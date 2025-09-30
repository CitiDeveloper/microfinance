<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('system_settings', function (Blueprint $table) {
            $table->string('loan_id_prefix')->default('LN-'); // Prefix for loans
            $table->unsignedBigInteger('loan_id_sequence')->default(1); // Next sequence number
            $table->unsignedInteger('loan_id_padding')->default(5); // Zero-padding length e.g., LN-00001
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('system_settings', function (Blueprint $table) {
            //
        });
    }
};
