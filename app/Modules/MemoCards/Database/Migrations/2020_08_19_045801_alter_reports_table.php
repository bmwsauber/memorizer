<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->integer('total')->nullable(true)->change();
            $table->integer('right')->nullable(true)->change();
            $table->integer('wrong')->nullable(true)->change();
        });
    }
}
