<?php

namespace App\Http\Controllers\Workflow;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateRequestWorkflowRequest;
use App\Models\Workflow\ApprovedWorkflow;
use App\Models\Workflow\AssociatedForm;
use App\Models\Workflow\RequestWorkflow;
use App\Models\Workflow\Workflow;
use App\Models\Workflow\WorkflowApprover;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequestWorkflowController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $workflows = Workflow::whereStatus("active")->whereInitiationRole(Auth::user()->role->id)->get();
    foreach ($workflows as $workflow) {
      $associatedForm = AssociatedForm::whereWorkflowId($workflow->id)->first();
      $workflow->associated_form =  $associatedForm->request_form_id;
    }
    $sender_request = RequestWorkflow::whereUserId(Auth::user()->id)->with(["user", "workflow"])->get();

    $approvedWorkflows = ApprovedWorkflow::with("request_workflow.workflow")
      ->whereHas('request_workflow', function ($query) {
        $query->where('user_id', Auth::user()->id);
      })->get()->unique("request_workflow_id");

    // dd($approvedWorkflows);
    foreach ($approvedWorkflows as $approvedWorkflow) {
      $approved = [];
      $approvedRoles = ApprovedWorkflow::where("request_workflow_id", $approvedWorkflow->request_workflow_id)->get();
      $hasApproved = ApprovedWorkflow::where("request_workflow_id", $approvedWorkflow->request_workflow_id)->where("approved", true)->get();
      $hasRejected = ApprovedWorkflow::where("request_workflow_id", $approvedWorkflow->request_workflow_id)->where("approved", false)->get();
      // dd(count($hasApproved));

      if (count($hasRejected) != 0) {
        $requestWorkflowStatus = RequestWorkflow::where("id", $approvedWorkflow->request_workflow->id)->where("status", "!=", "rejected")->first();
        if($requestWorkflowStatus) {
          $updatedStatus = $requestWorkflowStatus->update(["status" => "rejected"]);
        }
      }

      foreach ($approvedRoles as $approvedRole) {
        array_push($approved, $approvedRole);
      }

      $approvedWorkflow->need_approved = count($approvedRoles);
      $approvedWorkflow->has_approved = count($hasApproved);
      $approvedWorkflow->has_rejected = count($hasRejected);

      if(count($approvedRoles) == count($hasApproved)) {
        $requestWorkflowStatus = RequestWorkflow::where("id", $approvedWorkflow->request_workflow->id)->where("status", "!=", "approved")->first();
        if($requestWorkflowStatus) {
          $updatedStatus = $requestWorkflowStatus->update(["status" => "approved"]);
        }
      }
    }

    if(isset($updatedStatus) && $updatedStatus) {
      return redirect()->route("request-workflow.index");
    }

    $data = [
      'workflows' => $workflows,
      "request_workflows" => $sender_request,
      "approved_workflows" => $approvedWorkflows,
      // "approved_workflow"
    ];

    // dd($data["approved_workflows"]);

    // dd($data["approved_workflows"]);
    return view('workflow.request-workflow.index', $data);
  }

  // /**
  //  * Show the form for creating a new resource.
  //  *
  //  * @return \Illuminate\Http\Response
  //  */
  // public function create()
  // {
  // }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(CreateRequestWorkflowRequest $request)
  {
    $data = [
      "workflow_id" => $request->workflow_id,
      "request_workflow" => json_encode($request->except("workflow_id")),
      "user_id" => Auth::user()->id,
    ];

    $requestWorkflow = RequestWorkflow::create($data);

    if ($requestWorkflow) {
      $workflowApprovers = WorkflowApprover::where("workflow_id", $requestWorkflow->workflow_id)->get();

      $approvedWorkflows = [];
      foreach ($workflowApprovers as $workflowApprover) {
        $approvedWorkflow = [
          "request_workflow_id" => $requestWorkflow->id,
          "role_id" => $workflowApprover->approver_roles
        ];

        array_push($approvedWorkflows, $approvedWorkflow);
        // array_push($approvedWorkflows, $)
      }
    }

    $approvedWorkflow = ApprovedWorkflow::insert($approvedWorkflows);

    // dd($approvedWorkflow);

    $successMessage = 'Request Workflow Sender';

    return redirect()
      ->route('request-workflow.index')
      ->with('success', $successMessage);
  }

  // /**
  //  * Display the specified resource.
  //  *
  //  * @param  \App\Models\masters\Location  $location
  //  * @return \Illuminate\Http\Response
  //  */
  // public function show(Location $location)
  // {
  //   $data = [
  //     'location' => $location,
  //   ];
  //   return view('masters.location.detail', $data);
  // }

  // /**
  //  * Show the form for editing the specified resource.
  //  *
  //  * @param  \App\Models\masters\Location  $location
  //  * @return \Illuminate\Http\Response
  //  */
  // public function edit($id)
  // {
  //   $location = Location::with('company')
  //     ->where('id', $id)
  //     ->first();

  //   $data = [
  //     'location' => $location,
  //   ];

  //   $response = [
  //     'status' => 'success',
  //     'message' => 'Data retrieved successfully',
  //     'data' => $data,
  //   ];

  //   if ($data['location'] == null) {
  //     return response()->json(
  //       [
  //         'status' => 'failed',
  //         'message' => 'failed retrieved Data',
  //         'data' => null,
  //       ],
  //       404
  //     );
  //   }
  //   return response()->json($response, 200);
  //   // return view('masters.location.edit', $data);
  // }

  // /**
  //  * Update the specified resource in storage.
  //  *
  //  * @param  \Illuminate\Http\Request  $request
  //  * @param  \App\Models\masters\Location  $location
  //  * @return \Illuminate\Http\Response
  //  */
  // public function update(Request $request, Location $location)
  // {
  //   // dd($request->all());
  //   $location->update($request->all());
  //   return redirect()->route('locations.index');
  // }

  // /**
  //  * Remove the specified resource from storage.
  //  *
  //  * @param  \App\Models\masters\Location  $location
  //  * @return \Illuminate\Http\Response
  //  */
  // public function destroy(Location $location)
  // {
  //   if ($location == null) return redirect()->route('location.index')->withErrors("Data with Id" . $location->id . "Not found");

  //   $location->delete();
  //   return redirect()
  //     ->route('locations.index')
  //     ->with('success', 'Location Deleted Successfully');
  // }

  // public function AJAXGetAll()
  // {
  //   $data = Location::all();

  //   return response()->json(["data" => $data]);
  // }
}
