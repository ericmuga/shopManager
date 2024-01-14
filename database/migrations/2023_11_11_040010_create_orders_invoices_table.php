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
        Schema::create('sales_header', function (Blueprint $table) {
            $table->id();
            $table->string('document_type')->default('order');
            $table->foreignIdFor(Customer::class);
            $table->string('document_no');
            $table->foreignIdFor(User::class);
            $table->date('posting_date');
            $table->string('status');
            $table->string('ext_doc_no');
            $table->string('tax_uuid');
            $table->timestamps();
        });

          Schema::create('sales_invoice_header', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Customer::class);
            $table->string('document_no');
            $table->string('order_no')->nullable();
            $table->string('quote_no')->nullable();
            $table->foreignIdFor(User::class);
            $table->date('posting_date');
            $table->string('status');
            $table->string('ext_doc_no');
            $table->string('tax_uuid');
            $table->foreignIdFor(CustomerEntry::class);
            $table->timestamps();
          });

           Schema::create('sales_shipment_header', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Customer::class);
            $table->string('document_no');
            $table->string('order_no')->nullable();
            $table->string('quote_no')->nullable();
            $table->foreignIdFor(User::class);
            $table->date('posting_date');
            $table->string('status');
            $table->string('ext_doc_no');
            $table->string('tax_uuid');
            $table->timestamps();
          });

        Schema::create('sales_cr_header', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Customer::class);
            $table->string('document_no');
            $table->string('order_no')->nullable();
            $table->string('quote_no')->nullable();
            $table->foreignIdFor(User::class);
            $table->date('posting_date');
            $table->string('status');
            $table->string('ext_doc_no');
            $table->string('tax_uuid');
            $table->string(CustomerEntry::class);
            $table->timestamps();
        });


// ----------------------------Purchase headers ------------------------------------------//
        Schema::create('purchase_header', function (Blueprint $table) {
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

         Schema::create('purchase_rct_header', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Vendor::class);
            $table->foreignIdFor(User::class);
            $table->date('posting_date');
            $table->string('document_no');;
            $table->string('order_no');
            $table->string('status');
            $table->string('ext_doc_no');
            $table->string('tax_uuid');
            $table->timestamps();
        });

          Schema::create('purchase_invoice_header', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Vendor::class);
            $table->string('document_no');
            $table->string('order_no')->nullable();
            $table->string('quote_no')->nullable();
            $table->foreignIdFor(User::class);
            $table->date('posting_date');
            $table->string('status');
            $table->string('ext_doc_no');
            $table->string('tax_uuid');
            $table->foreignIdFor(VendorEntry::class);
            $table->timestamps();
        });
         Schema::create('purchase_cr_header', function (Blueprint $table) {
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
        Schema::dropIfExists('sales_header');
        Schema::dropIfExists('sales_shipment_header');
        Schema::dropIfExists('sales_invoice_header');
        Schema::dropIfExists('sales_cr_header');

        Schema::dropIfExists('purchase_header');
        Schema::dropIfExists('purchase_rct_header');
        Schema::dropIfExists('purchase_invoice_header');
        Schema::dropIfExists('purchase_cr_header');
    }
};
