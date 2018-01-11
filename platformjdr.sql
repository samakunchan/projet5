-- phpMyAdmin SQL Dump
-- version 4.1.14.8
-- http://www.phpmyadmin.net
--
-- Client :  db717571479.db.1and1.com
-- Généré le :  Lun 08 Janvier 2018 à 00:27
-- Version du serveur :  5.5.58-0+deb7u1-log
-- Version de PHP :  5.4.45-0+deb7u11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `db717571479`
--

-- --------------------------------------------------------

--
-- Structure de la table `adverts`
--

CREATE TABLE IF NOT EXISTS `adverts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `dates` datetime NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=20 ;

--
-- Contenu de la table `adverts`
--

INSERT INTO `adverts` (`id`, `title`, `content`, `dates`, `url`) VALUES
(1, '1er message', 'Message de Samakunchan : Ceci est le 1er message de la page d''annonce', '2017-12-19 01:15:29', '1er-message'),
(4, 'Barack Obama', '<p><img src="src/images/source/37900128.jpg" width="400" height="400" /></p>', '2017-12-19 15:29:03', 'barack-obama'),
(8, 'ezfez', '<p>fezfezf</p>', '2017-12-20 18:12:37', 'ezfez'),
(9, 'Juste mettre les titres', '<p>Et pas le contenu dans la gestion des annonces</p>', '2017-12-20 23:12:48', 'juste-mettre-les-titres'),
(10, 'Bonjour', '<h1>Ecrire une annonce</h1>\r\n<h1>Ecrire une annonce</h1>', '2017-12-21 23:39:26', 'bonjour'),
(11, 'salut', '<h1>Ecrire une annonce</h1>', '2017-12-21 23:47:05', 'salut'),
(12, 'Bonjour', '<p>azdazdza</p>', '2017-12-21 23:47:50', 'bonjour'),
(13, 'dzad', '<p>zadaz</p>', '2017-12-21 23:47:59', 'dzad'),
(14, 'dzad', '<p>zadaz</p>', '2017-12-21 23:48:07', 'dzad'),
(15, 'dzdza', '<p>dzadzaezfe</p>', '2017-12-21 23:51:46', 'dzdza'),
(16, 'Test', '<p>Bonjour, ceci est une nouvelle annonce</p>\r\n<p>Sign&eacute; Samakunchan</p>', '2017-12-25 22:35:59', 'test'),
(18, 'Lancement du site', '<p>C''est partie.</p>\r\n<p>Je lance officiellement l''ouverture du site. A partir de ce moment, chaque mise &agrave; jour sera indiquer ici.</p>\r\n<p>Vous pouvez &eacute;videmment r&eacute;agir dans l''espace commentaire ci-dessous.</p>\r\n<p>En ce moment le travaille se fait sur le style du site.</p>\r\n<p><img src="src/images/source/37900128.jpg" alt="" width="400" height="400" /></p>\r\n<p style="text-align: right;">Samakunchan.</p>', '2017-12-31 11:02:42', 'lancement-du-site'),
(19, 'Publication en ligne', '<p>Bonjour,</p>\r\n<p>Aujourd''hui c''est la premi&egrave;re publication en ligne d''une annonce sur ce site.</p>\r\n<p>Certains test sont en train d''&ecirc;tre effectuer, pour que tout soit bien harmoniser.</p>\r\n<p>Merci de votre patience</p>\r\n<p style="text-align: right;">Samakunchan.</p>', '2018-01-04 10:21:59', 'publication-en-ligne');

-- --------------------------------------------------------

--
-- Structure de la table `booking`
--

CREATE TABLE IF NOT EXISTS `booking` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `booked` int(11) NOT NULL,
  `booking_title` varchar(255) DEFAULT NULL,
  `dates` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=108 ;

--
-- Contenu de la table `booking`
--

INSERT INTO `booking` (`id`, `user_id`, `booked`, `booking_title`, `dates`) VALUES
(94, 10, 45, 'Psycho Pass', '2017-12-29 18:35:57'),
(90, 10, 46, 'Star Citizen', '2017-12-29 18:32:58'),
(93, 10, 47, 'Elite Dangerous and more', '2017-12-29 18:35:43'),
(97, 2, 47, 'Elite Dangerous and more', '2017-12-29 18:36:57'),
(98, 2, 45, 'Psycho Pass', '2017-12-29 18:37:04'),
(106, 1, 46, 'Star Citizen', '2018-01-03 11:11:43');

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `urlCat` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

--
-- Contenu de la table `categories`
--

INSERT INTO `categories` (`id`, `cat_name`, `description`, `urlCat`) VALUES
(5, 'Aventures', '<p>On trouve dans cette cat&eacute;gorie tout les univers de types aventures :</p>\r\n<ul>\r\n<li>Chasse aux tr&eacute;sors</li>\r\n<li>Exploration</li>\r\n<li>ect...</li>\r\n</ul>', 'aventures'),
(6, 'Science-fiction', '<p>On trouve dans cette cat&eacute;gorie toutes les univers du types extraterrestre, les univers de robot ou de cyborg ect...</p>', 'science-fiction'),
(7, 'Manga', '<p>On trouve dans cette cat&eacute;gorie toutes les univers du types manga:</p>\r\n<ul>\r\n<li>One piece,</li>\r\n<li>Naruto,</li>\r\n<li>Psycho pass ect...</li>\r\n</ul>', 'manga'),
(9, 'One Shot', '<p>Il arrive parfois d''avoir au dernier moment un cr&eacute;neaux pour une partie. Cette cat&eacute;gorie est r&eacute;serv&eacute; &agrave; cette effet.</p>', 'one-shot');

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `dates` datetime NOT NULL,
  `art_id` int(11) DEFAULT NULL,
  `signals` tinyint(1) DEFAULT NULL,
  `nb_com` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=36 ;

--
-- Contenu de la table `comments`
--

INSERT INTO `comments` (`id`, `author`, `content`, `dates`, `art_id`, `signals`, `nb_com`) VALUES
(18, 'admin', '<p>c''est parti</p>', '2017-12-25 22:35:27', 15, NULL, NULL),
(19, 'admin', '<p>Youpi :)</p>', '2017-12-25 22:37:18', 16, 2, NULL),
(20, 'admin', '<p>Un autre commentaire</p>', '2017-12-26 18:59:29', 16, 2, NULL),
(27, 'admin', '<p>ezfezf</p>', '2017-12-28 01:29:00', 16, 2, NULL),
(32, 'Samakunchan', '<p>Super l''&eacute;criture!!</p>', '2017-12-31 12:42:29', 18, NULL, NULL),
(33, 'Samakunchan', '<p>Je test la partie commentaire en ligne aussi</p>\r\n<p><img src="src/images/source/school_rumble_tsukamoto_tenma_close-up_view_30159_2048x1152.jpg" alt="" width="140" height="78" /></p>', '2018-01-04 10:22:26', 19, NULL, NULL),
(35, 'Samakunchan', '<p>un commentaire</p>', '2018-01-04 10:35:11', 19, 2, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `dialog`
--

CREATE TABLE IF NOT EXISTS `dialog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `content` text COLLATE latin1_general_ci NOT NULL,
  `dates` datetime NOT NULL,
  `party_id` int(11) DEFAULT NULL,
  `signals` int(11) DEFAULT NULL,
  `nb_com` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=6 ;

