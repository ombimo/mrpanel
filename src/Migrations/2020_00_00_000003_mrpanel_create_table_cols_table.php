<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MrpanelCreateTableColsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbz_table_cols', function (Blueprint $table) {
            $table->id();

            $table->foreignId('table_id')->nullable()
                  ->constrained('tbz_tables')
                  ->onUpdate('no action')
                  ->onDelete('cascade');

            $table->string('col_name', 50);
            $table->string('label', 100)->nullable();
            $table->string('help_text', 200)->nullable();
            $table->integer('type_id')->nullable();
            $table->boolean('view')->default(0);
            $table->boolean('form')->default(0);
            $table->boolean('searchable')->default(0);
            $table->boolean('empty_checker')->default(0);
            $table->integer('posisi_view')->default(0);
            $table->integer('posisi_form')->default(0);
            $table->text('config_view')->nullable();
            $table->text('config_form')->nullable();
            $table->timestamps();
            $table->unique(['table_id', 'col_name']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbz_table_cols');
    }
}
