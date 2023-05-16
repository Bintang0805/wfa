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
    <script src="{{ asset('js/it-asset.js') }}"></script>
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
            <h5 class="card-title mb-0">IT Asset Table</h5>
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-it-assets table border-top">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th class="text-nowrap">Location Name</th>
                        <th class="text-nowrap">Facility Name</th>
                        <th class="text-nowrap">Department</th>
                        <th class="text-nowrap">IT Asset Type</th>
                        <th class="text-nowrap">IT Asset Make</th>
                        <th class="text-nowrap">IT Asset Model</th>
                        <th class="text-nowrap">OEM SL No</th>
                        <th class="text-nowrap">Host Name</th>
                        <th class="text-nowrap">IP Address</th>
                        <th class="text-nowrap">Asset Type</th>
                        <th class="text-nowrap">OS Ver</th>
                        <th class="text-nowrap">Status</th>
                        <th class="text-nowrap">Owner Name</th>
                        <th class="text-nowrap">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($it_assets as $it_asset)
                        <tr>
                            <td>{{ $it_asset->id }}</td>
                            <td>{{ $it_asset->location->location_name }}</td>
                            <td>{{ $it_asset->facility->facility_name }}</td>
                            <td>{{ $it_asset->department->department }}</td>
                            <td>{{ $it_asset->it_asset_type->it_asset_type }}</td>
                            <td>{{ $it_asset->make }}</td>
                            <td>{{ $it_asset->model }}</td>
                            <td>{{ $it_asset->oem_sl_no }}</td>
                            <td>{{ $it_asset->host_name }}</td>
                            <td>{{ $it_asset->ip_address }}</td>
                            <td>{{ $it_asset->asset_type }}</td>
                            <td>{{ $it_asset->os_ver }}</td>
                            <td>{{ $it_asset->status }}</td>
                            <td>{{ $it_asset->owner_name }}</td>
                            <td class="d-flex">
                                <form action="{{ route('it-assets.destroy', ['it_asset' => $it_asset]) }}" id="DeleteForm"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="showPermission()">Delete</button>
                                </form>
                                <button class="edit-button btn btn-primary mx-2" data-id="{{ $it_asset->id }}"
                                    data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddItAsset">
                                    Edit
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Offcanvas to add new it asset -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddItAsset"
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
                        <input type="text" id="add-make" class="form-control" placeholder="California" name="make" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="add-model">IT Asset Model</label>
                        <input type="text" id="add-model" class="form-control" placeholder="California" name="model" />
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
        </div>
    </div>
@endsection
