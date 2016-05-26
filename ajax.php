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
if (isset($data["url"])) {
    $face = $data["face"];
    $pictureName = $data["url"];
    $facePicture = 'faces/' . $face . '.png';
    base64_to_jpeg($pictureName, 'temp/preview.png');

    $dest = imagecreatefrompng("temp/preview.png");
    $src = imagecreatefrompng($facePicture);

//    imagealphablending($image_1, true);
//    imagesavealpha($image_1, true);
//    imagecopy($image_1, $image_2, 0, 0, 0, 0, 100, 100);
//    imagepng($image_1, 'image_3.png')

    imagealphablending($dest, true);
    imagesavealpha($dest, true);

    imagecopy($dest, $src, 100, 0, 0, 0, 100, 142); //have to play with these numbers for it to work for you, etc.

    header('Content-Type: image/png');
    imagepng($dest, 'temp/blend.png');

    imagedestroy($dest);
    imagedestroy($src);

    echo('temp/blend.png');
}

?>