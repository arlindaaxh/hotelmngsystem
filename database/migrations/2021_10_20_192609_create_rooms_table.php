<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->string('type');
            $table->string('code');
            $table->string('number');
            $table->boolean('status');
            $table->json('facilities');
            $table->id();
            $table->timestamps();
        });


        Schema::table('rooms', function (Blueprint $table) {
            $table->string('cleaning_status');
            // $table->bigInteger('maintainer_id');
        });
    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rooms');
    }
}
