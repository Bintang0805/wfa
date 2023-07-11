<?php

namespace App\Http\Controllers\Workflow;

use App\Http\Controllers\Controller;
use App\Models\Workflow\ApprovedWorkflow;
use App\Models\Workflow\RequestWorkflow;
use App\Models\Workflow\WorkflowApprover;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConfirmWorkflowController extends Controller
{
    public function index () {
      // dd(ApprovedWorkflow::with(["request_workflow.workflow", "request_workflow.user"])->where("role_id", Auth::user()->id)->get());

      // $workflow = $workflow->where("id", 2)->get();
      $workflowApprovers = ApprovedWorkflow::with(["request_workflow.workflow", "request_workflow.user"])->where("role_id", Auth::user()->id)->where("approved", null)->get();

      // dd($workflowApprovers);
      // $workflow = RequestWorkflow::whereStatus("pending");

      // foreach ($workflowApprovers as $workflowApprover) {
      //   $workflow = $workflow->orWhere("workflow_id", $workflowApprover->workflow_id);
      // }

      // $workflow = $workflow->with(["workflow", "user"])->get();

      // // $requestWorkflow = $workflow->where("approver_roles", Auth::user()->id)->get();
      // dd($workflow);
      $data = [
        "workflow_approvers" => $workflowApprovers,
      ];

      return view("workflow.confirm-workflow.index", $data);
    }

    public function confirm(Request $request) {
      $ApprovedWorkflow = ApprovedWorkflow::where("id", $request->approved_workflow_id)->first();

      if($request->button == 1) {
        $confirmWorkflow = [
          "approved" => true,
        ];
      } else {
        $confirmWorkflow = [
          "approved" => false,
        ];
      }
      $ApprovedWorkflow->update($confirmWorkflow);

      return redirect()->route("confirm-workflows.index");
    }
}
