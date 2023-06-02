@php
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Location - WFA')


@section('vendor-style')
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
@endsection

<!-- Page -->
@section('page-style')

@endsection

@section('page-script')
    <script src="{{ asset('js/request-form.js') }}"></script>
    <script>
        var url = window.location.href;
        var urlObject = new URL(url);
        var pathname = urlObject.pathname;
        var pathnameParts = pathname.split('/');
        var id = pathnameParts[2];

        let getRequestForm = `${window.location.origin}/request-forms/${id}`;
        let getEditData = null;

        $.ajax({
            url: getRequestForm,
            type: 'GET',
            success: function(data) {
                getEditData = data.data;
                let getField = JSON.parse(data.data.fields);
                console.log(getEditData);
                fields = getField;
                console.log(fields);
                loadFields();
                return true;
            },
            error: function() {
                return false;
            }
        });
    </script>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Create New Form Fields</h5>
        </div>
        <div class="card-body table-responsive px-4 row">
            <div class="col-8 px-2">
                <div class="dropper-elements border w-100 d-flex align-items-center justify-content-center px-3 py-2 pb-5"
                    style="height:60vh; overflow-y: auto" ondrop="onDropInput(event)" ondragover="allowDrop(event)">
                    <p id="no-element">Drop Input Element In Here</p>
                </div>
            </div>
            <div class="col-4 px-2">
                <div class="drag-elements border px-3 py-2" style="height: 60vh; overflow: auto;">
                    <div class="drag-elements-title pt-3">
                        <h5>Form Elements</h5>
                    </div>
                    <div class="drag-elements-item">
                        <ul class="px-0" style="list-style: none;">
                            <li class="border-top border-bottom py-3 draggable-items" data-type="text"
                                style="cursor: grab; user-select: none" draggable="true">
                                <div class="row">
                                    <div class="col-1">
                                        <i class="fa-regular fa-keyboard"></i>
                                    </div>
                                    <div class="col-11">
                                        Input Text
                                    </div>
                                </div>
                            </li>
                            <li class="border-top border-bottom py-3 draggable-items" data-type="email"
                                style="cursor: grab; user-select: none" draggable="true">
                                <div class="row">
                                    <div class="col-1">
                                        <i class="fa-regular fa-envelope"></i>
                                    </div>
                                    <div class="col-11">
                                        Input Email
                                    </div>
                                </div>
                            </li>
                            <li class="border-top border-bottom py-3 draggable-items" data-type="password"
                                style="cursor: grab; user-select: none" draggable="true">
                                <div class="row">
                                    <div class="col-1">
                                        <i class="fa-solid fa-lock"></i>
                                    </div>
                                    <div class="col-11">
                                        Input Password
                                    </div>
                                </div>
                            </li>
                            <li class="border-top border-bottom py-3 draggable-items" data-type="date"
                                style="cursor: grab; user-select: none" draggable="true">
                                <div class="row">
                                    <div class="col-1">
                                        <i class="fa-regular fa-calendar"></i>
                                    </div>
                                    <div class="col-11">
                                        Input Date
                                    </div>
                                </div>
                            </li>
                            <li class="border-top border-bottom py-3 draggable-items" data-type="hidden"
                                style="cursor: grab; user-select: none" draggable="true">
                                <div class="row">
                                    <div class="col-1">
                                        <i class="fa-regular fa-eye-slash"></i>
                                    </div>
                                    <div class="col-11">
                                        Input Hidden
                                    </div>
                                </div>
                            </li>
                            <li class="border-top border-bottom py-3 draggable-items" data-type="file"
                                style="cursor: grab; user-select: none" draggable="true">
                                <div class="row">
                                    <div class="col-1">
                                        <i class="fa-regular fa-file"></i>
                                    </div>
                                    <div class="col-11">
                                        Input File
                                    </div>
                                </div>
                            </li>
                            <li class="border-top border-bottom py-3 draggable-items" data-type="select"
                                style="cursor: grab; user-select: none" draggable="true">
                                <div class="row">
                                    <div class="col-1">
                                        <i class="fa-solid fa-caret-down"></i>
                                    </div>
                                    <div class="col-11">
                                        Input Select
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="w-100 d-flex justify-content-end pt-3 align-items-end">
                <div class="button-group">
                    <button class="btn btn-danger">
                        Cancel
                    </button>
                    <button class="btn btn-primary ms-2" data-bs-toggle="modal" data-bs-target="#modalSaveForm">
                        Save Form
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalConfigureInput" tabindex="-1" aria-labelledby="modalCofigureInputLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="form-configure-input">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCofigureInputLabel">Modal title</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body modal-configure-input">
                        <div class="row">
                            <div class="col-6 px-2 mb-3">
                                <div class="form-input">
                                    <label>Required</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value=""
                                            id="input_required">
                                        <label class="form-check-label" for="input_required">
                                            True
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 px-2 mb-3">
                                <div class="form-input">
                                    <label for="input_label">Label</label>
                                    <input type="text" name="input_label" class="input_label form-control"
                                        id="input_label">
                                </div>
                            </div>
                            <div class="col-6 px-2 mb-3">
                                <div class="form-input">
                                    <label for="input_id">ID</label>
                                    <input type="text" name="input_id" class="input_id form-control" id="input_id">
                                </div>
                            </div>
                            <div class="col-6 px-2 mb-3">
                                <div class="form-input">
                                    <label for="input_class">Class</label>
                                    <input type="text" name="input_class" class="input_class form-control"
                                        id="input_class">
                                </div>
                            </div>
                            <div class="col-6 px-2 mb-3">
                                <div class="form-input">
                                    <label for="input_name">Name</label>
                                    <input type="text" name="input_name" class="input_name form-control"
                                        id="input_name">
                                </div>
                            </div>
                            <div class="col-6 px-2 mb-3">
                                <div class="form-input">
                                    <label for="input_type">Type</label>
                                    <select name="input_type" id="input_type" class="form-control">
                                        <option value="" disabled selected>Select Input Type</option>
                                        <option value="text">Text</option>
                                        <option value="email">Email</option>
                                        <option value="password">Password</option>
                                        <option value="date">Date</option>
                                        <option value="hidden">Hidden</option>
                                        <option value="file">File</option>
                                        <option value="number">Number</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6 px-2 mb-3">
                                <div class="form-input">
                                    <label for="input_placeholder">Placeholder</label>
                                    <input type="text" name="input_placeholder" class="input_help-text form-control"
                                        id="input_placeholder">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="save-configure-input">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalSaveForm" tabindex="-1" aria-labelledby="modalSaveFormLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('request-forms.store') }}" method="POST">
                    @csrf
                    <input type="hidden" value="{{ $request_form->id }}">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalSaveFormLabel">Form Builder</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="input-form-fields" name="fields">
                        <div class="form-input mb-3">
                            <label for="workflow_id">Workflow</label>
                            <select name="workflow_id" id="workflow_id" class="form-control">
                                <option value="" disabled selected>Select the workflow</option>
                                @foreach ($workflows as $workflow)
                                    <option value="{{ $workflow->id }}" {{ $workflow->id == $request_form->workflow_id ? "selected" : "" }}>{{ $workflow->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-input mb-3">
                            <label for="form-name">Form Name</label>
                            <input id="form-name" class="form-control" name="name"
                                placeholder="Give a Name for this form" value="{{ $request_form->name != "" ? $request_form->name : "" }}"/>
                        </div>
                        <div class="form-input">
                            <label for="form-description">Form Description</label>
                            <input id="form-description" class="form-control" name="description"
                                placeholder="Give a Description for this form" value="{{ $request_form->description != "" ? $request_form->description : "" }}"/>
                        </div>
                        <div class="preview-input-json w-100" id="preview-input-json"
                            style="max-height: 40vh; overflow-x: auto">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
