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
        Schema::create('items', function (Blueprint $table) {
            $table->id('id_items');
            $table->string('item_name');
            $table->string('item_image')->nullable();
            $table->string('code_items')->unique();
            $table->unsignedBigInteger('id_category');
            $table->integer('stock');
            $table->string('brand')->nullable();
            $table->enum('status', ['used', 'unused'])->default('unused');
            $table->enum('item_condition', ['good', 'broken'])->default('good');
            $table->timestamps();

            $table->foreign('id_category')->references('id_category')->on('category_items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
