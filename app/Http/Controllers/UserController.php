<?php

namespace App\Http\Controllers;

use App\Models\Admins\LogReport;
use App\Models\User;
use App\Models\Role;
use App\Models\Admins\CompaignEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index()
    {
        $users = User::with('roles')->get();
        return view('admins/users/index', compact('users'));
    }

    public function userLogReport(Request $request)
    {
        $data = LogReport::where('type', 'USER')->orderBy('id', 'desc')->get();
        return view('admins.logs.users', compact('data'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admins.users.create', compact('roles'));
    }

    public function campaignEmails()
    {
        $data = CompaignEmail::orderBy('id', 'desc')->get();
        return view('admins.users.campaign_emails', compact('data'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->all();

        if ($request->filled('password')) {
            $validatedData['password'] = Hash::make($request->password);
        }

        $user = User::create($validatedData);

        if ($request->has('roles')) {
            $user->roles()->sync($request->roles);
        }

        return redirect()->route('admins.users.index')->with('success', 'User created successfully.');
    }


    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('admins.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validatedData = $request->all();

        if ($request->filled('password')) {
            $validatedData['password'] = Hash::make($request->password);
        } else {
            unset($validatedData['password']);
        }
        $user->update($validatedData);

        if ($request->has('roles')) {
            $user->roles()->sync($request->roles);
        }

        return redirect()->route('admins.users.index')->with('success', 'User updated successfully.');
    }


    public function destroy($id)
    {
        User::destroy($id);
        return redirect()->route('admins.users.index')->with('success', 'User deleted successfully.');
    }
}
