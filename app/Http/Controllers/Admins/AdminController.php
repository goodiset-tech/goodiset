<?php

namespace App\Http\Controllers\Admins;

use App\Exports\ProductsExport;
use App\Http\Controllers\Controller;
use App\Models\Admins\Admin;
use App\Models\Admins\Blog_Category;
use App\Models\Admins\Blog_Post;
use App\Models\Admins\Brand;
use App\Models\Admins\BrandToMeta;
use App\Models\Admins\CategoriesToMeta;
use App\Models\Admins\Category;
use App\Models\Admins\CategoryCondition;
use App\Models\Admins\Colors;
use App\Models\Admins\Contact;
use App\Models\Admins\Coupon;
use App\Models\Admins\Faq;
use App\Models\Admins\Gallerie;
use App\Models\Admins\Learn_setting;
use App\Models\Admins\LogReport;
use App\Models\Admins\Media;
use App\Models\Admins\Order;
use App\Models\Admins\Pages;
use App\Models\Admins\Product;
use App\Models\Admins\ProductsToMeta;
use App\Models\Admins\Rating;
use App\Models\Admins\Setting;
use App\Models\Admins\Shap;
use App\Models\Admins\Size;
use App\Models\Admins\Slider;
use App\Models\Admins\PromotionalBanner;
use App\Models\Admins\SubCategory;
use App\Models\Allergen;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\BasketType;
use App\Models\BoxCustomize;
use App\Models\BoxSize;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Customer;
use App\Models\Flavour;
use App\Models\Format;
use App\Models\Ingredient;
use App\Models\Newsletter;
use App\Models\PackageType;
use App\Models\ProductSlugRedirect;
use App\Models\ProductType;
use App\Models\ProductVariation;
use App\Models\Shape;
use App\Models\ShippingMethod;
use App\Models\Theme;
use App\Models\TopAnnouncementBar;
use App\Models\Type;
use App\Models\Vat;
use App\Models\Visitor;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;
use Mail;
use Session;
use Stripe\Stripe;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Stripe\Exception\ApiErrorException;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\File;

/**
 * Class AdminController
 * 
 * Handles administrative functionalities such as dashboard analytics, 
 * category management, order processing, and system settings.
 * 
 * @package App\Http\Controllers\Admins
 */
class AdminController extends Controller
{

    /**
     * Show the admin login page.
     * 
     * @return \Illuminate\View\View
     */
    public function adminloginpage()
    {
        return view('admins.login');
    }

    // function admin_login_submit(Request $req)
    // {
    //     $user = Admin::where(['email' => $req->email])->first();
    //     $data = Admin::all();
    //     if ($user) {

    //         if (Hash::check($req->password, $user->password)) {
    //             $req->session()->flash('invalid', 'Success');
    //             $req->session()->put('admin', $user);
    //             return redirect('admin/dashboard');
    //         } else {

