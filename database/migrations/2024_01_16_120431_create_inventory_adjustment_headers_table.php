<?php

use App\Models\User;
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
        Schema::create('inventory_adjustment_headers', function (Blueprint $table) {
            $table->id();
             $table->string('status');
            $table->foreignIdFor(User::class);
            $table->string('entry_type');
            $table->date('posting_date');
            $table->string('document_no');
            $table->string('ext_doc_no');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_adjustment_headers');
    }
};
