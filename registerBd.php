<?php

require "rb-mysql.php";

R::setup( 'mysql:host=localhost;dbname=register',
    'root', 'root' );

if(!R::testConnection()) die('No DB connection!');

session_start();
