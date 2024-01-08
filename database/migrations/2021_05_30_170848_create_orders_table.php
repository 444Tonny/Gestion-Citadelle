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
        Schema::create(
            'orders', function (Blueprint $table){
            $table->id();
            $table->string('order_id')->unique();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('card_number')->nullable();
            $table->string('card_exp_month')->nullable();
            $table->string('card_exp_year')->nullable();
            $table->string('subscription');
            $table->integer('subscription_id');
            $table->float('price');
            $table->string('price_currency');
            $table->string('txn_id');
            $table->string('payment_status');
            $table->string('payment_type');
            $table->string('receipt')->nullable();
            $table->integer('user_id')->default(0);
            $table->timestamps();
        }
        );
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
