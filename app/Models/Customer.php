<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    // Optionally, define the table if it differs from the default (customers)
    // protected $table = 'your_table_name'; 

    // Define the fillable attributes
    protected $fillable = ['first_name', 'middle_name', 'last_name', 'email', 'phone', 'address'];

    // Add any relationships you need. For example, if you have relationships with other models:
    
    public function orders() {
        return $this->hasMany(Order::class);  // Assuming a customer can have many orders
    }

    // You can add more relationships here, similar to how 'course', 'yearLevel', and 'section' are added for 'Student'
}
