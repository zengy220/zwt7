/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : zwt

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-10-16 21:03:07
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for cs_active_gift
-- ----------------------------
DROP TABLE IF EXISTS `cs_active_gift`;
CREATE TABLE `cs_active_gift` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL COMMENT '礼品名称',
  `points` int(10) DEFAULT '0' COMMENT '该活动礼品对应的积分数值',
  `addtime` int(10) DEFAULT NULL COMMENT '创建该类型产品的时间',
  `is_active` smallint(1) DEFAULT '1' COMMENT '是否参与活动 1参与0下架',
  `imagePath` varchar(100) DEFAULT NULL COMMENT '商品的图片地址',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='参于兑换活动的礼品表';

-- ----------------------------
-- Records of cs_active_gift
-- ----------------------------
INSERT INTO `cs_active_gift` VALUES ('1', '1', '10元酱香型槟榔', '100', null, '1', 'images/img1.jpg');
INSERT INTO `cs_active_gift` VALUES ('2', '2', '20元清香型槟榔', '200', null, '1', 'images/img2.jpg');

-- ----------------------------
-- Table structure for cs_ad_content
-- ----------------------------
DROP TABLE IF EXISTS `cs_ad_content`;
CREATE TABLE `cs_ad_content` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(20) DEFAULT NULL COMMENT '标题',
  `ad_list_id` int(11) DEFAULT NULL COMMENT '所属广告位ID',
  `sort` int(11) DEFAULT NULL COMMENT '排序',
  `url` varchar(100) DEFAULT NULL COMMENT '跳转地址',
  `img` text COMMENT '图片地址',
  `word` text COMMENT '文字',
  `addtime` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=49 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cs_ad_content
-- ----------------------------
INSERT INTO `cs_ad_content` VALUES ('1', 'banner1', '1', '4', 'http://360.cn', 'ad1495764494.jpg', '', '1495188244');
INSERT INTO `cs_ad_content` VALUES ('7', '首页资讯广告', '3', '1', 'http://www.baidu.com', 'ad1495856138.png', '首页资讯广告', '1495539062');
INSERT INTO `cs_ad_content` VALUES ('13', '招商加盟顶部广告', '8', '3', 'http://taobao.com', 'ad1495590884.jpg', '招商加盟顶部广告', '1495590884');
INSERT INTO `cs_ad_content` VALUES ('38', '1111', '5', '0', 'http://baidu.com', 'ad1495679583.jpg', '', '1495618637');
INSERT INTO `cs_ad_content` VALUES ('39', '资讯中心广告', '7', '10', 'http://24jd.com', 'ad1495679551.jpg', '非大幅度', '1495618818');
INSERT INTO `cs_ad_content` VALUES ('40', '产品中心广告', '6', '0', 'http://24jd.com', 'ad1495679455.jpg', '冯达飞', '1495618921');
INSERT INTO `cs_ad_content` VALUES ('41', '招商电话：13911112222', '3', '2', 'http://taobao.com', 'ad1495619077.png', '1', '1495619077');
INSERT INTO `cs_ad_content` VALUES ('44', '鱼鱼', '2', '1', 'http://taobao.com', 'ad1495620099.png', '', '1495620099');

-- ----------------------------
-- Table structure for cs_ad_list
-- ----------------------------
DROP TABLE IF EXISTS `cs_ad_list`;
CREATE TABLE `cs_ad_list` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL COMMENT '名称',
  `simple_code` varchar(50) DEFAULT NULL COMMENT '简码',
  `illustration` varchar(60) DEFAULT NULL COMMENT '说明',
  `addtime` varchar(15) DEFAULT NULL,
  `is_delete` int(3) DEFAULT '1' COMMENT '是否能删除（1能0不能）',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cs_ad_list
-- ----------------------------
INSERT INTO `cs_ad_list` VALUES ('1', '首页bannner', 'SYGG', '首页顶部浮动banner位置', '1494317771', '1');
INSERT INTO `cs_ad_list` VALUES ('2', '删除位', 'SCW', '删除', '1495433613', '1');
INSERT INTO `cs_ad_list` VALUES ('3', '首页资讯广告', 'SYZXGG', '首页资讯中心左边广告位', '1495533150', '1');
INSERT INTO `cs_ad_list` VALUES ('5', '品牌文化顶部广告', 'PPWH', '品牌文化顶部广告（请勿删除）', '1495590085', '1');
INSERT INTO `cs_ad_list` VALUES ('6', '产品中心顶部广告', 'CPZX', '产品中心顶部广告(请勿删除)', '1495590637', '1');
INSERT INTO `cs_ad_list` VALUES ('7', '资讯中心顶部广告位', 'ZXZX', '资讯中心顶部广告位（请勿删除）', '1495590709', '1');
INSERT INTO `cs_ad_list` VALUES ('8', '招商加盟顶部广告', 'ZSJM', '招商加盟顶部广告(请勿删除)', '1495590773', '1');
INSERT INTO `cs_ad_list` VALUES ('12', '1', '1', '1', '1495613373', '1');

-- ----------------------------
-- Table structure for cs_company
-- ----------------------------
DROP TABLE IF EXISTS `cs_company`;
CREATE TABLE `cs_company` (
  `company_id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(50) DEFAULT '' COMMENT '组织名称',
  `company_type` tinyint(3) DEFAULT NULL COMMENT '组织类型(1总部，2分部)',
  `company_status` tinyint(3) DEFAULT '1' COMMENT '组织状态1正常0冻结',
  `company_num` varchar(11) DEFAULT '0' COMMENT '组织编号',
  `company_time` int(10) DEFAULT '0' COMMENT '组织创建时间',
  PRIMARY KEY (`company_id`),
  UNIQUE KEY `company_name` (`company_name`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COMMENT='组织(分公司)表';

-- ----------------------------
-- Records of cs_company
-- ----------------------------
INSERT INTO `cs_company` VALUES ('1', '总公司', '1', '1', '10', '1496304406');
INSERT INTO `cs_company` VALUES ('18', '常德分公湿', '2', '1', '15', '1497236276');
INSERT INTO `cs_company` VALUES ('20', '株洲分公司', '2', '1', '14', '0');
INSERT INTO `cs_company` VALUES ('22', '郴州分公司', '2', '1', '11', '1493798049');
INSERT INTO `cs_company` VALUES ('27', '长沙分公司', '2', '1', '91', '1496395610');

-- ----------------------------
-- Table structure for cs_content_category
-- ----------------------------
DROP TABLE IF EXISTS `cs_content_category`;
CREATE TABLE `cs_content_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '节点ID',
  `tpcode` char(64) NOT NULL COMMENT '栏目简码',
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '父ID',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '名称',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '标题',
  `tpl` varchar(255) NOT NULL DEFAULT '' COMMENT '模板',
  `col_url` varchar(255) NOT NULL DEFAULT '' COMMENT '模板',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '操作时间',
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '1启用',
  `thumb` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`,`tpcode`)
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=utf8 COMMENT='内容栏目表';

-- ----------------------------
-- Records of cs_content_category
-- ----------------------------
INSERT INTO `cs_content_category` VALUES ('1', 'PPWH', '0', '品牌文化', '', 'content', '/web/about/content', '1495525036', '0', '1', '/upfile/coloum/column1495005993.jpg');
INSERT INTO `cs_content_category` VALUES ('2', 'CPZX', '0', '产品中心', '', 'products_list', '/web/about/products_list', '1495526673', '1', '1', '/upfile/coloum/column1495006060.jpg');
INSERT INTO `cs_content_category` VALUES ('3', 'ZXZX', '0', '资讯中心', '', 'page_content', '/web/about/page_content', '1495872063', '3', '1', '/upfile/coloum/column1495006106.jpg');
INSERT INTO `cs_content_category` VALUES ('4', 'GYLC', '0', '工艺流程', '', 'content', '/web/about/content', '1495872625', '2', '0', '/upfile/coloum/column1495006152.');
INSERT INTO `cs_content_category` VALUES ('5', 'ZSJM', '0', '招商加盟', '', 'content', '/web/about/content', '1500449463', '4', '1', '/upfile/coloum/column1495006182.jpg');
INSERT INTO `cs_content_category` VALUES ('6', 'QYWH', '1', '企业文化', '', 'content', '/web/about/content', '1495708762', '1', '1', '/upfile/coloum/column1495007430.');
INSERT INTO `cs_content_category` VALUES ('7', 'DSZZC', '1', '董事长致辞', '', 'content', '/web/about/content', '1495708875', '2', '1', '/upfile/coloum/column1495007455.');
INSERT INTO `cs_content_category` VALUES ('8', 'FZZL', '1', '发展战略', '', 'content', '/web/about/content', '1495527900', '4', '1', '/upfile/coloum/column1495007479.');
INSERT INTO `cs_content_category` VALUES ('9', 'JYLN', '1', '经营理念', '', 'content', '/web/about/content', '1495527849', '3', '1', '/upfile/coloum/column1495007573.');
INSERT INTO `cs_content_category` VALUES ('10', 'BLWH', '3', '槟榔文化', '', 'page_content', '/web/about/page_content', '1495591143', '0', '1', '/upfile/coloum/column1495011839.');
INSERT INTO `cs_content_category` VALUES ('11', 'JMTJ', '5', '加盟条件', '', 'content', '/web/about/content', '1495538796', '2', '1', '/upfile/coloum/column1495079010.');
INSERT INTO `cs_content_category` VALUES ('12', 'JMLC', '5', '加盟流程', '', 'content', '/web/about/content', '1495535169', '1', '1', '/upfile/coloum/column1495079039.');
INSERT INTO `cs_content_category` VALUES ('13', 'SQJM', '5', '申请', '', 'join_us', '/web/about/join_us', '1495596513', '3', '1', '/upfile/coloum/column1495079076.');
INSERT INTO `cs_content_category` VALUES ('14', 'ZWDBZ', '2', '知味堂（包装）', '', 'products_list', '/web/about/products_list', '1495507167', '3', '1', '/upfile/coloum/column1495091119.');
INSERT INTO `cs_content_category` VALUES ('15', 'ZWTMD', '2', '知味堂（门店）', '', 'content', '/web/about/content', '1495507188', '2', '1', '/upfile/coloum/column1495091154.');
INSERT INTO `cs_content_category` VALUES ('16', 'OTHER', '2', '其他', '', 'content', '/web/about/content', '1495091176', '4', '1', '/upfile/coloum/column1495091176.');
INSERT INTO `cs_content_category` VALUES ('25', 'GYSM', '4', '工艺说明', '', 'content', '/web/about/content', '1495538882', '1', '1', '/upfile/coloum/column1495508371.png');
INSERT INTO `cs_content_category` VALUES ('26', 'HYZX', '3', '行业资讯', '', 'page_content', '/web/about/page_content', '1495591134', '1', '1', '/upfile/coloum/column1495521673.');
INSERT INTO `cs_content_category` VALUES ('27', 'GSDT', '3', '公司动态', '', 'page_content', '/web/about/page_content', '1495591123', '2', '1', '/upfile/coloum/column1495521796.');
INSERT INTO `cs_content_category` VALUES ('37', 'BLZY', '3', '槟榔作用', '', 'content', '/web/about/page_content', '1495591325', '3', '0', '/upfile/coloum/column1495530608.');

-- ----------------------------
-- Table structure for cs_content_content
-- ----------------------------
DROP TABLE IF EXISTS `cs_content_content`;
CREATE TABLE `cs_content_content` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '节点ID',
  `col_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '栏目id',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '标题',
  `subtitle` varchar(255) DEFAULT NULL COMMENT '副标题',
  `contents` text NOT NULL COMMENT '栏目内容',
  `thumb` varchar(255) NOT NULL DEFAULT '' COMMENT '缩略图',
  `filename` varchar(255) NOT NULL DEFAULT '' COMMENT '文件名称',
  `create_time` date NOT NULL DEFAULT '0000-00-00' COMMENT '发布时间',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '状态(1:显示，0：隐藏)',
  `istop` tinyint(3) NOT NULL DEFAULT '0' COMMENT '是否置顶（1：置顶）',
  `description` varchar(255) DEFAULT NULL COMMENT '简介',
  `update_time` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `list` (`col_id`,`status`,`id`),
  KEY `list2` (`status`,`id`)
) ENGINE=MyISAM AUTO_INCREMENT=48 DEFAULT CHARSET=utf8 COMMENT='内容基本表';

-- ----------------------------
-- Records of cs_content_content
-- ----------------------------
INSERT INTO `cs_content_content` VALUES ('1', '6', '企业文化', null, '<p>&nbsp; &nbsp; 知味堂（以下简称“公司”）成立于2077年，隶属于湖南醇品滋味食品集团旗下的槟榔产业品牌，是一家集槟榔产品技术研发和生产加工销售、物流于一体的全面发展企业。公司总部设在长沙，下设湘潭、湘阴两个生产基地和长沙、湘潭、海南三个产品实验基地。&nbsp;</p><p>&nbsp; &nbsp;公司秉承“弘扬湖湘文化，制造正宗上果槟榔”的经营理念和“专注、感恩、匠心、共赢 ”的价值观，坚持品牌创新，注重产品技术研发，大力推动“制度化、标准化、系统化”建设，拥有独立的槟榔产品技术研究所，并建立了设备完善的检测中心，通过引进先进生产设备和技术，不断改进工艺流程，严格控制生产环境和生产过程，保障产品质量安全，逐步完成槟榔产业的现代化管理，成为湖湘正宗上果槟榔引导者。<img src=\"/ueditor/php/upload/image/20170524/1495597078875739.jpg\" title=\"1495597078875739.jpg\" alt=\"a181.jpg\"/></p>', '/upfile/content/content1495522700.jpg', '', '2017-05-17', '1', '1', '', '2017-05-24 06:25:09');
INSERT INTO `cs_content_content` VALUES ('21', '10', '槟榔无毒，蒌叶、烟草', '', '<p>　　在人类的食物链里，属于口腔嗜好这类的超级食品，如烟草口香糖等，大多出欧美，惟槟榔产亚洲；而关于槟榔致癌的传说，则始于现代。</p><p>　　宋代《本草图经》、明代《本草纲目》、现代《中国药典》均将食用了一两千年的槟榔列为无毒。这是有事实根据的。湘潭以食用和制作槟榔闻世，而其自建国至今，口腔癌的发病率低于全国水平、国际水平；自1993年至2002年十年间更是无一例口腔癌病例。原因在哪里呢？</p><p>　　原来湖南的槟榔吃法，一是干制，二是绝不和蒌叶、烟草水同食。蒌叶含黄樟素，与烟草同为强致癌物，印度和东南亚的蒌叶、烟草水与新鲜槟榔混合同食，致湖南的干制槟榔蒙冤，是为外祸。</p>', '/upfile/content/content1495521881.jpg', '', '2017-05-23', '1', '0', '槟榔无毒，蒌叶、烟草有毒', '2017-05-25 11:11:22');
INSERT INTO `cs_content_content` VALUES ('24', '11', '加盟条件', null, '<p>加盟条件加盟条件加盟条件</p><p><img src=\"/ueditor/php/upload/image/20170523/1495524556140206.jpg\" title=\"1495524556140206.jpg\" alt=\"dd.jpg\"/></p>', '/upfile/content/content1495524560.png', '', '2017-05-23', '1', '0', '加盟条件-2', null);
INSERT INTO `cs_content_content` VALUES ('25', '12', '加盟流程', null, '<p>加盟流程加盟流程加盟流程</p><p><img src=\"/ueditor/php/upload/image/20170523/1495524586158572.jpg\" title=\"1495524586158572.jpg\" alt=\"dd.jpg\"/></p>', '/upfile/content/content1495524589.png', '', '2017-05-23', '1', '0', '加盟流程-2', null);
INSERT INTO `cs_content_content` VALUES ('29', '9', '经营理念样式', null, '<p>经营理念样式经营理念样式</p><p>经营理念样式经营理念样式</p><p><img src=\"/ueditor/php/upload/image/20170523/1495529655112411.jpg\" title=\"1495529655112411.jpg\"/></p><p><img src=\"/ueditor/php/upload/image/20170523/1495529658165285.png\" title=\"1495529658165285.png\"/></p><p><br/></p>', '', '', '2017-05-23', '1', '0', '经营理念样式经营理念样式经营理念样式', null);
INSERT INTO `cs_content_content` VALUES ('30', '8', '发展战略样式', null, '<p>发展战略发展战略发展战略</p><p>发展战略发展战略发展战略</p><p><img src=\"/ueditor/php/upload/image/20170523/1495529707968344.png\" title=\"1495529707968344.png\" alt=\"QQ截图20170512164721.png\"/></p>', '', '', '2017-05-23', '1', '0', '发展战略发展战略发展战略', '2017-05-23 04:55:29');
INSERT INTO `cs_content_content` VALUES ('31', '7', '董事长致辞', null, '<p>董事长致辞</p><p><span style=\"color: rgb(60, 60, 60); font-family: &#39;Microsoft Yahei&#39;, 微软雅黑, Arial, &#39;Hiragino Sans GB&#39;, 宋体; font-size: 14px; line-height: 24px; background-color: rgb(255, 255, 255);\">我梦想有一天。。。</span></p><p><span style=\"color: rgb(60, 60, 60); font-family: &#39;Microsoft Yahei&#39;, 微软雅黑, Arial, &#39;Hiragino Sans GB&#39;, 宋体; font-size: 14px; line-height: 24px; background-color: rgb(255, 255, 255);\"><img src=\"/ueditor/php/upload/image/20170523/1495529776582349.jpg\" title=\"1495529776582349.jpg\" alt=\"dd.jpg\"/></span></p>', '', '', '2017-05-23', '1', '0', '董事长致辞', null);
INSERT INTO `cs_content_content` VALUES ('32', '37', '槟榔的功效与作用', null, '<p>&nbsp; &nbsp; &nbsp; 槟榔果实中含有多种人体所需的营养元素和有益物质，如脂肪、槟榔油、生物碱、儿茶素、胆碱等成分。槟榔具有独特的御瘴功能，是历代医家治病的药果，又有&quot;洗瘴丹&quot;的别名。因为瘴疠之症，一般都同饮食不规律、气滞积结有关，而槟榔却能下气、消食、祛痰，所以在药用性能上被人们广泛关注。</p><p>&nbsp; &nbsp; &nbsp;&nbsp;</p><p><br/></p>', '/upfile/content/content1495676808.jpg', '', '2017-05-23', '1', '0', '槟榔的营养价值', '2017-05-25 09:53:16');
INSERT INTO `cs_content_content` VALUES ('34', '37', '槟榔的营养价值', null, '<p>&nbsp; &nbsp;&nbsp;槟榔原果的主要成分为31.1%的酚类、18.7%的多糖、14.0%的脂肪、10.8%的粗纤维、9.9%的水分、3.0%的灰分和0.5%的生物碱。槟榔还含有20多种微量元素，其中11种为人体必需的微量元素。</p><p>&nbsp; &nbsp; &nbsp;槟榔种子含总生物0.3%-0.6%，主要为槟榔碱，并含有少量槟榔次碱、去甲基槟榔碱、异去甲基槟榔次碱、槟榔副碱及高槟榔碱等，均与鞣酸集合存在。还有鞣质、脂肪、甘露醇、半乳糖、蔗糖、儿茶精、表二茶精、无色花青素、槟榔红色素、皂苷及多种原矢车菊素的二聚体、三聚体、四聚体等。</p><p>&nbsp; &nbsp; &nbsp;</p><p><br/></p>', '/upfile/content/content1495538113.png', '', '2017-05-23', '1', '0', '槟榔作用哇', '2017-05-25 10:25:43');
INSERT INTO `cs_content_content` VALUES ('41', '27', '动态变化1', null, '<p>动态变化1动态变化1动态变化1</p>', '', '', '2017-05-24', '1', '0', '动态变化1动态变化1', null);
INSERT INTO `cs_content_content` VALUES ('43', '6', '我是文化11', null, '<p>我是文化我是文化</p><p>什么是文化？</p>', '', '', '2017-05-24', '1', '0', '我是文化我是文化\r\n反反复复', '2017-05-24 03:22:57');
INSERT INTO `cs_content_content` VALUES ('45', '37', '槟榔的药用价值', null, '<p>&nbsp; &nbsp; &nbsp; 种子可入药，有杀虫、破积、下气、行水的功效，是我国名贵的&quot;四大南药&quot;之一。主治虫积，食积、气滞、痢疾、驱蛔、外治青光眼，嚼吃起兴奋作用。药圣李时珍对槟榔的医疗功能概括为&quot;醒能使之醉，醉能使之醒，饥能使之饱。&quot;<br/></p><p>&nbsp; &nbsp; &nbsp; &nbsp;槟榔果实中含有多种人体所需的营养元素和有益物质，如脂肪、槟榔油、生物碱、儿茶素、胆碱等成分。槟榔具有独特的御瘴功能，是历代医家治病的药果，又有&quot;洗瘴丹&quot;的别名。因为瘴疠之症，一般都同饮食不规律、气滞积结有关，而槟榔却能下气、消食、祛痰，所以在药用性能上被人们广泛关注。</p><p>大厦大厦大厦大厦大厦大厦大厦大厦大厦大厦大厦大厦大厦大厦大厦大厦大厦大厦大厦大厦大厦大厦大厦大厦大厦大厦大厦大厦大厦大厦大厦大厦大厦大厦大厦大厦大厦大厦d</p><p>&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</p><p><br/></p>', '/upfile/content/content1495676845.jpg', '', '2017-05-25', '1', '0', '', '2017-05-25 09:54:34');
INSERT INTO `cs_content_content` VALUES ('47', '25', 'tst', 'test', '<p>tes</p>', '/upfile/content/content1495871757.jpg', '', '2017-05-27', '1', '0', 'test', null);

