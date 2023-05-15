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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('phone')->unique()->nullable();
            $table->double('rate')->nullable();
            $table->double('wallet')->nullable();
            $table->string('password');
            $table->string('user_type', 255)->nullable()->default('user');
            $table->string('contact_number', 255)->nullable();
            $table->unsignedBigInteger('zone_id');
            $table->string('player_id')->nullable();
            $table->foreign('zone_id')->references('id')->on('zones')->onDelete('cascade');
            $table->text('address')->nullable();
            $table->text('user_otp')->nullable();
            $table->tinyInteger('status')->nullable()->default('1');
            $table->tinyInteger('is_featured')->nullable()->default('0');
            $table->string('time_zone')->default('UTC');
            $table->string('device_token')->nullable();
            $table->timestamp('last_notification_seen')->nullable();
            $table->timestamp('email_verified_at')->nullable();
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
        Schema::dropIfExists('users');
    }
};
