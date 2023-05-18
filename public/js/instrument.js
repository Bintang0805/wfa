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
      var dt_instrument_table = $('.datatables-instruments'),
        modal = $('#modalCenter');

      // Facilities datatable
      if (dt_instrument_table.length) {
        var dt_instrument = dt_instrument_table.DataTable({
          dom: '<"row mx-2"' + '<"col-md-2"<"me-3"l>>' + '<"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0"fB>>' + '>t' + '<"row mx-2"' + '<"col-sm-12 col-md-6"i>' + '<"col-sm-12 col-md-6"p>' + '>',
          buttons: [{
            text: '<i class="bx bx-plus me-0 me-sm-2"></i><span class="d-none d-sm-inline-block">Add New Instrument</span>',
            className: 'add-new btn btn-primary ms-2',
            attr: {
              'data-bs-toggle': 'modal',
              'data-bs-target': '#modalCenter'
            }
          }],
        });
      }

      // clearing form data when modal hidden
      modal.on('hidden.bs.modal', function () {
        let fv = $("#addNewInstrumentForm")
        fv[0].reset(true);
        $("#instrument_id").val("");
      });
    });

    var baseUrl = window.location.origin;

    // Menambahkan event listener ke tombol edit
    $(".edit-button").on("click", function () {
      // Mendapatkan data-id dari tombol edit yang diklik
      var id = $(this).data("id");

      let urlEdit = `${baseUrl}/instruments/${id}/edit`;

      $.ajax({
        url: urlEdit,
        type: 'GET',
        success: function (data) {
          let instrument = data.data.instrument;
          $('#instrument_id').val(instrument.id);
          $('#add-instrument-department').val(instrument.department.id);
          $('#add-instrument-type').val(instrument.instrument_type_id);
          $('#add-instrument-name').val(instrument.instrument_name);
          $('#add-instrument-make').val(instrument.instrument_make);
          $('#add-instrument-model').val(instrument.instrument_model);
          $('#add-data-storage').val(instrument.data_storage);
          $('#add-indirect-impact').val(instrument.indirect_impact);
          $('#add-qualification-status').val(instrument.qualification_status);
          $('#add-csv-status').val(instrument.csv_status);
          $('#add-computer-connected').val(instrument.computer_connected);
          $('#add-instrument-asset-code').val(instrument.instrument_asset_code);
          $('#add-status').val(instrument.status);
        }
      });
    });

    // Menambahkan event listener ke tombol detail
    $(".detail-button").on("click", function () {
      // Mendapatkan data-id dari tombol edit yang diklik
      var id = $(this).data("id");

      let urlEdit = `${baseUrl}/instruments/${id}/edit`;

      $.ajax({
        url: urlEdit,
        type: 'GET',
        success: function (data) {
          console.log(urlEdit);
          let instrument = data.data.instrument;
          console.log(instrument);
          $('#instrument-id-detail').text(`: ${instrument.id}`);
          $('#instrument-name-detail').text(`: ${instrument.instrument_name}`);
          $('#instrument-type-detail').text(`: ${instrument.instrument_type.instrument_type}`);
          $('#instrument-make-detail').text(`: ${instrument.instrument_make}`);
          $('#instrument-model-detail').text(`: ${instrument.instrument_model}`);
          $('#data-storage-detail').text(`: ${instrument.data_storage}`);
          $('#indirect-impact-detail').text(`: ${instrument.indirect_impact}`);
          $('#qualification-status-detail').text(`: ${instrument.qualification_status}`);
          $('#csv-status-detail').text(`: ${instrument.csv_status}`);
          $('#computer-connected-detail').text(`: ${instrument.computer_connected}`);
          $('#instrument-asset-code-detail').text(`: ${instrument.instrument_asset_code}`);
          $('#status-detail').text(instrument.status == 1 ? ": Active" : ": Retired");
          $('#department-id-detail').text(`: ${instrument.department_id}`);
          $('#department-name-detail').text(`: ${instrument.department.department}`);
          // let i = 1
          // facility.departments.forEach(department => {
          //   $('#TableBody').append(`
          //   <tr>
          //   <td>
          //   ${i++}
          //   </td>
          //   <td>
          //   ${department.id}
          //   </td>
          //   <td>
          //   ${department.department}
          //   </td>
          //   </tr>
          //   `);
          // });
        }
      });
    });


/******/ 	return __webpack_exports__;
    /******/
  })()
    ;
});
