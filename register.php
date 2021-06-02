<?php
//echo "<pre>";
include_once("./app/functions.php");

//function to start session in a way that prevents session hijacking
sess_start("lkjhtukih");

//checking if the user has already signed in
if (isset($_SESSION['uid']) && !empty($session['uid']) && is_numeric($_SESSION['uid'])) {
    header('location:adoption-board.php');
}


// ******checking the user's inputs: in case they are inserted properly and email name is not already taken => session params are created and he is redirected to the adoption board page*****
$err = [];
$valid = true;
$email_exist = false;
$varified_file = true;
$link = mysqli_connect("localhost", "root", "", "doggo");

$nameRegex = '/^[a-z]{2,60}$/i';
$emailRegex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i';
$pwdRegex = '/^\S*(?=\S{6,20})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/';



if (isset($_POST['submit'])) {

    if ($_POST['csrf'] === $_SESSION['csrf']) {

        //1. validating that the user's inputs are not empty and valid
        input_validation("f_name", $nameRegex);
        input_validation("l_name", $nameRegex);
        input_validation("email", $emailRegex);
        input_validation("pwd", $pwdRegex);

        if ($valid) {

            //2. cleaning inputs and hashing the pwd
            $myFName = clean_input('f_name', $link, INPUT_POST);
            $myLName = clean_input('l_name', $link, INPUT_POST);
            $myEmail = clean_input('email', $link, INPUT_POST);
            $myPwd = clean_input('pwd', $link, INPUT_POST);
            $myPwd = password_hash($myPwd, PASSWORD_BCRYPT);
            $myAvatarName = &$myFileName;
            $myFileName = "";


            //3. checking if the user's email already exists in DB
            $sql_1 = "SELECT * FROM users WHERE email='$myEmail'";
            $result_1 = mysqli_query($link, $sql_1);

            if ($result_1 && mysqli_num_rows($result_1) === 1) {
                $err['email_exist'] = true;
                $email_exist = true;
            }

            if (!$email_exist) {

                //4. In case the user chose a profile picture: checking file, storing it and assigning its name
                if (!empty($_FILES['image']['name'])) {
                    $varified_file = file_verify_save('profile_img');
                }

                if ($varified_file) {

                    //5. inserting new user's details to DB
                    $sql_2 = "INSERT INTO users VALUES (null,'$myEmail','$myPwd','$myFName','$myLName','$myAvatarName')";
                    $result_2 = mysqli_query($link, $sql_2);

                    if ($result_2 && mysqli_affected_rows($link) === 1) {

                        header("location:sign-in.php?sm=You registered successfully. You can sign in to your acount");
                    }
                }
            }
        }
    }
}


//****************************************


$csrf = csrf_token();
$pageName = "Register";

//*****html starts*****
include './templates/header.php';

?>
<div class="generic_area">
    <main class="register_area">
        <form class="register_form" action="" method="post" novalidate="novalidate" enctype="multipart/form-data">
            <p>Please fill in the details below:</p>

            <label for="fName" class="form-label">First Name:</label>
            <input type="text" name="f_name" class="form-input" placeholder="First Name" value="<?= (isset($err['email_exist'])) ? $_POST['f_name'] : ''; ?>">
            <span class="err"><?= (isset($err['f_name'])) ? $err['f_name'] : ""; ?></span>
            <?php if (isset($err['f_name_valid'])) : ?>
                <span class="err">*Must contain only letters, min 2 letters</span>
            <?php endif; ?><br>

            <label for="lName" class="form-label">Last Name:</label>
            <input type="text" name="l_name" class="form-input" placeholder="Last Name" value="<?= (isset($err['email_exist'])) ? $_POST['l_name'] : ''; ?>">
            <span class="err"><?= (isset($err['l_name'])) ? $err['l_name'] : ""; ?></span>
            <?php if (isset($err['l_name_valid'])) : ?>
                <span class="err">*Must contain only letters</span>
            <?php endif; ?><br>

            <label for="Email" class="form-label">Email:</label>
            <input type="text" name="email" class="form-input" placeholder="Email">
            <span class="err"><?= (isset($err['email'])) ? $err['email'] : ""; ?></span>
            <?php if (isset($err['email_valid'])) : ?>
                <span class="err">*Please enter a valid email address</span>
            <?php endif; ?>
            <?php if (isset($err['email_exist'])) : ?>
                <span class="err">*Email is taken. Please use a different one</span>
            <?php endif; ?>
            <br>

            <label for="Password" class="form-label">Password:</label>
            <input type="password" name="pwd" class="form-input pwdInp" placeholder="Password"><span class="showIcon" onclick="togglePwd()"> <i class="fas fa-eye" style="display:none"></i><i class="fas fa-eye-slash"></i></span>
            <span class="err"><?= (isset($err['pwd'])) ? $err['pwd'] : ""; ?></span>
            <?php if (isset($err['pwd_valid'])) : ?>
                <span class="err">*Password is not valid</span>
            <?php endif; ?>
            <br>
            <div class="pwd_rules <?= (isset($err['pwd_valid'])) ? "err" : ""; ?>">
                <p>(6-20 charaters, at least: one uppercase latter, one lowercase latter, one number)</p>
            </div>
            <label for="image" class="form-label">Profile picture (optional):</label>
            <input type="file" name="image" class="mb-4"><br>

            <input type="hidden" name="csrf" value="<?= $csrf; ?>">
            <p>
                <input type="submit" name="submit" class="btn btn-primary" value="Register">
            </p>



        </form>
    </main>
</div>
<?php
include './templates/footer.php';
?>