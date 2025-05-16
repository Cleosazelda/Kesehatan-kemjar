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
        Schema::create('rules', function (Blueprint $table) { 
            $table->id();
            $table->unsignedBigInteger('evidence_id');
            $table->unsignedBigInteger('hypothesis_id');
            $table->float('weight');
            $table->foreign('evidence_id')->references('id')->on('evidence')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('hypothesis_id')->references('id')->on('hypotheses')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rules');
    }
};
