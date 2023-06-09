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
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bs-stepper/bs-stepper.css') }}" />
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
    <script src="{{ asset('assets/vendor/libs/bs-stepper/bs-stepper.js') }}"></script>
@endsection

<!-- Page -->
@section('page-style')

@endsection

@section('page-script')
    <script src="{{ asset('js/modal-create-workflow.js') }}"></script>
    <script src="{{ asset('js/workflow.js') }}"></script>
    <script>
        $(function() {
            const select2 = $('.select2');

            // Select2 Country
            if (select2.length) {
                select2.each(function() {
                    var $this = $(this);
                    $this.wrap('<div class="position-relative"></div>').select2({
                        placeholder: 'Select value',
                        dropdownParent: $this.parent()
                    });
                });
            }
        });
    </script>
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
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createApp">Add New
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
                            <td><span
                                    class="badge {{ $workflow->status == 'active' ? 'bg-success' : 'bg-warning' }}">{{ $workflow->status }}</span>
                            </td>
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
    </div>

    {{-- <div class="mt-3">
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
    </div> --}}

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

    <!-- Create App Modal -->
    <div class="modal fade" id="createApp" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-simple modal-upgrade-plan">
            <div class="modal-content p-3 p-md-5">
                <div class="modal-body p-2">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="text-center">
                        <h3 class="mb-2">Create Workflow</h3>
                        <p>Provide data with this form to create your workflow.</p>
                    </div>
                    <!-- Property Listing Wizard -->
                    <div id="wizard-create-app" class="bs-stepper vertical mt-2 shadow-none border-0">
                        <div class="bs-stepper-header border-0 p-1">
                            <div class="step" data-target="#details">
                                <button type="button" class="step-trigger">
                                    <span class="bs-stepper-circle"><i class="bx bx-file fs-5"></i></span>
                                    <span class="bs-stepper-label">
                                        <span class="bs-stepper-title text-uppercase">Workflow</span>
                                        <span class="bs-stepper-subtitle">Enter the workflow details</span>
                                    </span>
                                </button>
                            </div>
                            <div class="line"></div>
                            <div class="step" data-target="#frameworks">
                                <button type="button" class="step-trigger">
                                    <span class="bs-stepper-circle"><i class="bx bx-box fs-5"></i></span>
                                    <span class="bs-stepper-label">
                                        <span class="bs-stepper-title text-uppercase">Initiator</span>
                                        <span class="bs-stepper-subtitle">Select the initiator role</span>
                                    </span>
                                </button>
                            </div>
                            <div class="line"></div>
                            <div class="step" data-target="#database">
                                <button type="button" class="step-trigger">
                                    <span class="bs-stepper-circle"><i class="bx bx-data fs-5"></i></span>
                                    <span class="bs-stepper-label">
                                        <span class="bs-stepper-title text-uppercase">Worker</span>
                                        <span class="bs-stepper-subtitle">Select the worker role</span>
                                    </span>
                                </button>
                            </div>
                            <div class="line"></div>
                            <div class="step" data-target="#billing">
                                <button type="button" class="step-trigger">
                                    <span class="bs-stepper-circle"><i class="bx bx-credit-card fs-5"></i></span>
                                    <span class="bs-stepper-label">
                                        <span class="bs-stepper-title text-uppercase">Approvers</span>
                                        <span class="bs-stepper-subtitle">Select the approvers</span>
                                    </span>
                                </button>
                            </div>
                            <div class="line"></div>
                            <div class="step" data-target="#submit">
                                <button type="button" class="step-trigger">
                                    <span class="bs-stepper-circle"><i class="bx bx-check fs-5"></i></span>
                                    <span class="bs-stepper-label">
                                        <span class="bs-stepper-title text-uppercase">Submit</span>
                                        <span class="bs-stepper-subtitle">Submit</span>
                                    </span>
                                </button>
                            </div>
                        </div>
                        <div class="bs-stepper-content p-1">
                            <form action="{{ route('workflows.store') }}" method="post" id="addNewWorkflowForm">
                                @csrf
                                <input type="hidden" name="id" id="workflow-id">
                                <!-- Details -->
                                <div id="details" class="content pt-3 pt-lg-0">
                                    <div class="mb-3 form-input">
                                        <label class="pb-1" for="add-workflow-name">Workflow Name</label>
                                        <input type="text" class="form-control form-control-lg" id="add-workflow-name"
                                            placeholder="Enter the Workflow Name" name="name">
                                    </div>
                                    <div class="mb-3 form-input">
                                        <label class="pb-1" for="add-workflow-description">Workflow Description</label>
                                        <input type="text" class="form-control form-control-lg"
                                            id="add-workflow-description" placeholder="Enter the Workflow Description"
                                            name="description">
                                    </div>
                                    <div class="col-12 d-flex justify-content-between mt-4">
                                        <button type="button" class="btn btn-label-secondary btn-prev" disabled> <i
                                                class="bx bx-left-arrow-alt bx-xs me-sm-1 me-0"></i>
                                            <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                        </button>
                                        <button type="button" class="btn btn-primary btn-next"> <span
                                                class="align-middle d-sm-inline-block d-none me-sm-1">Next</span> <i
                                                class="bx bx-right-arrow-alt bx-xs"></i></button>
                                    </div>
                                </div>

                                <!-- Frameworks -->
                                <div id="frameworks" class="content pt-3 pt-lg-0">
                                    <h5>Initiator Role</h5>
                                    <ul class="p-0 m-0">
                                        @foreach ($roles as $role)
                                            <li class="d-flex align-items-start mb-3">
                                                <div class="badge bg-label-info p-2 me-3 rounded"><i
                                                        class="bx bxl-react bx-sm"></i></div>
                                                <div class="d-flex justify-content-between w-100 flex-wrap gap-2">
                                                    <div class="me-2">
                                                        <h6 class="mb-0">{{ $role->role_name }}</h6>
                                                    </div>
                                                    <div class="d-flex align-items-center">
                                                        <div class="form-check form-check-inline form-input">
                                                            <input name="initiation_role" class="form-check-input"
                                                                type="radio" value="{{ $role->id }}" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>

                                    <div class="col-12 d-flex justify-content-between mt-4">
                                        <button type="button" class="btn btn-label-secondary btn-prev"> <i
                                                class="bx bx-left-arrow-alt bx-xs me-sm-1 me-0"></i> <span
                                                class="align-middle d-sm-inline-block d-none">Previous</span> </button>
                                        <button type="button" class="btn btn-primary btn-next"> <span
                                                class="align-middle d-sm-inline-block d-none me-sm-1">Next</span> <i
                                                class="bx bx-right-arrow-alt bx-xs"></i></button>
                                    </div>
                                </div>

                                <!-- Database -->
                                <div id="database" class="content pt-3 pt-lg-0">
                                    <h5>Select Worker Role</h5>
                                    <ul class="p-0 m-0">
                                        @foreach ($roles as $role)
                                            <li class="d-flex align-items-start mb-3">
                                                <div class="badge bg-label-info p-2 me-3 rounded"><i
                                                        class="bx bxl-react bx-sm"></i></div>
                                                <div class="d-flex justify-content-between w-100 flex-wrap gap-2">
                                                    <div class="me-2">
                                                        <h6 class="mb-0">{{ $role->role_name }}</h6>
                                                    </div>
                                                    <div class="d-flex align-items-center">
                                                        <div class="form-check form-check-inline form-input">
                                                            <input name="worker_roles" class="form-check-input"
                                                                type="radio" value="{{ $role->id }}" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="col-12 d-flex justify-content-between mt-4">
                                        <button type="button" class="btn btn-label-secondary btn-prev"> <i
                                                class="bx bx-left-arrow-alt bx-xs me-sm-1 me-0"></i> <span
                                                class="align-middle d-sm-inline-block d-none">Previous</span> </button>
                                        <button type="button" class="btn btn-primary btn-next"> <span
                                                class="align-middle d-sm-inline-block d-none me-sm-1">Next</span> <i
                                                class="bx bx-right-arrow-alt bx-xs"></i></button>
                                    </div>
                                </div>

                                <!-- billing -->
                                <div id="billing" class="content">
                                    <div id="AppNewCCForm" class="row g-3 pt-3 pt-lg-0 mb-5 form-input" onsubmit="return false">
                                        <label class="form-label" for="modalEditUserLanguage">Select the approvers</label>
                                        <select id="add-approver-roles" name="approver_roles" class="select2 form-select"
                                            multiple>
                                            <option value="">Select</option>
                                            @foreach ($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12 d-flex justify-content-between mt-4">
                                        <button type="button" class="btn btn-label-secondary btn-prev"> <i
                                                class="bx bx-left-arrow-alt bx-xs me-sm-1 me-0"></i> <span
                                                class="align-middle d-sm-inline-block d-none">Previous</span> </button>
                                        <button type="button" class="btn btn-primary btn-next"> <span
                                                class="align-middle d-sm-inline-block d-none me-sm-1">Next</span> <i
                                                class="bx bx-right-arrow-alt bx-xs"></i></button>
                                    </div>
                                </div>

                                <!-- submit -->
                                <div id="submit" class="content text-center pt-3 pt-lg-0">
                                    <h5 class="mb-2 mt-3">Submit</h5>
                                    <p>Submit to kick start your project.</p>
                                    <!-- image -->
                                    <img src="{{ asset('assets/img/illustrations/girl-doing-yoga-' . $configData['style'] . '.png') }}"
                                        alt="Create App img" width="300" class="img-fluid"
                                        data-app-light-img="illustrations/girl-doing-yoga-light.png"
                                        data-app-dark-img="illustrations/girl-doing-yoga-dark.png">
                                    <div class="col-12 d-flex justify-content-between mt-4 pt-2">
                                        <button type="button" class="btn btn-label-secondary btn-prev"> <i
                                                class="bx bx-left-arrow-alt bx-xs me-sm-1 me-0"></i> <span
                                                class="align-middle d-sm-inline-block d-none">Previous</span> </button>
                                        <button type="submit" class="btn btn-success btn-next btn-submit"> <span
                                                class="align-middle d-sm-inline-block d-none">Submit</span></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--/ Property Listing Wizard -->
            </div>
        </div>
    </div>
    <!--/ Create App Modal -->

@endsection
