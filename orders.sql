-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 01, 2017 at 01:47 PM
-- Server version: 5.7.14
-- PHP Version: 7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `demo`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
                          `id` int(11) NOT NULL,
                          `name` varchar(250) NOT NULL,
                          `datecreation` date NOT NULL,
                          `status` tinyint(1) NOT NULL,
                          `orderstatus` varchar(250) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ordersdetail`
--

CREATE TABLE `ordersdetail` (
                                `id` int(11) NOT NULL,
                                `ordersid` int(11) NOT NULL,
                                `productid` int(11) NOT NULL,
                                `quantity` int(11) NOT NULL,
                                `price` decimal(10,0) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
                           `id` int(8) NOT NULL,
                           `name` varchar(255) NOT NULL,
                           `code` varchar(255) NOT NULL,
                           `image` text NOT NULL,
                           `price` double(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `code`, `image`, `price`) VALUES
(1, 'Beef Bacon Burger', 'BBB01', 'product-images/BeefBacon.jpg', 200.00),
(2, 'Tango Taco', 'TT001', 'product-images/Taco.jpg', 100.00),
(3, 'Club Sandwich', 'CS001', 'product-images/salamisandwitch.jpg', 150.00),
(4, 'Chicken Burger', 'CB001', 'product-images/ChickenBurger.jpg', 200.00),
(5, 'Fries', 'F001', 'product-images/Fries.jpg', 80.00),
(6, 'Hot Dog', 'HD001', 'product-images/hotdog.jpg', 100.00),
(7, 'Can Coke', 'CC001', 'product-images/cancoke.jpg', 80.00),
(8, 'Salad Bowl', 'SB001', 'product-images/MedBowl-EGG.jpg', 150.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ordersdetail`
--
ALTER TABLE `ordersdetail`
    ADD PRIMARY KEY (`productid`,`ordersid`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
    ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;