<?php
// database/migrations/2024_01_01_000003_create_collateral_register_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCollateralRegisterTable extends Migration
{
    public function up()
    {
        Schema::create('collateral_register', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_id')->constrained()->onDelete('cascade');
            $table->string('collateral_type');
            $table->string('description');
            $table->decimal('estimated_value', 15, 2);
            $table->string('location')->nullable();
            $table->string('condition')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('registration_number')->nullable();
            $table->date('acquisition_date')->nullable();
            $table->date('last_valuation_date')->nullable();
            $table->text('notes')->nullable();
            $table->string('status')->default('active'); // active, released, seized, sold
            $table->string('document_path')->nullable();
            $table->foreignId('created_by')->constrained('staff');
            $table->timestamps();

            $table->index(['loan_id', 'status']);
            $table->index('collateral_type');
        });
    }

    public function down()
    {
        Schema::dropIfExists('collateral_register');
    }
}
