-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2018-08-21 15:47:28
-- 服务器版本： 5.5.47
-- PHP Version: 7.0.1

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

-- --------------------------------------------------------

--
-- 表的结构 `cmf_common_menu`
--

CREATE TABLE `cmf_common_menu` (
  `id` int(11) NOT NULL,
  `typeId` tinyint(4) NOT NULL COMMENT '类型',
  `parentId` int(11) NOT NULL COMMENT '上级id',
  `appId` int(11) NOT NULL COMMENT '应用id',
  `title` char(50) NOT NULL COMMENT '名称',
  `app` varchar(50) NOT NULL COMMENT '应用标识',
  `controller` varchar(50) NOT NULL COMMENT '控制器',
  `action` varchar(50) NOT NULL COMMENT '方法',
  `createTime` int(10) UNSIGNED NOT NULL COMMENT '创建时间',
  `sort` smallint(5) UNSIGNED NOT NULL COMMENT '排序',
  `className` varchar(255) DEFAULT NULL COMMENT '样式',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1正常 0删除',
  `askSure` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1操作询问'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='功能表';

-- --------------------------------------------------------

--
-- 表的结构 `cmf_company`
--

CREATE TABLE `cmf_company` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL COMMENT '商户名称',
  `address` varchar(100) NOT NULL COMMENT '地址',
  `contact` char(50) NOT NULL COMMENT '联系人',
  `phone` char(13) NOT NULL COMMENT '联系电话',
  `parentId` int(11) NOT NULL DEFAULT '0' COMMENT '上级id',
  `apps` varchar(255) NOT NULL COMMENT '可用应用id',
  `createTime` int(10) UNSIGNED NOT NULL COMMENT '创建时间',
  `createUserId` int(11) NOT NULL COMMENT '创建人id',
  `modifyUserId` int(11) DEFAULT NULL COMMENT '最后修改人id',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1开放 0关闭'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='商户表';

-- --------------------------------------------------------

--
-- 表的结构 `cmf_company_user`
--

CREATE TABLE `cmf_company_user` (
  `id` int(11) NOT NULL,
  `account` char(50) NOT NULL COMMENT '账号',
  `name` char(30) NOT NULL COMMENT '姓名',
  `password` char(40) NOT NULL COMMENT '密码',
  `createTime` int(10) UNSIGNED NOT NULL COMMENT '创建时间',
  `roleId` int(11) NOT NULL COMMENT '角色id',
  `companyId` int(11) NOT NULL COMMENT '商户id',
  `phone` char(20) NOT NULL COMMENT '电话',
  `createUserId` int(11) NOT NULL DEFAULT '0' COMMENT '创建人id',
  `loginErrorTimes` int(11) NOT NULL DEFAULT '0' COMMENT '登录错误次数',
  `passwordExpiration` tinyint(4) NOT NULL DEFAULT '0' COMMENT '开启密码过期 0否 1是',
  `modifyPasswordTime` int(10) UNSIGNED DEFAULT NULL COMMENT '修改密码时间',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1正常 0封禁'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='商户用户表';

-- --------------------------------------------------------

--
-- 表的结构 `cmf_company_user_role`
--

CREATE TABLE `cmf_company_user_role` (
  `id` int(11) NOT NULL,
  `name` char(20) NOT NULL COMMENT '角色名称',
  `companyId` int(11) NOT NULL COMMENT '商户id',
  `menuId` text NOT NULL COMMENT '能使用的功能id',
  `createTime` int(10) UNSIGNED NOT NULL COMMENT '创建时间',
  `createUserId` int(11) NOT NULL COMMENT '创建人id',
  `modifyUserId` int(11) DEFAULT NULL COMMENT '修改人id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='商户用户角色表';

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
-- Indexes for table `cmf_common_menu`
--
ALTER TABLE `cmf_common_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cmf_company`
--
ALTER TABLE `cmf_company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cmf_company_user`
--
ALTER TABLE `cmf_company_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `account` (`account`);

--
-- Indexes for table `cmf_company_user_role`
--
ALTER TABLE `cmf_company_user_role`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `cmf_common_apps`
--
ALTER TABLE `cmf_common_apps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `cmf_common_menu`
--
ALTER TABLE `cmf_common_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `cmf_company`
--
ALTER TABLE `cmf_company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `cmf_company_user`
--
ALTER TABLE `cmf_company_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `cmf_company_user_role`
--
ALTER TABLE `cmf_company_user_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
