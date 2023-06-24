<?php

namespace App\Http\Controllers\Workflow;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateWorkflowApproverRequest;
use App\Http\Requests\CreateWorkflowRequest;
use App\Models\User\Role;
use App\Models\Workflow\Workflow;
use App\Models\Workflow\WorkflowApprover;
use Illuminate\Http\Request;

class WorkflowApproverController extends Controller
{
  private $check = 1;
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $data = [
      "workflow_approvers" => WorkflowApprover::all(),
      "workflows" => Workflow::all(),
      "roles" => Role::all(),
    ];

    return view("workflow.workflow-approver.index", $data);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(CreateWorkflowApproverRequest $request)
  {
    $request->validated();

    $credentials = $request->all();

    $workflowApprover = [];
    foreach($credentials["approver_roles"] as $approver_roles) {
      $createWorkflowApprover = [
        "workflow_id" => $credentials["workflow_id"],
        "approver_roles" => $approver_roles["value"]
      ];
      array_push($workflowApprover, $createWorkflowApprover);
    }

    $result = WorkflowApprover::insert($workflowApprover);
    if ($result) {
      Workflow::whereId($credentials["workflow_id"])->first()->update(["level_of_approvers" => count($workflowApprover)]);

      $successMessage = 'Workflow Approver Created Successfully';
    } else {
      $successMessage = 'Workflow Approver Failed To Create';
    }

    $response = [
      'status' => 'success',
      'message' => $successMessage,
      'data' => $result,
    ];

    return response()->json($response);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\workflow  $workflow
   * @return \Illuminate\Http\Response
   */
  public function show(workflow $workflow)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\workflow  $workflow
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $workflow = WorkflowApprover::where('id', $id)->first();

    $data = [
      'workflow_approver' => $workflow,
    ];

    $response = [
      'status' => 'success',
      'message' => 'Data retrieved successfully',
      'data' => $data,
    ];

    if ($data['workflow_approver'] == null) {
      return response()->json(
        [
          'status' => 'failed',
          'message' => 'failed retrieved Data',
          'data' => null,
        ],
        404
      );
    }
    return response()->json($response, 200);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\workflow  $workflow
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, workflow $workflow)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\workflow  $workflow
   * @return \Illuminate\Http\Response
   */
  public function destroy(WorkflowApprover $workflow_approver)
  {
    if ($workflow_approver == null) return redirect()->route('workflow-approvers.index')->withErrors("Data with Id" . $workflow_approver->id . "Not found");

    $workflow_approver->delete();
    return redirect()
      ->route('workflow-approvers.index')
      ->with('success', 'Workflow Approver Deleted Successfully');
  }

  public function destroyAll($workflow_id) {
    if ($workflow_id == null) return redirect()->route('workflow-approvers.index')->withErrors("Data with Id" . $workflow_id . "Not found");

    WorkflowApprover::where("workflow_id", $workflow_id)->delete();

    return response()->json(
      [
        'status' => 'Success',
        'message' => 'Success Delete Old Data',
        'data' => null,
      ],
    );
  }
}
