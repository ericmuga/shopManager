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
        Schema::table('customers', function (Blueprint $table) {
            //
            $table->boolean('blocked')->default(false)->nullable();
        });
        Schema::table('vendors', function (Blueprint $table) {
            //
            $table->boolean('blocked')->default(false)->nullable();
        });
        Schema::table('item_posting_groups', function (Blueprint $table) {
            //
            $table->boolean('blocked')->default(false)->nullable();
        });
        Schema::table('tax_posting_groups', function (Blueprint $table) {
            //
            $table->boolean('blocked')->default(false)->nullable();
        });
         Schema::table('items', function (Blueprint $table) {
            //
            $table->boolean('blocked')->default(false)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('master_tables', function (Blueprint $table) {
            //
        });
    }
};
