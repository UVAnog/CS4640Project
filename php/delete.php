<?php
include('./database_connection.php');
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Extra Error Printing
$mysqli = new mysqli($dbserver, $dbuser, $dbpass, $dbdatabase);



$title=$_POST['title'];
mysqli_query($mysqli, "DELETE FROM book WHERE title=$title");
header("Location: books.php");
    exit();
?>