<?php
/**
 * Created by PhpStorm.
 * User: Fernan
 * Date: 26/05/2016
 * Time: 00:45
 */
function base64_to_jpeg($base64_string, $output_file) {
    $ifp = fopen($output_file, "wb");

    $data = explode(',', $base64_string);

    fwrite($ifp, base64_decode($data[1]));
    fclose($ifp);

    return $output_file;
}

$data = json_decode(file_get_contents('php://input'), true);
$pictureName = $data["url"];
error_log($pictureName);
base64_to_jpeg($pictureName, 'faces/test1.jpg');

?>