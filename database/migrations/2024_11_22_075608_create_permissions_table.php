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
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name');

            $table->foreignId('feature_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }

    // public function down(): void
    // {
    //     Schema::table('permissions', function (Blueprint $table) {
    //         $table->dropForeign(['feature_id']); // Drop the foreign key
    //     });

    //     Schema::dropIfExists('permissions');
    // }
};
