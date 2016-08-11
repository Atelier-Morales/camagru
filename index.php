<?php

require("config/database.php");

if (!isset($register))
    $register = false;

if (isset($_POST['submit'])) {
    $errMsg = '';
    //username and password sent from Form
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    if ($username == '')
        $errMsg .= 'You must enter your Username<br>';

    if ($password == '')
        $errMsg .= 'You must enter your Password<br>';

    if ($errMsg == '') {
        $sql = 'SELECT id, username, email, password FROM user WHERE username = :username OR email = :email';
        $records = $db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $records->execute(array(':username' => $username, ':email' => $username));
        $results = $records->fetchAll();
        $hashPass = hash('gost', $password);
        if (count($results[0]) > 0 && strcmp($hashPass, $results[0]['password']) == 0) {
            $username = $results[0]['username'];
            $email = $results[0]['email'];
            $login = true;
            $view = 1;
            $_SESSION['username'] = $username;
            $_SESSION['login'] = $login;
            $_SESSION['email'] = $email;
        } else {
            unset($username);
            $errMsg .= 'Username and Password not found<br>';
        }
    }
}

if (isset($_POST['submitReg'])) {
    $errMsg = '';
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $email = trim($_POST['email']);
    if ($username == '')
        $errMsg .= 'You must enter your Username<br>';

    if ($password == '')
        $errMsg .= 'You must enter your Password<br>';

    if ($email == '')
        $errMsg .= 'You must enter your Email<br>';

    if ($errMsg == '') {
        $pass = hash('gost', $password);
        $codedInfo = base64_encode($username . ' ' . $email . ' ' . $pass);
        $headers = "From: test@mydomain.com";
        $msg = "Hello " . $username . "\r\n" .
            "In order to complete your registration, please validate your account via this link :"
            . "\r\n" .
            "http://localhost:8080/camagru/index.php?token=" . $codedInfo
            . "\r\n" .
            "Thank you," . "\r\n" .
            "The Camagru Team";
        mail($email, "Camagru : Validate your account", $msg, $headers);
        unset($username);
        $confirm = true;
    }
}

if (isset($_POST['usernameCheck'])) {
    $check_username = trim($_POST['username']);
    if ($check_username == '')
        $errMsg .= 'You must enter your username or email<br>';
    else {
        $sql = 'SELECT username, email FROM user WHERE username = :username OR email = :email';
        $records = $db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $records->execute(array(':username' => $check_username, ':email' => $check_username));
        $results = $records->fetchAll();
        if (count($results[0]) > 0) {
            $username_to_contact = $results[0]['username'];
            $contact_email = $results[0]['email'];
            $email_info = base64_encode($username_to_contact);
            $headers = "From: test@mydomain.com";
            $msg = "Hello " . $username_to_contact . "\r\n" .
                "You can now reset your password via this link :"
                . "\r\n" .
                "http://localhost:8080/camagru/index.php?resetpass=" . $email_info
                . "\r\n" . "\r\n" .
                "Thank you," . "\r\n" .
                "The Camagru Team";
            mail($contact_email, "Camagru : Reset your password", $msg, $headers);
            $confirm2 = true;
        } else {
            $errMsg .= 'User not found<br>';
        }
    }
}

