<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('savings_products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->text('description')->nullable();
            $table->decimal('interest_rate', 5, 2)->default(0);
            $table->string('interest_calculation')->nullable();
            $table->decimal('minimum_deposit', 15, 2)->default(0);
            $table->decimal('maximum_deposit', 15, 2)->nullable();
            $table->decimal('minimum_balance', 15, 2)->default(0);
            $table->boolean('allow_withdrawals')->default(true);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('savings_products');
    }
};
