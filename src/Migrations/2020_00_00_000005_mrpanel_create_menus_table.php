<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MrpanelCreatemenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbz_menus', function (Blueprint $table) {
            $table->id();
            $table->integer('parent_id')->nullable();
            $table->string('name', 50);

            $table->foreignId('table_id')->nullable()
                  ->constrained('tbz_tables')
                  ->onUpdate('no action')
                  ->onDelete('cascade');

            $table->string('module', 20)->nullable();
            $table->string('url', 200)->nullable();
            $table->string('param', 50)->nullable();
            $table->string('icon_class', 50);
            $table->integer('position')->default(0);
            $table->boolean('is_separator')->default(0);
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
        Schema::dropIfExists('tbz_menus');
    }
}
