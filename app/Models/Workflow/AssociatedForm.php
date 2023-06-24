<?php

namespace App\Models\Workflow;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssociatedForm extends Model
{
    use HasFactory;
    protected $table = "associated_forms";
    protected $fillable = ["workflow_id", "request_form_id"];
    protected $guarded = ["id"];

    /**
     * Get the workflow that owns the AssociatedForm
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function workflow(): BelongsTo
    {
        return $this->belongsTo(Workflow::class, 'workflow_id', 'id');
    }

    /**
     * Get the request_form that owns the AssociatedForm
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function request_form(): BelongsTo
    {
        return $this->belongsTo(RequestForm::class, 'request_form_id', 'id');
    }
}
