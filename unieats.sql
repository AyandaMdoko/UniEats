-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 21, 2024 at 08:51 PM
-- Server version: 10.6.19-MariaDB
-- PHP Version: 8.3.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `unieatsc_unieats`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrators`
--

CREATE TABLE `administrators` (
  `Admin_id` int(11) NOT NULL,
  `Admin_Num` int(8) NOT NULL,
  `Name` varchar(30) NOT NULL,
  `Surname` varchar(30) NOT NULL,
  `Email_Add` varchar(40) NOT NULL,
  `Position` varchar(35) DEFAULT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `administrators`
--

INSERT INTO `administrators` (`Admin_id`, `Admin_Num`, `Name`, `Surname`, `Email_Add`, `Position`, `Password`) VALUES
(1, 38601990, 'Stanley', 'Mbhalati', 'stanley@gmail.com', 'Manager', '8cb2237d0679ca88db6464eac60da96345513964'),
(2, 43525172, 'Nathi', 'Mndawe', 'nathishaun44@gmail.com', 'staff member', '8cb2237d0679ca88db6464eac60da96345513964');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `Cart_id` int(11) NOT NULL,
  `User_id` int(100) NOT NULL,
  `pid` int(100) NOT NULL,
  `Item_Name` varchar(50) NOT NULL,
  `Item_Price` double NOT NULL,
  `Item_Quantity` int(100) NOT NULL,
  `Item_Image` varchar(100) NOT NULL,
  `Item_Description` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`Cart_id`, `User_id`, `pid`, `Item_Name`, `Item_Price`, `Item_Quantity`, `Item_Image`, `Item_Description`) VALUES
(158, 33, 37, 'Beef Stew', 28, 1, 'Beef Stew.jpg', 'A rich and hearty stew made with tender beef chunks, slow-cooked with a blend of fresh vegetables, beans, and savory spices. Served with a side of steamed rice, this comforting dish.'),
(159, 33, 36, 'Boerewors', 27, 1, 'af7110422d3b985e6a16e02521d179f4.jpg', ' Sausage (wors) grilled to perfection, served in a fresh roll with a hint of mustard and ketchup. A hearty and flavorful bite that&#39;s perfect for any time of the day.'),
(160, 33, 28, 'Fat Cake (With Mince & Cheese)', 29, 1, 'Vetkoek_ the easy, delicious recipe for a classic South African bread.jpeg', ' A warm, golden-brown fat cake stuffed with savory minced beef and melted cheese, perfect for a quick and satisfying bite.'),
(163, 36, 33, 'Sphatlho ', 35, 1, 'KOTA  SPHATLHO.jpg', ' A hearty South African sandwich loaded with fresh chips, juicy viennas, a succulent beef patty, crispy lettuce, eggs, all packed into a delicious roll for a filling and flavorful meal.'),
(164, 36, 27, 'Beef Hamburger', 60, 1, 'classical cheese burger.jpeg', ' A juicy grilled beef patty topped with fresh lettuce, tomato, pickles, and melted cheese, all served on a toasted sesame bun with a touch of ketchup and mayo'),
(191, 44, 31, 'Toasted Ham & Cheese Sandwich', 22, 3, 'ham and cheese sandwich.jpg', ' A classic combination of savory ham and melted cheese, toasted to golden perfection between slices of crispy bread. A deliciously warm and satisfying bite!'),
(193, 44, 34, 'fanta orange 2l', 27, 1, 'Fanta-Sparkling-Orange-.jpg', ' Brighten up your day with a 2-litre bottle of Fanta Orange. Bursting with a sweet and tangy citrus flavor, itï¿½s a favorite for every occasion.'),
(202, 46, 28, 'Fat Cake (With Mince & Cheese)', 29, 1, 'Vetkoek_ the easy, delicious recipe for a classic South African bread.jpeg', ' A warm, golden-brown fat cake stuffed with savory minced beef and melted cheese, perfect for a quick and satisfying bite.'),
(203, 42, 28, 'Fat Cake (With Mince & Cheese)', 29, 4, 'Vetkoek_ the easy, delicious recipe for a classic South African bread.jpeg', ' A warm, golden-brown fat cake stuffed with savory minced beef and melted cheese, perfect for a quick and satisfying bite.'),
(204, 42, 29, 'Fat Cake', 10, 1, 'Magwinya+Recipe.jpg', ' A soft and fluffy golden-brown fat cake, freshly fried to perfectionï¿½crispy on the outside, warm and tender on the inside. Perfect for a quick snack or as a side.'),
(210, 73, 33, 'Sphatlho ', 35, 1, 'KOTA  SPHATLHO.jpg', ' A hearty South African sandwich loaded with fresh chips, juicy viennas, a succulent beef patty, crispy lettuce, eggs, all packed into a delicious roll for a filling and flavorful meal.'),
(211, 73, 31, 'Toasted Ham & Cheese Sandwich', 22, 1, 'ham and cheese sandwich.jpg', ' A classic combination of savory ham and melted cheese, toasted to golden perfection between slices of crispy bread. A deliciously warm and satisfying bite!'),
(213, 29, 28, 'Fat Cake (With Mince & Cheese)', 29, 1, 'Vetkoek_ the easy, delicious recipe for a classic South African bread.jpeg', ' A warm, golden-brown fat cake stuffed with savory minced beef and melted cheese, perfect for a quick and satisfying bite.'),
(214, 29, 34, 'fanta orange 2l', 27, 1, 'Fanta-Sparkling-Orange-.jpg', ' Brighten up your day with a 2-litre bottle of Fanta Orange. Bursting with a sweet and tangy citrus flavor, itï¿½s a favorite for every occasion.'),
(227, 80, 33, 'Sphatlho ', 35, 1, 'KOTA  SPHATLHO.jpg', ' A hearty South African sandwich loaded with fresh chips, juicy viennas, a succulent beef patty, crispy lettuce, eggs, all packed into a delicious roll for a filling and flavorful meal.'),
(228, 80, 27, 'Beef Hamburger', 60, 1, 'classical cheese burger.jpeg', ' A juicy grilled beef patty topped with fresh lettuce, tomato, pickles, and melted cheese, all served on a toasted sesame bun with a touch of ketchup and mayo'),
(243, 69, 35, 'Hot Dog', 20, 1, 'hotDog.jpeg', ' A classic hot dog served in a soft bun, topped with your choice of sauces. Perfectly grilled for a juicy and satisfying bite every time.'),
(244, 69, 37, 'Beef Stew', 28, 1, 'Beef Stew.jpg', 'A rich and hearty stew made with tender beef chunks, slow-cooked with a blend of fresh vegetables, beans, and savory spices. Served with a side of steamed rice, this comforting dish.'),
(248, 105, 32, 'Coke 2l', 27, 2, 'Coca - Cola Classic  Soft Drink Bottle 2l _ Woolworths.jpeg', ' A refreshing 2-litre bottle of Coca-Cola, perfect for sharing. Enjoy the classic taste thatï¿½s both crisp and bubbly.'),
(338, 20, 27, 'Beef Hamburger', 65, 3, 'classical cheese burger.jpeg', ' A juicy grilled beef patty topped with fresh lettuce, tomato, pickles, and melted cheese, all served on a toasted sesame bun with a touch of ketchup and mayo'),
(339, 20, 30, 'Fresh Chips (Large)', 30, 2, 'Fresh chips.jpeg', ' Crispy, golden potato chips fried to perfection, lightly salted for a satisfying crunch with every bite. Perfect as a snack or side.'),
(344, 39, 33, 'Sphatlho ', 35, 2, 'KOTA  SPHATLHO.jpg', ' A hearty South African sandwich loaded with fresh chips, juicy viennas, a succulent beef patty, crispy lettuce, eggs, all packed into a delicious roll for a filling and flavorful meal.'),
(345, 40, 37, 'Beef Stew', 28, 1, 'Beef Stew.jpg', 'A rich and hearty stew made with tender beef chunks, slow-cooked with a blend of fresh vegetables, beans, and savory spices. Served with a side of steamed rice, this comforting dish.'),
(346, 40, 38, 'Samp', 10, 1, 'Samp_plain.jpg', ' Samp dish made from dried corn kernels, slowly cooked until tender. Enjoy its hearty texture as a comforting side or pair it with your favorite stew for a wholesome meal.'),
(347, 40, 32, 'Coke 2l', 27, 1, 'Coca - Cola Classic  Soft Drink Bottle 2l _ Woolworths.jpeg', ' A refreshing 2-litre bottle of Coca-Cola, perfect for sharing. Enjoy the classic taste thatï¿½s both crisp and bubbly.'),
(348, 41, 33, 'Sphatlho ', 35, 1, 'KOTA  SPHATLHO.jpg', ' A hearty South African sandwich loaded with fresh chips, juicy viennas, a succulent beef patty, crispy lettuce, eggs, all packed into a delicious roll for a filling and flavorful meal.'),
(349, 41, 37, 'Beef Stew', 28, 1, 'Beef Stew.jpg', 'A rich and hearty stew made with tender beef chunks, slow-cooked with a blend of fresh vegetables, beans, and savory spices. Served with a side of steamed rice, this comforting dish.'),
(350, 42, 32, 'Coke 2l', 27, 1, 'Coca - Cola Classic  Soft Drink Bottle 2l _ Woolworths.jpeg', ' A refreshing 2-litre bottle of Coca-Cola, perfect for sharing. Enjoy the classic taste thatï¿½s both crisp and bubbly.');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_admin`
--

