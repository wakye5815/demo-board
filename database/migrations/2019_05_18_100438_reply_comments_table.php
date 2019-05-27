<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ReplyCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reply_comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('to_comment_id')->unsigned();
            $table->bigInteger('from_comment_id')->unsigned();
            $table->timestamps();

            $table->foreign('to_comment_id')->references('id')->on('comments');
            $table->foreign('from_comment_id')->references('id')->on('comments');
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }
}
