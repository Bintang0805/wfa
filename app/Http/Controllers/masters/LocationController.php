<?php

namespace App\Http\Controllers\masters;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateLocationRequest;
use App\Models\masters\Company;
use App\Models\masters\Location;
use App\Models\User;
use Illuminate\Http\Request;

class LocationController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $locations = Location::with('facilities')->get();
    $facilityCount = 0;
    foreach ($locations as $l) {
      $facilityCount += $l->facilities->count();
    }

    $locations = Location::with('departments')->get();
    $departmentCount = 0;
    foreach ($locations as $l) {
      $departmentCount += $l->facilities->count();
    }

    $data = [
      'locations' => Location::with('company', 'facilities', 'departments')->get(),
      'facilityCount' => $facilityCount,
      'departmentCount' => $departmentCount,
      'companies' => Company::all(),
    ];
    return view('masters.location.index', $data);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('masters.location.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(CreateLocationRequest $request)
  {
    $credentials = $request->validated();
    Location::updateOrCreate(['id' => $request->id], $credentials);
    if ($request->id == null) {
      $successMessage = 'Location Created Successfully';
    } else {
      $successMessage = 'Location Updated Successfully';
    }

    return redirect()
      ->route('locations.index')
      ->with('success', $successMessage);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\masters\Location  $location
   * @return \Illuminate\Http\Response
   */
  public function show(Location $location)
  {
    $data = [
      'location' => $location,
    ];
    return view('masters.location.detail', $data);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\masters\Location  $location
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $location = Location::with('company')
      ->where('id', $id)
      ->first();

    $data = [
      'location' => $location,
    ];

    $response = [
      'status' => 'success',
      'message' => 'Data retrieved successfully',
      'data' => $data,
    ];

    if ($data['location'] == null) {
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
  public function update(Request $request, Location $location)
  {
    // dd($request->all());
    $location->update($request->all());
    return redirect()->route('locations.index');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\masters\Location  $location
   * @return \Illuminate\Http\Response
   */
  public function destroy(Location $location)
  {
    $location->delete();
    return redirect()
      ->route('locations.index')
      ->with('success', 'Location Deleted Successfully');
  }

  public function checkLocationNameUniqueness(Request $request)
  {
    $locationName = $request->input('locationName');

    // Mengecek keunikan "location_name" dalam database
    $exists = Location::where('location_name', $locationName)->exists();

    return response()->json(['exists' => $exists]);
  }

  public function AJAXGetAll() {
    $data = Location::all();

    return response()->json(["data" => $data]);
  }
}
