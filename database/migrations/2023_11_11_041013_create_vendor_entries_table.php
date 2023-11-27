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
        Schema::create('vendor_entries', function (Blueprint $table) {
            $table->id();
            $table->morphs('documentable');
            $table->date('posting_date');
            $table->foreignIdFor(User::class);
            $table->string('ext_doc_no');
            $table->string('tax_uuid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_entries');
    }
};
