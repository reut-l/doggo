<?php
if (!function_exists('sess_start')) {

    function sess_start($name = 'null')
    {
        if ($name) session_name($name);
        session_start();
        session_regenerate_id();
    }
}

if (!function_exists('csrf_token')) {

    function csrf_token()
    {
        $token = sha1(rand(1, 999) . time() . "!@#");
        $_SESSION['csrf'] = $token;
        return $token;
    }
}

if (!function_exists('user_verify')) {

    function user_verify()
    {
        $verify = [];

        if (!isset($_SESSION['uid'])) $verify[] = 1;

        if (!(isset($_SESSION['user_ip']) && $_SESSION['user_ip'] == $_SERVER['REMOTE_ADDR'])) $verify[] = 1;

        if (!(isset($_SESSION['user_agent']) && $_SESSION['user_agent'] == $_SERVER['HTTP_USER_AGENT'])) $verify[] = 1;

        return (array_sum($verify) === 0) ? true : false;
    }
}

if (!function_exists('clean_input')) {

    function clean_input($inpName, $conn, $requestType)
    {
        $clean_inp = filter_input($requestType, $inpName, FILTER_SANITIZE_STRING);
        $clean_inp = mysqli_real_escape_string($conn, $clean_inp);
        $clean_inp = trim($clean_inp);
        return $clean_inp;
    }
}

if (!function_exists('input_validation')) {

    function input_validation($inpName, $inpRegex = "/.+/")
    {
        global $valid, $err;
        if (empty($_POST[$inpName])) {
            switch ($inpName) {
                case "f_name":
                    $inpFullName = "first name";
                    break;
                case "l_name":
                    $inpFullName = "last name";
                    break;
                case "pwd":
                    $inpFullName = "password";
                    break;
                default:
                    $inpFullName = $inpName;
            }

            $err[$inpName] = "*Please enter $inpFullName";
            $valid = false;
        } elseif (!preg_match($inpRegex, $_POST[$inpName])) {
            $errName = $inpName . "_valid";
            $err[$errName] = true;
            $valid = false;
        }
    }
}

if (!function_exists('file_verify_save')) {

    function file_verify_save($file_save_dir)
    {
        global $myFileName;
        define("UPLOAD_MAX_SIZE", 1024 * 1024 * 10);
        $ex = ["jpg", "jpeg", "png", "gif", "bmp"];
        $verify = [];

        //series of file checks
        if (empty($_FILES['image']['name'])) $verify[] = 1;
        if (!is_uploaded_file($_FILES['image']['tmp_name'])) $verify[] = 1;
        if ($_FILES['image']['size'] > UPLOAD_MAX_SIZE) $verify[] = 1;
        if ($_FILES['image']['error'] != 0) $verify[] = 1;

        $file_info = pathinfo($_FILES['image']['name']);
        $file_ex = strtolower($file_info['extension']);
        if (!in_array($file_ex, $ex)) $verify[] = 1;


        if (array_sum($verify) === 0) {

            //save file and verify saving
            $myFileName = time() . '_' . $_FILES['image']['name'];
            return (move_uploaded_file($_FILES['image']['tmp_name'], "./$file_save_dir/" . $myFileName)) ? true : false;
        }
    }
}

if (!function_exists('time_to_phrase')) {

    function time_to_phrase($my_timestamp)
    {
        $numDays = floor((time() - $my_timestamp) / (60 * 60 * 24));
        $numHours = floor((time() - $my_timestamp) / (60 * 60));
        $numMinutes = floor((time() - $my_timestamp) / 60);
        $uploadDate = date('d F Y', $my_timestamp);

        if ($numMinutes == 0) {
            $phrase = "just now";
        } elseif ($numMinutes < 60) {
            $phrase = "$numMinutes minutes ago";
        } elseif ($numHours == 1) {
            $phrase = "$numHours hour ago";
        } elseif ($numHours < 24) {
            $phrase = "$numHours hourse ago";
        } elseif ($numDays == 1) {
            $phrase = "$numDays day ago";
        } elseif ($numDays < 7) {
            $phrase = "$numDays days ago";
        } else {
            $phrase = "on $uploadDate";
        }
        return $phrase;
    }
}
