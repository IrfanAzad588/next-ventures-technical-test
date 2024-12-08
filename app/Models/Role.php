<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    // Define how the attributes should be cast when retrieved or saved
    protected $fillable = [
        'name',
        'details',
        'permissions',
        'status',
    ];
    
    // Define how the attributes should be cast when retrieved or saved
    protected $casts = [
        "permissions" => "array", // Automatically cast the 'permissions' field to an array
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
}
