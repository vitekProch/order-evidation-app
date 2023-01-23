-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Pon 23. led 2023, 09:36
-- Verze serveru: 10.4.24-MariaDB
-- Verze PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `tst`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `employee`
--

CREATE TABLE `employee` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `shift_id` varchar(255) NOT NULL DEFAULT 'Ranní',
  `role` varchar(255) NOT NULL DEFAULT 'logged_in'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `employee`
--

INSERT INTO `employee` (`id`, `employee_id`, `name`, `password`, `shift_id`, `role`) VALUES
(11, 1234, 'admin', '$2y$10$0dpotZcQPGg2Ex9vct625exRnsNgnXBrR2..7ogLv9mQXNN2rttNa', 'Ranní', 'admin');

-- --------------------------------------------------------

--
-- Struktura tabulky `shift`
--

CREATE TABLE `shift` (
  `shift_id` int(11) NOT NULL,
  `shift_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `shift`
--

INSERT INTO `shift` (`shift_id`, `shift_name`) VALUES
(1, 'Ranní'),
(2, 'Odpolední'),
(3, 'Noční');

-- --------------------------------------------------------

--
-- Struktura tabulky `tube_diameter`
--

CREATE TABLE `tube_diameter` (
  `id` int(11) NOT NULL,
  `diameter_id` int(11) NOT NULL,
  `diameter` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `tube_diameter`
--

INSERT INTO `tube_diameter` (`id`, `diameter_id`, `diameter`) VALUES
(1, 0, 'Ø 6x1'),
(2, 1, 'Ø 6x0.8'),
(3, 2, 'Ø 8'),
(4, 3, 'Ø 10'),
(5, 4, 'Ø 12'),
(6, 5, 'Ø 15'),
(7, 6, 'Ø 18'),
(8, 7, 'Ø 22');

-- --------------------------------------------------------

--
-- Struktura tabulky `tube_excess`
--

CREATE TABLE `tube_excess` (
  `id` int(11) NOT NULL,
  `material_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `diameter_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabulky `tube_production`
--

CREATE TABLE `tube_production` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `material_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `diameter_id` varchar(255) NOT NULL,
  `made_quantity` int(11) NOT NULL,
  `create_date` datetime NOT NULL DEFAULT current_timestamp(),
  `shift_id` int(11) NOT NULL,
  `excess_quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexy pro exportované tabulky
--

--
-- Indexy pro tabulku `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employee_id` (`employee_id`);

--
-- Indexy pro tabulku `shift`
--
ALTER TABLE `shift`
  ADD PRIMARY KEY (`shift_id`);

--
-- Indexy pro tabulku `tube_diameter`
--
ALTER TABLE `tube_diameter`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pro tabulku `tube_excess`
--
ALTER TABLE `tube_excess`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_id` (`material_id`);

--
-- Indexy pro tabulku `tube_production`
--
ALTER TABLE `tube_production`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_id` (`order_id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `employee`
--
ALTER TABLE `employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pro tabulku `shift`
--
ALTER TABLE `shift`
  MODIFY `shift_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pro tabulku `tube_diameter`
--
ALTER TABLE `tube_diameter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pro tabulku `tube_excess`
--
ALTER TABLE `tube_excess`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pro tabulku `tube_production`
--
ALTER TABLE `tube_production`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
