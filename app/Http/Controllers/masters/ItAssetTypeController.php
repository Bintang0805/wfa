<?php

namespace App\Http\Controllers\masters;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateItAssetTypeRequest;
use App\Models\masters\ItAssetType;
use Illuminate\Http\Request;

class ItAssetTypeController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $data = [
      'it_asset_types' => ItAssetType::all(),
    ];
    return view('masters.it-asset-type.index', $data);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('masters.it-asset-type.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(CreateItAssetTypeRequest $request)
  {
    $credentials = $request->validated();
    ItAssetType::updateOrCreate(['id' => $request->id], $credentials);

    if ($request->id == null) {
      $successMessage = 'IT Asset Type Created Successfully';
    } else {
      $successMessage = 'IT Asset Type Updated Successfully';
    }

    return redirect()
      ->route('it-asset-types.index')
      ->with('success', $successMessage);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\masters\Location  $location
   * @return \Illuminate\Http\Response
   */
  public function show(ItAssetType $it_asset_type)
  {
    $data = [
      'it_asset_type' => $it_asset_type,
    ];
    return view('masters.it-asset-type.detail', $data);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\masters\Location  $location
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $it_asset_type = ItAssetType::where('id', $id)->first();

    $data = [
      'it_asset_type' => $it_asset_type,
    ];

    $response = [
      'status' => 'success',
      'message' => 'Data retrieved successfully',
      'data' => $data,
    ];

    if ($data['it_asset_type'] == null) {
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
  public function update(Request $request, ItAssetType $it_asset_type)
  {
    // dd($request->all());
    $it_asset_type->update($request->all());
    return redirect()->route('it-asset-types.index');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\masters\Location  $location
   * @return \Illuminate\Http\Response
   */
  public function destroy(ItAssetType $it_asset_type)
  {
    if($it_asset_type == null) return redirect()->route('it-asset-types.index')->withErrors("Data with Id" . $it_asset_type->id . "Not found");

    $it_asset_type->delete();
    return redirect()
      ->route('it-asset-types.index')
      ->with('success', 'IT Asset Type Deleted Succesfully');
  }

  public function AJAXGetAll() {
    $data = ItAssetType::all();

    return response()->json(["data" => $data]);
  }
}
