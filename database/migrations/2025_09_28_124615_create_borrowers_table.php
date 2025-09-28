<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_borrowers_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBorrowersTable extends Migration
{
    public function up()
    {
        Schema::create('borrowers', function (Blueprint $table) {
            $table->id();
            $table->string('county')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('business_name')->nullable();
            $table->string('unique_number')->unique()->nullable();
            $table->enum('gender', ['Male', 'Female', 'Nonbinary', 'Other', 'Decline to state'])->nullable();
            $table->enum('title', ['Mr.', 'Mrs.', 'Miss', 'Ms.', 'Dr.', 'Prof.', 'Rev.'])->nullable();
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('landline')->nullable();
            $table->enum('working_status', [
                'Employee',
                'Government Employee',
                'Private Sector Employee',
                'Owner',
                'Student',
                'Business Person',
                'Pensioner',
                'Pensioner',
                'Unemployed'
            ])->nullable();
            $table->integer('credit_score')->nullable();
            $table->string('photo')->nullable();
            $table->text('description')->nullable();
            $table->json('files')->nullable();
            $table->json('loan_officer_access')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('borrowers');
    }
}
