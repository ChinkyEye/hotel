<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id')->unsigned();
            $table->foreign('customer_id')->references('id')->on('users');
            $table->unsignedBigInteger('usertype_id')->unsigned();
            $table->foreign('usertype_id')->references('id')->on('usertypes');
            $table->integer('bill_id');
            $table->unsignedBigInteger('item_id')->unsigned();
            $table->foreign('item_id')->references('id')->on('items');
            $table->unsignedBigInteger('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('categories');
            $table->unsignedBigInteger('unit_id')->unsigned();
            $table->foreign('unit_id')->references('id')->on('units');
            $table->string('quantity',15);
            $table->string('total',15);
            $table->integer('is_confirmed')->default(0);
            $table->integer('bill_type')->default(0); //0 paid, 1 due
            $table->integer('item_type_id')->default(1); // 1 ready made, 2 kot, 3 bar...
            $table->integer('status')->default(1); // 0 old, 1 new
            $table->string('is_active')->default(1);
            $table->unsignedBigInteger('created_by')->unsigned();
            $table->foreign('created_by')->references('id')->on('users');
            $table->unsignedBigInteger('billed_by')->unsigned();
            $table->foreign('billed_by')->references('id')->on('users');
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
        Schema::dropIfExists('orders');
    }
}
