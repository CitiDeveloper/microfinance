<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChartOfAccountsTable extends Migration
{
    public function up()
    {
        Schema::create('chart_of_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_type_id')->constrained();
            $table->foreignId('parent_id')->nullable()->constrained('chart_of_accounts');
            $table->string('code')->unique();
            $table->string('name');
            $table->enum('normal_balance', ['debit', 'credit']);
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_system_account')->default(false);
            $table->timestamps();

            $table->index(['code', 'is_active']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('chart_of_accounts');
    }
}
