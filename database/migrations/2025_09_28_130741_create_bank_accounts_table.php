<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('coa_code', 4)->unique(); // still storing the 4-digit code
            $table->string('coa_name');
            $table->json('coa_default_categories')->nullable();
            $table->json('access_branches'); // multiple branch IDs
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bank_accounts');
    }
};
