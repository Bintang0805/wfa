<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateRoleRequest;
use App\Models\User\Role;
use Spatie\Permission\Models\Role as SpatieRole;
use Spatie\Permission\Models\Permission as SpatiePermission;
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
    $SpatiePermissions = SpatiePermission::all();
    $permissions = [];
    foreach ($SpatiePermissions as $SpatiePermission) {
      $SpatiePermissionEx = explode("-", $SpatiePermission->name);
      if (array_key_exists($SpatiePermissionEx[1], $permissions)) {
        $newPermission = [
          "permission" => $SpatiePermission,
          "function" => $SpatiePermissionEx[0]
        ];

        array_push($permissions[$SpatiePermissionEx[1]], $newPermission);
      } else {
        $newPermission = [
          "permission" => $SpatiePermission,
          "function" => $SpatiePermissionEx[0]
        ];

        $permissions[$SpatiePermissionEx[1]] = [$newPermission];
      }
    }

    $data = [
      "roles" => Role::all(),
      "permissions" => $permissions
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
    $roles = [
      "name" => $request->role_name,
      "guard_name" => "web"
    ];

    $role = SpatieRole::updateOrCreate(['id' => $request->id], $roles);

    if(!$role) {
      return redirect()->route("roles.index")->withErrors("Failed To Add New Role");
    }

    $role->givePermissionTo($request->permission);
    
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
    $role = SpatieRole::where("id", $id)->with("permissions")->first();

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
