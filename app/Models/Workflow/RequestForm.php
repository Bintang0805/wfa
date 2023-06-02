<?php

namespace App\Models\Workflow;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RequestForm extends Model
{
  use HasFactory;
  protected $table = 'request_forms';
  protected $fillable = ['name', 'workflow_id', 'description', 'fields'];
  protected $guarded = ['id'];

  /**
   * Get the workflow that owns the RequestForm
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function workflow(): BelongsTo
  {
      return $this->belongsTo(Workflow::class, 'workflow_id', 'id');
  }
}
