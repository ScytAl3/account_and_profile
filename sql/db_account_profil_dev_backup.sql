-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 29 juil. 2020 à 09:34
-- Version du serveur :  10.4.10-MariaDB
-- Version de PHP : 7.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `db_account_profil_dev`
--

-- --------------------------------------------------------

--
-- Structure de la table `astrological_sign`
--

DROP TABLE IF EXISTS `astrological_sign`;
CREATE TABLE IF NOT EXISTS `astrological_sign` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sign_name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `astrological_sign`
--

INSERT INTO `astrological_sign` (`id`, `sign_name`) VALUES
(1, 'Bélier'),
(2, 'Taureau'),
(3, 'Gémeaux'),
(4, 'Cancer'),
(5, 'Lion'),
(6, 'Vierge'),
(7, 'Balance'),
(8, 'Scorpion'),
(9, 'Sagittaire'),
(10, 'Capricorne'),
(11, 'Verseau'),
(12, 'Poissons');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lastName` varchar(100) NOT NULL,
  `firstName` varchar(100) NOT NULL,
  `dateOfBirth` date DEFAULT NULL,
  `placeOfBirth` varchar(100) DEFAULT NULL,
  `astrological_sign` varchar(50) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) NOT NULL,
  `presentation` text DEFAULT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'ROLE_USER',
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `lastName`, `firstName`, `dateOfBirth`, `placeOfBirth`, `astrological_sign`, `email`, `password`, `salt`, `presentation`, `role`, `created_at`) VALUES
(1, 'Doe', 'John', NULL, '', '', 'j.doe@example.com', '54e4feb636204d1e5fcf49fb202946db', 'b7c8cb5b20beb2733470a65bb59722de', '', 'ROLE_USER', '2020-05-07 11:17:30'),
(2, 'Jobs', 'Steven Paul', '1955-02-24', 'San Francisco', 'Verseau', 'amazing@example.com', '1f1c153c6717024f825a862901f9c3bc', '476e62fcde5fcaa1e7fc2629da120ce9', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc omni virtuti vitium contrario nomine opponitur. Quod cum dixissent, ille contra. Summus dolor plures dies manere non potest? Sed plane dicit quod intellegit. Quamquam id quidem, infinitum est in hac urbe', 'ROLE_USER', '2020-05-07 11:17:30'),
(3, 'Bli', 'Miss', NULL, '', '', 'miss.bli@example.com', '3c16807baa54ff9ed18b6b1a16308de0', '534459a92de7399e936189ecced337bf', '', 'ROLE_USER', '2020-05-07 11:19:04'),
(4, 'Blo', 'Mister', '1995-08-11', 'Paris', 'Lion', 'mister.blo@example.com', '2392595c8540e0e26c1b988eca8142b1', 'f3dfe26ddbd340e3ff845b89c6ab471b', 'Vivamus consectetuer hendrerit lacus. Praesent blandit laoreet nibh. Etiam sit amet orci eget eros faucibus tincidunt. Aenean imperdiet. Pellentesque dapibus hendrerit tortor.', 'ROLE_USER', '2020-05-07 11:50:10'),
(5, 'Test', 'Last', NULL, '', '', 'last.test@example.com', '9838e129bfbf4fc172e0e0e32508cf66', '697252c76065a6bea3a08f58d38aaa23', '', 'ROLE_USER', '2020-05-07 12:47:22');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
