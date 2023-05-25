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
    // if($request->id != null) {
    //   unset($request["ip_address"]);
    //   unset($request["host_name"]);
    // } else {
    //   $request->validate([
    //     "ip_address" => ["unique:it_assets,ip_address"],
    //     "host_name" => ["unique:it_assets,host_name"],
    //   ]);
    // }
    // dd($request->all());
    $department = Department::where('id', $request->department_id)->first();


    $credentials = $request->validated();
    $credentials['location_id'] = $department->location_id;
    $credentials['facility_id'] = $department->facility_id;

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
    $it_asset = ItAsset::with('location', 'facility', 'department', 'it_asset_type')
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

    if ($data['it_asset'] == null) {
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
    if($itAsset == null) return redirect()->route('it-assets.index')->withErrors("Data with Id" . $itAsset->id . "Not found");

    $itAsset->delete();
    return redirect()->route('it-assets.index')->with("success", "IT Asset Deleted Successfully");
  }

  public function AJAXGetAll() {
    $data = ItAsset::all();

    return response()->json(["data" => $data]);
  }
}
