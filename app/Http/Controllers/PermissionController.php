<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::all();
        return view('admins.permissions.index', compact('permissions'));
    }

    public function create()
    {
        return view('admins.permissions.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'module_name' => 'required|string|max:255|unique:permissions,module_name',
        ]);

        Permission::create($validatedData);

        return redirect()->route('admins.permissions.index')->with('success', 'Permission created successfully.');
    }


    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        return view('admins.permissions.edit', compact('permission'));
    }

    public function update(Request $request, Permission $permission)
    {
        $validatedData = $request->validate([
            'module_name' => 'required|string|max:255|unique:permissions,module_name,' . $permission->id,
        ]);

        $permission->update($validatedData);

        return redirect()->route('admins.permissions.index')->with('success', 'Permission updated successfully.');
    }


    public function destroy($id)
    {
        Permission::destroy($id);
        return redirect()->route('admins.permissions.index')->with('success', 'Permission deleted successfully.');
    }
}
