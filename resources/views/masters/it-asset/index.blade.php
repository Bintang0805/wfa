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
    <script src="{{ asset('js/it-asset.js') }}"></script>
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
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">IT Asset Table</h5>
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-it-assets table border-top">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th class="text-nowrap">IT Asset Make</th>
                        <th class="text-nowrap">IT Asset Model</th>
                        <th class="text-nowrap">OEM SL No</th>
                        <th class="text-nowrap">Status</th>
                        <th class="text-nowrap">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($it_assets as $it_asset)
                        <tr>
                            <td>{{ $it_asset->id }}</td>
                            <td>{{ $it_asset->make }}</td>
                            <td>{{ $it_asset->model }}</td>
                            <td>{{ $it_asset->oem_sl_no }}</td>
                            <td>{{ $it_asset->asset_status }}</td>
                            <td class="d-flex">
                                <button class="edit-button btn btn-sm btn-primary" data-id="{{ $it_asset->id }}"
                                    data-bs-toggle="modal" data-bs-target="#modalCenter">
                                    <i class="bx bx-edit"></i>
                                </button>
                                <form action="{{ route('it-assets.destroy', ['it_asset' => $it_asset]) }}" id="DeleteForm"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger mx-2" onclick="showPermission()"><i
                                            class="bx bx-trash"></i></button>
                                </form>
                                <button class="detail-button btn btn-sm btn-secondary" data-id="{{ $it_asset->id }}"
                                    data-bs-toggle="modal" data-bs-target="#modalCenterDetail">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Offcanvas to add new it asset -->
        {{-- <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddItAsset"
            aria-labelledby="offcanvasAddItAssetLabel">
            <div class="offcanvas-header">
                <h5 id="offcanvasAddItAssetLabel" class="offcanvas-title">Add IT Asset</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body mx-0 flex-grow-0">
                <form class="add-new-it-asset pt-0" id="addNewItAssetForm" method="POST"
                    action="{{ route('it-assets.store') }}">
                    @csrf
                    <input type="hidden" name="id" id="it_asset_id">
                    <div class="mb-3">
                        <label class="form-label" for="add-it-asset-department">Department</label>
                        <select name="department_id" id="add-it-asset-department" class="form-control">
                            <option value="" disabled selected>Select Department</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->department }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="add-it-asset-type">It Asset Type</label>
                        <select name="it_asset_type_id" id="add-it-asset-type" class="form-control">
                            <option value="" disabled selected>Select IT Asset Type</option>
                            @foreach ($it_asset_types as $it_asset_type)
                                <option value="{{ $it_asset_type->id }}">{{ $it_asset_type->it_asset_type }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="add-make">IT Asset Make</label>
                        <input type="text" id="add-make" class="form-control" placeholder="California"
                            name="make" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="add-model">IT Asset Model</label>
                        <input type="text" id="add-model" class="form-control" placeholder="California"
                            name="model" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="add-oem-sl-no">OEM SL No</label>
                        <input type="text" id="add-oem-sl-no" class="form-control" placeholder="California"
                            name="oem_sl_no" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="add-host-name">Host Name</label>
                        <input type="text" id="add-host-name" class="form-control" placeholder="California"
                            name="host_name" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="add-ip-address">IP Address</label>
                        <input type="text" id="add-ip-address" class="form-control" placeholder="California"
                            name="ip_address" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="add-asset-type">Asset Type</label>
                        <select name="asset_type" id="add-asset-type" class="form-control">
                            <option value="" disabled selected>Select Asset Type</option>
                            @foreach ($asset_types as $asset_type)
                                <option value="{{ $asset_type }}">{{ $asset_type }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="add-os-ver">OS Ver</label>
                        <input type="text" id="add-os-ver" class="form-control" placeholder="California"
                            name="os_ver" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="add-asset-status">Asset Status</label>
                        <select name="asset_status" id="add-asset-status" class="form-control">
                            <option value="" disabled selected>Select Status</option>
                            <option value="Active">Active</option>
                            <option value="Retired">Retired</option>
                            <option value="Stock">Stock</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="add-owner-name">Owner Name</label>
                        <input type="text" id="add-owner-name" class="form-control" placeholder="California"
                            name="owner_name" />
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
                    <form action="{{ route('it-assets.store') }}" method="post" id="addNewItAssetForm">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalCenterTitle">Form IT Asset</h5>
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
                            <input type="hidden" name="id" id="it_asset_id">
                            <div class="row">
                                <div class="mb-3 col-lg-6 col-12">
                                    <label class="form-label" for="add-it-asset-department">Department<span
                                            class="text-danger ps-1 fs-6">*</span></label>
                                    <select name="department_id" id="add-it-asset-department" class="form-control">
                                        <option value="" disabled selected>Select Department</option>
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}">{{ $department->department }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3 col-lg-6 col-12">
                                    <label class="form-label" for="add-it-asset-type">It Asset Type<span
                                            class="text-danger ps-1 fs-6">*</span></label>
                                    <select name="it_asset_type_id" id="add-it-asset-type" class="form-control">
                                        <option value="" disabled selected>Select IT Asset Type</option>
                                        @foreach ($it_asset_types as $it_asset_type)
                                            <option value="{{ $it_asset_type->id }}">{{ $it_asset_type->it_asset_type }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3 col-lg-6 col-12">
                                    <label class="form-label" for="add-make">IT Asset Make<span
                                            class="text-danger ps-1 fs-6">*</span></label>
                                    <input type="text" id="add-make" class="form-control" placeholder="California"
                                        name="make" />
                                </div>
                                <div class="mb-3 col-lg-6 col-12">
                                    <label class="form-label" for="add-model">IT Asset Model<span
                                            class="text-danger ps-1 fs-6">*</span></label>
                                    <input type="text" id="add-model" class="form-control" placeholder="California"
                                        name="model" />
                                </div>
                                <div class="mb-3 col-lg-6 col-12">
                                    <label class="form-label" for="add-oem-sl-no">OEM SL No<span
                                            class="text-danger ps-1 fs-6">*</span></label>
                                    <input type="text" id="add-oem-sl-no" class="form-control"
                                        placeholder="California" name="oem_sl_no" />
                                </div>
                                <div class="mb-3 col-lg-6 col-12">
                                    <label class="form-label" for="add-host-name">Host Name<span
                                            class="text-danger ps-1 fs-6">*</span></label>
                                    <input type="text" id="add-host-name" class="form-control"
                                        placeholder="California" name="host_name" />
                                </div>
                                <div class="mb-3 col-lg-6 col-12">
                                    <label class="form-label" for="add-ip-address">IP Address<span
                                            class="text-danger ps-1 fs-6">*</span></label>
                                    <input type="text" id="add-ip-address" class="form-control"
                                        placeholder="California" name="ip_address" />
                                </div>
                                <div class="mb-3 col-lg-6 col-12">
                                    <label class="form-label" for="add-asset-type">Asset Type<span
                                            class="text-danger ps-1 fs-6">*</span></label>
                                    <select name="asset_type" id="add-asset-type" class="form-control">
                                        <option value="" disabled selected>Select Asset Type</option>
                                        @foreach ($asset_types as $asset_type)
                                            <option value="{{ $asset_type }}">{{ $asset_type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3 col-lg-6 col-12">
                                    <label class="form-label" for="add-os-ver">OS Ver<span
                                            class="text-danger ps-1 fs-6">*</span></label>
                                    <input type="text" id="add-os-ver" class="form-control" placeholder="California"
                                        name="os_ver" />
                                </div>
                                <div class="mb-3 col-lg-6 col-12">
                                    <label class="form-label" for="add-asset-status">Asset Status<span
                                            class="text-danger ps-1 fs-6">*</span></label>
                                    <select name="asset_status" id="add-asset-status" class="form-control">
                                        <option value="" disabled selected>Select Status</option>
                                        <option value="Active">Active</option>
                                        <option value="Retired">Retired</option>
                                        <option value="Stock">Stock</option>
                                    </select>
                                </div>
                                <div class="mb-3 col-lg-6 col-12">
                                    <label class="form-label" for="add-owner-name">Owner Name<span
                                            class="text-danger ps-1 fs-6">*</span></label>
                                    <input type="text" id="add-owner-name" class="form-control"
                                        placeholder="California" name="owner_name" />
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
                        <h5 class="modal-title" id="modalCenterTitle">Detail IT Asset</h5>
                        <button type="reset" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row py-2">
                            <div class="col-4">
                                IT Asset Id
                            </div>
                            <div class="col-8" id="it-asset-id-detail">
                                : Loading
                            </div>
                        </div>
                        <div class="row py-2">
                            <div class="col-4">
                                IT Asset Type Id
                            </div>
                            <div class="col-8" id="it-asset-type-id-detail">
                                : Loading
                            </div>
                        </div>
                        <div class="row py-2">
                            <div class="col-4">
                                IT Asset Type
                            </div>
                            <div class="col-8" id="it-asset-type-detail">
                                : Loading
                            </div>
                        </div>
                        <div class="row py-2">
                            <div class="col-4">
                                IT Asset Make
                            </div>
                            <div class="col-8" id="it-asset-make-detail">
                                : Loading
                            </div>
                        </div>
                        <div class="row py-2">
                            <div class="col-4">
                                IT Asset Model
                            </div>
                            <div class="col-8" id="it-asset-model-detail">
                                : Loading
                            </div>
                        </div>
                        <div class="row py-2">
                            <div class="col-4">
                                OEM SL No
                            </div>
                            <div class="col-8" id="oem-sl-no-detail">
                                : Loading
                            </div>
                        </div>
                        <div class="row py-2">
                            <div class="col-4">
                                IP Address
                            </div>
                            <div class="col-8" id="ip-address-detail">
                                : Loading
                            </div>
                        </div>
                        <div class="row py-2">
                            <div class="col-4">
                                Host Name
                            </div>
                            <div class="col-8" id="host-name-detail">
                                : Loading
                            </div>
                        </div>
                        <div class="row py-2">
                            <div class="col-4">
                                Asset Type
                            </div>
                            <div class="col-8" id="asset-type-detail">
                                : Loading
                            </div>
                        </div>
                        <div class="row py-2">
                            <div class="col-4">
                                Os Ver
                            </div>
                            <div class="col-8" id="os-ver-detail">
                                : Loading
                            </div>
                        </div>
                        <div class="row py-2">
                            <div class="col-4">
                                Asset Status
                            </div>
                            <div class="col-8" id="asset-status-detail">
                                : Loading
                            </div>
                        </div>
                        <div class="row py-2">
                            <div class="col-4">
                                Owner Name
                            </div>
                            <div class="col-8" id="owner-name-detail">
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
                                Department
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
