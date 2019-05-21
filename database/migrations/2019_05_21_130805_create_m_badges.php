<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMBadges extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_badges', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('badge_id')->unique();
            $table->string('name', 255);
            $table->string('description', 255);
            $table->integer('priority');
        });
        
        Artisan::call('db:seed', ['--class' => 'MasterBadgesTableSeeder']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_badges');
    }
}
