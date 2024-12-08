<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;


// use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'roles',
        'permissions',
        'user_type',


    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    // Define how the attributes should be cast when retrieved or saved
    protected $casts = [
        'email_verified_at' => 'datetime',  // Automatically cast 'email_verified_at' to a datetime object
        'password'          => 'hashed',    // Automatically hash the 'password' field when saving or retrieving
        "permissions"       => "array",     // Cast the 'permissions' field to an array
        "roles"             => "array",     // Cast the 'roles' field to an array
    ];

    // Method to retrieve a list of permissions based on the provided permission IDs
    public function permissionList($permission_arr = null)
    {
        // If no specific permission array is provided, use the 'permissions' attribute
        if (empty($permission_arr)) {
            $permission_arr = $this->permissions;
        }

        // Check if the permission array is valid and contains items
        if (is_array($permission_arr) && count($permission_arr) > 0) {
            // Retrieve all Permission models where the IDs match the given array
            return Permission::whereIn('id', $permission_arr)->get();
        }

        // Return an empty array if no valid permissions are found
        return [];
    }

    // Method to retrieve a list of roles based on the provided role IDs
    public function roleList($role_arr = null)
    {
        // If no specific role array is provided, use the 'roles' attribute
        if (empty($role_arr)) {
            $role_arr = $this->roles;
        }

        // Check if the role array is valid and contains items
        if (is_array($role_arr) && count($role_arr) > 0) {
            // Retrieve all Role models where the IDs match the given array
            return Role::whereIn('id', $role_arr)->get();
        }
        // Return an empty array if no valid roles are found
        return [];
    }
}
