<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => [
    'auth:sanctum',
    'verified'
]], function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::group(['middleware' => ['permission:user.list']], function () {
        Route::get('/users', function () {
            return view('admin.users');
        })->name('users');
    });

    Route::group(['middleware' => ['permission:navigation-menu.list']], function () {
        Route::get('/navigation-menus', function () {
            return view('admin.navigation-menus');
        })->name('navigation-menus');
    });

    Route::group(['middleware' => ['permission:user-permission.list']], function () {
        Route::get('/user-permissions', function () {
            return view('admin.user-permissions');
        })->name('user-permissions');
    });
});

Route::get('/', function () {
    return view('welcome');
});


Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    Route::view('forms', 'forms')->name('forms');
    Route::view('cards', 'cards')->name('cards');
    Route::view('charts', 'charts')->name('charts');
    Route::view('buttons', 'buttons')->name('buttons');
    Route::view('modals', 'modals')->name('modals');
    Route::view('tables', 'tables')->name('tables');
    Route::view('calendar', 'calendar')->name('calendar');
});
