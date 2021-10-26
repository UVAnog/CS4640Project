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

          <table class="table table-striped">
            <tbody>
              <tr>
                <td>
                  <img
                    src="../assets/harry_potter.jpg"
                    class="book"
                    alt="Harry Potter"
                  />
                </td>
                <td>
                  <div>Harry Potter</div>
                  <div>J.K. Rowling</div>
                  <br />
                  <button class="btn btn-danger">
                    Remove from Saved Books
                  </button>
                  <button class="btn btn-primary">View Notes</button>
                </td>
              </tr>
              <tr>
                <td>
                  <img
                    src="../assets/brave_new_world.jpg"
                    class="book"
                    alt="Brave New World"
                  />
                </td>
                <td>
                  <div>Brave New World</div>
                  <div>Alduous Huxley</div>
                  <br />
                  <button class="btn btn-danger">
                    Remove from Saved Books
                  </button>
                  <button class="btn btn-primary">View Notes</button>
                </td>
              </tr>
              <tr>
                <td>
                  <img
                    src="../assets/to_kill_a_mockingbird.jpg"
                    class="book"
                    alt="To Kill A Mockingbird"
                  />
                </td>
                <td>
                  <div>To Kill A Mockingbird</div>
                  <div>Harper Lee</div>
                  <br />
                  <button class="btn btn-danger">
                    Remove from Saved Books
                  </button>
                  <button class="btn btn-primary">View Notes</button>
                </td>
              </tr>
            </tbody>
          </table>
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