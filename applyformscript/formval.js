(function () {
  "use strict";

  // Get studentAge from the hidden input
  var studentAge = document.getElementById('studentCourse').value;

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

const activeFormTab = document.getElementsByClassName("form_tab_active")[0];

const formTab = document.getElementsByClassName("form_tab");
// var inputTag = activeFormTab.querySelectorAll('input')
const nextBtns1 = document.querySelector(".nextButton1");
const nextBtns2 = document.querySelector(".nextButton2");
const nextBtns3 = document.querySelector(".nextButton3");
const nextBtns4 = document.querySelector(".nextButton4");

const priviousbtn1 = document.querySelector(".priviousbtn1");
const priviousbtn2 = document.querySelector(".priviousbtn2");
const priviousbtn3 = document.querySelector(".priviousbtn3");
const priviousbtn4 = document.querySelector(".priviousbtn4");

var formInputs = activeFormTab.getElementsByClassName("needVal");
for (let i = 0; i < formTab.length; i++) {
  // button1
  nextBtns1.addEventListener("click", () => {
    if (!document.getElementById("FirstName").checkValidity()) {
      formTab[0].classList.add("was-validated");
    } else if (!document.getElementById("SurName").checkValidity()) {
      formTab[0].classList.add("was-validated");
    } else if (document.getElementById("dateOfBirth").value == "") {
      formTab[0].classList.add("was-validated");
    } else {
      formTab[0].classList.remove("form_tab_active");
      formTab[0].classList.remove("prevform_tab_active");
      formTab[1].classList.add("form_tab_active");
    }
  });

  // button2
  nextBtns2.addEventListener("click", () => {
    var phNo = document.getElementById("phoneNumber");

    if (!document.getElementById("parentFirstName").checkValidity()) {
      formTab[1].classList.add("was-validated");
    } else if (!document.getElementById("parentSurName").checkValidity()) {
      formTab[1].classList.add("was-validated");
    } else if (!document.getElementById("parentAdderss").checkValidity()) {
      formTab[1].classList.add("was-validated");
    } else if (!document.getElementById("email").checkValidity()) {
      formTab[1].classList.add("was-validated");
    } else if (!phNo.checkValidity()) {
      formTab[1].classList.add("was-validated");
    } else {
      formTab[1].classList.remove("form_tab_active");
      formTab[1].classList.remove("prevform_tab_active");
      formTab[2].classList.add("form_tab_active");
    }
  });

  //button3
  nextBtns3.addEventListener("click", () => {
    if (document.getElementById("termsAndCondition1").checked == false) {
      formTab[2].classList.add("was-validated");
    } else if (document.getElementById("termsAndCondition2").checked == false) {
      formTab[2].classList.add("was-validated");
    } else if (document.getElementById("termsAndCondition3").checked == false) {
      formTab[2].classList.add("was-validated");
    } else if (document.getElementById("termsAndCondition4").checked == false) {
      formTab[2].classList.add("was-validated");
    } else if (document.getElementById("termsAndCondition5").checked == false) {
      formTab[2].classList.add("was-validated");
    } else if (document.getElementById("termsAndCondition6").checked == false) {
      formTab[2].classList.add("was-validated");
    } else {
      formTab[2].classList.remove("form_tab_active");
      formTab[2].classList.remove("prevform_tab_active");
      formTab[3].classList.add("form_tab_active");
    }
  });

  // button4
  nextBtns4.addEventListener("click", () => {
    if (document.getElementById("termsAndCondition7").checked == false) {
      formTab[3].classList.add("was-validated");
    } else if (document.getElementById("termsAndCondition8").checked == false) {
      formTab[3].classList.add("was-validated");
    } else if (document.getElementById("termsAndCondition9").checked == false) {
      formTab[3].classList.add("was-validated");
    } else {
      formTab[3].classList.remove("form_tab_active");
      formTab[3].classList.remove("prevform_tab_active");
      formTab[4].classList.add("form_tab_active");
    }
  });

  // privious btn/
  priviousbtn1.addEventListener("click", () => {
    formTab[1].classList.remove("form_tab_active");
    formTab[1].classList.remove("prevform_tab_active");
    formTab[0].classList.add("prevform_tab_active");
  });

  priviousbtn2.addEventListener("click", () => {
    formTab[2].classList.remove("form_tab_active");
    formTab[2].classList.remove("prevform_tab_active");
    formTab[1].classList.add("prevform_tab_active");
  });

  priviousbtn3.addEventListener("click", () => {
    formTab[3].classList.remove("form_tab_active");
    formTab[3].classList.remove("prevform_tab_active");
    formTab[2].classList.add("prevform_tab_active");
  });

  priviousbtn4.addEventListener("click", () => {
    formTab[4].classList.remove("form_tab_active");
    formTab[4].classList.remove("prevform_tab_active");
    formTab[3].classList.add("prevform_tab_active");
  });
}
