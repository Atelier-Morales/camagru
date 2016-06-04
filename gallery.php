<?php
/**
 * Created by PhpStorm.
 * User: Fernan
 * Date: 03/06/2016
 * Time: 02:25
 */


?>

<h1 style="text-align: center; font-family: helvetica;">Gallery</h1>

<div id="content2" class="row">
    <?php
    for ($i = 0; $i <= (count($pictures) - 1); $i++) {
        echo '<div class="columns">
            <div class="card">
                <div class="image">
                    <img width="527px" height="350" src="data:image/png;base64,' . base64_encode($pictures[$i]["src"]) . '">
                    <span class="title">' . $pictures[$i]["title"] . '</span>
                </div>
                <div class="content">
                    <p>Posted by ' . $pictures[$i]["username"] . ' on ' . $pictures[$i]["date"] . '</p>
                </div>
            <div class="action">
                <a href=\'#\'>view Picture</a>
            </div>
        </div>
        </div>';
    }
    ?>

<!--    <div class="columns">-->
<!--        <div class="card">-->
<!--            <div class="image">-->
<!--                <img src="http://static.pexels.com/wp-content/uploads/2014/07/alone-clouds-hills-1909-527x350.jpg">-->
<!--                <span class="title">Road Warrior</span>-->
<!--            </div>-->
<!--            <div class="content">-->
<!--                <p>I shall be telling this with a sigh . Somewhere ages and ages hence: Two roads diverged in a wood,-->
<!--                    and I — I took the one less traveled by. And that has made all the difference.</p>-->
<!--            </div>-->
<!--            <div class="action">-->
<!--                <a href='#'>Where this leads</a>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->

</div>
