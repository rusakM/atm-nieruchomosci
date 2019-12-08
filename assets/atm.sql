-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Czas generowania: 30 Lis 2019, 02:00
-- Wersja serwera: 10.4.8-MariaDB
-- Wersja PHP: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `atm`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `cities`
--

CREATE TABLE `cities` (
  `cityId` int(11) NOT NULL,
  `name` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `offers`
--

CREATE TABLE `offers` (
  `offerId` int(11) NOT NULL,
  `title` text COLLATE utf8_polish_ci NOT NULL,
  `price` int(11) NOT NULL,
  `area` int(11) NOT NULL,
  `cityId` int(11) NOT NULL,
  `typeOfEstate` int(11) NOT NULL,
  `typeOfMarket` int(11) NOT NULL,
  `typeOfTransaction` int(11) NOT NULL,
  `adress` text COLLATE utf8_polish_ci DEFAULT NULL,
  `description` text COLLATE utf8_polish_ci DEFAULT NULL,
  `insertionDate` text COLLATE utf8_polish_ci NOT NULL,
  `isFinished` int(11) NOT NULL DEFAULT -1,
  `isFurnitured` int(11) NOT NULL DEFAULT -1,
  `numOfRooms` int(11) NOT NULL DEFAULT 0,
  `floor` int(11) NOT NULL DEFAULT -1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `photos`
--

CREATE TABLE `photos` (
  `photoId` int(11) NOT NULL,
  `offerId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `typesOfEstates`
--

CREATE TABLE `typesOfEstates` (
  `typeFoEstateId` int(11) NOT NULL,
  `name` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`cityId`);

--
-- Indeksy dla tabeli `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`offerId`),
  ADD KEY `cityId` (`cityId`),
  ADD KEY `typeOfEstate` (`typeOfEstate`);

--
-- Indeksy dla tabeli `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`photoId`),
  ADD KEY `offerId` (`offerId`);

--
-- Indeksy dla tabeli `typesOfEstates`
--
ALTER TABLE `typesOfEstates`
  ADD PRIMARY KEY (`typeFoEstateId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `cities`
--
ALTER TABLE `cities`
  MODIFY `cityId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `offers`
--
ALTER TABLE `offers`
  MODIFY `offerId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `photos`
--
ALTER TABLE `photos`
  MODIFY `photoId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `typesOfEstates`
--
ALTER TABLE `typesOfEstates`
  MODIFY `typeFoEstateId` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
