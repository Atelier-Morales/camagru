<?php
/**
 * Created by PhpStorm.
 * User: Fernan
 * Date: 31/05/2016
 * Time: 00:27
 */
if (isset($_POST)) {
    $fileName = $_FILES["photo"]["name"]; // The file name
    $fileTmpLoc = $_FILES["photo"]["tmp_name"];
    $fileType = $_FILES["photo"]["type"];
    $fileSize = $_FILES["photo"]["size"];
    $fileErrorMsg = $_FILES["photo"]["error"];
    if (!$fileTmpLoc) {
        echo "ERROR: Please browse for a file before clicking the upload button.";
    }
    if(move_uploaded_file($fileTmpLoc, "temp/$fileName")) {
        echo "$fileName upload is complete";
    }
    else {
        echo "move_uploaded_file function failed";
    }
}

?>