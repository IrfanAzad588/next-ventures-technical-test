<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Http\Resources\RoleResource;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    // store Role
    public function store(Request $request)
    {
        try {
            if (Auth::guard('api')->check()) {
                $validatedData = $request->validate([
                    'name'         => 'required|string|max:255',
                    'details'      => 'nullable|string',
                    'status'       => 'nullable|in:Active,Inactive',
                    'permissions'  => 'nullable|array',  // must be an array if provided
                ]);

                $role = Role::create($validatedData);

                return response()->json([
                    'message' => 'Role created successfully',
                    'Role' => new RoleResource($role),
                ], 201);
            }

            return response()->json([
                'message' => 'User is not authenticated',
            ], 401);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }

    // Get all Role
    public function index()
    {
        try {
            if (Auth::guard('api')->check()) {
                $roles = Role::all();

                return response()->json([
                    'message' => 'Roles retrieved successfully',
                    'Roles' => RoleResource::collection($roles),
                ], 200);
            }

            return response()->json([
                'message' => 'User is not authenticated',
            ], 401);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }

    // Showing a specific Role 
    public function show(Request $request)
    {
        try {
            if (Auth::guard('api')->check()) {
                $role = Role::find($request->id);

                if ($role) {
                    return response()->json([
                        'message'  => 'Role retrieved successfully',
                        'Role'     => new RoleResource($role),
                    ], 200);
                }

                return response()->json([
                    'message' => 'Role not found',
                ], 404);
            }

            return response()->json([
                'message' => 'User is not authenticated',
            ], 401);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }

    // Update a specific Role 
    public function update(Request $request)
    {
        try {
            if (Auth::guard('api')->check()) {
                $role = Role::find($request->id);

                if ($role) {
                    $validatedData = $request->validate([
                        'name'         => 'nullable|string|max:255',
                        'details'      => 'nullable|string',
                        'status'       => 'nullable|in:Active,Inactive',
                        'permissions'  => 'nullable|string',
                    ]);

                    $role->update($validatedData);
                    return response()->json([
                        'message' => 'Role updated successfully',
                        'Role' => new RoleResource($role),
                    ], 200);
                }

                return response()->json([
                    'message' => 'Role not found',
                ], 404);
            }

            return response()->json([
                'message' => 'User is not authenticated',
            ], 401);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }

    // Delete a specific Role 
    public function delete(Request $request)
    {
        try {
            if (Auth::guard('api')->check()) {
                $role = Role::find($request->id);

                if ($role) {
                    $role->delete();

                    return response()->json([
                        'message' => 'Role deleted successfully',
                    ], 200);
                }

                return response()->json([
                    'message' => 'Role not found',
                ], 404);
            }

            return response()->json([
                'message' => 'User is not authenticated',
            ], 401);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }
}
