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
      var dt_department_table = $('.datatables-departments'),
        modal = $('#modalCenter');

      let hasError = $('#modalCenter').attr('data-errors')
      // console.log(hasError);
      if (hasError > 0) {
        modal.modal('show');
      }

      // Facilities datatable
      if (dt_department_table.length) {
        var dt_department = dt_department_table.DataTable({
          dom: '<"row mx-2"' + '<"col-md-2"<"me-3"l>>' + '<"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0"fB>>' + '>t' + '<"row mx-2"' + '<"col-sm-12 col-md-6"i>' + '<"col-sm-12 col-md-6"p>' + '>',
          buttons: [
            {
              extend: 'collection',
              className: 'btn btn-label-secondary dropdown-toggle mx-3',
              text: '<i class="bx bx-export me-2"></i>Export',
              buttons: [
                {
                  extend: 'print',
                  title: 'Departments Print',
                  text: '<i class="bx bx-printer me-2" ></i>Print',
                  className: 'dropdown-item',
                  exportOptions: {
                    columns: [1, 2, 3],
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
                  title: 'Departments CSV',
                  text: '<i class="bx bx-file me-2" ></i>Csv',
                  className: 'dropdown-item',
                  exportOptions: {
                    columns: [1, 2, 3],
                  }
                },
                {
                  extend: 'excel',
                  title: 'Location Excel',
                  text: '<i class="bx bxs-file-export me-1"></i>Excel',
                  className: 'dropdown-item',
                  exportOptions: {
                    columns: [1, 2, 3],
                  }
                },
                {
                  extend: 'pdf',
                  title: 'Departments PDF',
                  text: '<i class="bx bxs-file-pdf me-2"></i>Pdf',
                  className: 'dropdown-item',
                  exportOptions: {
                    columns: [1, 2, 3],
                  }
                },
                {
                  extend: 'copy',
                  title: 'Departments Copy',
                  text: '<i class="bx bx-copy me-2" ></i>Copy',
                  className: 'dropdown-item',
                  exportOptions: {
                    columns: [1, 2, 3],
                  }
                }
              ]
            },
            {
              text: '<i class="bx bx-plus me-0 me-sm-2"></i><span class="d-none d-sm-inline-block">Add New Department</span>',
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
        let fv = $("#addNewDepartmentForm")
        fv[0].reset(true);
        $("#department_id").val("");
      });
    });

    var baseUrl = window.location.origin;

    // Menambahkan event listener ke tombol edit
    $(".edit-button").on("click", function () {
      // Mendapatkan data-id dari tombol edit yang diklik
      var id = $(this).data("id");

      let urlEdit = `${baseUrl}/departments/${id}/edit`;

      $.ajax({
        url: urlEdit,
        type: 'GET',
        success: function (data) {
          let department = data.data.department;
          $('#department_id').val(department.id);
          $('#add-department-facility').val(department.facility_id);
          $('#add-department').val(department.department);
          $('#add-department-location').val(department.location_id);
        }
      });
    });

    // Menambahkan event listener ke tombol detail
    $(".detail-button").on("click", function () {
      // Mendapatkan data-id dari tombol edit yang diklik
      var id = $(this).data("id");

      let urlEdit = `${baseUrl}/departments/${id}/edit`;

      $.ajax({
        url: urlEdit,
        type: 'GET',
        success: function (data) {
          console.log(urlEdit);
          let department = data.data.department;
          console.log(department);
          $('#department-id-detail').text(`: ${department.id}`);
          $('#department-name-detail').text(`: ${department.department}`);
          $('#facility-id-detail').text(`: ${department.facility_id}`);
          $('#facility-name-detail').text(`: ${department.facility.facility_name}`);
          $('#location-id-detail').text(`: ${department.location_id}`);
          $('#location-name-detail').text(`: ${department.location.location_name}`);
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


    // validating form and updating department's data
    var addNewDepartmentForm = document.getElementById('addNewDepartmentForm');

    var fv = FormValidation.formValidation(addNewDepartmentForm, {
      fields: {
        facility_id: {
          validators: {
            notEmpty: {
              message: 'this is required'
            }
          }
        },
        department: {
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
