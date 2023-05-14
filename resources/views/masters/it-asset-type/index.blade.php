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
<script src="{{ asset('js/it-asset-type.js') }}"></script>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">It Asset Types Table</h5>
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-it-asset-types table border-top">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>It Asset Type</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                  @foreach ($it_asset_types as $it_asset_type)
                  <tr>
                    <td>{{ $it_asset_type->id }}</td>
                    <td>{{ $it_asset_type->it_asset_type }}</td>
                    <td class="d-flex">
                      <form action="{{ route('it-asset-types.destroy', ['it_asset_type' => $it_asset_type]) }}" method="POST">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-danger">Delete</button>
                      </form>
                      <button class="edit-button btn btn-primary mx-2" data-id="{{ $it_asset_type->id }}" data-bs-toggle="offcanvas" data-bs-target= "#offcanvasAddItAssetType">
                        Edit
                      </button>
                  </td>
                  </tr>
                  @endforeach
                </tbody>
            </table>
        </div>
        <!-- Offcanvas to add new user -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddItAssetType"
            aria-labelledby="offcanvasAddItAssetTypeLabel">
            <div class="offcanvas-header">
                <h5 id="offcanvasAddItAssetTypeLabel" class="offcanvas-title">Add It Asset Type</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body mx-0 flex-grow-0">
                <form class="add-new-it-asset-type pt-0" id="addNewItAssetTypeForm" method="POST"
                    action="{{ route('it-asset-types.store') }}">
                    @csrf
                    <input type="hidden" name="id" id="it_asset_type_id">
                    <div class="mb-3">
                        <label class="form-label" for="add-it-asset-type-name">It Asset Type</label>
                        <input type="text" id="add-it-asset-type" class="form-control" placeholder="California"
                            name="it_asset_type" />
                    </div>
                    <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Submit</button>
                    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">Cancel</button>
                </form>
            </div>
        </div>
    </div>
@endsection
