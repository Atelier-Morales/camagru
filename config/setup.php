

likes :

CREATE TABLE Likes(
id   INT              NOT NULL,
username VARCHAR (20)     NOT NULL,
picture_id  INT              NOT NULL,
PRIMARY KEY (id)
);

table USER :

CREATE TABLE `test`.`user`
(
    `id` INT NOT NULL AUTO_INCREMENT ,
    `username` VARCHAR(64) NULL DEFAULT NULL ,
    `email` VARCHAR(140) NOT NULL ,
    `password` CHAR(64) NOT NULL ,
    PRIMARY KEY (`id`),
    UNIQUE (`username`),
    UNIQUE (`password`)
)
ENGINE = InnoDB;