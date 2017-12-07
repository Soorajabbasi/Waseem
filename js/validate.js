$(document).ready(function() {
$("#login-form").validate({
    rules: {
        email: {
          required: true,
          email: true
        },
        password: {
            required: true,
            minlength:8,
            maxlength:64,
            nowhitespace:true
          }
      },
      messages: {
        email: {
          required: "This feild is required",
          email: "Enter a valid email address"
        },
        password: {
            required: "This feild is required",
            
          }
      }
});
$("#forgot-form").validate({
    rules: {
        email: {
          required: true,
          email: true
        }
      },
      messages: {
        email: {
          required: "This feild is required",
          email: "Enter a valid email address"
        }
      }
});
});