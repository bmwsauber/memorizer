<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIrregRowCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cards', function (Blueprint $table) {
            $table->tinyInteger('irreg_verb')->default(0)->after('rus');
            $table->tinyInteger('show_only')->nullable(true)->after('rus');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cards', function (Blueprint $table) {
            $table->dropColumn('irreg_verb');
            $table->dropColumn('show_only');
        });
    }
}
