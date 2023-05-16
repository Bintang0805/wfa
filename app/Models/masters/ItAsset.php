<?php

namespace App\Models\masters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItAsset extends Model
{
  use HasFactory;
  protected $table = "it_assets";
  protected $fillable = [
    "location_id",
    "facility_id",
    "department_id",
    "it_asset_type_id",
    "make",
    "model",
    "oem_sl_no",
    "host_name",
    "ip_address",
    "asset_type",
    "os_ver",
    "asset_status",
    "owner_name",
  ];
  protected $guarded = ["id"];

  /**
   * Get the location that owns the ItAsset
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function location(): BelongsTo
  {
      return $this->belongsTo(Location::class, 'location_id', 'id');
  }

  /**
   * Get the facility that owns the ItAsset
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function facility(): BelongsTo
  {
      return $this->belongsTo(Facility::class, 'facility_id', 'id');
  }

  /**
   * Get the department that owns the ItAsset
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function department(): BelongsTo
  {
      return $this->belongsTo(Department::class, 'department_id', 'id');
  }

  /**
   * Get the it_asset_type that owns the ItAsset
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function it_asset_type(): BelongsTo
  {
      return $this->belongsTo(ItAssetType::class, 'it_asset_type_id', 'id');
  }

  public static function getEnumType()
    {
      $data = [
        "asset_type" => ["GMP", "Non GMP"],
        "asset_status" => ["Active", "Retired", "Stock"],
      ];
      $obj = (object) json_decode(json_encode($data), false);

      return $obj;
    }
}
