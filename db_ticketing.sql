-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 12, 2021 at 04:11 AM
-- Server version: 5.7.24
-- PHP Version: 7.2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_imawiproites`
--

-- --------------------------------------------------------

--
-- Table structure for table `mst_ticketing_approval`
--

CREATE TABLE `mst_ticketing_approval` (
  `ticketing_approval_id` int(11) NOT NULL,
  `ticketing_requester_nik` varchar(10) NOT NULL,
  `ticketing_approval_nik_1` varchar(10) DEFAULT NULL,
  `ticketing_approval_nik_1_date` timestamp NULL DEFAULT NULL,
  `ticketing_approval_nik_2` varchar(10) DEFAULT NULL,
  `ticketing_approval_nik_2_date` timestamp NULL DEFAULT NULL,
  `ticketing_approval_nik_3` varchar(10) DEFAULT NULL,
  `ticketing_approval_nik_3_date` timestamp NULL DEFAULT NULL,
  `ticketing_approval_nik_4` varchar(10) DEFAULT NULL,
  `ticketing_approval_nik_4_date` timestamp NULL DEFAULT NULL,
  `ticketing_approval_nik_5` varchar(10) DEFAULT NULL,
  `ticketing_approval_nik_5_date` timestamp NULL DEFAULT NULL,
  `ticketing_approval_nik_6` varchar(10) DEFAULT NULL,
  `ticketing_approval_nik_6_date` timestamp NULL DEFAULT NULL,
  `ticketing_approval_nik_hr` varchar(10) DEFAULT NULL,
  `ticketing_approval_nik_hr_date` timestamp NULL DEFAULT NULL,
  `ticketing_approval_nik_ceo` varchar(10) DEFAULT NULL,
  `ticketing_approval_nik_ceo_date` timestamp NULL DEFAULT NULL,
  `created_by` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` varchar(50) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_by` varchar(50) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `ticket_id` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mst_ticketing_approval`
--

INSERT INTO `mst_ticketing_approval` (`ticketing_approval_id`, `ticketing_requester_nik`, `ticketing_approval_nik_1`, `ticketing_approval_nik_1_date`, `ticketing_approval_nik_2`, `ticketing_approval_nik_2_date`, `ticketing_approval_nik_3`, `ticketing_approval_nik_3_date`, `ticketing_approval_nik_4`, `ticketing_approval_nik_4_date`, `ticketing_approval_nik_5`, `ticketing_approval_nik_5_date`, `ticketing_approval_nik_6`, `ticketing_approval_nik_6_date`, `ticketing_approval_nik_hr`, `ticketing_approval_nik_hr_date`, `ticketing_approval_nik_ceo`, `ticketing_approval_nik_ceo_date`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`, `ticket_id`) VALUES
(12, '76112008', '65161410', NULL, '72231706', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Muhammad Bona Rizki', '2021-07-08 09:58:49', 'Muhammad Bona Rizki', '2021-07-08 09:58:49', NULL, NULL, '04/0721TCK'),
(29, '76112008', '65161410', NULL, '72231706', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Muhammad Bona Rizki', '2021-07-10 13:22:40', 'Muhammad Bona Rizki', '2021-07-10 13:22:40', NULL, NULL, '05/0721TCK');

-- --------------------------------------------------------

--
-- Table structure for table `mst_ticketing_approval_type`
--

CREATE TABLE `mst_ticketing_approval_type` (
  `approval_type_id` int(11) NOT NULL,
  `approval_nik` varchar(10) NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` varchar(50) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_by` varchar(50) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `type_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mst_ticketing_menu_child`
--

CREATE TABLE `mst_ticketing_menu_child` (
  `menu_child_id` int(11) NOT NULL,
  `menu_child_name` varchar(100) NOT NULL,
  `menu_child_icon` varchar(50) DEFAULT NULL,
  `menu_child_url` varchar(100) NOT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` varchar(100) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_by` varchar(100) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `menu_parent_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mst_ticketing_menu_child`
--

INSERT INTO `mst_ticketing_menu_child` (`menu_child_id`, `menu_child_name`, `menu_child_icon`, `menu_child_url`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`, `menu_parent_id`) VALUES
(13, 'Menu', 'fa fa-cog text-warning', 'ticketing/menu', 'Muhammad Bona Rizki', '2021-04-14 07:11:47', 'Muhammad Bona Rizki', '2021-04-15 08:36:34', NULL, NULL, 9),
(14, 'Access', 'fa fa-cog text-warning', 'ticketing/access', 'Muhammad Bona Rizki', '2021-04-14 08:38:29', 'Muhammad Bona Rizki', '2021-04-15 08:36:06', NULL, NULL, 9),
(15, 'Access Position', 'fa fa-cog text-warning', 'ticketing/access-position', 'Muhammad Bona Rizki', '2021-04-15 07:52:01', 'Muhammad Bona Rizki', '2021-04-15 08:36:19', NULL, NULL, 9),
(16, 'Priority', 'fa fa-cog text-warning', 'ticketing/priority', 'Muhammad Bona Rizki', '2021-04-16 01:46:42', 'Muhammad Bona Rizki', '2021-04-16 02:21:09', NULL, NULL, 9),
(17, 'Ticket Type', 'fa fa-cog text-warning', 'ticketing/type', 'Muhammad Bona Rizki', '2021-04-16 08:04:15', 'Muhammad Bona Rizki', '2021-04-16 08:04:15', NULL, NULL, 9),
(18, 'Approval Type', 'fa fa-cog text-warning', 'ticketing/approval/type', 'Muhammad Bona Rizki', '2021-04-26 01:51:08', 'Muhammad Bona Rizki', '2021-05-17 02:22:38', NULL, NULL, 9);

