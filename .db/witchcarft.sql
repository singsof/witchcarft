-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 14, 2023 at 07:15 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `witchcarft`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `account_id` int(11) NOT NULL COMMENT 'คีย์แอคเคาท์',
  `account_name` varchar(100) NOT NULL COMMENT 'ชื่อแอคเคาท์',
  `account_password` text NOT NULL COMMENT 'รหัสผ่านแอคเคาท์',
  `account_email` varchar(50) NOT NULL COMMENT 'อีเมลแอคเคาท์',
  `account_phone` varchar(10) NOT NULL COMMENT 'เบอร์แอคเคาท์',
  `account_address` text NOT NULL COMMENT 'ที่อยู่แอคเคาท์',
  `create_date` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'วันที่สร้างแอคเคาท์',
  `account_status` enum('show','hide','delete') NOT NULL DEFAULT 'show' COMMENT 'สถานะแอคเคาท์',
  `account_role` enum('user','admin') NOT NULL DEFAULT 'user' COMMENT 'สิทธิ์แอคเคาท์'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`account_id`, `account_name`, `account_password`, `account_email`, `account_phone`, `account_address`, `create_date`, `account_status`, `account_role`) VALUES
(24, 'SOMPHOL WILA', '$2y$10$ZCnqwRCAilsv2OrmuDnBQOcw8erJGD8lh2y6MZ/2YvTP6q4QDaz2y', 'singsoft.sw@gmail.com', '0961632545', '-', '2023-05-12 10:56:46', 'show', 'user'),
(30, 'สมพล', '$2y$10$XM4Dl1rLLlQilWkToxoEXevBY6VrQ4HAkDjTmHv5gcnKNW6l9daEm', 'sing@gmail.com', '098877333', '1234', '2023-05-13 07:00:57', 'show', 'user'),
(32, 'สมพล', '$2y$10$Pl9ufIvykYhphW/gmZIvCe3IeUSvElDIAu/3pBAPs85iUqMp6iHqa', 'test@gmail.com', '098786764', 'test					หกดหกด', '2023-05-14 22:20:56', 'show', 'user'),
(33, 'admid@gmail.com', '$2y$10$Pl9ufIvykYhphW/gmZIvCe3IeUSvElDIAu/3pBAPs85iUqMp6iHqa', 'admid@gmail.com', '09878676', 'admid@gmail.com', '2023-05-14 21:59:47', 'show', 'admin'),
(34, 'admid1@gmail.com', '$2y$10$Pl9ufIvykYhphW/gmZIvCe3IeUSvElDIAu/3pBAPs85iUqMp6iHqa', 'admid1@gmail.com', '0987656545', '1111', '2023-05-14 20:19:53', 'show', 'admin'),
(35, 'krittiya jina', '$2y$10$ZHrlkPW9wgM9oWGQ20b4weXjh28S4CPr7GRaJ75L5XrwQ/p7yH4uW', 'mind.krittiya@gmail.com', '0937248405', 'สุราษฎร์ธานี', '2023-05-14 23:00:41', 'show', 'user'),
(36, 'ฟราน', '$2y$10$16RzVTGJEXH3n2JY2zIA9ehmYUXnaNjeoUpc9p6b466q1Ne9RQ5US', 'mifazaza09@gmail.com', '0640166434', 'บ้าน 55/55 อยุธยา กรุงเทพ', '2023-05-14 23:02:55', 'show', 'user'),
(37, 'rr', '$2y$10$86f17cIZoAFy7wZ4n3qhB.GSIjDqWr/6x3SnOtz/Nbnel/7F2YumK', 'rr@rr.com', '0987656545', 'rr@rr.com', '2023-05-14 23:23:33', 'show', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_key` int(11) NOT NULL COMMENT 'คีย์คอมเมนต์',
  `comment_title` varchar(50) NOT NULL COMMENT 'ชื่อหัวข้อ',
  `comment_detail` text NOT NULL COMMENT 'รายละเอียดคอมเมนต์',
  `account_key` int(11) NOT NULL COMMENT 'คีย์ผู้คอมเมนต์',
  `product_key` int(11) NOT NULL COMMENT 'คีย์สินค้า',
  `comment_postdate` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'วันที่คอมเมนต์',
  `comment_status` enum('show','hide','delete') NOT NULL DEFAULT 'show' COMMENT 'สถานะคอมเมนต์'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_key`, `comment_title`, `comment_detail`, `account_key`, `product_key`, `comment_postdate`, `comment_status`) VALUES
