<?php

namespace Ombimo\MrPanel\Commands;

use Facade\Ignition\Tabs\Tab;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Ombimo\MrPanel\Models\Table;
use Ombimo\MrPanel\Models\InputType;
use Symfony\Component\Console\Input\Input;

class FixInput extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mrpanel:fix-input';

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
        $this->info('Fix Input Start');

        $dataInput = $this->getInput();

        foreach($dataInput as $input) {
            $this->info($input['name']);
            $modelInput = InputType::updateOrCreate(
                [
                    'id' => $input['id']
                ],
                $input,
            );
        }

        $this->info('Fix Input End');
    }

    public function getInput()
    {
        return [[
                'id' => 1,
                'name' => 'Input Text',
                'class' => 'InputText',
                'config' => '{}',
        ], [
                'id' => 2,
                'name' => 'Input Image',
                'class' => 'InputImage',
                'config' => '{"dir":{"type":"string","description":"Berdasarkan folder di public storage"}}',
        ], [
                'id' => 3,
                'name' => 'Date Picker',
                'class' => 'DatePicker',
                'config' => '{}',
        ], [
                'id' => 4,
                'name' => 'Input Number',
                'class' => 'InputNumber',
                'config' => '{}',
        ], [
                'id' => 5,
                'name' => 'Input Password',
                'class' => 'InputPassword',
                'config' => '{}',
        ], [
                'id' => 6,
                'name' => 'Radio Switch',
                'class' => 'RadioSwitch',
                'config' => '{}',
        ], [
                'id' => 7,
                'name' => 'Select',
                'class' => 'Select',
                'config' => '{"source":{"type":"object","properties":{"table_name":{"type":"string"},"col_id":{"type":"string"},"col_value":{"type":"string"}}},"null":{"type":"boolean","format":"checkbox"}}',
        ], [
                'id' => 8,
                'name' => 'Select2',
                'class' => 'Select2',
                'config' => '{"source":{"type":"object","properties":{"table_name":{"type":"string"},"col_id":{"type":"string"},"col_value":{"type":"string"}}},"null":{"type":"boolean","format":"checkbox"}}',
        ], [
                'id' => 9,
                'name' => 'Slug Auto',
                'class' => 'SlugAuto',
                'config' => '{"col_source":{"type":"string","description":"Sumber Slug"}}',
        ], [
                'id' => 10,
                'name' => 'Text Area',
                'class' => 'TextArea',
                'config' => '{}',
        ], [
                'id' => 11,
                'name' => 'Text Editor - CKE',
                'class' => 'TextEditorCke',
                'config' => '{}',
        ], [
                'id' => 12,
                'name' => 'Text Editro - Summernote',
                'class' => 'TextEditorSummernote',
                'config' => '{}',
        ], [
                'id' => 13,
                'name' => 'Time Picker',
                'class' => 'TimePicker',
                'config' => '{}',
        ], [
                'id' => 14,
                'name' => 'Input Image Resize',
                'class' => 'InputImageResize',
                'config' => '{"dir":{"type":"string","description":"Berdasarkan folder di public storage"}}',
        ], [
            'id' => 15,
            'name' => 'Input File',
            'class' => 'InputFile',
            'config' => '{"dir":{"type":"string","description":"Berdasarkan folder di public storage"}}',
        ], ];
    }
}
