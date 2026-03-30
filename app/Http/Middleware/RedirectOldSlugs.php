<?php

namespace App\Http\Middleware;

use App\Models\Admins\Product as AdminsProduct;
use Closure;
use Illuminate\Http\Request;
use App\Models\ProductSlugRedirect;
use App\Models\Product;

class RedirectOldSlugs
{
    public function handle(Request $request, Closure $next)
    {
        $slug = $request->route('id'); // Assuming the slug is passed as a route parameter

        if ($slug) {
            // Check if the slug exists in the product_slug_redirects table
            $redirect = ProductSlugRedirect::where('old_slug', $slug)
                ->orderBy('created_at', 'desc')
                ->first();

            if ($redirect) {
                $product = AdminsProduct::find($redirect->product_id);

                if ($product && $product->slug !== $slug) {
                    // Only redirect if current slug is different from product's current slug
                    return redirect()->route('product.show', ['id' => $product->slug], 301);
                }
            }
        }

        return $next($request);
    }
}
