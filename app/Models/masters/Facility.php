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
    return $this->hasMany(Department::class, 'facility_id', 'id');
  }

  /**
   * Get all of the equipments for the Facility
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function equipments(): HasMany
  {
      return $this->hasMany(Equipment::class, 'facility_id', 'id');
  }

  /**
   * Get all of the instruments for the Facility
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function instruments(): HasMany
  {
      return $this->hasMany(Instrument::class, 'facility_id', 'id');
  }

  /**
   * Get all of the it_assets for the Facility
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function it_assets(): HasMany
  {
      return $this->hasMany(ItAsset::class, 'facility_id', 'id');
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
}
