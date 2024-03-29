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
        Schema::create('tax_posting_setups', function (Blueprint $table) {
            $table->id();
            $table->string('item_tax_group_id');
            $table->string('bus_tax_group_id');
            $table->string('tax_identifier')->unique();
            $table->float('tax_rate',2,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tax_posting_setups');
    }
};
