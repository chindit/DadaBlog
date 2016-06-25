-- phpMyAdmin SQL Dump
-- version 4.6.0
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 29-04-2016 a las 16:04:02
-- Versión del servidor: 10.1.13-MariaDB
-- Versión de PHP: 7.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `DadaBlog`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articles`
--

CREATE TABLE `articles` (
  `id` int(10) UNSIGNED NOT NULL COMMENT 'ID de l''article',
  `titre` varchar(150) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Titre de l''article',
  `auteur` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Auteur de l''article',
  `contenu` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'Contenu de l''article',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Date de publication'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `commentaires`
--

CREATE TABLE `commentaires` (
  `id` int(10) UNSIGNED NOT NULL COMMENT 'Index',
  `article` int(10) UNSIGNED NOT NULL COMMENT 'ID de l''article',
  `auteur` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Nom de l''auteur',
  `email` varchar(125) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Email de l''auteur (du commentaire)',
  `message` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'Contenu du commentaire',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Date de soumission',
  `valide` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `pseudo` varchar(50) NOT NULL,
  `passwd` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `commentaires`
--
ALTER TABLE `commentaires`
  ADD PRIMARY KEY (`id`),
  ADD KEY `article` (`article`);

--
-- Indices de la tabla `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pseudo` (`pseudo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID de l''article', AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT de la tabla `commentaires`
--
ALTER TABLE `commentaires`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Index', AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT de la tabla `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `commentaires`
--
ALTER TABLE `commentaires`
  ADD CONSTRAINT `fk_commentaire_article` FOREIGN KEY (`article`) REFERENCES `articles` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
