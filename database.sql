/*
 Navicat Premium Data Transfer

 Source Server         : JINO - klaxwork_gorgaz
 Source Server Type    : PostgreSQL
 Source Server Version : 90617
 Source Host           : postgresql.klaxwork.myjino.ru:5432
 Source Catalog        : klaxwork_gorgaz
 Source Schema         : public

 Target Server Type    : PostgreSQL
 Target Server Version : 90617
 File Encoding         : 65001

 Date: 29/11/2020 00:46:04
*/


-- ----------------------------
-- Sequence structure for equipment_models_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."equipment_models_id_seq";
CREATE SEQUENCE "public"."equipment_models_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for equipment_types_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."equipment_types_id_seq";
CREATE SEQUENCE "public"."equipment_types_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for images_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."images_id_seq";
CREATE SEQUENCE "public"."images_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for order_equipments_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."order_equipments_id_seq";
CREATE SEQUENCE "public"."order_equipments_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for order_history_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."order_history_id_seq";
CREATE SEQUENCE "public"."order_history_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for orders_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."orders_id_seq";
CREATE SEQUENCE "public"."orders_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for reasons_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."reasons_id_seq";
CREATE SEQUENCE "public"."reasons_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for statuses_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."statuses_id_seq";
CREATE SEQUENCE "public"."statuses_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Table structure for equipment_models
-- ----------------------------
DROP TABLE IF EXISTS "public"."equipment_models";
CREATE TABLE "public"."equipment_models" (
  "id" int8 NOT NULL DEFAULT nextval('equipment_models_id_seq'::regclass),
  "model_name" varchar(255) COLLATE "pg_catalog"."default",
  "equipment_types_ref" int8
)
;

