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
    } else if (field.input.select) {
      loadSelectInput(field, formBuilder)
    } else if(field.input.input.attributes.type == "checkbox") {
      loadCheckboxInput(field, formBuilder)
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
    var baseInput = null
    if (combineInput.input.select) {
      baseInput = {
        id: combineInput.id,
        input: {
          wrapper: {
            class: combineInput.input.wrapper.class + " " + "col-6",
          },
          label: {
            text: combineInput.input.label.text,
            for: combineInput.input.label.for,
          },
          select: {
            attributes: {
              class: combineInput.input.select.attributes.class,
              type: combineInput.input.select.attributes.type,
              name: combineInput.input.select.attributes.name,
              id: combineInput.input.select.attributes.id,
              required: combineInput.input.select.attributes.required,
              placeholder: combineInput.input.select.attributes.placeholder,
            },
            option: {
              option: combineInput.input.select.option.option
            }
          },
        },
      };
    } else {
      baseInput = {
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
    }

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
      console.log(combineInput);
      configureInput(combineInput);
      return;
    });

    formBuilder.removeClass("d-flex align-items-center justify-content-center");
    formBuilder.append(rowWrapper);
  });
}

function loadSelectInput(field, formBuilder) {
  baseInput = {
    id: field.id,
    input: {
      wrapper: {
        class: field.input.wrapper.class,
      },
      label: {
        text: field.input.label,
        for: "",
      },
      select: {
        attributes: {
          class: field.input.select.attributes.class,
          name: field.input.select.attributes.name,
          id: field.input.select.attributes.id,
          required: field.input.select.attributes.required,
          placeholder: field.input.select.attributes.placeholder
        },
        option: {
          option: field.input.select.option.option
        }
      }
    }
  }

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

function loadCheckboxInput(field, formBuilder) {
  baseInput = {
    id: field.id,
    input: {
      wrapper: {
        class: field.input.wrapper.class,
      },
      label: {
        text: field.input.label,
        for: "",
      },
      input: {
        attributes: {
          type: field.input.input.attributes.type,
          class: field.input.input.attributes.class,
          name: field.input.input.attributes.name,
          id: field.input.input.attributes.id,
          required: field.input.input.attributes.required,
          placeholder: field.input.input.attributes.placeholder
        },
        option: {
          option: field.input.input.option.option
        }
      }
    }
  }

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

function loadCheckboxInputPreview(field, formBuilder) {
  baseInput = {
    id: field.id,
    input: {
      wrapper: {
        class: field.input.wrapper.class,
      },
      label: {
        text: field.input.label,
        for: "",
      },
      input: {
        attributes: {
          type: field.input.input.attributes.type,
          class: field.input.input.attributes.class,
          name: field.input.input.attributes.name,
          id: field.input.input.attributes.id,
          required: field.input.input.attributes.required,
          placeholder: field.input.input.attributes.placeholder
        },
        option: {
          option: field.input.input.option.option
        }
      }
    }
  }

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

function loadSelectInputPreview(field, formBuilder) {
  baseInput = {
    id: field.id,
    input: {
      wrapper: {
        class: field.input.wrapper.class,
      },
      label: {
        text: field.input.label,
        for: "",
      },
      select: {
        attributes: {
          class: field.input.select.attributes.class,
          name: field.input.select.attributes.name,
          id: field.input.select.attributes.id,
          required: field.input.select.attributes.required,
          placeholder: field.input.select.attributes.placeholder
        },
        option: {
          option: field.input.select.option.option
        }
      }
    }
  }

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

function loadCombinedInputPreview(field, formBuilder) {
  let rowWrapper = $("<div>").addClass(field.class);
  rowWrapper.attr("draggable", "false");

  field.input.forEach(combineInput => {
    let baseInput = null;
    if (combineInput.input.select) {
      baseInput = {
        id: combineInput.id,
        input: {
          wrapper: {
            class: combineInput.input.wrapper.class + " " + "col-6",
          },
          label: {
            text: combineInput.input.label.text,
            for: combineInput.input.label.for,
          },
          select: {
            attributes: {
              class: combineInput.input.select.attributes.class,
              type: combineInput.input.select.attributes.type,
              name: combineInput.input.select.attributes.name,
              id: combineInput.input.select.attributes.id,
              required: combineInput.input.select.attributes.required,
              placeholder: combineInput.input.select.attributes.placeholder,
            },
            option: {
              option: combineInput.input.select.option.option
            }
          },
        },
      };
    } else {
      baseInput = {
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
    }

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
  if (field.input.input.attributes.type == "hidden") {
    formBuilder.append(input);
  } else {
    formBuilder.append(wrapper);
  }
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
      if (inputId != inputDropper && inputId != null && inputDropper != null && inputId != "") {
        combineInput(inputId, inputDropper);
      }
    });
}

function createInputLabel(baseInput) {
  if (baseInput.input.label.text.text) {
    return $("<label>", baseInput.input.label.text).text(baseInput.input.label.text.text);
  } else {
    return $("<label>", baseInput.input.label).text(baseInput.input.label.text);
  }
}

function createInputGroup() {
  return $("<div>").addClass("input-group d-flex justify-content-between");
}

function createInputSpan() {
  return $("<span>").addClass("input-group-text");
}

function createConfigButton(input) {
  if (input.input.select) {
    return $("<button>")
      .addClass("btn btn-sm btn-outline-secondary me-2")
      .attr({
        "data-bs-toggle": "modal",
        "data-bs-target": "#modalConfigureSelect",
      })
      .text("Config");
  } else if (input.input.input.attributes.type == "checkbox") {
    return $("<button>")
      .addClass("btn btn-sm btn-outline-secondary me-2")
      .attr({
        "data-bs-toggle": "modal",
        "data-bs-target": "#modalConfigureCheckbox",
      })
      .text("Config")
  } else {
    return $("<button>")
      .addClass("btn btn-sm btn-outline-secondary me-2")
      .attr({
        "data-bs-toggle": "modal",
        "data-bs-target": "#modalConfigureInput",
      })
      .text("Config");
  }
}

function createDeleteButton(input) {
  return $("<button>")
    .addClass("btn btn-sm btn-outline-danger deleteInput")
    .attr("onclick", `deleteInput(${input.id})`)
    .text("X");
}

function createInput(baseInput) {
  let input = null;
  if (baseInput.input.select) {
    input = $("<select>", baseInput.input.select.attributes);
    optionPlaceholder = $("<option>");
    optionPlaceholder.attr("disable", "");
    optionPlaceholder.attr("selected", "");
    optionPlaceholder.text(baseInput.input.select.attributes.placeholder);
    input.append(optionPlaceholder);
    // let optionTexts = baseInput.input.select.option.option.text;
    // let optionValues = baseInput.input.select.option.option.value;
    let options = baseInput.input.select.option.option;
    if (options.text) {
      if (options.text.length > options.value.length) {
        for (let i = 0; i < options.text.length; i++) {
          let option = $("<option>").val(options.value[i]).text(options.text[i]);
          input.append(option);
        }
      } else {
        for (let i = 0; i < options.value.length; i++) {
          let option = $("<option>").val(options.value[i]).text(options.text[i]);
          input.append(option);
        }
      }
    }
    // options.forEach(option => {
    //   option
    // });
    // option.forEach(opt => {
    //   opt
    // });
  } else if (baseInput.input.input.attributes.type == "text-area") {
    input = $("<textarea>", baseInput.input.input.attributes);
  } else if (baseInput.input.input.attributes.type == "checkbox") {
    input = $("<div>");
    if(baseInput.input.input.option.option.text) {
      for (let i = 0; i < baseInput.input.input.option.option.text.length; i++) {
        let grp = $("<div>").addClass("form-check");
        grp.append($("<input>", baseInput.input.input.attributes).attr("name", `${baseInput.input.input.attributes.name}[]`).val(baseInput.input.input.option.option.value[i]));
        grp.append($("<label>").addClass("form-check-label").text(baseInput.input.input.option.option.text[i]))
        input.append(grp);
      }
    } else {
      input = $("<div>").addClass("form-check");
      input.append($("<input>", baseInput.input.input.attributes).attr("name", `${baseInput.input.input.attributes.name}[]`));
      input.append($("<label>").addClass("form-check-label"))
    }
  } else {
    input = $("<input>", baseInput.input.input.attributes);
  }

  return input;
  // return $("<input>", baseInput.input.input.attributes);
}

function configureInput(input) {
  console.log(input);
  let par = $('#ParentSelectOption');
  // let select_name = $(".select_value");
  // if(select_name.length > 1) {
  //   for (let i = 0; i < select_name.length - 1; i++) {
  //       par[0].remove(select_name[i].parentNode.parentNode.parentNode);
  //   }
  //   // select_name.forEach(element => {
  //   // });
  // }
  if (input.input.select) {
    $("#select_required").val(input.input.select.attributes.required);
    $("#select_label").val(input.input.label.text);
    $("#select_id").val(input.input.select.attributes.id);
    $("#select_class").val(input.input.select.attributes.class);
    $("#select_name").val(input.input.select.attributes.name);
    $("#select_type").val(input.input.select.attributes.type);
    $("#select_placeholder").val(input.input.select.attributes.placeholder);
    $("#form-configure-select").attr("data-id", input.id);
    if (input.input.select.option.option.text) {
      if (input.input.select.option.option.text.length > input.input.select.option.option.value.length) {
        for (let i = 0; i < input.input.select.option.option.text.length; i++) {
          if (i == 0) {
            $("#select_option_value").val(input.input.select.option.option.value[i])
            $("#select_option_text").val(input.input.select.option.option.text[i])
          } else {
            addNewSelectOption();
            let selectValue = $(".select_value");
            $(".select_value")[i - 1].value = input.input.select.option.option.value[i];
            $(".select_text")[i - 1].value = input.input.select.option.option.text[i];
          }
        }
      } else {
        for (let i = 0; i < input.input.select.option.option.value.length; i++) {
          if (i == 0) {
            $("#select_option_value").val(input.input.select.option.option.value[i])
            $("#select_option_text").val(input.input.select.option.option.text[i])
          } else {
            addNewSelectOption();
            let selectValue = $(".select_value");
            let selectValueLength = selectValue.length - 1;
            $(".select_value")[i - 1].value = input.input.select.option.option.value[i];
            $(".select_text")[i - 1].value = input.input.select.option.option.text[i];
          }
        }
      }
    }
  } if (input.input.input.attributes.type == "checkbox") {
    $("#checkbox_required").val(input.input.input.attributes.required);
    $("#checkbox_label").val(input.input.label.text);
    $("#checkbox_id").val(input.input.input.attributes.id);
    $("#checkbox_class").val(input.input.input.attributes.class);
    $("#checkbox_name").val(input.input.input.attributes.name);
    $("#checkbox_type").val(input.input.input.attributes.type);
    $("#checkbox_placeholder").val(input.input.input.attributes.placeholder);
    $("#form-configure-checkbox").attr("data-id", input.id);
    if (input.input.input.option.option.text) {
      if (input.input.input.option.option.text.length > input.input.input.option.option.value.length) {
        for (let i = 0; i < input.input.input.option.option.text.length; i++) {
          if (i > 0) {
            addNewCheckboxOption();
          }
          $(".checkbox_value")[i].value = input.input.input.option.option.value[i];
          $(".checkbox_text")[i].value = input.input.input.option.option.text[i];
        }
      } else {
        for (let i = 0; i < input.input.input.option.option.value.length; i++) {
          if (i > 0) {
            addNewCheckboxOption();
          }
          $(".checkbox_value")[i].value = input.input.input.option.option.value[i];
          $(".checkbox_text")[i].value = input.input.input.option.option.text[i];
        }
      }
    }
  } else {
    $("#input_required").val(input.input.input.attributes.required);
    $("#input_label").val(input.input.label.text);
    $("#input_id").val(input.input.input.attributes.id);
    $("#input_class").val(input.input.input.attributes.class);
    $("#input_name").val(input.input.input.attributes.name);
    $("#input_type").val(input.input.input.attributes.type);
    $("#input_placeholder").val(input.input.input.attributes.placeholder);
    $("#form-configure-input").attr("data-id", input.id);
  }
}


function addNewInput(type, label, placeholder) {
  let baseInput = null;
  if (type == "select") {
    baseInput = {
      id: Math.floor(Math.random() * 100000) + 1,
      input: {
        wrapper: {
          class: "mb-3 form-input",
        },
        label: {
          text: label,
          for: "",
        },
        select: {
          attributes: {
            class: "form-select",
            name: "",
            id: "",
            required: "false",
            placeholder: placeholder
          },
          option: {
            option: {}
          }
        }
      }
    }
  } else if (type == "checkbox") {
    baseInput = {
      id: Math.floor(Math.random() * 100000) + 1,
      input: {
        wrapper: {
          class: "mb-3 form-input",
        },
        label: {
          text: label,
          for: "",
        },
        input: {
          attributes: {
            class: "form-check-input",
            type: type,
            name: "",
            id: "",
            required: "false",
            placeholder: placeholder,
          },
          option: {
            option: {}
          }
        }
      }
    };
  } else {
    baseInput = {
      id: Math.floor(Math.random() * 100000) + 1,
      input: {
        wrapper: {
          class: "mb-3 form-input",
        },
        label: {
          text: label,
          for: "",
        },
        input: {
          attributes: {
            class: "form-control",
            type: type,
            name: "",
            id: "",
            required: "false",
            placeholder: placeholder,
          },
        }
      }
    };
  }

  fields.data.push(baseInput);
}

function onDropInput(event) {
  event.preventDefault();
  let inputType = event.dataTransfer.getData("input-type");
  let inputLabel = event.dataTransfer.getData("input-label");
  let inputPlaceholder = event.dataTransfer.getData("input-placeholder");
  let inputId = event.dataTransfer.getData("input-id");

  if (inputId) {
    console.log(inputId);
  } else {
    addNewInput(inputType, inputLabel, inputPlaceholder);
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
  let inputLabel = $(this).data("label");
  let inputPlaceholder = $(this).data("placeholder");
  event.originalEvent.dataTransfer.setData("input-type", inputType);
  event.originalEvent.dataTransfer.setData("input-label", inputLabel);
  event.originalEvent.dataTransfer.setData("input-placeholder", inputPlaceholder);
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

$("#save-configure-select").on("click", function () {
  let id = $("#form-configure-select").attr('data-id');
  let formValues = $("#form-configure-select").serializeArray().reduce(function (obj, item) {
    obj[item.name] = item.value;
    return obj;
  }, {});

  let formData = $("#form-configure-select").serializeArray();

  var optionTexts = [];
  var optionValues = [];

  // Memproses data serialized
  formData.forEach(function (field) {
    if (field.name === 'option_text[]') {
      optionTexts.push(field.value);
    } else if (field.name === 'option_value[]') {
      optionValues.push(field.value);
    }
  });
  let option = [];
  option["text"] = optionTexts;
  option["value"] = optionValues;
  option = {
    text: option["text"],
    value: option["value"]
  }

  let field = findInputById(fields.data, id);

  field.input.label.text = formValues.input_label;
  field.input.select.attributes.required = formValues.input_required;
  field.input.select.attributes.id = formValues.input_id;
  field.input.select.attributes.class = formValues.input_class;
  field.input.select.attributes.name = formValues.input_name;
  field.input.select.attributes.placeholder = formValues.input_placeholder;
  field.input.select.attributes.required = formValues.input_required;
  field.input.select.option.option = option;

  $("#modalConfigureSelect").modal("hide");
  $("#form-configure-select")[0].reset();
  loadFields();
  $('#ParentSelectOption').load(location.href + ' #ParentSelectOption');
});

$("#save-configure-checkbox").on("click", () => {
  let id = $("#form-configure-checkbox").attr('data-id');
  let formValues = $("#form-configure-checkbox").serializeArray().reduce(function (obj, item) {
    obj[item.name] = item.value;
    return obj;
  }, {});

  let formData = $("#form-configure-checkbox").serializeArray();

  var checkboxTexts = [];
  var checkboxValues = [];

  // Memproses data serialized
  formData.forEach(function (field) {
    if (field.name === 'checkbox_text[]') {
      checkboxTexts.push(field.value);
    } else if (field.name === 'checkbox_value[]') {
      checkboxValues.push(field.value);
    }
  });
  let checkbox = [];
  checkbox["text"] = checkboxTexts;
  checkbox["value"] = checkboxValues;
  checkbox = {
    text: checkbox["text"],
    value: checkbox["value"]
  }

  let field = findInputById(fields.data, id);

  field.input.label.text = formValues.input_label;
  field.input.input.attributes.required = formValues.input_required;
  field.input.input.attributes.id = formValues.input_id;
  field.input.input.attributes.class = formValues.input_class;
  field.input.input.attributes.name = formValues.input_name;
  field.input.input.attributes.placeholder = formValues.input_placeholder;
  field.input.input.attributes.required = formValues.input_required;
  field.input.input.option.option = checkbox;

  $("#modalConfigureCheckbox").modal("hide");
  $("#form-configure-checkbox")[0].reset();
  loadFields();
  $('#ParentCheckboxOption').load(location.href + ' #ParentCheckboxOption');
});

$('#modalConfigureSelect').on('hidden.bs.modal', function () {
  $('#ParentSelectOption').load(location.href + ' #ParentSelectOption');
});

$('#modalConfigureCheckbox').on('hidden.bs.modal', function () {
  $('#ParentCheckboxOption').load(location.href + ' #ParentCheckboxOption');
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
    } else if (field.input.select) {
      loadSelectInputPreview(field, formBuilder)
    } else if(field.input.input.attributes.type == "checkbox") {
      loadCheckboxInputPreview(field, formBuilder)
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

function addNewSelectOption() {
  let selectOption = $("<div>").addClass("select-option col-12 d-flex align-items-center mt-3");
  let row = $("<div>").addClass("row");
  let optionValue = $("<div>").addClass("option-value col-6");
  let inputOptionValue = $("<input>").attr("type", "text");
  inputOptionValue = inputOptionValue.attr("name", "option_value[]");
  inputOptionValue = inputOptionValue.addClass("select_value form-control");
  inputOptionValue = inputOptionValue.attr("id", "select_option_value");
  inputOptionValue = inputOptionValue.attr("placeholder", "Value");
  optionValue.append(inputOptionValue);

  let optionText = $("<div>").addClass("option-text col-6");
  let inputOptionText = $("<input>").attr("type", "text");
  inputOptionText = inputOptionText.attr("name", "option_text[]");
  inputOptionText = inputOptionText.addClass("select_text form-control");
  inputOptionText = inputOptionText.attr("id", "select_option_text");
  inputOptionText = inputOptionText.attr("placeholder", "Text");
  optionText.append(inputOptionText);

  let divDeleteSelectOption = $("<div>").addClass("button ps-2 d-flex");
  let buttonDeleteSelectOption = $("<button>").addClass("btn btn-outline-danger btn-sm").text("X").attr("type", "button");
  divDeleteSelectOption.append(buttonDeleteSelectOption);

  row.append(optionValue);
  row.append(optionText);
  selectOption.append(row);
  selectOption.append(divDeleteSelectOption);

  let newParentSelectOption = $("#ParentSelectOption");
  newParentSelectOption.append(selectOption);


  buttonDeleteSelectOption.on("click", (event) => {
    let deleteNode = event.target.parentNode.parentNode;
    deleteNode.remove();
  })

  return selectOption;
}

function addNewCheckboxOption() {
  let checkboxOption = $("<div>").addClass("checkbox-option col-12 d-flex align-items-center mt-3");
  let row = $("<div>").addClass("row");
  let optionValue = $("<div>").addClass("checkbox-value col-6");
  let checkValue = $("<input>").attr("type", "text");
  checkValue = checkValue.attr("name", "checkbox_value[]");
  checkValue = checkValue.addClass("checkbox_value form-control");
  checkValue = checkValue.attr("placeholder", "Value");
  optionValue.append(checkValue);

  let optionText = $("<div>").addClass("checkbox-text col-6");
  let checkText = $("<input>").attr("type", "text");
  checkText = checkText.attr("name", "checkbox_text[]");
  checkText = checkText.addClass("checkbox_text form-control");
  checkText = checkText.attr("placeholder", "Text");
  optionText.append(checkText);

  let divDeleteSelectOption = $("<div>").addClass("button ps-2 d-flex");
  let buttonDeleteSelectOption = $("<button>").addClass("btn btn-outline-danger btn-sm").text("X").attr("type", "button");
  divDeleteSelectOption.append(buttonDeleteSelectOption);

  row.append(optionValue);
  row.append(optionText);
  checkboxOption.append(row);
  checkboxOption.append(divDeleteSelectOption);

  let newParentSelectOption = $("#ParentCheckboxOption");
  newParentSelectOption.append(checkboxOption);


  buttonDeleteSelectOption.on("click", (event) => {
    let deleteNode = event.target.parentNode.parentNode;
    deleteNode.remove();
  })

  return checkboxOption;
}

$("#addNewSelectOption").on("click", () => {
  addNewSelectOption();
})

$("#addNewCheckboxOption").on("click", () => {
  addNewCheckboxOption();
})

