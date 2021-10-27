<?php
/** DATABASE SETUP **/
include('./database_connection.php');
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Extra Error Printing
$mysqli = new mysqli($dbserver, $dbuser, $dbpass, $dbdatabase);
$user = null;

// Join session or start one
session_start();

// If the user's email is not set in the session, then it's not
// a valid session (they didn't get here from the login page),
// so we should send them over to log in first before doing
// anything else!
if (!isset($_SESSION["email"])) {
    header("Location: index.php");
    exit();
}

// set user information for the page
$user = [
  "email" => $_SESSION["email"]
  ];
$user_email = $_SESSION["email"];


if (isset($_POST["title"])) { // validate the title coming in
  $stmt = $mysqli->prepare("select * from book where user_email = ?;");
  $stmt->bind_param("s", $user["email"]);
  if (!$stmt->execute()) {
      $error_msg = "Error checking for user";
  } else { 
      // result succeeded
      $res = $stmt->get_result();
      $data = $res->fetch_all(MYSQLI_ASSOC);
      
      if (!empty($data)) { //(isset($data[0])) {
          // user was found!
          
          // validate the user's title

          
            $stmt = $mysqli->prepare("select * from book where title = ?;");
            $stmt->bind_param("s", $_POST["title"]);
            if (!$stmt->execute()) {
                $error_msg = "Error checking for title";
            } else { 
                // result succeeded
                $res = $stmt->get_result();
                $data = $res->fetch_all(MYSQLI_ASSOC);
                
                if (!empty($data)) { //(isset($data[0])) {
                  $error_msg = "Book already exists in user library";
                }
              }


          
      } else {
          // book was not found, create the book
         
          
          
          $insert = $mysqli->prepare("insert into book (title, author, user_email) values (?, ?, ?);");
          $insert->bind_param("sss", $_POST["title"], $_POST["author"], $user["email"]);
          if (!$insert->execute()) {
              $error_msg = "Error creating new book";
          } 
          
          // Save user information into the session to use later
          
          header("Location: books.php");
          exit();
      }
  }
}
?>




<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">  
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="Nolan Harris, Yaseen Bhuiyan">
        <meta name="description" content="Search and save books and create notes">  
        <title>myBrary</title>
        <link rel="stylesheet" href="../styles/main.css" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous"> 
    </head>

    <body>
    <div>
      <nav
        class="navbar navbar-light navbar-expand-lg sticky-top"
        style="background-color: #e3f2fd"
        aria-label="Main Navigation
        Bar">
        <div class="container-xl">
          <a class="navbar-brand" href="landing.php"><div><img
                src="../assets/logo.svg" /></div></a>
          <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarsTop"
            aria-controls="navbarsTop"
            aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarsTop">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item hover-item">
                <a class="nav-link active" aria-current="page"
                  href="landing.php">Home</a>
              </li>
              <li class="nav-item hover-item">
                <a class="nav-link" aria-current="page" href="books.php">Saved
                  Books</a>
              </li>
              <li class="nav-item hover-item">
                <a class="nav-link" href="notes.php">Saved Notes</a>
              </li>
            </ul>

            <div class="" aria-labelledby="navbarDropdown">
              <div>
              <p> User: <?=$user["email"]?> </p>
                <button class="btn btn-primary"><a style="color: white;
                    text-decoration: none" href="index.php">Sign Out</a></button>
              </div>
            </div>

          </div>
        </div>
      </nav>
    </div>
    <div class="container">
    <div class="container" style="margin-top: 15px;">
            <div class="row col-xs-8">
                
                <p> Enter Book Title and Author: </p>
            </div>
            <div class="row justify-content-center">
                <div class="col-4">
                <?php
                    if (!empty($error_msg)) {
                        echo "<div class='alert alert-danger'>$error_msg</div>";
                    }
                ?>
                <form action="landing.php" method="post">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="title" class="form-control" id="title" name="title"/>
                    </div>
                    <div class="mb-3">
                        <label for="author" class="form-label">Author</label>
                        <input type="author" class="form-control" id="author" name="author"/>
                    </div>
                    <div class="text-center">
                    <button type="submit" class="btn btn-primary">Add New Book</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU"
      crossorigin="anonymous" async defer>
        </script>
  </body>
</html>