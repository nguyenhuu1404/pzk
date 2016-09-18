/*
Navicat MySQL Data Transfer

Source Server         : db_local
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : studyenglish

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2016-09-18 16:48:09
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for pzk_admin
-- ----------------------------
DROP TABLE IF EXISTS `pzk_admin`;
CREATE TABLE `pzk_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(40) NOT NULL,
  `adminLevelId` int(11) NOT NULL,
  `password` varchar(80) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `creatorId` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `modifiedId` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pzk_admin
-- ----------------------------
INSERT INTO `pzk_admin` VALUES ('1', 'huunv', '1', '8cb370be700c2a53f884fd9eb8e5bc2c', '1', '0', '2016-09-17 11:27:31', '0000-00-00 00:00:00', '0', 'nguyenhuu140490@gmail.com');

-- ----------------------------
-- Table structure for pzk_admin_level
-- ----------------------------
DROP TABLE IF EXISTS `pzk_admin_level`;
CREATE TABLE `pzk_admin_level` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `level` varchar(55) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `creatorId` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `modifiedId` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pzk_admin_level
-- ----------------------------
INSERT INTO `pzk_admin_level` VALUES ('1', 'Administrator', '1', '0', '2016-09-17 11:41:00', '0000-00-00 00:00:00', '0');

-- ----------------------------
-- Table structure for pzk_admin_level_action
-- ----------------------------
DROP TABLE IF EXISTS `pzk_admin_level_action`;
CREATE TABLE `pzk_admin_level_action` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_level_id` int(11) NOT NULL,
  `admin_action` varchar(255) NOT NULL,
  `admin_level` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `params` varchar(255) NOT NULL,
  `action_type` varchar(255) NOT NULL,
  `software` tinyint(4) NOT NULL,
  `created` datetime NOT NULL,
  `createdId` int(11) NOT NULL,
  `modified` datetime NOT NULL,
  `modifiedId` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pzk_admin_level_action
-- ----------------------------
INSERT INTO `pzk_admin_level_action` VALUES ('1', '0', 'admin_privilege', 'Administrator', '0', '[]', 'edit', '1', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00', '0');

-- ----------------------------
-- Table structure for pzk_admin_log
-- ----------------------------
DROP TABLE IF EXISTS `pzk_admin_log`;
CREATE TABLE `pzk_admin_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `menu` varchar(255) NOT NULL,
  `admin_controller` varchar(255) NOT NULL,
  `actionType` varchar(255) NOT NULL,
  `brief` text NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pzk_admin_log
-- ----------------------------
INSERT INTO `pzk_admin_log` VALUES ('1', '1', '', 'admin_menu', 'add', 'huunv Thêm mới bản ghi: menu[name: Hệ thống][ordering: ][status: 1]', '2016-09-17 14:45:57');
INSERT INTO `pzk_admin_log` VALUES ('2', '1', '', 'admin_menu', 'add', 'huunv Thêm mới bản ghi: menu[name: Thêm menu][ordering: ][status: 1]', '2016-09-17 14:46:58');
INSERT INTO `pzk_admin_log` VALUES ('3', '1', '', 'admin_menu', 'add', 'huunv Thêm mới bản ghi: menu[name: Quản trị][ordering: ][status: 1]', '2016-09-17 14:47:56');
INSERT INTO `pzk_admin_log` VALUES ('4', '1', '', 'admin_menu', 'add', 'huunv Thêm mới bản ghi: menu[name: Bảng phân quyền][ordering: ][status: 1]', '2016-09-17 14:48:59');
INSERT INTO `pzk_admin_log` VALUES ('5', '1', '', 'admin_menu', 'add', 'huunv Thêm mới bản ghi: menu[name: User admin][ordering: ][status: 1]', '2016-09-17 16:52:25');
INSERT INTO `pzk_admin_log` VALUES ('6', '1', '', 'admin_menu', 'edit', 'huunv Sửa bản ghi: menu[name: User admin][ordering: ][status: 1] thành [name: User admin][ordering: ][status: 1]', '2016-09-17 20:58:03');
INSERT INTO `pzk_admin_log` VALUES ('7', '1', '', 'admin_menu', 'add', 'huunv Thêm mới bản ghi: menu[name: Phân quyền][ordering: ][status: 1]', '2016-09-17 21:08:37');
INSERT INTO `pzk_admin_log` VALUES ('8', '1', '', 'admin_menu', 'add', 'huunv Thêm mới bản ghi: menu[name: Quyền truy cập][ordering: ][status: 1]', '2016-09-17 21:09:18');
INSERT INTO `pzk_admin_log` VALUES ('9', '1', '', 'admin_menu', 'add', 'huunv Thêm mới bản ghi: menu[name: Cấu hình][ordering: ][status: 1]', '2016-09-17 21:22:48');
INSERT INTO `pzk_admin_log` VALUES ('10', '1', '', 'admin_menu', 'add', 'huunv Thêm mới bản ghi: menu[name: Themes][ordering: ][status: 1]', '2016-09-17 21:27:35');
INSERT INTO `pzk_admin_log` VALUES ('11', '1', '', 'admin_menu', 'add', 'huunv Thêm mới bản ghi: menu[name: Logs][ordering: ][status: 1]', '2016-09-17 21:33:05');

-- ----------------------------
-- Table structure for pzk_admin_menu
-- ----------------------------
DROP TABLE IF EXISTS `pzk_admin_menu`;
CREATE TABLE `pzk_admin_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(159) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `admin_controller` varchar(150) NOT NULL,
  `parent` int(11) NOT NULL,
  `ordering` int(11) NOT NULL,
  `software` int(11) NOT NULL,
  `parents` varchar(255) NOT NULL,
  `shortcut` int(11) NOT NULL,
  `thumbnail` varchar(255) NOT NULL,
  `createdId` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `modifiedId` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pzk_admin_menu
-- ----------------------------
INSERT INTO `pzk_admin_menu` VALUES ('1', 'Hệ thống', '1', '0_1474098309', '0', '0', '1', ',1,', '0', '', '0', '2016-09-17 14:45:57', '0000-00-00 00:00:00', '0');
INSERT INTO `pzk_admin_menu` VALUES ('2', 'Thêm menu', '1', 'admin_menu', '1', '0', '1', ',1,2,', '0', '', '0', '2016-09-17 14:46:57', '0000-00-00 00:00:00', '0');
INSERT INTO `pzk_admin_menu` VALUES ('3', 'Quản trị', '1', '0_1474098450', '1', '0', '1', ',1,3,', '0', '', '0', '2016-09-17 14:47:56', '0000-00-00 00:00:00', '0');
INSERT INTO `pzk_admin_menu` VALUES ('4', 'Bảng phân quyền', '1', 'admin_privilege', '3', '0', '1', ',1,3,4,', '0', '', '0', '2016-09-17 14:48:59', '0000-00-00 00:00:00', '0');
INSERT INTO `pzk_admin_menu` VALUES ('5', 'User admin', '1', 'admin_mod', '3', '0', '1', ',1,3,5,', '0', '', '0', '2016-09-17 16:52:25', '2016-09-17 20:58:03', '1');
INSERT INTO `pzk_admin_menu` VALUES ('6', 'Phân quyền', '1', 'admin_levelaction', '3', '0', '1', ',1,3,6,', '0', '', '0', '2016-09-17 21:08:37', '0000-00-00 00:00:00', '0');
INSERT INTO `pzk_admin_menu` VALUES ('7', 'Quyền truy cập', '1', 'admin_adminlevel', '3', '0', '1', ',1,3,7,', '0', '', '0', '2016-09-17 21:09:18', '0000-00-00 00:00:00', '0');
INSERT INTO `pzk_admin_menu` VALUES ('8', 'Cấu hình', '1', 'admin_config', '1', '0', '1', ',1,8,', '0', '', '0', '2016-09-17 21:22:48', '0000-00-00 00:00:00', '0');
INSERT INTO `pzk_admin_menu` VALUES ('9', 'Themes', '1', 'admin_themes', '1', '0', '1', ',1,9,', '0', '', '0', '2016-09-17 21:27:33', '0000-00-00 00:00:00', '0');
INSERT INTO `pzk_admin_menu` VALUES ('10', 'Logs', '1', 'admin_log', '1', '0', '1', ',1,10,', '0', '', '0', '2016-09-17 21:33:04', '0000-00-00 00:00:00', '0');

-- ----------------------------
-- Table structure for pzk_themes
-- ----------------------------
DROP TABLE IF EXISTS `pzk_themes`;
CREATE TABLE `pzk_themes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created` varchar(255) NOT NULL,
  `creatorId` int(11) NOT NULL,
  `modified` varchar(255) NOT NULL,
  `modifiedId` int(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL,
  `content` text NOT NULL,
  `software` int(11) NOT NULL,
  `global` int(11) NOT NULL,
  `sharedSoftwares` varchar(255) NOT NULL,
  `default` int(11) NOT NULL,
  `ordering` int(11) NOT NULL,
  `site` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pzk_themes
-- ----------------------------
