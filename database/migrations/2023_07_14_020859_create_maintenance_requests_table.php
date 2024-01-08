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
        Schema::create('maintenance_requests', function (Blueprint $table) {
            $table->id();
            $table->integer('property_id')->default(0);
            $table->integer('unit_id')->default(0);
            $table->integer('issue_type')->default(0);
            $table->integer('maintainer_id')->default(0);
            $table->string('status')->nullable();
            $table->float('amount')->default(0);
            $table->string('issue_attachment')->nullable();
            $table->string('invoice')->nullable();
            $table->date('request_date')->nullable();
            $table->date('fixed_date')->nullable();
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
        Schema::dropIfExists('maintenance_requests');
    }
};
