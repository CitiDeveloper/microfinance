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
        Schema::create('collection_sheet_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('collection_sheet_id')->constrained()->onDelete('cascade');
            $table->foreignId('loan_id')->constrained()->onDelete('cascade');
            $table->foreignId('borrower_id')->constrained()->onDelete('cascade');
            $table->foreignId('repayment_id')->nullable()->constrained()->onDelete('cascade');
            $table->decimal('expected_amount', 15, 2)->default(0);
            $table->decimal('collected_amount', 15, 2)->default(0);
            $table->enum('collection_status', ['pending', 'collected', 'partial', 'missed'])->default('pending');
            $table->date('collection_date');
            $table->text('notes')->nullable();
            $table->timestamps();

            // Indexes with custom shorter names
            $table->index(['collection_sheet_id', 'collection_status'], 'cs_items_sheet_status');
            $table->index(['loan_id', 'collection_date'], 'cs_items_loan_date');
            $table->index('borrower_id', 'cs_items_borrower');
            $table->index('repayment_id', 'cs_items_repayment');
            $table->index('collection_status', 'cs_items_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collection_sheet_items');
    }
};