-- ----------------------------
-- Records of equipment_models
-- ----------------------------
INSERT INTO "public"."equipment_models" VALUES (2, '﻿тойник на опуске', 3);
INSERT INTO "public"."equipment_models" VALUES (3, 'AEG', 4);
INSERT INTO "public"."equipment_models" VALUES (4, 'Ariston', 4);
INSERT INTO "public"."equipment_models" VALUES (5, 'ATL', 4);
INSERT INTO "public"."equipment_models" VALUES (6, 'Avrora', 4);
INSERT INTO "public"."equipment_models" VALUES (7, 'Baltgaz', 4);
INSERT INTO "public"."equipment_models" VALUES (8, 'BaltGaz', 4);
INSERT INTO "public"."equipment_models" VALUES (9, 'Baxi', 4);
INSERT INTO "public"."equipment_models" VALUES (10, 'Beretta', 4);
INSERT INTO "public"."equipment_models" VALUES (11, 'Bosch', 4);
INSERT INTO "public"."equipment_models" VALUES (12, 'Centurion', 4);
INSERT INTO "public"."equipment_models" VALUES (13, 'CWH-13', 4);
INSERT INTO "public"."equipment_models" VALUES (14, 'Edisson', 4);
INSERT INTO "public"."equipment_models" VALUES (15, 'Etalon', 4);
INSERT INTO "public"."equipment_models" VALUES (16, 'Fniolon', 4);
INSERT INTO "public"."equipment_models" VALUES (17, 'Gordi', 4);
INSERT INTO "public"."equipment_models" VALUES (18, 'Heat master', 4);
INSERT INTO "public"."equipment_models" VALUES (19, 'Heatmaster', 4);
INSERT INTO "public"."equipment_models" VALUES (20, 'Inse', 4);
INSERT INTO "public"."equipment_models" VALUES (21, 'JS 46-10 A', 4);
INSERT INTO "public"."equipment_models" VALUES (22, 'Kraft', 4);
INSERT INTO "public"."equipment_models" VALUES (23, 'Lemaks', 4);
INSERT INTO "public"."equipment_models" VALUES (24, 'MasterGaz', 4);
INSERT INTO "public"."equipment_models" VALUES (25, 'Mora', 4);
INSERT INTO "public"."equipment_models" VALUES (26, 'Nano Pro', 4);
INSERT INTO "public"."equipment_models" VALUES (27, 'Neskar', 4);
INSERT INTO "public"."equipment_models" VALUES (28, 'Neva', 4);
INSERT INTO "public"."equipment_models" VALUES (29, 'Neva- 3208', 4);
INSERT INTO "public"."equipment_models" VALUES (30, 'Neva- 4510', 4);
INSERT INTO "public"."equipment_models" VALUES (31, 'Neva Luх', 4);
INSERT INTO "public"."equipment_models" VALUES (32, 'Neva-Lux', 4);
INSERT INTO "public"."equipment_models" VALUES (33, 'Neva-Lux', 4);
INSERT INTO "public"."equipment_models" VALUES (34, 'Neva-Tranzit', 4);
INSERT INTO "public"."equipment_models" VALUES (35, 'Neva-Tranzit.Orion', 4);
INSERT INTO "public"."equipment_models" VALUES (36, 'Orion', 4);
INSERT INTO "public"."equipment_models" VALUES (37, 'Pover', 4);
INSERT INTO "public"."equipment_models" VALUES (38, 'Prodesh', 4);
INSERT INTO "public"."equipment_models" VALUES (39, 'Roda', 4);
INSERT INTO "public"."equipment_models" VALUES (40, 'Samsung', 4);
INSERT INTO "public"."equipment_models" VALUES (41, 'Saturn', 4);
INSERT INTO "public"."equipment_models" VALUES (42, 'SUPERFLAME', 4);
INSERT INTO "public"."equipment_models" VALUES (43, 'Superflame', 4);
INSERT INTO "public"."equipment_models" VALUES (44, 'TGA', 4);
INSERT INTO "public"."equipment_models" VALUES (45, 'Vailant', 4);
INSERT INTO "public"."equipment_models" VALUES (46, 'Vector', 4);
INSERT INTO "public"."equipment_models" VALUES (47, 'Vector- Star', 4);
INSERT INTO "public"."equipment_models" VALUES (48, 'Vektor Lux Eco', 4);
INSERT INTO "public"."equipment_models" VALUES (49, 'Vivat', 4);
INSERT INTO "public"."equipment_models" VALUES (50, 'Volna', 4);
INSERT INTO "public"."equipment_models" VALUES (51, 'Wert', 4);
INSERT INTO "public"."equipment_models" VALUES (52, 'Zermen ВПГ-18', 4);
INSERT INTO "public"."equipment_models" VALUES (53, 'Zerten', 4);
INSERT INTO "public"."equipment_models" VALUES (54, 'Аврора', 4);
INSERT INTO "public"."equipment_models" VALUES (55, 'АЕГ', 4);
INSERT INTO "public"."equipment_models" VALUES (56, 'Аквилон', 4);
INSERT INTO "public"."equipment_models" VALUES (57, 'Алинтер', 4);
INSERT INTO "public"."equipment_models" VALUES (58, 'Аментер', 4);
INSERT INTO "public"."equipment_models" VALUES (59, 'Астра', 4);
INSERT INTO "public"."equipment_models" VALUES (60, 'Балт-Газ', 4);
INSERT INTO "public"."equipment_models" VALUES (61, 'Болер', 4);
INSERT INTO "public"."equipment_models" VALUES (62, 'Брэдфорд Вайт"', 4);
INSERT INTO "public"."equipment_models" VALUES (63, 'Вайланд', 4);
INSERT INTO "public"."equipment_models" VALUES (64, 'Ватер-Темп', 4);
INSERT INTO "public"."equipment_models" VALUES (65, 'Вектор', 4);
INSERT INTO "public"."equipment_models" VALUES (66, 'Вектор Стар', 4);
INSERT INTO "public"."equipment_models" VALUES (67, 'ВПГ', 4);
INSERT INTO "public"."equipment_models" VALUES (68, 'ВПГ "Беретта"', 4);
INSERT INTO "public"."equipment_models" VALUES (69, 'ВПГ "Вектор"', 4);
INSERT INTO "public"."equipment_models" VALUES (70, 'ВПГ "Таганрог" автомат', 4);
INSERT INTO "public"."equipment_models" VALUES (71, 'ВПГ ELSOTHERM', 4);
INSERT INTO "public"."equipment_models" VALUES (72, 'ВПГ N-T', 4);
INSERT INTO "public"."equipment_models" VALUES (73, 'ВПГ VAILAND', 4);
INSERT INTO "public"."equipment_models" VALUES (74, 'ВПГ авт MITCA', 4);
INSERT INTO "public"."equipment_models" VALUES (75, 'ВПГ авт.', 4);
INSERT INTO "public"."equipment_models" VALUES (76, 'ВПГ авт. "Нева Люкс"', 4);
INSERT INTO "public"."equipment_models" VALUES (77, 'ВПГ авт. "Нева"', 4);
INSERT INTO "public"."equipment_models" VALUES (78, 'ВПГ авт. "Нева-Транзит"', 4);
INSERT INTO "public"."equipment_models" VALUES (79, 'ВПГ авт. STOVROLIT', 4);
INSERT INTO "public"."equipment_models" VALUES (80, 'ВПГ авт. SUPERLUX', 4);
INSERT INTO "public"."equipment_models" VALUES (81, 'впг авт. АЕG', 4);
INSERT INTO "public"."equipment_models" VALUES (82, 'ВПГ авт. Аристон', 4);
INSERT INTO "public"."equipment_models" VALUES (83, 'ВПГ авт. КОМФОРТ', 4);
INSERT INTO "public"."equipment_models" VALUES (84, 'ВПГ авт. ЛарГаз', 4);
INSERT INTO "public"."equipment_models" VALUES (85, 'ВПГ авт."НЕВА"-4610', 4);
INSERT INTO "public"."equipment_models" VALUES (86, 'ВПГ автом Градини', 4);
INSERT INTO "public"."equipment_models" VALUES (87, 'ВПГ автомат  ЛАДОГАЗ', 4);
INSERT INTO "public"."equipment_models" VALUES (88, 'впг лемакс', 4);
INSERT INTO "public"."equipment_models" VALUES (89, 'ВПГ Лемакс авт', 4);
INSERT INTO "public"."equipment_models" VALUES (90, 'впг орион', 4);
INSERT INTO "public"."equipment_models" VALUES (91, 'ВПГ Феролли', 4);
INSERT INTO "public"."equipment_models" VALUES (92, 'ВПГ Электролюкс авт.', 4);
INSERT INTO "public"."equipment_models" VALUES (93, 'ВПГ-10', 4);
INSERT INTO "public"."equipment_models" VALUES (94, 'ВПГ-10 "Ладогаз"', 4);
INSERT INTO "public"."equipment_models" VALUES (95, 'ВПГ-10 "Протон"', 4);
INSERT INTO "public"."equipment_models" VALUES (96, 'впг-18', 4);
INSERT INTO "public"."equipment_models" VALUES (97, 'ВПГ-18 "Россиянка-м"', 4);
INSERT INTO "public"."equipment_models" VALUES (98, 'ВПГ-19', 4);
INSERT INTO "public"."equipment_models" VALUES (99, 'ВПГ-23', 4);
INSERT INTO "public"."equipment_models" VALUES (100, 'ВПГ-6', 4);
INSERT INTO "public"."equipment_models" VALUES (101, 'ГазЛюкс', 4);
INSERT INTO "public"."equipment_models" VALUES (102, 'Гефест', 4);
INSERT INTO "public"."equipment_models" VALUES (103, 'Горение', 4);
INSERT INTO "public"."equipment_models" VALUES (104, 'Граниди', 4);
INSERT INTO "public"."equipment_models" VALUES (105, 'ДеЛюкс', 4);
INSERT INTO "public"."equipment_models" VALUES (106, 'Догаз', 4);
INSERT INTO "public"."equipment_models" VALUES (107, 'Евролайн', 4);
INSERT INTO "public"."equipment_models" VALUES (108, 'Занусси', 4);
INSERT INTO "public"."equipment_models" VALUES (109, 'Занусси ВПГа', 4);
INSERT INTO "public"."equipment_models" VALUES (110, 'Искра', 4);
INSERT INTO "public"."equipment_models" VALUES (111, 'КГИ', 4);
INSERT INTO "public"."equipment_models" VALUES (112, 'Комфорт', 4);
INSERT INTO "public"."equipment_models" VALUES (113, 'Комфорт авт', 4);
INSERT INTO "public"."equipment_models" VALUES (114, 'Конорд', 4);
INSERT INTO "public"."equipment_models" VALUES (115, 'Корея', 4);
INSERT INTO "public"."equipment_models" VALUES (116, 'Крафт', 4);
INSERT INTO "public"."equipment_models" VALUES (117, 'Ладагаз', 4);
INSERT INTO "public"."equipment_models" VALUES (118, 'Ладогаз', 4);
INSERT INTO "public"."equipment_models" VALUES (119, 'ЛарГаз', 4);
INSERT INTO "public"."equipment_models" VALUES (120, 'ЛарГаз', 4);
INSERT INTO "public"."equipment_models" VALUES (121, 'ЛарГаз', 4);
INSERT INTO "public"."equipment_models" VALUES (122, 'Ларгаз', 4);
INSERT INTO "public"."equipment_models" VALUES (123, 'Ларгаз', 4);
INSERT INTO "public"."equipment_models" VALUES (124, 'Ларгаз', 4);
INSERT INTO "public"."equipment_models" VALUES (125, 'Ларгаз', 4);
INSERT INTO "public"."equipment_models" VALUES (126, 'Ларгаз', 4);
INSERT INTO "public"."equipment_models" VALUES (127, 'Лемакс', 4);
INSERT INTO "public"."equipment_models" VALUES (128, 'Ленинград', 4);
INSERT INTO "public"."equipment_models" VALUES (129, 'Мастер газ', 4);
INSERT INTO "public"."equipment_models" VALUES (130, 'Мидеа', 4);
INSERT INTO "public"."equipment_models" VALUES (131, 'Нева', 4);
INSERT INTO "public"."equipment_models" VALUES (132, 'Нева-4510 М', 4);
INSERT INTO "public"."equipment_models" VALUES (133, 'Нева-4511', 4);
INSERT INTO "public"."equipment_models" VALUES (134, 'Нева-Люкс', 4);
INSERT INTO "public"."equipment_models" VALUES (135, 'Нева-Транзит', 4);
INSERT INTO "public"."equipment_models" VALUES (136, 'Оазис', 4);
INSERT INTO "public"."equipment_models" VALUES (137, 'Оазис', 4);
INSERT INTO "public"."equipment_models" VALUES (138, 'Орион', 4);
INSERT INTO "public"."equipment_models" VALUES (139, 'ПГ-10Е', 4);
INSERT INTO "public"."equipment_models" VALUES (140, 'ПГ-6', 4);
INSERT INTO "public"."equipment_models" VALUES (141, 'ПГ-6', 4);
INSERT INTO "public"."equipment_models" VALUES (142, 'Промитей', 4);
INSERT INTO "public"."equipment_models" VALUES (143, 'Протон', 4);
INSERT INTO "public"."equipment_models" VALUES (144, 'РБС Прохладрненская', 4);
INSERT INTO "public"."equipment_models" VALUES (145, 'Россиянка', 4);
INSERT INTO "public"."equipment_models" VALUES (146, 'Ростел', 4);
INSERT INTO "public"."equipment_models" VALUES (147, 'Ростерм', 4);
INSERT INTO "public"."equipment_models" VALUES (148, 'Сармат', 4);
INSERT INTO "public"."equipment_models" VALUES (149, 'Сатурн', 4);
INSERT INTO "public"."equipment_models" VALUES (150, 'Сименкс', 4);
INSERT INTO "public"."equipment_models" VALUES (151, 'Сименс', 4);
INSERT INTO "public"."equipment_models" VALUES (152, 'Ставролит', 4);
INSERT INTO "public"."equipment_models" VALUES (153, 'Суперлюкс', 4);
INSERT INTO "public"."equipment_models" VALUES (154, 'Т.Г.А.', 4);
INSERT INTO "public"."equipment_models" VALUES (155, 'Таган.газ.аппарат', 4);
INSERT INTO "public"."equipment_models" VALUES (156, 'Тагангазаппарат', 4);
INSERT INTO "public"."equipment_models" VALUES (157, 'Таганрог', 4);
INSERT INTO "public"."equipment_models" VALUES (158, 'Таген', 4);
INSERT INTO "public"."equipment_models" VALUES (159, 'Титан', 4);
INSERT INTO "public"."equipment_models" VALUES (160, 'Тула', 4);
INSERT INTO "public"."equipment_models" VALUES (161, 'Турба', 4);
INSERT INTO "public"."equipment_models" VALUES (162, 'Феролли', 4);
INSERT INTO "public"."equipment_models" VALUES (163, 'Фундитал', 4);
INSERT INTO "public"."equipment_models" VALUES (164, 'Хитмастер', 4);
INSERT INTO "public"."equipment_models" VALUES (165, 'электролюкс', 4);
INSERT INTO "public"."equipment_models" VALUES (166, 'Эталон', 4);
INSERT INTO "public"."equipment_models" VALUES (167, 'Юкос', 4);
INSERT INTO "public"."equipment_models" VALUES (168, 'Юнкерс', 4);
INSERT INTO "public"."equipment_models" VALUES (169, 'ATL', 5);
INSERT INTO "public"."equipment_models" VALUES (170, 'Cointra', 5);
INSERT INTO "public"."equipment_models" VALUES (171, 'Mor-Flo', 5);
INSERT INTO "public"."equipment_models" VALUES (172, 'Neva', 5);
INSERT INTO "public"."equipment_models" VALUES (173, 'Neva Lux', 5);
INSERT INTO "public"."equipment_models" VALUES (174, 'Stavrrolit', 5);
INSERT INTO "public"."equipment_models" VALUES (175, 'TURCA', 5);
INSERT INTO "public"."equipment_models" VALUES (176, 'Vector', 5);
INSERT INTO "public"."equipment_models" VALUES (177, 'Viemann (бойлер)', 5);
INSERT INTO "public"."equipment_models" VALUES (178, 'Wailant', 5);
INSERT INTO "public"."equipment_models" VALUES (179, 'Zanussi"', 5);
INSERT INTO "public"."equipment_models" VALUES (180, 'Авангард', 5);
INSERT INTO "public"."equipment_models" VALUES (181, 'АЕG', 5);
INSERT INTO "public"."equipment_models" VALUES (182, 'АЕГ п/а', 5);
INSERT INTO "public"."equipment_models" VALUES (183, 'Аристон', 5);
INSERT INTO "public"."equipment_models" VALUES (184, 'Аристон', 5);
INSERT INTO "public"."equipment_models" VALUES (185, 'Астра', 5);
INSERT INTO "public"."equipment_models" VALUES (186, 'Атлант', 5);
INSERT INTO "public"."equipment_models" VALUES (187, 'Без наименованиея', 5);
INSERT INTO "public"."equipment_models" VALUES (188, 'Беретта', 5);
INSERT INTO "public"."equipment_models" VALUES (189, 'Бошь', 5);
INSERT INTO "public"."equipment_models" VALUES (190, 'ВПГ "Вайлант"', 5);
INSERT INTO "public"."equipment_models" VALUES (191, 'ВПГ п/а', 5);
INSERT INTO "public"."equipment_models" VALUES (192, 'ВПГ п/а', 5);
INSERT INTO "public"."equipment_models" VALUES (193, 'ВПГ п/а "Нева"', 5);
INSERT INTO "public"."equipment_models" VALUES (194, 'ВПГ п/а "Электролюкс"', 5);
INSERT INTO "public"."equipment_models" VALUES (195, 'ВПГ П/А BERETTA', 5);
INSERT INTO "public"."equipment_models" VALUES (196, 'ВПГ п/а BOSCH', 5);
INSERT INTO "public"."equipment_models" VALUES (197, 'ВПГ п/а Аристон', 5);
INSERT INTO "public"."equipment_models" VALUES (198, 'ВПГ п/а Астра', 5);
INSERT INTO "public"."equipment_models" VALUES (199, 'ВПГ п/а Электролюкс', 5);
INSERT INTO "public"."equipment_models" VALUES (200, 'впг Россиянка п/а', 5);
INSERT INTO "public"."equipment_models" VALUES (201, 'Газлюкс', 5);
INSERT INTO "public"."equipment_models" VALUES (202, 'Комфорт', 5);
INSERT INTO "public"."equipment_models" VALUES (203, 'Ладогаз', 5);
INSERT INTO "public"."equipment_models" VALUES (204, 'Лемакс', 5);
INSERT INTO "public"."equipment_models" VALUES (205, 'Нева', 5);
INSERT INTO "public"."equipment_models" VALUES (206, 'Нева-Транзит', 5);
INSERT INTO "public"."equipment_models" VALUES (207, 'Оазис', 5);
INSERT INTO "public"."equipment_models" VALUES (208, 'Протон', 5);
INSERT INTO "public"."equipment_models" VALUES (209, 'Россиянка', 5);
INSERT INTO "public"."equipment_models" VALUES (210, 'Россиянка- М п/а', 5);
INSERT INTO "public"."equipment_models" VALUES (211, 'Россиянка-м', 5);
INSERT INTO "public"."equipment_models" VALUES (212, 'Сиберия', 5);
INSERT INTO "public"."equipment_models" VALUES (213, 'Ставролит', 5);
INSERT INTO "public"."equipment_models" VALUES (214, 'Т.Г.А.', 5);
INSERT INTO "public"."equipment_models" VALUES (215, 'Таганрог', 5);
INSERT INTO "public"."equipment_models" VALUES (216, 'Термет', 5);
INSERT INTO "public"."equipment_models" VALUES (217, 'Титан', 5);
INSERT INTO "public"."equipment_models" VALUES (218, 'Тула', 5);
INSERT INTO "public"."equipment_models" VALUES (219, 'Электролюкс', 5);
INSERT INTO "public"."equipment_models" VALUES (220, 'Юнкерс', 5);
INSERT INTO "public"."equipment_models" VALUES (221, 'BK-G 10', 9);
INSERT INTO "public"."equipment_models" VALUES (222, 'BK-G10', 9);
INSERT INTO "public"."equipment_models" VALUES (223, 'BK-G16T', 9);
INSERT INTO "public"."equipment_models" VALUES (224, 'G 6', 9);
INSERT INTO "public"."equipment_models" VALUES (225, 'NPM- G 4', 9);
INSERT INTO "public"."equipment_models" VALUES (226, 'NPMG 4', 9);
INSERT INTO "public"."equipment_models" VALUES (227, 'NPM-G4', 9);
INSERT INTO "public"."equipment_models" VALUES (228, 'SI-G4', 9);
INSERT INTO "public"."equipment_models" VALUES (229, 'Алинтер', 9);
INSERT INTO "public"."equipment_models" VALUES (230, 'Бетар', 9);
INSERT INTO "public"."equipment_models" VALUES (231, 'Вектор G 4', 9);
INSERT INTO "public"."equipment_models" VALUES (232, 'ВЕКТОР-М/Т', 9);
INSERT INTO "public"."equipment_models" VALUES (233, 'ВК', 9);
INSERT INTO "public"."equipment_models" VALUES (234, 'ВК G4', 9);
INSERT INTO "public"."equipment_models" VALUES (235, 'ВК-G 4', 9);
INSERT INTO "public"."equipment_models" VALUES (236, 'ВК-G 4т', 9);
INSERT INTO "public"."equipment_models" VALUES (237, 'ВК-G10', 9);
INSERT INTO "public"."equipment_models" VALUES (238, 'ВК-G10Т', 9);
INSERT INTO "public"."equipment_models" VALUES (239, 'ВК-G6', 9);
INSERT INTO "public"."equipment_models" VALUES (240, 'ВК-G6т', 9);
INSERT INTO "public"."equipment_models" VALUES (241, 'Газовый счётчик', 9);
INSERT INTO "public"."equipment_models" VALUES (242, 'Геликон', 9);
INSERT INTO "public"."equipment_models" VALUES (243, 'Гефест', 9);
INSERT INTO "public"."equipment_models" VALUES (244, 'Гранд 2,4', 9);
INSERT INTO "public"."equipment_models" VALUES (245, 'Гранд 3,2', 9);
INSERT INTO "public"."equipment_models" VALUES (246, 'Гранд-1,6', 9);
INSERT INTO "public"."equipment_models" VALUES (247, 'Гранд-4', 9);
INSERT INTO "public"."equipment_models" VALUES (248, 'Гранд-6', 9);
INSERT INTO "public"."equipment_models" VALUES (249, 'Гранд-6 ТК', 9);
INSERT INTO "public"."equipment_models" VALUES (250, 'Мимакс', 9);
INSERT INTO "public"."equipment_models" VALUES (251, 'Минск', 9);
INSERT INTO "public"."equipment_models" VALUES (252, 'МКМ', 9);
INSERT INTO "public"."equipment_models" VALUES (253, 'МКМ G 6', 9);
INSERT INTO "public"."equipment_models" VALUES (254, 'МКМ-1', 9);
INSERT INTO "public"."equipment_models" VALUES (255, 'МКМ-G 4', 9);
INSERT INTO "public"."equipment_models" VALUES (256, 'Омега', 9);
INSERT INTO "public"."equipment_models" VALUES (257, 'Омега-М', 9);
INSERT INTO "public"."equipment_models" VALUES (258, 'ПКМ-1', 9);
INSERT INTO "public"."equipment_models" VALUES (259, 'СГ-1', 9);
INSERT INTO "public"."equipment_models" VALUES (260, 'СГБ -1,8', 9);
INSERT INTO "public"."equipment_models" VALUES (261, 'СГБ G 4-0', 9);
INSERT INTO "public"."equipment_models" VALUES (262, 'СГБ-4,0', 9);
INSERT INTO "public"."equipment_models" VALUES (263, 'СГБМ-1,6', 9);
INSERT INTO "public"."equipment_models" VALUES (264, 'СГБМ-3,2', 9);
INSERT INTO "public"."equipment_models" VALUES (265, 'СГБМ-4 1,5', 9);
INSERT INTO "public"."equipment_models" VALUES (266, 'СГД', 9);
INSERT INTO "public"."equipment_models" VALUES (267, 'СГД 3т', 9);
INSERT INTO "public"."equipment_models" VALUES (268, 'СГД G-4', 9);
INSERT INTO "public"."equipment_models" VALUES (269, 'СГД-3 ТG6', 9);
INSERT INTO "public"."equipment_models" VALUES (270, 'СГК G-4', 9);
INSERT INTO "public"."equipment_models" VALUES (271, 'СГК-4', 9);
INSERT INTO "public"."equipment_models" VALUES (272, 'СГМ-1,6', 9);
INSERT INTO "public"."equipment_models" VALUES (273, 'СГМН-1', 9);
INSERT INTO "public"."equipment_models" VALUES (274, 'СГМН-1', 9);
INSERT INTO "public"."equipment_models" VALUES (275, 'СГМН-1', 9);
INSERT INTO "public"."equipment_models" VALUES (276, 'СГМН-1', 9);
INSERT INTO "public"."equipment_models" VALUES (277, 'СГМН-1', 9);
INSERT INTO "public"."equipment_models" VALUES (278, 'СГМН-1 G6', 9);
INSERT INTO "public"."equipment_models" VALUES (279, 'СГМН-1-2-1-G6', 9);
INSERT INTO "public"."equipment_models" VALUES (280, 'СГМН1G6', 9);
INSERT INTO "public"."equipment_models" VALUES (281, '"Viessmann"', 10);
INSERT INTO "public"."equipment_models" VALUES (282, '2х контурный котел', 10);
INSERT INTO "public"."equipment_models" VALUES (283, '2х контурный котел BAXI', 10);
INSERT INTO "public"."equipment_models" VALUES (284, '2х контурный котел Beretta', 10);
INSERT INTO "public"."equipment_models" VALUES (285, '2х контурный котел FER', 10);
INSERT INTO "public"."equipment_models" VALUES (286, '2х контурный котел Fondital', 10);
INSERT INTO "public"."equipment_models" VALUES (287, '2х контурный котел KOREASTAR', 10);
INSERT INTO "public"."equipment_models" VALUES (288, '2х контурный котел NAVIEN', 10);
INSERT INTO "public"."equipment_models" VALUES (289, '2х контурный котел SEOUL', 10);
INSERT INTO "public"."equipment_models" VALUES (290, '2х контурный котел Vailland', 10);
INSERT INTO "public"."equipment_models" VALUES (291, '2х контурный котел Альфа THERMSIGMA', 10);
INSERT INTO "public"."equipment_models" VALUES (292, '2х контурный котел Ардерия', 10);
INSERT INTO "public"."equipment_models" VALUES (293, '2х контурный котел АРИСТОН', 10);
INSERT INTO "public"."equipment_models" VALUES (294, '2х контурный котел Протерм', 10);
INSERT INTO "public"."equipment_models" VALUES (295, '2х контурный котел Россиянка', 10);
INSERT INTO "public"."equipment_models" VALUES (296, '2х контурный котел САНЬЕР', 10);
INSERT INTO "public"."equipment_models" VALUES (297, '2х контурный котел Феролли', 10);
INSERT INTO "public"."equipment_models" VALUES (298, '2х контурный котел Эксклюзив', 10);
INSERT INTO "public"."equipment_models" VALUES (299, '2х контурный котел Электролюкс', 10);
INSERT INTO "public"."equipment_models" VALUES (300, '2ъх контурный котел Россиянка', 10);
INSERT INTO "public"."equipment_models" VALUES (301, 'AEG', 10);
INSERT INTO "public"."equipment_models" VALUES (302, 'AlpenHoff24', 10);
INSERT INTO "public"."equipment_models" VALUES (303, 'Arimax', 10);
INSERT INTO "public"."equipment_models" VALUES (304, 'Baltgaz', 10);
INSERT INTO "public"."equipment_models" VALUES (305, 'Baltur Tesis 24', 10);
INSERT INTO "public"."equipment_models" VALUES (306, 'BAXI', 10);
INSERT INTO "public"."equipment_models" VALUES (307, 'Baxi Luna', 10);
INSERT INTO "public"."equipment_models" VALUES (308, 'Baxi Mainfour 24-24s', 10);
INSERT INTO "public"."equipment_models" VALUES (309, 'BAXI напольный', 10);
INSERT INTO "public"."equipment_models" VALUES (310, 'Beretta напольный с элетронной платой управления', 10);
INSERT INTO "public"."equipment_models" VALUES (311, 'Buderis', 10);
INSERT INTO "public"."equipment_models" VALUES (312, 'Buderus Logamax', 10);
INSERT INTO "public"."equipment_models" VALUES (313, 'Clasic', 10);
INSERT INTO "public"."equipment_models" VALUES (314, 'CUBE TIBERIS', 10);
INSERT INTO "public"."equipment_models" VALUES (315, 'Daewoo DGB-160MES', 10);
INSERT INTO "public"."equipment_models" VALUES (316, 'De Dietrich', 10);
INSERT INTO "public"."equipment_models" VALUES (317, 'Droterm', 10);
INSERT INTO "public"."equipment_models" VALUES (318, 'Duval', 10);
INSERT INTO "public"."equipment_models" VALUES (319, 'Ecokovi-200', 10);
INSERT INTO "public"."equipment_models" VALUES (320, 'Elsoterm', 10);
INSERT INTO "public"."equipment_models" VALUES (321, 'Elsotherm', 10);
INSERT INTO "public"."equipment_models" VALUES (322, 'Eurotherm Technology', 10);
INSERT INTO "public"."equipment_models" VALUES (323, 'Ferolli', 10);
INSERT INTO "public"."equipment_models" VALUES (324, 'Ferolli', 10);
INSERT INTO "public"."equipment_models" VALUES (325, 'Fertech', 10);
INSERT INTO "public"."equipment_models" VALUES (326, 'FONDITAL', 10);
INSERT INTO "public"."equipment_models" VALUES (327, 'Gaz-eco', 10);
INSERT INTO "public"."equipment_models" VALUES (328, 'Gazlux', 10);
INSERT INTO "public"."equipment_models" VALUES (329, 'Haier', 10);
INSERT INTO "public"."equipment_models" VALUES (330, 'Hermann', 10);
INSERT INTO "public"."equipment_models" VALUES (331, 'Hydrosta', 10);
INSERT INTO "public"."equipment_models" VALUES (332, 'Immergas', 10);
INSERT INTO "public"."equipment_models" VALUES (333, 'ImmerGaz', 10);
INSERT INTO "public"."equipment_models" VALUES (334, 'Kentatsu Furst', 10);
INSERT INTO "public"."equipment_models" VALUES (335, 'Kentatsu Furst', 10);
INSERT INTO "public"."equipment_models" VALUES (336, 'Kovi', 10);
INSERT INTO "public"."equipment_models" VALUES (337, 'KOVI 30 D', 10);
INSERT INTO "public"."equipment_models" VALUES (338, 'Kovi -Koreavista', 10);
INSERT INTO "public"."equipment_models" VALUES (339, 'Lamborghini', 10);
INSERT INTO "public"."equipment_models" VALUES (340, 'Lemacs', 10);
INSERT INTO "public"."equipment_models" VALUES (341, 'Leopard', 10);
INSERT INTO "public"."equipment_models" VALUES (342, 'Mizudo', 10);
INSERT INTO "public"."equipment_models" VALUES (343, 'Navien', 10);
INSERT INTO "public"."equipment_models" VALUES (344, 'Navien Ace', 10);
INSERT INTO "public"."equipment_models" VALUES (345, 'Navien Deluxe Coaxial', 10);
INSERT INTO "public"."equipment_models" VALUES (346, 'NORA-TOP', 10);
INSERT INTO "public"."equipment_models" VALUES (347, 'Nova Florida (Pictor Dual Line)', 10);
INSERT INTO "public"."equipment_models" VALUES (348, 'NovaFlorida', 10);
INSERT INTO "public"."equipment_models" VALUES (349, 'Proterm', 10);
INSERT INTO "public"."equipment_models" VALUES (350, 'Protherm Geрard', 10);
INSERT INTO "public"."equipment_models" VALUES (351, 'Radiant', 10);
INSERT INTO "public"."equipment_models" VALUES (352, 'Rinnai', 10);
INSERT INTO "public"."equipment_models" VALUES (353, 'Roca NeoBit', 10);
INSERT INTO "public"."equipment_models" VALUES (354, 'SAVNIER DVAL', 10);
INSERT INTO "public"."equipment_models" VALUES (355, 'Tmmergac', 10);
INSERT INTO "public"."equipment_models" VALUES (356, 'Vaillant', 10);
INSERT INTO "public"."equipment_models" VALUES (357, 'Viadrus', 10);
INSERT INTO "public"."equipment_models" VALUES (358, 'Viallant', 10);
INSERT INTO "public"."equipment_models" VALUES (359, 'Vitopend 100-W', 10);
INSERT INTO "public"."equipment_models" VALUES (360, 'Wolf', 10);
INSERT INTO "public"."equipment_models" VALUES (361, 'Альфа-THERM', 10);
INSERT INTO "public"."equipment_models" VALUES (362, 'Антеа', 10);
INSERT INTO "public"."equipment_models" VALUES (363, 'Антей', 10);
INSERT INTO "public"."equipment_models" VALUES (364, 'Ардо', 10);
INSERT INTO "public"."equipment_models" VALUES (365, 'Аристон', 10);
INSERT INTO "public"."equipment_models" VALUES (366, 'Бакси', 10);
INSERT INTO "public"."equipment_models" VALUES (367, 'Бакси 24 ФИ', 10);
INSERT INTO "public"."equipment_models" VALUES (368, 'Бакси ECO COMPACT 24F', 10);
INSERT INTO "public"."equipment_models" VALUES (369, 'Бакси ECO4S', 10);
INSERT INTO "public"."equipment_models" VALUES (370, 'Бакси Eco-Home', 10);
INSERT INTO "public"."equipment_models" VALUES (371, 'Бакси Луна', 10);
INSERT INTO "public"."equipment_models" VALUES (372, 'Бакси Слим', 10);
INSERT INTO "public"."equipment_models" VALUES (373, 'Бакси Экофор', 10);
INSERT INTO "public"."equipment_models" VALUES (374, 'берта', 10);
INSERT INTO "public"."equipment_models" VALUES (375, 'Бошь', 10);
INSERT INTO "public"."equipment_models" VALUES (376, 'Будерос', 10);
INSERT INTO "public"."equipment_models" VALUES (377, 'Будерус', 10);
INSERT INTO "public"."equipment_models" VALUES (378, 'Будорос', 10);
INSERT INTO "public"."equipment_models" VALUES (379, 'Буферус', 10);
INSERT INTO "public"."equipment_models" VALUES (380, 'Вайланд', 10);
INSERT INTO "public"."equipment_models" VALUES (381, 'Вайсмон', 10);
INSERT INTO "public"."equipment_models" VALUES (382, 'Виалет', 10);
INSERT INTO "public"."equipment_models" VALUES (383, 'Виктория', 10);
INSERT INTO "public"."equipment_models" VALUES (384, 'Висман 24', 10);
INSERT INTO "public"."equipment_models" VALUES (385, 'ВОSCH Д/К', 10);
INSERT INTO "public"."equipment_models" VALUES (386, 'Вольф', 10);
INSERT INTO "public"."equipment_models" VALUES (387, 'Газлюкс', 10);
INSERT INTO "public"."equipment_models" VALUES (388, 'Газ-эко Д/К', 10);
INSERT INTO "public"."equipment_models" VALUES (389, 'Гефест', 10);
INSERT INTO "public"."equipment_models" VALUES (390, 'Дакон', 10);
INSERT INTO "public"."equipment_models" VALUES (391, 'Двухконтурный котел', 10);
INSERT INTO "public"."equipment_models" VALUES (392, 'Двухконтурный котел BAXI', 10);
INSERT INTO "public"."equipment_models" VALUES (393, 'Део', 10);
INSERT INTO "public"."equipment_models" VALUES (394, 'ДК "Hermаn"', 10);
INSERT INTO "public"."equipment_models" VALUES (395, 'ДК Frisquet', 10);
INSERT INTO "public"."equipment_models" VALUES (396, 'ДК"Вайланд"', 10);
INSERT INTO "public"."equipment_models" VALUES (397, 'ДК"Кетурами"', 10);
INSERT INTO "public"."equipment_models" VALUES (398, 'Евротерм', 10);
INSERT INTO "public"."equipment_models" VALUES (399, 'Електролюкс', 10);
INSERT INTO "public"."equipment_models" VALUES (400, 'Имергаз', 10);
INSERT INTO "public"."equipment_models" VALUES (401, 'Иммергаз', 10);
INSERT INTO "public"."equipment_models" VALUES (402, 'Импортный котел', 10);
INSERT INTO "public"."equipment_models" VALUES (403, 'Китурами', 10);
INSERT INTO "public"."equipment_models" VALUES (404, 'Кореастар', 10);
INSERT INTO "public"."equipment_models" VALUES (405, 'Лемакс', 10);
INSERT INTO "public"."equipment_models" VALUES (406, 'Мастер-газ', 10);
INSERT INTO "public"."equipment_models" VALUES (407, 'Мера', 10);
INSERT INTO "public"."equipment_models" VALUES (408, 'Мира', 10);
INSERT INTO "public"."equipment_models" VALUES (409, 'Мора', 10);
INSERT INTO "public"."equipment_models" VALUES (410, 'Моратоп', 10);
INSERT INTO "public"."equipment_models" VALUES (411, 'Нermann', 10);
INSERT INTO "public"."equipment_models" VALUES (412, 'Навьен', 10);
INSERT INTO "public"."equipment_models" VALUES (413, 'Навьен Айс', 10);
INSERT INTO "public"."equipment_models" VALUES (414, 'Навьен Делюкс', 10);
INSERT INTO "public"."equipment_models" VALUES (415, 'Нева', 10);
INSERT INTO "public"."equipment_models" VALUES (416, 'Нева-Люкс', 10);
INSERT INTO "public"."equipment_models" VALUES (417, 'Нева-Транзит', 10);
INSERT INTO "public"."equipment_models" VALUES (418, 'Оазис', 10);
INSERT INTO "public"."equipment_models" VALUES (419, 'Ордерия', 10);
INSERT INTO "public"."equipment_models" VALUES (420, 'Поликрафт', 10);
INSERT INTO "public"."equipment_models" VALUES (421, 'Росса', 10);
INSERT INTO "public"."equipment_models" VALUES (422, 'Россиянка', 10);
INSERT INTO "public"."equipment_models" VALUES (423, 'Россиянка- М', 10);
INSERT INTO "public"."equipment_models" VALUES (424, 'Рысь', 10);
INSERT INTO "public"."equipment_models" VALUES (425, 'Сиберия', 10);
INSERT INTO "public"."equipment_models" VALUES (426, 'Сибиряк', 10);
INSERT INTO "public"."equipment_models" VALUES (427, 'Тиберис', 10);
INSERT INTO "public"."equipment_models" VALUES (428, 'Фер', 10);
INSERT INTO "public"."equipment_models" VALUES (429, 'Феролли', 10);
INSERT INTO "public"."equipment_models" VALUES (430, 'Флама', 10);
INSERT INTO "public"."equipment_models" VALUES (431, 'Хабитат', 10);
INSERT INTO "public"."equipment_models" VALUES (432, 'электролюкс', 10);
INSERT INTO "public"."equipment_models" VALUES (433, 'Юнкерс', 10);
INSERT INTO "public"."equipment_models" VALUES (434, 'Янкерс', 10);
INSERT INTO "public"."equipment_models" VALUES (435, 'Elit', 13);
INSERT INTO "public"."equipment_models" VALUES (436, 'АГВ', 13);
INSERT INTO "public"."equipment_models" VALUES (437, 'АГВ-120', 13);
INSERT INTO "public"."equipment_models" VALUES (438, 'АГВ-80', 13);
INSERT INTO "public"."equipment_models" VALUES (439, 'АОГВ', 13);
INSERT INTO "public"."equipment_models" VALUES (440, 'АОГВ-6', 13);
INSERT INTO "public"."equipment_models" VALUES (441, 'Аристон', 13);
INSERT INTO "public"."equipment_models" VALUES (442, 'Газовик', 13);
INSERT INTO "public"."equipment_models" VALUES (443, 'Люкс', 13);
INSERT INTO "public"."equipment_models" VALUES (444, 'Росс', 13);
INSERT INTO "public"."equipment_models" VALUES (445, 'Термолюкс', 13);
INSERT INTO "public"."equipment_models" VALUES (446, 'Bauertherm Premier 10', 14);
INSERT INTO "public"."equipment_models" VALUES (447, 'RGA', 14);
INSERT INTO "public"."equipment_models" VALUES (448, 'АГВ-12', 14);
INSERT INTO "public"."equipment_models" VALUES (449, 'Ангара АОГВ', 14);
INSERT INTO "public"."equipment_models" VALUES (450, 'АОГВ-11,6', 14);
INSERT INTO "public"."equipment_models" VALUES (451, 'АОГВ-15,5', 14);
INSERT INTO "public"."equipment_models" VALUES (452, 'АОГВ-17', 14);
INSERT INTO "public"."equipment_models" VALUES (453, 'Газовик', 14);
INSERT INTO "public"."equipment_models" VALUES (454, 'Конорд', 14);
INSERT INTO "public"."equipment_models" VALUES (455, 'ОК-12', 14);
INSERT INTO "public"."equipment_models" VALUES (456, 'Сиберия', 14);
INSERT INTO "public"."equipment_models" VALUES (457, 'Таганрог котел', 14);
INSERT INTO "public"."equipment_models" VALUES (458, 'Термолюкс', 14);
INSERT INTO "public"."equipment_models" VALUES (459, 'Andara', 15);
INSERT INTO "public"."equipment_models" VALUES (460, 'Siberia', 15);
INSERT INTO "public"."equipment_models" VALUES (461, 'Ангара', 15);
INSERT INTO "public"."equipment_models" VALUES (462, 'АОГВ-12,5', 15);
INSERT INTO "public"."equipment_models" VALUES (463, 'АОГВ-23', 15);
INSERT INTO "public"."equipment_models" VALUES (464, 'АОГВК-35', 15);
INSERT INTO "public"."equipment_models" VALUES (465, 'Огонёк', 15);
INSERT INTO "public"."equipment_models" VALUES (466, 'Протерм', 15);
INSERT INTO "public"."equipment_models" VALUES (467, 'Таганрог', 15);
INSERT INTO "public"."equipment_models" VALUES (468, 'Термолюкс', 15);
INSERT INTO "public"."equipment_models" VALUES (469, 'Bauertherm', 16);
INSERT INTO "public"."equipment_models" VALUES (470, 'BAVERTHERM', 16);
INSERT INTO "public"."equipment_models" VALUES (471, 'Baxi-30 i', 16);
INSERT INTO "public"."equipment_models" VALUES (472, 'Beretta', 16);
INSERT INTO "public"."equipment_models" VALUES (473, 'Ferolli', 16);
INSERT INTO "public"."equipment_models" VALUES (474, 'Lemacs', 16);
INSERT INTO "public"."equipment_models" VALUES (475, 'Mora', 16);
INSERT INTO "public"."equipment_models" VALUES (476, 'Mora- TOP', 16);
INSERT INTO "public"."equipment_models" VALUES (477, 'PiквАеТерм-32', 16);
INSERT INTO "public"."equipment_models" VALUES (478, 'Premier', 16);
INSERT INTO "public"."equipment_models" VALUES (479, 'Proterm', 16);
INSERT INTO "public"."equipment_models" VALUES (480, 'Siberia', 16);
INSERT INTO "public"."equipment_models" VALUES (481, 'Sideria', 16);
INSERT INTO "public"."equipment_models" VALUES (482, 'vitopend 100', 16);
INSERT INTO "public"."equipment_models" VALUES (483, 'Wester', 16);
INSERT INTO "public"."equipment_models" VALUES (484, 'Акцент', 16);
INSERT INTO "public"."equipment_models" VALUES (485, 'Александровск', 16);
INSERT INTO "public"."equipment_models" VALUES (486, 'Ангара', 16);
INSERT INTO "public"."equipment_models" VALUES (487, 'Апекс', 16);
INSERT INTO "public"."equipment_models" VALUES (488, 'Аристон', 16);
INSERT INTO "public"."equipment_models" VALUES (489, 'Атара', 16);
INSERT INTO "public"."equipment_models" VALUES (490, 'Атем кс', 16);
INSERT INTO "public"."equipment_models" VALUES (491, 'Аттак', 16);
INSERT INTO "public"."equipment_models" VALUES (492, 'Бакси', 16);
INSERT INTO "public"."equipment_models" VALUES (493, 'Бошь', 16);
INSERT INTO "public"."equipment_models" VALUES (494, 'Братск', 16);
INSERT INTO "public"."equipment_models" VALUES (495, 'Брянск', 16);
INSERT INTO "public"."equipment_models" VALUES (496, 'Вайланд', 16);
INSERT INTO "public"."equipment_models" VALUES (497, 'Вега', 16);
INSERT INTO "public"."equipment_models" VALUES (498, 'Вестман', 16);
INSERT INTO "public"."equipment_models" VALUES (499, 'Витогаз', 16);
INSERT INTO "public"."equipment_models" VALUES (500, 'Георгиевск', 16);
INSERT INTO "public"."equipment_models" VALUES (501, 'Гефест', 16);
INSERT INTO "public"."equipment_models" VALUES (502, 'Дани', 16);
INSERT INTO "public"."equipment_models" VALUES (503, 'Данко', 16);
INSERT INTO "public"."equipment_models" VALUES (504, 'Данко- 20 С', 16);
INSERT INTO "public"."equipment_models" VALUES (505, 'Данко-15', 16);
INSERT INTO "public"."equipment_models" VALUES (506, 'Данко-18 С', 16);
INSERT INTO "public"."equipment_models" VALUES (507, 'Данко-24', 16);
INSERT INTO "public"."equipment_models" VALUES (508, 'Дени', 16);
INSERT INTO "public"."equipment_models" VALUES (509, 'Дон', 16);
INSERT INTO "public"."equipment_models" VALUES (510, 'Дон-16', 16);
INSERT INTO "public"."equipment_models" VALUES (511, 'Евротерм', 16);
INSERT INTO "public"."equipment_models" VALUES (512, 'Евротерм', 16);
INSERT INTO "public"."equipment_models" VALUES (513, 'Евротерм', 16);
INSERT INTO "public"."equipment_models" VALUES (514, 'Емкостный Бакси КС', 16);
INSERT INTO "public"."equipment_models" VALUES (515, 'Житомир', 16);
INSERT INTO "public"."equipment_models" VALUES (516, 'Житомир "Атем"', 16);
INSERT INTO "public"."equipment_models" VALUES (517, 'Житомир 3', 16);
INSERT INTO "public"."equipment_models" VALUES (518, 'Житомир-10 "Атем-Frank"', 16);
INSERT INTO "public"."equipment_models" VALUES (519, 'Иберия', 16);
INSERT INTO "public"."equipment_models" VALUES (520, 'Кебер', 16);
INSERT INTO "public"."equipment_models" VALUES (521, 'Кебер', 16);
INSERT INTO "public"."equipment_models" VALUES (522, 'Кебер', 16);
INSERT INTO "public"."equipment_models" VALUES (523, 'Кибер', 16);
INSERT INTO "public"."equipment_models" VALUES (524, 'Конорд', 16);
INSERT INTO "public"."equipment_models" VALUES (525, 'Кореастар', 16);
INSERT INTO "public"."equipment_models" VALUES (526, 'Корея Стар', 16);
INSERT INTO "public"."equipment_models" VALUES (527, 'котел напольный BERETTA', 16);
INSERT INTO "public"."equipment_models" VALUES (528, 'КС "Пятигорск"', 16);
INSERT INTO "public"."equipment_models" VALUES (529, 'КС Лемакс Премиум-50', 16);
INSERT INTO "public"."equipment_models" VALUES (530, 'кс Сиберия', 16);
INSERT INTO "public"."equipment_models" VALUES (531, 'КС-16', 16);
INSERT INTO "public"."equipment_models" VALUES (532, 'КС-20', 16);
INSERT INTO "public"."equipment_models" VALUES (533, 'КС-Г', 16);
INSERT INTO "public"."equipment_models" VALUES (534, 'КСГ  "Лемакс"', 16);
INSERT INTO "public"."equipment_models" VALUES (535, 'КСГ "Луч"', 16);
INSERT INTO "public"."equipment_models" VALUES (536, 'КСГ "Премиум-12,5"', 16);
INSERT INTO "public"."equipment_models" VALUES (537, 'КСГ -12,5 КЕБЕР', 16);
INSERT INTO "public"."equipment_models" VALUES (538, 'КСГ 12,5 Кедр', 16);
INSERT INTO "public"."equipment_models" VALUES (539, 'КСГ-10 "Лемакс"', 16);
INSERT INTO "public"."equipment_models" VALUES (540, 'КС-Г-16', 16);
INSERT INTO "public"."equipment_models" VALUES (541, 'КС-Г-16-1', 16);
INSERT INTO "public"."equipment_models" VALUES (542, 'КСГ-25', 16);
INSERT INTO "public"."equipment_models" VALUES (543, 'КСГ-25 д', 16);
INSERT INTO "public"."equipment_models" VALUES (544, 'КСГ-30 Д', 16);
INSERT INTO "public"."equipment_models" VALUES (545, 'КСГ-7,5 "Лемакс"', 16);
INSERT INTO "public"."equipment_models" VALUES (546, 'КСГ-80', 16);
INSERT INTO "public"."equipment_models" VALUES (547, 'кстг-20', 16);
INSERT INTO "public"."equipment_models" VALUES (548, 'КСТГВ-16', 16);
INSERT INTO "public"."equipment_models" VALUES (549, 'Лемакс', 16);
INSERT INTO "public"."equipment_models" VALUES (550, 'Лемакс ксг-12,5', 16);
INSERT INTO "public"."equipment_models" VALUES (551, 'Лемакс Премиум 70', 16);
INSERT INTO "public"."equipment_models" VALUES (552, 'Лемакс Премиум-30', 16);
INSERT INTO "public"."equipment_models" VALUES (553, 'Лемакс Премиум-80', 16);
INSERT INTO "public"."equipment_models" VALUES (554, 'Лемакс-Премиум 25', 16);
INSERT INTO "public"."equipment_models" VALUES (555, 'Лидер', 16);
INSERT INTO "public"."equipment_models" VALUES (556, 'Лидер-16', 16);
INSERT INTO "public"."equipment_models" VALUES (557, 'Лидер-25', 16);
INSERT INTO "public"."equipment_models" VALUES (558, 'Лидер-40', 16);
INSERT INTO "public"."equipment_models" VALUES (559, 'Лидер-50', 16);
INSERT INTO "public"."equipment_models" VALUES (560, 'Луч', 16);
INSERT INTO "public"."equipment_models" VALUES (561, 'Меркурий', 16);
INSERT INTO "public"."equipment_models" VALUES (562, 'Мимакс', 16);
INSERT INTO "public"."equipment_models" VALUES (563, 'Мора 5107', 16);
INSERT INTO "public"."equipment_models" VALUES (564, 'ОК', 16);
INSERT INTO "public"."equipment_models" VALUES (565, 'ОК-15', 16);
INSERT INTO "public"."equipment_models" VALUES (566, 'Премиум', 16);
INSERT INTO "public"."equipment_models" VALUES (567, 'Премиум-10', 16);
INSERT INTO "public"."equipment_models" VALUES (568, 'Премиум-12,5', 16);
INSERT INTO "public"."equipment_models" VALUES (569, 'Премиум-16', 16);
INSERT INTO "public"."equipment_models" VALUES (570, 'Прометей', 16);
INSERT INTO "public"."equipment_models" VALUES (571, 'Протерм "Волк"', 16);
INSERT INTO "public"."equipment_models" VALUES (572, 'Протерм "Пантера"', 16);
INSERT INTO "public"."equipment_models" VALUES (573, 'Протерм КСГ', 16);
INSERT INTO "public"."equipment_models" VALUES (574, 'Пятигорск', 16);
INSERT INTO "public"."equipment_models" VALUES (575, 'Ривнетерм', 16);
INSERT INTO "public"."equipment_models" VALUES (576, 'Риммс', 16);
INSERT INTO "public"."equipment_models" VALUES (577, 'РОСС', 16);
INSERT INTO "public"."equipment_models" VALUES (578, 'Русь', 16);
INSERT INTO "public"."equipment_models" VALUES (579, 'Сармат', 16);
INSERT INTO "public"."equipment_models" VALUES (580, 'Сармат-1', 16);
INSERT INTO "public"."equipment_models" VALUES (581, 'Сиберия', 16);
INSERT INTO "public"."equipment_models" VALUES (582, 'Сиберия', 16);
INSERT INTO "public"."equipment_models" VALUES (583, 'Сигнал', 16);
INSERT INTO "public"."equipment_models" VALUES (584, 'Ставрус', 16);
INSERT INTO "public"."equipment_models" VALUES (585, 'Таганрог', 16);
INSERT INTO "public"."equipment_models" VALUES (586, 'Термолюкс', 16);
INSERT INTO "public"."equipment_models" VALUES (587, 'Термотехник', 16);
INSERT INTO "public"."equipment_models" VALUES (588, 'Топпотер', 16);
INSERT INTO "public"."equipment_models" VALUES (589, 'Факел КСГ-7,5', 16);
INSERT INTO "public"."equipment_models" VALUES (590, 'Феролли', 16);
INSERT INTO "public"."equipment_models" VALUES (591, 'Экогаз', 16);
INSERT INTO "public"."equipment_models" VALUES (592, 'Электролюкс', 16);
INSERT INTO "public"."equipment_models" VALUES (593, 'Юнкерс', 16);
INSERT INTO "public"."equipment_models" VALUES (594, 'Бакси Слим 300', 17);
INSERT INTO "public"."equipment_models" VALUES (595, 'кс', 17);
INSERT INTO "public"."equipment_models" VALUES (596, 'Лемакс', 17);
INSERT INTO "public"."equipment_models" VALUES (597, 'Хебер КС-г', 17);
INSERT INTO "public"."equipment_models" VALUES (598, 'VEGA', 18);
INSERT INTO "public"."equipment_models" VALUES (599, 'житомир-3', 18);
INSERT INTO "public"."equipment_models" VALUES (600, 'КС "Ангара"', 18);
INSERT INTO "public"."equipment_models" VALUES (601, 'КС "Данко"', 18);
INSERT INTO "public"."equipment_models" VALUES (602, 'КС "Кебер"', 18);
INSERT INTO "public"."equipment_models" VALUES (603, 'КС "Протерм"', 18);
INSERT INTO "public"."equipment_models" VALUES (604, 'КС "Юнкер"', 18);
INSERT INTO "public"."equipment_models" VALUES (605, 'КС "Юнкерс"', 18);
INSERT INTO "public"."equipment_models" VALUES (606, 'КСГ "Житомер"', 18);
INSERT INTO "public"."equipment_models" VALUES (607, 'КСГ 20 Д', 18);
INSERT INTO "public"."equipment_models" VALUES (608, 'КСГ- 40', 18);
INSERT INTO "public"."equipment_models" VALUES (609, 'КСГ-10', 18);
INSERT INTO "public"."equipment_models" VALUES (610, 'КСГ-12 "Лемакс"', 18);
INSERT INTO "public"."equipment_models" VALUES (611, 'КСГ-16', 18);
INSERT INTO "public"."equipment_models" VALUES (612, 'КСГ-30 "Житомер"', 18);
INSERT INTO "public"."equipment_models" VALUES (613, 'КСГ-7 "Вега"', 18);
INSERT INTO "public"."equipment_models" VALUES (614, 'КСГ-7,5', 18);
INSERT INTO "public"."equipment_models" VALUES (615, 'КС-Г-8', 18);
INSERT INTO "public"."equipment_models" VALUES (616, 'КСГВ', 18);
INSERT INTO "public"."equipment_models" VALUES (617, 'КСГВ-12,5', 18);
INSERT INTO "public"."equipment_models" VALUES (618, 'КСГВ-20н', 18);
INSERT INTO "public"."equipment_models" VALUES (619, 'КСТГ', 18);
INSERT INTO "public"."equipment_models" VALUES (620, 'КСТГ-16 "Baxi"', 18);
INSERT INTO "public"."equipment_models" VALUES (621, 'КСТГ-40 "Сармат"', 18);
INSERT INTO "public"."equipment_models" VALUES (622, 'КСТГВ-30', 18);
INSERT INTO "public"."equipment_models" VALUES (623, 'КСТГВ-31,5', 18);
INSERT INTO "public"."equipment_models" VALUES (624, 'Лемакс ксг-30', 18);
INSERT INTO "public"."equipment_models" VALUES (625, 'Dani', 19);
INSERT INTO "public"."equipment_models" VALUES (626, 'Беретта', 19);
INSERT INTO "public"."equipment_models" VALUES (627, 'кчм', 19);
INSERT INTO "public"."equipment_models" VALUES (628, 'КЧМ- Г- 2 - 5', 19);
INSERT INTO "public"."equipment_models" VALUES (629, 'КЧМ-1', 19);
INSERT INTO "public"."equipment_models" VALUES (630, 'Лемакс "Лидер 25"', 19);
INSERT INTO "public"."equipment_models" VALUES (631, 'Лидер-25', 19);
INSERT INTO "public"."equipment_models" VALUES (632, 'Протерм', 19);
INSERT INTO "public"."equipment_models" VALUES (633, 'Сиберия', 19);
INSERT INTO "public"."equipment_models" VALUES (634, 'Таганрог', 19);
INSERT INTO "public"."equipment_models" VALUES (635, 'бойлер mor- fio proterm', 22);
INSERT INTO "public"."equipment_models" VALUES (636, 'Бойлер MOR-FLO', 22);
INSERT INTO "public"."equipment_models" VALUES (637, 'Болер МОR', 22);
INSERT INTO "public"."equipment_models" VALUES (638, 'ВНИИСТО', 23);
INSERT INTO "public"."equipment_models" VALUES (639, 'АПОК- 1 - 3', 25);
INSERT INTO "public"."equipment_models" VALUES (640, 'АКХ', 26);
INSERT INTO "public"."equipment_models" VALUES (641, 'Отопительная печь', 26);
INSERT INTO "public"."equipment_models" VALUES (642, 'Ricci', 28);
INSERT INTO "public"."equipment_models" VALUES (643, 'Kuppersberg', 29);
INSERT INTO "public"."equipment_models" VALUES (644, 'Аристон', 29);
INSERT INTO "public"."equipment_models" VALUES (645, 'Ханса', 29);
INSERT INTO "public"."equipment_models" VALUES (646, '"Kuppersberg"', 31);
INSERT INTO "public"."equipment_models" VALUES (647, 'Weissgauff', 31);
INSERT INTO "public"."equipment_models" VALUES (648, 'Ardo', 33);
INSERT INTO "public"."equipment_models" VALUES (649, 'Built-in', 33);
INSERT INTO "public"."equipment_models" VALUES (650, 'Candy', 33);
INSERT INTO "public"."equipment_models" VALUES (651, 'Dexp', 33);
INSERT INTO "public"."equipment_models" VALUES (652, 'Electronicsdeluxe', 33);
INSERT INTO "public"."equipment_models" VALUES (653, 'France', 33);
INSERT INTO "public"."equipment_models" VALUES (654, 'Haier', 33);
INSERT INTO "public"."equipment_models" VALUES (655, 'Hotpoint', 33);
INSERT INTO "public"."equipment_models" VALUES (656, 'Kuppersberg', 33);
INSERT INTO "public"."equipment_models" VALUES (657, 'Lex', 33);
INSERT INTO "public"."equipment_models" VALUES (658, 'LG', 33);
INSERT INTO "public"."equipment_models" VALUES (659, 'Midea', 33);
INSERT INTO "public"."equipment_models" VALUES (660, 'Novex', 33);
INSERT INTO "public"."equipment_models" VALUES (661, 'Rodmans', 33);
INSERT INTO "public"."equipment_models" VALUES (662, 'Simfer', 33);
INSERT INTO "public"."equipment_models" VALUES (663, 'TEKA', 33);
INSERT INTO "public"."equipment_models" VALUES (664, 'Weissgauff', 33);
INSERT INTO "public"."equipment_models" VALUES (665, 'Zigment stain', 33);
INSERT INTO "public"."equipment_models" VALUES (666, 'Аристон', 33);
INSERT INTO "public"."equipment_models" VALUES (667, 'Бошь', 33);
INSERT INTO "public"."equipment_models" VALUES (668, 'Веко', 33);
INSERT INTO "public"."equipment_models" VALUES (669, 'Гефест', 33);
INSERT INTO "public"."equipment_models" VALUES (670, 'Горение', 33);
INSERT INTO "public"."equipment_models" VALUES (671, 'Дарина', 33);
INSERT INTO "public"."equipment_models" VALUES (672, 'Занусси', 33);
INSERT INTO "public"."equipment_models" VALUES (673, 'Кёртинг', 33);
INSERT INTO "public"."equipment_models" VALUES (674, 'Крона', 33);
INSERT INTO "public"."equipment_models" VALUES (675, 'ПГ-4 панель Горение', 33);
INSERT INTO "public"."equipment_models" VALUES (676, 'Самсунг', 33);
INSERT INTO "public"."equipment_models" VALUES (677, 'Симфер', 33);
INSERT INTO "public"."equipment_models" VALUES (678, 'ТЕКА', 33);
INSERT INTO "public"."equipment_models" VALUES (679, 'ТЕКА', 33);
INSERT INTO "public"."equipment_models" VALUES (680, 'Ханса', 33);
INSERT INTO "public"."equipment_models" VALUES (681, 'Электролюкс', 33);
INSERT INTO "public"."equipment_models" VALUES (682, 'Hansa', 36);
INSERT INTO "public"."equipment_models" VALUES (683, 'Lex', 36);
INSERT INTO "public"."equipment_models" VALUES (684, 'Midea', 36);
INSERT INTO "public"."equipment_models" VALUES (685, 'Ricci', 36);
INSERT INTO "public"."equipment_models" VALUES (686, 'Terra', 36);
INSERT INTO "public"."equipment_models" VALUES (687, 'Wromet', 36);
INSERT INTO "public"."equipment_models" VALUES (688, 'Ардо', 36);
INSERT INTO "public"."equipment_models" VALUES (689, 'Армавир', 36);
INSERT INTO "public"."equipment_models" VALUES (690, 'Ашхабат', 36);
INSERT INTO "public"."equipment_models" VALUES (691, 'Вера', 36);
INSERT INTO "public"."equipment_models" VALUES (692, 'Веста', 36);
INSERT INTO "public"."equipment_models" VALUES (693, 'Гефест', 36);
INSERT INTO "public"."equipment_models" VALUES (694, 'Грета', 36);
INSERT INTO "public"."equipment_models" VALUES (695, 'Дарина', 36);
INSERT INTO "public"."equipment_models" VALUES (696, 'ЕАС', 36);
INSERT INTO "public"."equipment_models" VALUES (697, 'Запорижанка', 36);
INSERT INTO "public"."equipment_models" VALUES (698, 'Запорожанка', 36);
INSERT INTO "public"."equipment_models" VALUES (699, 'Карпаты', 36);
INSERT INTO "public"."equipment_models" VALUES (700, 'Кинг', 36);
INSERT INTO "public"."equipment_models" VALUES (701, 'Лада', 36);
INSERT INTO "public"."equipment_models" VALUES (702, 'Олёночка', 36);
INSERT INTO "public"."equipment_models" VALUES (703, 'пг -2 Флама', 36);
INSERT INTO "public"."equipment_models" VALUES (704, 'ПГ-2', 36);
INSERT INTO "public"."equipment_models" VALUES (705, 'ПГ-2 "Мечта"', 36);
INSERT INTO "public"."equipment_models" VALUES (706, 'Тбилиси', 36);
INSERT INTO "public"."equipment_models" VALUES (707, 'Терек', 36);
INSERT INTO "public"."equipment_models" VALUES (708, 'Флама', 36);
INSERT INTO "public"."equipment_models" VALUES (709, 'Ханса', 36);
INSERT INTO "public"."equipment_models" VALUES (710, '"Kuppersberg"', 38);
INSERT INTO "public"."equipment_models" VALUES (711, 'Hansa', 38);
INSERT INTO "public"."equipment_models" VALUES (712, 'Ардо', 38);
INSERT INTO "public"."equipment_models" VALUES (713, 'Аристон', 38);
INSERT INTO "public"."equipment_models" VALUES (714, 'Гефест', 38);
INSERT INTO "public"."equipment_models" VALUES (715, 'Горение', 38);
INSERT INTO "public"."equipment_models" VALUES (716, 'Горький', 38);
INSERT INTO "public"."equipment_models" VALUES (717, 'Индезит', 38);
INSERT INTO "public"."equipment_models" VALUES (718, 'Индезит', 38);
INSERT INTO "public"."equipment_models" VALUES (719, 'Кёртинг', 38);
INSERT INTO "public"."equipment_models" VALUES (720, 'Лика', 38);
INSERT INTO "public"."equipment_models" VALUES (721, 'Марина', 38);
INSERT INTO "public"."equipment_models" VALUES (722, 'Марина', 38);
INSERT INTO "public"."equipment_models" VALUES (723, 'Панель ПГ-3 Вирпул', 38);
INSERT INTO "public"."equipment_models" VALUES (724, 'панель пг-3 кинг', 38);
INSERT INTO "public"."equipment_models" VALUES (725, 'ПГ-3', 38);
INSERT INTO "public"."equipment_models" VALUES (726, 'Симфер', 38);
INSERT INTO "public"."equipment_models" VALUES (727, 'Терек', 38);
INSERT INTO "public"."equipment_models" VALUES (728, 'Электролюкс', 38);
INSERT INTO "public"."equipment_models" VALUES (729, 'Ariston', 39);
INSERT INTO "public"."equipment_models" VALUES (730, 'Beko', 39);
INSERT INTO "public"."equipment_models" VALUES (731, 'Bosch', 39);
INSERT INTO "public"."equipment_models" VALUES (732, 'De luxe', 39);
INSERT INTO "public"."equipment_models" VALUES (733, 'Fagor', 39);
INSERT INTO "public"."equipment_models" VALUES (734, 'Fornelli', 39);
INSERT INTO "public"."equipment_models" VALUES (735, 'Gefest', 39);
INSERT INTO "public"."equipment_models" VALUES (736, 'Hansa', 39);
INSERT INTO "public"."equipment_models" VALUES (737, 'Indezit', 39);
INSERT INTO "public"."equipment_models" VALUES (738, 'Korting', 39);
INSERT INTO "public"."equipment_models" VALUES (739, 'Krona', 39);
INSERT INTO "public"."equipment_models" VALUES (740, 'Lex', 39);
INSERT INTO "public"."equipment_models" VALUES (741, 'Midea', 39);
INSERT INTO "public"."equipment_models" VALUES (742, 'Nardi', 39);
INSERT INTO "public"."equipment_models" VALUES (743, 'Samsung', 39);
INSERT INTO "public"."equipment_models" VALUES (744, 'Smeg', 39);
INSERT INTO "public"."equipment_models" VALUES (745, 'Wirpool', 39);
INSERT INTO "public"."equipment_models" VALUES (746, 'Горение', 39);
INSERT INTO "public"."equipment_models" VALUES (747, 'панель пг-4 RAINFORD', 39);
INSERT INTO "public"."equipment_models" VALUES (748, 'Электролюкс', 39);
INSERT INTO "public"."equipment_models" VALUES (749, '14.120.00.000', 40);
INSERT INTO "public"."equipment_models" VALUES (750, 'Ariston', 40);
INSERT INTO "public"."equipment_models" VALUES (751, 'Artel', 40);
INSERT INTO "public"."equipment_models" VALUES (752, 'Bauer', 40);
INSERT INTO "public"."equipment_models" VALUES (753, 'BAUER', 40);
INSERT INTO "public"."equipment_models" VALUES (754, 'Blomberg', 40);
INSERT INTO "public"."equipment_models" VALUES (755, 'Bompani', 40);
INSERT INTO "public"."equipment_models" VALUES (756, 'Bosch', 40);
INSERT INTO "public"."equipment_models" VALUES (757, 'Brandt', 40);
INSERT INTO "public"."equipment_models" VALUES (758, 'Candi', 40);
INSERT INTO "public"."equipment_models" VALUES (759, 'Class Line', 40);
INSERT INTO "public"."equipment_models" VALUES (760, 'Classico', 40);
INSERT INTO "public"."equipment_models" VALUES (761, 'Creta', 40);
INSERT INTO "public"."equipment_models" VALUES (762, 'De Luxe', 40);
INSERT INTO "public"."equipment_models" VALUES (763, 'Desany', 40);
INSERT INTO "public"."equipment_models" VALUES (764, 'Eac', 40);
INSERT INTO "public"."equipment_models" VALUES (765, 'Elegant', 40);
INSERT INTO "public"."equipment_models" VALUES (766, 'Erison', 40);
INSERT INTO "public"."equipment_models" VALUES (767, 'Estrada', 40);
INSERT INTO "public"."equipment_models" VALUES (768, 'Fagor', 40);
INSERT INTO "public"."equipment_models" VALUES (769, 'Fornelli', 40);
INSERT INTO "public"."equipment_models" VALUES (770, 'Gefest De Luxe', 40);
INSERT INTO "public"."equipment_models" VALUES (771, 'Geran', 40);
INSERT INTO "public"."equipment_models" VALUES (772, 'Gezaris ПГ-4', 40);
INSERT INTO "public"."equipment_models" VALUES (773, 'Gorense', 40);
INSERT INTO "public"."equipment_models" VALUES (774, 'Greta', 40);
INSERT INTO "public"."equipment_models" VALUES (775, 'Greta', 40);
INSERT INTO "public"."equipment_models" VALUES (776, 'Haier', 40);
INSERT INTO "public"."equipment_models" VALUES (777, 'Hansa', 40);
INSERT INTO "public"."equipment_models" VALUES (778, 'Hauser', 40);
INSERT INTO "public"."equipment_models" VALUES (779, 'Hauswirt', 40);
INSERT INTO "public"."equipment_models" VALUES (780, 'Hotpoint Ariston', 40);
INSERT INTO "public"."equipment_models" VALUES (781, 'Indesit', 40);
INSERT INTO "public"."equipment_models" VALUES (782, 'Inspire', 40);
INSERT INTO "public"."equipment_models" VALUES (783, 'Korling', 40);
INSERT INTO "public"."equipment_models" VALUES (784, 'Korting', 40);
INSERT INTO "public"."equipment_models" VALUES (785, 'Kup Persberg', 40);
INSERT INTO "public"."equipment_models" VALUES (786, 'Kuppersberg', 40);
INSERT INTO "public"."equipment_models" VALUES (787, 'L Gen', 40);
INSERT INTO "public"."equipment_models" VALUES (788, 'Lagan', 40);
INSERT INTO "public"."equipment_models" VALUES (789, 'Leran', 40);
INSERT INTO "public"."equipment_models" VALUES (790, 'mabe', 40);
INSERT INTO "public"."equipment_models" VALUES (791, 'MBS', 40);
INSERT INTO "public"."equipment_models" VALUES (792, 'Mobe', 40);
INSERT INTO "public"."equipment_models" VALUES (793, 'MORA', 40);
INSERT INTO "public"."equipment_models" VALUES (794, 'More', 40);
INSERT INTO "public"."equipment_models" VALUES (795, 'Neff', 40);
INSERT INTO "public"."equipment_models" VALUES (796, 'Nord', 40);
INSERT INTO "public"."equipment_models" VALUES (797, 'Oarina', 40);
INSERT INTO "public"."equipment_models" VALUES (798, 'Ocean', 40);
INSERT INTO "public"."equipment_models" VALUES (799, 'Plama', 40);
INSERT INTO "public"."equipment_models" VALUES (800, 'Polamele', 40);
INSERT INTO "public"."equipment_models" VALUES (801, 'Polmetal', 40);
INSERT INTO "public"."equipment_models" VALUES (802, 'Polmetol', 40);
INSERT INTO "public"."equipment_models" VALUES (803, 'Primier', 40);
INSERT INTO "public"."equipment_models" VALUES (804, 'PYRAM: DA', 40);
INSERT INTO "public"."equipment_models" VALUES (805, 'Rainford', 40);
INSERT INTO "public"."equipment_models" VALUES (806, 'RainFord', 40);
INSERT INTO "public"."equipment_models" VALUES (807, 'Ricci', 40);
INSERT INTO "public"."equipment_models" VALUES (808, 'Samsung', 40);
INSERT INTO "public"."equipment_models" VALUES (809, 'Samsung', 40);
INSERT INTO "public"."equipment_models" VALUES (810, 'Seran', 40);
INSERT INTO "public"."equipment_models" VALUES (811, 'Siemens', 40);
INSERT INTO "public"."equipment_models" VALUES (812, 'Siemers', 40);
INSERT INTO "public"."equipment_models" VALUES (813, 'Simens', 40);
INSERT INTO "public"."equipment_models" VALUES (814, 'Simens', 40);
INSERT INTO "public"."equipment_models" VALUES (815, 'Simfer', 40);
INSERT INTO "public"."equipment_models" VALUES (816, 'Simfer', 40);
INSERT INTO "public"."equipment_models" VALUES (817, 'Star', 40);
INSERT INTO "public"."equipment_models" VALUES (818, 'Super General', 40);
INSERT INTO "public"."equipment_models" VALUES (819, 'Supra', 40);
INSERT INTO "public"."equipment_models" VALUES (820, 'Tessa', 40);
INSERT INTO "public"."equipment_models" VALUES (821, 'Vestel', 40);
INSERT INTO "public"."equipment_models" VALUES (822, 'Weissgauff', 40);
INSERT INTO "public"."equipment_models" VALUES (823, 'Whirpool', 40);
INSERT INTO "public"."equipment_models" VALUES (824, 'Wirlpool', 40);
INSERT INTO "public"."equipment_models" VALUES (825, 'Wrozamet', 40);
INSERT INTO "public"."equipment_models" VALUES (826, 'Xangwirt', 40);
INSERT INTO "public"."equipment_models" VALUES (827, 'Zannussi', 40);
INSERT INTO "public"."equipment_models" VALUES (828, 'Авангард', 40);
INSERT INTO "public"."equipment_models" VALUES (829, 'Авекс', 40);
INSERT INTO "public"."equipment_models" VALUES (830, 'Адель', 40);
INSERT INTO "public"."equipment_models" VALUES (831, 'Арго', 40);
INSERT INTO "public"."equipment_models" VALUES (832, 'Ардерия пг', 40);
INSERT INTO "public"."equipment_models" VALUES (833, 'Ардерия пг', 40);
INSERT INTO "public"."equipment_models" VALUES (834, 'Ардо', 40);
INSERT INTO "public"."equipment_models" VALUES (835, 'Ашхабад', 40);
INSERT INTO "public"."equipment_models" VALUES (836, 'Без названия', 40);
INSERT INTO "public"."equipment_models" VALUES (837, 'Беретта', 40);
INSERT INTO "public"."equipment_models" VALUES (838, 'Брест', 40);
INSERT INTO "public"."equipment_models" VALUES (839, 'Брест-Гефест 3100', 40);
INSERT INTO "public"."equipment_models" VALUES (840, 'Варта', 40);
INSERT INTO "public"."equipment_models" VALUES (841, 'Веко', 40);
INSERT INTO "public"."equipment_models" VALUES (842, 'Вера', 40);
INSERT INTO "public"."equipment_models" VALUES (843, 'Вико', 40);
INSERT INTO "public"."equipment_models" VALUES (844, 'Виктория', 40);
INSERT INTO "public"."equipment_models" VALUES (845, 'Вирпол', 40);
INSERT INTO "public"."equipment_models" VALUES (846, 'Волгоград', 40);
INSERT INTO "public"."equipment_models" VALUES (847, 'Вромет', 40);
INSERT INTO "public"."equipment_models" VALUES (848, 'Газлюкс', 40);
INSERT INTO "public"."equipment_models" VALUES (849, 'Газмаш', 40);
INSERT INTO "public"."equipment_models" VALUES (850, 'Гека', 40);
INSERT INTO "public"."equipment_models" VALUES (851, 'Гефест', 40);
INSERT INTO "public"."equipment_models" VALUES (852, 'Гефест', 40);
INSERT INTO "public"."equipment_models" VALUES (853, 'Голдстар', 40);
INSERT INTO "public"."equipment_models" VALUES (854, 'Горение', 40);
INSERT INTO "public"."equipment_models" VALUES (855, 'Горенье', 40);
INSERT INTO "public"."equipment_models" VALUES (856, 'Грета', 40);
INSERT INTO "public"."equipment_models" VALUES (857, 'Дако', 40);
INSERT INTO "public"."equipment_models" VALUES (858, 'Данко', 40);
INSERT INTO "public"."equipment_models" VALUES (859, 'Дарина', 40);
INSERT INTO "public"."equipment_models" VALUES (860, 'Дарница', 40);
INSERT INTO "public"."equipment_models" VALUES (861, 'Десани', 40);
INSERT INTO "public"."equipment_models" VALUES (862, 'Джина', 40);
INSERT INTO "public"."equipment_models" VALUES (863, 'Дружковка', 40);
INSERT INTO "public"."equipment_models" VALUES (864, 'Жевест', 40);
INSERT INTO "public"."equipment_models" VALUES (865, 'Занусси', 40);
INSERT INTO "public"."equipment_models" VALUES (866, 'ЗигмундШтайн', 40);
INSERT INTO "public"."equipment_models" VALUES (867, 'Зингир', 40);
INSERT INTO "public"."equipment_models" VALUES (868, 'Идель', 40);
INSERT INTO "public"."equipment_models" VALUES (869, 'Идель', 40);
INSERT INTO "public"."equipment_models" VALUES (870, 'Индезит', 40);
INSERT INTO "public"."equipment_models" VALUES (871, 'Италия', 40);
INSERT INTO "public"."equipment_models" VALUES (872, 'Кагор', 40);
INSERT INTO "public"."equipment_models" VALUES (873, 'Кайзер', 40);
INSERT INTO "public"."equipment_models" VALUES (874, 'Камерон', 40);
INSERT INTO "public"."equipment_models" VALUES (875, 'Канди', 40);
INSERT INTO "public"."equipment_models" VALUES (876, 'Карина', 40);
INSERT INTO "public"."equipment_models" VALUES (877, 'Карпаты', 40);
INSERT INTO "public"."equipment_models" VALUES (878, 'Кертинг', 40);
INSERT INTO "public"."equipment_models" VALUES (879, 'Кёртинг', 40);
INSERT INTO "public"."equipment_models" VALUES (880, 'Керхи', 40);
INSERT INTO "public"."equipment_models" VALUES (881, 'Кинг', 40);
INSERT INTO "public"."equipment_models" VALUES (882, 'Классико', 40);
INSERT INTO "public"."equipment_models" VALUES (883, 'Крафт', 40);
INSERT INTO "public"."equipment_models" VALUES (884, 'Крона', 40);
INSERT INTO "public"."equipment_models" VALUES (885, 'Кубань', 40);
INSERT INTO "public"."equipment_models" VALUES (886, 'Купперсберг', 40);
INSERT INTO "public"."equipment_models" VALUES (887, 'Лада', 40);
INSERT INTO "public"."equipment_models" VALUES (888, 'Лика', 40);
INSERT INTO "public"."equipment_models" VALUES (889, 'Луна', 40);
INSERT INTO "public"."equipment_models" VALUES (890, 'Лысьва', 40);
INSERT INTO "public"."equipment_models" VALUES (891, 'Люкс LL', 40);
INSERT INTO "public"."equipment_models" VALUES (892, 'Мабе', 40);
INSERT INTO "public"."equipment_models" VALUES (893, 'Магда', 40);
INSERT INTO "public"."equipment_models" VALUES (894, 'Магистр', 40);
INSERT INTO "public"."equipment_models" VALUES (895, 'Максвелл', 40);
INSERT INTO "public"."equipment_models" VALUES (896, 'МастерГаз', 40);
INSERT INTO "public"."equipment_models" VALUES (897, 'Мидеа', 40);
INSERT INTO "public"."equipment_models" VALUES (898, 'Модель 1457', 40);
INSERT INTO "public"."equipment_models" VALUES (899, 'Мора', 40);
INSERT INTO "public"."equipment_models" VALUES (900, 'Моравия', 40);
INSERT INTO "public"."equipment_models" VALUES (901, 'Найзер', 40);
INSERT INTO "public"."equipment_models" VALUES (902, 'Нина', 40);
INSERT INTO "public"."equipment_models" VALUES (903, 'Норд', 40);
INSERT INTO "public"."equipment_models" VALUES (904, 'Омга', 40);
INSERT INTO "public"."equipment_models" VALUES (905, 'Орджон', 40);
INSERT INTO "public"."equipment_models" VALUES (906, 'панель', 40);
INSERT INTO "public"."equipment_models" VALUES (907, 'панель "Крона" 5 комфорочная', 40);
INSERT INTO "public"."equipment_models" VALUES (908, 'панель 4-х конф. Франке', 40);
INSERT INTO "public"."equipment_models" VALUES (909, 'панель 4-х конфорочная', 40);
INSERT INTO "public"."equipment_models" VALUES (910, 'панель 4-х конфорочная "Бошь"', 40);
INSERT INTO "public"."equipment_models" VALUES (911, 'панель 5-и комфорочная BOSCH', 40);
INSERT INTO "public"."equipment_models" VALUES (912, 'панель Samsyng', 40);
INSERT INTO "public"."equipment_models" VALUES (913, 'панель пг-4 " АРИСТОН"', 40);
INSERT INTO "public"."equipment_models" VALUES (914, 'панель ПГ-4 Beko', 40);
INSERT INTO "public"."equipment_models" VALUES (915, 'панель пг-4 Brandt', 40);
INSERT INTO "public"."equipment_models" VALUES (916, 'панель пг-4 FAGOR', 40);
INSERT INTO "public"."equipment_models" VALUES (917, 'панель пг-4 ZANUSSI', 40);
INSERT INTO "public"."equipment_models" VALUES (918, 'панель пг-4 ВOSCH', 40);
INSERT INTO "public"."equipment_models" VALUES (919, 'панель пг-4 вирпул', 40);
INSERT INTO "public"."equipment_models" VALUES (920, 'панель пг-4 ГОРЕНЬЕ', 40);
INSERT INTO "public"."equipment_models" VALUES (921, 'панель ПГ-4 Зигмунг', 40);
INSERT INTO "public"."equipment_models" VALUES (922, 'панель пг-4 КАЙЗЕР', 40);
INSERT INTO "public"."equipment_models" VALUES (923, 'панель пг-4 КАНДИ', 40);
INSERT INTO "public"."equipment_models" VALUES (924, 'панель пг-4 кертинг', 40);
INSERT INTO "public"."equipment_models" VALUES (925, 'панель пг-4 кинг', 40);
INSERT INTO "public"."equipment_models" VALUES (926, 'панель пг-4 КРОНА', 40);
INSERT INTO "public"."equipment_models" VALUES (927, 'панель пг-4 самсунг', 40);
INSERT INTO "public"."equipment_models" VALUES (928, 'панель пг-4 сименс', 40);
INSERT INTO "public"."equipment_models" VALUES (929, 'панель пг-4 Франки', 40);
INSERT INTO "public"."equipment_models" VALUES (930, 'панель пг-4 ХАНСА', 40);
INSERT INTO "public"."equipment_models" VALUES (931, 'панель пг-4 ЭЛЕКТРОЛЮКС', 40);
INSERT INTO "public"."equipment_models" VALUES (932, 'панель Симфер', 40);
INSERT INTO "public"."equipment_models" VALUES (933, 'панельпг-4', 40);
INSERT INTO "public"."equipment_models" VALUES (934, 'пг- 4 " АРИСТОН"', 40);
INSERT INTO "public"."equipment_models" VALUES (935, 'ПГ-4', 40);
INSERT INTO "public"."equipment_models" VALUES (936, 'ПГ-4 "Ардо"', 40);
INSERT INTO "public"."equipment_models" VALUES (937, 'ПГ-4 "Бошь"', 40);
INSERT INTO "public"."equipment_models" VALUES (938, 'ПГ-4 "Брест"', 40);
INSERT INTO "public"."equipment_models" VALUES (939, 'ПГ-4 "Гефест"', 40);
INSERT INTO "public"."equipment_models" VALUES (940, 'ПГ-4 "Горенье"', 40);
INSERT INTO "public"."equipment_models" VALUES (941, 'ПГ-4 "Гретта"', 40);
INSERT INTO "public"."equipment_models" VALUES (942, 'ПГ-4 "Индезит"', 40);
INSERT INTO "public"."equipment_models" VALUES (943, 'ПГ-4 "Ханса"', 40);
INSERT INTO "public"."equipment_models" VALUES (944, 'ПГ-4 "Ханса"', 40);
INSERT INTO "public"."equipment_models" VALUES (945, 'ПГ-4 "Электролюкс"', 40);
INSERT INTO "public"."equipment_models" VALUES (946, 'пг-4 BEKO', 40);
INSERT INTO "public"."equipment_models" VALUES (947, 'ПГ-4 CIVI', 40);
INSERT INTO "public"."equipment_models" VALUES (948, 'пг-4 DAKO', 40);
INSERT INTO "public"."equipment_models" VALUES (949, 'пг-4 Greta', 40);
INSERT INTO "public"."equipment_models" VALUES (950, 'ПГ-4 HAUSER', 40);
INSERT INTO "public"."equipment_models" VALUES (951, 'пг-4 MABE', 40);
INSERT INTO "public"."equipment_models" VALUES (952, 'пг-4 RIKO', 40);
INSERT INTO "public"."equipment_models" VALUES (953, 'пг-4 zanussi', 40);
INSERT INTO "public"."equipment_models" VALUES (954, 'пг-4 Брест', 40);
INSERT INTO "public"."equipment_models" VALUES (955, 'пг-4 вирпул', 40);
INSERT INTO "public"."equipment_models" VALUES (956, 'пг-4 делюкс', 40);
INSERT INTO "public"."equipment_models" VALUES (957, 'пг-4 кертирг', 40);
INSERT INTO "public"."equipment_models" VALUES (958, 'пг-4 Кинг', 40);
INSERT INTO "public"."equipment_models" VALUES (959, 'пг-4 Крона', 40);
INSERT INTO "public"."equipment_models" VALUES (960, 'пг-4 норд', 40);
INSERT INTO "public"."equipment_models" VALUES (961, 'пг-4 терек', 40);
INSERT INTO "public"."equipment_models" VALUES (962, 'пг-4 флама', 40);
INSERT INTO "public"."equipment_models" VALUES (963, 'ПГ-5', 40);
INSERT INTO "public"."equipment_models" VALUES (964, 'пг-6', 40);
INSERT INTO "public"."equipment_models" VALUES (965, 'ПГ-6', 40);
INSERT INTO "public"."equipment_models" VALUES (966, 'Пламя', 40);
INSERT INTO "public"."equipment_models" VALUES (967, 'Полячка', 40);
INSERT INTO "public"."equipment_models" VALUES (968, 'Раинфорд', 40);
INSERT INTO "public"."equipment_models" VALUES (969, 'Рика', 40);
INSERT INTO "public"."equipment_models" VALUES (970, 'Ричи', 40);
INSERT INTO "public"."equipment_models" VALUES (971, 'Ролметал', 40);
INSERT INTO "public"."equipment_models" VALUES (972, 'Россиянка', 40);
INSERT INTO "public"."equipment_models" VALUES (973, 'С- N', 40);
INSERT INTO "public"."equipment_models" VALUES (974, 'Сlassic', 40);
INSERT INTO "public"."equipment_models" VALUES (975, 'Симфер', 40);
INSERT INTO "public"."equipment_models" VALUES (976, 'Смег', 40);
INSERT INTO "public"."equipment_models" VALUES (977, 'Стар', 40);
INSERT INTO "public"."equipment_models" VALUES (978, 'Тбилисси', 40);
INSERT INTO "public"."equipment_models" VALUES (979, 'Тека', 40);
INSERT INTO "public"."equipment_models" VALUES (980, 'Терек', 40);
INSERT INTO "public"."equipment_models" VALUES (981, 'Терра', 40);
INSERT INTO "public"."equipment_models" VALUES (982, 'Тула', 40);
INSERT INTO "public"."equipment_models" VALUES (983, 'Фагор', 40);
INSERT INTO "public"."equipment_models" VALUES (984, 'Флама', 40);
INSERT INTO "public"."equipment_models" VALUES (985, 'Форон', 40);
INSERT INTO "public"."equipment_models" VALUES (986, 'Хайсер', 40);
INSERT INTO "public"."equipment_models" VALUES (987, 'Ханса', 40);
INSERT INTO "public"."equipment_models" VALUES (988, 'Хаус вирт', 40);
INSERT INTO "public"."equipment_models" VALUES (989, 'Шорта', 40);
INSERT INTO "public"."equipment_models" VALUES (990, 'Штамп', 40);
INSERT INTO "public"."equipment_models" VALUES (991, 'Эдель', 40);
INSERT INTO "public"."equipment_models" VALUES (992, 'Эко лайн', 40);
INSERT INTO "public"."equipment_models" VALUES (993, 'Электа', 40);
INSERT INTO "public"."equipment_models" VALUES (994, 'Электра', 40);
INSERT INTO "public"."equipment_models" VALUES (995, 'Электролюкс', 40);
INSERT INTO "public"."equipment_models" VALUES (996, 'Электролюкс', 40);
INSERT INTO "public"."equipment_models" VALUES (997, 'Электролюкс', 40);
INSERT INTO "public"."equipment_models" VALUES (998, 'Элиста', 40);
INSERT INTO "public"."equipment_models" VALUES (999, 'Бошь', 41);
INSERT INTO "public"."equipment_models" VALUES (1000, 'ГОРЕНИЕ', 41);
INSERT INTO "public"."equipment_models" VALUES (1001, 'Сименс', 41);

