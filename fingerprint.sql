-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 05, 2025 at 06:07 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fingerprint`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `attendance_date` date NOT NULL,
  `time` time NOT NULL,
  `action_type` varchar(255) NOT NULL,
  `sign_in_time` time DEFAULT NULL,
  `sign_out_time` varchar(255) DEFAULT NULL,
  `break_requested` tinyint(1) DEFAULT 0,
  `break_approved` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `user_id`, `attendance_date`, `time`, `action_type`, `sign_in_time`, `sign_out_time`, `break_requested`, `break_approved`) VALUES
(33, 23, '2025-03-04', '09:00:14', 'Sign-in', NULL, NULL, 0, 0),
(34, 23, '2025-03-04', '17:00:20', 'Sign-out', NULL, NULL, 0, 0),
(35, 23, '2025-03-05', '17:00:23', 'Sign-in', NULL, NULL, 0, 0),
(36, 23, '2025-03-05', '17:00:26', 'Sign-out', NULL, NULL, 0, 0),
(37, 23, '2025-03-05', '17:00:32', 'Sign-in', NULL, NULL, 0, 0),
(38, 23, '2025-03-05', '17:00:34', 'Sign-out', NULL, NULL, 0, 0),
(39, 23, '2025-03-05', '17:00:36', 'Sign-in', NULL, NULL, 0, 0),
(40, 23, '2025-03-05', '17:00:38', 'Sign-out', NULL, NULL, 0, 0),
(41, 24, '2025-03-05', '18:00:13', 'Sign-in', NULL, NULL, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `leave_requests`
--

CREATE TABLE `leave_requests` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `leave_time` time NOT NULL,
  `return_time` time NOT NULL,
  `reason` text NOT NULL,
  `admin_reason` text NOT NULL,
  `status` enum('pending','approved','denied') DEFAULT 'pending',
  `request_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `extended_time` time DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `leave_requests`
--

INSERT INTO `leave_requests` (`id`, `user_id`, `leave_time`, `return_time`, `reason`, `admin_reason`, `status`, `request_time`, `extended_time`, `created_at`) VALUES
(1, 4, '10:00:00', '12:40:00', 'my reason', '', 'denied', '2024-10-03 00:44:48', NULL, '2024-10-03 00:46:37'),
(10, 12, '09:00:00', '11:00:00', 'For Errand', '', 'denied', '2025-01-28 17:33:00', NULL, '2025-01-28 17:33:00'),
(11, 13, '12:00:00', '14:00:00', 'Lunch', '', 'approved', '2025-01-28 17:43:09', NULL, '2025-01-28 17:43:09'),
(12, 18, '11:00:00', '14:54:00', 'bank', '', 'approved', '2025-02-11 13:50:09', NULL, '2025-02-11 13:50:09'),
(13, 18, '12:00:00', '13:00:00', 'lunch', '', 'pending', '2025-02-13 14:06:02', NULL, '2025-02-13 14:06:02'),
(14, 21, '08:00:00', '11:30:00', 'For fun', '', 'pending', '2025-02-26 11:46:25', NULL, '2025-02-26 11:46:25'),
(15, 23, '10:00:00', '10:30:00', 'Bank Activities', 'You have extra work task', 'denied', '2025-03-05 15:47:31', NULL, '2025-03-05 15:47:31'),
(16, 23, '10:30:00', '12:30:00', 'Medical', 'Directors instruction, see him.', 'denied', '2025-03-05 16:35:03', NULL, '2025-03-05 16:35:03');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `indexfinger` varchar(4000) DEFAULT NULL,
  `middlefinger` varchar(4000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `fullname`, `email`, `password`, `role`, `indexfinger`, `middlefinger`) VALUES
