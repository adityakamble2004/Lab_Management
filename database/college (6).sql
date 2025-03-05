-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 05, 2025 at 07:48 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `college`
--

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE `complaints` (
  `id` int(11) NOT NULL,
  `roll_no` int(11) NOT NULL,
  `asset_id` varchar(11) NOT NULL,
  `issue_description` text NOT NULL,
  `status` enum('Pending','Resolved','In Progress') DEFAULT 'Pending',
  `created_at` datetime DEFAULT current_timestamp(),
  `resolved_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `selected_problems` text NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `computer_id` int(10) DEFAULT NULL,
  `technician_id` int(11) DEFAULT NULL,
  `resolution_note` text DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `complaints`
--

INSERT INTO `complaints` (`id`, `roll_no`, `asset_id`, `issue_description`, `status`, `created_at`, `resolved_at`, `updated_at`, `selected_problems`, `email`, `computer_id`, `technician_id`, `resolution_note`, `user_id`) VALUES
(1, 1, '101', 'System is overheating frequently.', 'In Progress', '2025-01-24 23:54:09', '2025-01-26 00:01:08', '2025-02-21 00:39:02', '', NULL, NULL, 10, NULL, NULL),
(38, 24728, 'C34567', '', 'Resolved', '2025-01-25 23:30:40', '2025-01-26 00:01:06', '2025-03-04 23:46:09', 'Internet Connectivity Issues, Driver Issues, Operating System Errors', 'ak8806657127@gmail.com', NULL, 1, '', NULL),
(39, 24728, 'C34567', '', 'Resolved', '2025-01-25 23:31:42', '2025-01-26 00:01:04', '2025-02-21 01:12:54', 'Slow Performance, Software Crashes, Blue Screen of Death (BSOD)', 'ak8806657127@gmail.com', NULL, 1, 'done it', NULL),
(40, 24728, 'C34567', '', 'In Progress', '2025-01-25 23:33:18', '2025-01-26 00:00:59', '2025-02-21 00:43:30', 'Slow Performance, Software Crashes, Internet Connectivity Issues', 'ak8806657127@gmail.com', NULL, 11, NULL, NULL),
(41, 24728, 'D45678', '', 'In Progress', '2025-01-25 23:33:34', '2025-01-26 00:00:57', '2025-02-21 00:43:38', 'Blue Screen of Death (BSOD), Internet Connectivity Issues, Virus or Malware Infections', 'ak8806657127@gmail.com', NULL, 10, NULL, NULL),
(42, 24728, 'D45678', '', 'In Progress', '2025-01-25 23:33:54', '2025-01-26 00:00:55', '2025-02-21 00:43:46', 'Blue Screen of Death (BSOD), Internet Connectivity Issues, Virus or Malware Infections', 'ak8806657127@gmail.com', NULL, 11, NULL, NULL),
(43, 24728, 'F67890', '54329486', 'In Progress', '2025-01-25 23:46:46', '2025-01-26 00:00:51', '2025-02-21 00:44:00', 'Slow Performance, Software Crashes, Blue Screen of Death (BSOD), Internet Connectivity Issues', 'ak8806657127@gmail.com', NULL, 10, NULL, NULL),
(44, 24728, 'F67890', '54329486', 'Resolved', '2025-01-25 23:52:20', '2025-01-26 00:00:50', '2025-03-04 23:45:25', 'Slow Performance, Software Crashes, Blue Screen of Death (BSOD), Internet Connectivity Issues', 'ak8806657127@gmail.com', NULL, 1, '', NULL),
(45, 24728, 'D45678', '', 'Resolved', '2025-01-25 23:53:18', '2025-01-26 00:00:47', '2025-02-21 01:09:31', 'Slow Performance, Software Crashes', 'ak8806657127@gmail.com', NULL, 1, 'now it is fixed ', NULL),
(46, 24728, 'D45678', '', 'Resolved', '2025-01-25 23:54:11', '2025-01-26 00:00:45', '2025-02-21 01:09:37', 'Blue Screen of Death (BSOD), Internet Connectivity Issues, Virus or Malware Infections', 'ak8806657127@gmail.com', NULL, 1, '', NULL),
(47, 24728, 'D45678', '', 'Resolved', '2025-01-25 23:56:23', '2025-01-26 00:00:43', '2025-02-21 01:13:27', 'Blue Screen of Death (BSOD), Internet Connectivity Issues, Virus or Malware Infections', 'ak8806657127@gmail.com', NULL, 1, '', NULL),
(48, 24728, 'G78901', '', 'Resolved', '2025-01-25 23:58:59', '2025-01-26 00:00:41', '2025-03-04 22:59:41', 'Slow Performance, Software Crashes, Internet Connectivity Issues', 'ak8806657127@gmail.com', NULL, 1, '', NULL),
(49, 0, '', 'Test complaint description', 'In Progress', '2025-02-21 00:30:42', NULL, '2025-02-21 00:31:12', '', NULL, NULL, 6, NULL, 1),
(50, 0, '', 'Test complaint description', 'In Progress', '2025-02-21 00:32:03', NULL, '2025-02-21 00:34:22', '', NULL, NULL, 1, NULL, 1),
(51, 0, '', 'Test complaint description', 'In Progress', '2025-02-21 00:32:11', NULL, '2025-02-21 00:34:33', '', NULL, NULL, 7, NULL, 1),
(52, 0, '', 'Test complaint description', 'In Progress', '2025-02-21 00:32:14', NULL, '2025-02-21 00:34:39', '', NULL, NULL, 1, NULL, 1),
(53, 24728, 'E56789', 'not working properly \r\n', 'Resolved', '2025-02-21 00:36:24', NULL, '2025-03-04 22:59:46', 'Software Crashes, Internet Connectivity Issues, Overheating', 'ak8806657127@gmail.com', NULL, 1, '', NULL),
(54, 24728, 'C34567', 'KSDF .UBKWV', 'Resolved', '2025-02-21 00:36:51', NULL, '2025-03-05 00:54:22', 'Blue Screen of Death (BSOD), Hardware Failures, Overheating', 'ak8806657127@gmail.com', NULL, 0, '', NULL),
(55, 24728, 'C34567', '', 'In Progress', '2025-02-21 01:15:24', NULL, '2025-03-05 00:54:20', 'Virus or Malware Infections, Operating System Errors', 'ak8806657127@gmail.com', NULL, 0, NULL, NULL),
(56, 24728, 'C34567', '', 'In Progress', '2025-02-21 01:19:05', '2025-03-05 00:54:42', '2025-03-05 00:54:42', 'Virus or Malware Infections, Operating System Errors, Password or Login Issues', 'ak8806657127@gmail.com', NULL, 0, '', NULL),
(57, 24728, 'I90123', '', 'In Progress', '2025-02-21 01:19:23', '2025-03-05 00:54:11', '2025-03-05 00:54:11', 'Slow Performance, Password or Login Issues', 'ak8806657127@gmail.com', NULL, 1, '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `computers`
--

CREATE TABLE `computers` (
  `id` int(11) NOT NULL,
  `asset_id` varchar(50) NOT NULL,
  `computer_name` varchar(100) NOT NULL,
  `computer_type` enum('Desktop','Laptop','Server') NOT NULL,
  `operating_system` varchar(50) NOT NULL,
  `processor_details` varchar(100) DEFAULT NULL,
  `ram_size` varchar(20) DEFAULT NULL,
  `storage_details` varchar(50) DEFAULT NULL,
  `graphics_card` varchar(100) DEFAULT NULL,
  `monitor_details` varchar(100) DEFAULT NULL,
  `peripherals` text DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `mac_address` varchar(50) DEFAULT NULL,
  `network_name` varchar(100) DEFAULT NULL,
  `installed_applications` text DEFAULT NULL,
  `antivirus_details` varchar(100) DEFAULT NULL,
  `warranty_expiry_date` date DEFAULT NULL,
  `last_checked_date` date DEFAULT NULL,
  `assigned_user` varchar(100) DEFAULT NULL,
  `department` varchar(100) DEFAULT NULL,
  `service_history` text DEFAULT NULL,
  `issue_description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Lab` varchar(255) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Working'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `computers`
--

INSERT INTO `computers` (`id`, `asset_id`, `computer_name`, `computer_type`, `operating_system`, `processor_details`, `ram_size`, `storage_details`, `graphics_card`, `monitor_details`, `peripherals`, `ip_address`, `mac_address`, `network_name`, `installed_applications`, `antivirus_details`, `warranty_expiry_date`, `last_checked_date`, `assigned_user`, `department`, `service_history`, `issue_description`, `created_at`, `updated_at`, `Lab`, `status`) VALUES
(2, 'A12345', 'PC-001', 'Desktop', 'Windows 10', 'Intel i5-10400', '8GB', '512GB SSD', 'Intel UHD 630', 'Dell 24-inch', 'Keyboard, Mouse', '192.168.1.101', '00:14:22:58:9F:56', 'Corporate Network', 'Microsoft Office, Chrome', 'McAfee', '2026-12-15', '2025-01-10', 'John Doe', 'BCA', 'Replaced Hard Drive in 2023', 'No major issues', '2025-01-16 14:08:22', '2025-01-22 08:14:34', 'lab1', 'Working'),
(3, 'B23456', 'PC-002', 'Laptop', 'Windows 11', 'AMD Ryzen 5', '16GB', '1TB HDD', 'NVIDIA GTX 1650', 'HP 15-inch', 'Docking Station', '192.168.1.102', '00:14:22:58:9F:57', 'Corporate Network', 'Adobe Suite, Visual Studio', 'Kaspersky', '2025-07-20', '2025-01-10', 'Jane Smith', 'Engineering', 'Replaced Battery in 2024', 'Overheats occasionally', '2025-01-16 14:08:22', '2025-01-20 16:05:37', 'lab1', 'Working'),
(4, 'C34567', 'PC-003', 'Desktop', 'Windows 10', 'Intel i7-10700K', '32GB', '1TB SSD', 'NVIDIA RTX 3070', 'LG 27-inch', 'None', '192.168.1.103', '00:14:22:58:9F:58', 'Corporate Network', 'Visual Studio Code, Docker', 'Norton', '2026-05-10', '2025-01-10', 'Alice Johnson', 'Development', 'Replaced RAM in 2023', 'Minor graphics glitches', '2025-01-16 14:08:22', '2025-01-20 16:10:55', 'lab3', 'Working'),
(5, 'D45678', 'PC-004', 'Desktop', 'Windows 7', 'Intel i3-9100F', '4GB', '256GB SSD', 'Intel UHD 610', 'Samsung 24-inch', 'Printer', '192.168.1.104', '00:14:22:58:9F:59', 'Guest Network', 'Google Chrome', 'AVG', '2025-03-25', '2025-01-10', 'Tom Harris', 'Marketing', 'No history', 'Runs slow during large file transfers', '2025-01-16 14:08:22', '2025-01-24 16:42:43', 'lab3', 'Working'),
(6, 'E56789', 'PC-005', 'Laptop', 'macOS Ventura', 'Apple M1', '16GB', '512GB SSD', 'Apple Integrated', 'Apple 13-inch Retina', 'None', '192.168.1.105', '00:14:22:58:9F:60', 'Corporate Network', 'Xcode, Slack', 'Bitdefender', '2026-10-30', '2025-01-10', 'Emma Lee', 'Design', 'Replaced Keyboard in 2024', 'Occasional keyboard lag', '2025-01-16 14:08:22', '2025-01-24 16:43:11', 'lab4', 'Working'),
(7, 'F67890', 'PC-006', 'Desktop', 'Windows 10', 'AMD Ryzen 7 3700X', '16GB', '2TB HDD', 'AMD Radeon RX 5700', 'BenQ 27-inch', 'Webcam, Headset', '192.168.1.106', '00:14:22:58:9F:61', 'Corporate Network', 'Visual Studio, Spotify', 'Windows Defender', '2025-08-15', '2025-01-10', 'Marcus Kim', 'Sales', 'Replaced Hard Drive in 2022', 'Audio issues occasionally', '2025-01-16 14:08:22', '2025-01-24 16:43:50', 'lab5', 'Working'),
(8, 'G78901', 'PC-007', 'Laptop', 'Windows 10', 'Intel i5-1135G7', '8GB', '256GB SSD', 'Intel Iris Xe', 'Acer 15-inch', 'None', '192.168.1.107', '00:14:22:58:9F:62', 'Corporate Network', 'Microsoft Office, Zoom', 'McAfee', '2025-06-01', '2025-01-10', 'David Chen', 'Finance', 'No history', 'Battery drains quickly', '2025-01-16 14:08:22', '2025-01-24 16:44:20', 'language lab', 'Working'),
(9, 'H89012', 'PC-008', 'Desktop', 'Linux Ubuntu', 'Intel i9-11900K', '64GB', '512GB SSD', 'NVIDIA RTX 3080', 'Dell 32-inch', 'None', '192.168.1.108', '00:14:22:58:9F:63', 'Corporate Network', 'PyCharm, Docker', 'None', '2026-11-20', '2025-01-10', 'Lucas Miller', 'IT', 'Replaced GPU in 2024', 'No issues', '2025-01-16 14:08:22', '2025-01-24 16:45:29', 'business lab', 'Working'),
(10, 'I90123', 'PC-009', 'Laptop', 'Windows 11', 'Intel i7-12700', '16GB', '1TB SSD', 'Intel Iris Xe', 'Lenovo 14-inch', 'None', '192.168.1.109', '00:14:22:58:9F:64', 'Corporate Network', 'AutoCAD, Teams', 'ESET', '2027-01-10', '2025-01-10', 'Sarah Brown', 'Engineering', 'No history', 'Occasional lag with large AutoCAD files', '2025-01-16 14:08:22', '2025-01-24 16:43:29', 'lab5', 'Working'),
(11, 'J01234', 'PC-010', 'Desktop', 'Windows 10', 'Intel i3-8100', '8GB', '1TB HDD', 'Intel UHD 630', 'HP 24-inch', 'Scanner', '192.168.1.110', '00:14:22:58:9F:65', 'Guest Network', 'Microsoft Office, Chrome', 'Sophos', '2025-02-05', '2025-01-10', 'Oliver King', 'Support', 'No history', 'Slow boot times', '2025-01-16 14:08:22', '2025-01-16 14:08:22', NULL, 'Working'),
(12, '101', 'hp ', 'Desktop', 'WINDOWS 10', 'i-9', '16', '512', '5070', 'hp', 'keybord, mouse', '192.255.2546', '192.255.2546', 'LAN', 'MA OFFICE ', 'MS', '2025-01-20', '2026-01-20', 'Student', 'BCA', '', '', '2025-01-20 15:45:37', '2025-01-20 15:45:37', NULL, 'Working');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `Sr_No` int(11) DEFAULT NULL,
  `Roll_No` int(11) DEFAULT NULL,
  `Name_Of_Student` varchar(512) DEFAULT NULL,
  `Gender` varchar(512) DEFAULT NULL,
  `Mail_Id` varchar(512) DEFAULT NULL,
  `Mob_No` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`Sr_No`, `Roll_No`, `Name_Of_Student`, `Gender`, `Mail_Id`, `Mob_No`) VALUES
(1, 24701, 'AAGLAVE  NIKITA  SUDAM', 'FEMALE', 'aaglavesudam@gmail.com', 2147483647),
(2, 24702, 'ADMANE  POOJA  CHANDRAKANT', 'FEMALE', 'poojaadmane15@gmail.com', 2147483647),
(3, 24703, 'AJANE  PRAVIN  SHIVKUMAR', 'MALE', 'AJANESHRIKUMAR@GMAIL.COM', 2147483647),
(4, 24704, 'AKANGIRE  ANKITA  TUKARAM', 'FEMALE', 'aknagire@gmail.com', 2147483647),
(5, 24705, 'ARADHYE  VISHNU  GANPATI', 'MALE', 'aradhyevishnu@gmail.com', 2147483647),
(6, 24706, 'BEMBADE  VIKKI  VASANTRAO', 'MALE', 'vvbembade@gmail.com', 2147483647),
(7, 24707, 'BHANDARE  VAISHNAVI  HANMANT', 'FEMALE', 'BHANDAREV@GMAIL.COM', 2147483647),
(8, 24708, 'BHANDE  NIVRUTTI  VINOD', 'MALE', 'nivruttibhonde111@gmail.com', 2147483647),
(9, 24709, 'BHISE  ROHINI  SUNIL', 'FEMALE', 'rohinibhise089@gmail.com', 2147483647),
(10, 24710, 'BHOSLE  SWATI  DEVIDAS', 'FEMALE', 'bhosaled@gmail.com', 2147483647),
(11, 24711, 'BOLSURE  DEVASHISH  RAJESH', 'MALE', 'bolsuredewashish15@gmail.com', 2147483647),
(12, 24712, 'CHAUGULE  NAMRATA  DATTATRAY', 'FEMALE', 'chauguled@gmail.com', 2147483647),
(13, 24713, 'CHAVAN  SAMADHAN  RAMESH', 'MALE', 'chavanr@gmail.com', 2147483647),
(14, 24714, 'CHAVAN  SHRAVAN  GORAKH', 'MALE', 'shravanchavan311@gmail.com', 2147483647),
(15, 24715, 'CHAVAN  SUPRIYA  VASANT', 'FEMALE', 'chavanvasant222@gmail.com', 2147483647),
(16, 24716, 'DAHIVALE  MEGHA  NARAYAN', 'FEMALE', 'thenghadahiwale5562@gmail.com', 2147483647),
(17, 24717, 'DESHMUKH  ABHAYSINH  SHRIKISHAN', 'MALE', 'abhaysinhdeshmukh302@gmail.com', 2147483647),
(18, 24718, 'DHAGE  DIKSHA  VINOD', 'FEMALE', 'dhagev@gmail.com', 2147483647),
(19, 24719, 'GADIWALE  RAHIL  RAHIM', 'MALE', 'rahilgadiwale1@gmail.com', 2147483647),
(20, 24720, 'GAIKWAD  VISHAL  CHANDRAKANT', 'MALE', 'vg976425@gmail.com', 2147483647),
(21, 24721, 'HAQ  SARA FATEMA  MERAJUL', 'FEMALE', 'sarah@gmail.com', 2147483647),
(22, 24722, 'IDEKAR  ANIKET  LIMBRAJ', 'MALE', 'aniketidekar2005@gmail.com', 2147483647),
(23, 24723, 'JADHAV  MANGESH  SUBHASH', 'MALE', 'mangeshj2603@gmail.com', 2147483647),
(24, 24724, 'JADHAV  PRASHANT  ANGAD', 'MALE', 'prashantj4554@gmail.com', 2147483647),
(25, 24725, 'JAGADALE  SANDHYARANI  MANIK', 'MALE', 'sandhyaranij@gmail.com', 2147483647),
(26, 24726, 'JAMBHALDARE AJAY MARUTI', 'MALE', 'jambhaldarem@gmail.com', 2147483647),
(27, 24727, 'KADAM  VAISHNAVI  UTTAM', 'FEMALE', 'kadamu362@gmail.com', 2147483647),
(28, 24728, 'KAMBLE  ADITYA  BALAJI', 'MALE', 'kamblebalaji@gmail.com', 2147483647),
(29, 24729, 'KAMBLE  ROHIT  BABURAO', 'MALE', 'rk8879067@gmail.com', 2147483647),
(30, 24730, 'KAMBLE  VIJAY  PANDURANG', 'MALE', 'kamblep@gmail.com', 2147483647),
(31, 24731, 'KANADE  SWAPNIL  UTTARESHWAR', 'MALE', 'kanadeswapnil9529767618@gmail.com', 2147483647),
(32, 24732, 'KARALEKAR  RATNADIP  SATISH', 'MALE', 'ratandipkaralekar123@gmail.com', 2147483647),
(33, 24733, 'KAWADE  MADHUR  DATTATRAY', 'MALE', 'kawaded@gmail.com', 2147483647),
(34, 24734, 'KHAN  TANZEEN  MINHAJ', 'MALE', 'khantazeen2004@gmail.com', 2147483647),
(35, 24735, 'KHOSE  ASHLESHA  ANIL', 'FEMALE', 'khoseanil@gmail.com', 2147483647),
(36, 24736, 'KISWE  PRANAY  BALAJI', 'MALE', 'kiswebalaji@gmail.com', 2147483647),
(37, 24737, 'KULKARNI  ANKITA  PRAMOD', 'FEMALE', 'kulkarnip@gmail.com', 2147483647),
(38, 24738, 'KULKARNI  SAKSHI  NITIN', 'FEMALE', 'sakhikulkarni254@gmail.com', 2147483647),
(39, 24739, 'LOBHE  PRATHAMESH  ANKUSHRAO', 'MALE', 'prathmesh123@gmail.com', 2147483647),
(40, 24740, 'MACHVE  TEJAS  GOVIND', 'MALE', 'tejasmachave@gmail.com', 2147483647),
(41, 24741, 'MADJE  RAGHUVEER  BHAGIRATH', 'MALE', 'amarmadje88@gmail.com', 2147483647),
(42, 24742, 'MANDALE  VAISHNAVI  SANJAY', 'FEMALE', 'sanjaymandale73@gmail.com', 2147483647),
(43, 24743, 'MANE  VAIBHAV  NAGURAO', 'MALE', 'manevaibhav09@gmail.com', 2147483647),
(44, 24744, 'MANE RITESH UMAKANT', 'MALE', 'riteshmane09022005@gmail.com', 2147483647),
(45, 24745, 'NANDURGE  RIYAN  RIYAZ', 'MALE', 'nandurgeriyan@gmail.com', 2147483647),
(46, 24746, 'PANCHAL  SARIKHA  GUNDERAO', 'FEMALE', 'sarikapanchal2003@gmail.com', 2147483647),
(47, 24747, 'PARIHAR  VISHAL  MADHUKAR', 'MALE', 'pariharmadhukar@gmail.com', 2147483647),
(48, 24748, 'PATHAN  SHOHEB  YUSUF', 'MALE', 'PATHANSHOHEB85@GMAIL.COM', 2147483647),
(49, 24749, 'PATIL  ADITYA  GOVIND', 'MALE', 'adityapatil0203@gmail.com', 2147483647),
(50, 24750, 'PATIL  SANCHITA  SANTOSH', 'FEMALE', 'patilsantosh@gmail.com', 2147483647),
(51, 24751, 'PAWAR  GAYATRI  SUHAR', 'FEMALE', 'pawargayatri@gmail.com', 2147483647),
(52, 24752, 'PAWAR YOGESH  BALAJI', 'MALE', 'yogeshpoawarb407@gmail.com', 2147483647),
(53, 24753, 'PISAL  PALLAVI  ATMARAM', 'FEMALE', 'nehapisal97@gmail.com', 2147483647),
(54, 24754, 'RAUT  DHANRAJ  DILIP', 'MALE', 'DHANRAJRAUT427@GMAIL.COM', 2147483647),
(55, 24755, 'RAUTRAO  ADITYA  VIKASRAO', 'MALE', 'adityarautrao1657@gmail.com', 2147483647),
(56, 24756, 'SHAIKH  MAHEK  BURAN', 'FEMALE', 'shaikhburan@gmail.com', 2147483647),
(57, 24757, 'SHEWALKAR  VAISHNAVI  VINOD', 'FEMALE', 'shewalkarvaishnavi@gmail.com', 2147483647),
(58, 24758, 'SHINDE  GOPAL  NILKANTH', 'MALE', 'gopalshinde191@gmail.com', 2147483647),
(59, 24759, 'SHINDE  PAYAL  PANDIT', 'FEMALE', 'payalshinde1910@gmail.com', 2147483647),
(60, 24760, 'SOLANKAR  ADITI  MOHAN', 'FEMALE', 'msolankar768@gmail.com', 2147483647),
(61, 24761, 'SONKAMBLE  PRATIK  SHANKAR', 'MALE', 'sonkamble@gmail.com', 2147483647),
(62, 24762, 'SURYAWANSHI  RAGINI  RAJKUMAR', 'FEMALE', 'rajumars@gmail.com', 2147483647),
(63, 24763, 'SURYAWANSHI  TUSHAR  MILIND', 'MALE', 'tushar11suryawanshi@gmail.com', 2147483647),
(64, 24764, 'SWAMI  ABHAY  SANMUKH', 'MALE', 'abhayswai2004@gmail.com', 2147483647),
(65, 24765, 'SWAMI  ASHISH  YOGESH', 'MALE', 'ashishswami454154@gmail.com', 2147483647),
(66, 24766, 'TURE  GOVIND  SHANKAR', 'MALE', 'GOVINDTURE98@GMAIL.COM', 2147483647),
(67, 24767, 'WAGHMARE  NIKHIL  RAJU', 'MALE', 'nikhil9356293711@gmail.com', 2147483647),
(68, 24768, 'WAGHMARE  SNEHA  BHAGAVAT', 'FEMALE', 'waghmareb@gmail.com', 2147483647),
(69, 24769, 'WANMARE  RADHIKA  BALAJI', 'FEMALE', 'radhikawanmare123@gmail.com', 2147483647),
(70, 24770, 'YELGATE  PRATIKSHA  BALAJI', 'FEMALE', 'pratikyelgate007@gmail.com', 2147483647),
(71, 24771, 'HAJARE  SHWETA  SOMNATH', 'FEMALE', '', 2147483647),
(72, 24772, 'HANNURE  WASIM  RAFIK', 'MALE', 'wasimhannure07@gmail.com', 2147483647),
(73, 24801, 'ADE  DEEPAK  DAYANAND', 'MALE', 'ADED29718@GMAIL.COM', 2147483647),
(74, 24802, 'AKANGIRE  VAISHNAVI  BALAJI', 'FEMALE', 'akangirevaishanvi2003@gmail.com', 2147483647),
(75, 24803, 'BACHATE  AMARNATH  SUBHASH', 'MALE', 'bachateamar04@gmail.com', 2147483647),
(76, 24804, 'BAGWAN  MO HUSEN  A HAMID', 'MALE', 'bagwanh@GMAIL.COM', 2147483647),
(77, 24805, 'BAGWAN  TAYYBA  MATIN', 'FEMALE', 'ajimbagwsn@gmail.com', 2147483647),
(78, 24806, 'BARURE  SONAL  DATTATRAYA', 'FEMALE', 'dattabaraue4201@gmail.com', 2147483647),
(79, 24807, 'BHALERAO  VISHAL  UDDHAV', 'MALE', 'bhaleraovishal129@gmail.com', 2147483647),
(80, 24808, 'BHATLAWANDE  ADITI  ANIRUDDH', 'FEMALE', 'bhatlawandeaditi09@gmail.com', 2147483647),
(81, 24809, 'BHISE  RAJSHRI  TRIMBAKRAO', 'FEMALE', 'rajshreebhise678@gmail.com', 2147483647),
(82, 24810, 'BHISE  VAISHNAVI  VISHNU', 'FEMALE', 'vaishanibhise80@gmail.com', 2147483647),
(83, 24811, 'BHISE  YOGITA  MAROTI', 'FEMALE', 'bhisem@gmail.com', 2147483647),
(84, 24812, 'BHUSARE  SANDHYA  SANTOSH', 'FEMALE', 'khushibhusare68@gmail.com', 2147483647),
(85, 24813, 'CHAME  NIKITA  NAVANATH', 'FEMALE', 'nikitachame24@gmail.com', 2147483647),
(86, 24814, 'CHAMLEWAD  SANGMESHWAR  SUBHASH', 'MALE', 'sangmeshwarchamalewad@gmail.com', 2147483647),
(87, 24815, 'CHANGULE  ANKITA  BALAJI', 'FEMALE', 'changuleankita@gmail.com', 2147483647),
(88, 24816, 'CHAUDHARI  PANKAJ  VISHNU', 'MALE', 'chaudhari@gmail.com', 2147483647),
(89, 24817, 'CHAVAN  VAISHNAVI  VISHWANATH', 'FEMALE', 'amarchavan40@gmail.com', 2147483647),
(90, 24818, 'CHAWALE  PRASHANT  DEVIDAS', 'MALE', 'chevalev@gmail.com', 2147483647),
(91, 24819, 'CHIKATE  PREM  MILIND', 'MALE', 'premchikate01@gmail.com', 2147483647),
(92, 24820, 'DAKHANE PARVEJ  PASHA', 'MALE', 'dhakaniparvej0@gmail.com', 2147483647),
(93, 24821, 'DAPKE  PRADUMNA  ANGAD', 'MALE', 'praddumnp@gmail.com', 2147483647),
(94, 24822, 'DEVKAR  AJAY  VYANKAT', 'MALE', 'ajaydevkar7350@gmail.com', 2147483647),
(95, 24823, 'FAVADE  ROHAN  RAHUL', 'MALE', 'favader@gmail.com', 2147483647),
(96, 24824, 'GADGALE OMKAR BHAGWAT', 'MALE', 'gadgaleomkar@gmail.com', 2147483647),
(97, 24825, 'GAIKWAD  ABHISHEK  MADHUKAR', 'MALE', 'abhishekgaikwad1881@gmail.com', 2147483647),
(98, 24826, 'GHADGE  ADITYA  VILAS', 'MALE', 'aadityaghadge1542004@gmail.com', 2147483647),
(99, 24827, 'GHADLE  SURAJ  MAHESH', 'MALE', 'ghadlesuraj987@gmail.com', 2147483647),
(100, 24828, 'GHANGAVKAR  VIJAY  MOTIRAM', 'MALE', 'motiramng@gmail.com', 2147483647),
(101, 24829, 'GILDA  SHRADHA  ANAND', 'FEMALE', 'shradhagilda18@gmail.com', 2147483647),
(102, 24830, 'GOMCHALE  RADHIKA  DIGAMBAR', 'FEMALE', 'radhikagomchale@gmail.com', 2147483647),
(103, 24831, 'GUND  YOGESHWARI  SATISH', 'FEMALE', 'gundyogeshwari@gmail.com', 2147483647),
(104, 24832, 'HALLE  VINAYAK  VIJAYKUMAR', 'MALE', 'vinaykhalle@gmail.com', 2147483647),
(105, 24833, 'HARALE  ABHIJIT  DHONDIBA', 'MALE', 'haraled@gmail.com', 2147483647),
(106, 24834, 'JADHAV  RADHA  SANJAY', 'FEMALE', 'jadhavradha077@gmail.com', 2147483647),
(107, 24835, 'JADHAV  SHUBHAM  BHAGWAN', 'MALE', 'shubhampatil6110@gmail.com', 2147483647),
(108, 24836, 'JAGTAP  NIKITA  SANTOSH', 'FEMALE', 'jagtaps@gmail.com', 2147483647),
(109, 24837, 'KADAM ANIKET BHAUSAHEB', 'MALE', 'aniketkadam7387@gmail.com', 2147483647),
(110, 24838, 'KAPASE  VAISHNAVI  DILIP', 'FEMALE', 'kapasevaishnavi326@gmail.com', 2147483647),
(111, 24839, 'KHADAP  GANGA  ABASAHEB', 'FEMALE', 'gangakhadap960@gmail.com', 2147483647),
(112, 24840, 'KORE  ABHISHEK  MAHADEV', 'MALE', 'koreabhishek52@gmail.com', 2147483647),
(113, 24841, 'KULKARNI  PALLAVI  VYANKATESH', 'FEMALE', 'pallavikulkarni@gmail.com', 2147483647),
(114, 24842, 'LAD  MAHESH  VISHNU', 'MALE', 'maheshlad9037@gmail.com', 2147483647),
(115, 24843, 'MAGAR POOJA KAKASAHEB', 'FEMALE', 'poojamagar9922@gmail.com', 2147483647),
(116, 24844, 'MANE  DIPALI  HANMANT', 'FEMALE', 'dipalihm2004@gmail.com', 2147483647),
(117, 24845, 'MANE  PRANAV  HANMANT', 'MALE', 'baliramm77@gmail.com', 2147483647),
(118, 24846, 'MANE  SUSHMITA  SUDHAKAR', 'FEMALE', 'manesudhakr97@gmail.com', 2147483647),
(119, 24847, 'MATH  VAISHNAVI  CHANNAVIR', 'FEMALE', 'vaishanavimate678@gmail.com', 2147483647),
(120, 24848, 'MUNGALE  SAIFALI  KHUNMIR', 'MALE', 'saifalimugale@gmail.com', 2147483647),
(121, 24849, 'NELWADE  VAISHNAVI  DHONDIRAM', 'FEMALE', 'nelwadevaishnavi@gmail.com', 2147483647),
(122, 24850, 'NILANKAR  RADHESHYAM  UTTAMRAO', 'MALE', 'nilankaru@gmail.com', 2147483647),
(123, 24851, 'PANCHAL  OMKAR  ACHYUT', 'MALE', 'panchalachut@gmail.com', 2147483647),
(124, 24852, 'PATHAN  MUSKAN  RAFIK', 'FEMALE', 'muskanshaikh786@gmail.com', 2147483647),
(125, 24853, 'RATHOD  ADITYA  VINAYAK', 'MALE', 'adityarathodv@gmail.com', 2147483647),
(126, 24854, 'REDDY  BASAVKIRAN  SANJAY', 'MALE', 'basavkiranreddy@gmail.com', 2147483647),
(127, 24855, 'REDDY  GANESH  CHANDRAKANT', 'MALE', 'ganeshreddy15042003@gmail.com', 2147483647),
(128, 24856, 'SAKHARE  ABHISHEK  BHAGWAT', 'MALE', 'sakhareabhi91@gmail.com', 2147483647),
(129, 24857, 'SAKHARE  AKSHAY  KESHAV', 'MALE', 'sakharekesdhav@gmail.com', 2147483647),
(130, 24858, 'SAUDAGAR  SAMREEN  YUSUF', 'FEMALE', 'yusufsaudagar74@gmail.com', 2147483647),
(131, 24859, 'SAUDAGAR  TABASSUM  SALEEM', 'FEMALE', 'saudagartabassum123@gmail.com', 2147483647),
(132, 24860, 'SAWANT  VAIBHAVI  RAMRAJE', 'FEMALE', 'sawantvaibhav869825@gmail.com', 2147483647),
(133, 24861, 'SHAIKH  SANIYA  IBRAHIM', 'FEMALE', 'shaikhibrahim@gmail.com', 2147483647),
(134, 24862, 'SHAIKH  SHAFIYA  FARID', 'FEMALE', 'SS1634972@GMAIL.COM', 2147483647),
(135, 24863, 'SHASTRI PRACHI B K', 'FEMALE', 'shastrib@gmail.com', 2147483647),
(136, 24864, 'SHENDGE  HRITHIK  BHARAT', 'MALE', 'shendgehrithik@gmail.com', 2147483647),
(137, 24865, 'SHINDE  NIKITA  RAJENDRA', 'FEMALE', 'shinderajendra@gmail.com', 2147483647),
(138, 24866, 'SOMWANSHI  SAI  ARUN', 'FEMALE', 'somwanshisai@gmail.com', 2147483647),
(139, 24867, 'SONVANE  PARUTHVIRAJ  SUNIL', 'MALE', 'pruthivirajsonavane18@gmail.com', 2147483647),
(140, 24868, 'SURWASE  SHRIKANT  GANGADHAR', 'MALE', 'surwaseshrikant14@gmail.com', 2147483647),
(141, 24869, 'SURYAWANSHI  SAKSHI  MAHESHANKAR', 'FEMALE', 'suryawanshisakshi05@gmail.com', 2147483647),
(142, 24870, 'SURYAWANSHI  SUPRIYA  BALBHIM', 'FEMALE', 'suryawanshib@gmail.com', 2147483647),
(143, 24871, 'TACHALE  MANSI  NITIN', 'FEMALE', 'mansitachale2509@gmail.com', 2147483647),
(144, 24872, 'THORAT  PRATIK  BHAGWAT', 'MALE', 'pratikthorat9307@gmail.com', 2147483647),
(145, 24873, 'THOTE  OMKAR  BABURAO', 'MALE', 'thokebaburao@gmail.com', 2147483647),
(146, 24874, 'UPADE  ADITYA  BABU', 'MALE', 'adityaupade@gmail.com', 2147483647),
(147, 24875, 'VATARI  RENUKA  NARAYAN', 'FEMALE', 'vatarirenuka860@gmail.com', 2147483647),
(148, 24876, 'YELGATE  ROHINI  ANGAD', 'FEMALE', 'yelgateangad@gmail.com', 2147483647),
(149, 24877, 'YELLEBOINWAD  RAHUL  VENKAT', 'MALE', 'rahulyellebononwad@gmail.com', 2147483647),
(150, 24878, 'YELMATE  SANKET  VINOD', 'MALE', 'yelmatevinod@gmail.com', 2147483647),
(151, 24879, 'SALUNKE  RENUKA  MAHADEV', 'FEMALE', 'salunkerenuka40@gmail.com', 2147483647),
(152, 24880, 'MANE  ISHWAR  RAJESAHEB', 'MALE', 'omkarmane@gmai.com', 2147483647),
(153, 24881, 'CHAUDHARI  ZEENAT  MUSTAFA', 'FEMALE', 'zeenatchudhary9503@gmail.com', 2147483647),
(1, 24701, 'AAGLAVE  NIKITA  SUDAM', 'FEMALE', 'aaglavesudam@gmail.com', 2147483647),
(2, 24702, 'ADMANE  POOJA  CHANDRAKANT', 'FEMALE', 'poojaadmane15@gmail.com', 2147483647),
(3, 24703, 'AJANE  PRAVIN  SHIVKUMAR', 'MALE', 'AJANESHRIKUMAR@GMAIL.COM', 2147483647),
(4, 24704, 'AKANGIRE  ANKITA  TUKARAM', 'FEMALE', 'aknagire@gmail.com', 2147483647),
(5, 24705, 'ARADHYE  VISHNU  GANPATI', 'MALE', 'aradhyevishnu@gmail.com', 2147483647),
(6, 24706, 'BEMBADE  VIKKI  VASANTRAO', 'MALE', 'vvbembade@gmail.com', 2147483647),
(7, 24707, 'BHANDARE  VAISHNAVI  HANMANT', 'FEMALE', 'BHANDAREV@GMAIL.COM', 2147483647),
(8, 24708, 'BHANDE  NIVRUTTI  VINOD', 'MALE', 'nivruttibhonde111@gmail.com', 2147483647),
(9, 24709, 'BHISE  ROHINI  SUNIL', 'FEMALE', 'rohinibhise089@gmail.com', 2147483647),
(10, 24710, 'BHOSLE  SWATI  DEVIDAS', 'FEMALE', 'bhosaled@gmail.com', 2147483647),
(11, 24711, 'BOLSURE  DEVASHISH  RAJESH', 'MALE', 'bolsuredewashish15@gmail.com', 2147483647),
(12, 24712, 'CHAUGULE  NAMRATA  DATTATRAY', 'FEMALE', 'chauguled@gmail.com', 2147483647),
(13, 24713, 'CHAVAN  SAMADHAN  RAMESH', 'MALE', 'chavanr@gmail.com', 2147483647),
(14, 24714, 'CHAVAN  SHRAVAN  GORAKH', 'MALE', 'shravanchavan311@gmail.com', 2147483647),
(15, 24715, 'CHAVAN  SUPRIYA  VASANT', 'FEMALE', 'chavanvasant222@gmail.com', 2147483647),
(16, 24716, 'DAHIVALE  MEGHA  NARAYAN', 'FEMALE', 'thenghadahiwale5562@gmail.com', 2147483647),
(17, 24717, 'DESHMUKH  ABHAYSINH  SHRIKISHAN', 'MALE', 'abhaysinhdeshmukh302@gmail.com', 2147483647),
(18, 24718, 'DHAGE  DIKSHA  VINOD', 'FEMALE', 'dhagev@gmail.com', 2147483647),
(19, 24719, 'GADIWALE  RAHIL  RAHIM', 'MALE', 'rahilgadiwale1@gmail.com', 2147483647),
(20, 24720, 'GAIKWAD  VISHAL  CHANDRAKANT', 'MALE', 'vg976425@gmail.com', 2147483647),
(21, 24721, 'HAQ  SARA FATEMA  MERAJUL', 'FEMALE', 'sarah@gmail.com', 2147483647),
(22, 24722, 'IDEKAR  ANIKET  LIMBRAJ', 'MALE', 'aniketidekar2005@gmail.com', 2147483647),
(23, 24723, 'JADHAV  MANGESH  SUBHASH', 'MALE', 'mangeshj2603@gmail.com', 2147483647),
(24, 24724, 'JADHAV  PRASHANT  ANGAD', 'MALE', 'prashantj4554@gmail.com', 2147483647),
(25, 24725, 'JAGADALE  SANDHYARANI  MANIK', 'MALE', 'sandhyaranij@gmail.com', 2147483647),
(26, 24726, 'JAMBHALDARE AJAY MARUTI', 'MALE', 'jambhaldarem@gmail.com', 2147483647),
(27, 24727, 'KADAM  VAISHNAVI  UTTAM', 'FEMALE', 'kadamu362@gmail.com', 2147483647),
(28, 24728, 'KAMBLE  ADITYA  BALAJI', 'MALE', 'kamblebalaji@gmail.com', 2147483647),
(29, 24729, 'KAMBLE  ROHIT  BABURAO', 'MALE', 'rk8879067@gmail.com', 2147483647),
(30, 24730, 'KAMBLE  VIJAY  PANDURANG', 'MALE', 'kamblep@gmail.com', 2147483647),
(31, 24731, 'KANADE  SWAPNIL  UTTARESHWAR', 'MALE', 'kanadeswapnil9529767618@gmail.com', 2147483647),
(32, 24732, 'KARALEKAR  RATNADIP  SATISH', 'MALE', 'ratandipkaralekar123@gmail.com', 2147483647),
(33, 24733, 'KAWADE  MADHUR  DATTATRAY', 'MALE', 'kawaded@gmail.com', 2147483647),
(34, 24734, 'KHAN  TANZEEN  MINHAJ', 'MALE', 'khantazeen2004@gmail.com', 2147483647),
(35, 24735, 'KHOSE  ASHLESHA  ANIL', 'FEMALE', 'khoseanil@gmail.com', 2147483647),
(36, 24736, 'KISWE  PRANAY  BALAJI', 'MALE', 'kiswebalaji@gmail.com', 2147483647),
(37, 24737, 'KULKARNI  ANKITA  PRAMOD', 'FEMALE', 'kulkarnip@gmail.com', 2147483647),
(38, 24738, 'KULKARNI  SAKSHI  NITIN', 'FEMALE', 'sakhikulkarni254@gmail.com', 2147483647),
(39, 24739, 'LOBHE  PRATHAMESH  ANKUSHRAO', 'MALE', 'prathmesh123@gmail.com', 2147483647),
(40, 24740, 'MACHVE  TEJAS  GOVIND', 'MALE', 'tejasmachave@gmail.com', 2147483647),
(41, 24741, 'MADJE  RAGHUVEER  BHAGIRATH', 'MALE', 'amarmadje88@gmail.com', 2147483647),
(42, 24742, 'MANDALE  VAISHNAVI  SANJAY', 'FEMALE', 'sanjaymandale73@gmail.com', 2147483647),
(43, 24743, 'MANE  VAIBHAV  NAGURAO', 'MALE', 'manevaibhav09@gmail.com', 2147483647),
(44, 24744, 'MANE RITESH UMAKANT', 'MALE', 'riteshmane09022005@gmail.com', 2147483647),
(45, 24745, 'NANDURGE  RIYAN  RIYAZ', 'MALE', 'nandurgeriyan@gmail.com', 2147483647),
(46, 24746, 'PANCHAL  SARIKHA  GUNDERAO', 'FEMALE', 'sarikapanchal2003@gmail.com', 2147483647),
(47, 24747, 'PARIHAR  VISHAL  MADHUKAR', 'MALE', 'pariharmadhukar@gmail.com', 2147483647),
(48, 24748, 'PATHAN  SHOHEB  YUSUF', 'MALE', 'PATHANSHOHEB85@GMAIL.COM', 2147483647),
(49, 24749, 'PATIL  ADITYA  GOVIND', 'MALE', 'adityapatil0203@gmail.com', 2147483647),
(50, 24750, 'PATIL  SANCHITA  SANTOSH', 'FEMALE', 'patilsantosh@gmail.com', 2147483647);

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `teacher_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  `lab_in_charge` varchar(100) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('Admin','Teacher') DEFAULT 'Teacher',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`teacher_id`, `name`, `email`, `phone_number`, `lab_in_charge`, `username`, `password_hash`, `role`, `created_at`, `updated_at`) VALUES
(1, 'Aditya', 'ak8806657127@gmail.com', '9699600638', 'All Labs', 'admin', 'adi', 'Admin', '2025-01-18 14:30:58', '2025-01-18 14:30:58'),
(2, 'Kamble Aditya balaji', 'droptechnologyes@gmail.com', '09699600638', 'admin', 'adi', '$2y$10$XUEyHiRFN5uOnD4Bt4MIie5OarEHe7CSsHhYHufyoMDDsBj22vLoe', 'Admin', '2025-03-04 18:57:16', '2025-03-04 18:57:16');

