<?php

Route::group([
    'middleware' => ['web', 'mrpanel.dashboard'],
    'prefix' => config('mrpanel.prefix'),
    'namespace' => 'Ombimo\MrPanel\Modules\MPDataTables',
], function() {
    Route::get('datatables/{tableAlias}/{id?}', 'MPDataTablesController@get')->name('mrpanel.module.mpdatatables.get');
});