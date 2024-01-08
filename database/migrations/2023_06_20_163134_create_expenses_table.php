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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->integer('expense_id')->default(0);
            $table->integer('property_id')->default(0);
            $table->integer('unit_id')->default(0);
            $table->integer('expense_type')->default(0);
            $table->date('date')->nullable();
            $table->float('amount')->default(0.00);
            $table->string('receipt')->nullable();
            $table->text('notes')->nullable();
            $table->integer('parent_id')->default(0);
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
        Schema::dropIfExists('expenses');
    }
};
