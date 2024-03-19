-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Mar 19, 2024 at 09:09 PM
-- Server version: 5.7.39
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nuuk_workspace`
--

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `name`, `startDate`, `endDate`) VALUES
(9, 'Client meeting 12:00', '2024-02-28', '2024-03-05'),
(17, 'Work trip to USA', '2024-03-22', '2024-03-25'),
(32, 'Board and manager meetings', '2024-02-07', '2024-02-11'),
(33, 'Holdays! Enjoy off work!', '2024-02-12', '2024-02-15'),
(34, 'Zoom Meeeting 15:30', '2024-03-08', '2024-03-09'),
(43, 'Check 1 days length event', '2024-02-26', '2024-02-27');

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `id` int(10) NOT NULL,
  `title` varchar(50) NOT NULL,
  `text` text NOT NULL,
  `file_path` text,
  `author` varchar(50) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`id`, `title`, `text`, `file_path`, `author`, `created`) VALUES
(14, 'Check File Section', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n\r\n\r\nSome links\r\nhttps://www.google.com\r\nhttps://www.bing.com\r\nhttps://www.yahoo.com\r\n', 'file_storage/Rock Paper Scissors.html_1710689942.html', 'Gvido Pelše', '2024-03-17 15:39:02'),
(15, 'Check', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n\r\n\r\n', 'file_storage/forma_testing.css_1710693850.css,file_storage/forma_valid.css_1710693850.css,file_storage/js_stils.css_1710693850.css', 'Gvido Pelše', '2024-03-17 16:44:10'),
(16, 'New Links update', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. In aliquam sem fringilla ut morbi. Porttitor rhoncus dolor purus non enim praesent elementum facilisis leo. Viverra adipiscing at in tellus integer. Tellus pellentesque eu tincidunt tortor aliquam. Ullamcorper a lacus vestibulum sed arcu non odio euismod. Convallis convallis tellus id interdum velit. Ac turpis egestas maecenas pharetra convallis posuere morbi leo urna. Enim lobortis scelerisque fermentum dui faucibus. Dui sapien eget mi proin sed libero. Aliquam ultrices sagittis orci a. Sit amet tellus cras adipiscing enim eu turpis egestas pretium.\r\n\r\nVestibulum lectus mauris ultrices eros in cursus. Turpis massa sed elementum tempus. Nulla aliquet porttitor lacus luctus accumsan tortor.\r\n\r\nhttps://loremipsum.io\r\n\r\n\r\n\r\n\r\n', 'file_storage/forma_testing.css_1710880262.css', 'Gvido Pelše', '2024-03-19 20:31:02');

-- --------------------------------------------------------

--
-- Table structure for table `news_feed`
--

CREATE TABLE `news_feed` (
  `id` int(10) NOT NULL,
  `title` varchar(200) NOT NULL,
  `author` varchar(50) NOT NULL,
  `content` text NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `news_feed`
--

INSERT INTO `news_feed` (`id`, `title`, `author`, `content`, `created`) VALUES
(9, 'This is News 3', 'Trilloux', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '2024-02-05 08:51:46'),
(11, 'New announcement', 'Trilloux', 'In a groundbreaking study conducted by leading digital marketing experts, the significance of backlink marketing in enhancing website rankings has been reaffirmed. The research, spanning over a year and encompassing a diverse range of industries, has shed light on the pivotal role that backlinks play in the digital landscape. \r\n\r\nBacklink marketing, the process of acquiring hyperlinks from other websites to your own, has long been recognized as a fundamental aspect of search engine optimization (SEO). However, this latest study delves deeper into the mechanisms behind backlinks and their impact on search engine algorithms. \r\n\r\nThe findings reveal that websites with a robust backlink profile consistently outperform their counterparts in search engine results pages (SERPs). Backlinks from authoritative and relevant sources not only contribute to higher rankings but also signify trust and credibility to search engines. This is also update', '2024-03-03 16:57:36'),
(12, 'News Check 1', 'Trilloux', 'Another strategy is outreach, where you proactively reach out to other website owners or bloggers in your industry and request them to link to your content. Personalized outreach emails and building relationships with influencers can help in securing valuable backlinks.\r\n\r\nAdditionally, participating in online communities, forums, and social media platforms can also help in building backlinks. By actively engaging with relevant communities and sharing your expertise, you can attract attention to your content and earn backlinks from community members.\r\n\r\nIt\'s important to note that building backlinks is a long-term process that requires patience, persistence, and continuous effort. While it may take time to see significant results, focusing on creating valuable content and building genuine relationships with other website owners will ultimately pay off in improving your site\'s SEO performance and driving organic traffic. ', '2024-03-14 19:03:31');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `profile_image` varchar(255) DEFAULT '',
  `role` varchar(10) NOT NULL COMMENT 'admin or user',
  `status` enum('online','offline') NOT NULL DEFAULT 'offline'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `firstName`, `lastName`, `email`, `phone`, `profile_image`, `role`, `status`) VALUES
(1, 'trilloux', 'converse19', 'Gvido', 'Pelše', 'gvido.pelse@gmail.com', '+37129388198', 'profile1.jpg', 'admin', 'online'),
(2, 'testuser', 'testuser123', 'John Brian', 'West Hamilton', 'west@gmail.com', '22334488', 'image1_0.jpg', 'user', 'online'),
(4, 'jackblack', 'jackblack123', 'Jack', 'Black', 'jack@yahoo.com', '22440011', '', 'user', 'offline'),
(7, 'userzero', 'userzero123', 'Thor', 'Andre', 'thorandre@inbox.lv', '22443322', 'Mid-life office 5488d927-1605-46b0-9575-bff124cb8abe.png', 'user', 'online'),
(8, 'userone1', 'userone1', 'Mike', 'Stewart', 'mike@yahoo.com', '22550011', '', 'user', 'offline');

-- --------------------------------------------------------

--
-- Table structure for table `user_1_inbox`
--

CREATE TABLE `user_1_inbox` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `context` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `file_path` varchar(255) DEFAULT NULL,
  `sent_by` varchar(50) NOT NULL,
  `mark` enum('read','not_read') NOT NULL DEFAULT 'not_read',
  `important` enum('yes','no') DEFAULT 'no',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_1_inbox`
