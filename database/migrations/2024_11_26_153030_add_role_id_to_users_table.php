<?php

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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('role_id')
                  ->after('password') // Position the column after 'password'
                  ->nullable() // Allow null values initially, if needed
                  ->constrained('roles') // Link to the 'id' column in 'roles' table
                  ->cascadeOnDelete(); // Ensure cascading deletes if the role is deleted
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']); // Drop the foreign key constraint
            $table->dropColumn('role_id'); // Drop the column
        });
    }
};
