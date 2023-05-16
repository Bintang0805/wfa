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
      var dt_equipment_table = $('.datatables-equipments'),
        offCanvasForm = $('#offcanvasAddEquipment');

      // Facilities datatable
      if (dt_equipment_table.length) {
        var dt_equipment = dt_equipment_table.DataTable({
          dom: '<"row mx-2"' + '<"col-md-2"<"me-3"l>>' + '<"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0"fB>>' + '>t' + '<"row mx-2"' + '<"col-sm-12 col-md-6"i>' + '<"col-sm-12 col-md-6"p>' + '>',
          buttons: [{
            text: '<i class="bx bx-plus me-0 me-sm-2"></i><span class="d-none d-sm-inline-block">Add New Equipment</span>',
            className: 'add-new btn btn-primary ms-2',
            attr: {
              'data-bs-toggle': 'offcanvas',
              'data-bs-target': '#offcanvasAddEquipment'
            }
          }],
        });
      }

      // clearing form data when offcanvas hidden
      offCanvasForm.on('hidden.bs.offcanvas', function () {
        let fv = $("#addNewEquipmentForm")
        fv[0].reset(true);
        $("#equipment_id").val("");
      });
    });

    var baseUrl = window.location.origin;

    // Menambahkan event listener ke tombol edit
    $(".edit-button").on("click", function () {
      // Mendapatkan data-id dari tombol edit yang diklik
      var id = $(this).data("id");

      let urlEdit = `${baseUrl}/equipments/${id}/edit`;

      $.ajax({
        url: urlEdit,
        type: 'GET',
        success: function (data) {
          let equipment = data.data.equipment;
          $('#equipment_id').val(equipment.id);
          $('#add-equipment-department').val(equipment.department.id);
          $('#add-equipment-type').val(equipment.equipment_type_id);
          $('#add-equipment-name').val(equipment.equipment_name);
          $('#add-equipment-make').val(equipment.equipment_make);
          $('#add-equipment-model').val(equipment.equipment_model);
          $('#add-data-storage').val(equipment.data_storage);
          $('#add-indirect-impact').val(equipment.indirect_impact);
          $('#add-qualification-status').val(equipment.qualification_status);
          $('#add-csv-status').val(equipment.csv_status);
          $('#add-equipment-number').val(equipment.equipment_number);
          $('#add-status').val(equipment.status);
        }
      });
    });

/******/ 	return __webpack_exports__;
    /******/
  })()
    ;
});
