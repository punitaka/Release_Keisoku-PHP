-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: 2021 年 8 月 11 日 20:06
-- サーバのバージョン： 10.3.29-MariaDB-0+deb10u1
-- PHP Version: 7.3.29-1~deb10u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_kumikomi`
--
CREATE DATABASE IF NOT EXISTS `db_kumikomi` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `db_kumikomi`;

-- --------------------------------------------------------

--
-- テーブルの構造 `t_data1`
--
-- 作成日時： 2021 年 8 月 07 日 12:39
-- 最終更新： 2021 年 8 月 11 日 11:05
--

DROP TABLE IF EXISTS `t_data1`;
CREATE TABLE `t_data1` (
  `d_datetime` datetime NOT NULL COMMENT '計測日時',
  `v_YYYYMMDD` varchar(8) DEFAULT NULL COMMENT '計測日時(年月日)',
  `v_HHMISS` varchar(6) DEFAULT NULL COMMENT '計測日時(時分秒)',
  `d_temperature` double NOT NULL COMMENT '気温',
  `d_humidity` double NOT NULL COMMENT '湿度',
  `d_pressure` double NOT NULL COMMENT '気圧',
  `d_Illuminance` double NOT NULL COMMENT '照度',
  `v_memo` varchar(500) DEFAULT NULL COMMENT 'メモ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='計測データを格納する';

--
-- テーブルのリレーション `t_data1`:
--

-- --------------------------------------------------------

--
-- テーブルの構造 `t_data1_backup`
--
-- 作成日時： 2021 年 8 月 07 日 12:39
-- 最終更新： 2021 年 8 月 11 日 11:05
--

DROP TABLE IF EXISTS `t_data1_backup`;
CREATE TABLE `t_data1_backup` (
  `d_datetime` datetime NOT NULL COMMENT '計測日時',
  `v_YYYYMMDD` varchar(8) DEFAULT NULL COMMENT '計測日時(年月日)',
  `v_HHMISS` varchar(6) DEFAULT NULL COMMENT '計測日時(時分秒)',
  `d_temperature` double NOT NULL COMMENT '気温',
  `d_humidity` double NOT NULL COMMENT '湿度',
  `d_pressure` double NOT NULL COMMENT '気圧',
  `d_Illuminance` double NOT NULL COMMENT '照度',
  `v_memo` varchar(500) DEFAULT NULL COMMENT 'メモ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='t_data1テーブルのバックアップ';

--
-- テーブルのリレーション `t_data1_backup`:
--

-- --------------------------------------------------------

--
-- テーブルの構造 `t_summary_d`
--
-- 作成日時： 2021 年 8 月 11 日 11:04
--

DROP TABLE IF EXISTS `t_summary_d`;
CREATE TABLE `t_summary_d` (
  `v_YYYYMMDD` varchar(8) NOT NULL COMMENT '計測日時(年月日)',
  `d_a_temperature` double NOT NULL COMMENT '平均気温',
  `d_a_humidity` double NOT NULL COMMENT '平均湿度',
  `d_a_pressure` double NOT NULL COMMENT '平均気圧',
  `d_a_Illuminance` double NOT NULL COMMENT '平均照度',
  `v_memo` varchar(500) DEFAULT NULL COMMENT 'メモ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='集計データ(日)';

--
-- テーブルのリレーション `t_summary_d`:
--

-- --------------------------------------------------------

--
-- テーブルの構造 `t_summary_h`
--
-- 作成日時： 2021 年 8 月 07 日 11:21
-- 最終更新： 2021 年 8 月 11 日 11:05
--

DROP TABLE IF EXISTS `t_summary_h`;
CREATE TABLE `t_summary_h` (
  `v_YYYYMMDDHH` varchar(10) NOT NULL COMMENT '計測日時(年月日時)',
  `v_HH` varchar(2) NOT NULL COMMENT '計測日時(時)',
  `d_a_temperature` double NOT NULL COMMENT '平均気温',
  `d_a_humidity` double NOT NULL COMMENT '平均湿度',
  `d_a_pressure` double NOT NULL COMMENT '平均気圧',
  `d_a_Illuminance` double NOT NULL COMMENT '平均照度',
  `v_memo` varchar(500) DEFAULT NULL COMMENT 'メモ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='集計データ(時)';

--
-- テーブルのリレーション `t_summary_h`:
--

-- --------------------------------------------------------

--
-- テーブルの構造 `t_summary_m`
--
-- 作成日時： 2021 年 8 月 07 日 11:21
--

DROP TABLE IF EXISTS `t_summary_m`;
CREATE TABLE `t_summary_m` (
  `v_YYYYMM` varchar(6) NOT NULL COMMENT '計測日時(年月)',
  `d_a_temperature` double NOT NULL COMMENT '平均気温',
  `d_a_humidity` double NOT NULL COMMENT '平均湿度',
  `d_a_pressure` double NOT NULL COMMENT '平均気圧',
  `d_a_Illuminance` double NOT NULL COMMENT '平均照度',
  `v_memo` varchar(500) DEFAULT NULL COMMENT 'メモ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='集計データ(時)';

--
-- テーブルのリレーション `t_summary_m`:
--

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t_data1`
--
ALTER TABLE `t_data1`
  ADD PRIMARY KEY (`d_datetime`),
  ADD KEY `v_YYYYMMDD` (`v_YYYYMMDD`);

--
-- Indexes for table `t_data1_backup`
--
ALTER TABLE `t_data1_backup`
  ADD PRIMARY KEY (`d_datetime`),
  ADD KEY `v_YYYYMMDD` (`v_YYYYMMDD`);

--
-- Indexes for table `t_summary_d`
--
ALTER TABLE `t_summary_d`
  ADD PRIMARY KEY (`v_YYYYMMDD`);

--
-- Indexes for table `t_summary_h`
--
ALTER TABLE `t_summary_h`
  ADD PRIMARY KEY (`v_YYYYMMDDHH`);

--
-- Indexes for table `t_summary_m`
--
ALTER TABLE `t_summary_m`
  ADD PRIMARY KEY (`v_YYYYMM`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
