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

    let AJAXGetAllURL = `${window.location.origin}/AJAX/roles/AJAXGetAll`;
    let GetAllData = null;
    let oldValue = null;

    $.ajax({
      url: AJAXGetAllURL,
      type: 'GET',
      success: function (data) {
        GetAllData = data.data;
        return true;
      },
      error: function () {
        return false;
      }
    });

    setTimeout(() => {
      if ($(".success-toast")) {
        $(".success-toast").toast('hide');
      }
    }, 5000);

    setTimeout(() => {
      if ($(".error-message")) {
        $(".error-message").alert('close');
      }
    }, 5000);


    // Datatable (jquery)
    $(function () {
      // Variable declaration for table
      var dt_role_table = $('.datatables-roles'),
        modal = $('#modalCenter');

      // Locations datatable
      if (dt_role_table.length) {
        var dt_role = dt_role_table.DataTable({
          dom: '<"row mx-2"' + '<"col-md-2"<"me-3"l>>' + '<"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0"fB>>' + '>t' + '<"row mx-2"' + '<"col-sm-12 col-md-6"i>' + '<"col-sm-12 col-md-6"p>' + '>',
          buttons: [
            {
              extend: 'collection',
              className: 'btn btn-label-secondary dropdown-toggle mx-3',
              text: '<i class="bx bx-export me-2"></i>Export',
              buttons: [
                {
                  extend: 'print',
                  title: 'Locations Print',
                  text: 'Print',
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
                  title: 'Locations CSV',
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
                  title: 'Locations PDF',
                  text: '<i class="bx bxs-file-pdf me-2"></i>Pdf',
                  className: 'dropdown-item',
                  exportOptions: {
                    columns: [1, 2],
                  }
                },
                {
                  extend: 'copy',
                  title: 'Locations Copy',
                  text: '<i class="bx bx-copy me-2" ></i>Copy',
                  className: 'dropdown-item',
                  exportOptions: {
                    columns: [1, 2],
                  }
                }
              ]
            }],
        });
      }

      // clearing form data when offcanvas hidden
      modal.on('hidden.bs.modal', function () {
        let fv = $("#addNewRoleForm")
        oldValue = null;
        fv[0].reset(true);
        $("#role_id").val("");
      });
    });

    var baseUrl = window.location.origin;

    // Menambahkan event listener ke tombol edit
    $(".edit-button").on("click", function () {
      // Mendapatkan data-id dari tombol edit yang diklik
      var id = $(this).data("id");

      let urlEdit = `${baseUrl}/user/roles/${id}/edit`;

      $.ajax({
        url: urlEdit,
        type: 'GET',
        success: function (data) {
          console.log(urlEdit);
          let role = data.data.role;
          oldValue = role.role_name;
          $('#role_id').val(role.id);
          $('#role_name').val(role.role_name);
        }
      });
    });

    // Menambahkan event listener ke tombol detail
    // $(".detail-button").on("click", function () {
    //   // Mendapatkan data-id dari tombol edit yang diklik
    //   var id = $(this).data("id");

    //   let urlEdit = `${baseUrl}/roles/${id}/edit`;

    //   $.ajax({
    //     url: urlEdit,
    //     type: 'GET',
    //     success: function (data) {
    //       console.log(urlEdit);
    //       let location = data.data.location;
    //       console.log(location);
    //       $('#location-id-detail').text(`: ${location.id}`);
    //       $('#location-name-detail').text(`: ${location.location_name}`);
    //       $('#company-id').text(`: ${location.company_id}`);
    //       $('#company-name-detail').text(`: ${location.company.name}`);
    //     }
    //   });
    // });

    // validating form and updating user's data
    var addNewRoleForm = document.getElementById('addNewRoleForm');

    var fv = FormValidation.formValidation(addNewRoleForm, {
      fields: {
        role_name: {
          validators: {
            notEmpty: {
              message: 'this is required'
            },
            callback: {
              message: "This field must be unique",
              callback: (input) => {
                if (GetAllData != null) {
                  let unique = GetAllData.find(function (data) {
                    return data.role_name === input.value;
                  });
                  if (oldValue != null) {
                    return unique.role_name == oldValue ? true : false;
                  } else {
                    return unique != null ? false : true;
                  }
                } else {
                  return true;
                }
              }
            }
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
            return '.form-input';
          }
        }),
        submitButton: new FormValidation.plugins.SubmitButton(),
        // Submit the form when all fields are valid
        defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
        autoFocus: new FormValidation.plugins.AutoFocus()
      }
    })

    // validating form and updating location's data
    // var addNewLocationFormEdit = document.getElementById('addNewLocationFormEdit');

    // var fv = FormValidation.formValidation(addNewLocationFormEdit, {
    //   fields: {
    //     company_id: {
    //       validators: {
    //         notEmpty: {
    //           message: 'this is required'
    //         }
    //       }
    //     },
    //     location_name: {
    //       validators: {
    //         notEmpty: {
    //           message: 'this is required'
    //         },
    //       }
    //     },
    //   },
    //   plugins: {
    //     trigger: new FormValidation.plugins.Trigger(),
    //     bootstrap5: new FormValidation.plugins.Bootstrap5({
    //       // Use this for enabling/changing valid/invalid class
    //       eleValidClass: '',
    //       rowSelector: function rowSelector(field, ele) {
    //         // field is the field name & ele is the field element
    //         return '.form-input';
    //       }
    //     }),
    //     submitButton: new FormValidation.plugins.SubmitButton(),
    //     // Submit the form when all fields are valid
    //     defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
    //     autoFocus: new FormValidation.plugins.AutoFocus()
    //   }
    // })

/******/ 	return __webpack_exports__;
    /******/
  })()
    ;
});

function showPermission(form) {
  event.preventDefault();
  Swal.fire({
    title: 'Are you sure?',
    text: "You won't to delete this?",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes'
  }).then((result) => {
    if (result.isConfirmed) {
      form.submit(); // <--- submit form programmatically
    } else if (
      result.dismiss === Swal.DismissReason.cancel
    ) {
      swalWithBootstrapButtons.fire(
        'Cancelled',
        'Your data is safe :)',
        'error'
      )
    }
  })
}
