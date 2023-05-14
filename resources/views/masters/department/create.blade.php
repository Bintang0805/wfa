@php
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Location - WFA')


@section('vendor-style')

@endsection

@section('vendor-script')
    {{-- <script
        src="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/jquery/jquery.js?id=28f58d9b27389bc2161474b63d4550fb">
    </script>
    <script
        src="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/popper/popper.js?id=b97e30d0826b14784a53312b6ea562bc">
    </script>
    <script
        src="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/vendor/js/bootstrap.js?id=5cf23b844ba766fd18bf77de6f71daee">
    </script>
    <script
        src="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js?id=44b8e955848dc0c56597c09f6aebf89a">
    </script>
    <script
        src="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/hammer/hammer.js?id=f2b232153f92e544aab0ed45c56ab524">
    </script>
    <script
        src="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/typeahead-js/typeahead.js?id=f6bda588c16867a6cc4158cb4ed37ec6">
    </script>
    <script
        src="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/vendor/js/menu.js?id=c6ce30ded4234d0c4ca0fb5f2a2990d8">
    </script>
    <script
        src="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/moment/moment.js">
    </script>
    <script
        src="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js">
    </script>
    <script
        src="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/select2/select2.js">
    </script>
    <script
        src="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js">
    </script>
    <script
        src="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js">
    </script>
    <script
        src="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js">
    </script>
    <script
        src="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/cleavejs/cleave.js">
    </script>
    <script
        src="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/cleavejs/cleave-phone.js">
    </script>
    <script
        src="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/sweetalert2/sweetalert2.js">
    </script> --}}
@endsection

<!-- Page -->
@section('page-style')

@endsection

@section('page-script')
    {{-- <script
        src="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/js/laravel-user-management.js">
    </script> --}}
@endsection

@section('content')
    <form action="{{ route('departments.store') }}" method="POST">
      @csrf
      @method("POST")
      <input type="number" name="facility_id">
      <input type="text" name="department">
      <button type="submit">
        Submit
      </button>
    </form>
@endsection
