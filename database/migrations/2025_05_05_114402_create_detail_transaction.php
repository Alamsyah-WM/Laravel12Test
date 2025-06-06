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
        Schema::create('detail_transaction', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('table_transaction_id')->constrained('table_transaction')->cascadeOnDelete();
            $table->foreignUuid('master_id')->constrained('master_items')->cascadeOnDelete();
            $table->string('item');
            $table->integer('quantity');            
            $table->string('itemunit');
            $table->text('note');         
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_transaction');
    }
};
