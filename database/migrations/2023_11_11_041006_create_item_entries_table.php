<?php

use App\Models\Item;
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
        Schema::create('item_entries', function (Blueprint $table) {
            $table->id();
            $table->string('entry_type');
            $table->date('posting_date');
            $table->foreignIdFor(Item::class);
            $table->string('document_no');
            $table->string('ext_doc_no');
            $table->morphs('documentable');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_entries');
    }
};
