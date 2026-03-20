-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql207.ezyro.com
-- Generation Time: Apr 21, 2025 at 03:38 PM
-- Server version: 10.6.19-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ezyro_38606904_energeticka`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `total_paid` int(11) DEFAULT 0,
  `notes` mediumtext DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `total_paid`, `notes`) VALUES
(1, 'LukÃ¡Å¡ Pohorelec', 0, ''),
(2, 'Roman Marchuk', 304, ''),
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
(16, 'AleÅ¡ Berka', 0, ''),
(17, 'Daniel Doubrava', 0, ''),
(18, 'Filip JeÅ™Ã¡bek', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `id` int(11) NOT NULL,
  `action_type` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `admin_id` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `history`
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
(43, 'edit_drink', 'Edited drink ID 11: Monster Khaotic, quantity 1, buy price 32 KÄ, sell price 38 KÄ, owner DD', 'DD', '2025-03-31 13:05:30'),
(44, 'add_sale', 'Added sale: Roman Marchuk bought 1 Monster Khaotic for 38 KÄ, owner DD amount 35 KÄ, deal maker DD amount 3 KÄ, paid: No', 'DD', '2025-03-31 13:27:49'),
(45, 'delete_sale', 'Deleted sale ID 28: Roman Marchuk bought 1 Monster Khaotic', 'DD', '2025-03-31 13:27:52'),
(46, 'edit_drink', 'Edited drink ID 11: Monster Khaotic, quantity 1, buy price 32 KÄ, sell price 38 KÄ, owner DD', 'DD', '2025-03-31 13:27:58'),
(47, 'add_sale', 'Added sale: Roman Marchuk bought 1 Monster Khaotic for 38 KÄ, owner DD amount 35 KÄ, deal maker DD amount 3 KÄ, paid: No', 'DD', '2025-03-31 13:35:36'),
(48, 'delete_sale', 'Deleted sale ID 29: Roman Marchuk bought 1 Monster Khaotic', 'DD', '2025-03-31 13:35:41'),
(49, 'edit_drink', 'Edited drink ID 11: Monster Khaotic, quantity 1, buy price 32 KÄ, sell price 38 KÄ, owner DD', 'DD', '2025-03-31 13:35:46'),
(50, 'delete_sale', 'Deleted sale ID 30: Roman Marchuk bought 1 Monster Khaotic', 'DD', '2025-03-31 13:43:01'),
(51, 'delete_sale', 'Deleted sale ID 31: Roman Marchuk bought 1 Monster Khaotic', 'DD', '2025-03-31 13:43:25'),
(52, 'delete_sale', 'Deleted sale ID 32: Roman Marchuk bought 1 Monster Khaotic', 'DD', '2025-03-31 13:46:32'),
(53, 'delete_sale', 'Deleted sale ID 33: Roman Marchuk bought 1 Monster Khaotic', 'DD', '2025-03-31 13:46:46'),
(54, 'delete_sale', 'Deleted sale ID 34: Roman Marchuk bought 1 Monster Khaotic', 'DD', '2025-03-31 13:57:47'),
(55, 'edit_drink', 'Edited drink ID 11: Monster Khaotic, quantity 1, buy price 32 KÄ, sell price 38 KÄ, owner DD', 'DD', '2025-03-31 13:57:53'),
(56, 'delete_sale', 'Deleted sale ID 36: Roman Marchuk bought 1 Monster Khaotic', 'DD', '2025-03-31 14:04:00'),
(57, 'delete_sale', 'Deleted sale ID 35: Roman Marchuk bought 1 Monster Khaotic', 'DD', '2025-03-31 14:04:02'),
(58, 'edit_drink', 'Edited drink ID 11: Monster Khaotic, quantity 1, buy price 32 KÄ, sell price 38 KÄ, owner DD', 'DD', '2025-03-31 14:04:08'),
(59, 'add_sale', 'Added sale: Martin Le bought 1 Monster Ultra Zero for 38 KÄ, deal maker: DD, paid: Yes', 'DD', '2025-04-10 11:16:15'),
(60, 'delete_sale', 'Deleted sale ID 37: Martin Le bought 1 Monster Ultra Zero', 'DD', '2025-04-10 11:16:20'),
(61, 'add_sale', 'Added sale: Martin Le bought 1 Monster Ultra Zero for 38 KÄ, deal maker: DD, paid: Yes', 'DD', '2025-04-10 11:17:12'),
(62, 'delete_sale', 'Deleted sale ID 38: Martin Le bought 1 Monster Ultra Zero', 'DD', '2025-04-10 11:17:17'),
(63, 'add_sale', 'Added sale: Martin Le bought 1 Monster Ultra Zero for 38 KÄ, deal maker: DD, paid: Yes', 'DD', '2025-04-10 11:20:33'),
(64, 'delete_sale', 'Deleted sale ID 39: Martin Le bought 1 Monster Ultra Zero', 'DD', '2025-04-10 11:21:01'),
(65, 'add_sale', 'Added sale: Martin Le bought 1 Monster Ultra Zero for 38 KÄ, deal maker: DD, paid: Yes', 'DD', '2025-04-10 11:24:02'),
(66, 'delete_sale', 'Deleted sale ID 40: Martin Le bought 1 Monster Ultra Zero', 'DD', '2025-04-10 11:24:06'),
(67, 'add_sale', 'Added sale ID 41: Martin Le bought 1 Monster Ultra Zero for 38 KÄ, deal maker: DD, paid: Yes', 'DD', '2025-04-10 11:27:03'),
(68, 'delete_sale', 'Deleted sale ID 41: Martin Le bought 1 Monster Ultra Zero', 'DD', '2025-04-10 11:27:06'),
(69, 'add_sale', 'Added sale ID 42: Martin Le bought 1 Monster Ultra Zero for 38 KÄ, deal maker: DD, paid: Yes', 'DD', '2025-04-10 11:28:43'),
(70, 'delete_sale', 'Deleted sale ID 42: Martin Le bought 1 Monster Ultra Zero', 'DD', '2025-04-10 11:29:09'),
(71, 'add_sale', 'Added sale ID 43: Martin Le bought 1 Monster Ultra Zero for 38 KÄ, deal maker: DD, paid: No', 'DD', '2025-04-10 11:30:41'),
(72, 'delete_sale', 'Deleted sale ID 43: Martin Le bought 1 Monster Ultra Zero', 'DD', '2025-04-10 11:30:47'),
(73, 'add_sale', 'Added sale ID 44: Martin Le bought 1 Monster Ultra Zero for 38 KÄ, deal maker: DD, paid: Yes', 'DD', '2025-04-10 11:33:10'),
(74, 'delete_sale', 'Deleted sale ID 44: Martin Le bought 1 of Monster Ultra Zero for 38 KÄ on 2025-04-10 04:33:10, deal maker: 0, paid: Yes, returned 1 to inventory (ID 1, new qty: 9)', 'DD', '2025-04-10 11:33:13'),
(75, 'add_sale', 'Added sale ID 45: Martin Le bought 1 Monster Ultra Zero for 38 KÄ, deal maker: DD, paid: Yes', 'DD', '2025-04-10 11:40:42'),
(76, 'delete_sale', 'Deleted sale ID 45: Martin Le bought 1 Monster Ultra Zero for 38 KÄ on 2025-04-10 04:40:42, deal maker: 0, paid: Yes, returned 1 to inventory (ID 1, new qty: 9)', 'DD', '2025-04-10 11:40:46'),
(77, 'add_sale', 'Added sale ID 46: Martin Le bought 2 EverG Berries for 20 KÄ, deal maker: DD, paid: Yes', 'DD', '2025-04-10 11:46:08'),
(78, 'buy_update', 'Updated 5 of EverG Berries at buy price 10 KÄ and sell price 10 KÄ, owner: DD', 'DD', '2025-04-10 11:52:35'),
(79, 'edit_drink', 'Edited drink ID 12: Monster Hamilton ÄŒervenÃ½, quantity 0, buy price 33 KÄ, sell price 45 KÄ, owner Adam', 'DD', '2025-04-10 11:52:55'),
(80, 'edit_drink', 'Edited drink ID 1: Monster Ultra Zero, quantity 12, buy price 28 KÄ, sell price 38 KÄ, owner DD', 'DD', '2025-04-10 11:53:30'),
(81, 'edit_drink', 'Edited drink ID 1: Monster Ultra Zero, quantity 14, buy price 28 KÄ, sell price 38 KÄ, owner DD', 'DD', '2025-04-10 11:54:07'),
(82, 'add_customer', 'Added customer Daniel Doubrava with notes: ', 'DD', '2025-04-10 11:54:19'),
(83, 'add_sale', 'Added sale ID 47: Daniel Doubrava bought 1 Monster Ultra Zero for 38 KÄ, deal maker: Adam, paid: Yes', 'DD', '2025-04-10 11:54:42'),
(84, 'delete_sale', 'Deleted sale ID 47: Daniel Doubrava bought 1 Monster Ultra Zero for 38 KÄ on 2025-04-10 04:54:42, deal maker: 0, paid: Yes, returned 1 to inventory (ID 1, new qty: 14)', 'DD', '2025-04-10 12:04:19'),
(85, 'add_sale', 'Added sale ID 48: Daniel Doubrava bought 1 Monster Ultra Zero for 38 KÄ, deal maker: Adam, owner: DD, owner amount: 33 KÄ, deal maker amount: 5 KÄ, paid: Yes', 'DD', '2025-04-10 12:04:36'),
(86, 'add_sale', 'Added sale ID 49: Daniel Doubrava bought 1 Monster Ultra Zero for 38 KÄ, deal maker: DD, owner: DD, owner amount: 33 KÄ, deal maker amount: 5 KÄ, paid: No', 'DD', '2025-04-10 12:04:55'),
(87, 'delete_sale', 'Deleted sale ID 48: Daniel Doubrava bought 1 Monster Ultra Zero for 38 KÄ on 0000-00-00 00:00:00, deal maker: 0, paid: Yes, returned 1 to inventory (ID 1, new qty: 13)', 'DD', '2025-04-10 12:04:58'),
(88, 'delete_sale', 'Deleted sale ID 49: Daniel Doubrava bought 1 Monster Ultra Zero for 38 KÄ on 0000-00-00 00:00:00, deal maker: 0, paid: No, returned 1 to inventory (ID 1, new qty: 14)', 'DD', '2025-04-10 12:05:02'),
(89, 'add_sale', 'Added sale ID 50: Daniel Doubrava bought 1 Monster Ultra Zero for 38 KÄ, deal maker: Adam, owner: DD, owner amount: 33 KÄ, deal maker amount: 5 KÄ, paid: Yes', 'DD', '2025-04-10 12:06:41'),
(90, 'delete_sale', 'Deleted sale ID 50: Daniel Doubrava bought 1 Monster Ultra Zero for 38 KÄ on 0000-00-00 00:00:00, deal maker: 0, paid: Yes, returned 1 to inventory (ID 1, new qty: 14)', 'DD', '2025-04-10 12:06:50'),
(91, 'add_sale', 'Added sale ID 51: Daniel Doubrava bought 1 Monster Ultra Zero for 38 KÄ, deal maker: Adam, owner: DD, owner amount: 33 KÄ, deal maker amount: 5 KÄ, paid: Yes', 'DD', '2025-04-10 12:07:52'),
(92, 'add_sale', 'Added sale ID 52: Daniel Doubrava bought 1 Monster Doktor for 38 KÄ, deal maker: Adam, owner: DD, owner amount: 33 KÄ, deal maker amount: 5 KÄ, paid: Yes', 'DD', '2025-04-10 12:08:28'),
(93, 'delete_sale', 'Deleted sale ID 52: Daniel Doubrava bought 1 Monster Doktor for 38 KÄ on 2025-04-10 05:08:28, deal maker: 0, paid: Yes, returned 1 to inventory (ID 5, new qty: 4)', 'DD', '2025-04-10 12:08:52'),
(94, 'add_sale', 'Added sale ID 53: Daniel Doubrava bought 1 Monster Doktor for 38 KÄ, deal maker: Adam, owner: DD, owner amount: 33 KÄ, deal maker amount: 5 KÄ, paid: Yes', 'DD', '2025-04-10 12:14:37'),
(95, 'edit_drink', 'Edited drink ID 1: Monster Ultra Zero, quantity 15, buy price 28 KÄ, sell price 38 KÄ, owner DD', 'DD', '2025-04-15 06:28:57'),
(96, 'edit_drink', 'Edited drink ID 3: Monster Classic, quantity 1, buy price 28 KÄ, sell price 38 KÄ, owner DD', 'DD', '2025-04-15 06:30:59'),
(97, 'edit_drink', 'Edited drink ID 5: Monster Doktor, quantity 2, buy price 30 KÄ, sell price 38 KÄ, owner DD', 'DD', '2025-04-15 06:31:20'),
(98, 'edit_drink', 'Edited drink ID 6: Monster Hamilton, quantity 5, buy price 28 KÄ, sell price 38 KÄ, owner DD', 'DD', '2025-04-15 06:31:33'),
(99, 'edit_drink', 'Edited drink ID 7: Monster Mango Loco, quantity 1, buy price 28 KÄ, sell price 38 KÄ, owner DD', 'DD', '2025-04-15 06:32:28'),
(100, 'edit_drink', 'Edited drink ID 11: Monster Khaotic, quantity 0, buy price 32 KÄ, sell price 38 KÄ, owner DD', 'DD', '2025-04-15 06:32:39'),
(101, 'edit_drink', 'Edited drink ID 8: Tiger Classic, quantity 5, buy price 15 KÄ, sell price 25 KÄ, owner DD', 'DD', '2025-04-15 06:32:57'),
(102, 'edit_drink', 'Edited drink ID 13: EverG Berries, quantity 3, buy price 10 KÄ, sell price 10 KÄ, owner DD', 'DD', '2025-04-15 06:33:13'),
(103, 'edit_drink', 'Edited drink ID 16: Crazy Wolf Limetka, quantity 2, buy price 10 KÄ, sell price 12 KÄ, owner DD', 'DD', '2025-04-15 06:33:57'),
(104, 'edit_drink', 'Edited drink ID 18: Crazy Wolf Zero, quantity 3, buy price 10 KÄ, sell price 12 KÄ, owner DD', 'DD', '2025-04-15 06:34:14'),
(105, 'edit_drink', 'Edited drink ID 19: Crazy Wolf Opuncie, quantity 2, buy price 10 KÄ, sell price 12 KÄ, owner DD', 'DD', '2025-04-15 06:34:25'),
(106, 'add_drink', 'Added 3 Tiger Speed at buy price 14 KÄ, sell price 25 KÄ, owner DD', 'DD', '2025-04-15 06:34:54'),
(107, 'edit_drink', 'Edited drink ID 8: Tiger Classic, quantity 5, buy price 14 KÄ, sell price 25 KÄ, owner DD', 'DD', '2025-04-15 06:35:13'),
(108, 'add_drink', 'Added 2 Tiger white at buy price 14 KÄ, sell price 25 KÄ, owner Adam', 'adam', '2025-04-15 09:56:57'),
(109, 'add_drink', 'Added 2 Tiger Gangsta Cola at buy price 14 KÄ, sell price 25 KÄ, owner Adam', 'adam', '2025-04-15 09:57:39'),
(110, 'delete_sale', 'Deleted sale ID 14: Roman Marchuk bought 1 of Tiger Classic for 25 KÄ on 2025-03-28 04:57:55, deal maker: DD, paid: Yes, returned 1 to inventory (ID 8, new qty: 6)', 'adam', '2025-04-15 09:58:04'),
(111, 'add_drink', 'Added 1 Big Shock Orange Mango at buy price 27 KÄ, sell price 33 KÄ, owner Adam', 'adam', '2025-04-15 09:59:40'),
(112, 'add_sale', 'Added sale ID 54: LukÃ¡Å¡ Pohorelec bought multiple items for 38 KÄ, deal maker: Adam, total owner amount: 33 KÄ, total deal maker amount: 5 KÄ, paid: Yes', 'DD', '2025-04-15 10:23:10'),
(113, 'add_customer', 'Added customer Filip JeÅ™Ã¡bek with notes: ', 'DD', '2025-04-15 10:23:47'),
(114, 'add_sale', 'Added sale ID 55: Filip JeÅ™Ã¡bek bought multiple items for 38 KÄ, deal maker: Adam, total owner amount: 33 KÄ, total deal maker amount: 5 KÄ, paid: Yes', 'DD', '2025-04-15 10:24:04'),
(115, 'delete_sale', 'Deleted sale ID 55: Filip JeÅ™Ã¡bek', 'DD', '2025-04-15 11:22:50'),
(116, 'delete_sale', 'Deleted sale ID 54: LukÃ¡Å¡ Pohorelec', 'DD', '2025-04-15 11:23:09'),
(117, 'add_sale', 'Added sale ID 56: LukÃ¡Å¡ Pohorelec bought multiple items for 76 KÄ, deal maker: Adam, total owner amount: 28 KÄ, total deal maker amount: -28 KÄ, paid: Yes', 'DD', '2025-04-15 11:23:32'),
(118, 'delete_sale', 'Deleted sale ID 56: LukÃ¡Å¡ Pohorelec', 'DD', '2025-04-15 11:26:48'),
(119, 'add_sale', 'Added sale ID 57: LukÃ¡Å¡ Pohorelec bought multiple items for 76 KÄ, deal maker: Adam, total owner amount: 66 KÄ, total deal maker amount: 10 KÄ, paid: Yes', 'DD', '2025-04-15 11:27:40'),
(120, 'delete_sale', 'Deleted sale ID 57: LukÃ¡Å¡ Pohorelec', 'DD', '2025-04-15 11:29:24'),
(121, 'add_sale', 'Added sale ID 58: LukÃ¡Å¡ Pohorelec bought multiple items for 76 KÄ, deal maker: Adam, total owner amount: 66 KÄ, total deal maker amount: 10 KÄ, paid: Yes', 'DD', '2025-04-15 11:33:36'),
(122, 'delete_sale', 'Deleted sale ID 58: LukÃ¡Å¡ Pohorelec', 'DD', '2025-04-15 11:33:52'),
(123, 'add_sale', 'Added sale ID 59: LukÃ¡Å¡ Pohorelec bought multiple items for 76 KÄ, deal maker: Adam, total owner amount: 66 KÄ, total deal maker amount: 10 KÄ, paid: Yes', 'DD', '2025-04-21 16:33:03'),
(124, 'delete_sale', 'Deleted sale ID 59: LukÃ¡Å¡ Pohorelec', 'DD', '2025-04-21 16:45:56'),
(125, 'add_sale', 'Added sale ID 60: LukÃ¡Å¡ Pohorelec bought multiple items for 76 KÄ, deal maker: Adam, total owner amount: 66 KÄ, total deal maker amount: 10 KÄ, paid: Yes', 'DD', '2025-04-21 16:46:08'),
(126, 'delete_sale', 'Deleted sale ID 60: LukÃ¡Å¡ Pohorelec', 'DD', '2025-04-21 16:46:15'),
(127, 'add_sale', 'Added sale ID 61: LukÃ¡Å¡ Pohorelec bought multiple items for 76 KÄ, deal maker: Adam, total owner amount: 66 KÄ, total deal maker amount: 10 KÄ, paid: Yes', 'DD', '2025-04-21 17:06:04'),
(128, 'delete_sale', 'Deleted sale ID 61: LukÃ¡Å¡ Pohorelec', 'DD', '2025-04-21 17:06:21'),
(129, 'add_sale', 'Added sale ID 62: LukÃ¡Å¡ Pohorelec bought multiple items for 76 KÄ, deal maker: Adam, total owner amount: 66 KÄ, total deal maker amount: 10 KÄ, paid: Yes', 'DD', '2025-04-21 17:06:31'),
(130, 'delete_sale', 'Deleted sale ID 62: LukÃ¡Å¡ Pohorelec', 'DD', '2025-04-21 17:15:04'),
(131, 'add_sale', 'Added sale ID 63: LukÃ¡Å¡ Pohorelec bought multiple items for 76 KÄ, deal maker: Adam, total owner amount: 66 KÄ, total deal maker amount: 10 KÄ, paid: Yes', 'DD', '2025-04-21 17:30:40'),
(132, 'delete_sale', 'Deleted sale ID 63: LukÃ¡Å¡ Pohorelec', 'DD', '2025-04-21 17:30:52'),
(133, 'add_sale', 'Added sale ID 64: Daniel Doubrava bought multiple items for 38 KÄ, deal maker: DD, total owner amount: 33 KÄ, total deal maker amount: 5 KÄ, paid: Yes', 'DD', '2025-04-21 17:31:20'),
(134, 'delete_sale', 'Deleted sale ID 64: Daniel Doubrava', 'DD', '2025-04-21 17:31:30'),
(135, 'add_sale', 'Added sale ID 65: LukÃ¡Å¡ Pohorelec bought multiple items for 76 KÄ, deal maker: ADAM, total owner amount: 66 KÄ, total deal maker amount: 10 KÄ, paid: Yes', 'DD', '2025-04-21 17:38:20'),
(136, 'delete_sale', 'Deleted sale ID 65: LukÃ¡Å¡ Pohorelec', 'DD', '2025-04-21 17:38:30'),
(137, 'add_sale', 'Added sale ID 66: LukÃ¡Å¡ Pohorelec bought multiple items for 76 KÄ, deal maker: ADAM, total owner amount: 66 KÄ, total deal maker amount: 10 KÄ, paid: Yes', 'DD', '2025-04-21 19:28:04'),
(138, 'delete_sale', 'Deleted sale ID 66: LukÃ¡Å¡ Pohorelec', 'DD', '2025-04-21 19:28:24'),
(139, 'add_sale', 'Added sale ID 67: LukÃ¡Å¡ Pohorelec bought multiple items for 76 KÄ, deal maker: ADAM, total owner amount: 66 KÄ, total deal maker amount: 10 KÄ, paid: Yes', 'DD', '2025-04-21 19:28:43');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
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
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `drink_name`, `quantity`, `buy_price`, `sell_price`, `owner`, `image`) VALUES
(1, 'Monster Ultra Zero', 13, 28, 38, 'DD', NULL),
(2, 'Monster Bad Apple', 0, 40, 45, 'DD', NULL),
(3, 'Monster Classic', 1, 28, 38, 'DD', NULL),
(4, 'Monster Doktor', 2, 28, 38, 'DD', NULL),
(5, 'Monster Doktor', 2, 30, 38, 'DD', NULL),
(6, 'Monster Hamilton', 5, 28, 38, 'DD', NULL),
(7, 'Monster Mango Loco', 1, 28, 38, 'DD', NULL),
(8, 'Tiger Classic', 6, 14, 25, 'DD', NULL),
(9, 'Semtex Air', 6, 20, 25, 'DD', NULL),
(11, 'Monster Khaotic', 0, 32, 38, 'DD', NULL),
(12, 'Monster Hamilton ÄŒervenÃ½', 0, 33, 45, 'Adam', NULL),
(13, 'EverG Berries', 3, 10, 10, 'DD', NULL),
(14, 'Semtex Air Zero', 1, 20, 25, 'Adam', NULL),
(15, 'Crazy Wolf Meloun', 2, 10, 12, 'DD', NULL),
(16, 'Crazy Wolf Limetka', 2, 10, 12, 'DD', NULL),
(17, 'Crazy Wolf Cassis', 5, 10, 12, 'DD', NULL),
(18, 'Crazy Wolf Zero', 3, 10, 12, 'DD', NULL),
(19, 'Crazy Wolf Opuncie', 2, 10, 12, 'DD', NULL),
(22, 'Tiger Speed', 3, 14, 25, 'DD', NULL),
(23, 'Tiger white', 2, 14, 25, 'Adam', NULL),
(24, 'Tiger Gangsta Cola', 2, 14, 25, 'Adam', NULL),
(25, 'Big Shock Orange Mango', 1, 27, 33, 'Adam', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `profits`
--

CREATE TABLE `profits` (
  `id` int(11) NOT NULL,
  `person` varchar(10) NOT NULL,
  `total_profit` int(10) DEFAULT 0,
  `clean_profit` int(10) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `profits`
--

INSERT INTO `profits` (`id`, `person`, `total_profit`, `clean_profit`) VALUES
(1, 'DD', 0, 0),
(2, 'Adam', 0, 0),
(3, 'DD', 0, 0),
(4, 'Adam', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `buyer_name` varchar(255) NOT NULL,
  `drink_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `amount_paid` int(11) NOT NULL,
  `purchase_date` datetime NOT NULL DEFAULT current_timestamp(),
  `is_paid` tinyint(1) NOT NULL DEFAULT 0,
  `deal_maker` varchar(50) DEFAULT NULL,
  `profit` int(11) NOT NULL,
  `owner_amount` int(11) NOT NULL,
  `deal_maker_amount` int(11) NOT NULL,
  `is_profit_split` tinyint(1) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `buyer_name`, `drink_name`, `quantity`, `amount_paid`, `purchase_date`, `is_paid`, `deal_maker`, `profit`, `owner_amount`, `deal_maker_amount`, `is_profit_split`) VALUES