(22, '', 'example', 'hello@example.com', '$2y$10$44oa.cDagS50g/M8E35BWuhk7AgMbNhHIYEk1J4TVO/asMqNoaOXS', 'user', '', ''),
(23, '', 'user', 'user@example.com', '$2y$10$uD8TWx5tSdkt5ERGZtIyg.uF3DqYOnReaCxoCUhahNYaZYbQsotEK', 'user', 'APiAAcgq43NcwEE3CatxsKIUVZIRista2gf0OCkhA3c4yn-r1MTJJqI5ofqITPDOiORPSFl2ZrpfHcTaA5Y5E1lL4hU5UZZdeiceY6fkl4C-XYda6iD6xL-X1rSVb9hT1yWcXWzwI9zmLT4JO8ekZsWsMAQzcGb4tE4xpE0dXvnDSud4TxwoNX4a7nMPIlf9GgpbbNUQMiwndw0z_1CBFALWIhZiKIYSGZSN5aDLMTXqNqiIUGIDj6kLlrMw0JKuCIzKDAVmXQ8n3kLFBV7Ae1fs7mxxSkiYgk_np5Sh7wNPJRrHC8umQiFli9_Nvw8NIDYZijzr36A6-sP-igbALcgq1WeCh3xbEKUN6JN6qi4Ye89U4CVgeq4ondhb_lrQKQZ3jSKLQfaHY9QpsZsMJ9rwSAt82Jh9W6RejFkndcpO4E-1riNBOOchn_ygeF3CZZwVs3euEuk9MLTmygZRcGIvFbDKT6QkJA1G0lZV0MOEzVsX9Zh3e4ZU38WGTEmV4BvBu28A-H8ByCrjc1zAQTcJq3EwvRRVknMfvkT8-PL5y0riK3cw89iko-MKRO8HRM7JwcoSAPlG8smo2Tji9DQDY5A6vbCOv2UbBpgqbbBA5gjYkEqscNSN0iyPsjpYFIxPwvOkiA8eEVs80W6YCdugSy2OLn-hMxIn6wvMzJ1Mad6E6tGafBlBIImt-UBjKodaolUJhtRTtIF5K_rfsuvY_rCT7KuKmMgOvrG45JzHQEB0u6hEXKwTCAE88YqE-w8Dys5qf7cWnnHaierj9dFrYMlXWEProIeBpveTHYBtshrJHiI36u6piTbIT1SQ_o4FnwyJctzWxE9TCKWYtVWzivC-VzgeHPkjcAJX94jWOeqmgsyZLjwHt7EnaOwjeEA_LXcPAAzjQuwXo399f3BK-jxSa-A9pVxDfhp6kUfK7qavTRk4bnslr95nuAYriABnectxREADCNZfw45y8PYJiujRa9bj5sPtJBWA3e8WOMRnT6qVDnT4rdhMaCzPG1BS2rDIj05vAPiAAcgq43NcwEE3CatxcLwUVZLa8QrlgX-VzqsMp3NLAsy6Mf4bxI2gtlR7EL_IX9IvTs7lr2QYNT-hGXS2ONTw_rBBUUcX7YuD3jp7BPNjTzrO3cwUDXB7QcLhRsp-2G35aJEq5x_1-e2Oz7hxItKdfAO_suV9QpEFf0ipTHAvYG86U5jNUVT3kAiFLZ5NPNn05PFKjzVSj4k823b5q2repxJPi6Rt0kbvrqk6SRJDUMqMvLxNn3w6pgpZGAKQBmYCtXQYOTGKdWTLk33Fhn54xemkvby3YUBNaWC1f4ynBYlFSHC1xgaa0Tn4d4ML-AZG0tifOk3F23LdotIorKIyB--oQuiMmHJ59J4eLOY1r__Ebb9CDOW0POz3UN8IewkU23YvaM9QSj_MsdiUZ5CaX6R6gXFwHLCmUa5skh81uRo0I9v2vAHDi8K-i4QvVdV3XBZPj68sXTzKNNZ4RkRIm5vTAstwHklWeP9Fgl1TaqJQnqVdP9agI979lkwdxaMJdm8A6IEByCrjc1zAQTcJq3GwthRVkl6alL6cwbeJkmxH1MsoytJxvwAqgg2jI3dTUNITCGJtgpamLi7tcOptf1plmK1t_rN_ErSPxM5Gj8TV1UBM4ClD4FMpztmOUH9wZIXfbaGCL-NrSAxaCXkhVESgB08M9RZrE5mk2Kqo4OCeaApiUNgeWsyn2svvcYdhG6fjOJ1PlnEFPbPjKN3cyCUExCWZKKm-D_N08g6iNfpIV5rJMitdpHhEfbiV_bSKX2rfhXIb9cPvOCDyK-z07UXxYZ0iQO6e3xeQxobUckLv44cr23t4qA9x5_GRlqpLC4fXP70pX2KuhY70XeIfGt0ExRv9LRDExE_KiTbIXqXfV9aSGHmlBt0bZWUSyNyZkz03mHGXLyVsoM7JDKrC89coeRZLc9_5rkNdhdak18_0tKehMzPb7bWEfzmh74sjIAMrW-MHek2oFT7Yk94O9zEa02vhxZnRWEpZ_GHAudppzHdDU4sEu5A_8Zd7fx4boRipFmd5Um8xfwAAbzc-9LlVAACIeQEcMX8AANhUARwxfwAA4GV_LjF_AADwVAEcMX8AAOBlfy4xfwAAryJS9LlVAACIeQEcMX8AANhUARwxfwAAMFkBHDF_AAA', 'APiAAcgq43NcwEE3Catx8KAUVZKEU_4dqmhLRkMkwNgoJLAhG4-zjDki0DTPxE0YxK3xxSSXTpf1cclHXSWeuHb19o4R0SL8bay0EbWLUyCtfysw56faa_7iuB4YaoC66uYJ940EWn0oEWSY-C4lEib5vBQlwQx-Oq8iKdG01mYGzWdX1lzlHnzmCvxFeCj9j0W9_fvneRH0fIUVJCeez-eI4GcZWYz1lRYc48vAxTrR-9ZrYy_LOf0nB_9dCVazNkYh-6yV1ikKWTM29E29aJdXw_pyA9M2RhKEFKDs1FULSYHR2UKlp_ZTdxysFdGTbeXxP_zdyVQ7HQ39TxnXrcPmMRwxvtjj8azSYlkCvQcmZFT2eD7Ldw59cFw31keDJpXJsas-UJ2ol77wsrxyz-R7K_xf3lxs0ZCyahsMLZII-K2LkUpHGTstHMcYys9xdh5-PsHKLQTG1LmxcZHIpZx6hqeQybKo0QRrys5JCnb00IcQrP8ROGcphVOXghfGAGFJhG8A-H8ByCrjc1zAQTcJq3GwkxRVkkiczuXjwJwOIezUYWpMzTQwUwn4ZBOjpVHX7mkPOWzvDqHMVHRv5k9sPhXuV3YQq394xM9e0xMYkorXxQW9SPX0O8tOJ39IniSVZmFHffXuJkowhzgUrnkml69hPkTdAKNv27Zk_8fWQpGDjoyxo8TEH4Y08SY8WxaU4ZrUqhpHn6tXDx-vXVPFYDmGiEGJp3-Ub5IkCzM1dJpzxOTuHFDUzAh67M0LP4njPLbj7cSBDRfev3LkHcYvoJkwiA2iP1yhu5PhrwxP97PyMielZ5tVII2jsFX8Lz8NZRw-7MN__yVwgUtZDEQKYA6mQrc9V8gouTN_QJiskJd8G4Jzf5AW0TrzmkooOdKaWWGe5AbZq4LuZYfw0j5PyO75MPwAiC6_HKsU9CjlIvB_oZY63NOEYO8clSG01ap66BJGfAA58w-vdzqDyTQA_kFmVxv5QCN5SWXkpbsnVHsk6dxBI11636SdouFYIhBlFGExzXJvAPiAAcgq43NcwEE3Catx8KMUVZIvbkRtP03Ba-ALgzBfg1ZKgqZp8BOEnBJTS6_O0YZThP2hjaEUfIpaaCP6qxUpY6KQ0xCfIvIEhTSdBr6h2sqfZtenp2vLLLiKVjgwwH9fYKjX_celM-PxV7oL2IOgK2ooSK46b1W5i8jYJOMEl6XLpFsUGtLvVMZYLSXwCLs25p_FGKKauspq5o6dkA5kzznGAndxbts5i8imM_s4FHwbb3wgn9MHa3Fj0i9cnodfV-DqbCN5U47APC5Oq3XjkksN_2xPgsI9Mbr4YgH8jdzD8mLuQEgNNYHwMjy36amu8pLvwoOkAeAY5QS8eKYXtTo6L2WXkFTYylUi3ei7vT8P8FSfIT07sWjfM2rUy4NfWpJgOZaNYg8Wk1N3koZKacyNuY3QrxXn6rgn5lS-L9x-T7x3Nq8C4NFmRm749sT3G3Q81XqSWXyfrEkZtBhhm9ZJpu8MpSgOnMASIHAYjQ3P7SmxV8-DeNruJq9VOpoHYG8A6IAByCrjc1zAQTcJq3GwvRRVkvoYjMwtemwv66gf2Ny2TFBZ2S0RooLuyjFW9w25IxHS6jar7yWtpg8HGJgI0BkBKEeLvpKmtElk2wqqlFGK7AJhsxF0Jc5A6UuykZdlq2jEEDWcY6d3xlZKVsjRaPji34JT-mlJZDZ1CkcSHPM2LvqCgxqI2hQqrW7Sx7Ixk_BNGIGGNoJwU8AO4wUKObLzq8idYIwmZxOqqHrTUD8ofgXaSFM9guTa6UWT4rcyalAR3mGecIgBhVFPoVg8E_3jYKmauM-u9wtTWbQjzRfBjv_EG9rgMgnzaZwMzs0o9IUsuJv0wbTzhdTVRiuLHkDMO6EpktwOg_jn34LVwugqcbZSjSwokPZkVShM9MiOVI4-7jEUsf3srrx7aq6ZJ_fgko2ij590jFB97my0C4PtwOcrQNF64K8BMQXYzIPBiHFe98sOfv5JCa1mlkkC7XG-wGTf1hGCuzX5Vf75ykdZ-IPfepIOeBuEYJCh2Z6H8GEyby4xfwAAbzc-9LlVAACIeQEcMX8AANhUARwxfwAA4GV_LjF_AADwVAEcMX8AAOBlfy4xfwAAryJS9LlVAACIeQEcMX8AANhUARwxfwAAMFkBHDF_AAA'),
(24, '', 'admin', 'admin@example.com', '$2y$10$RjmFrSRUl4ZVsF285OEws.MQFle8Ezey/qvz/8IpkweJnK3XXtiiS', 'admin', 'APh2Acgq43NcwEE3Catx8LgUVZIGfbdBlg_HlinywMn7XxkhCqDCpSv6C-RIpCRD3S9ftz6pUYthj70R6NU_0yLSCTy4jJg2P9IDj6hkls4TtT9PgG6Oe79l06NAskLj8kBEBOVzWwxkpOf2bfFIkdyNqew62vZPyjzgxnVKcLfZ7RdYcJj1oaOSDRSzZjYfQyBiELZLkVUS5EHd4u_TRAP7khxH1wxsQzU_bRyEfvAMWQCH47V5OHmDxVhi-Sr7qC5Yfu_kAFdhHVUz7P7ibnhdv4zBOg04iBbOCK2oaGMEme-ZDWwN_yqZhTen7t5FDB20FaMDKPQtoQ9SHcs01R7kdQma7RrkQD-tWq7MjZGcIUET7rCdL6cooDCsotnSy3goTm1Q1JgPkuucbHF_aC-a54wUd264TVc6_shRii8cbTXBrtcsNRlojuZQN_ev_6FsJ9dInD7isGUjI1cKw-zlDtDNq2L0uY6KOg9IAL0egKWFaXb9lszCbwD4KwHIKuNzXMBBNwmrcTC_FFWSeLSFtDdXAmNI8Kn41TjO5lfSkTOZ2MeLpRky1eTDR21FQ6_QcdLqL2HtNe2J-b_y6ntRnehACSIeJnJ-LxFXIGqt-Y2HLJFGz_KM3sc-RA8clgdqgLb_fXwkpTx6Of94ggGK4Zv8qqLqN-_p00-I6_57V1rGryoXsT-fwhw1u3-3SdHi2XnbXAPpZelRc4WKeACLZLX4x45ntYfTwwRXGc3BB1QTBvNFA88dmnUdlRVme9n27Jm0KqOiLs_i_4iSARODHBSMcFijmldjhYEoBktvt8SuarluZYOJLSypQWniSqy4RWoPV7luL5O0HzJuluKKBGMxXZClo556cnQg8D2zIICB0OKMZWdBiTUwOgpfLth6OKe2WtCMQ28A-IAByCrjc1zAQTcJq3GwuBRVkif5USrdKwzwx7gtB0dDOdqTGuMCOM4DFfHQB5phyK03qKIRAvkwjOCJmCPwcVGU07rd6Hj7FA7w6UlYlQDRc6IQADpt5JyrGM0D4p0UkAIpi-6x8yKf3yaYxoHg69lUGK2Q7svsNJT1nf4sdVepL5JEcvBXHCY_fZlc0yZDz7NdHtoCM0NC41THVKsHON1HaUghhHN2FQqkvVzHmmbnbKsCvd4LeMediV-XeQvcZAkui-1wJ5dcnPzFRy2BPCwmChL8iSP5gf9rKNhwSIfmTlXwHknxfLF6oQGtLrDBMhoWB84Uxtkdgeg8OYCEip8K1dx4ffEtMtTJpbYMZvqUHubNxPocSa6lpuXEJxFL0B1FS_xnz5xrLv_LIEhiIE2dGveMYTV2ObUWNN6RfqWurHFFZchX-VRf6AjSR4KBIMfeesD4uJnB8h67-9EL_rsqidInIMPu75Nqrgd1GYY-LIqbxi5lLanIOH7NKJrAq9CXbwDoPgHIKuNzXMBBNwmrcfC7FFWSeGcXFgOmZYESRAo6OilekXV-k_G84tSSMDh_tUF91xtzO-g2s_oknqsP3n4JgViQ78ma90Q27b-OETpr58zHab2eBDIDeJXLkz23GiA-DKnGwfbakuLMcYBl0nSyPQI68LtrYWoHufzbGtgMIfYg91EtM8tdIxMjeK-0UJABubSS6XTeShxv_-b5_QTmkPaZrbtjKAoQvH3KMg2araAWli5T3Ny8p5DTS_xEOnJVZpMARgFv09OEFbG4hjKEQQHWaf2iznpE8owuWrYmTKWAHHDKhX-Afji1Y-hg5PZQ8bi0_xgRxGVNQpBsgzwMZfd75WEtbCRy68rqaDPlbNGkNs6OsEafeLqJnUr6ah8Dd_SihxQiYGzhZk2Psj_aN66tUORUKZd0I41tJ5baHuRvgBZWAABQAQGc6X8AACA1r67pfwAAbwejZxZWAAAIGwGc6X8AAHD2AJzpfwAACBMAAEkAAACI9gCc6X8AAFA1r67pfwAAQdi2ZxZWAADgfAGAFlYAAAgbAZzpfwAAcPYAnOl_AABw_QCc6X8AAIA1r67pfwAAe9i2ZxZWAAAIGwGc6X8AAHD2AJzpfwAA4HwBgBZWAABw_QCc6X8AALA1r67pfwAAbwejZxZWAAAIGwGc6X8AAFj2AJzpfwAA4DWvrul_AABw9gCc6X8AAOA1r67pfwAAr_K2ZxZWAAAIGwGc6X8AAFj2AJzpfwAAsPoAnOl_AAA', 'APh_Acgq43NcwEE3CatxcKAUVZJBhg4Fa1BzpEAHVSs5Rq7v5hoNkHjI_cgPH5XUwbm6VGc1EKaNcEd3OMW-GIbpkEXjpJPAW9tjXXNOkrqUst2vhAqGBdRY1JNOu4yqGaO7832rjz7WNdZJ_yVLDtnrGiwC1Xl_k1aiwXmIWuNuuo1ZcdEN8obkua5Fg6GgOKK36vzTC7UdSeMdfwvKVTdBsfGXehEOofGQ600cg5v3Bqx-fSzIClIuG8449AoThXu2cZGqY8zbdtshTvySRxbALCy51gATsmHOt0Uei06fYLZ_V7omYT9XgZrQchaPmGeJJZdBZVaOJ-NookKlU8vr4fLj1b1p77ELgxrOKkeRssvkfWYkrFsY4JRf3wjsaSCHr8Zch0S3Lhb-9cQ6-jZAoVhchWtqcAeVSjL3XW80GjJMJ0Mh7QYJmCTuOjwjdig0K2iNcLr739Vz6dvsQk9l0xAgV7VodE19x9wBzpn8_s8xozMWvGJyj7fH61PpN9OPbwD4gQHIKuNzXMBBNwmrcXCxFFWSyXgzoDCXTCW2kEdQQO0VAJu48WWyAFBBdxQluNOb9BiCWIhtNzv5_gSawfP96BHVdQMt3dt_baCbkPZFnp8jJWVwh3b9G38im8IHUKiowWxAQ7h18mnCnpPW3M8P0v0CWu-W4d0L3g0B0S6c_ZlT_smB8x2ELMQ3UHtLBVs2wXapCoSQbeWfYQI75es1_D5Gx-GcSl5QbBM6WfJ5nzvmpOOjMtdSXVC2l5B3H69QeMwgd6ZclfP7gMHMXvUvtTVXZMLaxTl2vNnXGB4RwMC0AtzTWBohqTWYAfPC5vGP0IdAojHqGImWQcZqtt-Zz02yYnXnPFSmrRCTyXxGKgAcoZut3nEm7ZoGF9AH19O_8xeb2UsHfMsmFA7fq1IIj6kSJsKEPZ-RhfRl2vJ79o22AzgV7sYB67EY93oCczVjjje7lhkgx53_qbekhLpZKmgB_uo_qRFSdcIwQ8brT3oFNyARvHOjyYLD0BHn6O5pKG4sbwD4gQHIKuNzXMBBNwmrcfC3FFWSk6Py_nsDdqcuruW_S13He00haEu92tu_xCQiRw1FIwkYW6PVWY_Ze6X8DEiwHdl9UfL-vCW_A5ms9t8uz1yWyWottckF90-C_92jLsCgHPQR6MUdLq4EQm1HfZkuPX3M2nFtjdMXKV709omZsxmjOUXQXx1jLJsEphq73GL6Tr0yf0bZDArPn66zBctPVi2K8w6-N9L3LSyTt6UNEljlFDtj-SXm_9NiH9FUig6zaeCPe-hRgZfPV4KP08JVbp0Ft9JcoVOHqHnzrXkmNaOdThWasv_tcmE159Rxi5Iv-V-Ldqpd3FOCmaQ3y3IWzZIZY9YwB1zdsM9Lq3-PGPuc24lEIU-yEeE4W0kuBFcAp4D3Cp1l_oeq0D4slp5IpKiYXnzQ5TfX8VQ36vZVkG4cn1WWdir52Tzco1MQt9enOIiNut2XjmI8y4LZxGMKRe-JeOExYclG1ANmEQmEasN23OhAVI2CU6hjvcNF6YYij4pAbwDogQHIKuNzXMBBNwmrcbCjFFWSFhQ_LYVUXKZbFPuVOoCprQVaTd-eCvT-ZiWqFQQzgQZKlqdDmq8M4a2W4Xnl5Ae7LGVfKeCN-oQcKgtCzBlgWg7bu0lT0TD_DMG5ftn-ImAch7yLhRuRHiqmXEtmVseRD4bv07RhzNQGVjCtMZhUmCN5kiziIZg5FMX7tl7KC8OXEXnD4Yy-lCi1RFKe_WbuZs4IFQv73RfE3kadZLyzlIrTpKF7XTuH8BeiVClkNiLOzmkJAcWy9BE6j3qGLU_038cqx0SRIejXnZMja0TpVXpVgvFH0j01_VzaY1y8_02V_Po-4xYw6BfJQBUcMi2U13uS0swy_XjTO682J_bKJrgdMyHS7CulXphLPn-9WDG9hSg6alyuSMydvKQHwmbPbEssl3LW2_nCWDw6EUrHCQFfzsSmoS3LmGK2a3_1Iu0MSc815YwqSmSUGGX_loK7rFPJ2tVKzfeGcBX7JBB-DZt6ibYiQTdfyhnqrOKwMYYEbwAAbwejZxZWAADInAGY6X8AABh4AZjpfwAA4EUvr-l_AAAweAGY6X8AAOBFL6_pfwAAr_K2ZxZWAADInAGY6X8AABh4AZjpfwAAcHwBmOl_AAA'),
(25, '', 'test', 'test@example.com', '$2y$10$r999tWu9I5Np6XKjLuHqp..5wOf9hkHpTI8AMYxObjNqL5jpjc0OO', 'user', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_profiles`
--

CREATE TABLE `user_profiles` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_of_birth` date NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `rank_level` int(11) NOT NULL CHECK (`rank_level` between 4 and 12),
  `department` enum('Transmission','Distribution','Customer Service','Maintenance') NOT NULL,
  `staff_id` varchar(10) NOT NULL,
  `address_staff` varchar(255) NOT NULL,
  `next_of_kin_name` varchar(100) NOT NULL,
  `next_of_kin_phone` varchar(15) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `leave_requests`
--
ALTER TABLE `leave_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `staff_id` (`staff_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `leave_requests`
--
ALTER TABLE `leave_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `user_profiles`
--
ALTER TABLE `user_profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `leave_requests`
--
ALTER TABLE `leave_requests`
  ADD CONSTRAINT `leave_requests_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD CONSTRAINT `user_profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
