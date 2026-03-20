-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Počítač: sql207.ezyro.com
-- Vytvořeno: Pon 31. bře 2025, 09:08
-- Verze serveru: 10.6.19-MariaDB
-- Verze PHP: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `ezyro_38606904_energeticka`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `total_paid` int(11) DEFAULT 0,
  `notes` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Vypisuji data pro tabulku `customers`
--

INSERT INTO `customers` (`id`, `name`, `total_paid`, `notes`) VALUES
(1, 'LukÃ¡Å¡ Pohorelec', 0, ''),
(2, 'Roman Marchuk', 228, ''),
(3, 'Pavel Kosour', 0, ''),
(4, 'Honza LeteckÃ½', 0, ''),
(5, 'Franta', 0, ''),
(6, 'Pavel Gamer', 0, ''),
(7, 'Adam Midrla', 0, ''),
(8, 'MatÄ›j Gelnar', 0, ''),
(9, 'Filip MareÄek', 76, ''),
(10, 'Ondra Belatka', 0, ''),
(11, 'Martin Le', 0, ''),
(12, 'Filip KnÃ­Å¾e', 0, ''),
(13, 'Pavel BartoÅ¡', 0, ''),
(14, 'Marek Gloser', 0, ''),
(15, 'MatÄ›j MareÄek', 0, ''),
(16, 'AleÅ¡ Berka', 0, '');

-- --------------------------------------------------------

--
-- Struktura tabulky `history`
--

