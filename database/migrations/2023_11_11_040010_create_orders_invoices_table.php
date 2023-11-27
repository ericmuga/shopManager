<?php

use App\Models\Customer;
use App\Models\CustomerEntry;
use App\Models\User;
use App\Models\Vendor;
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
        Schema::create('sales_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Customer::class);
            $table->string('document_no');
            $table->foreignIdFor(User::class);
            $table->date('posting_date');
            $table->string('status');
            $table->string('ext_doc_no');
            $table->string('tax_uuid');
            $table->timestamps();
        });

          Schema::create('sales_invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Customer::class);
            $table->string('document_no');
            $table->foreignIdFor(User::class);
            $table->date('posting_date');
            $table->string('status');
            $table->string('ext_doc_no');
            $table->string('tax_uuid');
            $table->foreignIdFor(CustomerEntry::class);
            $table->timestamps();
        });

        Schema::create('sales_cr_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Customer::class);
            $table->string('document_no');
            $table->foreignIdFor(User::class);
            $table->date('posting_date');
            $table->string('status');
            $table->string('ext_doc_no');
            $table->string('tax_uuid');
            $table->string(CustomerEntry::class);
            $table->timestamps();
        });

        Schema::create('purchases_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Vendor::class);
            $table->foreignIdFor(User::class);
            $table->date('posting_date');
            $table->string('document_no');
            $table->string('status');
            $table->string('ext_doc_no');
           $table->string('tax_uuid');
            $table->timestamps();
        });

          Schema::create('purchases_invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Vendor::class);
            $table->string('document_no');
            $table->foreignIdFor(User::class);
            $table->date('posting_date');
            $table->string('status');
            $table->string('ext_doc_no');
            $table->string('tax_uuid');
            $table->foreignIdFor(VendorEntry::class);
            $table->timestamps();
        });
         Schema::create('purchases_cr_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Vendor::class);
            $table->string('document_no');
            $table->foreignIdFor(User::class);
            $table->date('posting_date');
            $table->string('status');
            $table->string('ext_doc_no');
            $table->string('tax_uuid');
            $table->foreignIdFor(VendorEntry::class);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_orders');
        Schema::dropIfExists('purchase_orders');
        Schema::dropIfExists('sales_invoices');
        Schema::dropIfExists('purchase_invoices');
        Schema::dropIfExists('sales_cr_notes');
        Schema::dropIfExists('purchase_cr_notes');
    }
};
