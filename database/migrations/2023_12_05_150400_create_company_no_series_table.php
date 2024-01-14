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
        Schema::create('no_series', function (Blueprint $table) {
            $table->id();
            $table->string('series_code');
            $table->string('type');
            $table->date('last_date_used');
            $table->bigInteger('last_no_used');
            $table->tinyInteger('characters');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('no_series');
    }
};
