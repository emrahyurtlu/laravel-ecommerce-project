<?php

use App\Models\Invoice;
use App\Models\Product;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_details', function (Blueprint $table) {
            $table->id("invoice_detail_id");
            $table->foreignIdFor(Invoice::class, "invoice_id");
            $table->foreignIdFor(Product::class, "product_id");
            $table->integer("quantity");
            $table->float("unit_price");
            $table->float("total");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_details');
    }
}
