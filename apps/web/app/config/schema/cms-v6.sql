-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 05, 2023 at 10:04 AM
-- Server version: 8.0.26
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cms-v6`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int UNSIGNED NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `name` varchar(40) NOT NULL DEFAULT '',
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `created`, `modified`, `name`, `username`, `password`, `role`) VALUES
(1, '2022-12-16 13:51:15', '2022-12-16 13:51:15', '管理者', 'caters_admin', '$2y$10$7X.icRPhUBnFrsoBR784y.VMC9IrXxbbinEff3WMGa0N.WG3D8kH6', 0);

-- --------------------------------------------------------

--
-- Table structure for table `append_items`
--

CREATE TABLE `append_items` (
  `id` int UNSIGNED NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `page_config_id` int UNSIGNED NOT NULL DEFAULT '0',
  `position` int UNSIGNED NOT NULL DEFAULT '0',
  `name` varchar(40) NOT NULL DEFAULT '',
  `slug` varchar(30) NOT NULL DEFAULT '',
  `value_type` decimal(10,0) NOT NULL DEFAULT '0',
  `max_length` int UNSIGNED NOT NULL DEFAULT '0',
  `is_required` decimal(10,0) UNSIGNED NOT NULL DEFAULT '0',
  `mst_list_slug` varchar(40) NOT NULL DEFAULT '',
  `value_default` varchar(100) NOT NULL DEFAULT '',
  `attention` varchar(100) NOT NULL DEFAULT '',
  `edit_pos` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `append_items`
--

INSERT INTO `append_items` (`id`, `created`, `modified`, `page_config_id`, `position`, `name`, `slug`, `value_type`, `max_length`, `is_required`, `mst_list_slug`, `value_default`, `attention`, `edit_pos`) VALUES
(1, '2022-12-28 11:32:27', '2022-12-28 11:32:48', 1, 1, '数字欄追加', 'info_numeric', '1', 0, '0', '0', '', '', 1),
(2, '2022-12-28 11:39:18', '2022-12-28 11:39:18', 1, 2, 'テキスト追加', 'info_text', '2', 0, '0', '0', '', '', 5),
(3, '2022-12-28 11:41:28', '2022-12-28 11:41:28', 1, 3, 'テキストエリア追加', 'info_textarea', '3', 0, '0', '0', '', '', 0),
(4, '2022-12-28 11:48:03', '2022-12-28 11:48:03', 1, 4, '日付型追加', 'info_date', '4', 0, '0', '0', '', '', 3),
(5, '2022-12-28 12:00:14', '2022-12-28 12:00:14', 1, 5, '日付時間型の追加', 'info_datetime', '5', 0, '0', '0', '', '', 0),
(6, '2022-12-28 12:05:12', '2022-12-28 12:05:12', 1, 6, 'WYSIWYG型 追加', 'info_wysiwyg', '6', 0, '0', '0', '', '', 0),
(7, '2022-12-28 13:49:01', '2022-12-28 13:49:35', 1, 7, 'リスト型の追加', 'info_list', '10', 0, '0', 'sample_list', '', '', 0),
(8, '2022-12-28 13:54:34', '2022-12-28 14:25:52', 1, 8, '１チェックボックス', 'info_checkbox', '11', 0, '0', '0', '', '', 0),
(9, '2022-12-28 14:26:21', '2022-12-28 14:26:21', 1, 9, 'チェックボックス複数', 'info_checkbox_multiple', '11', 0, '0', 'sample_multiple', '', '', 0),
(10, '2022-12-28 15:35:10', '2022-12-28 15:37:23', 1, 10, 'radio型', 'info_radio', '12', 0, '0', 'sample_list', '1', '', 0),
(12, '2022-12-28 15:42:21', '2022-12-28 15:42:21', 1, 11, 'file型', 'info_file', '31', 0, '0', '0', '', '', 0),
(13, '2022-12-28 15:59:17', '2022-12-28 15:59:17', 1, 12, '画像型', 'info_image', '32', 0, '0', '0', '', '', 0),
(14, '2022-12-28 16:03:25', '2022-12-28 16:03:25', 1, 13, 'カラム無し', 'info_custom', '90', 0, '0', '0', '', '使用するViewはcustom_{スラッグ名}', 0);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int UNSIGNED NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `page_config_id` int UNSIGNED NOT NULL DEFAULT '0',
  `parent_category_id` int UNSIGNED NOT NULL DEFAULT '0',
  `position` int UNSIGNED NOT NULL DEFAULT '0',
  `status` varchar(10) NOT NULL DEFAULT 'publish',
  `name` varchar(40) NOT NULL DEFAULT '',
  `identifier` varchar(30) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `created`, `modified`, `page_config_id`, `parent_category_id`, `position`, `status`, `name`, `identifier`) VALUES
(1, '2022-12-16 15:38:45', '2022-12-16 15:38:45', 1, 0, 1, 'publish', 'カテゴリ！', ''),
(2, '2022-12-16 15:38:51', '2022-12-16 15:38:51', 1, 0, 2, 'publish', 'カテゴリ２', '');

-- --------------------------------------------------------

--
-- Table structure for table `infos`
--

CREATE TABLE `infos` (
  `id` int UNSIGNED NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `page_config_id` int UNSIGNED NOT NULL DEFAULT '0',
  `position` int UNSIGNED NOT NULL DEFAULT '0',
  `status` varchar(10) NOT NULL DEFAULT 'draft',
  `title` varchar(100) NOT NULL DEFAULT '',
  `notes` text NOT NULL,
  `start_at` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
  `end_at` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
  `image` varchar(100) NOT NULL DEFAULT '',
  `meta_description` varchar(200) NOT NULL DEFAULT '',
  `meta_keywords` varchar(200) NOT NULL DEFAULT '',
  `regist_user_id` int UNSIGNED NOT NULL DEFAULT '0',
  `category_id` int UNSIGNED NOT NULL DEFAULT '0',
  `index_type` decimal(10,0) NOT NULL DEFAULT '0',
  `multi_position` bigint NOT NULL DEFAULT '0',
  `parent_info_id` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `infos`
--

INSERT INTO `infos` (`id`, `created`, `modified`, `page_config_id`, `position`, `status`, `title`, `notes`, `start_at`, `end_at`, `image`, `meta_description`, `meta_keywords`, `regist_user_id`, `category_id`, `index_type`, `multi_position`, `parent_info_id`) VALUES
(2, '2022-12-16 17:45:50', '2022-12-28 15:59:45', 1, 2, 'publish', 'テスト', '', '2022-12-16 17:45:00', '1900-01-01 00:00:00', 'img_2_db851fa3-e4bc-4e75-9f73-c529d90a23ec.jpg', '', '', 1, 1, '0', 0, 0),
(3, '2022-12-20 18:57:24', '2022-12-20 18:57:24', 1, 1, 'publish', '待望のCMS-V6登場', '', '2022-12-20 18:56:00', '1900-01-01 00:00:00', 'img_3_26283c95-8967-440a-81ae-fcc916aae5d5.jpg', '', '', 1, 1, '0', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `info_append_items`
--

CREATE TABLE `info_append_items` (
  `id` int UNSIGNED NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `info_id` int UNSIGNED NOT NULL DEFAULT '0',
  `append_item_id` int UNSIGNED NOT NULL DEFAULT '0',
  `value_text` varchar(200) NOT NULL DEFAULT '',
  `value_textarea` text NOT NULL,
  `value_date` date NOT NULL DEFAULT '1900-01-01',
  `value_datetime` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
  `value_time` time NOT NULL DEFAULT '00:00:00',
  `value_int` int UNSIGNED NOT NULL DEFAULT '0',
  `value_key` varchar(30) NOT NULL DEFAULT '',
  `file` varchar(100) NOT NULL DEFAULT '',
  `file_size` int UNSIGNED NOT NULL DEFAULT '0',
  `file_name` varchar(100) NOT NULL DEFAULT '',
  `file_extension` varchar(10) NOT NULL DEFAULT '',
  `image` varchar(100) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `info_append_items`
--

INSERT INTO `info_append_items` (`id`, `created`, `modified`, `info_id`, `append_item_id`, `value_text`, `value_textarea`, `value_date`, `value_datetime`, `value_time`, `value_int`, `value_key`, `file`, `file_size`, `file_name`, `file_extension`, `image`) VALUES
(5, '2022-12-28 14:53:11', '2022-12-28 15:59:45', 2, 3, '', '', '1900-01-01', '1900-01-01 00:00:00', '00:00:00', 0, '', '', 0, '', '', ''),
(6, '2022-12-28 14:53:11', '2022-12-28 15:59:45', 2, 5, '', '', '1900-01-01', '1900-01-01 00:00:00', '00:00:00', 0, '', '', 0, '', '', ''),
(7, '2022-12-28 14:53:11', '2022-12-28 15:59:45', 2, 6, '', '', '1900-01-01', '1900-01-01 00:00:00', '00:00:00', 0, '', '', 0, '', '', ''),
(8, '2022-12-28 14:53:11', '2022-12-28 15:59:45', 2, 7, '', '', '1900-01-01', '1900-01-01 00:00:00', '00:00:00', 0, '', '', 0, '', '', ''),
(9, '2022-12-28 14:53:11', '2022-12-28 15:59:45', 2, 8, '', '', '1900-01-01', '1900-01-01 00:00:00', '00:00:00', 1, '', '', 0, '', '', ''),
(10, '2022-12-28 14:53:11', '2022-12-28 15:59:45', 2, 9, '', '', '1900-01-01', '1900-01-01 00:00:00', '00:00:00', 44, '', '', 0, '', '', ''),
(11, '2022-12-28 15:58:13', '2022-12-28 15:59:45', 2, 10, '', '', '1900-01-01', '1900-01-01 00:00:00', '00:00:00', 0, '1', '', 0, '', '', ''),
(12, '2022-12-28 15:58:13', '2022-12-28 15:59:45', 2, 12, '', '', '1900-01-01', '1900-01-01 00:00:00', '00:00:00', 0, '', 'ap_file_12_abcd945a-d62b-4d32-8add-8ee116f29681.pdf', 85097, 'Book1', 'pdf', ''),
(13, '2022-12-28 15:59:45', '2022-12-28 15:59:45', 2, 13, '', '', '1900-01-01', '1900-01-01 00:00:00', '00:00:00', 0, '', '', 0, '', '', 'append_img_13_d8140af5-9d00-4564-9606-5e86c1b19cec.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `info_categories`
--

CREATE TABLE `info_categories` (
  `id` int UNSIGNED NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `info_id` int UNSIGNED NOT NULL DEFAULT '0',
  `category_id` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `info_contents`
--

CREATE TABLE `info_contents` (
  `id` int UNSIGNED NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `info_id` int UNSIGNED NOT NULL DEFAULT '0',
  `block_type` decimal(10,0) NOT NULL DEFAULT '0',
  `position` int UNSIGNED NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `image` varchar(100) NOT NULL DEFAULT '',
  `image_pos` varchar(10) NOT NULL DEFAULT '',
  `file` varchar(100) NOT NULL DEFAULT '',
  `file_size` int UNSIGNED NOT NULL DEFAULT '0',
  `file_name` varchar(100) NOT NULL DEFAULT '',
  `file_extension` varchar(10) NOT NULL DEFAULT '',
  `section_sequence_id` int UNSIGNED NOT NULL DEFAULT '0',
  `option_value` varchar(255) NOT NULL DEFAULT '',
  `option_value2` varchar(40) NOT NULL DEFAULT '',
  `option_value3` varchar(40) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `info_contents`
--

INSERT INTO `info_contents` (`id`, `created`, `modified`, `info_id`, `block_type`, `position`, `title`, `content`, `image`, `image_pos`, `file`, `file_size`, `file_name`, `file_extension`, `section_sequence_id`, `option_value`, `option_value2`, `option_value3`) VALUES
(1, '2022-12-16 18:04:46', '2022-12-28 15:59:45', 2, '1', 1, 'タイトル', '', '', '', '', 0, '', '', 0, '', '', ''),
(2, '2022-12-16 18:04:46', '2022-12-28 15:59:45', 2, '2', 3, '', '<p>本文が入ります。</p>', '', '', '', 0, '', '', 0, '', '', ''),
(3, '2022-12-16 18:05:14', '2022-12-28 15:59:45', 2, '3', 2, '', '', 'img_3_fd852c41-c1de-4fdf-b75e-14de872bc6f3.jpg', '', '', 0, '', '', 0, '_self', '', ''),
(6, '2022-12-16 18:18:29', '2022-12-28 15:59:45', 2, '5', 4, '', '', '', '', '', 0, '', '', 0, '', '', ''),
(7, '2022-12-16 18:18:29', '2022-12-28 15:59:45', 2, '4', 5, '', '', '', '', 'e_f_7_eaf2c642-573f-4f3f-8fed-3acdf4f2e6a4.pdf', 85097, 'Book1', 'pdf', 0, '', '', ''),
(8, '2022-12-16 18:22:35', '2022-12-28 15:59:45', 2, '8', 6, 'ボタンです', 'http://caters.co.jp', '', '', '', 0, '', '', 0, '', '_blank', ''),
(9, '2022-12-16 18:22:35', '2022-12-28 15:59:45', 2, '9', 7, '', '', '', '', '', 0, '', '', 0, '', '', ''),
(10, '2022-12-16 18:22:35', '2022-12-28 15:59:45', 2, '11', 8, '', '', 'img_10_2e846a0b-8e8c-447a-826c-f00564319579.jpg', 'left', '', 0, '', '', 0, '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `info_stock_tables`
--

CREATE TABLE `info_stock_tables` (
  `id` bigint UNSIGNED NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `info_id` int UNSIGNED NOT NULL DEFAULT '0',
  `page_slug` varchar(40) NOT NULL DEFAULT '',
  `model_name` varchar(40) NOT NULL DEFAULT '',
  `model_id` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `info_tags`
--

CREATE TABLE `info_tags` (
  `id` int UNSIGNED NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `info_id` int UNSIGNED NOT NULL DEFAULT '0',
  `tag_id` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `info_tags`
--

INSERT INTO `info_tags` (`id`, `created`, `modified`, `info_id`, `tag_id`) VALUES
(1, '2022-12-16 18:11:28', '2022-12-16 18:11:28', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `info_tops`
--

CREATE TABLE `info_tops` (
  `id` int UNSIGNED NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `page_config_id` int UNSIGNED NOT NULL DEFAULT '0',
  `position` int UNSIGNED NOT NULL DEFAULT '0',
  `info_id` int UNSIGNED NOT NULL DEFAULT '0',
  `title` varchar(200) NOT NULL DEFAULT '',
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `kvs`
--

CREATE TABLE `kvs` (
  `id` int UNSIGNED NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `name` varchar(50) NOT NULL DEFAULT '',
  `key_name` varchar(40) NOT NULL DEFAULT '',
  `val` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `mst_lists`
--

CREATE TABLE `mst_lists` (
  `id` int UNSIGNED NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `position` decimal(10,0) NOT NULL COMMENT '表示順',
  `status` varchar(10) NOT NULL DEFAULT 'publish',
  `ltrl_cd` varchar(60) DEFAULT NULL,
  `ltrl_val` varchar(60) DEFAULT NULL,
  `ltrl_sub_val` text,
  `slug` varchar(100) NOT NULL DEFAULT '',
  `name` varchar(100) NOT NULL DEFAULT '',
  `sys_cd` decimal(10,0) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mst_lists`
