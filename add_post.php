<?php
//echo "<pre>";
include_once("./app/functions.php");

//function to start session in a way that prevents session hijacking
sess_start("lkjhtukih");

//checking if the user has already signed in
if (!user_verify()) {
    header("location:sign-in.php");
}

// ******checking the user's inputs and saving in DB => redirected to the adoption board page*****
$err = [];
$valid = true;
$varified_file = true;
$link = mysqli_connect("localhost", "root", "", "doggo");

if (isset($_POST['submit'])) {
    if ($_POST['csrf'] === $_SESSION['csrf']) {

        //1. validating that the user's inputs are not empty
        input_validation("title");
        input_validation("content");

        if ($valid) {

            //2. cleaning and preparing inputs
            $myTitle = clean_input('title', $link, INPUT_POST);
            $myContent = clean_input('content', $link, INPUT_POST);
            $myFileName = "";
            $myAuthorId = $_SESSION['uid'];
            $time = time();

            //3. checking file, storing it and assigning its name
            if (!empty($_FILES['image']['name'])) {
                $varified_file = file_verify_save('posts_img');
            }

            if ($varified_file) {

                //4. inserting new post details to DB
                $sql = "INSERT INTO posts VALUES (null,'$myTitle','$myContent','$myFileName','$myAuthorId','$time')";
                $result = mysqli_query($link, $sql);

                if ($result && mysqli_affected_rows($link) == 1) {
                    header("location:adoption-board.php?sm=Your post has been added successfully!");
                }
            }
        }
    }
}
//****************************************


$csrf = csrf_token();
$pageName = "Add Post";

//*****html starts*****
include './templates/header.php';

?>
<main class="edit_post_area generic_area">

    <div class="heading">
        <div class="addBtn">
            <a href="./adoption-board.php" class="btn btn-primary">Adoption Board</a>
        </div>
    </div>

    <form class="text-center border border-light p-5 post_form" action="" method="post" enctype="multipart/form-data" novalidate="novalidate">

        <p class="h4 mb-4">New Doggo Card</p>

        <span class="err"><?= (isset($err['title'])) ? $err['title'] : ""; ?></span>
        <input type="text" name="title" class="form-control mb-4" placeholder="Enter title here..." value="<?= (isset($_POST['title'])) ? $_POST['title'] : ""; ?>">
        <span class="err"><?= (isset($err['content'])) ? $err['content'] : ""; ?></span>
        <textarea name="content" class="form-control rounded-0" rows="8" placeholder="Enter a few words about your doggo friend..."><?= (isset($_POST['content'])) ? $_POST['content'] : ''; ?></textarea>
        <br>
        <label for="image">Add picture (optional):</label>
        <input type="file" name="image" class="mb-4"><br>
        <input type="hidden" name="csrf" value="<?= $csrf; ?>">
        <input type="submit" name="submit" value="Add Post" class="btn btn-primary">

    </form>

</main>

<?php
include './templates/footer.php';
?>