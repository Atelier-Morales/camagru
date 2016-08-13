<?php
/**
 * Created by PhpStorm.
 * User: Fernan
 * Date: 03/06/2016
 * Time: 02:25
 */

if (!isset($username) || $login == false) {
    header("Location: index.php");
}

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

    for ($i = 0; $i <= (count($pictures) - 1) && $i <= 5; $i++) {
        echo '<div class="columns" id="column-card">
            <div class="card">
                <div class="image">
                    <div class="image-wrapper overlay-fade-in">
                        <img width="527px" id="' . $pictures[$i]["id"] . '" height="350" src="data:image/png;base64,' . base64_encode($pictures[$i]["src"]) . '">
                        <span class="title" id="image-title' . $i . '">' . htmlspecialchars($pictures[$i]["title"], ENT_QUOTES, "UTF-8") . '</span>
                        <div onmouseenter="mouseEnter(\'' . $i . '\')" onmouseleave="mouseLeave(\'' . $i . '\')" class="image-overlay-content" onclick="sendAjaxToOpenModal(
                        \'' . $pictures[$i]["id"] . '\'
                        )">
                            <h2>' . htmlspecialchars($pictures[$i]["title"], ENT_QUOTES, "UTF-8") . '</h2>
                            <p style="top: 0px !important" class="title">Posted by ' . htmlspecialchars($pictures[$i]["username"], ENT_QUOTES, "UTF-8") . ' on ' . $pictures[$i]["date"] . '</p>
                            
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

<?php echo '<script type="text/javascript" src="js/gallery.js"></script>'; ?>