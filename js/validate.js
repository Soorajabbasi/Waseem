$(document).ready(function() {
jQuery.validator.addMethod("lettersonly", function(value, element) 
{
  return this.optional(element) || /^[a-z ]+$/i.test(value);
}, "Letters and spaces only please");

jQuery.validator.addMethod("cell", function (value, element) {
    value = value.replace(/\s+/g, "");
    return this.optional(element) || value.length > 9 && value.match(/^[0][3,7][0-9]*$/);
    }, "Invalid Phone Number, Write in following Pattern 03XXXXXXXXX");

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
$("#signup-form").validate({
    rules: {
        firstname:{
          required:true,
          lettersonly:true,
          minlength:4,
          maxlength:60
        },
        lastname:{
          required:true,
          lettersonly:true,
          minlength:4,
          maxlength:60
        },
        phonenumber:{
          minlength:11,
          maxlength:11,
          cell:true,
          required:true,
        },
        email: {
          required: true,
          email: true
        },
        password:{
          required:true
        }
      }
});
$("#review_from").validate({
  rules:{
    name:{
        required:true,
        lettersonly:true,
        minlength:4,
        maxlength:60
    },
    email:{
      email:true,
      required:true
    },
    review_des:{
      required:true,
      minlength:100,
      maxlength:1000
    }
  },
  messages:{
    name:{
      required:"*"
    },
    email:{
      email:"Please Insert Vaild Email Address",
      required:"*"
    }
  }
});
});