(1, 'การใช้งาน', 'ใน PHP ทั้ง the &&และ&ตัวดำเนินการ ใช้สำหรับการดำเนินการทางตรรกะ แต่มีลักษณะการทำงานที่แตกต่างกัน:', 24, 3, '2023-05-13 05:10:03', 'show'),
(2, 'สวยมาก', 'ใน PHP ทั้ง the &&และ&ตัวดำเนินการ ใช้สำหรับการดำเนินการทางตรรกะ แต่มีลักษณะการทำงานที่แตกต่างกัน:', 24, 3, '2023-05-13 05:10:06', 'show'),
(3, 'การใช้งาน', 'ใน PHP ทั้ง the &&และ&ตัวดำเนินการ ใช้สำหรับการดำเนินการทางตรรกะ แต่มีลักษณะการทำงานที่แตกต่างกัน:', 24, 3, '2023-05-13 05:10:07', 'show'),
(5, 'สวยมาก', 'ใน PHP ทั้ง the &&และ&ตัวดำเนินการ ใช้สำหรับการดำเนินการทางตรรกะ แต่มีลักษณะการทำงานที่แตกต่างกัน:', 24, 3, '2023-05-13 05:10:10', 'show'),
(6, 'Hi', '-', 32, 4, '2023-05-13 16:31:13', 'show'),
(7, 'สวัดดี', '-', 32, 4, '2023-05-13 16:31:31', 'show');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_key` int(11) NOT NULL,
  `order_code` varchar(50) NOT NULL COMMENT 'รหัสคำสั่งซื้อ',
  `account_key` int(11) NOT NULL COMMENT 'คีย์ผู้ชื่อ',
  `order_price` float(10,2) NOT NULL COMMENT 'ราคารวม',
  `order_delivery` text NOT NULL COMMENT 'ที่อยู่จัดส่ง',
  `order_price_delivery` float(10,2) NOT NULL COMMENT 'ค่าจัดส่ง',
  `order_date` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'วันที่สั่งซื้อ',
  `order_status` enum('wait','sending','success','cancel') NOT NULL DEFAULT 'wait' COMMENT 'สถานะออเดอร์'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_key`, `order_code`, `account_key`, `order_price`, `order_delivery`, `order_price_delivery`, `order_date`, `order_status`) VALUES
(32, '4IxEl1YitPDWLvoG6pAs', 32, 2300.00, 'test					หกดหกด', 50.00, '2023-05-14 03:18:36', 'sending'),
(33, 'aIFtQHDKW6OiTFfgG3X8', 32, 600.00, 'test					หกดหกด', 50.00, '2023-05-14 22:27:31', 'wait');

-- --------------------------------------------------------

--
-- Table structure for table `orders_details`
--

CREATE TABLE `orders_details` (
  `ordetail_key` int(11) NOT NULL COMMENT 'คีย์รายละเอียดออเดอร์',
  `order_key` int(11) NOT NULL COMMENT 'คีย์ออเดอร์',
  `product_key` int(11) NOT NULL COMMENT 'คีย์สินค้า',
  `ordetail_item` int(11) NOT NULL COMMENT 'จำนวนสินค้าสั่งซื้อ',
  `ordetail_price` float(10,2) NOT NULL COMMENT 'ราคาสินค้า',
  `ordetail_status` enum('show','hide','delete') NOT NULL DEFAULT 'show' COMMENT 'สถานะ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders_details`
--

INSERT INTO `orders_details` (`ordetail_key`, `order_key`, `product_key`, `ordetail_item`, `ordetail_price`, `ordetail_status`) VALUES
(29, 32, 3, 1, 600.00, 'show'),
(30, 32, 4, 1, 800.00, 'show'),
(31, 32, 5, 1, 900.00, 'show'),
(32, 33, 18, 1, 600.00, 'show');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_key` int(11) NOT NULL COMMENT 'คีย์ชำระเงิน',
  `order_key` int(11) NOT NULL COMMENT 'คีย์ออเดอร์',
  `payment_amount` decimal(10,2) NOT NULL COMMENT 'ยอดชำระเงิน',
  `payment_method` enum('cash','qrcode','paypal') NOT NULL COMMENT 'รูปแบบชำระเงิน',
  `payment_currency` enum('THB','USD','GBP','EUR') NOT NULL DEFAULT 'THB' COMMENT 'สกุลเงิน',
  `payment_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_key`, `order_key`, `payment_amount`, `payment_method`, `payment_currency`, `payment_time`) VALUES
(14, 32, '2350.00', 'qrcode', 'THB', '2023-05-13 19:18:04'),
(15, 33, '650.00', 'qrcode', 'THB', '2023-05-14 15:27:31');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_key` int(11) NOT NULL,
  `product_name` varchar(50) NOT NULL COMMENT 'ชื่อสินค้า',
  `product_stock` int(11) NOT NULL COMMENT 'จำนวนคงเหลือ',
  `product_price` float(10,2) NOT NULL COMMENT 'ราคาสินค้า',
  `product_picture` varchar(100) NOT NULL COMMENT 'ภาพสินค้า',
  `product_detail` text NOT NULL COMMENT 'รายละเอียดสินค้า',
  `product_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'วันที่แก้ไขสินค้า',
  `product_status` enum('show','hide','delete') NOT NULL DEFAULT 'show' COMMENT 'สถานะสินค้า'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_key`, `product_name`, `product_stock`, `product_price`, `product_picture`, `product_detail`, `product_update`, `product_status`) VALUES
