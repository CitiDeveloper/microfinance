<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('repayment_durations', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('months')->comment('Repayment duration in months'); // 1–360
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('repayment_durations');
    }
};
