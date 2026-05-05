<?php 

// Website URL
$site_url =  isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http" . "://" . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/\\'). '/'; //http://www.example.com/

// Webpage URL
$page_url = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http" . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];  //http://www.example.com/about

// Webpage Slug
$page_slug = pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME); // http://www.example.com/about => about

// echo $site_url; 
// echo "<br />";
// echo $page_url; 
// exit;