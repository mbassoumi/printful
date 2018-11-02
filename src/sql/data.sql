/*
 Navicat Premium Data Transfer

 Source Server         : local
 Source Server Type    : MySQL
 Source Server Version : 50723
 Source Host           : localhost:3306
 Source Schema         : printful_2

 Target Server Type    : MySQL
 Target Server Version : 50723
 File Encoding         : 65001

 Date: 02/11/2018 16:04:40
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for answers
-- ----------------------------
DROP TABLE IF EXISTS `answers`;
CREATE TABLE `answers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `question_id` int(10) unsigned NOT NULL,
  `option_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `answers_user_id_question_id_unique` (`user_id`,`question_id`),
  KEY `answers_question_id_foreign` (`question_id`),
  KEY `answers_option_id_foreign` (`option_id`),
  CONSTRAINT `answers_option_id_foreign` FOREIGN KEY (`option_id`) REFERENCES `options` (`id`) ON DELETE CASCADE,
  CONSTRAINT `answers_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `answers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of answers
-- ----------------------------
BEGIN;
INSERT INTO `answers` VALUES (1, 1, 1, 1);
INSERT INTO `answers` VALUES (2, 1, 2, 6);
INSERT INTO `answers` VALUES (3, 1, 3, 10);
INSERT INTO `answers` VALUES (4, 2, 6, 16);
COMMIT;

-- ----------------------------
-- Table structure for options
-- ----------------------------
DROP TABLE IF EXISTS `options`;
CREATE TABLE `options` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `question_id` int(10) unsigned NOT NULL,
  `mark` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `options_question_id_foreign` (`question_id`),
  CONSTRAINT `options_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of options
-- ----------------------------
BEGIN;
INSERT INTO `options` VALUES (1, '2', 1, 1);
INSERT INTO `options` VALUES (2, '10', 1, 0);
INSERT INTO `options` VALUES (3, '15', 1, 0);
INSERT INTO `options` VALUES (4, '20', 1, 0);
INSERT INTO `options` VALUES (5, '0', 1, 0);
INSERT INTO `options` VALUES (6, '0', 2, 0);
INSERT INTO `options` VALUES (7, '8', 2, 1);
INSERT INTO `options` VALUES (8, '22', 2, 0);
INSERT INTO `options` VALUES (9, '1', 3, 0);
INSERT INTO `options` VALUES (10, '7', 3, 1);
INSERT INTO `options` VALUES (11, '3', 3, 0);
INSERT INTO `options` VALUES (12, '6', 4, 1);
INSERT INTO `options` VALUES (13, '66', 4, 0);
INSERT INTO `options` VALUES (14, '626', 5, 0);
INSERT INTO `options` VALUES (15, '5', 5, 1);
INSERT INTO `options` VALUES (16, '5', 6, 1);
INSERT INTO `options` VALUES (17, '1', 6, 0);
INSERT INTO `options` VALUES (18, '32', 6, 0);
INSERT INTO `options` VALUES (19, '87', 6, 0);
INSERT INTO `options` VALUES (20, '66', 6, 0);
INSERT INTO `options` VALUES (21, 'NAN', 6, 0);
COMMIT;

-- ----------------------------
-- Table structure for questions
-- ----------------------------
DROP TABLE IF EXISTS `questions`;
CREATE TABLE `questions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quiz_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `questions_quiz_id_foreign` (`quiz_id`),
  CONSTRAINT `questions_quiz_id_foreign` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of questions
-- ----------------------------
BEGIN;
INSERT INTO `questions` VALUES (1, '1+1 = ?', 1);
INSERT INTO `questions` VALUES (2, '2*4= ?', 1);
INSERT INTO `questions` VALUES (3, '1+6= ?', 1);
INSERT INTO `questions` VALUES (4, '2*3= ?', 2);
INSERT INTO `questions` VALUES (5, '2+3= ?', 2);
INSERT INTO `questions` VALUES (6, '10/2= ?', 3);
COMMIT;

-- ----------------------------
-- Table structure for quizzes
-- ----------------------------
DROP TABLE IF EXISTS `quizzes`;
CREATE TABLE `quizzes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of quizzes
-- ----------------------------
BEGIN;
INSERT INTO `quizzes` VALUES (1, 'test 1');
INSERT INTO `quizzes` VALUES (2, 'test 2');
INSERT INTO `quizzes` VALUES (3, 'test 3');
COMMIT;

-- ----------------------------
-- Table structure for results
-- ----------------------------
DROP TABLE IF EXISTS `results`;
CREATE TABLE `results` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `quiz_id` int(10) unsigned NOT NULL,
  `result` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `results_user_id_quiz_id_unique` (`user_id`,`quiz_id`),
  KEY `results_quiz_id_foreign` (`quiz_id`),
  CONSTRAINT `results_quiz_id_foreign` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `results_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of results
-- ----------------------------
BEGIN;
INSERT INTO `results` VALUES (1, 1, 1, 2);
INSERT INTO `results` VALUES (2, 2, 3, 1);
COMMIT;

-- ----------------------------
-- Table structure for user_quiz
-- ----------------------------
DROP TABLE IF EXISTS `user_quiz`;
CREATE TABLE `user_quiz` (
  `user_id` int(10) unsigned NOT NULL,
  `quiz_id` int(10) unsigned NOT NULL,
  UNIQUE KEY `user_quiz_user_id_quiz_id_unique` (`user_id`,`quiz_id`),
  KEY `user_quiz_quiz_id_foreign` (`quiz_id`),
  CONSTRAINT `user_quiz_quiz_id_foreign` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user_quiz_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of user_quiz
-- ----------------------------
BEGIN;
INSERT INTO `user_quiz` VALUES (1, 1);
INSERT INTO `user_quiz` VALUES (2, 3);
COMMIT;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
BEGIN;
INSERT INTO `users` VALUES (1, 'majd');
INSERT INTO `users` VALUES (2, 'Basem');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
