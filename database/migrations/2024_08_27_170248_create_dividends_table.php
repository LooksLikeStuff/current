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
        Schema::create('dividends', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('ticker_id')
                ->references('id')
                ->on('tickers')
                ->restrictOnUpdate()
                ->restrictOnDelete();

            $table->float('sum');
            $table->float('profit');

            $table->date('buy_date');
            $table->date('registry_date');
            $table->date('payment_date');
            $table->boolean('is_paid')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dividends');
    }
};
