$(function () {

  var dt_workflow_table = $('.datatables-workflows')
  let modal = $('#modalCenter');

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

  var baseUrl = window.location.origin;

  let AJAXGetAllRolesURL = `${window.location.origin}/AJAX/roles/AJAXGetAll`;
  let GetAllDataRoles = null;
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

        $('#inputNewApprover').empty();

        workflow.workflow_approvers.forEach(approver => {
          let approverInput = `<div class="d-flex align-items-center px-0">
                                <select name="approver_roles" class="form-select">
                                  <option value="">Select</option>
                                  ${GetAllDataRoles.map(role => `<option value="${role.id}" ${role.id === approver.approver_roles ? 'selected' : ''}>${role.role_name}</option>`).join('')}
                                </select>
                                <button class="btn btn-danger btn-sm ms-2">X</button>
                              </div>`;
          $('#inputNewApprover').append(approverInput);
        });
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
        $('#initiation-role-detail').text(`: ${workflow.initiation_role}`);
        $('#level-of-approvers-detail').text(`: ${workflow.level_of_approvers}`);
        $('#approver-roles-detail').text(`: ${workflow.approver_roles}`);
        $('#worker-roles-detail').text(`: ${workflow.worker_roles}`);
        $('#status-detail').text(`: ${workflow.status}`);
        $('#email-reminder-detail').text(`: ${workflow.email_reminder}`);
        $('#web-notification-detail').text(`: ${workflow.web_notification}`);
      }
    });
  });


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
