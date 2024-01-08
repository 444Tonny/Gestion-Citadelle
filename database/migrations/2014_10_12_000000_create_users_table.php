<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'users', function (Blueprint $table){
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('type')->nullable();
            $table->string('profile')->nullable();
            $table->string('lang')->nullable();
            $table->integer('subscription')->nullable();
            $table->date('subscription_expire_date')->nullable();
            $table->integer('parent_id')->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->integer('is_active')->default(1);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
