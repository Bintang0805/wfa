<?php

namespace App\Models\masters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstrumentType extends Model
{
  use HasFactory;
  protected $table = 'instrument_types';
  protected $fillable = ['instrument_type'];
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