-- ----------------------------
-- Table structure for equipment_types
-- ----------------------------
DROP TABLE IF EXISTS "public"."equipment_types";
CREATE TABLE "public"."equipment_types" (
  "id" int8 NOT NULL DEFAULT nextval('equipment_types_id_seq'::regclass),
  "type_name" varchar(255) COLLATE "pg_catalog"."default"
)
;

-- ----------------------------
-- Records of equipment_types
-- ----------------------------
INSERT INTO "public"."equipment_types" VALUES (2, '﻿ВНИИСТО');
INSERT INTO "public"."equipment_types" VALUES (3, 'Внутренний газопровод');
INSERT INTO "public"."equipment_types" VALUES (4, 'Водонагреватель проточный газовый автоматический');
INSERT INTO "public"."equipment_types" VALUES (5, 'Водонагреватель проточный газовый полуавтоматический');
INSERT INTO "public"."equipment_types" VALUES (6, 'Водонагреватель проточный газовый с закрытой/открытой камерой');
INSERT INTO "public"."equipment_types" VALUES (7, 'Газовое оборудование индивидуальной бани (теплицы, гаража) при одной горелке');
INSERT INTO "public"."equipment_types" VALUES (8, 'Газовый колодец');
INSERT INTO "public"."equipment_types" VALUES (9, 'Газовый счетчик');
INSERT INTO "public"."equipment_types" VALUES (10, 'Двухконтурные котлы');
INSERT INTO "public"."equipment_types" VALUES (11, 'Духовой шкаф');
INSERT INTO "public"."equipment_types" VALUES (12, 'Емкостный водонагреватель импортный одноконтурный');
INSERT INTO "public"."equipment_types" VALUES (13, 'Емкостный водонагреватель типа АГВ-80, АГВ-120, АОГВ-4, АОГВ-6, АОГВ-10');
INSERT INTO "public"."equipment_types" VALUES (14, 'Емкостный водонагреватель типа АОГВ-11, АОГВ-15, АОГВ-20');
INSERT INTO "public"."equipment_types" VALUES (15, 'Емкостный водонагреватель типа АОГВ-17,5, АОГВ-23, АОГВ-29');
INSERT INTO "public"."equipment_types" VALUES (16, 'Емкостный водонагреватель типа ДОН-16, ДОН-31,5, Хопер');
INSERT INTO "public"."equipment_types" VALUES (17, 'Емкостный водонагреватель типа КС');
INSERT INTO "public"."equipment_types" VALUES (18, 'Емкостный водонагреватель типа КСГ-7,5, КСГ-10, КСГ-12,5, КСГ-16, КСГ-20, КСГ-25, КСГ-30');
INSERT INTO "public"."equipment_types" VALUES (19, 'Емкостный водонагреватель типа КЧМ');
INSERT INTO "public"."equipment_types" VALUES (20, 'Калорифер газовый');
INSERT INTO "public"."equipment_types" VALUES (21, 'Кипятильник КНД');
INSERT INTO "public"."equipment_types" VALUES (22, 'Комбинированная бойлерная установка типа "Мора"');
INSERT INTO "public"."equipment_types" VALUES (23, 'Котел отопительный ВНИИСТО');
INSERT INTO "public"."equipment_types" VALUES (24, 'Лабораторная горелка');
INSERT INTO "public"."equipment_types" VALUES (25, 'Отопительная печь без автоматики');
INSERT INTO "public"."equipment_types" VALUES (26, 'Отопительная печь с автоматикой');
INSERT INTO "public"."equipment_types" VALUES (27, 'Отопительный аппарат');
INSERT INTO "public"."equipment_types" VALUES (28, 'Панель газовая 2-х горелочная');
INSERT INTO "public"."equipment_types" VALUES (29, 'Панель газовая 2-х горелочная (без духового шкафа)');
INSERT INTO "public"."equipment_types" VALUES (30, 'Панель газовая 3-х горелочная');
INSERT INTO "public"."equipment_types" VALUES (31, 'Панель газовая 3-х горелочная (без духового шкафа)');
INSERT INTO "public"."equipment_types" VALUES (32, 'Панель газовая 4-х горелочная');
INSERT INTO "public"."equipment_types" VALUES (33, 'Панель газовая 4-х горелочная (без духового шкафа)');
INSERT INTO "public"."equipment_types" VALUES (34, 'Пищеварочный котел');
INSERT INTO "public"."equipment_types" VALUES (35, 'Плита газовая 2-горелочная (без духового шкафа)');
INSERT INTO "public"."equipment_types" VALUES (36, 'Плита газовая 2-х конфорочная');
INSERT INTO "public"."equipment_types" VALUES (37, 'Плита газовая 3-горелочная (без духового шкафа)');
INSERT INTO "public"."equipment_types" VALUES (38, 'Плита газовая 3-х конфорочная');
INSERT INTO "public"."equipment_types" VALUES (39, 'Плита газовая 4-горелочная (без духового шкафа)');
INSERT INTO "public"."equipment_types" VALUES (40, 'Плита газовая 4-х конфорочная');
INSERT INTO "public"."equipment_types" VALUES (41, 'Плита газовая 5-ти конфорочная');
INSERT INTO "public"."equipment_types" VALUES (42, 'Плита ресторанная без автоматики');
INSERT INTO "public"."equipment_types" VALUES (43, 'Плита ресторанная с автоматикой');
INSERT INTO "public"."equipment_types" VALUES (44, 'Прочее газовое оборудование');
INSERT INTO "public"."equipment_types" VALUES (45, 'Сигнализатор загазованности');
INSERT INTO "public"."equipment_types" VALUES (46, 'ШРП');

