<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {


        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('avatar')->default('default.png');
            $table->string('cover')->default('default.jpg');
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->boolean('bot')->default('0');
            $table->rememberToken();
            $table->timestamps();
        });



        DB::table('users')->insert(
            array(
                array('first_name' => 'Marjuke', 'last_name' => 'Rahman', 'avatar' => 'marjuke.jpg','email' => 'marjuke@mail.com', 'bot' => '1'),
                array('first_name' => 'Mominul', 'last_name' => 'Shisier', 'avatar' => 'mohyminul.jpg','email' => 'mohyminul@mail.com', 'bot' => '1'),
                array('first_name' => 'Mahadi', 'last_name' => 'Hasan', 'avatar' => 'mahadi.jpg','email' => 'mahadi@mail.com', 'bot' => '1'),
                array('first_name' => 'Shamim', 'last_name' => 'Hasnain', 'avatar' => 'shamim.jpg','email' => 'shamim@mail.com', 'bot' => '1'),
                array('first_name' => 'Faiyaz', 'last_name' => 'Islam', 'avatar' => 'faiyaz.jpg','email' => 'faiyaz@mail.com', 'bot' => '1'),
                array('first_name' => 'Rocker', 'last_name' => 'Kushol', 'avatar' => 'rocker.jpg','email' => 'rocker@mail.com', 'bot' => '1'),
                array('first_name' => 'Tahmid', 'last_name' => 'Hossain', 'avatar' => 'tahamid.jpg','email' => 'tahmid@mail.com', 'bot' => '1'),
                array('first_name' => 'Ahmed', 'last_name' => 'Shafkat', 'avatar' => 'ahmed.jpg','email' => 'ahmed@mail.com', 'bot' => '1'),
                array('first_name' => 'Ashik', 'last_name' => 'Haider', 'avatar' => 'ankon.jpg','email' => 'ashik@mail.com', 'bot' => '1'),
                array('first_name' => 'Erfan', 'last_name' => 'Hamid', 'avatar' => 'erfan.jpg','email' => 'erfan@mail.com', 'bot' => '1'),
            )
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
