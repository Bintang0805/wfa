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
    <script src="{{ asset('js/instrument.js') }}"></script>
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
            <h5 class="card-title mb-0">Instrument Table</h5>
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-instruments table border-top">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th class="text-nowrap">Location Name</th>
                        <th class="text-nowrap">Facility Name</th>
                        <th class="text-nowrap">Department</th>
                        <th class="text-nowrap">Intrument Type</th>
                        <th class="text-nowrap">Intrument Name</th>
                        <th class="text-nowrap">Intrument Make</th>
                        <th class="text-nowrap">Intrument Model</th>
                        <th class="text-nowrap">Data Storage</th>
                        <th class="text-nowrap">Indirect Impact</th>
                        <th class="text-nowrap">Qualification Status</th>
                        <th class="text-nowrap">CSV Status</th>
                        <th class="text-nowrap">Computer Connected</th>
                        <th class="text-nowrap">Instrument Asset Code</th>
                        <th class="text-nowrap">Status</th>
                        <th class="text-nowrap">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($instruments as $instrument)
                        <tr>
                            <td>{{ $instrument->id }}</td>
                            <td>{{ $instrument->location->location_name }}</td>
                            <td>{{ $instrument->facility->facility_name }}</td>
                            <td>{{ $instrument->department->department }}</td>
                            <td>{{ $instrument->instrument_type->instrument_type }}</td>
                            <td>{{ $instrument->instrument_name }}</td>
                            <td>{{ $instrument->instrument_make }}</td>
                            <td>{{ $instrument->instrument_model }}</td>
                            <td>{{ $instrument->data_storage }}</td>
                            <td>{{ $instrument->indirect_impact }}</td>
                            <td>{{ $instrument->qualification_status }}</td>
                            <td>{{ $instrument->csv_status }}</td>
                            <td>{{ $instrument->computer_connected }}</td>
                            <td>{{ $instrument->instrument_asset_code }}</td>
                            <td>{{ $instrument->status }}</td>
                            <td class="d-flex">
                                <form action="{{ route('instruments.destroy', ['instrument' => $instrument]) }}"
                                    id="DeleteForm" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="showPermission()">Delete</button>
                                </form>
                                <button class="edit-button btn btn-primary mx-2" data-id="{{ $instrument->id }}"
                                    data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddInstrument">
                                    Edit
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Offcanvas to add new instrument -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddInstrument"
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
        </div>
    </div>
@endsection
