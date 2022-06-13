-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2022-06-13 22:05:44
-- サーバのバージョン： 10.4.24-MariaDB
-- PHP のバージョン: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `bkk`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL COMMENT 'コメントID',
  `user_id` int(11) DEFAULT NULL COMMENT 'ユーザーID',
  `post_id` int(11) NOT NULL,
  `body` varchar(255) DEFAULT NULL COMMENT 'コメント内容',
  `created_at` datetime NOT NULL COMMENT 'コメント作成日時',
  `updated_at` datetime DEFAULT NULL COMMENT 'コメント編集日時',
  `deleted_at` datetime DEFAULT NULL COMMENT 'コメント削除日時'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `post_id`, `body`, `created_at`, `updated_at`, `deleted_at`) VALUES
(7, 59, 8, 'fsdalf;adsk;lfdsjk;lfjklsajkf;ladsjk;l', '2022-06-07 12:33:44', '2022-06-07 12:33:44', NULL),
(8, 59, 8, 'fsdalf;adsk;lfdsjk;lfjklsajkf;ladsjk;l', '2022-06-07 12:34:26', '2022-06-07 12:34:26', NULL),
(9, 60, 12, 'ハーレーほんとにいいね！', '2022-06-07 13:57:20', '2022-06-07 13:57:20', NULL),
(10, 61, 12, 'ハーレーほんとにいいよね', '2022-06-07 14:37:27', '2022-06-07 14:37:27', NULL),
(11, 62, 15, 'ほんとにすごいよね！！！', '2022-06-07 14:48:03', '2022-06-07 14:48:03', NULL),
(12, 63, 15, '確かにすごいよね。', '2022-06-07 15:36:16', '2022-06-07 15:36:16', NULL),
(13, 63, 16, '酒井さんさすがです。', '2022-06-07 15:37:30', '2022-06-07 15:37:30', NULL),
(14, 64, 17, '私もそう思います！', '2022-06-07 15:48:03', '2022-06-07 15:48:03', NULL),
(15, 65, 17, '色々ありますよ！', '2022-06-07 16:11:30', '2022-06-07 16:11:30', NULL);

-- --------------------------------------------------------

--
-- テーブルの構造 `favorites`
--

CREATE TABLE `favorites` (
  `id` int(11) NOT NULL COMMENT 'いいねID',
  `post_id` int(11) NOT NULL COMMENT '投稿ID',
  `user_id` int(11) NOT NULL COMMENT 'いいね保存者ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `favorites`
--

INSERT INTO `favorites` (`id`, `post_id`, `user_id`) VALUES
(17, 12, 60),
(18, 13, 61),
(19, 12, 61),
(20, 15, 62),
(21, 16, 63),
(22, 17, 64),
(23, 17, 65);

-- --------------------------------------------------------

--
-- テーブルの構造 `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL COMMENT '投稿認識ID',
  `user_id` int(11) DEFAULT NULL COMMENT 'ユーザーID',
  `tag_id` int(11) NOT NULL COMMENT 'タグID',
  `body` varchar(255) NOT NULL COMMENT '投稿内容',
  `deleted_at` datetime DEFAULT NULL COMMENT '削除日時',
  `good` int(11) DEFAULT NULL COMMENT 'いいね',
  `created_at` datetime NOT NULL COMMENT '登録日時',
  `updated_at` datetime DEFAULT NULL COMMENT 'アップデート日時'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `tag_id`, `body`, `deleted_at`, `good`, `created_at`, `updated_at`) VALUES
(15, 62, 3, 'ヤマハすごいね', '2022-06-07 15:36:48', 1, '2022-06-07 14:47:36', '2022-06-07 14:47:36'),
(16, 63, 2, 'カワサキさすがです', '2022-06-07 15:45:36', 1, '2022-06-07 15:36:40', '2022-06-07 15:37:09'),
(17, 64, 1, 'ホンダのことについて教えてください！！！！！！', NULL, 2, '2022-06-07 15:47:10', '2022-06-07 15:47:27'),
(18, 65, 3, 'ヤマハ最高！', '2022-06-07 16:12:32', 0, '2022-06-07 16:11:04', '2022-06-07 16:11:04');

-- --------------------------------------------------------

--
-- テーブルの構造 `tags`
--

CREATE TABLE `tags` (
  `id` int(11) NOT NULL COMMENT 'タグ',
  `name` varchar(255) NOT NULL COMMENT 'タグの名前',
  `created_at` datetime NOT NULL COMMENT 'タグ作成日時',
  `updated_at` datetime DEFAULT NULL COMMENT 'タグ編集日時',
  `deleted_at` datetime DEFAULT NULL COMMENT 'タグ削除日時'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `tags`
--

INSERT INTO `tags` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'ホンダ', '2022-06-02 00:00:00', NULL, NULL),
(2, 'カワサキ', '2022-06-02 00:00:00', NULL, NULL),
(3, 'ヤマハ', '2022-06-02 00:00:00', NULL, NULL),
(4, 'スズキ', '2022-06-02 00:00:00', NULL, NULL),
(5, 'ハーレー', '2022-06-02 00:00:00', NULL, NULL);

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL COMMENT 'ユーザーID',
  `name` varchar(255) NOT NULL COMMENT 'ユーザー名',
  `email` varchar(255) NOT NULL COMMENT 'メールアドレス',
  `password` varchar(500) NOT NULL COMMENT 'パスワード',
  `created_at` datetime NOT NULL COMMENT '登録日時',
  `updated_at` datetime DEFAULT NULL COMMENT 'アップデート日時',
  `deleted_at` datetime DEFAULT NULL COMMENT '退会日時'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`, `updated_at`, `deleted_at`) VALUES
