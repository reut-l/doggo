<?php
//echo "<pre>";

include_once("./app/functions.php");

//function to start session in a way that prevents session hijacking
sess_start("lkjhtukih");

//checking if the user has already signed in
if (!user_verify()) {
    header("location:index.php");
}

session_destroy();
header("location:index.php");
