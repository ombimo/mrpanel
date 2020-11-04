<?php

use Ombimo\MrPanel\Controllers\DashboardController;
use Ombimo\MrPanel\Controllers\Module\CreateController;
use Ombimo\MrPanel\Controllers\Module\DeleteController;
use Ombimo\MrPanel\Controllers\Module\UpdateController;
use Ombimo\MrPanel\Controllers\Module\ViewController;
use Ombimo\MrPanel\Controllers\RolePermissionController;
use Ombimo\MrPanel\Controllers\RoleMenusController;
use Ombimo\MrPanel\Controllers\TableController;
use Illuminate\Support\Facades\Route;

$panelController = 'Ombimo\MrPanel\Controllers';

Route::prefix(config('mrpanel.prefix'))->middleware('web')
    ->group(function () use ($panelController) {

    Route::get('login', $panelController.'\AdminController@login')->name('mrpanel.login');
    Route::post('login', $panelController.'\AdminController@loginAction');
    Route::get('logout', $panelController.'\AdminController@logoutAction')->name('mrpanel.logout');

});

Route::group([
    'middleware' => ['web', 'mrpanel.dashboard'],
    'prefix' => config('mrpanel.prefix'),
], function() {
    Route::get('/', [DashboardController::class, 'index'])->name('mrpanel.dashboard');

    //table
    Route::get('table', [TableController::class, 'index'])->name('mrpanel.table');
    Route::get('table/edit/{tableAlias}', [TableController::class, 'edit'])->name('mrpanel.table.edit');
    Route::post('table/edit/{tableAlias}', [TableController::class, 'editAction']);

    //permission
    Route::get('role-permission', [RolePermissionController::class, 'index'])->name('mrpanel.role-permission');
    Route::get('role-permission/{id}', [RolePermissionController::class, 'edit'])->name('mrpanel.role-permission.edit');
    Route::post('role-permission/edit', [RolePermissionController::class, 'editAction'])->name('mrpanel.role-permission.edit-action');

    //menu
    Route::get('role-menu', [RoleMenusController::class, 'index'])->name('mrpanel.role-menu');
    Route::get('role-menu/{id}', [RoleMenusController::class, 'edit'])->name('mrpanel.role-menu.edit');
    Route::post('role-menu/edit', [RoleMenusController::class, 'editAction'])->name('mrpanel.role-menu.edit-action');

    //default modules
    //view
    Route::get('{tableAlias}/view', [ViewController::class, 'get'])->name('mrpanel.module.view');

    //create
    Route::get('{tableAlias}/create', [CreateController::class, 'get'])->name('mrpanel.module.create');
    Route::post('{tableAlias}/create', [CreateController::class, 'post']);

    //update
    Route::get('{tableAlias}/update/{id}', [UpdateController::class, 'get'])->name('mrpanel.module.update');
    Route::post('{tableAlias}/update/{id}', [UpdateController::class, 'post']);

    //delete
    Route::get('{tableAlias}/delete', [DeleteController::class, 'get'])->name('mrpanel.module.delete');
    Route::post('{tableAlias}/delete', [DeleteController::class, 'post']);
});
