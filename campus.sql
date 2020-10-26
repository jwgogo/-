/*
 Navicat Premium Data Transfer

 Source Server         : 个人
 Source Server Type    : MariaDB
 Source Server Version : 100032
 Source Host           : localhost:3306
 Source Schema         : campus

 Target Server Type    : MariaDB
 Target Server Version : 100032
 File Encoding         : 65001

 Date: 10/05/2020 00:05:13
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for jw_admin
-- ----------------------------
DROP TABLE IF EXISTS `jw_admin`;
CREATE TABLE `jw_admin`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户名',
  `account` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '账号',
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '密码',
  `qq` int(12) NULL DEFAULT NULL COMMENT 'qq',
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '邮箱',
  `mobile` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '手机号',
  `mark` int(10) NULL DEFAULT 0 COMMENT '积分',
  `gold` int(10) NULL DEFAULT 0 COMMENT '金币',
  `is_del` int(1) NULL DEFAULT 1 COMMENT '是否拉黑 1 未拉黑  2拉黑',
  `addtime` int(10) NULL DEFAULT NULL COMMENT '注册时间',
  `lasttime` int(10) NULL DEFAULT NULL COMMENT '更新时间',
  `first_ip` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '注册IP',
  `last_ip` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '最后一次IP',
  `role` int(255) NULL DEFAULT NULL COMMENT '权限ID',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 16 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '后台管理员\r\n' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of jw_admin
-- ----------------------------
INSERT INTO `jw_admin` VALUES (11, '渐悟代码', 'jwcode', 'jw774627c6b64360d7205910c929ff07b8', NULL, '123456@qq.com', NULL, 0, 0, 1, 1568312800, 1589031787, '61.140.239.240', '14.103.171.214', 6);
INSERT INTO `jw_admin` VALUES (14, '学生管理测试用户', 'jwtest', 'jw0a28f42f1d902c91be058ca75925fc9b', NULL, 'jwtest2@qq.com', NULL, 0, 0, 1, 1584802148, 1588055708, '113.109.110.5', '175.3.176.27', 7);
INSERT INTO `jw_admin` VALUES (15, '来访用户', 'sAdmin', 'jw2aa72ea3adbcd74d86c67562cc1b0026', NULL, 'sAdmin@qq.com', NULL, 0, 0, 1, 1584802305, 1589033992, '61.144.158.121', '223.74.66.155', 6);

-- ----------------------------
-- Table structure for jw_attendance
-- ----------------------------
DROP TABLE IF EXISTS `jw_attendance`;
CREATE TABLE `jw_attendance`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `amtime1` time(0) NULL DEFAULT NULL COMMENT '上午上学',
  `amtime2` int(10) NULL DEFAULT NULL,
  `amtime3` time(0) NULL DEFAULT NULL COMMENT '上午放学',
  `amtime4` int(10) NULL DEFAULT NULL,
  `pmtime1` time(0) NULL DEFAULT NULL COMMENT '下午上学',
  `pmtime2` int(11) NULL DEFAULT NULL,
  `pmtime3` time(0) NULL DEFAULT NULL COMMENT '下午放学',
  `pmtime4` int(11) NULL DEFAULT NULL,
  `ngtime1` time(0) NULL DEFAULT NULL COMMENT '晚上上学',
  `ngtime2` int(11) NULL DEFAULT NULL,
  `ngtime3` time(0) NULL DEFAULT NULL COMMENT '晚上放学',
  `ngtime4` int(11) NULL DEFAULT NULL,
  `grade_id` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '使用年级',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '考勤时间查询' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of jw_attendance
-- ----------------------------
INSERT INTO `jw_attendance` VALUES (3, '08:00:00', 10, '11:30:00', 10, '14:00:00', 10, '18:00:00', 10, '19:00:00', 10, '21:00:00', 10, '4');

-- ----------------------------
-- Table structure for jw_authority
-- ----------------------------
DROP TABLE IF EXISTS `jw_authority`;
CREATE TABLE `jw_authority`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grade` int(1) NOT NULL COMMENT '等级类别 0 为一级 其他为 二级',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '权限名称',
  `way` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '操作',
  `addtime` int(11) NULL DEFAULT NULL COMMENT '添加时间',
  `sort` int(10) NULL DEFAULT 999 COMMENT '排序',
  `display` int(1) NULL DEFAULT 1 COMMENT '是否目录 1是',
  `icon` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '&#xe6f2;' COMMENT '图标',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 80 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '权限管理' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of jw_authority
-- ----------------------------
INSERT INTO `jw_authority` VALUES (5, 0, '权限管理', NULL, NULL, 997, 1, '&#xe82b;');
INSERT INTO `jw_authority` VALUES (11, 19, '会员列表', '/admin/user/userList', NULL, 999, 1, '&#xe69d;');
INSERT INTO `jw_authority` VALUES (13, 19, '添加会员', '/admin/user/add', 1567697254, 999, 1, '&#xe69d;');
INSERT INTO `jw_authority` VALUES (14, 23, '管理员列表', '/admin/admin_User/adminlist', 1567697289, 999, 1, '&#xe69d;');
INSERT INTO `jw_authority` VALUES (15, 5, '角色管理', '/admin/role/index', 1567697972, 999, 1, '&#xe69d;');
INSERT INTO `jw_authority` VALUES (16, 5, '权限分类', '/admin/role/kind', 1567697985, 999, 1, '&#xe69d;');
INSERT INTO `jw_authority` VALUES (17, 5, '权限管理', '/admin/role/authority', 1567698000, 999, 1, '&#xe69d;');
INSERT INTO `jw_authority` VALUES (23, 0, '管理员', NULL, 1567746389, 999, 1, '&#xe726;');
INSERT INTO `jw_authority` VALUES (24, 0, '系统设置', NULL, 1567866631, 1000, 1, '&#xe6ae;');
INSERT INTO `jw_authority` VALUES (25, 24, 'SEO', '/admin/System/seo', 1567927101, 999, 1, '&#xe6f2;');
INSERT INTO `jw_authority` VALUES (26, 24, '网站信息', '/admin/System/website', 1567929269, 999, 1, '&#xe6f2;');
INSERT INTO `jw_authority` VALUES (27, 24, '邮箱配置', '/admin/System/email', 1567948700, 999, 1, '&#xe6f2;');
INSERT INTO `jw_authority` VALUES (28, 24, 'IP黑名单', '/admin/System/ip', 1567951797, 999, 1, '&#xe6f2;');
INSERT INTO `jw_authority` VALUES (29, 0, '系统统计', NULL, 1567953565, 900, 1, '&#xe6b3;');
INSERT INTO `jw_authority` VALUES (30, 29, '访问日志', 'admin/log/log', 1567957712, 999, 1, '&#xe6f2;');
INSERT INTO `jw_authority` VALUES (31, 0, '设备操作', NULL, 1584535163, 999, 1, '&#xe6b6;');
INSERT INTO `jw_authority` VALUES (32, 31, '设备列表', '/admin/Equipment/EquipmentList', 1584535206, 999, 1, '&#xe6f2;');
INSERT INTO `jw_authority` VALUES (33, 0, '年级/班级管理', NULL, 1584545323, 999, 1, '&#xe6a9;');
INSERT INTO `jw_authority` VALUES (34, 33, '列表', '/admin/Grade/GradeList', 1584545374, 999, 1, '&#xe6f2;');
INSERT INTO `jw_authority` VALUES (35, 0, '考勤时间管理', NULL, 1584630555, 999, 1, '&#xe713;');
INSERT INTO `jw_authority` VALUES (36, 35, '考勤时间列表', '/admin/Attendance/AttList', 1584630592, 999, 1, '&#xe6f2;');
INSERT INTO `jw_authority` VALUES (37, 33, '添加操作', '/admin/Grade/add', 1584630645, 999, 2, '&#xe6f2;');
INSERT INTO `jw_authority` VALUES (38, 33, '班级修改操作', '/admin/Grade/edit', 1584630669, 999, 2, '&#xe6f2;');
INSERT INTO `jw_authority` VALUES (39, 33, '班级删除操作', '/admin/Grade/del', 1584630692, 999, 2, '&#xe6f2;');
INSERT INTO `jw_authority` VALUES (40, 31, '设备添加', '/admin/Equipment/add', 1584630740, 999, 2, '&#xe6f2;');
INSERT INTO `jw_authority` VALUES (41, 31, '设备修改', '/admin/Equipment/edit', 1584630763, 999, 2, '&#xe6f2;');
INSERT INTO `jw_authority` VALUES (42, 31, '设备删除', '/admin/Equipment/del', 1584630780, 999, 2, '&#xe6f2;');
INSERT INTO `jw_authority` VALUES (43, 35, '考勤时间添加', '/admin/Attendance/add', 1584630862, 999, 2, '&#xe6f2;');
INSERT INTO `jw_authority` VALUES (44, 35, '考勤时间修改', '/admin/Attendance/edit', 1584630887, 999, 2, '&#xe6f2;');
INSERT INTO `jw_authority` VALUES (45, 35, '考勤时间删除', '/admin/Attendance/del', 1584630916, 999, 2, '&#xe6f2;');
INSERT INTO `jw_authority` VALUES (46, 0, '宿舍管理', NULL, 1584713648, 999, 1, '&#xe6da;');
INSERT INTO `jw_authority` VALUES (47, 46, '宿舍类别', '/admin/Dorm/Category', 1584713822, 999, 1, '&#xe6f2;');
INSERT INTO `jw_authority` VALUES (48, 46, '宿舍类别 添加', '/admin/Dorm/CategoryAdd', 1584713857, 999, 2, '&#xe6f2;');
INSERT INTO `jw_authority` VALUES (49, 46, '宿舍类别 修改', '/admin/Dorm/CategoryEdit', 1584713881, 999, 2, '&#xe6f2;');
INSERT INTO `jw_authority` VALUES (50, 46, '宿舍类别 删除', '/admin/Dorm/CategoryDel', 1584713898, 999, 2, '&#xe6f2;');
INSERT INTO `jw_authority` VALUES (51, 46, '宿舍楼栋', '/admin/Dorm/building', 1584713822, 999, 1, '&#xe6f2;');
INSERT INTO `jw_authority` VALUES (52, 46, '宿舍楼栋 添加', '/admin/Dorm/buildAdd', 1584713857, 999, 2, '&#xe6f2;');
INSERT INTO `jw_authority` VALUES (53, 46, '宿舍楼栋 修改', '/admin/Dorm/buildEdit', 1584713881, 999, 2, '&#xe6f2;');
INSERT INTO `jw_authority` VALUES (54, 46, '宿舍楼栋 删除', '/admin/Dorm/buildDel', 1584713898, 999, 2, '&#xe6f2;');
INSERT INTO `jw_authority` VALUES (55, 46, '宿舍列表', '/admin/Dorm/dormList', 1584713822, 999, 1, '&#xe6f2;');
INSERT INTO `jw_authority` VALUES (56, 46, '宿舍 添加', '/admin/Dorm/dormAdd', 1584713857, 999, 2, '&#xe6f2;');
INSERT INTO `jw_authority` VALUES (57, 46, '宿舍 修改', '/admin/Dorm/dormEdit', 1584713881, 999, 2, '&#xe6f2;');
INSERT INTO `jw_authority` VALUES (58, 46, '宿舍 删除', '/admin/Dorm/dormDel', 1584713898, 999, 2, '&#xe6f2;');
INSERT INTO `jw_authority` VALUES (59, 0, '报表管理', NULL, 1584718631, 999, 1, '&#xe6a2;');
INSERT INTO `jw_authority` VALUES (60, 59, '考勤', '/admin/Report/attendance', 1584718661, 999, 2, '&#xe6f2;');
INSERT INTO `jw_authority` VALUES (61, 59, '人脸识别明细', '/admin/Report/details', 1584718911, 999, 1, '&#xe6f2;');
INSERT INTO `jw_authority` VALUES (62, 59, '宿舍打卡', '/admin/Report/dorm', 1584718931, 999, 2, '&#xe6f2;');
INSERT INTO `jw_authority` VALUES (63, 0, '师生管理', NULL, 1584767368, 999, 1, '&#xe6b8;');
INSERT INTO `jw_authority` VALUES (64, 63, '师生列表', '/admin/Students/lists', 1584767397, 999, 1, '&#xe6f2;');
INSERT INTO `jw_authority` VALUES (65, 0, '请假管理', NULL, 1584799403, 999, 1, '&#xe724;');
INSERT INTO `jw_authority` VALUES (66, 65, '请假列表', '/admin/Leave/lists', 1584799429, 999, 1, '&#xe6f2;');
INSERT INTO `jw_authority` VALUES (67, 65, '请假添加', '/admin/Leave/add', 1584801412, 999, 2, '&#xe6f2;');
INSERT INTO `jw_authority` VALUES (68, 65, '请假修改', '/admin/Leave/edit', 1584801431, 999, 2, '&#xe6f2;');
INSERT INTO `jw_authority` VALUES (69, 65, '请假删除', '/admin/Leave/edit', 1584801459, 999, 2, '&#xe6f2;');
INSERT INTO `jw_authority` VALUES (70, 63, '学生添加', '/admin/Students/add', 1584767397, 999, 2, '&#xe6f2;');
INSERT INTO `jw_authority` VALUES (71, 63, '学生修改', '/admin/Students/edit', 1584767397, 999, 2, '&#xe6f2;');
INSERT INTO `jw_authority` VALUES (72, 63, '学生删除', '/admin/Students/del', 1584767397, 999, 2, '&#xe6f2;');
INSERT INTO `jw_authority` VALUES (73, 63, '学生批量删除', '/admin/Students/delAll', 1584767397, 999, 2, '&#xe6f2;');
INSERT INTO `jw_authority` VALUES (74, 63, '学生照片上传', '/admin/Students/setfile', 1584767397, 999, 2, '&#xe6f2;');
INSERT INTO `jw_authority` VALUES (75, 23, '管理员添加', '/admin/admin_User/add', 1584801725, 999, 2, '&#xe6f2;');
INSERT INTO `jw_authority` VALUES (76, 23, '管理员修改', '/admin/admin_User/edit', 1584801737, 999, 2, '&#xe6f2;');
INSERT INTO `jw_authority` VALUES (77, 23, '管理员删除', '/admin/admin_User/del', 1584801746, 999, 2, '&#xe6f2;');
INSERT INTO `jw_authority` VALUES (78, 23, '管理员状态', '/admin/admin_User/state', 1584801755, 999, 2, '&#xe6f2;');
INSERT INTO `jw_authority` VALUES (79, 24, 'WebSocket', '/admin/System/websocket', 1588484255, 999, 1, '&#xe6f2;');

-- ----------------------------
-- Table structure for jw_berth
-- ----------------------------
DROP TABLE IF EXISTS `jw_berth`;
CREATE TABLE `jw_berth`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `d_id` int(11) NULL DEFAULT NULL COMMENT '宿舍id',
  `bed` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '床位',
  `s_id` int(11) NULL DEFAULT NULL COMMENT '学生ID',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '床位管理' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for jw_building
-- ----------------------------
DROP TABLE IF EXISTS `jw_building`;
CREATE TABLE `jw_building`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `b_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '宿舍楼栋名称',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '宿舍楼栋' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of jw_building
-- ----------------------------
INSERT INTO `jw_building` VALUES (1, '1号楼2');
INSERT INTO `jw_building` VALUES (2, '2号楼');

-- ----------------------------
-- Table structure for jw_category
-- ----------------------------
DROP TABLE IF EXISTS `jw_category`;
CREATE TABLE `jw_category`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `c_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '宿舍类别名称',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '宿舍类别' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of jw_category
-- ----------------------------
INSERT INTO `jw_category` VALUES (1, '男生宿舍');
INSERT INTO `jw_category` VALUES (2, '女生宿舍');
INSERT INTO `jw_category` VALUES (3, '女老师宿舍');

-- ----------------------------
-- Table structure for jw_dorm
-- ----------------------------
DROP TABLE IF EXISTS `jw_dorm`;
CREATE TABLE `jw_dorm`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `d_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '宿舍名称',
  `d_tier` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '第几层',
  `b_id` int(3) NULL DEFAULT NULL COMMENT '宿舍楼栋id',
  `c_id` int(11) NULL DEFAULT NULL COMMENT '宿舍类别id',
  `bed` int(255) NULL DEFAULT NULL COMMENT '床位数量',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '宿舍列表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of jw_dorm
-- ----------------------------
INSERT INTO `jw_dorm` VALUES (7, '1', '1', 1, 1, 1);
INSERT INTO `jw_dorm` VALUES (8, '2', '2', 1, 1, 2);
INSERT INTO `jw_dorm` VALUES (9, '3', '3', 1, 1, 3);

-- ----------------------------
-- Table structure for jw_equipment
-- ----------------------------
DROP TABLE IF EXISTS `jw_equipment`;
CREATE TABLE `jw_equipment`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '设备号',
  `device` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '设备ID',
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '设备名称',
  `site` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '设备位置',
  `state` int(1) NOT NULL DEFAULT 2 COMMENT '设备状态 1在线  2离线',
  `addtime` datetime(0) NULL DEFAULT NULL COMMENT '添加时间',
  `uptime` datetime(0) NULL DEFAULT NULL COMMENT '更新时间',
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '设备类型',
  `signin` int(2) NULL DEFAULT NULL COMMENT '是否为考勤机 1 考勤机 2普通',
  `turnover` int(255) NULL DEFAULT NULL COMMENT '1进 2出',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '设备' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of jw_equipment
-- ----------------------------
INSERT INTO `jw_equipment` VALUES (3, '4', '192.168.1.6', '456789', '食堂', 1, '2020-05-04 15:42:48', '2020-05-07 16:28:38', '人脸识别_STD', 2, 2);
INSERT INTO `jw_equipment` VALUES (6, '1', '223.74.66.155', '5C03R080186', '宿舍', 1, '2020-05-05 12:25:48', '2020-05-09 23:50:40', '人脸识别_STD', 1, 2);
INSERT INTO `jw_equipment` VALUES (7, '2', '192.168.0.100', 'KSDHKSK', '图书馆', 1, '2020-05-05 12:36:43', '2020-05-07 16:57:13', '人脸识别_STD', 1, 1);
INSERT INTO `jw_equipment` VALUES (9, '3', '223.74.66.155', 'asdasdad', '锅楼房', 1, '2020-05-09 23:50:57', '2020-05-09 23:51:29', '人脸识别_STD', 2, 1);

-- ----------------------------
-- Table structure for jw_face_information
-- ----------------------------
DROP TABLE IF EXISTS `jw_face_information`;
CREATE TABLE `jw_face_information`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sid` int(11) NULL DEFAULT NULL COMMENT '人员ID',
  `picture` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT 'base64照片',
  `addtime` datetime(0) NULL DEFAULT NULL COMMENT '添加时间',
  `serial_no` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '序列号',
  `type` int(5) NULL DEFAULT 99999 COMMENT '1 早上打卡 2 中午放学 3下午上学 4下午放学 5晚上上学 6晚上放学  99999其他',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `sid`(`sid`, `serial_no`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 24 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '人脸识别信息' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of jw_face_information
-- ----------------------------
INSERT INTO `jw_face_information` VALUES (3, 29, NULL, '2020-05-05 13:39:00', '5C03R080186', 99999);
INSERT INTO `jw_face_information` VALUES (4, 29, NULL, '2020-05-06 13:41:30', '5C03R080186', 99999);
INSERT INTO `jw_face_information` VALUES (6, 30, NULL, '2020-05-07 20:58:45', '5C03R080186', 99999);
INSERT INTO `jw_face_information` VALUES (7, 30, NULL, '2020-05-07 21:06:51', '5C03R080186', 99999);
INSERT INTO `jw_face_information` VALUES (8, 1, NULL, '2020-05-07 21:11:20', '5C03R080186', 6);
INSERT INTO `jw_face_information` VALUES (9, 1, NULL, '2020-05-07 21:11:22', '5C03R080186', 99999);
INSERT INTO `jw_face_information` VALUES (10, 1, NULL, '2020-05-07 21:11:23', '5C03R080186', 99999);
INSERT INTO `jw_face_information` VALUES (11, 1, NULL, '2020-05-07 22:56:51', '5C03R080186', 99999);
INSERT INTO `jw_face_information` VALUES (13, 1, NULL, '2020-05-08 19:21:29', '5C03R080186', 99999);
INSERT INTO `jw_face_information` VALUES (14, 1, NULL, '2020-05-08 20:55:59', '5C03R080186', 99999);
INSERT INTO `jw_face_information` VALUES (15, 1, NULL, '2020-05-08 23:43:19', '5C03R080186', 6);
INSERT INTO `jw_face_information` VALUES (16, 1, NULL, '2020-05-09 16:09:43', '5C03R080186', 1);
INSERT INTO `jw_face_information` VALUES (17, 1, NULL, '2020-05-09 19:07:55', '5C03R080186', 5);
INSERT INTO `jw_face_information` VALUES (18, 1, NULL, '2020-05-09 19:09:09', '5C03R080186', 99999);
INSERT INTO `jw_face_information` VALUES (19, 1, NULL, '2020-05-09 19:09:41', '5C03R080186', 99999);
INSERT INTO `jw_face_information` VALUES (20, 0, NULL, '2020-05-09 19:14:33', '5C03R080186', 99999);
INSERT INTO `jw_face_information` VALUES (21, 0, NULL, '2020-05-09 19:14:34', '5C03R080186', 99999);
INSERT INTO `jw_face_information` VALUES (22, 0, NULL, '2020-05-09 19:14:35', '5C03R080186', 99999);
INSERT INTO `jw_face_information` VALUES (23, 0, NULL, '2020-05-09 23:36:07', '5C03R080186', 99999);

-- ----------------------------
-- Table structure for jw_grade
-- ----------------------------
DROP TABLE IF EXISTS `jw_grade`;
CREATE TABLE `jw_grade`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(1) NULL DEFAULT NULL COMMENT '类型 1班级 2年级',
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '名称',
  `addtime` datetime(0) NULL DEFAULT NULL COMMENT '添加时间',
  `uptime` datetime(0) NULL DEFAULT NULL COMMENT '更新时间',
  `time_id` int(11) NULL DEFAULT 0 COMMENT '考勤时间设置',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '班级年级' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of jw_grade
-- ----------------------------
INSERT INTO `jw_grade` VALUES (4, 2, '19级高一', '2020-03-19 22:51:29', '2020-03-19 22:51:29', 3);
INSERT INTO `jw_grade` VALUES (5, 2, '19级高二', '2020-03-19 22:51:36', '2020-03-19 22:51:36', 0);
INSERT INTO `jw_grade` VALUES (6, 2, '19级高三', '2020-03-19 22:51:42', '2020-03-19 22:51:42', 0);
INSERT INTO `jw_grade` VALUES (8, 1, '19级高一(1)班', '2020-03-19 22:51:57', '2020-03-19 22:51:57', 0);
INSERT INTO `jw_grade` VALUES (9, 1, '19级高一(2)班', '2020-03-19 22:52:02', '2020-03-19 22:52:02', 0);
INSERT INTO `jw_grade` VALUES (10, 1, '19级高一(4)班', '2020-03-19 22:52:07', '2020-03-19 22:52:07', 0);
INSERT INTO `jw_grade` VALUES (11, 1, '19级高一(3)班', '2020-03-19 22:52:12', '2020-03-19 22:52:12', 0);

-- ----------------------------
-- Table structure for jw_ip_black
-- ----------------------------
DROP TABLE IF EXISTS `jw_ip_black`;
CREATE TABLE `jw_ip_black`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `info` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '说明',
  `addtime` int(11) NULL DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = 'IP黑名单' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of jw_ip_black
-- ----------------------------
INSERT INTO `jw_ip_black` VALUES (4, '192.3.3.2', NULL, 1567953364);
INSERT INTO `jw_ip_black` VALUES (5, '192.168.0.0', NULL, 1567953465);
INSERT INTO `jw_ip_black` VALUES (7, '127.0.0.12', 'log日志拉黑', 1568036550);

-- ----------------------------
-- Table structure for jw_leave
-- ----------------------------
DROP TABLE IF EXISTS `jw_leave`;
CREATE TABLE `jw_leave`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `s_id` int(11) NULL DEFAULT NULL COMMENT '学生ID',
  `start` datetime(0) NULL DEFAULT NULL COMMENT '开始时间',
  `end` datetime(0) NULL DEFAULT NULL COMMENT '结束时间',
  `type` int(1) NULL DEFAULT NULL COMMENT '请假类型 1请假 2休学',
  `mark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '备注',
  `sell` int(1) NULL DEFAULT 2 COMMENT '是否销假 1销假 2请假',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of jw_leave
-- ----------------------------
INSERT INTO `jw_leave` VALUES (3, 29, '2020-03-21 00:00:00', '2020-03-28 00:00:00', 1, '123123', 2);
INSERT INTO `jw_leave` VALUES (4, 18, '2020-03-21 00:00:00', '2020-03-31 00:00:00', 2, '12313', 2);

-- ----------------------------
-- Table structure for jw_log
-- ----------------------------
DROP TABLE IF EXISTS `jw_log`;
CREATE TABLE `jw_log`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(10) NULL DEFAULT NULL COMMENT '用户ID',
  `account` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '账号',
  `domain` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '请求地址',
  `param` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '请求参数',
  `method` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '请求类型',
  `type` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '资源类型',
  `time` int(11) NOT NULL COMMENT '请求时间',
  `ip` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'IP',
  `host` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '主机名（含端口）',
  `getInput` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '流信息',
  `header` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '请求头',
  `agent` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '是否蜘蛛',
  `referer` int(1) NULL DEFAULT NULL COMMENT '外联',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for jw_role
-- ----------------------------
DROP TABLE IF EXISTS `jw_role`;
CREATE TABLE `jw_role`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(12) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '角色名称',
  `role` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '权限列表',
  `state` int(1) NULL DEFAULT NULL COMMENT '1 启用 2关闭',
  `addtime` int(11) NULL DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '角色管理' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of jw_role
-- ----------------------------
INSERT INTO `jw_role` VALUES (6, '超级管理员', '15,16,17,14,75,76,77,78,25,26,27,28,79,30,32,40,41,42,34,37,38,39,36,43,44,45,47,48,49,50,51,52,53,54,55,56,57,58,60,61,62,64,70,71,72,73,74,66,67,68,69', 1, 1588741516);
INSERT INTO `jw_role` VALUES (7, '一般', '15,14,32,34,36,47,51,55,60,61,62,64,66', 1, 1584802106);

-- ----------------------------
-- Table structure for jw_session
-- ----------------------------
DROP TABLE IF EXISTS `jw_session`;
CREATE TABLE `jw_session`  (
  `admin_id` int(11) NOT NULL COMMENT '后台用户id',
  `user_id` int(11) NULL DEFAULT NULL COMMENT '前台用户id',
  `val` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `deltime` int(10) NULL DEFAULT NULL COMMENT '失效时间'
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '用户session' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of jw_session
-- ----------------------------
INSERT INTO `jw_session` VALUES (1, NULL, 'jw315cf4fe67aa207399140bdb4a60028a', 1568312998);
INSERT INTO `jw_session` VALUES (11, NULL, 'jw05f7e31e3da28a9cb25333c8bf0faa1f', 1589118187);
INSERT INTO `jw_session` VALUES (12, NULL, 'jw5fb8c38c9f667c88c67a0ee39496644b', 1568375452);
INSERT INTO `jw_session` VALUES (14, NULL, 'jw00c4f1bd018f44bcadcd2a3e8e0ec26d', 1588142108);
INSERT INTO `jw_session` VALUES (15, NULL, 'jw6ba6e0e5aa609303b36b75067dd315ca', 1589120392);

-- ----------------------------
-- Table structure for jw_student
-- ----------------------------
DROP TABLE IF EXISTS `jw_student`;
CREATE TABLE `jw_student`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grade_id` int(11) NULL DEFAULT NULL COMMENT '年级',
  `class_id` int(11) NULL DEFAULT NULL COMMENT '班级',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '姓名',
  `school` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '学号',
  `card` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '卡号',
  `type` int(1) NULL DEFAULT NULL COMMENT '类型  1走读 2住校 3午休',
  `note` int(1) NULL DEFAULT 2 COMMENT '短信推送 1推送 2不推送',
  `sex` int(1) NULL DEFAULT 3 COMMENT '1男 2女 3未知',
  `site` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '家庭地址',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '备注',
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '学生照片',
  `mobile` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '家长手机号',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 30 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '学生表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of jw_student
-- ----------------------------
INSERT INTO `jw_student` VALUES (1, 4, 8, '张贤胜', 'q23123', '2312', 3, 1, 1, '大门口', NULL, '/uploads/images/1849428241247.jpg', '15033332222');
INSERT INTO `jw_student` VALUES (2, 4, 8, '赵丽颖', '123123', '231313', 2, 2, 2, '学习', '6666', '/uploads/images/11036192873899.jpg', '15033332222');
INSERT INTO `jw_student` VALUES (18, 4, 8, '赵丽颖3', '123123', '231313', 2, 2, 2, '学习', '6666', '/uploads/images/11609769776950.jpg', '15033332222');
INSERT INTO `jw_student` VALUES (29, 4, 11, '赵丽颖2', '1111111111', '22222222222', 1, 2, 2, '学习222', '6666111', '/uploads/images/12037171905227.jpg', '150333311111');

-- ----------------------------
-- Table structure for jw_system
-- ----------------------------
DROP TABLE IF EXISTS `jw_system`;
CREATE TABLE `jw_system`  (
  `title` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '名称',
  `json` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'json 设置'
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '系统设置' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of jw_system
-- ----------------------------
INSERT INTO `jw_system` VALUES ('seo', '{\"title\":\"\\u6e10\\u609f\\u4ee3\\u7801\",\"keyword\":\"\\u6e10\\u609f\\u4ee3\\u7801\",\"info\":\"\\u6e10\\u609f\\u4ee3\\u7801\"}');
INSERT INTO `jw_system` VALUES ('website', '{\"title\":\"\\u5b66\\u9662\\u7ba1\\u7406\",\"icp\":\"\\u7ca4ICP\\u590719038961\\u53f7-2\",\"security\":\"\\u7ca4ICP\\u590719038961\\u53f7-2\",\"email\":\"52367@163.com\"}');
INSERT INTO `jw_system` VALUES ('email', '{\"launch\":\"\\u6e10\\u609f\\u4ee3\\u7801\",\"site\":\"123\",\"host\":\"smtp.163.com\",\"account\":\"123\",\"pass\":\"12\"}');
INSERT INTO `jw_system` VALUES ('setup', '{\"enter\":\"24\",\"zip\":\"2\",\"image\":\"1\"}');
INSERT INTO `jw_system` VALUES ('websocket', '{\"pid\":9492,\"ip\":\"62.234.73.235\",\"port\":\"3525\",\"status\":1,\"time\":\"2020-05-09 23:50:12\"}');

-- ----------------------------
-- Table structure for jw_user
-- ----------------------------
DROP TABLE IF EXISTS `jw_user`;
CREATE TABLE `jw_user`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户名',
  `account` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '账号',
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '密码',
  `qq` int(12) NULL DEFAULT NULL COMMENT 'qq',
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '邮箱',
  `mobile` int(11) NULL DEFAULT NULL COMMENT '手机号',
  `mark` int(10) NULL DEFAULT 0 COMMENT '积分',
  `gold` int(10) NULL DEFAULT 0 COMMENT '金币',
  `is_del` int(1) NULL DEFAULT 1 COMMENT '是否拉黑 1 未拉黑  2拉黑',
  `addtime` int(10) NULL DEFAULT NULL COMMENT '注册时间',
  `lasttime` int(10) NULL DEFAULT NULL COMMENT '更新时间',
  `first_ip` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '注册IP',
  `last_ip` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '最后一次IP',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 21 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '前台用户' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of jw_user
-- ----------------------------
INSERT INTO `jw_user` VALUES (4, '张三4', 'zhangsan', '123456', 123456, '123456@qq.com', 123456, 0, 0, 2, 456, 789, '127.0.0.1', '127.0.0.1');
INSERT INTO `jw_user` VALUES (5, '张三5', 'zhangsan', '123456', 123456, '123456@qq.com', 123456, 0, 0, 1, 456, 789, '127.0.0.1', '127.0.0.1');
INSERT INTO `jw_user` VALUES (6, '张三6', 'zhangsan', '123456', 123456, '123456@qq.com', 123456, 0, 0, 1, 456, 789, '127.0.0.1', '127.0.0.1');
INSERT INTO `jw_user` VALUES (7, '张三7', 'zhangsan', '123456', 123456, '123456@qq.com', 123456, 0, 0, 1, 456, 789, '127.0.0.1', '127.0.0.1');
INSERT INTO `jw_user` VALUES (8, '张三8', 'zhangsan', '123456', 123456, '123456@qq.com', 123456, 0, 0, 1, 456, 789, '127.0.0.1', '127.0.0.1');
INSERT INTO `jw_user` VALUES (9, '张三9', 'zhangsan', '123456', 123456, '123456@qq.com', 123456, 0, 0, 1, 456, 789, '127.0.0.1', '127.0.0.1');
INSERT INTO `jw_user` VALUES (10, '张三10', 'zhangsan', 'jwa0202b5829dc2c2d949683bf791eb26b', 123132, '123456@qq.com', 123456, 0, 0, 1, 456, 789, '127.0.0.1', '127.0.0.1');
INSERT INTO `jw_user` VALUES (12, '张三12', 'zhangsan', '123456', 123456, '123456@qq.com', 123456, 0, 0, 2, 456, 789, '127.0.0.1', '127.0.0.1');
INSERT INTO `jw_user` VALUES (13, '张三13', 'zhangsan', '123456', 123456, '123456@qq.com', 123456, 0, 0, 2, 456, 789, '127.0.0.1', '127.0.0.1');
INSERT INTO `jw_user` VALUES (14, '张三14', 'zhangsan', '123456', 123456, '123456@qq.com', 123456, 0, 0, 2, 456, 789, '127.0.0.1', '127.0.0.1');
INSERT INTO `jw_user` VALUES (16, '张三16', 'zhangsan', '123456', 123456, '123456@qq.com', 123456, 0, 0, 2, 456, 789, '127.0.0.1', '127.0.0.1');
INSERT INTO `jw_user` VALUES (17, '张三17', 'zhangsan', '123456', 123456, '123456@qq.com', 123456, 0, 0, 2, 456, 789, '127.0.0.1', '127.0.0.1');
INSERT INTO `jw_user` VALUES (18, '张三18', 'zhangsan', '123456', 123456, '123456@qq.com', 123456, 0, 0, 2, 456, 789, '127.0.0.1', '127.0.0.1');
INSERT INTO `jw_user` VALUES (19, '张三19', 'zhangsan', '123456', 123456, '123456@qq.com', 123456, 0, 0, 2, 456, 789, '127.0.0.1', '127.0.0.1');
INSERT INTO `jw_user` VALUES (20, '张三19', 'zhangsan', '123456', 123456, '123456@qq.com', 123456, 0, 0, 1, 456, 789, '127.0.0.1', '127.0.0.1');

SET FOREIGN_KEY_CHECKS = 1;
