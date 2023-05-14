<?php

namespace App\Models\masters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;
    protected $table = "equipments";
    protected $fillable = [
      "department_id",
      "equipment_type_id",
      "equipment_name",
      "equipment_make",
      "equiment_model",
      "data_storage",
      "indirect_impact",
      "qualification_status",
      "csv_status",
      "equiment_number",
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
