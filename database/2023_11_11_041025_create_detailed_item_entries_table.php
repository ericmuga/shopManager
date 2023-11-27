<?php

use App\Models\ItemEntry;
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
        Schema::create('detailed_item_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ItemEntry::class);
            $table->float('cost_amount');
            $table->float('sales_amount');
            $table->string('entry_type');
            $table->float('quantity');
            $table->date('posting_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detailed_item_entries');
    }
};
