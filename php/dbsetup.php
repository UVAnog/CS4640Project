

<?php
    // define variables
    /** SETUP **/
    $db = new mysqli("localhost", "nph2tx", "NolPres29", "nph2tx");
    
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

    