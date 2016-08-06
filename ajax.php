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
require("config/database.php");

if (isset($data["id_delete"])) {
    try {
        $sql = $db->prepare('DELETE FROM pictures WHERE id = :id AND user_id = :user_id');
        $sql->bindParam(':id', $data["id_delete"]);
        $sql->bindParam(':user_id' , $data["user_id"]);
        $db->beginTransaction();
        $sql->execute();
        $db->commit();
        if ($sql)
            echo "success";
        else
            echo "fail";
    }
    catch(PDOException $ex) {
        echo "An Error occured! : ".$ex->getMessage();
    }
}

if (isset($data["title"])) {

    $username = $_SESSION['username'];
    $fp = fopen('temp/blend.png', 'rb'); // read binary
    try {
        $sql = $db->prepare('INSERT INTO pictures (user_id, src, title, date) VALUES ((SELECT id FROM user WHERE username = :username), :src, :title, :date)');
        $sql->bindParam(':username', $username, PDO::PARAM_STR);
        $sql->bindParam(':src' , $fp, PDO::PARAM_LOB);
        $sql->bindParam(':title' , $data["title"]);
        $sql->bindParam(':date' , $data["date"]);
        //$records = $db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $db->beginTransaction();
        $sql->execute();
        $db->commit();
        if ($sql)
            echo "success";
        else
            echo "fail";
    }
    catch(PDOException $ex) {
        echo "An Error occured! : ".$ex->getMessage();
    }
}

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

if (isset($data["picture_to_like"])) {
    $username = $_SESSION['username'];
    try {
        $sql = $db->prepare('INSERT INTO likes (username, picture_id) VALUES(:username, :picture_id)');
        $sql->bindParam(':username', $username, PDO::PARAM_STR);
        $sql->bindParam(':picture_id' , $data["picture_to_like"]);
        $db->beginTransaction();
        $sql->execute();
        $db->commit();
        if ($sql)
            echo "success";
        else
            echo "fail";
    }
    catch(PDOException $ex) {
        echo "An Error occured! : ".$ex->getMessage();
    }
}

if (isset($data["picture_to_unlike"])) {
    $username = $_SESSION['username'];
    try {
        $sql = $db->prepare('DELETE FROM likes WHERE picture_id = :picture_id AND username = :username');
        $sql->bindParam(':username', $username, PDO::PARAM_STR);
        $sql->bindParam(':picture_id' , $data["picture_to_unlike"]);
        $db->beginTransaction();
        $sql->execute();
        $db->commit();
        if ($sql)
            echo "success";
        else
            echo "fail";
    }
    catch(PDOException $ex) {
        echo "An Error occured! : ".$ex->getMessage();
    }
}

if (isset($data["modal_id"])) {

    function fetchLikes($index, $likes) {
        $picture_likes = array();
        for ($k = 0; $k < count($likes); $k++) {
            if ($likes[$k]["picture_id"] == $index)
                array_push($picture_likes, $likes[$k]["username"]);
        }
        return $picture_likes;
    }

    $pic_id = $data["modal_id"];
    //fetch pictures first
    $sql = 'SELECT pic.id, pic.src, pic.title, pic.date, us.username 
                FROM pictures pic INNER JOIN user us ON pic.user_id = us.id';
    $records = $db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    $records->execute();
    $pictures = $records->fetchAll();

    //then likes
    $sql2 = 'SELECT username, picture_id FROM likes';
    $records2 = $db->prepare($sql2, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    $records2->execute();
    $likes = $records2->fetchAll();
    $found = -1;
    for ($index = 0; $index < count($pictures); $index++) {
        if ($pictures[$index]["id"] == $pic_id) {
            $found = $index;
            $like_array = '';
            $pic_likes = fetchLikes($pictures[$index]["id"], $likes);
            for ($f = 0; $f < count($pic_likes); $f++) {
                $like_array = $like_array . $pic_likes[$f];
                if ($f + 1 != count($pic_likes))
                    $like_array = $like_array . ';';
            }
            break ;
        }
    }
    if ($found > -1) {
        $username = $_SESSION['username'];
        echo $username. ',' .
            $pictures[$found]["title"] . ','.
            $pictures[$found]["date"] . ',' .
            $pictures[$found]["username"] . ',' .
            $pictures[$found]["id"] . ',' .
            $like_array;
    }
    else
        echo "fail";
}

?>