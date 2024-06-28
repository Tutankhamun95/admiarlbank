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
        Schema::create('p_queue', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pstg_id');
            $table->string('q_type');
            $table->timestamps();
    
            $table->foreign('pstg_id')->references('id')->on('pstg')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('p_queue');
    }
};
