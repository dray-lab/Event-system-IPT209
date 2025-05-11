<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserStatus;

class UserStatusSeeder extends Seeder
{
    public function run()
    {
        UserStatus::create(['name' => 'Active']);
        UserStatus::create(['name' => 'Inactive']);
        // Add more statuses as needed
    }
}
