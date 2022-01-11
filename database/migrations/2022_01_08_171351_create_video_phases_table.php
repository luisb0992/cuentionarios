<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateVideoPhasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('video_phases', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('phase_id');
            $table->text('name')->nullable();
            $table->integer('size')->nullable();
            $table->string('url')->nullable();
            $table->timestamps();
        });

        // agregar atributo data MEDIUMBLOB
        DB::statement("ALTER TABLE video_phases ADD data MEDIUMBLOB");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('video_phases');
    }
}
