<?php
if (!isset($username) || $login == false) {
    header("Location: index.php");
}
?>

<script type="text/javascript" src="js/script.js"></script>

<div id="leftCol">
    <h3 style="text-align:center;">Your Pictures</h3>
    <br>
<!--    <img width="320" height="240" id="photo2" src=""/>-->
    <?php
    for ($i = 0; $i <= (count($pics) - 1); $i++) {
        echo '<img width="320" height="240" id="none" src="data:image/png;base64,'.base64_encode($pics[$i]["src"]).'"/>';
        echo
            '<div><p>'. $pics[$i]["title"] . ' (' . $pics[$i]["date"] .
            ') <button id="delete" onclick="deleteLink(\''.$pics[$i]["id"].
            '\',\''.$pics[$i]["user_id"].'\')">X</button></p></div>';
    }
    ?>
</div>

<div id="content">
    <h1 style="text-align:center;">Take a picture and make your own montage!</h1>

    <div id="radioGroup">
        <?php
        for ($i = 1; $i <= 6; $i++) {
            echo '<div class="wrap">
            <img src="faces/'.$i.'.png"/>
            <input type="radio" name="mark" id="markStudent'.$i.'" value="Student" />
            </div>';
        }
        ?>
    </div>

    <div>
        <div id="demo"></div>
    </div>

    <br>

    <div class="camera">
        <video id="video">Video stream not available.</video>
        <br>
        <button id="startbutton">Take a photo</button>

        <br><br><br>

        <p>Preview :</p>
        <img width="320" height="240" id="photo2" src=""/>
        <br><br>
        <input type="text" name="photoTitle" id="photoTitle" placeholder="choose a title..."/>
        <button id="savebutton">save photo</button>
    </div>
    <br>
    <div class="upload">
        <form id="image_upload_form" method="post" enctype="multipart/form-data">
            Select image to upload:
            <input type="file" name="photo" id="fileToUpload">
            <input type="submit" value="Upload Image" id="submitFile" name="submitFile">
        </form>
    </div>


    <canvas id="canvas">
    </canvas>

    <img width="320" height="240" id="photo" src=""/>
</div>


