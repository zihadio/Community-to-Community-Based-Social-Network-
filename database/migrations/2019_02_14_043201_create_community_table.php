<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommunityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('community', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->integer('community_id');
            $table->timestamps();
        });


        DB::table('community')->insert(
            array(
                array('name' => 'Computer Engineers', 'community_id' => '1'),
                array('name' => 'Electrical Engineers', 'community_id' => '2'),
                array('name' => 'Cardiologist', 'community_id' => '3'),

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
        Schema::dropIfExists('community');
    }
}
