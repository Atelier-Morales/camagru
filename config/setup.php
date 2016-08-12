<?php
require("./database.php");

try {
    $user_table = $db->prepare("CREATE TABLE `test`.`user`
        (
            `id` INT NOT NULL AUTO_INCREMENT,
            `username` VARCHAR(64) NOT NULL,
            `email` VARCHAR(140) NOT NULL,
            `password` CHAR(64) NOT NULL,
            PRIMARY KEY (`id`),
            UNIQUE (`username`)
        )
        ENGINE = InnoDB");
    $user_table->execute();

    try {
        $pictures_table = $db->prepare("CREATE TABLE `test`.`pictures`
        (
            `id` INT NOT NULL AUTO_INCREMENT,
            `src` LONGBLOB NOT NULL,
            `title` VARCHAR(64) NOT NULL ,
            `date` VARCHAR(64) NOT NULL,
            `user_id` INT NOT NULL,
            PRIMARY KEY (`id`)
        )
        ENGINE = InnoDB");
        $pictures_table->execute();

        try {
            $likes_table = $db->prepare("CREATE TABLE `test`.`Likes`
            (
                `id` INT NOT NULL AUTO_INCREMENT,
                `username` VARCHAR(64) NOT NULL,
                `picture_id`  INT NOT NULL,
                PRIMARY KEY (`id`)
            )
            ENGINE = InnoDB");
            $likes_table->execute();

            try {
                $comment_table = $db->prepare("CREATE TABLE `test`.`Comments`
                (
                    `id` INT NOT NULL AUTO_INCREMENT,
                    `username` VARCHAR(64) NOT NULL,
                    `picture_id`  INT NOT NULL,
                    `comment` VARCHAR(64) NOT NULL,
                    `date_published` VARCHAR(64) NOT NULL,
                    PRIMARY KEY (`id`)
                )
                ENGINE = InnoDB");
                $comment_table->execute();

                echo "database scheme creation successful !";
            }
            catch (PDOException $e) {
                echo "error : could not create the table likes";
            }
        }
        catch (PDOException $e) {
            echo "error : could not create the table likes";
        }
    }
    catch (PDOException $e) {
        echo $e->getMessage();
        echo "error : could not create the Table pictures";
    }
}
catch (PDOException $e) {
    echo $e->getMessage();
    echo "error : could not create the tables in the db";
}

?>