-- ----------------------------
-- Table structure for images
-- ----------------------------
DROP TABLE IF EXISTS "public"."images";
CREATE TABLE "public"."images" (
  "id" int8 NOT NULL DEFAULT nextval('images_id_seq'::regclass),
  "title" varchar(255) COLLATE "pg_catalog"."default",
  "meta_data" text COLLATE "pg_catalog"."default",
  "fs_saveto" varchar(255) COLLATE "pg_catalog"."default",
  "fs_alias" varchar(255) COLLATE "pg_catalog"."default",
  "fs_filename" varchar(255) COLLATE "pg_catalog"."default",
  "fs_md5hash" varchar(255) COLLATE "pg_catalog"."default",
  "fs_filesize" float8,
  "dt_created" timestamp(6),
  "dt_updated" timestamp(6),
  "is_trash" bool,
  "fs_extension" varchar(255) COLLATE "pg_catalog"."default",
  "filename" varchar(255) COLLATE "pg_catalog"."default"
)
;

-- ----------------------------
-- Table structure for order_equipments
-- ----------------------------
DROP TABLE IF EXISTS "public"."order_equipments";
CREATE TABLE "public"."order_equipments" (
  "id" int8 NOT NULL DEFAULT nextval('order_equipments_id_seq'::regclass),
  "equipment_types_ref" int8,
  "equipment_models_ref" int8,
  "other_model" varchar(255) COLLATE "pg_catalog"."default",
  "image_ref" int8
)
;

