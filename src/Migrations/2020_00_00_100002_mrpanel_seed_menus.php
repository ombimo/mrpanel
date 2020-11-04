<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class MrpanelSeedMenus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('tbz_menus')->insert([[
            'parent_id' => null,
            'table_id' => null,
            'name' => 'Home',
            'module' => null,
            'url' => '/',
            'param' => null,
            'icon_class' => 'fas fa-home',
            'position' => 0,
            'is_separator' => false,
        ], [
            'parent_id' => null,
            'table_id' => null,
            'name' => 'Admin',
            'module' => null,
            'url' => null,
            'param' => null,
            'icon_class' => 'fas fa-users-cog',
            'position' => 2000,
            'is_separator' => true,
        ], [
            'parent_id' => null,
            'table_id' => 6,
            'name' => 'Menu',
            'module' => 'view',
            'url' => null,
            'param' => null,
            'icon_class' => '',
            'position' => 2001,
            'is_separator' => false,
        ], [
            'parent_id' => null,
            'table_id' => null,
            'name' => 'Table',
            'module' => null,
            'url' => 'table',
            'param' => null,
            'icon_class' => 'fas fa-table',
            'position' => 2002,
            'is_separator' => false,
        ], ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
