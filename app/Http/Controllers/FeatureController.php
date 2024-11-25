<?php

namespace App\Http\Controllers;

use App\Models\Feature;
use Illuminate\Http\Request;

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
        $modules = $features->map(function ($feature) {
            return [
                'name' => $feature->name,
                'create' => $feature->id * 4 - 3, // Assign permission IDs dynamically
                'view' => $feature->id * 4 - 2,
                'update' => $feature->id * 4 - 1,
                'delete' => $feature->id * 4,
            ];
        });

        return response()->json(['modules' => $modules]);
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
