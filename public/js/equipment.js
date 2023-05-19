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
        modal = $('#modalCenter');

      let hasError = $('#modalCenter').attr('data-errors')
      // console.log(hasError);
      if (hasError > 0) {
        modal.modal('show');
      }

      // Facilities datatable
      if (dt_equipment_table.length) {
        var dt_equipment = dt_equipment_table.DataTable({
          dom: '<"row mx-2"' + '<"col-md-2"<"me-3"l>>' + '<"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0"fB>>' + '>t' + '<"row mx-2"' + '<"col-sm-12 col-md-6"i>' + '<"col-sm-12 col-md-6"p>' + '>',
          buttons: [{
            text: '<i class="bx bx-plus me-0 me-sm-2"></i><span class="d-none d-sm-inline-block">Add New Equipment</span>',
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

    // Menambahkan event listener ke tombol detail
    $(".detail-button").on("click", function () {
      // Mendapatkan data-id dari tombol edit yang diklik
      var id = $(this).data("id");

      let urlEdit = `${baseUrl}/equipments/${id}/edit`;

      $.ajax({
        url: urlEdit,
        type: 'GET',
        success: function (data) {
          console.log(urlEdit);
          let equipment = data.data.equipment;
          console.log(equipment);
          $('#equipment-id-detail').text(`: ${equipment.id}`);
          $('#equipment-name-detail').text(`: ${equipment.equipment_name}`);
          $('#equipment-type-detail').text(`: ${equipment.equipment_type.equipment_type}`);
          $('#equipment-make-detail').text(`: ${equipment.equipment_make}`);
          $('#equipment-model-detail').text(`: ${equipment.equipment_model}`);
          $('#data-storage-detail').text(`: ${equipment.data_storage}`);
          $('#indirect-impact-detail').text(`: ${equipment.indirect_impact}`);
          $('#qualification-status-detail').text(`: ${equipment.qualification_status}`);
          $('#csv-status-detail').text(`: ${equipment.csv_status}`);
          $('#equipment-number-detail').text(`: ${equipment.equipment_number}`);
          $('#status-detail').text(equipment.status == 1 ? ": Active" : ": Retired");
          $('#department-id-detail').text(`: ${equipment.department_id}`);
          $('#department-name-detail').text(`: ${equipment.department.department}`);
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
