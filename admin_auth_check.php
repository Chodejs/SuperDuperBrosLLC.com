<?php
session_start();

// Check if the user is logged in.
// If they are not, redirect them to the login page.
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    // exit() is important to stop the script from continuing to execute on the protected page.
    exit;
}
?>
