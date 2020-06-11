-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июн 11 2020 г., 22:17
-- Версия сервера: 5.6.41
-- Версия PHP: 7.0.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `school`
--

-- --------------------------------------------------------

--
-- Структура таблицы `children`
--

CREATE TABLE `children` (
  `id` int(5) NOT NULL,
  `fio` varchar(50) NOT NULL,
  `birthdate` date NOT NULL,
  `class` int(2) NOT NULL,
  `gender` varchar(1) NOT NULL,
  `parent_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `children`
--

INSERT INTO `children` (`id`, `fio`, `birthdate`, `class`, `gender`, `parent_id`) VALUES
(1, 'Иванов Андрей Иванович', '2013-04-01', 1, 'M', 8),
(2, 'Иванова Алина Ивановна', '2013-11-30', 1, 'F', 8),
(19, 'Сергеев Сергей Сергеевич', '2005-02-23', 5, 'M', 8),
(20, 'тест тест проверка', '2007-02-28', 2, 'M', 8),
(22, 'Иванова Алина Ивановнаа', '2001-02-28', 1, 'F', 10);

-- --------------------------------------------------------

--
-- Структура таблицы `messages`
--

CREATE TABLE `messages` (
  `id` int(3) NOT NULL,
  `mdate` datetime NOT NULL,
  `fio` varchar(100) NOT NULL,
  `email` varchar(30) NOT NULL,
  `message` text NOT NULL,
  `status` varchar(20) NOT NULL,
  `answer_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `messages`
--

INSERT INTO `messages` (`id`, `mdate`, `fio`, `email`, `message`, `status`, `answer_date`) VALUES
(3, '2020-04-05 21:48:42', 'Иванов. И.И.', 'oroz.asan97@gmail.com', 'Содержимое 1...\r\n      Lorem ipsum dolor sit amet, consectetur adipisicing elit. Suscipit sint perspiciatis vero possimus tempora dolore odit, fugit dolores consequuntur quo, delectus quis deleniti nemo qui rem voluptatem! At sunt quo ipsum commodi molestiae aliquam suscipit mollitia provident, aut libero culpa similique corrupti ipsam neque vel eligendi magnam unde quis maiores?', 'answered', '2020-04-06 23:05:16'),
(4, '2020-04-06 23:05:16', 'Иванов. И.И.', 'oroz.asan97@gmail.com', 'odit, fugit dolores consequuntur quo, delectus quis deleniti nemo qui rem voluptatem! At sunt quo ipsum commodi molestiae aliquam suscipit mollitia provident, aut libero culpa similique corrupti ipsam neque vel eligendi magnam unde quis maiores?', 'unanswered', NULL),
(5, '2020-06-09 11:22:56', 'Иванов. И.И.', 'oroz.asan97@gmail.com', 'текст', 'answered', '2020-06-09 11:31:40');

-- --------------------------------------------------------

--
-- Структура таблицы `notes`
--

CREATE TABLE `notes` (
  `id` int(5) NOT NULL,
  `children_id` int(5) NOT NULL,
  `school_id` int(5) NOT NULL,
  `meeting_date` datetime DEFAULT NULL,
  `status` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `notes`
--

INSERT INTO `notes` (`id`, `children_id`, `school_id`, `meeting_date`, `status`) VALUES
(1, 1, 2, '2020-06-04 15:44:00', 'Отказ'),
(2, 2, 2, NULL, NULL),
(4, 19, 2, '2020-06-04 20:02:00', 'Принят'),
(5, 20, 2, '2020-06-24 13:45:00', 'Принят'),
(6, 22, 2, '2020-06-12 13:00:00', 'Принят');

-- --------------------------------------------------------

--
-- Структура таблицы `page`
--

CREATE TABLE `page` (
  `school_id` int(5) NOT NULL,
  `title` varchar(20) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `page`
--

INSERT INTO `page` (`school_id`, `title`, `content`) VALUES
(2, 'Основная информация', '<h3>Добро пожаловать!</h3>\r\n<i>20.05.2020</i>\r\n<p align=\"center\">Вы находитесь на странице школы №6</p>\r\n<hr>'),
(2, 'Новости', '<h3>Тема</h3>\r\n10.06.2020\r\n<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad consequatur eum maxime sequi quibusdam natus ab fugit ratione quos facilis sit reiciendis aliquid assumenda, laudantium voluptates explicabo labore obcaecati voluptas molestiae debitis unde, veritatis ea.\r\n</p>'),
(17, 'Основная информация', '<h3>Первая тема школы</h3>'),
(3, 'Основная информация', '<h3>Первая тема школы</h3>'),
(5, 'Основная информация', '<h3>Первая тема школы</h3>'),
(6, 'Основная информация', '<h3>Первая тема школы</h3>'),
(2, 'Поступление в первый', '<h3>Внимание!</h3>\r\n08.06.2020\r\n<p>Уважаемые родители и т.д.</p>'),
(25, 'Основная информация', '<h3>Первая тема школы</h3>');

-- --------------------------------------------------------

--
-- Структура таблицы `parent`
--

CREATE TABLE `parent` (
  `id` int(11) NOT NULL,
  `name1` varchar(30) NOT NULL,
  `name2` varchar(30) NOT NULL,
  `name3` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `address` varchar(150) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `pass` varchar(100) NOT NULL,
  `code` varchar(100) DEFAULT NULL,
  `active` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `parent`
--

INSERT INTO `parent` (`id`, `name1`, `name2`, `name3`, `email`, `address`, `telephone`, `pass`, `code`, `active`) VALUES
(8, 'Иванова', 'Иван', 'Иванович', 'test@mail.ru', 'ул. Кремлевская, д 18. кв 1010', '89631228888', '5bcc00274344fa21f3ee3c3813a5fcaa', 'rVeToaCc6YPGq37jmbh2WDNuIQdnkylspL0MfEXOHgJZKR5xAw', 'YES'),
(10, 'Тест', 'Тест', 'Тест', 'oroz.asan97@gmail.com', 'ул.Красной Позиции, дом 2А, к 322', '89991234567', '3d8ca222c2891f09c66e5eb39840c5af', '0', 'YES');

-- --------------------------------------------------------

--
-- Структура таблицы `school`
--

CREATE TABLE `school` (
  `id` int(5) NOT NULL,
  `name` varchar(300) DEFAULT NULL,
  `address` varchar(150) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `director` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `shorttitle` varchar(50) DEFAULT NULL,
  `year` int(4) DEFAULT NULL,
  `ccount` int(5) DEFAULT NULL,
  `tcount` int(5) DEFAULT NULL,
  `cor1` varchar(10) DEFAULT NULL,
  `cor2` varchar(10) DEFAULT NULL,
  `startdate` date DEFAULT NULL,
  `enddate` date DEFAULT NULL,
  `active` varchar(5) NOT NULL DEFAULT 'false'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `school`
--

INSERT INTO `school` (`id`, `name`, `address`, `telephone`, `director`, `email`, `shorttitle`, `year`, `ccount`, `tcount`, `cor1`, `cor2`, `startdate`, `enddate`, `active`) VALUES
(2, 'Муниципальное бюджетное общеобразовательное учреждение &laquo;Гимназия №6&raquo; Приволжского района', '420139, г. Казань, ул. Ю.Фучика, д. 26', '+7(843)-268-08-77', 'Баклашова Ольга Николаевна', 'gymn06@yandex.ru', 'МБОУ &quot;Гимназия №6&quot;', 1990, 2156, 134, '55.741410', '49.216195', '2020-05-01', '2020-07-05', 'true'),
(3, 'Муниципальное бюджетное общеобразовательное учреждение «Татарская гимназия №1 им.Г.Тукая» Вахитовского района г. Казани', '420108, г. Казань, ул. Мазита Гафури, д. 34а', '	+7(843)-293-38-67', 'Шамсеева Гульфия Гаязовна', '	g1.kzn@tatar.ru', 'Татарская гимназия № 1', 1990, 595, 38, '55.793689', '49.104994', '2020-06-01', '2020-06-09', 'true'),
(5, 'МБОУ «Средняя общеобразовательная школа №82 с углубленным изучением отдельных предметов им.Р.Г.Хасановой» Приволжского района г. Казани', '420049, г. Казань, ул. Качалова, д. 107', '+7(843)-277-78-94', '	Скобелкина Эльмира Мансуровна', '	s82.kzn@tatar.ru', 'МБОУ школа № 82', 1936, 543, 46, '55.772852', '49.149578', '2020-06-01', '2020-06-09', 'true'),
(6, 'Муниципальное бюджетное образовательное учреждение \"Средняя общеобразовательная школа №98 (татарско-русская)\" Вахитовского района г. Казани', 'г. Казань, ул. А.Еники, 23', '	+7(843)-236-24-12', '	Авзалова Айгуль Ильдаровна', 'shkola98@yandex.ru', 'МБОУ школа № 98', 1939, 534, 52, '55.783330', '49.154479', '2020-06-01', '2020-06-09', 'false'),
(17, 'Муниципальное бюджетное общеобразовательное учреждение «Средняя общеобразовательная школа №51» Вахитовского района г. Казани', '420021, Республика Татарстан, г. Казань, ул. К. Тинчурина, д. 3', '+7(843)-293-25-93', 'Акмаева Анастасия Сергеевна', 'school51kazan@mail.ru', 'МБОУ \"Школа №51\"', 1963, 369, 37, '55.779007', '49.104748', NULL, NULL, 'true'),
(25, 'Муниципальное бюджетное общеобразовательное учреждение &laquo;Гимназия №21&raquo; Приволжского района г. Казани', '420110, г. Казань, ул. Зорге, д. 72', '+7(843)-268-84-87', 'Позднякова Лариса Геннадьевна', 'gim21@bk.ru', 'МБОУ &quot;Гимназия №21&quot;', 1976, 698, 56, '55.749891', '49.215281', '2020-06-01', '2020-07-01', 'true');

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` int(5) NOT NULL,
  `email` varchar(50) NOT NULL,
  `pass` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `school_id` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `email`, `pass`, `type`, `school_id`) VALUES
(1, 'testuser@mail.ru', '098f6bcd4621d373cade4e832627b4f6', 'moderator', 2),
(2, 'reg.school.system@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 'admin', NULL),
(4, 'gim21@bk.ru', '1fb0e331c05a52d5eb847d6fc018320d', 'moderator', 25);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `children`
--
ALTER TABLE `children`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Индексы таблицы `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notes_ibfk_1` (`school_id`),
  ADD KEY `notes_ibfk_2` (`children_id`);

--
-- Индексы таблицы `page`
--
ALTER TABLE `page`
  ADD KEY `school_id` (`school_id`);

--
-- Индексы таблицы `parent`
--
ALTER TABLE `parent`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `school`
--
ALTER TABLE `school`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `school_id` (`school_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `children`
--
ALTER TABLE `children`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT для таблицы `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `notes`
--
ALTER TABLE `notes`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `parent`
--
ALTER TABLE `parent`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `school`
--
ALTER TABLE `school`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `children`
--
ALTER TABLE `children`
  ADD CONSTRAINT `children_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `parent` (`id`);

--
-- Ограничения внешнего ключа таблицы `notes`
--
ALTER TABLE `notes`
  ADD CONSTRAINT `notes_ibfk_1` FOREIGN KEY (`school_id`) REFERENCES `school` (`id`),
  ADD CONSTRAINT `notes_ibfk_2` FOREIGN KEY (`children_id`) REFERENCES `children` (`id`);

--
-- Ограничения внешнего ключа таблицы `page`
--
ALTER TABLE `page`
  ADD CONSTRAINT `page_ibfk_1` FOREIGN KEY (`school_id`) REFERENCES `school` (`id`);

--
-- Ограничения внешнего ключа таблицы `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`school_id`) REFERENCES `school` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
