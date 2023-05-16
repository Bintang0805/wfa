(function webpackUniversalModuleDefinition(root, factory) {
  if (typeof exports === 'object' && typeof module === 'object')
    module.exports = factory();
  else if (typeof define === 'function' && define.amd)
    define([], factory);
  else {
    var a = factory();
    for (var i in a) (typeof exports === 'object' ? exports : root)[i] = a[i];
  }
})(self, function () {
  return /******/ (function () { // webpackBootstrap
/******/ 	"use strict";
    var __webpack_exports__ = {};
    /*!*************************************************!*\
      !*** ./resources/js/laravel-user-management.js ***!
      \*************************************************/
    /**
     * Page User List
     */



    // Datatable (jquery)
    $(function () {
      // Variable declaration for table
      var dt_application_table = $('.datatables-applications'),
        offCanvasForm = $('#offcanvasAddApplication');

      // Facilities datatable
      if (dt_application_table.length) {
        var dt_application = dt_application_table.DataTable({
          dom: '<"row mx-2"' + '<"col-md-2"<"me-3"l>>' + '<"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0"fB>>' + '>t' + '<"row mx-2"' + '<"col-sm-12 col-md-6"i>' + '<"col-sm-12 col-md-6"p>' + '>',
          buttons: [{
            text: '<i class="bx bx-plus me-0 me-sm-2"></i><span class="d-none d-sm-inline-block">Add New Application</span>',
            className: 'add-new btn btn-primary ms-2',
            attr: {
              'data-bs-toggle': 'offcanvas',
              'data-bs-target': '#offcanvasAddApplication'
            }
          }],
        });
      }

      // clearing form data when offcanvas hidden
      offCanvasForm.on('hidden.bs.offcanvas', function () {
        let fv = $("#addNewApplicationForm")
        fv[0].reset(true);
        $("#application_id").val("");
      });
    });

    var baseUrl = window.location.origin;

    // Menambahkan event listener ke tombol edit
    $(".edit-button").on("click", function () {
      // Mendapatkan data-id dari tombol edit yang diklik
      var id = $(this).data("id");

      let urlEdit = `${baseUrl}/applications/${id}/edit`;

      $.ajax({
        url: urlEdit,
        type: 'GET',
        success: function (data) {
          let application = data.data.application;
          $('#application_id').val(application.id);
          $('#add-application-name').val(application.application_name);
          $('#add-application-ver').val(application.application_ver);
          $('#add-connected-to-computer').val(application.connected_to_computer);
          $('#add-application-department').val(application.department.id);
          $('#add-connected-to-server').val(application.connected_to_server);
          $('#add-application-role-type').val(application.application_role_type);
          $('#add-privilages').val(application.privilages);
          $('#add-manufacturer').val(application.manufacturer);
          $('#add-gamp-category').val(application.gamp_category);
          $('#add-csv-status').val(application.csv_status);
          $('#add-csv-completed-on').val(application.csv_completed_on);
          $('#add-periodic-review').val(application.periodic_review);
          $('#add-gxp-status').val(application.gxp_status);
          $('#add-backup-mode').val(application.backup_mode);
          $('#add-data-type').val(application.data_type);
          $('#add-vendor-details').val(application.vendor_details);
          $('#add-status').val(application.status);
        }
      });
    });

/******/ 	return __webpack_exports__;
    /******/
  })()
    ;
});
