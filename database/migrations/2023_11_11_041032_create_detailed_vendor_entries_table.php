<?php

use App\Models\CustomerEntry;
use App\Models\VendorEntry;
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
        Schema::create('detailed_vendor_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(VendorEntry::class);
            $table->string('entry_type');
            $table->string('document_no');
            $table->string('ext_doc_no');
            $table->float('amount');
            $table->date('posting_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detailed_vendor_entries');
    }
};
