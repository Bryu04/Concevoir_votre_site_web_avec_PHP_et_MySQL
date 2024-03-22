<?php

session_start();

require_once(__DIR__ . '/functions.php');

// Rupture de la connexion
// unset($_COOKIE['LOGGED_USER']);
// setcookie('LOGGED_USER','',time() - 3600, '/');

session_unset();
session_destroy();

redirectToUrl('index.php');

?>