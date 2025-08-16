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
        Schema::create('vams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id')->constrained('users');
            $table->string('name');
            $table->string('idCard');
            $table->foreignId('departmans_id')->constrained()->OnDelete('cascade');
            $table->foreignId('supervisors_id')->constrained()->OnDelete('cascade');
            $table->string('price');
            $table->text('descriptionUser')->nullable();
            $table->enum('resone', ['تحصیل', 'ازدواج', 'جهیزیه', 'درمان', 'تصادف', 'بیمه', 'فوت اقوام', 'مسکن', 'سایر'])->default('سایر');
            $table->enum('accept', ['No', 'Yes'])->default('No');
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
        Schema::dropIfExists('vams');
    }
};
