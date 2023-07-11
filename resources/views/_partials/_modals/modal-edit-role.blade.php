<!-- Add Role Modal -->
<div class="modal fade" id="editRoleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-simple modal-dialog-centered modal-add-new-role">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body">
                <form action="{{ route('roles.store') }}" id="editRoleForm" method="post" class="row g-3">
                    <button type="reset" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="text-center mb-4">
                        <h3 class="role-title">Edit Role</h3>
                        <p>Set role permissions</p>
                    </div>
                    <!-- Add role form -->
                    @csrf
                    <input type="hidden" name="id" id="edit_role_id">
                    <div class="col-12 mb-4 form-input">
                        <label class="form-label" for="role_name">Role Name</label>
                        <input type="text" id="edit_role_name" name="role_name" class="form-control"
                            placeholder="Enter a role name" tabindex="-1" />
                    </div>
                    <div class="col-12">
                        <h4>Role Permissions</h4>
                        <!-- Permission table -->
                        <div class="table-responsive">
                            <table class="table table-flush-spacing">
                                <tbody>
                                    <tr>
                                        <td class="text-nowrap fw-semibold">Administrator Access <i
                                                class="bx bx-info-circle bx-xs" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Allows a full access to the system"></i>
                                        </td>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="selectAllEdit" />
                                                <label class="form-check-label" for="selectAllEdit">
                                                    Select All
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    @foreach ($permissions as $key => $permission)
                                        <tr>
                                            <td class="text-nowrap fw-semibold">
                                                {{ ucwords(str_replace('_', ' ', $key)) }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    @foreach ($permission as $perm)
                                                        <div class="form-check me-3 me-lg-5">
                                                            <input class="form-check-input" type="checkbox"
                                                                id="edit-{{ $perm['permission']->name }}"
                                                                value="{{ $perm['permission']->id }}"
                                                                name="permission[]" />
                                                            <label class="form-check-label"
                                                                for="{{ $perm['permission']->name }}">
                                                                {{ $perm['function'] }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- Permission table -->
                    </div>
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
                        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                            aria-label="Close">Cancel</button>
                    </div>
                </form>
                <!--/ Add role form -->
            </div>
        </div>
    </div>
</div>
<!--/ Add Role Modal -->
