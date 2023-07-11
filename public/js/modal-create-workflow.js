/**
 *  Modal Example Wizard
 */

'use strict';

let AJAXGetAllURL = `${window.location.origin}/AJAX/roles/AJAXGetAll`;
let GetAllDataRoles = null;
fetch(AJAXGetAllURL)
  .then(response => response.json())
  .then(data => {
    GetAllDataRoles = data.data;
    return true;
  })
  .catch(error => {
    console.error(error);
    return false;
  });

let AJAXGetAllFormURL = `${window.location.origin}/AJAX/request-forms/AJAXGetAll`;
let GetAllDataForm = null;
let selectOptionsForm = {};
fetch(AJAXGetAllFormURL)
  .then(response => response.json())
  .then(data => {

    GetAllDataForm = data.data;
    GetAllDataForm = GetAllDataForm.map(form => {
      let fields = form.id;
      let value = form.name;
      return { [fields]: value };
    });
    GetAllDataForm.forEach(obj => {
      let key = Object.keys(obj)[0];
      let value = obj[key];
      selectOptionsForm[key] = value.toString();
    });

    return true;
  })
  .catch(error => {
    console.error(error);
    return false;
  });

$(function () {
  // Modal id
  const appModal = document.getElementById('createApp');

  // var fv = FormValidation.formValidation(addNewWorkflow, {
  //   fields: {
  //     name: {
  //       validators: {
  //         notEmpty: {
  //           message: 'this is required'
  //         }
  //       }
  //     },
  //     // initiation_role: {
  //     //   validators: {
  //     //     notEmpty: {
  //     //       message: 'this is required'
  //     //     },
  //     //   }
  //     // },
  //     // worker_roles: {
  //     //   validators: {
  //     //     notEmpty: {
  //     //       message: 'this is required'
  //     //     },
  //     //   }
  //     // },
  //     // approver_roles: {
  //     //   validators: {
  //     //     notEmpty: {
  //     //       message: 'this is required'
  //     //     },
  //     //   }
  //     // },
  //   },
  //   plugins: {
  //     trigger: new FormValidation.plugins.Trigger(),
  //     // bootstrap5: new FormValidation.plugins.Bootstrap5({
  //     //   // Use this for enabling/changing valid/invalid class
  //     //   eleValidClass: '',
  //     //   rowSelector: function rowSelector(field, ele) {
  //     //     // field is the field name & ele is the field element
  //     //     return '.form-input';
  //     //   }
  //     // }),
  //     submitButton: new FormValidation.plugins.SubmitButton(),
  //     // // Submit the form when all fields are valid
  //     // defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
  //     // autoFocus: new FormValidation.plugins.AutoFocus()
  //   }
  // })

  appModal.addEventListener('show.bs.modal', function (event) {
    const wizardCreateApp = document.querySelector('#wizard-create-app');
    if (typeof wizardCreateApp !== undefined && wizardCreateApp !== null) {
      // Wizard next prev button
      const wizardCreateAppNextList = [].slice.call(wizardCreateApp.querySelectorAll('.btn-next'));
      const wizardCreateAppPrevList = [].slice.call(wizardCreateApp.querySelectorAll('.btn-prev'));
      const wizardCreateAppBtnSubmit = wizardCreateApp.querySelector('.btn-submit');

      const createAppStepper = new Stepper(wizardCreateApp, {
        linear: false
      });

      if (wizardCreateAppNextList) {
        wizardCreateAppNextList.forEach(wizardCreateAppNext => {
          wizardCreateAppNext.addEventListener('click', event => {
            createAppStepper.next();
          });
        });
      }
      if (wizardCreateAppPrevList) {
        wizardCreateAppPrevList.forEach(wizardCreateAppPrev => {
          wizardCreateAppPrev.addEventListener('click', event => {
            createAppStepper.previous();
          });
        });
      }

      if (wizardCreateAppBtnSubmit) {
        wizardCreateAppBtnSubmit.addEventListener('click', event => {
          let formData = $(event.target.parentNode.parentNode.parentNode.parentNode).serializeArray();

          if (formData.length == 0) {
            formData = $(event.target.parentNode.parentNode.parentNode).serializeArray();
          }

          let worfklowStoreURL = `${window.location.origin}/workflows`;
          let worfklowApproverStoreURL = `${window.location.origin}/workflow-approvers`;

          let validate = checkValidInput(formData, ["name", "initiation_role", "worker_roles", "approver_roles"], ["_token", "id"]);
          // console.log(validate);
          if (validate.isValid) {
            createNewWorkflow(worfklowStoreURL, worfklowApproverStoreURL, formData)
          } else {
            showErrors(validate.validateInput);
            let firstInvalidInput = validate.validateInput.find(f => f.isValid == false);

            if (firstInvalidInput) {
              switch (firstInvalidInput.name) {
                case "name":
                  createAppStepper.previous();
                  createAppStepper.previous();
                  createAppStepper.previous();
                  createAppStepper.previous();
                  createAppStepper.previous();
                  createAppStepper.previous();
                  break;
                case "initiation_role":
                  createAppStepper.previous();
                  createAppStepper.previous();
                  createAppStepper.previous();
                  createAppStepper.previous();
                  createAppStepper.previous();
                  break;
                case "worker_roles":
                  createAppStepper.previous();
                  createAppStepper.previous();
                  createAppStepper.previous();
                  createAppStepper.previous();
                  break;
                case "approver_roles":
                  createAppStepper.previous();
                  createAppStepper.previous();
                  createAppStepper.previous();
                  break;
                default:
                  createAppStepper.previous();
                  createAppStepper.previous();
                  createAppStepper.previous();
                  createAppStepper.previous();
                  createAppStepper.previous();
                  createAppStepper.previous();
                  break;
              }
            }
          }
        });
      }
    }
  });



  let removedRoles = [];
  let oldFirstSelect = null;
  let firstSelectValue = null;
  $("#addNewApprover").on("click", (event) => {
    let formData = $("#addNewWorkflowForm").serializeArray()
    let selectedApproverRoles = formData.filter(f => f.name == "approver_roles" && f.value != "");
    let notSelectedRoles = GetAllDataRoles;
    selectedApproverRoles.forEach(selectedApproverRole => {
      notSelectedRoles = notSelectedRoles.filter(f => f.id != selectedApproverRole.value);
    });

    if (notSelectedRoles.length == 0) {
      $("#errorRole").toast("show");
      setTimeout(() => {
        $("#errorRole").toast("hide");
      }, 3000);

      return false;
    }

    let newApproverInput = document.createElement("div");
    newApproverInput.className = "d-flex flex-colum justify-content-center px-0";

    let selectElement = document.createElement("select");
    selectElement.name = "approver_roles";
    selectElement.className = "form-select";

    // let defaultOption = document.createElement("option");
    // defaultOption.value = "";
    // defaultOption.textContent = "Select";
    // selectElement.appendChild(defaultOption);

    notSelectedRoles.forEach(role => {
      let optionElement = document.createElement("option");
      optionElement.value = role.id;
      optionElement.textContent = role.name;
      selectElement.appendChild(optionElement);
    });

    let deleteButton = document.createElement("button");
    deleteButton.className = "btn btn-danger btn-sm ms-2";
    deleteButton.textContent = "X";

    newApproverInput.appendChild(selectElement);
    newApproverInput.appendChild(deleteButton);

    $("#inputNewApprover").append(newApproverInput);

    selectElement.addEventListener("change", (event) => {
      console.log("okeee");
    })

    deleteButton.addEventListener("click", (event) => {
      newApproverInput.remove();
    });
  })

  function addDefaultInputApprover() {
    let newApproverInput = document.createElement("div");
    newApproverInput.className = "d-flex align-items-center px-0";

    let selectElement = document.createElement("select");
    selectElement.name = "approver_roles";
    selectElement.className = "form-select";

    // let defaultOption = document.createElement("option");
    // defaultOption.value = "";
    // defaultOption.textContent = "Select";
    // selectElement.appendChild(defaultOption);

    GetAllDataRoles.forEach(role => {
      let optionElement = document.createElement("option");
      optionElement.value = role.id;
      optionElement.textContent = role.name;
      selectElement.appendChild(optionElement);
    });

    newApproverInput.appendChild(selectElement);

    $("#inputNewApprover").append(newApproverInput);
  }

  $('#createApp').on('hidden.bs.modal', function () {
    $("#inputNewApprover").empty();
    addDefaultInputApprover();
  });
});


