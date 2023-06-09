/**
 *  Modal Example Wizard
 */

'use strict';

$(function () {
  // Modal id
  const appModal = document.getElementById('createApp');

  // Credit Card
  const creditCardMask1 = document.querySelector('.app-credit-card-mask'),
    expiryDateMask1 = document.querySelector('.app-expiry-date-mask'),
    cvvMask1 = document.querySelector('.app-cvv-code-mask');
  let cleave;

  // Cleave JS card Mask
  function initCleave() {
    if (creditCardMask1) {
      cleave = new Cleave(creditCardMask1, {
        creditCard: true,
        onCreditCardTypeChanged: function (type) {
          if (type != '' && type != 'unknown') {
            document.querySelector('.app-card-type').innerHTML =
              '<img src="' + assetsPath + 'img/icons/payments/' + type + '-cc.png" class="cc-icon-image" height="28"/>';
          } else {
            document.querySelector('.app-card-type').innerHTML = '';
          }
        }
      });
    }
  }

  // Expiry Date Mask
  if (expiryDateMask1) {
    new Cleave(expiryDateMask1, {
      date: true,
      delimiter: '/',
      datePattern: ['m', 'y']
    });
  }

  // CVV
  if (cvvMask1) {
    new Cleave(cvvMask1, {
      numeral: true,
      numeralPositiveOnly: true
    });
  }
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
            initCleave();
          });
        });
      }
      if (wizardCreateAppPrevList) {
        wizardCreateAppPrevList.forEach(wizardCreateAppPrev => {
          wizardCreateAppPrev.addEventListener('click', event => {
            createAppStepper.previous();
            initCleave();
          });
        });
      }

      if (wizardCreateAppBtnSubmit) {
        wizardCreateAppBtnSubmit.addEventListener('click', event => {
          let GetApproverRoles = $(event.target.parentNode.parentNode.parentNode.parentNode).serializeArray();
          GetApproverRoles = GetApproverRoles.filter(f => f.name == "approver_roles");
          console.log(GetApproverRoles);
        });
      }
    }
  });

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
      description: {
        validators: {
          notEmpty: {
            message: 'this is required'
          },
        }
      },
      initiation_role: {
        validators: {
          notEmpty: {
            message: 'this is required'
          },
        }
      },
      worker_role: {
        validators: {
          notEmpty: {
            message: 'this is required'
          },
        }
      },
      approver_roles: {
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
          return '.form-input';
        }
      }),
      submitButton: new FormValidation.plugins.SubmitButton(),
      // Submit the form when all fields are valid
      defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
      autoFocus: new FormValidation.plugins.AutoFocus()
    }
  })
});


