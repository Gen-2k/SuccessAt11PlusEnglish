(function () {
  "use strict";

  var forms = document.querySelectorAll(".needs-validation");

  Array.prototype.slice.call(forms).forEach(function (form) {
    form.addEventListener(
      "submit",
      function (event) {
        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add("was-validated");
      },
      false
    );
  });
})();

// Wait for DOM to be ready
document.addEventListener('DOMContentLoaded', function() {
  // Form navigation functionality
  const formTab = document.getElementsByClassName("form_tab");
  const nextBtns1 = document.querySelector(".nextButton1");
  const nextBtns2 = document.querySelector(".nextButton2");
  const nextBtns3 = document.querySelector(".nextButton3");
  const nextBtns4 = document.querySelector(".nextButton4");

  const priviousbtn1 = document.querySelector(".priviousbtn1");
  const priviousbtn2 = document.querySelector(".priviousbtn2");
  const priviousbtn3 = document.querySelector(".priviousbtn3");
  const priviousbtn4 = document.querySelector(".priviousbtn4");

  // Validation helper function
  function validateTabFields(tabIndex, fieldIds) {
    let isValid = true;
    
    fieldIds.forEach(id => {
      const field = document.getElementById(id);
      if (field && !field.checkValidity()) {
        isValid = false;
      } else if (!field) {
        console.warn(`Field with id '${id}' not found`);
        isValid = false;
      }
    });
    
    if (!isValid) {
      formTab[tabIndex].classList.add("was-validated");
    }
    
    return isValid;
  }

  // Next button 1 - Student Details
  if (nextBtns1) {
    nextBtns1.addEventListener("click", () => {
      const fieldsToValidate = ["FirstName", "SurName", "dateOfBirth"];
      
      if (validateTabFields(0, fieldsToValidate)) {
        formTab[0].classList.remove("form_tab_active", "prevform_tab_active");
        formTab[1].classList.add("form_tab_active");
      }
    });
  }

  // Next button 2 - Parent Details
  if (nextBtns2) {
    nextBtns2.addEventListener("click", () => {
      const fieldsToValidate = ["parentFirstName", "parentSurName", "parentAddress", "email", "phoneNumber"];
      
      if (validateTabFields(1, fieldsToValidate)) {
        formTab[1].classList.remove("form_tab_active", "prevform_tab_active");
        formTab[2].classList.add("form_tab_active");
      }
    });
  }

  // Next button 3 - Terms and Conditions 1
  if (nextBtns3) {
    nextBtns3.addEventListener("click", () => {
      const checkboxIds = ["termsAndCondition1", "termsAndCondition2", "termsAndCondition3", "termsAndCondition4", "termsAndCondition5"];
      let allChecked = true;
      
      checkboxIds.forEach(id => {
        const checkbox = document.getElementById(id);
        if (!checkbox || !checkbox.checked) {
          allChecked = false;
        }
      });
      
      if (!allChecked) {
        formTab[2].classList.add("was-validated");
      } else {
        formTab[2].classList.remove("form_tab_active", "prevform_tab_active");
        formTab[3].classList.add("form_tab_active");
      }
    });
  }

  // Next button 4 - Terms and Conditions 2
  if (nextBtns4) {
    nextBtns4.addEventListener("click", () => {
      const checkboxIds = ["termsAndCondition6", "termsAndCondition7", "termsAndCondition8", "termsAndCondition9"];
      let allChecked = true;
      
      checkboxIds.forEach(id => {
        const checkbox = document.getElementById(id);
        if (!checkbox || !checkbox.checked) {
          allChecked = false;
        }
      });
      
      if (!allChecked) {
        formTab[3].classList.add("was-validated");
      } else {
        formTab[3].classList.remove("form_tab_active", "prevform_tab_active");
        formTab[4].classList.add("form_tab_active");
      }
    });
  }

  // Previous button navigation
  if (priviousbtn1) {
    priviousbtn1.addEventListener("click", () => {
      formTab[1].classList.remove("form_tab_active", "prevform_tab_active");
      formTab[0].classList.add("prevform_tab_active");
    });
  }

  if (priviousbtn2) {
    priviousbtn2.addEventListener("click", () => {
      formTab[2].classList.remove("form_tab_active", "prevform_tab_active");
      formTab[1].classList.add("prevform_tab_active");
    });
  }

  if (priviousbtn3) {
    priviousbtn3.addEventListener("click", () => {
      formTab[3].classList.remove("form_tab_active", "prevform_tab_active");
      formTab[2].classList.add("prevform_tab_active");
    });
  }

  if (priviousbtn4) {
    priviousbtn4.addEventListener("click", () => {
      formTab[4].classList.remove("form_tab_active", "prevform_tab_active");
      formTab[3].classList.add("prevform_tab_active");
    });
  }
});
