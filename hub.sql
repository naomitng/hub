-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 10, 2024 at 06:16 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

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
  `fname` varchar(30) NOT NULL,
  `lname` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `dept` varchar(50) NOT NULL,
  `pass` varchar(100) NOT NULL,
  `vercode` text NOT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT 0,
  `rescode` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`fname`, `lname`, `email`, `dept`, `pass`, `vercode`, `verified`, `rescode`) VALUES
('Naomi', 'Ting', 'hnaomiting@gmail.com', '1', '$2y$10$ggVJ7XoxIg8kwOibVx7VGeoaj5FzUMzj3b85AbzwJ/rzNoE5bfcli', '92d886223c222c6549c75698b1f4436b', 1, 'd2b8419866d0d7b97319cb36185d90b4');

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
  `adviser` varchar(30) NOT NULL,
  `dept` varchar(50) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `keywords` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `studies`
--

INSERT INTO `studies` (`id`, `title`, `authors`, `abstract`, `year`, `adviser`, `dept`, `filename`, `keywords`) VALUES
(4, 'Web-Based Thesis Archiving Management System', 'Delizo, Iver Darrel D. Manato, Cyril Jay Y. Vila, Brayn Klein P. Visbe, Paulo A.', 'Thesis is the report should be made by final year students in thc Faculty of Collegc of Engineering Architecture and Technology (CEAT), Rizal Technological University. There are two types of thesis report namely research and technical. Each thesis report must be bound kept in the thesis room. The thesis then will use as a general reference thesis for CEAT specially IT students. However, there are constraints in terms of the arrangement and search methods to find each thesis reports stored in the room. This will make it difficult for students to find topics that they wish to use a reference. There is also has time constraint problems faced by students and difficult for them to go into the room at every times. Safety of each thesis report also cannot be guaranteed because there is no method that can ensure the printed report or thesis project was included in the compact disc can hold out against damage or theft. Therefore, Thesis Archiving Management System was developed to help students more easily to find their desired report. Students can enter the system at every time. In addition, the safety report is also more secure as more systematic management methods in the TAMS can create data integrity in it. By using storage approach using database system, it will prove to be helpful to manage the report thesis in CEAT for their students more effectively.\r\n', '2022', 'Lea S. Nisperos', 'Information Technology', 'uploads/431057763_942821650626091_8418644287236025106_n.jpg', 'Archiving system, Web-based'),
(5, 'Web Based Document Tracking System with Cloud Server Integration for Rizal Technological University', 'Alberto, John Matthew E. Depaz, Denver B. Malapitan, Lance Farley V. Sadaya, John Carlo G.', 'In the age of technological advancement, organizations arc increasingly seeking ways to enhance their processes and services, and Rizal Technological University (RTU) is no exception. RTU strives to provide quality education and services to its students and stakeholders. However, the Technical Department of Rizal Technological University, Boni Campus, also known as the Management Information Center (MIC), faces the challenge of traditional and manual methods of tracking documents and records. These methods can be inefficient, time-consuming, and prone to errors, leading to delays, lost documents, and service delivery issues. To address these challenges and improve the quality and efficiency of services, the researchers have developed a Web-Based Document Tracking System with Cloud Server Integration. This system provides an efficient and organized approach to managing documents and records while ensuring accessibility and security. The system offers several benefits for the MIC, including easy tracking of all processed documents, the ability to create document routes, user account management, and permission settings for each account. Overall, the Web-Based Document Tracking System with Cloud Server Integration for RTU is a valuable addition to the university\'s services. It streamlines document and record tracking, making it more efficient and effective while ensuring accessibility and security. By implementing this system, RTU is better equipped to fulfill its mission of providing quality education and services.\r\n', '2023', '', 'Information Technology', 'uploads/430948682_751877360239198_3254527022649494855_n.jpg', 'Cloud Server integration, Web-based, Document Tracking System'),
(6, 'Emergency Panic Device for Senior Citizens in Barangay Highway Hills, Mandaluyong City: An Arduino-Based Device for Instant Contact to Local Medical Services', 'Baraeeros, Christian Dominic A. Carmona, Kimberly H. Cuartero, Jalen Raiyjha L. Sabalboro, Arjay M. Sabundo, Jake R. ', 'This research was all about the development of an Emergency Panic Dcvicc for Senior Citizens in Brgy. Highway Hills, Mandaluyong City: An Arduino-based device for instant contact to the local medical services during the academic year 2021. The Arduino IDE was used as the software platform for programming the instructions to Arduino Nano, and MIT APP Inventor was used to construct a mobile app that can record the incoming messages from the prototype. The hardware modules that the researchers utilized was Arduino Nano, which serves as a platform for programming major instructions for the functions of other modules. Through connecting the Arduino Nano to the GSM module, which was used in the prototype, the Arduino Nano can program an instruction for the GSM module. The user of the device will be asked for their information, personal emergency contacts, phone number, and their past health complications. The administrator has the power to entertain in gathering, editing, and checking the personal information of the user. The emergency contacts, relatives of the user, and the agent will receive the SMS, while the agent is responsible to relay the emergency message to the people that will be dispatched to the scene of distress while maintaining the communication to the user.\r\n', '2021', 'Lea S. Nisperos', 'Computer Engineering', 'uploads/431421179_1458272635115862_7288967026595005202_n.jpg', 'Aruduino, Mobile App');

--
-- Indexes for dumped tables
--

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
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `advisers`
--
ALTER TABLE `advisers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `archive`
--
ALTER TABLE `archive`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `studies`
--
ALTER TABLE `studies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
