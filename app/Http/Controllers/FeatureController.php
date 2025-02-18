<?php

namespace App\Http\Controllers;

use App\Models\Feature;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Models\RolePermission;

class FeatureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $features = Feature::all();
        return response()->json(['features' => $features], 200);
    }
    public function role_feature()
    {
        $features = Feature::all(['id', 'name']);
        $rolefeatures = $features->map(function ($feature) {
            return [
                'name' => $feature->name,
                'create' => $feature->id * 4 - 3,
                'view' => $feature->id * 4 - 2,
                'update' => $feature->id * 4 - 1,
                'delete' => $feature->id * 4,
            ];
        });

        return response()->json(['rolefeatures' => $rolefeatures]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }



    public function getModules(Request $request)
{

    $user = $request->user();

    if (!$user) {
        return response()->json(['message' => 'Unauthenticated.'], 401);
    }

    if (!$user->role_id) {
        return response()->json(['message' => 'User does not have a role assigned.'], 400);
    }

    $userRoleId = $user->role_id;


    $permissions = RolePermission::where('role_id', $userRoleId)
        ->with('permission.feature')
        ->get()
        ->groupBy('permission.feature.name')
        ->map(function ($group) {
            return $group->pluck('permission.name');
        });

    $modules = $permissions->map(function ($permissions, $featureName) {
        return [
            'module_name' => $featureName,
            'permissions' => $permissions->toArray(),
        ];
    })->values();

    $roleName = $user->role ? $user->role->name : 'No Role Assigned';

    return response()->json(
        ['modules' => $modules,
         'user' => $user,
         'role_name' => $roleName]);
}



    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|unique:features,name|max:255',
    ]);


    $feature = new Feature();
    $feature->name = $validated['name'];
    $feature->save();


    $permissions = [
        'Create', 'View', 'Update', 'Delete'
    ];

    foreach ($permissions as $permission) {

        $feature->permissions()->create([
            'name' => $permission,
        ]);
    }

    return response()->json(['message' => 'Module created successfully, with permissions'], 201);
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
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        try {
            $feature = Feature::findOrFail($id);
            $feature->update([
                'name' => $request->name,
            ]);

            return response()->json([
                'message' => 'Feature updated successfully!',
                'feature' => $feature,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update feature.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $feature = Feature::findOrFail($id);
            $feature->delete();

            return response()->json([
                'message' => 'Feature deleted successfully!',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete feature.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

}
