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
        Schema::table('maadirans', function (Blueprint $table) {
            $table->dropColumn('descriptionManager1');
            $table->dropColumn('validationManager1');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('maadirans', function (Blueprint $table) {
            //
        });
    }
};
