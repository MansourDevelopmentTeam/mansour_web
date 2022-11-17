-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 17, 2022 at 02:41 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mansourgroup`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `customer_last_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_first_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `apartment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `floor` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `landmark` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city_id` int(10) UNSIGNED DEFAULT NULL,
  `area_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `primary` tinyint(1) NOT NULL DEFAULT 0,
  `lat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lng` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `district_id` bigint(20) UNSIGNED DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verification_code` int(11) DEFAULT NULL,
  `phone_verified` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `user_id`, `customer_last_name`, `customer_first_name`, `name`, `address`, `apartment`, `floor`, `landmark`, `city_id`, `area_id`, `created_at`, `updated_at`, `deleted_at`, `primary`, `lat`, `lng`, `district_id`, `phone`, `email`, `verification_code`, `phone_verified`) VALUES
(10504, 1, 'Mahmoud', 'Muhanad', 'Muhanad Mahmoud', 'M okatam', 'asdasd', '1', 'asd', 10, 512, '2022-11-23 08:20:22', '2022-11-23 08:20:22', NULL, 0, '1', 'ar', 1816, '01110032911', 'muhanadmahmoud@hotmail.com', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ads`
--

CREATE TABLE `ads` (
  `id` int(10) UNSIGNED NOT NULL,
  `type` int(11) DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `deactivation_notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `popup` tinyint(1) NOT NULL DEFAULT 0,
  `banner_ad` tinyint(1) NOT NULL DEFAULT 0,
  `banner_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `banner_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `banner_title_ar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `banner_description_ar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_ar` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_web` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_web_ar` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ads`
--

INSERT INTO `ads` (`id`, `type`, `image`, `item_id`, `created_at`, `updated_at`, `active`, `deactivation_notes`, `order`, `popup`, `banner_ad`, `banner_title`, `banner_description`, `banner_title_ar`, `banner_description_ar`, `image_ar`, `image_web`, `image_web_ar`, `link`) VALUES
(56, 2, 'http://104.46.33.250/storage/uploads/280201874_5160462684008541_2868231885123684420_n-1658242570.jpg', 4, '2021-11-21 11:46:18', '2022-10-30 09:24:28', 1, NULL, 4, 0, 0, 'best_offer', NULL, NULL, NULL, 'http://104.46.33.250/storage/uploads/280201874_5160462684008541_2868231885123684420_n-1658242572.jpg', 'http://104.46.33.250/storage/uploads/360_F_262035364_gGi8uJsPl9uljis8C6oxI0w6AM7MKDLq-1648383310.jpeg', 'http://104.46.33.250/storage/uploads/360_F_262035364_gGi8uJsPl9uljis8C6oxI0w6AM7MKDLq-1648383315.jpeg', 'DVDSLG/171?variant=172'),
(58, 2, 'http://104.46.33.250/storage/uploads/Slide1-1659446985.jpg', 12, '2022-07-19 14:02:19', '2022-10-30 09:24:26', 1, NULL, 1, 0, 0, '5 تارجت', NULL, NULL, NULL, 'http://104.46.33.250/storage/uploads/Slide1-1659446994.jpg', 'http://104.46.33.250/storage/uploads/عملاء البرنامج-1658232098.jpg', 'http://104.46.33.250/storage/uploads/عملاء البرنامج-1658232103.jpg', NULL),
(59, 10, 'http://104.46.33.250/storage/uploads/Picture2-1658242302.png', NULL, '2022-07-19 15:22:21', '2022-10-30 09:24:29', 1, NULL, 5, 0, 0, NULL, NULL, NULL, NULL, 'http://104.46.33.250/storage/uploads/Picture2-1658242305.png', 'http://104.46.33.250/storage/uploads/Slide3-1658236923.JPG', 'http://104.46.33.250/storage/uploads/Slide3-1658236926.JPG', NULL),
(60, 10, 'http://104.46.33.250/storage/uploads/Picture4-1658242789.png', NULL, '2022-07-19 17:00:09', '2022-10-30 09:24:29', 1, NULL, 3, 0, 0, NULL, NULL, NULL, NULL, 'http://104.46.33.250/storage/uploads/Picture4-1658242792.png', 'http://104.46.33.250/storage/uploads/Picture4-1658242797.png', 'http://104.46.33.250/storage/uploads/Picture4-1658242801.png', NULL),
(61, 5, 'http://104.46.33.250/storage/uploads/Slide1-1659447158.jpg', 83, '2022-08-02 15:36:04', '2022-10-30 09:24:26', 1, NULL, 2, 0, 0, 'target 1', NULL, NULL, NULL, 'http://104.46.33.250/storage/uploads/Slide1-1659447163.jpg', 'http://104.46.33.250/storage/uploads/Slide1-1659447185.jpg', 'http://104.46.33.250/storage/uploads/Slide1-1659447190.jpg', NULL),
(62, 0, 'http://104.46.33.250/storage/uploads/Mansour-1663073938.JPG', NULL, '2022-09-13 15:17:29', '2022-10-30 09:24:24', 0, 'a', 0, 0, 0, 'اعلان هام', NULL, NULL, NULL, 'http://104.46.33.250/storage/uploads/Mansour-1663075030.JPG', 'http://104.46.33.250/storage/uploads/Mansour-1663075040.JPG', 'http://104.46.33.250/storage/uploads/Mansour-1663075047.JPG', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `affiliate_links`
--

CREATE TABLE `affiliate_links` (
  `id` int(10) UNSIGNED NOT NULL,
  `url` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `referral` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `affiliate_id` int(10) UNSIGNED DEFAULT NULL,
  `expiration_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `affiliate_link_histories`
--

CREATE TABLE `affiliate_link_histories` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_ip` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `link_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `affiliate_link_histories`
--

INSERT INTO `affiliate_link_histories` (`id`, `user_ip`, `user_id`, `link_id`, `created_at`, `updated_at`) VALUES
(4, '156.215.236.227', NULL, 8, '2021-09-19 14:05:06', '2021-09-19 14:05:06');

-- --------------------------------------------------------

--
-- Table structure for table `affiliate_requests`
--

CREATE TABLE `affiliate_requests` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_verified` tinyint(1) NOT NULL DEFAULT 0,
  `verification_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `rejection_reason` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `areas`
--

CREATE TABLE `areas` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `deactivation_notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivery_fees` decimal(8,2) DEFAULT NULL,
  `name_ar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aramex_area_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivery_fees_type` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `areas`
--

INSERT INTO `areas` (`id`, `name`, `city_id`, `created_at`, `updated_at`, `active`, `deactivation_notes`, `delivery_fees`, `name_ar`, `aramex_area_name`, `delivery_fees_type`) VALUES
(78, 'Egypt Alexandria desert', 7, NULL, NULL, 1, NULL, '0.00', 'مصر اسكندرية الصحراوي', NULL, 1),
(79, 'Alexandria Desert Road', 8, NULL, '2021-09-09 12:47:29', 1, NULL, '70.00', 'اسكندرية القاهرة الصحراوي', 'Alex Desert Rd.', 1),
(80, '6th of October City', 7, NULL, NULL, 1, NULL, '0.00', 'مدينة 6 أكتوبر', 'October City', 1),
(81, 'Desert Ismailia, Egypt', 9, NULL, NULL, 1, NULL, '0.00', 'مصر اسماعيلية الصحراوي', NULL, 1),
(82, 'Awsim', 7, NULL, NULL, 1, NULL, '0.00', 'اوسيم', NULL, 1),
(83, 'first settlement', 10, NULL, NULL, 1, NULL, '0.00', 'التجمع الأول', NULL, 1),
(84, 'Fifth settlement', 10, NULL, NULL, 1, NULL, '0.00', 'التجمع الخامس', NULL, 1),
(85, 'Shabramant', 7, NULL, NULL, 1, NULL, '0.00', 'شبرمنت', NULL, 1),
(86, 'Katameya', 10, NULL, NULL, 1, NULL, '0.00', 'القطامية', 'Katamiah', 1),
(87, 'End of Gesr El Sewes ', 10, NULL, NULL, 1, NULL, '0.00', 'آخر جسر السويس', NULL, 1),
(88, 'El Saff', 7, NULL, NULL, 1, NULL, '0.00', 'الصف', 'El Saf', 1),
(89, 'Hawamdiya', 7, NULL, NULL, 1, NULL, '0.00', 'الحوامدية', 'El Hawamdiah', 1),
(90, 'El Monwat ', 7, NULL, NULL, 1, NULL, '0.00', 'المنوات', NULL, 1),
(91, 'Sheikh Zayed City', 7, NULL, NULL, 1, NULL, '0.00', 'مدينة الشيخ زايد', NULL, 1),
(92, 'Badrashin', 7, NULL, NULL, 1, NULL, '0.00', 'البدرشين', 'Badrashin', 1),
(93, 'Bulaq El Dakrour', 7, NULL, NULL, 1, NULL, '0.00', 'بولاق الدكرور', 'Bolak El Dakrour', 1),
(94, 'Saft El Laban ', 7, NULL, NULL, 1, NULL, '0.00', 'صفط اللبن', NULL, 1),
(95, 'Warraq', 7, NULL, NULL, 1, NULL, '0.00', 'الوراق', 'Al Waraq', 1),
(96, 'Imbaba', 7, NULL, NULL, 1, NULL, '0.00', 'امبابة', 'Imbaba', 1),
(97, 'Nasr City', 10, NULL, NULL, 1, NULL, '0.00', 'مدينة نصر', 'Nasr City', 1),
(98, 'Third settlement', 10, NULL, NULL, 1, NULL, '0.00', 'التجمع الثالث', NULL, 1),
(99, 'Dokki', 7, NULL, NULL, 1, NULL, '0.00', 'الدقي', 'Dokki ', 1),
(100, 'Agouza', 7, NULL, NULL, 1, NULL, '0.00', 'العجوزة', 'Agouza', 1),
(101, 'Giza Square', 7, NULL, NULL, 1, NULL, '0.00', 'ميدان الجيزة', NULL, 1),
(102, 'El Ayat', 7, NULL, NULL, 1, NULL, '0.00', 'العياط', 'El Ayat', 1),
(103, 'Bahariya Oasis', 7, NULL, NULL, 1, NULL, '0.00', 'الواحات البحرية', 'Al Wahat', 1),
(104, 'Manshiet al-Qanater', 7, NULL, NULL, 1, NULL, '0.00', 'منشية القناطر', NULL, 1),
(105, 'Atfeh', 7, NULL, NULL, 1, NULL, '0.00', 'اطفيح', 'Atfeah', 1),
(106, 'El Haranya', 7, NULL, NULL, 1, NULL, '0.00', 'الحرانية', NULL, 1),
(107, 'El Omranya', 7, NULL, NULL, 1, NULL, '0.00', 'العمرانية', 'Omranya', 1),
(108, 'the church', 7, NULL, NULL, 1, NULL, '0.00', 'الكنيسة', NULL, 1),
(109, 'El Haram', 7, NULL, NULL, 1, NULL, '0.00', 'الهرم', 'Al Haram', 1),
(110, 'Dahshour', 7, NULL, NULL, 1, NULL, '0.00', 'دهشور', 'Dahshour', 1),
(111, 'Zenin', 7, NULL, NULL, 1, NULL, '0.00', 'زنين', NULL, 1),
(112, 'Saqqara', 7, NULL, NULL, 1, NULL, '0.00', 'سقارة', 'Saqara', 1),
(113, 'Tamwa', 7, NULL, NULL, 1, NULL, '0.00', 'طموة', NULL, 1),
(114, 'Faisal', 7, NULL, NULL, 1, NULL, '0.00', 'فيصل', NULL, 1),
(115, 'Kerdasa', 7, NULL, NULL, 1, NULL, '0.00', 'كرداسة', NULL, 1),
(116, 'Kafr El Gabal', 7, NULL, NULL, 1, NULL, '0.00', 'كفر الجبل', NULL, 1),
(117, 'Kafr Tohormos', 7, NULL, NULL, 1, NULL, '0.00', 'كفر طهرمس', NULL, 1),
(118, 'Kafr Ghatata ', 7, NULL, NULL, 1, NULL, '0.00', 'كفر غطاطي', NULL, 1),
(119, 'Kafr Nassar', 7, NULL, NULL, 1, NULL, '0.00', 'كفر نصار', NULL, 1),
(120, 'Manshiyat al-Bakari', 7, NULL, NULL, 1, NULL, '0.00', 'منشية البكاري', NULL, 1),
(121, 'Manial Shiha', 7, NULL, NULL, 1, NULL, '0.00', 'منيل شيحة', NULL, 1),
(122, 'El Mohandseen', 7, NULL, NULL, 1, NULL, '0.00', 'المهندسين', 'Mohandiseen', 1),
(123, 'Kitkat', 7, NULL, NULL, 1, NULL, '0.00', 'الكيت كات', NULL, 1),
(124, 'Heliopolis', 10, NULL, NULL, 1, NULL, '0.00', 'مصر الجديدة', 'Heliopolis', 1),
(125, 'Maadi', 10, NULL, NULL, 1, NULL, '0.00', 'المعادي', 'El Maadi', 1),
(126, 'Tora', 10, NULL, NULL, 1, NULL, '0.00', 'طره', 'Torah', 1),
(127, 'Akhmim', 11, NULL, NULL, 1, NULL, '0.00', 'اخميم', NULL, 1),
(128, 'Ballina', 11, NULL, NULL, 1, NULL, '0.00', 'البلينا', NULL, 1),
(129, 'Maragha', 11, NULL, NULL, 1, NULL, '0.00', 'المراغة', NULL, 1),
(130, 'Mansheya', 11, NULL, NULL, 1, NULL, '0.00', 'المنشية', NULL, 1),
(131, 'Gerga', 11, NULL, NULL, 1, NULL, '0.00', 'جرجا', NULL, 1),
(132, 'Juhayna', 11, NULL, NULL, 1, NULL, '0.00', 'جهينة', NULL, 1),
(133, 'Dar El Salam Masr', 10, NULL, NULL, 1, NULL, '0.00', 'دار السلام مصر', 'Dar El Salam', 1),
(134, 'Saklata ', 11, NULL, NULL, 1, NULL, '0.00', 'ساقلته', NULL, 1),
(135, 'Sohag', 11, NULL, NULL, 1, NULL, '0.00', 'سوهاج', 'sohag City', 1),
(136, 'Tama', 11, NULL, NULL, 1, NULL, '0.00', 'طما', NULL, 1),
(137, 'Taha', 11, NULL, NULL, 1, NULL, '0.00', 'طهطا', NULL, 1),
(138, 'Edfu', 12, NULL, NULL, 1, NULL, '0.00', 'ادفو', NULL, 1),
(139, 'Aswan', 12, NULL, NULL, 1, NULL, '0.00', 'اسوان', 'Aswan', 1),
(140, 'Drau', 12, NULL, NULL, 1, NULL, '0.00', 'دراو', NULL, 1),
(141, 'Kom Ombo', 12, NULL, NULL, 1, NULL, '0.00', 'كوم امبو', NULL, 1),
(142, 'Nubia', 12, NULL, NULL, 1, NULL, '0.00', 'النوبة', NULL, 1),
(143, 'Armant', 13, NULL, NULL, 1, NULL, '0.00', 'ارمنت', NULL, 1),
(144, 'Esna', 13, NULL, NULL, 1, NULL, '0.00', 'اسنا', NULL, 1),
(145, 'Bayadia', 13, NULL, NULL, 1, NULL, '0.00', 'البياضية', NULL, 1),
(146, 'Zinnia', 13, NULL, NULL, 1, NULL, '0.00', 'الزينية', NULL, 1),
(147, 'El Tod ', 13, NULL, NULL, 1, NULL, '0.00', 'الطود', NULL, 1),
(148, 'El Karna', 13, NULL, NULL, 1, NULL, '0.00', 'القرنة', NULL, 1),
(149, 'Luxor', 13, NULL, NULL, 1, NULL, '0.00', 'الاقصر', 'Luxour', 1),
(150, 'Abu Suwair', 14, NULL, NULL, 1, NULL, '0.00', 'ابو صوير', NULL, 1),
(151, 'Ismailia', 14, NULL, NULL, 1, NULL, '0.00', 'الاسماعيلية', 'Ismailia', 1),
(152, 'The big hill', 14, NULL, NULL, 1, NULL, '0.00', 'التل الكبير', NULL, 1),
(153, 'Snipers', 14, NULL, NULL, 1, NULL, '0.00', 'القصاصين', NULL, 1),
(154, 'El Qantara Sharq', 14, NULL, NULL, 1, NULL, '0.00', 'القنطرة شرق', 'El Qantara Sharq', 1),
(155, 'Kantara Gharb', 14, NULL, NULL, 1, NULL, '0.00', 'القنطرة غرب', NULL, 1),
(156, 'Fayed', 14, NULL, NULL, 1, NULL, '0.00', 'فايد', 'Fayid', 1),
(157, 'El Koren', 14, NULL, NULL, 1, NULL, '0.00', 'القرين', NULL, 1),
(158, 'Hurghada', 15, NULL, NULL, 1, NULL, '0.00', 'الغردقة', 'Hurghada', 1),
(159, 'El Kosayr', 15, NULL, NULL, 1, NULL, '0.00', 'القصير', NULL, 1),
(160, 'Ras Gharib', 15, NULL, NULL, 1, NULL, '0.00', 'رأس غارب', 'RAS GHAREB', 1),
(161, 'Safaga', 15, NULL, NULL, 1, NULL, '0.00', 'سفاجا', 'Safaga', 1),
(162, 'Shalatin', 15, NULL, NULL, 1, NULL, '0.00', 'شلاتين', NULL, 1),
(163, 'Halayeb city', 15, NULL, NULL, 1, NULL, '0.00', 'مدينة حلايب', NULL, 1),
(164, 'Marsa Alam', 15, NULL, NULL, 1, NULL, '0.00', 'مرسى علم', 'Marsa Alam', 1),
(165, 'Makadi', 15, NULL, NULL, 1, NULL, '0.00', 'مكادي', NULL, 1),
(166, 'Aboul Matamir', 16, NULL, NULL, 1, NULL, '0.00', 'ابو المطامير', NULL, 1),
(167, 'Abu Homs', 16, NULL, NULL, 1, NULL, '0.00', 'ابو حمص', NULL, 1),
(168, 'ADCO', 16, NULL, NULL, 1, NULL, '0.00', 'ادكو', NULL, 1),
(169, 'El Delngat', 16, NULL, NULL, 1, NULL, '0.00', 'الدلنجات', NULL, 1),
(170, 'Rahmaniyah', 16, NULL, NULL, 1, NULL, '0.00', 'الرحمانية', NULL, 1),
(171, 'Mahmudiyah', 16, NULL, NULL, 1, NULL, '0.00', 'المحمودية', NULL, 1),
(172, 'Itay el Barood', 16, NULL, NULL, 1, NULL, '0.00', 'ايتاي البارود', NULL, 1),
(173, 'Badr City', 10, NULL, NULL, 1, NULL, '0.00', 'مدينة بدر', 'Badr City', 1),
(174, 'Hoosh Essa', 16, NULL, NULL, 1, NULL, '0.00', 'حوش عيسي', NULL, 1),
(175, 'Damanhur', 16, NULL, NULL, 1, NULL, '0.00', 'دمنهور', 'Damanhour', 1),
(176, 'Rashid', 16, NULL, NULL, 1, NULL, '0.00', 'رشيد', NULL, 1),
(177, 'Shaprakhit', 16, NULL, NULL, 1, NULL, '0.00', 'شبراخيت', NULL, 1),
(178, 'Kafr Al Dawwar', 16, NULL, NULL, 1, NULL, '0.00', 'كفر الدوار', NULL, 1),
(179, 'Com hamada', 16, NULL, NULL, 1, NULL, '0.00', 'كوم حمادة', NULL, 1),
(180, 'Wadi El Natroun', 16, NULL, NULL, 1, NULL, '0.00', 'وادي النطرون', 'Wadi El Natroun', 1),
(181, 'Aja', 17, NULL, NULL, 1, NULL, '0.00', 'اجا', NULL, 1),
(182, 'El Gammalia', 17, NULL, NULL, 1, NULL, '0.00', 'الجمالية', NULL, 1),
(183, 'Sinbillawain', 17, NULL, NULL, 1, NULL, '0.00', 'السنبلاوين', NULL, 1),
(184, 'El Matarya', 17, NULL, NULL, 1, NULL, '0.00', 'المطرية', NULL, 1),
(185, 'El Manzala', 17, NULL, NULL, 1, NULL, '0.00', 'المنزلة', NULL, 1),
(186, 'Mansoura', 17, NULL, NULL, 1, NULL, '0.00', 'المنصورة', 'Mansoura', 1),
(187, 'Belqas', 17, NULL, NULL, 1, NULL, '0.00', 'بلقاس', 'Belqas', 1),
(188, 'Bani Ubaid', 17, NULL, NULL, 1, NULL, '0.00', 'بني عبيد', NULL, 1),
(189, 'Tema El Amdeed', 17, NULL, NULL, 1, NULL, '0.00', 'تمي الامديد', NULL, 1),
(190, 'Dikirnis', 17, NULL, NULL, 1, NULL, '0.00', 'دكرنس', NULL, 1),
(191, 'Sherbin', 17, NULL, NULL, 1, NULL, '0.00', 'شربين', NULL, 1),
(192, 'Talkha', 17, NULL, NULL, 1, NULL, '0.00', 'طلخا', NULL, 1),
(193, 'A locality of Dimna', 17, NULL, NULL, 1, NULL, '0.00', 'محلة دمنة', NULL, 1),
(194, 'menyt El Nasr', 17, NULL, NULL, 1, NULL, '0.00', 'منية النصر', NULL, 1),
(195, 'Meet Salsabil ', 17, NULL, NULL, 1, NULL, '0.00', 'ميت سلسبيل', NULL, 1),
(196, 'Meet Ghamr ', 17, NULL, NULL, 1, NULL, '0.00', 'ميت غمر', 'Meet Ghamr', 1),
(197, 'Nebroh', 17, NULL, NULL, 1, NULL, '0.00', 'نبروه', NULL, 1),
(198, 'Gamasa', 17, NULL, NULL, 1, NULL, '0.00', 'جمصة', NULL, 1),
(199, 'Damietta', 27, NULL, NULL, 1, NULL, '0.00', 'دمياط', 'Dumiatta', 1),
(200, 'Abu Hammad', 18, NULL, NULL, 1, NULL, '0.00', 'ابو حماد', NULL, 1),
(201, 'Abu Kabir', 18, NULL, NULL, 1, NULL, '0.00', 'ابو كبير', NULL, 1),
(202, 'Abrahamic', 18, NULL, NULL, 1, NULL, '0.00', 'الابراهيمية', NULL, 1),
(203, 'Hosseinieh', 18, NULL, NULL, 1, NULL, '0.00', 'الحسينية', NULL, 1),
(204, 'Zagazig', 18, NULL, NULL, 1, NULL, '0.00', 'الزقازيق', 'Zakazik', 1),
(205, 'Belbeis', 18, NULL, NULL, 1, NULL, '0.00', 'بلبيس', 'Belbis', 1),
(206, 'Darb Negm', 18, NULL, NULL, 1, NULL, '0.00', 'ديرب نجم', NULL, 1),
(207, 'Faqous', 18, NULL, NULL, 1, NULL, '0.00', 'فاقوس', NULL, 1),
(208, 'Kafr Saqr', 18, NULL, NULL, 1, NULL, '0.00', 'كفر صقر', NULL, 1),
(209, 'Mashtool EL Souq', 18, NULL, NULL, 1, NULL, '0.00', 'مشتول السوق', NULL, 1),
(210, 'Minya EL Kamh', 18, NULL, NULL, 1, NULL, '0.00', 'منيا القمح', NULL, 1),
(211, 'Haya', 18, NULL, NULL, 1, NULL, '0.00', 'ههيا', NULL, 1),
(212, 'El Salehya', 18, NULL, NULL, 1, NULL, '0.00', 'الصالحية', NULL, 1),
(213, 'New Salehya', 18, NULL, NULL, 1, NULL, '0.00', 'الصالحية الجديدة', 'New Salhia', 1),
(214, 'El Kanayat', 18, NULL, NULL, 1, NULL, '0.00', 'القنايات', NULL, 1),
(215, 'Awlad Sakr', 18, NULL, NULL, 1, NULL, '0.00', 'اولاد صقر', NULL, 1),
(216, 'San Hagar ', 18, NULL, NULL, 1, NULL, '0.00', 'صان حجر', NULL, 1),
(217, 'El Santa', 19, NULL, NULL, 1, NULL, '0.00', 'السنطة', NULL, 1),
(218, 'El Mahala EL Kobra ', 19, NULL, NULL, 1, NULL, '0.00', 'المحلة الكبري', 'Al Mahala', 1),
(219, 'Basion', 19, NULL, NULL, 1, NULL, '0.00', 'بسيون', NULL, 1),
(220, 'Zefta', 19, NULL, NULL, 1, NULL, '0.00', 'زفتي', NULL, 1),
(221, 'Samanoud', 19, NULL, NULL, 1, NULL, '0.00', 'سمنود', NULL, 1),
(222, 'Tanta', 19, NULL, NULL, 1, NULL, '0.00', 'طنطا', 'Tanta', 1),
(223, 'Kotor', 19, NULL, NULL, 1, NULL, '0.00', 'قطور', NULL, 1),
(224, 'Kafr El Zayat', 19, NULL, NULL, 1, NULL, '0.00', 'كفر الزيات', NULL, 1),
(225, 'Atsa', 20, NULL, NULL, 1, NULL, '0.00', 'اطسا', NULL, 1),
(226, 'Fayoum', 20, NULL, NULL, 1, NULL, '0.00', 'الفيوم', 'Fayoum', 1),
(227, 'Snores', 20, NULL, NULL, 1, NULL, '0.00', 'سنورس', NULL, 1),
(228, 'Tamiya', 20, NULL, NULL, 1, NULL, '0.00', 'طامية', NULL, 1),
(229, 'Ibshway', 20, NULL, NULL, 1, NULL, '0.00', 'ابشواي', NULL, 1),
(230, 'Yousef El Sedik', 20, NULL, NULL, 1, NULL, '0.00', 'يوسف الصديق', NULL, 1),
(231, 'El Saida Zainab', 10, NULL, NULL, 1, NULL, '0.00', 'السيدة زينب', NULL, 1),
(232, 'El Attaba', 10, NULL, NULL, 1, NULL, '0.00', 'العتبة', 'Attaba', 1),
(233, 'El Kasr El Ainy ', 10, NULL, NULL, 1, NULL, '0.00', 'القصر العينى', 'Kasr El Einy', 1),
(234, 'Manial', 10, NULL, NULL, 1, NULL, '0.00', 'المنيل', 'Manial El Rodah', 1),
(235, 'Wailly', 10, NULL, NULL, 1, NULL, '0.00', 'الوايلي', NULL, 1),
(236, 'Boulaq Abu El-Ela', 10, NULL, NULL, 1, NULL, '0.00', 'بولاق ابو العلا', NULL, 1),
(237, 'Ramses', 10, NULL, NULL, 1, NULL, '0.00', 'رمسيس', 'Ramsis', 1),
(238, 'Ghamra', 10, NULL, NULL, 1, NULL, '0.00', 'غمرة', 'Ghamrah', 1),
(239, 'Kasr El Nile ', 10, NULL, NULL, 1, NULL, '0.00', 'قصر النيل', NULL, 1),
(240, 'Down Town', 10, NULL, NULL, 1, NULL, '0.00', 'وسط البلد', 'Down Town', 1),
(241, 'Banha', 9, NULL, NULL, 1, NULL, '0.00', 'بنها', 'Benha ', 1),
(242, 'Shibin EL Kanater', 9, NULL, NULL, 1, NULL, '0.00', 'شبين القناطر', NULL, 1),
(243, 'Tukh', 9, NULL, NULL, 1, NULL, '0.00', 'طوخ', NULL, 1),
(244, 'Kafr Shukr', 9, NULL, NULL, 1, NULL, '0.00', 'كفر شكر', NULL, 1),
(245, 'Ashmoun', 21, NULL, NULL, 1, NULL, '0.00', 'اشمون', NULL, 1),
(246, 'Bagour', 21, NULL, NULL, 1, NULL, '0.00', 'الباجور', NULL, 1),
(247, 'El Shohada', 21, NULL, NULL, 1, NULL, '0.00', 'الشهداء', NULL, 1),
(248, 'Berkeit EL Sabaa', 21, NULL, NULL, 1, NULL, '0.00', 'بركة السبع', 'Berkeit Sabb', 1),
(249, 'Tala', 21, NULL, NULL, 1, NULL, '0.00', 'تلا', NULL, 1),
(250, 'Shbeen El Koom', 21, NULL, NULL, 1, NULL, '0.00', 'شبين الكوم', 'Shebin El Koum', 1),
(251, 'Quesna', 21, NULL, NULL, 1, NULL, '0.00', 'قويسنا', 'Quesna', 1),
(252, 'Menouf', 21, NULL, NULL, 1, NULL, '0.00', 'منوف', NULL, 1),
(253, 'Sadat City', 21, NULL, NULL, 1, NULL, '0.00', 'مدينة السادات', 'Sadat City', 1),
(254, 'Abu Qurqas', 22, NULL, NULL, 1, NULL, '0.00', 'ابو قرقاص', NULL, 1),
(255, 'El Adwa ', 22, NULL, NULL, 1, NULL, '0.00', 'العدوة', NULL, 1),
(256, 'Minya', 22, NULL, NULL, 1, NULL, '0.00', 'المنيا', 'Menia City', 1),
(257, 'Bani Mazar', 22, NULL, NULL, 1, NULL, '0.00', 'بني مزار', NULL, 1),
(258, 'Deir Mawas', 22, NULL, NULL, 1, NULL, '0.00', 'دير مواس', NULL, 1),
(259, 'Samalut', 22, NULL, NULL, 1, NULL, '0.00', 'سمالوط', NULL, 1),
(260, 'Matai', 22, NULL, NULL, 1, NULL, '0.00', 'مطاي', NULL, 1),
(261, 'Maghaghah', 22, NULL, NULL, 1, NULL, '0.00', 'مغاغة', NULL, 1),
(262, 'Malawi', 22, NULL, NULL, 1, NULL, '0.00', 'ملاوي', NULL, 1),
(263, 'El Kharga', 23, NULL, NULL, 1, NULL, '0.00', 'الخارجة', NULL, 1),
(264, 'Dakhla', 23, NULL, NULL, 1, NULL, '0.00', 'الداخلة', NULL, 1),
(265, 'Farafra', 23, NULL, NULL, 1, NULL, '0.00', 'الفرافرة', NULL, 1),
(266, 'Paris', 23, NULL, NULL, 1, NULL, '0.00', 'باريس', NULL, 1),
(267, 'Balat', 23, NULL, NULL, 1, NULL, '0.00', 'بلاط', NULL, 1),
(268, 'Al Fashn', 24, NULL, NULL, 1, NULL, '0.00', 'الفشن', NULL, 1),
(269, 'Al-Wasiti', 24, NULL, NULL, 1, NULL, '0.00', 'الواسطى', NULL, 1),
(270, 'BPA', 24, NULL, NULL, 1, NULL, '0.00', 'ببا', NULL, 1),
(271, 'Bani Suef', 24, NULL, NULL, 1, NULL, '0.00', 'بني سويف', 'Bani Swif', 1),
(272, 'Sumasta', 24, NULL, NULL, 1, NULL, '0.00', 'سمسطا', NULL, 1),
(273, 'Naser', 24, NULL, NULL, 1, NULL, '0.00', 'ناصر', NULL, 1),
(274, 'Hanasia', 24, NULL, NULL, 1, NULL, '0.00', 'هناسيا', NULL, 1),
(275, 'Port Said', 25, NULL, NULL, 1, NULL, '0.00', 'بور سعيد', 'Port Said', 1),
(276, 'Port Fouad', 25, NULL, NULL, 1, NULL, '0.00', 'مدينة بورفؤاد', NULL, 1),
(277, 'Abu Redis', 26, NULL, NULL, 1, NULL, '0.00', 'ابو رديس', NULL, 1),
(278, 'Abu Zenimah', 26, NULL, NULL, 1, NULL, '0.00', 'ابو زنيمة', NULL, 1),
(279, 'El Tor', 26, NULL, NULL, 1, NULL, '0.00', 'الطور', 'Al Tour City', 1),
(280, 'Dahab', 26, NULL, NULL, 1, NULL, '0.00', 'دهب', 'Dahab City', 1),
(281, 'Ras Sidr', 26, NULL, NULL, 1, NULL, '0.00', 'رأس سدر', 'Ras Seidr', 1),
(282, 'Saint Catherine', 26, NULL, NULL, 1, NULL, '0.00', 'سانت كاترين', NULL, 1),
(283, 'Sharm El Sheikh', 26, NULL, NULL, 1, NULL, '0.00', 'شرم الشيخ', 'Sharm El Sheikh', 1),
(284, 'Taba', 26, NULL, NULL, 1, NULL, '0.00', 'طابا', 'Taba City', 1),
(285, 'Nuweiba', 26, NULL, NULL, 1, NULL, '0.00', 'نويبع', 'Nuwibaa', 1),
(286, 'El Zarka ', 27, NULL, NULL, 1, NULL, '0.00', 'الزرقا', NULL, 1),
(287, 'Faraskur', 27, NULL, NULL, 1, NULL, '0.00', 'فارسكور', NULL, 1),
(288, 'Kafr EL Batekh', 27, NULL, NULL, 1, NULL, '0.00', 'كفر البطيخ', NULL, 1),
(289, 'Kafr Saad', 27, NULL, NULL, 1, NULL, '0.00', 'كفر سعد', NULL, 1),
(290, 'Ras El Bar ', 27, NULL, NULL, 1, NULL, '0.00', 'رأس البر', NULL, 1),
(291, 'El Hosna', 28, NULL, NULL, 1, NULL, '0.00', 'الحسنة', NULL, 1),
(292, 'Sheikh Zuwayed', 28, NULL, NULL, 1, NULL, '0.00', 'الشيخ زويد', NULL, 1),
(293, 'Bir al-Abed', 28, NULL, NULL, 1, NULL, '0.00', 'بئر العبد', NULL, 1),
(294, 'Rafah', 28, NULL, NULL, 1, NULL, '0.00', 'رفح', 'Rafah', 1),
(295, 'Nakhl', 28, NULL, NULL, 1, NULL, '0.00', 'نخل', NULL, 1),
(296, 'Abu Tisht', 29, NULL, NULL, 1, NULL, '0.00', 'ابو تشت', NULL, 1),
(297, 'El Wakf', 29, NULL, NULL, 1, NULL, '0.00', 'الوقف', NULL, 1),
(298, 'Deshna', 29, NULL, NULL, 1, NULL, '0.00', 'دشنا', NULL, 1),
(299, 'Farshout', 29, NULL, NULL, 1, NULL, '0.00', 'فرشوط', NULL, 1),
(300, 'Kaft', 29, NULL, NULL, 1, NULL, '0.00', 'قفط', NULL, 1),
(301, 'Qena', 29, NULL, NULL, 1, NULL, '0.00', 'قنا', 'Qena', 1),
(302, 'Kos ', 29, NULL, NULL, 1, NULL, '0.00', 'قوص', NULL, 1),
(303, 'Nagaa Hammadi', 29, NULL, NULL, 1, NULL, '0.00', 'نجع حمادي', 'Nag Hamadi', 1),
(304, 'Nekada', 29, NULL, NULL, 1, NULL, '0.00', 'نقادة', NULL, 1),
(305, 'Burullus', 30, NULL, NULL, 1, NULL, '0.00', 'البرلس', NULL, 1),
(306, 'EL Hamol', 30, NULL, NULL, 1, NULL, '0.00', 'الحامول', NULL, 1),
(307, 'Riyadh', 30, NULL, NULL, 1, NULL, '0.00', 'الرياض', NULL, 1),
(308, 'Bella', 30, NULL, NULL, 1, NULL, '0.00', 'بيلا', NULL, 1),
(309, 'Desouk', 30, NULL, NULL, 1, NULL, '0.00', 'دسوق', 'Desouk', 1),
(310, 'Sidi salem', 30, NULL, NULL, 1, NULL, '0.00', 'سيدي سالم', NULL, 1),
(311, 'Fooh', 30, NULL, NULL, 1, NULL, '0.00', 'فوه', NULL, 1),
(312, 'Celine', 30, NULL, NULL, 1, NULL, '0.00', 'قلين', NULL, 1),
(313, 'Kafr Al Sheikh', 30, NULL, NULL, 1, NULL, '0.00', 'كفر الشيخ', 'Kafr Al Sheikh', 1),
(314, 'Matbos', 30, NULL, NULL, 1, NULL, '0.00', 'مطوبس', NULL, 1),
(315, 'Baltim', 30, NULL, NULL, 1, NULL, '0.00', 'بلطيم', NULL, 1),
(316, 'Marsa Matrouh', 31, NULL, NULL, 1, NULL, '0.00', 'مرسي مطروح', 'Marsa Matrouh', 1),
(317, 'El Hamam', 31, NULL, NULL, 1, NULL, '0.00', 'الحمام', NULL, 1),
(318, 'El Alamein', 31, NULL, NULL, 1, NULL, '0.00', 'العلمين', NULL, 1),
(319, 'Ras El Hikma - El Dabaa', 31, NULL, NULL, 1, NULL, '0.00', 'رأس الحكمة - الضبعة', NULL, 1),
(320, 'Sidi Abdul Rahman', 31, NULL, NULL, 1, NULL, '0.00', 'سيدي عبد الرحمن', NULL, 1),
(321, 'Zamalek', 10, NULL, NULL, 1, NULL, '0.00', 'الزمالك', 'Zamalek', 1),
(322, 'El Basaten', 10, NULL, NULL, 1, NULL, '0.00', 'البساتين', NULL, 1),
(323, 'Misr El Qadima', 10, NULL, NULL, 1, NULL, '0.00', 'مصر القديمة', NULL, 1),
(324, 'Monib', 7, NULL, NULL, 1, NULL, '0.00', 'المنيب', 'Al Monib', 1),
(325, 'Sakyt Mekki', 7, NULL, NULL, 1, NULL, '0.00', 'ساقية مكي', NULL, 1),
(328, 'El Zaitoun', 10, NULL, NULL, 1, NULL, '0.00', 'الزيتون', 'El Zeitoun', 1),
(329, 'Hadayek El Koba', 10, NULL, NULL, 1, NULL, '0.00', 'حدائق القبة', 'Hadayek El Qobah', 1),
(331, 'New Administrative Capital', 10, NULL, NULL, 1, NULL, '0.00', 'العاصمة الإدارية الجديدة', 'New Capital City', 1),
(332, 'Madinaty', 10, NULL, NULL, 1, NULL, '0.00', 'مدينتي', 'Madinaty', 1),
(333, 'Helwan', 10, NULL, NULL, 1, NULL, '0.00', 'حلوان', 'Helwan', 1),
(334, '15th of May City', 10, NULL, '2021-09-12 15:46:56', 1, NULL, '0.00', 'مدينة 15 مايو', '15 Of May City', 2),
(335, 'El Tebin', 10, NULL, NULL, 1, NULL, '0.00', 'التبين', 'Tebin', 1),
(336, 'Abnoub', 32, NULL, NULL, 1, NULL, '0.00', 'ابنوب', NULL, 1),
(337, 'Abu Tig', 32, NULL, NULL, 1, NULL, '0.00', 'ابو تيج', NULL, 1),
(338, 'Assiut', 32, NULL, NULL, 1, NULL, '0.00', 'اسيوط', 'Assiut', 1),
(339, 'Badari', 32, NULL, NULL, 1, NULL, '0.00', 'البداري', NULL, 1),
(340, 'El Ghanaym', 32, NULL, NULL, 1, NULL, '0.00', 'الغنايم', NULL, 1),
(341, 'El Fath', 32, NULL, NULL, 1, NULL, '0.00', 'الفتح', NULL, 1),
(342, 'The Qusiyyah', 32, NULL, NULL, 1, NULL, '0.00', 'القوصية', NULL, 1),
(343, 'Dairut', 32, NULL, NULL, 1, NULL, '0.00', 'ديروط', NULL, 1),
(344, 'Sahel Selim', 32, NULL, NULL, 1, NULL, '0.00', 'ساحل سليم', NULL, 1),
(345, 'Sadfa', 32, NULL, NULL, 1, NULL, '0.00', 'صدفا', NULL, 1),
(346, 'Manfalut', 32, NULL, NULL, 1, NULL, '0.00', 'منفلوط', NULL, 1),
(347, 'El Arbeen', 33, NULL, NULL, 1, NULL, '0.00', 'الاربعين', NULL, 1),
(348, 'El Ganayn', 33, NULL, NULL, 1, NULL, '0.00', 'الجناين', NULL, 1),
(349, 'Suez', 33, NULL, NULL, 1, NULL, '0.00', 'السويس', 'Suez', 1),
(350, 'Ain Sokhna', 33, NULL, NULL, 1, NULL, '0.00', 'العين السخنة', NULL, 1),
(351, 'Ataka', 33, NULL, NULL, 1, NULL, '0.00', 'عتاقة', NULL, 1),
(352, 'El Marg', 10, NULL, NULL, 1, NULL, '0.00', 'المرج', 'El Marg', 1),
(353, 'New Nozha', 10, NULL, NULL, 1, NULL, '0.00', 'النزهة الجديدة', NULL, 1),
(354, 'Last Gesr El Suez', 10, NULL, NULL, 1, NULL, '0.00', 'آخر جسر السويس', NULL, 1),
(355, 'Karam Towers - the pearl of Muharram Bey', 8, NULL, NULL, 1, NULL, '0.00', 'ابراج كرام - لؤلؤة محرم بك', NULL, 1),
(356, 'Alexandria Matrouh', 8, NULL, NULL, 1, NULL, '0.00', 'اسكندرية مطروح', NULL, 1),
(357, 'Abu Qir', 8, NULL, NULL, 1, NULL, '0.00', 'ابو قير', NULL, 1),
(358, 'Apis', 8, NULL, NULL, 1, NULL, '0.00', 'ابيس', NULL, 1),
(359, 'Ard El Mahamara ', 8, NULL, NULL, 1, NULL, '0.00', 'ارض المحمرة', NULL, 1),
(360, 'El Hadra', 8, NULL, NULL, 1, NULL, '0.00', 'الحضرة', NULL, 1),
(361, 'El Dkhela', 8, NULL, NULL, 1, NULL, '0.00', 'الدخيلة', NULL, 1),
(362, 'Ras El Sawdaa', 8, NULL, NULL, 1, NULL, '0.00', 'الراس السوداء', 'Awaied-Ras Souda', 1),
(363, 'El Raml El Mery ', 8, NULL, NULL, 1, NULL, '0.00', 'الرمل الميري', NULL, 1),
(364, 'El Saa', 8, NULL, NULL, 1, NULL, '0.00', 'الساعة', NULL, 1),
(365, 'El Saraya', 8, NULL, NULL, 1, NULL, '0.00', 'السرايا', NULL, 1),
(366, 'Waterfalls', 8, NULL, NULL, 1, NULL, '0.00', 'الشلالات', NULL, 1),
(367, 'El Daherya', 8, NULL, NULL, 1, NULL, '0.00', 'الضاهرية', NULL, 1),
(368, 'El Talbia', 8, NULL, NULL, 1, NULL, '0.00', 'الطابية', NULL, 1),
(369, 'Bab Sahrk', 8, NULL, NULL, 1, NULL, '0.00', 'باب شرق', NULL, 1),
(370, 'Patrice Lumumba', 8, NULL, NULL, 1, NULL, '0.00', 'باتريس لومومبا', NULL, 1),
(371, 'Backus', 8, NULL, NULL, 1, NULL, '0.00', 'باكوس', NULL, 1),
(372, 'Bani Abbas', 8, NULL, NULL, 1, NULL, '0.00', 'بني العباس', NULL, 1),
(373, 'Tharwat', 8, NULL, NULL, 1, NULL, '0.00', 'ثروت', NULL, 1),
(374, 'Army Road', 8, NULL, NULL, 1, NULL, '0.00', 'طريق الجيش', NULL, 1),
(375, 'Ganaklis', 8, NULL, NULL, 1, NULL, '0.00', 'جناكليس', NULL, 1),
(376, 'El Nawatya Stone ', 8, NULL, NULL, 1, NULL, '0.00', 'حجر النواتية', NULL, 1),
(377, 'El Mohandseen District ', 8, NULL, NULL, 1, NULL, '0.00', 'حى المهندسين', NULL, 1),
(378, 'Khurshid', 8, NULL, NULL, 1, NULL, '0.00', 'خورشيد', NULL, 1),
(379, 'Zananery', 8, NULL, NULL, 1, NULL, '0.00', 'زنانيري', NULL, 1),
(380, 'Sutter', 8, NULL, NULL, 1, NULL, '0.00', 'سوتر', NULL, 1),
(381, 'Sidi Beshr Qebly ', 8, NULL, NULL, 1, NULL, '0.00', 'سيدي بشر قبلي', NULL, 1),
(382, 'Seuf', 8, NULL, NULL, 1, NULL, '0.00', 'سيوف', NULL, 1),
(383, 'Schutz - shoots', 8, NULL, NULL, 1, NULL, '0.00', 'شدس - شوتس', NULL, 1),
(384, 'Tamazen', 8, NULL, NULL, 1, NULL, '0.00', 'طمازين', NULL, 1),
(385, 'Toson', 8, NULL, NULL, 1, NULL, '0.00', 'طوسون', NULL, 1),
(386, 'Ezbet El Eahmanya', 8, NULL, NULL, 1, NULL, '0.00', 'عزبة الرحمانية', NULL, 1),
(387, 'Ezbet Hijazi', 8, NULL, NULL, 1, NULL, '0.00', 'عزبة حجازي', NULL, 1),
(388, 'Ankh Amoun', 8, NULL, NULL, 1, NULL, '0.00', 'عنخ امون', NULL, 1),
(389, 'Gabriel', 8, NULL, NULL, 1, NULL, '0.00', 'غبريال', NULL, 1),
(390, 'Ghet El Enab', 8, NULL, NULL, 1, NULL, '0.00', 'غيط العنب', NULL, 1),
(391, 'Fleming', 8, NULL, NULL, 1, NULL, '0.00', 'فلمنج', NULL, 1),
(392, 'Victoria', 8, NULL, NULL, 1, NULL, '0.00', 'فيكتوريا', NULL, 1),
(393, 'Karmoz', 8, NULL, NULL, 1, NULL, '0.00', 'كرموز', NULL, 1),
(394, 'Kafr Abdo', 8, NULL, NULL, 1, NULL, '0.00', 'كفر عبده', NULL, 1),
(395, 'Kafr Ashry', 8, NULL, NULL, 1, NULL, '0.00', 'كفر عشري', NULL, 1),
(396, 'El Namoos Bridge', 8, NULL, NULL, 1, NULL, '0.00', 'كوبري الناموس', NULL, 1),
(397, 'Kom El Dakka ', 8, NULL, NULL, 1, NULL, '0.00', 'كوم الدكة', NULL, 1),
(398, 'Kom el Shoqafa', 8, NULL, NULL, 1, NULL, '0.00', 'كوم الشقافة', NULL, 1),
(399, 'Lauran', 8, NULL, NULL, 1, NULL, '0.00', 'لوران', NULL, 1),
(400, 'Muharram Bek', 8, NULL, NULL, 1, NULL, '0.00', 'محرم بك', NULL, 1),
(401, 'Egypt Station', 8, NULL, NULL, 1, NULL, '0.00', 'محطة مصر', NULL, 1),
(402, 'El Tameer Axis ', 8, NULL, NULL, 1, NULL, '0.00', 'محور التعمير', NULL, 1),
(403, 'Nozha Airport - Iskander Airport', 8, NULL, NULL, 1, NULL, '0.00', 'مطار النزهة - مطار اسكندر', NULL, 1),
(404, 'Manshiet El-Nozha', 8, NULL, NULL, 1, NULL, '0.00', 'منشية النزهة', NULL, 1),
(405, 'Mina El Basal', 8, NULL, NULL, 1, NULL, '0.00', 'مينا البصل', NULL, 1),
(406, 'Wabour El Maya', 8, NULL, NULL, 1, NULL, '0.00', 'وابور المياه', NULL, 1),
(407, 'Winget ', 8, NULL, NULL, 1, NULL, '0.00', 'ونجت', NULL, 1),
(408, 'Mokattam', 10, NULL, NULL, 1, NULL, '0.00', 'المقطم', 'Mokattam', 1),
(409, 'Shubra Masr', 10, NULL, NULL, 1, NULL, '0.00', 'شبرا مصر', 'Shubra', 1),
(410, 'Khanka', 9, NULL, NULL, 1, NULL, '0.00', 'الخانكة', 'Khanka', 1),
(411, 'El Qanater El Khairya ', 9, NULL, NULL, 1, NULL, '0.00', 'القناطر الخيرية', 'AL Qanater', 1),
(412, 'Abu Zaabal', 9, NULL, NULL, 1, NULL, '0.00', 'ابو زعبل', 'Abu Zaabal', 1),
(413, 'EL Gabal El Asfar', 9, NULL, NULL, 1, NULL, '0.00', 'الجبل الاصفر', NULL, 1),
(414, 'El Khosos', 9, NULL, NULL, 1, NULL, '0.00', 'الخصوص', NULL, 1),
(415, 'Al Qalq', 9, NULL, NULL, 1, NULL, '0.00', 'القلج', NULL, 1),
(416, 'El Mania ', 9, NULL, NULL, 1, NULL, '0.00', 'المنية', NULL, 1),
(417, 'Syriacus', 9, NULL, NULL, 1, NULL, '0.00', 'سرياقوس', NULL, 1),
(418, 'Shubra El Kheima', 9, NULL, NULL, 1, NULL, '0.00', 'شبرا الخيمة', 'Shubra El Kheima', 1),
(419, 'Inundation', 10, NULL, NULL, 1, NULL, '0.00', 'غمرة', NULL, 1),
(420, 'Qalioub', 9, NULL, NULL, 1, NULL, '0.00', 'قليوب', 'Qalioub', 1),
(421, 'El Zawia El Hamra ', 10, NULL, NULL, 1, NULL, '0.00', 'الزاوية الحمراء', NULL, 1),
(422, 'Sidi Abd El Rahman', 31, NULL, NULL, 1, NULL, '0.00', 'سيدي عبد الرحمن', NULL, 1),
(423, 'Suez Road', 10, NULL, NULL, 1, NULL, '0.00', 'طريق السويس', NULL, 1),
(424, 'Sheraton', 10, NULL, NULL, 1, NULL, '0.00', 'شيراتون', NULL, 1),
(425, 'Ain Shams', 10, NULL, NULL, 1, NULL, '0.00', 'عين شمس', 'Ain Shams', 1),
(426, 'El Salam City ', 10, NULL, NULL, 1, NULL, '0.00', 'مدينة السلام', 'El Salam City', 1),
(427, 'Ezbet EL Nakhl', 9, NULL, NULL, 1, NULL, '0.00', 'عزبة النخل', NULL, 1),
(428, 'Kafr Shurafa', 9, NULL, NULL, 1, NULL, '0.00', 'كفر الشرفاء', NULL, 1),
(429, 'El Shrouk City', 10, NULL, NULL, 1, NULL, '0.00', 'مدينة الشروق', 'Al Shorouk', 1),
(430, 'Al-Ahram Gardens - Hadabet EL Haram', 7, NULL, NULL, 1, NULL, '0.00', 'حدائق الاهرام - هضبة الهر', NULL, 1),
(431, 'El Remaya ', 7, NULL, NULL, 1, NULL, '0.00', 'الرماية', NULL, 1),
(432, 'El Matarya', 10, NULL, NULL, 1, NULL, '0.00', 'المطرية', 'Al Matarya', 1),
(502, 'Abo Rawash', 7, NULL, NULL, 1, NULL, '0.00', 'ابو رواش', 'Abo Rawash', 1),
(503, 'Bargiel', 7, NULL, NULL, 1, NULL, '0.00', 'براجيل', 'Bargiel', 1),
(504, 'El Korimat', 7, NULL, NULL, 1, NULL, '0.00', 'الكريمات', 'EL Korimat', 1),
(505, 'Maraqia', 8, NULL, NULL, 1, NULL, '0.00', 'مارقيا', 'Maraqia', 1),
(506, 'Sedi Kreir', 8, NULL, NULL, 1, NULL, '0.00', 'سيدى كرير', 'Sedi Kreir', 1),
(507, 'Obour City', 9, NULL, NULL, 1, NULL, '0.00', 'مدينة العبور', 'Al Obour City', 1),
(508, 'Bahtem', 9, NULL, NULL, 1, NULL, '0.00', 'بهتيم', 'Bahtem', 1),
(509, 'Beigam', 9, NULL, NULL, 1, NULL, '0.00', 'بيجام', 'Beigam', 1),
(510, 'Kaha', 9, NULL, NULL, 1, NULL, '0.00', 'قها', 'Kaha', 1),
(511, 'Qaliubia', 9, NULL, NULL, 1, NULL, '0.00', 'القليوبية', 'Qaliubia', 1),
(512, 'Abasya', 10, NULL, NULL, 1, NULL, '0.00', 'العباسية', 'Abasya', 1),
(513, 'Cairo Suez Desert Rd', 10, NULL, NULL, 1, NULL, '0.00', 'طريق السويس الصحراوي', NULL, 1),
(514, 'Garden City', 10, NULL, NULL, 1, NULL, '0.00', 'جاردن سيتي', 'Garden City', 1),
(515, 'Cornish El Nile', 10, NULL, NULL, 1, NULL, '0.00', 'كورنيش النيل', NULL, 1),
(516, 'El Rehab', 10, NULL, NULL, 1, NULL, '0.00', 'الرحاب', 'EL rehab', 1),
(517, 'El Sawah', 10, NULL, NULL, 1, NULL, '0.00', 'السواح', 'EL SAWAH', 1),
(518, 'Mansheyt Naser', 10, NULL, NULL, 1, NULL, '0.00', 'منشية ناصر', 'Mansheyt Naser', 1),
(519, 'Moustorod', 10, NULL, NULL, 1, NULL, '0.00', 'مسطرد', 'Moustorod', 1),
(520, 'New Cairo', 10, NULL, NULL, 1, NULL, '0.00', 'القاهرة الجديدة', 'New Cairo', 1),
(521, 'El Gouna', 15, NULL, NULL, 1, NULL, '0.00', 'الجونة', 'EL GOUNA', 1),
(522, 'Ras Shokeir', 15, NULL, NULL, 1, NULL, '0.00', 'رأس شقير', 'Ras Shoqeir', 1),
(523, '10th of Ramadan City', 18, NULL, NULL, 1, NULL, '0.00', 'مدينة العاشر من رمضان', '10Th Of Ramadan City', 1),
(524, 'Inshas', 18, NULL, NULL, 1, NULL, '0.00', 'انشاص', 'Inshas', 1),
(525, 'New Valley', 23, NULL, NULL, 1, NULL, '0.00', 'الوادى الجديد', 'El Wadi El Gadid', 1),
(526, 'Toshka', 23, NULL, NULL, 1, NULL, '0.00', 'توشكى', 'Toshka', 1),
(527, 'Marabella', 8, NULL, NULL, 1, NULL, '0.00', 'ماربيلا', 'Marabella', 1),
(528, 'Marinah', 31, NULL, NULL, 1, NULL, '0.00', 'مارينا', 'Marinah', 1),
(529, 'Alexandria', 8, NULL, NULL, 1, NULL, '0.00', 'الاسكندرية', 'Alexandria', 1),
(530, 'El Arish', 28, NULL, NULL, 1, NULL, '0.00', 'العريش', 'Al Arish', 1),
(531, 'Borg Al Arab', 8, NULL, NULL, 1, NULL, '0.00', 'برج العرب', 'Borg Al Arab City', 1),
(532, 'Al Marg', 9, NULL, NULL, 1, NULL, '0.00', 'المرج', 'Al Marg', 1),
(533, 'El Ain Sokhna', 33, NULL, NULL, 1, NULL, '0.00', 'العين السخنة', 'Ein Al Sukhna', 1),
(534, 'El Giza', 7, NULL, NULL, 1, NULL, '0.00', 'الجيزة', 'Giza', 1),
(535, 'High Dam', 12, NULL, NULL, 1, NULL, '0.00', 'السد العالى', 'High Dam', 1),
(536, 'El Menoufia', 21, NULL, NULL, 1, NULL, '0.00', 'المنوفية', 'Al Menofiah', 1),
(537, 'El Nobaria', 16, NULL, NULL, 1, NULL, '0.00', 'النوباريه', 'Al Nobariah', 1),
(538, 'Abu Simbel', 12, NULL, NULL, 1, NULL, '0.00', 'ابو سمبل', 'ABOU SOMBO', 1),
(539, 'Siwa', 31, NULL, NULL, 1, NULL, '0.00', 'سيوة', 'Siwa', 1),
(540, 'testarea', 83, '2021-09-02 17:39:59', '2021-09-09 12:52:43', 1, NULL, '10.00', 'testarea', NULL, 1),
(541, 'dsad', 110, '2021-09-07 15:56:44', '2021-09-07 16:05:16', 1, NULL, '12.00', 'dasdsa', NULL, 1),
(542, 'test 20 mra action', 112, '2021-09-07 16:21:12', '2021-09-07 16:21:46', 1, NULL, '951.00', 'test 20 mra action', NULL, 1),
(543, 'TEST AREA', 113, '2021-09-08 15:12:53', '2021-09-08 15:12:53', 1, NULL, '0.00', 'TEST AREA', NULL, 1),
(544, 'NEW TEST AREA', 114, '2021-09-09 12:44:33', '2021-09-09 12:44:33', 1, NULL, '0.00', 'NEW TEST AREA', NULL, 1),
(545, 'new test area', 83, '2021-09-09 13:03:27', '2021-09-09 13:03:27', 1, NULL, '0.00', 'new test area', NULL, 1),
(546, 'new test area', 83, '2021-09-09 13:03:29', '2021-09-09 13:03:29', 1, NULL, '0.00', 'new test area', NULL, 1),
(547, '12', 84, '2021-09-09 14:39:48', '2021-09-09 14:39:48', 1, NULL, '0.00', '12', NULL, 1),
(548, 'area', 117, '2021-09-28 09:53:42', '2021-09-28 09:53:42', 1, NULL, '0.00', 'area', 'test', 1),
(549, 'area2', 117, '2021-09-28 09:59:50', '2021-09-28 10:01:17', 1, NULL, '90.00', 'area2', NULL, 1),
(550, 'test', 117, '2021-09-29 09:56:25', '2021-09-29 09:57:19', 0, 'test', '20.00', 'test', NULL, 1),
(551, 'test', 109, '2021-10-04 15:05:28', '2021-10-04 15:05:28', 1, NULL, '0.00', 'test', NULL, 1),
(552, 'testt', 109, '2021-10-06 10:28:17', '2021-10-06 10:28:17', 1, NULL, NULL, 'test', NULL, 1),
(553, 'testsss', 109, '2021-10-06 10:39:49', '2021-10-06 10:39:49', 1, NULL, NULL, 'testsss', NULL, 1),
(554, '878787', 118, '2021-10-06 15:00:08', '2021-10-06 15:02:03', 1, NULL, '40.00', '87878787', NULL, 1),
(555, 'area', 104, '2021-10-10 09:18:07', '2021-10-10 12:19:25', 1, NULL, NULL, 'area', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `black_ip_list`
--

CREATE TABLE `black_ip_list` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ip` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` int(10) UNSIGNED NOT NULL,
  `shop_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shop_name_ar` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `address_ar` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `area` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `area_ar` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lat` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lng` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direction_link` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 1,
  `images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`images`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name_ar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `created_at`, `updated_at`, `name_ar`, `image`, `status`) VALUES
(8695, 'DAVIDOFF', '2021-11-21 11:02:56', '2021-11-21 11:19:56', 'DAVIDOFF', 'https://mansourgroupapi.el-dokan.com/storage/uploads/davidoff-gold-550x550h-1637486379.jpeg', NULL),
(8696, 'TARGET', '2021-11-21 11:20:26', '2021-11-21 11:20:26', 'TARGET', 'https://mansourgroupapi.el-dokan.com/storage/uploads/target-extra-biue-2090x3223-1637486410.jpeg', NULL),
(8697, 'TIME', '2021-11-21 11:26:45', '2021-11-21 11:26:45', 'TIME', 'https://mansourgroupapi.el-dokan.com/storage/uploads/time-red-550x550-1637486798.jpeg', NULL),
(8698, 'BIC Tray', '2021-12-15 18:31:28', '2021-12-15 18:31:28', 'BIC Tray', 'https://mansourgroupapi.el-dokan.com/storage/uploads/Slide1-1639585880.JPG', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `created_at`, `updated_at`) VALUES
(67, 1000014, '2022-08-03 16:46:39', '2022-08-03 16:46:39'),
(68, 1000006, '2022-08-03 18:55:24', '2022-08-03 18:55:24'),
(69, 1000005, '2022-08-03 21:42:30', '2022-08-03 21:42:30'),
(70, 1000022, '2022-08-04 00:43:38', '2022-08-04 00:43:38'),
(82, 1000020, '2022-08-06 14:25:44', '2022-08-06 14:25:44'),
(84, 1000017, '2022-08-07 11:07:48', '2022-08-07 11:07:48'),
(85, 1000007, '2022-08-08 11:41:36', '2022-08-08 11:41:36'),
(87, 1000023, '2022-08-08 14:01:23', '2022-08-08 14:01:23'),
(92, 1000019, '2022-08-09 16:53:15', '2022-08-09 16:53:15'),
(98, 1000008, '2022-08-16 11:48:23', '2022-08-16 11:48:23'),
(103, 1000011, '2022-08-21 17:30:05', '2022-08-21 17:30:05');

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `cart_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `amount` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (`id`, `cart_id`, `product_id`, `amount`, `created_at`, `updated_at`) VALUES
(191, 68, 8, '2.00', '2022-08-03 18:55:24', '2022-08-03 18:55:30'),
(192, 69, 8, '1.50', '2022-08-03 21:42:30', '2022-08-10 15:45:05'),
(194, 70, 8, '2.00', '2022-08-04 00:43:38', '2022-08-04 00:43:49'),
(195, 67, 8, '2.00', '2022-08-04 03:22:20', '2022-08-04 03:24:14'),
(207, 68, 10, '2.00', '2022-08-04 18:46:22', '2022-08-04 18:48:04'),
(223, 67, 10, '2.00', '2022-08-06 14:34:34', '2022-08-06 14:35:04'),
(232, 67, 22, '1.00', '2022-08-08 00:27:11', '2022-08-09 11:18:42'),
(246, 87, 8, '21.50', '2022-08-09 14:22:06', '2022-08-10 01:25:13'),
(251, 92, 8, '2.00', '2022-08-09 16:53:15', '2022-08-14 00:47:32'),
(263, 87, 168, '2.50', '2022-08-12 23:18:20', '2022-08-12 23:18:54'),
(277, 82, 8, '2.00', '2022-08-13 21:22:07', '2022-08-13 21:22:12'),
(286, 98, 8, '5.00', '2022-08-16 11:48:23', '2022-08-16 11:48:34'),
(317, 67, 168, '1.00', '2022-09-08 16:56:24', '2022-09-08 16:56:47');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `deactivation_notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `name_ar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description_ar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ex_rate_pts` int(11) DEFAULT NULL,
  `ex_rate_egp` int(11) DEFAULT NULL,
  `payment_target` decimal(8,2) DEFAULT NULL,
  `family_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `parent_id`, `created_at`, `updated_at`, `image`, `created_by`, `active`, `deactivation_notes`, `order`, `name_ar`, `description_ar`, `slug`, `ex_rate_pts`, `ex_rate_egp`, `payment_target`, `family_id`) VALUES
(1, 'West', NULL, NULL, '2022-03-28 12:06:43', '2022-10-30 09:26:45', 'http://104.46.33.250/storage/uploads/360_F_262035364_gGi8uJsPl9uljis8C6oxI0w6AM7MKDLq-1648978133.jpeg', NULL, 1, NULL, 102, 'ويست', NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'Davidoff Evolve', NULL, NULL, '2022-03-28 12:06:43', '2022-10-30 09:26:45', 'http://104.46.33.250/storage/uploads/1464439_240-1656832143.jpg', NULL, 1, NULL, 8, 'دافيدوف ايفولف', NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'Davidoff Evolve', NULL, 3, '2022-03-28 12:06:43', '2022-07-24 11:36:32', 'http://104.46.33.250/storage/uploads/EV_Blue_V4-1649143710.png', NULL, 1, NULL, 8, 'دافيدوف ايفولف', NULL, NULL, 100, 15860, NULL, 45),
(5, 'Davidoff', NULL, NULL, '2022-03-28 12:06:43', '2022-10-30 09:26:46', 'http://104.46.33.250/storage/uploads/w1v4-1649143607.png', NULL, 1, NULL, 0, 'دافيدوف', NULL, NULL, NULL, NULL, NULL, NULL),
(7, 'Davidoff', NULL, NULL, '2022-03-28 12:06:43', '2022-10-30 09:26:48', 'http://104.46.33.250/storage/uploads/012210233-1656832163.gif', NULL, 1, NULL, 9, 'دافيدوف', NULL, NULL, NULL, NULL, NULL, NULL),
(8, 'Davidoff', NULL, 7, '2022-03-28 12:06:43', '2022-07-03 08:59:58', 'http://104.46.33.250/storage/uploads/w1v4-1649143978.png', NULL, 1, NULL, 104, 'دافيدوف', NULL, NULL, 150, 22785, NULL, 40),
(9, 'Gauloises', NULL, NULL, '2022-03-28 12:06:43', '2022-10-30 09:26:48', NULL, NULL, 1, NULL, 0, 'جولواز', NULL, NULL, NULL, NULL, NULL, NULL),
(11, 'Target Extra', NULL, NULL, '2022-03-28 12:06:43', '2022-10-30 09:26:49', 'http://104.46.33.250/storage/uploads/Target-Logo-png-hd-1656832188.png', NULL, 1, NULL, 6, 'تارجت اكسترا', NULL, NULL, NULL, NULL, NULL, NULL),
(12, 'Target Extra', NULL, 11, '2022-03-28 12:06:43', '2022-07-03 08:59:58', 'http://104.46.33.250/storage/uploads/Packs-1649144023.png', NULL, 1, NULL, 0, 'تارجت اكسترا', NULL, NULL, 50, 10250, NULL, 60),
(13, 'Lighters', NULL, NULL, '2022-03-28 12:06:43', '2022-10-30 09:26:49', 'http://104.46.33.250/storage/uploads/7-1656832203.jpg', NULL, 1, NULL, 5, 'ولعات', NULL, NULL, NULL, NULL, NULL, NULL),
(14, 'Lighters', NULL, 13, '2022-03-28 12:06:43', '2022-07-24 11:37:00', 'http://104.46.33.250/storage/uploads/360_F_262035364_gGi8uJsPl9uljis8C6oxI0w6AM7MKDLq-1648978306.jpeg', NULL, 1, NULL, 5, 'ولعات', NULL, NULL, 3, 232, NULL, 63),
(15, 'Rolling Paper', NULL, NULL, '2022-03-28 12:06:43', '2022-10-30 09:26:50', NULL, NULL, 1, NULL, 0, 'ورق بفره\r\n', NULL, NULL, NULL, NULL, NULL, NULL),
(17, 'PS', NULL, NULL, '2022-03-28 12:06:43', '2022-10-30 09:26:51', NULL, NULL, 1, NULL, 0, 'بى اس\r\n', NULL, NULL, NULL, NULL, NULL, NULL),
(19, 'Time', NULL, NULL, '2022-03-28 12:06:43', '2022-10-30 09:26:51', 'http://104.46.33.250/storage/uploads/wrtoex9fojpjlx9zaffv-1656832217.png', NULL, 1, NULL, 7, 'تايم', NULL, NULL, NULL, NULL, NULL, NULL),
(20, 'Time', NULL, 19, '2022-03-28 12:06:43', '2022-07-03 08:59:58', 'http://104.46.33.250/storage/uploads/blue-pack-1649142793.png', NULL, 1, NULL, 0, 'تايم', NULL, NULL, 100, 13300, NULL, 58),
(21, 'Loose Tobacco', NULL, NULL, '2022-04-12 12:10:15', '2022-09-13 15:32:29', 'http://104.46.33.250/storage/uploads/tobacco-g93ba268a2_640-1656832229.jpg', NULL, 0, 'y', 9, 'تبغ', NULL, NULL, NULL, NULL, NULL, NULL),
(22, 'Loose Tobacco', NULL, 21, '2022-04-12 12:10:15', '2022-07-24 11:37:42', 'http://104.46.33.250/storage/uploads/tobacco-g93ba268a2_640-1649763607.jpg', NULL, 1, NULL, 9, 'تبغ', NULL, NULL, 3, 940, NULL, 54),
(23, 'Fem Pad', NULL, NULL, '2022-06-29 14:20:36', '2022-09-13 15:32:34', 'http://104.46.33.250/storage/uploads/FineGuard_Comfort_Logo-640w-1656506165.webp', NULL, 0, 'y', 0, 'فوط نسائية', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `category_options`
--

CREATE TABLE `category_options` (
  `id` int(10) UNSIGNED NOT NULL,
  `sub_category_id` int(10) UNSIGNED NOT NULL,
  `option_id` int(10) UNSIGNED NOT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name_ar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `deactivation_notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivery_fees` decimal(8,2) DEFAULT NULL,
  `aramex_city_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivery_fees_type` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `name`, `created_at`, `updated_at`, `name_ar`, `active`, `deactivation_notes`, `delivery_fees`, `aramex_city_name`, `delivery_fees_type`) VALUES
(7, 'Giza', '2020-05-03 01:19:48', '2020-05-11 14:47:18', 'الجيزة', 1, '', '50.00', 'Giza', 1),
(8, 'Alexandria', '2020-05-03 01:36:25', '2021-10-06 15:04:03', 'الإسكندرية', 1, '', NULL, 'Alexandria', 1),
(9, 'Qaliobia', '2020-05-03 01:36:25', '2020-05-03 01:36:25', 'القليوبيه', 1, '', '50.00', 'Qaliubia', 1),
(10, 'Cairo', '2020-05-03 01:36:25', '2020-05-03 01:36:25', 'القاهرة', 1, '', '50.00', 'new Cairo', 1),
(11, 'Sohag', '2020-05-03 01:36:32', '2020-05-03 01:36:32', 'سوهاج', 1, '', '70.00', 'sohag City', 1),
(12, 'Aswan', '2020-05-03 01:36:32', '2020-05-03 01:36:32', 'اسوان', 1, '', '100.00', 'Aswan', 1),
(13, 'Luxor', '2020-05-03 01:36:32', '2020-05-03 01:36:32', 'الاقصر', 1, '', '100.00', 'Luxour', 1),
(14, 'Ismailia', '2020-05-03 01:36:32', '2020-05-03 01:36:32', 'الإسماعيلية', 1, '', '60.00', 'Ismailia', 1),
(15, 'Red Sea', '2020-05-03 01:36:32', '2020-05-03 01:36:32', 'البحر الاحمر', 1, '', '70.00', NULL, 1),
(16, 'Beheira', '2020-05-03 01:36:32', '2020-05-03 01:36:32', 'البحيرة', 1, '', '65.00', NULL, 1),
(17, 'Dakahlia', '2020-05-03 01:36:32', '2020-05-03 01:36:32', 'الدقهلية', 1, '', '60.00', NULL, 1),
(18, 'Sharkia', '2020-05-03 01:36:33', '2020-05-03 01:36:33', 'الشرقية', 1, '', '60.00', NULL, 1),
(19, 'Gharbia', '2020-05-03 01:36:33', '2020-05-03 01:36:33', 'الغربية', 1, '', '60.00', NULL, 1),
(20, 'Fayoum', '2020-05-03 01:36:33', '2020-05-03 01:36:33', 'الفيوم', 1, '', '65.00', 'Fayoum', 1),
(21, 'Menoufia', '2020-05-03 01:36:34', '2020-05-03 01:36:34', 'المنوفية', 1, '', '60.00', 'Al Menofiah', 1),
(22, 'Minya', '2020-05-03 01:36:34', '2020-05-03 01:36:34', 'المنيا', 1, '', '60.00', 'Menia City', 1),
(23, 'New Valley', '2020-05-03 01:36:34', '2020-05-03 01:36:34', 'الوادي الجديد', 1, '', '125.00', 'El Wadi El Gadid', 1),
(24, 'Bani Suef', '2020-05-03 01:36:34', '2020-05-03 01:36:34', 'بني سويف', 1, '', '70.00', 'Bani Swif', 1),
(25, 'Port Said', '2020-05-03 01:36:34', '2020-05-03 01:36:34', 'بور سعيد', 1, '', '60.00', 'Port Said', 1),
(26, 'South Sinai', '2020-05-03 01:36:34', '2020-05-03 01:36:34', 'جنوب سيناء', 1, '', '125.00', NULL, 1),
(27, 'Damietta', '2020-05-03 01:36:34', '2020-05-03 01:36:34', 'دمياط', 1, '', '60.00', 'Dumiatta', 1),
(28, 'North Sinai', '2020-05-03 01:36:34', '2020-05-03 01:36:34', 'شمال سيناء', 1, '', '120.00', NULL, 1),
(29, 'Qena', '2020-05-03 01:36:34', '2020-05-03 01:36:34', 'قنا', 1, '', '70.00', 'Qena', 1),
(30, 'Kafr Al sheikh', '2020-05-03 01:36:35', '2020-05-03 01:36:35', 'كفر الشيخ', 1, '', '60.00', 'Kafr Al Sheikh', 1),
(31, 'Matrouh', '2020-05-03 01:36:35', '2020-05-03 01:36:35', 'مطروح', 1, '', '80.00', 'Marsa Matrouh', 1),
(32, 'Assiut', '2020-05-03 01:36:38', '2020-05-03 01:36:38', 'أسيوط', 1, '', '80.00', 'Assiut', 1),
(33, 'Suez', '2020-05-03 01:36:38', '2020-05-03 01:36:38', 'السويس', 1, '', '60.00', 'Suez', 1);

-- --------------------------------------------------------

--
-- Table structure for table `closed_payment_methods`
--

CREATE TABLE `closed_payment_methods` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `payment_method_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `compare_products`
--

CREATE TABLE `compare_products` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `configurations`
--

CREATE TABLE `configurations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `label` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alias` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'input field type',
  `options` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`options`)),
  `group` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `required` tinyint(1) NOT NULL DEFAULT 1,
  `editable` tinyint(1) NOT NULL DEFAULT 1,
  `order` int(10) UNSIGNED NOT NULL DEFAULT 999,
  `scope` enum('global','customer','admin','backend') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'global',
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `configurations`
--

INSERT INTO `configurations` (`id`, `label`, `key`, `alias`, `value`, `type`, `options`, `group`, `required`, `editable`, `order`, `scope`, `description`, `created_at`, `updated_at`) VALUES
(1, 'ADMIN_THEME_TYPE', 'ADMIN_THEME_TYPE', NULL, '1', 'number', NULL, 'Admin', 1, 0, 999, 'admin', NULL, NULL, '2021-09-06 11:11:43'),
(2, 'Brand Name (En)', 'APP_NAME', NULL, 'Mansour', 'text', NULL, 'General', 1, 1, 999, 'global', NULL, NULL, '2021-11-21 11:26:17'),
(3, 'Brand Name (Ar)', 'APP_NAME_AR', NULL, 'منصور', 'text', NULL, 'General', 1, 1, 999, 'global', NULL, NULL, '2021-11-21 11:26:17'),
(4, 'Contact Email', 'ONLINE_EMAIL', NULL, 'contact@mansour.com', 'email', NULL, 'General', 1, 1, 999, 'global', NULL, NULL, '2021-11-21 11:26:17'),
(5, 'Info Email', 'INFO_EMAIL', NULL, 'contact@mansour.com', 'email', NULL, 'General', 1, 1, 999, 'global', NULL, NULL, '2021-11-21 11:26:17'),
(6, 'Hot Line', 'HOTPHONE', NULL, '16030', 'text', NULL, 'General', 1, 1, 999, 'global', NULL, NULL, '2022-03-30 11:37:21'),
(7, 'SOCIAL_URL_FACEBOOK', 'SOCIAL_URL_FACEBOOK', NULL, 'https://www.facebook.com', 'url', NULL, 'General', 1, 0, 999, 'global', NULL, NULL, NULL),
(8, 'SOCIAL_URL_YOUTUBE', 'SOCIAL_URL_YOUTUBE', NULL, 'https://www.youtube.com/', 'url', NULL, 'General', 1, 0, 999, 'global', NULL, NULL, NULL),
(9, 'SOCIAL_URL_INSTAGRAM', 'SOCIAL_URL_INSTAGRAM', NULL, 'https://www.instagram.com/', 'url', NULL, 'General', 1, 0, 999, 'global', NULL, NULL, NULL),
(10, 'STORE_ANDROID_URL', 'STORE_ANDROID_URL', NULL, 'https://play.google.com/store', 'url', NULL, 'General', 1, 0, 999, 'global', NULL, NULL, NULL),
(11, 'STORE_APPLE_URL', 'STORE_APPLE_URL', NULL, 'https://apps.apple.com', 'url', NULL, 'General', 1, 0, 999, 'global', NULL, NULL, NULL),
(12, 'STORE_HWAWEI_URL', 'STORE_HWAWEI_URL', NULL, 'https://appgallery.huawei.com', 'url', NULL, 'General', 1, 0, 999, 'global', NULL, NULL, NULL),
(13, 'Logo (En)', 'LOGO_IMAGE_URL', NULL, 'https://mobilaty-staging.el-dokan.com/assets/images/brand/logo_dark.png', 'url', NULL, 'General', 1, 0, 999, 'backend', NULL, NULL, NULL),
(14, 'TRUCK_IMAGE_URL', 'TRUCK_IMAGE_URL', NULL, 'https://mobilaty.com/assets/images/truck.png', 'url', NULL, 'General', 1, 1, 999, 'backend', NULL, NULL, NULL),
(15, 'ADMIN_URL', 'ADMIN_URL', NULL, 'https://mobilatyadmin-staging.el-dokan.com', 'url', NULL, 'General', 1, 0, 999, 'backend', NULL, NULL, NULL),
(16, 'WEBSITE_URL', 'WEBSITE_URL', NULL, 'https://store.el-dokan.com/', 'url', NULL, 'General', 1, 0, 999, 'global', NULL, NULL, NULL),
(17, 'APP_URL', 'APP_URL', NULL, 'http://104.46.33.250', 'url', NULL, 'General', 1, 0, 999, 'backend', NULL, NULL, NULL),
(18, 'PRODUCT_TYPE', 'PRODUCT_TYPE', NULL, 'variant', 'single_select', '[{\"main\": \"Main\"}, {\"variant\": \"Variant\"}]', 'Ecommerce', 1, 1, 999, 'backend', NULL, NULL, '2021-09-08 14:00:43'),
(19, 'BRANCH_TYPES', 'BRANCH_TYPES', NULL, 'Stores=>ستورز|Stores', 'text', NULL, 'Ecommerce', 1, 0, 999, 'backend', NULL, NULL, NULL),
(20, 'Colored Logo (En)', 'COLORED_LOGO_EN', NULL, 'https://mansourgroupapi.el-dokan.com/storage/uploads/4oQX3o-1637185723-1637486682.png', 'image', NULL, 'Brand', 1, 1, 999, 'global', NULL, NULL, '2021-11-21 11:26:17'),
(21, 'Colored Logo (Ar)', 'COLORED_LOGO_AR', NULL, 'https://mansourgroupapi.el-dokan.com/storage/uploads/4oQX3o-1637185723-1637486539.png', 'image', NULL, 'Brand', 1, 1, 999, 'global', NULL, NULL, '2021-11-21 11:23:14'),
(22, 'White Logo (En)', 'WHITE_LOGO_EN', NULL, 'https://mansourgroupapi.el-dokan.com/storage/uploads/4oQX3o-1637185723-1637486570.png', 'image', NULL, 'Brand', 1, 1, 999, 'global', NULL, NULL, '2021-11-21 11:23:14'),
(23, 'White Logo (Ar)', 'WHITE_LOGO_AR', NULL, 'https://mansourgroupapi.el-dokan.com/storage/uploads/4oQX3o-1637185723-1637486695.png', 'image', NULL, 'Brand', 1, 1, 999, 'global', NULL, NULL, '2021-11-21 11:26:17'),
(24, 'Black & White Logo', 'BLACK_LOGO', NULL, 'https://mansourgroupapi.el-dokan.com/storage/uploads/4oQX3o-1637185723-1637486722.png', 'image', NULL, 'Brand', 1, 1, 999, 'admin', NULL, NULL, '2021-11-21 11:26:17'),
(25, 'Fav Icon', 'FAV_ICON', NULL, 'https://mansourgroupapi.el-dokan.com/storage/uploads/4oQX3o-1637185723-1637486732.png', 'image', NULL, 'Brand', 1, 1, 999, 'global', NULL, NULL, '2021-11-21 11:26:17'),
(26, 'APP_KEY', 'APP_KEY', NULL, 'base64:JnNIcYn+/pUBTdqZaTJhhUjs6ME+PZ22HiHZBJYmviQ=', 'text', NULL, 'General', 1, 0, 999, 'backend', NULL, NULL, NULL),
(27, 'Mail Driver', 'MAIL_DRIVER', NULL, NULL, 'text', NULL, 'Mail', 1, 1, 999, 'backend', NULL, NULL, NULL),
(28, 'Mail Host', 'MAIL_HOST', NULL, 'email-smtp.us-east-1.amazonaws.com', 'text', NULL, 'Mail', 1, 1, 999, 'backend', NULL, NULL, NULL),
(29, 'Mail Port', 'MAIL_PORT', NULL, '465', 'number', NULL, 'Mail', 1, 1, 999, 'backend', NULL, NULL, NULL),
(30, 'Mail Username', 'MAIL_USERNAME', NULL, 'AKIA3YGEEJDVVB4CABOA', 'text', NULL, 'Mail', 1, 1, 999, 'backend', NULL, NULL, NULL),
(31, 'Mail Password', 'MAIL_PASSWORD', NULL, 'BAqMLZumaRT02yo/AKc/2NOJkOCdb27hdjRzKtHI6VRc', 'text', NULL, 'Mail', 1, 1, 999, 'backend', NULL, NULL, NULL),
(32, 'Mail Encryption', 'MAIL_ENCRYPTION', NULL, 'ssl', 'text', NULL, 'Mail', 1, 1, 999, 'backend', NULL, NULL, NULL),
(33, 'Sender Email Address', 'MAIL_FROM_ADDRESS', NULL, 'info@mansour.com', 'email', NULL, 'Mail', 1, 1, 999, 'backend', NULL, NULL, '2021-11-21 11:26:17'),
(34, 'Sender Email Name', 'MAIL_FROM_NAME', NULL, 'Mansour', 'text', NULL, 'Mail', 1, 1, 999, 'backend', NULL, NULL, '2021-11-21 11:26:17'),
(35, 'Mailchimp API Key', 'MAILCHIMP_APIKEY', NULL, '-us20', 'text', NULL, 'MailChimp', 1, 1, 999, 'backend', NULL, NULL, NULL),
(36, 'Mailchimp List ID', 'MAILCHIMP_LIST_ID', NULL, NULL, 'text', NULL, 'MailChimp', 1, 1, 999, 'backend', NULL, NULL, NULL),
(37, 'Facebook Client ID', 'FACEBOOK_CLIENT_ID', NULL, NULL, 'text', NULL, 'Social Auth', 1, 1, 999, 'global', NULL, NULL, NULL),
(38, 'Facebook Client Secret', 'FACEBOOK_CLIENT_SECRET', NULL, NULL, 'text', NULL, 'Social Auth', 1, 1, 999, 'backend', NULL, NULL, '2021-11-21 11:06:46'),
(39, 'Google Client ID', 'GOOGLE_CLIENT_ID', NULL, NULL, 'text', NULL, 'Social Auth', 1, 1, 999, 'global', NULL, NULL, NULL),
(40, 'Google Client Secret', 'GOOGLE_CLIENT_SECRET', NULL, NULL, 'text', NULL, 'Social Auth', 1, 1, 999, 'backend', NULL, NULL, NULL),
(41, 'Google Redirect URL', 'GOOGLE_REDIRECT', NULL, 'https://store.el-dokan.com/', 'text', NULL, 'Social Auth', 1, 1, 999, 'backend', NULL, NULL, '2021-09-22 11:25:28'),
(42, 'Aramex Username', 'ARAMEX_USER_NAME', NULL, NULL, 'text', NULL, 'Aramex', 1, 1, 999, 'backend', NULL, NULL, NULL),
(43, 'Aramex Password', 'ARAMEX_PASSWORD', NULL, NULL, 'text', NULL, 'Aramex', 1, 1, 999, 'backend', NULL, NULL, NULL),
(44, 'Aramex Account Entity', 'ARAMEX_ACCOUNT_ENTITY', NULL, 'CAI', 'text', NULL, 'Aramex', 1, 1, 999, 'backend', NULL, NULL, NULL),
(45, 'Aramex Account Country Code', 'ARAMEX_ACCOUNT_COUNTRY_CODE', NULL, 'EG', 'text', NULL, 'Aramex', 1, 1, 999, 'backend', NULL, NULL, NULL),
(46, 'Aramex URL', 'ARAMEX_URL', NULL, 'https://ws.aramex.net/ShippingAPI.V2/Shipping/Service_1_0.svc/json/CreatePickup', 'text', NULL, 'Aramex', 1, 1, 999, 'backend', NULL, NULL, NULL),
(47, 'Aramex Account PIN 1', 'ARAMEX_ACCOUNT_PIN_1', NULL, NULL, 'text', NULL, 'Aramex', 1, 1, 999, 'backend', NULL, NULL, NULL),
(48, 'Aramex Account No 1', 'ARAMEX_ACCOUNT_NUMBER_1', NULL, NULL, 'text', NULL, 'Aramex', 1, 1, 999, 'backend', NULL, NULL, NULL),
(49, 'Aramex Account PIN 2', 'ARAMEX_ACCOUNT_PIN_2', NULL, NULL, 'text', NULL, 'Aramex', 1, 1, 999, 'backend', NULL, NULL, NULL),
(50, 'Aramex Account No 2', 'ARAMEX_ACCOUNT_NUMBER_2', NULL, NULL, 'text', NULL, 'Aramex', 1, 1, 999, 'backend', NULL, NULL, NULL),
(51, 'Paymob Merchant ID', 'MERCHANT_ID', NULL, '4217', 'text', NULL, 'Paymob', 1, 1, 999, 'backend', NULL, NULL, NULL),
(52, 'Paymob API Key', 'WE_ACCEPT_PAYMENT_API_KEY', NULL, NULL, 'text', NULL, 'Paymob', 1, 1, 999, 'backend', NULL, NULL, '2021-11-21 11:06:46'),
(53, 'Paymob HMAC Hash', 'HMAC_HASH', NULL, NULL, 'text', NULL, 'Paymob', 1, 1, 999, 'backend', NULL, NULL, '2021-11-21 11:06:46'),
(54, 'Metabase URL', 'METABASE_URL', NULL, NULL, 'text', NULL, 'Metabase', 1, 1, 999, 'backend', NULL, NULL, '2021-11-21 11:06:46'),
(55, 'Get Go IFrame ID', 'GET_GO_IFRAME_ID', NULL, NULL, 'text', NULL, 'Paymob', 1, 1, 999, 'backend', NULL, NULL, '2021-11-21 11:06:46'),
(56, 'Get Go Integration ID', 'GET_GO_INTEGRATION_ID', NULL, NULL, 'text', NULL, 'Paymob', 1, 1, 999, 'backend', NULL, NULL, '2021-11-21 11:06:46'),
(57, 'Premium IFrame ID', 'PREMIUM_IFRAME_ID', NULL, NULL, 'text', NULL, 'Paymob', 1, 1, 999, 'backend', NULL, NULL, '2021-11-21 11:06:46'),
(58, 'Premium Integration ID', 'PREMIUM_INTEGRATION_ID', NULL, NULL, 'text', NULL, 'Paymob', 1, 1, 999, 'backend', NULL, NULL, '2021-11-21 11:06:46'),
(59, 'Shahry IFrame ID', 'SHAHRY_IFRAME_ID', NULL, NULL, 'text', NULL, 'Paymob', 1, 1, 999, 'backend', NULL, NULL, '2021-11-21 11:06:46'),
(60, 'Shahry Integration ID', 'SHAHRY_INTEGRATION_ID', NULL, NULL, 'text', NULL, 'Paymob', 1, 1, 999, 'backend', NULL, NULL, '2021-11-21 11:06:46'),
(61, 'Souhoola IFrame ID', 'SOUHOOLA_IFRAME_ID', NULL, NULL, 'text', NULL, 'Paymob', 1, 1, 999, 'backend', NULL, NULL, '2021-11-21 11:06:46'),
(62, 'Souhoola Integration ID', 'SOUHOOLA_INTEGRATION_ID', NULL, NULL, 'text', NULL, 'Paymob', 1, 1, 999, 'backend', NULL, NULL, '2021-11-21 11:06:46'),
(63, 'VALU IFrame ID', 'VALU_IFRAME_ID', NULL, NULL, 'text', NULL, 'Paymob', 1, 1, 999, 'backend', NULL, NULL, '2021-11-21 11:06:46'),
(64, 'VALU Integration ID', 'VALU_INTEGRATION_ID', NULL, NULL, 'text', NULL, 'Paymob', 1, 1, 999, 'backend', NULL, NULL, '2021-11-21 11:06:46'),
(65, 'Vodafone Integration ID', 'VODAFONE_INTEGRATION_ID', NULL, NULL, 'text', NULL, 'Paymob', 1, 1, 999, 'backend', NULL, NULL, '2021-11-21 11:06:46'),
(66, 'We Accept IFrame ID', 'WE_ACCEPT_IFRAME_ID', NULL, NULL, 'text', NULL, 'Paymob', 1, 1, 999, 'backend', NULL, NULL, '2021-11-21 11:06:46'),
(67, 'We Accept Integration ID', 'WE_ACCEPT_INTEGRATION_ID', NULL, NULL, 'text', NULL, 'Paymob', 1, 1, 999, 'backend', NULL, NULL, '2021-11-21 11:06:46'),
(68, 'UPG Merchant ID', 'UPG_MERCHANT_ID', NULL, NULL, 'text', NULL, 'UPG', 1, 1, 999, 'backend', NULL, NULL, '2021-11-21 11:06:46'),
(69, 'UPG Terminal ID', 'UPG_TERMINAL_ID', NULL, NULL, 'text', NULL, 'UPG', 1, 1, 999, 'backend', NULL, NULL, '2021-11-21 11:06:46'),
(70, 'UPG Secure Key', 'UPG_SECURE_KEY', NULL, NULL, 'text', NULL, 'UPG', 1, 1, 999, 'backend', NULL, NULL, '2021-11-21 11:06:46'),
(76, 'SMS Username', 'SMS_USERNAME', NULL, NULL, 'text', NULL, 'SMS', 0, 1, 999, 'backend', NULL, NULL, '2021-11-21 11:06:46'),
(77, 'SMS Password', 'SMS_PASSWORD', NULL, NULL, 'text', NULL, 'SMS', 0, 1, 999, 'backend', NULL, NULL, '2021-11-21 11:06:46'),
(78, 'SMS Sender ID', 'SMS_SENDER_ID', NULL, NULL, 'text', NULL, 'SMS', 0, 1, 999, 'backend', NULL, NULL, '2021-11-21 11:06:46'),
(79, 'SMS Connection', 'SMS_CONNECTION', NULL, NULL, 'single_select', '[{\"\": \"Disabled\"}, {\"victory\": \"Victory\"}, {\"smseg\": \"SMSEG\"}, {\"smsmisr\": \"SMSMisr\"}]', 'SMS', 0, 1, 999, 'admin', NULL, NULL, '2021-10-06 16:38:23'),
(80, 'SMS Driver', 'SMS_DRIVER', NULL, 'database', 'single_select', '[{\"gateway\": \"Gateway\"}, {\"database\": \"Database\"}]', 'SMS', 0, 1, 999, 'backend', NULL, NULL, '2021-10-03 11:31:07'),
(81, 'Apple Redirect URI', 'APPLE_REDIRECT_URI', NULL, NULL, 'text', NULL, 'Social Auth', 1, 1, 999, 'backend', NULL, NULL, NULL),
(82, 'Apple Client ID', 'APPLE_CLIENT_ID', NULL, NULL, 'text', NULL, 'Social Auth', 1, 1, 999, 'backend', NULL, NULL, NULL),
(83, 'Apple Client Secret', 'APPLE_CLIENT_SECRET', NULL, NULL, 'text', NULL, 'Social Auth', 1, 1, 999, 'backend', NULL, NULL, NULL),
(84, 'FCM Server Key', 'FCM_SERVER_KEY', NULL, 'AAAAdv-Aan4:APA91bEB4ExyaStm5DFw91Gf7Puxy9JhYP-FfZk5JZsguVnlRC-lKBIE1zOcKlJ3Gtv2Wr6WW0nNoiBx6MueLlS6hiY_OgAWOJjL-xPzMdLprwk_bdzkQRu7l50huQ-6lyZ6AhNKaBSD', 'text', NULL, 'FCM', 1, 1, 999, 'backend', NULL, NULL, '2021-11-21 11:06:46'),
(85, 'FCM Sender ID', 'FCM_SENDER_ID', NULL, '511092746878', 'text', NULL, 'FCM', 1, 1, 999, 'backend', NULL, NULL, '2021-11-21 11:06:46'),
(86, 'Google Maps API Key', 'GOOGLE_MAP_API_KEY', NULL, NULL, 'text', NULL, 'Google Maps', 1, 1, 999, 'customer', NULL, NULL, '2021-11-21 11:06:46'),
(87, 'ERP Token', 'erp_token', NULL, 'test', 'text', NULL, 'ERP Settings', 0, 1, 999, 'backend', NULL, NULL, NULL),
(88, 'Ex Rate Pts', 'ex_rate_pts', NULL, '1', 'float', NULL, 'Ecommerce', 1, 1, 999, 'backend', 'X points added to User account for Each Rate Egp ', NULL, '2021-09-20 13:28:02'),
(89, 'Ex Rate Egp', 'ex_rate_egp', NULL, '10', 'float', NULL, 'Ecommerce', 1, 1, 999, 'backend', 'Y EGP spent by the user', NULL, '2021-09-08 10:24:43'),
(90, 'Ex Rate Gold', 'ex_rate_gold', NULL, '15', 'float', NULL, 'Ecommerce', 1, 1, 999, 'backend', 'Extra % of points the user will get while Gold', NULL, NULL),
(91, 'EGP Gold', 'egp_gold', NULL, '1000000000', 'float', NULL, 'Ecommerce', 1, 1, 999, 'backend', 'Egp need per month to earn user gold status', NULL, '2021-12-15 16:32:40'),
(92, 'Pending Days', 'pending_days', NULL, '0', 'float', NULL, 'Ecommerce', 1, 1, 999, 'backend', 'The number of days the user points will remain \'Pending\' before it changes to \'Earned\'', NULL, NULL),
(93, 'Refer Points', 'refer_points', NULL, '100', 'float', NULL, 'Ecommerce', 1, 1, 999, 'backend', 'Number of points the users get when they refer a friend . ', NULL, NULL),
(94, 'Refer Minimum', 'refer_minimum', NULL, '100', 'float', NULL, 'Ecommerce', 1, 1, 999, 'backend', 'The minimum order amount for the referal code to work', NULL, NULL),
(95, 'Off Time', 'off_time', NULL, '12:00 pm', 'time', NULL, 'Ecommerce', 1, 1, 999, 'backend', NULL, NULL, '2021-09-08 14:08:20'),
(96, 'Min Order Amount', 'min_order_amount', NULL, '0', 'float', NULL, 'Ecommerce', 0, 1, 999, 'backend', NULL, NULL, '2021-10-08 17:04:12'),
(97, 'Open Time', 'open_time', NULL, '12:00 am', 'time', NULL, 'Ecommerce', 1, 1, 999, 'backend', NULL, NULL, NULL),
(98, 'Except Cod Amount', 'except_cod_amount', NULL, '40000', 'float', NULL, 'Ecommerce', 1, 1, 999, 'backend', NULL, NULL, '2021-09-20 12:44:24'),
(99, 'Menu', 'menu', NULL, '{\n   \"menu_background_color\":\"#000000\",\n   \"drop_menu_background_color\":\"#ffffff\",\n   \"level1_text_color\":\"#ffffff\",\n   \"level1_hover_color\":\"#f0485a\",\n   \"level2_text_color\":\"#f0485a\",\n   \"level2_hover_color\":\"#000000\",\n   \"level3_text_color\":\"#000000\",\n   \"level3_hover_color\":\"#f0485a\",\n   \"level1\":[\n      {\n         \"link\":\"/\",\n         \"name\":\"Home\",\n         \"name_ar\":\"الرئيسية\",\n         \"image\":null,\n         \"levels_length\":1,\n         \"level1_image\":false,\n         \"level2_image\":false,\n         \"level3_image\":false,\n         \"level3_items_spacing\":\"20\",\n         \"level3_items_spacing_metric\":\"px\",\n         \"menu_padding\":\"2\",\n         \"menu_padding_metric\":\"rem\",\n         \"level1_image_dimentions\":\"300\",\n         \"level1_image_dimentions_metric\":\"px\",\n         \"menu_fixed_width\":\"99\",\n         \"menu_fixed_width_metric\":\"%\",\n         \"fixed_width\":\"30\",\n         \"fixed_width_metric\":\"%\",\n         \"order\":1000,\n         \"level2\":[\n            \n         ]\n      },\n      {\"auto_category\":true}\n      \n   ],\n   \"#bf3241\":\"#level1_hover_color\",\n   \"#f0485a\":\"#level3_hover_color\",\n   \"#bf3259\":\"#level2_text_color\",\n   \"#e24e77\":\"#level2_text_color\",\n   \"#e2406d\":\"#level2_text_color\"\n}', 'textarea', NULL, 'Ecommerce', 1, 0, 999, 'backend', NULL, NULL, NULL),
(100, 'DELIVERY_FEES', 'DELIVERY_FEES', NULL, 'location', 'single_select', '[{\"aramex\": \"Aramex\"}, {\"location\": \"Location\"}]', 'Ecommerce', 1, 1, 999, 'backend', 'DELIVERY_FEES', NULL, '2021-09-16 12:55:00'),
(101, 'Affiliate Pending Days', 'affiliate_pending_days', NULL, '0', 'float', NULL, 'Ecommerce', 1, 1, 999, 'backend', NULL, NULL, '2021-09-20 13:28:02'),
(102, 'Enable Affiliate', 'enable_affiliate', NULL, '0', 'switch', NULL, 'Ecommerce', 1, 1, 999, 'global', NULL, NULL, '2022-03-30 11:37:22'),
(103, 'Enable Prescription', 'enable_prescription', NULL, '0', 'switch', NULL, 'Ecommerce', 1, 1, 999, 'global', NULL, NULL, '2022-03-30 11:37:22'),
(104, 'WEB_THEME_TYPE', 'WEB_THEME_TYPE', NULL, '1', 'number', NULL, 'Web', 1, 0, 999, 'customer', NULL, NULL, '2021-09-06 11:11:42'),
(105, 'ENABLE_LOYALITY', 'ENABLE_LOYALITY', NULL, '1', 'switch', NULL, 'Web', 1, 1, 999, 'global', NULL, NULL, '2022-03-30 11:37:22'),
(106, 'ENABLE_CATEGORY_VIEW', 'ENABLE_CATEGORY_VIEW', NULL, '0', 'switch', NULL, 'Web', 1, 1, 999, 'global', NULL, NULL, '2022-03-30 11:37:22'),
(107, 'ENABLE_SUBCATEGORY_VIEW', 'ENABLE_SUBCATEGORY_VIEW', NULL, '0', 'switch', NULL, 'Web', 1, 1, 999, 'global', NULL, NULL, '2022-03-30 11:37:22'),
(108, 'fbPixelId', 'fbPixelId', NULL, NULL, 'text', NULL, 'Web', 1, 1, 999, 'global', NULL, NULL, '2021-10-03 16:54:27'),
(109, 'googleTagManID', 'googleTagManID', NULL, 'GTM-PBV34PR', 'text', NULL, 'Web', 1, 1, 999, 'global', NULL, NULL, NULL),
(110, 'ENABLE_STATIC_MENU', 'ENABLE_STATIC_MENU', NULL, '0', 'switch', NULL, 'Web', 1, 1, 999, 'global', NULL, NULL, '2022-03-30 11:37:22'),
(111, 'logoWidth', 'logoWidth', NULL, '180px', 'text', NULL, 'Web', 1, 1, 999, 'global', NULL, NULL, NULL),
(112, 'logoHeight', 'logoHeight', NULL, '60px', 'text', NULL, 'Web', 1, 1, 999, 'global', NULL, NULL, NULL),
(113, 'logoWidthMobile', 'logoWidthMobile', NULL, '100%', 'text', NULL, 'Web', 1, 1, 999, 'global', NULL, NULL, NULL),
(114, 'logoHeightMobile', 'logoHeightMobile', NULL, '80px', 'text', NULL, 'Web', 1, 1, 999, 'global', NULL, NULL, NULL),
(115, 'SEO Scripts', 'WEB_SEO_SCRIPTS', NULL, '.', 'textarea', NULL, 'SEO Scripts', 1, 1, 999, 'global', NULL, NULL, '2021-10-04 13:21:32'),
(116, 'sloganEn', 'sloganEn', NULL, 'El Dokan | Experts in your needs', 'text', NULL, 'Web', 1, 1, 999, 'global', NULL, NULL, NULL),
(117, 'sloganAr', 'sloganAr', NULL, 'الدكان |  خبراء فى أحتياجاتك', 'text', NULL, 'Web', 1, 1, 999, 'global', NULL, NULL, NULL),
(118, 'metaDescriptionEn', 'metaDescriptionEn', NULL, 'Shop Mobiles | Tablets | Laptops | Accessories | Gaming | Smart Home | Deals at best price fast and safe shipping', 'text', NULL, 'Web', 1, 1, 999, 'global', NULL, NULL, NULL),
(119, 'metaDescriptionAr', 'metaDescriptionAr', NULL, 'تسوق هواتف | تابلت | لاب توب | إكسسوارات | العاب | المنزل الزكى | العروض بأفضل الأسعار مع شحن سريع آمن', 'text', NULL, 'Web', 1, 1, 999, 'global', NULL, NULL, NULL),
(120, 'footerAboutCompanyEn', 'footerAboutCompanyEn', NULL, 'Wherever you are, you will find us at more than 10 branches', 'text', NULL, 'Web', 1, 1, 999, 'global', NULL, NULL, NULL),
(121, 'footerAboutCompanyAr', 'footerAboutCompanyAr', NULL, 'أينما كنت, ستجدنا بأكثر من 10 فروع', 'text', NULL, 'Web', 1, 1, 999, 'global', NULL, NULL, NULL),
(122, 'Footer Payment Images', 'footerPaymentImages', NULL, 'https://storeapi.el-dokan.com/storage/uploads/payment_method.png', 'image', NULL, 'Web', 1, 1, 999, 'global', NULL, NULL, '2021-10-10 11:44:20'),
(123, 'footerPaymentImageStaticWidth', 'footerPaymentImageStaticWidth', NULL, '230', 'text', NULL, 'Web', 1, 1, 999, 'global', NULL, NULL, '2021-09-06 11:08:26'),
(124, 'Soft Bar BG Color', 'SOFTBAR_BG_COLOR', NULL, '#da1e1e', 'color', NULL, 'Soft Bar', 0, 1, 999, 'customer', NULL, NULL, '2021-09-07 15:16:52'),
(125, 'Soft Bar Font Color', 'SOFTBAR_FONT_COLOR', NULL, '#ffffff', 'color', NULL, 'Soft Bar', 0, 1, 999, 'customer', NULL, NULL, '2021-09-08 16:48:06'),
(126, 'Soft Bar Text (EN)', 'SOFTBAR_TEXT_EN', NULL, 'welcome on El Dokan', 'text', NULL, 'Soft Bar', 0, 1, 999, 'customer', NULL, NULL, '2021-10-06 14:54:37'),
(127, 'Soft Bar Text (AR)', 'SOFTBAR_TEXT_AR', NULL, 'اهلا بكم في الدكان', 'text', NULL, 'Soft Bar', 0, 1, 999, 'customer', NULL, NULL, '2021-10-06 14:54:37'),
(128, 'Enable Soft Bar', 'ENABLE_SOFTBAR', NULL, '0', 'switch', NULL, 'Soft Bar', 0, 1, 999, 'customer', NULL, NULL, '2022-03-30 11:37:22'),
(129, 'WEB BRAND COLOR', 'WEB_BRAND_COLOR', NULL, '#008c3d', 'color', NULL, 'Theme', 1, 1, 999, 'global', NULL, NULL, '2021-11-21 11:23:14'),
(130, 'WEB SECOND COLOR', 'WEB_SECOND_COLOR', NULL, '#000000', 'color', NULL, 'Theme', 1, 1, 999, 'customer', NULL, NULL, '2021-09-08 11:53:09'),
(131, 'WEB FOOTER BG COLOR', 'WEB_FOOTER_BG_COLOR', NULL, '#000000', 'color', NULL, 'Theme', 1, 1, 999, 'customer', NULL, NULL, '2021-09-08 13:24:26'),
(132, 'WEB FOOTER FONT COLOR', 'WEB_FOOTER_FONT_COLOR', NULL, '#ffffff', 'color', NULL, 'Theme', 1, 1, 999, 'customer', NULL, NULL, '2021-09-08 13:24:26'),
(133, 'Web Contact Time Txt (EN)', 'WEB_CONTACT_TIME_TXT_EN', NULL, 'We’re there every sunday to thursday 10 AM - 6 PM', 'textarea', NULL, 'Text', 1, 1, 999, 'customer', NULL, NULL, '2021-10-10 14:01:13'),
(134, 'Web Contact Time Txt (AR)', 'WEB_CONTACT_TIME_TXT_AR', NULL, 'مواعيد العمل: الأحد-الخميس من 10 صباحًا وحتى 6 مساءً', 'textarea', NULL, 'Text', 1, 1, 999, 'customer', NULL, NULL, '2021-10-10 14:01:13'),
(135, 'Enable Guest Checkout', 'enable_guest_checkout', NULL, '1', 'switch', NULL, 'Ecommerce', 1, 1, 999, 'customer', NULL, NULL, '2022-03-30 11:37:22'),
(136, 'Enable Large Image', 'ENABLE_LARGE_IMAGE', NULL, '1', 'switch', NULL, 'Web', 0, 1, 999, 'customer', NULL, NULL, '2022-03-30 11:37:22'),
(137, 'QNB SIMPLIFY API PUBLIC KEY', 'QNB_SIMPLIFY_API_PUBLIC_KEY', NULL, NULL, 'text', NULL, 'QNB SIMPLIFY', 1, 1, 999, 'backend', NULL, NULL, '2021-11-21 11:06:46'),
(138, 'QNB SIMPLIFY API PRIVATE KEY', 'QNB_SIMPLIFY_API_PRIVATE_KEY', NULL, NULL, 'text', NULL, 'QNB SIMPLIFY', 1, 1, 999, 'backend', NULL, NULL, '2021-11-21 11:06:46'),
(139, 'Paytabs Callback Url', 'PAYTABS_CALLBACK_URL', NULL, NULL, 'text', NULL, 'Paytabs', 1, 1, 999, 'backend', NULL, NULL, '2021-11-21 11:06:46'),
(140, 'Paytabs Server Key', 'PAYTABS_SERVER_KEY', NULL, NULL, 'text', NULL, 'Paytabs', 1, 1, 999, 'backend', NULL, NULL, '2021-11-21 11:06:46'),
(141, 'Paytabs Profile ID', 'PAYTABS_PROFILE_ID', NULL, NULL, 'text', NULL, 'Paytabs', 1, 1, 999, 'backend', NULL, NULL, '2021-11-21 11:06:46'),
(143, 'NBE Checkout js', 'NBE_CHECKOUT_JS', NULL, 'https://test-nbe.gateway.mastercard.com/checkout/version/49/checkout.js', 'text', NULL, 'NBE', 1, 1, 999, 'backend', NULL, NULL, '2021-09-22 15:06:18'),
(144, 'SMS ID', 'SMS_ID', NULL, NULL, 'text', NULL, 'SMS', 1, 1, 999, 'backend', NULL, NULL, '2021-11-21 11:06:46'),
(145, 'SMS Msignature', 'SMS_MSIGNATURE', NULL, NULL, 'text', NULL, 'SMS', 1, 1, 999, 'backend', NULL, NULL, '2021-11-21 11:06:46'),
(146, 'SMS token', 'SMS_TOKEN', NULL, NULL, 'text', NULL, 'SMS', 1, 1, 999, 'backend', NULL, NULL, '2021-11-21 11:06:46'),
(147, 'Country Code', 'COUNTRY_CODE', NULL, 'EG', 'single_select', '[{\"EG\": \"Egypt\"}, {\"QA\": \"Qatar\"}]', 'Ecommerce', 1, 1, 999, 'customer', NULL, NULL, '2021-10-11 09:51:10'),
(148, 'Currency Label (EN)', 'CURRENCY_CODE_EN', NULL, 'LE', 'single_select', '[{\"LE\": \"LE\"}, {\"QR\": \"QR\"}]', 'Ecommerce', 1, 1, 999, 'global', NULL, NULL, '2021-10-06 15:48:49'),
(149, 'Currency Label (AR)', 'CURRENCY_CODE_AR', NULL, 'ج.م', 'single_select', '[{\"ج.م\": \"ج.م\"}, {\"ر.ق\": \"ر.ق\"}]', 'Ecommerce', 1, 1, 999, 'global', NULL, NULL, '2021-10-06 15:48:49'),
(150, 'NBE Base Url', 'NBE_BASE_URL', NULL, 'https://test-nbe.gateway.mastercard.com/checkout/version/49', 'text', NULL, 'NBE', 1, 1, 999, 'backend', NULL, NULL, '2021-09-30 09:51:03'),
(154, 'Loading Shimmer Dark 1st Level', 'LOADING_SHIMMER_DARK_1', NULL, '#3B3939', 'color', NULL, 'Theme', 1, 1, 999, 'global', NULL, NULL, '2021-10-06 15:33:50'),
(155, 'Loading Shimmer Dark 2nd Level', 'LOADING_SHIMMER_DARK_2', NULL, '#343232', 'color', NULL, 'Theme', 1, 1, 999, 'global', NULL, NULL, '2021-10-06 15:33:50'),
(156, 'Loading Shimmer Dark 3rd Level', 'LOADING_SHIMMER_DARK_3', NULL, '#3B3939', 'color', NULL, 'Theme', 1, 1, 999, 'global', NULL, NULL, '2021-10-06 15:33:50'),
(157, 'Loading Shimmer Light 1st Level', 'LOADING_SHIMMER_LIGHT_1', NULL, '#E8E8E8', 'color', NULL, 'Theme', 1, 1, 999, 'global', NULL, NULL, '2021-10-06 15:33:50'),
(158, 'Loading Shimmer Light 2nd Level', 'LOADING_SHIMMER_LIGHT_2', NULL, '#E3E3E3', 'color', NULL, 'Theme', 1, 1, 999, 'global', NULL, NULL, '2021-10-06 15:33:50'),
(159, 'Metabase Token', 'METABASE_TOKEN', NULL, NULL, 'text', NULL, 'Metabase', 1, 1, 999, 'backend', NULL, NULL, '2021-11-21 11:06:46'),
(160, 'Meza Secure Key', 'MEZA_SECURE_KEY', NULL, NULL, 'text', NULL, 'Meza', 1, 1, 999, 'backend', NULL, NULL, NULL),
(161, 'Meza Merchant ID', 'MEZA_MERCHANT_ID', NULL, NULL, 'text', NULL, 'Meza', 1, 1, 999, 'backend', NULL, NULL, NULL),
(162, 'Meza Terminal ID', 'MEZA_TERMINAL_ID', NULL, NULL, 'text', NULL, 'Meza', 1, 1, 999, 'backend', NULL, NULL, NULL),
(163, 'NBE Username', 'NBE_USERNAME', NULL, NULL, 'text', NULL, 'NBE', 1, 1, 999, 'backend', NULL, NULL, NULL),
(164, 'NBE Password', 'NBE_PASSWORD', NULL, NULL, 'text', NULL, 'NBE', 1, 1, 999, 'backend', NULL, NULL, NULL),
(165, 'NBE Merchant ID', 'NBE_MERCHANT_ID', NULL, NULL, 'text', NULL, 'NBE', 1, 1, 999, 'backend', NULL, NULL, NULL),
(166, 'QNB Base Url', 'QNB_BASE_URL', NULL, NULL, 'text', NULL, 'QNB', 1, 1, 999, 'backend', NULL, NULL, NULL),
(167, 'Vodafone IFrame ID', 'VODAFONE_IFRAME_ID', NULL, NULL, 'text', NULL, 'Paymob', 1, 1, 999, 'backend', NULL, NULL, NULL),
(168, 'QNB Merchant ID', 'QNB_MERCHANT_ID', NULL, NULL, 'text', NULL, 'Bank Integration', 1, 1, 999, 'backend', NULL, NULL, NULL),
(169, 'QNB Username', 'QNB_USERNAME', NULL, NULL, 'text', NULL, 'Bank Integration', 1, 1, 999, 'backend', NULL, NULL, NULL),
(170, 'QNB Password', 'QNB_PASSWORD', NULL, NULL, 'text', NULL, 'Bank Integration', 1, 1, 999, 'backend', NULL, NULL, NULL),
(171, 'QNB Checkout JS', 'QNB_CHECKOUT_JS', NULL, NULL, 'text', NULL, 'Bank Integration', 1, 1, 999, 'backend', NULL, NULL, NULL),
(172, 'QNB Gateway Url', 'QNB_GATEWAY_URL', NULL, NULL, 'text', NULL, 'QNB', 1, 1, 999, 'backend', NULL, NULL, NULL),
(173, 'NBE Gateway Url', 'NBE_GATEWAY_URL', NULL, NULL, 'text', NULL, 'NBE', 1, 1, 999, 'backend', NULL, NULL, NULL),
(174, 'Ordering Notifiers List', 'ORDER_NOTIFIER_EMAILS', NULL, NULL, 'text', NULL, 'Ecommerce', 0, 1, 999, 'backend', NULL, NULL, NULL),
(175, 'Enable Districts', 'ENABLE_DISTRICT', NULL, '0', 'switch', NULL, 'Ecommerce', 1, 1, 999, 'global', NULL, NULL, '2022-03-30 11:37:22'),
(176, 'Facebook Conversion Api Version', 'FACEBOOK_CONVERSION_API_VERSION', NULL, NULL, 'text', NULL, 'Ecommerce', 1, 1, 999, 'global', NULL, NULL, NULL),
(177, 'Facebook Conversion Access Token', 'FACEBOOK_CONVERSION_ACCESS_TOKEN', NULL, NULL, 'text', NULL, 'Ecommerce', 1, 1, 999, 'global', NULL, NULL, NULL),
(178, 'Facebook Conversion Pixel Id', 'FACEBOOK_CONVERSION_PIXEL_ID', NULL, NULL, 'text', NULL, 'Ecommerce', 1, 1, 999, 'global', NULL, NULL, NULL),
(179, 'Order Policy Text En', 'ORDER_POLICY_TEXT_EN', NULL, NULL, 'html', NULL, 'Web', 1, 1, 999, 'customer', NULL, NULL, NULL),
(180, 'Order Policy Text Ar', 'ORDER_POLICY_TEXT_AR', NULL, NULL, 'html', NULL, 'Web', 1, 1, 999, 'customer', NULL, NULL, NULL),
(181, 'Enable Phone Login', 'enablePhoneLogin', NULL, '0', 'switch', NULL, 'Web', 0, 1, 999, 'customer', NULL, NULL, '2022-03-30 11:37:22'),
(182, 'Payment Targets', 'PAYMENT_TARGETS', NULL, '250000', 'float', NULL, 'Ecommerce', 0, 1, 999, 'global', 'Total payment purchase targets', NULL, '2021-12-16 10:32:34');

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

CREATE TABLE `contact_us` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `resolved` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_en` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_ar` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency_code_en` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency_code_ar` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `flag` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_prefix` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_length` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `phone_pattern` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `default_language` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fallback` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name_en`, `name_ar`, `country_code`, `currency_code_en`, `currency_code_ar`, `flag`, `phone_prefix`, `phone_length`, `phone_pattern`, `default_language`, `fallback`, `created_at`, `updated_at`) VALUES
(1, 'Egypt', 'مصر', 'EG', 'EGP', 'ج.م', 'https://upload.wikimedia.org/wikipedia/commons/thumb/f/fe/Flag_of_Egypt.svg/125px-Flag_of_Egypt.svg.png', '+2', 11, '(010|011|012|015)([0-9]{8})', 'AR', 1, NULL, NULL),
(2, 'Qatar', 'قطر', 'QA', 'QR', 'ر.ق', 'https://upload.wikimedia.org/wikipedia/commons/thumb/6/65/Flag_of_Qatar.svg/125px-Flag_of_Qatar.svg.png', '+974', 8, '(30|33|70|77|55|66|60|50|74|44|40)([0-9]{6})', 'AR', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customer_request`
--

CREATE TABLE `customer_request` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer_request`
--

INSERT INTO `customer_request` (`id`, `name`, `mobile`, `created_at`, `updated_at`) VALUES
(48, 'Mohamed Gamal', '01278781007', '2022-07-19 14:46:55', '2022-07-19 14:46:55'),
(61, 'muhanad', '01110032911', '2022-10-30 08:52:30', '2022-10-30 08:52:30');

-- --------------------------------------------------------

--
-- Table structure for table `custom_ads`
--

CREATE TABLE `custom_ads` (
  `id` int(10) UNSIGNED NOT NULL,
  `name_en` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name_ar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description_ar` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description_en` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `image_en` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_ar` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_web` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_web_ar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `deactivation_notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dev_key` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `link` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `custom_ads`
--

INSERT INTO `custom_ads` (`id`, `name_en`, `name_ar`, `description_ar`, `description_en`, `type`, `image_en`, `image_ar`, `image_web`, `image_web_ar`, `active`, `deactivation_notes`, `dev_key`, `item_id`, `created_at`, `updated_at`, `link`) VALUES
(0, 'Top AD', 'الاعلان العلوي', 'الاعلان العلوي', 'Top AD', 0, 'https://my-demoapi.el-dokan.com/storage/uploads/4aZFbk-1634394311.png', 'https://my-demoapi.el-dokan.com/storage/uploads/4aZFbk-1634394311.png', 'https://my-demoapi.el-dokan.com/storage/uploads/4aZFbk-1634394311.png', 'https://my-demoapi.el-dokan.com/storage/uploads/4aZFbk-1634394311.png', 1, NULL, '#ffffff', NULL, '2020-05-10 23:18:44', '2021-10-16 16:25:18', NULL),
(1, 'Bottom AD', 'الاعلان السفلي', 'الاعلان السفلي', 'Bottom AD', 0, 'https://my-demoapi.el-dokan.com/storage/uploads/4aZFbk-1634394311.png', 'https://my-demoapi.el-dokan.com/storage/uploads/4aZFbk-1634394311.png', 'https://my-demoapi.el-dokan.com/storage/uploads/4aZFbk-1634394311.png', 'https://my-demoapi.el-dokan.com/storage/uploads/4aZFbk-1634394311.png', 1, NULL, '#ffffff', NULL, '2020-05-10 23:18:44', '2021-10-12 13:22:52', NULL),
(2, 'AD ONE', 'اعلان 1', 'اعلان 1', 'AD ONE', 0, 'https://my-demoapi.el-dokan.com/storage/uploads/4aZFbk-1634394311.png', 'https://my-demoapi.el-dokan.com/storage/uploads/4aZFbk-1634394311.png', 'https://my-demoapi.el-dokan.com/storage/uploads/4aZFbk-1634394311.png', 'https://my-demoapi.el-dokan.com/storage/uploads/4aZFbk-1634394311.png', 1, NULL, '1', NULL, '2020-05-10 23:18:44', '2021-09-29 12:36:22', NULL),
(3, 'AD TWO', 'اعلان 2', 'اعلان 2', 'AD TWO', 0, 'https://my-demoapi.el-dokan.com/storage/uploads/4aZFbk-1634394311.png', 'https://my-demoapi.el-dokan.com/storage/uploads/4aZFbk-1634394311.png', 'https://my-demoapi.el-dokan.com/storage/uploads/4aZFbk-1634394311.png', 'https://my-demoapi.el-dokan.com/storage/uploads/4aZFbk-1634394311.png', 1, NULL, '0', NULL, '2020-05-10 23:19:35', '2021-09-29 16:48:47', NULL),
(4, 'AD THREE', 'اعلان 3', 'اعلان 3', 'AD THREE', 0, 'https://my-demoapi.el-dokan.com/storage/uploads/4aZFbk-1634394311.png', 'https://my-demoapi.el-dokan.com/storage/uploads/4aZFbk-1634394311.png', 'https://my-demoapi.el-dokan.com/storage/uploads/4aZFbk-1634394311.png', 'https://my-demoapi.el-dokan.com/storage/uploads/4aZFbk-1634394311.png', 1, NULL, '2', NULL, '2020-05-10 23:19:43', '2021-03-24 11:03:54', NULL),
(5, 'AD FOUR', 'اعلان 4', 'اعلان 4', 'AD FOUR', 0, 'https://my-demoapi.el-dokan.com/storage/uploads/4aZFbk-1634394311.png', 'https://my-demoapi.el-dokan.com/storage/uploads/4aZFbk-1634394311.png', 'https://my-demoapi.el-dokan.com/storage/uploads/4aZFbk-1634394311.png', 'https://my-demoapi.el-dokan.com/storage/uploads/4aZFbk-1634394311.png', 1, NULL, 'top-panner3', NULL, '2020-05-10 23:19:47', '2021-03-24 11:05:04', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `deliverer_district`
--

CREATE TABLE `deliverer_district` (
  `district_id` bigint(20) UNSIGNED NOT NULL,
  `deliverer_profile_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deliverer_profiles`
--

CREATE TABLE `deliverer_profiles` (
  `id` int(10) UNSIGNED NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `area_id` int(10) UNSIGNED DEFAULT NULL,
  `unique_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `city_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `deliverer_profiles`
--

INSERT INTO `deliverer_profiles` (`id`, `status`, `area_id`, `unique_id`, `image`, `created_at`, `updated_at`, `user_id`, `city_id`) VALUES
(3626, 3, 140, NULL, NULL, '2021-09-05 13:38:35', '2021-09-05 13:38:35', 1017259, 12),
(3627, 3, 140, NULL, NULL, '2021-09-05 13:38:37', '2021-09-05 13:38:37', 1017260, 12),
(3628, 3, 276, NULL, NULL, '2021-09-07 11:15:07', '2021-09-07 11:15:07', 1017266, 25),
(3629, 3, 415, NULL, NULL, '2021-09-08 16:16:12', '2021-09-08 16:16:12', 1017271, 9),
(3630, 3, 105, NULL, NULL, '2021-09-09 14:45:35', '2021-09-09 14:45:35', 1017280, 7),
(3631, 3, 79, NULL, NULL, '2021-09-13 13:44:53', '2021-09-13 13:44:53', 1017291, 8);

-- --------------------------------------------------------

--
-- Table structure for table `delivery_fees`
--

CREATE TABLE `delivery_fees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `source` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `source_id` int(11) DEFAULT NULL,
  `fees` decimal(8,2) NOT NULL,
  `weight_from` int(11) NOT NULL DEFAULT 0,
  `weight_to` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `delivery_fees`
--

INSERT INTO `delivery_fees` (`id`, `source`, `source_id`, `fees`, `weight_from`, `weight_to`, `created_at`, `updated_at`) VALUES
(1, 'city', 85, '5.00', 0, 20, '2021-09-07 12:50:54', '2021-09-07 12:50:54'),
(2, 'city', 85, '15.00', 22, 30, '2021-09-07 12:50:54', '2021-09-07 12:50:54'),
(3, 'city', 85, '20.00', 32, 50, '2021-09-07 12:50:54', '2021-09-07 12:50:54'),
(4, 'city', 86, '5.00', 0, 20, '2021-09-07 12:51:36', '2021-09-07 12:51:36'),
(5, 'city', 86, '15.00', 22, 30, '2021-09-07 12:51:36', '2021-09-07 12:51:36'),
(6, 'city', 86, '20.00', 32, 50, '2021-09-07 12:51:36', '2021-09-07 12:51:36'),
(7, 'city', 87, '5.00', 0, 20, '2021-09-07 13:02:46', '2021-09-07 13:02:46'),
(8, 'city', 87, '15.00', 22, 30, '2021-09-07 13:02:46', '2021-09-07 13:02:46'),
(9, 'city', 87, '20.00', 32, 50, '2021-09-07 13:02:46', '2021-09-07 13:02:46'),
(10, 'city', 88, '10.00', 10, 100, '2021-09-07 13:04:01', '2021-09-07 13:04:01'),
(11, 'city', 88, '20.00', 20, 200, '2021-09-07 13:04:01', '2021-09-07 13:04:01'),
(12, 'city', 94, '5.00', 0, 20, '2021-09-07 15:17:41', '2021-09-07 15:17:41'),
(13, 'city', 94, '15.00', 22, 30, '2021-09-07 15:17:41', '2021-09-07 15:17:41'),
(14, 'city', 94, '20.00', 32, 50, '2021-09-07 15:17:41', '2021-09-07 15:17:41'),
(15, 'city', 103, '20.00', 0, 0, '2021-09-07 15:26:40', '2021-09-07 15:26:40'),
(16, 'city', 105, '5.00', 0, 20, '2021-09-07 15:28:38', '2021-09-07 15:28:38'),
(17, 'city', 105, '15.00', 22, 30, '2021-09-07 15:28:38', '2021-09-07 15:28:38'),
(18, 'city', 105, '20.00', 32, 50, '2021-09-07 15:28:38', '2021-09-07 15:28:38'),
(24, 'area', 541, '12.00', 0, 0, '2021-09-07 16:05:16', '2021-09-07 16:05:16'),
(25, 'city', 111, '10.00', 10, 10, '2021-09-07 16:05:59', '2021-09-07 16:05:59'),
(26, 'city', 111, '20.00', 20, 20, '2021-09-07 16:05:59', '2021-09-07 16:05:59'),
(31, 'city', 112, '105.00', 0, 0, '2021-09-07 16:14:18', '2021-09-07 16:14:18'),
(34, 'area', 542, '951.00', 0, 0, '2021-09-07 16:21:46', '2021-09-07 16:21:46'),
(37, 'district', 1816, '164.00', 164, 164, '2021-09-07 16:25:24', '2021-09-07 16:25:24'),
(38, 'district', 1816, '165.00', 165, 165, '2021-09-07 16:25:24', '2021-09-07 16:25:24'),
(39, 'city', 113, '10.00', 5, 10, '2021-09-08 15:04:39', '2021-09-08 15:04:39'),
(40, 'area', 543, '10.00', 5, 10, '2021-09-08 15:12:53', '2021-09-08 15:12:53'),
(47, 'district', 1817, '80.00', 5, 10, '2021-09-08 16:02:56', '2021-09-08 16:02:56'),
(48, 'city', 114, '40.00', 0, 0, '2021-09-09 12:43:45', '2021-09-09 12:43:45'),
(49, 'area', 544, '50.00', 0, 0, '2021-09-09 12:44:33', '2021-09-09 12:44:33'),
(51, 'area', 540, '10.00', 1, 5, '2021-09-09 12:46:45', '2021-09-09 12:46:45'),
(52, 'area', 79, '70.00', 0, 0, '2021-09-09 12:47:29', '2021-09-09 12:47:29'),
(53, 'district', 1814, '50.00', 0, 0, '2021-09-09 12:48:21', '2021-09-09 12:48:21'),
(56, 'area', 545, '20.00', 0, 0, '2021-09-09 13:03:27', '2021-09-09 13:03:27'),
(57, 'area', 546, '20.00', 0, 0, '2021-09-09 13:03:29', '2021-09-09 13:03:29'),
(58, 'city', 115, '25.00', 1, 7, '2021-09-09 14:33:18', '2021-09-09 14:33:18'),
(59, 'area', 547, '12.00', 12, 12, '2021-09-09 14:39:48', '2021-09-09 14:39:48'),
(60, 'district', 1818, '12.00', 12, 12, '2021-09-09 14:40:04', '2021-09-09 14:40:04'),
(69, 'city', 10, '80.00', 0, 0, '2021-09-12 09:34:47', '2021-09-12 09:34:47'),
(72, 'city', 106, '80.00', 1, 5, '2021-09-12 12:11:45', '2021-09-12 12:11:45'),
(73, 'area', 334, '70.00', 2, 5, '2021-09-12 15:46:56', '2021-09-12 15:46:56');

-- --------------------------------------------------------

--
-- Table structure for table `device_tokens`
--

CREATE TABLE `device_tokens` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `device` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `device_tokens`
--

INSERT INTO `device_tokens` (`id`, `user_id`, `token`, `device`, `created_at`, `updated_at`) VALUES
(598, 1017373, 'f0IArZKoTkKQMWDTOQRZsi:APA91bEDuyNwaPMiYyIwY2uodcU79IGHXCv87YxezRfLsY5q35L9WXCwCVjI8LRCJZvRAnhf_GvOKv0Z4jCkE4gqC9UrhC0ahR-2TtvNUmzgEzd3ByWe3rwFlPeeB7GokGJjjgjBp-kj', '1', '2021-11-21 14:44:34', '2021-11-21 14:44:34'),
(639, 1017374, 'f-vA_7unRCahckMw5KNnRJ:APA91bFKIf4gKJO6mEfD9Q2weiKCNcjBIh-1uZq5ngPIpHjza350I1yxUBl049XgAglH0Ru8uf1aVa6mpFpTH5K0B22ehd8xk8-pWidzq_-gywx-4_ytHLyddLpr5WUc0IW3A3NnL-JB', '1', '2021-12-13 17:48:43', '2021-12-13 17:48:43'),
(957, 1017374, 'dSKiwpWdbk8bsyC2k-Nlr3:APA91bHY0znV-ER_LKZ4TyxwCDpkUYV0v97YYORvsMRd0_nr4FJVGRXMXNjBwkMfvtM_Xq4BP27EUd84PSO5_KRHnpFZgovjNnlBkYkFfIrLCZInGWoY81U9I7r4VF35hDwJnkfUvWR2', '2', '2021-12-22 16:51:26', '2021-12-22 16:51:26'),
(960, 1017373, 'eZFkuE7sSlGiYSQASaC6Vr:APA91bE1odFael4z-nRebvNINpL-p1uHdq09mD9oi0jjX1BHjRoDjwhqnzBkBdsiYpczxQapQk_tyT2aL6khiQ7sROlYhocYjh38ujFksEqU7R2U4RsCJkSUrfsDU9Cay8kfpm4o_KKH', '1', '2021-12-23 13:56:04', '2021-12-23 13:56:04'),
(979, 1017374, 'dzIetwvl200FrFeYafss9j:APA91bH7iqo2s3Zkwlc51d-EAvRv-6-S1uzkZJ6_pxuSzrFjuzSrD4YUVb3Vq7QCiSkGzbPkse43__Tj30TCkH87WylDBeHDBQxaPPtgJzhlY0WF1yYkbC7wJbDSopa7iDODnbcjwP3H', '2', '2021-12-26 10:54:32', '2021-12-26 10:54:32'),
(1045, 1017374, 'cuCoP09tT-mIzQpxwKyDnT:APA91bGEs1G0ZSOfdFDaHTsPIf1Yj6YdtdsCLhSzGgO_fQOlsZu-dzydqmBMqje4JAz_S6uMzO0ZSHQXCnSkjIESJovWocFG-Vm2TtrHfZuC3XvoWr_PIpvZPM-BWArjsThP0hTzpZhs', '1', '2021-12-28 10:42:35', '2021-12-28 10:42:35'),
(1158, 1017373, 'c9LOq3ZjQ2OokESoUJxglh:APA91bHnN4k5fdz9cxnzfai3M9RAmYOCKnrGYRuBY315k6uHTmryZFE8UscLSnP-8X4EXeIsUzzCc3NNsWd8XiAnI6hxcJL_P3au-V-IaSRzGmmq8YplBad61F_ZV4d51CpztnzkEZI3', '1', '2021-12-29 11:35:54', '2021-12-29 11:35:54'),
(1258, 1017373, 'fVGxgCKcRlCCFq0TT__GLY:APA91bGyQgI1Xo1Eq29oPTnqw8TlGc44NxLoAvsGon9DiGgfBTpVFYVTGYHn5gunivoIz9ACgMf1U0AN1OM104Ax9NFDV1iTIq2P-a1GdP6TwjkUDXjWrZHUeqcTopRwcPmwxpzuoJTm', '1', '2021-12-29 15:17:55', '2021-12-29 15:17:55'),
(1394, 999999, 'ecm4iIuESEKW9aQchh0faS:APA91bEvFc9xZandkFiPZXRvqKIFKRbB5j-wt1hbc3PoKswKYoHkBdfYR-Chj7WbYJ7nNwMrN1FDvvSx-a6aTdSAa4pY4rd8RhwOITUM_PhmsC463ScTqD9y7WJLUo13Ox43ArMANsB7', '1', '2022-01-05 16:10:09', '2022-01-05 16:10:09'),
(1413, 1017373, 'dFgKiuuiRfWCfXEeggJHeW:APA91bEaepWCF0KNn57deA0koku1wROzno6104sXmsbrDMHSlcxZI28WRzEArCkBiM7lG8zssNcTUlH1UWTewFgrIbvl_heSCeZf0HP0OW4QsmNa_flmNNEBQGAqTjXKA_U5JLU1wEeO', '1', '2022-01-06 18:02:54', '2022-01-06 18:02:54'),
(1559, 1017383, 'cSwRUO4FS2mYdZYDCsdoew:APA91bHMUjuS6rh8lbGNdF_nrUlKBEXElB2LHbEx7TCJl4bZy53Gqm2_K5IjjhqjdJ0rsiYd4hoglrLg9HxBRoBZ9BnIjLilDm6K3KcnFC6JRh4yXzlUJqO91A30yZ4SGsYXkChY1ZVA', '1', '2022-01-12 19:53:41', '2022-01-12 19:53:41'),
(1567, 1017373, 'd862GEgaSPynek3xs_sUZs:APA91bEBEzhWN2Z_A4KdXdo1UYyqw8Oy3PxqKoUiCdTqrtNdkcim-ol36jYIkg75c0jcdj5GpQXWqTG4m6ijwzUJaS_aHRhtYNdeeW95C1NZ3OZpa2O6yINrY028TQiQt6RWrPSg6KTy', '1', '2022-01-12 22:27:13', '2022-01-12 22:27:13'),
(1627, 1017381, 'dTvZmF2_TDOKZtsR_SpDxp:APA91bERwBUP3gAlfamFryWvWP0F0igy-abgWOVq5Yea0RqXv8reHJaKDl9DU0TNRq_SKKw195r99cnSZvTGviY3u4BQG-Htt8TNR-OTlN_2d645FXSPLqvwRFx6UdEFgiBk_BQ2Dseq', '1', '2022-01-13 15:33:24', '2022-01-13 15:33:24'),
(1643, 1017384, 'eR4zEOvgTiWHIyZhrtXBZI:APA91bEF7__LRxfXZe7aBYpGh1N5QGWDOuXmEiM9P1hVP9xLf1J6WEGgN78oTqGpCscW7mNvHYNC85B776F9OBzUjDhdkFxTOEpt1TpkZWBL_tsHiZtDzAKvEaREVLAWga0-UNzgQEbo', '1', '2022-01-16 12:23:04', '2022-01-16 12:23:04'),
(1663, 1017383, 'cSwRUO4FS2mYdZYDCsdoew:APA91bEvDnG4f4CGTBwy2wW78Wcj1QheXU62CGtC_Djtj7Zr7kEtUuuf-1uMhG-pKi7TG8EHCRdah0oKEVRC5uLZjOJZBDG-QNgveG-pKz0AqfEP1GLCAutfee-I-Jl8y8CJAShBLEVL', '1', '2022-01-16 15:15:44', '2022-01-16 15:15:44'),
(1675, 1017374, 'f20SGsJr9UqVnW499EUikp:APA91bH-sbPbpwSlOWJORSnmMIL5ArWDW4o3quPLeLyCU87RywLhPXeVp3OJQ2t2A-U980Ku5mhHkdAegD6ICI2qY4PDevh2958BSR_v9kOswrI69ROV18wyrSizGSQCp1Gu5BdTrtPT', '2', '2022-01-16 15:45:14', '2022-01-16 15:45:14'),
(1746, 999999, 'cOEqRDScTUqppqkxWJK7FA:APA91bFz4lIkBB68s_c6_jw0NWiZHARgAaHRkD3QezgLlceJxrj10l9OkbP9WtpFHECgJOn9osSZ146v6DjlBmEJKnth1ssqHJAl2XQy539aee2m9WD_a3G1VxfMRB5XNGYmMx3nRzh0', '1', '2022-03-03 15:21:52', '2022-03-03 15:21:52'),
(1754, 999999, 'cx5x03WKTKGrns25LyH-hy:APA91bFXV8K0HTopPagzCH7VNH-pfpABqg9MJQAh_q_jxCDzcZ5AchhmC0Hw9s6nu45siveMOvlUQyOQkSCO5UIGAY9MBCoDXgOpSRfsX7WcO5PcnVPPPIqIqC-yT3JiwyPJXTfLfSx2', '1', '2022-03-07 17:40:07', '2022-03-07 17:40:07'),
(1841, 1000000, 'fWC3_tjuS9Ge9KKJwZy6kc:APA91bGSVan8j_GTlaVRx2CmO50i4Jyusrla-4DHKFQRINyPAdww6HPuEE6cpBLIR2nsfO_4rdGTZ8s1U9FEFY476RZI3PI0mBM74wADBgyMbDl7vjJnMFvW6b2efF_wTdR62Dx5UBMT', '1', '2022-03-21 15:46:14', '2022-03-21 15:46:14'),
(2501, 1000004, 'dFPvrZ9SfE5hidQ8OLHbaC:APA91bGTwYceACEqojUDgscFwW3GjdGUiKIJBYQztaSxoB-Du3NZ8VWOCi1pU7E_fnGYfYn3itNyU7rsZoHX8cgkU6I_C8wI53p1PFYYogiR2HlZntGUOvV7EQzlZjOC4MsCLmrCtmPe', '2', '2022-04-05 13:21:19', '2022-04-05 13:21:19'),
(2674, 1000004, 'cWfqgPC4TOCMj-7I7Qxcrw:APA91bFWaldQ-rANqMTvPTMvmwExThmREyIq1goUK88lUS5C0sW_9oA_UAZ0p2-Ix-OJ5iH7--5XIYrzfNKL2jptzv8YiXWa5gL1LICxrNO_Wt4NuiDiZFIC2_PMgvjnUhd4rRSLoYra', '1', '2022-04-14 09:17:01', '2022-04-14 09:17:01'),
(2688, 1000010, 'dUq4CdUGQ1u7lJKxv7Ba_v:APA91bHsVMWElBLeOWyOyap2AJ_52viQkDwsV2RliORVRULYc6ldGRbHU2biiVXhIZJOs90JRaMo3sqxXtybJvCYx-WmpxMcstV9XvtNOJwYdFwSlHCw15X-qHY5mKohei_WTpQ8dzCM', '1', '2022-04-18 14:20:31', '2022-04-18 14:20:31'),
(2689, 1000010, 'dl3QG-JPScKRDF9S73kYcl:APA91bGYS51UDOMEi00PC03Tg6W8K3wX6NifI7gK8PiVkrvP6hIgRQ6KUYKgh7D4htcfruGT32ESM_wZbZ3UMDxezko7vYcMqcrqazj8aLOqA1gFfhBC9bJh2INztCVkDq0rcOQTN3su', '1', '2022-04-19 11:49:38', '2022-04-19 11:49:38'),
(2716, 1000010, 'exYFY_7MTcWE6ZMyob0ay4:APA91bGD9yLytLJlzqIcfs---o8QWTX_dJ_F1i5p6ZpK4QhB1NKcKa492N5Gr4KFFBWzNhGmsuxJZsBQgO8hE6O2ctlRjbACjtGbHL6BznsL5-EvwGImRrzBO1ACwGWqSgGt1Ck7Vmjk', '1', '2022-05-21 13:28:48', '2022-05-21 13:28:48'),
(2894, 1000001, 'fQ3WHk7CuULznpOGasEcKj:APA91bERVneozrdEpT_yablBMb92UkcSsfOZKxYmW_dVsacM6FRAqTcV5vBBzfbveJG1mr0_-aaPLV5_uB0iyMbdO7gc9dzPGubB2qeZ7Dx8XRGXP7mbvfqj8TQ90VpcTshbRCxRFGyX', '2', '2022-05-25 13:31:08', '2022-05-25 13:31:08'),
(2990, 1000001, 'cZg7x0T6UU7ss6XNg-FOB0:APA91bFRpXbGoMedYxj0Z1lLk8f1fyHhK-qdWZQcMCNvjiv6_LkHSHcZv6IABYSu3TNuBcy9UwSy6T8Nq9VaxrmdoBa8UvcOCkgsma1bVQdO7IA0KEr2OHKD2-AJgeHU3A6nZK05rR_f', '2', '2022-05-25 15:22:32', '2022-05-25 15:22:32'),
(2994, 1000001, 'ewaiCfOfr04gk1nkou26RP:APA91bGNVZemL6RVzNJZPGimjb_QDu25zdXai_rQnJLzEyGhXgO4_Ogh-_RK3-ZmfWDyibVSuXDjAJ_tDtUgIM3ig4MXHIoTPazX4Xcx4NPQ8CsbeNzFu9cV4g94AjGfmA8eOsBiJGmr', '2', '2022-05-25 16:17:53', '2022-05-25 16:17:53'),
(3043, 1000001, 'eHLVFCFPF0IlkAvnZ3msH5:APA91bH8f-icVql72Qsk4WnKRClCstpELYpl3VMVRRUENxV9c9onOPHrz04CJwl3UKyF8KIIbLn9gRualWCz3XpN7WFLPuse7UxONtMkSqis3Zm8mUgZtd0hxPf2HrhQSh62dZoETukJ', '2', '2022-05-26 18:01:34', '2022-05-26 18:01:34'),
(3147, 1000001, 'fMJ7sw_kVUwrnLRuXRN3pl:APA91bH2l1Xu08rvS2nLUL5wrUx6ckMMXIIdIlVEbqAm8WclNnVyRB6_WzrgxfMrmQXT5G2Oj6rfdcuJepQwObvNHR5xzby10dPBCvJNkvBMLZVmA546hP3Nsi6R8oKoVulT0E5NvmZ0', '2', '2022-05-29 15:50:16', '2022-05-29 15:50:16'),
(3151, 1000001, 'e5VBBwe6h0f3tZf3ZdoQTH:APA91bFKH8ocG4tOslFoU-VJgG8bgSvHEjg9VO-qXBp9NoXdAWTkF0S7e5cAJtMIG4w4-VKObT-Br1YzQOoKe659YCP9UBOHQVKX2LFNdBzHtZir0WkCA8kgYKcDSFlb8QN3Bg5Ugrv4', '2', '2022-05-29 16:06:08', '2022-05-29 16:06:08'),
(3213, 1000001, 'dgDfAZkca0GPqFMR41WTOh:APA91bFk--qjYwsP_Ln7sMh8jx5NXdQRMQYDBTnQWht8jRyfiBgmEzrVFeDJ3O0qU9uecdBOJaXZZoup8OkpN3FDT6s-UCFSzxsd-RiIpk84K47nYYcsbfTYW8cTzIjJbbeSAismL8AN', '2', '2022-05-30 11:31:01', '2022-05-30 11:31:01'),
(3225, 1000001, 'fZHC4tYPkEJHl1biLzq04L:APA91bGSZvTfJKDWuDtoUasFMpVyTJgJqA_gfiQNWRibTy7gP4uEvOmFA27DSHu0rZZIWoqxHuWsBYevc1joAvF3XqBfk79XHCMWO0KkKVKlQyH36eSIcKmnjLGU7sC8yvCkodtJk0SI', '2', '2022-05-30 11:45:53', '2022-05-30 11:45:53'),
(3231, 1000001, 'cYtySB7aJEihgltHN7wB_Z:APA91bE1TINeG6_khPzPaOuU_G40bI7OVDC1GjJDudI4JJs2CmbxZIayIf87rgwDMQSHbtwgkhNLF2fCOaRYO-LBAiq0jHs3LwRE4dmGMEcop26CMk_eePP-QMCWFM8DatcJTo9yrzPR', '2', '2022-06-01 17:21:05', '2022-06-01 17:21:05'),
(3315, 1000004, 'euSBxNkqSvGkclyJLF2ycj:APA91bEK9ETTtW0tvO4Ua-p68CRw0JBcU7DNaoGlK0E8iV4rmnABoZFu_9JSMGXam9cbnsckZE-JYKKSJizve-iYVpjxQEexjCQm1bBQqFzXz3L1bY4k1AMnEsMMKMTo7l58b_nxECeJ', '1', '2022-06-20 13:41:22', '2022-06-20 13:41:22'),
(3316, 1000004, 'euSBxNkqSvGkclyJLF2ycj:APA91bEK9ETTtW0tvO4Ua-p68CRw0JBcU7DNaoGlK0E8iV4rmnABoZFu_9JSMGXam9cbnsckZE-JYKKSJizve-iYVpjxQEexjCQm1bBQqFzXz3L1bY4k1AMnEsMMKMTo7l58b_nxECeJ', '1', '2022-06-20 13:41:22', '2022-06-20 13:41:22'),
(3342, 1000004, 'cSx_4DHoSl6nPQUFbfjovZ:APA91bEY0psY8qidxekNF3sUaUjYD6DC1l2pZsP-LK1p9tvY92wbzEsBEpl53B0G9tLqAUbZKo_yhayyZZqGjOYe810l2Hn8ISX9vYNfEes2XP5hmecn2PBjKvrcePkeGS1xxLbVPeix', '1', '2022-06-22 16:53:41', '2022-06-22 16:53:41'),
(3352, 999999, 'eB88T3R0S-aTNe6zNf6EjH:APA91bG4lt2-0K8Exk98JqPMkHSut24T1zBuwvp3NS3Wq2ZC-ozXi394GvvX29mlIkBrBaMAJQUIZ9ORkiyH_6P5Yd9JueO1dnz7NPD-UZXSD_XuEv3LcT4UQAeND5_h0YBR-wjYsWJq', '1', '2022-06-26 11:30:00', '2022-06-26 11:30:00'),
(3361, 1000004, 'dSpn1jUvRXir5AYhO5jqOy:APA91bE1c3BvqIEqgqDNIl2b_pNtUStSC04RrEJaBFcFyCFrxir8i2zyuJKTm1dYP4Is7S6jrzcSC5XogLUUPY3oiLmKo1SgR3_Swd29uivQLXOxINVNtIVUWKEq56sGf7HZ1AZT7lBw', '1', '2022-06-26 14:49:04', '2022-06-26 14:49:04'),
(3371, 999999, 'ewe5dKS3RriOoNe7mI8zNi:APA91bGF94KtjOFYfJhi6RKtXDLSuYmFRMhCjhjhHmc-vRM6C60BGfofEZ9dKGh8HHoI4AlXba-dzKEOUr3NkqHk_Z7q9uocR2c1Rhn069QyTcvM-mT2Ko-iCH8vh80oCFyJV8J4EpvR', '1', '2022-06-27 12:47:14', '2022-06-27 12:47:14'),
(3386, 1000004, 'd2fmXL0qQHaYr12N-2nEvF:APA91bGiCls_lPB65z6DWzal-5JYnsE3HT2Lc1fd5DBYgk2B60JslBcv9kySfEdgxBCb8WeAXT2YnpRYMk7Dg8GTaMFp2DUOUngE_nRkB2sGP7a3lQ4P0xC1NgxDIBHzqTzxr-B4EMRl', '1', '2022-06-29 10:21:29', '2022-06-29 10:21:29'),
(3405, 1000003, 'cblo9Pb1R7Kef7sNExY8Fx:APA91bG_zdOkV7jvg9_njQ2QJFNWVr6nvvBsOWguxPtxA61fSkXoRcjnp-8fgvc5Jm7RdeBN03NT4D3zxEUbbxQeA8RSeibevUa7DPRY84X7UDbtMFnga1YxKapjB-IBEKENPrQldkqm', '1', '2022-07-01 15:11:28', '2022-07-01 15:11:28'),
(3411, 1000003, 'dFHNS2SKRTmi4h_5MkKhQf:APA91bHWzuPhVz-zGltZWKXmTIdH3EEqVTAR7l51uIYgUjmA8xTfcvG2Omx-U2vcDsmhCAo7ecpJNQN6wXeJSQ1sRDl8lw5QmnOWb_OIk09gFOGScxZCl0yyc3PT4DGK-YEIBzmvKtH9', '1', '2022-07-04 11:02:05', '2022-07-04 11:02:05'),
(3703, 1000025, 'cUeRRft4Qa64O62oO6Oazf:APA91bFyDNIBmNhoBS7wkL-f3P15cKb4PncKGJHHBiaqpWEJUlohlv6GHvAKM9fkoWdwsh7A-C-0SXbubTd6d9icdw90gdCv2VDOVicQrDbRrN7ed3eVqYo9C9LsOAYED6XC2UcMAe4r', '1', '2022-08-04 10:46:26', '2022-08-04 10:46:26'),
(3788, 1000021, 'ft7V4urNSTGlrTUrZADQMa:APA91bGy6FagDe5h0umHg9PXBhu0HaGfovC-pLtywhol2bys8yZQYp1ZskUSoU-yrHLdJ7-OAc32D2dde23rkLZKnqy6vNs-13-BYWlxDNZsGWIhyL-iWp01J8H51iU9d9rGB-7zbo7_', '1', '2022-08-07 15:22:41', '2022-08-07 15:22:41'),
(3800, 1000007, 'czb7V8NbS4yIPFH6fZXQwf:APA91bGMFgqzNl0m5L8H9sXDeJc_NAWXdGRdPXrLBPUbzCmVQJu2Nv34CtdrZDHG7i8Vh_mH7CrdejFNTlDbLyXap-G-F0dAV4SYfc4gd57koty3VBWjcNIBSXXCJX8iotjY5G_IUgqI', '1', '2022-08-08 12:16:44', '2022-08-08 12:16:44'),
(3873, 1000023, 'eafu0L4PQ7Cli5g0G7q2z0:APA91bFcqAdl-gsNjxXIe_JYGJY3TEFgS7gRp21_TnT7U5y2avc8JLZfRFEQzC8JIYjruAdRXn42QMo1Vc5UUSQ8tMnkIcYvh-ERKK9wFWUPNPFmqspt-cuRe5DWsttFDPfQZtsMf9Cl', '1', '2022-08-14 19:13:10', '2022-08-14 19:13:10'),
(3876, 1000020, 'f5bBHhtRRfefXA-6QzYWiA:APA91bGwMMFdheQxoU9G1zVvepWnqkPXUWcSOcA1LgsjA8RppJwHuCTvX0yFgV_4Asvfm3Ztv4ibI0OL3sZxSTpuKj1VSoE5TCm7NVc2yGsXMjZ3778DExCC3uA2P883OajUIKaSXWoI', '1', '2022-08-15 10:07:09', '2022-08-15 10:07:09'),
(3877, 1000006, 'c70fT1Y-T22ZhBaHfTwTwR:APA91bEc398mOfZbBByF-dFrHj0K_7GbkDd4d11jnOS_FTpF1OJGQaDoC0fBilESqF3jVbWR5N7PSLp_EUUQusZDEH49AzpxC6si0c-bOJAYY8fdVh_fFTeMr7bQIYD2fGZ2bpAItYNp', '1', '2022-08-15 11:50:07', '2022-08-15 11:50:07'),
(3882, 1000008, 'dOKf3oQVSsW5yyKXvxHFIU:APA91bFbOSdTcF9LDZBhOdq1u1RISn_PKmVyHOasFHXUvVLkf54uF_bXy7Skov9ikQlgocVYn3wrKCpnbG5_0F8HmgEoNajrYRhVkA7d9xNihr77oBmul5vPIvyC2li_OCk48pFaiuGo', '1', '2022-08-16 11:47:58', '2022-08-16 11:47:58'),
(3902, 1000017, 'f5AUHCK8T0ujOoE_-BRLuo:APA91bH2Tms-fWV0wFZq_QxNTWiB2mGjGXdKTbI5k7j9Njh8SbmeHJNH-r0OcaObRZ0jkI01bd1Oganvefcd7vTHg-jLydIPTeXUTzUC_W83IhqIjKv19Ph2D9BnHzIN0Nuiitpzig1K', '1', '2022-08-20 20:15:47', '2022-08-20 20:15:47'),
(3923, 1000024, 'ddYdUv3BS0Stx9q9HbgmT9:APA91bEE6PsD8wIumOiNV5Ww-VuXOnQGPXaf3_o0l0unToyAxIR-gqXkrRvtJr2WuksHf834LpZT25VZdb_iqrrrLqGgffkkbAgSGLDo1UWuvIpsIQA4P_cvlB98XhvYWDb1Q9IAhXd-', '1', '2022-08-27 00:15:52', '2022-08-27 00:15:52'),
(3934, 1000002, 'd5xS0JfcQaKWqSykT4VSVu:APA91bG1QE4tEHPQoxX-VGam1ttWdhG-3rfYS8B4CUlOds3QrSek2GNVnvvM8eFUoarNMOAnk7MJKj5wR59tAPKRzSVniugaGc7CSxgJpjL_TajwcsKHAw93ePhU8XRTtscIWA1Su7ey', '1', '2022-09-05 10:28:19', '2022-09-05 10:28:19'),
(3935, 1000022, 'cvVSQyFwQI-VcDFxoBm48h:APA91bH1ssTIUZf4Df_CdfcINsE-URYeLRv5SIQd94qAo5p-2SuWsqcEaUpf35NpMLCZIdAnYd3-J5_nq2Kz3K95AYOZ23g2dilgcQyqiSwG53N_WxMWrymk9J7pxIFtK8rrJOdxoK8O', '1', '2022-09-07 12:33:12', '2022-09-07 12:33:12'),
(3936, 1000014, 'e-_vmvfTQzyYYNjo9LOQqR:APA91bEO7ziql7QlE98XUiY4REg3EtuxDT0t9o62V1WJQdEF0S1cMjhVZXsvHcLGLgILBrTEmDD09SDA34zD38w5or7mZcR9JqxdvOieYnY1nDiLwADq4H7oRQ7Uz136NG7hy98ZeX1n', '1', '2022-09-08 16:56:12', '2022-09-08 16:56:12'),
(3939, 1000003, 'dF6mJQChT3KOu_oQl390GN:APA91bGjkWY2K1lUz_U-G5brenpQcs569ZORJrYCocBEnv8xVpBITz0ubXlexApkT3EXNOKvEjdlsyuNNwFNCRV2Dyc05W3L1_vJK9TIZRU59FkShK6VgcTipmqWKCU3Chi6ShrnbCH8', '1', '2022-09-11 17:28:18', '2022-09-11 17:28:18'),
(3940, 1000001, 'cEOjx3vER_CkdnGgD-Zgw1:APA91bES1RgqCJMtrfMKy4b5iLmBwU3hs6pZNuS0iGH3GZ50irB8WoJkmC99QlcrOqYi8I80arHpttLx1cG0Rqh7LYi6tWGKR89VTFpP0XbxIz9R6poA27xGeZtEWJysj_eq6lwx-pBl', '1', '2022-09-13 13:58:55', '2022-09-13 13:58:55'),
(3942, 1000025, 'cjkEeLUNQNqOTU8QqpNbi4:APA91bGAoOINri3SfcshRFQje6vzf8eBYqYbtJgK84JklbxoLG8QFXpFWCsnGSwkdvF5e4I-N2QxSbN0bt2FBFmEQyUWI5FRdDLh3FxJyreiFJmFwkdqZfp_LvkwyC6BWFUT5aBmmtGN', '1', '2022-09-14 22:00:17', '2022-09-14 22:00:17'),
(3946, 1000011, 'dNRZH4JwQxuJaVLxwthRXe:APA91bFp52w8uXZtcD41IFoHSaz3Tb6BlKzRpL0i4XXHycBR40qKTiwZlNHlmQuT--dmgO3ISjWcCmlwCSFsGbp7KQ2dTe8KQC80oiCv-aVxVhhhl527wODqm4Ajm6SurhDIOjGRi-S-', '1', '2022-09-28 10:28:30', '2022-09-28 10:28:30'),
(3947, 1000019, 'epddHLsxSv-_WtTsLVtsMr:APA91bE2KN6hkesaZRamNEUQ5nFovPKGvrwX1QjnaSSPAXpY_evpDzGswijofdPuS_pL2yRQcMJPWsAtFfP756dZkNaWhzmBTuX-FEg1H0OeHik8qFx7xr6F5QrySkK5ZKXj5u9i1t7T', '1', '2022-10-05 15:15:50', '2022-10-05 15:15:50'),
(3948, 1000005, 'e4UuBSiuRNa3eAYY5TyhW0:APA91bGAdJAXnXdlHq-AfOOMBGC5W09ovIlqjJ00rwBGluOhaK66FE_Q9zpXmoa3G2j5wtRxFR1G1x3iOW0REFevRkg4COgkAPwwb-rV4Q_j6Y5cXf-H-0VFa_fpogs-IC_stcmw43tW', '1', '2022-10-08 22:11:38', '2022-10-08 22:11:38'),
(3963, 999999, 'e-dfCsaxR-KBPyeo_oLqv2:APA91bE6nvBiVCdjNkrhmMrqeT8-nyKPXsAs_yW4dy8YOERdr4Y-wG6WeZbn12Mqu4BeB6m3hwPGsGH8z0jZebfMs_H6u-wUKuRXAon2uA-p4wdvGfLlvbWBz0f8FUMwqO2lR4jCOrak', '1', '2022-11-03 07:42:04', '2022-11-03 07:42:04');

-- --------------------------------------------------------

--
-- Table structure for table `districts`
--

CREATE TABLE `districts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_ar` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `area_id` int(10) UNSIGNED NOT NULL,
  `delivery_fees` decimal(8,2) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `deactivation_notes` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `delivery_fees_type` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `districts`
--

INSERT INTO `districts` (`id`, `name`, `name_ar`, `area_id`, `delivery_fees`, `active`, `deactivation_notes`, `created_at`, `updated_at`, `delivery_fees_type`) VALUES
(1814, 'ss', 'SS', 79, '0.00', 1, '', '2021-07-02 20:22:44', '2021-09-09 12:51:25', 1),
(1815, 'testarea', 'testarea', 540, '0.00', 1, '', '2021-09-02 17:39:59', '2021-09-02 17:39:59', 1),
(1816, 'test 99 mra action edit', 'test 99 mra action edit', 542, '0.00', 1, '', '2021-09-07 16:22:17', '2021-09-07 16:23:49', 1),
(1817, 'TEST', 'TEST', 543, '0.00', 1, '', '2021-09-08 16:02:56', '2021-09-08 16:02:56', 1),
(1818, 'adsads', 'dasdas', 547, '0.00', 1, '', '2021-09-09 14:40:04', '2021-09-09 14:40:04', 1),
(1819, 'dis', 'dis', 548, '0.00', 1, '', '2021-09-28 09:55:51', '2021-09-28 09:55:51', 1),
(1820, 'area', 'area', 551, NULL, 1, '', '2021-10-06 10:40:43', '2021-10-06 10:40:43', 1),
(1821, 'jhgjhgjgjg', 'fhffhfh', 554, NULL, 1, '', '2021-10-06 15:00:29', '2021-10-06 15:00:29', 1),
(1822, 'district', 'district', 555, NULL, 1, '', '2021-10-10 09:18:23', '2021-10-10 12:21:01', 1);

-- --------------------------------------------------------

--
-- Table structure for table `edara_areas`
--

CREATE TABLE `edara_areas` (
  `id` int(10) UNSIGNED NOT NULL,
  `area_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `area_id` bigint(20) UNSIGNED NOT NULL,
  `edara_id` int(11) DEFAULT NULL,
  `edara_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `edara_drafts`
--

CREATE TABLE `edara_drafts` (
  `id` int(10) UNSIGNED NOT NULL,
  `edara_id` int(11) NOT NULL,
  `product_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sku` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double(10,2) NOT NULL,
  `discount_price` double(10,2) DEFAULT NULL,
  `discount_start_date` datetime DEFAULT NULL,
  `discount_end_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exports`
--

CREATE TABLE `exports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `progress` int(11) NOT NULL DEFAULT 0,
  `state` tinyint(4) NOT NULL DEFAULT 5,
  `finish_date` datetime DEFAULT NULL,
  `type` int(11) NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(10) UNSIGNED NOT NULL,
  `name_en` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name_ar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description_en` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description_ar` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name_en`, `name_ar`, `image`, `description_en`, `description_ar`, `created_at`, `updated_at`, `active`, `slug`, `order`) VALUES
(104, 'DAVIDOFF', 'دافيدوف', 'https://mansourgroupapi.el-dokan.com/storage/uploads/davidoff-classic-550x550h-1637488448.jpeg', 'DAVIDOFF', 'دافيدوف', '2021-11-21 11:54:27', '2022-09-13 15:31:06', 0, NULL, 0),
(105, 'TARGET', 'تارجت', 'https://mansourgroupapi.el-dokan.com/storage/uploads/target-extra-biue-2090x3223-1637488502.jpeg', 'TARGET', 'تارجت', '2021-11-21 11:55:16', '2022-09-13 15:31:10', 0, NULL, 0),
(106, 'TIME', 'تايم', 'https://mansourgroupapi.el-dokan.com/storage/uploads/time-red-550x550-1637488570.jpeg', 'TIME', 'تايم', '2021-11-21 11:56:31', '2022-09-13 15:31:14', 0, NULL, 0),
(107, 'Bic Tray', 'Bic Tray', 'https://mansourgroupapi.el-dokan.com/storage/uploads/Presentation1-1639591993.jpg', 'Bic Tray', 'Bic Tray', '2021-12-15 20:13:30', '2022-09-13 15:31:18', 0, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `import_histories`
--

CREATE TABLE `import_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `progress` int(11) NOT NULL DEFAULT 0,
  `state` tinyint(4) NOT NULL DEFAULT 5,
  `finish_date` datetime DEFAULT NULL,
  `type` int(11) NOT NULL,
  `file_path` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `report` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `cost_amount` int(11) DEFAULT NULL,
  `total_amount` int(11) DEFAULT NULL,
  `paid_amount` int(11) DEFAULT NULL,
  `discount` int(11) DEFAULT NULL,
  `remaining` int(11) DEFAULT NULL,
  `promo_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `delivery_fees` int(11) NOT NULL DEFAULT 0,
  `admin_discount` decimal(8,2) DEFAULT NULL,
  `grand_total` decimal(8,2) DEFAULT NULL,
  `total_delivery_fees` decimal(8,2) DEFAULT NULL,
  `free_delivery` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `order_id`, `cost_amount`, `total_amount`, `paid_amount`, `discount`, `remaining`, `promo_id`, `created_at`, `updated_at`, `delivery_fees`, `admin_discount`, `grand_total`, `total_delivery_fees`, `free_delivery`) VALUES
(42, 1, NULL, 9089500, NULL, NULL, NULL, NULL, '2022-07-20 15:58:49', '2022-07-20 15:58:49', 0, NULL, '90895.00', '0.00', 0),
(43, 2, NULL, 6150000, NULL, NULL, NULL, NULL, '2022-07-21 11:31:41', '2022-07-21 11:31:41', 0, NULL, '61500.00', '0.00', 0),
(44, 3, NULL, 5125000, NULL, NULL, NULL, NULL, '2022-07-21 11:37:29', '2022-07-21 11:37:29', 0, NULL, '51250.00', '0.00', 0),
(45, 4, NULL, 7403500, NULL, NULL, NULL, NULL, '2022-07-23 14:55:23', '2022-07-23 14:55:23', 0, NULL, '74035.00', '0.00', 0),
(46, 5, NULL, 5125000, NULL, NULL, NULL, NULL, '2022-07-24 10:51:02', '2022-07-24 10:51:02', 0, NULL, '51250.00', '0.00', 0),
(47, 6, NULL, 5125000, NULL, NULL, NULL, NULL, '2022-07-25 10:47:03', '2022-07-25 10:47:03', 0, NULL, '51250.00', '0.00', 0),
(48, 7, NULL, 5125000, NULL, NULL, NULL, NULL, '2022-07-25 10:56:44', '2022-07-25 10:56:44', 0, NULL, '51250.00', '0.00', 0),
(49, 8, NULL, 5240550, NULL, NULL, NULL, NULL, '2022-07-25 12:21:18', '2022-07-25 12:21:18', 0, NULL, '52405.50', '0.00', 0),
(50, 9, NULL, 6835500, NULL, NULL, NULL, NULL, '2022-07-25 12:44:07', '2022-07-25 12:44:07', 0, NULL, '68355.00', '0.00', 0),
(51, 10, NULL, 5125000, NULL, NULL, NULL, NULL, '2022-07-25 15:40:30', '2022-07-25 15:40:30', 0, NULL, '51250.00', '0.00', 0),
(52, 11, NULL, 12756350, NULL, NULL, NULL, NULL, '2022-07-26 04:54:22', '2022-07-26 04:54:22', 0, NULL, '127563.50', '0.00', 0),
(53, 12, NULL, 5467100, NULL, NULL, NULL, NULL, '2022-07-26 04:59:15', '2022-07-26 04:59:15', 0, NULL, '54671.00', '0.00', 0),
(54, 13, NULL, 5125000, NULL, NULL, NULL, NULL, '2022-07-26 11:57:46', '2022-07-26 11:57:46', 0, NULL, '51250.00', '0.00', 0),
(55, 14, NULL, 5125000, NULL, NULL, NULL, NULL, '2022-07-26 12:00:59', '2022-07-26 12:00:59', 0, NULL, '51250.00', '0.00', 0),
(56, 15, NULL, 6492100, NULL, NULL, NULL, NULL, '2022-07-26 12:42:00', '2022-07-26 12:42:00', 0, NULL, '64921.00', '0.00', 0),
(57, 16, NULL, 11960500, NULL, NULL, NULL, NULL, '2022-07-27 15:59:25', '2022-07-27 15:59:25', 0, NULL, '119605.00', '0.00', 0),
(58, 17, NULL, 5640000, NULL, NULL, NULL, NULL, '2022-07-27 17:06:05', '2022-07-27 17:06:05', 0, NULL, '56400.00', '0.00', 0),
(59, 18, NULL, 5125000, NULL, NULL, NULL, NULL, '2022-07-27 18:14:06', '2022-07-27 18:14:06', 0, NULL, '51250.00', '0.00', 0),
(60, 19, NULL, 5125000, NULL, NULL, NULL, NULL, '2022-07-28 00:37:25', '2022-07-28 00:37:25', 0, NULL, '51250.00', '0.00', 0),
(61, 20, NULL, 11960500, NULL, NULL, NULL, NULL, '2022-07-28 12:12:48', '2022-07-28 12:12:48', 0, NULL, '119605.00', '0.00', 0),
(62, 21, NULL, 5125000, NULL, NULL, NULL, NULL, '2022-07-28 12:17:39', '2022-07-28 12:17:39', 0, NULL, '51250.00', '0.00', 0),
(63, 22, NULL, 6150000, NULL, NULL, NULL, NULL, '2022-07-28 13:48:59', '2022-07-28 13:48:59', 0, NULL, '61500.00', '0.00', 0),
(64, 23, NULL, 10250000, NULL, NULL, NULL, NULL, '2022-07-29 04:14:10', '2022-07-29 04:14:10', 0, NULL, '102500.00', '0.00', 0),
(65, 24, NULL, 13667750, NULL, NULL, NULL, NULL, '2022-07-30 16:24:53', '2022-07-30 16:24:53', 0, NULL, '136677.50', '0.00', 0),
(66, 25, NULL, 10250000, NULL, NULL, NULL, NULL, '2022-07-31 11:51:29', '2022-07-31 11:51:29', 0, NULL, '102500.00', '0.00', 0),
(67, 26, NULL, 34850000, NULL, NULL, NULL, NULL, '2022-07-31 13:14:18', '2022-07-31 13:14:18', 0, NULL, '348500.00', '0.00', 0),
(68, 27, NULL, 10250000, NULL, NULL, NULL, NULL, '2022-07-31 13:19:06', '2022-07-31 13:19:06', 0, NULL, '102500.00', '0.00', 0),
(69, 28, NULL, 5125000, NULL, NULL, NULL, NULL, '2022-07-31 17:05:39', '2022-07-31 17:05:39', 0, NULL, '51250.00', '0.00', 0),
(70, 29, NULL, 5125000, NULL, NULL, NULL, NULL, '2022-07-31 17:21:45', '2022-07-31 17:21:45', 0, NULL, '51250.00', '0.00', 0),
(71, 30, NULL, 15375000, NULL, NULL, NULL, NULL, '2022-08-01 13:07:04', '2022-08-01 13:07:04', 0, NULL, '153750.00', '0.00', 0),
(72, 31, NULL, 8145000, NULL, NULL, NULL, NULL, '2022-08-01 13:20:30', '2022-08-01 13:20:30', 0, NULL, '81450.00', '0.00', 0),
(73, 32, NULL, 5125000, NULL, NULL, NULL, NULL, '2022-08-01 14:42:23', '2022-08-01 14:42:23', 0, NULL, '51250.00', '0.00', 0),
(74, 33, NULL, 5125000, NULL, NULL, NULL, NULL, '2022-08-01 19:29:55', '2022-08-01 19:29:55', 0, NULL, '51250.00', '0.00', 0),
(75, 34, NULL, 5125000, NULL, NULL, NULL, NULL, '2022-08-02 03:48:28', '2022-08-02 03:48:28', 0, NULL, '51250.00', '0.00', 0),
(76, 35, NULL, 1686000, NULL, NULL, NULL, NULL, '2022-08-02 12:57:37', '2022-08-02 12:57:37', 0, NULL, '16860.00', '0.00', 0),
(77, 36, NULL, 10250000, NULL, NULL, NULL, NULL, '2022-08-02 13:22:15', '2022-08-02 13:22:15', 0, NULL, '102500.00', '0.00', 0),
(78, 37, NULL, 5125000, NULL, NULL, NULL, NULL, '2022-08-02 13:41:51', '2022-08-02 13:41:51', 0, NULL, '51250.00', '0.00', 0),
(79, 38, NULL, 17085500, NULL, NULL, NULL, NULL, '2022-08-02 13:44:46', '2022-08-02 13:44:46', 0, NULL, '170855.00', '0.00', 0),
(80, 39, NULL, 52275000, NULL, NULL, NULL, NULL, '2022-08-02 13:49:42', '2022-08-02 13:49:42', 0, NULL, '522750.00', '0.00', 0),
(81, 40, NULL, 11275000, NULL, NULL, NULL, NULL, '2022-08-02 14:19:24', '2022-08-02 14:19:24', 0, NULL, '112750.00', '0.00', 0),
(82, 41, NULL, 16345000, NULL, NULL, NULL, NULL, '2022-08-02 15:07:44', '2022-08-02 15:07:44', 0, NULL, '163450.00', '0.00', 0),
(83, 42, NULL, 4045000, NULL, NULL, NULL, NULL, '2022-08-02 15:10:04', '2022-08-02 15:10:04', 0, NULL, '40450.00', '0.00', 0),
(84, 43, NULL, 2050000, NULL, NULL, NULL, NULL, '2022-08-02 16:54:40', '2022-08-02 16:54:40', 0, NULL, '20500.00', '0.00', 0),
(85, 44, NULL, 5125000, NULL, NULL, NULL, NULL, '2022-08-02 18:57:54', '2022-08-02 18:57:54', 0, NULL, '51250.00', '0.00', 0),
(86, 45, NULL, 5125000, NULL, NULL, NULL, NULL, '2022-08-02 23:24:11', '2022-08-02 23:24:11', 0, NULL, '51250.00', '0.00', 0),
(87, 46, NULL, 3075000, NULL, NULL, NULL, NULL, '2022-08-03 09:26:21', '2022-08-03 09:26:21', 0, NULL, '30750.00', '0.00', 0),
(88, 47, NULL, 2050000, NULL, NULL, NULL, NULL, '2022-08-03 09:28:40', '2022-08-03 09:28:40', 0, NULL, '20500.00', '0.00', 0),
(89, 48, NULL, 2050000, NULL, NULL, NULL, NULL, '2022-08-03 09:33:06', '2022-08-03 09:33:06', 0, NULL, '20500.00', '0.00', 0),
(90, 49, NULL, 2050000, NULL, NULL, NULL, NULL, '2022-08-03 09:50:57', '2022-08-03 09:50:57', 0, NULL, '20500.00', '0.00', 0),
(91, 50, NULL, 12300000, NULL, NULL, NULL, NULL, '2022-08-03 11:16:21', '2022-08-03 11:16:21', 0, NULL, '123000.00', '0.00', 0),
(92, 51, NULL, 2050000, NULL, NULL, NULL, NULL, '2022-08-03 11:34:51', '2022-08-03 11:34:51', 0, NULL, '20500.00', '0.00', 0),
(93, 52, NULL, 1025000, NULL, NULL, NULL, NULL, '2022-08-03 11:44:09', '2022-08-03 11:44:09', 0, NULL, '10250.00', '0.00', 0),
(94, 53, NULL, 2050000, NULL, NULL, NULL, NULL, '2022-08-03 11:47:35', '2022-08-03 11:47:35', 0, NULL, '20500.00', '0.00', 0),
(95, 54, NULL, 2050000, NULL, NULL, NULL, NULL, '2022-08-03 12:44:15', '2022-08-03 12:44:15', 0, NULL, '20500.00', '0.00', 0),
(96, 55, NULL, 2050000, NULL, NULL, NULL, NULL, '2022-08-03 12:52:54', '2022-08-03 12:52:54', 0, NULL, '20500.00', '0.00', 0),
(97, 56, NULL, 2050000, NULL, NULL, NULL, NULL, '2022-08-03 12:55:51', '2022-08-03 12:55:51', 0, NULL, '20500.00', '0.00', 0),
(98, 57, NULL, 2050000, NULL, NULL, NULL, NULL, '2022-08-03 13:01:11', '2022-08-03 13:01:11', 0, NULL, '20500.00', '0.00', 0),
(99, 58, NULL, 2050000, NULL, NULL, NULL, NULL, '2022-08-03 13:08:40', '2022-08-03 13:08:40', 0, NULL, '20500.00', '0.00', 0),
(100, 59, NULL, 2050000, NULL, NULL, NULL, NULL, '2022-08-03 13:13:01', '2022-08-03 13:13:01', 0, NULL, '20500.00', '0.00', 0),
(101, 60, NULL, 2050000, NULL, NULL, NULL, NULL, '2022-08-03 13:21:08', '2022-08-03 13:21:08', 0, NULL, '20500.00', '0.00', 0),
(102, 61, NULL, 2050000, NULL, NULL, NULL, NULL, '2022-08-03 13:27:11', '2022-08-03 13:27:11', 0, NULL, '20500.00', '0.00', 0),
(103, 62, NULL, 2050000, NULL, NULL, NULL, NULL, '2022-08-03 16:09:09', '2022-08-03 16:09:09', 0, NULL, '20500.00', '0.00', 0),
(104, 63, NULL, 2050000, NULL, NULL, NULL, NULL, '2022-08-03 16:56:24', '2022-08-03 16:56:24', 0, NULL, '20500.00', '0.00', 0),
(105, 64, NULL, 3075000, NULL, NULL, NULL, NULL, '2022-08-03 21:41:16', '2022-08-03 21:41:16', 0, NULL, '30750.00', '0.00', 0),
(106, 65, NULL, 4557000, NULL, NULL, NULL, NULL, '2022-08-04 13:10:36', '2022-08-04 13:10:36', 0, NULL, '45570.00', '0.00', 0),
(107, 66, NULL, 2050000, NULL, NULL, NULL, NULL, '2022-08-04 13:20:29', '2022-08-04 13:20:29', 0, NULL, '20500.00', '0.00', 0),
(108, 67, NULL, 6607000, NULL, NULL, NULL, NULL, '2022-08-04 13:30:40', '2022-08-04 13:30:40', 0, NULL, '66070.00', '0.00', 0),
(109, 68, NULL, 7175000, NULL, NULL, NULL, NULL, '2022-08-04 14:04:31', '2022-08-04 14:04:31', 0, NULL, '71750.00', '0.00', 0),
(110, 69, NULL, 2050000, NULL, NULL, NULL, NULL, '2022-08-04 14:22:38', '2022-08-04 14:22:38', 0, NULL, '20500.00', '0.00', 0),
(111, 70, NULL, 16400000, NULL, NULL, NULL, NULL, '2022-08-04 15:51:27', '2022-08-04 15:51:27', 0, NULL, '164000.00', '0.00', 0),
(112, 71, NULL, 10250000, NULL, NULL, NULL, NULL, '2022-08-06 03:53:31', '2022-08-06 03:53:31', 0, NULL, '102500.00', '0.00', 0),
(113, 72, NULL, 10250000, NULL, NULL, NULL, NULL, '2022-08-06 10:56:35', '2022-08-06 10:56:35', 0, NULL, '102500.00', '0.00', 0),
(114, 73, NULL, 52220000, NULL, NULL, NULL, NULL, '2022-08-06 12:40:47', '2022-08-06 12:40:47', 0, NULL, '522200.00', '0.00', 0),
(115, 74, NULL, 11392500, NULL, NULL, NULL, NULL, '2022-08-06 13:33:44', '2022-08-06 13:33:44', 0, NULL, '113925.00', '0.00', 0),
(116, 75, NULL, 4557000, NULL, NULL, NULL, NULL, '2022-08-06 14:39:19', '2022-08-06 14:39:19', 0, NULL, '45570.00', '0.00', 0),
(117, 76, NULL, 45570000, NULL, NULL, NULL, NULL, '2022-08-06 14:43:21', '2022-08-06 14:43:21', 0, NULL, '455700.00', '0.00', 0),
(118, 77, NULL, 2050000, NULL, NULL, NULL, NULL, '2022-08-06 15:03:23', '2022-08-06 15:03:23', 0, NULL, '20500.00', '0.00', 0),
(119, 78, NULL, 2050000, NULL, NULL, NULL, NULL, '2022-08-08 14:00:27', '2022-08-08 14:00:27', 0, NULL, '20500.00', '0.00', 0),
(120, 79, NULL, 9114000, NULL, NULL, NULL, NULL, '2022-08-09 13:34:18', '2022-08-09 13:34:18', 0, NULL, '91140.00', '0.00', 0),
(121, 80, NULL, 4557000, NULL, NULL, NULL, NULL, '2022-08-09 14:03:53', '2022-08-09 14:03:53', 0, NULL, '45570.00', '0.00', 0),
(122, 81, NULL, 2050000, NULL, NULL, NULL, NULL, '2022-08-09 16:52:51', '2022-08-09 16:52:51', 0, NULL, '20500.00', '0.00', 0),
(123, 82, NULL, 9114000, NULL, NULL, NULL, NULL, '2022-08-10 13:01:03', '2022-08-10 13:01:03', 0, NULL, '91140.00', '0.00', 0),
(124, 83, NULL, 512500, NULL, NULL, NULL, NULL, '2022-08-10 15:01:32', '2022-08-10 15:01:32', 0, NULL, '5125.00', '0.00', 0),
(125, 84, NULL, 4082750, NULL, NULL, NULL, NULL, '2022-08-13 04:07:09', '2022-08-13 04:07:09', 0, NULL, '40827.50', '0.00', 0),
(126, 85, NULL, 5015000, NULL, NULL, NULL, NULL, '2022-08-14 10:57:41', '2022-08-14 10:57:41', 0, NULL, '50150.00', '0.00', 0),
(127, 86, NULL, 3990000, NULL, NULL, NULL, NULL, '2022-08-14 12:26:17', '2022-08-14 12:26:17', 0, NULL, '39900.00', '0.00', 0),
(128, 87, NULL, 9114000, NULL, NULL, NULL, NULL, '2022-08-15 15:20:33', '2022-08-15 15:20:33', 0, NULL, '91140.00', '0.00', 0),
(129, 88, NULL, 2278500, NULL, NULL, NULL, NULL, '2022-08-17 21:54:55', '2022-08-17 21:54:55', 0, NULL, '22785.00', '0.00', 0),
(130, 89, NULL, 6835500, NULL, NULL, NULL, NULL, '2022-08-18 07:56:48', '2022-08-18 07:56:48', 0, NULL, '68355.00', '0.00', 0),
(131, 90, NULL, 11893500, NULL, NULL, NULL, NULL, '2022-08-20 17:49:31', '2022-08-20 17:49:31', 0, NULL, '118935.00', '0.00', 0),
(132, 91, NULL, 21007500, NULL, NULL, NULL, NULL, '2022-08-21 12:36:54', '2022-08-21 12:36:54', 0, NULL, '210075.00', '0.00', 0),
(133, 92, NULL, 6835500, NULL, NULL, NULL, NULL, '2022-08-22 04:18:07', '2022-08-22 04:18:07', 0, NULL, '68355.00', '0.00', 0),
(134, 93, NULL, 1330000, NULL, NULL, NULL, NULL, '2022-08-29 15:52:57', '2022-08-29 15:52:57', 0, NULL, '13300.00', '0.00', 0),
(135, 94, NULL, 9081000, NULL, NULL, NULL, NULL, '2022-09-11 06:05:47', '2022-09-11 06:05:47', 0, NULL, '90810.00', '0.00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(170, 'default', '{\"uuid\":\"ec011c2d-5dfb-441e-a38c-6ea38f0d4cbc\",\"displayName\":\"App\\\\Jobs\\\\StockNotifications\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\StockNotifications\",\"command\":\"O:27:\\\"App\\\\Jobs\\\\StockNotifications\\\":11:{s:36:\\\"\\u0000App\\\\Jobs\\\\StockNotifications\\u0000product\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:27:\\\"App\\\\Models\\\\Products\\\\Product\\\";s:2:\\\"id\\\";i:8;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1660037122, 1660037122),
(171, 'default', '{\"uuid\":\"010a7a53-349b-4a27-a124-55e6abdd3a16\",\"displayName\":\"App\\\\Events\\\\NotifyAdmin\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":12:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\NotifyAdmin\\\":2:{s:12:\\\"notification\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:37:\\\"App\\\\Models\\\\Notifications\\\\Notification\\\";s:2:\\\"id\\\";i:8424;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:6:\\\"socket\\\";N;}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1660044858, 1660044858),
(172, 'default', '{\"uuid\":\"587f3fce-e4b7-405f-bbfb-daaf05cdb8df\",\"displayName\":\"App\\\\Events\\\\NotifyAdmin\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":12:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\NotifyAdmin\\\":2:{s:12:\\\"notification\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:37:\\\"App\\\\Models\\\\Notifications\\\\Notification\\\";s:2:\\\"id\\\";i:8426;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:6:\\\"socket\\\";N;}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1660046633, 1660046633),
(173, 'default', '{\"uuid\":\"edc31768-0289-4431-82ec-dcaa0a0ba9c1\",\"displayName\":\"App\\\\Events\\\\NotifyAdmin\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":12:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\NotifyAdmin\\\":2:{s:12:\\\"notification\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:37:\\\"App\\\\Models\\\\Notifications\\\\Notification\\\";s:2:\\\"id\\\";i:8432;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:6:\\\"socket\\\";N;}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1660056771, 1660056771),
(174, 'default', '{\"uuid\":\"be80c363-c782-4728-93fa-1aed64921391\",\"displayName\":\"App\\\\Events\\\\NotifyAdmin\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":12:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\NotifyAdmin\\\":2:{s:12:\\\"notification\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:37:\\\"App\\\\Models\\\\Notifications\\\\Notification\\\";s:2:\\\"id\\\";i:8437;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:6:\\\"socket\\\";N;}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1660129263, 1660129263),
(175, 'default', '{\"uuid\":\"a67d9352-e792-41f1-9dff-1b33203666b3\",\"displayName\":\"App\\\\Events\\\\NotifyAdmin\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":12:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\NotifyAdmin\\\":2:{s:12:\\\"notification\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:37:\\\"App\\\\Models\\\\Notifications\\\\Notification\\\";s:2:\\\"id\\\";i:8440;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:6:\\\"socket\\\";N;}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1660136493, 1660136493),
(176, 'default', '{\"uuid\":\"7eba52f7-d150-4b0c-9417-15ec99776b5b\",\"displayName\":\"App\\\\Events\\\\NotifyAdmin\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":12:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\NotifyAdmin\\\":2:{s:12:\\\"notification\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:37:\\\"App\\\\Models\\\\Notifications\\\\Notification\\\";s:2:\\\"id\\\";i:8442;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:6:\\\"socket\\\";N;}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1660136519, 1660136519),
(177, 'default', '{\"uuid\":\"692303cf-b8c8-4c96-bf42-fb36b80aebd1\",\"displayName\":\"App\\\\Events\\\\NotifyAdmin\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":12:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\NotifyAdmin\\\":2:{s:12:\\\"notification\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:37:\\\"App\\\\Models\\\\Notifications\\\\Notification\\\";s:2:\\\"id\\\";i:8443;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:6:\\\"socket\\\";N;}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1660356430, 1660356430),
(178, 'default', '{\"uuid\":\"15ed9345-de6f-4ad9-90b3-b42034169a1a\",\"displayName\":\"App\\\\Events\\\\NotifyAdmin\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":12:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\NotifyAdmin\\\":2:{s:12:\\\"notification\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:37:\\\"App\\\\Models\\\\Notifications\\\\Notification\\\";s:2:\\\"id\\\";i:8446;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:6:\\\"socket\\\";N;}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1660467127, 1660467127),
(179, 'default', '{\"uuid\":\"17149788-9cbd-4631-a863-e18dd9315d9e\",\"displayName\":\"App\\\\Events\\\\NotifyAdmin\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":12:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\NotifyAdmin\\\":2:{s:12:\\\"notification\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:37:\\\"App\\\\Models\\\\Notifications\\\\Notification\\\";s:2:\\\"id\\\";i:8447;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:6:\\\"socket\\\";N;}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1660467461, 1660467461),
(180, 'default', '{\"uuid\":\"66b77186-2a03-44fa-8215-56cc58d5a048\",\"displayName\":\"App\\\\Events\\\\NotifyAdmin\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":12:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\NotifyAdmin\\\":2:{s:12:\\\"notification\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:37:\\\"App\\\\Models\\\\Notifications\\\\Notification\\\";s:2:\\\"id\\\";i:8451;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:6:\\\"socket\\\";N;}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1660472695, 1660472695),
(181, 'default', '{\"uuid\":\"92a9d604-0594-45f8-b64f-abba0a75a5cb\",\"displayName\":\"App\\\\Events\\\\NotifyAdmin\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":12:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\NotifyAdmin\\\":2:{s:12:\\\"notification\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:37:\\\"App\\\\Models\\\\Notifications\\\\Notification\\\";s:2:\\\"id\\\";i:8452;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:6:\\\"socket\\\";N;}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1660472777, 1660472777),
(182, 'default', '{\"uuid\":\"662a299f-c198-4fc1-baba-01f8a747ae94\",\"displayName\":\"App\\\\Events\\\\NotifyAdmin\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":12:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\NotifyAdmin\\\":2:{s:12:\\\"notification\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:37:\\\"App\\\\Models\\\\Notifications\\\\Notification\\\";s:2:\\\"id\\\";i:8455;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:6:\\\"socket\\\";N;}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1660473338, 1660473338),
(183, 'default', '{\"uuid\":\"0d55173a-3421-4e47-aa2a-c0a3d398d227\",\"displayName\":\"App\\\\Events\\\\NotifyAdmin\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":12:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\NotifyAdmin\\\":2:{s:12:\\\"notification\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:37:\\\"App\\\\Models\\\\Notifications\\\\Notification\\\";s:2:\\\"id\\\";i:8459;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:6:\\\"socket\\\";N;}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1660569634, 1660569634),
(184, 'default', '{\"uuid\":\"bb7963ca-36b8-43b7-9bc7-bd26a33e358a\",\"displayName\":\"App\\\\Events\\\\NotifyAdmin\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":12:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\NotifyAdmin\\\":2:{s:12:\\\"notification\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:37:\\\"App\\\\Models\\\\Notifications\\\\Notification\\\";s:2:\\\"id\\\";i:8462;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:6:\\\"socket\\\";N;}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1660766095, 1660766095),
(185, 'default', '{\"uuid\":\"7be0b008-ad49-4c00-995b-6ef3f25c56e0\",\"displayName\":\"App\\\\Events\\\\NotifyAdmin\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":12:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\NotifyAdmin\\\":2:{s:12:\\\"notification\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:37:\\\"App\\\\Models\\\\Notifications\\\\Notification\\\";s:2:\\\"id\\\";i:8464;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:6:\\\"socket\\\";N;}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1660802134, 1660802134),
(186, 'default', '{\"uuid\":\"3c8a8d90-5a08-496d-9b85-ceda396fb411\",\"displayName\":\"App\\\\Events\\\\NotifyAdmin\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":12:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\NotifyAdmin\\\":2:{s:12:\\\"notification\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:37:\\\"App\\\\Models\\\\Notifications\\\\Notification\\\";s:2:\\\"id\\\";i:8465;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:6:\\\"socket\\\";N;}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1660802208, 1660802208),
(187, 'default', '{\"uuid\":\"53f2c646-5379-45bc-8d8e-ada0f8ab7dd7\",\"displayName\":\"App\\\\Events\\\\NotifyAdmin\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":12:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\NotifyAdmin\\\":2:{s:12:\\\"notification\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:37:\\\"App\\\\Models\\\\Notifications\\\\Notification\\\";s:2:\\\"id\\\";i:8469;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:6:\\\"socket\\\";N;}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1661010517, 1661010517),
(188, 'default', '{\"uuid\":\"740bec3b-014e-4447-87cd-45062aad5736\",\"displayName\":\"App\\\\Events\\\\NotifyAdmin\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":12:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\NotifyAdmin\\\":2:{s:12:\\\"notification\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:37:\\\"App\\\\Models\\\\Notifications\\\\Notification\\\";s:2:\\\"id\\\";i:8470;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:6:\\\"socket\\\";N;}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1661010571, 1661010571),
(189, 'default', '{\"uuid\":\"4920f227-f7aa-43f8-bb38-23e80b848b7e\",\"displayName\":\"App\\\\Events\\\\NotifyAdmin\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":12:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\NotifyAdmin\\\":2:{s:12:\\\"notification\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:37:\\\"App\\\\Models\\\\Notifications\\\\Notification\\\";s:2:\\\"id\\\";i:8476;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:6:\\\"socket\\\";N;}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1661078096, 1661078096),
(190, 'default', '{\"uuid\":\"75097057-f25c-4288-b473-1a7bb957432d\",\"displayName\":\"App\\\\Events\\\\NotifyAdmin\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":12:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\NotifyAdmin\\\":2:{s:12:\\\"notification\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:37:\\\"App\\\\Models\\\\Notifications\\\\Notification\\\";s:2:\\\"id\\\";i:8477;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:6:\\\"socket\\\";N;}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1661078214, 1661078214),
(191, 'default', '{\"uuid\":\"0937bc8c-bc70-440d-a89e-71195d348a7d\",\"displayName\":\"App\\\\Events\\\\NotifyAdmin\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":12:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\NotifyAdmin\\\":2:{s:12:\\\"notification\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:37:\\\"App\\\\Models\\\\Notifications\\\\Notification\\\";s:2:\\\"id\\\";i:8486;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:6:\\\"socket\\\";N;}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1661134687, 1661134687),
(192, 'default', '{\"uuid\":\"8e591022-a925-45a0-85d2-ced2a55e85dc\",\"displayName\":\"App\\\\Events\\\\NotifyAdmin\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":12:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\NotifyAdmin\\\":2:{s:12:\\\"notification\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:37:\\\"App\\\\Models\\\\Notifications\\\\Notification\\\";s:2:\\\"id\\\";i:8490;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:6:\\\"socket\\\";N;}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1661781178, 1661781178),
(193, 'default', '{\"uuid\":\"4da28381-aba4-441f-9a31-d6278ff6988d\",\"displayName\":\"App\\\\Events\\\\NotifyAdmin\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":12:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\NotifyAdmin\\\":2:{s:12:\\\"notification\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:37:\\\"App\\\\Models\\\\Notifications\\\\Notification\\\";s:2:\\\"id\\\";i:8494;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:6:\\\"socket\\\";N;}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1662288934, 1662288934),
(194, 'default', '{\"uuid\":\"77d28082-167a-41e0-a88e-bf014ef6678d\",\"displayName\":\"App\\\\Events\\\\NotifyAdmin\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":12:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\NotifyAdmin\\\":2:{s:12:\\\"notification\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:37:\\\"App\\\\Models\\\\Notifications\\\\Notification\\\";s:2:\\\"id\\\";i:8495;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:6:\\\"socket\\\";N;}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1662288961, 1662288961),
(195, 'default', '{\"uuid\":\"85c42acf-8e84-4dcf-a26a-5817dbac2b43\",\"displayName\":\"App\\\\Events\\\\NotifyAdmin\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":12:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\NotifyAdmin\\\":2:{s:12:\\\"notification\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:37:\\\"App\\\\Models\\\\Notifications\\\\Notification\\\";s:2:\\\"id\\\";i:8496;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:6:\\\"socket\\\";N;}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1662289222, 1662289222),
(196, 'default', '{\"uuid\":\"2508e5ef-ecb2-4f88-a703-b8a042b7f46e\",\"displayName\":\"App\\\\Events\\\\NotifyAdmin\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":12:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\NotifyAdmin\\\":2:{s:12:\\\"notification\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:37:\\\"App\\\\Models\\\\Notifications\\\\Notification\\\";s:2:\\\"id\\\";i:8497;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:6:\\\"socket\\\";N;}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1662289234, 1662289234),
(197, 'default', '{\"uuid\":\"06ce9215-b155-4606-9493-3ec74ca9ff86\",\"displayName\":\"App\\\\Events\\\\NotifyAdmin\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":12:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\NotifyAdmin\\\":2:{s:12:\\\"notification\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:37:\\\"App\\\\Models\\\\Notifications\\\\Notification\\\";s:2:\\\"id\\\";i:8498;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:6:\\\"socket\\\";N;}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1662289476, 1662289476),
(198, 'default', '{\"uuid\":\"6a725654-12ee-4052-bbc4-b0f54dfc8925\",\"displayName\":\"App\\\\Events\\\\NotifyAdmin\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":12:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\NotifyAdmin\\\":2:{s:12:\\\"notification\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:37:\\\"App\\\\Models\\\\Notifications\\\\Notification\\\";s:2:\\\"id\\\";i:8499;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:6:\\\"socket\\\";N;}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1662869148, 1662869148),
(199, 'default', '{\"uuid\":\"758cb3b0-6c8d-4ad5-81d8-c872f4d2ecf6\",\"displayName\":\"App\\\\Jobs\\\\SendSMSViaOrange\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendSMSViaOrange\",\"command\":\"O:25:\\\"App\\\\Jobs\\\\SendSMSViaOrange\\\":12:{s:39:\\\"\\u0000App\\\\Jobs\\\\SendSMSViaOrange\\u0000mobileNumber\\\";s:11:\\\"01222267740\\\";s:34:\\\"\\u0000App\\\\Jobs\\\\SendSMSViaOrange\\u0000message\\\";s:90:\\\"\\u0645\\u0631\\u062d\\u0628\\u0627 \\u0628\\u0643 \\u0641\\u0649 \\u0645\\u062c\\u0645\\u0648\\u0639\\u0629 \\u0645\\u0646\\u0635\\u0648\\u0631 \\u0643\\u0644\\u0645\\u0629 \\u0627\\u0644\\u0645\\u0631\\u0648\\u0631 \\u0627\\u0644\\u062c\\u062f\\u064a\\u062f\\u0629 39567053\\\";s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1665259986, 1665259986),
(200, 'default', '{\"uuid\":\"14b4e50c-a97e-489e-895b-2606f0282ec8\",\"displayName\":\"App\\\\Jobs\\\\SendSMSViaOrange\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendSMSViaOrange\",\"command\":\"O:25:\\\"App\\\\Jobs\\\\SendSMSViaOrange\\\":12:{s:39:\\\"\\u0000App\\\\Jobs\\\\SendSMSViaOrange\\u0000mobileNumber\\\";s:11:\\\"01222267740\\\";s:34:\\\"\\u0000App\\\\Jobs\\\\SendSMSViaOrange\\u0000message\\\";s:90:\\\"\\u0645\\u0631\\u062d\\u0628\\u0627 \\u0628\\u0643 \\u0641\\u0649 \\u0645\\u062c\\u0645\\u0648\\u0639\\u0629 \\u0645\\u0646\\u0635\\u0648\\u0631 \\u0643\\u0644\\u0645\\u0629 \\u0627\\u0644\\u0645\\u0631\\u0648\\u0631 \\u0627\\u0644\\u062c\\u062f\\u064a\\u062f\\u0629 93895554\\\";s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1665260037, 1665260037),
(201, 'default', '{\"uuid\":\"d5894059-1734-4735-b508-ff0a72e5ef11\",\"displayName\":\"App\\\\Jobs\\\\SendSMSViaOrange\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendSMSViaOrange\",\"command\":\"O:25:\\\"App\\\\Jobs\\\\SendSMSViaOrange\\\":12:{s:39:\\\"\\u0000App\\\\Jobs\\\\SendSMSViaOrange\\u0000mobileNumber\\\";s:11:\\\"01222267740\\\";s:34:\\\"\\u0000App\\\\Jobs\\\\SendSMSViaOrange\\u0000message\\\";s:90:\\\"\\u0645\\u0631\\u062d\\u0628\\u0627 \\u0628\\u0643 \\u0641\\u0649 \\u0645\\u062c\\u0645\\u0648\\u0639\\u0629 \\u0645\\u0646\\u0635\\u0648\\u0631 \\u0643\\u0644\\u0645\\u0629 \\u0627\\u0644\\u0645\\u0631\\u0648\\u0631 \\u0627\\u0644\\u062c\\u062f\\u064a\\u062f\\u0629 77945284\\\";s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1665260152, 1665260152),
(202, 'default', '{\"uuid\":\"13dd6e6e-966a-4235-8146-b8ac90af7a03\",\"displayName\":\"App\\\\Jobs\\\\SendSMSViaOrange\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendSMSViaOrange\",\"command\":\"O:25:\\\"App\\\\Jobs\\\\SendSMSViaOrange\\\":12:{s:39:\\\"\\u0000App\\\\Jobs\\\\SendSMSViaOrange\\u0000mobileNumber\\\";s:11:\\\"01222267740\\\";s:34:\\\"\\u0000App\\\\Jobs\\\\SendSMSViaOrange\\u0000message\\\";s:90:\\\"\\u0645\\u0631\\u062d\\u0628\\u0627 \\u0628\\u0643 \\u0641\\u0649 \\u0645\\u062c\\u0645\\u0648\\u0639\\u0629 \\u0645\\u0646\\u0635\\u0648\\u0631 \\u0643\\u0644\\u0645\\u0629 \\u0627\\u0644\\u0645\\u0631\\u0648\\u0631 \\u0627\\u0644\\u062c\\u062f\\u064a\\u062f\\u0629 20031556\\\";s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1665260223, 1665260223),
(203, 'default', '{\"uuid\":\"4f011160-3386-4921-ba2a-405cfcde4c44\",\"displayName\":\"App\\\\Jobs\\\\SendSMSViaOrange\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendSMSViaOrange\",\"command\":\"O:25:\\\"App\\\\Jobs\\\\SendSMSViaOrange\\\":12:{s:39:\\\"\\u0000App\\\\Jobs\\\\SendSMSViaOrange\\u0000mobileNumber\\\";s:11:\\\"01222267740\\\";s:34:\\\"\\u0000App\\\\Jobs\\\\SendSMSViaOrange\\u0000message\\\";s:90:\\\"\\u0645\\u0631\\u062d\\u0628\\u0627 \\u0628\\u0643 \\u0641\\u0649 \\u0645\\u062c\\u0645\\u0648\\u0639\\u0629 \\u0645\\u0646\\u0635\\u0648\\u0631 \\u0643\\u0644\\u0645\\u0629 \\u0627\\u0644\\u0645\\u0631\\u0648\\u0631 \\u0627\\u0644\\u062c\\u062f\\u064a\\u062f\\u0629 84838342\\\";s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1665260227, 1665260227),
(204, 'default', '{\"uuid\":\"905c0867-da6c-40ec-9595-d164992bbc4b\",\"displayName\":\"App\\\\Jobs\\\\SendSMSViaOrange\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendSMSViaOrange\",\"command\":\"O:25:\\\"App\\\\Jobs\\\\SendSMSViaOrange\\\":12:{s:39:\\\"\\u0000App\\\\Jobs\\\\SendSMSViaOrange\\u0000mobileNumber\\\";s:11:\\\"01222267740\\\";s:34:\\\"\\u0000App\\\\Jobs\\\\SendSMSViaOrange\\u0000message\\\";s:90:\\\"\\u0645\\u0631\\u062d\\u0628\\u0627 \\u0628\\u0643 \\u0641\\u0649 \\u0645\\u062c\\u0645\\u0648\\u0639\\u0629 \\u0645\\u0646\\u0635\\u0648\\u0631 \\u0643\\u0644\\u0645\\u0629 \\u0627\\u0644\\u0645\\u0631\\u0648\\u0631 \\u0627\\u0644\\u062c\\u062f\\u064a\\u062f\\u0629 90273787\\\";s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1665260261, 1665260261),
(205, 'default', '{\"uuid\":\"1e9b8f05-5c2c-409e-a31e-f0f33bba396c\",\"displayName\":\"App\\\\Jobs\\\\SendSMSViaOrange\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendSMSViaOrange\",\"command\":\"O:25:\\\"App\\\\Jobs\\\\SendSMSViaOrange\\\":12:{s:39:\\\"\\u0000App\\\\Jobs\\\\SendSMSViaOrange\\u0000mobileNumber\\\";s:11:\\\"01222267740\\\";s:34:\\\"\\u0000App\\\\Jobs\\\\SendSMSViaOrange\\u0000message\\\";s:90:\\\"\\u0645\\u0631\\u062d\\u0628\\u0627 \\u0628\\u0643 \\u0641\\u0649 \\u0645\\u062c\\u0645\\u0648\\u0639\\u0629 \\u0645\\u0646\\u0635\\u0648\\u0631 \\u0643\\u0644\\u0645\\u0629 \\u0627\\u0644\\u0645\\u0631\\u0648\\u0631 \\u0627\\u0644\\u062c\\u062f\\u064a\\u062f\\u0629 58167887\\\";s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1665260315, 1665260315),
(206, 'default', '{\"uuid\":\"85ba35ff-73bc-4347-8364-fd9f0c138fcb\",\"displayName\":\"App\\\\Jobs\\\\SendSMSViaOrange\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendSMSViaOrange\",\"command\":\"O:25:\\\"App\\\\Jobs\\\\SendSMSViaOrange\\\":12:{s:39:\\\"\\u0000App\\\\Jobs\\\\SendSMSViaOrange\\u0000mobileNumber\\\";s:11:\\\"01222267740\\\";s:34:\\\"\\u0000App\\\\Jobs\\\\SendSMSViaOrange\\u0000message\\\";s:90:\\\"\\u0645\\u0631\\u062d\\u0628\\u0627 \\u0628\\u0643 \\u0641\\u0649 \\u0645\\u062c\\u0645\\u0648\\u0639\\u0629 \\u0645\\u0646\\u0635\\u0648\\u0631 \\u0643\\u0644\\u0645\\u0629 \\u0627\\u0644\\u0645\\u0631\\u0648\\u0631 \\u0627\\u0644\\u062c\\u062f\\u064a\\u062f\\u0629 28960666\\\";s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1665260372, 1665260372),
(207, 'default', '{\"uuid\":\"9e40bfe1-62d4-4e76-8aac-05e22356b7c9\",\"displayName\":\"App\\\\Jobs\\\\SendSMSViaOrange\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendSMSViaOrange\",\"command\":\"O:25:\\\"App\\\\Jobs\\\\SendSMSViaOrange\\\":12:{s:39:\\\"\\u0000App\\\\Jobs\\\\SendSMSViaOrange\\u0000mobileNumber\\\";s:11:\\\"01222267740\\\";s:34:\\\"\\u0000App\\\\Jobs\\\\SendSMSViaOrange\\u0000message\\\";s:90:\\\"\\u0645\\u0631\\u062d\\u0628\\u0627 \\u0628\\u0643 \\u0641\\u0649 \\u0645\\u062c\\u0645\\u0648\\u0639\\u0629 \\u0645\\u0646\\u0635\\u0648\\u0631 \\u0643\\u0644\\u0645\\u0629 \\u0627\\u0644\\u0645\\u0631\\u0648\\u0631 \\u0627\\u0644\\u062c\\u062f\\u064a\\u062f\\u0629 57038706\\\";s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1665260563, 1665260563),
(208, 'default', '{\"uuid\":\"0509f289-03fa-464e-aa58-75ea14da3e3d\",\"displayName\":\"App\\\\Jobs\\\\SendSMSViaOrange\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendSMSViaOrange\",\"command\":\"O:25:\\\"App\\\\Jobs\\\\SendSMSViaOrange\\\":12:{s:39:\\\"\\u0000App\\\\Jobs\\\\SendSMSViaOrange\\u0000mobileNumber\\\";s:11:\\\"01222267740\\\";s:34:\\\"\\u0000App\\\\Jobs\\\\SendSMSViaOrange\\u0000message\\\";s:90:\\\"\\u0645\\u0631\\u062d\\u0628\\u0627 \\u0628\\u0643 \\u0641\\u0649 \\u0645\\u062c\\u0645\\u0648\\u0639\\u0629 \\u0645\\u0646\\u0635\\u0648\\u0631 \\u0643\\u0644\\u0645\\u0629 \\u0627\\u0644\\u0645\\u0631\\u0648\\u0631 \\u0627\\u0644\\u062c\\u062f\\u064a\\u062f\\u0629 42559644\\\";s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1665260869, 1665260869);

-- --------------------------------------------------------

--
-- Table structure for table `lists`
--

CREATE TABLE `lists` (
  `id` int(10) UNSIGNED NOT NULL,
  `name_en` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name_ar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description_ar` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description_en` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` tinyint(4) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `rules` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`rules`)),
  `image_en` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_ar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `list_method` tinyint(1) NOT NULL DEFAULT 0,
  `condition_type` tinyint(1) NOT NULL DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lists`
--

INSERT INTO `lists` (`id`, `name_en`, `name_ar`, `description_ar`, `description_en`, `type`, `active`, `created_at`, `updated_at`, `rules`, `image_en`, `image_ar`, `list_method`, `condition_type`, `deleted_at`) VALUES
(78, 'Top Sellers', 'الاكثر مبيعا', 'Top Sellers', 'Top Sellers', 4, 1, '2021-11-14 19:09:13', '2022-08-08 11:07:39', NULL, NULL, NULL, 0, 0, '2022-08-08 11:07:39'),
(79, 'New Arrivals', 'احدث المنتجات', 'New Arrivals', 'New Arrivals', 4, 1, '2021-11-14 19:10:31', '2021-11-14 19:10:31', NULL, NULL, NULL, 0, 0, NULL),
(80, 'Featured Products', 'المميز', 'Featured Products', 'Featured Products', 4, 1, '2021-11-14 19:11:40', '2021-11-14 19:11:40', NULL, NULL, NULL, 0, 0, NULL),
(81, 'EVOLVE + try', 'EVOLVE + try', 'DVD + try', 'DVD + try', 4, 1, '2021-12-15 11:46:38', '2022-08-02 12:34:14', NULL, NULL, NULL, 0, 0, NULL),
(82, 'Time', 'Time', 'Time', 'Time', 4, 1, '2021-12-15 11:46:57', '2021-12-15 11:46:57', NULL, NULL, NULL, 0, 0, NULL),
(83, 'Target', 'Target', 'Target', 'Target', 4, 1, '2021-12-15 11:47:17', '2021-12-15 11:47:17', NULL, NULL, NULL, 0, 0, NULL),
(84, 'Bic', 'Bic', 'Bic', 'Bic', 4, 1, '2021-12-16 14:09:24', '2021-12-16 14:09:24', NULL, NULL, NULL, 0, 0, NULL),
(85, 'Big list', 'Big list', 'Big list', 'Big list', 4, 1, '2021-12-16 14:56:58', '2021-12-16 14:56:58', NULL, NULL, NULL, 0, 0, NULL),
(86, 'time mon', 'time mon', 'time mon', 'time mon', 4, 1, '2021-12-20 15:00:28', '2022-07-19 16:14:02', NULL, NULL, NULL, 0, 0, '2022-07-19 16:14:02'),
(87, 'DVD family', 'DVD family', 'DVD and Time List', 'DVD and Time List', 4, 1, '2021-12-28 12:12:03', '2022-08-02 12:37:15', NULL, NULL, NULL, 0, 0, NULL),
(88, 'DVD', 'اي حاجة', 'بسيب', 'سيبيسس', 4, 1, '2022-06-12 12:57:29', '2022-07-19 16:18:24', NULL, NULL, NULL, 0, 0, NULL),
(89, 'خصومات شهر يونيو', 'لايعن', 'لااهبلااعيبلاث', 'ميةىتيلاىهىسش', 4, 1, '2022-06-12 13:05:08', '2022-06-12 13:05:08', NULL, NULL, NULL, 0, 0, NULL),
(90, 'maya', 'مايا', 'مايا شريف', 'maya sherif', 4, 1, '2022-06-13 13:45:42', '2022-06-26 11:20:23', NULL, NULL, NULL, 0, 0, '2022-06-26 11:20:23'),
(91, 'June products', 'June products', 'June products', 'June products', 4, 1, '2022-06-14 13:16:31', '2022-06-14 13:16:31', NULL, NULL, NULL, 0, 0, NULL),
(92, 'ahmed', 'ahmed', 'snodju', 'sjbdih', 4, 1, '2022-06-14 13:24:09', '2022-06-22 14:04:57', NULL, NULL, NULL, 0, 0, '2022-06-22 14:04:57'),
(93, '1 try and tob 3', 'ولعات و سجاير', '1 try and tob 3 - test', '1 try and tob 3 - test', 4, 1, '2022-06-20 12:13:29', '2022-06-23 09:59:16', NULL, NULL, NULL, 0, 0, '2022-06-23 09:59:16'),
(94, 'test', 'testAr', 'testDescriptionAr', 'testDescription', 4, 1, '2022-06-21 12:01:23', '2022-06-23 10:01:58', NULL, NULL, NULL, 0, 0, '2022-06-23 10:01:58'),
(95, 'test', 'test', 'test', 'test', 4, 1, '2022-06-23 13:05:54', '2022-06-23 13:05:58', NULL, NULL, NULL, 0, 0, '2022-06-23 13:05:58'),
(96, 'test', 'testAr', 'cdjhsx', 'lhdwxs', 4, 1, '2022-06-23 13:19:12', '2022-06-23 13:19:37', NULL, NULL, NULL, 0, 0, '2022-06-23 13:19:37'),
(97, 'dvd only', 'dvd only', 'dvd only', 'dvd only', 4, 1, '2022-06-26 12:57:47', '2022-06-26 12:57:47', NULL, NULL, NULL, 0, 0, NULL),
(98, 'DVD EVOLVE', 'DVD EVOLVE', 'DVD EVOLVE', 'DVD EVOLVE', 4, 1, '2022-06-26 13:22:06', '2022-06-26 13:22:06', NULL, NULL, NULL, 0, 0, NULL),
(99, 'GV', 'GV', '12 GV = 1 CASE', '12 GV = 1 CASE', 4, 1, '2022-06-26 13:24:30', '2022-07-19 15:58:20', NULL, NULL, NULL, 0, 0, '2022-07-19 15:58:20'),
(100, 'target', 'تارجت', 'target', 'target', 4, 1, '2022-06-26 13:29:21', '2022-07-19 15:58:16', NULL, NULL, NULL, 0, 0, '2022-07-19 15:58:16'),
(101, 'all product', 'جميع الاصناف', 'product', 'product', 4, 1, '2022-07-18 11:24:46', '2022-07-18 11:24:46', NULL, NULL, NULL, 0, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `list_items`
--

CREATE TABLE `list_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `list_id` int(10) UNSIGNED NOT NULL,
  `item_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `list_items`
--

INSERT INTO `list_items` (`id`, `list_id`, `item_id`, `created_at`, `updated_at`) VALUES
(169624, 78, 90399, '2021-11-21 12:16:58', '2021-11-21 12:16:58'),
(169625, 78, 90397, '2021-11-21 12:16:58', '2021-11-21 12:16:58'),
(169626, 78, 90391, '2021-11-21 12:16:58', '2021-11-21 12:16:58'),
(169627, 78, 90393, '2021-11-21 12:16:58', '2021-11-21 12:16:58'),
(169628, 78, 90395, '2021-11-21 12:16:58', '2021-11-21 12:16:58'),
(169643, 85, 90403, '2021-12-16 15:05:47', '2021-12-16 15:05:47'),
(169644, 85, 90399, '2021-12-16 15:05:47', '2021-12-16 15:05:47'),
(169645, 85, 90401, '2021-12-16 15:05:47', '2021-12-16 15:05:47'),
(169646, 85, 90409, '2021-12-16 15:05:47', '2021-12-16 15:05:47'),
(169647, 86, 90409, '2021-12-20 15:00:28', '2021-12-20 15:00:28'),
(169648, 86, 90401, '2021-12-20 15:00:28', '2021-12-20 15:00:28'),
(169690, 89, 171, '2022-06-12 13:05:08', '2022-06-12 13:05:08'),
(169691, 90, 167, '2022-06-13 13:45:42', '2022-06-13 13:45:42'),
(169692, 90, 169, '2022-06-13 13:45:42', '2022-06-13 13:45:42'),
(169693, 91, 171, '2022-06-14 13:16:31', '2022-06-14 13:16:31'),
(169694, 91, 7, '2022-06-14 13:16:31', '2022-06-14 13:16:31'),
(169695, 91, 21, '2022-06-14 13:16:31', '2022-06-14 13:16:31'),
(169724, 93, 167, '2022-06-20 12:16:25', '2022-06-20 12:16:25'),
(169725, 93, 173, '2022-06-20 12:16:25', '2022-06-20 12:16:25'),
(169726, 93, 165, '2022-06-20 12:16:25', '2022-06-20 12:16:25'),
(169727, 93, 187, '2022-06-20 12:16:25', '2022-06-20 12:16:25'),
(169728, 93, 189, '2022-06-20 12:16:25', '2022-06-20 12:16:25'),
(169729, 93, 7, '2022-06-20 12:16:25', '2022-06-20 12:16:25'),
(169730, 93, 9, '2022-06-20 12:16:25', '2022-06-20 12:16:25'),
(169731, 94, 47, '2022-06-21 12:01:23', '2022-06-21 12:01:23'),
(169735, 95, 191, '2022-06-23 13:05:54', '2022-06-23 13:05:54'),
(169736, 96, 9, '2022-06-23 13:19:12', '2022-06-23 13:19:12'),
(169744, 97, 167, '2022-06-26 12:57:47', '2022-06-26 12:57:47'),
(169745, 97, 173, '2022-06-26 12:57:47', '2022-06-26 12:57:47'),
(169746, 97, 165, '2022-06-26 12:57:47', '2022-06-26 12:57:47'),
(169750, 99, 191, '2022-06-26 13:24:30', '2022-06-26 13:24:30'),
(169756, 84, 47, '2022-06-26 13:33:31', '2022-06-26 13:33:31'),
(169757, 100, 7, '2022-07-04 16:59:41', '2022-07-04 16:59:41'),
(169758, 100, 9, '2022-07-04 16:59:41', '2022-07-04 16:59:41'),
(169797, 83, 7, '2022-07-19 16:07:27', '2022-07-19 16:07:27'),
(169798, 83, 9, '2022-07-19 16:07:27', '2022-07-19 16:07:27'),
(169799, 82, 21, '2022-07-19 16:13:55', '2022-07-19 16:13:55'),
(169800, 82, 187, '2022-07-19 16:13:55', '2022-07-19 16:13:55'),
(169801, 82, 189, '2022-07-19 16:13:55', '2022-07-19 16:13:55'),
(169802, 88, 171, '2022-07-19 16:18:24', '2022-07-19 16:18:24'),
(169803, 88, 167, '2022-07-19 16:18:24', '2022-07-19 16:18:24'),
(169804, 88, 173, '2022-07-19 16:18:24', '2022-07-19 16:18:24'),
(169805, 88, 165, '2022-07-19 16:18:24', '2022-07-19 16:18:24'),
(169806, 101, 167, '2022-07-19 17:17:51', '2022-07-19 17:17:51'),
(169807, 101, 171, '2022-07-19 17:17:51', '2022-07-19 17:17:51'),
(169808, 101, 173, '2022-07-19 17:17:51', '2022-07-19 17:17:51'),
(169809, 101, 165, '2022-07-19 17:17:51', '2022-07-19 17:17:51'),
(169810, 101, 187, '2022-07-19 17:17:51', '2022-07-19 17:17:51'),
(169811, 101, 189, '2022-07-19 17:17:51', '2022-07-19 17:17:51'),
(169812, 101, 21, '2022-07-19 17:17:51', '2022-07-19 17:17:51'),
(169813, 101, 9, '2022-07-19 17:17:51', '2022-07-19 17:17:51'),
(169814, 101, 7, '2022-07-19 17:17:51', '2022-07-19 17:17:51'),
(169815, 101, 169, '2022-07-19 17:17:51', '2022-07-19 17:17:51'),
(169816, 101, 185, '2022-07-19 17:17:51', '2022-07-19 17:17:51'),
(169817, 101, 161, '2022-07-19 17:17:51', '2022-07-19 17:17:51'),
(169825, 87, 167, '2022-08-02 12:37:15', '2022-08-02 12:37:15'),
(169826, 87, 173, '2022-08-02 12:37:15', '2022-08-02 12:37:15'),
(169827, 87, 165, '2022-08-02 12:37:15', '2022-08-02 12:37:15'),
(169828, 87, 171, '2022-08-02 12:37:15', '2022-08-02 12:37:15'),
(169829, 87, 185, '2022-08-02 12:37:15', '2022-08-02 12:37:15'),
(169830, 87, 169, '2022-08-02 12:37:15', '2022-08-02 12:37:15'),
(169831, 87, 161, '2022-08-02 12:37:15', '2022-08-02 12:37:15'),
(169834, 98, 169, '2022-08-09 09:00:28', '2022-08-09 09:00:28'),
(169835, 98, 161, '2022-08-09 09:00:28', '2022-08-09 09:00:28'),
(169836, 81, 11, '2022-11-03 12:17:11', '2022-11-03 12:17:11'),
(169837, 81, 13, '2022-11-03 12:17:11', '2022-11-03 12:17:11'),
(169838, 81, 9, '2022-11-03 12:17:11', '2022-11-03 12:17:11');

-- --------------------------------------------------------

--
-- Table structure for table `list_rules`
--

CREATE TABLE `list_rules` (
  `id` int(10) UNSIGNED NOT NULL,
  `field` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `condition` int(11) DEFAULT NULL,
  `value` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `list_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2018_09_02_091622_create_profiles_table', 1),
(4, '2018_09_02_092312_create_cities_table', 1),
(5, '2018_09_02_092324_create_areas_table', 1),
(6, '2018_09_02_092325_create_districts_table', 1),
(7, '2018_09_02_092618_create_addresses_table', 1),
(8, '2018_09_02_093131_create_categories_table', 1),
(9, '2018_09_02_093440_create_brands_table', 1),
(10, '2018_09_02_093445_create_products_table', 1),
(11, '2018_09_02_095815_create_product_images_table', 1),
(12, '2018_09_02_095930_create_order_states_table', 1),
(13, '2018_09_02_095940_create_orders_table', 1),
(14, '2018_09_02_100517_create_order_history_table', 1),
(15, '2018_09_02_100711_create_product_prices_table', 1),
(16, '2018_09_02_100712_create_order_products_table', 1),
(17, '2018_09_02_104153_create_user_favourites_table', 1),
(18, '2018_09_02_104224_create_ads_table', 1),
(19, '2018_09_03_105921_create_deliverer_profile_table', 1),
(20, '2018_09_04_001654_create_prescriptions_table', 1),
(21, '2018_09_09_165852_create_device_tokens_table', 1),
(22, '2018_09_25_130557_create_promos_table', 1),
(23, '2018_09_29_135713_create_invoices_table', 1),
(24, '2018_09_29_142616_create_push_messages_table', 1),
(25, '2018_09_29_223009_create_user_promo_table', 1),
(26, '2018_09_30_163748_create_notifications_table', 1),
(27, '2019_06_26_115414_create_order_schedule_table', 1),
(28, '2019_06_26_121111_create_schedule_days_table', 1),
(29, '2019_06_27_124836_create_promo_targets_table', 1),
(30, '2019_07_27_152913_create_contact_us_table', 1),
(31, '2019_11_21_145640_create_rewards_table', 1),
(32, '2019_11_21_150149_create_user_points_table', 1),
(33, '2019_11_21_150459_create_user_redeems_table', 1),
(34, '2019_11_21_150943_create_settings_table', 1),
(35, '2019_11_21_183246_create_redeem_points_table', 1),
(36, '2020_04_21_110720_create_options', 1),
(37, '2020_04_21_110721_create_option_values', 1),
(38, '2020_04_21_110731_create_category_options', 1),
(39, '2020_04_21_110731_create_product_option_values', 1),
(40, '2020_04_22_172207_create_product_variant', 1),
(41, '2020_04_22_172207_create_product_variant_images', 1),
(42, '2020_04_22_172207_create_product_variant_values', 1),
(43, '2020_04_25_143108_create_stock_notifications_table', 1),
(44, '2020_04_26_022614_create_user_settings_table', 1),
(45, '2020_04_30_110247_create_product_reviews_table', 1),
(46, '2020_04_30_210247_create_groups_table', 1),
(47, '2020_04_30_210247_create_lists_table', 1),
(48, '2020_04_30_210247_create_sub_category_groups_table', 1),
(49, '2020_04_30_210247_create_tags_table', 1),
(50, '2020_04_30_211247_create_products_tags_table', 1),
(51, '2020_04_30_250247_create_list_items_table', 1),
(52, '2020_05_01_134125_create_permission_tables', 1),
(53, '2020_05_01_144538_create_role_state_table', 1),
(54, '2020_05_02_222616_create_deliverer_district_table', 1),
(56, '2020_05_03_141452_drop_order_rate', 1),
(57, '2020_05_03_222616_create_custom_ads_table', 1),
(58, '2020_05_03_222616_create_list_rules_table', 1),
(59, '2020_05_03_222616_create_pages_table', 1),
(60, '2020_05_03_222616_create_sections_table', 1),
(61, '2020_05_03_222616_create_stores_table', 1),
(62, '2020_05_17_112233_add_admin_notes_order', 2),
(63, '2020_05_17_223819_add_list_id_promos', 3),
(64, '2020_05_18_170246_add_resolved_contact_us', 4),
(65, '2020_05_19_125553_insert_contact_permission', 5),
(66, '2020_05_03_141452_add_reviews_type', 6),
(67, '2020_05_27_133942_create_promotions_table', 7),
(68, '2020_05_27_162521_add_name_ar_promotions', 8),
(69, '2020_05_18_170246_drop_variant_tables', 9),
(70, '2020_06_02_074406_add_category_slug', 9),
(71, '2020_06_02_074406_add_option_input_type', 9),
(72, '2020_06_02_074406_add_product_barcode', 9),
(73, '2020_06_02_074406_add_product_option_value_type', 9),
(74, '2020_06_02_074406_change_option_val_null', 10),
(75, '2020_05_15_141452_add_Group_active', 11),
(77, '2020_05_30_021925_add_prices_fields_order_products', 11),
(78, '2020_06_02_074406_add_order_history', 11),
(79, '2020_06_10_110156_add_target_type_promos', 11),
(80, '2020_05_27_162521_add_product_order', 12),
(81, '2020_06_10_110156_add_notification_details', 13),
(82, '2020_07_05_144216_add_index_product_sku', 14),
(83, '2020_05_15_141452_add_product_parent', 15),
(84, '2020_06_02_074406_add_product_option', 15),
(85, '2020_06_02_074406_add_group_slug', 16),
(86, '2020_07_29_122228_create_pickups_table', 17),
(87, '2020_07_29_124820_create_order_pickup_table', 18),
(88, '2020_07_30_144216_add_order_pickup_data', 19),
(89, '2020_07_30_144216_add_pickup_data', 19),
(90, '2020_07_30_144216_add_order_pickup_data2', 20),
(91, '2020_08_14_114225_add_qty_promotions', 21),
(92, '2020_08_14_141030_add_discount_qty_promotions', 22),
(93, '2020_08_15_143108_create_transactions_table', 23),
(94, '2020_08_15_281425_add_order_transactions', 23),
(95, '2020_08_15_281425_add_group_order', 24),
(96, '2020_09_02_183832_add_target_list_id_promotions', 25),
(97, '2020_09_03_114418_add_qty2_promotions', 26),
(98, '2020_09_03_114418_add_null_to_price', 27),
(99, '2020_09_03_114418_add_products_weight', 28),
(100, '2020_12_21_114418_add_aramex_city_name', 29),
(101, '2020_12_21_114418_add_pickup_tracking_update', 30),
(102, '2020_12_21_114418_add_aramex_area_name', 31),
(103, '2020_12_27_113659_create_payment_methods_table', 32),
(104, '2020_12_27_122339_create_promo_payment_method_table', 32),
(105, '2020_12_27_152944_add_discount_dates_to_products_table', 33),
(106, '2020_12_27_170734_add_some_columns_to_products_table', 34),
(107, '2020_12_27_144216_add_product_type', 35),
(108, '2020_12_27_153942_create_product_bundles_table', 35),
(109, '2020_12_27_173500_add_preorder_to_products_table', 36),
(110, '2020_12_28_115941_add_except_cod_to_settings', 37),
(111, '2020_12_28_131316_create_pages_table', 38),
(112, '2020_12_28_170734_change_input_text_table', 39),
(113, '2020_12_29_135019_add_optional_sub_category_id_to_products_tables', 40),
(114, '2020_12_30_165301_create_payment_credentials_table', 41),
(115, '2020_12_29_135019_add_payment_method_image_tables', 42),
(116, '2021_01_03_140013_add_preorder_data_order_products', 43),
(117, '2021_01_05_141541_change_except_cod_amount_and_drop_except_cod_at_settings', 44),
(118, '2021_01_05_141746_change_payment_methods_image_to_icone_at_payment_methods', 44),
(119, '2021_01_06_165752_create_product_skus_table', 45),
(120, '2021_01_10_140100_add_preorder_price_to_order_products_table', 46),
(121, '2021_01_10_140013_add_order_pickup_status', 47),
(122, '2021_01_10_140013_add_order_status', 47),
(123, '2021_01_12_114720_create_carts_table', 48),
(124, '2021_01_12_115801_add_preorder_dates_to_products_table', 49),
(125, '2021_01_10_140100_add_order_product_serial', 50),
(126, '2021_01_10_140100_add_product_video', 50),
(127, '2021_01_17_115801_add_order_phone', 51),
(128, '2020_08_13_173218_add_user_agent_order', 52),
(129, '2021_01_18_114136_create_closed_payment_methods_table', 52),
(130, '2021_01_19_115801_add_nullable_to_pickup_id', 52),
(131, '2021_01_19_115801_add_order_admin_id', 52),
(132, '2021_01_19_123343_create_compare_products_table', 52),
(133, '2021_01_19_140309_add_order_to_options_table', 52),
(134, '2021_01_19_140309_add_product_bundle_checkout', 53),
(135, '2021_01_24_135410_create_order_cancellation_reasons_table', 54),
(136, '2021_01_24_135411_add_columns_to_orders_table', 54),
(137, '2021_01_24_142249_add_user_type_to_order_cancellation_reasons_table', 54),
(138, '2021_01_31_135924_add_meta_fields_ar_products', 55),
(139, '2021_02_01_122723_add_image_web_to_custom_ads_table', 56),
(140, '2021_02_01_125055_add_appear_on_product_details_to_options_table', 56),
(141, '2021_02_02_204213_change_weight_field_products', 57),
(142, '2021_02_03_114800_add_image_web_ar_to_custom_ads_table', 58),
(143, '2021_02_15_152114_change_type_field_ads', 59),
(144, '2021_02_15_164525_change_type_field_custom_ads', 59),
(145, '2021_02_15_175243_add_link_field_ads', 59),
(146, '2021_02_25_161352_add_user_agent_to_transactions_table', 60),
(147, '2021_02_25_134449_create_jobs_table', 61),
(148, '2021_02_25_144629_create_failed_jobs_table', 61),
(149, '2021_03_07_190319_add_grand_total_invoice', 62),
(150, '2021_03_16_142303_add_bundle_id_order_products', 63),
(151, '2021_03_07_190319_add_total_delivery_fess_invoice', 64),
(152, '2021_03_09_122145_add_edara_id_to_users_table', 64),
(153, '2021_03_09_161944_create_edara_areas_table', 64),
(154, '2021_03_17_134642_create_edara_drafts_table', 64),
(155, '2021_04_13_331527_add_product_soft_delete', 64),
(156, '2021_06_07_165323_add_email_column_to_stock_notifiactions_table', 64),
(157, '2021_06_08_120539_change_product_id_column_in_product_skus_table', 64),
(158, '2021_06_16_163915_change_stock_column_in_products_table', 64),
(159, '2021_06_20_142821_add_item_link_column_to_notifications_table', 64),
(160, '2021_06_23_120421_create_branches_table', 64),
(161, '2021_06_23_134139_create_section_images_table', 64),
(162, '2021_06_23_150405_add_image_type_column_to_sections_table', 64),
(163, '2021_06_27_140341_add_link_en_column_to_section_images_table', 64),
(164, '2021_06_28_100039_add_direction_link_column_to_braches_table', 65),
(165, '2021_06_29_124532_add_order_column_to_payment_method_table', 66),
(166, '2021_06_30_161251_create_payment_method_product_table', 67),
(167, '2021_06_20_281425_add_transactions_columns', 68),
(168, '2021_07_12_170033_add_transaction_processe_column_to_transactions_table', 69),
(169, '2021_07_13_141900_add_type_column_to_payment_methods_table', 70),
(170, '2021_07_15_141358_add_downloadable_url_column_to_products_table', 71),
(171, '2021_07_13_142959_create_import_histories_table', 72),
(172, '2021_07_28_155937_create_exports_table', 72),
(173, '2021_08_16_131551_add_menu_col_to_settings_table', 73),
(174, '2021_08_16_172121_add_ip_column_to_users', 74),
(175, '2021_08_16_160156_add_user_ip_column_to_orders_table', 75),
(176, '2021_08_17_101506_update_pages_table', 76),
(177, '2021_08_17_144326_remove_ip_column_from_users_table', 77),
(178, '2021_08_17_173317_create_black_ip_list_table', 78),
(179, '2021_08_17_121849_add_softbar_columns_to_settings_table', 79),
(180, '2021_08_18_164136_add_page_seeder', 80),
(181, '2021_08_23_131759_create_payment_installments_table', 81),
(182, '2021_08_23_162221_add_password_column_payment_installment_table', 82),
(183, '2021_08_24_045754_build_cofigurations_table', 83),
(184, '2021_08_24_150409_update_configurations_table', 84),
(185, '2021_08_24_150839_add_payment_installment_id_column_to_orders', 85),
(186, '2021_08_26_053709_add_in_footer_to__pages_table', 86),
(187, '2021_08_26_074515_seed_pages_migration', 87),
(188, '2021_07_25_150405_add_time_stamp_to_password_resets_table', 88),
(189, '2021_08_19_135410_create_affiliate_requests_table', 89),
(190, '2021_08_19_135410_create_wallet_history_table', 89),
(191, '2021_08_19_331527_add_address_phone', 89),
(192, '2021_08_19_331527_add_order_affiliate_id', 89),
(193, '2021_08_19_331527_add_products_affiliate_commission', 89),
(194, '2021_08_19_331527_add_settings_affiliate_pending_days', 89),
(195, '2021_08_19_331527_add_user_promo_phone', 89),
(196, '2021_08_19_435410_create_affiliate_links_table', 89),
(197, '2021_08_19_535410_create_affiliate_link_histories_table', 89),
(198, '2021_08_19_641527_add_user_link_id', 89),
(199, '2019_12_14_000001_create_personal_access_tokens_table', 90),
(200, '2021_08_30_150839_add_import_histories_report', 90),
(201, '2021_08_31_194618_add_uuid_failed_jobs', 91),
(202, '2021_09_02_100824_add_username_column_to_payment_installment_table', 92),
(203, '2021_09_02_130341_add_transaction_request_column_to_transactions_table', 93),
(204, '2021_09_02_132655_change_transaction_request_column_to_transactions_table', 94),
(205, '2021_09_02_223757_drop_settings_table', 95),
(206, '2021_09_06_152254_add_title_ar_column_to_notification_table', 96),
(207, '2021_09_07_100004_add_payment_method_id_column_to_transactions_table', 97),
(208, '2021_09_07_104557_change_payment_method_in_transactions', 98),
(209, '2021_09_02_151304_create_shipping_areas_table', 99),
(210, '2021_09_02_151431_create_shipping_methods_table', 99),
(211, '2021_09_06_143800_create_delivery_fees_table', 99),
(212, '2021_09_07_182536_add_erp_id_users', 100),
(213, '2021_09_08_121200_create_request_logs_table', 101),
(214, '2021_09_05_000554_create_prescription_cancellation_reasons_table', 102),
(215, '2021_09_05_001654_create_prescriptions_table', 102),
(216, '2021_09_05_163726_create_prescription_images_table', 102),
(217, '2021_09_12_121625_delete_feild_type_from_delivery_fees', 103),
(218, '2021_09_12_121754_add_field_delivery_fees_type_to_areas_cities_districts_tabels', 103),
(219, '2021_09_13_130257_add_featured_flag_to_products_table', 104),
(220, '2021_09_13_161518_drop_list_rules_table', 105),
(221, '2021_09_13_162429_update_lists_table', 105),
(222, '2021_09_14_102813_create_list_rules_table', 106),
(223, '2021_09_14_132557_add_free_delivery_column_to_products', 107),
(224, '2021_09_16_100545_add_provider_column_to_payment_methods', 108),
(225, '2021_09_27_110422_add_payment_transaction_column_to_transactions_table', 109),
(226, '2021_09_27_124100_change_transaction_status_column_type_in_transactions_table', 110),
(227, '2021_09_22_111819_create_countries_table', 111),
(228, '2021_09_22_130309_seed_country_table', 111),
(229, '2021_09_23_132311_add_phone_length_col_to_countries_table', 111),
(230, '2021_09_23_143823_add_images_col_to_branches', 111),
(231, '2021_09_29_135328_add_weaccept_transaction_id_column_to_transactions_table', 112),
(232, '2021_10_06_093851_change_delivery_fees_column_from_districts', 113),
(233, '2021_10_26_154611_add_customer_first_name_to_addresses_table', 114),
(234, '2021_11_01_113206_update_promotions_table', 114),
(235, '2021_11_01_132018_create_promotion_conditions_table', 114),
(236, '2021_11_01_132400_create_promotion_conditions_custom_lists_table', 114),
(237, '2021_11_01_132529_create_promotion_targets_table', 114),
(238, '2021_11_01_132649_create_promotion_targets_custom_lists_table', 114),
(239, '2021_11_03_124040_add_barcode_column_to_products_table', 114),
(240, '2021_11_03_125853_add_slug_column_to_categories_table', 114),
(241, '2021_11_03_152221_add_list_id_to_promotions', 114),
(242, '2021_11_04_135812_add_list_method_and_list_method_to_lists_table', 114),
(243, '2021_11_04_141349_add_subtract_stock_column_to_products', 114),
(244, '2021_11_11_141349_add_qty_column_to_promotions', 114),
(245, '2021_11_15_114111_change_appear_in_search_column_in_options_table', 115),
(246, '2021_12_02_130937_add_active_col_to_payment_installments_table', 116),
(247, '2021_12_05_104630_change_sku_column_to_unique_in_products_table', 116),
(248, '2021_12_13_110355_add_b2b_columns_to_promotions_table', 116),
(249, '2021_12_13_110840_create_promotions_b2b_segments_table', 116),
(250, '2021_12_13_125341_alter_integer_to_float', 117),
(251, '2021_12_13_132058_update_promotion_segments_table', 118),
(252, '2021_12_13_135639_add_columns_to_categories_table', 119),
(253, '2021_12_14_103548_create_total_spent_per_categories_table', 119),
(254, '2021_12_14_160102_add_columns_to_users_table', 120),
(255, '2021_12_14_205333_make_iterator_nullable_in_promotion_segments', 121),
(256, '2021_12_15_131838_adjust_promotions_fields', 122),
(257, '2021_12_16_103529_add_payment_targets_column_to_categories_table', 123),
(258, '2021_12_21_130647_add_override_range_to_promotion_segments', 124),
(259, '2021_12_22_153638_add_quantity_to_promotion_targets', 125),
(260, '2021_12_26_133957_add_and_or_to_promotion_conditions_table', 126),
(261, '2021_12_27_164247_add_operator_to_promotion_targets', 127),
(262, '2021_12_28_114907_add_promotion_discount_to_orders', 128),
(263, '2022_01_03_124243_add_is_exclusive_to_promotions_table', 129),
(264, '2022_01_05_111859_add_per_month_to_promotions_table', 129),
(265, '2022_01_06_192813_create_promotion_user_table', 130),
(266, '2022_01_10_140933_create_promotion_groups_table', 131),
(267, '2022_01_10_141127_add_group_id_to_promotion_table', 131),
(268, '2022_01_12_145220_update_per_month_name_and_logic_in_promotions', 132),
(269, '2022_01_12_150636_change_periodic_type_in_promotions', 132),
(270, '2022_01_13_112845_make_periodic_nullable_in_promotions', 133),
(271, '2022_02_07_115334_add_family_id_column_to_categories_table', 134),
(272, '2022_03_02_115328_add_columns_to_products_table', 135),
(273, '2022_03_02_131125_add_columns_to_promotions_table', 136),
(274, '2022_03_02_131648_create_wallets_table', 137),
(275, '2022_03_03_155456_add_column_to_wallets_table', 138),
(276, '2022_03_06_124627_add_incentive_id_column_to_promotions_table', 139),
(277, '2022_03_07_135654_add_prod_id_to_products_table', 140),
(278, '2022_03_14_113246_rename_column_name_in_wallets_table', 141),
(279, '2022_01_18_160838_update_password_reset_email', 142),
(280, '2022_03_22_141756_add_approved_columns_to_wallets_table', 142),
(281, '2022_03_23_101838_create_customer_request_table', 143),
(282, '2022_03_23_161245_add_description_column_to_promotions_table', 144),
(283, '2022_03_27_113126_add_description_ar_column_to_promotions_table', 145),
(284, '2022_03_28_151811_add_wallet_redeem_to_orders_table', 146),
(285, '2022_04_03_123301_add_cashback_amount_to_orders_table', 147),
(286, '2022_06_20_134423_add_incentive_id_to_promos_table', 148),
(287, '2022_06_22_135048_add_deleted_at_column_to_lists_table', 149);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\Users\\User', 1),
(1, 'App\\Models\\Users\\User', 1004874),
(1, 'App\\Models\\Users\\User', 1008665),
(1, 'App\\Models\\Users\\User', 1015016),
(1, 'App\\Models\\Users\\User', 1016039),
(1, 'App\\Models\\Users\\User', 1016040),
(1, 'App\\Models\\Users\\User', 1016041),
(1, 'App\\Models\\Users\\User', 1016067),
(1, 'App\\Models\\Users\\User', 1016967),
(1, 'App\\Models\\Users\\User', 1017189),
(1, 'App\\Models\\Users\\User', 1017346),
(1, 'App\\Models\\Users\\User', 1017347),
(1, 'App\\Models\\Users\\User', 1017348),
(1, 'App\\Models\\Users\\User', 1017353),
(20, 'App\\Models\\Users\\User', 1000013),
(20, 'App\\Models\\Users\\User', 1000437),
(20, 'App\\Models\\Users\\User', 1008644),
(20, 'App\\Models\\Users\\User', 1008657),
(20, 'App\\Models\\Users\\User', 1008658),
(22, 'App\\Models\\Users\\User', 1008666),
(22, 'App\\Models\\Users\\User', 1015044),
(22, 'App\\Models\\Users\\User', 1015059),
(23, 'App\\Models\\Users\\User', 1008678),
(24, 'App\\Models\\Users\\User', 1015319),
(25, 'App\\Models\\Users\\User', 1015400),
(26, 'App\\Models\\Users\\User', 1015417),
(28, 'App\\Models\\Users\\User', 1017269),
(28, 'App\\Models\\Users\\User', 1017271),
(28, 'App\\Models\\Users\\User', 1017280),
(28, 'App\\Models\\Users\\User', 1017291);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_ar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `body_ar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `details` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_link` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `title`, `title_ar`, `body`, `body_ar`, `type`, `item_id`, `read`, `created_at`, `updated_at`, `image`, `details`, `item_link`) VALUES
(7133, NULL, 'New Order', NULL, 'You have received a new order 4236', NULL, NULL, NULL, 1, '2021-11-21 12:09:19', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7135, NULL, 'New Order', NULL, 'You have received a new order 4237', NULL, NULL, NULL, 1, '2021-11-21 12:17:50', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7137, NULL, 'New Order', NULL, 'You have received a new order 4238', NULL, NULL, NULL, 1, '2021-11-21 12:26:31', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7139, NULL, 'New Order', NULL, 'You have received a new order 4239', NULL, NULL, NULL, 1, '2021-11-21 13:34:44', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7141, NULL, 'New Order', NULL, 'You have received a new order 4240', NULL, NULL, NULL, 1, '2021-11-21 13:46:46', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7143, NULL, 'New Order', NULL, 'You have received a new order 4241', NULL, NULL, NULL, 1, '2021-11-21 14:15:19', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7145, NULL, 'New Order', NULL, 'You have received a new order 4242', NULL, NULL, NULL, 1, '2021-11-21 14:43:56', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7147, NULL, 'New Order', NULL, 'You have received a new order 4243', NULL, NULL, NULL, 1, '2021-11-21 14:44:26', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7149, NULL, 'New Order', NULL, 'You have received a new order 4244', NULL, NULL, NULL, 1, '2021-11-21 14:45:03', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7152, NULL, 'New Order', NULL, 'You have received a new order 4248', NULL, NULL, NULL, 1, '2021-12-15 12:47:50', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7154, NULL, 'New Order', NULL, 'You have received a new order 4249', NULL, NULL, NULL, 1, '2021-12-15 14:12:23', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7156, NULL, 'New Order', NULL, 'You have received a new order 4250', NULL, NULL, NULL, 1, '2021-12-15 14:18:04', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7158, NULL, 'New Order', NULL, 'You have received a new order 4251', NULL, NULL, NULL, 1, '2021-12-15 14:27:37', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7160, NULL, 'New Order', NULL, 'You have received a new order 4252', NULL, NULL, NULL, 1, '2021-12-15 14:49:01', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7162, NULL, 'New Order', NULL, 'You have received a new order 4253', NULL, NULL, NULL, 1, '2021-12-15 14:54:42', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7164, NULL, 'New Order', NULL, 'You have received a new order 4254', NULL, NULL, NULL, 1, '2021-12-15 14:58:25', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7166, NULL, 'New Order', NULL, 'You have received a new order 4255', NULL, NULL, NULL, 1, '2021-12-15 15:00:46', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7168, NULL, 'New Order', NULL, 'You have received a new order 4256', NULL, NULL, NULL, 1, '2021-12-15 15:01:58', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7170, NULL, 'New Order', NULL, 'You have received a new order 4257', NULL, NULL, NULL, 1, '2021-12-15 15:03:57', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7172, NULL, 'New Order', NULL, 'You have received a new order 4258', NULL, NULL, NULL, 1, '2021-12-15 15:04:36', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7174, NULL, 'New Order', NULL, 'You have received a new order 4259', NULL, NULL, NULL, 1, '2021-12-15 15:10:09', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7176, NULL, 'New Order', NULL, 'You have received a new order 4260', NULL, NULL, NULL, 1, '2021-12-15 15:24:08', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7178, NULL, 'New Order', NULL, 'You have received a new order 4261', NULL, NULL, NULL, 1, '2021-12-15 15:39:42', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7180, NULL, 'New Order', NULL, 'You have received a new order 4262', NULL, NULL, NULL, 1, '2021-12-15 15:41:35', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7182, NULL, 'New Order', NULL, 'You have received a new order 4263', NULL, NULL, NULL, 1, '2021-12-15 15:50:37', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7184, NULL, 'New Order', NULL, 'You have received a new order 4264', NULL, NULL, NULL, 1, '2021-12-15 15:59:46', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7186, NULL, 'New Order', NULL, 'You have received a new order 4265', NULL, NULL, NULL, 1, '2021-12-15 16:01:58', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7188, NULL, 'New Order', NULL, 'You have received a new order 4266', NULL, NULL, NULL, 1, '2021-12-15 16:10:25', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7190, NULL, 'New Order', NULL, 'You have received a new order 4267', NULL, NULL, NULL, 1, '2021-12-15 16:20:32', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7192, NULL, 'New Order', NULL, 'You have received a new order 4268', NULL, NULL, NULL, 1, '2021-12-15 16:22:38', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7194, NULL, 'New Order', NULL, 'You have received a new order 4269', NULL, NULL, NULL, 1, '2021-12-15 16:28:38', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7196, NULL, 'New Order', NULL, 'You have received a new order 4270', NULL, NULL, NULL, 1, '2021-12-15 17:08:14', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7198, NULL, 'New Order', NULL, 'You have received a new order 4271', NULL, NULL, NULL, 1, '2021-12-15 17:15:51', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7200, NULL, 'New Order', NULL, 'You have received a new order 4272', NULL, NULL, NULL, 1, '2021-12-15 17:47:12', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7202, NULL, 'New Order', NULL, 'You have received a new order 4273', NULL, NULL, NULL, 1, '2021-12-15 17:50:05', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7205, NULL, 'New Order', NULL, 'You have received a new order 4274', NULL, NULL, NULL, 1, '2021-12-16 08:53:26', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7229, NULL, 'New Order', NULL, 'You have received a new order 4275', NULL, NULL, NULL, 1, '2021-12-16 15:53:44', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7231, NULL, 'New Order', NULL, 'You have received a new order 4276', NULL, NULL, NULL, 1, '2021-12-16 15:54:28', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7234, NULL, 'New Order', NULL, 'You have received a new order 4277', NULL, NULL, NULL, 1, '2021-12-28 11:41:42', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7236, NULL, 'New Order', NULL, 'You have received a new order 4278', NULL, NULL, NULL, 1, '2021-12-28 11:46:03', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7239, NULL, 'New Order', NULL, 'You have received a new order 4279', NULL, NULL, NULL, 1, '2022-01-06 20:35:56', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7241, NULL, 'New Order', NULL, 'You have received a new order 4280', NULL, NULL, NULL, 1, '2022-01-08 13:39:16', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7243, NULL, 'New Order', NULL, 'You have received a new order 4281', NULL, NULL, NULL, 1, '2022-01-10 14:16:30', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7253, NULL, 'New Order', NULL, 'You have received a new order 4282', NULL, NULL, NULL, 1, '2022-01-10 15:17:25', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7255, NULL, 'New Order', NULL, 'You have received a new order 4283', NULL, NULL, NULL, 1, '2022-01-10 15:18:22', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7257, NULL, 'New Order', NULL, 'You have received a new order 4284', NULL, NULL, NULL, 1, '2022-01-10 15:20:17', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7260, NULL, 'New Order', NULL, 'You have received a new order 4285', NULL, NULL, NULL, 1, '2022-01-10 15:48:22', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7281, NULL, 'New Order', NULL, 'You have received a new order 4286', NULL, NULL, NULL, 1, '2022-01-11 14:07:13', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7286, NULL, 'New Order', NULL, 'You have received a new order 4287', NULL, NULL, NULL, 1, '2022-01-12 14:00:43', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7289, NULL, 'New Order', NULL, 'You have received a new order 4288', NULL, NULL, NULL, 1, '2022-01-12 14:25:17', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7292, NULL, 'New Order', NULL, 'You have received a new order 4289', NULL, NULL, NULL, 1, '2022-01-12 14:28:04', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7295, NULL, 'New Order', NULL, 'You have received a new order 4290', NULL, NULL, NULL, 1, '2022-01-12 14:31:00', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7305, NULL, 'New Order', NULL, 'You have received a new order 4291', NULL, NULL, NULL, 1, '2022-01-12 14:33:43', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7311, NULL, 'New Order', NULL, 'You have received a new order 4292', NULL, NULL, NULL, 1, '2022-01-12 14:46:51', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7314, NULL, 'New Order', NULL, 'You have received a new order 4293', NULL, NULL, NULL, 1, '2022-01-12 16:47:19', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7316, NULL, 'New Order', NULL, 'You have received a new order 4294', NULL, NULL, NULL, 1, '2022-01-12 16:53:12', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7318, NULL, 'New Order', NULL, 'You have received a new order 4295', NULL, NULL, NULL, 1, '2022-01-12 19:54:34', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7324, NULL, 'New Order', NULL, 'You have received a new order 4303', NULL, NULL, NULL, 1, '2022-03-02 16:27:04', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7325, 1019248, 'Order Created', 'تم الطلب', 'Your order #4303 is now Placed', 'حاله طلبك رقم #4303 هي تم الطلب', 5, 4303, 0, '2022-03-02 16:27:04', '2022-03-02 16:27:04', NULL, NULL, NULL),
(7326, NULL, 'New Order', NULL, 'You have received a new order 4304', NULL, NULL, NULL, 1, '2022-03-02 16:35:53', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7327, 1019248, 'Order Created', 'تم الطلب', 'Your order #4304 is now Placed', 'حاله طلبك رقم #4304 هي تم الطلب', 5, 4304, 0, '2022-03-02 16:35:53', '2022-03-02 16:35:53', NULL, NULL, NULL),
(7328, NULL, 'New Order', NULL, 'You have received a new order 4305', NULL, NULL, NULL, 1, '2022-03-02 16:39:49', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7329, 1019248, 'Order Created', 'تم الطلب', 'Your order #4305 is now Placed', 'حاله طلبك رقم #4305 هي تم الطلب', 5, 4305, 0, '2022-03-02 16:39:49', '2022-03-02 16:39:49', NULL, NULL, NULL),
(7330, NULL, 'New Order', NULL, 'You have received a new order 4306', NULL, NULL, NULL, 1, '2022-03-02 16:43:33', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7331, 1019248, 'Order Created', 'تم الطلب', 'Your order #4306 is now Placed', 'حاله طلبك رقم #4306 هي تم الطلب', 5, 4306, 0, '2022-03-02 16:43:33', '2022-03-02 16:43:33', NULL, NULL, NULL),
(7332, NULL, 'New Order', NULL, 'You have received a new order 1', NULL, NULL, NULL, 1, '2022-03-02 17:42:47', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7333, 1019248, 'Order Created', 'تم الطلب', 'Your order #1 is now Placed', 'حاله طلبك رقم #1 هي تم الطلب', 5, 1, 0, '2022-03-02 17:42:47', '2022-03-02 17:42:47', NULL, NULL, NULL),
(7334, NULL, 'New Order', NULL, 'You have received a new order 2', NULL, NULL, NULL, 1, '2022-03-03 10:04:36', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7335, 1019248, 'Order Created', 'تم الطلب', 'Your order #2 is now Placed', 'حاله طلبك رقم #2 هي تم الطلب', 5, 2, 0, '2022-03-03 10:04:37', '2022-03-03 10:04:37', NULL, NULL, NULL),
(7336, NULL, 'New Order', NULL, 'You have received a new order 1', NULL, NULL, NULL, 1, '2022-03-03 15:16:53', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7337, 1003849, 'Order Created', 'تم الطلب', 'Your order #1 is now Placed', 'حاله طلبك رقم #1 هي تم الطلب', 5, 1, 0, '2022-03-03 15:16:53', '2022-03-03 15:16:53', NULL, NULL, NULL),
(7338, NULL, 'New Order', NULL, 'You have received a new order 2', NULL, NULL, NULL, 1, '2022-03-03 15:27:33', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7339, 1003849, 'Order Created', 'تم الطلب', 'Your order #2 is now Placed', 'حاله طلبك رقم #2 هي تم الطلب', 5, 2, 0, '2022-03-03 15:27:33', '2022-03-03 15:27:33', NULL, NULL, NULL),
(7340, NULL, 'New Order', NULL, 'You have received a new order 3', NULL, NULL, NULL, 1, '2022-03-10 11:33:43', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7341, 1000004, 'Order Created', 'تم الطلب', 'Your order #3 is now Placed', 'حاله طلبك رقم #3 هي تم الطلب', 5, 3, 1, '2022-03-10 11:33:43', '2022-03-24 14:24:28', NULL, NULL, NULL),
(7342, NULL, 'New Order', NULL, 'You have received a new order 1', NULL, NULL, NULL, 1, '2022-03-10 12:05:10', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7343, 1000004, 'Order Created', 'تم الطلب', 'Your order #1 is now Placed', 'حاله طلبك رقم #1 هي تم الطلب', 5, 1, 1, '2022-03-10 12:05:10', '2022-03-24 14:27:21', NULL, NULL, NULL),
(7344, NULL, 'New Order', NULL, 'You have received a new order 2', NULL, NULL, NULL, 1, '2022-03-10 12:13:09', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7345, 1000004, 'Order Created', 'تم الطلب', 'Your order #2 is now Placed', 'حاله طلبك رقم #2 هي تم الطلب', 5, 2, 1, '2022-03-10 12:13:09', '2022-03-24 14:27:21', NULL, NULL, NULL),
(7346, NULL, 'New Order', NULL, 'You have received a new order 3', NULL, NULL, NULL, 1, '2022-03-10 12:17:02', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7347, 1000004, 'Order Created', 'تم الطلب', 'Your order #3 is now Placed', 'حاله طلبك رقم #3 هي تم الطلب', 5, 3, 1, '2022-03-10 12:17:02', '2022-03-24 14:27:21', NULL, NULL, NULL),
(7348, NULL, 'New Order', NULL, 'You have received a new order 4', NULL, NULL, NULL, 1, '2022-03-10 12:20:01', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7349, 1000004, 'Order Created', 'تم الطلب', 'Your order #4 is now Placed', 'حاله طلبك رقم #4 هي تم الطلب', 5, 4, 1, '2022-03-10 12:20:01', '2022-03-24 14:27:21', NULL, NULL, NULL),
(7350, NULL, 'New Order', NULL, 'You have received a new order 5', NULL, NULL, NULL, 1, '2022-03-10 12:22:32', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7351, 1000004, 'Order Created', 'تم الطلب', 'Your order #5 is now Placed', 'حاله طلبك رقم #5 هي تم الطلب', 5, 5, 1, '2022-03-10 12:22:32', '2022-03-24 14:27:21', NULL, NULL, NULL),
(7352, NULL, 'New Order', NULL, 'You have received a new order 6', NULL, NULL, NULL, 1, '2022-03-10 12:25:02', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7353, 1000004, 'Order Created', 'تم الطلب', 'Your order #6 is now Placed', 'حاله طلبك رقم #6 هي تم الطلب', 5, 6, 1, '2022-03-10 12:25:02', '2022-03-24 14:27:21', NULL, NULL, NULL),
(7354, NULL, 'New Order', NULL, 'You have received a new order 7', NULL, NULL, NULL, 1, '2022-03-15 16:07:55', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7356, NULL, 'New Order', NULL, 'You have received a new order 1', NULL, NULL, NULL, 1, '2022-03-16 12:37:21', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7357, 1000002, 'Order Created', 'تم الطلب', 'Your order #1 is now Placed', 'حاله طلبك رقم #1 هي تم الطلب', 5, 1, 0, '2022-03-16 12:37:21', '2022-03-16 12:37:21', NULL, NULL, NULL),
(7358, NULL, 'New Order', NULL, 'You have received a new order 1', NULL, NULL, NULL, 1, '2022-03-16 12:48:48', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7359, 1000002, 'Order Created', 'تم الطلب', 'Your order #1 is now Placed', 'حاله طلبك رقم #1 هي تم الطلب', 5, 1, 0, '2022-03-16 12:48:48', '2022-03-16 12:48:48', NULL, NULL, NULL),
(7360, NULL, 'New Order', NULL, 'You have received a new order 1', NULL, NULL, NULL, 1, '2022-03-16 12:55:38', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7361, 1000002, 'Order Created', 'تم الطلب', 'Your order #1 is now Placed', 'حاله طلبك رقم #1 هي تم الطلب', 5, 1, 0, '2022-03-16 12:55:38', '2022-03-16 12:55:38', NULL, NULL, NULL),
(7362, NULL, 'New Order', NULL, 'You have received a new order 2', NULL, NULL, NULL, 1, '2022-03-16 12:57:41', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7363, 1000002, 'Order Created', 'تم الطلب', 'Your order #2 is now Placed', 'حاله طلبك رقم #2 هي تم الطلب', 5, 2, 0, '2022-03-16 12:57:41', '2022-03-16 12:57:41', NULL, NULL, NULL),
(7364, NULL, 'New Order', NULL, 'You have received a new order 3', NULL, NULL, NULL, 1, '2022-03-16 13:13:16', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7365, 1000002, 'Order Created', 'تم الطلب', 'Your order #3 is now Placed', 'حاله طلبك رقم #3 هي تم الطلب', 5, 3, 0, '2022-03-16 13:13:16', '2022-03-16 13:13:16', NULL, NULL, NULL),
(7366, NULL, 'New Order', NULL, 'You have received a new order 4', NULL, NULL, NULL, 1, '2022-03-16 13:17:28', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7367, 1000002, 'Order Created', 'تم الطلب', 'Your order #4 is now Placed', 'حاله طلبك رقم #4 هي تم الطلب', 5, 4, 0, '2022-03-16 13:17:28', '2022-03-16 13:17:28', NULL, NULL, NULL),
(7368, NULL, 'New Order', NULL, 'You have received a new order 5', NULL, NULL, NULL, 1, '2022-03-16 13:26:09', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7369, 1000002, 'Order Created', 'تم الطلب', 'Your order #5 is now Placed', 'حاله طلبك رقم #5 هي تم الطلب', 5, 5, 0, '2022-03-16 13:26:09', '2022-03-16 13:26:09', NULL, NULL, NULL),
(7370, NULL, 'New Order', NULL, 'You have received a new order 6', NULL, NULL, NULL, 1, '2022-03-16 13:35:58', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7371, 1000002, 'Order Created', 'تم الطلب', 'Your order #6 is now Placed', 'حاله طلبك رقم #6 هي تم الطلب', 5, 6, 0, '2022-03-16 13:35:58', '2022-03-16 13:35:58', NULL, NULL, NULL),
(7372, NULL, 'New Order', NULL, 'You have received a new order 7', NULL, NULL, NULL, 1, '2022-03-16 13:47:48', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7373, 1000002, 'Order Created', 'تم الطلب', 'Your order #7 is now Placed', 'حاله طلبك رقم #7 هي تم الطلب', 5, 7, 0, '2022-03-16 13:47:48', '2022-03-16 13:47:48', NULL, NULL, NULL),
(7374, NULL, 'New Order', NULL, 'You have received a new order 8', NULL, NULL, NULL, 1, '2022-03-16 13:54:23', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7375, 1000002, 'Order Created', 'تم الطلب', 'Your order #8 is now Placed', 'حاله طلبك رقم #8 هي تم الطلب', 5, 8, 0, '2022-03-16 13:54:23', '2022-03-16 13:54:23', NULL, NULL, NULL),
(7376, NULL, 'New Order', NULL, 'You have received a new order 9', NULL, NULL, NULL, 1, '2022-03-16 13:55:30', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7377, 1000002, 'Order Created', 'تم الطلب', 'Your order #9 is now Placed', 'حاله طلبك رقم #9 هي تم الطلب', 5, 9, 0, '2022-03-16 13:55:30', '2022-03-16 13:55:30', NULL, NULL, NULL),
(7378, NULL, 'New Order', NULL, 'You have received a new order 10', NULL, NULL, NULL, 1, '2022-03-16 14:00:33', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7379, 1000002, 'Order Created', 'تم الطلب', 'Your order #10 is now Placed', 'حاله طلبك رقم #10 هي تم الطلب', 5, 10, 0, '2022-03-16 14:00:33', '2022-03-16 14:00:33', NULL, NULL, NULL),
(7380, NULL, 'New Order', NULL, 'You have received a new order 11', NULL, NULL, NULL, 1, '2022-03-16 14:05:44', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7381, 1000002, 'Order Created', 'تم الطلب', 'Your order #11 is now Placed', 'حاله طلبك رقم #11 هي تم الطلب', 5, 11, 0, '2022-03-16 14:05:44', '2022-03-16 14:05:44', NULL, NULL, NULL),
(7382, NULL, 'New Order', NULL, 'You have received a new order 12', NULL, NULL, NULL, 1, '2022-03-16 14:08:24', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7383, 1000002, 'Order Created', 'تم الطلب', 'Your order #12 is now Placed', 'حاله طلبك رقم #12 هي تم الطلب', 5, 12, 0, '2022-03-16 14:08:24', '2022-03-16 14:08:24', NULL, NULL, NULL),
(7384, NULL, 'New Order', NULL, 'You have received a new order 13', NULL, NULL, NULL, 1, '2022-03-16 14:19:09', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7385, 1000002, 'Order Created', 'تم الطلب', 'Your order #13 is now Placed', 'حاله طلبك رقم #13 هي تم الطلب', 5, 13, 0, '2022-03-16 14:19:09', '2022-03-16 14:19:09', NULL, NULL, NULL),
(7386, NULL, 'New Order', NULL, 'You have received a new order 14', NULL, NULL, NULL, 1, '2022-03-16 14:21:36', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7387, 1000002, 'Order Created', 'تم الطلب', 'Your order #14 is now Placed', 'حاله طلبك رقم #14 هي تم الطلب', 5, 14, 0, '2022-03-16 14:21:36', '2022-03-16 14:21:36', NULL, NULL, NULL),
(7388, NULL, 'New Order', NULL, 'You have received a new order 15', NULL, NULL, NULL, 1, '2022-03-16 14:23:17', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7389, 1000002, 'Order Created', 'تم الطلب', 'Your order #15 is now Placed', 'حاله طلبك رقم #15 هي تم الطلب', 5, 15, 0, '2022-03-16 14:23:17', '2022-03-16 14:23:17', NULL, NULL, NULL),
(7390, NULL, 'New Order', NULL, 'You have received a new order 16', NULL, NULL, NULL, 1, '2022-03-16 14:27:17', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7391, 1000002, 'Order Created', 'تم الطلب', 'Your order #16 is now Placed', 'حاله طلبك رقم #16 هي تم الطلب', 5, 16, 1, '2022-03-16 14:27:17', '2022-07-24 04:32:28', NULL, NULL, NULL),
(7392, NULL, 'New Order', NULL, 'You have received a new order 17', NULL, NULL, NULL, 1, '2022-03-16 14:34:07', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7393, 1000002, 'Order Created', 'تم الطلب', 'Your order #17 is now Placed', 'حاله طلبك رقم #17 هي تم الطلب', 5, 17, 1, '2022-03-16 14:34:07', '2022-07-24 04:32:28', NULL, NULL, NULL),
(7394, NULL, 'New Order', NULL, 'You have received a new order 18', NULL, NULL, NULL, 1, '2022-03-16 14:37:59', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7395, 1000002, 'Order Created', 'تم الطلب', 'Your order #18 is now Placed', 'حاله طلبك رقم #18 هي تم الطلب', 5, 18, 1, '2022-03-16 14:37:59', '2022-07-24 04:32:28', NULL, NULL, NULL),
(7396, NULL, 'New Order', NULL, 'You have received a new order 19', NULL, NULL, NULL, 1, '2022-03-16 14:42:23', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7397, 1000002, 'Order Created', 'تم الطلب', 'Your order #19 is now Placed', 'حاله طلبك رقم #19 هي تم الطلب', 5, 19, 1, '2022-03-16 14:42:23', '2022-07-24 04:32:28', NULL, NULL, NULL),
(7398, NULL, 'New Order', NULL, 'You have received a new order 20', NULL, NULL, NULL, 1, '2022-03-16 14:44:40', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7399, 1000002, 'Order Created', 'تم الطلب', 'Your order #20 is now Placed', 'حاله طلبك رقم #20 هي تم الطلب', 5, 20, 1, '2022-03-16 14:44:40', '2022-07-24 04:32:28', NULL, NULL, NULL),
(7400, NULL, 'New Order', NULL, 'You have received a new order 21', NULL, NULL, NULL, 1, '2022-03-22 11:42:10', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7402, NULL, 'New Order', NULL, 'You have received a new order 22', NULL, NULL, NULL, 1, '2022-03-22 14:00:39', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7404, NULL, 'New Order', NULL, 'You have received a new order 23', NULL, NULL, NULL, 1, '2022-03-22 14:23:22', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7406, NULL, 'New Order', NULL, 'You have received a new order 24', NULL, NULL, NULL, 1, '2022-03-22 15:05:34', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7407, 1000003, 'Order Created', 'تم الطلب', 'Your order #24 is now Placed', 'حاله طلبك رقم #24 هي تم الطلب', 5, 24, 1, '2022-03-22 15:05:34', '2022-03-29 14:17:57', NULL, NULL, NULL),
(7408, NULL, 'New Order', NULL, 'You have received a new order 25', NULL, NULL, NULL, 1, '2022-03-22 15:21:29', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7409, 1000003, 'Order Created', 'تم الطلب', 'Your order #25 is now Placed', 'حاله طلبك رقم #25 هي تم الطلب', 5, 25, 1, '2022-03-22 15:21:29', '2022-03-29 14:17:57', NULL, NULL, NULL),
(7410, NULL, 'New Order', NULL, 'You have received a new order 26', NULL, NULL, NULL, 1, '2022-03-23 15:32:58', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7412, NULL, 'New Order', NULL, 'You have received a new order 27', NULL, NULL, NULL, 1, '2022-03-24 10:52:26', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7413, 1000003, 'Order Created', 'تم الطلب', 'Your order #27 is now Placed', 'حاله طلبك رقم #27 هي تم الطلب', 5, 27, 1, '2022-03-24 10:52:26', '2022-03-29 14:17:57', NULL, NULL, NULL),
(7414, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #27 Status is now Confirmed', 'تم تغيير حالة الطلب #27 الي تم تأكيد الطلب', 5, 27, 1, '2022-03-24 10:53:12', '2022-04-04 11:26:51', NULL, NULL, NULL),
(7415, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #27 Status is now Cancelled', 'تم تغيير حالة الطلب #27 الي تم الالغاء', 5, 27, 1, '2022-03-24 11:31:17', '2022-04-04 11:26:51', NULL, NULL, NULL),
(7416, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #27 Status is now Placed', 'تم تغيير حالة الطلب #27 الي تم الطلب', 5, 27, 1, '2022-03-24 11:31:55', '2022-04-04 11:26:51', NULL, NULL, NULL),
(7417, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #27 Status is now Confirmed', 'تم تغيير حالة الطلب #27 الي تم تأكيد الطلب', 5, 27, 1, '2022-03-24 11:32:16', '2022-04-04 11:26:51', NULL, NULL, NULL),
(7418, NULL, 'New Order', NULL, 'You have received a new order 28', NULL, NULL, NULL, 1, '2022-03-24 13:58:24', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7419, 1000004, 'Order Created', 'تم الطلب', 'Your order #28 is now Placed', 'حاله طلبك رقم #28 هي تم الطلب', 5, 28, 1, '2022-03-24 13:58:24', '2022-03-24 14:27:21', NULL, NULL, NULL),
(7420, 1000004, 'Order Status Change', 'تغيير حالة الطلب', 'Order #28 Status is now Confirmed', 'تم تغيير حالة الطلب #28 الي تم تأكيد الطلب', 5, 28, 1, '2022-03-24 14:24:09', '2022-03-24 14:27:21', NULL, NULL, NULL),
(7421, 1000004, 'Order Status Change', 'تغيير حالة الطلب', 'Order #28 Status is now Shipped', 'تم تغيير حالة الطلب #28 الي تم التسليم', 5, 28, 1, '2022-03-24 14:24:42', '2022-03-24 14:27:21', NULL, NULL, NULL),
(7422, 1000004, 'Order Status Change', 'تغيير حالة الطلب', 'Order #28 Status is now Delivered', 'تم تغيير حالة الطلب #28 الي تم التوصيل', 5, 28, 1, '2022-03-24 14:25:04', '2022-03-24 14:27:21', NULL, NULL, NULL),
(7423, NULL, 'New Order', NULL, 'You have received a new order 29', NULL, NULL, NULL, 1, '2022-03-24 14:38:31', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7424, 1000004, 'Order Created', 'تم الطلب', 'Your order #29 is now Placed', 'حاله طلبك رقم #29 هي تم الطلب', 5, 29, 0, '2022-03-24 14:38:31', '2022-03-24 14:38:31', NULL, NULL, NULL),
(7425, 1000004, 'Mansour Group', 'مجموعة منصور', '70 has been added to your wallet', 'تم إضافة 70 الى محفظتك', 5, NULL, 0, '2022-03-24 14:38:31', '2022-03-24 14:38:31', NULL, NULL, NULL),
(7426, 1000004, 'Order Status Change', 'تغيير حالة الطلب', 'Order #29 Status is now Delivered', 'تم تغيير حالة الطلب #29 الي تم التوصيل', 5, 29, 0, '2022-03-24 14:39:33', '2022-03-24 14:39:33', NULL, NULL, NULL),
(7427, NULL, 'New Order', NULL, 'You have received a new order 30', NULL, NULL, NULL, 1, '2022-03-24 15:10:02', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7428, 1000004, 'Order Created', 'تم الطلب', 'Your order #30 is now Placed', 'حاله طلبك رقم #30 هي تم الطلب', 5, 30, 0, '2022-03-24 15:10:02', '2022-03-24 15:10:02', NULL, NULL, NULL),
(7429, 1000004, 'Mansour Group', 'مجموعة منصور', '70 has been added to your wallet', 'تم إضافة 70 الى محفظتك', 5, NULL, 0, '2022-03-24 15:11:10', '2022-03-24 15:11:10', NULL, NULL, NULL),
(7430, 1000004, 'Order Status Change', 'تغيير حالة الطلب', 'Order #30 Status is now Delivered', 'تم تغيير حالة الطلب #30 الي تم التوصيل', 5, 30, 0, '2022-03-24 15:11:10', '2022-03-24 15:11:10', NULL, NULL, NULL),
(7431, 1000004, 'Mansour Group', 'مجموعة منصور', '70 has been added to your wallet', 'تم إضافة 70 الى محفظتك', 5, NULL, 0, '2022-03-24 15:22:02', '2022-03-24 15:22:02', NULL, NULL, NULL),
(7432, 1000004, 'Order Status Change', 'تغيير حالة الطلب', 'Order #30 Status is now Delivered', 'تم تغيير حالة الطلب #30 الي تم التوصيل', 5, 30, 0, '2022-03-24 15:22:02', '2022-03-24 15:22:02', NULL, NULL, NULL),
(7433, 1000004, 'Mansour Group', 'مجموعة منصور', '70 has been added to your wallet', 'تم إضافة 70 الى محفظتك', 5, NULL, 1, '2022-03-24 15:23:44', '2022-03-24 16:22:07', NULL, NULL, NULL),
(7434, 1000004, 'Order Status Change', 'تغيير حالة الطلب', 'Order #30 Status is now Delivered', 'تم تغيير حالة الطلب #30 الي تم التوصيل', 5, 30, 0, '2022-03-24 15:23:44', '2022-03-24 15:23:44', NULL, NULL, NULL),
(7435, 1000004, 'Mansour Group', 'مجموعة منصور', '70 EGP has been added to your wallet', 'تم إضافة 70 جنيه الى محفظتك', 5, NULL, 1, '2022-03-24 15:31:26', '2022-03-24 16:22:07', NULL, NULL, NULL),
(7436, 1000004, 'Order Status Change', 'تغيير حالة الطلب', 'Order #30 Status is now Delivered', 'تم تغيير حالة الطلب #30 الي تم التوصيل', 5, 30, 1, '2022-03-24 15:31:26', '2022-03-24 16:22:07', NULL, NULL, NULL),
(7437, 1000004, 'Mansour Group', 'مجموعة منصور', '70 EGP has been added to your wallet', 'تم إضافة 70 جنيه الى محفظتك', 5, NULL, 1, '2022-03-24 15:42:31', '2022-03-24 16:22:07', NULL, NULL, NULL),
(7438, 1000004, 'Order Status Change', 'تغيير حالة الطلب', 'Order #30 Status is now Delivered', 'تم تغيير حالة الطلب #30 الي تم التوصيل', 5, 30, 1, '2022-03-24 15:42:31', '2022-03-24 16:22:07', NULL, NULL, NULL),
(7439, 1000004, 'Mansour Group', 'مجموعة منصور', '70 EGP has been added to your wallet', 'تم إضافة 70 جنيه الى محفظتك', 5, NULL, 1, '2022-03-24 15:58:28', '2022-03-24 16:22:07', NULL, NULL, NULL),
(7440, 1000004, 'Order Status Change', 'تغيير حالة الطلب', 'Order #30 Status is now Delivered', 'تم تغيير حالة الطلب #30 الي تم التوصيل', 5, 30, 1, '2022-03-24 15:58:28', '2022-03-24 16:22:07', NULL, NULL, NULL),
(7441, NULL, 'New Order', NULL, 'You have received a new order 31', NULL, NULL, NULL, 1, '2022-03-24 16:06:49', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7442, 1000004, 'Order Created', 'تم الطلب', 'Your order #31 is now Placed', 'حاله طلبك رقم #31 هي تم الطلب', 5, 31, 1, '2022-03-24 16:06:49', '2022-03-24 16:22:07', NULL, NULL, NULL),
(7443, 1000004, 'Mansour Group', 'مجموعة منصور', '70 EGP has been added to your wallet', 'تم إضافة 70 جنيه الى محفظتك', 5, NULL, 1, '2022-03-24 16:16:43', '2022-03-24 16:22:07', NULL, NULL, NULL),
(7444, 1000004, 'Order Status Change', 'تغيير حالة الطلب', 'Order #30 Status is now Delivered', 'تم تغيير حالة الطلب #30 الي تم التوصيل', 5, 30, 1, '2022-03-24 16:16:43', '2022-03-24 16:22:07', NULL, NULL, NULL),
(7445, 1000004, 'Mansour Group', 'مجموعة منصور', '70 EGP has been added to your wallet', 'تم إضافة 70 جنيه الى محفظتك', 5, NULL, 0, '2022-03-24 16:36:13', '2022-03-24 16:36:13', NULL, NULL, NULL),
(7446, 1000004, 'Order Status Change', 'تغيير حالة الطلب', 'Order #30 Status is now Delivered', 'تم تغيير حالة الطلب #30 الي تم التوصيل', 5, 30, 0, '2022-03-24 16:36:14', '2022-03-24 16:36:14', NULL, NULL, NULL),
(7447, 1000004, 'Mansour Group', 'مجموعة منصور', '70 EGP has been added to your wallet', 'تم إضافة 70 جنيه الى محفظتك', 5, NULL, 0, '2022-03-24 16:45:19', '2022-03-24 16:45:19', NULL, NULL, NULL),
(7448, 1000004, 'Order Status Change', 'تغيير حالة الطلب', 'Order #30 Status is now Delivered', 'تم تغيير حالة الطلب #30 الي تم التوصيل', 5, 30, 0, '2022-03-24 16:45:19', '2022-03-24 16:45:19', NULL, NULL, NULL),
(7449, 1000004, 'Order Status Change', 'تغيير حالة الطلب', 'Order #31 Status is now Cancelled', 'تم تغيير حالة الطلب #31 الي تم الالغاء', 5, 31, 0, '2022-03-24 16:45:58', '2022-03-24 16:45:58', NULL, NULL, NULL),
(7450, 1000004, 'Mansour Group', 'مجموعة منصور', '70 EGP has been added to your wallet', 'تم إضافة 70 جنيه الى محفظتك', 5, NULL, 0, '2022-03-24 16:47:28', '2022-03-24 16:47:28', NULL, NULL, NULL),
(7451, 1000004, 'Order Status Change', 'تغيير حالة الطلب', 'Order #30 Status is now Delivered', 'تم تغيير حالة الطلب #30 الي تم التوصيل', 5, 30, 0, '2022-03-24 16:47:28', '2022-03-24 16:47:28', NULL, NULL, NULL),
(7452, 1000004, 'Order Status Change', 'تغيير حالة الطلب', 'Order #30 Status is now Returned', 'تم تغيير حالة الطلب #30 الي تم الاسترجاع', 5, 30, 0, '2022-03-24 16:50:20', '2022-03-24 16:50:20', NULL, NULL, NULL),
(7453, NULL, 'New Order', NULL, 'You have received a new order 32', NULL, NULL, NULL, 1, '2022-03-24 16:53:21', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7454, 1000004, 'Order Created', 'تم الطلب', 'Your order #32 is now Placed', 'حاله طلبك رقم #32 هي تم الطلب', 5, 32, 0, '2022-03-24 16:53:21', '2022-03-24 16:53:21', NULL, NULL, NULL),
(7455, 1000004, 'Mansour Group', 'مجموعة منصور', '70 EGP has been added to your wallet', 'تم إضافة 70 جنيه الى محفظتك', 5, NULL, 0, '2022-03-24 16:54:39', '2022-03-24 16:54:39', NULL, NULL, NULL),
(7456, 1000004, 'Mansour Group', 'مجموعة منصور', '70 EGP has been added to your wallet', 'تم إضافة 70 جنيه الى محفظتك', 5, NULL, 0, '2022-03-24 16:58:24', '2022-03-24 16:58:24', NULL, NULL, NULL),
(7457, 1000004, 'Order Status Change', 'تغيير حالة الطلب', 'Order #30 Status is now Delivered', 'تم تغيير حالة الطلب #30 الي تم التوصيل', 5, 30, 0, '2022-03-24 16:58:59', '2022-03-24 16:58:59', NULL, NULL, NULL),
(7458, 1000004, 'Mansour Group', 'مجموعة منصور', '70 EGP has been added to your wallet', 'تم إضافة 70 جنيه الى محفظتك', 5, NULL, 0, '2022-03-24 16:59:26', '2022-03-24 16:59:26', NULL, NULL, NULL),
(7459, NULL, 'New Order', NULL, 'You have received a new order 33', NULL, NULL, NULL, 1, '2022-03-24 17:09:07', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7461, 1000004, 'Order Status Change', 'تغيير حالة الطلب', 'Order #30 Status is now Delivered', 'تم تغيير حالة الطلب #30 الي تم التوصيل', 5, 30, 0, '2022-03-24 17:15:15', '2022-03-24 17:15:15', NULL, NULL, NULL),
(7462, 1000004, 'Mansour Group', 'مجموعة منصور', '70 EGP has been added to your wallet', 'تم إضافة 70 جنيه الى محفظتك', 5, NULL, 0, '2022-03-24 17:15:17', '2022-03-24 17:15:17', NULL, NULL, NULL),
(7463, 1000004, 'Mansour Group', 'مجموعة منصور', '70 EGP has been added to your wallet', 'تم إضافة 70 جنيه الى محفظتك', 5, NULL, 0, '2022-03-24 17:16:13', '2022-03-24 17:16:13', NULL, NULL, NULL),
(7464, 1000004, 'Mansour Group', 'مجموعة منصور', '70 EGP has been added to your wallet', 'تم إضافة 70 جنيه الى محفظتك', 5, NULL, 0, '2022-03-24 17:18:50', '2022-03-24 17:18:50', NULL, NULL, NULL),
(7465, 1000004, 'Order Status Change', 'تغيير حالة الطلب', 'Order #30 Status is now Delivered', 'تم تغيير حالة الطلب #30 الي تم التوصيل', 5, 30, 0, '2022-03-24 17:19:06', '2022-03-24 17:19:06', NULL, NULL, NULL),
(7466, 1000004, 'Mansour Group', 'مجموعة منصور', '70 EGP has been added to your wallet', 'تم إضافة 70 جنيه الى محفظتك', 5, NULL, 0, '2022-03-24 17:19:06', '2022-03-24 17:19:06', NULL, NULL, NULL),
(7467, 1000004, 'Order Status Change', 'تغيير حالة الطلب', 'Order #30 Status is now Delivered', 'تم تغيير حالة الطلب #30 الي تم التوصيل', 5, 30, 1, '2022-03-24 17:19:33', '2022-03-28 15:13:32', NULL, NULL, NULL),
(7468, 1000004, 'Mansour Group', 'مجموعة منصور', '70 EGP has been added to your wallet', 'تم إضافة 70 جنيه الى محفظتك', 5, NULL, 0, '2022-03-24 17:19:33', '2022-03-24 17:19:33', NULL, NULL, NULL),
(7469, 1000004, 'Order Status Change', 'تغيير حالة الطلب', 'Order #28 Status is now Returned', 'تم تغيير حالة الطلب #28 الي تم الاسترجاع', 5, 28, 1, '2022-03-27 12:18:01', '2022-03-28 15:13:32', NULL, NULL, NULL),
(7471, NULL, 'New Order', NULL, 'You have received a new order 34', NULL, NULL, NULL, 1, '2022-03-27 14:05:16', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7475, NULL, 'New Order', NULL, 'You have received a new order 35', NULL, NULL, NULL, 1, '2022-03-27 14:12:44', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7478, NULL, 'New Order', NULL, 'You have received a new order 36', NULL, NULL, NULL, 1, '2022-03-27 14:15:12', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7481, NULL, 'New Order', NULL, 'You have received a new order 37', NULL, NULL, NULL, 1, '2022-03-27 14:24:33', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7484, NULL, 'New Order', NULL, 'You have received a new order 38', NULL, NULL, NULL, 1, '2022-03-27 15:00:59', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7487, NULL, 'New Order', NULL, 'You have received a new order 39', NULL, NULL, NULL, 1, '2022-03-27 16:51:29', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7489, NULL, 'Order Cancelled', NULL, 'Customer 1000001 Has just cancelled order 39', NULL, NULL, NULL, 1, '2022-03-28 11:16:13', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7490, NULL, 'Order Cancelled', NULL, 'Customer 1000001 Has just cancelled order 39', NULL, NULL, NULL, 1, '2022-03-28 11:16:14', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7491, NULL, 'Order Cancelled', NULL, 'Customer 1000004 Has just cancelled order 32', NULL, NULL, NULL, 1, '2022-03-28 14:50:44', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7492, NULL, 'New Order', NULL, 'You have received a new order 40', NULL, NULL, NULL, 1, '2022-03-28 14:51:10', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7493, 1000004, 'Order Created', 'تم الطلب', 'Your order #40 is now Placed', 'حاله طلبك رقم #40 هي تم الطلب', 5, 40, 1, '2022-03-28 14:51:10', '2022-03-28 15:13:32', NULL, NULL, NULL),
(7494, NULL, 'Order Cancelled', NULL, 'Customer 1000004 Has just cancelled order 40', NULL, NULL, NULL, 1, '2022-03-28 14:51:18', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7495, NULL, 'New Order', NULL, 'You have received a new order 41', NULL, NULL, NULL, 1, '2022-03-28 14:59:04', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7496, 1000004, 'Order Created', 'تم الطلب', 'Your order #41 is now Placed', 'حاله طلبك رقم #41 هي تم الطلب', 5, 41, 1, '2022-03-28 14:59:04', '2022-03-28 15:13:32', NULL, NULL, NULL),
(7497, 1000004, 'Order Status Change', 'تغيير حالة الطلب', 'Order #41 Status is now Delivered', 'تم تغيير حالة الطلب #41 الي تم التوصيل', 5, 41, 1, '2022-03-28 15:00:06', '2022-03-28 15:13:32', NULL, NULL, NULL),
(7498, 1000004, 'Order Status Change', 'تغيير حالة الطلب', 'Order #41 Status is now Returned', 'تم تغيير حالة الطلب #41 الي تم الاسترجاع', 5, 41, 1, '2022-03-28 15:01:42', '2022-03-28 15:13:32', NULL, NULL, NULL),
(7499, NULL, 'New Order', NULL, 'You have received a new order 42', NULL, NULL, NULL, 1, '2022-03-28 15:04:28', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7500, 1000004, 'Order Created', 'تم الطلب', 'Your order #42 is now Placed', 'حاله طلبك رقم #42 هي تم الطلب', 5, 42, 1, '2022-03-28 15:04:28', '2022-03-28 15:13:32', NULL, NULL, NULL),
(7501, 1000004, 'Order Status Change', 'تغيير حالة الطلب', 'Order #42 Status is now Delivered', 'تم تغيير حالة الطلب #42 الي تم التوصيل', 5, 42, 1, '2022-03-28 15:07:02', '2022-03-28 15:13:32', NULL, NULL, NULL),
(7502, NULL, 'New Order', NULL, 'You have received a new order 43', NULL, NULL, NULL, 1, '2022-03-28 15:10:29', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7503, 1000004, 'Order Created', 'تم الطلب', 'Your order #43 is now Placed', 'حاله طلبك رقم #43 هي تم الطلب', 5, 43, 1, '2022-03-28 15:10:29', '2022-03-28 15:13:32', NULL, NULL, NULL),
(7504, 1000004, 'Wallet Redeem', 'خصم المحفظة', 'Wallet redeemed with 140 EGP', 'تم خصم 140 جنيه من المحفظة', 5, NULL, 1, '2022-03-28 15:10:30', '2022-03-28 15:13:32', NULL, NULL, NULL),
(7505, 1000004, 'Order Status Change', 'تغيير حالة الطلب', 'Order #43 Status is now Delivered', 'تم تغيير حالة الطلب #43 الي تم التوصيل', 5, 43, 0, '2022-03-28 15:30:53', '2022-03-28 15:30:53', NULL, NULL, NULL),
(7506, NULL, 'New Order', NULL, 'You have received a new order 44', NULL, NULL, NULL, 1, '2022-03-28 15:31:12', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7507, 1000004, 'Order Created', 'تم الطلب', 'Your order #44 is now Placed', 'حاله طلبك رقم #44 هي تم الطلب', 5, 44, 1, '2022-03-28 15:31:12', '2022-03-29 12:11:00', NULL, NULL, NULL),
(7508, NULL, 'Order Cancelled', NULL, 'Customer 1000004 Has just cancelled order 44', NULL, NULL, NULL, 1, '2022-03-28 16:02:57', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7509, NULL, 'New Order', NULL, 'You have received a new order 45', NULL, NULL, NULL, 1, '2022-03-28 16:28:14', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7510, 1000004, 'Order Created', 'تم الطلب', 'Your order #45 is now Placed', 'حاله طلبك رقم #45 هي تم الطلب', 5, 45, 1, '2022-03-28 16:28:14', '2022-03-29 12:11:00', NULL, NULL, NULL),
(7511, 1000004, 'Mansour Group', 'مجموعة منصور', '70 EGP has been added to your wallet', 'تم إضافة 70 جنيه الى محفظتك', 5, NULL, 1, '2022-03-28 16:30:45', '2022-03-29 12:11:00', NULL, NULL, NULL),
(7512, 1000004, 'Order Status Change', 'تغيير حالة الطلب', 'Order #45 Status is now Delivered', 'تم تغيير حالة الطلب #45 الي تم التوصيل', 5, 45, 1, '2022-03-28 16:30:45', '2022-03-29 12:11:00', NULL, NULL, NULL),
(7513, 1000004, 'Order Status Change', 'تغيير حالة الطلب', 'Order #45 Status is now Returned', 'تم تغيير حالة الطلب #45 الي تم الاسترجاع', 5, 45, 1, '2022-03-28 16:31:21', '2022-03-29 12:11:00', NULL, NULL, NULL),
(7514, NULL, 'New Order', NULL, 'You have received a new order 46', NULL, NULL, NULL, 1, '2022-03-28 17:11:47', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7515, 1000004, 'Order Created', 'تم الطلب', 'Your order #46 is now Placed', 'حاله طلبك رقم #46 هي تم الطلب', 5, 46, 1, '2022-03-28 17:11:47', '2022-03-29 12:11:00', NULL, NULL, NULL),
(7516, 1000004, 'Mansour Group', 'مجموعة منصور', '70 EGP has been added to your wallet', 'تم إضافة 70 جنيه الى محفظتك', 5, NULL, 1, '2022-03-28 17:12:41', '2022-03-29 12:11:00', NULL, NULL, NULL),
(7517, 1000004, 'Order Status Change', 'تغيير حالة الطلب', 'Order #46 Status is now Delivered', 'تم تغيير حالة الطلب #46 الي تم التوصيل', 5, 46, 1, '2022-03-28 17:12:41', '2022-03-29 12:11:00', NULL, NULL, NULL),
(7518, NULL, 'New Order', NULL, 'You have received a new order 47', NULL, NULL, NULL, 1, '2022-03-28 17:13:47', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7519, 1000004, 'Order Created', 'تم الطلب', 'Your order #47 is now Placed', 'حاله طلبك رقم #47 هي تم الطلب', 5, 47, 1, '2022-03-28 17:13:47', '2022-03-29 12:11:00', NULL, NULL, NULL),
(7520, 1000004, 'Wallet Redeem', 'خصم المحفظة', 'Wallet redeemed with 70 EGP', 'تم خصم 70 جنيه من المحفظة', 5, NULL, 1, '2022-03-28 17:13:47', '2022-03-29 12:11:00', NULL, NULL, NULL),
(7521, NULL, 'New Order', NULL, 'You have received a new order 48', NULL, NULL, NULL, 1, '2022-03-29 11:36:57', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7523, 1000004, 'Order Status Change', 'تغيير حالة الطلب', 'Order #47 Status is now Delivered', 'تم تغيير حالة الطلب #47 الي تم التوصيل', 5, 47, 0, '2022-03-29 12:11:30', '2022-03-29 12:11:30', NULL, NULL, NULL),
(7524, NULL, 'New Order', NULL, 'You have received a new order 49', NULL, NULL, NULL, 1, '2022-03-29 12:11:57', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7525, 1000004, 'Order Created', 'تم الطلب', 'Your order #49 is now Placed', 'حاله طلبك رقم #49 هي تم الطلب', 5, 49, 0, '2022-03-29 12:11:57', '2022-03-29 12:11:57', NULL, NULL, NULL),
(7526, 1000004, 'Mansour Group', 'مجموعة منصور', '70 EGP has been added to your wallet', 'تم إضافة 70 جنيه الى محفظتك', 5, NULL, 0, '2022-03-29 12:12:30', '2022-03-29 12:12:30', NULL, NULL, NULL),
(7527, 1000004, 'Order Status Change', 'تغيير حالة الطلب', 'Order #49 Status is now Delivered', 'تم تغيير حالة الطلب #49 الي تم التوصيل', 5, 49, 0, '2022-03-29 12:12:30', '2022-03-29 12:12:30', NULL, NULL, NULL),
(7528, NULL, 'New Order', NULL, 'You have received a new order 50', NULL, NULL, NULL, 1, '2022-03-29 12:13:18', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7529, 1000004, 'Order Created', 'تم الطلب', 'Your order #50 is now Placed', 'حاله طلبك رقم #50 هي تم الطلب', 5, 50, 0, '2022-03-29 12:13:18', '2022-03-29 12:13:18', NULL, NULL, NULL),
(7530, 1000004, 'Wallet Redeem', 'خصم المحفظة', 'Wallet redeemed with 70 EGP', 'تم خصم 70 جنيه من المحفظة', 5, NULL, 0, '2022-03-29 12:13:19', '2022-03-29 12:13:19', NULL, NULL, NULL),
(7531, 1000004, 'Order Status Change', 'تغيير حالة الطلب', 'Order #50 Status is now Delivered', 'تم تغيير حالة الطلب #50 الي تم التوصيل', 5, 50, 0, '2022-03-29 12:44:35', '2022-03-29 12:44:35', NULL, NULL, NULL),
(7532, NULL, 'New Order', NULL, 'You have received a new order 51', NULL, NULL, NULL, 1, '2022-03-29 12:46:06', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7533, 1000004, 'Order Created', 'تم الطلب', 'Your order #51 is now Placed', 'حاله طلبك رقم #51 هي تم الطلب', 5, 51, 0, '2022-03-29 12:46:06', '2022-03-29 12:46:06', NULL, NULL, NULL),
(7534, NULL, 'Order Cancelled', NULL, 'Customer 1000004 Has just cancelled order 51', NULL, NULL, NULL, 1, '2022-03-29 12:46:46', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7535, NULL, 'New Order', NULL, 'You have received a new order 52', NULL, NULL, NULL, 1, '2022-03-29 12:46:56', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7536, 1000004, 'Order Created', 'تم الطلب', 'Your order #52 is now Placed', 'حاله طلبك رقم #52 هي تم الطلب', 5, 52, 0, '2022-03-29 12:46:56', '2022-03-29 12:46:56', NULL, NULL, NULL),
(7537, 1000004, 'Mansour Group', 'مجموعة منصور', '70 EGP has been added to your wallet', 'تم إضافة 70 جنيه الى محفظتك', 5, NULL, 0, '2022-03-29 12:47:20', '2022-03-29 12:47:20', NULL, NULL, NULL),
(7538, 1000004, 'Order Status Change', 'تغيير حالة الطلب', 'Order #52 Status is now Delivered', 'تم تغيير حالة الطلب #52 الي تم التوصيل', 5, 52, 0, '2022-03-29 12:47:20', '2022-03-29 12:47:20', NULL, NULL, NULL),
(7539, NULL, 'New Order', NULL, 'You have received a new order 53', NULL, NULL, NULL, 1, '2022-03-29 12:47:49', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7540, 1000004, 'Order Created', 'تم الطلب', 'Your order #53 is now Placed', 'حاله طلبك رقم #53 هي تم الطلب', 5, 53, 0, '2022-03-29 12:47:49', '2022-03-29 12:47:49', NULL, NULL, NULL),
(7541, 1000004, 'Wallet Redeem', 'خصم المحفظة', 'Wallet redeemed with 70 EGP', 'تم خصم 70 جنيه من المحفظة', 5, NULL, 0, '2022-03-29 12:47:49', '2022-03-29 12:47:49', NULL, NULL, NULL),
(7542, 1000004, 'Order Status Change', 'تغيير حالة الطلب', 'Order #53 Status is now Delivered', 'تم تغيير حالة الطلب #53 الي تم التوصيل', 5, 53, 1, '2022-03-29 13:02:16', '2022-03-29 16:42:42', NULL, NULL, NULL),
(7543, NULL, 'New Order', NULL, 'You have received a new order 54', NULL, NULL, NULL, 1, '2022-03-29 13:02:37', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7544, 1000004, 'Order Created', 'تم الطلب', 'Your order #54 is now Placed', 'حاله طلبك رقم #54 هي تم الطلب', 5, 54, 1, '2022-03-29 13:02:37', '2022-03-29 16:42:42', NULL, NULL, NULL),
(7545, 1000004, 'Mansour Group', 'مجموعة منصور', '70 EGP has been added to your wallet', 'تم إضافة 70 جنيه الى محفظتك', 5, NULL, 1, '2022-03-29 13:02:56', '2022-03-29 16:43:19', NULL, NULL, NULL),
(7546, 1000004, 'Order Status Change', 'تغيير حالة الطلب', 'Order #54 Status is now Delivered', 'تم تغيير حالة الطلب #54 الي تم التوصيل', 5, 54, 1, '2022-03-29 13:02:57', '2022-03-29 16:43:19', NULL, NULL, NULL),
(7547, NULL, 'New Order', NULL, 'You have received a new order 55', NULL, NULL, NULL, 1, '2022-03-29 13:03:40', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7548, 1000004, 'Order Created', 'تم الطلب', 'Your order #55 is now Placed', 'حاله طلبك رقم #55 هي تم الطلب', 5, 55, 1, '2022-03-29 13:03:40', '2022-03-31 11:33:08', NULL, NULL, NULL),
(7549, 1000004, 'Wallet Redeem', 'خصم المحفظة', 'Wallet redeemed with 70 EGP', 'تم خصم 70 جنيه من المحفظة', 5, NULL, 1, '2022-03-29 13:03:40', '2022-03-31 11:33:08', NULL, NULL, NULL),
(7550, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #27 Status is now Delivered', 'تم تغيير حالة الطلب #27 الي تم التوصيل', 5, 27, 1, '2022-03-29 14:17:47', '2022-04-04 11:26:51', NULL, NULL, NULL),
(7551, NULL, 'New Order', NULL, 'You have received a new order 56', NULL, NULL, NULL, 1, '2022-03-29 14:18:09', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7552, 1000003, 'Order Created', 'تم الطلب', 'Your order #56 is now Placed', 'حاله طلبك رقم #56 هي تم الطلب', 5, 56, 1, '2022-03-29 14:18:09', '2022-04-04 11:26:51', NULL, NULL, NULL),
(7553, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #56 Status is now Cancelled', 'تم تغيير حالة الطلب #56 الي تم الالغاء', 5, 56, 1, '2022-03-29 14:32:46', '2022-04-04 11:26:51', NULL, NULL, NULL),
(7554, NULL, 'New Order', NULL, 'You have received a new order 57', NULL, NULL, NULL, 1, '2022-03-29 14:32:58', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7555, 1000003, 'Order Created', 'تم الطلب', 'Your order #57 is now Placed', 'حاله طلبك رقم #57 هي تم الطلب', 5, 57, 1, '2022-03-29 14:32:59', '2022-04-04 11:26:51', NULL, NULL, NULL),
(7556, 1000004, 'Order Status Change', 'تغيير حالة الطلب', 'Order #55 Status is now Delivered', 'تم تغيير حالة الطلب #55 الي تم التوصيل', 5, 55, 1, '2022-03-29 16:41:18', '2022-03-31 11:33:08', NULL, NULL, NULL),
(7557, NULL, 'New Order', NULL, 'You have received a new order 58', NULL, NULL, NULL, 1, '2022-03-29 16:41:23', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7558, 1000004, 'Order Created', 'تم الطلب', 'Your order #58 is now Placed', 'حاله طلبك رقم #58 هي تم الطلب', 5, 58, 1, '2022-03-29 16:41:23', '2022-03-31 11:33:08', NULL, NULL, NULL),
(7559, 1000004, 'Mansour Group', 'مجموعة منصور', '70 EGP has been added to your wallet', 'تم إضافة 70 جنيه الى محفظتك', 5, NULL, 1, '2022-03-29 16:41:49', '2022-03-31 11:33:08', NULL, NULL, NULL),
(7560, 1000004, 'Order Status Change', 'تغيير حالة الطلب', 'Order #58 Status is now Delivered', 'تم تغيير حالة الطلب #58 الي تم التوصيل', 5, 58, 1, '2022-03-29 16:41:49', '2022-03-31 11:33:08', NULL, NULL, NULL),
(7561, NULL, 'New Order', NULL, 'You have received a new order 59', NULL, NULL, NULL, 1, '2022-03-29 16:42:55', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7562, 1000004, 'Order Created', 'تم الطلب', 'Your order #59 is now Placed', 'حاله طلبك رقم #59 هي تم الطلب', 5, 59, 1, '2022-03-29 16:42:55', '2022-03-31 11:33:08', NULL, NULL, NULL),
(7563, 1000004, 'Wallet Redeem', 'خصم المحفظة', 'Wallet redeemed with 140 EGP', 'تم خصم 140 جنيه من المحفظة', 5, NULL, 1, '2022-03-29 16:42:55', '2022-03-31 11:33:08', NULL, NULL, NULL),
(7564, 1000004, 'Order Status Change', 'تغيير حالة الطلب', 'Order #59 Status is now Delivered', 'تم تغيير حالة الطلب #59 الي تم التوصيل', 5, 59, 1, '2022-03-29 16:52:22', '2022-03-31 11:33:08', NULL, NULL, NULL),
(7565, NULL, 'New Order', NULL, 'You have received a new order 60', NULL, NULL, NULL, 1, '2022-03-29 16:52:43', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7566, 1000004, 'Order Created', 'تم الطلب', 'Your order #60 is now Placed', 'حاله طلبك رقم #60 هي تم الطلب', 5, 60, 1, '2022-03-29 16:52:43', '2022-03-31 11:33:08', NULL, NULL, NULL),
(7567, NULL, 'Order Cancelled', NULL, 'Customer 1000004 Has just cancelled order 60', NULL, NULL, NULL, 1, '2022-03-29 17:03:01', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7570, NULL, 'New Order', NULL, 'You have received a new order 61', NULL, NULL, NULL, 1, '2022-03-30 10:55:16', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7573, NULL, 'New Order', NULL, 'You have received a new order 62', NULL, NULL, NULL, 1, '2022-03-30 14:34:47', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7579, NULL, 'New Order', NULL, 'You have received a new order 63', NULL, NULL, NULL, 1, '2022-03-30 21:20:57', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7584, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #57 Status is now Cancelled', 'تم تغيير حالة الطلب #57 الي تم الالغاء', 5, 57, 1, '2022-03-31 10:34:24', '2022-04-04 11:26:51', NULL, NULL, NULL),
(7585, NULL, 'New Order', NULL, 'You have received a new order 64', NULL, NULL, NULL, 1, '2022-03-31 12:29:40', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7586, 1000004, 'Order Created', 'تم الطلب', 'Your order #64 is now Placed', 'حاله طلبك رقم #64 هي تم الطلب', 5, 64, 0, '2022-03-31 12:29:40', '2022-03-31 12:29:40', NULL, NULL, NULL);
INSERT INTO `notifications` (`id`, `user_id`, `title`, `title_ar`, `body`, `body_ar`, `type`, `item_id`, `read`, `created_at`, `updated_at`, `image`, `details`, `item_link`) VALUES
(7587, 1000004, 'Order Status Change', 'تغيير حالة الطلب', 'Order #64 Status is now Confirmed', 'تم تغيير حالة الطلب #64 الي تم تأكيد الطلب', 5, 64, 0, '2022-03-31 12:39:36', '2022-03-31 12:39:36', NULL, NULL, NULL),
(7588, 1000004, 'Order Status Change', 'تغيير حالة الطلب', 'Order #64 Status is now Confirmed', 'تم تغيير حالة الطلب #64 الي تم تأكيد الطلب', 5, 64, 0, '2022-03-31 12:39:51', '2022-03-31 12:39:51', NULL, NULL, NULL),
(7589, NULL, 'New Order', NULL, 'You have received a new order 65', NULL, NULL, NULL, 1, '2022-04-03 11:33:37', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7592, NULL, 'New Order', NULL, 'You have received a new order 66', NULL, NULL, NULL, 1, '2022-04-03 11:39:26', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7596, NULL, 'New Order', NULL, 'You have received a new order 67', NULL, NULL, NULL, 1, '2022-04-03 11:55:44', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7601, NULL, 'New Order', NULL, 'You have received a new order 68', NULL, NULL, NULL, 1, '2022-04-03 12:00:07', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7605, NULL, 'New Order', NULL, 'You have received a new order 69', NULL, NULL, NULL, 1, '2022-04-03 12:04:13', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7609, NULL, 'New Order', NULL, 'You have received a new order 70', NULL, NULL, NULL, 1, '2022-04-03 12:21:14', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7611, 1000004, 'Order Status Change', 'تغيير حالة الطلب', 'Order #64 Status is now Delivered', 'تم تغيير حالة الطلب #64 الي تم التوصيل', 5, 64, 0, '2022-04-04 10:19:01', '2022-04-04 10:19:01', NULL, NULL, NULL),
(7612, NULL, 'New Order', NULL, 'You have received a new order 71', NULL, NULL, NULL, 1, '2022-04-04 10:35:44', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7613, 1000004, 'Order Created', 'تم الطلب', 'Your order #71 is now Placed', 'حاله طلبك رقم #71 هي تم الطلب', 5, 71, 0, '2022-04-04 10:35:44', '2022-04-04 10:35:44', NULL, NULL, NULL),
(7614, NULL, 'Order Cancelled', NULL, 'Customer 1000004 Has just cancelled order 71', NULL, NULL, NULL, 1, '2022-04-04 10:45:12', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7615, NULL, 'New Order', NULL, 'You have received a new order 72', NULL, NULL, NULL, 1, '2022-04-04 10:45:27', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7616, 1000004, 'Order Created', 'تم الطلب', 'Your order #72 is now Placed', 'حاله طلبك رقم #72 هي تم الطلب', 5, 72, 0, '2022-04-04 10:45:27', '2022-04-04 10:45:27', NULL, NULL, NULL),
(7617, 1000004, 'Order Status Change', 'تغيير حالة الطلب', 'Order #72 Status is now Confirmed', 'تم تغيير حالة الطلب #72 الي تم تأكيد الطلب', 5, 72, 0, '2022-04-04 10:45:58', '2022-04-04 10:45:58', NULL, NULL, NULL),
(7618, 1000004, 'Order Status Change', 'تغيير حالة الطلب', 'Order #72 Status is now Delivered', 'تم تغيير حالة الطلب #72 الي تم التوصيل', 5, 72, 0, '2022-04-04 11:20:30', '2022-04-04 11:20:30', NULL, NULL, NULL),
(7619, NULL, 'New Order', NULL, 'You have received a new order 73', NULL, NULL, NULL, 1, '2022-04-04 11:20:39', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7620, 1000004, 'Order Created', 'تم الطلب', 'Your order #73 is now Placed', 'حاله طلبك رقم #73 هي تم الطلب', 5, 73, 0, '2022-04-04 11:20:39', '2022-04-04 11:20:39', NULL, NULL, NULL),
(7621, 1000004, 'Order Status Change', 'تغيير حالة الطلب', 'Order #73 Status is now Confirmed', 'تم تغيير حالة الطلب #73 الي تم تأكيد الطلب', 5, 73, 1, '2022-04-04 11:21:11', '2022-04-10 15:44:23', NULL, NULL, NULL),
(7622, NULL, 'New Order', NULL, 'You have received a new order 74', NULL, NULL, NULL, 1, '2022-04-04 11:25:09', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7623, 1000003, 'Order Created', 'تم الطلب', 'Your order #74 is now Placed', 'حاله طلبك رقم #74 هي تم الطلب', 5, 74, 1, '2022-04-04 11:25:09', '2022-04-12 13:51:48', NULL, NULL, NULL),
(7624, 1000003, 'Mansour Group', 'مجموعة منصور', '470 EGP has been added to your wallet', 'تم إضافة 470 جنيه الى محفظتك', 5, NULL, 1, '2022-04-04 11:30:03', '2022-04-12 16:38:39', NULL, NULL, NULL),
(7625, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #74 Status is now Delivered', 'تم تغيير حالة الطلب #74 الي تم التوصيل', 5, 74, 1, '2022-04-04 11:30:03', '2022-04-12 16:38:39', NULL, NULL, NULL),
(7626, NULL, 'New Order', NULL, 'You have received a new order 75', NULL, NULL, NULL, 1, '2022-04-04 11:30:12', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7627, 1000003, 'Order Created', 'تم الطلب', 'Your order #75 is now Placed', 'حاله طلبك رقم #75 هي تم الطلب', 5, 75, 1, '2022-04-04 11:30:12', '2022-04-12 16:38:39', NULL, NULL, NULL),
(7628, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #75 Status is now Confirmed', 'تم تغيير حالة الطلب #75 الي تم تأكيد الطلب', 5, 75, 1, '2022-04-04 11:31:39', '2022-04-12 16:38:39', NULL, NULL, NULL),
(7629, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #75 Status is now shipping', 'تم تغيير حالة الطلب #75 الي تم الشحن', 5, 75, 1, '2022-04-04 11:35:40', '2022-04-12 16:38:39', NULL, NULL, NULL),
(7630, 1000003, 'Mansour Group', 'مجموعة منصور', '470 EGP has been added to your wallet', 'تم إضافة 470 جنيه الى محفظتك', 5, NULL, 1, '2022-04-04 11:37:17', '2022-04-12 16:38:39', NULL, NULL, NULL),
(7631, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #75 Status is now Delivered', 'تم تغيير حالة الطلب #75 الي تم التوصيل', 5, 75, 1, '2022-04-04 11:37:17', '2022-04-12 16:38:39', NULL, NULL, NULL),
(7632, 1000004, 'Order Status Change', 'تغيير حالة الطلب', 'Order #73 Status is now Delivered', 'تم تغيير حالة الطلب #73 الي تم التوصيل', 5, 73, 1, '2022-04-04 11:41:02', '2022-04-10 15:44:23', NULL, NULL, NULL),
(7633, NULL, 'New Order', NULL, 'You have received a new order 76', NULL, NULL, NULL, 1, '2022-04-04 11:41:11', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7634, 1000004, 'Order Created', 'تم الطلب', 'Your order #76 is now Placed', 'حاله طلبك رقم #76 هي تم الطلب', 5, 76, 1, '2022-04-04 11:41:11', '2022-04-10 15:49:10', NULL, NULL, NULL),
(7635, NULL, 'New Order', NULL, 'You have received a new order 77', NULL, NULL, NULL, 1, '2022-04-04 12:17:50', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7636, 1000003, 'Order Created', 'تم الطلب', 'Your order #77 is now Placed', 'حاله طلبك رقم #77 هي تم الطلب', 5, 77, 1, '2022-04-04 12:17:50', '2022-04-12 16:38:39', NULL, NULL, NULL),
(7637, 1000004, 'Order Status Change', 'تغيير حالة الطلب', 'Order #76 Status is now Delivery Failed', 'تم تغيير حالة الطلب #76 الي فشل التسليم', 5, 76, 1, '2022-04-05 10:17:18', '2022-04-10 15:49:49', NULL, NULL, NULL),
(7638, 1000003, 'Mansour Group', 'مجموعة منصور', '470 EGP has been added to your wallet', 'تم إضافة 470 جنيه الى محفظتك', 5, NULL, 1, '2022-04-05 11:15:30', '2022-04-12 16:38:39', NULL, NULL, NULL),
(7639, NULL, 'New Order', NULL, 'You have received a new order 78', NULL, NULL, NULL, 1, '2022-04-05 11:58:54', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7643, NULL, 'New Order', NULL, 'You have received a new order 79', NULL, NULL, NULL, 1, '2022-04-05 12:14:42', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7649, NULL, 'New Order', NULL, 'You have received a new order 80', NULL, NULL, NULL, 1, '2022-04-05 12:47:11', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7651, NULL, 'New Order', NULL, 'You have received a new order 81', NULL, NULL, NULL, 1, '2022-04-05 13:05:18', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7653, NULL, 'New Order', NULL, 'You have received a new order 82', NULL, NULL, NULL, 1, '2022-04-05 13:12:19', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7655, NULL, 'New Order', NULL, 'You have received a new order 83', NULL, NULL, NULL, 1, '2022-04-05 13:14:14', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7657, 1000004, 'Mansour Group', 'مجموعة منصور', '470 EGP has been added to your wallet', 'تم إضافة 470 جنيه الى محفظتك', 5, NULL, 1, '2022-04-09 13:40:13', '2022-04-10 15:49:49', NULL, NULL, NULL),
(7658, NULL, 'New Order', NULL, 'You have received a new order 84', NULL, NULL, NULL, 1, '2022-04-09 13:41:36', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7659, 1000004, 'Order Created', 'تم الطلب', 'Your order #84 is now Placed', 'حاله طلبك رقم #84 هي تم الطلب', 5, 84, 1, '2022-04-09 13:41:37', '2022-04-10 15:49:49', NULL, NULL, NULL),
(7660, NULL, 'Order Cancelled', NULL, 'Customer 1000004 Has just cancelled order 84', NULL, NULL, NULL, 1, '2022-04-10 00:57:52', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7661, NULL, 'New Order', NULL, 'You have received a new order 85', NULL, NULL, NULL, 1, '2022-04-10 11:03:00', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7662, 1000004, 'Order Created', 'تم الطلب', 'Your order #85 is now Placed', 'حاله طلبك رقم #85 هي تم الطلب', 5, 85, 1, '2022-04-10 11:03:00', '2022-04-10 15:49:49', NULL, NULL, NULL),
(7663, NULL, 'New Order', NULL, 'You have received a new order 86', NULL, NULL, NULL, 1, '2022-04-10 12:18:13', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7664, 1000004, 'Order Created', 'تم الطلب', 'Your order #86 is now Placed', 'حاله طلبك رقم #86 هي تم الطلب', 5, 86, 1, '2022-04-10 12:18:13', '2022-04-10 15:49:49', NULL, NULL, NULL),
(7665, NULL, 'Order Cancelled', NULL, 'Customer 1000004 Has just cancelled order 86', NULL, NULL, NULL, 1, '2022-04-10 12:24:48', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7666, NULL, 'Order Rating', NULL, 'Order ID 86 is rated 1', NULL, NULL, NULL, 1, '2022-04-10 12:26:57', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7667, NULL, 'New Order', NULL, 'You have received a new order 87', NULL, NULL, NULL, 1, '2022-04-10 12:32:24', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7668, 1000004, 'Order Created', 'تم الطلب', 'Your order #87 is now Placed', 'حاله طلبك رقم #87 هي تم الطلب', 5, 87, 1, '2022-04-10 12:32:24', '2022-04-10 15:49:49', NULL, NULL, NULL),
(7669, NULL, 'New Order', NULL, 'You have received a new order 88', NULL, NULL, NULL, 1, '2022-04-10 13:00:13', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7670, 1000004, 'Order Created', 'تم الطلب', 'Your order #88 is now Placed', 'حاله طلبك رقم #88 هي تم الطلب', 5, 88, 1, '2022-04-10 13:00:13', '2022-04-10 15:49:49', NULL, NULL, NULL),
(7671, NULL, 'New Order', NULL, 'You have received a new order 89', NULL, NULL, NULL, 1, '2022-04-10 15:48:49', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7672, 1000004, 'Order Created', 'تم الطلب', 'Your order #89 is now Placed', 'حاله طلبك رقم #89 هي تم الطلب', 5, 89, 1, '2022-04-10 15:48:49', '2022-04-10 15:49:49', NULL, NULL, NULL),
(7673, 1000004, 'Wallet Redeem', 'خصم المحفظة', 'Wallet redeemed with 470 EGP', 'تم خصم 470 جنيه من المحفظة', 5, NULL, 1, '2022-04-10 15:48:49', '2022-04-10 15:49:49', NULL, NULL, NULL),
(7674, 1000004, 'Mansour Group', 'مجموعة منصور', '100 EGP has been added to your wallet', 'تم إضافة 100 جنيه الى محفظتك', 5, NULL, 1, '2022-04-10 15:49:39', '2022-04-10 15:49:49', NULL, NULL, NULL),
(7675, NULL, 'New Order', NULL, 'You have received a new order 90', NULL, NULL, NULL, 1, '2022-04-11 10:37:18', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7676, 1000004, 'Order Created', 'تم الطلب', 'Your order #90 is now Placed', 'حاله طلبك رقم #90 هي تم الطلب', 5, 90, 0, '2022-04-11 10:37:18', '2022-04-11 10:37:18', NULL, NULL, NULL),
(7677, NULL, 'Order Cancelled', NULL, 'Customer 1000004 Has just cancelled order 90', NULL, NULL, NULL, 1, '2022-04-11 11:53:04', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7678, NULL, 'New Order', NULL, 'You have received a new order 91', NULL, NULL, NULL, 1, '2022-04-11 11:53:22', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7679, 1000004, 'Order Created', 'تم الطلب', 'Your order #91 is now Placed', 'حاله طلبك رقم #91 هي تم الطلب', 5, 91, 0, '2022-04-11 11:53:23', '2022-04-11 11:53:23', NULL, NULL, NULL),
(7680, NULL, 'Order Cancelled', NULL, 'Customer 1000004 Has just cancelled order 91', NULL, NULL, NULL, 1, '2022-04-11 11:54:45', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7681, 1, 'File Exported ', NULL, 'Your export has completed! You can download the file from', NULL, 11, 0, 1, '2022-04-11 14:52:06', '2022-09-13 14:00:51', NULL, 'https://10.51.0.5/storage/exports/categories/Categories__by_Super Admin_2022_04_11 14_52_05.xlsx', NULL),
(7682, NULL, 'New Order', NULL, 'You have received a new order 92', NULL, NULL, NULL, 1, '2022-04-12 16:37:18', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7683, 1000003, 'Order Created', 'تم الطلب', 'Your order #92 is now Placed', 'حاله طلبك رقم #92 هي تم الطلب', 5, 92, 1, '2022-04-12 16:37:18', '2022-04-12 16:38:39', NULL, NULL, NULL),
(7684, NULL, 'Order Cancelled', NULL, 'Customer 1000003 Has just cancelled order 92', NULL, NULL, NULL, 1, '2022-04-12 16:37:53', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7685, NULL, 'New Order', NULL, 'You have received a new order 93', NULL, NULL, NULL, 1, '2022-04-12 22:47:38', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7688, NULL, 'New Order', NULL, 'You have received a new order 94', NULL, NULL, NULL, 1, '2022-04-12 23:01:05', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7691, NULL, 'New Order', NULL, 'You have received a new order 95', NULL, NULL, NULL, 1, '2022-04-12 23:13:54', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7693, NULL, 'New Order', NULL, 'You have received a new order 96', NULL, NULL, NULL, 1, '2022-04-13 11:44:59', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7695, NULL, 'New Order', NULL, 'You have received a new order 97', NULL, NULL, NULL, 1, '2022-04-13 11:59:11', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7698, NULL, 'New Order', NULL, 'You have received a new order 98', NULL, NULL, NULL, 1, '2022-04-13 12:05:55', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7702, NULL, 'New Order', NULL, 'You have received a new order 99', NULL, NULL, NULL, 1, '2022-04-13 12:10:06', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7705, NULL, 'New Order', NULL, 'You have received a new order 100', NULL, NULL, NULL, 1, '2022-04-14 10:47:25', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7706, 1000004, 'Order Created', 'تم الطلب', 'Your order #100 is now Placed', 'حاله طلبك رقم #100 هي تم الطلب', 5, 100, 1, '2022-04-14 10:47:26', '2022-05-17 13:00:39', NULL, NULL, NULL),
(7707, 1000004, 'Mansour Group', 'مجموعة منصور', '30 EGP has been added to your wallet', 'تم إضافة 30 جنيه الى محفظتك', 5, NULL, 1, '2022-04-14 12:16:32', '2022-05-17 13:00:39', NULL, NULL, NULL),
(7708, 1000004, 'Order Status Change', 'تغيير حالة الطلب', 'Order #100 Status is now Delivered', 'تم تغيير حالة الطلب #100 الي تم التوصيل', 5, 100, 1, '2022-04-14 12:16:32', '2022-05-17 13:00:39', NULL, NULL, NULL),
(7709, NULL, 'New Order', NULL, 'You have received a new order 101', NULL, NULL, NULL, 1, '2022-04-14 12:33:39', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7710, 1000004, 'Order Created', 'تم الطلب', 'Your order #101 is now Placed', 'حاله طلبك رقم #101 هي تم الطلب', 5, 101, 1, '2022-04-14 12:33:39', '2022-05-17 13:00:39', NULL, NULL, NULL),
(7711, 1000004, 'Mansour Group', 'مجموعة منصور', '180 EGP has been added to your wallet', 'تم إضافة 180 جنيه الى محفظتك', 5, NULL, 1, '2022-04-14 12:34:08', '2022-05-17 13:00:39', NULL, NULL, NULL),
(7712, 1000004, 'Order Status Change', 'تغيير حالة الطلب', 'Order #101 Status is now Delivered', 'تم تغيير حالة الطلب #101 الي تم التوصيل', 5, 101, 1, '2022-04-14 12:34:08', '2022-05-17 13:00:39', NULL, NULL, NULL),
(7713, NULL, 'New Order', NULL, 'You have received a new order 102', NULL, NULL, NULL, 1, '2022-04-14 12:36:41', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7714, 1000004, 'Order Created', 'تم الطلب', 'Your order #102 is now Placed', 'حاله طلبك رقم #102 هي تم الطلب', 5, 102, 1, '2022-04-14 12:36:41', '2022-05-17 13:00:39', NULL, NULL, NULL),
(7715, 1000004, 'Order Status Change', 'تغيير حالة الطلب', 'Order #102 Status is now Delivered', 'تم تغيير حالة الطلب #102 الي تم التوصيل', 5, 102, 1, '2022-04-14 12:37:12', '2022-05-17 13:00:39', NULL, NULL, NULL),
(7716, NULL, 'New Order', NULL, 'You have received a new order 103', NULL, NULL, NULL, 1, '2022-04-17 10:27:54', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7717, 1000004, 'Order Created', 'تم الطلب', 'Your order #103 is now Placed', 'حاله طلبك رقم #103 هي تم الطلب', 5, 103, 1, '2022-04-17 10:27:55', '2022-05-17 13:00:39', NULL, NULL, NULL),
(7718, 1000004, 'Order Status Change', 'تغيير حالة الطلب', 'Order #103 Status is now Delivered', 'تم تغيير حالة الطلب #103 الي تم التوصيل', 5, 103, 1, '2022-04-17 10:28:40', '2022-05-17 13:00:39', NULL, NULL, NULL),
(7719, NULL, 'New Order', NULL, 'You have received a new order 104', NULL, NULL, NULL, 1, '2022-04-19 14:10:35', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7720, 1000003, 'Order Created', 'تم الطلب', 'Your order #104 is now Placed', 'حاله طلبك رقم #104 هي تم الطلب', 5, 104, 0, '2022-04-19 14:10:36', '2022-04-19 14:10:36', NULL, NULL, NULL),
(7721, 1, 'File Exported ', NULL, 'Your export has completed! You can download the file from', NULL, 11, 0, 1, '2022-05-16 15:31:19', '2022-09-13 14:00:51', NULL, 'https://10.51.0.5/storage/exports/orders/Order_by_Super Admin_2022_05_16 15_31_17.xlsx', NULL),
(7722, 1, 'File Exported ', NULL, 'Your export has completed! You can download the file from', NULL, 11, 0, 1, '2022-05-16 15:31:30', '2022-09-13 14:00:51', NULL, 'https://10.51.0.5/storage/exports/orders/Order_by_Super Admin_2022_05_16 15_31_29.xlsx', NULL),
(7723, NULL, 'Order Cancelled', NULL, 'Customer 1000003 Has just cancelled order 104', NULL, NULL, NULL, 1, '2022-05-16 21:53:40', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7724, NULL, 'New Order', NULL, 'You have received a new order 105', NULL, NULL, NULL, 1, '2022-05-17 13:23:52', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7725, 1000003, 'Order Created', 'تم الطلب', 'Your order #105 is now Placed', 'حاله طلبك رقم #105 هي تم الطلب', 5, 105, 1, '2022-05-17 13:23:52', '2022-06-05 09:58:30', NULL, NULL, NULL),
(7726, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #105 Status is now Confirmed', 'تم تغيير حالة الطلب #105 الي تم تأكيد الطلب', 5, 105, 1, '2022-05-17 13:45:33', '2022-06-05 09:58:30', NULL, NULL, NULL),
(7727, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #105 Status is now shipping', 'تم تغيير حالة الطلب #105 الي تم الشحن', 5, 105, 1, '2022-05-17 13:46:01', '2022-06-05 09:58:30', NULL, NULL, NULL),
(7728, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #105 Status is now Delivered', 'تم تغيير حالة الطلب #105 الي تم التوصيل', 5, 105, 1, '2022-05-17 13:46:32', '2022-06-05 09:58:30', NULL, NULL, NULL),
(7729, NULL, 'New Order', NULL, 'You have received a new order 106', NULL, NULL, NULL, 1, '2022-05-22 15:17:08', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7730, 1000003, 'Order Created', 'تم الطلب', 'Your order #106 is now Placed', 'حاله طلبك رقم #106 هي تم الطلب', 5, 106, 1, '2022-05-22 15:17:09', '2022-06-05 09:58:30', NULL, NULL, NULL),
(7731, NULL, 'New Order', NULL, 'You have received a new order 107', NULL, NULL, NULL, 1, '2022-05-24 13:47:18', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7732, 1000004, 'Order Created', 'تم الطلب', 'Your order #107 is now Placed', 'حاله طلبك رقم #107 هي تم الطلب', 5, 107, 0, '2022-05-24 13:47:18', '2022-05-24 13:47:18', NULL, NULL, NULL),
(7733, 1000004, 'Wallet Redeem', 'خصم المحفظة', 'Wallet redeemed with 310 EGP', 'تم خصم 310 جنيه من المحفظة', 5, NULL, 0, '2022-05-24 13:47:18', '2022-05-24 13:47:18', NULL, NULL, NULL),
(7734, 1000004, 'Order Status Change', 'تغيير حالة الطلب', 'Order #107 Status is now Confirmed', 'تم تغيير حالة الطلب #107 الي تم تأكيد الطلب', 5, 107, 0, '2022-05-24 15:20:55', '2022-05-24 15:20:55', NULL, NULL, NULL),
(7735, 1000004, 'Mansour Group', 'مجموعة منصور', '60 EGP has been added to your wallet', 'تم إضافة 60 جنيه الى محفظتك', 5, NULL, 0, '2022-05-24 15:21:37', '2022-05-24 15:21:37', NULL, NULL, NULL),
(7736, 1000004, 'Order Status Change', 'تغيير حالة الطلب', 'Order #107 Status is now Delivered', 'تم تغيير حالة الطلب #107 الي تم التوصيل', 5, 107, 0, '2022-05-24 15:21:37', '2022-05-24 15:21:37', NULL, NULL, NULL),
(7737, NULL, 'New Order', NULL, 'You have received a new order 108', NULL, NULL, NULL, 1, '2022-06-03 16:52:50', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7739, NULL, 'Order Cancelled', NULL, 'Customer 1000006 Has just cancelled order 108', NULL, NULL, NULL, 1, '2022-06-03 16:57:25', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7740, NULL, 'New Order', NULL, 'You have received a new order 109', NULL, NULL, NULL, 1, '2022-06-03 16:57:40', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7742, NULL, 'Order Cancelled', NULL, 'Customer 1000006 Has just cancelled order 109', NULL, NULL, NULL, 1, '2022-06-03 17:01:08', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7743, NULL, 'New Order', NULL, 'You have received a new order 110', NULL, NULL, NULL, 1, '2022-06-03 17:01:20', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7745, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #106 Status is now Confirmed', 'تم تغيير حالة الطلب #106 الي تم تأكيد الطلب', 5, 106, 1, '2022-06-05 09:55:40', '2022-06-05 09:58:30', NULL, NULL, NULL),
(7747, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #106 Status is now Delivered', 'تم تغيير حالة الطلب #106 الي تم التوصيل', 5, 106, 1, '2022-06-05 09:56:29', '2022-06-05 09:58:30', NULL, NULL, NULL),
(7748, NULL, 'New Order', NULL, 'You have received a new order 111', NULL, NULL, NULL, 1, '2022-06-05 09:56:44', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7749, 1000003, 'Order Created', 'تم الطلب', 'Your order #111 is now Placed', 'حاله طلبك رقم #111 هي تم الطلب', 5, 111, 1, '2022-06-05 09:56:44', '2022-06-05 09:58:30', NULL, NULL, NULL),
(7750, 1000003, 'Mansour Group', 'مجموعة منصور', '60 EGP has been added to your wallet', 'تم إضافة 60 جنيه الى محفظتك', 5, NULL, 1, '2022-06-05 09:57:10', '2022-06-05 09:58:30', NULL, NULL, NULL),
(7751, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #111 Status is now Delivered', 'تم تغيير حالة الطلب #111 الي تم التوصيل', 5, 111, 1, '2022-06-05 09:57:10', '2022-06-05 09:58:30', NULL, NULL, NULL),
(7754, NULL, 'New Order', NULL, 'You have received a new order 112', NULL, NULL, NULL, 1, '2022-06-05 15:56:43', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7758, NULL, 'New Order', NULL, 'You have received a new order 113', NULL, NULL, NULL, 1, '2022-06-05 16:04:40', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7763, NULL, 'New Order', NULL, 'You have received a new order 114', NULL, NULL, NULL, 1, '2022-06-05 16:07:03', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7766, 1, 'File Exported ', NULL, 'Your export has completed! You can download the file from', NULL, 11, 0, 1, '2022-06-07 16:20:00', '2022-09-13 14:00:51', NULL, 'https://10.51.0.5/storage/exports/orders/Order_by_Super Admin_2022_06_07 16_19_58.xlsx', NULL),
(7767, 1, 'File Exported ', NULL, 'Your export has completed! You can download the file from', NULL, 11, 0, 1, '2022-06-07 16:20:05', '2022-09-13 14:00:51', NULL, 'https://10.51.0.5/storage/exports/orders/Order_by_Super Admin_2022_06_07 16_20_04.xlsx', NULL),
(7768, NULL, 'New Order', NULL, 'You have received a new order 115', NULL, NULL, NULL, 1, '2022-06-09 13:23:48', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7769, 1000003, 'Order Created', 'تم الطلب', 'Your order #115 is now Placed', 'حاله طلبك رقم #115 هي تم الطلب', 5, 115, 0, '2022-06-09 13:23:49', '2022-06-09 13:23:49', NULL, NULL, NULL),
(7770, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #115 Status is now Confirmed', 'تم تغيير حالة الطلب #115 الي تم تأكيد الطلب', 5, 115, 0, '2022-06-09 13:27:21', '2022-06-09 13:27:21', NULL, NULL, NULL),
(7771, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #115 Status is now shipping', 'تم تغيير حالة الطلب #115 الي تم الشحن', 5, 115, 0, '2022-06-09 13:28:19', '2022-06-09 13:28:19', NULL, NULL, NULL),
(7772, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #115 Status is now Prepared', 'تم تغيير حالة الطلب #115 الي جاهزة للتسليم', 5, 115, 0, '2022-06-09 13:29:09', '2022-06-09 13:29:09', NULL, NULL, NULL),
(7773, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #115 Status is now Confirmed', 'تم تغيير حالة الطلب #115 الي تم تأكيد الطلب', 5, 115, 0, '2022-06-09 13:32:40', '2022-06-09 13:32:40', NULL, NULL, NULL),
(7774, 1000003, 'Mansour Group', 'مجموعة منصور', '1500 EGP has been added to your wallet', 'تم إضافة 1500 جنيه الى محفظتك', 5, NULL, 0, '2022-06-09 13:33:13', '2022-06-09 13:33:13', NULL, NULL, NULL),
(7775, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #115 Status is now Delivered', 'تم تغيير حالة الطلب #115 الي تم التوصيل', 5, 115, 0, '2022-06-09 13:33:13', '2022-06-09 13:33:13', NULL, NULL, NULL),
(7776, NULL, 'New Order', NULL, 'You have received a new order 116', NULL, NULL, NULL, 1, '2022-06-09 13:36:07', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7777, 1000003, 'Order Created', 'تم الطلب', 'Your order #116 is now Placed', 'حاله طلبك رقم #116 هي تم الطلب', 5, 116, 0, '2022-06-09 13:36:07', '2022-06-09 13:36:07', NULL, NULL, NULL),
(7778, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #116 Status is now Cancelled', 'تم تغيير حالة الطلب #116 الي تم الالغاء', 5, 116, 0, '2022-06-09 13:37:36', '2022-06-09 13:37:36', NULL, NULL, NULL),
(7779, NULL, 'New Order', NULL, 'You have received a new order 117', NULL, NULL, NULL, 1, '2022-06-09 13:38:06', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7780, 1000003, 'Order Created', 'تم الطلب', 'Your order #117 is now Placed', 'حاله طلبك رقم #117 هي تم الطلب', 5, 117, 0, '2022-06-09 13:38:06', '2022-06-09 13:38:06', NULL, NULL, NULL),
(7781, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #117 Status is now Confirmed', 'تم تغيير حالة الطلب #117 الي تم تأكيد الطلب', 5, 117, 0, '2022-06-09 13:43:27', '2022-06-09 13:43:27', NULL, NULL, NULL),
(7782, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #117 Status is now Prepared', 'تم تغيير حالة الطلب #117 الي جاهزة للتسليم', 5, 117, 0, '2022-06-09 13:44:52', '2022-06-09 13:44:52', NULL, NULL, NULL),
(7783, 1000003, 'Mansour Group', 'مجموعة منصور', '30 EGP has been added to your wallet', 'تم إضافة 30 جنيه الى محفظتك', 5, NULL, 0, '2022-06-09 13:45:13', '2022-06-09 13:45:13', NULL, NULL, NULL),
(7784, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #117 Status is now Delivered', 'تم تغيير حالة الطلب #117 الي تم التوصيل', 5, 117, 0, '2022-06-09 13:45:13', '2022-06-09 13:45:13', NULL, NULL, NULL),
(7785, NULL, 'New Order', NULL, 'You have received a new order 118', NULL, NULL, NULL, 1, '2022-06-09 13:45:45', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7786, 1000003, 'Order Created', 'تم الطلب', 'Your order #118 is now Placed', 'حاله طلبك رقم #118 هي تم الطلب', 5, 118, 0, '2022-06-09 13:45:45', '2022-06-09 13:45:45', NULL, NULL, NULL),
(7787, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #118 Status is now Delivered', 'تم تغيير حالة الطلب #118 الي تم التوصيل', 5, 118, 0, '2022-06-12 09:30:19', '2022-06-12 09:30:19', NULL, NULL, NULL),
(7788, NULL, 'New Order', NULL, 'You have received a new order 119', NULL, NULL, NULL, 1, '2022-06-12 09:30:23', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7789, 1000003, 'Order Created', 'تم الطلب', 'Your order #119 is now Placed', 'حاله طلبك رقم #119 هي تم الطلب', 5, 119, 0, '2022-06-12 09:30:24', '2022-06-12 09:30:24', NULL, NULL, NULL),
(7790, 1000003, 'Mansour Group', 'مجموعة منصور', '30 EGP has been added to your wallet', 'تم إضافة 30 جنيه الى محفظتك', 5, NULL, 0, '2022-06-12 09:30:51', '2022-06-12 09:30:51', NULL, NULL, NULL),
(7791, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #119 Status is now Delivered', 'تم تغيير حالة الطلب #119 الي تم التوصيل', 5, 119, 0, '2022-06-12 09:30:51', '2022-06-12 09:30:51', NULL, NULL, NULL),
(7792, NULL, 'New Order', NULL, 'You have received a new order 120', NULL, NULL, NULL, 1, '2022-06-12 12:33:14', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7793, 1000003, 'Order Created', 'تم الطلب', 'Your order #120 is now Placed', 'حاله طلبك رقم #120 هي تم الطلب', 5, 120, 0, '2022-06-12 12:33:14', '2022-06-12 12:33:14', NULL, NULL, NULL),
(7794, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #120 Status is now Confirmed', 'تم تغيير حالة الطلب #120 الي تم تأكيد الطلب', 5, 120, 0, '2022-06-12 12:37:30', '2022-06-12 12:37:30', NULL, NULL, NULL),
(7795, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #120 Status is now Prepared', 'تم تغيير حالة الطلب #120 الي جاهزة للتسليم', 5, 120, 0, '2022-06-12 12:38:00', '2022-06-12 12:38:00', NULL, NULL, NULL),
(7796, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #120 Status is now Cancelled', 'تم تغيير حالة الطلب #120 الي تم الالغاء', 5, 120, 0, '2022-06-12 12:40:03', '2022-06-12 12:40:03', NULL, NULL, NULL),
(7797, NULL, 'New Order', NULL, 'You have received a new order 121', NULL, NULL, NULL, 1, '2022-06-12 14:00:50', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7798, 1000003, 'Order Created', 'تم الطلب', 'Your order #121 is now Placed', 'حاله طلبك رقم #121 هي تم الطلب', 5, 121, 0, '2022-06-12 14:00:50', '2022-06-12 14:00:50', NULL, NULL, NULL),
(7799, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #121 Status is now Delivered', 'تم تغيير حالة الطلب #121 الي تم التوصيل', 5, 121, 0, '2022-06-12 14:01:20', '2022-06-12 14:01:20', NULL, NULL, NULL),
(7800, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #121 Status is now Returned', 'تم تغيير حالة الطلب #121 الي تم الاسترجاع', 5, 121, 0, '2022-06-12 14:03:39', '2022-06-12 14:03:39', NULL, NULL, NULL),
(7801, NULL, 'New Order', NULL, 'You have received a new order 122', NULL, NULL, NULL, 1, '2022-06-12 14:04:52', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7802, 1000003, 'Order Created', 'تم الطلب', 'Your order #122 is now Placed', 'حاله طلبك رقم #122 هي تم الطلب', 5, 122, 1, '2022-06-12 14:04:52', '2022-06-13 14:05:26', NULL, NULL, NULL),
(7803, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #122 Status is now Delivered', 'تم تغيير حالة الطلب #122 الي تم التوصيل', 5, 122, 1, '2022-06-12 14:05:15', '2022-06-13 14:05:26', NULL, NULL, NULL),
(7804, NULL, 'New Order', NULL, 'You have received a new order 123', NULL, NULL, NULL, 1, '2022-06-12 14:26:53', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7805, 1000003, 'Order Created', 'تم الطلب', 'Your order #123 is now Placed', 'حاله طلبك رقم #123 هي تم الطلب', 5, 123, 1, '2022-06-12 14:26:53', '2022-06-13 14:05:26', NULL, NULL, NULL),
(7806, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #123 Status is now Delivered', 'تم تغيير حالة الطلب #123 الي تم التوصيل', 5, 123, 1, '2022-06-12 14:27:12', '2022-06-13 14:05:26', NULL, NULL, NULL),
(7807, NULL, 'New Order', NULL, 'You have received a new order 124', NULL, NULL, NULL, 1, '2022-06-12 15:13:20', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7808, 1000003, 'Order Created', 'تم الطلب', 'Your order #124 is now Placed', 'حاله طلبك رقم #124 هي تم الطلب', 5, 124, 1, '2022-06-12 15:13:20', '2022-06-13 14:05:26', NULL, NULL, NULL),
(7809, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #124 Status is now Confirmed', 'تم تغيير حالة الطلب #124 الي تم تأكيد الطلب', 5, 124, 1, '2022-06-12 15:13:50', '2022-06-13 14:05:26', NULL, NULL, NULL),
(7810, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #124 Status is now Delivered', 'تم تغيير حالة الطلب #124 الي تم التوصيل', 5, 124, 1, '2022-06-12 16:23:18', '2022-06-13 14:05:26', NULL, NULL, NULL),
(7811, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #124 Status is now Returned', 'تم تغيير حالة الطلب #124 الي تم الاسترجاع', 5, 124, 1, '2022-06-12 16:23:26', '2022-06-13 14:05:26', NULL, NULL, NULL),
(7812, NULL, 'New Order', NULL, 'You have received a new order 125', NULL, NULL, NULL, 1, '2022-06-12 16:36:37', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7813, 1000003, 'Order Created', 'تم الطلب', 'Your order #125 is now Placed', 'حاله طلبك رقم #125 هي تم الطلب', 5, 125, 1, '2022-06-12 16:36:37', '2022-06-13 14:05:26', NULL, NULL, NULL),
(7814, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #125 Status is now Delivered', 'تم تغيير حالة الطلب #125 الي تم التوصيل', 5, 125, 1, '2022-06-12 16:37:02', '2022-06-13 14:05:26', NULL, NULL, NULL),
(7815, NULL, 'New Order', NULL, 'You have received a new order 126', NULL, NULL, NULL, 1, '2022-06-13 14:20:03', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7816, 1000003, 'Order Created', 'تم الطلب', 'Your order #126 is now Placed', 'حاله طلبك رقم #126 هي تم الطلب', 5, 126, 0, '2022-06-13 14:20:03', '2022-06-13 14:20:03', NULL, NULL, NULL),
(7817, 1, 'File Exported ', NULL, 'Your export has completed! You can download the file from', NULL, 11, 0, 1, '2022-06-13 14:25:27', '2022-09-13 14:00:51', NULL, 'https://10.51.0.5/storage/exports/orders/Order_by_Super Admin_2022_06_13 14_25_25.xlsx', NULL),
(7818, NULL, 'Order Cancelled', NULL, 'Customer 1000003 Has just cancelled order 126', NULL, NULL, NULL, 1, '2022-06-13 14:31:50', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7819, NULL, 'New Order', NULL, 'You have received a new order 127', NULL, NULL, NULL, 1, '2022-06-13 14:37:39', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7820, 1000003, 'Order Created', 'تم الطلب', 'Your order #127 is now Placed', 'حاله طلبك رقم #127 هي تم الطلب', 5, 127, 0, '2022-06-13 14:37:39', '2022-06-13 14:37:39', NULL, NULL, NULL),
(7821, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #127 Status is now Confirmed', 'تم تغيير حالة الطلب #127 الي تم تأكيد الطلب', 5, 127, 0, '2022-06-13 15:04:42', '2022-06-13 15:04:42', NULL, NULL, NULL),
(7822, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #127 Status is now Delivered', 'تم تغيير حالة الطلب #127 الي تم التوصيل', 5, 127, 0, '2022-06-13 15:07:24', '2022-06-13 15:07:24', NULL, NULL, NULL),
(7823, NULL, 'New Order', NULL, 'You have received a new order 128', NULL, NULL, NULL, 1, '2022-06-13 15:31:34', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7824, 1000003, 'Order Created', 'تم الطلب', 'Your order #128 is now Placed', 'حاله طلبك رقم #128 هي تم الطلب', 5, 128, 0, '2022-06-13 15:31:35', '2022-06-13 15:31:35', NULL, NULL, NULL),
(7825, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #128 Status is now Delivered', 'تم تغيير حالة الطلب #128 الي تم التوصيل', 5, 128, 0, '2022-06-13 15:32:01', '2022-06-13 15:32:01', NULL, NULL, NULL),
(7826, 1, 'File Exported ', NULL, 'Your export has completed! You can download the file from', NULL, 11, 0, 1, '2022-06-13 16:13:36', '2022-09-13 14:00:51', NULL, 'https://10.51.0.5/storage/exports/orders/Order_by_Super Admin_2022_06_13 16_13_35.xlsx', NULL),
(7827, 1, 'File Exported ', NULL, 'Your export has completed! You can download the file from', NULL, 11, 0, 1, '2022-06-13 16:13:37', '2022-09-13 14:00:51', NULL, 'https://10.51.0.5/storage/exports/orders/Order_by_Super Admin_2022_06_13 16_13_36.xlsx', NULL),
(7828, NULL, 'New Order', NULL, 'You have received a new order 129', NULL, NULL, NULL, 1, '2022-06-14 09:27:04', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7829, 1000003, 'Order Created', 'تم الطلب', 'Your order #129 is now Placed', 'حاله طلبك رقم #129 هي تم الطلب', 5, 129, 0, '2022-06-14 09:27:05', '2022-06-14 09:27:05', NULL, NULL, NULL),
(7830, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #129 Status is now Delivered', 'تم تغيير حالة الطلب #129 الي تم التوصيل', 5, 129, 0, '2022-06-14 09:27:23', '2022-06-14 09:27:23', NULL, NULL, NULL),
(7831, NULL, 'New Order', NULL, 'You have received a new order 130', NULL, NULL, NULL, 1, '2022-06-14 09:28:14', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7832, 1000003, 'Order Created', 'تم الطلب', 'Your order #130 is now Placed', 'حاله طلبك رقم #130 هي تم الطلب', 5, 130, 0, '2022-06-14 09:28:14', '2022-06-14 09:28:14', NULL, NULL, NULL),
(7833, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #130 Status is now Delivered', 'تم تغيير حالة الطلب #130 الي تم التوصيل', 5, 130, 0, '2022-06-14 09:29:34', '2022-06-14 09:29:34', NULL, NULL, NULL),
(7834, NULL, 'New Order', NULL, 'You have received a new order 131', NULL, NULL, NULL, 1, '2022-06-14 09:38:45', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7835, 1000003, 'Order Created', 'تم الطلب', 'Your order #131 is now Placed', 'حاله طلبك رقم #131 هي تم الطلب', 5, 131, 0, '2022-06-14 09:38:45', '2022-06-14 09:38:45', NULL, NULL, NULL),
(7836, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #131 Status is now Delivered', 'تم تغيير حالة الطلب #131 الي تم التوصيل', 5, 131, 0, '2022-06-14 09:40:08', '2022-06-14 09:40:08', NULL, NULL, NULL),
(7837, 1, 'File Exported ', NULL, 'Your export has completed! You can download the file from', NULL, 11, 0, 1, '2022-06-14 13:01:22', '2022-09-13 14:00:51', NULL, 'https://10.51.0.5/storage/exports/products/productFullExport_20220614130121.xlsx', NULL),
(7838, 1, 'File Exported ', NULL, 'Your export has completed! You can download the file from', NULL, 11, 0, 1, '2022-06-14 13:02:01', '2022-09-13 14:00:51', NULL, 'https://10.51.0.5/storage/exports/products/products_stocks__by_Super Admin_2022_06_14 13_02_01.xlsx', NULL),
(7839, 1, 'File Exported ', NULL, 'Your export has completed! You can download the file from', NULL, 11, 0, 1, '2022-06-14 13:04:08', '2022-09-13 14:00:51', NULL, 'https://10.51.0.5/storage/exports/products/products_stocks__by_Super Admin_2022_06_14 13_04_08.xlsx', NULL),
(7840, 1, 'File Exported ', NULL, 'Your export has completed! You can download the file from', NULL, 11, 0, 1, '2022-06-14 13:04:11', '2022-09-13 14:00:51', NULL, 'https://10.51.0.5/storage/exports/products/productFullExport_20220614130411.xlsx', NULL),
(7841, NULL, 'New Order', NULL, 'You have received a new order 1', NULL, NULL, NULL, 1, '2022-06-14 16:49:11', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7842, 1000003, 'Order Created', 'تم الطلب', 'Your order #1 is now Placed', 'حاله طلبك رقم #1 هي تم الطلب', 5, 1, 1, '2022-06-14 16:49:12', '2022-06-19 14:13:32', NULL, NULL, NULL),
(7843, NULL, 'Order Cancelled', NULL, 'Customer 1000003 Has just cancelled order 1', NULL, NULL, NULL, 1, '2022-06-14 16:55:27', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7844, NULL, 'New Order', NULL, 'You have received a new order 2', NULL, NULL, NULL, 1, '2022-06-14 16:56:50', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7845, 1000003, 'Order Created', 'تم الطلب', 'Your order #2 is now Placed', 'حاله طلبك رقم #2 هي تم الطلب', 5, 2, 1, '2022-06-14 16:56:50', '2022-06-19 14:13:32', NULL, NULL, NULL),
(7846, NULL, 'Order Cancelled', NULL, 'Customer 1000003 Has just cancelled order 2', NULL, NULL, NULL, 1, '2022-06-19 11:18:43', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7847, NULL, 'New Order', NULL, 'You have received a new order 3', NULL, NULL, NULL, 1, '2022-06-19 11:20:46', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7848, 1000003, 'Order Created', 'تم الطلب', 'Your order #3 is now Placed', 'حاله طلبك رقم #3 هي تم الطلب', 5, 3, 1, '2022-06-19 11:20:47', '2022-06-19 14:13:32', NULL, NULL, NULL),
(7849, NULL, 'Order Cancelled', NULL, 'Customer 1000003 Has just cancelled order 3', NULL, NULL, NULL, 1, '2022-06-19 11:21:18', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7850, NULL, 'New Order', NULL, 'You have received a new order 4', NULL, NULL, NULL, 1, '2022-06-19 11:21:49', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7851, 1000003, 'Order Created', 'تم الطلب', 'Your order #4 is now Placed', 'حاله طلبك رقم #4 هي تم الطلب', 5, 4, 1, '2022-06-19 11:21:49', '2022-06-19 14:13:32', NULL, NULL, NULL),
(7852, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #4 Status is now Cancelled', 'تم تغيير حالة الطلب #4 الي تم الالغاء', 5, 4, 1, '2022-06-19 11:22:17', '2022-06-19 14:13:32', NULL, NULL, NULL),
(7853, NULL, 'New Order', NULL, 'You have received a new order 5', NULL, NULL, NULL, 1, '2022-06-19 11:22:58', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7854, 1000003, 'Order Created', 'تم الطلب', 'Your order #5 is now Placed', 'حاله طلبك رقم #5 هي تم الطلب', 5, 5, 1, '2022-06-19 11:22:58', '2022-06-19 14:13:32', NULL, NULL, NULL),
(7855, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #5 Status is now Delivered', 'تم تغيير حالة الطلب #5 الي تم التوصيل', 5, 5, 1, '2022-06-19 11:23:30', '2022-06-19 14:13:32', NULL, NULL, NULL),
(7856, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #5 Status is now Returned', 'تم تغيير حالة الطلب #5 الي تم الاسترجاع', 5, 5, 1, '2022-06-19 11:23:40', '2022-06-19 14:13:32', NULL, NULL, NULL),
(7857, 1, 'File Exported ', NULL, 'Your export has completed! You can download the file from', NULL, 11, 0, 1, '2022-06-19 11:29:22', '2022-09-13 14:00:51', NULL, 'https://10.51.0.5/storage/exports/orders/Order_by_Super Admin_2022_06_19 11_29_20.xlsx', NULL),
(7858, NULL, 'New Order', NULL, 'You have received a new order 6', NULL, NULL, NULL, 1, '2022-06-19 11:34:58', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7859, 1000003, 'Order Created', 'تم الطلب', 'Your order #6 is now Placed', 'حاله طلبك رقم #6 هي تم الطلب', 5, 6, 1, '2022-06-19 11:34:59', '2022-06-19 14:13:32', NULL, NULL, NULL),
(7860, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #6 Status is now Cancelled', 'تم تغيير حالة الطلب #6 الي تم الالغاء', 5, 6, 1, '2022-06-19 11:35:20', '2022-06-19 14:13:32', NULL, NULL, NULL),
(7861, 1, 'File Exported ', NULL, 'Your export has completed! You can download the file from', NULL, 11, 0, 1, '2022-06-19 14:12:03', '2022-09-13 14:00:51', NULL, 'https://10.51.0.5/storage/exports/products/products_stocks__by_Super Admin_2022_06_19 14_12_01.xlsx', NULL),
(7862, NULL, 'New Order', NULL, 'You have received a new order 7', NULL, NULL, NULL, 1, '2022-06-19 16:21:26', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7863, 1000003, 'Order Created', 'تم الطلب', 'Your order #7 is now Placed', 'حاله طلبك رقم #7 هي تم الطلب', 5, 7, 0, '2022-06-19 16:21:26', '2022-06-19 16:21:26', NULL, NULL, NULL),
(7864, NULL, 'Order Cancelled', NULL, 'Customer 1000003 Has just cancelled order 7', NULL, NULL, NULL, 1, '2022-06-19 16:29:23', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7865, NULL, 'New Order', NULL, 'You have received a new order 8', NULL, NULL, NULL, 1, '2022-06-19 16:30:03', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7866, 1000003, 'Order Created', 'تم الطلب', 'Your order #8 is now Placed', 'حاله طلبك رقم #8 هي تم الطلب', 5, 8, 0, '2022-06-19 16:30:03', '2022-06-19 16:30:03', NULL, NULL, NULL),
(7867, NULL, 'Order Cancelled', NULL, 'Customer 1000003 Has just cancelled order 8', NULL, NULL, NULL, 1, '2022-06-19 16:31:19', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7868, NULL, 'New Order', NULL, 'You have received a new order 9', NULL, NULL, NULL, 1, '2022-06-19 16:32:36', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7869, 1000003, 'Order Created', 'تم الطلب', 'Your order #9 is now Placed', 'حاله طلبك رقم #9 هي تم الطلب', 5, 9, 0, '2022-06-19 16:32:36', '2022-06-19 16:32:36', NULL, NULL, NULL),
(7870, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #9 Status is now Delivered', 'تم تغيير حالة الطلب #9 الي تم التوصيل', 5, 9, 0, '2022-06-20 11:41:32', '2022-06-20 11:41:32', NULL, NULL, NULL),
(7871, NULL, 'New Order', NULL, 'You have received a new order 10', NULL, NULL, NULL, 1, '2022-06-20 13:21:32', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7872, 1000003, 'Order Created', 'تم الطلب', 'Your order #10 is now Placed', 'حاله طلبك رقم #10 هي تم الطلب', 5, 10, 0, '2022-06-20 13:21:32', '2022-06-20 13:21:32', NULL, NULL, NULL),
(7873, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #10 Status is now Delivered', 'تم تغيير حالة الطلب #10 الي تم التوصيل', 5, 10, 0, '2022-06-20 13:21:51', '2022-06-20 13:21:51', NULL, NULL, NULL),
(7874, NULL, 'New Order', NULL, 'You have received a new order 11', NULL, NULL, NULL, 1, '2022-06-20 13:58:12', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7875, 1000003, 'Order Created', 'تم الطلب', 'Your order #11 is now Placed', 'حاله طلبك رقم #11 هي تم الطلب', 5, 11, 0, '2022-06-20 13:58:12', '2022-06-20 13:58:12', NULL, NULL, NULL),
(7876, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #11 Status is now Delivered', 'تم تغيير حالة الطلب #11 الي تم التوصيل', 5, 11, 1, '2022-06-20 13:58:35', '2022-06-22 10:11:24', NULL, NULL, NULL),
(7877, NULL, 'New Order', NULL, 'You have received a new order 1', NULL, NULL, NULL, 1, '2022-06-20 14:11:41', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7878, 1000003, 'Order Created', 'تم الطلب', 'Your order #1 is now Placed', 'حاله طلبك رقم #1 هي تم الطلب', 5, 1, 1, '2022-06-20 14:11:42', '2022-06-22 10:11:24', NULL, NULL, NULL),
(7879, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #1 Status is now Delivered', 'تم تغيير حالة الطلب #1 الي تم التوصيل', 5, 1, 1, '2022-06-20 14:12:31', '2022-06-22 10:11:24', NULL, NULL, NULL),
(7880, NULL, 'New Order', NULL, 'You have received a new order 1', NULL, NULL, NULL, 1, '2022-06-20 15:16:20', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7881, 1000003, 'Order Created', 'تم الطلب', 'Your order #1 is now Placed', 'حاله طلبك رقم #1 هي تم الطلب', 5, 1, 1, '2022-06-20 15:16:20', '2022-06-22 10:11:24', NULL, NULL, NULL),
(7882, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #1 Status is now Cancelled', 'تم تغيير حالة الطلب #1 الي تم الالغاء', 5, 1, 1, '2022-06-20 16:05:44', '2022-06-22 10:11:24', NULL, NULL, NULL),
(7883, NULL, 'New Order', NULL, 'You have received a new order 2', NULL, NULL, NULL, 1, '2022-06-20 16:06:37', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7884, 1000003, 'Order Created', 'تم الطلب', 'Your order #2 is now Placed', 'حاله طلبك رقم #2 هي تم الطلب', 5, 2, 1, '2022-06-20 16:06:37', '2022-06-22 10:11:24', NULL, NULL, NULL),
(7885, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #2 Status is now Delivered', 'تم تغيير حالة الطلب #2 الي تم التوصيل', 5, 2, 1, '2022-06-20 16:13:15', '2022-06-22 10:11:24', NULL, NULL, NULL),
(7886, NULL, 'New Order', NULL, 'You have received a new order 3', NULL, NULL, NULL, 1, '2022-06-20 16:13:53', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7887, 1000003, 'Order Created', 'تم الطلب', 'Your order #3 is now Placed', 'حاله طلبك رقم #3 هي تم الطلب', 5, 3, 1, '2022-06-20 16:13:53', '2022-06-22 10:11:24', NULL, NULL, NULL),
(7888, NULL, 'Order Cancelled', NULL, 'Customer 1000003 Has just cancelled order 3', NULL, NULL, NULL, 1, '2022-06-20 16:14:28', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7889, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #3 Status is now Delivered', 'تم تغيير حالة الطلب #3 الي تم التوصيل', 5, 3, 1, '2022-06-20 16:14:35', '2022-06-22 10:11:24', NULL, NULL, NULL),
(7890, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #3 Status is now Returned', 'تم تغيير حالة الطلب #3 الي تم الاسترجاع', 5, 3, 1, '2022-06-20 16:15:57', '2022-06-22 10:11:24', NULL, NULL, NULL),
(7891, NULL, 'New Order', NULL, 'You have received a new order 4', NULL, NULL, NULL, 1, '2022-06-22 10:28:53', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7892, 1000003, 'Order Created', 'تم الطلب', 'Your order #4 is now Placed', 'حاله طلبك رقم #4 هي تم الطلب', 5, 4, 1, '2022-06-22 10:28:53', '2022-06-23 15:13:54', NULL, NULL, NULL),
(7893, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #4 Status is now Delivered', 'تم تغيير حالة الطلب #4 الي تم التوصيل', 5, 4, 1, '2022-06-22 10:49:16', '2022-06-23 15:13:54', NULL, NULL, NULL),
(7894, NULL, 'New Order', NULL, 'You have received a new order 5', NULL, NULL, NULL, 1, '2022-06-22 11:19:02', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7895, 1000003, 'Order Created', 'تم الطلب', 'Your order #5 is now Placed', 'حاله طلبك رقم #5 هي تم الطلب', 5, 5, 1, '2022-06-22 11:19:02', '2022-06-23 15:13:54', NULL, NULL, NULL),
(7896, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #5 Status is now Delivered', 'تم تغيير حالة الطلب #5 الي تم التوصيل', 5, 5, 1, '2022-06-22 11:19:26', '2022-06-23 15:13:54', NULL, NULL, NULL),
(7897, NULL, 'New Order', NULL, 'You have received a new order 6', NULL, NULL, NULL, 1, '2022-06-22 11:24:49', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7898, 1000003, 'Order Created', 'تم الطلب', 'Your order #6 is now Placed', 'حاله طلبك رقم #6 هي تم الطلب', 5, 6, 1, '2022-06-22 11:24:49', '2022-06-23 15:13:54', NULL, NULL, NULL),
(7899, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #6 Status is now Confirmed', 'تم تغيير حالة الطلب #6 الي تم تأكيد الطلب', 5, 6, 1, '2022-06-22 11:25:06', '2022-06-23 15:13:54', NULL, NULL, NULL),
(7900, NULL, 'New Order', NULL, 'You have received a new order 7', NULL, NULL, NULL, 1, '2022-06-22 15:36:38', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7901, 1000004, 'Order Created', 'تم الطلب', 'Your order #7 is now Placed', 'حاله طلبك رقم #7 هي تم الطلب', 5, 7, 0, '2022-06-22 15:36:39', '2022-06-22 15:36:39', NULL, NULL, NULL),
(7902, 1000004, 'Order Status Change', 'تغيير حالة الطلب', 'Order #7 Status is now Delivered', 'تم تغيير حالة الطلب #7 الي تم التوصيل', 5, 7, 0, '2022-06-22 16:22:06', '2022-06-22 16:22:06', NULL, NULL, NULL),
(7903, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #6 Status is now Delivered', 'تم تغيير حالة الطلب #6 الي تم التوصيل', 5, 6, 1, '2022-06-22 16:25:07', '2022-06-23 15:13:54', NULL, NULL, NULL),
(7904, NULL, 'New Order', NULL, 'You have received a new order 8', NULL, NULL, NULL, 1, '2022-06-22 16:25:13', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7905, 1000003, 'Order Created', 'تم الطلب', 'Your order #8 is now Placed', 'حاله طلبك رقم #8 هي تم الطلب', 5, 8, 1, '2022-06-22 16:25:13', '2022-06-23 15:13:54', NULL, NULL, NULL),
(7906, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #8 Status is now Confirmed', 'تم تغيير حالة الطلب #8 الي تم تأكيد الطلب', 5, 8, 1, '2022-06-22 16:25:48', '2022-06-23 15:13:54', NULL, NULL, NULL),
(7907, NULL, 'New Order', NULL, 'You have received a new order 9', NULL, NULL, NULL, 1, '2022-06-22 16:47:17', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7908, 1000004, 'Order Created', 'تم الطلب', 'Your order #9 is now Placed', 'حاله طلبك رقم #9 هي تم الطلب', 5, 9, 0, '2022-06-22 16:47:17', '2022-06-22 16:47:17', NULL, NULL, NULL),
(7909, NULL, 'Order Cancelled', NULL, 'Customer 1000003 Has just cancelled order 8', NULL, NULL, NULL, 1, '2022-06-22 16:51:18', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7910, 999999, 'test notification1', NULL, 'test notification1', NULL, 1, NULL, 1, '2022-06-23 15:06:45', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7911, 1000002, 'test notification1', NULL, 'test notification1', NULL, 1, NULL, 1, '2022-06-23 15:06:45', '2022-07-24 04:32:28', NULL, NULL, NULL),
(7912, 1000003, 'test notification1', NULL, 'test notification1', NULL, 1, NULL, 1, '2022-06-23 15:06:45', '2022-06-23 15:13:54', NULL, NULL, NULL);
INSERT INTO `notifications` (`id`, `user_id`, `title`, `title_ar`, `body`, `body_ar`, `type`, `item_id`, `read`, `created_at`, `updated_at`, `image`, `details`, `item_link`) VALUES
(7913, 1000004, 'test notification1', NULL, 'test notification1', NULL, 1, NULL, 0, '2022-06-23 15:06:45', '2022-06-23 15:06:45', NULL, NULL, NULL),
(7918, 1000061, 'test notification1', NULL, 'test notification1', NULL, 1, NULL, 0, '2022-06-23 15:06:45', '2022-06-23 15:06:45', NULL, NULL, NULL),
(7925, 1000208, 'test notification1', NULL, 'test notification1', NULL, 1, NULL, 0, '2022-06-23 15:06:45', '2022-06-23 15:06:45', NULL, NULL, NULL),
(7928, 1000212, 'test notification1', NULL, 'test notification1', NULL, 1, NULL, 0, '2022-06-23 15:06:45', '2022-06-23 15:06:45', NULL, NULL, NULL),
(7944, NULL, 'New Order', NULL, 'You have received a new order 10', NULL, NULL, NULL, 1, '2022-06-26 09:05:58', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7945, 1000003, 'Order Created', 'تم الطلب', 'Your order #10 is now Placed', 'حاله طلبك رقم #10 هي تم الطلب', 5, 10, 0, '2022-06-26 09:05:59', '2022-06-26 09:05:59', NULL, NULL, NULL),
(7946, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #10 Status is now Confirmed', 'تم تغيير حالة الطلب #10 الي تم تأكيد الطلب', 5, 10, 0, '2022-06-26 09:06:54', '2022-06-26 09:06:54', NULL, NULL, NULL),
(7947, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #10 Status is now shipping', 'تم تغيير حالة الطلب #10 الي تم الشحن', 5, 10, 0, '2022-06-26 09:07:28', '2022-06-26 09:07:28', NULL, NULL, NULL),
(7948, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #10 Status is now Delivered', 'تم تغيير حالة الطلب #10 الي تم التوصيل', 5, 10, 0, '2022-06-26 09:07:41', '2022-06-26 09:07:41', NULL, NULL, NULL),
(7949, 999999, 'test', NULL, 'new DVD Offer', NULL, 2, 167, 1, '2022-06-26 11:21:50', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7950, 1000002, 'test', NULL, 'new DVD Offer', NULL, 2, 167, 1, '2022-06-26 11:21:50', '2022-07-24 04:32:28', NULL, NULL, NULL),
(7951, 1000003, 'test', NULL, 'new DVD Offer', NULL, 2, 167, 0, '2022-06-26 11:21:50', '2022-06-26 11:21:50', NULL, NULL, NULL),
(7952, 1000004, 'test', NULL, 'new DVD Offer', NULL, 2, 167, 0, '2022-06-26 11:21:50', '2022-06-26 11:21:50', NULL, NULL, NULL),
(7957, 1000061, 'test', NULL, 'new DVD Offer', NULL, 2, 167, 0, '2022-06-26 11:21:50', '2022-06-26 11:21:50', NULL, NULL, NULL),
(7964, 1000208, 'test', NULL, 'new DVD Offer', NULL, 2, 167, 0, '2022-06-26 11:21:50', '2022-06-26 11:21:50', NULL, NULL, NULL),
(7967, 1000212, 'test', NULL, 'new DVD Offer', NULL, 2, 167, 0, '2022-06-26 11:21:50', '2022-06-26 11:21:50', NULL, NULL, NULL),
(7983, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #8 Status is now Cancelled', 'تم تغيير حالة الطلب #8 الي تم الالغاء', 5, 8, 0, '2022-06-26 11:43:08', '2022-06-26 11:43:08', NULL, NULL, NULL),
(7984, NULL, 'New Order', NULL, 'You have received a new order 11', NULL, NULL, NULL, 1, '2022-06-26 13:41:57', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7985, 1000003, 'Order Created', 'تم الطلب', 'Your order #11 is now Placed', 'حاله طلبك رقم #11 هي تم الطلب', 5, 11, 0, '2022-06-26 13:41:57', '2022-06-26 13:41:57', NULL, NULL, NULL),
(7986, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #11 Status is now Cancelled', 'تم تغيير حالة الطلب #11 الي تم الالغاء', 5, 11, 0, '2022-06-26 13:43:00', '2022-06-26 13:43:00', NULL, NULL, NULL),
(7987, NULL, 'New Order', NULL, 'You have received a new order 12', NULL, NULL, NULL, 1, '2022-06-26 13:44:46', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7988, 1000003, 'Order Created', 'تم الطلب', 'Your order #12 is now Placed', 'حاله طلبك رقم #12 هي تم الطلب', 5, 12, 0, '2022-06-26 13:44:46', '2022-06-26 13:44:46', NULL, NULL, NULL),
(7989, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #12 Status is now Confirmed', 'تم تغيير حالة الطلب #12 الي تم تأكيد الطلب', 5, 12, 0, '2022-06-26 13:45:43', '2022-06-26 13:45:43', NULL, NULL, NULL),
(7990, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #12 Status is now Cancelled', 'تم تغيير حالة الطلب #12 الي تم الالغاء', 5, 12, 0, '2022-06-26 14:39:13', '2022-06-26 14:39:13', NULL, NULL, NULL),
(7991, NULL, 'New Order', NULL, 'You have received a new order 13', NULL, NULL, NULL, 1, '2022-06-26 15:03:59', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7992, 1000003, 'Order Created', 'تم الطلب', 'Your order #13 is now Placed', 'حاله طلبك رقم #13 هي تم الطلب', 5, 13, 0, '2022-06-26 15:03:59', '2022-06-26 15:03:59', NULL, NULL, NULL),
(7993, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #13 Status is now Confirmed', 'تم تغيير حالة الطلب #13 الي تم تأكيد الطلب', 5, 13, 0, '2022-06-26 15:04:35', '2022-06-26 15:04:35', NULL, NULL, NULL),
(7994, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #13 Status is now Delivered', 'تم تغيير حالة الطلب #13 الي تم التوصيل', 5, 13, 0, '2022-06-26 16:20:37', '2022-06-26 16:20:37', NULL, NULL, NULL),
(7995, NULL, 'New Order', NULL, 'You have received a new order 14', NULL, NULL, NULL, 1, '2022-06-26 16:20:43', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7996, 1000003, 'Order Created', 'تم الطلب', 'Your order #14 is now Placed', 'حاله طلبك رقم #14 هي تم الطلب', 5, 14, 0, '2022-06-26 16:20:43', '2022-06-26 16:20:43', NULL, NULL, NULL),
(7997, NULL, 'Order Cancelled', NULL, 'Customer 1000003 Has just cancelled order 14', NULL, NULL, NULL, 1, '2022-06-26 16:30:48', '2022-10-30 09:21:40', NULL, NULL, NULL),
(7998, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #14 Status is now Cancelled', 'تم تغيير حالة الطلب #14 الي تم الالغاء', 5, 14, 0, '2022-06-26 16:31:08', '2022-06-26 16:31:08', NULL, NULL, NULL),
(7999, NULL, 'New Order', NULL, 'You have received a new order 15', NULL, NULL, NULL, 1, '2022-06-26 16:31:27', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8000, 1000003, 'Order Created', 'تم الطلب', 'Your order #15 is now Placed', 'حاله طلبك رقم #15 هي تم الطلب', 5, 15, 0, '2022-06-26 16:31:27', '2022-06-26 16:31:27', NULL, NULL, NULL),
(8001, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #15 Status is now Confirmed', 'تم تغيير حالة الطلب #15 الي تم تأكيد الطلب', 5, 15, 0, '2022-06-26 16:31:46', '2022-06-26 16:31:46', NULL, NULL, NULL),
(8002, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #15 Status is now Cancelled', 'تم تغيير حالة الطلب #15 الي تم الالغاء', 5, 15, 0, '2022-06-26 16:49:27', '2022-06-26 16:49:27', NULL, NULL, NULL),
(8003, NULL, 'New Order', NULL, 'You have received a new order 16', NULL, NULL, NULL, 1, '2022-06-26 17:10:44', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8004, 1000003, 'Order Created', 'تم الطلب', 'Your order #16 is now Placed', 'حاله طلبك رقم #16 هي تم الطلب', 5, 16, 0, '2022-06-26 17:10:44', '2022-06-26 17:10:44', NULL, NULL, NULL),
(8005, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #16 Status is now Confirmed', 'تم تغيير حالة الطلب #16 الي تم تأكيد الطلب', 5, 16, 0, '2022-06-26 17:11:19', '2022-06-26 17:11:19', NULL, NULL, NULL),
(8006, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #16 Status is now Cancelled', 'تم تغيير حالة الطلب #16 الي تم الالغاء', 5, 16, 0, '2022-06-27 11:12:57', '2022-06-27 11:12:57', NULL, NULL, NULL),
(8007, NULL, 'New Order', NULL, 'You have received a new order 17', NULL, NULL, NULL, 1, '2022-06-27 11:43:23', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8008, 1000003, 'Order Created', 'تم الطلب', 'Your order #17 is now Placed', 'حاله طلبك رقم #17 هي تم الطلب', 5, 17, 0, '2022-06-27 11:43:23', '2022-06-27 11:43:23', NULL, NULL, NULL),
(8009, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #17 Status is now Confirmed', 'تم تغيير حالة الطلب #17 الي تم تأكيد الطلب', 5, 17, 0, '2022-06-27 11:46:19', '2022-06-27 11:46:19', NULL, NULL, NULL),
(8010, NULL, 'Order Cancelled', NULL, 'Customer 1000003 Has just cancelled order 17', NULL, NULL, NULL, 1, '2022-06-27 12:18:36', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8011, NULL, 'Order Cancelled', NULL, 'Customer 1000003 Has just cancelled order 17', NULL, NULL, NULL, 1, '2022-06-27 12:18:37', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8012, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #17 Status is now Cancelled', 'تم تغيير حالة الطلب #17 الي تم الالغاء', 5, 17, 0, '2022-06-27 12:19:26', '2022-06-27 12:19:26', NULL, NULL, NULL),
(8013, NULL, 'New Order', NULL, 'You have received a new order 18', NULL, NULL, NULL, 1, '2022-06-27 13:25:31', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8014, 1000003, 'Order Created', 'تم الطلب', 'Your order #18 is now Placed', 'حاله طلبك رقم #18 هي تم الطلب', 5, 18, 0, '2022-06-27 13:25:31', '2022-06-27 13:25:31', NULL, NULL, NULL),
(8015, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #18 Status is now Confirmed', 'تم تغيير حالة الطلب #18 الي تم تأكيد الطلب', 5, 18, 0, '2022-06-27 13:25:46', '2022-06-27 13:25:46', NULL, NULL, NULL),
(8016, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #18 Status is now Delivered', 'تم تغيير حالة الطلب #18 الي تم التوصيل', 5, 18, 0, '2022-06-28 09:54:43', '2022-06-28 09:54:43', NULL, NULL, NULL),
(8017, NULL, 'New Order', NULL, 'You have received a new order 19', NULL, NULL, NULL, 1, '2022-06-28 09:54:53', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8018, 1000003, 'Order Created', 'تم الطلب', 'Your order #19 is now Placed', 'حاله طلبك رقم #19 هي تم الطلب', 5, 19, 0, '2022-06-28 09:54:54', '2022-06-28 09:54:54', NULL, NULL, NULL),
(8019, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #19 Status is now Delivered', 'تم تغيير حالة الطلب #19 الي تم التوصيل', 5, 19, 0, '2022-06-28 10:19:45', '2022-06-28 10:19:45', NULL, NULL, NULL),
(8020, NULL, 'New Order', NULL, 'You have received a new order 20', NULL, NULL, NULL, 1, '2022-06-28 14:41:55', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8021, 1000003, 'Order Created', 'تم الطلب', 'Your order #20 is now Placed', 'حاله طلبك رقم #20 هي تم الطلب', 5, 20, 0, '2022-06-28 14:41:56', '2022-06-28 14:41:56', NULL, NULL, NULL),
(8022, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #20 Status is now Confirmed', 'تم تغيير حالة الطلب #20 الي تم تأكيد الطلب', 5, 20, 0, '2022-06-28 14:42:09', '2022-06-28 14:42:09', NULL, NULL, NULL),
(8023, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #20 Status is now Cancelled', 'تم تغيير حالة الطلب #20 الي تم الالغاء', 5, 20, 0, '2022-06-28 16:59:18', '2022-06-28 16:59:18', NULL, NULL, NULL),
(8024, NULL, 'New Order', NULL, 'You have received a new order 21', NULL, NULL, NULL, 1, '2022-06-28 17:03:37', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8025, 1000003, 'Order Created', 'تم الطلب', 'Your order #21 is now Placed', 'حاله طلبك رقم #21 هي تم الطلب', 5, 21, 0, '2022-06-28 17:03:37', '2022-06-28 17:03:37', NULL, NULL, NULL),
(8026, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #21 Status is now Confirmed', 'تم تغيير حالة الطلب #21 الي تم تأكيد الطلب', 5, 21, 0, '2022-06-28 17:19:06', '2022-06-28 17:19:06', NULL, NULL, NULL),
(8027, 1000003, 'Mansour Group', 'مجموعة منصور', '70 EGP has been added to your wallet', 'تم إضافة 70 جنيه الى محفظتك', 5, NULL, 0, '2022-06-28 18:06:46', '2022-06-28 18:06:46', NULL, NULL, NULL),
(8028, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #21 Status is now Delivered', 'تم تغيير حالة الطلب #21 الي تم التوصيل', 5, 21, 0, '2022-06-28 18:06:46', '2022-06-28 18:06:46', NULL, NULL, NULL),
(8029, NULL, 'New Order', NULL, 'You have received a new order 22', NULL, NULL, NULL, 1, '2022-06-29 09:59:11', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8030, 1000003, 'Order Created', 'تم الطلب', 'Your order #22 is now Placed', 'حاله طلبك رقم #22 هي تم الطلب', 5, 22, 0, '2022-06-29 09:59:11', '2022-06-29 09:59:11', NULL, NULL, NULL),
(8031, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #22 Status is now Confirmed', 'تم تغيير حالة الطلب #22 الي تم تأكيد الطلب', 5, 22, 0, '2022-06-29 10:02:10', '2022-06-29 10:02:10', NULL, NULL, NULL),
(8032, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #22 Status is now Cancelled', 'تم تغيير حالة الطلب #22 الي تم الالغاء', 5, 22, 0, '2022-06-29 10:24:10', '2022-06-29 10:24:10', NULL, NULL, NULL),
(8033, NULL, 'New Order', NULL, 'You have received a new order 23', NULL, NULL, NULL, 1, '2022-06-29 10:24:16', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8034, 1000003, 'Order Created', 'تم الطلب', 'Your order #23 is now Placed', 'حاله طلبك رقم #23 هي تم الطلب', 5, 23, 0, '2022-06-29 10:24:16', '2022-06-29 10:24:16', NULL, NULL, NULL),
(8035, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #23 Status is now Confirmed', 'تم تغيير حالة الطلب #23 الي تم تأكيد الطلب', 5, 23, 0, '2022-06-29 10:24:34', '2022-06-29 10:24:34', NULL, NULL, NULL),
(8036, NULL, 'Order Cancelled', NULL, 'Customer 1000003 Has just cancelled order 23', NULL, NULL, NULL, 1, '2022-06-29 10:35:10', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8037, NULL, 'New Order', NULL, 'You have received a new order 24', NULL, NULL, NULL, 1, '2022-06-29 10:38:41', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8038, 1000003, 'Order Created', 'تم الطلب', 'Your order #24 is now Placed', 'حاله طلبك رقم #24 هي تم الطلب', 5, 24, 0, '2022-06-29 10:38:41', '2022-06-29 10:38:41', NULL, NULL, NULL),
(8039, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #23 Status is now Cancelled', 'تم تغيير حالة الطلب #23 الي تم الالغاء', 5, 23, 0, '2022-06-29 10:39:04', '2022-06-29 10:39:04', NULL, NULL, NULL),
(8040, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #24 Status is now Confirmed', 'تم تغيير حالة الطلب #24 الي تم تأكيد الطلب', 5, 24, 0, '2022-06-29 10:39:14', '2022-06-29 10:39:14', NULL, NULL, NULL),
(8041, NULL, 'Order Cancelled', NULL, 'Customer 1000003 Has just cancelled order 24', NULL, NULL, NULL, 1, '2022-06-29 10:43:44', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8042, NULL, 'Order Cancelled', NULL, 'Customer 1000003 Has just cancelled order 24', NULL, NULL, NULL, 1, '2022-06-29 10:43:44', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8043, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #24 Status is now Cancelled', 'تم تغيير حالة الطلب #24 الي تم الالغاء', 5, 24, 0, '2022-06-29 10:43:58', '2022-06-29 10:43:58', NULL, NULL, NULL),
(8044, NULL, 'New Order', NULL, 'You have received a new order 25', NULL, NULL, NULL, 1, '2022-06-29 10:44:31', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8045, 1000003, 'Order Created', 'تم الطلب', 'Your order #25 is now Placed', 'حاله طلبك رقم #25 هي تم الطلب', 5, 25, 0, '2022-06-29 10:44:31', '2022-06-29 10:44:31', NULL, NULL, NULL),
(8046, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #25 Status is now Confirmed', 'تم تغيير حالة الطلب #25 الي تم تأكيد الطلب', 5, 25, 0, '2022-06-29 10:44:47', '2022-06-29 10:44:47', NULL, NULL, NULL),
(8047, NULL, 'Order Cancelled', NULL, 'Customer 1000003 Has just cancelled order 25', NULL, NULL, NULL, 1, '2022-06-29 10:46:33', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8048, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #25 Status is now Cancelled', 'تم تغيير حالة الطلب #25 الي تم الالغاء', 5, 25, 0, '2022-06-29 10:46:49', '2022-06-29 10:46:49', NULL, NULL, NULL),
(8049, NULL, 'New Order', NULL, 'You have received a new order 26', NULL, NULL, NULL, 1, '2022-06-29 10:47:42', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8050, 1000003, 'Order Created', 'تم الطلب', 'Your order #26 is now Placed', 'حاله طلبك رقم #26 هي تم الطلب', 5, 26, 0, '2022-06-29 10:47:42', '2022-06-29 10:47:42', NULL, NULL, NULL),
(8051, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #26 Status is now Confirmed', 'تم تغيير حالة الطلب #26 الي تم تأكيد الطلب', 5, 26, 0, '2022-06-29 10:48:01', '2022-06-29 10:48:01', NULL, NULL, NULL),
(8052, NULL, 'Order Cancelled', NULL, 'Customer 1000003 Has just cancelled order 26', NULL, NULL, NULL, 1, '2022-06-29 10:55:29', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8053, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #26 Status is now Cancelled', 'تم تغيير حالة الطلب #26 الي تم الالغاء', 5, 26, 0, '2022-06-29 10:56:12', '2022-06-29 10:56:12', NULL, NULL, NULL),
(8054, NULL, 'New Order', NULL, 'You have received a new order 27', NULL, NULL, NULL, 1, '2022-06-29 10:56:14', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8055, 1000003, 'Order Created', 'تم الطلب', 'Your order #27 is now Placed', 'حاله طلبك رقم #27 هي تم الطلب', 5, 27, 0, '2022-06-29 10:56:14', '2022-06-29 10:56:14', NULL, NULL, NULL),
(8056, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #27 Status is now Confirmed', 'تم تغيير حالة الطلب #27 الي تم تأكيد الطلب', 5, 27, 0, '2022-06-29 10:56:39', '2022-06-29 10:56:39', NULL, NULL, NULL),
(8057, NULL, 'Order Cancelled', NULL, 'Customer 1000003 Has just cancelled order 27', NULL, NULL, NULL, 1, '2022-06-29 11:03:28', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8058, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #27 Status is now Cancelled', 'تم تغيير حالة الطلب #27 الي تم الالغاء', 5, 27, 0, '2022-06-29 11:04:08', '2022-06-29 11:04:08', NULL, NULL, NULL),
(8059, NULL, 'New Order', NULL, 'You have received a new order 28', NULL, NULL, NULL, 1, '2022-06-29 11:04:13', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8060, 1000003, 'Order Created', 'تم الطلب', 'Your order #28 is now Placed', 'حاله طلبك رقم #28 هي تم الطلب', 5, 28, 0, '2022-06-29 11:04:13', '2022-06-29 11:04:13', NULL, NULL, NULL),
(8061, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #28 Status is now Confirmed', 'تم تغيير حالة الطلب #28 الي تم تأكيد الطلب', 5, 28, 0, '2022-06-29 11:04:38', '2022-06-29 11:04:38', NULL, NULL, NULL),
(8062, NULL, 'Order Cancelled', NULL, 'Customer 1000003 Has just cancelled order 28', NULL, NULL, NULL, 1, '2022-06-29 11:16:29', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8063, NULL, 'New Order', NULL, 'You have received a new order 29', NULL, NULL, NULL, 1, '2022-06-29 11:21:17', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8064, 1000003, 'Order Created', 'تم الطلب', 'Your order #29 is now Placed', 'حاله طلبك رقم #29 هي تم الطلب', 5, 29, 0, '2022-06-29 11:21:17', '2022-06-29 11:21:17', NULL, NULL, NULL),
(8065, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #29 Status is now Confirmed', 'تم تغيير حالة الطلب #29 الي تم تأكيد الطلب', 5, 29, 0, '2022-06-29 11:21:46', '2022-06-29 11:21:46', NULL, NULL, NULL),
(8066, NULL, 'Order Cancelled', NULL, 'Customer 1000003 Has just cancelled order 29', NULL, NULL, NULL, 1, '2022-06-29 11:27:00', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8067, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #29 Status is now Cancelled', 'تم تغيير حالة الطلب #29 الي تم الالغاء', 5, 29, 0, '2022-06-29 11:27:21', '2022-06-29 11:27:21', NULL, NULL, NULL),
(8068, NULL, 'New Order', NULL, 'You have received a new order 30', NULL, NULL, NULL, 1, '2022-06-29 11:28:30', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8069, 1000003, 'Order Created', 'تم الطلب', 'Your order #30 is now Placed', 'حاله طلبك رقم #30 هي تم الطلب', 5, 30, 0, '2022-06-29 11:28:30', '2022-06-29 11:28:30', NULL, NULL, NULL),
(8070, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #30 Status is now Confirmed', 'تم تغيير حالة الطلب #30 الي تم تأكيد الطلب', 5, 30, 0, '2022-06-29 11:28:58', '2022-06-29 11:28:58', NULL, NULL, NULL),
(8071, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #30 Status is now Delivered', 'تم تغيير حالة الطلب #30 الي تم التوصيل', 5, 30, 0, '2022-07-17 12:43:33', '2022-07-17 12:43:33', NULL, NULL, NULL),
(8072, NULL, 'New Order', NULL, 'You have received a new order 31', NULL, NULL, NULL, 1, '2022-07-17 12:43:41', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8073, 1000003, 'Order Created', 'تم الطلب', 'Your order #31 is now Placed', 'حاله طلبك رقم #31 هي تم الطلب', 5, 31, 0, '2022-07-17 12:43:41', '2022-07-17 12:43:41', NULL, NULL, NULL),
(8074, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #31 Status is now Confirmed', 'تم تغيير حالة الطلب #31 الي تم تأكيد الطلب', 5, 31, 0, '2022-07-17 12:44:31', '2022-07-17 12:44:31', NULL, NULL, NULL),
(8075, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #31 Status is now Delivered', 'تم تغيير حالة الطلب #31 الي تم التوصيل', 5, 31, 0, '2022-07-17 15:05:45', '2022-07-17 15:05:45', NULL, NULL, NULL),
(8076, NULL, 'New Order', NULL, 'You have received a new order 32', NULL, NULL, NULL, 1, '2022-07-17 15:07:33', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8077, 1000003, 'Order Created', 'تم الطلب', 'Your order #32 is now Placed', 'حاله طلبك رقم #32 هي تم الطلب', 5, 32, 0, '2022-07-17 15:07:33', '2022-07-17 15:07:33', NULL, NULL, NULL),
(8078, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #32 Status is now Confirmed', 'تم تغيير حالة الطلب #32 الي تم تأكيد الطلب', 5, 32, 0, '2022-07-17 15:07:46', '2022-07-17 15:07:46', NULL, NULL, NULL),
(8079, NULL, 'Order Cancelled', NULL, 'Customer 1000003 Has just cancelled order 32', NULL, NULL, NULL, 1, '2022-07-17 15:57:01', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8080, NULL, 'New Order', NULL, 'You have received a new order 33', NULL, NULL, NULL, 1, '2022-07-17 15:57:26', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8081, 1000003, 'Order Created', 'تم الطلب', 'Your order #33 is now Placed', 'حاله طلبك رقم #33 هي تم الطلب', 5, 33, 0, '2022-07-17 15:57:27', '2022-07-17 15:57:27', NULL, NULL, NULL),
(8082, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #33 Status is now Confirmed', 'تم تغيير حالة الطلب #33 الي تم تأكيد الطلب', 5, 33, 0, '2022-07-17 15:58:08', '2022-07-17 15:58:08', NULL, NULL, NULL),
(8083, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #33 Status is now Delivered', 'تم تغيير حالة الطلب #33 الي تم التوصيل', 5, 33, 0, '2022-07-17 16:05:02', '2022-07-17 16:05:02', NULL, NULL, NULL),
(8084, NULL, 'New Order', NULL, 'You have received a new order 34', NULL, NULL, NULL, 1, '2022-07-17 16:11:36', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8085, 1000003, 'Order Created', 'تم الطلب', 'Your order #34 is now Placed', 'حاله طلبك رقم #34 هي تم الطلب', 5, 34, 0, '2022-07-17 16:11:36', '2022-07-17 16:11:36', NULL, NULL, NULL),
(8086, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #34 Status is now Confirmed', 'تم تغيير حالة الطلب #34 الي تم تأكيد الطلب', 5, 34, 0, '2022-07-17 16:12:04', '2022-07-17 16:12:04', NULL, NULL, NULL),
(8087, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #34 Status is now Cancelled', 'تم تغيير حالة الطلب #34 الي تم الالغاء', 5, 34, 0, '2022-07-17 16:13:56', '2022-07-17 16:13:56', NULL, NULL, NULL),
(8088, NULL, 'New Order', NULL, 'You have received a new order 35', NULL, NULL, NULL, 1, '2022-07-17 16:16:52', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8089, 1000003, 'Order Created', 'تم الطلب', 'Your order #35 is now Placed', 'حاله طلبك رقم #35 هي تم الطلب', 5, 35, 1, '2022-07-17 16:16:52', '2022-07-19 09:44:05', NULL, NULL, NULL),
(8090, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #35 Status is now Confirmed', 'تم تغيير حالة الطلب #35 الي تم تأكيد الطلب', 5, 35, 1, '2022-07-17 16:17:04', '2022-07-19 09:44:05', NULL, NULL, NULL),
(8091, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #35 Status is now Delivered', 'تم تغيير حالة الطلب #35 الي تم التوصيل', 5, 35, 1, '2022-07-17 16:29:41', '2022-07-19 09:44:05', NULL, NULL, NULL),
(8092, NULL, 'New Order', NULL, 'You have received a new order 36', NULL, NULL, NULL, 1, '2022-07-17 16:43:28', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8093, 1000003, 'Order Created', 'تم الطلب', 'Your order #36 is now Placed', 'حاله طلبك رقم #36 هي تم الطلب', 5, 36, 1, '2022-07-17 16:43:28', '2022-07-19 09:44:05', NULL, NULL, NULL),
(8094, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #36 Status is now Confirmed', 'تم تغيير حالة الطلب #36 الي تم تأكيد الطلب', 5, 36, 1, '2022-07-17 16:43:51', '2022-07-19 09:44:05', NULL, NULL, NULL),
(8095, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #36 Status is now Delivered', 'تم تغيير حالة الطلب #36 الي تم التوصيل', 5, 36, 1, '2022-07-17 17:11:56', '2022-07-19 09:44:05', NULL, NULL, NULL),
(8096, NULL, 'New Order', NULL, 'You have received a new order 37', NULL, NULL, NULL, 1, '2022-07-18 13:01:39', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8097, 1000003, 'Order Created', 'تم الطلب', 'Your order #37 is now Placed', 'حاله طلبك رقم #37 هي تم الطلب', 5, 37, 1, '2022-07-18 13:01:40', '2022-07-19 09:44:05', NULL, NULL, NULL),
(8098, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #37 Status is now Confirmed', 'تم تغيير حالة الطلب #37 الي تم تأكيد الطلب', 5, 37, 1, '2022-07-18 13:02:52', '2022-07-19 09:44:05', NULL, NULL, NULL),
(8099, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #37 Status is now Delivered', 'تم تغيير حالة الطلب #37 الي تم التوصيل', 5, 37, 1, '2022-07-18 13:24:02', '2022-07-19 09:44:05', NULL, NULL, NULL),
(8100, 1000003, 'مرحبا بكم فيمجموعة منصور', NULL, 'مرحبا بكم فيمجموعة منصور', NULL, 1, NULL, 1, '2022-07-18 13:29:29', '2022-07-19 09:44:05', NULL, NULL, NULL),
(8101, NULL, 'New Order', NULL, 'You have received a new order 38', NULL, NULL, NULL, 1, '2022-07-19 10:55:49', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8102, 1000003, 'Order Created', 'تم الطلب', 'Your order #38 is now Placed', 'حاله طلبك رقم #38 هي تم الطلب', 5, 38, 0, '2022-07-19 10:55:50', '2022-07-19 10:55:50', NULL, NULL, NULL),
(8103, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #38 Status is now Cancelled', 'تم تغيير حالة الطلب #38 الي تم الالغاء', 5, 38, 0, '2022-07-19 11:21:56', '2022-07-19 11:21:56', NULL, NULL, NULL),
(8104, NULL, 'New Order', NULL, 'You have received a new order 39', NULL, NULL, NULL, 1, '2022-07-19 12:34:32', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8105, 1000003, 'Order Created', 'تم الطلب', 'Your order #39 is now Placed', 'حاله طلبك رقم #39 هي تم الطلب', 5, 39, 0, '2022-07-19 12:34:32', '2022-07-19 12:34:32', NULL, NULL, NULL),
(8106, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #39 Status is now Confirmed', 'تم تغيير حالة الطلب #39 الي تم تأكيد الطلب', 5, 39, 0, '2022-07-19 12:37:36', '2022-07-19 12:37:36', NULL, NULL, NULL),
(8107, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #39 Status is now Delivered', 'تم تغيير حالة الطلب #39 الي تم التوصيل', 5, 39, 0, '2022-07-19 13:09:16', '2022-07-19 13:09:16', NULL, NULL, NULL),
(8108, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #39 Status is now Returned', 'تم تغيير حالة الطلب #39 الي تم الاسترجاع', 5, 39, 0, '2022-07-19 15:18:01', '2022-07-19 15:18:01', NULL, NULL, NULL),
(8109, NULL, 'New Order', NULL, 'You have received a new order 40', NULL, NULL, NULL, 1, '2022-07-19 15:33:26', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8110, 1000003, 'Order Created', 'تم الطلب', 'Your order #40 is now Placed', 'حاله طلبك رقم #40 هي تم الطلب', 5, 40, 0, '2022-07-19 15:33:26', '2022-07-19 15:33:26', NULL, NULL, NULL),
(8111, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #40 Status is now Delivered', 'تم تغيير حالة الطلب #40 الي تم التوصيل', 5, 40, 0, '2022-07-19 15:33:44', '2022-07-19 15:33:44', NULL, NULL, NULL),
(8112, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #40 Status is now Returned', 'تم تغيير حالة الطلب #40 الي تم الاسترجاع', 5, 40, 0, '2022-07-19 15:35:02', '2022-07-19 15:35:02', NULL, NULL, NULL),
(8113, 1000004, 'Order Status Change', 'تغيير حالة الطلب', 'Order #9 Status is now Cancelled', 'تم تغيير حالة الطلب #9 الي تم الالغاء', 5, 9, 0, '2022-07-19 15:35:44', '2022-07-19 15:35:44', NULL, NULL, NULL),
(8114, 1, 'File Exported ', NULL, 'Your export has completed! You can download the file from', NULL, 11, 0, 1, '2022-07-19 15:50:37', '2022-09-13 14:00:51', NULL, 'https://10.51.0.5/storage/exports/categories/Categories__by_Super Admin_2022_07_19 15_50_35.xlsx', NULL),
(8115, NULL, 'New Order', NULL, 'You have received a new order 41', NULL, NULL, NULL, 1, '2022-07-20 09:39:52', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8116, 1000003, 'Order Created', 'تم الطلب', 'Your order #41 is now Placed', 'حاله طلبك رقم #41 هي تم الطلب', 5, 41, 0, '2022-07-20 09:39:53', '2022-07-20 09:39:53', NULL, NULL, NULL),
(8117, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #41 Status is now Confirmed', 'تم تغيير حالة الطلب #41 الي تم تأكيد الطلب', 5, 41, 0, '2022-07-20 09:40:31', '2022-07-20 09:40:31', NULL, NULL, NULL),
(8118, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #41 Status is now Delivered', 'تم تغيير حالة الطلب #41 الي تم التوصيل', 5, 41, 0, '2022-07-20 09:41:51', '2022-07-20 09:41:51', NULL, NULL, NULL),
(8119, NULL, 'New Order', NULL, 'You have received a new order 1', NULL, NULL, NULL, 1, '2022-07-20 15:58:49', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8120, 1000002, 'Order Created', 'تم الطلب', 'Your order #1 is now Placed', 'حاله طلبك رقم #1 هي تم الطلب', 5, 1, 1, '2022-07-20 15:58:49', '2022-07-24 04:32:28', NULL, NULL, NULL),
(8121, 1000002, 'Order Status Change', 'تغيير حالة الطلب', 'Order #1 Status is now Confirmed', 'تم تغيير حالة الطلب #1 الي تم تأكيد الطلب', 5, 1, 1, '2022-07-20 16:00:35', '2022-07-24 04:32:28', NULL, NULL, NULL),
(8122, NULL, 'New Order', NULL, 'You have received a new order 2', NULL, NULL, NULL, 1, '2022-07-21 11:31:41', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8123, 1000006, 'Order Created', 'تم الطلب', 'Your order #2 is now Placed', 'حاله طلبك رقم #2 هي تم الطلب', 5, 2, 0, '2022-07-21 11:31:41', '2022-07-21 11:31:41', NULL, NULL, NULL),
(8124, NULL, 'Order Cancelled', NULL, 'Customer 1000006 Has just cancelled order 2', NULL, NULL, NULL, 1, '2022-07-21 11:36:02', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8125, NULL, 'New Order', NULL, 'You have received a new order 3', NULL, NULL, NULL, 1, '2022-07-21 11:37:29', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8126, 1000006, 'Order Created', 'تم الطلب', 'Your order #3 is now Placed', 'حاله طلبك رقم #3 هي تم الطلب', 5, 3, 1, '2022-07-21 11:37:29', '2022-07-26 19:17:25', NULL, NULL, NULL),
(8127, 1000006, 'Order Status Change', 'تغيير حالة الطلب', 'Order #3 Status is now Confirmed', 'تم تغيير حالة الطلب #3 الي تم تأكيد الطلب', 5, 3, 1, '2022-07-21 11:38:35', '2022-07-26 19:17:25', NULL, NULL, NULL),
(8128, 1000002, 'Order Status Change', 'تغيير حالة الطلب', 'Order #1 Status is now Delivered', 'تم تغيير حالة الطلب #1 الي تم التوصيل', 5, 1, 1, '2022-07-21 16:26:04', '2022-07-24 04:32:28', NULL, NULL, NULL),
(8129, 1000006, 'Order Status Change', 'تغيير حالة الطلب', 'Order #3 Status is now Delivered', 'تم تغيير حالة الطلب #3 الي تم التوصيل', 5, 3, 1, '2022-07-21 18:11:47', '2022-07-26 19:17:25', NULL, NULL, NULL),
(8130, NULL, 'New Order', NULL, 'You have received a new order 4', NULL, NULL, NULL, 1, '2022-07-23 14:55:23', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8131, 1000006, 'Order Created', 'تم الطلب', 'Your order #4 is now Placed', 'حاله طلبك رقم #4 هي تم الطلب', 5, 4, 1, '2022-07-23 14:55:24', '2022-07-26 19:17:25', NULL, NULL, NULL),
(8132, 1000006, 'Order Status Change', 'تغيير حالة الطلب', 'Order #4 Status is now Confirmed', 'تم تغيير حالة الطلب #4 الي تم تأكيد الطلب', 5, 4, 1, '2022-07-24 09:30:43', '2022-07-26 19:17:25', NULL, NULL, NULL),
(8133, NULL, 'New Order', NULL, 'You have received a new order 5', NULL, NULL, NULL, 1, '2022-07-24 10:51:02', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8134, 1000008, 'Order Created', 'تم الطلب', 'Your order #5 is now Placed', 'حاله طلبك رقم #5 هي تم الطلب', 5, 5, 1, '2022-07-24 10:51:02', '2022-07-24 10:56:23', NULL, NULL, NULL),
(8135, 1000008, 'Order Status Change', 'تغيير حالة الطلب', 'Order #5 Status is now Confirmed', 'تم تغيير حالة الطلب #5 الي تم تأكيد الطلب', 5, 5, 1, '2022-07-24 10:52:15', '2022-07-24 10:56:23', NULL, NULL, NULL),
(8136, 1000008, 'Order Status Change', 'تغيير حالة الطلب', 'Order #5 Status is now Delivered', 'تم تغيير حالة الطلب #5 الي تم التوصيل', 5, 5, 0, '2022-07-25 09:18:41', '2022-07-25 09:18:41', NULL, NULL, NULL),
(8137, 1000006, 'Order Status Change', 'تغيير حالة الطلب', 'Order #4 Status is now Delivered', 'تم تغيير حالة الطلب #4 الي تم التوصيل', 5, 4, 1, '2022-07-25 09:18:42', '2022-07-26 19:17:25', NULL, NULL, NULL),
(8138, NULL, 'New Order', NULL, 'You have received a new order 6', NULL, NULL, NULL, 1, '2022-07-25 10:47:03', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8139, 1000008, 'Order Created', 'تم الطلب', 'Your order #6 is now Placed', 'حاله طلبك رقم #6 هي تم الطلب', 5, 6, 0, '2022-07-25 10:47:03', '2022-07-25 10:47:03', NULL, NULL, NULL),
(8140, NULL, 'Order Cancelled', NULL, 'Customer 1000008 Has just cancelled order 6', NULL, NULL, NULL, 1, '2022-07-25 10:56:06', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8141, NULL, 'New Order', NULL, 'You have received a new order 7', NULL, NULL, NULL, 1, '2022-07-25 10:56:44', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8142, 1000008, 'Order Created', 'تم الطلب', 'Your order #7 is now Placed', 'حاله طلبك رقم #7 هي تم الطلب', 5, 7, 0, '2022-07-25 10:56:44', '2022-07-25 10:56:44', NULL, NULL, NULL),
(8143, 1000008, 'Order Status Change', 'تغيير حالة الطلب', 'Order #6 Status is now Cancelled', 'تم تغيير حالة الطلب #6 الي تم الالغاء', 5, 6, 0, '2022-07-25 10:56:59', '2022-07-25 10:56:59', NULL, NULL, NULL),
(8144, 1000008, 'Order Status Change', 'تغيير حالة الطلب', 'Order #7 Status is now Confirmed', 'تم تغيير حالة الطلب #7 الي تم تأكيد الطلب', 5, 7, 0, '2022-07-25 10:58:18', '2022-07-25 10:58:18', NULL, NULL, NULL),
(8145, NULL, 'New Order', NULL, 'You have received a new order 8', NULL, NULL, NULL, 1, '2022-07-25 12:21:18', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8146, 1000002, 'Order Created', 'تم الطلب', 'Your order #8 is now Placed', 'حاله طلبك رقم #8 هي تم الطلب', 5, 8, 0, '2022-07-25 12:21:19', '2022-07-25 12:21:19', NULL, NULL, NULL),
(8147, NULL, 'Order Cancelled', NULL, 'Customer 1000002 Has just cancelled order 8', NULL, NULL, NULL, 1, '2022-07-25 12:31:45', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8148, NULL, 'New Order', NULL, 'You have received a new order 9', NULL, NULL, NULL, 1, '2022-07-25 12:44:07', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8149, 1000002, 'Order Created', 'تم الطلب', 'Your order #9 is now Placed', 'حاله طلبك رقم #9 هي تم الطلب', 5, 9, 0, '2022-07-25 12:44:07', '2022-07-25 12:44:07', NULL, NULL, NULL),
(8150, 1000002, 'Order Status Change', 'تغيير حالة الطلب', 'Order #9 Status is now Confirmed', 'تم تغيير حالة الطلب #9 الي تم تأكيد الطلب', 5, 9, 0, '2022-07-25 13:00:30', '2022-07-25 13:00:30', NULL, NULL, NULL),
(8151, NULL, 'New Order', NULL, 'You have received a new order 10', NULL, NULL, NULL, 1, '2022-07-25 15:40:30', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8152, 1000006, 'Order Created', 'تم الطلب', 'Your order #10 is now Placed', 'حاله طلبك رقم #10 هي تم الطلب', 5, 10, 1, '2022-07-25 15:40:30', '2022-07-26 19:17:25', NULL, NULL, NULL),
(8153, 1000006, 'Order Status Change', 'تغيير حالة الطلب', 'Order #10 Status is now Confirmed', 'تم تغيير حالة الطلب #10 الي تم تأكيد الطلب', 5, 10, 1, '2022-07-25 16:01:25', '2022-07-26 19:17:25', NULL, NULL, NULL),
(8154, NULL, 'New Order', NULL, 'You have received a new order 11', NULL, NULL, NULL, 1, '2022-07-26 04:54:22', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8155, 1000003, 'Order Created', 'تم الطلب', 'Your order #11 is now Placed', 'حاله طلبك رقم #11 هي تم الطلب', 5, 11, 0, '2022-07-26 04:54:22', '2022-07-26 04:54:22', NULL, NULL, NULL),
(8156, NULL, 'Order Cancelled', NULL, 'Customer 1000003 Has just cancelled order 11', NULL, NULL, NULL, 1, '2022-07-26 04:57:25', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8157, NULL, 'New Order', NULL, 'You have received a new order 12', NULL, NULL, NULL, 1, '2022-07-26 04:59:15', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8158, 1000003, 'Order Created', 'تم الطلب', 'Your order #12 is now Placed', 'حاله طلبك رقم #12 هي تم الطلب', 5, 12, 0, '2022-07-26 04:59:16', '2022-07-26 04:59:16', NULL, NULL, NULL),
(8159, NULL, 'Order Cancelled', NULL, 'Customer 1000006 Has just cancelled order 10', NULL, NULL, NULL, 1, '2022-07-26 11:57:31', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8160, NULL, 'New Order', NULL, 'You have received a new order 13', NULL, NULL, NULL, 1, '2022-07-26 11:57:46', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8161, 1000006, 'Order Created', 'تم الطلب', 'Your order #13 is now Placed', 'حاله طلبك رقم #13 هي تم الطلب', 5, 13, 1, '2022-07-26 11:57:46', '2022-07-26 19:17:25', NULL, NULL, NULL),
(8162, NULL, 'Order Cancelled', NULL, 'Customer 1000008 Has just cancelled order 7', NULL, NULL, NULL, 1, '2022-07-26 12:00:28', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8163, NULL, 'New Order', NULL, 'You have received a new order 14', NULL, NULL, NULL, 1, '2022-07-26 12:00:59', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8164, 1000008, 'Order Created', 'تم الطلب', 'Your order #14 is now Placed', 'حاله طلبك رقم #14 هي تم الطلب', 5, 14, 0, '2022-07-26 12:01:00', '2022-07-26 12:01:00', NULL, NULL, NULL),
(8165, 1000006, 'Order Status Change', 'تغيير حالة الطلب', 'Order #13 Status is now Confirmed', 'تم تغيير حالة الطلب #13 الي تم تأكيد الطلب', 5, 13, 1, '2022-07-26 12:01:15', '2022-07-26 19:17:25', NULL, NULL, NULL),
(8166, 1000008, 'Order Status Change', 'تغيير حالة الطلب', 'Order #14 Status is now Confirmed', 'تم تغيير حالة الطلب #14 الي تم تأكيد الطلب', 5, 14, 0, '2022-07-26 12:02:03', '2022-07-26 12:02:03', NULL, NULL, NULL),
(8167, NULL, 'Order Cancelled', NULL, 'Customer 1000003 Has just cancelled order 12', NULL, NULL, NULL, 1, '2022-07-26 12:40:15', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8168, NULL, 'New Order', NULL, 'You have received a new order 15', NULL, NULL, NULL, 1, '2022-07-26 12:42:00', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8169, 1000003, 'Order Created', 'تم الطلب', 'Your order #15 is now Placed', 'حاله طلبك رقم #15 هي تم الطلب', 5, 15, 0, '2022-07-26 12:42:00', '2022-07-26 12:42:00', NULL, NULL, NULL),
(8170, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #15 Status is now Confirmed', 'تم تغيير حالة الطلب #15 الي تم تأكيد الطلب', 5, 15, 0, '2022-07-26 12:42:34', '2022-07-26 12:42:34', NULL, NULL, NULL),
(8171, 1000002, 'Order Status Change', 'تغيير حالة الطلب', 'Order #9 Status is now Delivered', 'تم تغيير حالة الطلب #9 الي تم التوصيل', 5, 9, 0, '2022-07-26 13:33:39', '2022-07-26 13:33:39', NULL, NULL, NULL),
(8172, 1000008, 'Order Status Change', 'تغيير حالة الطلب', 'Order #14 Status is now Delivered', 'تم تغيير حالة الطلب #14 الي تم التوصيل', 5, 14, 0, '2022-07-27 15:41:06', '2022-07-27 15:41:06', NULL, NULL, NULL),
(8173, NULL, 'Order Rating', NULL, 'Order ID 14 is rated 1', NULL, NULL, NULL, 1, '2022-07-27 15:58:36', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8174, NULL, 'New Order', NULL, 'You have received a new order 16', NULL, NULL, NULL, 1, '2022-07-27 15:59:25', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8175, 1000008, 'Order Created', 'تم الطلب', 'Your order #16 is now Placed', 'حاله طلبك رقم #16 هي تم الطلب', 5, 16, 0, '2022-07-27 15:59:25', '2022-07-27 15:59:25', NULL, NULL, NULL),
(8176, NULL, 'New Order', NULL, 'You have received a new order 17', NULL, NULL, NULL, 1, '2022-07-27 17:06:05', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8177, 1000002, 'Order Created', 'تم الطلب', 'Your order #17 is now Placed', 'حاله طلبك رقم #17 هي تم الطلب', 5, 17, 0, '2022-07-27 17:06:05', '2022-07-27 17:06:05', NULL, NULL, NULL),
(8178, 1000002, 'Order Status Change', 'تغيير حالة الطلب', 'Order #17 Status is now Confirmed', 'تم تغيير حالة الطلب #17 الي تم تأكيد الطلب', 5, 17, 0, '2022-07-27 17:56:20', '2022-07-27 17:56:20', NULL, NULL, NULL),
(8179, 1000006, 'Order Status Change', 'تغيير حالة الطلب', 'Order #13 Status is now Delivered', 'تم تغيير حالة الطلب #13 الي تم التوصيل', 5, 13, 0, '2022-07-27 17:58:43', '2022-07-27 17:58:43', NULL, NULL, NULL),
(8180, NULL, 'Order Cancelled', NULL, 'Customer 1000003 Has just cancelled order 15', NULL, NULL, NULL, 1, '2022-07-27 18:13:57', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8181, NULL, 'New Order', NULL, 'You have received a new order 18', NULL, NULL, NULL, 1, '2022-07-27 18:14:06', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8182, 1000003, 'Order Created', 'تم الطلب', 'Your order #18 is now Placed', 'حاله طلبك رقم #18 هي تم الطلب', 5, 18, 0, '2022-07-27 18:14:06', '2022-07-27 18:14:06', NULL, NULL, NULL),
(8183, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #18 Status is now Confirmed', 'تم تغيير حالة الطلب #18 الي تم تأكيد الطلب', 5, 18, 0, '2022-07-27 18:55:41', '2022-07-27 18:55:41', NULL, NULL, NULL),
(8184, NULL, 'New Order', NULL, 'You have received a new order 19', NULL, NULL, NULL, 1, '2022-07-28 00:37:25', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8185, 1000005, 'Order Created', 'تم الطلب', 'Your order #19 is now Placed', 'حاله طلبك رقم #19 هي تم الطلب', 5, 19, 1, '2022-07-28 00:37:25', '2022-10-08 22:14:39', NULL, NULL, NULL),
(8186, NULL, 'Order Cancelled', NULL, 'Customer 1000008 Has just cancelled order 16', NULL, NULL, NULL, 1, '2022-07-28 11:48:45', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8187, NULL, 'New Order', NULL, 'You have received a new order 20', NULL, NULL, NULL, 1, '2022-07-28 12:12:48', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8188, 1000008, 'Order Created', 'تم الطلب', 'Your order #20 is now Placed', 'حاله طلبك رقم #20 هي تم الطلب', 5, 20, 0, '2022-07-28 12:12:48', '2022-07-28 12:12:48', NULL, NULL, NULL),
(8189, 1000008, 'Order Status Change', 'تغيير حالة الطلب', 'Order #20 Status is now Confirmed', 'تم تغيير حالة الطلب #20 الي تم تأكيد الطلب', 5, 20, 0, '2022-07-28 12:16:14', '2022-07-28 12:16:14', NULL, NULL, NULL),
(8190, 1000005, 'Order Status Change', 'تغيير حالة الطلب', 'Order #19 Status is now Cancelled', 'تم تغيير حالة الطلب #19 الي تم الالغاء', 5, 19, 1, '2022-07-28 12:16:50', '2022-10-08 22:14:39', NULL, NULL, NULL),
(8191, NULL, 'New Order', NULL, 'You have received a new order 21', NULL, NULL, NULL, 1, '2022-07-28 12:17:39', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8192, 1000005, 'Order Created', 'تم الطلب', 'Your order #21 is now Placed', 'حاله طلبك رقم #21 هي تم الطلب', 5, 21, 1, '2022-07-28 12:17:39', '2022-10-08 22:14:39', NULL, NULL, NULL),
(8193, 1000005, 'Order Status Change', 'تغيير حالة الطلب', 'Order #21 Status is now Confirmed', 'تم تغيير حالة الطلب #21 الي تم تأكيد الطلب', 5, 21, 1, '2022-07-28 12:19:06', '2022-10-08 22:14:39', NULL, NULL, NULL),
(8194, NULL, 'New Order', NULL, 'You have received a new order 22', NULL, NULL, NULL, 1, '2022-07-28 13:48:59', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8195, 1000006, 'Order Created', 'تم الطلب', 'Your order #22 is now Placed', 'حاله طلبك رقم #22 هي تم الطلب', 5, 22, 0, '2022-07-28 13:48:59', '2022-07-28 13:48:59', NULL, NULL, NULL),
(8196, 1000006, 'Order Status Change', 'تغيير حالة الطلب', 'Order #22 Status is now Confirmed', 'تم تغيير حالة الطلب #22 الي تم تأكيد الطلب', 5, 22, 0, '2022-07-28 13:49:24', '2022-07-28 13:49:24', NULL, NULL, NULL),
(8197, NULL, 'Order Cancelled', NULL, 'Customer 1000003 Has just cancelled order 18', NULL, NULL, NULL, 1, '2022-07-29 04:13:55', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8198, NULL, 'Order Cancelled', NULL, 'Customer 1000003 Has just cancelled order 18', NULL, NULL, NULL, 1, '2022-07-29 04:13:56', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8199, NULL, 'New Order', NULL, 'You have received a new order 23', NULL, NULL, NULL, 1, '2022-07-29 04:14:10', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8200, 1000003, 'Order Created', 'تم الطلب', 'Your order #23 is now Placed', 'حاله طلبك رقم #23 هي تم الطلب', 5, 23, 0, '2022-07-29 04:14:10', '2022-07-29 04:14:10', NULL, NULL, NULL),
(8201, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #23 Status is now Confirmed', 'تم تغيير حالة الطلب #23 الي تم تأكيد الطلب', 5, 23, 0, '2022-07-29 20:59:20', '2022-07-29 20:59:20', NULL, NULL, NULL),
(8202, NULL, 'Order Cancelled', NULL, 'Customer 1000003 Has just cancelled order 23', NULL, NULL, NULL, 1, '2022-07-30 16:23:03', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8203, NULL, 'New Order', NULL, 'You have received a new order 24', NULL, NULL, NULL, 1, '2022-07-30 16:24:53', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8204, 1000003, 'Order Created', 'تم الطلب', 'Your order #24 is now Placed', 'حاله طلبك رقم #24 هي تم الطلب', 5, 24, 0, '2022-07-30 16:24:53', '2022-07-30 16:24:53', NULL, NULL, NULL),
(8205, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #24 Status is now Confirmed', 'تم تغيير حالة الطلب #24 الي تم تأكيد الطلب', 5, 24, 0, '2022-07-31 08:59:36', '2022-07-31 08:59:36', NULL, NULL, NULL),
(8206, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #23 Status is now Cancelled', 'تم تغيير حالة الطلب #23 الي تم الالغاء', 5, 23, 0, '2022-07-31 09:14:54', '2022-07-31 09:14:54', NULL, NULL, NULL),
(8207, 1000006, 'Order Status Change', 'تغيير حالة الطلب', 'Order #22 Status is now Delivered', 'تم تغيير حالة الطلب #22 الي تم التوصيل', 5, 22, 0, '2022-07-31 10:02:17', '2022-07-31 10:02:17', NULL, NULL, NULL),
(8208, 1000005, 'Order Status Change', 'تغيير حالة الطلب', 'Order #21 Status is now Delivered', 'تم تغيير حالة الطلب #21 الي تم التوصيل', 5, 21, 1, '2022-07-31 10:02:18', '2022-10-08 22:14:39', NULL, NULL, NULL),
(8209, 1000008, 'Order Status Change', 'تغيير حالة الطلب', 'Order #20 Status is now Delivered', 'تم تغيير حالة الطلب #20 الي تم التوصيل', 5, 20, 0, '2022-07-31 10:02:18', '2022-07-31 10:02:18', NULL, NULL, NULL),
(8210, 1000002, 'Order Status Change', 'تغيير حالة الطلب', 'Order #17 Status is now Delivered', 'تم تغيير حالة الطلب #17 الي تم التوصيل', 5, 17, 0, '2022-07-31 10:02:18', '2022-07-31 10:02:18', NULL, NULL, NULL),
(8211, 1, 'File Exported ', NULL, 'Your export has completed! You can download the file from', NULL, 11, 0, 1, '2022-07-31 10:45:06', '2022-09-13 14:00:51', NULL, 'https://10.51.0.5/storage/exports/orders/Order_by_Admin_2022_07_31 10_45_04.xlsx', NULL),
(8212, NULL, 'New Order', NULL, 'You have received a new order 25', NULL, NULL, NULL, 1, '2022-07-31 11:51:29', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8213, 1000021, 'Order Created', 'تم الطلب', 'Your order #25 is now Placed', 'حاله طلبك رقم #25 هي تم الطلب', 5, 25, 0, '2022-07-31 11:51:29', '2022-07-31 11:51:29', NULL, NULL, NULL),
(8214, 1000021, 'Order Status Change', 'تغيير حالة الطلب', 'Order #25 Status is now Cancelled', 'تم تغيير حالة الطلب #25 الي تم الالغاء', 5, 25, 0, '2022-07-31 12:57:46', '2022-07-31 12:57:46', NULL, NULL, NULL),
(8215, NULL, 'New Order', NULL, 'You have received a new order 26', NULL, NULL, NULL, 1, '2022-07-31 13:14:18', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8216, 1000008, 'Order Created', 'تم الطلب', 'Your order #26 is now Placed', 'حاله طلبك رقم #26 هي تم الطلب', 5, 26, 0, '2022-07-31 13:14:19', '2022-07-31 13:14:19', NULL, NULL, NULL),
(8217, 1000008, 'Order Status Change', 'تغيير حالة الطلب', 'Order #26 Status is now Confirmed', 'تم تغيير حالة الطلب #26 الي تم تأكيد الطلب', 5, 26, 0, '2022-07-31 13:14:42', '2022-07-31 13:14:42', NULL, NULL, NULL),
(8218, NULL, 'New Order', NULL, 'You have received a new order 27', NULL, NULL, NULL, 1, '2022-07-31 13:19:06', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8219, 1000021, 'Order Created', 'تم الطلب', 'Your order #27 is now Placed', 'حاله طلبك رقم #27 هي تم الطلب', 5, 27, 0, '2022-07-31 13:19:06', '2022-07-31 13:19:06', NULL, NULL, NULL),
(8220, 1000021, 'Order Status Change', 'تغيير حالة الطلب', 'Order #27 Status is now Confirmed', 'تم تغيير حالة الطلب #27 الي تم تأكيد الطلب', 5, 27, 0, '2022-07-31 13:22:44', '2022-07-31 13:22:44', NULL, NULL, NULL),
(8221, 1, 'File Exported ', NULL, 'Your export has completed! You can download the file from', NULL, 11, 0, 1, '2022-07-31 13:28:44', '2022-09-13 14:00:51', NULL, 'https://10.51.0.5/storage/exports/products/Product_sales_20220731132844.xlsx', NULL),
(8222, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #24 Status is now Delivered', 'تم تغيير حالة الطلب #24 الي تم التوصيل', 5, 24, 0, '2022-07-31 16:13:45', '2022-07-31 16:13:45', NULL, NULL, NULL),
(8223, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #18 Status is now Delivered', 'تم تغيير حالة الطلب #18 الي تم التوصيل', 5, 18, 0, '2022-07-31 17:02:55', '2022-07-31 17:02:55', NULL, NULL, NULL),
(8224, NULL, 'New Order', NULL, 'You have received a new order 28', NULL, NULL, NULL, 1, '2022-07-31 17:05:39', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8225, 1000006, 'Order Created', 'تم الطلب', 'Your order #28 is now Placed', 'حاله طلبك رقم #28 هي تم الطلب', 5, 28, 0, '2022-07-31 17:05:39', '2022-07-31 17:05:39', NULL, NULL, NULL),
(8226, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #15 Status is now Delivered', 'تم تغيير حالة الطلب #15 الي تم التوصيل', 5, 15, 0, '2022-07-31 17:10:02', '2022-07-31 17:10:02', NULL, NULL, NULL),
(8227, 1000006, 'Order Status Change', 'تغيير حالة الطلب', 'Order #28 Status is now Cancelled', 'تم تغيير حالة الطلب #28 الي تم الالغاء', 5, 28, 0, '2022-07-31 17:21:02', '2022-07-31 17:21:02', NULL, NULL, NULL),
(8228, NULL, 'New Order', NULL, 'You have received a new order 29', NULL, NULL, NULL, 1, '2022-07-31 17:21:45', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8229, 1000006, 'Order Created', 'تم الطلب', 'Your order #29 is now Placed', 'حاله طلبك رقم #29 هي تم الطلب', 5, 29, 0, '2022-07-31 17:21:45', '2022-07-31 17:21:45', NULL, NULL, NULL),
(8230, 1000006, 'Order Status Change', 'تغيير حالة الطلب', 'Order #29 Status is now Confirmed', 'تم تغيير حالة الطلب #29 الي تم تأكيد الطلب', 5, 29, 0, '2022-07-31 17:23:47', '2022-07-31 17:23:47', NULL, NULL, NULL),
(8231, 1000006, 'Order Status Change', 'تغيير حالة الطلب', 'Order #29 Status is now Delivered', 'تم تغيير حالة الطلب #29 الي تم التوصيل', 5, 29, 0, '2022-08-01 13:04:09', '2022-08-01 13:04:09', NULL, NULL, NULL),
(8232, 1000008, 'Order Status Change', 'تغيير حالة الطلب', 'Order #26 Status is now Delivered', 'تم تغيير حالة الطلب #26 الي تم التوصيل', 5, 26, 0, '2022-08-01 13:04:10', '2022-08-01 13:04:10', NULL, NULL, NULL),
(8233, 1000021, 'Order Status Change', 'تغيير حالة الطلب', 'Order #27 Status is now Delivered', 'تم تغيير حالة الطلب #27 الي تم التوصيل', 5, 27, 0, '2022-08-01 13:05:53', '2022-08-01 13:05:53', NULL, NULL, NULL),
(8234, NULL, 'New Order', NULL, 'You have received a new order 30', NULL, NULL, NULL, 1, '2022-08-01 13:07:04', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8235, 1000021, 'Order Created', 'تم الطلب', 'Your order #30 is now Placed', 'حاله طلبك رقم #30 هي تم الطلب', 5, 30, 0, '2022-08-01 13:07:04', '2022-08-01 13:07:04', NULL, NULL, NULL);
INSERT INTO `notifications` (`id`, `user_id`, `title`, `title_ar`, `body`, `body_ar`, `type`, `item_id`, `read`, `created_at`, `updated_at`, `image`, `details`, `item_link`) VALUES
(8236, 1000021, 'Order Status Change', 'تغيير حالة الطلب', 'Order #30 Status is now Cancelled', 'تم تغيير حالة الطلب #30 الي تم الالغاء', 5, 30, 0, '2022-08-01 13:13:00', '2022-08-01 13:13:00', NULL, NULL, NULL),
(8237, NULL, 'New Order', NULL, 'You have received a new order 31', NULL, NULL, NULL, 1, '2022-08-01 13:20:30', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8238, 1000021, 'Order Created', 'تم الطلب', 'Your order #31 is now Placed', 'حاله طلبك رقم #31 هي تم الطلب', 5, 31, 0, '2022-08-01 13:20:30', '2022-08-01 13:20:30', NULL, NULL, NULL),
(8239, 1000021, 'Order Status Change', 'تغيير حالة الطلب', 'Order #31 Status is now Confirmed', 'تم تغيير حالة الطلب #31 الي تم تأكيد الطلب', 5, 31, 0, '2022-08-01 13:25:23', '2022-08-01 13:25:23', NULL, NULL, NULL),
(8240, 1000006, 'Order Status Change', 'تغيير حالة الطلب', 'Order #29 Status is now Returned', 'تم تغيير حالة الطلب #29 الي تم الاسترجاع', 5, 29, 0, '2022-08-01 14:35:17', '2022-08-01 14:35:17', NULL, NULL, NULL),
(8241, NULL, 'New Order', NULL, 'You have received a new order 32', NULL, NULL, NULL, 1, '2022-08-01 14:42:23', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8242, 1000006, 'Order Created', 'تم الطلب', 'Your order #32 is now Placed', 'حاله طلبك رقم #32 هي تم الطلب', 5, 32, 0, '2022-08-01 14:42:23', '2022-08-01 14:42:23', NULL, NULL, NULL),
(8243, 1000006, 'Order Status Change', 'تغيير حالة الطلب', 'Order #32 Status is now Confirmed', 'تم تغيير حالة الطلب #32 الي تم تأكيد الطلب', 5, 32, 0, '2022-08-01 14:43:23', '2022-08-01 14:43:23', NULL, NULL, NULL),
(8244, 1000006, 'Order Status Change', 'تغيير حالة الطلب', 'Order #32 Status is now Delivered', 'تم تغيير حالة الطلب #32 الي تم التوصيل', 5, 32, 0, '2022-08-01 19:29:02', '2022-08-01 19:29:02', NULL, NULL, NULL),
(8245, NULL, 'New Order', NULL, 'You have received a new order 33', NULL, NULL, NULL, 1, '2022-08-01 19:29:55', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8246, 1000006, 'Order Created', 'تم الطلب', 'Your order #33 is now Placed', 'حاله طلبك رقم #33 هي تم الطلب', 5, 33, 0, '2022-08-01 19:29:55', '2022-08-01 19:29:55', NULL, NULL, NULL),
(8247, 1000006, 'Order Status Change', 'تغيير حالة الطلب', 'Order #33 Status is now Confirmed', 'تم تغيير حالة الطلب #33 الي تم تأكيد الطلب', 5, 33, 0, '2022-08-01 19:31:32', '2022-08-01 19:31:32', NULL, NULL, NULL),
(8248, NULL, 'New Order', NULL, 'You have received a new order 34', NULL, NULL, NULL, 1, '2022-08-02 03:48:28', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8249, 1000003, 'Order Created', 'تم الطلب', 'Your order #34 is now Placed', 'حاله طلبك رقم #34 هي تم الطلب', 5, 34, 0, '2022-08-02 03:48:28', '2022-08-02 03:48:28', NULL, NULL, NULL),
(8250, NULL, 'Order Cancelled', NULL, 'Customer 1000003 Has just cancelled order 34', NULL, NULL, NULL, 1, '2022-08-02 03:48:56', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8251, NULL, 'New Order', NULL, 'You have received a new order 35', NULL, NULL, NULL, 1, '2022-08-02 12:57:37', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8252, 1000011, 'Order Created', 'تم الطلب', 'Your order #35 is now Placed', 'حاله طلبك رقم #35 هي تم الطلب', 5, 35, 0, '2022-08-02 12:57:37', '2022-08-02 12:57:37', NULL, NULL, NULL),
(8253, 1000011, 'Order Status Change', 'تغيير حالة الطلب', 'Order #35 Status is now Confirmed', 'تم تغيير حالة الطلب #35 الي تم تأكيد الطلب', 5, 35, 0, '2022-08-02 12:59:52', '2022-08-02 12:59:52', NULL, NULL, NULL),
(8254, 1000011, 'Order Status Change', 'تغيير حالة الطلب', 'Order #35 Status is now Cancelled', 'تم تغيير حالة الطلب #35 الي تم الالغاء', 5, 35, 0, '2022-08-02 13:15:52', '2022-08-02 13:15:52', NULL, NULL, NULL),
(8255, NULL, 'New Order', NULL, 'You have received a new order 36', NULL, NULL, NULL, 1, '2022-08-02 13:22:15', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8256, 1000020, 'Order Created', 'تم الطلب', 'Your order #36 is now Placed', 'حاله طلبك رقم #36 هي تم الطلب', 5, 36, 0, '2022-08-02 13:22:15', '2022-08-02 13:22:15', NULL, NULL, NULL),
(8257, 1000020, 'Order Status Change', 'تغيير حالة الطلب', 'Order #36 Status is now Cancelled', 'تم تغيير حالة الطلب #36 الي تم الالغاء', 5, 36, 0, '2022-08-02 13:31:31', '2022-08-02 13:31:31', NULL, NULL, NULL),
(8258, NULL, 'New Order', NULL, 'You have received a new order 37', NULL, NULL, NULL, 1, '2022-08-02 13:41:51', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8259, 1000020, 'Order Created', 'تم الطلب', 'Your order #37 is now Placed', 'حاله طلبك رقم #37 هي تم الطلب', 5, 37, 0, '2022-08-02 13:41:51', '2022-08-02 13:41:51', NULL, NULL, NULL),
(8260, 1000020, 'Order Status Change', 'تغيير حالة الطلب', 'Order #37 Status is now Confirmed', 'تم تغيير حالة الطلب #37 الي تم تأكيد الطلب', 5, 37, 0, '2022-08-02 13:42:50', '2022-08-02 13:42:50', NULL, NULL, NULL),
(8261, NULL, 'New Order', NULL, 'You have received a new order 38', NULL, NULL, NULL, 1, '2022-08-02 13:44:46', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8262, 1000007, 'Order Created', 'تم الطلب', 'Your order #38 is now Placed', 'حاله طلبك رقم #38 هي تم الطلب', 5, 38, 0, '2022-08-02 13:44:46', '2022-08-02 13:44:46', NULL, NULL, NULL),
(8263, 1000007, 'Order Status Change', 'تغيير حالة الطلب', 'Order #38 Status is now Confirmed', 'تم تغيير حالة الطلب #38 الي تم تأكيد الطلب', 5, 38, 0, '2022-08-02 13:46:35', '2022-08-02 13:46:35', NULL, NULL, NULL),
(8264, NULL, 'New Order', NULL, 'You have received a new order 39', NULL, NULL, NULL, 1, '2022-08-02 13:49:42', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8265, 1000008, 'Order Created', 'تم الطلب', 'Your order #39 is now Placed', 'حاله طلبك رقم #39 هي تم الطلب', 5, 39, 0, '2022-08-02 13:49:42', '2022-08-02 13:49:42', NULL, NULL, NULL),
(8266, 1000008, 'Order Status Change', 'تغيير حالة الطلب', 'Order #39 Status is now Confirmed', 'تم تغيير حالة الطلب #39 الي تم تأكيد الطلب', 5, 39, 0, '2022-08-02 13:50:06', '2022-08-02 13:50:06', NULL, NULL, NULL),
(8267, NULL, 'New Order', NULL, 'You have received a new order 40', NULL, NULL, NULL, 1, '2022-08-02 14:19:24', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8268, 1000022, 'Order Created', 'تم الطلب', 'Your order #40 is now Placed', 'حاله طلبك رقم #40 هي تم الطلب', 5, 40, 1, '2022-08-02 14:19:24', '2022-08-04 00:45:17', NULL, NULL, NULL),
(8269, 1000022, 'Order Status Change', 'تغيير حالة الطلب', 'Order #40 Status is now Confirmed', 'تم تغيير حالة الطلب #40 الي تم تأكيد الطلب', 5, 40, 1, '2022-08-02 14:40:46', '2022-08-04 00:45:17', NULL, NULL, NULL),
(8270, NULL, 'Order Cancelled', NULL, 'Customer 1000021 Has just cancelled order 31', NULL, NULL, NULL, 1, '2022-08-02 15:01:50', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8271, NULL, 'New Order', NULL, 'You have received a new order 41', NULL, NULL, NULL, 1, '2022-08-02 15:07:44', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8272, 1000021, 'Order Created', 'تم الطلب', 'Your order #41 is now Placed', 'حاله طلبك رقم #41 هي تم الطلب', 5, 41, 0, '2022-08-02 15:07:44', '2022-08-02 15:07:44', NULL, NULL, NULL),
(8273, 1000008, 'Order Status Change', 'تغيير حالة الطلب', 'Order #39 Status is now Cancelled', 'تم تغيير حالة الطلب #39 الي تم الالغاء', 5, 39, 0, '2022-08-02 15:09:10', '2022-08-02 15:09:10', NULL, NULL, NULL),
(8274, 1000007, 'Order Status Change', 'تغيير حالة الطلب', 'Order #38 Status is now Cancelled', 'تم تغيير حالة الطلب #38 الي تم الالغاء', 5, 38, 0, '2022-08-02 15:09:11', '2022-08-02 15:09:11', NULL, NULL, NULL),
(8275, 1000020, 'Order Status Change', 'تغيير حالة الطلب', 'Order #37 Status is now Cancelled', 'تم تغيير حالة الطلب #37 الي تم الالغاء', 5, 37, 0, '2022-08-02 15:09:11', '2022-08-02 15:09:11', NULL, NULL, NULL),
(8276, 1000006, 'Order Status Change', 'تغيير حالة الطلب', 'Order #33 Status is now Cancelled', 'تم تغيير حالة الطلب #33 الي تم الالغاء', 5, 33, 0, '2022-08-02 15:09:11', '2022-08-02 15:09:11', NULL, NULL, NULL),
(8277, 1000021, 'Order Status Change', 'تغيير حالة الطلب', 'Order #31 Status is now Cancelled', 'تم تغيير حالة الطلب #31 الي تم الالغاء', 5, 31, 0, '2022-08-02 15:09:11', '2022-08-02 15:09:11', NULL, NULL, NULL),
(8278, NULL, 'Order Cancelled', NULL, 'Customer 1000021 Has just cancelled order 41', NULL, NULL, NULL, 1, '2022-08-02 15:09:11', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8279, 1000022, 'Order Status Change', 'تغيير حالة الطلب', 'Order #40 Status is now Cancelled', 'تم تغيير حالة الطلب #40 الي تم الالغاء', 5, 40, 1, '2022-08-02 15:09:30', '2022-08-04 00:45:17', NULL, NULL, NULL),
(8280, NULL, 'New Order', NULL, 'You have received a new order 42', NULL, NULL, NULL, 1, '2022-08-02 15:10:04', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8281, 1000021, 'Order Created', 'تم الطلب', 'Your order #42 is now Placed', 'حاله طلبك رقم #42 هي تم الطلب', 5, 42, 0, '2022-08-02 15:10:04', '2022-08-02 15:10:04', NULL, NULL, NULL),
(8282, 1000021, 'Order Status Change', 'تغيير حالة الطلب', 'Order #42 Status is now Confirmed', 'تم تغيير حالة الطلب #42 الي تم تأكيد الطلب', 5, 42, 0, '2022-08-02 15:11:49', '2022-08-02 15:11:49', NULL, NULL, NULL),
(8283, 1, 'File Exported ', NULL, 'Your export has completed! You can download the file from', NULL, 11, 0, 1, '2022-08-02 15:18:02', '2022-09-13 14:00:51', NULL, 'https://10.51.0.5/storage/exports/orders/Order_by_Admin_2022_08_02 15_18_01.xlsx', NULL),
(8284, NULL, 'New Order', NULL, 'You have received a new order 43', NULL, NULL, NULL, 1, '2022-08-02 16:54:40', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8285, 1000022, 'Order Created', 'تم الطلب', 'Your order #43 is now Placed', 'حاله طلبك رقم #43 هي تم الطلب', 5, 43, 1, '2022-08-02 16:54:40', '2022-08-04 00:45:17', NULL, NULL, NULL),
(8286, 1000022, 'Order Status Change', 'تغيير حالة الطلب', 'Order #43 Status is now Confirmed', 'تم تغيير حالة الطلب #43 الي تم تأكيد الطلب', 5, 43, 1, '2022-08-02 16:56:11', '2022-08-04 00:45:17', NULL, NULL, NULL),
(8287, NULL, 'New Order', NULL, 'You have received a new order 44', NULL, NULL, NULL, 1, '2022-08-02 18:57:54', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8288, 1000006, 'Order Created', 'تم الطلب', 'Your order #44 is now Placed', 'حاله طلبك رقم #44 هي تم الطلب', 5, 44, 0, '2022-08-02 18:57:54', '2022-08-02 18:57:54', NULL, NULL, NULL),
(8289, NULL, 'New Order', NULL, 'You have received a new order 45', NULL, NULL, NULL, 1, '2022-08-02 23:24:11', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8290, 1000003, 'Order Created', 'تم الطلب', 'Your order #45 is now Placed', 'حاله طلبك رقم #45 هي تم الطلب', 5, 45, 0, '2022-08-02 23:24:11', '2022-08-02 23:24:11', NULL, NULL, NULL),
(8291, 1000006, 'Order Status Change', 'تغيير حالة الطلب', 'Order #44 Status is now Cancelled', 'تم تغيير حالة الطلب #44 الي تم الالغاء', 5, 44, 0, '2022-08-03 09:22:37', '2022-08-03 09:22:37', NULL, NULL, NULL),
(8292, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #45 Status is now Cancelled', 'تم تغيير حالة الطلب #45 الي تم الالغاء', 5, 45, 0, '2022-08-03 09:24:45', '2022-08-03 09:24:45', NULL, NULL, NULL),
(8293, NULL, 'New Order', NULL, 'You have received a new order 46', NULL, NULL, NULL, 1, '2022-08-03 09:26:21', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8294, 1000006, 'Order Created', 'تم الطلب', 'Your order #46 is now Placed', 'حاله طلبك رقم #46 هي تم الطلب', 5, 46, 0, '2022-08-03 09:26:21', '2022-08-03 09:26:21', NULL, NULL, NULL),
(8295, 1000006, 'Order Status Change', 'تغيير حالة الطلب', 'Order #46 Status is now Cancelled', 'تم تغيير حالة الطلب #46 الي تم الالغاء', 5, 46, 0, '2022-08-03 09:27:52', '2022-08-03 09:27:52', NULL, NULL, NULL),
(8296, NULL, 'New Order', NULL, 'You have received a new order 47', NULL, NULL, NULL, 1, '2022-08-03 09:28:40', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8297, 1000006, 'Order Created', 'تم الطلب', 'Your order #47 is now Placed', 'حاله طلبك رقم #47 هي تم الطلب', 5, 47, 0, '2022-08-03 09:28:40', '2022-08-03 09:28:40', NULL, NULL, NULL),
(8298, 1000006, 'Order Status Change', 'تغيير حالة الطلب', 'Order #47 Status is now Confirmed', 'تم تغيير حالة الطلب #47 الي تم تأكيد الطلب', 5, 47, 0, '2022-08-03 09:29:35', '2022-08-03 09:29:35', NULL, NULL, NULL),
(8299, NULL, 'New Order', NULL, 'You have received a new order 48', NULL, NULL, NULL, 1, '2022-08-03 09:33:06', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8300, 1000003, 'Order Created', 'تم الطلب', 'Your order #48 is now Placed', 'حاله طلبك رقم #48 هي تم الطلب', 5, 48, 0, '2022-08-03 09:33:06', '2022-08-03 09:33:06', NULL, NULL, NULL),
(8301, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #48 Status is now Confirmed', 'تم تغيير حالة الطلب #48 الي تم تأكيد الطلب', 5, 48, 0, '2022-08-03 09:33:42', '2022-08-03 09:33:42', NULL, NULL, NULL),
(8302, NULL, 'New Order', NULL, 'You have received a new order 49', NULL, NULL, NULL, 1, '2022-08-03 09:50:57', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8303, 1000007, 'Order Created', 'تم الطلب', 'Your order #49 is now Placed', 'حاله طلبك رقم #49 هي تم الطلب', 5, 49, 0, '2022-08-03 09:50:57', '2022-08-03 09:50:57', NULL, NULL, NULL),
(8304, 1000007, 'Order Status Change', 'تغيير حالة الطلب', 'Order #49 Status is now Confirmed', 'تم تغيير حالة الطلب #49 الي تم تأكيد الطلب', 5, 49, 0, '2022-08-03 09:51:29', '2022-08-03 09:51:29', NULL, NULL, NULL),
(8305, NULL, 'New Order', NULL, 'You have received a new order 50', NULL, NULL, NULL, 1, '2022-08-03 11:16:21', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8306, 1000024, 'Order Created', 'تم الطلب', 'Your order #50 is now Placed', 'حاله طلبك رقم #50 هي تم الطلب', 5, 50, 0, '2022-08-03 11:16:21', '2022-08-03 11:16:21', NULL, NULL, NULL),
(8307, 1, 'File Exported ', NULL, 'Your export has completed! You can download the file from', NULL, 11, 0, 1, '2022-08-03 11:20:29', '2022-09-13 14:00:51', NULL, 'https://10.51.0.5/storage/exports/products/Product_sales_20220803112028.xlsx', NULL),
(8308, 1000024, 'Order Status Change', 'تغيير حالة الطلب', 'Order #50 Status is now Cancelled', 'تم تغيير حالة الطلب #50 الي تم الالغاء', 5, 50, 0, '2022-08-03 11:31:43', '2022-08-03 11:31:43', NULL, NULL, NULL),
(8309, 1000021, 'Order Status Change', 'تغيير حالة الطلب', 'Order #42 Status is now Delivered', 'تم تغيير حالة الطلب #42 الي تم التوصيل', 5, 42, 0, '2022-08-03 11:33:38', '2022-08-03 11:33:38', NULL, NULL, NULL),
(8310, NULL, 'New Order', NULL, 'You have received a new order 51', NULL, NULL, NULL, 1, '2022-08-03 11:34:51', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8311, 1000021, 'Order Created', 'تم الطلب', 'Your order #51 is now Placed', 'حاله طلبك رقم #51 هي تم الطلب', 5, 51, 0, '2022-08-03 11:34:51', '2022-08-03 11:34:51', NULL, NULL, NULL),
(8312, 1000021, 'Order Status Change', 'تغيير حالة الطلب', 'Order #51 Status is now Confirmed', 'تم تغيير حالة الطلب #51 الي تم تأكيد الطلب', 5, 51, 0, '2022-08-03 11:41:14', '2022-08-03 11:41:14', NULL, NULL, NULL),
(8313, NULL, 'New Order', NULL, 'You have received a new order 52', NULL, NULL, NULL, 1, '2022-08-03 11:44:09', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8314, 1000017, 'Order Created', 'تم الطلب', 'Your order #52 is now Placed', 'حاله طلبك رقم #52 هي تم الطلب', 5, 52, 0, '2022-08-03 11:44:09', '2022-08-03 11:44:09', NULL, NULL, NULL),
(8315, 1000017, 'Order Status Change', 'تغيير حالة الطلب', 'Order #52 Status is now Cancelled', 'تم تغيير حالة الطلب #52 الي تم الالغاء', 5, 52, 0, '2022-08-03 11:45:11', '2022-08-03 11:45:11', NULL, NULL, NULL),
(8316, NULL, 'New Order', NULL, 'You have received a new order 53', NULL, NULL, NULL, 1, '2022-08-03 11:47:35', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8317, 1000017, 'Order Created', 'تم الطلب', 'Your order #53 is now Placed', 'حاله طلبك رقم #53 هي تم الطلب', 5, 53, 0, '2022-08-03 11:47:35', '2022-08-03 11:47:35', NULL, NULL, NULL),
(8318, 1000017, 'Order Status Change', 'تغيير حالة الطلب', 'Order #53 Status is now Confirmed', 'تم تغيير حالة الطلب #53 الي تم تأكيد الطلب', 5, 53, 0, '2022-08-03 11:48:13', '2022-08-03 11:48:13', NULL, NULL, NULL),
(8319, 1000021, 'Order Status Change', 'تغيير حالة الطلب', 'Order #51 Status is now Cancelled', 'تم تغيير حالة الطلب #51 الي تم الالغاء', 5, 51, 0, '2022-08-03 12:43:11', '2022-08-03 12:43:11', NULL, NULL, NULL),
(8320, 1000007, 'Order Status Change', 'تغيير حالة الطلب', 'Order #49 Status is now Cancelled', 'تم تغيير حالة الطلب #49 الي تم الالغاء', 5, 49, 0, '2022-08-03 12:44:12', '2022-08-03 12:44:12', NULL, NULL, NULL),
(8321, NULL, 'New Order', NULL, 'You have received a new order 54', NULL, NULL, NULL, 1, '2022-08-03 12:44:15', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8322, 1000021, 'Order Created', 'تم الطلب', 'Your order #54 is now Placed', 'حاله طلبك رقم #54 هي تم الطلب', 5, 54, 0, '2022-08-03 12:44:15', '2022-08-03 12:44:15', NULL, NULL, NULL),
(8323, 1000021, 'Order Status Change', 'تغيير حالة الطلب', 'Order #54 Status is now Confirmed', 'تم تغيير حالة الطلب #54 الي تم تأكيد الطلب', 5, 54, 0, '2022-08-03 12:45:05', '2022-08-03 12:45:05', NULL, NULL, NULL),
(8324, 1000017, 'Order Status Change', 'تغيير حالة الطلب', 'Order #53 Status is now Cancelled', 'تم تغيير حالة الطلب #53 الي تم الالغاء', 5, 53, 0, '2022-08-03 12:45:28', '2022-08-03 12:45:28', NULL, NULL, NULL),
(8325, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #48 Status is now Cancelled', 'تم تغيير حالة الطلب #48 الي تم الالغاء', 5, 48, 0, '2022-08-03 12:46:50', '2022-08-03 12:46:50', NULL, NULL, NULL),
(8326, 1000006, 'Order Status Change', 'تغيير حالة الطلب', 'Order #47 Status is now Cancelled', 'تم تغيير حالة الطلب #47 الي تم الالغاء', 5, 47, 0, '2022-08-03 12:46:50', '2022-08-03 12:46:50', NULL, NULL, NULL),
(8327, 1000022, 'Order Status Change', 'تغيير حالة الطلب', 'Order #43 Status is now Cancelled', 'تم تغيير حالة الطلب #43 الي تم الالغاء', 5, 43, 1, '2022-08-03 12:46:50', '2022-08-04 00:45:17', NULL, NULL, NULL),
(8328, NULL, 'New Order', NULL, 'You have received a new order 55', NULL, NULL, NULL, 1, '2022-08-03 12:52:54', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8329, 1000006, 'Order Created', 'تم الطلب', 'Your order #55 is now Placed', 'حاله طلبك رقم #55 هي تم الطلب', 5, 55, 0, '2022-08-03 12:52:54', '2022-08-03 12:52:54', NULL, NULL, NULL),
(8330, 1000006, 'Order Status Change', 'تغيير حالة الطلب', 'Order #55 Status is now Confirmed', 'تم تغيير حالة الطلب #55 الي تم تأكيد الطلب', 5, 55, 0, '2022-08-03 12:54:02', '2022-08-03 12:54:02', NULL, NULL, NULL),
(8331, NULL, 'New Order', NULL, 'You have received a new order 56', NULL, NULL, NULL, 1, '2022-08-03 12:55:51', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8332, 1000022, 'Order Created', 'تم الطلب', 'Your order #56 is now Placed', 'حاله طلبك رقم #56 هي تم الطلب', 5, 56, 1, '2022-08-03 12:55:51', '2022-08-04 00:45:17', NULL, NULL, NULL),
(8333, 1000022, 'Order Status Change', 'تغيير حالة الطلب', 'Order #56 Status is now Confirmed', 'تم تغيير حالة الطلب #56 الي تم تأكيد الطلب', 5, 56, 1, '2022-08-03 12:57:22', '2022-08-04 00:45:17', NULL, NULL, NULL),
(8334, NULL, 'New Order', NULL, 'You have received a new order 57', NULL, NULL, NULL, 1, '2022-08-03 13:01:11', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8335, 1000003, 'Order Created', 'تم الطلب', 'Your order #57 is now Placed', 'حاله طلبك رقم #57 هي تم الطلب', 5, 57, 0, '2022-08-03 13:01:11', '2022-08-03 13:01:11', NULL, NULL, NULL),
(8336, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #57 Status is now Confirmed', 'تم تغيير حالة الطلب #57 الي تم تأكيد الطلب', 5, 57, 0, '2022-08-03 13:06:23', '2022-08-03 13:06:23', NULL, NULL, NULL),
(8337, NULL, 'New Order', NULL, 'You have received a new order 58', NULL, NULL, NULL, 1, '2022-08-03 13:08:40', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8338, 1000024, 'Order Created', 'تم الطلب', 'Your order #58 is now Placed', 'حاله طلبك رقم #58 هي تم الطلب', 5, 58, 0, '2022-08-03 13:08:40', '2022-08-03 13:08:40', NULL, NULL, NULL),
(8339, 1000024, 'Order Status Change', 'تغيير حالة الطلب', 'Order #58 Status is now Confirmed', 'تم تغيير حالة الطلب #58 الي تم تأكيد الطلب', 5, 58, 0, '2022-08-03 13:10:53', '2022-08-03 13:10:53', NULL, NULL, NULL),
(8340, NULL, 'New Order', NULL, 'You have received a new order 59', NULL, NULL, NULL, 1, '2022-08-03 13:13:01', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8341, 1000017, 'Order Created', 'تم الطلب', 'Your order #59 is now Placed', 'حاله طلبك رقم #59 هي تم الطلب', 5, 59, 0, '2022-08-03 13:13:01', '2022-08-03 13:13:01', NULL, NULL, NULL),
(8342, 1000017, 'Order Status Change', 'تغيير حالة الطلب', 'Order #59 Status is now Confirmed', 'تم تغيير حالة الطلب #59 الي تم تأكيد الطلب', 5, 59, 0, '2022-08-03 13:20:45', '2022-08-03 13:20:45', NULL, NULL, NULL),
(8343, NULL, 'New Order', NULL, 'You have received a new order 60', NULL, NULL, NULL, 1, '2022-08-03 13:21:08', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8344, 1000007, 'Order Created', 'تم الطلب', 'Your order #60 is now Placed', 'حاله طلبك رقم #60 هي تم الطلب', 5, 60, 0, '2022-08-03 13:21:08', '2022-08-03 13:21:08', NULL, NULL, NULL),
(8345, 1000007, 'Order Status Change', 'تغيير حالة الطلب', 'Order #60 Status is now Confirmed', 'تم تغيير حالة الطلب #60 الي تم تأكيد الطلب', 5, 60, 0, '2022-08-03 13:21:48', '2022-08-03 13:21:48', NULL, NULL, NULL),
(8346, NULL, 'New Order', NULL, 'You have received a new order 61', NULL, NULL, NULL, 1, '2022-08-03 13:27:11', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8347, 1000020, 'Order Created', 'تم الطلب', 'Your order #61 is now Placed', 'حاله طلبك رقم #61 هي تم الطلب', 5, 61, 0, '2022-08-03 13:27:11', '2022-08-03 13:27:11', NULL, NULL, NULL),
(8348, 1000020, 'Order Status Change', 'تغيير حالة الطلب', 'Order #61 Status is now Confirmed', 'تم تغيير حالة الطلب #61 الي تم تأكيد الطلب', 5, 61, 0, '2022-08-03 13:28:25', '2022-08-03 13:28:25', NULL, NULL, NULL),
(8349, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #57 Status is now Delivered', 'تم تغيير حالة الطلب #57 الي تم التوصيل', 5, 57, 0, '2022-08-03 14:37:39', '2022-08-03 14:37:39', NULL, NULL, NULL),
(8350, NULL, 'New Order', NULL, 'You have received a new order 62', NULL, NULL, NULL, 1, '2022-08-03 16:09:09', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8351, 1000002, 'Order Created', 'تم الطلب', 'Your order #62 is now Placed', 'حاله طلبك رقم #62 هي تم الطلب', 5, 62, 0, '2022-08-03 16:09:09', '2022-08-03 16:09:09', NULL, NULL, NULL),
(8352, 1000002, 'Order Status Change', 'تغيير حالة الطلب', 'Order #62 Status is now Confirmed', 'تم تغيير حالة الطلب #62 الي تم تأكيد الطلب', 5, 62, 0, '2022-08-03 16:17:06', '2022-08-03 16:17:06', NULL, NULL, NULL),
(8353, NULL, 'New Order', NULL, 'You have received a new order 63', NULL, NULL, NULL, 1, '2022-08-03 16:56:24', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8354, 1000023, 'Order Created', 'تم الطلب', 'Your order #63 is now Placed', 'حاله طلبك رقم #63 هي تم الطلب', 5, 63, 0, '2022-08-03 16:56:24', '2022-08-03 16:56:24', NULL, NULL, NULL),
(8355, 1000023, 'Order Status Change', 'تغيير حالة الطلب', 'Order #63 Status is now Confirmed', 'تم تغيير حالة الطلب #63 الي تم تأكيد الطلب', 5, 63, 0, '2022-08-03 16:56:57', '2022-08-03 16:56:57', NULL, NULL, NULL),
(8356, NULL, 'New Order', NULL, 'You have received a new order 64', NULL, NULL, NULL, 1, '2022-08-03 21:41:16', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8357, 1000005, 'Order Created', 'تم الطلب', 'Your order #64 is now Placed', 'حاله طلبك رقم #64 هي تم الطلب', 5, 64, 1, '2022-08-03 21:41:16', '2022-10-08 22:14:39', NULL, NULL, NULL),
(8358, 1000006, 'Order Status Change', 'تغيير حالة الطلب', 'Order #55 Status is now Delivered', 'تم تغيير حالة الطلب #55 الي تم التوصيل', 5, 55, 0, '2022-08-04 09:33:54', '2022-08-04 09:33:54', NULL, NULL, NULL),
(8359, 1000023, 'Order Status Change', 'تغيير حالة الطلب', 'Order #63 Status is now Delivered', 'تم تغيير حالة الطلب #63 الي تم التوصيل', 5, 63, 0, '2022-08-04 09:34:13', '2022-08-04 09:34:13', NULL, NULL, NULL),
(8360, 1000020, 'Order Status Change', 'تغيير حالة الطلب', 'Order #61 Status is now Delivered', 'تم تغيير حالة الطلب #61 الي تم التوصيل', 5, 61, 0, '2022-08-04 09:35:45', '2022-08-04 09:35:45', NULL, NULL, NULL),
(8361, 1000007, 'Order Status Change', 'تغيير حالة الطلب', 'Order #60 Status is now Delivered', 'تم تغيير حالة الطلب #60 الي تم التوصيل', 5, 60, 0, '2022-08-04 09:35:45', '2022-08-04 09:35:45', NULL, NULL, NULL),
(8362, 1000017, 'Order Status Change', 'تغيير حالة الطلب', 'Order #59 Status is now Delivered', 'تم تغيير حالة الطلب #59 الي تم التوصيل', 5, 59, 0, '2022-08-04 09:35:45', '2022-08-04 09:35:45', NULL, NULL, NULL),
(8363, 1000024, 'Order Status Change', 'تغيير حالة الطلب', 'Order #58 Status is now Delivered', 'تم تغيير حالة الطلب #58 الي تم التوصيل', 5, 58, 0, '2022-08-04 09:35:46', '2022-08-04 09:35:46', NULL, NULL, NULL),
(8364, 1000022, 'Order Status Change', 'تغيير حالة الطلب', 'Order #56 Status is now Delivered', 'تم تغيير حالة الطلب #56 الي تم التوصيل', 5, 56, 0, '2022-08-04 09:36:43', '2022-08-04 09:36:43', NULL, NULL, NULL),
(8365, 1000005, 'Order Status Change', 'تغيير حالة الطلب', 'Order #64 Status is now Cancelled', 'تم تغيير حالة الطلب #64 الي تم الالغاء', 5, 64, 1, '2022-08-04 10:33:28', '2022-10-08 22:14:39', NULL, NULL, NULL),
(8366, NULL, 'Order Cancelled', NULL, 'Customer 1000002 Has just cancelled order 62', NULL, NULL, NULL, 1, '2022-08-04 13:09:19', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8367, NULL, 'New Order', NULL, 'You have received a new order 65', NULL, NULL, NULL, 1, '2022-08-04 13:10:36', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8368, 1000002, 'Order Created', 'تم الطلب', 'Your order #65 is now Placed', 'حاله طلبك رقم #65 هي تم الطلب', 5, 65, 0, '2022-08-04 13:10:36', '2022-08-04 13:10:36', NULL, NULL, NULL),
(8369, 1000002, 'Order Status Change', 'تغيير حالة الطلب', 'Order #65 Status is now Confirmed', 'تم تغيير حالة الطلب #65 الي تم تأكيد الطلب', 5, 65, 0, '2022-08-04 13:19:45', '2022-08-04 13:19:45', NULL, NULL, NULL),
(8370, NULL, 'Order Cancelled', NULL, 'Customer 1000021 Has just cancelled order 54', NULL, NULL, NULL, 1, '2022-08-04 13:19:59', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8371, 1000021, 'Order Status Change', 'تغيير حالة الطلب', 'Order #54 Status is now Cancelled', 'تم تغيير حالة الطلب #54 الي تم الالغاء', 5, 54, 0, '2022-08-04 13:20:20', '2022-08-04 13:20:20', NULL, NULL, NULL),
(8372, NULL, 'New Order', NULL, 'You have received a new order 66', NULL, NULL, NULL, 1, '2022-08-04 13:20:29', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8373, 1000021, 'Order Created', 'تم الطلب', 'Your order #66 is now Placed', 'حاله طلبك رقم #66 هي تم الطلب', 5, 66, 0, '2022-08-04 13:20:29', '2022-08-04 13:20:29', NULL, NULL, NULL),
(8374, 1000021, 'Order Status Change', 'تغيير حالة الطلب', 'Order #66 Status is now Confirmed', 'تم تغيير حالة الطلب #66 الي تم تأكيد الطلب', 5, 66, 0, '2022-08-04 13:21:08', '2022-08-04 13:21:08', NULL, NULL, NULL),
(8375, NULL, 'Order Cancelled', NULL, 'Customer 1000002 Has just cancelled order 65', NULL, NULL, NULL, 1, '2022-08-04 13:28:38', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8376, NULL, 'New Order', NULL, 'You have received a new order 67', NULL, NULL, NULL, 1, '2022-08-04 13:30:40', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8377, 1000002, 'Order Created', 'تم الطلب', 'Your order #67 is now Placed', 'حاله طلبك رقم #67 هي تم الطلب', 5, 67, 0, '2022-08-04 13:30:40', '2022-08-04 13:30:40', NULL, NULL, NULL),
(8378, 1000002, 'Order Status Change', 'تغيير حالة الطلب', 'Order #67 Status is now Confirmed', 'تم تغيير حالة الطلب #67 الي تم تأكيد الطلب', 5, 67, 0, '2022-08-04 13:38:46', '2022-08-04 13:38:46', NULL, NULL, NULL),
(8379, NULL, 'New Order', NULL, 'You have received a new order 68', NULL, NULL, NULL, 1, '2022-08-04 14:04:31', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8380, 1000020, 'Order Created', 'تم الطلب', 'Your order #68 is now Placed', 'حاله طلبك رقم #68 هي تم الطلب', 5, 68, 0, '2022-08-04 14:04:32', '2022-08-04 14:04:32', NULL, NULL, NULL),
(8381, 1000020, 'Order Status Change', 'تغيير حالة الطلب', 'Order #68 Status is now Cancelled', 'تم تغيير حالة الطلب #68 الي تم الالغاء', 5, 68, 0, '2022-08-04 14:20:23', '2022-08-04 14:20:23', NULL, NULL, NULL),
(8382, NULL, 'New Order', NULL, 'You have received a new order 69', NULL, NULL, NULL, 1, '2022-08-04 14:22:38', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8383, 1000020, 'Order Created', 'تم الطلب', 'Your order #69 is now Placed', 'حاله طلبك رقم #69 هي تم الطلب', 5, 69, 0, '2022-08-04 14:22:38', '2022-08-04 14:22:38', NULL, NULL, NULL),
(8384, 1000020, 'Order Status Change', 'تغيير حالة الطلب', 'Order #69 Status is now Confirmed', 'تم تغيير حالة الطلب #69 الي تم تأكيد الطلب', 5, 69, 0, '2022-08-04 14:27:19', '2022-08-04 14:27:19', NULL, NULL, NULL),
(8385, NULL, 'New Order', NULL, 'You have received a new order 70', NULL, NULL, NULL, 1, '2022-08-04 15:51:27', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8386, 1000019, 'Order Created', 'تم الطلب', 'Your order #70 is now Placed', 'حاله طلبك رقم #70 هي تم الطلب', 5, 70, 0, '2022-08-04 15:51:27', '2022-08-04 15:51:27', NULL, NULL, NULL),
(8387, 1000019, 'Order Status Change', 'تغيير حالة الطلب', 'Order #70 Status is now Cancelled', 'تم تغيير حالة الطلب #70 الي تم الالغاء', 5, 70, 0, '2022-08-04 15:53:27', '2022-08-04 15:53:27', NULL, NULL, NULL),
(8388, NULL, 'New Order', NULL, 'You have received a new order 71', NULL, NULL, NULL, 1, '2022-08-06 03:53:31', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8389, 1000023, 'Order Created', 'تم الطلب', 'Your order #71 is now Placed', 'حاله طلبك رقم #71 هي تم الطلب', 5, 71, 0, '2022-08-06 03:53:32', '2022-08-06 03:53:32', NULL, NULL, NULL),
(8390, 1000023, 'Order Status Change', 'تغيير حالة الطلب', 'Order #71 Status is now Cancelled', 'تم تغيير حالة الطلب #71 الي تم الالغاء', 5, 71, 0, '2022-08-06 10:46:05', '2022-08-06 10:46:05', NULL, NULL, NULL),
(8391, NULL, 'New Order', NULL, 'You have received a new order 72', NULL, NULL, NULL, 1, '2022-08-06 10:56:35', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8392, 1000017, 'Order Created', 'تم الطلب', 'Your order #72 is now Placed', 'حاله طلبك رقم #72 هي تم الطلب', 5, 72, 0, '2022-08-06 10:56:35', '2022-08-06 10:56:35', NULL, NULL, NULL),
(8393, NULL, 'New Order', NULL, 'You have received a new order 73', NULL, NULL, NULL, 1, '2022-08-06 12:40:47', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8394, 1000008, 'Order Created', 'تم الطلب', 'Your order #73 is now Placed', 'حاله طلبك رقم #73 هي تم الطلب', 5, 73, 0, '2022-08-06 12:40:47', '2022-08-06 12:40:47', NULL, NULL, NULL),
(8395, NULL, 'Order Cancelled', NULL, 'Customer 1000002 Has just cancelled order 67', NULL, NULL, NULL, 1, '2022-08-06 13:32:48', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8396, NULL, 'New Order', NULL, 'You have received a new order 74', NULL, NULL, NULL, 1, '2022-08-06 13:33:44', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8397, 1000002, 'Order Created', 'تم الطلب', 'Your order #74 is now Placed', 'حاله طلبك رقم #74 هي تم الطلب', 5, 74, 0, '2022-08-06 13:33:44', '2022-08-06 13:33:44', NULL, NULL, NULL),
(8398, NULL, 'New Order', NULL, 'You have received a new order 75', NULL, NULL, NULL, 1, '2022-08-06 14:39:19', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8399, 1000024, 'Order Created', 'تم الطلب', 'Your order #75 is now Placed', 'حاله طلبك رقم #75 هي تم الطلب', 5, 75, 0, '2022-08-06 14:39:19', '2022-08-06 14:39:19', NULL, NULL, NULL),
(8400, 1000002, 'Order Status Change', 'تغيير حالة الطلب', 'Order #74 Status is now Confirmed', 'تم تغيير حالة الطلب #74 الي تم تأكيد الطلب', 5, 74, 0, '2022-08-06 14:39:57', '2022-08-06 14:39:57', NULL, NULL, NULL),
(8401, 1000024, 'Order Status Change', 'تغيير حالة الطلب', 'Order #75 Status is now Confirmed', 'تم تغيير حالة الطلب #75 الي تم تأكيد الطلب', 5, 75, 0, '2022-08-06 14:40:21', '2022-08-06 14:40:21', NULL, NULL, NULL),
(8402, NULL, 'Order Cancelled', NULL, 'Customer 1000008 Has just cancelled order 73', NULL, NULL, NULL, 1, '2022-08-06 14:42:22', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8403, NULL, 'New Order', NULL, 'You have received a new order 76', NULL, NULL, NULL, 1, '2022-08-06 14:43:21', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8404, 1000008, 'Order Created', 'تم الطلب', 'Your order #76 is now Placed', 'حاله طلبك رقم #76 هي تم الطلب', 5, 76, 0, '2022-08-06 14:43:21', '2022-08-06 14:43:21', NULL, NULL, NULL),
(8405, 1000008, 'Order Status Change', 'تغيير حالة الطلب', 'Order #73 Status is now Cancelled', 'تم تغيير حالة الطلب #73 الي تم الالغاء', 5, 73, 0, '2022-08-06 15:03:15', '2022-08-06 15:03:15', NULL, NULL, NULL),
(8406, NULL, 'New Order', NULL, 'You have received a new order 77', NULL, NULL, NULL, 1, '2022-08-06 15:03:23', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8407, 1000023, 'Order Created', 'تم الطلب', 'Your order #77 is now Placed', 'حاله طلبك رقم #77 هي تم الطلب', 5, 77, 0, '2022-08-06 15:03:23', '2022-08-06 15:03:23', NULL, NULL, NULL),
(8408, 1000008, 'Order Status Change', 'تغيير حالة الطلب', 'Order #76 Status is now Confirmed', 'تم تغيير حالة الطلب #76 الي تم تأكيد الطلب', 5, 76, 0, '2022-08-06 15:34:14', '2022-08-06 15:34:14', NULL, NULL, NULL),
(8409, 1000017, 'Order Status Change', 'تغيير حالة الطلب', 'Order #72 Status is now Cancelled', 'تم تغيير حالة الطلب #72 الي تم الالغاء', 5, 72, 0, '2022-08-07 08:44:30', '2022-08-07 08:44:30', NULL, NULL, NULL),
(8410, 1000008, 'Order Status Change', 'تغيير حالة الطلب', 'Order #76 Status is now Delivered', 'تم تغيير حالة الطلب #76 الي تم التوصيل', 5, 76, 0, '2022-08-07 10:39:18', '2022-08-07 10:39:18', NULL, NULL, NULL),
(8411, 1000024, 'Order Status Change', 'تغيير حالة الطلب', 'Order #75 Status is now Delivered', 'تم تغيير حالة الطلب #75 الي تم التوصيل', 5, 75, 0, '2022-08-07 10:39:18', '2022-08-07 10:39:18', NULL, NULL, NULL),
(8412, 1000023, 'Order Status Change', 'تغيير حالة الطلب', 'Order #77 Status is now Confirmed', 'تم تغيير حالة الطلب #77 الي تم تأكيد الطلب', 5, 77, 0, '2022-08-07 10:51:15', '2022-08-07 10:51:15', NULL, NULL, NULL),
(8413, 1, 'File Exported ', NULL, 'Your export has completed! You can download the file from', NULL, 11, 0, 1, '2022-08-08 11:53:58', '2022-09-13 14:00:51', NULL, 'https://10.51.0.5/storage/exports/orders/Order_by_Admin_2022_08_08 11_53_56.xlsx', NULL),
(8414, NULL, 'Order Cancelled', NULL, 'Customer 1000023 Has just cancelled order 77', NULL, NULL, NULL, 1, '2022-08-08 12:30:16', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8415, NULL, 'New Order', NULL, 'You have received a new order 78', NULL, NULL, NULL, 1, '2022-08-08 14:00:27', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8416, 1000023, 'Order Created', 'تم الطلب', 'Your order #78 is now Placed', 'حاله طلبك رقم #78 هي تم الطلب', 5, 78, 0, '2022-08-08 14:00:27', '2022-08-08 14:00:27', NULL, NULL, NULL),
(8417, NULL, 'Order Rating', NULL, 'Order ID 24 is rated 2', NULL, NULL, NULL, 1, '2022-08-08 14:08:33', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8418, NULL, 'Order Rating', NULL, 'Order ID 15 is rated 1', NULL, NULL, NULL, 1, '2022-08-08 14:08:45', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8419, NULL, 'Order Rating', NULL, 'Order ID 57 is rated 1', NULL, NULL, NULL, 1, '2022-08-08 14:09:12', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8420, 1000023, 'Order Status Change', 'تغيير حالة الطلب', 'Order #78 Status is now Cancelled', 'تم تغيير حالة الطلب #78 الي تم الالغاء', 5, 78, 0, '2022-08-08 14:12:57', '2022-08-08 14:12:57', NULL, NULL, NULL),
(8421, 1000002, 'Order Status Change', 'تغيير حالة الطلب', 'Order #74 Status is now Delivered', 'تم تغيير حالة الطلب #74 الي تم التوصيل', 5, 74, 0, '2022-08-09 11:12:16', '2022-08-09 11:12:16', NULL, NULL, NULL),
(8422, 1000021, 'Order Status Change', 'تغيير حالة الطلب', 'Order #66 Status is now Cancelled', 'تم تغيير حالة الطلب #66 الي تم الالغاء', 5, 66, 0, '2022-08-09 11:27:53', '2022-08-09 11:27:53', NULL, NULL, NULL),
(8423, 1000020, 'Order Status Change', 'تغيير حالة الطلب', 'Order #69 Status is now Cancelled', 'تم تغيير حالة الطلب #69 الي تم الالغاء', 5, 69, 0, '2022-08-09 11:28:28', '2022-08-09 11:28:28', NULL, NULL, NULL),
(8424, NULL, 'New Order', NULL, 'You have received a new order 79', NULL, NULL, NULL, 1, '2022-08-09 13:34:18', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8425, 1000002, 'Order Created', 'تم الطلب', 'Your order #79 is now Placed', 'حاله طلبك رقم #79 هي تم الطلب', 5, 79, 0, '2022-08-09 13:34:18', '2022-08-09 13:34:18', NULL, NULL, NULL),
(8426, NULL, 'New Order', NULL, 'You have received a new order 80', NULL, NULL, NULL, 1, '2022-08-09 14:03:53', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8427, 1000024, 'Order Created', 'تم الطلب', 'Your order #80 is now Placed', 'حاله طلبك رقم #80 هي تم الطلب', 5, 80, 0, '2022-08-09 14:03:53', '2022-08-09 14:03:53', NULL, NULL, NULL),
(8428, 1000002, 'Order Status Change', 'تغيير حالة الطلب', 'Order #79 Status is now Confirmed', 'تم تغيير حالة الطلب #79 الي تم تأكيد الطلب', 5, 79, 0, '2022-08-09 14:16:31', '2022-08-09 14:16:31', NULL, NULL, NULL),
(8429, 1000024, 'Order Status Change', 'تغيير حالة الطلب', 'Order #80 Status is now Confirmed', 'تم تغيير حالة الطلب #80 الي تم تأكيد الطلب', 5, 80, 0, '2022-08-09 14:17:06', '2022-08-09 14:17:06', NULL, NULL, NULL),
(8430, 1000002, 'Order Status Change', 'تغيير حالة الطلب', 'Order #67 Status is now Cancelled', 'تم تغيير حالة الطلب #67 الي تم الالغاء', 5, 67, 0, '2022-08-09 14:34:38', '2022-08-09 14:34:38', NULL, NULL, NULL),
(8431, 1000002, 'Order Status Change', 'تغيير حالة الطلب', 'Order #65 Status is now Cancelled', 'تم تغيير حالة الطلب #65 الي تم الالغاء', 5, 65, 0, '2022-08-09 14:38:39', '2022-08-09 14:38:39', NULL, NULL, NULL),
(8432, NULL, 'New Order', NULL, 'You have received a new order 81', NULL, NULL, NULL, 1, '2022-08-09 16:52:51', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8433, 1000019, 'Order Created', 'تم الطلب', 'Your order #81 is now Placed', 'حاله طلبك رقم #81 هي تم الطلب', 5, 81, 0, '2022-08-09 16:52:51', '2022-08-09 16:52:51', NULL, NULL, NULL),
(8434, 1000019, 'Order Status Change', 'تغيير حالة الطلب', 'Order #81 Status is now Confirmed', 'تم تغيير حالة الطلب #81 الي تم تأكيد الطلب', 5, 81, 0, '2022-08-09 16:55:30', '2022-08-09 16:55:30', NULL, NULL, NULL),
(8435, 1000002, 'Order Status Change', 'تغيير حالة الطلب', 'Order #79 Status is now Delivered', 'تم تغيير حالة الطلب #79 الي تم التوصيل', 5, 79, 0, '2022-08-10 12:49:54', '2022-08-10 12:49:54', NULL, NULL, NULL),
(8436, 1000002, 'Order Status Change', 'تغيير حالة الطلب', 'Order #79 Status is now Returned', 'تم تغيير حالة الطلب #79 الي تم الاسترجاع', 5, 79, 0, '2022-08-10 12:57:09', '2022-08-10 12:57:09', NULL, NULL, NULL),
(8437, NULL, 'New Order', NULL, 'You have received a new order 82', NULL, NULL, NULL, 1, '2022-08-10 13:01:03', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8438, 1000002, 'Order Created', 'تم الطلب', 'Your order #82 is now Placed', 'حاله طلبك رقم #82 هي تم الطلب', 5, 82, 0, '2022-08-10 13:01:03', '2022-08-10 13:01:03', NULL, NULL, NULL),
(8439, 1000002, 'Order Status Change', 'تغيير حالة الطلب', 'Order #82 Status is now Confirmed', 'تم تغيير حالة الطلب #82 الي تم تأكيد الطلب', 5, 82, 0, '2022-08-10 13:02:16', '2022-08-10 13:02:16', NULL, NULL, NULL),
(8440, NULL, 'New Order', NULL, 'You have received a new order 83', NULL, NULL, NULL, 1, '2022-08-10 15:01:32', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8441, 1000011, 'Order Created', 'تم الطلب', 'Your order #83 is now Placed', 'حاله طلبك رقم #83 هي تم الطلب', 5, 83, 0, '2022-08-10 15:01:33', '2022-08-10 15:01:33', NULL, NULL, NULL),
(8442, NULL, 'Order Cancelled', NULL, 'Customer 1000011 Has just cancelled order 83', NULL, NULL, NULL, 1, '2022-08-10 15:01:59', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8443, NULL, 'New Order', NULL, 'You have received a new order 84', NULL, NULL, NULL, 1, '2022-08-13 04:07:09', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8444, 1000003, 'Order Created', 'تم الطلب', 'Your order #84 is now Placed', 'حاله طلبك رقم #84 هي تم الطلب', 5, 84, 0, '2022-08-13 04:07:10', '2022-08-13 04:07:10', NULL, NULL, NULL),
(8445, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #84 Status is now Confirmed', 'تم تغيير حالة الطلب #84 الي تم تأكيد الطلب', 5, 84, 0, '2022-08-13 19:04:37', '2022-08-13 19:04:37', NULL, NULL, NULL),
(8446, NULL, 'Order Cancelled', NULL, 'Customer 1000002 Has just cancelled order 82', NULL, NULL, NULL, 1, '2022-08-14 10:52:06', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8447, NULL, 'New Order', NULL, 'You have received a new order 85', NULL, NULL, NULL, 1, '2022-08-14 10:57:41', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8448, 1000002, 'Order Created', 'تم الطلب', 'Your order #85 is now Placed', 'حاله طلبك رقم #85 هي تم الطلب', 5, 85, 0, '2022-08-14 10:57:41', '2022-08-14 10:57:41', NULL, NULL, NULL),
(8449, 1000002, 'Order Status Change', 'تغيير حالة الطلب', 'Order #85 Status is now Confirmed', 'تم تغيير حالة الطلب #85 الي تم تأكيد الطلب', 5, 85, 0, '2022-08-14 12:18:32', '2022-08-14 12:18:32', NULL, NULL, NULL),
(8450, 1000002, 'Order Status Change', 'تغيير حالة الطلب', 'Order #85 Status is now Cancelled', 'تم تغيير حالة الطلب #85 الي تم الالغاء', 5, 85, 0, '2022-08-14 12:24:28', '2022-08-14 12:24:28', NULL, NULL, NULL),
(8451, NULL, 'Order Cancelled', NULL, 'Customer 1000002 Has just cancelled order 85', NULL, NULL, NULL, 1, '2022-08-14 12:24:55', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8452, NULL, 'New Order', NULL, 'You have received a new order 86', NULL, NULL, NULL, 1, '2022-08-14 12:26:17', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8453, 1000002, 'Order Created', 'تم الطلب', 'Your order #86 is now Placed', 'حاله طلبك رقم #86 هي تم الطلب', 5, 86, 0, '2022-08-14 12:26:17', '2022-08-14 12:26:17', NULL, NULL, NULL),
(8454, 1000002, 'Order Status Change', 'تغيير حالة الطلب', 'Order #86 Status is now Confirmed', 'تم تغيير حالة الطلب #86 الي تم تأكيد الطلب', 5, 86, 0, '2022-08-14 12:33:14', '2022-08-14 12:33:14', NULL, NULL, NULL),
(8455, 1, 'File Exported ', NULL, 'Your export has completed! You can download the file from', NULL, 11, 0, 1, '2022-08-14 12:35:38', '2022-09-13 14:00:51', NULL, 'https://10.51.0.5/storage/exports/products/Product_sales_20220814123537.xlsx', NULL),
(8456, 1000002, 'Order Status Change', 'تغيير حالة الطلب', 'Order #86 Status is now Delivered', 'تم تغيير حالة الطلب #86 الي تم التوصيل', 5, 86, 0, '2022-08-14 18:13:51', '2022-08-14 18:13:51', NULL, NULL, NULL),
(8457, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #84 Status is now Delivered', 'تم تغيير حالة الطلب #84 الي تم التوصيل', 5, 84, 0, '2022-08-14 18:14:06', '2022-08-14 18:14:06', NULL, NULL, NULL),
(8458, 1000002, 'Order Status Change', 'تغيير حالة الطلب', 'Order #62 Status is now Cancelled', 'تم تغيير حالة الطلب #62 الي تم الالغاء', 5, 62, 0, '2022-08-15 15:09:46', '2022-08-15 15:09:46', NULL, NULL, NULL),
(8459, NULL, 'New Order', NULL, 'You have received a new order 87', NULL, NULL, NULL, 1, '2022-08-15 15:20:33', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8460, 1000002, 'Order Created', 'تم الطلب', 'Your order #87 is now Placed', 'حاله طلبك رقم #87 هي تم الطلب', 5, 87, 0, '2022-08-15 15:20:34', '2022-08-15 15:20:34', NULL, NULL, NULL),
(8461, 1000002, 'Order Status Change', 'تغيير حالة الطلب', 'Order #87 Status is now Confirmed', 'تم تغيير حالة الطلب #87 الي تم تأكيد الطلب', 5, 87, 0, '2022-08-15 15:21:26', '2022-08-15 15:21:26', NULL, NULL, NULL),
(8462, NULL, 'New Order', NULL, 'You have received a new order 88', NULL, NULL, NULL, 1, '2022-08-17 21:54:55', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8463, 1000003, 'Order Created', 'تم الطلب', 'Your order #88 is now Placed', 'حاله طلبك رقم #88 هي تم الطلب', 5, 88, 0, '2022-08-17 21:54:55', '2022-08-17 21:54:55', NULL, NULL, NULL),
(8464, NULL, 'Order Cancelled', NULL, 'Customer 1000002 Has just cancelled order 87', NULL, NULL, NULL, 1, '2022-08-18 07:55:33', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8465, NULL, 'New Order', NULL, 'You have received a new order 89', NULL, NULL, NULL, 1, '2022-08-18 07:56:48', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8466, 1000002, 'Order Created', 'تم الطلب', 'Your order #89 is now Placed', 'حاله طلبك رقم #89 هي تم الطلب', 5, 89, 0, '2022-08-18 07:56:48', '2022-08-18 07:56:48', NULL, NULL, NULL),
(8467, 1000002, 'Order Status Change', 'تغيير حالة الطلب', 'Order #89 Status is now Confirmed', 'تم تغيير حالة الطلب #89 الي تم تأكيد الطلب', 5, 89, 0, '2022-08-18 09:26:23', '2022-08-18 09:26:23', NULL, NULL, NULL),
(8468, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #88 Status is now Cancelled', 'تم تغيير حالة الطلب #88 الي تم الالغاء', 5, 88, 0, '2022-08-18 09:31:03', '2022-08-18 09:31:03', NULL, NULL, NULL),
(8469, NULL, 'Order Cancelled', NULL, 'Customer 1000002 Has just cancelled order 89', NULL, NULL, NULL, 1, '2022-08-20 17:48:36', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8470, NULL, 'New Order', NULL, 'You have received a new order 90', NULL, NULL, NULL, 1, '2022-08-20 17:49:31', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8471, 1000002, 'Order Created', 'تم الطلب', 'Your order #90 is now Placed', 'حاله طلبك رقم #90 هي تم الطلب', 5, 90, 0, '2022-08-20 17:49:31', '2022-08-20 17:49:31', NULL, NULL, NULL),
(8472, 1000002, 'Order Status Change', 'تغيير حالة الطلب', 'Order #87 Status is now Cancelled', 'تم تغيير حالة الطلب #87 الي تم الالغاء', 5, 87, 0, '2022-08-21 08:57:58', '2022-08-21 08:57:58', NULL, NULL, NULL),
(8473, 1000002, 'Order Status Change', 'تغيير حالة الطلب', 'Order #89 Status is now Cancelled', 'تم تغيير حالة الطلب #89 الي تم الالغاء', 5, 89, 0, '2022-08-21 08:58:24', '2022-08-21 08:58:24', NULL, NULL, NULL),
(8474, 1000002, 'Order Status Change', 'تغيير حالة الطلب', 'Order #90 Status is now Confirmed', 'تم تغيير حالة الطلب #90 الي تم تأكيد الطلب', 5, 90, 0, '2022-08-21 08:58:51', '2022-08-21 08:58:51', NULL, NULL, NULL),
(8475, 1000002, 'Order Status Change', 'تغيير حالة الطلب', 'Order #85 Status is now Cancelled', 'تم تغيير حالة الطلب #85 الي تم الالغاء', 5, 85, 0, '2022-08-21 08:59:27', '2022-08-21 08:59:27', NULL, NULL, NULL),
(8476, NULL, 'Order Cancelled', NULL, 'Customer 1000002 Has just cancelled order 90', NULL, NULL, NULL, 1, '2022-08-21 12:34:56', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8477, NULL, 'New Order', NULL, 'You have received a new order 91', NULL, NULL, NULL, 1, '2022-08-21 12:36:54', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8478, 1000002, 'Order Created', 'تم الطلب', 'Your order #91 is now Placed', 'حاله طلبك رقم #91 هي تم الطلب', 5, 91, 0, '2022-08-21 12:36:54', '2022-08-21 12:36:54', NULL, NULL, NULL),
(8479, 1000002, 'Order Status Change', 'تغيير حالة الطلب', 'Order #90 Status is now Cancelled', 'تم تغيير حالة الطلب #90 الي تم الالغاء', 5, 90, 0, '2022-08-21 12:39:10', '2022-08-21 12:39:10', NULL, NULL, NULL),
(8480, 1000002, 'Order Status Change', 'تغيير حالة الطلب', 'Order #91 Status is now Confirmed', 'تم تغيير حالة الطلب #91 الي تم تأكيد الطلب', 5, 91, 0, '2022-08-21 12:39:58', '2022-08-21 12:39:58', NULL, NULL, NULL),
(8481, 1000002, 'Order Status Change', 'تغيير حالة الطلب', 'Order #82 Status is now Cancelled', 'تم تغيير حالة الطلب #82 الي تم الالغاء', 5, 82, 0, '2022-08-21 16:23:41', '2022-08-21 16:23:41', NULL, NULL, NULL),
(8482, 1000002, 'Order Status Change', 'تغيير حالة الطلب', 'Order #8 Status is now Cancelled', 'تم تغيير حالة الطلب #8 الي تم الالغاء', 5, 8, 0, '2022-08-21 16:24:13', '2022-08-21 16:24:13', NULL, NULL, NULL),
(8483, 1000002, 'Order Status Change', 'تغيير حالة الطلب', 'Order #62 Status is now Cancelled', 'تم تغيير حالة الطلب #62 الي تم الالغاء', 5, 62, 0, '2022-08-21 16:24:23', '2022-08-21 16:24:23', NULL, NULL, NULL),
(8484, 1000002, 'Order Status Change', 'تغيير حالة الطلب', 'Order #91 Status is now Delivered', 'تم تغيير حالة الطلب #91 الي تم التوصيل', 5, 91, 0, '2022-08-21 17:12:39', '2022-08-21 17:12:39', NULL, NULL, NULL),
(8485, 1000023, 'Order Status Change', 'تغيير حالة الطلب', 'Order #77 Status is now Cancelled', 'تم تغيير حالة الطلب #77 الي تم الالغاء', 5, 77, 0, '2022-08-21 17:13:09', '2022-08-21 17:13:09', NULL, NULL, NULL),
(8486, NULL, 'New Order', NULL, 'You have received a new order 92', NULL, NULL, NULL, 1, '2022-08-22 04:18:07', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8487, 1000003, 'Order Created', 'تم الطلب', 'Your order #92 is now Placed', 'حاله طلبك رقم #92 هي تم الطلب', 5, 92, 0, '2022-08-22 04:18:07', '2022-08-22 04:18:07', NULL, NULL, NULL),
(8488, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #92 Status is now Confirmed', 'تم تغيير حالة الطلب #92 الي تم تأكيد الطلب', 5, 92, 0, '2022-08-22 15:30:28', '2022-08-22 15:30:28', NULL, NULL, NULL),
(8489, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #92 Status is now Delivered', 'تم تغيير حالة الطلب #92 الي تم التوصيل', 5, 92, 0, '2022-08-23 16:30:50', '2022-08-23 16:30:50', NULL, NULL, NULL),
(8490, NULL, 'New Order', NULL, 'You have received a new order 93', NULL, NULL, NULL, 1, '2022-08-29 15:52:57', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8491, 1000003, 'Order Created', 'تم الطلب', 'Your order #93 is now Placed', 'حاله طلبك رقم #93 هي تم الطلب', 5, 93, 0, '2022-08-29 15:52:58', '2022-08-29 15:52:58', NULL, NULL, NULL),
(8492, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #93 Status is now Confirmed', 'تم تغيير حالة الطلب #93 الي تم تأكيد الطلب', 5, 93, 0, '2022-08-31 10:08:26', '2022-08-31 10:08:26', NULL, NULL, NULL),
(8493, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #93 Status is now Delivered', 'تم تغيير حالة الطلب #93 الي تم التوصيل', 5, 93, 0, '2022-08-31 16:51:49', '2022-08-31 16:51:49', NULL, NULL, NULL),
(8494, 1, 'File Exported ', NULL, 'Your export has completed! You can download the file from', NULL, 11, 0, 1, '2022-09-04 12:55:33', '2022-09-13 14:00:51', NULL, 'https://10.51.0.5/storage/exports/products/Product_sales_20220904125531.xlsx', NULL),
(8495, 1, 'File Exported ', NULL, 'Your export has completed! You can download the file from', NULL, 11, 0, 1, '2022-09-04 12:56:01', '2022-09-13 14:00:51', NULL, 'https://10.51.0.5/storage/exports/orders/Order_by_Admin_2022_09_04 12_56_00.xlsx', NULL),
(8496, 1, 'File Exported ', NULL, 'Your export has completed! You can download the file from', NULL, 11, 0, 1, '2022-09-04 13:00:22', '2022-09-13 14:00:51', NULL, 'https://10.51.0.5/storage/exports/orders/Order_by_Admin_2022_09_04 13_00_21.xlsx', NULL),
(8497, 1, 'File Exported ', NULL, 'Your export has completed! You can download the file from', NULL, 11, 0, 1, '2022-09-04 13:00:34', '2022-09-13 14:00:51', NULL, 'https://10.51.0.5/storage/exports/products/Product_sales_20220904130033.xlsx', NULL),
(8498, 1, 'File Exported ', NULL, 'Your export has completed! You can download the file from', NULL, 11, 0, 1, '2022-09-04 13:04:36', '2022-09-13 14:00:51', NULL, 'https://10.51.0.5/storage/exports/orders/Order_by_Admin_2022_09_04 13_04_35.xlsx', NULL);
INSERT INTO `notifications` (`id`, `user_id`, `title`, `title_ar`, `body`, `body_ar`, `type`, `item_id`, `read`, `created_at`, `updated_at`, `image`, `details`, `item_link`) VALUES
(8499, NULL, 'New Order', NULL, 'You have received a new order 94', NULL, NULL, NULL, 1, '2022-09-11 06:05:47', '2022-10-30 09:21:40', NULL, NULL, NULL),
(8500, 1000003, 'Order Created', 'تم الطلب', 'Your order #94 is now Placed', 'حاله طلبك رقم #94 هي تم الطلب', 5, 94, 0, '2022-09-11 06:05:48', '2022-09-11 06:05:48', NULL, NULL, NULL),
(8501, 1000003, 'Order Status Change', 'تغيير حالة الطلب', 'Order #94 Status is now Confirmed', 'تم تغيير حالة الطلب #94 الي تم تأكيد الطلب', 5, 94, 0, '2022-09-13 13:37:54', '2022-09-13 13:37:54', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE `options` (
  `id` int(10) UNSIGNED NOT NULL,
  `name_en` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name_ar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description_en` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description_ar` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` enum('1','2','3','4','5') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `appear_in_search` tinyint(1) NOT NULL DEFAULT 1,
  `appear_on_product_details` tinyint(1) NOT NULL DEFAULT 1,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `order` smallint(6) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`id`, `name_en`, `name_ar`, `description_en`, `description_ar`, `type`, `created_by`, `created_at`, `updated_at`, `appear_in_search`, `appear_on_product_details`, `active`, `order`) VALUES
(1044, 'test option en 1', 'test option ar 1', 'test option description en 1', 'test option description ar 1', '3', NULL, '2021-12-14 14:35:36', '2022-01-12 19:36:01', 1, 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `option_values`
--

CREATE TABLE `option_values` (
  `id` int(10) UNSIGNED NOT NULL,
  `name_en` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name_ar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `option_id` int(10) UNSIGNED NOT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `deliverer_id` int(10) UNSIGNED DEFAULT NULL,
  `state_id` int(10) UNSIGNED DEFAULT NULL,
  `paid_amount` int(11) DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rate` int(11) DEFAULT NULL,
  `payment_method` int(11) NOT NULL,
  `payment_installment_id` bigint(20) UNSIGNED DEFAULT NULL,
  `cancellation_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `customer_rate` int(11) DEFAULT NULL,
  `address_id` int(10) UNSIGNED DEFAULT NULL,
  `feedback` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unique_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `success_indicator` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scheduled_at` datetime DEFAULT NULL,
  `parent_id` int(10) UNSIGNED DEFAULT NULL,
  `referal` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fawry_ref` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sub_state_id` int(10) UNSIGNED DEFAULT NULL,
  `admin_notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `source` enum('1','2','3') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_id` bigint(20) UNSIGNED DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `admin_id` int(10) UNSIGNED DEFAULT NULL,
  `cancellation_text` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_ip` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `affiliate_id` int(10) UNSIGNED DEFAULT NULL,
  `promotion_discount` decimal(8,2) DEFAULT NULL,
  `wallet_redeem` decimal(8,2) NOT NULL DEFAULT 0.00,
  `cashback_amount` decimal(8,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `deliverer_id`, `state_id`, `paid_amount`, `notes`, `rate`, `payment_method`, `payment_installment_id`, `cancellation_id`, `created_at`, `updated_at`, `customer_rate`, `address_id`, `feedback`, `unique_id`, `success_indicator`, `scheduled_at`, `parent_id`, `referal`, `fawry_ref`, `sub_state_id`, `admin_notes`, `source`, `transaction_id`, `phone`, `user_agent`, `admin_id`, `cancellation_text`, `user_ip`, `affiliate_id`, `promotion_discount`, `wallet_redeem`, `cashback_amount`) VALUES
(1, 1, NULL, 4, NULL, NULL, NULL, 1, NULL, NULL, '2022-07-20 13:58:48', '2022-07-21 14:26:04', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01555453673', 'android', NULL, NULL, '10.51.0.213', NULL, NULL, '0.00', '0.00'),
(2, 1000006, NULL, 6, NULL, NULL, NULL, 1, NULL, NULL, '2022-07-21 09:31:41', '2022-07-21 09:36:02', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01020099053', 'android', NULL, NULL, '10.51.0.213', NULL, NULL, '0.00', '0.00'),
(3, 1000006, NULL, 4, NULL, NULL, 5, 1, NULL, NULL, '2022-07-21 09:37:29', '2022-07-26 17:18:18', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01020099053', 'android', NULL, NULL, '10.51.0.214', NULL, NULL, '0.00', '0.00'),
(4, 1000006, NULL, 4, NULL, NULL, 5, 1, NULL, NULL, '2022-07-23 12:55:22', '2022-07-26 17:17:50', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01020099053', 'android', NULL, NULL, '10.51.0.214', NULL, NULL, '0.00', '0.00'),
(5, 1000008, NULL, 4, NULL, NULL, NULL, 1, NULL, NULL, '2022-07-24 08:51:02', '2022-07-25 07:18:40', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01228654444', 'android', NULL, NULL, '10.51.0.214', NULL, NULL, '0.00', '0.00'),
(6, 1000008, NULL, 6, NULL, NULL, NULL, 1, NULL, NULL, '2022-07-25 08:47:03', '2022-07-25 08:56:06', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01228654444', 'android', NULL, NULL, '10.51.0.214', NULL, NULL, '0.00', '0.00'),
(7, 1000008, NULL, 6, NULL, NULL, NULL, 1, NULL, NULL, '2022-07-25 08:56:44', '2022-07-26 10:00:28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01228654444', 'android', NULL, NULL, '10.51.0.213', NULL, NULL, '0.00', '0.00'),
(8, 1000002, NULL, 6, NULL, NULL, NULL, 1, NULL, NULL, '2022-07-25 10:21:18', '2022-07-25 10:31:45', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01555453673', 'android', NULL, NULL, '10.51.0.214', NULL, NULL, '0.00', '0.00'),
(9, 1000002, NULL, 4, NULL, NULL, NULL, 1, NULL, NULL, '2022-07-25 10:44:07', '2022-07-26 11:33:39', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01555453673', 'android', NULL, NULL, '10.51.0.214', NULL, NULL, '0.00', '0.00'),
(10, 1000006, NULL, 6, NULL, NULL, NULL, 1, NULL, NULL, '2022-07-25 13:40:30', '2022-07-26 09:57:31', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01020099053', 'android', NULL, NULL, '10.51.0.213', NULL, NULL, '0.00', '0.00'),
(11, 1000003, NULL, 6, NULL, NULL, NULL, 1, NULL, NULL, '2022-07-26 02:54:22', '2022-07-26 02:57:25', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01095150281', 'android', NULL, NULL, '10.51.0.214', NULL, NULL, '0.00', '0.00'),
(12, 1000003, NULL, 6, NULL, NULL, NULL, 1, NULL, NULL, '2022-07-26 02:59:15', '2022-07-26 10:40:15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01095150281', 'android', NULL, NULL, '10.51.0.214', NULL, NULL, '0.00', '0.00'),
(13, 1000006, NULL, 4, NULL, NULL, NULL, 1, NULL, NULL, '2022-07-26 09:57:45', '2022-07-27 15:58:43', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01020099053', 'android', NULL, NULL, '10.51.0.214', NULL, NULL, '0.00', '0.00'),
(14, 1000008, NULL, 4, NULL, NULL, 1, 1, NULL, NULL, '2022-07-26 10:00:59', '2022-07-27 13:58:36', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01228654444', 'android', NULL, NULL, '10.51.0.214', NULL, NULL, '0.00', '0.00'),
(15, 1000003, NULL, 4, NULL, NULL, 1, 1, NULL, NULL, '2022-07-26 10:42:00', '2022-08-08 12:08:45', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01095150281', 'android', NULL, NULL, '10.51.0.213', NULL, NULL, '0.00', '0.00'),
(16, 1000008, NULL, 6, NULL, NULL, NULL, 1, NULL, NULL, '2022-07-27 13:59:25', '2022-07-28 09:48:45', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01228654444', 'android', NULL, NULL, '10.51.0.214', NULL, NULL, '0.00', '0.00'),
(17, 1000002, NULL, 4, NULL, NULL, NULL, 1, NULL, NULL, '2022-07-27 15:06:04', '2022-07-31 08:02:18', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01555453673', 'android', NULL, NULL, '10.51.0.214', NULL, NULL, '0.00', '0.00'),
(18, 1000003, NULL, 4, NULL, NULL, 5, 1, NULL, NULL, '2022-07-27 16:14:06', '2022-07-31 15:03:40', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01095150281', 'android', NULL, NULL, '10.51.0.214', NULL, NULL, '0.00', '0.00'),
(19, 1000005, NULL, 6, NULL, NULL, NULL, 1, NULL, NULL, '2022-07-27 22:37:25', '2022-07-28 10:16:50', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01222267740', 'android', NULL, NULL, '10.51.0.213', NULL, NULL, '0.00', '0.00'),
(20, 1000008, NULL, 4, NULL, NULL, NULL, 1, NULL, NULL, '2022-07-28 10:12:47', '2022-07-31 08:02:18', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01228654444', 'android', NULL, NULL, '10.51.0.214', NULL, NULL, '0.00', '0.00'),
(21, 1000005, NULL, 4, NULL, NULL, NULL, 1, NULL, NULL, '2022-07-28 10:17:39', '2022-07-31 08:02:18', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01222267740', 'android', NULL, NULL, '10.51.0.213', NULL, NULL, '0.00', '0.00'),
(22, 1000006, NULL, 4, NULL, NULL, NULL, 1, NULL, NULL, '2022-07-28 11:48:59', '2022-07-31 08:02:16', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01020099053', 'android', NULL, NULL, '10.51.0.214', NULL, NULL, '0.00', '0.00'),
(23, 1000003, NULL, 6, NULL, NULL, NULL, 1, NULL, NULL, '2022-07-29 02:14:10', '2022-07-30 14:23:03', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01095150281', 'android', NULL, NULL, '10.51.0.213', NULL, NULL, '0.00', '0.00'),
(24, 1000003, NULL, 4, NULL, NULL, 2, 1, NULL, NULL, '2022-07-30 14:24:53', '2022-08-08 12:08:33', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01095150281', 'android', NULL, NULL, '10.51.0.214', NULL, NULL, '0.00', '0.00'),
(25, 1000021, NULL, 6, NULL, NULL, NULL, 1, NULL, NULL, '2022-07-31 09:51:29', '2022-07-31 10:57:46', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01000600603', 'android', NULL, NULL, '10.51.0.213', NULL, NULL, '0.00', '0.00'),
(26, 1000008, NULL, 4, NULL, NULL, NULL, 1, NULL, NULL, '2022-07-31 11:14:18', '2022-08-01 11:04:10', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01228654444', 'android', NULL, NULL, '10.51.0.214', NULL, NULL, '0.00', '0.00'),
(27, 1000021, NULL, 4, NULL, NULL, NULL, 1, NULL, NULL, '2022-07-31 11:19:06', '2022-08-01 11:05:53', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01000600603', 'android', NULL, NULL, '10.51.0.214', NULL, NULL, '0.00', '0.00'),
(28, 1000006, NULL, 6, NULL, NULL, NULL, 1, NULL, NULL, '2022-07-31 15:05:39', '2022-07-31 15:21:01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01020099053', 'android', NULL, NULL, '10.51.0.213', NULL, NULL, '0.00', '0.00'),
(29, 1000006, NULL, 7, NULL, NULL, NULL, 1, NULL, NULL, '2022-07-31 15:21:44', '2022-08-01 12:35:17', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01020099053', 'android', NULL, NULL, '10.51.0.214', NULL, NULL, '0.00', '0.00'),
(30, 1000021, NULL, 6, NULL, NULL, NULL, 1, NULL, NULL, '2022-08-01 11:07:04', '2022-08-01 11:13:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01000600603', 'android', NULL, NULL, '10.51.0.213', NULL, NULL, '0.00', '0.00'),
(31, 1000021, NULL, 6, NULL, NULL, NULL, 1, NULL, NULL, '2022-08-01 11:20:29', '2022-08-02 13:01:50', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01000600603', 'android', NULL, NULL, '10.51.0.214', NULL, NULL, '0.00', '0.00'),
(32, 1000006, NULL, 4, NULL, NULL, NULL, 1, NULL, NULL, '2022-08-01 12:42:23', '2022-08-01 17:29:02', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01020099053', 'android', NULL, NULL, '10.51.0.213', NULL, NULL, '0.00', '0.00'),
(33, 1000006, NULL, 6, NULL, NULL, NULL, 1, NULL, NULL, '2022-08-01 17:29:55', '2022-08-02 13:09:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01020099053', 'android', NULL, NULL, '10.51.0.214', NULL, NULL, '0.00', '0.00'),
(34, 1000003, NULL, 6, NULL, NULL, NULL, 1, NULL, NULL, '2022-08-02 01:48:28', '2022-08-02 01:48:56', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01095150281', 'android', NULL, NULL, '10.51.0.214', NULL, NULL, '0.00', '0.00'),
(35, 1000011, NULL, 6, NULL, NULL, NULL, 1, NULL, NULL, '2022-08-02 10:57:36', '2022-08-02 11:15:52', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01283664243', 'android', NULL, NULL, '10.51.0.214', NULL, NULL, '0.00', '0.00'),
(36, 1000020, NULL, 6, NULL, NULL, NULL, 1, NULL, NULL, '2022-08-02 11:22:15', '2022-08-02 11:31:31', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01206887664', 'android', NULL, NULL, '10.51.0.214', NULL, NULL, '0.00', '0.00'),
(37, 1000020, NULL, 6, NULL, NULL, NULL, 1, NULL, NULL, '2022-08-02 11:41:51', '2022-08-02 13:09:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01206887664', 'android', NULL, NULL, '10.51.0.213', NULL, NULL, '0.00', '0.00'),
(38, 1000007, NULL, 6, NULL, NULL, NULL, 1, NULL, NULL, '2022-08-02 11:44:45', '2022-08-02 13:09:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01221170635', 'android', NULL, NULL, '10.51.0.213', NULL, NULL, '0.00', '0.00'),
(39, 1000008, NULL, 6, NULL, NULL, NULL, 1, NULL, NULL, '2022-08-02 11:49:41', '2022-08-02 13:09:10', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01228654444', 'android', NULL, NULL, '10.51.0.214', NULL, NULL, '0.00', '0.00'),
(40, 1000022, NULL, 6, NULL, NULL, NULL, 1, NULL, NULL, '2022-08-02 12:19:23', '2022-08-02 13:09:30', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01099551017', 'android', NULL, NULL, '10.51.0.213', NULL, NULL, '0.00', '0.00'),
(41, 1000021, NULL, 6, NULL, NULL, NULL, 1, NULL, NULL, '2022-08-02 13:07:44', '2022-08-02 13:09:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01000600603', 'android', NULL, NULL, '10.51.0.213', NULL, NULL, '0.00', '0.00'),
(42, 1000021, NULL, 4, NULL, NULL, NULL, 1, NULL, NULL, '2022-08-02 13:10:03', '2022-08-03 09:33:38', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01000600603', 'android', NULL, NULL, '10.51.0.213', NULL, NULL, '0.00', '0.00'),
(43, 1000022, NULL, 6, NULL, NULL, NULL, 1, NULL, NULL, '2022-08-02 14:54:39', '2022-08-03 10:46:50', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01099551017', 'android', NULL, NULL, '10.51.0.214', NULL, NULL, '0.00', '0.00'),
(44, 1000006, NULL, 6, NULL, NULL, NULL, 1, NULL, NULL, '2022-08-02 16:57:54', '2022-08-03 07:22:36', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01020099053', 'android', NULL, NULL, '10.51.0.213', NULL, NULL, '0.00', '0.00'),
(45, 1000003, NULL, 6, NULL, NULL, NULL, 1, NULL, NULL, '2022-08-02 21:24:10', '2022-08-03 07:24:45', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01095150281', 'android', NULL, NULL, '10.51.0.214', NULL, NULL, '0.00', '0.00'),
(46, 1000006, NULL, 6, NULL, NULL, NULL, 1, NULL, NULL, '2022-08-03 07:26:20', '2022-08-03 07:27:52', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01020099053', 'android', NULL, NULL, '10.51.0.213', NULL, NULL, '0.00', '0.00'),
(47, 1000006, NULL, 6, NULL, NULL, NULL, 1, NULL, NULL, '2022-08-03 07:28:40', '2022-08-03 10:46:50', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01020099053', 'android', NULL, NULL, '10.51.0.213', NULL, NULL, '0.00', '0.00'),
(48, 1000003, NULL, 6, NULL, NULL, NULL, 1, NULL, NULL, '2022-08-03 07:33:05', '2022-08-03 10:46:50', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01095150281', 'android', NULL, NULL, '10.51.0.213', NULL, NULL, '0.00', '0.00'),
(49, 1000007, NULL, 6, NULL, NULL, NULL, 1, NULL, NULL, '2022-08-03 07:50:57', '2022-08-03 10:44:12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01221170635', 'android', NULL, NULL, '10.51.0.213', NULL, NULL, '0.00', '0.00'),
(50, 1000024, NULL, 6, NULL, NULL, NULL, 1, NULL, NULL, '2022-08-03 09:16:20', '2022-08-03 09:31:43', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01200441130', 'android', NULL, NULL, '10.51.0.214', NULL, NULL, '0.00', '0.00'),
(51, 1000021, NULL, 6, NULL, NULL, NULL, 1, NULL, NULL, '2022-08-03 09:34:51', '2022-08-03 10:43:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01000600603', 'android', NULL, NULL, '10.51.0.213', NULL, NULL, '0.00', '0.00'),
(52, 1000017, NULL, 6, NULL, NULL, NULL, 1, NULL, NULL, '2022-08-03 09:44:09', '2022-08-03 09:45:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01150655968', 'android', NULL, NULL, '10.51.0.214', NULL, NULL, '0.00', '0.00'),
(53, 1000017, NULL, 6, NULL, NULL, NULL, 1, NULL, NULL, '2022-08-03 09:47:35', '2022-08-03 10:45:28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01150655968', 'android', NULL, NULL, '10.51.0.214', NULL, NULL, '0.00', '0.00'),
(54, 1000021, NULL, 6, NULL, NULL, NULL, 1, NULL, NULL, '2022-08-03 10:44:15', '2022-08-04 11:19:59', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01000600603', 'android', NULL, NULL, '10.51.0.214', NULL, NULL, '0.00', '0.00'),
(55, 1000006, NULL, 4, NULL, NULL, NULL, 1, NULL, NULL, '2022-08-03 10:52:54', '2022-08-04 07:33:53', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01020099053', 'android', NULL, NULL, '10.51.0.214', NULL, NULL, '0.00', '0.00'),
(56, 1000022, NULL, 4, NULL, NULL, 5, 1, NULL, NULL, '2022-08-03 10:55:51', '2022-08-05 02:26:58', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01099551017', 'android', NULL, NULL, '10.51.0.214', NULL, NULL, '0.00', '0.00'),
(57, 1000003, NULL, 4, NULL, NULL, 1, 1, NULL, NULL, '2022-08-03 11:01:11', '2022-08-08 12:09:12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01095150281', 'android', NULL, NULL, '10.51.0.213', NULL, NULL, '0.00', '0.00'),
(58, 1000024, NULL, 4, NULL, NULL, NULL, 1, NULL, NULL, '2022-08-03 11:08:40', '2022-08-04 07:35:46', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01200441130', 'android', NULL, NULL, '10.51.0.213', NULL, NULL, '0.00', '0.00'),
(59, 1000017, NULL, 4, NULL, NULL, NULL, 1, NULL, NULL, '2022-08-03 11:13:01', '2022-08-04 07:35:45', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01150655968', 'android', NULL, NULL, '10.51.0.213', NULL, NULL, '0.00', '0.00'),
(60, 1000007, NULL, 4, NULL, NULL, NULL, 1, NULL, NULL, '2022-08-03 11:21:08', '2022-08-04 07:35:45', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01221170635', 'android', NULL, NULL, '10.51.0.214', NULL, NULL, '0.00', '0.00'),
(61, 1000020, NULL, 4, NULL, NULL, NULL, 1, NULL, NULL, '2022-08-03 11:27:11', '2022-08-04 07:35:45', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01206887664', 'android', NULL, NULL, '10.51.0.213', NULL, NULL, '0.00', '0.00'),
(62, 1000002, NULL, 6, NULL, NULL, NULL, 1, NULL, NULL, '2022-08-03 14:09:08', '2022-08-04 11:09:19', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01555453673', 'android', NULL, NULL, '10.51.0.213', NULL, NULL, '0.00', '0.00'),
(63, 1000023, NULL, 4, NULL, NULL, NULL, 1, NULL, NULL, '2022-08-03 14:56:24', '2022-08-04 07:34:12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01123334815', 'android', NULL, NULL, '10.51.0.214', NULL, NULL, '0.00', '0.00'),
(64, 1000005, NULL, 6, NULL, NULL, NULL, 1, NULL, NULL, '2022-08-03 19:41:16', '2022-08-04 08:33:28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01222267740', 'android', NULL, NULL, '10.51.0.214', NULL, NULL, '0.00', '0.00'),
(65, 1000002, NULL, 6, NULL, NULL, NULL, 1, NULL, NULL, '2022-08-04 11:10:36', '2022-08-04 11:28:38', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01555453673', 'android', NULL, NULL, '10.51.0.214', NULL, NULL, '0.00', '0.00'),
(66, 1000021, NULL, 6, NULL, NULL, NULL, 1, NULL, NULL, '2022-08-04 11:20:29', '2022-08-09 09:27:53', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01000600603', 'android', NULL, NULL, '10.51.0.214', NULL, NULL, '0.00', '0.00'),
(67, 1000002, NULL, 6, NULL, NULL, NULL, 1, NULL, NULL, '2022-08-04 11:30:40', '2022-08-06 11:32:48', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01555453673', 'android', NULL, NULL, '10.51.0.213', NULL, NULL, '0.00', '0.00'),
(68, 1000020, NULL, 6, NULL, NULL, NULL, 1, NULL, NULL, '2022-08-04 12:04:31', '2022-08-04 12:20:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01206887664', 'android', NULL, NULL, '10.51.0.213', NULL, NULL, '0.00', '0.00'),
(69, 1000020, NULL, 6, NULL, NULL, NULL, 1, NULL, NULL, '2022-08-04 12:22:38', '2022-08-09 09:28:28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01206887664', 'android', NULL, NULL, '10.51.0.213', NULL, NULL, '0.00', '0.00'),
(70, 1000019, NULL, 6, NULL, NULL, NULL, 1, NULL, NULL, '2022-08-04 13:51:27', '2022-08-04 13:53:27', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01157267197', 'android', NULL, NULL, '10.51.0.213', NULL, NULL, '0.00', '0.00'),
(71, 1000023, NULL, 6, NULL, NULL, NULL, 1, NULL, NULL, '2022-08-06 01:53:30', '2022-08-06 08:46:04', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01123334815', 'android', NULL, NULL, '10.51.0.214', NULL, NULL, '0.00', '0.00'),
(72, 1000017, NULL, 6, NULL, NULL, NULL, 1, NULL, NULL, '2022-08-06 08:56:35', '2022-08-07 06:44:30', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01150655968', 'android', NULL, NULL, '10.51.0.214', NULL, NULL, '0.00', '0.00'),
(73, 1000008, NULL, 6, NULL, NULL, NULL, 1, NULL, NULL, '2022-08-06 10:40:47', '2022-08-06 12:42:22', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01228654444', 'android', NULL, NULL, '10.51.0.213', NULL, NULL, '0.00', '0.00'),
(74, 1000002, NULL, 4, NULL, NULL, NULL, 1, NULL, NULL, '2022-08-06 11:33:44', '2022-08-09 09:12:16', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01555453673', 'android', NULL, NULL, '10.51.0.213', NULL, NULL, '0.00', '0.00'),
(75, 1000024, NULL, 4, NULL, NULL, NULL, 1, NULL, NULL, '2022-08-06 12:39:18', '2022-08-07 08:39:18', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01200441130', 'android', NULL, NULL, '10.51.0.214', NULL, NULL, '0.00', '0.00'),
(76, 1000008, NULL, 4, NULL, NULL, NULL, 1, NULL, NULL, '2022-08-06 12:43:20', '2022-08-07 08:39:17', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01228654444', 'android', NULL, NULL, '10.51.0.213', NULL, NULL, '0.00', '0.00'),
(77, 1000023, NULL, 6, NULL, NULL, NULL, 1, NULL, NULL, '2022-08-06 13:03:23', '2022-08-08 10:30:16', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01123334815', 'android', NULL, NULL, '10.51.0.214', NULL, NULL, '0.00', '0.00'),
(78, 1000023, NULL, 6, NULL, NULL, NULL, 1, NULL, NULL, '2022-08-08 12:00:26', '2022-08-08 12:12:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01123334815', 'android', NULL, NULL, '10.51.0.214', NULL, NULL, '0.00', '0.00'),
(79, 1000002, NULL, 7, NULL, NULL, NULL, 1, NULL, NULL, '2022-08-09 11:34:18', '2022-08-10 10:57:09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01555453673', 'android', NULL, NULL, '10.51.0.213', NULL, NULL, '0.00', '0.00'),
(80, 1000024, NULL, 2, NULL, NULL, NULL, 1, NULL, NULL, '2022-08-09 12:03:53', '2022-08-09 12:17:06', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01200441130', 'android', NULL, NULL, '10.51.0.214', NULL, NULL, '0.00', '0.00'),
(81, 1000019, NULL, 2, NULL, NULL, NULL, 1, NULL, NULL, '2022-08-09 14:52:51', '2022-08-09 14:55:30', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01157267197', 'android', NULL, NULL, '10.51.0.213', NULL, NULL, '0.00', '0.00'),
(82, 1000002, NULL, 6, NULL, NULL, NULL, 1, NULL, NULL, '2022-08-10 11:01:02', '2022-08-14 08:52:06', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01555453673', 'android', NULL, NULL, '10.51.0.213', NULL, NULL, '0.00', '0.00'),
(83, 1000011, NULL, 6, NULL, NULL, NULL, 1, NULL, NULL, '2022-08-10 13:01:32', '2022-08-10 13:01:59', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01283664243', 'android', NULL, NULL, '10.51.0.214', NULL, NULL, '0.00', '0.00'),
(84, 1000003, NULL, 4, NULL, NULL, 5, 1, NULL, NULL, '2022-08-13 02:07:09', '2022-08-14 17:25:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01095150281', 'android', NULL, NULL, '10.51.0.213', NULL, NULL, '0.00', '0.00'),
(85, 1000002, NULL, 14, NULL, NULL, NULL, 1, NULL, NULL, '2022-08-14 08:57:40', '2022-10-26 11:02:28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01555453673', 'android', NULL, NULL, '10.51.0.213', NULL, NULL, '0.00', '0.00'),
(86, 1000002, NULL, 4, NULL, NULL, NULL, 1, NULL, NULL, '2022-08-14 10:26:17', '2022-08-14 16:13:51', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01555453673', 'android', NULL, NULL, '10.51.0.214', NULL, NULL, '0.00', '0.00'),
(87, 1000002, NULL, 6, NULL, NULL, NULL, 1, NULL, NULL, '2022-08-15 13:20:33', '2022-08-18 05:55:33', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01555453673', 'android', NULL, NULL, '10.51.0.213', NULL, NULL, '0.00', '0.00'),
(88, 1000003, NULL, 6, NULL, NULL, NULL, 1, NULL, NULL, '2022-08-17 19:54:54', '2022-08-18 07:31:03', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01095150281', 'android', NULL, NULL, '10.51.0.213', NULL, NULL, '0.00', '0.00'),
(89, 1000002, NULL, 6, NULL, NULL, NULL, 1, NULL, NULL, '2022-08-18 05:56:47', '2022-08-20 15:48:36', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01555453673', 'android', NULL, NULL, '10.51.0.213', NULL, NULL, '0.00', '0.00'),
(90, 1000002, NULL, 6, NULL, NULL, NULL, 1, NULL, NULL, '2022-08-20 15:49:30', '2022-08-21 10:34:56', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01555453673', 'android', NULL, NULL, '10.51.0.213', NULL, NULL, '0.00', '0.00'),
(91, 1000002, NULL, 4, NULL, NULL, NULL, 1, NULL, NULL, '2022-08-21 10:36:53', '2022-08-21 15:12:38', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01555453673', 'android', NULL, NULL, '10.51.0.214', NULL, NULL, '0.00', '0.00'),
(92, 1000003, NULL, 4, NULL, NULL, NULL, 1, NULL, NULL, '2022-08-22 02:18:07', '2022-08-23 14:30:50', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01095150281', 'android', NULL, NULL, '10.51.0.213', NULL, NULL, '0.00', '0.00'),
(93, 1000003, NULL, 4, NULL, NULL, NULL, 1, NULL, NULL, '2022-08-29 13:52:57', '2022-08-31 14:51:49', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01095150281', 'android', NULL, NULL, '10.51.0.213', NULL, NULL, '0.00', '0.00'),
(94, 1000003, NULL, 2, NULL, NULL, NULL, 1, NULL, NULL, '2022-09-11 04:05:46', '2022-09-13 11:37:53', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01095150281', 'android', NULL, NULL, '10.51.0.213', NULL, NULL, '0.00', '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `order_cancellation_reasons`
--

CREATE TABLE `order_cancellation_reasons` (
  `id` int(10) UNSIGNED NOT NULL,
  `text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `text_ar` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_type` enum('customer','admin') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_cancellation_reasons`
--

INSERT INTO `order_cancellation_reasons` (`id`, `text`, `text_ar`, `user_type`) VALUES
(1, 'Ordered by mistake ', 'تم الطلب بالخطأ', 'customer'),
(2, 'Item is out of stock | المنتج غير متوفر', 'other', 'admin'),
(3, 'As per customer request | بناء علي طلب العميل ', 'other', 'admin'),
(4, 'Customer is not reachable | العميل غير متاح', 'other', 'admin'),
(5, 'Find a better offer elsewhere', ' وجدت عرض افضل في مكان اخر', 'customer'),
(6, 'Shipping Delay', 'تأخر الشحن', 'customer'),
(7, 'Changed my opinion ', 'لقد غيرت رأئي', 'customer'),
(8, 'Other', 'أخري', 'customer'),
(9, 'Other | أخري', 'other', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `order_history`
--

CREATE TABLE `order_history` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `state_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `sub_state_id` int(10) UNSIGNED DEFAULT NULL,
  `status_notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_history`
--

INSERT INTO `order_history` (`id`, `order_id`, `state_id`, `user_id`, `created_at`, `updated_at`, `sub_state_id`, `status_notes`) VALUES
(1, 1, 1, NULL, '2022-06-20 15:16:18', '2022-06-20 15:16:18', NULL, NULL),
(2, 1, 6, 1, '2022-06-20 16:05:43', '2022-06-20 16:05:43', NULL, NULL),
(3, 2, 1, NULL, '2022-06-20 16:06:36', '2022-06-20 16:06:36', NULL, NULL),
(4, 2, 4, 1, '2022-06-20 16:13:15', '2022-06-20 16:13:15', NULL, NULL),
(5, 3, 1, NULL, '2022-06-20 16:13:53', '2022-06-20 16:13:53', NULL, NULL),
(6, 3, 6, 1000003, '2022-06-20 16:14:28', '2022-06-20 16:14:28', NULL, NULL),
(7, 3, 4, 1, '2022-06-20 16:14:35', '2022-06-20 16:14:35', NULL, NULL),
(8, 3, 7, 1, '2022-06-20 16:15:57', '2022-06-20 16:15:57', NULL, NULL),
(9, 4, 1, NULL, '2022-06-22 10:28:53', '2022-06-22 10:28:53', NULL, NULL),
(10, 4, 4, 1, '2022-06-22 10:49:15', '2022-06-22 10:49:15', NULL, NULL),
(11, 5, 1, NULL, '2022-06-22 11:19:02', '2022-06-22 11:19:02', NULL, NULL),
(12, 5, 4, 1, '2022-06-22 11:19:26', '2022-06-22 11:19:26', NULL, NULL),
(13, 6, 1, NULL, '2022-06-22 11:24:48', '2022-06-22 11:24:48', NULL, NULL),
(14, 6, 2, 1, '2022-06-22 11:25:06', '2022-06-22 11:25:06', NULL, NULL),
(15, 7, 1, NULL, '2022-06-22 15:36:37', '2022-06-22 15:36:37', NULL, NULL),
(16, 7, 4, 1, '2022-06-22 16:22:06', '2022-06-22 16:22:06', NULL, NULL),
(17, 6, 4, 1, '2022-06-22 16:25:07', '2022-06-22 16:25:07', NULL, NULL),
(18, 8, 1, NULL, '2022-06-22 16:25:13', '2022-06-22 16:25:13', NULL, NULL),
(19, 8, 2, 1, '2022-06-22 16:25:48', '2022-06-22 16:25:48', NULL, NULL),
(20, 9, 1, NULL, '2022-06-22 16:47:16', '2022-06-22 16:47:16', NULL, NULL),
(21, 8, 6, 1000003, '2022-06-22 16:51:18', '2022-06-22 16:51:18', NULL, NULL),
(22, 10, 1, NULL, '2022-06-26 09:05:57', '2022-06-26 09:05:57', NULL, NULL),
(23, 10, 2, 1, '2022-06-26 09:06:54', '2022-06-26 09:06:54', NULL, NULL),
(24, 10, 3, 1, '2022-06-26 09:07:28', '2022-06-26 09:07:28', NULL, NULL),
(25, 10, 4, 1, '2022-06-26 09:07:41', '2022-06-26 09:07:41', NULL, NULL),
(26, 8, 6, 1, '2022-06-26 11:43:08', '2022-06-26 11:43:08', NULL, NULL),
(27, 11, 1, NULL, '2022-06-26 13:41:57', '2022-06-26 13:41:57', NULL, NULL),
(28, 11, 6, 1, '2022-06-26 13:43:00', '2022-06-26 13:43:00', NULL, NULL),
(29, 12, 1, NULL, '2022-06-26 13:44:45', '2022-06-26 13:44:45', NULL, NULL),
(30, 12, 2, 1, '2022-06-26 13:45:43', '2022-06-26 13:45:43', NULL, NULL),
(31, 12, 6, 1, '2022-06-26 14:39:12', '2022-06-26 14:39:12', NULL, NULL),
(32, 13, 1, NULL, '2022-06-26 15:03:58', '2022-06-26 15:03:58', NULL, NULL),
(33, 13, 2, 1, '2022-06-26 15:04:35', '2022-06-26 15:04:35', NULL, NULL),
(34, 13, 4, 1, '2022-06-26 16:20:37', '2022-06-26 16:20:37', NULL, NULL),
(35, 14, 1, NULL, '2022-06-26 16:20:42', '2022-06-26 16:20:42', NULL, NULL),
(36, 14, 6, 1000003, '2022-06-26 16:30:48', '2022-06-26 16:30:48', NULL, NULL),
(37, 14, 6, 1, '2022-06-26 16:31:08', '2022-06-26 16:31:08', NULL, NULL),
(38, 15, 1, NULL, '2022-06-26 16:31:24', '2022-06-26 16:31:24', NULL, NULL),
(39, 15, 2, 1, '2022-06-26 16:31:46', '2022-06-26 16:31:46', NULL, NULL),
(40, 15, 6, 1, '2022-06-26 16:49:27', '2022-06-26 16:49:27', NULL, NULL),
(41, 16, 1, NULL, '2022-06-26 17:10:44', '2022-06-26 17:10:44', NULL, NULL),
(42, 16, 2, 1, '2022-06-26 17:11:19', '2022-06-26 17:11:19', NULL, NULL),
(43, 16, 6, 1, '2022-06-27 11:12:56', '2022-06-27 11:12:56', NULL, NULL),
(44, 17, 1, NULL, '2022-06-27 11:43:20', '2022-06-27 11:43:20', NULL, NULL),
(45, 17, 2, 1, '2022-06-27 11:46:19', '2022-06-27 11:46:19', NULL, NULL),
(46, 17, 6, 1000003, '2022-06-27 12:18:36', '2022-06-27 12:18:36', NULL, NULL),
(47, 17, 6, 1000003, '2022-06-27 12:18:37', '2022-06-27 12:18:37', NULL, NULL),
(48, 17, 6, 1, '2022-06-27 12:19:25', '2022-06-27 12:19:25', NULL, NULL),
(49, 18, 1, NULL, '2022-06-27 13:25:29', '2022-06-27 13:25:29', NULL, NULL),
(50, 18, 2, 1, '2022-06-27 13:25:46', '2022-06-27 13:25:46', NULL, NULL),
(51, 18, 4, 1, '2022-06-28 09:54:42', '2022-06-28 09:54:42', NULL, NULL),
(52, 19, 1, NULL, '2022-06-28 09:54:53', '2022-06-28 09:54:53', NULL, NULL),
(53, 19, 4, 1, '2022-06-28 10:19:45', '2022-06-28 10:19:45', NULL, NULL),
(54, 20, 1, NULL, '2022-06-28 14:41:53', '2022-06-28 14:41:53', NULL, NULL),
(55, 20, 2, 1, '2022-06-28 14:42:09', '2022-06-28 14:42:09', NULL, NULL),
(56, 20, 6, 1, '2022-06-28 16:59:18', '2022-06-28 16:59:18', NULL, NULL),
(57, 21, 1, NULL, '2022-06-28 17:03:34', '2022-06-28 17:03:34', NULL, NULL),
(58, 21, 2, 1, '2022-06-28 17:19:06', '2022-06-28 17:19:06', NULL, NULL),
(59, 21, 4, 1, '2022-06-28 18:06:46', '2022-06-28 18:06:46', NULL, NULL),
(60, 22, 1, NULL, '2022-06-29 09:59:10', '2022-06-29 09:59:10', NULL, NULL),
(61, 22, 2, 1, '2022-06-29 10:02:10', '2022-06-29 10:02:10', NULL, NULL),
(62, 22, 6, 1, '2022-06-29 10:24:10', '2022-06-29 10:24:10', NULL, NULL),
(63, 23, 1, NULL, '2022-06-29 10:24:15', '2022-06-29 10:24:15', NULL, NULL),
(64, 23, 2, 1, '2022-06-29 10:24:34', '2022-06-29 10:24:34', NULL, NULL),
(65, 23, 6, 1000003, '2022-06-29 10:35:10', '2022-06-29 10:35:10', NULL, NULL),
(66, 24, 1, NULL, '2022-06-29 10:38:40', '2022-06-29 10:38:40', NULL, NULL),
(67, 23, 6, 1, '2022-06-29 10:39:04', '2022-06-29 10:39:04', NULL, NULL),
(68, 24, 2, 1, '2022-06-29 10:39:14', '2022-06-29 10:39:14', NULL, NULL),
(69, 24, 6, 1000003, '2022-06-29 10:43:44', '2022-06-29 10:43:44', NULL, NULL),
(70, 24, 6, 1000003, '2022-06-29 10:43:44', '2022-06-29 10:43:44', NULL, NULL),
(71, 24, 6, 1, '2022-06-29 10:43:58', '2022-06-29 10:43:58', NULL, NULL),
(72, 25, 1, NULL, '2022-06-29 10:44:31', '2022-06-29 10:44:31', NULL, NULL),
(73, 25, 2, 1, '2022-06-29 10:44:47', '2022-06-29 10:44:47', NULL, NULL),
(74, 25, 6, 1000003, '2022-06-29 10:46:33', '2022-06-29 10:46:33', NULL, NULL),
(75, 25, 6, 1, '2022-06-29 10:46:49', '2022-06-29 10:46:49', NULL, NULL),
(76, 26, 1, NULL, '2022-06-29 10:47:41', '2022-06-29 10:47:41', NULL, NULL),
(77, 26, 2, 1, '2022-06-29 10:48:01', '2022-06-29 10:48:01', NULL, NULL),
(78, 26, 6, 1000003, '2022-06-29 10:55:29', '2022-06-29 10:55:29', NULL, NULL),
(79, 26, 6, 1, '2022-06-29 10:56:12', '2022-06-29 10:56:12', NULL, NULL),
(80, 27, 1, NULL, '2022-06-29 10:56:14', '2022-06-29 10:56:14', NULL, NULL),
(81, 27, 2, 1, '2022-06-29 10:56:39', '2022-06-29 10:56:39', NULL, NULL),
(82, 27, 6, 1000003, '2022-06-29 11:03:28', '2022-06-29 11:03:28', NULL, NULL),
(83, 27, 6, 1, '2022-06-29 11:04:08', '2022-06-29 11:04:08', NULL, NULL),
(84, 28, 1, NULL, '2022-06-29 11:04:12', '2022-06-29 11:04:12', NULL, NULL),
(85, 28, 2, 1, '2022-06-29 11:04:38', '2022-06-29 11:04:38', NULL, NULL),
(86, 28, 6, 1000003, '2022-06-29 11:16:29', '2022-06-29 11:16:29', NULL, NULL),
(87, 29, 1, NULL, '2022-06-29 11:21:16', '2022-06-29 11:21:16', NULL, NULL),
(88, 29, 2, 1, '2022-06-29 11:21:46', '2022-06-29 11:21:46', NULL, NULL),
(89, 29, 6, 1000003, '2022-06-29 11:27:00', '2022-06-29 11:27:00', NULL, NULL),
(90, 29, 6, 1, '2022-06-29 11:27:20', '2022-06-29 11:27:20', NULL, NULL),
(91, 30, 1, NULL, '2022-06-29 11:28:30', '2022-06-29 11:28:30', NULL, NULL),
(92, 30, 2, 1, '2022-06-29 11:28:58', '2022-06-29 11:28:58', NULL, NULL),
(93, 30, 4, 1, '2022-07-17 12:43:32', '2022-07-17 12:43:32', NULL, NULL),
(94, 31, 1, NULL, '2022-07-17 12:43:40', '2022-07-17 12:43:40', NULL, NULL),
(95, 31, 2, 1, '2022-07-17 12:44:31', '2022-07-17 12:44:31', NULL, NULL),
(96, 31, 4, 1, '2022-07-17 15:05:45', '2022-07-17 15:05:45', NULL, NULL),
(97, 32, 1, NULL, '2022-07-17 15:07:33', '2022-07-17 15:07:33', NULL, NULL),
(98, 32, 2, 1, '2022-07-17 15:07:46', '2022-07-17 15:07:46', NULL, NULL),
(99, 32, 6, 1000003, '2022-07-17 15:57:01', '2022-07-17 15:57:01', NULL, NULL),
(100, 33, 1, NULL, '2022-07-17 15:57:26', '2022-07-17 15:57:26', NULL, NULL),
(101, 33, 2, 1, '2022-07-17 15:58:08', '2022-07-17 15:58:08', NULL, NULL),
(102, 33, 4, 1, '2022-07-17 16:05:02', '2022-07-17 16:05:02', NULL, NULL),
(103, 34, 1, NULL, '2022-07-17 16:11:35', '2022-07-17 16:11:35', NULL, NULL),
(104, 34, 2, 1, '2022-07-17 16:12:04', '2022-07-17 16:12:04', NULL, NULL),
(105, 34, 6, 1, '2022-07-17 16:13:56', '2022-07-17 16:13:56', NULL, NULL),
(106, 35, 1, NULL, '2022-07-17 16:16:52', '2022-07-17 16:16:52', NULL, NULL),
(107, 35, 2, 1, '2022-07-17 16:17:04', '2022-07-17 16:17:04', NULL, NULL),
(108, 35, 4, 1, '2022-07-17 16:29:40', '2022-07-17 16:29:40', NULL, NULL),
(109, 36, 1, NULL, '2022-07-17 16:43:27', '2022-07-17 16:43:27', NULL, NULL),
(110, 36, 2, 1, '2022-07-17 16:43:51', '2022-07-17 16:43:51', NULL, NULL),
(111, 36, 4, 1, '2022-07-17 17:11:56', '2022-07-17 17:11:56', NULL, NULL),
(112, 37, 1, NULL, '2022-07-18 13:01:39', '2022-07-18 13:01:39', NULL, NULL),
(113, 37, 2, 1, '2022-07-18 13:02:52', '2022-07-18 13:02:52', NULL, NULL),
(114, 37, 4, 1, '2022-07-18 13:24:02', '2022-07-18 13:24:02', NULL, NULL),
(115, 38, 1, NULL, '2022-07-19 10:55:49', '2022-07-19 10:55:49', NULL, NULL),
(116, 38, 6, 1, '2022-07-19 11:21:56', '2022-07-19 11:21:56', NULL, NULL),
(117, 39, 1, NULL, '2022-07-19 12:34:31', '2022-07-19 12:34:31', NULL, NULL),
(118, 39, 2, 1, '2022-07-19 12:37:36', '2022-07-19 12:37:36', NULL, NULL),
(119, 39, 4, 1, '2022-07-19 13:09:16', '2022-07-19 13:09:16', NULL, NULL),
(120, 39, 7, 1, '2022-07-19 15:18:01', '2022-07-19 15:18:01', NULL, NULL),
(121, 40, 1, NULL, '2022-07-19 15:33:26', '2022-07-19 15:33:26', NULL, NULL),
(122, 40, 4, 1, '2022-07-19 15:33:44', '2022-07-19 15:33:44', NULL, NULL),
(123, 40, 7, 1, '2022-07-19 15:35:02', '2022-07-19 15:35:02', NULL, NULL),
(124, 9, 6, 1, '2022-07-19 15:35:44', '2022-07-19 15:35:44', NULL, NULL),
(125, 41, 1, NULL, '2022-07-20 09:39:52', '2022-07-20 09:39:52', NULL, NULL),
(126, 41, 2, 1, '2022-07-20 09:40:31', '2022-07-20 09:40:31', NULL, NULL),
(127, 41, 4, 1, '2022-07-20 09:41:51', '2022-07-20 09:41:51', NULL, NULL),
(128, 1, 1, NULL, '2022-07-20 15:58:48', '2022-07-20 15:58:48', NULL, NULL),
(129, 1, 2, 1, '2022-07-20 16:00:35', '2022-07-20 16:00:35', NULL, NULL),
(130, 2, 1, NULL, '2022-07-21 11:31:41', '2022-07-21 11:31:41', NULL, NULL),
(131, 2, 6, 1000006, '2022-07-21 11:36:02', '2022-07-21 11:36:02', NULL, NULL),
(132, 3, 1, NULL, '2022-07-21 11:37:29', '2022-07-21 11:37:29', NULL, NULL),
(133, 3, 2, 1, '2022-07-21 11:38:35', '2022-07-21 11:38:35', NULL, NULL),
(134, 1, 4, 1, '2022-07-21 16:26:04', '2022-07-21 16:26:04', NULL, NULL),
(135, 3, 4, 1, '2022-07-21 18:11:47', '2022-07-21 18:11:47', NULL, NULL),
(136, 4, 1, NULL, '2022-07-23 14:55:22', '2022-07-23 14:55:22', NULL, NULL),
(137, 4, 2, 1, '2022-07-24 09:30:43', '2022-07-24 09:30:43', NULL, NULL),
(138, 5, 1, NULL, '2022-07-24 10:51:02', '2022-07-24 10:51:02', NULL, NULL),
(139, 5, 2, 1, '2022-07-24 10:52:15', '2022-07-24 10:52:15', NULL, NULL),
(140, 5, 4, 1, '2022-07-25 09:18:40', '2022-07-25 09:18:40', NULL, NULL),
(141, 4, 4, 1, '2022-07-25 09:18:42', '2022-07-25 09:18:42', NULL, NULL),
(142, 6, 1, NULL, '2022-07-25 10:47:03', '2022-07-25 10:47:03', NULL, NULL),
(143, 6, 6, 1000008, '2022-07-25 10:56:06', '2022-07-25 10:56:06', NULL, NULL),
(144, 7, 1, NULL, '2022-07-25 10:56:44', '2022-07-25 10:56:44', NULL, NULL),
(145, 6, 6, 1, '2022-07-25 10:56:59', '2022-07-25 10:56:59', NULL, NULL),
(146, 7, 2, 1, '2022-07-25 10:58:18', '2022-07-25 10:58:18', NULL, NULL),
(147, 8, 1, NULL, '2022-07-25 12:21:18', '2022-07-25 12:21:18', NULL, NULL),
(148, 8, 6, 1000002, '2022-07-25 12:31:45', '2022-07-25 12:31:45', NULL, NULL),
(149, 9, 1, NULL, '2022-07-25 12:44:07', '2022-07-25 12:44:07', NULL, NULL),
(150, 9, 2, 1, '2022-07-25 13:00:30', '2022-07-25 13:00:30', NULL, NULL),
(151, 10, 1, NULL, '2022-07-25 15:40:30', '2022-07-25 15:40:30', NULL, NULL),
(152, 10, 2, 1, '2022-07-25 16:01:25', '2022-07-25 16:01:25', NULL, NULL),
(153, 11, 1, NULL, '2022-07-26 04:54:22', '2022-07-26 04:54:22', NULL, NULL),
(154, 11, 6, 1000003, '2022-07-26 04:57:25', '2022-07-26 04:57:25', NULL, NULL),
(155, 12, 1, NULL, '2022-07-26 04:59:15', '2022-07-26 04:59:15', NULL, NULL),
(156, 10, 6, 1000006, '2022-07-26 11:57:31', '2022-07-26 11:57:31', NULL, NULL),
(157, 13, 1, NULL, '2022-07-26 11:57:45', '2022-07-26 11:57:45', NULL, NULL),
(158, 7, 6, 1000008, '2022-07-26 12:00:28', '2022-07-26 12:00:28', NULL, NULL),
(159, 14, 1, NULL, '2022-07-26 12:00:59', '2022-07-26 12:00:59', NULL, NULL),
(160, 13, 2, 1, '2022-07-26 12:01:15', '2022-07-26 12:01:15', NULL, NULL),
(161, 14, 2, 1, '2022-07-26 12:02:02', '2022-07-26 12:02:02', NULL, NULL),
(162, 12, 6, 1000003, '2022-07-26 12:40:15', '2022-07-26 12:40:15', NULL, NULL),
(163, 15, 1, NULL, '2022-07-26 12:42:00', '2022-07-26 12:42:00', NULL, NULL),
(164, 15, 2, 1, '2022-07-26 12:42:34', '2022-07-26 12:42:34', NULL, NULL),
(165, 9, 4, 1, '2022-07-26 13:33:39', '2022-07-26 13:33:39', NULL, NULL),
(166, 14, 4, 1, '2022-07-27 15:41:06', '2022-07-27 15:41:06', NULL, NULL),
(167, 16, 1, NULL, '2022-07-27 15:59:25', '2022-07-27 15:59:25', NULL, NULL),
(168, 17, 1, NULL, '2022-07-27 17:06:04', '2022-07-27 17:06:04', NULL, NULL),
(169, 17, 2, 1, '2022-07-27 17:56:20', '2022-07-27 17:56:20', NULL, NULL),
(170, 13, 4, 1, '2022-07-27 17:58:43', '2022-07-27 17:58:43', NULL, NULL),
(171, 15, 6, 1000003, '2022-07-27 18:13:57', '2022-07-27 18:13:57', NULL, NULL),
(172, 18, 1, NULL, '2022-07-27 18:14:06', '2022-07-27 18:14:06', NULL, NULL),
(173, 18, 2, 1, '2022-07-27 18:55:41', '2022-07-27 18:55:41', NULL, NULL),
(174, 19, 1, NULL, '2022-07-28 00:37:25', '2022-07-28 00:37:25', NULL, NULL),
(175, 16, 6, 1000008, '2022-07-28 11:48:45', '2022-07-28 11:48:45', NULL, NULL),
(176, 20, 1, NULL, '2022-07-28 12:12:47', '2022-07-28 12:12:47', NULL, NULL),
(177, 20, 2, 1, '2022-07-28 12:16:14', '2022-07-28 12:16:14', NULL, NULL),
(178, 19, 6, 1, '2022-07-28 12:16:50', '2022-07-28 12:16:50', NULL, NULL),
(179, 21, 1, NULL, '2022-07-28 12:17:39', '2022-07-28 12:17:39', NULL, NULL),
(180, 21, 2, 1, '2022-07-28 12:19:06', '2022-07-28 12:19:06', NULL, NULL),
(181, 22, 1, NULL, '2022-07-28 13:48:59', '2022-07-28 13:48:59', NULL, NULL),
(182, 22, 2, 1, '2022-07-28 13:49:24', '2022-07-28 13:49:24', NULL, NULL),
(183, 18, 6, 1000003, '2022-07-29 04:13:55', '2022-07-29 04:13:55', NULL, NULL),
(184, 18, 6, 1000003, '2022-07-29 04:13:56', '2022-07-29 04:13:56', NULL, NULL),
(185, 23, 1, NULL, '2022-07-29 04:14:10', '2022-07-29 04:14:10', NULL, NULL),
(186, 23, 2, 1, '2022-07-29 20:59:20', '2022-07-29 20:59:20', NULL, NULL),
(187, 23, 6, 1000003, '2022-07-30 16:23:03', '2022-07-30 16:23:03', NULL, NULL),
(188, 24, 1, NULL, '2022-07-30 16:24:53', '2022-07-30 16:24:53', NULL, NULL),
(189, 24, 2, 1, '2022-07-31 08:59:35', '2022-07-31 08:59:35', NULL, NULL),
(190, 23, 6, 1, '2022-07-31 09:14:54', '2022-07-31 09:14:54', NULL, NULL),
(191, 22, 4, 1, '2022-07-31 10:02:16', '2022-07-31 10:02:16', NULL, NULL),
(192, 21, 4, 1, '2022-07-31 10:02:18', '2022-07-31 10:02:18', NULL, NULL),
(193, 20, 4, 1, '2022-07-31 10:02:18', '2022-07-31 10:02:18', NULL, NULL),
(194, 17, 4, 1, '2022-07-31 10:02:18', '2022-07-31 10:02:18', NULL, NULL),
(195, 25, 1, NULL, '2022-07-31 11:51:29', '2022-07-31 11:51:29', NULL, NULL),
(196, 25, 6, 1, '2022-07-31 12:57:46', '2022-07-31 12:57:46', NULL, NULL),
(197, 26, 1, NULL, '2022-07-31 13:14:18', '2022-07-31 13:14:18', NULL, NULL),
(198, 26, 2, 1, '2022-07-31 13:14:42', '2022-07-31 13:14:42', NULL, NULL),
(199, 27, 1, NULL, '2022-07-31 13:19:06', '2022-07-31 13:19:06', NULL, NULL),
(200, 27, 2, 1, '2022-07-31 13:22:44', '2022-07-31 13:22:44', NULL, NULL),
(201, 24, 4, 1, '2022-07-31 16:13:45', '2022-07-31 16:13:45', NULL, NULL),
(202, 18, 4, 1, '2022-07-31 17:02:55', '2022-07-31 17:02:55', NULL, NULL),
(203, 28, 1, NULL, '2022-07-31 17:05:39', '2022-07-31 17:05:39', NULL, NULL),
(204, 15, 4, 1, '2022-07-31 17:10:02', '2022-07-31 17:10:02', NULL, NULL),
(205, 28, 6, 1, '2022-07-31 17:21:01', '2022-07-31 17:21:01', NULL, NULL),
(206, 29, 1, NULL, '2022-07-31 17:21:44', '2022-07-31 17:21:44', NULL, NULL),
(207, 29, 2, 1, '2022-07-31 17:23:47', '2022-07-31 17:23:47', NULL, NULL),
(208, 29, 4, 1, '2022-08-01 13:04:09', '2022-08-01 13:04:09', NULL, NULL),
(209, 26, 4, 1, '2022-08-01 13:04:10', '2022-08-01 13:04:10', NULL, NULL),
(210, 27, 4, 1, '2022-08-01 13:05:53', '2022-08-01 13:05:53', NULL, NULL),
(211, 30, 1, NULL, '2022-08-01 13:07:04', '2022-08-01 13:07:04', NULL, NULL),
(212, 30, 6, 1, '2022-08-01 13:13:00', '2022-08-01 13:13:00', NULL, NULL),
(213, 31, 1, NULL, '2022-08-01 13:20:29', '2022-08-01 13:20:29', NULL, NULL),
(214, 31, 2, 1, '2022-08-01 13:25:23', '2022-08-01 13:25:23', NULL, NULL),
(215, 29, 7, 1, '2022-08-01 14:35:17', '2022-08-01 14:35:17', NULL, NULL),
(216, 32, 1, NULL, '2022-08-01 14:42:23', '2022-08-01 14:42:23', NULL, NULL),
(217, 32, 2, 1, '2022-08-01 14:43:23', '2022-08-01 14:43:23', NULL, NULL),
(218, 32, 4, 1, '2022-08-01 19:29:02', '2022-08-01 19:29:02', NULL, NULL),
(219, 33, 1, NULL, '2022-08-01 19:29:55', '2022-08-01 19:29:55', NULL, NULL),
(220, 33, 2, 1, '2022-08-01 19:31:32', '2022-08-01 19:31:32', NULL, NULL),
(221, 34, 1, NULL, '2022-08-02 03:48:28', '2022-08-02 03:48:28', NULL, NULL),
(222, 34, 6, 1000003, '2022-08-02 03:48:56', '2022-08-02 03:48:56', NULL, NULL),
(223, 35, 1, NULL, '2022-08-02 12:57:36', '2022-08-02 12:57:36', NULL, NULL),
(224, 35, 2, 1, '2022-08-02 12:59:51', '2022-08-02 12:59:51', NULL, NULL),
(225, 35, 6, 1, '2022-08-02 13:15:52', '2022-08-02 13:15:52', NULL, NULL),
(226, 36, 1, NULL, '2022-08-02 13:22:15', '2022-08-02 13:22:15', NULL, NULL),
(227, 36, 6, 1, '2022-08-02 13:31:31', '2022-08-02 13:31:31', NULL, NULL),
(228, 37, 1, NULL, '2022-08-02 13:41:51', '2022-08-02 13:41:51', NULL, NULL),
(229, 37, 2, 1, '2022-08-02 13:42:50', '2022-08-02 13:42:50', NULL, NULL),
(230, 38, 1, NULL, '2022-08-02 13:44:45', '2022-08-02 13:44:45', NULL, NULL),
(231, 38, 2, 1, '2022-08-02 13:46:35', '2022-08-02 13:46:35', NULL, NULL),
(232, 39, 1, NULL, '2022-08-02 13:49:41', '2022-08-02 13:49:41', NULL, NULL),
(233, 39, 2, 1, '2022-08-02 13:50:06', '2022-08-02 13:50:06', NULL, NULL),
(234, 40, 1, NULL, '2022-08-02 14:19:23', '2022-08-02 14:19:23', NULL, NULL),
(235, 40, 2, 1, '2022-08-02 14:40:46', '2022-08-02 14:40:46', NULL, NULL),
(236, 31, 6, 1000021, '2022-08-02 15:01:50', '2022-08-02 15:01:50', NULL, NULL),
(237, 41, 1, NULL, '2022-08-02 15:07:44', '2022-08-02 15:07:44', NULL, NULL),
(238, 39, 6, 1, '2022-08-02 15:09:10', '2022-08-02 15:09:10', NULL, NULL),
(239, 38, 6, 1, '2022-08-02 15:09:11', '2022-08-02 15:09:11', NULL, NULL),
(240, 37, 6, 1, '2022-08-02 15:09:11', '2022-08-02 15:09:11', NULL, NULL),
(241, 33, 6, 1, '2022-08-02 15:09:11', '2022-08-02 15:09:11', NULL, NULL),
(242, 31, 6, 1, '2022-08-02 15:09:11', '2022-08-02 15:09:11', NULL, NULL),
(243, 41, 6, 1000021, '2022-08-02 15:09:11', '2022-08-02 15:09:11', NULL, NULL),
(244, 40, 6, 1, '2022-08-02 15:09:30', '2022-08-02 15:09:30', NULL, NULL),
(245, 42, 1, NULL, '2022-08-02 15:10:03', '2022-08-02 15:10:03', NULL, NULL),
(246, 42, 2, 1, '2022-08-02 15:11:49', '2022-08-02 15:11:49', NULL, NULL),
(247, 43, 1, NULL, '2022-08-02 16:54:39', '2022-08-02 16:54:39', NULL, NULL),
(248, 43, 2, 1, '2022-08-02 16:56:11', '2022-08-02 16:56:11', NULL, NULL),
(249, 44, 1, NULL, '2022-08-02 18:57:54', '2022-08-02 18:57:54', NULL, NULL),
(250, 45, 1, NULL, '2022-08-02 23:24:10', '2022-08-02 23:24:10', NULL, NULL),
(251, 44, 6, 1, '2022-08-03 09:22:36', '2022-08-03 09:22:36', NULL, NULL),
(252, 45, 6, 1, '2022-08-03 09:24:45', '2022-08-03 09:24:45', NULL, NULL),
(253, 46, 1, NULL, '2022-08-03 09:26:20', '2022-08-03 09:26:20', NULL, NULL),
(254, 46, 6, 1, '2022-08-03 09:27:52', '2022-08-03 09:27:52', NULL, NULL),
(255, 47, 1, NULL, '2022-08-03 09:28:40', '2022-08-03 09:28:40', NULL, NULL),
(256, 47, 2, 1, '2022-08-03 09:29:35', '2022-08-03 09:29:35', NULL, NULL),
(257, 48, 1, NULL, '2022-08-03 09:33:05', '2022-08-03 09:33:05', NULL, NULL),
(258, 48, 2, 1, '2022-08-03 09:33:42', '2022-08-03 09:33:42', NULL, NULL),
(259, 49, 1, NULL, '2022-08-03 09:50:57', '2022-08-03 09:50:57', NULL, NULL),
(260, 49, 2, 1, '2022-08-03 09:51:29', '2022-08-03 09:51:29', NULL, NULL),
(261, 50, 1, NULL, '2022-08-03 11:16:20', '2022-08-03 11:16:20', NULL, NULL),
(262, 50, 6, 1, '2022-08-03 11:31:43', '2022-08-03 11:31:43', NULL, NULL),
(263, 42, 4, 1, '2022-08-03 11:33:38', '2022-08-03 11:33:38', NULL, NULL),
(264, 51, 1, NULL, '2022-08-03 11:34:51', '2022-08-03 11:34:51', NULL, NULL),
(265, 51, 2, 1, '2022-08-03 11:41:14', '2022-08-03 11:41:14', NULL, NULL),
(266, 52, 1, NULL, '2022-08-03 11:44:09', '2022-08-03 11:44:09', NULL, NULL),
(267, 52, 6, 1, '2022-08-03 11:45:11', '2022-08-03 11:45:11', NULL, NULL),
(268, 53, 1, NULL, '2022-08-03 11:47:35', '2022-08-03 11:47:35', NULL, NULL),
(269, 53, 2, 1, '2022-08-03 11:48:13', '2022-08-03 11:48:13', NULL, NULL),
(270, 51, 6, 1, '2022-08-03 12:43:11', '2022-08-03 12:43:11', NULL, NULL),
(271, 49, 6, 1, '2022-08-03 12:44:12', '2022-08-03 12:44:12', NULL, NULL),
(272, 54, 1, NULL, '2022-08-03 12:44:15', '2022-08-03 12:44:15', NULL, NULL),
(273, 54, 2, 1, '2022-08-03 12:45:04', '2022-08-03 12:45:04', NULL, NULL),
(274, 53, 6, 1, '2022-08-03 12:45:28', '2022-08-03 12:45:28', NULL, NULL),
(275, 48, 6, 1, '2022-08-03 12:46:50', '2022-08-03 12:46:50', NULL, NULL),
(276, 47, 6, 1, '2022-08-03 12:46:50', '2022-08-03 12:46:50', NULL, NULL),
(277, 43, 6, 1, '2022-08-03 12:46:50', '2022-08-03 12:46:50', NULL, NULL),
(278, 55, 1, NULL, '2022-08-03 12:52:54', '2022-08-03 12:52:54', NULL, NULL),
(279, 55, 2, 1, '2022-08-03 12:54:02', '2022-08-03 12:54:02', NULL, NULL),
(280, 56, 1, NULL, '2022-08-03 12:55:51', '2022-08-03 12:55:51', NULL, NULL),
(281, 56, 2, 1, '2022-08-03 12:57:22', '2022-08-03 12:57:22', NULL, NULL),
(282, 57, 1, NULL, '2022-08-03 13:01:11', '2022-08-03 13:01:11', NULL, NULL),
(283, 57, 2, 1, '2022-08-03 13:06:22', '2022-08-03 13:06:22', NULL, NULL),
(284, 58, 1, NULL, '2022-08-03 13:08:40', '2022-08-03 13:08:40', NULL, NULL),
(285, 58, 2, 1, '2022-08-03 13:10:53', '2022-08-03 13:10:53', NULL, NULL),
(286, 59, 1, NULL, '2022-08-03 13:13:01', '2022-08-03 13:13:01', NULL, NULL),
(287, 59, 2, 1, '2022-08-03 13:20:45', '2022-08-03 13:20:45', NULL, NULL),
(288, 60, 1, NULL, '2022-08-03 13:21:08', '2022-08-03 13:21:08', NULL, NULL),
(289, 60, 2, 1, '2022-08-03 13:21:48', '2022-08-03 13:21:48', NULL, NULL),
(290, 61, 1, NULL, '2022-08-03 13:27:11', '2022-08-03 13:27:11', NULL, NULL),
(291, 61, 2, 1, '2022-08-03 13:28:25', '2022-08-03 13:28:25', NULL, NULL),
(292, 57, 4, 1, '2022-08-03 14:37:39', '2022-08-03 14:37:39', NULL, NULL),
(293, 62, 1, NULL, '2022-08-03 16:09:08', '2022-08-03 16:09:08', NULL, NULL),
(294, 62, 2, 1, '2022-08-03 16:17:06', '2022-08-03 16:17:06', NULL, NULL),
(295, 63, 1, NULL, '2022-08-03 16:56:24', '2022-08-03 16:56:24', NULL, NULL),
(296, 63, 2, 1, '2022-08-03 16:56:57', '2022-08-03 16:56:57', NULL, NULL),
(297, 64, 1, NULL, '2022-08-03 21:41:16', '2022-08-03 21:41:16', NULL, NULL),
(298, 55, 4, 1, '2022-08-04 09:33:53', '2022-08-04 09:33:53', NULL, NULL),
(299, 63, 4, 1, '2022-08-04 09:34:12', '2022-08-04 09:34:12', NULL, NULL),
(300, 61, 4, 1, '2022-08-04 09:35:45', '2022-08-04 09:35:45', NULL, NULL),
(301, 60, 4, 1, '2022-08-04 09:35:45', '2022-08-04 09:35:45', NULL, NULL),
(302, 59, 4, 1, '2022-08-04 09:35:45', '2022-08-04 09:35:45', NULL, NULL),
(303, 58, 4, 1, '2022-08-04 09:35:46', '2022-08-04 09:35:46', NULL, NULL),
(304, 56, 4, 1, '2022-08-04 09:36:42', '2022-08-04 09:36:42', NULL, NULL),
(305, 64, 6, 1, '2022-08-04 10:33:28', '2022-08-04 10:33:28', NULL, NULL),
(306, 62, 6, 1000002, '2022-08-04 13:09:19', '2022-08-04 13:09:19', NULL, NULL),
(307, 65, 1, NULL, '2022-08-04 13:10:36', '2022-08-04 13:10:36', NULL, NULL),
(308, 65, 2, 1, '2022-08-04 13:19:45', '2022-08-04 13:19:45', NULL, NULL),
(309, 54, 6, 1000021, '2022-08-04 13:19:59', '2022-08-04 13:19:59', NULL, NULL),
(310, 54, 6, 1, '2022-08-04 13:20:20', '2022-08-04 13:20:20', NULL, NULL),
(311, 66, 1, NULL, '2022-08-04 13:20:29', '2022-08-04 13:20:29', NULL, NULL),
(312, 66, 2, 1, '2022-08-04 13:21:08', '2022-08-04 13:21:08', NULL, NULL),
(313, 65, 6, 1000002, '2022-08-04 13:28:38', '2022-08-04 13:28:38', NULL, NULL),
(314, 67, 1, NULL, '2022-08-04 13:30:40', '2022-08-04 13:30:40', NULL, NULL),
(315, 67, 2, 1, '2022-08-04 13:38:46', '2022-08-04 13:38:46', NULL, NULL),
(316, 68, 1, NULL, '2022-08-04 14:04:31', '2022-08-04 14:04:31', NULL, NULL),
(317, 68, 6, 1, '2022-08-04 14:20:23', '2022-08-04 14:20:23', NULL, NULL),
(318, 69, 1, NULL, '2022-08-04 14:22:38', '2022-08-04 14:22:38', NULL, NULL),
(319, 69, 2, 1, '2022-08-04 14:27:19', '2022-08-04 14:27:19', NULL, NULL),
(320, 70, 1, NULL, '2022-08-04 15:51:27', '2022-08-04 15:51:27', NULL, NULL),
(321, 70, 6, 1, '2022-08-04 15:53:27', '2022-08-04 15:53:27', NULL, NULL),
(322, 71, 1, NULL, '2022-08-06 03:53:30', '2022-08-06 03:53:30', NULL, NULL),
(323, 71, 6, 1, '2022-08-06 10:46:04', '2022-08-06 10:46:04', NULL, NULL),
(324, 72, 1, NULL, '2022-08-06 10:56:35', '2022-08-06 10:56:35', NULL, NULL),
(325, 73, 1, NULL, '2022-08-06 12:40:47', '2022-08-06 12:40:47', NULL, NULL),
(326, 67, 6, 1000002, '2022-08-06 13:32:48', '2022-08-06 13:32:48', NULL, NULL),
(327, 74, 1, NULL, '2022-08-06 13:33:44', '2022-08-06 13:33:44', NULL, NULL),
(328, 75, 1, NULL, '2022-08-06 14:39:18', '2022-08-06 14:39:18', NULL, NULL),
(329, 74, 2, 1, '2022-08-06 14:39:57', '2022-08-06 14:39:57', NULL, NULL),
(330, 75, 2, 1, '2022-08-06 14:40:21', '2022-08-06 14:40:21', NULL, NULL),
(331, 73, 6, 1000008, '2022-08-06 14:42:22', '2022-08-06 14:42:22', NULL, NULL),
(332, 76, 1, NULL, '2022-08-06 14:43:20', '2022-08-06 14:43:20', NULL, NULL),
(333, 73, 6, 1, '2022-08-06 15:03:15', '2022-08-06 15:03:15', NULL, NULL),
(334, 77, 1, NULL, '2022-08-06 15:03:23', '2022-08-06 15:03:23', NULL, NULL),
(335, 76, 2, 1, '2022-08-06 15:34:14', '2022-08-06 15:34:14', NULL, NULL),
(336, 72, 6, 1, '2022-08-07 08:44:30', '2022-08-07 08:44:30', NULL, NULL),
(337, 76, 4, 1, '2022-08-07 10:39:17', '2022-08-07 10:39:17', NULL, NULL),
(338, 75, 4, 1, '2022-08-07 10:39:18', '2022-08-07 10:39:18', NULL, NULL),
(339, 77, 2, 1, '2022-08-07 10:51:15', '2022-08-07 10:51:15', NULL, NULL),
(340, 77, 6, 1000023, '2022-08-08 12:30:16', '2022-08-08 12:30:16', NULL, NULL),
(341, 78, 1, NULL, '2022-08-08 14:00:26', '2022-08-08 14:00:26', NULL, NULL),
(342, 78, 6, 1, '2022-08-08 14:12:57', '2022-08-08 14:12:57', NULL, NULL),
(343, 74, 4, 1, '2022-08-09 11:12:16', '2022-08-09 11:12:16', NULL, NULL),
(344, 66, 6, 1, '2022-08-09 11:27:53', '2022-08-09 11:27:53', NULL, NULL),
(345, 69, 6, 1, '2022-08-09 11:28:28', '2022-08-09 11:28:28', NULL, NULL),
(346, 79, 1, NULL, '2022-08-09 13:34:18', '2022-08-09 13:34:18', NULL, NULL),
(347, 80, 1, NULL, '2022-08-09 14:03:53', '2022-08-09 14:03:53', NULL, NULL),
(348, 79, 2, 1, '2022-08-09 14:16:31', '2022-08-09 14:16:31', NULL, NULL),
(349, 80, 2, 1, '2022-08-09 14:17:06', '2022-08-09 14:17:06', NULL, NULL),
(350, 67, 6, 1, '2022-08-09 14:34:38', '2022-08-09 14:34:38', NULL, NULL),
(351, 65, 6, 1, '2022-08-09 14:38:39', '2022-08-09 14:38:39', NULL, NULL),
(352, 81, 1, NULL, '2022-08-09 16:52:51', '2022-08-09 16:52:51', NULL, NULL),
(353, 81, 2, 1, '2022-08-09 16:55:30', '2022-08-09 16:55:30', NULL, NULL),
(354, 79, 4, 1, '2022-08-10 12:49:53', '2022-08-10 12:49:53', NULL, NULL),
(355, 79, 7, 1, '2022-08-10 12:57:09', '2022-08-10 12:57:09', NULL, NULL),
(356, 82, 1, NULL, '2022-08-10 13:01:02', '2022-08-10 13:01:02', NULL, NULL),
(357, 82, 2, 1, '2022-08-10 13:02:16', '2022-08-10 13:02:16', NULL, NULL),
(358, 83, 1, NULL, '2022-08-10 15:01:32', '2022-08-10 15:01:32', NULL, NULL),
(359, 83, 6, 1000011, '2022-08-10 15:01:59', '2022-08-10 15:01:59', NULL, NULL),
(360, 84, 1, NULL, '2022-08-13 04:07:09', '2022-08-13 04:07:09', NULL, NULL),
(361, 84, 2, 1, '2022-08-13 19:04:36', '2022-08-13 19:04:36', NULL, NULL),
(362, 82, 6, 1000002, '2022-08-14 10:52:06', '2022-08-14 10:52:06', NULL, NULL),
(363, 85, 1, NULL, '2022-08-14 10:57:40', '2022-08-14 10:57:40', NULL, NULL),
(364, 85, 2, 1, '2022-08-14 12:18:31', '2022-08-14 12:18:31', NULL, NULL),
(365, 85, 6, 1, '2022-08-14 12:24:28', '2022-08-14 12:24:28', NULL, NULL),
(366, 85, 6, 1000002, '2022-08-14 12:24:55', '2022-08-14 12:24:55', NULL, NULL),
(367, 86, 1, NULL, '2022-08-14 12:26:17', '2022-08-14 12:26:17', NULL, NULL),
(368, 86, 2, 1, '2022-08-14 12:33:14', '2022-08-14 12:33:14', NULL, NULL),
(369, 86, 4, 1, '2022-08-14 18:13:51', '2022-08-14 18:13:51', NULL, NULL),
(370, 84, 4, 1, '2022-08-14 18:14:06', '2022-08-14 18:14:06', NULL, NULL),
(371, 62, 6, 1, '2022-08-15 15:09:45', '2022-08-15 15:09:45', NULL, NULL),
(372, 87, 1, NULL, '2022-08-15 15:20:33', '2022-08-15 15:20:33', NULL, NULL),
(373, 87, 2, 1, '2022-08-15 15:21:26', '2022-08-15 15:21:26', NULL, NULL),
(374, 88, 1, NULL, '2022-08-17 21:54:54', '2022-08-17 21:54:54', NULL, NULL),
(375, 87, 6, 1000002, '2022-08-18 07:55:33', '2022-08-18 07:55:33', NULL, NULL),
(376, 89, 1, NULL, '2022-08-18 07:56:47', '2022-08-18 07:56:47', NULL, NULL),
(377, 89, 2, 1, '2022-08-18 09:26:23', '2022-08-18 09:26:23', NULL, NULL),
(378, 88, 6, 1, '2022-08-18 09:31:03', '2022-08-18 09:31:03', NULL, NULL),
(379, 89, 6, 1000002, '2022-08-20 17:48:36', '2022-08-20 17:48:36', NULL, NULL),
(380, 90, 1, NULL, '2022-08-20 17:49:30', '2022-08-20 17:49:30', NULL, NULL),
(381, 87, 6, 1, '2022-08-21 08:57:58', '2022-08-21 08:57:58', NULL, NULL),
(382, 89, 6, 1, '2022-08-21 08:58:24', '2022-08-21 08:58:24', NULL, NULL),
(383, 90, 2, 1, '2022-08-21 08:58:50', '2022-08-21 08:58:50', NULL, NULL),
(384, 85, 6, 1, '2022-08-21 08:59:27', '2022-08-21 08:59:27', NULL, NULL),
(385, 90, 6, 1000002, '2022-08-21 12:34:56', '2022-08-21 12:34:56', NULL, NULL),
(386, 91, 1, NULL, '2022-08-21 12:36:53', '2022-08-21 12:36:53', NULL, NULL),
(387, 90, 6, 1, '2022-08-21 12:39:10', '2022-08-21 12:39:10', NULL, NULL),
(388, 91, 2, 1, '2022-08-21 12:39:58', '2022-08-21 12:39:58', NULL, NULL),
(389, 82, 6, 1, '2022-08-21 16:23:41', '2022-08-21 16:23:41', NULL, NULL),
(390, 8, 6, 1, '2022-08-21 16:24:13', '2022-08-21 16:24:13', NULL, NULL),
(391, 62, 6, 1, '2022-08-21 16:24:23', '2022-08-21 16:24:23', NULL, NULL),
(392, 91, 4, 1, '2022-08-21 17:12:38', '2022-08-21 17:12:38', NULL, NULL),
(393, 77, 6, 1, '2022-08-21 17:13:09', '2022-08-21 17:13:09', NULL, NULL),
(394, 92, 1, NULL, '2022-08-22 04:18:07', '2022-08-22 04:18:07', NULL, NULL),
(395, 92, 2, 1, '2022-08-22 15:30:27', '2022-08-22 15:30:27', NULL, NULL),
(396, 92, 4, 1, '2022-08-23 16:30:50', '2022-08-23 16:30:50', NULL, NULL),
(397, 93, 1, NULL, '2022-08-29 15:52:57', '2022-08-29 15:52:57', NULL, NULL),
(398, 93, 2, 1, '2022-08-31 10:08:25', '2022-08-31 10:08:25', NULL, NULL),
(399, 93, 4, 1, '2022-08-31 16:51:49', '2022-08-31 16:51:49', NULL, NULL),
(400, 94, 1, NULL, '2022-09-11 06:05:46', '2022-09-11 06:05:46', NULL, NULL),
(401, 94, 2, 1, '2022-09-13 13:37:53', '2022-09-13 13:37:53', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_pickups`
--

CREATE TABLE `order_pickups` (
  `pickup_id` bigint(20) UNSIGNED DEFAULT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `shipping_id` bigint(20) DEFAULT NULL,
  `foreign_hawb` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipment_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `update_description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tracking_result` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_products`
--

CREATE TABLE `order_products` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED DEFAULT NULL,
  `amount` decimal(8,2) NOT NULL,
  `missing` tinyint(1) NOT NULL DEFAULT 0,
  `cancelled` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `price_id` int(10) UNSIGNED DEFAULT NULL,
  `rate` decimal(8,2) DEFAULT NULL,
  `returned_quantity` int(11) DEFAULT NULL,
  `price` decimal(8,2) DEFAULT NULL,
  `discount_price` decimal(8,2) DEFAULT NULL,
  `preorder` tinyint(1) DEFAULT 0,
  `preorder_price` int(11) DEFAULT NULL,
  `remaining` decimal(8,2) DEFAULT NULL,
  `serial_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bundle_id` int(11) DEFAULT NULL,
  `affiliate_commission` decimal(8,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_products`
--

INSERT INTO `order_products` (`id`, `order_id`, `product_id`, `amount`, `missing`, `cancelled`, `created_at`, `updated_at`, `price_id`, `rate`, `returned_quantity`, `price`, `discount_price`, `preorder`, `preorder_price`, `remaining`, `serial_number`, `bundle_id`, `affiliate_commission`) VALUES
(1, 1, 166, '1.00', 0, 0, '2022-07-20 15:58:48', '2022-07-20 15:58:48', 498752, NULL, NULL, '22785.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(2, 1, 10, '5.00', 0, 0, '2022-07-20 15:58:48', '2022-07-20 15:58:48', 498725, NULL, NULL, '51250.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(3, 1, 186, '1.00', 0, 0, '2022-07-20 15:58:49', '2022-07-20 15:58:49', 498763, NULL, NULL, '16860.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(4, 2, 8, '4.00', 0, 0, '2022-07-21 11:31:41', '2022-07-21 11:31:41', 498748, NULL, NULL, '41000.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(5, 2, 10, '2.00', 0, 0, '2022-07-21 11:31:41', '2022-07-21 11:31:41', 498725, NULL, NULL, '20500.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(6, 3, 8, '4.00', 0, 0, '2022-07-21 11:37:29', '2022-07-21 11:37:29', 498748, NULL, NULL, '41000.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(7, 3, 10, '1.00', 0, 0, '2022-07-21 11:37:29', '2022-07-21 11:37:29', 498725, NULL, NULL, '10250.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(8, 4, 168, '0.50', 0, 0, '2022-07-23 14:55:23', '2022-07-23 14:55:23', 498753, NULL, NULL, '11392.50', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(9, 4, 166, '0.50', 0, 0, '2022-07-23 14:55:23', '2022-07-23 14:55:23', 498752, NULL, NULL, '11392.50', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(10, 4, 8, '3.00', 0, 0, '2022-07-23 14:55:23', '2022-07-23 14:55:23', 498748, NULL, NULL, '30750.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(11, 4, 10, '2.00', 0, 0, '2022-07-23 14:55:23', '2022-07-23 14:55:23', 498725, NULL, NULL, '20500.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(12, 5, 10, '5.00', 0, 0, '2022-07-24 10:51:02', '2022-07-24 10:51:02', 498725, NULL, NULL, '51250.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(13, 6, 10, '5.00', 0, 0, '2022-07-25 10:47:03', '2022-07-25 10:47:03', 498725, NULL, NULL, '51250.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(14, 7, 8, '3.00', 0, 0, '2022-07-25 10:56:44', '2022-07-25 10:56:44', 498748, NULL, NULL, '30750.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(15, 7, 10, '2.00', 0, 0, '2022-07-25 10:56:44', '2022-07-25 10:56:44', 498725, NULL, NULL, '20500.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(16, 8, 168, '2.00', 0, 0, '2022-07-25 12:21:18', '2022-07-25 12:21:18', 498753, NULL, NULL, '45570.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(17, 8, 172, '0.50', 0, 0, '2022-07-25 12:21:18', '2022-07-25 12:21:18', 498727, NULL, NULL, '6835.50', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(18, 9, 172, '5.00', 0, 0, '2022-07-25 12:44:07', '2022-07-25 12:44:07', 498727, NULL, NULL, '68355.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(19, 10, 8, '4.00', 0, 0, '2022-07-25 15:40:30', '2022-07-25 15:40:30', 498748, NULL, NULL, '41000.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(20, 10, 10, '1.00', 0, 0, '2022-07-25 15:40:30', '2022-07-25 15:40:30', 498725, NULL, NULL, '10250.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(21, 11, 174, '0.50', 0, 0, '2022-07-26 04:54:22', '2022-07-26 04:54:22', 498728, NULL, NULL, '11392.50', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(22, 11, 172, '1.00', 0, 0, '2022-07-26 04:54:22', '2022-07-26 04:54:22', 498727, NULL, NULL, '13671.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(23, 11, 8, '5.00', 0, 0, '2022-07-26 04:54:22', '2022-07-26 04:54:22', 498748, NULL, NULL, '51250.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(24, 11, 10, '5.00', 0, 0, '2022-07-26 04:54:22', '2022-07-26 04:54:22', 498725, NULL, NULL, '51250.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(25, 12, 172, '1.00', 0, 0, '2022-07-26 04:59:15', '2022-07-26 04:59:15', 498727, NULL, NULL, '13671.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(26, 12, 8, '3.00', 0, 0, '2022-07-26 04:59:15', '2022-07-26 04:59:15', 498748, NULL, NULL, '30750.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(27, 12, 10, '1.00', 0, 0, '2022-07-26 04:59:15', '2022-07-26 04:59:15', 498725, NULL, NULL, '10250.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(28, 13, 8, '5.00', 0, 0, '2022-07-26 11:57:45', '2022-07-26 11:57:45', 498748, NULL, NULL, '51250.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(29, 14, 8, '5.00', 0, 0, '2022-07-26 12:00:59', '2022-07-26 12:00:59', 498748, NULL, NULL, '51250.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(30, 15, 172, '1.00', 0, 0, '2022-07-26 12:42:00', '2022-07-26 12:42:00', 498727, NULL, NULL, '13671.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(31, 15, 8, '5.00', 0, 0, '2022-07-26 12:42:00', '2022-07-26 12:42:00', 498748, NULL, NULL, '51250.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(32, 16, 172, '5.00', 0, 0, '2022-07-27 15:59:25', '2022-07-27 15:59:25', 498727, NULL, NULL, '68355.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(33, 16, 10, '5.00', 0, 0, '2022-07-27 15:59:25', '2022-07-27 15:59:25', 498725, NULL, NULL, '51250.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(34, 17, 192, '60.00', 0, 0, '2022-07-27 17:06:05', '2022-07-27 17:06:05', 498762, NULL, NULL, '56400.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(35, 18, 8, '5.00', 0, 0, '2022-07-27 18:14:06', '2022-07-27 18:14:06', 498748, NULL, NULL, '51250.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(36, 19, 8, '3.00', 0, 0, '2022-07-28 00:37:25', '2022-07-28 00:37:25', 498748, NULL, NULL, '30750.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(37, 19, 10, '2.00', 0, 0, '2022-07-28 00:37:25', '2022-07-28 00:37:25', 498725, NULL, NULL, '20500.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(38, 20, 172, '5.00', 0, 0, '2022-07-28 12:12:47', '2022-07-28 12:12:47', 498727, NULL, NULL, '68355.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(39, 20, 8, '4.00', 0, 0, '2022-07-28 12:12:47', '2022-07-28 12:12:47', 498748, NULL, NULL, '41000.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(40, 20, 10, '1.00', 0, 0, '2022-07-28 12:12:47', '2022-07-28 12:12:47', 498725, NULL, NULL, '10250.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(41, 21, 10, '1.00', 0, 0, '2022-07-28 12:17:39', '2022-07-28 12:17:39', 498725, NULL, NULL, '10250.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(42, 21, 8, '4.00', 0, 0, '2022-07-28 12:17:39', '2022-07-28 12:17:39', 498748, NULL, NULL, '41000.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(43, 22, 8, '5.00', 0, 0, '2022-07-28 13:48:59', '2022-07-28 13:48:59', 498748, NULL, NULL, '51250.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(44, 22, 10, '1.00', 0, 0, '2022-07-28 13:48:59', '2022-07-28 13:48:59', 498725, NULL, NULL, '10250.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(45, 23, 8, '10.00', 0, 0, '2022-07-29 04:14:10', '2022-07-29 04:14:10', 498748, NULL, NULL, '102500.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(46, 24, 166, '0.50', 0, 0, '2022-07-30 16:24:53', '2022-07-30 16:24:53', 498752, NULL, NULL, '11392.50', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(47, 24, 168, '0.50', 0, 0, '2022-07-30 16:24:53', '2022-07-30 16:24:53', 498753, NULL, NULL, '11392.50', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(48, 24, 174, '0.50', 0, 0, '2022-07-30 16:24:53', '2022-07-30 16:24:53', 498728, NULL, NULL, '11392.50', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(49, 24, 8, '10.00', 0, 0, '2022-07-30 16:24:53', '2022-07-30 16:24:53', 498748, NULL, NULL, '102500.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(50, 25, 8, '5.00', 0, 0, '2022-07-31 11:51:29', '2022-07-31 11:51:29', 498748, NULL, NULL, '51250.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(51, 25, 10, '5.00', 0, 0, '2022-07-31 11:51:29', '2022-07-31 11:51:29', 498725, NULL, NULL, '51250.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(52, 26, 8, '33.00', 0, 0, '2022-07-31 13:14:18', '2022-07-31 13:14:18', 498748, NULL, NULL, '338250.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(53, 26, 10, '1.00', 0, 0, '2022-07-31 13:14:18', '2022-07-31 13:14:18', 498725, NULL, NULL, '10250.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(54, 27, 8, '9.00', 0, 0, '2022-07-31 13:19:06', '2022-07-31 13:19:06', 498748, NULL, NULL, '92250.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(55, 27, 10, '1.00', 0, 0, '2022-07-31 13:19:06', '2022-07-31 13:19:06', 498725, NULL, NULL, '10250.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(56, 28, 10, '3.00', 0, 0, '2022-07-31 17:05:39', '2022-07-31 17:05:39', 498725, NULL, NULL, '30750.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(57, 28, 8, '2.00', 0, 0, '2022-07-31 17:05:39', '2022-07-31 17:05:39', 498748, NULL, NULL, '20500.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(58, 29, 10, '1.00', 0, 0, '2022-07-31 17:21:44', '2022-07-31 17:21:44', 498725, NULL, NULL, '10250.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(59, 29, 8, '4.00', 0, 0, '2022-07-31 17:21:44', '2022-07-31 17:21:44', 498748, NULL, NULL, '41000.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(60, 30, 10, '4.00', 0, 0, '2022-08-01 13:07:04', '2022-08-01 13:07:04', 498725, NULL, NULL, '41000.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(61, 30, 8, '11.00', 0, 0, '2022-08-01 13:07:04', '2022-08-01 13:07:04', 498748, NULL, NULL, '112750.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(62, 31, 22, '0.50', 0, 0, '2022-08-01 13:20:29', '2022-08-01 13:20:29', 498749, NULL, NULL, '6650.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(63, 31, 188, '1.00', 0, 0, '2022-08-01 13:20:29', '2022-08-01 13:20:29', 498759, NULL, NULL, '13300.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(64, 31, 8, '5.00', 0, 0, '2022-08-01 13:20:29', '2022-08-01 13:20:29', 498748, NULL, NULL, '51250.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(65, 31, 10, '1.00', 0, 0, '2022-08-01 13:20:29', '2022-08-01 13:20:29', 498725, NULL, NULL, '10250.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(66, 32, 10, '1.00', 0, 0, '2022-08-01 14:42:23', '2022-08-01 14:42:23', 498725, NULL, NULL, '10250.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(67, 32, 8, '4.00', 0, 0, '2022-08-01 14:42:23', '2022-08-01 14:42:23', 498748, NULL, NULL, '41000.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(68, 33, 10, '1.00', 0, 0, '2022-08-01 19:29:55', '2022-08-01 19:29:55', 498725, NULL, NULL, '10250.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(69, 33, 8, '4.00', 0, 0, '2022-08-01 19:29:55', '2022-08-01 19:29:55', 498748, NULL, NULL, '41000.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(70, 34, 8, '5.00', 0, 0, '2022-08-02 03:48:28', '2022-08-02 03:48:28', 498748, NULL, NULL, '51250.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(71, 35, 48, '1.00', 0, 0, '2022-08-02 12:57:37', '2022-08-02 12:57:37', 498755, NULL, NULL, '280.70', '0.00', 0, NULL, NULL, NULL, NULL, NULL),
(72, 35, 162, '1.00', 0, 0, '2022-08-02 12:57:37', '2022-08-02 12:57:37', 498757, NULL, NULL, '16860.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(73, 36, 8, '8.00', 0, 0, '2022-08-02 13:22:15', '2022-08-02 13:22:15', 498748, NULL, NULL, '82000.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(74, 36, 10, '2.00', 0, 0, '2022-08-02 13:22:15', '2022-08-02 13:22:15', 498725, NULL, NULL, '20500.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(75, 37, 8, '4.00', 0, 0, '2022-08-02 13:41:51', '2022-08-02 13:41:51', 498748, NULL, NULL, '41000.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(76, 37, 10, '1.00', 0, 0, '2022-08-02 13:41:51', '2022-08-02 13:41:51', 498725, NULL, NULL, '10250.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(77, 38, 8, '9.00', 0, 0, '2022-08-02 13:44:45', '2022-08-02 13:44:45', 498748, NULL, NULL, '92250.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(78, 38, 10, '1.00', 0, 0, '2022-08-02 13:44:45', '2022-08-02 13:44:45', 498725, NULL, NULL, '10250.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(79, 38, 172, '5.00', 0, 0, '2022-08-02 13:44:45', '2022-08-02 13:44:45', 498727, NULL, NULL, '68355.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(80, 39, 8, '50.00', 0, 0, '2022-08-02 13:49:42', '2022-08-02 13:49:42', 498748, NULL, NULL, '512500.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(81, 39, 10, '1.00', 0, 0, '2022-08-02 13:49:42', '2022-08-02 13:49:42', 498725, NULL, NULL, '10250.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(82, 40, 10, '1.00', 0, 0, '2022-08-02 14:19:23', '2022-08-02 14:19:23', 498725, NULL, NULL, '10250.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(83, 40, 8, '10.00', 0, 0, '2022-08-02 14:19:24', '2022-08-02 14:19:24', 498748, NULL, NULL, '102500.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(84, 41, 10, '7.00', 0, 0, '2022-08-02 15:07:44', '2022-08-02 15:07:44', 498725, NULL, NULL, '71750.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(85, 41, 8, '7.00', 0, 0, '2022-08-02 15:07:44', '2022-08-02 15:07:44', 498748, NULL, NULL, '71750.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(86, 41, 188, '0.50', 0, 0, '2022-08-02 15:07:44', '2022-08-02 15:07:44', 498759, NULL, NULL, '6650.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(87, 41, 22, '0.50', 0, 0, '2022-08-02 15:07:44', '2022-08-02 15:07:44', 498749, NULL, NULL, '6650.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(88, 41, 190, '0.50', 0, 0, '2022-08-02 15:07:44', '2022-08-02 15:07:44', 498761, NULL, NULL, '6650.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(89, 42, 10, '1.00', 0, 0, '2022-08-02 15:10:03', '2022-08-02 15:10:03', 498725, NULL, NULL, '10250.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(90, 42, 8, '1.00', 0, 0, '2022-08-02 15:10:04', '2022-08-02 15:10:04', 498748, NULL, NULL, '10250.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(91, 42, 188, '0.50', 0, 0, '2022-08-02 15:10:04', '2022-08-02 15:10:04', 498759, NULL, NULL, '6650.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(92, 42, 190, '0.50', 0, 0, '2022-08-02 15:10:04', '2022-08-02 15:10:04', 498761, NULL, NULL, '6650.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(93, 42, 22, '0.50', 0, 0, '2022-08-02 15:10:04', '2022-08-02 15:10:04', 498749, NULL, NULL, '6650.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(94, 43, 8, '1.00', 0, 0, '2022-08-02 16:54:40', '2022-08-02 16:54:40', 498748, NULL, NULL, '10250.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(95, 43, 10, '1.00', 0, 0, '2022-08-02 16:54:40', '2022-08-02 16:54:40', 498725, NULL, NULL, '10250.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(96, 44, 10, '2.00', 0, 0, '2022-08-02 18:57:54', '2022-08-02 18:57:54', 498725, NULL, NULL, '20500.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(97, 44, 8, '3.00', 0, 0, '2022-08-02 18:57:54', '2022-08-02 18:57:54', 498748, NULL, NULL, '30750.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(98, 45, 8, '3.00', 0, 0, '2022-08-02 23:24:10', '2022-08-02 23:24:10', 498748, NULL, NULL, '30750.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(99, 45, 10, '2.00', 0, 0, '2022-08-02 23:24:11', '2022-08-02 23:24:11', 498725, NULL, NULL, '20500.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(100, 46, 10, '2.00', 0, 0, '2022-08-03 09:26:21', '2022-08-03 09:26:21', 498725, NULL, NULL, '20500.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(101, 46, 8, '1.00', 0, 0, '2022-08-03 09:26:21', '2022-08-03 09:26:21', 498748, NULL, NULL, '10250.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(102, 47, 10, '2.00', 0, 0, '2022-08-03 09:28:40', '2022-08-03 09:28:40', 498725, NULL, NULL, '20500.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(103, 48, 8, '1.00', 0, 0, '2022-08-03 09:33:06', '2022-08-03 09:33:06', 498748, NULL, NULL, '10250.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(104, 48, 10, '1.00', 0, 0, '2022-08-03 09:33:06', '2022-08-03 09:33:06', 498725, NULL, NULL, '10250.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(105, 49, 10, '1.00', 0, 0, '2022-08-03 09:50:57', '2022-08-03 09:50:57', 498725, NULL, NULL, '10250.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(106, 49, 8, '1.00', 0, 0, '2022-08-03 09:50:57', '2022-08-03 09:50:57', 498748, NULL, NULL, '10250.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(107, 50, 8, '7.00', 0, 0, '2022-08-03 11:16:20', '2022-08-03 11:16:20', 498748, NULL, NULL, '71750.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(108, 50, 10, '5.00', 0, 0, '2022-08-03 11:16:20', '2022-08-03 11:16:20', 498725, NULL, NULL, '51250.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(109, 51, 10, '1.00', 0, 0, '2022-08-03 11:34:51', '2022-08-03 11:34:51', 498725, NULL, NULL, '10250.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(110, 51, 8, '1.00', 0, 0, '2022-08-03 11:34:51', '2022-08-03 11:34:51', 498748, NULL, NULL, '10250.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(111, 52, 8, '0.50', 0, 0, '2022-08-03 11:44:09', '2022-08-03 11:44:09', 498748, NULL, NULL, '5125.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(112, 52, 10, '0.50', 0, 0, '2022-08-03 11:44:09', '2022-08-03 11:44:09', 498725, NULL, NULL, '5125.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(113, 53, 8, '1.00', 0, 0, '2022-08-03 11:47:35', '2022-08-03 11:47:35', 498748, NULL, NULL, '10250.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(114, 53, 10, '1.00', 0, 0, '2022-08-03 11:47:35', '2022-08-03 11:47:35', 498725, NULL, NULL, '10250.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(115, 54, 8, '2.00', 0, 0, '2022-08-03 12:44:15', '2022-08-03 12:44:15', 498748, NULL, NULL, '20500.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(116, 55, 8, '2.00', 0, 0, '2022-08-03 12:52:54', '2022-08-03 12:52:54', 498748, NULL, NULL, '20500.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(117, 56, 8, '2.00', 0, 0, '2022-08-03 12:55:51', '2022-08-03 12:55:51', 498748, NULL, NULL, '20500.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(118, 57, 8, '2.00', 0, 0, '2022-08-03 13:01:11', '2022-08-03 13:01:11', 498748, NULL, NULL, '20500.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(119, 58, 8, '2.00', 0, 0, '2022-08-03 13:08:40', '2022-08-03 13:08:40', 498748, NULL, NULL, '20500.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(120, 59, 8, '2.00', 0, 0, '2022-08-03 13:13:01', '2022-08-03 13:13:01', 498748, NULL, NULL, '20500.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(121, 60, 8, '2.00', 0, 0, '2022-08-03 13:21:08', '2022-08-03 13:21:08', 498748, NULL, NULL, '20500.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(122, 61, 8, '2.00', 0, 0, '2022-08-03 13:27:11', '2022-08-03 13:27:11', 498748, NULL, NULL, '20500.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(123, 62, 8, '2.00', 0, 0, '2022-08-03 16:09:08', '2022-08-03 16:09:08', 498748, NULL, NULL, '20500.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(124, 63, 8, '2.00', 0, 0, '2022-08-03 16:56:24', '2022-08-03 16:56:24', 498748, NULL, NULL, '20500.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(125, 64, 8, '3.00', 0, 0, '2022-08-03 21:41:16', '2022-08-03 21:41:16', 498748, NULL, NULL, '30750.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(126, 65, 166, '2.00', 0, 0, '2022-08-04 13:10:36', '2022-08-04 13:10:36', 498752, NULL, NULL, '45570.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(127, 66, 10, '2.00', 0, 0, '2022-08-04 13:20:29', '2022-08-04 13:20:29', 498725, NULL, NULL, '20500.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(128, 67, 10, '2.00', 0, 0, '2022-08-04 13:30:40', '2022-08-04 13:30:40', 498725, NULL, NULL, '20500.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(129, 67, 166, '2.00', 0, 0, '2022-08-04 13:30:40', '2022-08-04 13:30:40', 498752, NULL, NULL, '45570.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(130, 68, 8, '2.00', 0, 0, '2022-08-04 14:04:31', '2022-08-04 14:04:31', 498748, NULL, NULL, '20500.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(131, 68, 10, '5.00', 0, 0, '2022-08-04 14:04:31', '2022-08-04 14:04:31', 498725, NULL, NULL, '51250.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(132, 69, 10, '2.00', 0, 0, '2022-08-04 14:22:38', '2022-08-04 14:22:38', 498725, NULL, NULL, '20500.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(133, 70, 10, '14.00', 0, 0, '2022-08-04 15:51:27', '2022-08-04 15:51:27', 498725, NULL, NULL, '143500.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(134, 70, 8, '2.00', 0, 0, '2022-08-04 15:51:27', '2022-08-04 15:51:27', 498748, NULL, NULL, '20500.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(135, 71, 10, '10.00', 0, 0, '2022-08-06 03:53:30', '2022-08-06 03:53:30', 498725, NULL, NULL, '102500.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(136, 72, 10, '10.00', 0, 0, '2022-08-06 10:56:35', '2022-08-06 10:56:35', 498725, NULL, NULL, '102500.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(137, 73, 22, '5.00', 0, 0, '2022-08-06 12:40:47', '2022-08-06 12:40:47', 498749, NULL, NULL, '66500.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(138, 73, 174, '5.00', 0, 0, '2022-08-06 12:40:47', '2022-08-06 12:40:47', 498728, NULL, NULL, '113925.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(139, 73, 168, '10.00', 0, 0, '2022-08-06 12:40:47', '2022-08-06 12:40:47', 498753, NULL, NULL, '227850.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(140, 73, 166, '5.00', 0, 0, '2022-08-06 12:40:47', '2022-08-06 12:40:47', 498752, NULL, NULL, '113925.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(141, 74, 166, '5.00', 0, 0, '2022-08-06 13:33:44', '2022-08-06 13:33:44', 498752, NULL, NULL, '113925.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(142, 75, 168, '1.00', 0, 0, '2022-08-06 14:39:18', '2022-08-06 14:39:18', 498753, NULL, NULL, '22785.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(143, 75, 174, '0.50', 0, 0, '2022-08-06 14:39:18', '2022-08-06 14:39:18', 498728, NULL, NULL, '11392.50', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(144, 75, 166, '0.50', 0, 0, '2022-08-06 14:39:19', '2022-08-06 14:39:19', 498752, NULL, NULL, '11392.50', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(145, 76, 168, '10.00', 0, 0, '2022-08-06 14:43:21', '2022-08-06 14:43:21', 498753, NULL, NULL, '227850.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(146, 76, 174, '5.00', 0, 0, '2022-08-06 14:43:21', '2022-08-06 14:43:21', 498728, NULL, NULL, '113925.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(147, 76, 166, '5.00', 0, 0, '2022-08-06 14:43:21', '2022-08-06 14:43:21', 498752, NULL, NULL, '113925.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(148, 77, 10, '2.00', 0, 0, '2022-08-06 15:03:23', '2022-08-06 15:03:23', 498725, NULL, NULL, '20500.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(149, 78, 10, '2.00', 0, 0, '2022-08-08 14:00:26', '2022-08-08 14:00:26', 498725, NULL, NULL, '20500.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(150, 79, 166, '2.00', 0, 0, '2022-08-09 13:34:18', '2022-08-09 13:34:18', 498752, NULL, NULL, '45570.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(151, 79, 174, '1.00', 0, 0, '2022-08-09 13:34:18', '2022-08-09 13:34:18', 498728, NULL, NULL, '22785.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(152, 79, 168, '1.00', 0, 0, '2022-08-09 13:34:18', '2022-08-09 13:34:18', 498753, NULL, NULL, '22785.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(153, 80, 166, '1.00', 0, 0, '2022-08-09 14:03:53', '2022-08-09 14:03:53', 498752, NULL, NULL, '22785.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(154, 80, 168, '1.00', 0, 0, '2022-08-09 14:03:53', '2022-08-09 14:03:53', 498753, NULL, NULL, '22785.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(155, 81, 8, '2.00', 0, 0, '2022-08-09 16:52:51', '2022-08-09 16:52:51', 498748, NULL, NULL, '20500.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(156, 82, 166, '2.00', 0, 0, '2022-08-10 13:01:02', '2022-08-10 13:01:02', 498752, NULL, NULL, '45570.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(157, 82, 168, '1.00', 0, 0, '2022-08-10 13:01:02', '2022-08-10 13:01:02', 498753, NULL, NULL, '22785.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(158, 82, 174, '1.00', 0, 0, '2022-08-10 13:01:02', '2022-08-10 13:01:02', 498728, NULL, NULL, '22785.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(159, 83, 8, '0.50', 0, 0, '2022-08-10 15:01:32', '2022-08-10 15:01:32', 498748, NULL, NULL, '5125.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(160, 84, 190, '0.50', 0, 0, '2022-08-13 04:07:09', '2022-08-13 04:07:09', 498761, NULL, NULL, '6650.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(161, 84, 168, '1.00', 0, 0, '2022-08-13 04:07:09', '2022-08-13 04:07:09', 498753, NULL, NULL, '22785.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(162, 84, 174, '0.50', 0, 0, '2022-08-13 04:07:09', '2022-08-13 04:07:09', 498728, NULL, NULL, '11392.50', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(163, 85, 8, '1.00', 0, 0, '2022-08-14 10:57:40', '2022-08-14 10:57:40', 498748, NULL, NULL, '10250.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(164, 85, 188, '1.00', 0, 0, '2022-08-14 10:57:41', '2022-08-14 10:57:41', 498759, NULL, NULL, '13300.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(165, 85, 22, '1.00', 0, 0, '2022-08-14 10:57:41', '2022-08-14 10:57:41', 498749, NULL, NULL, '13300.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(166, 85, 190, '1.00', 0, 0, '2022-08-14 10:57:41', '2022-08-14 10:57:41', 498761, NULL, NULL, '13300.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(167, 86, 188, '1.00', 0, 0, '2022-08-14 12:26:17', '2022-08-14 12:26:17', 498759, NULL, NULL, '13300.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(168, 86, 190, '1.00', 0, 0, '2022-08-14 12:26:17', '2022-08-14 12:26:17', 498761, NULL, NULL, '13300.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(169, 86, 22, '1.00', 0, 0, '2022-08-14 12:26:17', '2022-08-14 12:26:17', 498749, NULL, NULL, '13300.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(170, 87, 166, '2.00', 0, 0, '2022-08-15 15:20:33', '2022-08-15 15:20:33', 498752, NULL, NULL, '45570.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(171, 87, 168, '2.00', 0, 0, '2022-08-15 15:20:33', '2022-08-15 15:20:33', 498753, NULL, NULL, '45570.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(172, 88, 166, '1.00', 0, 0, '2022-08-17 21:54:54', '2022-08-17 21:54:54', 498752, NULL, NULL, '22785.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(173, 89, 168, '2.00', 0, 0, '2022-08-18 07:56:47', '2022-08-18 07:56:47', 498753, NULL, NULL, '45570.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(174, 89, 174, '1.00', 0, 0, '2022-08-18 07:56:48', '2022-08-18 07:56:48', 498728, NULL, NULL, '22785.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(175, 90, 186, '2.00', 0, 0, '2022-08-20 17:49:30', '2022-08-20 17:49:30', 498763, NULL, NULL, '33720.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(176, 90, 170, '1.00', 0, 0, '2022-08-20 17:49:30', '2022-08-20 17:49:30', 498758, NULL, NULL, '16860.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(177, 90, 168, '2.00', 0, 0, '2022-08-20 17:49:31', '2022-08-20 17:49:31', 498753, NULL, NULL, '45570.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(178, 90, 174, '1.00', 0, 0, '2022-08-20 17:49:31', '2022-08-20 17:49:31', 498728, NULL, NULL, '22785.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(179, 91, 186, '2.00', 0, 0, '2022-08-21 12:36:53', '2022-08-21 12:36:53', 498763, NULL, NULL, '33720.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(180, 91, 170, '1.00', 0, 0, '2022-08-21 12:36:53', '2022-08-21 12:36:53', 498758, NULL, NULL, '16860.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(181, 91, 168, '6.00', 0, 0, '2022-08-21 12:36:53', '2022-08-21 12:36:53', 498753, NULL, NULL, '136710.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(182, 91, 174, '1.00', 0, 0, '2022-08-21 12:36:54', '2022-08-21 12:36:54', 498728, NULL, NULL, '22785.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(183, 92, 168, '2.00', 0, 0, '2022-08-22 04:18:07', '2022-08-22 04:18:07', 498753, NULL, NULL, '45570.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(184, 92, 174, '1.00', 0, 0, '2022-08-22 04:18:07', '2022-08-22 04:18:07', 498728, NULL, NULL, '22785.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(185, 93, 190, '1.00', 0, 0, '2022-08-29 15:52:57', '2022-08-29 15:52:57', 498761, NULL, NULL, '13300.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(186, 94, 170, '0.50', 0, 0, '2022-09-11 06:05:46', '2022-09-11 06:05:46', 498758, NULL, NULL, '8430.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(187, 94, 168, '1.00', 0, 0, '2022-09-11 06:05:46', '2022-09-11 06:05:46', 498753, NULL, NULL, '22785.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(188, 94, 174, '1.00', 0, 0, '2022-09-11 06:05:46', '2022-09-11 06:05:46', 498728, NULL, NULL, '22785.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(189, 94, 188, '0.50', 0, 0, '2022-09-11 06:05:46', '2022-09-11 06:05:46', 498759, NULL, NULL, '6650.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(190, 94, 190, '0.50', 0, 0, '2022-09-11 06:05:46', '2022-09-11 06:05:46', 498761, NULL, NULL, '6650.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(191, 94, 22, '0.50', 0, 0, '2022-09-11 06:05:46', '2022-09-11 06:05:46', 498749, NULL, NULL, '6650.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(192, 94, 162, '0.50', 0, 0, '2022-09-11 06:05:47', '2022-09-11 06:05:47', 498757, NULL, NULL, '8430.00', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(193, 94, 186, '0.50', 0, 0, '2022-09-11 06:05:47', '2022-09-11 06:05:47', 498763, NULL, NULL, '8430.00', NULL, 0, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_schedule`
--

CREATE TABLE `order_schedule` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `interval` int(11) NOT NULL,
  `time` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_states`
--

CREATE TABLE `order_states` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `parent_id` int(10) UNSIGNED DEFAULT NULL,
  `name_ar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `deactivation_notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `editable` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_states`
--

INSERT INTO `order_states` (`id`, `name`, `created_at`, `updated_at`, `parent_id`, `name_ar`, `active`, `deactivation_notes`, `editable`) VALUES
(1, 'Placed', NULL, NULL, NULL, 'تم الطلب', 1, NULL, 1),
(2, 'Confirmed', NULL, NULL, NULL, 'تم تأكيد الطلب', 1, NULL, 1),
(3, 'shipping', NULL, '2022-03-31 12:41:16', NULL, 'تم الشحن', 1, NULL, 1),
(4, 'Delivered', NULL, '2021-09-07 12:36:20', NULL, 'تم التوصيل', 1, NULL, 1),
(5, 'Investigation', NULL, NULL, NULL, 'قيد التحقق', 1, NULL, 0),
(6, 'Cancelled', NULL, NULL, NULL, 'تم الالغاء', 1, NULL, 1),
(7, 'Returned', NULL, NULL, NULL, 'تم الاسترجاع', 1, NULL, 1),
(8, 'Prepared', NULL, NULL, NULL, 'جاهزة للتسليم', 1, NULL, 1),
(9, 'In Completed', NULL, NULL, NULL, 'مكتمل', 1, NULL, 0),
(10, 'Partially Returned', NULL, NULL, NULL, 'تمت إرجاع جزء', 1, NULL, 0),
(11, 'Pending Payment', NULL, NULL, NULL, 'في انتظار الدفع', 1, NULL, 0),
(12, 'Pending Expired', NULL, NULL, NULL, 'انتهت الدفعة', 1, NULL, 0),
(13, 'Cant Delivered', NULL, NULL, NULL, 'غير قادر على التسليم', 1, NULL, 0),
(14, 'Delivery Failed', NULL, NULL, NULL, 'فشل التسليم', 1, NULL, 1),
(18, 'b', '2021-09-21 13:01:39', '2021-09-21 13:01:39', 1, NULL, 1, NULL, 1),
(19, 'b', '2021-09-21 13:01:41', '2021-09-21 13:02:00', 1, NULL, 0, 'bb', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(10) UNSIGNED NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_en` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_ar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content_ar` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content_en` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `in_footer` tinyint(1) NOT NULL,
  `order` int(10) UNSIGNED NOT NULL DEFAULT 999,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_credentials`
--

CREATE TABLE `payment_credentials` (
  `id` int(10) UNSIGNED NOT NULL,
  `method_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `default` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_installments`
--

CREATE TABLE `payment_installments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_en` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_ar` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `merchant_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_method_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_installments`
--

INSERT INTO `payment_installments` (`id`, `name_en`, `name_ar`, `merchant_id`, `username`, `password`, `payment_method_id`, `created_at`, `updated_at`, `active`) VALUES
(1, '6 Months', '٦ شهور', 'EGPTEST1', 'merchant.EGPTEST1', '61422445f6c0f954e24c7bd8216ceedf', 13, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_ar` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_online` tinyint(1) NOT NULL DEFAULT 0,
  `is_installment` tinyint(1) NOT NULL DEFAULT 0,
  `icon` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `type` int(11) NOT NULL DEFAULT 0,
  `provider` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 1,
  `deactivation_notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_methods`
--

INSERT INTO `payment_methods` (`id`, `name`, `name_ar`, `is_online`, `is_installment`, `icon`, `active`, `type`, `provider`, `order`, `deactivation_notes`, `created_at`, `updated_at`) VALUES
(1, 'Cash On Delivery', 'الدفع عند الاستلام', 0, 0, 'images/payment_methods/cash_payment.png', 1, 0, NULL, 0, NULL, '2021-01-26 17:10:35', '2021-01-26 17:10:35'),
(2, 'Credit / Debit card', ' بطاقة الائتمان \\ الخصم المباشر', 1, 0, 'images/payment_methods/credit_payment.png', 0, 0, NULL, 1, NULL, '2021-01-26 17:10:35', '2021-01-26 17:10:35'),
(3, 'ValU', 'فاليو', 1, 0, 'images/payment_methods/valU_payment.png', 0, 0, NULL, 3, NULL, '2021-01-26 17:10:35', '2021-01-26 17:10:35'),
(4, 'Fawry', 'فوري', 1, 0, 'images/payment_methods/fawry.png', 0, 0, NULL, 4, NULL, '2021-01-26 17:10:35', '2021-01-26 17:10:35'),
(5, 'Premium', 'بريميوم', 1, 0, 'images/payment_methods/premium.png', 0, 0, NULL, 5, NULL, '2021-01-26 17:10:35', '2021-01-26 17:10:35'),
(6, 'Credit card installment', 'تقسيط بطاقة الائتمان', 1, 0, 'images/payment_methods/credit_instalment_payment.png', 0, 0, NULL, 2, NULL, '2021-01-26 17:10:35', '2021-01-26 17:10:35'),
(7, 'NBE (Ahly)', 'NBE (البنك الاهلي)', 1, 0, 'images/payment_methods/nbe_payment.png', 0, 0, NULL, 2, NULL, '2021-01-26 17:10:35', '2021-01-26 17:10:35'),
(8, 'meza', 'meza', 1, 0, 'images/payment_methods/meza_payment.png', 0, 0, NULL, 2, NULL, '2021-01-26 17:10:35', '2021-01-26 17:10:35'),
(9, 'Souhoola', 'سهولة', 1, 0, 'images/payment_methods/souhoola_payment.png', 0, 0, NULL, 2, NULL, '2021-01-26 17:10:35', '2021-01-26 17:10:35'),
(10, 'Contact', 'كونتكت', 1, 0, 'images/payment_methods/get_go_payment.png', 0, 0, NULL, 2, NULL, '2021-01-26 17:10:35', '2021-01-26 17:10:35'),
(11, 'Shahry', 'شهري', 1, 0, 'images/payment_methods/shahry_payment.png', 0, 0, NULL, 2, NULL, '2021-01-26 17:10:35', '2021-01-26 17:10:35'),
(12, 'vodafone cash', 'vodafone cash', 1, 0, 'images/payment_methods/shahry_payment.png', 0, 1, NULL, 0, NULL, '2021-01-26 17:10:35', '2021-01-26 17:10:35'),
(13, 'NBE (Ahly) installment', 'NBE ( تقسيط البنك الاهلي )', 1, 0, 'images/payment_methods/nbe_payment.png', 0, 2, NULL, 2, NULL, '2021-01-26 17:10:35', '2021-01-26 17:10:35'),
(16, 'QNB Simplify', 'QNB Simplify', 1, 0, 'images/payment_methods/credit_payment.png', 0, 0, NULL, 1, NULL, NULL, NULL),
(17, 'Visa Paytabs', 'Visa Paytabs', 1, 0, 'https://www.pngitem.com/pimgs/m/5-56308_paytabs-logo-hd-png-download.png', 0, 0, 'paytabs', 1, NULL, '2021-09-22 10:53:26', '2021-09-22 10:53:26');

-- --------------------------------------------------------

--
-- Table structure for table `payment_method_product`
--

CREATE TABLE `payment_method_product` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `payment_method_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'View Categories', 'web', NULL, NULL),
(2, 'View Products', 'web', NULL, NULL),
(3, 'View Brands', 'web', NULL, NULL),
(4, 'View Options', 'web', NULL, NULL),
(5, 'View Orders', 'web', NULL, NULL),
(6, 'View Order States', 'web', NULL, NULL),
(7, 'View Customers', 'web', NULL, NULL),
(8, 'View Staff', 'web', NULL, NULL),
(9, 'View Cities', 'web', NULL, NULL),
(10, 'View Promos', 'web', NULL, NULL),
(11, 'View Ads', 'web', NULL, NULL),
(12, 'View Notifications', 'web', NULL, NULL),
(13, 'View Rewards', 'web', NULL, NULL),
(14, 'View Gift Requests', 'web', NULL, NULL),
(15, 'View Medical', 'web', NULL, NULL),
(16, 'View Admins', 'web', NULL, NULL),
(17, 'View Settings', 'web', NULL, NULL),
(18, 'View Ads', 'web', NULL, NULL),
(19, 'View Slider', 'web', NULL, NULL),
(20, 'View Sections', 'web', NULL, NULL),
(21, 'View Lists', 'web', NULL, NULL),
(22, 'View Contacts', 'web', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pickups`
--

CREATE TABLE `pickups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shipping_method` int(11) NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pickup_time` datetime NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `shipping_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_guid` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `prescriptions`
--

CREATE TABLE `prescriptions` (
  `id` int(10) UNSIGNED NOT NULL,
  `address_id` int(10) UNSIGNED DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `invoice_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cancellation_text` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `cancellation_id` int(10) UNSIGNED DEFAULT NULL,
  `admin_id` int(10) UNSIGNED DEFAULT NULL,
  `assigned_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `prescription_cancellation_reasons`
--

CREATE TABLE `prescription_cancellation_reasons` (
  `id` int(10) UNSIGNED NOT NULL,
  `text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `text_ar` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_type` enum('customer','admin') COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `prescription_cancellation_reasons`
--

INSERT INTO `prescription_cancellation_reasons` (`id`, `text`, `text_ar`, `user_type`) VALUES
(1, 'Ordered by mistake ', 'تم الطلب بالخطأ', 'customer'),
(2, 'Item is out of stock | المنتج غير متوفر', 'other', 'admin'),
(3, 'As per customer request | بناء علي طلب العميل ', 'other', 'admin'),
(4, 'Customer is not reachable | العميل غير متاح', 'other', 'admin'),
(5, 'Find a better offer elsewhere', ' وجدت عرض افضل في مكان اخر', 'customer'),
(6, 'Shipping Delay', 'تأخر الشحن', 'customer'),
(7, 'Changed my opinion ', 'لقد غيرت رأئي', 'customer'),
(8, 'Other', 'أخري', 'customer'),
(9, 'Other | أخري', 'other', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `prescription_images`
--

CREATE TABLE `prescription_images` (
  `id` int(10) UNSIGNED NOT NULL,
  `prescription_id` int(10) UNSIGNED NOT NULL,
  `url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keywords` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(10,2) UNSIGNED DEFAULT NULL,
  `price_ws` decimal(10,2) NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `brand_id` int(10) UNSIGNED DEFAULT NULL,
  `orders_count` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `category_id` int(10) UNSIGNED DEFAULT NULL,
  `optional_sub_category_id` int(11) DEFAULT NULL,
  `sku` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount_price` int(11) DEFAULT NULL,
  `discount_start_date` datetime DEFAULT NULL,
  `discount_end_date` datetime DEFAULT NULL,
  `deactivation_notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `creator_id` int(10) UNSIGNED DEFAULT NULL,
  `name_ar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description_ar` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `max_per_order` decimal(8,2) DEFAULT NULL,
  `min_days` int(11) DEFAULT NULL,
  `stock` decimal(8,2) NOT NULL DEFAULT 0.00,
  `rate` decimal(8,2) DEFAULT 5.00,
  `long_description_ar` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `long_description_en` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stock_alert` int(11) DEFAULT NULL,
  `barcode` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtract_stock` tinyint(1) NOT NULL DEFAULT 1,
  `order` int(11) DEFAULT NULL,
  `default_variant` tinyint(1) DEFAULT NULL,
  `option_default_id` bigint(20) UNSIGNED DEFAULT NULL,
  `parent_id` int(10) UNSIGNED DEFAULT NULL,
  `weight` decimal(8,2) DEFAULT NULL,
  `type` tinyint(4) DEFAULT 1,
  `has_stock` tinyint(4) DEFAULT 1,
  `preorder` tinyint(1) NOT NULL DEFAULT 0,
  `preorder_price` int(11) DEFAULT NULL,
  `preorder_start_date` datetime DEFAULT NULL,
  `preorder_end_date` datetime DEFAULT NULL,
  `video` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `available_soon` tinyint(4) NOT NULL DEFAULT 0,
  `last_editor` int(10) UNSIGNED DEFAULT NULL,
  `bundle_checkout` tinyint(4) NOT NULL DEFAULT 0,
  `meta_title_ar` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description_ar` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `downloadable_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `downloadable_label` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `affiliate_commission` decimal(8,2) DEFAULT NULL,
  `featured` tinyint(1) NOT NULL DEFAULT 0,
  `free_delivery` tinyint(1) NOT NULL DEFAULT 0,
  `tax_percentage` decimal(8,2) DEFAULT NULL,
  `fix_tax` decimal(8,2) DEFAULT NULL,
  `prod_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `meta_title`, `meta_description`, `keywords`, `price`, `price_ws`, `image`, `active`, `brand_id`, `orders_count`, `created_at`, `updated_at`, `category_id`, `optional_sub_category_id`, `sku`, `discount_price`, `discount_start_date`, `discount_end_date`, `deactivation_notes`, `creator_id`, `name_ar`, `description_ar`, `max_per_order`, `min_days`, `stock`, `rate`, `long_description_ar`, `long_description_en`, `stock_alert`, `barcode`, `subtract_stock`, `order`, `default_variant`, `option_default_id`, `parent_id`, `weight`, `type`, `has_stock`, `preorder`, `preorder_price`, `preorder_start_date`, `preorder_end_date`, `video`, `available_soon`, `last_editor`, `bundle_checkout`, `meta_title_ar`, `meta_description_ar`, `deleted_at`, `downloadable_url`, `downloadable_label`, `affiliate_commission`, `featured`, `free_delivery`, `tax_percentage`, `fix_tax`, `prod_id`) VALUES
(1, 'TMRD', 'TMRD', NULL, NULL, NULL, '13300.00', '266.00', '', 1, NULL, 0, '2022-10-31 14:47:11', '2022-10-31 14:47:11', 20, NULL, 'main_TMRD', NULL, NULL, NULL, NULL, 1, 'تايم ريد', 'TMRD', NULL, NULL, '0.00', '5.00', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, NULL, NULL, NULL, NULL, 0, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL),
(2, 'TMRD', 'TMRD', NULL, NULL, NULL, '13300.00', '266.00', '', 1, NULL, 0, '2022-10-31 14:47:11', '2022-11-01 09:06:59', 20, NULL, 'TMRD', NULL, NULL, NULL, NULL, 1, 'تايم ريد', 'TMRD', NULL, NULL, '100.00', '5.00', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, NULL, 1, 1, 0, NULL, NULL, NULL, NULL, 0, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, '0.00', '0.00', 30029),
(3, 'TMBU', 'TMBU', NULL, NULL, NULL, '13300.00', '266.00', '', 1, NULL, 0, '2022-10-31 14:47:11', '2022-10-31 14:47:11', 20, NULL, 'main_TMBU', NULL, NULL, NULL, NULL, 1, 'تايم بلو', 'TMBU', NULL, NULL, '0.00', '5.00', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, NULL, NULL, NULL, NULL, 0, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL),
(4, 'TMBU', 'TMBU', NULL, NULL, NULL, '13300.00', '266.00', '', 1, NULL, 0, '2022-10-31 14:47:11', '2022-11-01 09:06:59', 20, NULL, 'TMBU', NULL, NULL, NULL, NULL, 1, 'تايم بلو', 'TMBU', NULL, NULL, '100.00', '5.00', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 3, NULL, 1, 1, 0, NULL, NULL, NULL, NULL, 0, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, '0.00', '0.00', 30030),
(5, 'TMSL', 'TMSL', NULL, NULL, NULL, '13300.00', '266.00', '', 1, NULL, 0, '2022-10-31 14:47:11', '2022-10-31 14:47:11', 20, NULL, 'main_TMSL', NULL, NULL, NULL, NULL, 1, 'تايم سيلفر', 'TMSL', NULL, NULL, '0.00', '5.00', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, NULL, NULL, NULL, NULL, 0, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL),
(6, 'TMSL', 'TMSL', NULL, NULL, NULL, '13300.00', '266.00', '', 1, NULL, 0, '2022-10-31 14:47:11', '2022-11-01 09:06:59', 20, NULL, 'TMSL', NULL, NULL, NULL, NULL, 1, 'تايم سيلفر', 'TMSL', NULL, NULL, '100.00', '5.00', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 5, NULL, 1, 1, 0, NULL, NULL, NULL, NULL, 0, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, '0.00', '0.00', 30031),
(7, 'GLDVR', 'GLDVR', NULL, NULL, NULL, '1050.00', '21.00', '', 1, NULL, 0, '2022-10-31 14:47:11', '2022-10-31 14:47:11', 22, NULL, 'main_GLDVR', NULL, NULL, NULL, NULL, 1, 'جولدن فيرجينيا', 'GLDVR', NULL, NULL, '0.00', '5.00', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, NULL, NULL, NULL, NULL, 0, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL),
(8, 'GLDVR', 'GLDVR', NULL, NULL, NULL, '1050.00', '21.00', '', 1, NULL, 0, '2022-10-31 14:47:11', '2022-11-01 09:06:59', 22, NULL, 'GLDVR', NULL, NULL, NULL, NULL, 1, 'جولدن فيرجينيا', 'GLDVR', NULL, NULL, '100.00', '5.00', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 7, NULL, 1, 1, 0, NULL, NULL, NULL, NULL, 0, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, '0.00', '0.00', 30040),
(9, 'Davidoff Evolve Red', 'Davidoff Evolve Red', NULL, NULL, NULL, '17360.00', '347.00', '', 1, NULL, 0, '2022-10-31 14:47:11', '2022-10-31 14:47:11', 4, NULL, 'main_Davidoff Evolve Red', NULL, NULL, NULL, NULL, 1, 'دافيدوف احمر', 'Davidoff Evolve Red', NULL, NULL, '0.00', '5.00', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, NULL, NULL, NULL, NULL, 0, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL),
(10, 'Davidoff Evolve Red', 'Davidoff Evolve Red', NULL, NULL, NULL, '17360.00', '347.20', '', 1, NULL, 0, '2022-10-31 14:47:11', '2022-11-01 09:06:59', 4, NULL, 'Davidoff Evolve Red', NULL, NULL, NULL, NULL, 1, 'دافيدوف احمر', 'Davidoff Evolve Red', NULL, NULL, '100.00', '5.00', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 9, NULL, 1, 1, 0, NULL, NULL, NULL, NULL, 0, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, '0.00', '0.00', 30041),
(11, 'Davidoff Evolve Blue', 'Davidoff Evolve Blue', NULL, NULL, NULL, '17360.00', '347.00', '', 1, NULL, 0, '2022-10-31 14:47:11', '2022-10-31 14:47:11', 4, NULL, 'main_Davidoff Evolve Blue', NULL, NULL, NULL, NULL, 1, 'دافيدوف إيفولف أزرق', 'Davidoff Evolve Blue', NULL, NULL, '0.00', '5.00', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, NULL, NULL, NULL, NULL, 0, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL),
(12, 'Davidoff Evolve Blue', 'Davidoff Evolve Blue', NULL, NULL, NULL, '17360.00', '347.20', '', 1, NULL, 0, '2022-10-31 14:47:11', '2022-11-01 09:06:59', 4, NULL, 'Davidoff Evolve Blue', NULL, NULL, NULL, NULL, 1, 'دافيدوف إيفولف أزرق', 'Davidoff Evolve Blue', NULL, NULL, '100.00', '5.00', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 11, NULL, 1, 1, 0, NULL, NULL, NULL, NULL, 0, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, '0.00', '0.00', 30042),
(13, 'Davidoff Evolve Silver', 'Davidoff Evolve Silver', NULL, NULL, NULL, '17360.00', '347.00', '', 1, NULL, 0, '2022-10-31 14:47:11', '2022-10-31 14:47:11', 4, NULL, 'main_Davidoff Evolve Silver', NULL, NULL, NULL, NULL, 1, 'دافيدوف إيفولف سيلفر', 'Davidoff Evolve Silver', NULL, NULL, '0.00', '5.00', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, NULL, NULL, NULL, NULL, 0, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL),
(14, 'Davidoff Evolve Silver', 'Davidoff Evolve Silver', NULL, NULL, NULL, '17360.00', '347.20', '', 1, NULL, 0, '2022-10-31 14:47:11', '2022-11-01 09:06:59', 4, NULL, 'Davidoff Evolve Silver', NULL, NULL, NULL, NULL, 1, 'دافيدوف إيفولف سيلفر', 'Davidoff Evolve Silver', NULL, NULL, '100.00', '5.00', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 13, NULL, 1, 1, 0, NULL, NULL, NULL, NULL, 0, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, '0.00', '0.00', 30043),
(15, 'TREGR', 'TREGR', NULL, NULL, NULL, '10250.00', '205.00', '', 1, NULL, 0, '2022-10-31 14:47:11', '2022-10-31 14:47:11', 12, NULL, 'main_TREGR', NULL, NULL, NULL, NULL, 1, 'تارجت اكسترا احمر', 'TREGR', NULL, NULL, '0.00', '5.00', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, NULL, NULL, NULL, NULL, 0, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL),
(16, 'TREGR', 'TREGR', NULL, NULL, NULL, '10250.00', '205.00', '', 1, NULL, 0, '2022-10-31 14:47:11', '2022-11-01 09:06:59', 12, NULL, 'TREGR', NULL, NULL, NULL, NULL, 1, 'تارجت اكسترا احمر', 'TREGR', NULL, NULL, '100.00', '5.00', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 15, NULL, 1, 1, 0, NULL, NULL, NULL, NULL, 0, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, '0.00', '0.00', 30052),
(17, 'TREGB', 'TREGB', NULL, NULL, NULL, '10250.00', '205.00', '', 1, NULL, 0, '2022-10-31 14:47:11', '2022-10-31 14:47:11', 12, NULL, 'main_TREGB', NULL, NULL, NULL, NULL, 1, 'تارجت اكسترا ازرق', 'TREGB', NULL, NULL, '0.00', '5.00', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, NULL, NULL, NULL, NULL, 0, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL),
(18, 'TREGB', 'TREGB', NULL, NULL, NULL, '10250.00', '205.00', '', 1, NULL, 0, '2022-10-31 14:47:11', '2022-11-01 09:06:59', 12, NULL, 'TREGB', NULL, NULL, NULL, NULL, 1, 'تارجت اكسترا ازرق', 'TREGB', NULL, NULL, '100.00', '5.00', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 17, NULL, 1, 1, 0, NULL, NULL, NULL, NULL, 0, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, '0.00', '0.00', 30053),
(19, 'LI J5 I Prints Mini', 'LI J5 I Prints Mini', NULL, NULL, NULL, '351.00', '7.00', '', 1, NULL, 0, '2022-10-31 14:47:11', '2022-10-31 14:47:11', 14, NULL, 'main_LI J5 I Prints Mini', NULL, NULL, NULL, NULL, 1, 'ج عبوة بيك جى5 أشكال صغيره', 'LI J5 I Prints Mini', NULL, NULL, '0.00', '5.00', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, NULL, NULL, NULL, NULL, 0, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL),
(20, 'LI J5 I Prints Mini', 'LI J5 I Prints Mini', NULL, NULL, NULL, '350.88', '7.02', '', 1, NULL, 0, '2022-10-31 14:47:11', '2022-11-01 09:06:59', 14, NULL, 'LI J5 I Prints Mini', NULL, NULL, NULL, NULL, 1, 'ج عبوة بيك جى5 أشكال صغيره', 'LI J5 I Prints Mini', NULL, NULL, '100.00', '5.00', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 19, NULL, 1, 1, 0, NULL, NULL, NULL, NULL, 0, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, '14.00', '0.00', 33119),
(21, 'LI J5 I Plain Mini', 'LI J5 I Plain Mini', NULL, NULL, NULL, '281.00', '6.00', '', 1, NULL, 0, '2022-10-31 14:47:11', '2022-10-31 14:47:11', 14, NULL, 'main_LI J5 I Plain Mini', NULL, NULL, NULL, NULL, 1, ' ج عبوة بيك جى5 سادة صغير', 'LI J5 I Plain Mini', NULL, NULL, '0.00', '5.00', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, NULL, NULL, NULL, NULL, 0, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL),
(22, 'LI J5 I Plain Mini', 'LI J5 I Plain Mini', NULL, NULL, NULL, '280.70', '5.61', '', 1, NULL, 0, '2022-10-31 14:47:11', '2022-11-01 09:06:59', 14, NULL, 'LI J5 I Plain Mini', NULL, NULL, NULL, NULL, 1, ' ج عبوة بيك جى5 سادة صغير', 'LI J5 I Plain Mini', NULL, NULL, '100.00', '5.00', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 21, NULL, 1, 1, 0, NULL, NULL, NULL, NULL, 0, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, '14.00', '0.00', 33120),
(23, 'DVDPLC', 'DVDPLC', NULL, NULL, NULL, '23785.00', '476.00', '', 1, NULL, 0, '2022-10-31 14:47:11', '2022-10-31 14:47:11', 8, NULL, 'main_DVDPLC', NULL, NULL, NULL, NULL, 1, 'دافيدوف كلاسيك', 'DVDPLC', NULL, NULL, '0.00', '5.00', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, NULL, NULL, NULL, NULL, 0, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL),
(24, 'DVDPLC', 'DVDPLC', NULL, NULL, NULL, '2378500.00', '475.70', '', 1, NULL, 0, '2022-10-31 14:47:11', '2022-11-01 09:06:59', 8, NULL, 'DVDPLC', NULL, NULL, NULL, NULL, 1, 'دافيدوف كلاسيك', 'DVDPLC', NULL, NULL, '100.00', '5.00', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 23, NULL, 1, 1, 0, NULL, NULL, NULL, NULL, 0, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, '0.00', '0.00', 30000),
(25, 'DVDPLG', 'DVDPLG', NULL, NULL, NULL, '23785.00', '476.00', '', 1, NULL, 0, '2022-10-31 14:47:11', '2022-10-31 14:47:11', 8, NULL, 'main_DVDPLG', NULL, NULL, NULL, NULL, 1, 'دافيدوف جولد', 'DVDPLG', NULL, NULL, '0.00', '5.00', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, NULL, NULL, NULL, NULL, 0, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL),
(26, 'DVDPLG', 'DVDPLG', NULL, NULL, NULL, '23785.00', '475.70', '', 1, NULL, 0, '2022-10-31 14:47:11', '2022-11-01 09:06:59', 8, NULL, 'DVDPLG', NULL, NULL, NULL, NULL, 1, 'دافيدوف جولد', 'DVDPLG', NULL, NULL, '100.00', '5.00', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 25, NULL, 1, 1, 0, NULL, NULL, NULL, NULL, 0, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, '0.00', '0.00', 30001),
(27, 'DVDSLG', 'DVDSLG', NULL, NULL, NULL, '14271.00', '476.00', '', 1, NULL, 0, '2022-10-31 14:47:11', '2022-10-31 14:47:11', 8, NULL, 'main_DVDSLG', NULL, NULL, NULL, NULL, 1, 'دافيدوف سليمز جولد', 'DVDSLG', NULL, NULL, '0.00', '5.00', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, NULL, NULL, NULL, NULL, 0, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL),
(28, 'DVDSLG', 'DVDSLG', NULL, NULL, NULL, '14271.00', '475.70', '', 1, NULL, 0, '2022-10-31 14:47:11', '2022-11-01 09:06:59', 8, NULL, 'DVDSLG', NULL, NULL, NULL, NULL, 1, 'دافيدوف سليمز جولد', 'DVDSLG', NULL, NULL, '100.00', '5.00', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 27, NULL, 1, 1, 0, NULL, NULL, NULL, NULL, 0, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, '0.00', '0.00', 30003),
(29, 'DVDPLW', 'DVDPLW', NULL, NULL, NULL, '23785.00', '476.00', '', 1, NULL, 0, '2022-10-31 14:47:11', '2022-10-31 14:47:11', 8, NULL, 'main_DVDPLW', NULL, NULL, NULL, NULL, 1, 'دافيدوف وايت', 'DVDPLW', NULL, NULL, '0.00', '5.00', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, NULL, NULL, NULL, NULL, 0, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL),
(30, 'DVDPLW', 'DVDPLW', NULL, NULL, NULL, '23785.00', '475.70', '', 1, NULL, 0, '2022-10-31 14:47:11', '2022-11-01 09:06:59', 8, NULL, 'DVDPLW', NULL, NULL, NULL, NULL, 1, 'دافيدوف وايت', 'DVDPLW', NULL, NULL, '100.00', '5.00', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 29, NULL, 1, 1, 0, NULL, NULL, NULL, NULL, 0, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, '0.00', '0.00', 30002);

-- --------------------------------------------------------

--
-- Table structure for table `product_bundles`
--

CREATE TABLE `product_bundles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bundle_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_option_values`
--

CREATE TABLE `product_option_values` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `option_id` int(10) UNSIGNED NOT NULL,
  `image` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `input_en` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `input_ar` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `value_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_prices`
--

CREATE TABLE `product_prices` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED DEFAULT NULL,
  `price` int(11) NOT NULL,
  `discount_price` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_prices`
--

INSERT INTO `product_prices` (`id`, `product_id`, `price`, `discount_price`, `created_at`, `updated_at`) VALUES
(498692, 90391, 4300, 0, '2021-11-21 11:54:40', '2021-11-21 11:54:40'),
(498694, 90393, 4300, 0, '2021-11-21 11:54:40', '2021-11-21 11:54:40'),
(498696, 90395, 4200, 0, '2021-11-21 11:54:40', '2021-11-21 11:54:40'),
(498698, 90391, 4300, 0, '2021-11-21 11:59:11', '2021-11-21 11:59:11'),
(498700, 90393, 4300, 0, '2021-11-21 11:59:11', '2021-11-21 11:59:11'),
(498702, 90395, 4200, 0, '2021-11-21 11:59:11', '2021-11-21 11:59:11'),
(498704, 90397, 2000, 0, '2021-11-21 11:59:12', '2021-11-21 11:59:12'),
(498706, 90399, 2000, 0, '2021-11-21 11:59:12', '2021-11-21 11:59:12'),
(498722, 90885, 34649, 0, '2022-03-02 16:27:04', '2022-03-02 16:27:04'),
(498723, 40, 16700, 0, '2022-03-03 15:16:53', '2022-03-03 15:16:53'),
(498724, 42, 19300, 0, '2022-03-03 15:16:53', '2022-03-03 15:16:53'),
(498725, 10, 38525, 0, '2022-03-03 15:27:33', '2022-03-03 15:27:33'),
(498726, 90, 31750, 0, '2022-03-03 15:27:33', '2022-03-03 15:27:33'),
(498727, 172, 45600, 0, '2022-03-10 11:33:43', '2022-03-10 11:33:43'),
(498728, 174, 45600, 0, '2022-03-10 11:33:43', '2022-03-10 11:33:43'),
(498729, 176, 45600, 0, '2022-03-10 12:17:01', '2022-03-10 12:17:01'),
(498730, 178, 45600, 0, '2022-03-10 12:17:02', '2022-03-10 12:17:02'),
(498731, 100, 16700, 0, '2022-03-16 12:37:20', '2022-03-16 12:37:20'),
(498732, 102, 19300, 0, '2022-03-16 12:37:20', '2022-03-16 12:37:20'),
(498733, 104, 19300, 0, '2022-03-16 12:37:20', '2022-03-16 12:37:20'),
(498734, 120, 16700, 0, '2022-03-16 12:37:21', '2022-03-16 12:37:21'),
(498735, 175, 45600, 0, '2022-03-21 15:33:52', '2022-03-21 15:33:52'),
(498736, 175, 45600, 0, '2022-03-21 15:34:24', '2022-03-21 15:34:24'),
(498737, 175, 45600, 0, '2022-03-21 15:35:04', '2022-03-21 15:35:04'),
(498738, 175, 45600, 0, '2022-03-22 11:35:12', '2022-03-22 11:35:12'),
(498739, 12, 0, 0, '2022-03-24 13:58:24', '2022-03-24 13:58:24'),
(498740, 14, 38525, 0, '2022-03-27 14:05:16', '2022-03-27 14:05:16'),
(498741, 4, 25300, 0, '2022-03-27 14:12:44', '2022-03-27 14:12:44'),
(498742, 2, 38525, 0, '2022-03-28 14:59:04', '2022-03-28 14:59:04'),
(498743, 150, 31750, 0, '2022-03-28 15:04:28', '2022-03-28 15:04:28'),
(498744, 24, 43000, 0, '2022-03-29 14:18:08', '2022-03-29 14:18:08'),
(498745, 26, 43000, 0, '2022-03-29 14:32:58', '2022-03-29 14:32:58'),
(498746, 167, 45600, 0, '2022-04-10 11:50:35', '2022-04-10 11:50:35'),
(498747, 6, 16700, 0, '2022-04-10 13:00:13', '2022-04-10 13:00:13'),
(498748, 8, 20000, 0, '2022-04-10 13:00:13', '2022-04-10 13:00:13'),
(498749, 22, 26500, 0, '2022-04-13 11:44:59', '2022-04-13 11:44:59'),
(498750, 30, 36000, 0, '2022-04-14 12:36:40', '2022-04-14 12:36:40'),
(498751, 28, 27500, 0, '2022-04-17 10:27:54', '2022-04-17 10:27:54'),
(498752, 166, 45600, 0, '2022-05-24 13:47:17', '2022-05-24 13:47:17'),
(498753, 168, 45600, 0, '2022-05-24 13:47:17', '2022-05-24 13:47:17'),
(498754, 184, 95000, 0, '2022-06-03 16:57:39', '2022-06-03 16:57:39'),
(498755, 48, 24123, 0, '2022-06-05 16:07:02', '2022-06-05 16:07:02'),
(498756, 78, 27632, 0, '2022-06-05 16:07:02', '2022-06-05 16:07:02'),
(498757, 162, 1586000, 0, '2022-06-12 14:00:50', '2022-06-12 14:00:50'),
(498758, 170, 1586000, 0, '2022-06-19 11:20:46', '2022-06-19 11:20:46'),
(498759, 188, 1330000, 0, '2022-06-20 13:21:31', '2022-06-20 13:21:31'),
(498760, 32, 30263, 0, '2022-06-20 13:58:11', '2022-06-20 13:58:11'),
(498761, 190, 1330000, 0, '2022-06-22 11:24:48', '2022-06-22 11:24:48'),
(498762, 192, 94000, 0, '2022-06-27 11:43:22', '2022-06-27 11:43:22'),
(498763, 186, 1686000, 0, '2022-07-20 15:58:49', '2022-07-20 15:58:49'),
(498764, 187, 1330000, 0, '2022-08-07 12:23:43', '2022-08-07 12:23:43'),
(498765, 187, 1330000, 0, '2022-08-07 12:24:49', '2022-08-07 12:24:49'),
(498766, 7, 20000, 0, '2022-08-09 11:26:08', '2022-08-09 11:26:08'),
(498767, 9, 20000, 0, '2022-08-10 08:29:03', '2022-08-10 08:29:03'),
(498768, 7, 20000, 0, '2022-08-11 13:01:22', '2022-08-11 13:01:22'),
(498769, 165, 45600, 0, '2022-08-18 09:27:45', '2022-08-18 09:27:45');

-- --------------------------------------------------------

--
-- Table structure for table `product_reviews`
--

CREATE TABLE `product_reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `rate` int(11) NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `product_id` int(10) UNSIGNED DEFAULT NULL,
  `rejection_reason` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `type` tinyint(4) DEFAULT NULL,
  `order_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_skus`
--

CREATE TABLE `product_skus` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `sku` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_tags`
--

CREATE TABLE `product_tags` (
  `id` int(10) UNSIGNED NOT NULL,
  `tag_id` int(10) UNSIGNED DEFAULT NULL,
  `product_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE `profiles` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `provider_id` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `promos`
--

CREATE TABLE `promos` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `amount` decimal(8,2) DEFAULT NULL,
  `max_amount` int(11) DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expiration_date` date NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deactivation_notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `recurrence` int(11) NOT NULL DEFAULT 1,
  `first_order` tinyint(1) NOT NULL DEFAULT 0,
  `minimum_amount` decimal(8,2) DEFAULT NULL,
  `list_id` int(10) UNSIGNED DEFAULT NULL,
  `target_type` tinyint(1) DEFAULT NULL,
  `incentive_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `promos`
--

INSERT INTO `promos` (`id`, `name`, `type`, `amount`, `max_amount`, `description`, `expiration_date`, `active`, `created_at`, `updated_at`, `deactivation_notes`, `recurrence`, `first_order`, `minimum_amount`, `list_id`, `target_type`, `incentive_id`) VALUES
(112, 'CB2000', 1, '2000.00', 0, 'للحصول علي خصم بقيمة 2000 جنيه للكاش فقط \"CB2000\" استخدم كوبون', '2021-06-30', 1, '2021-03-03 16:39:46', '2021-06-10 12:55:38', NULL, 2, 0, NULL, 41, 0, NULL),
(113, 'MIFAN50', 1, '50.00', 0, 'للحصول علي خصم 50 جنيه \"MIFAN50\" استخدم كوبون', '2021-04-12', 0, '2021-04-05 16:46:33', '2021-04-26 13:34:39', '.', 2, 0, NULL, 35, 0, NULL),
(114, 'MFFLIVE100', 1, '100.00', NULL, 'للحصول علي خصم 100 جنيه \"MFFLIVE100\" استخدم كوبون', '2021-04-07', 0, '2021-04-07 10:36:29', '2021-04-08 11:54:11', '.', 1, 0, NULL, 36, 0, NULL),
(115, 'mhy8p', 1, '700.00', 0, 'للحصول علي خصم فوري 700 جنية لانظمة الكاش فقط mhy8p استخدم الكود', '2021-06-30', 0, '2021-04-26 12:44:01', '2021-06-20 12:59:18', '.', 2, 0, NULL, 56, 0, NULL),
(116, 'MH9XP', 2, '13.50', 0, 'للحصول علي خصم فوري 574جنية لانظمة الكاش فقط MH9XP استخدم الكود', '2021-05-31', 0, '2021-04-26 12:48:08', '2021-06-03 11:31:23', '.', 2, 0, NULL, 39, 0, NULL),
(117, 'MH10XL', 2, '7.00', 0, 'للحصول علي خصم فوري 234 جنية لانظمة الكاش فقط MH10XL استخدم الكود', '2021-05-31', 0, '2021-04-26 12:53:47', '2021-06-03 11:31:25', '.', 2, 0, NULL, 38, 0, NULL),
(118, 'MOR4P', 2, '3.80', 0, 'للحصول علي خصم فوري338 جنية لانظمة الكاش فقط MOR4P استخدم الكود', '2021-05-31', 0, '2021-04-26 12:58:19', '2021-06-03 11:31:27', '.', 2, 0, NULL, 52, 0, NULL),
(119, 'MVIV12', 2, '4.00', 0, 'للحصول علي خصم فوري 100 جنية لانظمة الكاش فقط MVIV12 استخدم الكود', '2021-05-31', 0, '2021-04-26 13:01:55', '2021-06-03 11:31:29', '.', 2, 0, NULL, 53, 0, NULL),
(120, 'MSM51', 1, '701.00', 0, 'للحصول علي خصم بقيمة 701 جنيه للكاش فقط \"MSM51\" استخدم كوبون', '2021-06-30', 1, '2021-04-26 13:05:53', '2021-06-10 11:47:13', NULL, 2, 0, NULL, 54, 0, NULL),
(121, 'CB1000', 1, '1000.00', 0, 'للحصول علي خصم بقيمة 1000 جنيه للكاش فقط \"CB1000\" استخدم كوبون', '2021-06-30', 1, '2021-05-11 19:47:22', '2021-06-10 12:50:58', NULL, 2, 0, NULL, 40, 0, NULL),
(122, 'MA1AJ', 1, '2151.00', 0, 'للحصول علي خصم اضافي بقيمة 2151 جنيه للكاش فقط \"MA1AJ\" استخدم كوبون', '2021-07-31', 1, '2021-06-03 11:35:55', '2021-07-11 17:58:18', NULL, 2, 0, NULL, 35, 0, NULL),
(123, 'MSO12', 2, '12.00', 0, '%للحصول علي خصم 12 MSO12 استخدم الكود', '2021-06-30', 1, '2021-06-03 14:38:12', '2021-06-03 14:38:12', NULL, 2, 0, NULL, 55, 0, NULL),
(124, 'test360', 2, '10.00', 0, '555614659+2918', '2021-06-30', 0, '2021-06-03 17:07:32', '2021-06-16 17:54:25', 'mmmm', 2, 0, NULL, 56, 0, NULL),
(125, 'mobxeleish', 2, '2.00', 0, '%للحصول علي خصم 2 mobxeleish استخدم الكود', '2021-06-30', 1, '2021-06-16 16:48:16', '2021-07-28 15:29:08', NULL, 2, 0, NULL, 57, 0, NULL),
(126, 'accxeleish', 2, '5.00', 0, '%للحصول علي خصم 5 \"accxeleish\" استخدم الكود', '2021-06-30', 1, '2021-06-16 16:52:09', '2021-07-21 23:46:00', NULL, 2, 0, NULL, 58, 0, NULL),
(127, 'MSTA10', 1, '199.00', 0, 'للحصول علي خصم بقيمة 199 جنيه للكاش فقط \"MSTA10\" استخدم كوبون', '2021-07-31', 1, '2021-06-17 11:41:06', '2021-07-05 11:49:34', NULL, 2, 0, NULL, NULL, 0, NULL),
(128, 'MHY8P', 1, '70.00', 0, 'للحصول علي خصم بقيمة 700 جنيه للكاش فقط \"MHY8P\" استخدم كوبون', '2021-07-31', 1, '2021-06-20 11:24:19', '2021-07-12 14:04:24', NULL, 2, 0, NULL, 56, 0, NULL),
(129, 'mina25', 2, '20.00', 0, 'this is promo', '2021-07-31', 1, '2021-07-12 14:16:16', '2021-07-12 14:16:16', NULL, 2, 0, NULL, NULL, 0, NULL),
(130, 'test', 1, '2000.00', 0, 'خصم 2000 ج', '2021-07-31', 1, '2021-07-13 14:00:03', '2021-07-21 14:32:51', NULL, 2, 0, NULL, NULL, 1, NULL),
(131, 'tste', 2, '40.00', 0, 'trygrtvr5grt', '2021-08-03', 1, '2021-08-02 22:39:44', '2021-08-03 10:06:52', NULL, 2, 0, NULL, 30, 0, NULL),
(132, 'promo-test66', 2, '10.00', 10000, '10% off', '2021-08-31', 1, '2021-08-18 16:23:44', '2021-08-18 16:23:44', NULL, 2, 0, '100.00', 30, 0, NULL),
(133, 'GIFT-D3SEY', 1, '50.00', 0, NULL, '2021-09-29', 1, '2021-08-29 11:40:28', '2021-08-29 11:40:28', NULL, 1, 0, NULL, NULL, NULL, NULL),
(134, 'GIFT-CU822', 1, '50.00', 0, NULL, '2021-09-29', 1, '2021-08-29 11:48:24', '2021-08-29 11:48:24', NULL, 1, 0, NULL, NULL, NULL, NULL),
(135, 'GIFT-BG3T0', 1, '60.00', 0, NULL, '2021-09-29', 1, '2021-08-29 11:50:28', '2021-08-29 11:50:28', NULL, 1, 0, NULL, NULL, NULL, NULL),
(136, 'GIFT-UDP1W', 1, '80.00', 0, NULL, '2021-09-29', 1, '2021-08-29 11:52:10', '2021-08-29 11:52:10', NULL, 1, 0, NULL, NULL, NULL, NULL),
(137, 'GIFT-WQUZU', 1, '50.00', 0, NULL, '2021-09-29', 1, '2021-08-29 11:57:46', '2021-08-29 11:57:46', NULL, 1, 0, NULL, NULL, NULL, NULL),
(138, 'GIFT-BQIHZ', 1, '50.00', 0, NULL, '2021-09-29', 1, '2021-08-29 12:00:50', '2021-08-29 12:00:50', NULL, 1, 0, NULL, NULL, NULL, NULL),
(139, 'GIFT-CUTU6', 1, '50.00', 0, NULL, '2021-09-29', 1, '2021-08-29 12:03:35', '2021-08-29 12:03:35', NULL, 1, 0, NULL, NULL, NULL, NULL),
(140, 'GIFT-Q3JEB', 1, '80.00', 0, NULL, '2021-09-29', 1, '2021-08-29 12:24:08', '2021-08-29 12:24:08', NULL, 1, 0, NULL, NULL, NULL, NULL),
(141, 'GIFT-DIVBB', 1, '60.00', 0, NULL, '2021-09-29', 1, '2021-08-29 13:49:02', '2021-08-29 13:49:02', NULL, 1, 0, NULL, NULL, NULL, NULL),
(142, 'GIFT-NOULD', 1, '50.00', 0, NULL, '2021-09-29', 1, '2021-08-29 13:51:30', '2021-08-29 13:51:30', NULL, 1, 0, NULL, NULL, NULL, NULL),
(143, 'GIFT-MTOFO', 1, '50.00', 0, NULL, '2021-09-29', 1, '2021-08-29 13:57:33', '2021-08-29 13:57:33', NULL, 1, 0, NULL, NULL, NULL, NULL),
(144, 'GIFT-WAVTB', 1, '50.00', 0, NULL, '2021-09-29', 1, '2021-08-29 15:59:06', '2021-08-29 15:59:06', NULL, 1, 0, NULL, NULL, NULL, NULL),
(145, 'GIFT-ZP4WN', 1, '50.00', 0, NULL, '2021-09-29', 1, '2021-08-29 17:37:11', '2021-08-29 17:37:11', NULL, 1, 0, NULL, NULL, NULL, NULL),
(146, 'GIFT-ZJAYE', 1, '50.00', 0, NULL, '2021-09-30', 1, '2021-08-30 15:13:40', '2021-08-30 15:13:40', NULL, 1, 0, NULL, NULL, NULL, NULL),
(147, 'GIFT-WSA5K', 1, '50.00', 0, NULL, '2021-10-01', 1, '2021-08-31 12:03:38', '2021-08-31 12:03:38', NULL, 1, 0, NULL, NULL, NULL, NULL),
(148, 'GIFT-UR8NT', 1, '50.00', 0, NULL, '2021-10-01', 1, '2021-09-01 16:08:40', '2021-09-01 16:08:40', NULL, 1, 0, NULL, NULL, NULL, NULL),
(149, 'GIFT-7K95Z', 1, '50.00', 0, NULL, '2021-10-01', 1, '2021-09-01 16:08:57', '2021-09-01 16:08:57', NULL, 1, 0, NULL, NULL, NULL, NULL),
(150, 'GIFT-VKP8T', 1, '50.00', 0, NULL, '2021-10-01', 1, '2021-09-01 16:09:10', '2021-09-01 16:09:10', NULL, 1, 0, NULL, NULL, NULL, NULL),
(151, 'GIFT-PL0TO', 1, '50.00', 0, NULL, '2021-10-01', 1, '2021-09-01 16:10:45', '2021-09-01 16:10:45', NULL, 1, 0, NULL, NULL, NULL, NULL),
(152, 'guestPromo', 1, '100.00', 0, 'guestPromo', '2021-09-30', 1, '2021-09-06 13:26:16', '2021-09-08 10:57:09', NULL, 1, 0, '100.00', NULL, 0, NULL),
(153, 'GIFT-R6GIS', 1, '500.00', 0, NULL, '2021-10-08', 1, '2021-09-08 13:19:26', '2021-09-08 13:19:26', NULL, 1, 0, NULL, NULL, NULL, NULL),
(154, 'GIFT-P2K6K', 2, '25.00', 50000, NULL, '2021-10-20', 1, '2021-09-20 10:56:50', '2021-09-20 10:56:50', NULL, 1, 0, NULL, NULL, NULL, NULL),
(155, 'GIFT-QWZKV', 2, '25.00', 50000, NULL, '2021-10-20', 1, '2021-09-20 10:57:20', '2021-09-20 10:57:20', NULL, 1, 0, NULL, NULL, NULL, NULL),
(156, 'GIFT-RC0T9', 2, '25.00', 50000, NULL, '2021-10-20', 1, '2021-09-20 11:11:14', '2021-09-20 11:11:14', NULL, 1, 0, NULL, NULL, NULL, NULL),
(157, 'GIFT-6H4ED', 2, '25.00', 50000, NULL, '2021-10-20', 1, '2021-09-20 11:24:49', '2021-09-20 11:24:49', NULL, 1, 0, NULL, NULL, NULL, NULL),
(158, 'GIFT-7LENY', 2, '25.00', 50000, NULL, '2021-10-20', 1, '2021-09-20 11:29:02', '2021-09-20 11:29:02', NULL, 1, 0, NULL, NULL, NULL, NULL),
(159, 'GIFT-K2ZH2', 2, '25.00', 50000, NULL, '2021-10-20', 1, '2021-09-20 11:29:11', '2021-09-20 11:29:11', NULL, 1, 0, NULL, NULL, NULL, NULL),
(160, 'GIFT-TECAT', 2, '25.00', 50000, NULL, '2021-10-20', 1, '2021-09-20 11:43:46', '2021-09-20 11:43:46', NULL, 1, 0, NULL, NULL, NULL, NULL),
(161, 'GIFT-C4QZH', 2, '25.00', 50000, NULL, '2021-10-20', 1, '2021-09-20 11:47:50', '2021-09-20 11:47:50', NULL, 1, 0, NULL, NULL, NULL, NULL),
(162, 'GIFT-GUQMF', 1, '500.00', 0, NULL, '2021-10-20', 1, '2021-09-20 13:12:22', '2021-09-20 13:12:22', NULL, 1, 0, NULL, NULL, NULL, NULL),
(163, 'GIFT-N23ZB', 2, '90.00', 1000000, NULL, '2021-10-20', 1, '2021-09-20 14:04:28', '2021-09-20 14:04:28', NULL, 1, 0, NULL, NULL, NULL, NULL),
(164, 'GIFT-XDMC5', 2, '50.00', 200000, NULL, '2021-10-20', 1, '2021-09-20 15:51:18', '2021-09-20 15:51:18', NULL, 1, 0, NULL, NULL, NULL, NULL),
(165, 'GIFT-PR6MR', 2, '50.00', 200000, NULL, '2021-10-20', 1, '2021-09-20 16:11:33', '2021-09-20 16:11:33', NULL, 1, 0, NULL, NULL, NULL, NULL),
(166, 'GIFT-EUJOC', 2, '50.00', 200000, NULL, '2021-10-20', 1, '2021-09-20 16:24:52', '2021-09-20 16:24:52', NULL, 1, 0, NULL, NULL, NULL, NULL),
(167, 'GIFT-I5GKT', 2, '50.00', 200000, NULL, '2021-10-20', 1, '2021-09-20 16:29:54', '2021-09-20 16:29:54', NULL, 1, 0, NULL, NULL, NULL, NULL),
(168, 'GIFT-OS9IW', 2, '50.00', 200000, NULL, '2021-10-20', 1, '2021-09-20 16:36:39', '2021-09-20 16:36:39', NULL, 1, 0, NULL, NULL, NULL, NULL),
(169, 'GIFT-CCYSM', 2, '50.00', 200000, NULL, '2021-10-20', 1, '2021-09-20 16:48:30', '2021-09-20 16:48:30', NULL, 1, 0, NULL, NULL, NULL, NULL),
(170, 'test5', 1, '5.00', NULL, 'askjasijfasjfasg', '2021-11-30', 1, '2021-11-21 12:13:47', '2021-11-21 12:13:47', NULL, 2, 0, NULL, NULL, 0, NULL),
(171, 'GIFT-B7S2W', 1, '10.00', 0, NULL, '2021-12-21', 1, '2021-11-21 14:19:22', '2021-11-21 14:19:22', NULL, 1, 0, NULL, NULL, 1, NULL),
(172, 'GIFT-WIQDY', 1, '10.00', 0, NULL, '2021-12-21', 1, '2021-11-21 14:26:35', '2021-11-21 14:26:35', NULL, 1, 0, NULL, NULL, 1, NULL),
(173, 'GIFT-N3X3G', 1, '10.00', 0, NULL, '2021-12-25', 1, '2021-11-25 13:56:05', '2021-11-25 13:56:05', NULL, 1, 0, NULL, NULL, 1, NULL),
(174, 'GIFT-NOWPD', 1, '10.00', 0, NULL, '2021-12-25', 1, '2021-11-25 13:56:27', '2021-11-25 13:56:27', NULL, 1, 0, NULL, NULL, 1, NULL),
(175, 'GIFT-HFXLV', 1, '50.00', 0, NULL, '2022-01-16', 1, '2021-12-16 11:19:00', '2021-12-16 11:19:00', NULL, 1, 0, NULL, NULL, 1, NULL),
(176, 'dec16', 1, '50.00', 0, 'msadaasd', '2022-03-31', 1, '2021-12-16 16:06:01', '2022-03-16 14:07:07', NULL, 3, 0, NULL, 81, 0, NULL),
(177, 'GIFT-OF1OY', 1, '50.00', 0, NULL, '2022-01-28', 1, '2021-12-28 14:26:46', '2021-12-28 14:26:46', NULL, 1, 0, NULL, NULL, 1, NULL),
(178, 'GIFT-HRVLZ', 1, '50.00', 0, NULL, '2022-05-01', 1, '2022-03-31 11:30:40', '2022-03-31 11:30:40', NULL, 1, 0, NULL, NULL, 1, NULL),
(179, 'GIFT-QBOKI', 1, '50.00', 0, NULL, '2022-05-01', 1, '2022-03-31 11:30:47', '2022-03-31 11:30:47', NULL, 1, 0, NULL, NULL, 1, NULL),
(180, 'GIFT-2W5SP', 1, '50.00', 0, NULL, '2022-05-01', 1, '2022-03-31 11:31:39', '2022-03-31 11:31:39', NULL, 1, 0, NULL, NULL, 1, NULL),
(181, 'GIFT-CNT5G', 1, '50.00', 0, NULL, '2022-05-04', 1, '2022-04-04 11:45:17', '2022-04-04 11:45:17', NULL, 1, 0, NULL, NULL, 1, NULL),
(182, 'GIFT-RVWNE', 1, '50.00', 0, NULL, '2022-05-04', 1, '2022-04-04 11:49:00', '2022-04-04 11:49:00', NULL, 1, 0, NULL, NULL, 1, NULL),
(183, 'GIFT-KYC76', 1, '50.00', 0, NULL, '2022-05-04', 1, '2022-04-04 12:10:37', '2022-04-04 12:10:37', NULL, 1, 0, NULL, NULL, 1, NULL),
(184, 'GIFT-UTTAY', 1, '50.00', 0, NULL, '2022-05-04', 1, '2022-04-04 12:12:51', '2022-04-04 12:12:51', NULL, 1, 0, NULL, NULL, 1, NULL),
(185, 'GIFT-UUKGS', 1, '50.00', 0, NULL, '2022-05-04', 1, '2022-04-04 12:18:53', '2022-04-04 12:18:53', NULL, 1, 0, NULL, NULL, 1, NULL),
(186, 'GIFT-5INQ4', 1, '50.00', 0, NULL, '2022-05-04', 1, '2022-04-04 12:53:42', '2022-04-04 12:53:42', NULL, 1, 0, NULL, NULL, 1, NULL),
(187, 'GIFT-TRKON', 1, '50.00', 0, NULL, '2022-05-04', 1, '2022-04-04 12:56:52', '2022-04-04 12:56:52', NULL, 1, 0, NULL, NULL, 1, NULL),
(188, 'GIFT-PMLQJ', 1, '50.00', 0, NULL, '2022-05-04', 1, '2022-04-04 13:51:12', '2022-04-04 13:51:12', NULL, 1, 0, NULL, NULL, 1, NULL),
(189, 'GIFT-UV6RF', 1, '50.00', 0, NULL, '2022-05-04', 1, '2022-04-04 13:53:25', '2022-04-04 13:53:25', NULL, 1, 0, NULL, NULL, 1, NULL),
(190, 'GIFT-Z7TBP', 1, '50.00', 0, NULL, '2022-05-04', 1, '2022-04-04 13:54:32', '2022-04-04 13:54:32', NULL, 1, 0, NULL, NULL, 1, NULL),
(191, 'GIFT-Q1D6U', 1, '50.00', 0, NULL, '2022-05-04', 1, '2022-04-04 14:02:30', '2022-04-04 14:02:30', NULL, 1, 0, NULL, NULL, 1, NULL),
(192, 'GIFT-QBSQ7', 1, '50.00', 0, NULL, '2022-05-04', 1, '2022-04-04 14:06:28', '2022-04-04 14:06:28', NULL, 1, 0, NULL, NULL, 1, NULL),
(193, 'GIFT-XAGXE', 1, '50.00', 0, NULL, '2022-05-04', 1, '2022-04-04 14:09:10', '2022-04-04 14:09:10', NULL, 1, 0, NULL, NULL, 1, NULL),
(194, 'GIFT-JENGK', 1, '50.00', 0, NULL, '2022-05-04', 1, '2022-04-04 14:34:16', '2022-04-04 14:34:16', NULL, 1, 0, NULL, NULL, 1, NULL),
(195, 'GIFT-JJVEY', 1, '50.00', 0, NULL, '2022-05-05', 1, '2022-04-05 11:28:50', '2022-04-05 11:28:50', NULL, 1, 0, NULL, NULL, 1, NULL),
(196, 'GIFT-RMKNE', 1, '50.00', 0, NULL, '2022-05-05', 1, '2022-04-05 13:14:11', '2022-04-05 13:14:11', NULL, 1, 0, NULL, NULL, 1, NULL),
(197, 'GIFT-PZNCS', 1, '50.00', 0, NULL, '2022-05-05', 1, '2022-04-05 13:14:24', '2022-04-05 13:14:24', NULL, 1, 0, NULL, NULL, 1, NULL),
(198, 'GIFT-SWZ8U', 1, '50.00', 0, NULL, '2022-05-06', 1, '2022-04-06 15:36:37', '2022-04-06 15:36:37', NULL, 1, 0, NULL, NULL, 1, NULL),
(199, 'GIFT-PMM4D', 1, '50.00', 0, NULL, '2022-05-10', 1, '2022-04-10 12:57:22', '2022-04-10 12:57:22', NULL, 1, 0, NULL, NULL, 1, NULL),
(200, 'GIFT-JQ8GF', 1, '50.00', 0, NULL, '2022-05-11', 1, '2022-04-11 12:47:44', '2022-04-11 12:47:44', NULL, 1, 0, NULL, NULL, 1, NULL),
(201, 'GIFT-I8EZW', 1, '50.00', 0, NULL, '2022-05-11', 1, '2022-04-11 12:49:01', '2022-04-11 12:49:01', NULL, 1, 0, NULL, NULL, 1, NULL),
(202, 'GIFT-UAC79', 1, '50.00', 0, NULL, '2022-05-11', 1, '2022-04-11 12:58:00', '2022-04-11 12:58:00', NULL, 1, 0, NULL, NULL, 1, NULL),
(203, 'GIFT-KJDAW', 1, '50.00', 0, NULL, '2022-05-11', 1, '2022-04-11 13:03:54', '2022-04-11 13:03:54', NULL, 1, 0, NULL, NULL, 1, NULL),
(204, 'GIFT-JHTFF', 1, '50.00', 0, NULL, '2022-05-11', 1, '2022-04-11 13:06:00', '2022-04-11 13:06:00', NULL, 1, 0, NULL, NULL, 1, NULL),
(205, 'GIFT-HK6KW', 1, '50.00', 0, NULL, '2022-05-11', 1, '2022-04-11 13:08:01', '2022-04-11 13:08:01', NULL, 1, 0, NULL, NULL, 1, NULL),
(206, 'GIFT-7OTDQ', 1, '50.00', 0, NULL, '2022-05-11', 1, '2022-04-11 13:11:59', '2022-04-11 13:11:59', NULL, 1, 0, NULL, NULL, 1, NULL),
(207, 'GIFT-A5KWT', 1, '50.00', 0, NULL, '2022-05-11', 1, '2022-04-11 13:13:19', '2022-04-11 13:13:19', NULL, 1, 0, NULL, NULL, 1, NULL),
(208, 'GIFT-VHSRW', 1, '50.00', 0, NULL, '2022-05-11', 1, '2022-04-11 13:16:51', '2022-04-11 13:16:51', NULL, 1, 0, NULL, NULL, 1, NULL),
(209, 'GIFT-8VYYI', 1, '50.00', 0, NULL, '2022-05-11', 1, '2022-04-11 13:19:17', '2022-04-11 13:19:17', NULL, 1, 0, NULL, NULL, 1, NULL),
(210, 'GIFT-PAUNL', 1, '50.00', 0, NULL, '2022-05-11', 1, '2022-04-11 13:23:37', '2022-04-11 13:23:37', NULL, 1, 0, NULL, NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `promotions`
--

CREATE TABLE `promotions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT 1,
  `group_id` int(11) DEFAULT NULL,
  `discount` decimal(8,2) DEFAULT NULL,
  `expiration_date` datetime DEFAULT NULL,
  `start_date` datetime NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `deactivation_notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name_ar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount_qty` decimal(8,2) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `gift_ar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gift_en` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `priority` int(11) NOT NULL,
  `check_all_conditions` tinyint(4) DEFAULT NULL,
  `times` int(11) DEFAULT NULL,
  `different_brands` tinyint(4) DEFAULT NULL,
  `different_categories` tinyint(4) DEFAULT NULL,
  `different_products` tinyint(4) DEFAULT NULL,
  `override_discount` tinyint(4) DEFAULT NULL,
  `list_id` int(10) UNSIGNED DEFAULT NULL,
  `qty` int(11) NOT NULL DEFAULT 1,
  `category` smallint(6) NOT NULL DEFAULT 1,
  `boost` decimal(8,2) DEFAULT NULL,
  `exclusive` tinyint(4) NOT NULL,
  `periodic` int(11) DEFAULT NULL,
  `instant` tinyint(1) NOT NULL DEFAULT 0,
  `incentive_id` int(11) DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description_ar` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `promotions`
--

INSERT INTO `promotions` (`id`, `name`, `type`, `group_id`, `discount`, `expiration_date`, `start_date`, `active`, `deactivation_notes`, `created_at`, `updated_at`, `name_ar`, `discount_qty`, `deleted_at`, `gift_ar`, `gift_en`, `priority`, `check_all_conditions`, `times`, `different_brands`, `different_categories`, `different_products`, `override_discount`, `list_id`, `qty`, `category`, `boost`, `exclusive`, `periodic`, `instant`, `incentive_id`, `description`, `description_ar`) VALUES
(18, 'خصم 250 جنيه علي كرتونة', 1, NULL, '75.00', '2021-11-30 00:00:00', '2021-11-08 00:00:00', 0, 'يبيسبشبسييبشس', '2021-11-21 12:12:12', '2021-12-15 11:48:09', 'خصم 250 جنيه علي كرتونة', '2.00', NULL, NULL, NULL, 1, 0, 109, 0, 0, NULL, 0, NULL, 1, 1, NULL, 0, 0, 0, NULL, NULL, NULL),
(19, 'Mix Incintive for TIMee', 1, NULL, NULL, '2021-12-15 00:00:00', '2021-12-01 00:00:00', 0, 'test', '2021-12-13 17:51:01', '2022-06-14 16:47:41', 'Mix Incintive for TIMe', NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 0, 0, 0, NULL, NULL, NULL),
(20, 'MIX INCENTIVE FOR Time', 1, NULL, NULL, '2021-12-30 00:00:00', '2021-12-07 00:00:00', 0, 'test', '2021-12-14 15:28:45', '2022-06-14 16:47:36', 'MIX INCENTIVE FOR Time', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 0, 0, 0, NULL, NULL, NULL),
(21, 'MIX INCENTIVE FOR DVD', 1, NULL, NULL, '2021-12-31 00:00:00', '2021-12-06 00:00:00', 0, 'test', '2021-12-14 17:58:36', '2022-06-14 16:47:27', 'MIX INCENTIVE FOR DVD', NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 0, 0, 0, NULL, NULL, NULL),
(22, 'MIX INCENTIVE FOR TIME', 1, NULL, NULL, '2021-12-31 00:00:00', '2021-12-07 00:00:00', 0, 'test', '2021-12-14 18:00:59', '2022-06-14 16:47:33', 'MIX INCENTIVE FOR TIME', NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 0, 0, 0, NULL, NULL, NULL),
(23, 'Instant incentive DVD MIX WS', 1, NULL, NULL, '2022-09-22 00:00:00', '2021-12-01 00:00:00', 0, 'test', '2021-12-15 11:49:41', '2022-06-19 15:09:27', 'خصم مسموح به منتجات منصور', NULL, NULL, NULL, NULL, 60, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 0, 30, 1, 702, 'MIX INCENTIVE FOR TIME ( SPECIAL POS)', 'MIX INCENTIVE FOR TIME ( SPECIAL POS)'),
(24, 'MIX INCENTIVE FOR DVD', 1, NULL, NULL, '2022-01-31 00:00:00', '2021-12-01 00:00:00', 0, 'test', '2021-12-15 11:50:38', '2022-01-05 10:56:20', 'MIX INCENTIVE FOR DVD', NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 0, 0, 0, NULL, NULL, NULL),
(25, 'Buy one BIC Tray  get (Recharge cards with 20 EGP  + 3 BIC  lighters free )', 1, NULL, '100.00', '2021-12-31 00:00:00', '2021-12-01 00:00:00', 0, 'test', '2021-12-15 18:37:24', '2021-12-26 11:30:11', 'Buy one BIC Tray  get (Recharge cards with 20 EGP  + 3 BIC  lighters free )', '3.00', NULL, NULL, NULL, 1, 0, 1, 0, 0, NULL, 0, NULL, 1, 1, '90.00', 0, 0, 0, NULL, NULL, NULL),
(26, 'MIX INCENTIVE FOR TIME', 1, NULL, NULL, '2022-01-31 00:00:00', '2021-12-01 00:00:00', 0, 'test', '2021-12-16 10:08:48', '2022-01-05 10:56:14', 'MIX INCENTIVE FOR TIME', NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 0, 0, 0, NULL, NULL, NULL),
(27, 'For 1 Time get 1 tray', 1, NULL, '100.00', '2021-12-31 00:00:00', '2021-12-08 00:00:00', 0, 'test', '2021-12-16 13:56:12', '2021-12-26 11:30:15', 'For 1 Time get 1 tray', '1.00', NULL, NULL, NULL, 1, 0, 1, 0, 0, NULL, 0, NULL, 1, 1, NULL, 0, 0, 0, NULL, NULL, NULL),
(28, 'For 1 Time get 2 ligters', 1, NULL, '100.00', '2021-12-31 00:00:00', '2021-12-01 00:00:00', 0, 'test', '2021-12-16 14:26:38', '2021-12-26 11:30:20', 'For 1 Time get 2 ligters', '2.00', NULL, NULL, NULL, 2, 0, 1, 0, 0, NULL, 0, NULL, 1, 1, NULL, 0, 0, 0, NULL, NULL, NULL),
(29, 'MIX INCENTIVE FOR TIME ( SPECIAL POS) from 4', 1, NULL, NULL, '2022-12-31 00:00:00', '2021-12-01 00:00:00', 0, 'test', '2021-12-16 14:37:32', '2022-01-05 10:56:45', 'MIX INCENTIVE FOR TIME ( SPECIAL POS) from 4', NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 0, 0, 0, NULL, NULL, NULL),
(30, 'Buy atleast 1TARGET, 1DVD, 1TIME and 4 BIC tray', 1, NULL, '100.00', '2021-12-31 00:00:00', '2021-12-01 00:00:00', 0, 'test', '2021-12-16 14:59:41', '2021-12-26 11:30:25', 'Buy atleast 1TARGET, 1DVD, 1TIME and 4 BIC tray', '1.00', NULL, NULL, NULL, 100, 1, 1, 0, 0, NULL, 0, NULL, 1, 1, '1000.00', 0, 0, 0, NULL, NULL, NULL),
(31, 'Fix on Time', 1, NULL, NULL, '2021-12-31 00:00:00', '2021-12-01 00:00:00', 0, 'test', '2021-12-16 15:10:47', '2022-01-05 10:57:24', 'Fix on Time', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 0, 0, 0, NULL, NULL, NULL),
(32, 'fix incentive on time Mon', 1, NULL, NULL, '2021-12-31 00:00:00', '2021-12-13 00:00:00', 0, 'test', '2021-12-20 15:09:03', '2022-01-05 10:57:41', 'fix incentive on time Mon', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 0, 0, 0, NULL, NULL, NULL),
(33, 'Buy 1 ( bic tray ) to get 1 bic lighter', 1, NULL, '100.00', '2021-12-31 00:00:00', '2021-12-08 00:00:00', 0, 'test', '2021-12-20 15:48:23', '2021-12-26 11:30:30', 'Buy 1 ( bic tray ) to get 1 bic lighter', '3.00', NULL, NULL, NULL, 4, 0, 1, 0, 0, NULL, 0, NULL, 1, 1, '20.00', 0, 0, 0, NULL, NULL, NULL),
(34, 'buy 48 bicTray to get 1 bic tray', 1, NULL, '100.00', '2021-12-31 00:00:00', '2021-12-01 00:00:00', 0, 'test', '2021-12-20 16:08:01', '2021-12-26 11:30:35', 'buy 48 bicTray to get 1 bic tray', '1.00', NULL, NULL, NULL, 1, 0, 1, 0, 0, NULL, 0, NULL, 1, 1, NULL, 0, 0, 0, NULL, NULL, NULL),
(35, 'buy 84 bicTray to get 2', 1, NULL, '100.00', '2021-12-31 00:00:00', '2021-12-14 00:00:00', 0, 'test', '2021-12-20 16:10:04', '2021-12-26 11:30:39', 'buy 84 bicTray to get 2', '2.00', NULL, NULL, NULL, 2, 0, 5, 0, 0, NULL, 0, NULL, 1, 1, NULL, 0, 0, 0, NULL, NULL, NULL),
(36, 'ami', 1, NULL, '100.00', '2021-12-31 00:00:00', '2021-12-01 00:00:00', 0, 'tds', '2021-12-23 17:01:51', '2022-01-05 14:01:50', 'ami', '5.00', NULL, NULL, NULL, 5, 0, 2, 0, 0, NULL, 0, NULL, 1, 1, '0.00', 0, 0, 0, NULL, NULL, NULL),
(37, '1 time then get gift', 1, NULL, '100.00', '2021-12-31 00:00:00', '2021-12-01 00:00:00', 0, 'test', '2021-12-27 14:27:04', '2022-01-05 14:01:56', '1 time then get gift', NULL, NULL, NULL, NULL, 5, 0, 1, 0, 0, NULL, 0, NULL, 1, 1, '600.00', 0, 0, 0, NULL, NULL, NULL),
(38, '2 time to get gift', 1, NULL, '100.00', '2021-12-31 00:00:00', '2021-12-01 00:00:00', 0, 'test', '2021-12-28 12:39:45', '2022-01-05 14:02:00', '2 time to get gift', NULL, NULL, NULL, NULL, 4, 0, 1, 0, 0, NULL, 0, NULL, 1, 1, '600.00', 0, 0, 0, NULL, NULL, NULL),
(39, 'incentive on time', 1, NULL, NULL, '2021-12-30 00:00:00', '2021-12-08 00:00:00', 0, 'test', '2021-12-28 14:47:20', '2022-01-05 10:57:57', 'incentive on time', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 0, 0, 0, NULL, NULL, NULL),
(40, 'Buy from DVD OR TIME', 1, NULL, NULL, '2022-04-03 00:00:00', '2021-12-01 00:00:00', 0, 'test', '2021-12-28 15:35:00', '2022-01-05 10:58:04', 'Buy from DVD OR TIME', NULL, NULL, NULL, NULL, 22, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 0, 0, 0, NULL, NULL, NULL),
(41, 'continue on time only', 1, NULL, NULL, '2022-05-13 00:00:00', '2021-12-01 00:00:00', 0, 'test', '2021-12-28 15:42:37', '2022-01-05 10:58:11', 'continue on time only', NULL, NULL, NULL, NULL, 100, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 0, 0, 0, NULL, NULL, NULL),
(42, 'Buy 1 bic  tray , 20 + 3 bic lighter', 1, NULL, '100.00', '2021-12-31 00:00:00', '2021-12-01 00:00:00', 0, 'te', '2021-12-28 16:34:05', '2022-01-05 14:02:05', 'Buy 1 bic  tray , 20 +3 bic lighter', NULL, NULL, NULL, NULL, 5, 0, 1, 0, 0, NULL, 0, NULL, 1, 1, '20.00', 0, 0, 0, NULL, NULL, NULL),
(43, 'buy 4 bictray', 1, NULL, '100.00', '2021-12-31 00:00:00', '2021-12-01 00:00:00', 0, 'sad', '2021-12-28 16:35:10', '2022-01-05 14:02:09', 'buy 4 bictray', NULL, NULL, NULL, NULL, 4, 0, 1, 0, 0, NULL, 0, NULL, 1, 1, NULL, 0, 0, 0, NULL, NULL, NULL),
(44, 'buy 7 bictray', 1, NULL, '100.00', '2021-12-31 00:00:00', '2021-12-01 00:00:00', 0, 'sad', '2021-12-28 16:36:14', '2022-01-05 14:02:13', 'buy 7 bictray', NULL, NULL, NULL, NULL, 3, 0, 1, 0, 0, NULL, 0, NULL, 1, 1, NULL, 0, 0, 0, NULL, NULL, NULL),
(45, 'mix promotion', 1, NULL, NULL, '2021-12-31 00:00:00', '2021-12-01 00:00:00', 0, 'jhj', '2021-12-28 17:12:49', '2022-01-05 14:02:17', 'mix promotion', NULL, NULL, NULL, NULL, 90, 0, 2, 0, 0, NULL, 0, NULL, 1, 1, '550.00', 0, 0, 0, NULL, NULL, NULL),
(46, 'Mix DVD or Item', 1, NULL, NULL, '2022-01-31 00:00:00', '2022-01-01 00:00:00', 0, 'test', '2022-01-02 16:36:43', '2022-01-05 10:58:24', 'Mix DVD or Item', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 0, 0, 0, NULL, NULL, NULL),
(47, 'time only', 1, NULL, NULL, '2022-01-31 00:00:00', '2022-01-01 00:00:00', 0, 'test', '2022-01-02 16:37:44', '2022-01-05 10:58:19', 'time only', NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 0, 0, 0, NULL, NULL, NULL),
(48, 'BIC 1', 1, NULL, '100.00', '2022-01-31 00:00:00', '2022-01-01 00:00:00', 0, 'test', '2022-01-03 14:06:07', '2022-01-05 14:02:22', 'BIC 1', NULL, NULL, NULL, NULL, 1, 0, 1, 0, 0, NULL, 0, NULL, 1, 1, NULL, 0, 0, 0, NULL, NULL, NULL),
(49, 'BIC gifts 5', 1, NULL, '100.00', '2022-01-31 00:00:00', '2022-01-01 00:00:00', 0, 'test', '2022-01-04 13:37:31', '2022-01-05 14:02:27', 'BIC gifts 5', NULL, NULL, NULL, NULL, 5, 0, 1, 0, 0, NULL, 0, NULL, 1, 1, NULL, 0, 0, 0, NULL, NULL, NULL),
(50, 'BIC gifts 4', 1, NULL, '100.00', '2022-01-31 00:00:00', '2022-01-01 00:00:00', 0, 'test', '2022-01-04 13:39:50', '2022-01-05 14:05:21', 'BIC gifts 4', NULL, NULL, NULL, NULL, 4, 0, 1, 0, 0, NULL, 0, NULL, 1, 1, NULL, 0, 0, 0, NULL, NULL, NULL),
(51, 'BIC gifts 3', 1, NULL, '100.00', '2022-01-31 00:00:00', '2022-01-01 00:00:00', 0, 'test', '2022-01-04 13:41:12', '2022-01-05 14:05:15', 'BIC gifts 3', NULL, NULL, NULL, NULL, 3, 0, 1, 0, 0, NULL, 0, NULL, 1, 1, NULL, 0, 0, 0, NULL, NULL, NULL),
(52, 'BIC gifts 2', 1, NULL, '100.00', '2022-01-31 00:00:00', '2022-01-01 00:00:00', 0, 'test', '2022-01-04 13:42:20', '2022-01-05 14:01:33', 'BIC gifts 2', NULL, NULL, NULL, NULL, 2, 0, 1, 0, 0, NULL, 0, NULL, 1, 1, NULL, 0, 0, 0, NULL, NULL, NULL),
(53, 'BIC gifts 1', 1, NULL, '100.00', '2022-01-31 00:00:00', '2022-01-01 00:00:00', 0, 'test', '2022-01-04 13:43:16', '2022-01-05 14:01:28', 'BIC gifts 1', NULL, NULL, NULL, NULL, 1, 0, 2, 0, 0, NULL, 0, NULL, 1, 1, NULL, 0, 0, 0, NULL, NULL, NULL),
(54, 'Mix BIG', 1, NULL, NULL, '2022-01-31 00:00:00', '2022-01-01 00:00:00', 0, 'sdf', '2022-01-04 15:55:01', '2022-01-05 14:01:24', 'Mix BIC', NULL, NULL, NULL, NULL, 1, 0, 1, 0, 0, NULL, 0, NULL, 1, 1, '550.00', 0, 0, 0, NULL, NULL, NULL),
(55, 'MIX BIC Higher', 1, NULL, NULL, '2022-01-31 00:00:00', '2022-01-01 00:00:00', 0, 'sdf', '2022-01-04 16:20:38', '2022-01-05 14:01:20', 'MIX BIC Higher', NULL, NULL, NULL, NULL, 2, 0, 1, 0, 0, NULL, 0, NULL, 1, 1, '1100.00', 0, 0, 0, NULL, NULL, NULL),
(56, 'TIME INCENTIVE WS', 1, NULL, NULL, '2022-09-16 00:00:00', '2022-01-01 00:00:00', 0, '0', '2022-01-05 11:00:44', '2022-06-13 10:34:30', 'خصم مسموح به تايـــم جملة', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 0, NULL, 0, 2006, NULL, NULL),
(57, 'Mini Trade Program DVD', 1, NULL, NULL, '2022-06-30 00:00:00', '2022-01-01 00:00:00', 0, '0', '2022-01-05 11:01:51', '2022-06-13 10:34:27', 'خصم مسموح به برنامج تجار دافيدوف', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 0, NULL, 1, 309, NULL, NULL),
(58, 'Wholesale Partnership DVD', 1, NULL, NULL, '2022-01-31 00:00:00', '2022-01-01 00:00:00', 0, 'test', '2022-01-05 11:05:49', '2022-06-12 14:18:29', 'DVD خصم مسموح به مسحوبات تجار جملة', NULL, NULL, NULL, NULL, 50, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 0, NULL, 0, 249, NULL, NULL),
(59, 'MIX INCENTIVE FOR DVD', 1, NULL, NULL, '2022-01-31 00:00:00', '2022-01-01 00:00:00', 0, 'd', '2022-01-05 11:10:10', '2022-06-12 14:18:34', 'MIX INCENTIVE FOR DVD', NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 0, 0, 0, NULL, NULL, NULL),
(60, 'Wholesale Partnership DVD', 1, NULL, NULL, '2022-01-31 00:00:00', '2022-01-01 00:00:00', 0, 'test', '2022-01-05 11:12:34', '2022-06-12 14:18:37', 'DVD خصم مسموح به مسحوبات تجار جملة', NULL, NULL, NULL, NULL, 50, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 0, NULL, 0, 249, NULL, NULL),
(61, 'Wholesale Partnership DVD', 1, NULL, NULL, '2022-01-31 00:00:00', '2022-01-01 00:00:00', 0, 'test', '2022-01-05 11:13:26', '2022-06-12 14:18:53', 'DVD خصم مسموح به مسحوبات تجار جملة', NULL, NULL, NULL, NULL, 50, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 0, NULL, 0, 249, NULL, NULL),
(62, 'test111', 1, NULL, NULL, '2022-12-01 00:00:00', '2022-10-01 00:00:00', 0, 'ddsdsd', '2022-01-05 12:51:58', '2022-01-05 14:01:17', 'test111', NULL, NULL, NULL, NULL, 1, 0, 2, 1, 0, NULL, 0, NULL, 1, 1, NULL, 1, 0, 0, NULL, NULL, NULL),
(63, 'bbrtb', 1, NULL, NULL, '2022-12-01 00:00:00', '2022-10-01 00:00:00', 0, 'dddd', '2022-01-05 13:11:06', '2022-01-05 14:01:12', 'berbrbt', NULL, NULL, NULL, NULL, 1, 0, 12, 1, 0, NULL, 0, NULL, 1, 1, NULL, 0, 0, 0, NULL, NULL, NULL),
(64, 'a', 1, NULL, '1.00', '2022-01-20 00:00:00', '2022-01-03 00:00:00', 0, 'dddd', '2022-01-05 13:39:44', '2022-01-05 14:01:08', 'a', '1.00', NULL, NULL, NULL, 1, 0, 1, 0, 0, NULL, 0, NULL, 1, 1, NULL, 0, 1, 0, NULL, NULL, NULL),
(65, 'Buy 4 BIC Cartoons get 1', 1, NULL, '100.00', '2022-01-31 00:00:00', '2022-01-03 00:00:00', 0, 'test', '2022-01-05 14:07:36', '2022-06-13 12:00:45', 'Buy 4 BIC Cartoons get 1', '1.00', NULL, NULL, NULL, 1, 0, 1, 0, 0, NULL, 0, NULL, 1, 1, NULL, 0, 0, 0, NULL, NULL, NULL),
(66, 'Buy 7 BIC Cartoons get 2', 1, NULL, '100.00', '2022-01-31 00:00:00', '2022-01-02 00:00:00', 0, 'test', '2022-01-05 14:08:36', '2022-06-13 12:00:41', 'Buy 7 BIC Cartoons get 2', '2.00', NULL, NULL, NULL, 2, 0, 1, 0, 0, NULL, 0, NULL, 1, 1, NULL, 0, 0, 0, NULL, NULL, NULL),
(67, 'Buy 11 BIC Cartoons get 4 mmmm', 1, NULL, '100.00', '2022-01-31 00:00:00', '2022-01-02 00:00:00', 0, 'test', '2022-01-05 14:09:46', '2022-06-13 12:00:37', 'Buy 11 BIC Cartoons get 4', '4.00', NULL, NULL, NULL, 3, 0, 1, 0, 0, NULL, 0, NULL, 1, 1, NULL, 0, 0, 0, NULL, NULL, NULL),
(68, 'Buy 15 BIC Cartoons get 8', 1, NULL, '100.00', '2022-01-31 00:00:00', '2022-01-02 00:00:00', 0, 'test', '2022-01-05 14:13:23', '2022-06-13 12:00:48', 'Buy 15 BIC Cartoons get 8', '8.00', NULL, NULL, NULL, 4, 0, 1, 0, 0, NULL, 0, NULL, 1, 1, NULL, 0, 0, 0, NULL, NULL, NULL),
(69, 'Buy 20 BIC Cartoons get 13', 1, NULL, '100.00', '2022-01-31 00:00:00', '2022-01-02 00:00:00', 0, 'test', '2022-01-05 14:16:00', '2022-06-13 12:00:52', 'Buy 20 BIC Cartoons get 13', '13.00', NULL, NULL, NULL, 5, 0, 1, 0, 0, NULL, 0, NULL, 1, 1, NULL, 0, 0, 0, NULL, NULL, NULL),
(70, 'Buy one BIC Tray  get (Recharge cards with 20 EGP  + 3 BIC  lighters free )', 1, NULL, '100.00', '2022-01-31 00:00:00', '2022-01-02 00:00:00', 0, 'test', '2022-01-05 15:25:35', '2022-06-13 12:00:54', 'Buy one BIC Tray  get (Recharge cards with 20 EGP  + 3 BIC  lighters free )', '3.00', NULL, NULL, NULL, 90, 0, 99999, 0, 0, NULL, 0, NULL, 1, 1, '20.00', 1, 1, 0, NULL, NULL, NULL),
(71, 'MIX INCENTIVE FOR MIX CASES', 1, NULL, NULL, '2022-01-31 00:00:00', '2022-01-02 00:00:00', 0, 'testgfg', '2022-01-05 18:04:17', '2022-06-13 12:00:56', 'MIX INCENTIVE FOR MIX CASES', NULL, NULL, NULL, NULL, 5, 0, 3, 0, 0, NULL, 0, NULL, 1, 1, '550.00', 0, 0, 0, NULL, NULL, NULL),
(72, 'asdas', 1, NULL, NULL, '2022-01-31 00:00:00', '2022-01-05 00:00:00', 0, 'gfgf', '2022-01-08 14:12:39', '2022-06-19 14:12:34', 'asdas', NULL, '2022-06-19 14:12:34', NULL, NULL, 100000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 0, 0, 0, NULL, NULL, NULL),
(73, 'MIX INCENTIVE FOR FREE GIFT ON DVD OR TIME 2 tray', 1, 1, NULL, '2022-01-31 00:00:00', '2022-01-02 00:00:00', 0, 'test', '2022-01-09 15:43:48', '2022-06-13 12:00:59', 'MIX INCENTIVE FOR FREE GIFT ON DVD OR TIME 2 tray', NULL, NULL, NULL, NULL, 8, 0, 1, 0, 0, NULL, 0, NULL, 1, 1, '600.00', 0, 0, 0, NULL, NULL, NULL),
(74, 'MIX INCENTIVE FOR FREE GIFT ON DVD OR TIME 1 tray , 1 lighter', 1, 1, NULL, '2022-01-31 00:00:00', '2022-01-02 00:00:00', 0, 'test', '2022-01-09 15:45:49', '2022-06-13 12:01:01', 'MIX INCENTIVE FOR FREE GIFT ON DVD OR TIME 1 tray , 1 lighter', NULL, NULL, NULL, NULL, 9, 0, 1, 0, 0, NULL, 0, NULL, 1, 1, '690.00', 0, 0, 0, NULL, NULL, NULL),
(75, 'MIX INCENTIVE FOR FREE GIFT ON DVD OR TIME 1 tray , 1 lighter', 1, 1, NULL, '2022-01-31 00:00:00', '2022-01-02 00:00:00', 0, 'test', '2022-01-09 15:48:06', '2022-06-13 12:01:09', 'MIX INCENTIVE FOR FREE GIFT ON DVD OR TIME 1 tray , 1 lighter', NULL, NULL, NULL, NULL, 10, 0, 1, 0, 0, NULL, 0, NULL, 1, 1, '645.00', 0, 0, 0, NULL, NULL, NULL),
(76, 'test 1', 1, NULL, NULL, '2022-01-31 00:00:00', '2022-01-01 00:00:00', 0, 'test', '2022-01-10 12:46:47', '2022-01-11 11:13:11', 'test 1', NULL, NULL, NULL, NULL, 2, 0, 5, 0, 0, NULL, 0, NULL, 1, 1, '100.00', 0, 0, 0, NULL, NULL, NULL),
(77, 'Wholesale Partnership DVD', 1, NULL, NULL, '2022-06-30 00:00:00', '2022-06-13 00:00:00', 0, 'jnj', '2022-01-10 13:07:31', '2022-06-20 12:07:23', 'DVD خصم مسموح به مسحوبات تجار جملة', NULL, NULL, NULL, NULL, 100, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 0, NULL, 1, 249, 'DVD خصم مسموح به مسحوبات تجار جملة', 'DVD خصم مسموح به مسحوبات تجار جملة'),
(78, 'MIX INCENTIVE FOR FREE GIFT ON DVD OR TIME 10 BIC J3 PLAIN', 1, 1, NULL, '2022-01-31 00:00:00', '2022-01-01 00:00:00', 0, 'test', '2022-01-11 11:21:56', '2022-06-13 12:01:12', 'MIX INCENTIVE FOR FREE GIFT ON DVD OR TIME 10 BIC J3 PLAIN', NULL, NULL, NULL, NULL, 11, 0, 1, 0, 0, NULL, 0, NULL, 1, 1, '3000.00', 0, 0, 0, NULL, NULL, NULL),
(79, 'MIX INCENTIVE FOR FREE GIFT ON DVD OR TIME 10 BIC Lighter', 1, 1, NULL, '2022-01-31 00:00:00', '2022-01-01 00:00:00', 0, 'test', '2022-01-11 11:28:41', '2022-06-13 12:01:16', 'MIX INCENTIVE FOR FREE GIFT ON DVD OR TIME 10 BIC Lighter', NULL, NULL, NULL, NULL, 10, 0, 1, 0, 0, NULL, 0, NULL, 1, 1, '3450.00', 0, 0, 0, NULL, NULL, NULL),
(80, 'MIX INCENTIVE FOR FREE GIFT ON DVD OR TIME (5 BIC J3 PLAIN and 5 BIC J5 PRINT)', 1, 1, NULL, '2022-01-31 00:00:00', '2022-01-01 00:00:00', 0, 'test', '2022-01-11 11:31:47', '2022-06-13 12:01:19', 'MIX INCENTIVE FOR FREE GIFT ON DVD OR TIME (5 BIC J3 PLAIN and 5 BIC J5 PRINT)', NULL, NULL, NULL, NULL, 11, 0, 1, 0, 0, NULL, 0, NULL, 1, 1, '3225.00', 0, 0, 0, NULL, NULL, NULL),
(81, 'MIX INCENTIVE FOR FREE GIFT ON DVD OR TIME 12 BIC J3 PLAIN', 1, 1, NULL, '2022-01-31 00:00:00', '2022-01-01 00:00:00', 0, 'test', '2022-01-11 11:33:50', '2022-06-13 12:01:27', 'MIX INCENTIVE FOR FREE GIFT ON DVD OR TIME 12 BIC J3 PLAIN', NULL, NULL, NULL, NULL, 12, 0, 1, 0, 0, NULL, 0, NULL, 1, 1, '3600.00', 0, 0, 0, NULL, NULL, NULL),
(82, 'MIX INCENTIVE FOR FREE GIFT ON DVD OR TIME 12 BIC J5 PRINT', 1, 1, NULL, '2022-01-31 00:00:00', '2022-01-01 00:00:00', 0, 'test', '2022-01-11 11:35:56', '2022-06-13 12:01:33', 'MIX INCENTIVE FOR FREE GIFT ON DVD OR TIME 12 BIC J5 PRINT', NULL, NULL, NULL, NULL, 13, 0, 1, 0, 0, NULL, 0, NULL, 1, 1, '4140.00', 0, 0, 0, NULL, NULL, NULL),
(83, 'MIX INCENTIVE FOR FREE GIFT ON DVD OR TIME (6 BIC J3 PLAIN and 6 BIC J5 PRINT)', 1, 1, NULL, '2022-01-31 00:00:00', '2022-01-01 00:00:00', 0, 'test', '2022-01-11 11:38:22', '2022-06-13 12:01:42', 'MIX INCENTIVE FOR FREE GIFT ON DVD OR TIME (6 BIC J3 PLAIN and 6 BIC J5 PRINT)', NULL, NULL, NULL, NULL, 14, 0, 1, 0, 0, NULL, 0, NULL, 1, 1, '3870.00', 0, 0, 0, NULL, NULL, NULL),
(84, 'MIX INCENTIVE FOR FREE GIFT ON DVD OR TIME 24 BIC J3 PLAIN', 1, 1, NULL, '2022-01-31 00:00:00', '2022-01-01 00:00:00', 0, 'test', '2022-01-11 11:40:19', '2022-06-13 12:01:46', 'MIX INCENTIVE FOR FREE GIFT ON DVD OR TIME 24 BIC J3 PLAIN', NULL, NULL, NULL, NULL, 15, 0, 1, 0, 0, NULL, 0, NULL, 1, 1, '7200.00', 0, 0, 0, NULL, NULL, NULL),
(85, 'MIX INCENTIVE FOR FREE GIFT ON DVD OR TIME 24 BIC 5 PRINT', 1, 1, NULL, '2022-01-31 00:00:00', '2022-01-01 00:00:00', 0, 'test', '2022-01-11 11:54:14', '2022-06-13 12:01:49', 'MIX INCENTIVE FOR FREE GIFT ON DVD OR TIME 24 BIC 5 PRINT', NULL, NULL, NULL, NULL, 16, 0, 1, 0, 0, NULL, 0, NULL, 1, 1, '8280.00', 0, 0, 0, NULL, NULL, NULL),
(86, 'MIX INCENTIVE FOR FREE GIFT ON DVD OR TIME(12 BIC J3 PLAIN and 12 BIC J5 PRINT)', 1, 1, NULL, '2022-01-31 00:00:00', '2022-01-01 00:00:00', 0, 'test', '2022-01-11 11:56:02', '2022-06-13 12:01:52', 'MIX INCENTIVE FOR FREE GIFT ON DVD OR TIME (12 BIC J3 PLAIN and 12 BIC J5 PRINT)', NULL, NULL, NULL, NULL, 17, 0, 1, 0, 0, NULL, 0, NULL, 1, 1, '7740.00', 0, 0, 0, NULL, NULL, NULL),
(87, 'MIX INCENTIVE FOR FREE GIFT ON DVD OR TIME 72 BIC J3 PLAIN', 1, 1, NULL, '2022-01-31 00:00:00', '2022-01-01 00:00:00', 0, 'test', '2022-01-11 11:58:05', '2022-06-13 12:01:59', 'MIX INCENTIVE FOR FREE GIFT ON DVD OR TIME 72 BIC J3 PLAIN', NULL, NULL, NULL, NULL, 18, 0, 1, 0, 0, NULL, 0, NULL, 1, 1, '21600.00', 0, 0, 0, NULL, NULL, NULL),
(88, 'Remaining of Whole Sales Incentives', 1, NULL, '10.00', '2022-03-31 00:00:00', '2022-03-01 00:00:00', 0, 'test', '2022-01-11 11:59:37', '2022-06-19 14:13:27', 'خصم مسموح به اهداف جملة باقى', '1.00', NULL, NULL, NULL, 23, 0, NULL, 0, 0, NULL, 0, NULL, 1, 1, '70.00', 0, NULL, 1, 122, NULL, NULL),
(89, 'MIX INCENTIVE FOR FREE GIFT ON DVD OR TIME (36 BIC J3 PLAIN and 36 BIC J5 PRINT)', 1, 1, NULL, '2022-01-31 00:00:00', '2022-01-01 00:00:00', 0, 'test', '2022-01-11 12:00:54', '2022-06-19 14:13:21', 'MIX INCENTIVE FOR FREE GIFT ON DVD OR TIME (36 BIC J3 PLAIN and 36 BIC J5 PRINT)', NULL, NULL, NULL, NULL, 20, 0, 1, 0, 0, NULL, 0, NULL, 1, 1, '23220.00', 0, 0, 0, NULL, NULL, NULL),
(90, 'MIX INCENTIVE FOR MIX CASES', 1, NULL, '100.00', '2022-03-02 00:00:00', '2022-01-02 00:00:00', 0, 'test', '2022-01-12 17:08:23', '2022-06-19 14:13:17', 'MIX INCENTIVE FOR MIX CASES', '10.00', NULL, NULL, NULL, 9, 0, 3, 0, 0, NULL, 0, NULL, 1, 1, NULL, 0, 0, 0, NULL, NULL, NULL),
(91, 'Remaining of Whole Sales Incentives', 1, NULL, '100.00', '2022-04-27 00:00:00', '2022-01-11 00:00:00', 0, 'test', '2022-01-12 17:23:59', '2022-06-13 12:02:01', 'خصم مسموح به اهداف جملة باقى', NULL, NULL, NULL, NULL, 100, 0, 1, 0, 0, NULL, 0, NULL, 1, 1, '100.00', 0, NULL, 0, 122, 'ddd', 'دافيدوف وايت دافيدوف وايت دافيدوف وايت دافيدوف وايت دافيدوف وايت'),
(92, 'Mixed Incentive', 1, NULL, NULL, '2022-08-22 00:00:00', '2022-03-01 00:00:00', 0, '00', '2022-03-28 16:27:30', '2022-06-13 15:17:59', 'خصم مسموح به تشكيلة', NULL, NULL, NULL, NULL, 22, 0, 1, 1, 0, NULL, 0, NULL, 1, 1, '100.00', 0, NULL, 1, 131, NULL, NULL),
(93, 'Wholesale Partnership DVD', 1, NULL, NULL, '2022-06-30 00:00:00', '2022-06-12 00:00:00', 0, 'test', '2022-06-13 10:08:31', '2022-06-19 14:12:23', 'DVD خصم مسموح به مسحوبات تجار جملة', NULL, NULL, NULL, NULL, 10000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 0, NULL, 1, 249, 'على كل 10 كراتين دافيدوف 30000 جنية خصم', 'على كل 10 كراتين دافيدوف 30000 جنية خصم'),
(94, 'Instant incentive DVD1 MIX', 1, NULL, '100.00', '2022-06-30 00:00:00', '2022-06-13 00:00:00', 0, 'test', '2022-06-13 15:31:02', '2022-06-19 14:12:57', 'خصم مسموح به منتجات منصور', '100.00', NULL, NULL, NULL, 1, 0, NULL, 0, 0, 2, 0, NULL, 1, 1, NULL, 0, NULL, 1, 470, NULL, NULL),
(95, 'Buy from DVD OR TIME First one', 1, NULL, NULL, '2022-08-09 00:00:00', '2022-06-19 11:00:00', 0, 'test', '2022-06-19 15:27:32', '2022-06-19 15:54:15', 'Buy from DVD OR TIME First one', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 0, 30, 1, 788, 'Buy from DVD OR TIME Buy from DVD OR TIME Buy from DVD OR TIME', 'Buy from DVD OR TIME Buy from DVD OR TIME Buy from DVD OR TIME Buy from DVD OR TIME'),
(96, 'Instant incentive DVD1 MIX', 1, NULL, '100.00', '2022-06-30 00:00:00', '2022-06-20 00:00:00', 0, '1', '2022-06-20 12:19:32', '2022-06-20 12:47:20', 'خصم مسموح به منتجات منصور', '1.00', NULL, NULL, NULL, 1, 0, NULL, 0, 0, 1, 0, NULL, 1, 1, NULL, 0, 1, 1, 470, 'علبة ولاعات J5سادة بقيـمــة \"  265  \"   على 3 كراتين أي نوع', 'علبة ولاعات J5سادة بقيـمــة \"  265  \"   على 3 كراتين أي نوع'),
(97, 'Instant incenitve DVD MIX-483', 1, NULL, NULL, '2022-06-30 00:00:00', '2022-06-22 00:00:00', 0, '.0', '2022-06-22 10:26:55', '2022-06-26 12:04:12', 'خصم مسموح به دافيدوف', NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 0, NULL, 1, 483, '-	خصم 125 جنية على ½ كرتونة \n-	خصم 250 جنية على الكرتونة   \nبحد اقصي 9 كراتين', '-	خصم 125 جنية على ½ كرتونة \n-	خصم 250 جنية على الكرتونة   \nبحد اقصي 9 كراتين'),
(98, 'Wholesale Partnership DVD-249', 1, NULL, '100.00', '2022-06-30 00:00:00', '2022-06-22 00:00:00', 0, '5', '2022-06-22 16:21:25', '2022-06-28 16:10:34', 'DVD خصم مسموح به مسحوبات تجار جملة', '100.00', NULL, NULL, NULL, 5, 0, NULL, 0, 0, NULL, 0, NULL, 1, 1, NULL, 0, NULL, 1, 249, 'DVD خصم مسموح به مسحوبات تجار جملة', 'DVD خصم مسموح به مسحوبات تجار جملة'),
(99, 'Instant incentive DVD1 MIX-470', 1, NULL, NULL, '2022-06-30 00:00:00', '2022-06-26 00:00:00', 1, NULL, '2022-06-26 12:41:00', '2022-06-26 12:46:44', 'خصم مسموح به منتجات منصور', NULL, '2022-06-26 12:46:44', NULL, NULL, 100, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 0, NULL, 1, 470, '25 OUTER DVD + 33120', '25 OUTER DVD + 33120'),
(100, 'Instant incentive DVD1 MIX-470', 1, NULL, '100.00', '2022-06-30 00:00:00', '2022-06-26 00:00:00', 0, 'test', '2022-06-26 12:54:10', '2022-07-04 16:48:17', 'خصم مسموح به منتجات منصور', '100.00', NULL, NULL, NULL, 100, 0, NULL, 0, 0, NULL, 0, NULL, 1, 1, '32.54', 0, NULL, 1, 470, '25 OUTER DVD + 33120', '25 OUTER DVD + 33120'),
(101, 'Instant incentive DVD5 MIX-493', 1, NULL, NULL, '2022-06-30 00:00:00', '2022-06-26 00:00:00', 0, 'gg', '2022-06-26 13:18:59', '2022-07-04 16:47:20', 'خصم مسموح به دافيدوف', NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 0, NULL, 1, 493, '1 CASE DVD', '1 CASE DVD'),
(102, 'DVD EVOLVE INC WS-603', 1, NULL, NULL, '2022-06-30 00:00:00', '2022-06-26 00:00:00', 0, 'test', '2022-06-26 13:22:54', '2022-07-04 16:47:27', 'خصم مسموح به دافيدوف إيفولف', NULL, NULL, NULL, NULL, 80, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 0, NULL, 1, 603, 'DVD EVOLVE', 'DVD EVOLVE'),
(103, 'GLDVR INC7-1000', 1, NULL, NULL, '2022-06-30 00:00:00', '2022-06-26 00:00:00', 0, 'test', '2022-06-26 13:25:27', '2022-07-04 16:47:30', 'خصم مسموح به جولدن فيرجينيا', NULL, NULL, NULL, NULL, 70, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 0, NULL, 1, 1000, '12 GV = 1 CASE', '12 GV = 1 CASE'),
(104, 'TIME INCENTIVE WS-992', 1, NULL, NULL, '2022-07-30 00:00:00', '2022-06-26 00:00:00', 0, 'test', '2022-06-26 13:27:24', '2022-07-18 11:17:51', 'خصم مسموح به تايـــم جملة', NULL, NULL, NULL, NULL, 60, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 0, NULL, 1, 992, '1 CASE TIME', '1 CASE TIME'),
(105, 'TARGET EXTRA INCENTIVE WS1-925', 1, NULL, NULL, '2022-07-31 00:00:00', '2022-07-18 00:00:00', 0, '33', '2022-06-26 13:30:23', '2022-07-19 15:57:13', 'خصم 20ج', NULL, NULL, NULL, NULL, 335, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 0, NULL, 1, 925, 'In the case of buying a carton of any kind, 20 pounds will be deducted', 'في حالة شراء كرتونه من اي صنف يتم خصم 20 جنيها'),
(106, 'BIC Wholesalers Discount-1600', 1, NULL, NULL, '2022-06-30 00:00:00', '2022-06-26 00:00:00', 0, '55', '2022-06-26 13:34:31', '2022-06-29 11:15:03', 'خصم مسموح به أسواق خاصه ولاعات', NULL, NULL, NULL, NULL, 40, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 0, NULL, 1, 1600, '12 BIC = 1 CASE BIC  33120', '12 BIC = 1 CASE BIC  33120'),
(107, 'BIC Wholesalers Discount-1600', 1, NULL, '100.00', '2022-07-31 00:00:00', '2022-07-18 00:00:00', 0, '000', '2022-06-29 11:16:15', '2022-07-19 15:57:03', 'خصم مسموح به أسواق خاصه ولاعات', '100.00', NULL, NULL, NULL, 11, 0, NULL, 0, 0, NULL, 0, NULL, 1, 1, '39.30', 0, NULL, 1, 1600, 'خصم مسموح به أسواق خاصه ولاعات', 'خصم مسموح به أسواق خاصه ولاعات'),
(108, 'BIC Wholesalers Discount-1600', 1, NULL, '100.00', '2022-07-31 00:00:00', '2022-07-18 00:00:00', 0, '3', '2022-07-04 16:50:07', '2022-07-18 11:45:05', 'خصم مسموح به أسواق خاصه ولاعات', '1.00', NULL, NULL, NULL, 334, 0, 1, 0, 0, NULL, 0, NULL, 1, 1, '32.50', 0, NULL, 1, 1600, 'test', 'test'),
(109, '20 EGP discount', 1, NULL, NULL, '2022-07-31 00:00:00', '2022-07-19 00:00:00', 0, '0', '2022-07-19 16:03:55', '2022-08-02 10:56:44', 'خصم 20 ج', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 0, NULL, 1, 603, '20 EGP discount on the Case', 'خصم 20 جنية على الكرتونة'),
(110, '20 EGP discount', 1, NULL, NULL, '2022-07-31 00:00:00', '2022-07-19 00:00:00', 0, '0', '2022-07-19 16:10:06', '2022-08-02 10:56:40', 'خصم 20 ج', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 0, NULL, 1, 925, '20 EGP discount on each carton\n-Maximum purchase of 5 Cas\'s only', 'خصم 20 جنية على كل كرتونة\n- الحد الاقصى للشراء 5 كراتين فقط'),
(111, '20 EGP discount', 1, NULL, NULL, '2022-07-31 00:00:00', '2022-07-19 00:00:00', 0, '0', '2022-07-19 16:17:08', '2022-08-02 10:56:35', 'خصم 20 ج', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 0, NULL, 1, 992, '20 EGP discount on each carton', 'خصم 20 جنية على كل كرتونة'),
(112, '20 EGP discount', 1, NULL, NULL, '2022-07-31 00:00:00', '2022-07-19 00:00:00', 0, '0', '2022-07-19 16:18:56', '2022-08-02 10:56:30', 'خصم 20 ج', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 0, NULL, 1, 470, '20 EGP discount on each cas', 'خصم 20 جنية على كل كرتونة'),
(113, '20EGP Discount', 1, NULL, NULL, '2022-08-31 00:00:00', '2022-08-02 00:00:00', 1, NULL, '2022-08-02 12:37:29', '2022-08-02 12:41:34', 'خصم 20ج', NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 0, NULL, 1, 8010, NULL, NULL),
(114, 'TIME Discount', 1, NULL, NULL, '2022-08-31 00:00:00', '2022-08-02 00:00:00', 1, NULL, '2022-08-02 12:43:20', '2022-08-04 09:24:33', 'خصم تايم', NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 0, NULL, 1, 8012, '20EGP Discount', '- خصم 125 على النصف كرتونة\n- خصم 250 + 20 جنية على كل كرتونه بدون حد اقصى'),
(115, '20EGP Discount', 1, NULL, NULL, '2022-08-31 00:00:00', '2022-08-02 00:00:00', 1, NULL, '2022-08-02 12:44:44', '2022-08-02 12:44:44', 'خصم 20ج', NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 0, NULL, 1, 8013, '20EGP Discount', 'خصم 20 جنية على كل كرتونه'),
(116, 'EVOLVE Discount-8011', 1, NULL, '100.00', '2022-08-31 00:00:00', '2022-08-02 00:00:00', 1, NULL, '2022-08-02 12:51:18', '2022-08-02 13:19:38', 'خصم ايفولف', '1.00', NULL, NULL, NULL, 10, 0, 1, 0, 0, NULL, 0, NULL, 1, 1, '39.30', 1, NULL, 1, 8011, 'EVOLVE Discount', '- علبة ولعات على الفاتورة من اول نصف كارتونة ايفولف\n- 20 جنية على كل كارتونة'),
(117, 'DVD WS ONLINE-8010', 1, NULL, NULL, '2022-11-30 00:00:00', '2022-04-28 00:00:00', 1, NULL, '2022-11-03 11:37:14', '2022-11-03 11:37:14', 'خصم دافيدوف جملة اون لاين', NULL, NULL, NULL, NULL, 1123123, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 0, 1, 1, 8010, 'asdasd', 'asd'),
(118, 'EVOLVE WS ONLINE-8011', 1, NULL, NULL, '2022-11-30 00:00:00', '2022-11-01 00:00:00', 1, NULL, '2022-11-03 11:43:57', '2022-11-03 12:16:12', 'خصم ايفولف جملة اون لاين', NULL, NULL, NULL, NULL, 123123, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 0, 1, 1, 8011, 'Hello', 'Hello AR');

-- --------------------------------------------------------

--
-- Table structure for table `promotions_b2b_segments`
--

CREATE TABLE `promotions_b2b_segments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `min` decimal(8,2) NOT NULL,
  `max` decimal(8,2) DEFAULT NULL,
  `discount_type` tinyint(4) NOT NULL,
  `discount` decimal(8,2) NOT NULL,
  `iterator` decimal(8,2) DEFAULT NULL,
  `promotion_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `override_range` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `promotions_b2b_segments`
--

INSERT INTO `promotions_b2b_segments` (`id`, `min`, `max`, `discount_type`, `discount`, `iterator`, `promotion_id`, `created_at`, `updated_at`, `override_range`) VALUES
(3, '0.50', '3.00', 2, '1.00', '3.00', 19, '2021-12-14 11:53:21', '2021-12-14 11:53:21', 0),
(4, '31.00', '80.00', 1, '4.00', '3.00', 19, '2021-12-14 11:53:21', '2021-12-14 11:53:21', 0),
(16, '1.00', '99999.00', 1, '30.00', '1.00', 21, '2021-12-14 17:58:36', '2021-12-14 17:58:36', 0),
(17, '1.00', '1.00', 1, '50.00', '1.00', 20, '2021-12-14 17:59:05', '2021-12-14 17:59:05', 0),
(18, '2.00', '9999.00', 2, '50.00', '1.00', 20, '2021-12-14 17:59:05', '2021-12-14 17:59:05', 0),
(20, '1.00', '1.00', 1, '500.00', '1.00', 22, '2021-12-14 18:08:34', '2021-12-14 18:08:34', 0),
(21, '2.00', '9.00', 1, '250.00', '1.00', 22, '2021-12-14 18:08:34', '2021-12-14 18:08:34', 0),
(22, '10.00', '24.00', 1, '500.00', '1.00', 22, '2021-12-14 18:08:34', '2021-12-14 18:08:34', 0),
(81, '0.50', NULL, 2, '500.00', '1.00', 31, '2021-12-16 15:10:47', '2021-12-16 15:10:47', 0),
(208, '1.00', '1.00', 1, '500.00', '1.00', 26, '2021-12-27 11:43:58', '2021-12-27 11:43:58', 0),
(209, '2.00', '5.00', 1, '250.00', '1.00', 26, '2021-12-27 11:43:58', '2021-12-27 11:43:58', 0),
(210, '6.00', '8.00', 1, '500.00', '1.00', 26, '2021-12-27 11:43:58', '2021-12-27 11:43:58', 1),
(211, '9.00', '12.00', 2, '250.00', '1.00', 26, '2021-12-27 11:43:58', '2021-12-27 11:43:58', 1),
(212, '13.00', NULL, 1, '500.00', '1.00', 26, '2021-12-27 11:43:58', '2021-12-27 11:43:58', 0),
(231, '1.00', '3.00', 1, '1000.00', '1.00', 32, '2021-12-28 10:53:07', '2021-12-28 10:53:07', 0),
(232, '4.00', '8.00', 2, '1500.00', '1.00', 32, '2021-12-28 10:53:07', '2021-12-28 10:53:07', 1),
(233, '9.00', '99999.00', 1, '150.00', '1.00', 32, '2021-12-28 10:53:07', '2021-12-28 10:53:07', 0),
(307, '0.50', '10.00', 1, '250.00', '0.50', 39, '2021-12-28 16:09:49', '2021-12-28 16:09:49', 0),
(308, '11.00', '24.00', 2, '2500.00', '1.00', 39, '2021-12-28 16:09:49', '2021-12-28 16:09:49', 1),
(309, '25.00', '49.00', 1, '10.00', '1.00', 39, '2021-12-28 16:09:49', '2021-12-28 16:09:49', 0),
(310, '50.00', '99.00', 1, '14.00', '1.00', 39, '2021-12-28 16:09:49', '2021-12-28 16:09:49', 0),
(311, '100.00', '99999.00', 1, '0.00', '1.00', 39, '2021-12-28 16:09:49', '2021-12-28 16:09:49', 0),
(425, '1.00', '5.00', 1, '5.00', '1.00', 40, '2022-01-02 14:34:38', '2022-01-02 14:34:38', 0),
(426, '6.00', '10.00', 1, '10.00', '1.00', 40, '2022-01-02 14:34:38', '2022-01-02 14:34:38', 0),
(427, '11.00', '20.00', 1, '15.00', '1.00', 40, '2022-01-02 14:34:38', '2022-01-02 14:34:38', 0),
(430, '1.00', '1.00', 1, '50.00', '1.00', 41, '2022-01-02 15:22:59', '2022-01-02 15:22:59', 0),
(431, '2.00', '99999.00', 2, '5.00', '1.00', 41, '2022-01-02 15:22:59', '2022-01-02 15:22:59', 0),
(457, '25.00', '50.00', 1, '750.00', '1.00', 47, '2022-01-02 16:37:44', '2022-01-02 16:37:44', 0),
(471, '0.50', '5.00', 1, '250.00', '0.50', 46, '2022-01-04 11:57:45', '2022-01-04 11:57:45', 0),
(472, '6.00', '10.00', 1, '500.00', '1.00', 46, '2022-01-04 11:57:45', '2022-01-04 11:57:45', 0),
(473, '11.00', '14.00', 1, '0.00', '1.00', 46, '2022-01-04 11:57:45', '2022-01-04 11:57:45', 0),
(474, '15.00', '24.00', 1, '650.00', '1.00', 46, '2022-01-04 11:57:45', '2022-01-04 11:57:45', 0),
(479, '1.00', '99999.00', 1, '30.00', '1.00', 24, '2022-01-05 10:48:52', '2022-01-05 10:48:52', 0),
(480, '1.00', '1.00', 1, '500.00', '1.00', 29, '2022-01-05 10:50:39', '2022-01-05 10:50:39', 0),
(481, '2.00', '9.00', 1, '250.00', '1.00', 29, '2022-01-05 10:50:39', '2022-01-05 10:50:39', 0),
(482, '10.00', '24.00', 1, '500.00', '1.00', 29, '2022-01-05 10:50:39', '2022-01-05 10:50:39', 0),
(483, '25.00', '49.00', 2, '250.00', '1.00', 29, '2022-01-05 10:50:39', '2022-01-05 10:50:39', 0),
(484, '50.00', '9999.00', 1, '700.00', '1.00', 29, '2022-01-05 10:50:39', '2022-01-05 10:50:39', 0),
(535, '0.50', '1.00', 1, '10.00', '0.50', 72, '2022-01-08 14:15:10', '2022-01-08 14:15:10', 0),
(610, '1.00', '10.00', 1, '250.00', '1.00', 59, '2022-01-10 13:55:14', '2022-01-10 13:55:14', 0),
(611, '11.00', '24.00', 1, '0.00', '1.00', 59, '2022-01-10 13:55:14', '2022-01-10 13:55:14', 1),
(612, '25.00', '49.00', 1, '10.00', '1.00', 59, '2022-01-10 13:55:14', '2022-01-10 13:55:14', 1),
(613, '50.00', '99.00', 1, '14.00', '1.00', 59, '2022-01-10 13:55:14', '2022-01-10 13:55:14', 0),
(643, '25.00', '50.00', 1, '750.00', '1.00', 61, '2022-04-05 19:49:31', '2022-04-05 19:49:31', 1),
(644, '25.00', '50.00', 1, '750.00', '1.00', 60, '2022-04-05 19:50:09', '2022-04-05 19:50:09', 1),
(645, '25.00', '50.00', 1, '750.00', '1.00', 58, '2022-04-05 19:50:50', '2022-04-05 19:50:50', 1),
(657, '0.50', '10.00', 1, '25.00', '0.50', 56, '2022-06-12 14:26:21', '2022-06-12 14:26:21', 0),
(658, '1.00', NULL, 1, '200.00', '1.00', 57, '2022-06-12 14:26:27', '2022-06-12 14:26:27', 0),
(680, '1.00', '4.00', 1, '300.00', '1.00', 93, '2022-06-14 16:47:19', '2022-06-14 16:47:19', 0),
(693, '3.00', '5.00', 1, '50.00', '1.00', 23, '2022-06-19 15:02:05', '2022-06-19 15:02:05', 0),
(694, '6.00', '99999.00', 1, '10.00', '1.00', 23, '2022-06-19 15:02:05', '2022-06-19 15:02:05', 1),
(695, '1.00', '5.00', 1, '400.00', '1.00', 95, '2022-06-19 15:27:32', '2022-06-19 15:27:32', 0),
(696, '6.00', '10.00', 2, '500.00', '1.00', 95, '2022-06-19 15:27:32', '2022-06-19 15:27:32', 1),
(697, '11.00', '14.00', 2, '0.00', '1.00', 95, '2022-06-19 15:27:32', '2022-06-19 15:27:32', 0),
(698, '15.00', '24.00', 1, '650.00', '1.00', 95, '2022-06-19 15:27:32', '2022-06-19 15:27:32', 0),
(700, '1.00', '5.00', 1, '25.00', '1.00', 77, '2022-06-19 16:12:01', '2022-06-19 16:12:01', 0),
(706, '0.50', '1.00', 1, '125.00', '0.50', 97, '2022-06-22 16:30:32', '2022-06-22 16:30:32', 0),
(707, '1.00', '9.00', 1, '250.00', '1.00', 97, '2022-06-22 16:30:32', '2022-06-22 16:30:32', 1),
(708, '0.50', '0.50', 1, '265.00', '0.50', 99, '2022-06-26 12:41:00', '2022-06-26 12:41:00', 0),
(710, '1.00', '99999.00', 1, '300.00', '1.00', 102, '2022-06-26 13:22:54', '2022-06-26 13:22:54', 0),
(711, '12.00', '99999.00', 1, '100.00', '12.00', 103, '2022-06-26 13:25:27', '2022-06-26 13:25:27', 0),
(716, '1.00', '9999.00', 1, '500.00', '1.00', 101, '2022-06-26 17:51:44', '2022-06-26 17:51:44', 0),
(717, '12.00', '99999.00', 1, '232.46', '12.00', 106, '2022-06-28 18:09:09', '2022-06-28 18:09:09', 0),
(725, '1.00', '99999.00', 1, '300.00', '1.00', 104, '2022-07-17 16:42:00', '2022-07-17 16:42:00', 0),
(730, '1.00', '99999.00', 1, '20.00', '1.00', 105, '2022-07-18 12:46:41', '2022-07-18 12:46:41', 0),
(764, '1.00', '99999.00', 1, '20.00', '1.00', 112, '2022-07-20 10:22:42', '2022-07-20 10:22:42', 0),
(765, '1.00', '99999.00', 1, '20.00', '1.00', 111, '2022-07-20 10:23:49', '2022-07-20 10:23:49', 0),
(770, '1.00', '99999.00', 1, '20.00', '1.00', 110, '2022-07-24 10:50:30', '2022-07-24 10:50:30', 0),
(772, '1.00', '99999.00', 1, '20.00', '1.00', 109, '2022-08-01 10:06:52', '2022-08-01 10:06:52', 0),
(775, '1.00', '9999.00', 1, '20.00', '1.00', 113, '2022-08-02 12:41:34', '2022-08-02 12:41:34', 0),
(777, '1.00', '99999.00', 1, '20.00', '1.00', 115, '2022-08-02 12:44:44', '2022-08-02 12:44:44', 0),
(778, '0.50', '0.50', 1, '125.00', '0.50', 114, '2022-08-04 09:24:33', '2022-08-04 09:24:33', 0),
(779, '1.00', '99999.00', 1, '270.00', '1.00', 114, '2022-08-04 09:24:33', '2022-08-04 09:24:33', 1),
(780, '12.00', '12.00', 1, '1.00', '1.00', 117, '2022-11-03 11:37:14', '2022-11-03 11:37:14', 0),
(782, '1.00', '1.00', 1, '5000.00', '1.00', 118, '2022-11-03 12:16:12', '2022-11-03 12:16:12', 0);

-- --------------------------------------------------------

--
-- Table structure for table `promotion_conditions`
--

CREATE TABLE `promotion_conditions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `item_type` tinyint(4) NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `quantity` decimal(8,2) DEFAULT NULL,
  `operator` tinyint(4) NOT NULL DEFAULT 0,
  `promotion_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `promotion_conditions`
--

INSERT INTO `promotion_conditions` (`id`, `item_type`, `item_id`, `amount`, `quantity`, `operator`, `promotion_id`, `created_at`, `updated_at`) VALUES
(7, 1, 78, NULL, '2.00', 0, 18, '2021-11-21 14:07:23', '2021-11-21 14:07:23'),
(10, 1, 78, NULL, NULL, 0, 19, '2021-12-14 11:53:21', '2021-12-14 11:53:21'),
(29, 1, 80, NULL, NULL, 0, 21, '2021-12-14 17:58:36', '2021-12-14 17:58:36'),
(30, 1, 79, NULL, NULL, 0, 20, '2021-12-14 17:59:05', '2021-12-14 17:59:05'),
(31, 1, 80, NULL, NULL, 0, 20, '2021-12-14 17:59:05', '2021-12-14 17:59:05'),
(33, 1, 80, NULL, NULL, 0, 22, '2021-12-14 18:08:34', '2021-12-14 18:08:34'),
(62, 2, NULL, NULL, '1.00', 0, 25, '2021-12-16 13:54:33', '2021-12-16 13:54:33'),
(69, 1, 82, NULL, '1.00', 0, 28, '2021-12-16 14:26:38', '2021-12-16 14:26:38'),
(70, 1, 82, NULL, '1.00', 0, 27, '2021-12-16 14:27:06', '2021-12-16 14:27:06'),
(79, 1, 85, NULL, '1.00', 0, 30, '2021-12-16 15:02:01', '2021-12-16 15:02:01'),
(80, 2, NULL, NULL, '4.00', 0, 30, '2021-12-16 15:02:01', '2021-12-16 15:02:01'),
(81, 1, 82, NULL, NULL, 0, 31, '2021-12-16 15:10:47', '2021-12-16 15:10:47'),
(87, 2, NULL, NULL, '48.00', 0, 34, '2021-12-20 16:08:01', '2021-12-20 16:08:01'),
(89, 2, NULL, NULL, '1.00', 0, 33, '2021-12-20 16:18:21', '2021-12-20 16:18:21'),
(96, 2, NULL, NULL, '84.00', 0, 35, '2021-12-23 16:45:34', '2021-12-23 16:45:34'),
(136, 1, 82, NULL, NULL, 0, 26, '2021-12-27 11:43:58', '2021-12-27 11:43:58'),
(164, 2, NULL, NULL, '1.00', 1, 36, '2021-12-27 14:56:04', '2021-12-27 14:56:04'),
(301, 1, 86, NULL, NULL, 0, 32, '2021-12-28 10:53:07', '2021-12-28 10:53:07'),
(321, 1, 87, NULL, '1.00', 1, 37, '2021-12-28 12:38:05', '2021-12-28 12:38:05'),
(322, 1, 87, NULL, '2.00', 1, 38, '2021-12-28 12:39:45', '2021-12-28 12:39:45'),
(343, 1, 82, NULL, NULL, 0, 39, '2021-12-28 16:09:49', '2021-12-28 16:09:49'),
(359, 2, NULL, NULL, '1.00', 1, 42, '2021-12-28 16:38:42', '2021-12-28 16:38:42'),
(361, 2, NULL, NULL, '7.00', 1, 44, '2021-12-28 16:38:57', '2021-12-28 16:38:57'),
(362, 2, NULL, NULL, '4.00', 1, 43, '2021-12-28 16:44:13', '2021-12-28 16:44:13'),
(430, 1, 81, NULL, '1.00', 0, 45, '2021-12-28 17:31:55', '2021-12-28 17:31:55'),
(431, 1, 83, NULL, '1.00', 1, 45, '2021-12-28 17:31:55', '2021-12-28 17:31:55'),
(432, 1, 82, NULL, '1.00', 1, 45, '2021-12-28 17:31:55', '2021-12-28 17:31:55'),
(433, 1, 84, NULL, '2.00', 1, 45, '2021-12-28 17:31:55', '2021-12-28 17:31:55'),
(472, 1, 87, NULL, NULL, 0, 40, '2022-01-02 14:34:38', '2022-01-02 14:34:38'),
(474, 1, 82, NULL, NULL, 0, 41, '2022-01-02 15:22:59', '2022-01-02 15:22:59'),
(482, 1, 82, NULL, NULL, 0, 47, '2022-01-02 16:37:44', '2022-01-02 16:37:44'),
(488, 1, 84, NULL, '1.00', 1, 48, '2022-01-03 14:07:24', '2022-01-03 14:07:24'),
(489, 1, 87, NULL, NULL, 0, 46, '2022-01-04 11:57:45', '2022-01-04 11:57:45'),
(498, 2, NULL, NULL, '7.00', 1, 52, '2022-01-04 13:45:12', '2022-01-04 13:45:12'),
(499, 2, NULL, NULL, '11.00', 1, 51, '2022-01-04 13:45:49', '2022-01-04 13:45:49'),
(500, 2, NULL, NULL, '15.00', 1, 50, '2022-01-04 13:46:29', '2022-01-04 13:46:29'),
(501, 2, NULL, NULL, '20.00', 1, 49, '2022-01-04 13:48:02', '2022-01-04 13:48:02'),
(502, 2, NULL, NULL, '4.00', 1, 54, '2022-01-04 15:55:01', '2022-01-04 15:55:01'),
(503, 2, NULL, NULL, '1.00', 1, 54, '2022-01-04 15:55:01', '2022-01-04 15:55:01'),
(504, 2, NULL, NULL, '1.00', 1, 54, '2022-01-04 15:55:01', '2022-01-04 15:55:01'),
(505, 2, NULL, NULL, '1.00', 1, 54, '2022-01-04 15:55:01', '2022-01-04 15:55:01'),
(506, 2, NULL, NULL, '8.00', 1, 55, '2022-01-04 16:20:38', '2022-01-04 16:20:38'),
(507, 2, NULL, NULL, '2.00', 1, 55, '2022-01-04 16:20:38', '2022-01-04 16:20:38'),
(508, 2, NULL, NULL, '2.00', 1, 55, '2022-01-04 16:20:38', '2022-01-04 16:20:38'),
(509, 2, NULL, NULL, '2.00', 1, 55, '2022-01-04 16:20:38', '2022-01-04 16:20:38'),
(510, 2, NULL, NULL, '4.00', 1, 53, '2022-01-05 10:33:52', '2022-01-05 10:33:52'),
(513, 1, 81, NULL, NULL, 0, 24, '2022-01-05 10:48:52', '2022-01-05 10:48:52'),
(514, 1, 82, NULL, NULL, 0, 29, '2022-01-05 10:50:39', '2022-01-05 10:50:39'),
(526, 1, 78, 100, '10.00', 1, 62, '2022-01-05 13:03:13', '2022-01-05 13:03:13'),
(530, 1, 78, 1200, '10.00', 1, 63, '2022-01-05 13:12:21', '2022-01-05 13:12:21'),
(536, 1, 78, NULL, '1.00', 1, 64, '2022-01-05 13:40:00', '2022-01-05 13:40:00'),
(542, 2, NULL, NULL, '11.00', 1, 67, '2022-01-05 14:11:00', '2022-01-05 14:11:00'),
(543, 2, NULL, NULL, '15.00', 1, 68, '2022-01-05 14:13:23', '2022-01-05 14:13:23'),
(544, 2, NULL, NULL, '20.00', 1, 69, '2022-01-05 14:16:00', '2022-01-05 14:16:00'),
(572, 2, NULL, NULL, '7.00', 1, 66, '2022-01-08 13:08:18', '2022-01-08 13:08:18'),
(578, 1, 82, NULL, NULL, 0, 72, '2022-01-08 14:15:10', '2022-01-08 14:15:10'),
(631, 2, NULL, NULL, '4.00', 1, 65, '2022-01-09 16:29:10', '2022-01-09 16:29:10'),
(645, 1, 81, NULL, NULL, 0, 59, '2022-01-10 13:55:14', '2022-01-10 13:55:14'),
(651, 1, 87, NULL, '1.00', 1, 76, '2022-01-10 17:49:29', '2022-01-10 17:49:29'),
(652, 2, NULL, NULL, '1.00', 1, 70, '2022-01-11 11:09:51', '2022-01-11 11:09:51'),
(717, 1, 87, NULL, '1.00', 1, 89, '2022-01-11 15:46:04', '2022-01-11 15:46:04'),
(718, 2, NULL, NULL, '36.00', 1, 89, '2022-01-11 15:46:04', '2022-01-11 15:46:04'),
(719, 2, NULL, NULL, '36.00', 1, 89, '2022-01-11 15:46:04', '2022-01-11 15:46:04'),
(722, 1, 87, NULL, '1.00', 1, 87, '2022-01-11 15:46:44', '2022-01-11 15:46:44'),
(723, 2, NULL, NULL, '72.00', 1, 87, '2022-01-11 15:46:44', '2022-01-11 15:46:44'),
(727, 1, 87, NULL, '1.00', 1, 85, '2022-01-11 15:47:13', '2022-01-11 15:47:13'),
(728, 2, NULL, NULL, '24.00', 1, 85, '2022-01-11 15:47:13', '2022-01-11 15:47:13'),
(729, 1, 87, NULL, '1.00', 1, 84, '2022-01-11 15:47:23', '2022-01-11 15:47:23'),
(730, 2, NULL, NULL, '24.00', 1, 84, '2022-01-11 15:47:23', '2022-01-11 15:47:23'),
(731, 1, 87, NULL, '1.00', 1, 83, '2022-01-11 15:47:46', '2022-01-11 15:47:46'),
(732, 2, NULL, NULL, '6.00', 1, 83, '2022-01-11 15:47:46', '2022-01-11 15:47:46'),
(733, 2, NULL, NULL, '6.00', 1, 83, '2022-01-11 15:47:46', '2022-01-11 15:47:46'),
(734, 1, 87, NULL, '1.00', 1, 82, '2022-01-11 15:48:09', '2022-01-11 15:48:09'),
(735, 2, NULL, NULL, '12.00', 1, 82, '2022-01-11 15:48:09', '2022-01-11 15:48:09'),
(736, 1, 87, NULL, '1.00', 1, 81, '2022-01-11 15:48:35', '2022-01-11 15:48:35'),
(737, 2, NULL, NULL, '12.00', 1, 81, '2022-01-11 15:48:35', '2022-01-11 15:48:35'),
(741, 1, 87, NULL, '1.00', 1, 78, '2022-01-11 15:48:58', '2022-01-11 15:48:58'),
(742, 2, NULL, NULL, '10.00', 1, 78, '2022-01-11 15:48:58', '2022-01-11 15:48:58'),
(750, 1, 87, NULL, '1.00', 1, 73, '2022-01-11 15:57:07', '2022-01-11 15:57:07'),
(751, 2, NULL, NULL, '2.00', 1, 73, '2022-01-11 15:57:07', '2022-01-11 15:57:07'),
(755, 1, 87, NULL, '1.00', 1, 74, '2022-01-11 16:04:40', '2022-01-11 16:04:40'),
(756, 2, NULL, NULL, '2.00', 1, 74, '2022-01-11 16:04:40', '2022-01-11 16:04:40'),
(757, 1, 87, NULL, '1.00', 1, 75, '2022-01-11 16:10:04', '2022-01-11 16:10:04'),
(758, 2, NULL, NULL, '1.00', 1, 75, '2022-01-11 16:10:04', '2022-01-11 16:10:04'),
(759, 2, NULL, NULL, '1.00', 1, 75, '2022-01-11 16:10:04', '2022-01-11 16:10:04'),
(764, 1, 87, NULL, '1.00', 1, 86, '2022-01-12 11:43:10', '2022-01-12 11:43:10'),
(765, 2, NULL, NULL, '12.00', 1, 86, '2022-01-12 11:43:10', '2022-01-12 11:43:10'),
(766, 2, NULL, NULL, '12.00', 1, 86, '2022-01-12 11:43:10', '2022-01-12 11:43:10'),
(768, 1, 87, NULL, '1.00', 1, 79, '2022-01-12 13:23:31', '2022-01-12 13:23:31'),
(769, 2, NULL, NULL, '10.00', 1, 79, '2022-01-12 13:23:31', '2022-01-12 13:23:31'),
(770, 1, 87, NULL, '1.00', 1, 80, '2022-01-12 13:24:36', '2022-01-12 13:24:36'),
(771, 2, NULL, NULL, '5.00', 1, 80, '2022-01-12 13:24:36', '2022-01-12 13:24:36'),
(772, 2, NULL, NULL, '5.00', 1, 80, '2022-01-12 13:24:36', '2022-01-12 13:24:36'),
(773, 1, 81, NULL, '1.00', 0, 71, '2022-01-12 17:02:00', '2022-01-12 17:02:00'),
(774, 1, 82, NULL, '1.00', 0, 71, '2022-01-12 17:02:00', '2022-01-12 17:02:00'),
(775, 1, 83, NULL, '1.00', 0, 71, '2022-01-12 17:02:00', '2022-01-12 17:02:00'),
(776, 1, 84, NULL, '4.00', 1, 71, '2022-01-12 17:02:00', '2022-01-12 17:02:00'),
(778, 1, 81, NULL, '5.00', 1, 90, '2022-01-12 17:11:38', '2022-01-12 17:11:38'),
(848, 1, 87, NULL, '1.00', 1, 88, '2022-03-28 16:21:12', '2022-03-28 16:21:12'),
(855, 1, 81, NULL, '2.00', 1, 91, '2022-04-05 12:13:45', '2022-04-05 12:13:45'),
(857, 1, 82, NULL, NULL, 0, 61, '2022-04-05 19:49:31', '2022-04-05 19:49:31'),
(858, 1, 82, NULL, NULL, 0, 60, '2022-04-05 19:50:09', '2022-04-05 19:50:09'),
(859, 1, 82, NULL, NULL, 0, 58, '2022-04-05 19:50:50', '2022-04-05 19:50:50'),
(871, 1, 82, NULL, NULL, 0, 56, '2022-06-12 14:26:21', '2022-06-12 14:26:21'),
(872, 1, 81, NULL, NULL, 0, 57, '2022-06-12 14:26:27', '2022-06-12 14:26:27'),
(892, 1, 81, NULL, '1.00', 1, 92, '2022-06-13 12:02:34', '2022-06-13 12:02:34'),
(896, 2, NULL, NULL, '3.00', 1, 94, '2022-06-13 15:31:02', '2022-06-13 15:31:02'),
(897, 1, 81, NULL, NULL, 0, 93, '2022-06-14 16:47:19', '2022-06-14 16:47:19'),
(904, 1, 82, NULL, NULL, 0, 23, '2022-06-19 15:02:05', '2022-06-19 15:02:05'),
(905, 1, 87, NULL, NULL, 0, 95, '2022-06-19 15:27:32', '2022-06-19 15:27:32'),
(907, 1, 81, NULL, NULL, 0, 77, '2022-06-19 16:12:01', '2022-06-19 16:12:01'),
(912, 2, NULL, NULL, '1.00', 1, 96, '2022-06-20 12:27:01', '2022-06-20 12:27:01'),
(913, 2, NULL, NULL, '1.00', 1, 96, '2022-06-20 12:27:01', '2022-06-20 12:27:01'),
(914, 2, NULL, NULL, '1.00', 1, 96, '2022-06-20 12:27:01', '2022-06-20 12:27:01'),
(920, 1, 81, NULL, NULL, 0, 97, '2022-06-22 16:30:32', '2022-06-22 16:30:32'),
(922, 2, NULL, NULL, '1.00', 1, 98, '2022-06-26 09:04:59', '2022-06-26 09:04:59'),
(923, 1, 81, NULL, NULL, 0, 99, '2022-06-26 12:41:00', '2022-06-26 12:41:00'),
(931, 1, 98, NULL, NULL, 0, 102, '2022-06-26 13:22:54', '2022-06-26 13:22:54'),
(932, 1, 99, NULL, NULL, 0, 103, '2022-06-26 13:25:27', '2022-06-26 13:25:27'),
(942, 1, 97, NULL, NULL, 0, 101, '2022-06-26 17:51:44', '2022-06-26 17:51:44'),
(943, 1, 84, NULL, NULL, 0, 106, '2022-06-28 18:09:09', '2022-06-28 18:09:09'),
(949, 2, NULL, NULL, '0.50', 1, 100, '2022-06-29 11:27:49', '2022-06-29 11:27:49'),
(968, 1, 82, NULL, NULL, 0, 104, '2022-07-17 16:42:00', '2022-07-17 16:42:00'),
(972, 1, 100, NULL, '2.00', 1, 108, '2022-07-18 11:45:05', '2022-07-18 11:45:05'),
(975, 1, 101, NULL, NULL, 0, 105, '2022-07-18 12:46:41', '2022-07-18 12:46:41'),
(976, 2, NULL, NULL, '12.00', 1, 107, '2022-07-19 10:50:02', '2022-07-19 10:50:02'),
(1000, 1, 88, NULL, NULL, 0, 112, '2022-07-20 10:22:42', '2022-07-20 10:22:42'),
(1001, 1, 82, NULL, NULL, 0, 111, '2022-07-20 10:23:49', '2022-07-20 10:23:49'),
(1004, 1, 83, NULL, NULL, 0, 110, '2022-07-24 10:50:30', '2022-07-24 10:50:30'),
(1006, 1, 98, NULL, NULL, 0, 109, '2022-08-01 10:06:52', '2022-08-01 10:06:52'),
(1009, 1, 87, NULL, NULL, 0, 113, '2022-08-02 12:41:34', '2022-08-02 12:41:34'),
(1011, 1, 83, NULL, NULL, 0, 115, '2022-08-02 12:44:44', '2022-08-02 12:44:44'),
(1018, 1, 98, NULL, '0.50', 1, 116, '2022-08-02 13:19:38', '2022-08-02 13:19:38'),
(1019, 1, 82, NULL, NULL, 0, 114, '2022-08-04 09:24:33', '2022-08-04 09:24:33'),
(1020, 1, 81, NULL, NULL, 0, 117, '2022-11-03 11:37:14', '2022-11-03 11:37:14'),
(1022, 1, 81, NULL, NULL, 0, 118, '2022-11-03 12:16:12', '2022-11-03 12:16:12');

-- --------------------------------------------------------

--
-- Table structure for table `promotion_conditions_custom_lists`
--

CREATE TABLE `promotion_conditions_custom_lists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `item_id` int(11) NOT NULL,
  `condition_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `promotion_conditions_custom_lists`
--

INSERT INTO `promotion_conditions_custom_lists` (`id`, `item_id`, `condition_id`, `created_at`, `updated_at`) VALUES
(4, 90406, 62, '2021-12-16 13:54:33', '2021-12-16 13:54:33'),
(6, 90406, 80, '2021-12-16 15:02:01', '2021-12-16 15:02:01'),
(9, 90406, 87, '2021-12-20 16:08:01', '2021-12-20 16:08:01'),
(11, 90406, 89, '2021-12-20 16:18:21', '2021-12-20 16:18:21'),
(15, 90406, 96, '2021-12-23 16:45:34', '2021-12-23 16:45:34'),
(26, 90410, 164, '2021-12-27 14:56:04', '2021-12-27 14:56:04'),
(90, 90406, 359, '2021-12-28 16:38:42', '2021-12-28 16:38:42'),
(92, 90406, 361, '2021-12-28 16:38:57', '2021-12-28 16:38:57'),
(93, 90406, 362, '2021-12-28 16:44:13', '2021-12-28 16:44:13'),
(99, 90406, 498, '2022-01-04 13:45:12', '2022-01-04 13:45:12'),
(100, 90406, 499, '2022-01-04 13:45:49', '2022-01-04 13:45:49'),
(101, 90406, 500, '2022-01-04 13:46:29', '2022-01-04 13:46:29'),
(102, 90406, 501, '2022-01-04 13:48:02', '2022-01-04 13:48:02'),
(103, 90406, 502, '2022-01-04 15:55:01', '2022-01-04 15:55:01'),
(104, 90398, 503, '2022-01-04 15:55:01', '2022-01-04 15:55:01'),
(105, 90400, 503, '2022-01-04 15:55:01', '2022-01-04 15:55:01'),
(106, 90404, 504, '2022-01-04 15:55:01', '2022-01-04 15:55:01'),
(107, 90392, 504, '2022-01-04 15:55:01', '2022-01-04 15:55:01'),
(108, 90394, 504, '2022-01-04 15:55:01', '2022-01-04 15:55:01'),
(109, 90396, 504, '2022-01-04 15:55:01', '2022-01-04 15:55:01'),
(110, 90412, 505, '2022-01-04 15:55:01', '2022-01-04 15:55:01'),
(111, 90410, 505, '2022-01-04 15:55:01', '2022-01-04 15:55:01'),
(112, 90402, 505, '2022-01-04 15:55:01', '2022-01-04 15:55:01'),
(113, 90406, 506, '2022-01-04 16:20:38', '2022-01-04 16:20:38'),
(114, 90408, 506, '2022-01-04 16:20:38', '2022-01-04 16:20:38'),
(115, 90398, 507, '2022-01-04 16:20:38', '2022-01-04 16:20:38'),
(116, 90400, 507, '2022-01-04 16:20:38', '2022-01-04 16:20:38'),
(117, 90404, 508, '2022-01-04 16:20:38', '2022-01-04 16:20:38'),
(118, 90392, 508, '2022-01-04 16:20:38', '2022-01-04 16:20:38'),
(119, 90394, 508, '2022-01-04 16:20:38', '2022-01-04 16:20:38'),
(120, 90396, 508, '2022-01-04 16:20:38', '2022-01-04 16:20:38'),
(121, 90412, 509, '2022-01-04 16:20:38', '2022-01-04 16:20:38'),
(122, 90410, 509, '2022-01-04 16:20:38', '2022-01-04 16:20:38'),
(123, 90402, 509, '2022-01-04 16:20:38', '2022-01-04 16:20:38'),
(124, 90406, 510, '2022-01-05 10:33:52', '2022-01-05 10:33:52'),
(128, 90406, 542, '2022-01-05 14:11:00', '2022-01-05 14:11:00'),
(129, 90406, 543, '2022-01-05 14:13:23', '2022-01-05 14:13:23'),
(130, 90406, 544, '2022-01-05 14:16:00', '2022-01-05 14:16:00'),
(141, 90406, 572, '2022-01-08 13:08:18', '2022-01-08 13:08:18'),
(149, 90406, 631, '2022-01-09 16:29:10', '2022-01-09 16:29:10'),
(151, 90406, 652, '2022-01-11 11:09:51', '2022-01-11 11:09:51'),
(187, 90406, 718, '2022-01-11 15:46:04', '2022-01-11 15:46:04'),
(188, 90408, 719, '2022-01-11 15:46:04', '2022-01-11 15:46:04'),
(190, 90406, 723, '2022-01-11 15:46:44', '2022-01-11 15:46:44'),
(193, 90408, 728, '2022-01-11 15:47:13', '2022-01-11 15:47:13'),
(194, 90406, 730, '2022-01-11 15:47:23', '2022-01-11 15:47:23'),
(195, 90408, 732, '2022-01-11 15:47:46', '2022-01-11 15:47:46'),
(196, 90406, 733, '2022-01-11 15:47:46', '2022-01-11 15:47:46'),
(197, 90408, 735, '2022-01-11 15:48:09', '2022-01-11 15:48:09'),
(198, 90406, 737, '2022-01-11 15:48:35', '2022-01-11 15:48:35'),
(201, 90406, 742, '2022-01-11 15:48:58', '2022-01-11 15:48:58'),
(206, 90406, 751, '2022-01-11 15:57:07', '2022-01-11 15:57:07'),
(209, 90408, 756, '2022-01-11 16:04:40', '2022-01-11 16:04:40'),
(210, 90406, 758, '2022-01-11 16:10:04', '2022-01-11 16:10:04'),
(211, 90408, 759, '2022-01-11 16:10:04', '2022-01-11 16:10:04'),
(212, 90408, 765, '2022-01-12 11:43:10', '2022-01-12 11:43:10'),
(213, 90406, 766, '2022-01-12 11:43:10', '2022-01-12 11:43:10'),
(214, 90408, 769, '2022-01-12 13:23:31', '2022-01-12 13:23:31'),
(215, 90408, 771, '2022-01-12 13:24:36', '2022-01-12 13:24:36'),
(216, 90406, 772, '2022-01-12 13:24:36', '2022-01-12 13:24:36'),
(217, 174, 896, '2022-06-13 15:31:02', '2022-06-13 15:31:02'),
(218, 166, 896, '2022-06-13 15:31:02', '2022-06-13 15:31:02'),
(219, 168, 896, '2022-06-13 15:31:02', '2022-06-13 15:31:02'),
(220, 8, 896, '2022-06-13 15:31:02', '2022-06-13 15:31:02'),
(221, 10, 896, '2022-06-13 15:31:02', '2022-06-13 15:31:02'),
(222, 168, 912, '2022-06-20 12:27:01', '2022-06-20 12:27:01'),
(223, 174, 912, '2022-06-20 12:27:01', '2022-06-20 12:27:01'),
(224, 166, 912, '2022-06-20 12:27:01', '2022-06-20 12:27:01'),
(225, 188, 913, '2022-06-20 12:27:01', '2022-06-20 12:27:01'),
(226, 190, 913, '2022-06-20 12:27:01', '2022-06-20 12:27:01'),
(227, 22, 913, '2022-06-20 12:27:01', '2022-06-20 12:27:01'),
(228, 8, 914, '2022-06-20 12:27:01', '2022-06-20 12:27:01'),
(229, 10, 914, '2022-06-20 12:27:01', '2022-06-20 12:27:01'),
(233, 48, 922, '2022-06-26 09:04:59', '2022-06-26 09:04:59'),
(274, 168, 949, '2022-06-29 11:27:49', '2022-06-29 11:27:49'),
(275, 174, 949, '2022-06-29 11:27:49', '2022-06-29 11:27:49'),
(276, 166, 949, '2022-06-29 11:27:49', '2022-06-29 11:27:49'),
(280, 48, 976, '2022-07-19 10:50:02', '2022-07-19 10:50:02');

-- --------------------------------------------------------

--
-- Table structure for table `promotion_groups`
--

CREATE TABLE `promotion_groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `promotion_groups`
--

INSERT INTO `promotion_groups` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Group A', '2022-01-10 17:04:06', '2022-01-10 17:04:06'),
(2, 'Group B', '2022-01-10 17:04:06', '2022-01-10 17:04:06'),
(3, 'Group C', '2022-01-10 17:04:06', '2022-01-10 17:04:06');

-- --------------------------------------------------------

--
-- Table structure for table `promotion_targets`
--

CREATE TABLE `promotion_targets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `item_type` tinyint(4) NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `promotion_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `quantity` decimal(8,2) NOT NULL,
  `operator` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `promotion_targets`
--

INSERT INTO `promotion_targets` (`id`, `item_type`, `item_id`, `promotion_id`, `created_at`, `updated_at`, `quantity`, `operator`) VALUES
(7, 1, 78, 18, '2021-11-21 14:07:23', '2021-11-21 14:07:23', '0.00', 0),
(11, 2, NULL, 25, '2021-12-16 13:54:33', '2021-12-16 13:54:33', '0.00', 0),
(18, 2, NULL, 28, '2021-12-16 14:26:38', '2021-12-16 14:26:38', '0.00', 0),
(19, 2, NULL, 27, '2021-12-16 14:27:06', '2021-12-16 14:27:06', '0.00', 0),
(21, 1, 81, 30, '2021-12-16 15:02:01', '2021-12-16 15:02:01', '0.00', 0),
(24, 2, NULL, 34, '2021-12-20 16:08:01', '2021-12-20 16:08:01', '0.00', 0),
(26, 2, NULL, 33, '2021-12-20 16:18:21', '2021-12-20 16:18:21', '0.00', 0),
(31, 2, 90408, 35, '2021-12-23 16:45:34', '2021-12-23 16:45:34', '2.00', 0),
(64, 2, 90400, 36, '2021-12-27 14:56:04', '2021-12-27 14:56:04', '2.00', 0),
(65, 2, 90398, 36, '2021-12-27 14:56:04', '2021-12-27 14:56:04', '2.00', 0),
(66, 2, 90402, 36, '2021-12-27 14:56:04', '2021-12-27 14:56:04', '1.00', 0),
(116, 2, 90404, 37, '2021-12-28 12:38:05', '2021-12-28 12:38:05', '1.00', 0),
(117, 2, 90402, 37, '2021-12-28 12:38:05', '2021-12-28 12:38:05', '1.00', 0),
(118, 2, 90408, 37, '2021-12-28 12:38:05', '2021-12-28 12:38:05', '2.00', 1),
(119, 2, 90408, 38, '2021-12-28 12:39:45', '2021-12-28 12:39:45', '2.00', 1),
(120, 2, 90404, 38, '2021-12-28 12:39:45', '2021-12-28 12:39:45', '1.00', 0),
(121, 2, 90402, 38, '2021-12-28 12:39:45', '2021-12-28 12:39:45', '1.00', 0),
(125, 2, 90408, 42, '2021-12-28 16:38:42', '2021-12-28 16:38:42', '3.00', 1),
(127, 2, 90406, 44, '2021-12-28 16:38:57', '2021-12-28 16:38:57', '2.00', 1),
(128, 2, 90406, 43, '2021-12-28 16:44:13', '2021-12-28 16:44:13', '1.00', 1),
(137, 2, 90408, 52, '2022-01-04 13:45:12', '2022-01-04 13:45:12', '2.00', 1),
(138, 2, 90408, 51, '2022-01-04 13:45:49', '2022-01-04 13:45:49', '4.00', 1),
(139, 2, 90408, 50, '2022-01-04 13:46:29', '2022-01-04 13:46:29', '8.00', 1),
(140, 2, 90408, 49, '2022-01-04 13:48:02', '2022-01-04 13:48:02', '13.00', 1),
(141, 2, 90408, 53, '2022-01-05 10:33:52', '2022-01-05 10:33:52', '1.00', 1),
(145, 2, 90408, 67, '2022-01-05 14:11:00', '2022-01-05 14:11:00', '4.00', 1),
(146, 2, 90408, 68, '2022-01-05 14:13:23', '2022-01-05 14:13:23', '8.00', 1),
(147, 2, 90408, 69, '2022-01-05 14:16:00', '2022-01-05 14:16:00', '13.00', 1),
(158, 2, 90408, 66, '2022-01-08 13:08:18', '2022-01-08 13:08:18', '2.00', 1),
(161, 2, 90408, 65, '2022-01-09 16:29:10', '2022-01-09 16:29:10', '1.00', 1),
(163, 2, 90408, 70, '2022-01-11 11:09:51', '2022-01-11 11:09:51', '3.00', 1),
(164, 2, 48, 94, '2022-06-13 15:31:02', '2022-06-13 15:31:02', '1.00', 1),
(169, 2, 48, 96, '2022-06-20 12:27:01', '2022-06-20 12:27:01', '1.00', 1),
(172, 2, 48, 98, '2022-06-26 09:04:59', '2022-06-26 09:04:59', '1.00', 1),
(183, 2, 48, 100, '2022-06-29 11:27:49', '2022-06-29 11:27:49', '1.00', 1),
(195, 2, 48, 108, '2022-07-18 11:45:05', '2022-07-18 11:45:05', '1.00', 1),
(197, 2, 48, 107, '2022-07-19 10:50:02', '2022-07-19 10:50:02', '1.00', 1),
(204, 2, 48, 116, '2022-08-02 13:19:38', '2022-08-02 13:19:38', '1.00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `promotion_targets_custom_lists`
--

CREATE TABLE `promotion_targets_custom_lists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `item_id` int(11) NOT NULL,
  `target_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `promotion_targets_custom_lists`
--

INSERT INTO `promotion_targets_custom_lists` (`id`, `item_id`, `target_id`, `created_at`, `updated_at`) VALUES
(4, 90408, 11, '2021-12-16 13:54:33', '2021-12-16 13:54:33'),
(13, 90408, 18, '2021-12-16 14:26:38', '2021-12-16 14:26:38'),
(14, 90406, 19, '2021-12-16 14:27:06', '2021-12-16 14:27:06'),
(17, 90406, 24, '2021-12-20 16:08:01', '2021-12-20 16:08:01'),
(19, 90408, 26, '2021-12-20 16:18:21', '2021-12-20 16:18:21');

-- --------------------------------------------------------

--
-- Table structure for table `promotion_users`
--

CREATE TABLE `promotion_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `promotion_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `use_date` datetime NOT NULL,
  `valid_date` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `promotion_users`
--

INSERT INTO `promotion_users` (`id`, `promotion_id`, `user_id`, `order_id`, `use_date`, `valid_date`, `created_at`, `updated_at`) VALUES
(1, 70, 1017373, 4280, '2022-01-08 13:39:16', '2022-02-08 13:39:16', '2022-01-08 13:39:16', '2022-01-08 13:39:16'),
(2, 97, 1000003, 4, '2022-06-22 10:28:53', '2022-06-29 10:28:53', '2022-06-22 10:28:53', '2022-06-22 10:28:53'),
(3, 108, 1000003, 31, '2022-07-17 12:43:40', '2022-07-19 12:43:40', '2022-07-17 12:43:40', '2022-07-17 12:43:40');

-- --------------------------------------------------------

--
-- Table structure for table `promo_payment_method`
--

CREATE TABLE `promo_payment_method` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `promo_id` int(10) UNSIGNED NOT NULL,
  `payment_method_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `promo_payment_method`
--

INSERT INTO `promo_payment_method` (`id`, `promo_id`, `payment_method_id`, `created_at`, `updated_at`) VALUES
(11, 112, 1, NULL, NULL),
(12, 112, 2, NULL, NULL),
(13, 113, 1, NULL, NULL),
(14, 113, 2, NULL, NULL),
(15, 113, 3, NULL, NULL),
(16, 113, 5, NULL, NULL),
(17, 114, 1, NULL, NULL),
(18, 114, 2, NULL, NULL),
(19, 114, 3, NULL, NULL),
(20, 114, 5, NULL, NULL),
(21, 115, 1, NULL, NULL),
(22, 115, 2, NULL, NULL),
(23, 116, 1, NULL, NULL),
(24, 116, 2, NULL, NULL),
(25, 117, 1, NULL, NULL),
(26, 117, 2, NULL, NULL),
(27, 118, 1, NULL, NULL),
(28, 118, 2, NULL, NULL),
(29, 119, 1, NULL, NULL),
(30, 119, 2, NULL, NULL),
(31, 120, 1, NULL, NULL),
(32, 120, 2, NULL, NULL),
(33, 121, 1, NULL, NULL),
(34, 122, 1, NULL, NULL),
(35, 122, 2, NULL, NULL),
(36, 123, 1, NULL, NULL),
(37, 123, 2, NULL, NULL),
(38, 123, 3, NULL, NULL),
(39, 123, 5, NULL, NULL),
(41, 124, 2, NULL, NULL),
(44, 121, 2, NULL, NULL),
(45, 125, 1, NULL, NULL),
(46, 125, 2, NULL, NULL),
(47, 125, 3, NULL, NULL),
(48, 125, 5, NULL, NULL),
(49, 126, 1, NULL, NULL),
(50, 126, 2, NULL, NULL),
(51, 126, 3, NULL, NULL),
(52, 126, 5, NULL, NULL),
(53, 127, 1, NULL, NULL),
(54, 127, 2, NULL, NULL),
(55, 128, 1, NULL, NULL),
(56, 128, 2, NULL, NULL),
(57, 131, 1, NULL, NULL),
(58, 131, 3, NULL, NULL),
(59, 131, 2, NULL, NULL),
(60, 131, 5, NULL, NULL),
(61, 131, 6, NULL, NULL),
(62, 131, 9, NULL, NULL),
(63, 131, 10, NULL, NULL),
(64, 131, 11, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `promo_targets`
--

CREATE TABLE `promo_targets` (
  `promo_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `promo_targets`
--

INSERT INTO `promo_targets` (`promo_id`, `user_id`, `phone`, `id`, `created_at`, `updated_at`) VALUES
(130, 1017208, NULL, 5808, NULL, NULL),
(133, 1017240, NULL, 5809, NULL, NULL),
(134, 1017240, NULL, 5810, NULL, NULL),
(135, 1017240, NULL, 5811, NULL, NULL),
(136, 1017240, NULL, 5812, NULL, NULL),
(137, 1017240, NULL, 5813, NULL, NULL),
(138, 1017240, NULL, 5814, NULL, NULL),
(139, 1017240, NULL, 5815, NULL, NULL),
(140, 1017240, NULL, 5816, NULL, NULL),
(141, 1017240, NULL, 5817, NULL, NULL),
(142, 1017240, NULL, 5818, NULL, NULL),
(143, 1017240, NULL, 5819, NULL, NULL),
(144, 1015376, NULL, 5820, NULL, NULL),
(145, 1017240, NULL, 5821, NULL, NULL),
(146, 1017240, NULL, 5822, NULL, NULL),
(147, 1015784, NULL, 5823, NULL, NULL),
(148, 1015784, NULL, 5824, NULL, NULL),
(149, 1015784, NULL, 5825, NULL, NULL),
(150, 1015784, NULL, 5826, NULL, NULL),
(151, 1015784, NULL, 5827, NULL, NULL),
(153, 1017248, NULL, 5828, NULL, NULL),
(154, 1017298, NULL, 5829, NULL, NULL),
(155, 1017298, NULL, 5830, NULL, NULL),
(156, 1017298, NULL, 5831, NULL, NULL),
(157, 1017298, NULL, 5832, NULL, NULL),
(158, 1017298, NULL, 5833, NULL, NULL),
(159, 1017298, NULL, 5834, NULL, NULL),
(160, 1017298, NULL, 5835, NULL, NULL),
(161, 1017298, NULL, 5836, NULL, NULL),
(162, 1017298, NULL, 5837, NULL, NULL),
(163, 1017298, NULL, 5838, NULL, NULL),
(164, 1017302, NULL, 5839, NULL, NULL),
(165, 1017302, NULL, 5840, NULL, NULL),
(166, 1017302, NULL, 5841, NULL, NULL),
(167, 1017210, NULL, 5842, NULL, NULL),
(168, 1017210, NULL, 5843, NULL, NULL),
(169, 1017240, NULL, 5844, NULL, NULL),
(178, 1000004, NULL, 5851, NULL, NULL),
(179, 1000004, NULL, 5852, NULL, NULL),
(180, 1000004, NULL, 5853, NULL, NULL),
(181, 1000004, NULL, 5854, NULL, NULL),
(182, 1000003, NULL, 5855, NULL, NULL),
(183, 1000003, NULL, 5856, NULL, NULL),
(184, 1000004, NULL, 5857, NULL, NULL),
(185, 1000003, NULL, 5858, NULL, NULL),
(186, 1000003, NULL, 5859, NULL, NULL),
(187, 1000003, NULL, 5860, NULL, NULL),
(188, 1000004, NULL, 5861, NULL, NULL),
(189, 1000004, NULL, 5862, NULL, NULL),
(190, 1000004, NULL, 5863, NULL, NULL),
(191, 1000004, NULL, 5864, NULL, NULL),
(192, 1000004, NULL, 5865, NULL, NULL),
(193, 1000004, NULL, 5866, NULL, NULL),
(194, 1000004, NULL, 5867, NULL, NULL),
(195, 1000003, NULL, 5868, NULL, NULL),
(196, 1000003, NULL, 5869, NULL, NULL),
(197, 1000003, NULL, 5870, NULL, NULL),
(199, 1000004, NULL, 5872, NULL, NULL),
(200, 1000004, NULL, 5873, NULL, NULL),
(201, 1000004, NULL, 5874, NULL, NULL),
(202, 1000004, NULL, 5875, NULL, NULL),
(203, 1000004, NULL, 5876, NULL, NULL),
(204, 1000004, NULL, 5877, NULL, NULL),
(205, 1000004, NULL, 5878, NULL, NULL),
(206, 1000004, NULL, 5879, NULL, NULL),
(207, 1000004, NULL, 5880, NULL, NULL),
(208, 1000004, NULL, 5881, NULL, NULL),
(209, 1000004, NULL, 5882, NULL, NULL),
(210, 1000004, NULL, 5883, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `push_messages`
--

CREATE TABLE `push_messages` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `creator_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `push_messages`
--

INSERT INTO `push_messages` (`id`, `title`, `body`, `creator_id`, `created_at`, `updated_at`, `image`, `product_id`) VALUES
(349, 'test notification', 'test notification', NULL, '2021-12-16 12:34:55', '2021-12-16 12:34:55', NULL, NULL),
(350, 'test notification', 'test notification', NULL, '2021-12-16 12:35:18', '2021-12-16 12:35:18', NULL, NULL),
(351, 'test notification1', 'test notification1', 1, '2022-06-23 15:06:45', '2022-06-23 15:06:45', NULL, NULL),
(352, 'test', 'new DVD Offer', 1, '2022-06-26 11:21:50', '2022-06-26 11:21:50', NULL, 167),
(353, 'مرحبا بكم فيمجموعة منصور', 'مرحبا بكم فيمجموعة منصور', 1, '2022-07-18 13:29:29', '2022-07-18 13:29:29', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `redeem_points`
--

CREATE TABLE `redeem_points` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_point_id` int(11) NOT NULL,
  `redeem_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `request_logs`
--

CREATE TABLE `request_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_type` enum('customer','admin','branch','affiliate') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `method` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `request` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`request`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rewards`
--

CREATE TABLE `rewards` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 1,
  `amount_type` tinyint(1) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `max_amount` int(11) DEFAULT NULL,
  `point_cost` int(11) NOT NULL DEFAULT 0,
  `is_gold` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `deactivation_notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name_ar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description_ar` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rewards`
--

INSERT INTO `rewards` (`id`, `name`, `description`, `image`, `type`, `amount_type`, `amount`, `max_amount`, `point_cost`, `is_gold`, `created_at`, `updated_at`, `active`, `deactivation_notes`, `name_ar`, `description_ar`) VALUES
(22, 'Redeem 10 EGP on Time', 'Redeem 10 points', NULL, 1, 1, 10, NULL, 10, 0, '2021-11-21 13:36:17', '2021-12-15 20:59:33', 0, 'test', 'خصم 20 جنيه على منتجات تيم', 'Redeem 10 points'),
(23, 'Voucher', 'Voucher', 'http://104.46.33.250/storage/uploads/Picture2-1649756138.jpg', 2, 1, 50, NULL, 5000, 0, '2021-12-15 20:49:04', '2022-07-18 13:36:31', 1, NULL, 'Voucher', 'Voucher'),
(24, 'Vacuum Cleaner', '<span style=\"font-size:12.0pt;font-family:&quot;Segoe UI Light&quot;;\nmso-ascii-font-family:&quot;Segoe UI Light&quot;;mso-fareast-font-family:+mn-ea;\nmso-bidi-font-family:+mn-cs;mso-ascii-theme-font:minor-latin;mso-fareast-theme-font:\nminor-fareast;mso-b', 'http://104.46.33.250/storage/uploads/Picture3-1649756095.jpg', 2, NULL, NULL, NULL, 9000, 0, '2021-12-15 20:49:58', '2022-07-18 13:35:50', 0, '0', 'Vacuum Cleaner', '<span style=\"font-size:12.0pt;font-family:&quot;Segoe UI Light&quot;;\nmso-ascii-font-family:&quot;Segoe UI Light&quot;;mso-fareast-font-family:+mn-ea;\nmso-bidi-font-family:+mn-cs;mso-ascii-theme-font:minor-latin;mso-fareast-theme-font:\nminor-fareast;mso-bidi-theme-font:minor-bidi;color:black;mso-color-index:1;\nmso-font-kerning:12.0pt;language:en-US;mso-style-textfill-type:solid;\nmso-style-textfill-fill-themecolor:text1;mso-style-textfill-fill-color:black;\nmso-style-textfill-fill-alpha:100.0%\">Vacuum Cleaner</span>'),
(25, 'Water Dispenser', '<span style=\"font-size:12.0pt;font-family:&quot;Segoe UI Light&quot;;\nmso-ascii-font-family:&quot;Segoe UI Light&quot;;mso-fareast-font-family:+mn-ea;\nmso-bidi-font-family:+mn-cs;mso-ascii-theme-font:minor-latin;mso-fareast-theme-font:\nminor-fareast;mso-b', 'http://104.46.33.250/storage/uploads/Picture4-1649756082.jpg', 2, NULL, NULL, NULL, 15000, 0, '2021-12-15 20:50:43', '2022-07-18 13:35:55', 0, '0', 'Water Dispenser', '<span style=\"font-size:12.0pt;font-family:&quot;Segoe UI Light&quot;;\nmso-ascii-font-family:&quot;Segoe UI Light&quot;;mso-fareast-font-family:+mn-ea;\nmso-bidi-font-family:+mn-cs;mso-ascii-theme-font:minor-latin;mso-fareast-theme-font:\nminor-fareast;mso-bidi-theme-font:minor-bidi;color:black;mso-color-index:1;\nmso-font-kerning:12.0pt;language:en-US;mso-style-textfill-type:solid;\nmso-style-textfill-fill-themecolor:text1;mso-style-textfill-fill-color:black;\nmso-style-textfill-fill-alpha:100.0%\">Water Dispenser</span>'),
(26, 'Security Camera', '<span style=\"font-size:12.0pt;font-family:&quot;Segoe UI Light&quot;;\nmso-ascii-font-family:&quot;Segoe UI Light&quot;;mso-fareast-font-family:+mn-ea;\nmso-bidi-font-family:+mn-cs;mso-ascii-theme-font:minor-latin;mso-fareast-theme-font:\nminor-fareast;mso-b', 'http://104.46.33.250/storage/uploads/Picture5-1649756066.jpg', 2, NULL, NULL, NULL, 18, 0, '2021-12-15 20:51:31', '2022-07-18 13:35:39', 0, '0', 'Security Camera', '<span style=\"font-size:12.0pt;font-family:&quot;Segoe UI Light&quot;;\nmso-ascii-font-family:&quot;Segoe UI Light&quot;;mso-fareast-font-family:+mn-ea;\nmso-bidi-font-family:+mn-cs;mso-ascii-theme-font:minor-latin;mso-fareast-theme-font:\nminor-fareast;mso-bidi-theme-font:minor-bidi;color:black;mso-color-index:1;\nmso-font-kerning:12.0pt;language:en-US;mso-style-textfill-type:solid;\nmso-style-textfill-fill-themecolor:text1;mso-style-textfill-fill-color:black;\nmso-style-textfill-fill-alpha:100.0%\">Security Camera</span>'),
(27, 'Mobile', '<span style=\"font-size:12.0pt;font-family:&quot;Segoe UI Light&quot;;\nmso-ascii-font-family:&quot;Segoe UI Light&quot;;mso-fareast-font-family:+mn-ea;\nmso-bidi-font-family:+mn-cs;mso-ascii-theme-font:minor-latin;mso-fareast-theme-font:\nminor-fareast;mso-b', 'http://104.46.33.250/storage/uploads/Picture7-1649756053.jpg', 2, NULL, NULL, NULL, 23000, 0, '2021-12-15 20:52:07', '2022-07-18 13:35:34', 0, '0', 'Mobile', '<span style=\"font-size:12.0pt;font-family:&quot;Segoe UI Light&quot;;\nmso-ascii-font-family:&quot;Segoe UI Light&quot;;mso-fareast-font-family:+mn-ea;\nmso-bidi-font-family:+mn-cs;mso-ascii-theme-font:minor-latin;mso-fareast-theme-font:\nminor-fareast;mso-bidi-theme-font:minor-bidi;color:black;mso-color-index:1;\nmso-font-kerning:12.0pt;language:en-US;mso-style-textfill-type:solid;\nmso-style-textfill-fill-themecolor:text1;mso-style-textfill-fill-color:black;\nmso-style-textfill-fill-alpha:100.0%\">Mobile</span>'),
(28, 'Smart Watch', '<span style=\"font-size:12.0pt;font-family:&quot;Segoe UI Light&quot;;\nmso-ascii-font-family:&quot;Segoe UI Light&quot;;mso-fareast-font-family:+mn-ea;\nmso-bidi-font-family:+mn-cs;mso-ascii-theme-font:minor-latin;mso-fareast-theme-font:\nminor-fareast;mso-b', 'http://104.46.33.250/storage/uploads/Picture6-1649756036.jpg', 2, NULL, NULL, NULL, 27000, 0, '2021-12-15 20:52:44', '2022-07-18 13:35:28', 0, '0', 'Smart Watch', '<span style=\"font-size:12.0pt;font-family:&quot;Segoe UI Light&quot;;\nmso-ascii-font-family:&quot;Segoe UI Light&quot;;mso-fareast-font-family:+mn-ea;\nmso-bidi-font-family:+mn-cs;mso-ascii-theme-font:minor-latin;mso-fareast-theme-font:\nminor-fareast;mso-bidi-theme-font:minor-bidi;color:black;mso-color-index:1;\nmso-font-kerning:12.0pt;language:en-US;mso-style-textfill-type:solid;\nmso-style-textfill-fill-themecolor:text1;mso-style-textfill-fill-color:black;\nmso-style-textfill-fill-alpha:100.0%\">Smart Watch</span>'),
(29, 'Tablet', '<span style=\"font-size:12.0pt;font-family:&quot;Segoe UI Light&quot;;\nmso-ascii-font-family:&quot;Segoe UI Light&quot;;mso-fareast-font-family:+mn-ea;\nmso-bidi-font-family:+mn-cs;mso-ascii-theme-font:minor-latin;mso-fareast-theme-font:\nminor-fareast;mso-b', 'http://104.46.33.250/storage/uploads/Picture8-1649756020.jpg', 2, NULL, NULL, NULL, 36000, 0, '2021-12-15 20:53:31', '2022-07-18 13:35:22', 0, '0', 'Tablet', '<span style=\"font-size:12.0pt;font-family:&quot;Segoe UI Light&quot;;\nmso-ascii-font-family:&quot;Segoe UI Light&quot;;mso-fareast-font-family:+mn-ea;\nmso-bidi-font-family:+mn-cs;mso-ascii-theme-font:minor-latin;mso-fareast-theme-font:\nminor-fareast;mso-bidi-theme-font:minor-bidi;color:black;mso-color-index:1;\nmso-font-kerning:12.0pt;language:en-US;mso-style-textfill-type:solid;\nmso-style-textfill-fill-themecolor:text1;mso-style-textfill-fill-color:black;\nmso-style-textfill-fill-alpha:100.0%\">Tablet</span>'),
(30, 'T.V. LED', '<span style=\"font-size:12.0pt;font-family:&quot;Segoe UI Light&quot;;\nmso-ascii-font-family:&quot;Segoe UI Light&quot;;mso-fareast-font-family:+mn-ea;\nmso-bidi-font-family:+mn-cs;mso-ascii-theme-font:minor-latin;mso-fareast-theme-font:\nminor-fareast;mso-b', 'http://104.46.33.250/storage/uploads/Picture9-1649756001.jpg', 2, NULL, NULL, NULL, 45000, 0, '2021-12-15 20:54:06', '2022-07-18 13:35:16', 0, '0', 'T.V. LED', '<span style=\"font-size:12.0pt;font-family:&quot;Segoe UI Light&quot;;\nmso-ascii-font-family:&quot;Segoe UI Light&quot;;mso-fareast-font-family:+mn-ea;\nmso-bidi-font-family:+mn-cs;mso-ascii-theme-font:minor-latin;mso-fareast-theme-font:\nminor-fareast;mso-bidi-theme-font:minor-bidi;color:black;mso-color-index:1;\nmso-font-kerning:12.0pt;language:en-US;mso-style-textfill-type:solid;\nmso-style-textfill-fill-themecolor:text1;mso-style-textfill-fill-color:black;\nmso-style-textfill-fill-alpha:100.0%\">T.V. LED</span>'),
(31, 'Refrigerator', '<span style=\"font-size:12.0pt;font-family:&quot;Segoe UI Light&quot;;\nmso-ascii-font-family:&quot;Segoe UI Light&quot;;mso-fareast-font-family:+mn-ea;\nmso-bidi-font-family:+mn-cs;mso-ascii-theme-font:minor-latin;mso-fareast-theme-font:\nminor-fareast;mso-b', 'http://104.46.33.250/storage/uploads/Picture11-1649755979.jpg', 2, NULL, NULL, NULL, 54000, 0, '2021-12-15 20:54:43', '2022-07-18 13:35:08', 0, '0', 'Refrigerator', '<span style=\"font-size:12.0pt;font-family:&quot;Segoe UI Light&quot;;\nmso-ascii-font-family:&quot;Segoe UI Light&quot;;mso-fareast-font-family:+mn-ea;\nmso-bidi-font-family:+mn-cs;mso-ascii-theme-font:minor-latin;mso-fareast-theme-font:\nminor-fareast;mso-bidi-theme-font:minor-bidi;color:black;mso-color-index:1;\nmso-font-kerning:12.0pt;language:en-US;mso-style-textfill-type:solid;\nmso-style-textfill-fill-themecolor:text1;mso-style-textfill-fill-color:black;\nmso-style-textfill-fill-alpha:100.0%\">Refrigerator</span>'),
(32, 'Internal Trip', '<span style=\"font-size:12.0pt;font-family:&quot;Segoe UI Light&quot;;\nmso-ascii-font-family:&quot;Segoe UI Light&quot;;mso-fareast-font-family:+mn-ea;\nmso-bidi-font-family:+mn-cs;mso-ascii-theme-font:minor-latin;mso-fareast-theme-font:\nminor-fareast;mso-b', 'http://104.46.33.250/storage/uploads/Picture13-1649755925.jpg', 2, NULL, NULL, NULL, 63000, 0, '2021-12-15 20:55:13', '2022-07-18 13:35:03', 0, '0', 'Internal Trip', '<span style=\"font-size:12.0pt;font-family:&quot;Segoe UI Light&quot;;\nmso-ascii-font-family:&quot;Segoe UI Light&quot;;mso-fareast-font-family:+mn-ea;\nmso-bidi-font-family:+mn-cs;mso-ascii-theme-font:minor-latin;mso-fareast-theme-font:\nminor-fareast;mso-bidi-theme-font:minor-bidi;color:black;mso-color-index:1;\nmso-font-kerning:12.0pt;language:en-US;mso-style-textfill-type:solid;\nmso-style-textfill-fill-themecolor:text1;mso-style-textfill-fill-color:black;\nmso-style-textfill-fill-alpha:100.0%\">Internal Trip</span>'),
(33, 'Air Condition', '<p style=\"language:en-US;margin-top:0pt;margin-bottom:0pt;margin-left:0in;\ntext-align:center;direction:ltr;unicode-bidi:embed;vertical-align:middle;\nmso-line-break-override:none;word-break:normal;punctuation-wrap:hanging\"><span style=\"font-size:12.0pt;fon', 'http://104.46.33.250/storage/uploads/Picture12-1649755902.jpg', 2, NULL, NULL, NULL, 72000, 0, '2021-12-15 20:55:57', '2022-07-18 13:34:56', 0, '0', 'Air Condition', '<p style=\"language:en-US;margin-top:0pt;margin-bottom:0pt;margin-left:0in;\ntext-align:center;direction:ltr;unicode-bidi:embed;vertical-align:middle;\nmso-line-break-override:none;word-break:normal;punctuation-wrap:hanging\"><span style=\"font-size:12.0pt;font-family:&quot;Segoe UI Light&quot;;mso-ascii-font-family:\n&quot;Segoe UI Light&quot;;mso-fareast-font-family:+mn-ea;mso-bidi-font-family:+mn-cs;\nmso-ascii-theme-font:minor-latin;mso-fareast-theme-font:minor-fareast;\nmso-bidi-theme-font:minor-bidi;color:black;mso-color-index:1;mso-font-kerning:\n12.0pt;language:en-US;mso-style-textfill-type:solid;mso-style-textfill-fill-themecolor:\ntext1;mso-style-textfill-fill-color:black;mso-style-textfill-fill-alpha:100.0%\">Air\nCondition</span></p>'),
(34, 'Scooter', '<span style=\"font-size:12.0pt;font-family:&quot;Segoe UI Light&quot;;\nmso-ascii-font-family:&quot;Segoe UI Light&quot;;mso-fareast-font-family:+mn-ea;\nmso-bidi-font-family:+mn-cs;mso-ascii-theme-font:minor-latin;mso-fareast-theme-font:\nminor-fareast;mso-b', 'http://104.46.33.250/storage/uploads/Picture10-1649755827.jpg', 2, NULL, NULL, NULL, 81000, 0, '2021-12-15 20:56:32', '2022-07-18 13:34:48', 0, 'ن', 'سكوتر', '<span style=\"font-size:12.0pt;font-family:&quot;Segoe UI Light&quot;;\nmso-ascii-font-family:&quot;Segoe UI Light&quot;;mso-fareast-font-family:+mn-ea;\nmso-bidi-font-family:+mn-cs;mso-ascii-theme-font:minor-latin;mso-fareast-theme-font:\nminor-fareast;mso-bidi-theme-font:minor-bidi;color:black;mso-color-index:1;\nmso-font-kerning:12.0pt;language:en-US;mso-style-textfill-type:solid;\nmso-style-textfill-fill-themecolor:text1;mso-style-textfill-fill-color:black;\nmso-style-textfill-fill-alpha:100.0%\">Scooter</span>'),
(35, 'Foreign Trip', '<span style=\"font-size:12.0pt;font-family:&quot;Segoe UI Light&quot;;\nmso-ascii-font-family:&quot;Segoe UI Light&quot;;mso-fareast-font-family:+mn-ea;\nmso-bidi-font-family:+mn-cs;mso-ascii-theme-font:minor-latin;mso-fareast-theme-font:\nminor-fareast;mso-b', 'http://104.46.33.250/storage/uploads/Picture15-1649755872.jpg', 2, NULL, NULL, NULL, 90000, 0, '2021-12-15 20:56:57', '2022-07-18 13:34:40', 0, '0', 'Foreign Trip', '<span style=\"font-size:12.0pt;font-family:&quot;Segoe UI Light&quot;;\nmso-ascii-font-family:&quot;Segoe UI Light&quot;;mso-fareast-font-family:+mn-ea;\nmso-bidi-font-family:+mn-cs;mso-ascii-theme-font:minor-latin;mso-fareast-theme-font:\nminor-fareast;mso-bidi-theme-font:minor-bidi;color:black;mso-color-index:1;\nmso-font-kerning:12.0pt;language:en-US;mso-style-textfill-type:solid;\nmso-style-textfill-fill-themecolor:text1;mso-style-textfill-fill-color:black;\nmso-style-textfill-fill-alpha:100.0%\">Foreign Trip</span>');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `deactivation_notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`, `active`, `deactivation_notes`) VALUES
(1, 'Super Admin', 'web', '2020-05-01 23:29:05', '2021-09-08 11:43:45', 1, NULL),
(20, 'Sub Admin', 'web', '2020-07-09 12:13:11', '2021-02-14 13:06:25', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(1, 20),
(1, 21),
(1, 23),
(1, 27),
(2, 20),
(2, 21),
(2, 22),
(2, 23),
(2, 27),
(3, 21),
(3, 23),
(3, 27),
(4, 21),
(4, 23),
(4, 27),
(5, 20),
(5, 21),
(5, 22),
(5, 23),
(5, 24),
(5, 25),
(5, 26),
(5, 27),
(5, 28),
(5, 29),
(6, 20),
(6, 21),
(6, 22),
(6, 23),
(6, 24),
(6, 25),
(6, 26),
(6, 27),
(6, 28),
(6, 29),
(7, 20),
(7, 21),
(7, 22),
(7, 23),
(7, 25),
(7, 27),
(8, 21),
(8, 23),
(8, 27),
(9, 21),
(9, 23),
(9, 27),
(10, 21),
(10, 23),
(10, 27),
(11, 21),
(11, 23),
(11, 27),
(12, 20),
(12, 21),
(12, 23),
(12, 27),
(13, 21),
(13, 23),
(13, 27),
(14, 20),
(14, 21),
(14, 23),
(14, 27),
(15, 21),
(15, 23),
(15, 27),
(16, 21),
(16, 23),
(16, 27),
(17, 21),
(17, 23),
(17, 27),
(18, 21),
(18, 23),
(18, 27),
(19, 20),
(19, 21),
(19, 23),
(19, 27),
(20, 20),
(20, 21),
(20, 23),
(20, 27),
(21, 20),
(21, 21),
(21, 23),
(21, 27),
(22, 21),
(22, 23),
(22, 27);

-- --------------------------------------------------------

--
-- Table structure for table `role_state`
--

CREATE TABLE `role_state` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `order_state_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_state`
--

INSERT INTO `role_state` (`role_id`, `order_state_id`) VALUES
(25, 1),
(25, 2),
(25, 6),
(26, 8),
(26, 2),
(26, 7),
(27, 1),
(27, 2),
(27, 3),
(27, 4),
(27, 5),
(27, 6),
(27, 7),
(27, 8),
(27, 9),
(27, 10),
(27, 11),
(27, 12),
(27, 13),
(27, 14),
(28, 1),
(28, 2),
(28, 3),
(28, 4),
(28, 5),
(28, 6),
(29, 1),
(29, 2),
(29, 3),
(29, 4),
(29, 5),
(29, 6),
(29, 7),
(29, 8),
(29, 9),
(29, 10),
(29, 11),
(29, 12),
(29, 13),
(29, 14),
(20, 1),
(20, 2),
(20, 6),
(20, 4);

-- --------------------------------------------------------

--
-- Table structure for table `schedule_days`
--

CREATE TABLE `schedule_days` (
  `id` int(10) UNSIGNED NOT NULL,
  `schedule_id` int(10) UNSIGNED NOT NULL,
  `day` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `id` int(10) UNSIGNED NOT NULL,
  `name_en` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name_ar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description_ar` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description_en` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` tinyint(4) DEFAULT NULL,
  `image_en` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_ar` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `list_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `image_type` int(11) NOT NULL DEFAULT 1 COMMENT '1=no images, 2=one image, 3=five images'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`id`, `name_en`, `name_ar`, `description_ar`, `description_en`, `type`, `image_en`, `image_ar`, `order`, `active`, `list_id`, `created_at`, `updated_at`, `image_type`) VALUES
(42, 'عروض حصرية', 'عروض حصرية', 'يوم سعيد', 'have a nice day', 0, NULL, NULL, 1, 1, 101, '2022-06-13 13:48:15', '2022-10-30 09:26:27', 1);

-- --------------------------------------------------------

--
-- Table structure for table `section_images`
--

CREATE TABLE `section_images` (
  `id` int(10) UNSIGNED NOT NULL,
  `image_en` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_ar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `section_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `link_en` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shipping_areas`
--

CREATE TABLE `shipping_areas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shipping_id` int(11) DEFAULT NULL,
  `shipping_area_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_area_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `area_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shipping_methods`
--

CREATE TABLE `shipping_methods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_ar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shipping_methods`
--

INSERT INTO `shipping_methods` (`id`, `name`, `name_ar`, `created_at`, `updated_at`) VALUES
(1, 'INTERNAL', NULL, NULL, NULL),
(2, 'MYLERZ', NULL, NULL, NULL),
(3, 'ARAMEX', NULL, NULL, NULL),
(4, 'BOSTA', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `stock_notifications`
--

CREATE TABLE `stock_notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sub_category_groups`
--

CREATE TABLE `sub_category_groups` (
  `id` int(10) UNSIGNED NOT NULL,
  `group_id` int(10) UNSIGNED DEFAULT NULL,
  `category_id` int(10) UNSIGNED DEFAULT NULL,
  `sub_category_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_category_groups`
--

INSERT INTO `sub_category_groups` (`id`, `group_id`, `category_id`, `sub_category_id`, `created_at`, `updated_at`) VALUES
(1043, 107, 947, 948, '2021-12-15 20:13:30', '2021-12-15 20:13:30');

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` int(10) UNSIGNED NOT NULL,
  `name_en` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name_ar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description_ar` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description_en` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `total_spent_per_categories`
--

CREATE TABLE `total_spent_per_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `total_spent` decimal(8,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `total_spent_per_categories`
--

INSERT INTO `total_spent_per_categories` (`id`, `user_id`, `category_id`, `total_spent`, `created_at`, `updated_at`) VALUES
(1, 1017374, 942, '20000.00', '2021-12-15 14:24:48', '2021-12-15 16:51:55'),
(2, 1017373, 942, '20000.00', '2021-12-15 15:08:36', '2021-12-15 15:24:50'),
(3, 1017373, 940, '1000.00', '2021-12-15 15:08:36', '2021-12-15 15:08:36'),
(4, 1017379, 940, '3000.00', '2021-12-15 15:40:16', '2021-12-15 16:00:23'),
(5, 1017379, 942, '20000.00', '2021-12-15 15:42:06', '2021-12-15 16:02:36'),
(6, 1017380, 940, '7000.00', '2021-12-15 16:12:16', '2021-12-16 15:58:46'),
(7, 1017380, 942, '25000.00', '2021-12-15 16:12:16', '2021-12-16 15:58:46'),
(8, 1017374, 940, '1000.00', '2021-12-15 16:51:55', '2021-12-15 16:51:55'),
(9, 1017381, 940, '6000.00', '2021-12-15 17:16:14', '2022-01-12 14:01:23'),
(10, 1017382, 942, '25000.00', '2021-12-15 17:47:36', '2021-12-15 18:25:59'),
(11, 1017382, 940, '2000.00', '2021-12-15 17:50:36', '2021-12-15 18:25:59'),
(12, 1017380, 944, '999999.99', '2021-12-16 15:58:46', '2021-12-16 15:58:46'),
(13, 1017381, 942, '37500.00', '2022-01-10 15:27:49', '2022-01-12 15:12:45'),
(14, 1017381, 944, '30.00', '2022-01-12 14:01:23', '2022-01-12 14:31:53'),
(15, 1017381, 948, '1400.00', '2022-01-12 14:01:23', '2022-01-12 14:31:53'),
(16, 1000002, 12, '53673.50', '2022-03-16 13:12:59', '2022-07-21 16:26:05'),
(17, 1000002, 8, '467556.00', '2022-03-16 13:15:53', '2022-08-21 17:12:39'),
(18, 1000000, 8, '912.00', '2022-03-22 14:15:51', '2022-03-22 14:15:51'),
(19, 1000003, 8, '999999.99', '2022-03-22 15:06:17', '2022-08-23 16:30:51'),
(20, 1000001, 8, '6595.38', '2022-03-23 15:41:35', '2022-04-12 23:13:39'),
(21, 1000004, 8, '280854.38', '2022-03-24 14:25:04', '2022-06-22 16:22:06'),
(22, 1000001, 20, '253.00', '2022-03-27 14:13:06', '2022-03-27 14:13:06'),
(23, 1000004, 20, '783.00', '2022-03-28 15:07:02', '2022-05-24 15:21:37'),
(24, 1000005, 8, '9277.25', '2022-03-30 14:39:05', '2022-06-05 16:05:14'),
(25, 1000005, 14, '3732.55', '2022-03-30 14:39:05', '2022-06-06 12:53:47'),
(26, 1000001, 14, '860.00', '2022-03-30 21:20:45', '2022-04-03 11:42:27'),
(27, 1000004, 14, '1940.00', '2022-04-10 12:25:22', '2022-04-17 10:28:41'),
(28, 1000004, 12, '183.50', '2022-04-10 13:00:44', '2022-04-10 13:00:44'),
(29, 1000010, 20, '530.00', '2022-04-13 11:52:11', '2022-04-13 11:59:39'),
(30, 1000010, 8, '2736.00', '2022-04-13 11:52:11', '2022-04-13 12:06:12'),
(31, 1000006, 8, '26889.00', '2022-06-05 10:01:10', '2022-07-25 09:18:42'),
(32, 1000003, 4, '31720.00', '2022-06-12 14:01:20', '2022-06-12 14:05:15'),
(33, 1000003, 14, '47083.60', '2022-06-13 15:32:01', '2022-07-17 17:11:56'),
(34, 1000003, 12, '686750.00', '2022-06-20 13:21:51', '2022-08-03 14:37:40'),
(35, 1000003, 20, '192850.00', '2022-06-20 13:21:51', '2022-08-31 16:51:49'),
(36, 1000004, 4, '15860.00', '2022-06-22 16:22:06', '2022-06-22 16:22:06'),
(37, 1000003, 22, '23500.00', '2022-06-28 09:54:44', '2022-07-17 17:11:56'),
(38, 1000002, 4, '67440.00', '2022-07-21 16:26:05', '2022-08-21 17:12:39'),
(39, 1000006, 12, '338250.00', '2022-07-21 18:11:48', '2022-08-04 09:33:55'),
(40, 1000008, 12, '502250.00', '2022-07-25 09:18:41', '2022-08-01 13:04:10'),
(41, 1000005, 12, '51250.00', '2022-07-31 10:02:18', '2022-07-31 10:02:18'),
(42, 1000008, 8, '524055.00', '2022-07-31 10:02:18', '2022-08-07 10:39:18'),
(43, 1000002, 22, '56400.00', '2022-07-31 10:02:18', '2022-07-31 10:02:18'),
(44, 1000021, 12, '123000.00', '2022-08-01 13:05:54', '2022-08-03 11:33:39'),
(45, 1000021, 20, '19950.00', '2022-08-03 11:33:39', '2022-08-03 11:33:39'),
(46, 1000023, 12, '20500.00', '2022-08-04 09:34:13', '2022-08-04 09:34:13'),
(47, 1000020, 12, '20500.00', '2022-08-04 09:35:45', '2022-08-04 09:35:45'),
(48, 1000007, 12, '20500.00', '2022-08-04 09:35:45', '2022-08-04 09:35:45'),
(49, 1000017, 12, '20500.00', '2022-08-04 09:35:46', '2022-08-04 09:35:46'),
(50, 1000024, 12, '20500.00', '2022-08-04 09:35:46', '2022-08-04 09:35:46'),
(51, 1000022, 12, '20500.00', '2022-08-04 09:36:43', '2022-08-04 09:36:43'),
(52, 1000024, 8, '45570.00', '2022-08-07 10:39:18', '2022-08-07 10:39:18'),
(53, 1000002, 20, '39900.00', '2022-08-14 18:13:51', '2022-08-14 18:13:51');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_details` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_transaction` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_pay_id` int(11) DEFAULT NULL,
  `weaccept_transaction_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `card_info` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_response` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_status` int(11) DEFAULT 0,
  `total_amount` int(11) DEFAULT NULL,
  `customer_id` int(10) UNSIGNED DEFAULT NULL,
  `user_agent` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `payment_reference` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_method_id` int(10) UNSIGNED DEFAULT NULL,
  `response_code` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `session` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `success_indicator` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_processe` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_request` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `rating` decimal(8,2) DEFAULT NULL,
  `deactivation_notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_active` datetime DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_verified` tinyint(1) NOT NULL DEFAULT 0,
  `verification_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `referal` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `spent` int(11) NOT NULL DEFAULT 0,
  `refered` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `first_order` tinyint(1) NOT NULL DEFAULT 0,
  `type` tinyint(1) NOT NULL DEFAULT 1,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `admin_first_order` tinyint(1) NOT NULL DEFAULT 0,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `edara_id` int(11) DEFAULT NULL,
  `link_id` int(10) UNSIGNED DEFAULT NULL,
  `erp_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `active`, `remember_token`, `created_at`, `updated_at`, `birthdate`, `rating`, `deactivation_notes`, `last_active`, `image`, `phone_verified`, `verification_code`, `referal`, `spent`, `refered`, `first_order`, `type`, `role`, `admin_first_order`, `last_name`, `edara_id`, `link_id`, `erp_id`, `code`) VALUES
(1, 'زهرة الحدائق', 'muhanad@el-dokan.com', '$2a$10$qk1odlnSVfmGeM0qNdNVFOK8IPxTtp3iVFQpgY5xteOwqZndY0wiO', '01022627548', 1, NULL, NULL, '2022-11-03 11:40:21', NULL, NULL, NULL, '2022-07-20 10:16:13', NULL, 1, NULL, NULL, 0, '0', 0, 2, 'ADMIN', 0, NULL, NULL, NULL, NULL, '202_384995'),
(999999, 'البطل الرومانى', 'muhanadd@el-dokan.com', '$2a$10$qk1odlnSVfmGeM0qNdNVFOK8IPxTtp3iVFQpgY5xteOwqZndY0wiO', '01555453673', 1, NULL, NULL, '2022-11-03 11:40:21', NULL, NULL, NULL, '2022-07-20 10:18:54', NULL, 1, NULL, NULL, 0, '0', 0, 1, 'WS', 0, NULL, NULL, NULL, NULL, '292_1581'),
(1000000, 'زهرة الحدائق', NULL, '$2y$10$Wpokz657LJWWVqCYcLjcA.TKu1TMNK80aWF/tzt4CMyiUgTKacrfm', '01022627548', 1, NULL, '2022-07-20 10:20:37', '2022-07-20 12:14:55', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 0, '0', 0, 1, 'RT', 0, NULL, NULL, NULL, NULL, '202_384995'),
(1000001, 'جملة باب البحر', NULL, '$2y$10$1D6Je7Kbg105igF8P8phd.ySjJ938MJV8Uhnl1VH7cOARKI6.I4Cy', '01002211282', 1, NULL, '2022-07-20 10:20:38', '2022-11-03 11:40:21', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 0, '0', 0, 1, 'WS', 0, NULL, NULL, NULL, NULL, '240_385345'),
(1000002, 'البطل الرومانى', NULL, '$2y$10$/O5FqXn/bVMOG9vCyRQ25uZj6x78SPKgxqVsTQtdqA57nJJnC7dRi', '01555453673', 1, NULL, '2022-07-20 10:20:38', '2022-08-21 17:12:39', NULL, NULL, NULL, NULL, NULL, 1, NULL, 'البطل-ROG0', 670690, '0', 1, 1, NULL, 1, NULL, NULL, NULL, NULL, '292_1581'),
(1000003, 'ك/ محروس /عبد الرحيم /محمد محمد سنه', NULL, '$2y$10$3AjajXefNoaavZ4kvIT88uFjt87h5ucioUaL.Xt5dBnGXSV5xGU.W', '01095150281', 1, NULL, '2022-07-20 10:20:38', '2022-11-03 11:40:21', NULL, NULL, NULL, NULL, NULL, 1, NULL, 'ك/-MRZY', 395832, '0', 1, 1, 'WS', 1, NULL, NULL, NULL, NULL, '312_17586'),
(1000004, 'تجارة سلطان', NULL, '$2y$10$v5T31MEyPshB2eQRBiTRZ.FgbHF9x7VE2.DSADN9Ht1Ow6mPaob5a', '01112084000', 1, NULL, '2022-07-20 10:20:38', '2022-11-03 11:40:21', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 0, '0', 0, 1, 'WS', 0, NULL, NULL, NULL, NULL, '4_44558'),
(1000005, 'البدرى للتجاره والتوزيع', NULL, '$2y$10$XpyEMUhC6lc3ndMcJYzIee5CHZacEx6H4gINWoFcey/v1wPS8MJ52', '01222267740', 1, NULL, '2022-07-20 10:20:38', '2022-11-03 11:40:21', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 51250, '0', 0, 1, 'WS', 1, NULL, NULL, NULL, NULL, '608_15584'),
(1000006, 'تجارة وليد صبحى', NULL, '$2y$10$uhPEv1Bxf.8KdJqf.JNVa.WG6f.0xgeu4ggRTs/kumn6TV3poYlae', '01020099053', 1, NULL, '2022-07-20 10:20:38', '2022-11-03 11:40:21', NULL, NULL, NULL, NULL, NULL, 1, NULL, 'تجارة-4JLB', 361035, '0', 1, 1, 'WS', 1, NULL, NULL, NULL, NULL, '611_90658'),
(1000007, 'الروماني للتجارة', NULL, '$2y$10$eQX5twhhw5FxGpLzexhIH.Z6s6YrSSJVMzjoO3Y10vR1oy2ncUifu', '01221170635', 1, NULL, '2022-07-20 10:20:38', '2022-11-03 11:40:21', NULL, NULL, NULL, NULL, NULL, 1, NULL, 'الروماني-VNUY', 20500, '0', 1, 1, 'WS', 1, NULL, NULL, NULL, NULL, '640_46145'),
(1000008, 'الحاجه امال', NULL, '$2y$10$bVGm/Ktu0PRBwIsW5UcEyeZR.XVi.TaytTcUWU/j.JrrbPik5raJG', '01228654444', 1, NULL, '2022-07-20 10:20:38', '2022-11-03 11:40:21', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 1026305, '0', 1, 1, 'WS', 1, NULL, NULL, NULL, NULL, '9_5241'),
(1000009, 'جوهرة باب البحر', NULL, '$2y$10$hmWTHntgtqdrBoHjNy06U.eo3L8TJ2TEOzNUITFhJz72517wcXmGa', '01222375280', 1, NULL, '2022-07-20 10:20:38', '2022-11-03 11:40:21', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 0, '0', 0, 1, 'WS', 0, NULL, NULL, NULL, NULL, '9_80019'),
(1000010, 'Mina', NULL, '$2y$10$Vb5lUAJ/78p9xM7wjjcJ1.9ULCI98xOKnvQiuhUROtkUbLRXswKaa', '01283337343', 1, NULL, '2022-07-20 12:14:56', '2022-11-03 11:40:21', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 0, '0', 0, 1, 'WS', 0, NULL, NULL, NULL, NULL, '9_99999'),
(1000011, 'Shawky', NULL, '$2y$10$DamV05Cq.Zi19728iJIb2.QLh1b/DeRdPVtQ7TiIfDQLql8bh2vY6', '01283664243', 1, NULL, '2022-07-20 15:28:29', '2022-11-03 11:40:21', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 0, '0', 0, 1, 'WS', 1, NULL, NULL, NULL, NULL, '9_999999'),
(1000014, 'الجندى للسجائر', NULL, '$2y$10$8282PojzSlMQ1KQcJdmm4eDvsk2AD7H90PE2SHDiQ5LHgoEhlt5T2', '01023526532', 1, NULL, '2022-07-27 10:42:52', '2022-11-03 11:40:21', NULL, NULL, NULL, NULL, NULL, 1, NULL, 'الجندى-4ZPN', 0, '0', 0, 1, 'WS', 0, NULL, NULL, NULL, NULL, '491_384728'),
(1000015, 'سجايركو', NULL, '$2y$10$OhtesW6mCn40bBbZtFVZWubV/RN5R02hNFRo10iU3XGYBCBPt.ro6', '01111323216', 1, NULL, '2022-07-27 10:42:52', '2022-11-03 11:40:21', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 0, '0', 0, 1, 'WS', 0, NULL, NULL, NULL, NULL, '455_100543'),
(1000016, 'سجايركو الاصلى', NULL, '$2y$10$QMsxFSHtkjWGIS0SrkaLg.lXadY1GecHaSHwzUAJs7LzKasn7uFlm', '01000789103', 1, NULL, '2022-07-27 10:42:52', '2022-11-03 11:40:21', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 0, '0', 0, 1, 'WS', 0, NULL, NULL, NULL, NULL, '289_377691'),
(1000017, 'ابو يوسف نسيم', NULL, '$2y$10$xuUGmqYzWdtWKKdw8cqIE.ieHPoSI.swPEO4yLG4oFAq0LLkXOb5.', '01150655968', 1, NULL, '2022-07-27 10:42:52', '2022-11-03 11:40:21', NULL, NULL, NULL, NULL, NULL, 1, NULL, 'ابو-LKK3', 20500, '0', 0, 1, 'WS', 1, NULL, NULL, NULL, NULL, '660_81420'),
(1000018, 'الوسام', NULL, '$2y$10$jbgyE1eKQHLA098Ri0ub1OB2LlHYsqoEYSjeAoYiRON2ql3UHjOJW', '01096405990', 1, NULL, '2022-07-27 10:42:53', '2022-11-03 11:40:21', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 0, '0', 0, 1, 'WS', 0, NULL, NULL, NULL, NULL, '460_91541'),
(1000019, 'مقلة الاصدقاء', NULL, '$2y$10$VfWbpeRFfxakoLL29evpjeok/MC9XaxeLGY.AJLzBz/05qXHcycY6', '01157267197', 1, NULL, '2022-07-27 10:42:53', '2022-11-03 11:40:21', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 0, '0', 1, 1, 'WS', 1, NULL, NULL, NULL, NULL, '244_9592'),
(1000020, 'ماهر عشم', NULL, '$2y$10$7LcuQEjU79StGJthUXxBke4gybep.WLwMtRkfqVw/LYNy.yCVsvFK', '01206887664', 1, NULL, '2022-07-27 10:42:53', '2022-11-03 11:40:21', NULL, NULL, NULL, NULL, NULL, 1, NULL, 'ماهر-CMLE', 20500, '0', 0, 1, 'WS', 1, NULL, NULL, NULL, NULL, '473_385132'),
(1000021, 'رامى نبيل', NULL, '$2y$10$OSrcoLUYlzcq4DteuxV1de4zZ9i8etChMMmiZJUC0/eCl4l3x4Xv2', '01000600603', 1, NULL, '2022-07-27 10:42:53', '2022-11-03 11:40:21', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 142950, '0', 0, 1, 'WS', 1, NULL, NULL, NULL, NULL, '381_362398'),
(1000022, 'مجدى منصور', NULL, '$2y$10$gVnvF2hfAflyN5cfr8uXc.tYTr/JhN3cuUOuBAauJl/HjYC1mkztu', '01099551017', 1, NULL, '2022-07-27 10:42:53', '2022-11-03 11:40:21', NULL, NULL, NULL, NULL, NULL, 1, NULL, 'مجدى-JBEX', 20500, '0', 1, 1, 'WS', 1, NULL, NULL, NULL, NULL, '462_48503'),
(1000023, 'جملة احمد حديدة', NULL, '$2y$10$iGMXWxrktdTUBD0t/Sg0mu0l6mmWevz7Oei8Mo64LdGGJYz2E7KMa', '01123334815', 1, NULL, '2022-07-27 10:42:53', '2022-11-03 11:40:21', NULL, NULL, NULL, NULL, NULL, 1, NULL, 'جملة-TSG3', 20500, '0', 0, 1, 'WS', 1, NULL, NULL, NULL, NULL, '386_7946'),
(1000024, 'سامح لبيب', NULL, '$2y$10$VVoWp9zE7Nndz893j8ZCOOjbNV/X2ru7NKMHUPBhaBBkranl6AOam', '01200441130', 1, NULL, '2022-07-27 10:42:53', '2022-11-03 11:40:21', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 66070, '0', 1, 1, 'WS', 1, NULL, NULL, NULL, NULL, '609_74119'),
(1000025, 'Mayada', NULL, '$2y$10$1cqM3p24CUDmpugoXFAHze.0I7FFDCnXlbZx2sMvFbz2lJnGaohGy', '01204201292', 1, NULL, '2022-07-27 10:42:53', '2022-11-03 11:40:21', NULL, NULL, NULL, NULL, NULL, 1, NULL, 'MAYADA-66JA', 0, '0', 0, 1, 'WS', 0, NULL, NULL, NULL, NULL, '12_1231231');

-- --------------------------------------------------------

--
-- Table structure for table `user_favourites`
--

CREATE TABLE `user_favourites` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_favourites`
--

INSERT INTO `user_favourites` (`user_id`, `product_id`) VALUES
(1000004, 172),
(1000005, 10),
(1000023, 168);

-- --------------------------------------------------------

--
-- Table structure for table `user_points`
--

CREATE TABLE `user_points` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `referer_id` int(11) DEFAULT NULL,
  `amount_spent` int(11) NOT NULL DEFAULT 0,
  `total_points` int(11) NOT NULL DEFAULT 0,
  `used_points` int(11) NOT NULL DEFAULT 0,
  `expired_points` int(11) NOT NULL DEFAULT 0,
  `expiration_date` date NOT NULL,
  `activation_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `remaining_points` int(11) NOT NULL DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_points`
--

INSERT INTO `user_points` (`id`, `user_id`, `order_id`, `referer_id`, `amount_spent`, `total_points`, `used_points`, `expired_points`, `expiration_date`, `activation_date`, `created_at`, `updated_at`, `remaining_points`, `deleted_at`) VALUES
(1, 1000002, 1, NULL, 90895, 506, 0, 0, '2023-06-30', '2022-07-21', '2022-07-21 16:26:05', '2022-07-21 16:26:05', 506, NULL),
(2, 1000006, 3, NULL, 51250, 250, 0, 0, '2023-06-30', '2022-07-21', '2022-07-21 18:11:48', '2022-07-21 18:11:48', 250, NULL),
(3, 1000008, 5, NULL, 51250, 250, 0, 0, '2023-06-30', '2022-07-25', '2022-07-25 09:18:41', '2022-07-25 09:18:41', 250, NULL),
(4, 1000006, 4, NULL, 74035, 400, 0, 0, '2023-06-30', '2022-07-25', '2022-07-25 09:18:42', '2022-07-25 09:18:42', 400, NULL),
(5, 1000002, 9, NULL, 68355, 450, 0, 0, '2023-06-30', '2022-07-26', '2022-07-26 13:33:39', '2022-07-26 13:33:39', 450, NULL),
(6, 1000008, 14, NULL, 51250, 250, 0, 0, '2023-06-30', '2022-07-27', '2022-07-27 15:41:06', '2022-07-27 15:41:06', 250, NULL),
(7, 1000006, 13, NULL, 51250, 250, 0, 0, '2023-06-30', '2022-07-27', '2022-07-27 17:58:43', '2022-07-27 17:58:43', 250, NULL),
(8, 1000006, 22, NULL, 61500, 300, 0, 0, '2023-06-30', '2022-07-31', '2022-07-31 10:02:18', '2022-07-31 10:02:18', 300, NULL),
(9, 1000005, 21, NULL, 51250, 250, 0, 0, '2023-06-30', '2022-07-31', '2022-07-31 10:02:18', '2022-07-31 10:02:18', 250, NULL),
(10, 1000008, 20, NULL, 119605, 700, 0, 0, '2023-06-30', '2022-07-31', '2022-07-31 10:02:18', '2022-07-31 10:02:18', 700, NULL),
(11, 1000002, 17, NULL, 56400, 180, 0, 0, '2023-06-30', '2022-07-31', '2022-07-31 10:02:18', '2022-07-31 10:02:18', 180, NULL),
(12, 1000003, 24, NULL, 136678, 725, 0, 0, '2023-06-30', '2022-07-31', '2022-07-31 16:13:45', '2022-07-31 16:13:45', 725, NULL),
(13, 1000003, 18, NULL, 51250, 250, 0, 0, '2023-06-30', '2022-07-31', '2022-07-31 17:02:55', '2022-07-31 17:02:55', 250, NULL),
(14, 1000003, 15, NULL, 64921, 340, 0, 0, '2023-06-30', '2022-07-31', '2022-07-31 17:10:02', '2022-07-31 17:10:02', 340, NULL),
(15, 1000006, 29, NULL, 51250, 250, 0, 0, '2023-06-30', '2022-08-01', '2022-08-01 13:04:10', '2022-08-01 14:35:17', 250, '2022-08-01 14:35:17'),
(16, 1000008, 26, NULL, 348500, 1700, 0, 0, '2023-06-30', '2022-08-01', '2022-08-01 13:04:10', '2022-08-01 13:04:10', 1700, NULL),
(17, 1000021, 27, NULL, 102500, 500, 0, 0, '2023-06-30', '2022-08-01', '2022-08-01 13:05:54', '2022-08-01 13:05:54', 500, NULL),
(18, 1000006, 32, NULL, 51250, 250, 0, 0, '2023-06-30', '2022-08-01', '2022-08-01 19:29:02', '2022-08-01 19:29:02', 250, NULL),
(19, 1000021, 42, NULL, 40450, 250, 0, 0, '2023-06-30', '2022-08-03', '2022-08-03 11:33:39', '2022-08-03 11:33:39', 250, NULL),
(20, 1000003, 57, NULL, 20500, 100, 0, 0, '2023-06-30', '2022-08-03', '2022-08-03 14:37:39', '2022-08-03 14:37:39', 100, NULL),
(21, 1000006, 55, NULL, 20500, 100, 0, 0, '2023-06-30', '2022-08-04', '2022-08-04 09:33:55', '2022-08-04 09:33:55', 100, NULL),
(22, 1000023, 63, NULL, 20500, 100, 0, 0, '2023-06-30', '2022-08-04', '2022-08-04 09:34:13', '2022-08-04 09:34:13', 100, NULL),
(23, 1000020, 61, NULL, 20500, 100, 0, 0, '2023-06-30', '2022-08-04', '2022-08-04 09:35:45', '2022-08-04 09:35:45', 100, NULL),
(24, 1000007, 60, NULL, 20500, 100, 0, 0, '2023-06-30', '2022-08-04', '2022-08-04 09:35:45', '2022-08-04 09:35:45', 100, NULL),
(25, 1000017, 59, NULL, 20500, 100, 0, 0, '2023-06-30', '2022-08-04', '2022-08-04 09:35:46', '2022-08-04 09:35:46', 100, NULL),
(26, 1000024, 58, NULL, 20500, 100, 0, 0, '2023-06-30', '2022-08-04', '2022-08-04 09:35:46', '2022-08-04 09:35:46', 100, NULL),
(27, 1000022, 56, NULL, 20500, 100, 0, 0, '2023-06-30', '2022-08-04', '2022-08-04 09:36:43', '2022-08-04 09:36:43', 100, NULL),
(28, 1000008, 76, NULL, 455700, 3000, 0, 0, '2023-06-30', '2022-08-07', '2022-08-07 10:39:18', '2022-08-07 10:39:18', 3000, NULL),
(29, 1000024, 75, NULL, 45570, 300, 0, 0, '2023-06-30', '2022-08-07', '2022-08-07 10:39:18', '2022-08-07 10:39:18', 300, NULL),
(30, 1000002, 74, NULL, 113925, 750, 0, 0, '2023-06-30', '2022-08-09', '2022-08-09 11:12:16', '2022-08-09 11:12:16', 750, NULL),
(31, 1000002, 79, NULL, 91140, 600, 0, 0, '2023-06-30', '2022-08-10', '2022-08-10 12:49:54', '2022-08-10 12:57:09', 600, '2022-08-10 12:57:09'),
(32, 1000002, 86, NULL, 39900, 300, 0, 0, '2023-06-30', '2022-08-14', '2022-08-14 18:13:51', '2022-08-14 18:13:51', 300, NULL),
(33, 1000003, 84, NULL, 40828, 275, 0, 0, '2023-06-30', '2022-08-14', '2022-08-14 18:14:06', '2022-08-14 18:14:06', 275, NULL),
(34, 1000002, 91, NULL, 210075, 1369, 0, 0, '2023-06-30', '2022-08-21', '2022-08-21 17:12:39', '2022-08-21 17:12:39', 1369, NULL),
(35, 1000003, 92, NULL, 68355, 450, 0, 0, '2023-06-30', '2022-08-23', '2022-08-23 16:30:51', '2022-08-23 16:30:51', 450, NULL),
(36, 1000003, 93, NULL, 13300, 100, 0, 0, '2023-06-30', '2022-08-31', '2022-08-31 16:51:49', '2022-08-31 16:51:49', 100, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_promo`
--

CREATE TABLE `user_promo` (
  `promo_id` int(10) UNSIGNED NOT NULL,
  `use_date` datetime DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_promo`
--

INSERT INTO `user_promo` (`promo_id`, `use_date`, `phone`, `user_id`) VALUES
(170, '2021-11-21 12:17:50', '01095594471', NULL),
(171, '2021-11-21 14:43:56', '01095594471', NULL),
(172, '2021-11-21 14:44:26', '01095594471', NULL),
(176, '2022-03-16 14:05:44', '01286730601', 1000002),
(176, '2022-03-16 14:08:24', '01286730601', 1000002),
(176, '2022-03-22 14:23:22', '01223976087', NULL),
(178, '2022-04-04 10:35:44', '01000481804', 1000004),
(179, '2022-04-10 11:03:00', '01000481804', 1000004),
(180, '2022-04-10 12:32:24', '01000481804', 1000004),
(182, '2022-04-12 16:37:18', '01283664243', 1000003),
(181, '2022-04-14 10:47:25', '01000481804', 1000004),
(183, '2022-04-19 14:10:35', '01283664243', 1000003);

-- --------------------------------------------------------

--
-- Table structure for table `user_redeems`
--

CREATE TABLE `user_redeems` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `reward_id` bigint(20) UNSIGNED NOT NULL,
  `promo_id` int(10) UNSIGNED DEFAULT NULL,
  `points_used` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_redeems`
--

INSERT INTO `user_redeems` (`id`, `user_id`, `reward_id`, `promo_id`, `points_used`, `status`, `created_at`, `updated_at`) VALUES
(72, 1000004, 26, NULL, 18, 1, '2022-03-31 11:29:26', '2022-04-04 11:57:02'),
(73, 1000004, 23, 178, 50, 1, '2022-03-31 11:30:40', '2022-07-18 13:42:25'),
(74, 1000004, 23, 179, 50, 1, '2022-03-31 11:30:47', '2022-07-18 13:42:23'),
(75, 1000004, 23, 180, 50, 1, '2022-03-31 11:31:39', '2022-07-18 13:42:21'),
(76, 1000004, 23, 181, 50, 1, '2022-04-04 11:45:17', '2022-07-18 13:43:57'),
(77, 1000003, 23, 182, 50, 1, '2022-04-04 11:49:00', '2022-07-18 13:43:53'),
(78, 1000003, 23, 183, 50, 1, '2022-04-04 12:10:37', '2022-07-18 13:43:51'),
(79, 1000004, 23, 184, 50, 1, '2022-04-04 12:12:51', '2022-07-18 13:43:48'),
(80, 1000003, 23, 185, 50, 1, '2022-04-04 12:18:53', '2022-07-18 13:43:45'),
(81, 1000003, 23, 186, 50, 1, '2022-04-04 12:53:42', '2022-07-18 13:43:42'),
(82, 1000003, 23, 187, 50, 1, '2022-04-04 12:56:52', '2022-07-18 13:44:00'),
(83, 1000004, 23, 188, 50, 1, '2022-04-04 13:51:12', '2022-07-18 13:44:04'),
(84, 1000004, 23, 189, 50, 1, '2022-04-04 13:53:25', '2022-07-18 13:44:07'),
(85, 1000004, 23, 190, 50, 1, '2022-04-04 13:54:32', '2022-07-18 13:44:11'),
(86, 1000004, 23, 191, 50, 1, '2022-04-04 14:02:30', '2022-07-18 13:43:36'),
(87, 1000004, 23, 192, 50, 1, '2022-04-04 14:06:28', '2022-07-18 13:43:33'),
(88, 1000004, 23, 193, 50, 1, '2022-04-04 14:09:10', '2022-07-18 13:43:31'),
(89, 1000004, 23, 194, 50, 1, '2022-04-04 14:34:16', '2022-07-18 13:43:28'),
(90, 1000003, 23, 195, 50, 1, '2022-04-05 11:28:50', '2022-07-18 13:43:26'),
(91, 1000003, 26, NULL, 18, 1, '2022-04-05 11:29:34', '2022-07-18 13:43:24'),
(92, 1000003, 23, 196, 50, 1, '2022-04-05 13:14:11', '2022-07-18 13:43:21'),
(93, 1000003, 23, 197, 50, 1, '2022-04-05 13:14:24', '2022-07-18 13:43:17'),
(97, 1000004, 24, NULL, 9000, 1, '2022-04-10 12:54:01', '2022-07-18 13:43:15'),
(98, 1000004, 24, NULL, 9000, 1, '2022-04-10 12:56:58', '2022-07-18 13:43:13'),
(99, 1000004, 23, 199, 50, 1, '2022-04-10 12:57:22', '2022-07-18 13:42:49'),
(100, 1000004, 23, 200, 50, 1, '2022-04-11 12:47:44', '2022-07-18 13:42:46'),
(101, 1000004, 23, 201, 50, 1, '2022-04-11 12:49:01', '2022-07-18 13:42:44'),
(102, 1000004, 23, 202, 50, 1, '2022-04-11 12:58:00', '2022-07-18 13:42:42'),
(103, 1000004, 23, 203, 50, 1, '2022-04-11 13:03:54', '2022-07-18 13:42:40'),
(104, 1000004, 23, 204, 50, 1, '2022-04-11 13:06:00', '2022-07-18 13:42:52'),
(105, 1000004, 23, 205, 50, 1, '2022-04-11 13:08:01', '2022-07-18 13:42:54'),
(106, 1000004, 23, 206, 50, 1, '2022-04-11 13:11:59', '2022-07-18 13:42:57'),
(107, 1000004, 23, 207, 50, 1, '2022-04-11 13:13:19', '2022-07-18 13:42:59'),
(108, 1000004, 23, 208, 50, 1, '2022-04-11 13:16:51', '2022-07-18 13:43:03'),
(109, 1000004, 23, 209, 50, 1, '2022-04-11 13:19:17', '2022-07-18 13:42:00'),
(110, 1000004, 23, 210, 50, 1, '2022-04-11 13:23:37', '2022-07-18 13:41:58'),
(111, 1000003, 23, NULL, 50, 1, '2022-04-12 11:36:52', '2022-07-18 13:41:56'),
(114, 1000004, 23, NULL, 50, 1, '2022-04-14 10:49:08', '2022-07-18 13:41:52'),
(115, 1000004, 23, NULL, 50, 1, '2022-04-14 11:25:08', '2022-07-18 13:41:50'),
(116, 1000004, 24, NULL, 9000, 1, '2022-04-14 12:37:27', '2022-07-18 13:41:47'),
(117, 1000004, 23, NULL, 50, 1, '2022-04-14 12:38:12', '2022-07-18 13:41:39'),
(118, 1000004, 24, NULL, 9000, 1, '2022-04-17 10:29:16', '2022-07-18 13:41:37'),
(119, 1000004, 24, NULL, 9000, 1, '2022-04-17 10:29:22', '2022-07-18 13:41:35'),
(144, 1000003, 24, NULL, 9000, 1, '2022-06-12 12:50:35', '2022-06-12 12:51:29'),
(145, 1000003, 23, NULL, 50, 1, '2022-07-18 13:33:11', '2022-07-18 13:41:32');

-- --------------------------------------------------------

--
-- Table structure for table `user_settings`
--

CREATE TABLE `user_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `language` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en',
  `notify_general` tinyint(1) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_settings`
--

INSERT INTO `user_settings` (`id`, `language`, `notify_general`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'en', 0, 1004845, NULL, NULL),
(2, 'en', 0, 1004869, '2020-04-26 10:15:17', '2020-04-26 10:25:57'),
(3, 'en', 0, 1004848, '2020-04-27 14:35:32', '2020-04-30 10:49:15'),
(4, 'en', 0, 1004876, '2020-05-04 21:29:39', '2020-05-09 23:27:44'),
(5, 'ar', 0, 1004880, '2020-05-04 22:47:50', '2020-05-04 22:47:53'),
(6, 'ar', 0, 1004882, '2020-05-04 23:18:13', '2020-05-04 23:18:40'),
(7, 'en', 0, 999999, '2020-05-05 10:58:33', '2022-10-30 09:23:28'),
(8, 'ar', 0, 1008503, '2020-05-14 13:58:26', '2020-05-14 21:43:46'),
(9, 'en', 0, 1008504, '2020-05-14 21:43:48', '2020-05-14 21:45:47'),
(10, 'ar', 0, 1008533, '2020-05-20 22:46:08', '2020-05-20 22:46:08'),
(11, 'ar', 0, 1004875, '2020-05-21 11:27:33', '2020-05-21 11:27:33'),
(12, 'ar', 0, 1008535, '2020-05-21 12:00:48', '2020-05-21 12:00:48'),
(13, 'ar', 0, 1008552, '2020-05-23 17:51:29', '2020-05-23 17:51:29'),
(14, 'ar', 0, 1008546, '2020-05-23 19:24:57', '2020-05-23 19:24:57'),
(15, 'ar', 0, 1008548, '2020-05-24 12:31:27', '2020-05-24 12:31:27'),
(16, 'en', 0, 1008561, '2020-05-26 23:16:11', '2020-05-26 23:16:18'),
(17, 'ar', 0, 1008563, '2020-05-27 15:32:23', '2020-05-27 15:32:23'),
(18, 'en', 0, 1015303, '2020-10-18 23:18:36', '2020-10-18 23:18:36'),
(19, 'en', 0, 1015304, '2020-10-19 11:46:23', '2020-10-19 11:48:21'),
(20, 'en', 0, 1008653, '2020-10-19 11:48:12', '2021-02-17 20:42:14'),
(21, 'en', 0, 1015314, '2020-12-07 16:09:01', '2021-02-18 10:54:51'),
(22, 'en', 0, 1015309, '2020-12-10 22:58:22', '2020-12-15 16:07:43'),
(23, 'en', 0, 1015322, '2020-12-29 11:35:30', '2020-12-29 11:35:30'),
(24, 'ar', 0, 1015323, '2020-12-29 17:43:42', '2020-12-29 17:45:36'),
(25, 'ar', 0, 1015318, '2020-12-29 19:03:28', '2021-02-11 18:54:04'),
(26, 'en', 0, 1015324, '2020-12-29 23:36:36', '2020-12-29 23:36:36'),
(27, 'en', 0, 1015326, '2020-12-31 09:07:42', '2020-12-31 09:07:42'),
(28, 'en', 0, 1015327, '2021-01-03 00:28:38', '2021-01-03 00:28:38'),
(29, 'en', 0, 1015328, '2021-01-04 21:19:15', '2021-01-04 21:19:15'),
(30, 'en', 0, 1015307, '2021-01-28 22:34:02', '2021-02-18 19:53:29'),
(31, 'en', 0, 1015321, '2021-01-29 13:44:23', '2021-02-18 18:31:52'),
(32, 'en', 0, 1015346, '2021-01-30 17:50:16', '2021-02-01 00:01:57'),
(33, 'en', 0, 1015342, '2021-01-31 11:24:36', '2021-02-02 12:50:52'),
(34, 'en', 0, 1015312, '2021-01-31 12:55:34', '2021-02-18 19:26:18'),
(35, 'en', 0, 1015313, '2021-01-31 16:27:50', '2021-02-11 16:20:41'),
(36, 'en', 0, 1015333, '2021-01-31 16:45:34', '2021-01-31 18:01:02'),
(37, 'en', 0, 1015347, '2021-01-31 19:19:23', '2021-01-31 19:19:23'),
(38, 'en', 0, 1015310, '2021-01-31 20:25:06', '2021-02-16 20:31:06'),
(39, 'ar', 0, 1015348, '2021-02-01 21:23:01', '2021-02-01 21:24:24'),
(40, 'ar', 0, 1015343, '2021-02-03 13:28:49', '2021-02-03 13:49:12'),
(41, 'en', 0, 1015349, '2021-02-03 22:13:40', '2021-02-03 22:13:40'),
(42, 'en', 0, 1015350, '2021-02-04 11:30:58', '2021-02-04 11:30:58'),
(43, 'en', 0, 1015320, '2021-02-04 12:53:51', '2021-02-04 12:53:51'),
(44, 'en', 0, 1015351, '2021-02-04 12:54:52', '2021-02-04 12:54:52'),
(45, 'en', 0, 1015352, '2021-02-17 13:24:27', '2021-02-18 16:19:22'),
(46, 'en', 0, 1015353, '2021-02-17 23:56:11', '2021-02-17 23:56:11'),
(47, 'en', 0, 1015354, '2021-02-18 00:09:46', '2021-02-18 00:09:46'),
(48, 'en', 0, 1015355, '2021-02-18 17:00:35', '2021-02-18 17:00:35'),
(49, 'en', 0, 1015374, '2021-02-21 10:24:09', '2021-02-21 10:24:09'),
(50, 'en', 0, 1015375, '2021-02-21 11:28:32', '2021-02-21 11:28:32'),
(51, 'en', 0, 1015376, '2021-02-21 13:49:51', '2021-09-09 15:31:20'),
(52, 'en', 0, 1015377, '2021-02-21 13:50:36', '2021-08-25 11:19:27'),
(53, 'en', 0, 1015378, '2021-02-21 14:55:44', '2021-08-17 12:52:06'),
(54, 'en', 0, 1015379, '2021-02-21 15:34:39', '2021-02-21 15:34:39'),
(55, 'en', 0, 1015380, '2021-02-21 15:37:37', '2021-02-21 15:37:37'),
(56, 'en', 0, 1015381, '2021-02-21 15:38:11', '2021-02-27 19:22:52'),
(57, 'ar', 0, 1015382, '2021-02-21 16:14:54', '2021-02-26 18:00:06'),
(58, 'en', 0, 1015383, '2021-02-21 16:51:49', '2021-04-05 17:16:27'),
(59, 'en', 0, 1015384, '2021-02-21 17:22:29', '2021-02-21 17:48:05'),
(60, 'en', 0, 1015385, '2021-02-21 18:55:46', '2021-08-17 10:55:25'),
(61, 'en', 0, 1015386, '2021-02-21 19:44:54', '2021-02-21 19:44:54'),
(62, 'en', 0, 1015387, '2021-02-21 22:44:20', '2021-02-21 22:44:20'),
(63, 'en', 0, 1015388, '2021-02-21 23:32:17', '2021-03-07 01:28:23'),
(64, 'en', 0, 1015389, '2021-02-22 00:09:05', '2021-02-22 00:09:05'),
(65, 'en', 0, 1015390, '2021-02-22 11:35:58', '2021-02-22 11:35:58'),
(66, 'en', 0, 1015391, '2021-02-22 17:43:35', '2021-02-22 17:43:35'),
(67, 'en', 0, 1015392, '2021-02-22 18:41:02', '2021-08-30 13:25:54'),
(68, 'ar', 0, 1015393, '2021-02-22 19:37:22', '2021-07-06 15:12:21'),
(69, 'en', 0, 1015394, '2021-02-23 01:11:22', '2021-02-23 01:11:22'),
(70, 'en', 0, 1015395, '2021-02-23 10:06:44', '2021-02-23 10:06:44'),
(71, 'en', 0, 1015396, '2021-02-23 10:17:41', '2021-09-07 18:24:09'),
(72, 'en', 0, 1015397, '2021-02-23 13:59:30', '2021-02-23 14:00:07'),
(73, 'en', 0, 1015398, '2021-02-23 14:36:19', '2021-02-23 14:36:19'),
(74, 'ar', 0, 1015399, '2021-02-23 14:45:32', '2021-04-28 13:10:56'),
(75, 'en', 0, 1015401, '2021-02-23 17:12:41', '2021-02-23 17:12:41'),
(76, 'ar', 0, 1015402, '2021-02-23 18:58:33', '2021-02-23 18:59:23'),
(77, 'ar', 0, 1015403, '2021-02-23 19:45:08', '2021-02-23 19:46:42'),
(78, 'en', 0, 1015403, '2021-02-23 21:07:23', '2021-02-23 21:07:23'),
(79, 'ar', 0, 1015404, '2021-02-23 21:44:09', '2021-03-28 09:34:10'),
(80, 'ar', 0, 1015405, '2021-02-23 22:30:45', '2021-02-23 22:36:01'),
(81, 'en', 0, 1015406, '2021-02-23 23:31:01', '2021-07-11 17:26:51'),
(82, 'en', 0, 1015407, '2021-02-23 23:36:42', '2021-02-23 23:36:42'),
(83, 'en', 0, 1015408, '2021-02-24 01:16:50', '2021-02-24 01:16:50'),
(84, 'ar', 0, 1015409, '2021-02-24 10:43:25', '2021-02-24 10:58:53'),
(85, 'en', 0, 1015410, '2021-02-24 13:53:23', '2021-02-24 13:53:23'),
(86, 'en', 0, 1015411, '2021-02-24 14:05:18', '2021-02-24 14:05:18'),
(87, 'ar', 0, 1015412, '2021-02-24 19:10:39', '2021-02-24 19:11:12'),
(88, 'en', 0, 1015413, '2021-02-24 20:20:05', '2021-06-28 09:39:00'),
(89, 'ar', 0, 1015414, '2021-02-25 00:14:37', '2021-02-25 00:14:59'),
(90, 'en', 0, 1015415, '2021-02-25 07:20:31', '2021-02-25 07:20:31'),
(91, 'ar', 0, 1015416, '2021-02-25 10:58:20', '2021-02-25 10:59:31'),
(92, 'en', 0, 1015418, '2021-02-25 14:04:35', '2021-02-25 14:04:35'),
(93, 'ar', 0, 1015419, '2021-02-25 14:05:13', '2021-04-25 01:52:52'),
(94, 'en', 0, 1015420, '2021-02-25 14:06:48', '2021-02-25 14:06:48'),
(95, 'ar', 0, 1015421, '2021-02-25 14:08:28', '2021-02-25 14:08:45'),
(96, 'en', 0, 1015422, '2021-02-25 14:20:44', '2021-02-25 14:20:44'),
(97, 'en', 0, 1015423, '2021-02-25 14:22:48', '2021-02-25 14:22:48'),
(98, 'ar', 0, 1015424, '2021-02-25 14:29:13', '2021-02-25 14:30:44'),
(99, 'en', 0, 1015425, '2021-02-25 14:35:50', '2021-02-25 14:35:50'),
(100, 'en', 0, 1015426, '2021-02-25 14:41:01', '2021-02-25 14:41:01'),
(101, 'en', 0, 1015427, '2021-02-25 14:46:17', '2021-02-25 14:46:17'),
(102, 'en', 0, 1015428, '2021-02-25 14:46:50', '2021-02-25 14:46:50'),
(103, 'en', 0, 1015429, '2021-02-25 14:58:45', '2021-02-25 14:58:45'),
(104, 'en', 0, 1015430, '2021-02-25 15:14:14', '2021-02-25 15:14:14'),
(105, 'ar', 0, 1015431, '2021-02-25 15:17:29', '2021-02-25 15:18:09'),
(106, 'ar', 0, 1015432, '2021-02-25 15:20:27', '2021-02-25 15:20:50'),
(107, 'en', 0, 1015433, '2021-02-25 15:25:34', '2021-06-29 23:04:17'),
(108, 'en', 0, 1015434, '2021-02-25 15:30:38', '2021-02-25 15:30:38'),
(109, 'en', 0, 1015435, '2021-02-25 15:36:51', '2021-02-25 15:36:51'),
(110, 'en', 0, 1015436, '2021-02-25 15:42:57', '2021-07-08 10:56:47'),
(111, 'en', 0, 1015437, '2021-02-25 16:31:30', '2021-02-25 16:31:30'),
(112, 'en', 0, 1015438, '2021-02-25 16:42:08', '2021-02-25 16:42:08'),
(113, 'en', 0, 1015439, '2021-02-25 16:45:03', '2021-02-25 16:45:03'),
(114, 'en', 0, 1015440, '2021-02-25 16:53:48', '2021-02-25 16:53:48'),
(115, 'en', 0, 1015441, '2021-02-25 17:17:16', '2021-02-25 17:17:16'),
(116, 'en', 0, 1015442, '2021-02-25 17:27:05', '2021-02-25 17:27:05'),
(117, 'en', 0, 1015443, '2021-02-25 17:46:42', '2021-02-25 17:46:42'),
(118, 'ar', 0, 1015444, '2021-02-25 18:01:43', '2021-02-25 18:03:40'),
(119, 'ar', 0, 1015445, '2021-02-25 18:27:15', '2021-02-25 18:27:43'),
(120, 'ar', 0, 1015446, '2021-02-25 18:42:18', '2021-02-25 18:43:56'),
(121, 'en', 0, 1015447, '2021-02-25 19:07:21', '2021-02-25 19:07:21'),
(122, 'ar', 0, 1015448, '2021-02-25 19:26:07', '2021-02-25 19:27:34'),
(123, 'en', 0, 1015449, '2021-02-25 19:34:34', '2021-02-25 19:34:34'),
(124, 'en', 0, 1015450, '2021-02-25 19:37:36', '2021-02-25 19:37:36'),
(125, 'en', 0, 1015451, '2021-02-25 19:59:16', '2021-02-25 19:59:16'),
(126, 'ar', 0, 1015452, '2021-02-25 19:59:48', '2021-02-25 20:00:06'),
(127, 'en', 0, 1015453, '2021-02-25 20:36:12', '2021-02-25 20:36:12'),
(128, 'en', 0, 1015454, '2021-02-25 21:26:20', '2021-02-25 21:26:20'),
(129, 'en', 0, 1015455, '2021-02-25 21:35:25', '2021-02-25 21:35:25'),
(130, 'ar', 0, 1015456, '2021-02-25 22:12:23', '2021-02-25 22:19:25'),
(131, 'en', 0, 1015457, '2021-02-25 22:37:14', '2021-02-25 22:37:14'),
(132, 'en', 0, 1015458, '2021-02-25 22:57:43', '2021-02-25 22:57:43'),
(133, 'en', 0, 1015459, '2021-02-26 00:38:08', '2021-02-28 22:57:00'),
(134, 'ar', 0, 1015460, '2021-02-26 01:08:17', '2021-02-26 01:10:55'),
(135, 'en', 0, 1015461, '2021-02-26 01:16:12', '2021-02-26 01:16:12'),
(136, 'ar', 0, 1015462, '2021-02-26 02:18:50', '2021-02-26 22:16:15'),
(137, 'en', 0, 1015463, '2021-02-26 07:08:26', '2021-02-26 07:08:26'),
(138, 'ar', 0, 1015464, '2021-02-26 08:52:46', '2021-02-26 08:53:14'),
(139, 'ar', 0, 1015465, '2021-02-26 10:38:08', '2021-02-26 10:38:38'),
(140, 'ar', 0, 1015466, '2021-02-26 11:53:48', '2021-02-26 11:57:10'),
(141, 'ar', 0, 1015467, '2021-02-26 13:07:29', '2021-02-26 13:08:22'),
(142, 'ar', 0, 1015468, '2021-02-26 14:37:12', '2021-02-26 14:38:06'),
(143, 'en', 0, 1015466, '2021-02-26 16:16:49', '2021-02-26 16:16:49'),
(144, 'en', 0, 1015469, '2021-02-26 18:22:24', '2021-02-26 18:22:24'),
(145, 'en', 0, 1015470, '2021-02-26 19:14:18', '2021-02-26 19:14:18'),
(146, 'en', 0, 1015471, '2021-02-26 20:45:44', '2021-02-26 20:45:44'),
(147, 'en', 0, 1015472, '2021-02-26 22:28:05', '2021-03-09 18:29:34'),
(148, 'ar', 0, 1015473, '2021-02-26 23:23:14', '2021-02-26 23:26:19'),
(149, 'en', 0, 1015474, '2021-02-26 23:32:27', '2021-02-26 23:32:27'),
(150, 'en', 0, 1015475, '2021-02-26 23:32:58', '2021-02-26 23:32:58'),
(151, 'en', 0, 1015476, '2021-02-26 23:43:54', '2021-02-26 23:43:54'),
(152, 'en', 0, 1015477, '2021-02-27 01:12:58', '2021-02-27 01:12:58'),
(153, 'en', 0, 1015478, '2021-02-27 06:22:24', '2021-02-27 06:22:24'),
(154, 'en', 0, 1015479, '2021-02-27 10:52:36', '2021-02-27 10:52:36'),
(155, 'ar', 0, 1015480, '2021-02-27 15:12:46', '2021-02-27 15:22:18'),
(156, 'ar', 0, 1015481, '2021-02-27 16:36:38', '2021-02-27 16:37:59'),
(157, 'ar', 0, 1015482, '2021-02-27 16:54:49', '2021-02-27 16:55:35'),
(158, 'en', 0, 1015483, '2021-02-27 17:14:40', '2021-02-27 17:14:40'),
(159, 'en', 0, 1015484, '2021-02-27 17:24:38', '2021-02-27 17:24:38'),
(160, 'en', 0, 1015485, '2021-02-27 19:12:03', '2021-02-27 19:12:03'),
(161, 'en', 0, 1015486, '2021-02-27 19:50:53', '2021-02-27 19:50:53'),
(162, 'en', 0, 1015487, '2021-02-27 21:16:12', '2021-02-27 21:16:12'),
(163, 'en', 0, 1015488, '2021-02-27 21:43:18', '2021-02-27 21:43:18'),
(164, 'en', 0, 1015489, '2021-02-27 22:38:06', '2021-02-27 22:38:06'),
(165, 'en', 0, 1015462, '2021-02-28 00:37:17', '2021-02-28 00:37:17'),
(166, 'en', 0, 1015490, '2021-02-28 02:54:28', '2021-02-28 02:54:28'),
(167, 'en', 0, 1015491, '2021-02-28 06:33:15', '2021-02-28 06:33:15'),
(168, 'ar', 0, 1015492, '2021-02-28 07:53:43', '2021-02-28 07:54:02'),
(169, 'en', 0, 1015493, '2021-02-28 09:52:33', '2021-02-28 09:52:33'),
(170, 'ar', 0, 1015494, '2021-02-28 10:05:33', '2021-02-28 10:05:57'),
(171, 'en', 0, 1015495, '2021-02-28 10:28:30', '2021-02-28 10:28:30'),
(172, 'en', 0, 1015496, '2021-02-28 12:51:15', '2021-02-28 12:51:15'),
(173, 'ar', 0, 1015497, '2021-02-28 15:47:55', '2021-02-28 15:48:57'),
(174, 'en', 0, 1015498, '2021-02-28 19:03:18', '2021-02-28 19:03:18'),
(175, 'en', 0, 1015499, '2021-02-28 19:10:26', '2021-02-28 19:10:26'),
(176, 'en', 0, 1015500, '2021-02-28 21:42:37', '2021-02-28 21:42:37'),
(177, 'en', 0, 1015501, '2021-02-28 21:45:34', '2021-02-28 21:45:34'),
(178, 'en', 0, 1015502, '2021-02-28 22:17:18', '2021-02-28 22:17:18'),
(179, 'en', 0, 1015503, '2021-02-28 22:24:56', '2021-02-28 22:24:56'),
(180, 'en', 0, 1015504, '2021-02-28 23:00:40', '2021-02-28 23:00:40'),
(181, 'en', 0, 1015505, '2021-02-28 23:25:59', '2021-02-28 23:25:59'),
(182, 'ar', 0, 1015506, '2021-02-28 23:57:31', '2021-03-10 03:13:27'),
(183, 'ar', 0, 1015507, '2021-03-01 11:49:31', '2021-03-01 11:50:37'),
(184, 'en', 0, 1015482, '2021-03-01 12:04:52', '2021-03-01 12:04:52'),
(185, 'ar', 0, 1015508, '2021-03-01 14:25:51', '2021-03-01 14:27:51'),
(186, 'en', 0, 1015509, '2021-03-01 16:39:56', '2021-03-01 16:39:56'),
(187, 'en', 0, 1015510, '2021-03-01 18:20:23', '2021-03-01 18:20:23'),
(188, 'en', 0, 1015511, '2021-03-01 19:28:51', '2021-03-01 19:28:51'),
(189, 'en', 0, 1015512, '2021-03-01 21:31:01', '2021-03-01 21:31:01'),
(190, 'en', 0, 1015513, '2021-03-01 21:57:58', '2021-03-01 21:57:58'),
(191, 'ar', 0, 1015514, '2021-03-01 22:07:14', '2021-03-01 22:09:15'),
(192, 'en', 0, 1015515, '2021-03-01 22:26:14', '2021-03-01 22:26:14'),
(193, 'en', 0, 1015516, '2021-03-01 23:03:31', '2021-03-01 23:03:31'),
(194, 'en', 0, 1015517, '2021-03-02 03:03:37', '2021-03-02 03:03:37'),
(195, 'en', 0, 1015518, '2021-03-02 03:24:32', '2021-03-02 03:24:32'),
(196, 'ar', 0, 1015519, '2021-03-02 03:31:43', '2021-03-02 03:32:09'),
(197, 'ar', 0, 1015520, '2021-03-02 03:47:47', '2021-04-06 19:25:03'),
(198, 'en', 0, 1015521, '2021-03-02 05:05:52', '2021-03-02 05:05:52'),
(199, 'en', 0, 1015522, '2021-03-02 07:29:32', '2021-03-02 07:29:32'),
(200, 'ar', 0, 1015523, '2021-03-02 07:56:12', '2021-03-02 07:56:48'),
(201, 'ar', 0, 1015524, '2021-03-02 08:56:54', '2021-03-02 08:57:11'),
(202, 'en', 0, 1015525, '2021-03-02 09:02:14', '2021-03-02 09:02:14'),
(203, 'en', 0, 1015526, '2021-03-02 10:38:11', '2021-03-02 10:38:11'),
(204, 'en', 0, 1015527, '2021-03-02 11:04:43', '2021-03-02 11:04:43'),
(205, 'en', 0, 1015528, '2021-03-02 11:24:06', '2021-03-02 11:24:06'),
(206, 'ar', 0, 1015529, '2021-03-02 12:07:19', '2021-03-02 12:10:40'),
(207, 'ar', 0, 1015530, '2021-03-02 12:13:59', '2021-03-02 12:14:57'),
(208, 'ar', 0, 1015531, '2021-03-02 12:34:34', '2021-03-02 12:59:01'),
(209, 'en', 0, 1015532, '2021-03-02 13:56:36', '2021-03-02 13:56:36'),
(210, 'en', 0, 1015533, '2021-03-02 14:10:56', '2021-03-02 14:12:13'),
(211, 'en', 0, 1015534, '2021-03-02 14:16:09', '2021-03-02 14:16:09'),
(212, 'ar', 0, 1015535, '2021-03-02 15:02:02', '2021-03-02 15:07:53'),
(213, 'en', 0, 1015536, '2021-03-02 16:01:01', '2021-03-02 16:01:01'),
(214, 'ar', 0, 1015537, '2021-03-02 16:01:51', '2021-03-02 16:02:26'),
(215, 'en', 0, 1015538, '2021-03-02 16:41:46', '2021-03-02 16:41:46'),
(216, 'en', 0, 1015539, '2021-03-02 17:10:06', '2021-03-02 17:10:06'),
(217, 'en', 0, 1015385, '2021-03-02 19:37:25', '2021-03-02 19:37:25'),
(218, 'en', 0, 1015540, '2021-03-02 20:19:23', '2021-03-02 20:19:23'),
(219, 'en', 0, 1015541, '2021-03-02 20:50:53', '2021-03-02 20:50:53'),
(220, 'en', 0, 1015542, '2021-03-02 21:56:17', '2021-03-02 21:56:17'),
(221, 'ar', 0, 1015543, '2021-03-02 22:05:48', '2021-03-02 22:06:29'),
(222, 'en', 0, 1015544, '2021-03-02 23:02:26', '2021-03-02 23:02:26'),
(223, 'en', 0, 1015545, '2021-03-02 23:10:01', '2021-03-02 23:10:01'),
(224, 'ar', 0, 1015546, '2021-03-02 23:35:00', '2021-03-02 23:37:04'),
(225, 'ar', 0, 1015547, '2021-03-03 01:29:36', '2021-03-03 01:56:46'),
(226, 'en', 0, 1015548, '2021-03-03 01:33:29', '2021-03-03 01:33:29'),
(227, 'en', 0, 1015537, '2021-03-03 02:04:30', '2021-03-03 02:04:30'),
(228, 'en', 0, 1015549, '2021-03-03 02:33:12', '2021-03-03 02:33:12'),
(229, 'en', 0, 1015547, '2021-03-03 05:06:49', '2021-03-03 05:06:49'),
(230, 'ar', 0, 1015550, '2021-03-03 09:53:18', '2021-03-03 09:53:43'),
(231, 'en', 0, 1015551, '2021-03-03 10:03:57', '2021-03-03 10:03:57'),
(232, 'en', 0, 1015552, '2021-03-03 10:56:20', '2021-08-29 16:49:07'),
(233, 'en', 0, 1015553, '2021-03-03 11:58:11', '2021-03-03 11:58:11'),
(234, 'ar', 0, 1015554, '2021-03-03 13:02:18', '2021-03-03 13:03:55'),
(235, 'en', 0, 1015555, '2021-03-03 13:48:51', '2021-03-03 13:48:51'),
(236, 'ar', 0, 1015556, '2021-03-03 14:32:49', '2021-03-03 14:35:47'),
(237, 'en', 0, 1015557, '2021-03-03 14:53:06', '2021-03-03 14:53:06'),
(238, 'en', 0, 1015558, '2021-03-03 14:57:43', '2021-03-03 14:57:43'),
(239, 'en', 0, 1015559, '2021-03-03 16:20:35', '2021-03-03 16:20:35'),
(240, 'en', 0, 1015560, '2021-03-03 19:13:39', '2021-03-03 19:13:39'),
(241, 'ar', 0, 1015561, '2021-03-03 19:31:20', '2021-03-03 19:32:50'),
(242, 'en', 0, 1015562, '2021-03-03 19:44:36', '2021-03-03 19:44:36'),
(243, 'en', 0, 1015563, '2021-03-03 20:24:50', '2021-03-03 20:24:50'),
(244, 'en', 0, 1015564, '2021-03-03 20:27:03', '2021-03-03 20:27:03'),
(245, 'en', 0, 1015565, '2021-03-03 20:53:48', '2021-03-03 20:53:48'),
(246, 'en', 0, 1015566, '2021-03-03 22:12:50', '2021-03-03 22:12:50'),
(247, 'en', 0, 1015567, '2021-03-03 22:50:56', '2021-03-03 22:50:56'),
(248, 'ar', 0, 1015568, '2021-03-03 23:28:38', '2021-03-03 23:29:37'),
(249, 'en', 0, 1015569, '2021-03-04 00:19:13', '2021-03-04 00:19:13'),
(250, 'en', 0, 1015570, '2021-03-04 00:37:27', '2021-07-05 11:28:48'),
(251, 'ar', 0, 1015571, '2021-03-04 01:17:40', '2021-03-04 01:22:11'),
(252, 'en', 0, 1015572, '2021-03-04 02:26:54', '2021-03-04 02:26:54'),
(253, 'en', 0, 1015573, '2021-03-04 06:17:12', '2021-03-04 06:17:12'),
(254, 'ar', 0, 1015574, '2021-03-04 09:06:13', '2021-03-04 09:06:45'),
(255, 'en', 0, 1015575, '2021-03-04 09:30:05', '2021-03-04 09:30:05'),
(256, 'en', 0, 1015576, '2021-03-04 09:49:20', '2021-03-04 09:49:20'),
(257, 'ar', 0, 1015577, '2021-03-04 11:08:36', '2021-03-04 11:08:54'),
(258, 'en', 0, 1015578, '2021-03-04 16:51:59', '2021-03-04 16:51:59'),
(259, 'en', 0, 1015579, '2021-03-04 17:11:18', '2021-03-04 17:11:18'),
(260, 'en', 0, 1015580, '2021-03-04 18:43:20', '2021-03-04 18:43:20'),
(261, 'ar', 0, 1015581, '2021-03-04 18:44:19', '2021-03-04 18:44:48'),
(262, 'en', 0, 1015582, '2021-03-04 18:57:19', '2021-03-04 18:57:19'),
(263, 'en', 0, 1015583, '2021-03-04 19:16:20', '2021-03-04 19:16:20'),
(264, 'en', 0, 1015584, '2021-03-04 19:21:22', '2021-03-04 19:21:22'),
(265, 'en', 0, 1015585, '2021-03-04 19:23:39', '2021-03-04 19:23:39'),
(266, 'en', 0, 1015586, '2021-03-04 19:46:02', '2021-03-04 19:46:02'),
(267, 'en', 0, 1015587, '2021-03-04 21:27:22', '2021-03-04 21:27:22'),
(268, 'ar', 0, 1015588, '2021-03-04 22:08:11', '2021-03-04 22:08:43'),
(269, 'en', 0, 1015589, '2021-03-04 22:36:21', '2021-03-04 22:36:21'),
(270, 'en', 0, 1015590, '2021-03-04 23:22:46', '2021-03-04 23:22:46'),
(271, 'ar', 0, 1015591, '2021-03-04 23:50:47', '2021-03-04 23:54:15'),
(272, 'en', 0, 1015592, '2021-03-05 00:54:54', '2021-03-05 00:54:54'),
(273, 'en', 0, 1015593, '2021-03-05 01:00:06', '2021-03-05 01:00:06'),
(274, 'en', 0, 1015594, '2021-03-05 01:16:59', '2021-03-05 01:16:59'),
(275, 'en', 0, 1015595, '2021-03-05 04:28:19', '2021-03-05 04:28:19'),
(276, 'en', 0, 1015596, '2021-03-05 08:27:21', '2021-03-05 08:27:21'),
(277, 'ar', 0, 1015597, '2021-03-05 09:18:44', '2021-03-05 09:40:20'),
(278, 'en', 0, 1015597, '2021-03-05 09:47:33', '2021-03-05 09:47:33'),
(279, 'en', 0, 1015598, '2021-03-05 10:39:05', '2021-03-05 10:39:05'),
(280, 'en', 0, 1015599, '2021-03-05 11:35:14', '2021-03-05 11:35:14'),
(281, 'en', 0, 1015600, '2021-03-05 12:54:05', '2021-03-05 12:54:05'),
(282, 'en', 0, 1015601, '2021-03-05 13:45:38', '2021-03-05 13:45:38'),
(283, 'ar', 0, 1015602, '2021-03-05 16:40:47', '2021-03-05 16:48:44'),
(284, 'en', 0, 1015603, '2021-03-05 18:22:28', '2021-03-05 18:22:28'),
(285, 'ar', 0, 1015604, '2021-03-05 18:56:15', '2021-03-05 18:57:58'),
(286, 'en', 0, 1015605, '2021-03-05 21:26:52', '2021-03-05 21:26:52'),
(287, 'ar', 0, 1015606, '2021-03-06 00:40:59', '2021-03-06 00:41:33'),
(288, 'en', 0, 1015607, '2021-03-06 00:49:14', '2021-03-06 00:49:14'),
(289, 'en', 0, 1015608, '2021-03-06 04:26:31', '2021-03-06 04:26:31'),
(290, 'en', 0, 1015609, '2021-03-06 10:31:44', '2021-03-06 10:31:44'),
(291, 'en', 0, 1015610, '2021-03-06 14:23:25', '2021-03-06 14:23:25'),
(292, 'en', 0, 1015611, '2021-03-06 16:05:08', '2021-03-06 16:05:08'),
(293, 'en', 0, 1015612, '2021-03-06 16:29:50', '2021-03-06 16:29:50'),
(294, 'en', 0, 1015613, '2021-03-06 16:40:31', '2021-03-06 16:40:31'),
(295, 'en', 0, 1015614, '2021-03-06 17:29:21', '2021-03-06 17:29:21'),
(296, 'en', 0, 1015615, '2021-03-06 18:26:19', '2021-03-06 18:26:19'),
(297, 'en', 0, 1015616, '2021-03-06 18:56:08', '2021-03-06 18:56:08'),
(298, 'en', 0, 1015617, '2021-03-06 20:11:56', '2021-03-06 20:11:56'),
(299, 'en', 0, 1015618, '2021-03-06 22:02:46', '2021-03-06 22:02:46'),
(300, 'ar', 0, 1015619, '2021-03-06 23:46:09', '2021-03-07 13:07:39'),
(301, 'en', 0, 1015620, '2021-03-07 01:47:30', '2021-03-07 01:47:30'),
(302, 'en', 0, 1015621, '2021-03-07 02:37:07', '2021-03-07 02:37:07'),
(303, 'en', 0, 1015622, '2021-03-07 06:28:08', '2021-03-07 06:28:08'),
(304, 'en', 0, 1015623, '2021-03-07 14:43:40', '2021-03-07 14:43:40'),
(305, 'en', 0, 1015624, '2021-03-07 15:25:52', '2021-03-07 15:25:52'),
(306, 'en', 0, 1015625, '2021-03-07 15:35:37', '2021-03-07 15:35:37'),
(307, 'en', 0, 1015626, '2021-03-07 15:38:41', '2021-03-07 15:38:41'),
(308, 'en', 0, 1015627, '2021-03-07 16:16:50', '2021-03-07 16:16:50'),
(309, 'en', 0, 1015628, '2021-03-07 16:29:25', '2021-03-07 16:29:25'),
(310, 'ar', 0, 1015629, '2021-03-07 19:25:22', '2021-03-07 19:26:17'),
(311, 'en', 0, 1015456, '2021-03-07 20:02:22', '2021-03-07 20:02:22'),
(312, 'en', 0, 1015630, '2021-03-07 20:07:26', '2021-03-07 20:07:26'),
(313, 'ar', 0, 1015631, '2021-03-07 21:50:03', '2021-03-07 21:53:36'),
(314, 'en', 0, 1015632, '2021-03-08 13:09:45', '2021-04-27 19:27:06'),
(315, 'en', 0, 1015633, '2021-03-08 13:16:50', '2021-03-08 13:16:50'),
(316, 'en', 0, 1015634, '2021-03-08 18:45:16', '2021-03-08 18:45:16'),
(317, 'en', 0, 1015635, '2021-03-08 19:00:32', '2021-03-08 19:00:32'),
(318, 'en', 0, 1015636, '2021-03-08 20:05:43', '2021-03-08 20:05:43'),
(319, 'en', 0, 1015637, '2021-03-09 03:48:56', '2021-03-09 03:48:56'),
(320, 'ar', 0, 1015638, '2021-03-09 05:51:57', '2021-03-09 06:13:04'),
(321, 'en', 0, 1015639, '2021-03-09 07:56:19', '2021-03-09 07:56:19'),
(322, 'en', 0, 1015640, '2021-03-09 13:00:41', '2021-03-09 13:00:41'),
(323, 'en', 0, 1015641, '2021-03-09 14:42:58', '2021-03-09 14:42:58'),
(324, 'ar', 0, 1015642, '2021-03-09 15:13:58', '2021-03-09 15:14:47'),
(325, 'ar', 0, 1015643, '2021-03-09 16:53:07', '2021-03-09 16:53:40'),
(326, 'en', 0, 1015644, '2021-03-09 19:09:51', '2021-03-09 19:09:51'),
(327, 'ar', 0, 1015645, '2021-03-09 22:40:28', '2021-03-09 22:41:45'),
(328, 'en', 0, 1015646, '2021-03-10 05:13:56', '2021-03-10 05:13:56'),
(329, 'ar', 0, 1015647, '2021-03-10 06:32:27', '2021-03-18 17:51:11'),
(330, 'en', 0, 1015648, '2021-03-10 13:58:41', '2021-03-10 13:58:41'),
(331, 'en', 0, 1015649, '2021-03-10 16:23:24', '2021-03-10 16:23:24'),
(332, 'en', 0, 1015650, '2021-03-10 17:30:45', '2021-03-10 17:30:45'),
(333, 'en', 0, 1015651, '2021-03-10 20:40:27', '2021-03-10 20:40:27'),
(334, 'en', 0, 1015652, '2021-03-10 21:58:00', '2021-03-10 21:58:00'),
(335, 'en', 0, 1015653, '2021-03-11 00:36:04', '2021-03-11 00:36:04'),
(336, 'ar', 0, 1015654, '2021-03-11 00:44:16', '2021-03-11 00:46:04'),
(337, 'en', 0, 1015655, '2021-03-11 02:30:12', '2021-03-19 18:38:29'),
(338, 'en', 0, 1015656, '2021-03-11 05:02:53', '2021-03-11 05:02:53'),
(339, 'en', 0, 1015657, '2021-03-11 08:58:18', '2021-03-11 08:58:18'),
(340, 'ar', 0, 1015658, '2021-03-11 09:13:40', '2021-03-24 14:25:45'),
(341, 'en', 0, 1015659, '2021-03-11 13:35:11', '2021-03-11 13:35:11'),
(342, 'en', 0, 1015660, '2021-03-11 15:30:17', '2021-03-14 20:37:43'),
(343, 'ar', 0, 1015661, '2021-03-11 15:59:56', '2021-03-11 16:00:38'),
(344, 'ar', 0, 1015662, '2021-03-11 21:18:49', '2021-03-15 15:27:42'),
(345, 'ar', 0, 1015663, '2021-03-11 21:31:45', '2021-03-11 21:32:50'),
(346, 'en', 0, 1015664, '2021-03-12 14:29:41', '2021-03-12 14:29:41'),
(347, 'en', 0, 1015665, '2021-03-12 14:56:18', '2021-03-12 14:56:18'),
(348, 'ar', 0, 1015666, '2021-03-12 22:45:01', '2021-03-12 22:48:33'),
(349, 'ar', 0, 1015667, '2021-03-13 01:01:23', '2021-03-15 10:55:53'),
(350, 'en', 0, 1015668, '2021-03-13 01:20:59', '2021-03-13 01:20:59'),
(351, 'en', 0, 1015669, '2021-03-13 15:06:55', '2021-03-13 15:06:55'),
(352, 'ar', 0, 1015670, '2021-03-13 15:13:44', '2021-03-13 15:14:04'),
(353, 'en', 0, 1015671, '2021-03-13 17:25:01', '2021-03-13 17:25:01'),
(354, 'ar', 0, 1015672, '2021-03-13 22:31:30', '2021-03-13 22:32:18'),
(355, 'en', 0, 1015673, '2021-03-14 00:22:40', '2021-03-14 00:22:40'),
(356, 'en', 0, 1015674, '2021-03-14 01:43:28', '2021-03-14 01:43:28'),
(357, 'en', 0, 1015675, '2021-03-14 09:10:03', '2021-03-14 09:10:03'),
(358, 'en', 0, 1015676, '2021-03-14 16:51:02', '2021-03-14 16:51:02'),
(359, 'en', 0, 1015677, '2021-03-14 17:38:25', '2021-03-14 17:38:25'),
(360, 'en', 0, 1015678, '2021-03-14 18:03:15', '2021-03-14 18:03:15'),
(361, 'en', 0, 1015679, '2021-03-14 18:11:18', '2021-03-14 18:11:18'),
(362, 'en', 0, 1015680, '2021-03-14 18:27:46', '2021-03-14 18:27:46'),
(363, 'en', 0, 1015681, '2021-03-14 20:54:11', '2021-03-14 20:54:11'),
(364, 'ar', 0, 1015682, '2021-03-14 22:57:31', '2021-03-20 20:27:43'),
(365, 'en', 0, 1015683, '2021-03-15 01:57:11', '2021-09-08 13:14:36'),
(366, 'ar', 0, 1015684, '2021-03-15 02:23:17', '2021-03-15 02:27:42'),
(367, 'ar', 0, 1015685, '2021-03-15 03:11:00', '2021-03-15 03:13:28'),
(368, 'en', 0, 1015404, '2021-03-15 09:23:29', '2021-03-15 09:23:29'),
(369, 'en', 0, 1015686, '2021-03-15 10:43:46', '2021-03-15 10:43:46'),
(370, 'en', 0, 1015687, '2021-03-15 11:34:52', '2021-03-15 11:34:52'),
(371, 'en', 0, 1015688, '2021-03-15 11:36:42', '2021-03-15 11:36:42'),
(372, 'ar', 0, 1015689, '2021-03-15 14:20:00', '2021-03-15 14:20:23'),
(373, 'en', 0, 1015690, '2021-03-15 14:26:12', '2021-03-15 14:26:12'),
(374, 'en', 0, 1015691, '2021-03-15 14:31:12', '2021-03-15 14:31:12'),
(375, 'en', 0, 1015692, '2021-03-15 15:01:52', '2021-03-15 15:01:52'),
(376, 'en', 0, 1015693, '2021-03-15 15:03:57', '2021-03-15 15:03:57'),
(377, 'en', 0, 1015694, '2021-03-15 15:26:11', '2021-03-15 15:26:11'),
(378, 'ar', 0, 1015695, '2021-03-15 15:32:34', '2021-03-15 15:35:07'),
(379, 'ar', 0, 1015696, '2021-03-15 15:44:50', '2021-03-15 15:54:20'),
(380, 'ar', 0, 1015697, '2021-03-15 16:57:09', '2021-03-15 16:58:27'),
(381, 'en', 0, 1015698, '2021-03-15 19:09:49', '2021-03-15 19:09:49'),
(382, 'en', 0, 1015699, '2021-03-15 20:18:06', '2021-03-15 20:18:06'),
(383, 'en', 0, 1015700, '2021-03-15 20:24:26', '2021-03-15 20:24:26'),
(384, 'ar', 0, 1015701, '2021-03-15 21:30:27', '2021-03-16 19:22:43'),
(385, 'ar', 0, 1015702, '2021-03-15 21:35:34', '2021-03-15 21:36:15'),
(386, 'en', 0, 1015703, '2021-03-15 22:22:32', '2021-03-15 22:22:32'),
(387, 'en', 0, 1015704, '2021-03-15 23:19:20', '2021-03-15 23:19:20'),
(388, 'ar', 0, 1015705, '2021-03-16 00:33:52', '2021-03-16 00:34:30'),
(389, 'en', 0, 1015706, '2021-03-16 00:39:34', '2021-03-16 00:39:34'),
(390, 'en', 0, 1015707, '2021-03-16 01:52:25', '2021-03-16 01:52:25'),
(391, 'en', 0, 1015708, '2021-03-16 02:34:36', '2021-03-16 02:34:36'),
(392, 'en', 0, 1015709, '2021-03-16 04:38:36', '2021-03-16 04:38:36'),
(393, 'en', 0, 1015710, '2021-03-16 06:07:34', '2021-03-16 06:07:34'),
(394, 'en', 0, 1015711, '2021-03-16 06:09:02', '2021-03-16 06:09:02'),
(395, 'en', 0, 1015712, '2021-03-16 08:07:17', '2021-03-16 08:07:17'),
(396, 'ar', 0, 1015713, '2021-03-16 08:37:16', '2021-03-16 08:38:09'),
(397, 'en', 0, 1015714, '2021-03-16 08:54:45', '2021-04-21 09:23:23'),
(398, 'en', 0, 1015715, '2021-03-16 09:09:52', '2021-03-16 09:09:52'),
(399, 'en', 0, 1015716, '2021-03-16 09:51:06', '2021-03-16 09:51:06'),
(400, 'ar', 0, 1015717, '2021-03-16 09:51:11', '2021-06-02 11:55:22'),
(401, 'en', 0, 1015718, '2021-03-16 11:08:21', '2021-03-16 11:08:21'),
(402, 'en', 0, 1015719, '2021-03-16 13:27:09', '2021-03-16 13:27:09'),
(403, 'en', 0, 1015720, '2021-03-16 14:21:12', '2021-03-16 14:21:12'),
(404, 'en', 0, 1015721, '2021-03-16 14:41:58', '2021-03-16 14:41:58'),
(405, 'ar', 0, 1015722, '2021-03-16 15:20:35', '2021-03-16 15:21:36'),
(406, 'en', 0, 1015723, '2021-03-16 15:28:21', '2021-03-16 15:28:21'),
(407, 'en', 0, 1015724, '2021-03-16 15:43:48', '2021-03-16 15:43:48'),
(408, 'en', 0, 1015725, '2021-03-16 15:54:51', '2021-03-16 15:54:51'),
(409, 'en', 0, 1015726, '2021-03-16 15:56:42', '2021-03-16 15:56:42'),
(410, 'en', 0, 1015727, '2021-03-16 16:02:43', '2021-03-16 16:02:43'),
(411, 'en', 0, 1015728, '2021-03-16 16:12:19', '2021-03-16 16:12:19'),
(412, 'ar', 0, 1015729, '2021-03-16 16:15:18', '2021-03-21 13:57:36'),
(413, 'en', 0, 1015729, '2021-03-16 16:32:13', '2021-03-16 16:32:13'),
(414, 'ar', 0, 1015730, '2021-03-16 17:02:39', '2021-03-16 17:03:17'),
(415, 'ar', 0, 1015731, '2021-03-16 17:13:27', '2021-03-16 17:13:43'),
(416, 'en', 0, 1015732, '2021-03-16 17:51:34', '2021-03-16 17:51:34'),
(417, 'en', 0, 1015733, '2021-03-16 18:20:08', '2021-03-16 18:20:08'),
(418, 'en', 0, 1015734, '2021-03-16 18:21:00', '2021-03-16 18:21:00'),
(419, 'ar', 0, 1015735, '2021-03-16 18:25:33', '2021-03-16 18:28:29'),
(420, 'en', 0, 1015736, '2021-03-16 18:25:40', '2021-03-16 18:25:40'),
(421, 'en', 0, 1015737, '2021-03-16 18:36:17', '2021-03-16 18:36:17'),
(422, 'ar', 0, 1015738, '2021-03-16 18:59:49', '2021-03-16 19:21:45'),
(423, 'en', 0, 1015739, '2021-03-16 19:20:43', '2021-03-16 19:20:43'),
(424, 'en', 0, 1015740, '2021-03-16 19:27:54', '2021-03-16 19:27:54'),
(425, 'en', 0, 1015741, '2021-03-16 20:12:35', '2021-03-16 20:12:35'),
(426, 'en', 0, 1015742, '2021-03-16 20:42:53', '2021-03-16 20:42:53'),
(427, 'en', 0, 1015743, '2021-03-16 21:05:30', '2021-03-16 21:05:30'),
(428, 'en', 0, 1015744, '2021-03-16 21:13:02', '2021-03-16 21:13:02'),
(429, 'en', 0, 1015745, '2021-03-16 21:49:00', '2021-03-16 21:49:00'),
(430, 'en', 0, 1015746, '2021-03-16 22:42:38', '2021-03-16 22:42:38'),
(431, 'en', 0, 1015747, '2021-03-16 23:19:13', '2021-03-16 23:19:13'),
(432, 'en', 0, 1015748, '2021-03-16 23:24:00', '2021-03-16 23:24:00'),
(433, 'en', 0, 1015749, '2021-03-17 00:09:42', '2021-03-17 00:09:42'),
(434, 'en', 0, 1015750, '2021-03-17 00:15:17', '2021-03-17 00:15:17'),
(435, 'en', 0, 1015751, '2021-03-17 01:24:15', '2021-03-17 01:24:15'),
(436, 'en', 0, 1015752, '2021-03-17 08:51:47', '2021-03-17 08:51:47'),
(437, 'en', 0, 1015753, '2021-03-17 11:28:19', '2021-03-17 11:28:19'),
(438, 'en', 0, 1015754, '2021-03-17 11:53:38', '2021-03-17 11:53:38'),
(439, 'en', 0, 1015755, '2021-03-17 12:00:31', '2021-03-17 12:00:31'),
(440, 'en', 0, 1015756, '2021-03-17 12:58:12', '2021-03-17 12:58:12'),
(441, 'en', 0, 1015757, '2021-03-17 13:03:36', '2021-03-17 13:03:36'),
(442, 'en', 0, 1015758, '2021-03-17 13:13:35', '2021-03-17 13:13:35'),
(443, 'en', 0, 1015759, '2021-03-17 13:50:42', '2021-03-17 13:50:42'),
(444, 'en', 0, 1015760, '2021-03-17 14:06:17', '2021-03-17 14:06:17'),
(445, 'en', 0, 1015761, '2021-03-17 14:14:59', '2021-03-17 14:17:02'),
(446, 'en', 0, 1015762, '2021-03-17 14:43:48', '2021-03-17 14:43:48'),
(447, 'ar', 0, 1015763, '2021-03-17 15:37:10', '2021-03-17 15:38:07'),
(448, 'en', 0, 1015764, '2021-03-17 16:31:43', '2021-03-17 16:31:43'),
(449, 'en', 0, 1015765, '2021-03-17 17:25:39', '2021-03-17 17:25:39'),
(450, 'ar', 0, 1015766, '2021-03-17 18:30:37', '2021-03-17 18:58:39'),
(451, 'en', 0, 1015767, '2021-03-17 20:19:40', '2021-03-17 20:19:40'),
(452, 'en', 0, 1015768, '2021-03-17 20:38:01', '2021-03-17 20:38:01'),
(453, 'en', 0, 1015769, '2021-03-17 21:00:17', '2021-03-17 21:00:17'),
(454, 'en', 0, 1015770, '2021-03-17 21:22:27', '2021-03-17 21:22:27'),
(455, 'en', 0, 1015771, '2021-03-17 22:31:05', '2021-03-17 22:31:05'),
(456, 'en', 0, 1015772, '2021-03-17 23:15:48', '2021-03-17 23:15:48'),
(457, 'en', 0, 1015773, '2021-03-17 23:51:32', '2021-03-17 23:51:32'),
(458, 'en', 0, 1015774, '2021-03-18 00:34:13', '2021-03-18 00:34:13'),
(459, 'en', 0, 1015775, '2021-03-18 01:29:43', '2021-03-18 01:29:43'),
(460, 'en', 0, 1015776, '2021-03-18 02:13:13', '2021-03-18 02:13:13'),
(461, 'en', 0, 1015777, '2021-03-18 03:25:49', '2021-03-18 03:25:49'),
(462, 'en', 0, 1015701, '2021-03-18 07:00:19', '2021-03-18 07:00:19'),
(463, 'en', 0, 1015778, '2021-03-18 10:44:41', '2021-03-18 10:44:41'),
(464, 'en', 0, 1015779, '2021-03-18 10:56:14', '2021-03-18 10:56:14'),
(465, 'en', 0, 1015780, '2021-03-18 11:09:27', '2021-03-18 11:09:27'),
(466, 'en', 0, 1015781, '2021-03-18 11:14:29', '2021-03-18 11:14:29'),
(467, 'en', 0, 1015782, '2021-03-18 11:21:28', '2021-03-18 11:21:28'),
(468, 'en', 0, 1015783, '2021-03-18 11:49:11', '2021-03-18 11:49:11'),
(469, 'en', 0, 1015784, '2021-03-18 13:36:08', '2021-04-11 14:46:09'),
(470, 'ar', 0, 1015785, '2021-03-18 13:45:42', '2021-06-21 13:03:13'),
(471, 'en', 0, 1015786, '2021-03-18 15:03:00', '2021-03-18 15:03:00'),
(472, 'en', 0, 1015787, '2021-03-18 15:50:52', '2021-03-18 15:50:52'),
(473, 'en', 0, 1015788, '2021-03-18 15:59:07', '2021-03-18 15:59:07'),
(474, 'en', 0, 1015789, '2021-03-18 15:59:48', '2021-03-18 15:59:48'),
(475, 'en', 0, 1015790, '2021-03-18 16:02:04', '2021-03-18 16:02:04'),
(476, 'ar', 0, 1015791, '2021-03-18 16:12:03', '2021-03-18 16:12:59'),
(477, 'en', 0, 1015792, '2021-03-18 16:37:34', '2021-03-18 16:37:34'),
(478, 'en', 0, 1015793, '2021-03-18 17:24:04', '2021-03-18 17:24:04'),
(479, 'en', 0, 1015794, '2021-03-18 17:35:35', '2021-03-18 17:35:35'),
(480, 'en', 0, 1015795, '2021-03-18 17:43:12', '2021-03-18 17:43:12'),
(481, 'en', 0, 1015796, '2021-03-18 19:22:10', '2021-03-18 19:22:10'),
(482, 'en', 0, 1015797, '2021-03-18 20:18:13', '2021-03-18 20:18:13'),
(483, 'en', 0, 1015798, '2021-03-18 21:09:08', '2021-03-18 21:09:08'),
(484, 'en', 0, 1015799, '2021-03-18 22:35:29', '2021-03-18 22:35:29'),
(485, 'ar', 0, 1015800, '2021-03-18 22:40:24', '2021-03-18 22:41:05'),
(486, 'en', 0, 1015801, '2021-03-19 00:09:41', '2021-03-19 00:09:41'),
(487, 'ar', 0, 1015802, '2021-03-19 00:17:28', '2021-03-19 00:18:42'),
(488, 'en', 0, 1015803, '2021-03-19 00:34:23', '2021-03-19 00:34:23'),
(489, 'ar', 0, 1015804, '2021-03-19 00:45:16', '2021-03-19 00:46:22'),
(490, 'en', 0, 1015805, '2021-03-19 01:07:27', '2021-03-19 01:07:27'),
(491, 'en', 0, 1015806, '2021-03-19 03:28:42', '2021-03-19 03:28:42'),
(492, 'en', 0, 1015807, '2021-03-19 04:00:35', '2021-03-19 04:00:35'),
(493, 'ar', 0, 1015808, '2021-03-19 05:34:32', '2021-03-19 05:35:22'),
(494, 'en', 0, 1015809, '2021-03-19 11:01:04', '2021-03-19 11:01:04'),
(495, 'ar', 0, 1015810, '2021-03-19 15:21:49', '2021-03-19 15:22:06'),
(496, 'en', 0, 1015811, '2021-03-19 15:50:04', '2021-03-19 15:50:04'),
(497, 'en', 0, 1015812, '2021-03-19 18:20:17', '2021-03-19 18:20:17'),
(498, 'ar', 0, 1015813, '2021-03-19 18:51:42', '2021-03-19 18:53:01'),
(499, 'en', 0, 1015814, '2021-03-19 19:22:05', '2021-03-19 19:22:05'),
(500, 'en', 0, 1015815, '2021-03-19 19:30:39', '2021-03-19 19:30:39'),
(501, 'en', 0, 1015816, '2021-03-19 19:50:19', '2021-03-19 19:50:19'),
(502, 'ar', 0, 1015817, '2021-03-19 21:35:06', '2021-03-19 21:35:47'),
(503, 'en', 0, 1015818, '2021-03-19 22:31:47', '2021-03-19 22:31:47'),
(504, 'en', 0, 1015819, '2021-03-19 22:46:01', '2021-03-19 22:46:01'),
(505, 'en', 0, 1015820, '2021-03-19 22:50:16', '2021-03-19 22:50:16'),
(506, 'en', 0, 1015822, '2021-03-20 03:20:38', '2021-03-20 03:20:38'),
(507, 'ar', 0, 1015823, '2021-03-20 03:46:44', '2021-03-20 03:46:50'),
(508, 'en', 0, 1015824, '2021-03-20 07:40:49', '2021-03-20 07:40:49'),
(509, 'ar', 0, 1015825, '2021-03-20 09:32:40', '2021-03-20 09:33:46'),
(510, 'ar', 0, 1015826, '2021-03-20 10:58:30', '2021-03-20 11:00:11'),
(511, 'en', 0, 1015827, '2021-03-20 11:38:14', '2021-03-20 11:38:14'),
(512, 'en', 0, 1015828, '2021-03-20 12:24:30', '2021-03-20 12:24:30'),
(513, 'en', 0, 1015829, '2021-03-20 13:51:00', '2021-03-20 13:51:00'),
(514, 'en', 0, 1015830, '2021-03-20 14:05:30', '2021-03-20 14:05:30'),
(515, 'en', 0, 1015831, '2021-03-20 14:25:33', '2021-03-20 14:25:33'),
(516, 'en', 0, 1015832, '2021-03-20 15:30:52', '2021-03-20 15:30:52'),
(517, 'en', 0, 1015833, '2021-03-20 15:55:57', '2021-03-20 15:55:57'),
(518, 'en', 0, 1015834, '2021-03-20 16:08:00', '2021-03-20 16:08:00'),
(519, 'ar', 0, 1015835, '2021-03-20 16:12:58', '2021-03-20 16:17:35'),
(520, 'en', 0, 1015836, '2021-03-20 16:48:07', '2021-03-20 16:48:07'),
(521, 'en', 0, 1015837, '2021-03-20 17:36:49', '2021-03-20 17:36:49'),
(522, 'en', 0, 1015838, '2021-03-20 18:05:43', '2021-03-20 18:05:43'),
(523, 'en', 0, 1015839, '2021-03-20 18:26:14', '2021-03-20 18:26:14'),
(524, 'en', 0, 1015840, '2021-03-20 18:40:13', '2021-03-20 18:40:13'),
(525, 'en', 0, 1015841, '2021-03-20 19:35:43', '2021-03-20 19:35:43'),
(526, 'en', 0, 1015842, '2021-03-20 20:02:05', '2021-03-20 20:02:05'),
(527, 'en', 0, 1015843, '2021-03-20 20:24:54', '2021-03-20 20:24:54'),
(528, 'ar', 0, 1015844, '2021-03-20 21:25:13', '2021-03-20 21:26:01'),
(529, 'en', 0, 1015845, '2021-03-20 21:51:36', '2021-03-20 21:51:36'),
(530, 'en', 0, 1015846, '2021-03-20 22:34:43', '2021-03-20 22:34:43'),
(531, 'ar', 0, 1015847, '2021-03-20 22:40:31', '2021-03-22 15:23:02'),
(532, 'en', 0, 1015848, '2021-03-20 22:59:31', '2021-03-20 22:59:31'),
(533, 'en', 0, 1015849, '2021-03-20 23:00:52', '2021-03-20 23:00:52'),
(534, 'ar', 0, 1015850, '2021-03-20 23:18:18', '2021-03-20 23:18:50'),
(535, 'en', 0, 1015851, '2021-03-20 23:39:18', '2021-03-20 23:39:18'),
(536, 'en', 0, 1015852, '2021-03-21 01:17:04', '2021-03-21 01:17:04'),
(537, 'en', 0, 1015853, '2021-03-21 01:20:13', '2021-03-21 01:20:13'),
(538, 'en', 0, 1015854, '2021-03-21 01:40:41', '2021-03-21 01:40:41'),
(539, 'en', 0, 1015855, '2021-03-21 02:02:57', '2021-03-21 02:02:57'),
(540, 'en', 0, 1015856, '2021-03-21 03:05:35', '2021-03-21 03:05:35'),
(541, 'ar', 0, 1015857, '2021-03-21 08:33:55', '2021-04-18 11:26:53'),
(542, 'en', 0, 1015858, '2021-03-21 09:33:02', '2021-03-21 09:33:02'),
(543, 'en', 0, 1015859, '2021-03-21 10:07:26', '2021-03-21 10:07:26'),
(544, 'en', 0, 1015860, '2021-03-21 10:32:55', '2021-03-21 10:32:55'),
(545, 'en', 0, 1015861, '2021-03-21 11:36:46', '2021-03-21 11:36:46'),
(546, 'en', 0, 1015862, '2021-03-21 14:28:52', '2021-03-21 14:28:52'),
(547, 'en', 0, 1015863, '2021-03-21 14:59:21', '2021-03-21 14:59:21'),
(548, 'en', 0, 1015864, '2021-03-21 15:48:42', '2021-03-21 15:48:42'),
(549, 'en', 0, 1015865, '2021-03-21 15:49:21', '2021-03-21 15:49:21'),
(550, 'ar', 0, 1015866, '2021-03-21 18:03:42', '2021-03-21 18:04:09'),
(551, 'ar', 0, 1015867, '2021-03-21 19:38:13', '2021-03-22 18:49:25'),
(552, 'en', 0, 1015868, '2021-03-21 19:48:30', '2021-03-21 19:48:30'),
(553, 'en', 0, 1015869, '2021-03-21 20:59:38', '2021-03-21 20:59:38'),
(554, 'ar', 0, 1015870, '2021-03-21 21:28:56', '2021-03-21 21:30:06'),
(555, 'en', 0, 1015870, '2021-03-21 21:39:00', '2021-03-21 21:39:00'),
(556, 'en', 0, 1015871, '2021-03-21 23:09:18', '2021-03-21 23:09:18'),
(557, 'ar', 0, 1015872, '2021-03-22 00:19:55', '2021-03-24 21:50:56'),
(558, 'en', 0, 1015529, '2021-03-22 01:42:59', '2021-03-22 01:42:59'),
(559, 'en', 0, 1015873, '2021-03-22 02:38:09', '2021-03-22 02:45:53'),
(560, 'ar', 0, 1015874, '2021-03-22 09:22:47', '2021-03-22 09:23:09'),
(561, 'ar', 0, 1015875, '2021-03-22 10:50:01', '2021-03-22 10:53:17'),
(562, 'en', 0, 1015876, '2021-03-22 12:32:19', '2021-03-22 12:32:19'),
(563, 'ar', 0, 1015877, '2021-03-22 12:55:08', '2021-03-22 12:56:21'),
(564, 'en', 0, 1015878, '2021-03-22 12:57:24', '2021-03-22 12:57:24'),
(565, 'en', 0, 1015879, '2021-03-22 13:01:21', '2021-03-22 13:01:21'),
(566, 'en', 0, 1015880, '2021-03-22 13:03:39', '2021-03-22 13:03:39'),
(567, 'en', 0, 1015881, '2021-03-22 13:25:22', '2021-03-22 13:25:22'),
(568, 'en', 0, 1015882, '2021-03-22 13:38:56', '2021-09-19 16:39:24'),
(569, 'en', 0, 1015883, '2021-03-22 14:12:56', '2021-03-22 14:12:56'),
(570, 'en', 0, 1015884, '2021-03-22 15:25:17', '2021-03-22 15:25:17'),
(571, 'en', 0, 1015885, '2021-03-22 15:48:48', '2021-03-22 15:48:48'),
(572, 'ar', 0, 1015886, '2021-03-22 16:23:34', '2021-03-22 17:29:38'),
(573, 'en', 0, 1015887, '2021-03-22 17:56:41', '2021-03-22 17:56:41'),
(574, 'en', 0, 1015888, '2021-03-22 19:05:14', '2021-03-22 19:05:14'),
(575, 'en', 0, 1015889, '2021-03-22 19:44:30', '2021-03-22 19:44:30'),
(576, 'en', 0, 1015890, '2021-03-22 20:51:16', '2021-03-22 20:51:16'),
(577, 'en', 0, 1015891, '2021-03-22 21:38:11', '2021-03-22 21:38:11'),
(578, 'ar', 0, 1015892, '2021-03-22 21:56:14', '2021-03-22 21:57:25'),
(579, 'en', 0, 1015892, '2021-03-22 22:26:58', '2021-03-22 22:26:58'),
(580, 'en', 0, 1015893, '2021-03-23 01:05:56', '2021-03-23 01:05:56'),
(581, 'ar', 0, 1015894, '2021-03-23 01:21:05', '2021-03-23 01:22:20'),
(582, 'en', 0, 1015877, '2021-03-23 09:15:01', '2021-03-23 09:15:01'),
(583, 'en', 0, 1015895, '2021-03-23 09:56:08', '2021-03-23 09:56:08'),
(584, 'en', 0, 1015896, '2021-03-23 09:56:31', '2021-03-23 09:56:31'),
(585, 'en', 0, 1015383, '2021-03-23 11:01:59', '2021-03-23 11:01:59'),
(586, 'ar', 0, 1015897, '2021-03-23 11:19:49', '2021-03-23 11:20:14'),
(587, 'en', 0, 1015898, '2021-03-23 11:31:37', '2021-03-23 11:31:37'),
(588, 'en', 0, 1015899, '2021-03-23 14:21:09', '2021-03-23 14:21:09'),
(589, 'ar', 0, 1015900, '2021-03-23 15:50:02', '2021-03-23 15:58:02'),
(590, 'ar', 0, 1015901, '2021-03-23 17:55:54', '2021-03-23 17:56:22'),
(591, 'ar', 0, 1015902, '2021-03-23 19:40:34', '2021-03-23 19:40:59'),
(592, 'en', 0, 1015903, '2021-03-23 21:20:53', '2021-03-23 21:20:53'),
(593, 'en', 0, 1015904, '2021-03-23 21:26:45', '2021-03-23 21:26:45'),
(594, 'ar', 0, 1015905, '2021-03-23 21:59:19', '2021-03-28 16:41:46'),
(595, 'en', 0, 1015906, '2021-03-23 23:12:38', '2021-03-23 23:12:38'),
(596, 'ar', 0, 1015907, '2021-03-23 23:31:07', '2021-03-23 23:46:57'),
(597, 'en', 0, 1015908, '2021-03-24 00:02:40', '2021-03-24 00:02:40'),
(598, 'en', 0, 1015909, '2021-03-24 03:51:36', '2021-03-24 03:51:36'),
(599, 'en', 0, 1015910, '2021-03-24 07:40:02', '2021-03-24 07:40:02'),
(600, 'ar', 0, 1015911, '2021-03-24 10:08:33', '2021-03-25 12:55:09'),
(601, 'en', 0, 1015912, '2021-03-24 10:49:20', '2021-03-24 10:49:20'),
(602, 'ar', 0, 1015913, '2021-03-24 10:50:22', '2021-03-24 10:51:09'),
(603, 'en', 0, 1015914, '2021-03-24 10:51:04', '2021-03-24 10:51:04'),
(604, 'en', 0, 1015915, '2021-03-24 10:52:28', '2021-03-24 10:52:28'),
(605, 'en', 0, 1015916, '2021-03-24 10:53:09', '2021-03-24 10:53:09'),
(606, 'en', 0, 1015917, '2021-03-24 10:54:17', '2021-03-24 10:54:17'),
(607, 'en', 0, 1015918, '2021-03-24 11:15:50', '2021-03-24 11:15:50'),
(608, 'ar', 0, 1015919, '2021-03-24 12:25:34', '2021-03-24 12:25:40'),
(609, 'en', 0, 1015920, '2021-03-24 18:50:41', '2021-03-24 18:50:41'),
(610, 'ar', 0, 1015921, '2021-03-24 23:17:38', '2021-03-25 04:07:09'),
(611, 'en', 0, 1015922, '2021-03-25 00:20:33', '2021-03-25 00:20:33'),
(612, 'en', 0, 1015923, '2021-03-25 01:33:36', '2021-03-25 01:33:36'),
(613, 'en', 0, 1015924, '2021-03-25 01:44:26', '2021-03-25 01:44:26'),
(614, 'en', 0, 1015925, '2021-03-25 03:47:15', '2021-03-25 03:47:15'),
(615, 'ar', 0, 1015926, '2021-03-25 03:58:57', '2021-03-25 04:00:27'),
(616, 'en', 0, 1015927, '2021-03-25 09:03:05', '2021-03-25 09:03:05'),
(617, 'en', 0, 1015928, '2021-03-25 10:32:56', '2021-03-25 10:32:56'),
(618, 'en', 0, 1015929, '2021-03-25 10:33:17', '2021-03-25 10:33:17'),
(619, 'en', 0, 1015930, '2021-03-25 11:49:09', '2021-03-25 11:49:09'),
(620, 'en', 0, 1015931, '2021-03-25 13:13:25', '2021-03-25 13:13:25'),
(621, 'ar', 0, 1015932, '2021-03-25 16:05:37', '2021-03-25 16:06:15'),
(622, 'en', 0, 1015933, '2021-03-25 17:43:22', '2021-03-25 17:43:22'),
(623, 'en', 0, 1015934, '2021-03-25 18:16:05', '2021-03-25 18:16:05'),
(624, 'en', 0, 1015935, '2021-03-26 00:31:06', '2021-03-26 00:31:06'),
(625, 'ar', 0, 1015936, '2021-03-26 01:00:45', '2021-03-26 01:02:21'),
(626, 'ar', 0, 1015937, '2021-03-26 01:30:23', '2021-03-26 01:31:23'),
(627, 'en', 0, 1015938, '2021-03-26 03:20:45', '2021-03-26 03:20:45'),
(628, 'en', 0, 1015939, '2021-03-26 04:54:43', '2021-03-26 04:54:43'),
(629, 'en', 0, 1015940, '2021-03-26 04:58:30', '2021-03-26 04:58:30'),
(630, 'ar', 0, 1015941, '2021-03-26 05:01:48', '2021-03-26 05:01:54'),
(631, 'en', 0, 1015942, '2021-03-26 09:50:02', '2021-03-26 09:50:02'),
(632, 'ar', 0, 1015943, '2021-03-26 10:29:23', '2021-04-23 03:54:56'),
(633, 'en', 0, 1015944, '2021-03-26 14:11:48', '2021-03-26 14:11:48'),
(634, 'en', 0, 1015945, '2021-03-26 15:39:08', '2021-03-26 15:39:08'),
(635, 'en', 0, 1015946, '2021-03-26 16:22:42', '2021-03-26 16:22:42'),
(636, 'en', 0, 1015947, '2021-03-26 16:54:49', '2021-03-26 16:54:49'),
(637, 'en', 0, 1015948, '2021-03-26 20:03:46', '2021-03-26 20:03:46'),
(638, 'en', 0, 1015937, '2021-03-26 21:19:10', '2021-03-26 21:19:10'),
(639, 'en', 0, 1015949, '2021-03-26 22:58:17', '2021-03-26 22:58:17'),
(640, 'en', 0, 1015950, '2021-03-26 23:20:07', '2021-03-26 23:20:07'),
(641, 'ar', 0, 1015951, '2021-03-27 01:02:42', '2021-03-27 01:04:31'),
(642, 'en', 0, 1015952, '2021-03-27 01:46:08', '2021-03-27 01:46:08'),
(643, 'en', 0, 1015953, '2021-03-27 06:20:58', '2021-03-27 06:20:58'),
(644, 'en', 0, 1015954, '2021-03-27 08:04:20', '2021-03-27 08:04:20'),
(645, 'en', 0, 1015955, '2021-03-27 12:37:01', '2021-03-27 12:37:01'),
(646, 'en', 0, 1015956, '2021-03-27 14:23:52', '2021-03-27 14:23:52'),
(647, 'en', 0, 1015957, '2021-03-27 17:02:42', '2021-03-27 17:02:42'),
(648, 'en', 0, 1015958, '2021-03-27 21:10:04', '2021-03-27 21:10:04'),
(649, 'en', 0, 1015959, '2021-03-27 21:10:24', '2021-03-27 21:10:24'),
(650, 'ar', 0, 1015960, '2021-03-27 21:29:08', '2021-03-27 21:30:32'),
(651, 'en', 0, 1015961, '2021-03-27 23:08:08', '2021-03-27 23:08:08'),
(652, 'en', 0, 1015962, '2021-03-27 23:11:58', '2021-03-27 23:11:58'),
(653, 'en', 0, 1015963, '2021-03-28 00:04:23', '2021-03-28 00:04:23'),
(654, 'en', 0, 1015731, '2021-03-28 01:13:51', '2021-03-28 01:13:51'),
(655, 'ar', 0, 1015964, '2021-03-28 01:29:02', '2021-03-28 01:29:14'),
(656, 'en', 0, 1015965, '2021-03-28 01:30:14', '2021-03-28 01:30:14'),
(657, 'en', 0, 1015966, '2021-03-28 01:41:47', '2021-03-28 01:41:47'),
(658, 'en', 0, 1015967, '2021-03-28 08:47:54', '2021-03-28 08:47:54'),
(659, 'en', 0, 1015968, '2021-03-28 08:59:19', '2021-03-28 08:59:19'),
(660, 'en', 0, 1015969, '2021-03-28 13:12:07', '2021-03-28 13:12:07'),
(661, 'ar', 0, 1015970, '2021-03-28 13:12:52', '2021-03-28 13:13:28'),
(662, 'en', 0, 1015971, '2021-03-28 14:38:13', '2021-03-28 14:38:13'),
(663, 'ar', 0, 1015972, '2021-03-28 14:55:49', '2021-03-28 14:57:05'),
(664, 'en', 0, 1015973, '2021-03-28 16:30:28', '2021-03-28 16:30:28'),
(665, 'en', 0, 1015974, '2021-03-28 16:32:20', '2021-03-28 16:32:20'),
(666, 'en', 0, 1015975, '2021-03-28 17:52:18', '2021-03-28 17:52:18'),
(667, 'en', 0, 1015976, '2021-03-28 20:22:04', '2021-03-28 20:22:04'),
(668, 'en', 0, 1015977, '2021-03-28 21:12:51', '2021-03-28 21:12:51'),
(669, 'en', 0, 1015978, '2021-03-28 21:34:26', '2021-03-28 21:34:26'),
(670, 'en', 0, 1015979, '2021-03-29 00:55:05', '2021-03-29 00:55:05'),
(671, 'en', 0, 1015980, '2021-03-29 00:56:43', '2021-03-29 00:56:43'),
(672, 'ar', 0, 1015981, '2021-03-29 05:34:42', '2021-03-29 05:35:23'),
(673, 'en', 0, 1015982, '2021-03-29 10:42:17', '2021-03-29 10:42:17'),
(674, 'en', 0, 1015983, '2021-03-29 11:25:41', '2021-03-29 11:25:41'),
(675, 'en', 0, 1015984, '2021-03-29 11:27:20', '2021-03-29 11:27:20'),
(676, 'en', 0, 1015985, '2021-03-29 11:34:53', '2021-03-29 11:34:53'),
(677, 'en', 0, 1015986, '2021-03-29 18:11:32', '2021-03-29 18:11:32'),
(678, 'en', 0, 1015987, '2021-03-29 19:05:58', '2021-03-29 19:05:58'),
(679, 'en', 0, 1015988, '2021-03-29 19:42:14', '2021-03-29 19:42:14'),
(680, 'en', 0, 1015989, '2021-03-29 23:31:49', '2021-03-29 23:31:49'),
(681, 'en', 0, 1015990, '2021-03-30 00:15:29', '2021-03-30 00:15:29'),
(682, 'en', 0, 1015991, '2021-03-30 11:55:40', '2021-03-30 11:55:40'),
(683, 'ar', 0, 1015992, '2021-03-30 12:48:19', '2021-03-30 13:06:08'),
(684, 'ar', 0, 1015993, '2021-03-30 14:49:56', '2021-03-30 14:50:25'),
(685, 'ar', 0, 1015994, '2021-03-30 15:01:10', '2021-03-30 15:02:04'),
(686, 'ar', 0, 1015995, '2021-03-30 18:42:02', '2021-03-30 18:44:24'),
(687, 'en', 0, 1015995, '2021-03-30 18:48:02', '2021-03-30 18:48:02'),
(688, 'en', 0, 1015970, '2021-03-30 19:22:35', '2021-03-30 19:22:35'),
(689, 'en', 0, 1015996, '2021-03-30 19:52:47', '2021-03-30 19:52:47'),
(690, 'en', 0, 1015997, '2021-03-30 19:58:57', '2021-03-30 19:58:57'),
(691, 'en', 0, 1015998, '2021-03-30 20:01:17', '2021-03-30 20:01:17'),
(692, 'ar', 0, 1015999, '2021-03-30 23:52:39', '2021-03-30 23:53:38'),
(693, 'en', 0, 1016000, '2021-03-31 06:09:13', '2021-03-31 06:09:13'),
(694, 'en', 0, 1016001, '2021-03-31 06:09:26', '2021-03-31 15:55:32'),
(695, 'en', 0, 1016002, '2021-03-31 09:01:28', '2021-03-31 09:01:28'),
(696, 'ar', 0, 1016003, '2021-03-31 17:32:37', '2021-03-31 17:40:43'),
(697, 'ar', 0, 1016004, '2021-03-31 18:38:54', '2021-03-31 18:39:01'),
(698, 'ar', 0, 1016005, '2021-03-31 21:25:51', '2021-03-31 21:27:10'),
(699, 'en', 0, 1016006, '2021-04-01 00:31:40', '2021-04-01 00:31:40'),
(700, 'ar', 0, 1016007, '2021-04-01 08:50:13', '2021-04-01 10:01:33'),
(701, 'en', 0, 1016008, '2021-04-01 10:45:28', '2021-04-01 10:45:28'),
(702, 'ar', 0, 1016009, '2021-04-01 14:23:15', '2021-04-01 14:30:13'),
(703, 'en', 0, 1016010, '2021-04-01 15:38:28', '2021-04-01 15:38:28'),
(704, 'en', 0, 1016011, '2021-04-01 16:56:32', '2021-04-01 16:56:32'),
(705, 'ar', 0, 1016012, '2021-04-01 18:30:58', '2021-04-01 18:51:40'),
(706, 'en', 0, 1016013, '2021-04-01 18:33:25', '2021-04-01 18:33:25'),
(707, 'en', 0, 1016014, '2021-04-01 18:55:18', '2021-04-01 18:55:18'),
(708, 'ar', 0, 1016015, '2021-04-01 19:02:46', '2021-04-01 19:03:27'),
(709, 'ar', 0, 1016016, '2021-04-01 20:44:35', '2021-04-07 16:18:55'),
(710, 'ar', 0, 1016017, '2021-04-01 21:29:03', '2021-04-01 21:29:10'),
(711, 'ar', 0, 1016018, '2021-04-01 22:46:55', '2021-04-05 18:13:44'),
(712, 'ar', 0, 1016019, '2021-04-02 05:18:01', '2021-04-02 05:20:02'),
(713, 'en', 0, 1016020, '2021-04-02 05:39:44', '2021-04-02 05:39:44'),
(714, 'ar', 0, 1016021, '2021-04-02 11:32:11', '2021-04-02 11:33:07'),
(715, 'en', 0, 1015791, '2021-04-02 14:21:49', '2021-04-02 14:21:49'),
(716, 'en', 0, 1016022, '2021-04-02 14:28:04', '2021-04-02 14:28:04'),
(717, 'en', 0, 1016023, '2021-04-02 14:45:33', '2021-04-02 14:45:33'),
(718, 'ar', 0, 1016024, '2021-04-02 19:57:57', '2021-04-05 09:00:20'),
(719, 'en', 0, 1016025, '2021-04-02 23:36:33', '2021-04-02 23:36:33'),
(720, 'en', 0, 1016026, '2021-04-03 02:17:45', '2021-04-03 02:17:45'),
(721, 'en', 0, 1016027, '2021-04-03 06:54:07', '2021-04-03 06:54:07'),
(722, 'en', 0, 1016028, '2021-04-03 09:53:05', '2021-04-03 09:53:05'),
(723, 'en', 0, 1015857, '2021-04-03 10:30:34', '2021-04-03 10:30:34'),
(724, 'ar', 0, 1016029, '2021-04-03 11:01:08', '2021-04-03 11:01:42'),
(725, 'en', 0, 1016030, '2021-04-03 15:05:01', '2021-04-03 15:05:01');
INSERT INTO `user_settings` (`id`, `language`, `notify_general`, `user_id`, `created_at`, `updated_at`) VALUES
(726, 'en', 0, 1016031, '2021-04-03 15:19:45', '2021-04-03 15:19:45'),
(727, 'en', 0, 1016032, '2021-04-03 17:28:34', '2021-04-03 17:28:34'),
(728, 'en', 0, 1016033, '2021-04-03 23:33:27', '2021-04-03 23:33:27'),
(729, 'en', 0, 1016034, '2021-04-04 00:56:48', '2021-04-04 00:56:48'),
(730, 'en', 0, 1016035, '2021-04-04 01:57:24', '2021-04-04 01:57:24'),
(731, 'ar', 0, 1016036, '2021-04-04 02:36:28', '2021-04-04 02:37:04'),
(732, 'en', 0, 1016037, '2021-04-04 11:25:49', '2021-04-04 11:25:49'),
(733, 'ar', 0, 1016038, '2021-04-04 12:00:42', '2021-04-11 11:37:03'),
(734, 'en', 0, 1016042, '2021-04-04 14:33:54', '2021-06-19 00:36:10'),
(735, 'en', 0, 1016043, '2021-04-04 14:34:32', '2021-04-04 14:34:32'),
(736, 'ar', 0, 1016044, '2021-04-04 15:20:18', '2021-04-04 15:20:48'),
(737, 'en', 0, 1016045, '2021-04-04 17:00:26', '2021-09-21 16:33:24'),
(738, 'en', 0, 1016046, '2021-04-04 17:11:03', '2021-05-06 10:18:14'),
(739, 'en', 0, 1016047, '2021-04-04 17:34:35', '2021-04-04 17:34:35'),
(740, 'en', 0, 1016048, '2021-04-04 20:08:08', '2021-04-04 20:08:08'),
(741, 'ar', 0, 1016049, '2021-04-04 20:54:42', '2021-04-04 20:55:45'),
(742, 'en', 0, 1016050, '2021-04-04 21:13:00', '2021-04-04 21:13:00'),
(743, 'en', 0, 1016051, '2021-04-04 21:31:02', '2021-04-04 21:31:02'),
(744, 'en', 0, 1016052, '2021-04-04 22:05:13', '2021-04-07 12:32:50'),
(745, 'en', 0, 1016053, '2021-04-04 22:57:02', '2021-04-04 22:57:02'),
(746, 'en', 0, 1016054, '2021-04-04 23:07:41', '2021-04-04 23:07:41'),
(747, 'en', 0, 1016055, '2021-04-05 02:44:59', '2021-04-05 02:44:59'),
(748, 'en', 0, 1016056, '2021-04-05 07:13:09', '2021-04-05 07:13:09'),
(749, 'en', 0, 1016057, '2021-04-05 10:34:58', '2021-04-13 13:18:15'),
(750, 'ar', 0, 1016058, '2021-04-05 11:49:43', '2021-04-05 11:50:33'),
(751, 'en', 0, 1016059, '2021-04-05 13:30:56', '2021-04-05 13:30:56'),
(752, 'ar', 0, 1016060, '2021-04-05 13:36:47', '2021-04-05 13:37:27'),
(753, 'ar', 0, 1016061, '2021-04-05 14:26:28', '2021-04-05 14:27:57'),
(754, 'en', 0, 1016062, '2021-04-05 14:35:18', '2021-04-05 14:35:18'),
(755, 'ar', 0, 1016063, '2021-04-05 15:32:34', '2021-04-05 15:33:01'),
(756, 'en', 0, 1016064, '2021-04-05 15:41:02', '2021-04-05 15:41:02'),
(757, 'en', 0, 1016065, '2021-04-05 16:57:37', '2021-04-05 16:57:37'),
(758, 'en', 0, 1016066, '2021-04-05 17:00:56', '2021-04-05 17:00:56'),
(759, 'en', 0, 1016068, '2021-04-05 18:59:29', '2021-04-05 19:28:44'),
(760, 'en', 0, 1016069, '2021-04-05 20:51:03', '2021-04-05 20:51:03'),
(761, 'en', 0, 1016070, '2021-04-05 21:02:22', '2021-04-05 21:02:22'),
(762, 'en', 0, 1016071, '2021-04-05 22:40:16', '2021-04-05 22:40:16'),
(763, 'ar', 0, 1016072, '2021-04-05 23:28:53', '2021-04-05 23:29:12'),
(764, 'en', 0, 1016073, '2021-04-05 23:54:13', '2021-04-05 23:54:13'),
(765, 'ar', 0, 1016074, '2021-04-06 07:24:20', '2021-04-06 07:25:12'),
(766, 'en', 0, 1016075, '2021-04-06 09:29:45', '2021-04-06 09:29:45'),
(767, 'en', 0, 1016052, '2021-04-06 09:36:04', '2021-04-06 09:36:04'),
(768, 'ar', 0, 1016076, '2021-04-06 10:54:26', '2021-04-06 10:54:59'),
(769, 'en', 0, 1016077, '2021-04-06 11:03:20', '2021-04-06 11:03:20'),
(770, 'en', 0, 1016078, '2021-04-06 11:04:57', '2021-04-06 11:04:57'),
(771, 'ar', 0, 1016079, '2021-04-06 11:10:20', '2021-04-06 11:10:46'),
(772, 'en', 0, 1016080, '2021-04-06 11:20:34', '2021-04-06 11:20:34'),
(773, 'en', 0, 1016081, '2021-04-06 11:22:06', '2021-04-06 11:22:06'),
(774, 'ar', 0, 1016082, '2021-04-06 11:31:49', '2021-04-06 11:32:28'),
(775, 'en', 0, 1016083, '2021-04-06 11:44:05', '2021-04-06 11:44:05'),
(776, 'en', 0, 1016084, '2021-04-06 11:56:44', '2021-04-06 11:56:44'),
(777, 'en', 0, 1016085, '2021-04-06 11:59:22', '2021-04-06 11:59:22'),
(778, 'ar', 0, 1016086, '2021-04-06 12:13:30', '2021-04-06 12:22:21'),
(779, 'en', 0, 1016087, '2021-04-06 12:16:00', '2021-04-06 12:16:00'),
(780, 'en', 0, 1016088, '2021-04-06 12:17:26', '2021-04-06 12:17:26'),
(781, 'ar', 0, 1016089, '2021-04-06 12:25:18', '2021-04-06 12:26:11'),
(782, 'en', 0, 1016090, '2021-04-06 12:37:44', '2021-04-06 12:37:44'),
(783, 'en', 0, 1016091, '2021-04-06 14:32:35', '2021-04-06 14:32:35'),
(784, 'en', 0, 1016092, '2021-04-06 14:41:50', '2021-04-06 14:41:50'),
(785, 'en', 0, 1016093, '2021-04-06 14:59:05', '2021-04-06 14:59:05'),
(786, 'ar', 0, 1016094, '2021-04-06 15:11:12', '2021-04-06 15:19:51'),
(787, 'en', 0, 1016095, '2021-04-06 15:11:24', '2021-04-06 15:11:24'),
(788, 'en', 0, 1016096, '2021-04-06 15:35:06', '2021-04-06 15:35:06'),
(789, 'en', 0, 1016097, '2021-04-06 16:11:45', '2021-04-06 16:11:45'),
(790, 'ar', 0, 1016098, '2021-04-06 17:10:47', '2021-04-06 17:11:13'),
(791, 'ar', 0, 1016099, '2021-04-06 17:42:02', '2021-04-06 17:43:39'),
(792, 'en', 0, 1016100, '2021-04-06 18:02:05', '2021-04-06 18:02:05'),
(793, 'ar', 0, 1016101, '2021-04-06 18:21:14', '2021-04-06 18:22:22'),
(794, 'en', 0, 1016102, '2021-04-06 18:31:02', '2021-04-06 18:31:02'),
(795, 'en', 0, 1016103, '2021-04-06 19:11:07', '2021-04-06 19:11:07'),
(796, 'en', 0, 1016104, '2021-04-06 19:13:50', '2021-04-06 19:13:50'),
(797, 'en', 0, 1016105, '2021-04-06 22:28:57', '2021-04-06 22:28:57'),
(798, 'en', 0, 1016106, '2021-04-06 23:26:53', '2021-04-06 23:26:53'),
(799, 'en', 0, 1016107, '2021-04-07 01:35:55', '2021-04-07 01:35:55'),
(800, 'en', 0, 1016108, '2021-04-07 08:51:30', '2021-04-07 08:51:30'),
(801, 'ar', 0, 1016109, '2021-04-07 09:46:16', '2021-04-07 09:47:07'),
(802, 'en', 0, 1016109, '2021-04-07 09:58:39', '2021-04-07 09:58:39'),
(803, 'en', 0, 1016110, '2021-04-07 11:12:40', '2021-04-07 11:12:40'),
(804, 'en', 0, 1016111, '2021-04-07 12:20:26', '2021-04-07 12:20:26'),
(805, 'en', 0, 1016112, '2021-04-07 14:08:05', '2021-04-07 14:08:05'),
(806, 'en', 0, 1016113, '2021-04-07 15:10:12', '2021-04-07 15:10:12'),
(807, 'en', 0, 1016114, '2021-04-07 15:12:34', '2021-04-07 15:12:34'),
(808, 'en', 0, 1016115, '2021-04-07 17:06:48', '2021-04-07 17:06:48'),
(809, 'ar', 0, 1016116, '2021-04-07 17:32:57', '2021-04-07 17:35:16'),
(810, 'en', 0, 1016117, '2021-04-07 18:46:59', '2021-04-07 18:46:59'),
(811, 'ar', 0, 1016118, '2021-04-07 22:23:00', '2021-04-07 22:31:19'),
(812, 'ar', 0, 1016119, '2021-04-08 00:06:33', '2021-04-08 00:12:11'),
(813, 'ar', 0, 1016120, '2021-04-08 00:09:33', '2021-04-08 00:10:28'),
(814, 'en', 0, 1016121, '2021-04-08 03:15:46', '2021-04-08 03:15:46'),
(815, 'ar', 0, 1016122, '2021-04-08 04:31:53', '2021-04-08 04:34:05'),
(816, 'en', 0, 1016123, '2021-04-08 08:37:13', '2021-04-08 08:37:13'),
(817, 'en', 0, 1016124, '2021-04-08 11:08:58', '2021-04-08 11:08:58'),
(818, 'en', 0, 1016125, '2021-04-08 11:33:48', '2021-04-08 11:33:48'),
(819, 'en', 0, 1016126, '2021-04-08 13:46:56', '2021-04-08 13:46:56'),
(820, 'en', 0, 1016127, '2021-04-08 18:46:38', '2021-04-08 18:46:38'),
(821, 'en', 0, 1016128, '2021-04-08 18:54:04', '2021-09-12 17:13:36'),
(822, 'en', 0, 1016129, '2021-04-08 20:53:54', '2021-04-08 20:53:54'),
(823, 'en', 0, 1016130, '2021-04-08 22:49:48', '2021-04-08 22:49:48'),
(824, 'ar', 0, 1016131, '2021-04-09 00:12:12', '2021-04-09 00:13:54'),
(825, 'en', 0, 1016132, '2021-04-09 02:05:29', '2021-04-09 02:05:29'),
(826, 'en', 0, 1016133, '2021-04-09 02:06:14', '2021-04-09 02:06:14'),
(827, 'en', 0, 1016134, '2021-04-09 16:49:45', '2021-04-09 16:49:45'),
(828, 'ar', 0, 1016135, '2021-04-09 21:28:33', '2021-04-09 21:29:30'),
(829, 'en', 0, 1016136, '2021-04-10 00:14:54', '2021-06-24 01:53:07'),
(830, 'en', 0, 1016137, '2021-04-10 00:57:01', '2021-04-10 00:57:01'),
(831, 'en', 0, 1016138, '2021-04-10 07:30:41', '2021-04-10 07:30:41'),
(832, 'en', 0, 1016139, '2021-04-10 07:40:52', '2021-04-10 07:40:52'),
(833, 'en', 0, 1016140, '2021-04-10 15:13:26', '2021-04-10 15:13:26'),
(834, 'en', 0, 1016141, '2021-04-10 17:45:33', '2021-04-10 17:45:33'),
(835, 'en', 0, 1016142, '2021-04-10 18:04:42', '2021-04-10 18:04:42'),
(836, 'en', 0, 1016143, '2021-04-10 18:21:25', '2021-04-10 18:21:25'),
(837, 'en', 0, 1016144, '2021-04-10 20:21:55', '2021-04-10 20:21:55'),
(838, 'en', 0, 1016089, '2021-04-10 23:52:39', '2021-04-10 23:52:39'),
(839, 'en', 0, 1016145, '2021-04-11 01:23:15', '2021-04-11 01:23:15'),
(840, 'en', 0, 1016146, '2021-04-11 02:10:15', '2021-04-11 02:10:15'),
(841, 'en', 0, 1016147, '2021-04-11 02:18:42', '2021-04-11 02:18:42'),
(842, 'ar', 0, 1016148, '2021-04-11 10:31:02', '2021-04-11 10:32:58'),
(843, 'en', 0, 1016149, '2021-04-11 13:59:39', '2021-04-11 13:59:39'),
(844, 'ar', 0, 1016150, '2021-04-11 15:41:55', '2021-04-11 15:41:56'),
(845, 'en', 0, 1016151, '2021-04-11 19:15:26', '2021-04-11 19:15:26'),
(846, 'en', 0, 1016152, '2021-04-11 20:51:37', '2021-04-11 20:51:37'),
(847, 'ar', 0, 1016153, '2021-04-12 00:02:16', '2021-04-12 00:02:41'),
(848, 'en', 0, 1016154, '2021-04-12 02:19:19', '2021-04-12 02:19:19'),
(849, 'en', 0, 1016155, '2021-04-12 02:29:22', '2021-04-12 02:29:22'),
(850, 'en', 0, 1016156, '2021-04-12 02:32:31', '2021-04-12 02:32:31'),
(851, 'en', 0, 1016157, '2021-04-12 07:25:55', '2021-04-12 07:25:55'),
(852, 'en', 0, 1016158, '2021-04-12 13:46:23', '2021-04-12 13:46:23'),
(853, 'en', 0, 1016159, '2021-04-12 14:55:31', '2021-04-12 14:55:31'),
(854, 'ar', 0, 1016160, '2021-04-12 17:02:36', '2021-04-12 17:03:17'),
(855, 'en', 0, 1016161, '2021-04-12 21:50:34', '2021-04-12 21:50:34'),
(856, 'ar', 0, 1016162, '2021-04-12 23:05:25', '2021-04-13 23:41:57'),
(857, 'en', 0, 1016163, '2021-04-13 01:29:52', '2021-04-13 01:29:52'),
(858, 'en', 0, 1016164, '2021-04-13 10:36:34', '2021-04-13 10:36:34'),
(859, 'en', 0, 1016165, '2021-04-13 12:59:43', '2021-04-13 12:59:43'),
(860, 'en', 0, 1016057, '2021-04-13 13:18:14', '2021-04-13 13:18:14'),
(861, 'ar', 0, 1016166, '2021-04-13 14:12:33', '2021-04-13 14:13:18'),
(862, 'en', 0, 1016167, '2021-04-13 19:38:25', '2021-04-13 19:38:25'),
(863, 'en', 0, 1016168, '2021-04-14 00:15:37', '2021-04-14 00:15:37'),
(864, 'en', 0, 1016169, '2021-04-14 04:23:39', '2021-04-14 04:23:39'),
(865, 'en', 0, 1016170, '2021-04-14 11:09:15', '2021-04-14 11:09:15'),
(866, 'ar', 0, 1016171, '2021-04-14 14:42:48', '2021-04-14 14:43:04'),
(867, 'en', 0, 1016172, '2021-04-14 14:57:05', '2021-04-14 14:57:05'),
(868, 'en', 0, 1016173, '2021-04-14 16:08:42', '2021-04-14 16:08:42'),
(869, 'ar', 0, 1016174, '2021-04-14 16:10:05', '2021-04-14 16:10:34'),
(870, 'en', 0, 1016175, '2021-04-14 17:51:20', '2021-04-14 17:51:20'),
(871, 'ar', 0, 1016176, '2021-04-14 20:14:03', '2021-04-14 20:15:59'),
(872, 'en', 0, 1016177, '2021-04-15 00:14:53', '2021-04-15 00:14:53'),
(873, 'en', 0, 1015835, '2021-04-15 02:16:11', '2021-04-15 02:16:11'),
(874, 'en', 0, 1016178, '2021-04-15 02:48:05', '2021-04-15 02:48:05'),
(875, 'ar', 0, 1016179, '2021-04-15 03:08:13', '2021-04-15 03:09:25'),
(876, 'en', 0, 1016180, '2021-04-15 03:45:23', '2021-04-15 03:45:23'),
(877, 'en', 0, 1016181, '2021-04-15 04:15:29', '2021-04-15 04:15:29'),
(878, 'en', 0, 1016182, '2021-04-15 04:59:53', '2021-04-15 04:59:53'),
(879, 'ar', 0, 1016183, '2021-04-15 06:50:24', '2021-04-15 06:52:54'),
(880, 'en', 0, 1016184, '2021-04-15 11:34:22', '2021-04-15 11:34:22'),
(881, 'en', 0, 1016185, '2021-04-15 12:44:48', '2021-05-19 11:33:06'),
(882, 'en', 0, 1016186, '2021-04-15 13:19:12', '2021-04-15 13:19:12'),
(883, 'ar', 0, 1016187, '2021-04-15 13:27:08', '2021-04-15 13:59:56'),
(884, 'ar', 0, 1016188, '2021-04-15 13:41:34', '2021-04-26 14:23:58'),
(885, 'en', 0, 1016189, '2021-04-15 13:48:11', '2021-04-15 13:48:11'),
(886, 'ar', 0, 1016190, '2021-04-15 13:56:25', '2021-04-15 13:57:32'),
(887, 'ar', 0, 1016191, '2021-04-15 13:58:25', '2021-04-15 13:59:12'),
(888, 'en', 0, 1016192, '2021-04-15 14:04:38', '2021-04-15 14:04:38'),
(889, 'en', 0, 1016193, '2021-04-15 14:09:47', '2021-04-15 14:09:47'),
(890, 'en', 0, 1016194, '2021-04-15 14:19:40', '2021-04-15 14:19:40'),
(891, 'en', 0, 1016195, '2021-04-15 14:22:12', '2021-04-15 14:22:12'),
(892, 'en', 0, 1016196, '2021-04-15 14:41:47', '2021-04-15 14:41:47'),
(893, 'en', 0, 1016197, '2021-04-15 16:03:18', '2021-04-15 16:03:18'),
(894, 'ar', 0, 1016198, '2021-04-15 16:15:56', '2021-04-25 23:25:46'),
(895, 'en', 0, 1016199, '2021-04-15 16:41:43', '2021-04-15 16:41:43'),
(896, 'ar', 0, 1016200, '2021-04-15 16:50:17', '2021-04-17 01:34:06'),
(897, 'en', 0, 1016201, '2021-04-15 17:10:55', '2021-04-15 17:10:55'),
(898, 'en', 0, 1015666, '2021-04-15 18:17:21', '2021-04-15 18:17:21'),
(899, 'en', 0, 1016202, '2021-04-15 19:16:53', '2021-04-15 19:16:53'),
(900, 'en', 0, 1016203, '2021-04-15 22:54:19', '2021-04-15 22:54:19'),
(901, 'en', 0, 1016204, '2021-04-16 01:19:24', '2021-04-16 01:19:24'),
(902, 'en', 0, 1016205, '2021-04-16 06:44:18', '2021-04-16 06:44:18'),
(903, 'en', 0, 1016206, '2021-04-16 11:03:04', '2021-04-16 11:03:04'),
(904, 'en', 0, 1016207, '2021-04-16 13:17:20', '2021-04-16 13:17:20'),
(905, 'en', 0, 1016208, '2021-04-16 14:44:59', '2021-04-16 14:44:59'),
(906, 'en', 0, 1016209, '2021-04-16 17:21:58', '2021-04-16 17:21:58'),
(907, 'en', 0, 1016210, '2021-04-16 19:20:39', '2021-04-16 19:20:39'),
(908, 'ar', 0, 1016211, '2021-04-16 23:12:55', '2021-04-16 23:14:01'),
(909, 'en', 0, 1015826, '2021-04-17 00:08:09', '2021-04-17 00:08:09'),
(910, 'ar', 0, 1016212, '2021-04-17 00:47:19', '2021-04-17 00:51:09'),
(911, 'en', 0, 1016213, '2021-04-17 01:18:23', '2021-04-17 01:18:23'),
(912, 'en', 0, 1016214, '2021-04-17 11:14:59', '2021-04-17 11:14:59'),
(913, 'en', 0, 1016215, '2021-04-17 13:01:47', '2021-04-17 13:01:47'),
(914, 'ar', 0, 1016216, '2021-04-17 14:26:41', '2021-04-17 14:49:27'),
(915, 'en', 0, 1016217, '2021-04-17 18:00:57', '2021-04-17 18:00:57'),
(916, 'en', 0, 1016218, '2021-04-17 19:13:51', '2021-04-17 19:13:51'),
(917, 'en', 0, 1016219, '2021-04-17 23:40:40', '2021-04-17 23:40:40'),
(918, 'ar', 0, 1016220, '2021-04-18 01:41:56', '2021-04-18 01:43:50'),
(919, 'en', 0, 1016221, '2021-04-18 03:12:36', '2021-04-18 03:12:36'),
(920, 'en', 0, 1016222, '2021-04-18 03:13:04', '2021-04-18 03:13:04'),
(921, 'en', 0, 1016223, '2021-04-18 13:56:07', '2021-04-18 13:56:07'),
(922, 'ar', 0, 1016224, '2021-04-18 13:57:17', '2021-04-18 13:57:51'),
(923, 'ar', 0, 1016225, '2021-04-18 14:22:47', '2021-04-18 14:24:05'),
(924, 'en', 0, 1016226, '2021-04-18 15:33:12', '2021-04-18 15:33:12'),
(925, 'en', 0, 1016227, '2021-04-18 17:00:49', '2021-04-18 17:00:49'),
(926, 'en', 0, 1016228, '2021-04-18 17:42:25', '2021-04-18 17:42:25'),
(927, 'en', 0, 1016229, '2021-04-19 01:30:43', '2021-04-19 01:30:43'),
(928, 'ar', 0, 1016230, '2021-04-19 01:54:21', '2021-05-05 03:40:02'),
(929, 'en', 0, 1016231, '2021-04-19 02:28:03', '2021-04-19 02:28:03'),
(930, 'en', 0, 1016232, '2021-04-19 04:12:28', '2021-04-19 04:12:28'),
(931, 'en', 0, 1016233, '2021-04-19 05:45:52', '2021-04-19 05:45:52'),
(932, 'en', 0, 1016234, '2021-04-19 16:54:44', '2021-04-19 16:54:44'),
(933, 'en', 0, 1016235, '2021-04-19 17:20:57', '2021-04-19 17:20:57'),
(934, 'en', 0, 1016236, '2021-04-19 19:43:30', '2021-04-19 19:43:30'),
(935, 'en', 0, 1016237, '2021-04-19 20:25:36', '2021-04-19 20:25:36'),
(936, 'ar', 0, 1016238, '2021-04-19 22:19:06', '2021-04-19 22:23:55'),
(937, 'ar', 0, 1016239, '2021-04-19 23:26:11', '2021-04-19 23:27:59'),
(938, 'en', 0, 1016240, '2021-04-19 23:57:42', '2021-04-19 23:57:42'),
(939, 'en', 0, 1016241, '2021-04-20 00:42:36', '2021-04-20 00:42:36'),
(940, 'en', 0, 1016242, '2021-04-20 02:04:30', '2021-04-20 02:04:30'),
(941, 'en', 0, 1016243, '2021-04-20 02:17:41', '2021-04-20 02:17:41'),
(942, 'en', 0, 1016244, '2021-04-20 04:07:15', '2021-04-20 04:07:15'),
(943, 'en', 0, 1016245, '2021-04-20 13:25:36', '2021-04-20 13:25:36'),
(944, 'en', 0, 1016246, '2021-04-20 17:14:19', '2021-04-20 17:14:19'),
(945, 'en', 0, 1016247, '2021-04-20 19:41:32', '2021-04-20 19:41:32'),
(946, 'ar', 0, 1016248, '2021-04-20 20:50:29', '2021-04-20 20:52:41'),
(947, 'ar', 0, 1016249, '2021-04-21 02:59:17', '2021-04-21 02:59:31'),
(948, 'en', 0, 1016250, '2021-04-21 04:14:05', '2021-04-21 04:14:05'),
(949, 'en', 0, 1016251, '2021-04-21 07:57:48', '2021-04-21 07:57:48'),
(950, 'en', 0, 1016252, '2021-04-21 11:41:08', '2021-04-21 11:41:08'),
(951, 'en', 0, 1016253, '2021-04-21 12:43:17', '2021-04-21 12:43:17'),
(952, 'en', 0, 1016254, '2021-04-21 13:25:43', '2021-04-21 13:25:43'),
(953, 'en', 0, 1016255, '2021-04-21 13:37:42', '2021-04-21 13:37:42'),
(954, 'en', 0, 1016256, '2021-04-21 16:39:19', '2021-04-21 16:39:19'),
(955, 'en', 0, 1016257, '2021-04-21 18:06:05', '2021-04-21 18:06:05'),
(956, 'ar', 0, 1016258, '2021-04-21 18:23:02', '2021-06-14 22:56:58'),
(957, 'ar', 0, 1016259, '2021-04-21 20:07:55', '2021-04-21 20:09:07'),
(958, 'en', 0, 1016260, '2021-04-21 23:31:57', '2021-04-21 23:31:57'),
(959, 'ar', 0, 1016261, '2021-04-22 02:53:21', '2021-04-22 02:54:44'),
(960, 'ar', 0, 1016262, '2021-04-22 02:57:37', '2021-04-22 02:58:38'),
(961, 'ar', 0, 1016263, '2021-04-22 03:37:30', '2021-04-22 03:37:53'),
(962, 'en', 0, 1016264, '2021-04-22 03:54:35', '2021-04-22 03:54:35'),
(963, 'en', 0, 1016265, '2021-04-22 05:27:21', '2021-04-22 05:27:21'),
(964, 'en', 0, 1016266, '2021-04-22 10:17:42', '2021-04-22 10:17:42'),
(965, 'en', 0, 1016267, '2021-04-22 10:24:06', '2021-04-22 10:24:06'),
(966, 'en', 0, 1016268, '2021-04-22 10:43:45', '2021-04-22 10:43:45'),
(967, 'ar', 0, 1016269, '2021-04-22 12:30:32', '2021-05-05 13:15:33'),
(968, 'ar', 0, 1016270, '2021-04-22 13:45:17', '2021-04-22 13:45:33'),
(969, 'en', 0, 1016271, '2021-04-22 13:45:18', '2021-04-22 13:45:18'),
(970, 'en', 0, 1016272, '2021-04-22 14:21:16', '2021-04-22 14:21:16'),
(971, 'en', 0, 1016273, '2021-04-22 14:23:30', '2021-04-22 14:23:30'),
(972, 'en', 0, 1016274, '2021-04-22 14:27:28', '2021-04-22 14:27:28'),
(973, 'en', 0, 1016275, '2021-04-22 14:38:55', '2021-04-22 14:38:55'),
(974, 'en', 0, 1016276, '2021-04-22 16:35:07', '2021-04-22 16:35:07'),
(975, 'en', 0, 1016277, '2021-04-22 22:27:13', '2021-04-22 22:27:13'),
(976, 'en', 0, 1016278, '2021-04-22 22:56:33', '2021-04-22 22:56:33'),
(977, 'en', 0, 1016279, '2021-04-22 22:57:03', '2021-04-22 22:57:03'),
(978, 'ar', 0, 1016280, '2021-04-22 23:56:22', '2021-04-23 08:37:06'),
(979, 'en', 0, 1016281, '2021-04-23 01:12:21', '2021-04-23 01:12:21'),
(980, 'en', 0, 1016282, '2021-04-23 01:56:28', '2021-04-23 02:05:29'),
(981, 'en', 0, 1016283, '2021-04-23 01:56:49', '2021-04-23 01:56:49'),
(982, 'ar', 0, 1016284, '2021-04-23 05:46:51', '2021-04-23 05:48:09'),
(983, 'en', 0, 1016285, '2021-04-23 10:39:45', '2021-04-23 10:39:45'),
(984, 'en', 0, 1016286, '2021-04-23 14:36:56', '2021-04-23 14:36:56'),
(985, 'en', 0, 1016287, '2021-04-23 14:48:19', '2021-04-23 14:48:19'),
(986, 'en', 0, 1016288, '2021-04-23 16:59:04', '2021-04-23 16:59:04'),
(987, 'en', 0, 1016289, '2021-04-23 19:14:26', '2021-04-23 19:14:26'),
(988, 'en', 0, 1016290, '2021-04-23 21:12:32', '2021-04-23 21:12:32'),
(989, 'ar', 0, 1016291, '2021-04-23 21:13:01', '2021-04-23 21:13:55'),
(990, 'en', 0, 1016292, '2021-04-23 21:38:12', '2021-04-23 21:38:12'),
(991, 'ar', 0, 1016293, '2021-04-23 22:09:43', '2021-04-23 22:13:43'),
(992, 'ar', 0, 1016294, '2021-04-24 00:13:51', '2021-04-24 00:15:43'),
(993, 'en', 0, 1016295, '2021-04-24 00:51:57', '2021-04-24 00:51:57'),
(994, 'en', 0, 1016296, '2021-04-24 01:57:29', '2021-04-24 01:57:29'),
(995, 'ar', 0, 1016297, '2021-04-24 02:41:41', '2021-04-24 02:41:59'),
(996, 'en', 0, 1016298, '2021-04-24 03:54:26', '2021-04-24 03:54:26'),
(997, 'ar', 0, 1016299, '2021-04-24 04:16:30', '2021-04-24 04:17:25'),
(998, 'en', 0, 1016300, '2021-04-24 04:36:21', '2021-04-24 04:36:21'),
(999, 'en', 0, 1016301, '2021-04-24 06:28:16', '2021-04-24 06:28:16'),
(1000, 'en', 0, 1016302, '2021-04-24 07:44:59', '2021-04-24 07:44:59'),
(1001, 'ar', 0, 1016303, '2021-04-24 09:58:45', '2021-04-24 09:59:06'),
(1002, 'en', 0, 1016304, '2021-04-24 10:48:21', '2021-04-24 10:48:21'),
(1003, 'en', 0, 1016305, '2021-04-24 11:19:07', '2021-04-24 11:19:07'),
(1004, 'en', 0, 1016306, '2021-04-24 12:13:03', '2021-04-24 12:13:03'),
(1005, 'en', 0, 1016307, '2021-04-24 14:11:46', '2021-04-24 14:11:46'),
(1006, 'en', 0, 1016308, '2021-04-24 15:49:06', '2021-04-24 15:49:06'),
(1007, 'en', 0, 1016309, '2021-04-24 16:24:33', '2021-04-24 16:24:33'),
(1008, 'en', 0, 1016310, '2021-04-24 17:20:39', '2021-04-24 17:20:39'),
(1009, 'en', 0, 1016311, '2021-04-24 17:28:29', '2021-04-24 17:28:29'),
(1010, 'en', 0, 1016312, '2021-04-24 18:09:02', '2021-04-24 18:09:02'),
(1011, 'ar', 0, 1016313, '2021-04-24 19:33:11', '2021-04-24 19:33:38'),
(1012, 'en', 0, 1016314, '2021-04-24 19:36:42', '2021-04-24 19:36:42'),
(1013, 'en', 0, 1016315, '2021-04-24 20:26:26', '2021-04-24 20:26:26'),
(1014, 'ar', 0, 1016316, '2021-04-24 21:23:45', '2021-04-24 21:31:32'),
(1015, 'en', 0, 1016317, '2021-04-24 21:30:52', '2021-04-24 21:30:52'),
(1016, 'en', 0, 1016318, '2021-04-24 21:53:26', '2021-04-24 21:53:26'),
(1017, 'ar', 0, 1016319, '2021-04-24 22:16:25', '2021-04-24 22:17:11'),
(1018, 'en', 0, 1016320, '2021-04-24 23:44:36', '2021-04-24 23:44:36'),
(1019, 'en', 0, 1016321, '2021-04-24 23:49:26', '2021-04-24 23:49:26'),
(1020, 'en', 0, 1016322, '2021-04-25 04:02:25', '2021-04-25 04:02:25'),
(1021, 'ar', 0, 1016323, '2021-04-25 04:08:22', '2021-04-25 04:14:14'),
(1022, 'en', 0, 1016324, '2021-04-25 05:39:15', '2021-04-25 05:39:15'),
(1023, 'en', 0, 1016325, '2021-04-25 06:30:44', '2021-04-25 06:30:44'),
(1024, 'en', 0, 1016326, '2021-04-25 11:50:30', '2021-04-25 11:50:30'),
(1025, 'en', 0, 1016327, '2021-04-25 12:00:41', '2021-04-25 12:00:41'),
(1026, 'en', 0, 1016328, '2021-04-25 12:49:00', '2021-04-25 12:49:00'),
(1027, 'en', 0, 1016329, '2021-04-25 12:54:34', '2021-04-25 12:54:34'),
(1028, 'en', 0, 1016330, '2021-04-25 13:21:39', '2021-04-25 13:21:39'),
(1029, 'ar', 0, 1016331, '2021-04-25 13:25:50', '2021-10-06 14:55:16'),
(1030, 'ar', 0, 1016332, '2021-04-25 13:26:10', '2021-09-06 11:03:45'),
(1031, 'ar', 0, 1016333, '2021-04-25 14:30:18', '2021-04-25 14:30:32'),
(1032, 'en', 0, 1016334, '2021-04-25 15:00:29', '2021-04-25 15:00:29'),
(1033, 'ar', 0, 1016335, '2021-04-25 17:50:43', '2021-04-25 17:57:59'),
(1034, 'en', 0, 1016336, '2021-04-25 17:57:54', '2021-04-25 17:57:54'),
(1035, 'en', 0, 1016337, '2021-04-25 22:33:43', '2021-04-25 22:33:43'),
(1036, 'en', 0, 1016338, '2021-04-25 22:38:53', '2021-04-25 22:38:53'),
(1037, 'en', 0, 1016339, '2021-04-25 22:43:25', '2021-04-25 22:43:25'),
(1038, 'ar', 0, 1016340, '2021-04-26 00:24:13', '2021-04-26 00:24:47'),
(1039, 'ar', 0, 1016341, '2021-04-26 03:25:56', '2021-04-26 03:28:04'),
(1040, 'ar', 0, 1016342, '2021-04-26 11:07:17', '2021-04-26 11:08:05'),
(1041, 'en', 0, 1016343, '2021-04-26 14:50:33', '2021-04-26 14:50:33'),
(1042, 'ar', 0, 1016344, '2021-04-26 14:57:06', '2021-04-26 15:13:59'),
(1043, 'ar', 0, 1016345, '2021-04-26 15:27:20', '2021-04-26 15:28:47'),
(1044, 'en', 0, 1016346, '2021-04-26 15:36:51', '2021-04-26 15:36:51'),
(1045, 'en', 0, 1016344, '2021-04-26 15:40:43', '2021-04-26 15:40:43'),
(1046, 'en', 0, 1016347, '2021-04-26 15:46:47', '2021-04-26 15:46:47'),
(1047, 'en', 0, 1016348, '2021-04-26 19:17:11', '2021-04-26 19:17:11'),
(1048, 'en', 0, 1016349, '2021-04-26 20:48:45', '2021-04-26 20:48:45'),
(1049, 'en', 0, 1016350, '2021-04-26 22:16:27', '2021-04-26 22:16:27'),
(1050, 'en', 0, 1016351, '2021-04-26 22:31:04', '2021-04-26 22:31:04'),
(1051, 'ar', 0, 1016352, '2021-04-27 03:37:24', '2021-04-27 03:40:00'),
(1052, 'en', 0, 1016353, '2021-04-27 08:59:06', '2021-04-27 08:59:06'),
(1053, 'en', 0, 1016354, '2021-04-27 11:18:48', '2021-04-27 11:18:48'),
(1054, 'ar', 0, 1016355, '2021-04-27 13:32:44', '2021-04-27 13:40:21'),
(1055, 'en', 0, 1016356, '2021-04-27 15:51:56', '2021-04-27 16:06:54'),
(1056, 'ar', 0, 1016357, '2021-04-27 15:58:34', '2021-04-27 15:59:02'),
(1057, 'en', 0, 1016358, '2021-04-27 16:11:05', '2021-04-27 16:11:05'),
(1058, 'en', 0, 1016359, '2021-04-27 19:50:37', '2021-04-27 19:50:37'),
(1059, 'en', 0, 1016360, '2021-04-28 01:42:18', '2021-04-28 01:42:18'),
(1060, 'ar', 0, 1016361, '2021-04-28 03:19:25', '2021-04-28 03:19:41'),
(1061, 'en', 0, 1016362, '2021-04-28 09:32:01', '2021-04-28 09:32:01'),
(1062, 'ar', 0, 1016363, '2021-04-28 11:38:16', '2021-04-28 11:39:00'),
(1063, 'en', 0, 1016364, '2021-04-28 13:20:59', '2021-04-28 13:20:59'),
(1064, 'en', 0, 1016365, '2021-04-28 15:57:53', '2021-04-28 15:57:53'),
(1065, 'en', 0, 1016366, '2021-04-28 16:58:08', '2021-04-28 16:58:08'),
(1066, 'ar', 0, 1016367, '2021-04-28 20:44:18', '2021-04-28 20:44:49'),
(1067, 'ar', 0, 1016368, '2021-04-28 20:57:54', '2021-04-28 20:58:37'),
(1068, 'en', 0, 1016369, '2021-04-29 03:05:19', '2021-04-29 03:05:19'),
(1069, 'en', 0, 1016370, '2021-04-29 08:55:44', '2021-04-29 08:55:44'),
(1070, 'en', 0, 1016371, '2021-04-29 10:27:31', '2021-04-29 10:27:31'),
(1071, 'ar', 0, 1016372, '2021-04-29 12:38:44', '2021-04-29 12:40:34'),
(1072, 'en', 0, 1016373, '2021-04-29 14:12:04', '2021-04-29 14:12:04'),
(1073, 'en', 0, 1016374, '2021-04-29 20:52:48', '2021-04-29 20:52:48'),
(1074, 'en', 0, 1016375, '2021-04-30 01:29:36', '2021-04-30 01:29:36'),
(1075, 'en', 0, 1016376, '2021-04-30 03:40:25', '2021-04-30 03:40:25'),
(1076, 'en', 0, 1016377, '2021-04-30 12:00:24', '2021-04-30 12:00:24'),
(1077, 'ar', 0, 1016378, '2021-04-30 13:27:48', '2021-04-30 13:28:15'),
(1078, 'en', 0, 1016379, '2021-04-30 14:24:23', '2021-04-30 14:24:23'),
(1079, 'en', 0, 1016380, '2021-04-30 14:51:39', '2021-04-30 14:51:39'),
(1080, 'ar', 0, 1016381, '2021-04-30 16:17:15', '2021-04-30 16:17:57'),
(1081, 'ar', 0, 1016382, '2021-04-30 17:30:32', '2021-04-30 17:31:10'),
(1082, 'en', 0, 1016383, '2021-04-30 19:21:27', '2021-04-30 19:21:27'),
(1083, 'en', 0, 1016384, '2021-05-01 03:09:12', '2021-05-01 03:09:12'),
(1084, 'en', 0, 1016385, '2021-05-01 03:33:12', '2021-05-01 03:33:12'),
(1085, 'en', 0, 1016386, '2021-05-01 03:34:09', '2021-05-01 03:34:09'),
(1086, 'en', 0, 1016387, '2021-05-01 05:11:12', '2021-05-01 05:11:12'),
(1087, 'en', 0, 1016388, '2021-05-01 15:47:13', '2021-05-01 15:47:13'),
(1088, 'ar', 0, 1016389, '2021-05-01 17:54:11', '2021-05-01 17:55:10'),
(1089, 'ar', 0, 1016390, '2021-05-01 18:08:06', '2021-05-01 18:11:55'),
(1090, 'en', 0, 1016391, '2021-05-02 01:26:29', '2021-05-02 01:26:29'),
(1091, 'en', 0, 1016392, '2021-05-02 15:43:32', '2021-05-02 15:43:32'),
(1092, 'ar', 0, 1016393, '2021-05-02 16:06:48', '2021-05-02 16:08:27'),
(1093, 'en', 0, 1016394, '2021-05-02 17:24:13', '2021-05-02 17:24:13'),
(1094, 'en', 0, 1016395, '2021-05-02 22:30:56', '2021-05-02 22:30:56'),
(1095, 'en', 0, 1016396, '2021-05-02 22:33:06', '2021-05-02 22:33:06'),
(1096, 'en', 0, 1016397, '2021-05-03 00:29:22', '2021-05-03 00:29:22'),
(1097, 'en', 0, 1016398, '2021-05-03 04:04:00', '2021-05-03 04:04:00'),
(1098, 'en', 0, 1016399, '2021-05-03 04:58:06', '2021-05-03 04:58:06'),
(1099, 'ar', 0, 1016400, '2021-05-03 15:09:55', '2021-05-05 12:20:56'),
(1100, 'en', 0, 1016401, '2021-05-04 01:57:36', '2021-05-04 01:57:36'),
(1101, 'ar', 0, 1016402, '2021-05-04 20:12:01', '2021-05-04 20:12:44'),
(1102, 'en', 0, 1016403, '2021-05-04 20:20:15', '2021-05-04 20:20:15'),
(1103, 'en', 0, 1016389, '2021-05-04 20:40:02', '2021-05-04 20:40:02'),
(1104, 'ar', 0, 1016404, '2021-05-04 23:46:07', '2021-05-04 23:52:23'),
(1105, 'en', 0, 1016405, '2021-05-05 03:13:23', '2021-05-05 03:13:23'),
(1106, 'ar', 0, 1016406, '2021-05-05 07:54:11', '2021-05-05 07:54:54'),
(1107, 'en', 0, 1016407, '2021-05-05 15:23:10', '2021-05-05 15:23:10'),
(1108, 'ar', 0, 1016408, '2021-05-05 18:52:59', '2021-05-05 18:54:25'),
(1109, 'en', 0, 1016409, '2021-05-05 19:26:28', '2021-05-05 19:26:28'),
(1110, 'en', 0, 1016410, '2021-05-05 19:28:40', '2021-05-05 19:28:40'),
(1111, 'en', 0, 1016411, '2021-05-05 19:30:04', '2021-05-05 19:30:04'),
(1112, 'en', 0, 1016412, '2021-05-05 20:36:15', '2021-05-05 20:36:15'),
(1113, 'ar', 0, 1016413, '2021-05-05 21:12:18', '2021-05-05 21:16:24'),
(1114, 'en', 0, 1016414, '2021-05-05 22:19:25', '2021-05-05 22:19:25'),
(1115, 'en', 0, 1016415, '2021-05-05 22:33:23', '2021-05-05 22:33:23'),
(1116, 'en', 0, 1016416, '2021-05-05 22:55:16', '2021-05-05 22:55:16'),
(1117, 'ar', 0, 1016417, '2021-05-05 23:28:18', '2021-05-05 23:30:10'),
(1118, 'ar', 0, 1016418, '2021-05-06 00:59:01', '2021-05-06 00:59:18'),
(1119, 'en', 0, 1016419, '2021-05-06 01:30:58', '2021-05-06 01:30:58'),
(1120, 'ar', 0, 1016420, '2021-05-06 01:31:52', '2021-05-06 01:32:36'),
(1121, 'en', 0, 1016421, '2021-05-06 02:01:02', '2021-05-06 02:01:02'),
(1122, 'en', 0, 1016422, '2021-05-06 02:16:28', '2021-05-06 02:16:28'),
(1123, 'en', 0, 1016423, '2021-05-06 03:57:36', '2021-05-06 03:57:36'),
(1124, 'en', 0, 1016424, '2021-05-06 04:03:04', '2021-05-06 04:03:04'),
(1125, 'ar', 0, 1016425, '2021-05-06 04:39:39', '2021-05-06 04:40:48'),
(1126, 'ar', 0, 1016426, '2021-05-06 05:39:28', '2021-05-06 05:41:00'),
(1127, 'ar', 0, 1016427, '2021-05-06 08:03:10', '2021-05-06 08:04:22'),
(1128, 'en', 0, 1016428, '2021-05-06 08:11:23', '2021-05-06 08:11:23'),
(1129, 'en', 0, 1016429, '2021-05-06 09:23:13', '2021-05-06 09:23:13'),
(1130, 'en', 0, 1016430, '2021-05-06 11:31:36', '2021-05-06 11:31:36'),
(1131, 'ar', 0, 1016431, '2021-05-06 12:32:45', '2021-05-06 12:34:20'),
(1132, 'ar', 0, 1016432, '2021-05-06 12:37:56', '2021-05-06 12:38:13'),
(1133, 'en', 0, 1016432, '2021-05-06 14:01:40', '2021-05-06 14:01:40'),
(1134, 'ar', 0, 1016433, '2021-05-06 14:27:45', '2021-05-06 14:28:26'),
(1135, 'ar', 0, 1016434, '2021-05-06 16:03:55', '2021-05-06 16:04:49'),
(1136, 'ar', 0, 1016435, '2021-05-07 00:22:34', '2021-05-07 00:23:33'),
(1137, 'en', 0, 1016436, '2021-05-07 01:06:47', '2021-05-07 01:06:47'),
(1138, 'en', 0, 1016437, '2021-05-07 03:07:28', '2021-05-07 03:07:28'),
(1139, 'en', 0, 1016438, '2021-05-07 03:09:14', '2021-05-07 03:09:14'),
(1140, 'en', 0, 1016439, '2021-05-07 04:41:14', '2021-05-07 04:41:14'),
(1141, 'en', 0, 1016440, '2021-05-07 08:24:57', '2021-05-07 08:24:57'),
(1142, 'en', 0, 1016441, '2021-05-07 09:49:41', '2021-06-12 16:30:49'),
(1143, 'en', 0, 1016442, '2021-05-07 15:23:16', '2021-05-07 15:23:16'),
(1144, 'en', 0, 1016443, '2021-05-07 16:04:31', '2021-05-07 16:04:31'),
(1145, 'en', 0, 1016444, '2021-05-07 21:29:23', '2021-05-07 21:29:23'),
(1146, 'ar', 0, 1016445, '2021-05-07 23:22:48', '2021-05-07 23:23:08'),
(1147, 'ar', 0, 1016446, '2021-05-08 04:59:47', '2021-05-08 05:06:56'),
(1148, 'en', 0, 1016447, '2021-05-08 09:13:52', '2021-05-08 09:13:52'),
(1149, 'en', 0, 1016448, '2021-05-08 13:13:51', '2021-05-08 13:13:51'),
(1150, 'ar', 0, 1016449, '2021-05-08 13:48:42', '2021-05-08 13:51:57'),
(1151, 'en', 0, 1016450, '2021-05-08 14:46:29', '2021-05-08 14:46:29'),
(1152, 'en', 0, 1016451, '2021-05-08 15:50:17', '2021-05-08 15:50:17'),
(1153, 'en', 0, 1016452, '2021-05-08 16:04:22', '2021-05-08 16:04:22'),
(1154, 'en', 0, 1016453, '2021-05-08 20:06:13', '2021-05-08 20:06:13'),
(1155, 'en', 0, 1016454, '2021-05-08 20:37:04', '2021-05-08 20:37:04'),
(1156, 'en', 0, 1016455, '2021-05-09 01:06:17', '2021-05-09 01:06:17'),
(1157, 'ar', 0, 1016456, '2021-05-09 13:22:13', '2021-05-09 13:22:25'),
(1158, 'en', 0, 1016457, '2021-05-09 20:44:45', '2021-05-09 20:44:45'),
(1159, 'en', 0, 1016382, '2021-05-10 02:16:10', '2021-05-10 02:16:10'),
(1160, 'ar', 0, 1016458, '2021-05-10 05:23:23', '2021-05-10 05:24:10'),
(1161, 'en', 0, 1016459, '2021-05-10 09:16:57', '2021-05-10 09:16:57'),
(1162, 'en', 0, 1016460, '2021-05-10 09:29:10', '2021-05-10 09:29:10'),
(1163, 'ar', 0, 1016461, '2021-05-10 12:05:50', '2021-05-10 12:07:09'),
(1164, 'ar', 0, 1016462, '2021-05-10 13:15:41', '2021-05-10 13:15:55'),
(1165, 'en', 0, 1016463, '2021-05-10 15:49:02', '2021-05-10 15:49:02'),
(1166, 'en', 0, 1016464, '2021-05-10 15:55:51', '2021-05-10 15:55:51'),
(1167, 'ar', 0, 1016465, '2021-05-10 15:57:23', '2021-05-10 15:57:58'),
(1168, 'en', 0, 1016466, '2021-05-10 16:18:44', '2021-05-10 16:18:44'),
(1169, 'ar', 0, 1016467, '2021-05-11 01:05:36', '2021-05-11 01:06:29'),
(1170, 'en', 0, 1016468, '2021-05-11 02:12:27', '2021-05-11 02:12:27'),
(1171, 'ar', 0, 1016469, '2021-05-11 04:08:23', '2021-05-11 04:10:40'),
(1172, 'en', 0, 1016469, '2021-05-11 04:30:21', '2021-05-11 04:30:21'),
(1173, 'en', 0, 1016470, '2021-05-11 13:12:36', '2021-05-11 13:12:36'),
(1174, 'en', 0, 1016471, '2021-05-11 13:32:40', '2021-05-11 13:32:40'),
(1175, 'en', 0, 1016472, '2021-05-11 15:17:34', '2021-05-11 15:17:34'),
(1176, 'en', 0, 1016473, '2021-05-11 19:18:01', '2021-05-11 19:18:01'),
(1177, 'en', 0, 1016474, '2021-05-11 20:18:48', '2021-05-11 20:18:48'),
(1178, 'ar', 0, 1016475, '2021-05-12 06:54:13', '2021-05-12 06:54:55'),
(1179, 'en', 0, 1016476, '2021-05-12 12:38:11', '2021-05-12 12:38:11'),
(1180, 'en', 0, 1016477, '2021-05-12 20:03:04', '2021-05-12 20:03:04'),
(1181, 'ar', 0, 1016478, '2021-05-12 20:21:43', '2021-05-12 20:22:49'),
(1182, 'en', 0, 1016479, '2021-05-12 20:57:37', '2021-05-12 20:57:37'),
(1183, 'en', 0, 1016480, '2021-05-13 03:33:33', '2021-05-13 03:33:33'),
(1184, 'ar', 0, 1016481, '2021-05-13 03:57:09', '2021-05-13 22:31:04'),
(1185, 'en', 0, 1016482, '2021-05-13 10:36:11', '2021-05-13 10:36:11'),
(1186, 'ar', 0, 1016483, '2021-05-13 11:19:00', '2021-05-13 11:20:04'),
(1187, 'en', 0, 1016484, '2021-05-13 12:04:57', '2021-05-13 12:04:57'),
(1188, 'en', 0, 1016485, '2021-05-13 14:25:06', '2021-05-13 14:25:06'),
(1189, 'en', 0, 1016486, '2021-05-13 15:17:07', '2021-05-13 15:17:07'),
(1190, 'en', 0, 1016487, '2021-05-13 15:26:50', '2021-05-13 15:26:50'),
(1191, 'ar', 0, 1016488, '2021-05-13 16:29:30', '2021-05-13 16:29:42'),
(1192, 'en', 0, 1016489, '2021-05-14 04:39:46', '2021-05-14 04:39:46'),
(1193, 'en', 0, 1016490, '2021-05-14 11:17:40', '2021-05-14 11:17:40'),
(1194, 'en', 0, 1016491, '2021-05-14 14:12:55', '2021-06-13 10:20:41'),
(1195, 'en', 0, 1016492, '2021-05-14 16:00:47', '2021-05-14 16:00:47'),
(1196, 'en', 0, 1016493, '2021-05-14 16:23:41', '2021-05-14 16:23:41'),
(1197, 'ar', 0, 1016494, '2021-05-14 17:54:50', '2021-05-14 18:00:16'),
(1198, 'ar', 0, 1016495, '2021-05-14 17:55:17', '2021-05-14 17:57:52'),
(1199, 'en', 0, 1016494, '2021-05-14 18:01:19', '2021-05-14 18:01:19'),
(1200, 'en', 0, 1016496, '2021-05-14 18:48:15', '2021-05-14 18:48:15'),
(1201, 'en', 0, 1016497, '2021-05-14 21:18:07', '2021-05-14 21:18:07'),
(1202, 'en', 0, 1016498, '2021-05-15 00:40:00', '2021-05-15 00:40:00'),
(1203, 'en', 0, 1016499, '2021-05-15 00:50:58', '2021-05-15 00:50:58'),
(1204, 'en', 0, 1016500, '2021-05-15 04:09:51', '2021-05-15 04:09:51'),
(1205, 'en', 0, 1016501, '2021-05-15 04:37:10', '2021-05-15 04:37:10'),
(1206, 'en', 0, 1016502, '2021-05-15 11:41:18', '2021-05-15 11:41:18'),
(1207, 'en', 0, 1016503, '2021-05-15 11:58:19', '2021-05-15 11:58:19'),
(1208, 'en', 0, 1016504, '2021-05-15 14:22:51', '2021-05-15 14:22:51'),
(1209, 'en', 0, 1016505, '2021-05-15 17:15:33', '2021-05-15 17:15:33'),
(1210, 'ar', 0, 1016506, '2021-05-16 12:45:29', '2021-05-16 12:51:58'),
(1211, 'ar', 0, 1016507, '2021-05-16 20:17:59', '2021-05-16 20:18:48'),
(1212, 'en', 0, 1016508, '2021-05-16 20:55:47', '2021-05-16 20:55:47'),
(1213, 'ar', 0, 1016509, '2021-05-16 21:45:11', '2021-05-16 21:45:52'),
(1214, 'en', 0, 1016510, '2021-05-17 02:43:41', '2021-05-17 02:43:41'),
(1215, 'en', 0, 1016511, '2021-05-17 10:59:50', '2021-05-17 10:59:50'),
(1216, 'en', 0, 1016512, '2021-05-17 12:57:13', '2021-05-17 12:57:13'),
(1217, 'ar', 0, 1016513, '2021-05-17 18:11:44', '2021-05-17 18:29:04'),
(1218, 'en', 0, 1016513, '2021-05-17 18:21:59', '2021-05-17 18:21:59'),
(1219, 'ar', 0, 1016514, '2021-05-17 20:05:40', '2021-05-17 20:08:40'),
(1220, 'en', 0, 1016515, '2021-05-17 20:46:05', '2021-05-17 20:46:05'),
(1221, 'en', 0, 1016516, '2021-05-17 22:41:15', '2021-05-17 22:41:15'),
(1222, 'ar', 0, 1016517, '2021-05-18 02:08:24', '2021-05-18 02:08:56'),
(1223, 'ar', 0, 1016518, '2021-05-18 04:47:17', '2021-05-18 04:47:24'),
(1224, 'en', 0, 1016519, '2021-05-18 06:00:44', '2021-05-18 06:00:44'),
(1225, 'en', 0, 1016520, '2021-05-18 10:40:05', '2021-05-18 10:40:05'),
(1226, 'ar', 0, 1016521, '2021-05-18 13:28:25', '2021-06-02 20:38:56'),
(1227, 'en', 0, 1016522, '2021-05-18 13:55:44', '2021-05-18 13:55:44'),
(1228, 'ar', 0, 1016523, '2021-05-18 13:56:39', '2021-05-18 14:29:28'),
(1229, 'en', 0, 1016524, '2021-05-18 14:56:56', '2021-05-18 14:56:56'),
(1230, 'en', 0, 1016525, '2021-05-18 15:17:48', '2021-05-18 15:17:48'),
(1231, 'en', 0, 1016526, '2021-05-18 16:34:03', '2021-05-18 16:34:03'),
(1232, 'en', 0, 1016527, '2021-05-18 19:48:11', '2021-05-18 19:48:11'),
(1233, 'ar', 0, 1016528, '2021-05-19 01:00:52', '2021-05-22 20:22:40'),
(1234, 'en', 0, 1016529, '2021-05-19 01:57:02', '2021-05-19 01:57:02'),
(1235, 'en', 0, 1016530, '2021-05-19 04:50:16', '2021-05-19 04:50:16'),
(1236, 'en', 0, 1016531, '2021-05-19 06:41:46', '2021-05-19 06:41:46'),
(1237, 'en', 0, 1016532, '2021-05-19 08:55:29', '2021-05-19 08:55:29'),
(1238, 'en', 0, 1016533, '2021-05-19 09:49:56', '2021-05-19 09:49:56'),
(1239, 'ar', 0, 1016534, '2021-05-19 11:09:12', '2021-05-19 12:13:36'),
(1240, 'en', 0, 1016535, '2021-05-19 11:53:29', '2021-05-19 11:53:29'),
(1241, 'en', 0, 1016536, '2021-05-19 11:54:05', '2021-05-26 17:28:09'),
(1242, 'en', 0, 1016537, '2021-05-19 12:27:35', '2021-05-19 12:27:35'),
(1243, 'en', 0, 1016538, '2021-05-19 14:00:53', '2021-05-19 14:00:53'),
(1244, 'ar', 0, 1016539, '2021-05-19 14:13:19', '2021-05-19 14:13:25'),
(1245, 'en', 0, 1016540, '2021-05-19 14:16:40', '2021-05-19 14:16:40'),
(1246, 'en', 0, 1016541, '2021-05-19 14:38:05', '2021-05-19 14:38:05'),
(1247, 'en', 0, 1016542, '2021-05-19 16:45:04', '2021-05-19 16:45:04'),
(1248, 'en', 0, 1016543, '2021-05-19 16:50:43', '2021-05-19 16:50:43'),
(1249, 'en', 0, 1016544, '2021-05-19 18:08:55', '2021-05-19 18:08:55'),
(1250, 'en', 0, 1016545, '2021-05-19 18:23:49', '2021-05-19 18:23:49'),
(1251, 'ar', 0, 1016546, '2021-05-19 18:45:44', '2021-05-19 18:51:31'),
(1252, 'en', 0, 1016547, '2021-05-19 19:40:33', '2021-05-19 19:40:33'),
(1253, 'ar', 0, 1016548, '2021-05-19 20:39:24', '2021-05-19 20:41:00'),
(1254, 'en', 0, 1016549, '2021-05-19 22:26:56', '2021-05-19 22:26:56'),
(1255, 'en', 0, 1016550, '2021-05-19 22:28:00', '2021-05-19 22:28:00'),
(1256, 'ar', 0, 1016551, '2021-05-19 23:45:28', '2021-05-20 13:45:01'),
(1257, 'en', 0, 1016552, '2021-05-20 00:57:01', '2021-05-20 00:57:01'),
(1258, 'en', 0, 1016553, '2021-05-20 01:39:20', '2021-05-20 01:39:20'),
(1259, 'ar', 0, 1016554, '2021-05-20 02:34:08', '2021-05-20 16:38:26'),
(1260, 'en', 0, 1016555, '2021-05-20 05:19:18', '2021-05-20 05:19:18'),
(1261, 'en', 0, 1016556, '2021-05-20 05:33:03', '2021-05-20 05:33:03'),
(1262, 'en', 0, 1016557, '2021-05-20 13:34:33', '2021-05-20 13:34:33'),
(1263, 'ar', 0, 1016558, '2021-05-20 13:45:37', '2021-06-17 13:13:17'),
(1264, 'en', 0, 1016559, '2021-05-20 13:48:58', '2021-05-20 13:48:58'),
(1265, 'en', 0, 1016560, '2021-05-20 14:49:19', '2021-05-20 14:49:19'),
(1266, 'en', 0, 1016561, '2021-05-20 16:14:53', '2021-05-20 16:14:53'),
(1267, 'en', 0, 1016562, '2021-05-20 17:55:04', '2021-05-20 17:55:04'),
(1268, 'en', 0, 1016563, '2021-05-20 18:03:58', '2021-05-20 18:03:58'),
(1269, 'en', 0, 1016564, '2021-05-20 21:19:25', '2021-05-20 21:19:25'),
(1270, 'en', 0, 1016565, '2021-05-20 21:36:06', '2021-05-20 21:36:06'),
(1271, 'en', 0, 1016566, '2021-05-20 22:34:05', '2021-05-20 22:34:05'),
(1272, 'en', 0, 1016567, '2021-05-20 23:26:39', '2021-05-20 23:26:39'),
(1273, 'en', 0, 1016568, '2021-05-21 01:28:52', '2021-05-21 01:28:52'),
(1274, 'en', 0, 1016569, '2021-05-21 01:42:11', '2021-05-21 01:42:11'),
(1275, 'ar', 0, 1016570, '2021-05-21 04:18:54', '2021-05-21 04:19:10'),
(1276, 'en', 0, 1016571, '2021-05-21 04:39:21', '2021-05-21 04:39:21'),
(1277, 'en', 0, 1016572, '2021-05-21 04:57:56', '2021-05-21 04:57:56'),
(1278, 'en', 0, 1016573, '2021-05-21 08:58:24', '2021-05-21 08:58:24'),
(1279, 'en', 0, 1016574, '2021-05-21 09:12:13', '2021-05-21 09:12:13'),
(1280, 'en', 0, 1016575, '2021-05-21 11:30:27', '2021-05-21 11:30:27'),
(1281, 'en', 0, 1016576, '2021-05-21 16:07:36', '2021-05-21 16:07:36'),
(1282, 'en', 0, 1016577, '2021-05-21 18:30:09', '2021-05-21 18:30:09'),
(1283, 'en', 0, 1016578, '2021-05-21 21:04:31', '2021-05-21 21:04:31'),
(1284, 'en', 0, 1016579, '2021-05-22 00:39:40', '2021-05-22 00:39:40'),
(1285, 'en', 0, 1016580, '2021-05-22 01:00:10', '2021-05-22 01:00:10'),
(1286, 'en', 0, 1016581, '2021-05-22 01:45:16', '2021-05-22 01:45:16'),
(1287, 'ar', 0, 1016582, '2021-05-22 10:04:41', '2021-05-22 10:04:49'),
(1288, 'en', 0, 1016582, '2021-05-22 11:17:11', '2021-05-22 11:17:11'),
(1289, 'ar', 0, 1016583, '2021-05-22 13:57:20', '2021-05-22 14:00:10'),
(1290, 'en', 0, 1016584, '2021-05-22 14:12:18', '2021-05-22 14:12:18'),
(1291, 'ar', 0, 1016585, '2021-05-22 16:55:53', '2021-05-22 16:55:58'),
(1292, 'en', 0, 1016586, '2021-05-22 19:07:39', '2021-05-22 19:07:39'),
(1293, 'en', 0, 1016587, '2021-05-22 19:53:11', '2021-05-22 19:53:11'),
(1294, 'ar', 0, 1016588, '2021-05-22 20:50:23', '2021-05-22 20:50:41'),
(1295, 'en', 0, 1016589, '2021-05-22 21:11:49', '2021-05-22 21:11:49'),
(1296, 'en', 0, 1016590, '2021-05-23 00:57:29', '2021-05-23 00:57:29'),
(1297, 'en', 0, 1016591, '2021-05-23 01:26:48', '2021-05-23 01:26:48'),
(1298, 'ar', 0, 1016592, '2021-05-23 03:01:57', '2021-05-25 01:45:38'),
(1299, 'ar', 0, 1016593, '2021-05-23 04:35:01', '2021-05-23 04:35:34'),
(1300, 'en', 0, 1016594, '2021-05-23 10:46:20', '2021-05-23 10:46:20'),
(1301, 'en', 0, 1016595, '2021-05-23 12:20:53', '2021-05-23 12:20:53'),
(1302, 'ar', 0, 1016596, '2021-05-23 12:23:46', '2021-05-23 12:26:42'),
(1303, 'ar', 0, 1016597, '2021-05-23 12:37:32', '2021-05-27 00:25:07'),
(1304, 'en', 0, 1016598, '2021-05-23 14:19:48', '2021-05-23 14:19:48'),
(1305, 'en', 0, 1016599, '2021-05-23 15:17:05', '2021-05-23 15:17:05'),
(1306, 'en', 0, 1016600, '2021-05-23 15:33:00', '2021-05-23 15:33:00'),
(1307, 'ar', 0, 1016601, '2021-05-23 20:05:52', '2021-05-25 22:20:00'),
(1308, 'en', 0, 1016602, '2021-05-23 20:51:14', '2021-05-23 20:51:14'),
(1309, 'ar', 0, 1016603, '2021-05-23 22:00:52', '2021-05-27 23:14:49'),
(1310, 'en', 0, 1016604, '2021-05-23 22:16:41', '2021-05-23 22:16:41'),
(1311, 'en', 0, 1016605, '2021-05-24 03:03:53', '2021-05-24 03:03:53'),
(1312, 'en', 0, 1016406, '2021-05-24 07:30:36', '2021-05-24 07:30:36'),
(1313, 'en', 0, 1016606, '2021-05-24 12:25:26', '2021-05-24 12:25:26'),
(1314, 'ar', 0, 1016607, '2021-05-24 13:55:20', '2021-05-24 13:57:30'),
(1315, 'en', 0, 1016558, '2021-05-24 16:04:24', '2021-05-24 16:04:24'),
(1316, 'en', 0, 1016608, '2021-05-24 16:27:13', '2021-05-24 16:27:13'),
(1317, 'en', 0, 1016609, '2021-05-24 18:06:53', '2021-05-24 18:06:53'),
(1318, 'en', 0, 1016610, '2021-05-24 20:40:27', '2021-05-26 06:34:21'),
(1319, 'en', 0, 1016611, '2021-05-24 21:00:52', '2021-05-24 21:00:52'),
(1320, 'en', 0, 1016612, '2021-05-25 00:32:17', '2021-05-25 00:32:17'),
(1321, 'en', 0, 1016613, '2021-05-25 00:37:04', '2021-05-25 00:37:04'),
(1322, 'en', 0, 1016614, '2021-05-25 11:16:18', '2021-05-25 11:16:18'),
(1323, 'en', 0, 1016615, '2021-05-25 12:36:14', '2021-05-25 12:36:14'),
(1324, 'en', 0, 1016616, '2021-05-25 12:44:43', '2021-05-25 12:44:43'),
(1325, 'en', 0, 1016617, '2021-05-25 13:58:54', '2021-05-25 13:58:54'),
(1326, 'ar', 0, 1016618, '2021-05-25 14:46:42', '2021-05-25 14:48:36'),
(1327, 'en', 0, 1016619, '2021-05-25 15:28:22', '2021-05-25 15:28:22'),
(1328, 'en', 0, 1016620, '2021-05-25 17:45:20', '2021-05-25 17:45:20'),
(1329, 'ar', 0, 1016621, '2021-05-25 18:59:45', '2021-05-25 19:00:14'),
(1330, 'en', 0, 1016622, '2021-05-25 22:27:25', '2021-05-25 22:27:25'),
(1331, 'ar', 0, 1016623, '2021-05-25 22:43:33', '2021-05-26 13:17:44'),
(1332, 'en', 0, 1016624, '2021-05-25 23:37:17', '2021-05-25 23:37:17'),
(1333, 'en', 0, 1016625, '2021-05-25 23:40:40', '2021-05-25 23:40:40'),
(1334, 'en', 0, 1016626, '2021-05-26 01:03:42', '2021-05-26 01:03:42'),
(1335, 'en', 0, 1016627, '2021-05-26 02:08:47', '2021-05-26 02:08:47'),
(1336, 'ar', 0, 1016628, '2021-05-26 13:01:56', '2021-05-26 13:07:05'),
(1337, 'ar', 0, 1016629, '2021-05-26 15:52:38', '2021-05-26 15:52:55'),
(1338, 'ar', 0, 1016630, '2021-05-26 18:00:26', '2021-05-26 18:01:16'),
(1339, 'en', 0, 1016631, '2021-05-26 18:44:41', '2021-05-26 18:44:41'),
(1340, 'en', 0, 1016632, '2021-05-26 20:31:11', '2021-05-26 20:31:11'),
(1341, 'ar', 0, 1016633, '2021-05-26 20:49:22', '2021-05-26 20:49:53'),
(1342, 'en', 0, 1016634, '2021-05-26 21:27:34', '2021-05-26 21:27:34'),
(1343, 'ar', 0, 1016635, '2021-05-26 21:31:57', '2021-05-26 22:05:38'),
(1344, 'ar', 0, 1016636, '2021-05-26 21:57:28', '2021-06-24 22:35:56'),
(1345, 'en', 0, 1016637, '2021-05-26 23:19:04', '2021-05-26 23:19:04'),
(1346, 'en', 0, 1016638, '2021-05-27 00:57:04', '2021-05-27 00:57:04'),
(1347, 'ar', 0, 1016639, '2021-05-27 03:21:31', '2021-05-28 02:44:27'),
(1348, 'ar', 0, 1016640, '2021-05-27 08:15:53', '2021-05-27 08:16:45'),
(1349, 'ar', 0, 1016641, '2021-05-27 10:26:58', '2021-05-27 11:26:39'),
(1350, 'en', 0, 1016642, '2021-05-27 15:33:30', '2021-05-27 15:33:30'),
(1351, 'en', 0, 1016643, '2021-05-27 18:17:45', '2021-05-27 18:17:45'),
(1352, 'en', 0, 1016644, '2021-05-27 18:24:08', '2021-05-27 18:24:08'),
(1353, 'en', 0, 1016645, '2021-05-27 19:57:46', '2021-05-27 19:57:46'),
(1354, 'en', 0, 1015662, '2021-05-27 20:35:02', '2021-05-27 20:35:02'),
(1355, 'en', 0, 1016646, '2021-05-27 20:50:29', '2021-05-27 20:50:29'),
(1356, 'en', 0, 1016647, '2021-05-27 21:02:47', '2021-05-27 21:02:47'),
(1357, 'en', 0, 1016648, '2021-05-28 00:27:20', '2021-05-28 00:27:20'),
(1358, 'ar', 0, 1016649, '2021-05-28 00:47:24', '2021-05-28 00:48:24'),
(1359, 'en', 0, 1016650, '2021-05-28 02:28:43', '2021-05-28 02:28:43'),
(1360, 'en', 0, 1016651, '2021-05-28 03:03:02', '2021-05-28 03:03:02'),
(1361, 'en', 0, 1016652, '2021-05-28 03:44:14', '2021-05-28 03:44:14'),
(1362, 'en', 0, 1016653, '2021-05-28 07:13:22', '2021-05-28 07:13:22'),
(1363, 'ar', 0, 1016654, '2021-05-28 08:27:24', '2021-05-28 08:28:25'),
(1364, 'en', 0, 1016655, '2021-05-28 09:47:58', '2021-05-28 09:47:58'),
(1365, 'ar', 0, 1016656, '2021-05-28 10:19:33', '2021-05-28 10:51:29'),
(1366, 'en', 0, 1016657, '2021-05-28 11:20:42', '2021-05-28 11:20:42'),
(1367, 'en', 0, 1016658, '2021-05-28 11:26:50', '2021-05-28 11:26:50'),
(1368, 'ar', 0, 1016659, '2021-05-28 13:26:54', '2021-05-28 13:28:07'),
(1369, 'ar', 0, 1016660, '2021-05-28 13:40:01', '2021-05-28 13:40:58'),
(1370, 'ar', 0, 1016661, '2021-05-28 13:59:14', '2021-06-02 10:45:16'),
(1371, 'en', 0, 1016662, '2021-05-28 14:49:30', '2021-05-28 14:49:30'),
(1372, 'ar', 0, 1016663, '2021-05-28 15:01:30', '2021-05-28 15:08:28'),
(1373, 'en', 0, 1016664, '2021-05-28 15:20:30', '2021-05-28 15:20:30'),
(1374, 'en', 0, 1016665, '2021-05-28 20:42:47', '2021-05-28 20:42:47'),
(1375, 'en', 0, 1016666, '2021-05-28 22:52:47', '2021-05-28 22:52:47'),
(1376, 'en', 0, 1016667, '2021-05-28 23:58:05', '2021-05-28 23:58:05'),
(1377, 'ar', 0, 1016668, '2021-05-29 00:54:58', '2021-05-29 06:53:54'),
(1378, 'en', 0, 1016669, '2021-05-29 01:21:40', '2021-05-29 01:21:40'),
(1379, 'en', 0, 1016670, '2021-05-29 02:58:47', '2021-05-29 02:58:47'),
(1380, 'en', 0, 1016671, '2021-05-29 03:24:55', '2021-05-29 03:24:55'),
(1381, 'en', 0, 1016672, '2021-05-29 04:06:33', '2021-05-29 04:06:33'),
(1382, 'ar', 0, 1016673, '2021-05-29 04:13:30', '2021-05-29 04:16:37'),
(1383, 'ar', 0, 1016674, '2021-05-29 07:19:43', '2021-05-29 07:22:28'),
(1384, 'ar', 0, 1016675, '2021-05-29 08:56:42', '2021-05-29 12:22:20'),
(1385, 'ar', 0, 1016676, '2021-05-29 10:12:39', '2021-05-29 10:15:52'),
(1386, 'en', 0, 1016677, '2021-05-29 10:55:13', '2021-05-29 10:55:13'),
(1387, 'en', 0, 1016678, '2021-05-29 11:16:11', '2021-05-29 11:16:11'),
(1388, 'ar', 0, 1016679, '2021-05-29 11:26:15', '2021-05-29 11:27:22'),
(1389, 'en', 0, 1016680, '2021-05-29 13:43:29', '2021-05-29 13:43:29'),
(1390, 'en', 0, 1016681, '2021-05-29 13:54:20', '2021-05-29 13:54:20'),
(1391, 'en', 0, 1016676, '2021-05-29 13:56:28', '2021-05-29 13:56:28'),
(1392, 'en', 0, 1016682, '2021-05-29 14:01:05', '2021-05-29 14:01:05'),
(1393, 'ar', 0, 1016683, '2021-05-29 15:05:11', '2021-05-29 15:07:21'),
(1394, 'ar', 0, 1016684, '2021-05-29 15:17:59', '2021-05-29 16:31:51'),
(1395, 'en', 0, 1016685, '2021-05-29 16:52:43', '2021-05-29 16:52:43'),
(1396, 'en', 0, 1016686, '2021-05-29 17:14:12', '2021-05-29 17:14:12'),
(1397, 'en', 0, 1016687, '2021-05-29 18:10:09', '2021-05-29 18:10:09'),
(1398, 'ar', 0, 1016688, '2021-05-29 18:31:00', '2021-05-29 18:32:31'),
(1399, 'en', 0, 1016689, '2021-05-29 20:30:02', '2021-05-29 20:30:02'),
(1400, 'en', 0, 1016690, '2021-05-29 21:05:24', '2021-05-29 21:05:24'),
(1401, 'en', 0, 1016691, '2021-05-29 22:01:50', '2021-05-29 22:01:50'),
(1402, 'en', 0, 1016692, '2021-05-29 22:03:12', '2021-05-29 22:03:12'),
(1403, 'en', 0, 1016693, '2021-05-30 05:04:40', '2021-05-30 05:04:40'),
(1404, 'en', 0, 1016694, '2021-05-30 12:07:45', '2021-05-30 12:07:45'),
(1405, 'en', 0, 1016695, '2021-05-30 12:58:05', '2021-05-30 12:58:05'),
(1406, 'en', 0, 1016696, '2021-05-30 13:40:00', '2021-05-30 13:40:00'),
(1407, 'en', 0, 1016697, '2021-05-30 14:07:53', '2021-05-30 14:07:53'),
(1408, 'ar', 0, 1016698, '2021-05-30 15:09:58', '2021-05-30 15:11:30'),
(1409, 'en', 0, 1016699, '2021-05-30 15:16:45', '2021-05-30 15:16:45'),
(1410, 'en', 0, 1016700, '2021-05-30 16:12:46', '2021-05-30 16:12:46'),
(1411, 'en', 0, 1016701, '2021-05-30 16:34:22', '2021-05-30 16:34:22'),
(1412, 'en', 0, 1016702, '2021-05-30 16:47:55', '2021-05-30 16:47:55'),
(1413, 'en', 0, 1016703, '2021-05-30 17:42:46', '2021-05-30 17:42:46'),
(1414, 'en', 0, 1016704, '2021-05-30 18:21:13', '2021-05-30 18:21:13'),
(1415, 'en', 0, 1016705, '2021-05-30 18:33:34', '2021-05-30 18:33:34'),
(1416, 'en', 0, 1016706, '2021-05-30 18:45:00', '2021-05-30 18:45:00'),
(1417, 'en', 0, 1016707, '2021-05-30 19:08:55', '2021-05-30 19:08:55'),
(1418, 'en', 0, 1016708, '2021-05-30 19:43:35', '2021-05-30 19:43:35'),
(1419, 'en', 0, 1016709, '2021-05-30 22:14:00', '2021-05-30 22:14:00'),
(1420, 'en', 0, 1016710, '2021-05-30 23:07:39', '2021-05-30 23:07:39'),
(1421, 'en', 0, 1016711, '2021-05-31 00:53:19', '2021-05-31 00:53:19'),
(1422, 'en', 0, 1016712, '2021-05-31 00:54:36', '2021-05-31 00:56:05'),
(1423, 'en', 0, 1016713, '2021-05-31 02:55:56', '2021-06-03 04:26:08'),
(1424, 'ar', 0, 1016714, '2021-05-31 04:03:20', '2021-05-31 04:05:39'),
(1425, 'ar', 0, 1016715, '2021-05-31 11:27:42', '2021-05-31 11:31:57'),
(1426, 'en', 0, 1016716, '2021-05-31 11:33:33', '2021-05-31 11:33:33'),
(1427, 'en', 0, 1016717, '2021-05-31 12:23:44', '2021-05-31 12:23:44'),
(1428, 'ar', 0, 1016718, '2021-05-31 13:21:51', '2021-05-31 13:24:49'),
(1429, 'en', 0, 1016719, '2021-05-31 13:45:40', '2021-05-31 13:45:40'),
(1430, 'en', 0, 1016720, '2021-05-31 16:56:06', '2021-05-31 16:56:06'),
(1431, 'en', 0, 1016721, '2021-05-31 17:05:01', '2021-05-31 17:05:01'),
(1432, 'ar', 0, 1016722, '2021-05-31 17:05:13', '2021-05-31 17:09:03'),
(1433, 'en', 0, 1016723, '2021-05-31 17:26:00', '2021-05-31 17:26:00'),
(1434, 'en', 0, 1016724, '2021-05-31 17:41:09', '2021-05-31 17:41:09'),
(1435, 'en', 0, 1016725, '2021-05-31 18:18:52', '2021-05-31 18:18:52'),
(1436, 'en', 0, 1016726, '2021-05-31 18:50:25', '2021-05-31 18:50:25'),
(1437, 'ar', 0, 1016727, '2021-05-31 20:11:08', '2021-05-31 20:11:13'),
(1438, 'en', 0, 1016728, '2021-05-31 20:29:15', '2021-05-31 20:29:15'),
(1439, 'en', 0, 1016729, '2021-05-31 21:59:12', '2021-05-31 21:59:12'),
(1440, 'en', 0, 1016730, '2021-05-31 22:23:29', '2021-05-31 22:23:29'),
(1441, 'en', 0, 1016731, '2021-05-31 22:30:40', '2021-05-31 22:30:40');
INSERT INTO `user_settings` (`id`, `language`, `notify_general`, `user_id`, `created_at`, `updated_at`) VALUES
(1442, 'ar', 0, 1016732, '2021-05-31 22:41:17', '2021-05-31 22:41:54'),
(1443, 'en', 0, 1016733, '2021-05-31 23:12:22', '2021-05-31 23:12:22'),
(1444, 'ar', 0, 1016734, '2021-05-31 23:23:02', '2021-05-31 23:23:14'),
(1445, 'ar', 0, 1016735, '2021-06-01 00:11:38', '2021-06-01 00:13:33'),
(1446, 'en', 0, 1016528, '2021-06-01 01:16:33', '2021-06-01 01:16:33'),
(1447, 'en', 0, 1016736, '2021-06-01 05:10:15', '2021-06-01 05:10:15'),
(1448, 'en', 0, 1016737, '2021-06-01 05:55:12', '2021-06-01 05:55:12'),
(1449, 'ar', 0, 1016738, '2021-06-01 06:48:05', '2021-06-01 06:48:45'),
(1450, 'ar', 0, 1016739, '2021-06-01 08:41:27', '2021-06-01 08:42:24'),
(1451, 'en', 0, 1016740, '2021-06-01 10:18:33', '2021-06-01 10:18:33'),
(1452, 'en', 0, 1016741, '2021-06-01 14:08:27', '2021-06-01 14:08:27'),
(1453, 'en', 0, 1016742, '2021-06-01 15:44:36', '2021-06-01 15:44:36'),
(1454, 'en', 0, 1016743, '2021-06-01 15:58:37', '2021-06-01 15:58:37'),
(1455, 'ar', 0, 1016744, '2021-06-01 16:10:23', '2021-06-01 16:16:04'),
(1456, 'ar', 0, 1016745, '2021-06-01 16:39:57', '2021-06-01 16:41:20'),
(1457, 'en', 0, 1016746, '2021-06-01 17:29:57', '2021-06-01 17:29:57'),
(1458, 'en', 0, 1016747, '2021-06-01 18:19:40', '2021-06-01 18:19:40'),
(1459, 'en', 0, 1016748, '2021-06-01 18:47:31', '2021-06-01 18:47:31'),
(1460, 'ar', 0, 1016749, '2021-06-01 19:28:58', '2021-06-01 19:31:09'),
(1461, 'en', 0, 1016749, '2021-06-01 20:33:01', '2021-06-01 20:33:01'),
(1462, 'ar', 0, 1016750, '2021-06-01 21:47:02', '2021-06-01 21:50:08'),
(1463, 'ar', 0, 1016751, '2021-06-01 22:59:24', '2021-06-01 23:00:47'),
(1464, 'en', 0, 1016752, '2021-06-01 23:00:14', '2021-06-01 23:00:14'),
(1465, 'en', 0, 1016753, '2021-06-01 23:10:06', '2021-06-01 23:10:06'),
(1466, 'en', 0, 1016754, '2021-06-01 23:29:54', '2021-06-01 23:29:54'),
(1467, 'ar', 0, 1016755, '2021-06-02 00:15:04', '2021-06-02 00:15:29'),
(1468, 'en', 0, 1016756, '2021-06-02 02:13:01', '2021-06-02 02:13:01'),
(1469, 'ar', 0, 1016757, '2021-06-02 06:11:33', '2021-06-02 06:14:28'),
(1470, 'ar', 0, 1016758, '2021-06-02 08:03:01', '2021-06-02 08:03:51'),
(1471, 'en', 0, 1016759, '2021-06-02 08:26:11', '2021-06-02 08:26:11'),
(1472, 'ar', 0, 1016760, '2021-06-02 10:25:23', '2021-06-02 10:25:45'),
(1473, 'ar', 0, 1016761, '2021-06-02 10:50:27', '2021-06-02 10:50:51'),
(1474, 'en', 0, 1016762, '2021-06-02 11:04:01', '2021-06-02 11:04:01'),
(1475, 'en', 0, 1016763, '2021-06-02 13:54:59', '2021-06-02 13:54:59'),
(1476, 'en', 0, 1016761, '2021-06-02 14:35:43', '2021-06-02 14:35:43'),
(1477, 'ar', 0, 1016764, '2021-06-02 15:13:36', '2021-06-02 15:20:45'),
(1478, 'en', 0, 1016765, '2021-06-02 16:10:42', '2021-06-02 16:10:42'),
(1479, 'en', 0, 1016766, '2021-06-02 16:43:57', '2021-06-02 16:43:57'),
(1480, 'en', 0, 1016767, '2021-06-02 17:11:05', '2021-06-02 17:11:05'),
(1481, 'ar', 0, 1016768, '2021-06-02 18:06:15', '2021-06-02 18:06:40'),
(1482, 'ar', 0, 1016769, '2021-06-02 19:07:07', '2021-06-04 19:10:02'),
(1483, 'ar', 0, 1016770, '2021-06-02 19:45:09', '2021-06-02 19:47:00'),
(1484, 'en', 0, 1016771, '2021-06-02 19:46:20', '2021-06-02 19:46:20'),
(1485, 'en', 0, 1016772, '2021-06-02 19:55:20', '2021-06-02 19:55:20'),
(1486, 'en', 0, 1016773, '2021-06-02 20:55:43', '2021-06-02 20:55:43'),
(1487, 'en', 0, 1016774, '2021-06-02 21:16:29', '2021-06-02 21:16:29'),
(1488, 'ar', 0, 1016775, '2021-06-02 21:49:31', '2021-06-02 21:51:11'),
(1489, 'en', 0, 1016776, '2021-06-02 22:22:18', '2021-06-02 22:22:18'),
(1490, 'ar', 0, 1016777, '2021-06-02 22:25:15', '2021-06-07 20:15:51'),
(1491, 'ar', 0, 1016778, '2021-06-02 23:39:33', '2021-06-02 23:40:54'),
(1492, 'ar', 0, 1016779, '2021-06-03 00:56:55', '2021-06-03 01:02:19'),
(1493, 'en', 0, 1016780, '2021-06-03 02:20:48', '2021-06-03 02:20:48'),
(1494, 'en', 0, 1016781, '2021-06-03 02:47:26', '2021-06-03 02:47:26'),
(1495, 'ar', 0, 1016782, '2021-06-03 10:27:55', '2021-06-04 00:12:55'),
(1496, 'en', 0, 1016783, '2021-06-03 10:57:53', '2021-06-03 10:57:53'),
(1497, 'ar', 0, 1016784, '2021-06-03 11:04:22', '2021-06-03 11:04:39'),
(1498, 'ar', 0, 1016785, '2021-06-03 12:03:40', '2021-06-03 12:04:13'),
(1499, 'en', 0, 1016786, '2021-06-03 14:06:34', '2021-06-03 14:06:34'),
(1500, 'ar', 0, 1016787, '2021-06-03 15:26:31', '2021-06-03 15:27:20'),
(1501, 'en', 0, 1016788, '2021-06-03 18:57:10', '2021-06-03 18:57:10'),
(1502, 'en', 0, 1016789, '2021-06-03 19:27:22', '2021-06-03 19:27:22'),
(1503, 'en', 0, 1016790, '2021-06-03 19:51:31', '2021-06-03 19:51:31'),
(1504, 'en', 0, 1016621, '2021-06-03 21:12:45', '2021-06-03 21:12:45'),
(1505, 'en', 0, 1016791, '2021-06-03 21:52:51', '2021-06-03 21:52:51'),
(1506, 'ar', 0, 1016792, '2021-06-04 00:25:53', '2021-06-04 00:26:32'),
(1507, 'en', 0, 1016793, '2021-06-04 01:27:25', '2021-06-04 01:27:25'),
(1508, 'en', 0, 1016794, '2021-06-04 04:10:46', '2021-06-04 04:10:46'),
(1509, 'en', 0, 1016795, '2021-06-04 08:19:12', '2021-06-04 08:19:12'),
(1510, 'en', 0, 1016796, '2021-06-04 10:44:55', '2021-06-04 10:44:55'),
(1511, 'ar', 0, 1016797, '2021-06-04 13:06:30', '2021-06-04 13:06:42'),
(1512, 'en', 0, 1016798, '2021-06-04 14:54:58', '2021-06-04 14:54:58'),
(1513, 'en', 0, 1016750, '2021-06-04 15:06:07', '2021-06-04 15:06:07'),
(1514, 'en', 0, 1016799, '2021-06-04 15:48:34', '2021-06-04 15:48:34'),
(1515, 'en', 0, 1016800, '2021-06-04 18:25:20', '2021-06-04 18:25:20'),
(1516, 'ar', 0, 1016801, '2021-06-04 19:47:57', '2021-06-04 19:48:31'),
(1517, 'en', 0, 1016802, '2021-06-04 21:24:48', '2021-06-04 21:24:48'),
(1518, 'ar', 0, 1016803, '2021-06-05 01:19:40', '2021-06-05 01:22:11'),
(1519, 'en', 0, 1016804, '2021-06-05 01:33:31', '2021-06-05 01:33:31'),
(1520, 'en', 0, 1016805, '2021-06-05 02:42:52', '2021-06-05 02:42:52'),
(1521, 'en', 0, 1016806, '2021-06-05 03:09:35', '2021-06-05 03:09:35'),
(1522, 'en', 0, 1016807, '2021-06-05 06:54:29', '2021-06-05 06:54:29'),
(1523, 'ar', 0, 1016808, '2021-06-05 08:39:37', '2021-06-05 08:42:02'),
(1524, 'ar', 0, 1016809, '2021-06-05 11:16:40', '2021-06-05 11:17:30'),
(1525, 'en', 0, 1016810, '2021-06-05 13:48:32', '2021-06-05 13:48:32'),
(1526, 'ar', 0, 1016811, '2021-06-05 13:53:14', '2021-06-05 13:59:20'),
(1527, 'en', 0, 1016812, '2021-06-05 16:16:43', '2021-06-05 16:16:43'),
(1528, 'ar', 0, 1016813, '2021-06-05 16:21:09', '2021-06-05 16:23:05'),
(1529, 'en', 0, 1016813, '2021-06-05 16:30:55', '2021-06-05 16:30:55'),
(1530, 'en', 0, 1016814, '2021-06-05 16:32:36', '2021-06-05 16:32:36'),
(1531, 'en', 0, 1016815, '2021-06-05 18:38:54', '2021-06-05 18:38:54'),
(1532, 'en', 0, 1016816, '2021-06-05 21:43:19', '2021-06-05 21:43:19'),
(1533, 'en', 0, 1016817, '2021-06-05 23:17:37', '2021-06-05 23:17:37'),
(1534, 'en', 0, 1016818, '2021-06-06 00:03:44', '2021-06-06 00:03:44'),
(1535, 'en', 0, 1016819, '2021-06-06 00:53:01', '2021-06-06 00:53:01'),
(1536, 'ar', 0, 1016820, '2021-06-06 01:01:33', '2021-06-06 01:01:48'),
(1537, 'en', 0, 1016821, '2021-06-06 10:18:03', '2021-06-06 10:18:03'),
(1538, 'en', 0, 1016822, '2021-06-06 13:10:59', '2021-06-06 13:10:59'),
(1539, 'en', 0, 1016823, '2021-06-06 17:26:55', '2021-06-06 17:26:55'),
(1540, 'en', 0, 1016824, '2021-06-06 19:00:49', '2021-06-06 19:00:49'),
(1541, 'en', 0, 1016825, '2021-06-06 21:58:51', '2021-06-06 21:58:51'),
(1542, 'en', 0, 1016826, '2021-06-06 22:52:33', '2021-06-06 22:52:33'),
(1543, 'en', 0, 1016827, '2021-06-06 23:18:35', '2021-06-06 23:18:35'),
(1544, 'en', 0, 1016828, '2021-06-06 23:38:59', '2021-06-06 23:40:01'),
(1545, 'en', 0, 1016829, '2021-06-07 00:04:25', '2021-06-07 00:04:25'),
(1546, 'ar', 0, 1016830, '2021-06-07 02:16:22', '2021-06-07 02:17:37'),
(1547, 'en', 0, 1016831, '2021-06-07 02:49:13', '2021-06-07 02:49:13'),
(1548, 'en', 0, 1016294, '2021-06-07 06:11:00', '2021-06-07 06:11:00'),
(1549, 'en', 0, 1016832, '2021-06-07 06:58:39', '2021-06-07 06:58:39'),
(1550, 'en', 0, 1016833, '2021-06-07 08:50:30', '2021-06-07 08:50:30'),
(1551, 'en', 0, 1016834, '2021-06-07 09:24:15', '2021-06-07 09:24:15'),
(1552, 'en', 0, 1016835, '2021-06-07 10:05:24', '2021-06-07 10:05:24'),
(1553, 'en', 0, 1016836, '2021-06-07 11:05:37', '2021-06-07 11:05:37'),
(1554, 'ar', 0, 1016837, '2021-06-07 11:09:09', '2021-06-07 11:10:05'),
(1555, 'en', 0, 1016838, '2021-06-07 12:56:03', '2021-06-07 12:56:03'),
(1556, 'ar', 0, 1016839, '2021-06-07 14:30:27', '2021-06-07 14:31:57'),
(1557, 'ar', 0, 1016840, '2021-06-07 14:43:38', '2021-06-07 17:36:39'),
(1558, 'ar', 0, 1016841, '2021-06-07 14:43:51', '2021-06-07 14:44:36'),
(1559, 'en', 0, 1016842, '2021-06-07 14:54:24', '2021-06-07 14:54:24'),
(1560, 'en', 0, 1016843, '2021-06-07 14:56:21', '2021-06-07 14:56:21'),
(1561, 'en', 0, 1016844, '2021-06-07 15:45:30', '2021-06-07 15:45:30'),
(1562, 'en', 0, 1016845, '2021-06-07 16:39:32', '2021-06-07 16:39:32'),
(1563, 'en', 0, 1016846, '2021-06-07 18:05:22', '2021-06-07 18:05:22'),
(1564, 'en', 0, 1016847, '2021-06-07 20:12:14', '2021-06-07 20:12:14'),
(1565, 'ar', 0, 1016848, '2021-06-07 20:12:37', '2021-06-07 20:13:37'),
(1566, 'ar', 0, 1016849, '2021-06-07 20:27:19', '2021-06-07 20:28:14'),
(1567, 'ar', 0, 1016850, '2021-06-07 22:56:40', '2021-06-07 22:56:58'),
(1568, 'en', 0, 1016851, '2021-06-07 23:36:48', '2021-06-07 23:36:48'),
(1569, 'en', 0, 1016852, '2021-06-08 04:58:23', '2021-06-08 04:58:23'),
(1570, 'en', 0, 1016853, '2021-06-08 06:32:31', '2021-06-08 06:32:31'),
(1571, 'en', 0, 1016854, '2021-06-08 10:15:07', '2021-06-08 10:15:07'),
(1572, 'en', 0, 1016855, '2021-06-08 11:17:01', '2021-06-08 11:17:01'),
(1573, 'ar', 0, 1016856, '2021-06-08 11:30:21', '2021-06-08 11:31:03'),
(1574, 'en', 0, 1016857, '2021-06-08 13:29:31', '2021-06-08 13:29:31'),
(1575, 'ar', 0, 1016858, '2021-06-08 13:30:32', '2021-06-08 13:31:33'),
(1576, 'en', 0, 1016859, '2021-06-08 16:38:50', '2021-06-08 16:38:50'),
(1577, 'en', 0, 1016860, '2021-06-08 17:16:55', '2021-06-08 17:16:55'),
(1578, 'en', 0, 1016861, '2021-06-08 17:30:24', '2021-06-08 17:30:24'),
(1579, 'en', 0, 1016862, '2021-06-08 17:33:35', '2021-06-08 17:33:35'),
(1580, 'en', 0, 1016863, '2021-06-08 18:09:41', '2021-06-08 18:09:41'),
(1581, 'en', 0, 1016864, '2021-06-08 18:19:01', '2021-06-08 18:19:01'),
(1582, 'ar', 0, 1016865, '2021-06-08 19:24:42', '2021-06-08 19:25:37'),
(1583, 'ar', 0, 1016866, '2021-06-08 20:01:19', '2021-06-08 20:01:52'),
(1584, 'en', 0, 1016867, '2021-06-08 20:04:57', '2021-06-08 20:04:57'),
(1585, 'ar', 0, 1016868, '2021-06-08 20:54:00', '2021-06-08 20:58:40'),
(1586, 'en', 0, 1016869, '2021-06-08 21:02:07', '2021-06-08 21:02:07'),
(1587, 'en', 0, 1016870, '2021-06-08 21:26:52', '2021-06-08 21:26:52'),
(1588, 'ar', 0, 1016871, '2021-06-08 21:49:26', '2021-06-08 21:50:05'),
(1589, 'en', 0, 1016872, '2021-06-09 00:09:32', '2021-06-09 00:09:32'),
(1590, 'en', 0, 1016873, '2021-06-09 01:27:01', '2021-06-09 01:27:01'),
(1591, 'en', 0, 1016874, '2021-06-09 02:42:37', '2021-06-09 02:42:37'),
(1592, 'ar', 0, 1016875, '2021-06-09 03:06:35', '2021-06-09 03:06:42'),
(1593, 'en', 0, 1016876, '2021-06-09 08:43:33', '2021-06-09 08:43:33'),
(1594, 'ar', 0, 1016877, '2021-06-09 09:51:37', '2021-06-09 09:59:03'),
(1595, 'en', 0, 1016878, '2021-06-09 10:48:03', '2021-06-09 10:48:03'),
(1596, 'ar', 0, 1016879, '2021-06-09 11:40:11', '2021-06-09 11:40:47'),
(1597, 'en', 0, 1016880, '2021-06-09 12:15:35', '2021-06-09 12:15:35'),
(1598, 'ar', 0, 1016881, '2021-06-09 12:19:14', '2021-06-09 12:19:31'),
(1599, 'en', 0, 1016882, '2021-06-09 12:22:23', '2021-06-09 12:22:23'),
(1600, 'ar', 0, 1016883, '2021-06-09 13:08:48', '2021-06-09 13:10:43'),
(1601, 'en', 0, 1016884, '2021-06-09 13:17:09', '2021-06-09 13:17:09'),
(1602, 'en', 0, 1016885, '2021-06-09 21:05:17', '2021-06-09 21:05:17'),
(1603, 'en', 0, 1016886, '2021-06-09 23:32:13', '2021-06-09 23:32:13'),
(1604, 'en', 0, 1016887, '2021-06-10 00:14:39', '2021-06-10 00:14:39'),
(1605, 'en', 0, 1016888, '2021-06-10 00:44:41', '2021-06-10 00:44:41'),
(1606, 'en', 0, 1016889, '2021-06-10 00:56:14', '2021-06-10 00:56:14'),
(1607, 'en', 0, 1016890, '2021-06-10 02:38:29', '2021-06-10 02:38:29'),
(1608, 'en', 0, 1016891, '2021-06-10 04:30:06', '2021-06-10 04:30:06'),
(1609, 'ar', 0, 1016892, '2021-06-10 04:31:08', '2021-06-10 04:31:24'),
(1610, 'en', 0, 1016893, '2021-06-10 05:14:12', '2021-06-10 05:14:12'),
(1611, 'en', 0, 1016894, '2021-06-10 05:56:48', '2021-06-10 05:56:48'),
(1612, 'en', 0, 1016895, '2021-06-10 06:11:29', '2021-06-10 06:12:33'),
(1613, 'en', 0, 1016896, '2021-06-10 06:18:41', '2021-06-10 06:18:41'),
(1614, 'ar', 0, 1016897, '2021-06-10 10:13:36', '2021-06-10 10:14:00'),
(1615, 'en', 0, 1016898, '2021-06-10 10:27:22', '2021-06-10 10:27:22'),
(1616, 'ar', 0, 1016899, '2021-06-10 13:31:29', '2021-06-10 13:31:52'),
(1617, 'en', 0, 1016900, '2021-06-10 13:46:16', '2021-06-10 13:46:16'),
(1618, 'en', 0, 1016901, '2021-06-10 14:33:30', '2021-06-10 14:33:30'),
(1619, 'en', 0, 1016902, '2021-06-10 14:55:21', '2021-06-10 14:55:21'),
(1620, 'en', 0, 1016903, '2021-06-10 15:55:58', '2021-06-10 15:55:58'),
(1621, 'en', 0, 1016904, '2021-06-10 16:21:15', '2021-06-10 16:21:15'),
(1622, 'en', 0, 1016905, '2021-06-10 16:27:11', '2021-06-10 16:27:11'),
(1623, 'ar', 0, 1016906, '2021-06-10 18:08:41', '2021-06-10 18:10:14'),
(1624, 'en', 0, 1016907, '2021-06-10 19:10:37', '2021-06-10 19:10:37'),
(1625, 'en', 0, 1016908, '2021-06-10 21:32:01', '2021-06-10 21:32:01'),
(1626, 'en', 0, 1016909, '2021-06-11 01:58:43', '2021-06-11 01:58:43'),
(1627, 'en', 0, 1016910, '2021-06-11 02:05:04', '2021-06-11 02:05:04'),
(1628, 'ar', 0, 1016911, '2021-06-11 02:06:09', '2021-06-11 02:10:43'),
(1629, 'en', 0, 1016912, '2021-06-11 04:03:30', '2021-06-11 04:03:30'),
(1630, 'ar', 0, 1016913, '2021-06-11 07:05:48', '2021-06-11 07:06:20'),
(1631, 'en', 0, 1016727, '2021-06-11 13:40:14', '2021-06-11 13:40:14'),
(1632, 'en', 0, 1016914, '2021-06-11 14:50:27', '2021-06-11 14:50:27'),
(1633, 'ar', 0, 1016915, '2021-06-11 19:02:07', '2021-06-11 19:13:52'),
(1634, 'en', 0, 1016916, '2021-06-11 19:31:59', '2021-06-11 19:31:59'),
(1635, 'en', 0, 1016917, '2021-06-11 21:11:43', '2021-06-11 21:11:43'),
(1636, 'en', 0, 1016918, '2021-06-11 22:10:18', '2021-06-11 22:10:18'),
(1637, 'ar', 0, 1016919, '2021-06-11 22:20:53', '2021-06-11 22:22:29'),
(1638, 'en', 0, 1016920, '2021-06-11 22:58:51', '2021-06-11 22:58:51'),
(1639, 'en', 0, 1016921, '2021-06-11 23:11:25', '2021-06-11 23:11:25'),
(1640, 'ar', 0, 1016922, '2021-06-11 23:39:17', '2021-06-11 23:40:45'),
(1641, 'ar', 0, 1016923, '2021-06-12 00:35:47', '2021-06-12 00:36:36'),
(1642, 'en', 0, 1016924, '2021-06-12 01:37:36', '2021-06-12 01:37:36'),
(1643, 'ar', 0, 1016925, '2021-06-12 01:51:38', '2021-06-12 01:53:53'),
(1644, 'ar', 0, 1016926, '2021-06-12 02:12:31', '2021-06-12 09:24:26'),
(1645, 'en', 0, 1016927, '2021-06-12 10:17:11', '2021-06-12 10:17:11'),
(1646, 'ar', 0, 1016928, '2021-06-12 12:38:33', '2021-06-12 12:48:30'),
(1647, 'en', 0, 1016929, '2021-06-12 14:07:53', '2021-06-12 14:07:53'),
(1648, 'ar', 0, 1016930, '2021-06-12 14:30:11', '2021-06-12 14:32:17'),
(1649, 'en', 0, 1016931, '2021-06-12 14:40:36', '2021-06-12 14:40:36'),
(1650, 'ar', 0, 1016932, '2021-06-12 21:22:20', '2021-06-12 21:25:41'),
(1651, 'ar', 0, 1016933, '2021-06-13 03:58:13', '2021-06-13 03:58:58'),
(1652, 'en', 0, 1016934, '2021-06-13 04:55:56', '2021-06-13 04:55:56'),
(1653, 'en', 0, 1016935, '2021-06-13 05:28:57', '2021-06-13 05:28:57'),
(1654, 'en', 0, 1016936, '2021-06-13 08:02:19', '2021-06-13 08:02:19'),
(1655, 'ar', 0, 1016937, '2021-06-13 08:23:11', '2021-06-13 08:25:14'),
(1656, 'ar', 0, 1016938, '2021-06-13 10:01:33', '2021-06-13 10:02:14'),
(1657, 'en', 0, 1016491, '2021-06-13 10:12:35', '2021-06-13 10:12:35'),
(1658, 'en', 0, 1016939, '2021-06-13 12:15:01', '2021-06-13 12:15:01'),
(1659, 'en', 0, 1016940, '2021-06-13 15:41:32', '2021-06-13 15:41:32'),
(1660, 'en', 0, 1016941, '2021-06-13 16:24:22', '2021-06-13 16:24:22'),
(1661, 'ar', 0, 1016942, '2021-06-13 17:17:29', '2021-06-13 17:17:51'),
(1662, 'en', 0, 1016943, '2021-06-13 17:18:53', '2021-06-13 17:18:53'),
(1663, 'en', 0, 1016944, '2021-06-13 17:46:14', '2021-06-13 17:46:14'),
(1664, 'en', 0, 1016919, '2021-06-13 18:38:21', '2021-06-13 18:38:21'),
(1665, 'ar', 0, 1016945, '2021-06-13 20:33:27', '2021-06-13 20:34:31'),
(1666, 'ar', 0, 1016946, '2021-06-13 20:40:44', '2021-06-14 20:50:29'),
(1667, 'en', 0, 1016947, '2021-06-13 20:45:25', '2021-06-13 20:45:25'),
(1668, 'en', 0, 1016760, '2021-06-13 21:46:04', '2021-06-13 21:46:04'),
(1669, 'en', 0, 1016948, '2021-06-13 23:34:49', '2021-06-13 23:34:49'),
(1670, 'en', 0, 1016949, '2021-06-14 01:31:06', '2021-06-14 01:31:06'),
(1671, 'en', 0, 1016950, '2021-06-14 05:14:59', '2021-06-14 05:14:59'),
(1672, 'ar', 0, 1016951, '2021-06-14 05:32:32', '2021-06-15 23:31:46'),
(1673, 'en', 0, 1016768, '2021-06-14 13:50:54', '2021-06-14 13:50:54'),
(1674, 'en', 0, 1016952, '2021-06-14 15:12:48', '2021-06-14 15:12:48'),
(1675, 'en', 0, 1016953, '2021-06-14 15:38:37', '2021-06-14 15:38:37'),
(1676, 'en', 0, 1016954, '2021-06-14 15:48:32', '2021-06-14 15:48:32'),
(1677, 'ar', 0, 1016955, '2021-06-14 17:46:12', '2021-06-14 17:46:17'),
(1678, 'en', 0, 1016956, '2021-06-14 23:55:18', '2021-06-14 23:55:18'),
(1679, 'en', 0, 1016957, '2021-06-15 00:57:28', '2021-06-15 00:57:28'),
(1680, 'ar', 0, 1016958, '2021-06-15 02:49:09', '2021-06-15 02:49:28'),
(1681, 'ar', 0, 1016959, '2021-06-15 02:50:29', '2021-06-15 02:52:58'),
(1682, 'en', 0, 1016960, '2021-06-15 03:22:54', '2021-06-15 03:22:54'),
(1683, 'ar', 0, 1016961, '2021-06-15 10:10:43', '2021-06-15 10:16:14'),
(1684, 'en', 0, 1016962, '2021-06-15 12:37:14', '2021-06-15 12:37:14'),
(1685, 'en', 0, 1016963, '2021-06-15 12:52:43', '2021-06-15 12:52:43'),
(1686, 'ar', 0, 1016964, '2021-06-15 14:56:02', '2021-06-21 13:36:45'),
(1687, 'en', 0, 1016965, '2021-06-15 16:09:30', '2021-06-15 16:09:30'),
(1688, 'en', 0, 1016966, '2021-06-15 16:40:01', '2021-06-15 16:40:01'),
(1689, 'en', 0, 1016968, '2021-06-15 22:08:35', '2021-06-15 22:08:35'),
(1690, 'en', 0, 1016969, '2021-06-15 22:15:31', '2021-06-15 22:15:31'),
(1691, 'en', 0, 1016970, '2021-06-15 23:54:46', '2021-06-15 23:54:46'),
(1692, 'ar', 0, 1016971, '2021-06-16 01:35:38', '2021-06-16 01:36:35'),
(1693, 'en', 0, 1016972, '2021-06-16 01:56:41', '2021-06-16 01:56:41'),
(1694, 'ar', 0, 1016973, '2021-06-16 02:08:22', '2021-06-16 02:08:56'),
(1695, 'ar', 0, 1016974, '2021-06-16 02:28:53', '2021-06-16 02:29:28'),
(1696, 'en', 0, 1016975, '2021-06-16 08:21:13', '2021-06-16 08:21:13'),
(1697, 'en', 0, 1016976, '2021-06-16 10:16:53', '2021-06-16 10:16:53'),
(1698, 'en', 0, 1016977, '2021-06-16 11:53:29', '2021-06-16 11:53:29'),
(1699, 'en', 0, 1016978, '2021-06-16 11:59:54', '2021-06-16 11:59:54'),
(1700, 'ar', 0, 1016979, '2021-06-16 12:23:32', '2021-06-16 12:24:02'),
(1701, 'ar', 0, 1016980, '2021-06-16 13:54:54', '2021-06-16 13:55:00'),
(1702, 'en', 0, 1016981, '2021-06-16 13:56:59', '2021-06-16 13:56:59'),
(1703, 'en', 0, 1016982, '2021-06-16 14:31:51', '2021-06-16 14:31:51'),
(1704, 'en', 0, 1016983, '2021-06-16 15:14:01', '2021-06-16 15:14:01'),
(1705, 'en', 0, 1016984, '2021-06-16 15:15:50', '2021-06-16 15:15:50'),
(1706, 'en', 0, 1016985, '2021-06-16 16:40:42', '2021-06-16 16:40:42'),
(1707, 'en', 0, 1016986, '2021-06-16 16:42:56', '2021-06-16 16:42:56'),
(1708, 'en', 0, 1016987, '2021-06-16 16:44:23', '2021-06-16 16:44:23'),
(1709, 'en', 0, 1016988, '2021-06-16 16:48:02', '2021-06-16 16:48:02'),
(1710, 'en', 0, 1016989, '2021-06-16 16:50:25', '2021-06-16 16:50:25'),
(1711, 'en', 0, 1016990, '2021-06-16 16:55:20', '2021-06-16 16:55:20'),
(1712, 'en', 0, 1016991, '2021-06-16 17:21:09', '2021-06-16 17:21:09'),
(1713, 'ar', 0, 1016992, '2021-06-16 17:25:36', '2021-06-16 17:26:53'),
(1714, 'ar', 0, 1016993, '2021-06-16 17:29:01', '2021-06-16 17:29:38'),
(1715, 'ar', 0, 1016994, '2021-06-16 17:44:49', '2021-06-16 17:44:55'),
(1716, 'en', 0, 1016995, '2021-06-16 18:07:50', '2021-06-16 18:07:50'),
(1717, 'en', 0, 1016996, '2021-06-16 18:56:53', '2021-06-16 18:56:53'),
(1718, 'en', 0, 1016997, '2021-06-16 20:27:16', '2021-06-16 20:27:16'),
(1719, 'ar', 0, 1016998, '2021-06-16 21:04:12', '2021-06-16 21:05:04'),
(1720, 'en', 0, 1016999, '2021-06-16 21:10:59', '2021-06-16 21:10:59'),
(1721, 'ar', 0, 1017000, '2021-06-16 21:18:52', '2021-06-16 21:19:17'),
(1722, 'en', 0, 1017001, '2021-06-16 21:20:56', '2021-06-16 21:20:56'),
(1723, 'en', 0, 1017002, '2021-06-16 21:34:23', '2021-06-16 21:34:23'),
(1724, 'en', 0, 1017003, '2021-06-16 21:34:38', '2021-06-16 21:34:38'),
(1725, 'en', 0, 1017004, '2021-06-16 21:34:51', '2021-06-16 21:34:51'),
(1726, 'ar', 0, 1017005, '2021-06-16 21:56:18', '2021-06-23 13:41:38'),
(1727, 'en', 0, 1017006, '2021-06-16 22:10:01', '2021-06-16 22:10:01'),
(1728, 'en', 0, 1017007, '2021-06-16 22:13:36', '2021-06-16 22:13:36'),
(1729, 'ar', 0, 1017008, '2021-06-17 00:59:05', '2021-06-17 01:00:51'),
(1730, 'en', 0, 1017009, '2021-06-17 01:13:56', '2021-06-17 01:13:56'),
(1731, 'en', 0, 1017010, '2021-06-17 02:38:46', '2021-06-17 02:38:46'),
(1732, 'ar', 0, 1017011, '2021-06-17 03:31:15', '2021-06-17 06:44:55'),
(1733, 'en', 0, 1017012, '2021-06-17 07:18:10', '2021-06-17 07:18:10'),
(1734, 'en', 0, 1017013, '2021-06-17 07:22:23', '2021-06-17 07:22:23'),
(1735, 'en', 0, 1017014, '2021-06-17 09:13:07', '2021-06-17 09:13:07'),
(1736, 'en', 0, 1017015, '2021-06-17 10:47:13', '2021-06-17 10:47:13'),
(1737, 'ar', 0, 1017016, '2021-06-17 13:11:07', '2021-06-17 13:13:03'),
(1738, 'en', 0, 1017017, '2021-06-17 13:54:47', '2021-06-17 13:54:47'),
(1739, 'en', 0, 1017018, '2021-06-17 14:05:46', '2021-06-17 14:05:46'),
(1740, 'en', 0, 1017019, '2021-06-17 14:22:27', '2021-06-17 14:22:27'),
(1741, 'en', 0, 1017020, '2021-06-17 14:45:00', '2021-06-17 14:45:00'),
(1742, 'en', 0, 1017021, '2021-06-17 14:46:17', '2021-06-17 14:46:17'),
(1743, 'en', 0, 1017022, '2021-06-17 15:03:58', '2021-06-17 15:03:58'),
(1744, 'en', 0, 1017023, '2021-06-17 15:37:23', '2021-06-17 15:37:23'),
(1745, 'ar', 0, 1017024, '2021-06-17 16:25:45', '2021-06-17 16:26:19'),
(1746, 'en', 0, 1017025, '2021-06-17 16:36:34', '2021-06-17 16:36:34'),
(1747, 'en', 0, 1017026, '2021-06-17 17:10:19', '2021-06-17 17:10:19'),
(1748, 'en', 0, 1017027, '2021-06-17 17:16:04', '2021-06-17 17:16:04'),
(1749, 'ar', 0, 1017028, '2021-06-17 17:21:00', '2021-06-17 17:24:20'),
(1750, 'ar', 0, 1017029, '2021-06-17 17:58:43', '2021-06-17 19:29:19'),
(1751, 'en', 0, 1017030, '2021-06-17 18:34:31', '2021-06-17 18:35:25'),
(1752, 'en', 0, 1017031, '2021-06-17 18:56:40', '2021-06-17 18:56:40'),
(1753, 'en', 0, 1017032, '2021-06-17 18:57:36', '2021-06-17 18:57:36'),
(1754, 'en', 0, 1017033, '2021-06-17 19:32:31', '2021-06-17 19:32:31'),
(1755, 'en', 0, 1017034, '2021-06-17 20:29:03', '2021-06-17 20:29:03'),
(1756, 'en', 0, 1016998, '2021-06-17 23:36:08', '2021-06-17 23:36:08'),
(1757, 'en', 0, 1017035, '2021-06-17 23:36:19', '2021-06-17 23:36:19'),
(1758, 'en', 0, 1017036, '2021-06-17 23:59:49', '2021-06-17 23:59:49'),
(1759, 'ar', 0, 1017037, '2021-06-18 00:14:27', '2021-06-18 00:14:30'),
(1760, 'ar', 0, 1017038, '2021-06-18 00:30:03', '2021-06-18 00:40:01'),
(1761, 'en', 0, 1017039, '2021-06-18 02:20:45', '2021-06-18 02:20:45'),
(1762, 'ar', 0, 1017040, '2021-06-18 04:41:52', '2021-06-18 04:42:11'),
(1763, 'ar', 0, 1017041, '2021-06-18 08:26:31', '2021-06-18 08:27:57'),
(1764, 'en', 0, 1017042, '2021-06-18 12:28:47', '2021-06-18 12:28:47'),
(1765, 'en', 0, 1017043, '2021-06-18 13:02:43', '2021-06-18 13:02:43'),
(1766, 'ar', 0, 1017044, '2021-06-18 13:19:15', '2021-06-18 13:19:45'),
(1767, 'en', 0, 1017045, '2021-06-18 18:13:38', '2021-06-18 18:13:38'),
(1768, 'en', 0, 1017046, '2021-06-18 18:22:49', '2021-06-18 18:22:49'),
(1769, 'en', 0, 1017047, '2021-06-18 18:28:30', '2021-06-18 18:28:30'),
(1770, 'ar', 0, 1017048, '2021-06-18 19:35:08', '2021-06-18 19:35:55'),
(1771, 'en', 0, 1017049, '2021-06-18 19:57:48', '2021-06-18 19:57:48'),
(1772, 'ar', 0, 1017050, '2021-06-18 20:03:54', '2021-06-18 20:04:15'),
(1773, 'en', 0, 1017051, '2021-06-18 20:38:49', '2021-06-18 20:38:49'),
(1774, 'ar', 0, 1017052, '2021-06-19 02:16:02', '2021-06-19 02:16:03'),
(1775, 'en', 0, 1017053, '2021-06-19 02:22:38', '2021-06-19 02:22:38'),
(1776, 'en', 0, 1017054, '2021-06-19 11:44:11', '2021-06-19 11:44:11'),
(1777, 'en', 0, 1017055, '2021-06-19 13:17:07', '2021-06-19 13:17:07'),
(1778, 'en', 0, 1017056, '2021-06-19 13:31:22', '2021-06-19 13:31:22'),
(1779, 'en', 0, 1017057, '2021-06-19 13:42:19', '2021-06-19 13:42:19'),
(1780, 'en', 0, 1017058, '2021-06-19 13:54:56', '2021-06-19 13:54:56'),
(1781, 'ar', 0, 1017059, '2021-06-19 14:24:46', '2021-06-19 14:25:36'),
(1782, 'ar', 0, 1017060, '2021-06-19 15:26:58', '2021-06-19 15:44:35'),
(1783, 'en', 0, 1017061, '2021-06-19 15:38:18', '2021-06-19 15:38:18'),
(1784, 'ar', 0, 1017062, '2021-06-19 15:56:45', '2021-06-19 15:57:23'),
(1785, 'en', 0, 1017063, '2021-06-19 16:21:07', '2021-06-19 16:21:07'),
(1786, 'en', 0, 1017064, '2021-06-19 17:21:08', '2021-06-19 17:21:08'),
(1787, 'en', 0, 1017065, '2021-06-19 17:24:55', '2021-06-19 17:24:55'),
(1788, 'en', 0, 1017066, '2021-06-19 20:31:21', '2021-06-19 20:31:21'),
(1789, 'en', 0, 1017067, '2021-06-19 20:42:51', '2021-06-19 20:42:51'),
(1790, 'en', 0, 1017068, '2021-06-19 21:34:35', '2021-06-19 21:34:35'),
(1791, 'en', 0, 1017069, '2021-06-19 21:56:37', '2021-06-19 21:56:37'),
(1792, 'en', 0, 1017070, '2021-06-19 22:19:24', '2021-06-19 22:19:24'),
(1793, 'ar', 0, 1017071, '2021-06-19 22:50:02', '2021-06-19 22:50:30'),
(1794, 'en', 0, 1017072, '2021-06-19 22:55:06', '2021-06-19 22:55:06'),
(1795, 'en', 0, 1017073, '2021-06-20 00:13:43', '2021-06-20 00:13:43'),
(1796, 'en', 0, 1017074, '2021-06-20 00:21:47', '2021-06-20 00:21:47'),
(1797, 'en', 0, 1017075, '2021-06-20 02:02:52', '2021-06-20 02:05:34'),
(1798, 'ar', 0, 1017076, '2021-06-20 03:03:10', '2021-06-20 03:03:27'),
(1799, 'en', 0, 1017077, '2021-06-20 04:47:53', '2021-06-20 04:47:53'),
(1800, 'en', 0, 1017078, '2021-06-20 11:16:55', '2021-06-20 11:16:55'),
(1801, 'en', 0, 1017079, '2021-06-20 11:37:50', '2021-06-20 11:37:50'),
(1802, 'en', 0, 1017080, '2021-06-20 12:28:37', '2021-06-20 12:28:37'),
(1803, 'en', 0, 1017081, '2021-06-20 13:31:16', '2021-06-20 13:31:16'),
(1804, 'en', 0, 1017082, '2021-06-20 13:32:16', '2021-06-20 13:32:16'),
(1805, 'en', 0, 1017083, '2021-06-20 13:54:36', '2021-06-20 13:54:36'),
(1806, 'en', 0, 1017084, '2021-06-20 14:10:39', '2021-06-20 14:10:39'),
(1807, 'en', 0, 1017085, '2021-06-20 17:29:13', '2021-06-20 17:29:13'),
(1808, 'ar', 0, 1017086, '2021-06-20 18:34:55', '2021-06-20 18:37:10'),
(1809, 'en', 0, 1017060, '2021-06-20 19:43:31', '2021-06-20 19:43:31'),
(1810, 'ar', 0, 1017087, '2021-06-20 19:53:30', '2021-06-20 19:53:36'),
(1811, 'en', 0, 1017088, '2021-06-20 20:52:40', '2021-06-20 20:52:40'),
(1812, 'en', 0, 1017089, '2021-06-20 22:55:55', '2021-06-20 22:55:55'),
(1813, 'en', 0, 1017090, '2021-06-20 23:13:50', '2021-06-20 23:13:50'),
(1814, 'en', 0, 1017091, '2021-06-21 00:06:49', '2021-06-21 00:06:49'),
(1815, 'en', 0, 1017092, '2021-06-21 05:21:47', '2021-06-21 05:21:47'),
(1816, 'ar', 0, 1017093, '2021-06-21 07:38:07', '2021-06-21 07:42:48'),
(1817, 'en', 0, 1017094, '2021-06-21 14:48:52', '2021-06-21 14:48:52'),
(1818, 'en', 0, 1017095, '2021-06-21 15:52:04', '2021-06-21 15:52:04'),
(1819, 'en', 0, 1017096, '2021-06-21 16:55:13', '2021-06-21 16:55:13'),
(1820, 'en', 0, 1017097, '2021-06-21 18:35:51', '2021-06-21 18:35:51'),
(1821, 'ar', 0, 1017098, '2021-06-21 19:03:15', '2021-06-21 19:06:06'),
(1822, 'en', 0, 1017099, '2021-06-21 19:29:09', '2021-06-21 19:29:09'),
(1823, 'en', 0, 1017100, '2021-06-21 19:39:19', '2021-06-21 19:39:19'),
(1824, 'ar', 0, 1017101, '2021-06-21 19:41:43', '2021-06-22 00:08:54'),
(1825, 'en', 0, 1017102, '2021-06-21 20:50:10', '2021-06-21 20:50:10'),
(1826, 'ar', 0, 1017103, '2021-06-21 21:58:00', '2021-06-23 07:49:01'),
(1827, 'ar', 0, 1017104, '2021-06-21 22:13:26', '2021-06-21 22:13:59'),
(1828, 'ar', 0, 1017105, '2021-06-21 22:49:45', '2021-06-21 22:49:46'),
(1829, 'en', 0, 1017106, '2021-06-21 22:50:39', '2021-06-21 22:50:39'),
(1830, 'en', 0, 1017107, '2021-06-22 02:28:46', '2021-06-22 02:28:46'),
(1831, 'en', 0, 1017108, '2021-06-22 06:33:36', '2021-06-22 06:33:36'),
(1832, 'en', 0, 1017109, '2021-06-22 13:08:21', '2021-06-22 13:08:21'),
(1833, 'en', 0, 1017110, '2021-06-22 14:42:52', '2021-06-22 14:42:52'),
(1834, 'en', 0, 1017111, '2021-06-22 14:59:16', '2021-06-22 14:59:16'),
(1835, 'ar', 0, 1017112, '2021-06-22 17:06:14', '2021-06-22 17:06:40'),
(1836, 'en', 0, 1017113, '2021-06-22 19:03:13', '2021-06-22 19:03:13'),
(1837, 'ar', 0, 1017114, '2021-06-22 19:04:49', '2021-06-22 19:07:45'),
(1838, 'en', 0, 1017115, '2021-06-22 20:09:42', '2021-06-22 20:09:42'),
(1839, 'ar', 0, 1017116, '2021-06-22 21:16:37', '2021-06-22 21:21:41'),
(1840, 'en', 0, 1016811, '2021-06-22 23:48:05', '2021-06-22 23:48:05'),
(1841, 'en', 0, 1017117, '2021-06-22 23:49:06', '2021-06-22 23:58:30'),
(1842, 'en', 0, 1017118, '2021-06-23 00:16:23', '2021-06-23 00:16:23'),
(1843, 'en', 0, 1017119, '2021-06-23 02:38:46', '2021-06-23 02:38:46'),
(1844, 'en', 0, 1017120, '2021-06-23 04:03:23', '2021-06-23 04:03:23'),
(1845, 'en', 0, 1017121, '2021-06-23 06:07:55', '2021-06-23 06:07:55'),
(1846, 'ar', 0, 1017122, '2021-06-23 06:45:23', '2021-06-23 06:47:06'),
(1847, 'ar', 0, 1017123, '2021-06-23 10:50:39', '2021-06-23 10:53:31'),
(1848, 'ar', 0, 1017124, '2021-06-23 15:39:11', '2021-06-23 15:40:34'),
(1849, 'en', 0, 1017125, '2021-06-23 16:36:12', '2021-06-23 16:36:12'),
(1850, 'ar', 0, 1017126, '2021-06-23 17:04:35', '2021-06-23 17:04:58'),
(1851, 'ar', 0, 1017127, '2021-06-23 17:07:50', '2021-06-23 17:09:36'),
(1852, 'ar', 0, 1017128, '2021-06-23 17:53:44', '2021-06-23 20:37:29'),
(1853, 'ar', 0, 1017129, '2021-06-23 17:57:59', '2021-06-23 18:00:20'),
(1854, 'en', 0, 1017130, '2021-06-23 18:02:28', '2021-06-23 18:02:28'),
(1855, 'en', 0, 1017131, '2021-06-23 20:05:42', '2021-06-23 20:05:42'),
(1856, 'en', 0, 1017132, '2021-06-23 20:08:52', '2021-06-23 20:08:52'),
(1857, 'en', 0, 1017133, '2021-06-24 00:04:47', '2021-06-24 00:04:47'),
(1858, 'ar', 0, 1017134, '2021-06-24 02:28:21', '2021-06-24 02:29:53'),
(1859, 'en', 0, 1017135, '2021-06-24 03:16:46', '2021-06-24 03:16:46'),
(1860, 'ar', 0, 1017136, '2021-06-24 17:03:24', '2021-06-24 17:03:45'),
(1861, 'en', 0, 1017137, '2021-06-24 22:17:55', '2021-06-24 22:17:55'),
(1862, 'ar', 0, 1017138, '2021-06-25 01:23:45', '2021-06-25 01:29:21'),
(1863, 'en', 0, 1017139, '2021-06-25 13:30:38', '2021-06-25 13:30:38'),
(1864, 'en', 0, 1017140, '2021-06-25 15:26:26', '2021-06-25 15:26:26'),
(1865, 'en', 0, 1017141, '2021-06-25 18:18:20', '2021-06-25 18:18:20'),
(1866, 'en', 0, 1017142, '2021-06-25 18:57:20', '2021-06-25 18:57:20'),
(1867, 'en', 0, 1017143, '2021-06-25 19:03:26', '2021-06-25 19:03:26'),
(1868, 'en', 0, 1017144, '2021-06-25 19:20:57', '2021-06-25 19:20:57'),
(1869, 'ar', 0, 1017145, '2021-06-25 21:31:52', '2021-06-25 21:33:30'),
(1870, 'ar', 0, 1017146, '2021-06-25 21:55:33', '2021-06-25 21:56:19'),
(1871, 'en', 0, 1017147, '2021-06-25 22:05:00', '2021-06-25 22:05:00'),
(1872, 'ar', 0, 1017148, '2021-06-25 22:17:40', '2021-06-25 22:17:40'),
(1873, 'ar', 0, 1017149, '2021-06-25 22:30:12', '2021-06-25 22:32:29'),
(1874, 'ar', 0, 1017150, '2021-06-25 23:18:37', '2021-06-25 23:19:34'),
(1875, 'en', 0, 1017151, '2021-06-25 23:33:33', '2021-06-25 23:33:33'),
(1876, 'en', 0, 1017152, '2021-06-25 23:36:30', '2021-06-25 23:36:30'),
(1877, 'en', 0, 1017153, '2021-06-25 23:39:50', '2021-06-25 23:39:50'),
(1878, 'en', 0, 1017154, '2021-06-25 23:45:40', '2021-06-25 23:45:40'),
(1879, 'en', 0, 1017059, '2021-06-26 00:35:28', '2021-06-26 00:35:28'),
(1880, 'ar', 0, 1017155, '2021-06-26 00:37:17', '2021-06-26 00:37:38'),
(1881, 'ar', 0, 1017156, '2021-06-26 01:15:31', '2021-06-26 01:16:11'),
(1882, 'en', 0, 1017157, '2021-06-26 03:05:41', '2021-06-26 03:05:41'),
(1883, 'en', 0, 1017158, '2021-06-26 04:36:29', '2021-06-26 04:36:29'),
(1884, 'ar', 0, 1017159, '2021-06-26 06:12:57', '2021-06-26 06:13:15'),
(1885, 'en', 0, 1017160, '2021-06-26 08:36:11', '2021-06-26 08:36:11'),
(1886, 'en', 0, 1017161, '2021-06-26 12:16:17', '2021-06-26 12:16:17'),
(1887, 'ar', 0, 1017162, '2021-06-26 13:18:55', '2021-06-26 13:19:10'),
(1888, 'en', 0, 1017163, '2021-06-26 15:13:15', '2021-06-26 15:13:15'),
(1889, 'en', 0, 1017164, '2021-06-26 15:22:33', '2021-06-26 15:22:33'),
(1890, 'ar', 0, 1017165, '2021-06-26 16:08:44', '2021-06-26 16:11:47'),
(1891, 'ar', 0, 1017166, '2021-06-26 16:43:40', '2021-06-26 16:44:23'),
(1892, 'ar', 0, 1017167, '2021-06-26 18:15:57', '2021-06-26 18:17:38'),
(1893, 'en', 0, 1017168, '2021-06-26 18:45:40', '2021-06-26 18:45:40'),
(1894, 'ar', 0, 1017169, '2021-06-26 19:05:37', '2021-06-26 19:06:24'),
(1895, 'ar', 0, 1017170, '2021-06-26 21:08:28', '2021-06-26 21:09:18'),
(1896, 'en', 0, 1017171, '2021-06-26 22:57:37', '2021-06-26 22:57:37'),
(1897, 'en', 0, 1017172, '2021-06-26 23:43:29', '2021-06-26 23:43:29'),
(1898, 'en', 0, 1017173, '2021-06-27 01:37:12', '2021-06-27 01:37:12'),
(1899, 'en', 0, 1017174, '2021-06-27 02:19:44', '2021-06-27 02:19:44'),
(1900, 'ar', 0, 1017175, '2021-06-27 03:02:27', '2021-06-27 03:03:53'),
(1901, 'en', 0, 1017176, '2021-06-27 04:08:59', '2021-06-27 04:08:59'),
(1902, 'en', 0, 1017177, '2021-06-27 05:51:53', '2021-06-27 05:51:53'),
(1903, 'en', 0, 1017178, '2021-06-27 11:05:25', '2021-06-27 11:05:25'),
(1904, 'en', 0, 1017179, '2021-06-27 11:06:00', '2021-06-27 11:06:00'),
(1905, 'en', 0, 1017180, '2021-06-27 11:06:18', '2021-06-27 11:06:18'),
(1906, 'en', 0, 1017181, '2021-06-27 11:55:31', '2021-06-27 11:55:31'),
(1907, 'en', 0, 1015419, '2021-06-27 11:57:28', '2021-06-27 11:57:28'),
(1908, 'en', 0, 1017182, '2021-06-27 12:44:06', '2021-06-27 12:44:06'),
(1909, 'en', 0, 1017183, '2021-06-27 13:56:52', '2021-06-27 13:56:52'),
(1910, 'ar', 0, 1017184, '2021-06-27 14:07:40', '2021-06-27 14:09:10'),
(1911, 'en', 0, 1017185, '2021-06-27 14:27:11', '2021-06-27 14:27:11'),
(1912, 'en', 0, 1017186, '2021-06-28 09:26:07', '2021-10-04 16:27:58'),
(1913, 'en', 0, 1017187, '2021-06-28 09:30:41', '2021-06-28 13:44:39'),
(1914, 'en', 0, 1017188, '2021-06-28 10:26:50', '2021-06-28 11:39:25'),
(1915, 'en', 0, 1017190, '2021-06-28 11:56:01', '2021-06-30 12:14:40'),
(1916, 'ar', 0, 1015400, '2021-06-28 13:54:55', '2021-07-06 13:02:21'),
(1917, 'en', 0, 1017191, '2021-06-29 14:23:57', '2021-06-29 14:23:57'),
(1918, 'en', 0, 1017192, '2021-06-29 15:08:13', '2021-06-29 15:08:13'),
(1919, 'en', 0, 1017193, '2021-07-01 15:43:47', '2021-07-01 15:43:47'),
(1920, 'ar', 0, 1017194, '2021-07-04 11:34:11', '2021-08-10 15:39:18'),
(1921, 'en', 0, 1017195, '2021-07-04 11:39:21', '2021-07-04 11:39:21'),
(1922, 'en', 0, 1017196, '2021-07-04 11:43:08', '2021-07-04 11:43:08'),
(1923, 'en', 0, 1017197, '2021-07-04 11:57:36', '2021-09-29 15:33:07'),
(1924, 'en', 0, 1017198, '2021-07-04 12:11:58', '2021-08-18 16:02:40'),
(1925, 'en', 0, 1017199, '2021-07-04 22:55:09', '2021-07-04 22:55:09'),
(1926, 'en', 0, 1017200, '2021-07-06 10:47:49', '2021-07-06 10:47:49'),
(1927, 'en', 0, 1017201, '2021-07-06 11:17:49', '2021-07-06 11:17:49'),
(1928, 'en', 0, 1017202, '2021-07-06 15:27:00', '2021-08-05 11:12:30'),
(1929, 'en', 0, 1017203, '2021-07-07 14:39:26', '2021-07-07 14:39:26'),
(1930, 'en', 0, 1017204, '2021-07-08 09:56:10', '2021-07-08 09:56:10'),
(1931, 'en', 0, 1017205, '2021-07-08 11:21:30', '2021-07-08 11:21:30'),
(1932, 'en', 0, 1017206, '2021-07-08 11:28:08', '2021-07-08 11:28:08'),
(1933, 'en', 0, 1017207, '2021-07-08 11:37:04', '2021-08-29 20:49:54'),
(1934, 'en', 0, 1017208, '2021-07-08 13:03:03', '2021-07-08 13:03:03'),
(1935, 'en', 0, 1017209, '2021-07-08 13:11:11', '2021-07-08 13:11:11'),
(1936, 'en', 0, 1017210, '2021-07-08 13:56:40', '2021-09-01 16:01:17'),
(1937, 'en', 0, 1017211, '2021-07-08 15:31:39', '2021-07-13 14:11:48'),
(1938, 'en', 0, 1017212, '2021-07-12 16:45:13', '2021-07-12 16:45:13'),
(1939, 'en', 0, 1017213, '2021-07-13 10:15:07', '2021-07-13 10:15:07'),
(1940, 'en', 0, 1017214, '2021-07-13 14:15:24', '2021-09-07 18:15:26'),
(1941, 'en', 0, 1017215, '2021-07-14 16:53:04', '2021-07-14 16:53:04'),
(1942, 'en', 0, 1017216, '2021-07-14 17:49:35', '2021-07-14 17:49:35'),
(1943, 'en', 0, 1017217, '2021-07-25 17:01:27', '2021-07-25 17:01:27'),
(1944, 'en', 0, 1017218, '2021-07-26 10:12:45', '2021-07-28 14:31:42'),
(1945, 'en', 0, 1017219, '2021-08-02 10:37:02', '2021-08-02 10:37:02'),
(1946, 'en', 0, 1017220, '2021-08-02 21:42:31', '2021-08-02 21:48:34'),
(1947, 'en', 0, 1017221, '2021-08-03 12:49:32', '2021-08-03 12:49:32'),
(1948, 'en', 0, 1017222, '2021-08-06 10:46:37', '2021-08-06 10:46:37'),
(1949, 'en', 0, 1017223, '2021-08-08 22:57:58', '2021-08-08 22:57:58'),
(1950, 'en', 0, 1017224, '2021-08-09 14:14:08', '2021-09-07 18:01:38'),
(1951, 'en', 0, 1017225, '2021-08-10 11:58:04', '2021-08-10 11:58:04'),
(1952, 'en', 0, 1015376, '2021-08-10 14:58:30', '2021-08-10 14:58:30'),
(1953, 'en', 0, 1017226, '2021-08-10 15:17:09', '2021-08-10 15:17:09'),
(1954, 'en', 0, 1017227, '2021-08-10 16:30:17', '2021-08-10 16:30:17'),
(1955, 'en', 0, 1017228, '2021-08-15 15:45:45', '2021-09-07 10:38:35'),
(1956, 'en', 0, 1017229, '2021-08-16 16:45:03', '2021-08-16 16:45:03'),
(1957, 'en', 0, 1017230, '2021-08-18 11:57:06', '2021-09-19 10:56:45'),
(1958, 'en', 0, 1017231, '2021-08-18 12:09:08', '2021-08-18 12:09:08'),
(1959, 'en', 0, 1017232, '2021-08-21 18:41:50', '2021-08-21 18:44:49'),
(1960, 'en', 0, 1017233, '2021-08-22 14:18:08', '2021-08-22 14:18:08'),
(1961, 'en', 0, 1017234, '2021-08-23 11:01:00', '2021-08-23 11:01:00'),
(1962, 'en', 0, 1017235, '2021-08-24 16:16:09', '2021-08-24 16:16:09'),
(1963, 'en', 0, 1017236, '2021-08-25 13:58:24', '2021-08-25 13:58:24'),
(1964, 'en', 0, 1017237, '2021-08-26 11:16:02', '2021-08-26 11:16:02'),
(1965, 'en', 0, 1017238, '2021-08-26 11:17:52', '2021-08-26 11:17:52'),
(1966, 'en', 0, 1017239, '2021-08-26 12:12:43', '2021-08-26 12:12:43'),
(1967, 'en', 0, 1017240, '2021-08-26 17:25:13', '2021-09-05 16:46:20'),
(1968, 'en', 0, 1017241, '2021-08-29 14:32:03', '2021-08-30 09:27:08'),
(1969, 'en', 0, 1017243, '2021-08-31 15:07:55', '2021-08-31 15:07:55'),
(1970, 'en', 0, 1017244, '2021-08-31 15:24:37', '2021-08-31 15:24:37'),
(1971, 'en', 0, 1017245, '2021-09-01 13:06:49', '2021-09-01 13:13:25'),
(1972, 'en', 0, 1017246, '2021-09-01 15:12:59', '2021-09-01 15:12:59'),
(1973, 'en', 0, 1017247, '2021-09-02 09:18:00', '2021-09-02 09:18:00'),
(1974, 'en', 0, 1017248, '2021-09-02 11:24:47', '2021-09-02 11:24:47'),
(1975, 'en', 0, 1017249, '2021-09-02 12:10:02', '2021-09-02 12:10:02'),
(1976, 'en', 0, 1017252, '2021-09-05 11:23:39', '2021-09-11 20:40:28'),
(1977, 'en', 0, 1017253, '2021-09-05 11:47:01', '2021-09-05 11:47:01'),
(1978, 'en', 0, 1017254, '2021-09-05 11:57:24', '2021-09-05 11:57:24'),
(1979, 'en', 0, 1017255, '2021-09-05 12:01:57', '2021-09-05 12:01:57'),
(1980, 'en', 0, 1017256, '2021-09-05 12:42:08', '2021-09-05 12:42:08'),
(1981, 'en', 0, 1017257, '2021-09-05 13:11:35', '2021-09-05 13:11:35'),
(1982, 'en', 0, 1017258, '2021-09-05 13:23:19', '2021-09-05 13:23:19'),
(1983, 'en', 0, 1017261, '2021-09-05 16:20:06', '2021-09-05 16:20:06'),
(1984, 'en', 0, 1017262, '2021-09-06 09:50:56', '2021-09-06 16:37:06'),
(1985, 'en', 0, 1017263, '2021-09-06 13:34:19', '2021-09-06 13:34:19'),
(1986, 'en', 0, 1017264, '2021-09-06 14:13:41', '2021-09-06 14:13:41'),
(1987, 'en', 0, 1017265, '2021-09-06 14:51:31', '2021-09-06 14:51:31'),
(1988, 'en', 0, 1017251, '2021-09-06 16:00:50', '2021-09-07 14:49:50'),
(1989, 'en', 0, 1017267, '2021-09-07 11:41:43', '2021-09-07 11:41:43'),
(1990, 'en', 0, 1017268, '2021-09-08 11:53:44', '2021-09-08 11:53:44'),
(1991, 'en', 0, 1017272, '2021-09-08 17:40:10', '2021-09-08 17:40:10'),
(1992, 'en', 0, 1017273, '2021-09-08 17:42:16', '2021-09-08 17:42:16'),
(1993, 'en', 0, 1017274, '2021-09-08 17:44:17', '2021-09-08 17:44:17'),
(1994, 'en', 0, 1017275, '2021-09-08 17:45:40', '2021-09-08 17:45:40'),
(1995, 'en', 0, 1017276, '2021-09-09 09:58:10', '2021-09-09 09:58:10'),
(1996, 'en', 0, 1017277, '2021-09-09 10:13:58', '2021-09-09 10:13:58'),
(1997, 'ar', 0, 1017278, '2021-09-09 10:14:10', '2021-09-20 15:12:11'),
(1998, 'en', 0, 1017279, '2021-09-09 14:09:23', '2021-09-09 14:09:23'),
(1999, 'en', 0, 1017281, '2021-09-09 15:41:39', '2021-09-09 15:41:39'),
(2000, 'en', 0, 1017282, '2021-09-12 10:45:58', '2021-09-12 10:45:58'),
(2001, 'en', 0, 1017283, '2021-09-12 11:35:25', '2021-09-12 11:35:25'),
(2002, 'en', 0, 1017284, '2021-09-12 12:10:08', '2021-09-12 12:10:08'),
(2003, 'en', 0, 1017285, '2021-09-12 14:41:43', '2021-09-12 14:41:43'),
(2004, 'en', 0, 1017286, '2021-09-12 15:03:49', '2021-09-12 15:03:49'),
(2005, 'en', 0, 1017287, '2021-09-12 15:42:47', '2021-09-12 15:42:47'),
(2006, 'en', 0, 1017288, '2021-09-12 16:21:07', '2021-09-12 16:21:07'),
(2007, 'en', 0, 1017289, '2021-09-12 16:48:56', '2021-09-12 16:48:56'),
(2008, 'en', 0, 1017290, '2021-09-13 10:45:09', '2021-09-13 10:45:09'),
(2009, 'en', 0, 1017292, '2021-09-13 14:56:16', '2021-09-13 14:56:16'),
(2010, 'en', 0, 1017293, '2021-09-15 16:34:36', '2021-09-15 16:34:36'),
(2011, 'en', 0, 1017294, '2021-09-17 11:00:35', '2021-09-17 11:00:35'),
(2012, 'en', 0, 1017295, '2021-09-19 14:32:24', '2021-09-19 14:32:24'),
(2013, 'en', 0, 1017296, '2021-09-19 14:33:30', '2021-09-19 14:33:30'),
(2014, 'en', 0, 1017297, '2021-09-19 14:55:05', '2021-09-19 14:55:05'),
(2015, 'en', 0, 1017298, '2021-09-19 15:02:32', '2021-09-19 15:02:32'),
(2016, 'en', 0, 1017299, '2021-09-20 12:22:11', '2021-09-20 12:22:11'),
(2017, 'en', 0, 1017300, '2021-09-20 14:22:22', '2021-09-20 14:22:22'),
(2018, 'ar', 0, 1017301, '2021-09-20 15:15:05', '2021-09-20 15:15:05'),
(2019, 'en', 0, 1017302, '2021-09-20 15:38:46', '2021-09-20 15:38:46'),
(2020, 'en', 0, 1017303, '2021-09-20 16:02:07', '2021-09-20 16:02:07'),
(2021, 'en', 0, 1017304, '2021-09-21 09:54:42', '2021-09-21 09:54:42'),
(2022, 'en', 0, 1017305, '2021-09-21 10:48:29', '2021-09-21 10:48:29'),
(2023, 'en', 0, 1017306, '2021-09-21 10:50:26', '2021-09-21 10:50:26'),
(2024, 'en', 0, 1017307, '2021-09-21 11:32:52', '2021-09-21 11:32:52'),
(2025, 'en', 0, 1017308, '2021-09-21 11:41:53', '2021-09-21 11:41:53'),
(2026, 'en', 0, 1017309, '2021-09-21 11:47:12', '2021-09-21 11:47:12'),
(2027, 'en', 0, 1017310, '2021-09-21 11:53:35', '2021-09-21 11:53:35'),
(2028, 'en', 0, 1017311, '2021-09-21 12:00:21', '2021-09-21 12:00:21'),
(2029, 'en', 0, 1017312, '2021-09-21 12:06:36', '2021-09-21 12:06:36'),
(2030, 'ar', 0, 1017313, '2021-09-22 17:36:14', '2021-09-22 17:36:14'),
(2031, 'en', 0, 1017314, '2021-09-23 13:04:42', '2021-09-23 13:17:18'),
(2032, 'en', 0, 1017315, '2021-09-29 11:44:45', '2021-09-29 11:44:45'),
(2033, 'en', 0, 1017316, '2021-10-03 11:46:50', '2021-10-03 11:46:50'),
(2034, 'en', 0, 1017317, '2021-10-03 11:47:48', '2021-10-03 11:47:48'),
(2035, 'en', 0, 1017318, '2021-10-03 11:48:56', '2021-10-03 11:48:56'),
(2036, 'en', 0, 1017319, '2021-10-03 11:49:40', '2021-10-03 11:49:40'),
(2037, 'en', 0, 1017320, '2021-10-03 11:50:24', '2021-10-03 11:50:24'),
(2038, 'en', 0, 1017321, '2021-10-03 11:51:18', '2021-10-03 11:51:18'),
(2039, 'en', 0, 1017322, '2021-10-03 11:52:07', '2021-10-03 11:52:07'),
(2040, 'en', 0, 1017323, '2021-10-03 12:17:16', '2021-10-03 12:17:16'),
(2041, 'en', 0, 1017324, '2021-10-03 13:03:52', '2021-10-03 13:03:52'),
(2042, 'en', 0, 1017325, '2021-10-03 13:06:36', '2021-10-03 13:06:36'),
(2043, 'en', 0, 1017326, '2021-10-03 13:06:54', '2021-10-03 13:06:54'),
(2044, 'en', 0, 1017327, '2021-10-03 13:07:12', '2021-10-03 13:07:12'),
(2045, 'en', 0, 1017328, '2021-10-03 13:07:57', '2021-10-03 13:07:57'),
(2046, 'en', 0, 1017329, '2021-10-03 13:16:54', '2021-10-03 13:16:54'),
(2047, 'en', 0, 1017330, '2021-10-03 13:23:45', '2021-10-03 13:23:45'),
(2048, 'en', 0, 1017331, '2021-10-03 15:22:34', '2021-10-03 15:22:34'),
(2049, 'en', 0, 1017332, '2021-10-04 13:18:36', '2021-10-04 13:18:36'),
(2050, 'en', 0, 1017333, '2021-10-04 13:39:37', '2021-10-04 13:39:37'),
(2051, 'en', 0, 1017334, '2021-10-04 16:14:38', '2021-10-04 16:14:38'),
(2052, 'en', 0, 1017335, '2021-10-04 16:18:46', '2021-10-04 16:18:46'),
(2053, 'en', 0, 1017336, '2021-10-04 16:42:55', '2021-10-04 16:42:55'),
(2054, 'en', 0, 1017337, '2021-10-04 16:46:32', '2021-10-04 16:46:32'),
(2055, 'en', 0, 1017338, '2021-10-04 16:50:46', '2021-10-04 16:50:46'),
(2056, 'en', 0, 1017339, '2021-10-04 17:04:22', '2021-10-04 17:04:22'),
(2057, 'en', 0, 1017340, '2021-10-05 10:26:04', '2021-10-05 10:26:04'),
(2058, 'en', 0, 1017341, '2021-10-05 10:30:14', '2021-10-05 10:30:14'),
(2059, 'en', 0, 1017342, '2021-10-05 13:11:42', '2021-10-05 13:11:42'),
(2060, 'en', 0, 1017343, '2021-10-05 13:17:50', '2021-10-05 13:17:50'),
(2061, 'en', 0, 1017344, '2021-10-06 12:03:02', '2021-10-06 12:03:02'),
(2062, 'en', 0, 1017345, '2021-10-06 15:35:38', '2021-10-06 15:35:38'),
(2063, 'en', 0, 1017349, '2021-10-10 11:41:09', '2021-10-10 11:41:09'),
(2064, 'en', 0, 1017350, '2021-10-10 14:02:27', '2021-10-10 14:02:27'),
(2065, 'en', 0, 1017351, '2021-10-10 14:10:09', '2021-10-10 14:10:09'),
(2066, 'en', 0, 1017352, '2021-10-10 15:32:43', '2021-10-10 15:32:43'),
(2067, 'en', 0, 1017354, '2021-10-11 10:51:28', '2021-10-11 10:51:28'),
(2068, 'en', 0, 1017355, '2021-10-11 11:22:29', '2021-10-11 11:22:29'),
(2069, 'en', 0, 1017356, '2021-10-11 11:23:16', '2021-10-11 11:23:16'),
(2070, 'en', 0, 1017357, '2021-10-11 11:24:59', '2021-10-11 11:24:59'),
(2071, 'en', 0, 1017358, '2021-10-11 11:31:29', '2021-10-11 11:31:29'),
(2072, 'en', 0, 1017359, '2021-10-11 11:57:42', '2021-10-11 11:57:42'),
(2073, 'en', 0, 1017360, '2021-10-11 13:32:35', '2021-10-11 13:32:35'),
(2074, 'en', 0, 1017361, '2021-10-11 13:39:08', '2021-10-11 13:39:08'),
(2075, 'en', 0, 1017362, '2021-10-11 13:41:54', '2021-10-11 13:41:54'),
(2076, 'en', 0, 1017363, '2021-10-11 13:48:33', '2021-10-11 13:48:33'),
(2077, 'en', 0, 1017364, '2021-10-11 16:00:48', '2021-10-11 16:00:48'),
(2078, 'en', 0, 1017365, '2021-10-11 16:16:09', '2021-10-11 16:16:09'),
(2079, 'en', 0, 1017366, '2021-10-11 16:19:47', '2021-10-11 16:19:47'),
(2080, 'en', 0, 1017367, '2021-10-11 16:24:14', '2021-10-11 16:24:14'),
(2081, 'en', 0, 1017368, '2021-10-11 16:25:21', '2021-10-11 16:25:21'),
(2082, 'en', 0, 1017369, '2021-10-11 16:28:23', '2021-10-11 16:28:23'),
(2083, 'en', 0, 1017370, '2021-10-11 16:38:49', '2021-10-11 16:38:49'),
(2084, 'en', 0, 1017371, '2021-10-12 10:23:02', '2021-10-12 10:23:02'),
(2085, 'en', 0, 1017372, '2021-10-12 10:39:27', '2021-10-12 10:39:27'),
(2086, 'en', 0, 1017373, '2021-11-21 11:11:47', '2022-01-16 12:12:24'),
(2087, 'en', 0, 1017374, '2021-12-13 15:08:39', '2022-01-13 11:09:32'),
(2088, 'en', 0, 1017375, '2021-12-14 15:09:41', '2021-12-14 15:09:41'),
(2089, 'en', 0, 1017376, '2021-12-14 23:44:21', '2021-12-14 23:44:21'),
(2090, 'en', 0, 1017377, '2021-12-15 11:30:07', '2021-12-15 11:30:07'),
(2091, 'ar', 0, 1017378, '2021-12-15 11:30:35', '2022-01-12 12:04:13'),
(2092, 'en', 0, 1017379, '2021-12-15 13:36:37', '2021-12-15 13:36:37'),
(2093, 'en', 0, 1017380, '2021-12-15 16:08:20', '2021-12-16 16:07:13'),
(2094, 'en', 0, 1017381, '2021-12-15 17:13:05', '2022-01-12 16:45:49'),
(2095, 'en', 0, 1017382, '2021-12-15 17:29:24', '2021-12-15 17:29:24'),
(2096, 'en', 0, 1017383, '2021-12-16 13:14:22', '2022-01-12 20:10:08'),
(2097, 'en', 0, 1017384, '2022-01-16 12:22:45', '2022-01-16 12:22:45'),
(2098, 'en', 0, 1017859, '2022-02-23 12:52:55', '2022-02-23 12:52:55'),
(2099, 'en', 0, 1019248, '2022-03-02 12:54:16', '2022-03-02 12:54:17'),
(2100, 'en', 0, 1003849, '2022-03-03 15:16:10', '2022-03-03 15:16:10'),
(2101, 'en', 0, 1000000, '2022-03-07 17:00:02', '2022-05-30 11:47:40'),
(2102, 'en', 0, 1000004, '2022-03-10 10:51:55', '2022-06-29 10:21:29'),
(2103, 'ar', 0, 1000002, '2022-03-16 12:28:45', '2022-07-24 04:33:25'),
(2104, 'en', 0, 1000003, '2022-03-22 14:52:55', '2022-09-13 15:12:48'),
(2105, 'en', 0, 1000001, '2022-03-23 13:19:24', '2022-07-20 11:25:45'),
(2106, 'ar', 0, 1000005, '2022-03-30 13:25:28', '2022-06-05 16:02:23'),
(2107, 'en', 0, 1000010, '2022-04-13 11:25:29', '2022-05-16 14:33:18'),
(2108, 'ar', 0, 1000006, '2022-06-02 12:48:42', '2022-06-02 12:48:54'),
(2109, 'ar', 0, 1000012, '2022-06-12 12:45:00', '2022-06-12 12:45:00'),
(2110, 'ar', 0, 1000422, '2022-06-13 11:47:38', '2022-06-13 11:47:38'),
(2111, 'ar', 0, 1000007, '2022-07-20 10:26:35', '2022-08-02 13:04:56'),
(2112, 'ar', 0, 1000011, '2022-07-20 15:45:36', '2022-07-20 15:45:36'),
(2113, 'en', 0, 1000008, '2022-07-24 10:29:16', '2022-07-24 10:29:16'),
(2114, 'en', 0, 1000025, '2022-07-27 12:28:49', '2022-09-14 22:00:17'),
(2115, 'ar', 0, 1000021, '2022-07-31 11:46:28', '2022-07-31 11:46:28'),
(2116, 'ar', 0, 1000022, '2022-08-02 12:34:04', '2022-08-04 00:44:58'),
(2117, 'ar', 0, 1000020, '2022-08-02 13:19:33', '2022-08-02 13:19:33'),
(2118, 'ar', 0, 1000019, '2022-08-02 18:27:22', '2022-08-02 18:27:22'),
(2119, 'en', 0, 1000024, '2022-08-03 11:14:05', '2022-08-03 11:14:05'),
(2120, 'ar', 0, 1000017, '2022-08-03 11:40:42', '2022-08-03 11:40:42'),
(2121, 'ar', 0, 1000023, '2022-08-03 15:01:13', '2022-08-03 15:01:13'),
(2122, 'ar', 0, 1000014, '2022-08-03 16:45:00', '2022-08-03 16:45:00'),
(2123, 'en', 0, 1, '2022-10-30 09:04:09', '2022-10-30 09:04:09');

-- --------------------------------------------------------

--
-- Table structure for table `wallets`
--

CREATE TABLE `wallets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `incentive_id` bigint(20) UNSIGNED NOT NULL,
  `delivered` tinyint(1) NOT NULL DEFAULT 0,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wallet_histories`
--

CREATE TABLE `wallet_histories` (
  `id` int(10) UNSIGNED NOT NULL,
  `affiliate_id` int(10) UNSIGNED DEFAULT NULL,
  `order_id` int(10) UNSIGNED DEFAULT NULL,
  `amount` decimal(8,2) DEFAULT NULL,
  `due_date` datetime DEFAULT NULL,
  `payment_method` tinyint(4) DEFAULT NULL,
  `phone_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `iban` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` tinyint(4) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `rejection_reason` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `admin_comment` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `addresses_user_id_foreign` (`user_id`),
  ADD KEY `addresses_city_id_foreign` (`city_id`),
  ADD KEY `addresses_area_id_foreign` (`area_id`),
  ADD KEY `addresses_district_id_foreign` (`district_id`);

--
-- Indexes for table `ads`
--
ALTER TABLE `ads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `affiliate_links`
--
ALTER TABLE `affiliate_links`
  ADD PRIMARY KEY (`id`),
  ADD KEY `affiliate_links_affiliate_id_foreign` (`affiliate_id`);

--
-- Indexes for table `affiliate_link_histories`
--
ALTER TABLE `affiliate_link_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `affiliate_link_histories_user_id_foreign` (`user_id`),
  ADD KEY `affiliate_link_histories_link_id_foreign` (`link_id`);

--
-- Indexes for table `affiliate_requests`
--
ALTER TABLE `affiliate_requests`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `affiliate_requests_email_unique` (`email`),
  ADD KEY `affiliate_requests_user_id_foreign` (`user_id`),
  ADD KEY `affiliate_requests_phone_index` (`phone`);

--
-- Indexes for table `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `areas_city_id_foreign` (`city_id`);

--
-- Indexes for table `black_ip_list`
--
ALTER TABLE `black_ip_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_user_id_foreign` (`user_id`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_items_cart_id_foreign` (`cart_id`),
  ADD KEY `cart_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categories_parent_id_foreign` (`parent_id`),
  ADD KEY `categories_created_by_foreign` (`created_by`);

--
-- Indexes for table `category_options`
--
ALTER TABLE `category_options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_options_sub_category_id_foreign` (`sub_category_id`),
  ADD KEY `category_options_option_id_foreign` (`option_id`),
  ADD KEY `category_options_created_by_foreign` (`created_by`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `closed_payment_methods`
--
ALTER TABLE `closed_payment_methods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `closed_payment_methods_user_id_foreign` (`user_id`),
  ADD KEY `closed_payment_methods_payment_method_id_foreign` (`payment_method_id`);

--
-- Indexes for table `compare_products`
--
ALTER TABLE `compare_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `compare_products_user_id_foreign` (`user_id`),
  ADD KEY `compare_products_product_id_foreign` (`product_id`);

--
-- Indexes for table `configurations`
--
ALTER TABLE `configurations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `configurations_key_unique` (`key`),
  ADD UNIQUE KEY `configurations_alias_unique` (`alias`);

--
-- Indexes for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `countries_country_code_unique` (`country_code`),
  ADD UNIQUE KEY `countries_currency_code_en_unique` (`currency_code_en`),
  ADD UNIQUE KEY `countries_currency_code_ar_unique` (`currency_code_ar`);

--
-- Indexes for table `customer_request`
--
ALTER TABLE `customer_request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `custom_ads`
--
ALTER TABLE `custom_ads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deliverer_district`
--
ALTER TABLE `deliverer_district`
  ADD KEY `deliverer_district_district_id_foreign` (`district_id`),
  ADD KEY `deliverer_district_deliverer_profile_id_foreign` (`deliverer_profile_id`);

--
-- Indexes for table `deliverer_profiles`
--
ALTER TABLE `deliverer_profiles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `deliverer_profile_unique_id_unique` (`unique_id`),
  ADD UNIQUE KEY `unique_id` (`unique_id`),
  ADD UNIQUE KEY `deliverer_profiles_unique_id_unique` (`unique_id`),
  ADD KEY `deliverer_profile_area_id_foreign` (`area_id`),
  ADD KEY `deliverer_profile_user_id_foreign` (`user_id`),
  ADD KEY `deliverer_profiles_city_id_foreign` (`city_id`);

--
-- Indexes for table `delivery_fees`
--
ALTER TABLE `delivery_fees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `device_tokens`
--
ALTER TABLE `device_tokens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `districts`
--
ALTER TABLE `districts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `districts_area_id_foreign` (`area_id`);

--
-- Indexes for table `edara_areas`
--
ALTER TABLE `edara_areas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `edara_areas_area_type_area_id_index` (`area_type`,`area_id`);

--
-- Indexes for table `edara_drafts`
--
ALTER TABLE `edara_drafts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `edara_drafts_product_id_foreign` (`product_id`);

--
-- Indexes for table `exports`
--
ALTER TABLE `exports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exports_user_id_foreign` (`user_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `import_histories`
--
ALTER TABLE `import_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `import_histories_user_id_foreign` (`user_id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoices_order_id_foreign` (`order_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `lists`
--
ALTER TABLE `lists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `list_items`
--
ALTER TABLE `list_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `list_items_list_id_foreign` (`list_id`);

--
-- Indexes for table `list_rules`
--
ALTER TABLE `list_rules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `list_rules_list_id_foreign` (`list_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_user_id_foreign` (`user_id`);

--
-- Indexes for table `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `options_created_by_foreign` (`created_by`);

--
-- Indexes for table `option_values`
--
ALTER TABLE `option_values`
  ADD PRIMARY KEY (`id`),
  ADD KEY `option_values_option_id_foreign` (`option_id`),
  ADD KEY `option_values_created_by_foreign` (`created_by`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`),
  ADD KEY `orders_deliverer_id_foreign` (`deliverer_id`),
  ADD KEY `orders_state_id_foreign` (`state_id`),
  ADD KEY `orders_address_id_foreign` (`address_id`),
  ADD KEY `orders_parent_id_foreign` (`parent_id`),
  ADD KEY `orders_sub_state_id_foreign` (`sub_state_id`),
  ADD KEY `orders_transaction_id_foreign` (`transaction_id`),
  ADD KEY `orders_admin_id_foreign` (`admin_id`),
  ADD KEY `orders_cancellation_id_foreign` (`cancellation_id`),
  ADD KEY `orders_payment_installment_id_foreign` (`payment_installment_id`),
  ADD KEY `orders_affiliate_id_foreign` (`affiliate_id`);

--
-- Indexes for table `order_cancellation_reasons`
--
ALTER TABLE `order_cancellation_reasons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_history`
--
ALTER TABLE `order_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_history_order_id_foreign` (`order_id`),
  ADD KEY `order_history_state_id_foreign` (`state_id`),
  ADD KEY `order_history_user_id_foreign` (`user_id`);

--
-- Indexes for table `order_pickups`
--
ALTER TABLE `order_pickups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_pickups_pickup_id_foreign` (`pickup_id`),
  ADD KEY `order_pickups_order_id_foreign` (`order_id`);

--
-- Indexes for table `order_products`
--
ALTER TABLE `order_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_products_order_id_foreign` (`order_id`),
  ADD KEY `order_products_product_id_foreign` (`product_id`),
  ADD KEY `order_products_price_id_foreign` (`price_id`);

--
-- Indexes for table `order_schedule`
--
ALTER TABLE `order_schedule`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_schedule_order_id_foreign` (`order_id`);

--
-- Indexes for table `order_states`
--
ALTER TABLE `order_states`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_states_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payment_credentials`
--
ALTER TABLE `payment_credentials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payment_credentials_method_id_foreign` (`method_id`);

--
-- Indexes for table `payment_installments`
--
ALTER TABLE `payment_installments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payment_installments_payment_method_id_foreign` (`payment_method_id`);

--
-- Indexes for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_method_product`
--
ALTER TABLE `payment_method_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payment_method_product_payment_method_id_foreign` (`payment_method_id`),
  ADD KEY `payment_method_product_product_id_foreign` (`product_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `pickups`
--
ALTER TABLE `pickups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prescriptions`
--
ALTER TABLE `prescriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prescriptions_address_id_foreign` (`address_id`),
  ADD KEY `prescriptions_user_id_foreign` (`user_id`),
  ADD KEY `prescriptions_cancellation_id_foreign` (`cancellation_id`),
  ADD KEY `prescriptions_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `prescription_cancellation_reasons`
--
ALTER TABLE `prescription_cancellation_reasons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prescription_images`
--
ALTER TABLE `prescription_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prescription_images_prescription_id_foreign` (`prescription_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_brand_id_foreign` (`brand_id`),
  ADD KEY `products_category_id_foreign` (`category_id`),
  ADD KEY `products_creator_id_foreign` (`creator_id`),
  ADD KEY `products_sku_index` (`sku`),
  ADD KEY `products_last_editor_foreign` (`last_editor`);
ALTER TABLE `products` ADD FULLTEXT KEY `fulltext_index` (`name`,`name_ar`);

--
-- Indexes for table `product_bundles`
--
ALTER TABLE `product_bundles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_bundles_bundle_id_foreign` (`bundle_id`),
  ADD KEY `product_bundles_product_id_foreign` (`product_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_option_values`
--
ALTER TABLE `product_option_values`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_option_values_product_id_foreign` (`product_id`),
  ADD KEY `product_option_values_option_id_foreign` (`option_id`),
  ADD KEY `product_option_values_created_by_foreign` (`created_by`),
  ADD KEY `product_option_values_value_id_foreign` (`value_id`);

--
-- Indexes for table `product_prices`
--
ALTER TABLE `product_prices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_prices_product_id_foreign` (`product_id`);

--
-- Indexes for table `product_reviews`
--
ALTER TABLE `product_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_reviews_user_id_foreign` (`user_id`),
  ADD KEY `product_reviews_product_id_foreign` (`product_id`),
  ADD KEY `product_reviews_order_id_foreign` (`order_id`);

--
-- Indexes for table `product_skus`
--
ALTER TABLE `product_skus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_skus_product_id_foreign` (`product_id`);

--
-- Indexes for table `product_tags`
--
ALTER TABLE `product_tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_tags_tag_id_foreign` (`tag_id`),
  ADD KEY `product_tags_product_id_foreign` (`product_id`);

--
-- Indexes for table `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profiles_user_id_foreign` (`user_id`);

--
-- Indexes for table `promos`
--
ALTER TABLE `promos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `promos_list_id_foreign` (`list_id`);

--
-- Indexes for table `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `promotions_b2b_segments`
--
ALTER TABLE `promotions_b2b_segments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `promotions_b2b_segments_promotion_id_foreign` (`promotion_id`);

--
-- Indexes for table `promotion_conditions`
--
ALTER TABLE `promotion_conditions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `promotion_conditions_promotion_id_foreign` (`promotion_id`);

--
-- Indexes for table `promotion_conditions_custom_lists`
--
ALTER TABLE `promotion_conditions_custom_lists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `promotion_conditions_custom_lists_condition_id_foreign` (`condition_id`);

--
-- Indexes for table `promotion_groups`
--
ALTER TABLE `promotion_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `promotion_targets`
--
ALTER TABLE `promotion_targets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `promotion_targets_promotion_id_foreign` (`promotion_id`);

--
-- Indexes for table `promotion_targets_custom_lists`
--
ALTER TABLE `promotion_targets_custom_lists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `promotion_targets_custom_lists_target_id_foreign` (`target_id`);

--
-- Indexes for table `promotion_users`
--
ALTER TABLE `promotion_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `promo_payment_method`
--
ALTER TABLE `promo_payment_method`
  ADD PRIMARY KEY (`id`),
  ADD KEY `promo_payment_method_promo_id_foreign` (`promo_id`),
  ADD KEY `promo_payment_method_payment_method_id_foreign` (`payment_method_id`);

--
-- Indexes for table `promo_targets`
--
ALTER TABLE `promo_targets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `promo_targets_promo_id_foreign` (`promo_id`),
  ADD KEY `promo_targets_user_id_foreign` (`user_id`),
  ADD KEY `promo_targets_phone_foreign` (`phone`);

--
-- Indexes for table `push_messages`
--
ALTER TABLE `push_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `push_messages_creator_id_foreign` (`creator_id`);

--
-- Indexes for table `redeem_points`
--
ALTER TABLE `redeem_points`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `request_logs`
--
ALTER TABLE `request_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rewards`
--
ALTER TABLE `rewards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `role_state`
--
ALTER TABLE `role_state`
  ADD KEY `role_state_role_id_foreign` (`role_id`),
  ADD KEY `role_state_order_state_id_foreign` (`order_state_id`);

--
-- Indexes for table `schedule_days`
--
ALTER TABLE `schedule_days`
  ADD PRIMARY KEY (`id`),
  ADD KEY `schedule_days_schedule_id_foreign` (`schedule_id`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sections_list_id_foreign` (`list_id`);

--
-- Indexes for table `section_images`
--
ALTER TABLE `section_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `section_images_section_id_foreign` (`section_id`);

--
-- Indexes for table `shipping_areas`
--
ALTER TABLE `shipping_areas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shipping_methods`
--
ALTER TABLE `shipping_methods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_notifications`
--
ALTER TABLE `stock_notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_notifications_product_id_foreign` (`product_id`),
  ADD KEY `stock_notifications_user_id_foreign` (`user_id`);

--
-- Indexes for table `sub_category_groups`
--
ALTER TABLE `sub_category_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sub_category_groups_group_id_foreign` (`group_id`),
  ADD KEY `sub_category_groups_category_id_foreign` (`category_id`),
  ADD KEY `sub_category_groups_sub_category_id_foreign` (`sub_category_id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `total_spent_per_categories`
--
ALTER TABLE `total_spent_per_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transactions_customer_id_foreign` (`customer_id`),
  ADD KEY `transactions_payment_method_id_foreign` (`payment_method_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_phone_index` (`phone`),
  ADD KEY `users_link_id_foreign` (`link_id`);

--
-- Indexes for table `user_favourites`
--
ALTER TABLE `user_favourites`
  ADD KEY `user_favourites_user_id_foreign` (`user_id`),
  ADD KEY `user_favourites_product_id_foreign` (`product_id`);

--
-- Indexes for table `user_points`
--
ALTER TABLE `user_points`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_points_user_id_foreign` (`user_id`);

--
-- Indexes for table `user_promo`
--
ALTER TABLE `user_promo`
  ADD KEY `user_promo_promo_id_foreign` (`promo_id`),
  ADD KEY `user_promo_user_id_foreign` (`user_id`);

--
-- Indexes for table `user_redeems`
--
ALTER TABLE `user_redeems`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_redeems_user_id_foreign` (`user_id`),
  ADD KEY `user_redeems_reward_id_foreign` (`reward_id`);

--
-- Indexes for table `user_settings`
--
ALTER TABLE `user_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wallets`
--
ALTER TABLE `wallets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wallet_histories`
--
ALTER TABLE `wallet_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wallet_histories_affiliate_id_foreign` (`affiliate_id`),
  ADD KEY `wallet_histories_order_id_foreign` (`order_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10505;

--
-- AUTO_INCREMENT for table `ads`
--
ALTER TABLE `ads`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `affiliate_links`
--
ALTER TABLE `affiliate_links`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `affiliate_link_histories`
--
ALTER TABLE `affiliate_link_histories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `affiliate_requests`
--
ALTER TABLE `affiliate_requests`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `areas`
--
ALTER TABLE `areas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=556;

--
-- AUTO_INCREMENT for table `black_ip_list`
--
ALTER TABLE `black_ip_list`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8699;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=325;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `category_options`
--
ALTER TABLE `category_options`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3169;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT for table `closed_payment_methods`
--
ALTER TABLE `closed_payment_methods`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `compare_products`
--
ALTER TABLE `compare_products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=786;

--
-- AUTO_INCREMENT for table `configurations`
--
ALTER TABLE `configurations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=183;

--
-- AUTO_INCREMENT for table `contact_us`
--
ALTER TABLE `contact_us`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `customer_request`
--
ALTER TABLE `customer_request`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `custom_ads`
--
ALTER TABLE `custom_ads`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `deliverer_profiles`
--
ALTER TABLE `deliverer_profiles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3632;

--
-- AUTO_INCREMENT for table `delivery_fees`
--
ALTER TABLE `delivery_fees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `device_tokens`
--
ALTER TABLE `device_tokens`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3964;

--
-- AUTO_INCREMENT for table `districts`
--
ALTER TABLE `districts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1823;

--
-- AUTO_INCREMENT for table `edara_areas`
--
ALTER TABLE `edara_areas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `edara_drafts`
--
ALTER TABLE `edara_drafts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exports`
--
ALTER TABLE `exports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=148;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT for table `import_histories`
--
ALTER TABLE `import_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=209;

--
-- AUTO_INCREMENT for table `lists`
--
ALTER TABLE `lists`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `list_items`
--
ALTER TABLE `list_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=169839;

--
-- AUTO_INCREMENT for table `list_rules`
--
ALTER TABLE `list_rules`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4286;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=288;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8502;

--
-- AUTO_INCREMENT for table `options`
--
ALTER TABLE `options`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1045;

--
-- AUTO_INCREMENT for table `option_values`
--
ALTER TABLE `option_values`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2994;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `order_cancellation_reasons`
--
ALTER TABLE `order_cancellation_reasons`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `order_history`
--
ALTER TABLE `order_history`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=402;

--
-- AUTO_INCREMENT for table `order_pickups`
--
ALTER TABLE `order_pickups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=430;

--
-- AUTO_INCREMENT for table `order_products`
--
ALTER TABLE `order_products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=194;

--
-- AUTO_INCREMENT for table `order_schedule`
--
ALTER TABLE `order_schedule`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `order_states`
--
ALTER TABLE `order_states`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `payment_credentials`
--
ALTER TABLE `payment_credentials`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `payment_installments`
--
ALTER TABLE `payment_installments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `payment_method_product`
--
ALTER TABLE `payment_method_product`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pickups`
--
ALTER TABLE `pickups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `prescriptions`
--
ALTER TABLE `prescriptions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `prescription_cancellation_reasons`
--
ALTER TABLE `prescription_cancellation_reasons`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `prescription_images`
--
ALTER TABLE `prescription_images`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `product_bundles`
--
ALTER TABLE `product_bundles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=591;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1530450;

--
-- AUTO_INCREMENT for table `product_option_values`
--
ALTER TABLE `product_option_values`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=569596;

--
-- AUTO_INCREMENT for table `product_prices`
--
ALTER TABLE `product_prices`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=498770;

--
-- AUTO_INCREMENT for table `product_reviews`
--
ALTER TABLE `product_reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `product_skus`
--
ALTER TABLE `product_skus`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=394;

--
-- AUTO_INCREMENT for table `product_tags`
--
ALTER TABLE `product_tags`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `profiles`
--
ALTER TABLE `profiles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4651;

--
-- AUTO_INCREMENT for table `promos`
--
ALTER TABLE `promos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=211;

--
-- AUTO_INCREMENT for table `promotions`
--
ALTER TABLE `promotions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT for table `promotions_b2b_segments`
--
ALTER TABLE `promotions_b2b_segments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=783;

--
-- AUTO_INCREMENT for table `promotion_conditions`
--
ALTER TABLE `promotion_conditions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1023;

--
-- AUTO_INCREMENT for table `promotion_conditions_custom_lists`
--
ALTER TABLE `promotion_conditions_custom_lists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=281;

--
-- AUTO_INCREMENT for table `promotion_groups`
--
ALTER TABLE `promotion_groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `promotion_targets`
--
ALTER TABLE `promotion_targets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=205;

--
-- AUTO_INCREMENT for table `promotion_targets_custom_lists`
--
ALTER TABLE `promotion_targets_custom_lists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `promotion_users`
--
ALTER TABLE `promotion_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `promo_payment_method`
--
ALTER TABLE `promo_payment_method`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `promo_targets`
--
ALTER TABLE `promo_targets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5884;

--
-- AUTO_INCREMENT for table `push_messages`
--
ALTER TABLE `push_messages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=354;

--
-- AUTO_INCREMENT for table `redeem_points`
--
ALTER TABLE `redeem_points`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=169;

--
-- AUTO_INCREMENT for table `request_logs`
--
ALTER TABLE `request_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3927;

--
-- AUTO_INCREMENT for table `rewards`
--
ALTER TABLE `rewards`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `schedule_days`
--
ALTER TABLE `schedule_days`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `section_images`
--
ALTER TABLE `section_images`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `shipping_areas`
--
ALTER TABLE `shipping_areas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shipping_methods`
--
ALTER TABLE `shipping_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `stock_notifications`
--
ALTER TABLE `stock_notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=539;

--
-- AUTO_INCREMENT for table `sub_category_groups`
--
ALTER TABLE `sub_category_groups`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1044;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `total_spent_per_categories`
--
ALTER TABLE `total_spent_per_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21455;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1000027;

--
-- AUTO_INCREMENT for table `user_points`
--
ALTER TABLE `user_points`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `user_redeems`
--
ALTER TABLE `user_redeems`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=146;

--
-- AUTO_INCREMENT for table `user_settings`
--
ALTER TABLE `user_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2124;

--
-- AUTO_INCREMENT for table `wallets`
--
ALTER TABLE `wallets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wallet_histories`
--
ALTER TABLE `wallet_histories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_area_id_foreign` FOREIGN KEY (`area_id`) REFERENCES `areas` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `addresses_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `addresses_district_id_foreign` FOREIGN KEY (`district_id`) REFERENCES `districts` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `affiliate_links`
--
ALTER TABLE `affiliate_links`
  ADD CONSTRAINT `affiliate_links_affiliate_id_foreign` FOREIGN KEY (`affiliate_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `affiliate_requests`
--
ALTER TABLE `affiliate_requests`
  ADD CONSTRAINT `affiliate_requests_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
