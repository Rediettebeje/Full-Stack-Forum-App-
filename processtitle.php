<?php

/*
 * processestitle.php file that process user input from a form, and displays the results on new page
 */


//this will load the mustache template library
require_once 'mustache/mustache/src/Mustache/Autoloader.php';
Mustache_Autoloader::register();

// this will create a new mustache template engine
$mustache = new Mustache_Engine;

// Load the header and footer templates

$header = file_get_contents('templates/header.html');
$footer = file_get_contents('templates/footer.html');

// this will be used to send the page title into the page
$header_data = ["pagetitle" => "Home Page"];

//this is being used to send a footer title and local time to the footer
$footer_data = [
    "localtime" => date('l jS \of F Y h:i:s A'),
    "footertitle" => "Home Page"];

/* * *********************************************
 * STEP 1: INPUT: Do NOT process, just get the data.
 * Do not delete this comment,
 * ********************************************** */

 if (!empty($_POST['title']) && !empty($_POST['favorite_drink']) && !empty($_POST['pet_name']) && !empty($_POST['fictional_place']) && !empty($_POST['real_place'])) { 

// extract the data from the global $_POST (if it exists) into local variables.
    $title = $_POST['title'];
    $favorite_drink = $_POST['favorite_drink'];
    $pet_name = $_POST['pet_name'];
    $fictional_place = $_POST['fictional_place'];
    $real_place = $_POST['real_place'];
} else {
    $title = "";
    $favorite_drink = "";
    $pet_name = "";
    $fictional_place = "";
    $real_place = "";
}

/* * ******************************************************
 * STEP 2: VALIDATION: Always clean your input first!!!!
 * Do NOT process, only CLEAN and VALIDATE.
 * Do not delete this comment.
 * ****************************************************** */

// clean up the variables (a little) by removing leading and trailing white space
$title = trim($title);
$favorite_drink = trim($favorite_drink);
$pet_name = trim($pet_name);
$fictional_place = trim($fictional_place);
$real_place = trim($real_place);

// Strip HTML tags from the input
$title = strip_tags($title);
$favorite_drink = strip_tags($favorite_drink);
$pet_name = strip_tags($pet_name);
$fictional_place = strip_tags($fictional_place);
$real_place = strip_tags($real_place);

//limit the input to be max of 64 characters
$title = substr($title, 0, 64);
$favorite_drink = substr($favorite_drink, 0, 64);
$pet_name = substr($pet_name, 0, 64);
$fictional_place = substr($fictional_place, 0, 64);
$real_place = substr($real_place, 0, 64);

if (!empty($title) && !empty($favorite_drink) && !empty($pet_name) && !empty($fictional_place) && !empty($real_place)) {

 /*     * *************************************************************************
     * STEP 3 and 4: PROCESSING and OUTPUT: Notice this code only executes
     * if you have valid data from steps 1 and 2. Your code must always have
     * a saftey feature similar to this.
     * Do not delete this comment.
     * ************************************************************************ */
   
 // Concatenate the parts together to make ONE string
  $whole_title= "$title $favorite_drink $pet_name of $fictional_place and $real_place";

 // Calculate the length of inputs
    $title_length = strlen($title);
    $drink_length = strlen($favorite_drink);
    $pet_length = strlen($pet_name);
    $fictional_place_length = strlen($fictional_place);
    $real_place_length = strlen($real_place);
    $total_length= strlen($whole_title);

    // check the number of whole_title characters
    $title_message = ($total_length>= 30) ? "That's a heck of a title!" : "That's a cute little title.";

    // Load and render success template
    $success = file_get_contents('templates/success.html');

    $data = [
        'whole_title' => htmlspecialchars($whole_title),
        'title' => htmlspecialchars($title),
        'favorite_drink' => htmlspecialchars($favorite_drink),
        'pet_name' => htmlspecialchars($pet_name),
        'fictional_place' => htmlspecialchars($fictional_place),
        'real_place' => htmlspecialchars($real_place),
        'title_length' => $title_length,
        'drink_length' => $drink_length,
        'pet_length' => $pet_length,
        'fictional_place_length' => $fictional_place_length,
        'real_place_length' => $real_place_length,
        'total_length' => $total_length,
        'title_message' => $title_message
    ];

    echo $mustache->render($header, $header_data) . PHP_EOL;
    echo $mustache->render($success, $data) . PHP_EOL;
    echo $mustache->render($footer, $footer_data) . PHP_EOL;
    
} else {
    
    // Load and render error template
    $error = file_get_contents('templates/error.html');

    echo $mustache->render($header, $header_data) . PHP_EOL;
    echo $mustache->render($error). PHP_EOL;
    echo $mustache->render($footer, $footer_data) . PHP_EOL;
    
  
}
?>