    //             // return "password not matched";
    //             $req->session()->flash('invalid', 'Enter Your Correct Password');
    //             return view('admins.login');
    //         }
    //     } else {
    //         $req->session()->flash('invalid', 'Invalid Email & Password');
    //         return view('admins.login');
    //     }
    // }
    /**
     * Handle admin login submission.
     * 
     * @param Request $req
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function admin_login_submit(Request $req)
    {
        $credentials = $req->only('email', 'password');
        //dd($credentials);
        if (Auth::guard('admin')->attempt($credentials)) {
            $req->session()->flash('success', 'Login Successful');

            $data = [
                'type' => 'USER',
                'type_id' => Auth::guard('admin')->user()->id,
                'message' => 'The User:<b>' . Auth::guard('admin')->user()->name . '</b> has been logged in at:<b>' . date('F j, Y H:i:s A') . '</b>',
                'user_id' => Auth::guard('admin')->user()->id,
                'ip_address' => $_SERVER['REMOTE_ADDR'] ?? request()->ip(),
                'url' => request()->fullUrl(),
                'method' => request()->method(),
                'changes' => "",
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $logs = new LogReport();
            $logs->addLog($data);
            return redirect()->back()->with([
                'msg' => 'Admin Login Successfully',
                'msg_type' => 'success'
            ]);
        } else {
            $req->session()->flash('invalid', 'Invalid Email or Password');
            return view('admins.login');
        }
    }

    public function admin()
    {
        $edit = Admin::all();
        return view('admins.admin', compact('edit'));
    }

    public function update_admin(Request $req)
    {
        $email = $req->email;
        $pass = Hash::make($req->pass);
        $data = array(
            'email' => $email,
            'password' => $pass,
        );
        $up = DB::table('admins')->where('id', $req->id)->update($data);
        if ($up) {
            return redirect(route('admins.admin'))->with([
                'msg' => 'Admin updated Successfully',
                'msg_type' => 'success',
            ]);
        } else {
            return redirect(route('admins.admin'))->with([
                'msg' => 'Please Try Again!',
                'msg_type' => 'success',
            ]);
        }
    }

    public function logout(Request $req)
    {
        Auth::guard('admin')->logout();
        return redirect('admin/login');
        // if ($req->session()->has('admin')) {
        //     $req->session()->pull('admin');
        //     return redirect('admin/login');
        // }
    }

    public function getOrderStatus($status)
    {
        $statusArray = [
            0 => 'Pending',
            1 => 'Confirmed',
            2 => 'Delivered',
            3 => 'Cancel',
            4 => 'Dispatched',
        ];
        return $statusArray[$status] ?? 'Unknown Status';
    }

    /**
     * Display the admin dashboard with various analytics and filters.
     * 
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function dashboard(Request $request)
    {
        $categories = Category::all();
        $products = Product::all();
        $rating = Rating::all();

        $dateFilter = $request->input('date_filter', 'this_week');
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');

        $visitorQuery = Visitor::query();
        $orderQuery = Order::query();

        // Determine date range for graphs
        $startDate = Carbon::now()->subDays(15); // Default to last 15 days
        $endDate = Carbon::now();

        switch ($dateFilter) {
            case 'today':
                $visitorQuery->whereBetween('visit_date', [Carbon::today()->startOfDay(), Carbon::now()]);
                $orderQuery->whereBetween('created_at', [Carbon::today()->startOfDay(), Carbon::now()]);
                $startDate = Carbon::today()->startOfDay();
                $endDate = Carbon::now();
                break;
            case 'yesterday':
                $visitorQuery->whereDate('visit_date', Carbon::yesterday());
                $orderQuery->whereDate('created_at', Carbon::yesterday());
                $startDate = Carbon::yesterday()->startOfDay();
                $endDate = Carbon::yesterday()->endOfDay();
                break;
            case 'this_week':
                $visitorQuery->whereBetween('visit_date', [Carbon::now()->startOfWeek(), Carbon::now()]);
                $orderQuery->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()]);
                $startDate = Carbon::now()->startOfWeek();
                $endDate = Carbon::now();
                break;
            case 'last_week':
                $visitorQuery->whereBetween('visit_date', [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()]);
                $orderQuery->whereBetween('created_at', [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()]);
                $startDate = Carbon::now()->subWeek()->startOfWeek();
                $endDate = Carbon::now()->subWeek()->endOfWeek();
                break;
            case 'this_month':
                $visitorQuery->whereYear('visit_date', Carbon::now()->year)->whereMonth('visit_date', Carbon::now()->month);
                $orderQuery->whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->month);
                $startDate = Carbon::now()->startOfMonth();
                $endDate = Carbon::now();
                break;
            case 'last_month':
                $lastMonth = Carbon::now()->subMonth();
                $visitorQuery->whereYear('visit_date', $lastMonth->year)->whereMonth('visit_date', $lastMonth->month);
                $orderQuery->whereYear('created_at', $lastMonth->year)->whereMonth('created_at', $lastMonth->month);
                $startDate = Carbon::now()->subMonth()->startOfMonth();
                $endDate = Carbon::now()->subMonth()->endOfMonth();
                break;
            case 'this_year':
                $visitorQuery->whereYear('visit_date', Carbon::now()->year);
                $orderQuery->whereYear('created_at', Carbon::now()->year);
                $startDate = Carbon::now()->startOfYear();
                $endDate = Carbon::now();
                break;
            case 'last_year':
                $visitorQuery->whereYear('visit_date', Carbon::now()->subYear()->year);
                $orderQuery->whereYear('created_at', Carbon::now()->subYear()->year);
                $startDate = Carbon::now()->subYear()->startOfYear();
                $endDate = Carbon::now()->subYear()->endOfYear();
                break;
            case 'custom':
                if ($fromDate && $toDate) {
                    $from = Carbon::parse($fromDate)->startOfDay();
                    $to = Carbon::parse($toDate)->endOfDay();
                    $visitorQuery->whereBetween('visit_date', [$from, $to]);
                    $orderQuery->whereBetween('created_at', [$from, $to]);
                    $startDate = $from;
                    $endDate = $to;
                }
                break;
            case 'all':
                $startDate = Carbon::parse(Order::min('created_at')) ?? Carbon::now()->subYear();
                $endDate = Carbon::now();
                break;
            default:
                $startDate = Carbon::now()->subDays(15);
                $endDate = Carbon::now();
                break;
        }

        $totalVisitors = $visitorQuery->sum('visitors');

        $visitors = Visitor::whereBetween('visit_date', [$startDate, $endDate])
            ->orderBy('visit_date', 'ASC')
            ->get();

        $visitorDates = $visitors->pluck('visit_date')->map(function ($date) {
            return Carbon::parse($date)->format('m/d/Y');
        });

        $visitorCounts = $visitors->pluck('visitors');

        // Order data for graphs
        $orders = Order::whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'ASC')
            ->get();

        // Generate date range for graph
        $orderDates = [];
        $currentDate = $startDate->copy();
        while ($currentDate <= $endDate) {
            $orderDates[] = $currentDate->format('m/d/Y');
            $currentDate->addDay();
        }

        // Initialize arrays for order counts and values
        $pendingOrderCounts = array_fill(0, count($orderDates), 0);
        $confirmedOrderCounts = array_fill(0, count($orderDates), 0);
        $dispatchedOrderCounts = array_fill(0, count($orderDates), 0);
        $deliveredOrderCounts = array_fill(0, count($orderDates), 0);
        $canceledOrderCounts = array_fill(0, count($orderDates), 0);

        $pendingOrderValues = array_fill(0, count($orderDates), 0);
        $confirmedOrderValues = array_fill(0, count($orderDates), 0);
        $dispatchedOrderValues = array_fill(0, count($orderDates), 0);
        $deliveredOrderValues = array_fill(0, count($orderDates), 0);
        $canceledOrderValues = array_fill(0, count($orderDates), 0);

        // Aggregate order data by date
        foreach ($orders as $order) {
            $orderDate = Carbon::parse($order->created_at)->format('m/d/Y');
            $index = array_search($orderDate, $orderDates);

            if ($index !== false) {
                switch ($order->dstatus) {
                    case '0':
                        if ($order->payment_method !== 'ngenius' || $order->payment_status !== 'pending') {
                            $pendingOrderCounts[$index]++;
                            $pendingOrderValues[$index] += $order->amount ?? 0;
                        }
                        break;
                    case '1':
                        $confirmedOrderCounts[$index]++;
                        $confirmedOrderValues[$index] += $order->amount ?? 0;
                        break;
                    case '2':
                        $deliveredOrderCounts[$index]++;
                        $deliveredOrderValues[$index] += $order->amount ?? 0;
                        break;
                    case '3':
                        $canceledOrderCounts[$index]++;
                        $canceledOrderValues[$index] += $order->amount ?? 0;
                        break;
                    case '4':
                        $dispatchedOrderCounts[$index]++;
                        $dispatchedOrderValues[$index] += $order->amount ?? 0;
                        break;
                }
            }
        }

        // Total order counts and values
        $totalOrderCounts = array_map(function ($a, $b, $c, $d, $e) {
            return $a + $b + $c + $d + $e;
        }, $pendingOrderCounts, $confirmedOrderCounts, $dispatchedOrderCounts, $deliveredOrderCounts, $canceledOrderCounts);

        $totalOrderValues = array_map(function ($a, $b, $c, $d, $e) {
            return $a + $b + $c + $d + $e;
        }, $pendingOrderValues, $confirmedOrderValues, $dispatchedOrderValues, $deliveredOrderValues, $canceledOrderValues);

        $pending_orders = clone $orderQuery;
        $pending_orders = $pending_orders->where('dstatus', '0')
            ->whereNot(function ($query) {
                $query->where('payment_method', 'ngenius')
                    ->where('payment_status', 'pending');
            })
            ->get();

        $com_orders = clone $orderQuery;
        $com_orders = $com_orders->where('dstatus', '1')->get();

        $del_orders = clone $orderQuery;
        $del_orders = $del_orders->where('dstatus', '2')->get();

        $can_orders = clone $orderQuery;
        $can_orders = $can_orders->where('dstatus', '3')->get();

        $des_orders = clone $orderQuery;
        $des_orders = $des_orders->where('dstatus', '4')->get();

        $tottal_amount = $del_orders->sum('amount');
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $deliverd_orders_amount = $del_orders->sum('amount');
        $pending_orders_amount = $pending_orders->sum('amount');
        $dispatch_orders_amount = $des_orders->sum('amount');
        $confirmed_orders_amount = $com_orders->sum('amount');
        $canceled_orders_amount = $can_orders->sum('amount');

        $deliverd_vat = $deliverd_orders_amount * 0.05;
        $pending_vat = $pending_orders_amount * 0.05;
        $dispatch_vat = $dispatch_orders_amount * 0.05;
        $confirmed_vat = $confirmed_orders_amount * 0.05;

        $deliverd_discount = $del_orders->sum('discount');
        $pending_discount = $pending_orders->sum('discount');
        $dispatch_discount = $des_orders->sum('discount');
        $confirmed_discount = $com_orders->sum('discount');

        $deliverd_shipping = $del_orders->sum('shipping_fee');
        $pending_shipping = $pending_orders->sum('shipping_fee');
        $dispatch_shipping = $des_orders->sum('shipping_fee');
        $confirmed_shipping = $com_orders->sum('shipping_fee');

        $total_vat = $deliverd_vat + $pending_vat + $dispatch_vat + $confirmed_vat;
        $total_discount = $deliverd_discount + $pending_discount + $dispatch_discount + $confirmed_discount;
        $total_shipping = $deliverd_shipping + $pending_shipping + $dispatch_shipping + $confirmed_shipping;

        $total_order_amount = $deliverd_orders_amount + $pending_orders_amount + $dispatch_orders_amount + $confirmed_orders_amount;
        $net_order_amount = $total_order_amount - $total_vat - $total_shipping;

        $this_mon_amount = $del_orders->sum('amount');
        $this_pen_mon_amount = $pending_orders->sum('amount') + $com_orders->sum('amount') + $des_orders->sum('amount');

        // Debugging for today filter
        if ($dateFilter === 'today') {
            // Uncomment the line below to debug
            // dd($orders);
        }

        return view('admins.dashboard', compact(
            'total_vat',
            'total_discount',
            'total_shipping',
            'net_order_amount',
            'categories',
            'products',
            'rating',
            'pending_orders',
            'del_orders',
            'can_orders',
            'des_orders',
            'com_orders',
            'tottal_amount',
            'this_mon_amount',
            'this_pen_mon_amount',
            'dateFilter',
            'deliverd_orders_amount',
            'pending_orders_amount',
            'dispatch_orders_amount',
            'confirmed_orders_amount',
            'canceled_orders_amount',
            'visitorDates',
            'visitorCounts',
            'totalVisitors',
            'fromDate',
            'toDate',
            'orderDates',
            'pendingOrderCounts',
            'confirmedOrderCounts',
            'dispatchedOrderCounts',
            'deliveredOrderCounts',
            'canceledOrderCounts',
            'totalOrderCounts',
            'pendingOrderValues',
            'confirmedOrderValues',
            'dispatchedOrderValues',
            'deliveredOrderValues',
            'canceledOrderValues',
            'totalOrderValues'
        ));
    }

    public function sales()
    {
        // Get total sales for products
        // $productSales = Order::where('dstatus', '!=', 3)
        //     ->whereNotNull('product_detail')
        //     ->whereNot(function ($query) {
        //         $query->where('payment_method', 'ngenius')
        //             ->where('payment_status', 'pending');
        //     })->whereNotNull('product_detail')->get()->sum(function ($order) {
        //         $products = json_decode($order->product_detail, true);
        //         $total = 0;
        //         foreach ($products as $product) {
        //             $productData = Product::find($product['id'] ?? 0);
        //             if ($productData) {
        //                 $total += $product['qty'] * $productData->discount_price;
        //             }
        //         }
        //         return $total;
        //     });

        // // Get total sales for categories
        // $categorySales = Order::where('dstatus', '!=', 3)
        //     ->whereNotNull('product_detail')
        //     ->whereNotNull('product_detail')
        //     ->whereNot(function ($query) {
        //         $query->where('payment_method', 'ngenius')
        //             ->where('payment_status', 'pending');
        //     })
        //     ->get()
        //     ->sum(function ($order) {
        //         $products = json_decode($order->product_detail, true);
        //         $categories = [];
        //         $total = 0;

        //         foreach ($products as $product) {
        //             $productData = Product::find($product['id'] ?? 0);
        //             if ($productData) {
        //                 $categoryIds = explode(',', $productData->category_id);
        //                 $categoryCount = max(1, count($categoryIds)); // Prevent division by zero

        //                 foreach ($categoryIds as $category) {
        //                     $category = trim($category);
        //                     if (!isset($categories[$category])) {
        //                         $categories[$category] = 0;
        //                     }

        //                     // **Distribute sales among all categories**
        //                     $categories[$category] += ($product['qty'] * $productData->discount_price) / $categoryCount;
        //                 }
        //             }
        //         }

        //         return array_sum($categories);
        //     });, compact('productSales', 'categorySales')

        return view('admins.sales');
    }

    public function inventory(Request $request)
    {
        return view('admins.inventory');
    }
    // public function visits(Request $request)
    // {
    //     return view('admins.visits');
    // }
    public function visits(Request $request)
    {
        // Get the date filter from the request
        $dateFilter = $request->input('date_filter', 'last_7_days');

        // Calculate the date range based on the filter
        $dateRange = $this->getDateRange($dateFilter);

        // Fetch total visitors
        $totalVisitors = Visitor::whereBetween('visit_date', [$dateRange['start'], $dateRange['end']])
            ->sum('visitors');

        // Fetch unique countries
        $uniqueCountries = Visitor::whereBetween('visit_date', [$dateRange['start'], $dateRange['end']])
            ->distinct('country')
            ->count('country');

        // Fetch visits by country
        $visitsByCountry = Visitor::selectRaw('country, SUM(visitors) as total_visitors')
            ->whereBetween('visit_date', [$dateRange['start'], $dateRange['end']])
            ->groupBy('country')
            ->get();

        // GCC Countries list
        $gccCountries = ['Saudi Arabia', 'United Arab Emirates', 'Kuwait', 'Oman', 'Qatar', 'Bahrain'];

        // Fetch visits by GCC country
        $visitsByGCC = Visitor::selectRaw('country, SUM(visitors) as total_visitors')
            ->whereBetween('visit_date', [$dateRange['start'], $dateRange['end']])
            ->whereIn('country', $gccCountries)
            ->groupBy('country')
            ->get()
            ->keyBy('country');

        // Ensure all GCC countries are present in the result even if they have 0 visitors
        $gccDataArray = [];
        foreach ($gccCountries as $country) {
            $gccDataArray[] = [
                'country' => $country,
                'total_visitors' => $visitsByGCC->has($country) ? (int)$visitsByGCC[$country]->total_visitors : 0,
            ];
        }
        $gccData = collect($gccDataArray);

        // Fetch visits by day
        $visitsByDay = Visitor::selectRaw('visit_date, SUM(visitors) as total_visitors')
            ->whereBetween('visit_date', [$dateRange['start'], $dateRange['end']])
            ->groupBy('visit_date')
            ->orderBy('visit_date')
            ->get();

        // Prepare data for the map
        $mapData = $visitsByCountry->map(function ($item) {
            return [
                'country' => $item->country,
                'visitors' => $item->total_visitors,
            ];
        });

        return view('admins.visits', compact('dateFilter', 'totalVisitors', 'uniqueCountries', 'visitsByCountry', 'mapData', 'visitsByDay', 'gccData'));
    }

    private function getDateRange($filter)
    {
        switch ($filter) {
            case 'today':
                return ['start' => Carbon::today(), 'end' => Carbon::today()->endOfDay()];
            case 'yesterday':
                return ['start' => Carbon::yesterday(), 'end' => Carbon::yesterday()->endOfDay()];
            case 'last_7_days':
                return ['start' => Carbon::today()->subDays(6), 'end' => Carbon::today()->endOfDay()];
            case 'this_week':
                return ['start' => Carbon::now()->startOfWeek(), 'end' => Carbon::now()->endOfWeek()];
            case 'last_week':
                return ['start' => Carbon::now()->subWeek()->startOfWeek(), 'end' => Carbon::now()->subWeek()->endOfWeek()];
            case 'this_month':
                return ['start' => Carbon::now()->startOfMonth(), 'end' => Carbon::now()->endOfMonth()];
            case 'last_month':
                return ['start' => Carbon::now()->subMonth()->startOfMonth(), 'end' => Carbon::now()->subMonth()->endOfMonth()];
            case 'this_year':
                return ['start' => Carbon::now()->startOfYear(), 'end' => Carbon::now()->endOfYear()];
            case 'last_year':
                return ['start' => Carbon::now()->subYear()->startOfYear(), 'end' => Carbon::now()->subYear()->endOfYear()];
            default:
                // Default to last 7 days if unknown filter
                return ['start' => Carbon::today()->subDays(6), 'end' => Carbon::today()->endOfDay()];
        }
    }

    public function category_all(Request $request, $id = 0, $delete = null)
    {
        // echo "<pre>";print_r($request->all());exit;
        $edit = null;
        $category_conditions = null;
        $seo = null;

        $categories = Category::all();

        //    echo "<pre>";print_r($themes);exit;
        return view('admins.category_table', compact('categories'));
    }

    /**
     * Manage individual categories (view, edit, delete).
     * 
     * @param Request $request
     * @param int $id
     * @param string|null $delete
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function category(Request $request, $id = 0, $delete = null)
    {
        // echo "<pre>";print_r($request->all());exit;
        $edit = null;
        $category_conditions = null;
        $seo = null;
        if (isset($delete) && $id > 0) {
            Category::find($id)->delete();
            CategoryCondition::where('category_id', $id)->forceDelete();
            return redirect(route('admins.category'))->with([
                'msg' => 'Category Deleted Successfully',
                'msg_type' => 'success',
            ]);
        }
        if ($id > 0 && !isset($delete)) {
            $seo = CategoriesToMeta::where('cid', '=', $id)->first();
            $category_conditions = CategoryCondition::where('category_id', $id)->get();
            $edit = Category::find($id);
        }
        if ($request->isMethod('post')) {
            $hiddenId = $request->hidden_id ?? null;
            $validator = Validator::make($request->all(), [
                'name' => [
                    'required',
                    Rule::unique('categories', 'name')->ignore($hiddenId, 'id'),
                ],
            ]);

            if ($validator->fails()) {

                return redirect(route('admins.category'))->with([
                    'msg' => $validator->errors(),
                    'msg_type' => 'errors',
                ]);
            }

            if ($request->has('hidden_id')) {

                $category = Category::find($request->hidden_id);
                $category->name = $request->name;
                $category->name_ar = $request->name_ar;
                $category->sub_title = $request->sub_title;
                $category->sub_title_ar = $request->sub_title_ar;
                $category->color = $request->color;
                $category->status = $request->status;
                $category->menu = $request->menu;
                $category->mega_menu = $request->mega_menu;
                $category->home_cat = $request->home_cat;
                $category->show_on_cart = $request->show_on_cart;
                $category->sort_no = $request->sort_no;
                $category->show_no_mob = 0;
                $category->slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-f]+/', '-', $request->name)));
                $category->description = $request->description;
                $category->description_ar = $request->description_ar;
                $category->is_manual = $request->categoryType;
                if ($request->is_condition) {
                    $category->is_condition = $request->is_condition;
                }
                if (isset($request->icon)) {
                    $imageone = $request->icon;
                    $pimage_name = time() . $imageone->getClientOriginalName();
                    $imageone->move(public_path('/images/category_icons/'), $pimage_name);
                    $category->icon = 'images/category_icons/' . $pimage_name;
                }

                if ($request->hasFile('image_one')) {
                    $file = $request->file('image_one');
                    $name = time() . '.webp';
                    Image::make($file)->resize(200, 200, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->encode('webp', 100)->save(public_path('/images/category/') . $name);
                    $category['image'] = 'images/category/' . $name;
                }

                if ($request->hasFile('homepage_image')) {
                    $file = $request->file('homepage_image');
                    $name = time() . '_home.webp';
                    Image::make($file)->resize(400, 400, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->encode('webp', 100)->save(public_path('/images/category/') . $name);
                    $category->homepage_image = 'images/category/' . $name;
                }

                if ($request->hasFile('banner')) {
                    $file = $request->file('banner');
                    $name = time() . '_' . uniqid() . '.webp';
                    Image::make($file)->resize(1200, 400, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->encode('webp', 100)->save(public_path('/images/category/') . $name);
                    $category['banner'] = 'images/category/' . $name;
                }

                $category->updated_at = Date('Y-m-d h:i:s');
                $category->save();

                if ($request->type && $request->categoryType == 2) {

                    $types = $request->input('type', []);
                    $conditions = $request->input('condition', []);
                    $conditionValues = $request->input('condition_value', []);
                    // Mapping for types to condition_value keys
                    $mappedTypes = [
                        'Weight' => 'normal',
                        'Title' => 'normal',
                        'Tag' => 'normal',
                        'Price' => 'normal',
                        'Flavour' => 'flavours',
                        'Allergens' => 'allergens',
                        'Format' => 'formats',
                        'Country' => 'countries',
                        'Color' => 'color',
                        'Products' => 'product',
                        'Sku no' => 'normal',
                    ];

                    // Prepare formatted data
                    $formattedData = [];
                    foreach ($types as $index => $type) {
                        $conditionValueArray = $conditionValues[$index] ?? [];
                        $key = $mappedTypes[$type] ?? 'normal'; // Fallback to 'normal' if type isn't mapped
                        $conditionValue = $conditionValueArray[$key] ?? null;

                        // Check if the value is an array (e.g., multiple products)
                        if (is_array($conditionValue)) {
                            // Concatenate array values into a comma-separated string
                            $conditionValue = implode(',', $conditionValue);
                        }
                        if (empty($conditionValue)) {
                            continue; // Skip if condition_value is empty
                        }

                        $formattedData[] = [
                            'category_id' => $category->id,
                            'type' => $type,
                            'condition' => $conditions[$index] ?? null,
                            'condition_value' => $conditionValue,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }

                    // echo "<pre>";print_r($formattedData);exit;

                    CategoryCondition::where('category_id', $category->id)->forceDelete();
                    if (!empty($formattedData)) {
                        CategoryCondition::insert($formattedData);
                    } else {
                        $data = $request->all();
                        // echo "<pre>";print_r($data['condition_value']);exit;

                        // Check if 'condition_value' exists in the request
                        if (isset($data['condition_value']) && is_array($data['condition_value'])) {
                            // Filter and reindex 'condition_value'

                            $data['condition_value'] = array_values(array_filter($data['condition_value'], function ($value) {
                                if (is_array($value)) {
                                    // If the value is an array, implode it into a comma-separated string
                                    return !empty(array_filter($value)); // Ensure the array is not empty
                                }
                                return !empty($value); // Keep non-empty scalar values
                            }));

                            // Process the array: implode if necessary
                            $data['condition_value'] = array_map(function ($value) {
                                if (is_array($value)) {
                                    // Flatten and implode the array
                                    $flattened = array_filter($value, function ($item) {
                                        return !is_array($item) && !is_null($item) && $item !== ''; // Keep only valid scalar values
                                    });
                                    return implode(',', $flattened);
                                }
                                return $value; // Keep scalar values as they are
                            }, $data['condition_value']);
                        }
                        $types = $data["type"];
                        $conditions = $data["condition"];
                        $values = $data["condition_value"];

                        foreach ($types as $index => $type) {
                            CategoryCondition::create([
                                'category_id' => $category->id,
                                'type' => $type,
                                'condition' => $conditions[$index],
                                'condition_value' => $values[$index],
                            ]);
                        }
                    }
                    $dataEdit = [];
                }
                if ($request->type && $request->categoryType == 1) {
                    CategoryCondition::where('category_id', $category->id)->forceDelete();
                }

                $seo = CategoriesToMeta::where('cid', '=', $request->hidden_id)->first();

                if ($seo) {
                    $seo->title = $request->stitle;
                    $seo->description = $request->sdescription;
                    $seo->keywords = $request->skeywords;
                    $seo->save();
                } else {
                    $categoriesmeta = new CategoriesToMeta();

                    $categoriesmeta->cid = $category->id;
                    $categoriesmeta->title = $request->stitle;
                    $categoriesmeta->description = $request->sdescription;
                    $categoriesmeta->keywords = $request->skeywords;
                    $categoriesmeta->save();
                }
            } else {

                $category = new Category();
                $category->created_at = Date('Y-m-d h:i:s');
                $category->name = $request->name;
                $category->name_ar = $request->name_ar;
                $category->sub_title = $request->sub_title;
                $category->sub_title_ar = $request->sub_title_ar;
                $category->color = $request->color;
                $category->status = $request->status;
                $category->menu = $request->menu;
                $category->mega_menu = $request->mega_menu;
                $category->home_cat = $request->home_cat;
                $category->sort_no = $request->sort_no;
                $category->show_no_mob = 0;
                $category->is_manual = $request->categoryType;
                $category->description = $request->description;
                $category->description_ar = $request->description_ar;
                if ($request->is_condition) {
                    $category->is_condition = $request->is_condition;
                }

                if (isset($request->icon)) {
                    $imageone = $request->icon;
                    $pimage_name = time() . $imageone->getClientOriginalName();
                    $imageone->move(public_path('/images/category_icons/'), $pimage_name);
                    $category->icon = 'images/category_icons/' . $pimage_name;
                }
                if ($request->hasFile('image_one')) {
                    $file = $request->file('image_one');
                    $name = time() . '.webp';
                    Image::make($file)->resize(200, 200, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->encode('webp', 100)->save(public_path('/images/category/') . $name);
                    $category['image'] = 'images/category/' . $name;
                }

                if ($request->hasFile('homepage_image')) {
                    $file = $request->file('homepage_image');
                    $name = time() . '_home.webp';
                    Image::make($file)->resize(400, 400, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->encode('webp', 100)->save(public_path('/images/category/') . $name);
                    $category->homepage_image = 'images/category/' . $name;
                }

                if ($request->hasFile('banner')) {
                    $file = $request->file('banner');
                    $name = time() . '_' . uniqid() . '.webp';
                    Image::make($file)->resize(1200, 400, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->encode('webp', 80)->save(public_path('/images/category/') . $name);
                    $category['banner'] = 'images/category/' . $name;
                }
                $category->slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->name)));
                $category->updated_at = Date('Y-m-d h:i:s');

                if ($request->type && $request->categoryType == 2) {
                    $data = $request->all();
                    // Check if 'condition_value' exists in the request
                    if (isset($data['condition_value']) && is_array($data['condition_value'])) {
                        // Filter and reindex 'condition_value'
                        $data['condition_value'] = array_values(array_filter($data['condition_value'], function ($value) {
                            return !empty($value); // Keep only non-empty values
                        }));
                    }

                    // echo "<pre>";print_r($data);exit;
                    $validator = Validator::make($data, [
                        'type' => 'required|array',
                        'type.*' => 'required|string',
                        'condition' => 'required|array',
                        'condition.*' => 'required|string|in:=,!=,>,<',
                        'condition_value' => 'required',
                        'condition_value.*' => 'required',
                    ]);

                    if ($validator->fails()) {

                        return redirect(route('admins.category'))->with([
                            'msg' => $validator->errors(),
                            'msg_type' => 'errors',
                        ]);
                    }
                }

                $category->save();

                if ($request->type && $request->categoryType == 2) {
                    $data = $request->all();
                    // echo '<pre>';print_r($data);exit;
                    // Check if 'condition_value' exists in the request
                    if (isset($data['condition_value']) && is_array($data['condition_value'])) {
                        // Filter and reindex 'condition_value'

                        $data['condition_value'] = array_values(array_filter($data['condition_value'], function ($value) {
                            return !empty($value); // Keep only non-empty values
                        }));
                    }
                    $data['condition_value'] = array_map(function ($value) {
                        if (is_array($value)) {
                            // Flatten and implode the array
                            $flattened = array_filter($value, function ($item) {
                                return !is_array($item) && !is_null($item) && $item !== ''; // Keep only valid scalar values
                            });
                            return implode(',', $flattened);
                        }
                        return $value; // Keep scalar values as they are
                    }, $data['condition_value']);

                    // echo '<pre>';print_r($data);exit;
                    $types = $data["type"];
                    $conditions = $data["condition"];
                    $values = $data["condition_value"];

                    foreach ($types as $index => $type) {
                        CategoryCondition::create([
                            'category_id' => $category->id,
                            'type' => $type,
                            'condition' => $conditions[$index],
                            'condition_value' => $values[$index],
                        ]);
                    }
                }

                $categoriesmeta = new CategoriesToMeta();

                $categoriesmeta->cid = $category->id;
                $categoriesmeta->title = $request->stitle;
                $categoriesmeta->description = $request->sdescription;
                $categoriesmeta->keywords = $request->skeywords;
                $categoriesmeta->save();
            }

            return redirect(route('admins.category_all'))->with([
                'msg' => 'Category Saved Successfully',
                'msg_type' => 'success',
            ]);
        }

        $categories = Category::all();
        $category_types = DB::table('category_types')
            ->leftJoin('category_conditions as cc', 'cc.type', 'category_types.name')
            ->select('category_types.id', 'category_types.name', 'cc.type as selected')
            ->distinct()->get();
        $brands = Brand::leftJoin(
            'category_conditions as cc',
            DB::raw('CASE WHEN cc.condition_value ~ \'^[0-9]+$\' THEN CAST(cc.condition_value AS INTEGER) ELSE 0 END'),
            '=',
            'brands.id'
        )
            ->select(
                'brands.id',
                'brands.name',
                DB::raw('CASE WHEN cc.condition_value ~ \'^[0-9]+$\' THEN CAST(cc.condition_value AS INTEGER) ELSE 0 END as selected')
            )
            ->distinct()
            ->get();
        $themes = Theme::leftJoin(
            'category_conditions as cc',
            DB::raw('CASE WHEN cc.condition_value ~ \'^[0-9]+$\' THEN CAST(cc.condition_value AS INTEGER) ELSE 0 END'),
            '=',
            'themes.id'
        )
            ->select(
                'themes.id',
                'themes.name',
                DB::raw('CASE WHEN cc.condition_value ~ \'^[0-9]+$\' THEN CAST(cc.condition_value AS INTEGER) ELSE 0 END as selected')
            )
            ->distinct()
            ->get();
        $colors = Colors::leftJoin(
            'category_conditions as cc',
            DB::raw('CASE WHEN cc.condition_value ~ \'^[0-9]+$\' THEN CAST(cc.condition_value AS INTEGER) ELSE 0 END'),
            '=',
            'colors.id'
        )
            ->select(
                'colors.id',
                'colors.name',
                DB::raw('CASE WHEN cc.condition_value ~ \'^[0-9]+$\' THEN CAST(cc.condition_value AS INTEGER) ELSE 0 END as selected')
            )
            ->distinct()
            ->get();
        $allergens = Allergen::leftJoin(
            'category_conditions as cc',
            DB::raw('CASE WHEN cc.condition_value ~ \'^[0-9]+$\' THEN CAST(cc.condition_value AS INTEGER) ELSE 0 END'),
            '=',
            'allergens.id'
        )
            ->select(
                'allergens.id',
                'allergens.name',
                DB::raw('CASE WHEN cc.condition_value ~ \'^[0-9]+$\' THEN CAST(cc.condition_value AS INTEGER) ELSE 0 END as selected')
            )
            ->distinct()
            ->get();
        $flavours = Flavour::leftJoin(
            'category_conditions as cc',
            DB::raw('CASE WHEN cc.condition_value ~ \'^[0-9]+$\' THEN CAST(cc.condition_value AS INTEGER) ELSE 0 END'),
            '=',
            'flavours.id'
        )
            ->select(
                'flavours.id',
                'flavours.name',
                DB::raw('CASE WHEN cc.condition_value ~ \'^[0-9]+$\' THEN CAST(cc.condition_value AS INTEGER) ELSE 0 END as selected')
            )
            ->distinct()
            ->get();

        $formats = Format::leftJoin(
            'category_conditions as cc',
            DB::raw('CASE WHEN cc.condition_value ~ \'^[0-9]+$\' THEN CAST(cc.condition_value AS INTEGER) ELSE 0 END'),
            '=',
            'formats.id'
        )
            ->select(
                'formats.id',
                'formats.name',
                DB::raw('CASE WHEN cc.condition_value ~ \'^[0-9]+$\' THEN CAST(cc.condition_value AS INTEGER) ELSE 0 END as selected')
            )
            ->distinct()
            ->get();

        $countries = Country::leftJoin(
            'category_conditions as cc',
            DB::raw('CASE WHEN cc.condition_value ~ \'^[0-9]+$\' THEN CAST(cc.condition_value AS INTEGER) ELSE 0 END'),
            '=',
            'countries.id'
        )
            ->select(
                'countries.id',
                'countries.name',
                DB::raw('CASE WHEN cc.condition_value ~ \'^[0-9]+$\' THEN CAST(cc.condition_value AS INTEGER) ELSE 0 END as selected')
            )
            ->distinct()
            ->get();
        $products = Product::where('status', 1)->get();
        //    echo "<pre>";print_r($themes);exit;
        return view('admins.category', compact('categories', 'edit', 'category_conditions', 'seo', 'category_types', 'brands', 'themes', 'colors', 'allergens', 'flavours', 'formats', 'countries', 'products'));
    }

    public function getCategoryTypeCondition(Request $request)
    {
        $type = $request->type;

        if ($type == 'Price' || $type == 'Weight' || $type == 'Sku no') {
            $conditions = DB::table('category_type_conditions')->select('name', 'value')->get();
            return response()->json([
                'status' => 'success',
                'conditions' => $conditions,
            ]);
        } else {
            $conditions = DB::table('category_type_conditions')->select('name', 'value')->where('name', 'is equal to')->get();
            return response()->json([
                'status' => 'success',
                'conditions' => $conditions,
            ]);
        }
    }

    public function brand(Request $request, $id = 0, $delete = null)
    {
        $edit = null;
        $path = null;
        $seo = null;
        if (isset($delete) && $id > 0) {
            $brand = Brand::find($id);
            $file_path = public_path() . '/' . $brand->brand_logo;
            if (\File::exists($file_path)) {
                \File::delete(public_path() . '/' . $brand->brand_logo);
            }
            $brand->delete();
            return redirect(route('admins.brand'))->with([
                'msg' => 'Brand Deleted Successfully',
                'msg_type' => 'success',
            ]);
        }
        if ($id > 0 && !isset($delete)) {
            $edit = Brand::find($id);
            $seo = BrandToMeta::where('bid', '=', $id)->first();
        }
        if ($request->isMethod('post')) {

            // $request->validate([
            //     'name' => 'required|unique:brands,name,' . $request->hidden_id,
            //     'logo' => 'required|mimes:png,jpg,jpeg,gif'
            // ]);

            if ($request->has('hidden_id')) {
                $brand = Brand::find($request->hidden_id);

                $brand->brand_logo = $brand->brand_logo;

                $seo = BrandToMeta::where('bid', '=', $request->hidden_id)->first();

                if ($seo) {
                    $seo->title = $request->stitle;
                    $seo->description = $request->sdescription;
                    $seo->keywords = $request->skeywords;
                    $seo->save();
                } else {
                    $BrandToMeta = new BrandToMeta();

                    $BrandToMeta->bid = $brand->id;
                    $BrandToMeta->title = $request->stitle;
                    $BrandToMeta->description = $request->sdescription;
                    $BrandToMeta->keywords = $request->skeywords;
                    $BrandToMeta->save();
                }
            } else {
                $brand = new Brand();
                $brand->created_at = Date('Y-m-d h:i:s');
            }
            if ($request->hasFile('logo')) {
                $file = $request->file('logo');
                $extension = 'webp';
                $image_name = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->name)));
                $name = $image_name . '.' . $extension;
                $file->move(public_path('/images/brands/'), $name);
                // $webpContent = file_get_contents(public_path('/images/brands/') . $name);
                // $image = imagecreatefromstring($webpContent);
                // $originalWidth = imagesx($image);
                // $originalHeight = imagesy($image);
                // $newWidth = 130;
                // $newHeight = 130;
                // $newImage = imagecreatetruecolor($newWidth, $newHeight);
                // $transparent = imagecolorallocatealpha($newImage, 0, 0, 0, 127);
                // imagefill($newImage, 0, 0, $transparent);
                // imagesavealpha($newImage, true);
                // imagecopyresampled($newImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $originalWidth, $originalHeight);
                // imagewebp($newImage, public_path('/images/brands/') . $name, 90);
                // imagedestroy($image);
                // imagedestroy($newImage);
                $brand['brand_logo'] = 'images/brands/' . $name;
            }
            $brand->name = $request->name;
            $brand->slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->name)));
            $brand->updated_at = Date('Y-m-d h:i:s');
            $brand->save();

            $BrandToMeta = new BrandToMeta();

            $BrandToMeta->bid = $brand->id;
            $BrandToMeta->title = $request->stitle;
            $BrandToMeta->description = $request->sdescription;
            $BrandToMeta->keywords = $request->skeywords;
            $BrandToMeta->save();
            return redirect(route('admins.brand'))->with([
                'msg' => 'Brand Saved Successfully',
                'msg_type' => 'success',
            ]);
        }

        $brands = Brand::all();
        return view('admins.brand', compact('brands', 'edit', 'seo'));
    }

    public function product_type(Request $request, $id = 0, $delete = null)
    {
        $edit = null;
        if (isset($delete) && $id > 0) {
            ProductType::find($id)->delete();
            return redirect(route('admins.product_type'))->with([
                'msg' => 'Product Type Deleted Successfully',
                'msg_type' => 'success',
            ]);
        }
        if ($id > 0 && !isset($delete)) {
            $edit = ProductType::find($id);
        }
        if ($request->isMethod('post')) {

            if ($request->has('hidden_id')) {
                $brand = ProductType::find($request->hidden_id);
            } else {
                $brand = new ProductType();
                $brand->created_at = Date('Y-m-d h:i:s');
            }
            $brand->name = $request->name;
            $brand->updated_at = Date('Y-m-d h:i:s');
            $brand->save();
            return redirect(route('admins.product_type'))->with([
                'msg' => 'Product Types Saved Successfully',
                'msg_type' => 'success',
            ]);
        }

        $ProductType = ProductType::all();
        return view('admins.product_types.index', compact('ProductType', 'edit'));
    }

    public function ingredient(Request $request, $id = 0, $delete = null)
    {
        $edit = null;
        if (isset($delete) && $id > 0) {
            Ingredient::find($id)->delete();
            return redirect(route('admins.ingredient'))->with([
                'msg' => 'Ingredient Deleted Successfully',
                'msg_type' => 'success',
            ]);
        }
        if ($id > 0 && !isset($delete)) {
            $edit = Ingredient::find($id);
        }
        if ($request->isMethod('post')) {

            if ($request->has('hidden_id')) {
                $brand = Ingredient::find($request->hidden_id);
            } else {
                $brand = new Ingredient();
                $brand->created_at = Date('Y-m-d h:i:s');
            }
            $brand->name = $request->name;
            $brand->updated_at = Date('Y-m-d h:i:s');
            $brand->save();
            return redirect(route('admins.ingredient'))->with([
                'msg' => 'Ingredient Saved Successfully',
                'msg_type' => 'success',
            ]);
        }

        $ProductType = Ingredient::all();
        return view('admins.ingredient.index', compact('ProductType', 'edit'));
    }

    public function allergen(Request $request, $id = 0, $delete = null)
    {
        $edit = null;
        if (isset($delete) && $id > 0) {
            Allergen::find($id)->delete();
            return redirect(route('admins.allergen'))->with([
                'msg' => 'Allergen Deleted Successfully',
                'msg_type' => 'success',
            ]);
        }
        if ($id > 0 && !isset($delete)) {
            $edit = Allergen::find($id);
        }
        if ($request->isMethod('post')) {

            if ($request->has('hidden_id')) {
                $brand = Allergen::find($request->hidden_id);
            } else {
                $brand = new Allergen();
                $brand->created_at = Date('Y-m-d h:i:s');
            }
            $brand->name = $request->name;
            $brand->updated_at = Date('Y-m-d h:i:s');
            $brand->save();
            return redirect(route('admins.allergen'))->with([
                'msg' => 'Allergen Saved Successfully',
                'msg_type' => 'success',
            ]);
        }

        $ProductType = Allergen::all();
        return view('admins.allergen.index', compact('ProductType', 'edit'));
    }

    public function package_type(Request $request, $id = 0, $delete = null)
    {
        $edit = null;
        if (isset($delete) && $id > 0) {
            PackageType::find($id)->delete();
            return redirect(route('admins.package_type'))->with([
                'msg' => 'Package Type Deleted Successfully',
                'msg_type' => 'success',
            ]);
        }
        if ($id > 0 && !isset($delete)) {
            $edit = PackageType::find($id);
        }
        if ($request->isMethod('post')) {

            if ($request->has('hidden_id')) {
                $brand = PackageType::find($request->hidden_id);
            } else {
                $brand = new PackageType();
                $brand->created_at = Date('Y-m-d h:i:s');
            }
            $brand->name = $request->name;
            $brand->price = $request->price;
            $brand->updated_at = Date('Y-m-d h:i:s');
            $brand->save();
            return redirect(route('admins.package_type'))->with([
                'msg' => 'Package Types Saved Successfully',
                'msg_type' => 'success',
            ]);
        }

        $PackageType = PackageType::all();
        return view('admins.package_type', compact('PackageType', 'edit'));
    }

    public function basket_type(Request $request, $id = 0, $delete = null)
    {
        $edit = null;
        if (isset($delete) && $id > 0) {
            BasketType::find($id)->delete();
            return redirect(route('admins.basket_type'))->with([
                'msg' => 'Basket Type Deleted Successfully',
                'msg_type' => 'success',
            ]);
        }
        if ($id > 0 && !isset($delete)) {
            $edit = BasketType::find($id);
        }
        if ($request->isMethod('post')) {

            if ($request->has('hidden_id')) {
                $brand = BasketType::find($request->hidden_id);
            } else {
                $brand = new BasketType();
                $brand->created_at = Date('Y-m-d h:i:s');
            }
            $brand->name = $request->name;
            $brand->updated_at = Date('Y-m-d h:i:s');
            $brand->save();
            return redirect(route('admins.basket_type'))->with([
                'msg' => 'Basket Types Saved Successfully',
                'msg_type' => 'success',
            ]);
        }

        $BasketType = BasketType::all();
        return view('admins.basket_type', compact('BasketType', 'edit'));
    }

    public function theme(Request $request, $id = 0, $delete = null)
    {
        $edit = null;
        if (isset($delete) && $id > 0) {
            Theme::find($id)->delete();
            return redirect(route('admins.theme'))->with([
                'msg' => 'Theme Deleted Successfully',
                'msg_type' => 'success',
            ]);
        }
        if ($id > 0 && !isset($delete)) {
            $edit = Theme::find($id);
        }
        if ($request->isMethod('post')) {
            if ($request->has('hidden_id')) {
                $theme = Theme::find($request->hidden_id);
            } else {
                $theme = new Theme();
                $theme->created_at = Date('Y-m-d h:i:s');
            }
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $extension = 'webp';
                // Rename the file with a new extension
                $name = time() . '.' . $extension;

                // Move the uploaded file to the desired directory
                $file->move(public_path('/images/themes/'), $name);

                $theme['image'] = 'images/themes/' . $name;
            }
            if ($request->hasFile('banner')) {
                $file = $request->file('banner');
                $extension = $file->getClientOriginalExtension();
                $extension = 'webp';
                // Rename the file with a new extension
                $name = time() . '_' . uniqid() . '.' . $extension;

                // Move the uploaded file to the desired directory
                $file->move(public_path('/images/themes/'), $name);

                $theme['banner'] = 'images/themes/' . $name;
            }
            $theme->name = $request->name;
            $theme->slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->name)));
            $theme->updated_at = Date('Y-m-d h:i:s');
            $theme->save();
            return redirect(route('admins.theme'))->with([
                'msg' => 'Theme Saved Successfully',
                'msg_type' => 'success',
            ]);
        }

        $Theme = Theme::all();
        return view('admins.theme', compact('Theme', 'edit'));
    }

    public function flavour(Request $request, $id = 0, $delete = null)
    {
        $edit = null;
        if (isset($delete) && $id > 0) {
            Flavour::find($id)->delete();
            return redirect(route('admins.flavour'))->with([
                'msg' => 'Flavour Deleted Successfully',
                'msg_type' => 'success',
            ]);
        }
        if ($id > 0 && !isset($delete)) {
            $edit = Flavour::find($id);
        }
        if ($request->isMethod('post')) {

            if ($request->has('hidden_id')) {
                $flavour = Flavour::find($request->hidden_id);
            } else {
                $flavour = new Flavour();
                $flavour->created_at = Date('Y-m-d h:i:s');
            }
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $extension = 'webp';
                // Rename the file with a new extension
                $name = time() . '.' . $extension;

                // Move the uploaded file to the desired directory
                $file->move(public_path('/images/flavours/'), $name);

                $theme['image'] = 'images/flavours/' . $name;
            }
            if ($request->hasFile('banner')) {
                $file = $request->file('banner');
                $extension = $file->getClientOriginalExtension();
                $extension = 'webp';
                // Rename the file with a new extension
                $name = time() . '_' . uniqid() . '.' . $extension;

                // Move the uploaded file to the desired directory
                $file->move(public_path('/images/flavours/'), $name);

                $theme['banner'] = 'images/flavours/' . $name;
            }
            $flavour->name = $request->name;
            $flavour->name_ar = $request->name_ar;
            $flavour->color = $request->color;
            $flavour->show_home = $request->show_home;
            $flavour->slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->name)));
            $flavour->updated_at = Date('Y-m-d h:i:s');
            $flavour->save();
            return redirect(route('admins.flavour'))->with([
                'msg' => 'Flavour Saved Successfully',
                'msg_type' => 'success',
            ]);
        }

        $Flavour = Flavour::all();
        return view('admins.flavour', compact('Flavour', 'edit'));
    }

    public function colors(Request $request, $id = 0, $delete = null)
    {
        $edit = null;
        if (isset($delete) && $id > 0) {
            Colors::find($id)->delete();
            return redirect(route('admins.colors'))->with([
                'msg' => 'Colors Deleted Successfully',
                'msg_type' => 'success',
            ]);
        }
        if ($id > 0 && !isset($delete)) {
            $edit = Colors::find($id);
        }
        if ($request->isMethod('post')) {

            if ($request->has('hidden_id')) {
                $category = Colors::find($request->hidden_id);
                $category->name = $request->name;
                $category->updated_at = Date('Y-m-d h:i:s');
                $category->save();
            } else {

                $category = new Colors();
                $category->created_at = Date('Y-m-d h:i:s');
                $category->name = $request->name;
                $category->updated_at = Date('Y-m-d h:i:s');
                $category->save();
            }

            return redirect(route('admins.colors'))->with([
                'msg' => 'colors Saved Successfully',
                'msg_type' => 'success',
            ]);
        }
        $categories = Colors::all();
        return view('admins.colors', compact('categories', 'edit'));
    }

    public function box_customize(Request $request, $id = 0, $delete = null)
    {
        $edit = null;
        if (isset($delete) && $id > 0) {
            BoxCustomize::find($id)->delete();
            return redirect(route('admins.box_customize'))->with([
                'msg' => 'Box Deleted Successfully',
                'msg_type' => 'success',
            ]);
        }
        if ($id > 0 && !isset($delete)) {
            $edit = BoxCustomize::find($id);
        }
        if ($request->isMethod('post')) {

            if ($request->has('hidden_id')) {
                $BoxCustomize = BoxCustomize::find($request->hidden_id);
            } else {
                $BoxCustomize = new BoxCustomize();
                $BoxCustomize->created_at = Date('Y-m-d h:i:s');
            }
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $extension = 'webp';
                // Rename the file with a new extension
                $name = time() . '.' . $extension;

                // Move the uploaded file to the desired directory
                $file->move(public_path('/images/boxes/'), $name);

                $BoxCustomize['image'] = 'images/boxes/' . $name;
            }
            $BoxCustomize->size_id = $request->size_id;
            $BoxCustomize->package_id = $request->package_id;
            $BoxCustomize->price = $request->price;
            $BoxCustomize->weight = $request->weight;
            $BoxCustomize->updated_at = Date('Y-m-d h:i:s');
            $BoxCustomize->save();
            return redirect(route('admins.box_customize'))->with([
                'msg' => 'Box Saved Successfully',
                'msg_type' => 'success',
            ]);
        }

        $BoxCustomize = BoxCustomize::all();
        $BoxSize = BoxSize::all();
        $PackageType = PackageType::all();
        return view('admins.makeownbasket', compact('BoxCustomize', 'BoxSize', 'PackageType', 'edit'));
    }

    public function box_size(Request $request, $id = 0, $delete = null)
    {
        $edit = null;
        if (isset($delete) && $id > 0) {
            BoxSize::find($id)->delete();
            return redirect(route('admins.box_size'))->with([
                'msg' => 'Box Size Deleted Successfully',
                'msg_type' => 'success',
            ]);
        }
        if ($id > 0 && !isset($delete)) {
            $edit = BoxSize::find($id);
        }
        if ($request->isMethod('post')) {

            if ($request->has('hidden_id')) {
                $BoxSize = BoxSize::find($request->hidden_id);
            } else {
                $BoxSize = new BoxSize();
                $BoxSize->created_at = Date('Y-m-d h:i:s');
            }
            $BoxSize->name = $request->name;
            $BoxSize->updated_at = Date('Y-m-d h:i:s');
            $BoxSize->save();
            return redirect(route('admins.box_size'))->with([
                'msg' => 'Box Size Saved Successfully',
                'msg_type' => 'success',
            ]);
        }

        $BoxSize = BoxSize::all();
        return view('admins.box_size', compact('BoxSize', 'edit'));
    }

    public function shap(Request $request, $id = 0, $delete = null)
    {
        $edit = null;
        if (isset($delete) && $id > 0) {
            Shap::find($id)->delete();
            return redirect(route('admins.shap'))->with([
                'msg' => 'Shap Deleted Successfully',
                'msg_type' => 'success',
            ]);
        }
        if ($id > 0 && !isset($delete)) {
            $edit = Shap::find($id);
        }
        if ($request->isMethod('post')) {

            $request->validate([
                'name' => 'required|unique:categories,name,' . $request->hidden_id,
            ]);

            if ($request->has('hidden_id')) {
                $category = Shap::find($request->hidden_id);
                $category->name = $request->name;
                $category->updated_at = Date('Y-m-d h:i:s');
                $category->save();
            } else {

                $category = new Shap();
                $category->created_at = Date('Y-m-d h:i:s');
                $category->name = $request->name;
                $category->updated_at = Date('Y-m-d h:i:s');
                $category->save();
            }

            return redirect(route('admins.shap'))->with([
                'msg' => 'Shap Saved Successfully',
                'msg_type' => 'success',
            ]);
        }
        $categories = Shap::all();
        return view('admins.shap', compact('categories', 'edit'));
    }

    public function currency(Request $request, $id = 0, $delete = null)
    {
        $edit = null;
        if (isset($delete) && $id > 0) {
            Currency::find($id)->delete();
            return redirect(route('admins.currency'))->with([
                'msg' => 'Currency Deleted Successfully',
                'msg_type' => 'success',
            ]);
        }
        if ($id > 0 && !isset($delete)) {
            $edit = Currency::find($id);
        }
        if ($request->isMethod('post')) {
            if ($request->has('hidden_id')) {
                $currency = Currency::find($request->hidden_id);
            } else {
                $currency = new Currency();
                $currency->created_at = Date('Y-m-d h:i:s');
            }
            $currency->name = $request->name;
            $currency->symbol = $request->symbol;
            $currency->updated_at = Date('Y-m-d h:i:s');
            $currency->save();
            return redirect(route('admins.currency'))->with([
                'msg' => 'Currency Saved Successfully',
                'msg_type' => 'success',
            ]);
        }

        $currency = Currency::all();
        return view('admins.currency', compact('currency', 'edit'));
    }

    public function vat(Request $request, $id = 0, $delete = null)
    {
        $edit = null;
        if (isset($delete) && $id > 0) {
            Vat::find($id)->delete();
            return redirect(route('admins.vat'))->with([
                'msg' => 'Vat Deleted Successfully',
                'msg_type' => 'success',
            ]);
        }
        if ($id > 0 && !isset($delete)) {
            $edit = Vat::find($id);
        }
        if ($request->isMethod('post')) {
            if ($request->has('hidden_id')) {
                $vat = Vat::find($request->hidden_id);
            } else {
                $vat = new Vat();
                $vat->created_at = Date('Y-m-d h:i:s');
            }
            $vat->country_name = $request->country_name;
            $vat->tax_value = $request->tax_value;
            $vat->updated_at = Date('Y-m-d h:i:s');
            $vat->save();
            return redirect(route('admins.vat'))->with([
                'msg' => 'Vat Saved Successfully',
                'msg_type' => 'success',
            ]);
        }

        $vat = Vat::all();
        return view('admins.vat', compact('vat', 'edit'));
    }

    public function top_announcement_bar(Request $request, $id = 0, $delete = null)
    {
        $edit = null;
        if (isset($delete) && $id > 0) {
            TopAnnouncementBar::find($id)->delete();
            return redirect(route('admins.announcements'))->with([
                'msg' => 'Announcement Deleted Successfully',
                'msg_type' => 'success',
            ]);
        }
        if ($id > 0 && !isset($delete)) {
            $edit = TopAnnouncementBar::find($id);
        }
        if ($request->isMethod('post')) {
            if ($request->has('hidden_id')) {
                $announcements = TopAnnouncementBar::find($request->hidden_id);
            } else {
                $announcements = new TopAnnouncementBar();
                $announcements->created_at = Date('Y-m-d h:i:s');
            }
            $announcements->text = $request->text;
            $announcements->text_ar = $request->text_ar;
            $announcements->status = $request->status;
            $announcements->updated_at = Date('Y-m-d h:i:s');
            $announcements->save();
            return redirect(route('admins.announcements'))->with([
                'msg' => 'Announcement Saved Successfully',
                'msg_type' => 'success',
            ]);
        }

        $announcements = TopAnnouncementBar::all();
        return view('admins.announcements', compact('announcements', 'edit'));
    }

    public function home_cats(Request $request, $id = 0, $delete = null)
    {
        $edit = null;
        if (isset($delete) && $id > 0) {
            DB::table('home_cats')->delete($id);
            return redirect(route('admins.home_cats'))->with([
                'msg' => 'Category Deleted Successfully',
                'msg_type' => 'success',
            ]);
        }
        if ($id > 0 && !isset($delete)) {
            $edit = DB::table('home_cats')->where('home_cats.id', $id)->first();
            // dd($edit);
        }
        if ($request->isMethod('post')) {

            $request->validate([
                'name' => 'required|unique:categories,name,' . $request->hidden_id,
            ]);

            if ($request->has('hidden_id')) {
                $in = array(
                    'updated_at' => Date('Y-m-d h:i:s'),
                    'name' => $request->name,
                    'status' => $request->status,
                    'sort' => $request->sort,
                );
                $id = DB::table('home_cats')->where('id', $request->hidden_id)->update($in);
            } else {
                $in = array(
                    'updated_at' => Date('Y-m-d h:i:s'),
                    'created_at' => Date('Y-m-d h:i:s'),
                    'name' => $request->name,
                    'status' => $request->status,
                    'sort' => $request->sort,
                );
                $id = DB::table('home_cats')->insert($in);
            }

            return redirect(route('admins.home_cats'))->with([
                'msg' => 'Category Saved Successfully',
                'msg_type' => 'success',
            ]);
        }
        $categories = DB::table('home_cats')->get();
        return view('admins.home_cats', compact('categories', 'edit'));
    }

    public function clarity(Request $request, $id = 0, $delete = null)
    {
        $edit = null;
        if (isset($delete) && $id > 0) {
            DB::table('calarity')->delete($id);
            return redirect(route('admins.clarity'))->with([
                'msg' => 'Clarity Deleted Successfully',
                'msg_type' => 'success',
            ]);
        }
        if ($id > 0 && !isset($delete)) {
            $edit = DB::table('calarity')->where('calarity.id', $id)->first();
            // dd($edit);
        }
        if ($request->isMethod('post')) {

            if ($request->has('hidden_id')) {
                $in = array(
                    'updated_at' => Date('Y-m-d h:i:s'),
                    'name' => $request->name,
                );
                $id = DB::table('calarity')->where('id', $request->hidden_id)->update($in);
            } else {
                $in = array(
                    'updated_at' => Date('Y-m-d h:i:s'),
                    'created_at' => Date('Y-m-d h:i:s'),
                    'name' => $request->name,
                );
                $id = DB::table('calarity')->insert($in);
            }

            return redirect(route('admins.clarity'))->with([
                'msg' => 'Size Saved Successfully',
                'msg_type' => 'success',
            ]);
        }
        $categories = DB::table('calarity')->get();
        return view('admins.calarity', compact('categories', 'edit'));
    }
    public function size(Request $request, $id = 0, $delete = null)
    {
        $edit = null;
        if (isset($delete) && $id > 0) {
            Size::find($id)->delete();
            return redirect(route('admins.size'))->with([
                'msg' => 'Size Deleted Successfully',
                'msg_type' => 'success',
            ]);
        }
        if ($id > 0 && !isset($delete)) {
            $edit = Size::find($id);
        }
        if ($request->isMethod('post')) {

            if ($request->has('hidden_id')) {
                $category = Size::find($request->hidden_id);
                $category->name = $request->name;
                $category->updated_at = Date('Y-m-d h:i:s');
                $category->save();
            } else {

                $category = new Size();
                $category->created_at = Date('Y-m-d h:i:s');
                $category->name = $request->name;
                $category->updated_at = Date('Y-m-d h:i:s');
                $category->save();
            }

            return redirect(route('admins.size'))->with([
                'msg' => 'Size Saved Successfully',
                'msg_type' => 'success',
            ]);
        }
        $categories = Size::all();
        return view('admins.size', compact('categories', 'edit'));
    }

    public function subcategory(Request $request, $id = 0, $delete = null)
    {
        $edit = null;
        if (isset($delete) && $id > 0) {
            SubCategory::find($id)->delete();
            return redirect(route('admins.subcategory'))->with([
                'msg' => 'SubCategory Deleted Successfully',
                'msg_type' => 'success',
            ]);
        }
        if ($id > 0 && !isset($delete)) {
            $edit = SubCategory::find($id);
        }
        if ($request->isMethod('post')) {

            $request->validate([
                'name' => 'required',
                'category_id' => 'required',
            ]);

            if ($request->has('hidden_id')) {
                $category = SubCategory::find($request->hidden_id);
            } else {
                $category = new SubCategory();
                $category->created_at = Date('Y-m-d h:i:s');
            }
            $category->name = $request->name;
            $category->slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->name)));
            $category->category_id = $request->category_id;
            $category->updated_at = Date('Y-m-d h:i:s');
            $category->save();
            return redirect(route('admins.subcategory'))->with([
                'msg' => 'SubCategory Saved Successfully',
                'msg_type' => 'success',
            ]);
        }
        $categories = Category::all();
        $sub_categories = $users = SubCategory::leftJoin('categories', 'categories.id', '=', 'sub_categories.category_id')
            ->select('sub_categories.*', 'categories.name AS parent_category')
            ->get();
        return view('admins.subcategory', compact('categories', 'sub_categories', 'edit'));
    }

    public function news_letters(Request $request, $id = 0, $delete = null)
    {
        if (isset($delete) && $id > 0) {
            Newsletter::find($id)->delete();
            return redirect(route('admins.news_letters'))->with([
                'msg' => 'Subcriber Deleted Successfully',
                'msg_type' => 'success',
            ]);
        }
        $news_letters = Newsletter::get();
        return view('admins.news_letters', compact('news_letters'));
    }

    public function coupon(Request $request, $id = 0, $delete = null)
    {
        $edit = null;

        // Delete Coupon
        if (isset($delete) && $id > 0) {
            Coupon::find($id)->delete();
            return redirect(route('admins.coupon'))->with([
                'msg' => 'Coupon Deleted Successfully',
                'msg_type' => 'success',
            ]);
        }

        // Edit Coupon
        if ($id > 0 && !isset($delete)) {
            $edit = Coupon::find($id);
        }

        // Handle Form Submission
        if ($request->isMethod('post')) {
            if ($request->has('hidden_id')) {
                $coupon = Coupon::find($request->hidden_id);
            } else {
                $coupon = new Coupon();
                $coupon->created_at = now();
            }

            $coupon->code = $request->code;
            $coupon->discount = $request->discount;
            $coupon->type = $request->type;
            $coupon->status = $request->status;
            $coupon->cart_minimum = $request->cart_minimum;
            $coupon->end_date = $request->end_date;
            $coupon->one_time_use = $request->one_time_use;
            $coupon->num_of_coupons = $request->num_of_coupons;
            $coupon->auto_apply = $request->auto_apply;

            // Convert product IDs from string to JSON array
            $coupon->products = $request->products ? json_encode($request->products) : null;

            $coupon->updated_at = now();
            $coupon->save();

            return redirect(route('admins.coupon'))->with([
                'msg' => 'Coupon Saved Successfully',
                'msg_type' => 'success',
            ]);
        }

        // Get Active Products for Selection
        $products = Product::where('status', 1)->get();

        // Get All Coupons
        $coupons = Coupon::all();

        return view('admins.coupons', compact('coupons', 'edit', 'products'));
    }

    public function products(Request $request, $id = 0, $delete = null)
    {

        $products = Product::select('products.*')->orderBy('products.id', 'DESC')->get();
        $categories = Category::all();
        $formats = Format::all();
        return view('admins.products', compact('products', 'categories', 'formats'));
    }

    public function inventoryReport()
    {
        return view('admins.inventory_report');
    }


    public function review(Request $request, $id = 0, $delete = null)
    {
        $reviews = Rating::where('status', 0)->get();
        return view('admins.review', compact('reviews'));
    }
    public function approved_review(Request $request, $id = 0, $delete = null)
    {
        $reviews = Rating::where('status', 1)->get();
        return view('admins.approve_review', compact('reviews'));
    }

    public function pages(Request $request, $id = 0, $delete = null)
    {
        $pages = Pages::all();
        return view('admins.pages', compact('pages'));
    }
    public function toggleHeader(Request $request)
    {
        $request->validate([
            'page_id' => 'required|integer|exists:pages,id',
            'status' => 'required|boolean',
        ]);

        $page = Pages::findOrFail($request->page_id);
        $page->is_show_in_header = (bool)$request->status;
        $page->save();

        return response()->json(['msg' => 'Header visibility updated', 'msg_type' => 'success']);
    }
    public function static_pages(Request $request, $id = 0, $delete = null)
    {
        $pages = Pages::all();
        return view('admins.static_pages', compact('pages'));
    }
    public function dynamic_pages(Request $request, $id = 0, $delete = null)
    {
        $pages = Category::all();
        return view('admins.dynamic_pages', compact('pages'));
    }
    public function msections(Request $request, $id = 0, $delete = null)
    {
        $pages = DB::table('sections')->get();
        foreach ($pages as $k => $v) {
            $page = DB::table('pages')->where('pages.id', $v->menu)->first();
            if (isset($page->name)) {
                $v->menu = $page->name;
            } else {
                $v->menu = ' ';
            }
        }
        return view('admins.msections', compact('pages'));
    }

    public function setting(Request $request, $id = 0, $delete = null)
    {
        if ($request->isMethod('post')) {
            // dd($request);
            if ($request->hidden_id) {

                $setting = Setting::find($request->hidden_id);

                // if(isset($request->logo1)){
                //     $imageone = $request->logo1;
                //     $pimage_name = time().$imageone->getClientOriginalName();
                //     $imageone->move(public_path('/images/'),$pimage_name);
                //     $setting->logo1 = 'images/'.$pimage_name;
                // }

                if ($request->hasFile('logo1')) {
                    $file = $request->file('logo1');
                    $extension = $file->getClientOriginalExtension();
                    $extension = 'webp';
                    // Rename the file with a new extension
                    $name = time() . '.' . $extension;

                    // Move the uploaded file to the desired directory
                    $file->move(public_path('images/'), $name);

                    $setting['logo1'] = 'images/' . $name;
                }

                if ($request->hasFile('logo')) {
                    $file = $request->file('logo');
                    $extension = $file->getClientOriginalExtension();
                    $extension = 'webp';
                    // Rename the file with a new extension
                    $name = time() . '.' . $extension;

                    // Move the uploaded file to the desired directory
                    $file->move(public_path('images/'), $name);

                    $setting['logo'] = 'images/' . $name;
                }

                if ($request->hasFile('homepage_image_one')) {
                    $file = $request->file('homepage_image_one');
                    $extension = $file->getClientOriginalExtension();
                    $extension = 'webp';
                    // Rename the file with a new extension
                    $name = time() . '.' . $extension;

                    // Move the uploaded file to the desired directory
                    $file->move(public_path('images/'), $name);

                    $setting['homepage_image_one'] = 'images/' . $name;
                }

                if ($request->hasFile('homepage_image_two')) {
                    $file = $request->file('homepage_image_two');
                    $extension = $file->getClientOriginalExtension();
                    $extension = 'webp';
                    // Rename the file with a new extension
                    $name = time() . '.' . $extension;

                    // Move the uploaded file to the desired directory
                    $file->move(public_path('images/'), $name);

                    $setting['homepage_image_two'] = 'images/' . $name;
                }

                if ($request->hasFile('homepage_image_3')) {
                    $file = $request->file('homepage_image_3');
                    $extension = $file->getClientOriginalExtension();
                    $extension = 'webp';
                    $name = time() . '.' . $extension;

                    // Move the uploaded file to the desired directory
                    $file->move(public_path('images/'), $name);

                    $setting['homepage_image_3'] = 'images/' . $name;
                }

                if ($request->hasFile('homepage_image_4')) {
                    $file = $request->file('homepage_image_4');
                    $extension = $file->getClientOriginalExtension();
                    $extension = 'webp';
                    // Rename the file with a new extension
                    $name = time() . '.' . $extension;

                    // Move the uploaded file to the desired directory
                    $file->move(public_path('images/'), $name);

                    $setting['homepage_image_4'] = 'images/' . $name;
                }

                $setting->email = $request->email;
                $setting->phone = $request->phone;
                $setting->site_title = $request->site_title;
                $setting->title = $request->title;
                $setting->description = $request->description;
                $setting->keywords = $request->keywords;
                $setting->min_order_value = $request->min_order_value;

                $setting->phonetwo = $request->phonetwo;
                $setting->instagram = $request->instagram;
                $setting->shipping_time = $request->shipping_time;
                $setting->currency = $request->currency;
                $setting->shipping = $request->shipping;
                $tax = Vat::where('id', $request->tax_value)->first();
                $setting->tax_id = $request->tax_value;
                $setting->tax_value = $tax->tax_value;

                $setting->homepage_footer = $request->homepage_footer;
                $setting->footer_text = $request->footer;
                $setting->stripe_public_key = $request->stripe_public_key;
                $setting->stripe_secret_key = $request->stripe_secret_key;
                $setting->smtp_host = $request->smtp_host;
                $setting->smtp_port = $request->smtp_port;
                $setting->smtp_username = $request->smtp_username;
                $setting->smtp_password = $request->smtp_password;
                $setting->smtp_encryption = $request->smtp_encryption;
                $setting->smtp_from_email = $request->smtp_from_email;
                $setting->smtp_from_name = $request->smtp_from_name;
                $setting->save();

                // $this->updateEnv([
                //     'STRIPE_KEY' => $request->stripe_public_key,
                //     'STRIPE_SECRET' => $request->stripe_secret_key,
                //     'MAIL_HOST' => $request->smtp_host,
                //     'MAIL_PORT' => $request->smtp_port,
                //     'MAIL_USERNAME' => $request->smtp_username,
                //     'MAIL_PASSWORD' => $request->smtp_password,
                //     'MAIL_ENCRYPTION' => $request->smtp_encryption,
                //     'MAIL_FROM_ADDRESS' => $request->smtp_from_email,
                //     'MAIL_FROM_NAME' => $request->smtp_from_name,
                // ]);
                return redirect(route('admins.setting'))->with([
                    'msg' => 'Setting Saved Successfully',
                    'msg_type' => 'success',
                ]);
            }
        }

        $edit = Setting::where('id', '=', '1')->first();
        return view('admins.setting', compact('edit'));
    }

    protected function updateEnv(array $data)
    {
        $envPath = base_path('.env');
        if (file_exists($envPath)) {
            foreach ($data as $key => $value) {
                $escaped = preg_quote('=' . env($key), '/');
                file_put_contents($envPath, preg_replace(
                    "/^{$key}{$escaped}/m",
                    "{$key}={$value}",
                    file_get_contents($envPath)
                ));
            }
        }
    }

    public function learn_setting(Request $request, $id = 0, $delete = null)
    {
        if ($request->isMethod('post')) {
            // dd($request);
            if ($request->hidden_id) {

                $setting = Learn_setting::find($request->hidden_id);

                if (isset($request->learn_img_1)) {
                    $imageone = $request->learn_img_1;
                    $pimage_name = time() . $imageone->getClientOriginalName();
                    $imageone->move(public_path('/images/'), $pimage_name);
                    $setting->learn_img_1 = 'images/' . $pimage_name;
                }

                if (isset($request->learn_img_2)) {
                    $imageone = $request->learn_img_2;
                    $pimage_name = time() . $imageone->getClientOriginalName();
                    $imageone->move(public_path('/images/'), $pimage_name);
                    $setting->learn_img_2 = 'images/' . $pimage_name;
                }

                if (isset($request->learn_img_3)) {
                    $imageone = $request->learn_img_3;
                    $pimage_name = time() . $imageone->getClientOriginalName();
                    $imageone->move(public_path('/images/'), $pimage_name);
                    $setting->learn_img_3 = 'images/' . $pimage_name;
                }

                $setting->p_1 = $request->p_1;
                $setting->p2 = $request->p2;
                $setting->p3 = $request->p3;
                $setting->p4 = $request->p4;
                $setting->p5 = $request->p5;
                $setting->p6 = $request->p6;

                $setting->save();
            }
        }

        $edit = Learn_setting::where('id', '=', '1')->first();
        return view('admins.learn_setting', compact('edit'));
    }

    public function orders(Request $request)
    {
        $orders = Order::where('dstatus', '0')->orderBy('id', 'DESC')->get();
        return view('admins.orders', compact('orders'));
    }
    public function delete_order(Request $request)
    {
        $ids = $request->input('id', []);

        Order::whereIn('id', $ids)->delete();
        return redirect()->back()->with([
            'msg' => 'Selected records deleted successfully.',
            'msg_type' => 'success',
        ]);
    }
    public function delete_review(Request $request)
    {
        $ids = $request->input('id', []);

        Rating::whereIn('id', $ids)->delete();
        return redirect()->back()->with([
            'msg' => 'Selected records deleted successfully.',
            'msg_type' => 'success',
        ]);
    }
    public function delete_contact(Request $request)
    {
        $ids = $request->input('id', []);

        Contact::whereIn('id', $ids)->delete();
        return redirect()->back()->with([
            'msg' => 'Selected records deleted successfully.',
            'msg_type' => 'success',
        ]);
    }
    public function contact(Request $request)
    {
        $type = $request->type;
        // No eager load needed for the page shell; DataTables will fetch
        return view('admins.contact', compact('type'));
    }

    public function contactDataTable(Request $request)
    {
        $type   = $request->query('type');     // required
        $period = $request->query('period');   // today|this_week|this_month|last_7|last_30|all (optional)
        $from   = $request->query('from');     // optional custom start (YYYY-MM-DD)
        $to     = $request->query('to');       // optional custom end (YYYY-MM-DD)

        [$start, $end] = $this->resolvePeriodBounds($period, $from, $to);

        $query = Contact::where('contact_type', $type)
            ->select('id', 'name', 'email', 'phone', 'meg', 'created_at')
            ->when($start, fn($q) => $q->where('created_at', '>=', $start))
            ->when($end,   fn($q) => $q->where('created_at', '<',  $end))
            ->orderByDesc('id');

        return DataTables::of($query)
            ->addColumn(
                'checkbox',
                fn($row) =>
                '<input type="checkbox" class="emp_checkbox" value="' . $row->id . '" name="id[]">'
            )
            ->addColumn('actions', function ($row) {
                return '
                <a href="tel:' . e($row->phone ?? '#') . '" class="btn btn-primary btn-sm action-btn" title="Call">
                    <i class="fa fa-phone"></i>
                </a>
                <a href="https://wa.me/' . e($row->phone ?? '') . '" target="_blank" class="btn btn-success btn-sm action-btn" title="WhatsApp">
                    <i class="fa fa-whatsapp"></i>
                </a>
                <button type="button" class="btn btn-info btn-sm action-btn reply-btn" 
                        data-id="' . e($row->id) . '"
                        data-email="' . e($row->email) . '"
                        data-name="' . e($row->name) . '"
                        title="Reply">
                    <i class="fa fa-envelope"></i>
                </button>
                <a data-href="' . route('admins.meg_delete', ['id' => $row->id]) . '"
                   class="btn btn-danger btn-sm delete_record1 action-btn" 
                   href="javascript:void(0)" 
                   data-id="' . e($row->id) . '"
                   title="Delete">
                    <i class="fa fa-times"></i>
                </a>';
            })
            ->editColumn('meg', fn($row) => Str::limit($row->meg, 100000))
            ->editColumn('phone', fn($row) => $row->phone ?? 'N/A')
            ->editColumn('created_at', fn($row) => $row->created_at->format('Y-m-d H:i:s'))
            ->rawColumns(['checkbox', 'actions'])
            ->make(true);
    }

    public function countContactSpam(Request $request)
    {
        $request->validate(['type' => 'required|string']);
        [$pattern, $keywords] = $this->spamPattern();

        $count = Contact::where('contact_type', $request->string('type'))
            ->where(function ($q) use ($pattern, $keywords) {
                // Postgres case-insensitive regex for URLs
                $q->where('name', '~*', $pattern)
                    // Keywords with ILIKE (Postgres-only, case-insensitive)
                    ->orWhere(function ($qq) use ($keywords) {
                        foreach ($keywords as $kw) {
                            $qq->orWhere('name', 'ILIKE', "%{$kw}%");
                        }
                    });
            })
            ->count();

        return response()->json(['success' => true, 'count' => $count]);
    }

    public function clearContactSpam(Request $request)
    {
        $request->validate(['type' => 'required|string']);
        [$pattern, $keywords] = $this->spamPattern();

        $deleted = Contact::where('contact_type', $request->string('type'))
            ->where(function ($q) use ($pattern, $keywords) {
                $q->where('name', '~*', $pattern)
                    ->orWhere(function ($qq) use ($keywords) {
                        foreach ($keywords as $kw) {
                            $qq->orWhere('name', 'ILIKE', "%{$kw}%");
                        }
                    });
            })
            ->delete();

        return response()->json([
            'success' => true,
            'deleted' => $deleted,
            'message' => "Removed {$deleted} spam message(s).",
        ]);
    }

    private function spamPattern(): array
    {
        $urlRegex = '(https?://|www\\.)';

        $keywords = [
            'ссылке',
            'уже',
            'денежн',
            'вас!',
            'ваша',
            'вы выиграли',
            'выигрыш',
            'подарок',
            'сюрприз',
            'путёвка',
            'выиграй',
            'взять приз',
            'узнайте больше',
            '***',
        ];

        return [$urlRegex, $keywords];
    }

    private function resolvePeriodBounds(?string $period, ?string $from, ?string $to): array
    {
        if ($from && $to) {
            $start = Carbon::parse($from)->startOfDay();
            $end   = Carbon::parse($to)->addDay()->startOfDay(); // exclusive
            return [$start, $end];
        }

        $todayStart = Carbon::today();
        $now        = Carbon::now();

        return match ($period) {
            'today'     => [$todayStart, $todayStart->copy()->addDay()],
            'this_week' => [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()->addDay()->startOfDay()],
            'this_month' => [Carbon::now()->startOfMonth(), Carbon::now()->copy()->startOfMonth()->addMonth()],
            'last_7'    => [$now->copy()->subDays(7)->startOfDay(), $now->copy()->addDay()->startOfDay()],
            'last_30'   => [$now->copy()->subDays(30)->startOfDay(), $now->copy()->addDay()->startOfDay()],
            default     => [null, null], // 'all' or missing => no bounds
        };
    }

    public function sendContactReply(Request $request)
    {
        try {
            $contact = Contact::findOrFail($request->contact_id);

            $to_name = $contact->name;
            $to_email = $request->to_email;
            $data = [
                'name' => (string) $to_name,
                'to_email' => (string) $to_email,
                'phone' => $contact->phone ? (string) $contact->phone : 'N/A',
                'reply_message' => (string) $request->message, // Renamed to avoid conflict
                'original_message' => (string) $contact->meg,
                'submitted_at' => $contact->created_at->format('Y-m-d H:i:s')
            ];

            Mail::send('emails.contact_reply', $data, function ($msg) use ($to_name, $to_email) {
                $msg->to($to_email, $to_name)
                    ->subject('Response to Your Inquiry');
                $msg->from(config('mail.from.address'), config('mail.from.name'));
            });

            return response()->json(['success' => true]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Email not sent due to technical reasons',
                'error' => $th->getMessage(),
                'error_details' => [
                    'file' => $th->getFile(),
                    'line' => $th->getLine(),
                    'trace' => $th->getTraceAsString()
                ]
            ], 500);
        }
    }
    public function complete_orders(Request $request)
    {
        $orders = Order::where('dstatus', '1')->orderBy('id', 'DESC')->get();
        return view('admins.corder', compact('orders'));
    }

    public function deliverd_orders(Request $request)
    {
        $orders = Order::where('dstatus', '2')->orderBy('id', 'DESC')->get();
        return view('admins.deorder', compact('orders'));
    }

    public function canceled_orders(Request $request)
    {
        $orders = Order::where('dstatus', '3')->orderBy('id', 'DESC')->get();
        return view('admins.caorder', compact('orders'));
    }

    public function dispatched_orders(Request $request)
    {
        $orders = Order::where('dstatus', '4')->orderBy('id', 'DESC')->get();
        return view('admins.dorder', compact('orders'));
    }
    public function dreft_orders(Request $request)
    {
        $orders = Order::where('dstatus', '5')->orderBy('id', 'DESC')->get();
        return view('admins.drorder', compact('orders'));
    }


    public function product_form(Request $request, $id = 0)
    {
        try {
            //  dd($request);
            $edit = null;
            if ($request->isMethod('post')) {

                if ($request->product_color !== null) {
                    if (count($request->product_color) > 1) {
                        $allcolors = implode(",", $request->product_color);
                    } else {
                        // $allcolors = $request->colors;
                        $allcolors = implode(",", $request->product_color);
                    }
                } else {
                    $allcolors = '';
                }
                if ($request->product_size !== null) {

                    if (count($request->product_size) > 1) {
                        $product_sizes = implode(",", $request->product_size);
                    } else {
                        $product_sizes = implode(",", $request->product_size);
                    }
                } else {
                    $product_sizes = '';
                }

                if ($request->ingredient !== null) {

                    if (count($request->ingredient) > 1) {
                        $ingredients = implode(",", $request->ingredient);
                    } else {
                        $ingredients = implode(",", $request->ingredient);
                    }
                } else {
                    $ingredients = '';
                }

                if ($request->allergen !== null) {

                    if (count($request->allergen) > 1) {
                        $allergens = implode(",", $request->allergen);
                    } else {
                        $allergens = implode(",", $request->allergen);
                    }
                } else {
                    $allergens = '';
                }

                $home_cats = '';
                if ($request->home_cats !== null) {
                    if (count($request->home_cats) > 1) {
                        $home_cats = implode(",", $request->home_cats);
                    } else {
                        // $allcolors = $request->colors;
                        $home_cats = implode(",", $request->home_cats);
                    }
                } else {
                    $home_cats = '';
                }

                if ($request->category_id !== null) {

                    if (count($request->category_id) > 1) {
                        $cats = implode(",", $request->category_id);
                    } else {
                        $cats = implode(",", $request->category_id);
                    }
                } else {
                    $cats = '';
                }

                if ($request->theme_id !== null) {

                    if (count($request->theme_id) > 1) {
                        $theme_id = implode(",", $request->theme_id);
                    } else {
                        $theme_id = implode(",", $request->theme_id);
                    }
                } else {
                    $theme_id = '';
                }

                if ($request->hidden_id) {
                    // dd($_REQUEST);
                    $product = Product::find($request->hidden_id);

                    // Capture old values
                    $oldValues = [];
                    $newValues = [];

                    // Get original attributes before changes
                    $originalAttributes = $product->getAttributes();

                    if ($request->has('thumb_base64')) {
                        $imageData = $request->input('thumb_base64');

                        list($type, $data) = explode(';', $imageData);
                        list(, $data) = explode(',', $data);

                        $decodedImage = base64_decode($data);

                        $imageName = uniqid() . '.webp';
                        $destinationPath = public_path('images/product-thumb/');

                        if (!file_exists($destinationPath)) {
                            mkdir($destinationPath, 0755, true);
                        }

                        $image = imagecreatefromstring($decodedImage);

                        if ($image !== false) {
                            imagewebp($image, $destinationPath . $imageName, 100); // 100 is the quality (0-100)

                            imagedestroy($image);

                            $product['thumb'] = 'images/product-thumb/' . $imageName;
                        }
                    }

                    if ($request->has('image_one_base64')) {
                        $imageData = $request->input('image_one_base64');

                        list($type, $data) = explode(';', $imageData);
                        list(, $data) = explode(',', $data);

                        $decodedImage = base64_decode($data);

                        $imageName = uniqid() . '.webp';
                        $destinationPath = public_path('images/products/');

                        if (!file_exists($destinationPath)) {
                            mkdir($destinationPath, 0755, true);
                        }

                        $image = imagecreatefromstring($decodedImage);

                        if ($image !== false) {
                            imagewebp($image, $destinationPath . $imageName, 100);

                            imagedestroy($image);

                            $product['image_one'] = 'images/products/' . $imageName;
                        }
                    }
                    // if ($request->hasFile('thumb')) {
                    //     // if (!empty($product->thumb) && file_exists(public_path($product->thumb))) {
                    //     //     unlink(public_path($product->thumbali));
                    //     // }
                    //     $file = $request->file('thumb');
                    //     $extension = 'webp';
                    //     $image_name = $product->slug;
                    //     $name = time() . '.' . $extension;
                    //     $destinationPath = public_path('/images/product-thumb/');
                    //     if (!file_exists($destinationPath)) {
                    //         mkdir($destinationPath, 0755, true);
                    //     }
                    //     $image = Image::make($file);
                    //     $image->save($destinationPath . $name);
                    //     $product['thumb'] = 'images/product-thumb/' . $name;
                    // }

                    // if ($request->hasFile('image_one')) {
                    //     // if (!empty($product->thumb) && file_exists(public_path($product->image_one))) {
                    //     //     unlink(public_path($product->image_one));
                    //     // }
                    //     $file = $request->file('image_one');
                    //     $extension = 'webp';
                    //     $image_name = $product->slug;
                    //     $name = time() . '.' . $extension;
                    //     $destinationPath = public_path('/images/products/');
                    //     if (!file_exists($destinationPath)) {
                    //         mkdir($destinationPath, 0755, true);
                    //     }
                    //     $image = Image::make($file);
                    //     $image->save($destinationPath . $name);
                    //     $product['image_one'] = 'images/products/' . $name;
                    // }



                    if ($request->related_product_id !== null) {

                        if (count($request->related_product_id) > 1) {
                            $related_product_id = implode(",", $request->related_product_id);
                        } else {
                            $related_product_id = implode(",", $request->related_product_id);
                        }
                    } else {
                        $related_product_id = '';
                    }

                    if ($request->bundle_product_id !== null) {

                        if (count($request->bundle_product_id) > 1) {
                            $bundle_product_id = implode(",", $request->bundle_product_id);
                        } else {
                            $bundle_product_id = implode(",", $request->bundle_product_id);
                        }
                    } else {
                        $bundle_product_id = '';
                    }

                    $product->category_id = $cats;
                    $product->related_product_id = $related_product_id;
                    $product->bundle_product_id = $bundle_product_id;
                    $product->product_name = $request->product_name;
                    $product->product_details = $request->product_details;
                    $product->brand_id = $request->brand_id;
                    $product->product_color = $allcolors;
                    $product->product_size = $product_sizes;
                    $product->ingredient = $ingredients;
                    $product->ingredients_ar = $request->ingredients_ar;
                    $product->nutritions = $request->nutritions;
                    $product->ingredients = $request->ingredients;
                    $product->nutritions_ar = $request->nutritions_ar;
                    $product->product_description_ar = $request->product_description_ar;

                    $product->allergen = $allergens;
                    $product->product_type_id = $request->product_type_id;
                    $product->package_type_id = $request->package_type_id;
                    $product->theme_id = $theme_id;
                    $product->flavour_id = $request->flavour_id;
                    $product->shape = $request->shape;
                    $product->sku_no = $request->sku_no;
                    $product->article_number = $request->article_number;
                    $product->orignal_name = $request->orignal_name;
                    $product->type = $request->type;
                    $product->name_ar = $request->name_ar;
                    $product->sort_order = $request->sort_order;
                    $product->name_sw = $request->name_sw;
                    $product->b2c_price = $request->b2c_price;
                    $product->b2b_price = $request->b2b_price;
                    $product->b2d_price = $request->b2d_price;
                    $product->b2p = $request->b2p_price;
                    $product->basket_type_id = $request->basket_type_id;
                    $product->short_description = $request->short_discriiption;
                    $tags = preg_replace('/\s+/', '-', $request->tags);
                    $product->tags = $tags;
                    $product->shipping_price = $request->shipping_price;
                    $product->weight = $request->weight;
                    $product->total_weight = $request->total_weight;
                    $product->palm_oil = isset($request->palm_oil) ? 1 : 0;
                    $product->vegan = isset($request->vegan) ? 1 : 0;
                    $product->gelatin_free = isset($request->gelatin_free) ? 1 : 0;
                    $product->gluten_free = isset($request->gluten_free) ? 1 : 0;
                    $product->lactose_free = isset($request->lactose_free) ? 1 : 0;
                    $product->sustainability = isset($request->sustainability) ? 1 : 0;
                    $product->sku = $request->sku;
                    $product->weight_per_unit = $request->weight_per_unit;
                    $product->no_of_unit = $request->no_of_unit;
                    $product->product_code = $request->product_code;
                    // $product->slug = $request->slug;
                    // Capture old slug
                    $oldSlug = $product->slug;
                    $newSlug = $request->slug;

                    // Check if slug has changed
                    if ($oldSlug !== $newSlug && !empty($oldSlug)) {
                        // Save old slug to product_slug_redirects table
                        ProductSlugRedirect::create([
                            'product_id' => $product->id,
                            'old_slug' => $oldSlug,
                        ]);
                    }
                    if (isset($home_cats)) {
                        $product->home_cats = $home_cats;
                    } else {
                        $product->home_cats = '';
                    }

                    $product->product_quantity = $request->product_quantity;
                    $product->selling_price = $request->selling_price;
                    $product->discount_price = $request->discount_price;
                    $product->format = $request->format;
                    $product->country = $request->country;
                    $product->main_slider = isset($request->main_slider) ? 1 : 0;
                    $product->hot_deal = isset($request->hot_deal) ? 1 : 0;
                    $product->new_arrival = isset($request->New_Arrival) ? 1 : 0;
                    $product->featured = isset($request->Featured) ? 1 : 0;
                    $product->best_rated = isset($request->best_rated) ? 1 : 0;
                    $product->mid_slider = isset($request->mid_slider) ? 1 : 0;
                    $product->hot_new = isset($request->hot_new) ? 1 : 0;
                    $product->sale = isset($request->Sale) ? 1 : 0;
                    $product->status = 1;
                    $product->slug = $newSlug;

                    foreach ($originalAttributes as $key => $oldValue) {
                        if ($product->$key != $oldValue) {
                            $oldValues[$key] = $oldValue; // Store only changed old values
                            $newValues[$key] = $product->$key; // Store new values
                        }
                    }
                    // dd($request->short_discriiption);
                    $product->save();

                    $logs = new LogReport();

                    $changes = [
                        'old' => $oldValues,
                        'new' => $newValues, // Only changed attributes
                    ];

                    $data = [
                        'type' => 'PRODUCT',
                        'type_id' => $product->id,
                        'message' => 'The product:<b>' . $product->product_name . '</b> has been updated by user:<b>' . Auth::guard('admin')->user()->name . '</b>',
                        'user_id' => Auth::guard('admin')->user()->id,
                        'ip_address' => $_SERVER['REMOTE_ADDR'] ?? request()->ip(),
                        'url' => request()->fullUrl(),
                        'method' => request()->method(),
                        'changes' => json_encode($changes, JSON_UNESCAPED_UNICODE),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                    $logs->addLog($data);

                    if ($request->hasFile('gallary_images')) {
                        foreach ($request->file('gallary_images') as $image) {
                            $extension = $image->getClientOriginalExtension();
                            $extension = 'webp';
                            $image_name = $product->slug;
                            $filename = $image_name . '_' . uniqid() . '.' . $extension;

                            $image->move(public_path('gallery/'), $filename);

                            Gallerie::create([
                                'product_id' => $request->hidden_id,
                                'photo' => '/gallery/' . $filename,
                            ]);
                        }
                    }

                    $seo = ProductsToMeta::where('pid', '=', $request->hidden_id)->first();
                    if ($seo !== null) {
                        $seo->title = $request->stitle;
                        $seo->description = $request->sdescription;
                        $seo->keywords = $request->skeywords;
                        $seo->save();
                    } else {
                        $seo = new ProductsToMeta;
                        $seo['title'] = $request->stitle;
                        $seo['description'] = $request->sdescription;
                        $seo['keywords'] = $request->skeywords;
                        $seo['pid'] = $request->hidden_id;
                        $seo->save();
                    }
                } else {
                    // dd($request);
                    $product = new Product();

                    if ($request->has('thumb_base64')) {
                        $imageData = $request->input('thumb_base64');

                        list($type, $data) = explode(';', $imageData);
                        list(, $data) = explode(',', $data);

                        $decodedImage = base64_decode($data);

                        $imageName = uniqid() . '.webp';
                        $destinationPath = public_path('images/product-thumb/');

                        if (!file_exists($destinationPath)) {
                            mkdir($destinationPath, 0755, true);
                        }

                        $image = imagecreatefromstring($decodedImage);

                        if ($image !== false) {
                            imagewebp($image, $destinationPath . $imageName, 100); // 100 is the quality (0-100)

                            imagedestroy($image);

                            $product['thumb'] = 'images/product-thumb/' . $imageName;
                        }
                    }

                    if ($request->has('image_one_base64')) {
                        $imageData = $request->input('image_one_base64');

                        list($type, $data) = explode(';', $imageData);
                        list(, $data) = explode(',', $data);

                        $decodedImage = base64_decode($data);

                        $imageName = uniqid() . '.webp';
                        $destinationPath = public_path('images/products/');

                        if (!file_exists($destinationPath)) {
                            mkdir($destinationPath, 0755, true);
                        }

                        $image = imagecreatefromstring($decodedImage);

                        if ($image !== false) {
                            imagewebp($image, $destinationPath . $imageName, 100);

                            imagedestroy($image);

                            $product['image_one'] = 'images/products/' . $imageName;
                        }
                    }


                    // if ($request->hasFile('thumb')) {
                    //     // if (!empty($product->thumb) && file_exists(public_path($product->thumb))) {
                    //     //     unlink(public_path($product->thumbali));
                    //     // }
                    //     $file = $request->file('thumb');
                    //     $extension = 'webp';
                    //     $image_name = $product->slug;
                    //     $name = time() . '.' . $extension;
                    //     $destinationPath = public_path('/images/product-thumb/');
                    //     if (!file_exists($destinationPath)) {
                    //         mkdir($destinationPath, 0755, true);
                    //     }
                    //     $image = Image::make($file);
                    //     $image->save($destinationPath . $name);
                    //     $product['thumb'] = 'images/product-thumb/' . $name;
                    // }

                    // if ($request->hasFile('image_one')) {
                    //     // if (!empty($product->thumb) && file_exists(public_path($product->image_one))) {
                    //     //     unlink(public_path($product->image_one));
                    //     // }
                    //     $file = $request->file('image_one');
                    //     $extension = 'webp';
                    //     $image_name = $product->slug;
                    //     $name = time() . '.' . $extension;
                    //     $destinationPath = public_path('/images/products/');
                    //     if (!file_exists($destinationPath)) {
                    //         mkdir($destinationPath, 0755, true);
                    //     }
                    //     $image = Image::make($file);
                    //     $image->save($destinationPath . $name);
                    //     $product['image_one'] = 'images/products/' . $name;
                    // }


                    if ($request->category_id !== null) {

                        if (count($request->category_id) > 1) {
                            $cats = implode(",", $request->category_id);
                        } else {
                            $cats = implode(",", $request->category_id);
                        }
                    } else {
                        $cats = '';
                    }

                    if ($request->product_color !== null) {
                        if (count($request->product_color) > 1) {
                            $allcolors = implode(",", $request->product_color);
                        } else {
                            // $allcolors = $request->colors;
                            $allcolors = implode(",", $request->product_color);
                        }
                    } else {
                        $allcolors = '';
                    }
                    if ($request->product_size !== null) {

                        if (count($request->product_size) > 1) {
                            $product_sizes = implode(",", $request->product_size);
                        } else {
                            $product_sizes = implode(",", $request->product_size);
                        }
                    } else {
                        $product_sizes = '';
                    }

                    if ($request->ingredient !== null) {

                        if (count($request->ingredient) > 1) {
                            $ingredients = implode(",", $request->ingredient);
                        } else {
                            $ingredients = implode(",", $request->ingredient);
                        }
                    } else {
                        $ingredients = '';
                    }

                    if ($request->allergen !== null) {

                        if (count($request->allergen) > 1) {
                            $allergens = implode(",", $request->allergen);
                        } else {
                            $allergens = implode(",", $request->allergen);
                        }
                    } else {
                        $allergens = '';
                    }

                    if ($request->related_product_id !== null) {

                        if (count($request->related_product_id) > 1) {
                            $related_product_id = implode(",", $request->related_product_id);
                        } else {
                            $related_product_id = implode(",", $request->related_product_id);
                        }
                    } else {
                        $related_product_id = '';
                    }

                    if ($request->bundle_product_id !== null) {

                        if (count($request->bundle_product_id) > 1) {
                            $bundle_product_id = implode(",", $request->bundle_product_id);
                        } else {
                            $bundle_product_id = implode(",", $request->bundle_product_id);
                        }
                    } else {
                        $bundle_product_id = '';
                    }
                    if ($request->theme_id !== null) {

                        if (count($request->theme_id) > 1) {
                            $theme_id = implode(",", $request->theme_id);
                        } else {
                            $theme_id = implode(",", $request->theme_id);
                        }
                    } else {
                        $theme_id = '';
                    }
                    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->product_name)));
                    $originalSlug = $slug;
                    $count = 1;

                    while (Product::where('slug', $slug)->exists()) {
                        $slug = $originalSlug . '-' . $count;
                        $count++;
                    }

                    $product->slug = $slug;

                    $product->category_id = $cats;
                    $product->related_product_id = $related_product_id;
                    $product->bundle_product_id = $bundle_product_id;
                    $product->product_name = $request->product_name;
                    $product->product_details = $request->product_details;
                    $product->short_description = $request->short_discriiption;
                    $tags = preg_replace('/\s+/', '-', $request->tags);
                    $product->tags = $tags;
                    $product->shipping_price = $request->shipping_price;
                    if (isset($home_cats)) {
                        $product->home_cats = $home_cats;
                    } else {
                        $product->home_cats = '';
                    }

                    $product->product_quantity = $request->product_quantity;
                    $product->brand_id = $request->brand_id;
                    $product->product_color = $allcolors;
                    $product->product_size = $product_sizes;
                    $product->ingredient = $ingredients;
                    $product->allergen = $allergens;
                    $product->product_type_id = $request->product_type_id;
                    $product->package_type_id = $request->package_type_id;
                    $product->theme_id = $theme_id;
                    $product->flavour_id = $request->flavour_id;
                    $product->shape = $request->shape;
                    $product->sku_no = $request->sku_no;
                    $product->article_number = $request->article_number;
                    $product->orignal_name = $request->orignal_name;
                    $product->nutritions = $request->nutritions;
                    $product->type = $request->type;
                    $product->ingredients_ar = $request->ingredients_ar;
                    $product->ingredients = $request->ingredients;
                    $product->nutritions_ar = $request->nutritions_ar;
                    $product->product_description_ar = $request->product_description_ar;
                    $product->sort_order = $request->sort_order;
                    $product->name_ar = $request->name_ar;
                    $product->name_sw = $request->name_sw;
                    $product->b2c_price = $request->b2c_price;
                    $product->b2b_price = $request->b2b_price;
                    $product->b2d_price = $request->b2d_price;
                    $product->b2p = $request->b2p_price;
                    $product->basket_type_id = $request->basket_type_id;
                    $product->selling_price = $request->selling_price;
                    $product->discount_price = $request->discount_price;
                    $product->weight = $request->weight;
                    $product->total_weight = $request->total_weight;
                    $product->weight_per_unit = $request->weight_per_unit;
                    $product->no_of_unit = $request->no_of_unit;
                    $product->palm_oil = isset($request->palm_oil) ? 1 : 0;
                    $product->vegan = isset($request->vegan) ? 1 : 0;
                    $product->gelatin_free = isset($request->gelatin_free) ? 1 : 0;
                    $product->gluten_free = isset($request->gluten_free) ? 1 : 0;
                    $product->lactose_free = isset($request->lactose_free) ? 1 : 0;
                    $product->sustainability = isset($request->sustainability) ? 1 : 0;
                    $product->format = $request->format;
                    $product->sku = $request->sku;
                    $product->product_code = $request->product_code;
                    $product->country = $request->country;
                    $product->main_slider = isset($request->main_slider) ? 1 : 0;
                    $product->hot_deal = isset($request->hot_deal) ? 1 : 0;
                    $product->new_arrival = isset($request->New_Arrival) ? 1 : 0;
                    $product->featured = isset($request->Featured) ? 1 : 0;
                    $product->best_rated = isset($request->best_rated) ? 1 : 0;
                    $product->mid_slider = isset($request->mid_slider) ? 1 : 0;
                    $product->hot_new = isset($request->hot_new) ? 1 : 0;
                    $product->sale = isset($request->Sale) ? 1 : 0;
                    $product->status = 1;
                    $product->save();

                    $logs = new LogReport();

                    $data = [
                        'type' => 'PRODUCT',
                        'type_id' => $product->id,
                        'message' => 'The product:<b>' . $product->product_name . '</b> has been created by user:<b>' . Auth::guard('admin')->user()->name . '</b>',
                        'user_id' => Auth::guard('admin')->user()->id,
                        'ip_address' => $_SERVER['REMOTE_ADDR'] ?? request()->ip(),
                        'url' => request()->fullUrl(),
                        'method' => request()->method(),
                    ];
                    $logs->addLog($data);

                    $product->variations()->delete();

                    // Check if there are variations in the request
                    if ($request->has('variations')) {
                        foreach ($request->input('variations') as $variation) {
                            // Create a new ProductVariation
                            $productVariation = new ProductVariation([
                                'price' => $variation['price'],
                                'stock' => $variation['stock'],
                            ]);

                            // Save the variation to the product
                            $product->variations()->save($productVariation);

                            // Process the attributes for the variation
                            $attributes = explode(',', $variation['attributes']);
                            foreach ($attributes as $attributeNameValue) {
                                if (strpos($attributeNameValue, ':') !== false) {
                                    // Properly formatted as Name:Value
                                    [$attributeName, $attributeValue] = explode(':', $attributeNameValue, 2);
                                } else {
                                    // Handle unstructured input
                                    $attributeName = 'Default'; // Replace with your fallback
                                    $attributeValue = $attributeNameValue;
                                }

                                // Find or create the attribute
                                $attribute = Attribute::firstOrCreate(['name' => $attributeName]);

                                // Find or create the attribute value
                                $value = AttributeValue::firstOrCreate([
                                    'value' => $attributeValue,
                                    'attribute_id' => $attribute->id,
                                ]);

                                // Attach the attribute value to the product variation
                                $productVariation->attributes()->attach($value->id);
                            }

                            // Handle image upload for the variation
                            if (isset($variation['image']) && $variation['image'] instanceof UploadedFile) {
                                $imagePath = $variation['image']->store('product_variations', 'public');
                                $productVariation->update(['image' => $imagePath]);
                            }
                        }
                    }

                    $lastid = $product->id;
                    if ($request->hasFile('gallary_images')) {
                        foreach ($request->file('gallary_images') as $image) {
                            $extension = $image->getClientOriginalExtension();
                            $extension = 'webp';
                            $image_name = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->product_name)));
                            $filename = $image_name . '_' . uniqid() . '.' . $extension;

                            $image->move(public_path('gallery/'), $filename);

                            Gallerie::create([
                                'product_id' => $lastid,
                                'photo' => '/gallery/' . $filename,
                            ]);
                        }
                    }

                    $seo = new ProductsToMeta;
                    $seo['title'] = $request->stitle;
                    $seo['description'] = $request->sdescription;
                    $seo['keywords'] = $request->skeywords;
                    $seo['pid'] = $lastid;
                    $seo->save();
                }
                return redirect(route('admins.products'))->with([
                    'msg' => 'Product Saved Successfully',
                    'msg_type' => 'success',
                ]);
            }
            $categories = Category::all();
            $subcategories = SubCategory::all();
            $brands = Brand::all();
            $products = Product::all();
            $rproducts = Product::all();
            $color = Colors::all();
            $size = Size::all();
            $theme = Theme::all();
            $flavour = Flavour::all();
            $product_type = ProductType::all();
            $package_type = PackageType::all();
            $basket_type = BasketType::all();
            $ingredient = Ingredient::all();
            $allergen = Allergen::all();
            $countries = Country::all();
            $format = Format::all();
            $shapes = Shape::all();
            $types = Type::all();
            $variations = [];
            $seo = [];
            if ($id > 0) {
                $edit = Product::findorFail($id);
                $seo = ProductsToMeta::where('pid', $id)->get();
            }

            return view('admins.product_form', compact('categories', 'shapes', 'types', 'subcategories', 'rproducts', 'countries', 'format', 'ingredient', 'allergen', 'brands', 'edit', 'seo', 'products', 'variations', 'color', 'size', 'theme', 'flavour', 'product_type', 'package_type', 'basket_type'));
        } catch (\Exception $e) {
            \Log::error('Error in product_form: ' . $e->getMessage());
            return redirect(route('admins.products'))->with([
                'msg' => 'An error occurred while saving the product. Please try again.',
                'msg_type' => 'error',
            ]);
        }
    }

    public function updateSortOrder(Request $request)
    {
        $product = Product::find($request->id);
        if ($product) {
            $product->sort_order = $request->sort_order;
            $product->save();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }

    public function productLogReport(Request $request)
    {
        $data = LogReport::where('type', 'PRODUCT')->orderBy('id', 'desc')->get();
        return view('admins.logs.products', compact('data'));
    }

    public function orderLogReport(Request $request)
    {
        $data = LogReport::where('type', 'ORDER')->orderBy('id', 'desc')->get();
        return view('admins.logs.orders', compact('data'));
    }

    // public function accounts(Request $request)
    // {
    //     $data = Customer::leftJoin('orders', 'customers.email', '=', 'orders.email')
    //         ->select('customers.*', \DB::raw('COUNT(orders.id) as order_count'), \DB::raw('SUM(orders.amount) as total_purchase_amount'))
    //         ->groupBy('customers.id')
    //         ->get();

    //     return view('admins.accounts', compact('data'));
    // }
    public function accounts(Request $request)
    {
        $query = Customer::leftJoin('orders', 'customers.email', '=', 'orders.email')
            ->select(
                'customers.*',
                \DB::raw('COUNT(orders.id) as order_count'),
                \DB::raw('SUM(orders.amount) as total_purchase_amount'),
                \DB::raw('MIN(orders.created_at) as first_purchase_date'),
                \DB::raw("COALESCE(customers.city, orders.city) as city"),
                \DB::raw("COALESCE(customers.country, orders.country) as country")
            )
            ->where(function ($query) {
                $query->whereNotNull('orders.id')
                    ->orWhere(function ($subQuery) {
                        $subQuery->whereNotNull('customers.email')
                            ->where('customers.email', '!=', '')
                            ->where('customers.email', 'LIKE', '%@%')
                            ->whereNotNull('customers.name')
                            ->where('customers.name', '!=', '')
                            ->whereRaw('LENGTH(customers.name) > 5')
                            ->whereRaw("customers.name !~ '^[a-zA-Z0-9]{6,}$'");
                    });
            });

        // Filters
        if ($request->filled('name')) {
            $query->where('customers.name', 'ILIKE', '%' . $request->name . '%');
        }

        if ($request->filled('email')) {
            $query->where('customers.email', 'ILIKE', '%' . $request->email . '%');
        }

        if ($request->filled('phone')) {
            $query->where('customers.phone', 'ILIKE', '%' . $request->phone . '%');
        }

        if ($request->filled('start_date')) {
            $query->where('orders.created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->where('orders.created_at', '<=', $request->end_date);
        }

        $data = $query->groupBy('customers.id', 'customers.city', 'customers.country', 'orders.city', 'orders.country')->get();

        return view('admins.accounts', compact('data'));
    }





    private function convertToWebp($sourcePath)
    {
        $image = imagecreatefromstring(file_get_contents($sourcePath));
        imagewebp($image, $sourcePath . '.webp', 80);
        imagedestroy($image);
    }

    public function page_form(Request $request, $id = 0)
    {

        $edit = null;
        if ($request->isMethod('post')) {
            if (isset($_REQUEST['section'])) {
                if (empty($request->name)) {
                    return back()->with([
                        'msg' => 'section name is Required!',
                        'msg_type' => 'danger',
                    ]);
                    if (empty($request->menu)) {
                        return back()->with([
                            'msg' => 'section Parent menu is Required!',
                            'msg_type' => 'danger',
                        ]);
                    }
                }
            } else {
                if (empty($_REQUEST['name'])) {

                    return back()->with([
                        'msg' => 'name field Required!',
                        'msg_type' => 'danger',
                    ]);
                }
            }

            if ($request->hidden_id) {
                if (isset($_REQUEST['section'])) {
                    $in = array(
                        'name' => $request->name,
                        'position' => $request->position,
                        'status' => $request->status,
                        'menu' => $request->menu,
                        'menu_type' => $request->menu_type,
                    );
                    $id = DB::table('sections')->where('id', $request->hidden_id)->update($in);
                    if ($id) {
                        return redirect(route('admins.msections'))->with([
                            'msg' => 'Section update Successfully',
                            'msg_type' => 'success',
                        ]);
                    }
                } else {
                    $page = Pages::find($request->hidden_id);
                    $page->name = $request->name;
                    $page->name_ar = $request->name_ar;
                    $page->slug = $request->slug;
                    $page->page_type = $request->input('page_type') ?: null;
                    $page->is_show_in_header = $request->is_show_in_header;
                    $page->sort_no = $request->sort_no;
                    $page->sub_title = $request->sub_title;
                    $page->sub_title_ar = $request->sub_title_ar;
                    // if ($request->page_image_one) {
                    //     $file = $request->page_image_one;

                    //     $name = time() . $file->getClientOriginalName();
                    //     $file->move(public_path('img/slider'), $name);
                    //     $page['page_image'] = $name;
                    // }

                    if ($request->hasFile('page_image_one')) {

                        $file = $request->file('page_image_one');
                        $extension = 'webp';
                        $name = time() . '.' . $extension;
                        $destinationPath = public_path('img/slider/');
                        if (!file_exists($destinationPath)) {
                            mkdir($destinationPath, 0755, true);
                        }
                        $image = Image::make($file);
                        $image->save($destinationPath . $name);
                        $page['page_image'] =  $name;
                    }
                    if ($request->icon_svg) {
                        $file = $request->icon_svg;

                        $name = time() . $file->getClientOriginalName();
                        $file->move(public_path('img/slider'), $name);
                        $page['icon_svg'] = $name;
                    }
                    $page->save();
                }
            } else {

                if (isset($_REQUEST['section'])) {
                    $in = array(
                        'name' => $request->name,
                        'position' => $request->position,
                        'status' => $request->status,
                        'menu' => $request->menu,
                    );
                    $id = DB::table('sections')->insert($in);
                    if ($id) {
                        return redirect(route('admins.msections'))->with([
                            'msg' => 'Section add Successfully',
                            'msg_type' => 'success',
                        ]);
                    }
                } else {
                    if (isset($_REQUEST['section'])) {
                        return back()->with([
                            'msg' => 'name field is Required!',
                            'msg_type' => 'danger',
                        ]);
                    }

                    $page = new Pages();
                    $page->name = $request->name;
                    $page->name_ar = $request->name_ar;
                    $page->slug = $request->slug;
                    $page->page_type = $request->input('page_type') ?: null;
                    $page->is_show_in_header = $request->is_show_in_header;
                    $page->sort_no = $request->sort_no;
                    $page->sub_title = $request->sub_title;
                    $page->sub_title_ar = $request->sub_title_ar;
                    if ($request->page_image_one) {
                        $file = $request->page_image_one;

                        $name = time() . $file->getClientOriginalName();
                        $file->move(public_path('img/slider'), $name);
                        $page['page_image'] = $name;
                    }
                    if ($request->icon_svg) {
                        $file = $request->icon_svg;

                        $name = time() . $file->getClientOriginalName();
                        $file->move(public_path('img/slider'), $name);
                        $page['icon_svg'] = $name;
                    }
                    $page->save();
                }
            }

            return redirect(route('admins.pages'))->with([
                'msg' => 'pages Saved Successfully',
                'msg_type' => 'success',
            ]);
        }
        $page = Pages::all();
        $sections = [];

        if (isset($_REQUEST['section'])) {
            if ($id > 0) {
                $edit = DB::table('sections')->where('sections.id', $id)->first();
            }
            return view('admins.section_form', compact('page', 'edit'));
        } else {
            if ($id > 0) {
                $edit = Pages::findorFail($id);
            }
            $categories = Category::all();
            // dd($categories);
            $products = Product::all();
            return view('admins.page_form', compact('page', 'edit', 'sections', 'categories', 'products'));
        }
        $categories = Category::all();
        $products = Product::all();
        return view('admins.page_form', compact('page', 'edit', 'categories', 'products'));
    }
    public function static_page_form(Request $request, $id = 0)
    {

        $edit = null;
        if ($request->isMethod('post')) {
            if (isset($_REQUEST['section'])) {
                if (empty($request->name)) {
                    return back()->with([
                        'msg' => 'section name is Required!',
                        'msg_type' => 'danger',
                    ]);
                    if (empty($request->menu)) {
                        return back()->with([
                            'msg' => 'section Parent menu is Required!',
                            'msg_type' => 'danger',
                        ]);
                    }
                }
            } else {
                if (empty($_REQUEST['name'])) {

                    return back()->with([
                        'msg' => 'name field Required!',
                        'msg_type' => 'danger',
                    ]);
                }
            }

            if ($request->hidden_id) {
                if (isset($_REQUEST['section'])) {
                    $in = array(
                        'name' => $request->name,
                        'name_ar' => $request->name_ar,
                        'position' => $request->position,
                        'status' => $request->status,
                        'menu' => $request->menu,
                        'menu_type' => $request->menu_type,
                    );
                    $id = DB::table('sections')->where('id', $request->hidden_id)->update($in);
                    if ($id) {
                        return redirect(route('admins.msections'))->with([
                            'msg' => 'Section update Successfully',
                            'msg_type' => 'success',
                        ]);
                    }
                } else {
                    $page = Pages::find($request->hidden_id);
                    $page->name = $request->name;
                    $page->name_ar = $request->name_ar;
                    $page->slug = $request->slug;
                    if ($request->page_image_one) {
                        $file = $request->page_image_one;

                        $name = time() . $file->getClientOriginalName();
                        $file->move(public_path('img/slider'), $name);
                        $page['page_image'] = $name;
                    }
                    $page->save();
                }
            } else {

                if (isset($_REQUEST['section'])) {
                    $in = array(
                        'name' => $request->name,
                        'position' => $request->position,
                        'status' => $request->status,
                        'menu' => $request->menu,
                    );
                    $id = DB::table('sections')->insert($in);
                    if ($id) {
                        return redirect(route('admins.msections'))->with([
                            'msg' => 'Section add Successfully',
                            'msg_type' => 'success',
                        ]);
                    }
                } else {
                    if (isset($_REQUEST['section'])) {
                        return back()->with([
                            'msg' => 'name field is Required!',
                            'msg_type' => 'danger',
                        ]);
                    }

                    $page = new Pages();
                    $page->name = $request->name;
                    $page->name_ar = $request->name_ar;
                    if ($request->page_image_one) {
                        $file = $request->page_image_one;

                        $name = time() . $file->getClientOriginalName();
                        $file->move(public_path('img/slider'), $name);
                        $page['page_image'] = $name;
                    }
                    $page->save();
                }
            }

            return redirect(route('admins.pages'))->with([
                'msg' => 'pages Saved Successfully',
                'msg_type' => 'success',
            ]);
        }
        $page = Pages::all();
        $sections = [];

        if (isset($_REQUEST['section'])) {
            if ($id > 0) {
                $edit = DB::table('sections')->where('sections.id', $id)->first();
            }
            return view('admins.section_form', compact('page', 'edit'));
        } else {
            if ($id > 0) {
                $edit = Pages::findorFail($id);
            }
            $categories = Category::all();
            // dd($categories);
            $products = Product::all();
            return view('admins.static_page_form', compact('page', 'edit', 'sections', 'categories', 'products'));
        }
        $categories = Category::all();
        $products = Product::all();
        return view('admins.static_page_form', compact('page', 'edit', 'categories', 'products'));
    }

    public function dynamic_page_form(Request $request, $id = 0, $delete = null)
    {
        // echo "<pre>";print_r($request->all());exit;
        $edit = null;
        $category_conditions = null;
        $seo = null;
        if (isset($delete) && $id > 0) {
            Category::find($id)->delete();
            CategoryCondition::where('category_id', $id)->forceDelete();
            return redirect(route('admins.category'))->with([
                'msg' => 'Category Deleted Successfully',
                'msg_type' => 'success',
            ]);
        }
        if ($id > 0 && !isset($delete)) {
            $edit = Category::find($id);
        }
        if ($request->isMethod('post')) {
            $hiddenId = $request->hidden_id ?? null;

            if ($request->has('hidden_id')) {

                $category = Category::find($request->hidden_id);

                if ($request->hasFile('banner')) {
                    $file = $request->file('banner');
                    $extension = $file->getClientOriginalExtension();
                    $extension = 'webp';
                    $name = time() . '_' . uniqid() . '.' . $extension;
                    $file->move(public_path('/images/category/'), $name);
                    $category['banner'] = 'images/category/' . $name;
                }
                $category->save();
            } else {

                $category = new Category();
                if ($request->hasFile('banner')) {
                    $file = $request->file('banner');
                    $extension = $file->getClientOriginalExtension();
                    $extension = 'webp';
                    $name = time() . '_' . uniqid() . '.' . $extension;
                    $file->move(public_path('/images/category/'), $name);
                    $category['banner'] = 'images/category/' . $name;
                }
                $category->save();
            }

            return redirect(route('admins.dynamic_pages'))->with([
                'msg' => 'Dynamic Page Saved Successfully',
                'msg_type' => 'success',
            ]);
        }

        $categories = Category::all();

        return view('admins.dynamic_page_form', compact('categories', 'edit'));
    }
    public function get_subCategory_html(Request $request)
    {
        $options = "";
        $categoryId = filter_var($request->input('category_id'), FILTER_VALIDATE_INT);
        if ($categoryId === false || $categoryId < 1) {
            echo $options;

            return;
        }
        $sub_categories = SubCategory::where('category_id', $categoryId)->get();
        $sub_cat_id = $request->sub_category_id;
        if (count($sub_categories) > 0) {
            foreach ($sub_categories as $sub_category) {
                $selected = $sub_cat_id > 0 && $sub_category->id == $sub_cat_id ? "selected" : null;
                $options .= '<option ' . $selected . ' value="' . $sub_category->id . '">' . $sub_category->name . '</option>';
            }
        }
        echo $options;
    }

    public function get_products(Request $request)
    {
        $searchItem = $request->searchTerm;
        $products = Product::where('status', '1')
            ->where('product_name', 'ILIKE', '%' . $searchItem . '%')
            ->get();
        $data = [];
        foreach ($products as $v) {
            $data[] = array("id" => $v['id'], "text" => $v['product_name']);
        }
        echo json_encode($data);
    }

    public function product_delete($id)
    {
        $product = Product::find($id);
        $img_one = public_path() . '/' . $product->image_one;
        if (\File::exists($img_one)) {
            \File::delete($img_one);
        }
        $img_two = public_path() . '/' . $product->image_two;
        if (\File::exists($img_two)) {
            \File::delete($img_two);
        }
        $img_three = public_path() . '/' . $product->image_three;
        if (\File::exists($img_three)) {
            \File::delete($img_three);
        }
        $product->delete();

        $logs = new LogReport();

        $oldValues = [];
        $newValues = [];
        $changes = [
            'old' => array_merge($oldValues, ['status' => 'active']), // Add custom "status" value
            'new' => array_merge($newValues, ['status' => 'delete']), // Add new custom "status"
        ];

        $data = [
            'type' => 'PRODUCT',
            'type_id' => $product->id,
            'message' => 'The product: <b>' . $product->product_name . '</b> has been deleted by user: <b>' . Auth::guard('admin')->user()->name . '</b>',
            'user_id' => Auth::guard('admin')->user()->id,
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? request()->ip(),
            'url' => request()->fullUrl(),
            'method' => request()->method(),
            'changes' => json_encode($changes, JSON_UNESCAPED_UNICODE),
            'created_at' => now(),
            'updated_at' => now(),
        ];

        $logs->addLog($data);

        return redirect(route('admins.products'))->with([
            'msg' => 'Product Deleted Successfully',
            'msg_type' => 'success',
        ]);
    }
    public function gallery_delete($id)
    {
        $gallery = Gallerie::find($id);
        $img_one = public_path() . '/gallery/' . $gallery->photo;
        if (\File::exists($img_one)) {
            \File::delete($img_one);
        }
        $gallery->delete();
        return redirect()->back()->with([
            'msg' => 'Gallery Image Deleted Successfully',
            'msg_type' => 'success',
        ]);
    }
    public function review_delete($id)
    {
        $product = Rating::find($id);
        $product->delete();
        return redirect(route('admins.review'))->with([
            'msg' => 'Review Deleted Successfully',
            'msg_type' => 'success',
        ]);
    }
    public function order_delete($id)
    {
        $product = Order::find($id);
        $product->delete();

        $logs = new LogReport();

        $oldValues = [];
        $newValues = [];
        $changes = [
            'old' => array_merge($oldValues, ['status' => 'active']), // Add custom "status" value
            'new' => array_merge($newValues, ['status' => 'delete']), // Add new custom "status"
        ];

        $data = [
            'type' => 'ORDER',
            'type_id' => $product->id,
            'message' => 'The order: <b>' . $product->order_no . '</b> has been deleted by user: <b>' . Auth::guard('admin')->user()->name . '</b>',
            'user_id' => Auth::guard('admin')->user()->id,
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? request()->ip(),
            'url' => request()->fullUrl(),
            'method' => request()->method(),
            'changes' => json_encode($changes, JSON_UNESCAPED_UNICODE),
            'created_at' => now(),
            'updated_at' => now(),
        ];

        $logs->addLog($data);

        return redirect(route('admins.orders'))->with([
            'msg' => 'Order Deleted Successfully',
            'msg_type' => 'success',
        ]);
    }
    public function meg_delete($id)
    {
        try {
            $contact = Contact::findOrFail($id);
            $contact->delete();

            return response()->json(['success' => true]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete the message: ' . $th->getMessage()
            ], 500);
        }
        // $product = Contact::find($id);
        // $product->delete();
        // return redirect(route('admins.contact'))->with([
        //     'msg' => 'Message Deleted Successfully',
        //     'msg_type' => 'success',
        // ]);
    }
    public function order_edit($id)
    {
        $edit = Order::findorFail($id);
        // echo "<pre>";print_r($edit);print_r($edit);exit;
        // $pro = Product::findorFail($edit->pid);
        $shippingMethods = ShippingMethod::all();
        // $logReport = LogReport::where('type', 'ORDER')->where('type_id', $id)->orderBy('id', 'desc')->get();
        return view('admins.edit_order', compact('edit', 'shippingMethods'));
    }

    public function draft_order_edit($id)
    {
        $edit = Order::findorFail($id);
        // echo "<pre>";print_r($edit);print_r($edit);exit;
        // $pro = Product::findorFail($edit->pid);
        $shippingMethods = ShippingMethod::all();
        // $logReport = LogReport::where('type', 'ORDER')->where('type_id', $id)->orderBy('id', 'desc')->get();
        return view('admins.draft_order_edit', compact('edit', 'shippingMethods'));
    }

    public function up_delivery_status(Request $request)
    {
        // echo "<pre>";print_r(Auth::guard('admin')->user()->id);exit;
        $order = Order::find($request->id);
        $oldValues = [];
        $newValues = [];
        $originalAttributes = $order->getAttributes();
        $shippng_company = '';
        if ($request->dstatus == 1) {

            if ($request->payment_status) {
                $order->payment_status = $request->payment_status;
            }
            $order->status = 1;
            $order->dstatus = $request->dstatus;

            $order->customer_name = $request->customer_name;
            $order->email = $request->email;
            $order->city = $request->city;
            $order->phone = $request->phone;
            $order->country = $request->country;
            $order->address = $request->address;
            $order->unit = $request->unit;

            // $order->shipping_company = $request->company;
            // $order->track_url = $request->track_url;
            // $order->track_no = $request->track_no;
            $order->note = $request->note;
            $shippng_company = $request->company;
            $datetime = Carbon::now('Asia/Dubai')->addMinutes(15);
            // Prepare API data
            if ($request->company == "Jeebly" && $order->track_no == '') {
                $data = [
                    "order_type" => "food and beverages",
                    "pickup_building" => "Store # MW012b dubai festival city mall 1st Floor",
                    "pickup_street" => "Dubai Festival City Mall",
                    "pickup_area" => "Dubai Festival City",
                    "pickup_city" => "Dubai",
                    "pickup_contact_phone_country_code" => "+971",
                    "pickup_contact_phone" => "42737018",
                    "destination_area" => $order->city . ($request->country ? "," . $request->country : "") ?? "",
                    "destination_building" => 'Apartment no ' . $order->unit,
                    "destination_street" => $request->address,
                    "destination_city" => $request->city ?? "",
                    "recipient_name" => $request->customer_name,
                    "recipient_contact_phone_country_code" => "+971",
                    "recipient_contact_phone" => $order->phone,
                    "payment_method" => $order->payment_method == 'cash_on_delivery' ? "COD" : "Prepaid",
                    "planned_start_time" => $datetime->format('Y-m-d H:i'),
                    "cod_amount" => $order->payment_method == 'cash_on_delivery' ? $order->amount : 0,
                    "no_of_packages" => 1,
                    "tip_amount" => 0,
                    "extra_info" => "Order",
                    "pick_lat" => "",
                    "pick_long" => "",
                    "drop_lat" => "",
                    "drop_long" => "",
                ];
                // echo "<pre>";print_r($data);exit;
                // Send POST request
                $response = Http::withHeaders([
                    'X-API-KEY' => env('JEELY_API_KEY'),
                    'client_key' => env('JEELY_CLIENT_KEY'),
                    'Content-Type' => 'application/json',
                ])->post(env('JEELY_API_URL'), $data);
                if ($response->successful()) {
                    $orderId = $response->json('Order Id'); // Extracts the "Order Id"]
                    $order->track_url = "https://myjeebly.jeebly.com/shipment-tracking/";
                    $order->track_no = $orderId;
                    $order->shipping_company = "Jeebly";
                } else {
                    $order->track_url = "";
                    $order->track_no = "";
                    return redirect(route('admins.orders'))->with([
                        'msg' => "Jeebly: " . $response->json('message'),
                        'msg_type' => 'danger',
                    ]);
                }
            } else {
                $order->shipping_company = $request->company;
                $order->track_url = $request->track_url;
                $order->track_no = $request->track_no;
            }

            foreach ($originalAttributes as $key => $oldValue) {
                if ($order->$key != $oldValue) {
                    $oldValues[$key] = $oldValue; // Store only changed old values
                    $newValues[$key] = $order->$key; // Store new values
                }
            }

            $order->save();

            $changes = [
                'old' => $oldValues,
                'new' => $newValues, // Only changed attributes
            ];

            $logs = new LogReport();

            $data = [
                'type' => 'ORDER',
                'type_id' => $order->id,
                'message' => 'The status of Order No:<b>' . $order->order_no . '</b> changed to <b>' . $this->getOrderStatus($order->dstatus) . '</b> by user:<b>' . Auth::guard('admin')->user()->name . '</b>',
                'user_id' => Auth::guard('admin')->user()->id,
                'ip_address' => $_SERVER['REMOTE_ADDR'] ?? request()->ip(),
                'url' => request()->fullUrl(),
                'method' => request()->method(),
                'changes' => json_encode($changes, JSON_UNESCAPED_UNICODE),
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $logs->addLog($data);
            $order_data = Order::where('id', $request->id)->get();
            if ($order_data) {
                $to_name = $order->name;
                $to_email = $order->email;
                $data = [
                    'order' => $order_data,

                ];
                if ($shippng_company == "letstango @newtek") {
                    $to_name = "letstango @newtek";
                    $to_email = "goodisetdeliveries@letstango.com";
                    try {
                        Mail::send('emails.assign_order', $data, function ($message) use ($to_name, $to_email) {
                            $message->to($to_email, $to_name)
                                ->subject('We have confirmed your order(s) and its ready for shipping.’');
                            $message->from(config('mail.from.address'), config('mail.from.name'));
                        });
                    } catch (\Throwable $th) {
                        return redirect(route('admins.complete_orders'))->with([
                            'msg' => 'Email not sent because of technical reasons. Other than that status is updated',
                            'msg_type' => 'danger',
                        ]);
                    }
                }
                try {
                    Mail::send('emails.p_order', $data, function ($message) use ($to_name, $to_email) {
                        $message->to($to_email, $to_name)
                            ->subject('We have confirmed your order(s) and its ready for shipping.’');
                        $message->from(config('mail.from.address'), config('mail.from.name'));
                    });
                } catch (\Throwable $th) {
                    return redirect(route('admins.complete_orders'))->with([
                        'msg' => 'Email not sent because of technical reasons. Other than that status is updated',
                        'msg_type' => 'danger',
                    ]);
                }
            }
            return redirect(route('admins.complete_orders'))->with([
                'msg' => 'Order Updated Successfully',
                'msg_type' => 'success',
            ]);
        } elseif ($request->dstatus == 2) {
            if ($request->payment_status) {
                $order->payment_status = $request->payment_status;
            }
            $order->status = 2;
            $order->dstatus = $request->dstatus;
            $order->customer_name = $request->customer_name;
            $order->email = $request->email;
            $order->city = $request->city;
            $order->phone = $request->phone;
            $order->country = $request->country;
            $order->address = $request->address;
            $order->unit = $request->unit;
            $order->shipping_company = $request->company;
            $order->track_url = $request->track_url;
            $order->track_no = $request->track_no;
            $order->note = $request->note;

            foreach ($originalAttributes as $key => $oldValue) {
                if ($order->$key != $oldValue) {
                    $oldValues[$key] = $oldValue; // Store only changed old values
                    $newValues[$key] = $order->$key; // Store new values
                }
            }

            $order->save();

            $changes = [
                'old' => $oldValues,
                'new' => $newValues, // Only changed attributes
            ];

            $logs = new LogReport();

            $data = [
                'type' => 'ORDER',
                'type_id' => $order->id,
                'message' => 'The status of Order No:<b>' . $order->order_no . '</b> changed to <b>' . $this->getOrderStatus($order->dstatus) . '</b> by user:<b>' . Auth::guard('admin')->user()->name . '</b>',
                'user_id' => Auth::guard('admin')->user()->id,
                'ip_address' => $_SERVER['REMOTE_ADDR'] ?? request()->ip(),
                'url' => request()->fullUrl(),
                'method' => request()->method(),
                'changes' => json_encode($changes, JSON_UNESCAPED_UNICODE),
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $logs->addLog($data);

            $logs->addLog($data);

            $order_data = Order::where('id', $request->id)->get();
            if ($order_data) {
                $to_name = $order->name;
                $to_email = $order->email;
                $data = [
                    'order' => $order_data,

                ];

                try {
                    Mail::send('emails.p_order', $data, function ($message) use ($to_name, $to_email) {
                        $message->to($to_email, $to_name)
                            ->subject('Your products are delivered.’');
                        $message->from(config('mail.from.address'), config('mail.from.name'));
                    });
                } catch (\Throwable $th) {
                    return redirect(route('admins.deliverd_orders'))->with([
                        'msg' => 'Email not sent because of technical reasons. Other than that status is updated',
                        'msg_type' => 'danger',
                    ]);
                }

                return redirect(route('admins.deliverd_orders'))->with([
                    'msg' => 'Order Updated Successfully',
                    'msg_type' => 'success',
                ]);
            }
        } elseif ($request->dstatus == 3) {
            try {
                if ($order->payment_method == 'stripe' || $order->payment_method == 'Card') {
                    Stripe::setApiKey(getSetting('stripe_secret_key'));

                    $refundParams = [];
                    if (substr($order->transaction_id, 0, 3) === 'pi_') {
                        $refundParams['payment_intent'] = $order->transaction_id;
                    } else {
                        $refundParams['charge'] = $order->transaction_id;
                    }

                    $refund = \Stripe\Refund::create($refundParams);

                    $order->payment_status = 'refunded';
                }
            } catch (ApiErrorException $e) {
                return redirect()->back()->with([
                    'msg' => 'Stripe Error: ' . $e->getMessage(),
                    'msg_type' => 'danger',
                ]);
            }

            if ($request->payment_status) {
                $order->payment_status = $request->payment_status;
            }

            $order->status = 3;
            $order->dstatus = $request->dstatus;
            $order->customer_name = $request->customer_name;
            $order->email = $request->email;
            $order->city = $request->city;
            $order->phone = $request->phone;
            $order->country = $request->country;
            $order->address = $request->address;
            $order->unit = $request->unit;
            $order->shipping_company = $request->company;
            $order->track_url = $request->track_url;
            $order->track_no = $request->track_no;
            $order->note = $request->note;

            foreach ($originalAttributes as $key => $oldValue) {
                if ($order->$key != $oldValue) {
                    $oldValues[$key] = $oldValue; // Store only changed old values
                    $newValues[$key] = $order->$key; // Store new values
                }
            }

            $order->save();

            $changes = [
                'old' => $oldValues,
                'new' => $newValues, // Only changed attributes
            ];

            // Prepare API data
            if (!empty($order->track_no)) {
                $data = [
                    "order_id" => $order->track_no,
                ];
                $response = Http::withHeaders([
                    'X-API-KEY' => env('JEELY_API_KEY'),
                    'client_key' => env('JEELY_CLIENT_KEY'),
                    'Content-Type' => 'application/json',
                ])->post(env('JEELY_CANCEL_API_URL'), $data);

                if ($response->successful()) {
                    $order->dstatus = 3;
                } else {
                    return redirect(route('admins.orders'))->with([
                        'msg' => "Jeebly: " . $response->json('message'),
                        'msg_type' => 'danger',
                    ]);
                }
            }

            $logs = new LogReport();

            $data = [
                'type' => 'ORDER',
                'type_id' => $order->id,
                'message' => 'The status of Order No:<b>' . $order->order_no . '</b> changed to <b>' . $this->getOrderStatus($order->dstatus) . '</b> by user:<b>' . Auth::guard('admin')->user()->name . '</b>',
                'user_id' => Auth::guard('admin')->user()->id,
                'ip_address' => $_SERVER['REMOTE_ADDR'] ?? request()->ip(),
                'url' => request()->fullUrl(),
                'method' => request()->method(),
                'changes' => json_encode($changes, JSON_UNESCAPED_UNICODE),
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $logs->addLog($data);

            $order_data = Order::where('id', $request->id)->get();
            if ($order_data) {
                $to_name = $order->name;
                $to_email = $order->email;
                $data = [
                    'order' => $order_data,

                ];

                try {
                    Mail::send('emails.p_order', $data, function ($message) use ($to_name, $to_email) {
                        $message->to($to_email, $to_name)
                            ->subject('Your Order Has Been Canceled');
                        $message->from(config('mail.from.address'), config('mail.from.name'));
                    });
                } catch (\Throwable $th) {
                    return redirect(route('admins.canceled_orders'))->with([
                        'msg' => 'Email not sent because of technical reasons. Other than that status is updated',
                        'msg_type' => 'danger',
                    ]);
                }
            }

            return redirect(route('admins.canceled_orders'))->with([
                'msg' => 'Order Updated Successfully',
                'msg_type' => 'success',
            ]);
        } elseif ($request->dstatus == 4) {

            if ($request->payment_status) {
                $order->payment_status = $request->payment_status;
            }

            $order->status = 4;
            $order->dstatus = $request->dstatus;
            $order->customer_name = $request->customer_name;
            $order->email = $request->email;
            $order->city = $request->city;
            $order->phone = $request->phone;
            $order->country = $request->country;
            $order->address = $request->address;
            $order->unit = $request->unit;

            $order->note = $request->note;

            foreach ($originalAttributes as $key => $oldValue) {
                if ($order->$key != $oldValue) {
                    $oldValues[$key] = $oldValue; // Store only changed old values
                    $newValues[$key] = $order->$key; // Store new values
                }
            }

            $order->save();

            $changes = [
                'old' => $oldValues,
                'new' => $newValues, // Only changed attributes
            ];

            $logs = new LogReport();

            $data = [
                'type' => 'ORDER',
                'type_id' => $order->id,
                'message' => 'The status of Order No:<b>' . $order->order_no . '</b> changed to <b>' . $this->getOrderStatus($order->dstatus) . '</b> by user:<b>' . Auth::guard('admin')->user()->name . '</b>',
                'user_id' => Auth::guard('admin')->user()->id,
                'ip_address' => $_SERVER['REMOTE_ADDR'] ?? request()->ip(),
                'url' => request()->fullUrl(),
                'method' => request()->method(),
                'changes' => json_encode($changes, JSON_UNESCAPED_UNICODE),
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $logs->addLog($data);

            $order_data = Order::where('id', $request->id)->get();
            if ($order_data) {
                $to_name = $order->name;
                $to_email = $order->email;
                $data = [
                    'order' => $order_data,

                ];

                try {
                    Mail::send('emails.p_order', $data, function ($message) use ($to_name, $to_email) {
                        $message->to($to_email, $to_name)
                            ->subject('Your Order is On The Way');
                        $message->from(config('mail.from.address'), config('mail.from.name'));
                    });
                } catch (\Throwable $th) {
                    return redirect(route('admins.dispatched_orders'))->with([
                        'msg' => 'Email not sent because of technical reasons. Other than that status is updated',
                        'msg_type' => 'danger',
                    ]);
                }
            }

            return redirect(route('admins.dispatched_orders'))->with([
                'msg' => 'Order Updated Successfully',
                'msg_type' => 'success',
            ]);
        } else {
            $order->status = 1;
            $order->dstatus = $request->dstatus;
            $order->customer_name = $request->customer_name;
            $order->email = $request->email;
            $order->city = $request->city;
            $order->phone = $request->phone;
            $order->country = $request->country;
            $order->address = $request->address;
            $order->unit = $request->unit;
            $order->shipping_company = $request->company;
            $order->track_url = $request->track_url;
            $order->track_no = $request->track_no;
            $order->note = $request->note;

            foreach ($originalAttributes as $key => $oldValue) {
                if ($order->$key != $oldValue) {
                    $oldValues[$key] = $oldValue; // Store only changed old values
                    $newValues[$key] = $order->$key; // Store new values
                }
            }

            $order->save();

            $changes = [
                'old' => $oldValues,
                'new' => $newValues, // Only changed attributes
            ];

            $logs = new LogReport();

            $data = [
                'type' => 'ORDER',
                'type_id' => $order->id,
                'message' => 'The status of Order No:<b>' . $order->order_no . '</b> changed to <b>' . $this->getOrderStatus($order->dstatus) . '</b> by user:<b>' . Auth::guard('admin')->user()->name . '</b>',
                'user_id' => Auth::guard('admin')->user()->id,
                'ip_address' => $_SERVER['REMOTE_ADDR'] ?? request()->ip(),
                'url' => request()->fullUrl(),
                'method' => request()->method(),
                'changes' => json_encode($changes, JSON_UNESCAPED_UNICODE),
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $logs->addLog($data);

            return redirect(route('admins.orders'))->with([
                'msg' => 'Order Updated Successfully',
                'msg_type' => 'success',
            ]);
        }
    }
    public function up_draft_status(Request $request)
    {
        // echo "<pre>";print_r(Auth::guard('admin')->user()->id);exit;
        $order = Order::find($request->id);
        $oldValues = [];
        $newValues = [];
        $originalAttributes = $order->getAttributes();

        $shippng_company = '';
        $order->dstatus = $request->dstatus;
        $order->payment_status = $request->payment_status;
        $order->payment_method = $request->payment_method;
        $order->customer_name = $request->customer_name;
        $order->email = $request->email;
        $order->city = $request->city;
        $order->phone = $request->phone;
        $order->country = $request->country;
        $order->address = $request->address;
        $order->shipping_company = $request->company;
        $order->track_url = $request->track_url;
        $order->track_no = $request->track_no;
        $order->note = $request->note;

        foreach ($originalAttributes as $key => $oldValue) {
            if ($order->$key != $oldValue) {
                $oldValues[$key] = $oldValue; // Store only changed old values
                $newValues[$key] = $order->$key; // Store new values
            }
        }

        $order->save();

        $order_data = Order::where('id', $request->id)->get();
        if ($order_data) {
            $to_name = $order->name;
            $to_email = $order->email;
            $data = [
                'order' => $order_data,

            ];
            try {
                Mail::send('emails.order', $data, function ($message) use ($to_name, $to_email) {
                    $message->to($to_email, $to_name)
                        ->subject('We have confirmed your order(s) and its ready for shipping.’');
                    $message->from(config('mail.from.address'), config('mail.from.name'));
                });
            } catch (\Throwable $th) {
                return redirect(route('admins.complete_orders'))->with([
                    'msg' => 'Email not sent because of technical reasons. Other than that status is updated',
                    'msg_type' => 'danger',
                ]);
            }
        }




        $changes = [
            'old' => $oldValues,
            'new' => $newValues, // Only changed attributes
        ];

        $logs = new LogReport();

        $data = [
            'type' => 'ORDER',
            'type_id' => $order->id,
            'message' => 'The status of Order No:<b>' . $order->order_no . '</b> changed to <b>' . $this->getOrderStatus($order->dstatus) . '</b> by user:<b>' . Auth::guard('admin')->user()->name . '</b>',
            'user_id' => Auth::guard('admin')->user()->id,
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? request()->ip(),
            'url' => request()->fullUrl(),
            'method' => request()->method(),
            'changes' => json_encode($changes, JSON_UNESCAPED_UNICODE),
            'created_at' => now(),
            'updated_at' => now(),
        ];
        $logs->addLog($data);

        return redirect(route('admins.orders'))->with([
            'msg' => 'Order Updated Successfully',
            'msg_type' => 'success',
        ]);
    }
    public function bulkUpdateStatus(Request $request)
    {
        $orderIds = $request->id;
        $status = $request->status;

        if (!$orderIds || $status === null) {
            return redirect()->back()->with([
                'msg' => 'Please select at least one order and a status!',
                'msg_type' => 'danger',
            ]);
        }

        // Update order statuses
        Order::whereIn('id', $orderIds)->update(['dstatus' => $status]);

        // Get updated orders with customer emails
        $orders = Order::whereIn('id', $orderIds)->get();

        // foreach ($orders as $order) {
        //     Mail::to($order->email)->send(new OrderStatusUpdated($order));
        // }

        return redirect()->back()->with([
            'msg' => 'Selected orders updated successfully, and emails sent!',
            'msg_type' => 'success',
        ]);
    }

    public function page_delete($id)
    {
        $product = Pages::find($id);
        $product->delete();
        return redirect(route('admins.pages'))->with([
            'msg' => 'Page Deleted Successfully',
            'msg_type' => 'success',
        ]);
    }
    public function section_delete($id)
    {
        $product = DB::table('sections')->delete($id);
        // $product->delete();
        return redirect(route('admins.msections'))->with([
            'msg' => 'Section Deleted Successfully',
            'msg_type' => 'success',
        ]);
    }
    public function update_product_status(Request $request)
    {
        $product = Product::find($request->product_id);

        // Capture old values
        $oldValues = [];
        $newValues = [];

        // Get original attributes before changes
        $originalAttributes = $product->getAttributes();

        $product->status = $request->Status;
        $product->save();

        foreach ($originalAttributes as $key => $oldValue) {
            if ($product->$key != $oldValue) {
                $oldValues[$key] = $oldValue; // Store only changed old values
                $newValues[$key] = $product->$key; // Store new values
            }
        }
        $logs = new LogReport();

        $changes = [
            'old' => $oldValues,
            'new' => $newValues, // Only changed attributes
        ];

        $data = [
            'type' => 'PRODUCT',
            'type_id' => $product->id,
            'message' => 'The product: <b>' . $product->product_name . '</b> has been ' .
                (($product->status == 1) ? "Activated" : "Deactivated") .
                ' by user: <b>' . Auth::guard('admin')->user()->name . '</b>',
            'user_id' => Auth::guard('admin')->user()->id,
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? request()->ip(),
            'url' => request()->fullUrl(),
            'method' => request()->method(),
            'changes' => json_encode($changes, JSON_UNESCAPED_UNICODE),
            'created_at' => now(),
            'updated_at' => now(),
        ];
        $logs->addLog($data);
        return response()->json([
            'msg' => 'Product Status Updated',
            'msg_type' => 'success',
        ]);
    }

    public function update_trending_product(Request $request)
    {
        $product = Product::find($request->product_id);

        // Capture old values
        $oldValues = [];
        $newValues = [];

        // Get original attributes before changes
        $originalAttributes = $product->getAttributes();

        $product->is_trending = $request->is_trending;
        $product->save();

        foreach ($originalAttributes as $key => $oldValue) {
            if ($product->$key != $oldValue) {
                $oldValues[$key] = $oldValue; // Store only changed old values
                $newValues[$key] = $product->$key; // Store new values
            }
        }
        $logs = new LogReport();

        $changes = [
            'old' => $oldValues,
            'new' => $newValues, // Only changed attributes
        ];

        $data = [
            'type' => 'PRODUCT',
            'type_id' => $product->id,
            'message' => 'The product: <b>' . $product->product_name . '</b> trending status has been change to' .
                (($product->is_trending == 1) ? "Activated" : "Deactivated") .
                ' by user: <b>' . Auth::guard('admin')->user()->name . '</b>',
            'user_id' => Auth::guard('admin')->user()->id,
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? request()->ip(),
            'url' => request()->fullUrl(),
            'method' => request()->method(),
            'changes' => json_encode($changes, JSON_UNESCAPED_UNICODE),
            'created_at' => now(),
            'updated_at' => now(),
        ];
        $logs->addLog($data);
        return response()->json([
            'msg' => 'Product Status Updated',
            'msg_type' => 'success',
        ]);
    }
    public function update_review_status(Request $request)
    {
        $product = Rating::find($request->review_id);
        $product->status = $request->Status;
        $product->save();
        return response()->json([
            'msg' => 'Review Status Updated',
            'msg_type' => 'success',
        ]);
    }
    public function media(Request $request, $id = 0, $delete = null)
    {
        $edit = null;
        if (isset($delete) && $id > 0) {
            Media::find($id)->delete();
            return redirect(route('admins.media'))->with([
                'msg' => 'Media Deleted Successfully',
                'msg_type' => 'success',
            ]);
        }
        if ($id > 0 && !isset($delete)) {
            $edit = Media::find($id);
        }
        if ($request->isMethod('post')) {

            if ($request->has('hidden_id')) {
                $category = Media::find($request->hidden_id);

                //   if(isset($request->name)){
                //         $imageone = $request->name;
                //         $pimage_name = time().$imageone->getClientOriginalName();
                //         $imageone->move(public_path('/images/media/'),$pimage_name);
                //         $category->name= 'images/media/'.$pimage_name;
                //     }
                if ($request->hasFile('name')) {
                    $file = $request->file('name');
                    $extension = $file->getClientOriginalExtension();
                    $extension = 'webp';
                    // Rename the file with a new extension
                    $name = time() . '.' . $extension;

                    // Move the uploaded file to the desired directory
                    $file->move(public_path('/images/media/'), $name);

                    $category['name'] = 'images/media/' . $name;
                }
                $category->updated_at = Date('Y-m-d h:i:s');
                $category->save();
            } else {

                $category = new Media();
                //  if(isset($request->name)){
                //     $imageone = $request->name;
                //     $pimage_name = time().$imageone->getClientOriginalName();
                //     $imageone->move(public_path('/images/media/'),$pimage_name);
                //     $category->name= 'images/media/'.$pimage_name;
                // }
                if ($request->hasFile('name')) {
                    $file = $request->file('name');
                    $extension = $file->getClientOriginalExtension();
                    $extension = 'webp';
                    // Rename the file with a new extension
                    $name = time() . '.' . $extension;

                    // Move the uploaded file to the desired directory
                    $file->move(public_path('/images/media/'), $name);

                    $category['name'] = 'images/media/' . $name;
                }
                $category->updated_at = Date('Y-m-d h:i:s');
                $category->save();
            }

            return redirect(route('admins.media'))->with([
                'msg' => 'Media Saved Successfully',
                'msg_type' => 'success',
            ]);
        }
        $categories = Media::all();
        return view('admins.media', compact('categories', 'edit'));
    }
    public function blog_category(Request $request, $id = 0, $delete = null)
    {
        $edit = null;
        if (isset($delete) && $id > 0) {
            Blog_Category::find($id)->delete();
            return redirect(route('admins.blog_category'))->with([
                'msg' => 'Blog Category Deleted Successfully',
                'msg_type' => 'success',
            ]);
        }
        if ($id > 0 && !isset($delete)) {
            $edit = Blog_Category::find($id);
        }
        if ($request->isMethod('post')) {

            // $request->validate([
            //     'title_english'=>'required|unique:post_categories,title_english,'.$request->hidden_id,
            //     'title_urdu'=>'required|unique:post_categories,title_urdu,'.$request->hidden_id,
            // ]);

            if ($request->has('hidden_id')) {
                $category = Blog_Category::find($request->hidden_id);

                $category->title_english = $request->title_english;
                $category->slug = $request->slug;
                $category->title_urdu = $request->title_urdu;
                $category->title = $request->title;
                $category->description = $request->seo_des;
                $category->keywords = $request->seo_key;
                $category->updated_at = Date('Y-m-d h:i:s');
                $category->save();
            } else {
                $category = new Blog_Category();
                $category->created_at = Date('Y-m-d h:i:s');
                $category->title_english = $request->title_english;
                $category->slug = $request->slug;
                $category->title_urdu = $request->title_urdu;
                $category->title = $request->title;
                $category->description = $request->seo_des;
                $category->keywords = $request->seo_key;
                $category->updated_at = Date('Y-m-d h:i:s');
                $category->save();
            }

            return redirect(route('admins.blog_category'))->with([
                'msg' => 'Blog Category Saved Successfully',
                'msg_type' => 'success',
            ]);
        }
        $categories = Blog_Category::all();
        return view('admins.blog_category', compact('categories', 'edit'));
    }
    public function blog(Request $request, $id = 0, $delete = null)
    {

        $edit = null;
        if (isset($delete) && $id > 0) {
            Blog_Post::find($id)->delete();
            return redirect(route('admins.blog'))->with([
                'msg' => 'Blog  Deleted Successfully',
                'msg_type' => 'success',
            ]);
        }
        if ($id > 0 && !isset($delete)) {
            $edit = Blog_Post::find($id);
        }
        if ($request->isMethod('post')) {

            if ($request->has('hidden_id')) {
                $category = Blog_Post::find($request->hidden_id);

                $category->title_english = $request->title_english;
                $category->slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->title_english)));
                $category->description_english = $request->description;
                $category->title = $request->title;
                $category->description = $request->seo_des;
                $category->keywords = $request->seo_key;
                $category->category_id = $request->category;
                // if(isset($request->image)){
                //     $imageone = $request->image;
                //     $pimage_name = time().$imageone->getClientOriginalName();
                //     $imageone->move(public_path('/images/blogs/'),$pimage_name);
                //     $category->image= 'images/blogs/'.$pimage_name;
                // }
                if ($request->hasFile('image')) {
                    $file = $request->file('image');
                    $extension = $file->getClientOriginalExtension();
                    $extension = 'webp';
                    // Rename the file with a new extension
                    $name = time() . '.' . $extension;

                    // Move the uploaded file to the desired directory
                    $file->move(public_path('/images/blogs/'), $name);

                    $category['image'] = 'images/blogs/' . $name;
                }
                $category->updated_at = Date('Y-m-d h:i:s');
                $category->save();
            } else {
                // dd($request);
                $category = new Blog_Post();
                $category->created_at = Date('Y-m-d h:i:s');
                $category->title_english = $request->title_english;
                $category->slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->title_english)));
                $category->description_english = $request->description;
                $category->category_id = $request->category;
                $category->title = $request->title;
                $category->description = $request->seo_des;
                $category->keywords = $request->seo_key;
                // if(isset($request->image)){
                //     $imageone = $request->image;
                //     $pimage_name = time().$imageone->getClientOriginalName();
                //     $imageone->move(public_path('/images/blogs/'),$pimage_name);
                //     $category->image= 'images/blogs/'.$pimage_name;
                // }
                if ($request->hasFile('image')) {
                    $file = $request->file('image');
                    $extension = $file->getClientOriginalExtension();
                    $extension = 'webp';
                    // Rename the file with a new extension
                    $name = time() . '.' . $extension;

                    // Move the uploaded file to the desired directory
                    $file->move(public_path('/images/blogs/'), $name);

                    $category['image'] = 'images/blogs/' . $name;
                }
                $category->updated_at = Date('Y-m-d h:i:s');
                $category->save();
            }

            return redirect(route('admins.blog'))->with([
                'msg' => 'Blog Saved Successfully',
                'msg_type' => 'success',
            ]);
        }
        $categories = Blog_Post::all();
        return view('admins.blog_posts', compact('categories', 'edit'));
    }
    public function post_form(Request $request, $id = 0) {}
    public function post_delete() {}

    public function slider(Request $request, $id = 0, $delete = null)
    {
        $edit = null;
        if (isset($delete) && $id > 0) {
            $slider = Slider::find($id);
            $file_path = public_path() . '/' . $slider->slider_image;
            if (\File::exists($file_path)) {
                \File::delete($file_path);
            }
            $slider->delete();
            return redirect(route('admins.slider'))->with([
                'msg' => 'Slider Deleted Successfully',
                'msg_type' => 'success',
            ]);
        }
        if ($id > 0 && !isset($delete)) {
            $edit = Slider::find($id);
        }
        if ($request->isMethod('post')) {
            if ($request->has('hidden_id')) {
                $slider = Slider::find($request->hidden_id);
            } else {
                $slider = new Slider();
                $slider->created_at = Date('Y-m-d h:i:s');
            }
            $slider->updated_at = Date('Y-m-d h:i:s');
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $extension = '.webp';
                $name = time() . '.' . uniqid() . $extension;
                $file->move(public_path('img/slider'), $name);
                $slider->slider_image = $name;
            }
            if ($request->hasFile('mobile_image')) {
                $file = $request->file('mobile_image');
                $extension = $file->getClientOriginalExtension();
                $extension = '.webp';
                $name = time() . '.' . $extension;
                $file->move(public_path('img/slider'), $name);
                $slider->slider_mobile_image = $name;
            }
            $slider->cid = $request->link;
            $slider->heading = $request->heading;
            $slider->button = $request->button;
            $slider->p = $request->p;
            $slider->button_ar = $request->button_ar;
            $slider->heading_ar = $request->heading_ar;
            $slider->paragraph_ar = $request->paragraph_ar;
            $slider->status = $request->status;

            $slider->save();
            return redirect(route('admins.slider'))->with([
                'msg' => 'Slider Saved Successfully',
                'msg_type' => 'success',
            ]);
        }
        $sliders = Slider::all();
        $categories = Category::all();
        return view('admins.slider', compact('sliders', 'categories', 'edit'));
    }

    public function promotional_banner(Request $request, $id = 0, $delete = null)
    {
        $edit = null;

        // Handle delete
        if (isset($delete) && $id > 0) {
            $banner = PromotionalBanner::find($id);
            if ($banner) {
                // Delete image
                if ($banner->image) {
                    $file_path = public_path('img/promotional/' . $banner->image);
                    if (File::exists($file_path)) {
                        File::delete($file_path);
                    }
                }
                $banner->delete();
            }
            return redirect(route('admins.promotional_banner'))->with([
                'msg' => 'Promotional Banner Deleted Successfully',
                'msg_type' => 'success',
            ]);
        }

        // Handle edit mode
        if ($id > 0 && !isset($delete)) {
            $edit = PromotionalBanner::find($id);
        }

        // Handle create/update
        if ($request->isMethod('post')) {
            // Check 2 banner limit for new banners
            if (!$request->has('hidden_id')) {
                $currentCount = PromotionalBanner::count();
                if ($currentCount >= 2) {
                    return redirect(route('admins.promotional_banner'))->with([
                        'msg' => 'Maximum limit of 2 promotional banners reached',
                        'msg_type' => 'danger',
                    ]);
                }
            }

            if ($request->has('hidden_id')) {
                $banner = PromotionalBanner::find($request->hidden_id);
            } else {
                $banner = new PromotionalBanner();
                $banner->created_at = Date('Y-m-d h:i:s');
            }
            $banner->updated_at = Date('Y-m-d h:i:s');

            $directory = public_path('img/promotional/');
            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0777, true, true);
            }

            // Handle image upload with auto-resize to 1000x350
            if ($request->hasFile('image')) {
                // Delete old image if updating
                if ($banner->image) {
                    $old_path = public_path('img/promotional/' . $banner->image);
                    if (File::exists($old_path)) {
                        File::delete($old_path);
                    }
                }

                $file = $request->file('image');
                $name = 'promo_' . time() . '_' . uniqid() . '.webp';
                $path = public_path('img/promotional/' . $name);

                // Resize and save using Intervention Image fit() to fill 625x200 perfectly
                Image::make($file)
                    ->fit(625, 200, function ($constraint) {
                        $constraint->upsize();
                    })
                    ->encode('webp', 85) // Optimized for Lighthouse
                    ->save($path);

                $banner->image = $name;
            }

            $banner->link = $request->link;
            $banner->sort_order = $request->sort_order ?? 0;
            $banner->status = $request->status ?? 1;

            $banner->save();
            return redirect(route('admins.promotional_banner'))->with([
                'msg' => 'Promotional Banner Saved Successfully',
                'msg_type' => 'success',
            ]);
        }

        $banners = PromotionalBanner::orderBy('sort_order', 'asc')->get();
        return view('admins.promotional_banner', compact('banners', 'edit'));
    }

    public function faq(Request $request, $id = 0, $delete = null)
    {
        $edit = null;
        if (isset($delete) && $id > 0) {
            $slider = Faq::find($id);

            $slider->delete();
            return redirect(route('admins.faq'))->with([
                'msg' => 'Faq Deleted Successfully',
                'msg_type' => 'success',
            ]);
        }
        if ($id > 0 && !isset($delete)) {
            $edit = Faq::find($id);
            return view('admins.edit_faq', compact('edit'));
        }
        if ($request->isMethod('post')) {
            if ($request->has('hidden_id')) {
                $slider = Faq::find($request->hidden_id);
            } else {
                $slider = new Faq();
            }

            $slider->answer = $request->answer;
            $slider->a_name = $request->a_name;
            $slider->status = $request->status;
            $slider->question = $request->question;

            $slider->save();
            return redirect(route('admins.faq'))->with([
                'msg' => 'Faq Saved Successfully',
                'msg_type' => 'success',
            ]);
        }
        $sliders = Faq::all();
        return view('admins.faq', compact('sliders', 'edit'));
    }
    public function generateDriverToken(Request $request)
    {
        $order = Order::findOrFail($request->order_id);

        if (!$order->driver_token) {
            $order->driver_token = Str::random(32);
            $order->save();
        }

        return response()->json(['token' => $order->driver_token]);
    }

    public function sendOrderConfirmationEmail(Request $request)
    {
        try {
            $order = Order::findOrFail($request->order_id);
            $oldValues = [];
            $newValues = [];
            $originalAttributes = $order->getAttributes();
            $order_data = Order::where('id', $request->order_id)->get();
            $to_name = $order->customer_name;
            $to_email = $order->email;

            foreach ($originalAttributes as $key => $oldValue) {
                if ($order->$key != $oldValue) {
                    $oldValues[$key] = $oldValue; // Store only changed old values
                    $newValues[$key] = $order->$key; // Store new values
                }
            }

            $changes = [
                'old' => $oldValues,
                'new' => $newValues, // Only changed attributes
            ];

            $logs = new LogReport();

            $data1 = [
                'type' => 'ORDER',
                'type_id' => $order->id,
                'message' => 'The order confirmation email sent to customer of Order No:<b>' . $order->order_no . '</b> by user:<b>' . Auth::guard('admin')->user()->name . '</b>',
                'user_id' => Auth::guard('admin')->user()->id,
                'ip_address' => $_SERVER['REMOTE_ADDR'] ?? request()->ip(),
                'url' => request()->fullUrl(),
                'method' => request()->method(),
                'changes' => json_encode($changes, JSON_UNESCAPED_UNICODE),
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $logs->addLog($data1);

            $data = [
                'order' => $order_data,
            ];

            Mail::send('emails.con_order', $data, function ($message) use ($to_name, $to_email) {
                $message->to($to_email, $to_name)
                    ->subject('We have confirmed your order(s) and its ready for shipping.');
                $message->from(config('mail.from.address'), config('mail.from.name'));
            });

            return response()->json(['success' => true]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Email not sent because of technical reasons'
            ]);
        }
    }

    public function customExport(Request $request)
    {
        try {
            $exportType = $request->input('export_type', 'products');
            $productIds = $request->input('product_ids', []);
            $categoryIds = $request->input('category_ids', []);
            $columns = $request->input('columns', []);

            // Validate inputs
            if ($exportType === 'products' && empty($productIds)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please select at least one product'
                ]);
            }
            if ($exportType === 'categories' && empty($categoryIds)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please select at least one category'
                ]);
            }
            if (empty($columns)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please select at least one column'
                ]);
            }

            // Query products based on export type
            $products = collect(); // Initialize empty collection

            if ($exportType === 'products') {
                // Fetch products by IDs
                $products = Product::whereIn('id', $productIds)
                    ->select($columns)
                    ->get();
            } else {
                // Fetch products by categories
                $products = Product::where(function ($query) use ($categoryIds, $request) {
                    foreach ($categoryIds as $categoryId) {
                        // Check if category exists and is manual
                        $categoryObj = Category::find($categoryId); // Adjust to your Category model
                        if ($categoryObj && isset($categoryObj->is_manual) && $categoryObj->is_manual == 2) {
                            // Fetch search conditions for the manual category
                            $searchObj = CategoryCondition::where('category_id', $categoryId)->get(); // Adjust to your SearchCondition model
                            if ($searchObj->count() > 0) {
                                foreach ($searchObj as $val) {
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
                            // Non-manual category: match category_id in comma-separated string
                            $query->orWhereRaw("? = ANY(string_to_array(products.category_id, ','))", [$categoryId]);
                        }
                    }
                })
                    ->select($columns)
                    ->get();
            }

            // Check if any products were found
            if ($products->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No products found for the selected criteria'
                ]);
            }

            // Create Excel file using Laravel Excel package
            $export = new ProductsExport($products, $columns);
            $fileName = 'products_export_' . date('Ymd_His') . '.xlsx';

            // Store the file in a subdirectory 'product_export' on the 'public' disk
            Excel::store($export, 'product_export/' . $fileName, 'public');

            // Generate the correct download URL
            $downloadUrl = url('/product_export/' . $fileName);

            return response()->json([
                'success' => true,
                'download_url' => $downloadUrl
            ]);
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Export failed: ' . $e->getMessage());

            // Return error response
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while generating the Excel file: ' . $e->getMessage()
            ], 500);
        }
    }
}
