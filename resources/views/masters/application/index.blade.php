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
@endsection

<!-- Page -->
@section('page-style')

@endsection

@section('page-script')
    <script src="{{ asset('js/application.js') }}"></script>
    @if (session('success'))
        <script>
            $(function() {
                Swal.fire({
                    icon: 'success',
                    title: "Yeiy",
                    text: "{{ session('success') }}",
                    showConfirmButton: false,
                    timer: 2500
                });
            })
        </script>
    @endif
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
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger" role="alert">
                {{ $error }}
            </div>
        @endforeach
    @endif
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Application Table</h5>
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-applications table border-top">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th class="text-nowrap">Application Name</th>
                        <th class="text-nowrap">Application Ver</th>
                        <th class="text-nowrap">Connected To Computer</th>
                        <th class="text-nowrap">Location Name</th>
                        <th class="text-nowrap">Facility Name</th>
                        <th class="text-nowrap">Department</th>
                        <th class="text-nowrap">Connected To Server</th>
                        <th class="text-nowrap">Application Role Type</th>
                        <th class="text-nowrap">Privilages</th>
                        <th class="text-nowrap">Manufacturer</th>
                        <th class="text-nowrap">Gamp Category</th>
                        <th class="text-nowrap">CSV Status</th>
                        <th class="text-nowrap">CSV Completed On</th>
                        <th class="text-nowrap">Periodic Review</th>
                        <th class="text-nowrap">GXP Status</th>
                        <th class="text-nowrap">Backup Mode</th>
                        <th class="text-nowrap">Data Type</th>
                        <th class="text-nowrap">Vendor Details</th>
                        <th class="text-nowrap">Status</th>
                        <th class="text-nowrap">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($applications as $application)
                        <tr>
                            <td>{{ $application->id }}</td>
                            <td>{{ $application->application_name }}</td>
                            <td>{{ $application->application_ver }}</td>
                            <td>{{ $application->connected_to_computer }}</td>
                            <td>{{ $application->location->location_name }}</td>
                            <td>{{ $application->facility->facility_name }}</td>
                            <td>{{ $application->department->department }}</td>
                            <td>{{ $application->connected_to_server }}</td>
                            <td>{{ $application->application_role_type }}</td>
                            <td>{{ $application->privilages }}</td>
                            <td>{{ $application->manufacturer }}</td>
                            <td>{{ $application->gamp_category }}</td>
                            <td>{{ $application->csv_status }}</td>
                            <td>{{ $application->csv_completed_on }}</td>
                            <td>{{ $application->periodic_review }}</td>
                            <td>{{ $application->gxp_status }}</td>
                            <td>{{ $application->backup_mode }}</td>
                            <td>{{ $application->data_type }}</td>
                            <td>{{ $application->vendor_details }}</td>
                            <td>{{ $application->status }}</td>
                            <td class="d-flex">
                                <form action="{{ route('applications.destroy', ['application' => $application]) }}"
                                    id="DeleteForm" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="showPermission()">Delete</button>
                                </form>
                                <button class="edit-button btn btn-primary mx-2" data-id="{{ $application->id }}"
                                    data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddApplication">
                                    Edit
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Offcanvas to add new equipment -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddApplication"
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
                        {{-- <input type="text" id="add-application-ver" class="form-control" placeholder="California"
                          name="application_ver" /> --}}
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
                        {{-- <input type="text" id="add-application-ver" class="form-control" placeholder="California"
                        name="application_ver" /> --}}
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
        </div>
    </div>
@endsection
