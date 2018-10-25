-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2018-10-25 10:20:28
-- 服务器版本： 5.5.47
-- PHP Version: 7.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
-- 表的结构 `cmf_manage_apps`
--

CREATE TABLE `cmf_manage_apps` (
  `id` int(11) NOT NULL,
  `app` char(50) NOT NULL COMMENT '应用标识',
  `title` char(50) NOT NULL COMMENT '应用标题',
  `description` varchar(255) NOT NULL COMMENT '应用描述',
  `createTime` int(10) UNSIGNED NOT NULL COMMENT '创建时间',
  `entryUrl` varchar(255) DEFAULT NULL COMMENT '前台地址',
  `manageEntryUrl` varchar(255) DEFAULT NULL COMMENT '后台地址',
  `logo` varchar(255) NOT NULL COMMENT '图标地址',
  `sort` smallint(5) UNSIGNED NOT NULL COMMENT '排序号',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1正常 0删除',
  `logoColor` varchar(30) DEFAULT NULL COMMENT 'logo背景色'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='应用表';

--
-- 转存表中的数据 `cmf_manage_apps`
--

INSERT INTO `cmf_manage_apps` (`id`, `app`, `title`, `description`, `createTime`, `entryUrl`, `manageEntryUrl`, `logo`, `sort`, `status`, `logoColor`) VALUES
(1, 'manage', '后台管理', '应用后台管理，用户管理，商户管理等', 0, '', 'manage/apps/index', 'fa fa-gears', 1, 1, 'red'),
(2, 'content', '内容管理', '', 1540462755, '', '', 'fa fa-file-powerpoint-o', 2, 1, 'blue');

-- --------------------------------------------------------

--
-- 表的结构 `cmf_manage_company`
--

CREATE TABLE `cmf_manage_company` (
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
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1开放 0关闭',
  `typeId` int(11) NOT NULL COMMENT '类型id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='商户表';

--
-- 转存表中的数据 `cmf_manage_company`
--

INSERT INTO `cmf_manage_company` (`id`, `name`, `address`, `contact`, `phone`, `parentId`, `apps`, `createTime`, `createUserId`, `modifyUserId`, `status`, `typeId`) VALUES
(1, '系统后台商户', '', '李相江', '13333333333', 0, '', 0, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- 表的结构 `cmf_manage_companytype`
--

CREATE TABLE `cmf_manage_companytype` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL COMMENT '类型名称',
  `apps` varchar(255) NOT NULL COMMENT '可用应用id',
  `createTime` int(10) UNSIGNED NOT NULL COMMENT '创建时间',
  `createUserId` int(11) NOT NULL COMMENT '创建人'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商户类型表';

--
-- 转存表中的数据 `cmf_manage_companytype`
--

INSERT INTO `cmf_manage_companytype` (`id`, `name`, `apps`, `createTime`, `createUserId`) VALUES
(1, '系统后台商户', '1', 1537864306, 1);

-- --------------------------------------------------------

--
-- 表的结构 `cmf_manage_menu`
--

CREATE TABLE `cmf_manage_menu` (
  `id` int(11) NOT NULL,
  `typeId` tinyint(4) NOT NULL COMMENT '1:菜单 2:操作',
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
  `askSure` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1操作询问',
  `requestType` tinyint(4) NOT NULL DEFAULT '0' COMMENT '请求类型',
  `param` varchar(30) DEFAULT NULL COMMENT '跳转带的参数',
  `field` varchar(30) DEFAULT NULL COMMENT '参数值所属字段'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='功能表';

--
-- 转存表中的数据 `cmf_manage_menu`
--

INSERT INTO `cmf_manage_menu` (`id`, `typeId`, `parentId`, `appId`, `title`, `app`, `controller`, `action`, `createTime`, `sort`, `className`, `status`, `askSure`, `requestType`, `param`, `field`) VALUES
(1, 1, 0, 1, '应用管理', 'manage', 'Apps', 'index', 0, 1, NULL, 1, 0, 0, NULL, NULL),
(2, 1, 0, 1, '商户管理', 'manage', 'Company', 'index', 0, 3, NULL, 1, 0, 0, NULL, NULL),
(3, 1, 0, 1, '功能菜单', 'manage', 'Apps', 'menu', 0, 2, NULL, 1, 0, 0, NULL, NULL),
(4, 1, 0, 1, '用户管理', 'manage', 'User', 'index', 1536999683, 4, '', 1, 0, 0, '', ''),
(5, 1, 0, 1, '角色管理', 'manage', 'User', 'role', 1537930684, 5, '', 1, 0, 0, '', ''),
(6, 3, 3, 1, '添加菜单', 'manage', 'Apps', 'addMenu', 1536490926, 1, 'layui-btn layui-btn-normal', 1, 0, 2, '', ''),
(7, 3, 1, 1, '添加应用', 'manage', 'apps', 'addApp', 1536491000, 1, 'layui-btn layui-btn-normal', 1, 0, 2, '', ''),
(8, 2, 1, 1, '编辑应用', 'manage', 'Apps', 'editApp', 1537952323, 1, 'layui-btn layui-btn-xs', 1, 0, 2, '', ''),
(9, 2, 3, 1, '编辑功能', 'manage', 'apps', 'editMenu', 1537952334, 1, 'layui-btn layui-btn-xs', 1, 0, 2, '', ''),
(10, 4, 0, 1, '根据appid获取菜单列表', 'manage', 'apps', 'getMenuByAppId', 1536486545, 0, '', 1, 0, 0, '', ''),
(11, 2, 1, 1, '删除应用', 'manage', 'Apps', 'delApp', 1540375982, 2, 'layui-btn layui-btn-xs layui-btn-danger', 0, 1, 3, '', ''),
(12, 3, 2, 1, '添加商户', 'manage', 'Company', 'addCompany', 1536998178, 1, 'layui-btn layui-btn-normal', 1, 0, 2, '', ''),
(13, 1, 0, 1, '商户类型', 'manage', 'Company', 'companyType', 1537863155, 3, '', 1, 0, 0, '', ''),
(14, 3, 13, 1, '添加类型', 'manage', 'Company', 'addCompanyType', 1537863371, 0, 'layui-btn layui-btn-normal', 1, 0, 2, '', ''),
(15, 2, 13, 1, '编辑商户类型', 'manage', 'Company', 'editCompanyType', 1537954436, 1, 'layui-btn layui-btn-xs', 1, 0, 2, '', ''),
(16, 2, 13, 1, '删除类型', 'manage', 'Company', 'delCompanyType', 1537863548, 2, 'layui-btn layui-btn-xs layui-btn-danger', 1, 1, 3, '', ''),
(17, 2, 2, 1, '编辑商户', 'manage', 'Company', 'editCompany', 1537954447, 1, 'layui-btn layui-btn-xs', 1, 0, 2, '', ''),
(18, 3, 5, 1, '添加角色', 'manage', 'User', 'addRole', 1537931694, 1, 'layui-btn layui-btn-normal', 1, 0, 2, '', ''),
(19, 2, 5, 1, '编辑角色', 'manage', 'User', 'editRole', 1537955085, 1, 'layui-btn layui-btn-xs', 1, 0, 2, '', ''),
(20, 3, 4, 1, '添加用户', 'manage', 'User', 'addUser', 1537957666, 1, 'layui-btn layui-btn-normal', 1, 0, 2, '', ''),
(21, 2, 4, 1, '编辑用户', 'manage', 'User', 'editUser', 1540203296, 1, 'layui-btn layui-btn-xs', 1, 0, 2, '', '');

-- --------------------------------------------------------

--
-- 表的结构 `cmf_manage_user`
--

CREATE TABLE `cmf_manage_user` (
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

--
-- 转存表中的数据 `cmf_manage_user`
--

INSERT INTO `cmf_manage_user` (`id`, `account`, `name`, `password`, `createTime`, `roleId`, `companyId`, `phone`, `createUserId`, `loginErrorTimes`, `passwordExpiration`, `modifyPasswordTime`, `status`) VALUES
(1, 'lxjez', '李相江', '462bf95cb00e1f620a8e1e7eab7f40cdb93701b5', 0, 1, 1, '', 1, 0, 0, NULL, 1),
(2, 'lxj1', '李相江', 'beb56db0352b1ecb4fa2552230525133457a882e', 1540258859, 2, 1, '', 1, 0, 0, NULL, 1);

-- --------------------------------------------------------

--
-- 表的结构 `cmf_manage_user_role`
--

CREATE TABLE `cmf_manage_user_role` (
  `id` int(11) NOT NULL,
  `name` char(20) NOT NULL COMMENT '角色名称',
  `companyId` int(11) NOT NULL COMMENT '商户id',
  `apps` varchar(255) NOT NULL COMMENT '可用appid',
  `menuId` text NOT NULL COMMENT '能使用的功能id',
  `createTime` int(10) UNSIGNED NOT NULL COMMENT '创建时间',
  `createUserId` int(11) NOT NULL COMMENT '创建人id',
  `modifyUserId` int(11) DEFAULT NULL COMMENT '修改人id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='商户用户角色表';

--
-- 转存表中的数据 `cmf_manage_user_role`
--

INSERT INTO `cmf_manage_user_role` (`id`, `name`, `companyId`, `apps`, `menuId`, `createTime`, `createUserId`, `modifyUserId`) VALUES
(1, '超级管理员', 1, '', '', 0, 1, NULL),
(2, '用户管理员', 0, '1', '4,5,18,19,20,21', 1540206628, 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cmf_manage_apps`
--
ALTER TABLE `cmf_manage_apps`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `app` (`app`);

--
-- Indexes for table `cmf_manage_company`
--
ALTER TABLE `cmf_manage_company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cmf_manage_companytype`
--
ALTER TABLE `cmf_manage_companytype`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cmf_manage_menu`
--
ALTER TABLE `cmf_manage_menu`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `app` (`app`,`controller`,`action`) USING BTREE;

--
-- Indexes for table `cmf_manage_user`
--
ALTER TABLE `cmf_manage_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `account` (`account`);

--
-- Indexes for table `cmf_manage_user_role`
--
ALTER TABLE `cmf_manage_user_role`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `cmf_manage_apps`
--
ALTER TABLE `cmf_manage_apps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- 使用表AUTO_INCREMENT `cmf_manage_company`
--
ALTER TABLE `cmf_manage_company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- 使用表AUTO_INCREMENT `cmf_manage_companytype`
--
ALTER TABLE `cmf_manage_companytype`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- 使用表AUTO_INCREMENT `cmf_manage_menu`
--
ALTER TABLE `cmf_manage_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- 使用表AUTO_INCREMENT `cmf_manage_user`
--
ALTER TABLE `cmf_manage_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- 使用表AUTO_INCREMENT `cmf_manage_user_role`
--
ALTER TABLE `cmf_manage_user_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
