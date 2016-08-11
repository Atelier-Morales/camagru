<?php
/**
 * Created by PhpStorm.
 * User: fmorales
 * Date: 8/11/16
 * Time: 11:02 AM
 */

?>

<div align="center">
    <br />
    <div style="width:400px; border: solid 1px #006D9C; " align="left">
        <?php
        if (isset($errMsgReset)){
            echo '<div style="color:#FF0000;text-align:center;font-size:24px;">'.$errMsgReset.'</div>';
        }

        if (isset($temp_user) && !isset($errMsgReset)) {
            if(isset($errMsgPass)){
                echo '<div style="color:#FF0000;text-align:center;font-size:12px;">'.$errMsgPass.'</div>';
            }
            echo '<div style="background-color:#006D9C; color:#FFFFFF; padding:3px;"><b>Type a new password for '
                . htmlspecialchars($temp_user, ENT_QUOTES, "UTF-8") .'</b></div>';
            echo '<div style="margin:30px">
                    <form action="" method="post">
                        <input type="text" name="check-username" class="box" value="'.
                htmlspecialchars($temp_user, ENT_QUOTES, "UTF-8").'" style="display: none"/>
                        <label>New Password :</label>
                        <input type="password" name="password" class="box" />
                        <br/><br>
                        <label>Confirm Password :</label>
                        <input type="password" name="passwordConfirm" class="box" />
                        <br/>
                        <br />
                        <input type="submit" name=\'submitNewPass\' value="submit new password" class=\'submit\' />
                        <br />
                    </form>
                </div>';
        }
        else if (!isset($temp_user)) {
            if(isset($errMsg)){
                echo '<div style="color:#FF0000;text-align:center;font-size:12px;">'.$errMsg.'</div>';
            }
            echo '<div style="background-color:#006D9C; color:#FFFFFF; padding:3px;"><b>Type your username</b></div>';
            echo '<div style="margin:30px">
                    <form action="" method="post">
                        <label>Username :</label>
                        <input style="width: 75%;" type="text" name="username" class="box" />
                        <br/>
                        <br />
                        <input type="submit" name=\'usernameCheck\' value="send reset email" class=\'submit\' />
                        <br />
                    </form>
                </div>';
        }
        ?>
    </div>
    <br>
    <a href="index.php">Back</a>
</div>
