<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('guarantors', function (Blueprint $table) {
            $table->id();

            // Personal Information
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('business_name')->nullable();
            $table->string('unique_number')->nullable();
            $table->enum('gender', ['Male', 'Female', 'Nonbinary', 'Other', 'Decline to state'])->nullable();
            $table->enum('title', ['Mr.', 'Mrs.', 'Miss', 'Ms.', 'Dr.', 'Prof.', 'Rev.'])->nullable();
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->date('date_of_birth')->nullable();

            // Address Information
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('landline')->nullable();

            // Employment Information
            $table->enum('working_status', [
                'Employee',
                'Government Employee',
                'Private Sector Employee',
                'Owner',
                'Student',
                'Overseas Worker',
                'Pensioner',
                'Unemployed'
            ])->nullable();

            // Media and Additional Info
            $table->string('photo')->nullable();
            $table->text('description')->nullable();
            $table->json('files')->nullable();

            // Relationships and Metadata
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('branch_id')->constrained()->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index(['first_name', 'last_name']);
            $table->index('business_name');
            $table->index('unique_number');
            $table->index('branch_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('guarantors');
    }
};
