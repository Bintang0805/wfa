@extends('layouts/layoutMaster')

@section('title', 'Permission - Apps')

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

@section('page-script')
    <script src="{{ asset('js/app-access-permission.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/modal-add-permission.js') }}"></script>
    <script src="{{ asset('assets/js/modal-edit-permission.js') }}"></script> --}}
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
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger error-message" role="alert">
                {{ $error }}
            </div>
        @endforeach
    @endif

    <!-- Permission Table -->
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5 class="card-title mb-0">Permissions Table</h5>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPermissionModal">
              Add New Permission
            </button>
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-permissions table border-top">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Permission</th>
                        <th>Created Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                  @php
                      $i=1
                  @endphp
                    @foreach ($permissions as $permission)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $permission->name }}</td>
                            <td>{{ $permission->created_at }}</td>
                            <td class="d-flex">
                                <button class="edit-button btn-sm btn btn-primary" data-id="{{ $permission->id }}"
                                    data-bs-toggle="modal" data-bs-target="#createApp">
                                    <i class="bx bx-edit"></i>
                                </button>
                                <form action="{{ route('permissions.destroy', ['permission' => $permission]) }}"
                                    method="POST" class="DeleteForm">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger mx-2"
                                        onclick="showPermission(this.parentNode)"><i class="bx bx-trash"></i></button>
                                </form>
                                <button class="detail-button btn btn-sm btn-secondary" data-id="{{ $permission->id }}"
                                    data-bs-toggle="modal" data-bs-target="#modalCenterDetail">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!--/ Permission Table -->


    <!-- Modal -->
    @include('_partials/_modals/modal-add-permission')
    @include('_partials/_modals/modal-edit-permission')
    <!-- /Modal -->
@endsection
