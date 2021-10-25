<?php
    include("dbcredentials.php");
    $mysqli= new mysqli($server , $user , $password , $database );
    $error_msg="" ;
    // start session
    session_start();
    if(isset($_POST[" email" ])){
    // check if user is in database
    $stmt= $stmt->prepare("select * from user where email = ?;");
    $stmt->bind_param("s", $_POST["email"]);
    if (!$stmt->execute()) {
    $error_msg = "User not found";
    }
    else {
    // the user exists in the database
    $res = $stmt->get_result();
    $data = $res->fetch_all(MYSQLI_ASSOC);
    // we found user
    if(isset($data[0])){
    // send them to quiz
    // can only use header command before any html
    // redirect user to other page
    header("Location: books.html?email={$data[0]["email"]}");
    exit();
    }
    else {
    // we did not find the user, insert new email and info as new user
    $insert = $mysqli->prepare("insert into user (name,email) values (?, ?);");
    $insert-> bind_param("ss", $_POST["name"], $_POST["email"]);
    if (!$insert->execute()){
    $error_msg = "Error. Could not create new user";
    }
    header("Location: books.html?email={$_POST["email"]}");
    exit();
    }
    }
    }

    ?>
    <!DOCTYPE html>
    <!--
        Sources used: 

        - https://cs4640.cs.virginia.edu
        - 
        
-->
    <html>
        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <title>myBrary Login</title>
            <meta name="myBrary login page" content="">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="stylesheet" href="">
            <meta author="nolan, nph2tx">
            <link
                href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css"
                rel="stylesheet"
                integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU"
                crossorigin="anonymous">
        </head>
        <body>
            <div class="container" style="margin-top: 50px;">
                <div class="row col-xs-8">
                    <h1>myBrary</h1>
                </div>
                <div class="row">
                    <div class="col-xs-8 mx-auto">
                        <form action="login.php" method="post">
                            <?=$error_msg?>
                                <div class="h-10 p-5 mb-3">
                                    <h5>Name: </h5>
                                    <div class="h-10 p-5 mb-3">
                                        <input type="text" class="form-control"
                                            id="name" name="name"
                                            placeholder="Name">
                                    </div>
                                </div>
                                <div class="h-10 p-5 mb-3">
                                    <h5>Email: </h5>
                                    <div class="h-10 p-5 mb-3">
                                        <input type="text" class="form-control"
                                            id="email" name="email"
                                            placeholder="Email">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password:</label>
                                    <input type="password" class="form-control"
                                        id="password" name="password"></input>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Login
                                    or Create Account</button>
                            </div>
                        </form>
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