-- ----------------------------
-- Table structure for cs_menu
-- ----------------------------
DROP TABLE IF EXISTS `cs_menu`;
CREATE TABLE `cs_menu` (
  `menu_Id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(20) DEFAULT NULL COMMENT '菜单名字',
  `menu_url` varchar(50) DEFAULT NULL,
  `menu_sort` int(11) DEFAULT '0',
  `menu_status` int(1) DEFAULT '1' COMMENT '菜单状态（0不使用，1使用）',
  `menu_show` int(1) NOT NULL DEFAULT '0' COMMENT '是否显示（0不显示，1显示）',
  `relation_Id` int(11) DEFAULT NULL COMMENT '菜单关联ID',
  `add_time` varchar(11) DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`menu_Id`),
  KEY `relation_Id` (`relation_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=121 DEFAULT CHARSET=utf8 COMMENT='后台菜单表';

-- ----------------------------
-- Records of cs_menu
-- ----------------------------
INSERT INTO `cs_menu` VALUES ('1', '系统管理', '', '0', '1', '1', '0', '1494846157');
INSERT INTO `cs_menu` VALUES ('2', '菜单列表', '/Home/User/menu_list', '1', '1', '1', '1', '1495015736');
INSERT INTO `cs_menu` VALUES ('56', '修改菜单', '/Home/User/menu_set', '0', '1', '1', '2', '1494847466');
INSERT INTO `cs_menu` VALUES ('57', '删除菜单', '/Home/User/menu_del', '0', '1', '1', '2', '1494847489');
INSERT INTO `cs_menu` VALUES ('58', '添加菜单', '/Home/User/menu_add', '0', '1', '1', '2', '1494848888');
INSERT INTO `cs_menu` VALUES ('59', '员工列表', '/Home/User/user_list', '3', '1', '1', '1', '1496902822');
INSERT INTO `cs_menu` VALUES ('60', '角色列表', '/Home/User/roleList', '2', '1', '1', '1', '1494851251');
INSERT INTO `cs_menu` VALUES ('61', '角色添加', '/Home/User/roleAdd', '0', '1', '1', '60', '1494851328');
INSERT INTO `cs_menu` VALUES ('62', '组织列表', '/Home/Company/company_list', '1', '1', '0', '1', '1535943634');
INSERT INTO `cs_menu` VALUES ('63', '栏目管理', '', '10', '1', '0', '0', '1535955202');
INSERT INTO `cs_menu` VALUES ('64', '栏目设置', '/Home/Column/index', '0', '1', '1', '63', '1495525870');
INSERT INTO `cs_menu` VALUES ('65', '栏目内容', '/Home/Column/content_list', '1', '1', '1', '63', '1494987356');
INSERT INTO `cs_menu` VALUES ('66', '广告管理', '', '11', '1', '0', '0', '1535955215');
INSERT INTO `cs_menu` VALUES ('67', '广告位设置', '/Home/Advertise/ad_list', '0', '1', '1', '66', '1494987491');
INSERT INTO `cs_menu` VALUES ('68', '广告内容', '/Home/Advertise/ad_content_list', '1', '1', '1', '66', '1494987551');
INSERT INTO `cs_menu` VALUES ('69', '系统首页', '/Home/User/index', '0', '1', '0', '1', '1495015079');
INSERT INTO `cs_menu` VALUES ('77', '员工列表删除', '/Home/User/user_del', '0', '1', '1', '59', '1496386996');
INSERT INTO `cs_menu` VALUES ('78', '员工列表修改', '/Home/User/user_edit', '0', '1', '1', '59', '1496387045');
INSERT INTO `cs_menu` VALUES ('79', '员工列表添加', '/Home/User/user_add', '0', '1', '1', '59', '1496387650');
INSERT INTO `cs_menu` VALUES ('80', '组织列表删除', '/Home/Company/company_del', '0', '1', '1', '62', '1496387724');
INSERT INTO `cs_menu` VALUES ('81', '编辑组织页面', '/Home/Company/company_update_html', '0', '1', '1', '62', '1496387764');
INSERT INTO `cs_menu` VALUES ('82', '编辑组织动作', '/Home/Company/company_update', '0', '1', '1', '62', '1496388493');
INSERT INTO `cs_menu` VALUES ('83', '添加组织页面', '/Home/Company/company_add_html', '0', '1', '1', '62', '1496388565');
INSERT INTO `cs_menu` VALUES ('84', '添加组织动作', '/Home/Company/company_add', '0', '1', '1', '62', '1496388600');
INSERT INTO `cs_menu` VALUES ('85', '角色编辑', '/Home/User/roleEdit', '0', '1', '1', '60', '1496388808');
INSERT INTO `cs_menu` VALUES ('86', '角色删除', '/Home/User/roleDel', '0', '1', '1', '60', '1496388851');
INSERT INTO `cs_menu` VALUES ('87', '重置密码', '/Home/User/edit_pwd', '0', '1', '1', '59', '1496393396');
INSERT INTO `cs_menu` VALUES ('98', '所属客服', '/Home/User/ajax_kefu', '0', '1', '1', '59', '1497230348');
INSERT INTO `cs_menu` VALUES ('99', '所属区域经理', '/Home/User/ajax_kefu2', '0', '1', '1', '59', '1497230400');
INSERT INTO `cs_menu` VALUES ('105', '问卷调查', '', '1', '1', '0', '0', '1535955161');
INSERT INTO `cs_menu` VALUES ('106', '录入问卷', '/Home/Questionnaire/index', '1', '1', '1', '105', '1535614398');
INSERT INTO `cs_menu` VALUES ('107', '录入问题', '/Home/Question/index', '2', '1', '1', '105', '1535614439');
INSERT INTO `cs_menu` VALUES ('108', '录入选项', '/Home/Option/index', '3', '1', '1', '105', '1535614473');
INSERT INTO `cs_menu` VALUES ('111', '问卷', '', '9', '1', '1', '0', '1535944371');
INSERT INTO `cs_menu` VALUES ('112', '录入问卷', '/Home/Questionsearch/questionnaire', '1', '1', '1', '111', '1536302503');
INSERT INTO `cs_menu` VALUES ('113', '问卷问题', '/Home/Questionsearch/question', '2', '1', '0', '111', '1538182697');
INSERT INTO `cs_menu` VALUES ('114', '问卷选项', '/Home/Questionsearch/option', '3', '1', '0', '111', '1538182776');
INSERT INTO `cs_menu` VALUES ('115', '答题列表', '/Home/Questionsearch/answer', '5', '1', '0', '111', '1539165775');
INSERT INTO `cs_menu` VALUES ('116', '评分', '/Home/Questionsearch/score', '6', '1', '1', '111', '1536627013');
INSERT INTO `cs_menu` VALUES ('117', '问题选项集合', '/Home/Questionsearch/question_option', '8', '1', '0', '111', '1538098225');
INSERT INTO `cs_menu` VALUES ('118', '所有问题选项', '/Home/Questionsearch/all_question_option', '8', '1', '0', '111', '1538098277');
INSERT INTO `cs_menu` VALUES ('119', '整体评分', '/Home/Questionsearch/whole_score', '9', '1', '1', '111', '1539069873');
INSERT INTO `cs_menu` VALUES ('120', '答题详情', '/Home/Answer/index', '8', '1', '0', '111', '1539165131');

-- ----------------------------
-- Table structure for cs_option
-- ----------------------------
DROP TABLE IF EXISTS `cs_option`;
CREATE TABLE `cs_option` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '选项类型，1单选，2多选，3文本',
  `option_type` int(10) DEFAULT NULL,
  `name` varchar(250) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT '选项内容',
  `question_id` int(10) DEFAULT NULL COMMENT '选项所属问题',
  `sort` int(10) DEFAULT NULL COMMENT '排序',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `questions` varchar(40) DEFAULT NULL COMMENT '赋值',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=219 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cs_option
-- ----------------------------
INSERT INTO `cs_option` VALUES ('51', null, 'A.过轻：低于18.5', '43', '1', '1536655047', '0');
INSERT INTO `cs_option` VALUES ('52', null, 'B.正常：18.5-23.9', '43', '2', '1536655063', '0');
INSERT INTO `cs_option` VALUES ('53', null, 'C.过重：24-27.9', '43', '3', '1536655076', '0');
INSERT INTO `cs_option` VALUES ('54', null, 'D.肥胖：28-32', '43', '4', '1536655089', '0');
INSERT INTO `cs_option` VALUES ('55', null, 'A.平产', '49', '1', '1536655238', '0');
INSERT INTO `cs_option` VALUES ('56', null, 'B.难产（产钳助产、剖腹产）', '49', '2', '1536655256', '0');
INSERT INTO `cs_option` VALUES ('57', null, 'C.未生产', '49', '3', '1536655268', '0');
INSERT INTO `cs_option` VALUES ('58', null, 'A.少（少于20ml，一次行经少于10片卫生巾）', '50', '1', '1536656161', '10/14/12/15/14/28');
INSERT INTO `cs_option` VALUES ('59', null, 'B.中等（20～80ml，一次行经约10～26片卫生巾）', '50', '2', '1536656225', '0');
INSERT INTO `cs_option` VALUES ('60', null, 'C.多（多于80ml，一次行经多于26片卫生巾）', '50', '3', '1536656250', '-10/-8/18/23/16/10');
INSERT INTO `cs_option` VALUES ('61', null, 'A.淡红', '51', '1', '1536656291', '20/0/0/0/20/40');
INSERT INTO `cs_option` VALUES ('62', null, 'B.鲜红', '51', '2', '1536656311', '0');
INSERT INTO `cs_option` VALUES ('63', null, 'C.暗红', '51', '3', '1536656330', '14/0/14/24/0/0');
INSERT INTO `cs_option` VALUES ('64', null, 'D.黑褐色', '51', '4', '1536656356', '21/0/14/24/0/0');
INSERT INTO `cs_option` VALUES ('65', null, 'A.有块', '52', '1', '1536656394', '12/0/14/26/0/0');
INSERT INTO `cs_option` VALUES ('66', null, 'B.无块   ', '52', '2', '1536656414', '0');
INSERT INTO `cs_option` VALUES ('67', null, 'A.3天', '53', '1', '1536656451', '-10/0/8/0/8/0');
INSERT INTO `cs_option` VALUES ('68', null, 'B.5天', '53', '2', '1536656470', '-14/0/12/0/12/0');
INSERT INTO `cs_option` VALUES ('69', null, 'C.7天', '53', '3', '1536656493', '-21/0/18/0/18/0');
INSERT INTO `cs_option` VALUES ('70', null, 'E.月经无提前', '53', '5', '1536656531', '0');
INSERT INTO `cs_option` VALUES ('71', null, 'A.3天', '54', '1', '1536656571', '21/11/7/7/0/7');
INSERT INTO `cs_option` VALUES ('72', null, 'B.5天', '54', '2', '1536656588', '30/16/10/10/0/10');
INSERT INTO `cs_option` VALUES ('73', null, 'C.7天', '54', '3', '1536656609', '45/24/15/15/0/15');
INSERT INTO `cs_option` VALUES ('74', null, 'D.月经无退后', '54', '4', '1536656631', '0');
INSERT INTO `cs_option` VALUES ('75', null, 'A.有', '55', '1', '1536656677', '0/0/30/16/0/0');
INSERT INTO `cs_option` VALUES ('76', null, 'B.无', '55', '2', '1536656694', '0');
INSERT INTO `cs_option` VALUES ('77', null, 'A.经前', '56', '1', '1536656731', '0/0/10/10/0/0');
INSERT INTO `cs_option` VALUES ('78', null, 'B.经时', '56', '2', '1536656748', '0');
INSERT INTO `cs_option` VALUES ('79', null, 'C.经后', '56', '3', '1536656770', '0/0/0/0/10/10');
INSERT INTO `cs_option` VALUES ('80', null, 'A.得温则缓', '57', '1', '1536656805', '10/20/0/10/0/0');
INSERT INTO `cs_option` VALUES ('81', null, 'B.寒温无影响', '57', '2', '1536656820', '0');
INSERT INTO `cs_option` VALUES ('82', null, 'C.得冷则缓', '57', '3', '1536656839', '-20/0/0/0/0/0');
INSERT INTO `cs_option` VALUES ('83', null, 'A.喜按小腹', '58', '1', '1536656881', '0/0/0/0/16/11');
INSERT INTO `cs_option` VALUES ('84', null, 'B.按揉无影响', '58', '2', '1536656902', '0');
INSERT INTO `cs_option` VALUES ('85', null, 'C.怕按小腹', '58', '3', '1536656920', '0/0/20/16/0/0');
INSERT INTO `cs_option` VALUES ('86', null, 'A.喜热饮', '59', '1', '1536656958', '10/20/0/10/0/0');
INSERT INTO `cs_option` VALUES ('87', null, 'B.冷热无影响', '59', '2', '1536656975', '0');
INSERT INTO `cs_option` VALUES ('88', null, 'C.喜冷饮', '59', '3', '1536656995', '-20/0/0/0/0/0');
INSERT INTO `cs_option` VALUES ('89', null, 'A.寒冷季节或环境易发', '60', '1', '1536657026', '20/0/0/0/0/0');
INSERT INTO `cs_option` VALUES ('90', null, 'B.季节环境无影响', '60', '2', '1536657040', '0');
INSERT INTO `cs_option` VALUES ('91', null, 'C.炎热季节或环境易发', '60', '3', '1536657061', '-20/0/0/0/0/0');
INSERT INTO `cs_option` VALUES ('92', null, 'A.隐痛', '61', '1', '1536657089', '0/0/0/0/14/10');
INSERT INTO `cs_option` VALUES ('93', null, 'B.冷痛', '61', '2', '1536657106', '40/26/0/0/0/0');
INSERT INTO `cs_option` VALUES ('94', null, 'C.刺痛', '61', '3', '1536657123', '0/0/10/44/0/0');
INSERT INTO `cs_option` VALUES ('95', null, 'D.胀痛', '61', '4', '1536657143', '0/0/44/0/0/0');
INSERT INTO `cs_option` VALUES ('96', null, 'E.绞痛', '61', '5', '1536657162', '0/0/34/12/0/0');
INSERT INTO `cs_option` VALUES ('97', null, 'A.手脚发凉，入冬尤盛', '62', '1', '1536657205', '6/40/0/0/8/0');
INSERT INTO `cs_option` VALUES ('98', null, 'B.手足寒热不明显', '62', '2', '1536657225', '0');
INSERT INTO `cs_option` VALUES ('99', null, 'C.手足发热，夜间明显', '62', '3', '1536657247', '0/-26/0/0/0/0');
INSERT INTO `cs_option` VALUES ('100', null, 'A.容易疲倦犯困', '63', '1', '1536657294', '0/0/0/0/22/0');
INSERT INTO `cs_option` VALUES ('101', null, 'B.无明显疲倦感', '63', '2', '1536657311', '0');
INSERT INTO `cs_option` VALUES ('102', null, 'C.容易亢奋 ', '63', '3', '1536657333', '0/-16/12/0/0/0');
INSERT INTO `cs_option` VALUES ('103', null, 'A.已婚', '47', '1', '1536657640', '0');
INSERT INTO `cs_option` VALUES ('104', null, 'B.未婚', '47', '2', '1536657657', '0');
INSERT INTO `cs_option` VALUES ('105', null, 'A.未生育', '48', '1', '1536657684', '0');
INSERT INTO `cs_option` VALUES ('106', null, 'B.1胎', '48', '2', '1536657701', '0');
INSERT INTO `cs_option` VALUES ('107', null, 'C.2胎或以上', '48', '3', '1536657718', '0');
INSERT INTO `cs_option` VALUES ('108', null, '问卷2第一个选项', '64', '1', '1538031471', '1');
INSERT INTO `cs_option` VALUES ('112', null, 'B.中等（20～80ml，一次行经约10～26片卫生巾）', '96', '2', '1538127361', '-10/-8/18/23/76/1000');
INSERT INTO `cs_option` VALUES ('111', null, 'A.少（少于20ml，一次行经少于10片卫生巾）', '96', '1', '1538127361', '1/2/3/4/5/1000');
INSERT INTO `cs_option` VALUES ('113', null, 'A.少（少于20ml，一次行经少于10片卫生巾）', '99', '1', '1538128086', '10/2');
INSERT INTO `cs_option` VALUES ('114', null, 'B.中等（20～80ml，一次行经约10～26片卫生巾）', '99', '2', '1538128086', null);
INSERT INTO `cs_option` VALUES ('115', null, 'C.多（多于80ml，一次行经多于26片卫生巾）', '99', '3', '1538128086', '2/3');
INSERT INTO `cs_option` VALUES ('116', null, 'A.淡红', '100', '1', '1538128141', '1/2');
INSERT INTO `cs_option` VALUES ('117', null, 'B.鲜红', '100', '2', '1538128141', '1/3');
INSERT INTO `cs_option` VALUES ('118', null, 'C.暗红', '100', '3', '1538128141', '1/4');
INSERT INTO `cs_option` VALUES ('119', null, 'D.黑褐色', '100', '4', '1538128141', '1/5');
INSERT INTO `cs_option` VALUES ('120', null, '1', '101', '1', '1538189337', null);
INSERT INTO `cs_option` VALUES ('121', null, '3', '101', '2', '1538189337', null);
INSERT INTO `cs_option` VALUES ('122', null, '2', '102', '1', '1538189349', null);
INSERT INTO `cs_option` VALUES ('123', null, '4', '102', '2', '1538189349', null);
INSERT INTO `cs_option` VALUES ('124', null, '选择1', '103', '1', '1538204531', null);
INSERT INTO `cs_option` VALUES ('125', null, '选择2', '103', '2', '1538204531', null);
INSERT INTO `cs_option` VALUES ('126', null, '1', '104', '1', '1538204545', null);
INSERT INTO `cs_option` VALUES ('127', null, '2', '104', '2', '1538204545', null);
INSERT INTO `cs_option` VALUES ('143', null, 'D.生育后痛经缓减', '105', '4', '1538280089', null);
INSERT INTO `cs_option` VALUES ('142', null, 'C.生育后痛经无变化', '105', '3', '1538280089', null);
INSERT INTO `cs_option` VALUES ('141', null, 'B.生育后痛经加重', '105', '2', '1538280089', null);
INSERT INTO `cs_option` VALUES ('140', null, 'A.未生育', '105', '1', '1538280089', null);
INSERT INTO `cs_option` VALUES ('144', null, 'A.少（少于20ml，一次行经少于10片卫生巾）', '106', '1', '1538287115', '10/14/12/15/14/28');
INSERT INTO `cs_option` VALUES ('145', null, 'B.中等（20～80ml，一次行经约10～26片卫生巾）', '106', '2', '1538287115', null);
INSERT INTO `cs_option` VALUES ('146', null, 'C.多（多于80ml）', '106', '3', '1538287115', 'C:-10/-8/18/23/16/10');
INSERT INTO `cs_option` VALUES ('147', null, 'A.淡红', '107', '1', '1538287179', '20/0/0/0/20/40');
INSERT INTO `cs_option` VALUES ('148', null, 'B.鲜红', '107', '2', '1538287179', null);
INSERT INTO `cs_option` VALUES ('149', null, 'C.暗红', '107', '3', '1538287179', '14/0/14/24/0/0');
INSERT INTO `cs_option` VALUES ('150', null, 'D.黑褐色', '107', '4', '1538287179', '21/0/21/36/0/0');
INSERT INTO `cs_option` VALUES ('151', null, 'A.有块', '108', '1', '1538287221', 'A:12/0/14/26/0/0');
INSERT INTO `cs_option` VALUES ('152', null, 'B.无块', '108', '2', '1538287221', null);
INSERT INTO `cs_option` VALUES ('153', null, 'A.过轻：低于18.5', '109', '1', '1538288312', null);
INSERT INTO `cs_option` VALUES ('154', null, 'B.正常：18.5-23.9', '109', '2', '1538288312', null);
INSERT INTO `cs_option` VALUES ('155', null, 'C.过重：24-27.9', '109', '3', '1538288312', null);
INSERT INTO `cs_option` VALUES ('156', null, 'D.肥胖：28-32', '109', '4', '1538288312', null);
INSERT INTO `cs_option` VALUES ('157', null, 'E.非常肥胖, 高于32', '109', '5', '1538288312', null);
INSERT INTO `cs_option` VALUES ('158', null, 'A.已婚', '113', '1', '1538288366', null);
INSERT INTO `cs_option` VALUES ('159', null, 'B.未婚 ', '113', '2', '1538288366', null);
INSERT INTO `cs_option` VALUES ('160', null, 'A.未生育', '114', '1', '1538288389', null);
INSERT INTO `cs_option` VALUES ('161', null, 'B.1胎', '114', '2', '1538288389', null);
INSERT INTO `cs_option` VALUES ('162', null, 'C.2胎或以上', '114', '3', '1538288389', null);
INSERT INTO `cs_option` VALUES ('163', null, 'A.未生育', '115', '1', '1538288416', null);
INSERT INTO `cs_option` VALUES ('164', null, 'B.生育后痛经加重', '115', '2', '1538288416', null);
INSERT INTO `cs_option` VALUES ('165', null, 'C.生育后痛经无变化', '115', '3', '1538288416', null);
INSERT INTO `cs_option` VALUES ('166', null, 'D.生育后痛经缓减', '115', '4', '1538288416', null);
INSERT INTO `cs_option` VALUES ('167', null, 'A.平产', '116', '1', '1538288448', null);
INSERT INTO `cs_option` VALUES ('168', null, 'B.难产（产钳助产、剖腹产）', '116', '2', '1538288448', null);
INSERT INTO `cs_option` VALUES ('169', null, 'C.未生产', '116', '3', '1538288448', null);
INSERT INTO `cs_option` VALUES ('170', null, 'A.少（少于20ml，一次行经少于10片卫生巾）', '117', '1', '1538288497', '10/14/12/15/14/28');
INSERT INTO `cs_option` VALUES ('171', null, 'B.中等（20～80ml，一次行经约10～26片卫生巾）', '117', '2', '1538288497', null);
INSERT INTO `cs_option` VALUES ('172', null, 'C.多（多于80ml，一次行经多于26片卫生巾）', '117', '3', '1538288497', '-10/-8/18/23/16/10');
INSERT INTO `cs_option` VALUES ('173', null, 'A.淡红', '118', '1', '1538288553', '20/0/0/0/20/40');
INSERT INTO `cs_option` VALUES ('174', null, 'B.鲜红', '118', '2', '1538288553', null);
INSERT INTO `cs_option` VALUES ('175', null, 'C.暗红', '118', '3', '1538288553', '14/0/14/24/0/0');
INSERT INTO `cs_option` VALUES ('176', null, 'D.黑褐色', '118', '4', '1538288553', '21/0/21/36/0/0');
INSERT INTO `cs_option` VALUES ('177', null, 'A.有块', '119', '1', '1538288582', '12/0/14/26/0/0');
INSERT INTO `cs_option` VALUES ('178', null, 'B.无块', '119', '2', '1538288582', null);
INSERT INTO `cs_option` VALUES ('179', null, 'A.3天', '120', '1', '1538288713', '-10/0/8/0/8/0');
INSERT INTO `cs_option` VALUES ('180', null, 'B.5天', '120', '2', '1538288713', '-14/0/12/0/12/0');
INSERT INTO `cs_option` VALUES ('181', null, 'C.7天 ', '120', '3', '1538288713', '-21/0/18/0/18/0');
INSERT INTO `cs_option` VALUES ('182', null, 'D.先后不定', '120', '4', '1538288713', '0/0/20/12/0/10');
INSERT INTO `cs_option` VALUES ('183', null, 'E.月经无提前', '120', '5', '1538288713', null);
INSERT INTO `cs_option` VALUES ('184', null, 'A.3天', '121', '1', '1538288772', '21/11/7/7/0/7');
INSERT INTO `cs_option` VALUES ('185', null, 'B.5天', '121', '2', '1538288772', '30/16/10/10/0/10');
INSERT INTO `cs_option` VALUES ('186', null, 'C.7天', '121', '3', '1538288772', '45/24/15/15/0/15');
INSERT INTO `cs_option` VALUES ('187', null, 'D.月经无退后', '121', '4', '1538288772', null);
INSERT INTO `cs_option` VALUES ('188', null, 'A.有', '122', '1', '1538288800', '0/0/30/16/0/0');
INSERT INTO `cs_option` VALUES ('189', null, 'B.无', '122', '2', '1538288800', null);
INSERT INTO `cs_option` VALUES ('190', null, 'A.经前', '123', '1', '1538288839', '0/0/10/10/0/0');
INSERT INTO `cs_option` VALUES ('191', null, 'B.经时', '123', '2', '1538288839', null);
INSERT INTO `cs_option` VALUES ('192', null, 'C.经后', '123', '3', '1538288839', '0/0/0/0/10/10');
INSERT INTO `cs_option` VALUES ('193', null, 'A.得温则缓', '124', '1', '1538288886', '10/20/0/10/0/0');
INSERT INTO `cs_option` VALUES ('194', null, 'B.寒温无影响', '124', '2', '1538288886', null);
INSERT INTO `cs_option` VALUES ('195', null, 'C.得冷则缓', '124', '3', '1538288886', '-20/0/0/0/0/0');
INSERT INTO `cs_option` VALUES ('196', null, 'A.喜按小腹', '125', '1', '1538288923', '0/22/0/0/16/11');
INSERT INTO `cs_option` VALUES ('197', null, 'B.按揉无影响', '125', '2', '1538288923', null);
INSERT INTO `cs_option` VALUES ('198', null, 'C.怕按小腹', '125', '3', '1538288923', '0/0/20/16/0/0');
INSERT INTO `cs_option` VALUES ('218', null, 'C.喜冷饮', '126', '3', '1539247927', '-20/0/0/0/0/0');
INSERT INTO `cs_option` VALUES ('217', null, 'B.冷热无影响', '126', '2', '1539247927', null);
INSERT INTO `cs_option` VALUES ('216', null, 'A.喜热饮', '126', '1', '1539247927', '10/20/0/10/0/0');
INSERT INTO `cs_option` VALUES ('202', null, 'A.寒冷季节或环境易发', '127', '1', '1538289059', '20/0/0/0/0/0');
INSERT INTO `cs_option` VALUES ('203', null, 'B.季节环境无影响', '127', '2', '1538289059', null);
INSERT INTO `cs_option` VALUES ('204', null, 'C.炎热季节或环境易发', '127', '3', '1538289059', '-20/0/0/0/0/0');
INSERT INTO `cs_option` VALUES ('205', null, 'A.隐痛', '128', '1', '1538289133', '0/14/0/0/14/10');
INSERT INTO `cs_option` VALUES ('206', null, 'B.冷痛', '128', '2', '1538289133', '40/26/0/0/0/0');
INSERT INTO `cs_option` VALUES ('207', null, 'C.刺痛', '128', '3', '1538289133', '0/0/10/44/0/0');
INSERT INTO `cs_option` VALUES ('208', null, 'D.胀痛', '128', '4', '1538289133', '0/0/44/0/0/0');
INSERT INTO `cs_option` VALUES ('209', null, 'E.绞痛', '128', '5', '1538289133', '0/0/34/12/0/0');
INSERT INTO `cs_option` VALUES ('210', null, 'A.手脚发凉，入冬尤盛', '129', '1', '1538289174', '6/40/0/0/8/0');
INSERT INTO `cs_option` VALUES ('211', null, 'B.手足寒热不明显', '129', '2', '1538289174', null);
INSERT INTO `cs_option` VALUES ('212', null, 'C.手足发热，夜间明显', '129', '3', '1538289174', '0/-26/0/0/0/0');
INSERT INTO `cs_option` VALUES ('213', null, 'A.容易疲倦犯困', '130', '1', '1538289214', '0/0/0/0/22/0');
INSERT INTO `cs_option` VALUES ('214', null, 'B.无明显疲倦感', '130', '2', '1538289214', null);
INSERT INTO `cs_option` VALUES ('215', null, 'C.容易亢奋 ', '130', '3', '1538289214', '0/-16/12/0/0/0');

-- ----------------------------
-- Table structure for cs_property
-- ----------------------------
DROP TABLE IF EXISTS `cs_property`;
CREATE TABLE `cs_property` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `questions` varchar(20) DEFAULT NULL COMMENT '属性',
  `questionnaire_id` int(8) DEFAULT NULL COMMENT '所属问卷id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=77 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cs_property
-- ----------------------------
INSERT INTO `cs_property` VALUES ('25', '寒', '20');
INSERT INTO `cs_property` VALUES ('26', '阳虚', '20');
INSERT INTO `cs_property` VALUES ('27', '气滞', '20');
INSERT INTO `cs_property` VALUES ('28', '血瘀', '20');
INSERT INTO `cs_property` VALUES ('29', '气虚', '20');
INSERT INTO `cs_property` VALUES ('30', '血虚', '20');
INSERT INTO `cs_property` VALUES ('31', '寒', '21');
INSERT INTO `cs_property` VALUES ('32', '阳虚', '21');
INSERT INTO `cs_property` VALUES ('33', '气滞', '21');
INSERT INTO `cs_property` VALUES ('34', '血瘀', '21');
INSERT INTO `cs_property` VALUES ('35', '气虚', '21');
INSERT INTO `cs_property` VALUES ('36', '血虚', '21');
INSERT INTO `cs_property` VALUES ('37', '寒', '22');
INSERT INTO `cs_property` VALUES ('38', '阳虚', '22');
INSERT INTO `cs_property` VALUES ('39', '气滞', '22');
INSERT INTO `cs_property` VALUES ('40', '血瘀', '22');
INSERT INTO `cs_property` VALUES ('41', '气虚', '22');
INSERT INTO `cs_property` VALUES ('42', '血虚', '22');
INSERT INTO `cs_property` VALUES ('43', '寒', '23');
INSERT INTO `cs_property` VALUES ('44', '阳虚', '23');
INSERT INTO `cs_property` VALUES ('45', '气滞', '23');
INSERT INTO `cs_property` VALUES ('46', '血瘀', '23');
INSERT INTO `cs_property` VALUES ('47', '气虚', '23');
INSERT INTO `cs_property` VALUES ('48', '血虚', '23');
INSERT INTO `cs_property` VALUES ('49', '寒', '24');
INSERT INTO `cs_property` VALUES ('50', '寒', '25');
INSERT INTO `cs_property` VALUES ('51', '阳虚', '25');
INSERT INTO `cs_property` VALUES ('52', '气滞', '25');
INSERT INTO `cs_property` VALUES ('53', '血瘀', '25');
INSERT INTO `cs_property` VALUES ('54', '气虚', '25');
INSERT INTO `cs_property` VALUES ('55', '血虚', '25');
INSERT INTO `cs_property` VALUES ('56', '寒', '26');
INSERT INTO `cs_property` VALUES ('57', '阳虚', '26');
INSERT INTO `cs_property` VALUES ('58', '气滞', '26');
INSERT INTO `cs_property` VALUES ('59', '血瘀', '26');
INSERT INTO `cs_property` VALUES ('60', '气虚', '26');
INSERT INTO `cs_property` VALUES ('61', '血虚', '26');
INSERT INTO `cs_property` VALUES ('62', '寒', '27');
INSERT INTO `cs_property` VALUES ('63', '韩6', '28');
INSERT INTO `cs_property` VALUES ('64', '气', '28');
INSERT INTO `cs_property` VALUES ('66', '阳虚', '31');
INSERT INTO `cs_property` VALUES ('65', '寒', '31');
INSERT INTO `cs_property` VALUES ('67', '气滞', '31');
INSERT INTO `cs_property` VALUES ('68', '血瘀', '31');
INSERT INTO `cs_property` VALUES ('69', '气虚', '31');
INSERT INTO `cs_property` VALUES ('70', '血虚', '31');
INSERT INTO `cs_property` VALUES ('71', '寒', '32');
INSERT INTO `cs_property` VALUES ('72', '阳虚', '32');
INSERT INTO `cs_property` VALUES ('73', '气滞', '32');
INSERT INTO `cs_property` VALUES ('74', '血瘀', '32');
INSERT INTO `cs_property` VALUES ('75', '气虚', '32');
INSERT INTO `cs_property` VALUES ('76', '血虚', '32');

-- ----------------------------
-- Table structure for cs_question
-- ----------------------------
DROP TABLE IF EXISTS `cs_question`;
CREATE TABLE `cs_question` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '问题类型',
  `question_type` int(8) DEFAULT NULL COMMENT '问题类型，1是单选，2是多选，3是文本',
  `name` varchar(250) DEFAULT NULL COMMENT '问题内容',
  `questionnaire_id` int(10) DEFAULT NULL COMMENT '问题所属的问卷',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `sort` int(4) DEFAULT NULL COMMENT '排序',
  `options` varchar(800) DEFAULT NULL COMMENT '选项内容',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=133 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cs_question
-- ----------------------------
INSERT INTO `cs_question` VALUES ('127', '1', '痛经是', '32', '1538289059', '19', '{\"0\":{\"type\":\"radio\",\"text\":\"A.寒冷季节或环境易发*20/0/0/0/0/0\"},\"1\":{\"type\":\"radio\",\"text\":\"B.季节环境无影响\"},\"2\":{\"type\":\"radio\",\"text\":\"C.炎热季节或环境易发*-20/0/0/0/0/0\"}}');
INSERT INTO `cs_question` VALUES ('116', '1', '生产', '32', '1538288448', '8', '{\"0\":{\"type\":\"radio\",\"text\":\"A.平产\"},\"1\":{\"type\":\"radio\",\"text\":\"B.难产（产钳助产、剖腹产）\"},\"2\":{\"type\":\"radio\",\"text\":\"C.未生产\"}}');
INSERT INTO `cs_question` VALUES ('131', '3', '您的身高是多少cm', '32', '1539305857', '1', null);
INSERT INTO `cs_question` VALUES ('132', '3', '您的体重是多少kg', '32', '1539305891', '2', null);
INSERT INTO `cs_question` VALUES ('110', '3', '月经初潮（第一次来月经的年龄）', '32', '1538288323', '2', null);
INSERT INTO `cs_question` VALUES ('111', '3', '月经周期（两次月经第1天的间隔天数）', '32', '1538288332', '3', null);
INSERT INTO `cs_question` VALUES ('112', '3', '行经（月经持续天数）', '32', '1538288340', '4', null);
INSERT INTO `cs_question` VALUES ('113', '1', '婚姻', '32', '1538288366', '5', '{\"0\":{\"type\":\"radio\",\"text\":\"A.已婚\"},\"1\":{\"type\":\"radio\",\"text\":\"B.未婚 \"}}');
INSERT INTO `cs_question` VALUES ('114', '1', '生育', '32', '1538288389', '6', '{\"0\":{\"type\":\"radio\",\"text\":\"A.未生育\"},\"1\":{\"type\":\"radio\",\"text\":\"B.1胎\"},\"2\":{\"type\":\"radio\",\"text\":\"C.2胎或以上\"}}');
INSERT INTO `cs_question` VALUES ('115', '1', '生育后痛经情况的变化', '32', '1538288416', '7', '{\"0\":{\"type\":\"radio\",\"text\":\"A.未生育\"},\"1\":{\"type\":\"radio\",\"text\":\"B.生育后痛经加重\"},\"2\":{\"type\":\"radio\",\"text\":\"C.生育后痛经无变化\"},\"3\":{\"type\":\"radio\",\"text\":\"D.生育后痛经缓减\"}}');
INSERT INTO `cs_question` VALUES ('126', '1', '饮食习惯', '32', '1539247927', '18', '{\"0\":{\"type\":\"radio\",\"text\":\"A.喜热饮*10/20/0/10/0/0\"},\"1\":{\"type\":\"radio\",\"text\":\"B.冷热无影响\"},\"2\":{\"type\":\"radio\",\"text\":\"C.喜冷饮*-20/0/0/0/0/0\"}}');
INSERT INTO `cs_question` VALUES ('125', '1', '痛时', '32', '1538288923', '17', '{\"0\":{\"type\":\"radio\",\"text\":\"A.喜按小腹*0/22/0/0/16/11\"},\"1\":{\"type\":\"radio\",\"text\":\"B.按揉无影响\"},\"2\":{\"type\":\"radio\",\"text\":\"C.怕按小腹*0/0/20/16/0/0\"}}');
INSERT INTO `cs_question` VALUES ('122', '1', '经前是否有乳房胀痛', '32', '1538288800', '14', '{\"0\":{\"type\":\"radio\",\"text\":\"A.有*0/0/30/16/0/0\"},\"1\":{\"type\":\"radio\",\"text\":\"B.无\"}}');
INSERT INTO `cs_question` VALUES ('123', '1', '痛经常常发生在', '32', '1538288839', '15', '{\"0\":{\"type\":\"radio\",\"text\":\"A.经前*0/0/10/10/0/0\"},\"1\":{\"type\":\"radio\",\"text\":\"B.经时\"},\"2\":{\"type\":\"radio\",\"text\":\"C.经后*0/0/0/0/10/10\"}}');
INSERT INTO `cs_question` VALUES ('124', '1', '痛时', '32', '1538288886', '16', '{\"0\":{\"type\":\"radio\",\"text\":\"A.得温则缓*10/20/0/10/0/0\"},\"1\":{\"type\":\"radio\",\"text\":\"B.寒温无影响\"},\"2\":{\"type\":\"radio\",\"text\":\"C.得冷则缓*-20/0/0/0/0/0\"}}');
INSERT INTO `cs_question` VALUES ('117', '1', '经量', '32', '1538288497', '9', '{\"0\":{\"type\":\"radio\",\"text\":\"A.少（少于20ml，一次行经少于10片卫生巾）*10/14/12/15/14/28\"},\"1\":{\"type\":\"radio\",\"text\":\"B.中等（20～80ml，一次行经约10～26片卫生巾）\"},\"2\":{\"type\":\"radio\",\"text\":\"C.多（多于80ml，一次行经多于26片卫生巾）*-10/-8/18/23/16/10\"}}');
INSERT INTO `cs_question` VALUES ('118', '1', '经色', '32', '1538288553', '10', '{\"0\":{\"type\":\"radio\",\"text\":\"A.淡红*20/0/0/0/20/40\"},\"1\":{\"type\":\"radio\",\"text\":\"B.鲜红\"},\"2\":{\"type\":\"radio\",\"text\":\"C.暗红*14/0/14/24/0/0\"},\"3\":{\"type\":\"radio\",\"text\":\"D.黑褐色*21/0/21/36/0/0\"}}');
INSERT INTO `cs_question` VALUES ('119', '1', '质地', '32', '1538288582', '11', '{\"0\":{\"type\":\"radio\",\"text\":\"A.有块*12/0/14/26/0/0\"},\"1\":{\"type\":\"radio\",\"text\":\"B.无块\"}}');
INSERT INTO `cs_question` VALUES ('120', '1', '月经提前', '32', '1538288713', '12', '{\"0\":{\"type\":\"radio\",\"text\":\"A.3天*-10/0/8/0/8/0\"},\"1\":{\"type\":\"radio\",\"text\":\"B.5天*-14/0/12/0/12/0\"},\"2\":{\"type\":\"radio\",\"text\":\"C.7天 *-21/0/18/0/18/0\"},\"3\":{\"type\":\"radio\",\"text\":\"D.先后不定*0/0/20/12/0/10\"},\"4\":{\"type\":\"radio\",\"text\":\"E.月经无提前\"}}');
INSERT INTO `cs_question` VALUES ('121', '1', '月经退后', '32', '1538288772', '13', '{\"0\":{\"type\":\"radio\",\"text\":\"A.3天*21/11/7/7/0/7\"},\"1\":{\"type\":\"radio\",\"text\":\"B.5天*30/16/10/10/0/10\"},\"2\":{\"type\":\"radio\",\"text\":\"C.7天*45/24/15/15/0/15\"},\"3\":{\"type\":\"radio\",\"text\":\"D.月经无退后\"}}');
INSERT INTO `cs_question` VALUES ('128', '1', '痛的性质', '32', '1538289133', '20', '{\"0\":{\"type\":\"radio\",\"text\":\"A.隐痛*0/14/0/0/14/10\"},\"1\":{\"type\":\"radio\",\"text\":\"B.冷痛*40/26/0/0/0/0\"},\"2\":{\"type\":\"radio\",\"text\":\"C.刺痛*0/0/10/44/0/0\"},\"3\":{\"type\":\"radio\",\"text\":\"D.胀痛*0/0/44/0/0/0\"},\"4\":{\"type\":\"radio\",\"text\":\"E.绞痛*0/0/34/12/0/0\"}}');
INSERT INTO `cs_question` VALUES ('129', '1', '平素', '32', '1538289174', '21', '{\"0\":{\"type\":\"radio\",\"text\":\"A.手脚发凉，入冬尤盛*6/40/0/0/8/0\"},\"1\":{\"type\":\"radio\",\"text\":\"B.手足寒热不明显\"},\"2\":{\"type\":\"radio\",\"text\":\"C.手足发热，夜间明显*0/-26/0/0/0/0\"}}');
INSERT INTO `cs_question` VALUES ('130', '1', '平素', '32', '1538289214', '22', '{\"0\":{\"type\":\"radio\",\"text\":\"A.容易疲倦犯困*0/0/0/0/22/0\"},\"1\":{\"type\":\"radio\",\"text\":\"B.无明显疲倦感\"},\"2\":{\"type\":\"radio\",\"text\":\"C.容易亢奋 *0/-16/12/0/0/0\"}}');

-- ----------------------------
-- Table structure for cs_questionnaire
-- ----------------------------
DROP TABLE IF EXISTS `cs_questionnaire`;
CREATE TABLE `cs_questionnaire` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `question_id` int(10) DEFAULT NULL COMMENT '问题id',
  `name` varchar(40) DEFAULT NULL COMMENT '调查问卷名称',
  `create_time` int(11) DEFAULT NULL COMMENT '时间',
  `sort` int(4) DEFAULT NULL COMMENT '排序',
  `status` int(3) DEFAULT NULL COMMENT '是否启用',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COMMENT='问卷表';

-- ----------------------------
-- Records of cs_questionnaire
-- ----------------------------
INSERT INTO `cs_questionnaire` VALUES ('32', null, '痛经情况问卷调查表', '1538288257', '1', '1');

-- ----------------------------
-- Table structure for cs_questions_options
-- ----------------------------
DROP TABLE IF EXISTS `cs_questions_options`;
CREATE TABLE `cs_questions_options` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `options` varchar(800) NOT NULL,
  `standard` varchar(100) DEFAULT NULL,
  `score` tinyint(3) unsigned DEFAULT NULL,
  `questionnaire_id` smallint(5) unsigned NOT NULL,
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cs_questions_options
-- ----------------------------
INSERT INTO `cs_questions_options` VALUES ('25', '你是通过何种途径得知凤凰网原创频道的？', '{\"0\":{\"type\":\"checkbox\",\"text\":\"凤凰网首页推荐\"},\"1\":{\"type\":\"checkbox\",\"text\":\"凤凰网读书频道推荐\"},\"2\":{\"type\":\"checkbox\",\"text\":\"听其他人推荐\"},\"3\":{\"type\":\"checkbox\",\"text\":\"在其他地方看到的\"},\"4\":{\"type\":\"checkbox\",\"text\":\"偶然撞进来的\"},\"5\":{\"type\":\"checkbox_othertext\",\"text\":\"\"}}', null, null, '1', '1');
INSERT INTO `cs_questions_options` VALUES ('27', '您是何时知道凤凰网原创频道的？', '{\"0\":{\"type\":\"radio\",\"text\":\"2012年上半年\"},\"1\":{\"type\":\"radio\",\"text\":\"2012年下半年\"},\"2\":{\"type\":\"radio\",\"text\":\"2013年一季度\"},\"3\":{\"type\":\"radio\",\"text\":\"2013年二季度\"},\"4\":{\"type\":\"radio\",\"text\":\"刚刚\"},\"5\":{\"type\":\"radio_othertext\",\"text\":\"\"}}', null, null, '1', '2');
INSERT INTO `cs_questions_options` VALUES ('28', '您一般何时登陆凤凰网原创频道？', '{\"0\":{\"type\":\"radio\",\"text\":\"上午\"},\"1\":{\"type\":\"radio\",\"text\":\"下午\"},\"2\":{\"type\":\"radio\",\"text\":\"晚上\"},\"3\":{\"type\":\"radio\",\"text\":\"工作时间\"},\"4\":{\"type\":\"radio\",\"text\":\"休闲时间\"},\"5\":{\"type\":\"radio\",\"text\":\"说不好\"}}', null, null, '1', '3');
INSERT INTO `cs_questions_options` VALUES ('29', '你对凤凰网原创频道的印象如何？', '{\"0\":{\"type\":\"radio\",\"text\":\"很喜欢\"},\"1\":{\"type\":\"radio\",\"text\":\"还可以\"},\"2\":{\"type\":\"radio\",\"text\":\"一般\"},\"3\":{\"type\":\"radio\",\"text\":\"不喜欢\"},\"4\":{\"type\":\"radio\",\"text\":\"没感觉\"}}', null, null, '1', '4');
INSERT INTO `cs_questions_options` VALUES ('30', '你喜欢原创频道的原因是什么', '{\"0\":{\"type\":\"checkbox\",\"text\":\"作品不错\"},\"1\":{\"type\":\"checkbox\",\"text\":\"网页漂亮\"},\"2\":{\"type\":\"checkbox\",\"text\":\"阅读页面流畅\"},\"3\":{\"type\":\"checkbox\",\"text\":\"与同类网站相比更出色\"},\"4\":{\"type\":\"checkbox_othertext\",\"text\":\"\"}}', null, null, '1', '5');
INSERT INTO `cs_questions_options` VALUES ('31', '您认为凤凰网原创频道应该改善的地方有哪些？', '{\"0\":{\"type\":\"checkbox\",\"text\":\"美化页面\"},\"1\":{\"type\":\"checkbox\",\"text\":\"增加作品数量\"},\"2\":{\"type\":\"checkbox\",\"text\":\"提高作品质量\"},\"3\":{\"type\":\"checkbox\",\"text\":\"优化登陆、订购流程\"},\"4\":{\"type\":\"checkbox\",\"text\":\"多提供知名网络作者作品\"},\"5\":{\"type\":\"checkbox_othertext\",\"text\":\"\"}}', null, null, '1', '6');
INSERT INTO `cs_questions_options` VALUES ('32', '你是否能接受付费阅读网络原创作品？', '{\"0\":{\"type\":\"radio\",\"text\":\"能\"},\"1\":{\"type\":\"radio\",\"text\":\"不能\"},\"2\":{\"type\":\"radio\",\"text\":\"视情况而定\"}}', null, null, '1', '7');
INSERT INTO `cs_questions_options` VALUES ('33', '您在凤凰网原创频道是否付费订购过作品？', '{\"0\":{\"type\":\"radio\",\"text\":\"经常订购\"},\"1\":{\"type\":\"radio\",\"text\":\"少于3次\"},\"2\":{\"type\":\"radio\",\"text\":\"仅1次\"},\"3\":{\"type\":\"radio\",\"text\":\"没有过\"}}', null, null, '1', '8');
INSERT INTO `cs_questions_options` VALUES ('34', '您在凤凰网原创频道读过几部作品？', '{\"0\":{\"type\":\"radio\",\"text\":\"数不清\"},\"1\":{\"type\":\"radio\",\"text\":\"10部以上\"},\"2\":{\"type\":\"radio\",\"text\":\"5-10部\"},\"3\":{\"type\":\"radio\",\"text\":\"2-4部\"},\"4\":{\"type\":\"radio\",\"text\":\"仅1部\"},\"5\":{\"type\":\"radio\",\"text\":\"没读过\"}}', null, null, '1', '9');
INSERT INTO `cs_questions_options` VALUES ('35', '您读得最多的读物哪种类型是？', '{\"0\":{\"type\":\"radio\",\"text\":\"纸质图书\"},\"1\":{\"type\":\"radio\",\"text\":\"网络小说\"},\"2\":{\"type\":\"radio\",\"text\":\"报刊杂志\"},\"3\":{\"type\":\"radio\",\"text\":\"不怎么读\"}}', null, null, '1', '10');
INSERT INTO `cs_questions_options` VALUES ('36', '您一般读何种题材作品？', '{\"0\":{\"type\":\"checkbox\",\"text\":\"青春文学\"},\"1\":{\"type\":\"checkbox\",\"text\":\"婚恋小说\"},\"2\":{\"type\":\"checkbox\",\"text\":\"情色小说\"},\"3\":{\"type\":\"checkbox\",\"text\":\"职场小说\"},\"4\":{\"type\":\"checkbox\",\"text\":\"官场小说\"},\"5\":{\"type\":\"checkbox\",\"text\":\"历史类\"},\"6\":{\"type\":\"checkbox\",\"text\":\"军事类\"},\"7\":{\"type\":\"checkbox\",\"text\":\"玄幻、仙侠类\"},\"8\":{\"type\":\"checkbox\",\"text\":\"悬疑类\"},\"9\":{\"type\":\"checkbox\",\"text\":\"武侠类\"},\"10\":{\"type\":\"checkbox\",\"text\":\"文化类\"},\"11\":{\"type\":\"checkbox\",\"text\":\"生活类\"},\"12\":{\"type\":\"checkbox\",\"text\":\"学术类\"},\"13\":{\"type\":\"checkbox\",\"text\":\"财经类\"},\"14\":{\"type\":\"checkbox\",\"text\":\"都市题材\"},\"15\":{\"type\":\"checkbox\",\"text\":\"乡土题材\"},\"16\":{\"type\":\"checkbox\",\"text\":\"其它\"}}', null, null, '1', '11');
INSERT INTO `cs_questions_options` VALUES ('37', '你对凤凰网原创频道的有什么建议？', '{\"0\":{\"type\":\"text\",\"text\":\"\"}}', null, null, '1', '12');
INSERT INTO `cs_questions_options` VALUES ('38', '具有“含泪的微笑”风格的小说家是？', '{\"0\":{\"type\":\"radio\",\"text\":\"莫泊桑\"},\"1\":{\"type\":\"radio\",\"text\":\"契科夫\"},\"2\":{\"type\":\"radio\",\"text\":\"欧亨利\"},\"3\":{\"type\":\"radio\",\"text\":\"屠格涅夫\"}}', '2', '10', '2', '1');
INSERT INTO `cs_questions_options` VALUES ('39', '唐代“新乐府运动”的倡导者是？', '{\"0\":{\"type\":\"radio\",\"text\":\"岑参\"},\"1\":{\"type\":\"radio\",\"text\":\"白居易\"},\"2\":{\"type\":\"radio\",\"text\":\"韩愈\"},\"3\":{\"type\":\"radio_othertext\",\"text\":\"\"}}', '1', '10', '2', '2');
INSERT INTO `cs_questions_options` VALUES ('40', '主张文章应“惟陈言之务去”的文学家是？', '{\"0\":{\"type\":\"text\",\"text\":\"\"}}', '%u97E9%u6108', '10', '2', '3');
INSERT INTO `cs_questions_options` VALUES ('41', '以下诗篇属于李白创作的有', '{\"0\":{\"type\":\"checkbox\",\"text\":\"静夜思\"},\"1\":{\"type\":\"checkbox\",\"text\":\"茅屋为秋风所破歌\"},\"2\":{\"type\":\"checkbox\",\"text\":\"春晓\"},\"3\":{\"type\":\"checkbox\",\"text\":\"将进酒\"}}', '0,3', '10', '2', '4');
INSERT INTO `cs_questions_options` VALUES ('42', '鲁迅原名什么？', '{\"0\":{\"type\":\"radio\",\"text\":\"周作人\"},\"1\":{\"type\":\"radio\",\"text\":\"周星星\"},\"2\":{\"type\":\"radio\",\"text\":\"周海媚\"},\"3\":{\"type\":\"radio_othertext\",\"text\":\"\"}}', '3:%u5468%u6811%u4EBA', '10', '2', '5');
INSERT INTO `cs_questions_options` VALUES ('43', '下列作品中属于编年体历史著作的是?', '{\"0\":{\"type\":\"radio\",\"text\":\"<国语>\"},\"1\":{\"type\":\"radio\",\"text\":\"<战国策>\"},\"2\":{\"type\":\"radio\",\"text\":\"<左传>\"},\"3\":{\"type\":\"radio\",\"text\":\"<史记>\"}}', '1', '10', '2', '6');
INSERT INTO `cs_questions_options` VALUES ('44', '说明文《沙漠里的奇怪现象》的作者是?', '{\"0\":{\"type\":\"radio\",\"text\":\"朱光潜\"},\"1\":{\"type\":\"radio\",\"text\":\"华罗庚\"},\"2\":{\"type\":\"radio\",\"text\":\"钱钟书\"},\"3\":{\"type\":\"radio_othertext\",\"text\":\"\"}}', '3:%u7AFA%u53EF%u6862', '10', '2', '7');
INSERT INTO `cs_questions_options` VALUES ('45', '由徐志摩发起、组织的文学社团是?', '{\"0\":{\"type\":\"radio\",\"text\":\"新月社\"},\"1\":{\"type\":\"radio\",\"text\":\"创造性\"},\"2\":{\"type\":\"radio\",\"text\":\"语丝社\"},\"3\":{\"type\":\"radio\",\"text\":\"文学研究会\"}}', '0', '10', '2', '8');
INSERT INTO `cs_questions_options` VALUES ('46', '曾经荣获“人民艺术家”称号的作家是', '{\"0\":{\"type\":\"radio\",\"text\":\"茅盾\"},\"1\":{\"type\":\"radio\",\"text\":\"巴金\"},\"2\":{\"type\":\"radio\",\"text\":\"老舍\"},\"3\":{\"type\":\"radio\",\"text\":\"冰心\"}}', '2', '10', '2', '9');
INSERT INTO `cs_questions_options` VALUES ('47', '王实甫《西厢记•长亭送别》的体裁是', '{\"0\":{\"type\":\"radio\",\"text\":\"散曲\"},\"1\":{\"type\":\"radio\",\"text\":\"套数\"},\"2\":{\"type\":\"radio\",\"text\":\"诸宫调\"},\"3\":{\"type\":\"radio\",\"text\":\"杂曲\"}}', '3', '10', '2', '10');
INSERT INTO `cs_questions_options` VALUES ('48', '人民优步是私人车辆，拼车合乘，它有什么好处：', '{\"0\":{\"type\":\"checkbox\",\"text\":\"减少交通拥堵\"},\"1\":{\"type\":\"checkbox\",\"text\":\"减少尾气排放\"},\"2\":{\"type\":\"checkbox\",\"text\":\"提高城市道路承载能力\"},\"3\":{\"type\":\"checkbox\",\"text\":\"社会进步\"}}', '0,1,2', '20', '5', '1');
INSERT INTO `cs_questions_options` VALUES ('49', '个人着装及卫生要求', '{\"0\":{\"type\":\"checkbox\",\"text\":\"衣着得体\"},\"1\":{\"type\":\"checkbox\",\"text\":\"仪容整洁\"},\"2\":{\"type\":\"checkbox\",\"text\":\"较随意，日常生活怎样就怎样\"},\"3\":{\"type\":\"checkbox\",\"text\":\"时髦流行\"}}', '0,1', '20', '5', '2');
INSERT INTO `cs_questions_options` VALUES ('50', '司机端软件账号', '{\"0\":{\"type\":\"radio\",\"text\":\"注册的手机号@c.cc\"},\"1\":{\"type\":\"radio\",\"text\":\"手机号\"},\"2\":{\"type\":\"radio\",\"text\":\"QQ账号\"},\"3\":{\"type\":\"radio\",\"text\":\"qq号\"}}', '1', '20', '5', '3');
INSERT INTO `cs_questions_options` VALUES ('51', '您的初始密码是？', '{\"0\":{\"type\":\"radio\",\"text\":\"在申请表中设置的密码\"},\"1\":{\"type\":\"radio\",\"text\":\"微信号\"},\"2\":{\"type\":\"radio\",\"text\":\"QQ号\"},\"3\":{\"type\":\"radio\",\"text\":\"123456\"}}', '0', '20', '5', '4');
INSERT INTO `cs_questions_options` VALUES ('52', '做人民优步司机的目的', '{\"0\":{\"type\":\"checkbox\",\"text\":\"顺路搭车，帮助别人\"},\"1\":{\"type\":\"checkbox\",\"text\":\"认识朋友，创建社区\"},\"2\":{\"type\":\"checkbox\",\"text\":\"分担费用，覆盖成本\"},\"3\":{\"type\":\"checkbox\",\"text\":\"道德高尚\"}}', '0,2', '20', '5', '5');
INSERT INTO `cs_questions_options` VALUES ('53', '小朋友们 过马路 应该是怎 样的 顺序 呢？', '{\"0\":{\"type\":\"radio\",\"text\":\"看→停→过\"},\"1\":{\"type\":\"radio\",\"text\":\"停→看→过\"},\"2\":{\"type\":\"radio\",\"text\":\"过→看→停\"},\"3\":{\"type\":\"radio\",\"text\":\"停→过→看\"}}', '1', '20', '6', '1');
INSERT INTO `cs_questions_options` VALUES ('54', '人行道就是斑马线吗？', '{\"0\":{\"type\":\"radio\",\"text\":\"是\"},\"1\":{\"type\":\"radio\",\"text\":\"不是\"},\"2\":{\"type\":\"radio\",\"text\":\"不清楚\"},\"3\":{\"type\":\"radio\",\"text\":\"你说呢\"}}', '1', '20', '6', '2');
INSERT INTO `cs_questions_options` VALUES ('55', '过马路时怎样看车辆？', '{\"0\":{\"type\":\"radio\",\"text\":\"看左面\"},\"1\":{\"type\":\"radio\",\"text\":\"看前面\"},\"2\":{\"type\":\"radio\",\"text\":\"看右面\"},\"3\":{\"type\":\"radio\",\"text\":\"左看,右看, 再左看\"}}', '3', '20', '6', '3');
INSERT INTO `cs_questions_options` VALUES ('56', '儿童的事业范围有多大', '{\"0\":{\"type\":\"radio\",\"text\":\"120度\"},\"1\":{\"type\":\"radio\",\"text\":\"不超过90度\"},\"2\":{\"type\":\"radio\",\"text\":\"150度\"},\"3\":{\"type\":\"radio\",\"text\":\"120度~150度\"}}', '3', '20', '6', '4');
INSERT INTO `cs_questions_options` VALUES ('57', '哪个年龄段的人必须遵守 &quot;交通安全阀&quot;', '{\"0\":{\"type\":\"radio\",\"text\":\"10岁以下的儿童\"},\"1\":{\"type\":\"radio\",\"text\":\"89岁以上的老人\"},\"2\":{\"type\":\"radio\",\"text\":\"10~80岁之间的人\"},\"3\":{\"type\":\"radio\",\"text\":\"所有的人\"}}', '2', '20', '6', '5');
INSERT INTO `cs_questions_options` VALUES ('58', '选出不同类的一项', '{\"0\":{\"type\":\"radio\",\"text\":\"蛇\"},\"1\":{\"type\":\"radio\",\"text\":\"树\"},\"2\":{\"type\":\"radio\",\"text\":\"老虎\"},\"3\":{\"type\":\"radio\",\"text\":\"河马\"}}', '1', '20', '7', '1');
INSERT INTO `cs_questions_options` VALUES ('59', '在下列分数中，选出不同类的一项：', '{\"0\":{\"type\":\"radio\",\"text\":\"3/5\"},\"1\":{\"type\":\"radio\",\"text\":\"3/7\"},\"2\":{\"type\":\"radio\",\"text\":\"3/9\"},\"3\":{\"type\":\"radio\",\"text\":\"1/5\"}}', '2', '20', '7', '2');
INSERT INTO `cs_questions_options` VALUES ('60', '男孩对男子，正如女孩对', '{\"0\":{\"type\":\"radio\",\"text\":\"青年\"},\"1\":{\"type\":\"radio\",\"text\":\"孩子\"},\"2\":{\"type\":\"radio\",\"text\":\"夫人\"},\"3\":{\"type\":\"radio\",\"text\":\"姑娘\"},\"4\":{\"type\":\"radio\",\"text\":\"妇女\"}}', '2', '20', '7', '3');
INSERT INTO `cs_questions_options` VALUES ('61', '如果笔相对于写字，那么书相对于', '{\"0\":{\"type\":\"radio\",\"text\":\"娱乐\"},\"1\":{\"type\":\"radio\",\"text\":\"阅读\"},\"2\":{\"type\":\"radio\",\"text\":\"学文化\"},\"3\":{\"type\":\"radio\",\"text\":\"解除疲劳\"}}', '1', '20', '7', '4');
INSERT INTO `cs_questions_options` VALUES ('62', '马之于马厩，正如人之于', '{\"0\":{\"type\":\"radio\",\"text\":\"牛棚\"},\"1\":{\"type\":\"radio\",\"text\":\"马车\"},\"2\":{\"type\":\"radio\",\"text\":\"房屋\"},\"3\":{\"type\":\"radio\",\"text\":\"农场\"},\"4\":{\"type\":\"radio\",\"text\":\"楼房\"}}', '2', '20', '7', '5');
INSERT INTO `cs_questions_options` VALUES ('63', '心中女神', '{\"0\":{\"type\":\"radio\",\"text\":\"斤斤计较\"},\"1\":{\"type\":\"radio\",\"text\":\"哈哈哈哈\"},\"2\":{\"type\":\"radio\",\"text\":\"斤斤计较斤斤计较\"}}', null, null, '10', '1');
INSERT INTO `cs_questions_options` VALUES ('64', 'overview feeling', '{\"0\":{\"type\":\"checkbox\",\"text\":\"bad\"},\"1\":{\"type\":\"checkbox\",\"text\":\"normal\"},\"2\":{\"type\":\"checkbox\",\"text\":\"good\"}}', null, null, '11', '1');
INSERT INTO `cs_questions_options` VALUES ('65', 'infrastructure', '{\"0\":{\"type\":\"radio\",\"text\":\"good\"},\"1\":{\"type\":\"radio\",\"text\":\"bad\"}}', null, null, '11', '2');
INSERT INTO `cs_questions_options` VALUES ('66', '阿萨阿', '{\"0\":{\"type\":\"radio\",\"text\":\"斯蒂芬斯蒂芬森的\"},\"1\":{\"type\":\"radio\",\"text\":\"斯蒂芬斯蒂芬斯蒂芬\"},\"2\":{\"type\":\"radio\",\"text\":\"斯蒂芬斯蒂芬斯蒂芬森斯蒂芬\"},\"3\":{\"type\":\"radio_othertext\",\"text\":\"\"}}', null, null, '13', '1');
INSERT INTO `cs_questions_options` VALUES ('67', '去委屈委屈委屈委屈我', '{\"0\":{\"type\":\"checkbox\",\"text\":\"去委屈委屈委屈为\"},\"1\":{\"type\":\"checkbox\",\"text\":\"去委屈委屈委屈为请问\"},\"2\":{\"type\":\"checkbox\",\"text\":\"去委屈委屈委屈亲亲亲亲亲亲\"}}', null, null, '13', '2');
INSERT INTO `cs_questions_options` VALUES ('68', '和法国和法国恢复', '{\"0\":{\"type\":\"text\",\"text\":\"\"}}', null, null, '13', '3');
INSERT INTO `cs_questions_options` VALUES ('69', '1000', '{\"0\":{\"type\":\"radio\",\"text\":\"10000\"},\"1\":{\"type\":\"radio\",\"text\":\"20000\"},\"2\":{\"type\":\"radio_othertext\",\"text\":\"\"}}', null, null, '16', '1');
INSERT INTO `cs_questions_options` VALUES ('70', '啊', '{\"0\":{\"type\":\"radio\",\"text\":\"啊啊1\"},\"1\":{\"type\":\"radio\",\"text\":\"啊啊2\"},\"2\":{\"type\":\"radio\",\"text\":\"啊啊3\"},\"3\":{\"type\":\"radio\",\"text\":\"啊啊4\"}}', null, null, '17', '1');
INSERT INTO `cs_questions_options` VALUES ('71', '1.请选择以下哪个是错的？', '{\"0\":{\"type\":\"radio\",\"text\":\"A       3\"},\"1\":{\"type\":\"radio\",\"text\":\"B      4\"},\"2\":{\"type\":\"radio\",\"text\":\"C     5\"},\"3\":{\"type\":\"radio\",\"text\":\"D    6\"}}', '1', '2', '19', '1');
INSERT INTO `cs_questions_options` VALUES ('72', '2.请选择正确的？', '{\"0\":{\"type\":\"radio\",\"text\":\"A     DLFJLDFKFLDLDFDF\"},\"1\":{\"type\":\"radio\",\"text\":\"B     EEFDFDF\"},\"2\":{\"type\":\"radio\",\"text\":\"C    DFDFD\"},\"3\":{\"type\":\"radio\",\"text\":\"D    DD\"}}', '0', '2', '19', '2');
INSERT INTO `cs_questions_options` VALUES ('73', '我的第一个问题', '{\"0\":{\"type\":\"radio\",\"text\":\"我的第一个问题1选项\"},\"1\":{\"type\":\"radio\",\"text\":\"我的第一个问题2选项\"},\"2\":{\"type\":\"radio\",\"text\":\"我的第一个问题3选项\"}}', null, null, '20', '1');
INSERT INTO `cs_questions_options` VALUES ('74', '第二个问题', '{\"0\":{\"type\":\"radio\",\"text\":\"第二个问题1选项\"},\"1\":{\"type\":\"radio\",\"text\":\"第二个问题2选项\"}}', null, null, '20', '2');
INSERT INTO `cs_questions_options` VALUES ('75', '第三个问题', '{\"0\":{\"type\":\"text\",\"text\":\"\"}}', null, null, '20', '3');
INSERT INTO `cs_questions_options` VALUES ('76', '第一个问题', '{\"0\":{\"type\":\"radio\",\"text\":\"1\"},\"1\":{\"type\":\"radio\",\"text\":\"2\"}}', null, null, '21', '1');

-- ----------------------------
-- Table structure for cs_que_user
-- ----------------------------
DROP TABLE IF EXISTS `cs_que_user`;
CREATE TABLE `cs_que_user` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(40) DEFAULT NULL COMMENT '用户名字',
  `phone` bigint(20) DEFAULT NULL COMMENT '手机号码',
  `sex` int(8) DEFAULT NULL COMMENT '性别，1男，2女',
  `age` int(8) DEFAULT NULL COMMENT '年龄',
  `address` varchar(250) DEFAULT NULL COMMENT '地址',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=57 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cs_que_user
-- ----------------------------
INSERT INTO `cs_que_user` VALUES ('42', '我的手机', '13135318241', null, '11', null, '1539158644');
INSERT INTO `cs_que_user` VALUES ('43', '测试号码', '13135318241', null, '22', null, '1539158902');
INSERT INTO `cs_que_user` VALUES ('44', '第二次测试手机号码', '13135318241', null, '32', null, '1539159082');
INSERT INTO `cs_que_user` VALUES ('45', '一万', '13755032537', null, '10000', null, '1539238713');
INSERT INTO `cs_que_user` VALUES ('46', '二万', '13755032537', null, '222', null, '1539239497');
INSERT INTO `cs_que_user` VALUES ('47', '5553', '13755032537', null, '333', null, '1539239628');
INSERT INTO `cs_que_user` VALUES ('48', 'ggg', '13755032537', null, '33', null, '1539240501');
INSERT INTO `cs_que_user` VALUES ('49', '2千已经好了', '13135318241', null, '22', null, '1539244971');
INSERT INTO `cs_que_user` VALUES ('50', '4444', '444444444444', null, '44', null, '1539310786');
INSERT INTO `cs_que_user` VALUES ('51', '5555', '55555555555', null, '55', null, '1539311467');
INSERT INTO `cs_que_user` VALUES ('52', '6666666', '6666666666', null, '66', null, '1539312249');
INSERT INTO `cs_que_user` VALUES ('53', '777', '777777', null, '77', null, '1539315607');
INSERT INTO `cs_que_user` VALUES ('54', '88', '888888', null, '88', null, '1539316022');
INSERT INTO `cs_que_user` VALUES ('55', '99999', '999999', null, '999', null, '1539316588');
INSERT INTO `cs_que_user` VALUES ('56', '111', '1111', null, '111', null, '1539316973');

-- ----------------------------
-- Table structure for cs_role
-- ----------------------------
DROP TABLE IF EXISTS `cs_role`;
CREATE TABLE `cs_role` (
  `role_Id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(20) DEFAULT NULL COMMENT '角色名',
  `role_identity` tinyint(3) DEFAULT NULL COMMENT '角色区分(0总部角色，1分部角色)',
  `role_position` tinyint(3) DEFAULT '5' COMMENT '0系统管理员，1区域经理，2客服，3业务员，4财务',
  `role_type` int(1) DEFAULT '1' COMMENT '角色类型(0系统角色,1自定义角色)',
  `role_status` int(1) DEFAULT '1' COMMENT '角色状态（0不使用，1使用）',
  `role_num` tinyint(3) NOT NULL DEFAULT '0' COMMENT '角色编号',
  `add_time` varchar(11) DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`role_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='角色表';

-- ----------------------------
-- Records of cs_role
-- ----------------------------
INSERT INTO `cs_role` VALUES ('1', '超级管理员', '0', '0', '0', '1', '0', '1539165170');
INSERT INTO `cs_role` VALUES ('2', '总部管理员', '0', '0', '0', '1', '0', '1499747950');
INSERT INTO `cs_role` VALUES ('8', '分公司管理员', '1', '0', '0', '1', '0', '1497249100');
INSERT INTO `cs_role` VALUES ('9', '客服', '1', '2', '1', '1', '20', '1497323327');

-- ----------------------------
-- Table structure for cs_rolemenu
-- ----------------------------
DROP TABLE IF EXISTS `cs_rolemenu`;
CREATE TABLE `cs_rolemenu` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `role_Id` varchar(20) DEFAULT NULL,
  `menu_Id` varchar(20) DEFAULT NULL,
  `addtime` varchar(20) DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`Id`),
  KEY `menu_Id` (`menu_Id`),
  KEY `role_Id` (`role_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=4986 DEFAULT CHARSET=utf8 COMMENT='后台角色菜单表';

-- ----------------------------
-- Records of cs_rolemenu
-- ----------------------------
INSERT INTO `cs_rolemenu` VALUES ('56', '5', '1', '1490264531');
INSERT INTO `cs_rolemenu` VALUES ('57', '5', '2', '1490264531');
INSERT INTO `cs_rolemenu` VALUES ('58', '5', '5', '1490264531');
INSERT INTO `cs_rolemenu` VALUES ('59', '5', '6', '1490264531');
INSERT INTO `cs_rolemenu` VALUES ('60', '5', '8', '1490264531');
INSERT INTO `cs_rolemenu` VALUES ('63', '6', '1', '1490265235');
INSERT INTO `cs_rolemenu` VALUES ('64', '6', '2', '1490265235');
INSERT INTO `cs_rolemenu` VALUES ('3499', '8', '1', '1497249100');
INSERT INTO `cs_rolemenu` VALUES ('3500', '8', '69', '1497249100');
INSERT INTO `cs_rolemenu` VALUES ('3501', '8', '62', '1497249100');
INSERT INTO `cs_rolemenu` VALUES ('3502', '8', '60', '1497249100');
INSERT INTO `cs_rolemenu` VALUES ('3503', '8', '59', '1497249100');
INSERT INTO `cs_rolemenu` VALUES ('3504', '8', '77', '1497249100');
INSERT INTO `cs_rolemenu` VALUES ('3505', '8', '78', '1497249100');
INSERT INTO `cs_rolemenu` VALUES ('3506', '8', '79', '1497249100');
INSERT INTO `cs_rolemenu` VALUES ('3507', '8', '87', '1497249100');
INSERT INTO `cs_rolemenu` VALUES ('3508', '8', '98', '1497249100');
INSERT INTO `cs_rolemenu` VALUES ('3509', '8', '99', '1497249100');
INSERT INTO `cs_rolemenu` VALUES ('3510', '8', '21', '1497249100');
INSERT INTO `cs_rolemenu` VALUES ('3511', '8', '26', '1497249100');
INSERT INTO `cs_rolemenu` VALUES ('3512', '8', '24', '1497249100');
INSERT INTO `cs_rolemenu` VALUES ('3513', '8', '25', '1497249100');
INSERT INTO `cs_rolemenu` VALUES ('3514', '8', '75', '1497249100');
INSERT INTO `cs_rolemenu` VALUES ('3515', '8', '76', '1497249100');
INSERT INTO `cs_rolemenu` VALUES ('3516', '8', '90', '1497249100');
INSERT INTO `cs_rolemenu` VALUES ('3517', '8', '100', '1497249100');
INSERT INTO `cs_rolemenu` VALUES ('3518', '8', '51', '1497249100');
INSERT INTO `cs_rolemenu` VALUES ('3625', '20', '1', '1497249154');
INSERT INTO `cs_rolemenu` VALUES ('3626', '20', '69', '1497249154');
INSERT INTO `cs_rolemenu` VALUES ('3627', '20', '2', '1497249154');
INSERT INTO `cs_rolemenu` VALUES ('3628', '20', '56', '1497249154');
INSERT INTO `cs_rolemenu` VALUES ('3629', '20', '57', '1497249154');
INSERT INTO `cs_rolemenu` VALUES ('3630', '20', '58', '1497249154');
INSERT INTO `cs_rolemenu` VALUES ('3631', '20', '62', '1497249154');
INSERT INTO `cs_rolemenu` VALUES ('3632', '20', '80', '1497249154');
INSERT INTO `cs_rolemenu` VALUES ('3633', '20', '81', '1497249154');
INSERT INTO `cs_rolemenu` VALUES ('3634', '20', '82', '1497249154');
INSERT INTO `cs_rolemenu` VALUES ('3635', '20', '83', '1497249154');
INSERT INTO `cs_rolemenu` VALUES ('3636', '20', '84', '1497249154');
INSERT INTO `cs_rolemenu` VALUES ('3637', '20', '60', '1497249154');
INSERT INTO `cs_rolemenu` VALUES ('3638', '20', '61', '1497249154');
INSERT INTO `cs_rolemenu` VALUES ('3639', '20', '85', '1497249154');
INSERT INTO `cs_rolemenu` VALUES ('3640', '20', '86', '1497249154');
INSERT INTO `cs_rolemenu` VALUES ('3641', '20', '59', '1497249154');
INSERT INTO `cs_rolemenu` VALUES ('3642', '20', '77', '1497249154');
INSERT INTO `cs_rolemenu` VALUES ('3643', '20', '78', '1497249154');
INSERT INTO `cs_rolemenu` VALUES ('3644', '20', '79', '1497249154');
INSERT INTO `cs_rolemenu` VALUES ('3645', '20', '87', '1497249154');
INSERT INTO `cs_rolemenu` VALUES ('3646', '20', '98', '1497249154');
INSERT INTO `cs_rolemenu` VALUES ('3647', '20', '99', '1497249154');
INSERT INTO `cs_rolemenu` VALUES ('3648', '20', '21', '1497249154');
INSERT INTO `cs_rolemenu` VALUES ('3649', '20', '26', '1497249154');
INSERT INTO `cs_rolemenu` VALUES ('3650', '20', '24', '1497249154');
INSERT INTO `cs_rolemenu` VALUES ('3651', '20', '25', '1497249154');
INSERT INTO `cs_rolemenu` VALUES ('3652', '20', '75', '1497249154');
INSERT INTO `cs_rolemenu` VALUES ('3653', '20', '76', '1497249154');
INSERT INTO `cs_rolemenu` VALUES ('3654', '20', '90', '1497249154');
INSERT INTO `cs_rolemenu` VALUES ('3655', '20', '100', '1497249154');
INSERT INTO `cs_rolemenu` VALUES ('3656', '20', '51', '1497249154');
INSERT INTO `cs_rolemenu` VALUES ('3657', '20', '89', '1497249154');
INSERT INTO `cs_rolemenu` VALUES ('3658', '20', '52', '1497249154');
INSERT INTO `cs_rolemenu` VALUES ('3659', '20', '88', '1497249154');
INSERT INTO `cs_rolemenu` VALUES ('3660', '20', '27', '1497249154');
INSERT INTO `cs_rolemenu` VALUES ('3661', '20', '31', '1497249154');
INSERT INTO `cs_rolemenu` VALUES ('3662', '20', '29', '1497249154');
INSERT INTO `cs_rolemenu` VALUES ('3663', '20', '38', '1497249154');
INSERT INTO `cs_rolemenu` VALUES ('3664', '20', '36', '1497249154');
INSERT INTO `cs_rolemenu` VALUES ('3665', '20', '37', '1497249154');
INSERT INTO `cs_rolemenu` VALUES ('3666', '20', '41', '1497249154');
INSERT INTO `cs_rolemenu` VALUES ('3667', '20', '42', '1497249154');
INSERT INTO `cs_rolemenu` VALUES ('3668', '20', '43', '1497249154');
INSERT INTO `cs_rolemenu` VALUES ('3669', '20', '44', '1497249154');
INSERT INTO `cs_rolemenu` VALUES ('3670', '20', '45', '1497249154');
INSERT INTO `cs_rolemenu` VALUES ('3671', '20', '46', '1497249154');
INSERT INTO `cs_rolemenu` VALUES ('3672', '20', '47', '1497249154');
INSERT INTO `cs_rolemenu` VALUES ('3673', '20', '48', '1497249154');
INSERT INTO `cs_rolemenu` VALUES ('3674', '20', '49', '1497249154');
INSERT INTO `cs_rolemenu` VALUES ('3675', '20', '91', '1497249154');
INSERT INTO `cs_rolemenu` VALUES ('3676', '20', '50', '1497249154');
INSERT INTO `cs_rolemenu` VALUES ('3677', '20', '92', '1497249154');
INSERT INTO `cs_rolemenu` VALUES ('3678', '20', '63', '1497249154');
INSERT INTO `cs_rolemenu` VALUES ('3679', '20', '64', '1497249154');
INSERT INTO `cs_rolemenu` VALUES ('3680', '20', '65', '1497249154');
INSERT INTO `cs_rolemenu` VALUES ('3681', '20', '66', '1497249154');
INSERT INTO `cs_rolemenu` VALUES ('3682', '20', '67', '1497249154');
INSERT INTO `cs_rolemenu` VALUES ('3683', '20', '68', '1497249154');
INSERT INTO `cs_rolemenu` VALUES ('3684', '20', '70', '1497249154');
INSERT INTO `cs_rolemenu` VALUES ('3685', '20', '71', '1497249154');
INSERT INTO `cs_rolemenu` VALUES ('3686', '20', '72', '1497249154');
INSERT INTO `cs_rolemenu` VALUES ('3687', '20', '73', '1497249154');
INSERT INTO `cs_rolemenu` VALUES ('3688', '20', '74', '1497249154');
INSERT INTO `cs_rolemenu` VALUES ('3689', '17', '1', '1497264791');
INSERT INTO `cs_rolemenu` VALUES ('3690', '17', '69', '1497264791');
INSERT INTO `cs_rolemenu` VALUES ('3691', '17', '2', '1497264791');
INSERT INTO `cs_rolemenu` VALUES ('3692', '17', '56', '1497264791');
INSERT INTO `cs_rolemenu` VALUES ('3693', '17', '57', '1497264791');
INSERT INTO `cs_rolemenu` VALUES ('3694', '17', '58', '1497264791');
INSERT INTO `cs_rolemenu` VALUES ('3695', '17', '62', '1497264791');
INSERT INTO `cs_rolemenu` VALUES ('3696', '17', '80', '1497264791');
INSERT INTO `cs_rolemenu` VALUES ('3697', '17', '81', '1497264791');
INSERT INTO `cs_rolemenu` VALUES ('3698', '17', '82', '1497264791');
INSERT INTO `cs_rolemenu` VALUES ('3699', '17', '83', '1497264791');
INSERT INTO `cs_rolemenu` VALUES ('3700', '17', '84', '1497264791');
INSERT INTO `cs_rolemenu` VALUES ('3701', '17', '60', '1497264791');
INSERT INTO `cs_rolemenu` VALUES ('3702', '17', '61', '1497264791');
INSERT INTO `cs_rolemenu` VALUES ('3703', '17', '85', '1497264791');
INSERT INTO `cs_rolemenu` VALUES ('3704', '17', '86', '1497264791');
INSERT INTO `cs_rolemenu` VALUES ('3705', '17', '59', '1497264791');
INSERT INTO `cs_rolemenu` VALUES ('3706', '17', '77', '1497264791');
INSERT INTO `cs_rolemenu` VALUES ('3707', '17', '78', '1497264791');
INSERT INTO `cs_rolemenu` VALUES ('3708', '17', '79', '1497264791');
INSERT INTO `cs_rolemenu` VALUES ('3709', '17', '87', '1497264791');
INSERT INTO `cs_rolemenu` VALUES ('3710', '17', '98', '1497264791');
INSERT INTO `cs_rolemenu` VALUES ('3711', '17', '99', '1497264791');
INSERT INTO `cs_rolemenu` VALUES ('3712', '17', '21', '1497264791');
INSERT INTO `cs_rolemenu` VALUES ('3713', '17', '26', '1497264791');
INSERT INTO `cs_rolemenu` VALUES ('3714', '17', '24', '1497264791');
INSERT INTO `cs_rolemenu` VALUES ('3715', '17', '25', '1497264791');
INSERT INTO `cs_rolemenu` VALUES ('3716', '17', '75', '1497264791');
INSERT INTO `cs_rolemenu` VALUES ('3717', '17', '76', '1497264791');
INSERT INTO `cs_rolemenu` VALUES ('3718', '17', '90', '1497264791');
INSERT INTO `cs_rolemenu` VALUES ('3719', '17', '100', '1497264791');
INSERT INTO `cs_rolemenu` VALUES ('3720', '17', '51', '1497264791');
INSERT INTO `cs_rolemenu` VALUES ('3721', '17', '89', '1497264791');
INSERT INTO `cs_rolemenu` VALUES ('3722', '17', '52', '1497264791');
INSERT INTO `cs_rolemenu` VALUES ('3723', '17', '88', '1497264791');
INSERT INTO `cs_rolemenu` VALUES ('3724', '17', '27', '1497264791');
INSERT INTO `cs_rolemenu` VALUES ('3725', '17', '31', '1497264791');
INSERT INTO `cs_rolemenu` VALUES ('3726', '17', '29', '1497264791');
INSERT INTO `cs_rolemenu` VALUES ('3727', '17', '38', '1497264791');
INSERT INTO `cs_rolemenu` VALUES ('3728', '17', '36', '1497264791');
INSERT INTO `cs_rolemenu` VALUES ('3729', '17', '37', '1497264791');
INSERT INTO `cs_rolemenu` VALUES ('3730', '17', '41', '1497264791');
INSERT INTO `cs_rolemenu` VALUES ('3731', '17', '42', '1497264791');
INSERT INTO `cs_rolemenu` VALUES ('3732', '17', '43', '1497264791');
INSERT INTO `cs_rolemenu` VALUES ('3733', '17', '44', '1497264791');
INSERT INTO `cs_rolemenu` VALUES ('3734', '17', '45', '1497264791');
INSERT INTO `cs_rolemenu` VALUES ('3735', '17', '46', '1497264791');
INSERT INTO `cs_rolemenu` VALUES ('3736', '17', '47', '1497264791');
INSERT INTO `cs_rolemenu` VALUES ('3737', '17', '48', '1497264791');
INSERT INTO `cs_rolemenu` VALUES ('3738', '17', '49', '1497264791');
INSERT INTO `cs_rolemenu` VALUES ('3739', '17', '91', '1497264791');
INSERT INTO `cs_rolemenu` VALUES ('3740', '17', '50', '1497264791');
INSERT INTO `cs_rolemenu` VALUES ('3741', '17', '92', '1497264791');
INSERT INTO `cs_rolemenu` VALUES ('3742', '17', '63', '1497264791');
INSERT INTO `cs_rolemenu` VALUES ('3743', '17', '64', '1497264791');
INSERT INTO `cs_rolemenu` VALUES ('3744', '17', '65', '1497264791');
INSERT INTO `cs_rolemenu` VALUES ('3745', '17', '66', '1497264791');
INSERT INTO `cs_rolemenu` VALUES ('3746', '17', '67', '1497264791');
INSERT INTO `cs_rolemenu` VALUES ('3747', '17', '68', '1497264791');
INSERT INTO `cs_rolemenu` VALUES ('3748', '17', '70', '1497264791');
INSERT INTO `cs_rolemenu` VALUES ('3749', '17', '71', '1497264791');
INSERT INTO `cs_rolemenu` VALUES ('3750', '17', '72', '1497264791');
INSERT INTO `cs_rolemenu` VALUES ('3751', '17', '73', '1497264791');
INSERT INTO `cs_rolemenu` VALUES ('3752', '17', '74', '1497264791');
INSERT INTO `cs_rolemenu` VALUES ('3952', '9', '1', '1497323327');
INSERT INTO `cs_rolemenu` VALUES ('3953', '9', '69', '1497323327');
INSERT INTO `cs_rolemenu` VALUES ('3954', '9', '59', '1497323327');
INSERT INTO `cs_rolemenu` VALUES ('3955', '9', '77', '1497323327');
INSERT INTO `cs_rolemenu` VALUES ('3956', '9', '78', '1497323327');
INSERT INTO `cs_rolemenu` VALUES ('3957', '9', '79', '1497323327');
INSERT INTO `cs_rolemenu` VALUES ('3958', '9', '87', '1497323327');
INSERT INTO `cs_rolemenu` VALUES ('3959', '9', '98', '1497323327');
INSERT INTO `cs_rolemenu` VALUES ('3960', '9', '99', '1497323327');
INSERT INTO `cs_rolemenu` VALUES ('3961', '9', '24', '1497323327');
INSERT INTO `cs_rolemenu` VALUES ('3962', '9', '25', '1497323327');
INSERT INTO `cs_rolemenu` VALUES ('3963', '9', '75', '1497323327');
INSERT INTO `cs_rolemenu` VALUES ('3964', '9', '76', '1497323327');
INSERT INTO `cs_rolemenu` VALUES ('3965', '9', '90', '1497323327');
INSERT INTO `cs_rolemenu` VALUES ('3966', '9', '100', '1497323327');
INSERT INTO `cs_rolemenu` VALUES ('3967', '9', '101', '1497323327');
INSERT INTO `cs_rolemenu` VALUES ('3968', '9', '51', '1497323327');
INSERT INTO `cs_rolemenu` VALUES ('3969', '9', '89', '1497323327');
INSERT INTO `cs_rolemenu` VALUES ('3970', '9', '52', '1497323327');
INSERT INTO `cs_rolemenu` VALUES ('3971', '9', '88', '1497323327');
INSERT INTO `cs_rolemenu` VALUES ('3972', '9', '27', '1497323327');
INSERT INTO `cs_rolemenu` VALUES ('3973', '9', '31', '1497323327');
INSERT INTO `cs_rolemenu` VALUES ('3974', '9', '29', '1497323327');
INSERT INTO `cs_rolemenu` VALUES ('3975', '9', '38', '1497323327');
INSERT INTO `cs_rolemenu` VALUES ('3976', '9', '36', '1497323327');
INSERT INTO `cs_rolemenu` VALUES ('3977', '9', '37', '1497323327');
INSERT INTO `cs_rolemenu` VALUES ('3978', '9', '41', '1497323327');
INSERT INTO `cs_rolemenu` VALUES ('3979', '9', '42', '1497323327');
INSERT INTO `cs_rolemenu` VALUES ('3980', '9', '43', '1497323327');
INSERT INTO `cs_rolemenu` VALUES ('3981', '9', '44', '1497323327');
INSERT INTO `cs_rolemenu` VALUES ('3982', '9', '45', '1497323327');
INSERT INTO `cs_rolemenu` VALUES ('3983', '9', '97', '1497323327');
INSERT INTO `cs_rolemenu` VALUES ('3984', '9', '46', '1497323327');
INSERT INTO `cs_rolemenu` VALUES ('3985', '9', '47', '1497323327');
INSERT INTO `cs_rolemenu` VALUES ('3986', '9', '93', '1497323327');
INSERT INTO `cs_rolemenu` VALUES ('3987', '9', '48', '1497323327');
INSERT INTO `cs_rolemenu` VALUES ('3988', '9', '94', '1497323327');
INSERT INTO `cs_rolemenu` VALUES ('3989', '9', '49', '1497323327');
INSERT INTO `cs_rolemenu` VALUES ('3990', '9', '91', '1497323327');
INSERT INTO `cs_rolemenu` VALUES ('3991', '9', '95', '1497323327');
INSERT INTO `cs_rolemenu` VALUES ('3992', '9', '50', '1497323327');
INSERT INTO `cs_rolemenu` VALUES ('3993', '9', '92', '1497323327');
INSERT INTO `cs_rolemenu` VALUES ('3994', '9', '96', '1497323327');
INSERT INTO `cs_rolemenu` VALUES ('3995', '16', '1', '1497324085');
INSERT INTO `cs_rolemenu` VALUES ('3996', '16', '69', '1497324085');
INSERT INTO `cs_rolemenu` VALUES ('3997', '16', '2', '1497324085');
INSERT INTO `cs_rolemenu` VALUES ('3998', '16', '56', '1497324085');
INSERT INTO `cs_rolemenu` VALUES ('3999', '16', '57', '1497324085');
INSERT INTO `cs_rolemenu` VALUES ('4000', '16', '58', '1497324085');
INSERT INTO `cs_rolemenu` VALUES ('4001', '16', '62', '1497324085');
INSERT INTO `cs_rolemenu` VALUES ('4002', '16', '80', '1497324085');
INSERT INTO `cs_rolemenu` VALUES ('4003', '16', '81', '1497324085');
INSERT INTO `cs_rolemenu` VALUES ('4004', '16', '82', '1497324085');
INSERT INTO `cs_rolemenu` VALUES ('4005', '16', '83', '1497324085');
INSERT INTO `cs_rolemenu` VALUES ('4006', '16', '84', '1497324085');
INSERT INTO `cs_rolemenu` VALUES ('4007', '16', '60', '1497324085');
INSERT INTO `cs_rolemenu` VALUES ('4008', '16', '61', '1497324085');
INSERT INTO `cs_rolemenu` VALUES ('4009', '16', '85', '1497324085');
INSERT INTO `cs_rolemenu` VALUES ('4010', '16', '86', '1497324085');
INSERT INTO `cs_rolemenu` VALUES ('4011', '16', '59', '1497324085');
INSERT INTO `cs_rolemenu` VALUES ('4012', '16', '77', '1497324085');
INSERT INTO `cs_rolemenu` VALUES ('4013', '16', '78', '1497324085');
INSERT INTO `cs_rolemenu` VALUES ('4014', '16', '79', '1497324085');
INSERT INTO `cs_rolemenu` VALUES ('4015', '16', '87', '1497324085');
INSERT INTO `cs_rolemenu` VALUES ('4016', '16', '98', '1497324085');
INSERT INTO `cs_rolemenu` VALUES ('4017', '16', '99', '1497324085');
INSERT INTO `cs_rolemenu` VALUES ('4018', '16', '21', '1497324085');
INSERT INTO `cs_rolemenu` VALUES ('4019', '16', '26', '1497324085');
INSERT INTO `cs_rolemenu` VALUES ('4020', '16', '24', '1497324085');
INSERT INTO `cs_rolemenu` VALUES ('4021', '16', '25', '1497324085');
INSERT INTO `cs_rolemenu` VALUES ('4022', '16', '75', '1497324085');
INSERT INTO `cs_rolemenu` VALUES ('4023', '16', '76', '1497324085');
INSERT INTO `cs_rolemenu` VALUES ('4024', '16', '90', '1497324085');
INSERT INTO `cs_rolemenu` VALUES ('4025', '16', '100', '1497324085');
INSERT INTO `cs_rolemenu` VALUES ('4026', '16', '101', '1497324085');
INSERT INTO `cs_rolemenu` VALUES ('4027', '16', '51', '1497324085');
INSERT INTO `cs_rolemenu` VALUES ('4028', '16', '89', '1497324085');
INSERT INTO `cs_rolemenu` VALUES ('4029', '16', '52', '1497324085');
INSERT INTO `cs_rolemenu` VALUES ('4030', '16', '88', '1497324085');
INSERT INTO `cs_rolemenu` VALUES ('4031', '16', '27', '1497324085');
INSERT INTO `cs_rolemenu` VALUES ('4032', '16', '31', '1497324085');
INSERT INTO `cs_rolemenu` VALUES ('4033', '16', '29', '1497324085');
INSERT INTO `cs_rolemenu` VALUES ('4034', '16', '38', '1497324085');
INSERT INTO `cs_rolemenu` VALUES ('4035', '16', '36', '1497324085');
INSERT INTO `cs_rolemenu` VALUES ('4036', '16', '37', '1497324085');
INSERT INTO `cs_rolemenu` VALUES ('4037', '16', '41', '1497324085');
INSERT INTO `cs_rolemenu` VALUES ('4038', '16', '42', '1497324085');
INSERT INTO `cs_rolemenu` VALUES ('4039', '16', '43', '1497324085');
INSERT INTO `cs_rolemenu` VALUES ('4040', '16', '44', '1497324085');
INSERT INTO `cs_rolemenu` VALUES ('4041', '16', '45', '1497324085');
INSERT INTO `cs_rolemenu` VALUES ('4042', '16', '97', '1497324085');
INSERT INTO `cs_rolemenu` VALUES ('4043', '16', '46', '1497324085');
INSERT INTO `cs_rolemenu` VALUES ('4044', '16', '47', '1497324085');
INSERT INTO `cs_rolemenu` VALUES ('4045', '16', '93', '1497324085');
INSERT INTO `cs_rolemenu` VALUES ('4046', '16', '48', '1497324085');
INSERT INTO `cs_rolemenu` VALUES ('4047', '16', '94', '1497324085');
INSERT INTO `cs_rolemenu` VALUES ('4048', '16', '49', '1497324085');
INSERT INTO `cs_rolemenu` VALUES ('4049', '16', '91', '1497324085');
INSERT INTO `cs_rolemenu` VALUES ('4050', '16', '95', '1497324085');
INSERT INTO `cs_rolemenu` VALUES ('4051', '16', '50', '1497324085');
INSERT INTO `cs_rolemenu` VALUES ('4052', '16', '92', '1497324085');
INSERT INTO `cs_rolemenu` VALUES ('4053', '16', '96', '1497324085');
INSERT INTO `cs_rolemenu` VALUES ('4054', '16', '63', '1497324085');
INSERT INTO `cs_rolemenu` VALUES ('4055', '16', '64', '1497324085');
INSERT INTO `cs_rolemenu` VALUES ('4056', '16', '65', '1497324085');
INSERT INTO `cs_rolemenu` VALUES ('4057', '16', '66', '1497324085');
INSERT INTO `cs_rolemenu` VALUES ('4058', '16', '67', '1497324085');
INSERT INTO `cs_rolemenu` VALUES ('4059', '16', '68', '1497324085');
INSERT INTO `cs_rolemenu` VALUES ('4060', '16', '70', '1497324085');
INSERT INTO `cs_rolemenu` VALUES ('4061', '16', '71', '1497324085');
INSERT INTO `cs_rolemenu` VALUES ('4062', '16', '72', '1497324085');
INSERT INTO `cs_rolemenu` VALUES ('4063', '16', '73', '1497324085');
INSERT INTO `cs_rolemenu` VALUES ('4064', '16', '74', '1497324085');
INSERT INTO `cs_rolemenu` VALUES ('4494', '2', '1', '1499747950');
INSERT INTO `cs_rolemenu` VALUES ('4495', '2', '69', '1499747950');
INSERT INTO `cs_rolemenu` VALUES ('4496', '2', '2', '1499747950');
INSERT INTO `cs_rolemenu` VALUES ('4497', '2', '56', '1499747950');
INSERT INTO `cs_rolemenu` VALUES ('4498', '2', '57', '1499747950');
INSERT INTO `cs_rolemenu` VALUES ('4499', '2', '58', '1499747950');
INSERT INTO `cs_rolemenu` VALUES ('4500', '2', '62', '1499747950');
INSERT INTO `cs_rolemenu` VALUES ('4501', '2', '80', '1499747950');
INSERT INTO `cs_rolemenu` VALUES ('4502', '2', '81', '1499747950');
INSERT INTO `cs_rolemenu` VALUES ('4503', '2', '82', '1499747950');
INSERT INTO `cs_rolemenu` VALUES ('4504', '2', '83', '1499747950');
INSERT INTO `cs_rolemenu` VALUES ('4505', '2', '84', '1499747950');
INSERT INTO `cs_rolemenu` VALUES ('4506', '2', '60', '1499747950');
INSERT INTO `cs_rolemenu` VALUES ('4507', '2', '61', '1499747950');
INSERT INTO `cs_rolemenu` VALUES ('4508', '2', '85', '1499747950');
INSERT INTO `cs_rolemenu` VALUES ('4509', '2', '86', '1499747950');
INSERT INTO `cs_rolemenu` VALUES ('4510', '2', '59', '1499747950');
INSERT INTO `cs_rolemenu` VALUES ('4511', '2', '77', '1499747950');
INSERT INTO `cs_rolemenu` VALUES ('4512', '2', '78', '1499747950');
INSERT INTO `cs_rolemenu` VALUES ('4513', '2', '79', '1499747950');
INSERT INTO `cs_rolemenu` VALUES ('4514', '2', '87', '1499747950');
INSERT INTO `cs_rolemenu` VALUES ('4515', '2', '98', '1499747950');
INSERT INTO `cs_rolemenu` VALUES ('4516', '2', '99', '1499747950');
INSERT INTO `cs_rolemenu` VALUES ('4517', '2', '21', '1499747950');
INSERT INTO `cs_rolemenu` VALUES ('4518', '2', '26', '1499747950');
INSERT INTO `cs_rolemenu` VALUES ('4519', '2', '24', '1499747950');
INSERT INTO `cs_rolemenu` VALUES ('4520', '2', '25', '1499747950');
INSERT INTO `cs_rolemenu` VALUES ('4521', '2', '75', '1499747950');
INSERT INTO `cs_rolemenu` VALUES ('4522', '2', '76', '1499747950');
INSERT INTO `cs_rolemenu` VALUES ('4523', '2', '90', '1499747950');
INSERT INTO `cs_rolemenu` VALUES ('4524', '2', '100', '1499747950');
INSERT INTO `cs_rolemenu` VALUES ('4525', '2', '101', '1499747950');
INSERT INTO `cs_rolemenu` VALUES ('4526', '2', '51', '1499747950');
INSERT INTO `cs_rolemenu` VALUES ('4527', '2', '89', '1499747950');
INSERT INTO `cs_rolemenu` VALUES ('4528', '2', '52', '1499747950');
INSERT INTO `cs_rolemenu` VALUES ('4529', '2', '88', '1499747950');
INSERT INTO `cs_rolemenu` VALUES ('4530', '2', '27', '1499747950');
INSERT INTO `cs_rolemenu` VALUES ('4531', '2', '31', '1499747950');
INSERT INTO `cs_rolemenu` VALUES ('4532', '2', '29', '1499747950');
INSERT INTO `cs_rolemenu` VALUES ('4533', '2', '38', '1499747950');
INSERT INTO `cs_rolemenu` VALUES ('4534', '2', '36', '1499747950');
INSERT INTO `cs_rolemenu` VALUES ('4535', '2', '37', '1499747950');
INSERT INTO `cs_rolemenu` VALUES ('4536', '2', '41', '1499747950');
INSERT INTO `cs_rolemenu` VALUES ('4537', '2', '42', '1499747950');
INSERT INTO `cs_rolemenu` VALUES ('4538', '2', '43', '1499747950');
INSERT INTO `cs_rolemenu` VALUES ('4539', '2', '44', '1499747950');
INSERT INTO `cs_rolemenu` VALUES ('4540', '2', '45', '1499747950');
INSERT INTO `cs_rolemenu` VALUES ('4541', '2', '97', '1499747950');
INSERT INTO `cs_rolemenu` VALUES ('4542', '2', '46', '1499747950');
INSERT INTO `cs_rolemenu` VALUES ('4543', '2', '47', '1499747950');
INSERT INTO `cs_rolemenu` VALUES ('4544', '2', '93', '1499747950');
INSERT INTO `cs_rolemenu` VALUES ('4545', '2', '48', '1499747950');
INSERT INTO `cs_rolemenu` VALUES ('4546', '2', '94', '1499747950');
INSERT INTO `cs_rolemenu` VALUES ('4547', '2', '49', '1499747950');
INSERT INTO `cs_rolemenu` VALUES ('4548', '2', '91', '1499747950');
INSERT INTO `cs_rolemenu` VALUES ('4549', '2', '95', '1499747950');
INSERT INTO `cs_rolemenu` VALUES ('4550', '2', '50', '1499747950');
INSERT INTO `cs_rolemenu` VALUES ('4551', '2', '92', '1499747950');
INSERT INTO `cs_rolemenu` VALUES ('4552', '2', '96', '1499747950');
INSERT INTO `cs_rolemenu` VALUES ('4553', '2', '63', '1499747950');
INSERT INTO `cs_rolemenu` VALUES ('4554', '2', '64', '1499747950');
INSERT INTO `cs_rolemenu` VALUES ('4555', '2', '65', '1499747950');
INSERT INTO `cs_rolemenu` VALUES ('4556', '2', '66', '1499747950');
INSERT INTO `cs_rolemenu` VALUES ('4557', '2', '67', '1499747950');
INSERT INTO `cs_rolemenu` VALUES ('4558', '2', '68', '1499747950');
INSERT INTO `cs_rolemenu` VALUES ('4559', '2', '70', '1499747950');
INSERT INTO `cs_rolemenu` VALUES ('4560', '2', '71', '1499747950');
INSERT INTO `cs_rolemenu` VALUES ('4561', '2', '72', '1499747950');
INSERT INTO `cs_rolemenu` VALUES ('4562', '2', '73', '1499747950');
INSERT INTO `cs_rolemenu` VALUES ('4563', '2', '74', '1499747950');
INSERT INTO `cs_rolemenu` VALUES ('4943', '1', '1', '1539165170');
INSERT INTO `cs_rolemenu` VALUES ('4944', '1', '69', '1539165170');
INSERT INTO `cs_rolemenu` VALUES ('4945', '1', '2', '1539165170');
INSERT INTO `cs_rolemenu` VALUES ('4946', '1', '56', '1539165170');
INSERT INTO `cs_rolemenu` VALUES ('4947', '1', '57', '1539165170');
INSERT INTO `cs_rolemenu` VALUES ('4948', '1', '58', '1539165170');
INSERT INTO `cs_rolemenu` VALUES ('4949', '1', '62', '1539165170');
INSERT INTO `cs_rolemenu` VALUES ('4950', '1', '80', '1539165170');
INSERT INTO `cs_rolemenu` VALUES ('4951', '1', '81', '1539165170');
INSERT INTO `cs_rolemenu` VALUES ('4952', '1', '82', '1539165170');
INSERT INTO `cs_rolemenu` VALUES ('4953', '1', '83', '1539165170');
INSERT INTO `cs_rolemenu` VALUES ('4954', '1', '84', '1539165170');
INSERT INTO `cs_rolemenu` VALUES ('4955', '1', '60', '1539165170');
INSERT INTO `cs_rolemenu` VALUES ('4956', '1', '61', '1539165170');
INSERT INTO `cs_rolemenu` VALUES ('4957', '1', '85', '1539165170');
INSERT INTO `cs_rolemenu` VALUES ('4958', '1', '86', '1539165170');
INSERT INTO `cs_rolemenu` VALUES ('4959', '1', '59', '1539165170');
INSERT INTO `cs_rolemenu` VALUES ('4960', '1', '77', '1539165170');
INSERT INTO `cs_rolemenu` VALUES ('4961', '1', '78', '1539165170');
INSERT INTO `cs_rolemenu` VALUES ('4962', '1', '79', '1539165170');
INSERT INTO `cs_rolemenu` VALUES ('4963', '1', '87', '1539165170');
INSERT INTO `cs_rolemenu` VALUES ('4964', '1', '98', '1539165170');
INSERT INTO `cs_rolemenu` VALUES ('4965', '1', '99', '1539165170');
INSERT INTO `cs_rolemenu` VALUES ('4966', '1', '63', '1539165170');
INSERT INTO `cs_rolemenu` VALUES ('4967', '1', '64', '1539165170');
INSERT INTO `cs_rolemenu` VALUES ('4968', '1', '65', '1539165170');
INSERT INTO `cs_rolemenu` VALUES ('4969', '1', '66', '1539165170');
INSERT INTO `cs_rolemenu` VALUES ('4970', '1', '67', '1539165170');
INSERT INTO `cs_rolemenu` VALUES ('4971', '1', '68', '1539165170');
INSERT INTO `cs_rolemenu` VALUES ('4972', '1', '105', '1539165170');
INSERT INTO `cs_rolemenu` VALUES ('4973', '1', '106', '1539165170');
INSERT INTO `cs_rolemenu` VALUES ('4974', '1', '107', '1539165170');
INSERT INTO `cs_rolemenu` VALUES ('4975', '1', '108', '1539165170');
INSERT INTO `cs_rolemenu` VALUES ('4976', '1', '111', '1539165170');
INSERT INTO `cs_rolemenu` VALUES ('4977', '1', '112', '1539165170');
INSERT INTO `cs_rolemenu` VALUES ('4978', '1', '113', '1539165170');
INSERT INTO `cs_rolemenu` VALUES ('4979', '1', '114', '1539165170');
INSERT INTO `cs_rolemenu` VALUES ('4980', '1', '115', '1539165170');
INSERT INTO `cs_rolemenu` VALUES ('4981', '1', '116', '1539165170');
INSERT INTO `cs_rolemenu` VALUES ('4982', '1', '117', '1539165170');
INSERT INTO `cs_rolemenu` VALUES ('4983', '1', '118', '1539165170');
INSERT INTO `cs_rolemenu` VALUES ('4984', '1', '120', '1539165170');
INSERT INTO `cs_rolemenu` VALUES ('4985', '1', '119', '1539165170');

-- ----------------------------
-- Table structure for cs_score
-- ----------------------------
DROP TABLE IF EXISTS `cs_score`;
CREATE TABLE `cs_score` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) DEFAULT NULL COMMENT '用户id',
  `user_name` varchar(40) DEFAULT NULL COMMENT '用户名',
  `age` int(10) DEFAULT NULL COMMENT '年龄',
  `phone` bigint(200) DEFAULT NULL COMMENT '电话号码',
  `bmi` varchar(200) DEFAULT NULL COMMENT '体质指数(BMI)',
  `all_property` varchar(80) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT '所有属性',
  `all_score` varchar(80) DEFAULT NULL COMMENT '所有的评分',
  `count_property` varchar(80) DEFAULT NULL COMMENT '统计属性',
  `count_score` varchar(80) DEFAULT NULL COMMENT '统计后的评分',
  `questionnaire_id` int(10) DEFAULT NULL COMMENT '所属问卷id',
  `questionnaire_name` varchar(80) DEFAULT NULL COMMENT '所属问卷名称',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cs_score
-- ----------------------------
INSERT INTO `cs_score` VALUES ('25', '42', '我的手机', '11', '2147483647', null, '寒/阳虚/气滞/血瘀/气虚/血虚', '76/82/86/66/20/10', '(寒+阳虚)/(气滞+血瘀)/(气虚+血虚)', '158/152/30', '32', '痛经情况问卷调查表', '1539158646');
INSERT INTO `cs_score` VALUES ('26', '43', '测试号码', '22', '2147483647', null, '寒/阳虚/气滞/血瘀/气虚/血虚', '-18/-26/108/134/38/35', '(寒+阳虚)/(气滞+血瘀)/(气虚+血虚)', '-44/242/73', '32', '痛经情况问卷调查表', '1539158904');
INSERT INTO `cs_score` VALUES ('27', '44', '第二次测试手机号码', '32', '13135318241', null, '寒/阳虚/气滞/血瘀/气虚/血虚', '42/16/76/118/28/25', '(寒+阳虚)/(气滞+血瘀)/(气虚+血虚)', '58/194/53', '32', '痛经情况问卷调查表', '1539159084');
INSERT INTO `cs_score` VALUES ('28', '45', '一万', '10000', '13755032537', null, '寒/阳虚/气滞/血瘀/气虚/血虚', '87/78/77/67/42/65', '(寒+阳虚)/(气滞+血瘀)/(气虚+血虚)', '165/144/107', '32', '痛经情况问卷调查表', '1539238715');
INSERT INTO `cs_score` VALUES ('29', '46', '二万', '222', '13755032537', null, '寒/阳虚/气滞/血瘀/气虚/血虚', '73/36/95/91/81/2020', '(寒+阳虚)/(气滞+血瘀)/(气虚+血虚)', '109/186/2101', '32', '痛经情况问卷调查表', '1539239500');
INSERT INTO `cs_score` VALUES ('30', '47', '5553', '333', '13755032537', null, '寒/阳虚/气滞/血瘀/气虚/血虚', '111/38/132/134/99/2015', '(寒+阳虚)/(气滞+血瘀)/(气虚+血虚)', '149/266/2114', '32', '痛经情况问卷调查表', '1539239630');
INSERT INTO `cs_score` VALUES ('31', '49', '2千已经好了', '22', '13135318241', null, '寒/阳虚/气滞/血瘀/气虚/血虚', '-54/-4/62/67/28/10', '(寒+阳虚)/(气滞+血瘀)/(气虚+血虚)', '-58/129/38', '32', '痛经情况问卷调查表', '1539245498');
INSERT INTO `cs_score` VALUES ('32', '50', '4444', '44', '444444444444', '过轻', '寒/阳虚/气滞/血瘀/气虚/血虚', '69/121/81/84/82/56', '(寒+阳虚)/(气滞+血瘀)/(气虚+血虚)', '190/165/138', '32', '痛经情况问卷调查表', '1539310788');
INSERT INTO `cs_score` VALUES ('33', '51', '5555', '55', '55555555555', '非常肥胖', '寒/阳虚/气滞/血瘀/气虚/血虚', '123/80/93/92/42/54', '(寒+阳虚)/(气滞+血瘀)/(气虚+血虚)', '203/185/96', '32', '痛经情况问卷调查表', '1539311470');
INSERT INTO `cs_score` VALUES ('34', '52', '6666666', '66', '6666666666', '非常肥胖76.9', '寒/阳虚/气滞/血瘀/气虚/血虚', '41/-18/157/119/8/15', '(寒+阳虚)/(气滞+血瘀)/(气虚+血虚)', '23/276/23', '32', '痛经情况问卷调查表', '1539312252');
INSERT INTO `cs_score` VALUES ('35', '53', '777', '77', '777777', '过轻0', '寒/阳虚/气滞/血瘀/气虚/血虚', '-43/-50/73/103/38/20', '(寒+阳虚)/(气滞+血瘀)/(气虚+血虚)', '-93/176/58', '32', '痛经情况问卷调查表', '1539315609');
INSERT INTO `cs_score` VALUES ('36', '54', '88', '88', '888888', '非常肥胖142.9', '寒/阳虚/气滞/血瘀/气虚/血虚', '-49/-50/135/87/16/20', '(寒+阳虚)/(气滞+血瘀)/(气虚+血虚)', '-99/222/36', '32', '痛经情况问卷调查表', '1539316024');
INSERT INTO `cs_score` VALUES ('37', '55', '99999', '999', '999999', '正常23.9', '寒/阳虚/气滞/血瘀/气虚/血虚', '-50/-50/99/119/44/20', '(寒+阳虚)/(气滞+血瘀)/(气虚+血虚)', '-100/218/64', '32', '痛经情况问卷调查表', '1539316590');
INSERT INTO `cs_score` VALUES ('38', '56', '111', '111', '1111', '23.9(正常)', '寒/阳虚/气滞/血瘀/气虚/血虚', '42/42/86/90/28/25', '(寒+阳虚)/(气滞+血瘀)/(气虚+血虚)', '84/176/53', '32', '痛经情况问卷调查表', '1539316975');

-- ----------------------------
-- Table structure for cs_user
-- ----------------------------
DROP TABLE IF EXISTS `cs_user`;
CREATE TABLE `cs_user` (
  `user_Id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL DEFAULT '0' COMMENT '组织ID',
  `username` varchar(20) DEFAULT NULL COMMENT '登录账号',
  `password` varchar(32) DEFAULT NULL COMMENT '密码',
  `real_name` varchar(20) DEFAULT NULL COMMENT '真实姓名',
  `head_img` varchar(255) DEFAULT NULL COMMENT '用户头像',
  `tel` varchar(20) DEFAULT NULL COMMENT '电话',
  `addtime` varchar(20) DEFAULT NULL COMMENT '添加时间',
  `is_use` int(1) DEFAULT '1' COMMENT '登录许可(0不允许，1允许)',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  `ser_uid` int(11) DEFAULT '0' COMMENT '关联客服ID',
  `manager_uid` int(11) DEFAULT '0' COMMENT '关联区域经理ID',
  PRIMARY KEY (`user_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='后台管理者表';

-- ----------------------------
-- Records of cs_user
-- ----------------------------
INSERT INTO `cs_user` VALUES ('6', '1', 'admin', 'c7587f7409d4fe85cd5faaceb727146f', '超级管理员', null, '13975147202', '1490062011', '1', null, null, '0');

-- ----------------------------
-- Table structure for cs_userrole
-- ----------------------------
DROP TABLE IF EXISTS `cs_userrole`;
CREATE TABLE `cs_userrole` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `user_Id` varchar(11) DEFAULT NULL COMMENT '用户ID',
  `role_Id` varchar(11) DEFAULT NULL COMMENT '角色ID',
  `time` varchar(20) DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`Id`),
  KEY `user_Id` (`user_Id`),
  KEY `role_Id` (`role_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=330 DEFAULT CHARSET=utf8 COMMENT='用户角色中间表';

-- ----------------------------
-- Records of cs_userrole
-- ----------------------------
INSERT INTO `cs_userrole` VALUES ('57', '6', '1', '1490593177');
INSERT INTO `cs_userrole` VALUES ('59', '8', '2', '1492072937');
INSERT INTO `cs_userrole` VALUES ('62', '11', '2', '1492393776');
INSERT INTO `cs_userrole` VALUES ('64', '13', '9', '1492497515');
INSERT INTO `cs_userrole` VALUES ('65', '14', '8', '1492498313');
INSERT INTO `cs_userrole` VALUES ('108', '25', '9', '1495867926');
INSERT INTO `cs_userrole` VALUES ('109', '26', '9', '1495867950');
INSERT INTO `cs_userrole` VALUES ('173', '90', '16', '1496278702');
INSERT INTO `cs_userrole` VALUES ('193', '110', '16', '1496304312');
INSERT INTO `cs_userrole` VALUES ('208', '125', '17', '1496313079');
INSERT INTO `cs_userrole` VALUES ('209', '126', '10', '1496313276');
INSERT INTO `cs_userrole` VALUES ('211', '128', '8', '1496322413');
INSERT INTO `cs_userrole` VALUES ('212', '129', '8', '1496322689');
INSERT INTO `cs_userrole` VALUES ('213', '130', '10', '1496369288');
INSERT INTO `cs_userrole` VALUES ('214', '131', '17', '1496369360');
INSERT INTO `cs_userrole` VALUES ('215', '132', '10', '1496369447');
INSERT INTO `cs_userrole` VALUES ('218', '135', '9', '1496370921');
INSERT INTO `cs_userrole` VALUES ('219', '136', '16', '1496371220');
INSERT INTO `cs_userrole` VALUES ('221', '138', '8', '1496375201');
INSERT INTO `cs_userrole` VALUES ('223', '140', '8', '1496387288');
INSERT INTO `cs_userrole` VALUES ('224', '141', '2', '1496387906');
INSERT INTO `cs_userrole` VALUES ('225', '142', '9', '1496392983');
INSERT INTO `cs_userrole` VALUES ('227', '144', '9', '1496625309');
INSERT INTO `cs_userrole` VALUES ('228', '145', '16', '1496625343');
INSERT INTO `cs_userrole` VALUES ('229', '146', '17', '1496625367');
INSERT INTO `cs_userrole` VALUES ('230', '147', '9', '1496626389');
INSERT INTO `cs_userrole` VALUES ('231', '148', '9', '1496626443');
INSERT INTO `cs_userrole` VALUES ('232', '149', '9', '1496626465');
INSERT INTO `cs_userrole` VALUES ('233', '150', '10', '1496626531');
INSERT INTO `cs_userrole` VALUES ('234', '151', '10', '1496626548');
INSERT INTO `cs_userrole` VALUES ('235', '152', '10', '1496626568');
INSERT INTO `cs_userrole` VALUES ('236', '153', '10', '1496626601');
INSERT INTO `cs_userrole` VALUES ('237', '154', '10', '1496626632');
INSERT INTO `cs_userrole` VALUES ('238', '155', '8', '1496630056');
INSERT INTO `cs_userrole` VALUES ('239', '156', '16', '1496634058');
INSERT INTO `cs_userrole` VALUES ('240', '157', '16', '1496634080');
INSERT INTO `cs_userrole` VALUES ('243', '160', '9', '1496649608');
INSERT INTO `cs_userrole` VALUES ('244', '161', '16', '1496651052');
INSERT INTO `cs_userrole` VALUES ('247', '164', '10', '1496663111');
INSERT INTO `cs_userrole` VALUES ('251', '168', '16', '1496735940');
INSERT INTO `cs_userrole` VALUES ('252', '169', '9', '1496735961');
INSERT INTO `cs_userrole` VALUES ('253', '170', '10', '1496735986');
INSERT INTO `cs_userrole` VALUES ('263', '180', '8', '1496803152');
INSERT INTO `cs_userrole` VALUES ('264', '181', '17', '1496803527');
INSERT INTO `cs_userrole` VALUES ('265', '182', '16', '1496826320');
INSERT INTO `cs_userrole` VALUES ('266', '183', '9', '1496826352');
INSERT INTO `cs_userrole` VALUES ('267', '184', '10', '1496826396');
INSERT INTO `cs_userrole` VALUES ('268', '185', '10', '1496826756');
INSERT INTO `cs_userrole` VALUES ('270', '187', '10', '1496885965');
INSERT INTO `cs_userrole` VALUES ('272', '189', '10', '1496886034');
INSERT INTO `cs_userrole` VALUES ('276', '193', '10', '1496908560');
INSERT INTO `cs_userrole` VALUES ('279', '196', '17', '1496972190');
INSERT INTO `cs_userrole` VALUES ('280', '197', '17', '1496972214');
INSERT INTO `cs_userrole` VALUES ('287', '204', '8', '1496977443');
INSERT INTO `cs_userrole` VALUES ('304', '221', '8', '1496990288');
INSERT INTO `cs_userrole` VALUES ('313', '230', '16', '1497006924');
INSERT INTO `cs_userrole` VALUES ('314', '231', '16', '1497229328');
INSERT INTO `cs_userrole` VALUES ('315', '232', '16', '1497248994');
INSERT INTO `cs_userrole` VALUES ('316', '233', '9', '1497249021');
INSERT INTO `cs_userrole` VALUES ('317', '234', '10', '1497249038');
INSERT INTO `cs_userrole` VALUES ('318', '235', '9', '1497249688');
INSERT INTO `cs_userrole` VALUES ('319', '236', '16', '1497249707');
INSERT INTO `cs_userrole` VALUES ('320', '237', '16', '1497320117');
INSERT INTO `cs_userrole` VALUES ('321', '238', '10', '1497322818');
INSERT INTO `cs_userrole` VALUES ('322', '239', '10', '1497929661');
INSERT INTO `cs_userrole` VALUES ('323', '240', '2', '1497929702');
INSERT INTO `cs_userrole` VALUES ('325', '242', '16', '1497946758');
INSERT INTO `cs_userrole` VALUES ('326', '243', '16', '1497947462');
INSERT INTO `cs_userrole` VALUES ('327', '244', '10', '1497947493');
INSERT INTO `cs_userrole` VALUES ('329', '246', '9', '1497947993');

-- ----------------------------
-- Table structure for cs_user_answer
-- ----------------------------
DROP TABLE IF EXISTS `cs_user_answer`;
CREATE TABLE `cs_user_answer` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) DEFAULT NULL COMMENT '绑定用户id',
  `question_type` int(8) DEFAULT NULL COMMENT '题型，1单选题，2多选题，3文本',
  `option_id` varchar(40) DEFAULT NULL COMMENT '选项',
  `content` varchar(250) DEFAULT NULL COMMENT '内容',
  `question_id` int(8) DEFAULT NULL COMMENT '问题id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=783 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cs_user_answer
-- ----------------------------
INSERT INTO `cs_user_answer` VALUES ('446', '42', null, null, '153', '109');
INSERT INTO `cs_user_answer` VALUES ('447', '42', null, null, '2', '110');
INSERT INTO `cs_user_answer` VALUES ('448', '42', null, null, '2', '111');
INSERT INTO `cs_user_answer` VALUES ('449', '42', null, null, '2', '112');
INSERT INTO `cs_user_answer` VALUES ('450', '42', null, null, '159', '113');
INSERT INTO `cs_user_answer` VALUES ('451', '42', null, null, '161', '114');
INSERT INTO `cs_user_answer` VALUES ('452', '42', null, null, '164', '115');
INSERT INTO `cs_user_answer` VALUES ('453', '42', null, null, '168', '116');
INSERT INTO `cs_user_answer` VALUES ('454', '42', null, null, '171', '117');
INSERT INTO `cs_user_answer` VALUES ('455', '42', null, null, '175', '118');
INSERT INTO `cs_user_answer` VALUES ('456', '42', null, null, '178', '119');
INSERT INTO `cs_user_answer` VALUES ('457', '42', null, null, '180', '120');
INSERT INTO `cs_user_answer` VALUES ('458', '42', null, null, '185', '121');
INSERT INTO `cs_user_answer` VALUES ('459', '42', null, null, '188', '122');
INSERT INTO `cs_user_answer` VALUES ('460', '42', null, null, '191', '123');
INSERT INTO `cs_user_answer` VALUES ('461', '42', null, null, '194', '124');
INSERT INTO `cs_user_answer` VALUES ('462', '42', null, null, '198', '125');
INSERT INTO `cs_user_answer` VALUES ('463', '42', null, null, '200', '126');
INSERT INTO `cs_user_answer` VALUES ('464', '42', null, null, '203', '127');
INSERT INTO `cs_user_answer` VALUES ('465', '42', null, null, '206', '128');
INSERT INTO `cs_user_answer` VALUES ('466', '42', null, null, '210', '129');
INSERT INTO `cs_user_answer` VALUES ('467', '42', null, null, '214', '130');
INSERT INTO `cs_user_answer` VALUES ('468', '43', null, null, '153', '109');
INSERT INTO `cs_user_answer` VALUES ('469', '43', null, null, '22', '110');
INSERT INTO `cs_user_answer` VALUES ('470', '43', null, null, '22', '111');
INSERT INTO `cs_user_answer` VALUES ('471', '43', null, null, '22', '112');
INSERT INTO `cs_user_answer` VALUES ('472', '43', null, null, '158', '113');
INSERT INTO `cs_user_answer` VALUES ('473', '43', null, null, '160', '114');
INSERT INTO `cs_user_answer` VALUES ('474', '43', null, null, '165', '115');
INSERT INTO `cs_user_answer` VALUES ('475', '43', null, null, '168', '116');
INSERT INTO `cs_user_answer` VALUES ('476', '43', null, null, '172', '117');
INSERT INTO `cs_user_answer` VALUES ('477', '43', null, null, '176', '118');
INSERT INTO `cs_user_answer` VALUES ('478', '43', null, null, '178', '119');
INSERT INTO `cs_user_answer` VALUES ('479', '43', null, null, '180', '120');
INSERT INTO `cs_user_answer` VALUES ('480', '43', null, null, '186', '121');
INSERT INTO `cs_user_answer` VALUES ('481', '43', null, null, '189', '122');
INSERT INTO `cs_user_answer` VALUES ('482', '43', null, null, '192', '123');
INSERT INTO `cs_user_answer` VALUES ('483', '43', null, null, '195', '124');
INSERT INTO `cs_user_answer` VALUES ('484', '43', null, null, '198', '125');
INSERT INTO `cs_user_answer` VALUES ('485', '43', null, null, '201', '126');
INSERT INTO `cs_user_answer` VALUES ('486', '43', null, null, '204', '127');
INSERT INTO `cs_user_answer` VALUES ('487', '43', null, null, '207', '128');
INSERT INTO `cs_user_answer` VALUES ('488', '43', null, null, '212', '129');
INSERT INTO `cs_user_answer` VALUES ('489', '43', null, null, '215', '130');
INSERT INTO `cs_user_answer` VALUES ('490', '44', null, null, '153', '109');
INSERT INTO `cs_user_answer` VALUES ('491', '44', null, null, '32', '110');
INSERT INTO `cs_user_answer` VALUES ('492', '44', null, null, '32', '111');
INSERT INTO `cs_user_answer` VALUES ('493', '44', null, null, '32', '112');
INSERT INTO `cs_user_answer` VALUES ('494', '44', null, null, '158', '113');
INSERT INTO `cs_user_answer` VALUES ('495', '44', null, null, '161', '114');
INSERT INTO `cs_user_answer` VALUES ('496', '44', null, null, '165', '115');
INSERT INTO `cs_user_answer` VALUES ('497', '44', null, null, '168', '116');
INSERT INTO `cs_user_answer` VALUES ('498', '44', null, null, '172', '117');
INSERT INTO `cs_user_answer` VALUES ('499', '44', null, null, '176', '118');
INSERT INTO `cs_user_answer` VALUES ('500', '44', null, null, '178', '119');
INSERT INTO `cs_user_answer` VALUES ('501', '44', null, null, '180', '120');
INSERT INTO `cs_user_answer` VALUES ('502', '44', null, null, '186', '121');
INSERT INTO `cs_user_answer` VALUES ('503', '44', null, null, '189', '122');
INSERT INTO `cs_user_answer` VALUES ('504', '44', null, null, '191', '123');
INSERT INTO `cs_user_answer` VALUES ('505', '44', null, null, '194', '124');
INSERT INTO `cs_user_answer` VALUES ('506', '44', null, null, '197', '125');
INSERT INTO `cs_user_answer` VALUES ('507', '44', null, null, '200', '126');
INSERT INTO `cs_user_answer` VALUES ('508', '44', null, null, '203', '127');
INSERT INTO `cs_user_answer` VALUES ('509', '44', null, null, '207', '128');
INSERT INTO `cs_user_answer` VALUES ('510', '44', null, null, '211', '129');
INSERT INTO `cs_user_answer` VALUES ('511', '44', null, null, '214', '130');
INSERT INTO `cs_user_answer` VALUES ('512', '45', null, null, '153', '109');
INSERT INTO `cs_user_answer` VALUES ('513', '45', null, null, '10000', '110');
INSERT INTO `cs_user_answer` VALUES ('514', '45', null, null, '10000', '111');
INSERT INTO `cs_user_answer` VALUES ('515', '45', null, null, '10000', '112');
INSERT INTO `cs_user_answer` VALUES ('516', '45', null, null, '158', '113');
INSERT INTO `cs_user_answer` VALUES ('517', '45', null, null, '161', '114');
INSERT INTO `cs_user_answer` VALUES ('518', '45', null, null, '164', '115');
INSERT INTO `cs_user_answer` VALUES ('519', '45', null, null, '167', '116');
INSERT INTO `cs_user_answer` VALUES ('520', '45', null, null, '171', '117');
INSERT INTO `cs_user_answer` VALUES ('521', '45', null, null, '173', '118');
INSERT INTO `cs_user_answer` VALUES ('522', '45', null, null, '177', '119');
INSERT INTO `cs_user_answer` VALUES ('523', '45', null, null, '179', '120');
INSERT INTO `cs_user_answer` VALUES ('524', '45', null, null, '186', '121');
INSERT INTO `cs_user_answer` VALUES ('525', '45', null, null, '188', '122');
INSERT INTO `cs_user_answer` VALUES ('526', '45', null, null, '191', '123');
INSERT INTO `cs_user_answer` VALUES ('527', '45', null, null, '193', '124');
INSERT INTO `cs_user_answer` VALUES ('528', '45', null, null, '197', '125');
INSERT INTO `cs_user_answer` VALUES ('529', '45', null, null, '199', '126');
INSERT INTO `cs_user_answer` VALUES ('530', '45', null, null, '203', '127');
INSERT INTO `cs_user_answer` VALUES ('531', '45', null, null, '205', '128');
INSERT INTO `cs_user_answer` VALUES ('532', '45', null, null, '211', '129');
INSERT INTO `cs_user_answer` VALUES ('533', '45', null, null, '214', '130');
INSERT INTO `cs_user_answer` VALUES ('534', '46', null, null, '155', '109');
INSERT INTO `cs_user_answer` VALUES ('535', '46', null, null, '112', '110');
INSERT INTO `cs_user_answer` VALUES ('536', '46', null, null, '111', '111');
INSERT INTO `cs_user_answer` VALUES ('537', '46', null, null, '11', '112');
INSERT INTO `cs_user_answer` VALUES ('538', '46', null, null, '158', '113');
INSERT INTO `cs_user_answer` VALUES ('539', '46', null, null, '162', '114');
INSERT INTO `cs_user_answer` VALUES ('540', '46', null, null, '166', '115');
INSERT INTO `cs_user_answer` VALUES ('541', '46', null, null, '168', '116');
INSERT INTO `cs_user_answer` VALUES ('542', '46', null, null, '171', '117');
INSERT INTO `cs_user_answer` VALUES ('543', '46', null, null, '174', '118');
INSERT INTO `cs_user_answer` VALUES ('544', '46', null, null, '177', '119');
INSERT INTO `cs_user_answer` VALUES ('545', '46', null, null, '182', '120');
INSERT INTO `cs_user_answer` VALUES ('546', '46', null, null, '185', '121');
INSERT INTO `cs_user_answer` VALUES ('547', '46', null, null, '188', '122');
INSERT INTO `cs_user_answer` VALUES ('548', '46', null, null, '191', '123');
INSERT INTO `cs_user_answer` VALUES ('549', '46', null, null, '194', '124');
INSERT INTO `cs_user_answer` VALUES ('550', '46', null, null, '197', '125');
INSERT INTO `cs_user_answer` VALUES ('551', '46', null, null, '200', '126');
INSERT INTO `cs_user_answer` VALUES ('552', '46', null, null, '203', '127');
INSERT INTO `cs_user_answer` VALUES ('553', '46', null, null, '206', '128');
INSERT INTO `cs_user_answer` VALUES ('554', '46', null, null, '211', '129');
INSERT INTO `cs_user_answer` VALUES ('555', '46', null, null, '214', '130');
INSERT INTO `cs_user_answer` VALUES ('556', '47', null, null, '153', '109');
INSERT INTO `cs_user_answer` VALUES ('557', '47', null, null, '112', '110');
INSERT INTO `cs_user_answer` VALUES ('558', '47', null, null, '111', '111');
INSERT INTO `cs_user_answer` VALUES ('559', '47', null, null, '4', '112');
INSERT INTO `cs_user_answer` VALUES ('560', '47', null, null, '158', '113');
INSERT INTO `cs_user_answer` VALUES ('561', '47', null, null, '162', '114');
INSERT INTO `cs_user_answer` VALUES ('562', '47', null, null, '164', '115');
INSERT INTO `cs_user_answer` VALUES ('563', '47', null, null, '169', '116');
INSERT INTO `cs_user_answer` VALUES ('564', '47', null, null, '171', '117');
INSERT INTO `cs_user_answer` VALUES ('565', '47', null, null, '175', '118');
INSERT INTO `cs_user_answer` VALUES ('566', '47', null, null, '177', '119');
INSERT INTO `cs_user_answer` VALUES ('567', '47', null, null, '181', '120');
INSERT INTO `cs_user_answer` VALUES ('568', '47', null, null, '186', '121');
INSERT INTO `cs_user_answer` VALUES ('569', '47', null, null, '188', '122');
INSERT INTO `cs_user_answer` VALUES ('570', '47', null, null, '191', '123');
INSERT INTO `cs_user_answer` VALUES ('571', '47', null, null, '193', '124');
INSERT INTO `cs_user_answer` VALUES ('572', '47', null, null, '198', '125');
INSERT INTO `cs_user_answer` VALUES ('573', '47', null, null, '200', '126');
INSERT INTO `cs_user_answer` VALUES ('574', '47', null, null, '202', '127');
INSERT INTO `cs_user_answer` VALUES ('575', '47', null, null, '206', '128');
INSERT INTO `cs_user_answer` VALUES ('576', '47', null, null, '212', '129');
INSERT INTO `cs_user_answer` VALUES ('577', '47', null, null, '214', '130');
INSERT INTO `cs_user_answer` VALUES ('578', '48', null, null, '153', '109');
INSERT INTO `cs_user_answer` VALUES ('579', '48', null, null, '112', '110');
INSERT INTO `cs_user_answer` VALUES ('580', '48', null, null, '111', '111');
INSERT INTO `cs_user_answer` VALUES ('581', '48', null, null, '3', '112');
INSERT INTO `cs_user_answer` VALUES ('582', '48', null, null, '158', '113');
INSERT INTO `cs_user_answer` VALUES ('583', '48', null, null, '162', '114');
INSERT INTO `cs_user_answer` VALUES ('584', '48', null, null, '164', '115');
INSERT INTO `cs_user_answer` VALUES ('585', '48', null, null, '168', '116');
INSERT INTO `cs_user_answer` VALUES ('586', '48', null, null, '172', '117');
INSERT INTO `cs_user_answer` VALUES ('587', '48', null, null, '175', '118');
INSERT INTO `cs_user_answer` VALUES ('588', '48', null, null, '178', '119');
INSERT INTO `cs_user_answer` VALUES ('589', '48', null, null, '181', '120');
INSERT INTO `cs_user_answer` VALUES ('590', '48', null, null, '187', '121');
INSERT INTO `cs_user_answer` VALUES ('591', '48', null, null, '188', '122');
INSERT INTO `cs_user_answer` VALUES ('592', '48', null, null, '192', '123');
INSERT INTO `cs_user_answer` VALUES ('593', '48', null, null, '195', '124');
INSERT INTO `cs_user_answer` VALUES ('594', '48', null, null, '197', '125');
INSERT INTO `cs_user_answer` VALUES ('595', '48', null, null, '200', '126');
INSERT INTO `cs_user_answer` VALUES ('596', '48', null, null, '203', '127');
INSERT INTO `cs_user_answer` VALUES ('597', '48', null, null, '208', '128');
INSERT INTO `cs_user_answer` VALUES ('598', '48', null, null, '212', '129');
INSERT INTO `cs_user_answer` VALUES ('599', '48', null, null, '215', '130');
INSERT INTO `cs_user_answer` VALUES ('600', '49', null, null, '153', '109');
INSERT INTO `cs_user_answer` VALUES ('601', '49', null, null, '112', '110');
INSERT INTO `cs_user_answer` VALUES ('602', '49', null, null, '111', '111');
INSERT INTO `cs_user_answer` VALUES ('603', '49', null, null, '3', '112');
INSERT INTO `cs_user_answer` VALUES ('604', '49', null, null, '159', '113');
INSERT INTO `cs_user_answer` VALUES ('605', '49', null, null, '162', '114');
INSERT INTO `cs_user_answer` VALUES ('606', '49', null, null, '164', '115');
INSERT INTO `cs_user_answer` VALUES ('607', '49', null, null, '168', '116');
INSERT INTO `cs_user_answer` VALUES ('608', '49', null, null, '172', '117');
INSERT INTO `cs_user_answer` VALUES ('609', '49', null, null, '174', '118');
INSERT INTO `cs_user_answer` VALUES ('610', '49', null, null, '178', '119');
INSERT INTO `cs_user_answer` VALUES ('611', '49', null, null, '180', '120');
INSERT INTO `cs_user_answer` VALUES ('612', '49', null, null, '187', '121');
INSERT INTO `cs_user_answer` VALUES ('613', '49', null, null, '189', '122');
INSERT INTO `cs_user_answer` VALUES ('614', '49', null, null, '191', '123');
INSERT INTO `cs_user_answer` VALUES ('615', '49', null, null, '195', '124');
INSERT INTO `cs_user_answer` VALUES ('616', '49', null, null, '197', '125');
INSERT INTO `cs_user_answer` VALUES ('617', '49', null, null, '199', '126');
INSERT INTO `cs_user_answer` VALUES ('618', '49', null, null, '204', '127');
INSERT INTO `cs_user_answer` VALUES ('619', '49', null, null, '207', '128');
INSERT INTO `cs_user_answer` VALUES ('620', '49', null, null, '211', '129');
INSERT INTO `cs_user_answer` VALUES ('621', '49', null, null, '215', '130');
INSERT INTO `cs_user_answer` VALUES ('622', '50', null, null, '172', '131');
INSERT INTO `cs_user_answer` VALUES ('623', '50', null, null, '70', '132');
INSERT INTO `cs_user_answer` VALUES ('624', '50', null, null, '4', '110');
INSERT INTO `cs_user_answer` VALUES ('625', '50', null, null, '4', '111');
INSERT INTO `cs_user_answer` VALUES ('626', '50', null, null, '4', '112');
INSERT INTO `cs_user_answer` VALUES ('627', '50', null, null, '158', '113');
INSERT INTO `cs_user_answer` VALUES ('628', '50', null, null, '160', '114');
INSERT INTO `cs_user_answer` VALUES ('629', '50', null, null, '164', '115');
INSERT INTO `cs_user_answer` VALUES ('630', '50', null, null, '167', '116');
INSERT INTO `cs_user_answer` VALUES ('631', '50', null, null, '170', '117');
INSERT INTO `cs_user_answer` VALUES ('632', '50', null, null, '174', '118');
INSERT INTO `cs_user_answer` VALUES ('633', '50', null, null, '177', '119');
INSERT INTO `cs_user_answer` VALUES ('634', '50', null, null, '179', '120');
INSERT INTO `cs_user_answer` VALUES ('635', '50', null, null, '184', '121');
INSERT INTO `cs_user_answer` VALUES ('636', '50', null, null, '188', '122');
INSERT INTO `cs_user_answer` VALUES ('637', '50', null, null, '190', '123');
INSERT INTO `cs_user_answer` VALUES ('638', '50', null, null, '194', '124');
INSERT INTO `cs_user_answer` VALUES ('639', '50', null, null, '196', '125');
INSERT INTO `cs_user_answer` VALUES ('640', '50', null, null, '216', '126');
INSERT INTO `cs_user_answer` VALUES ('641', '50', null, null, '202', '127');
INSERT INTO `cs_user_answer` VALUES ('642', '50', null, null, '205', '128');
INSERT INTO `cs_user_answer` VALUES ('643', '50', null, null, '210', '129');
INSERT INTO `cs_user_answer` VALUES ('644', '50', null, null, '213', '130');
INSERT INTO `cs_user_answer` VALUES ('645', '51', null, null, '172', '131');
INSERT INTO `cs_user_answer` VALUES ('646', '51', null, null, '70', '132');
INSERT INTO `cs_user_answer` VALUES ('647', '51', null, null, '5', '110');
INSERT INTO `cs_user_answer` VALUES ('648', '51', null, null, '5', '111');
INSERT INTO `cs_user_answer` VALUES ('649', '51', null, null, '5', '112');
INSERT INTO `cs_user_answer` VALUES ('650', '51', null, null, '158', '113');
INSERT INTO `cs_user_answer` VALUES ('651', '51', null, null, '160', '114');
INSERT INTO `cs_user_answer` VALUES ('652', '51', null, null, '164', '115');
INSERT INTO `cs_user_answer` VALUES ('653', '51', null, null, '168', '116');
INSERT INTO `cs_user_answer` VALUES ('654', '51', null, null, '170', '117');
INSERT INTO `cs_user_answer` VALUES ('655', '51', null, null, '174', '118');
INSERT INTO `cs_user_answer` VALUES ('656', '51', null, null, '177', '119');
INSERT INTO `cs_user_answer` VALUES ('657', '51', null, null, '180', '120');
INSERT INTO `cs_user_answer` VALUES ('658', '51', null, null, '186', '121');
INSERT INTO `cs_user_answer` VALUES ('659', '51', null, null, '188', '122');
INSERT INTO `cs_user_answer` VALUES ('660', '51', null, null, '190', '123');
INSERT INTO `cs_user_answer` VALUES ('661', '51', null, null, '193', '124');
INSERT INTO `cs_user_answer` VALUES ('662', '51', null, null, '196', '125');
INSERT INTO `cs_user_answer` VALUES ('663', '51', null, null, '217', '126');
INSERT INTO `cs_user_answer` VALUES ('664', '51', null, null, '202', '127');
INSERT INTO `cs_user_answer` VALUES ('665', '51', null, null, '206', '128');
INSERT INTO `cs_user_answer` VALUES ('666', '51', null, null, '212', '129');
INSERT INTO `cs_user_answer` VALUES ('667', '51', null, null, '214', '130');
INSERT INTO `cs_user_answer` VALUES ('668', '52', null, null, '171', '131');
INSERT INTO `cs_user_answer` VALUES ('669', '52', null, null, '70', '132');
INSERT INTO `cs_user_answer` VALUES ('670', '52', null, null, '6', '110');
INSERT INTO `cs_user_answer` VALUES ('671', '52', null, null, '6', '111');
INSERT INTO `cs_user_answer` VALUES ('672', '52', null, null, '6', '112');
INSERT INTO `cs_user_answer` VALUES ('673', '52', null, null, '158', '113');
INSERT INTO `cs_user_answer` VALUES ('674', '52', null, null, '161', '114');
INSERT INTO `cs_user_answer` VALUES ('675', '52', null, null, '164', '115');
INSERT INTO `cs_user_answer` VALUES ('676', '52', null, null, '168', '116');
INSERT INTO `cs_user_answer` VALUES ('677', '52', null, null, '171', '117');
INSERT INTO `cs_user_answer` VALUES ('678', '52', null, null, '175', '118');
INSERT INTO `cs_user_answer` VALUES ('679', '52', null, null, '177', '119');
INSERT INTO `cs_user_answer` VALUES ('680', '52', null, null, '179', '120');
INSERT INTO `cs_user_answer` VALUES ('681', '52', null, null, '186', '121');
INSERT INTO `cs_user_answer` VALUES ('682', '52', null, null, '188', '122');
INSERT INTO `cs_user_answer` VALUES ('683', '52', null, null, '190', '123');
INSERT INTO `cs_user_answer` VALUES ('684', '52', null, null, '194', '124');
INSERT INTO `cs_user_answer` VALUES ('685', '52', null, null, '198', '125');
INSERT INTO `cs_user_answer` VALUES ('686', '52', null, null, '218', '126');
INSERT INTO `cs_user_answer` VALUES ('687', '52', null, null, '203', '127');
INSERT INTO `cs_user_answer` VALUES ('688', '52', null, null, '209', '128');
INSERT INTO `cs_user_answer` VALUES ('689', '52', null, null, '212', '129');
INSERT INTO `cs_user_answer` VALUES ('690', '52', null, null, '215', '130');
INSERT INTO `cs_user_answer` VALUES ('691', '53', null, null, '171', '131');
INSERT INTO `cs_user_answer` VALUES ('692', '53', null, null, '70', '132');
INSERT INTO `cs_user_answer` VALUES ('693', '53', null, null, '7', '110');
INSERT INTO `cs_user_answer` VALUES ('694', '53', null, null, '7', '111');
INSERT INTO `cs_user_answer` VALUES ('695', '53', null, null, '7', '112');
INSERT INTO `cs_user_answer` VALUES ('696', '53', null, null, '159', '113');
INSERT INTO `cs_user_answer` VALUES ('697', '53', null, null, '162', '114');
INSERT INTO `cs_user_answer` VALUES ('698', '53', null, null, '166', '115');
INSERT INTO `cs_user_answer` VALUES ('699', '53', null, null, '168', '116');
INSERT INTO `cs_user_answer` VALUES ('700', '53', null, null, '172', '117');
INSERT INTO `cs_user_answer` VALUES ('701', '53', null, null, '176', '118');
INSERT INTO `cs_user_answer` VALUES ('702', '53', null, null, '178', '119');
INSERT INTO `cs_user_answer` VALUES ('703', '53', null, null, '180', '120');
INSERT INTO `cs_user_answer` VALUES ('704', '53', null, null, '187', '121');
INSERT INTO `cs_user_answer` VALUES ('705', '53', null, null, '189', '122');
INSERT INTO `cs_user_answer` VALUES ('706', '53', null, null, '192', '123');
INSERT INTO `cs_user_answer` VALUES ('707', '53', null, null, '195', '124');
INSERT INTO `cs_user_answer` VALUES ('708', '53', null, null, '197', '125');
INSERT INTO `cs_user_answer` VALUES ('709', '53', null, null, '217', '126');
INSERT INTO `cs_user_answer` VALUES ('710', '53', null, null, '204', '127');
INSERT INTO `cs_user_answer` VALUES ('711', '53', null, null, '207', '128');
INSERT INTO `cs_user_answer` VALUES ('712', '53', null, null, '212', '129');
INSERT INTO `cs_user_answer` VALUES ('713', '53', null, null, '215', '130');
INSERT INTO `cs_user_answer` VALUES ('714', '54', null, null, '171', '131');
INSERT INTO `cs_user_answer` VALUES ('715', '54', null, null, '70', '132');
INSERT INTO `cs_user_answer` VALUES ('716', '54', null, null, '8', '110');
INSERT INTO `cs_user_answer` VALUES ('717', '54', null, null, '8', '111');
INSERT INTO `cs_user_answer` VALUES ('718', '54', null, null, '8', '112');
INSERT INTO `cs_user_answer` VALUES ('719', '54', null, null, '158', '113');
INSERT INTO `cs_user_answer` VALUES ('720', '54', null, null, '161', '114');
INSERT INTO `cs_user_answer` VALUES ('721', '54', null, null, '166', '115');
INSERT INTO `cs_user_answer` VALUES ('722', '54', null, null, '169', '116');
INSERT INTO `cs_user_answer` VALUES ('723', '54', null, null, '172', '117');
INSERT INTO `cs_user_answer` VALUES ('724', '54', null, null, '176', '118');
INSERT INTO `cs_user_answer` VALUES ('725', '54', null, null, '178', '119');
INSERT INTO `cs_user_answer` VALUES ('726', '54', null, null, '182', '120');
INSERT INTO `cs_user_answer` VALUES ('727', '54', null, null, '187', '121');
INSERT INTO `cs_user_answer` VALUES ('728', '54', null, null, '189', '122');
INSERT INTO `cs_user_answer` VALUES ('729', '54', null, null, '191', '123');
INSERT INTO `cs_user_answer` VALUES ('730', '54', null, null, '195', '124');
INSERT INTO `cs_user_answer` VALUES ('731', '54', null, null, '198', '125');
INSERT INTO `cs_user_answer` VALUES ('732', '54', null, null, '218', '126');
INSERT INTO `cs_user_answer` VALUES ('733', '54', null, null, '204', '127');
INSERT INTO `cs_user_answer` VALUES ('734', '54', null, null, '208', '128');
INSERT INTO `cs_user_answer` VALUES ('735', '54', null, null, '212', '129');
INSERT INTO `cs_user_answer` VALUES ('736', '54', null, null, '215', '130');
INSERT INTO `cs_user_answer` VALUES ('737', '55', null, null, '171', '131');
INSERT INTO `cs_user_answer` VALUES ('738', '55', null, null, '70', '132');
INSERT INTO `cs_user_answer` VALUES ('739', '55', null, null, '9', '110');
INSERT INTO `cs_user_answer` VALUES ('740', '55', null, null, '9', '111');
INSERT INTO `cs_user_answer` VALUES ('741', '55', null, null, '9', '112');
INSERT INTO `cs_user_answer` VALUES ('742', '55', null, null, '159', '113');
INSERT INTO `cs_user_answer` VALUES ('743', '55', null, null, '161', '114');
INSERT INTO `cs_user_answer` VALUES ('744', '55', null, null, '165', '115');
INSERT INTO `cs_user_answer` VALUES ('745', '55', null, null, '169', '116');
INSERT INTO `cs_user_answer` VALUES ('746', '55', null, null, '172', '117');
INSERT INTO `cs_user_answer` VALUES ('747', '55', null, null, '176', '118');
INSERT INTO `cs_user_answer` VALUES ('748', '55', null, null, '178', '119');
INSERT INTO `cs_user_answer` VALUES ('749', '55', null, null, '181', '120');
INSERT INTO `cs_user_answer` VALUES ('750', '55', null, null, '187', '121');
INSERT INTO `cs_user_answer` VALUES ('751', '55', null, null, '189', '122');
INSERT INTO `cs_user_answer` VALUES ('752', '55', null, null, '192', '123');
INSERT INTO `cs_user_answer` VALUES ('753', '55', null, null, '195', '124');
INSERT INTO `cs_user_answer` VALUES ('754', '55', null, null, '198', '125');
INSERT INTO `cs_user_answer` VALUES ('755', '55', null, null, '217', '126');
INSERT INTO `cs_user_answer` VALUES ('756', '55', null, null, '204', '127');
INSERT INTO `cs_user_answer` VALUES ('757', '55', null, null, '207', '128');
INSERT INTO `cs_user_answer` VALUES ('758', '55', null, null, '212', '129');
INSERT INTO `cs_user_answer` VALUES ('759', '55', null, null, '215', '130');
INSERT INTO `cs_user_answer` VALUES ('760', '56', null, null, '171', '131');
INSERT INTO `cs_user_answer` VALUES ('761', '56', null, null, '70', '132');
INSERT INTO `cs_user_answer` VALUES ('762', '56', null, null, '11', '110');
INSERT INTO `cs_user_answer` VALUES ('763', '56', null, null, '11', '111');
INSERT INTO `cs_user_answer` VALUES ('764', '56', null, null, '11', '112');
INSERT INTO `cs_user_answer` VALUES ('765', '56', null, null, '158', '113');
INSERT INTO `cs_user_answer` VALUES ('766', '56', null, null, '161', '114');
INSERT INTO `cs_user_answer` VALUES ('767', '56', null, null, '165', '115');
INSERT INTO `cs_user_answer` VALUES ('768', '56', null, null, '168', '116');
INSERT INTO `cs_user_answer` VALUES ('769', '56', null, null, '172', '117');
INSERT INTO `cs_user_answer` VALUES ('770', '56', null, null, '176', '118');
INSERT INTO `cs_user_answer` VALUES ('771', '56', null, null, '178', '119');
INSERT INTO `cs_user_answer` VALUES ('772', '56', null, null, '180', '120');
INSERT INTO `cs_user_answer` VALUES ('773', '56', null, null, '186', '121');
INSERT INTO `cs_user_answer` VALUES ('774', '56', null, null, '189', '122');
INSERT INTO `cs_user_answer` VALUES ('775', '56', null, null, '191', '123');
INSERT INTO `cs_user_answer` VALUES ('776', '56', null, null, '194', '124');
INSERT INTO `cs_user_answer` VALUES ('777', '56', null, null, '198', '125');
INSERT INTO `cs_user_answer` VALUES ('778', '56', null, null, '218', '126');
INSERT INTO `cs_user_answer` VALUES ('779', '56', null, null, '204', '127');
INSERT INTO `cs_user_answer` VALUES ('780', '56', null, null, '206', '128');
INSERT INTO `cs_user_answer` VALUES ('781', '56', null, null, '211', '129');
INSERT INTO `cs_user_answer` VALUES ('782', '56', null, null, '214', '130');

-- ----------------------------
-- Table structure for cs_user_question
-- ----------------------------
DROP TABLE IF EXISTS `cs_user_question`;
CREATE TABLE `cs_user_question` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) DEFAULT NULL COMMENT '绑定用户id',
  `question_type` int(8) NOT NULL COMMENT '题型，1单选题，2多选题，3文本',
  `option` varchar(40) DEFAULT NULL COMMENT '选项',
  `content` varchar(250) DEFAULT NULL COMMENT '内容',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cs_user_question
-- ----------------------------

-- ----------------------------
-- Table structure for cs_user_questionnaire
-- ----------------------------
DROP TABLE IF EXISTS `cs_user_questionnaire`;
CREATE TABLE `cs_user_questionnaire` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_questionnaire` varchar(40) DEFAULT NULL COMMENT '问卷名字',
  `user_id` int(10) DEFAULT NULL COMMENT '用户id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cs_user_questionnaire
-- ----------------------------

-- ----------------------------
-- Procedure structure for wk
-- ----------------------------
DROP PROCEDURE IF EXISTS `wk`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `wk`()
begin
DECLARE ii,jj INT;
SELECT jj = MAX(id) FROM cs_gift_exchange_record;
set ii = 0;
while ii < 9 do
insert into cs_gift_exchange_record values (jj+1,'1705197amtljzb','1495195948',135,'cp136892',131443,'旅行系列',0,100,1,2,1495195498,0,NULL);
set ii = ii + 1;
end while;
end
;;
DELIMITER ;
