<?php

namespace App\Http\Controllers\Front;

use App\Helpers\Cart;
use App\Http\Controllers\Controller;
use App\Imports\ProductsImport;
use App\Mail\CouponEmail;
use App\Models\Admins\Blog_Category;
use App\Models\Admins\Blog_Comment;
use App\Models\Admins\Blog_Post;
use App\Models\Admins\Brand;
use App\Models\Admins\Category;
use App\Models\Admins\CategoryCondition;
use App\Models\Admins\Colors;
use App\Models\Admins\Contact;
use App\Models\Admins\Coupon;
use App\Models\Faq;
use App\Models\Admins\Gallerie;
use App\Models\Admins\Learn_setting;
use App\Models\Admins\Order;
use App\Models\Admins\Pages;
use App\Models\Admins\Product;
use App\Models\Admins\Rating;
use App\Models\Admins\Setting;
use App\Models\Admins\Shap;
use App\Models\Admins\Size;
use App\Models\Admins\Slider;
use App\Models\Admins\PromotionalBanner;
use App\Models\Admins\User;
use App\Models\Allergen;
use App\Models\BasketType;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BoxCustomize;
use App\Models\BoxSize;
use App\Models\City;
use App\Models\Countries;
use App\Models\Country;
use App\Models\Customer;
use App\Models\Faq as ModelsFaq;
use App\Models\Location as ModelsLocation;
use App\Models\Flavour;
use App\Models\HomePageVideo;
use App\Models\Format;
use App\Models\Newsletter;
use App\Models\OrderNotification;
use App\Models\PackageType;
use App\Models\ProductSlugRedirect;
use App\Models\ProductType;
use App\Models\Theme;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Session;
use Stripe\Charge;
use Stripe\Stripe;
use App\Models\Visitor;
use App\Services\WhatsAppService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Stevebauman\Location\Facades\Location;
use Illuminate\Support\Facades\Validator;
use Stripe\PaymentIntent;

/**
 * Class FrontController
 * 
 * Handles public-facing functionalities such as homepage rendering, 
 * product details, user authentication, and checkout processes.
 * 
 * @package App\Http\Controllers\Front
 */
class FrontController extends Controller
{

