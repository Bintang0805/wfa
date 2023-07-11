@php
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Location - WFA')


@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/formvalidation/dist/css/formValidation.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/animate-css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/animate-css/animate.css') }}">
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave-phone.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/toastr/toastr.js') }}"></script>
@endsection

<!-- Page -->
@section('page-style')

@endsection

@section('page-script')
    {{-- <script src="{{ asset('js/modal-create-workflow.js') }}"></script> --}}
    {{-- <script src="{{ asset('js/workflow.js') }}"></script> --}}
    <script src="{{ asset('js/request-form.js') }}"></script>
    <script>
        $(".send-request-button").on("click", (event) => {
            let workflowId = $(event.target).attr("data-id");
            let approvedWorkflowId = $(event.target).attr("data-approved-workflow-id");
            console.log(approvedWorkflowId);
            // $("#workflow_id").val(workflowId);
            $("#approved_workflow_id").val(approvedWorkflowId);
            loadPreviewFields(workflowId);
        })
    </script>
    <script src="{{ asset("js/confirm-workflow.js") }}"></script>
@endsection

@section('content')
    <div class="bs-toast toast fade bg-primary position-fixed bottom-0 end-0 me-4 mb-4 success-toast" role="alert"
        aria-live="assertive" aria-atomic="true">
        <div class="toast-header pb-2">
            {{-- <img src="..." class="rounded me-2" alt="" /> --}}
            <div class="me-auto fw-semibold">Success Message</div>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            Success saved the workflow. waiting the page reload!
        </div>
    </div>
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger error-message" role="alert">
                {{ $error }}
            </div>
        @endforeach
    @endif
    <div class="card mt-4">
        <div class="card-header">
            <h5 class="card-title mb-0">Confirm Workflow Table</h5>
        </div>
        <div class="card-datatable table-responsive">
            <table id="datatables-workflows" class="datatables-workflows table border-top">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>User Name</th>
                        <th>Workflow Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                  @php
                      $i = 1;
                  @endphp
                    @foreach ($workflow_approvers as $workflow_approver)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $workflow_approver->request_workflow->user->name }}</td>
                            <td>{{ $workflow_approver->request_workflow->workflow->name }}</td>
                            <td>
                              <button class="btn btn-primary button-confirm" data-request="{{ $workflow_approver->request_workflow->request_workflow }}" data-approved-workflow-id="{{ $workflow_approver->id }}">
                                Confirm
                              </button>
                            </td>
                            {{-- <td>
                              <span class="badge {{ $request_workflow->status == 'pending' ? 'text-bg-warning' : "" }}">{{ $request_workflow->status }}</span>
                            </td> --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- <div class="mt-3">
        <div class="modal fade" id="modalCenterDetail" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">Detail Workflow</h5>
                        <button type="reset" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row py-2">
                            <div class="col-4">
                                Workflow Id
                            </div>
                            <div class="col-8" id="workflow-id-detail">
                                : Loading
                            </div>
                        </div>
                        <div class="row py-2">
                            <div class="col-4">
                                Workflow Name
                            </div>
                            <div class="col-8" id="workflow-name-detail">
                                : Loading
                            </div>
                        </div>
                        <div class="row py-2">
                            <div class="col-4">
                                Workflow Description
                            </div>
                            <div class="col-8" id="workflow-description-detail">
                                : Loading
                            </div>
                        </div>
                        <div class="row py-2">
                            <div class="col-4">
                                Initiation Role
                            </div>
                            <div class="col-8" id="initiation-role-detail">
                                : Loading
                            </div>
                        </div>
                        <div class="row py-2">
                            <div class="col-4">
                                Level Of Approvers
                            </div>
                            <div class="col-8" id="level-of-approvers-detail">
                                : 0
                            </div>
                        </div>
                        <div class="row py-2">
                            <div class="col-4">
                                Approver Roles
                            </div>
                            <div class="col-8" id="approver-roles-detail">
                                : Loading
                            </div>
                        </div>
                        <div class="row py-2">
                            <div class="col-4">
                                Worker Roles
                            </div>
                            <div class="col-8" id="worker-roles-detail">
                                : Loading
                            </div>
                        </div>
                        <div class="row py-2">
                            <div class="col-4">
                                Status
                            </div>
                            <div class="col-8" id="status-detail">
                                : Loading
                            </div>
                        </div>
                        <div class="row py-2">
                            <div class="col-4">
                                Email Reminder
                            </div>
                            <div class="col-8" id="email-reminder-detail">
                                : Loading
                            </div>
                        </div>
                        <div class="row py-2">
                            <div class="col-4">
                                Web Notification
                            </div>
                            <div class="col-8" id="web-notification-detail">
                                : Loading
                            </div>
                        </div>
                        <table class="table table-striped mt-4">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Workflow Approvers</th>
                                </tr>
                            </thead>
                            <tbody id="TableBody">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <!-- Create App Modal -->
    <div class="modal fade" id="confirmRequest" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-simple modal-upgrade-plan">
            <div class="modal-content p-3 p-md-5">
                <div class="modal-body p-2">
                  <form action="{{ route('confirm-workflows.confirm') }}" method="POST">
                    @csrf
                    {{-- <input type="hidden" name="workflow_id" id="workflow_id"> --}}
                    <input type="hidden" name="approved_workflow_id" id="approved_workflow_id">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="text-center">
                      <h3 class="mb-2">Approval Workflow</h3>
                    </div>
                    <div class="input-preview w-100 row">
                    </div>
                    <div class="button d-flex justify-content-end pt-5">
                      <button type="submit" name="button" class="btn btn-danger me-3" value="0">
                        Reject
                      </button>
                      <button type="submit" name="button" class="btn btn-success" value="1">
                        Approve
                      </button>
                    </div>
                  </form>
                </div>
                <!--/ Property Listing Wizard -->
            </div>
        </div>
    </div>
    <!--/ Create App Modal -->

@endsection
