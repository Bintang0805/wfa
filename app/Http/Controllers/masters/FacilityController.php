<?php

namespace App\Http\Controllers\masters;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateFacilityRequest;
use App\Models\masters\Facility;
use App\Models\masters\Location;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $facilities = Facility::with('departments')->get();
    $departmentCount = 0;
    foreach ($facilities as $f) {
      $departmentCount += $f->departments->count();
    }

    $data = [
      'facilities' => Facility::with('location')->get(),
      'locations' => Location::all(),
      'departmentCount' => $departmentCount
    ];
    return view('masters.facility.index', $data);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('masters.facility.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(CreateFacilityRequest $request)
  {
    $credentials = $request->validated();
    Facility::updateOrCreate(['id' => $request->id], $credentials);

    if ($request->id == null) {
      $successMessage = 'Facility Created Successfully';
    } else {
      $successMessage = 'Facility Updated Successfully';
    }

    return redirect()
      ->route('facilities.index')
      ->with('success', $successMessage);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\masters\Location  $location
   * @return \Illuminate\Http\Response
   */
  public function show(Facility $facility)
  {
    $data = [
      'facility' => $facility,
    ];
    return view('masters.facility.detail', $data);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\masters\Location  $location
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $facility = Facility::where('id', $id)->first();

    $data = [
      'facility' => $facility,
    ];

    $response = [
      'status' => 'success',
      'message' => 'Data retrieved successfully',
      'data' => $data,
    ];

    if ($data['facility'] == null) {
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
  public function update(Request $request, Facility $facility)
  {
    // dd($request->all());
    $facility->update($request->all());
    return redirect()->route('facilities.index');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\masters\Location  $location
   * @return \Illuminate\Http\Response
   */
  public function destroy(Facility $facility)
  {
    $facility->delete();
    return redirect()
      ->route('facilities.index')
      ->with('success', 'Facility Deleted Successfully');
  }
}
