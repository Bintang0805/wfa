<?php

namespace App\Models\masters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItAsset extends Model
{
  use HasFactory;
  protected $table = "it_assets";
  protected $fillable = [
    "it_asset_type_id",
    "make",
    "model",
    "oem_sl_no",
    "host_name",
    "ip_address",
    "asset_type",
    "os_ver",
    "asset_status",
  ];
  protected $guarded = ["id"];

  public function BaseValidate()
  {
    $fields = $this->fillable;
    $validateData = [];
    foreach ($fields as $field) {
      $combine = [$field => ["required"]];
      array_push($validateData, $combine);
    }
    return $validateData;
  }
}
