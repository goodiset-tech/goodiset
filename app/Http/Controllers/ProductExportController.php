<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;
use League\Csv\Writer;
use Illuminate\Support\Facades\Storage;

class ProductExportController extends Controller
{
    // Export products as a CSV file
    public function export()
    {
        $products = DB::table('products')->get();

        if ($products->isEmpty()) {
            return back()->with('error', 'No products found to export.');
        }

        $csvPath = 'exports/products.csv';
        $csv = Writer::createFromPath(public_path($csvPath), 'w+');
        $headers = array_keys((array)$products->first());
        $csv->insertOne($headers);

        foreach ($products as $product) {
            $csv->insertOne((array)$product);
        }

        return response()->download(public_path($csvPath))->deleteFileAfterSend(true);
    }

    // Import products from an uploaded CSV file
    public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:csv,txt|max:2048',
    ]);

    $file = $request->file('file');
    $csv = Reader::createFromPath($file->getRealPath(), 'r');
    $csv->setHeaderOffset(0);

    $records = $csv->getRecords();

    foreach ($records as $record) {
        // Handle nullable or numeric fields
        $record['id'] = is_numeric($record['id']) ? $record['id'] : null;
        $record['brand_id'] = is_numeric($record['brand_id']) ? $record['brand_id'] : null;
        $record['package_type_id'] = is_numeric($record['package_type_id']) ? $record['package_type_id'] : null;
        $record['flavour_id'] = is_numeric($record['flavour_id']) ? $record['flavour_id'] : null;
        $record['basket_type_id'] = is_numeric($record['basket_type_id']) ? $record['basket_type_id'] : null;
        $record['product_type_id'] = is_numeric($record['product_type_id']) ? $record['product_type_id'] : null;
        $record['sub_category_id'] = is_numeric($record['sub_category_id']) ? $record['sub_category_id'] : null;
        $record['created_at'] = empty($record['created_at']) ? now() : $record['created_at'];
        $record['updated_at'] = empty($record['updated_at']) ? now() : $record['updated_at'];
        $record['carat'] = is_numeric($record['carat']) ? $record['carat'] : null;
        $record['discount_price'] = is_numeric($record['discount_price']) ? $record['discount_price'] : null;

        // Check for unique `slug` and make it unique if necessary
        $originalSlug = $record['slug'];
        $uniqueSlug = $originalSlug;
        $count = 1;

        while (DB::table('products')->where('slug', $uniqueSlug)->exists()) {
            $uniqueSlug = $originalSlug . '-' . $count;
            $count++;
        }

        $record['slug'] = $uniqueSlug;

        // If id is empty, remove it from the record to force a new insert
        if (empty($record['id'])) {
            unset($record['id']);
        }

        // Perform the upsert (Insert if ID doesn't exist, otherwise update)
        DB::table('products')->updateOrInsert(
            ['id' => $record['id'] ?? null], // Match on primary key, if exists
            $record // Update or create with CSV data
        );
    }

    return redirect(route('admins.products'))->with([
        'msg' => 'Products imported successfully!',
        'msg_type' => 'success',
    ]);
}


    public function importexport(Request $request)
    {
        return view('admins.importexport');
    }
}

