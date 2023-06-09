@php
    $configData = Helper::appClasses();
@endphp
<!-- Create App Modal -->
<div class="modal fade" id="createApp" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-simple modal-upgrade-plan">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body p-2">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center">
                    <h3 class="mb-2">Create Workflow</h3>
                    <p>Provide data with this form to create your workflow.</p>
                </div>
                <!-- Property Listing Wizard -->
                <div id="wizard-create-app" class="bs-stepper vertical mt-2 shadow-none border-0">
                    <div class="bs-stepper-header border-0 p-1">
                        <div class="step" data-target="#details">
                            <button type="button" class="step-trigger">
                                <span class="bs-stepper-circle"><i class="bx bx-file fs-5"></i></span>
                                <span class="bs-stepper-label">
                                    <span class="bs-stepper-title text-uppercase">Workflow</span>
                                    <span class="bs-stepper-subtitle">Enter the workflow details</span>
                                </span>
                            </button>
                        </div>
                        <div class="line"></div>
                        <div class="step" data-target="#frameworks">
                            <button type="button" class="step-trigger">
                                <span class="bs-stepper-circle"><i class="bx bx-box fs-5"></i></span>
                                <span class="bs-stepper-label">
                                    <span class="bs-stepper-title text-uppercase">Initiator</span>
                                    <span class="bs-stepper-subtitle">Select the initiator role</span>
                                </span>
                            </button>
                        </div>
                        <div class="line"></div>
                        <div class="step" data-target="#database">
                            <button type="button" class="step-trigger">
                                <span class="bs-stepper-circle"><i class="bx bx-data fs-5"></i></span>
                                <span class="bs-stepper-label">
                                    <span class="bs-stepper-title text-uppercase">Worker</span>
                                    <span class="bs-stepper-subtitle">Select the worker role</span>
                                </span>
                            </button>
                        </div>
                        <div class="line"></div>
                        <div class="step" data-target="#billing">
                            <button type="button" class="step-trigger">
                                <span class="bs-stepper-circle"><i class="bx bx-credit-card fs-5"></i></span>
                                <span class="bs-stepper-label">
                                    <span class="bs-stepper-title text-uppercase">Approvers</span>
                                    <span class="bs-stepper-subtitle">Select the approvers</span>
                                </span>
                            </button>
                        </div>
                        <div class="line"></div>
                        <div class="step" data-target="#submit">
                            <button type="button" class="step-trigger">
                                <span class="bs-stepper-circle"><i class="bx bx-check fs-5"></i></span>
                                <span class="bs-stepper-label">
                                    <span class="bs-stepper-title text-uppercase">Submit</span>
                                    <span class="bs-stepper-subtitle">Submit</span>
                                </span>
                            </button>
                        </div>
                    </div>
                    <div class="bs-stepper-content p-1">
                        <form action="{{ route('workflows.store') }}" method="post" id="addNewWorkflowForm">
                          @csrf
                            <input type="hidden" name="id" id="workflow-id">
                            <!-- Details -->
                            <div id="details" class="content pt-3 pt-lg-0">
                                <div class="mb-3">
                                    <label class="pb-1" for="add-workflow-name">Workflow Name</label>
                                    <input type="text" class="form-control form-control-lg" id="add-workflow-name"
                                        placeholder="Enter the Workflow Name" name="name">
                                </div>
                                <div class="mb-3">
                                    <label class="pb-1" for="add-workflow-description">Workflow Description</label>
                                    <input type="text" class="form-control form-control-lg" id="add-workflow-description"
                                        placeholder="Enter the Workflow Description" name="description">
                                </div>
                                <div class="col-12 d-flex justify-content-between mt-4">
                                    <button type="button" class="btn btn-label-secondary btn-prev" disabled> <i
                                            class="bx bx-left-arrow-alt bx-xs me-sm-1 me-0"></i>
                                        <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                    </button>
                                    <button type="button" class="btn btn-primary btn-next"> <span
                                            class="align-middle d-sm-inline-block d-none me-sm-1">Next</span> <i
                                            class="bx bx-right-arrow-alt bx-xs"></i></button>
                                </div>
                            </div>

                            <!-- Frameworks -->
                            <div id="frameworks" class="content pt-3 pt-lg-0">
                                <h5>Initiator Role</h5>
                                <ul class="p-0 m-0">
                                    <li class="d-flex align-items-start mb-3">
                                        <div class="badge bg-label-info p-2 me-3 rounded"><i
                                                class="bx bxl-react bx-sm"></i></div>
                                        <div class="d-flex justify-content-between w-100 flex-wrap gap-2">
                                            <div class="me-2">
                                                <h6 class="mb-0">Admin</h6>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <div class="form-check form-check-inline">
                                                    <input name="initiator_role" class="form-check-input"
                                                        type="radio" value="admin" />
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="d-flex align-items-start mb-3">
                                        <div class="badge bg-label-danger p-2 me-3 rounded"><i
                                                class="bx bxl-angular bx-sm"></i></div>
                                        <div class="d-flex justify-content-between w-100 flex-wrap gap-2">
                                            <div class="me-2">
                                                <h6 class="mb-0">HR</h6>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <div class="form-check form-check-inline">
                                                    <input name="initiator_role" class="form-check-input"
                                                        type="radio" value="" checked="" />
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="d-flex align-items-start mb-3">
                                        <div class="badge bg-label-warning p-2 me-3 rounded"><i
                                                class="bx bxl-html5 bx-sm"></i></div>
                                        <div class="d-flex justify-content-between w-100 flex-wrap gap-2">
                                            <div class="me-2">
                                                <h6 class="mb-0">Lab Employee</h6>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <div class="form-check form-check-inline">
                                                    <input name="initiator_role" class="form-check-input"
                                                        type="radio" value="lab_employee" />
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="d-flex align-items-start">
                                        <div class="badge bg-label-success p-2 me-3 rounded"><i
                                                class="bx bxl-vuejs bx-sm"></i></div>
                                        <div class="d-flex justify-content-between w-100 flex-wrap gap-2">
                                            <div class="me-2">
                                                <h6 class="mb-0">IT</h6>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <div class="form-check form-check-inline">
                                                    <input name="initiator_role" class="form-check-input"
                                                        type="radio" value="it" />
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>

                                <div class="col-12 d-flex justify-content-between mt-4">
                                    <button type="button" class="btn btn-label-secondary btn-prev"> <i
                                            class="bx bx-left-arrow-alt bx-xs me-sm-1 me-0"></i> <span
                                            class="align-middle d-sm-inline-block d-none">Previous</span> </button>
                                    <button type="button" class="btn btn-primary btn-next"> <span
                                            class="align-middle d-sm-inline-block d-none me-sm-1">Next</span> <i
                                            class="bx bx-right-arrow-alt bx-xs"></i></button>
                                </div>
                            </div>

                            <!-- Database -->
                            <div id="database" class="content pt-3 pt-lg-0">
                                <h5>Select Worker Role</h5>
                                <ul class="p-0 m-0">
                                    <li class="d-flex align-items-start mb-3">
                                        <div class="badge bg-label-info p-2 me-3 rounded"><i
                                                class="bx bxl-react bx-sm"></i></div>
                                        <div class="d-flex justify-content-between w-100 flex-wrap gap-2">
                                            <div class="me-2">
                                                <h6 class="mb-0">Admin</h6>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <div class="form-check form-check-inline">
                                                    <input name="worker_role" class="form-check-input"
                                                        type="radio" value="admin" />
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="d-flex align-items-start mb-3">
                                        <div class="badge bg-label-danger p-2 me-3 rounded"><i
                                                class="bx bxl-angular bx-sm"></i></div>
                                        <div class="d-flex justify-content-between w-100 flex-wrap gap-2">
                                            <div class="me-2">
                                                <h6 class="mb-0">HR</h6>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <div class="form-check form-check-inline">
                                                    <input name="worker_role" class="form-check-input"
                                                        type="radio" value="" checked="" />
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="d-flex align-items-start mb-3">
                                        <div class="badge bg-label-warning p-2 me-3 rounded"><i
                                                class="bx bxl-html5 bx-sm"></i></div>
                                        <div class="d-flex justify-content-between w-100 flex-wrap gap-2">
                                            <div class="me-2">
                                                <h6 class="mb-0">Lab Employee</h6>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <div class="form-check form-check-inline">
                                                    <input name="worker_role" class="form-check-input"
                                                        type="radio" value="lab_employee" />
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="d-flex align-items-start">
                                        <div class="badge bg-label-success p-2 me-3 rounded"><i
                                                class="bx bxl-vuejs bx-sm"></i></div>
                                        <div class="d-flex justify-content-between w-100 flex-wrap gap-2">
                                            <div class="me-2">
                                                <h6 class="mb-0">IT</h6>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <div class="form-check form-check-inline">
                                                    <input name="worker_role" class="form-check-input"
                                                        type="radio" value="it" />
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                                <div class="col-12 d-flex justify-content-between mt-4">
                                    <button type="button" class="btn btn-label-secondary btn-prev"> <i
                                            class="bx bx-left-arrow-alt bx-xs me-sm-1 me-0"></i> <span
                                            class="align-middle d-sm-inline-block d-none">Previous</span> </button>
                                    <button type="button" class="btn btn-primary btn-next"> <span
                                            class="align-middle d-sm-inline-block d-none me-sm-1">Next</span> <i
                                            class="bx bx-right-arrow-alt bx-xs"></i></button>
                                </div>
                            </div>

                            <!-- billing -->
                            <div id="billing" class="content">
                                <div id="AppNewCCForm" class="row g-3 pt-3 pt-lg-0 mb-5" onsubmit="return false">
                                    <label class="form-label" for="modalEditUserLanguage">Select the approvers</label>
                                    <select id="add-approver-roles" name="approver_roles"
                                        class="select2 form-select" multiple>
                                        <option value="">Select</option>
                                        <option value="english" selected>English</option>
                                        <option value="spanish">Spanish</option>
                                        <option value="french">French</option>
                                        <option value="german">German</option>
                                        <option value="dutch">Dutch</option>
                                        <option value="hebrew">Hebrew</option>
                                        <option value="sanskrit">Sanskrit</option>
                                        <option value="hindi">Hindi</option>
                                    </select>
                                </div>
                                <div class="col-12 d-flex justify-content-between mt-4">
                                    <button type="button" class="btn btn-label-secondary btn-prev"> <i
                                            class="bx bx-left-arrow-alt bx-xs me-sm-1 me-0"></i> <span
                                            class="align-middle d-sm-inline-block d-none">Previous</span> </button>
                                    <button type="button" class="btn btn-primary btn-next"> <span
                                            class="align-middle d-sm-inline-block d-none me-sm-1">Next</span> <i
                                            class="bx bx-right-arrow-alt bx-xs"></i></button>
                                </div>
                            </div>

                            <!-- submit -->
                            <div id="submit" class="content text-center pt-3 pt-lg-0">
                                <h5 class="mb-2 mt-3">Submit</h5>
                                <p>Submit to kick start your project.</p>
                                <!-- image -->
                                <img src="{{ asset('assets/img/illustrations/girl-doing-yoga-' . $configData['style'] . '.png') }}"
                                    alt="Create App img" width="300" class="img-fluid"
                                    data-app-light-img="illustrations/girl-doing-yoga-light.png"
                                    data-app-dark-img="illustrations/girl-doing-yoga-dark.png">
                                <div class="col-12 d-flex justify-content-between mt-4 pt-2">
                                    <button type="button" class="btn btn-label-secondary btn-prev"> <i
                                            class="bx bx-left-arrow-alt bx-xs me-sm-1 me-0"></i> <span
                                            class="align-middle d-sm-inline-block d-none">Previous</span> </button>
                                    <button type="submit" class="btn btn-success btn-next btn-submit"> <span
                                            class="align-middle d-sm-inline-block d-none">Submit</span></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!--/ Property Listing Wizard -->
        </div>
    </div>
</div>
<!--/ Create App Modal -->
