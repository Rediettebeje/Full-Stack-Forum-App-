"use strict";

function clearForm() {
  /*
   * This function replaces the text in text boxes with empty strings
   * and replaces the message area with an html <br>
   */
  $("#name").val("");
  $("#returnEmail").val("");
  $("#reEnterReturnEmail").val("");
  $("#subject").val("");
  $("#message").val("");
  $("#msg").html("<br>");
}

function validate() {
  var errorMessage = "";
//get the strings from the text boxes and trim them
  var name = $("#name").val().trim();
  var returnEmail = $("#returnEmail").val().trim();
  var reEnterReturnEmail = $("#reEnterReturnEmail").val().trim();
  var subject = $("#subject").val().trim();
  var message = $("#message").val().trim();

 //put the trimmed versions back into the form for good iser experience (UX)
  $("#name").val(name);
  $("#returnEmail").val(returnEmail);
  $("#reEnterReturnEmail").val(reEnterReturnEmail);
  $("#subject").val(subject);
  $("#message").val(message);

//test the strings from the form and store the error messages
  if (name === "") {
    errorMessage += "Name cannot be empty.<br>";
  }

  if (returnEmail === "") {
    errorMessage += "Email address cannot be empty.<br>";
  } else {
    errorMessage += validateEmail(returnEmail);
  }

  if (reEnterReturnEmail === "") {
    errorMessage += "Confirm email address cannot be empty.<br>";
  } else {
    errorMessage += validateEmail(reEnterReturnEmail);
  }

  if (returnEmail !== reEnterReturnEmail) {
    errorMessage += "Email fields do not match.<br>";
  }

  if (subject === "") {
    errorMessage += "Subject cannot be empty.<br>";
  }

  if (message === "") {
    errorMessage += "Message cannot be empty.<br>";
  }

//send the errors back or send an empty string if there is no error
  return errorMessage;
}

/*
 * This is the jQuery docready method. It automatically executes when the DOM
 * is ready. You should always put handlers and other auto-executed code in
 * a docready function. It protects you from "race-conditions" when the JS
 * tries to execute before the DOM is complete.
 */

$(document).ready(function () {
  // Event handler for the clear button
  $("#clear").click(function () {
    clearForm();
  });


    // event handler for the send button
  $("#send").click(function () {
    // will prevent the form from submitting if there is an error
      let submit = false;
      
    //bring the message area in to report errors or "Sent!"
    var msgArea = $("#msg");
    // validate form and get back error messages (if any)
    var msg = validate();
    // report errors or submit the form
    // returning true or false is what allows the form to submit or not
    if (msg === "") {
      // will allow the form to submit
      submit = true;
    } else {
        $("#msg").html(msg);
        msgArea[0].scrollIntoView({ behavior: "smooth", block: "center" });
    }
    return submit;
  });
});
