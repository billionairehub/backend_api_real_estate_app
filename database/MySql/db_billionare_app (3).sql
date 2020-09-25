-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th9 25, 2020 lúc 10:20 AM
-- Phiên bản máy phục vụ: 10.4.14-MariaDB
-- Phiên bản PHP: 7.2.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `db_billionare_app`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `account`
--

CREATE TABLE `account` (
  `id` int(10) UNSIGNED NOT NULL,
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
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `account`
--

INSERT INTO `account` (`id`, `username`, `passwords`, `phone`, `email`, `url_avata`, `url_cover_image`, `personal_infor`, `id_token_faceboook`, `id_token_google`, `birth_date`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'userupdate2', '$2y$10$J3CReJXX10fqGQwk.AU/eO6qeVyLTlH.gyzUgAoUcP/aL4YGGIhg6', '0123456789', 'chieudang@gmail.com', 'http://localhost:8000/image_avata/2020_09_25_01_33_141600997594.png', 'http://localhost:8000/image_cover/2020_09_25_01_33_141600997594.png', 'Thông tin giới thiệu ĐVC', NULL, NULL, '1999-09-10', '2020-09-24 02:22:30', '2020-09-24 18:33:15', NULL),
(2, 'userupdate', '$2y$10$K24uy.0WG.cHdxe6OrZ6t.62VhRjkv6NMYH3j.IC9113nIHIPGB2a', '0123456702', 'chieudangupdate@gmail.com', 'http://localhost:8000/image_avata/2020_09_25_08_15_421601021742.png', 'http://localhost:8000/image_cover/2020_09_25_08_13_471601021627.png', 'Thông tin giới thiệu ĐVC', NULL, NULL, '2020-09-25', '2020-09-24 23:59:47', '2020-09-25 01:16:10', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `album`
--

CREATE TABLE `album` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_account` int(11) NOT NULL,
  `album_avt` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `album_cover` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `album`
--

INSERT INTO `album` (`id`, `id_account`, `album_avt`, `album_cover`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'http://localhost:8000/image_avata/2020_09_24_09_22_291600939349.png', 'http://localhost:8000/image_cover/2020_09_24_09_22_291600939349.png', '2020-09-24 02:22:29', '2020-09-24 02:22:29', NULL),
(2, 1, 'http://localhost:8000/image_avata/2020_09_24_09_23_151600939395.png', 'http://localhost:8000/image_cover/2020_09_24_09_23_151600939395.png', '2020-09-24 02:23:16', '2020-09-24 02:23:16', NULL),
(3, 1, 'http://localhost:8000/image_avata/2020_09_25_01_33_141600997594.png', 'http://localhost:8000/image_cover/2020_09_25_01_33_141600997594.png', '2020-09-24 18:33:14', '2020-09-24 18:33:14', NULL),
(4, 2, 'http://localhost:8000/image_avata/2020_09_25_06_59_461601017186.png', 'http://localhost:8000/image_cover/2020_09_25_06_59_461601017187.png', '2020-09-24 23:59:47', '2020-09-24 23:59:47', NULL),
(5, 2, 'http://localhost:8000/image_avata/2020_09_25_08_05_091601021109.png', 'http://localhost:8000/image_cover/2020_09_25_06_59_461601017187.png', '2020-09-25 01:05:09', '2020-09-25 01:05:09', NULL),
(6, 2, 'http://localhost:8000/image_avata/2020_09_25_08_05_501601021150.png', 'http://localhost:8000/image_cover/2020_09_25_06_59_461601017187.png', '2020-09-25 01:05:50', '2020-09-25 01:05:50', NULL),
(7, 2, 'http://localhost:8000/image_avata/2020_09_25_08_06_111601021171.png', 'http://localhost:8000/image_cover/2020_09_25_06_59_461601017187.png', '2020-09-25 01:06:11', '2020-09-25 01:06:11', NULL),
(8, 2, 'http://localhost:8000/image_avata/2020_09_25_08_06_111601021171.png', 'http://localhost:8000/image_cover/2020_09_25_08_12_131601021533.png', '2020-09-25 01:12:13', '2020-09-25 01:12:13', NULL),
(9, 2, 'http://localhost:8000/image_avata/2020_09_25_08_06_111601021171.png', 'http://localhost:8000/image_cover/2020_09_25_08_12_521601021572.png', '2020-09-25 01:12:52', '2020-09-25 01:12:52', NULL),
(10, 2, 'http://localhost:8000/image_avata/2020_09_25_08_06_111601021171.png', 'http://localhost:8000/image_cover/2020_09_25_08_13_471601021627.png', '2020-09-25 01:13:47', '2020-09-25 01:13:47', NULL),
(11, 2, 'http://localhost:8000/image_avata/2020_09_25_08_15_421601021742.png', 'http://localhost:8000/image_cover/2020_09_25_08_13_471601021627.png', '2020-09-25 01:15:42', '2020-09-25 01:15:42', NULL),
(12, 2, 'http://localhost:8000/image_avata/2020_09_25_08_15_421601021742.png', 'http://localhost:8000/image_cover/2020_09_25_08_13_471601021627.png', '2020-09-25 01:16:10', '2020-09-25 01:16:10', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `comment`
--

CREATE TABLE `comment` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_post` int(11) NOT NULL,
  `id_account_comment` int(11) NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `follow`
--

CREATE TABLE `follow` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_account` int(11) NOT NULL,
  `id_followers` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `like`
--

CREATE TABLE `like` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_post` int(11) NOT NULL,
  `id_account_like` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(15, '2020_09_23_025625_create_accounts_table', 1),
(16, '2020_09_23_025714_create_posts_table', 1),
(17, '2020_09_23_025740_create_post_details_table', 1),
(18, '2020_09_23_025754_create_likes_table', 1),
(19, '2020_09_23_025818_create_comments_table', 1),
(20, '2020_09_23_030107_create_follows_table', 1),
(21, '2020_09_23_095723_create_albums_table', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `post`
--

CREATE TABLE `post` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_account` int(11) NOT NULL,
  `post_date` date NOT NULL,
  `sum_image` int(11) NOT NULL,
  `id_comment` int(11) NOT NULL,
  `id_like` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `post_detail`
--

CREATE TABLE `post_detail` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_post` int(11) NOT NULL,
  `url_img` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `album`
--
ALTER TABLE `album`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `follow`
--
ALTER TABLE `follow`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `like`
--
ALTER TABLE `like`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `post_detail`
--
ALTER TABLE `post_detail`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `account`
--
ALTER TABLE `account`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `album`
--
ALTER TABLE `album`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `follow`
--
ALTER TABLE `follow`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `like`
--
ALTER TABLE `like`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT cho bảng `post`
--
ALTER TABLE `post`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `post_detail`
--
ALTER TABLE `post_detail`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
