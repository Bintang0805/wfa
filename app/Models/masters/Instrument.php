<?php

namespace App\Models\masters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instrument extends Model
{
  use HasFactory;
  protected $table = 'instruments';
  protected $fillable = [
    "instrument_type_id",
    "instrument_make",
    "instument_model",
    "data_storage",
    "indirect_impact",
    "qualification_status",
    "csv_status",
    "computer_connected",
    "instrument_asset_code",
    "status",
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
