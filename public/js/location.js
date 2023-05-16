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
      var dt_location_table = $('.datatables-locations'),
        offCanvasForm = $('#offcanvasAddLocation');

      // Locations datatable
      if (dt_location_table.length) {
        var dt_location = dt_location_table.DataTable({
          dom: '<"row mx-2"' + '<"col-md-2"<"me-3"l>>' + '<"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0"fB>>' + '>t' + '<"row mx-2"' + '<"col-sm-12 col-md-6"i>' + '<"col-sm-12 col-md-6"p>' + '>',
          buttons: [{
            text: '<i class="bx bx-plus me-0 me-sm-2"></i><span class="d-none d-sm-inline-block">Add New Location</span>',
            className: 'add-new btn btn-primary ms-2',
            attr: {
              'data-bs-toggle': 'offcanvas',
              'data-bs-target': '#offcanvasAddLocation'
            }
          }],
        });
      }

      // clearing form data when offcanvas hidden
      offCanvasForm.on('hidden.bs.offcanvas', function () {
        let fv = $("#addNewLocationForm")
        fv[0].reset(true);
        $("#location_id").val("");
      });
    });

    var baseUrl = window.location.origin;

    // Menambahkan event listener ke tombol edit
    $(".edit-button").on("click", function () {
      // Mendapatkan data-id dari tombol edit yang diklik
      var id = $(this).data("id");

      let urlEdit = `${baseUrl}/locations/${id}/edit`;

      $.ajax({
        url: urlEdit,
        type: 'GET',
        success: function (data) {
          console.log(urlEdit);
          let location = data.data.location;
          $('#location_id').val(location.id);
          $('#add-location-name').val(location.location_name);
          $('#add-location-company').val(location.company_id);
        }
      });
    });

/******/ 	return __webpack_exports__;
    /******/
  })()
    ;
});
