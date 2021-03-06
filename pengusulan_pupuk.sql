/*
 Navicat Premium Data Transfer

 Source Server         : root
 Source Server Type    : MySQL
 Source Server Version : 50724
 Source Host           : localhost:3306
 Source Schema         : pengusulan_pupuk

 Target Server Type    : MySQL
 Target Server Version : 50724
 File Encoding         : 65001

 Date: 25/06/2020 17:03:43
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for tb_desa
-- ----------------------------
DROP TABLE IF EXISTS `tb_desa`;
CREATE TABLE `tb_desa`  (
  `kode_desa` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `nama_desa` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`kode_desa`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tb_desa
-- ----------------------------
INSERT INTO `tb_desa` VALUES ('3506222001', 'Banyakan');
INSERT INTO `tb_desa` VALUES ('3506222002', 'Jatirejo');
INSERT INTO `tb_desa` VALUES ('3506222003', 'Manyaran');
INSERT INTO `tb_desa` VALUES ('3506222004', 'Tiron');
INSERT INTO `tb_desa` VALUES ('3506222005', 'Parang');
INSERT INTO `tb_desa` VALUES ('3506222006', 'Sendang');
INSERT INTO `tb_desa` VALUES ('3506222007', 'Maron');
INSERT INTO `tb_desa` VALUES ('3506222008', 'Ngablak');
INSERT INTO `tb_desa` VALUES ('3506222009', 'Jabon');

-- ----------------------------
-- Table structure for tb_distributor
-- ----------------------------
DROP TABLE IF EXISTS `tb_distributor`;
CREATE TABLE `tb_distributor`  (
  `id_distributor` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `nama_distributor` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `alamat_distributor` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_distributor`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tb_level
-- ----------------------------
DROP TABLE IF EXISTS `tb_level`;
CREATE TABLE `tb_level`  (
  `id_level` int(11) NOT NULL AUTO_INCREMENT,
  `level` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_level`) USING BTREE,
  INDEX `level`(`level`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tb_level
-- ----------------------------
INSERT INTO `tb_level` VALUES (1, 'ADMIN');
INSERT INTO `tb_level` VALUES (2, 'DISTRIBUTOR');
INSERT INTO `tb_level` VALUES (5, 'PETANI');
INSERT INTO `tb_level` VALUES (4, 'POKTAN');
INSERT INTO `tb_level` VALUES (3, 'PPL');

-- ----------------------------
-- Table structure for tb_petani
-- ----------------------------
DROP TABLE IF EXISTS `tb_petani`;
CREATE TABLE `tb_petani`  (
  `id_petani` int(11) NOT NULL AUTO_INCREMENT,
  `id_kelompok` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `nik` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `nama_petani` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `alamat` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `sektor` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `luas_lahan` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `tahap` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_petani`) USING BTREE,
  INDEX `id_kelompok`(`id_kelompok`) USING BTREE,
  INDEX `nama_petani`(`nama_petani`) USING BTREE,
  INDEX `sektor`(`sektor`) USING BTREE,
  CONSTRAINT `tb_petani_ibfk_2` FOREIGN KEY (`id_kelompok`) REFERENCES `tb_poktan` (`id_poktan`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `tb_petani_ibfk_3` FOREIGN KEY (`sektor`) REFERENCES `tb_sektor` (`jenis_tanaman`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 342 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tb_petani
-- ----------------------------
INSERT INTO `tb_petani` VALUES (1, 'K004', '3506221002650005', 'Suprihatin', 'Kamal : 04/02', 'tanaman pangan', '0.175', 'm3');
INSERT INTO `tb_petani` VALUES (2, 'K004', '3506220711710002', 'Zainal Arifin', 'Kamal : 01/01', 'tanaman pangan', '0.375', 'm3');
INSERT INTO `tb_petani` VALUES (3, 'K004', '3506221801800001', 'Misbahudin', 'Kamal : 02/01', 'tanaman pangan', '0.35', NULL);
INSERT INTO `tb_petani` VALUES (4, 'K004', '3506221505700001', 'Jamari', 'Kamal : 03/01', 'tanaman pangan', '0.336', NULL);
INSERT INTO `tb_petani` VALUES (5, 'K004', '3506220803610001', 'Nyoto', 'Kamal : 02/01', 'tanaman pangan', '0.175', NULL);
INSERT INTO `tb_petani` VALUES (6, 'K004', '3506222507690001', 'Kristiadi Widi Raharjo', 'Kamal : 01/01', 'tanaman pangan', '0.345', NULL);
INSERT INTO `tb_petani` VALUES (7, 'K004', '3506220107560059', 'Sunaryo', 'Kamal : 01/01', 'tanaman pangan', '0.375', NULL);
INSERT INTO `tb_petani` VALUES (8, 'K004', '3506220107570052', 'Gapar', 'Kamal : 02/01', 'tanaman pangan', '0.3625', NULL);
INSERT INTO `tb_petani` VALUES (9, 'K004', '3506220701850003', 'Miftachul  Huda', 'Kamal : 04/01', 'tanaman pangan', '0.1725', NULL);
INSERT INTO `tb_petani` VALUES (10, 'K004', '3506220107500073', 'Sukemi', 'Kamal : 03/01', 'tanaman pangan', '0.375', NULL);
INSERT INTO `tb_petani` VALUES (11, 'K004', '3506222508560001', 'Muanam', 'Kamal : 03/01', 'tanaman pangan', '0.168', NULL);
INSERT INTO `tb_petani` VALUES (12, 'K004', '3506222508560001', 'Juwito', 'Kamal : 04/01', 'tanaman pangan', '0.168', NULL);
INSERT INTO `tb_petani` VALUES (13, 'K004', '3506220107300029', 'Supangi', 'Kamal : 01/01', 'tanaman pangan', '0.345', NULL);
INSERT INTO `tb_petani` VALUES (14, 'K004', '3506221004710001', 'Slamet ', 'Kamal : 04/01', 'tanaman pangan', '0.1725', NULL);
INSERT INTO `tb_petani` VALUES (15, 'K004', '3506221208490004', 'Kamun', 'Kamal : 04/01', 'tanaman pangan', '0.5625', NULL);
INSERT INTO `tb_petani` VALUES (16, 'K004', '3506222109740004', 'Subari', 'Kamal : 01/02', 'tanaman pangan', '0.345', NULL);
INSERT INTO `tb_petani` VALUES (17, 'K004', '3506225407690001', 'Darwati', 'Kamal : 02/01', 'tanaman pangan', '0.168', NULL);
INSERT INTO `tb_petani` VALUES (18, 'K004', '3506220107680103', 'Panidi', 'Kamal : 04/01', 'tanaman pangan', '0.375', NULL);
INSERT INTO `tb_petani` VALUES (19, 'K004', '3506223112560005', 'Sukadi', 'Kamal : 01/01', 'tanaman pangan', '0.6025', NULL);
INSERT INTO `tb_petani` VALUES (20, 'K004', '3506221503610002', 'Suwarjono', 'Kamal : 04/01', 'tanaman pangan', '0.375', NULL);
INSERT INTO `tb_petani` VALUES (21, 'K004', '3506226802720002', 'Tin Masdariyati', 'Kamal : 01/01', 'tanaman pangan', '0.35', NULL);
INSERT INTO `tb_petani` VALUES (22, 'K004', '3506224107480099', 'Samini', 'Kamal : 01/02', 'tanaman pangan', '0.175', NULL);
INSERT INTO `tb_petani` VALUES (23, 'K004', '3506220103720002', 'Mahtum Efendi', 'Kamal : 04/01', 'tanaman pangan', '0.168', NULL);
INSERT INTO `tb_petani` VALUES (24, 'K004', '3506220905830001', 'Imam Asari', 'Kamal : 01/02', 'tanaman pangan', '0.375', NULL);
INSERT INTO `tb_petani` VALUES (25, 'K004', '3506222508520002', 'Supadi', 'Kamal : 03/01', 'tanaman pangan', '0.1725', NULL);
INSERT INTO `tb_petani` VALUES (26, 'K004', '3506220601770003', 'Abu Katimin', 'Kamal : 01/02', 'tanaman pangan', '0.5625', NULL);
INSERT INTO `tb_petani` VALUES (27, 'K004', '3506220107530102', 'Suparno', 'Kamal : 03/01', 'tanaman pangan', '0.1875', NULL);
INSERT INTO `tb_petani` VALUES (28, 'K004', '3506220708510001', 'Ramidi', 'Kamal : 04/01', 'tanaman pangan', '0.336', NULL);
INSERT INTO `tb_petani` VALUES (29, 'K004', '3506220107620059', 'Wagito ', 'Kamal : 02/01', 'tanaman pangan', '0.168', NULL);
INSERT INTO `tb_petani` VALUES (30, 'K004', '3506223112590003', 'Kasim', 'Kamal : 01/01', 'tanaman pangan', '0.1875', NULL);
INSERT INTO `tb_petani` VALUES (31, 'K004', '3506220101450002', 'Warno', 'Kamal : 03/01', 'tanaman pangan', '0.35', NULL);
INSERT INTO `tb_petani` VALUES (32, 'K004', '3506223112590004', 'Mariyaji', 'Kamal : 01/01', 'tanaman pangan', '0.5625', NULL);
INSERT INTO `tb_petani` VALUES (33, 'K004', '3506222310710001', 'Moh Thoyib', 'Kamal : 02/01', 'tanaman pangan', '0.345', NULL);
INSERT INTO `tb_petani` VALUES (34, 'K004', '3506222405800001', 'Suyanto', 'Kamal : 01/01', 'tanaman pangan', '0.35', NULL);
INSERT INTO `tb_petani` VALUES (35, 'K004', '3506222310710001', 'Slamet Sukaryanto', 'Kamal : 01/02', 'tanaman pangan', '0.168', NULL);
INSERT INTO `tb_petani` VALUES (36, 'K004', '3506222606720006', 'Supriyadi', 'Kamal : 02/02', 'tanaman pangan', '0.375', NULL);
INSERT INTO `tb_petani` VALUES (37, 'K004', '3506222511700001', 'Edi  Wibowo', 'Kamal : 02/02', 'tanaman pangan', '0.35', NULL);
INSERT INTO `tb_petani` VALUES (38, 'K004', '3506220706800002', 'Moh. Rifai', 'Kamal : 02/01', 'tanaman pangan', '0.1725', NULL);
INSERT INTO `tb_petani` VALUES (39, 'K004', '3506220107630151', 'Kamsuri', 'Kamal : 02/02', 'tanaman pangan', '0.1725', NULL);
INSERT INTO `tb_petani` VALUES (40, 'K004', '3506221312660002', 'Samuji', 'Kamal : 02/02', 'tanaman pangan', '0.366', NULL);
INSERT INTO `tb_petani` VALUES (41, 'K004', '3506132910700002', 'Nur Salim', 'Sonorejo : 01/02', 'tanaman pangan', '0.5625', NULL);
INSERT INTO `tb_petani` VALUES (42, 'K004', '3506225806640002', 'Wiji  Tiharni', 'Kamal : 01/02', 'tanaman pangan', '0.168', NULL);
INSERT INTO `tb_petani` VALUES (43, 'K004', '3506221504730004', 'Slamet  Saifudin', 'Kamal : 03/01', 'tanaman pangan', '0.175', NULL);
INSERT INTO `tb_petani` VALUES (44, 'K004', '3506221507930004', 'M. Irfan Julianto', 'Kamal : 02/01', 'tanaman pangan', '0.1725', NULL);
INSERT INTO `tb_petani` VALUES (45, 'K004', '3506223112560002', 'Jono', 'Kamal : 01/01', 'tanaman pangan', '0.336', NULL);
INSERT INTO `tb_petani` VALUES (46, 'K004', '3506220401640003', 'Pandi', 'Kamal : 03/01', 'tanaman pangan', '0.175', NULL);
INSERT INTO `tb_petani` VALUES (47, 'K004', '3506220407910001', 'Rohmat  Sidiq', 'Kamal : 01/01', 'tanaman pangan', '0.345', NULL);
INSERT INTO `tb_petani` VALUES (48, 'K004', '3506220107500072', 'Sukono', 'Kamal : 04/01', 'tanaman pangan', '0.375', NULL);
INSERT INTO `tb_petani` VALUES (49, 'K004', '3506221312610001', 'Suyatin', 'Kamal : 04/01', 'tanaman pangan', '0.168', NULL);
INSERT INTO `tb_petani` VALUES (50, 'K004', '3506220901790001', 'Tugiono', 'Kamal : 01/02', 'tanaman pangan', '0.175', NULL);
INSERT INTO `tb_petani` VALUES (51, 'K004', '3506220707650002', 'Suwarno', 'Kamal : 02/01', 'tanaman pangan', '0.35', NULL);
INSERT INTO `tb_petani` VALUES (52, 'K004', '3506220706730002', 'Adnan  Lutfi', 'Kamal : 02/01', 'tanaman pangan', '0.5625', NULL);
INSERT INTO `tb_petani` VALUES (53, 'K004', '3506221003660001', 'Sumadji', 'Kamal : 03/01', 'tanaman pangan', '0.175', NULL);
INSERT INTO `tb_petani` VALUES (54, 'K004', '3506223112500003', 'Musni', 'Kamal : 03/01', 'tanaman pangan', '0.345', NULL);
INSERT INTO `tb_petani` VALUES (55, 'K004', '3506221802740002', 'Mad  Kosim', 'Kamal : 03/02', 'tanaman pangan', '0.375', NULL);
INSERT INTO `tb_petani` VALUES (56, 'K004', '3506220107610061', 'Jaimah', 'Kamal : 02/01', 'tanaman pangan', '0.5625', NULL);
INSERT INTO `tb_petani` VALUES (57, 'K004', '3506220611870001', 'Ari Dwi Purnama', 'Kamal : 01/02', 'tanaman pangan', '0.504', NULL);
INSERT INTO `tb_petani` VALUES (58, 'K004', '3506222704750002', 'Budi  Santoso', 'Kamal : 01/02', 'tanaman pangan', '0.1875', NULL);
INSERT INTO `tb_petani` VALUES (59, 'K004', '3506221505700001', 'Jamari', 'Kamal : 03/01', 'tanaman pangan', '0.5175', 'm1');
INSERT INTO `tb_petani` VALUES (60, 'K004', '3506222502680001', 'Miseri', 'Kamal : 03/01', 'tanaman pangan', '0.336', NULL);
INSERT INTO `tb_petani` VALUES (61, 'K004', '3506220809560001', 'Kasiadi', 'Kamal : 01/02', 'tanaman pangan', '0.504', NULL);
INSERT INTO `tb_petani` VALUES (62, 'K004', '3506222005750001', 'Pujiono', 'Kamal : 01/02', 'tanaman pangan', '0.336', NULL);
INSERT INTO `tb_petani` VALUES (63, 'K004', '3506225002840003', 'Reni Fatimatul Ulfa', 'Kamal : 01/02', 'tanaman pangan', '0.175', NULL);
INSERT INTO `tb_petani` VALUES (64, 'K004', '3506221306760002', 'Joko Lelono Al Zaki M.', 'Kamal : 01/02', 'tanaman pangan', '0.35', NULL);
INSERT INTO `tb_petani` VALUES (65, 'K004', '3506221406400003', 'Marwi', 'Kamal : 01/02', 'tanaman pangan', '0.5175', NULL);
INSERT INTO `tb_petani` VALUES (66, 'K004', '3506221501900006', 'Wahyu Krisdiantoro', 'Kamal : 02/03', 'tanaman pangan', '0.175', NULL);
INSERT INTO `tb_petani` VALUES (70, 'K046', '3506222507820002', 'M. Sobiri', NULL, 'tanaman pangan', '0.35', NULL);
INSERT INTO `tb_petani` VALUES (71, 'K046', '3506224107220027', 'Maslakah', NULL, 'tanaman pangan', '0.65', NULL);
INSERT INTO `tb_petani` VALUES (72, 'K046', '3506226701840001', 'Siti Jaziroh', NULL, 'tanaman pangan', '0.25', NULL);
INSERT INTO `tb_petani` VALUES (73, 'K046', '3506221605840001', 'M. Adi Maqfur', NULL, 'tanaman pangan', '0.25', NULL);
INSERT INTO `tb_petani` VALUES (74, 'K046', '3506220201850003', 'M. Sholeh', NULL, 'tanaman pangan', '0.35', NULL);
INSERT INTO `tb_petani` VALUES (75, 'K046', '3506220107880083', 'Imam Mustofa', NULL, 'tanaman pangan', '0.5', NULL);
INSERT INTO `tb_petani` VALUES (76, 'K046', '3506226910860001', 'Dwi Utami', NULL, 'tanaman pangan', '0.35', NULL);
INSERT INTO `tb_petani` VALUES (77, 'K046', '3506227112670002', 'Siti Fatoyah', NULL, 'tanaman pangan', '0.65', NULL);
INSERT INTO `tb_petani` VALUES (78, 'K046', '3506221007830006', 'Suwarno Hasan R', NULL, 'tanaman pangan', '0.35', NULL);
INSERT INTO `tb_petani` VALUES (79, 'K046', '1205520108116500340', 'Srinatun', NULL, 'tanaman pangan', '0.5', NULL);
INSERT INTO `tb_petani` VALUES (80, 'K046', '3506221109580001', 'Shoib', NULL, 'tanaman pangan', '0.5', NULL);
INSERT INTO `tb_petani` VALUES (81, 'K046', '3506226306840001', 'Siti Aminah', NULL, 'tanaman pangan', '0.5', NULL);
INSERT INTO `tb_petani` VALUES (82, 'K046', '3506220604740002', 'Gunawan', NULL, 'tanaman pangan', '0.4', NULL);
INSERT INTO `tb_petani` VALUES (83, 'K046', '3506220502520001', 'Solihin', NULL, 'tanaman pangan', '0.4', NULL);
INSERT INTO `tb_petani` VALUES (84, 'K046', '3506225210810002', 'Binti Rofi\'Ah', NULL, 'tanaman pangan', '0.5', NULL);
INSERT INTO `tb_petani` VALUES (85, 'K046', '3506226507760001', 'Listiani', NULL, 'tanaman pangan', '0.6', NULL);
INSERT INTO `tb_petani` VALUES (86, 'K046', '3506223112420002', 'Nuhudin', NULL, 'tanaman pangan', '0.7', NULL);
INSERT INTO `tb_petani` VALUES (87, 'K046', '3506220107470005', 'Kumaidi', NULL, 'tanaman pangan', '0.5', NULL);
INSERT INTO `tb_petani` VALUES (88, 'K046', '3506222706910001', 'Tria Setyawan', NULL, 'tanaman pangan', '0.35', NULL);
INSERT INTO `tb_petani` VALUES (89, 'K046', '3506222312890002', 'Nasihudin', NULL, 'tanaman pangan', '0.35', NULL);
INSERT INTO `tb_petani` VALUES (90, 'K046', '3506224206880003', 'Anik Wijayanah', NULL, 'tanaman pangan', '0.5', NULL);
INSERT INTO `tb_petani` VALUES (91, 'K046', '3506224505810006', 'Retno Purwanti', NULL, 'tanaman pangan', '0.6', NULL);
INSERT INTO `tb_petani` VALUES (92, 'K046', '3506221201760001', 'M. Zunus', NULL, 'tanaman pangan', '0.35', NULL);
INSERT INTO `tb_petani` VALUES (93, 'K046', '3506221012690005', 'Ali Rofi\'I', NULL, 'tanaman pangan', '0.75', NULL);
INSERT INTO `tb_petani` VALUES (94, 'K046', '3506220211720001', 'Ibnu Mas\'Ud', NULL, 'tanaman pangan', '0.35', NULL);
INSERT INTO `tb_petani` VALUES (95, 'K046', '3506221606670001', 'Ibnu Malik', NULL, 'tanaman pangan', '0.6', NULL);
INSERT INTO `tb_petani` VALUES (96, 'K046', '3506220107600097', 'Wasid', NULL, 'tanaman pangan', '0.65', NULL);
INSERT INTO `tb_petani` VALUES (97, 'K046', '3506221402740002', 'Agus Salim', NULL, 'tanaman pangan', '0.55', NULL);
INSERT INTO `tb_petani` VALUES (98, 'K046', '3506222805580001', 'Rebo', NULL, 'tanaman pangan', '0.7', NULL);
INSERT INTO `tb_petani` VALUES (99, 'K046', '3506220106580003', 'Nahrowi', NULL, 'tanaman pangan', '0.35', NULL);
INSERT INTO `tb_petani` VALUES (100, 'K046', '3506220109560001', 'Suwaji', NULL, 'tanaman pangan', '0.7', NULL);
INSERT INTO `tb_petani` VALUES (101, 'K046', '3506221510570002', 'Mahsun', NULL, 'tanaman pangan', '0.85', NULL);
INSERT INTO `tb_petani` VALUES (102, 'K046', '3506225208750002', 'Sumiati', NULL, 'tanaman pangan', '0.4', NULL);
INSERT INTO `tb_petani` VALUES (103, 'K046', '3506220107630076', 'Nur Wakid', NULL, 'tanaman pangan', '0.35', NULL);
INSERT INTO `tb_petani` VALUES (104, 'K046', '3506220902570001', 'Suwito', NULL, 'tanaman pangan', '0.35', NULL);
INSERT INTO `tb_petani` VALUES (105, 'K046', '3506221507290003', 'M. Ridwan', NULL, 'tanaman pangan', '0.7', NULL);
INSERT INTO `tb_petani` VALUES (106, 'K046', '3506221605840001', 'Moh. Adi Maqfur', NULL, 'tanaman pangan', '0.35', NULL);
INSERT INTO `tb_petani` VALUES (107, 'K046', '3506220107420061', 'M. Sholeh', NULL, 'tanaman pangan', '0.35', NULL);
INSERT INTO `tb_petani` VALUES (108, 'K046', '3506220611590001', 'Sujarwanto', NULL, 'tanaman pangan', '0.7', NULL);
INSERT INTO `tb_petani` VALUES (109, 'K046', '3506223103670002', 'Mat Jupri', NULL, 'tanaman pangan', '0.7', NULL);
INSERT INTO `tb_petani` VALUES (110, 'K046', '3506224107390027', 'Sulastri', NULL, 'tanaman pangan', '0.35', NULL);
INSERT INTO `tb_petani` VALUES (111, 'K046', '3506220107590076', 'Fauzin', NULL, 'tanaman pangan', '0.35', NULL);
INSERT INTO `tb_petani` VALUES (112, 'K046', '3506220107500066', 'Kusnindar', NULL, 'tanaman pangan', '0.5', NULL);
INSERT INTO `tb_petani` VALUES (113, 'K046', '3506220107470047', 'Kusnun', NULL, 'tanaman pangan', '0.5', NULL);
INSERT INTO `tb_petani` VALUES (114, 'K046', '3506225502660001', 'Suyati', NULL, 'tanaman pangan', '0.35', NULL);
INSERT INTO `tb_petani` VALUES (115, 'K046', '3506221911650003', 'Abdl Wachid', NULL, 'tanaman pangan', '0.5', NULL);
INSERT INTO `tb_petani` VALUES (116, 'K046', '3506220107350028', 'Kabul Mustajab H', NULL, 'tanaman pangan', '0.5', NULL);
INSERT INTO `tb_petani` VALUES (117, 'K046', '3506220107600116', 'Mat Salem', NULL, 'tanaman pangan', '0.35', NULL);
INSERT INTO `tb_petani` VALUES (118, 'K046', '3506221608630003', 'Yusup', NULL, 'tanaman pangan', '0.35', NULL);
INSERT INTO `tb_petani` VALUES (119, 'K046', '3506224407800006', 'Siti Anhariyah', NULL, 'tanaman pangan', '0.5', NULL);
INSERT INTO `tb_petani` VALUES (120, 'K046', '3506221704600001', 'Nuhanto', NULL, 'tanaman pangan', '0.5', NULL);
INSERT INTO `tb_petani` VALUES (121, 'K046', '3506220712660001', 'Didik Restuyono', NULL, 'tanaman pangan', '0.6', NULL);
INSERT INTO `tb_petani` VALUES (122, 'K046', '3506221511770002', 'Mukhatip', NULL, 'tanaman pangan', '0.5', NULL);
INSERT INTO `tb_petani` VALUES (123, 'K046', '0826/13.2006/94', 'Mutakrip', NULL, 'tanaman pangan', '0.5', NULL);
INSERT INTO `tb_petani` VALUES (124, 'K046', '3506224107500087', 'Sripah', NULL, 'tanaman pangan', '0.35', NULL);
INSERT INTO `tb_petani` VALUES (125, 'K046', '3506220107600154', 'Kariyono', NULL, 'tanaman pangan', '0.7', NULL);
INSERT INTO `tb_petani` VALUES (126, 'K046', '3506221901490001', 'Kuswadi', NULL, 'tanaman pangan', '0.7', NULL);
INSERT INTO `tb_petani` VALUES (127, 'K046', '3506221601740002', 'M. Sholeh', NULL, 'tanaman pangan', '1.35', NULL);
INSERT INTO `tb_petani` VALUES (128, 'K046', '3506221208820004', 'Suwito', NULL, 'tanaman pangan', '0.5', NULL);
INSERT INTO `tb_petani` VALUES (129, 'K046', '3506220501580001', 'Sudiono', NULL, 'tanaman pangan', '0.5', NULL);
INSERT INTO `tb_petani` VALUES (130, 'K046', '3506222608690001', 'Sholeh', NULL, 'tanaman pangan', '0.5', NULL);
INSERT INTO `tb_petani` VALUES (131, 'K046', '3506225903730002', 'Siti Kuzaiman', NULL, 'tanaman pangan', '0.6', NULL);
INSERT INTO `tb_petani` VALUES (132, 'K046', '3506225010890002', 'Daril Muniron', NULL, 'tanaman pangan', '0.5', NULL);
INSERT INTO `tb_petani` VALUES (133, 'K046', '3506221808500001', 'Mustakim', NULL, 'tanaman pangan', '0.7', NULL);
INSERT INTO `tb_petani` VALUES (134, 'K046', '3506222012880001', 'Andi Rahman', NULL, 'tanaman pangan', '0.45', NULL);
INSERT INTO `tb_petani` VALUES (135, 'K046', '3506224106770004', 'Yuni Datun Nikmah', NULL, 'tanaman pangan', '0.5', NULL);
INSERT INTO `tb_petani` VALUES (136, 'K046', '3506222604950003', 'Imam Subhan R', NULL, 'tanaman pangan', '0.65', NULL);
INSERT INTO `tb_petani` VALUES (137, 'K046', '3506221012660001', 'Mubasir', NULL, 'tanaman pangan', '0.7', NULL);
INSERT INTO `tb_petani` VALUES (138, 'K046', '3571020506750013', 'Qomari', NULL, 'tanaman pangan', '0.35', NULL);
INSERT INTO `tb_petani` VALUES (139, 'K046', '3506222106770006', 'Aris Zamzani', NULL, 'tanaman pangan', '0.5', NULL);
INSERT INTO `tb_petani` VALUES (140, 'K046', '3506225207820002', 'Zuli Ariyanti', NULL, 'tanaman pangan', '0.5', NULL);
INSERT INTO `tb_petani` VALUES (141, 'K046', '3506224107500084', 'Istonik', NULL, 'tanaman pangan', '0.35', NULL);
INSERT INTO `tb_petani` VALUES (142, 'K046', '3506222808750004', 'Zainal Abidin', NULL, 'tanaman pangan', '1.5', NULL);
INSERT INTO `tb_petani` VALUES (143, 'K046', '3506224511770002', 'Siti Musringan', NULL, 'tanaman pangan', '0.5', NULL);
INSERT INTO `tb_petani` VALUES (144, 'K046', '3506225807530001', 'Samini', NULL, 'tanaman pangan', '0.4', NULL);
INSERT INTO `tb_petani` VALUES (145, 'K047', '3506220107520064', 'Imam Arifin', NULL, 'tanaman pangan', '0.25', NULL);
INSERT INTO `tb_petani` VALUES (146, 'K047', '3506224107550075', 'Umi Nadhiroh', NULL, 'tanaman pangan', '0.5', NULL);
INSERT INTO `tb_petani` VALUES (147, 'K047', '3506221511770002', 'Mukhatip', NULL, 'tanaman pangan', '0.35', NULL);
INSERT INTO `tb_petani` VALUES (148, 'K047', '3506226205670001', 'Kurin Nasikah', NULL, 'tanaman pangan', '0.65', NULL);
INSERT INTO `tb_petani` VALUES (149, 'K047', '3506221009670001', 'Imam Sopingi', NULL, 'tanaman pangan', '0.5', NULL);
INSERT INTO `tb_petani` VALUES (150, 'K047', '3506221510570002', 'Mahsun', NULL, 'tanaman pangan', '0.25', NULL);
INSERT INTO `tb_petani` VALUES (151, 'K047', '3506220610890002', 'Syamsul Arifin', NULL, 'tanaman pangan', '0.5', NULL);
INSERT INTO `tb_petani` VALUES (152, 'K047', '3506220211640002', 'Mashuri', NULL, 'tanaman pangan', '0.25', NULL);
INSERT INTO `tb_petani` VALUES (153, 'K047', '3506222905910001', 'Agus Nursani', NULL, 'tanaman pangan', '0.35', NULL);
INSERT INTO `tb_petani` VALUES (154, 'K047', '3506224107530094', 'Siti Mujipah', NULL, 'tanaman pangan', '0.5', NULL);
INSERT INTO `tb_petani` VALUES (155, 'K047', '3506221611830002', 'Moh. Zaim Mas\'Ud', NULL, 'tanaman pangan', '0.25', NULL);
INSERT INTO `tb_petani` VALUES (156, 'K047', '3506221711700001', 'Basuni Ahmad', NULL, 'tanaman pangan', '0.5', NULL);
INSERT INTO `tb_petani` VALUES (157, 'K047', '3506222501650001', 'Imam Muchson', NULL, 'tanaman pangan', '0.25', NULL);
INSERT INTO `tb_petani` VALUES (158, 'K047', '3506220107630099', 'Khoirul Umam', NULL, 'tanaman pangan', '0.5', NULL);
INSERT INTO `tb_petani` VALUES (159, 'K047', '3506221212610002', 'Moch. Musman', NULL, 'tanaman pangan', '0.25', NULL);
INSERT INTO `tb_petani` VALUES (160, 'K047', '3506226304590002', 'Zumaroh', NULL, 'tanaman pangan', '0.35', NULL);
INSERT INTO `tb_petani` VALUES (161, 'K047', '3506221210880002', 'M. Aris Sugiono', NULL, 'tanaman pangan', '0.25', NULL);
INSERT INTO `tb_petani` VALUES (162, 'K047', '3506221107740002', 'Zainal Arifin', NULL, 'tanaman pangan', '0.75', NULL);
INSERT INTO `tb_petani` VALUES (163, 'K047', '3506220209620001', 'Mujamil', NULL, 'tanaman pangan', '1', NULL);
INSERT INTO `tb_petani` VALUES (164, 'K047', '3506220301420002', 'Mujari', NULL, 'tanaman pangan', '0.45', NULL);
INSERT INTO `tb_petani` VALUES (165, 'K047', '3506229808520001', 'Siti Munawaroh', NULL, 'tanaman pangan', '0.35', NULL);
INSERT INTO `tb_petani` VALUES (166, 'K047', '3506224708900002', 'Indah Agustian', NULL, 'tanaman pangan', '0.5', NULL);
INSERT INTO `tb_petani` VALUES (167, 'K047', '3506220107450039', 'M. Shodiq', NULL, 'tanaman pangan', '0.7', NULL);
INSERT INTO `tb_petani` VALUES (168, 'K047', '3506220602790001', 'Miftahul Huda', NULL, 'tanaman pangan', '0.28', NULL);
INSERT INTO `tb_petani` VALUES (169, 'K047', '3506221005700006', 'Alfin', NULL, 'tanaman pangan', '0.53', NULL);
INSERT INTO `tb_petani` VALUES (170, 'K047', '3506225608850003', 'Khoirul Abidah', NULL, 'tanaman pangan', '0.4', NULL);
INSERT INTO `tb_petani` VALUES (171, 'K007', '3506220107450538', 'Mashuri', NULL, 'tanaman pangan', '0.17', NULL);
INSERT INTO `tb_petani` VALUES (172, 'K007', '3506222709600001', 'Ahmad Mustajab', NULL, 'tanaman pangan', '0.35', NULL);
INSERT INTO `tb_petani` VALUES (173, 'K007', '3506130512720001', 'Paiman', NULL, 'tanaman pangan', '0.5', NULL);
INSERT INTO `tb_petani` VALUES (174, 'K007', '3506220510670001', 'Budairi', NULL, 'tanaman pangan', '0.5', NULL);
INSERT INTO `tb_petani` VALUES (175, 'K007', '3506224107580133', 'Maspupah', NULL, 'tanaman pangan', '1', NULL);
INSERT INTO `tb_petani` VALUES (176, 'K007', '3506220107520064', 'Imam Arifin', NULL, 'tanaman pangan', '0.35', NULL);
INSERT INTO `tb_petani` VALUES (177, 'K007', '3506220107550084', 'Kusni', NULL, 'tanaman pangan', '1', NULL);
INSERT INTO `tb_petani` VALUES (178, 'K007', '3506222906560001', 'Mujali', NULL, 'tanaman pangan', '0.35', NULL);
INSERT INTO `tb_petani` VALUES (179, 'K007', '3506220308840005', 'Shofirudinazzi', NULL, 'tanaman pangan', '0.5', NULL);
INSERT INTO `tb_petani` VALUES (180, 'K007', '3506220704610003', 'Supardi', NULL, 'tanaman pangan', '0.75', NULL);
INSERT INTO `tb_petani` VALUES (181, 'K007', '3506220107570092', 'Misran', NULL, 'tanaman pangan', '0.5', NULL);
INSERT INTO `tb_petani` VALUES (182, 'K007', '3506222010580001', 'Mashari', NULL, 'tanaman pangan', '1', NULL);
INSERT INTO `tb_petani` VALUES (183, 'K007', '3506227001850002', 'Anita Eviasih', NULL, 'tanaman pangan', '1', NULL);
INSERT INTO `tb_petani` VALUES (184, 'K007', '3506220401710003', 'M. Farihin', NULL, 'tanaman pangan', '0.25', NULL);
INSERT INTO `tb_petani` VALUES (185, 'K007', '3506222910880001', 'Moh. Sholikin', NULL, 'tanaman pangan', '0.5', NULL);
INSERT INTO `tb_petani` VALUES (186, 'K007', '3506221501740002', 'Mohammad Sholeh', NULL, 'tanaman pangan', '1.25', NULL);
INSERT INTO `tb_petani` VALUES (187, 'K007', '3506221212600002', 'Hariadi', NULL, 'tanaman pangan', '0.35', NULL);
INSERT INTO `tb_petani` VALUES (188, 'K007', '3506223112540005', 'Ahmad Dirok', NULL, 'tanaman pangan', '0.25', NULL);
INSERT INTO `tb_petani` VALUES (189, 'K007', '3506225108530001', 'Mundayati', NULL, 'tanaman pangan', '0.35', NULL);
INSERT INTO `tb_petani` VALUES (190, 'K007', '3506221107590002', 'Tohid', NULL, 'tanaman pangan', '1', NULL);
INSERT INTO `tb_petani` VALUES (191, 'K007', '3506222401880001', 'Setiawan', NULL, 'tanaman pangan', '0.55', NULL);
INSERT INTO `tb_petani` VALUES (192, 'K007', '3506220404660004', 'Wasito', NULL, 'tanaman pangan', '0.5', NULL);
INSERT INTO `tb_petani` VALUES (193, 'K007', '3506221107740002', 'Sutiyono', NULL, 'tanaman pangan', '1', NULL);
INSERT INTO `tb_petani` VALUES (194, 'K007', '3506221107740002', 'Zainal Arifin', NULL, 'tanaman pangan', '0.5', NULL);
INSERT INTO `tb_petani` VALUES (195, 'K007', '3506223107570001', 'M. Hamim Tohari', NULL, 'tanaman pangan', '0.25', NULL);
INSERT INTO `tb_petani` VALUES (196, 'K007', '3506220705590001', 'Moh. Soleh', NULL, 'tanaman pangan', '1', NULL);
INSERT INTO `tb_petani` VALUES (197, 'K007', '3506226506700002', 'Erma Wahyuni', NULL, 'tanaman pangan', '2', NULL);
INSERT INTO `tb_petani` VALUES (198, 'K007', '3506225910640001', 'Siti Asfiyatul Khoiriyah', NULL, 'tanaman pangan', '2', NULL);
INSERT INTO `tb_petani` VALUES (199, 'K007', '3506224107470044', 'Ngulamah', NULL, 'tanaman pangan', '1', NULL);
INSERT INTO `tb_petani` VALUES (200, 'K007', '3506223004940002', 'Arif Rahman Hakim', NULL, 'tanaman pangan', '0.5', NULL);
INSERT INTO `tb_petani` VALUES (201, 'K011', '3506221606640003', 'Ansori', NULL, 'tanaman pangan', '1', NULL);
INSERT INTO `tb_petani` VALUES (202, 'K011', '3506221607860002', 'Ibnu Nandir', NULL, 'tanaman pangan', '0.5', NULL);
INSERT INTO `tb_petani` VALUES (203, 'K011', '3506220107400079', 'Masduqi', NULL, 'tanaman pangan', '0.35', NULL);
INSERT INTO `tb_petani` VALUES (204, 'K011', '3506220107560062', 'Sugito', NULL, 'tanaman pangan', '1.5', NULL);
INSERT INTO `tb_petani` VALUES (205, 'K011', '3506220107520047', 'Kamami', NULL, 'tanaman pangan', '0.75', NULL);
INSERT INTO `tb_petani` VALUES (206, 'K011', '3506220107420066', 'Kurmen', NULL, 'tanaman pangan', '0.17', NULL);
INSERT INTO `tb_petani` VALUES (207, 'K011', '3506220107620063', 'Gufron', NULL, 'tanaman pangan', '0.35', NULL);
INSERT INTO `tb_petani` VALUES (208, 'K011', '3506220606740001', 'Saifudin', NULL, 'tanaman pangan', '0.75', NULL);
INSERT INTO `tb_petani` VALUES (209, 'K011', '3506220107550082', 'Muryani', NULL, 'tanaman pangan', '0.35', NULL);
INSERT INTO `tb_petani` VALUES (210, 'K011', '3506220302390001', 'Komari', NULL, 'tanaman pangan', '0.5', NULL);
INSERT INTO `tb_petani` VALUES (211, 'K011', '3506221310530001', 'Muji Kuwat', NULL, 'tanaman pangan', '0.25', NULL);
INSERT INTO `tb_petani` VALUES (212, 'K011', '3506220107480056', 'Supardi', NULL, 'tanaman pangan', '0.17', NULL);
INSERT INTO `tb_petani` VALUES (213, 'K011', '3506222606520001', 'Suwarto', NULL, 'tanaman pangan', '0.35', NULL);
INSERT INTO `tb_petani` VALUES (214, 'K011', '3506220405660001', 'Sudirman', NULL, 'tanaman pangan', '1.25', NULL);
INSERT INTO `tb_petani` VALUES (215, 'K011', '3506220107580105', 'Waloyo', NULL, 'tanaman pangan', '0.5', NULL);
INSERT INTO `tb_petani` VALUES (216, 'K011', '3506222501730001', 'M. Rois Subki', NULL, 'tanaman pangan', '0.5', NULL);
INSERT INTO `tb_petani` VALUES (217, 'K011', '3506221004590001', 'Salam Mustofa', NULL, 'tanaman pangan', '0.17', NULL);
INSERT INTO `tb_petani` VALUES (218, 'K011', '3506220611520001', 'Sumiran', NULL, 'tanaman pangan', '1.25', NULL);
INSERT INTO `tb_petani` VALUES (219, 'K011', '3506224705670003', 'Sriyah', NULL, 'tanaman pangan', '0.17', NULL);
INSERT INTO `tb_petani` VALUES (220, 'K011', '3506220107450046', 'Suladin', NULL, 'tanaman pangan', '0.35', NULL);
INSERT INTO `tb_petani` VALUES (221, 'K011', '3506221503790001', 'Priyanto', NULL, 'tanaman pangan', '0.35', NULL);
INSERT INTO `tb_petani` VALUES (222, 'K011', '3506220210700001', 'Sulton Mustofa', NULL, 'tanaman pangan', '0.5', NULL);
INSERT INTO `tb_petani` VALUES (223, 'K011', '3506221705800003', 'Moh. Slamet S', NULL, 'tanaman pangan', '0.17', NULL);
INSERT INTO `tb_petani` VALUES (224, 'K011', '3506224706730004', 'Siti Zuhriyati', NULL, 'tanaman pangan', '1.17', NULL);
INSERT INTO `tb_petani` VALUES (225, 'K011', '3506220107630126', 'Mat Choiri', NULL, 'tanaman pangan', '0.17', NULL);
INSERT INTO `tb_petani` VALUES (226, 'K011', '3506220107420067', 'Kurmat', NULL, 'tanaman pangan', '0.17', NULL);
INSERT INTO `tb_petani` VALUES (227, 'K011', '3506224107560065', 'Amanah', NULL, 'tanaman pangan', '0.5', NULL);
INSERT INTO `tb_petani` VALUES (228, 'K011', '3506220107400051', 'Muhammad Abdan', NULL, 'tanaman pangan', '0.17', NULL);
INSERT INTO `tb_petani` VALUES (229, 'K011', '3506222506510001', 'Mukasim', NULL, 'tanaman pangan', '0.25', NULL);
INSERT INTO `tb_petani` VALUES (230, 'K011', '3506220704610003', 'Supardi', NULL, 'tanaman pangan', '0.75', NULL);
INSERT INTO `tb_petani` VALUES (231, 'K033', '3506220107510059', 'Safuan', 'Dsn. Banyakan 02/01', 'tanaman pangan', '0.5', NULL);
INSERT INTO `tb_petani` VALUES (232, 'K033', '3506220107560056', 'Nurhudi', 'Dsn. Margosari 02/01', 'tanaman pangan', '0.17', NULL);
INSERT INTO `tb_petani` VALUES (233, 'K033', '3506224107570073', 'Napsiyah', 'Dsn. Banyakan 01/02', 'tanaman pangan', '0.35', NULL);
INSERT INTO `tb_petani` VALUES (234, 'K033', '3506221711600001', 'Hatimodin', 'Dsn. Nglaban 01/01', 'tanaman pangan', '0.5', NULL);
INSERT INTO `tb_petani` VALUES (235, 'K033', '3506223112680007', 'Muhson', 'Dsn. Banyakan 02/01 ', 'tanaman pangan', '0.35', NULL);
INSERT INTO `tb_petani` VALUES (236, 'K033', '3506223112540005', 'Ahmad Dirok', 'Dsn. Banyakan 02/01', 'tanaman pangan', '0.35', NULL);
INSERT INTO `tb_petani` VALUES (237, 'K033', '3506220107400051', 'Mohamad Abdan', 'Dsn. Banyakan 03/01', 'tanaman pangan', '0.5', NULL);
INSERT INTO `tb_petani` VALUES (238, 'K033', '3506222112450001', 'Sujud', 'Dsn. Margosari 06/02', 'tanaman pangan', '1.17', NULL);
INSERT INTO `tb_petani` VALUES (239, 'K033', '3506222003600001', 'Imam Mauludin', 'Dsn. Banyakan 01/01', 'tanaman pangan', '0.85', NULL);
INSERT INTO `tb_petani` VALUES (240, 'K033', '3506220107500077', 'Kabul', 'Dsn. Margosari 05/02', 'tanaman pangan', '0.35', NULL);
INSERT INTO `tb_petani` VALUES (241, 'K033', '3506062509850001', 'Abdul Rohman', 'Dsn Mergosono 02/01', 'tanaman pangan', '0.4', NULL);
INSERT INTO `tb_petani` VALUES (242, 'K033', '3506221607720001', 'Masakur', 'Dsn. Margosari 04/02', 'tanaman pangan', '0.35', NULL);
INSERT INTO `tb_petani` VALUES (243, 'K033', '3506220306740002', 'Wasito', 'Dsn. Mergosono 02/01', 'tanaman pangan', '0.17', NULL);
INSERT INTO `tb_petani` VALUES (244, 'K033', '3506222910880001', 'Moh. Sholikin', NULL, 'tanaman pangan', '0.5', NULL);
INSERT INTO `tb_petani` VALUES (245, 'K033', '3506220501610001', 'Sholikin Huda', 'Dsn. Manyaran 01/01', 'tanaman pangan', '0.35', NULL);
INSERT INTO `tb_petani` VALUES (246, 'K033', '3506223112520002', 'Moh. Kodim', NULL, 'tanaman pangan', '0.17', NULL);
INSERT INTO `tb_petani` VALUES (247, 'K033', '5306220107550084', 'Kusni', NULL, 'tanaman pangan', '1.35', NULL);
INSERT INTO `tb_petani` VALUES (248, 'K033', '3506220107430056', 'Sholihin', NULL, 'tanaman pangan', '0.17', NULL);
INSERT INTO `tb_petani` VALUES (249, 'K033', '3506221502520002', 'Sumardi', NULL, 'tanaman pangan', '0.17', NULL);
INSERT INTO `tb_petani` VALUES (250, 'K033', '3506220503410002', 'Chabib', NULL, 'tanaman pangan', '1.17', NULL);
INSERT INTO `tb_petani` VALUES (251, 'K033', '3506222005710001', 'Eddy Meinanto', NULL, 'tanaman pangan', '0.17', NULL);
INSERT INTO `tb_petani` VALUES (252, 'K033', '3506220106900002', 'Mohamad Asrofi', NULL, 'tanaman pangan', '0.17', NULL);
INSERT INTO `tb_petani` VALUES (253, 'K033', '3506221211710001', 'Mohamad Ali Mashar', NULL, 'tanaman pangan', '0.5', NULL);
INSERT INTO `tb_petani` VALUES (254, 'K033', '3506221903380001', 'Mohamad Rosyid', NULL, 'tanaman pangan', '0.35', NULL);
INSERT INTO `tb_petani` VALUES (255, 'K033', '3506220412570002', 'Ashari', NULL, 'tanaman pangan', '0.17', NULL);
INSERT INTO `tb_petani` VALUES (256, 'K033', '3506221103520001', 'Rohmad', NULL, 'tanaman pangan', '0.17', NULL);
INSERT INTO `tb_petani` VALUES (257, 'K033', '3506220107600099', 'Isnande', NULL, 'tanaman pangan', '0.65', NULL);
INSERT INTO `tb_petani` VALUES (258, 'K033', '3506220305520001', 'Mubakah', NULL, 'tanaman pangan', '0.5', NULL);
INSERT INTO `tb_petani` VALUES (259, 'K033', '3506226101430001', 'Muzaroah', NULL, 'tanaman pangan', '0.35', NULL);
INSERT INTO `tb_petani` VALUES (260, 'K033', '3506220304760001', 'Mukibin', NULL, 'tanaman pangan', '0.17', NULL);
INSERT INTO `tb_petani` VALUES (261, 'K033', '3506220107580050', 'Hardi', NULL, 'tanaman pangan', '0.17', NULL);
INSERT INTO `tb_petani` VALUES (262, 'K033', '3506220404660004', 'Sutiyono', NULL, 'tanaman pangan', '1.35', NULL);
INSERT INTO `tb_petani` VALUES (263, 'K033', '3506220107560060', 'Dardiri', NULL, 'tanaman pangan', '0.17', NULL);
INSERT INTO `tb_petani` VALUES (264, 'K033', '3506220107580031', 'Mustofa', NULL, 'tanaman pangan', '0.5', NULL);
INSERT INTO `tb_petani` VALUES (265, 'K033', '3506224107860069', 'Nur Kholidah', NULL, 'tanaman pangan', '0.17', NULL);
INSERT INTO `tb_petani` VALUES (266, 'K033', '3506221506550002', 'Sukarlin', NULL, 'tanaman pangan', '0.35', NULL);
INSERT INTO `tb_petani` VALUES (267, 'K033', '3506222801640001', 'Ali Muklasin', NULL, 'tanaman pangan', '0.85', NULL);
INSERT INTO `tb_petani` VALUES (268, 'K033', '3571012704540004', 'Moh. Syahri', NULL, 'tanaman pangan', '0.35', NULL);
INSERT INTO `tb_petani` VALUES (269, 'K033', '3506222303700001', 'Djono', NULL, 'tanaman pangan', '0.17', NULL);
INSERT INTO `tb_petani` VALUES (270, 'K033', '3506220602590001', 'Jumani', NULL, 'tanaman pangan', '0.65', NULL);
INSERT INTO `tb_petani` VALUES (271, 'K033', '3506222012500001', 'Yusuf Sugianto H', NULL, 'tanaman pangan', '0.17', NULL);
INSERT INTO `tb_petani` VALUES (272, 'K033', '3506220503600001', 'Sugito', NULL, 'tanaman pangan', '0.17', NULL);
INSERT INTO `tb_petani` VALUES (273, 'K033', '3506220107740064', 'Ulum', NULL, 'tanaman pangan', '0.35', NULL);
INSERT INTO `tb_petani` VALUES (274, 'K033', '3506220611710002', 'Adib Aminoto', NULL, 'tanaman pangan', '0.17', NULL);
INSERT INTO `tb_petani` VALUES (275, 'K033', '3506224107490048', 'Mahsunatun', NULL, 'tanaman pangan', '0.35', NULL);
INSERT INTO `tb_petani` VALUES (276, 'K033', '3506220606700002', 'Syamsul', NULL, 'tanaman pangan', '0.5', NULL);
INSERT INTO `tb_petani` VALUES (277, 'K033', '3506224705670003', 'Sriyah', NULL, 'tanaman pangan', '0.17', NULL);
INSERT INTO `tb_petani` VALUES (278, 'K033', '3506220605740002', 'Nur Cholis', NULL, 'tanaman pangan', '0.17', NULL);
INSERT INTO `tb_petani` VALUES (279, 'K033', '3506221708690002', 'Yajib', NULL, 'tanaman pangan', '0.17', NULL);
INSERT INTO `tb_petani` VALUES (280, 'K033', '3506221408820002', 'Agus Suwandi', NULL, 'tanaman pangan', '0.17', NULL);
INSERT INTO `tb_petani` VALUES (281, 'K033', '3506220406680003', 'Sugianto', NULL, 'tanaman pangan', '0.17', NULL);
INSERT INTO `tb_petani` VALUES (282, 'K033', '3506220107350034', 'Rukani', NULL, 'tanaman pangan', '0.17', NULL);
INSERT INTO `tb_petani` VALUES (283, 'K033', '3506222709600001', 'Ahmad Mustajab', NULL, 'tanaman pangan', '0.35', NULL);
INSERT INTO `tb_petani` VALUES (284, 'K033', '3506220711910002', 'Mohamad Noviantoro', NULL, 'tanaman pangan', '0.5', NULL);
INSERT INTO `tb_petani` VALUES (285, 'K033', '3506220107350033', 'Suyatmo', NULL, 'tanaman pangan', '0.17', NULL);
INSERT INTO `tb_petani` VALUES (286, 'K033', '3506220107450063', 'Samsudin', NULL, 'tanaman pangan', '0.17', NULL);
INSERT INTO `tb_petani` VALUES (287, 'K033', '3506220507730004', 'Madhoiri', NULL, 'tanaman pangan', '0.35', NULL);
INSERT INTO `tb_petani` VALUES (288, 'K033', '3506220107570092', 'Misran', NULL, 'tanaman pangan', '0.35', NULL);
INSERT INTO `tb_petani` VALUES (289, 'K033', '3506220107510054', 'Tawar', NULL, 'tanaman pangan', '0.17', NULL);
INSERT INTO `tb_petani` VALUES (290, 'K033', '3506221201880002', 'Moh. Asnaim', NULL, 'tanaman pangan', '0.65', NULL);
INSERT INTO `tb_petani` VALUES (291, 'K033', '3506220107480071', 'Nur Kamid', NULL, 'tanaman pangan', '0.5', NULL);
INSERT INTO `tb_petani` VALUES (292, 'K033', '3506221008770001', 'Darno', NULL, 'tanaman pangan', '0.35', NULL);
INSERT INTO `tb_petani` VALUES (293, 'K033', '3506221404680001', 'Siswanto', NULL, 'tanaman pangan', '0.85', NULL);
INSERT INTO `tb_petani` VALUES (294, 'K033', '3506220107570094', 'Suryono', NULL, 'tanaman pangan', '0.35', NULL);
INSERT INTO `tb_petani` VALUES (295, 'K033', '3506222907770003', 'Nuryahman', NULL, 'tanaman pangan', '0.17', NULL);
INSERT INTO `tb_petani` VALUES (296, 'K033', '3506221102680001', 'Subakir', NULL, 'tanaman pangan', '0.35', NULL);
INSERT INTO `tb_petani` VALUES (297, 'K033', '3506220107580102', 'Masrodi', NULL, 'tanaman pangan', '0.65', NULL);
INSERT INTO `tb_petani` VALUES (298, 'K033', '3506221007760004', 'Hamim Mashari', NULL, 'tanaman pangan', '0.17', NULL);
INSERT INTO `tb_petani` VALUES (299, 'K033', '3506220704770002', 'Nasihin', NULL, 'tanaman pangan', '0.17', NULL);
INSERT INTO `tb_petani` VALUES (300, 'K033', '3506220107710075', 'Wagito', NULL, 'tanaman pangan', '0.35', NULL);
INSERT INTO `tb_petani` VALUES (301, 'K033', '3506225209780001', 'Dewi Fitriati', NULL, 'tanaman pangan', '0.17', NULL);
INSERT INTO `tb_petani` VALUES (302, 'K033', '3506221069890002', 'Moh. Saiful Anwar', NULL, 'tanaman pangan', '0.17', NULL);
INSERT INTO `tb_petani` VALUES (303, 'K033', '3506222103520001', 'Subianto', NULL, 'tanaman pangan', '0.35', NULL);
INSERT INTO `tb_petani` VALUES (304, 'K033', '3506221104670002', 'Suwandi', NULL, 'tanaman pangan', '0.17', NULL);
INSERT INTO `tb_petani` VALUES (305, 'K033', '3506226402680001', 'Sri Sugihastuti', NULL, 'tanaman pangan', '0.35', NULL);
INSERT INTO `tb_petani` VALUES (306, 'K033', '3518060508700001', 'Muhammad Syaroni', NULL, 'tanaman pangan', '0.17', NULL);
INSERT INTO `tb_petani` VALUES (307, 'K033', '3571011004800010', 'Alib', NULL, 'tanaman pangan', '0.35', NULL);
INSERT INTO `tb_petani` VALUES (308, 'K033', '3506225509970003', 'Siti Fatimah', NULL, 'tanaman pangan', '0.17', NULL);
INSERT INTO `tb_petani` VALUES (309, 'K033', '3506222601810001', 'Ali Imron', NULL, 'tanaman pangan', '0.17', NULL);
INSERT INTO `tb_petani` VALUES (310, 'K033', '3506224202860003', 'Semi Puji Rahayu', NULL, 'tanaman pangan', '0.17', NULL);
INSERT INTO `tb_petani` VALUES (311, 'K033', '3506220107530046', 'Nursalim', 'Rt 002 Rw 001 Dsn. Sambirejo Ds. Tiron', 'tanaman pangan', '0.175', NULL);
INSERT INTO `tb_petani` VALUES (312, 'K033', '3506226103870001', 'Sutinah', 'Rt 002 Rw 001 Dsn. Mergosono Ds. Banyakan', 'tanaman pangan', '0.35', NULL);
INSERT INTO `tb_petani` VALUES (313, 'K003', '3506130107550107', 'Sunar', 'Rt 001 Rw 002 Dsn. Sumber Gambi Desa Sonorejo Kec. Grogol', 'tanaman pangan', '0.25', NULL);
INSERT INTO `tb_petani` VALUES (314, 'K003', '3506220201750003', 'Ghufron', 'Rt 002 Rw 002 Dsn. Kamal Desa Banyakan', 'tanaman pangan', '0.5', NULL);
INSERT INTO `tb_petani` VALUES (315, 'K003', '3506220706800002', 'Moh. Rifai', 'Rt 002 Rw 002 Dsn. Kamal Desa Banyakan', 'tanaman pangan', '0.5', NULL);
INSERT INTO `tb_petani` VALUES (316, 'K003', '3506222508520002', 'Supadi', 'Rt 003 Rw 001 Dsn. Kamal Desa Banyakan', 'tanaman pangan', '0.25', NULL);
INSERT INTO `tb_petani` VALUES (317, 'K003', '3506222907740002', 'Agus Tamar', 'Rt 002 Rw 002 Dsn. Kamal Desa Banyakan', 'tanaman pangan', '0.5', NULL);
INSERT INTO `tb_petani` VALUES (318, 'K003', '3506220107520053', 'Kadirin', 'Rt 002 Rw 001 Dsn. Kamal Desa Banyakan', 'tanaman pangan', '0.5', NULL);
INSERT INTO `tb_petani` VALUES (319, 'K003', '3506221312610001', 'Suyatin', 'Rt 004 Rw 001 Dsn. Kamal Desa Banyakan', 'tanaman pangan', '0.5', NULL);
INSERT INTO `tb_petani` VALUES (320, 'K003', '3506220708510001', 'Ramidi', 'Rt 004 Rw 001 Dsn. Kamal Desa Banyakan', 'tanaman pangan', '0.75', NULL);
INSERT INTO `tb_petani` VALUES (321, 'K003', '3506220107500072', 'Sukono', 'Rt 004 Rw 001 Dsn. Kamal Desa Banyakan', 'tanaman pangan', '0.5', NULL);
INSERT INTO `tb_petani` VALUES (322, 'K003', '3506221202550001', 'Katimin', 'Rt 002 Rw 002 Dsn. Kamal Desa Banyakan', 'tanaman pangan', '0.5', NULL);
INSERT INTO `tb_petani` VALUES (323, 'K003', '3506220302690003', 'Slamet Hastono', 'Rt 002 Rw 002 Dsn. Kamal Desa Banyakan', 'tanaman pangan', '0.25', NULL);
INSERT INTO `tb_petani` VALUES (324, 'K003', '3506221506580004', 'Marjuli', 'Rt 003 Rw 002 Dsn. Kamal Desa Banyakan', 'tanaman pangan', '0.5', NULL);
INSERT INTO `tb_petani` VALUES (325, 'K003', '3506220107500073', 'Sukemi', 'Rt 003 Rw 001 Dsn. Kamal Desa Banyakan', 'tanaman pangan', '0.25', NULL);
INSERT INTO `tb_petani` VALUES (326, 'K003', '3506221812580001', 'Heli Hadi Suroso', 'Rt 002 Rw 002 Dsn. Kamal Desa Banyakan', 'tanaman pangan', '0.75', NULL);
INSERT INTO `tb_petani` VALUES (327, 'K003', '3506224107530097', 'Siti Djainab', 'Rt 003 Rw 001 Dsn. Kamal Desa Banyakan', 'tanaman pangan', '0.5', NULL);
INSERT INTO `tb_petani` VALUES (328, 'K003', '3506220609900002', 'Eka Pranata', 'Rt 001 Rw 002 Dsn. Kamal Desa Banyakan', 'tanaman pangan', '0.5', NULL);
INSERT INTO `tb_petani` VALUES (329, 'K003', '3506220107530111', 'Kusno', 'Rt 001 Rw 001 Dsn. Kamal Desa Banyakan', 'tanaman pangan', '0.75', NULL);
INSERT INTO `tb_petani` VALUES (330, 'K003', '3506220308730003', 'Sumadi', 'Rt 002 Rw 002 Dsn. Kamal Desa Banyakan', 'tanaman pangan', '0.5', NULL);
INSERT INTO `tb_petani` VALUES (331, 'K003', '3506220809560001', 'Kasiadi', 'Rt 001 Rw 002 Dsn. Kamal Desa Banyakan', 'tanaman pangan', '1.5', NULL);
INSERT INTO `tb_petani` VALUES (332, 'K003', '3506222109780006', 'Mohamad Lutfiali', 'Rt 003 Rw 002 Dsn. Kamal Desa Banyakan', 'tanaman pangan', '0.25', NULL);
INSERT INTO `tb_petani` VALUES (333, 'K003', '3506221312680002', 'Samuji', 'Rt 002 Rw 002 Dsn. Kamal Desa Banyakan', 'tanaman pangan', '0.25', NULL);
INSERT INTO `tb_petani` VALUES (334, 'K003', '3518042708850003', 'Slamet Widodo', 'Rt 002 Rw 003 Desa Sekaran Loceret Nganjuk', 'tanaman pangan', '0.25', NULL);
INSERT INTO `tb_petani` VALUES (335, 'K003', '3506220601770003', 'Abu Katimin', 'Rt 001 Rw 002 Dsn. Kamal Desa Banyakan', 'tanaman pangan', '0.5', NULL);
INSERT INTO `tb_petani` VALUES (337, 'K003', '3506220107830078', 'Moh. Rohim', 'Rt 002 Rw 002 Dsn. Kamal Desa Banyakan', 'tanaman pangan', '0.25', NULL);
INSERT INTO `tb_petani` VALUES (338, 'K003', '3506220611870001', 'Ari Dwi Purnama', 'Rt 001 Rw 002 Dsn. Kamal Desa Banyakan', 'tanaman pangan', '0.5', NULL);
INSERT INTO `tb_petani` VALUES (341, 'K004', '6666666666666666', 'fajar', 'kediri', 'tanaman pangan', '0.698', 'm2');

-- ----------------------------
-- Table structure for tb_poktan
-- ----------------------------
DROP TABLE IF EXISTS `tb_poktan`;
CREATE TABLE `tb_poktan`  (
  `id_poktan` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `id_desa` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `poktan` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_poktan`) USING BTREE,
  INDEX `poktan`(`poktan`) USING BTREE,
  INDEX `tb_poktan_ibfk_1`(`id_desa`) USING BTREE,
  CONSTRAINT `tb_poktan_ibfk_1` FOREIGN KEY (`id_desa`) REFERENCES `tb_desa` (`kode_desa`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tb_poktan
-- ----------------------------
INSERT INTO `tb_poktan` VALUES ('K001', NULL, 'ADEM AYEM');
INSERT INTO `tb_poktan` VALUES ('K002', NULL, 'BUDIDAYA');
INSERT INTO `tb_poktan` VALUES ('K003', '3506222001', 'KAMAL I ');
INSERT INTO `tb_poktan` VALUES ('K004', '3506222001', 'KAMAL II');
INSERT INTO `tb_poktan` VALUES ('K005', NULL, 'KARYO TANI');
INSERT INTO `tb_poktan` VALUES ('K006', NULL, 'KRADENAN');
INSERT INTO `tb_poktan` VALUES ('K007', '3506222001', 'LESTARI');
INSERT INTO `tb_poktan` VALUES ('K008', NULL, 'LESTARI 2');
INSERT INTO `tb_poktan` VALUES ('K009', NULL, 'MAJU TANI');
INSERT INTO `tb_poktan` VALUES ('K010', NULL, 'MANDIRI');
INSERT INTO `tb_poktan` VALUES ('K011', '3506222001', 'MANYAR');
INSERT INTO `tb_poktan` VALUES ('K012', NULL, 'MERGOSONO');
INSERT INTO `tb_poktan` VALUES ('K013', NULL, 'RAHAYU');
INSERT INTO `tb_poktan` VALUES ('K014', NULL, 'RAHAYU 1');
INSERT INTO `tb_poktan` VALUES ('K015', NULL, 'RAHAYU 2');
INSERT INTO `tb_poktan` VALUES ('K016', NULL, 'ROWO MAKMUR');
INSERT INTO `tb_poktan` VALUES ('K017', NULL, 'RUKUN TANI I');
INSERT INTO `tb_poktan` VALUES ('K018', NULL, 'RUKUN TANI II');
INSERT INTO `tb_poktan` VALUES ('K019', NULL, 'SAMPURNO');
INSERT INTO `tb_poktan` VALUES ('K020', NULL, 'SBR. BENTIS I');
INSERT INTO `tb_poktan` VALUES ('K021', NULL, 'SBR. BENTIS II');
INSERT INTO `tb_poktan` VALUES ('K022', NULL, 'SEDONO');
INSERT INTO `tb_poktan` VALUES ('K023', NULL, 'SEKAR ARUM I');
INSERT INTO `tb_poktan` VALUES ('K024', NULL, 'SEKAR ARUM II');
INSERT INTO `tb_poktan` VALUES ('K025', NULL, 'SEKAR ARUM III');
INSERT INTO `tb_poktan` VALUES ('K026', NULL, 'SEMPULUR');
INSERT INTO `tb_poktan` VALUES ('K027', NULL, 'SENDANG MULYO');
INSERT INTO `tb_poktan` VALUES ('K028', NULL, 'SIDO MAJU');
INSERT INTO `tb_poktan` VALUES ('K029', NULL, 'SIDO MAKMUR');
INSERT INTO `tb_poktan` VALUES ('K030', NULL, 'SIDODADI');
INSERT INTO `tb_poktan` VALUES ('K031', NULL, 'SIDODADI I');
INSERT INTO `tb_poktan` VALUES ('K032', NULL, 'SIDODADI II');
INSERT INTO `tb_poktan` VALUES ('K033', '3506222001', 'SIDODADI III');
INSERT INTO `tb_poktan` VALUES ('K034', NULL, 'SRI REJEKI');
INSERT INTO `tb_poktan` VALUES ('K035', NULL, 'SUBUR MAKMUR');
INSERT INTO `tb_poktan` VALUES ('K036', NULL, 'SUMBER AYEM 2');
INSERT INTO `tb_poktan` VALUES ('K037', NULL, 'SUMBER AYEM');
INSERT INTO `tb_poktan` VALUES ('K038', NULL, 'SUMBER MULYO I');
INSERT INTO `tb_poktan` VALUES ('K039', NULL, 'SUMBER MULYO II');
INSERT INTO `tb_poktan` VALUES ('K040', NULL, 'SUMBER PANGAN');
INSERT INTO `tb_poktan` VALUES ('K041', NULL, 'TAMAN TANI I');
INSERT INTO `tb_poktan` VALUES ('K042', NULL, 'TAMAN TANI II');
INSERT INTO `tb_poktan` VALUES ('K043', NULL, 'TAMAN TANI III');
INSERT INTO `tb_poktan` VALUES ('K044', NULL, 'TANAH HARAPAN JAYA');
INSERT INTO `tb_poktan` VALUES ('K045', NULL, 'TANI MAJU');
INSERT INTO `tb_poktan` VALUES ('K046', '3506222001', 'TANI MAJU 2');
INSERT INTO `tb_poktan` VALUES ('K047', '3506222001', 'TANI MAKMUR');
INSERT INTO `tb_poktan` VALUES ('K048', NULL, 'TANI MAKMUR 2');
INSERT INTO `tb_poktan` VALUES ('K049', NULL, 'TANI MULYO');
INSERT INTO `tb_poktan` VALUES ('K050', NULL, 'TOPENG INDAH I');
INSERT INTO `tb_poktan` VALUES ('K051', NULL, 'TOPENG INDAH II');
INSERT INTO `tb_poktan` VALUES ('K052', NULL, 'WALUYO');

-- ----------------------------
-- Table structure for tb_pupuk
-- ----------------------------
DROP TABLE IF EXISTS `tb_pupuk`;
CREATE TABLE `tb_pupuk`  (
  `id_pupuk` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `id_distributor` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `id_sektor` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `nama_pupuk` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_pupuk`) USING BTREE,
  INDEX `id_sektor`(`id_sektor`) USING BTREE,
  INDEX `id_distributor`(`id_distributor`) USING BTREE,
  CONSTRAINT `tb_pupuk_ibfk_1` FOREIGN KEY (`id_sektor`) REFERENCES `tb_sektor` (`id_sektor`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `tb_pupuk_ibfk_2` FOREIGN KEY (`id_distributor`) REFERENCES `tb_distributor` (`id_distributor`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tb_pupuk
-- ----------------------------
INSERT INTO `tb_pupuk` VALUES ('P001', NULL, 'S001', 'Urea MT1');
INSERT INTO `tb_pupuk` VALUES ('P002', NULL, 'S002', 'Urea MT1');
INSERT INTO `tb_pupuk` VALUES ('P003', NULL, 'S001', 'Urea MT2');
INSERT INTO `tb_pupuk` VALUES ('P004', NULL, 'S002', 'Urea MT2');
INSERT INTO `tb_pupuk` VALUES ('P005', NULL, 'S001', 'Urea MT3');
INSERT INTO `tb_pupuk` VALUES ('P006', NULL, 'S002', 'Urea MT3');
INSERT INTO `tb_pupuk` VALUES ('P007', NULL, 'S001', 'SP36 MT1');
INSERT INTO `tb_pupuk` VALUES ('P008', NULL, 'S002', 'SP36 MT1');
INSERT INTO `tb_pupuk` VALUES ('P009', NULL, 'S001', 'SP36 MT2');
INSERT INTO `tb_pupuk` VALUES ('P010', NULL, 'S002', 'SP36 MT2');
INSERT INTO `tb_pupuk` VALUES ('P011', NULL, 'S001', 'SP36 MT3');
INSERT INTO `tb_pupuk` VALUES ('P012', NULL, 'S002', 'SP36 MT3');
INSERT INTO `tb_pupuk` VALUES ('P013', NULL, 'S001', 'ZA MT1');
INSERT INTO `tb_pupuk` VALUES ('P014', NULL, 'S002', 'ZA MT1');
INSERT INTO `tb_pupuk` VALUES ('P015', NULL, 'S001', 'ZA MT2');
INSERT INTO `tb_pupuk` VALUES ('P016', NULL, 'S002', 'ZA MT2');
INSERT INTO `tb_pupuk` VALUES ('P017', NULL, 'S001', 'ZA MT3');
INSERT INTO `tb_pupuk` VALUES ('P018', NULL, 'S002', 'ZA MT3');
INSERT INTO `tb_pupuk` VALUES ('P019', NULL, 'S001', 'NPK MT1');
INSERT INTO `tb_pupuk` VALUES ('P020', NULL, 'S002', 'NPK MT1');
INSERT INTO `tb_pupuk` VALUES ('P021', NULL, 'S001', 'NPK MT2');
INSERT INTO `tb_pupuk` VALUES ('P022', NULL, 'S002', 'NPK MT2');
INSERT INTO `tb_pupuk` VALUES ('P023', NULL, 'S001', 'NPK MT3');
INSERT INTO `tb_pupuk` VALUES ('P024', NULL, 'S002', 'NPK MT3');
INSERT INTO `tb_pupuk` VALUES ('P025', NULL, 'S001', 'Organik MT1');
INSERT INTO `tb_pupuk` VALUES ('P026', NULL, 'S002', 'Organik MT1');
INSERT INTO `tb_pupuk` VALUES ('P027', NULL, 'S001', 'Organik MT2');
INSERT INTO `tb_pupuk` VALUES ('P028', NULL, 'S002', 'Organik MT2');
INSERT INTO `tb_pupuk` VALUES ('P029', NULL, 'S001', 'Organik MT3');
INSERT INTO `tb_pupuk` VALUES ('P030', NULL, 'S002', 'Organik MT3');

-- ----------------------------
-- Table structure for tb_sektor
-- ----------------------------
DROP TABLE IF EXISTS `tb_sektor`;
CREATE TABLE `tb_sektor`  (
  `id_sektor` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `jenis_tanaman` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `nama_tanaman` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_sektor`) USING BTREE,
  INDEX `jenis_tanaman`(`jenis_tanaman`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tb_sektor
-- ----------------------------
INSERT INTO `tb_sektor` VALUES ('S001', 'Tanaman Pangan', 'Padi');
INSERT INTO `tb_sektor` VALUES ('S002', 'Tanaman Pangan', 'Jagung');

-- ----------------------------
-- Table structure for tb_user
-- ----------------------------
DROP TABLE IF EXISTS `tb_user`;
CREATE TABLE `tb_user`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `level` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `tb_user_ibfk_1`(`level`) USING BTREE,
  INDEX `username`(`username`) USING BTREE,
  CONSTRAINT `tb_user_ibfk_1` FOREIGN KEY (`level`) REFERENCES `tb_level` (`level`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tb_user
-- ----------------------------
INSERT INTO `tb_user` VALUES (1, 'KAMAL II', 'fajar@gmail.com', 'kediri1717', 'POKTAN');
INSERT INTO `tb_user` VALUES (2, 'Wahyu Krisdiantoro', 'fajarmilitan@gmail.com', 'user', 'PETANI');
INSERT INTO `tb_user` VALUES (3, 'Marwi', 'marwi@gmail.com', 'user', 'PETANI');
INSERT INTO `tb_user` VALUES (4, 'Suprihatin', 'supri@gmail.com', 'user', 'PETANI');
INSERT INTO `tb_user` VALUES (5, 'fajar', 'fajarmi@gmail.com', 'user', 'PETANI');
INSERT INTO `tb_user` VALUES (6, 'Banyakan', 'banyakan@gmail.com', 'ppl', 'PPL');
INSERT INTO `tb_user` VALUES (8, 'fajar', 'fajarmilitan0@gmail.com', 'user', 'PETANI');

-- ----------------------------
-- Table structure for tb_usulan
-- ----------------------------
DROP TABLE IF EXISTS `tb_usulan`;
CREATE TABLE `tb_usulan`  (
  `id_usulan` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `id_petani` int(11) NULL DEFAULT NULL,
  `m1` blob NULL,
  `m2` blob NULL,
  `m3` blob NULL,
  `status_poktan` blob NULL,
  `status_ppl` blob NULL,
  `status_admin` blob NULL,
  `keterangan` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `timestamp` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP(0) ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id_usulan`) USING BTREE,
  INDEX `id_petani`(`id_petani`) USING BTREE,
  CONSTRAINT `FK_tb_usulan_tb_petani` FOREIGN KEY (`id_petani`) REFERENCES `tb_petani` (`id_petani`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tb_usulan
-- ----------------------------
INSERT INTO `tb_usulan` VALUES ('U001', 1, 0x59546F794F6E74704F6A413759546F344F6E747A4F6A5936496E4E6C6133527663694937637A6F304F694A5159575270496A747A4F6A5136496D783159584D694F334D364D7A6F694D433478496A747A4F6A5136496E56795A5745694F334D364E446F694D7A41754D434937637A6F304F694A7A63444D32496A747A4F6A4D36496A55754D434937637A6F794F694A3659534937637A6F304F6949794D433477496A747A4F6A4D36496D357761794937637A6F304F6949304D433477496A747A4F6A6336496D39795A324675615773694F334D364E446F694E5441754D434937637A6F304F694A6B5958526C496A747A4F6A45774F6949784D5330774E6930794D444535496A743961546F784F3245364F447037637A6F324F694A7A5A577430623349694F334D364E6A6F69536D466E6457356E496A747A4F6A5136496D783159584D694F334D364E446F694D4334784E794937637A6F304F694A31636D5668496A747A4F6A5936496A55784C6A41774D534937637A6F304F694A7A63444D32496A747A4F6A4D36496A67754E534937637A6F794F694A3659534937637A6F304F69497A4E433477496A747A4F6A4D36496D357761794937637A6F304F6949324F433477496A747A4F6A6336496D39795A324675615773694F334D364E446F694F4455754D434937637A6F304F694A6B5958526C496A747A4F6A45774F6949784D5330774E6930794D444977496A743966513D3D, 0x59546F794F6E74704F6A413759546F344F6E747A4F6A5936496E4E6C6133527663694937637A6F304F694A5159575270496A747A4F6A5136496D783159584D694F334D364D7A6F694D433478496A747A4F6A5136496E56795A5745694F334D364E446F694D7A41754D434937637A6F304F694A7A63444D32496A747A4F6A4D36496A55754D434937637A6F794F694A3659534937637A6F304F6949794D433477496A747A4F6A4D36496D357761794937637A6F304F6949304D433477496A747A4F6A6336496D39795A324675615773694F334D364E446F694E5441754D434937637A6F304F694A6B5958526C496A747A4F6A45774F6949784D5330774E6930794D444535496A743961546F784F3245364F447037637A6F324F694A7A5A577430623349694F334D364E6A6F69536D466E6457356E496A747A4F6A5136496D783159584D694F334D364E446F694D4334784E794937637A6F304F694A31636D5668496A747A4F6A5936496A55784C6A41774D534937637A6F304F694A7A63444D32496A747A4F6A4D36496A67754E534937637A6F794F694A3659534937637A6F304F69497A4E433477496A747A4F6A4D36496D357761794937637A6F304F6949324F433477496A747A4F6A6336496D39795A324675615773694F334D364E446F694F4455754D434937637A6F304F694A6B5958526C496A747A4F6A45774F6949784D5330774E6930794D444977496A743966513D3D, 0x59546F784F6E74704F6A413759546F344F6E747A4F6A5936496E4E6C6133527663694937637A6F304F694A5159575270496A747A4F6A5136496D783159584D694F334D364E546F694D4334784E7A55694F334D364E446F6964584A6C59534937637A6F304F6949314D693431496A747A4F6A5136496E4E774D7A59694F334D364E446F694F4334334E534937637A6F794F694A3659534937637A6F304F69497A4E533477496A747A4F6A4D36496D357761794937637A6F304F6949334D433477496A747A4F6A6336496D39795A324675615773694F334D364E446F694F4463754E534937637A6F304F694A6B5958526C496A747A4F6A45774F6949784E5330774E6930794D444977496A743966513D3D, 0x59546F794F6E74704F6A413759546F7A4F6E74704F6A4137637A6F304F694A30636E566C496A74704F6A4537637A6F794F694A744D69493761546F794F334D364E446F694D6A41794D43493766576B364D5474684F6A4D3665326B364D44747A4F6A5136496E5279645755694F326B364D54747A4F6A4936496D307A496A74704F6A4937637A6F304F6949794D444977496A743966513D3D, NULL, NULL, NULL, '2020-06-17 21:58:16');
INSERT INTO `tb_usulan` VALUES ('U002', 2, NULL, 0x59546F794F6E74704F6A413759546F344F6E747A4F6A5936496E4E6C6133527663694937637A6F304F694A5159575270496A747A4F6A5136496D783159584D694F334D364D7A6F694D433478496A747A4F6A5136496E56795A5745694F334D364E446F694D7A41754D434937637A6F304F694A7A63444D32496A747A4F6A4D36496A55754D434937637A6F794F694A3659534937637A6F304F6949794D433477496A747A4F6A4D36496D357761794937637A6F304F6949304D433477496A747A4F6A6336496D39795A324675615773694F334D364E446F694E5441754D434937637A6F304F694A6B5958526C496A747A4F6A45774F6949784D5330774E6930794D444535496A743961546F784F3245364F447037637A6F324F694A7A5A577430623349694F334D364E6A6F69536D466E6457356E496A747A4F6A5136496D783159584D694F334D364E446F694D4334784E794937637A6F304F694A31636D5668496A747A4F6A5936496A55784C6A41774D534937637A6F304F694A7A63444D32496A747A4F6A4D36496A67754E534937637A6F794F694A3659534937637A6F304F69497A4E433477496A747A4F6A4D36496D357761794937637A6F304F6949324F433477496A747A4F6A6336496D39795A324675615773694F334D364E446F694F4455754D434937637A6F304F694A6B5958526C496A747A4F6A45774F6949784D5330774E6930794D444977496A743966513D3D, 0x59546F784F6E74704F6A413759546F344F6E747A4F6A5936496E4E6C6133527663694937637A6F304F694A5159575270496A747A4F6A5136496D783159584D694F334D364E546F694D4334784E7A55694F334D364E446F6964584A6C59534937637A6F304F6949314D693431496A747A4F6A5136496E4E774D7A59694F334D364E446F694F4334334E534937637A6F794F694A3659534937637A6F304F69497A4E533477496A747A4F6A4D36496D357761794937637A6F304F6949334D433477496A747A4F6A6336496D39795A324675615773694F334D364E446F694F4463754E534937637A6F304F694A6B5958526C496A747A4F6A45774F6949784E5330774E6930794D444977496A743966513D3D, NULL, NULL, NULL, NULL, '2020-06-17 22:02:27');
INSERT INTO `tb_usulan` VALUES ('U003', 341, 0x59546F784F6E74704F6A413759546F344F6E747A4F6A5936496E4E6C6133527663694937637A6F304F694A5159575270496A747A4F6A5136496D783159584D694F334D364E546F694D4334324F5463694F334D364E446F6964584A6C59534937637A6F314F6949794D446B754D534937637A6F304F694A7A63444D32496A747A4F6A5536496A4D304C6A6731496A747A4F6A4936496E7068496A747A4F6A5536496A457A4F533430496A747A4F6A4D36496D357761794937637A6F314F6949794E7A67754F434937637A6F334F694A76636D6468626D6C72496A747A4F6A5536496A4D304F433431496A747A4F6A5136496D5268644755694F334D364D544136496A497A4C5441324C5449774D6A41694F333139, 0x59546F784F6E74704F6A413759546F344F6E747A4F6A5936496E4E6C6133527663694937637A6F304F694A5159575270496A747A4F6A5136496D783159584D694F334D364D7A6F694D433432496A747A4F6A5136496E56795A5745694F334D364E546F694D5467774C6A41694F334D364E446F696333417A4E694937637A6F304F69497A4D433477496A747A4F6A4936496E7068496A747A4F6A5536496A45794D433477496A747A4F6A4D36496D357761794937637A6F314F6949794E4441754D434937637A6F334F694A76636D6468626D6C72496A747A4F6A5536496A4D774D433477496A747A4F6A5136496D5268644755694F334D364D544136496A497A4C5441324C5449774D6A41694F333139, NULL, NULL, NULL, NULL, NULL, '2020-06-23 20:31:32');

SET FOREIGN_KEY_CHECKS = 1;
