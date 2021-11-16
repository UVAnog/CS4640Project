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
        <meta name="description" content="search notes">  
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
                    <div class="search"><i class="fa fa-search">Search your
                            notes</i><input
                            type="text" class="form-control"
                            placeholder="Search"><button class="btn
                            btn-primary">Search</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="book1 float-container">
                <div class="image1 float-child col-md-6">
                    <div>
                        <img src="../assets/harry_potter.jpg" height="400px"
                            width="300px"
                            />
                    </div>
                </div>
                <div class="notes-text float-child col-md-6">
                    <div class="book-info">
                        <div style="text-decoration: underline;"><h5>Notes for:</h5></div>
                        <div style="padding-top: 16px;"><h3>Harry Potter and the
                                Deathly Hallows</h3></div>
                        <div style="padding-top: 16px;"><h6>J.K Rowling</h6></div>
                    </div>
                </div>

                <div class="notes container">
                    <div class="notes1">
                        <div><h1>1.</h1></div>
                        <div class="notes-text" style="padding-top: 16px;">
                            Harry Potter and the Deathly Hallows is a fantasy
                            novel
                            written by British author J. K. Rowling and the
                            seventh
                            and final novel of the Harry Potter series. It was
                            released on 21 July 2007 in the United Kingdom by
                            Bloomsbury Publishing, in the United States by
                            Scholastic, and in Canada by Raincoast Books. The
                            novel
                            chronicles the events directly following Harry
                            Potter
                            and the Half-Blood Prince (2005) and the final
                            confrontation between the wizards Harry Potter and
                            Lord
                            Voldemort.

                            Deathly Hallows shattered sales records upon
                            release,
                            surpassing marks set by previous titles of the Harry
                            Potter series. It holds the Guinness World Record
                            for
                            most novels sold within 24 hours of release, with
                            8.3
                            million sold in the US and 2.65 million in the
                            UK.[1][2]
                            Generally well received by critics, the book won the
                            2008 Colorado Blue Spruce Book Award, and the
                            American
                            Library Association named it the "Best Book for
                            Young
                            Adults". A film adaptation of the novel was released
                            in
                            two parts: Harry Potter and the Deathly Hallows –
                            Part 1
                            in November 2010 and Part 2 in July 2011.
                        </div>
                        <div class="notes-buttons">
                            <div><button class="btn
                                    btn-primary">Edit</button></div>
                            <div style="padding: 32px;"><button class="btn
                                    btn-danger">Delete</button></div>
                        </div>
                    </div>
                    <div class="notes2">
                        <div><h1>2.</h1></div>
                        <div class="notes-text" style="padding-top: 16px;">
                            Throughout the six previous novels in the series,
                            the
                            main character Harry Potter has struggled with the
                            difficulties of adolescence along with being famous
                            as
                            the only person ever to survive the Killing Curse.
                            The
                            curse was cast by Tom Riddle, better known as Lord
                            Voldemort, a powerful evil wizard who murdered
                            Harry's
                            parents and attempted to kill Harry as a baby, due
                            to a
                            prophecy which claimed Harry would be able to stop
                            him.
                            As an orphan, Harry was placed in the care of his
                            Muggle
                            (non-magical) relatives Petunia Dursley and Vernon
                            Dursley, with their son Dudley Dursley.
                        </div>
                        <div class="notes-buttons">
                            <div><button class="btn
                                    btn-primary">Edit</button></div>
                            <div style="padding: 32px;"><button class="btn
                                    btn-danger">Delete</button></div>
                        </div>
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