    public function generateMetaProductFeed()
    {
        try {
            // Eager load brand to optimize queries
            $products = Product::with('brand')->where('status', 1)->latest()->get();
        } catch (\Exception $e) {
            Log::error('Error loading products: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to load products: ' . $e->getMessage()], 500);
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<rss version="2.0" xmlns:fb="http://www.facebook.com/2008/fbml" xmlns:g="http://base.google.com/ns/1.0">';
        $xml .= '<channel>';
        $xml .= '<title>' . htmlspecialchars(getSetting('site_title')) . ' Meta Product Feed</title>';
        $xml .= '<link>' . htmlspecialchars(url('/')) . '</link>';
        $xml .= '<description>Product catalog for ' . htmlspecialchars(getSetting('site_title')) . '</description>';

        foreach ($products as $product) {

            $xml .= '<item>';
            $xml .= '<g:id>' . htmlspecialchars($product->id) . '</g:id>';
            $xml .= '<g:title>' . htmlspecialchars($product->product_name) . '</g:title>';
            $plainDescription = strip_tags($product->product_details ?? 'No description available');
            $xml .= '<g:description>' . htmlspecialchars(ucfirst(strtolower($plainDescription))) . '</g:description>';

            $xml .= '<g:link>' . htmlspecialchars(url('/product/' . $product->slug)) . '</g:link>';

            // Image handling (Meta requires a main image)
            $imageUrl =  asset($product->image_one);
            $xml .= '<g:image_link>' . htmlspecialchars($imageUrl) . '?v=' . $product->updated_at . '</g:image_link>';

            // Price with currency in ISO 4217 format (e.g., "19.99 AED")
            $currency = "AED"; // Assumed to return "AED"
            $xml .= '<g:price>' . number_format($product->discount_price, 2, '.', '') . ' ' . $currency . '</g:price>';

            // Availability (Meta supports in stock, out of stock, preorder, etc.)
            $availability = $product->product_quantity > 0 ? 'in stock' : 'out of stock';
            $xml .= '<g:availability>' . $availability . '</g:availability>';

            $xml .= '<g:condition>new</g:condition>';

            // Add shipping (dynamic based on getShippingRate)
            $xml .= '<g:shipping>';
            $xml .= '<g:country>AE</g:country>';
            $xml .= '<g:service>Standard</g:service>';
            $xml .= '</g:shipping>';

            // Add tax (5% VAT included in price)
            $xml .= '<g:tax>';
            $xml .= '<g:country>AE</g:country>';
            $xml .= '<g:rate>5.0</g:rate>';
            $xml .= '<g:tax_included>true</g:tax_included>'; // VAT is included in the product price
            $xml .= '</g:tax>';

            // Fetch brand name using relationship
            $brandName = null;
            try {
                $brandName = $product->brand ? $product->brand->name : getSetting('site_title');
            } catch (\Exception $e) {
                Log::error('Error accessing brand for product ID ' . $product->id . ': ' . $e->getMessage());
                $brandName = getSetting('site_title');
            }
            $xml .= '<g:brand>' . htmlspecialchars($brandName) . '</g:brand>';

            // Fetch first category name for product_type
            $categoryName = null;
            try {
                $categories = $product->categories();
                if ($categories->isNotEmpty()) {
                    $categoryName = $categories->first()->name;
                    $xml .= '<g:product_type>' . htmlspecialchars($categoryName) . '</g:product_type>';
                }
            } catch (\Exception $e) {
                Log::error('Error accessing categories for product ID ' . $product->id . ': ' . $e->getMessage());
            }

            // Fetch all color names for g:color
            try {
                $colors = $product->colors();
                if ($colors->isNotEmpty()) {
                    $colorNames = $colors->pluck('name')->implode(', ');
                    $xml .= '<g:color>' . htmlspecialchars($colorNames) . '</g:color>';
                }
            } catch (\Exception $e) {
                Log::error('Error accessing colors for product ID ' . $product->id . ': ' . $e->getMessage());
            }

            // Fetch all size names for g:size
            try {
                $sizes = $product->sizes();
                if ($sizes->isNotEmpty()) {
                    $sizeNames = $sizes->pluck('name')->implode(', ');
                    $xml .= '<g:size>' . htmlspecialchars($sizeNames) . '</g:size>';
                }
            } catch (\Exception $e) {
                Log::error('Error accessing sizes for product ID ' . $product->id . ': ' . $e->getMessage());
            }

            // Optional fields
            if ($product->mpn) {
                $xml .= '<g:mpn>' . htmlspecialchars($product->mpn) . '</g:mpn>';
            }
            if ($product->sku) {
                $xml .= '<g:gtin>' . htmlspecialchars($product->sku) . '</g:gtin>';
            }

            // Handle bundle products if applicable
            if (isset($product->format) && $product->format == '3') {
                $xml .= '<g:custom_label_0>Bundle</g:custom_label_0>';
            }

            $xml .= '</item>';
        }

        $xml .= '</channel>';
        $xml .= '</rss>';

        // Save the file with public permissions
        $filePath = public_path('meta-product-feed.xml');
        file_put_contents($filePath, $xml);

        return response()->json(['success' => true, 'message' => 'Meta product feed generated successfully']);
    }
    /**
     * Generate a product feed in RSS/XML format for Google/Meta.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function generateProductFeed()
    {
        $products = Product::latest()->get(); // Fetch all products, adjust as needed
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<rss version="2.0" xmlns:g="http://base.google.com/ns/1.0">';
        $xml .= '<channel>';
        $xml .= '<title>' . htmlspecialchars(getSetting('site_title')) . ' Product Feed</title>';
        $xml .= '<link>' . htmlspecialchars(url('/')) . '</link>';
        $xml .= '<description>Product catalog for ' . htmlspecialchars(getSetting('site_title')) . '</description>';

        foreach ($products as $product) {
            $xml .= '<item>';
            $xml .= '<g:id>' . htmlspecialchars($product->id) . '</g:id>';
            $xml .= '<title>' . htmlspecialchars($product->product_name) . '</title>';
            $xml .= '<description>' . htmlspecialchars($product->product_details ?? 'No description available') . '</description>';
            $xml .= '<link>' . htmlspecialchars(url('/product/' . $product->slug)) . '</link>';

            // Image handling (assuming you have a way to get the main image)
            $imageUrl = asset('') . $product->image_one;
            $xml .= '<g:image_link>' . htmlspecialchars($imageUrl) . '</g:image_link>';

            $xml .= '<g:price>' . number_format($product->discount_price, 2) . ' AED</g:price>';
            $xml .= '<g:availability>' . ($product->product_quantity > 0 ? 'in stock' : 'out of stock') . '</g:availability>';
            $xml .= '<g:condition>new</g:condition>';

            // Optional fields (adjust based on your Product model)
            if ($product->brand) {
                $xml .= '<g:brand>' . htmlspecialchars($product->brand) . '</g:brand>';
            }
            if ($product->gtin) {
                $xml .= '<g:gtin>' . htmlspecialchars($product->gtin) . '</g:gtin>';
            }
            if ($product->mpn) {
                $xml .= '<g:mpn>' . htmlspecialchars($product->mpn) . '</g:mpn>';
            }

            // Handle bundle products if applicable
            if (isset($product->format) && $product->format == 3) {
                $xml .= '<g:custom_label_0>Bundle</g:custom_label_0>';
            }

            $xml .= '</item>';
        }

        $xml .= '</channel>';
        $xml .= '</rss>';

        // Save the file with public permissions
        $filePath = public_path('product-feed.xml');
        file_put_contents($filePath, $xml);

        return response()->json(['success' => true, 'message' => 'Product feed generated successfully']);
    }

    public function index()
    {
        $posts = Product::latest()->get();
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        foreach ($posts as $post) {
            $xml .= '<url>
            <loc>' . htmlspecialchars(url('product/' . $post->slug)) . '</loc>
            <priority>1.0</priority>
            <changefreq>daily</changefreq>
            </url>';
        }

        $xml .= '</urlset>';

        // Save the file with public permissions
        $filePath = public_path('sitemap.xml');
        file_put_contents($filePath, $xml);

        return response()->json(['success' => true]);
    }

    public function categories()
    {
        $posts = Category::latest()->get();
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        foreach ($posts as $post) {
            $xml .= '<url>
            <loc>' . htmlspecialchars(url('category/' . $post->slug)) . '</loc>
            <priority>1.0</priority>
            <changefreq>daily</changefreq>
            </url>';
        }

        $xml .= '</urlset>';

        // Save the file with public permissions
        $filePath = public_path('category.xml');
        file_put_contents($filePath, $xml);

        return response()->json(['success' => true]);
    }

    public function brands()
    {
        $posts = Brand::latest()->get();
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        foreach ($posts as $post) {
            $xml .= '<url>
            <loc>' . htmlspecialchars(url('brand/' . $post->slug)) . '</loc>
            <priority>1.0</priority>
            <changefreq>daily</changefreq>
            </url>';
        }

        $xml .= '</urlset>';

        // Save the file with public permissions
        $filePath = public_path('brand.xml');
        file_put_contents($filePath, $xml);

        return response()->json(['success' => true]);
    }

    public function products_tag()
    {
        $products = Product::latest()->get();

        $chunkSize = 2500;
        $currentChunk = 1;
        $tagIndex = 0;

        while ($tagIndex < count($products)) {
            $xml = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
            $linksCount = 0;

            for ($i = 0; $i < $chunkSize && $tagIndex < count($products); $i++) {
                $product = $products[$tagIndex];
                $tags = explode(",", $product->tags);

                foreach ($tags as $tag) {
                    $tag = str_replace("&", "and", $tag);
                    $tag = urlencode(trim($tag)); // Ensure valid URL format
                    $url = url('tags/') . '/' . $tag;

                    $xml .= '<url>
                    <loc>' . $url . '</loc>
                    <priority>1.0</priority>
                    <changefreq>daily</changefreq>
                    </url>';

                    $linksCount++;
                    if ($linksCount >= $chunkSize) {
                        break 2; // Break both inner and outer loops
                    }
                }

                $tagIndex++;
            }

            $xml .= '</urlset>';
            $filename = "product_tags_{$currentChunk}.xml";
            $filePath = public_path($filename);

            file_put_contents($filePath, $xml);
            $currentChunk++;
        }

        return response()->json(['message' => 'Sitemaps generated successfully']);
    }

    /**
     * Display the homepage with sliders, featured products, and categories.
     * 
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function home(Request $request)
    {
        $today = Carbon::today()->toDateString();
        $ip = $request->ip();
        $location = Location::get($ip);
        $country = $location ? $location->countryName : 'Unknown';

        // Check if the visitor from this country has already been counted today
        $visitor = Visitor::where('visit_date', $today)
            ->where('country', $country)
            ->first();

        if (!$visitor) {
            // If not, create a new entry
            $visitor = Visitor::create([
                'visit_date' => $today,
                'country' => $country,
                'visitors' => 1, // Initial visit count
            ]);
        } else {
            // If visitor already exists, increment the count
            $visitor->increment('visitors');
        }
        $page = "home";
        $Slider = Slider::all();
        $Rating = Rating::all();
        $categories = Category::all();
        $setting = DB::table('setting')
            ->where('id', '=', '1')
            ->first();

        $meta = DB::table('setting')
            ->where('id', '=', '1')
            ->first();

        if ($meta) {
            $meta->image = '';
            $meta->url = url('/');

            $sch = [
                '@context' => 'https://schema.org/',
                '@type' => 'Product',
                'name' => $meta->title ?? 'Default Title',
                'description' => $meta->description ?? 'Default Description',
                'brand' => [
                    '@type' => 'Brand',
                    'name' => 'UAE Disar',
                ],
                'sku' => getSetting('site_title') . '_pk',
                'gtin13' => getSetting('phone') ?? '',
                'offers' => [
                    '@type' => 'AggregateOffer',
                    'url' => url()->current(),
                    'priceCurrency' => getSetting('currency') ?? 'USD',
                    'lowPrice' => '10',
                    'highPrice' => '500',
                    'offerCount' => '5',
                ],
                'aggregateRating' => [
                    '@type' => 'AggregateRating',
                    'ratingValue' => '5',
                    'bestRating' => '5',
                    'worstRating' => '1',
                    'ratingCount' => '1',
                    'reviewCount' => '1',
                ],
                'review' => [
                    '@type' => 'Review',
                    'name' => 'Fahad Khan',
                    'reviewBody' => 'Best Product',
                    'reviewRating' => [
                        '@type' => 'Rating',
                        'ratingValue' => '5',
                        'bestRating' => '5',
                        'worstRating' => '1',
                    ],
                    'datePublished' => '2022-05-01',
                    'author' => [
                        '@type' => 'Person',
                        'name' => getSetting('site_title') ?? 'Default Site',
                    ],
                    'publisher' => [
                        '@type' => 'Organization',
                        'name' => 'goodiset.com',
                    ],
                ],
            ];

            // Assign schema data to meta object
            $meta->scheme = json_encode($sch, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        }


        $products = Product::select('products.*')->where('status', 1)->orderBy('products.id', 'DESC')->get();
        $fproducts = Product::select('products.*')->where('status', 1)->where('featured', '1')->orderBy('products.id', 'DESC')->limit(10)->get();

        $aproducts = Product::select('products.*')->where('status', 1)->where('new_arrival', '1')->orderBy('products.id', 'DESC')->limit(5)->get();

        // $onslaeproducts=Product::select('products.*')->where('Sale','1')->orderBy('products.id','DESC')->limit(10)->get();
        $onslaeproducts = Product::where('status', 1)->inRandomOrder()->limit(10)->get();
        $Ratings = Rating::where('status', 1)->inRandomOrder()->limit(10)->get();
        $mostviewproducts = Product::select('products.*')->where('status', 1)->orderBy('view', 'DESC')->limit(10)->get();
        Session::put('title', 'Home');
        $flavours = Flavour::where('show_home', 1)->limit(6)->orderBy('id', 'ASC')->get();

        $faqs = Faq::where('page', 'general')->get();
        $home_categories = Category::where('status', 1)->orderBy('sort_no', 'asc')->get();
        $promotional_banners = PromotionalBanner::where('status', 1)->orderBy('sort_order', 'asc')->get();
        $homeVideos = HomePageVideo::query()->where('status', true)->orderBy('sort_order')->orderBy('id')->get();

        return view('front.home1', compact('page', 'Ratings', 'products', 'categories', 'home_categories', 'fproducts', 'setting', 'aproducts', 'mostviewproducts', 'Slider', 'Rating', 'meta', 'onslaeproducts', 'faqs', 'flavours', 'promotional_banners', 'homeVideos'));
    }

    /**
     * Show the user login page.
     * 
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function login()
    {
        if (session()->has('user')) {
            return redirect('/my_account');
        }
        Session::put('title', 'Login');
        return view('front.login');
    }
    public function cart_data()
    {
        return view('front.cart_data');
    }
    public function hearder_cart()
    {
        return view('front.hearder_cart');
    }
    public function user_login(Request $req)
    {
        // Validate the request data
        $req->validate([
            'login_email' => 'required|email',
            'g-recaptcha-response' => 'required'
        ]);

        // Verify reCAPTCHA
        $recaptchaSecret = config('services.recaptcha.secret_key');
        $recaptchaResponse = $req->input('g-recaptcha-response');

        $verifyResponse = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => $recaptchaSecret,
            'response' => $recaptchaResponse,
            'remoteip' => $req->ip()
        ])->json();

        // print_r($verifyResponse);die;

        if (!$verifyResponse['success']) {
            return redirect('/login')->with([
                'msg' => 'reCAPTCHA verification failed. Please try again.',
                'msg_type' => 'danger'
            ]);
        }

        // Find user by email
        $user = Customer::where('email', $req->login_email)->first();

        if ($user) {
            try {
                if (!filter_var($req->login_email, FILTER_VALIDATE_EMAIL)) {
                    return redirect('/login')->with([
                        'msg' => 'Invalid email format. Please check your email address.',
                        'msg_type' => 'danger'
                    ]);
                }
                $domain = substr(strrchr($req->login_email, "@"), 1);
                if (!checkdnsrr($domain, 'MX')) {
                    return redirect('/login')->with([
                        'msg' => 'Email domain appears invalid or unreachable.',
                        'msg_type' => 'danger'
                    ]);
                }
                $otp = random_int(1000, 9999);
                $user->otp = $otp;
                $user->save();
                $to = $user->email;
                $name = $user->name;
                $data = [
                    'user' => $user,
                ];
                Mail::send('emails.mail', $data, function ($message) use ($to, $name) {
                    $message->to($to, $name)
                        ->subject('OTP for Account Verification')
                        ->from(config('mail.from.address'), config('mail.from.name'));
                });
                return view('front.verify', compact('user'));
            } catch (\Exception $e) {
                Log::error('Mail error: ' . $e->getMessage());
                return redirect('/login')->with([
                    'msg' => 'Error sending OTP email. Please try again later.',
                    'msg_type' => 'danger'
                ]);
            }
        } else {
            return redirect('/login')->with([
                'msg' => 'User not found. Please try again.',
                'msg_type' => 'danger'
            ]);
        }
    }

    public function verify_login(Request $req)
    {
        Session::put('title', 'Verify Otp');
        $user = Customer::where(['email' => $req->email])->first();
        $data = Customer::all();
        if ($user) {
            $to_email = $user->email;
            $otp = $req->value1 . $req->value2 . $req->value3 . $req->value4;

            if ($user->otp == $otp) {
                $req->session()->flash('invalid', 'Success');
                $req->session()->put('user', $user);
                return redirect('/my_account');
            } else {

                // return "password not matched";
                $req->session()->flash('msg', 'Enter Correct Otp');
                $req->session()->flash('msg_type', 'danger');
                return view('front.verify', compact('user'));
            }
        } else {
            return redirect('/login')->with([
                'msg' => 'Please Try Again',
                'msg_type' => 'danger',
            ]);
            // $req->session()->flash('invalid','Invalid Email & Password');
            // return view('front.login');
        }
    }
    public function logout(Request $req)
    {
        if ($req->session()->has('user')) {
            $req->session()->pull('user');
            return redirect('/login');
        }
    }

    public function register(Request $req)
    {
        // Validate the request data
        $req->validate([
            'g-recaptcha-response' => 'required'
        ]);
        // Convert email to lowercase
        $email = strtolower($req->email);
        // Verify reCAPTCHA
        $recaptchaSecret = config('services.recaptcha.secret_key');
        $recaptchaResponse = $req->input('g-recaptcha-response');

        $verifyResponse = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => $recaptchaSecret,
            'response' => $recaptchaResponse,
            'remoteip' => $req->ip()
        ])->json();

        // print_r($verifyResponse);die;

        if (!$verifyResponse['success']) {
            return redirect()->back()->with([
                'msg' => 'reCAPTCHA verification failed. Please try again.',
                'msg_type' => 'danger'
            ]);
        }

        // Check if email already exists
        $check_email = Customer::where('email', $email)->first();
        if ($check_email) {
            return redirect()->back()->with([
                'msg' => 'This Email Address already Exists',
                'msg_type' => 'danger',
            ]);
        }

        // Generate a 4-digit OTP
        $otp = random_int(1000, 9999);

        // Create a new customer
        $User = new Customer();
        $User->name = $req->name;
        $User->email = $email; // Store email in lowercase
        $User->phone = $req->phone;
        $User->otp = $otp;

        if ($User->save()) {
            $to_name = $req->name;
            $to_email = $email; // Use lowercase email

            $data = [
                'user' => $User,
            ];

            try {
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    return redirect()->back()->with([
                        'msg' => 'Invalid email format. Please check your email address.',
                        'msg_type' => 'danger'
                    ]);
                }
                $domain = substr(strrchr($email, "@"), 1);
                if (!checkdnsrr($domain, 'MX')) {
                    return redirect()->back()->with([
                        'msg' => 'Email domain appears invalid or unreachable.',
                        'msg_type' => 'danger'
                    ]);
                }
                // Send a welcome email
                Mail::send('emails.welcome', $data, function ($message) use ($to_name, $to_email) {
                    $message->to($to_email, $to_name)
                        ->subject('Account Opening')
                        ->from(config('mail.from.address'), config('mail.from.name'));
                });

                // --- NEW: prepare values for Snap ---
                $normalizedEmail = strtolower(trim($User->email ?? ''));
                $normalizedPhone = preg_replace('/\D+/', '', (string)($User->phone ?? '')); // digits only
                // If you know country code, ensure E.164 here (e.g., add '1' for US if absent)

                $snapPayload = [
                    'sign_up_method'          => 'form', // or 'email', adjust if you capture method
                    'user_email'              => $normalizedEmail ?: null,
                    'user_phone_number'       => $normalizedPhone ?: null,
                    'user_hashed_email'       => $normalizedEmail ? hash('sha256', $normalizedEmail) : null,
                    'user_hashed_phone_number' => $normalizedPhone ? hash('sha256', $normalizedPhone) : null,
                ];

                return view('front.success', compact('User', 'snapPayload'));
            } catch (\Exception $e) {
                Log::error('Mail error: ' . $e->getMessage());
            }
        }

        return redirect('/user_register')->with([
            'msg' => 'Please Try Again',
            'msg_type' => 'danger',
        ]);
    }

    public function user_update(Request $request)
    {
        $in = array(

            'name' => $request->name,
            'email' => $request->email,
            'company' => $request->company,
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'country' => $request->country,
            'unit_type' => $request->unit_type,
            'unit_number' => $request->unit_number,
            'postal_code' => $request->postal_code,
        );
        $id = DB::table('customers')->where('id', $request->id)->update($in);
        $user = Customer::where(['email' => $request->email])->first();
        if ($id) {
            $request->session()->put('user', $user);
            return redirect('/my_account')->with([
                'msg' => 'User Updated successfully',
                'msg_type' => 'success',
            ]);
        } else {
            return redirect('/my_account')->with([
                'msg' => 'Please Try Again',
                'msg_type' => 'error',
            ]);
        }
    }

    public function forget_pass(Request $request)
    {
        if ($request->isMethod('post')) {
            $check_email = User::where('email', $request->email)->first();
            if (isset($check_email)) {
                $user = User::find($check_email->id);
                $user->password = Str::random(10);
                $user->save();
                $lastid = $user->id;
                if ($lastid) {
                    $pass = User::where('id', $lastid)->first();
                    $to_name = $check_email->name;
                    $to_email = $check_email->email;
                    $data = [
                        'name' => $to_name,
                        'password' => $pass->password,

                    ];
                    Mail::send('emails.password', $data, function ($message) use ($to_name, $to_email) {
                        $message->to($to_email, $to_name)
                            ->subject('Forget Password Email’');
                        $message->from('orders@dealstore.com.pk', 'DealStore');
                    });

                    return redirect()->back()->with([
                        'msg' => 'Your Password Is Sent To Your Email.',
                        'msg_type' => 'success',
                    ]);
                }
            } else {
                return redirect()->back()->with([
                    'msg' => 'This Email Not Found',
                    'msg_type' => 'success',
                ]);
            }
        }
        Session::put('title', 'Forget Password');
        return view('front.forget_pass');
    }

    public function subcribe_newsletter(Request $request)
    {
        $check_email = Newsletter::where('email', $request->email)->first();
        if (isset($check_email)) {
            return redirect()->back()->with([
                'msg' => 'This Email Address already Exists',
                'msg_type' => 'danger',
            ]);
        }

        $Newsletter = new Newsletter();
        $Newsletter->email = $request->email;
        $Newsletter->created_at = Date('Y-m-d h:i:s');
        $Newsletter->updated_at = Date('Y-m-d h:i:s');
        $Newsletter->save();
        return redirect()->back()->with([
            'msg' => 'Thank you for subscribing to our newsletter!',
            'msg_type' => 'success',
        ]);
    }
    public function product_detail($slug)
    {
        $allcatagories = Category::where(['status' => 1])->get();
        $Slider = Slider::all();
        $product = Product::where(['slug' => $slug, 'status' => 1])->get();

        if (count($product) > 0) {
            $pro = $product[0];

            $rat = Rating::where(['status' => 1, 'pid' => $pro->id])->first();
            $name = $rat ? $rat->name : '';
            $rateb = $rat ? $rat->review : '';
            $rate = $rat ? $rat->rate : '';

            $sett = Setting::where('id', '1')->first();
            $meta = DB::table('products_to_meta')->where('pid', $pro->id)->first();
            $brand = Brand::where(['id' => $pro->brand_id])->first();
            $rating = Rating::where(['status' => 1, 'pid' => $pro->id])->orderBy('id', 'Desc')->get();
            $rcount = Rating::where(['status' => 1, 'pid' => $pro->id])->count();
            $faq = Faq::where(['status' => 1, 'page' => 'general'])->get();
            $rpro = explode(',', $pro->category_id);
            $rproducts = Product::whereIn('category_id', $rpro)->inRandomOrder()->limit(10)->get();

            $pro->increment('view'); // Increase view count
            if ($meta) {
                $meta->url = url('/') . '/product/' . $pro->slug;
                $meta->image = url('/') . '/' . $pro->image_one;





                // ✅ Add Schema.org Structured Data for Product Detail Page
                $productSchema = [
                    '@context' => 'https://schema.org/',
                    '@type' => 'Product',
                    'name' => $pro->product_name,
                    'image' => url('/') . '/' . $pro->image_one,
                    'description' => strip_tags($pro->description),
                    'sku' => $pro->sku ?? 'N/A',
                    'brand' => [
                        '@type' => 'Brand',
                        'name' => $brand->name ?? 'Unknown Brand',
                    ],
                    'offers' => [
                        '@type' => 'Offer',
                        'priceCurrency' => getSetting('currency') ?? 'USD',
                        'price' => $pro->discount_price ?? '0',
                        'availability' => $pro->product_quantity > 0 ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
                        'url' => url('/product/' . $pro->slug),
                    ],
                    'aggregateRating' => [
                        '@type' => 'AggregateRating',
                        'ratingValue' => $rate ?? '0',
                        'bestRating' => '5',
                        'worstRating' => '1',
                        'ratingCount' => $rcount ?? '0',
                        'reviewCount' => $rcount ?? '0',
                    ],
                    'review' => [],
                ];

                // ✅ Add Reviews to Schema
                foreach ($rating as $rev) {
                    $productSchema['review'][] = [
                        '@type' => 'Review',
                        'author' => [
                            '@type' => 'Person',
                            'name' => $rev->name,
                        ],
                        'reviewBody' => $rev->review,
                        'reviewRating' => [
                            '@type' => 'Rating',
                            'ratingValue' => $rev->rate,
                            'bestRating' => '5',
                            'worstRating' => '1',
                        ],
                    ];
                }

                // Store schema in meta
                $meta->scheme = json_encode($productSchema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
            }
            Session::put('title', 'Product Detail');

            return view('front.product_detail', compact(
                'allcatagories',
                'brand',
                'sett',
                'product',
                'rcount',
                'rating',
                'faq',
                'Slider',
                'meta',
                'rproducts',
            ));
        } else {
            return abort(404);
        }
    }

    public function blog_detail($slug)
    {
        // Fetch the blog (published only)
        $blog = Blog::where('slug', $slug)->where('status', 1)->with('category')->firstOrFail();

        // Fetch related blogs (up to 3, same category, excluding current blog)
        $relatedBlogs = Blog::where('blog_category_id', $blog->blog_category_id)
            ->where('id', '!=', $blog->id)
            ->where('status', 1)
            ->latest()
            ->take(3)
            ->get();

        // Fetch comments for the blog
        $comments = Blog_Comment::where('bid', $blog->id)->latest()->get();

        // Fetch all categories
        $categories = BlogCategory::all();

        // Set dynamic session title
        Session::put('title', $blog->title);

        return view('front.blog_detail', compact('blog', 'relatedBlogs', 'comments', 'categories'));
    }
    public function blod_comment(Request $request)
    {
        // dd($request);
        $rating = new Blog_Comment();

        $rating->bid = $request->bid;
        $rating->comment = $request->cum;
        $rating->name = $request->name;
        // $rating->email=$request->email;
        // $rating->review=$request->review;
        $rating->save();

        $product = Blog_Post::where(['id' => $request->bid])->get();
        $pro = $product[0];

        return redirect('/blog/' . $product[0]->slug)->with([
            'msg' => 'Comment submit successfully',
            'msg_type' => 'success',
        ]);
    }

    public function contact_us(Request $request)
    {
        // dd($request);
        $rating = new Contact();

        $rating->name = $request->name;
        $rating->email = $request->email;
        $rating->meg = $request->meg;

        $rating->save();

        return redirect('/contact')->with([
            'msg' => 'Message send submit successfully',
            'msg_type' => 'success',
        ]);
    }

    public function celebrations(Request $request)
    {
        Session::put('title', 'Celebrations');
        $page = "celebrations";
        $theme = Theme::all();
        $faqs = Faq::where('page', 'celebration')->get();
        return view('front.celebrations', compact('page', 'theme', 'faqs'));
    }

    public function celebration_detail(Request $request)
    {

        $theme = Theme::where(['slug' => $request->slug])->first();
        $category_id = Theme::where(['slug' => $request->slug])->first();
        $themeid = $theme->id;
        Session::put('title', 'Celebrations');
        $product_sizes = [];
        $product_colors = [];
        $category = [];
        $theme = [];

        $product_size = Product::whereNotNull('product_size')
            ->distinct()
            ->pluck('product_size')
            ->flatMap(function ($size) {
                return is_string($size) ? explode(',', $size) : [$size];
            })
            ->filter(fn($size) => is_numeric($size))
            ->unique()
            ->values()
            ->toArray();

        if (count($product_size) > 0) {
            $product_sizes = $product_size;
        }

        $product_color = Product::whereNotNull('product_color')
            ->distinct()
            ->pluck('product_color')
            ->flatMap(function ($color) {
                return is_string($color) ? explode(',', $color) : [$color];
            })
            ->filter(fn($color) => is_numeric($color))
            ->unique()
            ->values()
            ->toArray();

        if (count($product_color) > 0) {
            $product_colors = $product_color;
        }

        $category = Product::whereNotNull('category_id')
            ->distinct()
            ->pluck('category_id')
            ->flatMap(function ($color) {
                return is_string($color) ? explode(',', $color) : [$color];
            })
            ->filter(fn($color) => is_numeric($color))
            ->unique()
            ->values()
            ->toArray();

        if (count($category) > 0) {
            $category = $category;
        }

        $theme_id = Product::whereNotNull('theme_id')
            ->distinct()
            ->pluck('theme_id')
            ->flatMap(function ($color) {
                return is_string($color) ? explode(',', $color) : [$color];
            })
            ->filter(fn($color) => is_numeric($color))
            ->unique()
            ->values()
            ->toArray();

        if (count($theme_id) > 0) {
            $theme = $theme_id;
        }

        $categories = Category::whereIn('id', $category)->get();

        $color = Colors::whereIn('id', $product_colors)->get();

        $size = Size::whereIn('id', $product_sizes)->get();

        $theme = Theme::whereIn('id', $theme)->get();

        $flavour = Flavour::whereIn(
            'id',
            Product::whereNotNull('flavour_id')->distinct()->pluck('flavour_id')->toArray()
        )->get();

        $brand = Brand::whereIn(
            'id',
            Product::whereNotNull('brand_id')->distinct()->pluck('brand_id')->toArray()
        )->get();

        $product_type = ProductType::whereIn(
            'id',
            Product::whereNotNull('product_type_id')->distinct()->pluck('product_type_id')->toArray()
        )->get();

        $package_type = PackageType::whereIn(
            'id',
            Product::whereNotNull('package_type_id')->distinct()->pluck('package_type_id')->toArray()
        )->get();

        $basket_type = BasketType::whereIn(
            'id',
            Product::whereNotNull('basket_type_id')->distinct()->pluck('basket_type_id')->toArray()
        )->get();

        $format = Format::whereIn(
            'id',
            Product::whereNotNull('format')->distinct()->pluck('format')->toArray()
        )->get();

        return view('front.shop', compact('themeid', 'brand', 'format', 'category_id', 'categories', 'color', 'size', 'theme', 'flavour', 'product_type', 'package_type', 'basket_type'));
    }

    public function pickmix(Request $request)
    {

        $theme = Format::where(['id' => 1])->first();
        $category_id = Format::where(['id' => 1])->first();
        $formatid = $theme->id;
        Session::put('title', 'Pick & Mix');

        $product_sizes = [];
        $product_colors = [];
        $category = [];
        $theme = [];

        $product_size = Product::whereNotNull('product_size')
            ->distinct()
            ->pluck('product_size')
            ->flatMap(function ($size) {
                return is_string($size) ? explode(',', $size) : [$size];
            })
            ->filter(fn($size) => is_numeric($size))
            ->unique()
            ->values()
            ->toArray();

        if (count($product_size) > 0) {
            $product_sizes = $product_size;
        }

        $product_color = Product::whereNotNull('product_color')
            ->distinct()
            ->pluck('product_color')
            ->flatMap(function ($color) {
                return is_string($color) ? explode(',', $color) : [$color];
            })
            ->filter(fn($color) => is_numeric($color))
            ->unique()
            ->values()
            ->toArray();

        if (count($product_color) > 0) {
            $product_colors = $product_color;
        }

        $category = Product::whereNotNull('category_id')
            ->distinct()
            ->pluck('category_id')
            ->flatMap(function ($color) {
                return is_string($color) ? explode(',', $color) : [$color];
            })
            ->filter(fn($color) => is_numeric($color))
            ->unique()
            ->values()
            ->toArray();

        if (count($category) > 0) {
            $category = $category;
        }

        $theme_id = Product::whereNotNull('theme_id')
            ->distinct()
            ->pluck('theme_id')
            ->flatMap(function ($color) {
                return is_string($color) ? explode(',', $color) : [$color];
            })
            ->filter(fn($color) => is_numeric($color))
            ->unique()
            ->values()
            ->toArray();

        if (count($theme_id) > 0) {
            $theme = $theme_id;
        }

        $categories = Category::whereIn('id', $category)->get();

        $color = Colors::whereIn('id', $product_colors)->get();

        $size = Size::whereIn('id', $product_sizes)->get();

        $theme = Theme::whereIn('id', $theme)->get();

        $flavour = Flavour::whereIn(
            'id',
            Product::whereNotNull('flavour_id')->distinct()->pluck('flavour_id')->toArray()
        )->get();

        $brand = Brand::whereIn(
            'id',
            Product::whereNotNull('brand_id')->distinct()->pluck('brand_id')->toArray()
        )->get();


        $product_type = ProductType::whereIn(
            'id',
            Product::whereNotNull('product_type_id')->distinct()->pluck('product_type_id')->toArray()
        )->get();

        $package_type = PackageType::whereIn(
            'id',
            Product::whereNotNull('package_type_id')->distinct()->pluck('package_type_id')->toArray()
        )->get();

        $basket_type = BasketType::whereIn(
            'id',
            Product::whereNotNull('basket_type_id')->distinct()->pluck('basket_type_id')->toArray()
        )->get();

        $format = Format::whereIn(
            'id',
            Product::whereNotNull('format')->distinct()->pluck('format')->toArray()
        )->get();
        return view('front.shop', compact('formatid', 'brand', 'category_id', 'categories', 'color', 'size', 'theme', 'flavour', 'product_type', 'package_type', 'basket_type', 'format'));
    }

    public function flavours(Request $request)
    {
        Session::put('title', 'Flavours');
        $page = "flavours";
        $theme = Flavour::all();
        return view('front.celebrations', compact('page', 'theme'));
    }

    public function flavour_detail(Request $request)
    {

        $theme = Flavour::where(['slug' => $request->slug])->first();
        $category_id = Flavour::where(['slug' => $request->slug])->first();
        $flavourid = $theme->id;
        Session::put('title', 'Flavours');
        $product_sizes = [];
        $product_colors = [];
        $category = [];
        $theme = [];

        $product_size = Product::whereNotNull('product_size')
            ->distinct()
            ->pluck('product_size')
            ->flatMap(function ($size) {
                return is_string($size) ? explode(',', $size) : [$size];
            })
            ->filter(fn($size) => is_numeric($size))
            ->unique()
            ->values()
            ->toArray();

        if (count($product_size) > 0) {
            $product_sizes = $product_size;
        }

        $product_color = Product::whereNotNull('product_color')
            ->distinct()
            ->pluck('product_color')
            ->flatMap(function ($color) {
                return is_string($color) ? explode(',', $color) : [$color];
            })
            ->filter(fn($color) => is_numeric($color))
            ->unique()
            ->values()
            ->toArray();

        if (count($product_color) > 0) {
            $product_colors = $product_color;
        }

        $category_id1 = Product::whereNotNull('category_id')
            ->distinct()
            ->pluck('category_id')
            ->flatMap(function ($color) {
                return is_string($color) ? explode(',', $color) : [$color];
            })
            ->filter(fn($color) => is_numeric($color))
            ->unique()
            ->values()
            ->toArray();

        if (count($category_id1) > 0) {
            $category = $category_id1;
        }

        $theme_id = Product::whereNotNull('theme_id')
            ->distinct()
            ->pluck('theme_id')
            ->flatMap(function ($color) {
                return is_string($color) ? explode(',', $color) : [$color];
            })
            ->filter(fn($color) => is_numeric($color))
            ->unique()
            ->values()
            ->toArray();

        if (count($theme_id) > 0) {
            $theme = $theme_id;
        }

        $categories = Category::whereIn('id', $category)->get();

        $color = Colors::whereIn('id', $product_colors)->get();

        $size = Size::whereIn('id', $product_sizes)->get();

        $theme = Theme::whereIn('id', $theme)->get();

        // $flavour = Flavour::whereIn(
        //     'id',
        //     Product::whereNotNull('flavour_id')->distinct()->pluck('flavour_id')->toArray()
        // )->get();

        $flavour = Flavour::all();

        $product_type = ProductType::whereIn(
            'id',
            Product::whereNotNull('product_type_id')->distinct()->pluck('product_type_id')->toArray()
        )->get();

        $package_type = PackageType::whereIn(
            'id',
            Product::whereNotNull('package_type_id')->distinct()->pluck('package_type_id')->toArray()
        )->get();

        $basket_type = BasketType::whereIn(
            'id',
            Product::whereNotNull('basket_type_id')->distinct()->pluck('basket_type_id')->toArray()
        )->get();

        $brand = Brand::whereIn(
            'id',
            Product::whereNotNull('brand_id')->distinct()->pluck('brand_id')->toArray()
        )->get();

        $format = Format::whereIn(
            'id',
            Product::whereNotNull('format')->distinct()->pluck('format')->toArray()
        )->get();

        return view('front.shop', compact('flavourid', 'brand', 'format', 'category_id', 'categories', 'color', 'size', 'theme', 'flavour', 'product_type', 'package_type', 'basket_type'));
    }

    public function shop(Request $request)
    {
        Session::put('title', 'Shop');
        $page = "shop";
        $product_sizes = [];
        $product_colors = [];
        $category = [];
        $theme = [];

        $product_size = Product::whereNotNull('product_size')
            ->distinct()
            ->pluck('product_size')
            ->flatMap(function ($size) {
                return is_string($size) ? explode(',', $size) : [$size];
            })
            ->filter(fn($size) => is_numeric($size))
            ->unique()
            ->values()
            ->toArray();

        if (count($product_size) > 0) {
            $product_sizes = $product_size;
        }

        $product_color = Product::whereNotNull('product_color')
            ->distinct()
            ->pluck('product_color')
            ->flatMap(function ($color) {
                return is_string($color) ? explode(',', $color) : [$color];
            })
            ->filter(fn($color) => is_numeric($color))
            ->unique()
            ->values()
            ->toArray();

        if (count($product_color) > 0) {
            $product_colors = $product_color;
        }

        $category_id = Product::whereNotNull('category_id')
            ->distinct()
            ->pluck('category_id')
            ->flatMap(function ($color) {
                return is_string($color) ? explode(',', $color) : [$color];
            })
            ->filter(fn($color) => is_numeric($color))
            ->unique()
            ->values()
            ->toArray();

        if (count($category_id) > 0) {
            $category = $category_id;
        }

        $theme_id = Product::whereNotNull('theme_id')
            ->distinct()
            ->pluck('theme_id')
            ->flatMap(function ($color) {
                return is_string($color) ? explode(',', $color) : [$color];
            })
            ->filter(fn($color) => is_numeric($color))
            ->unique()
            ->values()
            ->toArray();

        if (count($theme_id) > 0) {
            $theme = $theme_id;
        }

        $categories = Category::whereIn('id', $category)->get();

        $color = Colors::whereIn('id', $product_colors)->get();

        $size = Size::whereIn('id', $product_sizes)->get();

        $theme = Theme::whereIn('id', $theme)->get();

        $flavour = Flavour::whereIn(
            'id',
            Product::whereNotNull('flavour_id')->distinct()->pluck('flavour_id')->toArray()
        )->get();

        $brand = Brand::whereIn(
            'id',
            Product::whereNotNull('brand_id')->distinct()->pluck('brand_id')->toArray()
        )->get();

        $product_type = ProductType::whereIn(
            'id',
            Product::whereNotNull('product_type_id')->distinct()->pluck('product_type_id')->toArray()
        )->get();

        $package_type = PackageType::whereIn(
            'id',
            Product::whereNotNull('package_type_id')->distinct()->pluck('package_type_id')->toArray()
        )->get();

        $basket_type = BasketType::whereIn(
            'id',
            Product::whereNotNull('basket_type_id')->distinct()->pluck('basket_type_id')->toArray()
        )->get();

        $format = Format::whereIn(
            'id',
            Product::whereNotNull('format')->distinct()->pluck('format')->toArray()
        )->get();

        // $categories = Category::all();
        // $color = Colors::all();
        // $size = Size::all();
        // $theme = Theme::all();
        // $flavour = Flavour::all();
        // $product_type = ProductType::all();
        // $package_type = PackageType::all();
        // $basket_type = BasketType::all();
        // $format = Format::all();

        $best = Product::select('products.*')->orderBy('view', 'DESC')->limit(3)->get();
        return view('front.shop', compact('page', 'best', 'brand', 'categories', 'color', 'size', 'theme', 'flavour', 'product_type', 'package_type', 'basket_type', 'format'));
    }

    public function search_detail(Request $slug)
    {
        // $brands=Brand::all();
        $Slider = Slider::all();
        $categories = Category::all();
        // return $slug->input();
        $rproducts = product::where('product_name', 'ilike', '%' . $slug->text . '%')->get();
        $slugs = $slug->text;
        Session::put('title', 'Search');
        $product_sizes = [];
        $product_colors = [];
        $category = [];
        $theme = [];

        $product_size = Product::whereNotNull('product_size')
            ->distinct()
            ->pluck('product_size')
            ->flatMap(function ($size) {
                return is_string($size) ? explode(',', $size) : [$size];
            })
            ->filter(fn($size) => is_numeric($size))
            ->unique()
            ->values()
            ->toArray();

        if (count($product_size) > 0) {
            $product_sizes = $product_size;
        }

        $product_color = Product::whereNotNull('product_color')
            ->distinct()
            ->pluck('product_color')
            ->flatMap(function ($color) {
                return is_string($color) ? explode(',', $color) : [$color];
            })
            ->filter(fn($color) => is_numeric($color))
            ->unique()
            ->values()
            ->toArray();

        if (count($product_color) > 0) {
            $product_colors = $product_color;
        }

        $category_id = Product::whereNotNull('category_id')
            ->distinct()
            ->pluck('category_id')
            ->flatMap(function ($color) {
                return is_string($color) ? explode(',', $color) : [$color];
            })
            ->filter(fn($color) => is_numeric($color))
            ->unique()
            ->values()
            ->toArray();

        if (count($category_id) > 0) {
            $category = $category_id;
        }

        $theme_id = Product::whereNotNull('theme_id')
            ->distinct()
            ->pluck('theme_id')
            ->flatMap(function ($color) {
                return is_string($color) ? explode(',', $color) : [$color];
            })
            ->filter(fn($color) => is_numeric($color))
            ->unique()
            ->values()
            ->toArray();

        if (count($theme_id) > 0) {
            $theme = $theme_id;
        }

        $categories = Category::whereIn('id', $category)->get();

        $color = Colors::whereIn('id', $product_colors)->get();

        $size = Size::whereIn('id', $product_sizes)->get();

        $theme = Theme::whereIn('id', $theme)->get();

        $flavour = Flavour::whereIn(
            'id',
            Product::whereNotNull('flavour_id')->distinct()->pluck('flavour_id')->toArray()
        )->get();

        $brand = Brand::whereIn(
            'id',
            Product::whereNotNull('brand_id')->distinct()->pluck('brand_id')->toArray()
        )->get();

        $product_type = ProductType::whereIn(
            'id',
            Product::whereNotNull('product_type_id')->distinct()->pluck('product_type_id')->toArray()
        )->get();

        $package_type = PackageType::whereIn(
            'id',
            Product::whereNotNull('package_type_id')->distinct()->pluck('package_type_id')->toArray()
        )->get();

        $basket_type = BasketType::whereIn(
            'id',
            Product::whereNotNull('basket_type_id')->distinct()->pluck('basket_type_id')->toArray()
        )->get();

        $format = Format::whereIn(
            'id',
            Product::whereNotNull('format')->distinct()->pluck('format')->toArray()
        )->get();
        return view('front.shop', compact('rproducts', 'brand', 'format', 'slugs', 'categories', 'categories', 'color', 'size', 'theme', 'flavour', 'product_type', 'package_type', 'basket_type'));
    }

    // public function fetchProducts(Request $request)
    // {
    //     $query = Product::query();

    //     $searchObj = new \stdClass();
    //     $categoryObj = new \stdClass();

    //     if ($request->has('selected_cate')) {
    //         $category_id = $request->selected_cate;
    //         $searchObj = CategoryCondition::where('category_id', $category_id)->select('type', 'condition', 'condition_value')->get();
    //         $categoryObj = Category::where('id', $category_id)->select('id', 'is_manual', 'is_condition')->first();
    //         // $query->whereRaw("? = ANY(string_to_array(category_id, ','))", [$category_id]);
    //     }

    //     // Apply filters based on request data
    //     if ($request->has('category_id')) {
    //         $category_id = $request->category_id;
    //         $searchObj = CategoryCondition::where('category_id', $category_id)->select('type', 'condition', 'condition_value')->get();
    //         $categoryObj = Category::where('id', $category_id)->select('id', 'is_manual', 'is_condition')->first();
    //         // $query->whereRaw("? = ANY(string_to_array(category_id, ','))", [$category_id]);
    //     }



    //     if (isset($categoryObj->is_manual) && $categoryObj->is_manual == 2) {
    //         if ($searchObj->count() > 0) {
    //             foreach ($searchObj as $key => $val) {
    //                 $method = $categoryObj->is_condition == 2 ? 'orWhere' : 'where';

    //                 if (trim($val->type) == 'Price') {

    //                     $query->$method('discount_price', $val->condition, intval($val->condition_value));
    //                 }

    //                 if (trim($val->type) == 'Format') {
    //                     $query->$method('format', $val->condition, intval($val->condition_value));
    //                 }

    //                 if (trim($val->type) == 'Tag') {
    //                     $conditionValues = explode(',', $val->condition_value);
    //                     $tagValues = array_map(fn($value) => str_replace(' ', '', trim($value)), $conditionValues);

    //                     foreach ($tagValues as $tag) {
    //                         $query->$method('tags', 'LIKE', '%' . $tag . '%');
    //                     }
    //                 }

    //                 if (trim($val->type) == 'Title') {
    //                     $query->$method('product_name', $val->condition, $val->condition_value);
    //                 }

    //                 if (trim($val->type) == 'Products') {
    //                     if ($val->condition_value) {
    //                         $conditionValues = explode(',', $val->condition_value);
    //                         $query->whereIn('id', $conditionValues);
    //                     }
    //                 }

    //                 if (trim($val->type) == 'Made in') {
    //                     $query->$method('country', $val->condition, intval($val->condition_value));
    //                 }

    //                 if (trim($val->type) == 'Brand') {
    //                     $query->$method('brand_id', $val->condition, intval($val->condition_value));
    //                 }

    //                 if (trim($val->type) == 'Theme') {
    //                     $query->$method('theme_id', $val->condition, intval($val->condition_value));
    //                 }

    //                 if (trim($val->type) == 'Flavour') {
    //                     $query->$method('flavour_id', $val->condition, intval($val->condition_value));
    //                 }

    //                 if (trim($val->type) == 'Color') {
    //                     $query->$method('product_color', $val->condition, intval($val->condition_value));
    //                 }

    //                 if (trim($val->type) == 'Allergens') {
    //                     $query->$method('allergen', $val->condition, intval($val->condition_value));
    //                 }

    //                 if (trim($val->type) == 'Weight') {
    //                     $query->$method('weight', $val->condition, $val->condition_value);
    //                 }
    //             }
    //         }
    //     } else {

    //         if ($request->has('selected_cate')) {
    //             $category_id = $request->selected_cate;
    //             $query->whereRaw("? = ANY(string_to_array(category_id, ','))", [$category_id]);
    //         }

    //         // Apply filters based on request data
    //         if ($request->has('category_id')) {
    //             $category_id = $request->category_id;
    //             $query->whereRaw("? = ANY(string_to_array(category_id, ','))", [$category_id]);
    //         }

    //         if ($request->has('product_type_id')) {
    //             $query->where('product_type_id', $request->product_type_id);
    //         }
    //         if ($request->has('theme_id')) {
    //             $theme_id = $request->theme_id;

    //             $query->whereRaw("? = ANY(string_to_array(theme_id, ','))", [$theme_id]);
    //         }
    //         if ($request->has('color_id')) {
    //             $colorId = $request->color_id;

    //             $query->whereRaw("? = ANY(string_to_array(product_color, ','))", [$colorId]);
    //         }
    //         if ($request->has('size_id')) {
    //             $colorId = $request->size_id;

    //             $query->whereRaw("? = ANY(string_to_array(product_size, ','))", [$colorId]);
    //         }

    //         if ($request->has('package_type_id')) {
    //             $query->where('package_type_id', $request->package_type_id);
    //         }
    //         if ($request->has('flavour_id')) {
    //             $query->where('flavour_id', $request->flavour_id);
    //         }
    //         if ($request->has('flavour_id')) {
    //             $query->where('flavour_id', $request->flavour_id);
    //         }
    //         if ($request->has('basket_type_id')) {
    //             $query->where('basket_type_id', $request->basket_type_id);
    //         }
    //         if ($request->has('format_id')) {
    //             $query->where('format', $request->format_id);
    //         }
    //         if ($request->has('brand_id')) {
    //             $query->where('brand_id', $request->brand_id);
    //         }
    //         if ($request->has('slug')) {
    //             $query->where('product_name', 'ilike', '%' . $request->slug . '%');
    //         }
    //     }
    //     $query->where('status', 1);
    //     // Pagination with 40 items per page
    //     $products = $query->orderByRaw("CASE WHEN COALESCE(sort_order, 0) > 0 THEN sort_order ELSE 9999999 END ASC, product_name ASC")->paginate(24);

    //     // $products = $query->orderBy('id', 'desc')->paginate(24);
    //     $products->getCollection()->transform(function ($product) {
    //         $totalRate = Rating::where('pid', $product->id)
    //             ->where('status', 1)
    //             ->sum('rate');

    //         $totalCount = Rating::where('pid', $product->id)
    //             ->where('status', 1)
    //             ->count();

    //         $product->average_rating = $totalCount > 0 ? $totalRate / $totalCount : 0;

    //         $product->in_cart = \App\Helpers\Cart::has_pro($product->id); // Check if product is in cart
    //         $format = $product->format == 1 ? '100 g' : 1;
    //         $cartQuantity = \App\Helpers\Cart::product_qty($product->id) ?? 1;
    //         $product->in_cart_quantity = $product->format == 1 ? ($cartQuantity * 100) . ' g' : ($cartQuantity * 1);
    //         $product->cart_quantity = $cartQuantity;


    //         return $product;
    //     });

    //     // Return JSON response with products and pagination info
    //     return response()->json([
    //         'products' => $products->items(),
    //         'pagination' => [
    //             'total' => $products->total(),
    //             'per_page' => $products->perPage(), // Add this line to include 'per_page'
    //             'current_page' => $products->currentPage(),
    //             'last_page' => $products->lastPage(),
    //             'prev_page_url' => $products->previousPageUrl(),
    //             'next_page_url' => $products->nextPageUrl(),
    //         ],
    //     ]);
    // }
    public function fetchProducts(Request $request)
    {
        $query = Product::query();

        $searchObj = new \stdClass();
        $categoryObj = new \stdClass();

        if ($request->has('selected_cate')) {
            $category_id = $request->selected_cate;
            $searchObj = CategoryCondition::where('category_id', $category_id)->get();
            $categoryObj = Category::where('id', $category_id)->first();
        }

        if ($request->has('category_id')) {
            $category_id = $request->category_id;
            $searchObj = CategoryCondition::where('category_id', $category_id)->get();
            $categoryObj = Category::where('id', $category_id)->first();
        }

        /** -------------------------
         *   CATEGORY CONDITION LOGIC
         * -------------------------*/
        if (isset($categoryObj->is_manual) && $categoryObj->is_manual == 2) {
            if ($searchObj->count() > 0) {
                foreach ($searchObj as $val) {
                    $method = $categoryObj->is_condition == 2 ? 'orWhere' : 'where';

                    switch (trim($val->type)) {
                        case 'Price':
                            $query->$method('discount_price', $val->condition, intval($val->condition_value));
                            break;

                        case 'Format':
                            $query->$method('format', $val->condition, intval($val->condition_value));
                            break;

                        case 'Tag':
                            $tags = explode(',', $val->condition_value);
                            foreach ($tags as $tag) {
                                $query->$method('tags', 'LIKE', '%' . trim($tag) . '%');
                            }
                            break;

                        case 'Title':
                            $query->$method('product_name', $val->condition, $val->condition_value);
                            break;

                        case 'Products':
                            $ids = explode(',', $val->condition_value);
                            $query->whereIn('id', $ids);
                            break;

                        case 'Made in':
                            $query->$method('country', $val->condition, intval($val->condition_value));
                            break;

                        case 'Brand':
                            $query->$method('brand_id', $val->condition, intval($val->condition_value));
                            break;

                        case 'Theme':
                            $query->$method('theme_id', $val->condition, intval($val->condition_value));
                            break;

                        case 'Flavour':
                            $query->$method('flavour_id', $val->condition, intval($val->condition_value));
                            break;

                        case 'Color':
                            $query->$method('product_color', $val->condition, intval($val->condition_value));
                            break;

                        case 'Allergens':
                            $query->$method('allergen', $val->condition, intval($val->condition_value));
                            break;

                        case 'Weight':
                            $query->$method('weight', $val->condition, $val->condition_value);
                            break;
                    }
                }
            }
        } else {
            /** -------------------------
             *   NORMAL FILTERS
             * -------------------------*/
            if ($request->has('selected_cate')) {
                $query->whereRaw("? = ANY(string_to_array(category_id, ','))", [$request->selected_cate]);
            }
            if ($request->has('category_id')) {
                $query->whereRaw("? = ANY(string_to_array(category_id, ','))", [$request->category_id]);
            }
            if ($request->has('product_type_id')) {
                $query->where('product_type_id', $request->product_type_id);
            }
            if ($request->has('theme_id')) {
                $query->whereRaw("? = ANY(string_to_array(theme_id, ','))", [$request->theme_id]);
            }
            if ($request->has('color_id')) {
                $query->whereRaw("? = ANY(string_to_array(product_color, ','))", [$request->color_id]);
            }
            if ($request->has('size_id')) {
                $query->whereRaw("? = ANY(string_to_array(product_size, ','))", [$request->size_id]);
            }
            if ($request->has('package_type_id')) {
                $query->where('package_type_id', $request->package_type_id);
            }
            if ($request->has('flavour_id')) {
                $query->where('flavour_id', $request->flavour_id);
            }
            if ($request->has('basket_type_id')) {
                $query->where('basket_type_id', $request->basket_type_id);
            }
            if ($request->has('format_id')) {
                $query->where('format', $request->format_id);
            }
            if ($request->has('brand_id')) {
                $query->where('brand_id', $request->brand_id);
            }
            if ($request->has('slug')) {
                $query->where('product_name', 'ilike', '%' . $request->slug . '%');
            }
        }

