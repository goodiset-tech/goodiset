<?php

namespace App\Imports;

use App\Models\Admins\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;
class ProductsImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

        //try{
            // $product = New Product();

            // $product->sku = $row['sku'];
            // $product->product_code = $row['product_code'];
            // $product->product_name = $row['product_name'];
            // $product->slug = Str::slug($row['product_name'], '-') ;
            // $product->category_id = $row['category_id'];
            // $product->sub_category_id = $row['sub_category_id'];
            // $product->formate_id = $row['formate_id'];
            // $product->falvour_id = $row['falvour_id'];
            // $product->product_details = $row['product_detail'];
            // $product->brand_id =0;
            // $product->product_quantity =100;
            // $product->selling_price =0;
            // $product->discount_price =0;
            // $product->shipping_price =0;
            // $product->image_one = 'no_product.png';
            // $product->save();


    $row = array_filter($row, fn($value) => !is_null($value) && $value !== '');
    $row['product_code'] = (string)$row['product_code'];
    \Log::info('Row data:', $row);
    return new Product([
        'sku' => $row['sku'] ?? " ",
        'product_code' => $row['product_code'],
        'product_name' => $row['product_name'],
        'slug' => Str::slug($row['product_name'], '-'),
        'category_id' => (int)$row['category_id'] ?? 0,
        'sub_category_id' => (int)$row['sub_category_id'] ?? 0,
        'format' => $row['formate_id'] ?? "",
        'flavour_id' => 0,
        'product_details' => $row['product_detail'],
        'brand_id' => 0,
        'product_quantity' => 100,
        'selling_price' => 8,
        'discount_price' => 10,
        'shipping_price' => 2,
        'image_one' => 'no_product.png',
        'country' => (int) $row['country'] ?? 0,
    ]);

}

        // } catch (\Exception $e) {
        //     return back()->with('error', 'Error importing file: ' . $e->getMessage());
        // }
        

    
}