(1, 'Honza LeteckÃ½', 'Monster Ultra Zero', 1, 38, '2025-03-27 08:10:15', 1, 'Adam', 0, 0, 0, 1),
(2, 'Pavel Kosour', 'Monster Ultra Zero', 1, 38, '2025-03-27 08:45:28', 1, 'Adam', 0, 0, 0, 1),
(6, 'Roman Marchuk', 'Monster Bad Apple', 1, 45, '2025-03-27 09:24:50', 1, 'Adam', 0, 0, 0, 1),
(7, 'LukÃ¡Å¡ Pohorelec', 'Monster Ultra Zero', 1, 38, '2025-03-27 09:28:10', 1, 'Adam', 0, 0, 0, 1),
(15, 'Pavel Kosour', 'Monster Bad Apple', 1, 45, '2025-03-28 04:58:32', 1, 'DD', 5, 42, 3, 1),
(16, 'Filip MareÄek', 'Monster Bad Apple', 1, 45, '2025-03-28 04:59:27', 1, 'DD', 5, 42, 3, 1),
(17, 'Martin Le', 'Crazy Wolf Limetka', 1, 12, '2025-03-28 05:15:42', 1, 'DD', 2, 11, 1, 1),
(18, 'Martin Le', 'Crazy Wolf Zero', 1, 12, '2025-03-28 05:15:59', 1, 'DD', 2, 11, 1, 1),
(19, 'Martin Le', 'Crazy Wolf Casis', 1, 12, '2025-03-28 05:16:25', 1, 'DD', 2, 11, 1, 1),
(20, 'LukÃ¡Å¡ Pohorelec', 'Monster Ultra Zero', 1, 38, '2025-03-28 09:30:20', 1, 'Adam', 10, 33, 5, 1),
(46, 'Martin Le', 'EverG Berries', 2, 20, '2025-04-10 04:46:08', 1, 'Adam', 0, 20, 0, 1),
(53, 'Daniel Doubrava', 'Monster Doktor', 1, 38, '2025-04-10 05:14:37', 1, 'Adam', 10, 33, 5, 1),
(51, 'Daniel Doubrava', 'Monster Ultra Zero', 1, 38, '2025-04-10 05:07:52', 1, 'Adam', 10, 33, 5, 1),
(67, 'LukÃ¡Å¡ Pohorelec', '', 0, 76, '2025-04-21 12:28:43', 1, 'ADAM', 20, 66, 10, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sale_items`
--

CREATE TABLE `sale_items` (
  `id` int(11) NOT NULL,
  `sale_id` int(11) NOT NULL,
  `drink_id` int(11) NOT NULL,
  `drink_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `buy_price` int(11) NOT NULL,
  `owner_amount` int(11) NOT NULL,
  `deal_maker_amount` int(11) NOT NULL,
  `sale_price` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `sale_items`
--

INSERT INTO `sale_items` (`id`, `sale_id`, `drink_id`, `drink_name`, `quantity`, `buy_price`, `owner_amount`, `deal_maker_amount`, `sale_price`) VALUES
(14, 67, 1, 'Monster Ultra Zero', 2, 28, 33, 5, 38);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'DD', '$2y$10$5/vslQsJd80ZmnB9oW8Lr.CQ7CJX8tSOrqwZ8wITlHWpSghjx/QoC', '2025-03-30 09:48:43'),
(2, 'adam', '$2y$10$wg9gV4s9XRZA0hOXC7Wg4./um7tJXqAjnEN3e2lnIp2Nh83uF9gCy', '2025-03-30 09:48:56');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`) USING HASH;

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `profits`
--
ALTER TABLE `profits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sale_items`
--
ALTER TABLE `sale_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sale_id` (`sale_id`),
  ADD KEY `drink_id` (`drink_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=140;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `profits`
--
ALTER TABLE `profits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `sale_items`
--
ALTER TABLE `sale_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
