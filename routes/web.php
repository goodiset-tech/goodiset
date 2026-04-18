<?php

use App\Http\Controllers\Admins\LanguageController;
use App\Http\Controllers\Admin\OrderNotificationController;
use App\Http\Controllers\Admins\TranslationController;
use App\Http\Controllers\BlogCategoryController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\HomePageVideoController;
use App\Http\Controllers\Admins\CityController;
use App\Http\Controllers\Admins\CountryController;
use App\Http\Controllers\Admins\ShippingRateController;
use App\Http\Controllers\Admins\ShippingZoneController;
use App\Http\Controllers\PaymentMethodController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admins;
use App\Http\Controllers\Admins\AdminController;
use App\Http\Controllers\Admins\PopupController;
use App\Http\Controllers\Admins\ProductController;
use App\Http\Controllers\BoxCalculatorController;
use App\Http\Controllers\BoxCustomizeController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\Front;
use App\Http\Controllers\Front\NgeniusPaymentController;
use App\Http\Controllers\Front\PaymentController as FrontPaymentController;
use App\Http\Controllers\InventoryRequestController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductExportController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SalesReportController;
use App\Http\Controllers\ShippingMethodController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\LocationsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\PaymentMethod;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::post('/hide-popup', function (Request $request) {
    session()->put('popup_shown', true); // Prevent popup from showing again in the session
    return response()->json(['success' => true]);
})->name('hide.popup');
Route::post('/create-payment-intent', [Front\FrontController::class, 'create_payment_intent'])->name('create_payment_intent');
// Route::post('/create-payment-intent', function (Request $request) {

// });

