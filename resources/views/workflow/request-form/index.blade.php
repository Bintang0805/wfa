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
    <script src="{{ asset('js/request-form.js') }}"></script>
@endsection

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5 class="card-title mb-0">Form Fields Table</h5>
            <div class="button">
              <a href="{{ route('request-forms.create') }}">
                <button class="btn btn-primary">Add New Form</button>
              </a>
            </div>
        </div>
        <div class="card-datatable table-responsive px-3">
            <table class="datatables-form-fields2 table border-top">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Form Name</th>
                        <th>Status</th>
                        <th>Associated Workflow</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($request_forms as $request_form)
                        <tr>
                            <td>{{ $request_form->id }}</td>
                            <td class="request-form-name">{{ $request_form->name }}</td>
                            <td class="request-form-status">
                              <span class="badge {{ $request_form->status == true ? 'bg-success' : 'bg-warning' }}">{{ $request_form->status == true ? "active" : "inactive" }}</span>
                            </td>
                            <td>
                              {{ $request_form->associated_form_to_string }}
                            </td>
                            <td class="d-flex">
                              <a
                              href="{{ route('request-forms.edit', ['request_form' => $request_form->id]) }}">
                              <button class="edit-button btn-sm btn btn-primary" data-id="">
                                  <i class="bx bx-edit"></i>
                              </button>
                          </a>
                          <form
                              action="{{ route('request-forms.destroy', ['request_form' => $request_form->id]) }}"
                              method="POST" class="DeleteForm">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="btn btn-sm btn-danger mx-2"
                                  onclick="showPermission(this.parentNode)"><i class="bx bx-trash"></i></button>
                          </form>
                          <button class="detail-button btn btn-sm btn-secondary button-fields-preview"
                              data-id="{{ $request_form->id != null ? $request_form->id : '' }}"
                              data-bs-toggle="modal" data-bs-target="#fieldsPreview">
                              {{-- <i class="bx bx-dots-vertical-rounded"></i> --}}
                              View Form
                          </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-datatable table-responsive px-3">
            <table class="datatables-form-fields table border-top">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Workflow Name</th>
                        <th>Form Name</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($workflows as $workflow)
                        <tr>
                            <td>{{ $workflow->id }}</td>
                            <td class="request-form-name">{{ $workflow->name }}</td>
                            <td class="request-form-name">
                                {{ $workflow->request_form != null ? $workflow->request_form->name : '' }}
                            </td>
                            <td class="request-form-status"><span
                                    class="badge {{ $workflow->status == 'active' ? 'bg-success' : 'bg-warning' }}">{{ $workflow->status }}</span>
                            </td>
                            <td class="d-flex">
                                @if ($workflow->request_form != null)
                                    {{-- <a
                                        href="{{ route('request-forms.edit', ['request_form' => $workflow->request_form]) }}">
                                        <button class="edit-button btn-sm btn btn-primary" data-id="">
                                            <i class="bx bx-edit"></i>
                                        </button>
                                    </a> --}}
                                    <form
                                        action="{{ route('request-forms.destroy', ['request_form' => $workflow->request_form]) }}"
                                        method="POST" class="DeleteForm">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger mx-2"
                                            onclick="showPermission(this.parentNode)"><i class="bx bx-trash"></i></button>
                                    </form>
                                    <button class="detail-button btn btn-sm btn-secondary button-fields-preview"
                                        data-id="{{ $workflow->request_form != null ? $workflow->request_form->id : '' }}"
                                        data-bs-toggle="modal" data-bs-target="#fieldsPreview">
                                        {{-- <i class="bx bx-dots-vertical-rounded"></i> --}}
                                        Preview Form
                                    </button>
                                @else
                                    <a href="{{ route('request-forms.create-custom', ['workflow_id' => $workflow->id]) }}">
                                        <button class="btn btn-sm btn-primary">
                                            {{-- <i class="bx bx-dots-vertical-rounded"></i> --}}
                                            Create Form
                                        </button>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="fieldsPreview" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Preview Input</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="input-preview w-100">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
