<?php

namespace App\Models\masters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItAssetType extends Model
{
  use HasFactory;
  protected $table = 'it_asset_types';
  protected $fillable = ['it_asset_type'];
  protected $guarded = ['id'];

  public function BaseValidate()
  {
    $fields = $this->fillable;
    $validateData = [];
    foreach ($fields as $field) {
      $combine = [$field => ['required']];
      array_push($validateData, $combine);
    }
    return $validateData;
  }
}
