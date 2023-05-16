<?php

namespace App\Http\Controllers\masters;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateItAssetRequest;
use App\Models\masters\Department;
use App\Models\masters\Facility;
use App\Models\masters\ItAsset;
use App\Models\masters\ItAssetType;
use App\Models\masters\Location;
use Illuminate\Http\Request;

class ItAssetController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $enum_types = ItAsset::getEnumType();
    $data = [
      'it_assets' => ItAsset::with('location', 'facility', 'department', 'it_asset_type')->get(),
      'departments' => Department::all(),
      'it_asset_types' => ItAssetType::all(),
      'asset_types' => $enum_types->asset_type,
      'asset_status' => $enum_types->asset_status,
    ];

    return view('masters.it-asset.index', $data);
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
  public function store(CreateItAssetRequest $request)
  {
    // dd($request->all());
    $department = Department::where('id', $request->department_id)->first();
    $facility = Facility::where('id', $department->id)->first();
    $location = Location::where('id', $facility->id)->first();

    $credentials = $request->validated();
    $credentials['location_id'] = $location->id;
    $credentials['facility_id'] = $facility->id;
    ItAsset::updateOrCreate(['id' => $request->id], $credentials);

    if ($request->id == null) {
      $successMessage = 'IT Asset Created Successfully';
    } else {
      $successMessage = 'IT Asset Updated Successfully';
    }

    return redirect()->route('it-assets.index')->with("success", $successMessage);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\masters\ItAsset  $itAsset
   * @return \Illuminate\Http\Response
   */
  public function show(ItAsset $itAsset)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\masters\ItAsset  $itAsset
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $it_asset = ItAsset::with('location', 'facility', 'department')
      ->where('id', $id)
      ->first();

    $data = [
      'it_asset' => $it_asset,
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
   * @param  \App\Models\masters\ItAsset  $itAsset
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, ItAsset $itAsset)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\masters\ItAsset  $itAsset
   * @return \Illuminate\Http\Response
   */
  public function destroy(ItAsset $itAsset)
  {
    $itAsset->delete();
    return redirect()->route('it-assets.index')->with("success", "IT Asset Deleted Successfully");
  }
}
