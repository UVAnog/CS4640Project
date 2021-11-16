<?php
include('./database_connection.php');
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Extra Error Printing
$mysqli = new mysqli($dbserver, $dbuser, $dbpass, $dbdatabase);


$title=$_GET['title'] ? $_GET['title'] : $_POST['title'];
if ($_GET['note']) {
    // delete note
    $note = $_GET['note'];
    mysqli_query($mysqli, "DELETE FROM note WHERE book_title='$title' AND text='$note'");
    header("Location: notes.php");
  } else {
      // delete book
    mysqli_query($mysqli, "DELETE FROM book WHERE title='$title'");
    header("Location: books.php");
  }
exit();
?>