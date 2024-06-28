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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('from_account_id')->nullable();
            $table->string('to_account_id')->nullable();
            $table->decimal('amount', 15, 2);
            $table->timestamps();

            $table->foreign('from_account_id')->references('account_number')->on('accounts')->onDelete('cascade');
            $table->foreign('to_account_id')->references('account_number')->on('accounts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
