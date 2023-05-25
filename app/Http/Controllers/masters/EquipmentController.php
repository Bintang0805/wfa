<?php

namespace App\Http\Controllers\masters;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateEquipmentRequest;
use App\Models\masters\Department;
use App\Models\masters\Equipment;
use App\Models\masters\EquipmentType;
use App\Models\masters\Facility;
use App\Models\masters\Location;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $enum_types = Equipment::getEnumType();
    $data = [
      'equipments' => Equipment::with('location', 'facility', 'department', 'equipment_type')->get(),
      'departments' => Department::all(),
      'equipment_types' => EquipmentType::all(),
      'data_storage_types' => $enum_types->data_storage,
      'indirect_impact_types' => $enum_types->indirect_impact,
      'qualification_status_types' => $enum_types->qualification_status,
      'csv_status_types' => $enum_types->csv_status,
    ];

    return view('masters.equipment.index', $data);
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
  public function store(CreateEquipmentRequest $request)
  {
    // dd($request->all());
    $department = Department::where('id', $request->department_id)->first();
    // $facility = Facility::where('id', $department->id)->first();
    // $location = Location::where('id', $facility->id)->first();

    $credentials = $request->validated();
    $credentials['location_id'] = $department->location_id;
    $credentials['facility_id'] = $department->facility_id;

    Equipment::updateOrCreate(['id' => $request->id], $credentials);

    if ($request->id == null) {
      $successMessage = 'Equipment Created Successfully';
    } else {
      $successMessage = 'Equipment Updated Successfully';
    }

    return redirect()
      ->route('equipments.index')
      ->with('success', $successMessage);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\masters\Equipment  $equipment
   * @return \Illuminate\Http\Response
   */
  public function show(Equipment $equipment)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\masters\Equipment  $equipment
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $equipment = Equipment::with('location', 'facility', 'department', 'equipment_type')
      ->where('id', $id)
      ->first();

    $data = [
      'equipment' => $equipment,
    ];

    $response = [
      'status' => 'success',
      'message' => 'Data retrieved successfully',
      'data' => $data,
    ];

    if ($data['equipment'] == null) {
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
   * @param  \App\Models\masters\Equipment  $equipment
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Equipment $equipment)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\masters\Equipment  $equipment
   * @return \Illuminate\Http\Response
   */
  public function destroy(Equipment $equipment)
  {
    if($equipment == null) return redirect()->route('equipments.index')->withErrors("Data with Id" . $equipment->id . "Not found");

    $equipment->delete();
    return redirect()->route('equipments.index')->with("success", "Equipment Deleted Successfully");
  }

  public function AJAXGetAll() {
    $data = Equipment::all();

    return response()->json(["data" => $data]);
  }
}
