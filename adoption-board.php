<?php
//echo "<pre>";
include_once("./app/functions.php");

//function to start session in a way that prevents session hijacking
sess_start("lkjhtukih");


//checking if the user has already signed in
$user_signed_in = (user_verify()) ? true : false;


//reading all posts from DB
$link = mysqli_connect("localhost", "root", "", "doggo");
$sql = "SELECT posts.*,users.f_name FROM posts JOIN users ON posts.author_id=users.id ORDER BY posts.upload_timestamp DESC";
$result = mysqli_query($link, $sql);


$posts = [];
if ($result && mysqli_num_rows($result) > 0) {
    $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

$pageName = "Adoption Board";

//*****html starts*****
include './templates/header.php';

?>

<?php if (isset($_GET['sm'])) : ?>
    <div class="alert alert-success sm-box">
        <?= $_GET['sm']; ?>
    </div>
<?php endif; ?>

<main class="board_area generic_area">
    <div class="heading">
        <?php if ($user_signed_in) : ?>
            <div class="addBtn">
                <a href="./add_post.php" class="btn btn-primary">+ Add New</a>
            </div>
        <?php else : ?>
            <div>
                <button class="btn btn-primary" disabled>+ Add New</button><br>
                To add new doggo <a href="./sign-in.php">sign-in here</a>. Not a member yet? <a href="./register.php">register here</a>.</p>
            </div>
        <?php endif ?>

    </div>
    <div class="row text-center">

        <?php foreach ($posts as $post) : ?>
            <?php $post['time_phrase'] = time_to_phrase($post['upload_timestamp']) ?>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card">
                    <div class="adopt_card_img">
                        <img class="card-img-top" src="./posts_img/<?= (!empty($post['image'])) ? $post['image'] : 'default.jpg' ?>" alt="">
                    </div>
                    <div class="adopt_card_body">
                        <h4 class="adopt_card_title"><?= htmlspecialchars($post['title']); ?></h4>
                        <p class="adopt_card_text"><?= htmlspecialchars($post['content']); ?></p>
                    </div>
                    <div class="adopt_card_footer">
                        <p id="posted_line">
                            <?php if ($user_signed_in && $post['author_id'] == $_SESSION['uid']) : ?>
                                <img src="./profile_img/<?= $_SESSION['uAvatar'] ?>" alt="">
                            <?php endif; ?>
                            Posted by <?= htmlspecialchars($post['f_name']); ?></p>
                        <p>Last updated <?= $post['time_phrase']; ?></p>
                        <?php if ($user_signed_in && $post['author_id'] == $_SESSION['uid']) : ?>
                            <a href=" ./edit_post.php?p=<?= $post['id'] ?>" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                            <a href="./delete_post.php?p=<?= $post['id'] ?>" onclick="return confirm('Are you sure you want to delete this post?')" class="btn btn-primary"><i class="fas fa-trash-alt"></i></a>
                        <?php else : ?>
                            <a href="" class="btn btn-primary"><i class="fas fa-phone"></i></a>
                            <a href="" class="btn btn-primary"><i class="fas fa-envelope"></i></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<?php
include './templates/footer.php';
?>