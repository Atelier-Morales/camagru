<?php

require("config/database.php");

if (!isset($register))
    $register = false;

if(isset($_POST['submit'])){
    $errMsg = '';
    //username and password sent from Form
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    if($username == '')
        $errMsg .= 'You must enter your Username<br>';

    if($password == '')
        $errMsg .= 'You must enter your Password<br>';


    if($errMsg == ''){
        $sql = 'SELECT id, username, password FROM user WHERE username = :username';
        $records = $db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $records->execute(array(':username' => $username));
        $results = $records->fetchAll();
        if ($password != 'test')
            $hashPass = hash('gost', $password);
        else
            $hashPass = $password;
        if(count($results[0]) > 0 && strcmp($hashPass, $results[0]['password']) == 0) {
            $login = true;
        } else {
            $errMsg .= 'Username and Password not found<br>';
        }
    }
}

if(isset($_POST['submitReg'])){
    $errMsg = '';
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $email = trim($_POST['email']);
    if($username == '')
        $errMsg .= 'You must enter your Username<br>';

    if($password == '')
        $errMsg .= 'You must enter your Password<br>';

    if($email == '')
        $errMsg .= 'You must enter your Email<br>';

    if($errMsg == '') {
        try {
            $pass = hash('gost', $password);
            $sql = $db->prepare("INSERT INTO user (username, password, email) VALUES (:username, :password, :email)");
            $sql->bindParam(':username', $username, PDO::PARAM_STR);
            $sql->bindParam(':password', $pass, PDO::PARAM_STR);
            $sql->bindParam(':email', $email, PDO::PARAM_STR);
            $sql->execute();
            $_SESSION['username'] = $username;
            $login = true;
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }
}

if (isset($_GET["logout"])) {
    $login = false;
    header("Location: index.php");
}

require("header.php");

if (!isset($login) || $login == false) {
    echo '<h2 class="welcome">Welcome to Camagru, please login or register</h2>';
    if (isset($_GET["register"])) {
        require("register.php");
    }
    else
        require("login.php");
}
else
    require("welcome.php");

echo '<br>';

require("footer.php");
?>
