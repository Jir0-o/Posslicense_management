<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function __construct(){
    //     $this->middleware('permission:View Assign Task',['only'=>['index']]);
    //     $this->middleware('permission:Create Assign task',['only'=>['create']]);
    //     $this->middleware('permission:Edit Assign Task',['only'=>['edit']]);
    //     $this->middleware('permission:Delete Assign Task',['only'=>['destroy']]);
    //     $this->middleware('permission:Change Status',['only'=>['incomplete','completed','requested','pendingdate']]);

    // }
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('permission.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $permission = Permission::create(['name' => $request->permissionName,
    'guard_name' => 'web']);
        return redirect()->route('settings')->with('success', 'Permission Created successfully.');
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
        $permission= Permission::find($id);
        return view('permission.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'permissionName' => 'required',
        ]);
    

        $permission = Permission::find($id);

        $permission->name = $request->permissionName;
        $permission->save();
        return redirect()->route('settings')->with('success', 'Permission Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $permission = Permission::find($id);
        $permission->delete();
 
        return back()->with('success', 'Permission deleted successfully.');
    }
}
