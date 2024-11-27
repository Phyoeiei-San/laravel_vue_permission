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
                'create' => $feature->id * 4 - 3, // Assign permission IDs dynamically
                'view' => $feature->id * 4 - 2,
                'update' => $feature->id * 4 - 1,
                'delete' => $feature->id * 4,
            ];
        });

        return response()->json(['rolefeatures' => $rolefeatures]);
    }
    // public function feature_permission()
    // {
    //     $features = Feature::with('permissions')->get();

    //     return response()->json(['features' => $features], 200);
    // }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }



    public function getModules(Request $request)
{
    // Check if the user is authenticated
    $user = $request->user();

    if (!$user) {
        return response()->json(['message' => 'Unauthenticated.'], 401);
    }

    if (!$user->role_id) {
        return response()->json(['message' => 'User does not have a role assigned.'], 400);
    }

    $userRoleId = $user->role_id;

    // Fetch permissions based on the user's role_id
    $permissions = RolePermission::where('role_id', $userRoleId)
        ->with('permission.feature') // Load the permission and its associated feature
        ->get()
        ->groupBy('permission.feature.name') // Group permissions by feature name
        ->map(function ($group) {
            return $group->pluck('permission.name'); // Extract permission names
        });

    $modules = $permissions->map(function ($permissions, $featureName) {
        return [
            'module_name' => $featureName,
            'permissions' => $permissions->toArray(),
        ];
    })->values();

    $roleName = $user->role ? $user->role->name : 'No Role Assigned'; // Retrieve role name

    return response()->json(
        ['modules' => $modules,
         'user' => $user,
         'role_name' => $roleName]);
}




    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'name' => 'required|string|max:255',

    //     ]);

    //     // Create user
    //     $user = new Feature();
    //     $user->name = $validated['name'];

    //     $user->save();

    //     return response()->json(['message' => 'Module created successfully'], 201);
    // }
    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
    ]);

    // Create the new feature
    $feature = new Feature();
    $feature->name = $validated['name'];
    $feature->save();

    // Create the permissions associated with the feature
    $permissions = [
        'Create', 'View', 'Update', 'Delete'
    ];

    foreach ($permissions as $permission) {
        // Create each permission
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
