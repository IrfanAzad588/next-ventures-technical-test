<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Permission;
use App\Http\Resources\PermissionResource;
use Illuminate\Support\Facades\Auth;

class PermissionController extends Controller
{
    // store permission
    public function store(Request $request)
    {
        try {
            if (Auth::guard('api')->check()) {
                $validatedData = $request->validate([
                    'name' => 'required|string|max:255',
                    'details' => 'nullable|string',
                    'status' => 'nullable|in:Active,Inactive',
                ]);

                $permission = Permission::create($validatedData);

                return response()->json([
                    'message' => 'Permission created successfully',
                    'permission' => new PermissionResource($permission),
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

    // Get all permission
    public function index()
    {
        try {
            if (Auth::guard('api')->check()) {
                $permissions = Permission::all();

                return response()->json([
                    'message' => 'Permissions retrieved successfully',
                    'permissions' => PermissionResource::collection($permissions),
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
    // Showing a specific permission 
    public function show(Request $request)
    {
        try {
            if (Auth::guard('api')->check()) {
                $permission = Permission::find($request->id);

                if ($permission) {
                    return response()->json([
                        'message' => 'Permission retrieved successfully',
                        'permission' => new PermissionResource($permission),
                    ], 200);
                }

                return response()->json([
                    'message' => 'Permission not found',
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

    // Update a specific permission 
    public function update(Request $request)
    {
        try {
            if (Auth::guard('api')->check()) {
                $permission = Permission::find($request->id);

                if ($permission) {
                    $validatedData = $request->validate([
                        'name' => 'nullable|string|max:255',
                        'details' => 'nullable|string',
                        'status' => 'nullable|in:Active,Inactive',
                    ]);

                    $permission->update($validatedData);

                    return response()->json([
                        'message' => 'Permission updated successfully',
                        'permission' => new PermissionResource($permission),
                    ], 200);
                }

                return response()->json([
                    'message' => 'Permission not found',
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

    // Delete a specific permission 
    public function delete(Request $request)
    {
        try {
            if (Auth::guard('api')->check()) {
                $permission = Permission::find($request->id);

                if ($permission) {
                    $permission->delete();

                    return response()->json([
                        'message' => 'Permission deleted successfully',
                    ], 200);
                }

                return response()->json([
                    'message' => 'Permission not found',
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
