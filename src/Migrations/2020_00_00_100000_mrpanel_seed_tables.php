<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class MrpanelSeedTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('tbz_tables')->insert([[
            'id' => 1,
            'name' => 'tbz_roles',
            'alias' => 'tbz-roles',
            'label' => 'Roles',
        ], [
            'id' => 2,
            'name' => 'tbz_admin',
            'alias' => 'tbz-admin',
            'label' => 'Admin',
        ], [
            'id' => 3,
            'name' => 'tbz_tables',
            'alias' => 'tbz-tables',
            'label' => 'Table',
        ], [
            'id' => 4,
            'name' => 'tbz_table_cols',
            'alias' => 'tbz-table-cols',
            'label' => 'Table Col',
        ], [
            'id' => 5,
            'name' => 'tbz_permissions',
            'alias' => 'tbz-permissions',
            'label' => 'Permission',
        ], [
            'id' => 6,
            'name' => 'tbz_menus',
            'alias' => 'tbz-menus',
            'label' => 'Menu',
        ], [
            'id' => 7,
            'name' => 'tbz_modules',
            'alias' => 'tbz-modules',
            'label' => 'Module',
        ], [
            'id' => 8,
            'name' => 'tbz_input_type',
            'alias' => 'tbz-input-type',
            'label' => 'Input Type',
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
