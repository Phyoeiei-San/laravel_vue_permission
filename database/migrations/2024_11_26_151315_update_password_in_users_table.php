<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('users')
        ->where('id', '<>', 1)
        ->update(['password' => bcrypt('office12')]); // Hash the default password
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         DB::table('users')
            ->where('id', '<>', 1)
            ->update(['password' => null]);
    }
};
