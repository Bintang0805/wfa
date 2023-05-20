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
    <script src="{{ asset('js/facility.js') }}"></script>
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
    <div class="row g-4 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span>Facilities</span>
                            <div class="d-flex align-items-end mt-2">
                                <h3 class="mb-0 me-2">{{ $facilities->count() }}</h3>
                                <small class="text-success">(100%)</small>
                            </div>
                            <small>Total Facilities</small>
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
                            <span>Locations</span>
                            <div class="d-flex align-items-end mt-2">
                                <h3 class="mb-0 me-2">{{ $locations->count() }}</h3>
                                <small class="text-success">(100%)</small>
                            </div>
                            <small>Total Locations</small>
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
            <h5 class="card-title mb-0">Facilities Table</h5>
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-facilities table border-top">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Facility Name</th>
                        <th>Location Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($facilities as $facility)
                        <tr>
                            <td>{{ $facility->id }}</td>
                            <td>{{ $facility->facility_name }}</td>
                            <td>{{ $facility->location->location_name }}</td>
                            <td class="d-flex">
                                <button class="edit-button btn btn-sm btn-primary" data-id="{{ $facility->id }}"
                                    data-bs-toggle="modal" data-bs-target="#modalCenter">
                                    <i class="bx bx-edit"></i>
                                </button>
                                <form action="{{ route('facilities.destroy', ['facility' => $facility]) }}" method="POST"
                                    id="DeleteForm">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger mx-2" onclick="showPermission()"><i
                                            class="bx bx-trash"></i></button>
                                </form>
                                <button class="detail-button btn btn-sm btn-secondary" data-id="{{ $facility->id }}"
                                    data-bs-toggle="modal" data-bs-target="#modalCenterDetail">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{-- <!-- Offcanvas to add new user -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddFacility"
            aria-labelledby="offcanvasAddFacilityLabel">
            <div class="offcanvas-header">
                <h5 id="offcanvasAddFacilityLabel" class="offcanvas-title">Add Facility</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body mx-0 flex-grow-0">
                <form class="add-new-facility pt-0" id="addNewFacilityForm" method="POST"
                    action="{{ route('facilities.store') }}">
                    @csrf
                    <input type="hidden" name="id" id="facility_id">
                    <div class="mb-3">
                        <label class="form-label" for="add-facility-location">Location</label>
                        <select name="location_id" id="add-facility-location" class="form-control">
                            <option value="" disabled selected>Select Location</option>
                            @foreach ($locations as $location)
                                <option value="{{ $location->id }}">{{ $location->location_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="add-facility-name">Facility Name</label>
                        <input type="text" id="add-facility-name" class="form-control" placeholder="California"
                            name="facility_name" />
                    </div>
                    <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Submit</button>
                    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">Cancel</button>
                </form>
            </div>
        </div> --}}
    </div>

    <div class="mt-3">
        <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true"
            data-errors="{{ $errors->any() == true ? true : false }}">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form class="add-new-facility pt-0" id="addNewFacilityForm" method="POST"
                        action="{{ route('facilities.store') }}">
                        @csrf
                        <input type="hidden" name="id" id="facility_id">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalCenterTitle">Form Facility</h5>
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
                            <div class="mb-3">
                                <label class="form-label" for="add-facility-location">Location<span
                                        class="text-danger ps-1 fs-6">*</span></label>
                                <select name="location_id" id="add-facility-location" class="form-control">
                                    <option value="" disabled selected>Select Location</option>
                                    @foreach ($locations as $location)
                                        <option value="{{ $location->id }}">{{ $location->location_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="add-facility-name">Facility Name<span
                                        class="text-danger ps-1 fs-6">*</span></label>
                                <input type="text" id="add-facility-name" class="form-control"
                                    placeholder="California" name="facility_name" />
                            </div>
                            {{-- <div class="row">
                              <div class="col mb-3">
                                <label for="nameWithTitle" class="add-location-company">Company<span
                                          class="text-danger ps-1 fs-6">*</span></label>
                                  <select name="company_id" id="add-location-company" class="form-control">
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
                                <input type="text" id="add-location-name" class="form-control"
                                placeholder="California" name="location_name" />
                              </div> --}}
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
                        <h5 class="modal-title" id="modalCenterTitle">Detail Facility</h5>
                        <button type="reset" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row py-2">
                            <div class="col-4">
                                Facility Id
                            </div>
                            <div class="col-8" id="facility-id-detail">
                                : Loading
                            </div>
                        </div>
                        <div class="row py-2">
                            <div class="col-4">
                                Facility Name
                            </div>
                            <div class="col-8" id="facility-name-detail">
                                : Loading
                            </div>
                        </div>
                        <div class="row py-2">
                            <div class="col-4">
                                Location Id
                            </div>
                            <div class="col-8" id="location-id">
                                : Loading
                            </div>
                        </div>
                        <div class="row py-2">
                            <div class="col-4">
                                Location Name
                            </div>
                            <div class="col-8" id="location-name-detail">
                                : Loading
                            </div>
                        </div>
                        <table class="table table-striped mt-4">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Department Id</th>
                                    <th scope="col">Department Name</th>
                                </tr>
                            </thead>
                            <tbody id="TableBody">
                                {{-- <tr>
                                    <th scope="row">1</th>
                                    <td >Mark</td>
                                    <td>Otto</td>
                                </tr> --}}
                            </tbody>
                        </table>
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
