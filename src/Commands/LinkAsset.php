<?php

namespace Ombimo\MrPanel\Commands;

use Facade\Ignition\Tabs\Tab;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Ombimo\MrPanel\Models\Table;

class LinkAsset extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mrpanel:link-asset';

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
        $this->info('Link Asset Start');

        $target = __DIR__ . '/../../assets';
        $link = public_path('mrpanel-assets');

        $this->laravel->make('files')->link($target, $link);

        $this->info('Link Asset End');
    }
}
