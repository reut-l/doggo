<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="icon" href="img/favicon.png" type="image/png" />
    <title>Doggo - Making home for dogs</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.css" />
    <link rel="stylesheet" href="css/flaticon.css" />
    <link rel="stylesheet" href="css/themify-icons.css" />
    <link rel="stylesheet" href="vendors/owl-carousel/owl.carousel.min.css" />
    <link rel="stylesheet" href="vendors/nice-select/css/nice-select.css" />
    <!-- main css Font Awesome-->
    <script src="https://kit.fontawesome.com/0d1f370dae.js" crossorigin="anonymous"></script>
    <!-- main css -->
    <link rel="stylesheet" href="css/style.css" />
</head>

<body>
    <!--================ Start Header Menu Area =================-->
    <header class="header_area">
        <div class="main_menu">

            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="container">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <a class="navbar-brand logo_h" href="index.php"><img src="img/logo<?= ($pageName !== "Home") ? "2" : ""; ?>.png" alt="" /></a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="icon-bar"></span> <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
                        <div id="left-nav">
                            <ul class="nav navbar-nav menu_nav ml-auto">
                                <li class="nav-item <?= ($pageName === "Home") ? 'active' : ''; ?>">
                                    <a class="nav-link" href="index.php">Home</a>
                                </li>
                                <li class="nav-item <?= ($pageName === "About Us") ? 'active' : ''; ?>">
                                    <a class="nav-link" href="about.php">About</a>
                                </li>
                                <li class="nav-item <?= ($pageName === "Adoption Board") ? 'active' : ''; ?>">
                                    <a class="nav-link" href="adoption-board.php">Adoption Board</a>
                                </li>

                                <li class="nav-item <?= ($pageName === "Contact Us") ? 'active' : ''; ?>">
                                    <a class="nav-link" href="contact.php">Contact</a>
                                </li>


                            </ul>
                        </div>
                        <div id="right-nav">

                            <?php if (isset($_SESSION['uid'])) : ?>
                                <div class="user_nav-item">
                                    <img src="./profile_img/<?= $_SESSION['uAvatar'] ?>" alt="">
                                    <span class="nav-link" href="" style="cursor:default">Hello, <?= $_SESSION['uname'] ?></span>
                                </div>
                                <ul class="nav navbar-nav menu_nav ml-auto">
                                    <li class="<?= ($pageName === "Logout") ? 'active ' : ''; ?>nav-item ">
                                        <a class="nav-link" href="logout.php">Logout</a>
                                    </li>
                                </ul>
                            <?php else : ?>
                                <ul class="nav navbar-nav menu_nav ml-auto">
                                    <li class="<?= ($pageName === "Sign In") ? 'active ' : ''; ?>nav-item ">
                                        <a class="nav-link" href="sign-in.php">Sign in</a>
                                    </li>
                                    <li class="nav-item <?= ($pageName === "Register") ? 'active' : ''; ?>">
                                        <a class="nav-link" href="register.php">Register</a>
                                    </li>
                                </ul>
                            <?php endif; ?>

                        </div>

                    </div>
            </nav>
        </div>
    </header>
    <!--================ End Header Menu Area =================-->
    <!--================ Start Home Banner Area =================-->
    <?php if ($pageName !== "Home") : ?>
        <section class="banner_area">
            <div class="banner_inner d-flex align-items-center">
                <div class="overlay"></div>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-6">
                            <div class="banner_content text-center">
                                <h2><?= $pageName ?></h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!--================ End Home Banner Area =================-->