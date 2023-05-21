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


    setTimeout(() => {
      if($(".success-toast")) {
        $(".success-toast").toast('hide');
      }
    }, 5000);

    setTimeout(() => {
      if($(".error-message")) {
        $(".error-message").toast('hide');
      }
    }, 5000);


    // Datatable (jquery)
    $(function () {
      // Variable declaration for table
      var dt_facility_table = $('.datatables-facilities'),
        modal = $('#modalCenter');

      let hasError = $('#modalCenter').attr('data-errors')
      // console.log(hasError);
      if(hasError > 0) {
        modal.modal('show');
      }

      // Facilities datatable
      if (dt_facility_table.length) {
        var dt_facility = dt_facility_table.DataTable({
          dom: '<"row mx-2"' + '<"col-md-2"<"me-3"l>>' + '<"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0"fB>>' + '>t' + '<"row mx-2"' + '<"col-sm-12 col-md-6"i>' + '<"col-sm-12 col-md-6"p>' + '>',
          buttons: [{
            extend: 'collection',
            className: 'btn btn-label-secondary dropdown-toggle mx-3',
            text: '<i class="bx bx-export me-2"></i>Export',
            buttons: [
              {
                extend: 'print',
                title: 'Facilities Print',
                text: '<i class="bx bx-printer me-2" ></i>Print',
                className: 'dropdown-item',
                exportOptions: {
                  columns: [1, 2],
                },
                customize: function (win) {
                  //customize print view for dark
                  $(win.document.body)
                    .css('color', config.colors.headingColor)
                    .css('border-color', config.colors.borderColor)
                    .css('background-color', config.colors.body);
                  $(win.document.body)
                    .find('table')
                    .addClass('compact')
                    .css('color', 'inherit')
                    .css('border-color', 'inherit')
                    .css('background-color', 'inherit');
                }
              },
              {
                extend: 'csv',
                title: 'Facilities CSV',
                text: '<i class="bx bx-file me-2" ></i>Csv',
                className: 'dropdown-item',
                exportOptions: {
                  columns: [1, 2],
                }
              },
              {
                extend: 'excel',
                title: 'Location Excel',
                text: '<i class="bx bxs-file-export me-1"></i>Excel',
                className: 'dropdown-item',
                exportOptions: {
                  columns: [1, 2],
                }
              },
              {
                extend: 'pdf',
                title: 'Facilities PDF',
                text: '<i class="bx bxs-file-pdf me-2"></i>Pdf',
                className: 'dropdown-item',
                exportOptions: {
                  columns: [1, 2],
                }
              },
              {
                extend: 'copy',
                title: 'Facilities Copy',
                text: '<i class="bx bx-copy me-2" ></i>Copy',
                className: 'dropdown-item',
                exportOptions: {
                  columns: [1, 2],
                }
              }
            ]
          },
          {
            text: '<i class="bx bx-plus me-0 me-sm-2"></i><span class="d-none d-sm-inline-block">Add New Facility</span>',
            className: 'add-new btn btn-primary ms-2',
            attr: {
              'data-bs-toggle': 'modal',
              'data-bs-target': '#modalCenter'
            }
          }],
        });
      }

      // clearing form data when offcanvas hidden
      modal.on('hidden.bs.modal', function () {
        let fv = $("#addNewFacilityForm")
        fv[0].reset(true);
        $("#facility_id").val("");
      });
    });

    $("#modalCenterDetail").on('hidden.bs.modal', function () {
      $("#TableBody").html("");
    })

    var baseUrl = window.location.origin;

    // Menambahkan event listener ke tombol edit
    $(".edit-button").on("click", function () {
      // Mendapatkan data-id dari tombol edit yang diklik
      var id = $(this).data("id");

      let urlEdit = `${baseUrl}/facilities/${id}/edit`;

      $.ajax({
        url: urlEdit,
        type: 'GET',
        success: function (data) {
          let facility = data.data.facility;
          $('#facility_id').val(facility.id);
          $('#add-facility-location').val(facility.location_id);
          $('#add-facility-name').val(facility.facility_name);
        }
      });
    });

    // Menambahkan event listener ke tombol detail
    $(".detail-button").on("click", function () {
      // Mendapatkan data-id dari tombol edit yang diklik
      var id = $(this).data("id");

      let urlEdit = `${baseUrl}/facilities/${id}/edit`;

      $.ajax({
        url: urlEdit,
        type: 'GET',
        success: function (data) {
          console.log(urlEdit);
          let facility = data.data.facility;
          console.log(facility);
          $('#facility-id-detail').text(`: ${facility.id}`);
          $('#facility-name-detail').text(`: ${facility.facility_name}`);
          $('#location-id').text(`: ${facility.location_id}`);
          $('#location-name-detail').text(`: ${facility.location.location_name}`);
          let i = 1
          facility.departments.forEach(department => {
            $('#TableBody').append(`
            <tr>
            <td>
            ${i++}
            </td>
            <td>
            ${department.id}
            </td>
            <td>
            ${department.department}
            </td>
            </tr>
            `);
          });
        }
      });
    });

    // validating form and updating facility's data
    var addNewFacilityForm = document.getElementById('addNewFacilityForm');

    var fv = FormValidation.formValidation(addNewFacilityForm, {
      fields: {
        location_id: {
          validators: {
            notEmpty: {
              message: 'this is required'
            }
          }
        },
        facility_name: {
          validators: {
            notEmpty: {
              message: 'this is required'
            },
          }
        },
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap5: new FormValidation.plugins.Bootstrap5({
          // Use this for enabling/changing valid/invalid class
          eleValidClass: '',
          rowSelector: function rowSelector(field, ele) {
            // field is the field name & ele is the field element
            return '.mb-3';
          }
        }),
        submitButton: new FormValidation.plugins.SubmitButton(),
        // Submit the form when all fields are valid
        defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
        autoFocus: new FormValidation.plugins.AutoFocus()
      }
    })

/******/ 	return __webpack_exports__;
    /******/
  })()
    ;
});
