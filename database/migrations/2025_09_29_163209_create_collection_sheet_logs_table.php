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
        Schema::create('collection_sheet_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('collection_sheet_id')->constrained()->onDelete('cascade');
            $table->string('action', 100);
            $table->text('details')->nullable();
            $table->foreignId('performed_by')->constrained('users')->onDelete('cascade');
            $table->timestamp('performed_at');
            $table->json('old_data')->nullable();
            $table->json('new_data')->nullable();

            // Indexes with custom shorter names
            $table->index('collection_sheet_id', 'cs_logs_sheet');
            $table->index('action', 'cs_logs_action');
            $table->index('performed_by', 'cs_logs_performer');
            $table->index('performed_at', 'cs_logs_time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collection_sheet_logs');
    }
};
