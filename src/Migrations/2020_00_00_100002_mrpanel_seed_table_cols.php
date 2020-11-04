<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class MrpanelSeedTableCols extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('tbz_table_cols')->insert([[
            'table_id' => 6,
            'col_name' => 'name',
            'label' => 'Nama',
            'help_text' => '',
            'type_id' => 1,
            'view' => true,
            'form' => true,
            'searchable' => true,
            'empty_checker' => false,
            'posisi_view' => 1,
            'posisi_form' => 1,
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
