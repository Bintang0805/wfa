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
    <script src="{{ asset('js/application.js') }}"></script>
    <script>
        function showPermission() {
            event.preventDefault();
            let form = document.getElementById('DeleteForm');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't to delete this?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // <--- submit form programmatically
                } else if (
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire(
                        'Cancelled',
                        'Your data is safe :)',
                        'error'
                    )
                }
            })
        }
    </script>
@endsection

@section('content')
    @if (session('success'))
        <div class="bs-toast toast fade show bg-primary position-fixed bottom-0 end-0 me-4 mb-4" role="alert"
            aria-live="assertive" aria-atomic="true">
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
        <div class="bs-toast toast fade show bg-danger position-fixed bottom-0 end-0 me-4 mb-4" role="alert"
            aria-live="assertive" aria-atomic="true">
            <div class="toast-header pb-2">
                {{-- <img src="..." class="rounded me-2" alt="" /> --}}
                <div class="me-auto fw-semibold">Error Message</div>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                Error Manipulated The Data
            </div>
        </div>
    @endif
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Application Table</h5>
        </div>
        <div class="card-body">
            <form class="dt_adv_search" method="POST">
                <div class="row">
                    <div class="col-12">
                        <div class="row g-3">
                            <div class="col-12 col-sm-6 col-lg-6">
                                <label class="form-label">Application Name:</label>
                                <input type="text" class="form-control dt-input dt-application-name" data-column=1>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-6">
                                <label class="form-label">Location Name:</label>
                                <input type="text" class="form-control dt-input" data-column=2>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-6">
                                <label class="form-label">Facility Name:</label>
                                <input type="text" class="form-control dt-input" data-column=3>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-6">
                                <label class="form-label">Department Name:</label>
                                <input type="text" class="form-control dt-input" data-column=4>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-applications table border-top">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th class="text-nowrap">Application Name</th>
                        <th class="text-nowrap">Location Name</th>
                        <th class="text-nowrap">Facility Name</th>
                        <th class="text-nowrap">Department Name</th>
                        <th class="text-nowrap">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($applications as $application)
                        <tr>
                            <td>{{ $application->id }}</td>
                            <td>{{ $application->application_name }}</td>
                            <td>{{ $application->location->location_name }}</td>
                            <td>{{ $application->facility->facility_name }}</td>
                            <td>{{ $application->department->department }}</td>
                            <td class="d-flex">
                                <button class="detail-button btn btn-sm btn-secondary" data-id="{{ $application->id }}"
                                    data-bs-toggle="modal" data-bs-target="#modalCenterDetail">
                                    Detail
                                </button>
                                <button class="edit-button btn btn-sm btn-primary mx-2" data-id="{{ $application->id }}"
                                    data-bs-toggle="modal" data-bs-target="#modalCenter">
                                    Edit
                                </button>
                                <form action="{{ route('applications.destroy', ['application' => $application]) }}"
                                    id="DeleteForm" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="showPermission()">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Offcanvas to add new equipment -->
        {{-- <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddApplication"
            aria-labelledby="offcanvasAddApplicationLabel">
            <div class="offcanvas-header">
                <h5 id="offcanvasAddApplicationLabel" class="offcanvas-title">Add Application</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body mx-0 flex-grow-0">
                <form class="add-new-application pt-0" id="addNewApplicationForm" method="POST"
                    action="{{ route('applications.store') }}">
                    @csrf
                    <input type="hidden" name="id" id="application_id">
                    <div class="mb-3">
                        <label class="form-label" for="add-application-name">Application Name</label>
                        <input type="text" id="add-application-name" class="form-control" placeholder="California"
                            name="application_name" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="add-application-name">Application Ver</label>
                        <input type="text" id="add-application-ver" class="form-control" placeholder="California"
                            name="application_ver" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="add-connected-to-computer">Connected To Computer</label>
                        <select name="connected_to_computer" id="add-connected-to-computer" class="form-control">
                            <option value="" disabled selected> Select Connected To Computer</option>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="add-application-department">Department</label>
                        <select name="department_id" id="add-application-department" class="form-control">
                            <option value="" disabled selected>Select Department</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->department }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="add-connected-to-server">Connected To Server</label>
                        <select name="connected_to_server" id="add-connected-to-server" class="form-control">
                            <option value="" disabled selected> Select Connected To Server</option>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="add-application-role-type">Application Role Type</label>
                        <select name="application_role_type" id="add-application-role-type" class="form-control">
                            <option value="" disabled selected>Select Application Role Type</option>
                            @foreach ($application_role_types as $application_role_type)
                                <option value="{{ $application_role_type }}">
                                    {{ $application_role_type }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="add-privilages">Privilages</label>
                        <input type="text" id="add-privilages" class="form-control" placeholder="California"
                            name="privilages" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="add-manufacturer">Manufacturer</label>
                        <input type="text" id="add-manufacturer" class="form-control" placeholder="California"
                            name="manufacturer" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="add-gamp-category">Gamp Category</label>
                        <select name="gamp_category" id="add-gamp-category" class="form-control">
                            <option value="" disabled selected>Select Gamp Category</option>
                            @foreach ($gamp_category_types as $gamp_category_type)
                                <option value="{{ $gamp_category_type }}">{{ $gamp_category_type }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="add-csv-status">CSV Status</label>
                        <select name="csv_status" id="add-csv-status" class="form-control">
                            <option value="" disabled selected>Select CSV Status</option>
                            @foreach ($csv_status_types as $csv_status_type)
                                <option value="{{ $csv_status_type }}">{{ $csv_status_type }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="add-csv-completed-on">CSV Completed On</label>
                        <input type="date" id="add-csv-completed-on" class="form-control" name="csv_completed_on"
                            value="now" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="add-periodic-review">Periodic Review</label>
                        <input type="text" id="add-periodic-review" class="form-control" name="periodic_review" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="add-gxp-status">GXP Status</label>
                        <select name="gxp_status" id="add-gxp-status" class="form-control">
                            <option value="" disabled selected>Select GXP Status</option>
                            @foreach ($gxp_status_types as $gxp_status_type)
                                <option value="{{ $gxp_status_type }}">{{ $gxp_status_type }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="add-backup-mode">Backup Mode</label>
                        <select name="backup_mode" id="add-backup-mode" class="form-control">
                            <option value="" disabled selected>Select Backup Mode</option>
                            @foreach ($backup_mode_types as $backup_mode_type)
                                <option value="{{ $backup_mode_type }}">{{ $backup_mode_type }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="add-data-type">Data Type</label>
                        <select name="data_type" id="add-data-type" class="form-control">
                            <option value="" disabled selected>Select Data Type</option>
                            @foreach ($data_types as $data_type)
                                <option value="{{ $data_type }}">{{ $data_type }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="add-vendor-details">Vendor Details</label>
                        <input type="text" id="add-vendor-details" class="form-control" placeholder="California"
                            name="vendor_details" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="add-status">Status</label>
                        <select name="status" id="add-status" class="form-control">
                            <option value="" disabled selected>Select Status</option>
                            @foreach ($status_types as $status_type)
                                <option value="{{ $status_type }}">{{ $status_type }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Submit</button>
                    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">Cancel</button>
                </form>
            </div>
        </div> --}}
    </div>

    <div class="mt-3">
        <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true" data-errors="{{ $errors->any() == true ? true : false }}">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form action="{{ route('applications.store') }}" method="post" id="addNewApplicationForm">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalCenterTitle">Form IT Asset</h5>
                            <button type="reset" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                    <div class="alert alert-danger mx-1" role="alert">
                                        {{ $error }}
                                    </div>
                                @endforeach
                            @endif
                            <input type="hidden" name="id" id="application_id">
                            <div class="mb-3">
                                <label class="form-label" for="add-application-name">Application Name<span
                                        class="text-danger ps-1 fs-6">*</span></label>
                                <input type="text" id="add-application-name" class="form-control"
                                    placeholder="California" name="application_name" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="add-application-name">Application Ver<span
                                        class="text-danger ps-1 fs-6">*</span></label>
                                <input type="text" id="add-application-ver" class="form-control"
                                    placeholder="California" name="application_ver" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="add-connected-to-computer">Connected To Computer<span
                                        class="text-danger ps-1 fs-6">*</span></label>
                                {{-- <input type="text" id="add-application-ver" class="form-control" placeholder="California"
                              name="application_ver" /> --}}
                                <select name="connected_to_computer" id="add-connected-to-computer" class="form-control">
                                    <option value="" disabled selected> Select Connected To Computer</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="add-application-department">Department<span
                                        class="text-danger ps-1 fs-6">*</span></label>
                                <select name="department_id" id="add-application-department" class="form-control">
                                    <option value="" disabled selected>Select Department</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->department }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="add-connected-to-server">Connected To Server<span
                                        class="text-danger ps-1 fs-6">*</span></label>
                                {{-- <input type="text" id="add-application-ver" class="form-control" placeholder="California"
                            name="application_ver" /> --}}
                                <select name="connected_to_server" id="add-connected-to-server" class="form-control">
                                    <option value="" disabled selected> Select Connected To Server</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="add-application-role-type">Application Role Type<span
                                        class="text-danger ps-1 fs-6">*</span></label>
                                <select name="application_role_type" id="add-application-role-type" class="form-control">
                                    <option value="" disabled selected>Select Application Role Type</option>
                                    @foreach ($application_role_types as $application_role_type)
                                        <option value="{{ $application_role_type }}">
                                            {{ $application_role_type }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="add-privilages">Privilages<span
                                        class="text-danger ps-1 fs-6">*</span></label>
                                <input type="text" id="add-privilages" class="form-control" placeholder="California"
                                    name="privilages" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="add-manufacturer">Manufacturer<span
                                        class="text-danger ps-1 fs-6">*</span></label>
                                <input type="text" id="add-manufacturer" class="form-control"
                                    placeholder="California" name="manufacturer" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="add-gamp-category">Gamp Category<span
                                        class="text-danger ps-1 fs-6">*</span></label>
                                <select name="gamp_category" id="add-gamp-category" class="form-control">
                                    <option value="" disabled selected>Select Gamp Category</option>
                                    @foreach ($gamp_category_types as $gamp_category_type)
                                        <option value="{{ $gamp_category_type }}">{{ $gamp_category_type }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="add-csv-status">CSV Status<span
                                        class="text-danger ps-1 fs-6">*</span></label>
                                <select name="csv_status" id="add-csv-status" class="form-control">
                                    <option value="" disabled selected>Select CSV Status</option>
                                    @foreach ($csv_status_types as $csv_status_type)
                                        <option value="{{ $csv_status_type }}">{{ $csv_status_type }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="add-csv-completed-on">CSV Completed On<span
                                        class="text-danger ps-1 fs-6">*</span></label>
                                <input type="date" id="add-csv-completed-on" class="form-control"
                                    name="csv_completed_on" value="now" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="add-periodic-review">Periodic Review<span
                                        class="text-danger ps-1 fs-6">*</span></label>
                                <input type="text" id="add-periodic-review" class="form-control"
                                    name="periodic_review" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="add-gxp-status">GXP Status<span
                                        class="text-danger ps-1 fs-6">*</span></label>
                                <select name="gxp_status" id="add-gxp-status" class="form-control">
                                    <option value="" disabled selected>Select GXP Status</option>
                                    @foreach ($gxp_status_types as $gxp_status_type)
                                        <option value="{{ $gxp_status_type }}">{{ $gxp_status_type }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="add-backup-mode">Backup Mode<span
                                        class="text-danger ps-1 fs-6">*</span></label>
                                <select name="backup_mode" id="add-backup-mode" class="form-control">
                                    <option value="" disabled selected>Select Backup Mode</option>
                                    @foreach ($backup_mode_types as $backup_mode_type)
                                        <option value="{{ $backup_mode_type }}">{{ $backup_mode_type }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="add-data-type">Data Type<span
                                        class="text-danger ps-1 fs-6">*</span></label>
                                <select name="data_type" id="add-data-type" class="form-control">
                                    <option value="" disabled selected>Select Data Type</option>
                                    @foreach ($data_types as $data_type)
                                        <option value="{{ $data_type }}">{{ $data_type }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="add-vendor-details">Vendor Details<span
                                        class="text-danger ps-1 fs-6">*</span></label>
                                <input type="text" id="add-vendor-details" class="form-control"
                                    placeholder="California" name="vendor_details" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="add-status">Status<span
                                        class="text-danger ps-1 fs-6">*</span></label>
                                <select name="status" id="add-status" class="form-control">
                                    <option value="" disabled selected>Select Status</option>
                                    @foreach ($status_types as $status_type)
                                        <option value="{{ $status_type }}">{{ $status_type }}
                                        </option>
                                    @endforeach
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
                        <h5 class="modal-title" id="modalCenterTitle">Detail IT Asset</h5>
                        <button type="reset" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row py-2">
                            <div class="col-4">
                                Application Id
                            </div>
                            <div class="col-8" id="application-id-detail">
                                : Loading
                            </div>
                        </div>
                        <div class="row py-2">
                            <div class="col-4">
                                Application Name
                            </div>
                            <div class="col-8" id="application-name-detail">
                                : Loading
                            </div>
                        </div>
                        <div class="row py-2">
                            <div class="col-4">
                                Application Ver
                            </div>
                            <div class="col-8" id="application-ver-detail">
                                : Loading
                            </div>
                        </div>
                        <div class="row py-2">
                            <div class="col-4">
                                Connected To Computer
                            </div>
                            <div class="col-8" id="connected-to-computer-detail">
                                : Loading
                            </div>
                        </div>
                        <div class="row py-2">
                            <div class="col-4">
                                Connected To Server
                            </div>
                            <div class="col-8" id="connected-to-server-detail">
                                : Loading
                            </div>
                        </div>
                        <div class="row py-2">
                            <div class="col-4">
                                Application Role Type
                            </div>
                            <div class="col-8" id="application-role-type-detail">
                                : Loading
                            </div>
                        </div>
                        <div class="row py-2">
                            <div class="col-4">
                                Privilages
                            </div>
                            <div class="col-8" id="privilages-detail">
                                : Loading
                            </div>
                        </div>
                        <div class="row py-2">
                            <div class="col-4">
                                Manufacturer
                            </div>
                            <div class="col-8" id="manufacturer-detail">
                                : Loading
                            </div>
                        </div>
                        <div class="row py-2">
                            <div class="col-4">
                                GAMP Category
                            </div>
                            <div class="col-8" id="gamp-category-detail">
                                : Loading
                            </div>
                        </div>
                        <div class="row py-2">
                            <div class="col-4">
                                CSV Status
                            </div>
                            <div class="col-8" id="csv-status-detail">
                                : Loading
                            </div>
                        </div>
                        <div class="row py-2">
                            <div class="col-4">
                                CSV Completed On
                            </div>
                            <div class="col-8" id="csv-completed-on-detail">
                                : Loading
                            </div>
                        </div>
                        <div class="row py-2">
                            <div class="col-4">
                                Periodic Review
                            </div>
                            <div class="col-8" id="periodic-review-detail">
                                : Loading
                            </div>
                        </div>
                        <div class="row py-2">
                            <div class="col-4">
                                GXP Status
                            </div>
                            <div class="col-8" id="gxp-status-detail">
                                : Loading
                            </div>
                        </div>
                        <div class="row py-2">
                            <div class="col-4">
                                Backup Mode
                            </div>
                            <div class="col-8" id="backup-mode-detail">
                                : Loading
                            </div>
                        </div>
                        <div class="row py-2">
                            <div class="col-4">
                                Data Type
                            </div>
                            <div class="col-8" id="data-type-detail">
                                : Loading
                            </div>
                        </div>
                        <div class="row py-2">
                            <div class="col-4">
                                Vendor Details
                            </div>
                            <div class="col-8" id="vendor-detail">
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
                        {{-- <div class="row">
                      <div class="col mb-3">
                          <label for="nameWithTitle" class="add-location-company">Company<span
                                  class="text-danger ps-1 fs-6">*</span></label>
                          <select name="company_id" id="add-location-company" readonly class="form-control">
                              <option value="" disabled selected>Select Company</option>
                              @foreach ($companies as $company)
                                  <option value="{{ $company->id }}">{{ $company->name }}</option>
                              @endforeach
                          </select>
                      </div>
                  </div>
                  <div class="mb-3">
                      <label class="form-label" for="add-location-name">Location Name<span
                              class="text-danger ps-1 fs-6">*</span></label>
                      <input type="text" id="add-location-name" class="form-control" placeholder="California"
                          name="location_name" readonly/>
                  </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
