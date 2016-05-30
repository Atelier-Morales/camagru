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
        $sql = 'SELECT id, username, email, password FROM user WHERE username = :username OR email = :email';
        $records = $db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $records->execute(array(':username' => $username, ':email' => $username));
        $results = $records->fetchAll();
        $hashPass = hash('gost', $password);
        if(count($results[0]) > 0 && strcmp($hashPass, $results[0]['password']) == 0) {
            $username = $results[0]['username'];
            $login = true;
            $_SESSION['username'] = $username;
        } else {
            unset($username);
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
        $pass = hash('gost', $password);
        $codedInfo = base64_encode($username . ' ' . $email . ' ' . $pass);
        $headers = "From: test@mydomain.com";
        $msg = "Hello " . $username . "\r\n" .
            "In order to complete your registration, please validate your account via this link :"
            . "\r\n" .
            "http://localhost:8080/index.php?token=" . $codedInfo
            . "\r\n" .
            "Thank you," . "\r\n" .
            "The Camagru Team";
        mail($email,"Camagru : Validate your account",$msg, $headers);
        unset($username);
        $confirm = true;
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
        $_SESSION['username'] = $token[0];
        $username = $token[0];
        $login = true;
        $welcome = true;
    } catch(PDOException $e) {
        echo $e->getMessage();
    }
}

if (isset($_GET["logout"])) {
    $login = false;
    unset($username);
    unset($_SESSION['username']);
    header("Location: index.php");
}

require("ajax.php");

require("header.php");

if (!isset($login) || $login == false) {
    if (isset($_GET["register"])) {
        if (isset($confirm) && $confirm == true) {
            echo '<h2 class="welcome">Please click on the link you have received by email</h2>';
        }
        else {
            echo '<h2 class="welcome">Welcome to Camagru, please login or register</h2>';
            require("register.php");
        }
    }
    else {
        echo '<h2 class="welcome">Welcome to Camagru, please login or register</h2>';
        require("login.php");
    }
}
else {
    $sql = 'SELECT src, title, date 
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
        $message = "welcome to camagru, ". $username;
        echo '<script type="text/javascript">'
        , 'window.alert("' . $message . '");'
        , '</script>'
        ;
    }
}

echo '<br>';

require("footer.php");
?>