-- ----------------------------
-- Table structure for order_history
-- ----------------------------
DROP TABLE IF EXISTS "public"."order_history";
CREATE TABLE "public"."order_history" (
  "id" int8 NOT NULL DEFAULT nextval('order_history_id_seq'::regclass),
  "orders_ref" int8 NOT NULL,
  "order_comment" text COLLATE "pg_catalog"."default",
  "order_status" varchar(255) COLLATE "pg_catalog"."default",
  "dt_created" timestamp(6)
)
;

-- ----------------------------
-- Table structure for orders
-- ----------------------------
DROP TABLE IF EXISTS "public"."orders";
CREATE TABLE "public"."orders" (
  "id" int8 NOT NULL DEFAULT nextval('orders_id_seq'::regclass),
  "first_name_owner" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "second_name_owner" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "third_name_owner" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "account" varchar(12) COLLATE "pg_catalog"."default" NOT NULL,
  "is_declarant_agent" bool,
  "first_name_agent" varchar(255) COLLATE "pg_catalog"."default",
  "second_name_agent" varchar(255) COLLATE "pg_catalog"."default",
  "third_name_agent" varchar(255) COLLATE "pg_catalog"."default",
  "proxy_image_ref" int8,
  "index" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "state" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "city" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "street" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "house" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "building" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "apartment" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "address" text COLLATE "pg_catalog"."default" NOT NULL,
  "reason_ref" int8 NOT NULL,
  "reason_text" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "phone" varchar(10) COLLATE "pg_catalog"."default" NOT NULL,
  "email" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "status_1c" varchar(255) COLLATE "pg_catalog"."default",
  "is_order_send" bool,
  "order_uid" varchar(255) COLLATE "pg_catalog"."default"
)
;
COMMENT ON COLUMN "public"."orders"."id" IS 'ID заявки в системе сайта';
COMMENT ON COLUMN "public"."orders"."first_name_owner" IS 'Имя собственника';
COMMENT ON COLUMN "public"."orders"."second_name_owner" IS 'Фамилия собственника';
COMMENT ON COLUMN "public"."orders"."third_name_owner" IS 'Отчество собственника';
COMMENT ON COLUMN "public"."orders"."account" IS 'Лицевой счет';
COMMENT ON COLUMN "public"."orders"."is_declarant_agent" IS 'Заявитель является собственником';
COMMENT ON COLUMN "public"."orders"."first_name_agent" IS 'Имя доверенного лица';
COMMENT ON COLUMN "public"."orders"."second_name_agent" IS 'Фамилия доверенного лица';
COMMENT ON COLUMN "public"."orders"."third_name_agent" IS 'Отчество доверенного лица';
COMMENT ON COLUMN "public"."orders"."proxy_image_ref" IS 'Фото доверенности';
COMMENT ON COLUMN "public"."orders"."index" IS 'Индекс';
COMMENT ON COLUMN "public"."orders"."state" IS 'Область/Край';
COMMENT ON COLUMN "public"."orders"."city" IS 'Город/Населенный пункт';
COMMENT ON COLUMN "public"."orders"."street" IS 'Улица';
COMMENT ON COLUMN "public"."orders"."house" IS 'Номер дома';
COMMENT ON COLUMN "public"."orders"."building" IS 'Корпус';
COMMENT ON COLUMN "public"."orders"."apartment" IS 'Квартира';
COMMENT ON COLUMN "public"."orders"."address" IS 'Адрес объекта';
COMMENT ON COLUMN "public"."orders"."reason_ref" IS 'Причина обращения';
COMMENT ON COLUMN "public"."orders"."reason_text" IS 'Текст обращения';
COMMENT ON COLUMN "public"."orders"."phone" IS 'Контактный телефон';
COMMENT ON COLUMN "public"."orders"."email" IS 'Email';
COMMENT ON COLUMN "public"."orders"."status_1c" IS 'Статус в системе 1с (приходит из 1с в ответе на запрос из вебформы)';
COMMENT ON COLUMN "public"."orders"."is_order_send" IS 'Принята ли заявка в системе 1С';
COMMENT ON COLUMN "public"."orders"."order_uid" IS 'UID заявки в системе 1С';

