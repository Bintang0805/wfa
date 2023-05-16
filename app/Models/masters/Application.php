<?php

namespace App\Models\masters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Application extends Model
{
    use HasFactory;
    protected $table = "applications";
    protected $fillable = [
      "application_name",
      "application_ver",
      "connected_to_computer",
      "location_id",
      "facility_id",
      "department_id",
      "connected_to_server",
      "application_role_type",
      "privilages",
      "manufacturer",
      "gamp_category",
      "csv_status",
      "csv_completed_on",
      "periodic_review",
      "gxp_status",
      "backup_mode",
      "data_type",
      "vendor_details",
      "status",
    ];
    protected $guarded = ["id"];

    /**
     * Get the location that owns the Application
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'location_id', 'id');
    }

    /**
     * Get the facility that owns the Application
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function facility(): BelongsTo
    {
        return $this->belongsTo(Facility::class, 'facility_id', 'id');
    }

    /**
     * Get the department that owns the Application
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    public static function getEnumType()
    {
      $data = [
        "application_role" => ["Single", "Multiple"],
        "gamp_category" => ["1", "2", "3", "4", "5"],
        "csv_status" => ["Completed", "On Going", "Pending", "NA"],
        "gxp_status" => ["Yes", "NO", "NA"],
        "backup_mode" => ["Automatic", "Manual"],
        "data" => ["Flat File", "Database", "NA"],
        "status" => ["Active", "Retired"],
      ];
      $obj = (object) json_decode(json_encode($data), false);

      return $obj;
    }
}
