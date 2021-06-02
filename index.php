<?php
include_once("./app/functions.php");

//function to start session in a way that prevents session hijacking
sess_start("lkjhtukih");

$pageName = "Home";

//*****html starts*****
include './templates/header.php';
?>

<!--================ Start Home Banner Area =================-->
<section class="home_banner_area">
  <div class="banner_inner">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="banner_content text-center">
            <h4 class="text-uppercase mt-4 mb-5">
              Welcome to Doggo community
            </h4>
            <h2 class="text-uppercase mt-4 mb-5">
              adopting dogs made easy
            </h2>
            <div>
              <?php if (isset($_SESSION['uid'])) : ?>
                <a href="adoption-board.php" class="primary-btn ml-sm-3 ml-0">adoption board</a>
              <?php else : ?>
                <a href="sign-in.php" class="primary-btn2 mb-3 mb-sm-0">sign in</a>
                <a href="register.php" class="primary-btn ml-sm-3 ml-0">register</a>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!--================ End Home Banner Area =================-->

<?php
include './templates/footer.php';
?>