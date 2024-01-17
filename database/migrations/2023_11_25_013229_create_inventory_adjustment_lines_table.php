<?php

use App\Models\InventoryAdjustmentHeader;
use App\Models\Item;
use App\Models\Location;
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
        Schema::create('inventory_adjustment_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(InventoryAdjustmentHeader::class);
            $table->foreignIdFor(Location::class);
            $table->foreignIdFor(Item::class);
            $table->float('unit_cost');
            $table->float('cost_amount');
            $table->float('sales_amount');



            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_adjustment_lines');
    }
};
