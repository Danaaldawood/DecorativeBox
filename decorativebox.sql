-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 17, 2024 at 08:11 AM
-- Server version: 5.7.24
-- PHP Version: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `decorativebox`
--

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `id` int(11) NOT NULL,
  `firstName` varchar(200) NOT NULL,
  `lastName` varchar(200) NOT NULL,
  `emailAddress` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`id`, `firstName`, `lastName`, `emailAddress`, `password`) VALUES
(3, 'Lama', 'Alenzi', 'Lama.Alenzi@gmail.com', '$2y$10$3JZUuY3Jb67ST78OrrMp6eCU.3nQ8EdtHzaRXSQAkroxb1AXV1QIO'),
(4, 'Turki', 'Aldhayan', 'Turki.Aldhayan@gmail.com', '$2y$10$vEJk0TT8C75P9E41oEJaUuwAD1EXu/I4h/GAh7CGQa3CR4ToiewTm');

-- --------------------------------------------------------

--
-- Table structure for table `designcategory`
--

CREATE TABLE `designcategory` (
  `id` int(11) NOT NULL,
  `category` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `designcategory`
--

INSERT INTO `designcategory` (`id`, `category`) VALUES
(1, 'Modern'),
(2, 'Country'),
(3, 'Coastal'),
(4, 'Bohemian');

-- --------------------------------------------------------

--
-- Table structure for table `designconsultation`
--

CREATE TABLE `designconsultation` (
  `id` int(11) NOT NULL,
  `requestID` int(11) NOT NULL,
  `consultation` varchar(500) NOT NULL,
  `consultationImgFileName` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `designconsultation`
--

INSERT INTO `designconsultation` (`id`, `requestID`, `consultation`, `consultationImgFileName`) VALUES
(4, 6, 'Living room with white theme.', '661f7dea0ebe8.jpg'),
(5, 10, 'Living room - Country style - Light grey and brown.', '661f8361a595c.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `designconsultationrequest`
--

CREATE TABLE `designconsultationrequest` (
  `id` int(11) NOT NULL,
  `clientID` int(11) DEFAULT NULL,
  `designerID` int(11) DEFAULT NULL,
  `roomTypeID` int(11) NOT NULL,
  `designCategoryID` int(11) NOT NULL,
  `roomWidth` int(11) NOT NULL,
  `roomLength` int(11) NOT NULL,
  `colorPreferences` varchar(200) NOT NULL,
  `date` varchar(200) NOT NULL,
  `statusID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `designconsultationrequest`
--

INSERT INTO `designconsultationrequest` (`id`, `clientID`, `designerID`, `roomTypeID`, `designCategoryID`, `roomWidth`, `roomLength`, `colorPreferences`, `date`, `statusID`) VALUES
(6, 3, 2, 2, 1, 4, 5, 'White', '2024-04-17', 2),
(7, 3, 2, 4, 2, 7, 8, 'Blue and white', '2024-04-17', 3),
(8, 3, 3, 4, 2, 7, 8, 'White and blue', '2024-04-17', 1),
(9, 4, 4, 1, 4, 20, 15, 'Green and brown.', '2024-04-17', 3),
(10, 4, 4, 1, 2, 7, 8, 'Light grey and brown.', '2024-04-17', 2),
(11, 4, 3, 1, 2, 3, 4, 'Black and white', '2024-04-17', 1);

-- --------------------------------------------------------

--
-- Table structure for table `designer`
--

CREATE TABLE `designer` (
  `id` int(11) NOT NULL,
  `firstName` varchar(200) NOT NULL,
  `lastName` varchar(200) NOT NULL,
  `emailAddress` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `brandName` varchar(200) NOT NULL,
  `logoImgFileName` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `designer`
--

INSERT INTO `designer` (`id`, `firstName`, `lastName`, `emailAddress`, `password`, `brandName`, `logoImgFileName`) VALUES
(2, 'Aljawhara', 'Aldhayan', 'Aljawhara\'Aldhayan@gmail.com', '$2y$10$6cP6niDdvW.UCqJfou5EweAXxv2P6iKzMZvA7G2RsPSxJQ3Us0HFK', 'RadiantRooms', '661f791b88a8a0.40003396.png'),
(3, 'Dana', 'Aldawood', 'Dana.Aldawood@hotmail.com', '$2y$10$qL7cD2xGzvpEJbB4NPgyIOK4XAbdtVHgziVJ8ALLzK6i3S6g7szsm', 'ZenithSpaces', '661f7f20317c89.83530706.png'),
(4, 'Duna', 'Alabdulaziz', 'Duna.Alabdulaziz@gmail.com', '$2y$10$EsGaQhkQ8LJWbsCUQM/9J.9cRGxwmj0DLj3DK/RRupQ13MT9MdTm2', 'BloomBrio', '661f8119b34023.15718265.png');

-- --------------------------------------------------------

--
-- Table structure for table `designerspeciality`
--

CREATE TABLE `designerspeciality` (
  `designerID` int(11) NOT NULL,
  `designCategoryID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `designerspeciality`
--

INSERT INTO `designerspeciality` (`designerID`, `designCategoryID`) VALUES
(2, 2),
(2, 3),
(3, 1),
(3, 2),
(3, 3),
(4, 2),
(4, 4);

-- --------------------------------------------------------

--
-- Table structure for table `designprotofiloproject`
--

CREATE TABLE `designprotofiloproject` (
  `id` int(11) NOT NULL,
  `designerID` int(11) NOT NULL,
  `projectName` varchar(200) NOT NULL,
  `projectImgFileName` varchar(500) NOT NULL,
  `description` varchar(200) NOT NULL,
  `designCategoryID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `designprotofiloproject`
--

INSERT INTO `designprotofiloproject` (`id`, `designerID`, `projectName`, `projectImgFileName`, `description`, `designCategoryID`) VALUES
(2, 2, 'Living room- Bohemian style', '661f7a9c822e65.05918854.jpg', 'Living room: Bohemian style. The room has large windows.', 4),
(3, 2, 'Kitchen- Coastal style.', '661f7b1764b894.85662830.jpg', 'Kitchen: Coastal style. color theme:White', 3),
(4, 2, 'Living room- Modern style', '661f7bddc3c8f1.35987019.jpg', 'Living room: Modern style. White table, with fireplace LED screen.', 1),
(5, 3, 'Bathroom -Country style', '661f7f589ebb77.24458256.jpg', 'Bathroom with a country style, color theme: Blue and white.', 2),
(6, 3, 'Bedroom - Coastal', '661f7fbf77baf5.93989058.jpg', 'Bedroom: Coastal style. color them: Blue and white.', 3),
(7, 3, 'Bedroom - Modern style', '661f8006434168.04331839.jpg', 'Bedroom: Modern style, Color theme: Grey and gold.', 1),
(9, 4, 'Living room- Bohemian style', '661f819cd34630.54672698.jpg', 'Living room: Bohemian style. Color theme: Green and light brown.', 4),
(10, 4, 'Living room - Country style.', '661f81ff126b49.37624957.jpg', 'Living room: Country style. color theme: Light grey and Brown.', 2);

-- --------------------------------------------------------

--
-- Table structure for table `requeststatus`
--

CREATE TABLE `requeststatus` (
  `id` int(11) NOT NULL,
  `status` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `requeststatus`
--

INSERT INTO `requeststatus` (`id`, `status`) VALUES
(1, 'pending consultation'),
(2, 'consultation provided'),
(3, 'consultation declined');

-- --------------------------------------------------------

--
-- Table structure for table `roomtype`
--

CREATE TABLE `roomtype` (
  `id` int(11) NOT NULL,
  `type` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roomtype`
--

INSERT INTO `roomtype` (`id`, `type`) VALUES
(1, 'Living Room'),
(2, 'Bedroom'),
(3, 'Kitchen'),
(4, 'Bathroom');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `designcategory`
--
ALTER TABLE `designcategory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `designconsultation`
--
ALTER TABLE `designconsultation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `requestID` (`requestID`);

--
-- Indexes for table `designconsultationrequest`
--
ALTER TABLE `designconsultationrequest`
  ADD PRIMARY KEY (`id`),
  ADD KEY `clientID` (`clientID`),
  ADD KEY `designerID` (`designerID`),
  ADD KEY `roomTypeID` (`roomTypeID`),
  ADD KEY `designCategoryID` (`designCategoryID`),
  ADD KEY `statusID` (`statusID`);

--
-- Indexes for table `designer`
--
ALTER TABLE `designer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `designerspeciality`
--
ALTER TABLE `designerspeciality`
  ADD KEY `designCategoryID` (`designCategoryID`),
  ADD KEY `designerID` (`designerID`);

--
-- Indexes for table `designprotofiloproject`
--
ALTER TABLE `designprotofiloproject`
  ADD PRIMARY KEY (`id`),
  ADD KEY `designerID` (`designerID`),
  ADD KEY `designCategoryID` (`designCategoryID`);

--
-- Indexes for table `requeststatus`
--
ALTER TABLE `requeststatus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roomtype`
--
ALTER TABLE `roomtype`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `designcategory`
--
ALTER TABLE `designcategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `designconsultation`
--
ALTER TABLE `designconsultation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `designconsultationrequest`
--
ALTER TABLE `designconsultationrequest`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `designer`
--
ALTER TABLE `designer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `designprotofiloproject`
--
ALTER TABLE `designprotofiloproject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `requeststatus`
--
ALTER TABLE `requeststatus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `roomtype`
--
ALTER TABLE `roomtype`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `designconsultation`
--
ALTER TABLE `designconsultation`
  ADD CONSTRAINT `designconsultation_ibfk_1` FOREIGN KEY (`requestID`) REFERENCES `designconsultationrequest` (`id`);

--
-- Constraints for table `designconsultationrequest`
--
ALTER TABLE `designconsultationrequest`
  ADD CONSTRAINT `designconsultationrequest_ibfk_1` FOREIGN KEY (`clientID`) REFERENCES `client` (`id`),
  ADD CONSTRAINT `designconsultationrequest_ibfk_2` FOREIGN KEY (`designerID`) REFERENCES `designer` (`id`),
  ADD CONSTRAINT `designconsultationrequest_ibfk_3` FOREIGN KEY (`roomTypeID`) REFERENCES `roomtype` (`id`),
  ADD CONSTRAINT `designconsultationrequest_ibfk_4` FOREIGN KEY (`designCategoryID`) REFERENCES `designcategory` (`id`),
  ADD CONSTRAINT `designconsultationrequest_ibfk_5` FOREIGN KEY (`statusID`) REFERENCES `requeststatus` (`id`);

--
-- Constraints for table `designerspeciality`
--
ALTER TABLE `designerspeciality`
  ADD CONSTRAINT `designerspeciality_ibfk_1` FOREIGN KEY (`designCategoryID`) REFERENCES `designcategory` (`id`),
  ADD CONSTRAINT `designerspeciality_ibfk_2` FOREIGN KEY (`designerID`) REFERENCES `designer` (`id`);

--
-- Constraints for table `designprotofiloproject`
--
ALTER TABLE `designprotofiloproject`
  ADD CONSTRAINT `designprotofiloproject_ibfk_1` FOREIGN KEY (`designerID`) REFERENCES `designer` (`id`),
  ADD CONSTRAINT `designprotofiloproject_ibfk_2` FOREIGN KEY (`designCategoryID`) REFERENCES `designcategory` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
