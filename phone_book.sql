-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Окт 08 2020 г., 04:05
-- Версия сервера: 5.7.25
-- Версия PHP: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `phone_book`
--

-- --------------------------------------------------------

--
-- Структура таблицы `items`
--

CREATE TABLE `items` (
  `id` int(10) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `user` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `items`
--

INSERT INTO `items` (`id`, `first_name`, `last_name`, `phone`, `email`, `image`, `user`) VALUES
(1, 'Кристофер', 'Нолан', '+7(900)185-55-66', 'test1@test.ru', '', 12),
(2, 'Джон Дэвид', 'Вашингтон', '+7(900)183-25-36', 'test2@test.ru', '44793.jpg', 13),
(3, 'Роберт', 'Паттинсон', '+7(903)253-45-96', 'test3@test.ru', '68135.jpg', 14),
(4, 'Элизабет', 'Дебики', '+7(900)569-35-89', 'test4@test.ru', '58787.jpg', 13),
(5, 'Кеннет', 'Брана', '+7(903)568-54-89', 'test5@test.ru', '', 12),
(6, 'Аарон', 'Тейлор-Джонсон', '+7(900)123-54-89', 'test6@test.ru', '81760.jpg', 14),
(7, 'Майкл', 'Кейн', '+7(900)456-87-92', 'test7@test.ru', '42690.jpg', 12),
(8, 'Юрий', 'Колокольников', '+7(900)325-65-28', 'test8@test.ru', '', 13),
(9, 'Димпл', 'Кападиа', '+7(900)604-87-92', 'test9@test.ru', '', 12),
(10, 'Клеманс', 'Поэзи', '+7(900)654-87-90', 'test11@test.ru', '58358.jpg', 13),
(12, 'Джефферсон', 'Холл', '+7(900)645-87-82', 'test13@test.ru', '', 13),
(14, 'Иво', 'Уукиви', '+7(900)567-23-45', 'test14@test.ru', '26250.jpg', 12),
(15, 'Юхан', 'Ульфсак', '+7(900)325-65-55', 'test12@test.ru', '58932.jpg', 14),
(16, 'Рич', 'Кероло', '+7(900)727-43-24', 'test16@test.ru', '56462.jpg', 13),
(17, 'Джонатан', 'Кэмп', '+7(900)682-97-02', 'test17@test.ru', '', 12),
(18, 'Химеш', 'Патель', '+7(900)654-87-92', 'test10@test.ru', '', 12),
(20, 'Сэндер', 'Ребане', '+7(900)379-24-88', 'test19@test.ru', '', 14),
(21, 'Мартин', 'Донован', '+7(900)525-77-33', 'test20@test.ru', '', 13),
(23, 'Эндрю', 'Ховард', '+7(900)682-34-45', 'test15@test.ru', '26250.jpg', 12),
(28, 'Уэс', 'Чэтэм', '+7(900)555-55-22', 'test18@test.ru', '', 14);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `email` varchar(255) NOT NULL,
  `login` varchar(16) NOT NULL,
  `hash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Пользователи';

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `email`, `login`, `hash`) VALUES
(12, 'admin1@test.ru', 'authUser1', '$2y$10$/P9qmfoyFii45pNkoPc/b.SDDxI5l4M7J7PQBOSoJS7BrIdpeZmcm'),
(13, 'admin2@test.ru', 'authUser2', '$2y$10$8Ov55U0IBSI4TuEnMb4yAOcJZ6xxb3xIBNQJu.Z47ZBmn8vwJNXUG'),
(14, 'admin3@test.ru', 'authUser3', '$2y$10$H5iLmtADDXXru6wMUyZx.OL3lm2pnx2ReQJTtgaKqiBCNpko62EEG');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `items`
--
ALTER TABLE `items`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