(44, '佐藤', 'satou@test.com', '$2y$10$lcUNYQDvch.19w9ID1jkE.WgXPMtViweu2Vi2UuIyWKXib6C7WzJ2', '2022-06-05 21:39:20', '2022-06-05 21:39:20', NULL),
(45, '真中', 'manaka@test.com', '$2y$10$JwgawJ2WSsBVNnvMOFu8IORJ6kN8ecWMWAd5Z6gC/R7iQEyvOGQNi', '2022-06-05 21:47:02', '2022-06-05 21:47:02', NULL),
(46, '  川脇', 'kawawaki@gmail.com', '$2y$10$j7HhCxeE48VUXn6knDvga.DkFmvxNvJyxugLqVNjEihHqJqQPkpFa', '2022-06-05 21:53:58', '2022-06-05 21:53:58', NULL),
(47, '田口', 'taguchi@gmail.com', '$2y$10$mTIvGrJg9s90FBeR2zbbh.K0KBslAwS26pUfJdSGayZeoh6Fmyf3m', '2022-06-05 22:15:14', '2022-06-05 22:15:14', NULL),
(48, '坂下', 'sakasita@test.com', '$2y$10$MoOzz8dELpNQuKB6h/7l/OPdpJeE4xg.Z9bO1zdXm/.34fKrFLyvG', '2022-06-05 22:30:12', '2022-06-05 22:30:12', NULL),
(49, 'サムス', 'test@test.com', '$2y$10$zlssqZv1rXAbsZyD4whUc.A2h70GuJagyJLzWoM2nmZrbLbMNK0Pq', '2022-06-05 23:04:41', '2022-06-05 23:04:41', NULL),
(50, '井原', 'ihara@test.com', '$2y$10$sfR5OnmDBM1ME/x6LyGNmOavY/550nZTIcYWkFmsc1O8sc0Kv9Au6', '2022-06-06 14:45:21', '2022-06-06 14:45:21', NULL),
(51, '令和３年', 'reiwa@test.com', '$2y$10$5ZYwbjPR7bBpMaM0u.7NMeZwnBD4h6nN0E3/zaVBdgEC7QhtPzhkK', '2022-06-06 15:35:57', '2022-06-06 15:35:57', NULL),
(52, '坂fds\\\\dfksfsal;fklas:', 'sakaguchi@test.com', '$2y$10$Nc/O4YoTLZUnz/qA.u6iW.ZmWAnWgLWmMIebo0IujVVDJWVEtRICi', '2022-06-06 15:54:17', '2022-06-06 15:54:17', NULL),
(53, '酒井', 'sakai@test.com', '$2y$10$yb/xTWoJnU3e/dq7KyC86eQCL.9pIPH1fe3b6JGte0dTCiYFwZKSu', '2022-06-07 08:56:24', '2022-06-07 08:56:24', '2022-06-07 09:01:12'),
(55, '酒井', 'sakai@gmail.com', '$2y$10$3C4Xl4GEsPbO1wL15bM2WOQcUDgyTjhhEW5Fw2PAUHVbeXGSStwOe', '2022-06-07 09:09:44', '2022-06-07 09:09:44', NULL),
(56, '木下', 'kinoshita@gmail.com', '$2y$10$/XsMaD39CM5YPMKM49.5R.NThZFKntatvbwP0R5RSIVP2Qo71dTJe', '2022-06-07 10:40:00', '2022-06-07 10:40:00', '2022-06-07 10:43:27'),
(57, '金森', 'kanamori@test.com', '$2y$10$Zonvohajkgp.UjCmm.SYy.lyOWp0axj72Wu3KUtL45c0iUicCsHLK', '2022-06-07 11:19:05', '2022-06-07 11:19:05', '2022-06-07 11:21:12'),
(58, '熊本', 'kumamoto@test.com', '$2y$10$LYycc1TBdTYf1PkmplLdaupoUx7BdxUM2h6WvtkhAJQr4T5qNfNCi', '2022-06-07 12:07:17', '2022-06-07 12:07:17', '2022-06-07 12:11:36'),
(59, '坂下', 'sakashita@gmail.com', '$2y$10$45ZjJF4nVfXdYSxS9FXvfeA8gTxvryTxgiGIO4aol5X6kbknmGGuS', '2022-06-07 12:26:22', '2022-06-07 12:26:22', NULL),
(60, '本村', 'motomura@test.com', '$2y$10$lsrJTw.wI.4Zq4qUvCI3Feqz4/sX9OPLFi.3UolUs93zrAFV2D64y', '2022-06-07 13:56:09', '2022-06-07 13:56:09', '2022-06-07 13:58:46'),
(61, '本島', 'motojima@test.com', '$2y$10$D6xnYRsFjUIVGOHPaRoG9OFKQWdN6G09RqfFgSz.eZMCtxVCCVrYe', '2022-06-07 14:36:00', '2022-06-07 14:36:00', '2022-06-07 14:38:40'),
(62, '川脇', 'kawawaki@test.com', '$2y$10$JcMxiVGLOp5atapy.yynqu8qq04WSt8WkDubEExNnF2rVaLB1rgKS', '2022-06-07 14:47:00', '2022-06-07 14:47:00', '2022-06-07 14:48:46'),
(63, '酒井', 'sakai@yahoo.com', '$2y$10$uZ6esCcAQnSW7XJTrvnehucxN2vb3pF9wPTPVQQ3ooqTJsSrXETBu', '2022-06-07 15:35:33', '2022-06-07 15:35:33', '2022-06-07 15:38:11'),
(64, '友澤', 'tomozawa@test.com', '$2y$10$wPGRh/Rb56dmssyRy6Cem./BAxB3DQ0puUnjZG.NOeirxP3VrFH/.', '2022-06-07 15:46:31', '2022-06-07 15:46:31', '2022-06-07 15:48:56'),
(65, '坂下', 'sakasita@gmail.com', '$2y$10$6BBY3JkCllGCTR/cuB/INO6paMKqkBG/NJquGvowZZeGvX7cOnMd.', '2022-06-07 16:10:27', '2022-06-07 16:10:27', '2022-06-07 16:12:52'),
(66, 'テスト', 'test@test.co.jp', '$2y$10$klhsGSX2GrBP8qKGbM434Oae4VKFI55cr0pK.z70l9QyGSmOLV6G.', '2022-06-12 23:33:48', '2022-06-12 23:33:48', NULL);

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tags_un` (`name`);

--
-- テーブルのインデックス `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_un` (`email`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'コメントID', AUTO_INCREMENT=16;

--
-- テーブルの AUTO_INCREMENT `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'いいねID', AUTO_INCREMENT=24;

--
-- テーブルの AUTO_INCREMENT `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '投稿認識ID', AUTO_INCREMENT=19;

--
-- テーブルの AUTO_INCREMENT `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'タグ', AUTO_INCREMENT=6;

--
-- テーブルの AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ユーザーID', AUTO_INCREMENT=67;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