-- --------------------------------------------------------

--
-- Table structure for table `mst_ticketing_menu_grand_child`
--

CREATE TABLE `mst_ticketing_menu_grand_child` (
  `menu_grand_child_id` int(11) NOT NULL,
  `menu_grand_child_name` varchar(100) NOT NULL,
  `menu_grand_child_icon` varchar(50) DEFAULT NULL,
  `menu_grand_child_url` varchar(100) NOT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` varchar(100) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_by` varchar(100) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `menu_child_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mst_ticketing_menu_parent`
--

CREATE TABLE `mst_ticketing_menu_parent` (
  `menu_parent_id` int(11) NOT NULL,
  `menu_parent_name` varchar(100) NOT NULL,
  `menu_parent_icon` varchar(50) DEFAULT NULL,
  `menu_parent_url` varchar(100) NOT NULL,
  `menu_parent_status` char(1) NOT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` varchar(100) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_by` varchar(100) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mst_ticketing_menu_parent`
--

INSERT INTO `mst_ticketing_menu_parent` (`menu_parent_id`, `menu_parent_name`, `menu_parent_icon`, `menu_parent_url`, `menu_parent_status`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`) VALUES
(1, 'Dashboard', 'fa fa-home text-primary', 'ticketing', '0', 'Muhammad Bona Rizki', '2021-04-14 07:06:50', 'Muhammad Bona Rizki', '2021-04-14 08:16:20', NULL, NULL),
(9, 'Management', 'fa fa-cog text-warning', '#', '0', 'Muhammad Bona Rizki', '2021-04-14 07:11:09', 'Muhammad Bona Rizki', '2021-04-14 07:29:58', NULL, NULL),
(10, 'Form Request', 'fa fa-file-invoice text-success', 'ticketing/request', '0', 'Muhammad Bona Rizki', '2021-05-18 03:37:23', 'Muhammad Bona Rizki', '2021-05-18 03:45:48', NULL, NULL),
(11, 'Status', 'fa fa-history text-info', 'ticketing/status', '0', 'Muhammad Bona Rizki', '2021-07-05 06:48:53', 'Muhammad Bona Rizki', '2021-07-05 06:58:30', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mst_ticketing_priority`
--

CREATE TABLE `mst_ticketing_priority` (
  `priority_id` int(11) NOT NULL,
  `priority_name` varchar(50) NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` varchar(50) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_by` varchar(50) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mst_ticketing_priority`
--

INSERT INTO `mst_ticketing_priority` (`priority_id`, `priority_name`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`) VALUES
(1, 'biasa', 'Muhammad Bona Rizki', '2021-04-16 13:48:54', 'Muhammad Bona Rizki', '2021-07-11 16:33:19', 'Muhammad Bona Rizki', NULL),
(2, 'penting', 'Muhammad Bona Rizki', '2021-04-16 14:44:54', 'Muhammad Bona Rizki', '2021-04-16 07:56:20', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mst_ticketing_type`
--

CREATE TABLE `mst_ticketing_type` (
  `type_id` int(11) NOT NULL,
  `type_name` varchar(50) NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` varchar(50) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_by` varchar(50) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `agent_nik` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mst_ticketing_type`
--

INSERT INTO `mst_ticketing_type` (`type_id`, `type_name`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`, `agent_nik`) VALUES
(1, 'support', '', '2021-04-16 08:56:16', '', '2021-04-16 09:00:05', 'Muhammad Bona Rizki', '2021-04-16 09:00:05', '0'),
(2, 'testo', '', '2021-04-16 09:00:11', 'Muhammad Bona Rizki', '2021-05-11 02:33:55', 'Muhammad Bona Rizki', '2021-05-11 02:33:55', '76112008'),
(3, 'test user agent', '', '2021-04-22 08:52:53', 'Muhammad Bona Rizki', '2021-05-11 02:33:59', 'Muhammad Bona Rizki', '2021-05-11 02:33:59', '76112008'),
(4, 'SAP Report', '', '2021-05-11 02:34:38', 'Muhammad Bona Rizki', '2021-05-11 02:34:38', NULL, NULL, '10110301'),
(5, 'Email / Internet', '', '2021-05-11 02:35:22', 'Muhammad Bona Rizki', '2021-05-11 02:35:22', NULL, NULL, '36220903'),
(6, 'SAP User', '', '2021-05-11 02:39:26', 'Muhammad Bona Rizki', '2021-05-11 02:39:26', NULL, NULL, '25990707'),
(7, 'VPN', '', '2021-05-11 02:43:02', 'Muhammad Bona Rizki', '2021-05-11 03:21:10', NULL, NULL, '38850911'),
(8, 'IT PO', '', '2021-06-03 02:20:05', 'Muhammad Bona Rizki', '2021-06-03 02:20:05', NULL, NULL, '36220903');

-- --------------------------------------------------------

--
-- Table structure for table `trans_ticket`
--

CREATE TABLE `trans_ticket` (
  `ticket_id` int(11) NOT NULL,
  `ticket_subject` text NOT NULL,
  `ticket_image` text NOT NULL,
  `on_process_at` timestamp NULL DEFAULT NULL,
  `finish_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` varchar(50) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_by` varchar(50) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `priority_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `trans_ticketing_detail_po`
--

CREATE TABLE `trans_ticketing_detail_po` (
  `detail_po_id` int(11) NOT NULL,
  `nama_barang` varchar(50) NOT NULL,
  `qty` varchar(50) NOT NULL,
  `harga` varchar(50) NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` varchar(50) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_by` varchar(50) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `ticket_id` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trans_ticketing_detail_po`
--

INSERT INTO `trans_ticketing_detail_po` (`detail_po_id`, `nama_barang`, `qty`, `harga`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`, `ticket_id`) VALUES
(1, 'keyboard', '2', '500000', 'Muhammad Bona Rizki', '2021-06-08 03:50:01', 'Muhammad Bona Rizki', '2021-06-08 03:50:01', NULL, NULL, '03/0621TCK'),
(22, 'bola', '2', '2000000', 'Muhammad Bona Rizki', '2021-07-08 09:58:49', 'Muhammad Bona Rizki', '2021-07-08 09:58:49', NULL, NULL, '04/0721TCK'),
(23, 'test', '2', '300000', 'Muhammad Bona Rizki', '2021-07-08 09:58:49', 'Muhammad Bona Rizki', '2021-07-08 09:58:49', NULL, NULL, '04/0721TCK'),
(56, 'test', '2', '20000', 'Muhammad Bona Rizki', '2021-07-10 13:22:40', 'Muhammad Bona Rizki', '2021-07-10 13:22:40', NULL, NULL, '05/0721TCK'),
(57, 'testo', '1', '20000', 'Muhammad Bona Rizki', '2021-07-10 13:22:40', 'Muhammad Bona Rizki', '2021-07-10 13:22:40', NULL, NULL, '05/0721TCK');

-- --------------------------------------------------------

--
-- Table structure for table `trans_ticketing_header`
--

CREATE TABLE `trans_ticketing_header` (
  `ticket_id` varchar(10) NOT NULL,
  `type_id` int(11) NOT NULL,
  `priority_id` int(11) NOT NULL DEFAULT '1',
  `period_id` int(11) NOT NULL,
  `user_ticketing_request` varchar(10) NOT NULL,
  `ticket_status` enum('process','done','cancel','') NOT NULL DEFAULT 'process',
  `created_by` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` varchar(50) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_by` varchar(50) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trans_ticketing_header`
--

INSERT INTO `trans_ticketing_header` (`ticket_id`, `type_id`, `priority_id`, `period_id`, `user_ticketing_request`, `ticket_status`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`) VALUES
('01/0621TCK', 8, 1, 6, '76112008', 'cancel', 'Muhammad Bona Rizki', '2021-06-08 03:38:49', 'Muhammad Bona Rizki', '2021-07-12 03:56:40', NULL, NULL),
('02/0621TCK', 8, 1, 6, '76112008', 'process', 'Muhammad Bona Rizki', '2021-06-08 03:41:24', 'Muhammad Bona Rizki', '2021-07-12 03:36:15', NULL, NULL),
('03/0621TCK', 8, 1, 6, '76112008', 'process', 'Muhammad Bona Rizki', '2021-06-08 03:50:01', 'Muhammad Bona Rizki', '2021-07-12 03:36:12', NULL, NULL),
('04/0721TCK', 8, 1, 6, '76112008', 'process', 'Muhammad Bona Rizki', '2021-07-08 09:58:49', 'Muhammad Bona Rizki', '2021-07-11 16:22:29', NULL, NULL),
('05/0721TCK', 8, 1, 6, '76112008', 'process', 'Muhammad Bona Rizki', '2021-07-10 13:22:40', 'Muhammad Bona Rizki', '2021-07-11 16:22:37', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mst_ticketing_approval`
--
ALTER TABLE `mst_ticketing_approval`
  ADD PRIMARY KEY (`ticketing_approval_id`);

--
-- Indexes for table `mst_ticketing_approval_type`
--
ALTER TABLE `mst_ticketing_approval_type`
  ADD PRIMARY KEY (`approval_type_id`);

--
-- Indexes for table `mst_ticketing_menu_child`
--
ALTER TABLE `mst_ticketing_menu_child`
  ADD PRIMARY KEY (`menu_child_id`),
  ADD KEY `menu_parent_id` (`menu_parent_id`);

--
-- Indexes for table `mst_ticketing_menu_grand_child`
--
ALTER TABLE `mst_ticketing_menu_grand_child`
  ADD PRIMARY KEY (`menu_grand_child_id`),
  ADD KEY `menu_child_id` (`menu_child_id`);

--
-- Indexes for table `mst_ticketing_menu_parent`
--
ALTER TABLE `mst_ticketing_menu_parent`
  ADD PRIMARY KEY (`menu_parent_id`);

--
-- Indexes for table `mst_ticketing_priority`
--
ALTER TABLE `mst_ticketing_priority`
  ADD PRIMARY KEY (`priority_id`);

--
-- Indexes for table `mst_ticketing_type`
--
ALTER TABLE `mst_ticketing_type`
  ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `trans_ticket`
--
ALTER TABLE `trans_ticket`
  ADD PRIMARY KEY (`ticket_id`);

--
-- Indexes for table `trans_ticketing_detail_po`
--
ALTER TABLE `trans_ticketing_detail_po`
  ADD PRIMARY KEY (`detail_po_id`);

--
-- Indexes for table `trans_ticketing_header`
--
ALTER TABLE `trans_ticketing_header`
  ADD PRIMARY KEY (`ticket_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mst_ticketing_approval`
--
ALTER TABLE `mst_ticketing_approval`
  MODIFY `ticketing_approval_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `mst_ticketing_approval_type`
--
ALTER TABLE `mst_ticketing_approval_type`
  MODIFY `approval_type_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mst_ticketing_menu_child`
--
ALTER TABLE `mst_ticketing_menu_child`
  MODIFY `menu_child_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `mst_ticketing_menu_grand_child`
--
ALTER TABLE `mst_ticketing_menu_grand_child`
  MODIFY `menu_grand_child_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mst_ticketing_menu_parent`
--
ALTER TABLE `mst_ticketing_menu_parent`
  MODIFY `menu_parent_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `mst_ticketing_priority`
--
ALTER TABLE `mst_ticketing_priority`
  MODIFY `priority_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `mst_ticketing_type`
--
ALTER TABLE `mst_ticketing_type`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `trans_ticket`
--
ALTER TABLE `trans_ticket`
  MODIFY `ticket_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `trans_ticketing_detail_po`
--
ALTER TABLE `trans_ticketing_detail_po`
  MODIFY `detail_po_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `mst_ticketing_menu_child`
--
ALTER TABLE `mst_ticketing_menu_child`
  ADD CONSTRAINT `mst_ticketing_menu_child_ibfk_1` FOREIGN KEY (`menu_parent_id`) REFERENCES `mst_ticketing_menu_parent` (`menu_parent_id`);

--
-- Constraints for table `mst_ticketing_menu_grand_child`
--
ALTER TABLE `mst_ticketing_menu_grand_child`
  ADD CONSTRAINT `mst_ticketing_menu_grand_child_ibfk_1` FOREIGN KEY (`menu_child_id`) REFERENCES `mst_ticketing_menu_child` (`menu_child_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
