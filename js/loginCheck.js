$(function() {
  $("#loginForm input").jqBootstrapValidation({
    preventSubmit: true,
    submitError: function($form, event, errors) {
      // additional error messages or events
    },
    submitSuccess: function($form, event) {
      event.preventDefault(); // prevent default submit behaviour
      // get values from FORM
      var email = $("input#emaillogin").val();
      var password = $("input#passwordlogin").val();

      $this = $("#sendLoginButton");
      $this.prop("disabled", true); // Disable submit button until AJAX call is complete to prevent duplicate messages
      $.ajax({
        url: "./loginProcess.php",
        type: "POST",
        data: {
          email: email,
          password: password
        },
        cache: false,
        success: function(data) {
          if(data.status == 'success'){
            window.location.href = data.message;
          }
          if(data.status == 'error'){
            // Fail login
            $('#Loginoutput').html("<div class='alert alert-danger'>");
            $('#Loginoutput > .alert-danger').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
              .append("</button>");
            $('#Loginoutput > .alert-danger').append($("<strong>").text(data.message));
            $('#Loginoutput > .alert-danger').append('</div>');
            //clear all fields
            $('#loginForm').trigger("reset");
          }
        },
        error: function() {
          // Fail login
          $('#Loginoutput').html("<div class='alert alert-danger'>");
          $('#Loginoutput > .alert-danger').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
            .append("</button>");
          $('#Loginoutput > .alert-danger').append($("<strong>").text("Sorry. Something wrong! Try again!"));
          $('#Loginoutput > .alert-danger').append('</div>');
          //clear all fields
          $('#loginForm').trigger("reset");
        },
        complete: function() {
          setTimeout(function() {
            $this.prop("disabled", false); // Re-enable submit button when AJAX call is complete
          }, 1000);
        }
      });
    },
    filter: function() {
      return $(this).is(":visible");
    },
  });

  $("a[data-toggle=\"tab\"]").click(function(e) {
    e.preventDefault();
    $(this).tab("show");
  });
});

/*When clicking on Full hide fail/success boxes */
$('#email').focus(function() {
  $('#Loginoutput').html('');
});
