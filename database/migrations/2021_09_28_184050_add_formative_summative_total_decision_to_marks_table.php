<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFormativeSummativeTotalDecisionToMarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('marks', function (Blueprint $table) {
            $table->integer('formative');
            $table->integer('summative');
            $table->integer('total');
            $table->boolean('decision');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('marks', function (Blueprint $table) {
            $table->dropColumn(['formative', 'summative', 'total', 'decision']);
        });
    }
}
