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
        Schema::create('hypothesis_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hypothesis_id'); // Foreign key ke tabel hypotheses
            $table->string('image_path'); // Menyimpan nama gambar
            $table->timestamps();

            // Relasi ke tabel hypotheses
            $table->foreign('hypothesis_id')->references('id')->on('hypotheses')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {


        // Drop the `hypotheses` table
        Schema::dropIfExists('hypothesis_images');
    }
};
