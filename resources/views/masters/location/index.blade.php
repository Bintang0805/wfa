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
    <script src="{{ asset('js/location.js') }}"></script>
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
    <div class="row g-4 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span>Locations</span>
                            <div class="d-flex align-items-end mt-2">
                                <h3 class="mb-0 me-2">{{ $locations->count() }}</h3>
                                <small class="text-success">(100%)</small>
                            </div>
                            <small>Total Locations</small>
                        </div>
                        <span class="badge bg-label-primary rounded p-2">
                            <i class="bx bx-user bx-sm"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span>Companies</span>
                            <div class="d-flex align-items-end mt-2">
                                <h3 class="mb-0 me-2">{{ $companies->count() }}</h3>
                                <small class="text-success">(100%)</small>
                            </div>
                            <small>Total Companies</small>
                        </div>
                        <span class="badge bg-label-danger rounded p-2">
                            <i class="bx bx-group bx-sm"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span>Facility</span>
                            <div class="d-flex align-items-end mt-2">
                                <h3 class="mb-0 me-2">{{ $facilityCount }}</h3>
                                <small class="text-success">(100%)</small>
                            </div>
                            <small>Registered Facility</small>
                        </div>
                        <span class="badge bg-label-warning rounded p-2">
                            <i class="bx bx-user-voice bx-sm"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span>Department</span>
                            <div class="d-flex align-items-end mt-2">
                                <h3 class="mb-0 me-2">{{ $departmentCount }}</h3>
                                <small class="text-success">(100%)</small>
                            </div>
                            <small>Registered Department</small>
                        </div>
                        <span class="badge bg-label-warning rounded p-2">
                            <i class="bx bx-user-voice bx-sm"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Locations Table</h5>
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-locations table border-top">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Company name</th>
                        <th>Location Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($locations as $location)
                        <tr>
                            <td>{{ $location->id }}</td>
                            <td>{{ $location->company->name }}</td>
                            <td class="location-name">{{ $location->location_name }}</td>
                            <td class="d-flex">
                                <form action="{{ route('locations.destroy', ['location' => $location]) }}" method="POST"
                                    id="DeleteForm">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="showPermission()">Delete</button>
                                </form>
                                <button class="edit-button btn btn-primary mx-2" data-id="{{ $location->id }}"
                                    data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddLocation">
                                    Edit
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Offcanvas to add new location -->
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
        </div>
    </div>
@endsection
