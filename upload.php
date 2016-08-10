<?php
/**
 * Created by PhpStorm.
 * User: Fernan
 * Date: 31/05/2016
 * Time: 00:27
 */
if (isset($_POST)) {
    if (isset($_FILES["photo"])) {
        try {
            $fileName = $_FILES["photo"]["name"]; // The file name
            $fileTmpLoc = $_FILES["photo"]["tmp_name"];
            $fileType = $_FILES["photo"]["type"];

            if ($fileType != "image/jpeg" && $fileType != "image/png")
                throw new Exception("Please choose another format");
            else if (!$fileTmpLoc) {
                throw new Exception("Please upload a picture");
            }
            else {
                $fileSize = $_FILES["photo"]["size"];
                $fileErrorMsg = $_FILES["photo"]["error"];
                $fileFace = $_POST["face"];

                $facePicture = 'faces/' . $fileFace . '.png';
                move_uploaded_file($fileTmpLoc, "temp/preview.png");
                $dest = imagecreatefromstring(file_get_contents('temp/preview.png'));
                $src = imagecreatefrompng($facePicture);

                imagealphablending($dest, true);
                imagesavealpha($dest, true);

                imagecopy($dest, $src, 100, 0, 0, 0, 100, 142); //have to play with these numbers for it to work for you, etc.

                header('Content-Type: image/png');
                imagepng($dest, 'temp/blend.png');

                imagedestroy($dest);
                imagedestroy($src);
                echo('temp/blend.png');
            }
        }
        catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}

?>