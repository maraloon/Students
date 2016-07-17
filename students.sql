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
  `hash` text NOT NULL,
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
(1, '', 'Ким', 'Чен Ир', 'a666a', 123, 'm', 'zxc@zxc.ru', 1975, 'resident'),
(2, '', 'Чин', 'Ху', '123', 45, 'm', 'asd@qwe.net', 1995, ''),
(26, 'q45avnr87tnmhk1dmk5q', 'Хи', 'Кигурой', 'я333у', 123, 'f', 'a@aqa', 2000, 'foreign'),
(41, 'vafu1tr2hwdqujt86tag', 'Хи', 'Кигурой', 'я333у', 123, 'f', 'a@aqaq', 2000, 'foreign'),
(42, 'yg37nz0v7u0y9gsky2my', 'Хи', 'Кигурой', 'я333у', 123, 'f', 'a@aqazxc', 2000, 'foreign'),
(43, 'p3zlfibhg4ky224cjygr', 'Хиго', 'Кигуро', 'я333у', 123, 'f', 'a@aqaqsdfghj', 2001, 'foreign'),
(44, 'qwe', 'testName', 'testSName', '123', 200, 'm', 'z@z', 2000, 'resident'),
(45, 'qwe', 'testName', 'testSName', '123', 200, 'm', 'z@z1', 2000, 'resident'),
(46, 'qwe', 'testName', 'testSName', '123', 200, 'm', 'z@z2', 2000, 'resident'),
(47, 'qwe', 'testName', 'testSName', '123', 200, 'm', 'z@z3', 2000, 'resident'),
(48, 'qwe', 'testName', 'testSName', '123', 200, 'm', 'z@z4', 2000, 'resident'),
(49, 'qwe', 'testName', 'testSName', '123', 200, 'm', 'z@z5', 2000, 'resident'),
(50, 'qwe', 'testName', 'testSName', '123', 200, 'm', 'z@z6', 2000, 'resident'),
(51, 'qwe', 'testName', 'testSName', '123', 200, 'm', 'z@z7', 2000, 'resident'),
(52, 'qwe', 'testName', 'testSName', '123', 200, 'm', 'z@z8', 2000, 'resident'),
(53, 'qwe', 'testName', 'testSName', '123', 200, 'm', 'z@z9', 2000, 'resident'),
(54, 'qwe', 'testName', 'testSName', '123', 200, 'm', 'z@z10', 2000, 'resident'),
(55, 'qwe', 'testName', 'testSName', '123', 200, 'm', 'z@z11', 2000, 'resident'),
(56, 'qwe', 'testName', 'testSName', '123', 200, 'm', 'z@z12', 2000, 'resident'),
(57, 'qwe', 'testName', 'testSName', '123', 200, 'm', 'z@z13', 2000, 'resident'),
(58, 'qwe', 'testName', 'testSName', '123', 200, 'm', 'z@z14', 2000, 'resident'),
(59, 'qwe', 'testName', 'testSName', '123', 200, 'm', 'z@z15', 2000, 'resident'),
(60, 'qwe', 'testName', 'testSName', '123', 200, 'm', 'z@z16', 2000, 'resident'),
(61, 'dvm8nrt82qh4lxdeicfa', 'Таня', 'Иванова', 'а13', 123, 'f', 'a@k', 1993, 'foreign'),
(62, '2wbb2qszinnefps2a2j', 'Tierto', 'Esdiego', '123', 200, 'f', 'tierto@es.com', 2000, 'foreign'),
(63, 'f9d3z7yg2f9lu7kzxz', 'Kizanio', 'Erghty', '123', 123, 'f', 'kizano@ergh.com', 2000, 'foreign'),
(64, 'bxtlitbaw178gmdfoyn', 'Лира', 'Белаква', '122', 123, 'f', 'zxc@zxzc.ru', 2003, 'foreign');

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
