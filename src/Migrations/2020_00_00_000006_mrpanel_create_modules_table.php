<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MrpanelCreateModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbz_modules', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->string('query', 100);
            $table->string('callback', 200);
            $table->boolean('method_get')->default(0);
            $table->boolean('method_post')->default(0);
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
        Schema::dropIfExists('tbz_module');
    }
}
