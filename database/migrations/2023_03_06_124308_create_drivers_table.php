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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->string('username')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('phone')->unique()->nullable();
            $table->double('rate')->nullable();
            $table->string('user_type', 255)->nullable()->default('driver');
            $table->unsignedBigInteger('veichle_type_id');
            $table->foreign('veichle_type_id')->references('id')->on('veichles')->onDelete('cascade');
            $table->unsignedBigInteger('vehicle_brand_id');
            $table->foreign('vehicle_brand_id')->references('id')->on('vehicle_brands')->onDelete('cascade');
            $table->unsignedBigInteger('vehicle_model_id');
            $table->foreign('vehicle_model_id')->references('id')->on('vehicle_models')->onDelete('cascade');
            $table->unsignedBigInteger('vehicle_color_id');
            $table->foreign('vehicle_color_id')->references('id')->on('vehicle_colors')->onDelete('cascade');
            $table->string('vehicle_year', 255)->nullable();
            $table->string('vehicle_plate_number', 255)->nullable();
            $table->string('user_otp', 255)->nullable();
            $table->string('player_id')->nullable();
            $table->string('zone_id', 255)->nullable();
            $table->text('address')->nullable();
            $table->tinyInteger('status')->nullable()->default('0');
            $table->tinyInteger('is_featured')->nullable()->default('0');
            $table->string('time_zone')->default('UTC');
            $table->string('device_token')->nullable();
            $table->timestamp('last_notification_seen')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('expire_at')->nullable();
            $table->timestamp('expire_at')->nullable();
            $table->text('device_key')->nullable();
            $table->rememberToken();
            $table->softDeletes();
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
        Schema::dropIfExists('drivers');
    }
};
