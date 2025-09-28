<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('loan_payment_schemes', function (Blueprint $table) {
            $table->id();
            $table->string('name');         // e.g., Daily, Weekly, Monthly, etc.
            $table->unsignedInteger('code'); // your provided values (6, 4, 9, etc.)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loan_payment_schemes');
    }
};
