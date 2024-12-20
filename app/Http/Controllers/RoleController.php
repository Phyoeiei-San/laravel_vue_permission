<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Feature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();
        return response()->json(['roles' => $roles], 200);
    }

    public function feature()
    {
        $features = Feature::all();
        return response()->json(['features' => $features], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|unique:roles,name',
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,id',
        ]);


        $role = Role::create([
            'name' => $request->name,
        ]);


        $role->permissions()->attach($request->permissions);

        
        return response()->json(['message' => 'Role created successfully!'], 201);
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function getPermissions(Role $role)
{
    return response()->json(['permissions' => $role->permissions]);
}



public function updatePermissions(Request $request, Role $role)
{
    $request->validate([
        'permissions' => 'array',
        'permissions.*' => 'exists:permissions,id',
    ]);

    $role->permissions()->sync($request->permissions);
    return response()->json(['message' => 'Permissions updated successfully!']);
}


}
