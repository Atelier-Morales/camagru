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

    function fetchComments($index, $comments) {
        $picture_comments = array();
        for ($n = 0; $n < count($comments); $n++) {
            if ($comments[$n]["picture_id"] == $index) {
                $output = '[\''. $comments[$n]["username"] . '\',\'' . $comments[$n]["comment"] .'\',\''. $comments[$n]["date_published"] .'\']';
                array_push($picture_comments, $output);
            }
        }
        return $picture_comments;
    }

    for ($i = 0; $i <= (count($pictures) - 1); $i++) {
        $like_array = '[';
        $pic_likes = fetchLikes($pictures[$i]["id"], $likes);
        for ($f = 0; $f < count($pic_likes); $f++) {
            $like_array .= '\''.$pic_likes[$f].'\'';
            if ($f + 1 != count($pic_likes))
                $like_array .= ',';
        }
        $like_array .= ']';

        $comment_array = '[';
        $pic_comments = fetchComments($pictures[$i]["id"], $comments);
        for ($q = 0; $q < count($pic_comments); $q++) {
            $comment_array .= $pic_comments[$q];
            if ($q + 1 != count($pic_comments))
                $comment_array .= ',';
        }
        $comment_array .= ']';
        echo '<div class="columns">
            <div class="card">
                <div class="image">
                    <div class="image-wrapper overlay-fade-in">
                        <img width="527px" id="' . $pictures[$i]["id"] . '" height="350" src="data:image/png;base64,' . base64_encode($pictures[$i]["src"]) . '">
                        <span class="title" id="image-title' . $i . '">' . htmlspecialchars($pictures[$i]["title"], ENT_QUOTES, "UTF-8") . '</span>
                        <div onmouseenter="mouseEnter(\'' . $i . '\')" onmouseleave="mouseLeave(\'' . $i . '\')" class="image-overlay-content" onclick="openModal(
                        \'' . $username . '\',
                        \'' . htmlspecialchars($pictures[$i]["title"], ENT_QUOTES, "UTF-8") . '\',
                        \'' . $pictures[$i]["date"] . '\',
                        \'' . $pictures[$i]["username"] . '\',
                        \'' . $pictures[$i]["id"] . '\',
                        ' . htmlspecialchars($like_array, ENT_QUOTES, "UTF-8") .',
                        ' . htmlspecialchars($comment_array, ENT_QUOTES, "UTF-8") . '
                        )">
                            <h2>' . htmlspecialchars($pictures[$i]["title"], ENT_QUOTES, "UTF-8") . '</h2>
                            <p style="top: 0px !important" class="title">Posted by ' . $pictures[$i]["username"] . ' on ' . $pictures[$i]["date"] . '</p>
                            
                            <p class="title">' . countLikes($pictures[$i]["id"], $likes) . ' likes / ' . countLikes($pictures[$i]["id"], $comments) . ' Comments</p><br>
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
        <div id="comment-section"></div>
        <br>
        <p>Comment this picture:</p>
        <textarea id="comment" style="width: 80%"></textarea>
        <br>
        <div id="publish-button"></div>
    </div>

</div>