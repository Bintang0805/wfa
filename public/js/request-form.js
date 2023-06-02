var dt_location_table = $('.datatables-form-fields')

// Locations datatable
if (dt_location_table.length) {
  var dt_location = dt_location_table.DataTable({
  });
}

let AJAXGetAllURL = `${window.location.origin}/AJAX/request-forms/AJAXGetAll`;
let GetAllData = null;

$.ajax({
  url: AJAXGetAllURL,
  type: 'GET',
  success: function (data) {
    GetAllData = data.data;
    console.log(GetAllData);
    return true;
  },
  error: function () {
    return false;
  }
});

let fields = {
  data: [],
};

let previewJSON = document.getElementById("preview-input-json");
let inputFormFields = document.getElementById("input-form-fields");

function loadFields() {
  var formBuilder = $(".dropper-elements");
  formBuilder.empty();

  if (!fields.data || fields.data.length === 0) {
    formBuilder.innerHTML = "";
  }

  fields.data.forEach(function (field) {
    if (Array.isArray(field.input)) {
      loadCombinedInput(field, formBuilder);
    } else {
      loadSingleInput(field, formBuilder);
    }
  });

  console.log(fields);
  console.log(JSON.stringify(fields, null, 2));
  let inputJSON = JSON.stringify(fields);
  let fieldsJSON = JSON.stringify(fields, null, 2).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
  previewJSON.innerHTML = "<pre>" + fieldsJSON + "</pre>";
  inputFormFields.value = inputJSON;
}

function loadCombinedInput(field, formBuilder) {
  console.log("Data Ini Hasil Cobine");
  console.log(fields);

  let rowWrapper = $("<div>").addClass(field.class);
  rowWrapper.attr("draggable", "false");

  field.input.forEach(combineInput => {
    var baseInput = {
      id: combineInput.id,
      input: {
        wrapper: {
          class: combineInput.input.wrapper.class + " " + "col-6",
        },
        label: {
          text: combineInput.input.label.text,
          for: combineInput.input.label.for,
        },
        input: {
          attributes: {
            class: combineInput.input.input.attributes.class,
            type: combineInput.input.input.attributes.type,
            name: combineInput.input.input.attributes.name,
            id: combineInput.input.input.attributes.id,
            required: combineInput.input.input.attributes.required,
            placeholder: combineInput.input.input.attributes.placeholder,
          },
        },
      },
    };

    var wrapper = createUnDraggableWrapper(baseInput);
    var label = createInputLabel(baseInput);
    var inputGroup = createInputGroup();
    var span = createInputSpan();
    var buttonConfig = createConfigButton(combineInput);
    var buttonDelete = createDeleteButton(combineInput);
    var input = createInput(baseInput);

    wrapper.append(label);
    span.append(buttonConfig);
    span.append(buttonDelete);
    inputGroup.append(input, span);
    wrapper.append(inputGroup);
    rowWrapper.append(wrapper);

    var noElement = $("#no-element");
    if (noElement.length > 0) {
      formBuilder.empty();
    }

    buttonConfig.on("click", function () {
      configureInput(combineInput);
      return;
    });

    formBuilder.removeClass("d-flex align-items-center justify-content-center");
    formBuilder.append(rowWrapper);
  });
}

function loadCombinedInputPreview(field, formBuilder) {
  let rowWrapper = $("<div>").addClass(field.class);
  rowWrapper.attr("draggable", "false");

  field.input.forEach(combineInput => {
    var baseInput = {
      id: combineInput.id,
      input: {
        wrapper: {
          class: combineInput.input.wrapper.class + " " + "col-6",
        },
        label: {
          text: combineInput.input.label.text,
          for: combineInput.input.label.for,
        },
        input: {
          attributes: {
            class: combineInput.input.input.attributes.class,
            type: combineInput.input.input.attributes.type,
            name: combineInput.input.input.attributes.name,
            id: combineInput.input.input.attributes.id,
            required: combineInput.input.input.attributes.required,
            placeholder: combineInput.input.input.attributes.placeholder,
          },
        },
      },
    };

    var wrapper = createUnDraggableWrapper(baseInput);
    var label = createInputLabel(baseInput);
    var inputGroup = createInputGroup();
    var input = createInput(baseInput);

    wrapper.append(label);
    inputGroup.append(input);
    wrapper.append(inputGroup);
    rowWrapper.append(wrapper);

    var noElement = $("#no-element");
    if (noElement.length > 0) {
      formBuilder.empty();
    }

    formBuilder.removeClass("d-flex align-items-center justify-content-center");
    formBuilder.append(rowWrapper);
  });
}

