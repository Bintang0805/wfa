@extends('layouts/layoutMaster')

@section('title', 'User Management - Crud App')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/formvalidation/dist/css/formValidation.min.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/animate-css/animate.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.css')}}" />
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/moment/moment.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
<script src="{{asset('assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/cleavejs/cleave.js')}}"></script>
<script src="{{asset('assets/vendor/libs/cleavejs/cleave-phone.js')}}"></script>
<script src="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('js/user-management.js')}}"></script>
@endsection

@section('content')

<div class="row g-4 mb-4">
  <div class="col-sm-6 col-xl-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between">
          <div class="content-left">
            <span>Users</span>
            <div class="d-flex align-items-end mt-2">
              <h3 class="mb-0 me-2">{{$totalUser}}</h3>
              <small class="text-success">(100%)</small>
            </div>
            <small>Total Users</small>
          </div>
          <span class="badge bg-label-primary rounded p-2">
            <i class="bx bx-user bx-sm"></i>
          </span>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between">
          <div class="content-left">
            <span>Verified Users</span>
            <div class="d-flex align-items-end mt-2">
              <h3 class="mb-0 me-2">{{$verified}}</h3>
              <small class="text-success">(+95%)</small>
            </div>
            <small>Recent analytics </small>
          </div>
          <span class="badge bg-label-success rounded p-2">
            <i class="bx bx-user-check bx-sm"></i>
          </span>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between">
          <div class="content-left">
            <span>Duplicate Users</span>
            <div class="d-flex align-items-end mt-2">
              <h3 class="mb-0 me-2">{{$userDuplicates}}</h3>
              <small class="text-success">(0%)</small>
            </div>
            <small>Recent analytics</small>
          </div>
          <span class="badge bg-label-danger rounded p-2">
            <i class="bx bx-group bx-sm"></i>
          </span>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between">
          <div class="content-left">
            <span>Verification Pending</span>
            <div class="d-flex align-items-end mt-2">
              <h3 class="mb-0 me-2">{{$notVerified}}</h3>
              <small class="text-danger">(+6%)</small>
            </div>
            <small>Recent analytics</small>
          </div>
          <span class="badge bg-label-warning rounded p-2">
            <i class="bx bx-user-voice bx-sm"></i>
          </span>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Users List Table -->
<div class="card">
  <div class="card-header">
    <h5 class="card-title mb-0">Search Filter</h5>
  </div>
  <div class="card-datatable table-responsive">
    <table class="datatables-users table border-top">
      <thead>
        <tr>
          <th></th>
          <th>Id</th>
          <th>User</th>
          <th>Email</th>
          <th>Verified</th>
          <th>Role</th>
          <th>Actions</th>
        </tr>
      </thead>
    </table>
  </div>
  <!-- Offcanvas to add new user -->
  <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddUser" aria-labelledby="offcanvasAddUserLabel">
    <div class="offcanvas-header">
      <h5 id="offcanvasAddUserLabel" class="offcanvas-title">Add User</h5>
      <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body mx-0 flex-grow-0">
      <form class="add-new-user pt-0" id="addNewUserForm">
        <input type="hidden" name="id" id="user_id">
        <div class="mb-3">
          <label class="form-label" for="add-user-fullname">Full Name</label>
          <input type="text" class="form-control" id="add-user-fullname" placeholder="John Doe" name="name" aria-label="John Doe" />
        </div>
        <div class="mb-3">
          <label class="form-label" for="add-user-email">Email</label>
          <input type="text" id="add-user-email" class="form-control" placeholder="john.doe@example.com" aria-label="john.doe@example.com" name="email" />
        </div>
        <div class="mb-3">
          <label class="form-label" for="add-user-contact">Contact</label>
          <input type="text" id="add-user-contact" class="form-control phone-mask" placeholder="+1 (609) 988-44-11" aria-label="john.doe@example.com" name="contact" />
        </div>
        <div class="mb-3">
          <label class="form-label" for="add-user-company">Company</label>
          <select id="add-user-company" class="selectCompany form-select" name="company_id">
            <option value="">Select</option>
            @foreach ($companies as $company)
                <option value="{{ $company->id }}">{{ $company->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label" for="country">Country</label>
          <input type="text" id="add-user-country" class="form-control" name="country">
        </div>
        <div class="mb-3">
          <label class="form-label" for="add-user-role">User Role</label>
          <select id="add-user-role" class="form-select" name="user_role">
            @forelse ($roles as $role)
                <option value="{{ $role->id }}">{{ $role->name }}</option>
            @empty
                <option value="" disabled selected>Roles data is empty</option>
            @endforelse
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label" for="add-user-password">Password</label>
          <input type="password" id="add-user-password" class="form-control" name="password">
        </div>
        <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Submit</button>
        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">Cancel</button>
      </form>
    </div>
  </div>
</div>
@endsection
