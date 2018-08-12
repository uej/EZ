-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 2018-08-11 15:46:17
-- 服务器版本： 5.7.23-0ubuntu0.18.04.1-log
-- PHP Version: 7.2.8-1+ubuntu18.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- 表的结构 `cmf_common_apps`
--

CREATE TABLE `cmf_common_apps` (
  `id` int(11) NOT NULL,
  `app` char(50) NOT NULL COMMENT '应用标识',
  `title` char(50) NOT NULL COMMENT '应用标题',
  `description` varchar(255) NOT NULL COMMENT '应用描述',
  `createTime` int(10) UNSIGNED NOT NULL COMMENT '创建时间',
  `entryUrl` varchar(255) NOT NULL COMMENT '前台地址',
  `manageEntryUrl` varchar(255) NOT NULL COMMENT '后台地址',
  `logo` varchar(255) NOT NULL COMMENT '图标地址',
  `sort` smallint(5) UNSIGNED NOT NULL COMMENT '排序号',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1正常 0删除'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='应用表';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cmf_common_apps`
--
ALTER TABLE `cmf_common_apps`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `app` (`app`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `cmf_common_apps`
--
ALTER TABLE `cmf_common_apps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
