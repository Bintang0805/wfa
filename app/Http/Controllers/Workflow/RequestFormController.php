<?php

namespace App\Http\Controllers\Workflow;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateRequestFormRequest;
use App\Models\Workflow\AssociatedForm;
use App\Models\Workflow\RequestForm;
use App\Models\Workflow\Workflow;
use Illuminate\Http\Request;

class RequestFormController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    // $requestForms = collect(RequestForm::with("workflows")->get());
    // dd(RequestForm::all());
    $requestForms = RequestForm::all();
    foreach($requestForms as $requestForm) {
      $requestForm->status = count(AssociatedForm::where("request_form_id", $requestForm->id)->get()) > 0;
      $requestForm->associated_form = AssociatedForm::with(["request_form", "workflow"])->where("request_form_id", $requestForm->id)->get();
      $associated_form_to_string = "";
      foreach ($requestForm->associated_form as $associated_form) {
        if($associated_form_to_string == "") {
          $associated_form_to_string .= $associated_form->workflow->name;
        } else {
          $associated_form_to_string .= ", " . $associated_form->workflow->name;
        }
      }
      $requestForm->associated_form_to_string = $associated_form_to_string;
    }

    $workflows = Workflow::all();

    foreach ($workflows as $workflow) {
      $workflow->associated_form = AssociatedForm::select("request_form_id")->where("workflow_id", $workflow->id)->get();
      $associatedForm = AssociatedForm::with(["request_form", "workflow"])->where("workflow_id", $workflow->id)->first();
      if($associatedForm != null) {
        $workflow->request_form = $associatedForm->request_form;
      } else {
        $workflow->request_form = null;
      }
    }

    $data = [
      "workflows" => $workflows,
      "request_forms" => $requestForms
    ];
    // dd($data);

    return view("workflow.request-form.index", $data);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create($workflow_id = null)
  {
    if($workflow_id != null) {
      $data = [
        "workflow" => Workflow::where("id", $workflow_id)->first(),
      ];

      return view("workflow.request-form.create", $data);
    } else {
      return view("workflow.request-form.create");
    }

  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(CreateRequestFormRequest $request)
  {
    $credentials = $request->validated();

    $requestForm = RequestForm::updateOrCreate(['id' => $request->id], $credentials);

    if(isset($request->workflow_id) && $requestForm != null) {
      $associatedForm = [
        "workflow_id" => $request->workflow_id,
        "request_form_id" => $requestForm->id
      ];

      $createAssociatedForm = AssociatedForm::create($associatedForm);

      if($createAssociatedForm != null) {
        $updateWorkflow = [
          "status" => "active",
        ];

        Workflow::where("id", $request->workflow_id)->update($updateWorkflow);
      }
    }

    // $workflow = Workflow::where("id", $request->workflow_id)->first();
    // $updateWorkflow = [
    //   "associated_form" => $requestForm->id,
    //   "status" => "active"
    // ];

    // $workflow->update($updateWorkflow);

    return redirect()
      ->route('request-forms.index')
      ->with('success', "create new Request Form Success");
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\RequestForm  $requestForm
   * @return \Illuminate\Http\Response
   */
  public function show(RequestForm $requestForm)
  {
    return response()->json(["data" => $requestForm]);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\RequestForm  $requestForm
   * @return \Illuminate\Http\Response
   */
  public function edit(RequestForm $requestForm)
  {
    $data = [
      "request_form" => $requestForm,
    ];

    return view("workflow.request-form.edit", $data);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\RequestForm  $requestForm
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, RequestForm $requestForm)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\RequestForm  $requestForm
   * @return \Illuminate\Http\Response
   */
  public function destroy(RequestForm $requestForm)
  {
    if ($requestForm == null) return redirect()->route('request-forms.index')->withErrors("Data with Id" . $requestForm->id . "Not found");

    $associatedForm = AssociatedForm::where("request_form_id", $requestForm->id)->get();

    $updateWorkflow = [];
    foreach ($associatedForm as $form) {
      array_push($updateWorkflow, $form->workflow_id);
    }


    if($associatedForm != null) {
      $workflowUpdated = Workflow::whereIn("id", $updateWorkflow)->update(["status" => "inactive"]);
    }

    if($workflowUpdated) {
      $requestForm->delete();
    }

    return redirect()
      ->route('request-forms.index')
      ->with('success', 'Role Deleted Successfully');
  }

  public function AJAXGetAll()
  {
    $data = RequestForm::all();

    return response()->json(["data" => $data]);
  }
}