CREATE TABLE `delivery_admin` (
  `del_id` int(11) NOT NULL,
  `Name` varchar(30) NOT NULL,
  `Surname` varchar(30) NOT NULL,
  `stu_Num` int(8) NOT NULL,
  `Email_Address` varchar(50) NOT NULL,
  `Cell_Number` varchar(15) NOT NULL,
  `Password_Hash` varchar(255) NOT NULL,
  `OTP_Hash` varchar(65) NOT NULL,
  `OTP_Expiry` datetime NOT NULL,
  `Reset_Token_Hash` varchar(64) NOT NULL,
  `Reset_Token_Expires_At` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `delivery_admin`
--

INSERT INTO `delivery_admin` (`del_id`, `Name`, `Surname`, `stu_Num`, `Email_Address`, `Cell_Number`, `Password_Hash`, `OTP_Hash`, `OTP_Expiry`, `Reset_Token_Hash`, `Reset_Token_Expires_At`) VALUES
(1, 'Stan', 'Mbhalati', 38601990, '38601990@mynwu.ac.za', '06978264254', '$2y$10$wEBmwQlcMPhDIYtP0CyyZ.tJur7zybeaEKo17V8.KDxoumoMdTkc.', 'f49c9ad163ab46bb1cb99c56cea9ba82415d0c8c6f749e1014fa5af410cab569', '2024-11-04 16:06:48', '', '0000-00-00 00:00:00'),
(2, 'OT', 'Motlhabane', 35649437, 'plannerg96@gmail.com', '0848716259', '$2y$10$wEcHipwXOYqRGm0HmlUMc.Pjo1v5wYFndmM857xqtiw5tPvs9mPbm', 'a2b0667fb4929d9a8671d33f51293bcb5579f66d6472e88ba2196a7cef173724', '2024-10-18 13:45:35', '', '0000-00-00 00:00:00'),
(3, 'Shaun', 'Mndawe', 43525172, '43525172@mynwu.ac.za', '0678367371', '$2y$10$jtoPy4OBTjJ5BWE5bWXpiuVr7O5LVqsvgTbxBiB2BacYgdihIAEN2', 'f948dd580e2a25d1bec23609821c89f31f90a240dcc7f27a48b89dad86e11eae', '2024-11-04 14:17:43', '', '0000-00-00 00:00:00'),
(4, 'Ayanda', 'Mdoko', 34934219, '34934219@mynwu.ac.za', '0635999488', '$2y$10$CaY0Kx92okoLvZp5nAtY4umR5QOx3gwaPcP6yN301MijnoRNbSnN2', '33a38135fa6e8f874c8b436eed396e5d0020e9ba43d4421d998e97bba68ce2df', '2024-11-13 10:42:10', '', '0000-00-00 00:00:00'),
(5, 'Panwell', 'zulu', 85959559, '85959559@mynwu.ac.za', '0713487523', '$2y$10$XgAaTzb4Pu.oiziz.xK8OeAB.UviZzXhEyIJcdTSCuflFjrvHDnaS', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `Item_id` int(11) NOT NULL,
  `Category` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Item_Name` varchar(50) NOT NULL,
  `Item_Price` double NOT NULL,
  `Item_Description` varchar(250) NOT NULL,
  `Item_Availability` int(100) DEFAULT NULL,
  `Item_Image` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`Item_id`, `Category`, `Item_Name`, `Item_Price`, `Item_Description`, `Item_Availability`, `Item_Image`) VALUES
(27, 'Baskets & Hamburgers', 'Beef Hamburger', 60, ' A juicy grilled beef patty topped with fresh lettuce, tomato, pickles, and melted cheese, all served on a toasted sesame bun with a touch of ketchup and mayo', NULL, 'classical cheese burger.jpeg'),
(28, 'Breakfast', 'Fat Cake (With Mince & Cheese)', 29, ' A warm, golden-brown fat cake stuffed with savory minced beef and melted cheese, perfect for a quick and satisfying bite.', NULL, 'Vetkoek_ the easy, delicious recipe for a classic South African bread.jpeg'),
(29, 'Breakfast', 'Fat Cake', 10, ' A soft and fluffy golden-brown fat cake, freshly fried to perfection—crispy on the outside, warm and tender on the inside. Perfect for a quick snack or as a side.', NULL, 'Magwinya+Recipe.jpg'),
(30, 'Baskets & Hamburgers', 'Fresh Chips (Large)', 30, ' Crispy, golden potato chips fried to perfection, lightly salted for a satisfying crunch with every bite. Perfect as a snack or side.', NULL, 'Fresh chips.jpeg'),
(31, 'Sandwiches & Spheltho', 'Toasted Ham & Cheese Sandwich', 22, ' A classic combination of savory ham and melted cheese, toasted to golden perfection between slices of crispy bread. A deliciously warm and satisfying bite!', NULL, 'ham and cheese sandwich.jpg'),
(32, 'Beverages', 'Coke 2l', 27, ' A refreshing 2-litre bottle of Coca-Cola, perfect for sharing. Enjoy the classic taste that’s both crisp and bubbly.', NULL, 'Coca - Cola Classic  Soft Drink Bottle 2l _ Woolworths.jpeg'),
(33, 'Sandwiches & Spheltho', 'Sphatlho ', 35, ' A hearty South African sandwich loaded with fresh chips, juicy viennas, a succulent beef patty, crispy lettuce, eggs, all packed into a delicious roll for a filling and flavorful meal.', NULL, 'KOTA  SPHATLHO.jpg'),
(34, 'Beverages', 'fanta orange 2l', 27, ' Brighten up your day with a 2-litre bottle of Fanta Orange. Bursting with a sweet and tangy citrus flavor, it&#039;s a favorite for every occasion.', NULL, 'Fanta-Sparkling-Orange-.jpg'),
(35, 'Rolls', 'Hot Dog', 20, ' A classic hot dog served in a soft bun, topped with your choice of sauces. Perfectly grilled for a juicy and satisfying bite every time.', NULL, 'hotDog.jpeg'),
(36, 'Rolls', 'Boerewors', 27, ' Sausage (wors) grilled to perfection, served in a fresh roll with a hint of mustard and ketchup. A hearty and flavorful bite that&#039;s perfect for any time of the day.', NULL, 'af7110422d3b985e6a16e02521d179f4.jpg'),
(37, 'Meal of Day', 'Beef Stew', 28, 'A rich and hearty stew made with tender beef chunks, slow-cooked with a blend of fresh vegetables, beans, and savory spices. Served with a side of steamed rice, this comforting dish.', NULL, 'Beef Stew.jpg'),
(38, 'Meal of Day', 'Samp', 10, ' Samp dish made from dried corn kernels, slowly cooked until tender. Enjoy its hearty texture as a comforting side or pair it with your favorite stew for a wholesome meal.', NULL, 'Samp_plain.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `Message_id` int(11) NOT NULL,
  `User_id` int(100) NOT NULL,
  `Name` varchar(30) NOT NULL,
  `Surname` varchar(30) NOT NULL,
  `Email_Add` varchar(50) NOT NULL,
  `Phone_Number` varchar(15) NOT NULL,
  `Message` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`Message_id`, `User_id`, `Name`, `Surname`, `Email_Add`, `Phone_Number`, `Message`) VALUES
(5, 0, 'mdu', '', '0645053035', '34679634@mynwu.', 'no complains the system is good bentwanabam. and the best part is otp for security reasons and 5 minutes otp duration. and i have no complains. well-done project x.'),
(6, 0, 'mdu.', '', '0645053035', '34679634@mynwu.', 'ðŸ”¥ðŸ”¥ðŸ”¥ðŸ”¥'),
(7, 0, 'Tshireletso', '', '0828128044', 'Tshirelaw@ymail', 'The system is good but i feel like you guys could have added more'),
(12, 0, 'Nonhlanhla', '', '1', 'nonhlanhlangwen', 'I appreciate the security of the system, especially its various verification steps and prompts. It is user-friendly and visually appealing. However, I have one complaint. I intended to order only one item from the menu, a sphatlo priced at R42, but was required to add another item because the total was below R50. As a result, I had to include a 2-litre Coke to meet the minimum order requirement. Additionally, after placing my order, I did not receive an email or pop-up notification confirming th'),
(13, 0, 'Samukelo ', '', '0737435198', 'samumngomezulu2', 'User-friendliness is compromised by the tedious aspect of having to use an OTP every I log in-it inconveniences me as a verified user. Additionally, having to manually enter the number of items for my order is inconvenient. A number picker or a similar feature would make this process more efficient. Everything else is in order. '),
(14, 0, 'OT Motlhabane', '', '0848716259', 'plannerg96@gmai', 'Simple design, and user friendly ordering system. \r\nSystem Navigation is great, as there are guidelines provided to easily navigate the system, and customer support is solid. \r\nThe system gets the job done'),
(15, 0, 'Stanley Tsundzuka', '', '0670992561', 'stanleymbhalati', 'The food is not good '),
(16, 0, 'Stan', '', '0670992561', 'stanleymbhalati', 'good service');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `User_id` int(100) NOT NULL,
  `del_id` int(11) NOT NULL,
  `Name` varchar(30) NOT NULL,
  `Surname` varchar(30) NOT NULL,
  `Phone_Number` varchar(15) NOT NULL,
  `Email_Add` varchar(40) NOT NULL,
  `Payment_Method` varchar(50) NOT NULL,
  `Ress_Add` varchar(50) NOT NULL,
  `Total_Products` varchar(100) NOT NULL,
  `Total_Price` double NOT NULL,
  `vat_amount` varchar(10) NOT NULL,
  `delivery_fee` double NOT NULL,
  `order_num` varchar(10) NOT NULL,
  `Placed_On` date NOT NULL DEFAULT current_timestamp(),
  `Delivery_Status` varchar(25) NOT NULL,
  `validate_status` varchar(50) NOT NULL,
  `claim_order` varchar(50) NOT NULL,
  `Accept_to_deliver` varchar(50) NOT NULL,
  `time_placed` time NOT NULL DEFAULT current_timestamp(),
  `Meal_customerization` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `User_id`, `del_id`, `Name`, `Surname`, `Phone_Number`, `Email_Add`, `Payment_Method`, `Ress_Add`, `Total_Products`, `Total_Price`, `vat_amount`, `delivery_fee`, `order_num`, `Placed_On`, `Delivery_Status`, `validate_status`, `claim_order`, `Accept_to_deliver`, `time_placed`, `Meal_customerization`) VALUES
(1, 29, 20, 'Google', 'Planner', '0848716259', 'plannerg96@gmail.com', 'Online Payment', 'Khayelitsha Residence', 'Beef Stew (28 x 1) - Hot Dog (20 x 1) - fanta orange 2l (27 x 2) - Fat Cake (10 x 1) - Boerewors (27', 209, '0', 10, '#ui603507', '2024-10-14', 'Out For Delivery', 'approved', 'Claimed', 'Accepted', '00:50:15', ''),
(2, 33, 20, 'Ayanda', 'Mdoko', '0635999489', 'mdokoayanda@gmail.com', 'Online Payment', 'James Moroka Residence', 'Beef Hamburger (60 x 1) - Frech Chips (Large) (30 x 1) - ', 100, '0', 10, '#ui666150', '2024-10-14', 'Out For Delivery', 'approved', '', 'Accepted', '07:47:39', ''),
(3, 35, 0, 'Nonhlanhla', 'Ngwenya', '0659308665', 'nonhlanhlangwenya18@gmail.com', 'Online Payment', 'Sedibeng Residence', 'Sphatlho  (35 x 1) - Coke 2l (27 x 1) - ', 72, '0', 10, '#ui749678', '2024-10-14', 'pending', 'approved', '', '', '08:57:17', ''),
(4, 32, 0, 'Ayanda', 'Mdoko', '0635999488', '34934219@mynwu.ac.za', 'Online Payment', 'James Moroka Residence', 'Fat Cake (With Mince & Cheese) (29 x 1) - Fat Cake (10 x 1) - Coke 2l (27 x 1) - ', 76, '0', 10, '#ui785694', '2024-10-14', 'pending', 'approved', '', '', '09:15:30', ''),
(5, 37, 0, 'Francis', 'Guambe', '0720951198', 'moabifrancis@gmail.com', 'Online Payment', 'Sedibeng Residence', 'Fat Cake (With Mince & Cheese) (29 x 1) - fanta orange 2l (27 x 1) - ', 66, '0', 10, '#ui646934', '2024-10-14', 'pending', 'approved', '', '', '10:00:57', ''),
(6, 32, 0, 'Ayanda', 'Mdoko', '0635999488', '34934219@mynwu.ac.za', 'Online Payment', 'James Moroka Residence', 'Beef Hamburger (60 x 1) - Beef Stew (28 x 1) - ', 98, '0', 10, '#ui937364', '2024-10-14', 'pending', 'approved', '', '', '10:44:50', ''),
(7, 38, 0, 'Tumelo', 'Ndwandwe', '0823618705', 'ndwandwetumelo@gmail.com', 'Online Payment', 'CLUSTER 11', 'Beef Hamburger (60 x 1) - ', 70, '0', 10, '#ui386817', '2024-10-14', 'pending', 'approved', '', '', '11:21:54', ''),
(8, 40, 0, 'Reatlegile', 'KHAREJANE', '0630031102', 'Reatlegilethabiso@gmail.com', 'Online Payment', 'CLUSTER 13', 'Toasted Ham & Cheese Sandwich (22 x 1) - Coke 2l (27 x 1) - ', 59, '0', 10, '#ui168730', '2024-10-14', 'pending', 'approved', '', '', '11:33:53', ''),
(9, 41, 0, 'Mpumelelo', 'Mkwanazi', '678950801', 'mpumelelomkwanazi91@gmail.com', 'Online Payment', 'CLUSTER 13', 'Sphatlho  (35 x 1) - Frech Chips (Large) (30 x 1) - ', 75, '0', 10, '#ui764095', '2024-10-14', 'pending', 'approved', '', '', '14:07:12', ''),
(10, 42, 0, 'Tshireletso', 'Moroke', '0828128044', 'Tshirelaw@ymail.com', 'Online Payment', 'A-2, Office: A2D-G25A', 'Fat Cake (With Mince & Cheese) (29 x 1) - Beef Hamburger (60 x 1) - Fat Cake (10 x 1) - Sphatlho  (3', 144, '0', 10, '#ui505234', '2024-10-14', 'pending', 'approved', '', '', '14:51:00', ''),
(11, 43, 0, 'mdu', 'kotelo', '0645053035', '34679634@mynwu.ac.za', 'Online Payment', 'Lost City Residence', 'Coke 2l (27 x 1) - Fat Cake (10 x 1) - Samp (10 x 1) - Beef Stew (28 x 1) - ', 85, '0', 10, '#ui492880', '2024-10-14', 'pending', 'approved', '', '', '16:47:11', ''),
(12, 43, 0, 'mdu', 'kotelo', '0645053035', '34679634@mynwu.ac.za', 'Online Payment', 'Lost City Residence', 'Boerewors (27 x 26) - Hot Dog (20 x 1) - Coke 2l (27 x 10) - fanta orange 2l (27 x 2) - ', 1056, '0', 10, '#ui014531', '2024-10-14', 'pending', 'approved', '', '', '16:57:00', 'no customerization.'),
(13, 37, 0, 'Francis', 'Guambe', '0720951198', 'moabifrancis@gmail.com', 'Online Payment', 'Sedibeng Residence', 'Toasted Ham & Cheese Sandwich (22 x 1) - Coke 2l (27 x 1) - fanta orange 2l (27 x 1) - ', 86, '0', 10, '#ui215687', '2024-10-14', 'pending', 'approved', '', '', '21:29:30', ''),
(14, 45, 0, 'Mihle', 'Bomvu', '0637041240', 'Bomvumihle@gmail.com', 'Online Payment', 'Lost City Residence', 'Beef Hamburger (60 x 1) - Frech Chips (Large) (30 x 1) - ', 100, '0', 10, '#ui550006', '2024-10-15', 'pending', 'approved', '', '', '12:30:48', ''),
(15, 37, 0, 'Francis', 'Guambe', '0720951198', 'moabifrancis@gmail.com', 'Online Payment', 'Sedibeng Residence', 'Toasted Ham & Cheese Sandwich (22 x 1) - Sphatlho  (35 x 1) - Coke 2l (27 x 1) - ', 94, '0', 10, '#ui897185', '2024-10-15', 'pending', 'approved', '', '', '13:01:31', ''),
(16, 30, 20, 'Stanley', 'Mbhalati', '0670992561', 'stanleymbhalati212@gmail.com', 'Online Payment', 'James Moroka Residence', 'Beef Hamburger (60 x 1) - Frech Chips (Large) (30 x 1) - ', 100, '0', 10, '#ui925102', '2024-10-18', 'pending', 'approved', '', '', '12:03:10', ''),
(17, 37, 0, 'Francis', 'Guambe', '0720951198', 'moabifrancis@gmail.com', 'Online Payment', 'Sedibeng Residence', 'Toasted Ham & Cheese Sandwich (22 x 1) - Coke 2l (27 x 1) - ', 59, '0', 10, '#ui968280', '2024-10-18', 'pending', 'approved', '', '', '13:59:45', ''),
(18, 76, 0, 'Alfredo', 'Ussaque', '0793790235', '0bongane1@gmail.com', 'Online Payment', 'Nelson Mandela Residence', 'Beef Stew (28 x 1) - Coke 2l (27 x 1) - ', 65, '0', 10, '#ui393806', '2024-10-19', 'pending', 'approved', '', '', '09:28:33', 'Not salt on my meal '),
(19, 83, 20, 'Confidence', 'Moeketsi', '0823850918', 'confidencemoeketsi62@gmail.com', 'Online Payment', 'Khayelitsha Residence', 'Frech Chips (Large) (30 x 1) - Coke 2l (27 x 1) - Fat Cake (10 x 4) - ', 107, '0', 10, '#ui755337', '2024-10-20', 'Out For Delivery', 'approved', '', 'Accepted', '16:10:38', ''),
(20, 84, 0, 'Ororiseng', 'Sephai', '0786755756', 'sephaiororiseng@gmail.com', 'Online Payment', 'Khayelitsha Residence', 'Beef Hamburger (60 x 1) - Toasted Ham & Cheese Sandwich (22 x 1) - ', 92, '0', 10, '#ui104448', '2024-10-20', 'pending', 'approved', '', '', '16:18:17', ''),
(21, 85, 0, 'Mpho', 'SEREME', '0647000603', 'mpho.sereme1234@gmail.com', 'Online Payment', 'Sedibeng Residence', 'Fat Cake (With Mince & Cheese) (29 x 2) - Sphatlho  (35 x 2) - ', 138, '0', 10, '#ui248354', '2024-10-21', 'pending', 'approved', '', '', '16:29:59', 'please remove tomatoes'),
(22, 32, 0, 'Ayanda', 'Mdoko', '0635999488', '34934219@mynwu.ac.za', 'Online Payment', 'James Moroka Residence', 'Sphatlho  (35 x 1) - Toasted Ham & Cheese Sandwich (22 x 1) - ', 67, '0', 10, '#ui351193', '2024-10-21', 'pending', 'approved', '', '', '18:11:48', ''),
(23, 69, 0, 'Nathi', 'Mndawe', '0713487523', 'nathishaun44@gmail.com', 'Online Payment', 'Postgrad Residence', 'Fat Cake (With Mince & Cheese) (29 x 5) - ', 155, '0', 10, '#ui813655', '2024-10-21', 'pending', 'approved', '', '', '18:31:53', ''),
(24, 86, 20, 'John', 'Doe', '0640346468', 'justjokesjohn@gmail.com', 'Online Payment', 'Khayelitsha Residence', 'Fat Cake (With Mince & Cheese) (29 x 5) - ', 155, '0', 10, '#ui608050', '2024-10-21', 'Completed', 'approved', 'Claimed', 'Accepted', '19:58:40', ''),
(25, 69, 0, 'Nathi', 'Mndawe', '0713487523', 'nathishaun44@gmail.com', 'Online Payment', 'Postgrad Residence', 'Toasted Ham & Cheese Sandwich (22 x 5) - ', 120, '0', 10, '#ui001277', '2024-10-22', 'pending', 'approved', '', '', '00:31:04', ''),
(26, 32, 0, 'Ayanda', 'Mdoko', '0635999488', '34934219@mynwu.ac.za', 'Online Payment', 'James Moroka Residence', 'Fresh Chips (Large) (30 x 1) - Beef Hamburger (60 x 1) - Coke 2l (27 x 1) - ', 127, '0', 10, '#ui519669', '2024-10-22', 'Out For Delivery', 'approved', '', '', '20:23:41', ''),
(27, 32, 0, 'Ayanda', 'Mdoko', '0635999488', '34934219@mynwu.ac.za', 'Online Payment', 'James Moroka Residence', 'Beef Stew (28 x 1) - fanta orange 2l (27 x 1) - ', 65, '0', 10, '#ui436572', '2024-10-29', '', 'approved', '', '', '19:54:13', ''),
(28, 30, 20, 'Stanley', 'Mbhalati', '0670992561', 'stanleymbhalati212@gmail.com', 'Online Payment', 'Great Hall', 'Coke 2l (27 x 1) - Fat Cake (With Mince & Cheese) (29 x 1) - ', 66, '0', 10, '#ui604767', '2024-10-30', 'Completed', 'approved', 'Claimed', 'Accepted', '13:38:16', ''),
(29, 30, 0, 'Stanley', 'Mbhalati', '0670992561', 'stanleymbhalati212@gmail.com', 'Online Payment', 'Great Hall', 'Fat Cake (With Mince & Cheese) (29 x 1) - Fresh Chips (Large) (30 x 1) - ', 69, '0', 10, '#ui756949', '2024-10-31', 'Out For Delivery', 'approved', '', '', '21:54:28', 'Remove the tomatoes '),
(30, 30, 20, 'Stanley', 'Mbhalati', '0670992561', 'stanleymbhalati212@gmail.com', 'Online Payment', 'Great Hall', 'Fat Cake (With Mince & Cheese) (29 x 4) - ', 126, '0', 10, '#ui575531', '2024-11-01', 'Completed', 'approved', '', 'Accepted', '13:27:40', ''),
(31, 30, 22, 'Stanley', 'Mbhalati', '0670992561', 'stanleymbhalati212@gmail.com', 'Online Payment', 'Nelson Mandela Residence', 'Coke 2l (27 x 1) - Beef Hamburger (60 x 1) - ', 97, '0', 10, '#ui482052', '2024-11-02', 'Completed', 'approved', '', 'Accepted', '14:26:19', ''),
(32, 30, 20, 'Stanley', 'Mbhalati', '0670978978', 'stanleymbhalati212@gmail.com', 'Online Payment', 'James Moroka Residence', 'Beef Hamburger (60 x 2) - Coke 2l (27 x 2) - ', 184, '0', 10, '#ui437591', '2024-11-02', 'Out For Delivery', 'approved', '', 'Accepted', '15:43:10', ''),
(33, 30, 20, 'Stanley', 'Mbhalati', '0670978896', 'stanleymbhalati212@gmail.com', 'Online Payment', 'MBADA Residence', 'Beef Hamburger (60 x 2) - Coke 2l (27 x 1) - ', 157, '0', 10, '#ui274704', '2024-11-02', 'Completed', 'approved', 'Claimed', 'Accepted', '15:48:12', ''),
(34, 30, 4, 'Stanley', 'Mbhalati', '0670978896', 'stanleymbhalati212@gmail.com', 'Online Payment', 'MBADA Residence', 'Coke 2l (27 x 1) - Hot Dog (20 x 1) - Beef Stew (28 x 1) - fanta orange 2l (27 x 1) - Boerewors (27 ', 139, '0', 10, '#ui670702', '2024-11-02', 'Out For Delivery', 'approved', '', 'Accepted', '21:44:53', 'remove tomatoes'),
(85, 4, 0, 'Ayanda', 'Mdoko', '0635999489', 'mdokoayanda@gmail.com', 'Online Payment', 'James Moroka Residence', 'Beef Hamburger (65 x 1) - fanta orange 2l (27 x 1) - ', 102, '0', 10, '#ui208987', '2024-11-03', 'Out For Delivery', 'approved', '', '', '20:51:23', ''),
(86, 4, 0, 'Ayanda', 'Mdoko', '0635999489', 'mdokoayanda@gmail.com', 'Online Payment', 'James Moroka Residence', 'Fat Cake (10 x 1) - Fresh Chips (Large) (30 x 1) - Toasted Ham & Cheese Sandwich (22 x 1) - ', 72, '0', 10, '#ui945628', '2024-11-03', 'Out For Delivery', 'approved', '', '', '21:04:51', ''),
(87, 2, 0, 'Stanley', 'Mbhalati', '0670978896', 'stanleymbhalati212@gmail.com', 'Online Payment', 'MBADA Residence', 'Fat Cake (With Mince & Cheese) (29 x 2) - Fat Cake (10 x 1) - ', 78, '0', 10, '#ui180677', '2024-11-04', 'Out For Delivery', 'approved', '', '', '01:54:02', ''),
(88, 20, 0, 'Sternan', 'VanNiekerk', '0721132673', 'sternan.vanniekerk@gmail.com', 'Online Payment', 'MBADA Residence', 'Beef Hamburger (65 x 1) - Coke 2l (27 x 1) - ', 102, '0', 10, '#ui357310', '2024-11-04', 'Out For Delivery', 'approved', '', '', '14:05:17', ''),
(89, 22, 3, 'Nathi', 'Mndawe', '0713487523', 'nathishaun44@gmail.com', 'Online Payment', 'Postgrad Residence', 'Fat Cake (With Mince & Cheese) (29 x 4) - ', 126, '0', 10, '#ui421525', '2024-11-04', 'Out For Delivery', 'approved', '', 'Accepted', '14:15:25', ''),
(90, 20, 0, 'Sternan', 'VanNiekerk', '0721132687', 'sternan.vanniekerk@gmail.com', 'Online Payment', 'MBADA Residence', 'Sphatlho  (35 x 2) - fanta orange 2l (27 x 1) - ', 107, '0', 10, '#ui564062', '2024-11-04', '', 'approved', '', '', '14:26:00', ''),
(91, 4, 0, 'Ayanda', 'Mdoko', '0635999489', 'mdokoayanda@gmail.com', 'Online Payment', 'James Moroka Residence', 'Beef Hamburger (65 x 1) - Coke 2l (27 x 1) - ', 102, '0', 10, '#ui937928', '2024-11-04', '', 'approved', '', '', '14:27:33', ''),
(92, 20, 0, 'Sternan', 'VanNiekerk', '0721132689', 'sternan.vanniekerk@gmail.com', 'Online Payment', 'The Stone', 'fanta orange 2l (27 x 2) - Beef Stew (28 x 1) - Samp (10 x 1) - ', 102, '0', 10, '#ui701096', '2024-11-04', '', 'approved', '', '', '14:36:43', ''),
(93, 38, 1, 'Nomisa', 'Mbhalati', '0697966456', 'meehlebomvu@gmail.com', 'Online Payment', 'Sedibeng Residence', 'Beef Hamburger (65 x 2) - Coke 2l (27 x 1) - ', 167, '0', 10, '#ui604528', '2024-11-04', 'Completed', 'approved', 'Claimed', 'Accepted', '15:58:20', ''),
(94, 2, 0, 'Stanley', 'Mbhalati', '0670978896', 'stanleymbhalati212@gmail.com', 'Online Payment', 'CLUSTER 13', 'Fresh Chips (Large) (30 x 1) - Beef Hamburger (60 x 1) - ', 100, '0', 10, '#ui434910', '2024-11-15', '', '', '', '', '13:28:40', 'remove tomatoes'),
(95, 4, 0, 'Ayanda', 'Mdoko', '0635999489', 'mdokoayanda@gmail.com', 'Online Payment', 'James Moroka Residence', 'Fat Cake (With Mince & Cheese) (29 x 1) - Coke 2l (27 x 1) - Toasted Ham & Cheese Sandwich (22 x 1) ', 98, '0', 10, '#ui878948', '2024-11-20', '', '', '', '', '14:14:08', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `User_Num` int(8) NOT NULL,
  `User_type` varchar(15) NOT NULL,
  `Name` varchar(30) NOT NULL,
  `Surname` varchar(30) NOT NULL,
  `Email_Add` varchar(50) NOT NULL,
  `Phone_Number` varchar(15) NOT NULL,
  `Ress_Add` varchar(60) NOT NULL,
  `Password_hash` varchar(255) NOT NULL,
  `OTP_hash` varchar(65) NOT NULL,
  `OTP_expiry` datetime NOT NULL,
  `Acc_activation_hash` varchar(64) NOT NULL,
  `Reset_token_hash` varchar(64) NOT NULL,
  `Reset_token_expires_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `User_Num`, `User_type`, `Name`, `Surname`, `Email_Add`, `Phone_Number`, `Ress_Add`, `Password_hash`, `OTP_hash`, `OTP_expiry`, `Acc_activation_hash`, `Reset_token_hash`, `Reset_token_expires_at`) VALUES
(1, 39422222, 'Student', 'Google', 'Planner', 'plannerg96@gmail.com', '0848716259', 'Khayelitsha Residence', '$2y$10$zaYv4rgfalmZGFKGLsmEGuFHnnWJho.m0QE6Cz.FlSXzjmpnyBgoS', '7fc4e8b387250a71c1965d2e8bd589d77f10e7109454d03503ee400fefd68462', '2024-10-18 13:53:22', '8a1a7fa1d2063f737a234ebd8ec69ea103bee2bf34cc7c4b3245026719d87763', '', '0000-00-00 00:00:00'),
(2, 38601990, 'Student', 'Stanley', 'Mbhalati', 'stanleymbhalati212@gmail.com', '0670978896', 'CLUSTER 13', '$2y$10$viWgY0tLAK4ZNCRLzbcJpOiyqDd/4g4oOaEgZdWUq1aJx80TkjZTu', 'f11523bebce3aa76d1a44cf9ce13523851107f84b75170f4fe27794abf8e4663', '2024-11-15 13:30:48', 'e4f7ae0ad74a6b16566ac9f0404b1b51c90fedc27a5ce08b72e7d257671862c7', '36860da1b544f2a92fbd7e519639b50dc4c0a8e65db37009f4861e542b9294b7', '2024-11-03 23:26:10'),
(3, 34934219, 'Student', 'Ayanda', 'Mdoko', '34934219@mynwu.ac.za', '0635999488', 'James Moroka Residence', '$2y$10$fgsNciIz0JLUOcINoSW/0OyJQUXE/5UvcwpItAVAuhT8pogKjmnTu', '6a167039d3198006b4f85fb241371cdbdcfd0ad5b71f302d3e0140aec00678fb', '2024-10-29 19:56:30', '', '', '0000-00-00 00:00:00'),
(4, 32565523, 'Staff', 'Ayanda', 'Mdoko', 'mdokoayanda@gmail.com', '0635999489', 'James Moroka Residence', '$2y$10$iyvjfTxrhaZTMQIgdu2IK.j6AgnC8mdaaq552Q3hxQZ9FqBqfbu5.', 'd96bb17771c1572c8a78e467fd6bbd821542851595f407f1b8a8980f942e7d69', '2024-11-20 14:17:28', '', '', '0000-00-00 00:00:00'),
(5, 32337798, 'Student', 'Tshwaranang', 'Modiga', 'Modigatshwaranang@gmail.com', '0672683517', '', '$2y$10$moSpDSAHlU6hu5Meu3PWnOzdcEhPdBfpzxr.ZGkZIZPBX9g/1r6AG', '', '0000-00-00 00:00:00', '4dea8479fc096b4bd14e9c72a48834223653639b245acceec0a2d45df6c75c4b', '', '0000-00-00 00:00:00'),
(6, 35176539, 'Visitor', 'Nonhlanhla', 'Ngwenya', 'nonhlanhlangwenya18@gmail.com', '0659308665', 'Sedibeng Residence', '$2y$10$6fnceZ/udG2rarcJJQc2zuFUUIepVR/YIdbc2fzusQmKPnZGAB606', '39656685303a57e34e065b18227db7981de8756ba2f7c355da8e3bf7e4bd67c8', '2024-11-02 12:06:08', '', '', '0000-00-00 00:00:00'),
(7, 39371808, 'Student', 'Samukelo', 'Sammy', 'samumngomezulu230@gmail.com', '0737435198', 'CLUSTER 11', '$2y$10$EKoVjL3Uul/zSf1YBc1jguWxW5ePsObyC81qMg9C4XkV9PfTj0W0u', '3be6ad9739339e1b55faac98286e477a5fd6944f065ea5c387fc0db1f8556678', '2024-10-18 13:33:38', '', '13f1e2724f3723b387cdc5210934af25dff2f3bcd8245c3a1f6d4e5f08efbd57', '2024-10-18 13:56:35'),
(8, 35796715, 'Student', 'Francis', 'Guambe', 'moabifrancis@gmail.com', '0720951198', 'Sedibeng Residence', '$2y$10$b7FjKD5INPTcAKLT9NeLXevnaHGXdl2FmXP0cYxuFb.RCThq.Uwk2', '8e6d5c4af546ef26597ac3a0cf934fbd203db264a1a057e1df9371ecca71eee6', '2024-10-18 13:53:08', '', '62a4b235b9682ceee4ae365137d5d43a124657f855dce710b08f72ac87025782', '2024-10-20 14:52:33'),
(9, 39525090, 'Student', 'Tumelo', 'Ndwandwe', 'ndwandwetumelo@gmail.com', '0823618705', 'CLUSTER 11', '$2y$10$3KfrRw7SwRpYnfQ/5n7f/uUKIZT2kYElMFdOBUeTbFMXnCYp/VVBS', '42cfac3412efa46b44861be587b7f2e606f1080776f91165fbf18005874e78b5', '2024-10-14 11:15:17', '', '', '0000-00-00 00:00:00'),
(10, 35814098, 'Student', 'Reatlegile', 'KHAREJANE', 'Reatlegilethabiso@gmail.com', '0630031102', 'CLUSTER 13', '$2y$10$Ljm3iG/0/L3pXBcdj3r6PO46TBnaDx8iauvpAg8cgRf/tbU/5oaI2', 'dc6d229a7e400ab9a38913fbd13a10a20093e3a18067e3b1bbc0f0cb905e73fe', '2024-10-14 11:34:37', 'efaee2c21d16c41a8111534d0963bdd477220012dc7ed278e57282af92aa0110', '', '0000-00-00 00:00:00'),
(11, 12345678, 'Student', 'Mpumelelo', 'Mkwanazi', 'mpumelelomkwanazi91@gmail.com', '678950801', 'CLUSTER 13', '$2y$10$GsGCWNOmOPTbIU4BVOBZ1eLUlhXM2p4zD6A4C7vsMMQlIzV5l9y0O', '615b4735527e7962d656048100c12defff47c82281d61a5327c44b16fe9336b2', '2024-10-14 14:09:23', '', '', '0000-00-00 00:00:00'),
(12, 23127988, 'Staff', 'Tshireletso', 'Moroke', 'Tshirelaw@ymail.com', '0828128044', 'A-2, Office: A2D-G25A', '$2y$10$fFg3DifHTLYCnpt./C3OSufnqIlqCHcW7NfQBpEVOdp3wb9JI7cZa', '3c2b8e79b214b570e23645c8992d7d542fb6f98c2ce6b913d89028ef0c85cbae', '2024-10-15 14:17:16', '', '', '0000-00-00 00:00:00'),
(13, 45679645, 'Student', 'mdu', 'kotelo', '34679634@mynwu.ac.za', '0645053035', 'Lost City Residence', '$2y$10$q0R5fLZfPFYUlZ3AeZ3r7eL85R31pAI98ZKltaLCFYAkh.tnDK3Zy', '0a3e66353d0459bbe9b688446c8cd5dcf68bdd0e69e54596cd01aea0d5452ef0', '2024-10-14 17:33:14', '', '', '0000-00-00 00:00:00'),
(14, 37820982, 'Student', 'Reabetsoe', 'Malatjie', '37820982@mynwu.ac.za', '0625830549', 'library', '$2y$10$BPpIRKWvGZdOCjcuCmxfU.wuRh1vyL4FZNewqds8R1MYu99fmE.ia', '92106eb9f6c9358a253233cfdca3a8581aaa3d978f599d6be1b0dc53334ec800', '2024-10-18 12:24:19', '', '', '0000-00-00 00:00:00'),
(15, 42298318, 'Student', 'Mihle', 'Bomvu', 'Bomvumihle@gmail.com', '0637041240', 'Lost City Residence', '$2y$10$X6pzzstA3zyZaZZML2iU1.4WHNMHRO982Khxe0VeeGp1OcnJF9fTm', '0b4f450c3a04a7d1496efbce882dc47becb0ee8c17954a623b8ca4b48b2516c8', '2024-10-15 12:33:17', '', '', '0000-00-00 00:00:00'),
(16, 37256122, 'Student', 'Phemelo', 'Meleloe', 'meleloeroyalty@gmail.com', '0724726155', '', '$2y$10$xj3uZcKeae79t8bZRTyyGOfZLj.QFPcOfbQxIJIKdOl.0WbkEIr7C', '221f4833a0360de8f2617af236de6d6ae5a9fae3a3934e6b4a4dddbc0b13c940', '2024-10-18 10:47:25', '', '', '0000-00-00 00:00:00'),
(17, 12350858, 'Staff', 'Thamie', 'Ndlovu', 'Thamie.Ndlovu@nwu.ac.za', '0822140610', '', '$2y$10$PJvgjhKGZyDObyN4LDhRa.mGfsUJeoau6WSIQQqOWpLItOrf019d6', '', '0000-00-00 00:00:00', '', '', '0000-00-00 00:00:00'),
(18, 37256122, 'Student', 'Tumelo', 'Meleloe', '37256122@mynwu.ac.za', '0781184924', '', '$2y$10$KxE3FziATpzYEHA5x1y1LOPnkLmNoNyGGCHD1U9lFqX6Zh4kElL2u', '89155a46a43146942bedbfed2f0d657421dcd3675a784757183d32854a8bd43d', '2024-10-20 14:29:37', '', '', '0000-00-00 00:00:00'),
(19, 38601990, 'Student', 'Stan', 'Mbhalati', '38601990@mynwu.ac.za', '0892637373', '', '$2y$10$JHnY6s.PPw78AdSMYM.cH./dfb4REIVzYKn0KcSAfAhh1iznVE0/q', '4d8c9c8b4ce9d9651788faceee4f567223e1c901835d7080b2b26e44d914e282', '2024-10-18 10:57:39', '', '', '0000-00-00 00:00:00'),
(20, 39980286, 'Student', 'Sternan', 'VanNiekerk', 'sternan.vanniekerk@gmail.com', '0721132645', 'Postgrad Residence', '$2y$10$/knBUPcFbvc5I9tviTk96ubqHW93F4UKrERil9B1XYhYaiRMRxlLq', '049fac50a6fed75097bc0a7b339e32fa71fd67c6cdb24b677eea1957bc499ebe', '2024-11-04 14:00:49', '', '', '0000-00-00 00:00:00'),
(21, 35456465, 'Visitor', 'Panwel', 'Mdoko', 'ayandamdoko665@gmai.com', '0635888928', '', '$2y$10$mtS5/AFgdelz1OD0l9cht.uMUkxV.kqYTd0tXQoFqFr3wEiCySpSW', '336b6d58ffc5e11e12fe70853542cda024ff4f7c433b706408031830f2e62e48', '2024-10-18 11:24:42', 'b11d87da76cdff26d952114b61b2e47b3ca84955eb07b66aac74fbd897f32f70', '', '0000-00-00 00:00:00'),
(22, 43525172, 'Student', 'Nathi', 'Mndawe', 'nathishaun44@gmail.com', '0713487523', 'Postgrad Residence', '$2y$10$W68F.xnlR9PpTEqaHJakIOKvuPevJq4eRX8ZHNMkvLQl/8/7INR2q', '01ba68e0874acd60ebdf2b134f72322c5f7b1c0319bc38a43b72d8961b3d9578', '2024-11-04 14:09:43', '', 'bf0f64ae15afaaf5f10dde55e9352d88b00061b1ad3e9f48481fdddff2117ad4', '2024-11-02 14:01:29'),
(23, 36611670, 'Student', 'Reitumetse', 'Melelwe', 'reitumetseroyalty@gmail.com', '0742186549', 'Sedibeng Residence', '$2y$10$i9pHEJzmLnlyH1D.0g4G7e50/Y4nIgYYU.i/s5KhOySDaWrrUDThu', '7a58eca04e435cb83dae3509aa05d5965b9b32eaa9af3f248007739a05cd9803', '2024-10-18 12:27:13', '8f80f6f2ff8384ac589d09936147dd56183c7023a86c2adb9d03ef64b46fb9c4', '', '0000-00-00 00:00:00'),
(24, 214605775, 'Visitor', 'Boipelo', 'Meleloe', 'bjmeleloe@gmail.com', '0763161072', '', '$2y$10$hT/cRzkeJu03s0SV7gY7jezkQh847l0gM9g2lDAP1Ww0rc.NUOVeC', '9e64eb7b1b50a873d8eaef4b583c8ba9bc2692e7df0035bc820e63ec0c94e8a2', '2024-10-18 13:00:23', 'eab7967c2eb712758b032d7c2cb0745bd845bd86080459bf6c171c753890fd00', '', '0000-00-00 00:00:00'),
(25, 43622720, 'Student', 'Linomtha', 'Penxa', 'linomthapenxa@gmail.com', '0608242231', '', '$2y$10$DeOe2X/P4shAu4ReIbM/r..sj5OillRUNhFXg/4YJMU/wuOsG3C4a', '', '0000-00-00 00:00:00', '5cff300903056b1a162b5cc00215e97ec06d72a8171ac4219c2c8e7202445d08', '', '0000-00-00 00:00:00'),
(26, 41003532, 'Visitor', 'Alfredo', 'Ussaque', '0bongane1@gmail.com', '0793790235', 'Nelson Mandela Residence', '$2y$10$5gew/lsmVs.vptkAhO0JkuPIbuVvrxQcPDLTLJoIdC6g7Ty2r1k2G', 'd6b0d90dae11bcf9b07c89b6d0864a543d43f03af6726c6702b55aa2524c52dd', '2024-10-19 09:08:51', '', '', '0000-00-00 00:00:00'),
(27, 37256122, 'Student', 'Nkosinathi', 'Mndawe', 'motlatsimagadlagmail.com', '0785425130', '', '$2y$10$IFU5BnT2MaEgTx4fC/gzyux4wheptf9cFVRCtqRUH6S3Lt3/N0KBi', '', '0000-00-00 00:00:00', '8ead7db23c55f91dcaeb39bf7256d1d0a535ab223620c780ce4567da47e376d7', '', '0000-00-00 00:00:00'),
(28, 38601985, 'Student', 'Zuka', 'Mbhalati', 'zukambhalati212@gmail.com', '0678367371', '', '$2y$10$nvBQTbSq4J04dTZKSnlOmOpmlS2.HQYF.Pijw6G8xHOxSXyC5YIgK', '7cd9357d24b560e64441631b3575b065a58c93b7ee4572cb12524740bfcd3dca', '2024-10-20 14:00:59', '2b9ee52a67ecf40228569650770f7cabf8a11a35cd9bf6660d39c9b595acf964', '', '0000-00-00 00:00:00'),
(29, 27690997, 'Student', 'Potso', 'Mokgaola', 'Mkglpts@gmail.com', '0813471028', 'Khayelitsha Residence', '$2y$10$noAB3RXbN4vFTyylbPYzveMxfY7hktn3TnQDAikDeOaUsOgkz0zLu', '096366c850594d3fae1466ef2355eb28a7296b6fa70cc89d80282857df4f08a6', '2024-10-20 15:57:16', '', '', '0000-00-00 00:00:00'),
(30, 33648808, 'Student', 'Shaun', 'Mmelegedi', 'onkgomoditsesaun@gmail.com', '0635708061', '', '$2y$10$VysUOGxhWfB0a/PG26enS.emC29jLEtQfFRHZ1mpZ6tTCsfuAMDoe', 'de9cd890200e7a431fd92ff2b0d841a9ce6d512417ea3a884bac477c0eefa056', '2024-10-20 15:53:16', 'f569c4c34c079a7b77e8c5474c39377e4a98636a4412e522c397f1cc8a227729', '', '0000-00-00 00:00:00'),
(31, 40242552, 'Student', 'Calphonia', 'Motlogedi', 'lehlogolomotlogedi@gmail.com', '0793055064', '', '$2y$10$jUJs6XetjKJ4qoZmjTH4DeA1Sg/l9Ahj9Q2hklagiMI35g4t2x53K', '', '0000-00-00 00:00:00', '', '', '0000-00-00 00:00:00'),
(32, 38638614, 'Student', 'Confidence', 'Moeketsi', 'confidencemoeketsi62@gmail.com', '0823850918', 'Khayelitsha Residence', '$2y$10$lTLwPcYptJGPmzKFS31V9ew.Kzd.w/H2bWzuAYzta3GxMEkwwJ33m', '8c9529987e91a70108b68fff1a1778cd3bc8b9aaf8fb5f4e2359b1acabd4a067', '2024-10-20 16:09:48', '', '', '0000-00-00 00:00:00'),
(33, 35650079, 'Student', 'Ororiseng', 'Sephai', 'sephaiororiseng@gmail.com', '0786755756', 'Khayelitsha Residence', '$2y$10$a.Gl0DzqG.WwS9JcpIisbOf3lKH7pq7s.jseqP8YUXQ6wcjufE7da', '8e2c8ec599e12975adea0dbac6e34f65f047b9fe690431aa57e0cc89358a710c', '2024-10-20 16:18:34', '', '', '0000-00-00 00:00:00'),
(34, 10, 'Visitor', 'Mpho', 'SEREME', 'mpho.sereme1234@gmail.com', '0647000603', 'library', '$2y$10$Njt3FDW4ofrIdDtSAW8T2.Izs77C9hHITY64LWQ.q2yN1vTIPnV1y', '20c965832fede99e0d8ee58fcc51a9d3c30617b008a48b03f0e23560a9b5695b', '2024-10-21 16:29:20', 'c7822a4ca7680462f074316f7e82e859fbe2ab8fbd3118b1776e40af40e4949f', '', '0000-00-00 00:00:00'),
(35, 54689878, 'Student', 'John', 'Doe', 'justjokesjohn@gmail.com', '0640346468', 'Khayelitsha Residence', '$2y$10$7CkUEueTvK.G3QN/KLmoZu2p7ccZQm6s3ZiBzPlaei.KtBoj2rIEW', 'cf704f0e3e3892afba5d1504fc603d0de7bea18a8a8abdf875b900ba75e30bb2', '2024-10-21 19:58:21', '', '', '0000-00-00 00:00:00'),
(36, 43525172, 'Staff', 'Nkosinathi', 'Mndawe', 's219942706@mandela.ac.za', '067', '', '$2y$10$AYte9ehmO.MeqIhRwxrCuuBaaEI4haTHNh9NYlnVoPJn/2yuHqZXC', '', '0000-00-00 00:00:00', '5e90dfc7c59b5d70272fd11116d40a00aa938d5d043223a1b46fbd3fdc4c172a', '', '0000-00-00 00:00:00'),
(37, 51893738, 'Student', 'Katlego', 'Baabua', 'baabuakatlegopc@gmail.com', '0762013529', 'CLUSTER 8', '$2y$10$qopDUW4KYz.OQiE6iGYNq.9N8lClLhsbegdqxCJggDJC3DNbzraZ6', '8ab2744239278a40b4e4b3ad6ec76c5f629976fc0cd7216888101cb107baea6b', '2024-10-25 16:42:04', '1279e496b0baef3d1c1239c7532f015b69972e2e322cf6594128e9a424d77f7e', '', '0000-00-00 00:00:00'),
(38, 69646646, 'Student', 'Nomisa', 'Mbhalati', 'meehlebomvu@gmail.com', '0697966456', 'Sedibeng Residence', '$2y$10$fSkfEwDT2beSmOdp1dj9nO97C/TxKkOrCr4Hy6JEFYIndPNKVHCUy', '3f02a9167d91d128178487d8ea72072eca0f99d7c1bb2a06b8e156469136eef7', '2024-11-04 15:58:45', '', '', '0000-00-00 00:00:00'),
(39, 3338483, 'Staff', 'Lucas', 'khoza', 'Khozalt@gmail.com', '0767453646', '', '$2y$10$bo/.8DFvANMwZqiLkpzPi.89iJfhGXQTHb/yb0XNGMbE5XRMerof2', 'd5e2425eaea519e47a11062ee39887a8460504da05d329808a085015a8eb42a8', '2024-11-04 16:09:00', 'ea7efe443a1dd96fba899ccc00709ce823c146b563de40894762f29427af71b9', '', '0000-00-00 00:00:00'),
(40, 56546465, 'Visitor', 'Precious', 'Mbhalati', 'preciousm80@webmail.co.za', '0761023965', 'CLUSTER 10', '$2y$10$iaC5KcB4BNAmzkBXQMx7RuAtFqnJuOdEOvsZ.iXtoVpaFxr3zDCF2', 'e7d266d8968841a3c68b1cf45fca1bcda7dc04bf45fe8eed9e5132bcfe8e2a73', '2024-11-07 16:49:41', 'ffc9850b86a8f629f5ce5213c7a7aa92bccc9d941f691620a9362b254f9518de', '', '0000-00-00 00:00:00'),
(41, 22003246, 'Visitor', 'Oarabile', 'Phukuile', 'oraphukuile@gmail.com', '0659767468', '', '$2y$10$dQDSiLuHzI6P6XbI9uFNd.mxAk4HQ2DKlDeH.Kumdv.u1cgrvph2q', 'd20aea50f3350fe9eed3150d54b3ecdaed26eeb63b6a30800de0fffd02d8fe15', '2024-11-07 18:27:10', '', '', '0000-00-00 00:00:00'),
(42, 33604405, 'Student', 'NWU', 'UNIBO', 'nwu3630@gmail.com', '0667424706', '', '$2y$10$zVK8bZjaiTwhGLzgioxiz.IApmn9fAt7HPADJs6MtUsRk5ZzzV3B2', '76b45cc107e8f4c640af3ce5679eff3f531ea7913605d410c7a243eb7c47085e', '2024-11-07 19:23:31', '', '', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrators`
--
ALTER TABLE `administrators`
  ADD PRIMARY KEY (`Admin_id`),
  ADD UNIQUE KEY `Email_Add` (`Email_Add`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`Cart_id`);

--
-- Indexes for table `delivery_admin`
--
ALTER TABLE `delivery_admin`
  ADD PRIMARY KEY (`del_id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`Item_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`Message_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Email_Add` (`Email_Add`),
  ADD UNIQUE KEY `Phone_Number` (`Phone_Number`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administrators`
--
ALTER TABLE `administrators`
  MODIFY `Admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `Cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=360;

--
-- AUTO_INCREMENT for table `delivery_admin`
--
ALTER TABLE `delivery_admin`
  MODIFY `del_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `Item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `Message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