function checkValidInput(serializeForm, notText = [], ignore = []) {
  let response = [];
  let object = {};

  if (ignore.length > 0) {
    ignore.forEach(field => {
      serializeForm = serializeForm.filter(f => f.name != field);
    });
  }

  let getApproverRoles = serializeForm.filter(f => f.name == "approver_roles");

  if (notText.length > 0) {
    notText.forEach(fieldName => {
      if (fieldName != "approver_roles") {
        if (serializeForm.filter(f => f.name == fieldName).length == 0) {
          object = {
            "name": fieldName,
            "isValid": false,
          }

          response.push(object)
        } else {
          if (serializeForm.find(f => f.name == fieldName).value == "") {
            object = {
              "name": fieldName,
              "isValid": false,
            }
          } else {
            object = {
              "name": fieldName,
              "isValid": true,
            }
          }

          response.push(object)
        }
      } else {
        let approverRolesValid = true;
        if (getApproverRoles.length > 0) {
          getApproverRoles.forEach(input => {
            if (input.value == "") {
              approverRolesValid = false;
            }
          })
        } else {
          approverRolesValid = false;
        }

        object = {
          "name": "approver_roles",
          "isValid": approverRolesValid
        }

        response.push(object);
      }
    });
  }

  let formValid = true;
  response.forEach(res => {
    if (!res.isValid) {
      formValid = false;
    }
  });

  response = {
    "validateInput": response,
    "isValid": formValid
  }

  return response;
}


