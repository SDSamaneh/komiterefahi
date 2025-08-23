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
            $table->enum('status', ['Pending', 'No', 'Yes'])->default('Pending');
            $table->string('memberDate')->nullable();
            $table->string('memberPrice')->nullable();
            $table->string('lastSalary')->nullable();
            $table->string('debt_company')->nullable();
            $table->string('debt_madiran')->nullable();
            $table->string('debt_fund')->nullable();
            $table->string('debt_purchase')->nullable();
            $table->string('validationDate')->nullable();
            $table->text('descriptionHr')->nullable();
            $table->enum('validationHr', ['Pending', 'No', 'Yes'])->default('Pending');
            $table->enum('validation_managerHr', ['Pending', 'No', 'Yes'])->default('Pending');
            $table->text('descriptionManager1')->nullable();
            $table->enum('validationManager1', ['Pending', 'No', 'Yes'])->default('Pending');
            $table->string('finalPrice')->nullable()->default(null);
            $table->text('descriptionManager2')->nullable();
            $table->enum('validationManager2', ['Pending', 'No', 'Yes'])->default('Pending');
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