-- ----------------------------
-- Table structure for reasons
-- ----------------------------
DROP TABLE IF EXISTS "public"."reasons";
CREATE TABLE "public"."reasons" (
  "id" int8 NOT NULL DEFAULT nextval('reasons_id_seq'::regclass),
  "reason_name" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "reason_code" varchar(255) COLLATE "pg_catalog"."default"
)
;

-- ----------------------------
-- Records of reasons
-- ----------------------------
INSERT INTO "public"."reasons" VALUES (1, 'Восстановление ИТД', NULL);
INSERT INTO "public"."reasons" VALUES (2, 'восстановление ИТД на газификацию квартиры (домовладения)', NULL);
INSERT INTO "public"."reasons" VALUES (3, 'Врезка газопровода', NULL);
INSERT INTO "public"."reasons" VALUES (4, 'выдача (временной) абонентной книжки', NULL);
INSERT INTO "public"."reasons" VALUES (5, 'выдача абонентной книжки', NULL);
INSERT INTO "public"."reasons" VALUES (6, 'выдача заключения о технической возможности транспортировки природного газа', NULL);
INSERT INTO "public"."reasons" VALUES (7, 'Выдача копии акта об отключении', NULL);
INSERT INTO "public"."reasons" VALUES (8, 'выдача копий ИТД', NULL);
INSERT INTO "public"."reasons" VALUES (9, 'выдача копий проекта газификации', NULL);
INSERT INTO "public"."reasons" VALUES (10, 'выдача справки на субсидии', NULL);
INSERT INTO "public"."reasons" VALUES (11, 'выдача справки о газификации домовладения (квартиры)', NULL);
INSERT INTO "public"."reasons" VALUES (12, 'Выдача ТУ', NULL);
INSERT INTO "public"."reasons" VALUES (13, 'выезд представителя для выполнения земляных работ', NULL);
INSERT INTO "public"."reasons" VALUES (14, 'вызов представителя для определения объема работ', NULL);
INSERT INTO "public"."reasons" VALUES (15, 'выписка истории пуска газа', NULL);
INSERT INTO "public"."reasons" VALUES (16, 'Газификация нового литера', NULL);
INSERT INTO "public"."reasons" VALUES (17, 'демонтаж байпаса', NULL);
INSERT INTO "public"."reasons" VALUES (18, 'демонтаж ВПГ', NULL);
INSERT INTO "public"."reasons" VALUES (19, 'демонтаж газового оборудования', NULL);
INSERT INTO "public"."reasons" VALUES (20, 'демонтаж газового счетчика', NULL);
INSERT INTO "public"."reasons" VALUES (21, 'демонтаж газопровода', NULL);
INSERT INTO "public"."reasons" VALUES (22, 'демонтаж отопительного прибора', NULL);
INSERT INTO "public"."reasons" VALUES (23, 'демонтаж ПГ', NULL);
INSERT INTO "public"."reasons" VALUES (24, 'жалоба', NULL);
INSERT INTO "public"."reasons" VALUES (25, 'заглушка одной конфорки на ПГ', NULL);
INSERT INTO "public"."reasons" VALUES (26, 'заключение договора на ТО ВДГО', NULL);
INSERT INTO "public"."reasons" VALUES (27, 'закрытие лицевого счета', NULL);
INSERT INTO "public"."reasons" VALUES (28, 'замена ВПГ', NULL);
INSERT INTO "public"."reasons" VALUES (29, 'замена газового счетчика', NULL);
INSERT INTO "public"."reasons" VALUES (30, 'замена отопительного прибора (котла)', NULL);
INSERT INTO "public"."reasons" VALUES (31, 'замена ПГ', NULL);
INSERT INTO "public"."reasons" VALUES (32, 'Заявление на возврат денег', NULL);
INSERT INTO "public"."reasons" VALUES (33, 'земельные работы', NULL);
INSERT INTO "public"."reasons" VALUES (34, 'изготовление проекта', NULL);
INSERT INTO "public"."reasons" VALUES (35, 'инвентаризация газового оборудования', NULL);
INSERT INTO "public"."reasons" VALUES (36, 'инструктаж по пользованию газовыми приборами', NULL);
INSERT INTO "public"."reasons" VALUES (37, 'обрезка газопровода (реконструкция, снос дома)', NULL);
INSERT INTO "public"."reasons" VALUES (38, 'основания подключения другого абонента', NULL);
INSERT INTO "public"."reasons" VALUES (39, 'отключение г/оборудования', NULL);
INSERT INTO "public"."reasons" VALUES (40, 'отключить соседа', NULL);
INSERT INTO "public"."reasons" VALUES (41, 'открытие лицевого счета', NULL);
INSERT INTO "public"."reasons" VALUES (42, 'Первичные пуски нового домовладения', NULL);
INSERT INTO "public"."reasons" VALUES (43, 'первичный пуск ВПГ', NULL);
INSERT INTO "public"."reasons" VALUES (44, 'первичный пуск отопительного прибора', NULL);
INSERT INTO "public"."reasons" VALUES (45, 'первичный пуск ПГ', NULL);
INSERT INTO "public"."reasons" VALUES (46, 'перенос газового счетчика', NULL);
INSERT INTO "public"."reasons" VALUES (47, 'перенос газовых приборов в другое место без сварки', NULL);
INSERT INTO "public"."reasons" VALUES (48, 'перенос газовых приборов в другое место со сваркой', NULL);
INSERT INTO "public"."reasons" VALUES (49, 'перенос трубы', NULL);
INSERT INTO "public"."reasons" VALUES (50, 'переоформление ИТД', NULL);
INSERT INTO "public"."reasons" VALUES (51, 'перерасчет по оплате ТО', NULL);
INSERT INTO "public"."reasons" VALUES (52, 'письменный ответ для населения', NULL);
INSERT INTO "public"."reasons" VALUES (53, 'Поверка газового счетчика', NULL);
INSERT INTO "public"."reasons" VALUES (54, 'Подключение абонента по заявлению', NULL);
INSERT INTO "public"."reasons" VALUES (55, 'подключение газовых приборов (сварка)', NULL);
INSERT INTO "public"."reasons" VALUES (56, 'подключение газовых приборов без отсоединения (заглушка)', NULL);
INSERT INTO "public"."reasons" VALUES (57, 'Проверка ИТД', NULL);
INSERT INTO "public"."reasons" VALUES (58, 'продажа газового оборудования', NULL);
INSERT INTO "public"."reasons" VALUES (59, 'производство земляных работ экскаватором', NULL);
INSERT INTO "public"."reasons" VALUES (60, 'расторжение договора', NULL);
INSERT INTO "public"."reasons" VALUES (61, 'реконструкция газопровода (перенос, арка и др.)', NULL);
INSERT INTO "public"."reasons" VALUES (62, 'Ремонт газового оборудования', NULL);
INSERT INTO "public"."reasons" VALUES (63, 'Розничная Торговля', NULL);
INSERT INTO "public"."reasons" VALUES (64, 'Смена адреса', NULL);
INSERT INTO "public"."reasons" VALUES (65, 'снятие газового счетчика на поверку (ремонт)', NULL);
INSERT INTO "public"."reasons" VALUES (66, 'снятие счетчика на экспертизу', NULL);
INSERT INTO "public"."reasons" VALUES (67, 'согласование даты проведения  ТО', NULL);
INSERT INTO "public"."reasons" VALUES (68, 'соглашение о  рассрочке на  оплату ТО', NULL);
INSERT INTO "public"."reasons" VALUES (69, 'Строительно-монтажные работы', NULL);
INSERT INTO "public"."reasons" VALUES (70, 'установка газового счетчика', NULL);
INSERT INTO "public"."reasons" VALUES (71, 'Установка дополнительного газового оборудования', NULL);
INSERT INTO "public"."reasons" VALUES (72, 'установка заглушки на газовых приборах, в связи с непроживанием (ремонтом)', NULL);
INSERT INTO "public"."reasons" VALUES (73, 'установка сигнализатора загазованности', NULL);
INSERT INTO "public"."reasons" VALUES (74, 'Установка СиКЗ', NULL);

