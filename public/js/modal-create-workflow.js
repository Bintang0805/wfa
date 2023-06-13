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

$(function () {
  // Modal id
  const appModal = document.getElementById('createApp');

  var addNewWorkflow = document.getElementById('addNewWorkflowForm');

  var fv = FormValidation.formValidation(addNewWorkflow, {
    fields: {
      name: {
        validators: {
          notEmpty: {
            message: 'this is required'
          }
        }
      },
      // initiation_role: {
      //   validators: {
      //     notEmpty: {
      //       message: 'this is required'
      //     },
      //   }
      // },
      // worker_roles: {
      //   validators: {
      //     notEmpty: {
      //       message: 'this is required'
      //     },
      //   }
      // },
      // approver_roles: {
      //   validators: {
      //     notEmpty: {
      //       message: 'this is required'
      //     },
      //   }
      // },
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
      // // Submit the form when all fields are valid
      // defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
      // autoFocus: new FormValidation.plugins.AutoFocus()
    }
  })

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
          let getApproverRoles = formData.filter(f => f.name == "approver_roles");
          let getWorkflow = formData.filter(f => f.name != "approver_roles");

          let worfklowStoreURL = `${window.location.origin}/workflows`;
          let worfklowApproverStoreURL = `${window.location.origin}/workflow-approvers`;

          fv.validate().then((status) => {
            if (status == "Valid") {
              $.ajaxSetup({
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
              });

              $.ajax({
                url: worfklowStoreURL,
                type: 'POST',
                data: getWorkflow,
                success: function (data) {
                  let worfklowApproverDeleteAllURL = `${window.location.origin}/AJAX/workflow-approvers/deleteAll/${data.data.id}`;
                  $.ajax({
                    url: worfklowApproverDeleteAllURL,
                    type: 'GET',
                    success: function () {
                      setTimeout(() => {
                        getApproverRoles.forEach(approverRole => {
                          $.ajax({
                            url: worfklowApproverStoreURL,
                            type: 'POST',
                            data: {
                              workflow_id: data.data.id,
                              approver_roles: approverRole.value
                            },
                            success: function (data) {
                              console.log(data);
                              return true;
                            },
                            error: function () {
                              return false;
                            }
                          });
                        });

                        $("#datatables-workflows").load(location.href + " #datatables-workflows");
                        $(".success-toast").toast('show');
                        let fr = $("#addNewWorkflowForm")
                        fr[0].reset(true);
                        $("#createApp").modal("hide");
                        setTimeout(() => {
                          if ($(".success-toast")) {
                            $(".success-toast").toast('hide');
                          }
                        }, 5000);
                      }, 300);
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
            } else {
              createAppStepper.previous();
              createAppStepper.previous();
              createAppStepper.previous();
              createAppStepper.previous();
            }
          })
        });
      }
    }
  });



  $("#addNewApprover").on("click", () => {
    let newApproverInput = document.createElement("div");
    newApproverInput.className = "d-flex align-items-center px-0";

    let selectElement = document.createElement("select");
    selectElement.name = "approver_roles";
    selectElement.className = "form-select";

    let defaultOption = document.createElement("option");
    defaultOption.value = "";
    defaultOption.textContent = "Select";
    selectElement.appendChild(defaultOption);

    GetAllDataRoles.forEach(role => {
      let optionElement = document.createElement("option");
      optionElement.value = role.id;
      optionElement.textContent = role.role_name;
      selectElement.appendChild(optionElement);
    });

    let deleteButton = document.createElement("button");
    deleteButton.className = "btn btn-danger btn-sm ms-2";
    deleteButton.textContent = "X";

    newApproverInput.appendChild(selectElement);
    newApproverInput.appendChild(deleteButton);

    $("#inputNewApprover").append(newApproverInput);

    deleteButton.addEventListener("click", () => {
      newApproverInput.remove();
    });
  })

  function addDefaultInputApprover() {
    let newApproverInput = document.createElement("div");
    newApproverInput.className = "d-flex align-items-center px-0";

    let selectElement = document.createElement("select");
    selectElement.name = "approver_roles";
    selectElement.className = "form-select";

    let defaultOption = document.createElement("option");
    defaultOption.value = "";
    defaultOption.textContent = "Select";
    selectElement.appendChild(defaultOption);

    GetAllDataRoles.forEach(role => {
      let optionElement = document.createElement("option");
      optionElement.value = role.id;
      optionElement.textContent = role.role_name;
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


