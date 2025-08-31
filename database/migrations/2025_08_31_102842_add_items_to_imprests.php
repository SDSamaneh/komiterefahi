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
        Schema::table('imprests', function (Blueprint $table) {
            $table->string('finalPrice')->nullable()->default(null);
            $table->text('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('imprests', function (Blueprint $table) {
            Schema::dropIfExists('imprests');
        });
    }
};
