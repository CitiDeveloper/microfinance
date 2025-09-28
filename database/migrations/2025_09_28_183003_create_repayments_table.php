<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('repayments', function (Blueprint $table) {
            $table->id();

            // relations
            $table->foreignId('loan_id')->constrained('loans')->onDelete('cascade');
            $table->foreignId('borrower_id')->constrained('borrowers')->onDelete('cascade');
            $table->foreignId('branch_id')->constrained('branches')->onDelete('cascade');

            // who collected / posted the payment (staff)
            $table->foreignId('collected_by')->nullable()->constrained('staff')->nullOnDelete();

            // repayment metadata
            $table->integer('repayment_number')->nullable()->comment('Which installment number (1..N) where applicable');
            $table->decimal('amount', 15, 2)->comment('Total amount paid');
            $table->decimal('principal_paid', 15, 2)->default(0);
            $table->decimal('interest_paid', 15, 2)->default(0);
            $table->decimal('fees_paid', 15, 2)->default(0);
            $table->decimal('penalty_paid', 15, 2)->default(0);
            $table->decimal('waiver_amount', 15, 2)->default(0);

            // bookkeeping & reference
            $table->date('payment_date')->nullable()->comment('Date customer made payment');
            $table->dateTime('posted_at')->nullable()->comment('When finance posted the payment');
            $table->string('receipt_number')->nullable()->index();
            $table->string('transaction_reference')->nullable()->unique();
            $table->foreignId('payment_method_id')->nullable()->constrained('payment_methods')->nullOnDelete();
            $table->foreignId('dea_cash_bank_account')->nullable()->constrained('bank_accounts')->nullOnDelete();

            // balances & fx
            $table->decimal('outstanding_balance', 15, 2)->nullable()->comment('Balance after this payment');
            $table->decimal('exchange_rate', 18, 8)->nullable()->comment('If cross-currency');

            // status & reconciliation
            $table->enum('status', ['pending', 'posted', 'failed', 'reversed'])->default('pending');
            $table->boolean('is_reconciled')->default(false);

            // reversal audit
            $table->foreignId('reversed_by')->nullable()->constrained('staff')->nullOnDelete();
            $table->timestamp('reversed_at')->nullable();
            $table->text('reversal_reason')->nullable();

            // misc
            $table->text('notes')->nullable();
            $table->json('metadata')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // helpful indexes
            $table->index(['loan_id', 'borrower_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('repayments');
    }
};
