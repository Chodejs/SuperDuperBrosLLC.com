<?php
// db_connect.php

// Turn on error reporting for mysqli to throw exceptions on errors
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// --- IMPORTANT ---
// Please create a new database named 'superduperbrosllc' in your local MySQL setup (e.g., phpMyAdmin).
// Then, update the credentials below to match your local environment.

$db_host = "localhost";         // Usually "localhost" or "127.0.0.1"
$db_user = "root";              // Your local MySQL username
$db_pass = "mysql";             // Your local MySQL password
$db_name = "superduperbrosllc";      // The new database for this project

try {
    // Attempt to create a new mysqli connection
    $db = new mysqli($db_host, $db_user, $db_pass, $db_name);
    
    // Set the character set for the connection
    $db->set_charset("utf8mb4");

} catch (mysqli_sql_exception $e) {
    // Log the error for debugging, but don't show sensitive details to the public.
    error_log("Database Connection Error: " . $e->getMessage());
    
    // Display a generic, user-friendly error message.
    // On a live site, you might just show a "service unavailable" page.
    die("<h2>Database Connection Failed!</h2>
         <p>We're sorry, but we couldn't connect to the database. Please check the settings in `db_connect.php` and ensure your MySQL server is running and the database '<strong>" . htmlspecialchars($db_name) . "</strong>' exists.</p>
         <p><strong>Error for developer:</strong> " . htmlspecialchars($e->getMessage()) . "</p>");
}

// The $db object is now available for use in any script that includes this file.
?>