-- ----------------------------
-- Table structure for statuses
-- ----------------------------
DROP TABLE IF EXISTS "public"."statuses";
CREATE TABLE "public"."statuses" (
  "id" int8 NOT NULL DEFAULT nextval('statuses_id_seq'::regclass),
  "status_name" varchar(255) COLLATE "pg_catalog"."default"
)
;

-- ----------------------------
-- Records of statuses
-- ----------------------------
INSERT INTO "public"."statuses" VALUES (1, 'Новая');
INSERT INTO "public"."statuses" VALUES (2, 'На рассмотрении');
INSERT INTO "public"."statuses" VALUES (3, 'В работе');
INSERT INTO "public"."statuses" VALUES (4, 'Доработка');
INSERT INTO "public"."statuses" VALUES (5, 'Закрыта');
INSERT INTO "public"."statuses" VALUES (6, 'Отказано');
INSERT INTO "public"."statuses" VALUES (7, 'Отменена абонентом');

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."equipment_models_id_seq"
OWNED BY "public"."equipment_models"."id";
SELECT setval('"public"."equipment_models_id_seq"', 1003, true);
ALTER SEQUENCE "public"."equipment_types_id_seq"
OWNED BY "public"."equipment_types"."id";
SELECT setval('"public"."equipment_types_id_seq"', 48, true);
ALTER SEQUENCE "public"."images_id_seq"
OWNED BY "public"."images"."id";
SELECT setval('"public"."images_id_seq"', 3, false);
ALTER SEQUENCE "public"."order_equipments_id_seq"
OWNED BY "public"."order_equipments"."id";
SELECT setval('"public"."order_equipments_id_seq"', 3, false);
ALTER SEQUENCE "public"."order_history_id_seq"
OWNED BY "public"."order_history"."id";
SELECT setval('"public"."order_history_id_seq"', 3, false);
ALTER SEQUENCE "public"."orders_id_seq"
OWNED BY "public"."orders"."id";
SELECT setval('"public"."orders_id_seq"', 3, false);
ALTER SEQUENCE "public"."reasons_id_seq"
OWNED BY "public"."reasons"."id";
SELECT setval('"public"."reasons_id_seq"', 76, true);
ALTER SEQUENCE "public"."statuses_id_seq"
OWNED BY "public"."statuses"."id";
SELECT setval('"public"."statuses_id_seq"', 9, true);

