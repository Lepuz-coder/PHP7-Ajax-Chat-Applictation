-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 27 Ara 2019, 13:45:51
-- Sunucu sürümü: 10.4.8-MariaDB
-- PHP Sürümü: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `chatting`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `istekler`
--

CREATE TABLE `istekler` (
  `id` int(11) NOT NULL,
  `kullaniciid` int(100) NOT NULL,
  `arkadasistekid` text COLLATE utf8mb4_turkish_ci NOT NULL,
  `yenimesajid` text COLLATE utf8mb4_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `istekler`
--

INSERT INTO `istekler` (`id`, `kullaniciid`, `arkadasistekid`, `yenimesajid`) VALUES
(1, 1, '', '2-3-4'),
(2, 2, '', ''),
(3, 3, '', ''),
(4, 4, '', ''),
(5, 5, '', ''),
(6, 6, '', ''),
(7, 7, '', '');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kisiler`
--

CREATE TABLE `kisiler` (
  `id` int(11) NOT NULL,
  `kullaniciad` varchar(30) COLLATE utf8mb4_turkish_ci NOT NULL,
  `sifre` text COLLATE utf8mb4_turkish_ci NOT NULL,
  `arkadaslarid` text COLLATE utf8mb4_turkish_ci NOT NULL,
  `online` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `kisiler`
--

INSERT INTO `kisiler` (`id`, `kullaniciad`, `sifre`, `arkadaslarid`, `online`) VALUES
(1, 'Lepuz', 'emosano1907', '2-3-4-6-5-7', 0),
(2, 'Miray', '123', '5-1-6', 1),
(3, 'Berkay', '123', '1', 0),
(4, 'Ckardovic', '123456', '1', 0),
(5, 'Lelelem', '123', '1', 0),
(6, 'Mehmet1907', 'mehdi1907', '1-2', 1),
(7, 'Enes', '123', '1', 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `mesajlar`
--

CREATE TABLE `mesajlar` (
  `id` int(11) NOT NULL,
  `kullaniciid` text COLLATE utf8mb4_turkish_ci NOT NULL,
  `mesajkutuları` text COLLATE utf8mb4_turkish_ci NOT NULL,
  `yazıyorkutuları` text COLLATE utf8mb4_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `mesajlar`
--

INSERT INTO `mesajlar` (`id`, `kullaniciid`, `mesajkutuları`, `yazıyorkutuları`) VALUES
(1, '2-1', 'e5175fd4f113ae58deb58733588927947f731bad', 'e5175fd4f113ae58deb58733588927947f731bad'),
(2, '3-1', '5b9c641e093661d7270d8f40a0e6d2f24a0dfc22', '5b9c641e093661d7270d8f40a0e6d2f24a0dfc22'),
(3, '4-1', 'c90d702d64f544d5bfa7c1733e67f1d47333fecd', 'c90d702d64f544d5bfa7c1733e67f1d47333fecd'),
(4, '1-6', '9c5a72cd55b705391e904af342441951bd587297', '9c5a72cd55b705391e904af342441951bd587297'),
(5, '5-1', '585b399213bcaae24de4295d3b9310fe46279257', '585b399213bcaae24de4295d3b9310fe46279257'),
(6, '1-7', '38b8f007067d7433b4434d94c8a2f6b1e4788134', '38b8f007067d7433b4434d94c8a2f6b1e4788134'),
(7, '7-2', '526308d309d6f4a86ad985922246e3f3353f31f0', '526308d309d6f4a86ad985922246e3f3353f31f0'),
(8, '6-2', 'e1528b346e9db6816133745c210c6a1a09e6164b', 'e1528b346e9db6816133745c210c6a1a09e6164b');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `token`
--

CREATE TABLE `token` (
  `id` int(11) NOT NULL,
  `token` text COLLATE utf8mb4_turkish_ci NOT NULL,
  `saatlikkulanım` int(11) NOT NULL,
  `saat` varchar(6) COLLATE utf8mb4_turkish_ci NOT NULL,
  `izin` varchar(6) COLLATE utf8mb4_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `token`
--

INSERT INTO `token` (`id`, `token`, `saatlikkulanım`, `saat`, `izin`) VALUES
(1, 'p5kH26t1Tgo16ymE3fR', 0, '19-04', '3');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `istekler`
--
ALTER TABLE `istekler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `kisiler`
--
ALTER TABLE `kisiler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `mesajlar`
--
ALTER TABLE `mesajlar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `token`
--
ALTER TABLE `token`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `istekler`
--
ALTER TABLE `istekler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Tablo için AUTO_INCREMENT değeri `kisiler`
--
ALTER TABLE `kisiler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Tablo için AUTO_INCREMENT değeri `mesajlar`
--
ALTER TABLE `mesajlar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Tablo için AUTO_INCREMENT değeri `token`
--
ALTER TABLE `token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
