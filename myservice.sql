-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Мар 01 2017 г., 14:54
-- Версия сервера: 5.7.16-log
-- Версия PHP: 7.1.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `myservice`
--
CREATE DATABASE IF NOT EXISTS `myservice` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `myservice`;

-- --------------------------------------------------------

--
-- Структура таблицы `groups`
--
-- Создание: Мар 01 2017 г., 04:46
-- Последнее обновление: Мар 01 2017 г., 11:34
--

DROP TABLE IF EXISTS `groups`;
CREATE TABLE IF NOT EXISTS `groups` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '№ экскурсии',
  `user_id` int(11) NOT NULL COMMENT 'ID создателя',
  `name` varchar(100) NOT NULL COMMENT 'Название экскурсии',
  `description` text NOT NULL COMMENT 'Описание',
  `conditions` text NOT NULL COMMENT 'Требования к участникам',
  `date` varchar(30) NOT NULL COMMENT 'Дата проведения',
  `members` int(11) NOT NULL COMMENT 'Количество участников',
  `cost` int(11) NOT NULL COMMENT 'Стоимость',
  PRIMARY KEY (`group_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='Экскурсии + закрытые группы';

--
-- Дамп данных таблицы `groups`
--

INSERT INTO `groups` (`group_id`, `user_id`, `name`, `description`, `conditions`, `date`, `members`, `cost`) VALUES
(1, 2, 'Тестдрайв', 'Привет', '', '2017-03-17', 30, 13000),
(2, 2, 'Нету', 'Отсутствует', '', '2019-06-05', 32, 23455),
(3, 4, 'qqqqqqqqqqqqq', 'qqqqqqqqqqqqqqqq', 'qqqqqqqqqqqqqqqqqqqqq', '2017-03-17', 33, 333333),
(4, 5, 'wwwwwwwww', 'sdf', 'sdf', '2017-03-10', 33, 123);

-- --------------------------------------------------------

--
-- Структура таблицы `images`
--
-- Создание: Мар 01 2017 г., 03:41
-- Последнее обновление: Мар 01 2017 г., 11:34
--

DROP TABLE IF EXISTS `images`;
CREATE TABLE IF NOT EXISTS `images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `image` varchar(1024) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `images_ibfk_1` (`group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `images`
--

INSERT INTO `images` (`id`, `group_id`, `image`) VALUES
(1, 2, '/uploads/87bd49d5570101acbd515e01a5c4129b.jpg'),
(2, 2, '/uploads/a56c23bf490f2cd4c2ebb1678f7cdc51.jpg'),
(3, 2, '/uploads/c2305e269b1886ea1677f74741c9f53d.jpg'),
(4, 4, '/uploads/42deb9dec19d2c05b5f1c5261b11160d.jpg');

-- --------------------------------------------------------

--
-- Структура таблицы `members`
--
-- Создание: Мар 01 2017 г., 03:38
-- Последнее обновление: Мар 01 2017 г., 11:46
--

DROP TABLE IF EXISTS `members`;
CREATE TABLE IF NOT EXISTS `members` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '№ участника',
  `group_id` int(11) NOT NULL COMMENT '№ группы',
  `user_id` int(11) NOT NULL COMMENT '№ пользователя',
  `status` smallint(2) NOT NULL COMMENT 'Статус',
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='Список кто в какой группе состоит';

--
-- Дамп данных таблицы `members`
--

INSERT INTO `members` (`id`, `group_id`, `user_id`, `status`) VALUES
(3, 1, 1, 1),
(4, 1, 1, 0),
(5, 1, 3, 2),
(6, 1, 3, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `migration`
--
-- Создание: Мар 01 2017 г., 02:14
-- Последнее обновление: Мар 01 2017 г., 02:14
--

DROP TABLE IF EXISTS `migration`;
CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1488334464),
('m130524_201442_init', 1488334467);

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--
-- Создание: Мар 01 2017 г., 02:14
-- Последнее обновление: Мар 01 2017 г., 11:34
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'v1rMmG9sSoOZ4WaMIlkBAEr5WGGQD4-y', '$2y$13$aoM3hVRwMcUZBCczQQTd0e2s0pNIpajFAWpsHXHncbHoevhjS12bG', NULL, 'admin@webmaster.org', 10, 1488336136, 1488336136),
(2, 'test2', '9cqnpNxfEhAjDeHPmJNFIUg1QpgNXUGv', '$2y$13$1wbuUWzxXjVX.kBvFh6F5OdIcMtdKY24Mg16HgrsTpzOrYhgVuKw.', NULL, 'test@test.ru', 10, 1488341533, 1488341533),
(3, 'qwe', 'Q966eCRH1eXBfsi7qcrFx7JiOGzqf8QO', '$2y$13$ezXoLxGlxZUslXJgrd8ckuUMymtg2.nbuZ/pEejB2XKBaNNnfz/Hm', NULL, 'qwe@mail.ru', 10, 1488367153, 1488367153),
(4, 'ewq', 'Wj4m1Kj6NHpa0DJsSdTtMwBAan4w-7d2', '$2y$13$9C2mEJpiWr3GDZV07FfhoewcpqhJ0CUVzzDOBMfN6/NAzmd.cGDhq', NULL, 'admin@mail.ru', 10, 1488367283, 1488367283),
(5, 'qqq', 'FBE25a39wmYHv2cq6QHbxkM-BNcdZW7a', '$2y$13$PwEopYEgACzpzIxOlKJv4OPGzMeoaVJuY7kdC1f230LS0GiOZyk7a', NULL, 'qqqq@mail.ru', 10, 1488368067, 1488368067);

-- --------------------------------------------------------

--
-- Структура таблицы `user_info`
--
-- Создание: Мар 01 2017 г., 03:28
-- Последнее обновление: Мар 01 2017 г., 11:34
--

DROP TABLE IF EXISTS `user_info`;
CREATE TABLE IF NOT EXISTS `user_info` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL COMMENT 'Ваши ФИО',
  `genre` tinyint(1) NOT NULL COMMENT 'Ваш пол:',
  `phone` varchar(12) DEFAULT NULL COMMENT 'Ваш номер телефона',
  `about` text COMMENT 'О себе',
  `role` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Роль',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Информация о пользователях';

--
-- Дамп данных таблицы `user_info`
--

INSERT INTO `user_info` (`id`, `name`, `genre`, `phone`, `about`, `role`) VALUES
(1, 'Admin Adminov Adminovich', 0, '1234325412', 'Привет, чувак =)', 0),
(2, 'Test Test Test', 1, '7775521', 'Nobody', 1),
(3, 'qweqweqweq', 0, '123', '12312312312312', 0),
(4, 'qweqweqwe', 0, '123123', '112e', 1),
(5, 'qweqweqweq', 0, '1231', 'asdasdasd', 1);

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `groups`
--
ALTER TABLE `groups`
  ADD CONSTRAINT `groups_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `images_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`group_id`) ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `members`
--
ALTER TABLE `members`
  ADD CONSTRAINT `members_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`group_id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `members_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `user_info`
--
ALTER TABLE `user_info`
  ADD CONSTRAINT `user_info_ibfk_1` FOREIGN KEY (`id`) REFERENCES `user` (`id`) ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
