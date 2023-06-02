<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateRoleRequest;
use App\Models\User\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $data = [
      "roles" => Role::all(),
    ];
    return view("user.role.index", $data);
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
  public function store(CreateRoleRequest $request)
  {
    $credentials = $request->validated();
    Role::updateOrCreate(['id' => $request->id], $credentials);
    if ($request->id == null) {
      $successMessage = 'Role Created Successfully';
    } else {
      $successMessage = 'Role Updated Successfully';
    }

    return redirect()
      ->route('roles.index')
      ->with('success', $successMessage);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\User\Role  $role
   * @return \Illuminate\Http\Response
   */
  public function show(Role $role)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\User\Role  $role
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $role = Role::where('id', $id)->first();

    $data = [
      'role' => $role,
    ];

    $response = [
      'status' => 'success',
      'message' => 'Data retrieved successfully',
      'data' => $data,
    ];

    if ($data['role'] == null) {
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
   * @param  \App\Models\User\Role  $role
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Role $role)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\User\Role  $role
   * @return \Illuminate\Http\Response
   */
  public function destroy(Role $role)
  {
    if ($role == null) return redirect()->route('roles.index')->withErrors("Data with Id" . $role->id . "Not found");

    $role->delete();
    return redirect()
      ->route('roles.index')
      ->with('success', 'Role Deleted Successfully');
  }

  public function AJAXGetAll()
  {
    $data = Role::all();

    return response()->json(["data" => $data]);
  }
}
