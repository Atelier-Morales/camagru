<h1 style="text-align:center;">Take a picture and make your own montage!</h1>

<div id="radioGroup">
   <?php
        for ($i = 1; $i <= 6; $i++) {
            echo '<div class="wrap">
            <img width="100px" src="faces/'.$i.'.png"/>
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
</div>

<br>

<canvas id="canvas">
</canvas>

<img width="320" height="240" id="photo" src=""/>

<img width="320" height="240" id="photo2" src=""/>


<script type="text/javascript" src="js/script.js"></script>
