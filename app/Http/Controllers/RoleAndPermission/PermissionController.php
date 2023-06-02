<?php

namespace App\Http\Controllers\RoleAndPermission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
  public function index()
  {
    return view("role-and-permission.permission.index");
  }
}
