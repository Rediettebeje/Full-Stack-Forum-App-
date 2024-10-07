"use strict"; 

function clearForm() {
    /*
     * this function replaces the text in text boxes with empty strings
     * and replaces the message area with an html <br>
     */
    $("#title").val("");
    $("#favorite_drink").val("");
    $("#petName").val("");
    $("#fictionalPlace").val("");
    $("#realPlace").val("");
    $("#email").val("");
    /* NOTE: This next line violates the division of concerns rule,
     */
    $("#msg").html("<br>");
}

// Check for a valid email address
function validate() {
    var errorMessage = "";

    // Get the strings from the text boxes and trim them
    var title = $("#title").val().trim();
    var favoriteDrink = $("#favorite_drink").val().trim();
    var petName = $("#petName").val().trim();
    var fictionalPlace = $("#fictionalPlace").val().trim();
    var realPlace = $("#realPlace").val().trim();
    var email = $("#email").val().trim();

    // Put the trimmed versions back into the form for good user experience (UX)
    $("#title").val(title);
    $("#favorite_drink").val(favoriteDrink);
    $("#petName").val(petName);
    $("#fictionalPlace").val(fictionalPlace);
    $("#realPlace").val(realPlace);
    $("#email").val(email);

    // Test the strings from the form and store the error messages
    if (title === "") {
        errorMessage += "Title cannot be empty.<br>";
    }
    if (favoriteDrink === "") {
        errorMessage += "FavoriteDrink cannot be empty.<br>";
    }
    if (petName === "") {
        errorMessage += "PetName cannot be empty.<br>";
    }
    if (fictionalPlace === "") {
        errorMessage += "FictionalPlace cannot be empty.<br>";
    }
    if (realPlace === "") {
        errorMessage += "RealPlace cannot be empty.<br>";
    }
    if (email === "") {
        errorMessage += "Email cannot be empty.<br>";
    } else {
        errorMessage += validateEmail(email);
    }

    // Check if fictional place is the same as real place
    if (fictionalPlace === realPlace) {
        errorMessage += "Fictional place and real place cannot be the same.<br>";
    }   

    // Send the errors back or send an empty string if there is no error
    return errorMessage;
}

$(document).ready(function () {
    // Event handler for the clear button
    $("#clear").click(function () {
        clearForm();
    });

    // Event handler for the send button
    $("#submit").click(function () {
        // Prevent form submission if there is an error
      
        let submit = false;

        // Bring the message area in to report errors or "Sent!"
        var msgArea = $("#msg");
        // Validate form and get back error messages (if any)
        var msg = validate();
        // Report errors or submit the form
        // Returning true or false is what allows the form to submit or not
        if (msg === "") {
            // Allow the form to submit
            submit = true;
            // Here you might want to actually submit the form if necessary
        } else {
            $("#msg").html(msg);
            msgArea[0].scrollIntoView({ behavior: "smooth", block: "center" });
        }
        return submit;
    });
});
