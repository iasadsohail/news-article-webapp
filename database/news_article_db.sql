-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 26, 2020 at 06:29 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `news_article_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `a_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `a_title` text NOT NULL,
  `a_description` text NOT NULL,
  `a_timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `a_img_address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`a_id`, `user_id`, `cat_id`, `a_title`, `a_description`, `a_timestamp`, `a_img_address`) VALUES
(19, 1, 3, 'Some Article About News', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam sed faucibus ligula. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. In convallis ipsum ac ipsum vehicula dictum. Suspendisse laoreet orci eu turpis tincidunt, eget imperdiet felis sollicitudin. In eget hendrerit nulla. Curabitur finibus consequat risus sed facilisis. Quisque vel libero id metus dignissim feugiat non at magna. Curabitur eget tortor est. Morbi vel euismod lorem. Morbi maximus vel enim vel vestibulum. Morbi porta sed massa nec vulputate. Praesent mollis, ipsum id semper viverra, sem erat rhoncus augue, a vulputate quam mi eget nibh. Morbi vitae diam id leo convallis viverra nec eget mauris. In non velit nisl. Nulla quis nunc ex. Curabitur eu orci consequat, accumsan neque et, pellentesque turpis.\r\n\r\nSed finibus magna in mauris auctor hendrerit. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Vivamus viverra iaculis posuere. Etiam accumsan ipsum in porttitor blandit. Nunc vel diam ac quam rhoncus scelerisque eu vel nisi. Maecenas et malesuada eros. Nullam lacinia ultricies libero, vitae tempor quam vulputate ut.\r\n\r\nPraesent accumsan id magna vel posuere. Sed non congue lorem, at semper velit. Etiam sodales quam eu nulla mollis viverra. Pellentesque quis nibh ante. Pellentesque ultricies, orci sit amet scelerisque cursus, ante augue consequat tellus, bibendum volutpat mi est id leo. Cras eu dapibus massa. Aliquam consectetur nunc ac tristique imperdiet. Proin malesuada, eros ullamcorper interdum interdum, orci velit fringilla risus, vel venenatis dolor eros at nisi. In hac habitasse platea dictumst. Curabitur vitae nunc augue. Aliquam rutrum lectus quam, eget ultricies tellus suscipit consequat. Morbi elementum egestas elit. Suspendisse fringilla erat vel urna varius rhoncus. Mauris dignissim vulputate est id condimentum.\r\n\r\nPellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Mauris et nisi nec sem dignissim dapibus. Vestibulum et odio egestas ante bibendum ultricies. Vivamus maximus orci magna, at mattis lorem lacinia at. Donec venenatis lacinia felis, et aliquet ante sollicitudin a. Integer mattis efficitur nunc sed porttitor. Cras rhoncus viverra diam id pellentesque.\r\n\r\nEtiam vitae metus mattis, interdum quam scelerisque, porta dui. Nulla pretium sed ante in dignissim. Maecenas pretium purus blandit nisl varius dapibus. Nullam ullamcorper semper nisl eget elementum. Quisque ac maximus orci, in elementum urna. In elementum enim neque, vitae facilisis quam ullamcorper in. Proin at felis eros. Aenean efficitur sed arcu quis malesuada. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.', '2020-12-26 13:19:26', '1__5fe770998e388.png');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `cat_id` int(11) NOT NULL,
  `cat_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_name`) VALUES
(1, 'Business'),
(3, 'Technology'),
(6, 'Temporary 2');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `c_id` int(11) NOT NULL,
  `a_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `c_text` text NOT NULL,
  `c_timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`c_id`, `a_id`, `user_id`, `c_text`, `c_timestamp`) VALUES
(4, 19, 7, 'Hello, I hope you are doing fine. That is a very fine article. Thank You for the Lorem Ipsum.', '2020-12-26 13:28:38');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` text NOT NULL,
  `user_email` text NOT NULL,
  `user_password` text NOT NULL,
  `user_type` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `user_password`, `user_type`) VALUES
(1, 'Alpha', 'alpha@alpha.com', '41a3d23e04b4c8c17cf049d608295fdf', 'admin'),
(7, 'John Carter', 'johncarter@gmail.com', '3a50b17d43b3a45046c55ef90a8902d9', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`a_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `a_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
