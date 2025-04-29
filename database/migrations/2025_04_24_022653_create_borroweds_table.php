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
        Schema::create('borroweds', function (Blueprint $table) {
            $table->id('id_borrowed');
            $table->unsignedBigInteger('id_user');
            $table->dateTime('date_borrowed');
            $table->dateTime('due_date');
            $table->enum('status', ['approved', 'not approved']);
            $table->timestamps();

            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borroweds');
    }
};
