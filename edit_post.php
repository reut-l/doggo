<?php
//echo "<pre>";

include_once("./app/functions.php");

//function to start session in a way that prevents session hijacking
sess_start("lkjhtukih");

//checking if the user has already signed in
if (!user_verify()) {
    header("location:sign-in.php");
}

//*****reading from DB the post details (the post that the user selected for edit via adoption-board page) *****/
$link = mysqli_connect("localhost", "root", "", "doggo");

if (isset($_GET['p']) && is_numeric($_GET['p'])) {
    $post_id = mysqli_real_escape_string($link, $_GET['p']);
    $uid = $_SESSION['uid'];

    $sql_1 = "SELECT * from posts WHERE id='$post_id' and author_id='$uid'";
    $result = mysqli_query($link, $sql_1);

    if ($result && mysqli_num_rows($result) == 1) {
        $res = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $post = $res[0];
    }
}

//******checking the user's new inputs and saving (overwriting) in DB => redirected to the adoption board page*****
$err = [];
$valid = true;
$varified_file = true;

if (isset($_POST['submit'])) {
    if ($_POST['csrf'] === $_SESSION['csrf']) {

        //1. validating that the user's inputs are not empty
        input_validation("title");
        input_validation("content");

        if ($valid) {

            //2. cleaning and preparing inputs
            $myTitle = clean_input('title', $link, INPUT_POST);
            $myContent = clean_input('content', $link, INPUT_POST);
            $myFileName = $post['image'];
            $myAuthorId = $_SESSION['uid'];
            $time = time();

            //3. checking file, storing it and assigning its name
            if (!empty($_FILES['image']['name'])) {
                $varified_file = file_verify_save('posts_img');
            }

            if ($varified_file) {

                //4. inserting new post details to DB
                $sql_2 = "UPDATE posts set title='$myTitle', content='$myContent', image='$myFileName',upload_timestamp='$time' WHERE id=$post_id and author_id=$uid";
                $result = mysqli_query($link, $sql_2);

                if ($result && mysqli_affected_rows($link) == 1) {
                    header("location:adoption-board.php?sm=Your post has been saved successfully!");
                }
            }
        }
    }
}
//****************************************


$csrf = csrf_token();
$pageName = "Edit Post";

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

        <p class="h4 mb-4">Edit Post</p>

        <span class="err"><?= (isset($err['title'])) ? $err['title'] : ""; ?></span>
        <input type="text" name="title" class="form-control mb-4" value="<?= $post['title'] ?>">
        <span class="err"><?= (isset($err['content'])) ? $err['content'] : ""; ?></span>
        <textarea name="content" class="form-control rounded-0" rows="8"><?= $post['content'] ?></textarea>
        <br>
        <?php if (!empty($post['image'])) : ?>
            <img class="card-img-top" src="./posts_img/<?= $post['image'] ?>" alt=""><br>
            <div class="change_file">
                <label for="image">Change picture:</label>
                <input type="file" id="image" name="image" class="mb-4 narrow_inp">
            </div>
        <?php else : ?>
            <label for="image">Add picture (optional):</label>
            <input type="file" name="image" class="mb-4"><br>
        <?php endif; ?>
        <input type="hidden" name="csrf" value="<?= $csrf; ?>">
        <div class="bottom_edit_post">
            <input type="submit" name="submit" value="Save Post" class="btn btn-primary">
            <button class="btn btn-primary cancel_btn"><a href="./adoption-board.php">Cancel</a></button>
        </div>
    </form>

</main>

<?php
include './templates/footer.php';
?>