--

INSERT INTO `mst_lists` (`id`, `created`, `modified`, `position`, `status`, `ltrl_cd`, `ltrl_val`, `ltrl_sub_val`, `slug`, `name`, `sys_cd`) VALUES
(1, '2022-12-28 13:47:34', '2022-12-28 13:47:34', '1', 'publish', '1', 'リスト項目１', '', 'sample_list', 'サンプルリスト', '1'),
(2, '2022-12-28 13:47:48', '2022-12-28 13:47:48', '2', 'publish', '2', 'リスト項目２', '', 'sample_list', 'サンプルリスト', '1'),
(3, '2022-12-28 14:23:49', '2022-12-28 14:23:49', '1', 'publish', '0x0001', '項目１', '', 'sample_multiple', '複数選択用サンプル', '1'),
(4, '2022-12-28 14:24:09', '2022-12-28 14:24:09', '2', 'publish', '0x0002', '項目２', '', 'sample_multiple', '複数選択用サンプル', '1'),
(5, '2022-12-28 14:24:19', '2022-12-28 14:24:19', '3', 'publish', '0x0004', '項目３', '', 'sample_multiple', '複数選択用サンプル', '1'),
(6, '2022-12-28 14:24:30', '2022-12-28 14:24:30', '4', 'publish', '0x0008', '項目４', '', 'sample_multiple', '複数選択用サンプル', '1'),
(7, '2022-12-28 14:24:42', '2022-12-28 14:24:42', '5', 'publish', '0x0010', '項目５', '', 'sample_multiple', '複数選択用サンプル', '1'),
(8, '2022-12-28 14:25:00', '2022-12-28 14:25:00', '6', 'publish', '0x0020', '項目６', '', 'sample_multiple', '複数選択用サンプル', '1'),
(9, '2022-12-28 14:25:25', '2022-12-28 14:25:25', '7', 'publish', '0x0040', '項目７', '', 'sample_multiple', '複数選択用サンプル', '1');

