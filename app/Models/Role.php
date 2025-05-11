<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    // Ensure 'name' is in the $fillable property for mass assignment
    protected $fillable = ['name'];
   
}
