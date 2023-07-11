baseUrl = window.location.origin;

let AJAXGetAllRolesURL = `${window.location.origin}/AJAX/roles/AJAXGetAll`;
GetAllDataRoles = null;
fetch(AJAXGetAllRolesURL)
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

  // $("#make-form-later").checked
  var dt_workflow_table = $('.datatables-workflows')
  let modal = $('#createApp');

  // Locations datatable
  if (dt_workflow_table.length) {
    var dt_workflow = dt_workflow_table.DataTable({
    });
  }

  modal.on('hidden.bs.modal', function () {
    let fv = $("#addNewWorkflowForm")
    fv[0].reset(true);
    $("#workflow-id").val("");
  });

  dt_workflow.on('page.dt', function (e, settings) {
    setTimeout(() => {
      $(".edit-button").on("click", function () {
        // Mendapatkan data-id dari tombol edit yang diklik
        var id = $(this).data("id");

        let urlEdit = `${baseUrl}/workflows/${id}/edit`;

        $.ajax({
          url: urlEdit,
          type: 'GET',
          success: function (data) {
            let workflow = data.data.workflow;
            $('#workflow-id').val(workflow.id);
            $('#add-workflow-name').val(workflow.name);
            $('#add-workflow-description').val(workflow.description);
            let inputInitiationRole = $(".add-initiation-role").filter(function () { return $(this).val() == workflow.initiation_role });
            inputInitiationRole.prop("checked", true);
            $('#add-approver-roles').val(workflow.approver_roles);
            let inputWorkerRoles = $(".add-worker-roles").filter(function () { return $(this).val() == workflow.worker_roles });
            inputWorkerRoles.prop("checked", true);
            // $('#add-status').val(workflow.status);
            $('#add-email-reminder').val(workflow.email_reminder);
            $('#add-web-notification').val(workflow.web_notification);
            $('#add-associated-form').val(workflow.associated_form);
            if (workflow.associated_form != null) {
              document.getElementById("make-form-later").checked = false;
              document.getElementById("add-associated-form").disabled = false;
            }

            $("#modal-title").text("Edit Workflow");

            $('#inputNewApprover').empty();

            if (workflow.workflow_approvers.length > 0) {
              workflow.workflow_approvers.forEach(approver => {
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
                  if (role.id == approver.approver_roles) {
                    optionElement.selected = true;
                  }
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
              });
            } else {
              let approverInput = `
              <div class="d-flex flex-column justify-content-center form-input px-0">
                <select name="approver_roles" class="form-select">
                  ${GetAllDataRoles.map(role => `<option value="${role.id}">${role.name}</option>`).join('')}
                </select>
              </div>`
              $("#inputNewApprover").append(approverInput);
            }
          }
        });
      });

      $(".detail-button").on("click", function () {
        // Mendapatkan data-id dari tombol edit yang diklik
        var id = $(this).data("id");

        let urlEdit = `${baseUrl}/workflows/${id}/edit`;

        $.ajax({
          url: urlEdit,
          type: 'GET',
          success: function (data) {
            console.log(urlEdit);
            let workflow = data.data.workflow;
            console.log(workflow);
            $('#workflow-id-detail').text(`: ${workflow.id}`);
            $('#workflow-name-detail').text(`: ${workflow.name}`);
            $('#workflow-description-detail').text(`: ${workflow.description}`);
            $('#initiation-role-detail').text(`: ${workflow.initiation_role.name}`);
            // $('#level-of-approvers-detail').text(`: ${workflow.workflow_approvers.length}`);
            $('#worker-roles-detail').text(`: ${workflow.worker_role.name}`);
            $('#status-detail').text(`: ${workflow.status}`);
            $('#email-reminder-detail').text(`: ${workflow.email_reminder == 1 ? 'Yes' : 'No'}`);
            $('#web-notification-detail').text(`: ${workflow.web_notification == 1 ? 'Yes' : 'No'}`);
            let i = 1
            $("#TableBody").empty();
            if (workflow.workflow_approvers.length != 0) {
              workflow.workflow_approvers.forEach(workflow_approver => {
                $('#TableBody').append(`
              <tr>
              <td>
              ${i++}
              </td>
              <td>
              ${workflow_approver.role.name}
              </td>
              </tr>
              `);
              });
            }

          }
        });
      });
    }, 300);
  });

  // Menambahkan event listener ke tombol edit
  $(".edit-button").on("click", function () {
    // Mendapatkan data-id dari tombol edit yang diklik
    var id = $(this).data("id");

    let urlEdit = `${baseUrl}/workflows/${id}/edit`;

    $.ajax({
      url: urlEdit,
      type: 'GET',
      success: function (data) {
        let workflow = data.data.workflow;
        $('#workflow-id').val(workflow.id);
        $('#add-workflow-name').val(workflow.name);
        $('#add-workflow-description').val(workflow.description);
        let inputInitiationRole = $(".add-initiation-role").filter(function () { return $(this).val() == workflow.initiation_role });
        inputInitiationRole.prop("checked", true);
        $('#add-approver-roles').val(workflow.approver_roles);
        let inputWorkerRoles = $(".add-worker-roles").filter(function () { return $(this).val() == workflow.worker_roles });
        inputWorkerRoles.prop("checked", true);
        // $('#add-status').val(workflow.status);
        $('#add-email-reminder').val(workflow.email_reminder);
        $('#add-web-notification').val(workflow.web_notification);
        $('#add-associated-form').val(workflow.associated_form);

        $("#modal-title").text("Edit Workflow");

        if (workflow.associated_form != null) {
          document.getElementById("make-form-later").checked = false;
          document.getElementById("add-associated-form").disabled = false;
        }

        $('#inputNewApprover').empty();

        if (workflow.workflow_approvers.length > 0) {
          workflow.workflow_approvers.forEach(approver => {
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
              if (role.id == approver.approver_roles) {
                optionElement.selected = true;
              }
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
          });
        } else {
          let approverInput = `<div class="d-flex flex-column justify-content-center px-0">
          <select name="approver_roles" class="form-select">
            ${GetAllDataRoles.map(role => `<option value="${role.id}">${role.name}</option>`).join('')}
          </select>
        </div>`
          $("#inputNewApprover").append(approverInput);
        }
      }
    });
  });

  // Menambahkan event listener ke tombol detail
  $(".detail-button").on("click", function () {
    // Mendapatkan data-id dari tombol edit yang diklik
    var id = $(this).data("id");

    let urlEdit = `${baseUrl}/workflows/${id}/edit`;

    $.ajax({
      url: urlEdit,
      type: 'GET',
      success: function (data) {
        console.log(urlEdit);
        let workflow = data.data.workflow;
        console.log(workflow);
        $('#workflow-id-detail').text(`: ${workflow.id}`);
        $('#workflow-name-detail').text(`: ${workflow.name}`);
        $('#workflow-description-detail').text(`: ${workflow.description}`);
        $('#initiation-role-detail').text(`: ${workflow.initiation_role.name}`);
        // $('#level-of-approvers-detail').text(`: ${workflow.workflow_approvers.length}`);
        $('#worker-roles-detail').text(`: ${workflow.worker_role.name}`);
        $('#status-detail').text(`: ${workflow.status}`);
        $('#email-reminder-detail').text(`: ${workflow.email_reminder == 1 ? 'Yes' : 'No'}`);
        $('#web-notification-detail').text(`: ${workflow.web_notification == 1 ? 'Yes' : 'No'}`);

        let i = 1
        $("#TableBody").empty();
        if (workflow.workflow_approvers.length != 0) {
          workflow.workflow_approvers.forEach(workflow_approver => {
            $('#TableBody').append(`
              <tr>
              <td>
              ${i++}
              </td>
              <td>
              ${workflow_approver.role.name}
              </td>
              </tr>
              `);
          });
        }
      }
    });
  });


  $("#buttonCreateWorkflow").on("click", function () {
    $("#modal-title").text("Create Workflow")
  })

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


function toogleAssociatedForm(checked) {
  var select = document.getElementById("add-associated-form");
  if (checked) {
    select.disabled = true;
  } else {
    select.disabled = false;
  }
  // if(checked)
}
