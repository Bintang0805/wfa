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

    let AJAXGetAllURL = `${window.location.origin}/AJAX/permissions/AJAXGetAll`;
    let GetAllData = null;

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
      var dt_location_table = $('.datatables-permissions'),
        modal = $('#modalCenter');

      // Locations datatable
      if (dt_location_table.length) {
        var dt_location = dt_location_table.DataTable({
        });
      }

      // clearing form data when offcanvas hidden
      modal.on('hidden.bs.modal', function () {
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

    // Menambahkan event listener ke tombol detail
    $(".detail-button").on("click", function () {
      // Mendapatkan data-id dari tombol edit yang diklik
      var id = $(this).data("id");

      let urlEdit = `${baseUrl}/locations/${id}/edit`;

      $.ajax({
        url: urlEdit,
        type: 'GET',
        success: function (data) {
          console.log(urlEdit);
          let location = data.data.location;
          console.log(location);
          $('#location-id-detail').text(`: ${location.id}`);
          $('#location-name-detail').text(`: ${location.location_name}`);
          $('#company-id').text(`: ${location.company_id}`);
          $('#company-name-detail').text(`: ${location.company.name}`);
        }
      });
    });

    // validating form and updating user's data
    var addNewPermissionForm = document.getElementById('addNewPermissionForm');

    var fv = FormValidation.formValidation(addNewPermissionForm, {
      fields: {
        name: {
          validators: {
            notEmpty: {
              message: 'this is required'
            },
            callback: {
              message: "This field must be unique",
              callback: (input) => {
                if (GetAllData != null) {
                  let unique = GetAllData.find(function (data) {
                    return data.name === input.value;
                  });
                  return unique != null ? false : true;
                } else {
                  return true;
                }
              }
            },
            callback: {
              message: "Format for this field is invalid",
              callback: (input) => {
                var regex = /^[a-z]+-[a-z_]+$/;
                // return regex.test(input) ? true : false;
                console.log(regex.test(input.value));
                if (regex.test(input.value)) {
                  return true;
                } else {
                  return false;
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
    var addNewLocationFormEdit = document.getElementById('addNewLocationFormEdit');

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
