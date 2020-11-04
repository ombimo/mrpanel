<?php

namespace Ombimo\MrPanel\Commands;

use Facade\Ignition\Tabs\Tab;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Ombimo\MrPanel\Models\Table;

class PurgeTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mrpanel:purge-table';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Purge Table Start');

        $tables = array_map('reset', DB::select('SHOW TABLES'));

        Table::where('id', '>', 100)->whereNotIn('name', $tables)->delete();

        foreach ($tables as $tableName) {
            $table = Table::where('id', '>', 100)->where('name', $tableName)->first();
            if ($table != null) {
                $cols = DB::select("SHOW COLUMNS FROM $tableName");
                $colsName = [];
                foreach ($cols as $col) {
                    $colsName[] = $col->Field;
                }

                $table->cols()->whereNotIn('col_name', $colsName)->delete();
            }//end if table not null
        }// end foreach

        $this->info('Purge Table End');
    }
}
