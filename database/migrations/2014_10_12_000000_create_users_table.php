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
        Schema::create('users', function (Blueprint $table) {
            $table->id('id_user');
            $table->enum('role', ['guru', 'siswa']);
            $table->string('name');
            $table->enum('class', ['X', 'XI', 'XII'])->nullable();
            $table->string('password');
            $table->enum('major', ['RPL', 'PSPT', 'ANIMASI', 'TJKT', 'TE'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
