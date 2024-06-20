CREATE DATABASE IF NOT EXISTS `contact_list` CHARACTER SET utf8 COLLATE utf8_general_ci;

USE `contact_list`;

CREATE TABLE IF NOT EXISTS `Category` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `description` VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `Contact` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255)  NOT NULL,
    `lastname` VARCHAR(255)  NOT NULL,
    `email` VARCHAR(255)  NOT NULL,
    `cellphone` VARCHAR(255)  NOT NULL,
    `category_id` INT,
    FOREIGN KEY (`category_id`) REFERENCES `Category` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;