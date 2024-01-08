<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'subscriptions', function (Blueprint $table){
            $table->id();
            $table->string('name')->unique();
            $table->float('price')->default(0.00);
            $table->string('duration')->nullable();
            $table->string('image')->nullable();
            $table->integer('total_user')->nullable();
            $table->integer('total_property')->nullable();
            $table->integer('total_tenant')->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('subscriptions');
    }
}
