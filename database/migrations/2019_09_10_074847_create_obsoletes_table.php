<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObsoletesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('obsoletes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('project_name')->comment('集资项目名称');
            $table->integer('project_id')->nullable()->comment('集资项目名称');
            $table->string('platform')->nullable()->comment('平台，取值范围：摩点、oWhat、其他');
            $table->string('fanclub')->comment('应援会');
            
            $table->datetime('start_time');
            $table->datetime('end_time');
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
        Schema::dropIfExists('obsoletes');
    }
}
