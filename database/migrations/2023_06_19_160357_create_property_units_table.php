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
        Schema::create('property_units', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->integer('bedroom')->default(0);
            $table->integer('property_id')->default(0);
            $table->integer('baths')->default(0);
            $table->integer('kitchen')->default(0);
            $table->float('rent')->default(0);
            $table->float('deposit_amount')->default(0);
            $table->string('deposit_type')->nullable();
            $table->string('late_fee_type')->nullable();
            $table->float('late_fee_amount')->default(0);
            $table->float('incident_receipt_amount')->default(0);
            $table->string('rent_type')->default(0);
            $table->integer('rent_duration')->default(0);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->date('payment_due_date')->nullable();
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
        Schema::dropIfExists('property_units');
    }
};
