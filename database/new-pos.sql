/*
 Navicat Premium Data Transfer

 Source Server         : LOCAL - MYSQL
 Source Server Type    : MySQL
 Source Server Version : 100421
 Source Host           : localhost:3306
 Source Schema         : new-pos

 Target Server Type    : MySQL
 Target Server Version : 100421
 File Encoding         : 65001

 Date: 26/02/2022 10:36:19
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for add_opt
-- ----------------------------
DROP TABLE IF EXISTS `add_opt`;
CREATE TABLE `add_opt`  (
  `id_add_opt` int NOT NULL AUTO_INCREMENT,
  `id_outlet` int NOT NULL,
  `nama_add_opt` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `punya_bahan_baku` int NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_add_opt`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of add_opt
-- ----------------------------
INSERT INTO `add_opt` VALUES (1, 1, 'Pelengkap Kopi', 0, '2022-01-20 23:31:46', 'Administrator', NULL, NULL);
INSERT INTO `add_opt` VALUES (2, 1, 'Topping Seblak', 1, '2022-01-20 23:41:57', 'Administrator', NULL, NULL);
INSERT INTO `add_opt` VALUES (3, 1, 'Topping Terang Bulan', 1, '2022-01-21 00:23:06', 'Administrator', NULL, NULL);
INSERT INTO `add_opt` VALUES (4, 1, 'Pelengkap Milk Shake', 1, '2022-01-22 22:24:31', 'Administrator', NULL, NULL);
INSERT INTO `add_opt` VALUES (5, 1, 'tes', 1, '2022-01-23 03:34:30', 'Administrator', NULL, NULL);
INSERT INTO `add_opt` VALUES (6, 1, 'Pelengkap Rokok', 0, '2022-01-23 04:13:11', 'Administrator', NULL, NULL);
INSERT INTO `add_opt` VALUES (7, 1, 'testing insert opsi tambahan (edit)', 1, '2022-01-27 00:24:48', 'Administrator', '2022-01-27 00:59:02', 'Administrator');
INSERT INTO `add_opt` VALUES (8, 1, 'Toping Serabi', 1, '2022-01-27 03:30:53', 'Administrator', NULL, NULL);
INSERT INTO `add_opt` VALUES (9, 1, 'testing outlet', 1, '2022-01-27 08:36:52', 'Administrator', NULL, NULL);

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
) ENGINE = InnoDB AUTO_INCREMENT = 33 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

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
INSERT INTO `add_opt_detail` VALUES (11, 4, 'Boba', 1000);
INSERT INTO `add_opt_detail` VALUES (12, 4, 'Keju', 1000);
INSERT INTO `add_opt_detail` VALUES (13, 4, 'Misis', 1000);
INSERT INTO `add_opt_detail` VALUES (14, 4, 'Ekstra Susu', 1000);
INSERT INTO `add_opt_detail` VALUES (15, 5, 'ss', 12222);
INSERT INTO `add_opt_detail` VALUES (16, 6, 'Korek', 2000);
INSERT INTO `add_opt_detail` VALUES (17, 6, 'Roti', 5000);
INSERT INTO `add_opt_detail` VALUES (27, 7, 'opsi 1', 3000);
INSERT INTO `add_opt_detail` VALUES (28, 7, 'opsi 2', 2000);
INSERT INTO `add_opt_detail` VALUES (29, 8, 'Extra Keju', 2000);
INSERT INTO `add_opt_detail` VALUES (30, 8, 'Extra Coklat', 2000);
INSERT INTO `add_opt_detail` VALUES (31, 8, 'Extra Susu', 2000);
INSERT INTO `add_opt_detail` VALUES (32, 9, 'opsi outlet 1', 1000);

-- ----------------------------
-- Table structure for add_opt_komposit
-- ----------------------------
DROP TABLE IF EXISTS `add_opt_komposit`;
CREATE TABLE `add_opt_komposit`  (
  `id_add_opt_komposit` int NOT NULL AUTO_INCREMENT,
  `id_add_opt` int NOT NULL,
  `id_produk_detail` int NOT NULL,
  `nama_komposit` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `jumlah_komposit` float NOT NULL,
  PRIMARY KEY (`id_add_opt_komposit`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 16 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of add_opt_komposit
-- ----------------------------
INSERT INTO `add_opt_komposit` VALUES (6, 29, 135, 'BAHAN_BAKU_SUSU_UHT_INDOMILK', 0.2);
INSERT INTO `add_opt_komposit` VALUES (7, 29, 137, 'BAHAN_BAKU_GULA', 0.1);
INSERT INTO `add_opt_komposit` VALUES (8, 29, 141, 'BAHAN_BAKU_GARAM', 0.001);
INSERT INTO `add_opt_komposit` VALUES (9, 30, 135, 'BAHAN_BAKU_SUSU_UHT_INDOMILK', 0.2);
INSERT INTO `add_opt_komposit` VALUES (10, 30, 137, 'BAHAN_BAKU_GULA', 0.1);
INSERT INTO `add_opt_komposit` VALUES (11, 31, 135, 'BAHAN_BAKU_SUSU_UHT_INDOMILK', 0.2);
INSERT INTO `add_opt_komposit` VALUES (12, 31, 137, 'BAHAN_BAKU_GULA', 0.1);
INSERT INTO `add_opt_komposit` VALUES (13, 32, 135, 'BAHAN_BAKU_SUSU_UHT_INDOMILK', 0.1);
INSERT INTO `add_opt_komposit` VALUES (14, 32, 137, 'BAHAN_BAKU_GULA', 0.2);
INSERT INTO `add_opt_komposit` VALUES (15, 32, 141, 'BAHAN_BAKU_GARAM', 0.5);

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
INSERT INTO `gudang` VALUES (2, 'GD-0002', 'Gudang Utama', 'Jl. Ledokombo no 2 (kantor desa ledokombo)', '1', '2022-01-08 02:24:39', '2022-01-08 02:36:56', 'Administrator', 'Administrator');

-- ----------------------------
-- Table structure for kas
-- ----------------------------
DROP TABLE IF EXISTS `kas`;
CREATE TABLE `kas`  (
  `id_kas` bigint NOT NULL AUTO_INCREMENT,
  `id_outlet` int NOT NULL,
  `tanggal` date NOT NULL,
  `jam` time NOT NULL,
  `total` float NOT NULL,
  `status` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'OPEN, CLOSE',
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_kas`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of kas
-- ----------------------------

-- ----------------------------
-- Table structure for kas_detail
-- ----------------------------
DROP TABLE IF EXISTS `kas_detail`;
CREATE TABLE `kas_detail`  (
  `id_kas_detail` bigint NOT NULL AUTO_INCREMENT,
  `id_kas` int NOT NULL,
  `jenis` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'KK, KM, SO, PO, SM, KM, SOPN',
  `aliran` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'KELUAR / MASUK',
  `nilai` float NOT NULL,
  `keterangan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_kas_detail`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of kas_detail
-- ----------------------------

-- ----------------------------
-- Table structure for kategori
-- ----------------------------
DROP TABLE IF EXISTS `kategori`;
CREATE TABLE `kategori`  (
  `id_kategori` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_outlet` int NOT NULL,
  `nama_kategori` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_kategori`) USING BTREE,
  UNIQUE INDEX `kategori_nama_kategori_unique`(`nama_kategori`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 19 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of kategori
-- ----------------------------
INSERT INTO `kategori` VALUES (1, 1, 'ROKOK', '2021-12-26 00:38:53', '2021-12-27 17:03:03');
INSERT INTO `kategori` VALUES (2, 1, 'ALAT TULIS KANTOR', '2021-12-26 01:50:24', '2021-12-27 17:02:51');
INSERT INTO `kategori` VALUES (3, 1, 'JASA LAMINATING', '2021-12-27 18:43:08', '2021-12-27 18:43:08');
INSERT INTO `kategori` VALUES (10, 1, 'MINUMAN', NULL, NULL);
INSERT INTO `kategori` VALUES (13, 1, 'BAHAN BAKU', '2022-01-23 00:17:52', NULL);
INSERT INTO `kategori` VALUES (14, 1, 'MAKANAN', '2022-01-26 14:21:14', '2022-01-26 22:30:51');
INSERT INTO `kategori` VALUES (15, 1, 'ALKOHOL', '2022-01-26 07:22:19', '2022-01-26 07:40:42');
INSERT INTO `kategori` VALUES (16, 1, 'TESTING OUTLET 1', '2022-01-27 08:37:08', NULL);
INSERT INTO `kategori` VALUES (17, 1, 'FROOZEN FOOD', '2022-02-02 04:54:16', NULL);
INSERT INTO `kategori` VALUES (18, 1, 'LAPTOP', '2022-02-11 23:17:11', NULL);

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
  `status` int NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_member`) USING BTREE,
  UNIQUE INDEX `member_kode_member_unique`(`kode_member`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of member
-- ----------------------------
INSERT INTO `member` VALUES (3, '00001', 'Syahril Ardi', 'Jl. Raung no. 31 Kalisat Jember', '0877379697', 1, '2022-01-14 17:48:55', '2022-01-14 17:48:55');
INSERT INTO `member` VALUES (4, '00002', 'Dimas Islami', 'Jl. Benowo - Gresik no. 1 Surabaya', '984598669', 1, '2022-01-14 17:49:18', '2022-01-14 17:49:18');
INSERT INTO `member` VALUES (5, '00003', 'Zakaria', 'Sidoarjo', '986296', 0, '2022-01-14 17:49:32', '2022-01-28 19:33:09');
INSERT INTO `member` VALUES (6, 'MBR-000000001', 'Faizah Hikmatul Aulia', 'Jl. Kartini Gg Tangguh No. 2 Ajung Kalisat', '088226066358', 1, '2022-01-28 19:26:28', '2022-01-28 19:26:28');

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
INSERT INTO `outlet` VALUES (1, 'Toko Bumdes', 'Jl. Ledokombo', '08888', 1, '/img/logo-20220122210248.png', '/img/member.png', 1, 0, NULL, NULL, '2022-01-17 22:45:45', NULL);

-- ----------------------------
-- Table structure for outlet_pajak
-- ----------------------------
DROP TABLE IF EXISTS `outlet_pajak`;
CREATE TABLE `outlet_pajak`  (
  `id_outet_pajak` int NOT NULL,
  `id_outlet` int NOT NULL,
  `id_pajak` int NOT NULL,
  PRIMARY KEY (`id_outet_pajak`, `id_outlet`, `id_pajak`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

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
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

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
  `id_outlet` int NOT NULL,
  `kode_pembelian` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_pembelian` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_pembelian` date NULL DEFAULT NULL,
  `total_item` int NOT NULL,
  `total_harga` float NOT NULL,
  `diskon` tinyint NULL DEFAULT 0 COMMENT 'seharusnya tidak dipakai',
  `bayar` int NOT NULL DEFAULT 0,
  `catatan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `status` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT 'DRAFT' COMMENT 'DRAFT, RECEIVED, CANCEL',
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_pembelian`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 32 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of pembelian
-- ----------------------------
INSERT INTO `pembelian` VALUES (22, 4, 1, 'PO-000000001', 'NPO-YNTKTS-000000001', '2022-01-01', 3, 146009, 0, 0, NULL, 'DONE', '2022-01-30 02:52:04', 'Administrator', '2022-01-30 03:34:22', 'Administrator');
INSERT INTO `pembelian` VALUES (23, 3, 1, 'PO-000000002', 'NPO-YNTKTS-000000002', '2022-01-29', 1, 36631.1, 0, 0, 'testing insert purchase order', 'CANCEL', '2022-01-30 02:57:18', 'Administrator', '2022-01-30 03:25:54', 'Administrator');
INSERT INTO `pembelian` VALUES (24, 4, 1, 'PO-000000003', 'NPO-YNTKTS-000000003', '2022-01-29', 3, 114350, 0, 0, NULL, 'DONE', '2022-01-30 03:49:06', 'Administrator', '2022-01-30 03:50:28', 'Administrator');
INSERT INTO `pembelian` VALUES (25, 4, 1, 'PO-000000004', 'NPO-YNTKTS-000000004', '2022-01-01', 3, 180000, 0, 0, 'ok', 'CANCEL', '2022-01-30 03:52:09', 'Administrator', '2022-01-30 03:52:17', 'Administrator');
INSERT INTO `pembelian` VALUES (26, 4, 1, 'PO-000000005', 'NPO-YNTKTS-000000005', '2022-01-29', 3, 170000, 0, 0, 'testing insert simpan & terima barang', 'DONE', '2022-01-30 03:59:30', 'Administrator', NULL, NULL);
INSERT INTO `pembelian` VALUES (27, 4, 1, 'PO-000000006', 'NPO-YNTKTS-000000006', '2022-01-01', 1, 0, 0, 0, NULL, 'CANCEL', '2022-01-30 04:07:05', 'Administrator', '2022-01-30 04:07:27', 'Administrator');
INSERT INTO `pembelian` VALUES (28, 4, 1, 'PO-000000007', 'NPO-YNTKTS-000000007', '2022-01-30', 2, 0, 0, 0, 'testing batalkan', 'CANCEL', '2022-01-31 04:52:14', 'Administrator', '2022-01-31 04:52:29', 'Administrator');
INSERT INTO `pembelian` VALUES (29, 4, 1, 'PO-000000008', 'NPO-YNTKTS-000000008', '2022-01-30', 2, 48750, 0, 0, NULL, 'DRAFT', '2022-01-31 04:56:59', 'Administrator', NULL, NULL);
INSERT INTO `pembelian` VALUES (30, 4, 1, 'PO-000000009', 'NPO-YNTKTS-000000009', '2022-02-01', 2, 11500, 0, 0, NULL, 'DONE', '2022-02-02 01:21:03', 'Administrator', '2022-02-02 01:21:25', 'Administrator');
INSERT INTO `pembelian` VALUES (31, 4, 1, 'PO-000000010', 'NPO-YNTKTS-000000010', '2022-02-09', 1, 20000, 0, 0, NULL, 'DONE', '2022-02-10 02:42:09', 'Administrator', '2022-02-10 02:42:36', 'Administrator');

-- ----------------------------
-- Table structure for pembelian_detail
-- ----------------------------
DROP TABLE IF EXISTS `pembelian_detail`;
CREATE TABLE `pembelian_detail`  (
  `id_pembelian_detail` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_pembelian` int NOT NULL,
  `id_produk` int NOT NULL,
  `harga_beli` float NOT NULL,
  `jumlah` float NOT NULL,
  `subtotal` float NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_pembelian_detail`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 56 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of pembelian_detail
-- ----------------------------
INSERT INTO `pembelian_detail` VALUES (35, 22, 135, 10000.3, 5.67, 56701.8, '2022-01-30 02:52:04', NULL);
INSERT INTO `pembelian_detail` VALUES (36, 22, 137, 8750.12, 5.67, 49613.2, '2022-01-30 02:52:04', NULL);
INSERT INTO `pembelian_detail` VALUES (37, 22, 141, 7000.67, 5.67, 39693.8, '2022-01-30 02:52:04', NULL);
INSERT INTO `pembelian_detail` VALUES (38, 23, 137, 11000.3, 0, 36631.1, '2022-01-30 02:57:18', NULL);
INSERT INTO `pembelian_detail` VALUES (39, 24, 135, 10100, 2.5, 25250, '2022-01-30 03:49:07', NULL);
INSERT INTO `pembelian_detail` VALUES (40, 24, 137, 9000, 5.5, 49500, '2022-01-30 03:49:07', NULL);
INSERT INTO `pembelian_detail` VALUES (41, 24, 141, 7200, 5.5, 39600, '2022-01-30 03:49:07', NULL);
INSERT INTO `pembelian_detail` VALUES (42, 25, 135, 10000, 0, 100000, '2022-01-30 03:52:09', NULL);
INSERT INTO `pembelian_detail` VALUES (43, 25, 137, 9000, 0, 45000, '2022-01-30 03:52:09', NULL);
INSERT INTO `pembelian_detail` VALUES (44, 25, 141, 7000, 0, 35000, '2022-01-30 03:52:09', NULL);
INSERT INTO `pembelian_detail` VALUES (45, 26, 135, 10000, 9, 90000, '2022-01-30 03:59:30', NULL);
INSERT INTO `pembelian_detail` VALUES (46, 26, 137, 9000, 5, 45000, '2022-01-30 03:59:30', NULL);
INSERT INTO `pembelian_detail` VALUES (47, 26, 141, 7000, 5, 35000, '2022-01-30 03:59:30', NULL);
INSERT INTO `pembelian_detail` VALUES (48, 27, 135, 0, 0, 0, '2022-01-30 04:07:05', NULL);
INSERT INTO `pembelian_detail` VALUES (49, 28, 137, 9000, 0, 0, '2022-01-31 04:52:14', NULL);
INSERT INTO `pembelian_detail` VALUES (50, 28, 141, 7500, 0, 0, '2022-01-31 04:52:14', NULL);
INSERT INTO `pembelian_detail` VALUES (51, 29, 137, 9000, 2.5, 22500, '2022-01-31 04:56:59', NULL);
INSERT INTO `pembelian_detail` VALUES (52, 29, 141, 7500, 3.5, 26250, '2022-01-31 04:56:59', NULL);
INSERT INTO `pembelian_detail` VALUES (53, 30, 135, 10000, 0.5, 5000, '2022-02-02 01:21:03', NULL);
INSERT INTO `pembelian_detail` VALUES (54, 30, 137, 13000, 0.5, 6500, '2022-02-02 01:21:03', NULL);
INSERT INTO `pembelian_detail` VALUES (55, 31, 137, 2000, 10, 20000, '2022-02-10 02:42:09', NULL);

-- ----------------------------
-- Table structure for pengeluaran
-- ----------------------------
DROP TABLE IF EXISTS `pengeluaran`;
CREATE TABLE `pengeluaran`  (
  `id_pengeluaran` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_outlet` int NOT NULL,
  `kode_pengeluaran` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_pengeluaran` date NULL DEFAULT NULL,
  `deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nominal` float NOT NULL,
  `status` int NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_pengeluaran`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of pengeluaran
-- ----------------------------
INSERT INTO `pengeluaran` VALUES (1, 1, 'PL-000000002', '2022-01-28', 'beli popok', 200000, 0, '2022-01-14 22:35:19', 'Administrator', '2022-01-14 22:35:19', NULL);
INSERT INTO `pengeluaran` VALUES (2, 1, 'PL-000000001', '2022-01-01', 'bayar token listrik', 51000, 1, '2022-01-29 06:56:42', 'Administrator', '2022-01-29 00:21:30', 'Administrator');
INSERT INTO `pengeluaran` VALUES (3, 1, 'PL-000000003', '2022-01-01', 'Bayar PDAM Bulan Januari', 35000, 1, '2022-01-29 00:38:56', 'Administrator', NULL, NULL);
INSERT INTO `pengeluaran` VALUES (4, 1, 'PL-000000004', '2022-01-02', 'Perbaikan atap genteng TOKO', 150000, 1, '2022-01-29 00:39:27', 'Administrator', NULL, NULL);

-- ----------------------------
-- Table structure for penjualan
-- ----------------------------
DROP TABLE IF EXISTS `penjualan`;
CREATE TABLE `penjualan`  (
  `id_penjualan` bigint NOT NULL AUTO_INCREMENT,
  `id_member` int NULL DEFAULT NULL,
  `id_outlet` int NOT NULL,
  `kode_penjualan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `total_item` int NOT NULL,
  `total_harga` float NOT NULL,
  `total_diskon` float NULL DEFAULT 0,
  `total_promosi` float NULL DEFAULT 0,
  `custom_ammount` float NULL DEFAULT 0,
  `total_pajak` float NULL DEFAULT 0,
  `total_harga_semua` float NOT NULL,
  `tipe_bayar` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nomor_kartu` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `uang_diterima` float NOT NULL,
  `catatan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'DRAFT' COMMENT 'DRAFT, PAID, VOID',
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_penjualan`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of penjualan
-- ----------------------------

-- ----------------------------
-- Table structure for penjualan_detail
-- ----------------------------
DROP TABLE IF EXISTS `penjualan_detail`;
CREATE TABLE `penjualan_detail`  (
  `id_penjualan_detail` bigint NOT NULL,
  `id_penjualan` bigint NOT NULL,
  `id_produk` int NOT NULL,
  `id_uom` int NOT NULL,
  `nama_produk` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `harga_produk` float NOT NULL,
  `jumlah_produk` float NOT NULL,
  `diskon_produk` float NULL DEFAULT 0,
  `subtotal_produk` float NOT NULL,
  PRIMARY KEY (`id_penjualan_detail`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of penjualan_detail
-- ----------------------------

-- ----------------------------
-- Table structure for penjualan_detail_add_opt
-- ----------------------------
DROP TABLE IF EXISTS `penjualan_detail_add_opt`;
CREATE TABLE `penjualan_detail_add_opt`  (
  `penjualan_detail_add_opt` bigint NOT NULL AUTO_INCREMENT,
  `id_penjualan_detail` bigint NOT NULL,
  `id_add_opt_detail` int NOT NULL,
  `nama_add_opt` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `harga_add_opt` float NOT NULL,
  `jumlah_add_opt` float NOT NULL,
  `subtotal_add_opt` float NOT NULL,
  PRIMARY KEY (`penjualan_detail_add_opt`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of penjualan_detail_add_opt
-- ----------------------------

-- ----------------------------
-- Table structure for penjualan_diskon
-- ----------------------------
DROP TABLE IF EXISTS `penjualan_diskon`;
CREATE TABLE `penjualan_diskon`  (
  `id_penjualan_diskon` int NOT NULL AUTO_INCREMENT,
  `id_penjualan` bigint NOT NULL,
  `diskon_val` float NOT NULL,
  `diskon_unit` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `diskon_money` float NOT NULL,
  PRIMARY KEY (`id_penjualan_diskon`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of penjualan_diskon
-- ----------------------------

-- ----------------------------
-- Table structure for penjualan_pajak
-- ----------------------------
DROP TABLE IF EXISTS `penjualan_pajak`;
CREATE TABLE `penjualan_pajak`  (
  `id_penjualan_pajak` bigint NOT NULL AUTO_INCREMENT,
  `id_penjualan` bigint NOT NULL,
  `id_pajak` int NOT NULL,
  `nama_pajak` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `jumlah` float NOT NULL,
  `jumlah_unit` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `jumlah_money` float NOT NULL,
  PRIMARY KEY (`id_penjualan_pajak`, `id_penjualan`, `id_pajak`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of penjualan_pajak
-- ----------------------------

-- ----------------------------
-- Table structure for penjualan_promo
-- ----------------------------
DROP TABLE IF EXISTS `penjualan_promo`;
CREATE TABLE `penjualan_promo`  (
  `id_penjualan_promo` int NOT NULL AUTO_INCREMENT,
  `id_penjualan` bigint NOT NULL,
  `id_promo` int NOT NULL,
  `tipe_promo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'BOGO, TOTAL, DLL',
  `kode_promo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama_promo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `promo_val` float NOT NULL,
  `promo_unit` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `promo_money` float NOT NULL,
  PRIMARY KEY (`id_penjualan_promo`, `id_penjualan`, `id_promo`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of penjualan_promo
-- ----------------------------

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
  `id_uom` int NOT NULL,
  `sku_produk` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `barcode_produk` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `kode_produk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_produk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `merk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `diskon` tinyint NOT NULL DEFAULT 0,
  `harga_jual` int NOT NULL,
  `dijual` int NOT NULL DEFAULT 1,
  `kelola_stok` int NOT NULL DEFAULT 1,
  `pajak` int NOT NULL DEFAULT 0,
  `jenis` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'master',
  `tipe` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'tunggal',
  `additional` int NULL DEFAULT 0,
  `min_stok` float NULL DEFAULT NULL,
  `deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
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
) ENGINE = InnoDB AUTO_INCREMENT = 144 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of produk
-- ----------------------------
INSERT INTO `produk` VALUES (4, 1, 1, 0, '', NULL, 'P000001', 'TOPPAS FILTER 12', 'TOPPAS', 0, 16000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-27 17:15:02', '2022-01-13 00:07:41', NULL, NULL);
INSERT INTO `produk` VALUES (5, 1, 0, 9, 'RKK-G88-M', NULL, 'PRD-000000024', 'GOLDEN 12 88 MERAH', 'GOLDEN', 0, 12000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, '1643903722.jpeg', 1, '2021-12-27 17:18:38', '2022-02-04 06:55:22', NULL, 'Administrator');
INSERT INTO `produk` VALUES (6, 1, 0, 9, 'RKK-D88H12', NULL, 'PRD-000000019', 'DELUXE 12 BOLD 88 HITAM', 'DELUXE BOLD 88', 0, 12000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, '1643903472.jpeg', 1, '2021-12-27 17:19:43', '2022-02-04 06:51:12', NULL, 'Administrator');
INSERT INTO `produk` VALUES (7, 1, 0, 0, '', NULL, 'P000007', 'MLD 20 PUTIH', 'MLD', 0, 27500, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-27 17:20:21', '2021-12-29 22:13:22', NULL, NULL);
INSERT INTO `produk` VALUES (8, 1, 0, 9, 'RKK-GEO-MLD', NULL, 'PRD-000000023', 'GEO MILD', 'GEOMILD', 0, 21500, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, '1643903682.jpeg', 1, '2021-12-27 17:21:07', '2022-02-04 06:54:42', NULL, 'Administrator');
INSERT INTO `produk` VALUES (9, 1, 0, 0, '', NULL, 'P000009', 'LA MILD 16', 'LA MILD', 0, 24000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-27 17:21:50', '2021-12-27 17:21:50', NULL, NULL);
INSERT INTO `produk` VALUES (10, 1, 0, 0, '', NULL, 'P000010', 'SAMPOERNA MILD 16', 'SAMPOERNA', 0, 24500, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-27 17:22:47', '2021-12-29 18:05:47', NULL, NULL);
INSERT INTO `produk` VALUES (11, 1, 0, 0, '', NULL, 'P000011', 'SURYA 12 GG', 'SURYA', 0, 20000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-27 17:23:55', '2021-12-29 18:05:47', NULL, NULL);
INSERT INTO `produk` VALUES (12, 1, 0, 9, 'RKK-GRNDL-12', NULL, 'PRD-000000026', 'GRENDEL 12', 'GRENDEL', 0, 12000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, '1643903803.jpeg', 1, '2021-12-27 17:25:34', '2022-02-04 06:56:43', NULL, 'Administrator');
INSERT INTO `produk` VALUES (13, 1, 0, 9, 'RKK-GRNDL-16', NULL, 'PRD-000000027', 'GRENDEL 16', 'GRENDEL', 0, 15500, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, '1643903823.jpeg', 1, '2021-12-27 17:26:18', '2022-02-04 06:57:03', NULL, 'Administrator');
INSERT INTO `produk` VALUES (14, 1, 0, 0, '', NULL, 'P000014', 'TOPPAS FILTER 16', 'TOPPAS', 0, 17000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-27 17:27:26', '2021-12-27 17:27:26', NULL, NULL);
INSERT INTO `produk` VALUES (15, 1, 0, 9, 'RKK-D88H', NULL, 'PRD-000000018', 'DELUXE 16 BOLD 88 HITAM', 'DELUXE BOLD 88', 0, 15000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, '1643903405.jpeg', 1, '2021-12-27 17:28:42', '2022-02-04 06:50:05', NULL, 'Administrator');
INSERT INTO `produk` VALUES (16, 1, 0, 9, 'RKK-G88-16', NULL, 'PRD-000000025', 'GOLDEN 16 88 MERAH', 'GOLDEN', 0, 15000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, '1643903760.jpeg', 1, '2021-12-27 18:06:53', '2022-02-04 06:56:00', NULL, 'Administrator');
INSERT INTO `produk` VALUES (17, 1, 0, 0, '', NULL, 'P000017', 'NEXT BOLD 20', 'NEXT BOLD', 0, 18000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-27 18:08:01', '2021-12-27 18:08:01', NULL, NULL);
INSERT INTO `produk` VALUES (18, 1, 0, 9, 'RKK-ASI', NULL, 'PRD-000000017', 'AGA SAMPOERNA IJO', 'AGA SAMPOERNA', 0, 14000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, '1643903088.jpeg', 1, '2021-12-27 18:08:59', '2022-02-04 06:44:48', NULL, 'Administrator');
INSERT INTO `produk` VALUES (19, 1, 0, 0, '', NULL, 'P000019', 'MLD 16 HITAM', 'MLD', 0, 23500, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-27 18:10:16', '2021-12-27 18:10:16', NULL, NULL);
INSERT INTO `produk` VALUES (20, 1, 0, 9, 'RKK-DJ-76', NULL, 'PRD-000000021', 'DJARUM 76', 'DJARUM', 0, 13500, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, '1643903614.jpeg', 1, '2021-12-27 18:11:06', '2022-02-04 06:53:34', NULL, 'Administrator');
INSERT INTO `produk` VALUES (21, 1, 0, 9, 'RKK-GEO-M', NULL, 'PRD-000000022', 'GEO KRETEK MERFAH', 'GEO', 0, 8000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, '1643903659.jpeg', 1, '2021-12-27 18:11:52', '2022-02-04 06:54:19', NULL, 'Administrator');
INSERT INTO `produk` VALUES (22, 1, 0, 0, '', NULL, 'P000022', 'SURYA PRO MERAH', 'SURYA', 0, 21000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-27 18:12:43', '2021-12-27 21:14:14', NULL, NULL);
INSERT INTO `produk` VALUES (23, 1, 0, 9, 'RKK-DIP12-H', NULL, 'PRD-000000020', 'DIPLOMAT 12 HITAM', 'DIPLOMAT', 0, 19000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, '1643903538.jpeg', 1, '2021-12-27 18:13:54', '2022-02-04 06:52:18', NULL, 'Administrator');
INSERT INTO `produk` VALUES (24, 1, 0, 0, '', NULL, 'P000024', 'MAGNUM FILTER HITAM', 'MAGNUM', 0, 18500, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-27 18:14:56', '2021-12-27 18:14:56', NULL, NULL);
INSERT INTO `produk` VALUES (25, 1, 0, 0, '', NULL, 'P000025', 'SURYA PROMILD PUTIH', 'SURYA', 0, 21500, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-27 18:16:03', '2021-12-27 18:16:03', NULL, NULL);
INSERT INTO `produk` VALUES (26, 2, 0, 0, '', NULL, 'P000026', 'MATERAI 10K', 'MATERAI', 0, 11000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-27 18:42:44', '2021-12-29 18:02:59', NULL, NULL);
INSERT INTO `produk` VALUES (27, 1, 0, 9, 'RKK-KRK-M', NULL, 'PRD-000000029', 'KOREK MAGNET', 'KOREK', 0, 2000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, '1643903913.jpeg', 1, '2021-12-27 18:49:46', '2022-02-04 06:58:33', NULL, 'Administrator');
INSERT INTO `produk` VALUES (28, 1, 0, 9, 'RKK-KRK-B', NULL, 'PRD-000000028', 'KOREK BIASA', 'KOREK', 0, 1000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, '1643903886.jpeg', 1, '2021-12-27 18:50:51', '2022-02-04 06:58:06', NULL, 'Administrator');
INSERT INTO `produk` VALUES (29, 3, 0, 0, '', NULL, 'P000029', 'Jasa Laminating', 'kertas fintech', 0, 5000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-27 21:18:35', '2021-12-29 22:13:22', NULL, NULL);
INSERT INTO `produk` VALUES (30, 2, 0, 0, '', NULL, 'P000030', 'BOLPOIN GEL TIZO 340', 'TIZO', 0, 5000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-27 21:56:46', '2021-12-29 18:02:59', NULL, NULL);
INSERT INTO `produk` VALUES (31, 2, 0, 0, '', NULL, 'P000031', 'BOLPOIN GEL WEIYADA 5681', 'WEIYADA', 0, 5000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-27 22:03:11', '2021-12-27 22:03:11', NULL, NULL);
INSERT INTO `produk` VALUES (32, 2, 0, 0, '', NULL, 'P000032', 'BOLPOIN STANDARD BLACK', 'STANDARD AE7', 0, 2000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-27 22:16:25', '2021-12-27 22:16:25', NULL, NULL);
INSERT INTO `produk` VALUES (33, 2, 0, 0, '', NULL, 'P000033', 'BOLPOIN GEL G-3073', 'ZHIXIN G-3073', 0, 3000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-27 22:17:46', '2021-12-27 22:17:46', NULL, NULL);
INSERT INTO `produk` VALUES (34, 2, 0, 0, '', NULL, 'P000034', 'CAT AIR WATER COLOUR NO.120', 'MR. LOVE GUITAR', 0, 15000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-27 22:20:55', '2021-12-27 22:20:55', NULL, NULL);
INSERT INTO `produk` VALUES (35, 2, 0, 0, '', NULL, 'P000035', 'KUAS CAT AIR  PAGODA NO.1', 'PAGODA HANDY', 0, 3000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-27 22:28:22', '2021-12-27 22:28:22', NULL, NULL);
INSERT INTO `produk` VALUES (36, 2, 0, 0, '', NULL, 'P000036', 'KUAS CAT AIR PAGODA NO.3', 'PAGODA HANDY', 0, 3500, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-27 22:29:49', '2021-12-27 22:29:49', NULL, NULL);
INSERT INTO `produk` VALUES (37, 2, 0, 0, '', NULL, 'P000037', 'KUAS CAT AIR PAGODA NO.5', 'PAGODA HANDY', 0, 3500, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-27 22:31:44', '2021-12-27 22:31:44', NULL, NULL);
INSERT INTO `produk` VALUES (38, 2, 0, 0, '', NULL, 'P000038', 'KUAS CAT AIR PAGODA NO.7', 'PAGODA HANDY', 0, 4000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-27 22:32:34', '2021-12-27 22:32:34', NULL, NULL);
INSERT INTO `produk` VALUES (39, 2, 0, 0, '', NULL, 'P000039', 'CRAYON FANCY BT21', 'FANCY BT21', 0, 10000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-27 22:36:43', '2021-12-27 22:36:43', NULL, NULL);
INSERT INTO `produk` VALUES (40, 2, 0, 0, '', NULL, 'P000040', 'SPIDOL WARNA SIGN PEN 12', 'SAFARI BRAND', 0, 6500, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-27 22:42:03', '2021-12-27 22:42:03', NULL, NULL);
INSERT INTO `produk` VALUES (41, 2, 0, 0, '', NULL, 'P000041', 'SPIDOL WARNA SNOWMAN SIGN PEN 12', 'SNOWMAN', 0, 17000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-27 22:45:55', '2021-12-27 22:45:55', NULL, NULL);
INSERT INTO `produk` VALUES (42, 2, 0, 0, '', NULL, 'P000042', 'PENSIL WARNA JOYKO PJ 12', 'JOYKO', 0, 15000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-27 22:49:35', '2021-12-27 22:49:35', NULL, NULL);
INSERT INTO `produk` VALUES (43, 2, 0, 0, '', NULL, 'P000043', 'CRAYON TITI 18', 'TITI', 0, 35000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-27 22:54:32', '2021-12-27 22:54:32', NULL, NULL);
INSERT INTO `produk` VALUES (44, 2, 0, 0, '', NULL, 'P000044', 'KOTAK PENSIL SPORT COKLAT', 'SPORT ST 308', 0, 15000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-27 23:00:08', '2021-12-27 23:00:08', NULL, NULL);
INSERT INTO `produk` VALUES (45, 2, 0, 0, '', NULL, 'P000045', 'KOTAK PENSIL UNICORN UNGU', 'UNICORN', 0, 25000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-27 23:01:12', '2021-12-27 23:01:12', NULL, NULL);
INSERT INTO `produk` VALUES (46, 2, 0, 0, '', NULL, 'P000046', 'KOTAK PENSIL MOMO PINK', 'MOMO M-083', 0, 25000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-27 23:02:03', '2021-12-27 23:02:03', NULL, NULL);
INSERT INTO `produk` VALUES (47, 2, 0, 0, '', NULL, 'P000047', 'KOTAK PENSIL SPORT RED', 'SPORT ST 308', 0, 15000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-27 23:02:39', '2021-12-27 23:02:39', NULL, NULL);
INSERT INTO `produk` VALUES (48, 2, 0, 0, '', NULL, 'P000048', 'PENGGARIS BUTTERFLY 30 CM', 'BUTTERFLY', 0, 3000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-27 23:05:57', '2021-12-27 23:05:57', NULL, NULL);
INSERT INTO `produk` VALUES (49, 2, 0, 0, '', NULL, 'P000049', 'JANGKA JOYKO MS-25', 'JOYKO', 0, 12000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-27 23:09:39', '2021-12-27 23:09:39', NULL, NULL);
INSERT INTO `produk` VALUES (50, 2, 0, 0, '', NULL, 'P000050', 'KAPUR TULIS  PC PUTIH', 'PEACE CHALK', 0, 5000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-27 23:12:35', '2021-12-27 23:12:35', NULL, NULL);
INSERT INTO `produk` VALUES (51, 2, 0, 0, '', NULL, 'P000051', 'LEM FOX PUTIH', 'LEM FOX', 0, 10000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-27 23:15:20', '2021-12-27 23:15:20', NULL, NULL);
INSERT INTO `produk` VALUES (52, 2, 0, 0, '', NULL, 'P000052', 'GUNTING JOYKO SC-838', 'JOYKO SC-838', 0, 10000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-27 23:17:17', '2021-12-27 23:17:17', NULL, NULL);
INSERT INTO `produk` VALUES (53, 2, 0, 0, '', NULL, 'P000053', 'GUNTING M2000 SM-A145', 'M2000 SM-A145', 0, 5000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-27 23:18:02', '2021-12-27 23:18:02', NULL, NULL);
INSERT INTO `produk` VALUES (54, 2, 0, 0, '', NULL, 'P000054', 'GUNTING LINKO SC-040', 'LINKO SC-040', 0, 5000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-27 23:22:23', '2021-12-27 23:22:23', NULL, NULL);
INSERT INTO `produk` VALUES (55, 2, 0, 0, '', NULL, 'P000055', 'TINTA SPIDOL SNOWMAN PERMANENT', 'SNOWMAN', 0, 12500, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-28 17:16:43', '2021-12-28 17:16:43', NULL, NULL);
INSERT INTO `produk` VALUES (56, 2, 0, 0, '', NULL, 'P000056', 'TINTA EPSON YELLOW', 'EPSON 664', 0, 90000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-28 17:26:39', '2021-12-28 17:26:39', NULL, NULL);
INSERT INTO `produk` VALUES (57, 2, 0, 0, '', NULL, 'P000057', 'TINTA EPSON MAGENTA', 'EPSON 664', 0, 90000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-28 17:27:15', '2021-12-28 17:27:15', NULL, NULL);
INSERT INTO `produk` VALUES (58, 2, 0, 0, '', NULL, 'P000058', 'TINTA EPSON BLACK', 'EPSON 664', 0, 90000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-28 17:28:35', '2021-12-28 17:28:35', NULL, NULL);
INSERT INTO `produk` VALUES (59, 2, 0, 0, '', NULL, 'P000059', 'TINTA EPSON CYAN', 'EPSON 664', 0, 90000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-28 17:29:08', '2021-12-28 17:29:08', NULL, NULL);
INSERT INTO `produk` VALUES (60, 2, 0, 0, '', NULL, 'P000060', 'LEM FOX KALENG', 'LEM FOX', 0, 10000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-28 17:34:29', '2021-12-28 17:34:29', NULL, NULL);
INSERT INTO `produk` VALUES (61, 2, 0, 0, '', NULL, 'P000061', 'CORRECTION PEN KIRIKO', 'KIRIKO', 0, 7000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-28 17:39:51', '2021-12-28 17:39:51', NULL, NULL);
INSERT INTO `produk` VALUES (62, 2, 0, 0, '', NULL, 'P000062', 'SPIDOL BESAR SNOWMAN PERMANENT', 'SNOWMAN', 0, 8000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-28 17:45:29', '2021-12-28 17:45:29', NULL, NULL);
INSERT INTO `produk` VALUES (63, 2, 0, 0, '', NULL, 'P000063', 'PENSIL BACHELOR 2B', 'BACHELOR', 0, 1000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-28 17:50:07', '2021-12-29 18:05:47', NULL, NULL);
INSERT INTO `produk` VALUES (64, 2, 0, 0, '', NULL, 'P000064', 'SETIP JOYKO B40', 'JOYKO', 0, 1500, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-28 17:53:55', '2021-12-28 17:54:09', NULL, NULL);
INSERT INTO `produk` VALUES (65, 2, 0, 0, '', NULL, 'P000065', 'KEROTAN RANDOM ANGSA', 'ANGSA', 0, 3500, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-28 18:11:13', '2021-12-28 18:11:13', NULL, NULL);
INSERT INTO `produk` VALUES (66, 2, 0, 0, '', NULL, 'P000066', 'KEROTAN RANDOM BUNGKUS', 'KERANG BUNGKUS', 0, 5000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-28 18:19:12', '2021-12-28 18:19:12', NULL, NULL);
INSERT INTO `produk` VALUES (67, 2, 0, 0, '', NULL, 'P000067', 'STABILO ARTLINE  660', 'SHACHINATA', 0, 6000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-28 18:21:35', '2021-12-28 18:21:35', NULL, NULL);
INSERT INTO `produk` VALUES (68, 2, 0, 0, '', NULL, 'P000068', 'STAPLER JOYKO HD-10', 'JOYKO HD-10', 0, 11000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-28 18:27:28', '2021-12-28 18:27:28', NULL, NULL);
INSERT INTO `produk` VALUES (69, 2, 0, 0, '', NULL, 'P000069', 'AMPLOP 104 PPS', 'PAPERLINE', 0, 250, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-28 18:34:28', '2021-12-28 18:34:28', NULL, NULL);
INSERT INTO `produk` VALUES (70, 2, 0, 0, '', NULL, 'P000070', 'AMPLOP 90 PPS', 'PAPERLINE', 0, 500, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-28 18:35:16', '2021-12-28 18:35:16', NULL, NULL);
INSERT INTO `produk` VALUES (71, 2, 0, 0, '', NULL, 'P000071', 'LEM BAKAR KECIL', 'NO MERK', 0, 1000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-28 18:42:35', '2021-12-28 18:42:35', NULL, NULL);
INSERT INTO `produk` VALUES (72, 2, 0, 0, '', NULL, 'P000072', 'LEM LIQUID BESAR POVINAL', 'POVINAL', 0, 5000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-28 18:46:53', '2021-12-28 18:46:53', NULL, NULL);
INSERT INTO `produk` VALUES (73, 2, 0, 0, '', NULL, 'P000073', 'LEM LIQUID KECIL POVINAL', 'POVINAL', 0, 3000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-28 18:48:40', '2021-12-28 18:48:40', NULL, NULL);
INSERT INTO `produk` VALUES (74, 2, 0, 0, '', NULL, 'P000074', 'LEM GLUKOL KECIL', 'GLUKOL', 0, 1000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-28 19:16:02', '2021-12-28 19:16:02', NULL, NULL);
INSERT INTO `produk` VALUES (75, 2, 0, 0, '', NULL, 'P000075', 'TISU SAKU', 'FANCY', 0, 1000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-28 19:17:16', '2021-12-28 19:17:16', NULL, NULL);
INSERT INTO `produk` VALUES (76, 2, 0, 0, '', NULL, 'P000076', 'LAKBAN BENING DAIMARU', 'DAIMARU', 0, 15000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-28 19:26:35', '2021-12-28 19:26:35', NULL, NULL);
INSERT INTO `produk` VALUES (77, 2, 0, 0, '', NULL, 'P000077', 'LAKBAN LINEN HITAM DAIMARU', 'DAIMARU', 0, 20000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-28 19:31:32', '2021-12-28 19:31:32', NULL, NULL);
INSERT INTO `produk` VALUES (78, 2, 0, 0, '', NULL, 'P000078', 'DOUBLE TAPE NACHI  12 MM', 'NACHI', 0, 5000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-28 19:35:30', '2021-12-28 19:35:30', NULL, NULL);
INSERT INTO `produk` VALUES (79, 2, 0, 0, '', NULL, 'P000079', 'ISOLASI MOTIF FANCY', 'FANCY', 0, 1000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-28 19:37:33', '2021-12-28 19:37:33', NULL, NULL);
INSERT INTO `produk` VALUES (80, 2, 0, 0, '', NULL, 'P000080', 'BUKU TULIS SIDU 38 LEMBAR', 'SIDU 38 L', 0, 3000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-28 19:44:35', '2021-12-28 20:20:47', NULL, NULL);
INSERT INTO `produk` VALUES (81, 2, 0, 0, '', NULL, 'P000081', 'NOTA KONTAN 2 PLY', 'PAPERLINE', 0, 5000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-28 19:53:20', '2021-12-28 19:54:30', NULL, NULL);
INSERT INTO `produk` VALUES (82, 2, 0, 0, '', NULL, 'P000082', 'NOTA KONTAN 3 PLY', 'FORTE', 0, 5000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-28 19:54:11', '2021-12-28 19:54:11', NULL, NULL);
INSERT INTO `produk` VALUES (83, 2, 0, 0, '', NULL, 'P000083', 'KWITANSI MINI 40 SHEETS', 'PAPERLINE', 0, 3000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-28 19:55:45', '2021-12-28 19:55:45', NULL, NULL);
INSERT INTO `produk` VALUES (84, 2, 0, 0, '', NULL, 'P000084', 'PAPERCLIP NO.3 SEAGULL', 'SEA GULL', 0, 4000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-28 20:02:13', '2021-12-28 20:02:13', NULL, NULL);
INSERT INTO `produk` VALUES (85, 2, 0, 0, '', NULL, 'P000085', 'STAPLES GW NO.10', 'GREAT WALL', 0, 2000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-28 20:03:29', '2021-12-28 20:03:29', NULL, NULL);
INSERT INTO `produk` VALUES (86, 2, 0, 0, '', NULL, 'P000086', 'SAMPUL BENING KWARTO', 'JERSY KWARTO', 0, 1000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-28 20:04:38', '2021-12-28 20:04:38', NULL, NULL);
INSERT INTO `produk` VALUES (87, 2, 0, 0, '', NULL, 'P000087', 'PELUBANG KERTAS V-TEC NO.30', 'PUNCH', 0, 15000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-28 20:08:10', '2021-12-28 20:08:10', NULL, NULL);
INSERT INTO `produk` VALUES (88, 2, 0, 0, '', NULL, 'P000088', 'FOLIO BERGARIS', 'SIDU', 0, 4500, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-28 20:14:33', '2021-12-28 20:14:33', NULL, NULL);
INSERT INTO `produk` VALUES (89, 2, 0, 0, '', NULL, 'P000089', 'BUKU TULIS VISION 38 LEMBAR', 'VISION', 0, 2500, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-28 20:21:26', '2021-12-28 20:21:26', NULL, NULL);
INSERT INTO `produk` VALUES (90, 2, 0, 0, '', NULL, 'P000090', 'BUKU TULIS SIDU 58 LEMBAR', 'SIDU', 0, 5000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-28 20:32:01', '2021-12-28 20:32:01', NULL, NULL);
INSERT INTO `produk` VALUES (91, 2, 0, 0, '', NULL, 'P000091', 'BUKU TULIS MATEMATIKA 38 LEMBAR', 'SIDU', 0, 3000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-28 20:48:26', '2021-12-28 20:48:26', NULL, NULL);
INSERT INTO `produk` VALUES (92, 2, 0, 0, '', NULL, 'P000092', 'BUKU TULIS KOTAK SIDU 38 LEMBAR', 'SIDU', 0, 4000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-28 20:55:58', '2021-12-28 20:55:58', NULL, NULL);
INSERT INTO `produk` VALUES (93, 2, 0, 0, '', NULL, 'P000093', 'BUKU TULIS KOTAK MATEMATIKA SIDU 38 LEMBAR', 'SIDU', 0, 3500, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-28 20:57:03', '2021-12-28 20:57:03', NULL, NULL);
INSERT INTO `produk` VALUES (94, 2, 0, 0, '', NULL, 'P000094', 'BUKU GAMBAR A4 SIDU', 'SIDU', 0, 4000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-28 21:14:46', '2021-12-28 21:14:46', NULL, NULL);
INSERT INTO `produk` VALUES (95, 2, 0, 0, '', NULL, 'P000095', 'BUKU GAMBAR A4 KIKY', 'KIKY', 0, 5000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-28 21:24:54', '2021-12-28 21:25:48', NULL, NULL);
INSERT INTO `produk` VALUES (96, 2, 0, 0, '', NULL, 'P000096', 'BUKU GAMBAR SD A4 SIDU', 'SIDU', 0, 4000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-28 21:32:58', '2021-12-28 21:32:58', NULL, NULL);
INSERT INTO `produk` VALUES (97, 2, 0, 0, '', NULL, 'P000097', 'STAPLES BESAR NO.3', 'ETONA', 0, 3500, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-28 22:04:50', '2021-12-28 22:04:50', NULL, NULL);
INSERT INTO `produk` VALUES (98, 2, 0, 0, '', NULL, 'P000098', 'STOPMAP FOLIO KERTAS', 'SABANG MERAUKE', 0, 1000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-28 22:13:20', '2021-12-29 18:02:59', NULL, NULL);
INSERT INTO `produk` VALUES (99, 2, 0, 0, '', NULL, 'P000099', 'AMPLOP COKLAT KANCING', 'KIKY', 0, 2000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-28 22:15:58', '2021-12-28 22:15:58', NULL, NULL);
INSERT INTO `produk` VALUES (100, 2, 0, 0, '', NULL, 'P000100', 'BUKU TABUNGAN', 'TUT WURI HANDAYANI', 0, 1000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-28 22:18:29', '2021-12-28 22:19:00', NULL, NULL);
INSERT INTO `produk` VALUES (101, 2, 0, 0, '', NULL, 'P000101', 'BUKU FOLIO BESAR BATIK WARNA', 'PAPERLINE', 0, 20000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-28 22:22:13', '2021-12-28 22:22:13', NULL, NULL);
INSERT INTO `produk` VALUES (102, 2, 0, 0, '', NULL, 'P000102', 'BUKU FOLIO BESAR BATIK COKLAT', 'KIKY', 0, 20000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-28 22:22:48', '2021-12-29 18:12:44', NULL, NULL);
INSERT INTO `produk` VALUES (103, 2, 0, 0, '', NULL, 'P000103', 'BUKU FOLIO KAS', 'KIKY', 0, 25000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-28 22:28:34', '2021-12-28 22:28:34', NULL, NULL);
INSERT INTO `produk` VALUES (104, 2, 0, 0, '', NULL, 'P000104', 'BUKU GAMBAR A3 SIDU', 'SIDU', 0, 9000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-28 22:31:06', '2021-12-28 22:31:06', NULL, NULL);
INSERT INTO `produk` VALUES (105, 2, 0, 0, '', NULL, 'P000105', 'BUKU KEWARTO KAS', 'KIKY', 0, 15000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-28 22:33:27', '2021-12-28 22:33:27', NULL, NULL);
INSERT INTO `produk` VALUES (106, 2, 0, 0, '', NULL, 'P000106', 'BUKU KWARTO 50', 'KIKY', 0, 12000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-28 22:34:35', '2021-12-28 22:34:35', NULL, NULL);
INSERT INTO `produk` VALUES (107, 2, 0, 0, '', NULL, 'P000107', 'PAPAN CLIPBOARD MOTIF', 'FANCY', 0, 12000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-28 22:37:20', '2021-12-28 22:37:20', NULL, NULL);
INSERT INTO `produk` VALUES (108, 2, 0, 0, '', NULL, 'P000108', 'PAPAN CLIPBOARD POLOS', 'REBECCA', 0, 15000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-28 22:38:09', '2021-12-28 22:38:09', NULL, NULL);
INSERT INTO `produk` VALUES (109, 2, 0, 0, '', NULL, 'P000109', 'STOPMAP KACING', 'IMCO', 0, 6000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-28 22:43:04', '2021-12-29 18:05:47', NULL, NULL);
INSERT INTO `produk` VALUES (110, 2, 0, 0, '', NULL, 'P000110', 'KERTAS A4 80 ORANGE', 'SIDU', 0, 50000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-28 22:46:03', '2021-12-28 22:46:03', NULL, NULL);
INSERT INTO `produk` VALUES (111, 2, 0, 0, '', NULL, 'P000111', 'KERTAS KADO MOTIF BUAH', 'MOTIF BUAH', 0, 1500, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-28 22:49:47', '2021-12-28 22:49:47', NULL, NULL);
INSERT INTO `produk` VALUES (112, 2, 0, 0, '', NULL, 'P000112', 'KERTAS KADO BATIK', 'MOTIF BATIK', 0, 1000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-28 22:50:45', '2021-12-28 22:50:45', NULL, NULL);
INSERT INTO `produk` VALUES (113, 2, 0, 0, '', NULL, 'P000113', 'PLATIK BUNGA', 'BUNGA BENING', 0, 1000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-28 22:51:19', '2021-12-28 22:51:19', NULL, NULL);
INSERT INTO `produk` VALUES (114, 2, 0, 0, '', NULL, 'P000114', 'KERTAS F4 75 BIRU', 'PHYTON CPR', 0, 50000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-29 20:30:25', '2021-12-29 20:32:20', NULL, NULL);
INSERT INTO `produk` VALUES (115, 2, 0, 0, '', NULL, 'P000115', 'KERTAS A4 75 BIRU', 'PPO', 0, 45000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-29 20:32:02', '2021-12-29 20:32:02', NULL, NULL);
INSERT INTO `produk` VALUES (116, 2, 0, 0, '', NULL, 'P000116', 'KERTAS DUPLEK 350 GR', 'NOMERK', 0, 8500, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-29 20:33:53', '2021-12-29 20:33:53', NULL, NULL);
INSERT INTO `produk` VALUES (117, 2, 0, 0, '', NULL, 'P000117', 'KERTAS MANILA PUTIH', 'NOMERK', 0, 2500, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-29 20:34:24', '2021-12-29 20:34:24', NULL, NULL);
INSERT INTO `produk` VALUES (118, 2, 0, 0, '', NULL, 'P000118', 'KERTAS MINYAK', 'NOMERK', 0, 1500, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-29 20:35:21', '2021-12-29 20:35:21', NULL, NULL);
INSERT INTO `produk` VALUES (119, 2, 0, 0, '', NULL, 'P000119', 'KERTAS SUKUN', 'NOMERK', 0, 1500, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-29 20:36:18', '2021-12-29 20:36:18', NULL, NULL);
INSERT INTO `produk` VALUES (120, 2, 0, 0, '', NULL, 'P000120', 'CUTTER KECIL SC-9A', 'GUNINCO', 0, 5000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-29 21:03:55', '2021-12-29 21:03:55', NULL, NULL);
INSERT INTO `produk` VALUES (121, 2, 0, 0, '', NULL, 'P000121', 'CUTTER BESAR A-18', 'GUNINCO', 0, 7000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-29 21:04:53', '2021-12-29 21:04:53', NULL, NULL);
INSERT INTO `produk` VALUES (122, 2, 0, 0, '', NULL, 'P000122', 'MIKA JILID COVER KUNING', 'SINGA KEMBAR', 0, 500, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-29 21:07:54', '2021-12-29 21:07:54', NULL, NULL);
INSERT INTO `produk` VALUES (123, 2, 0, 0, '', NULL, 'P000123', 'LAKBAN COKLAT', 'NO MERK', 0, 8000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-29 21:09:42', '2021-12-29 21:09:42', NULL, NULL);
INSERT INTO `produk` VALUES (124, 2, 0, 0, '', NULL, 'P000124', 'MATERAN KAIN', 'CHINA', 0, 2500, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-29 21:11:31', '2021-12-29 21:11:31', NULL, NULL);
INSERT INTO `produk` VALUES (125, 2, 0, 0, '', NULL, 'P000125', 'AMPLOP COKLAT PANJANG', 'NO MERK', 0, 5000, 1, 1, 0, 'master', 'tunggal', 0, NULL, NULL, NULL, 1, '2021-12-29 21:45:56', '2021-12-29 21:45:56', NULL, NULL);
INSERT INTO `produk` VALUES (126, 2, 0, 9, 'ATK-KWB40S', '12432356475', 'PRD-000000009', 'KWITANSI BESAR 40 SHEETS', 'PAPERLINE', 0, 5000, 1, 1, 1, 'master', 'tunggal', 0, NULL, NULL, '1642861829.jpeg', 1, '2021-12-29 21:58:12', '2022-01-23 05:30:29', NULL, 'Administrator');
INSERT INTO `produk` VALUES (129, 10, 1, 6, 'MIN-MSC', NULL, 'oke nanti', 'Milk Shake Coklat', NULL, 0, 10000, 1, 0, 1, 'master', 'komposit', 1, NULL, NULL, '1642836745.jpeg', 1, '2022-01-22 22:32:25', NULL, 'Administrator', NULL);
INSERT INTO `produk` VALUES (133, 10, 1, 6, 'MIN-MSM', NULL, 'PRD-000000016', 'Milk Shake Matcha', NULL, 0, 10000, 1, 0, 1, 'master', 'komposit', 1, NULL, 'tes update', '1642839550.png', 1, '2022-01-22 23:19:10', '2022-02-03 05:50:35', 'Administrator', 'Administrator');
INSERT INTO `produk` VALUES (135, 13, 1, 8, 'BB-SUHT', '1233321', 'PRD-000000007', 'Susu UHT Indomilk', NULL, 0, 0, 0, 1, 1, 'master', 'tunggal', 0, 5, NULL, '', 1, '2022-01-23 00:17:52', '2022-01-23 04:10:36', 'Administrator', 'Administrator');
INSERT INTO `produk` VALUES (136, 1, 1, 9, 'R-DRJ', '6786789', 'PRD-000000008', 'ROKOK DURJANA', NULL, 0, 5000, 1, 1, 1, 'master', 'tunggal', 1, NULL, NULL, '1642857207.jpg', 0, '2022-01-23 04:13:27', NULL, 'Administrator', NULL);
INSERT INTO `produk` VALUES (137, 13, 1, 10, 'BB-GL', NULL, 'PRD-000000010', 'Gula', NULL, 0, 0, 0, 1, 1, 'master', 'tunggal', 0, NULL, NULL, '', 1, '2022-01-25 23:32:27', NULL, 'Administrator', NULL);
INSERT INTO `produk` VALUES (138, 14, 1, 9, 'M-SRB', NULL, 'PRD-000000015', 'Serabi', NULL, 0, 2000, 1, 0, 1, 'master', 'komposit', 1, NULL, NULL, '1643200268.jpeg', 1, '2022-01-27 03:31:08', '2022-01-27 03:34:25', 'Administrator', 'Administrator');
INSERT INTO `produk` VALUES (139, 13, 1, 11, 'BB-TT', NULL, 'PRD-000000012', 'Tepung Terigu', NULL, 0, 0, 0, 1, 1, 'master', 'tunggal', 0, 100, NULL, '', 1, '2022-01-27 03:32:19', NULL, 'Administrator', NULL);
INSERT INTO `produk` VALUES (140, 13, 1, 9, 'BB-TLR', NULL, 'PRD-000000013', 'Telur', NULL, 0, 0, 0, 1, 1, 'master', 'tunggal', 0, 10, NULL, '', 1, '2022-01-27 03:33:19', NULL, 'Administrator', NULL);
INSERT INTO `produk` VALUES (141, 13, 1, 11, 'BB-GRM', NULL, 'PRD-000000014', 'Garam', NULL, 0, 0, 0, 1, 1, 'master', 'tunggal', 0, 100, NULL, '', 1, '2022-01-27 03:34:00', NULL, 'Administrator', NULL);
INSERT INTO `produk` VALUES (142, 18, 1, 9, 'L-MB-01', NULL, 'PRD-000000031', 'MacBook 2015', NULL, 0, 10000000, 1, 1, 1, 'master', 'tunggal', 0, NULL, NULL, '1644567473.jpg', 1, '2022-02-11 23:17:11', '2022-02-11 23:17:53', 'Administrator', 'Administrator');
INSERT INTO `produk` VALUES (143, 14, 1, 9, 'M-MKRN-01', NULL, 'PRD-000000032', 'Makroni Biasa', NULL, 0, 3000, 1, 0, 1, 'master', 'komposit', 0, NULL, NULL, '1644580791.jpg', 1, '2022-02-12 02:59:51', NULL, 'Administrator', NULL);

-- ----------------------------
-- Table structure for produk_additional
-- ----------------------------
DROP TABLE IF EXISTS `produk_additional`;
CREATE TABLE `produk_additional`  (
  `id_produk_additional` bigint NOT NULL AUTO_INCREMENT,
  `id_produk` int NOT NULL,
  `id_add_opt` int NOT NULL,
  PRIMARY KEY (`id_produk_additional`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of produk_additional
-- ----------------------------
INSERT INTO `produk_additional` VALUES (1, 129, 4);
INSERT INTO `produk_additional` VALUES (6, 1, 4);
INSERT INTO `produk_additional` VALUES (7, 1, 5);
INSERT INTO `produk_additional` VALUES (13, 136, 6);
INSERT INTO `produk_additional` VALUES (15, 138, 8);
INSERT INTO `produk_additional` VALUES (16, 133, 4);

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
) ENGINE = InnoDB AUTO_INCREMENT = 34 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of produk_komposit
-- ----------------------------
INSERT INTO `produk_komposit` VALUES (4, 133, 135, 'BAHAN_BAKU_MILK_SHAKE_MATCHA', 0.2);
INSERT INTO `produk_komposit` VALUES (5, 133, 137, 'BAHAN_BAKU_MILK_SHAKE_MATCHA', 0.006);
INSERT INTO `produk_komposit` VALUES (6, 129, 137, 'BAHAN_BAKU_MILK_SHAKE_COKLAT', 0.001);
INSERT INTO `produk_komposit` VALUES (30, 138, 141, 'BAHAN_BAKU_SERABI', 2);
INSERT INTO `produk_komposit` VALUES (31, 138, 140, 'BAHAN_BAKU_SERABI', 0.5);
INSERT INTO `produk_komposit` VALUES (32, 138, 139, 'BAHAN_BAKU_SERABI', 15);
INSERT INTO `produk_komposit` VALUES (33, 138, 135, 'BAHAN_BAKU_SERABI', 0.5);

-- ----------------------------
-- Table structure for promo_auto_bogo
-- ----------------------------
DROP TABLE IF EXISTS `promo_auto_bogo`;
CREATE TABLE `promo_auto_bogo`  (
  `id_promo_auto_bogo` int NOT NULL AUTO_INCREMENT,
  `kode_promo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama_promo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `min_qty_produk` int NOT NULL,
  `id_produk_beli` int NOT NULL,
  `id_produk_bonus` int NOT NULL,
  `qty_produk_bonus` int NOT NULL DEFAULT 1,
  `kuota` int NULL DEFAULT 1,
  `batas_perhari` int NULL DEFAULT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_akhir` date NOT NULL,
  `hari` int NOT NULL DEFAULT 0 COMMENT '0,1,2,3,4,5,7',
  `jam_mulai` time NOT NULL DEFAULT '00:00:00',
  `jam_akhir` time NOT NULL DEFAULT '23:59:59',
  `status` int NOT NULL COMMENT '0,1,2',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `updated_by` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_promo_auto_bogo`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of promo_auto_bogo
-- ----------------------------
INSERT INTO `promo_auto_bogo` VALUES (5, 'PR-AB-0000000001', 'Milkshake Matcha 2x Get Milkshake Matcha 1x', 2, 133, 133, 1, 5, 5, '2022-02-07', '2022-02-28', 0, '00:00:00', '23:59:59', 1, '2022-02-08 04:51:28', '2022-02-08 04:51:30', 'tester', 'tester');

-- ----------------------------
-- Table structure for promo_auto_bogo_outlet
-- ----------------------------
DROP TABLE IF EXISTS `promo_auto_bogo_outlet`;
CREATE TABLE `promo_auto_bogo_outlet`  (
  `id_outlet_promo` int NOT NULL,
  `id_promo_auto_bogo` int NOT NULL,
  PRIMARY KEY (`id_outlet_promo`, `id_promo_auto_bogo`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of promo_auto_bogo_outlet
-- ----------------------------
INSERT INTO `promo_auto_bogo_outlet` VALUES (1, 5);
INSERT INTO `promo_auto_bogo_outlet` VALUES (1, 6);
INSERT INTO `promo_auto_bogo_outlet` VALUES (1, 7);

-- ----------------------------
-- Table structure for promo_auto_grandtotal
-- ----------------------------
DROP TABLE IF EXISTS `promo_auto_grandtotal`;
CREATE TABLE `promo_auto_grandtotal`  (
  `id_promo_auto_grandtotal` int NOT NULL AUTO_INCREMENT,
  `kode_promo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama_promo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `min_grandtotal` float NOT NULL,
  `diskon_val` float NOT NULL,
  `diskon_unit` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `kuota` int NULL DEFAULT 1,
  `batas_perhari` int NULL DEFAULT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_akhir` date NOT NULL,
  `hari` int NOT NULL DEFAULT 0 COMMENT '0,1,2,3,4,5,7',
  `jam_mulai` time NOT NULL DEFAULT '00:00:00',
  `jam_akhir` time NOT NULL DEFAULT '23:59:59',
  `status` int NOT NULL COMMENT '0,1,2',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `updated_by` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_promo_auto_grandtotal`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of promo_auto_grandtotal
-- ----------------------------
INSERT INTO `promo_auto_grandtotal` VALUES (5, 'PR-AG-0000000001', 'Total Pembelian Rp. 100.000 Diskon 10%', 100000, 10, '%', 5, 5, '2022-02-07', '2022-02-28', 0, '00:00:00', '23:59:59', 1, '2022-02-08 04:54:11', '2022-02-08 04:54:13', NULL, NULL);

-- ----------------------------
-- Table structure for promo_auto_grandtotal_outlet
-- ----------------------------
DROP TABLE IF EXISTS `promo_auto_grandtotal_outlet`;
CREATE TABLE `promo_auto_grandtotal_outlet`  (
  `id_outlet_promo` int NOT NULL,
  `id_promo_auto_grandtotal` int NOT NULL,
  PRIMARY KEY (`id_outlet_promo`, `id_promo_auto_grandtotal`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of promo_auto_grandtotal_outlet
-- ----------------------------
INSERT INTO `promo_auto_grandtotal_outlet` VALUES (1, 5);

-- ----------------------------
-- Table structure for promo_auto_qty_produk
-- ----------------------------
DROP TABLE IF EXISTS `promo_auto_qty_produk`;
CREATE TABLE `promo_auto_qty_produk`  (
  `id_promo_auto_qty_produk` int NOT NULL AUTO_INCREMENT,
  `kode_promo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama_promo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `min_qty_produk` int NOT NULL,
  `id_produk_beli` int NOT NULL,
  `diskon_val` float NOT NULL,
  `diskon_unit` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `kuota` int NULL DEFAULT 1,
  `batas_perhari` int NULL DEFAULT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_akhir` date NOT NULL,
  `hari` int NOT NULL DEFAULT 0 COMMENT '0,1,2,3,4,5,7',
  `jam_mulai` time NOT NULL DEFAULT '00:00:00',
  `jam_akhir` time NOT NULL DEFAULT '23:59:59',
  `status` int NOT NULL COMMENT '0,1,2',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `updated_by` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_promo_auto_qty_produk`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of promo_auto_qty_produk
-- ----------------------------
INSERT INTO `promo_auto_qty_produk` VALUES (5, 'PR-AQP-0000000001', 'Beli Matcha 3x Dikson Rp. 5,000', 3, 133, 5000, 'rp', 5, 5, '2022-02-07', '2022-02-28', 0, '00:00:00', '23:59:59', 1, '2022-02-08 04:58:10', '2022-02-08 04:58:12', NULL, NULL);
INSERT INTO `promo_auto_qty_produk` VALUES (6, 'PR-AQP-0000000002', 'Diskon 50% Toppas Filter 12', 1, 4, 50, '%', 100, 100, '2022-02-07', '2022-02-28', 0, '00:00:00', '23:59:59', 1, '2022-02-08 06:56:12', '2022-02-08 06:56:14', NULL, NULL);
INSERT INTO `promo_auto_qty_produk` VALUES (7, 'PR-AQP-0000000003', 'Diskon +20% Toppas Filter 12', 1, 4, 20, '%', 100, 100, '2022-02-07', '2022-02-28', 0, '00:00:00', '23:59:59', 1, '2022-02-08 06:57:17', '2022-02-08 06:57:19', NULL, NULL);

-- ----------------------------
-- Table structure for promo_auto_qty_produk_outlet
-- ----------------------------
DROP TABLE IF EXISTS `promo_auto_qty_produk_outlet`;
CREATE TABLE `promo_auto_qty_produk_outlet`  (
  `id_outlet_promo` int NOT NULL,
  `id_promo_auto_qty_produk` int NOT NULL,
  PRIMARY KEY (`id_outlet_promo`, `id_promo_auto_qty_produk`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of promo_auto_qty_produk_outlet
-- ----------------------------
INSERT INTO `promo_auto_qty_produk_outlet` VALUES (1, 5);
INSERT INTO `promo_auto_qty_produk_outlet` VALUES (1, 6);
INSERT INTO `promo_auto_qty_produk_outlet` VALUES (1, 7);

-- ----------------------------
-- Table structure for promo_diskon
-- ----------------------------
DROP TABLE IF EXISTS `promo_diskon`;
CREATE TABLE `promo_diskon`  (
  `id_promo_diskon` int NOT NULL AUTO_INCREMENT,
  `kode_promo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama_promo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `diskon_val` float NOT NULL,
  `diskon_unit` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `kuota` int NULL DEFAULT 1,
  `batas_perhari` int NULL DEFAULT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_akhir` date NOT NULL,
  `hari` int NOT NULL DEFAULT 0 COMMENT '0,1,2,3,4,5,7',
  `jam_mulai` time NOT NULL DEFAULT '00:00:00',
  `jam_akhir` time NOT NULL DEFAULT '23:59:59',
  `status` int NOT NULL COMMENT '0,1,2',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `updated_by` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_promo_diskon`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of promo_diskon
-- ----------------------------
INSERT INTO `promo_diskon` VALUES (5, 'PR-D-0000000001', 'Diskon pelajar 5%', 5, '%', 5, 5, '2022-02-07', '2022-02-28', 0, '00:00:00', '23:59:59', 1, '2022-02-08 04:59:51', '2022-02-08 04:59:57', NULL, NULL);

-- ----------------------------
-- Table structure for promo_diskon_outlet
-- ----------------------------
DROP TABLE IF EXISTS `promo_diskon_outlet`;
CREATE TABLE `promo_diskon_outlet`  (
  `id_outlet_promo` int NOT NULL,
  `id_promo_diskon` int NOT NULL,
  PRIMARY KEY (`id_outlet_promo`, `id_promo_diskon`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of promo_diskon_outlet
-- ----------------------------
INSERT INTO `promo_diskon_outlet` VALUES (1, 5);

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
INSERT INTO `sessions` VALUES ('JZVjn47gA5tIt3i68tFUgsTy6p9oZHCq2quA9T9Y', 1, '192.168.28.36', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/98.0.4758.102 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiaWozUWhkRTJmRnlXd05reXM2WWZaTm5lNG1HZXZQY1pmMFNIdEFYSiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDQ6Imh0dHA6Ly8xOTIuMTY4LjI4LjM2OjY5NjkvYXBwL3RyYW5zYWtzaS1qdWFsIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo2OiJvdXRsZXQiO3M6MToiMSI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2MDoiJDJ5JDEwJGh4VHZGWVNoT1hTZmZlWTVFdzRDdGUuVm5xdkpCM1p0VC51ckF1VGFnTUNoZzZESUNRT1hHIjt9', 1645179076);
INSERT INTO `sessions` VALUES ('TCrBrSZSC70S0CPsVFwxSSgeaFVpc61vKkxY3eTj', 1, '192.168.28.1', 'Mozilla/5.0 (Linux; Android 11; SM-A505F Build/RP1A.200720.012; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/98.0.4758.101 Mobile Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiNVppZEdVdERTZFUyV2RSVTNTNm4zOFZoSHRMeHZxa3VKVWY2WmxZMiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDQ6Imh0dHA6Ly8xOTIuMTY4LjI4LjM2OjY5NjkvYXBwL3RyYW5zYWtzaS1qdWFsIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo2OiJvdXRsZXQiO3M6MToiMSI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2MDoiJDJ5JDEwJGh4VHZGWVNoT1hTZmZlWTVFdzRDdGUuVm5xdkpCM1p0VC51ckF1VGFnTUNoZzZESUNRT1hHIjt9', 1645180522);
INSERT INTO `sessions` VALUES ('XhJmgPDv8aM1KZn4NuuWSrqjSMTZsQjrsXGME4ux', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/98.0.4758.102 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiUzJGaEt5Z29QNlJVbHZ1bkR3SWE5RzdRQ0Y2UmVyRE9ncEdaRWlqdSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9kYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6MTc6InBhc3N3b3JkX2hhc2hfd2ViIjtzOjYwOiIkMnkkMTAkaHhUdkZZU2hPWFNmZmVZNUV3NEN0ZS5WbnF2SkIzWnRULnVyQXVUYWdNQ2hnNkRJQ1FPWEciO30=', 1645766376);

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
INSERT INTO `setting` VALUES (1, 'Toko Bumdes', 'Jl. Ledokombo', '08888', 1, 0, 1, '/img/logo-20220122210248.png', '/img/member.png', 2, 1, NULL, '2022-02-18 10:35:14');

-- ----------------------------
-- Table structure for stok_produk
-- ----------------------------
DROP TABLE IF EXISTS `stok_produk`;
CREATE TABLE `stok_produk`  (
  `id_stok_produk` bigint NOT NULL AUTO_INCREMENT,
  `id_outlet` bigint NOT NULL,
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
) ENGINE = InnoDB AUTO_INCREMENT = 90 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of stok_produk
-- ----------------------------
INSERT INTO `stok_produk` VALUES (58, 1, 'ST-B-000000001', NULL, '2022-01-29', 'PEMBELIAN', 'STOKPEMBELIAN', 1, '2022-01-30 03:34:22', NULL, 'Administrator', NULL);
INSERT INTO `stok_produk` VALUES (59, 1, 'ST-B-000000002', NULL, '2022-01-29', 'PEMBELIAN', 'STOKPEMBELIAN', 1, '2022-01-30 03:50:28', NULL, 'Administrator', NULL);
INSERT INTO `stok_produk` VALUES (60, 1, 'ST-B-000000003', NULL, '2022-01-29', 'PEMBELIAN', 'STOKPEMBELIAN', 1, '2022-01-30 03:59:30', NULL, 'Administrator', NULL);
INSERT INTO `stok_produk` VALUES (61, 1, 'ST-M-000000004', 'testing insert stok masuk', '2022-01-30', 'MASUK', 'STOKMASUK', 1, '2022-01-31 03:54:26', NULL, 'Administrator', NULL);
INSERT INTO `stok_produk` VALUES (62, 1, 'ST-M-000000005', 'oke', '2022-01-01', 'MASUK', 'STOKMASUK', 0, '2022-01-31 03:55:00', NULL, 'Administrator', NULL);
INSERT INTO `stok_produk` VALUES (63, 1, 'ST-M-000000006', 'testing insert float', '2022-01-30', 'MASUK', 'STOKMASUK', 1, '2022-01-31 04:29:09', NULL, 'Administrator', NULL);
INSERT INTO `stok_produk` VALUES (64, 1, 'ST-K-0001', 'testing insert', '2022-01-30', 'KELUAR', 'STOKKELUAR', 0, '2022-01-31 05:34:39', NULL, 'Administrator', NULL);
INSERT INTO `stok_produk` VALUES (65, 1, 'ST-K-000000002', 'testing insert 2', '2022-01-30', 'KELUAR', 'STOKKELUAR', 1, '2022-01-31 05:37:03', NULL, 'Administrator', NULL);
INSERT INTO `stok_produk` VALUES (85, 1, 'ST-O-0001', NULL, '2022-01-31', 'OPNAME', 'STOKOPNAME', 0, '2022-02-01 06:53:53', NULL, 'Administrator', NULL);
INSERT INTO `stok_produk` VALUES (86, 1, 'ST-OP-000000001', NULL, '2022-01-31', 'OPNAME', 'STOKOPNAME', 1, '2022-02-01 06:55:49', NULL, 'Administrator', NULL);
INSERT INTO `stok_produk` VALUES (87, 1, 'ST-B-000000002', NULL, '2022-02-01', 'PEMBELIAN', 'STOKPEMBELIAN', 1, '2022-02-02 01:21:25', NULL, 'Administrator', NULL);
INSERT INTO `stok_produk` VALUES (88, 1, 'ST-B-000000002', NULL, '2022-02-09', 'PEMBELIAN', 'STOKPEMBELIAN', 1, '2022-02-10 02:42:36', NULL, 'Administrator', NULL);
INSERT INTO `stok_produk` VALUES (89, 1, 'ST-M-000000002', 'ok', '2022-02-09', 'MASUK', 'STOKMASUK', 0, '2022-02-10 02:43:33', NULL, 'Administrator', NULL);

-- ----------------------------
-- Table structure for stok_produk_detail
-- ----------------------------
DROP TABLE IF EXISTS `stok_produk_detail`;
CREATE TABLE `stok_produk_detail`  (
  `id_stok_produk_detail` bigint NOT NULL AUTO_INCREMENT,
  `id_produk` int NOT NULL,
  `nilai` float NOT NULL,
  `jenis` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `harga` float NOT NULL DEFAULT 0,
  `sub_total` float NOT NULL DEFAULT 0,
  `sumber` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id_reference` bigint NOT NULL,
  `kode_reference` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_stok_produk_detail`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 208 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of stok_produk_detail
-- ----------------------------
INSERT INTO `stok_produk_detail` VALUES (86, 135, 5.67, 'MASUK', 10000.3, 56701.8, 'stok_produk', 58, 'ST-B-000000001');
INSERT INTO `stok_produk_detail` VALUES (87, 137, 5.67, 'MASUK', 8750.12, 49613.2, 'stok_produk', 58, 'ST-B-000000001');
INSERT INTO `stok_produk_detail` VALUES (88, 141, 5.67, 'MASUK', 7000.67, 39693.8, 'stok_produk', 58, 'ST-B-000000001');
INSERT INTO `stok_produk_detail` VALUES (89, 135, 2.5, 'MASUK', 10100, 25250, 'stok_produk', 59, 'ST-B-000000002');
INSERT INTO `stok_produk_detail` VALUES (90, 137, 5.5, 'MASUK', 9000, 49500, 'stok_produk', 59, 'ST-B-000000002');
INSERT INTO `stok_produk_detail` VALUES (91, 141, 5.5, 'MASUK', 7200, 39600, 'stok_produk', 59, 'ST-B-000000002');
INSERT INTO `stok_produk_detail` VALUES (92, 135, 9, 'MASUK', 10000, 90000, 'stok_produk', 60, 'ST-B-000000003');
INSERT INTO `stok_produk_detail` VALUES (93, 137, 5, 'MASUK', 9000, 45000, 'stok_produk', 60, 'ST-B-000000003');
INSERT INTO `stok_produk_detail` VALUES (94, 141, 5, 'MASUK', 7000, 35000, 'stok_produk', 60, 'ST-B-000000003');
INSERT INTO `stok_produk_detail` VALUES (95, 135, 5.5, 'MASUK', 15000, 82500, 'stok_produk', 61, 'ST-M-000000004');
INSERT INTO `stok_produk_detail` VALUES (96, 137, 2.5, 'MASUK', 10000, 25000, 'stok_produk', 61, 'ST-M-000000004');
INSERT INTO `stok_produk_detail` VALUES (97, 141, 2.5, 'MASUK', 9000, 22500, 'stok_produk', 61, 'ST-M-000000004');
INSERT INTO `stok_produk_detail` VALUES (98, 137, 0, 'MASUK', 8500, 0, 'stok_produk', 62, 'ST-M-000000005');
INSERT INTO `stok_produk_detail` VALUES (99, 135, 6.77, 'MASUK', 10000.3, 67702.2, 'stok_produk', 63, 'ST-M-000000006');
INSERT INTO `stok_produk_detail` VALUES (100, 137, 3.56, 'MASUK', 9900.36, 35245.3, 'stok_produk', 63, 'ST-M-000000006');
INSERT INTO `stok_produk_detail` VALUES (101, 141, 2.93, 'MASUK', 8800.35, 25785, 'stok_produk', 63, 'ST-M-000000006');
INSERT INTO `stok_produk_detail` VALUES (102, 135, 0, 'KELUAR', 10942.7, 0, 'stok_produk', 64, 'ST-K-0001');
INSERT INTO `stok_produk_detail` VALUES (103, 137, 0, 'KELUAR', 9192.91, 0, 'stok_produk', 64, 'ST-K-0001');
INSERT INTO `stok_produk_detail` VALUES (104, 141, 0, 'KELUAR', 7526.8, 0, 'stok_produk', 64, 'ST-K-0001');
INSERT INTO `stok_produk_detail` VALUES (105, 135, -0.5, 'KELUAR', 10942.7, -5471.37, 'stok_produk', 65, 'ST-K-000000002');
INSERT INTO `stok_produk_detail` VALUES (106, 137, -0.5, 'KELUAR', 9192.91, -4596.46, 'stok_produk', 65, 'ST-K-000000002');
INSERT INTO `stok_produk_detail` VALUES (107, 141, -1, 'KELUAR', 7526.8, -7526.8, 'stok_produk', 65, 'ST-K-000000002');
INSERT INTO `stok_produk_detail` VALUES (192, 141, 0, 'MASUK', 7526.8, 0, 'stok_produk', 85, 'ST-O-0001');
INSERT INTO `stok_produk_detail` VALUES (193, 140, 0, 'MASUK', 0, 0, 'stok_produk', 85, 'ST-O-0001');
INSERT INTO `stok_produk_detail` VALUES (194, 139, 0, 'MASUK', 0, 0, 'stok_produk', 85, 'ST-O-0001');
INSERT INTO `stok_produk_detail` VALUES (195, 137, 0, 'MASUK', 9192.91, 0, 'stok_produk', 85, 'ST-O-0001');
INSERT INTO `stok_produk_detail` VALUES (196, 136, 0, 'MASUK', 0, 0, 'stok_produk', 85, 'ST-O-0001');
INSERT INTO `stok_produk_detail` VALUES (197, 135, 0, 'MASUK', 10942.7, 0, 'stok_produk', 85, 'ST-O-0001');
INSERT INTO `stok_produk_detail` VALUES (198, 141, 0, 'MASUK', 7526.8, 0, 'stok_produk', 86, 'ST-OP-000000001');
INSERT INTO `stok_produk_detail` VALUES (199, 140, 0, 'MASUK', 0, 0, 'stok_produk', 86, 'ST-OP-000000001');
INSERT INTO `stok_produk_detail` VALUES (200, 139, 0, 'MASUK', 0, 0, 'stok_produk', 86, 'ST-OP-000000001');
INSERT INTO `stok_produk_detail` VALUES (201, 137, 0, 'MASUK', 9192.91, 0, 'stok_produk', 86, 'ST-OP-000000001');
INSERT INTO `stok_produk_detail` VALUES (202, 136, 0, 'MASUK', 0, 0, 'stok_produk', 86, 'ST-OP-000000001');
INSERT INTO `stok_produk_detail` VALUES (203, 135, 0, 'MASUK', 10942.7, 0, 'stok_produk', 86, 'ST-OP-000000001');
INSERT INTO `stok_produk_detail` VALUES (204, 135, 0.5, 'MASUK', 10000, 5000, 'stok_produk', 87, 'ST-B-000000002');
INSERT INTO `stok_produk_detail` VALUES (205, 137, 0.5, 'MASUK', 13000, 6500, 'stok_produk', 87, 'ST-B-000000002');
INSERT INTO `stok_produk_detail` VALUES (206, 137, 10, 'MASUK', 2000, 20000, 'stok_produk', 88, 'ST-B-000000002');
INSERT INTO `stok_produk_detail` VALUES (207, 137, 0, 'MASUK', 10000, 0, 'stok_produk', 89, 'ST-M-000000002');

-- ----------------------------
-- Table structure for supplier
-- ----------------------------
DROP TABLE IF EXISTS `supplier`;
CREATE TABLE `supplier`  (
  `id_supplier` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `kode_supplier` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `telepon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_supplier`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of supplier
-- ----------------------------
INSERT INTO `supplier` VALUES (3, 'SUP-000000003', 'TOKO ARDIAN', 'Jalan Stasiun Sumberlesung Kecamatan Ledokombo', '082226426388', 1, '2021-12-27 17:08:18', '2021-12-27 17:08:18');
INSERT INTO `supplier` VALUES (4, 'SUP-000000002', 'PRIMA STATIONERY', 'Jalan Gatot Subroto No.72 JEMBER', '467009485290', 1, '2021-12-27 17:10:09', '2021-12-27 17:10:09');
INSERT INTO `supplier` VALUES (5, 'SUP-000000001', 'TOKO SYAHRIL', 'Jl. Kalisat no. 31 Jember', '08767887562', 1, NULL, NULL);

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
-- Table structure for uom
-- ----------------------------
DROP TABLE IF EXISTS `uom`;
CREATE TABLE `uom`  (
  `id_uom` int NOT NULL AUTO_INCREMENT,
  `nama_uom` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_uom`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of uom
-- ----------------------------
INSERT INTO `uom` VALUES (6, 'GELAS', NULL, NULL, NULL, NULL);
INSERT INTO `uom` VALUES (8, 'LITER', '2022-01-23 00:17:52', 'Administrator', NULL, NULL);
INSERT INTO `uom` VALUES (9, 'PCS', '2022-01-23 04:13:27', 'Administrator', NULL, NULL);
INSERT INTO `uom` VALUES (10, 'KILOGRAM', '2022-01-25 23:32:27', 'Administrator', NULL, NULL);
INSERT INTO `uom` VALUES (11, 'GRAM', '2022-01-27 03:32:19', 'Administrator', NULL, NULL);

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
INSERT INTO `users` VALUES (1, 'Administrator', 'admin@gmail.com', NULL, '$2y$10$hxTvFYShOXSffeY5Ew4Cte.VnqvJB3ZtT.urAuTagMChg6DICQOXG', '/img/logo-20220211122449.jpg', 1, NULL, NULL, NULL, NULL, NULL, '2021-12-26 00:05:56', '2022-02-12 03:24:49');
INSERT INTO `users` VALUES (2, 'Kasir 1', 'kasir1@gmail.com', NULL, '$2y$10$1KH.KxV0AOjKRuCQNM8omOPja/5DYqu0CUkMp3oA5e7obUU9ywGzS', '/img/user.jpg', 2, NULL, NULL, NULL, NULL, NULL, '2021-12-26 00:05:56', '2021-12-26 00:05:56');

SET FOREIGN_KEY_CHECKS = 1;