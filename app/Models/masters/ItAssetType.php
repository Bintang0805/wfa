<?php

namespace App\Models\masters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ItAssetType extends Model
{
  use HasFactory;
  protected $table = 'it_asset_types';
  protected $fillable = ['it_asset_type'];
  protected $guarded = ['id'];

  /**
   * Get all of the it_assets for the ItAssetType
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function it_assets(): HasMany
  {
      return $this->hasMany(ItAsset::class, 'it_asset_type_id', 'id');
  }
}
