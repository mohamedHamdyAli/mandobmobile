<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_requests', function (Blueprint $table) {
            $table->id();
            $table->string('address_to');
            $table->double('lat_to');
            $table->double('long_to');
            $table->string('order_name')->nullable();
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->string('client_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('block')->nullable();
            $table->double('price')->nullable();
            $table->string('buliding_num')->nullable();
            $table->string('road')->nullable();
            $table->string('flat_office')->nullable();
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
        Schema::dropIfExists('order_requests');
    }
};
