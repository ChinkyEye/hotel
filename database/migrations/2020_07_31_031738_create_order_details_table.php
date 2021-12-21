<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->integer('bill_id');
            $table->float('total',8,2);
            $table->float('discount',8,2);
            $table->float('grand_total',8,2);
            $table->float('tender',8,2);
            $table->float('return_change',8,2);
            $table->float('received',8,2)->nullable();
            $table->unsignedBigInteger('customer_id')->unsigned();
            $table->foreign('customer_id')->references('id')->on('users');
            $table->unsignedBigInteger('usertype_id')->unsigned();
            $table->foreign('usertype_id')->references('id')->on('usertypes');
            $table->unsignedBigInteger('table_id')->unsigned();
            $table->foreign('table_id')->references('id')->on('tables');
            $table->integer('is_active')->default(1);
            $table->integer('is_confirmed')->default(0); // 0 order succes, 1 confirm, 2 processing, 3 deliver
            $table->integer('bill_type')->default(0); //0 paid, 1 due, 2 for receive type 1
            $table->integer('receive_type')->default(0); //0 order, 1 paisa pay from customer
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
        Schema::dropIfExists('order_details');
    }
}