        $query->where('status', 1);

        $products = $query
            ->orderByRaw("CASE WHEN COALESCE(sort_order,0)>0 THEN sort_order ELSE 999999 END ASC, product_name ASC")
            ->paginate(24);

        /** -------------------------
         *   ENRICH PRODUCT DATA
         * -------------------------*/
        $products->getCollection()->transform(function ($product) {
            $totalRate = Rating::where('pid', $product->id)->where('status', 1)->sum('rate');
            $count = Rating::where('pid', $product->id)->where('status', 1)->count();
            $product->average_rating = $count ? $totalRate / $count : 0;

            $product->in_cart = Cart::has_pro($product->id);
            $qty = Cart::product_qty($product->id) ?? 1;

            $product->cart_quantity = $qty;
            $product->in_cart_quantity = $product->format == 1 ? ($qty * 100) . " g" : $qty;

            return $product;
        });

        /** -----------------------------------
         *  🔥 RENDER PRODUCT CARDS USING BLADE
         * -----------------------------------*/
        $html = view('partials.product-cards', [
            'products' => $products,
        ])->render();

        return response()->json([
            'html' => $html,
            'pagination' => [
                'total' => $products->total(),
                'per_page' => $products->perPage(),
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
            ],
        ]);
    }


    public function user_register(Request $request)
    {
        Session::put('title', 'User Register');

        return view('front.register');
    }

    public function category_detail($slug)
    {
        //redirect to  https://www.goodisetsubscription.com
        if ($slug === 'subscription') {
            return redirect('https://www.goodisetsubscription.com');
        }

        $Slider = Slider::all();
        // $categories = Category::all();
        $best = Product::select('products.*')->orderBy('view', 'DESC')->limit(3)->get();

        $category_id = Category::where(['slug' => $slug])->first();
        $category_id->increment('view');
        $cateid = $category_id->id;
        if (isset($category_id->name)) {
            Session::put('title', $category_id->name);
        }

        $meta = DB::table('categories_to_meta')
            ->where('cid', '=', $category_id->id)
            ->first();
        if ($meta) {
            $meta->image = '';
            $meta->url = url('/category/') . '/' . $slug;
            $sch = array(
                '@context' => 'https://schema.org/',
                '@type' => 'Category',
                'name' => $meta->title,
                'description' => $meta->description,
                'brand' => array(
                    '@type' => 'Brand',
                    'name' => 'UAE Disar',
                ),
                'sku' => 'DealStore_diSUa',
                'gtin13' => '54435345',
                'offers' => array(
                    '@type' => 'AggregateOffer',
                    'url' => url()->current(),
                    'priceCurrency' => 'PKR',
                    'lowPrice' => '1999',
                    'highPrice' => '2000',
                    'offerCount' => '5',
                ),
                'aggregateRating' => array(
                    '@type' => 'AggregateRating',
                    'ratingValue' => '5',
                    'bestRating' => '5',
                    'worstRating' => '1',
                    'ratingCount' => '1',
                    'reviewCount' => '1',
                ),
                'review' => array(
                    '@type' => 'Review',
                    'name' => 'Fahad Khan',
                    'reviewBody' => 'Best Product',
                    'reviewRating' => array(
                        '@type' => 'Rating',
                        'ratingValue' => '5',
                        'bestRating' => '5',
                        'worstRating' => '1',
                    ),
                    'datePublished' => '2022-05-01',
                    'author' => array(
                        '@type' => 'Person',
                        'name' => 'DealStore',
                    ),
                    'publisher' => array(
                        '@type' => 'Organization',
                        'name' => 'DealStore.com.pk',
                    ),
                ),
            );
            // $meta->scheme = $sch;
        }

        $products = Product::where(['category_id' => $cateid, 'status' => 1])->orderby('id', 'desc')->paginate(40);
        $product_sizes = [];
        $product_colors = [];
        $category = [];
        $theme = [];

        $product_size = Product::whereNotNull('product_size')
            ->distinct()
            ->pluck('product_size')
            ->flatMap(function ($size) {
                return is_string($size) ? explode(',', $size) : [$size];
            })
            ->filter(fn($size) => is_numeric($size))
            ->unique()
            ->values()
            ->toArray();

        if (count($product_size) > 0) {
            $product_sizes = $product_size;
        }

        $product_color = Product::whereNotNull('product_color')
            ->distinct()
            ->pluck('product_color')
            ->flatMap(function ($color) {
                return is_string($color) ? explode(',', $color) : [$color];
            })
            ->filter(fn($color) => is_numeric($color))
            ->unique()
            ->values()
            ->toArray();

        if (count($product_color) > 0) {
            $product_colors = $product_color;
        }

        $category = Product::whereNotNull('category_id')
            ->distinct()
            ->pluck('category_id')
            ->flatMap(function ($color) {
                return is_string($color) ? explode(',', $color) : [$color];
            })
            ->filter(fn($color) => is_numeric($color))
            ->unique()
            ->values()
            ->toArray();

        if (count($category) > 0) {
            $category = $category;
        }

        $theme_id = Product::whereNotNull('theme_id')
            ->distinct()
            ->pluck('theme_id')
            ->flatMap(function ($color) {
                return is_string($color) ? explode(',', $color) : [$color];
            })
            ->filter(fn($color) => is_numeric($color))
            ->unique()
            ->values()
            ->toArray();

        if (count($theme_id) > 0) {
            $theme = $theme_id;
        }

        $categories = Category::whereIn('id', $category)->get();

        $color = Colors::whereIn('id', $product_colors)->get();

        $size = Size::whereIn('id', $product_sizes)->get();

        $theme = Theme::whereIn('id', $theme)->get();

        $flavour = Flavour::whereIn(
            'id',
            Product::whereNotNull('flavour_id')->distinct()->pluck('flavour_id')->toArray()
        )->get();

        $brand = Brand::whereIn(
            'id',
            Product::whereNotNull('brand_id')->distinct()->pluck('brand_id')->toArray()
        )->get();

        $product_type = ProductType::whereIn(
            'id',
            Product::whereNotNull('product_type_id')->distinct()->pluck('product_type_id')->toArray()
        )->get();

        $package_type = PackageType::whereIn(
            'id',
            Product::whereNotNull('package_type_id')->distinct()->pluck('package_type_id')->toArray()
        )->get();

        $basket_type = BasketType::whereIn(
            'id',
            Product::whereNotNull('basket_type_id')->distinct()->pluck('basket_type_id')->toArray()
        )->get();

        $format = Format::whereIn(
            'id',
            Product::whereNotNull('format')->distinct()->pluck('format')->toArray()
        )->get();
        return view('front.shop', compact('meta', 'format', 'brand', 'products', 'cateid', 'category_id', 'best', 'categories', 'color', 'size', 'theme', 'flavour', 'product_type', 'package_type', 'basket_type'));
    }

    public function blog_category($id)
    {
        $cate = Blog_Category::all();
        $meta = Blog_Category::where(['slug' => $id])->first();
        $category_id = Blog_Category::where(['slug' => $id])->first();
        $cateid = $category_id->id;
        if (isset($category_id->title_english)) {
            Session::put('title', $category_id->title_english);
        }

        $post = Blog_Post::where(['category_id' => $cateid])->get();

        return view('front.blogs', compact('post', 'category_id', 'meta', 'cate'));
    }
    public function blogs(Request $request)
    {
        Session::put('title', 'Blogs');

        // Query for blogs
        $query = Blog::query()->where('status', 1); // Only published blogs

        // Search filter
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'ilike', '%' . $search . '%')
                    ->orWhere('short_description', 'ilike', '%' . $search . '%');
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('blog_category_id', $request->input('category'));
        }

        // Paginate blogs (6 per page)
        $posts = $query->with('category')->latest()->paginate(6);

        // Get all categories for dropdown
        $categories = BlogCategory::all();

        return view('front.blog', compact('posts', 'categories'));
    }

    public function cart()
    {
        Session::put('title', 'Cart');
        $userCountry = 'United Arab Emirates';
        $aproducts = Product::select('products.*')->where('status', 1)->where('new_arrival', '1')->orderBy('products.id', 'DESC')->limit(3)->get();
        $countries = Countries::where('status', 1)->get();
        return view('front.cart', compact('aproducts', 'userCountry', 'countries'));
    }

    /**
     * HTML fragment for the header mini-cart drawer (no layout wrapper).
     */
    public function cartDrawer()
    {
        $aproducts = Product::select('products.*')
            ->where('status', 1)
            ->where('new_arrival', '1')
            ->orderBy('products.id', 'DESC')
            ->limit(8)
            ->get();

        $cartQty = 0;
        $cartAmount = 0.0;
        if (Session::has('cart')) {
            $c = Session::get('cart');
            $cartQty = (int) ($c['qty'] ?? 0);
            $cartAmount = (float) ($c['amount'] ?? 0);
        }

        return view('includes.front.cart-drawer-inner', compact('aproducts', 'cartQty', 'cartAmount'));
    }

    // public function contact(Request $request)
    // {
    //     // dd($request);
    //     if ($request->submit) {
    //         // Verify reCAPTCHA
    //         $recaptchaSecret = env('RECAPTCHA_SECRET_KEY'); // Add this to your .env file
    //         $recaptchaResponse = $request->input('g-recaptcha-response');

    //         $verifyResponse = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
    //             'secret' => $recaptchaSecret,
    //             'response' => $recaptchaResponse,
    //             'remoteip' => $request->ip()
    //         ])->json();

    //         if (!$verifyResponse['success']) {
    //             return redirect('/contact-us')->with([
    //                 'msg' => 'reCAPTCHA verification failed. Please try again.',
    //                 'msg_type' => 'danger'
    //             ]);
    //         }

    //         if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
    //             return redirect('/contact-us')->with([
    //                 'msg' => 'Invalid email format. Please check your email address.',
    //                 'msg_type' => 'danger'
    //             ]);
    //         }
    //         $domain = substr(strrchr($request->email, "@"), 1);
    //         if (!checkdnsrr($domain, 'MX')) {
    //             return redirect('/contact-us')->with([
    //                 'msg' => 'Email domain appears invalid or unreachable.',
    //                 'msg_type' => 'danger'
    //             ]);
    //         }

    //         $contact = Contact::create($request->all());
    //         $lastid = $contact->id;
    //         $contact_list = Contact::where('id', $lastid)->first();



    //         if ($contact_list->contact_type == 'Customers') {
    //             try {
    //                 $to_name = $request->name;
    //                 $to_email = $request->email;
    //                 $data = [
    //                     'user' => $contact_list,
    //                 ];
    //                 Mail::send('emails.CustomerInquiry', $data, function ($message) use ($to_name, $to_email) {
    //                     $message->to($to_email, $to_name)
    //                         ->subject('Contact');
    //                     $message->from(config('mail.from.address'), config('mail.from.name'));
    //                 });
    //             } catch (\Exception $e) {
    //                 \Log::error('Failed to send customer creation email: ' . $e->getMessage());
    //             }
    //         } elseif ($contact_list->contact_type == 'Franchise') {
    //             try {
    //                 $to_name = $request->name;
    //                 $to_email = $request->email;
    //                 $data = [
    //                     'user' => $contact_list,
    //                 ];
    //                 Mail::send('emails.FranchiseInquiry', $data, function ($message) use ($to_name, $to_email) {
    //                     $message->to($to_email, $to_name)
    //                         ->subject('Contact');
    //                     $message->from(config('mail.from.address'), config('mail.from.name'));
    //                 });
    //             } catch (\Exception $e) {
    //                 \Log::error('Failed to send customer creation email: ' . $e->getMessage());
    //             }
    //         } elseif ($contact_list->contact_type == 'Retailers') {
    //             try {
    //                 $to_name = $request->name;
    //                 $to_email = $request->email;
    //                 $data = [
    //                     'user' => $contact_list,
    //                 ];
    //                 Mail::send('emails.RetailerInquiry', $data, function ($message) use ($to_name, $to_email) {
    //                     $message->to($to_email, $to_name)
    //                         ->subject('Contact');
    //                     $message->from(config('mail.from.address'), config('mail.from.name'));
    //                 });
    //             } catch (\Exception $e) {
    //                 \Log::error('Failed to send customer creation email: ' . $e->getMessage());
    //             }
    //         } elseif ($contact_list->contact_type == 'Event Organizer') {
    //             try {
    //                 $to_name = $request->name;
    //                 $to_email = $request->email;
    //                 $data = [
    //                     'user' => $contact_list,
    //                 ];
    //                 Mail::send('emails.OrganiserInquiry', $data, function ($message) use ($to_name, $to_email) {
    //                     $message->to($to_email, $to_name)
    //                         ->subject('Contact');
    //                     $message->from(config('mail.from.address'), config('mail.from.name'));
    //                 });
    //             } catch (\Exception $e) {
    //                 \Log::error('Failed to send customer creation email: ' . $e->getMessage());
    //             }
    //         } elseif ($contact_list->contact_type == 'inquiry') {
    //             try {
    //                 $to_name = $request->name;
    //                 $to_email = $request->email;
    //                 $data = [
    //                     'user' => $contact_list,
    //                 ];
    //                 Mail::send('emails.Inquiry', $data, function ($message) use ($to_name, $to_email) {
    //                     $message->to($to_email, $to_name)
    //                         ->subject('Contact');
    //                     $message->from(config('mail.from.address'), config('mail.from.name'));
    //                 });
    //             } catch (\Exception $e) {
    //                 \Log::error('Failed to send customer creation email: ' . $e->getMessage());
    //             }
    //         }

    //         return redirect()->route('contact-us')->with([
    //             'msg' => 'Request Submit Successfully!',
    //             'msg_type' => 'success',
    //         ]);
    //     }
    //     $page = Pages::where(['slug' => 'contact-us'])->first();
    //     $page->increment('view');
    //     Session::put('title', 'Contact Us');
    //     return view('front.contact', compact('page'));
    // }

    public function contact(Request $request)
    {
        if ($request->has('submit')) {

            // Verify reCAPTCHA
            $recaptchaSecret = config('services.recaptcha.secret_key');
            $recaptchaResponse = $request->input('g-recaptcha-response');

            $verifyResponse = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => $recaptchaSecret,
                'response' => $recaptchaResponse,
                'remoteip' => $request->ip()
            ])->json();

            if (!$verifyResponse['success']) {
                \Log::warning('reCAPTCHA verification failed', ['response' => $verifyResponse]);
                return redirect()->back()->with([
                    'msg' => 'reCAPTCHA verification failed. Please try again.',
                    'msg_type' => 'danger'
                ]);
            }

            // Validate email format
            if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
                \Log::error('Invalid email format: ' . $request->email);
                return redirect()->back()->with([
                    'msg' => 'Invalid email format. Please check your email address.',
                    'msg_type' => 'danger'
                ]);
            }

            // Validate email domain (only in production)
            $domain = substr(strrchr($request->email, "@"), 1);
            if (app()->environment('production') && !checkdnsrr($domain, 'MX') && !checkdnsrr($domain, 'A')) {
                \Log::error('Invalid email domain: ' . $domain);
                return redirect()->back()->with([
                    'msg' => 'Email domain appears invalid or unreachable.',
                    'msg_type' => 'danger'
                ]);
            }

            // Save contact data
            $contact = Contact::create($request->all());
            $contact_list = Contact::findOrFail($contact->id);

            // Send email based on contact type
            $emailTemplates = [
                'Customers' => 'emails.CustomerInquiry',
                'Franchise' => 'emails.FranchiseInquiry',
                'Retailers' => 'emails.RetailerInquiry',
                'Resellers' => 'emails.ResellerInquiry',
                'Influencers' => 'emails.InfluencerInquiry',
                'Event Organizer' => 'emails.OrganiserInquiry',
                'inquiry' => 'emails.Inquiry',
                'corporate_events' => 'emails.CorporateInquiry',
            ];

            if (array_key_exists($contact_list->contact_type, $emailTemplates)) {
                try {
                    $to_name = $request->name;
                    $to_email = $request->email;
                    $data = ['user' => $contact_list];

                    Mail::send($emailTemplates[$contact_list->contact_type], $data, function ($message) use ($to_name, $to_email) {
                        $message->to($to_email, $to_name)
                            ->subject('Contact')
                            ->from(config('mail.from.address'), config('mail.from.name'));
                    });
                } catch (\Exception $e) {
                    \Log::error('Failed to send email for contact type ' . $contact_list->contact_type . ': ' . $e->getMessage());
                }

                try {
                    $to_name = "Admin";
                    $to_email = "info@goodiset.com";
                    $data = ['user' => $contact_list];

                    Mail::send($emailTemplates[$contact_list->contact_type], $data, function ($message) use ($to_name, $to_email) {
                        $message->to($to_email, $to_name)
                            ->subject('Contact')
                            ->from(config('mail.from.address'), config('mail.from.name'));
                    });
                } catch (\Exception $e) {
                    \Log::error('Failed to send email for contact type ' . $contact_list->contact_type . ': ' . $e->getMessage());
                }
            } else {
                \Log::warning('Unknown contact type: ' . $contact_list->contact_type);
            }

            return redirect()->back()->with([
                'msg' => 'Request Submitted Successfully!',
                'msg_type' => 'success',
            ]);
        }

        // Load contact page
        $page = Pages::where(['slug' => 'contact-us'])->firstOrFail();
        $page->increment('view');
        Session::put('title', 'Contact Us');
        return view('front.contact', compact('page'));
    }

    public function track_order(Request $request)
    {
        $product = Order::where(['order_no' => $request->num])->get();
        $count = Order::where(['order_no' => $request->num])->count();

        Session::put('title', 'Track Order');
        return view('front.track_order', compact('product', 'count'));
    }

    public function checkout()
    {
        // if (Session::get('user')) {
        //     $uid = Session::get('user')['id'];
        //     $user = User::where(['id' => $uid])->get();
        //     Session::put('title', 'Order Checkout');
        //     return view('front.order', compact('user'));
        // } else {
        $userCountry = 'United Arab Emirates';
        $aproducts = Product::select('products.*')->where('status', 1)->where('new_arrival', '1')->orderBy('products.id', 'DESC')->limit(3)->get();
        $countries = Countries::where('status', 1)->get();
        Session::put('title', 'Checkout');
        return view('front.checkout', compact('aproducts', 'userCountry', 'countries'));
        // }
    }
    public function payment()
    {
        $userCountry =  'United Arab Emirates';
        $aproducts = Product::select('products.*')->where('status', 1)->where('new_arrival', '1')->orderBy('products.id', 'DESC')->limit(3)->get();
        $countries = Countries::where('status', 1)->get();
        Session::put('title', 'Checkout');
        return view('front.payment', compact('aproducts', 'userCountry', 'countries'));
    }
    public function order()
    {
        if (Session::get('user')) {
            $uid = Session::get('user')['id'];
            $user = User::where(['id' => $uid])->get();
            Session::put('title', 'Order Checkout');
            return view('front.order', compact('user'));
        } else {

            Session::put('title', 'Order Checkout');
            return view('front.order');
        }
    }
    public function guest_checkout()
    {

        Session::put('title', 'Order Checkout');
        return view('front.order');
    }

    public function my_account()
    {
        $uid = Session::get('user')['id'];
        $email = Session::get('user')['email'];
        $user = Customer::where(['id' => $uid])->get();
        $order = Order::where(['email' => $email])->latest()->get();
        $countries = Countries::all();
        Session::put('title', 'My Account');
        return view('front.myaccount', compact('user', 'order', 'countries'));
    }

    // public function order(Request $slug)
    // {

    //   $id = $slug->product;

    //   $product = product::where(['id'=>$id , 'status'=>1])->get();

    //     return view('front.orderpage',compact('product'));
    // }

    public function page_detail($slug)
    {
        $Slider = Slider::all();
        $size = Size::all();
        $colors = Colors::all();
        $shap = Shap::all();
        $meta = '';
        $pages = Pages::where(['slug' => $slug])->get();
        $title = '';
        if (isset($pages[0]->name)) {
            Session::put('title', $pages[0]->name);
        }
        return view('front.dynamicpage', compact('title', 'pages', 'slug', 'Slider', 'meta', 'size', 'colors', 'shap'));
    }

    public function about(Request $request)
    {
        $products = Product::select('products.*')->orderBy('products.id', 'DESC')->get();
        $categories = Category::all();
        $Slider = Slider::all();
        $size = Size::all();
        $colors = Colors::all();
        $shap = Shap::all();
        $meta = '';
        $page = Pages::where(['slug' => 'about-us'])->first();
        $page->increment('view');
        Session::put('title', $page->name);
        return view('front.about', compact('Slider', 'page', 'meta', 'size', 'colors', 'shap', 'products', 'categories'));
    }
    public function learn(Request $request)
    {
        $setting = Learn_setting::all();
        Session::put('title', 'Learn');
        return view('front.new', compact('setting'));
    }

    public function faq(Request $request)
    {

        $faqs = Faq::where('status', 1)->get();
        $page = Pages::where(['slug' => 'faqs'])->first();
        $page->increment('view');
        Session::put('title', $page->name);
        return view('front.faq', compact('faqs', 'page'));
    }
    // public function order(Request $request)
    // {

    //         $setting=product::where(['id'=>$request->pid ])->get();
    //         Session::put('title','Checkout');
    //         return view('front.checkout',compact('setting'));
    // }

    // public function order_submit(Request $request)
    // {
    //     if (Session::get('user')) {
    //         $Order = new Order();
    //         foreach (Cart::products() as $product) {
    //             $Order->product_detail = json_encode(Session::get('cart')['items']);

    //             $Order->uid = Session::get('user')['id'];
    //             $Order->order_no = rand(10, 100000);
    //             $Order->customer_name = $request->name;
    //             $Order->email = $request->email;
    //             $Order->phone = $request->phone;
    //             $Order->country = $request->country;
    //             $Order->address = $request->address;
    //             $Order->city = $request->city;

    //             $Order->amount = Session::get('cart')['amount'] + 250;
    //             $Order->save();
    //             $lastid = $Order->id;
    //             $productt = Product::find($product->id);
    //             $productt->product_quantity = $productt->product_quantity - $product['qty'];
    //             $productt->update();
    //         }
    //         $order_data = Order::where('id', $lastid)->get();
    //         if ($lastid) {
    //             $to_name = $request->name;
    //             $to_email = $request->email;
    //             $data = [
    //                 'order' => $order_data,

    //             ];
    //             Mail::send('emails.order', $data, function ($message) use ($to_name, $to_email) {
    //                 $message->to($to_email, $to_name)
    //                     ->subject('Order Email From DealStore');
    //                 $message->from('orders@dealstore.com.pk', 'DealStore');
    //             });
    //             $to = 'orders@dealstore.com.pk';
    //             $to_n = 'Admin';
    //             Mail::send('emails.admin_order', $data, function ($message) use ($to_n, $to) {
    //                 $message->to($to, $to_n)
    //                     ->subject('Order Email From DealStore');
    //                 $message->from('orders@dealstore.com.pk', 'DealStore');
    //             });
    //         }
    //         Session::forget('cart');
    //         return redirect('/my_account')->with([
    //             'msg' => 'Order submit successfully',
    //             'msg_type' => 'success',
    //         ]);
    //     } else {
    //         $Order = new Order();
    //         foreach (Cart::products() as $product) {

    //             $Order->product_detail = json_encode(Session::get('cart')['items']);

    //             $Order->uid = rand(10, 100000);
    //             $Order->order_no = rand(10, 100000);
    //             $Order->customer_name = $request->name;
    //             $Order->email = $request->email;
    //             $Order->phone = $request->phone;
    //             $Order->country = $request->country;
    //             $Order->address = $request->address;
    //             $Order->city = $request->city;

    //             $Order->amount = Session::get('cart')['amount'] + 250;

    //             $Order->save();
    //             $lastid = $Order->id;

    //             $productt = Product::find($product->id);
    //             $productt->product_quantity = $productt->product_quantity - $product->qty;
    //             $productt->update();
    //         }
    //         $order_data = Order::where('id', $lastid)->get();
    //         if ($lastid) {
    //             $to_name = $request->name;
    //             $to_email = $request->email;
    //             $data = [
    //                 'order' => $order_data,

    //             ];
    //             Mail::send('emails.order', $data, function ($message) use ($to_name, $to_email) {
    //                 $message->to($to_email, $to_name)
    //                     ->subject('Order Email From DealStore');
    //                 $message->from('orders@dealstore.com.pk', 'DealStore');
    //             });
    //             $to = 'orders@dealstore.com.pk';
    //             $to_n = 'Admin';
    //             Mail::send('emails.admin_order', $data, function ($message) use ($to_n, $to) {
    //                 $message->to($to, $to_n)
    //                     ->subject('Order Email From DealStore');
    //                 $message->from('orders@dealstore.com.pk', 'DealStore');
    //             });
    //         }

    //         Session::forget('cart');
    //         return view('front.thanks', compact('order_data'));
    //     }
    // }

    public function draft_order_submit(Request $request)
    {
        if ($request) {
            try {
                // Validate request
                $request->validate([
                    'email' => 'required|email',
                    'phone' => 'required',
                    'country' => 'required',
                    'address' => 'required',
                    'city' => 'required',
                ]);

                Cart::mergeGuestContact($request->email, $request->phone, $request->country);

                // Process payment
                $payment_status = 'unpaid';
                $transaction_id = '';
                $payment_method = 'unknown';

                // Calculate total amount
                $totalAmount = Session::get('cart')['amount'];
                $shipping = $this->getShippingrate($totalAmount, $request->city, $request->country);
                $discount = Session::get('cart')['discount'];
                $taxPercentage = getSetting('tax_value');
                $vat = ($totalAmount * $taxPercentage / 100);
                $totalWithTax = ($totalAmount - $discount) + $shipping + $vat;
                $session_id = Session::getId();
                $existingOrder = Order::where('session_id', $session_id)->where('email', $request->email)->where('payment_method', 'unknown')->where('payment_status', 'unpaid')->first();
                if ($existingOrder) {
                    $existingOrder->product_detail = json_encode(Session::get('cart')['items']);
                    $existingOrder->amount = $totalWithTax;
                    $existingOrder->discount = Session::get('cart')['discount'] ?? 0;
                    $existingOrder->shipping_fee = $shipping;
                    $existingOrder->vat = $vat;
                    $existingOrder->save();
                    return response()->json(['success' => true, 'message' => 'Order submitted successfully']);
                }
                // Handle different payment methods
                switch ($payment_method) {
                    case 'stripe':
                    case 'google_pay': // Google Pay is processed via Stripe
                        Stripe::setApiKey(getSetting('stripe_secret_key'));
                        $charge = Charge::create([
                            'amount' => $totalWithTax * 100, // Convert to cents
                            'currency' => 'aed',
                            'source' => $request->stripeToken, // Stripe or Google Pay token
                            'description' => 'Order Payment',
                        ]);
                        $transaction_id = $charge->id;
                        $payment_status = $charge->status === 'succeeded' ? 'paid' : 'failed';
                        break;
                    case 'express_checkout':
                        $transaction_id = $request->transaction_id ?? 'EXPRESS_CHECKOUT_' . uniqid();
                        $payment_status = 'pending';
                        break;
                    case 'apple_pay':
                        $payment_status = 'paid';
                        $transaction_id = 'APPLE_PAY_' . uniqid();
                        break;

                    case 'ngenius':
                        $payment_status = 'pending';
                        break;

                    case 'cash_on_delivery':
                        $payment_status = 'pending';
                        break;
                    case 'unknown':
                        $payment_status = 'unpaid';
                        break;
                    default:
                        throw new \Exception('Invalid payment method');
                }
                // Create order
                $Order = new Order();

                $package_type = 0;
                $package_size = 0;
                $package_name = null;
                $coupon_code = null;
                $package_qty = 0;
                if (Session::get('cart')['package_type']) {
                    $package_type = Session::get('cart')['package_type'];
                }
                if (Session::get('cart')['package_size']) {
                    $package_size = Session::get('cart')['package_size'];
                }
                if (Session::get('cart')['package_name']) {
                    $package_name = Session::get('cart')['package_name'];
                }
                if (Session::get('cart')['package_name']) {
                    $package_qty = Session::get('cart')['package_qty'];
                }
                if (Session::get('cart')['coupon_code']) {
                    $coupon_code = Session::get('cart')['coupon_code'];
                }
                $totalAmount = Session::get('cart')['amount'];
                $discount = Session::get('cart')['discount'];
                $shipping = $this->getShippingrate($totalAmount, $request->city, $request->country);
                $taxPercentage = getSetting('tax_value');
                $vat = ($totalAmount * $taxPercentage / 100);
                $totalWithTax = ($totalAmount - $discount) + $shipping + ($totalAmount * $taxPercentage / 100);
                $Order->product_detail = json_encode(Session::get('cart')['items']);
                $Order->package_detail = json_encode(Session::get('cart')['package_detail']);
                $Order->uid = Session::get('user') ? Session::get('user')['id'] : rand(10, 100000);
                $Order->order_no = rand(10, 100000);
                $Order->customer_name = $request->fname . ' ' . $request->lname;
                $Order->email = $request->email;
                $Order->phone = $request->phone;
                $Order->country = $request->country;
                $Order->state = $request->state;
                $Order->unit = $request->unit;
                $Order->payment_method = $payment_method;
                $Order->postal_code = $request->postal_code;
                $Order->unit_number = $request->unit_number;
                $Order->order_note = $request->order_note;
                $Order->company_name = $request->company_name;
                $Order->coupon_code = $coupon_code;
                $Order->address = $request->address;
                $Order->city = $request->city;
                $Order->discount = Session::get('cart')['discount'] ?? 0;
                $Order->amount = $totalWithTax;
                $Order->shipping_fee = $shipping;
                $Order->vat = $vat;
                $Order->session_id = $session_id;
                $Order->dstatus = 5;
                $Order->payment_status = $payment_status;
                $Order->transaction_id = $transaction_id;
                $Order->package_id = $package_type ?? 0;
                $Order->package_size_id = $package_size ?? 0;
                $Order->package_name = $package_name ?? null;
                $Order->package_qty = $package_qty ?? 0;
                $Order->save();
                $Order->order_no = str_pad($Order->id, 6, '0', STR_PAD_LEFT);
                $Order->save();
                $lastid = $Order->id;
                $order_neew = Order::where('id', $lastid)->first();
                // $coupon = Coupon::where('code', $coupon_code)->first();
                // if ($coupon) {
                //     $coupon->no_of_discount += 1;
                //     $coupon->save();
                // }
                $order_data = Order::where('id', $lastid)->get();
                $cart = Session::get('cart');
                $cart['draft_order_no'] = $order_neew->order_no;
                Session::put('cart', $cart);


                $customer_data1 = Customer::where('email', $request->email)->first();
                if (!$customer_data1) {
                    $data = array(
                        'name' => $request->fname . ' ' . $request->lname,
                        'email' => $request->email,
                        'phone' => $request->phone,
                        'address' => $request->address,
                        'city' => $request->city,
                        'country' => $request->country,
                        'unit_type' => $request->unit,
                        'unit_number' => $request->unit_number,
                        'postal_code' => $request->postal_code,
                        'otp' => random_int(1000, 9999),
                    );
                    $customer = Customer::create($data);
                    $customer_data = Customer::where('email', $request->email)->first();
                    if ($customer) {
                        try {
                            $to_name = $request->name;
                            $to_email = $request->email;
                            $data = [
                                'user' => $customer_data,
                            ];
                            Mail::send('emails.welcome', $data, function ($message) use ($to_name, $to_email) {
                                $message->to($to_email, $to_name)
                                    ->subject('Account Opening Email');
                                $message->from(config('mail.from.address'), config('mail.from.name'));
                            });
                        } catch (\Exception $e) {
                            \Log::error('Failed to send customer creation email: ' . $e->getMessage());
                        }
                    }
                }
                return response()->json(['success' => true, 'cart' => $order_neew, 'order_no' => $order_neew->order_no, 'encrypted_order_no' => $order_neew->encrypted_order_no, 'payment_method' => $request->payment_method, 'message' => 'Order submitted successfully']);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => $e->getMessage()]);
            }
        }
        abort(404);
    }

    public function order_submit(Request $request)
    {
        if ($request) {
            try {
                // Validate request
                $request->validate([
                    'email' => 'required|email',
                    'phone' => 'required',
                    'country' => 'required',
                    'address' => 'required',
                    'city' => 'required',
                ]);

                Cart::mergeGuestContact($request->email, $request->phone, $request->country);

                // Process payment
                $payment_status = 'pending';
                $transaction_id = '';
                $payment_method = $request->payment_method;

                // Calculate total amount
                $totalAmount = Session::get('cart')['amount'];
                $shipping = $this->getShippingrate($totalAmount, $request->city, $request->country);
                $discount = Session::get('cart')['discount'];
                $taxPercentage = getSetting('tax_value');
                $vat = ($totalAmount * $taxPercentage / 100);
                $totalWithTax = ($totalAmount - $discount) + $shipping + $vat;

                $session_id = Session::getId();
                $existingOrder = Order::where('session_id', $session_id)->where('email', $request->email)->where('payment_method', 'unknown')->where('payment_status', 'unpaid')->first();

                if ($existingOrder) {
                    if ($existingOrder->payment_method ==  'unknown') {
                        $payment_method =  $request->payment_method;
                        switch ($payment_method) {
                            case 'stripe':
                                Stripe::setApiKey(getSetting('stripe_secret_key'));
                                $intent = PaymentIntent::retrieve($request->paymentIntentId);

                                $cvc_check = $intent->payment_method_details->card->checks->block_if_wrong_cvc_based_on_risk ?? null;
                                if ($cvc_check === 'fail') {
                                    $intent->cancel();
                                    return response()->json([
                                        'success' => false,
                                        'message' => 'Invalid CVC. Please check your card details.'
                                    ]);
                                }

                                $intent->capture();
                                $transaction_id = $intent->id;
                                $payment_method = "Card";
                                $payment_status = 'paid';
                                break;
                            case 'express_checkout':
                                $transaction_id = $request->transaction_id ?? 'EXPRESS_CHECKOUT_' . uniqid();
                                $payment_status = 'paid';
                                break;
                            case 'apple_pay':
                                $payment_status = 'paid';
                                $payment_method = "Apple pay";
                                $transaction_id = $request->transaction_id ?? 'APPLE_PAY_' . uniqid();
                                break;
                            case 'google_pay':
                                $payment_status = 'paid';
                                $payment_method = "Google Pay";
                                $transaction_id = $request->transaction_id ?? 'GOOGLE_PAY_' . uniqid();
                                break;

                            case 'ngenius':
                                $payment_status = 'pending';
                                break;

                            case 'cash_on_delivery':
                                $payment_method = "cash_on_delivery";
                                $payment_status = 'unpaid';
                                break;

                            default:
                                throw new \Exception('Invalid payment method ' . $payment_method);
                        }
                        $existingOrder->payment_method = $payment_method;
                        $existingOrder->transaction_id = $transaction_id;
                        $existingOrder->payment_status = $payment_status;
                        $existingOrder->dstatus = 0;
                        $existingOrder->save();
                        $coupon = Coupon::where('code', $existingOrder->coupon_code)->first();
                        if ($coupon) {
                            $coupon->no_of_discount += 1;
                            $coupon->save();
                        }
                        $order_data = Order::where('id', $existingOrder->id)->get();
                        if ($existingOrder->payment_method != "ngenius") {

                            try {
                                $to_name = $existingOrder->customer_name;
                                $to_email = $existingOrder->email;
                                $data = [
                                    'order' => $order_data,
                                ];
                                Mail::send('emails.order', $data, function ($message) use ($to_name, $to_email) {
                                    $message->to($to_email, $to_name)
                                        ->subject('Order Email');
                                    $message->from(config('mail.from.address'), config('mail.from.name'));
                                });
                            } catch (\Exception $e) {
                                \Log::error('Failed to send order email to customer: ' . $e->getMessage());
                            }


                            // Admin email
                            $notifyemails = OrderNotification::latest()->get();
                            if ($notifyemails) {
                                foreach ($notifyemails as $notifyemail) {
                                    try {
                                        $to = $notifyemail->email;
                                        $to_n = $notifyemail->name;
                                        $data = [
                                            'order' => $order_data,
                                        ];
                                        Mail::send('emails.admin_order', $data, function ($message) use ($to_n, $to) {
                                            $message->to($to, $to_n)
                                                ->subject('Order Email');
                                            $message->from(config('mail.from.address'), config('mail.from.name'));
                                        });
                                    } catch (\Exception $e) {
                                        \Log::error('Failed to send order email to admin: ' . $e->getMessage());
                                    }
                                }
                            }
                        }
                        if ($existingOrder->payment_method != 'ngenius') {
                            foreach (Cart::products() as $product) {
                                $productt = Product::find($product->id);
                                if ($productt->format == 3) {
                                    $rpro = [];
                                    if (isset($productt->bundle_product_id)) {
                                        $rpro = explode(',', $productt->bundle_product_id);
                                    }
                                    $rprod = Product::whereIn('id', $rpro)->get();
                                    foreach ($rprod as $products) {
                                        $product_bundle = Product::find($products->id);
                                        $product_bundle->product_quantity -= 1;
                                        $product_bundle->save();
                                    }
                                }
                                $productt->product_quantity -= $product['qty'];
                                $productt->save();
                            }

                            Session::forget('cart');
                            Session::forget('cart_customize');
                            Session::forget('selected_box');
                        }
                        return response()->json(['success' => true, 'cart' => $existingOrder, 'order_no' => $existingOrder->order_no, 'encrypted_order_no' => $existingOrder->encrypted_order_no, 'payment_method' => $request->payment_method, 'message' => 'Order submitted successfully']);
                    } else {
                        $existingOrder->delete();
                    }
                }

                // Handle different payment methods
                switch ($payment_method) {
                    case 'stripe':
                        Stripe::setApiKey(getSetting('stripe_secret_key'));
                        $intent = PaymentIntent::retrieve($request->paymentIntentId);

                        $cvc_check = $intent->payment_method_details->card->checks->cvc_check ?? null;
                        if ($cvc_check === 'fail') {
                            $intent->cancel();
                            return response()->json([
                                'success' => false,
                                'message' => 'Invalid CVC. Please check your card details.'
                            ]);
                        }

                        $intent->capture();
                        $transaction_id = $intent->id;
                        $payment_method = "Card";
                        $payment_status = 'paid';
                        break;
                    case 'express_checkout':
                        $transaction_id = $request->transaction_id ?? 'EXPRESS_CHECKOUT_' . uniqid();
                        $payment_method = "express_checkout";
                        $payment_status = 'paid';
                        break;
                    case 'apple_pay':
                        $payment_status = 'paid';
                        $payment_method = "Apple pay";
                        $transaction_id = $request->transaction_id ?? 'APPLE_PAY_' . uniqid();
                        break;
                    case 'google_pay':
                        $payment_status = 'paid';
                        $payment_method = "Google Pay";
                        $transaction_id = $request->transaction_id ?? 'GOOGLE_PAY_' . uniqid();
                        break;

                    case 'ngenius':
                        $payment_method = "ngenius";
                        $payment_status = 'pending';
                        break;

                    case 'cash_on_delivery':
                        $payment_method = "cash_on_delivery";
                        $payment_status = 'unpaid';
                        break;

                    default:
                        throw new \Exception('Invalid payment method ' . $payment_method);
                }

                // Create order
                $Order = new Order();

                $package_type = 0;
                $package_size = 0;
                $package_name = null;
                $coupon_code = null;
                $package_qty = 0;
                if (Session::get('cart')['package_type']) {
                    $package_type = Session::get('cart')['package_type'];
                }
                if (Session::get('cart')['package_size']) {
                    $package_size = Session::get('cart')['package_size'];
                }
                if (Session::get('cart')['package_name']) {
                    $package_name = Session::get('cart')['package_name'];
                }
                if (Session::get('cart')['package_name']) {
                    $package_qty = Session::get('cart')['package_qty'];
                }
                if (Session::get('cart')['coupon_code']) {
                    $coupon_code = Session::get('cart')['coupon_code'];
                }
                $totalAmount = Session::get('cart')['amount'];
                $discount = Session::get('cart')['discount'];
                $shipping = $this->getShippingrate($totalAmount, $request->city, $request->country);
                $taxPercentage = getSetting('tax_value');
                $vat = ($totalAmount * $taxPercentage / 100);
                $totalWithTax = ($totalAmount - $discount) + $shipping + ($totalAmount * $taxPercentage / 100);
                $Order->product_detail = json_encode(Session::get('cart')['items']);
                $Order->package_detail = json_encode(Session::get('cart')['package_detail']);
                $Order->uid = Session::get('user') ? Session::get('user')['id'] : rand(10, 100000);
                $Order->order_no = rand(10, 100000);
                $Order->customer_name = $request->fname . ' ' . $request->lname;
                $Order->email = $request->email;
                $Order->phone = $request->phone;
                $Order->country = $request->country;
                $Order->state = $request->state;
                $Order->unit = $request->unit;
                $Order->payment_method = $payment_method;
                $Order->postal_code = $request->postal_code;
                $Order->unit_number = $request->unit_number;
                $Order->order_note = $request->order_note;
                $Order->company_name = $request->company_name;
                $Order->coupon_code = $coupon_code;
                $Order->address = $request->address;
                $Order->city = $request->city;
                $Order->discount = Session::get('cart')['discount'] ?? 0;
                $Order->amount = $totalWithTax;
                $Order->shipping_fee = $shipping;
                $Order->vat = $vat;
                $Order->session_id = $session_id;
                $Order->payment_status = $payment_status;
                $Order->transaction_id = $transaction_id;
                $Order->package_id = $package_type ?? 0;
                $Order->package_size_id = $package_size ?? 0;
                $Order->package_name = $package_name ?? null;
                $Order->package_qty = $package_qty ?? 0;
                $Order->save();
                $Order->order_no = str_pad($Order->id, 6, '0', STR_PAD_LEFT);
                $Order->save();
                $lastid = $Order->id;
                $order_neew = Order::where('id', $lastid)->first();
                $coupon = Coupon::where('code', $coupon_code)->first();
                if ($coupon) {
                    $coupon->no_of_discount += 1;
                    $coupon->save();
                }
                $order_data = Order::where('id', $lastid)->get();
                if ($lastid) {

                    if ($order_neew->payment_method != "ngenius") {

                        try {
                            $to_name = $order_neew->customer_name;
                            $to_email = $order_neew->email;
                            $data = [
                                'order' => $order_data,
                            ];
                            Mail::send('emails.order', $data, function ($message) use ($to_name, $to_email) {
                                $message->to($to_email, $to_name)
                                    ->subject('Order Email');
                                $message->from(config('mail.from.address'), config('mail.from.name'));
                            });
                        } catch (\Exception $e) {
                            \Log::error('Failed to send order email to customer: ' . $e->getMessage());
                        }


                        // Admin email
                        $notifyemails = OrderNotification::latest()->get();
                        if ($notifyemails) {
                            foreach ($notifyemails as $notifyemail) {
                                try {
                                    $to = $notifyemail->email;
                                    $to_n = $notifyemail->name;
                                    $data = [
                                        'order' => $order_data,
                                    ];
                                    Mail::send('emails.admin_order', $data, function ($message) use ($to_n, $to) {
                                        $message->to($to, $to_n)
                                            ->subject('Order Email');
                                        $message->from(config('mail.from.address'), config('mail.from.name'));
                                    });
                                } catch (\Exception $e) {
                                    \Log::error('Failed to send order email to admin: ' . $e->getMessage());
                                }
                            }
                        }
                        // $message = "🛒 New Order Received!\nOrder ID: {$order_neew->order_no}\nCustomer: {$order_neew->customer_name}\nTotal: {$order_neew->amount} " . getSetting('currency') . "}";

                        // Send WhatsApp Message
                        // $whatsapp = new WhatsAppService();
                        // $response = $whatsapp->sendMessage(env('ADMIN_WHATSAPP_NUMBER'), $message);
                    }
                }

                $customer_data1 = Customer::where('email', $request->email)->first();
                if (!$customer_data1) {
                    $data = array(
                        'name' => $request->fname . ' ' . $request->lname,
                        'email' => $request->email,
                        'phone' => $request->phone,
                        'address' => $request->address,
                        'city' => $request->city,
                        'country' => $request->country,
                        'unit_type' => $request->unit,
                        'unit_number' => $request->unit_number,
                        'postal_code' => $request->postal_code,
                        'otp' => random_int(1000, 9999),
                    );
                    $customer = Customer::create($data);
                    $customer_data = Customer::where('email', $request->email)->first();
                    if ($customer) {
                        try {
                            $to_name = $request->name;
                            $to_email = $request->email;
                            $data = [
                                'user' => $customer_data,
                            ];
                            Mail::send('emails.welcome', $data, function ($message) use ($to_name, $to_email) {
                                $message->to($to_email, $to_name)
                                    ->subject('Account Opening Email');
                                $message->from(config('mail.from.address'), config('mail.from.name'));
                            });
                        } catch (\Exception $e) {
                            \Log::error('Failed to send customer creation email: ' . $e->getMessage());
                        }
                    }
                }
                if ($request->payment_method != 'ngenius') {
                    foreach (Cart::products() as $product) {
                        $productt = Product::find($product->id);
                        if ($productt->format == 3) {
                            $rpro = [];
                            if (isset($productt->bundle_product_id)) {
                                $rpro = explode(',', $productt->bundle_product_id);
                            }
                            $rprod = Product::whereIn('id', $rpro)->get();
                            foreach ($rprod as $products) {
                                $product_bundle = Product::find($products->id);
                                $product_bundle->product_quantity -= 1;
                                $product_bundle->save();
                            }
                        }
                        $productt->product_quantity -= $product['qty'];
                        $productt->save();
                    }

                    Session::forget('cart');
                    Session::forget('cart_customize');
                    Session::forget('selected_box');
                }
                return response()->json(['success' => true, 'cart' => $order_neew, 'order_no' => $order_neew->order_no, 'encrypted_order_no' => $order_neew->encrypted_order_no, 'payment_method' => $request->payment_method, 'message' => 'Order submitted successfully']);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => $e->getMessage()]);
            }
        }
        abort(404);
    }

    public function create_payment_intent(Request $request)
    {
        Stripe::setApiKey(getSetting('stripe_secret_key'));

        try {
            // Convert amount to cents
            $totalAmount = Session::get('cart')['amount'];
            $shipping = $this->getShippingrate($totalAmount, $request->city, $request->country);
            $discount = Session::get('cart')['discount'];
            $taxPercentage = getSetting('tax_value');
            $vat = ($totalAmount * $taxPercentage / 100);
            $amount = ($totalAmount - $discount) + $shipping + $vat;
            $amount = intval($amount);

            $intentData = [
                'amount' => $amount * 100, // Amount should be in cents
                'currency' => 'aed',
                'automatic_payment_methods' => ['enabled' => true], // Apple Pay & Google Pay are included
            ];

            if ($request->payment_method === 'stripe') {
                $intentData['capture_method'] = 'manual';
            }

            $intent = PaymentIntent::create($intentData);

            return response()->json(['clientSecret' => $intent->client_secret]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getShippingrate($amount = null, $city_id = null, $country_id = null)
    {
        $amount = $amount;
        $city_name = $city_id;
        $country_name = $country_id;

        // Check if city exists and has valid shipping rules
        $city = City::where('name', $city_name)->first();
        if ($city && $city->min_order > 0 && $city->shipping_cost > 0 && $city->free_shipping > 0) {
            $minOrder = (int)$city->min_order;
            $shippingCost = (int)$city->shipping_cost;
            $freeShippingThreshold = (int)$city->free_shipping;
        } else {
            // Fallback to country if city shipping rules are not available
            $country = Countries::where('name', $country_name)->first();
            if ($country) {
                $minOrder = (int)$country->min_order;
                $shippingCost = (int)$country->shipping_cost;
                $freeShippingThreshold = (int)$country->free_shipping;
            } else {
                // Default values if neither city nor country have shipping rules
                $minOrder = 0;
                $shippingCost = 0;
                $freeShippingThreshold = 0;
            }
        }
        return $finalShippingCost = ($amount >= $freeShippingThreshold) ? 0 : $shippingCost;
    }


    public function thanks(Request $request)
    {
        try {
            $order_no = Crypt::decryptString($request->order_no);
        } catch (\Exception $e) {
            // Fallback for non-encrypted or invalid order numbers (if still needed for legacy support, remove catch if not)
            $order_no = $request->order_no;
        }

        $order = Order::where('order_no', $order_no)->first();
        if (!$order) {
            abort(404);
        }

        Session::put('title', 'Thankyou');
        return view('front.thanks', compact('order'));
    }

    public function order_detail(Request $request)
    {
        try {
            $order_no = Crypt::decryptString($request->order_no);
        } catch (\Exception $e) {
            $order_no = $request->order_no;
        }

        $order = Order::where('order_no', $order_no)->first();

        if (!$order) {
            abort(404);
        }

        // Security check: Only allow the owner to see the order details
        $user = Session::get('user');
        if (!$user || $user->email !== $order->email) {
            // Optional: If it was just placed in this session (guest), we might want to allow it?
            // But usually, order_detail is for my_account view.
            return redirect('/login')->with(['msg' => 'Please login to view order details', 'msg_type' => 'danger']);
        }

        Session::put('title', 'Order Detail');
        return view('front.order_detail', compact('order'));
    }

    public function reorder(Request $request)
    {
        try {
            $order_no = Crypt::decryptString($request->order_no);
        } catch (\Exception $e) {
            $order_no = $request->order_no;
        }

        $order = Order::where('order_no', $order_no)->first();

        if (!$order) {
            abort(404);
        }

        // Security check: Only allow the owner to reorder
        $user = Session::get('user');
        if (!$user || $user->email !== $order->email) {
            return redirect('/login')->with(['msg' => 'Please login to reorder items', 'msg_type' => 'danger']);
        }

        $products = json_decode($order->product_detail, true) ?? [];
        foreach ($products as $item) {
            if (isset($item['id']) && $item['id'] != null) {
                \App\Helpers\Cart::add($item['id'], $item['qty']);
            }
        }

        $packages = json_decode($order->package_detail, true) ?? [];
        foreach ($packages as $pkg) {
            if (isset($pkg['package_type']) && $pkg['package_type'] != null) {
                \App\Helpers\Cart::add(null, $pkg['qty'], $pkg['package_type'], $pkg['package_size']);
            }
        }

        return redirect('/cart')->with(['msg' => 'All items from order ' . $order->order_no . ' have been added to your cart.', 'msg_type' => 'success']);
    }

    public function instant_order(Request $request)
    {
        $Order = new Order();
        $array = array(
            'id' => $request->id,
            'qty' => $request->qty,
        );
        $pro[] = $array;
        $Order->product_detail = json_encode($pro);
        $Order->uid = rand(10, 100000);
        $Order->order_no = rand(10, 100000);
        $Order->customer_name = $request->name;
        $Order->email = $request->email;
        $Order->phone = $request->phone;
        $Order->country = $request->country;
        $Order->address = $request->address;
        $Order->city = $request->city;

        $Order->amount = Session::get('cart')['amount'] + 250;
        $Order->save();
        $lastid = $Order->id;
        $order_data = Order::where('id', $lastid)->get();
        if ($lastid) {
            $to_name = $request->name;
            $to_email = $request->email;
            $data = [
                'order' => $order_data,

            ];
            Mail::send('emails.order', $data, function ($message) use ($to_name, $to_email) {
                $message->to($to_email, $to_name)
                    ->subject('Order Email’');
                $message->from('orders@dealstore.com.pk', 'DealStore');
            });
            $to = 'orders@dealstore.com.pk';
            $to_n = 'Admin';
            Mail::send('emails.admin_order', $data, function ($message) use ($to_n, $to) {
                $message->to($to, $to_n)
                    ->subject('Order Email’');
                $message->from('orders@dealstore.com.pk', 'DealStore');
            });
        }
        $productt = Product::find($request->id);
        $productt->product_quantity = $productt->product_quantity - $request->qty;
        $productt->update();

        return redirect('/product/' . $productt->slug)->with([
            'msg' => 'Order submit successfully',
            'msg_type' => 'success',
        ]);
    }

    public function rating_submit(Request $request)
    {

        // Handle file upload if present
        $filePath = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $uniqueName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/images/reviews/'), $uniqueName);
            $filePath = 'images/reviews/' . $uniqueName;
        }

        // Create a new rating entry
        $rating = new Rating();
        $rating->pid = $request->pid;
        $rating->rate = $request->rating;
        $rating->name = $request->name;
        $rating->email = $request->email;
        $rating->review = $request->review;
        $rating->status = 1;
        $rating->file = $filePath; // Save the file path if uploaded
        $rating->title = $request->title;
        $rating->choice = $request->choice;
        $rating->save();

        // Fetch the product for redirection
        $product = product::where(['id' => $request->pid, 'status' => 1])->first();
        if (!$product) {
            return redirect('/')->with([
                'msg' => 'Product not found or inactive',
                'msg_type' => 'error',
            ]);
        }

        return redirect('/product/' . $product->slug)->with([
            'msg' => 'Review submitted successfully',
            'msg_type' => 'success',
        ]);
    }

    public function faq_submit(Request $request)
    {
        // dd($request);
        $rating = new Faq();

        $rating->pid = $request->pid;
        $rating->question = $request->question;
        $rating->name = $request->name;
        $rating->save();
        if ($rating->save()) {
            $product = product::where(['id' => $request->pid, 'status' => 1])->get();
            $pro = $product[0];

            return redirect('/product/' . $product[0]->slug)->with([
                'msg' => 'Question submit successfully',
                'msg_type' => 'success',
            ]);
        } else {
            $product = product::where(['id' => $request->pid, 'status' => 1])->get();
            $pro = $product[0];

            return redirect('/product/' . $product[0]->slug)->with([
                'msg' => 'Please try Again!',
                'msg_type' => 'success',
            ]);
        }
    }

    public function trackorder(Request $request)
    {

        $product = Order::where(['order_no' => $request->num])->get();
        $count = Order::where(['order_no' => $request->num])->count();
        Session::put('title', 'Track Order');
        return view('front.track_order', compact('product', 'count'));
    }

    public function get_selected_shap(Request $request)
    {
        $data = $request->data;
        $old = $request->session()->get('selected_shap');
        if (!$old) {
            $old = array();
        }
        if ($request->action == "add") {

            // $request->session()->forget('selected_shap');
            if (isset($old)) {
                if (count($old) != 0) {
                    if (in_array($data, $old)) {
                    } else {
                        array_push($old, $data);
                        $request->session()->put('selected_shap', $old);
                    }
                } else {
                    $array = array();
                    array_push($array, $data);
                    $request->session()->put('selected_shap', $array);
                }
            } else {
                $array = array();
                array_push($array, $data);
                $request->session()->put('selected_shap', $array);
                // print_r($old);
            }
        } else {

            foreach (array_keys($old, $data, true) as $key) {
                unset($old[$key]);
            }

            $request->session()->forget('selected_shap');
            $request->session()->put('selected_shap', $old);
        }
        $old = array(1);

        $selected_shap = $request->session()->get('selected_shap');
        $selected_color = $request->session()->get('selected_color');
        $selected_size = $request->session()->get('selected_size');

        $newto = $request->session()->get('to');
        $datafrom = $request->session()->get('from');

        $Products = Product::orderBy('id', 'DESC');
        if ($selected_color == '') {
            $selected_color = array();
        }
        if ($selected_shap == '') {
            $selected_shap = array();
        }
        if ($selected_size == '') {
            $selected_size = array();
        }

        if (count($selected_shap) > 0 && count($selected_color) > 0 && count($selected_size) > 0) {
            if ($newto != '' && $datafrom != '') {
                $Products = DB::select("SELECT * FROM `products` WHERE product_color IN (" . implode(",", $selected_color) . ") AND product_shap IN (" . implode(",", $selected_shap) . ") AND product_size IN (" . implode(",", $selected_size) . ") AND discount_price BETWEEN " . $newto . " AND " . $datafrom . " ORDER BY id DESC ");
            } else {
                $Products = DB::select("SELECT * FROM `products` WHERE product_color IN (" . implode(",", $selected_color) . ") AND product_shap IN (" . implode(",", $selected_shap) . ") AND product_size IN (" . implode(",", $selected_size) . ") ORDER BY id DESC ");
            }
            // return "SELECT * FROM `products` WHERE product_color IN (".implode(",",$selected_color).") AND product_shap IN (".implode(",",$selected_shap).") AND product_size IN (".implode(",",$selected_size).") ORDER BY id DESC ";

        } elseif (count($selected_shap) == 0 && count($selected_color) == 0 && count($selected_size) == 0) {
            if ($newto != '' && $datafrom != '') {
                $Products = DB::select("SELECT * FROM `products` WHERE discount_price BETWEEN " . $newto . " AND " . $datafrom . " ORDER BY id DESC ");
            } else {
                $Products = DB::select("SELECT * FROM `products` ORDER BY id DESC ");
            }
        } else {

            if (count($selected_shap) == 0) {

                if (count($selected_color) == 0 && count($selected_size) > 0) {
                    if ($newto != '' && $datafrom != '') {
                        $Products = DB::select("SELECT * FROM `products` WHERE product_size IN (" . implode(",", $selected_size) . ") AND discount_price BETWEEN " . $newto . " AND " . $datafrom . " ORDER BY id DESC ");
                    } else {
                        $Products = DB::select("SELECT * FROM `products` WHERE product_size IN (" . implode(",", $selected_size) . ") ORDER BY id DESC ");
                    }
                } elseif (count($selected_color) > 0 && count($selected_size) == 0) {
                    if ($newto != '' && $datafrom != '') {
                        $Products = DB::select("SELECT * FROM `products` WHERE product_color IN (" . implode(",", $selected_color) . ") AND discount_price BETWEEN " . $newto . " AND " . $datafrom . " ORDER BY id DESC ");
                    } else {
                        $Products = DB::select("SELECT * FROM `products` WHERE product_color IN (" . implode(",", $selected_color) . ") ORDER BY id DESC ");
                    }
                } else {
                    if ($newto != '' && $datafrom != '') {
                        $Products = DB::select("SELECT * FROM `products` WHERE product_color IN (" . implode(",", $selected_color) . ") and product_size IN (" . implode(",", $selected_size) . ") AND discount_price BETWEEN " . $newto . " AND " . $datafrom . " ORDER BY id DESC ");
                    } else {
                        $Products = DB::select("SELECT * FROM `products` WHERE product_color IN (" . implode(",", $selected_color) . ") and product_size IN (" . implode(",", $selected_size) . ") ORDER BY id DESC ");
                    }
                }
            } elseif (count($selected_color) == 0) {

                if (count($selected_shap) > 0 && count($selected_size) > 0) {
                    if ($newto != '' && $datafrom != '') {
                        $Products = DB::select("SELECT * FROM `products` WHERE product_size IN (" . implode(",", $selected_size) . ") and product_shap IN (" . implode(",", $selected_shap) . ") AND discount_price BETWEEN " . $newto . " AND " . $datafrom . " ORDER BY id DESC ");
                    } else {
                        $Products = DB::select("SELECT * FROM `products` WHERE product_size IN (" . implode(",", $selected_size) . ") and product_shap IN (" . implode(",", $selected_shap) . ") ORDER BY id DESC ");
                    }
                } elseif (count($selected_size) == 0 && count($selected_shap) > 0) {
                    if ($newto != '' && $datafrom != '') {
                        $Products = DB::select("SELECT * FROM `products` WHERE product_shap IN (" . implode(",", $selected_shap) . ") AND discount_price BETWEEN " . $newto . " AND " . $datafrom . " ORDER BY id DESC ");
                    } else {
                        $Products = DB::select("SELECT * FROM `products` WHERE product_shap IN (" . implode(",", $selected_shap) . ") ORDER BY id DESC ");
                    }
                } elseif (count($selected_shap) == 0 && count($selected_size) > 1) {
                    if ($newto != '' && $datafrom != '') {
                        $Products = DB::select("SELECT * FROM `products` WHERE product_size IN (" . implode(",", $selected_size) . ") AND discount_price BETWEEN " . $newto . " AND " . $datafrom . " ORDER BY id DESC ");
                    } else {
                        $Products = DB::select("SELECT * FROM `products` WHERE product_size IN (" . implode(",", $selected_size) . ") ORDER BY id DESC ");
                    }
                }
            } elseif (count($selected_size) == 0) {

                if (count($selected_shap) > 0 && count($selected_color) > 0) {
                    if ($newto != '' && $datafrom != '') {
                        $Products = DB::select("SELECT * FROM `products` WHERE product_color IN (" . implode(",", $selected_color) . ") and product_shap IN (" . implode(",", $selected_shap) . ") AND discount_price BETWEEN " . $newto . " AND " . $datafrom . " ORDER BY id DESC ");
                    } else {
                        $Products = DB::select("SELECT * FROM `products` WHERE product_color IN (" . implode(",", $selected_color) . ") and product_shap IN (" . implode(",", $selected_shap) . ") ORDER BY id DESC ");
                    }
                } elseif (count($selected_color) == 0 && count($selected_shap) > 0) {
                    if ($newto != '' && $datafrom != '') {
                        $Products = DB::select("SELECT * FROM `products` WHERE product_shap IN (" . implode(",", $selected_shap) . ") AND discount_price BETWEEN " . $newto . " AND " . $datafrom . " ORDER BY id DESC ");
                    } else {
                        $Products = DB::select("SELECT * FROM `products` WHERE product_shap IN (" . implode(",", $selected_shap) . ") ORDER BY id DESC ");
                    }
                } elseif (count($selected_shap) == 0 && count($selected_color) > 1) {
                    if ($newto != '' && $datafrom != '') {
                        $Products = DB::select("SELECT * FROM `products` WHERE product_color IN (" . implode(",", $selected_color) . ") AND discount_price BETWEEN " . $newto . " AND " . $datafrom . " ORDER BY id DESC ");
                    } else {
                        $Products = DB::select("SELECT * FROM `products` WHERE product_color IN (" . implode(",", $selected_color) . ") ORDER BY id DESC ");
                    }
                }
            }
        }

        $html = '';
        foreach ($Products as $key => $product) {
            // dd($product->id);
            $Galleries = Gallerie::where(['product_id' => $product->id])->get();

            $Catagories = Category::where(['id' => $product->category_id])->get();

            if (count($Catagories) > 0) {
                $cateslug = $Catagories[0]->slug;
                $catename = $Catagories[0]->name;
            } else {
                $cateslug = '';
                $catename = '';
            }
            if (count($Galleries) > 0) {
                $gallary = $Galleries[0]->photo;
            } else {
                $gallary = '';
            }
            $html .= '<div class="c-product-grid_item"><div class="c-product-grid_thumb-wrap"><a href="product/' . $product->slug . '" class="lrv-loop-product_link"><img src="' . $product->image_one . '" class="c-product-grid_thumb"><img src="' . $gallary . '" class="c-product-grid_thumb product_grid_thumb_hover"></a><div class="c-product-grid_badges"></div><div class="c-product-grid_thumb-button-list"><button class="h-cb c-product-grid_thumb-button"><i class="ip-eye c-product-grid_icon"></i> <span class="c-product-grid_icon-text">Quick view</span></button> <button data-size="" class="js-wishlist-btn"><i class="ip-heart c-product-grid_icon"></i></button></div></div><a href="product/' . $product->slug . '" class="c-product-grid_atc"><span class="c-product-grid_atc-text">View Product</span></a><div class="c-product-grid_details"><div class="c-product-grid_title-wrap"><div class="c-product-grid_category-list"><a class="c-product-grid_category-item" href="/category/' . $cateslug . '">' . $catename . '</a></div><a href="product/' . $product->slug . '" class="product_link_link"><h2 class="lrv-loop-product_title">' . $product->product_name . '</h2></a></div><div class="c-product-grid_price-wrap"><span class="price"><span class="lrv-Price-amount amount"><bdi><span class="lrv-Price-currencySymbol">$</span>' . $product->discount_price . '</bdi></span></span></div></div></div>';
        }

        if ($html == '') {
            $html = '<span style="width: 100%;text-align: center;margin: 185px;">No Record Found!</span>';
        } else {
            $html = $html;
        }

        return $html;
    }

    public function get_selected_color(Request $request)
    {
        // dd($request->session()->get('selected_color'));
        $data = $request->data;
        $old = $request->session()->get('selected_color');
        if (!$old) {
            $old = array();
        }
        // dd($data);
        if ($request->action == "add") {

            // $request->session()->forget('selected_color');
            if (isset($old)) {
                if (count($old) != 0) {
                    if (in_array($data, $old)) {
                    } else {
                        array_push($old, $data);
                        $request->session()->put('selected_color', $old);
                    }
                } else {
                    $array = array();
                    array_push($array, $data);
                    $request->session()->put('selected_color', $array);
                }
            } else {
                $array = array();
                array_push($array, $data);
                $request->session()->put('selected_color', $array);
                // print_r($old);
            }
        } else {

            foreach (array_keys($old, $data, true) as $key) {
                unset($old[$key]);
            }

            $request->session()->forget('selected_color');
            $request->session()->put('selected_color', $old);
        }

        $old = array(1);

        $selected_shap = $request->session()->get('selected_shap');
        $selected_color = $request->session()->get('selected_color');
        $selected_size = $request->session()->get('selected_size');

        $newto = $request->session()->get('to');
        $datafrom = $request->session()->get('from');

        $Products = Product::orderBy('id', 'DESC');
        // // return $selected_color;
        if ($selected_color == '') {
            $selected_color = array();
        }
        if ($selected_shap == '') {
            $selected_shap = array();
        }
        if ($selected_size == '') {
            $selected_size = array();
        }

        if (count($selected_shap) > 0 && count($selected_color) > 0 && count($selected_size) > 0) {
            if ($newto != '' && $datafrom != '') {
                $Products = DB::select("SELECT * FROM `products` WHERE product_color IN (" . implode(",", $selected_color) . ") AND product_shap IN (" . implode(",", $selected_shap) . ") AND product_size IN (" . implode(",", $selected_size) . ") AND discount_price BETWEEN " . $newto . " AND " . $datafrom . " ORDER BY id DESC ");
            } else {
                $Products = DB::select("SELECT * FROM `products` WHERE product_color IN (" . implode(",", $selected_color) . ") AND product_shap IN (" . implode(",", $selected_shap) . ") AND product_size IN (" . implode(",", $selected_size) . ") ORDER BY id DESC ");
            }
        } elseif (count($selected_shap) == 0 && count($selected_color) == 0 && count($selected_size) == 0) {
            if ($newto != '' && $datafrom != '') {
                $Products = DB::select("SELECT * FROM `products` WHERE discount_price BETWEEN " . $newto . " AND " . $datafrom . " ORDER BY id DESC ");
            } else {
                $Products = DB::select("SELECT * FROM `products` ORDER BY id DESC ");
            }
        } else {

            if (count($selected_shap) == 0) {

                if (count($selected_color) == 0 && count($selected_size) > 0) {
                    if ($newto != '' && $datafrom != '') {
                        $Products = DB::select("SELECT * FROM `products` WHERE product_size IN (" . implode(",", $selected_size) . ") AND discount_price BETWEEN " . $newto . " AND " . $datafrom . " ORDER BY id DESC ");
                    } else {
                        $Products = DB::select("SELECT * FROM `products` WHERE product_size IN (" . implode(",", $selected_size) . ") ORDER BY id DESC ");
                    }
                } elseif (count($selected_color) > 0 && count($selected_size) == 0) {
                    // return "SELECT * FROM `products` WHERE product_color IN (".implode(",",$selected_color).") ORDER BY id DESC ";
                    if ($newto != '' && $datafrom != '') {
                        $Products = DB::select("SELECT * FROM `products` WHERE product_color IN (" . implode(",", $selected_color) . ") AND discount_price BETWEEN " . $newto . " AND " . $datafrom . " ORDER BY id DESC ");
                    } else {
                        $Products = DB::select("SELECT * FROM `products` WHERE product_color IN (" . implode(",", $selected_color) . ") ORDER BY id DESC ");
                    }
                } else {
                    if ($newto != '' && $datafrom != '') {
                        $Products = DB::select("SELECT * FROM `products` WHERE product_color IN (" . implode(",", $selected_color) . ") and product_size IN (" . implode(",", $selected_size) . ") AND discount_price BETWEEN " . $newto . " AND " . $datafrom . " ORDER BY id DESC ");
                    } else {
                        $Products = DB::select("SELECT * FROM `products` WHERE product_color IN (" . implode(",", $selected_color) . ") and product_size IN (" . implode(",", $selected_size) . ") ORDER BY id DESC ");
                    }
                }
            } elseif (count($selected_color) == 0) {

                if (count($selected_shap) > 0 && count($selected_size) > 0) {
                    if ($newto != '' && $datafrom != '') {
                        $Products = DB::select("SELECT * FROM `products` WHERE product_size IN (" . implode(",", $selected_size) . ") and product_shap IN (" . implode(",", $selected_shap) . ") AND discount_price BETWEEN " . $newto . " AND " . $datafrom . " ORDER BY id DESC ");
                    } else {
                        $Products = DB::select("SELECT * FROM `products` WHERE product_size IN (" . implode(",", $selected_size) . ") and product_shap IN (" . implode(",", $selected_shap) . ") ORDER BY id DESC ");
                    }
                } elseif (count($selected_size) == 0 && count($selected_shap) > 0) {
                    if ($newto != '' && $datafrom != '') {
                        $Products = DB::select("SELECT * FROM `products` WHERE product_shap IN (" . implode(",", $selected_shap) . ")  AND discount_price BETWEEN " . $newto . " AND " . $datafrom . " ORDER BY id DESC ");
                    } else {
                        $Products = DB::select("SELECT * FROM `products` WHERE product_shap IN (" . implode(",", $selected_shap) . ") ORDER BY id DESC ");
                    }
                } elseif (count($selected_shap) == 0 && count($selected_size) > 1) {
                    if ($newto != '' && $datafrom != '') {
                        $Products = DB::select("SELECT * FROM `products` WHERE product_size IN (" . implode(",", $selected_size) . ") AND discount_price BETWEEN " . $newto . " AND " . $datafrom . " ORDER BY id DESC ");
                    } else {
                        $Products = DB::select("SELECT * FROM `products` WHERE product_size IN (" . implode(",", $selected_size) . ") ORDER BY id DESC ");
                    }
                }
            } elseif (count($selected_size) == 0) {

                if (count($selected_shap) > 0 && count($selected_color) > 0) {
                    if ($newto != '' && $datafrom != '') {
                        $Products = DB::select("SELECT * FROM `products` WHERE product_color IN (" . implode(",", $selected_color) . ") and product_shap IN (" . implode(",", $selected_shap) . ") AND discount_price BETWEEN " . $newto . " AND " . $datafrom . "  ORDER BY id DESC ");
                    } else {
                        $Products = DB::select("SELECT * FROM `products` WHERE product_color IN (" . implode(",", $selected_color) . ") and product_shap IN (" . implode(",", $selected_shap) . ") ORDER BY id DESC ");
                    }
                } elseif (count($selected_color) == 0 && count($selected_shap) > 0) {
                    if ($newto != '' && $datafrom != '') {
                        $Products = DB::select("SELECT * FROM `products` WHERE product_shap IN (" . implode(",", $selected_shap) . ") AND discount_price BETWEEN " . $newto . " AND " . $datafrom . " ORDER BY id DESC ");
                    } else {
                        $Products = DB::select("SELECT * FROM `products` WHERE product_shap IN (" . implode(",", $selected_shap) . ") ORDER BY id DESC ");
                    }
                } elseif (count($selected_shap) == 0 && count($selected_color) > 1) {
                    if ($newto != '' && $datafrom != '') {
                        $Products = DB::select("SELECT * FROM `products` WHERE product_color IN (" . implode(",", $selected_color) . ") AND discount_price BETWEEN " . $newto . " AND " . $datafrom . " ORDER BY id DESC ");
                    } else {
                        $Products = DB::select("SELECT * FROM `products` WHERE product_color IN (" . implode(",", $selected_color) . ") ORDER BY id DESC ");
                    }
                }
            }
        }

        $html = '';
        foreach ($Products as $key => $product) {
            // dd($product->id);
            $Galleries = Gallerie::where(['product_id' => $product->id])->get();

            $Catagories = Category::where(['id' => $product->category_id])->get();

            if (count($Catagories) > 0) {
                $cateslug = $Catagories[0]->slug;
                $catename = $Catagories[0]->name;
            } else {
                $cateslug = '';
                $catename = '';
            }
            if (count($Galleries) > 0) {
                $gallary = $Galleries[0]->photo;
            } else {
                $gallary = '';
            }
            $html .= '<div class="c-product-grid_item"><div class="c-product-grid_thumb-wrap"><a href="product/' . $product->slug . '" class="lrv-loop-product_link"><img src="' . $product->image_one . '" class="c-product-grid_thumb"><img src="' . $gallary . '" class="c-product-grid_thumb product_grid_thumb_hover"></a><div class="c-product-grid_badges"></div><div class="c-product-grid_thumb-button-list"><button class="h-cb c-product-grid_thumb-button"><i class="ip-eye c-product-grid_icon"></i> <span class="c-product-grid_icon-text">Quick view</span></button> <button data-size="" class="js-wishlist-btn"><i class="ip-heart c-product-grid_icon"></i></button></div></div><a href="product/' . $product->slug . '" class="c-product-grid_atc"><span class="c-product-grid_atc-text">View Product</span></a><div class="c-product-grid_details"><div class="c-product-grid_title-wrap"><div class="c-product-grid_category-list"><a class="c-product-grid_category-item" href="/category/' . $cateslug . '">' . $catename . '</a></div><a href="product/' . $product->slug . '" class="product_link_link"><h2 class="lrv-loop-product_title">' . $product->product_name . '</h2></a></div><div class="c-product-grid_price-wrap"><span class="price"><span class="lrv-Price-amount amount"><bdi><span class="lrv-Price-currencySymbol">$</span>' . $product->discount_price . '</bdi></span></span></div></div></div>';
        }
        // return $html;
        if ($html == '') {
            $html = '<span style="width: 100%;text-align: center;margin: 185px;">No Record Found!</span>';
        } else {
            $html = $html;
        }

        return $html;
    }

    public function get_selected_size(Request $request)
    {
        $data = $request->data;
        $old = $request->session()->get('selected_size');
        if (!$old) {
            $old = array();
        }
        // dd($request->session()->get('selected_size'));
        if ($request->action == "add") {

            // $request->session()->forget('selected_size');
            if (isset($old)) {
                if (count($old) != 0) {
                    if (in_array($data, $old)) {
                    } else {
                        array_push($old, $data);
                        $request->session()->put('selected_size', $old);
                    }
                } else {
                    $array = array();
                    array_push($array, $data);
                    $request->session()->put('selected_size', $array);
                }
            } else {
                $array = array();
                array_push($array, $data);
                $request->session()->put('selected_size', $array);
                // print_r($old);
            }
        } else {

            foreach (array_keys($old, $data, true) as $key) {
                unset($old[$key]);
            }

            $request->session()->forget('selected_size');
            $request->session()->put('selected_size', $old);
        }
        // dd($old);

        $selected_shap = $request->session()->get('selected_shap');
        $selected_color = $request->session()->get('selected_color');
        $selected_size = $request->session()->get('selected_size');

        $newto = $request->session()->get('to');
        $datafrom = $request->session()->get('from');

        $Products = Product::orderBy('id', 'DESC');
        // // return $selected_color;
        if ($selected_color == '') {
            $selected_color = array();
        }
        if ($selected_shap == '') {
            $selected_shap = array();
        }
        if ($selected_size == '') {
            $selected_size = array();
        }

        if (count($selected_shap) > 0 && count($selected_color) > 0 && count($selected_size) > 0) {
            if ($newto != '' && $datafrom != '') {
                $Products = DB::select("SELECT * FROM `products` WHERE product_color IN (" . implode(",", $selected_color) . ") AND product_shap IN (" . implode(",", $selected_shap) . ") AND product_size IN (" . implode(",", $selected_size) . ") AND discount_price BETWEEN " . $newto . " AND " . $datafrom . "  ORDER BY id DESC ");
            } else {
                $Products = DB::select("SELECT * FROM `products` WHERE product_color IN (" . implode(",", $selected_color) . ") AND product_shap IN (" . implode(",", $selected_shap) . ") AND product_size IN (" . implode(",", $selected_size) . ") ORDER BY id DESC ");
            }
        } elseif (count($selected_shap) == 0 && count($selected_color) == 0 && count($selected_size) == 0) {
            if ($newto != '' && $datafrom != '') {
                $Products = DB::select("SELECT * FROM `products` WHERE discount_price BETWEEN " . $newto . " AND " . $datafrom . " ORDER BY id DESC ");
            } else {
                $Products = DB::select("SELECT * FROM `products` ORDER BY id DESC ");
            }
        } else {

            if (count($selected_shap) == 0) {

                if (count($selected_color) == 0 && count($selected_size) > 0) {
                    if ($newto != '' && $datafrom != '') {
                        $Products = DB::select("SELECT * FROM `products` WHERE product_size IN (" . implode(",", $selected_size) . ") AND discount_price BETWEEN " . $newto . " AND " . $datafrom . " ORDER BY id DESC ");
                    } else {
                        // return "SELECT * FROM `products` WHERE product_size IN (".implode(",",$selected_size).") ORDER BY id DESC ";
                        $Products = DB::select("SELECT * FROM `products` WHERE product_size IN (" . implode(",", $selected_size) . ") ORDER BY id DESC ");
                    }
                } elseif (count($selected_color) > 0 && count($selected_size) == 0) {
                    if ($newto != '' && $datafrom != '') {
                        $Products = DB::select("SELECT * FROM `products` WHERE product_color IN (" . implode(",", $selected_color) . ") AND discount_price BETWEEN " . $newto . " AND " . $datafrom . " ORDER BY id DESC ");
                    } else {
                        $Products = DB::select("SELECT * FROM `products` WHERE product_color IN (" . implode(",", $selected_color) . ") ORDER BY id DESC ");
                    }
                } else {
                    if ($newto != '' && $datafrom != '') {
                        $Products = DB::select("SELECT * FROM `products` WHERE product_color IN (" . implode(",", $selected_color) . ") and product_size IN (" . implode(",", $selected_size) . ") AND discount_price BETWEEN " . $newto . " AND " . $datafrom . " ORDER BY id DESC ");
                    } else {
                        $Products = DB::select("SELECT * FROM `products` WHERE product_color IN (" . implode(",", $selected_color) . ") and product_size IN (" . implode(",", $selected_size) . ") ORDER BY id DESC ");
                    }
                }
            } elseif (count($selected_color) == 0) {

                if (count($selected_shap) > 0 && count($selected_size) > 0) {
                    if ($newto != '' && $datafrom != '') {
                        $Products = DB::select("SELECT * FROM `products` WHERE product_size IN (" . implode(",", $selected_size) . ") and product_shap IN (" . implode(",", $selected_shap) . ") AND discount_price BETWEEN " . $newto . " AND " . $datafrom . " ORDER BY id DESC ");
                    } else {
                        $Products = DB::select("SELECT * FROM `products` WHERE product_size IN (" . implode(",", $selected_size) . ") and product_shap IN (" . implode(",", $selected_shap) . ") ORDER BY id DESC ");
                    }
                } elseif (count($selected_size) == 0 && count($selected_shap) > 0) {
                    if ($newto != '' && $datafrom != '') {
                        $Products = DB::select("SELECT * FROM `products` WHERE product_shap IN (" . implode(",", $selected_shap) . ") AND discount_price BETWEEN " . $newto . " AND " . $datafrom . " ORDER BY id DESC ");
                    } else {
                        $Products = DB::select("SELECT * FROM `products` WHERE product_shap IN (" . implode(",", $selected_shap) . ") ORDER BY id DESC ");
                    }
                } elseif (count($selected_shap) == 0 && count($selected_size) > 1) {
                    if ($newto != '' && $datafrom != '') {
                        $Products = DB::select("SELECT * FROM `products` WHERE product_size IN (" . implode(",", $selected_size) . ") AND discount_price BETWEEN " . $newto . " AND " . $datafrom . " ORDER BY id DESC ");
                    } else {
                        $Products = DB::select("SELECT * FROM `products` WHERE product_size IN (" . implode(",", $selected_size) . ") ORDER BY id DESC ");
                    }
                }
            } elseif (count($selected_size) == 0) {

                if (count($selected_shap) > 0 && count($selected_color) > 0) {
                    if ($newto != '' && $datafrom != '') {
                        $Products = DB::select("SELECT * FROM `products` WHERE product_color IN (" . implode(",", $selected_color) . ") and product_shap IN (" . implode(",", $selected_shap) . ") AND discount_price BETWEEN " . $newto . " AND " . $datafrom . " ORDER BY id DESC ");
                    } else {
                        $Products = DB::select("SELECT * FROM `products` WHERE product_color IN (" . implode(",", $selected_color) . ") and product_shap IN (" . implode(",", $selected_shap) . ") ORDER BY id DESC ");
                    }
                } elseif (count($selected_color) == 0 && count($selected_shap) > 0) {
                    if ($newto != '' && $datafrom != '') {
                        $Products = DB::select("SELECT * FROM `products` WHERE product_shap IN (" . implode(",", $selected_shap) . ") AND discount_price BETWEEN " . $newto . " AND " . $datafrom . " ORDER BY id DESC ");
                    } else {
                        $Products = DB::select("SELECT * FROM `products` WHERE product_shap IN (" . implode(",", $selected_shap) . ") ORDER BY id DESC ");
                    }
                } elseif (count($selected_shap) == 0 && count($selected_color) > 1) {
                    if ($newto != '' && $datafrom != '') {
                        $Products = DB::select("SELECT * FROM `products` WHERE product_color IN (" . implode(",", $selected_color) . ") AND discount_price BETWEEN " . $newto . " AND " . $datafrom . " ORDER BY id DESC ");
                    } else {
                        $Products = DB::select("SELECT * FROM `products` WHERE product_color IN (" . implode(",", $selected_color) . ") ORDER BY id DESC ");
                    }
                }
            }
        }

        $html = '';
        foreach ($Products as $key => $product) {
            // dd($product->id);
            $Galleries = Gallerie::where(['product_id' => $product->id])->get();

            $Catagories = Category::where(['id' => $product->category_id])->get();

            if (count($Catagories) > 0) {
                $cateslug = $Catagories[0]->slug;
                $catename = $Catagories[0]->name;
            } else {
                $cateslug = '';
                $catename = '';
            }
            if (count($Galleries) > 0) {
                $gallary = $Galleries[0]->photo;
            } else {
                $gallary = '';
            }
            $html .= '<div class="c-product-grid_item"><div class="c-product-grid_thumb-wrap"><a href="product/' . $product->slug . '" class="lrv-loop-product_link"><img src="' . $product->image_one . '" class="c-product-grid_thumb"><img src="' . $gallary . '" class="c-product-grid_thumb product_grid_thumb_hover"></a><div class="c-product-grid_badges"></div><div class="c-product-grid_thumb-button-list"><button class="h-cb c-product-grid_thumb-button"><i class="ip-eye c-product-grid_icon"></i> <span class="c-product-grid_icon-text">Quick view</span></button> <button data-size="" class="js-wishlist-btn"><i class="ip-heart c-product-grid_icon"></i></button></div></div><a href="product/' . $product->slug . '" class="c-product-grid_atc"><span class="c-product-grid_atc-text">View Product</span></a><div class="c-product-grid_details"><div class="c-product-grid_title-wrap"><div class="c-product-grid_category-list"><a class="c-product-grid_category-item" href="/category/' . $cateslug . '">' . $catename . '</a></div><a href="product/' . $product->slug . '" class="product_link_link"><h2 class="lrv-loop-product_title">' . $product->product_name . '</h2></a></div><div class="c-product-grid_price-wrap"><span class="price"><span class="lrv-Price-amount amount"><bdi><span class="lrv-Price-currencySymbol">$</span>' . $product->discount_price . '</bdi></span></span></div></div></div>';
        }
        // return $html;
        if ($html == '') {
            $html = '<span style="width: 100%;text-align: center;margin: 185px;">No Record Found!</span>';
        } else {
            $html = $html;
        }

        return $html;
    }

    public function get_selected_price(Request $request)
    {
        $html = '';
        $products = Product::select('products.*')->orderBy('products.id', 'DESC')->get();
        // dd($products);
        //price filter
        $npro = array();
        foreach ($products as $key => $product) {
            if (isset($request->min_price) && isset($request->max_price)) {
                //var_dump( $product->discount_price);
                $price = str_replace(',', '', $product->discount_price);
                $price = (float) $price;
                $price = ceil($price);

                if ($price >= $request->min_price && $price <= $request->max_price) {

                    $npro[] = $product;
                }
            } else {
                $npro[] = $product;
            }
        }
        $products = $npro;
        if ($request->shap) {
            $shap = explode(',', $request->shap);
            //  dd($shap);
            $npro = array();
            foreach ($products as $key => $product) {
                $pshaps = array();
                if ($product->product_shap) {
                    $pshaps = explode(',', $product->product_shap);
                    // dd(array_intersect($pshaps,$shap));
                }

                if (array_intersect($pshaps, $shap)) {
                    $npro[] = $product;
                }
            }
            // dd($npro);
            $products = $npro;
        }
        if ($request->size) {
            $size = explode(',', $request->size);
            //  dd($size);
            $npro = array();
            foreach ($products as $key => $product) {
                $pshaps = array();
                if ($product->product_clarity) {
                    $pshaps = explode(',', $product->product_clarity);
                    // dd(array_intersect($pshaps,$shap));
                }

                if (array_intersect($pshaps, $size)) {
                    $npro[] = $product;
                }
            }
            // dd($npro);
            $products = $npro;
        }
        if ($request->category) {
            //  dd($size);
            $npro = array();
            foreach ($products as $key => $product) {
                $pshaps = array();
                if ($product->category_id) {
                    $pshaps = explode(',', $product->category_id);
                    // dd(array_intersect($pshaps,$shap));
                }
                // if($product->id == 141)
                // {
                //     var_dump($request->category);
                //     var_dump($pshaps);
                //     die("OK");
                // }

                if (in_array($request->category, $pshaps)) {
                    $npro[] = $product;
                }
            }
            // dd($npro);
            $products = $npro;
        }
        if ($request->colors) {
            $size = explode(',', $request->colors);
            //  dd($size);
            $npro = array();
            foreach ($products as $key => $product) {
                $pshaps = array();
                if ($product->product_color) {
                    $pshaps = explode(',', $product->product_color);
                    // dd(array_intersect($pshaps,$shap));
                }

                if (array_intersect($pshaps, $size)) {
                    $npro[] = $product;
                }
            }
            // dd($npro);
            $products = $npro;
        }
        //price filter
        foreach ($products as $key => $product) {
            // dd($product->id);
            $Galleries = Gallerie::where(['product_id' => $product->id])->get();

            $Catagories = Category::where(['id' => $product->category_id])->get();

            if (count($Catagories) > 0) {
                $cateslug = $Catagories[0]->slug;
                $catename = $Catagories[0]->name;
            } else {
                $cateslug = '';
                $catename = '';
            }
            if (count($Galleries) > 0) {
                $gallary = $Galleries[0]->photo;
            } else {
                $gallary = '';
            }
            $html .= '<div class="c-product-grid_item"><div class="c-product-grid_thumb-wrap"><a href="' . url('/') . '/product/' . $product->slug . '" class="lrv-loop-product_link"><img src="/' . $product->image_one . '" class="c-product-grid_thumb"><img src="' . $gallary . '" class="c-product-grid_thumb product_grid_thumb_hover"></a><div class="c-product-grid_badges"></div><div class="c-product-grid_thumb-button-list"><button class="h-cb c-product-grid_thumb-button"><i class="ip-eye c-product-grid_icon"></i> <span class="c-product-grid_icon-text">Quick view</span></button> <button data-size="" class="js-wishlist-btn"><i class="ip-heart c-product-grid_icon"></i></button></div></div><a href="product/' . $product->slug . '" class="c-product-grid_atc"><span class="c-product-grid_atc-text">View Product</span></a><div class="c-product-grid_details"><div class="c-product-grid_title-wrap"><div class="c-product-grid_category-list"><a class="c-product-grid_category-item" href="/category/' . $cateslug . '">' . $catename . '</a></div><a href="product/' . $product->slug . '" class="product_link_link"><h2 class="lrv-loop-product_title">' . $product->product_name . '-' . $product->category_id . '</h2></a></div><div class="c-product-grid_price-wrap"><span class="price"><span class="lrv-Price-amount amount"><bdi><span class="lrv-Price-currencySymbol">$</span>' . $product->discount_price . '</bdi></span></span></div></div></div>';
        }
        // var_dump($html);

        if ($html == '') {
            $html = '<span style="width: 100%;text-align: center;margin: 185px;">No Record Found!</span>';
        } else {
            $html = $html;
        }

        return $html;
    }

    public function get_selected_detail(Request $request)
    {
        $data = $request->data;
        $old = $request->session()->get('selected_color');

        if ($request->action == "add" && $request->method == "colors") {

            // $request->session()->forget('selected_color');
            if (isset($old)) {
                if (count($old) != 0) {
                    if (in_array($data, $old)) {
                    } else {
                        array_push($old, $data);
                        $request->session()->put('selected_color', $old);
                    }
                } else {
                    $array = array();
                    array_push($array, $data);
                    $request->session()->put('selected_color', $array);
                }
            } else {
                $array = array();
                array_push($array, $data);
                $request->session()->put('selected_color', $array);
                // print_r($old);
            }
        } elseif ($request->action == "remove" && $request->method == "colors") {

            foreach (array_keys($old, $data, true) as $key) {
                unset($old[$key]);
            }

            $request->session()->forget('selected_color');
            $request->session()->put('selected_color', $old);
        }

        $oldone = $request->session()->get('selected_size');
        if ($request->action == "add" && $request->method == "colors") {

            // $request->session()->forget('selected_size');
            if (isset($oldone)) {
                if (count($oldone) != 0) {
                    if (in_array($data, $oldone)) {
                    } else {
                        array_push($oldone, $data);
                        $request->session()->put('selected_size', $oldone);
                    }
                } else {
                    $array = array();
                    array_push($array, $data);
                    $request->session()->put('selected_size', $array);
                }
            } else {
                $array = array();
                array_push($array, $data);
                $request->session()->put('selected_size', $array);
                // print_r($oldone);
            }
        } elseif ($request->action == "remove" && $request->method == "colors") {

            foreach (array_keys($oldone, $data, true) as $key) {
                unset($oldone[$key]);
            }

            $request->session()->forget('selected_size');
            $request->session()->put('selected_size', $oldone);
        }
    }

    public function brand_detail($slug)
    {
        $brands = Brand::all();
        $Slider = Slider::all();
        $categories = Category::all();

        $brand_id = brand::where(['slug' => $slug])->first();

        $meta = DB::table('brand_to_meta')
            ->where('bid', '=', $brand_id->id)
            ->first();
        if ($meta) {
            $meta->image = '';
            $meta->url = url('/brand/') . '/' . $slug;
            $sch = array(
                '@context' => 'https://schema.org/',
                '@type' => 'Brand',
                'name' => $meta->title,
                'description' => $meta->description,
                'brand' => array(
                    '@type' => 'Brand',
                    'name' => 'UAE Disar',
                ),
                'sku' => 'DealStore_diSUa',
                'gtin13' => '54435345',
                'offers' => array(
                    '@type' => 'AggregateOffer',
                    'url' => url()->current(),
                    'priceCurrency' => 'PKR',
                    'lowPrice' => '1999',
                    'highPrice' => '2000',
                    'offerCount' => '5',
                ),
                'aggregateRating' => array(
                    '@type' => 'AggregateRating',
                    'ratingValue' => '5',
                    'bestRating' => '5',
                    'worstRating' => '1',
                    'ratingCount' => '1',
                    'reviewCount' => '1',
                ),
                'review' => array(
                    '@type' => 'Review',
                    'name' => 'Fahad Khan',
                    'reviewBody' => 'Best Product',
                    'reviewRating' => array(
                        '@type' => 'Rating',
                        'ratingValue' => '5',
                        'bestRating' => '5',
                        'worstRating' => '1',
                    ),
                    'datePublished' => '2022-05-01',
                    'author' => array(
                        '@type' => 'Person',
                        'name' => 'DealStore',
                    ),
                    'publisher' => array(
                        '@type' => 'Organization',
                        'name' => 'DealStore.com.pk',
                    ),
                ),
            );
            $meta->scheme = $sch;
        }
        // dd($brand_id[0]->id);
        $products = Product::where(['brand_id' => $brand_id->id, 'status' => 1])->orderby('id', 'desc')->paginate(40);

        return view('front.brand_detail', compact('products', 'categories', 'brand_id', 'meta'));
    }

    public function tags_detail($slug)
    {
        $Slider = Slider::all();
        $categories = Category::all();

        $rproducts = product::where('tags', 'ilike', '%' . $slug . '%')->get();

        $tags = str_replace('-', ' ', $slug);

        return view('front.result_detail', compact('rproducts', 'categories', 'tags', 'slug'));
    }

    // public function search_detail(Request $slug)
    // {
    //     $brands=Brand::all();
    //     $Slider=Slider::all();
    //     $categories=Category::all();
    //     // return $slug->input();
    //     $rproducts = product::where('product_name', 'like', '%'.$slug->input('q').'%')->get();

    //     return view('front.result_detail',compact('rproducts','categories','brands'));
    // }

    public function aboutus()
    {
        $page = Pages::where(['slug' => 'about-us'])->first();
        $page->increment('view');
        Session::put('title', $page->name);
        return view('front.aboutus', compact('page'));
    }
    public function privacypolicy()
    {
        $page = Pages::where(['slug' => 'privacypolicy'])->first();
        $page->increment('view');
        Session::put('title', 'Privacy Policy');
        return view('front.privacypolicy', compact('page'));
    }
    public function terms()
    {
        $page = Pages::where(['slug' => 'terms'])->first();
        $page->increment('view');
        Session::put('title', 'Terms');
        return view('front.terms', compact('page'));
    }
    public function becomepartner()
    {
        Session::put('title', 'Be Come Partner');
        return view('front.becomepartner');
    }

    public function faqs()
    {
        $page = Pages::where(['slug' => 'faqs'])->first();
        $page->increment('view');
        Session::put('title', 'FAQ`S');
        $faqs = Faq::where('page', 'general')->get();
        return view('front.faqs', compact('page', 'faqs'));
    }

    public function locations()
    {

        $locations = ModelsLocation::all();
        $page = Pages::where(['slug' => 'our-stores'])->first();
        $page->increment('view');
        Session::put('title', $page->name);
        $faqs = Faq::where('page', 'stores')->get();
        return view('front.locations', compact('locations', 'page', 'faqs'));
    }

    public function retailers()
    {

        $page = Pages::where(['slug' => 'retailer-reseller'])->first();
        $page->increment('view');
        Session::put('title', $page->name);
        $faqs = Faq::where('page', 'retailers')->get();
        $resslerfaqs = Faq::where('page', 'resellers')->get();
        return view('front.retailers', compact('page', 'faqs', 'resslerfaqs'));
    }
    public function partners()
    {
        $page = Pages::where(['slug' => 'partners'])->first();
        $faqs = Faq::where('page', 'partners')->get();
        $page->increment('view');
        Session::put('title', $page->name);
        return view('front.partners', compact('page', 'faqs'));
    }

    public function corporateEvents()
    {
        $page = Pages::where(['slug' => 'corporate-events'])->first();
        $faqs = Faq::where('page', 'corporate-events')->get();
        $page->increment('view');
        Session::put('title', $page->name);
        return view('front.corporate-events', compact('page', 'faqs'));
    }
    public function resellers()
    {
        Session::put('title', 'Resellers');
        $page = Pages::where(['slug' => 'resellers'])->first();
        $faqs = Faq::where('page', 'resellers')->get();
        $page->increment('view');
        Session::put('title', $page->name);
        return view('front.reseller', compact('page', 'faqs'));
    }
    public function influencers()
    {
        $page = Pages::where(['slug' => 'influencers'])->first();
        $faqs = Faq::where('page', 'influencers')->get();
        $page->increment('view');
        Session::put('title', $page->name);
        return view('front.influencers', compact('page', 'faqs'));
    }
    public function makeownbasket()
    {
        Session::put('title', 'Make Own Basket');
        $product = Product::where('format', 1)->where('status', 1)->get();
        $packages = PackageType::all();
        $sizes = BoxSize::all();
        $boxes = DB::table('box_customize')
            ->join('package_types', 'box_customize.package_id', '=', 'package_types.id')
            ->join('box_sizes', 'box_customize.size_id', '=', 'box_sizes.id')
            ->select('box_customize.*', 'package_types.name as package_type_name', 'package_types.id as package_type_id', 'box_sizes.name as box_size_name', 'box_sizes.id as box_sizes_id')
            ->get();
        return view('front.makeownbasket', compact('product', 'sizes', 'packages'));
    }
    public function get_box(Request $request)
    {
        Session::forget('cart_customize');
        $package_type = $request->package_type;
        $size = $request->size;

        $box = [
            'package_type' => $package_type,
            'size' => $size,

        ];
        session(['selected_box' => $box]);

        $boxes = BoxCustomize::where('box_customize.package_id', $package_type)
            ->where('box_customize.size_id', $size)
            ->join('package_types', 'box_customize.package_id', '=', 'package_types.id')
            ->join('box_sizes', 'box_customize.size_id', '=', 'box_sizes.id')
            ->select(
                'box_customize.*',
                'package_types.name as package_name',
                'box_sizes.name as size_name'
            )
            ->get();
        $cart = session()->get('cart_customize', []);

        $totalQuantity = array_sum(array_column($cart, 'quantity'));

        return response()->json([
            'boxes' => $boxes,
            'total_quantity' => $totalQuantity,
        ]);
    }
    public function import_product()
    {
        Session::put('title', 'import_product');
        return view('front.import_product');
    }

    public function importProducts(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        try {
            // dd($request);
            $filePath = $request->file('file')->store('temp');
            $absolutePath = storage_path('app/' . $filePath);

            // Import the Excel data
            Excel::import(new ProductsImport, $absolutePath);
            return back()->with('success', 'Products imported successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Error importing file: ' . $e->getMessage());
        }
    }

    public function thankyou()
    {
        Session::put('title', 'Thankyou');
        return view('front.thanks');
    }

    public function searchProducts(Request $request)
    {
        $query = $request->input('text');
        $products = Product::where('product_name', 'ilike', "%{$query}%")->where('status', 1)->limit(10)->get();
        return response()->json($products);
    }

    public function getShippingRules($city_id = null, $country_id = null)
    {
        if ($city_id) {
            $city = City::where('name', $city_id)->first();
            if ($city && $city->min_order > 0 && $city->shipping_cost > 0 && $city->free_shipping > 0) {
                return response()->json([
                    'name' => $city->name,
                    'minOrder' => (int)$city->min_order,
                    'shippingCost' => (int)$city->shipping_cost,
                    'freeShippingThreshold' => (int)$city->free_shipping,
                    'discount' => Session::get('cart.discount', 0),
                ]);
                exit;
            }
        }
        if ($country_id) {
            $country = Countries::where('name', $country_id)->first();
            if ($country) {
                return response()->json([
                    'name' => $country->name,
                    'minOrder' => (int)$country->min_order,
                    'shippingCost' => (int)$country->shipping_cost,
                    'freeShippingThreshold' => (int)$country->free_shipping,
                    'discount' => Session::get('cart.discount', 0),
                ]);
                exit;
            }
        }

        return response()->json([
            'minOrder' => 0,
            'shippingCost' => 0,
            'freeShippingThreshold' => 0,
            'discount' => 0,
        ]);
    }

    public function getCities($country_id)
    {
        $country = Countries::where('name', $country_id)->first();
        if (! $country) {
            return response()->json([]);
        }
        $cities = City::where('country_id', $country->id)->where('status', 1)->get();

        return response()->json($cities);
    }

    public function subscribe(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'recaptcha' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Invalid input.']);
        }

        // Verify reCAPTCHA
        // $recaptchaSecret = '6LdJrO8qAAAAAOSgu1BqYm1f1-W7LKv3di-ZtVnU'; // Add your reCAPTCHA secret key
        // $recaptchaResponse = $request->input('recaptcha');
        // $verifyResponse = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$recaptchaSecret}&response={$recaptchaResponse}");
        // $responseData = json_decode($verifyResponse);

        // if (!$responseData->success) {
        //     return response()->json(['success' => false, 'message' => 'reCAPTCHA verification failed.']);
        // }

        // Check if email already exists
        $email = $request->input('email');
        if (Newsletter::where('email', $email)->exists() || Customer::where('email', $email)->exists()) {
            return response()->json(['success' => false, 'message' => 'Email already subscribed.']);
        }

        // Save email to newsletter table
        Newsletter::create(['email' => $email]);

        // Generate coupon code (example)
        $couponCode = 'WELCOME10';

        // Send email with coupon code
        Mail::to($email)->send(new CouponEmail($couponCode));

        return response()->json(['success' => true, 'message' => 'Subscription successful!']);
    }
}
