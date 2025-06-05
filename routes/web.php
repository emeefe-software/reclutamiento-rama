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

Auth::routes();

Route::middleware('guest')->group(function(){
    Route::get('/', 'WelcomeController@welcome')->name('welcome');
    Route::get('entrevistas/agendar', 'InterviewController@scheduleByGuest')->name('interviews.schedule');
    Route::post('entrevistas','InterviewController@store')->name('agendar');
});

Route::prefix('dashboard')->as('dashboard.')->group(function(){
    Route::get('/', 'Dashboard\HomeController@index')->name('home');
});

Route::get('storage/{path}', 'StorageController@getFile')->where('path', '^(?!img\/.*$).*')->name('storage.getFile');


//Rutas compartidas por admin y responsable
Route::middleware('role:admin|responsable')->group(function(){
    Route::get('candidates','UserController@candidates')->name('candidates');
    Route::resources([
        'universities'=>'UniversityController',
        'hours'=>'HourController',
        'careers' => 'CareerController',
        'interviews'=>'InterviewController',
        'programs'=>'ProgramController',
    ]);
});


Route::prefix('admin')->middleware('role:admin')->group(function(){
    Route::get('settings','SettingController@index')->name('settings');
    Route::post('settings/save','SettingController@save')->name('settings.save');
    Route::post('programs/asociate/edit', 'ProgramController@asociateEdit')->name('programs.asociateEdit');
    Route::get('programs/asociate', 'ProgramController@asociate')->name('programs.asociate');
    Route::post('programs/asociate', 'ProgramController@asociateStore')->name('programs.asociate.store');
    Route::post('programs/asociate/update', 'ProgramController@asociateUpdate')->name('programs.asociate.update');
    Route::post('programs/asociate/delete', 'ProgramController@asociateDestroy')->name('programs.asociate.destroy');
    Route::put('programs/{program}/paused', 'ProgramController@isPaused')->name('programs.ispaused');
    Route::post('notes/create','NoteController@store')->name('notes.create');
    //registros de usuario
    Route::get('users/{user}/registers', 'RegisterController@index')->name('users.registers.index');
    Route::post('users/registers', 'RegisterController@store')->name('users.registers.store');
    Route::delete('users/registers/destroy/{id}', 'RegisterController@destroy')->name('users.registers.destroy');
    Route::put('users/registers/{id}', 'RegisterController@update')->name('users.registers.update');

    Route::put('users/{user}/activate', 'UserController@activate')->name('users.activate');
    Route::put('users/{user}/lock', 'UserController@lock')->name('users.lock');
    Route::put('users/{user}/disable', 'UserController@disable')->name('users.disable');
    Route::resources([
        'users'=>'UserController',
    ]);
});

Route::prefix('responsable')->middleware('role:responsable|admin')->group(function(){
    Route::get('interviews/agendar', 'InterviewController@scheduleByResponsable')->name('interviews');
    Route::post('interviews','InterviewController@storeManual')->name('agendarResponsable');
});

Route::prefix('practicing')->middleware('role:practicing')->group(function(){
    Route::get('hours', 'HoursController@hours')->name('user.hours');
});

Route::post('check', 'RegisterController@check')->name('check');
Route::post('food', 'FoodController@food')->name('food');

Route::get('comidas', 'FoodController@comidas')->name('foods.comidas');
Route::prefix('foods')->name('foods.')->group(function(){
    Route::post('/{food}/pay', 'FoodController@pay')->name('pay')->middleware('permission:manage_food_payments')->middleware('role:admin');
    Route::get('confirm', 'FoodController@askConfirm')->name('confirm')->middleware('role:practicing');
    Route::post('confirm', 'FoodController@confirm')->name('confirm')->middleware('role:practicing');
    Route::resource('/', 'FoodController')->middleware('role:admin');
});