(1, 'Rhodochrosite', 50, 200.00, 'Screenshot_1.png', 'โรโดโครไซต์ หรือที่หลายคนรู้จักกันว่า “หินดึงดูดความรัก” เหมาะสำหรับคนโสดโดยเฉพาะ คนที่อยากเสริมเสน่ห์ ความเมตตาน่าเอ็นดูให้กับตัวเอง  ทำให้สมหวังเรื่องความรัก ดีไซน์เป็นกำไลหินสีชมพูอ่อน เข้าได้กับทุกเฉดสีผิว โดยเนื้อหินสวยเนียนละเอียด สามารถใส่เป็นเครื่องประดับได้ สำหรับพลังของหินชนิดนี้ จะช่วยเสริมเรื่องการพูด เพิ่มเสน่ห์เรื่องของการพูด ความน่ารักน่าเอ็นดู เพิ่มโชคด้านการค้าขายและเจรจาต่อรอง ให้เป็นไปได้อย่างราบรื่น', '2023-05-12 12:59:34', 'delete'),
(2, 'Rose Quartz', 50, 500.00, 'Screenshot_2.png', 'กำไลหินมงคล ที่ช่วยในเรื่องของความรักเหมือนกัน คือ กำไลโรสควอตซ์ หรือ “หินแห่งความรัก” เป็นกำไรหินสีชมพูสุดน่ารักที่ทำจากแร่หิน Quartz ซึ่งเป็นแร่ที่มีความอุดมสมบูรณ์มากที่สุด โดยในสมัยโบราณ หินชนิดนี้ถูกใช้เพื่อการรักษาโรค ส่วนในปัจจุบันมีความเชื่อว่าแร่หิน Quartz ช่วยในเรื่องของการสื่อสาร การทำความเข้าใจ จึงเหมาะกับคนที่ต้องการเสริมด้านความรัก ช่วยให้ความสัมพันธ์ยืนยาวและเข้าใจกันมากขึ้น  นอกจากนี้ยังช่วยส่งเสริมด้านการขายงาน การสื่อสารกับลูกค้า เพิ่มเสน่ห์ให้หลายคนอยากเข้าหา ถือเป็นอีกหนึ่ง', '2023-05-12 13:20:14', 'delete'),
(3, 'Lapis', 50, 600.00, 'Screenshot_3.png', 'เพิ่มความปังให้กับงาน โดยกำไลหินชนิดนี้ เป็นหินที่ช่วยเพิ่มสมาธิและความคิดสร้างสรรค์ ทำให้ผู้ที่สวมใส่สามารถคลายเครียด และมีจิตใจที่สงบลงได้ เหมาะสำหรับคนที่ต้องการใช้สมาธิในการคิดไอเดีย หรือสร้างสรรค์ผลงานให้มีความแปลกใหม่ ไม่ว่าจะเป็นคนที่ทำงานด้านครีเอทีฟ', '2023-05-11 18:28:46', 'show'),
(4, 'Amethyst', 50, 800.00, 'Screenshot_4.png', 'ป็นหินที่ช่วยในเรื่องของความเจริญก้าวหน้า โดดเด่นในเรื่องของหน้าที่การงาน  ทำให้ผู้สวมใส่มีสมาธิ อีกทั้งยังมีความเชื่อว่า หากใครใส่กำไลอเมทิสต์ จะกลายเป็นคนที่ใจเย็นลง', '2023-05-11 18:28:46', 'show'),
(5, 'Sparking Love', 50, 900.00, 'Screenshot_5.png', 'เสริมในเรื่องความรักและความเมตตาจากคนรอบข้าง และยังคอยขจัดปัดเป่าพลังในแง่ลบไม่ให้เข้ามารบกวน', '2023-05-11 18:28:46', 'show'),
(6, 'แหวนหยก', 50, 1000.00, 'Screenshot_6.png', 'ในทางศาสตร์ฮวงจุ้ย ‘หยก’ เป็นเครื่องมือในการสร้างและรักษาพลังงานชี่ ด้วยคุณสมบัติในด้านการสร้างความสมดุลและความสงบเยือกเย็น อีกทั้งยังนิยมนำมาใช้เป็นเครื่องรางในการปกป้องอันตรายและการนำโชคอีกด้วย ', '2023-05-11 18:28:46', 'show'),
(7, 'ชาร์มท้าวเวสสุวรรณควรมีติดข้อมือไว้', 50, 1200.00, 'Screenshot_7.png', 'ชาร์มท้าวเวสสุวรรณ ช่วยส่งเสริมโชคลาภ ช่วยเรื่องการเงิน อำนาจวาสนา และความเจริญก้าวหน้า', '2023-05-11 18:28:46', 'show'),
(8, 'ด้ายแดง ปี่เซี๊ยะ', 50, 1300.00, 'Screenshot_8.png', 'สำหรับเสริมดวงของทุกปีนักษัตรที่ดี คือ ปี่เซียะ ด้ายแดง คู่บารมี เสริมโชค เรียกทรัพย์ ร่ำรวย เงิน ทอง ปัดเป่าสิ่งชั่วร้าย เก็บเงินทองไม่รั่วไหลพร้อมก้อนเงิน สัญลักษณ์ของความมั่งคั่ง มั่งมี', '2023-05-11 18:28:46', 'show'),
(9, 'ไหลเขียว', 50, 1400.00, 'Screenshot_9.png', '‘ไหลเขียว’ เป็นเครื่องรางที่เหมาะกับคนที่รู้สึกว่าช่วงนี้ทำอะไรก็ไม่ดี ค้าขายไม่ขึ้น ทำอะไรไม่ค่อยสำเร็จ ‘ไหลเขียว’ มีสรรพคุณช่วยไล่สิ่งเลวร้าย คุณไสย มนต์ดำ ลมเพลมพัด เดรฉานวิชาต่างๆ แถมมีคุณสมบัติช่วยให้แคล้วคลาด', '2023-05-11 18:28:46', 'show'),
(10, 'รูปโอมพระพิฆเนศ', 50, 1500.00, 'Screenshot_10.png', 'สัญลักษณ์โอมที่ช่วยเสริมเรื่องการเงินปัง ๆ การงานดี ความรักเลิศ สร้อยคอ จี้โอมของพระพิฆเนศ ช่วยเสริมเสน่ห์ เมตตามหานิยม รวมถึงแผ่นทองพระพิฆเนศด้วยจ้า บูชาแล้วค้าขายดีสุด ๆ', '2023-05-11 18:28:46', 'show'),
(16, 'Rhodochrosite', 50, 200.00, 'Screenshot_1.png', 'โรโดโครไซต์ หรือที่หลายคนรู้จักกันว่า “หินดึงดูดความรัก” เหมาะสำหรับคนโสดโดยเฉพาะ คนที่อยากเสริมเสน่ห์ ความเมตตาน่าเอ็นดูให้กับตัวเอง  ทำให้สมหวังเรื่องความรัก ดีไซน์เป็นกำไลหินสีชมพูอ่อน เข้าได้กับทุกเฉดสีผิว โดยเนื้อหินสวยเนียนละเอียด สามารถใส่เป็นเครื่องประดับได้ สำหรับพลังของหินชนิดนี้ จะช่วยเสริมเรื่องการพูด เพิ่มเสน่ห์เรื่องของการพูด ความน่ารักน่าเอ็นดู เพิ่มโชคด้านการค้าขายและเจรจาต่อรอง ให้เป็นไปได้อย่างราบรื่น', '2023-05-12 12:59:34', 'delete'),
(17, 'Rose Quartz', 50, 500.00, 'Screenshot_2.png', 'กำไลหินมงคล ที่ช่วยในเรื่องของความรักเหมือนกัน คือ กำไลโรสควอตซ์ หรือ “หินแห่งความรัก” เป็นกำไรหินสีชมพูสุดน่ารักที่ทำจากแร่หิน Quartz ซึ่งเป็นแร่ที่มีความอุดมสมบูรณ์มากที่สุด โดยในสมัยโบราณ หินชนิดนี้ถูกใช้เพื่อการรักษาโรค ส่วนในปัจจุบันมีความเชื่อว่าแร่หิน Quartz ช่วยในเรื่องของการสื่อสาร การทำความเข้าใจ จึงเหมาะกับคนที่ต้องการเสริมด้านความรัก ช่วยให้ความสัมพันธ์ยืนยาวและเข้าใจกันมากขึ้น  นอกจากนี้ยังช่วยส่งเสริมด้านการขายงาน การสื่อสารกับลูกค้า เพิ่มเสน่ห์ให้หลายคนอยากเข้าหา ถือเป็นอีกหนึ่ง', '2023-05-12 13:20:14', 'delete'),
(18, 'Lapis', 50, 600.00, 'Screenshot_3.png', 'เพิ่มความปังให้กับงาน โดยกำไลหินชนิดนี้ เป็นหินที่ช่วยเพิ่มสมาธิและความคิดสร้างสรรค์ ทำให้ผู้ที่สวมใส่สามารถคลายเครียด และมีจิตใจที่สงบลงได้ เหมาะสำหรับคนที่ต้องการใช้สมาธิในการคิดไอเดีย หรือสร้างสรรค์ผลงานให้มีความแปลกใหม่ ไม่ว่าจะเป็นคนที่ทำงานด้านครีเอทีฟ', '2023-05-11 18:28:46', 'show'),
(19, 'Amethyst', 50, 800.00, 'Screenshot_4.png', 'ป็นหินที่ช่วยในเรื่องของความเจริญก้าวหน้า โดดเด่นในเรื่องของหน้าที่การงาน  ทำให้ผู้สวมใส่มีสมาธิ อีกทั้งยังมีความเชื่อว่า หากใครใส่กำไลอเมทิสต์ จะกลายเป็นคนที่ใจเย็นลง', '2023-05-11 18:28:46', 'show'),
(20, 'Sparking Love', 50, 900.00, 'Screenshot_5.png', 'เสริมในเรื่องความรักและความเมตตาจากคนรอบข้าง และยังคอยขจัดปัดเป่าพลังในแง่ลบไม่ให้เข้ามารบกวน', '2023-05-11 18:28:46', 'show'),
(21, 'แหวนหยก', 50, 1000.00, 'Screenshot_6.png', 'ในทางศาสตร์ฮวงจุ้ย ‘หยก’ เป็นเครื่องมือในการสร้างและรักษาพลังงานชี่ ด้วยคุณสมบัติในด้านการสร้างความสมดุลและความสงบเยือกเย็น อีกทั้งยังนิยมนำมาใช้เป็นเครื่องรางในการปกป้องอันตรายและการนำโชคอีกด้วย ', '2023-05-11 18:28:46', 'show'),
(22, 'ชาร์มท้าวเวสสุวรรณควรมีติดข้อมือไว้', 50, 1200.00, 'Screenshot_7.png', 'ชาร์มท้าวเวสสุวรรณ ช่วยส่งเสริมโชคลาภ ช่วยเรื่องการเงิน อำนาจวาสนา และความเจริญก้าวหน้า', '2023-05-11 18:28:46', 'show'),
(23, 'ด้ายแดง ปี่เซี๊ยะ', 50, 1300.00, 'Screenshot_8.png', 'สำหรับเสริมดวงของทุกปีนักษัตรที่ดี คือ ปี่เซียะ ด้ายแดง คู่บารมี เสริมโชค เรียกทรัพย์ ร่ำรวย เงิน ทอง ปัดเป่าสิ่งชั่วร้าย เก็บเงินทองไม่รั่วไหลพร้อมก้อนเงิน สัญลักษณ์ของความมั่งคั่ง มั่งมี', '2023-05-11 18:28:46', 'show'),
(24, 'ไหลเขียว', 50, 1400.00, 'Screenshot_9.png', '‘ไหลเขียว’ เป็นเครื่องรางที่เหมาะกับคนที่รู้สึกว่าช่วงนี้ทำอะไรก็ไม่ดี ค้าขายไม่ขึ้น ทำอะไรไม่ค่อยสำเร็จ ‘ไหลเขียว’ มีสรรพคุณช่วยไล่สิ่งเลวร้าย คุณไสย มนต์ดำ ลมเพลมพัด เดรฉานวิชาต่างๆ แถมมีคุณสมบัติช่วยให้แคล้วคลาด', '2023-05-11 18:28:46', 'show'),
(25, 'รูปโอมพระพิฆเนศ', 50, 1500.00, 'Screenshot_10.png', 'สัญลักษณ์โอมที่ช่วยเสริมเรื่องการเงินปัง ๆ การงานดี ความรักเลิศ สร้อยคอ จี้โอมของพระพิฆเนศ ช่วยเสริมเสน่ห์ เมตตามหานิยม รวมถึงแผ่นทองพระพิฆเนศด้วยจ้า บูชาแล้วค้าขายดีสุด ๆ', '2023-05-11 18:28:46', 'show'),
(26, 'ww', 11, 111.00, 'vv2023_05_14_21_12_51ze2gjv.png', '111', '2023-05-14 14:12:51', 'show'),
(27, 'wwy', 11, 111.00, 'Yr2023_05_14_21_14_56k6vUdp.png', '111', '2023-05-14 14:14:56', 'show'),
(28, 'wwyw', 11, 111.00, 's92023_05_14_21_15_059KuXqG.png', '111', '2023-05-14 14:22:00', 'delete'),
(29, 'ad', 5, 666.00, 'Uf2023_05_14_21_15_397dzZPG.png', '66', '2023-05-14 14:21:56', 'delete');