function showErrors(validateData) {
  console.log(validateData);
  validateData.forEach(input => {
    let elInput = $(`#input_${input.name}`);
    if (!input.isValid) {
      if (elInput.hasClass("d-none")) {
        elInput.removeClass("d-none");
      }
    } else {
      if (!elInput.hasClass("d-none")) {
        elInput.addClass("d-none");
      }
    }
  })
}

function createNewWorkflow(workflowURL, approverURL, formData) {
  let getWorkflow = formData.filter(f => f.name != "approver_roles");
  let getApproverRoles = formData.filter(f => f.name == "approver_roles");

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $.ajax({
    url: workflowURL,
    type: 'POST',
    data: getWorkflow,
    async: false,
    success: function (data) {
      let worfklowApproverDeleteAllURL = `${window.location.origin}/AJAX/workflow-approvers/deleteAll/${data.data.id}`;
      $.ajax({
        url: worfklowApproverDeleteAllURL,
        type: 'GET',
        async: false,
        success: function () {
          $.ajax({
            url: approverURL,
            type: 'POST',
            data: {
              workflow_id: data.data.id,
              approver_roles: getApproverRoles,
            },
            success: function (data) {
              $(".success-toast").toast('show');
              let fr = $("#addNewWorkflowForm")
              fr[0].reset(true);
              $("#createApp").modal("hide");
              setTimeout(() => {
                location.reload();
              }, 1000);
              setTimeout(() => {
                if ($(".success-toast")) {
                  $(".success-toast").toast('hide');
                }
              }, 5000);
              return true;
            },
            error: function () {
              return false;
            }
          });
          return true;
        },
        error: function () {
          return false;
        }
      });
      return true;
    },
    error: function () {
      return false;
    }
  });
}
