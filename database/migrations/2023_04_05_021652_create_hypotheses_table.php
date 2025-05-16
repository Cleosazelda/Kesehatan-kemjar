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
        Schema::create('hypotheses', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->text('description');
            $table->text('solution');
            // $table->text('image');
            $table->timestamps();
        });
    } 

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the foreign key from `hypothesis_images` table
        Schema::table('hypothesis_images', function (Blueprint $table) {
            $table->dropForeign(['hypothesis_id']);
        });

        Schema::dropIfExists('hypotheses');
    }
};