function loadSingleInput(field, formBuilder) {
  var baseInput = {
    id: field.id,
    input: {
      wrapper: {
        class: field.input.wrapper.class,
      },
      label: {
        text: field.input.label.text,
        for: field.input.label.for,
      },
      input: {
        attributes: {
          class: field.input.input.attributes.class,
          type: field.input.input.attributes.type,
          name: field.input.input.attributes.name,
          id: field.input.input.attributes.id,
          required: field.input.input.attributes.required,
          placeholder: field.input.input.attributes.placeholder,
        },
      },
    },
  };

  var wrapper = createDraggableWrapper(baseInput);
  var label = createInputLabel(baseInput);
  var inputGroup = createInputGroup();
  var span = createInputSpan();
  var buttonConfig = createConfigButton(field);
  var buttonDelete = createDeleteButton(field);
  var input = createInput(baseInput);

  wrapper.append(label);
  span.append(buttonConfig);
  span.append(buttonDelete);
  inputGroup.append(input, span);
  wrapper.append(inputGroup);

  var noElement = $("#no-element");
  if (noElement.length > 0) {
    formBuilder.empty();
  }

  formBuilder.removeClass("d-flex align-items-center justify-content-center");
  formBuilder.append(wrapper);

  buttonConfig.on("click", function () {
    configureInput(field);
    return;
  });
}

function loadSingleInputPreview(field, formBuilder) {
  var baseInput = {
    id: field.id,
    input: {
      wrapper: {
        class: field.input.wrapper.class,
      },
      label: {
        text: field.input.label.text,
        for: field.input.label.for,
      },
      input: {
        attributes: {
          class: field.input.input.attributes.class,
          type: field.input.input.attributes.type,
          name: field.input.input.attributes.name,
          id: field.input.input.attributes.id,
          required: field.input.input.attributes.required,
          placeholder: field.input.input.attributes.placeholder,
        },
      },
    },
  };

  var wrapper = createDraggableWrapper(baseInput);
  var label = createInputLabel(baseInput);
  var inputGroup = createInputGroup();
  var input = createInput(baseInput);

  wrapper.append(label);
  inputGroup.append(input);
  wrapper.append(inputGroup);

  var noElement = $("#no-element");
  if (noElement.length > 0) {
    formBuilder.empty();
  }

  formBuilder.removeClass("d-flex align-items-center justify-content-center");
  formBuilder.append(wrapper);
}

function createUnDraggableWrapper(baseInput) {
  return $("<div>")
    .attr({
      "data-id": baseInput.id,
      draggable: "false",
      style: "user-select: none",
    })
    .addClass(baseInput.input.wrapper.class)
}

function createDraggableWrapper(baseInput) {
  return $("<div>")
    .attr({
      "data-id": baseInput.id,
      draggable: "true",
    })
    .addClass(baseInput.input.wrapper.class)
    .on("dragstart", function (event) {
      let inputId = $(this).data("id");
      event.originalEvent.dataTransfer.setData("input-id", inputId);
    })
    .on("dragover", function (event) {
      event.preventDefault();
    })
    .on("drop", (event) => {
      let inputId = event.originalEvent.dataTransfer.getData("input-id");
      let inputDropper = event.target.parentNode.parentNode.getAttribute("data-id");
      if (inputId != inputDropper && inputId != null && inputDropper != null) {
        combineInput(inputId, inputDropper);
      }
    });
}

function createInputLabel(baseInput) {
  return $("<label>", baseInput.input.label).text(baseInput.input.label.text);
}

function createInputGroup() {
  return $("<div>").addClass("input-group");
}

function createInputSpan() {
  return $("<span>").addClass("input-group-text");
}

function createConfigButton(input) {
  return $("<button>")
    .addClass("btn btn-sm btn-outline-secondary me-2")
    .attr({
      "data-bs-toggle": "modal",
      "data-bs-target": "#modalConfigureInput",
    })
    .text("Config");
}

function createDeleteButton(input) {
  return $("<button>")
    .addClass("btn btn-sm btn-outline-danger deleteInput")
    .attr("onclick", `deleteInput(${input.id})`)
    .text("X");
}

function createInput(baseInput) {
  return $("<input>", baseInput.input.input.attributes);
}

function configureInput(input) {
  $("#input_required").val(input.input.input.attributes.required);
  $("#input_label").val(input.input.label.text);
  $("#input_id").val(input.input.input.attributes.id);
  $("#input_class").val(input.input.input.attributes.class);
  $("#input_name").val(input.input.input.attributes.name);
  $("#input_type").val(input.input.input.attributes.type);
  $("#input_placeholder").val(input.input.input.attributes.placeholder);
  $("#form-configure-input").attr("data-id", input.id);
}


