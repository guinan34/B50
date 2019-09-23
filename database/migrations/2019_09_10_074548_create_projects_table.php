<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('project_name')->comment('集资项目名称');
            $table->integer('project_id')->nullable()->comment('集资项目名称');
            $table->string('platform')->nullable()->comment('平台，取值范围：摩点、oWhat、其他，可为NULL');
            $table->float('amount')->comment('集资金额');
            
            $table->string('remark')->nullable()->comment('备注');  

            $table->unsignedInteger('song_id')->comment('歌曲ID song表外键');
            $table->unsignedInteger('fanclub_id')->comment('应援会ID fanclub表外键');

            $table->integer('is_obsolete')->default('0')->comment('设置是否废弃0启用,1废弃');

            $table->datetime('start_time');
            $table->datetime('end_time');
            //设置外键以及级联删除和更新
            // $table->foreign('song')->references('song')->on('songs')->onDelete('cascade')->onUpdate('cascade');
            // $table->foreign('fan_club')->references('fan_club')->on('fan_clubs')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('projects');
    }
}