-- --------------------------------------------------------

--
-- Table structure for table `page_configs`
--

CREATE TABLE `page_configs` (
  `id` int UNSIGNED NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `site_config_id` int UNSIGNED NOT NULL DEFAULT '0',
  `position` int UNSIGNED NOT NULL DEFAULT '0',
  `page_title` varchar(100) NOT NULL DEFAULT '',
  `slug` varchar(40) NOT NULL DEFAULT '',
  `header` text NOT NULL,
  `footer` text NOT NULL,
  `is_public_date` decimal(10,0) NOT NULL DEFAULT '0',
  `is_public_time` decimal(10,0) NOT NULL DEFAULT '0',
  `page_template_id` int UNSIGNED NOT NULL DEFAULT '0',
  `description` varchar(255) NOT NULL DEFAULT '',
  `keywords` varchar(255) NOT NULL DEFAULT '',
  `is_category` varchar(10) NOT NULL DEFAULT 'N',
  `is_category_sort` varchar(10) NOT NULL DEFAULT 'N',
  `is_category_multiple` decimal(10,0) NOT NULL DEFAULT '0',
  `is_category_multilevel` decimal(10,0) NOT NULL DEFAULT '0',
  `modified_category_role` int UNSIGNED NOT NULL DEFAULT '0',
  `max_multilevel` int UNSIGNED NOT NULL DEFAULT '0',
  `disable_position_order` decimal(10,0) NOT NULL DEFAULT '0',
  `disable_preview` decimal(10,0) NOT NULL DEFAULT '0',
  `is_auto_menu` decimal(10,0) NOT NULL DEFAULT '0',
  `list_style` decimal(10,0) NOT NULL DEFAULT '1',
  `root_dir_type` decimal(10,0) NOT NULL DEFAULT '0',
  `link_color` varchar(10) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `page_configs`
--

INSERT INTO `page_configs` (`id`, `created`, `modified`, `site_config_id`, `position`, `page_title`, `slug`, `header`, `footer`, `is_public_date`, `is_public_time`, `page_template_id`, `description`, `keywords`, `is_category`, `is_category_sort`, `is_category_multiple`, `is_category_multilevel`, `modified_category_role`, `max_multilevel`, `disable_position_order`, `disable_preview`, `is_auto_menu`, `list_style`, `root_dir_type`, `link_color`) VALUES
(1, '2022-12-16 15:38:35', '2022-12-16 15:38:35', 1, 1, 'お知らせ', 'news', '', '', '0', '0', 0, '', '', 'Y', 'N', '0', '0', 0, 0, '0', '0', '1', '1', '0', '#000000');

-- --------------------------------------------------------

--
-- Table structure for table `page_config_extensions`
--

CREATE TABLE `page_config_extensions` (
  `id` int UNSIGNED NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `page_config_id` int UNSIGNED NOT NULL DEFAULT '0',
  `position` int NOT NULL DEFAULT '0',
  `status` varchar(10) NOT NULL DEFAULT 'publish',
  `type` decimal(10,0) NOT NULL DEFAULT '0',
  `option_value` varchar(100) NOT NULL DEFAULT '',
  `name` varchar(40) NOT NULL DEFAULT '',
  `link` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `page_config_items`
--

CREATE TABLE `page_config_items` (
  `id` int UNSIGNED NOT NULL,
  `created` datetime NOT NULL,
  `modifed` datetime NOT NULL,
  `page_config_id` int UNSIGNED NOT NULL DEFAULT '0',
  `position` int UNSIGNED NOT NULL DEFAULT '0',
  `parts_type` varchar(10) NOT NULL DEFAULT 'main',
  `item_key` varchar(40) NOT NULL DEFAULT '',
  `status` varchar(10) NOT NULL DEFAULT 'Y',
  `memo` varchar(100) NOT NULL DEFAULT '',
  `title` varchar(30) NOT NULL DEFAULT '',
  `sub_title` varchar(30) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `phinxlog`
--

CREATE TABLE `phinxlog` (
  `version` bigint NOT NULL,
  `migration_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `breakpoint` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `phinxlog`
--

INSERT INTO `phinxlog` (`version`, `migration_name`, `start_time`, `end_time`, `breakpoint`) VALUES
(20221208022223, 'Initial', '2022-12-16 04:48:25', '2022-12-16 04:48:25', 0);

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `id` int UNSIGNED NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `date` date NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'publish',
  `memo` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`id`, `created`, `modified`, `date`, `status`, `memo`) VALUES
(1, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-01-01', '1', ''),
(2, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-01-02', '1', ''),
(3, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-01-08', '1', ''),
(4, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-01-09', '1', ''),
(5, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-01-10', '1', ''),
(6, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-01-15', '1', ''),
(7, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-01-16', '1', ''),
(8, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-01-22', '1', ''),
(9, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-01-23', '1', ''),
(10, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-01-29', '1', ''),
(11, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-01-30', '1', ''),
(12, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-02-05', '1', ''),
(13, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-02-06', '1', ''),
(14, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-02-11', '1', ''),
(15, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-02-12', '1', ''),
(16, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-02-13', '1', ''),
(17, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-02-19', '1', ''),
(18, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-02-20', '1', ''),
(19, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-02-23', '1', ''),
(20, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-02-26', '1', ''),
(21, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-02-27', '1', ''),
(22, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-03-05', '1', ''),
(23, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-03-06', '1', ''),
(24, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-03-12', '1', ''),
(25, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-03-13', '1', ''),
(26, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-03-19', '1', ''),
(27, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-03-20', '1', ''),
(28, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-03-26', '1', ''),
(29, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-03-27', '1', ''),
(30, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-04-02', '1', ''),
(31, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-04-03', '1', ''),
(32, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-04-09', '1', ''),
(33, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-04-10', '1', ''),
(34, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-04-16', '1', ''),
(35, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-04-17', '1', ''),
(36, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-04-23', '1', ''),
(37, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-04-24', '1', ''),
(38, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-04-29', '1', ''),
(39, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-04-30', '1', ''),
(40, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-05-01', '1', ''),
(41, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-05-03', '1', ''),
(42, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-05-04', '1', ''),
(43, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-05-05', '1', ''),
(44, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-05-07', '1', ''),
(45, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-05-08', '1', ''),
(46, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-05-14', '1', ''),
(47, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-05-15', '1', ''),
(48, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-05-21', '1', ''),
(49, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-05-22', '1', ''),
(50, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-05-28', '1', ''),
(51, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-05-29', '1', ''),
(52, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-06-04', '1', ''),
(53, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-06-05', '1', ''),
(54, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-06-11', '1', ''),
(55, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-06-12', '1', ''),
(56, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-06-18', '1', ''),
(57, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-06-19', '1', ''),
(58, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-06-25', '1', ''),
(59, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-06-26', '1', ''),
(60, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-07-02', '1', ''),
(61, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-07-03', '1', ''),
(62, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-07-09', '1', ''),
(63, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-07-10', '1', ''),
(64, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-07-16', '1', ''),
(65, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-07-17', '1', ''),
(66, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-07-18', '1', ''),
(67, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-07-23', '1', ''),
(68, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-07-24', '1', ''),
(69, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-07-30', '1', ''),
(70, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-07-31', '1', ''),
(71, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-08-06', '1', ''),
(72, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-08-07', '1', ''),
(73, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-08-11', '1', ''),
(74, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-08-13', '1', ''),
(75, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-08-14', '1', ''),
(76, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-08-20', '1', ''),
(77, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-08-21', '1', ''),
(78, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-08-27', '1', ''),
(79, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-08-28', '1', ''),
(80, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-09-03', '1', ''),
(81, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-09-04', '1', ''),
(82, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-09-10', '1', ''),
(83, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-09-11', '1', ''),
(84, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-09-17', '1', ''),
(85, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-09-18', '1', ''),
(86, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-09-19', '1', ''),
(87, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-09-24', '1', ''),
(88, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-09-25', '1', ''),
(89, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-10-01', '1', ''),
(90, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-10-02', '1', ''),
(91, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-10-08', '1', ''),
(92, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-10-09', '1', ''),
(93, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-10-10', '1', ''),
(94, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-10-15', '1', ''),
(95, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-10-16', '1', ''),
(96, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-10-22', '1', ''),
(97, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-10-23', '1', ''),
(98, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-10-29', '1', ''),
(99, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-10-30', '1', ''),
(100, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-11-03', '1', ''),
(101, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-11-05', '1', ''),
(102, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-11-06', '1', ''),
(103, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-11-12', '1', ''),
(104, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-11-13', '1', ''),
(105, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-11-19', '1', ''),
(106, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-11-20', '1', ''),
(107, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-11-23', '1', ''),
(108, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-11-26', '1', ''),
(109, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-11-27', '1', ''),
(110, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-12-03', '1', ''),
(111, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-12-04', '1', ''),
(112, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-12-10', '1', ''),
(113, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-12-11', '1', ''),
(114, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-12-17', '1', ''),
(115, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-12-18', '1', ''),
(116, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-12-24', '1', ''),
(117, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-12-25', '1', ''),
(118, '2022-12-20 18:15:16', '2022-12-20 18:15:16', '2022-12-31', '1', ''),
(119, '2022-12-20 18:21:27', '2022-12-20 18:21:30', '2022-04-28', '0', '');

-- --------------------------------------------------------

--
-- Table structure for table `section_sequences`
--

CREATE TABLE `section_sequences` (
  `id` int UNSIGNED NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `info_content_id` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `site_configs`
--

CREATE TABLE `site_configs` (
  `id` int UNSIGNED NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `position` int UNSIGNED NOT NULL DEFAULT '0',
  `status` varchar(10) NOT NULL DEFAULT 'draft',
  `site_name` varchar(100) NOT NULL DEFAULT '',
  `slug` varchar(40) NOT NULL DEFAULT '',
  `is_root` decimal(10,0) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `site_configs`
--

INSERT INTO `site_configs` (`id`, `created`, `modified`, `position`, `status`, `site_name`, `slug`, `is_root`) VALUES
(1, '2022-12-16 13:55:04', '2022-12-16 13:55:04', 1, 'publish', 'デモサイト', '', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` int UNSIGNED NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `tag` varchar(40) NOT NULL DEFAULT '',
  `status` varchar(10) NOT NULL DEFAULT 'publish',
  `position` int UNSIGNED NOT NULL DEFAULT '0',
  `page_config_id` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `created`, `modified`, `tag`, `status`, `position`, `page_config_id`) VALUES
(1, '2022-12-16 18:11:28', '2022-12-16 18:11:28', 'ああ', 'publish', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `useradmins`
--

CREATE TABLE `useradmins` (
  `id` int UNSIGNED NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `email` varchar(200) NOT NULL DEFAULT '',
  `username` varchar(30) NOT NULL DEFAULT '',
  `password` varchar(200) NOT NULL DEFAULT '',
  `temp_password` varchar(40) NOT NULL DEFAULT '',
  `temp_pass_expired` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
  `temp_key` varchar(200) NOT NULL DEFAULT '',
  `name` varchar(60) NOT NULL DEFAULT '',
  `status` varchar(10) NOT NULL DEFAULT 'publish',
  `face_image` varchar(100) NOT NULL DEFAULT '',
  `role` int UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `useradmins`
--

INSERT INTO `useradmins` (`id`, `created`, `modified`, `email`, `username`, `password`, `temp_password`, `temp_pass_expired`, `temp_key`, `name`, `status`, `face_image`, `role`) VALUES
(1, '2022-12-16 14:58:38', '2022-12-16 15:38:04', '', 'develop', '', 'caters040917', '1900-01-01 00:00:00', '', '開発', 'publish', 'img_1_33d0f62c-394d-405d-8d30-90ee39fb61fe.jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `useradmin_sites`
--

CREATE TABLE `useradmin_sites` (
  `id` int UNSIGNED NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `useradmin_id` int UNSIGNED NOT NULL DEFAULT '0',
  `site_config_id` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `useradmin_sites`
--

INSERT INTO `useradmin_sites` (`id`, `created`, `modified`, `useradmin_id`, `site_config_id`) VALUES
(1, '2022-12-16 15:38:04', '2022-12-16 15:38:04', 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `append_items`
--
ALTER TABLE `append_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `infos`
--
ALTER TABLE `infos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `info_append_items`
--
ALTER TABLE `info_append_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `info_categories`
--
ALTER TABLE `info_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `info_contents`
--
ALTER TABLE `info_contents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `info_stock_tables`
--
ALTER TABLE `info_stock_tables`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `info_tags`
--
ALTER TABLE `info_tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `info_tops`
--
ALTER TABLE `info_tops`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kvs`
--
ALTER TABLE `kvs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mst_lists`
--
ALTER TABLE `mst_lists`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sys_cd` (`sys_cd`,`slug`,`ltrl_cd`),
  ADD KEY `sys_cd_2` (`sys_cd`,`slug`);

--
-- Indexes for table `page_configs`
--
ALTER TABLE `page_configs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `page_config_extensions`
--
ALTER TABLE `page_config_extensions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `page_config_items`
--
ALTER TABLE `page_config_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `phinxlog`
--
ALTER TABLE `phinxlog`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `section_sequences`
--
ALTER TABLE `section_sequences`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `site_configs`
--
ALTER TABLE `site_configs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `useradmins`
--
ALTER TABLE `useradmins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `useradmin_sites`
--
ALTER TABLE `useradmin_sites`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `append_items`
--
ALTER TABLE `append_items`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `infos`
--
ALTER TABLE `infos`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `info_append_items`
--
ALTER TABLE `info_append_items`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `info_categories`
--
ALTER TABLE `info_categories`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `info_contents`
--
ALTER TABLE `info_contents`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `info_stock_tables`
--
ALTER TABLE `info_stock_tables`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `info_tags`
--
ALTER TABLE `info_tags`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `info_tops`
--
ALTER TABLE `info_tops`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kvs`
--
ALTER TABLE `kvs`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mst_lists`
--
ALTER TABLE `mst_lists`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `page_configs`
--
ALTER TABLE `page_configs`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `page_config_extensions`
--
ALTER TABLE `page_config_extensions`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `page_config_items`
--
ALTER TABLE `page_config_items`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT for table `section_sequences`
--
ALTER TABLE `section_sequences`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `site_configs`
--
ALTER TABLE `site_configs`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `useradmins`
--
ALTER TABLE `useradmins`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `useradmin_sites`
--
ALTER TABLE `useradmin_sites`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
