-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  jeu. 28 avr. 2022 à 05:59
-- Version du serveur :  5.7.26
-- Version de PHP :  7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `app_leave`
--

-- --------------------------------------------------------

--
-- Structure de la table `l_calendar`
--

DROP TABLE IF EXISTS `l_calendar`;
CREATE TABLE IF NOT EXISTS `l_calendar` (
  `id_calendar` int(11) NOT NULL AUTO_INCREMENT,
  `c_debut` date NOT NULL,
  `c_fin` date DEFAULT NULL,
  `c_description` varchar(250) NOT NULL,
  `c_flag` int(11) NOT NULL,
  PRIMARY KEY (`id_calendar`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `l_leave`
--

DROP TABLE IF EXISTS `l_leave`;
CREATE TABLE IF NOT EXISTS `l_leave` (
  `id_leave` int(11) NOT NULL AUTO_INCREMENT,
  `l_type` varchar(200) DEFAULT NULL,
  `l_dateDepart` datetime NOT NULL,
  `l_dateFin` datetime NOT NULL,
  `l_responsable` varchar(250) NOT NULL,
  `l_nbJpris` int(11) NOT NULL,
  `l_nbJrest` int(11) NOT NULL,
  `l_nbJdispo` int(11) NOT NULL,
  `l_statut` int(11) DEFAULT NULL,
  `l_archived` int(11) DEFAULT NULL,
  `l_dateAjout` datetime NOT NULL,
  `l_idUser` int(11) NOT NULL,
  PRIMARY KEY (`id_leave`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `l_params`
--

DROP TABLE IF EXISTS `l_params`;
CREATE TABLE IF NOT EXISTS `l_params` (
  `id_params` int(11) NOT NULL AUTO_INCREMENT,
  `param_code` varchar(50) DEFAULT NULL,
  `param_lib` varchar(100) DEFAULT NULL,
  `param_value` varchar(200) DEFAULT NULL,
  `param_section` int(11) NOT NULL,
  PRIMARY KEY (`id_params`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `l_params`
--

INSERT INTO `l_params` (`id_params`, `param_code`, `param_lib`, `param_value`, `param_section`) VALUES
(1, 'DOMAINE', 'Domaine', 'aveolys', 1),
(2, 'AD_IP', 'Adresse IP du serveur AD', '192.168.4.15', 1),
(3, 'GR_AD', 'Nom du groupe AD des utilisateurs habilités', 'cn=*', 1),
(4, 'DN_AC', 'Base DN (dc=domaine, dc=local)', 'OU=utilisateurs,OU=aveolys,DC=aveolys,DC=loc', 1),
(5, 'ADMIN_AD', 'Nom de l\'Administrateur AD', 'appli.rh', 1),
(6, 'PWD_AD', 'Mot de passe de l’administrateur AD', '@veoc0d', 1),
(7, 'LDAP_DOMLOCAL', 'Nom du domaine', 'aveolys.loc', 1),
(8, 'PORT_AD', 'Port LDAP', 'ldap', 1),
(9, 'SU_AD', 'Suffixe des comptes ad', '@aveolys.loc', 1),
(10, 'LDAP_TO_IMPORT', 'Filtre des utilisateurs à importé dans l\'application', '(&(objectClass=user))', 1),
(11, 'LDAP_GRP_DEFAULT', 'ID du groupe par défaut des utilisateurs importés ( 4 = invité)', '4', 1),
(12, 'email_type', 'Type', 'html', 2),
(13, 'email_protocol', 'Protocol', 'smtp', 2),
(14, 'email_host', 'Adresse smtp host', 'mail.iris.re', 2),
(15, 'email_user', 'Adresse utilisateur smtp', 'aveolys@aveolys.com', 2),
(16, 'email_password', 'Mot de passe', '@uthent974', 2),
(17, 'email_port', 'Port', '587', 2),
(18, 'email_sender', 'Adresse d\'expéditeur par défaut', 'aveolys@aveolys.com', 2),
(19, 'email_appname', 'Identication ou nom de l\'application', 'Appli Congé', 2),
(20, 'email_subject', 'Sujet du mail', 'Congé', 2),
(21, 'email_destinataire', 'Mail des destinataires (Doit être séparé de point-virgule \';\')', 'dimby@aveolys.com', 2);

-- --------------------------------------------------------

--
-- Structure de la table `l_service`
--

DROP TABLE IF EXISTS `l_service`;
CREATE TABLE IF NOT EXISTS `l_service` (
  `id_service` int(11) NOT NULL AUTO_INCREMENT,
  `s_label` varchar(250) NOT NULL,
  `s_description` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`id_service`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `l_user`
--

DROP TABLE IF EXISTS `l_user`;
CREATE TABLE IF NOT EXISTS `l_user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `u_pseudo` varchar(250) DEFAULT NULL,
  `u_nom` varchar(250) NOT NULL,
  `u_prenom` varchar(250) NOT NULL,
  `u_avatar` varchar(250) NOT NULL,
  `u_email` varchar(250) DEFAULT NULL,
  `u_password` varchar(250) DEFAULT NULL,
  `u_idService` int(11) NOT NULL,
  `u_reference` varchar(250) DEFAULT NULL,
  `u_dispo` int(11) DEFAULT NULL,
  `u_dispoYear` int(11) DEFAULT NULL,
  `u_archived` int(11) NOT NULL,
  `u_status` tinyint(1) NOT NULL,
  `u_profilId` int(11) NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=MyISAM AUTO_INCREMENT=52 DEFAULT CHARSET=latin1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
