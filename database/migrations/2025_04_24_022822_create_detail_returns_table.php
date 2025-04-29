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
        Schema::create('detail_returns', function (Blueprint $table) {
            $table->id('id_detail_return');
            $table->foreignId('id_details_borrow')->constrained('details_borrows', 'id_details_borrow')->onDelete('cascade');
            $table->dateTime('date_return');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_returns');
    }
};