-- --------------------------------------------------------

--
-- Table structure for table `relation_card_product`
--

CREATE TABLE `relation_card_product` (
  `relation_key` int(11) NOT NULL COMMENT 'คีย์ความสมพันธ์',
  `product_key` int(11) NOT NULL COMMENT 'คีย์สินค้า',
  `card_key` int(11) NOT NULL COMMENT 'คีย์การ์ด',
  `relation_status` enum('show','hide','delete') NOT NULL DEFAULT 'show' COMMENT 'สถานะความสัมพันธ์'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `relation_card_product`
--

INSERT INTO `relation_card_product` (`relation_key`, `product_key`, `card_key`, `relation_status`) VALUES
(2, 3, 1, 'show'),
(3, 4, 1, 'show'),
(6, 3, 2, 'show'),
(7, 5, 3, 'show'),
(8, 6, 3, 'show'),
(9, 7, 3, 'show'),
(10, 6, 4, 'show'),
(11, 7, 4, 'show'),
(12, 10, 4, 'show'),
(13, 9, 5, 'show'),
(14, 3, 5, 'show'),
(15, 1, 5, 'show'),
(17, 4, 6, 'show'),
(18, 5, 6, 'show'),
(19, 1, 7, 'show'),
(21, 5, 7, 'show'),
(22, 4, 8, 'show'),
(23, 6, 8, 'show'),
(24, 9, 8, 'show'),
(25, 3, 9, 'show'),
(27, 1, 9, 'show'),
(34, 3, 2, 'show'),
(35, 3, 1, 'show'),
(36, 4, 2, 'show'),
(37, 5, 1, 'show'),
(38, 5, 7, 'show'),
(39, 4, 19, 'show'),
(40, 4, 19, 'show'),
(41, 4, 19, 'show'),
(42, 5, 19, 'show'),
(43, 8, 19, 'show'),
(44, 9, 19, 'show'),
(45, 18, 19, 'show');

-- --------------------------------------------------------

--
-- Table structure for table `tarotcards`
--

CREATE TABLE `tarotcards` (
  `card_key` int(11) NOT NULL COMMENT 'คีย์อ้างอิงไพ่',
  `card_name` varchar(50) NOT NULL COMMENT 'ชื่อไพ่',
  `card_picture` varchar(50) NOT NULL COMMENT 'รูปภาพไพ่',
  `card_meaning` text NOT NULL COMMENT 'ความหมายไพ่',
  `card_detail` text NOT NULL COMMENT 'รายละเอียดไพ่',
  `card_status` enum('show','hide','delete') NOT NULL DEFAULT 'show' COMMENT 'สถานะไพ่'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tarotcards`
--

INSERT INTO `tarotcards` (`card_key`, `card_name`, `card_picture`, `card_meaning`, `card_detail`, `card_status`) VALUES
(1, 'THE FOOL', 'Screenshot_1.png', '\"เด็กหนุ่มผู้มีอิสระ ไร้เดียงสา พร้อมจะผจญภัยไปยังโลกกว้าง ก้าวเดินไปยังหน้าผาอันตราย อย่างไม่หวั่นเกรง พร้อมสุนัขคู่ใจตัวน้อยที่พร้อมปกป้องระหว่างทาง\"', 'ไพ่ใบนี้ถ้าเป็นไพ่ที่บ่งบอกลักษณะของคน ก็จะเป็นคนที่มีลักษณะมีความคิดอิสระ ความรักอิสระ ดูไร้เดียงสา ซึ่งจริงๆก็อาจจะไม่ได้ไร้เดียงสา แต่เราเลือกว่าเราชอบแล้ว รักแล้ว ที่จะตามสิ่งที่ฝันตามสิ่งที่ชอบ แม้จะประสบความสำเร็จหรือไม่ก็ตาม', 'show'),
(2, 'THE MAGICIAN', 'Screenshot_2.png', '\"จอมเวทย์ผู้มีความสามารถในการเชื่อมระหว่างโลกและจักรวาล ผู้มีเข้าใจในธรรมชาติและความสามารถในการควบคุมผสาน สรรสร้าง ทุกสรรพสิ่งจาก ดิน น้ำ ลม ไฟ\"\r\n', 'ไพ่ใบนี้บ่งบอกลักษณะของคนที่มีความรู้ ความสามารถ ฉลาด เข้าใจโลก เป็นนักวิชาการ นักวิจัย  แต่ในอีกมุมนึงก็อาจจะดูเป็นคนที่พูดดี พูดเก่ง มีความรู้ มากเกินกว่าที่จะเป็นปฏิบัติจริง\r\n', 'show'),
(3, 'THE HIGH PRIESTESS', 'Screenshot_3.png', '\"ราชินีพระจันทร์ เทพธิดาผู้สามารถติดต่อกับโลกแห่งจิตวิญญาณและความจริง เป็นเจ้าลัทธิที่มีอำนาจลึกลับ ซับซ้อนของผู้หญิงซ่อนอยู่เบื้องหลังความไร้เดียงสา\"', 'ไพ่ใบนี้บ่งบอกถึงคนที่มีสัญชาตญาณ มีเซนส์ มีความลึกลับ ซับซ้อนในความคิดและการกระทำ แม้อาจจะไม่ใช่เรื่องดี ที่มีความขัดแย้งและปกปิด แต่จริงๆแล้วสิ่งที่ปกปิดไว้นั้นกลับมีความไร้เดียงสาบริสุทธิ์อยู่', 'show'),
(4, 'THE EMPRESS', 'bb2023_05_14_21_47_132MjLRj.png', '\"จักรพรรดินีผู้เลอโฉม และมีความเป็นแม่สูง นั่งอยู่สวนป่าที่มีความอุดมสมบูรณ์ เธอพร้อมที่จะหล่อเลี้ยงและให้กำเนิดสรรพสิ่ง พร้อมที่จะดูแลคนของเธอเป็นอย่างดี\"', 'ไพ่ใบนี้ส่วนใหญ่ถ้าคนเป็นคู่กันแล้ว ก็อาจจะหมายความถึงการให้กำเนิดลูก ถ้าใครรอมีลูกหรือถามเรื่องมีลูก แล้วออกไพ่ใบนี้ขึ้นมา ก็มีแววจะตั้งครรภ์ได้ล่ะครับ', 'show'),
(5, 'THE EMPEROR', 'Screenshot_5.png', '\"จักรพรรดิผู้นิ่งสงบ การควบคุมคน ความนิ่ง ความมั่นคง ทำให้สามารถสยบโลกไว้ได้ด้วยอำนาจของตัวเอง ชายผู้มีความเป็นพ่อสูง พร้อมห่วงใยดูแลและปกป้อง\"', 'ไพ่จักรพรรดิใบนี้เป็นไพ่ที่บ่งบอกถึงคนที่มีลักษณะของความเป็นพ่อ เป็นผู้ชายสูง เป็นคนที่นิ่ง มั่นคง พร้อมดูแลปกป้องทุกคนด้วยกำลังและความสามารถที่มี อาจดูเป็นคนแข็งๆ เป็นคนตรงๆ ไม่อ่อนโยน อ่อนหวาน แต่ก็มีความมั่นคง และจริงใจ ไพ่ใบนี้อาจหมายถึงบุคคลที่มีอายุมาก เป็นหัวหน้า เป็นผู้นำคนอื่น หรือคนที่มีประสบการณ์ในด้านต่างๆสูง', 'show'),
(6, 'THE HIEROPHANT', 'Screenshot_6.png', '\"สังฆราช ผู้ศึกษาความรู้ ธรรมเนียมปฏิบัติ เป็นผู้นำด้านความเชื่อ ความศรัทธา ผู้เคร่งครัดในจารีต พร้อมที่จะถ่ายทอดความรู้ความเชื่อให้เหล่าศิษย์ทั้งหลาย\"', 'ไพ่ใบนี้เป็นลักษณะของไพ่ที่บ่งบอกถึงอะไรที่เป็นข้อตกลงร่วม เป็นกฏ เป็นประเพณี จารีต ที่ประพฤติตาม รวมถึงความเชื่อและศาสนา ถ้าพูดถึงลักษณะคน ก็จะเป็นได้ทั้งพระ บาทหลวง ไปยันถึง ครูอาจารย์ ผู้สั่งสอน ผู้อบรมให้ความรู้ต่างๆ หรืออาจเป็นคนที่ประพฤติตนตามจารีต เป็นคนอนุรักษ์นิยม ทำตามสิ่งที่เรียนรู้มา ไม่นอกกรอบ', 'show'),
(7, 'THE LOVERS', 'Screenshot_7.png', '\"เรื่องราวของอดัม กับ อีฟ ในสวนอีเดน ที่พระเจ้าได้ให้ทั้งคู่เป็นคู่ครองกันและอยู่อย่างมีความสุข แต่งูก็ได้เสนอผลไม้แห่งความรู้ซึ่งเป็นผลไม้ต้องห้ามที่พระเจ้าได้ห้ามไว้  ถึงทางเลือกที่พวกเขาจะต้องเลือก\"', 'ไพ่ใบนี้ชื่ออาจเหมือนความรัก ความสมหวัง แต่อันที่จริงแล้ว ไพ่ใบนี้คือทางเลือก ถ้าดูจากรูปบนไพ่ จะเห็นว่า เทวดาได้ทำให้คนสองคนมาเจอกัน เปรียบเหมือนพรหมลิขิต แต่ก็ยังไม่ได้ตัดสินใจอะไรชัดเจนขึ้นมา เพราะถ้าดูจะเห็นว่า ฝ่ายหญิง หรือ อีฟ มองหน้าเทวดราเหมือนสงสัยว่า \"ผู้ชายคนนี้ใช่จริงๆรึเปล่า\" ดังนั้นไพ่ใบนี้จึงเปรียบเสมือนโอกาสที่เข้ามา ซึ่งเราต้องเลือกและตัดสินใจ', 'show'),
(8, 'THE CHARIOT', 'Screenshot_8.png', '\"อัศวินรถม้าผู้ที่สามารถควบคุมรถม้าไปได้ด้วยพละกำลัง พร้อมมุ่งหน้าเข้าประจันข้าศึก โดยไม่เกรงกลัวต่อสิ่งใด \"', 'ความหมายของไพ่ใบนี้จะเป็นไพ่แห่งการเคลื่อนที่ การมุทะลุ เพื่อไปให้ถึงชัยชนะ ดังนั้นไพ่นี้จึงเปรียบเสมือนไพ่ที่พร้อมออกศึกเพื่อชัยชนะ แม้ยังไม่รู้ว่าตัวเองจะชนะหรือไม่ แต่ก็พร้อมลุยไปข้างหน้าด้วยความสามารถทั้งหมด\r\nที่มี\r\n', 'show'),
(9, 'STRENGTH', 'Screenshot_9.png', '\"หญิงสาวลูบหัวและคางของสิงโตด้วยใบหน้ายิ้มอย่างสงบ ซึ่งสิงโตก็ยอมเธอ โดยที่เธอไม่จำเป็นต้องออกแรงใดๆ\"', 'ไพ่ใบนี้ความหมายเปรียบเหมือนความเข้มแข็งที่เราสามารถควบคุมภายในจิตใจ สามารถต้านทานความดุดัน ความโกรธ ความดิบเถื่อนซึ่งเปรียบเสมือนสิงโตในตัวเองลงได้ เพราะนั้นคือความแข็งแกร่งที่แท้จริง', 'show'),
(19, '1', 'k72023_05_14_20_37_56gKMHTM.png', '9', '9', 'show');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`account_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_key`),
  ADD KEY `products` (`product_key`),
  ADD KEY `account` (`account_key`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_key`),
  ADD KEY `account_key` (`account_key`);

--
-- Indexes for table `orders_details`
--
ALTER TABLE `orders_details`
  ADD PRIMARY KEY (`ordetail_key`),
  ADD KEY `order_keys` (`order_key`),
  ADD KEY `pro` (`product_key`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_key`),
  ADD KEY `order_key` (`order_key`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_key`);

--
-- Indexes for table `relation_card_product`
--
ALTER TABLE `relation_card_product`
  ADD PRIMARY KEY (`relation_key`),
  ADD KEY `product_key` (`product_key`),
  ADD KEY `card_key` (`card_key`);

--
-- Indexes for table `tarotcards`
--
ALTER TABLE `tarotcards`
  ADD PRIMARY KEY (`card_key`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `account_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'คีย์แอคเคาท์', AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_key` int(11) NOT NULL AUTO_INCREMENT COMMENT 'คีย์คอมเมนต์', AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_key` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `orders_details`
--
ALTER TABLE `orders_details`
  MODIFY `ordetail_key` int(11) NOT NULL AUTO_INCREMENT COMMENT 'คีย์รายละเอียดออเดอร์', AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_key` int(11) NOT NULL AUTO_INCREMENT COMMENT 'คีย์ชำระเงิน', AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_key` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `relation_card_product`
--
ALTER TABLE `relation_card_product`
  MODIFY `relation_key` int(11) NOT NULL AUTO_INCREMENT COMMENT 'คีย์ความสมพันธ์', AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `tarotcards`
--
ALTER TABLE `tarotcards`
  MODIFY `card_key` int(11) NOT NULL AUTO_INCREMENT COMMENT 'คีย์อ้างอิงไพ่', AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `account` FOREIGN KEY (`account_key`) REFERENCES `accounts` (`account_id`),
  ADD CONSTRAINT `products` FOREIGN KEY (`product_key`) REFERENCES `products` (`product_key`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `account_key` FOREIGN KEY (`account_key`) REFERENCES `accounts` (`account_id`);

--
-- Constraints for table `orders_details`
--
ALTER TABLE `orders_details`
  ADD CONSTRAINT `order_keys` FOREIGN KEY (`order_key`) REFERENCES `orders` (`order_key`),
  ADD CONSTRAINT `pro` FOREIGN KEY (`product_key`) REFERENCES `products` (`product_key`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `order_key` FOREIGN KEY (`order_key`) REFERENCES `orders` (`order_key`);

--
-- Constraints for table `relation_card_product`
--
ALTER TABLE `relation_card_product`
  ADD CONSTRAINT `card_key` FOREIGN KEY (`card_key`) REFERENCES `tarotcards` (`card_key`),
  ADD CONSTRAINT `product_key` FOREIGN KEY (`product_key`) REFERENCES `products` (`product_key`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
