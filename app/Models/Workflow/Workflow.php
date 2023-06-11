<?php

namespace App\Models\Workflow;

use App\Models\User\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
      "web_notification",
      "associated_form",
    ];
    protected $guarded = ["id"];

    /**
     * Get the role that owns the workflow
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'inititation_role', 'id');
    }

    /**
     * Get the request_form that owns the Workflow
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function request_form(): BelongsTo
    {
        return $this->belongsTo(RequestForm::class, 'associated_form', 'id');
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
