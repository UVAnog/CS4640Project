

<?php
    // define variables
    /** SETUP **/
    include("dbcredentials.php");
    $mysqli= new mysqli($server , $user , $password , $database );
    
    $db->query("drop table if exists book;");
    $db->query("create table book (
        id int not null auto_increment,
        title text not null,
        author text not null,
        primary key (id));");
    
    $db->query("drop table if exists user;");
    $db->query("create table user (
        id int not null auto_increment,
        email text not null,
        name text not null,
        password text not null,
        primary key (id));"); 

    