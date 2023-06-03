<?php

use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\masters\ApplicationController;
use App\Http\Controllers\masters\CompanyController;
use App\Http\Controllers\masters\DepartmentController;
use App\Http\Controllers\masters\EquipmentController;
use App\Http\Controllers\masters\EquipmentTypeController;
use App\Http\Controllers\masters\FacilityController;
use App\Http\Controllers\masters\FormFieldController;
use App\Http\Controllers\masters\InstrumentController;
use App\Http\Controllers\masters\InstrumentTypeController;
use App\Http\Controllers\masters\ItAssetController;
use App\Http\Controllers\masters\ItAssetTypeController;
use App\Http\Controllers\masters\LocationController;
use App\Http\Controllers\RoleAndPermission\PermissionController;
use App\Http\Controllers\User\RoleController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Workflow\RequestFormController;
use App\Http\Controllers\Workflow\WorkflowApproverController;
use App\Http\Controllers\Workflow\WorkflowController;
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

Route::get("/", [AuthController::class, "login"]);

// Auth
Route::get("auth/login", [AuthController::class, "login"])->name("auth.login");
Route::get("auth/register", [AuthController::class, "register"]);
Route::post("auth/authenticate", [AuthController::class, "authenticate"])->name("auth.authenticate");
Route::get("auth/logout", [AuthController::class, "logout"])->name("auth.logout");

// // Role And Permission
// // Route::resource("role-and-permission/roles", RoleController::class);
// Route::resource("role-and-permission/permissions", PermissionController::class);


Route::middleware("auth")->group(function () {
  // User Management
  Route::get('/user/user-managements', [UserController::class, 'UserManagement'])->name('user-management');
  Route::resource('/user-list', UserController::class);
  Route::resource("user/roles", RoleController::class);


  // Master
  Route::resource('companies', CompanyController::class);

  Route::resource('locations', LocationController::class);

  Route::resource('departments', DepartmentController::class);
  Route::resource('facilities', FacilityController::class);
  Route::resource('equipment-types', EquipmentTypeController::class);
  Route::resource('equipments', EquipmentController::class);
  Route::resource('instrument-types', InstrumentTypeController::class);
  Route::resource('instruments', InstrumentController::class);
  Route::resource('it-asset-types', ItAssetTypeController::class);
  Route::resource('it-assets', ItAssetController::class);
  Route::resource('applications', ApplicationController::class);
  Route::resource("form-fields", FormFieldController::class);
  Route::resource("request-forms", RequestFormController::class);
  Route::resource("workflows", WorkflowController::class);
  Route::resource("workflow-approvers", WorkflowApproverController::class);
  Route::get("request-forms/create/{workflow_id}", [RequestFormController::class, "create"])->name("request-forms.create-custom");
  
});


// Main Page Route
Route::get('/', $controller_path . '\pages\HomePage@index')->name('pages-home');
Route::get('/page-2', $controller_path . '\pages\Page2@index')->name('pages-page-2');

// pages
Route::get('/pages/misc-error', $controller_path . '\pages\MiscError@index')->name('pages-misc-error');



// AJAX
Route::get('AJAX/locations/AJAXGetAll', [LocationController::class, "AJAXGetAll"]);
Route::get('AJAX/facilities/AJAXGetAll', [FacilityController::class, "AJAXGetAll"]);
Route::get('AJAX/departments/AJAXGetAll', [DepartmentController::class, "AJAXGetAll"]);
Route::get('AJAX/equipment-types/AJAXGetAll', [EquipmentTypeController::class, "AJAXGetAll"]);
Route::get('AJAX/instrument-types/AJAXGetAll', [InstrumentTypeController::class, "AJAXGetAll"]);
Route::get('AJAX/instruments/AJAXGetAll', [InstrumentController::class, "AJAXGetAll"]);
Route::get('AJAX/equipments/AJAXGetAll', [EquipmentController::class, "AJAXGetAll"]);
Route::get('AJAX/it-asset-types/AJAXGetAll', [ItAssetTypeController::class, "AJAXGetAll"]);
Route::get('AJAX/it-assets/AJAXGetAll', [ItAssetController::class, "AJAXGetAll"]);
Route::get('AJAX/applications/AJAXGetAll', [ApplicationController::class, "AJAXGetAll"]);
Route::get('AJAX/request-forms/AJAXGetAll', [RequestFormController::class, "AJAXGetAll"]);
Route::get('AJAX/roles/AJAXGetAll', [RoleController::class, "AJAXGetAll"]);
