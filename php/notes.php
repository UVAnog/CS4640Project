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
    "books" => array(),
    "notes" => array()
    ];

    // get books associated with current user
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

    // get notes associated with current user
    $stmt = $mysqli->prepare("select * from note where user_email = ?;");
    $stmt->bind_param("s", $user["email"]);
    if (!$stmt->execute()) {
        $error_msg = "Error checking for user";
    } else { 
        // result succeeded
        $res = $stmt->get_result();
        $data = $res->fetch_all(MYSQLI_ASSOC);
        
        if (!empty($data)) { //(isset($data[0])) {
          $json = json_encode($data, JSON_PRETTY_PRINT);
          $user["notes"] = json_decode($json, true);
        } else {
          $error_msg = "Error: no notes in library";
        }
      }

      if (isset($_POST["book"]) && isset($_POST["note"])) { // validate the note coming in
        $stmt = $mysqli->prepare("select * from note where book_title = ? and text = ?;");
        $stmt->bind_param("ss", $_POST["book"], $_POST["note"]);
        if (!$stmt->execute()) {
            $error_msg = "Error checking for note";
        } else {
          // result succeeded
          $res = $stmt->get_result();
          $data = $res->fetch_all(MYSQLI_ASSOC);
          
          if (!empty($data)) {
            // note was found
            $error_msg = "Error: note already exists!";
          } else {
            // note was not found, create the note
            $insert = $mysqli->prepare("insert into note (user_email, book_title, text) values (?, ?, ?);");
            $insert->bind_param("sss", $user["email"], $_POST["book"], $_POST["note"]);
            if (!$insert->execute()) {
                $error_msg = "Error creating new note";
            } 
            
            // Save user information into the session to use later
            header("Location: notes.php");
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
        <meta name="description" content="search notes">  
        <title>myBrary</title>
        <link rel="stylesheet" href="../styles/main.css" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous"> 
    
        <script>

          function onLoad() {
            setDropdownOptions();
            displayNotes();
            setSearchbar();
          }

          function setDropdownOptions () {
            var books = <?php echo json_encode($user["books"]); ?>;
            var dropdown = document.getElementById("book");
            for (var i=0; i<books.length; i++){
              var newOption = document.createElement("option");
              newOption.value = books[i].title;
              newOption.innerHTML = books[i].title;
              dropdown.appendChild(newOption);
            }
          }

          function validateForm() {
            let note = document.getElementById("note").value;
            if(note==""){
              alert("Error: Note field must be filled out!")
              return false;
            }
          }

          var notes = <?php echo json_encode($user["notes"]); ?>;

          const displayNotes = () => {
            var table = document.getElementById("note-table");

            notes.forEach((note) => {
              var newRow = table.insertRow(table.rows.length);
              newRow.insertCell(0).textContent = note.book_title;
              newRow.insertCell(1).textContent = note.text;
              newRow.insertCell(2).innerHTML =
                `<button class="btn btn-sm btn-danger" onclick="location.href='delete.php?title=${note.book_title}&note=${note.text}'";>Delete</button>`;
            });
          }

          function setSearchbar() {
            var searchbar = document.getElementById("searchbar");
            if(notes.length === 0){
              searchbar.setAttribute("disabled", "true");
            } else {
              searchbar.removeAttribute("disabled");
            }
          }

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
                <a class="nav-link" aria-current="page" href="books.php">Saved
                  Books</a>
              </li>
              <li class="nav-item hover-item">
                <a class="nav-link active" href="notes.php">Saved Notes</a>
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
                    <div class="search"><i class="fa fa-search">Search your
                            notes</i><input
                            id="searchbar"
                            type="text" class="form-control"
                            placeholder="Search"><button class="btn
                            btn-primary">Search</button>
                    </div>
                    
                    <div style="padding: 10px; margin-top: 20px; border: 1px solid black;">
                      <?php
                        if (!empty($error_msg)) {
                          echo "<div class='alert alert-danger'>$error_msg</div>";
                        }
                      ?>

                      <label for="form">Add a New Note</label>
                      <form id="form" action="notes.php" onsubmit="return validateForm()" method="post">
                        <div class="mb-3">
                          <label for="book">Choose a Book:</label>
                          <select name="book" id="book"></select>
                        </div>
                        <div class="mb-3">
                          <label for="note" class="form-label">Enter note:</label>
                          <input type="note" class="form-control" id="note" name="note"/>
                        </div>
                        <div class="text-center">
                          <button type="submit" class="btn btn-primary">Add New Note</button>
                        </div>
                      </form>

                      <table id="note-table" class="table table-striped" style="margin-top: 20px;">
                        <tr class="table-dark">
                          <th style="text-align: center;">Book Title</th>
                          <th style="text-align: center;">Note Text</th>
                          <th style="text-align: center;">Actions</th>
                        </tr>
                      </table>
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