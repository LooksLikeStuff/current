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
        Schema::table('tickers', function (Blueprint $table) {
            $table->foreignId('company_id')
                ->after('name')
                ->nullable()
                ->references('id')
                ->on('companies')
                ->restrictOnDelete()
                ->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickers', function (Blueprint $table) {
            $table->dropForeign('tickers_company_id_foreign');
            $table->dropColumn('company_id');
        });
    }
};
