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
        Schema::table('items', function (Blueprint $table) {

         $table->unsignedBigInteger('tax_group_id')->index();

        });


        Schema::table('customers', function (Blueprint $table) {

         $table->unsignedBigInteger('tax_posting_group_id')->index();
         $table->unsignedBigInteger('bus_posting_group_id')->index();

        });
         Schema::table('vendors', function (Blueprint $table) {

         $table->unsignedBigInteger('tax_posting_group_id')->index();
         $table->unsignedBigInteger('bus_posting_group_id')->index();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {


    }
};
