<?php

namespace App\Http\Controllers\masters;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateEquipmentTypeRequest;
use App\Models\masters\EquipmentType;
use Illuminate\Http\Request;

class EquipmentTypeController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $data = [
      'equipment_types' => EquipmentType::all(),
    ];
    return view('masters.equipment-type.index', $data);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('masters.equipment-type.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(CreateEquipmentTypeRequest $request)
  {
    $credentials = $request->validated();
    EquipmentType::updateOrCreate(['id' => $request->id], $credentials);

    return redirect()->route('equipment-types.index');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\masters\Location  $location
   * @return \Illuminate\Http\Response
   */
  public function show(EquipmentType $equipment_type)
  {
    $data = [
      'equipment_type' => $equipment_type,
    ];
    return view('masters.equiment-type.detail', $data);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\masters\Location  $location
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $equipment_type = EquipmentType::where('id', $id)->first();

    $data = [
      'equipment_type' => $equipment_type,
    ];

    $response = [
      'status' => 'success',
      'message' => 'Data retrieved successfully',
      'data' => $data,
    ];

    if ($data['equipment_type'] == null) {
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
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\masters\Location  $location
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, EquipmentType $equipment_type)
  {
    // dd($request->all());
    $equipment_type->update($request->all());
    return redirect()->route('equipment-types.index');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\masters\Location  $location
   * @return \Illuminate\Http\Response
   */
  public function destroy(EquipmentType $equipment_type)
  {
    $equipment_type->delete();
    return redirect()->route('equipment-types.index');
  }
}
