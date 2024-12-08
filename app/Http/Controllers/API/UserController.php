<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

// use Auth;

class UserController extends Controller
{
    public function loginUser(Request $request)
    {
        try {
            // Extract only 'email' and 'password' from the request
            $credentials = $request->only('email', 'password');

            // Attempt to authenticate using the provided credentials
            if (Auth::attempt($credentials)) {
                // Retrieve the authenticated user
                $user = Auth::user();

                // Create a personal access token for the authenticated user
                $token = $user->createToken('example')->accessToken;

                // Return a JSON response with the login success message, token, and user details
                return response()->json([
                    'message' => 'Login successful',
                    'token' => $token,
                    'user' => new UserResource($user),
                ], 200);
            } else {
                // Return a JSON response with an invalid credentials message
                return response()->json(['message' => 'Invalid credentials'], 401);
            }
        } catch (\Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Login Error: ', ['error' => $e->getMessage()]);

            // Return a JSON response indicating an internal server error
            return response()->json([
                'message' => 'An error occurred during login. Please try again later.'
            ], 500);
        }
    }


    public function userLogout()
    {
        try {
            // Check if the user is authenticated using the 'api' guard
            if (Auth::guard('api')->check()) {
                // Get the access token of the currently authenticated user
                $accessToken = Auth::guard('api')->user()->token();

                // Revoke the associated refresh tokens for this access token
                DB::table('oauth_refresh_tokens')
                    ->where('access_token_id', $accessToken->id)
                    ->update(['revoked' => true]);

                // Revoke the user's current access token
                $accessToken->revoke();

                // Return a success response indicating the user has been logged out
                return response()->json(['message' => 'User Logout Successfully'], 200);
            }

            // Return a response indicating the user is not authenticated
            return response()->json([
                'message' => 'User is not authenticated',
            ], 401);
        } catch (\Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Logout Error: ', ['error' => $e->getMessage()]);

            // Return a JSON response indicating an internal server error
            return response()->json([
                'message' => 'An error occurred during logout. Please try again later.'
            ], 500);
        }
    }


    // store User
    public function store(Request $request)
    {
        try {
            if (Auth::guard('api')->check()) {
                $validatedData = $request->validate([
                    'name'         => 'required|string|max:255',
                    'email'        => 'required|email|max:255',
                    'password'     => 'nullable|string',
                    'user_type'    => 'nullable|string',
                    'permissions'  => 'nullable|array',
                    'roles'        => 'nullable|array',
                ]);

                // Hash the password if provided
                if (!empty($validatedData['password'])) {
                    $validatedData['password'] = Hash::make($validatedData['password']);
                }

                $user = User::create($validatedData);

                return response()->json([
                    'message' => 'User created successfully',
                    'User' => new UserResource($user),
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

    // Get all User
    public function index()
    {
        try {
            if (Auth::guard('api')->check()) {
                $users = User::all();

                return response()->json([
                    'message' => 'Users retrieved successfully',
                    'Users' => UserResource::collection($users),
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

    // Showing a specific User 
    public function show(Request $request)
    {
        try {
            if (Auth::guard('api')->check()) {
                $user = User::find($request->id);

                if ($user) {
                    return response()->json([
                        'message'  => 'User retrieved successfully',
                        'User'     => new UserResource($user),
                    ], 200);
                }

                return response()->json([
                    'message' => 'User not found',
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

    // Update a specific User 
    public function update(Request $request)
    {
        try {
            if (Auth::guard('api')->check()) {
                $user = User::find($request->id);

                if ($user) {
                    $validatedData = $request->validate([
                        'name'         => 'nullable|string|max:255',
                        'email'        => 'nullable|string',
                        'status'       => 'nullable|in:Active,Inactive',
                        'permissions'  => 'nullable|string', // must be an array if provided
                        'roles'        => 'nullable|array',  // must be an array if provided
                    ]);

                    $user->update($validatedData);
                    return response()->json([
                        'message' => 'User updated successfully',
                        'User' => new UserResource($user),
                    ], 200);
                }

                return response()->json([
                    'message' => 'User not found',
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

    // Delete a specific User 
    public function delete(Request $request)
    {
        try {
            if (Auth::guard('api')->check()) {
                $user = User::find($request->id);

                if ($user) {
                    $user->delete();

                    return response()->json([
                        'message' => 'User deleted successfully',
                    ], 200);
                }

                return response()->json([
                    'message' => 'User not found',
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
