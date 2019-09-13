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
Route::group(['middleware' => 'auth'], function () {
    Route::get('/add_project_view', 'ProjectController@index')->name('add_project_view');
    Route::post('insert_project', 'ProjectController@create')->name('create_project');
//Codice
    Route::get('/add_codice_view', 'CodiceController@index')->name('add_codice_view');
    Route::post('insert_codice', 'CodiceController@create')->name('create_codice');
    Route::post('configuration_codice', 'CodiceController@get_by_id')->name('get_part_by_project_id');
    Route::post('configuration_project', 'CodiceController@get_by_id_project')->name('get_project_by_codice_id');
    Route::get('codice_list_view', 'CodiceController@codice_list_view')->name('codice_list_view');
    Route::post('/codice_list', 'CodiceController@codice_list')->name('codice_list');
    Route::post('codice_list/seraching', 'CodiceController@searching');
    Route::get('codice_list/delete/{id}', 'CodiceController@delete')->name('delete_codice');
    Route::post('/codice_list/filter', 'CodiceController@get_by_project')->name('filter_by_project');
    Route::get('codice_list/update_view/{id}', 'CodiceController@update_view')->name('update_view');
    Route::post('codice_list/update', 'CodiceController@update_codice')->name('codice_update');
//Configuration
    Route::get('/configuration_list/update_view/{id}', 'ConfigurationController@update_view')->name('update_view');
    Route::post('/configuration_list/update', 'ConfigurationController@update')->name('update_configuration');
    Route::get('configuration_list_view/{codiceid?}', 'ConfigurationController@config_list_view')->name('conf_list_view');
    Route::post('configuration_list', 'ConfigurationController@config_list')->name('conf_list');
    Route::get('configuration/upload_view/{id}', 'ConfigurationController@upload_foto_view')->name('upload_view');
    Route::post('/configuration/upload', 'ConfigurationController@upload_photo')->name('upload');
    Route::get('/add_configuration', 'ConfigurationController@index')->name('add_configuration');
    Route::post('insert_configuration', 'ConfigurationController@insert')->name('insert_configuration');
    Route::get('/configuration/get_list_excel', 'ConfigurationController@get_excell')->name('get_excell');
//Project
    Route::get('project_list/delete/{id}', 'ProjectController@delete')->name('delete_project');
    Route::get('project_list_view', 'ProjectController@project_list_view')->name('projects_list_view');
    Route::post('project_list', 'ProjectController@project_list')->name('project_list');
    Route::get('project_list/update_view/{id}', 'ProjectController@update_project_view')->name('project_update_view');
    Route::post('project_list/update', 'ProjectController@update_project')->name('project_update');
//Photo
    Route::post('photo_list', 'PhotoController@photo_list')->name('photo_l');
    Route::get('photo_list_view/{codiceid?}', 'PhotoController@index')->name('photo_list_view');
    Route::post('photo_download', 'PhotoController@download_photo')->name('download_photo');
    Route::get('/photo_delete/{id}', 'PhotoController@delete_photo')->name('delete_photo');
    Route::get('/photo/raport_view', 'PhotoController@raport_view')->name('photo_raport_view');
    Route::post('/photo/raport_generate', 'PhotoController@raport')->name('generate_raport');
//Raport
    Route::get('/raport_view', 'RaportController@get_compare_view')->name('raport_view');
    Route::post('/generate_raport', 'RaportController@generate_raport')->name('generate_raport');
    Route::get('/raport_list_view', 'RaportController@report_list_view')->name('report_list_view');
    Route::post('/add_report','RaportController@create_report')->name('create_report');
    Route::post('/all_reports', 'RaportController@get_all')->name('get_all_reports');
//Machines
    Route::get('/add_machine_view', 'MachineController@index')->name('add_machine_view');
    Route::get('/machine_list_view', 'MachineController@machines_list_view')->name('machine_list_view');
    Route::post('/machine_list', 'MachineController@machines_list')->name('machine list');
    Route::post('/add_machine', 'MachineController@create')->name('add_machine');
//Connectors
    Route::get('/add_connector_view', 'ConnectorController@index')->name('add_connector_view');
    Route::post('/add_connector', 'ConnectorController@create')->name('add_connector');
    Route::post('/connector_list', 'ConnectorController@connector_list')->name('connector_list');
    Route::get('/connector_list_view', 'ConnectorController@connectors_list_view')->name('connector_list_view');
    Route::get('/specification_view', 'ConnectorController@upload_specification_view')->name('specification_view');
    Route::post('/upload_specifications', 'ConnectorController@upload_specifications')->name('upload_specif');
    Route::post('/download_specification', 'ConnectorController@download_specification')->name('download_specif');
   
//Miniaplicators
    Route::get('/add_miniaplicator_view', 'MiniaplicatorController@index')->name('add_miniaplicator_view');
    Route::post('/add_miniaplicator', 'MiniaplicatorController@create')->name('add_miniaplicator');
    Route::get('/miniaplicator_list_view', 'MiniaplicatorController@miniaplicators_list_view')->name('mini_list_view');
    Route::post('/miniaplicator_list', 'MiniaplicatorController@miniaplicator_list')->name('miniaplicator_list');
    Route::get('/miniaplicator_list/delete/{id}', 'MiniaplicatorController@delete')->name('delete_miniaplicator');

//Mini Calibration    
    Route::post('/add_mini_calibration', 'MiniaplicatorController@add_mini_calibration')->name('add_mini_calibration');
    Route::get('/add_mini_calibaration_view' , 'MiniaplicatorController@add_calibration_view')->name('mini_calibration_view');
    Route::post('/mini_calibaration_list' , 'MiniaplicatorController@mini_calibration_list')->name('mini_calibration_list');
    Route::get('/mini_calibaration_list_view' , 'MiniaplicatorController@mini_calibration_list_view')->name('mini_calibration_list_view');
    Route::get('/mini_calibration_delete/{id}','MiniaplicatorController@mini_calibration_delete')->name('mini_calibr_delete');

   
    
});

