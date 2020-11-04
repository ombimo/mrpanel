<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class MrpanelSeedInputType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('tbz_input_type')->insert([[
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
        ],]);
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
