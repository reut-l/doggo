<?php
//echo "<pre>";

include_once("./app/functions.php");

//function to start session in a way that prevents session hijacking
sess_start("lkjhtukih");

//checking if the user has already signed in
if (!user_verify()) {
    header("location:sign-in.php");
}


//*****deleting the post details from DB (the post that the user selected for delete via adoption-board page) *****/
$link = mysqli_connect("localhost", "root", "", "doggo");

if (isset($_GET['p']) && !empty($_GET['p']) && is_numeric($_GET['p'])) {
    $post_id = clean_input('p', $link, INPUT_GET);
    $uid = $_SESSION['uid'];

    $sql = "DELETE FROM posts WHERE id='$post_id' and author_id='$uid'";
    $result = mysqli_query($link, $sql);

    if ($result && mysqli_affected_rows($link) == 1) {
        header("location:adoption-board.php?sm=Your post has been deleted successfully!");
        exit;
    }
}

header("location:adoption-board.php");
