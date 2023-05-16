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
      var dt_instrument_type_table = $('.datatables-instrument-types'),
        offCanvasForm = $('#offcanvasAddInstrumentType');

      // Facilities datatable
      if (dt_instrument_type_table.length) {
        var dt_instrument_type = dt_instrument_type_table.DataTable({
          dom: '<"row mx-2"' + '<"col-md-2"<"me-3"l>>' + '<"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0"fB>>' + '>t' + '<"row mx-2"' + '<"col-sm-12 col-md-6"i>' + '<"col-sm-12 col-md-6"p>' + '>',
          buttons: [{
            text: '<i class="bx bx-plus me-0 me-sm-2"></i><span class="d-none d-sm-inline-block">Add New Instrument Type</span>',
            className: 'add-new btn btn-primary ms-2',
            attr: {
              'data-bs-toggle': 'offcanvas',
              'data-bs-target': '#offcanvasAddInstrumentType'
            }
          }],
        });
      }

      // clearing form data when offcanvas hidden
      offCanvasForm.on('hidden.bs.offcanvas', function () {
        let fv = $("#addNewInstrumentTypeForm")
        fv[0].reset(true);
        $("#instrument_type_id").val("");
      });
    });

    var baseUrl = window.location.origin;

    // Menambahkan event listener ke tombol edit
    $(".edit-button").on("click", function () {
      // Mendapatkan data-id dari tombol edit yang diklik
      var id = $(this).data("id");

      let urlEdit = `${baseUrl}/instrument-types/${id}/edit`;

      $.ajax({
        url: urlEdit,
        type: 'GET',
        success: function (data) {
          let instrument_type = data.data.instrument_type;
          $('#instrument_type_id').val(instrument_type.id);
          $('#add-instrument-type').val(instrument_type.instrument_type);
        }
      });
    });

/******/ 	return __webpack_exports__;
    /******/
  })()
    ;
});
