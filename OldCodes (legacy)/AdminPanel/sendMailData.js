$(document).ready(() => {
  $(document).on("click", "#pendingStuMsg", function () {
    var arr = [];
    $("#trBody").each(function () {
      $(this)
        .find("tr")
        .each(function () {
          var ids = $(this).find(".viewDatatBtn").attr("value");
          arr.push(ids);
        });
    });
    $(document).on("submit", "#send", function (e) {
      $(".uploadBtn").prop("disabled", true);
      $(".uploadBtn img").removeClass("d-none");
      var emailTitle = $("#mailHeading").val();
      var emailtxt = $("#email_text").val();
      var action = "email_note";
      e.preventDefault();
      $.ajax({
        type: "POST",
        url: "Exit-studentsCode.php",
        data: {
          id: arr,
          requestAction: action,
          emailTitle: emailTitle,
          emailbody: emailtxt,
        },
        success: function (response) {
          if (response) {
            $("#mailSentModal").modal("hide");
            $("#email_sub").val("");
            $("#mailHeading").val("");
            $("#email_text").val("");
            $(".uploadBtn").prop("disabled", false);
            $(".uploadBtn img").addClass("d-none");
            alertify.set("notifier", "position", "top-right");
            alertify.success("Mail Sended Successfully..!");
          } else {
            $(".uploadBtn").prop("disabled", false);
            $(".uploadBtn img").addClass("d-none");
            alertify.set("notifier", "position", "top-right");
            alertify.error("Somthing Went to wrong...!");
          }
        },
      });
    });
  });
});
