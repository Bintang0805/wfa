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

    // Get All Data With Ajax
    let AJAXGetAllURL = `${window.location.origin}/AJAX/applications/AJAXGetAll`;
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
        $(".error-message").toast('hide');
      }
    }, 5000);

    // Datatable (jquery)
    $(function () {
      // Variable declaration for table
      var dt_application_table = $('.datatables-applications'),
        modal = $('#modalCenter');

      // Facilities datatable
      if (dt_application_table.length) {
        var dt_application = dt_application_table.DataTable({
          dom: '<"row mx-2"' + '<"col-md-2"<"me-3"l>>' + '<"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0"fB>>' + '>t' + '<"row mx-2"' + '<"col-sm-12 col-md-6"i>' + '<"col-sm-12 col-md-6"p>' + '>',
          buttons: [{
            text: '<i class="bx bx-plus me-0 me-sm-2"></i><span class="d-none d-sm-inline-block">Add New Application</span>',
            className: 'add-new btn btn-primary ms-2',
            attr: {
              'data-bs-toggle': 'modal',
              'data-bs-target': '#modalCenter'
            }
          }],
        });
      }
      function filterColumn(i, val) {
        dt_application_table.DataTable().column(i).search(val, false, true).draw();
      }

      $('input.dt-input').on('keyup', function () {
        filterColumn($(this).attr('data-column'), $(this).val());
      });

      // clearing form data when modal hidden
      modal.on('hidden.bs.modal', function () {
        let fv = $("#addNewApplicationForm");
        oldValue = null;
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
          oldValue = application.application_name;
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

    // Menambahkan event listener ke tombol detail
    $(".detail-button").on("click", function () {
      // Mendapatkan data-id dari tombol edit yang diklik
      var id = $(this).data("id");

      let urlEdit = `${baseUrl}/applications/${id}/edit`;

      $.ajax({
        url: urlEdit,
        type: 'GET',
        success: function (data) {
          console.log(urlEdit);
          let application = data.data.application;
          console.log(application);
          $('#application-id-detail').text(`: ${application.id}`);
          $('#application-name-detail').text(`: ${application.application_name}`);
          $('#application-ver-detail').text(`: ${application.application_ver}`);
          $('#connected-to-computer-detail').text(`: ${application.connected_to_computer == 1 ? "Yes" : "No"}`);
          $('#application-department-detail').text(`: ${application.department}.id`);
          $('#connected-to-server-detail').text(`: ${application.connected_to_server == 1 ? "Yes" : "No"}`);
          $('#application-role-type-detail').text(`: ${application.application_role_type}`);
          $('#privilages-detail').text(`: ${application.privilages}`);
          $('#manufacturer-detail').text(`: ${application.manufacturer}`);
          $('#gamp-category-detail').text(`: ${application.gamp_category}`);
          $('#csv-status-detail').text(`: ${application.csv_status}`);
          $('#csv-completed-on-detail').text(`: ${application.csv_completed_on}`);
          $('#periodic-review-detail').text(`: ${application.periodic_review}`);
          $('#gxp-status-detail').text(`: ${application.gxp_status}`);
          $('#backup-mode-detail').text(`: ${application.backup_mode}`);
          $('#data-type-detail').text(`: ${application.data_type}`);
          $('#vendor-detail').text(`: ${application.vendor_details}`);
          $('#status-detail').text(`: ${application.status}`);
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

    // validating form and updating application's data
    var addNewApplicationForm = document.getElementById('addNewApplicationForm');

    var fv = FormValidation.formValidation(addNewApplicationForm, {
      fields: {
        application_name: {
          validators: {
            notEmpty: {
              message: 'this is required'
            },
            callback: {
              message: "This field must be unique",
              callback: (input) => {
                if (GetAllData != null) {
                  let unique = GetAllData.find(function (data) {
                    return data.application_name === input.value;
                  });
                  if (oldValue != null) {
                    return unique.application_name == oldValue ? true : false;
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
        application_ver: {
          validators: {
            notEmpty: {
              message: 'this is required'
            },
          }
        },
        connected_to_computer: {
          validators: {
            notEmpty: {
              message: 'this is required'
            },
          }
        },
        department_id: {
          validators: {
            notEmpty: {
              message: 'this is required'
            },
          }
        },
        connected_to_server: {
          validators: {
            notEmpty: {
              message: 'this is required'
            },
          }
        },
        application_role_type: {
          validators: {
            notEmpty: {
              message: 'this is required'
            },
          }
        },
        privilages: {
          validators: {
            notEmpty: {
              message: 'this is required'
            },
          }
        },
        manufacturer: {
          validators: {
            notEmpty: {
              message: 'this is required'
            },
          }
        },
        gamp_category: {
          validators: {
            notEmpty: {
              message: 'this is required'
            },
          }
        },
        csv_status: {
          validators: {
            notEmpty: {
              message: 'this is required'
            },
          }
        },
        csv_completed_on: {
          validators: {
            notEmpty: {
              message: 'this is required'
            },
          }
        },
        periodic_review: {
          validators: {
            notEmpty: {
              message: 'this is required'
            },
          }
        },
        gxp_status: {
          validators: {
            notEmpty: {
              message: 'this is required'
            },
          }
        },
        backup_mode: {
          validators: {
            notEmpty: {
              message: 'this is required'
            },
          }
        },
        data_type: {
          validators: {
            notEmpty: {
              message: 'this is required'
            },
          }
        },
        vendor_details: {
          validators: {
            notEmpty: {
              message: 'this is required'
            },
          }
        },
        status: {
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
