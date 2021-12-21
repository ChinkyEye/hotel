<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->float('price', 8, 2);
            $table->float('quantity', 6, 2);
            $table->integer('qty_rem')->default(0);
            $table->float('rate', 8, 2)->nullable();
            $table->float('vat', 6, 2)->nullable();
            $table->float('total', 8, 2)->nullable();
            $table->integer('type')->default(0); // 4 for asset
            $table->unsignedBigInteger('vendor_id')->unsigned();
            $table->foreign('vendor_id')->references('id')->on('vendor_details');
            $table->unsignedBigInteger('unit_id')->unsigned();
            $table->foreign('unit_id')->references('id')->on('units');
            $table->unsignedBigInteger('bought_user_id')->unsigned();
            $table->foreign('bought_user_id')->references('id')->on('users');
            $table->unsignedBigInteger('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('categories');
            $table->unsignedBigInteger('created_by')->unsigned();
            $table->foreign('created_by')->references('id')->on('users');
            $table->boolean('is_active')->default(True); // 1 active, 0 non active
            $table->string('date_np',10);
            $table->string('date',10);
            $table->string('time',8);
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
        Schema::dropIfExists('stocks');
    }
}
