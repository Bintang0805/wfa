<?php

namespace App\Models\masters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Department extends Model
{
  use HasFactory;
  protected $table = 'departments';
  protected $fillable = ['location_id', 'facility_id', 'department'];
  protected $guarded = ['id'];

  /**
   * Get the facility that owns the Department
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function facility(): BelongsTo
  {
    return $this->belongsTo(Facility::class, 'facility_id', 'id');
  }

  /**
   * Get the location that owns the Department
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function location(): BelongsTo
  {
      return $this->belongsTo(Location::class, 'location_id', 'id');
  }
}
