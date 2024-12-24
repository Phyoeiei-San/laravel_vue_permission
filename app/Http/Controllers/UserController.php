<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $users = UserRole::with('roles')->get();
        return response()->json(['users' => $users], 200);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function roles()
    {
        $roles = Role::all();
        return response()->json(['roles' => $roles], 200);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email|unique:user_roles,email',
        'address' => 'nullable|string',
        'phone_no' => 'required|string|max:15',
        'role_id' => 'required|exists:roles,id',
    ]);


    $userRole = new UserRole();
    $userRole->name = $validated['name'];
    $userRole->email = $validated['email'];
    $userRole->address = $validated['address'] ?? null;
    $userRole->phone_no = $validated['phone_no'];
    $userRole->role_id = $validated['role_id'];
    $userRole->save();


    $user = new User();
    $user->name = $validated['name'];
    $user->email = $validated['email'];
    $user->role_id = $validated['role_id'];
    $user->password = $user->password ?? Hash::make('office12');
    $user->save();


    return response()->json(['message' => 'Staff and Staff Role created successfully'], 201);
}



    /**
     * Display the specified resource.
     */


    /**
     * Show the form for editing the specified resource.
     */
    public function show($id)
    {
        try {
            $user = UserRole::findOrFail($id);

            return response()->json([
                'success' => true,
                'user' => $user,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'User not found.',
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Find the user by ID
        $user = UserRole::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found.',
            ], 404);
        }


        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email' ,
            'address' => 'nullable|string|max:255',
            'phone_no' => 'required|string|max:15',
            'role_id' => 'required|exists:roles,id',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }


        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'address' => $request->input('address'),
            'phone_no' => $request->input('phone_no'),
            'role_id' => $request->input('role_id'),
        ]);


        return response()->json([
            'success' => true,
            'message' => 'User updated successfully!',
            'user' => $user,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $user = UserRole::findOrFail($id);
            $user->delete();

            return response()->json([
                'success' => true,
                'message' => 'User deleted successfully!',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'User not found.',
            ], 404);
        }
    }


public function getPermissions(Role $role)
{

    $permissions = $role->permissions()->select('permissions.id')->pluck('id');

    return response()->json(['permissions' => $permissions]);
}

public function search(Request $request)
{

    $searchKey = $request->input('key');
    $users = UserRole::with('roles')
                ->where('name', 'like', "%$searchKey%")
                ->orWhereHas('roles', function ($query) use ($searchKey) {
                    $query->where('name', 'like', "%$searchKey%");
                })
                 ->get();

    return response()->json(['users' => $users], 200);
}


}
