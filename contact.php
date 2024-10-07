<?php
/*
 * contact.php file that renders the form page content
 */

//this will load the mustache template library
require_once 'mustache/mustache/src/Mustache/Autoloader.php';
Mustache_Autoloader::register();

// this will create a new mustache template engine
$mustache = new Mustache_Engine;

// these lines load your header, footer, and form template into strings
$header = file_get_contents('templates/header.html');
$form = file_get_contents('templates/contact.html');
$footer = file_get_contents('templates/footer.html');

// No dynamic data needed for the form
$data = [];

// this will be used to send the page title into the page
$header_data = ["pagetitle" => "Contact page"];

//this is being used to send a footer title and local time to the footer
$footer_data = [
    "localtime" => date('l jS \of F Y h:i:s A'),
    "footertitle" => "Contact page"];

//this combines the variables with the templates and creates a complete web page.   
echo $mustache->render($header, $header_data) . PHP_EOL;
echo $mustache->render($form, $data) . PHP_EOL;
echo $mustache->render($footer, $footer_data) . PHP_EOL;
