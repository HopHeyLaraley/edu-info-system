<?php

use App\Models\Role;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('role')->unique();
            $table->timestamps();
        });

        // Role::create([
        //     'role'=>'user',
        // ]);
        // Role::create([
        //     'role'=>'admin',
        // ]);

        // Role::create([
        //     'role'=>'teacher',
        // ]);

        // Role::create([
        //     'role'=>'student',
        // ]);

        // Role::create([
        //     'role'=>'parent',
        // ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
