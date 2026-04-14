CREATE DATABASE IF NOT EXISTS `user_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE `user_db`;

-- Tabel tbl_user
CREATE TABLE IF NOT EXISTS `tbl_user` (
    `Id`         INT(10)      NOT NULL AUTO_INCREMENT,
    `Username`   VARCHAR(128) NOT NULL,
    `Password`   VARCHAR(255) NOT NULL COMMENT 'Menggunakan password_hash() bcrypt, butuh minimal 60 karakter',
    `CreateTime` DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `tbl_user` (`Username`, `Password`, `CreateTime`) VALUES
('hanandia', '$2y$10$tsEI3a4jrBeNdKAlQNC1yeI4M/szE6ebcIuvRWHSZzi4fCb8O0tXO', '2007-02-21 00:00:00'),
('Eko Indrajit', '$2y$10$tsEI3a4jrBeNdKAlQNC1yeI4M/szE6ebcIuvRWHSZzi4fCb8O0tXO', '2007-02-21 00:00:00');
