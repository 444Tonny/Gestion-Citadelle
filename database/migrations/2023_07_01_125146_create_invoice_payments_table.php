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
        Schema::create('invoice_payments', function (Blueprint $table) {
            $table->id();
            $table->integer('invoice_id')->default(0);
            $table->string('transaction_id')->nullable();
            $table->string('payment_type')->nullable();
            $table->float('amount')->default(0);
            $table->date('payment_date')->nullable();
            $table->string('receipt')->nullable();
            $table->integer('parent_id')->default(0);
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('invoice_payments');
    }
};
