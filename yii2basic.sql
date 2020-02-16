-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Хост: mysql-db:3306
-- Время создания: Апр 18 2019 г., 15:59
-- Версия сервера: 5.7.25
-- Версия PHP: 7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `yii2basic`
--

-- --------------------------------------------------------

--
-- Структура таблицы `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1551732450),
('m190304_205241_create_user_table', 1555179186),
('m190413_003923_create_vk_table', 1555179186);

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `paid_to` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `updated_at` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password_hash`, `reset_token`, `paid_to`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@admin.ru', '$2y$13$ZUWtzAFQ80sJQ9P5XIgaRe0jw729d1vm.zvNGknTA5ZyfNV0ROrjO', NULL, 'Thu, 18 Apr 2019 15:15:05 +0000', 'Mon, 15 Apr 2019 15:15:05 +0000', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `vk`
--

CREATE TABLE `vk` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `access_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lastname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `avatar_link` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `vk`
--

INSERT INTO `vk` (`id`, `user_id`, `access_token`, `name`, `lastname`, `avatar_link`) VALUES
(1, 1, 'f028f851af403077d77a517cf7eaf017794d854389f178a4e73ca402571d6f2d9246bf2594c8ca835d3b5', 'Alx', 'Drago', 'https://pp.userapi.com/c840633/v840633961/2de0f/c6i6TuA1U5U.jpg?ava=1');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `vk`
--
ALTER TABLE `vk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-vk-user_id` (`user_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `vk`
--
ALTER TABLE `vk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `vk`
--
ALTER TABLE `vk`
  ADD CONSTRAINT `fk-vk-user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
