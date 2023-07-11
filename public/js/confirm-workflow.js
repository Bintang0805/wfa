$(function() {
  $(".button-confirm").on("click", (event) => {
    let request = JSON.parse($(event.target).attr("data-request"));
    let approvedWorkflowId = $(event.target).attr("data-approved-workflow-id");
    $("#approved_workflow_id").val(approvedWorkflowId);
    delete request._token
    let requestKey = Object.keys(request);

    // console.log(requestLength);
    let inputPreview = $(".input-preview");
    inputPreview.empty();
    for (let i = 0; i < requestKey.length; i++) {
      console.log(request[requestKey[i]]);
      let wrapper = $("<div>").attr("class", "mt-3 col-12 col-md-6");
      let label = $("<label>").text(requestKey[i]);

      let input = $("<p>").attr("class", "w-100 text-dark text-break");
      input.text(request[requestKey[i]]);

      wrapper.append(label, input);
      inputPreview.append(wrapper);
    }

    $("#confirmRequest").modal("show");

  })
})
