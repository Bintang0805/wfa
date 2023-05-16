<?php

namespace App\Models\masters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EquipmentType extends Model
{
    use HasFactory;
    protected $table = "equipment_types";
    protected $fillable = [
      "equipment_type"
    ];
    protected $guarded = ["id"];

    /**
     * Get all of the equipments for the EquipmentType
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function equipments(): HasMany
    {
        return $this->hasMany(Equipment::class, 'equipment_type_id', 'id');
    }
}
