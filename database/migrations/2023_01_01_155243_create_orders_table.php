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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('address_from');
            $table->double('lat_from');
            $table->double('long_from');
            $table->text('note')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('zone_id');
            $table->foreign('zone_id')->references('id')->on('zones')->onDelete('cascade');
            $table->tinyInteger('pick_up_type')->nullable()->default('1')->comment('1- now , 0- later');
            $table->string('status')->nullable()->default('pending')->comment('pending ,delivered, upcoming');
            $table->double('total_cost');
            $table->date('order_date')->nullable();
            $table->time('order_time')->nullable();
            $table->string('activity_type_ids', 255)->nullable();
            $table->unsignedBigInteger('veichle_type_id');
            $table->foreign('veichle_type_id')->references('id')->on('veichles')->onDelete('cascade');
            $table->integer('cancell_details')->nullable();
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
};
