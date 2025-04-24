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
        Schema::create('details_borrows', function (Blueprint $table) {
            $table->id('id_details_borrow');
            $table->unsignedBigInteger('id_items');
            $table->unsignedBigInteger('id_borrowed');
            $table->integer('amount');
            $table->timestamps();

            $table->foreign('id_items')->references('id_items')->on('items')->onDelete('cascade');
            $table->foreign('id_borrowed')->references('id_borrowed')->on('borroweds')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('details_borrows');
    }
};
