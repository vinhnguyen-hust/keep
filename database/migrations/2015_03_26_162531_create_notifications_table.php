<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sent_from', '20')->nullable();
            $table->string('type', 20)->nullable();
            $table->string('subject')->nullable();
            $table->string('slug')->unique();
            $table->text('body')->nullable();
            $table->integer('object_id')->unsigned()->nullable();
            $table->string('object_type', 128)->nullable();
            $table->dateTime('sent_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('notifications');
    }
}