function addNewInput(type) {
  let baseInput = {
    id: Math.floor(Math.random() * 100000) + 1,
    input: {
      wrapper: {
        class: "mb-3 form-input",
      },
      label: {
        text: "Label Name",
        for: "",
      },
      input: {
        attributes: {
          class: "form-control",
          type: type,
          name: "",
          id: "",
          required: "false",
          placeholder: "",
        },
      }
    }
  };

  fields.data.push(baseInput);
}

function onDropInput(event) {
  event.preventDefault();
  let inputType = event.dataTransfer.getData("input-type");
  let inputId = event.dataTransfer.getData("input-id");

  if (inputId) {
    console.log(inputId);
  } else {
    addNewInput(inputType);
  }

  loadFields();
}

function combineInput(inputDrag, inputDropper) {
  // console.log("Input Drag: " + inputDrag);
  // console.log("Input Dropper: " + inputDropper);
  inputDragIndex = fields.data.findIndex(f => f.id == inputDrag);
  inputDropperIndex = fields.data.findIndex(f => f.id == inputDropper);

  console.log("Input Drag Index : " + inputDragIndex);
  console.log("Input Dropper Index : " + inputDropperIndex);

  let newObject = {
    class: "row",
    input: [fields.data[inputDropperIndex], fields.data[inputDragIndex]]
  };

  if (!Array.isArray(fields.data[inputDropperIndex])) {
    fields.data[inputDropperIndex] = newObject;
    fields.data.splice(inputDragIndex, 1);
  }
}

function allowDrop(event) {
  event.preventDefault();
}

let draggableItems = $(".draggable-items");
draggableItems.on("dragstart", function (event) {
  let inputType = $(this).data("type");
  event.originalEvent.dataTransfer.setData("input-type", inputType);
});

function deleteInput(id) {
  // let indexToRemove = fields.data.findIndex(f => f.id === id);
  let indexToRemove = findIndexInputById(fields.data, id);
  if (Array.isArray(indexToRemove)) {
    fields.data[indexToRemove[0]].input.splice(indexToRemove[1], 1);
    fields.data[indexToRemove[0]] = fields.data[indexToRemove[0]].input[0];
    console.log(fields.data);
  } else {
    if (indexToRemove !== -1) {
      fields.data.splice(indexToRemove, 1);
    }
  }
  loadFields();
}

function findIndexInputById(arr, id) {
  for (let i = 0; i < arr.length; i++) {
    if (arr[i].id == id) {
      return i;
    }

    if (arr[i].input && Array.isArray(arr[i].input)) {
      for (let j = 0; j < arr[i].input.length; j++) {
        if (arr[i].input[j].id == id) {
          return [i, j];
        }
      }
    }
  }
  return null;
}

function findInputById(arr, id) {
  for (let i = 0; i < arr.length; i++) {
    if (arr[i].id == id) {
      return arr[i];
    }

    if (arr[i].input && Array.isArray(arr[i].input)) {
      const nestedResult = findInputById(arr[i].input, id);
      if (nestedResult) {
        return nestedResult;
      }
    }
  }

  return null;
}

$("#save-configure-input").on("click", function () {
  let id = $("#form-configure-input").attr('data-id');
  let formValues = $("#form-configure-input").serializeArray().reduce(function (obj, item) {
    obj[item.name] = item.value;
    return obj;
  }, {});

  let field = findInputById(fields.data, id);

  field.input.label.text = formValues.input_label;
  field.input.input.attributes.required = formValues.input_required;
  field.input.input.attributes.id = formValues.input_id;
  field.input.input.attributes.class = formValues.input_class;
  field.input.input.attributes.name = formValues.input_name;
  field.input.input.attributes.placeholder = formValues.input_placeholder;
  field.input.input.attributes.required = formValues.input_required;
  field.input.input.attributes.type = formValues.input_type;

  $("#modalConfigureInput").modal("hide");
  $("#form-configure-input")[0].reset();
  loadFields();
});

function loadPreviewFields(id) {
  var formBuilder = $(".input-preview");
  formBuilder.empty();

  console.log(id);
  // let field = JSON.parse(GetAllData)
  let fields = JSON.parse(GetAllData.find(f => f.id == id).fields);

  if (!fields.data || fields.data.length === 0) {
    formBuilder.innerHTML = "";
  }

  fields.data.forEach(function (field) {
    if (Array.isArray(field.input)) {
      loadCombinedInputPreview(field, formBuilder);
    } else {
      loadSingleInputPreview(field, formBuilder);
    }
  });
}

let buttonLoadPreview = $(".button-fields-preview").on("click", (event) => {
  let id = event.target.getAttribute("data-id");;
  console.log(id);
  loadPreviewFields(id)
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
