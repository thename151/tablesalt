-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 28, 2013 at 12:03 AM
-- Server version: 5.6.14
-- PHP Version: 5.5.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `web7`
--

-- --------------------------------------------------------

--
-- Table structure for table `login1`
--

CREATE TABLE IF NOT EXISTS `login1` (
  `uniqueX` int(11) NOT NULL AUTO_INCREMENT,
  `loginName` varchar(25) NOT NULL,
  `loginTime` datetime NOT NULL,
  PRIMARY KEY (`uniqueX`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=446 ;

-- --------------------------------------------------------

--
-- Table structure for table `messages1`
--

CREATE TABLE IF NOT EXISTS `messages1` (
  `uniqueX` int(11) NOT NULL AUTO_INCREMENT,
  `from1` varchar(25) NOT NULL,
  `to1` varchar(25) NOT NULL,
  `message1` varchar(500) NOT NULL,
  `datetime` datetime NOT NULL,
  PRIMARY KEY (`uniqueX`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `priceview1`
--
CREATE TABLE IF NOT EXISTS `priceview1` (
`uniqueX` int(11)
,`creator1` varchar(25)
,`product1` varchar(40)
,`creator2` varchar(25)
,`product2` varchar(40)
,`price1` decimal(9,6)
,`ct` bigint(21)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `priceview5`
--
CREATE TABLE IF NOT EXISTS `priceview5` (
`uniqueX` int(11)
,`creator1` varchar(25)
,`product1` varchar(40)
,`creator2` varchar(25)
,`product2` varchar(40)
,`price2` decimal(9,6)
,`ct` bigint(21)
);
-- --------------------------------------------------------

--
-- Table structure for table `products1`
--

CREATE TABLE IF NOT EXISTS `products1` (
  `uniqueX` int(11) NOT NULL AUTO_INCREMENT,
  `productName` varchar(40) NOT NULL,
  `profileName` varchar(25) NOT NULL,
  `detail` varchar(500) NOT NULL,
  `status1` varchar(25) NOT NULL DEFAULT 'okay',
  `dateTime` datetime NOT NULL,
  PRIMARY KEY (`uniqueX`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=35 ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `pv01`
--
CREATE TABLE IF NOT EXISTS `pv01` (
`uniqueX` int(11)
,`creator1` varchar(25)
,`product1` varchar(40)
,`creator2` varchar(25)
,`product2` varchar(40)
,`price1` decimal(9,6)
,`ct` bigint(21)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `pv02`
--
CREATE TABLE IF NOT EXISTS `pv02` (
`uniqueX` int(11)
,`creator1` varchar(25)
,`product1` varchar(40)
,`creator2` varchar(25)
,`product2` varchar(40)
,`price2` decimal(9,6)
,`ct` bigint(21)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `pv1`
--
CREATE TABLE IF NOT EXISTS `pv1` (
`pvc1` varchar(25)
,`pvp1` varchar(40)
,`pvc2` varchar(25)
,`pvp2` varchar(40)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `pv2`
--
CREATE TABLE IF NOT EXISTS `pv2` (
`pvc1` varchar(25)
,`pvp1` varchar(40)
,`pvc2` varchar(25)
,`pvp2` varchar(40)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `pv3`
--
CREATE TABLE IF NOT EXISTS `pv3` (
`pvc1` varchar(25)
,`pvp1` varchar(40)
,`pvc2` varchar(25)
,`pvp2` varchar(40)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `pv4`
--
CREATE TABLE IF NOT EXISTS `pv4` (
`pvc1` varchar(25)
,`pvp1` varchar(40)
,`pvc2` varchar(25)
,`pvp2` varchar(40)
,`price1` decimal(9,6)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `pv5`
--
CREATE TABLE IF NOT EXISTS `pv5` (
`pvc1` varchar(25)
,`pvp1` varchar(40)
,`pvc2` varchar(25)
,`pvp2` varchar(40)
,`price1` decimal(9,6)
,`price2` decimal(9,6)
);
-- --------------------------------------------------------

--
-- Table structure for table `querylog`
--

CREATE TABLE IF NOT EXISTS `querylog` (
  `uniqueX` int(11) NOT NULL AUTO_INCREMENT,
  `theQuery` varchar(250) NOT NULL,
  `dateTime` datetime NOT NULL,
  PRIMARY KEY (`uniqueX`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT AUTO_INCREMENT=185 ;

-- --------------------------------------------------------

--
-- Table structure for table `sales3`
--

CREATE TABLE IF NOT EXISTS `sales3` (
  `uniqueX` int(11) NOT NULL AUTO_INCREMENT,
  `amount1` decimal(6,3) NOT NULL,
  `type1` varchar(25) NOT NULL,
  `stock` decimal(9,6) NOT NULL,
  `creator1` varchar(25) NOT NULL,
  `product1` varchar(40) NOT NULL,
  `creator2` varchar(25) NOT NULL,
  `product2` varchar(40) NOT NULL,
  `price1` decimal(9,6) NOT NULL,
  `price2` decimal(9,6) NOT NULL,
  `user` varchar(25) NOT NULL,
  `dateTime` datetime NOT NULL,
  `dateTime2` datetime NOT NULL,
  PRIMARY KEY (`uniqueX`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=565 ;

-- --------------------------------------------------------

--
-- Table structure for table `scores1`
--

CREATE TABLE IF NOT EXISTS `scores1` (
  `uniqueX` int(11) NOT NULL AUTO_INCREMENT,
  `who1` varchar(25) NOT NULL,
  `creator` varchar(25) NOT NULL,
  `product` varchar(40) NOT NULL,
  `amount` decimal(6,3) NOT NULL,
  PRIMARY KEY (`uniqueX`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=115 ;

-- --------------------------------------------------------

--
-- Table structure for table `sendreclog1`
--

CREATE TABLE IF NOT EXISTS `sendreclog1` (
  `uniqueX` int(11) NOT NULL AUTO_INCREMENT,
  `from1` varchar(25) NOT NULL,
  `to1` varchar(25) NOT NULL,
  `creator` varchar(25) NOT NULL,
  `product` varchar(40) NOT NULL,
  `amount` decimal(6,3) NOT NULL,
  `sendsort` varchar(25) NOT NULL,
  `dateLog` datetime NOT NULL,
  PRIMARY KEY (`uniqueX`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1168 ;

-- --------------------------------------------------------

--
-- Table structure for table `tradelog`
--

CREATE TABLE IF NOT EXISTS `tradelog` (
  `uniqueX` int(11) NOT NULL AUTO_INCREMENT,
  `odduser` varchar(25) NOT NULL,
  `wouldsend` decimal(10,9) NOT NULL,
  `doessend` decimal(4,3) NOT NULL,
  `trade1ux` int(11) NOT NULL,
  `user1` varchar(25) NOT NULL,
  `creator1` varchar(25) NOT NULL,
  `product1` varchar(40) NOT NULL,
  `amount1` decimal(6,3) NOT NULL,
  `price2` decimal(9,6) NOT NULL,
  `trade2ux` int(11) NOT NULL,
  `user2` varchar(25) NOT NULL,
  `creator2` varchar(25) NOT NULL,
  `product2` varchar(40) NOT NULL,
  `amount2` decimal(6,3) NOT NULL,
  `price1` decimal(9,6) NOT NULL,
  `dateTime` datetime NOT NULL,
  PRIMARY KEY (`uniqueX`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Table structure for table `users1`
--

CREATE TABLE IF NOT EXISTS `users1` (
  `uniqueX` int(11) NOT NULL AUTO_INCREMENT,
  `loginName` varchar(25) NOT NULL,
  `createDate` datetime NOT NULL,
  `hashword` varchar(255) NOT NULL,
  PRIMARY KEY (`uniqueX`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=55 ;

-- --------------------------------------------------------

--
-- Structure for view `priceview1`
--
DROP TABLE IF EXISTS `priceview1`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `priceview1` AS select `sales3`.`uniqueX` AS `uniqueX`,`sales3`.`creator1` AS `creator1`,`sales3`.`product1` AS `product1`,`sales3`.`creator2` AS `creator2`,`sales3`.`product2` AS `product2`,`sales3`.`price1` AS `price1`,count(0) AS `ct` from `sales3` where `sales3`.`price1` in (select min(`sales3`.`price1`) from `sales3` where (`sales3`.`stock` > 0) group by `sales3`.`creator1`,`sales3`.`product1`,`sales3`.`creator2`,`sales3`.`product2`) group by `sales3`.`creator1`,`sales3`.`product1`,`sales3`.`creator2`,`sales3`.`product2` order by `sales3`.`price1` limit 0,30;

-- --------------------------------------------------------

--
-- Structure for view `priceview5`
--
DROP TABLE IF EXISTS `priceview5`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `priceview5` AS select `sales3`.`uniqueX` AS `uniqueX`,`sales3`.`creator1` AS `creator1`,`sales3`.`product1` AS `product1`,`sales3`.`creator2` AS `creator2`,`sales3`.`product2` AS `product2`,`sales3`.`price2` AS `price2`,count(0) AS `ct` from `sales3` where `sales3`.`price2` in (select max(`sales3`.`price2`) from `sales3` where (`sales3`.`stock` > 0) group by `sales3`.`creator2`,`sales3`.`product2`,`sales3`.`creator1`,`sales3`.`product1`) group by `sales3`.`creator2`,`sales3`.`product2`,`sales3`.`creator1`,`sales3`.`product1` order by `sales3`.`uniqueX` limit 0,30;

-- --------------------------------------------------------

--
-- Structure for view `pv01`
--
DROP TABLE IF EXISTS `pv01`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `pv01` AS select `sales3`.`uniqueX` AS `uniqueX`,`sales3`.`creator1` AS `creator1`,`sales3`.`product1` AS `product1`,`sales3`.`creator2` AS `creator2`,`sales3`.`product2` AS `product2`,`sales3`.`price1` AS `price1`,count(0) AS `ct` from `sales3` where `sales3`.`price1` in (select min(`sales3`.`price1`) from `sales3` where (`sales3`.`stock` > 0) group by `sales3`.`creator1`,`sales3`.`product1`,`sales3`.`creator2`,`sales3`.`product2`) group by `sales3`.`creator1`,`sales3`.`product1`,`sales3`.`creator2`,`sales3`.`product2` order by `sales3`.`price1` limit 0,30;

-- --------------------------------------------------------

--
-- Structure for view `pv02`
--
DROP TABLE IF EXISTS `pv02`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `pv02` AS select `sales3`.`uniqueX` AS `uniqueX`,`sales3`.`creator1` AS `creator1`,`sales3`.`product1` AS `product1`,`sales3`.`creator2` AS `creator2`,`sales3`.`product2` AS `product2`,`sales3`.`price2` AS `price2`,count(0) AS `ct` from `sales3` where `sales3`.`price2` in (select max(`sales3`.`price2`) from `sales3` where (`sales3`.`stock` > 0) group by `sales3`.`creator2`,`sales3`.`product2`,`sales3`.`creator1`,`sales3`.`product1`) group by `sales3`.`creator2`,`sales3`.`product2`,`sales3`.`creator1`,`sales3`.`product1` order by `sales3`.`uniqueX` limit 0,30;

-- --------------------------------------------------------

--
-- Structure for view `pv1`
--
DROP TABLE IF EXISTS `pv1`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `pv1` AS select `sales3`.`creator1` AS `pvc1`,`sales3`.`product1` AS `pvp1`,`sales3`.`creator2` AS `pvc2`,`sales3`.`product2` AS `pvp2` from `sales3` limit 0,30;

-- --------------------------------------------------------

--
-- Structure for view `pv2`
--
DROP TABLE IF EXISTS `pv2`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `pv2` AS select `sales3`.`creator2` AS `pvc1`,`sales3`.`product2` AS `pvp1`,`sales3`.`creator1` AS `pvc2`,`sales3`.`product1` AS `pvp2` from `sales3` limit 0,30;

-- --------------------------------------------------------

--
-- Structure for view `pv3`
--
DROP TABLE IF EXISTS `pv3`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `pv3` AS select `pv1`.`pvc1` AS `pvc1`,`pv1`.`pvp1` AS `pvp1`,`pv1`.`pvc2` AS `pvc2`,`pv1`.`pvp2` AS `pvp2` from `pv1` union select `pv2`.`pvc1` AS `pvc1`,`pv2`.`pvp1` AS `pvp1`,`pv2`.`pvc2` AS `pvc2`,`pv2`.`pvp2` AS `pvp2` from `pv2`;

-- --------------------------------------------------------

--
-- Structure for view `pv4`
--
DROP TABLE IF EXISTS `pv4`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `pv4` AS select `pv3`.`pvc1` AS `pvc1`,`pv3`.`pvp1` AS `pvp1`,`pv3`.`pvc2` AS `pvc2`,`pv3`.`pvp2` AS `pvp2`,`pv01`.`price1` AS `price1` from (`pv3` left join `pv01` on(((`pv3`.`pvc2` = `pv01`.`creator1`) and (`pv3`.`pvp1` = `pv01`.`product2`) and (`pv3`.`pvc1` = `pv01`.`creator2`) and (`pv3`.`pvp2` = `pv01`.`product1`))));

-- --------------------------------------------------------

--
-- Structure for view `pv5`
--
DROP TABLE IF EXISTS `pv5`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `pv5` AS select `pv4`.`pvc2` AS `pvc1`,`pv4`.`pvp2` AS `pvp1`,`pv4`.`pvc1` AS `pvc2`,`pv4`.`pvp1` AS `pvp2`,`pv02`.`price2` AS `price1`,`pv4`.`price1` AS `price2` from (`pv4` left join `pv02` on(((`pv4`.`pvc1` = `pv02`.`creator1`) and (`pv4`.`pvp1` = `pv02`.`product1`) and (`pv4`.`pvc2` = `pv02`.`creator2`) and (`pv4`.`pvp2` = `pv02`.`product2`)))) where ((`pv4`.`price1` > 0) or (`pv02`.`price2` > 0)) order by `pv02`.`price2`;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
