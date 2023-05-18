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
      var dt_it_asset_table = $('.datatables-it-assets'),
        modal = $('#modalCenter');

      // Facilities datatable
      if (dt_it_asset_table.length) {
        var dt_it_asset = dt_it_asset_table.DataTable({
          dom: '<"row mx-2"' + '<"col-md-2"<"me-3"l>>' + '<"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0"fB>>' + '>t' + '<"row mx-2"' + '<"col-sm-12 col-md-6"i>' + '<"col-sm-12 col-md-6"p>' + '>',
          buttons: [{
            text: '<i class="bx bx-plus me-0 me-sm-2"></i><span class="d-none d-sm-inline-block">Add New IT Asset</span>',
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
        let fv = $("#addNewItAssetForm")
        fv[0].reset(true);
        $("#it_asset_id").val("");
      });
    });

    var baseUrl = window.location.origin;

    // Menambahkan event listener ke tombol edit
    $(".edit-button").on("click", function () {
      // Mendapatkan data-id dari tombol edit yang diklik
      var id = $(this).data("id");

      let urlEdit = `${baseUrl}/it-assets/${id}/edit`;

      $.ajax({
        url: urlEdit,
        type: 'GET',
        success: function (data) {
          let it_asset = data.data.it_asset;
          $('#it_asset_id').val(it_asset.id);
          $('#add-it-asset-department').val(it_asset.department.id);
          $('#add-it-asset-type').val(it_asset.it_asset_type_id);
          $('#add-make').val(it_asset.make);
          $('#add-model').val(it_asset.model);
          $('#add-oem-sl-no').val(it_asset.oem_sl_no);
          $('#add-host-name').val(it_asset.host_name);
          $('#add-ip-address').val(it_asset.ip_address);
          $('#add-asset-type').val(it_asset.asset_type);
          $('#add-os-ver').val(it_asset.os_ver);
          $('#add-asset-status').val(it_asset.asset_status);
          $('#add-owner-name').val(it_asset.owner_name);
        }
      });
    });

    // Menambahkan event listener ke tombol detail
    $(".detail-button").on("click", function () {
      // Mendapatkan data-id dari tombol edit yang diklik
      var id = $(this).data("id");

      let urlEdit = `${baseUrl}/it-assets/${id}/edit`;

      $.ajax({
        url: urlEdit,
        type: 'GET',
        success: function (data) {
          console.log(urlEdit);
          let it_asset = data.data.it_asset;
          console.log(it_asset);
          $('#it-asset-id-detail').text(`: ${it_asset.id}`);
          $('#it-asset-type-id-detail').text(`: ${it_asset.it_asset_type_id}`);
          $('#it-asset-type-detail').text(`: ${it_asset.it_asset_type.it_asset_type}`);
          $('#it-asset-make-detail').text(`: ${it_asset.make}`);
          $('#it-asset-model-detail').text(`: ${it_asset.model}`);
          $('#oem-sl-no-detail').text(`: ${it_asset.oem_sl_no}`);
          $('#host-name-detail').text(`: ${it_asset.host_name}`);
          $('#ip-address-detail').text(`: ${it_asset.ip_address}`);
          $('#asset-type-detail').text(`: ${it_asset.asset_type}`);
          $('#os-ver-detail').text(`: ${it_asset.os_ver}`);
          $('#asset-status-detail').text(it_asset.asset_status == 1 ? ": Active" : ": Retired");
          $('#owner-name-detail').text(it_asset.owner_name);
          $('#department-id-detail').text(`: ${it_asset.department_id}`);
          $('#department-name-detail').text(`: ${it_asset.department.department}`);
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
