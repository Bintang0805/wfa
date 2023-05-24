<?php

namespace App\Http\Controllers\masters;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateInstrumentRequest;
use App\Models\masters\Department;
use App\Models\masters\Facility;
use App\Models\masters\Instrument;
use App\Models\masters\InstrumentType;
use App\Models\masters\Location;
use Illuminate\Http\Request;

class InstrumentController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $enum_types = Instrument::getEnumType();
    $data = [
      'instruments' => Instrument::with('location', 'facility', 'department', 'instrument_type')->get(),
      'departments' => Department::all(),
      'instrument_types' => InstrumentType::all(),
      'data_storage_types' => $enum_types->data_storage,
      'indirect_impact_types' => $enum_types->indirect_impact,
      'qualification_status_types' => $enum_types->qualification_status,
      'csv_status_types' => $enum_types->csv_status,
      'computer_connected_types' => $enum_types->computer_connected,
    ];

    return view('masters.instrument.index', $data);
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
  public function store(CreateInstrumentRequest $request)
  {
    // dd($request->all());
    $department = Department::where('id', $request->department_id)->first();
    $facility = Facility::where('id', $department->id)->first();
    $location = Location::where('id', $facility->id)->first();

    $credentials = $request->validated();
    $credentials['location_id'] = $location->id;
    $credentials['facility_id'] = $facility->id;
    Instrument::updateOrCreate(['id' => $request->id], $credentials);

    if ($request->id == null) {
      $successMessage = 'Instrument Created Successfully';
    } else {
      $successMessage = 'Instrument Updated Successfully';
    }

    return redirect()->route('instruments.index')->with("success", $successMessage);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\masters\Instrument  $instrument
   * @return \Illuminate\Http\Response
   */
  public function show(Instrument $instrument)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\masters\Instrument  $instrument
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $instrument = Instrument::with('location', 'facility', 'department', 'instrument_type')
      ->where('id', $id)
      ->first();

    $data = [
      'instrument' => $instrument,
    ];

    $response = [
      'status' => 'success',
      'message' => 'Data retrieved successfully',
      'data' => $data,
    ];

    if ($data['instrument'] == null) {
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
   * @param  \App\Models\masters\Instrument  $instrument
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Instrument $instrument)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\masters\Instrument  $instrument
   * @return \Illuminate\Http\Response
   */
  public function destroy(Instrument $instrument)
  {
    $instrument->delete();
    return redirect()->route('instruments.index')->with("success", "Intrument Deleted Successfully");
  }

  public function AJAXGetAll() {
    $data = Instrument::all();

    return response()->json(["data" => $data]);
  }
}
