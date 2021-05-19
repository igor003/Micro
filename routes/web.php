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
    Route::post('codice_list/searching', 'CodiceController@searching');
    Route::get('codice_list/delete/{id}', 'CodiceController@delete')->name('delete_codice');
    Route::post('/codice_list/filter', 'CodiceController@get_by_project')->name('filter_by_project');
    Route::get('codice_list/update_view/{id}', 'CodiceController@update_view')->name('update_view');
    Route::post('codice_list/update', 'CodiceController@update_codice')->name('codice_update');
     Route::get('/codice/add_BOM', 'CodiceController@add_BOOM')->name('add_codice_BOM');
    Route::get('/codice_list/BOM/{id}', 'CodiceController@bom_list')->name('bom_list');
//Configuration
    Route::get('/configuration_list/update_view/{id}', 'ConfigurationController@update_view')->name('update_view');
    Route::post('/configuration_list/update', 'ConfigurationController@update')->name('update_configuration');
    Route::get('configuration_list_view/{codiceid?}', 'ConfigurationController@config_list_view')->name('conf_list_view');
    Route::post('configuration_list', 'ConfigurationController@config_list')->name('conf_list');
    Route::get('configuration/upload_view/{id}', 'ConfigurationController@upload_foto_view')->name('upload_view');
    Route::post('/configuration/upload', 'ConfigurationController@upload_photo')->name('upload');
    Route::get('/add_configuration', 'ConfigurationController@index')->name('add_configuration');
    Route::post('insert_configuration', 'ConfigurationController@insert')->name('insert_configuration');
    Route::get('/configuration/get_list_excel/{project_id?}', 'ConfigurationController@get_excell')->name('get_excell');
    Route::post('/configuration/get_by_part_id','Configurationcontroller@get_by_part_id')->name('get_by_part_id');
    Route::post('/configuration/serv_datetitme','Configurationcontroller@get_server_date')->name('get_serv_datetitme');
    Route::get('/configuration/height_measurements/{id}','Configurationcontroller@height_measurements_view')->name('heighr_measur');
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
    Route::get('/connector_list/update_view/{id}', 'ConnectorController@update_view')->name('connector_update_view');
    Route::get('/connector_list/upload_photo_view','ConnectorController@upload_connector_photo_view')->name('connector_photo');
    Route::post('/connector_list/upload_photos', 'ConnectorController@upload_photos')->name('upload_photo');
   
//Miniaplicators
    Route::get('/add_miniaplicator_view', 'MiniaplicatorController@index')->name('add_miniaplicator_view');
    Route::post('/add_miniaplicator', 'MiniaplicatorController@create')->name('add_miniaplicator');
    Route::get('/miniaplicator_list_view', 'MiniaplicatorController@miniaplicators_list_view')->name('mini_list_view');
    Route::post('/miniaplicator_list', 'MiniaplicatorController@miniaplicator_list')->name('miniaplicator_list');
    Route::get('/miniaplicator_list/delete/{id}', 'MiniaplicatorController@delete')->name('delete_miniaplicator');
    Route::get('/miniaplicator_list/update_view/{id}', 'MiniaplicatorController@update_view')->name('update_mini_view');
    Route::post('/get_minis_by_connector','MiniaplicatorController@get_minis_by_terminal')->name('minis_by_connect');
//Mini Calibration    
    Route::post('/add_mini_calibration', 'MiniaplicatorController@add_mini_calibration')->name('add_mini_calibration');
    Route::get('/add_mini_calibaration_view' , 'MiniaplicatorController@add_calibration_view')->name('mini_calibration_view');
    Route::post('/mini_calibaration_list' , 'MiniaplicatorController@mini_calibration_list')->name('mini_calibration_list');
    Route::get('/mini_calibaration_list_view' , 'MiniaplicatorController@mini_calibration_list_view')->name('mini_calibration_list_view');
    Route::get('/mini_calibration_delete/{id}','MiniaplicatorController@mini_calibration_delete')->name('mini_calibr_delete');
//Admin Users 
    Route::get('/user/update_view/{id}', 'UserController@update_view');
    Route::get('/users_list', 'UserController@index')->name('usr_list');
    Route::post('/users_update', 'UserController@update')->name('usr_update');
//Validation mini
    Route::get('mini/validations','MiniValidationController@add_validation_view')->name('valid_view');
    Route::post('mini/add_validation','MiniValidationController@add_validation')->name('add_validation');
    Route::get('mini/validations_list_view','MiniValidationController@validation_list_view')->name('valid_list_view');
    Route::get('mini/mini_valid_list_done_view','MiniValidationController@validation_list_done_view')->name('valid_list_done_view');
    Route::post('mini_valid_list','MiniValidationController@validations_list')->name('valid_list');
    Route::post('mini_valid_done_list','MiniValidationController@validations_done_list')->name('valid_done_list');
    Route::get('mini/validation_upload/{id}','MiniValidationController@upload_validation_view')->name('valid_upload_view');
    Route::post('mini/upload_validation','MiniValidationController@upload_validation')->name('upload_valid');
    Route::post('mini/download_validation','MiniValidationController@download_validation')->name('valid_download');
//Interface
    Route::get('/interface','InterfaceController@index')->name('interface_view');
    Route::get('/interface/add','InterfaceController@add_interface_view')->name('add_interface');
    Route::post('/interface/upload','InterfaceController@upload_interfaces')->name('upload_interf');
    Route::post('/interface/get_list','InterfaceController@get_list');
    Route::post('/interface/download', 'InterfaceController@download');
    Route::post('/interface/preview','InterfaceController@get_jpg_by_id');
    Route::get('/interfaces/update_view/{id}','InterfaceController@update_view')->name('interf_update_view');
    Route::post('/interfaces/update','InterfaceController@update_interface')->name('update_interf');
});

//Raport
    Route::get('/raport_view/{date?}', 'RaportController@get_compare_view')->name('raport_view');
    Route::get('/monthly_report/{month?}/{year?}', 'RaportController@monthly_report')->name('monthly_report');
    Route::get('/yearly_report/{year?}','RaportController@yearly_report')->name('yearly_report');
    Route::get('/execut_time_report/{date?}','RaportController@execut_time_report')->name('execut_time_report');
    Route::post('/generate_raport', 'RaportController@generate_raport')->name('generate_raport_aggraf');
    Route::get('/raport_list_view', 'RaportController@report_list_view')->name('report_list_view');
    Route::post('/add_report','RaportController@create_report')->name('create_report');
    Route::post('/all_reports', 'RaportController@get_all')->name('get_all_reports');
    Route::post('/data_exec_time', 'RaportController@get_data_exec_time')->name('exec_time');