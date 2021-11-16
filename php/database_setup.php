<?php
    // define variables
    /** SETUP **/
    include("./database_connection.php");
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $db = new mysqli($dbserver , $dbuser , $dbpass , $dbdatabase );
    
    $db->query("drop table if exists book;");
    $db->query("create table book (
        id int not null auto_increment,
        title text not null,
        author text not null,
        user_email text not null,
        primary key (id));");
    
    $db->query("drop table if exists user;");
    $db->query("create table user (
        id int not null auto_increment,
        email text not null,
        name text not null,
        password text not null,
        primary key (id));"); 

    $db->query("drop table if exists note;");
    $db->query("create table note (
        id int not null auto_increment,
        user_email text not null,
        book_title text not null,
        text text not null,
        primary key (id));"); 
