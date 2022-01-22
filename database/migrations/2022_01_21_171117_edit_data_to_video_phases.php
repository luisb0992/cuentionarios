<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class EditDataToVideoPhases extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('video_phases', function (Blueprint $table) {
            $table->longText('data')->nullable()->change();
        });

        // if (env('DB_CONNECTION') === 'mysql') {
        //     DB::statement("ALTER TABLE video_phases MODIFY COLUMN data TEXT");
        // }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // if (env('DB_CONNECTION') === 'mysql') {
        //     DB::statement("ALTER TABLE video_phases MODIFY COLUMN data MEDIUMBLOB");
        // }
    }
}
