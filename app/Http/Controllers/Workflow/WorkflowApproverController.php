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
    $result = WorkflowApprover::updateOrCreate(['id' => $request->id], $credentials);
    if ($request->id == null) {
      $successMessage = 'Workflow Approver Created Successfully';
    } else {
      $successMessage = 'Workflow Approver Updated Successfully';
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
}
