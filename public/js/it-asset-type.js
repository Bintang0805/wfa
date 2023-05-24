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
    let AJAXGetAllURL = `${window.location.origin}/AJAX/it-asset-types/AJAXGetAll`;
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
      var dt_it_asset_type_table = $('.datatables-it-asset-types'),
        modal = $('#modalCenter');

      let hasError = $('#modalCenter').attr('data-errors')
      // console.log(hasError);
      if (hasError > 0) {
        modal.modal('show');
      }

      // Facilities datatable
      if (dt_it_asset_type_table.length) {
        var dt_it_asset_type = dt_it_asset_type_table.DataTable({
          dom: '<"row mx-2"' + '<"col-md-2"<"me-3"l>>' + '<"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0"fB>>' + '>t' + '<"row mx-2"' + '<"col-sm-12 col-md-6"i>' + '<"col-sm-12 col-md-6"p>' + '>',
          buttons: [
            {
              extend: 'collection',
              className: 'btn btn-label-secondary dropdown-toggle mx-3',
              text: '<i class="bx bx-export me-2"></i>Export',
              buttons: [
                {
                  extend: 'print',
                  title: 'IT Asset Types Print',
                  text: '<i class="bx bx-printer me-2" ></i>Print',
                  className: 'dropdown-item',
                  exportOptions: {
                    columns: [1],
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
                  title: 'IT Asset Types CSV',
                  text: '<i class="bx bx-file me-2" ></i>Csv',
                  className: 'dropdown-item',
                  exportOptions: {
                    columns: [1],
                  }
                },
                {
                  extend: 'excel',
                  title: 'Location Excel',
                  text: '<i class="bx bxs-file-export me-1"></i>Excel',
                  className: 'dropdown-item',
                  exportOptions: {
                    columns: [1],
                  }
                },
                {
                  extend: 'pdf',
                  title: 'IT Asset Types PDF',
                  text: '<i class="bx bxs-file-pdf me-2"></i>Pdf',
                  className: 'dropdown-item',
                  exportOptions: {
                    columns: [1],
                  }
                },
                {
                  extend: 'copy',
                  title: 'IT Asset Types Copy',
                  text: '<i class="bx bx-copy me-2" ></i>Copy',
                  className: 'dropdown-item',
                  exportOptions: {
                    columns: [1],
                  }
                }
              ]
            },
            {
              text: '<i class="bx bx-plus me-0 me-sm-2"></i><span class="d-none d-sm-inline-block">Add New It Asset Type</span>',
              className: 'add-new btn btn-primary ms-2',
              attr: {
                'data-bs-toggle': 'modal',
                'data-bs-target': '#modalCenter'
              }
            }],
        });
      }

      // clearing form data when offcanvas hidden
      modal.on('hidden.bs.offcanvas', function () {
        let fv = $("#addNewItAssetTypeForm")
        oldValue = null;
        fv[0].reset(true);
        $("#it_asset_type_id").val("");
      });
    });

    var baseUrl = window.location.origin;

    // Menambahkan event listener ke tombol edit
    $(".edit-button").on("click", function () {
      // Mendapatkan data-id dari tombol edit yang diklik
      var id = $(this).data("id");

      let urlEdit = `${baseUrl}/it-asset-types/${id}/edit`;

      $.ajax({
        url: urlEdit,
        type: 'GET',
        success: function (data) {
          let it_asset_type = data.data.it_asset_type;
          oldValue = it_asset_type.it_asset_type;
          $('#it_asset_type_id').val(it_asset_type.id);
          $('#add-it-asset-type').val(it_asset_type.it_asset_type);
        }
      });
    });

    // validating form and updating it asset type's data
    var addNewItAssetTypeForm = document.getElementById('addNewItAssetTypeForm');

    var fv = FormValidation.formValidation(addNewItAssetTypeForm, {
      fields: {
        it_asset_type: {
          validators: {
            notEmpty: {
              message: 'this is required'
            },
            callback: {
              message: "This field must be unique",
              callback: (input) => {
                if (GetAllData != null) {
                  let unique = GetAllData.find(function (data) {
                    return data.it_asset_type === input.value;
                  });
                  if(oldValue != null) {
                    return unique.it_asset_type == oldValue ? true : false;
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
            return '.mb-3';
          }
        }),
        submitButton: new FormValidation.plugins.SubmitButton(),
        // Submit the form when all fields are valid
        defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
        autoFocus: new FormValidation.plugins.AutoFocus()
      }
    })

    function uniqueValidate(value) {
      let url = `${baseUrl}/it-asset-types/validation-unique`;
      let result;
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      $.ajax({
        url: url,
        type: 'POST',
        data: {
          input: value,
        },
        async: false,
        success: function (data) {
          if(data.exists == true) {
            result = false;
          } else {
            result = true
          }
        },
        error: function() {
          return false;
        }
      });

      return result
    }


/******/ 	return __webpack_exports__;
    /******/
  })()
    ;
});
