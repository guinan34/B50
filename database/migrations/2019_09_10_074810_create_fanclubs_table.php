<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFanclubsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fanclubs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fanclub')->comment('应援会');
            $table->string('member')->comment('成员');
            $table->string('modian_id')->comment('摩点项目id');
            $table->string('owhat_id')->comment('owhat项目id');
            $table->boolean('active')->comment('0应援会废弃 1应援会启用');
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
        Schema::dropIfExists('fanclubs');
    }
}