--

INSERT INTO `user_1_inbox` (`id`, `title`, `context`, `file_path`, `sent_by`, `mark`, `important`, `created`) VALUES
(90, 'check symbols', 'chekš thi\'s you know you\'re a \"yeeeet\" ,  \'skrrrr\'. \r\n\r\nØ	Å', NULL, 'Gvido Pelše', 'read', 'no', '2024-03-14 18:52:40'),
(91, 'check overwrite', 'Rock papaah \r\n\r\n', 'msg_files/1710448965_Rock Paper Scissors.html', 'Gvido Pelše', 'not_read', 'yes', '2024-03-14 20:42:45');

-- --------------------------------------------------------

--
-- Table structure for table `user_1_outbox`
--

CREATE TABLE `user_1_outbox` (
  `id` int(11) NOT NULL,
  `sent_to` varchar(50) DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `context` text,
  `file_path` varchar(255) DEFAULT NULL,
  `sent_by` varchar(50) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_1_outbox`
--

INSERT INTO `user_1_outbox` (`id`, `sent_to`, `title`, `context`, `file_path`, `sent_by`, `created`) VALUES
(106, 'Gvido Pelše', 'check symbols', 'chekš thi\'s you know you\'re a \"yeeeet\" ,  \'skrrrr\'. \r\n\r\nØ	Å', NULL, 'Gvido Pelše', '2024-03-14 18:52:40'),
(107, 'Gvido Pelše', 'check overwrite', 'Rock papaah \r\n\r\n', 'msg_files/1710448965_Rock Paper Scissors.html', 'Gvido Pelše', '2024-03-14 20:42:45'),
(108, 'Jack Black', 'Rock papas', 'Scissors you', 'msg_files/1710449013_Rock Paper Scissors.html', 'Gvido Pelše', '2024-03-14 20:43:33'),
(109, 'Mike Stewart', 'Hey Mike, Jack', 'Some check message for you \r\n\r\nAnd some LINK \r\n\r\nhttps://www.hostinger.no\r\n\r\nAnd file \r\n\r\n', 'msg_files/1710881977_forma_testing.css', 'Gvido Pelše', '2024-03-19 20:59:37'),
(110, 'Jack Black', 'Hey Mike, Jack', 'Some check message for you \r\n\r\nAnd some LINK \r\n\r\nhttps://www.hostinger.no\r\n\r\nAnd file \r\n\r\n', 'msg_files/1710881977_forma_testing.css', 'Gvido Pelše', '2024-03-19 20:59:37');

-- --------------------------------------------------------

--
-- Table structure for table `user_1_tasks`
--

CREATE TABLE `user_1_tasks` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_by` varchar(50) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `title` varchar(50) NOT NULL,
  `description` text,
  `priority` enum('low','medium','high') DEFAULT 'medium',
  `status` enum('active','completed') DEFAULT 'active',
  `alert` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_1_tasks`
--

INSERT INTO `user_1_tasks` (`id`, `user_id`, `created_by`, `created`, `title`, `description`, `priority`, `status`, `alert`) VALUES
(4, 1, 'Gvido', '2024-02-07 08:40:04', 'Write to Client John Bern', 'Compose an email to Client John Bern providing a project development update. The email should include progress made on various aspects of the project, such as requirement analysis, prototyping, and initial codebase setup. Additionally, highlight any key milestones achieved and the teams commitment to delivering high-quality results within the allocated budget and timeline.\\r\\nThis it\\\'s is', 'low', 'active', '2024-02-11 12:25:00'),
(8, 1, 'Gvido', '2024-02-08 19:08:25', 'Check excel ', 'Please review the Excel document provided and ensure accuracy and completeness. Verify all data entries, formulas, and calculations for correctness. Additionally, cross-reference the information with any relevant sources or documentation to confirm its accuracy. If any discrepancies or errors are found, please document\'s them thoroughly and propose appropriate corrections or adjustments. These\'s it\'s.', 'low', 'active', '2024-03-06 23:18:00'),
(11, 1, 'Gvido', '2024-03-16 21:28:29', 'New Task', 'New task\r\n\r\nCheck out\r\n\r\nSymbols\'s it\'s', 'medium', 'completed', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_2_inbox`
--

CREATE TABLE `user_2_inbox` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `context` text,
  `file_path` varchar(255) DEFAULT NULL,
  `sent_by` varchar(50) NOT NULL,
  `mark` enum('read','not_read') DEFAULT 'not_read',
  `important` enum('yes','no') DEFAULT 'no',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_2_outbox`
--

CREATE TABLE `user_2_outbox` (
  `id` int(11) NOT NULL,
  `sent_to` varchar(50) DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `context` text,
  `file_path` varchar(255) DEFAULT NULL,
  `sent_by` varchar(50) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_2_tasks`
--

CREATE TABLE `user_2_tasks` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_by` varchar(50) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `title` varchar(50) NOT NULL,
  `description` text,
  `priority` enum('low','medium','high') DEFAULT 'medium',
  `status` enum('active','completed') DEFAULT 'active',
  `alert` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_2_tasks`
--

INSERT INTO `user_2_tasks` (`id`, `user_id`, `created_by`, `created`, `title`, `description`, `priority`, `status`, `alert`) VALUES
(7, 2, 'John Brian', '2024-03-10 18:53:41', 'Check online', 'Check online methods', 'low', 'active', '2024-03-10 19:55:00');

-- --------------------------------------------------------

--
-- Table structure for table `user_4_inbox`
--

CREATE TABLE `user_4_inbox` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `context` text,
  `file_path` varchar(255) DEFAULT NULL,
  `sent_by` varchar(50) NOT NULL,
  `mark` enum('read','not_read') DEFAULT 'not_read',
  `important` enum('yes','no') DEFAULT 'no',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_4_inbox`
--

INSERT INTO `user_4_inbox` (`id`, `title`, `context`, `file_path`, `sent_by`, `mark`, `important`, `created`) VALUES
(26, 'check da link', 'https://open.spotify.com\\r\\nthis one', NULL, 'Gvido Pelše', 'not_read', 'no', '2024-03-13 19:49:38'),
(27, 'jackio', 'wade\\r\\n\\r\\nhttps://open.spotify.com\\r\\nwadup yo', NULL, 'Gvido Pelše', 'not_read', 'no', '2024-03-13 19:55:36'),
(28, 'wasup', 'you Jackie\\r\\n\\r\\ncheck da link\\r\\n\\r\\nhttps://open.spotify.com\\r\\nthis one', NULL, 'Gvido Pelše', 'not_read', 'yes', '2024-03-13 20:00:27'),
(29, 'hey Jackie', 'check my link out \r\n\r\nthis one \r\n\r\nhttps://open.spotify.com\r\nlisten to Spotify\r\n\r\nhttps://open.spotify.com\r\nhttps://www.youtube.com\r\n', NULL, 'Gvido Pelše', 'not_read', 'no', '2024-03-13 20:12:50'),
(30, 'Rock papas', 'Scissors you', 'msg_files/1710449013_Rock Paper Scissors.html', 'Gvido Pelše', 'not_read', 'no', '2024-03-14 20:43:33'),
(31, 'Hey Mike, Jack', 'Some check message for you \r\n\r\nAnd some LINK \r\n\r\nhttps://www.hostinger.no\r\n\r\nAnd file \r\n\r\n', 'msg_files/1710881977_forma_testing.css', 'Gvido Pelše', 'read', 'no', '2024-03-19 20:59:37');

-- --------------------------------------------------------

--
-- Table structure for table `user_4_outbox`
--

CREATE TABLE `user_4_outbox` (
  `id` int(11) NOT NULL,
  `sent_to` varchar(50) DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `context` text,
  `file_path` varchar(255) DEFAULT NULL,
  `sent_by` varchar(50) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_4_outbox`
--

INSERT INTO `user_4_outbox` (`id`, `sent_to`, `title`, `context`, `file_path`, `sent_by`, `created`) VALUES
(13, 'Gvido Pelše', 'yo', 'https://open.spotify.com\\r\\nthis yo', NULL, 'Jack Black', '2024-03-13 19:35:30'),
(14, 'Gvido Pelše', 'what', 'https://open.spotify.com\\r\\nyolo this', NULL, 'Jack Black', '2024-03-13 19:45:37'),
(15, 'Gvido Pelše', 'RE: wasup', 'fuck yeah\\r\\n                ----------REPLY----------\\r\\n                Gvido Pelše<br>\\r\\n                you Jackie<br/><br/>check da link<br/><br/>https://open.spotify.com<br/>this one<br>\\r\\n                <br>\\r\\n            ', NULL, 'Jack Black', '2024-03-13 20:02:30');

-- --------------------------------------------------------

--
-- Table structure for table `user_4_tasks`
--

CREATE TABLE `user_4_tasks` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_by` varchar(50) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `title` varchar(50) NOT NULL,
  `description` text,
  `priority` enum('low','medium','high') DEFAULT 'medium',
  `status` enum('active','completed') DEFAULT 'active',
  `alert` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_4_tasks`
--

INSERT INTO `user_4_tasks` (`id`, `user_id`, `created_by`, `created`, `title`, `description`, `priority`, `status`, `alert`) VALUES
(1, 4, 'Gvido', '2024-02-14 18:41:48', 'Task for Jack', 'Hey this is taks for you, from admin panel. Created by admin to check if admin tasks works!', 'low', 'active', '2024-02-14 20:43:00'),
(2, 4, 'Gvido', '2024-02-15 17:08:26', 'Another Check', 'From the Admin', 'low', 'active', NULL),
(3, 4, 'Jack', '2024-03-06 22:30:28', 'Task not from admin', 'this is task not from admin\\r\\n\\r\\nWithout alert set on will not display in alerts\\r\\n\\r\\nIf task from admin , will display in alerts without alert set on', 'medium', 'active', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_7_tasks`
--

CREATE TABLE `user_7_tasks` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_by` varchar(50) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `title` varchar(50) NOT NULL,
  `description` text,
  `priority` enum('low','medium','high') DEFAULT 'medium',
  `status` enum('active','completed') DEFAULT 'active',
  `alert` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_8_inbox`
--

CREATE TABLE `user_8_inbox` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `context` text,
  `file_path` varchar(255) DEFAULT NULL,
  `sent_by` varchar(50) NOT NULL,
  `mark` enum('read','not_read') DEFAULT 'not_read',
  `important` enum('yes','no') DEFAULT 'no',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_8_inbox`
--

INSERT INTO `user_8_inbox` (`id`, `title`, `context`, `file_path`, `sent_by`, `mark`, `important`, `created`) VALUES
(1, 'Hey Mike, Jack', 'Some check message for you \r\n\r\nAnd some LINK \r\n\r\nhttps://www.hostinger.no\r\n\r\nAnd file \r\n\r\n', 'msg_files/1710881977_forma_testing.css', 'Gvido Pelše', 'not_read', 'no', '2024-03-19 20:59:37');

-- --------------------------------------------------------

--
-- Table structure for table `user_8_outbox`
--

CREATE TABLE `user_8_outbox` (
  `id` int(11) NOT NULL,
  `sent_to` varchar(50) DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `context` text,
  `file_path` varchar(255) DEFAULT NULL,
  `sent_by` varchar(50) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_8_tasks`
--

CREATE TABLE `user_8_tasks` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_by` varchar(50) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `title` varchar(50) NOT NULL,
  `description` text,
  `priority` enum('low','medium','high') DEFAULT 'medium',
  `status` enum('active','completed') DEFAULT 'active',
  `alert` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news_feed`
--
ALTER TABLE `news_feed`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_1_inbox`
--
ALTER TABLE `user_1_inbox`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_1_outbox`
--
ALTER TABLE `user_1_outbox`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_1_tasks`
--
ALTER TABLE `user_1_tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_2_inbox`
--
ALTER TABLE `user_2_inbox`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_2_outbox`
--
ALTER TABLE `user_2_outbox`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_2_tasks`
--
ALTER TABLE `user_2_tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_4_inbox`
--
ALTER TABLE `user_4_inbox`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_4_outbox`
--
ALTER TABLE `user_4_outbox`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_4_tasks`
--
ALTER TABLE `user_4_tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_7_tasks`
--
ALTER TABLE `user_7_tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_8_inbox`
--
ALTER TABLE `user_8_inbox`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_8_outbox`
--
ALTER TABLE `user_8_outbox`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_8_tasks`
--
ALTER TABLE `user_8_tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `news_feed`
--
ALTER TABLE `news_feed`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user_1_inbox`
--
ALTER TABLE `user_1_inbox`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `user_1_outbox`
--
ALTER TABLE `user_1_outbox`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `user_1_tasks`
--
ALTER TABLE `user_1_tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user_2_inbox`
--
ALTER TABLE `user_2_inbox`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_2_outbox`
--
ALTER TABLE `user_2_outbox`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_2_tasks`
--
ALTER TABLE `user_2_tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user_4_inbox`
--
ALTER TABLE `user_4_inbox`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `user_4_outbox`
--
ALTER TABLE `user_4_outbox`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `user_4_tasks`
--
ALTER TABLE `user_4_tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_7_tasks`
--
ALTER TABLE `user_7_tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_8_inbox`
--
ALTER TABLE `user_8_inbox`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_8_outbox`
--
ALTER TABLE `user_8_outbox`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_8_tasks`
--
ALTER TABLE `user_8_tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_1_tasks`
--
ALTER TABLE `user_1_tasks`
  ADD CONSTRAINT `user_1_tasks_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `user_2_tasks`
--
ALTER TABLE `user_2_tasks`
  ADD CONSTRAINT `user_2_tasks_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `user_4_tasks`
--
ALTER TABLE `user_4_tasks`
  ADD CONSTRAINT `user_4_tasks_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `user_7_tasks`
--
ALTER TABLE `user_7_tasks`
  ADD CONSTRAINT `user_7_tasks_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `user_8_tasks`
--
ALTER TABLE `user_8_tasks`
  ADD CONSTRAINT `user_8_tasks_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
