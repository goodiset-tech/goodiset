<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsExport implements FromCollection, WithHeadings
{
    protected $products;
    protected $columns;

    public function __construct($products, $columns)
    {
        $this->products = $products;
        $this->columns = $columns;
    }

    public function collection()
    {
        return $this->products;
    }

    public function headings(): array
    {
        // Define the mapping of database column names to display names
        $columnMap = [
            'product_name' => 'Product Name',
            'name_ar' => 'Name (Arabic)',
            'category_id' => 'Category ID',
            'brand_id' => 'Brand ID',
            'name_sw' => 'Name (Swedish)',
            'slug' => 'Slug',
            'sku' => 'SKU',
            'product_code' => 'Product Code',
            'product_quantity' => 'Product Quantity',
            'product_details' => 'Product Details',
            'short_description' => 'Short Description',
            'related_product_id' => 'Related Product ID',
            'product_color' => 'Product Color',
            'product_size' => 'Product Size',
            'product_shape' => 'Product Shape',
            'tags' => 'Tags',
            'selling_price' => 'Discounted Price',
            'discount_price' => 'Price',
            'shipping_price' => 'Shipping Price',
            'new_arrival' => 'New Arrival',
            'featured' => 'Featured',
            'view' => 'Visits',
            'sale' => 'Sale',
            'status' => 'Status',
            'image_one' => 'Image One',
            'thumb' => 'Thumbnail',
            'gallary_images' => 'Gallery Images',
            'theme_id' => 'Theme ID',
            'package_type_id' => 'Package Type ID',
            'flavour_id' => 'Flavour ID',
            'basket_type_id' => 'Basket Type ID',
            'product_type_id' => 'Product Type ID',
            'ingredient' => 'Ingredient',
            'allergen' => 'Allergen',
            'weight' => 'Weight',
            'format_id' => 'Format',
            'country' => 'Country',
            'sub_category_id' => 'Sub Category ID',
            'total_weight' => 'Total Weight',
            'palm_oil' => 'Palm Oil',
            'vegan' => 'Vegan',
            'gelatin_free' => 'Gelatin Free',
            'lactose_free' => 'Lactose Free',
            'sustainability' => 'Sustainability',
            'bundle_product_id' => 'Bundle Product ID',
            'shape' => 'Shape',
            'ingredients_ar' => 'Ingredients (Arabic)',
            'b2c_price' => 'B2C Price',
            'b2b_price' => 'B2B Price',
            'b2d_price' => 'B2D Price',
            'b2p' => 'B2P',
            'HS_Code' => 'HS Code',
            'Country_Code' => 'Country Code',
            'Country' => 'Country',
            'Country_in_English' => 'Country in English',
            'Country_in_Arabic' => 'Country in Arabic',
            'nutritional_facts' => 'Nutritional Facts',
            'sort_order' => 'Sort Order',
            'gluten_free' => 'Gluten Free',
            'sku_no' => 'SKU Number',
            'article_number' => 'Article Number',
            'orignal_name' => 'Original Name',
            'original_price' => 'Original Price',
            'nutritions' => 'Nutritions',
        ];

        // Map the selected columns to their display names
        return array_map(function ($column) use ($columnMap) {
            return $columnMap[$column] ?? $column; // Fallback to column name if not in map
        }, $this->columns);
    }
}