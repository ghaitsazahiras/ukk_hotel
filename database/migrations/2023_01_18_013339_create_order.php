<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->bigIncrements('order_id');
            $table->integer('order_number');
            $table->string('order_name');
            $table->string('order_email');
            $table->timestamp('order_date');
            $table->date('checkin_date');
            $table->date('checkout_date');
            $table->string('guest_name');
            $table->integer('room_qty');
            $table->unsignedBigInteger('room_type_id');
            $table->enum('order_status', ['new', 'check in', 'check out']);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();
            
            $table->foreign('room_type_id')->references('room_type_id')->on('room_type');
            $table->foreign('user_id')->references('user_id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order');
    }
}
