<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('role.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'roleName' => 'required|string|max:255',
            'permissions' => 'array',
            'permissions.*' => 'integer|exists:permissions,id',
        ]);
        
        $role = Role::create(['name' => $request->roleName,
    'guard_name' => 'web']);
        $role->permissions()->sync($request->permissions);
    
        return redirect()->route('settings')->with('success', 'Role created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $permissions = Permission::all();
        $role = Role::find($id);
        $rolePermissions = $role->permissions->pluck('id')->toArray();
        return view('role.edit', compact('role','permissions','rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'roleName' => 'required|string|max:255',
            'permissions' => 'array',
            'permissions.*' => 'integer|exists:permissions,id',
        ]);
    
        $role = Role::findOrFail($id);
        $role->name = $request->input('roleName');
        $role->save();
    
        $role->permissions()->sync($request->permissions);
    
    
        return redirect()->route('settings')->with('success', 'Role created successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $permission = Role::find($id);
        $permission->delete();
 
        return back()->with('success', 'Role deleted successfully.');
    }

    public function userUpdate(Request $request, string $id)
    {
        try {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users,email,' . $id,
                'password' => 'nullable|confirmed',
                'role' => 'required|array',
                'profile_picture' => 'nullable|image|max:2048', // Ensure the key matches
            ]);
    
            $user = User::findOrFail($id);
            $user->name = $request->name;
            $user->email = $request->email;
    
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
    
            if ($request->hasFile('profile_picture')) {
                // Save new profile picture
                $profilePicturePath = $request->file('profile_picture')->store('profile-photos', 'public');
                $user->profile_photo_path = $profilePicturePath;
            }
    
            $user->syncRoles($request->role);
            $user->save();
    
            return response()->json(['success' => 'User updated successfully.']);
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('User Update Failed:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to update user.'], 500);
        }
    }
}
