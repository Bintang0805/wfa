<?php

namespace App\Models\masters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Equipment extends Model
{
    use HasFactory;
    protected $table = "equipments";
    protected $fillable = [
      "location_id",
      "facility_id",
      "department_id",
      "equipment_type_id",
      "equipment_name",
      "equipment_make",
      "equipment_model",
      "data_storage",
      "indirect_impact",
      "qualification_status",
      "csv_status",
      "equipment_number",
      "status",
    ];
    protected $guarded = ["id"];

    /**
     * Get the location that owns the Equipment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'location_id', 'id');
    }

    /**
     * Get the facility that owns the Equipment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function facility(): BelongsTo
    {
        return $this->belongsTo(Facility::class, 'facility_id', 'id');
    }

    /**
     * Get the department that owns the Equipment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    /**
     * Get the equipment_type that owns the Equipment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function equipment_type(): BelongsTo
    {
        return $this->belongsTo(EquipmentType::class, 'equipment_type_id', 'id');
    }

    public static function getEnumType()
    {
      $data = [
        "data_storage" => ["Yes", "No", "NA"],
        "indirect_impact" => ["Yes", "No", "NA"],
        "qualification_status" => ["Completed", "On Going", "Pending", "NA"],
        "csv_status" => ["Completed", "On Going", "Pending", "NA"] ,
      ];
      $obj = (object) json_decode(json_encode($data), false);

      return $obj;
    }
}
