<?php

namespace App\Models\masters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Facility extends Model
{
  use HasFactory;
  protected $table = 'facilities';
  protected $fillable = ['location_id', 'facility_name'];
  protected $guarded = ['id'];

  /**
   * Get all of the departments for the Facility
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function departments(): HasMany
  {
    return $this->hasMany(Department::class, 'department_id', 'id');
  }

  /**
   * Get the location that owns the Facility
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function location(): BelongsTo
  {
    return $this->belongsTo(Location::class, 'location_id', 'id');
  }

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
