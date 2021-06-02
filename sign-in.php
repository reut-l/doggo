<?php
//echo "<pre>";
include_once("./app/functions.php");

//function to start session in a way that prevents session hijacking
sess_start("lkjhtukih");

//checking if the user has already signed in
if (isset($_SESSION['uid']) && !empty($session['uid']) && is_numeric($_SESSION['uid'])) {
    header('location:adoption-board.php');
}


// ******checking the user's inputs: in case they are correct => session params are created and he is redirected to the adoption board page*****
$err = [];
$valid = true;
$link = mysqli_connect("localhost", "root", "", "doggo");

if (isset($_POST['submit'])) {
    if ($_POST['csrf'] === $_SESSION['csrf']) {

        //1. validating that the user's inputs are not empty
        if (empty($_POST['email'])) {
            $err['email'] = "*Please enter email";
            $valid = false;
        }
        if (empty($_POST['pwd'])) {
            $err['pwd'] = "*Please enter password";
            $valid = false;
        }
        if ($valid) {
            $myEmail = clean_input('email', $link, INPUT_POST);
            $myPwd = clean_input('pwd', $link, INPUT_POST);

            //2.checking if the user's inputs match a user in DB
            $sql = "select * from users where email='$myEmail'";

            $result = mysqli_query($link, $sql);

            if ($result && mysqli_num_rows($result) === 1) {
                $resArr = mysqli_fetch_all($result, MYSQLI_ASSOC);
                $user = $resArr[0];

                if (password_verify($myPwd, $user['pwd'])) {
                    $_SESSION['uid'] = $user['id'];
                    $_SESSION['uname'] = $user['f_name'];
                    $_SESSION['uAvatar'] = (!empty($user['avatar'])) ? $user['avatar'] : 'default.png';
                    $_SESSION['user_ip'] = $_SERVER['REMOTE_ADDR'];
                    $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];

                    header("location:adoption-board.php");
                } else {
                    $err['loginDetails'] = "Email and/or password are incorrect.";
                }
            } else {
                $err['loginDetails'] = "Email and/or password are incorrect.";
            }
        }
    }
}

//****************************************

$csrf = csrf_token();
$pageName = "Sign In";

//*****html starts*****
include './templates/header.php';

?>

<main class="sign-in_area generic_area">
    <div class="heading">
        <p>If you aren't a member yet, please <a href="./register.php">register here</a>.</p>
    </div>

    <form action="" method="post" novalidate="novalidate">

        <label for="Email" class="form-label">Email:</label>
        <input type="text" name="email" class="form-input" placeholder="Email">
        <span class="err"><?= (isset($err['email'])) ? $err['email'] : ""; ?></span><br>
        <label for="Password" class="form-label">Password:</label>
        <input type="password" name="pwd" class="form-input pwdInp" placeholder="Password"><span class="showIcon" onclick="togglePwd()"> <i class="fas fa-eye" style="display:none"></i><i class="fas fa-eye-slash"></i></span>
        <span class="err"><?= (isset($err['pwd'])) ? $err['pwd'] : ""; ?></span><br>
        <span class="err"><?= (isset($err['loginDetails'])) ? $err['loginDetails'] : ""; ?></span><br>
        <input type="hidden" name="csrf" value="<?= $csrf; ?>">
        <input type="submit" name="submit" class="btn btn-primary" value="Sign In">

    </form>
</main>

<?php
include './templates/footer.php';
?>