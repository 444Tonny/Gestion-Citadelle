<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'supports', function (Blueprint $table){
            $table->id();
            $table->string('subject')->nullable();
            $table->string('assign_user')->nullable();
            $table->string('priority')->nullable();
            $table->string('status')->nullable();
            $table->string('attachment')->nullable();
            $table->text('description')->nullable();
            $table->integer('created_id')->default(0);
            $table->integer('parent_id')->default(0);
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
        Schema::dropIfExists('supports');
    }
}
