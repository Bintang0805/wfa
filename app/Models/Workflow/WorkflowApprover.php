<?php

namespace App\Models\Workflow;

use App\Models\User\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkflowApprover extends Model
{
    use HasFactory;
    protected $table = "workflow_approvers";
    protected $fillable = ["workflow_id", "approver_roles"];
    protected $guarded = ["id"];

    /**
     * Get the workflow that owns the WorkflowApprover
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function workflow(): BelongsTo
    {
        return $this->belongsTo(Workflow::class, 'workflow_id', 'id');
    }

    /**
     * Get the role that owns the WorkflowApprover
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'approver_roles', 'id');
    }
}
