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

    function countLikes($index, $likes) {
        $result = 0;
        for ($j = 0; $j < count($likes); $j++) {
            if ($likes[$j]["picture_id"] == $index)
                $result++;
        }
        return $result;
    }

    function fetchLikes($index, $likes) {
        $picture_likes = array();
        for ($k = 0; $k < count($likes); $k++) {
            if ($likes[$k]["picture_id"] == $index)
                array_push($picture_likes, $likes[$k]["username"]);
        }
        return $picture_likes;
    }

    for ($i = 0; $i <= (count($pictures) - 1); $i++) {
        $like_array = '[';
        $pic_likes = fetchLikes($pictures[$i]["id"], $likes);
        for ($f = 0; $f < count($pic_likes); $f++) {
            $like_array = $like_array.'\''.$pic_likes[$f].'\'';
            if ($f + 1 != count($pic_likes))
                $like_array = $like_array . ',';
        }
        $like_array = $like_array . ']';
        echo '<div class="columns">
            <div class="card">
                <div class="image">
                    <div class="image-wrapper overlay-fade-in">
                        <img width="527px" id="' . $pictures[$i]["id"] . '" height="350" src="data:image/png;base64,' . base64_encode($pictures[$i]["src"]) . '">
                        <span class="title" id="image-title' . $i . '">' . $pictures[$i]["title"] . '</span>
                        <div onmouseenter="mouseEnter(\'' . $i . '\')" onmouseleave="mouseLeave(\'' . $i . '\')" class="image-overlay-content" onclick="openModal(
                        \'' . $username . '\',
                        \'' . $pictures[$i]["title"] . '\',
                        \'' . $pictures[$i]["date"] . '\',
                        \'' . $pictures[$i]["username"] . '\',
                        \'' . $pictures[$i]["id"] . '\',
                        ' . $like_array .'
                        )">
                            <h2>' . $pictures[$i]["title"] . '</h2>
                            <p class="title">Posted by ' . $pictures[$i]["username"] . ' on ' . $pictures[$i]["date"] . '</p>
                            <p class="title">' . countLikes($pictures[$i]["id"], $likes) . ' likes</p>
                        </div>
                    </div>
                </div>
        </div>
        </div>';
    }



    ?>

</div>



<!-- The Modal -->
<div id="myModal" class="modal">

    <!-- Modal content -->
    <div class="modal-content">
        <span class="close" onclick="closeModal()">x</span>
        <p  class="modal-title" id="modal-title"></p>
        <img width="80%" id="imageView" src="">
        <p id="likes"></p>
        <p id="like-button"></p>
    </div>

</div>