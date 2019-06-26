<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Auth::routes();
Route::get('/', 'HomeController@index');
Route::resource('grv', 'GetGRVController');
Route::resource('issue', 'IssueController');
Route::resource('serialized', 'SerializedItemsController');
Route::resource('serials', 'SerialsearchController');
Route::resource('warranties', 'ItemWarrantController');
Route::resource('warrantysetup', 'WarrantyController');
Route::resource('issueddnote', 'IssuedDnoteController');
Route::get('issuednote', 'IssueDnoteController@issue');

Route::resource('sync', 'GetGRVController@sync');

Route::get('serialized-unprocessed', 'SerializedItemsController@index_unprocessed');
Route::get('show-unprocessed/{id}', 'SerializedItemsController@show_un');
Route::get('unprocessed', 'GetGRVController@index_unprocessed');
Route::get('edit-unprocessed/{id}', 'GetGRVController@edit_un');
Route::post('receive-unprocessed', 'GetGRVController@receive_un');
Route::post('receive', 'GetGRVController@receive');
Route::post('receive-item', 'IssueController@receive');
Route::get('deliver', 'IssueController@deliver');
Route::get('/home', 'HomeController@index');
Route::resource('reports','ReportsController');
Route::get('sales-report','ReportsController@invoiceCreate');
Route::post('sales-report-generate','ReportsController@geInvoiceReport');
Route::resource('manage-users','ManageUsersController');

Route::resource('setting', 'SettingController');
