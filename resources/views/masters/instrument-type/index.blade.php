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
    <script src="{{ asset('js/instrument-type.js') }}"></script>
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
        <div class="bs-toast toast fade show bg-primary position-fixed bottom-0 end-0 me-4 mb-4 success-toast" role="alert"
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
            <h5 class="card-title mb-0">Instrument Types Table</h5>
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-instrument-types table border-top">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Instrument Type</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($instrument_types as $instrument_type)
                        <tr>
                            <td>{{ $instrument_type->id }}</td>
                            <td>{{ $instrument_type->instrument_type }}</td>
                            <td class="d-flex">
                                <button class="edit-button btn btn-sm btn-primary mx-2"
                                    data-id="{{ $instrument_type->id }}" data-bs-toggle="modal"
                                    data-bs-target="#modalCenter">
                                    <i class="bx bx-edit"></i>
                                </button>
                                <form
                                    action="{{ route('instrument-types.destroy', ['instrument_type' => $instrument_type]) }}"
                                    id="DeleteForm" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="showPermission()"><i class="bx bx-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Offcanvas to add new instrument type -->
        {{-- <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddInstrumentType"
            aria-labelledby="offcanvasAddInstrumentTypeLabel">
            <div class="offcanvas-header">
                <h5 id="offcanvasAddInstrumentTypeLabel" class="offcanvas-title">Add Instrument Type</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body mx-0 flex-grow-0">
                <form class="add-new-instrument-type pt-0" id="addNewInstrumentTypeForm" method="POST"
                    action="{{ route('instrument-types.store') }}">
                    @csrf
                    <input type="hidden" name="id" id="instrument_type_id">
                    <div class="mb-3">
                        <label class="form-label" for="add-instrument-type">Instrument Type</label>
                        <input type="text" id="add-instrument-type" class="form-control" placeholder="California"
                            name="instrument_type" />
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
                    <form action="{{ route('instrument-types.store') }}" method="post" id="addNewInstrumentTypeForm">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalCenterTitle">Form Instrument Type</h5>
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
                            <input type="hidden" name="id" id="instrument_type_id">
                            <div class="mb-3">
                                <label class="form-label" for="add-instrument-type">Instrument Type<span
                                        class="text-danger ps-1 fs-6">*</span></label>
                                <input type="text" id="add-instrument-type" class="form-control"
                                    name="instrument_type" />
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
@endsection
