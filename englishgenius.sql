-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Фев 26 2021 г., 11:44
-- Версия сервера: 8.0.18
-- Версия PHP: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `englishgenius`
--

-- --------------------------------------------------------

--
-- Структура таблицы `dictionaries`
--

CREATE TABLE `dictionaries` (
  `dictionaryid` int(11) NOT NULL,
  `name` char(50) COLLATE utf8_unicode_ci NOT NULL,
  `discription` char(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dictionaryowner` int(11) NOT NULL,
  `ispublic` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `dictionaries`
--

INSERT INTO `dictionaries` (`dictionaryid`, `name`, `discription`, `dictionaryowner`, `ispublic`) VALUES
(43, 'Oxford 3000', 'The most important words in English.', 5, 1),
(44, 'krex table', 'Test table1', 6, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `userid` int(11) NOT NULL,
  `username` char(16) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` char(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`userid`, `username`, `email`, `password`) VALUES
(5, 'krex1k', 'kmv5125@gmail.com', '$2y$10$opX9MrzePk05fBzlqspQD.nkPL50Tjk6tI0fST3DKrdUx3190LAPm'),
(6, 'krex', 'maksim.kasabutski@gmail.com', '$2y$10$jP9VOUGz4wq/CXOvZP0kQ.lUVbHjq1oZqP/Z7oFqiQe1P.K2NbWKy');

-- --------------------------------------------------------

--
-- Структура таблицы `users_has_dictionaries`
--

CREATE TABLE `users_has_dictionaries` (
  `users_userid` int(11) NOT NULL,
  `dictionaries_dictionaryid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `users_has_dictionaries`
--

INSERT INTO `users_has_dictionaries` (`users_userid`, `dictionaries_dictionaryid`) VALUES
(5, 43),
(6, 43),
(5, 44),
(6, 44);

-- --------------------------------------------------------

--
-- Структура таблицы `wordlist`
--

CREATE TABLE `wordlist` (
  `wordid` int(11) NOT NULL,
  `dictionaryid` int(11) NOT NULL,
  `word` char(25) COLLATE utf8_unicode_ci NOT NULL,
  `translation` char(25) COLLATE utf8_unicode_ci NOT NULL,
  `pos` char(10) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `wordlist`
--

INSERT INTO `wordlist` (`wordid`, `dictionaryid`, `word`, `translation`, `pos`) VALUES
(39, 43, 'car', 'машина', 'noun'),
(40, 43, 'nice', 'красивый', 'noun');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `dictionaries`
--
ALTER TABLE `dictionaries`
  ADD PRIMARY KEY (`dictionaryid`),
  ADD UNIQUE KEY `dictionaryname_UNIQUE` (`name`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`),
  ADD UNIQUE KEY `username_UNIQUE` (`username`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`);

--
-- Индексы таблицы `users_has_dictionaries`
--
ALTER TABLE `users_has_dictionaries`
  ADD PRIMARY KEY (`users_userid`,`dictionaries_dictionaryid`),
  ADD KEY `fk_users_has_dictionaries_dictionaries1_idx` (`dictionaries_dictionaryid`),
  ADD KEY `fk_users_has_dictionaries_users_idx` (`users_userid`);

--
-- Индексы таблицы `wordlist`
--
ALTER TABLE `wordlist`
  ADD PRIMARY KEY (`wordid`),
  ADD KEY `fk_wordlist_dictionaries1_idx` (`dictionaryid`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `dictionaries`
--
ALTER TABLE `dictionaries`
  MODIFY `dictionaryid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `wordlist`
--
ALTER TABLE `wordlist`
  MODIFY `wordid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `users_has_dictionaries`
--
ALTER TABLE `users_has_dictionaries`
  ADD CONSTRAINT `fk_users_has_dictionaries_dictionaries1` FOREIGN KEY (`dictionaries_dictionaryid`) REFERENCES `dictionaries` (`dictionaryid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_users_has_dictionaries_users` FOREIGN KEY (`users_userid`) REFERENCES `users` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `wordlist`
--
ALTER TABLE `wordlist`
  ADD CONSTRAINT `fk_wordlist_dictionaries1` FOREIGN KEY (`dictionaryid`) REFERENCES `dictionaries` (`dictionaryid`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
