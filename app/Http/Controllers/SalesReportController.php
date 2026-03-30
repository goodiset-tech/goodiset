<?php

namespace App\Http\Controllers;

use App\Models\Admins\Category;
use App\Models\Admins\Order;
use App\Models\Admins\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class SalesReportController extends Controller
{
    public function salesReportForm()
    {
        $categories = Category::all(); // Assuming Category model exists
        $products = Product::all();

        return view('admins.sales_report_form', compact('categories', 'products'));
    }


    public function salesReport()
    {
        // Fetch all products
        $products = Product::all()->keyBy('id');

        // Fetch all orders
        $orders = Order::where('dstatus', '!=', 3)->where('dstatus', '!=', 5)->whereNotNull('product_detail')
            ->whereNot(function ($query) {
                $query->where('payment_method', 'ngenius')
                    ->where('payment_status', 'pending');
            })->get();

        $salesData = [];

        foreach ($orders as $order) {
            $orderProducts = json_decode($order->product_detail, true);

            foreach ($orderProducts as $product) {
                $productId = $product['id'] ?? null;

                if ($productId && isset($products[$productId])) {
                    $categoryId = $products[$productId]->category_id;
                    $categoryName = 'Category ' . $categoryId; // Replace with actual category name if needed

                    if (!isset($salesData[$categoryId])) {
                        $salesData[$categoryId] = [
                            'category_name' => $categoryName,
                            'total_sales' => 0,
                            'total_quantity' => 0,
                            'products' => [],
                        ];
                    }

                    if (!isset($salesData[$categoryId]['products'][$productId])) {
                        $salesData[$categoryId]['products'][$productId] = [
                            'name' => $products[$productId]->name_sw,
                            'total_sales' => 0,
                            'total_quantity' => 0,
                        ];
                    }

                    $price = $product['price'] ?? $products[$productId]->discount_price;

                    // Update sales and quantity
                    $salesData[$categoryId]['total_sales'] += $price * $product['qty'];
                    $salesData[$categoryId]['total_quantity'] += $product['qty'];

                    $salesData[$categoryId]['products'][$productId]['total_sales'] += $products[$productId]->discount_price * $product['qty'];
                    $salesData[$categoryId]['products'][$productId]['total_quantity'] += $product['qty'];
                }
            }
        }

        return response()->json($salesData);
    }

    public function productSalesReport(Request $request)
    {
        $dateFilter = $request->input('date_filter', 'all');
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
        $exportAll = $request->input('export_all', false);
        $format = $request->input('format', null);

        // Define date ranges based on filter
        $dateRanges = [
            'today' => [Carbon::today(), Carbon::tomorrow()],
            'yesterday' => [Carbon::yesterday(), Carbon::today()],
            'this_week' => [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()],
            'last_week' => [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()],
            'this_month' => [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()],
            'last_month' => [Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()],
            'this_year' => [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()],
            'last_year' => [Carbon::now()->subYear()->startOfYear(), Carbon::now()->subYear()->endOfYear()],
        ];

        // Fetch all products
        $products = Product::all()->keyBy('id');

        // Fetch orders based on filter
        $ordersQuery = Order::where('dstatus', '!=', 3)
            ->where('dstatus', '!=', 5)
            ->whereNot(function ($query) {
                $query->where('payment_method', 'ngenius')
                    ->where('payment_status', 'pending');
            })
            ->whereNotNull('product_detail');

        // Apply date filter
        if ($dateFilter === 'custom' && $fromDate && $toDate) {
            $ordersQuery->whereBetween('created_at', [$fromDate, Carbon::parse($toDate)->endOfDay()]);
        } elseif ($dateFilter !== 'all' && isset($dateRanges[$dateFilter])) {
            $ordersQuery->whereBetween('created_at', $dateRanges[$dateFilter]);
        }

        $orders = $ordersQuery->get();
        $salesData = [];
        $grandTotals = [
            'total_sales' => 0.0,
            'total_quantity' => 0,
            'vat' => 0.0,
            'total_shipping' => 0.0,
            'total_discount' => 0.0,
        ];

        foreach ($orders as $order) {
            $orderProducts = json_decode($order->product_detail, true);
            if (!is_array($orderProducts)) {
                \Log::warning('Invalid product_detail for order ID: ' . $order->id);
                continue;
            }

            foreach ($orderProducts as $product) {
                $productId = $product['id'] ?? null;
                $qty = $product['qty'] ?? 0;

                if ($productId && isset($products[$productId])) {
                    if (!isset($salesData[$productId])) {
                        $salesData[$productId] = [
                            'name' => $products[$productId]->product_name ?? 'Unknown',
                            'total_sales' => 0.0,
                            'vat' => 0.0,
                            'total_quantity' => 0,
                            'avg_sale_price' => 0.0,
                        ];
                    }

                    $price = $product['price'] ?? $products[$productId]->discount_price ?? 0.0;
                    $subtotal = $price * $qty;

                    $salesData[$productId]['total_sales'] += $subtotal;
                    $salesData[$productId]['total_quantity'] += $qty;
                }
            }

            // Accumulate shipping and discount
            $grandTotals['total_shipping'] += floatval($order->shipping_fee ?? 0);
            $grandTotals['total_discount'] += floatval($order->discount ?? 0);
        }

        // Finalize sales data
        foreach ($salesData as &$data) {
            $data['vat'] = $data['total_sales'] * 0.05;
            $data['avg_sale_price'] = $data['total_quantity'] > 0 ? $data['total_sales'] / $data['total_quantity'] : 0.0;

            // Accumulate grand totals
            $grandTotals['total_sales'] += $data['total_sales'];
            $grandTotals['total_quantity'] += $data['total_quantity'];
            $grandTotals['vat'] += $data['vat'];

            // Format for display
            $data['total_sales'] = number_format($data['total_sales'], 2);
            $data['vat'] = number_format($data['vat'], 2);
            $data['avg_sale_price'] = number_format($data['avg_sale_price'], 2);
        }
        unset($data);

        // Format grand totals
        $grandTotals = [
            'total_sales' => number_format($grandTotals['total_sales'], 2),
            'total_quantity' => $grandTotals['total_quantity'],
            'vat' => number_format($grandTotals['vat'], 2),
            'total_shipping' => number_format($grandTotals['total_shipping'], 2),
            'total_discount' => number_format($grandTotals['total_discount'], 2),
        ];

        // Debug logs
        \Log::info('Product Sales Data Sample: ', array_slice($salesData, 0, 2));
        \Log::info('Product Sales Grand Totals: ', $grandTotals);

        // If export is requested, handle it here
        if ($exportAll && $format) {
            $dataCollection = collect($salesData);

            if ($format === 'csv') {
                return $this->exportToCsv($dataCollection);
            } elseif ($format === 'excel') {
                return $this->exportToExcel($dataCollection);
            } elseif ($format === 'pdf') {
                return $this->exportToPdf($dataCollection);
            }
        }

        return DataTables::of(collect($salesData))
            ->with('grandTotals', $grandTotals)
            ->make(true);
    }

    // Helper methods for export
    private function exportToCsv($data)
    {
        $filename = 'product_sales_report_' . now()->format('YmdHis') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($data) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Product Name', 'Total Sales (' . getSetting('currency') . ')', 'VAT 5% (' . getSetting('currency') . ')', 'Total Quantity Sold','Avg Sale Price  (' . getSetting('currency') . ')']);

            foreach ($data as $row) {
                fputcsv($file, [
                    $row['name'],
                    $row['total_sales'],
                    $row['vat'],
                    $row['total_quantity'],
                    $row['avg_sale_price'],
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function exportToExcel($data)
    {
        return Excel::download(new class($data) implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings {
            private $data;

            public function __construct($data)
            {
                $this->data = $data;
            }

            public function collection()
            {
                return $this->data->map(function ($item) {
                    return [
                        'Product Name' => $item['name'],
                        'Total Sales (' . getSetting('currency') . ')' => $item['total_sales'],
                        'VAT 5% (' . getSetting('currency') . ')' => $item['vat'],
                        'Total Quantity Sold' => $item['total_quantity'],
                        'Avg Sale Price  (' . getSetting('currency') . ')' => $item['total_sales'],
                    ];
                });
            }

            public function headings(): array
            {
                return ['Product Name', 'Total Sales (' . getSetting('currency') . ')', 'Total Quantity Sold'];
            }
        }, 'product_sales_report_' . now()->format('YmdHis') . '.xlsx');
    }

    private function exportToPdf($data)
    {
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admins.product_sales_pdf', ['salesData' => $data]);
        return $pdf->download('product_sales_report_' . now()->format('YmdHis') . '.pdf');
    }

    public function generalLedgerReport(Request $request)
    {
        $dateFilter = $request->input('date_filter', 'all');
        $statusFilter = $request->input('status_filter', 'all');
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');

        // Same date ranges as product sales report
        $dateRanges = [
            'today' => [Carbon::today(), Carbon::tomorrow()],
            'yesterday' => [Carbon::yesterday(), Carbon::today()],
            'this_week' => [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()],
            'last_week' => [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()],
            'this_month' => [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()],
            'last_month' => [Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()],
            'this_year' => [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()],
            'last_year' => [Carbon::now()->subYear()->startOfYear(), Carbon::now()->subYear()->endOfYear()],
        ];

        $query = Order::select([
            'id',
            'created_at',
            'payment_method',
            'payment_status',
            'dstatus',
            'amount',
            'order_no',
            'customer_name',
            'shipping_company'
        ]);

        // Apply date filter
        if ($dateFilter === 'custom' && $fromDate && $toDate) {
            $query->whereBetween('created_at', [$fromDate, Carbon::parse($toDate)->endOfDay()]);
        } elseif ($dateFilter !== 'all' && isset($dateRanges[$dateFilter])) {
            $query->whereBetween('created_at', $dateRanges[$dateFilter]);
        }

        // Apply status filter
        if ($statusFilter !== 'all') {
            if ($statusFilter === 'completed') {
                $query->where('dstatus', 1);
            } elseif ($statusFilter === 'canceled') {
                $query->where('dstatus', 3);
            } elseif ($statusFilter === 'delivered') {
                $query->where('dstatus', 2);
            } elseif ($statusFilter === 'dispatched') {
                $query->where('dstatus', 4);
            } elseif ($statusFilter === 'pending') {
                $query->where('dstatus', 0);
            }
        }

        $transactions = $query->orderBy('created_at', 'desc')->get();

        $ledgerData = $transactions->map(function ($transaction) {
            $type = '';
            if ($transaction->dstatus == 1) {
                $type = "Completed";
            } elseif ($transaction->dstatus == 3) {
                $type = "Cancel";
            } elseif ($transaction->dstatus == 2) {
                $type = "Delivered";
            } elseif ($transaction->dstatus == 4) {
                $type = "Dispatched";
            } elseif ($transaction->dstatus == 0) {
                $type = "Pending";
            }
            return [
                'date' => $transaction->created_at->format('Y-m-d H:i:s'),
                'order_no' => $transaction->order_no,
                'customer' => $transaction->customer_name,
                'type' => $type,
                'shipping_method' => !empty($transaction->shipping_company) ? $transaction->shipping_company : 'N/A',
                'payment_method' => ucfirst($transaction->payment_method) ?? 'N/A',
                'vat' => $transaction->amount * 0.05,
                'discount' => $transaction->discount ?? 0,
                'shipping' => $transaction->shipping_fee ?? 0,
                'amount' => $transaction->amount ?? 0,
                'status' => (function () use ($transaction, $type) {
                    if ($transaction->payment_status == 'pending') {
                        return 'Unpaid';
                    } elseif (
                        $type === 'Cancel' && $transaction->payment_method == 'stripe' || $transaction->payment_method == 'Card'
                        || $transaction->payment_method == 'express_checkout' ||  $transaction->payment_method === 'Google Pay'
                        ||  $transaction->payment_method == 'Apple Pay'
                    ) {
                        return 'Refunded';
                    } else {
                        return ucfirst($transaction->payment_status ?? 'unknown');
                    }
                })(),
            ];
        });

        return DataTables::of($ledgerData)->make(true);
    }

    public function categorySalesReport(Request $request)
    {
        $dateFilter = $request->input('date_filter', 'all');
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');

        // Define date ranges based on filter
        $dateRanges = [
            'today' => [Carbon::today(), Carbon::tomorrow()],
            'yesterday' => [Carbon::yesterday(), Carbon::today()],
            'this_week' => [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()],
            'last_week' => [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()],
            'this_month' => [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()],
            'last_month' => [Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()],
            'this_year' => [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()],
            'last_year' => [Carbon::now()->subYear()->startOfYear(), Carbon::now()->subYear()->endOfYear()],
        ];

        $products = Product::all()->keyBy('id');
        $ordersQuery = Order::where('dstatus', '!=', 3)
            ->where('dstatus', '!=', 5)
            ->whereNot(function ($query) {
                $query->where('payment_method', 'ngenius')
                    ->where('payment_status', 'pending');
            })
            ->whereNotNull('product_detail');

        // Apply date filtering
        if ($dateFilter === 'custom' && $fromDate && $toDate) {
            $ordersQuery->whereBetween('created_at', [$fromDate, Carbon::parse($toDate)->endOfDay()]);
        } elseif ($dateFilter !== 'all' && isset($dateRanges[$dateFilter])) {
            $ordersQuery->whereBetween('created_at', $dateRanges[$dateFilter]);
        }

        $orders = $ordersQuery->get();
        $categories = Category::all()->keyBy('id');

        $salesData = [];
        $grandTotals = [
            'total_sales' => 0.0,
            'total_quantity' => 0,
            'vat' => 0.0,
            'total_shipping' => 0.0,
            'total_discount' => 0.0,
        ];

        foreach ($orders as $order) {
            $orderProducts = json_decode($order->product_detail, true);
            if (!is_array($orderProducts)) {
                \Log::warning('Invalid product_detail for order ID: ' . $order->id);
                continue;
            }

            foreach ($orderProducts as $product) {
                $productId = $product['id'] ?? null;
                $qty = $product['qty'] ?? 0;

                if ($productId && isset($products[$productId])) {
                    $categoryIds = explode(',', $products[$productId]->category_id);
                    $primaryCategoryId = trim($categoryIds[0] ?? '');

                    if ($primaryCategoryId && isset($categories[$primaryCategoryId])) {
                        if (!isset($salesData[$primaryCategoryId])) {
                            $salesData[$primaryCategoryId] = [
                                'category_name' => $categories[$primaryCategoryId]->name ?? 'Unknown',
                                'total_sales' => 0.0,
                                'total_quantity' => 0,
                                'vat' => 0.0,
                                'avg_sale_price' => 0.0,
                            ];
                        }

                        $price = $product['price'] ?? $products[$productId]->discount_price ?? 0.0;
                        $totalSale = $price * $qty;

                        $salesData[$primaryCategoryId]['total_sales'] += $totalSale;
                        $salesData[$primaryCategoryId]['total_quantity'] += $qty;
                    }
                }
            }

            // Accumulate shipping and discount
            $shipping = floatval($order->shipping_fee ?? 0);
            $discount = floatval($order->discount ?? 0);
            $grandTotals['total_shipping'] += $shipping;
            $grandTotals['total_discount'] += $discount;
        }

        // Finalize sales data
        foreach ($salesData as &$data) {
            $data['vat'] = $data['total_sales'] * 0.05;
            $data['avg_sale_price'] = $data['total_quantity'] > 0 ? $data['total_sales'] / $data['total_quantity'] : 0.0;

            // Accumulate grand totals
            $grandTotals['total_sales'] += $data['total_sales'];
            $grandTotals['total_quantity'] += $data['total_quantity'];
            $grandTotals['vat'] += $data['vat'];

            // Format for display
            $data['total_sales'] = number_format($data['total_sales'], 2);
            $data['vat'] = number_format($data['vat'], 2);
            $data['avg_sale_price'] = number_format($data['avg_sale_price'], 2);
        }
        unset($data);

        // Format grand totals
        $grandTotals = [
            'total_sales' => number_format($grandTotals['total_sales'], 2),
            'total_quantity' => $grandTotals['total_quantity'],
            'vat' => number_format($grandTotals['vat'], 2),
            'total_shipping' => number_format($grandTotals['total_shipping'], 2),
            'total_discount' => number_format($grandTotals['total_discount'], 2),
        ];

        // Debug logs
        \Log::info('Sales Data Sample: ', array_slice($salesData, 0, 2));
        \Log::info('Grand Totals: ', $grandTotals);

        return DataTables::of(collect($salesData))
            ->with('grandTotals', $grandTotals)
            ->make(true);
    }

    public function monthlySalesReport()
    {
        $orders = Order::where('dstatus', '!=', 3)
            ->where('dstatus', '!=', 5)
            ->whereNotNull('product_detail')
            ->whereNot(function ($query) {
                $query->where('payment_method', 'ngenius')
                    ->where('payment_status', 'pending');
            })
            ->selectRaw('EXTRACT(MONTH FROM created_at) as month')
            ->selectRaw('EXTRACT(YEAR FROM created_at) as year')
            ->selectRaw('COUNT(*) as order_count')
            ->selectRaw('SUM(CASE WHEN json_typeof(product_detail::json) = \'array\' THEN json_array_length(product_detail::json) ELSE 0 END) as items_sold')
            ->selectRaw('SUM(amount::numeric) as total_amount')
            ->selectRaw('SUM(COALESCE(discount::numeric, 0)) as total_discount')
            ->selectRaw('SUM(shipping_fee::numeric) as total_shipping')
            ->selectRaw('SUM(CASE WHEN payment_method IN (\'stripe\', \'Card\') THEN amount::numeric ELSE 0 END) as stripe_amount')
            ->selectRaw('SUM(CASE WHEN payment_method = \'Apple pay\' THEN amount::numeric ELSE 0 END) as apple_pay_amount')
            ->selectRaw('SUM(CASE WHEN payment_method = \'Google Pay\' THEN amount::numeric ELSE 0 END) as google_pay_amount')
            ->selectRaw('SUM(CASE WHEN payment_method = \'cash_on_delivery\' THEN amount::numeric ELSE 0 END) as cod_amount')
            ->selectRaw('SUM(CASE WHEN payment_method = \'express_checkout\' THEN amount::numeric ELSE 0 END) as express_checkout_amount')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        $monthlyData = [];
        $srNo = 1;
        $grandTotals = [
            'order_count' => 0,
            'items_sold' => 0,
            'total_amount' => 0,
            'total_vat' => 0,
            'total_discount' => 0,
            'total_shipping' => 0,
            'stripe_amount' => 0,
            'apple_pay_amount' => 0,
            'google_pay_amount' => 0,
            'cod_amount' => 0,
            'express_checkout_amount' => 0,
        ];

        foreach ($orders as $order) {
            $vat = ($order->total_amount ?? 0) * 0.05; // VAT is 5% of total_amount

            $monthName = date('F', mktime(0, 0, 0, $order->month, 1));
            $monthlyData[] = [
                'sr_no' => $srNo++,
                'year' => $order->year,
                'month_num' => $order->month,
                'month' => $monthName . ' ' . $order->year,
                'order_count' => $order->order_count,
                'items_sold' => $order->items_sold,
                'total_amount' => number_format($order->total_amount ?? 0, 2),
                'total_vat' => number_format($vat, 2),
                'total_discount' => number_format($order->total_discount ?? 0, 2),
                'total_shipping' => number_format($order->total_shipping ?? 0, 2),
                'stripe_amount' => number_format($order->stripe_amount ?? 0, 2),
                'apple_pay_amount' => number_format($order->apple_pay_amount ?? 0, 2),
                'google_pay_amount' => number_format($order->google_pay_amount ?? 0, 2),
                'cod_amount' => number_format($order->cod_amount ?? 0, 2),
                'express_checkout_amount' => number_format($order->express_checkout_amount ?? 0, 2),
            ];

            // Accumulate grand totals
            $grandTotals['order_count'] += $order->order_count ?? 0;
            $grandTotals['items_sold'] += $order->items_sold ?? 0;
            $grandTotals['total_amount'] += $order->total_amount ?? 0;
            $grandTotals['total_vat'] += $vat;
            $grandTotals['total_discount'] += $order->total_discount ?? 0;
            $grandTotals['total_shipping'] += $order->total_shipping ?? 0;
            $grandTotals['stripe_amount'] += $order->stripe_amount ?? 0;
            $grandTotals['apple_pay_amount'] += $order->apple_pay_amount ?? 0;
            $grandTotals['google_pay_amount'] += $order->google_pay_amount ?? 0;
            $grandTotals['cod_amount'] += $order->cod_amount ?? 0;
            $grandTotals['express_checkout_amount'] += $order->express_checkout_amount ?? 0;
        }

        // Format grand totals
        $grandTotals = [
            'order_count' => $grandTotals['order_count'],
            'items_sold' => $grandTotals['items_sold'],
            'total_amount' => number_format($grandTotals['total_amount'], 2),
            'total_vat' => number_format($grandTotals['total_vat'], 2),
            'total_discount' => number_format($grandTotals['total_discount'], 2),
            'total_shipping' => number_format($grandTotals['total_shipping'], 2),
            'stripe_amount' => number_format($grandTotals['stripe_amount'], 2),
            'apple_pay_amount' => number_format($grandTotals['apple_pay_amount'], 2),
            'google_pay_amount' => number_format($grandTotals['google_pay_amount'], 2),
            'cod_amount' => number_format($grandTotals['cod_amount'], 2),
            'express_checkout_amount' => number_format($grandTotals['express_checkout_amount'], 2),
        ];

        // Sort the collection by year and month_num
        $sortedData = collect($monthlyData)->sortByDesc(function ($item) {
            return [$item['year'], $item['month_num']];
        })->values();

        return DataTables::of($sortedData)
            ->with('grandTotals', $grandTotals)
            ->make(true);
    }

    public function monthlyOdooReport()
    {
        // Fetch orders with product details, grouped by month and year
        $orders = Order::where('dstatus', '!=', 3)
            ->where('dstatus', '!=', 5)
            ->whereNotNull('product_detail')
            ->whereNot(function ($query) {
                $query->where('payment_method', 'ngenius')
                    ->where('payment_status', 'pending');
            })
            ->selectRaw('EXTRACT(MONTH FROM created_at) as month')
            ->selectRaw('EXTRACT(YEAR FROM created_at) as year')
            ->selectRaw('SUM(amount::numeric + COALESCE(discount::numeric, 0)) as total_amount')
            ->selectRaw('SUM(amount::numeric) as total_amount_after_discount')
            ->selectRaw('SUM(amount::numeric) as total_collected')
            ->selectRaw('SUM(discount::numeric) as total_discount')
            ->selectRaw('SUM(shipping_fee::numeric) as total_shipping')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        $monthlyData = [];
        $srNo = 1;
        $grandTotals = [
            'total_amount' => 0,
            'total_amount_after_discount' => 0,
            'total_collected' => 0,
            'total_vat' => 0,
            'vat_on_items' => 0, // New Grand Total Field
            'total_discount' => 0,
            'total_shipping' => 0,
            'items_sold' => 0,
            'item_total_with_discount' => 0,
            'item_total_without_discount' => 0,
        ];

        foreach ($orders as $order) {
            // Calculate VAT as 5% of total_amount
            $vat = ($order->total_amount ?? 0) * 0.05;

            // Fetch orders for this month/year to process product details
            $monthOrders = Order::where('dstatus', '!=', 3)
                ->where('dstatus', '!=', 5)
                ->whereNotNull('product_detail')
                ->whereNot(function ($query) {
                    $query->where('payment_method', 'ngenius')
                        ->where('payment_status', 'pending');
                })
                ->whereRaw('EXTRACT(MONTH FROM created_at) = ?', [$order->month])
                ->whereRaw('EXTRACT(YEAR FROM created_at) = ?', [$order->year])
                ->get();

            $itemsSold = 0;
            $itemTotalWithDiscount = 0;
            $itemTotalWithoutDiscount = 0;

            foreach ($monthOrders as $monthOrder) {
                $orderProducts = json_decode($monthOrder->product_detail, true);
                if (!is_array($orderProducts)) {
                    \Log::warning('Invalid product_detail for order ID: ' . $monthOrder->id);
                    continue;
                }

                foreach ($orderProducts as $product) {
                    $qty = $product['qty'] ?? 0;
                    $price = $product['price'] ?? 0;
                    $discount = $product['discount'] ?? 0;

                    $itemsSold += $qty;
                    $itemTotalWithoutDiscount += $qty * $price;
                    $itemTotalWithDiscount += $qty * ($price - $discount);
                }
            }

            // Calculate VAT on Items (5% of itemTotalWithDiscount)
            $vatOnItems = $itemTotalWithDiscount * 0.05;

            $monthName = date('F', mktime(0, 0, 0, $order->month, 1));
            $monthlyData[] = [
                'sr_no' => $srNo++,
                'year' => $order->year,
                'month_num' => $order->month,
                'month' => $monthName . ' ' . $order->year,
                'total_amount' => number_format($order->total_amount ?? 0, 2),
                'total_amount_after_discount' => number_format($order->total_amount_after_discount ?? 0, 2),
                'total_collected' => number_format($order->total_collected ?? 0, 2),
                'total_vat' => number_format($vat, 2),
                'vat_on_items' => number_format($vatOnItems, 2), // New Field
                'total_discount' => number_format($order->total_discount ?? 0, 2),
                'total_shipping' => number_format($order->total_shipping ?? 0, 2),
                'items_sold' => $itemsSold,
                'item_total_with_discount' => number_format($itemTotalWithDiscount, 2),
                'item_total_without_discount' => number_format($itemTotalWithoutDiscount, 2),
            ];

            // Accumulate grand totals
            $grandTotals['total_amount'] += $order->total_amount ?? 0;
            $grandTotals['total_amount_after_discount'] += $order->total_amount_after_discount ?? 0;
            $grandTotals['total_collected'] += $order->total_collected ?? 0;
            $grandTotals['total_vat'] += $vat;
            $grandTotals['vat_on_items'] += $vatOnItems; // Accumulate New Field
            $grandTotals['total_discount'] += $order->total_discount ?? 0;
            $grandTotals['total_shipping'] += $order->total_shipping ?? 0;
            $grandTotals['items_sold'] += $itemsSold;
            $grandTotals['item_total_with_discount'] += $itemTotalWithDiscount;
            $grandTotals['item_total_without_discount'] += $itemTotalWithoutDiscount;
        }

        // Format grand totals
        $grandTotals = [
            'total_amount' => number_format($grandTotals['total_amount'], 2),
            'total_amount_after_discount' => number_format($grandTotals['total_amount_after_discount'], 2),
            'total_collected' => number_format($grandTotals['total_collected'], 2),
            'total_vat' => number_format($grandTotals['total_vat'], 2),
            'vat_on_items' => number_format($grandTotals['vat_on_items'], 2), // New Field
            'total_discount' => number_format($grandTotals['total_discount'], 2),
            'total_shipping' => number_format($grandTotals['total_shipping'], 2),
            'items_sold' => $grandTotals['items_sold'],
            'item_total_with_discount' => number_format($grandTotals['item_total_with_discount'], 2),
            'item_total_without_discount' => number_format($grandTotals['item_total_without_discount'], 2),
        ];

        // Sort the collection by year and month_num
        $sortedData = collect($monthlyData)->sortByDesc(function ($item) {
            return [$item['year'], $item['month_num']];
        })->values();

        return DataTables::of($sortedData)
            ->with('grandTotals', $grandTotals)
            ->make(true);
    }

    public function vatReport(Request $request)
    {
        $dateFilter = $request->input('date_filter', 'all');
        $statusFilter = $request->input('status_filter', 'all');
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');

        $dateRanges = [
            'today' => [Carbon::today(), Carbon::tomorrow()],
            'yesterday' => [Carbon::yesterday(), Carbon::today()],
            'this_week' => [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()],
            'last_week' => [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()],
            'this_month' => [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()],
            'last_month' => [Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()],
            'this_year' => [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()],
            'last_year' => [Carbon::now()->subYear()->startOfYear(), Carbon::now()->subYear()->endOfYear()],
        ];

        $query = Order::select([
            'order_no',
            'amount',
            'shipping_fee',
            'discount',
            'created_at',
            'dstatus'
        ]);

        // Apply date filter
        if ($dateFilter === 'custom' && $fromDate && $toDate) {
            $query->whereBetween('created_at', [$fromDate, Carbon::parse($toDate)->endOfDay()]);
        } elseif ($dateFilter !== 'all' && isset($dateRanges[$dateFilter])) {
            $query->whereBetween('created_at', $dateRanges[$dateFilter]);
        }

        // Apply status filter
        if ($statusFilter !== 'all') {
            if ($statusFilter === 'completed') {
                $query->where('dstatus', 1);
            } elseif ($statusFilter === 'canceled') {
                $query->where('dstatus', 3);
            } elseif ($statusFilter === 'delivered') {
                $query->where('dstatus', 2);
            } elseif ($statusFilter === 'dispatched') {
                $query->where('dstatus', 4);
            } elseif ($statusFilter === 'pending') {
                $query->where('dstatus', 0);
            }
        }

        $transactions = $query->orderBy('created_at', 'desc')->get();

        $vatData = $transactions->map(function ($transaction) {
            $invoiceTotal = $transaction->amount ?? 0;
            $vatAmount = $invoiceTotal * 0.05; // 5% VAT
            $amountExcludingVat = $invoiceTotal - $vatAmount;

            return [
                'invoice_no' => $transaction->order_no,
                'invoice_total' => $invoiceTotal,
                'vat_amount' => number_format($vatAmount, 2),
                'shipping_amount' => $transaction->shipping_fee ?? 0,
                'discount_amount' => $transaction->discount ?? 0,
                'amount_excluding_vat' => number_format($amountExcludingVat, 2),
            ];
        });

        return DataTables::of($vatData)->make(true);
    }

    public function productSalesView(Request $request)
    {
        $dateFilter = $request->input('date_filter', 'all');
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
        return view('admins.product_sales_report', compact('dateFilter', 'fromDate', 'toDate'));
    }
    public function categorySalesView(Request $request)
    {
        $dateFilter = $request->input('date_filter', 'all');
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
        return view('admins.category_sales_report', compact('dateFilter', 'fromDate', 'toDate'));
    }

    public function generalLedgerReportView(Request $request)
    {
        $dateFilter = $request->input('date_filter', 'all');
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
        $statusFilter  = $request->input('status_filter', 'all');
        return view('admins.general_ledger', compact('dateFilter', 'statusFilter', 'fromDate', 'toDate'));
    }
    public function vatReportView(Request $request)
    {
        $dateFilter = $request->input('date_filter', 'all');
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
        $statusFilter  = $request->input('status_filter', 'all');
        return view('admins.vat_report', compact('dateFilter', 'statusFilter', 'fromDate', 'toDate'));
    }
    public function showMonthlySalesReport(Request $request)
    {
        $dateFilter = $request->input('date_filter', 'all');
        $statusFilter  = $request->input('status_filter', 'all');
        return view('admins.monthly-sales-report', compact('dateFilter', 'statusFilter'));
    }
    public function showMonthlyOdooReport(Request $request)
    {
        $dateFilter = $request->input('date_filter', 'all');
        $statusFilter = $request->input('status_filter', 'all');
        return view('admins.monthly-odoo-report', compact('dateFilter', 'statusFilter'));
    }
}
