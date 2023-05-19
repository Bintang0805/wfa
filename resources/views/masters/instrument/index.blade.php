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
    <script src="{{ asset('js/instrument.js') }}"></script>
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
            <h5 class="card-title mb-0">Instrument Table</h5>
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-instruments table border-top">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th class="text-nowrap">Intrument Name</th>
                        <th class="text-nowrap">Intrument Make</th>
                        <th class="text-nowrap">Intrument Model</th>
                        <th class="text-nowrap">Status</th>
                        <th class="text-nowrap">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($instruments as $instrument)
                        <tr>
                            <td>{{ $instrument->id }}</td>
                            <td>{{ $instrument->instrument_name }}</td>
                            <td>{{ $instrument->instrument_make }}</td>
                            <td>{{ $instrument->instrument_model }}</td>
                            <td>{{ $instrument->status == 1 ? 'Active' : 'Retired' }}</td>
                            <td class="d-flex">
                                <button class="detail-button btn btn-sm btn-secondary" data-id="{{ $instrument->id }}"
                                    data-bs-toggle="modal" data-bs-target="#modalCenterDetail">
                                    Detail
                                </button>
                                <button class="edit-button btn btn-sm btn-primary mx-2" data-id="{{ $instrument->id }}"
                                    data-bs-toggle="modal" data-bs-target="#modalCenter">
                                    Edit
                                </button>
                                <form action="{{ route('instruments.destroy', ['instrument' => $instrument]) }}"
                                    id="DeleteForm" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="showPermission()">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Offcanvas to add new instrument -->
        {{-- <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddInstrument"
            aria-labelledby="offcanvasAddInstrumentLabel">
            <div class="offcanvas-header">
                <h5 id="offcanvasAddInstrumentLabel" class="offcanvas-title">Add Instrument</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body mx-0 flex-grow-0">
                <form class="add-new-instrument pt-0" id="addNewInstrumentForm" method="POST"
                    action="{{ route('instruments.store') }}">
                    @csrf
                    <input type="hidden" name="id" id="instrument_id">
                    <div class="mb-3">
                        <label class="form-label" for="add-instrument-department">Department</label>
                        <select name="department_id" id="add-instrument-department" class="form-control">
                            <option value="" disabled selected>Select Department</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->department }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="add-instrument-type">Instrument Type</label>
                        <select name="instrument_type_id" id="add-instrument-type" class="form-control">
                            <option value="" disabled selected>Select Instrument Type</option>
                            @foreach ($instrument_types as $instrument_type)
                                <option value="{{ $instrument_type->id }}">{{ $instrument_type->instrument_type }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="add-instrument-name">Instrument Name</label>
                        <input type="text" id="add-instrument-name" class="form-control" placeholder="California"
                            name="instrument_name" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="add-instrument-make">Instrument Make</label>
                        <input type="text" id="add-instrument-make" class="form-control" placeholder="California"
                            name="instrument_make" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="add-instrument-model">Instrument Model</label>
                        <input type="text" id="add-instrument-model" class="form-control" placeholder="California"
                            name="instrument_model" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="add-data-storage">Data Storage</label>
                        <select name="data_storage" id="add-data-storage" class="form-control">
                            <option value="" disabled selected>Select Data Storage</option>
                            @foreach ($data_storage_types as $data_storage_type)
                                <option value="{{ $data_storage_type }}">{{ $data_storage_type }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="add-indirect-impact">Indirect Impact</label>
                        <select name="indirect_impact" id="add-indirect-impact" class="form-control">
                            <option value="" disabled selected>Select Indirect Impact</option>
                            @foreach ($indirect_impact_types as $indirect_impact_type)
                                <option value="{{ $indirect_impact_type }}">{{ $indirect_impact_type }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="add-qualification-status">Qualification Status</label>
                        <select name="qualification_status" id="add-qualification-status" class="form-control">
                            <option value="" disabled selected>Select Qualification Status</option>
                            @foreach ($qualification_status_types as $qualification_status_type)
                                <option value="{{ $qualification_status_type }}">{{ $qualification_status_type }}
                                </option>
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
                        <label class="form-label" for="add-computer-connected">Computer Connected</label>
                        <select name="computer_connected" id="add-computer-connected" class="form-control">
                            <option value="" disabled selected>Select Computer Connected</option>
                            @foreach ($computer_connected_types as $computer_connected_type)
                                <option value="{{ $computer_connected_type }}">{{ $computer_connected_type }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="add-instrument-asset-code">Instrument Asset Code</label>
                        <input type="text" id="add-instrument-asset-code" class="form-control"
                            placeholder="California" name="instrument_asset_code" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="add-status">Status</label>
                        <select name="status" id="add-status" class="form-control">
                            <option value="" disabled selected>Select Status</option>
                            <option value="1">Active</option>
                            <option value="0">Retired</option>
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
                    <form action="{{ route('instruments.store') }}" method="post" id="addNewInstrumentForm">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalCenterTitle">Form Instrument</h5>
                            <button type="reset" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                    <div class="alert alert-danger mx-1" role="alert">
                                        {{ $error }}
                                    </div>
                                @endforeach
                            @endif
                            <input type="hidden" name="id" id="instrument_id">
                            <div class="mb-3">
                                <label class="form-label" for="add-instrument-department">Department<span
                                        class="text-danger ps-1 fs-6">*</span></label>
                                <select name="department_id" id="add-instrument-department" class="form-control">
                                    <option value="" disabled selected>Select Department</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->department }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="add-instrument-type">Instrument Type<span
                                        class="text-danger ps-1 fs-6">*</span></label>
                                <select name="instrument_type_id" id="add-instrument-type" class="form-control">
                                    <option value="" disabled selected>Select Instrument Type</option>
                                    @foreach ($instrument_types as $instrument_type)
                                        <option value="{{ $instrument_type->id }}">
                                            {{ $instrument_type->instrument_type }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="add-instrument-name">Instrument Name<span
                                        class="text-danger ps-1 fs-6">*</span></label>
                                <input type="text" id="add-instrument-name" class="form-control"
                                    placeholder="California" name="instrument_name" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="add-instrument-make">Instrument Make<span
                                        class="text-danger ps-1 fs-6">*</span></label>
                                <input type="text" id="add-instrument-make" class="form-control"
                                    placeholder="California" name="instrument_make" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="add-instrument-model">Instrument Model<span
                                        class="text-danger ps-1 fs-6">*</span></label>
                                <input type="text" id="add-instrument-model" class="form-control"
                                    placeholder="California" name="instrument_model" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="add-data-storage">Data Storage<span
                                        class="text-danger ps-1 fs-6">*</span></label>
                                <select name="data_storage" id="add-data-storage" class="form-control">
                                    <option value="" disabled selected>Select Data Storage</option>
                                    @foreach ($data_storage_types as $data_storage_type)
                                        <option value="{{ $data_storage_type }}">{{ $data_storage_type }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="add-indirect-impact">Indirect Impact<span
                                        class="text-danger ps-1 fs-6">*</span></label>
                                <select name="indirect_impact" id="add-indirect-impact" class="form-control">
                                    <option value="" disabled selected>Select Indirect Impact</option>
                                    @foreach ($indirect_impact_types as $indirect_impact_type)
                                        <option value="{{ $indirect_impact_type }}">{{ $indirect_impact_type }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="add-qualification-status">Qualification Status<span
                                        class="text-danger ps-1 fs-6">*</span></label>
                                <select name="qualification_status" id="add-qualification-status" class="form-control">
                                    <option value="" disabled selected>Select Qualification Status</option>
                                    @foreach ($qualification_status_types as $qualification_status_type)
                                        <option value="{{ $qualification_status_type }}">{{ $qualification_status_type }}
                                        </option>
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
                                <label class="form-label" for="add-computer-connected">Computer Connected<span
                                        class="text-danger ps-1 fs-6">*</span></label>
                                <select name="computer_connected" id="add-computer-connected" class="form-control">
                                    <option value="" disabled selected>Select Computer Connected</option>
                                    @foreach ($computer_connected_types as $computer_connected_type)
                                        <option value="{{ $computer_connected_type }}">{{ $computer_connected_type }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="add-instrument-asset-code">Instrument Asset Code<span
                                        class="text-danger ps-1 fs-6">*</span></label>
                                <input type="text" id="add-instrument-asset-code" class="form-control"
                                    placeholder="California" name="instrument_asset_code" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="add-status">Status<span
                                        class="text-danger ps-1 fs-6">*</span></label>
                                <select name="status" id="add-status" class="form-control">
                                    <option value="" disabled selected>Select Status</option>
                                    <option value="1">Active</option>
                                    <option value="0">Retired</option>
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
                        <h5 class="modal-title" id="modalCenterTitle">Detail Instrument</h5>
                        <button type="reset" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row py-2">
                            <div class="col-4">
                                Instrument Id
                            </div>
                            <div class="col-8" id="instrument-id-detail">
                                : Loading
                            </div>
                        </div>
                        <div class="row py-2">
                            <div class="col-4">
                                Instrument Name
                            </div>
                            <div class="col-8" id="instrument-name-detail">
                                : Loading
                            </div>
                        </div>
                        <div class="row py-2">
                            <div class="col-4">
                                Instrument Type
                            </div>
                            <div class="col-8" id="instrument-type-detail">
                                : Loading
                            </div>
                        </div>
                        <div class="row py-2">
                            <div class="col-4">
                                Instrument Make
                            </div>
                            <div class="col-8" id="instrument-make-detail">
                                : Loading
                            </div>
                        </div>
                        <div class="row py-2">
                            <div class="col-4">
                                Instrument Model
                            </div>
                            <div class="col-8" id="instrument-model-detail">
                                : Loading
                            </div>
                        </div>
                        <div class="row py-2">
                            <div class="col-4">
                                Data Storage
                            </div>
                            <div class="col-8" id="data-storage-detail">
                                : Loading
                            </div>
                        </div>
                        <div class="row py-2">
                            <div class="col-4">
                                Indirect Impact
                            </div>
                            <div class="col-8" id="indirect-impact-detail">
                                : Loading
                            </div>
                        </div>
                        <div class="row py-2">
                            <div class="col-4">
                                Qualification Status
                            </div>
                            <div class="col-8" id="qualification-status-detail">
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
                                Computer Connected
                            </div>
                            <div class="col-8" id="computer-connected-detail">
                                : Loading
                            </div>
                        </div>
                        <div class="row py-2">
                            <div class="col-4">
                                Instrument Asset Code
                            </div>
                            <div class="col-8" id="instrument-asset-code-detail">
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
                                Department Id
                            </div>
                            <div class="col-8" id="department-id-detail">
                                : Loading
                            </div>
                        </div>
                        <div class="row py-2">
                            <div class="col-4">
                                Department Name
                            </div>
                            <div class="col-8" id="department-name-detail">
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
