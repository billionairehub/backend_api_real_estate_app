-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1:3306
-- Thời gian đã tạo: Th9 29, 2020 lúc01:38 PM
-- Phiên bản máy phục vụ: 10.4.10-MariaDB
-- Phiên bản PHP: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `backend_api_real_estate_app`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `account`
--

DROP TABLE IF EXISTS `account`;
CREATE TABLE IF NOT EXISTS `account` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `passwords` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url_avata` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url_cover_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_infor` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_token_faceboook` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_token_google` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `code` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code_time_expireds` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `account`
--

INSERT INTO `account` (`id`, `username`, `passwords`, `phone`, `email`, `url_avata`, `url_cover_image`, `personal_infor`, `id_token_faceboook`, `id_token_google`, `birth_date`, `code`, `code_time_expireds`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'phuongminh', '$2y$10$GfYjezRxbG7.jxV0GCs9puLrbakpppn3AAb.bXT5rGx/IMIXPWYHi', NULL, 'nguyenminhphuong25111999@gmail.com', 'http://127.0.0.1:8000/image_cover/2020_09_28_01_41_261601257286.jpg', 'http://127.0.0.1:8000/image_cover/2020_09_28_01_41_261601257286.png,http://127.0.0.1:8000/image_cover/2020_09_28_01_41_261601257286.png,http://127.0.0.1:8000/image_cover/2020_09_28_01_41_261601257286.png', NULL, NULL, NULL, '2020-09-28', 'YG9HNE', 1601350477000, '2020-09-27 18:41:26', '2020-09-28 19:34:37', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `album`
--

DROP TABLE IF EXISTS `album`;
CREATE TABLE IF NOT EXISTS `album` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_account` int(11) NOT NULL,
  `album_avt` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `album_cover` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `album`
--

