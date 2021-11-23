-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 07, 2019 at 11:59 AM
-- Server version: 5.7.20-0ubuntu0.17.04.1
-- PHP Version: 7.0.22-0ubuntu0.17.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `proyecto-tienda`
--

-- --------------------------------------------------------

--
-- Table structure for table `productos`
--
--
-- Dumping data for table `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `id_categoria`, `precio`, `foto`, `destacado`, `fecha`, `carrusel`) VALUES
(1, 'Margaritas s', 'Bellis perennis, comúnmente llamada chiribita, margarita común, pascueta o vellorita es una planta herbácea muy utilizada a efectos decorativos mezclada con ...', 1, 15, 'php3Erxgt.jpg', 0, '2017-11-28 15:58:37', 'phpvg1SGI.jpg'),
(2, 'Tulipanes', 'Con su amplia gama de formas y colores, los tulipanes florecen a partir de mediados-finales de primavera y dan un toque de animación a patios y jardines.', 1, 12, 'php6p9520.jpg', 1, '2017-11-28 16:00:30', 'phpMMyjjA.jpg'),
(3, 'Flor de pascua', 'Euphorbia pulcherrima, conocida comúnmente como flor de Navidad, corona del Inca, nochebuena, flor de pascua o poinsetia, entre otros nombres, es una especie de la familia Euphorbiaceae nativa del sureste de México', 1, 15, 'phpNgUXup.jpg', 1, '2017-11-28 16:43:27', 'phpRNuDo5.jpg'),
(4, 'Rosas', 'El género Rosa está compuesto por un conocido grupo de arbustos espinosos y floridos representantes principales de la familia de las rosáceas. Se denomina ...', 1, 40, 'phpMWRktt.jpeg', 0, '2017-11-28 17:59:39', ''),
(5, 'Clavel', 'El clavel (Dianthus caryophyllus) es una planta herbácea perteneciente a la familia de las Caryophyllaceae, difundida en las regiones mediterráneas.', 1, 18, 'phphIt7ts.jpeg', 0, '2017-11-28 18:00:40', ''),
(6, 'Gerbera', 'Gerbera, es un género de plantas ornamentales de la familia Asteraceae. Comprende unas 150 especies descritas y de estas, solo 38 aceptadas.​​ ...', 1, 10, 'phpnO85wF.jpeg', 0, '2017-11-28 18:03:06', ''),
(7, 'Lilium', 'Las especies de Lilium, comúnmente llamadas azucenas o lirios, constituyen un género con alrededor de 110 integrantes que se incluye dentro de la familia de', 1, 25, 'phpHfrYNN.jpeg', 0, '2017-11-28 18:04:29', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
