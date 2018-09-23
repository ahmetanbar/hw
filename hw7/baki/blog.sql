-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1:3306
-- Üretim Zamanı: 23 Eyl 2018, 09:21:42
-- Sunucu sürümü: 5.7.21
-- PHP Sürümü: 5.6.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `blog`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `articles`
--

DROP TABLE IF EXISTS `articles`;
CREATE TABLE IF NOT EXISTS `articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `topic` text CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL,
  `article` text CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL,
  `title` text CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL,
  `likes` int(8) DEFAULT '0',
  `dislikes` int(8) DEFAULT '0',
  `views` int(8) NOT NULL DEFAULT '0',
  `comments` int(8) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `articles`
--

INSERT INTO `articles` (`id`, `username`, `date`, `topic`, `article`, `title`, `likes`, `dislikes`, `views`, `comments`) VALUES
(2, 'bakialmaci', '2018-09-16 14:35:06', 'php', 'php ile alakalı yazı', 'php nedir?', 0, 0, 0, 0),
(3, 'bakialmaci', '2018-09-16 15:42:02', 'arm', 'arm ile alakalı yazı.', 'arm nedir?', 0, 0, 0, 0),
(4, 'bakialmaci', '2018-09-16 15:43:24', 'java', 'java ile alakalı yazı.', 'java nedir?', 1, 0, 37, 0),
(5, 'bakialmaci', '2018-09-17 07:35:10', 'css', 'css ile alakalı yazı', 'css nedir?', 0, 0, 3, 0),
(6, 'bakialmaci', '2018-09-17 07:35:52', 'general', 'general yazı', 'general bilgiler', 1, 0, 7, 0),
(7, 'bakialmaci', '2018-09-17 08:54:56', 'Php', 'Yapısı gereği gerçekten çok sade ve temiz kod yazarak istediğiniz uygulamaları geliştirme imkanı verir.\r\n\r\nSöz dizimi çok basit ve anlamlıdır. Alışmak için zorlanmazsınız, çabuk öğrenilebilir.\r\n\r\nBir kaç işlem barındıran küçük uygulamalardan, büyük kurumsal projelere kadar her türlü web uygulamasını tasarlama esnekliğine sahiptir.\r\n\r\nOOP ve PHP nin tüm nimetlerinden yararlanır böylece güncel php özelliklerinde oop uygun şekilde çalışırız.\r\n\r\nDiğer Laravel’i laravel yapan özellikler:\r\nORM\r\n\r\nORM Nedir önce onu açıklarsak; (Object Relational Mapping) Database ile uygulamamızda (Object-Oritented) nesnelerimiz sayesinde bağlantı kurup yönetmemizi sağlayan bir yapıdır. Klasik SQL cümleleri yazmadan nesnelerimiz üzerinden veri tabanına erişim sağlayıp kontrol edebiliyor sorgular çalıştırabiliyoruz. ORM database den bağımsız çalışır. Yani Mysql, SQLite, postgresql, MSSql, Oracle gibi bir çok database için aynı kodları kullanırsınız. Bir çok avantajı var ama burada değinmeyeceğiz.\r\n\r\nLaravel Eloquent ORM kullanır. En gelişmiş Active Record uygulamasıdır.', 'Laravel Nedir ?', 1, 0, 22, 0),
(10, 'emine', '2018-09-20 17:27:32', 'general', 'colors are colorful.', 'colors', 0, 0, 25, 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(8) NOT NULL,
  `article_id` int(8) NOT NULL,
  `comments` text CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL,
  `title` text CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL,
  `username` text CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `article_id`, `comments`, `title`, `username`) VALUES
(5, 2, 4, 'ben ahmet good job', 'merhaba', 'ahmetanbar'),
(6, 2, 4, 'harikaaaa', 'hmmm', 'ahmetanbar'),
(7, 2, 6, 'yazılar harika içinde kayboldum adeta', 'merhabalar', 'ahmetanbar');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `contact`
--

DROP TABLE IF EXISTS `contact`;
CREATE TABLE IF NOT EXISTS `contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` text CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL,
  `email` text CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL,
  `msg` text CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `contact`
--

INSERT INTO `contact` (`id`, `username`, `email`, `msg`) VALUES
(1, 'bakialmaci', 'bakialmaci@gmail.com', 'sasasaa');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` text CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL,
  `passcode` text CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL,
  `email` text CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL,
  `firstname` text CHARACTER SET utf8 COLLATE utf8_turkish_ci,
  `surname` text CHARACTER SET utf8 COLLATE utf8_turkish_ci,
  `tel` text CHARACTER SET utf8 COLLATE utf8_turkish_ci,
  `age` text CHARACTER SET utf8 COLLATE utf8_turkish_ci,
  `sex` text CHARACTER SET utf8 COLLATE utf8_turkish_ci,
  `work` text CHARACTER SET utf8 COLLATE utf8_turkish_ci,
  `active` timestamp NULL DEFAULT NULL,
  `state` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`id`, `username`, `passcode`, `email`, `firstname`, `surname`, `tel`, `age`, `sex`, `work`, `active`, `state`) VALUES
(8, 'furkan', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'furkan@gmail.com', 'Furkan', 'Ardıç', '05464761108', 'Erkek', NULL, NULL, NULL, 1),
(7, 'baki', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'bakialmaci@gmail.com', 'Muhammed Baki', 'Almacı', '05464761108', 'Erkek', NULL, NULL, NULL, 1),
(10, 'bakialmaci', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'bakialmaci@gmail.com', 'Muhammed Baki', 'Almacı', '05464761108', 'Erkek', NULL, NULL, NULL, 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