INSERT INTO `album` (`id`, `id_account`, `album_avt`, `album_cover`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'http://127.0.0.1:8000/image_avata/2020_09_28_01_41_261601257286.png', 'http://127.0.0.1:8000/image_cover/2020_09_28_01_41_261601257286.png', '2020-09-27 18:41:26', '2020-09-27 18:41:26', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_post` int(11) NOT NULL,
  `id_account_comment` int(11) NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `follow`
--

DROP TABLE IF EXISTS `follow`;
CREATE TABLE IF NOT EXISTS `follow` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_account` int(11) NOT NULL,
  `id_followers` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `like`
--

DROP TABLE IF EXISTS `like`;
CREATE TABLE IF NOT EXISTS `like` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_post` int(11) NOT NULL,
  `id_account_like` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(22, '2020_09_23_025625_create_accounts_table', 1),
(32, '2020_09_23_025714_create_posts_table', 2),
(24, '2020_09_23_025740_create_post_details_table', 1),
(25, '2020_09_23_025754_create_likes_table', 1),
(26, '2020_09_23_025818_create_comments_table', 1),
(27, '2020_09_23_030107_create_follows_table', 1),
(28, '2020_09_23_095723_create_albums_table', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `post`
--

DROP TABLE IF EXISTS `post`;
CREATE TABLE IF NOT EXISTS `post` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `post_author` bigint(20) NOT NULL,
  `post_content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_image` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_comment_status` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `post`
--

INSERT INTO `post` (`id`, `post_author`, `post_content`, `post_image`, `post_status`, `post_comment_status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(4, 1, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'https://earthsky.org/upl/2018/06/ocean-Kim-Cronan-Wabasso-Beach-FL-dec18-2018-scaled-e1591491613364.jpeg', 'published', 1, '2020-09-28 18:35:06', '2020-09-28 21:48:16', '2020-09-28 21:48:16'),
(3, 1, 'Updated', 'https://earthsky.org/upl/2018/06/ocean-Kim-Cronan-Wabasso-Beach-FL-dec18-2018-scaled-e1591491613364.jpeg,https://earthsky.org/upl/2018/06/ocean-Kim-Cronan-Wabasso-Beach-FL-dec18-2018-scaled-e1591491613364.jpeg,https://earthsky.org/upl/2018/06/ocean-Kim-Cronan-Wabasso-Beach-FL-dec18-2018-scaled-e1591491613364.jpeg,https://earthsky.org/upl/2018/06/ocean-Kim-Cronan-Wabasso-Beach-FL-dec18-2018-scaled-e1591491613364.jpeg,https://earthsky.org/upl/2018/06/ocean-Kim-Cronan-Wabasso-Beach-FL-dec18-2018-scaled-e1591491613364.jpeg,https://earthsky.org/upl/2018/06/ocean-Kim-Cronan-Wabasso-Beach-FL-dec18-2018-scaled-e1591491613364.jpeg', 'published', 1, '2020-09-28 18:35:06', '2020-09-28 21:47:07', '2020-09-28 21:47:07'),
(5, 1, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'https://earthsky.org/upl/2018/06/ocean-Kim-Cronan-Wabasso-Beach-FL-dec18-2018-scaled-e1591491613364.jpeg,https://earthsky.org/upl/2018/06/ocean-Kim-Cronan-Wabasso-Beach-FL-dec18-2018-scaled-e1591491613364.jpeg,https://earthsky.org/upl/2018/06/ocean-Kim-Cronan-Wabasso-Beach-FL-dec18-2018-scaled-e1591491613364.jpeg', 'published', 1, '2020-09-28 18:35:06', '2020-09-28 18:35:06', NULL),
(6, 1, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'https://earthsky.org/upl/2018/06/ocean-Kim-Cronan-Wabasso-Beach-FL-dec18-2018-scaled-e1591491613364.jpeg', 'published', 1, '2020-09-28 18:35:06', '2020-09-28 18:35:06', NULL),
(7, 1, 'Test', 'C:\\wamp64\\tmp\\php1700.tmp', 'published', 1, '2020-09-28 18:35:06', '2020-09-28 22:20:57', NULL),
(24, 1, 'Test ter', 'http://127.0.0.1:8000/storage/img_post/202009290607360LOCB6EYAFA.jpg,http://127.0.0.1:8000/storage/img_post/202009290607371UD44HRS0VJ.jpg', 'published', 1, '2020-09-28 23:07:37', '2020-09-28 23:07:37', NULL),
(25, 1, 'Update post 25', 'http://127.0.0.1:8000/storage/img_post/202009290614080BZOWIWWL49.jpg,http://127.0.0.1:8000/storage/img_post/202009290614081NVG8WKESYC.jpg,http://127.0.0.1:8000/storage/img_post/2020092906140823C37TAC1N8.jpg,http://127.0.0.1:8000/storage/img_post/20200929061409381D2KA912H.jpg', 'published', 1, '2020-09-28 23:13:07', '2020-09-28 23:14:09', NULL),
(8, 2, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'https://earthsky.org/upl/2018/06/ocean-Kim-Cronan-Wabasso-Beach-FL-dec18-2018-scaled-e1591491613364.jpeg', 'published', 1, '2020-09-28 18:35:06', '2020-09-28 18:35:06', NULL),
(9, 1, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'https://earthsky.org/upl/2018/06/ocean-Kim-Cronan-Wabasso-Beach-FL-dec18-2018-scaled-e1591491613364.jpeg', 'published', 1, '2020-09-28 18:35:06', '2020-09-28 22:24:56', '2020-09-28 22:24:56'),
(10, 1, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'https://earthsky.org/upl/2018/06/ocean-Kim-Cronan-Wabasso-Beach-FL-dec18-2018-scaled-e1591491613364.jpeg', 'published', 1, '2020-09-28 18:35:06', '2020-09-28 18:35:06', NULL),
(11, 1, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'https://earthsky.org/upl/2018/06/ocean-Kim-Cronan-Wabasso-Beach-FL-dec18-2018-scaled-e1591491613364.jpeg', 'published', 1, '2020-09-28 18:35:06', '2020-09-28 18:35:06', NULL),
(12, 1, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'https://earthsky.org/upl/2018/06/ocean-Kim-Cronan-Wabasso-Beach-FL-dec18-2018-scaled-e1591491613364.jpeg', 'published', 1, '2020-09-28 18:35:06', '2020-09-28 18:35:06', NULL),
(13, 1, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'https://earthsky.org/upl/2018/06/ocean-Kim-Cronan-Wabasso-Beach-FL-dec18-2018-scaled-e1591491613364.jpeg', 'published', 1, '2020-09-28 18:35:06', '2020-09-28 18:35:06', NULL),
(14, 1, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'https://earthsky.org/upl/2018/06/ocean-Kim-Cronan-Wabasso-Beach-FL-dec18-2018-scaled-e1591491613364.jpeg', 'published', 1, '2020-09-28 18:35:06', '2020-09-28 18:35:06', NULL),
(15, 1, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'https://earthsky.org/upl/2018/06/ocean-Kim-Cronan-Wabasso-Beach-FL-dec18-2018-scaled-e1591491613364.jpeg', 'published', 1, '2020-09-28 18:35:06', '2020-09-28 18:35:06', NULL),
(16, 1, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'https://earthsky.org/upl/2018/06/ocean-Kim-Cronan-Wabasso-Beach-FL-dec18-2018-scaled-e1591491613364.jpeg', 'published', 1, '2020-09-28 18:35:06', '2020-09-28 18:35:06', NULL),
(17, 1, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'https://earthsky.org/upl/2018/06/ocean-Kim-Cronan-Wabasso-Beach-FL-dec18-2018-scaled-e1591491613364.jpeg', 'published', 1, '2020-09-28 18:35:06', '2020-09-28 18:35:06', NULL),
(18, 1, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'https://earthsky.org/upl/2018/06/ocean-Kim-Cronan-Wabasso-Beach-FL-dec18-2018-scaled-e1591491613364.jpeg', 'published', 1, '2020-09-28 18:35:06', '2020-09-28 18:35:06', NULL),
(19, 1, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'https://earthsky.org/upl/2018/06/ocean-Kim-Cronan-Wabasso-Beach-FL-dec18-2018-scaled-e1591491613364.jpeg', 'published', 1, '2020-09-28 21:10:36', '2020-09-28 21:10:36', NULL),
(20, 1, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'https://earthsky.org/upl/2018/06/ocean-Kim-Cronan-Wabasso-Beach-FL-dec18-2018-scaled-e1591491613364.jpeg', 'published', 1, '2020-09-28 21:10:52', '2020-09-28 21:10:52', NULL),
(21, 1, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'https://earthsky.org/upl/2018/06/ocean-Kim-Cronan-Wabasso-Beach-FL-dec18-2018-scaled-e1591491613364.jpeg', 'published', 1, '2020-09-28 21:11:05', '2020-09-28 21:11:05', NULL),
(22, 1, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'https://earthsky.org/upl/2018/06/ocean-Kim-Cronan-Wabasso-Beach-FL-dec18-2018-scaled-e1591491613364.jpeg,https://earthsky.org/upl/2018/06/ocean-Kim-Cronan-Wabasso-Beach-FL-dec18-2018-scaled-e1591491613364.jpeg', 'published', 1, '2020-09-28 21:11:41', '2020-09-28 21:11:41', NULL),
(23, 1, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'https://earthsky.org/upl/2018/06/ocean-Kim-Cronan-Wabasso-Beach-FL-dec18-2018-scaled-e1591491613364.jpeg,https://earthsky.org/upl/2018/06/ocean-Kim-Cronan-Wabasso-Beach-FL-dec18-2018-scaled-e1591491613364.jpeg', 'published', 1, '2020-09-28 21:12:11', '2020-09-28 21:12:11', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
