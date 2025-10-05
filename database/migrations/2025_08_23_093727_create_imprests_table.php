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
        Schema::create('imprests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id')->constrained('users');
            $table->string('name');
            $table->string('idCard');
            $table->string('price');
            $table->enum('loc', ['یکتاز', 'اوراسیا'])->default('یکتاز');
            $table->enum('status', ['No', 'Yes'])->default('Yes');
            $table->enum('accept', ['Pending', 'No', 'Yes'])->default('Pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imprests');
    }
};
