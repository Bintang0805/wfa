<?php

namespace App\Models\Workflow;

use App\Models\User\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Workflow extends Model
{
    use HasFactory;
    protected $table = "workflows";
    protected $fillable = [
      "name",
      "description",
      "initiation_role",
      "level_of_approvers",
      "worker_roles",
      "status",
      "email_reminder",
      "web_notification"
    ];
    protected $guarded = ["id"];

    /**
     * Get the role that owns the workflow
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function initiation_role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'initiation_role', 'id');
    }

    /**
     * Get the role that owns the workflow
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function worker_role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'worker_roles', 'id');
    }


    /**
     * Get all of the workflow_approvers for the Workflow
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function workflow_approvers(): HasMany
    {
        return $this->hasMany(WorkflowApprover::class, 'workflow_id', 'id');
    }

    public static function getEnumType()
    {
      $data = [
        "status" => ["active", "inactive"],
      ];
      $obj = (object) json_decode(json_encode($data), false);

      return $obj;
    }
}
