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
    <script src="{{ asset('js/equipment.js') }}"></script>
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
            <h5 class="card-title mb-0">Equipment Table</h5>
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-equipments table border-top">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th class="text-nowrap">Location Name</th>
                        <th class="text-nowrap">Facility Name</th>
                        <th class="text-nowrap">Department</th>
                        <th class="text-nowrap">Equipment Type</th>
                        <th class="text-nowrap">Equipment Name</th>
                        <th class="text-nowrap">Equipment Make</th>
                        <th class="text-nowrap">Equipment Model</th>
                        <th class="text-nowrap">Data Storage</th>
                        <th class="text-nowrap">Indirect Impact</th>
                        <th class="text-nowrap">Qualification Status</th>
                        <th class="text-nowrap">CSV Status</th>
                        <th class="text-nowrap">Equipment Number</th>
                        <th class="text-nowrap">Status</th>
                        <th class="text-nowrap">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($equipments as $equipment)
                        <tr>
                            <td>{{ $equipment->id }}</td>
                            <td>{{ $equipment->location->location_name }}</td>
                            <td>{{ $equipment->facility->facility_name }}</td>
                            <td>{{ $equipment->department->department }}</td>
                            <td>{{ $equipment->equipment_type->equipment_type }}</td>
                            <td>{{ $equipment->equipment_name }}</td>
                            <td>{{ $equipment->equipment_make }}</td>
                            <td>{{ $equipment->equipment_model }}</td>
                            <td>{{ $equipment->data_storage }}</td>
                            <td>{{ $equipment->indirect_impact }}</td>
                            <td>{{ $equipment->qualification_status }}</td>
                            <td>{{ $equipment->csv_status }}</td>
                            <td>{{ $equipment->equipment_number }}</td>
                            <td>{{ $equipment->status }}</td>
                            <td class="d-flex">
                                <form action="{{ route('equipments.destroy', ['equipment' => $equipment]) }}"
                                    id="DeleteForm" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="showPermission()">Delete</button>
                                </form>
                                <button class="edit-button btn btn-primary mx-2" data-id="{{ $equipment->id }}"
                                    data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddEquipment">
                                    Edit
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Offcanvas to add new equipment -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddEquipment"
            aria-labelledby="offcanvasAddEquipmentLabel">
            <div class="offcanvas-header">
                <h5 id="offcanvasAddEquipmentLabel" class="offcanvas-title">Add Equipment</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body mx-0 flex-grow-0">
                <form class="add-new-equipment pt-0" id="addNewEquipmentForm" method="POST"
                    action="{{ route('equipments.store') }}">
                    @csrf
                    <input type="hidden" name="id" id="equipment_id">
                    <div class="mb-3">
                        <label class="form-label" for="add-equipment-department">Department</label>
                        <select name="department_id" id="add-equipment-department" class="form-control">
                            <option value="" disabled selected>Select Department</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->department }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="add-equipment-type">Equipment Type</label>
                        <select name="equipment_type_id" id="add-equipment-type" class="form-control">
                            <option value="" disabled selected>Select Equipment Type</option>
                            @foreach ($equipment_types as $equipment_type)
                                <option value="{{ $equipment_type->id }}">{{ $equipment_type->equipment_type }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="add-equipment-name">Equipment Name</label>
                        <input type="text" id="add-equipment-name" class="form-control" placeholder="California"
                            name="equipment_name" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="add-equipment-make">Equipment Make</label>
                        <input type="text" id="add-equipment-make" class="form-control" placeholder="California"
                            name="equipment_make" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="add-equipment-model">Equipment Model</label>
                        <input type="text" id="add-equipment-model" class="form-control" placeholder="California"
                            name="equipment_model" />
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
                        <label class="form-label" for="add-equipment-number">Equipment Number</label>
                        <input type="text" id="add-equipment-number" class="form-control" placeholder="California"
                            name="equipment_number" />
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
