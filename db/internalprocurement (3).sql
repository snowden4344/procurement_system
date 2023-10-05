-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 06, 2023 at 12:59 AM
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
-- Database: `internalprocurement`
--

-- --------------------------------------------------------

--
-- Table structure for table `bidders`
--

CREATE TABLE `bidders` (
  `id` int(11) NOT NULL,
  `full_name` varchar(50) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `email` varchar(255) NOT NULL,
  `business_name` varchar(100) NOT NULL,
  `business_phone_number` varchar(15) NOT NULL,
  `business_email` varchar(255) NOT NULL,
  `tax_id` varchar(20) NOT NULL,
  `year_established` year(4) NOT NULL,
  `industry_type` varchar(50) NOT NULL,
  `business_type` varchar(50) NOT NULL,
  `bank_name` varchar(100) NOT NULL,
  `account_name` varchar(100) NOT NULL,
  `account_number` varchar(50) NOT NULL,
  `account_type` varchar(50) NOT NULL,
  `business_description` mediumtext NOT NULL,
  `business_address` varchar(255) NOT NULL,
  `b_username` varchar(8) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `is_verified` enum('Yes','No','Deleted') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bidders`
--

INSERT INTO `bidders` (`id`, `full_name`, `phone_number`, `email`, `business_name`, `business_phone_number`, `business_email`, `tax_id`, `year_established`, `industry_type`, `business_type`, `bank_name`, `account_name`, `account_number`, `account_type`, `business_description`, `business_address`, `b_username`, `password`, `is_verified`) VALUES
(4, 'Elon Musk', '778877889', 'elonmusk@tesla.co', 'Tesla', '0992277991', 'elonmusk@tesla.co', 'JJ882002', '1977', 'Technology', 'Corporation', 'FDH Bank', 'Elon Musk', '182222222222', 'current', 'We are him', 'We are located there', NULL, NULL, 'Deleted'),
(5, 'Limbani Kuweruza', '888825580', 'limbanikuweruza1@gmail.com', 'Kombeza', '0874899472', 'limbanikuweruza1@gmail.com', 'BB393849', '2021', 'Retail', 'Small Business', 'Nedbank Malawi', 'Limbani OG', '18273894738', 'savings', 'We sell kombeza at affordable prices', 'Hall 9 room 300', 'li8urwu5', '$2y$10$tZ3mgIEHBZO9JurFDJKFSej09lKbZs4TO1gTnPuxZOnOVmpgwFnny', 'Yes'),
(6, 'Sonwabile Siyathandana', '123648291', 'tamperproofnewsagency@gmail.com', 'Tamper Proof News Agency', '0123648291', 'tamperproofnewsagency@gmail.com', 'BIke93029', '2019', 'Healthcare', 'Small Business', 'Reserve Bank of Malawi', 'Sonwabile Siyathandana', '210000000078', 'current', 'We are him', 'We are here', '9a6aoe4n', '$2y$10$LSiufvthNqd.aWJLqTJFwe5aPWGBKi6bodfjmay5r3s2luT9ETfkC', 'Yes'),
(7, 'Joseph Dzanja', '887365579', 'joseph2003dzanja@gmail.com', 'JD Electronics', '0887365579', 'joseph2003dzanja@gmail.com', 'JS93893', '2019', 'Technology', 'Small Business', 'Reserve Bank of Malawi', 'Joseph Dzanja', '18293028374', 'current', 'We offer what you need', 'We are in Hall 9', 'i2z3d5g8', '$2y$10$kK2rpjMLOkPW5fcBZsc1vuucGI9AfBU/eCBrgEPf/Ij8TxGkWfkRa', 'Yes'),
(8, 'Khumbo Kaunda', '928367223', 'khumbokaunda18@gmail.com', 'Kaunda Stuff', '0928367223', 'khumbokaunda18@gmail.com', 'Hiaiai', '1978', 'Manufacturing', 'Startup', 'Reserve Bank of Malawi', 'Khumbo Kaunda', '1782738273782', 'current', 'Let there be light', 'Ayitu', 'i9mukaua', '$2y$10$zPz1Rmfk/V8WycMMGMEfOOvzRWu7ezVqPqTUs3B5CxDKmN3iNq9MO', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `contact_details`
--

CREATE TABLE `contact_details` (
  `contact_id` int(11) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `email` varchar(255) NOT NULL,
  `physical_address` varchar(255) NOT NULL,
  `company_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_details`
--

INSERT INTO `contact_details` (`contact_id`, `phone_number`, `email`, `physical_address`, `company_name`) VALUES
(1, '0982944937', 'tamperproofprocurementsystem@gmail.com', 'Ginger Alley, Private Bag 2023, Limbe', 'Tamper Proof Organization');

-- --------------------------------------------------------

--
-- Table structure for table `contract_awards`
--

CREATE TABLE `contract_awards` (
  `id` int(11) NOT NULL,
  `rfq_number` varchar(20) DEFAULT NULL,
  `quotation_id` int(11) DEFAULT NULL,
  `date_awarded` date DEFAULT NULL,
  `bidder_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contract_awards`
--

INSERT INTO `contract_awards` (`id`, `rfq_number`, `quotation_id`, `date_awarded`, `bidder_id`) VALUES
(8, 'RFQ-1', 6, '2023-10-05', 6),
(9, 'RFQ-12', 7, '2023-10-05', 6),
(10, 'RFQ-10', 9, '2023-10-05', 6),
(11, 'RFQ-18', 10, '2023-10-05', 7),
(12, 'RFQ-19', 11, '2023-10-06', 8);

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `department_name` varchar(45) NOT NULL,
  `department_budget` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `department_name`, `department_budget`) VALUES
(1, 'IT', 5000000.00),
(2, 'Human Resources', 6000000.00);

-- --------------------------------------------------------

--
-- Table structure for table `quotations`
--

CREATE TABLE `quotations` (
  `id` int(11) NOT NULL,
  `rfq_number` varchar(20) DEFAULT NULL,
  `bidder_id` int(11) DEFAULT NULL,
  `price_per_item` decimal(10,2) DEFAULT NULL,
  `price_per_unit` decimal(10,2) DEFAULT NULL,
  `date_created` date NOT NULL,
  `expected_delivery_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quotations`
--

INSERT INTO `quotations` (`id`, `rfq_number`, `bidder_id`, `price_per_item`, `price_per_unit`, `date_created`, `expected_delivery_date`) VALUES
(6, 'RFQ-1', 6, 5000.00, 4900.00, '2023-10-05', '2023-10-13'),
(7, 'RFQ-12', 6, 1000000.00, 900000.00, '2023-10-05', '2023-10-20'),
(8, 'RFQ-15', 6, 4000.00, 3900.00, '2023-10-05', '2023-10-12'),
(9, 'RFQ-10', 6, 50.00, 40.00, '2023-10-05', '2023-12-20'),
(10, 'RFQ-18', 7, 12000.00, 11000.00, '2023-10-05', '2023-10-11'),
(11, 'RFQ-19', 8, 500.00, 50.00, '2023-10-06', '2023-10-11');

-- --------------------------------------------------------

--
-- Table structure for table `request_for_quotations`
--

CREATE TABLE `request_for_quotations` (
  `rfq_number` varchar(20) NOT NULL,
  `rfq_title` varchar(45) NOT NULL,
  `requisition_id` int(11) NOT NULL,
  `date_generated` date NOT NULL,
  `deadline` date NOT NULL,
  `product_details` text NOT NULL,
  `preferred_language` varchar(40) NOT NULL,
  `quotes_validity` varchar(20) NOT NULL,
  `payment_terms` varchar(20) NOT NULL,
  `submission_methods` varchar(40) NOT NULL,
  `warranties` longtext NOT NULL,
  `evaluation_criteria` longtext NOT NULL,
  `terms_and_conditions` longtext NOT NULL,
  `release_of_payment_conditions` longtext NOT NULL,
  `status` enum('In Progress','Completed') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `request_for_quotations`
--

INSERT INTO `request_for_quotations` (`rfq_number`, `rfq_title`, `requisition_id`, `date_generated`, `deadline`, `product_details`, `preferred_language`, `quotes_validity`, `payment_terms`, `submission_methods`, `warranties`, `evaluation_criteria`, `terms_and_conditions`, `release_of_payment_conditions`, `status`) VALUES
('RFQ-1', 'jdsbfjsdf', 1, '2023-10-01', '2023-10-05', 'asnkanskanskn', 'english', '2023-10-13', 'net_30', 'System, Email, Mail', 'asjdjasdjas', 'sajhjahs', 'askhkasnks', 'saknkans', 'Completed'),
('RFQ-10', 'Request for quotations - Overwhelmed', 10, '2023-10-02', '2023-10-03', 'That nice song', 'english', '2023-11-05', 'net_90', 'System, Email, Mail', 'Song shall be returned if it is not likeable', 'Needs to have bass boost', 'Terms and conditions apply', 'The song should be lit first', 'Completed'),
('RFQ-12', 'Request for quotations - Laptops', 12, '2023-10-02', '2023-11-05', 'High spec HP laptop 500GB Ram', 'spanish', '2023-11-05', 'net_30', 'System, Email, Mail', 'Warranties', 'Criteria chani chani', 'Tcs and Cs', 'Release', 'Completed'),
('RFQ-13', 'Request for quotations - Fans', 13, '2023-10-02', '2023-10-06', 'Metal frame\r\n200V ac\r\nLong power chord\r\nTwo round pin plug\r\n1.2 meters height', 'english', '2023-10-31', 'net_90', 'System, Email, Mail', 'The fans shall be returnable if they are non functional', 'Quality\r\nPrice\r\nReputation', 'Read the public procurement act', 'The payment shall be released upon successful inspection of the product.', 'In Progress'),
('RFQ-14', 'Request for quotations - Fans', 14, '2023-10-02', '2023-10-04', 'specifications', 'english', '2023-10-19', 'net_60', 'System, Email, Mail', 'Warranties', 'Criteria', 'T and cs', 'Conditions', 'In Progress'),
('RFQ-15', 'Request for quotations - Stationary', 15, '2023-10-03', '2023-10-04', 'Hard cover books and bic pens', 'english', '2023-10-08', 'net_30', 'System, Email, Mail', 'Shall be returned if any of the items are torn', 'Quality, price, reputation', 'Terms and conditions apply', 'It should be good enough bro', 'In Progress'),
('RFQ-16', 'One two', 16, '2023-10-03', '2023-10-11', 'We danced the night away', 'english', '2023-10-05', 'net_30', 'System, Email, Mail', 'I met you in the darl', 'You lit me up', 'You made me feel as though', 'I was enough', 'In Progress'),
('RFQ-17', 'Request For Quotations - Trials', 17, '2023-10-05', '2023-10-06', 'Let us specify more', 'english', '2023-10-14', 'net_30', 'System, Email, Mail', 'Here are my warranties', 'I shall evaluate this', 'Which ones', 'Please bro, work', 'In Progress'),
('RFQ-18', 'Request for quotations - Headphones', 18, '2023-10-05', '2023-10-06', 'Specifics', 'english', '2023-10-06', 'net_30', 'System, Email, Mail', 'Warranty', 'Criteria', 'Hello veya', 'Conditions', 'Completed'),
('RFQ-19', 'Some thing new', 19, '2023-10-06', '2023-10-14', 'dsuhsd', 'english', '2023-10-13', 'net_30', 'System, Email, Mail', 'Here is the warranty', 'here ', 'yebp', 'More', 'Completed'),
('RFQ-2', 'hsnadkfm', 2, '2023-10-01', '2023-10-12', 'askkan', 'english', '', 'net_30', 'System, Email, Mail', 'askjkajs', 'asnkdnksan', 'aslajsljas', 'asknkans', 'In Progress'),
('RFQ-9', 'dosijosijf', 9, '2023-10-01', '2023-10-21', 'sdfsdf', 'english', '2023-10-05', 'net_30', 'Email, Mail', 'dsknlfsndlf', 'dslfnlsndfl', 'dsfnlsdf', 'sdfsdf', 'In Progress');

-- --------------------------------------------------------

--
-- Table structure for table `requisitions`
--

CREATE TABLE `requisitions` (
  `requisition_id` int(11) NOT NULL,
  `requisition_name` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `date_created` date DEFAULT NULL,
  `reason` text DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `document` blob DEFAULT NULL,
  `document_hashcode` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `requisitions`
--

INSERT INTO `requisitions` (`requisition_id`, `requisition_name`, `description`, `quantity`, `category`, `amount`, `status`, `date_created`, `reason`, `user_id`, `document`, `document_hashcode`) VALUES
(1, 'Hardware requisition', 'Testing', 3, 'Hardware', 1000.00, 'Initiated', '2023-10-01', 'Test more', 2, 0x7265717569736974696f6e732f7265717569736974696f6e5f313639363134363737332e706466, '0af3ae78e91641ec5cc88651ca94605c'),
(2, 'Hardware requisition', 'Test two', 3, 'Hardware', 1000.00, 'Initiated', '2023-10-01', 'Testing more', 2, 0x7265717569736974696f6e732f7265717569736974696f6e5f313639363134363837322e706466, '0ff817780172b3cd9c1df811ec8ec310'),
(8, 'Furniture requisition', 'Hello', 3, 'Furniture', 1100.00, 'Initiated', '2023-10-01', 'Its me', 2, 0x7265717569736974696f6e732f7265717569736974696f6e5f313639363135303938362e706466, 'd091e1dae0c608443d8563f00755530a'),
(9, 'Hardware requisition', 'Ndani', 3, 'Hardware', 1100.00, 'Initiated', '2023-10-01', 'Nsalu', 2, 0x2e2e2f7265717569736974696f6e732f7265717569736974696f6e5f313639363135363038342e706466, '55ccb20616d8345e0c93998d0b0bfcb1'),
(10, 'Hardware requisition', 'I get overwhelmed', 5, 'Hardware', 1006.00, 'Initiated', '2023-10-01', 'Creeps', 2, 0x2e2e2f7265717569736974696f6e732f7265717569736974696f6e5f313639363135363132372e706466, '09eb1346dda8f6b52fa527fc4da31da5'),
(11, 'Hardware requisition', 'See approval', 4, 'Hardware', 1000.00, 'Declined', '2023-10-02', 'Yela', 2, 0x2e2e2f7265717569736974696f6e732f7265717569736974696f6e5f313639363233373635312e706466, '73626f51020e550f87f6be0b8bd87055'),
(12, 'Electronics requisition', 'Laptops', 5, 'Electronics', 200000.00, 'Initiated', '2023-10-02', 'For printing and gaming', 2, 0x2e2e2f7265717569736974696f6e732f7265717569736974696f6e5f313639363235343038332e706466, '03dc851e265eb0489fce2260ac0d5dc3'),
(13, 'Appliances requisition', 'High powered fans', 5, 'Appliances', 100000.00, 'Initiated', '2023-10-02', 'The temperature in this office is just too high', 2, 0x2e2e2f7265717569736974696f6e732f7265717569736974696f6e5f313639363236323838352e706466, '35b1acb5964b5507539d3ab10c2ea1b8'),
(14, 'Hardware requisition', 'Fans', 2, 'Hardware', 60000.00, 'Initiated', '2023-10-02', 'Heat accumulation', 9, 0x2e2e2f7265717569736974696f6e732f7265717569736974696f6e5f313639363236363537322e706466, '78c14cacf425a6e5f0340e9baabbb15d'),
(15, 'Stationery requisition', 'In need of office writing equipment', 20, 'Stationery', 20000.00, 'Initiated', '2023-10-03', 'The books and pens available were stolen yesterday', 9, 0x2e2e2f7265717569736974696f6e732f7265717569736974696f6e5f313639363332323436352e706466, '14eede7d4b4de656e67524821a5349cd'),
(16, 'Hardware requisition', 'Hello', 1, 'Hardware', 2.00, 'Initiated', '2023-10-03', 'It\'s me', 9, 0x2e2e2f7265717569736974696f6e732f7265717569736974696f6e5f313639363332333434342e706466, 'bebf12d8cc0eb5cdcf040a4a92e466ed'),
(17, 'Hardware requisition', 'Lets start and finish this thing', 4, 'Hardware', 5000.00, 'Initiated', '2023-10-05', 'I honestly don\'t know why', 9, 0x2e2e2f7265717569736974696f6e732f7265717569736974696f6e5f313639363533383536382e706466, '12427ad99ca75d9552ea926365a9679a'),
(18, 'Hardware requisition', 'Headphones', 5, 'Hardware', 100000.00, 'Initiated', '2023-10-05', 'Sound imveke', 9, 0x2e2e2f7265717569736974696f6e732f7265717569736974696f6e5f313639363533393737312e706466, '6fe7912de2ba5663facf7af029fbe85c'),
(19, 'Hardware requisition', 'Don\'t ', 50, 'Hardware', 3000.00, 'Initiated', '2023-10-06', 'You run', 11, 0x2e2e2f7265717569736974696f6e732f7265717569736974696f6e5f313639363534333837352e706466, 'e5985df508f3cca98135364902e9b5ea');

-- --------------------------------------------------------

--
-- Table structure for table `stores`
--

CREATE TABLE `stores` (
  `store_id` int(11) NOT NULL,
  `location` varchar(45) NOT NULL,
  `Supplier` varchar(45) NOT NULL,
  `rfq_number` varchar(20) NOT NULL,
  `quantity` int(11) NOT NULL,
  `date_received` date NOT NULL,
  `date_delivered` date NOT NULL,
  `category` varchar(45) NOT NULL,
  `status` enum('Expected','Received') NOT NULL,
  `username` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(8) NOT NULL,
  `firstname` varchar(20) NOT NULL,
  `lastname` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(256) NOT NULL,
  `phone_number` int(11) NOT NULL,
  `date_created` date NOT NULL,
  `department` varchar(20) NOT NULL,
  `role` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `firstname`, `lastname`, `email`, `password`, `phone_number`, `date_created`, `department`, `role`) VALUES
(1, 'mK9da7m9', 'Khumbo', 'Kaunda', 'khumbokaunda18@gmail.com', '$2y$10$/U.Jx1rDGYgh1ks5ejlhL.RlBYVaw45GBV3rAUJcJN0CHX2viZN5G', 982944937, '2023-10-01', 'IT', 'Administrator'),
(2, 'cu4Ketua', 'Misheck', 'Kaunda', 'cis-026-19@must.ac.mw', '$2y$10$oKTWWUK7CUVu6satktM/MepsYya1xTmT1ozVKlhjGydtDZt04bevW', 887984119, '2023-10-01', 'Human Resources', 'User'),
(3, 'iBgln8r8', 'Cringe', 'Bro', 'cringebro4344@gmail.com', '$2y$10$PFdJAt33B3UwBmzSxMo7HeUUU.WDQmxaGGU8xCIWgtcgHX/l8ZFBe', 2147483647, '2023-10-01', 'Accounting', 'Approver'),
(4, 'c09oiogl', 'Tempo', 'Emo', 'tempoemo10@gmail.com', '$2y$10$qWTiL5wDWLsBjEY6xJ/7NuYhEodQsKq2iQvgiQBdMH5lX6PGFudsm', 999999999, '2023-10-01', 'Procurement', 'Procurement'),
(7, 'o3aac2j0', 'Joseph', 'Dzanja', 'bit-021-19@must.ac.mw', '$2y$10$8fbJGU17VQF9nc.2LBA8K.HqCp4P2dXZ4CXpB8sBbomiblc3KE8vu', 887365579, '2023-10-02', 'Stores', 'Stores'),
(9, 'm3gb9apr', 'Khumbo', 'Kaunda', 'randoprogrammer23@gmail.com', '$2y$10$./1YLygFtsqsylTIdcXM9e5J.zWsWN.w1WHigHiEX/s6K/ruFvWsm', 982944938, '2023-10-02', 'IT', 'User'),
(11, '2sa8gl30', 'Sonwabile', 'Siyathandana', 'tamperproofnewsagency@gmail.com', '$2y$10$mbNSAcO.TZyZ61q64kma1OBh9hMZPfEQwx3pIzX0stVawQLCVv/Jy', 328374832, '2023-10-06', 'IT', 'User');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bidders`
--
ALTER TABLE `bidders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_index` (`email`),
  ADD UNIQUE KEY `business_email_index` (`business_email`),
  ADD UNIQUE KEY `tax_id_index` (`tax_id`),
  ADD UNIQUE KEY `b_username_index` (`b_username`);

--
-- Indexes for table `contact_details`
--
ALTER TABLE `contact_details`
  ADD PRIMARY KEY (`contact_id`);

--
-- Indexes for table `contract_awards`
--
ALTER TABLE `contract_awards`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rfq_number_unique` (`rfq_number`),
  ADD KEY `quotation_id` (`quotation_id`),
  ADD KEY `bidder_id` (`bidder_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quotations`
--
ALTER TABLE `quotations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rfq_number` (`rfq_number`),
  ADD KEY `bidder_id` (`bidder_id`);

--
-- Indexes for table `request_for_quotations`
--
ALTER TABLE `request_for_quotations`
  ADD PRIMARY KEY (`rfq_number`),
  ADD KEY `requisition_id` (`requisition_id`);

--
-- Indexes for table `requisitions`
--
ALTER TABLE `requisitions`
  ADD PRIMARY KEY (`requisition_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `stores`
--
ALTER TABLE `stores`
  ADD PRIMARY KEY (`store_id`),
  ADD KEY `rfq_number` (`rfq_number`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_index` (`email`),
  ADD UNIQUE KEY `phonenumber_index` (`phone_number`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bidders`
--
ALTER TABLE `bidders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `contact_details`
--
ALTER TABLE `contact_details`
  MODIFY `contact_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contract_awards`
--
ALTER TABLE `contract_awards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `quotations`
--
ALTER TABLE `quotations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `requisitions`
--
ALTER TABLE `requisitions`
  MODIFY `requisition_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `stores`
--
ALTER TABLE `stores`
  MODIFY `store_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `contract_awards`
--
ALTER TABLE `contract_awards`
  ADD CONSTRAINT `contract_awards_ibfk_1` FOREIGN KEY (`rfq_number`) REFERENCES `request_for_quotations` (`rfq_number`),
  ADD CONSTRAINT `contract_awards_ibfk_2` FOREIGN KEY (`quotation_id`) REFERENCES `quotations` (`id`),
  ADD CONSTRAINT `contract_awards_ibfk_3` FOREIGN KEY (`bidder_id`) REFERENCES `bidders` (`id`);

--
-- Constraints for table `quotations`
--
ALTER TABLE `quotations`
  ADD CONSTRAINT `quotations_ibfk_1` FOREIGN KEY (`rfq_number`) REFERENCES `request_for_quotations` (`rfq_number`),
  ADD CONSTRAINT `quotations_ibfk_2` FOREIGN KEY (`bidder_id`) REFERENCES `bidders` (`id`);

--
-- Constraints for table `request_for_quotations`
--
ALTER TABLE `request_for_quotations`
  ADD CONSTRAINT `request_for_quotations_ibfk_1` FOREIGN KEY (`requisition_id`) REFERENCES `requisitions` (`requisition_id`);

--
-- Constraints for table `requisitions`
--
ALTER TABLE `requisitions`
  ADD CONSTRAINT `requisitions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stores`
--
ALTER TABLE `stores`
  ADD CONSTRAINT `stores_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`),
  ADD CONSTRAINT `stores_ibfk_2` FOREIGN KEY (`rfq_number`) REFERENCES `request_for_quotations` (`rfq_number`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
