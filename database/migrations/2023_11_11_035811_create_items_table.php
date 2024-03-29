<?php

use App\Models\ItemPostingGroup;
use App\Models\TaxPostingGroup;
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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('type')->index();
            $table->string('code')->unique();
            $table->string('barcode')->unique()->nullable();
            $table->string('description');
            $table->string('base_uom');
            $table->string('sales_uom');
            $table->string('unit_cost');
            $table->string('unit_price');
            $table->boolean('blocked');
            $table->foreignIdFor(TaxPostingGroup::class);

            $table->foreignIdFor(ItemPostingGroup::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
