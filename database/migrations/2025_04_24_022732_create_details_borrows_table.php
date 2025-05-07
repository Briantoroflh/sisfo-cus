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
            $table->unsignedBigInteger('id_items'); // Ensure this is unsignedBigInteger
            $table->integer('amount');
            $table->string('used_for');
            $table->string('class');
            $table->dateTime('date_borrowed');
            $table->dateTime('due_date');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('id_items')
                ->references('id_items')
                ->on('items')
                ->onDelete('cascade');

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
