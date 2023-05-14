<?php

use App\Http\Controllers\masters\ApplicationController;
use App\Http\Controllers\masters\CompanyController;
use App\Http\Controllers\masters\DepartmentController;
use App\Http\Controllers\masters\EquipmentController;
use App\Http\Controllers\masters\EquipmentTypeController;
use App\Http\Controllers\masters\FacilityController;
use App\Http\Controllers\masters\InstrumentController;
use App\Http\Controllers\masters\InstrumentTypeController;
use App\Http\Controllers\masters\ItAssetController;
use App\Http\Controllers\masters\ItAssetTypeController;
use App\Http\Controllers\masters\LocationController;
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

$controller_path = 'App\Http\Controllers';

// Main Page Route
Route::get('/', $controller_path . '\pages\HomePage@index')->name('pages-home');
Route::get('/page-2', $controller_path . '\pages\Page2@index')->name('pages-page-2');

// pages
Route::get('/pages/misc-error', $controller_path . '\pages\MiscError@index')->name('pages-misc-error');

// Master
Route::resource('companies', CompanyController::class);

Route::resource('locations', LocationController::class);
Route::get('user-list', [LocationController::class, "list"]);

Route::resource('departments', DepartmentController::class);
Route::resource('facilities', FacilityController::class);
Route::resource('equipment-types', EquipmentTypeController::class);
Route::resource('equipments', EquipmentController::class);
Route::resource('instrument-types', InstrumentTypeController::class);
Route::resource('instruments', InstrumentController::class);
Route::resource('it-asset-types', ItAssetTypeController::class);
Route::resource('it-assets', ItAssetController::class);
Route::resource('applications', ApplicationController::class);
