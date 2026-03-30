<?php

namespace App\Models\Admins;

use App\Models\ProductVariation;
use App\Models\Flavour;
use App\Models\Format;
use App\Models\PackageType;
use App\Models\ProductType;
use App\Models\Theme;
use App\Models\BasketType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    // protected $fillable = [
    //     'sku', 'product_code', 'product_name', 'slug', 'category_id',
    //     'sub_category_id', 'formate_id', 'falvour_id', 'product_details',
    //     'brand_id', 'product_quantity', 'selling_price', 'discount_price',
    //     'shipping_price', 'image_one'
    // ];
    public function variations()
    {
        return $this->hasMany(ProductVariation::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function color()
    {
        return $this->belongsTo(Colors::class, 'product_color');
    }

    public function size()
    {
        return $this->belongsTo(Size::class, 'product_size');
    }

    public function theme()
    {
        return $this->belongsTo(Theme::class, 'theme_id');
    }

    public function flavour()
    {
        return $this->belongsTo(Flavour::class, 'flavour_id');
    }

    public function productType()
    {
        return $this->belongsTo(ProductType::class, 'product_type_id');
    }

    public function packageType()
    {
        return $this->belongsTo(PackageType::class, 'package_type_id');
    }

    public function basketType()
    {
        return $this->belongsTo(BasketType::class, 'basket_type_id');
    }

    public function format()
    {
        return $this->belongsTo(Format::class, 'format');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }

    // Access category_id as an array of IDs
    public function getCategoryIdsAttribute()
    {
        return $this->category_id ? explode(',', $this->category_id) : [];
    }

    // Fetch categories based on category_id
    public function categories()
    {
        return Category::whereIn('id', $this->getCategoryIdsAttribute())->get();
    }

    // Access product_color as an array of IDs
    public function getColorIdsAttribute()
    {
        return $this->product_color ? explode(',', $this->product_color) : [];
    }

    // Fetch colors based on product_color
    public function colors()
    {
        return Colors::whereIn('id', $this->getColorIdsAttribute())->get();
    }

    // Access product_size as an array of IDs
    public function getSizeIdsAttribute()
    {
        return $this->product_size ? explode(',', $this->product_size) : [];
    }

    // Fetch sizes based on product_size
    public function sizes()
    {
        return Size::whereIn('id', $this->getSizeIdsAttribute())->get();
    }
}
