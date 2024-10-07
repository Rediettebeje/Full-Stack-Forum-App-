<?php

/*
 * email.php file that process user input from a contact form, and displays the results on new page
 */



// Load the Mustache template library
require_once 'mustache/mustache/src/Mustache/Autoloader.php'; 
Mustache_Autoloader::register();

// Create a new Mustache template engine
$mustache = new Mustache_Engine;

// Load the header and footer templates
$header = file_exists('templates/header.html') ? file_get_contents('templates/header.html') : '';
$footer = file_exists('templates/footer.html') ? file_get_contents('templates/footer.html') : '';

// Data to send into the header and footer
$header_data = ["pagetitle" => "Home Page"];
$footer_data = [
    "localtime" => date('l jS \of F Y h:i:s A'),
    "footertitle" => "Home Page"
];

function successpage($mustache, $header, $header_data, $footer, $footer_data) {
    // Load and render success template
    $successpage = file_exists('templates/success_email.html') ? file_get_contents('templates/success_email.html') : '';

    echo $mustache->render($header, $header_data) . PHP_EOL;
    echo $mustache->render($successpage, []) . PHP_EOL; // If no data is needed, you can pass an empty array
    echo $mustache->render($footer, $footer_data) . PHP_EOL;
}

function failurepage($mustache, $header, $header_data, $footer, $footer_data) {
    // Load and render error template
    $failurepage = file_exists('templates/error_email.html') ? file_get_contents('templates/error_email.html') : '';

    echo $mustache->render($header, $header_data) . PHP_EOL;
    echo $mustache->render($failurepage, []) . PHP_EOL; // If no data is needed, you can pass an empty array
    echo $mustache->render($footer, $footer_data) . PHP_EOL;
}



function main() {

    // Load Mustache engine, templates, and data locally
    $mustache = new Mustache_Engine;
    $header = file_exists('templates/header.html') ? file_get_contents('templates/header.html') : '';
    $footer = file_exists('templates/footer.html') ? file_get_contents('templates/footer.html') : '';
    $header_data = ["pagetitle" => "Home Page"];
    $footer_data = [
        "localtime" => date('l jS \of F Y h:i:s A'),
        "footertitle" => "Home Page"
    ];

    /* This will test to make sure we have a non-empty $_POST from
     * the form submission. */
    if (!empty($_POST)) {
          
        // clean up the variables (a little) by removing leading and trailing white space
         $name = trim($_POST['name']);
         $subject = trim($_POST['subject']);
         $message = trim($_POST['message']);
      
        // Strip HTML tags from the input
         $name = strip_tags($name);
         $subject = strip_tags($subject);
         $message = strip_tags($message);
        
         //limit the input to be max of 64 characters
         $name = substr($name, 0, 64);
         $subject = substr($subject, 0, 64);
         $message = substr($message, 0, 1000);
         $from = filter_var($_POST['from'], FILTER_VALIDATE_EMAIL);

        /* The cleaning routines above may leave any variable empty. If we
         * find an empty variable, we stop processing because that means
         * someone tried to send us something malicious and/or incorrect. */
        if (!empty($name) && !empty($from) && !empty($subject) && !empty($message)) {

            /* this forms the correct email headers to send an email */
            $to = "rediettebeje@gmail.com"; 
            $headers = "From: $from\r\n";
            $headers .= "Reply-To: $from\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";

              
            /* Now attempt to send the email. This uses a REAL email function
             * and will send an email. Make sure you only sned it to yourself.
             * server, you would use just "mail" instead of "mymail" and
             * it will be sent normally. Read about the PHP mail() function
             * https://www.php.net/manual/en/function.mail.php
             * then it's up to you to fill out the paramters correctly.
             */
            if (mail($to, $subject, $message, $headers)) {
                successpage($mustache, $header, $header_data, $footer, $footer_data);
            } else {
                failurepage($mustache, $header, $header_data, $footer, $footer_data);
            }
        } else {
            failurepage($mustache, $header, $header_data, $footer, $footer_data);
        }
    } else {
        failurepage($mustache, $header, $header_data, $footer, $footer_data);
    }
}

// this kicks off the script
main();
