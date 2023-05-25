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
    let AJAXGetAllURL = `${window.location.origin}/AJAX/equipments/AJAXGetAll`;
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
        oldValue = null;
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
          oldValue = equipment.equipment_name;
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

    // validating form and updating equipment's data
    var addNewEquipmentForm = document.getElementById('addNewEquipmentForm');

    var fv = FormValidation.formValidation(addNewEquipmentForm, {
      fields: {
        department_id: {
          validators: {
            notEmpty: {
              message: 'this is required'
            }
          }
        },
        equipment_type_id: {
          validators: {
            notEmpty: {
              message: 'this is required'
            },
          }
        },
        equipment_name: {
          validators: {
            notEmpty: {
              message: 'this is required'
            },
            callback: {
              message: "This field must be unique",
              callback: (input) => {
                if (GetAllData != null) {
                  let unique = GetAllData.find(function (data) {
                    return data.equipment_name === input.value;
                  });
                  if (oldValue != null) {
                    return unique.equipment_name == oldValue ? true : false;
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
        equipment_make: {
          validators: {
            notEmpty: {
              message: 'this is required'
            },
          }
        },
        equipment_model: {
          validators: {
            notEmpty: {
              message: 'this is required'
            },
          }
        },
        data_storage: {
          validators: {
            notEmpty: {
              message: 'this is required'
            },
          }
        },
        indirect_impact: {
          validators: {
            notEmpty: {
              message: 'this is required'
            },
          }
        },
        qualification_status: {
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
        equipment_number: {
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
