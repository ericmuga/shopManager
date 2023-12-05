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
        Schema::create('company_setup', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('postal_address');
            $table->string('phone');
            $table->string('email');
            $table->string('pin');
            $table->string('bank_name');
            $table->string('account_no');
            $table->string('branch_name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_setup');
    }
};
