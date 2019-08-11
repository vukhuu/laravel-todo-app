<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Routes for TodoList model's actions
Route::resource('todoLists', 'TodoListController')->only([
    'index', 'show', 'store', 'update', 'destroy'
])->middleware('auth');

// Routes for TodoListItem model's actions
Route::post('todoListItems/{todoListItem}/markDone', 'TodoListItemController@markDone')
    ->name('todoListItems.markDone');
Route::resource('todoListItems', 'TodoListItemController')->only([
    'store', 'update', 'destroy'
])->middleware('auth');

// Routes for frontend web app
Route::group(['middleware' => 'auth'], function () {
    Route::get('/main', 'MainController@index');
});