-- --------------------------------------------------------

--
-- Table structure for table `technicians`
--

CREATE TABLE `technicians` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `verified` tinyint(1) DEFAULT 0,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `verification_token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `phone` varchar(20) DEFAULT NULL,
  `specialization` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `technicians`
--

INSERT INTO `technicians` (`id`, `name`, `email`, `password`, `verified`, `status`, `verification_token`, `created_at`, `phone`, `specialization`) VALUES
(1, 'Kamble Aditya Balaji', 'drotechnologyes@gmail.com', '$2y$10$Ftefvp9ryyicbTObpO6BCOCWCUZ.GBFS/yhEvlgp8b7rYe.oBLZl.', 1, 'approved', NULL, '2025-02-20 15:37:53', '09699600638', ''),
(2, 'Kamble vijay', 'vijay@gmail.com', '$2y$10$/VK4EIQMCJYdBU4Y1ey/cuO9fThisnD9T6ud5gpbVoxc1QFOOvqKS', 0, 'approved', NULL, '2025-02-20 16:35:35', NULL, NULL),
(3, 'Ajay', 'ajay@gmail.com', '$2y$10$CdVepstn0CV20SdoEixeI.YwXjxGFnbV0YqRAOkC.rylRboLGktCi', 0, 'approved', NULL, '2025-02-20 16:36:14', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `roll_no` varchar(20) DEFAULT NULL,
  `class` varchar(50) DEFAULT NULL,
  `subjects` text DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `verification_token` varchar(255) DEFAULT NULL,
  `is_verified` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `roll_no`, `class`, `subjects`, `photo`, `email`, `password`, `verification_token`, `is_verified`) VALUES
(1, 'admin', '1', NULL, NULL, NULL, 'admin@gmail.com', '$2y$10$74BpqUpHS.DECEH7hTAziOvErMnZ4MsSQ1MdwFepcQ.e/7aV8JI/.', NULL, 0),
(6, 'ajay', '24726', NULL, NULL, NULL, 'admin5@gmail.com', '$2y$10$g.aLAgQZ7QenQDaUC6P9xOr9zLPkWIutwYTvfmVr5BGym5sT1kg8i', NULL, 0),
(7, 'admin5', '24755', NULL, NULL, NULL, 'admin5@gmail.com', '$2y$10$WkiZzHMDM9fHEWMCP1AYTu2w38MazWwTNyS.tk58Xm/m23IKq9Boa', NULL, 0),
(10, 'Kamble Vijay Pandurang', '24730', 'BCA TY', 'PHP,C++', 'uploads/WhatsApp Image 2025-01-22 at 13.40.39.jpeg', 'vijayk366602@gmail.com', '$2y$10$q56bhBConrr.C4OO9VT4T.6tp.U3.jOW8jO4D/bgD5utlMhMlywvK', NULL, 0),
(11, 'Kamble Aditya Balaji', '24728', 'BCA TY', 'cpp', 'uploads/IMG_20241013_145328.jpg', 'ak8806657127@gmail.com', '$2y$10$cxh59SJsXxvaV8JlkLt88.NFANHCVNviU4.W0R5SVT7Am.LpxJI1K', '4c9ccc2c254d99e765ccd137b5469f59', 0),
(16, 'shivani', '24427', NULL, NULL, NULL, 'shivanihanchate27@gamil.com', '$2y$10$5w.CnEj5Wy44Y1Nr/obfrui6kt9vX20NqVPpey9pPPxsYcg/BYeoi', NULL, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `complaints`
--
ALTER TABLE `complaints`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `computers`
--
ALTER TABLE `computers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `asset_id` (`asset_id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`teacher_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `technicians`
--
ALTER TABLE `technicians`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `roll_no` (`roll_no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `complaints`
--
ALTER TABLE `complaints`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `computers`
--
ALTER TABLE `computers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `teacher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `technicians`
--
ALTER TABLE `technicians`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
