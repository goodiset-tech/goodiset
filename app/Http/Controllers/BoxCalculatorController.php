<?php

namespace App\Http\Controllers;

use App\Models\Admins\Box;
use App\Models\Admins\BoxProduct;
use App\Models\Admins\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BoxCalculatorController extends Controller
{
    public function index()
    {
        $products = Product::where('format', 1)->get();
        return view('admins.box_calculator', compact('products'));
    }

    public function list()
    {
        $boxes = Box::with('products.product')->get();
        return view('admins.box_list', compact('boxes'));
    }

    public function save(Request $request)
    {
        $data = $request->validate([
            'box_name' => 'required|string|max:255',
            'box_weight' => 'required|numeric|min:500',
            'max_boxes' => 'required|integer|min:0',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.percentage' => 'required|numeric|min:0|max:100',
            'products.*.pieces' => 'required|integer|min:0',
        ]);

        try {
            DB::beginTransaction();

            $box = Box::updateOrCreate(
                ['id' => $request->box_id],
                [
                    'box_name' => $data['box_name'],
                    'box_weight' => $data['box_weight'],
                    'max_boxes' => $data['max_boxes'],
                ]
            );

            if ($request->box_id) {
                BoxProduct::where('box_id', $box->id)->delete();
            }

            foreach ($data['products'] as $product) {
                BoxProduct::create([
                    'box_id' => $box->id,
                    'product_id' => $product['product_id'],
                    'percentage' => $product['percentage'],
                    'pieces' => $product['pieces'],
                ]);
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Box saved successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function edit($id)
    {
        $box = Box::with('products')->findOrFail($id);
        $products = Product::where('format', 1)->get();
        return view('admins.box_calculator', compact('box', 'products'));
    }

    public function delete($id)
    {
        $box = Box::findOrFail($id);
        $box->products()->delete();
        $box->delete();
        return redirect()->route('admins.box.list')->with('success', 'Box deleted successfully');
    }
}