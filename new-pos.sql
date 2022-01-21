/*
 Navicat Premium Data Transfer

 Source Server         : MYSQL - LOCAL
 Source Server Type    : MySQL
 Source Server Version : 100421
 Source Host           : localhost:3306
 Source Schema         : new-pos

 Target Server Type    : MySQL
 Target Server Version : 100421
 File Encoding         : 65001

 Date: 21/01/2022 17:29:37
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for add_opt
-- ----------------------------
DROP TABLE IF EXISTS `add_opt`;
CREATE TABLE `add_opt`  (
  `id_add_opt` int NOT NULL AUTO_INCREMENT,
  `nama_add_opt` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `punya_bahan_baku` int NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_add_opt`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of add_opt
-- ----------------------------
INSERT INTO `add_opt` VALUES (1, 'Pelengkap Kopi', 0, '2022-01-20 08:31:46', 'Administrator', NULL, NULL);
INSERT INTO `add_opt` VALUES (2, 'Topping Seblak', 1, '2022-01-20 08:41:57', 'Administrator', NULL, NULL);
INSERT INTO `add_opt` VALUES (3, 'Topping Terang Bulan', 1, '2022-01-20 09:23:06', 'Administrator', NULL, NULL);

-- ----------------------------
-- Table structure for add_opt_detail
-- ----------------------------
DROP TABLE IF EXISTS `add_opt_detail`;
CREATE TABLE `add_opt_detail`  (
  `id_add_opt_detail` int NOT NULL AUTO_INCREMENT,
  `id_add_opt` int NOT NULL,
  `nama_add_opt_detail` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `harga_add_opt_detail` float NOT NULL,
  PRIMARY KEY (`id_add_opt_detail`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of add_opt_detail
-- ----------------------------
INSERT INTO `add_opt_detail` VALUES (1, 1, 'Vietnam Drip', 2000);
INSERT INTO `add_opt_detail` VALUES (2, 1, 'Susu SKM', 1000);
INSERT INTO `add_opt_detail` VALUES (3, 1, 'V60', 3000);
INSERT INTO `add_opt_detail` VALUES (4, 1, 'Moka Pot', 3000);
INSERT INTO `add_opt_detail` VALUES (5, 2, 'Sosis', 2000);
INSERT INTO `add_opt_detail` VALUES (6, 2, 'Telur', 2000);
INSERT INTO `add_opt_detail` VALUES (7, 2, 'Daging', 5000);
INSERT INTO `add_opt_detail` VALUES (8, 3, 'Extra Keju', 2500);
INSERT INTO `add_opt_detail` VALUES (9, 3, 'Extra Susu', 1500);
INSERT INTO `add_opt_detail` VALUES (10, 3, 'Extra Coklat', 1500);

-- ----------------------------
-- Table structure for diskon
-- ----------------------------
DROP TABLE IF EXISTS `diskon`;
CREATE TABLE `diskon`  (
  `id_diskon` int NOT NULL,
  `nama` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `jumlah` float NOT NULL,
  `tipe` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` int NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_diskon`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of diskon
-- ----------------------------

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `failed_jobs_uuid_unique`(`uuid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of failed_jobs
-- ----------------------------

-- ----------------------------
-- Table structure for gudang
-- ----------------------------
DROP TABLE IF EXISTS `gudang`;
CREATE TABLE `gudang`  (
  `id_gudang` bigint NOT NULL AUTO_INCREMENT,
  `kode_gudang` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama_gudang` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `alamat_gudang` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `status` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `updated_by` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_gudang`, `kode_gudang`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of gudang
-- ----------------------------
INSERT INTO `gudang` VALUES (2, 'GD-0002', 'Gudang Utama', 'Jl. Ledokombo no 2 (kantor desa ledokombo)', '1', '2022-01-07 11:24:39', '2022-01-07 11:36:56', 'Administrator', 'Administrator');

-- ----------------------------
-- Table structure for kategori
-- ----------------------------
DROP TABLE IF EXISTS `kategori`;
CREATE TABLE `kategori`  (
  `id_kategori` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_kategori`) USING BTREE,
  UNIQUE INDEX `kategori_nama_kategori_unique`(`nama_kategori`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of kategori
-- ----------------------------
INSERT INTO `kategori` VALUES (1, 'ROKOK', '2021-12-25 09:38:53', '2021-12-27 02:03:03');
INSERT INTO `kategori` VALUES (2, 'ALAT TULIS KANTOR', '2021-12-25 10:50:24', '2021-12-27 02:02:51');
INSERT INTO `kategori` VALUES (3, 'JASA LAMINATING', '2021-12-27 03:43:08', '2021-12-27 03:43:08');

-- ----------------------------
-- Table structure for member
-- ----------------------------
DROP TABLE IF EXISTS `member`;
CREATE TABLE `member`  (
  `id_member` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `kode_member` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `telepon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_member`) USING BTREE,
  UNIQUE INDEX `member_kode_member_unique`(`kode_member`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of member
-- ----------------------------
INSERT INTO `member` VALUES (3, '00001', 'Syahril Ardi', 'Jl. Raung no. 31 Kalisat Jember', '0877379697', '2022-01-14 02:48:55', '2022-01-14 02:48:55');
INSERT INTO `member` VALUES (4, '00002', 'Dimas Islami', 'Jl. Benowo - Gresik no. 1 Surabaya', '984598669', '2022-01-14 02:49:18', '2022-01-14 02:49:18');
INSERT INTO `member` VALUES (5, '00003', 'Zakaria', 'Sidoarjo', '986296', '2022-01-14 02:49:32', '2022-01-14 02:49:32');

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 25 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '2014_10_12_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (2, '2014_10_12_100000_create_password_resets_table', 1);
INSERT INTO `migrations` VALUES (3, '2014_10_12_200000_add_two_factor_columns_to_users_table', 1);
INSERT INTO `migrations` VALUES (4, '2019_08_19_000000_create_failed_jobs_table', 1);
INSERT INTO `migrations` VALUES (5, '2019_12_14_000001_create_personal_access_tokens_table', 1);
INSERT INTO `migrations` VALUES (6, '2020_05_21_100000_create_teams_table', 1);
INSERT INTO `migrations` VALUES (7, '2020_05_21_200000_create_team_user_table', 1);
INSERT INTO `migrations` VALUES (8, '2020_05_21_300000_create_team_invitations_table', 1);
INSERT INTO `migrations` VALUES (9, '2021_03_05_194740_tambah_kolom_baru_to_users_table', 1);
INSERT INTO `migrations` VALUES (10, '2021_03_05_195441_buat_kategori_table', 1);
INSERT INTO `migrations` VALUES (11, '2021_03_05_195949_buat_produk_table', 1);
INSERT INTO `migrations` VALUES (12, '2021_03_05_200515_buat_member_table', 1);
INSERT INTO `migrations` VALUES (13, '2021_03_05_200706_buat_supplier_table', 1);
INSERT INTO `migrations` VALUES (14, '2021_03_05_200841_buat_pembelian_table', 1);
INSERT INTO `migrations` VALUES (15, '2021_03_05_200845_buat_pembelian_detail_table', 1);
INSERT INTO `migrations` VALUES (16, '2021_03_05_200853_buat_penjualan_table', 1);
INSERT INTO `migrations` VALUES (17, '2021_03_05_200858_buat_penjualan_detail_table', 1);
INSERT INTO `migrations` VALUES (18, '2021_03_05_200904_buat_setting_table', 1);
INSERT INTO `migrations` VALUES (19, '2021_03_05_201756_buat_pengeluaran_table', 1);
INSERT INTO `migrations` VALUES (20, '2021_03_11_225128_create_sessions_table', 1);
INSERT INTO `migrations` VALUES (21, '2021_03_24_115009_tambah_foreign_key_to_produk_table', 1);
INSERT INTO `migrations` VALUES (22, '2021_03_24_131829_tambah_kode_produk_to_produk_table', 1);
INSERT INTO `migrations` VALUES (23, '2021_05_08_220315_tambah_diskon_to_setting_table', 1);
INSERT INTO `migrations` VALUES (24, '2021_05_09_124745_edit_id_member_to_penjualan_table', 1);

-- ----------------------------
-- Table structure for outlet
-- ----------------------------
DROP TABLE IF EXISTS `outlet`;
CREATE TABLE `outlet`  (
  `id_outlet` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_outlet` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `telepon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipe_nota` tinyint NOT NULL,
  `path_logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `path_kartu_member` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dark_mode` int NOT NULL DEFAULT 0,
  `modul_meja` int NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_outlet`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of outlet
-- ----------------------------
INSERT INTO `outlet` VALUES (1, 'Toko Bumdes', 'Jl. Ledokombo', '08888', 1, '/img/logo-20220114084924.png', '/img/member.png', 1, 0, NULL, NULL, '2022-01-17 07:45:45', NULL);

-- ----------------------------
-- Table structure for outlet_diskon
-- ----------------------------
DROP TABLE IF EXISTS `outlet_diskon`;
CREATE TABLE `outlet_diskon`  (
  `id_outlet_diskon` int NOT NULL,
  `id_outlet` int NOT NULL,
  `id_diskon` int NOT NULL,
  PRIMARY KEY (`id_outlet_diskon`, `id_outlet`, `id_diskon`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of outlet_diskon
-- ----------------------------

-- ----------------------------
-- Table structure for outlet_pajak
-- ----------------------------
DROP TABLE IF EXISTS `outlet_pajak`;
CREATE TABLE `outlet_pajak`  (
  `id_outet_pajak` int NOT NULL,
  `id_outlet` int NOT NULL,
  `id_pajak` int NOT NULL,
  PRIMARY KEY (`id_outet_pajak`, `id_outlet`, `id_pajak`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of outlet_pajak
-- ----------------------------

-- ----------------------------
-- Table structure for pajak
-- ----------------------------
DROP TABLE IF EXISTS `pajak`;
CREATE TABLE `pajak`  (
  `id_pajak` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `jumlah` float NOT NULL,
  `tipe` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` int NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_pajak`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pajak
-- ----------------------------

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets`  (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  INDEX `password_resets_email_index`(`email`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of password_resets
-- ----------------------------

-- ----------------------------
-- Table structure for pembelian
-- ----------------------------
DROP TABLE IF EXISTS `pembelian`;
CREATE TABLE `pembelian`  (
  `id_pembelian` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_supplier` int NOT NULL,
  `total_item` int NOT NULL,
  `total_harga` int NOT NULL,
  `diskon` tinyint NOT NULL DEFAULT 0,
  `bayar` int NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_pembelian`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of pembelian
-- ----------------------------
INSERT INTO `pembelian` VALUES (3, 3, 0, 0, 0, 0, '2021-12-27 02:10:47', '2021-12-27 02:10:47');
INSERT INTO `pembelian` VALUES (4, 3, 0, 0, 0, 0, '2021-12-27 03:55:18', '2021-12-27 03:55:18');
INSERT INTO `pembelian` VALUES (5, 4, 0, 0, 0, 0, '2021-12-27 06:48:48', '2021-12-27 06:48:48');
INSERT INTO `pembelian` VALUES (6, 4, 1, 13400, 0, 13400, '2021-12-29 09:21:51', '2021-12-29 09:21:51');
INSERT INTO `pembelian` VALUES (7, 4, 1, 20000, 0, 20000, '2022-01-06 07:52:03', '2022-01-06 07:52:03');
INSERT INTO `pembelian` VALUES (8, 4, 1, 100000, 0, 100000, '2022-01-06 07:59:47', '2022-01-06 07:59:47');
INSERT INTO `pembelian` VALUES (9, 4, 1, 21000, 0, 21000, '2022-01-06 10:34:09', '2022-01-06 10:34:09');
INSERT INTO `pembelian` VALUES (10, 3, 2, 142500, 0, 142500, '2022-01-06 12:08:55', '2022-01-06 12:08:55');
INSERT INTO `pembelian` VALUES (12, 4, 2, 177500, 0, 177500, '2022-01-12 07:50:17', '2022-01-12 07:50:17');
INSERT INTO `pembelian` VALUES (13, 4, 3, 280000, 0, 280000, '2022-01-12 08:15:27', '2022-01-12 08:15:27');
INSERT INTO `pembelian` VALUES (14, 4, 1, 60000, 0, 60000, '2022-01-14 08:26:05', '2022-01-14 08:26:05');
INSERT INTO `pembelian` VALUES (15, 4, 5, 472500, 0, 472500, '2022-01-14 08:40:17', '2022-01-14 08:40:17');
INSERT INTO `pembelian` VALUES (16, 3, 5, 277000, 0, 277000, '2022-01-14 08:45:29', '2022-01-14 08:45:29');

-- ----------------------------
-- Table structure for pembelian_detail
-- ----------------------------
DROP TABLE IF EXISTS `pembelian_detail`;
CREATE TABLE `pembelian_detail`  (
  `id_pembelian_detail` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_pembelian` int NOT NULL,
  `id_produk` int NOT NULL,
  `harga_beli` int NOT NULL,
  `jumlah` int NOT NULL,
  `subtotal` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_pembelian_detail`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 27 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of pembelian_detail
-- ----------------------------
INSERT INTO `pembelian_detail` VALUES (3, 6, 21, 6700, 2, 13400, '2021-12-29 09:21:51', '2021-12-29 09:21:51');
INSERT INTO `pembelian_detail` VALUES (4, 7, 8, 20000, 1, 20000, '2022-01-06 07:52:03', '2022-01-06 07:52:03');
INSERT INTO `pembelian_detail` VALUES (5, 8, 8, 20000, 5, 100000, '2022-01-06 07:59:47', '2022-01-06 07:59:47');
INSERT INTO `pembelian_detail` VALUES (6, 9, 8, 21000, 1, 21000, '2022-01-06 10:34:09', '2022-01-06 10:34:09');
INSERT INTO `pembelian_detail` VALUES (7, 10, 8, 21000, 5, 105000, '2022-01-06 12:08:55', '2022-01-06 12:08:55');
INSERT INTO `pembelian_detail` VALUES (8, 10, 21, 7500, 5, 37500, '2022-01-06 12:08:55', '2022-01-06 12:08:55');
INSERT INTO `pembelian_detail` VALUES (11, 12, 4, 15500, 5, 77500, '2022-01-12 07:50:17', '2022-01-12 07:50:17');
INSERT INTO `pembelian_detail` VALUES (12, 12, 11, 20000, 5, 100000, '2022-01-12 07:50:17', '2022-01-12 07:50:17');
INSERT INTO `pembelian_detail` VALUES (13, 13, 4, 15500, 5, 77500, '2022-01-12 08:15:27', '2022-01-12 08:15:27');
INSERT INTO `pembelian_detail` VALUES (14, 13, 14, 20500, 5, 102500, '2022-01-12 08:15:27', '2022-01-12 08:15:27');
INSERT INTO `pembelian_detail` VALUES (15, 13, 11, 20000, 5, 100000, '2022-01-12 08:15:27', '2022-01-12 08:15:27');
INSERT INTO `pembelian_detail` VALUES (16, 14, 4, 20000, 3, 60000, '2022-01-14 08:26:05', '2022-01-14 08:26:05');
INSERT INTO `pembelian_detail` VALUES (17, 15, 4, 16500, 5, 82500, '2022-01-14 08:40:17', '2022-01-14 08:40:17');
INSERT INTO `pembelian_detail` VALUES (18, 15, 14, 21500, 5, 107500, '2022-01-14 08:40:17', '2022-01-14 08:40:17');
INSERT INTO `pembelian_detail` VALUES (19, 15, 11, 21000, 5, 105000, '2022-01-14 08:40:17', '2022-01-14 08:40:17');
INSERT INTO `pembelian_detail` VALUES (20, 15, 22, 18500, 5, 92500, '2022-01-14 08:40:17', '2022-01-14 08:40:17');
INSERT INTO `pembelian_detail` VALUES (21, 15, 25, 17000, 5, 85000, '2022-01-14 08:40:17', '2022-01-14 08:40:17');
INSERT INTO `pembelian_detail` VALUES (22, 16, 4, 16000, 2, 32000, '2022-01-14 08:45:29', '2022-01-14 08:45:29');
INSERT INTO `pembelian_detail` VALUES (23, 16, 14, 21000, 3, 63000, '2022-01-14 08:45:29', '2022-01-14 08:45:29');
INSERT INTO `pembelian_detail` VALUES (24, 16, 11, 20600, 2, 41200, '2022-01-14 08:45:29', '2022-01-14 08:45:29');
INSERT INTO `pembelian_detail` VALUES (25, 16, 22, 18600, 3, 55800, '2022-01-14 08:45:29', '2022-01-14 08:45:29');
INSERT INTO `pembelian_detail` VALUES (26, 16, 25, 17000, 5, 85000, '2022-01-14 08:45:29', '2022-01-14 08:45:29');

-- ----------------------------
-- Table structure for pengeluaran
-- ----------------------------
DROP TABLE IF EXISTS `pengeluaran`;
CREATE TABLE `pengeluaran`  (
  `id_pengeluaran` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nominal` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_pengeluaran`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of pengeluaran
-- ----------------------------
INSERT INTO `pengeluaran` VALUES (1, 'beli popok', 200000, '2022-01-14 07:35:19', '2022-01-14 07:35:19');

-- ----------------------------
-- Table structure for penjualan
-- ----------------------------
DROP TABLE IF EXISTS `penjualan`;
CREATE TABLE `penjualan`  (
  `id_penjualan` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_member` int NULL DEFAULT NULL,
  `total_item` int NOT NULL,
  `total_harga` int NOT NULL,
  `diskon` tinyint NOT NULL DEFAULT 0,
  `bayar` int NOT NULL DEFAULT 0,
  `diterima` int NOT NULL DEFAULT 0,
  `id_user` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_penjualan`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 36 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of penjualan
-- ----------------------------
INSERT INTO `penjualan` VALUES (17, NULL, 2, 55000, 0, 55000, 0, 1, '2021-12-27 03:45:02', '2021-12-27 03:46:00');
INSERT INTO `penjualan` VALUES (18, NULL, 10, 159000, 0, 159000, 0, 1, '2021-12-27 03:46:06', '2021-12-27 03:51:30');
INSERT INTO `penjualan` VALUES (19, NULL, 8, 122000, 0, 122000, 0, 1, '2021-12-27 03:51:46', '2021-12-27 03:53:51');
INSERT INTO `penjualan` VALUES (20, NULL, 6, 91500, 0, 91500, 0, 1, '2021-12-27 06:12:30', '2021-12-27 06:14:14');
INSERT INTO `penjualan` VALUES (22, NULL, 16, 163500, 0, 163500, 0, 1, '2021-12-29 02:58:39', '2021-12-29 03:02:59');
INSERT INTO `penjualan` VALUES (23, NULL, 8, 127500, 0, 127500, 0, 1, '2021-12-29 03:03:23', '2021-12-29 03:05:47');
INSERT INTO `penjualan` VALUES (24, NULL, 8, 132000, 0, 132000, 0, 1, '2021-12-29 07:11:01', '2021-12-29 07:13:22');
INSERT INTO `penjualan` VALUES (25, NULL, 2, 23500, 0, 23500, 25000, 1, '2022-01-06 02:18:32', '2022-01-06 02:18:32');
INSERT INTO `penjualan` VALUES (26, NULL, 1, 32000, 0, 32000, 35000, 1, '2022-01-06 07:53:50', '2022-01-06 07:53:50');
INSERT INTO `penjualan` VALUES (27, NULL, 1, 16000, 0, 16000, 17000, 1, '2022-01-06 10:57:19', '2022-01-06 10:57:19');
INSERT INTO `penjualan` VALUES (28, NULL, 2, 59000, 0, 59000, 60000, 1, '2022-01-06 12:15:49', '2022-01-06 12:15:49');
INSERT INTO `penjualan` VALUES (32, NULL, 1, 195000, 0, 195000, 200000, 1, '2022-01-12 08:45:33', '2022-01-12 08:45:33');
INSERT INTO `penjualan` VALUES (33, NULL, 1, 32000, 0, 32000, 0, 1, '2022-01-13 10:54:18', '2022-01-13 10:54:18');
INSERT INTO `penjualan` VALUES (34, NULL, 2, 82000, 0, 82000, 85000, 1, '2022-01-16 02:53:06', '2022-01-16 02:53:06');
INSERT INTO `penjualan` VALUES (35, NULL, 1, 16000, 0, 16000, 17000, 1, '2022-01-16 02:56:46', '2022-01-16 02:56:46');

-- ----------------------------
-- Table structure for penjualan_detail
-- ----------------------------
DROP TABLE IF EXISTS `penjualan_detail`;
CREATE TABLE `penjualan_detail`  (
  `id_penjualan_detail` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_penjualan` int NOT NULL,
  `id_produk` int NOT NULL,
  `harga_beli` int NOT NULL DEFAULT 0,
  `harga_jual` int NOT NULL,
  `jumlah` int NOT NULL,
  `diskon` tinyint NOT NULL DEFAULT 0,
  `subtotal` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_penjualan_detail`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 73 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of penjualan_detail
-- ----------------------------
INSERT INTO `penjualan_detail` VALUES (13, 17, 7, 26400, 27500, 2, 0, 55000, '2021-12-27 03:45:31', '2021-12-27 03:45:39');
INSERT INTO `penjualan_detail` VALUES (14, 18, 23, 18100, 19000, 1, 0, 19000, '2021-12-27 03:46:34', '2021-12-27 03:46:34');
INSERT INTO `penjualan_detail` VALUES (15, 18, 22, 20200, 21000, 2, 0, 42000, '2021-12-27 03:47:18', '2021-12-27 03:47:21');
INSERT INTO `penjualan_detail` VALUES (16, 18, 11, 18400, 20000, 3, 0, 60000, '2021-12-27 03:47:33', '2021-12-27 03:47:40');
INSERT INTO `penjualan_detail` VALUES (17, 18, 12, 11500, 12000, 3, 0, 36000, '2021-12-27 03:48:09', '2021-12-27 03:48:16');
INSERT INTO `penjualan_detail` VALUES (18, 18, 27, 2000, 2000, 1, 0, 2000, '2021-12-27 03:51:16', '2021-12-27 03:51:16');
INSERT INTO `penjualan_detail` VALUES (19, 19, 4, 11750, 13000, 1, 0, 13000, '2021-12-27 03:52:05', '2021-12-27 03:52:05');
INSERT INTO `penjualan_detail` VALUES (20, 19, 8, 20000, 16000, 1, 0, 16000, '2021-12-27 03:52:21', '2021-12-27 03:52:21');
INSERT INTO `penjualan_detail` VALUES (21, 19, 18, 12600, 14000, 1, 0, 14000, '2021-12-27 03:52:35', '2021-12-27 03:52:35');
INSERT INTO `penjualan_detail` VALUES (22, 19, 11, 18400, 20000, 1, 0, 20000, '2021-12-27 03:52:47', '2021-12-27 03:52:47');
INSERT INTO `penjualan_detail` VALUES (23, 19, 26, 10000, 11000, 1, 0, 11000, '2021-12-27 03:52:59', '2021-12-27 03:52:59');
INSERT INTO `penjualan_detail` VALUES (24, 19, 6, 10600, 12000, 1, 0, 12000, '2021-12-27 03:53:20', '2021-12-27 03:53:20');
INSERT INTO `penjualan_detail` VALUES (25, 19, 22, 20200, 21000, 1, 0, 21000, '2021-12-27 03:53:34', '2021-12-27 03:53:34');
INSERT INTO `penjualan_detail` VALUES (26, 19, 15, 14100, 15000, 1, 0, 15000, '2021-12-27 03:53:46', '2021-12-27 03:53:46');
INSERT INTO `penjualan_detail` VALUES (27, 20, 7, 26400, 27500, 1, 0, 27500, '2021-12-27 06:12:41', '2021-12-27 06:12:41');
INSERT INTO `penjualan_detail` VALUES (28, 20, 20, 12700, 13500, 1, 0, 13500, '2021-12-27 06:12:50', '2021-12-27 06:12:50');
INSERT INTO `penjualan_detail` VALUES (29, 20, 13, 14750, 15500, 1, 0, 15500, '2021-12-27 06:13:01', '2021-12-27 06:13:01');
INSERT INTO `penjualan_detail` VALUES (30, 20, 22, 20200, 21000, 1, 0, 21000, '2021-12-27 06:13:18', '2021-12-27 06:13:18');
INSERT INTO `penjualan_detail` VALUES (31, 20, 5, 10600, 12000, 1, 0, 12000, '2021-12-27 06:13:36', '2021-12-27 06:13:36');
INSERT INTO `penjualan_detail` VALUES (32, 20, 27, 2000, 2000, 1, 0, 2000, '2021-12-27 06:13:48', '2021-12-27 06:13:48');
INSERT INTO `penjualan_detail` VALUES (34, 22, 7, 26400, 27500, 1, 0, 27500, '2021-12-29 02:58:48', '2021-12-29 02:58:48');
INSERT INTO `penjualan_detail` VALUES (35, 22, 30, 3292, 5000, 1, 0, 5000, '2021-12-29 02:59:28', '2021-12-29 02:59:28');
INSERT INTO `penjualan_detail` VALUES (36, 22, 11, 18400, 20000, 1, 0, 20000, '2021-12-29 02:59:40', '2021-12-29 02:59:40');
INSERT INTO `penjualan_detail` VALUES (37, 22, 29, 5000, 5000, 7, 0, 35000, '2021-12-29 02:59:54', '2021-12-29 03:02:32');
INSERT INTO `penjualan_detail` VALUES (38, 22, 26, 10000, 11000, 1, 0, 11000, '2021-12-29 03:00:19', '2021-12-29 03:00:19');
INSERT INTO `penjualan_detail` VALUES (39, 22, 8, 20000, 16000, 1, 0, 16000, '2021-12-29 03:00:26', '2021-12-29 03:00:26');
INSERT INTO `penjualan_detail` VALUES (40, 22, 16, 14100, 15000, 1, 0, 15000, '2021-12-29 03:00:39', '2021-12-29 03:00:39');
INSERT INTO `penjualan_detail` VALUES (41, 22, 18, 12600, 14000, 1, 0, 14000, '2021-12-29 03:00:49', '2021-12-29 03:00:49');
INSERT INTO `penjualan_detail` VALUES (42, 22, 98, 500, 1000, 1, 0, 1000, '2021-12-29 03:01:00', '2021-12-29 03:01:00');
INSERT INTO `penjualan_detail` VALUES (43, 22, 23, 18100, 19000, 1, 0, 19000, '2021-12-29 03:01:15', '2021-12-29 03:01:15');
INSERT INTO `penjualan_detail` VALUES (44, 23, 29, 5000, 5000, 1, 0, 5000, '2021-12-29 03:03:35', '2021-12-29 03:03:35');
INSERT INTO `penjualan_detail` VALUES (45, 23, 11, 18400, 20000, 1, 0, 20000, '2021-12-29 03:03:45', '2021-12-29 03:03:45');
INSERT INTO `penjualan_detail` VALUES (46, 23, 8, 20000, 16000, 1, 0, 16000, '2021-12-29 03:03:52', '2021-12-29 03:03:52');
INSERT INTO `penjualan_detail` VALUES (47, 23, 109, 3667, 6000, 1, 0, 6000, '2021-12-29 03:04:02', '2021-12-29 03:04:02');
INSERT INTO `penjualan_detail` VALUES (48, 23, 7, 26400, 27500, 1, 0, 27500, '2021-12-29 03:04:11', '2021-12-29 03:04:11');
INSERT INTO `penjualan_detail` VALUES (49, 23, 10, 22600, 24500, 1, 0, 24500, '2021-12-29 03:04:27', '2021-12-29 03:04:27');
INSERT INTO `penjualan_detail` VALUES (50, 23, 7, 26400, 27500, 1, 0, 27500, '2021-12-29 03:04:36', '2021-12-29 03:04:36');
INSERT INTO `penjualan_detail` VALUES (51, 23, 63, 750, 1000, 1, 0, 1000, '2021-12-29 03:04:54', '2021-12-29 03:04:54');
INSERT INTO `penjualan_detail` VALUES (52, 24, 8, 20000, 16000, 1, 0, 16000, '2021-12-29 07:11:19', '2021-12-29 07:11:19');
INSERT INTO `penjualan_detail` VALUES (53, 24, 29, 5000, 5000, 2, 0, 10000, '2021-12-29 07:11:32', '2021-12-29 07:12:41');
INSERT INTO `penjualan_detail` VALUES (54, 24, 23, 18100, 19000, 1, 0, 19000, '2021-12-29 07:11:40', '2021-12-29 07:11:40');
INSERT INTO `penjualan_detail` VALUES (55, 24, 7, 26400, 27500, 1, 0, 27500, '2021-12-29 07:11:49', '2021-12-29 07:11:49');
INSERT INTO `penjualan_detail` VALUES (56, 24, 7, 26400, 27500, 1, 0, 27500, '2021-12-29 07:11:52', '2021-12-29 07:11:52');
INSERT INTO `penjualan_detail` VALUES (57, 24, 23, 18100, 19000, 1, 0, 19000, '2021-12-29 07:12:03', '2021-12-29 07:12:03');
INSERT INTO `penjualan_detail` VALUES (58, 24, 4, 11750, 13000, 1, 0, 13000, '2021-12-29 07:12:13', '2021-12-29 07:12:13');
INSERT INTO `penjualan_detail` VALUES (59, 25, 8, 20000, 16000, 1, 0, 16000, '2022-01-06 02:18:32', '2022-01-06 02:18:32');
INSERT INTO `penjualan_detail` VALUES (60, 25, 21, 6700, 7500, 1, 0, 7500, '2022-01-06 02:18:32', '2022-01-06 02:18:32');
INSERT INTO `penjualan_detail` VALUES (61, 26, 8, 20000, 16000, 2, 0, 32000, '2022-01-06 07:53:50', '2022-01-06 07:53:50');
INSERT INTO `penjualan_detail` VALUES (62, 27, 8, 20000, 16000, 1, 0, 16000, '2022-01-06 10:57:19', '2022-01-06 10:57:19');
INSERT INTO `penjualan_detail` VALUES (63, 28, 8, 21000, 21500, 2, 0, 43000, '2022-01-06 12:15:49', '2022-01-06 12:15:49');
INSERT INTO `penjualan_detail` VALUES (64, 28, 21, 7500, 8000, 2, 0, 16000, '2022-01-06 12:15:49', '2022-01-06 12:15:49');
INSERT INTO `penjualan_detail` VALUES (68, 32, 4, 15091, 13000, 15, 0, 195000, '2022-01-12 08:45:33', '2022-01-12 08:45:33');
INSERT INTO `penjualan_detail` VALUES (69, 33, 4, 15773, 16000, 2, 0, 32000, '2022-01-13 10:54:18', '2022-01-13 10:54:18');
INSERT INTO `penjualan_detail` VALUES (70, 34, 4, 16121, 16000, 3, 0, 48000, '2022-01-16 02:53:06', '2022-01-16 02:53:06');
INSERT INTO `penjualan_detail` VALUES (71, 34, 14, 20813, 17000, 2, 0, 34000, '2022-01-16 02:53:06', '2022-01-16 02:53:06');
INSERT INTO `penjualan_detail` VALUES (72, 35, 4, 16121, 16000, 1, 0, 16000, '2022-01-16 02:56:46', '2022-01-16 02:56:46');

-- ----------------------------
-- Table structure for personal_access_tokens
-- ----------------------------
DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `personal_access_tokens_token_unique`(`token`) USING BTREE,
  INDEX `personal_access_tokens_tokenable_type_tokenable_id_index`(`tokenable_type`, `tokenable_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of personal_access_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for produk
-- ----------------------------
DROP TABLE IF EXISTS `produk`;
CREATE TABLE `produk`  (
  `id_produk` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_kategori` int UNSIGNED NOT NULL,
  `id_outlet` int NOT NULL,
  `sku_produk` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `barcode_produk` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `kode_produk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_produk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `merk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `diskon` tinyint NOT NULL DEFAULT 0,
  `harga_jual` int NOT NULL,
  `satuan_stok` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dijual` int NOT NULL DEFAULT 1,
  `kelola_stok` int NOT NULL DEFAULT 1,
  `pajak` int NOT NULL DEFAULT 0,
  `jenis` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'master',
  `tipe` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'tunggal',
  `min_stok` float NULL DEFAULT NULL,
  `gambar` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `status` int NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `updated_by` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_produk`) USING BTREE,
  UNIQUE INDEX `produk_nama_produk_unique`(`nama_produk`) USING BTREE,
  UNIQUE INDEX `produk_kode_produk_unique`(`kode_produk`) USING BTREE,
  INDEX `produk_id_kategori_foreign`(`id_kategori`) USING BTREE,
  CONSTRAINT `produk_id_kategori_foreign` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 127 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of produk
-- ----------------------------
INSERT INTO `produk` VALUES (4, 1, 0, '', NULL, 'P000001', 'TOPPAS FILTER 12', 'TOPPAS', 0, 16000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-27 02:15:02', '2022-01-12 09:07:41', NULL, NULL);
INSERT INTO `produk` VALUES (5, 1, 0, '', NULL, 'P000005', 'GOLDEN 12 88 MERAH', 'GOLDEN', 0, 12000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-27 02:18:38', '2021-12-27 06:14:14', NULL, NULL);
INSERT INTO `produk` VALUES (6, 1, 0, '', NULL, 'P000006', 'DELUXE 12 BOLD 88 HITAM', 'DELUXE BOLD 88', 0, 12000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-27 02:19:43', '2021-12-27 03:53:51', NULL, NULL);
INSERT INTO `produk` VALUES (7, 1, 0, '', NULL, 'P000007', 'MLD 20 PUTIH', 'MLD', 0, 27500, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-27 02:20:21', '2021-12-29 07:13:22', NULL, NULL);
INSERT INTO `produk` VALUES (8, 1, 0, '', NULL, 'P000008', 'GEO MILD', 'GEOMILD', 0, 21500, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-27 02:21:07', '2021-12-29 07:13:22', NULL, NULL);
INSERT INTO `produk` VALUES (9, 1, 0, '', NULL, 'P000009', 'LA MILD 16', 'LA MILD', 0, 24000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-27 02:21:50', '2021-12-27 02:21:50', NULL, NULL);
INSERT INTO `produk` VALUES (10, 1, 0, '', NULL, 'P000010', 'SAMPOERNA MILD 16', 'SAMPOERNA', 0, 24500, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-27 02:22:47', '2021-12-29 03:05:47', NULL, NULL);
INSERT INTO `produk` VALUES (11, 1, 0, '', NULL, 'P000011', 'SURYA 12 GG', 'SURYA', 0, 20000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-27 02:23:55', '2021-12-29 03:05:47', NULL, NULL);
INSERT INTO `produk` VALUES (12, 1, 0, '', NULL, 'P000012', 'GRENDEL 12', 'GRENDEL', 0, 12000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-27 02:25:34', '2021-12-27 03:51:30', NULL, NULL);
INSERT INTO `produk` VALUES (13, 1, 0, '', NULL, 'P000013', 'GRENDEL 16', 'GRENDEL', 0, 15500, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-27 02:26:18', '2021-12-27 06:14:14', NULL, NULL);
INSERT INTO `produk` VALUES (14, 1, 0, '', NULL, 'P000014', 'TOPPAS FILTER 16', 'TOPPAS', 0, 17000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-27 02:27:26', '2021-12-27 02:27:26', NULL, NULL);
INSERT INTO `produk` VALUES (15, 1, 0, '', NULL, 'P000015', 'DELUXE 16 BOLD 88 HITAM', 'DELUXE BOLD 88', 0, 15000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-27 02:28:42', '2021-12-27 03:53:51', NULL, NULL);
INSERT INTO `produk` VALUES (16, 1, 0, '', NULL, 'P000016', 'GOLDEN 16 88 MERAH', 'GOLDEN', 0, 15000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-27 03:06:53', '2021-12-29 03:02:59', NULL, NULL);
INSERT INTO `produk` VALUES (17, 1, 0, '', NULL, 'P000017', 'NEXT BOLD 20', 'NEXT BOLD', 0, 18000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-27 03:08:01', '2021-12-27 03:08:01', NULL, NULL);
INSERT INTO `produk` VALUES (18, 1, 0, '', NULL, 'P000018', 'AGA SAMPOERNA IJO', 'AGA SAMPOERNA', 0, 14000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-27 03:08:59', '2021-12-29 03:02:59', NULL, NULL);
INSERT INTO `produk` VALUES (19, 1, 0, '', NULL, 'P000019', 'MLD 16 HITAM', 'MLD', 0, 23500, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-27 03:10:16', '2021-12-27 03:10:16', NULL, NULL);
INSERT INTO `produk` VALUES (20, 1, 0, '', NULL, 'P000020', 'DJARUM 76', 'DJARUM', 0, 13500, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-27 03:11:06', '2021-12-27 06:14:14', NULL, NULL);
INSERT INTO `produk` VALUES (21, 1, 0, '', NULL, 'P000021', 'GEO KRETEK MERFAH', 'GEO', 0, 8000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-27 03:11:52', '2021-12-27 03:11:52', NULL, NULL);
INSERT INTO `produk` VALUES (22, 1, 0, '', NULL, 'P000022', 'SURYA PRO MERAH', 'SURYA', 0, 21000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-27 03:12:43', '2021-12-27 06:14:14', NULL, NULL);
INSERT INTO `produk` VALUES (23, 1, 0, '', NULL, 'P000023', 'DIPLOMAT 12 HITAM', 'DIPLOMAT', 0, 19000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-27 03:13:54', '2021-12-29 07:13:22', NULL, NULL);
INSERT INTO `produk` VALUES (24, 1, 0, '', NULL, 'P000024', 'MAGNUM FILTER HITAM', 'MAGNUM', 0, 18500, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-27 03:14:56', '2021-12-27 03:14:56', NULL, NULL);
INSERT INTO `produk` VALUES (25, 1, 0, '', NULL, 'P000025', 'SURYA PROMILD PUTIH', 'SURYA', 0, 21500, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-27 03:16:03', '2021-12-27 03:16:03', NULL, NULL);
INSERT INTO `produk` VALUES (26, 2, 0, '', NULL, 'P000026', 'MATERAI 10K', 'MATERAI', 0, 11000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-27 03:42:44', '2021-12-29 03:02:59', NULL, NULL);
INSERT INTO `produk` VALUES (27, 1, 0, '', NULL, 'P000027', 'KOREK MAGNET', 'KOREK', 0, 2000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-27 03:49:46', '2021-12-27 06:14:14', NULL, NULL);
INSERT INTO `produk` VALUES (28, 1, 0, '', NULL, 'P000028', 'KOREK BIASA', 'KOREK', 0, 1000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-27 03:50:51', '2021-12-27 03:50:51', NULL, NULL);
INSERT INTO `produk` VALUES (29, 3, 0, '', NULL, 'P000029', 'Jasa Laminating', 'kertas fintech', 0, 5000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-27 06:18:35', '2021-12-29 07:13:22', NULL, NULL);
INSERT INTO `produk` VALUES (30, 2, 0, '', NULL, 'P000030', 'BOLPOIN GEL TIZO 340', 'TIZO', 0, 5000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-27 06:56:46', '2021-12-29 03:02:59', NULL, NULL);
INSERT INTO `produk` VALUES (31, 2, 0, '', NULL, 'P000031', 'BOLPOIN GEL WEIYADA 5681', 'WEIYADA', 0, 5000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-27 07:03:11', '2021-12-27 07:03:11', NULL, NULL);
INSERT INTO `produk` VALUES (32, 2, 0, '', NULL, 'P000032', 'BOLPOIN STANDARD BLACK', 'STANDARD AE7', 0, 2000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-27 07:16:25', '2021-12-27 07:16:25', NULL, NULL);
INSERT INTO `produk` VALUES (33, 2, 0, '', NULL, 'P000033', 'BOLPOIN GEL G-3073', 'ZHIXIN G-3073', 0, 3000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-27 07:17:46', '2021-12-27 07:17:46', NULL, NULL);
INSERT INTO `produk` VALUES (34, 2, 0, '', NULL, 'P000034', 'CAT AIR WATER COLOUR NO.120', 'MR. LOVE GUITAR', 0, 15000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-27 07:20:55', '2021-12-27 07:20:55', NULL, NULL);
INSERT INTO `produk` VALUES (35, 2, 0, '', NULL, 'P000035', 'KUAS CAT AIR  PAGODA NO.1', 'PAGODA HANDY', 0, 3000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-27 07:28:22', '2021-12-27 07:28:22', NULL, NULL);
INSERT INTO `produk` VALUES (36, 2, 0, '', NULL, 'P000036', 'KUAS CAT AIR PAGODA NO.3', 'PAGODA HANDY', 0, 3500, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-27 07:29:49', '2021-12-27 07:29:49', NULL, NULL);
INSERT INTO `produk` VALUES (37, 2, 0, '', NULL, 'P000037', 'KUAS CAT AIR PAGODA NO.5', 'PAGODA HANDY', 0, 3500, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-27 07:31:44', '2021-12-27 07:31:44', NULL, NULL);
INSERT INTO `produk` VALUES (38, 2, 0, '', NULL, 'P000038', 'KUAS CAT AIR PAGODA NO.7', 'PAGODA HANDY', 0, 4000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-27 07:32:34', '2021-12-27 07:32:34', NULL, NULL);
INSERT INTO `produk` VALUES (39, 2, 0, '', NULL, 'P000039', 'CRAYON FANCY BT21', 'FANCY BT21', 0, 10000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-27 07:36:43', '2021-12-27 07:36:43', NULL, NULL);
INSERT INTO `produk` VALUES (40, 2, 0, '', NULL, 'P000040', 'SPIDOL WARNA SIGN PEN 12', 'SAFARI BRAND', 0, 6500, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-27 07:42:03', '2021-12-27 07:42:03', NULL, NULL);
INSERT INTO `produk` VALUES (41, 2, 0, '', NULL, 'P000041', 'SPIDOL WARNA SNOWMAN SIGN PEN 12', 'SNOWMAN', 0, 17000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-27 07:45:55', '2021-12-27 07:45:55', NULL, NULL);
INSERT INTO `produk` VALUES (42, 2, 0, '', NULL, 'P000042', 'PENSIL WARNA JOYKO PJ 12', 'JOYKO', 0, 15000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-27 07:49:35', '2021-12-27 07:49:35', NULL, NULL);
INSERT INTO `produk` VALUES (43, 2, 0, '', NULL, 'P000043', 'CRAYON TITI 18', 'TITI', 0, 35000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-27 07:54:32', '2021-12-27 07:54:32', NULL, NULL);
INSERT INTO `produk` VALUES (44, 2, 0, '', NULL, 'P000044', 'KOTAK PENSIL SPORT COKLAT', 'SPORT ST 308', 0, 15000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-27 08:00:08', '2021-12-27 08:00:08', NULL, NULL);
INSERT INTO `produk` VALUES (45, 2, 0, '', NULL, 'P000045', 'KOTAK PENSIL UNICORN UNGU', 'UNICORN', 0, 25000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-27 08:01:12', '2021-12-27 08:01:12', NULL, NULL);
INSERT INTO `produk` VALUES (46, 2, 0, '', NULL, 'P000046', 'KOTAK PENSIL MOMO PINK', 'MOMO M-083', 0, 25000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-27 08:02:03', '2021-12-27 08:02:03', NULL, NULL);
INSERT INTO `produk` VALUES (47, 2, 0, '', NULL, 'P000047', 'KOTAK PENSIL SPORT RED', 'SPORT ST 308', 0, 15000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-27 08:02:39', '2021-12-27 08:02:39', NULL, NULL);
INSERT INTO `produk` VALUES (48, 2, 0, '', NULL, 'P000048', 'PENGGARIS BUTTERFLY 30 CM', 'BUTTERFLY', 0, 3000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-27 08:05:57', '2021-12-27 08:05:57', NULL, NULL);
INSERT INTO `produk` VALUES (49, 2, 0, '', NULL, 'P000049', 'JANGKA JOYKO MS-25', 'JOYKO', 0, 12000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-27 08:09:39', '2021-12-27 08:09:39', NULL, NULL);
INSERT INTO `produk` VALUES (50, 2, 0, '', NULL, 'P000050', 'KAPUR TULIS  PC PUTIH', 'PEACE CHALK', 0, 5000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-27 08:12:35', '2021-12-27 08:12:35', NULL, NULL);
INSERT INTO `produk` VALUES (51, 2, 0, '', NULL, 'P000051', 'LEM FOX PUTIH', 'LEM FOX', 0, 10000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-27 08:15:20', '2021-12-27 08:15:20', NULL, NULL);
INSERT INTO `produk` VALUES (52, 2, 0, '', NULL, 'P000052', 'GUNTING JOYKO SC-838', 'JOYKO SC-838', 0, 10000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-27 08:17:17', '2021-12-27 08:17:17', NULL, NULL);
INSERT INTO `produk` VALUES (53, 2, 0, '', NULL, 'P000053', 'GUNTING M2000 SM-A145', 'M2000 SM-A145', 0, 5000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-27 08:18:02', '2021-12-27 08:18:02', NULL, NULL);
INSERT INTO `produk` VALUES (54, 2, 0, '', NULL, 'P000054', 'GUNTING LINKO SC-040', 'LINKO SC-040', 0, 5000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-27 08:22:23', '2021-12-27 08:22:23', NULL, NULL);
INSERT INTO `produk` VALUES (55, 2, 0, '', NULL, 'P000055', 'TINTA SPIDOL SNOWMAN PERMANENT', 'SNOWMAN', 0, 12500, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-28 02:16:43', '2021-12-28 02:16:43', NULL, NULL);
INSERT INTO `produk` VALUES (56, 2, 0, '', NULL, 'P000056', 'TINTA EPSON YELLOW', 'EPSON 664', 0, 90000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-28 02:26:39', '2021-12-28 02:26:39', NULL, NULL);
INSERT INTO `produk` VALUES (57, 2, 0, '', NULL, 'P000057', 'TINTA EPSON MAGENTA', 'EPSON 664', 0, 90000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-28 02:27:15', '2021-12-28 02:27:15', NULL, NULL);
INSERT INTO `produk` VALUES (58, 2, 0, '', NULL, 'P000058', 'TINTA EPSON BLACK', 'EPSON 664', 0, 90000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-28 02:28:35', '2021-12-28 02:28:35', NULL, NULL);
INSERT INTO `produk` VALUES (59, 2, 0, '', NULL, 'P000059', 'TINTA EPSON CYAN', 'EPSON 664', 0, 90000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-28 02:29:08', '2021-12-28 02:29:08', NULL, NULL);
INSERT INTO `produk` VALUES (60, 2, 0, '', NULL, 'P000060', 'LEM FOX KALENG', 'LEM FOX', 0, 10000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-28 02:34:29', '2021-12-28 02:34:29', NULL, NULL);
INSERT INTO `produk` VALUES (61, 2, 0, '', NULL, 'P000061', 'CORRECTION PEN KIRIKO', 'KIRIKO', 0, 7000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-28 02:39:51', '2021-12-28 02:39:51', NULL, NULL);
INSERT INTO `produk` VALUES (62, 2, 0, '', NULL, 'P000062', 'SPIDOL BESAR SNOWMAN PERMANENT', 'SNOWMAN', 0, 8000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-28 02:45:29', '2021-12-28 02:45:29', NULL, NULL);
INSERT INTO `produk` VALUES (63, 2, 0, '', NULL, 'P000063', 'PENSIL BACHELOR 2B', 'BACHELOR', 0, 1000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-28 02:50:07', '2021-12-29 03:05:47', NULL, NULL);
INSERT INTO `produk` VALUES (64, 2, 0, '', NULL, 'P000064', 'SETIP JOYKO B40', 'JOYKO', 0, 1500, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-28 02:53:55', '2021-12-28 02:54:09', NULL, NULL);
INSERT INTO `produk` VALUES (65, 2, 0, '', NULL, 'P000065', 'KEROTAN RANDOM ANGSA', 'ANGSA', 0, 3500, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-28 03:11:13', '2021-12-28 03:11:13', NULL, NULL);
INSERT INTO `produk` VALUES (66, 2, 0, '', NULL, 'P000066', 'KEROTAN RANDOM BUNGKUS', 'KERANG BUNGKUS', 0, 5000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-28 03:19:12', '2021-12-28 03:19:12', NULL, NULL);
INSERT INTO `produk` VALUES (67, 2, 0, '', NULL, 'P000067', 'STABILO ARTLINE  660', 'SHACHINATA', 0, 6000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-28 03:21:35', '2021-12-28 03:21:35', NULL, NULL);
INSERT INTO `produk` VALUES (68, 2, 0, '', NULL, 'P000068', 'STAPLER JOYKO HD-10', 'JOYKO HD-10', 0, 11000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-28 03:27:28', '2021-12-28 03:27:28', NULL, NULL);
INSERT INTO `produk` VALUES (69, 2, 0, '', NULL, 'P000069', 'AMPLOP 104 PPS', 'PAPERLINE', 0, 250, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-28 03:34:28', '2021-12-28 03:34:28', NULL, NULL);
INSERT INTO `produk` VALUES (70, 2, 0, '', NULL, 'P000070', 'AMPLOP 90 PPS', 'PAPERLINE', 0, 500, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-28 03:35:16', '2021-12-28 03:35:16', NULL, NULL);
INSERT INTO `produk` VALUES (71, 2, 0, '', NULL, 'P000071', 'LEM BAKAR KECIL', 'NO MERK', 0, 1000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-28 03:42:35', '2021-12-28 03:42:35', NULL, NULL);
INSERT INTO `produk` VALUES (72, 2, 0, '', NULL, 'P000072', 'LEM LIQUID BESAR POVINAL', 'POVINAL', 0, 5000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-28 03:46:53', '2021-12-28 03:46:53', NULL, NULL);
INSERT INTO `produk` VALUES (73, 2, 0, '', NULL, 'P000073', 'LEM LIQUID KECIL POVINAL', 'POVINAL', 0, 3000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-28 03:48:40', '2021-12-28 03:48:40', NULL, NULL);
INSERT INTO `produk` VALUES (74, 2, 0, '', NULL, 'P000074', 'LEM GLUKOL KECIL', 'GLUKOL', 0, 1000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-28 04:16:02', '2021-12-28 04:16:02', NULL, NULL);
INSERT INTO `produk` VALUES (75, 2, 0, '', NULL, 'P000075', 'TISU SAKU', 'FANCY', 0, 1000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-28 04:17:16', '2021-12-28 04:17:16', NULL, NULL);
INSERT INTO `produk` VALUES (76, 2, 0, '', NULL, 'P000076', 'LAKBAN BENING DAIMARU', 'DAIMARU', 0, 15000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-28 04:26:35', '2021-12-28 04:26:35', NULL, NULL);
INSERT INTO `produk` VALUES (77, 2, 0, '', NULL, 'P000077', 'LAKBAN LINEN HITAM DAIMARU', 'DAIMARU', 0, 20000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-28 04:31:32', '2021-12-28 04:31:32', NULL, NULL);
INSERT INTO `produk` VALUES (78, 2, 0, '', NULL, 'P000078', 'DOUBLE TAPE NACHI  12 MM', 'NACHI', 0, 5000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-28 04:35:30', '2021-12-28 04:35:30', NULL, NULL);
INSERT INTO `produk` VALUES (79, 2, 0, '', NULL, 'P000079', 'ISOLASI MOTIF FANCY', 'FANCY', 0, 1000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-28 04:37:33', '2021-12-28 04:37:33', NULL, NULL);
INSERT INTO `produk` VALUES (80, 2, 0, '', NULL, 'P000080', 'BUKU TULIS SIDU 38 LEMBAR', 'SIDU 38 L', 0, 3000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-28 04:44:35', '2021-12-28 05:20:47', NULL, NULL);
INSERT INTO `produk` VALUES (81, 2, 0, '', NULL, 'P000081', 'NOTA KONTAN 2 PLY', 'PAPERLINE', 0, 5000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-28 04:53:20', '2021-12-28 04:54:30', NULL, NULL);
INSERT INTO `produk` VALUES (82, 2, 0, '', NULL, 'P000082', 'NOTA KONTAN 3 PLY', 'FORTE', 0, 5000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-28 04:54:11', '2021-12-28 04:54:11', NULL, NULL);
INSERT INTO `produk` VALUES (83, 2, 0, '', NULL, 'P000083', 'KWITANSI MINI 40 SHEETS', 'PAPERLINE', 0, 3000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-28 04:55:45', '2021-12-28 04:55:45', NULL, NULL);
INSERT INTO `produk` VALUES (84, 2, 0, '', NULL, 'P000084', 'PAPERCLIP NO.3 SEAGULL', 'SEA GULL', 0, 4000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-28 05:02:13', '2021-12-28 05:02:13', NULL, NULL);
INSERT INTO `produk` VALUES (85, 2, 0, '', NULL, 'P000085', 'STAPLES GW NO.10', 'GREAT WALL', 0, 2000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-28 05:03:29', '2021-12-28 05:03:29', NULL, NULL);
INSERT INTO `produk` VALUES (86, 2, 0, '', NULL, 'P000086', 'SAMPUL BENING KWARTO', 'JERSY KWARTO', 0, 1000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-28 05:04:38', '2021-12-28 05:04:38', NULL, NULL);
INSERT INTO `produk` VALUES (87, 2, 0, '', NULL, 'P000087', 'PELUBANG KERTAS V-TEC NO.30', 'PUNCH', 0, 15000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-28 05:08:10', '2021-12-28 05:08:10', NULL, NULL);
INSERT INTO `produk` VALUES (88, 2, 0, '', NULL, 'P000088', 'FOLIO BERGARIS', 'SIDU', 0, 4500, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-28 05:14:33', '2021-12-28 05:14:33', NULL, NULL);
INSERT INTO `produk` VALUES (89, 2, 0, '', NULL, 'P000089', 'BUKU TULIS VISION 38 LEMBAR', 'VISION', 0, 2500, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-28 05:21:26', '2021-12-28 05:21:26', NULL, NULL);
INSERT INTO `produk` VALUES (90, 2, 0, '', NULL, 'P000090', 'BUKU TULIS SIDU 58 LEMBAR', 'SIDU', 0, 5000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-28 05:32:01', '2021-12-28 05:32:01', NULL, NULL);
INSERT INTO `produk` VALUES (91, 2, 0, '', NULL, 'P000091', 'BUKU TULIS MATEMATIKA 38 LEMBAR', 'SIDU', 0, 3000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-28 05:48:26', '2021-12-28 05:48:26', NULL, NULL);
INSERT INTO `produk` VALUES (92, 2, 0, '', NULL, 'P000092', 'BUKU TULIS KOTAK SIDU 38 LEMBAR', 'SIDU', 0, 4000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-28 05:55:58', '2021-12-28 05:55:58', NULL, NULL);
INSERT INTO `produk` VALUES (93, 2, 0, '', NULL, 'P000093', 'BUKU TULIS KOTAK MATEMATIKA SIDU 38 LEMBAR', 'SIDU', 0, 3500, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-28 05:57:03', '2021-12-28 05:57:03', NULL, NULL);
INSERT INTO `produk` VALUES (94, 2, 0, '', NULL, 'P000094', 'BUKU GAMBAR A4 SIDU', 'SIDU', 0, 4000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-28 06:14:46', '2021-12-28 06:14:46', NULL, NULL);
INSERT INTO `produk` VALUES (95, 2, 0, '', NULL, 'P000095', 'BUKU GAMBAR A4 KIKY', 'KIKY', 0, 5000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-28 06:24:54', '2021-12-28 06:25:48', NULL, NULL);
INSERT INTO `produk` VALUES (96, 2, 0, '', NULL, 'P000096', 'BUKU GAMBAR SD A4 SIDU', 'SIDU', 0, 4000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-28 06:32:58', '2021-12-28 06:32:58', NULL, NULL);
INSERT INTO `produk` VALUES (97, 2, 0, '', NULL, 'P000097', 'STAPLES BESAR NO.3', 'ETONA', 0, 3500, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-28 07:04:50', '2021-12-28 07:04:50', NULL, NULL);
INSERT INTO `produk` VALUES (98, 2, 0, '', NULL, 'P000098', 'STOPMAP FOLIO KERTAS', 'SABANG MERAUKE', 0, 1000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-28 07:13:20', '2021-12-29 03:02:59', NULL, NULL);
INSERT INTO `produk` VALUES (99, 2, 0, '', NULL, 'P000099', 'AMPLOP COKLAT KANCING', 'KIKY', 0, 2000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-28 07:15:58', '2021-12-28 07:15:58', NULL, NULL);
INSERT INTO `produk` VALUES (100, 2, 0, '', NULL, 'P000100', 'BUKU TABUNGAN', 'TUT WURI HANDAYANI', 0, 1000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-28 07:18:29', '2021-12-28 07:19:00', NULL, NULL);
INSERT INTO `produk` VALUES (101, 2, 0, '', NULL, 'P000101', 'BUKU FOLIO BESAR BATIK WARNA', 'PAPERLINE', 0, 20000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-28 07:22:13', '2021-12-28 07:22:13', NULL, NULL);
INSERT INTO `produk` VALUES (102, 2, 0, '', NULL, 'P000102', 'BUKU FOLIO BESAR BATIK COKLAT', 'KIKY', 0, 20000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-28 07:22:48', '2021-12-29 03:12:44', NULL, NULL);
INSERT INTO `produk` VALUES (103, 2, 0, '', NULL, 'P000103', 'BUKU FOLIO KAS', 'KIKY', 0, 25000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-28 07:28:34', '2021-12-28 07:28:34', NULL, NULL);
INSERT INTO `produk` VALUES (104, 2, 0, '', NULL, 'P000104', 'BUKU GAMBAR A3 SIDU', 'SIDU', 0, 9000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-28 07:31:06', '2021-12-28 07:31:06', NULL, NULL);
INSERT INTO `produk` VALUES (105, 2, 0, '', NULL, 'P000105', 'BUKU KEWARTO KAS', 'KIKY', 0, 15000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-28 07:33:27', '2021-12-28 07:33:27', NULL, NULL);
INSERT INTO `produk` VALUES (106, 2, 0, '', NULL, 'P000106', 'BUKU KWARTO 50', 'KIKY', 0, 12000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-28 07:34:35', '2021-12-28 07:34:35', NULL, NULL);
INSERT INTO `produk` VALUES (107, 2, 0, '', NULL, 'P000107', 'PAPAN CLIPBOARD MOTIF', 'FANCY', 0, 12000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-28 07:37:20', '2021-12-28 07:37:20', NULL, NULL);
INSERT INTO `produk` VALUES (108, 2, 0, '', NULL, 'P000108', 'PAPAN CLIPBOARD POLOS', 'REBECCA', 0, 15000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-28 07:38:09', '2021-12-28 07:38:09', NULL, NULL);
INSERT INTO `produk` VALUES (109, 2, 0, '', NULL, 'P000109', 'STOPMAP KACING', 'IMCO', 0, 6000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-28 07:43:04', '2021-12-29 03:05:47', NULL, NULL);
INSERT INTO `produk` VALUES (110, 2, 0, '', NULL, 'P000110', 'KERTAS A4 80 ORANGE', 'SIDU', 0, 50000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-28 07:46:03', '2021-12-28 07:46:03', NULL, NULL);
INSERT INTO `produk` VALUES (111, 2, 0, '', NULL, 'P000111', 'KERTAS KADO MOTIF BUAH', 'MOTIF BUAH', 0, 1500, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-28 07:49:47', '2021-12-28 07:49:47', NULL, NULL);
INSERT INTO `produk` VALUES (112, 2, 0, '', NULL, 'P000112', 'KERTAS KADO BATIK', 'MOTIF BATIK', 0, 1000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-28 07:50:45', '2021-12-28 07:50:45', NULL, NULL);
INSERT INTO `produk` VALUES (113, 2, 0, '', NULL, 'P000113', 'PLATIK BUNGA', 'BUNGA BENING', 0, 1000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-28 07:51:19', '2021-12-28 07:51:19', NULL, NULL);
INSERT INTO `produk` VALUES (114, 2, 0, '', NULL, 'P000114', 'KERTAS F4 75 BIRU', 'PHYTON CPR', 0, 50000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-29 05:30:25', '2021-12-29 05:32:20', NULL, NULL);
INSERT INTO `produk` VALUES (115, 2, 0, '', NULL, 'P000115', 'KERTAS A4 75 BIRU', 'PPO', 0, 45000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-29 05:32:02', '2021-12-29 05:32:02', NULL, NULL);
INSERT INTO `produk` VALUES (116, 2, 0, '', NULL, 'P000116', 'KERTAS DUPLEK 350 GR', 'NOMERK', 0, 8500, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-29 05:33:53', '2021-12-29 05:33:53', NULL, NULL);
INSERT INTO `produk` VALUES (117, 2, 0, '', NULL, 'P000117', 'KERTAS MANILA PUTIH', 'NOMERK', 0, 2500, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-29 05:34:24', '2021-12-29 05:34:24', NULL, NULL);
INSERT INTO `produk` VALUES (118, 2, 0, '', NULL, 'P000118', 'KERTAS MINYAK', 'NOMERK', 0, 1500, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-29 05:35:21', '2021-12-29 05:35:21', NULL, NULL);
INSERT INTO `produk` VALUES (119, 2, 0, '', NULL, 'P000119', 'KERTAS SUKUN', 'NOMERK', 0, 1500, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-29 05:36:18', '2021-12-29 05:36:18', NULL, NULL);
INSERT INTO `produk` VALUES (120, 2, 0, '', NULL, 'P000120', 'CUTTER KECIL SC-9A', 'GUNINCO', 0, 5000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-29 06:03:55', '2021-12-29 06:03:55', NULL, NULL);
INSERT INTO `produk` VALUES (121, 2, 0, '', NULL, 'P000121', 'CUTTER BESAR A-18', 'GUNINCO', 0, 7000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-29 06:04:53', '2021-12-29 06:04:53', NULL, NULL);
INSERT INTO `produk` VALUES (122, 2, 0, '', NULL, 'P000122', 'MIKA JILID COVER KUNING', 'SINGA KEMBAR', 0, 500, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-29 06:07:54', '2021-12-29 06:07:54', NULL, NULL);
INSERT INTO `produk` VALUES (123, 2, 0, '', NULL, 'P000123', 'LAKBAN COKLAT', 'NO MERK', 0, 8000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-29 06:09:42', '2021-12-29 06:09:42', NULL, NULL);
INSERT INTO `produk` VALUES (124, 2, 0, '', NULL, 'P000124', 'MATERAN KAIN', 'CHINA', 0, 2500, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-29 06:11:31', '2021-12-29 06:11:31', NULL, NULL);
INSERT INTO `produk` VALUES (125, 2, 0, '', NULL, 'P000125', 'AMPLOP COKLAT PANJANG', 'NO MERK', 0, 5000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-29 06:45:56', '2021-12-29 06:45:56', NULL, NULL);
INSERT INTO `produk` VALUES (126, 2, 0, '', NULL, 'P000126', 'KWITANSI BESAR 40 SHEETS', 'PAPERLINE', 0, 5000, '', 1, 1, 0, 'master', 'tunggal', NULL, NULL, 1, '2021-12-29 06:58:12', '2021-12-29 06:58:12', NULL, NULL);

-- ----------------------------
-- Table structure for produk_additional
-- ----------------------------
DROP TABLE IF EXISTS `produk_additional`;
CREATE TABLE `produk_additional`  (
  `id_produk_additional` bigint NOT NULL AUTO_INCREMENT,
  `id_produk_master` int NOT NULL,
  `id_produk_detail` int NOT NULL,
  `group` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama_additional` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `harga_jual` float NULL DEFAULT NULL,
  PRIMARY KEY (`id_produk_additional`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of produk_additional
-- ----------------------------

-- ----------------------------
-- Table structure for produk_komposit
-- ----------------------------
DROP TABLE IF EXISTS `produk_komposit`;
CREATE TABLE `produk_komposit`  (
  `id_produk_komposit` bigint NOT NULL AUTO_INCREMENT,
  `id_produk_master` int NULL DEFAULT NULL,
  `id_produk_detail` int NULL DEFAULT NULL,
  `nama_komposit` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `jumlah_komposit` float NULL DEFAULT NULL,
  PRIMARY KEY (`id_produk_komposit`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of produk_komposit
-- ----------------------------

-- ----------------------------
-- Table structure for purchases
-- ----------------------------
DROP TABLE IF EXISTS `purchases`;
CREATE TABLE `purchases`  (
  `po_id` int NULL DEFAULT NULL,
  `sku` int NULL DEFAULT NULL,
  `purchase_date` datetime NULL DEFAULT NULL,
  `price` int NULL DEFAULT NULL,
  `qty` int NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of purchases
-- ----------------------------
INSERT INTO `purchases` VALUES (1, 123, '2017-01-01 12:25:00', 20, 5);
INSERT INTO `purchases` VALUES (2, 123, '2017-05-01 15:45:00', 18, 3);
INSERT INTO `purchases` VALUES (3, 123, '2017-05-02 12:00:00', 15, 1);
INSERT INTO `purchases` VALUES (4, 456, '2013-06-10 16:00:00', 60, 7);

-- ----------------------------
-- Table structure for sales
-- ----------------------------
DROP TABLE IF EXISTS `sales`;
CREATE TABLE `sales`  (
  `sale_id` int NULL DEFAULT NULL,
  `sku` int NULL DEFAULT NULL,
  `sale_date` datetime NULL DEFAULT NULL,
  `price` int NULL DEFAULT NULL,
  `qty` int NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of sales
-- ----------------------------
INSERT INTO `sales` VALUES (1, 123, '2017-01-15 11:00:00', 30, 1);
INSERT INTO `sales` VALUES (2, 123, '2017-01-20 14:00:00', 28, 3);
INSERT INTO `sales` VALUES (3, 123, '2017-05-10 15:00:00', 25, 2);
INSERT INTO `sales` VALUES (4, 456, '2017-06-11 12:00:00', 80, 1);

-- ----------------------------
-- Table structure for sessions
-- ----------------------------
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions`  (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NULL DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `payload` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `sessions_user_id_index`(`user_id`) USING BTREE,
  INDEX `sessions_last_activity_index`(`last_activity`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of sessions
-- ----------------------------
INSERT INTO `sessions` VALUES ('qWHjy2rMRE2hyvFmWdSa9dbi5iNNXARNNGtkx9Fe', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.71 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiUzlXSmxwMUgxUTRJekdNWXVDUkpFWEk4TjQwZkVXNEsxeVFYQ1Y4byI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzU6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9wcm9kdWsvY3JlYXRlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo2OiJvdXRsZXQiO3M6MToiMSI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2MDoiJDJ5JDEwJGh4VHZGWVNoT1hTZmZlWTVFdzRDdGUuVm5xdkpCM1p0VC51ckF1VGFnTUNoZzZESUNRT1hHIjt9', 1642676354);

-- ----------------------------
-- Table structure for setting
-- ----------------------------
DROP TABLE IF EXISTS `setting`;
CREATE TABLE `setting`  (
  `id_setting` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_perusahaan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `telepon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipe_nota` tinyint NOT NULL,
  `diskon` smallint NOT NULL DEFAULT 0,
  `min_stok` float NULL DEFAULT 0,
  `path_logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `path_kartu_member` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `gudang_prioritas` bigint NULL DEFAULT NULL,
  `dark_mode` int NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_setting`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of setting
-- ----------------------------
INSERT INTO `setting` VALUES (1, 'Toko Bumdes', 'Jl. Ledokombo', '08888', 1, 0, 1, '/img/logo-20220119071636.png', '/img/member.png', 2, 0, NULL, '2022-01-20 10:59:03');

-- ----------------------------
-- Table structure for stok_produk
-- ----------------------------
DROP TABLE IF EXISTS `stok_produk`;
CREATE TABLE `stok_produk`  (
  `id_stok_produk` bigint NOT NULL AUTO_INCREMENT,
  `id_gudang` bigint NOT NULL,
  `kode` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `catatan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `tanggal` date NOT NULL,
  `jenis` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `reference` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` int NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `updated_by` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_stok_produk`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 51 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of stok_produk
-- ----------------------------
INSERT INTO `stok_produk` VALUES (1, 2, 'ST-M-0001', 'syahril test insert stok masuk', '2022-01-10', 'MASUK', 'STOKMASUK', 0, '2022-01-10 04:19:13', NULL, 'Administrator', NULL);
INSERT INTO `stok_produk` VALUES (3, 2, 'ST-M-0003', 'tes harga', '2022-01-10', 'MASUK', 'STOKMASUK', 1, '2022-01-10 09:03:34', NULL, 'Administrator', NULL);
INSERT INTO `stok_produk` VALUES (4, 2, 'ST-M-0004', 'gelombang toppas ke 2', '2022-01-01', 'MASUK', 'STOKMASUK', 1, '2022-01-10 09:23:16', NULL, 'Administrator', NULL);
INSERT INTO `stok_produk` VALUES (5, 2, 'ST-K-0005', 'tess keluar', '2022-01-10', 'KELUAR', 'STOKKELUAR', 0, '2022-01-10 13:21:22', NULL, 'Administrator', NULL);
INSERT INTO `stok_produk` VALUES (6, 2, 'ST-K-0006', 'tes 2', '2022-01-10', 'KELUAR', 'STOKKELUAR', 0, '2022-01-10 13:24:36', NULL, 'Administrator', NULL);
INSERT INTO `stok_produk` VALUES (7, 2, 'ST-K-0007', 'revisi', '2022-01-11', 'KELUAR', 'STOKKELUAR', 0, '2022-01-10 13:33:29', NULL, 'Administrator', NULL);
INSERT INTO `stok_produk` VALUES (8, 2, 'ST-K-0008', 'tes code', '2022-01-10', 'KELUAR', 'STOKKELUAR', 0, '2022-01-10 13:52:37', NULL, 'Administrator', NULL);
INSERT INTO `stok_produk` VALUES (9, 2, 'ST-K-0009', 'tes code', '2022-01-10', 'KELUAR', 'STOKKELUAR', 1, '2022-01-10 13:53:37', NULL, 'Administrator', NULL);
INSERT INTO `stok_produk` VALUES (10, 2, 'ST-K-0010', 'tes', '2022-01-10', 'KELUAR', 'STOKKELUAR', 0, '2022-01-11 11:14:09', NULL, 'Administrator', NULL);
INSERT INTO `stok_produk` VALUES (11, 2, 'ST-K-0011', NULL, '2022-01-11', 'KELUAR', 'STOKKELUAR', 1, '2022-01-11 11:16:00', NULL, 'Administrator', NULL);
INSERT INTO `stok_produk` VALUES (27, 2, 'ST-O-0001', NULL, '2022-01-12', 'OPNAME', 'STOKOPNAME', 0, '2022-01-12 03:44:16', NULL, 'Administrator', NULL);
INSERT INTO `stok_produk` VALUES (28, 2, 'ST-O-0002', NULL, '2022-01-12', 'OPNAME', 'STOKOPNAME', 0, '2022-01-12 03:45:13', NULL, 'Administrator', NULL);
INSERT INTO `stok_produk` VALUES (29, 2, 'ST-O-0003', NULL, '2022-01-12', 'OPNAME', 'STOKOPNAME', 0, '2022-01-12 03:46:00', NULL, 'Administrator', NULL);
INSERT INTO `stok_produk` VALUES (30, 2, 'ST-O-0004', NULL, '2022-01-12', 'OPNAME', 'STOKOPNAME', 0, '2022-01-12 03:47:04', NULL, 'Administrator', NULL);
INSERT INTO `stok_produk` VALUES (31, 2, 'ST-O-0005', NULL, '2022-01-12', 'OPNAME', 'STOKOPNAME', 0, '2022-01-12 03:55:12', NULL, 'Administrator', NULL);
INSERT INTO `stok_produk` VALUES (32, 2, 'ST-O-0006', NULL, '2022-01-12', 'OPNAME', 'STOKOPNAME', 1, '2022-01-12 04:01:58', NULL, 'Administrator', NULL);
INSERT INTO `stok_produk` VALUES (33, 2, 'ST-O-0007', NULL, '2022-01-12', 'OPNAME', 'STOKOPNAME', 1, '2022-01-12 04:36:56', NULL, 'Administrator', NULL);
INSERT INTO `stok_produk` VALUES (34, 2, 'ST-O-0008', NULL, '2022-01-12', 'OPNAME', 'STOKOPNAME', 1, '2022-01-12 04:37:49', NULL, 'Administrator', NULL);
INSERT INTO `stok_produk` VALUES (36, 2, 'ST-B-0009', NULL, '2022-01-12', 'PEMBELIAN', 'STOKPEMBELIAN', 1, '2022-01-12 08:15:27', NULL, 'Administrator', NULL);
INSERT INTO `stok_produk` VALUES (38, 2, 'ST-P-0009', NULL, '2022-01-12', 'PENJUALAN', 'STOKPENJUALAN', 1, '2022-01-12 08:45:33', NULL, 'Administrator', NULL);
INSERT INTO `stok_produk` VALUES (39, 2, 'ST-M-0010', NULL, '2022-01-12', 'MASUK', 'STOKMASUK', 1, '2022-01-12 09:07:25', NULL, 'Administrator', NULL);
INSERT INTO `stok_produk` VALUES (40, 2, 'ST-P-0010', NULL, '2022-01-13', 'PENJUALAN', 'STOKPENJUALAN', 1, '2022-01-13 10:54:18', NULL, 'Administrator', NULL);
INSERT INTO `stok_produk` VALUES (41, 2, 'ST-O-0009', NULL, '2022-01-13', 'OPNAME', 'STOKOPNAME', 1, '2022-01-13 10:57:15', NULL, 'Administrator', NULL);
INSERT INTO `stok_produk` VALUES (42, 2, 'ST-M-0011', NULL, '2022-01-14', 'MASUK', 'STOKMASUK', 1, '2022-01-14 04:05:14', NULL, 'Administrator', NULL);
INSERT INTO `stok_produk` VALUES (43, 2, 'ST-K-0012', 'tes', '2022-01-14', 'KELUAR', 'STOKKELUAR', 0, '2022-01-14 06:59:22', NULL, 'Administrator', NULL);
INSERT INTO `stok_produk` VALUES (44, 2, 'ST-O-0010', NULL, '2022-01-14', 'OPNAME', 'STOKOPNAME', 0, '2022-01-14 07:26:20', NULL, 'Administrator', NULL);
INSERT INTO `stok_produk` VALUES (45, 2, 'ST-B-0011', NULL, '2022-01-14', 'PEMBELIAN', 'STOKPEMBELIAN', 1, '2022-01-14 08:26:06', NULL, 'Administrator', NULL);
INSERT INTO `stok_produk` VALUES (46, 2, 'ST-B-0011', NULL, '2022-01-14', 'PEMBELIAN', 'STOKPEMBELIAN', 1, '2022-01-14 08:40:17', NULL, 'Administrator', NULL);
INSERT INTO `stok_produk` VALUES (47, 2, 'ST-B-0011', NULL, '2022-01-14', 'PEMBELIAN', 'STOKPEMBELIAN', 1, '2022-01-14 08:45:30', NULL, 'Administrator', NULL);
INSERT INTO `stok_produk` VALUES (48, 2, 'ST-P-0011', NULL, '2022-01-16', 'PENJUALAN', 'STOKPENJUALAN', 1, '2022-01-16 02:53:06', NULL, 'Administrator', NULL);
INSERT INTO `stok_produk` VALUES (49, 2, 'ST-P-0012', NULL, '2022-01-16', 'PENJUALAN', 'STOKPENJUALAN', 1, '2022-01-16 02:56:47', NULL, 'Administrator', NULL);
INSERT INTO `stok_produk` VALUES (50, 2, 'ST-O-0011', NULL, '2022-01-17', 'OPNAME', 'STOKOPNAME', 1, '2022-01-17 06:34:57', NULL, 'Administrator', NULL);

-- ----------------------------
-- Table structure for stok_produk_detail
-- ----------------------------
DROP TABLE IF EXISTS `stok_produk_detail`;
CREATE TABLE `stok_produk_detail`  (
  `id_stok_produk_detail` bigint NOT NULL AUTO_INCREMENT,
  `id_produk` int NOT NULL,
  `nilai` float NOT NULL,
  `jenis` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `harga` bigint NOT NULL DEFAULT 0,
  `sub_total` bigint NOT NULL DEFAULT 0,
  `sumber` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id_reference` bigint NOT NULL,
  `kode_reference` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_stok_produk_detail`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 77 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of stok_produk_detail
-- ----------------------------
INSERT INTO `stok_produk_detail` VALUES (1, 4, 0, 'MASUK', 14500, 0, 'stok_produk', 1, 'ST-M-0001');
INSERT INTO `stok_produk_detail` VALUES (2, 14, 0, 'MASUK', 19500, 0, 'stok_produk', 1, 'ST-M-0001');
INSERT INTO `stok_produk_detail` VALUES (3, 98, 0, 'MASUK', 2000, 0, 'stok_produk', 1, 'ST-M-0001');
INSERT INTO `stok_produk_detail` VALUES (7, 4, 10, 'MASUK', 15000, 150000, 'stok_produk', 3, 'ST-M-0003');
INSERT INTO `stok_produk_detail` VALUES (8, 14, 5, 'MASUK', 20000, 100000, 'stok_produk', 3, 'ST-M-0003');
INSERT INTO `stok_produk_detail` VALUES (9, 4, 10, 'MASUK', 14500, 145000, 'stok_produk', 4, 'ST-M-0004');
INSERT INTO `stok_produk_detail` VALUES (10, 4, 0, 'KELUAR', 14750, 0, 'stok_produk', 5, 'ST-K-0005');
INSERT INTO `stok_produk_detail` VALUES (11, 14, 0, 'KELUAR', -20000, 0, 'stok_produk', 5, 'ST-K-0005');
INSERT INTO `stok_produk_detail` VALUES (12, 4, 0, 'KELUAR', 14750, 0, 'stok_produk', 6, 'ST-K-0006');
INSERT INTO `stok_produk_detail` VALUES (13, 4, 0, 'KELUAR', 14750, 0, 'stok_produk', 7, 'ST-K-0007');
INSERT INTO `stok_produk_detail` VALUES (14, 4, 0, 'KELUAR', 14750, 0, 'stok_produk', 8, 'ST-K-0008');
INSERT INTO `stok_produk_detail` VALUES (15, 4, -6, 'KELUAR', 14750, -88500, 'stok_produk', 9, 'ST-K-0009');
INSERT INTO `stok_produk_detail` VALUES (16, 4, 0, 'KELUAR', 14750, 0, 'stok_produk', 10, 'ST-K-0010');
INSERT INTO `stok_produk_detail` VALUES (17, 4, -10, 'KELUAR', 14750, -147500, 'stok_produk', 11, 'ST-K-0011');
INSERT INTO `stok_produk_detail` VALUES (39, 4, 0, 'KELUAR', 14750, 0, 'stok_produk', 27, 'ST-O-0001');
INSERT INTO `stok_produk_detail` VALUES (40, 4, 0, 'KELUAR', 14750, 0, 'stok_produk', 28, 'ST-O-0002');
INSERT INTO `stok_produk_detail` VALUES (41, 4, 0, 'KELUAR', 14750, 0, 'stok_produk', 29, 'ST-O-0003');
INSERT INTO `stok_produk_detail` VALUES (42, 4, 0, 'MASUK', 14750, 0, 'stok_produk', 30, 'ST-O-0004');
INSERT INTO `stok_produk_detail` VALUES (43, 4, 0, 'MASUK', 14750, 0, 'stok_produk', 31, 'ST-O-0005');
INSERT INTO `stok_produk_detail` VALUES (44, 4, 1, 'MASUK', 14750, 14750, 'stok_produk', 32, 'ST-O-0006');
INSERT INTO `stok_produk_detail` VALUES (45, 4, -1, 'KELUAR', 14750, -14750, 'stok_produk', 33, 'ST-O-0007');
INSERT INTO `stok_produk_detail` VALUES (46, 4, 2, 'MASUK', 14750, 29500, 'stok_produk', 34, 'ST-O-0008');
INSERT INTO `stok_produk_detail` VALUES (47, 14, -2, 'KELUAR', 20000, -40000, 'stok_produk', 34, 'ST-O-0008');
INSERT INTO `stok_produk_detail` VALUES (50, 4, 5, 'MASUK', 15500, 77500, 'stok_produk', 36, 'ST-B-0009');
INSERT INTO `stok_produk_detail` VALUES (51, 14, 5, 'MASUK', 20500, 102500, 'stok_produk', 36, 'ST-B-0009');
INSERT INTO `stok_produk_detail` VALUES (52, 11, 5, 'MASUK', 20000, 100000, 'stok_produk', 36, 'ST-B-0009');
INSERT INTO `stok_produk_detail` VALUES (53, 4, -15, 'KELUAR', 15091, -226364, 'stok_produk', 38, 'ST-P-0009');
INSERT INTO `stok_produk_detail` VALUES (54, 4, 10, 'MASUK', 15500, 155000, 'stok_produk', 39, 'ST-M-0010');
INSERT INTO `stok_produk_detail` VALUES (55, 4, -2, 'KELUAR', 15773, -31545, 'stok_produk', 40, 'ST-P-0010');
INSERT INTO `stok_produk_detail` VALUES (56, 4, -1, 'KELUAR', 15773, -15773, 'stok_produk', 41, 'ST-O-0009');
INSERT INTO `stok_produk_detail` VALUES (57, 4, 2, 'MASUK', 10000, 20000, 'stok_produk', 42, 'ST-M-0011');
INSERT INTO `stok_produk_detail` VALUES (58, 4, 0, 'KELUAR', 13464, 0, 'stok_produk', 43, 'ST-K-0012');
INSERT INTO `stok_produk_detail` VALUES (59, 4, 0, 'MASUK', 13464, 0, 'stok_produk', 44, 'ST-O-0010');
INSERT INTO `stok_produk_detail` VALUES (60, 14, 0, 'KELUAR', 20313, 0, 'stok_produk', 44, 'ST-O-0010');
INSERT INTO `stok_produk_detail` VALUES (61, 4, 3, 'MASUK', 20000, 60000, 'stok_produk', 45, 'ST-B-0011');
INSERT INTO `stok_produk_detail` VALUES (62, 4, 5, 'MASUK', 16500, 82500, 'stok_produk', 46, 'ST-B-0011');
INSERT INTO `stok_produk_detail` VALUES (63, 14, 5, 'MASUK', 21500, 107500, 'stok_produk', 46, 'ST-B-0011');
INSERT INTO `stok_produk_detail` VALUES (64, 11, 5, 'MASUK', 21000, 105000, 'stok_produk', 46, 'ST-B-0011');
INSERT INTO `stok_produk_detail` VALUES (65, 22, 5, 'MASUK', 18500, 92500, 'stok_produk', 46, 'ST-B-0011');
INSERT INTO `stok_produk_detail` VALUES (66, 25, 5, 'MASUK', 17000, 85000, 'stok_produk', 46, 'ST-B-0011');
INSERT INTO `stok_produk_detail` VALUES (67, 4, 2, 'MASUK', 16000, 32000, 'stok_produk', 47, 'ST-B-0011');
INSERT INTO `stok_produk_detail` VALUES (68, 14, 3, 'MASUK', 21000, 63000, 'stok_produk', 47, 'ST-B-0011');
INSERT INTO `stok_produk_detail` VALUES (69, 11, 2, 'MASUK', 20600, 41200, 'stok_produk', 47, 'ST-B-0011');
INSERT INTO `stok_produk_detail` VALUES (70, 22, 3, 'MASUK', 18600, 55800, 'stok_produk', 47, 'ST-B-0011');
INSERT INTO `stok_produk_detail` VALUES (71, 25, 5, 'MASUK', 17000, 85000, 'stok_produk', 47, 'ST-B-0011');
INSERT INTO `stok_produk_detail` VALUES (72, 4, -3, 'KELUAR', 16121, -48364, 'stok_produk', 48, 'ST-P-0011');
INSERT INTO `stok_produk_detail` VALUES (73, 14, -2, 'KELUAR', 20813, -41625, 'stok_produk', 48, 'ST-P-0011');
INSERT INTO `stok_produk_detail` VALUES (74, 4, -1, 'KELUAR', 16121, -16121, 'stok_produk', 49, 'ST-P-0012');
INSERT INTO `stok_produk_detail` VALUES (75, 4, 0, 'MASUK', 16121, 0, 'stok_produk', 50, 'ST-O-0011');
INSERT INTO `stok_produk_detail` VALUES (76, 14, 0, 'MASUK', 20813, 0, 'stok_produk', 50, 'ST-O-0011');

-- ----------------------------
-- Table structure for supplier
-- ----------------------------
DROP TABLE IF EXISTS `supplier`;
CREATE TABLE `supplier`  (
  `id_supplier` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `telepon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_supplier`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of supplier
-- ----------------------------
INSERT INTO `supplier` VALUES (3, 'TOKO ARDIAN', 'Jalan Stasiun Sumberlesung Kecamatan Ledokombo', '082226426388', '2021-12-27 02:08:18', '2021-12-27 02:08:18');
INSERT INTO `supplier` VALUES (4, 'PRIMA STATIONERY', 'Jalan Gatot Subroto No.72 JEMBER', '467009485290', '2021-12-27 02:10:09', '2021-12-27 02:10:09');

-- ----------------------------
-- Table structure for team_invitations
-- ----------------------------
DROP TABLE IF EXISTS `team_invitations`;
CREATE TABLE `team_invitations`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `team_id` bigint UNSIGNED NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `team_invitations_team_id_email_unique`(`team_id`, `email`) USING BTREE,
  CONSTRAINT `team_invitations_team_id_foreign` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of team_invitations
-- ----------------------------

-- ----------------------------
-- Table structure for team_user
-- ----------------------------
DROP TABLE IF EXISTS `team_user`;
CREATE TABLE `team_user`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `team_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `team_user_team_id_user_id_unique`(`team_id`, `user_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of team_user
-- ----------------------------

-- ----------------------------
-- Table structure for teams
-- ----------------------------
DROP TABLE IF EXISTS `teams`;
CREATE TABLE `teams`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_team` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `teams_user_id_index`(`user_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of teams
-- ----------------------------

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `level` tinyint NOT NULL DEFAULT 0,
  `two_factor_secret` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `two_factor_recovery_codes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `current_team_id` bigint UNSIGNED NULL DEFAULT NULL,
  `profile_photo_path` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_email_unique`(`email`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'Administrator', 'admin@gmail.com', NULL, '$2y$10$hxTvFYShOXSffeY5Ew4Cte.VnqvJB3ZtT.urAuTagMChg6DICQOXG', '/img/logo-20220119101629.jpg', 1, NULL, NULL, NULL, NULL, NULL, '2021-12-25 09:05:56', '2022-01-19 10:16:29');
INSERT INTO `users` VALUES (2, 'Kasir 1', 'kasir1@gmail.com', NULL, '$2y$10$1KH.KxV0AOjKRuCQNM8omOPja/5DYqu0CUkMp3oA5e7obUU9ywGzS', '/img/user.jpg', 2, NULL, NULL, NULL, NULL, NULL, '2021-12-25 09:05:56', '2021-12-25 09:05:56');

SET FOREIGN_KEY_CHECKS = 1;
