CREATE DATABASE `common-database`;
USE `common-database`;

CREATE TABLE `users`
(
  `id` int PRIMARY KEY AUTO_INCREMENT COMMENT 'auto increment',
  `mail` varchar(255),
  `pseudo` varchar(255),
  `password` varchar(255)
);

CREATE TABLE `user_info`
(
  `id_user` int PRIMARY KEY,
  `birthdate` date,
  `pays` varchar(255),
  `name` varchar(255),
  `surname` varchar(255)
);

CREATE TABLE `post`
(
  `id_post` int PRIMARY KEY AUTO_INCREMENT COMMENT 'auto increment',
  `id_user` int,
  `post_content` varchar(255),
  `post_date` date,
  `hashtags` text,
  `hasMedia` boolean,
  `media_id` int
);

CREATE TABLE `follow`
(
  `id_user` int PRIMARY KEY,
  `follows` longtext
);

CREATE TABLE `media`
(
  `id_media` int PRIMARY KEY AUTO_INCREMENT COMMENT 'auto increment',
  `media` blob
);

CREATE TABLE `messages`
(
  `message_id` int PRIMARY KEY AUTO_INCREMENT COMMENT 'auto increment',
  `from_id` int,
  `to_id` int,
  `message_content` text,
  `message_date` date
);

CREATE TABLE `comments`
(
  `id_comment` int PRIMARY KEY AUTO_INCREMENT COMMENT 'Auto increment',
  `id_post` int,
  `id_user` int,
  `content` varchar(255),
  `comment_date` date
);


ALTER TABLE `post` ADD FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

ALTER TABLE `follow` ADD FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

ALTER TABLE `messages` ADD FOREIGN KEY (`to_id`) REFERENCES `users` (`id`);

ALTER TABLE `messages` ADD FOREIGN KEY (`from_id`) REFERENCES `users` (`id`);

ALTER TABLE `user_info` ADD FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

ALTER TABLE `comments` ADD FOREIGN KEY (`id_post`) REFERENCES `post` (`id_post`);

