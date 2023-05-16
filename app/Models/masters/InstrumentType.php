<?php

namespace App\Models\masters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InstrumentType extends Model
{
  use HasFactory;
  protected $table = 'instrument_types';
  protected $fillable = ['instrument_type'];
  protected $guarded = ['id'];

  /**
   * Get all of the instruments for the InstrumentType
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function instruments(): HasMany
  {
      return $this->hasMany(Instrument::class, 'instrument_type_id', 'id');
  }
}
