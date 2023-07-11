<!-- Add Permission Modal -->
<div class="modal fade" id="addPermissionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-simple">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body">
              <form action="{{ route('permissions.store') }}" method="POST" class="row" id="addNewPermissionForm">
                <button type="reset" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h3>Add New Permission</h3>
                    <p>Permissions you may use and assign to your users.</p>
                </div>
                    @csrf
                    <div class="col-12 mb-3 form-input">
                        <label class="form-label" for="modalPermissionName">Permission Name</label>
                        <input type="text" id="modalPermissionName" name="name" class="form-control"
                            placeholder="Example: create-page_name" autofocus />
                    </div>
                    <div class="col-12 text-center demo-vertical-spacing">
                        <button type="submit" class="btn btn-primary me-sm-3 me-1">Create Permission</button>
                        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                            aria-label="Close">Discard</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--/ Add Permission Modal -->
