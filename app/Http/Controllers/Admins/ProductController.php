<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Admins\Product;
use App\Models\Admins\Category;
use App\Models\Admins\CategoryCondition;
use App\Models\Format;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\SvgWriter;

class ProductController extends Controller
{
    public function getProducts(Request $request)
    {
        $query = Product::select('products.*');
        // ->orderBy('products.id', 'DESC');
        if (request()->has('order')) {
            $columnIndex = request('order')[0]['column']; // Get index of column being sorted
            $columnName = request('columns')[$columnIndex]['name']; // Get column name
            $columnSortOrder = request('order')[0]['dir']; // Sorting direction (asc/desc)

            // Ensure sorting is only applied to database fields
            $sortableColumns = ['id', 'product_name', 'sort_order', 'format_id', 'discount_price', 'product_quantity', 'view', 'status'];

            if (in_array($columnName, $sortableColumns)) {
                $query->orderBy("products.$columnName", $columnSortOrder);
            } else {
                $query->orderBy('products.id', 'DESC'); // Fallback sorting
            }
        } else {
            $query->orderBy('products.id', 'DESC');
        }

        // Search Filter
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('product_name', 'ILIKE', '%' . $search . '%')
                    ->orWhere('sku', 'ILIKE', '%' . $search . '%')
                    ->orWhere('sku_no', 'ILIKE', '%' . $search . '%');
            });
        }

        // Article Numbers Filter (separate field)
        if ($request->has('article_numbers') && !empty($request->article_numbers)) {
            $articleNumbers = array_map(fn($item) => trim($item), explode(',', $request->article_numbers));
            $query->where(function ($q) use ($articleNumbers) {
                foreach ($articleNumbers as $articleNumber) {
                    $q->orWhere('article_number', 'ILIKE', '%' . $articleNumber . '%');
                }
            });
        }

        // Filter by Category (PostgreSQL Compatible)

        if ($request->has('category')) {
            $category_id = $request->category;
            $searchObj = CategoryCondition::where('category_id', $category_id)->select('type', 'condition', 'condition_value')->get();
            $categoryObj = Category::where('id', $category_id)->select('id', 'is_manual', 'is_condition')->first();
            // $query->whereRaw("? = ANY(string_to_array(category_id, ','))", [$category_id]);
        }
        if ($request->has('category') && !empty($request->category)) {
            if (isset($categoryObj->is_manual) && $categoryObj->is_manual == 2) {
                if ($searchObj->count() > 0) {
                    foreach ($searchObj as $key => $val) {
                        $method = $categoryObj->is_condition == 2 ? 'orWhere' : 'where';

                        if (trim($val->type) == 'Price') {

                            $query->$method('discount_price', $val->condition, intval($val->condition_value));
                        }

                        if (trim($val->type) == 'Format') {
                            $query->$method('format', $val->condition, intval($val->condition_value));
                        }

                        if (trim($val->type) == 'Tag') {
                            $conditionValues = explode(',', $val->condition_value);
                            $tagValues = array_map(fn($value) => str_replace(' ', '', trim($value)), $conditionValues);

                            foreach ($tagValues as $tag) {
                                $query->$method('tags', 'ILIKE', '%' . $tag . '%');
                            }
                        }

                        if (trim($val->type) == 'Title') {
                            $query->$method('product_name', $val->condition, $val->condition_value);
                        }

                        if (trim($val->type) == 'Products') {
                            if ($val->condition_value) {
                                $conditionValues = explode(',', $val->condition_value);
                                $query->whereIn('id', $conditionValues);
                            }
                        }

                        if (trim($val->type) == 'Made in') {
                            $query->$method('country', $val->condition, intval($val->condition_value));
                        }

                        if (trim($val->type) == 'Brand') {
                            $query->$method('brand_id', $val->condition, intval($val->condition_value));
                        }

                        if (trim($val->type) == 'Theme') {
                            $query->$method('theme_id', $val->condition, intval($val->condition_value));
                        }

                        if (trim($val->type) == 'Flavour') {
                            $query->$method('flavour_id', $val->condition, intval($val->condition_value));
                        }

                        if (trim($val->type) == 'Color') {
                            $query->$method('product_color', $val->condition, intval($val->condition_value));
                        }

                        if (trim($val->type) == 'Allergens') {
                            $query->$method('allergen', $val->condition, intval($val->condition_value));
                        }

                        if (trim($val->type) == 'Weight') {
                            $query->$method('weight', $val->condition, $val->condition_value);
                        }
                        if (trim($val->type) == 'Sku no') {
                            $query->$method('sku_no', $val->condition, $val->condition_value);
                        }
                    }
                }
            } else {
                if ($request->has('category') && !empty($request->category)) {
                    $query->whereRaw("? = ANY(string_to_array(products.category_id, ','))", [$request->category]);
                }
            }
        }



        // Filter by Format
        if ($request->has('format') && !empty($request->format)) {
            $query->where('products.format', $request->format);
        }

        // Filter by Status
        if ($request->has('status') && $request->status !== null && $request->status !== '') {
            $query->where('products.status', $request->status);
        }

        // Apply DataTables Formatting
        return DataTables::of($query)
            ->addColumn('checkbox', function ($product) {
                return '<input type="checkbox" class="product-checkbox" value="' . $product->id . '">';
            })
            ->addColumn('image', function ($product) {
                return '<img src="' . asset($product->image_one) . '" width="50">';
            })
            ->addColumn('sort_order', function ($product) {
                return '<input type="number" class="form-control sort-order-input"
                            data-id="' . $product->id . '"
                            value="' . ($product->sort_order ?? 0) . '"
                            style="width: 80px;">';
            })
            ->addColumn('category', function ($product) {
                // Convert category_id string to an array
                $categoryIds = explode(',', $product->category_id);
                $categories = Category::whereIn('id', $categoryIds)->pluck('name')->implode(', ');

                return $categories ?: 'N/A';
            })
            ->addColumn('format', function ($product) {
                return Format::where('id', $product->format)->value('name') ?? 'N/A';
            })
            ->addColumn('price', function ($product) {
                return '<span class="icon-aed">' . getSetting('currency') . '</span> ' . $product->discount_price;
            })
            ->addColumn('quantity', function ($product) {
                return $product->product_quantity;
            })
            ->addColumn('visits', function ($product) {
                return $product->view;
            })
            ->addColumn('status', function ($product) {
                $checked = $product->status == 1 ? 'checked' : '';
                return '
                <div class="switch">
                    <div class="onoffswitch">
                        <input type="checkbox" name="product_status"
                            data-id="' . $product->id . '"
                            ' . $checked . '
                            class="onoffswitch-checkbox"
                            id="example-' . $product->id . '">
                        <label class="onoffswitch-label"
                            for="example-' . $product->id . '">
                            <span class="onoffswitch-inner"></span>
                            <span class="onoffswitch-switch"></span>
                        </label>
                    </div>
                </div>';
            })
            ->addColumn('trending_products', function ($product) {
                $checked = $product->is_trending == 1 ? 'checked' : '';
                return '
                <div class="switch">
                    <div class="onoffswitch">
                        <input type="checkbox" name="is_trending"
                            data-id="' . $product->id . '"
                            ' . $checked . '
                            class="onoffswitch-checkbox"
                            id="example-trending-' . $product->id . '">
                        <label class="onoffswitch-label"
                            for="example-trending-' . $product->id . '">
                            <span class="onoffswitch-inner"></span>
                            <span class="onoffswitch-switch"></span>
                        </label>
                    </div>
                </div>';
            })
            ->addColumn('action', function ($product) {
                return '
                    <a href="' . route('admins.product_form', $product->id) . '" 
                       class="btn btn-success btn-sm">
                       <i class="fa fa-edit"></i>
                    </a>

                    <button id="genrate_label" data-id="' . $product->id . '" class="btn btn-info btn-sm">
                       <i class="fa fa-plus"></i>
                    </button>

                    <a data-href="' . route('admins.product_delete', ['id' => $product->id]) . '"
                       class="btn btn-danger btn-sm delete_record"
                       href="javascript:void(0)">
                       <i class="fa fa-times"></i>
                    </a>';
            })
            ->rawColumns(['image', 'sort_order', 'status', 'trending_products', 'action', 'price']) // Ensure correct HTML rendering
            ->make(true);
    }

    public function getProductDetails(Request $request, $product_id)
    {
        try {
            $product = Product::findOrFail($product_id);
            // Generate QR code server-side
            $productUrl = url('product/' . $product->slug);
            $qrCode = QrCode::create($productUrl)
                ->setSize(80)
                ->setMargin(0);

            $writer = new SvgWriter();
            $result = $writer->write($qrCode);
            $svgString = $result->getString();
            return response()->json([
                'success' => true,
                'product' => [
                    'product_name' => $product->product_name,
                    'name_ar' => $product->name_ar,
                    'image_one' => asset($product->image_one),
                    'ingredient' => $product->ingredient,
                    'ingredients_ar' => $product->ingredients_ar,
                    'country' => $product->country,
                    'slug' => $product->slug,
                    'item_no' => $product->sku_no ?? $product->product_code,
                    'vegan' => $product->vegan ?? 0,
                    'gelatin_free' => $product->gelatin_free ?? 0,
                    'lactose_free' => $product->lactose_free ?? 0,
                    'gluten_free' => $product->gluten_free ?? 0,
                    'palm_oil' => $product->palm_oil ?? 0,
                    'qr_code' => $svgString,
                    'article_number' => $product->article_number,
                    'sku_no' => $product->sku_no,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching product details'
            ], 500);
        }
    }

    public function getMultipleProductDetails(Request $request)
    {
        try {
            $productIds = $request->input('product_ids', []);

            if (empty($productIds)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No products selected'
                ], 400);
            }

            $products = Product::whereIn('id', $productIds)->get()->map(function ($product) {
                // Generate QR code for each product
                $productUrl = url('product/' . $product->slug);
                $qrCode = QrCode::create($productUrl)
                    ->setSize(80)
                    ->setMargin(0);

                $writer = new SvgWriter();
                $result = $writer->write($qrCode);
                $svgString = $result->getString();

                return [
                    'id' => $product->id,
                    'product_name' => $product->product_name,
                    'name_ar' => $product->name_ar,
                    'image_one' => asset($product->image_one),
                    'ingredient' => $product->ingredients ?? 'N/A',
                    'ingredients_ar' => $product->ingredients_ar ?? 'N/A',
                    'country' => $product->country ?? 'N/A',
                    'slug' => $product->slug,
                    'item_no' => $product->sku_no ?? $product->product_code,
                    'vegan' => $product->vegan ?? 0,
                    'gelatin_free' => $product->gelatin_free ?? 0,
                    'lactose_free' => $product->lactose_free ?? 0,
                    'gluten_free' => $product->gluten_free ?? 0,
                    'palm_oil' => $product->palm_oil ?? 0,
                    'qr_code' => $svgString,
                    'article_number' => $product->article_number,
                    'sku_no' => $product->sku_no,
                ];
            });

            if ($products->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No products found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'products' => $products
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching product details: ' . $e->getMessage()
            ], 500);
        }
    }

    public function inventoryReportData(Request $request)
    {
        $query = Product::query();

        return DataTables::of($query)
            ->addColumn('sku', fn($product) => $product->sku_no ?? $product->sku_no ?? 'N/A')
            ->addColumn('product_name', fn($product) => $product->product_name ?? 'N/A')
            ->addColumn('price', fn($product) => getSetting('currency') . ' ' . ($product->discount_price ?? 0))
            ->addColumn('product_quantity', fn($product) => $product->product_quantity ?? 0)
            ->addColumn('weight_per_unit', function ($product) {
                if ((int) $product->format === 1) {
                    $weight = $product->weight_per_unit ?? 0;
                    return '<input type="number" class="form-control form-control-sm weight-input" 
                    data-id="' . $product->id . '" 
                    value="' . $weight . '" 
                    style="width: 80px;" />';
                }
                return '--';
            })

            ->addColumn('total_weight', function ($product) {
                return ((int) $product->format === 1)
                    ? ((int) $product->product_quantity * 100) . ' g'
                    : '--';
            })
            ->addColumn('quantity_by_unit', function ($product) {
                if ((int) $product->format === 1) {
                    $totalWeight = (int) $product->product_quantity * 100;
                    $weightPerUnit = (float) $product->weight_per_unit;
                    $units = $weightPerUnit > 0 ? floor($totalWeight / $weightPerUnit) : 0;
                    return $units . ' units';
                }
                return '--';
            })
            ->rawColumns(['price', 'weight_per_unit', 'total_weight', 'quantity_by_unit'])
            ->make(true);
    }

    public function updateWeight(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'weight_per_unit' => 'nullable|numeric|min:0'
        ]);

        $product = Product::find($request->product_id);
        $product->weight_per_unit = $request->weight_per_unit;
        $product->save();

        return response()->json(['success' => true]);
    }
}
