<?php

use App\Models\BusPostingGroup;
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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('id_no');
            $table->string('email')->nullable();
            $table->date('dob')->nullable();
            $table->string('guardian_id_no')->nullable();
            $table->string('phone_number');
            $table->string('address')->nullable();
            $table->string('physical_address')->nullable();
            $table->string('PIN')->nullable();
            $table->boolean('blocked')->default(false);
            $table->foreignIdFor(TaxPostingGroup::class);
            $table->foreignIdFor(BusPostingGroup::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
