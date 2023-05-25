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
    <script src="{{ asset('js/equipment.js') }}"></script>
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
        <div class="bs-toast toast fade show bg-danger position-fixed bottom-0 end-0 me-4 mb-4 error-message" role="alert"
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
            <h5 class="card-title mb-0">Equipment Table</h5>
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-equipments table border-top">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th class="text-nowrap">Equipment Name</th>
                        <th class="text-nowrap">Equipment Number</th>
                        <th class="text-nowrap">Status</th>
                        <th class="text-nowrap">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($equipments as $equipment)
                        <tr>
                            <td>{{ $equipment->id }}</td>
                            <td>{{ $equipment->equipment_name }}</td>
                            <td>{{ $equipment->equipment_number }}</td>
                            <td>{{ $equipment->status == 1 ? 'Active' : 'Retired' }}</td>
                            <td class="d-flex">
                                <button class="edit-button btn btn-sm btn-primary" data-id="{{ $equipment->id }}"
                                    data-bs-toggle="modal" data-bs-target="#modalCenter">
                                    <i class="bx bx-edit"></i>
                                </button>
                                <form action="{{ route('equipments.destroy', ['equipment' => $equipment]) }}"
                                    class="DeleteForm" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger mx-2"
                                        onclick="showPermission(this.parentNode)"><i class="bx bx-trash"></i></button>
                                </form>
                                <button class="detail-button btn btn-sm btn-secondary" data-id="{{ $equipment->id }}"
                                    data-bs-toggle="modal" data-bs-target="#modalCenterDetail">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Offcanvas to add new equipment -->
        {{-- <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddEquipment"
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
        </div> --}}
    </div>

    <div class="mt-3">
        <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true"
            data-errors="{{ $errors->any() == true ? true : false }}">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <form action="{{ route('equipments.store') }}" method="post" id="addNewEquipmentForm">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalCenterTitle">Form Equipment</h5>
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
                            <input type="hidden" name="id" id="equipment_id">
                            <div class="row">
                                <div class="mb-3 col-lg-6 col-12">
                                    <label class="form-label" for="add-equipment-department">Department<span
                                            class="text-danger ps-1 fs-6">*</span></label>
                                    <select name="department_id" id="add-equipment-department" class="form-control">
                                        <option value="" disabled selected>Select Department</option>
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}">{{ $department->department }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3 col-lg-6 col-12">
                                    <label class="form-label" for="add-equipment-type">Equipment Type<span
                                            class="text-danger ps-1 fs-6">*</span></label>
                                    <select name="equipment_type_id" id="add-equipment-type" class="form-control">
                                        <option value="" disabled selected>Select Equipment Type</option>
                                        @foreach ($equipment_types as $equipment_type)
                                            <option value="{{ $equipment_type->id }}">
                                                {{ $equipment_type->equipment_type }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3 col-lg-6 col-12">
                                    <label class="form-label" for="add-equipment-name">Equipment Name<span
                                            class="text-danger ps-1 fs-6">*</span></label>
                                    <input type="text" id="add-equipment-name" class="form-control"
                                        placeholder="California" name="equipment_name" />
                                </div>
                                <div class="mb-3 col-lg-6 col-12">
                                    <label class="form-label" for="add-equipment-make">Equipment Make<span
                                            class="text-danger ps-1 fs-6">*</span></label>
                                    <input type="text" id="add-equipment-make" class="form-control"
                                        placeholder="California" name="equipment_make" />
                                </div>
                                <div class="mb-3 col-lg-6 col-12">
                                    <label class="form-label" for="add-equipment-model">Equipment Model<span
                                            class="text-danger ps-1 fs-6">*</span></label>
                                    <input type="text" id="add-equipment-model" class="form-control"
                                        placeholder="California" name="equipment_model" />
                                </div>
                                <div class="mb-3 col-lg-6 col-12">
                                    <label class="form-label" for="add-data-storage">Data Storage<span
                                            class="text-danger ps-1 fs-6">*</span></label>
                                    <select name="data_storage" id="add-data-storage" class="form-control">
                                        <option value="" disabled selected>Select Data Storage</option>
                                        @foreach ($data_storage_types as $data_storage_type)
                                            <option value="{{ $data_storage_type }}">{{ $data_storage_type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3 col-lg-6 col-12">
                                    <label class="form-label" for="add-indirect-impact">Indirect Impact<span
                                            class="text-danger ps-1 fs-6">*</span></label>
                                    <select name="indirect_impact" id="add-indirect-impact" class="form-control">
                                        <option value="" disabled selected>Select Indirect Impact</option>
                                        @foreach ($indirect_impact_types as $indirect_impact_type)
                                            <option value="{{ $indirect_impact_type }}">{{ $indirect_impact_type }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3 col-lg-6 col-12">
                                    <label class="form-label" for="add-qualification-status">Qualification Status<span
                                            class="text-danger ps-1 fs-6">*</span></label>
                                    <select name="qualification_status" id="add-qualification-status"
                                        class="form-control">
                                        <option value="" disabled selected>Select Qualification Status</option>
                                        @foreach ($qualification_status_types as $qualification_status_type)
                                            <option value="{{ $qualification_status_type }}">
                                                {{ $qualification_status_type }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3 col-lg-6 col-12">
                                    <label class="form-label" for="add-csv-status">CSV Status<span
                                            class="text-danger ps-1 fs-6">*</span></label>
                                    <select name="csv_status" id="add-csv-status" class="form-control">
                                        <option value="" disabled selected>Select CSV Status</option>
                                        @foreach ($csv_status_types as $csv_status_type)
                                            <option value="{{ $csv_status_type }}">{{ $csv_status_type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3 col-lg-6 col-12">
                                    <label class="form-label" for="add-equipment-number">Equipment Number<span
                                            class="text-danger ps-1 fs-6">*</span></label>
                                    <input type="text" id="add-equipment-number" class="form-control"
                                        placeholder="California" name="equipment_number" />
                                </div>
                                <div class="mb-3 col-lg-6 col-12">
                                    <label class="form-label" for="add-status">Status<span
                                            class="text-danger ps-1 fs-6">*</span></label>
                                    <select name="status" id="add-status" class="form-control">
                                        <option value="" disabled selected>Select Status</option>
                                        <option value="1">Active</option>
                                        <option value="0">Retired</option>
                                    </select>
                                </div>
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
                        <h5 class="modal-title" id="modalCenterTitle">Detail Equipment</h5>
                        <button type="reset" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row py-2">
                            <div class="col-4">
                                Equipment Id
                            </div>
                            <div class="col-8" id="equipment-id-detail">
                                : Loading
                            </div>
                        </div>
                        <div class="row py-2">
                            <div class="col-4">
                                Equipment Name
                            </div>
                            <div class="col-8" id="equipment-name-detail">
                                : Loading
                            </div>
                        </div>
                        <div class="row py-2">
                            <div class="col-4">
                                Equipment Type
                            </div>
                            <div class="col-8" id="equipment-type-detail">
                                : Loading
                            </div>
                        </div>
                        <div class="row py-2">
                            <div class="col-4">
                                Equipment Make
                            </div>
                            <div class="col-8" id="equipment-make-detail">
                                : Loading
                            </div>
                        </div>
                        <div class="row py-2">
                            <div class="col-4">
                                Equipment Model
                            </div>
                            <div class="col-8" id="equipment-model-detail">
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
                                Equipment Number
                            </div>
                            <div class="col-8" id="equipment-number-detail">
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
