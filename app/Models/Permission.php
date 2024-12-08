<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    // Define how the attributes should be cast when retrieved or saved
    protected $fillable = [
        'name',
        'details',
        'permissions',
        'status',
    ];
}
