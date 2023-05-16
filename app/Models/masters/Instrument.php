<?php

namespace App\Models\masters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Instrument extends Model
{
  use HasFactory;
  protected $table = 'instruments';
  protected $fillable = [
    "location_id",
    "facility_id",
    "department_id",
    "instrument_type_id",
    "instrument_name",
    "instrument_make",
    "instrument_model",
    "data_storage",
    "indirect_impact",
    "qualification_status",
    "csv_status",
    "computer_connected",
    "instrument_asset_code",
    "status",
  ];
  protected $guarded = ["id"];

  /**
   * Get the location that owns the Instrument
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function location(): BelongsTo
  {
      return $this->belongsTo(Location::class, 'location_id', 'id');
  }

  /**
   * Get the facility that owns the Instrument
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function facility(): BelongsTo
  {
      return $this->belongsTo(Facility::class, 'facility_id', 'id');
  }

  /**
   * Get the department that owns the Instrument
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function department(): BelongsTo
  {
      return $this->belongsTo(Department::class, 'department_id', 'id');
  }

  /**
   * Get the instrument_type that owns the Instrument
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function instrument_type(): BelongsTo
  {
      return $this->belongsTo(InstrumentType::class, 'instrument_type_id', 'id');
  }

  public static function getEnumType()
    {
      $data = [
        "data_storage" => ["Yes", "No", "NA"],
        "indirect_impact" => ["Yes", "No", "NA"],
        "qualification_status" => ["Completed", "On Going", "Pending", "NA"],
        "csv_status" => ["Completed", "On Going", "Pending", "NA"],
        "computer_connected" => ["Yes", "No", "NA"],
      ];
      $obj = (object) json_decode(json_encode($data), false);

      return $obj;
    }
}
