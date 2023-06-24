<?php

namespace App\Http\Controllers\Workflow;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateWorkflowRequest;
use App\Models\User\Role;
use App\Models\Workflow\AssociatedForm;
use App\Models\Workflow\RequestForm;
use App\Models\Workflow\Workflow;
use Illuminate\Http\Request;

class WorkflowController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $enum = Workflow::getEnumType();
    $data = [
      "workflows" => Workflow::all(),
      "roles" => Role::all(),
      "forms" => RequestForm::all(),
      "option_statuses" => $enum->status,
    ];


    return view("workflow.workflow.index", $data);
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
  public function store(CreateWorkflowRequest $request)
  {
    $request->validated();

    $credentials = $request->all();

    if($credentials["associated_form"] != null) {
      $credentials["status"] = "active";
    }
    // dd($credentials);
    $result = Workflow::updateOrCreate(['id' => $request->id], $credentials);
    if($result) {
      if($credentials["associated_form"] != null) {
        $associatedFormId = AssociatedForm::select("id")->whereWorkflowId($result->id)->first();
        $createAssociatedForm = [
          "workflow_id" => $result->id,
          "request_form_id" => $credentials["associated_form"]
        ];
        if($associatedFormId) {
          AssociatedForm::where("workflow_id", $result->id)->update($createAssociatedForm);
        } else {
          AssociatedForm::create($createAssociatedForm);
        }
      } else {
        AssociatedForm::whereWorkflowId($result->id)->delete();
      }
    }
    if ($request->id == null) {
      $successMessage = 'Workflow Created Successfully';
    } else {
      $successMessage = 'Workflow Updated Successfully';
    }

    $response = [
      'status' => 'success',
      'message' => $successMessage,
      'data' => $result,
    ];

    return response()->json($response);
    // return redirect()
    //   ->route('workflows.index')
    //   ->with('success', $successMessage);
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
    $workflow = Workflow::with("workflow_approvers.role")->whereId($id)->first();
    $workflowAssociatedForm = AssociatedForm::whereWorkflowId($id)->first();
    if($workflowAssociatedForm) {
      $workflow->associated_form = $workflowAssociatedForm->request_form_id;
    }
    // $workflow = Workflow::with(["associated_form, workflow_approvers.role"])->where('id', $id)->first();

    $data = [
      'workflow' => $workflow,
    ];

    $response = [
      'status' => 'success',
      'message' => 'Data retrieved successfully',
      'data' => $data,
    ];

    if ($data['workflow'] == null) {
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
  public function update(Request $request, Workflow $workflow)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\workflow  $workflow
   * @return \Illuminate\Http\Response
   */
  public function destroy(Workflow $workflow)
  {
    if ($workflow == null) return redirect()->route('workflows.index')->withErrors("Data with Id" . $workflow->id . "Not found");

    $workflow->delete();
    return redirect()
      ->route('workflows.index')
      ->with('success', 'Workflow Deleted Successfully');
  }

  public function getLastId(Workflow $workflow)
  {
    $result = $workflow->orderBy("id", "desc")->first();

    dd($result);
  }

  public function AJAXGetAll()
  {
    $workflows = Workflow::all();

    foreach ($workflows as $workflow) {
      $nestedData['id'] = $workflow->id;
      $nestedData['name'] = $workflow->name;
      $nestedData['status'] = $workflow->status;

      $data[] = $nestedData;
    }

    return response()->json(["data" => $data]);
  }
}