if (isset($_POST['submitNewPass'])) {
    if (strcmp($_POST['password'], $_POST['passwordConfirm']) != 0) {
        $errMsgPass = 'passwords don\'t match please retype passwords';
    }
    else {
        try {
            $temp_user = $_POST['check-username'];
            $newPass = hash('gost', $_POST['password']);
            $sql = $db->prepare("UPDATE `user` 
                                  SET `user`.`password` = :newpassword 
                                  WHERE `user`.`username` = :temp_username");
            $sql->bindParam(':newpassword', $newPass);
            $sql->bindParam(':temp_username', $temp_user);
            $sql->execute();
            setcookie('resetsuccess', true, time() + 1, "/");
            header("Location: index.php");
        }
        catch (PDOException $e) {
            $errMsgPass = $e;
        }
    }

}

if (isset($_GET["token"])) {
    $decoded = base64_decode(htmlspecialchars($_GET["token"]));
    $token = explode(" ", $decoded);
    try {
        $sql = $db->prepare("INSERT INTO user (username, password, email) VALUES (:username, :password, :email)");
        $sql->bindParam(':username', $token[0], PDO::PARAM_STR);
        $sql->bindParam(':password', $token[2], PDO::PARAM_STR);
        $sql->bindParam(':email', $token[1], PDO::PARAM_STR);
        $sql->execute();
        header("Location: index.php");
    } catch (PDOException $e) {
        header("Location: index.php");
    }
}

if (isset($_COOKIE['resetsuccess'])) {
    if ($_COOKIE['resetsuccess'] == 1) {
        $reset_success = 'password succesfully reset, please log in';
        unset($_COOKIE['resetsuccess']);
    }
}

if (isset($_GET["logout"])) {
    $login = false;
    unset($username);
    unset($_SESSION['username']);
    unset($_SESSION['login']);
    header("Location: index.php");
}

if (isset($_GET["gallery"]) || isset($_GET["home"])) {
    $login = $_SESSION['login'];
    $username = $_SESSION['username'];
    if (isset($_GET["gallery"]))
        $view = 2;
    else
        $view = 1;
}

require("ajax.php");
require("header.php");

if (!isset($login) || $login == false) {
    if (isset($_GET["register"])) {
        if (isset($confirm) && $confirm == true) {
            echo '<h2 class="welcome">Please click on the link you have received by email</h2>';
        } else {
            echo '<h2 class="welcome">Welcome to Camagru, please login or register</h2>';
            require("register.php");
        }
    }
    else if (isset($_GET["resetpass"])) {
        if (strlen($_GET["resetpass"]) == 0) {
            if (isset($confirm2) && $confirm2 == true)
                echo '<h2 class="welcome">Please click on the link you have received by email</h2>';
            else
                require("reset.php");
        }
        else if (strlen($_GET["resetpass"]) > 0) {
            $user_exists = base64_decode($_GET["resetpass"]);
            try {
                $sql = 'SELECT username, email FROM user WHERE username = :username';
                $records = $db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                $records->execute(array(':username' => $user_exists));
                $results = $records->fetchAll();
                if (count($results[0]) > 0) {
                    $temp_user = $results[0]['username'];
                }
                else {
                    $errMsgReset .= 'User not found, please type a valid username<br>';
                }
            }
            catch (PDOException $e) {
                $errMsgReset .= 'User not found, please type a valid username<br>';
            }
            require("reset.php");
        }
    }
    else {
        echo '<h2 class="welcome">Welcome to Camagru, please login or register</h2>';
        require("login.php");
    }
} else {
    if ($view == 1) {
        $sql = 'SELECT pic.id, pic.src, pic.title, pic.date, pic.user_id 
                FROM pictures pic 
                INNER JOIN user us 
                ON pic.user_id = us.id 
                WHERE us.username = :username
                ORDER BY pic.date DESC';
        $records = $db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $records->execute(array(':username' => $username));
        $pics = $records->fetchAll();
        require("welcome.php");
        if (isset($welcome) && $welcome == true) {
            $message = "welcome to camagru, " . $username;
            echo '<script type="text/javascript">'
            , 'window.alert("' . $message . '");'
            , '</script>';
        }
    }
    else if ($view == 2) {

        //fetch pictures first
        $sql = 'SELECT pic.id, pic.src, pic.title, pic.date, us.username 
                FROM pictures pic INNER JOIN user us ON pic.user_id = us.id';
        $records = $db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $records->execute();
        $pictures = $records->fetchAll();

        //then likes
        $sql2 = 'SELECT username, picture_id FROM likes';
        $records2 = $db->prepare($sql2, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $records2->execute();
        $likes = $records2->fetchAll();

        //and finally comments
        $sql3 = 'SELECT username, picture_id, comment, date_published FROM Comments';
        $records3 = $db->prepare($sql3, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $records3->execute();
        $comments = $records3->fetchAll();
        require("gallery.php");
    }
}


echo '<br>';

require("footer.php");
?>

