<?php

namespace App\Http\Controllers\Workflow;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateRequestWorkflowRequest;
use App\Models\Workflow\AssociatedForm;
use App\Models\Workflow\RequestWorkflow;
use App\Models\Workflow\Workflow;
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
    foreach($workflows as $workflow) {
      $associatedForm = AssociatedForm::whereWorkflowId($workflow->id)->first();
      $workflow->associated_form =  $associatedForm->request_form_id;
    }
    $sender_request = RequestWorkflow::whereUserId(Auth::user()->id)->with(["user", "workflow"])->get();

    $data = [
      'workflows' => $workflows,
      "request_workflows" => $sender_request
    ];
    return view('workflow.request-workflow.index', $data);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
  }

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

    RequestWorkflow::create($data);

    $successMessage = 'Request Workflow Sender';

    return redirect()
      ->route('request-workflow.index')
      ->with('success', $successMessage);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\masters\Location  $location
   * @return \Illuminate\Http\Response
   */
  public function show(Location $location)
  {
    $data = [
      'location' => $location,
    ];
    return view('masters.location.detail', $data);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\masters\Location  $location
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $location = Location::with('company')
      ->where('id', $id)
      ->first();

    $data = [
      'location' => $location,
    ];

    $response = [
      'status' => 'success',
      'message' => 'Data retrieved successfully',
      'data' => $data,
    ];

    if ($data['location'] == null) {
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
    // return view('masters.location.edit', $data);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\masters\Location  $location
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Location $location)
  {
    // dd($request->all());
    $location->update($request->all());
    return redirect()->route('locations.index');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\masters\Location  $location
   * @return \Illuminate\Http\Response
   */
  public function destroy(Location $location)
  {
    if ($location == null) return redirect()->route('location.index')->withErrors("Data with Id" . $location->id . "Not found");

    $location->delete();
    return redirect()
      ->route('locations.index')
      ->with('success', 'Location Deleted Successfully');
  }

  public function AJAXGetAll()
  {
    $data = Location::all();

    return response()->json(["data" => $data]);
  }
}
