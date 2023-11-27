<?php

use App\Models\Item;
use App\Models\PurchaseCrNote;
use App\Models\PurchaseOrder;
use App\Models\SalesInvoice;
use App\Models\PurchaseInvoice;
use App\Models\SalesCrNote;
use App\Models\SalesOrder;
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
        Schema::create('sales_order_lines', function (Blueprint $table) {
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
            $table->foreignIdFor(SalesOrder::class);
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
            $table->timestamps();
        });

         Schema::create('purchase_order_lines', function (Blueprint $table) {
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
            $table->timestamps();
        });
        Schema::create('purchase_cr_lines', function (Blueprint $table) {
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
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_order_lines');
        Schema::dropIfExists('sales_invoice_lines');
        Schema::dropIfExists('purchase_order_lines');
        Schema::dropIfExists('purchase_invoice_lines');
        Schema::dropIfExists('purchase_cr_lines');
        Schema::dropIfExists('sales_cr_lines');
    }
};
