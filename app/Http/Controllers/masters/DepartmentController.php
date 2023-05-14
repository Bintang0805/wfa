<?php

namespace App\Http\Controllers\masters;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateDepartmentRequest;
use App\Models\masters\Department;
use App\Models\masters\Facility;
use App\Models\masters\Location;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $data = [
      'departments' => Department::with('facility', 'location')->get(),
      'facilities' => Facility::all(),
    ];

    return view('masters.department.index', $data);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('masters.department.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(CreateDepartmentRequest $request)
  {
    $location = Location::where('id', $request->facility_id)->first();
    $credentials = $request->validated();
    $credentials["location_id"] = $location->id;

    Department::updateOrCreate(["id" => $request->id] ,$credentials);

    return redirect()->route('departments.index');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\masters\Location  $location
   * @return \Illuminate\Http\Response
   */
  public function show(Department $department)
  {
    $data = [
      'department' => $department,
    ];
    return view('masters.department.detail', $data);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\masters\Location  $location
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $department = Department::where('id', $id)->first();

    $data = [
      'department' => $department,
    ];

    $response = [
      'status' => 'success',
      'message' => 'Data retrieved successfully',
      'data' => $data,
    ];

    if ($data['department'] == null) {
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
   * @param  \App\Models\masters\Location  $location
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Department $department)
  {
    // dd($request->all());
    $department->update($request->all());
    return redirect()->route('departments.index');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\masters\Location  $location
   * @return \Illuminate\Http\Response
   */
  public function destroy(Department $department)
  {
    $department->delete();
    return redirect()->route('departments.index');
  }
}
