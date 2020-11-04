<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class MrpanelCreateMenuRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbz_menu_role', function (Blueprint $table) {
            $table->id();

            $table->foreignId('role_id')->nullable()
                  ->constrained('tbz_roles')
                  ->onUpdate('no action')
                  ->onDelete('cascade');
            $table->foreignId('menu_id')->nullable()
                  ->constrained('tbz_menus')
                  ->onUpdate('no action')
                  ->onDelete('cascade');

            $table->boolean('can_see')->default(0);

            $table->timestamps();

            $table->unique(['role_id', 'menu_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbz_menu_role');
    }
}
