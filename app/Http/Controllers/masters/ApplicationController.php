<?php

namespace App\Http\Controllers\masters;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateApplicationRequest;
use App\Models\masters\Application;
use App\Models\masters\Department;
use App\Models\masters\Facility;
use App\Models\masters\Location;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $enum_types = Application::getEnumType();
    $data = [
      'applications' => Application::with('location', 'facility', 'department')->get(),
      'departments' => Department::all(),
      'application_role_types' => $enum_types->application_role,
      'gamp_category_types' => $enum_types->gamp_category,
      'csv_status_types' => $enum_types->csv_status,
      'gxp_status_types' => $enum_types->gxp_status,
      'backup_mode_types' => $enum_types->backup_mode,
      'data_types' => $enum_types->data,
      'status_types' => $enum_types->status,
    ];

    return view('masters.application.index', $data);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(CreateApplicationRequest $request)
  {

    $department = Department::where('id', $request->department_id)->first();
    $facility = Facility::where('id', $department->facility_id)->first();
    $location = Location::where('id', $facility->location_id)->first();

    $credentials = $request->validated();
    $credentials['location_id'] = $location->id;
    $credentials['facility_id'] = $facility->id;
    Application::updateOrCreate(['id' => $request->id], $credentials);

    if ($request->id == null) {
      $successMessage = 'Application Created Successfully';
    } else {
      $successMessage = 'Application Updated Successfully';
    }

    return redirect()
      ->route('applications.index')
      ->with('success', $successMessage);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\masters\Application  $application
   * @return \Illuminate\Http\Response
   */
  public function show(Application $application)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\masters\Application  $application
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $application = Application::with('location', 'facility', 'department')
      ->where('id', $id)
      ->first();

    $data = [
      'application' => $application,
    ];

    $response = [
      'status' => 'success',
      'message' => 'Data retrieved successfully',
      'data' => $data,
    ];

    if ($data['application'] == null) {
      return response()->json(
        [
          'status' => 'failed',
          'message' => 'failed retrieved Data',
          'data' => null,
        ],
        404
      );
    }
    return response()->json($response, 200);
    // return view('masters.location.edit', $data);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\masters\Application  $application
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Application $application)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\masters\Application  $application
   * @return \Illuminate\Http\Response
   */
  public function destroy(Application $application)
  {
    $application->delete();
    return redirect()
      ->route('applications.index')
      ->with('success', 'Application Deleted Successfully');
  }

  public function AJAXGetAll() {
    $data = Application::all();

    return response()->json(["data" => $data]);
  }
}
