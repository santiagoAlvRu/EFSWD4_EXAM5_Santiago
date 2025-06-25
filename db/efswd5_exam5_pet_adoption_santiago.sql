-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 25, 2025 at 09:08 AM
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
-- Database: `efswd5_exam5_pet_adoption_santiago`
--
CREATE DATABASE IF NOT EXISTS `efswd5_exam5_pet_adoption_santiago` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `efswd5_exam5_pet_adoption_santiago`;

-- --------------------------------------------------------

--
-- Table structure for table `pets`
--

CREATE TABLE `pets` (
  `id` int(11) NOT NULL,
  `name` varchar(75) NOT NULL,
  `breed` varchar(75) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `size` enum('X-Small','Small','Medium','Large','X-Large') NOT NULL,
  `age` tinyint(4) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `address` varchar(100) NOT NULL,
  `vaccinated` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `description` text NOT NULL,
  `status` enum('Adopted','Available') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pets`
--

INSERT INTO `pets` (`id`, `name`, `breed`, `gender`, `size`, `age`, `picture`, `address`, `vaccinated`, `description`, `status`) VALUES
(5, 'Cutie', 'Golden Retriever', 'Male', 'Medium', 2, '68581b924c1b2.jpg', 'Praterstraße 45', 'Yes', 'A friendly and familiar dog', 'Available'),
(6, 'Benito', 'Beagle', 'Male', 'Small', 2, '6859087326302.jpg', 'Margaretenstraße 41', 'Yes', 'Loyal and curious. Great with other pets', 'Available'),
(7, 'Luna', 'Chihuahua', 'Female', 'X-Small', 1, '6859090a82671.jpg', 'Kollingasse 8', 'Yes', 'Small but feisty. Prefers a quiet home.', 'Available'),
(22, 'Luli', 'Pomerania', 'Female', 'X-Small', 9, '685a670968ef9.jpg', 'Kollingasse 14', 'Yes', 'A lovely dog, great for a family.', 'Available'),
(23, 'Stevy', 'Bull Dog', 'Male', 'Medium', 9, '685a67986cbfb.jpg', 'Karmeliterplatz 2', 'Yes', 'A dog who loves to go outside, very sociable and respectfull.', 'Available');

-- --------------------------------------------------------

--
-- Table structure for table `pet_adoption`
--

CREATE TABLE `pet_adoption` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `pet_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pet_adoption`
--

INSERT INTO `pet_adoption` (`id`, `user_id`, `pet_id`) VALUES
(1, 16, 5),
(15, 16, 6);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `fname` varchar(100) NOT NULL,
  `lname` varchar(120) NOT NULL,
  `email` varchar(150) NOT NULL,
  `date_of_birth` date NOT NULL,
  `address` varchar(150) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('user','admin') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `fname`, `lname`, `email`, `date_of_birth`, `address`, `picture`, `password`, `status`) VALUES
(2, 'Santiago', 'Alvarez Ruiz', 'santiago@admin.com', '1990-01-19', 'Praterstrasse 23', '6857be11ec357.png', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', 'admin'),
(3, 'Maria', 'Lang', 'marialang@user.com', '1985-04-15', 'Margaretenstraße 15', '6857bb2571b3b.jpg', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', 'user'),
(15, 'John', 'Has', 'john@user.com', '1990-04-05', 'Praterstraße 12', '6859a2df67373.jpg', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', 'user'),
(16, 'Santiago', 'Alvarez Ruiz', 'santiago@user.com', '1990-02-19', 'Praterstraße 15', 'avatar.png', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pets`
--
ALTER TABLE `pets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pet_adoption`
--
ALTER TABLE `pet_adoption`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `pet_id` (`pet_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pets`
--
ALTER TABLE `pets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `pet_adoption`
--
ALTER TABLE `pet_adoption`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pet_adoption`
--
ALTER TABLE `pet_adoption`
  ADD CONSTRAINT `pet_adoption_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `pet_adoption_ibfk_2` FOREIGN KEY (`pet_id`) REFERENCES `pets` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