--
-- Contenu de la table `dialog`
--

INSERT INTO `dialog` (`id`, `author`, `content`, `dates`, `party_id`, `signals`, `nb_com`) VALUES
(1, 'Samakunchan', '<p>1er comment</p>', '2018-01-05 15:59:08', 48, 2, NULL),
(2, 'Samakunchan', '<p>2eme comment</p>', '2018-01-05 16:00:05', 48, 2, NULL),
(3, 'Samakunchan', '<p>un message</p>', '2018-01-05 18:07:13', 47, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `migration_versions`
--

CREATE TABLE IF NOT EXISTS `migration_versions` (
  `version` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `migration_versions`
--

INSERT INTO `migration_versions` (`version`) VALUES
('20171218204716'),
('20171218204826'),
('20171218210012'),
('20171218215525');

-- --------------------------------------------------------

--
-- Structure de la table `proposition_party`
--

CREATE TABLE IF NOT EXISTS `proposition_party` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `dates` datetime NOT NULL,
  `cat_id` int(11) DEFAULT NULL,
  `nb_players` int(11) DEFAULT NULL,
  `spot_max` int(11) DEFAULT NULL,
  `images` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `id_author` int(11) DEFAULT NULL,
  `name_author` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `signals` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=49 ;

--
-- Contenu de la table `proposition_party`
--

INSERT INTO `proposition_party` (`id`, `title`, `content`, `dates`, `cat_id`, `nb_players`, `spot_max`, `images`, `url`, `id_author`, `name_author`, `signals`) VALUES
(7, 'Le loup', '<p>Restabat ut Caesar post haec properaret accitus et abstergendae causa suspicionis sororem suam, eius uxorem, Constantius ad se tandem desideratam venire multis fictisque blanditiis hortabatur. quae licet ambigeret metuens saepe cruentum, spe tamen quod eum lenire poterit ut germanum profecta, cum Bithyniam introisset, in statione quae Caenos Gallicanos appellatur, absumpta est vi febrium repentina. cuius post obitum maritus contemplans cecidisse fiduciam qua se fultum existimabat, anxia cogitatione, quid moliretur haerebat. Non ergo erunt homines deliciis diffluentes audiendi, si quando de amicitia, quam nec usu nec ratione habent cognitam, disputabunt. Nam quis est, pro deorum fidem atque hominum! qui velit, ut neque diligat quemquam nec ipse ab ullo diligatur, circumfluere omnibus copiis atque in omnium rerum abundantia vivere? Haec enim est tyrannorum vita nimirum, in qua nulla fides, nulla caritas, nulla stabilis benevolentiae potest esse fiducia, omnia semper suspecta atque sollicita, nullus locus amicitiae. Quis enim aut eum diligat quem metuat, aut eum a quo se metui putet? Coluntur tamen simulatione dumtaxat ad tempus. Quod si forte, ut fit plerumque, ceciderunt, tum intellegitur quam fuerint inopes amicorum. Quod Tarquinium dixisse ferunt, tum exsulantem se intellexisse quos fidos amicos habuisset, quos infidos, cum iam neutris gratiam referre posset.</p>', '2017-12-20 23:06:44', 5, NULL, 5, 'default.png', 'le-loup', 1, 'Samakunchan', 0),
(8, 'Le bon la brute et le truand', '<p>222Restabat ut Caesar post haec properaret accitus et abstergendae causa suspicionis sororem suam, eius uxorem, Constantius ad se tandem desideratam venire multis fictisque blanditiis hortabatur. quae licet ambigeret metuens saepe cruentum, spe tamen quod eum lenire poterit ut germanum profecta, cum Bithyniam introisset, in statione quae Caenos Gallicanos appellatur, absumpta est vi febrium repentina. cuius post obitum maritus contemplans cecidisse fiduciam qua se fultum existimabat, anxia cogitatione, quid moliretur haerebat. Non ergo erunt homines deliciis diffluentes audiendi, si quando de amicitia, quam nec usu nec ratione habent cognitam, disputabunt. Nam quis est, pro deorum fidem atque hominum! qui velit, ut neque diligat quemquam nec ipse ab ullo diligatur, circumfluere omnibus copiis atque in omnium rerum abundantia vivere? Haec enim est tyrannorum vita nimirum, in qua nulla fides, nulla caritas, nulla stabilis benevolentiae potest esse fiducia, omnia semper suspecta atque sollicita, nullus locus amicitiae. Quis enim aut eum diligat quem metuat, aut eum a quo se metui putet? Coluntur tamen simulatione dumtaxat ad tempus. Quod si forte, ut fit plerumque, ceciderunt, tum intellegitur quam fuerint inopes amicorum. Quod Tarquinium dixisse ferunt, tum exsulantem se intellexisse quos fidos amicos habuisset, quos infidos, cum iam neutris gratiam referre posset.</p>\r\n<p>Restabat ut Caesar post haec properaret accitus et abstergendae causa suspicionis sororem suam, eius uxorem, Constantius ad se tandem desideratam venire multis fictisque blanditiis hortabatur. quae licet ambigeret metuens saepe cruentum, spe tamen quod eum lenire poterit ut germanum profecta, cum Bithyniam introisset, in statione quae Caenos Gallicanos appellatur, absumpta est vi febrium repentina. cuius post obitum maritus contemplans cecidisse fiduciam qua se fultum existimabat, anxia cogitatione, quid moliretur haerebat. Non ergo erunt homines deliciis diffluentes audiendi, si quando de amicitia, quam nec usu nec ratione habent cognitam, disputabunt. Nam quis est, pro deorum fidem atque hominum! qui velit, ut neque diligat quemquam nec ipse ab ullo diligatur, circumfluere omnibus copiis atque in omnium rerum abundantia vivere? Haec enim est tyrannorum vita nimirum, in qua nulla fides, nulla caritas, nulla stabilis benevolentiae potest esse fiducia, omnia semper suspecta atque sollicita, nullus locus amicitiae. Quis enim aut eum diligat quem metuat, aut eum a quo se metui putet? Coluntur tamen simulatione dumtaxat ad tempus. Quod si forte, ut fit plerumque, ceciderunt, tum intellegitur quam fuerint inopes amicorum. Quod Tarquinium dixisse ferunt, tum exsulantem se intellexisse quos fidos amicos habuisset, quos infidos, cum iam neutris gratiam referre posset.</p>', '2017-12-20 23:07:12', 6, NULL, 3, 'default.png', 'le-bon-la-brute-et-le-truand', 1, 'Samakunchan', NULL),
(42, 'Salut les amis', '<p>Restabat ut Caesar post haec properaret accitus et abstergendae causa suspicionis sororem suam, eius uxorem, Constantius ad se tandem desideratam venire multis fictisque blanditiis hortabatur. quae licet ambigeret metuens saepe cruentum, spe tamen quod eum lenire poterit ut germanum profecta, cum Bithyniam introisset, in statione quae Caenos Gallicanos appellatur, absumpta est vi febrium repentina. cuius post obitum maritus contemplans cecidisse fiduciam qua se fultum existimabat, anxia cogitatione, quid moliretur haerebat. Non ergo erunt homines deliciis diffluentes audiendi, si quando de amicitia, quam nec usu nec ratione habent cognitam, disputabunt. Nam quis est, pro deorum fidem atque hominum! qui velit, ut neque diligat&nbsp;</p>', '2017-12-28 03:12:20', 5, NULL, 2, 'imageParty2.gif', 'salut-les-amis', 2, 'cedric', 0),
(44, 'One piece', '<p>333Restabat ut Caesar post haec properaret accitus et abstergendae causa suspicionis sororem suam, eius uxorem, Constantius ad se tandem desideratam venire multis fictisque blanditiis hortabatur. quae licet ambigeret metuens saepe cruentum, spe tamen quod eum lenire poterit ut germanum profecta, cum Bithyniam introisset, in statione quae Caenos Gallicanos appellatur, absumpta est vi febrium repentina. cuius post obitum maritus contemplans cecidisse fiduciam qua se fultum existimabat, anxia cogitatione, quid moliretur haerebat. Non ergo erunt homines deliciis diffluentes audiendi, si quando de amicitia, quam nec usu nec ratione habent cognitam, disputabunt. Nam quis est, pro deorum fidem atque hominum! qui velit, ut neque diligat quemquam nec ipse ab ullo diligatur, circumfluere omnibus copiis atque in omnium rerum abundantia vivere? Haec enim est tyrannorum vita nimirum, in qua nulla fides, nulla caritas, nulla stabilis benevolentiae potest esse fiducia, omnia semper suspecta atque sollicita, nullus locus amicitiae. Quis enim aut eum diligat quem metuat, aut eum a quo se metui putet? Coluntur tamen simulatione dumtaxat ad tempus. Quod si forte, ut fit plerumque, ceciderunt, tum intellegitur quam fuerint inopes amicorum. Quod Tarquinium dixisse ferunt, tum exsulantem se intellexisse quos fidos amicos habuisset, quos infidos, cum iam neutris gratiam referre posset.</p>\r\n<p>333Restabat ut Caesar post haec properaret accitus et abstergendae causa suspicionis sororem suam, eius uxorem, Constantius ad se tandem desideratam venire multis fictisque blanditiis hortabatur. quae licet ambigeret metuens saepe cruentum, spe tamen quod eum lenire poterit ut germanum profecta, cum Bithyniam introisset, in statione quae Caenos Gallicanos appellatur, absumpta est vi febrium repentina. cuius post obitum maritus contemplans cecidisse fiduciam qua se fultum existimabat, anxia cogitatione, quid moliretur haerebat. Non ergo erunt homines deliciis diffluentes audiendi, si quando de amicitia, quam nec usu nec ratione habent cognitam, disputabunt. Nam quis est, pro deorum fidem atque hominum! qui velit, ut neque diligat quemquam nec ipse ab ullo diligatur, circumfluere omnibus copiis atque in omnium rerum abundantia vivere? Haec enim est tyrannorum vita nimirum, in qua nulla fides, nulla caritas, nulla stabilis benevolentiae potest esse fiducia, omnia semper suspecta atque sollicita, nullus locus amicitiae. Quis enim aut eum diligat quem metuat, aut eum a quo se metui putet? Coluntur tamen simulatione dumtaxat ad tempus. Quod si forte, ut fit plerumque, ceciderunt, tum intellegitur quam fuerint inopes amicorum. Quod Tarquinium dixisse ferunt, tum exsulantem se intellexisse quos fidos amicos habuisset, quos infidos, cum iam neutris gratiam referre posset.</p>', '2017-12-28 03:51:22', 7, NULL, 5, 'default.png', 'one-piece', 1, 'Samakunchan', NULL),
(45, 'Psycho Pass', '<p>333Restabat ut Caesar post haec properaret accitus et abstergendae causa suspicionis sororem suam, eius uxorem, Constantius ad se tandem desideratam venire multis fictisque blanditiis hortabatur. quae licet ambigeret metuens saepe cruentum, spe tamen quod eum lenire poterit ut germanum profecta, cum Bithyniam introisset, in statione quae Caenos Gallicanos appellatur, absumpta est vi febrium repentina. cuius post obitum maritus contemplans cecidisse fiduciam qua se fultum existimabat, anxia cogitatione, quid moliretur haerebat. Non ergo erunt homines deliciis diffluentes audiendi, si quando de amicitia, quam nec usu nec ratione habent cognitam, disputabunt. Nam quis est, pro deorum fidem atque hominum! qui velit, ut neque diligat quemquam nec ipse ab ullo diligatur, circumfluere omnibus copiis atque in omnium rerum abundantia vivere? Haec enim est tyrannorum vita nimirum, in qua nulla fides, nulla caritas, nulla stabilis benevolentiae potest esse fiducia, omnia semper suspecta atque sollicita, nullus locus amicitiae. Quis enim aut eum diligat quem metuat, aut eum a quo se metui putet? Coluntur tamen simulatione dumtaxat ad tempus. Quod si forte, ut fit plerumque, ceciderunt, tum intellegitur quam fuerint inopes amicorum. Quod Tarquinium dixisse ferunt, tum exsulantem se intellexisse quos fidos amicos habuisset, quos infidos, cum iam neutris gratiam referre posset.</p>', '2017-12-28 03:51:41', 5, NULL, 4, 'default.png', 'psycho-pass', 1, 'Samakunchan', NULL),
(46, 'Star Citizen', '<p>33Restabat ut Caesar post haec properaret accitus et abstergendae causa suspicionis sororem suam, eius uxorem, Constantius ad se tandem desideratam venire multis fictisque blanditiis hortabatur. quae licet ambigeret metuens saepe cruentum, spe tamen quod eum lenire poterit ut germanum profecta, cum Bithyniam introisset, in statione quae Caenos Gallicanos appellatur, absumpta est vi febrium repentina. cuius post obitum maritus contemplans cecidisse fiduciam qua se fultum existimabat, anxia cogitatione, quid moliretur haerebat. Non ergo erunt homines deliciis diffluentes audiendi, si quando de amicitia, quam nec usu nec ratione habent cognitam, disputabunt. Nam quis est, pro deorum fidem atque.</p>\r\n<p>33Restabat ut Caesar post haec properaret accitus et abstergendae causa suspicionis sororem suam, eius uxorem, Constantius ad se tandem desideratam venire multis fictisque blanditiis hortabatur. quae licet ambigeret metuens saepe cruentum, spe tamen quod eum lenire poterit ut germanum profecta, cum Bithyniam introisset, in statione quae Caenos Gallicanos appellatur, absumpta est vi febrium repentina. cuius post obitum maritus contemplans cecidisse fiduciam qua se fultum existimabat, anxia cogitatione, quid moliretur haerebat. Non ergo erunt homines deliciis diffluentes audiendi, si quando de amicitia, quam nec usu nec ratione habent cognitam, disputabunt. Nam quis est, pro deorum fidem atque&nbsp;</p>', '2017-12-28 09:22:17', 6, NULL, 5, 'imageParty9.jpg', 'star-citizen', 9, 'fred', NULL),
(47, 'Elite Dangerous and more', '<p>Restabat ut Caesar post haec properaret accitus et abstergendae causa suspicionis sororem suam, eius uxorem, Constantius ad se tandem desideratam venire multis fictisque blanditiis hortabatur. quae licet ambigeret metuens saepe cruentum, spe tamen quod eum lenire poterit ut germanum profecta, cum Bithyniam introisset, in statione quae Caenos Gallicanos appellatur, absumpta est vi febrium repentina. cuius post obitum maritus contemplans cecidisse fiduciam qua se fultum existimabat, anxia cogitatione, quid moliretur haerebat. Non ergo erunt homines deliciis diffluentes audiendi, si quando de amicitia, quam nec usu nec ratione habent cognitam, disputabunt. Nam quis est, pro deorum fidem atque hominum! qui velit, ut neque diligat quemquam nec ipse ab&nbsp;</p>', '2017-12-29 03:01:30', 5, NULL, 2, 'imageParty1.jpg', 'elite-dangerous-and-more', 1, 'Samakunchan', 0),
(48, 'Party test', '<p>Date</p>', '2018-01-04 16:59:26', 9, NULL, 2, 'default.png', 'party-test', 1, 'Samakunchan', 0);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dates` datetime NOT NULL,
  `lasted_date` datetime DEFAULT NULL,
  `roles` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_1483A5E9F85E0677` (`username`),
  UNIQUE KEY `UNIQ_1483A5E9E7927C74` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=15 ;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `fullname`, `username`, `email`, `password`, `dates`, `lasted_date`, `roles`, `is_active`, `avatar`) VALUES
(1, 'Samakunchan', 'admin', 'admin@gmail.fr', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '2017-12-18 21:49:15', NULL, 'ROLE_ADMIN', 1, '1.jpg'),
(2, 'cedric', 'client', 'client@gmail.fr', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '2017-12-19 00:13:44', NULL, 'ROLE_MODO', 1, '1.png'),
(8, 'seb', 'seb', 'seb@gmail.fr', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '2017-12-22 18:07:49', NULL, 'ROLE_USER', 1, '1.png'),
(9, 'fred', 'fred', 'fred@mail.fr', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '2017-12-28 05:27:59', NULL, 'ROLE_USER', 1, '1.png'),
(10, 'harry', 'harry', 'harry@mail.fr', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '2017-12-28 05:38:44', NULL, 'ROLE_USER', 1, '1.png'),
(12, 'Jotaro', 'jojo', 'jojo@mail.fr', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '2017-12-30 03:24:17', NULL, 'ROLE_USER', 1, '1.png'),
(14, 'Benoit', 'ben', 'ben@mail.fr', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', '2018-01-05 19:27:47', NULL, 'ROLE_USER', 1, '1.png');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
