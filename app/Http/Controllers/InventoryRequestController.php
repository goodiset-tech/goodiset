<?php

namespace App\Http\Controllers;

use App\Models\InventoryRequest;
use App\Models\InventoryRequestItem;
use App\Models\Warehouse;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\InventoryRequestCreated;
use App\Models\Admins\Product as AdminsProduct;
use App\Models\Admins\User;
use App\Models\User as ModelsUser;

class InventoryRequestController extends Controller
{
    // Display all inventory requests
    public function index()
    {
        $requests = InventoryRequest::with(['pickupWarehouse', 'dropoffWarehouse', 'items.product'])->get();
        return view('admins.inventory_requests.index', compact('requests'));
    }

    // Show the form to create a new inventory request
    public function create()
    {
        $warehouses = Warehouse::all();
        $products = AdminsProduct::all();
        $users = User::all();
        return view('admins.inventory_requests.create', compact('warehouses', 'products', 'users'));
    }

    // Store a new inventory request
    public function store(Request $request)
    {
        $request->validate([
            'pickup_warehouse_id' => 'required|exists:warehouses,id',
            'dropoff_warehouse_id' => 'required|exists:warehouses,id',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.unit' => 'required|string',
            'users' => 'required|array',
            'users.*' => 'exists:users,id',
        ]);

        // Create the inventory request
        $inventoryRequest = InventoryRequest::create([
            'pickup_warehouse_id' => $request->pickup_warehouse_id,
            'dropoff_warehouse_id' => $request->dropoff_warehouse_id,
            'status' => 'pending',
            'users' => $request->users,
        ]);

        // Add items to the request
        foreach ($request->products as $product) {
            InventoryRequestItem::create([
                'inventory_request_id' => $inventoryRequest->id,
                'product_id' => $product['product_id'],
                'quantity' => $product['quantity'],
                'unit' => $product['unit'],
            ]);
        }

        // Send email to selected users
        $users = User::whereIn('id', $request->users)->get();
        foreach ($users as $user) {
            Mail::to($user->email)->send(new InventoryRequestCreated($inventoryRequest));
        }

        return redirect()->route('admins.inventory-requests.index')->with('success', 'Inventory request created successfully.');
    }

    // Show details of a specific inventory request
    public function show(InventoryRequest $inventoryRequest)
    {
        return view('admins.inventory_requests.show', compact('inventoryRequest'));
    }

    // Show the form to edit an inventory request
    public function edit(InventoryRequest $inventoryRequest)
    {
        $warehouses = Warehouse::all();
        $products = AdminsProduct::all();
        $users = User::all();
        return view('admins.inventory_requests.edit', compact('inventoryRequest', 'warehouses', 'products', 'users'));
    }

    // Update an inventory request
    public function update(Request $request, InventoryRequest $inventoryRequest)
    {
        $request->validate([
            'pickup_warehouse_id' => 'required|exists:warehouses,id',
            'dropoff_warehouse_id' => 'required|exists:warehouses,id',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.unit' => 'required|string',
            'users' => 'required|array',
            'users.*' => 'exists:users,id',
        ]);

        // Update the inventory request
        $inventoryRequest->update([
            'pickup_warehouse_id' => $request->pickup_warehouse_id,
            'dropoff_warehouse_id' => $request->dropoff_warehouse_id,
            'users' => $request->users,
        ]);

        // Delete existing items and add new ones
        $inventoryRequest->items()->delete();
        foreach ($request->products as $product) {
            InventoryRequestItem::create([
                'inventory_request_id' => $inventoryRequest->id,
                'product_id' => $product['product_id'],
                'quantity' => $product['quantity'],
                'unit' => $product['unit'],
            ]);
        }

        // Send email to selected users
        $users = User::whereIn('id', $request->users)->get();
        foreach ($users as $user) {
            Mail::to($user->email)->send(new InventoryRequestCreated($inventoryRequest));
        }

        return redirect()->route('admins.inventory-requests.index')->with('success', 'Inventory request updated successfully.');
    }

    // Delete an inventory request
    public function destroy(InventoryRequest $inventoryRequest)
    {
        $inventoryRequest->items()->delete();
        $inventoryRequest->delete();
        return redirect()->route('admins.inventory-requests.index')->with('success', 'Inventory request deleted successfully.');
    }

    // Update the status of an inventory request
    public function updateStatus(Request $request, InventoryRequest $inventoryRequest)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $inventoryRequest->update([
            'status' => $request->status,
        ]);

        return redirect()->route('admins.inventory-requests.index')->with('success', 'Inventory request status updated successfully.');
    }
}