<?php
//if (!isset($username) || $login == false) {
//    header("Location: index.php");
//}
?>

<div align="center">
    <br />
    <div style="width:300px; border: solid 1px #006D9C; " align="left">
        <?php
        if(isset($errMsg)){
            echo '<div style="color:#FF0000;text-align:center;font-size:12px;">'.$errMsg.'</div>';
        }
        ?>
        <div style="background-color:#006D9C; color:#FFFFFF; padding:3px;"><b>Register</b></div>
        <div style="margin:30px">
            <form action="" method="post">
                <label>Username :</label>
                <input type="text" name="username" class="box" />
                <br />
                <br />
                <label>Email Address:</label>
                <input type="email" name="email" class="box" />
                <br />
                <br />
                <label>Password :</label>
                <input type="password" name="password" class="box" />
                <br/>
                <br />
                <input type="submit" name='submitReg' value="Submit Registration" class='submit' />
                <br />
            </form>
        </div>
    </div>
    <br>
    <a href="index.php">Login</a>
</div>
