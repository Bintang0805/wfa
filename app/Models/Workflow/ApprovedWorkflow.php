<?php

namespace App\Models\Workflow;

use App\Models\User\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApprovedWorkflow extends Model
{
    use HasFactory;
    protected $table = "approved_workflows";
    protected $fillable = ["request_workflow_id", "role_id", "approved"];
    protected $guarded = ["id"];

    /**
     * Get the request_workflow that owns the ApprovedWorkflow
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function request_workflow(): BelongsTo
    {
        return $this->belongsTo(RequestWorkflow::class, 'request_workflow_id', 'id');
    }

    /**
     * Get the role that owns the ApprovedWorkflow
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }
}
