<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('name',100);
            $table->string('address',50);
            $table->string('phone',50);
            $table->string('footer_quote1');
            $table->string('footer_quote2');
            $table->string('taxamount')->nullable();
            $table->string('logo')->nullable();
            $table->string('pan',50)->nullable();
            $table->string('email',50)->nullable();
            $table->integer('is_active')->default(1); // always active
            $table->unsignedBigInteger('fiscalyear_id');
            $table->foreign('fiscalyear_id')->references('id')->on('fiscal_years');
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users');
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('settings');
    }
}
