<?php

namespace App\Http\Controllers\masters;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateInstrumentTypeRequest;
use App\Models\masters\InstrumentType;
use Illuminate\Http\Request;

class InstrumentTypeController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $data = [
      'instrument_types' => InstrumentType::all(),
    ];
    return view('masters.instrument-type.index', $data);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('masters.instrument-type.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(CreateInstrumentTypeRequest $request)
  {
    $credentials = $request->validated();
    InstrumentType::updateOrCreate(['id' => $request->id], $credentials);

    if ($request->id == null) {
      $successMessage = 'Instrument Type Created Successfully';
    } else {
      $successMessage = 'Instrument Type Updated Successfully';
    }

    return redirect()
      ->route('instrument-types.index')
      ->with('success', $successMessage);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\masters\Location  $location
   * @return \Illuminate\Http\Response
   */
  public function show(InstrumentType $instrument_type)
  {
    $data = [
      'instrument_type' => $instrument_type,
    ];
    return view('masters.instrument-type.detail', $data);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\masters\Location  $location
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $instrument_type = InstrumentType::where('id', $id)->first();

    $data = [
      'instrument_type' => $instrument_type,
    ];

    $response = [
      'status' => 'success',
      'message' => 'Data retrieved successfully',
      'data' => $data,
    ];

    if ($data['instrument_type'] == null) {
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
  public function update(Request $request, InstrumentType $instrument_type)
  {
    // dd($request->all());
    $instrument_type->update($request->all());
    return redirect()->route('instrument-types.index');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\masters\Location  $location
   * @return \Illuminate\Http\Response
   */
  public function destroy(InstrumentType $instrument_type)
  {
    $instrument_type->delete();
    return redirect()
      ->route('instrument-types.index')
      ->with('success', 'Instrument Type Deleted Successfully');
  }

  public function AJAXGetAll() {
    $data = InstrumentType::all();

    return response()->json(["data" => $data]);
  }
}
