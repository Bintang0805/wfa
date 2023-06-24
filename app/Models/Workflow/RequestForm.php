<?php

namespace App\Models\Workflow;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RequestForm extends Model
{
  use HasFactory;
  protected $table = 'request_forms';
  protected $fillable = ['name', 'workflow_id', 'description', 'fields', 'status'];
  protected $guarded = ['id'];

  // /**
  //  * Get the workflow that owns the RequestForm
  //  *
  //  * @return \Illuminate\Database\Eloquent\Relations\HasMany
  //  */
  // public function workflows(): HasMany
  // {
  //     return $this->belongsTo(Workflow::class, 'workflow_id', 'id');
  // }

  /**
   * Get all of the workflows for the RequestForm
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function workflows(): HasMany
  {
      return $this->hasMany(Workflow::class, 'workflow_id', 'id');
  }
}
