<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class MrpanelCreateTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbz_tables', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150)->unique();
            $table->string('alias', 150)->unique();
            $table->string('label', 150)->nullable();
            $table->string('primary_col', 150)->nullable();
            $table->string('created_col', 150)->nullable();
            $table->string('updated_col', 150)->nullable();
            $table->text('additional')->nullable();
            $table->text('addon')->nullable();
            $table->boolean('publish')->default(0);
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
        Schema::dropIfExists('tbz_tables');
    }
}
