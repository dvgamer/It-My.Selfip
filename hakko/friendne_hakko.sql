-- phpMyAdmin SQL Dump
-- version 3.3.8.1
-- http://www.phpmyadmin.net
--
-- โฮสต์: localhost
-- เวลาในการสร้าง: 08 ก.พ. 2011  04:02น.
-- รุ่นของเซิร์ฟเวอร์: 5.0.91
-- รุ่นของ PHP: 5.2.16

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- ฐานข้อมูล: `friendne_hakko`
--

-- --------------------------------------------------------

--
-- โครงสร้างตาราง `hak_component`
--

CREATE TABLE IF NOT EXISTS `hak_component` (
  `com_id` int(10) NOT NULL auto_increment,
  `name` varchar(20) NOT NULL,
  `title` varchar(100) NOT NULL,
  PRIMARY KEY  (`com_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- dump ตาราง `hak_component`
--

INSERT INTO `hak_component` (`com_id`, `name`, `title`) VALUES
(1, 'frontpage', 'หน้าแรก'),
(2, 'content', 'บทความ'),
(3, 'translator', 'มังงะ');

-- --------------------------------------------------------

--
-- โครงสร้างตาราง `hak_content`
--

CREATE TABLE IF NOT EXISTS `hak_content` (
  `con_id` int(10) NOT NULL auto_increment,
  `uid` int(15) NOT NULL,
  `image` varchar(36) NOT NULL,
  `title` varchar(100) NOT NULL,
  `pretext` text NOT NULL,
  `fulltext` text NOT NULL,
  `created` int(15) NOT NULL,
  PRIMARY KEY  (`con_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- dump ตาราง `hak_content`
--

INSERT INTO `hak_content` (`con_id`, `uid`, `image`, `title`, `pretext`, `fulltext`, `created`) VALUES
(1, 1113031282, 'f517ca34951b59a683c6f6e1abb7bd47.jpg', 'เริ่มต้นสร้างเกม Ghost Legends ', 'อย่างที่บอกละมันคือการเริ่มต้น... ดังคำกล่าวที่ว่า [b]"ไม่มีประวัติศาสตร์ใดเกิดขึ้นเองได้ตามธรรมชาติหรอก"[/b] เท่าที่คิดๆ ไว้ก็แค่เป้นเกมผจญภัยวิ่งๆ ฟันๆ เท่านั้นละ ยังไม่รู้เหมือนกันว่าจะไปไหวหรือป่าว แต่ก็[u]อยากทำ[/u]อะนะ งั้นก้ไปเตรียมอุปรณ์ทำเกมกันก่อนละกัน', 'ภาษาที่ใช้ก็คงภาษา C# โดยใช้ Framework XNA 4.0 ดูจะง่ายสุดละมั้ง เออและ ต้องมี Visual C# ด้วยนะ ผมใช้ 2010 Express for Window Phone มันเบาดีนะ (XNA 4.0 ต้องติดตั้งกับ Visual 2010 เท่านั้นนะ) [center][img=หน้าตาโปรแกรม]VisualCSharp.jpg[/img][/center] เอาละผมก็มีงานที่เคยทำๆ ไว้แล้วอันนึงอะนะ ว่าจะเอามาใช้เป็น หน้า Title ก่อนเข้าเกมนะ มันชัดกว่านี้อะนะโดนเว็บ drop คุณภาพลงไปซะเยอะเลย กว่าจะเสร็จก็ผ่านไป 8 - 9 ชม. มั้ง ไม่ได้ออกแบบเองซะด้วยสิ จำเค้ามาทำอีกทีนึง...\r\n[clip]1567259257402[/clip] หลังจากที่เราได้ Title Game มาแล้วนะ 55+ มาดู Resource อื่นๆ บ้างดีกว่า เริ่มจาก...[center][img=พื้นหลังเกม]Blue.jpg[/img][br][img=Cursor]Cursor2.png[/img][img=ตัวอย่างปุ่มหน้าเมนูเกม]StartGame.png[/img][br][img=Effect เวลาโดนฟัน]Slash-Blade.png[/img][/center] เมื่อเราก็ได้ทรัพยากรในการสร้างเกมมาพอสมควรแล้วไว้โอกาสหน้าจะเอาผลมาได้ชมกันนะครับ... \r\n', 1294020306);

-- --------------------------------------------------------

--
-- โครงสร้างตาราง `hak_group_author`
--

CREATE TABLE IF NOT EXISTS `hak_group_author` (
  `mag_id` int(10) NOT NULL,
  `aut_id` int(10) NOT NULL,
  PRIMARY KEY  (`mag_id`,`aut_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- dump ตาราง `hak_group_author`
--

INSERT INTO `hak_group_author` (`mag_id`, `aut_id`) VALUES
(1, 1),
(2, 2),
(2, 3);

-- --------------------------------------------------------

--
-- โครงสร้างตาราง `hak_group_genre`
--

CREATE TABLE IF NOT EXISTS `hak_group_genre` (
  `mag_id` int(10) NOT NULL,
  `gen_id` int(10) NOT NULL,
  PRIMARY KEY  (`mag_id`,`gen_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- dump ตาราง `hak_group_genre`
--

INSERT INTO `hak_group_genre` (`mag_id`, `gen_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(2, 4),
(2, 6),
(2, 7),
(2, 8),
(2, 9);

-- --------------------------------------------------------

--
-- โครงสร้างตาราง `hak_manga`
--

CREATE TABLE IF NOT EXISTS `hak_manga` (
  `mag_id` int(10) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL,
  `status` varchar(20) NOT NULL,
  `link` text NOT NULL,
  `summary` text NOT NULL,
  `created` int(15) NOT NULL,
  `view` int(9) NOT NULL default '0',
  PRIMARY KEY  (`mag_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- dump ตาราง `hak_manga`
--

INSERT INTO `hak_manga` (`mag_id`, `name`, `status`, `link`, `summary`, `created`, `view`) VALUES
(1, 'Nana to Kaoru', 'OnGoing', 'http://apps.facebook.com/hakkomew/?component=translator&manga=Nana_to_Kaoru', 'คาโอรุ เด็กหนุ่มวัย 17 ผู้หลงใหลใน SM เเละฝันอยากจะเล่น SM กับนานะ เพื่อนตั้งเเต่สมัยเด็กมาโดยตลอด จนวันหนึ่ง เเม่เจอของสะสม SM ของเขา เพื่อเเก้เผ็ดเจ้าลูกตัวเเสบ จึงขอช่วยให้ นานะ เพื่อนสมัยเด็กของคาโอรุ เอาไปซ่อน เเต่ทว่า หนึ่งในของที่ฝากให้เอาไปซ่อนนั่น มี ชุดหนัง อยู่ด้วยด้วยความอยากรู้อยากเห็น นานะจึงลองสวมมันดู เเละด้วยอุบัติเหตุไม่คาดฝันทำให้ไม่สามารถถอดชุดออกได้ เรื่องวุ่นวายทั้งหมดจึงได้เริ่มต้นขึ้น...', 1296785332, 95),
(2, 'Tenkyuugi - Sephirahnatus', 'OnGoing', 'http://apps.facebook.com/hakkomew/?component=translator&manga=Tenkyuugi_-_Sephirahnatus', 'ในโลกที่มี 10 กฎแห่งสวรรค์ และ 22 กฎแห่งภิพบ ถึงแม้ว่ามนุษย์ไม่สามารถร่วงรู้ถึงกฎแห่งสวรรค์ที่พระเจ้าเป็นผู้ใช้ได้ แต่พวกเขาก็ใช้ประโยชน์จากกฎแห่งภิพบ เนื่องจากสัญลักษณ์แต่ละอันสามารถนำไปใช้เป็นตัวกลางผ่านการร่ายเวทย์  ซึ่งความสามารถเหล่านั้นจะถูกร่ายโดยนักเวทย์ นักเวทย์ที่ปราถนาที่จะเรียนรู้กฎจะต้องเข้าศึกษาในสถาบันเวทมนตร์[br][br][tab]นานาโอะ คิสะ และ เนนเท็น เป็นน้องใหม่ที่สมัครเรียนที่สถาบันศึกษาเวทมนตร์แห่งบุรพาที่เจ็ด ถึงแม้จะมีอยู่ถึง 22 กฎ แต่ก็มีความสามารถหายากอยู่ซึ่งนานาโอะเป็นผู้ครอบครองความสามารถนั้น และมันก็คือ....', 1296785405, 284);

-- --------------------------------------------------------

--
-- โครงสร้างตาราง `hak_manga_author`
--

CREATE TABLE IF NOT EXISTS `hak_manga_author` (
  `aut_id` int(10) NOT NULL auto_increment,
  `author_name` varchar(50) NOT NULL,
  PRIMARY KEY  (`aut_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- dump ตาราง `hak_manga_author`
--

INSERT INTO `hak_manga_author` (`aut_id`, `author_name`) VALUES
(1, 'AMAZUME Ryuta'),
(2, 'SENO Tatsune'),
(3, 'TAKAMIYA Aya');

-- --------------------------------------------------------

--
-- โครงสร้างตาราง `hak_manga_chapter`
--

CREATE TABLE IF NOT EXISTS `hak_manga_chapter` (
  `mag_id` int(10) NOT NULL,
  `list_id` varchar(5) NOT NULL,
  `trans_uid` int(15) NOT NULL,
  `chapter_name` varchar(50) NOT NULL,
  `created` int(15) NOT NULL,
  PRIMARY KEY  (`mag_id`,`list_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- dump ตาราง `hak_manga_chapter`
--

INSERT INTO `hak_manga_chapter` (`mag_id`, `list_id`, `trans_uid`, `chapter_name`, `created`) VALUES
(1, '1', 1113031282, 'ความฝันที่ห่อหุ้มด้วยหนังสัตว์', 1296785329),
(1, '2', 1113031282, 'การเจรจา', 1296785401),
(2, '1', 1113031282, 'สถาบันศึกษาเวทมนตร์แห่งบูรพาที่เจ็ด', 1296785514);

-- --------------------------------------------------------

--
-- โครงสร้างตาราง `hak_manga_genre`
--

CREATE TABLE IF NOT EXISTS `hak_manga_genre` (
  `gen_id` int(10) NOT NULL auto_increment,
  `genre_name` varchar(50) NOT NULL,
  PRIMARY KEY  (`gen_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- dump ตาราง `hak_manga_genre`
--

INSERT INTO `hak_manga_genre` (`gen_id`, `genre_name`) VALUES
(1, 'Mature'),
(2, 'Psychological'),
(3, 'Romance'),
(4, 'School Life'),
(5, 'Seinen'),
(6, 'Action'),
(7, 'Fantasy'),
(8, 'Josei'),
(9, 'Sci-fi');

-- --------------------------------------------------------

--
-- โครงสร้างตาราง `hak_module`
--

CREATE TABLE IF NOT EXISTS `hak_module` (
  `mod_id` int(10) NOT NULL auto_increment,
  `com_id` int(10) NOT NULL,
  `pos_id` int(10) NOT NULL,
  `public` int(1) NOT NULL default '1',
  `name` varchar(50) NOT NULL,
  `title` varchar(200) NOT NULL,
  `order_list` int(2) NOT NULL default '0',
  PRIMARY KEY  (`mod_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- dump ตาราง `hak_module`
--

INSERT INTO `hak_module` (`mod_id`, `com_id`, `pos_id`, `public`, `name`, `title`, `order_list`) VALUES
(1, 1, 3, 0, 'connect_facebook.php', 'เข้าสู่ระบบ', 0),
(2, 1, 5, 0, 'manga_silder.php', 'Slider Manga', 0),
(3, 1, 3, 0, 'lasttopics_board.php', 'หัวข้อกระทู้ล่าสุด', 2),
(4, 1, 3, 1, 'manga_list.php', 'มังงะ', 1),
(5, 1, 3, 1, 'user_support.php', 'สนับสนุนโดย', 3),
(6, 3, 4, 0, 'manga_allchapter.php', 'ตอนที่', 0);

-- --------------------------------------------------------

--
-- โครงสร้างตาราง `hak_position`
--

CREATE TABLE IF NOT EXISTS `hak_position` (
  `pos_id` int(10) NOT NULL auto_increment,
  `name` varchar(20) NOT NULL,
  PRIMARY KEY  (`pos_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- dump ตาราง `hak_position`
--

INSERT INTO `hak_position` (`pos_id`, `name`) VALUES
(1, 'head'),
(2, 'body'),
(3, 'left'),
(4, 'right'),
(5, 'user1'),
(6, 'user2');

-- --------------------------------------------------------

--
-- โครงสร้างตาราง `hak_user`
--

CREATE TABLE IF NOT EXISTS `hak_user` (
  `uid` int(15) NOT NULL,
  `user` varchar(50) NOT NULL,
  `class_id` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `block` int(1) NOT NULL default '0',
  PRIMARY KEY  (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- dump ตาราง `hak_user`
--

INSERT INTO `hak_user` (`uid`, `user`, `class_id`, `name`, `block`) VALUES
(1113031282, 'dvgamer', 2, 'HaKkoMEw', 0),
(1230004898, 'CeeIsApilak', 2, 'สนับสนุนพื้นที่ใน Server ', 0),
(1730739711, 'skhung.t.sing', 1, 'น้องสาว', 0),
(1244292699, 'marchexzero', 1, 'marchexzero', 0);

-- --------------------------------------------------------

--
-- โครงสร้างตาราง `hak_user_class`
--

CREATE TABLE IF NOT EXISTS `hak_user_class` (
  `class_id` int(10) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL,
  `title` varchar(100) NOT NULL,
  PRIMARY KEY  (`class_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- dump ตาราง `hak_user_class`
--

INSERT INTO `hak_user_class` (`class_id`, `name`, `title`) VALUES
(1, 'user', 'ผู้ใช้ทั่วไป'),
(2, 'donate', 'ผู้สนับสนุน'),
(3, 'translator', 'นักแปล');

-- --------------------------------------------------------

--
-- โครงสร้างตาราง `hak_user_online`
--

CREATE TABLE IF NOT EXISTS `hak_user_online` (
  `expires` int(12) NOT NULL,
  `uid` int(15) NOT NULL,
  `mag_id` int(10) NOT NULL,
  `guest` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- dump ตาราง `hak_user_online`
--

INSERT INTO `hak_user_online` (`expires`, `uid`, `mag_id`, `guest`) VALUES
(1297116000, 1113031282, 1, 0);