Route::get('/get-payment-method/{id}', function ($id) {
    try {
        Stripe::setApiKey(getSetting('stripe_secret_key'));
        $paymentMethod = PaymentMethod::retrieve($id);
        return response()->json($paymentMethod);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
});


Route::post('/store-checkout-session', function (Request $request) {
    Session::put('checkout', $request->all());
    return response()->json(['message' => 'Session stored successfully']);
})->name('store.checkout.session');

Route::get('/get-checkout-session', function () {
    return response()->json(Session::get('checkout', []));
})->name('get.checkout.session');

Route::get('/clear-cache', function () {
    \Illuminate\Support\Facades\Artisan::call('config:cache');
    return 'Application cache cleared';
});
Route::get('/test', [Admins\AdminController::class, 'test'])->name('test');
Route::get('/', function () {
    return view('welcome');
});
Route::get('/admin', function () {
    return redirect('admin/login');
});
Route::name('admins.')->prefix('/admin')->group(function () {
    Route::get('/login', [Admins\AdminController::class, 'adminloginpage'])->name('login')->middleware('adminnotlogedin');
    Route::post('/login', [Admins\AdminController::class, 'admin_login_submit'])->name('admin_login_submit');
    Route::get('/logout', [Admins\AdminController::class, 'logout']);
    Route::get('/category/condition', [Admins\AdminController::class, 'getCategoryTypeCondition']);
    Route::middleware(['adminlogedin'])->group(function () {
        Route::get('/dashboard', [Admins\AdminController::class, 'dashboard'])->name('dashboard')->middleware('adminlogedin');
        Route::get('/sales', [Admins\AdminController::class, 'sales'])->name('sales')->middleware('adminlogedin');
        Route::get('/inventory', [Admins\AdminController::class, 'inventory'])->name('inventory')->middleware('adminlogedin');
        Route::get('/visits', [Admins\AdminController::class, 'visits'])->name('visits')->middleware('adminlogedin');

        Route::any('/category/{id?}/{delete?}', [Admins\AdminController::class, 'category'])->middleware('check.permission:category,read')->name('category');
        Route::any('/all-categories', [Admins\AdminController::class, 'category_all'])->middleware('check.permission:category,read')->name('category_all');
        Route::any('/colors/{id?}/{delete?}', [Admins\AdminController::class, 'colors'])->middleware('check.permission:colors,read')->name('colors');
        Route::any('/size/{id?}/{delete?}', [Admins\AdminController::class, 'size'])->middleware('check.permission:size,read')->name('size');
        Route::any('/clarity/{id?}/{delete?}', [Admins\AdminController::class, 'clarity'])->name('clarity');
        Route::any('/home_cats/{id?}/{delete?}', [Admins\AdminController::class, 'home_cats'])->name('home_cats');
        Route::any('/shap/{id?}/{delete?}', [Admins\AdminController::class, 'shap'])->name('shap');
        // Route::any('/blog_category/{id?}/{delete?}',[Admins\AdminController::class,'blog_category'])->middleware('check.permission:dashboard,read')->name('blog_category');
        Route::any('/media/{id?}/{delete?}', [Admins\AdminController::class, 'media'])->name('media');
        // Route::get('/blog_category',[Admins\AdminController::class,'blog_category'])->middleware('check.permission:dashboard,read')->name('blog_category');
        // Route::get('/blog',[Admins\AdminController::class,'blog'])->middleware('check.permission:dashboard,read')->name('blog');
        // Route::any('/blog/{id?}/{delete?}',[Admins\AdminController::class,'blog'])->middleware('check.permission:dashboard,read')->name('blog');
        Route::any('/coupon/{id?}/{delete?}', [Admins\AdminController::class, 'coupon'])->name('coupon');
        Route::any('/orders', [Admins\AdminController::class, 'orders'])->middleware('check.permission:orders,read')->name('orders');
        Route::any('/draft_orders', [Admins\AdminController::class, 'dreft_orders'])->middleware('check.permission:orders,read')->name('draft_orders');
        Route::any('/contact', [Admins\AdminController::class, 'contact'])->middleware('check.permission:messages,read')->name('contact');
        Route::get('/contact/datatable', [Admins\AdminController::class, 'contactDataTable'])->name('contact.datatable');
        Route::post('/admins/contact/clear-spam', [Admins\AdminController::class, 'clearContactSpam'])->name('contact.clear_spam');
        Route::get('/admins/contact/clear-spam/count', [Admins\AdminController::class, 'countContactSpam'])->name('contact.clear_spam.count');
        Route::any('/complete_orders', [Admins\AdminController::class, 'complete_orders'])->middleware('check.permission:orders,read')->name('complete_orders');
        Route::any('/deliverd_orders', [Admins\AdminController::class, 'deliverd_orders'])->middleware('check.permission:orders,read')->name('deliverd_orders');
        Route::any('/canceled_orders', [Admins\AdminController::class, 'canceled_orders'])->middleware('check.permission:orders,read')->name('canceled_orders');
        Route::any('/dispatched_orders', [Admins\AdminController::class, 'dispatched_orders'])->middleware('check.permission:orders,read')->name('dispatched_orders');
        Route::get('/orders/log-report', [Admins\AdminController::class, 'orderLogReport'])->middleware('check.permission:orders,read')->name('orders.logreport');
        Route::any('/brand/{id?}/{delete?}', [Admins\AdminController::class, 'brand'])->middleware('check.permission:brand,read')->name('brand');
        Route::any('/product_type/{id?}/{delete?}', [Admins\AdminController::class, 'product_type'])->middleware('check.permission:product_type,read')->name('product_type');
        Route::any('/allergen/{id?}/{delete?}', [Admins\AdminController::class, 'allergen'])->middleware('check.permission:allergen,read')->name('allergen');
        Route::any('/ingredient/{id?}/{delete?}', [Admins\AdminController::class, 'ingredient'])->middleware('check.permission:ingredient,read')->name('ingredient');
        Route::any('/flavour/{id?}/{delete?}', [Admins\AdminController::class, 'flavour'])->middleware('check.permission:flavours,read')->name('flavour');
        Route::any('/package_type/{id?}/{delete?}', [Admins\AdminController::class, 'package_type'])->middleware('check.permission:package_type,read')->name('package_type');
        Route::any('/basket_type/{id?}/{delete?}', [Admins\AdminController::class, 'basket_type'])->middleware('check.permission:basket_type,read')->name('basket_type');
        Route::any('/theme/{id?}/{delete?}', [Admins\AdminController::class, 'theme'])->middleware('check.permission:theme,read')->name('theme');
        Route::any('/currency/{id?}/{delete?}', [Admins\AdminController::class, 'currency'])->middleware('check.permission:currency,read')->name('currency');
        Route::any('/vat/{id?}/{delete?}', [Admins\AdminController::class, 'vat'])->name('vat');
        Route::any('/box_customize/{id?}/{delete?}', [Admins\AdminController::class, 'box_customize'])->name('box_customize');
        Route::any('/box_size/{id?}/{delete?}', [Admins\AdminController::class, 'box_size'])->name('box_size');
        Route::any('/announcements/{id?}/{delete?}', [Admins\AdminController::class, 'top_announcement_bar'])->middleware('check.permission:announcement,read')->name('announcements');
        Route::any('/subcategory/{id?}/{delete?}', [Admins\AdminController::class, 'subcategory'])->middleware('check.permission:subcategory,read')->name('subcategory');
        Route::any('/news_letters/{id?}/{delete?}', [Admins\AdminController::class, 'news_letters'])->middleware('check.permission:newsletters,read')->name('news_letters');
        Route::get('/products', [Admins\AdminController::class, 'products'])->middleware('check.permission:products,read')->name('products');
        Route::get('/products/log-report', [Admins\AdminController::class, 'productLogReport'])->middleware('check.permission:products,read')->name('products.logreport');
        Route::any('/product_form/{id?}', [Admins\AdminController::class, 'product_form'])->middleware('check.permission:products,create')->name('product_form');
        Route::get('/pages', [Admins\AdminController::class, 'pages'])->middleware('check.permission:pages,read')->name('pages');
        Route::post('/admin/pages/toggle-header', [Admins\AdminController::class, 'toggleHeader'])->name('toggle_page_header');
        Route::get('/msections', [Admins\AdminController::class, 'msections'])->name('msections');
        Route::get('/dsection/{id?}', [Admins\AdminController::class, 'dsection'])->name('dsection');
        Route::get('/setting', [Admins\AdminController::class, 'setting'])->middleware('check.permission:settings,read')->name('setting');
        Route::any('/setting/{id?}', [Admins\AdminController::class, 'setting'])->name('setting');
        Route::get('/learn_setting', [Admins\AdminController::class, 'learn_setting'])->name('learn_setting');
        Route::any('/learn_setting/{id?}', [Admins\AdminController::class, 'learn_setting'])->name('learn_setting');
        Route::any('/page_form/{id?}', [Admins\AdminController::class, 'page_form'])->name('page_form');
        Route::any('/static_page_form/{id?}', [Admins\AdminController::class, 'static_page_form'])->name('static_page_form');
        Route::any('/dynamic_page_form/{id?}', [Admins\AdminController::class, 'dynamic_page_form'])->name('dynamic_page_form');
        Route::get('/product/delete/{id}', [Admins\AdminController::class, 'product_delete'])->name('product_delete');
        Route::get('/gallery/delete/{id}', [Admins\AdminController::class, 'gallery_delete'])->name('gallery_delete');
        Route::get('/order/delete/{id}', [Admins\AdminController::class, 'order_delete'])->name('order_delete');
        Route::delete('/meg/delete/{id}', [Admins\AdminController::class, 'meg_delete'])->name('meg_delete');
        Route::get('/order/edit/{id}', [Admins\AdminController::class, 'order_edit'])->name('edit_order');
        Route::get('/draft_order/edit/{id}', [Admins\AdminController::class, 'draft_order_edit'])->name('edit_draft_order');
        Route::post('/order/up_delivery_status', [Admins\AdminController::class, 'up_delivery_status'])->name('up_delivery_status');
        Route::post('/order/up_draft_status', [Admins\AdminController::class, 'up_draft_status'])->name('up_draft_status');
        Route::get('/pages/delete/{id}', [Admins\AdminController::class, 'page_delete'])->name('page_delete');
        Route::get('/sections/delete/{id}', [Admins\AdminController::class, 'section_delete'])->name('section_delete');
        Route::post('/get_subCategory_html', [Admins\AdminController::class, 'get_subCategory_html'])->name('get_subCategory_html');
        Route::post('/get_products', [Admins\AdminController::class, 'get_products'])->name('get_products');
        Route::post('/update_product_status', [Admins\AdminController::class, 'update_product_status'])->name('update_product_status');
        Route::post('/update_trending_product', [Admins\AdminController::class, 'update_trending_product'])->name('update_trending_product');
        Route::post('/update_review_status', [Admins\AdminController::class, 'update_review_status'])->name('update_review_status');
        Route::any('/review', [Admins\AdminController::class, 'review'])->middleware('check.permission:reviews,read')->name('review');
        Route::any('/approve_review', [Admins\AdminController::class, 'approved_review'])->middleware('check.permission:reviews,read')->name('approve_review');
        Route::get('/review/delete/{id}', [Admins\AdminController::class, 'review_delete'])->name('review_delete');
        Route::get('/posts', [Admins\AdminController::class, 'posts'])->name('posts');
        Route::get('/admin', [Admins\AdminController::class, 'admin'])->name('admin');
        Route::post('/update_admin', [Admins\AdminController::class, 'update_admin'])->name('update_admin');
        Route::any('/delete_order', [Admins\AdminController::class, 'delete_order'])->name('delete_order');
        Route::any('/delete_review', [Admins\AdminController::class, 'delete_review'])->name('delete_review');
        Route::any('/delete_contact', [Admins\AdminController::class, 'delete_contact'])->name('delete_contact');
        Route::any('/post_form/{id?}', [Admins\AdminController::class, 'post_form'])->name('post_form');
        Route::get('/post/delete/{id}', [Admins\AdminController::class, 'post_delete'])->name('post_delete');
        Route::any('/slider/{id?}/{delete?}', [Admins\AdminController::class, 'slider'])->middleware('check.permission:sliders,read')->name('slider');
        Route::any('/promotional_banner/{id?}/{delete?}', [Admins\AdminController::class, 'promotional_banner'])->middleware('check.permission:sliders,read')->name('promotional_banner');
        // Route::any('/faq/{id?}/{delete?}',[Admins\AdminController::class,'faq'])->middleware('check.permission:faqs,read')->name('faq');
        Route::resource('users', UserController::class)->middleware('check.permission:user_management,read');
        Route::get('log-report', [UserController::class, 'userLogReport'])->middleware('check.permission:user_management,read')->name('user.logreport');
        Route::resource('roles', RoleController::class)->middleware('check.permission:user_management,read');
        Route::get('/campaign-emails', [UserController::class, 'campaignEmails']);
        Route::resource('permissions', PermissionController::class);
        Route::get('/get-payment-settings/{method}', [PaymentMethodController::class, 'getSettings']);
        Route::post('/save-payment-settings', [PaymentMethodController::class, 'saveSettings']);
        Route::get('/export-products', [ProductExportController::class, 'export'])->name('products.export');
        Route::post('/import-products', [ProductExportController::class, 'import'])->name('products.import');
        Route::get('/import-products', [ProductExportController::class, 'importexport'])->name('products.import.export');
        Route::resource('shipping-methods', ShippingMethodController::class);
        Route::post('/admin/orders/bulk-update-status', [Admins\AdminController::class, 'bulkUpdateStatus'])->name('bulk_update_status');
        Route::post('/admin/update-sort-order', [Admins\AdminController::class, 'updateSortOrder'])->name('update_sort_order');
        Route::get('/admin/accounts', [Admins\AdminController::class, 'accounts'])->name('accounts');
        Route::resource('countries', CountryController::class);
        Route::get('countries/delete/{country}', [CountryController::class, 'destroy'])->name('countries.delete_get');
        Route::post('/countries/toggle-status', [CountryController::class, 'toggleStatus'])->name('countries.toggle-status');
        Route::resource('cities', CityController::class);
        Route::get('cities/delete/{city}', [CityController::class, 'destroy'])->name('cities.delete_get');
        Route::post('/cities/toggle-status', [CityController::class, 'toggleStatus'])->name('cities.toggle-status');
        Route::resource('shipping-zones', ShippingZoneController::class);
        Route::resource('shipping-rates', ShippingRateController::class);
        Route::get('/sales-report-view', [SalesReportController::class, 'salesReportForm']);
        Route::get('/sales-report', [SalesReportController::class, 'salesReport']);
        Route::get('/product-sales-report', [SalesReportController::class, 'productSalesView']);
        Route::get('/api/product-sales-report', [SalesReportController::class, 'productSalesReport']);
        Route::get('/category-sales-report', [SalesReportController::class, 'categorySalesView']);
        Route::get('/api/category-sales-report', [SalesReportController::class, 'categorySalesReport']);
        Route::get('/general-ledger-report', [SalesReportController::class, 'generalLedgerReportView'])->name('general-ledger');
        Route::get('/api/general-ledger-report', [SalesReportController::class, 'generalLedgerReport']);
        Route::get('/monthly-sales-report', [SalesReportController::class, 'showMonthlySalesReport'])->name('monthly.sales.report');
        Route::get('/api/monthly-sales-report', [SalesReportController::class, 'monthlySalesReport']);
        Route::get('/monthly-odoo-report', [SalesReportController::class, 'showMonthlyOdooReport'])->name('monthly-odoo-report');
        Route::get('/api/monthly-odoo-report', [SalesReportController::class, 'monthlyOdooReport'])->name('api.monthly-odoo-report');
        Route::get('/vat-report', [SalesReportController::class, 'vatReportView'])->name('vat-report-view');
        Route::get('/api/vat-report', [SalesReportController::class, 'vatReport'])->name('vat-report');
        Route::resource('offers', OfferController::class);
        Route::post('/offers/get-products-by-category', [OfferController::class, 'getProductsByCategory'])->name('offers.get_products_by_category');
        // Route::get('/offers/revertExpiredOrInactiveOffers', [OfferController::class, 'revertExpiredOrInactiveOffers'])->name('offers.revertExpiredOrInactiveOffers');
        Route::resource('promotions', PromotionController::class);
        Route::get('/admins/products/data', [ProductController::class, 'getProducts'])->name('products.data');
        Route::post('admins/products/generate-label', [ProductController::class, 'generateLabel'])->name('generate_label');
        Route::get('admins/products/details/{product_id}', [ProductController::class, 'getProductDetails'])->name('get_product_details');
        Route::post('products/multiple-details', [ProductController::class, 'getMultipleProductDetails'])->name('get_multiple_product_details');
        Route::resource('warehouses', WarehouseController::class);
        Route::resource('inventory-requests', InventoryRequestController::class);
        Route::put('inventory-requests/{inventoryRequest}/update-status', [InventoryRequestController::class, 'updateStatus'])->name('inventory-requests.update-status');
        Route::post('/generate-driver-token', [Admins\AdminController::class, 'generateDriverToken']);
        Route::post('/send-order-confirmation-email', [Admins\AdminController::class, 'sendOrderConfirmationEmail'])->name('send.order.confirmation');
        Route::post('/send-contact-reply', [Admins\AdminController::class, 'sendContactReply'])->name('send_contact_reply');
        Route::get('/faq', [FaqController::class, 'index'])->name('faq');
        Route::get('/faq/create', [FaqController::class, 'create'])->name('faq.create');
        Route::post('/faq', [FaqController::class, 'store'])->name('faq.store');
        Route::get('/faq/{id}', [FaqController::class, 'edit'])->name('faq.edit');
        Route::put('/faq/{id}', [FaqController::class, 'update'])->name('faq.update');
        Route::get('/faq/{id}/delete', [FaqController::class, 'destroy'])->name('faq.destroy');
        Route::post('/products/custom-export', [Admins\AdminController::class, 'customExport'])->name('products.custom_export');
        Route::get('/static-pages', [Admins\AdminController::class, 'static_pages'])->middleware('check.permission:pages,read')->name('static_pages');
        Route::get('/dynamic-pages', [Admins\AdminController::class, 'dynamic_pages'])->middleware('check.permission:pages,read')->name('dynamic_pages');
        Route::get('/locations', [LocationsController::class, 'index'])->name('locations.index');
        Route::get('/locations/create', [LocationsController::class, 'create'])->name('locations.create');
        Route::post('/locations', [LocationsController::class, 'store'])->name('locations.store');
        Route::get('/locations/{id}/edit', [LocationsController::class, 'edit'])->name('locations.edit');
        Route::put('/locations/{id}', [LocationsController::class, 'update'])->name('locations.update');
        Route::delete('/locations/{id}', [LocationsController::class, 'destroy'])->name('locations.destroy');
        Route::resource('blogs', BlogController::class)->names('blogs');
        Route::resource('home-videos', HomePageVideoController::class)
            ->parameters(['home-videos' => 'video'])
            ->except(['show']);
        Route::resource('blog/categories', BlogCategoryController::class)->names('blogs.categories');
        Route::resource('order_notifications', OrderNotificationController::class)->names('order_notifications');
        Route::post('order_notifications/toggle-status', [OrderNotificationController::class, 'toggleStatus'])->name('order_notifications.toggle-status');
        Route::get('/popup', [PopupController::class, 'index'])->name('popup');
        Route::post('/popup', [PopupController::class, 'store'])->name('popup.store');
        Route::delete('/popup', [PopupController::class, 'destroy'])->name('popup.delete');
        Route::get('/box-calculator', [BoxCalculatorController::class, 'index'])->name('box.calculator');
        Route::get('/box-list', [BoxCalculatorController::class, 'list'])->name('box.list');
        Route::post('/box/save', [BoxCalculatorController::class, 'save'])->name('box.save');
        Route::get('/box/edit/{id}', [BoxCalculatorController::class, 'edit'])->name('box.edit');
        Route::delete('/box/delete/{id}', [BoxCalculatorController::class, 'delete'])->name('box.delete');
        Route::get('/products/inventory-report', [AdminController::class, 'inventoryReport'])->name('products.inventory.report');
        Route::get('/admin/products/inventory-report/data', [ProductController::class, 'inventoryReportData'])->name('products.inventory.report.data');
        Route::post('/admin/products/update-weight', [ProductController::class, 'updateWeight'])
            ->name('products.update.weight');
        Route::get('languages',                [LanguageController::class, 'index'])->name('languages');
        Route::post('languages',               [LanguageController::class, 'store']);
        Route::get('languages/{id}',           [LanguageController::class, 'edit'])->name('languages.edit');
        Route::post('languages/{id}',          [LanguageController::class, 'update']);
        Route::get('languages/{id}/delete',    [LanguageController::class, 'destroy'])->name('languages.delete');
        Route::post('languages/{id}/default',  [LanguageController::class, 'makeDefault'])->name('languages.default');

        // Translations per language
        Route::delete('translation/{id}', [TranslationController::class, 'deleteKeyAjax'])->name('translations.key.delete.ajax');
        Route::get('translations/{lang}',                    [TranslationController::class, 'index'])->name('translations');
        Route::post('translations/{lang}/add-key',           [TranslationController::class, 'storeKey'])->name('translations.addkey');
        Route::post('translations/{lang}/save-value',        [TranslationController::class, 'saveValue'])->name('translations.savevalue');
        Route::post('translations/{lang}/bulk-save',         [TranslationController::class, 'bulkSave'])->name('translations.bulk');
        Route::post('translations/{lang}/import-json',       [TranslationController::class, 'importJson'])->name('translations.importjson');
        Route::get('translations/{lang}/{key}/delete',       [TranslationController::class, 'deleteKey'])->name('translations.deletekey');

        Route::get('translations/{lang}', [TranslationController::class, 'index'])->name('translations');
        Route::get('translations/{lang}/datatable', [TranslationController::class, 'datatable'])->name('translations.datatable');
        Route::post('translations/{lang}/save-value', [TranslationController::class, 'saveValue'])->name('translations.savevalue');
    });
});
Route::get('/', [Front\FrontController::class, 'home'])->name('home');
Route::post('/import-products', [Front\FrontController::class, 'importProducts'])->name('import.products');
Route::get('/import_product', [Front\FrontController::class, 'import_product'])->name('import_product');
Route::get('/sitemap', [Front\FrontController::class, 'index'])->name('sitemap');
Route::get('/categories_sitemap', [Front\FrontController::class, 'categories'])->name('categories_sitemap');
Route::get('/brand_sitemap', [Front\FrontController::class, 'brands'])->name('brand_sitemap');
Route::get('/products_tag', [Front\FrontController::class, 'products_tag'])->name('products_tag');
Route::get('/products_feed_xml', [Front\FrontController::class, 'generateProductFeed'])->name('products_feed_xml');
Route::get('/generate_meta_product_feed', [Front\FrontController::class, 'generateMetaProductFeed'])->name('generateMetaProductFeed');
Route::get('/shop/{id}', [Front\FrontController::class, 'shop'])->name('shop');
Route::any('/shop', [Front\FrontController::class, 'shop'])->name('shop');
Route::get('/api/fetch-products', [Front\FrontController::class, 'fetchProducts']);
Route::get('/product/{id}', [Front\FrontController::class, 'product_detail'])->name('product.show')->middleware('redirect.old.slugs');;
Route::get('/blogs', [Front\FrontController::class, 'blogs'])->name('blogs');
Route::get('/blog/{id}', [Front\FrontController::class, 'blog_detail'])->name('blog.show');
Route::get('/category/{id}', [Front\FrontController::class, 'category_detail'])->name('category.show');
Route::get('/blog_category/{id}', [Front\FrontController::class, 'blog_category']);
Route::get('/shape/{id}', [Front\FrontController::class, 'shape_detail']);
Route::get('/brand/{id}', [Front\FrontController::class, 'brand_detail']);
Route::get('/tags/{id}', [Front\FrontController::class, 'tags_detail']);
Route::get('/search', [Front\FrontController::class, 'search_detail']);
Route::get('/order', [Front\FrontController::class, 'order']);
Route::get('/cart', [Front\FrontController::class, 'cart'])->name('cart');
Route::get('/cart/drawer', [Front\FrontController::class, 'cartDrawer'])->name('cart.drawer');
Route::any('/contact-us', [Front\FrontController::class, 'contact'])->name('contact-us');
Route::post('cart/increment', [Front\CartController::class, 'increment']);
Route::post('cart/decrement', [Front\CartController::class, 'decrement']);
Route::post('cart/set-qty', [Front\CartController::class, 'setQuantity']);
Route::get('cart/ui-state', [Front\CartController::class, 'uiState']);
Route::post('cart/remove', [Front\CartController::class, 'remove']);
Route::post('cart/clear', [Front\CartController::class, 'clear']);
Route::get('login', [Front\FrontController::class, 'login']);
Route::get('verify_opt', [Front\FrontController::class, 'verify']);
Route::post('verify_login', [Front\FrontController::class, 'verify_login']);
Route::get('logout', [Front\FrontController::class, 'logout']);
Route::post('register', [Front\FrontController::class, 'register']);
Route::get('user_register', [Front\FrontController::class, 'user_register']);
Route::post('user_login', [Front\FrontController::class, 'user_login']);
Route::get('my_account', [Front\FrontController::class, 'my_account'])->name('my_account');
Route::post('user_update', [Front\FrontController::class, 'user_update']);
Route::get('checkout', [Front\FrontController::class, 'checkout']);
Route::get('payment', [Front\FrontController::class, 'payment']);
Route::get('guest_checkout', [Front\FrontController::class, 'guest_checkout']);
Route::get('track_order', [Front\FrontController::class, 'track_order']);
Route::get('celebrations', [Front\FrontController::class, 'celebrations']);
Route::get('celebration/{slug}', [Front\FrontController::class, 'celebration_detail']);
Route::get('/pick&mix', [Front\FrontController::class, 'pickmix'])->name('pick&mix');
Route::get('flavours', [Front\FrontController::class, 'flavours']);
Route::get('flavour/{slug}', [Front\FrontController::class, 'flavour_detail'])->name('flavour_detail');
Route::get('/page/{id}', [Front\FrontController::class, 'page_detail']);
Route::get('/about', [Front\FrontController::class, 'about'])->name('about');
Route::get('/learn', [Front\FrontController::class, 'learn'])->name('learn');
Route::get('/faq', [Front\FrontController::class, 'faq'])->name('faq');
Route::post('/order', [Front\FrontController::class, 'order'])->name('order');
Route::post('/cart_data', [Front\FrontController::class, 'cart_data'])->name('cart_data');
Route::post('/hearder_cart', [Front\FrontController::class, 'hearder_cart'])->name('hearder_cart');
Route::post('/order_submit', [Front\FrontController::class, 'order_submit'])->name('order_submit');
Route::post('/draft_order_submit', [Front\FrontController::class, 'draft_order_submit'])->name('draft_order_submit');
Route::post('/instant_order', [Front\FrontController::class, 'instant_order'])->name('instant_order');
Route::post('/blod_comment', [Front\FrontController::class, 'blod_comment'])->name('blod_comment');
Route::post('/rating_submit', [Front\FrontController::class, 'rating_submit'])->name('rating_submit');
Route::post('/faq_submit', [Front\FrontController::class, 'faq_submit'])->name('faq_submit');
Route::post('/contact_us', [Front\FrontController::class, 'contact_us'])->name('contact_us');
Route::post('/trackorder', [Front\FrontController::class, 'trackorder'])->name('trackorder');
Route::get('/about-us', [Front\FrontController::class, 'aboutus'])->name('about-us');
Route::get('/privacy-policy', [Front\FrontController::class, 'privacypolicy'])->name('privacy-policy');
Route::get('/terms', [Front\FrontController::class, 'terms'])->name('terms');
Route::get('/becomepartner', [Front\FrontController::class, 'becomepartner'])->name('becomepartner');
Route::get('/make-own-basket', [Front\FrontController::class, 'makeownbasket'])->name('makeownbasket');
Route::any('/get_box', [Front\FrontController::class, 'get_box'])->name('get_box');
Route::get('/faqs', [Front\FrontController::class, 'faqs'])->name('faqs');
Route::get('/our-stores', [Front\FrontController::class, 'locations'])->name('locations');
Route::get('/retailer-reseller', [Front\FrontController::class, 'retailers'])->name('retailers');
Route::get('/partners', [Front\FrontController::class, 'partners'])->name('partners');
Route::get('/corporate-events', [Front\FrontController::class, 'corporateEvents'])->name('corporate-events');
Route::get('/resellers', [Front\FrontController::class, 'resellers'])->name('resellers');
Route::get('/influencers', [Front\FrontController::class, 'influencers'])->name('influencers');
Route::get('/thanks/{order_no}', [Front\FrontController::class, 'thanks'])->name('thanks');
Route::get('/order_detail/{order_no}', [Front\FrontController::class, 'order_detail'])->name('order_detail');
Route::get('/reorder/{order_no}', [Front\FrontController::class, 'reorder'])->name('reorder');
Route::post('/get_selected_shap', [Front\FrontController::class, 'get_selected_shap'])->name('get_selected_shap');
Route::post('/get_selected_color', [Front\FrontController::class, 'get_selected_color'])->name('get_selected_color');
Route::post('/get_selected_size', [Front\FrontController::class, 'get_selected_size'])->name('get_selected_size');
Route::post('/get_selected_detail', [Front\FrontController::class, 'get_selected_detail'])->name('get_selected_detail');
Route::any('/get_selected_price', [Front\FrontController::class, 'get_selected_price'])->name('get_selected_price');
Route::post('/cart/add', [Front\CartController::class, 'add'])->name('cart');
Route::post('/apply-coupon', [Front\CartController::class, 'applyCoupon'])->name('applyCoupon');
Route::post('/add-to-cart', [Front\CartController::class, 'addToCart'])->name('add.to.cart');
Route::post('/decrement-to-cart', [Front\CartController::class, 'decrementToCart'])->name('decrement.to.cart');
Route::post('/remove-from-cart', [Front\CartController::class, 'removeFromCart'])->name('remove.from.cart');
Route::POST('/subcribe_newsletter', [Front\FrontController::class, 'subcribe_newsletter'])->name('subcribe_newsletter');
Route::any('/forget_pass', [Front\FrontController::class, 'forget_pass'])->name('forget_pass');
Route::get('/search-products', [Front\FrontController::class, 'searchProducts']);
Route::post('/api/ngenius-session', [Front\PaymentController::class, 'createNgeniusSession']);
Route::post('/ngenius/create-order', [NgeniusPaymentController::class, 'createPaymentOrder'])->name('ngenius.createOrder');
Route::get('/payment/status', [NgeniusPaymentController::class, 'handlePaymentStatus'])->name('payment.status');
Route::get('/get-shipping-rules/{city_id?}/{country_id?}', [Front\FrontController::class, 'getShippingRules']);
Route::get('/get-cities/{country_id}', [Front\FrontController::class, 'getCities']);
Route::post('/subscribe',  [Front\FrontController::class, 'subscribe']);
Route::post('/locale', [LocaleController::class, 'switch'])->name('locale.switch');
Route::get('/switch_ar', [LocaleController::class, 'switch_ar'])->name('locale.switch_ar');
Route::get('/switch_en', [LocaleController::class, 'switch_en'])->name('locale.switch_en');

// Route::get('/send-test-email', function () {
//     Mail::raw('This is a test email from Laravel using SMTP.', function ($message) {
//         $message->to('khurram.jamilsatti@gmail.com');
//         $message->subject('Test Email');
//     });

//     return 'Email sent!';
// });


// Add this outside any auth middleware group
Route::get('/driver/order/{token}', [DriverController::class, 'showOrder'])->name('driver.order');
Route::post('/driver/order/{token}/update',  [DriverController::class, 'updateStatus'])->name('driver.order.update');

Route::get('/secret-download-lang/{lang}', function ($lang) {
    if (!in_array($lang, ['ar', 'en'])) {
        abort(404);
    }
    $path = resource_path("lang/{$lang}.json");
    if (file_exists($path)) {
        return response()->download($path);
    }
    abort(404);
});
