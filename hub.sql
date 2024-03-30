-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 30, 2024 at 09:37 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hub`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `fname` varchar(30) NOT NULL,
  `lname` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `dept` varchar(50) NOT NULL,
  `pass` varchar(100) NOT NULL,
  `vercode` text NOT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT 0,
  `rescode` text NOT NULL,
  `approval` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `fname`, `lname`, `email`, `dept`, `pass`, `vercode`, `verified`, `rescode`, `approval`) VALUES
(24, 'Haesser Naomi', 'Ting', 'hnaomiting@gmail.com', 'IT Department', '$2y$10$o9fjh5Gs9xK7ATJrJlX0xuncn1umrv9.vLFfYh9/f8XUl9eCKuKOi', 'bbbe4e44ad83ab868485060df78bbc01', 1, '70822805b3921618b8ea2a272034f2d0', 1),
(25, 'Mizzy', 'Perez', 'mdperez@rtu.edu.ph', 'IT Department', '$2y$10$/dgm5HKm9Re.FjNdt9xUeeF3TNG5hhLpUI6ULA6yLO.mN1o5/B1y2', 'b6e8bdcb00944b7189b9ee744c1b10f4', 1, '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `advisers`
--

CREATE TABLE `advisers` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `email` varchar(60) NOT NULL,
  `dept` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `advisers`
--

INSERT INTO `advisers` (`id`, `name`, `email`, `dept`) VALUES
(2, 'Lea S. Nisperos', 'lnisperos@rtu.edu.ph', 'Information Technology'),
(3, 'Noel Gutierrez', 'ngutierrez@rtu.edu.ph', 'Information Technology'),
(4, 'Richmond Allen Villanueva', 'rdvillanueva02@rtu.edu.ph', 'Information Technology'),
(5, 'May Figueroa', 'mbfigueroa@rtu.edu.ph', 'Information Technology'),
(6, 'Kenneth Martinez', 'kmartinez@rtu.edu.ph', 'Information Technology'),
(8, 'Aphril Alcalde', 'aaalcalde@rtu.edu.ph', 'Information Technology'),
(9, 'Michael Fernandez', 'mmfernandez@rtu.edu.ph', 'Information Technology'),
(10, 'Jaevier Villanueva ', 'javillanueva02@rtu.edu.ph', 'Information Technology'),
(11, 'Greta Rosario', 'gmrosario@rtu.edu.ph', 'Information Technology'),
(12, 'Christopher Lee Zaplan', 'clzaplan02@rtu.edu.ph', 'Computer Engineering'),
(13, 'Alquin Cezar', 'adcezar@rtu.edu.ph', 'Computer Engineering'),
(14, 'Dolores Cruz', 'dacruz002@rtu.edu.ph', 'Computer Engineering'),
(15, 'Floyd De Vela', 'fdevela@rtu.edu.ph', 'Computer Engineering'),
(16, 'Julius Cabauatan', 'jucabauatan@rtu.edu.ph', 'Computer Engineering'),
(17, 'Jenelyn Luna', 'jeluna@rtu.edu.ph', 'Computer Engineering');

-- --------------------------------------------------------

--
-- Table structure for table `archive`
--

CREATE TABLE `archive` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `authors` varchar(500) NOT NULL,
  `abstract` varchar(2000) NOT NULL,
  `year` varchar(5) NOT NULL,
  `adviser` varchar(30) NOT NULL,
  `dept` varchar(50) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `keywords` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `archive`
--

INSERT INTO `archive` (`id`, `title`, `authors`, `abstract`, `year`, `adviser`, `dept`, `filename`, `keywords`) VALUES
(1, 'Kuya D\' Specialties Online Ordering System', 'Clemente, Ace Vincent C. Escuadro, Zaldy L. Lachama, Jake E. Reyes, Edmar John V. Sonico, Rusty S.', 'A web-based solution that assists Kuya D\' Specialties in managing their business digitally and enables customers to place online orders. Online ordering systems are becoming more necessary than manual methods to help the business expand. As a result, this system was created to assist Kuya D\' Specialties in managing their online sales and setvices- It is a more effective method to strengthen the connection between Kuya D\' Specialties and its clients- The administrative staff and Kuya D\' Specialties consumers are the two intended users for this system- Ten modules make up the system: login and registration, customizing stock specification, managing orders and profiles, searching for products, managing stocks and specifications, approving orders, advice administration for admin side functions, and live chat.\r\n', '2023', 'Sample Adviser', 'Information Technology', 'uploads/423619474_940654174112173_3174740682615900542_n.jpg', 'Web-based, Inventory system, Live chat'),
(2, 'Web App for Inventory Management and Point of Sale Using Relational Database', 'Braganza, Charlie E. Cabigas, Ralph Kenneth R. Matilos, Russel Rey A. Patron, John Tholitz', 'This research provides a capstone project conducted by fourth-year Rizal Technological University — Boni Campus bachelor\'s degree in information technology students. Researchers were tasked with producing a project that would benefit others and was connected to the course they are currently enrolled in. Web app is an inventory management with a point of sale using relational database that can handle different devices were it has the ability to punched all kinds of stock goods like raw materials, work in progress, stores to finish goods, consumables and many more, but most of the time small businesses encountered different issues wherein some of them are fledgling enterprise in which they experience the common problems that affects them as they begin their business career and for them to be more hands-on to business. The researcher built a system that supports the whole transaction process that would help every business to edit their product items especially for the small enterprise in order to accomplish their needs for their business.', '2022', 'Lea S. Nisperos', 'Information Technology', 'uploads/430874840_382153494771560_859116301418897918_n.jpg', 'Web-based, Inventory Management, Relational Database'),
(3, 'Watcher: Mobile Application That Monitors Mobile App Usage to Help Parents to Control Their Children', 'Bellen, Jenny-Babe B. Gabriola, Carl Joshua A. Garcia, Mikaella Mae C. Verdad, Ron Michael R.', 'The Watcher application aims to helps parents to monitor their children\'s phone, that can help control the children\'s screen time throughout the day. In recent years, access to media has undergone a transformation as mobile devices (e.g., smartphones and tablets) now allow families to provide their child with screen time opportunities throughout the day. Indeed, smartphone and tablet ownership has increased dramatically in the past five years (Pew Research Center, 2014). Some parents nowadays allows their children to use gadgets while they are doing household chores or when they are not at home (e.g., working), therefore they were not able to properly monitor the children\'s activities on their gadgets. The application can access and take control of the children\'s phone to be able to monitor the app usage, and determine the time that the children are spending in the current day. The application can also take control of the phone to turn on parental control features such as to disable certain application and it\'s notification for a certain amount of time, as well as tum off the target\'s phone.', '2022', 'Kenneth martinez', 'Information Technology', 'uploads/431151347_726386732647530_1186541395350408673_n.jpg', 'Mobile application');

-- --------------------------------------------------------

--
-- Table structure for table `studies`
--

CREATE TABLE `studies` (
  `id` int(11) NOT NULL,
  `title` longtext NOT NULL,
  `authors` varchar(500) NOT NULL,
  `abstract` varchar(2000) NOT NULL,
  `year` varchar(5) NOT NULL,
  `adviser` int(11) NOT NULL,
  `dept` varchar(50) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `keywords` longtext NOT NULL,
  `contributor` int(11) NOT NULL,
  `verified` int(11) NOT NULL,
  `popularity` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `studies`
--

INSERT INTO `studies` (`id`, `title`, `authors`, `abstract`, `year`, `adviser`, `dept`, `filename`, `keywords`, `contributor`, `verified`, `popularity`) VALUES
(224, 'QUALITY MANAGEMENT SYSTEM FOR UNIVERSITY CENTER OFCULTURE, ARTS, AND EVENTS TROUPE', 'Correra, MarijoLaranan, AldrinMozo, ErysRamos, Paul Zedrick', 'This Capstone project is entitled \"Quality Management System for University Center of Culture, Arts, and Events Troupes\" that is a web based management system that focuses in helping the University Center of the Culture, Arts, and Events (UCCAE) in terms of filing their documents and events. Which resolves their concern of tracking all thc records from the previous years as it was mentioned by the UCCAE E-data Officer that the records are physical papers that most of the time are misplaced and makes it hard for them to track the records from old events. This System will allow the user to sort events and files depending on the dates that the user wants to track down. The user must scan the old documents first and have it inputted on the system and save. The system will also help the department to sort out their members depending on its membership status, course department, level of membership, and specific troupe. Every data that was inserted by the admin user can be edited, deleted, saved and generated. Keywords: File management, Records, Membership, Events, File, Documents, Filing\r\n', '2023', 15, 'Information Technology', '', 'File management, Records, Membership', 25, 1, 14),
(227, 'RTU VEHICLE PARKING MANAGEMENT SYSTEM', 'Cribe, Normarc C. Ishizawa, Matt Florence T. Macabugao, Donna P. Rivera, Niel Patrick M.', 'The Rizal Technological University Parking Management System is a crucial element of urban infrastructure, with the objective of effectively and optimally managing the use of parking spaces. This summary presents of a typical parking management system, emphasizing its principal features and advantages. This chapter provides a comprehensive literature review of previous research conducted on parking management, examining the associated impacts and challenges. Additionally, it presents empirical data obtained from a survey study conducted by the authors within Rizal Technological University, Boni Campus. The survey specifically focuses on the\r\n', '2023', 3, 'Information Technology', 'uploads/', 'test, test, test, test', 25, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `superadmin`
--

CREATE TABLE `superadmin` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `superadmin`
--

INSERT INTO `superadmin` (`id`, `name`, `username`, `password`) VALUES
(1, 'Super Admin', 'supadmin', '$2y$10$T3lBKKAopXRwsTKnu8fqNulprqTsBUi2XcVhfRI0gyuoiYS.dIN9u');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `advisers`
--
ALTER TABLE `advisers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `archive`
--
ALTER TABLE `archive`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `studies`
--
ALTER TABLE `studies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `adviserfk` (`adviser`),
  ADD KEY `conrtibutorfk` (`contributor`);

--
-- Indexes for table `superadmin`
--
ALTER TABLE `superadmin`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `advisers`
--
ALTER TABLE `advisers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `archive`
--
ALTER TABLE `archive`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `studies`
--
ALTER TABLE `studies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=228;

--
-- AUTO_INCREMENT for table `superadmin`
--
ALTER TABLE `superadmin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `studies`
--
ALTER TABLE `studies`
  ADD CONSTRAINT `adviserfk` FOREIGN KEY (`adviser`) REFERENCES `advisers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `conrtibutorfk` FOREIGN KEY (`contributor`) REFERENCES `admin` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
