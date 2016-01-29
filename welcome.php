<h1 style="text-align:center;">Take a picture and make your own montage!</h1>

<div id="radioGroup">
   <?php
        for ($i = 1; $i <= 6; $i++) {
            echo '<div class="wrap">
            <img width="100px" src="faces/'.$i.'.png"/>
            <input type="radio" name="mark" id="markStudent" value="Student" />
            </div>';
        }
    ?>
</div>

<br>

<div class="camera">
    <video id="video">Video stream not available.</video>
    <br>
    <button id="startbutton">Take photo</button>
</div>

<br>

<canvas id="canvas">
</canvas>

<script type="text/javascript" src="js/script.js"></script>
