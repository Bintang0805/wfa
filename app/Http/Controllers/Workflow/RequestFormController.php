<?php

namespace App\Http\Controllers\Workflow;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateRequestFormRequest;
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
    $data = [
      "workflows" => Workflow::with("request_form")->get(),
    ];

    return view("workflow.request-form.index", $data);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create($workflow_id)
  {
    $data = [
      "workflow" => Workflow::where("id", $workflow_id)->first(),
    ];

    return view("workflow.request-form.create", $data);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(CreateRequestFormRequest $request)
  {
    $request->validated();

    $workflow = Workflow::where("id", $request->workflow_id)->first();
    $requestForm = RequestForm::create($request->all());

    $updateWorkflow = [
      "associated_form" => $requestForm->id,
      "status" => "active"
    ];

    $workflow->update($updateWorkflow);

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
      "workflows" => Workflow::where("associated_form", null)->orWhere("associated_form", $requestForm->id)->get(),
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

    $workflow = Workflow::where("id", $requestForm->workflow_id)->first();

    $requestForm->delete();

    $updateWorkflow = [
      "status" => "inactive",
    ];

    $workflow->update($updateWorkflow);

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
