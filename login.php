
<div align="center">
    <br />
    <div style="width:300px; border: solid 1px #006D9C; " align="left">
        <?php
        if(isset($errMsg)){
            echo '<div style="color:#FF0000;text-align:center;font-size:12px;">'.$errMsg.'</div>';
        }
        if (isset($reset_success) && strlen($reset_success) > 0){
            echo '<div style="color:#2c845d;text-align:center;font-size:12px;">' .$reset_success.'</div>';
        }
        ?>
        <div style="background-color:#006D9C; color:#FFFFFF; padding:3px;"><b>Login</b></div>
        <div style="margin:30px">
            <form action="" method="post">
                <label>Username :</label>
                <input type="text" name="username" class="box" />
                <br />
                <br />
                <label>Password :</label>
                <input type="password" name="password" class="box" />
                <br/><br>
                <a href="index.php?resetpass"><small>Forgot password</small></a>
                <br /><br>
                <input type="submit" name='submit' value="Submit" class='submit' />
                <br />
            </form>
        </div>
    </div>
    <br>
    <a href="index.php?register">Register</a>
</div>