CREATE TABLE `history` (
  `id` int(11) NOT NULL,
  `action_type` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `admin_id` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Vypisuji data pro tabulku `history`
--

INSERT INTO `history` (`id`, `action_type`, `description`, `admin_id`, `created_at`) VALUES
(1, 'add_customer', 'Added customer LukÃ¡Å¡ Pohorelec with notes: ', 'DD', '2025-03-30 10:17:31'),
(2, 'add_customer', 'Added customer Roman Marchuk with notes: ', 'DD', '2025-03-30 10:17:40'),
(3, 'add_customer', 'Added customer Pavel Kosour with notes: ', 'DD', '2025-03-30 10:17:47'),
(4, 'add_customer', 'Added customer Honza LeteckÃ½ with notes: ', 'DD', '2025-03-30 10:17:52'),
(5, 'add_customer', 'Added customer Franta with notes: ', 'DD', '2025-03-30 10:17:59'),
(6, 'add_customer', 'Added customer Pavel Gamer with notes: ', 'DD', '2025-03-30 10:18:04'),
(7, 'add_customer', 'Added customer Adam Midrla with notes: ', 'DD', '2025-03-30 10:18:23'),
(8, 'add_customer', 'Added customer MatÄ›j Gelnar with notes: ', 'DD', '2025-03-30 10:18:51'),
(9, 'add_customer', 'Added customer Filip MareÄek with notes: ', 'DD', '2025-03-30 10:19:00'),
(10, 'add_customer', 'Added customer Ondra Belatka with notes: ', 'DD', '2025-03-30 10:19:10'),
(11, 'add_customer', 'Added customer Martin Le with notes: ', 'DD', '2025-03-30 10:19:19'),
(12, 'add_customer', 'Added customer Filip KnÃ­Å¾e with notes: ', 'DD', '2025-03-30 10:19:28'),
(13, 'add_customer', 'Added customer Pavel BartoÅ¡ with notes: ', 'DD', '2025-03-30 10:19:36'),
(14, 'add_customer', 'Added customer Marek Gloser with notes: ', 'DD', '2025-03-30 10:20:13'),
(15, 'add_customer', 'Added customer MatÄ›j MareÄek with notes: ', 'DD', '2025-03-30 10:22:52'),
(16, 'add_customer', 'Added customer AleÅ¡ Berka with notes: ', 'DD', '2025-03-30 10:23:12'),
(17, 'edit_drink', 'Edited drink ID 12: Monster Hamilton ÄŒervenÃ½, quantity 1, buy price 3 KÄ, sell price 45 KÄ, owner Adam', 'DD', '2025-03-30 11:17:06'),
(18, 'edit_drink', 'Edited drink ID 12: Monster Hamilton ÄŒervenÃ½, quantity 1, buy price 33 KÄ, sell price 45 KÄ, owner Adam', 'DD', '2025-03-30 11:17:11'),
(19, 'edit_customer', 'Updated customer ID 7: name to \'Adam Midrla\', notes to \'kys\'', 'DD', '2025-03-30 11:18:56'),
(20, 'edit_customer', 'Updated customer ID 7: name to \'Adam Midrla\', notes to \'\'', 'DD', '2025-03-30 11:18:59'),
(21, 'add_sale', 'Added sale: Filip MareÄek bought 2 Monster Ultra Zero for 76 KÄ, owner DD amount 66 KÄ, deal maker Adam amount 10 KÄ, paid: No', 'DD', '2025-03-30 11:20:40'),
(22, 'delete_sale', 'Deleted sale ID 21: Filip MareÄek bought 2 Monster Ultra Zero', 'DD', '2025-03-30 11:21:30'),
(23, 'edit_drink', 'Edited drink ID 1: Monster Ultra Zero, quantity 16, buy price 28 KÄ, sell price 38 KÄ, owner DD', 'DD', '2025-03-30 11:21:39'),
(24, 'buy_update', 'Added 10 of Monster Zero Ultra at buy price 28 KÄ and sell price 38 KÄ, owner: DD', 'DD', '2025-03-30 11:22:22'),
(25, 'delete_drink', 'Deleted drink \'Monster Zero Ultra\' (ID 21)', 'DD', '2025-03-30 11:22:29'),
(26, 'add_sale', 'Added sale: Roman Marchuk bought 1 Monster Khaotic for 38 KÄ, owner DD amount 35 KÄ, deal maker DD amount 3 KÄ, paid: No', 'DD', '2025-03-31 12:45:00'),
(27, 'delete_sale', 'Deleted sale ID 22: Roman Marchuk bought 1 Monster Khaotic', 'DD', '2025-03-31 12:46:54'),
(28, 'edit_drink', 'Edited drink ID 11: Monster Khaotic, quantity 1, buy price 32 KÄ, sell price 38 KÄ, owner DD', 'DD', '2025-03-31 12:49:12'),
(29, 'add_sale', 'Added sale: Roman Marchuk bought 1 Monster Khaotic for 38 KÄ, owner DD amount 35 KÄ, deal maker DD amount 3 KÄ, paid: No', 'DD', '2025-03-31 12:52:16'),
(30, 'delete_sale', 'Deleted sale ID 23: Roman Marchuk bought 1 Monster Khaotic', 'DD', '2025-03-31 12:52:38'),
(31, 'edit_drink', 'Edited drink ID 11: Monster Khaotic, quantity 1, buy price 32 KÄ, sell price 38 KÄ, owner DD', 'DD', '2025-03-31 12:52:44'),
(32, 'add_sale', 'Added sale: Roman Marchuk bought 1 Monster Khaotic for 38 KÄ, owner DD amount 35 KÄ, deal maker DD amount 3 KÄ, paid: No', 'DD', '2025-03-31 12:53:20'),
(33, 'delete_sale', 'Deleted sale ID 24: Roman Marchuk bought 1 Monster Khaotic', 'DD', '2025-03-31 12:53:29'),
(34, 'edit_drink', 'Edited drink ID 11: Monster Khaotic, quantity 1, buy price 32 KÄ, sell price 38 KÄ, owner DD', 'DD', '2025-03-31 12:53:37'),
(35, 'add_sale', 'Added sale: Roman Marchuk bought 1 Monster Khaotic for 38 KÄ, owner DD amount 35 KÄ, deal maker DD amount 3 KÄ, paid: No', 'DD', '2025-03-31 12:57:23'),
(36, 'delete_sale', 'Deleted sale ID 25: Roman Marchuk bought 1 Monster Khaotic', 'DD', '2025-03-31 12:57:53'),
(37, 'edit_drink', 'Edited drink ID 11: Monster Khaotic, quantity 1, buy price 32 KÄ, sell price 38 KÄ, owner DD', 'DD', '2025-03-31 12:58:00'),
(38, 'add_sale', 'Added sale: Roman Marchuk bought 1 Monster Khaotic for 38 KÄ, owner DD amount 35 KÄ, deal maker DD amount 3 KÄ, paid: No', 'DD', '2025-03-31 13:03:13'),
(39, 'delete_sale', 'Deleted sale ID 26: Roman Marchuk bought 1 Monster Khaotic', 'DD', '2025-03-31 13:03:29'),
(40, 'edit_drink', 'Edited drink ID 11: Monster Khaotic, quantity 1, buy price 32 KÄ, sell price 38 KÄ, owner DD', 'DD', '2025-03-31 13:03:36'),
(41, 'add_sale', 'Added sale: Roman Marchuk bought 1 Monster Khaotic for 38 KÄ, owner DD amount 35 KÄ, deal maker DD amount 3 KÄ, paid: No', 'DD', '2025-03-31 13:05:22'),
(42, 'delete_sale', 'Deleted sale ID 27: Roman Marchuk bought 1 Monster Khaotic', 'DD', '2025-03-31 13:05:25'),
(43, 'edit_drink', 'Edited drink ID 11: Monster Khaotic, quantity 1, buy price 32 KÄ, sell price 38 KÄ, owner DD', 'DD', '2025-03-31 13:05:30');

-- --------------------------------------------------------

--
-- Struktura tabulky `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `drink_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `buy_price` int(11) NOT NULL,
  `sell_price` int(11) NOT NULL,
  `owner` enum('DD','Adam') NOT NULL DEFAULT 'DD',
  `image` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Vypisuji data pro tabulku `inventory`
--

INSERT INTO `inventory` (`id`, `drink_name`, `quantity`, `buy_price`, `sell_price`, `owner`, `image`) VALUES
(1, 'Monster Ultra Zero', 16, 28, 38, 'DD', NULL),
(2, 'Monster Bad Apple', 0, 40, 45, 'DD', NULL),
(3, 'Monster Classic', 2, 28, 38, 'DD', NULL),
(4, 'Monster Doktor', 4, 28, 38, 'DD', NULL),
(5, 'Monster Doktor', 3, 30, 38, 'DD', NULL),
(6, 'Monster Hamilton', 7, 28, 38, 'DD', NULL),
(7, 'Monster Mango Loco', 2, 28, 38, 'DD', NULL),
(8, 'Tiger Classic', 0, 15, 25, 'DD', NULL),
(9, 'Semtex Air', 6, 20, 25, 'DD', NULL),
(11, 'Monster Khaotic', 1, 32, 38, 'DD', NULL),
(12, 'Monster Hamilton ÄŒervenÃ½', 1, 33, 45, 'Adam', NULL),
(13, 'EverG Berries', 5, 10, 10, 'DD', NULL),
(14, 'Semtex Air Zero', 1, 20, 25, 'Adam', NULL),
(15, 'Crazy Wolf Meloun', 2, 10, 12, 'DD', NULL),
(16, 'Crazy Wolf Limetka', 1, 10, 12, 'DD', NULL),
(17, 'Crazy Wolf Cassis', 5, 10, 12, 'DD', NULL),
(18, 'Crazy Wolf Zero', 4, 10, 12, 'DD', NULL),
(19, 'Crazy Wolf Opuncie', 4, 10, 12, 'DD', NULL);

-- --------------------------------------------------------

--
-- Struktura tabulky `profits`
--

CREATE TABLE `profits` (
  `id` int(11) NOT NULL,
  `person` varchar(10) NOT NULL,
  `total_profit` int(10) DEFAULT 0,
  `clean_profit` int(10) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Vypisuji data pro tabulku `profits`
--

INSERT INTO `profits` (`id`, `person`, `total_profit`, `clean_profit`) VALUES
(1, 'DD', 0, 0),
(2, 'Adam', 0, 0),
(3, 'DD', 0, 0),
(4, 'Adam', 0, 0);

-- --------------------------------------------------------

--
-- Struktura tabulky `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `buyer_name` varchar(255) NOT NULL,
  `drink_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `amount_paid` int(11) NOT NULL,
  `purchase_date` datetime NOT NULL,
  `is_paid` tinyint(1) NOT NULL DEFAULT 0,
  `deal_maker` varchar(10) NOT NULL,
  `profit` int(11) NOT NULL,
  `owner_amount` int(11) NOT NULL,
  `deal_maker_amount` int(11) NOT NULL,
  `is_profit_split` tinyint(1) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Vypisuji data pro tabulku `sales`
--

INSERT INTO `sales` (`id`, `buyer_name`, `drink_name`, `quantity`, `amount_paid`, `purchase_date`, `is_paid`, `deal_maker`, `profit`, `owner_amount`, `deal_maker_amount`, `is_profit_split`) VALUES
(1, 'Honza LeteckÃ½', 'Monster Ultra Zero', 1, 38, '2025-03-27 08:10:15', 1, '', 0, 0, 0, 1),
(2, 'Pavel Kosour', 'Monster Ultra Zero', 1, 38, '2025-03-27 08:45:28', 1, '', 0, 0, 0, 1),
(6, 'Roman Marchuk', 'Monster Bad Apple', 1, 45, '2025-03-27 09:24:50', 1, '', 0, 0, 0, 1),
(7, 'LukÃ¡Å¡ Pohorelec', 'Monster Ultra Zero', 1, 38, '2025-03-27 09:28:10', 1, '', 0, 0, 0, 1),
(14, 'Roman Marchuk', 'Tiger Classic', 1, 25, '2025-03-28 04:57:55', 1, 'DD', 10, 20, 5, 1),
(15, 'Pavel Kosour', 'Monster Bad Apple', 1, 45, '2025-03-28 04:58:32', 1, 'DD', 5, 42, 3, 1),
(16, 'Filip MareÄek', 'Monster Bad Apple', 1, 45, '2025-03-28 04:59:27', 1, 'DD', 5, 42, 3, 1),
(17, 'Martin Le', 'Crazy Wolf Limetka', 1, 12, '2025-03-28 05:15:42', 1, 'DD', 2, 11, 1, 1),
(18, 'Martin Le', 'Crazy Wolf Zero', 1, 12, '2025-03-28 05:15:59', 1, 'DD', 2, 11, 1, 1),
(19, 'Martin Le', 'Crazy Wolf Casis', 1, 12, '2025-03-28 05:16:25', 1, 'DD', 2, 11, 1, 1),
(20, 'LukÃ¡Å¡ Pohorelec', 'Monster Ultra Zero', 1, 38, '2025-03-28 09:30:20', 1, 'Adam', 10, 33, 5, 1);

-- --------------------------------------------------------

--
-- Struktura tabulky `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Vypisuji data pro tabulku `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'DD', '$2y$10$5/vslQsJd80ZmnB9oW8Lr.CQ7CJX8tSOrqwZ8wITlHWpSghjx/QoC', '2025-03-30 09:48:43'),
(2, 'adam', '$2y$10$wg9gV4s9XRZA0hOXC7Wg4./um7tJXqAjnEN3e2lnIp2Nh83uF9gCy', '2025-03-30 09:48:56');

--
-- Klíče pro exportované tabulky
--

--
-- Klíče pro tabulku `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Klíče pro tabulku `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id`);

--
-- Klíče pro tabulku `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`);

--
-- Klíče pro tabulku `profits`
--
ALTER TABLE `profits`
  ADD PRIMARY KEY (`id`);

--
-- Klíče pro tabulku `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- Klíče pro tabulku `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pro tabulku `history`
--
ALTER TABLE `history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT pro tabulku `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pro tabulku `profits`
--
ALTER TABLE `profits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pro tabulku `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT pro tabulku `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
