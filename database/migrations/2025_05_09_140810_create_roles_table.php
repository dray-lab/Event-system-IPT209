<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        // Roles to be inserted
        $roles = [
            ['name' => 'Admin'],
            ['name' => 'Organizer'],
            ['name' => 'User'],
        ];

        // Corrected foreach loop with $role
        foreach ($roles as $role) {
            Role::create($role);  // Inserts roles into the database
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
