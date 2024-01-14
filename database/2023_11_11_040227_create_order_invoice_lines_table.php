<?php

use App\Models\Item;
use App\Models\ItemEntry;
use App\Models\Location;
use App\Models\PurchaseCrNote;
use App\Models\PurchaseOrder;
use App\Models\SalesInvoice;
use App\Models\PurchaseInvoice;
use App\Models\PurchaseReceipt;
use App\Models\SalesCrNote;
use App\Models\SalesOrder;
use App\Models\SalesShipment;
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

        Schema::create('sales_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Item::class);
            $table->string('document_type')->default('order');
            $table->float('unit_price');
            $table->string('document_no');
            $table->string('ext_doc_no');
            $table->float('quantity');
            $table->string('uom')->nullable();
            $table->string('item_tax_group');
            $table->string('customer_tax_group');
            $table->string('item_posting_group');
            $table->string('customer_posting_group');
            $table->float('vat_percent');
            $table->float('amount');
            $table->float('amount_inc_vat');
            $table->foreignIdFor(SalesOrder::class);
            $table->foreignIdFor(Location::class);
            $table->timestamps();
        });


         Schema::create('sales_invoice_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Item::class);
            $table->float('unit_price');
             $table->string('document_no');
            $table->string('ext_doc_no');
            $table->float('quantity');
            $table->string('uom')->nullable();
            $table->string('item_tax_group');
            $table->string('customer_tax_group');
            $table->string('item_posting_group');
            $table->string('customer_posting_group');
            $table->float('vat_percent');
            $table->float('amount');
            $table->float('amount_inc_vat');
            $table->foreignIdFor(SalesInvoice::class);
            $table->foreignIdFor(ItemEntry::class);
            $table->foreignIdFor(Location::class);
            $table->timestamps();
        });

        Schema::create('sales_shipment_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Item::class);
            $table->float('unit_price');
            $table->string('document_no');
            $table->string('ext_doc_no');
            $table->float('quantity');
            $table->string('uom')->nullable();
            $table->string('item_tax_group');
            $table->string('customer_tax_group');
            $table->string('item_posting_group');
            $table->string('customer_posting_group');
            $table->float('vat_percent');
            $table->float('amount');
            $table->float('amount_inc_vat');
            $table->foreignIdFor(SalesShipment::class);
            $table->foreignIdFor(ItemEntry::class);
            $table->foreignIdFor(Location::class);
            $table->timestamps();
        });


        Schema::create('sales_cr_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Item::class);
            $table->float('unit_price');
            $table->string('document_no');
            $table->string('ext_doc_no');
            $table->float('quantity');
            $table->string('uom')->nullable();
            $table->string('item_tax_group');
            $table->string('customer_tax_group');
            $table->string('item_posting_group');
            $table->string('customer_posting_group');
            $table->float('vat_percent');
            $table->float('amount');
            $table->float('amount_inc_vat');
            $table->foreignIdFor(SalesCrNote::class);
            $table->foreignIdFor(ItemEntry::class);
            $table->foreignIdFor(Location::class);
            $table->timestamps();
        });

         Schema::create('purchase_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Item::class);
            $table->string('document_no');
            $table->string('document_type')->default('order');
            $table->string('ext_doc_no');
            $table->float('unit_cost');
            $table->float('quantity');
            $table->string('uom')->nullable();
            $table->string('item_tax_group');
            $table->string('customer_tax_group');
            $table->string('item_posting_group');
            $table->string('vendor_posting_group');
            $table->float('vat_percent');
            $table->float('amount');
            $table->float('amount_inc_vat');
            $table->foreignIdFor(Location::class);
            $table->foreignIdFor(PurchaseOrder::class);
            $table->timestamps();
        });

         Schema::create('purchase_invoice_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Item::class);
            $table->string('document_no');
            $table->string('ext_doc_no');
            $table->float('unit_cost');
            $table->float('quantity');
            $table->string('uom')->nullable();
            $table->string('item_tax_group');
            $table->string('customer_tax_group');
            $table->string('item_posting_group');
            $table->string('vendor_posting_group');
            $table->float('vat_percent');
            $table->float('amount');
            $table->float('amount_inc_vat');
            $table->foreignIdFor(PurchaseInvoice::class);
            $table->foreignIdFor(Location::class);
            $table->foreignIdFor(ItemEntry::class);
            $table->timestamps();
        });

        Schema::create('purchase_cr__lines', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Item::class);
            $table->string('document_no');
            $table->string('ext_doc_no');
            $table->float('unit_cost');
            $table->float('quantity');
            $table->string('uom')->nullable();
            $table->string('item_tax_group');
            $table->string('customer_tax_group');
            $table->string('item_posting_group');
            $table->string('vendor_posting_group');
            $table->float('vat_percent');
            $table->float('amount');
            $table->float('amount_inc_vat');
            $table->foreignIdFor(PurchaseCrNote::class);
            $table->foreignIdFor(ItemEntry::class);
            $table->foreignIdFor(Location::class);
            $table->timestamps();
        });

        Schema::create('purchase_rct_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Item::class);
             $table->string('document_no');
            $table->string('ext_doc_no');
            $table->float('unit_cost');
            $table->float('quantity');
            $table->string('uom')->nullable();
            $table->string('item_tax_group');
            $table->string('customer_tax_group');
            $table->string('item_posting_group');
            $table->string('vendor_posting_group');
            $table->float('vat_percent');
            $table->float('amount');
            $table->float('amount_inc_vat');
            $table->foreignIdFor(PurchaseReceipt::class);
            $table->foreignIdFor(ItemEntry::class);
            $table->foreignIdFor(Location::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_lines');
        Schema::dropIfExists('sales_invoice_lines');
        Schema::dropIfExists('sales_shipment_lines');
        Schema::dropIfExists('sales_cr_lines');

        Schema::dropIfExists('purchase_lines');
        Schema::dropIfExists('purchase_invoice_lines');
        Schema::dropIfExists('purchase_rct_lines');
        Schema::dropIfExists('purchase_cr_lines');
    }
};
