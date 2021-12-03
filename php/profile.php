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
    "email" => $_SESSION["email"],
    "books" => array()
    ];

    // get books associated with current user
    // rewrite using $_GET
    $stmt = $mysqli->prepare("select * from book where user_email = ?;");
    $stmt->bind_param("s", $user["email"]);
    if (!$stmt->execute()) {
        $error_msg = "Error checking for user";
    } else { 
        // result succeeded
        $res = $stmt->get_result();
        $data = $res->fetch_all(MYSQLI_ASSOC);
        
        if (!empty($data)) { //(isset($data[0])) {
          $json = json_encode($data, JSON_PRETTY_PRINT);
          $user["books"] = json_decode($json, true);
        } else {
          $error_msg = "Error: no books in library";
        }
      }
?>

<!DOCTYPE html>
<style>
  .outer-div {
    display: flex;
    justify-content: center;
    align-items: center;
    
  }

</style>
<html>
    <head>
        <meta charset="UTF-8">  
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="Nolan Harris, Yaseen Bhuiyan">
        <meta name="description" content="Search and save books">  
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> 
        <title>myBrary</title>
        <link rel="stylesheet" href="../styles/main.css" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous"> 
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
        <script type="text/javascript">
          
        </script>
    
     </head>

    <body onload="onLoad()">
      <div>
      <nav
        class="navbar navbar-light navbar-expand-lg sticky-top"
        style="background-color: #e3f2fd"
        aria-label="Main Navigation
        Bar">
        <div class="container-xl">
          <a class="navbar-brand" href="home.php"><div><img
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
                <a class="nav-link" aria-current="page"
                  href="home.php">Home</a>
              </li>
              <li class="nav-item hover-item">
                <a class="nav-link active" aria-current="page" href="books.php">Saved
                  Books</a>
              </li>
              <li class="nav-item hover-item">
                <a class="nav-link" href="notes.php">Saved Notes</a>
              </li>
              <li class="nav-item hover-item">
                <a class="nav-link" href="profile.php">Profile</a>
              </li>
            </ul>

            <li class="nav-item dropdown" style="list-style-type: none">
            <p> User: <?=$user["email"]?> </p>               
            <div class="" aria-labelledby="navbarDropdown">
              <div>
                <button class="btn btn-primary"><a style="color: white;
                    text-decoration: none" href="index.php">Sign Out</a></button>
              </div>
            </div>
            </li>

          </div>
        </div>
      </nav>
      </div>
      <div class="outer-div">
        <div>
          <h3>Current Profile: <?=$user["email"]?></h3>        
      </div>
    
    </div>
    <div class="outer-div">
        <div>
          <button class="btn btn-primary"><a style="color: white;
                    text-decoration: none" href='../angular/dist/angular'>Edit Profile</a></button>     
      </div>

        <script
          src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css"
          rel="stylesheet"
          integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU"
          crossorigin="anonymous" 
          async 
          defer>
        </script>

    </body>
</html>