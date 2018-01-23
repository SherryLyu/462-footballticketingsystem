$(function() {
  $("#registerForm input").jqBootstrapValidation({
    preventSubmit: true,
    submitError: function($form, event, errors) {
      // additional error messages or events
    },
    submitSuccess: function($form, event) {
      event.preventDefault(); // prevent default submit behaviour
      // get values from FORM
      var firstname = $("input#firstnameregis").val();
      var lastname = $("input#lastnameregis").val();
      var email = $("input#emailregis").val();
      var username = $("input#usernameregis").val();
      var password = $("input#passwordregis").val();
      var result = $('input#usertypeinput').is(':checked');
      if(result == true) var usertype = 1;
      else var usertype = 2;    

      $this = $("#sendRegisterButton");
      $this.prop("disabled", true); // Disable submit button until AJAX call is complete to prevent duplicate messages
      $.ajax({
        url: "././specialphp/registerCheck.php",
        type: "POST",
        data: {
          firstname: firstname,
          lastname: lastname,
          email: email,
          username: username,
          password: password,
          usertype: usertype
        },
        cache: false,
        success: function(data) {
          if(data.status == 'success'){
            $('#successRegister').html("<div class='alert alert-success'>");
            $('#successRegister > .alert-success').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
              .append("</button>");
            $('#successRegister > .alert-success')
              .append("<strong>Successfully registered. Please login on the right side. </strong>");
            $('#successRegister > .alert-success')
              .append('</div>');  
            //clear all fields
            $('#registerForm').trigger("reset");
          }else if(data.status == 'error'){
            // Fail register
            $('#successRegister').html("<div class='alert alert-danger'>");
            $('#successRegister > .alert-danger').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
              .append("</button>");
            $('#successRegister > .alert-danger').append($("<strong>").text(data.message));
            $('#successRegister > .alert-danger').append('</div>');
          }
        },
        error: function() {
          // Fail register
          $('#successRegister').html("<div class='alert alert-danger'>");
          $('#successRegister > .alert-danger').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
            .append("</button>");
          $('#successRegister > .alert-danger').append($("<strong>").text("Sorry. Something wrong! Try again!"));
          $('#successRegister > .alert-danger').append('</div>');
          //clear all fields
          $('#registerForm').trigger("reset");
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
$('#firstname').focus(function() {
  $('#successRegister').html('');
});
