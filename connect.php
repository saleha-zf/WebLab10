<?php 


// Define the database connection parameters
$db_host = "localhost";       // Database host (usually localhost)
$db_user = "root";            // Database username (default is 'root' for local setups)
$db_pass = "";                // Database password (leave empty for local MySQL default setup)
$db_name = "attsystem";     


// Establishing the connection
$connection = mysqli_connect('localhost', 'root', '', 'attsystem');

// Check the connection
if (!$connection) {
    die('Cannot connect to server: ' . mysqli_connect_error());
}
?>