-- ----------------------------
-- Primary Key structure for table equipment_models
-- ----------------------------
ALTER TABLE "public"."equipment_models" ADD CONSTRAINT "equipment_models_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table equipment_types
-- ----------------------------
ALTER TABLE "public"."equipment_types" ADD CONSTRAINT "equipment_types_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table images
-- ----------------------------
ALTER TABLE "public"."images" ADD CONSTRAINT "images_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table order_equipments
-- ----------------------------
ALTER TABLE "public"."order_equipments" ADD CONSTRAINT "order_equipments_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table order_history
-- ----------------------------
ALTER TABLE "public"."order_history" ADD CONSTRAINT "order_history_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table orders
-- ----------------------------
ALTER TABLE "public"."orders" ADD CONSTRAINT "orders_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table reasons
-- ----------------------------
ALTER TABLE "public"."reasons" ADD CONSTRAINT "reasons_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table statuses
-- ----------------------------
ALTER TABLE "public"."statuses" ADD CONSTRAINT "statuses_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Foreign Keys structure for table equipment_models
-- ----------------------------
ALTER TABLE "public"."equipment_models" ADD CONSTRAINT "equipment_models_fk1" FOREIGN KEY ("equipment_types_ref") REFERENCES "public"."equipment_types" ("id") ON DELETE CASCADE ON UPDATE CASCADE;

-- ----------------------------
-- Foreign Keys structure for table order_equipments
-- ----------------------------
ALTER TABLE "public"."order_equipments" ADD CONSTRAINT "order_equipments_fk1" FOREIGN KEY ("image_ref") REFERENCES "public"."images" ("id") ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE "public"."order_equipments" ADD CONSTRAINT "order_equipments_fk2" FOREIGN KEY ("equipment_types_ref") REFERENCES "public"."equipment_types" ("id") ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE "public"."order_equipments" ADD CONSTRAINT "order_equipments_fk3" FOREIGN KEY ("equipment_models_ref") REFERENCES "public"."equipment_models" ("id") ON DELETE CASCADE ON UPDATE CASCADE;

-- ----------------------------
-- Foreign Keys structure for table order_history
-- ----------------------------
ALTER TABLE "public"."order_history" ADD CONSTRAINT "order_history_fk1" FOREIGN KEY ("orders_ref") REFERENCES "public"."orders" ("id") ON DELETE CASCADE ON UPDATE CASCADE;

-- ----------------------------
-- Foreign Keys structure for table orders
-- ----------------------------
ALTER TABLE "public"."orders" ADD CONSTRAINT "orders_fk1" FOREIGN KEY ("proxy_image_ref") REFERENCES "public"."images" ("id") ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE "public"."orders" ADD CONSTRAINT "orders_fk2" FOREIGN KEY ("reason_ref") REFERENCES "public"."reasons" ("id") ON DELETE CASCADE ON UPDATE CASCADE;
