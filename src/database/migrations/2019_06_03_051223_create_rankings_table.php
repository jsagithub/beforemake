<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRankingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rankings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_project')->unsigned();
            $table->foreign('id_project')
                  ->references('id')->on('projects')
                  ->onDelete('cascade');
            $table->integer('position');
            $table->integer('id_project_status')->unsigned();
            $table->foreign('id_project_status')
                  ->references('id')->on('project_statuses');
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
        Schema::dropIfExists('rankings');
    }
}
