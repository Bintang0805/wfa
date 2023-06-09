<?php

namespace App\Models\masters;

use Illuminate\Contracts\Support\ValidatedData;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
  use HasFactory;
  protected $table = 'locations';
  protected $fillable = ['company_id', 'location_name'];
  protected $guarded = ['id'];

  /**
   * Get all of the facilities for the Location
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function facilities(): HasMany
  {
    return $this->hasMany(Facility::class, 'location_id', 'id');
  }

  /**
   * Get all of the departments for the Location
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function departments(): HasMany
  {
      return $this->hasMany(Department::class, 'location_id', 'id');
  }

  /**
   * Get all of the equipments for the Location
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function equipments(): HasMany
  {
      return $this->hasMany(Equipment::class, 'location_id', 'id');
  }

  /**
   * Get all of the instrument_types for the Location
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function instruments(): HasMany
  {
      return $this->hasMany(instruments::class, 'location_id', 'id');
  }

  /**
   * Get all of the it_assets for the Location
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function it_assets(): HasMany
  {
      return $this->hasMany(ItAsset::class, 'location_id', 'id');
  }
  /**
   * Get the company that owns the Location
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function company(): BelongsTo
  {
    return $this->belongsTo(Company::class, 'company_id', 'id');
  }
}
