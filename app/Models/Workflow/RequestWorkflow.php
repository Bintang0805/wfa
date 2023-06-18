<?php

namespace App\Models\Workflow;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RequestWorkflow extends Model
{
    use HasFactory;
    protected $table = "request_workflows";
    protected $fillable = [
      "workflow_id",
      "request_workflow",
      "user_id",
      "status",
    ];
    protected $guarded = ["id"];

    /**
     * Get the workflow that owns the RequestWorkflow
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function workflow(): BelongsTo
    {
        return $this->belongsTo(Workflow::class, 'workflow_id', 'id');
    }

    public function user(): BelongsTo {
      return $this->belongsTo(User::class, "user_id", 'id');
    }
}
