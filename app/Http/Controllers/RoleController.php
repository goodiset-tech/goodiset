<?php
namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions:id,name,module_name,action')->get();
        return view('admins.roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::select('id', 'name', 'module_name', 'action')->get();
        $modules = $permissions->pluck('module_name')->unique();
        return view('admins.roles.create', compact('permissions','modules'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role = Role::create(['name' => $request->name]);
        $role->permissions()->sync($request->permissions);

        return redirect()->route('admins.roles.index')->with('success', 'Role created successfully.');
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::select('id', 'name', 'module_name', 'action')->get();
        $modules = $permissions->pluck('module_name')->unique();
        return view('admins.roles.edit', compact('role', 'permissions','modules'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:roles,name,' . $id,
                'permissions' => 'required|array',
                'permissions.*' => 'exists:permissions,id',
            ]);

            $role = Role::findOrFail($id);
            $role->update(['name' => $request->name]);
            $role->permissions()->sync($request->permissions);

            return redirect()->route('admins.roles.index')->with('success', 'Role updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete(); // Use soft delete if applicable
        return redirect()->route('admins.roles.index')->with('success', 'Role deleted successfully.');
    }
}
