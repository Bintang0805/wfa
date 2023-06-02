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
    <script src="{{ asset('js/workflow.js') }}"></script>
@endsection

@section('content')
    @if (session('success'))
        <div class="bs-toast toast fade show bg-primary position-fixed bottom-0 end-0 me-4 mb-4 success-toast"
            role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header pb-2">
                {{-- <img src="..." class="rounded me-2" alt="" /> --}}
                <div class="me-auto fw-semibold">Success Message</div>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                {{ session('success') }}
            </div>
        </div>
    @endif
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger error-message" role="alert">
                {{ $error }}
            </div>
        @endforeach
    @endif
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Workflows Table</h5>
        </div>
        <div class="card-datatable table-responsive">
            <div class="button d-flex w-100 justify-content-end pe-3">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCenter">Add New
                    Workflow</button>
            </div>
            <table class="datatables-workflows table border-top">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Workflow Name</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($workflows as $workflow)
                        <tr>
                            <td>{{ $workflow->id }}</td>
                            <td>{{ $workflow->name }}</td>\
                            <td><span class="badge {{ $workflow->status == "active" ? "bg-success" : "bg-warning" }}">{{ $workflow->status }}</span></td>
                            <td class="d-flex">
                                <button class="edit-button btn-sm btn btn-primary" data-id="{{ $workflow->id }}"
                                    data-bs-toggle="modal" data-bs-target="#modalCenter">
                                    <i class="bx bx-edit"></i>
                                </button>
                                <form action="{{ route('workflows.destroy', ['workflow' => $workflow]) }}" method="POST"
                                    class="DeleteForm">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger mx-2"
                                        onclick="showPermission(this.parentNode)"><i class="bx bx-trash"></i></button>
                                </form>
                                <button class="detail-button btn btn-sm btn-secondary" data-id="{{ $workflow->id }}"
                                    data-bs-toggle="modal" data-bs-target="#modalCenterDetail">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{-- <!-- Offcanvas to add new location -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddLocation"
            aria-labelledby="offcanvasAddLocationLabel">
            <div class="offcanvas-header">
                <h5 id="offcanvasAddLocationLabel" class="offcanvas-title">Add Location</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body mx-0 flex-grow-0">
                <form class="add-new-location pt-0" id="addNewLocationForm" method="POST"
                    action="{{ route('locations.store') }}">
                    @csrf
                    <input type="hidden" name="id" id="location_id">
                    <div class="mb-3">
                        <label class="form-label" for="add-location-company">Company</label>
                        <select name="company_id" id="add-location-company" class="form-control">
                            <option value="" disabled selected>Select Company</option>
                            @foreach ($companies as $company)
                                <option value="{{ $company->id }}">{{ $company->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="add-location-name">Location Name</label>
                        <input type="text" id="add-location-name" class="form-control" placeholder="California"
                            name="location_name" />
                    </div>
                    <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Submit</button>
                    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">Cancel</button>
                </form>
            </div>
        </div> --}}
    </div>

    <div class="mt-3">
        <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <form action="{{ route('workflows.store') }}" method="post" id="addNewWorkflowForm">
                        @csrf
                        <input type="hidden" name="id" id="workflow-id">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalCenterTitle">Form Workflow</h5>
                            <button type="reset" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body row">
                            <div class="mb-3 form-input col-12 col-md-6">
                                <label class="form-label" for="add-workflow-name">Workflow Name<span
                                        class="text-danger ps-1 fs-6">*</span></label>
                                <input type="text" id="add-workflow-name" class="form-control" placeholder="California"
                                    name="name" />
                            </div>
                            <div class="mb-3 form-input col-12 col-md-6">
                                <label class="form-label" for="add-workflow-description">Workflow Description<span
                                        class="text-danger ps-1 fs-6">*</span></label>
                                <input type="text" id="add-workflow-description" class="form-control"
                                    placeholder="California" name="description" />
                            </div>
                            <div class="mb-3 form-input col-12 col-md-6">
                                <label class="form-label" for="add-initiation-role">Initiation Role<span
                                        class="text-danger ps-1 fs-6">*</span></label>
                                <select name="initiation_role" id="add-initiation-role" class="form-control">
                                    <option value="" disabled selected>Select Initiation Role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 form-input col-12 col-md-6">
                                <label class="form-label" for="add-approver-roles">Approver Roles<span
                                        class="text-danger ps-1 fs-6">*</span></label>
                                <select name="approver_roles" id="add-approver-roles" class="form-control">
                                    <option value="" disabled selected>Select Approver Roles</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 form-input col-12 col-md-6">
                                <label class="form-label" for="add-worker-roles">Worker Roles<span
                                        class="text-danger ps-1 fs-6">*</span></label>
                                <select name="worker_roles" id="add-worker-roles" class="form-control">
                                    <option value="" disabled selected>Select Worker Roles</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 form-input col-12 col-md-6">
                                <label class="form-label" for="add-email-reminder">Email Reminder<span
                                        class="text-danger ps-1 fs-6">*</span></label>
                                <select name="email_reminder" id="add-email-reminder" class="form-control">
                                    <option value="" disabled selected>Select Email Reminder</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                            <div class="mb-3 form-input col-12 col-md-6">
                                <label class="form-label" for="add-web-notification">Web Notification<span
                                        class="text-danger ps-1 fs-6">*</span></label>
                                <select name="web_notification" id="add-web-notification" class="form-control">
                                    <option value="" disabled selected>Select Web Notification</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-3">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
