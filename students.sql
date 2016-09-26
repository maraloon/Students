-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Июл 16 2016 г., 12:22
-- Версия сервера: 10.1.13-MariaDB
-- Версия PHP: 7.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `students`
--

-- --------------------------------------------------------

--
-- Структура таблицы `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `hash` varchar(200) NOT NULL,
  `name` varchar(200) NOT NULL,
  `sname` varchar(200) NOT NULL,
  `group_num` varchar(5) NOT NULL,
  `points` int(3) NOT NULL,
  `gender` enum('m','f') NOT NULL,
  `email` varchar(200) NOT NULL,
  `b_year` year(4) NOT NULL COMMENT 'Birthday year',
  `is_resident` enum('resident','foreign') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `students`
--

INSERT INTO `students` (`id`, `hash`, `name`, `sname`, `group_num`, `points`, `gender`, `email`, `b_year`, `is_resident`) VALUES
(1, '', 'Артём', 'Озорнин', '11a', 123, 'm', 'art@mail.ru', 1993, 'resident'),
(2, '', 'Анастасия', 'Моисеева', '11a', 45, 'f', 'ansts@mail.net', 1994, ''),
(3, '', 'Евгений', 'Князев', '11a', 123, 'm', 'gena@mail.ru', 1993, 'foreign'),
(4, '', 'Антон', 'Мулюкин', '11a', 123, 'm', 'tony@mail.ru', 1993, 'foreign'),
(5, '', 'Алексей', 'Новиков', '11a', 123, 'm', 'lexa@mail.ru', 1994, 'foreign'),
(6, '', 'Илья', 'Романовский', '11a', 123, 'm', 'illia@mail.ru', 1993, 'foreign'),
(7, '', 'Павел', 'Демидов', '11a', 200, 'm', 'pavel@mail.ru', 1994, 'resident'),
(8, '', 'Денис', 'Петров', '11a', 200, 'm', 'den@mail.ru', 1993, 'resident'),
(9, '', 'Артём', 'Щербаков', '11b', 200, 'm', 'tema@mail.ru', 1993, 'resident'),
(10, '', 'Андрей', 'Кузнецов', '11b', 200, 'm', 'dron@mail.ru', 1994, 'resident'),
(11, '', 'Максим', 'Исаев', '11b', 200, 'm', 'max@mail.ru', 1994, 'resident'),
(12, '', 'Александр', 'Ильчук', '11b', 200, 'm', 'alex@mail.ru', 1995, 'resident'),
(13, '', 'Роман', 'Май', '11b', 200, 'm', 'rome@mail.ru', 1995, 'resident'),
(14, '', 'Александр', 'Климов', '11b', 200, 'm', 'klim@mail.ru', 1995, 'resident'),
(15, '', 'Михаил', 'Мордвицкий', '11b', 200, 'm', 'mihail@mail.ru', 1995, 'resident'),
(16, '', 'Андрей', 'Басалай', '11c', 200, 'm', 'basalay@mail.ru', 1995, 'resident'),
(17, '', 'Александр', 'Царьков', '11c', 200, 'm', 'tzar@mail.ru', 1994, 'resident'),
(18, '', 'Илья', 'Явна', '11c', 200, 'm', 'yavna@mail.ru', 1994, 'resident'),
(19, '', 'Дмитрий', 'Егоров', '11c', 200, 'm', 'egorov@mail.ru', 1995, 'resident'),
(20, '', 'Александр', 'Зорин', '11c', 200, 'm', 'zorin@mail.ru', 1995, 'resident'),
(21, '', 'Майя', 'Казарцева', '11c', 200, 'm', 'maiya@mail.ru', 1994, 'resident'),
(22, '', 'Сергей', 'Жбанов', '11c', 200, 'm', 'zban@mail.ru', 1995, 'resident'),
(23, '', 'Владимир', 'Фролов', '11c', 200, 'm', 'frolov@mail.ru', 1995, 'resident'),
(24, '', 'Таня', 'Иванова', '11d', 123, 'f', 'tanya@mail.ru', 1995, 'foreign'),
(25, '', 'Николай', 'Осипов', '11d', 200, 'm', 'osip@ya.com', 1994, 'foreign'),
(26, '', 'Илья', 'Карасёв', '11d', 123, 'm', 'karas@ya.com', 1995, 'foreign'),
(27, '', 'Лира', 'Белаква', '11d', 123, 'f', 'lira@ya.ru', 1994, 'foreign');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
