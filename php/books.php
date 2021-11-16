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
<html>
    <head>
        <meta charset="UTF-8">  
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="Nolan Harris, Yaseen Bhuiyan">
        <meta name="description" content="Search and save books">  
        <title>myBrary</title>
        <link rel="stylesheet" href="../styles/main.css" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous"> 
    
        <script type="text/javascript">
          var books = <?php echo json_encode($user["books"]); ?>;

          function displayBooks() {
            var table = document.getElementById("book-table");

            books.forEach((book) => {
              var newRow = table.insertRow(table.rows.length);
              newRow.insertCell(0).textContent = book.title;
              newRow.insertCell(1).textContent = book.author;
              newRow.insertCell(2).innerHTML =
                `<button class="btn btn-sm btn-danger" onclick="location.href='delete.php?title=${book.title}'";>Delete</button>`; //NEED TO ADD DELETE FUNCTION
            });
          }
        </script>
    
     </head>

    <body onload="displayBooks()">
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
                <a class="nav-link active" aria-current="page"
                  href="home.php">Home</a>
              </li>
              <li class="nav-item hover-item">
                <a class="nav-link" aria-current="page" href="books.php">Saved
                  Books</a>
              </li>
              <li class="nav-item hover-item">
                <a class="nav-link" href="notes.php">Saved Notes</a>
              </li>
            </ul>

            <li class="nav-item dropdown" style="list-style-type: none">
            <p> User: <?=$user["email"]?> </p>  
            <a
                class="nav-link dropdown-toggle"
                href="#"
                id="navbarDropdown"
                role="button"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
              >
                <img
                  src="../assets/user.png"
                  style="width: 25px; height: 25px"
                />
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Something else here</a>
              </div>
            </li>

          </div>
        </div>
      </nav>
      </div>
        <div class="container searchbar">
          <div class="row height d-flex">
            <div class="col-md-8">
              <div class="search">
                <i class="fa fa-search">Search your books</i
                ><input
                  type="text"
                  class="form-control"
                  placeholder="Search"
                /><button class="btn btn-primary">Search</button>
              </div>

              <br />

              <table id="book-table" class="table table-striped">
                <tr class="table-dark">
                  <th style="text-align: center;">Title</th>
                  <th style="text-align: center;">Author</th>
                  <th style="text-align: center;">Actions</th>
                </tr>
              </table>

              <div>

                <?php
                  if (empty($user["books"])) {
                    echo "<div class='alert alert-danger'>No books in your library
                      <button><a href='home.php'>Add new books</a></button>
                      </div>";
                  }
                ?>

            </div>
          </div>
        </div>
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