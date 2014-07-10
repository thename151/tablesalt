-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 10, 2014 at 02:27 PM
-- Server version: 5.5.37-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.3

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
-- Table structure for table `addresschecks`
--

CREATE TABLE IF NOT EXISTS `addresschecks` (
  `uniqueX` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(25) NOT NULL,
  `address` varchar(40) NOT NULL,
  `total` decimal(16,8) NOT NULL,
  `difference` decimal(16,8) NOT NULL,
  `runintotal` decimal(16,8) NOT NULL,
  `datetime` datetime NOT NULL,
  PRIMARY KEY (`uniqueX`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `addressesinuse`
--

CREATE TABLE IF NOT EXISTS `addressesinuse` (
  `uniqueX` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(25) NOT NULL,
  `address` varchar(40) NOT NULL,
  `code` varchar(20) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`uniqueX`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `addresslist`
--

CREATE TABLE IF NOT EXISTS `addresslist` (
  `uniqueX` int(11) NOT NULL AUTO_INCREMENT,
  `address` varchar(40) NOT NULL,
  `status` varchar(25) NOT NULL,
  `user` varchar(25) NOT NULL,
  `datetime` datetime NOT NULL,
  PRIMARY KEY (`uniqueX`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Stand-in structure for view `coinview`
--
CREATE TABLE IF NOT EXISTS `coinview` (
`difference` decimal(17,8)
,`address` varchar(40)
,`datetime` datetime
,`user` varchar(25)
,`runintotal` decimal(16,8)
,`tablename` varchar(8)
);
-- --------------------------------------------------------

--
-- Table structure for table `deposits`
--

CREATE TABLE IF NOT EXISTS `deposits` (
  `uniqueX` int(11) NOT NULL AUTO_INCREMENT,
  `amount` decimal(16,8) NOT NULL,
  `address` varchar(40) NOT NULL,
  `confirmations` int(11) NOT NULL,
  `datetime1` datetime NOT NULL,
  `datetime2` datetime NOT NULL,
  PRIMARY KEY (`uniqueX`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `divs`
--

CREATE TABLE IF NOT EXISTS `divs` (
  `UniqueX` int(11) NOT NULL AUTO_INCREMENT,
  `totalx` int(11) NOT NULL,
  `user` varchar(25) NOT NULL,
  `amount` decimal(6,3) NOT NULL,
  `wouldsend` decimal(7,6) NOT NULL,
  `doessend` decimal(4,3) NOT NULL,
  PRIMARY KEY (`UniqueX`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `divtotal`
--

CREATE TABLE IF NOT EXISTS `divtotal` (
  `uniqueX` int(11) NOT NULL AUTO_INCREMENT,
  `cr1` varchar(25) NOT NULL,
  `pr1` varchar(40) NOT NULL,
  `cr2` varchar(25) NOT NULL,
  `pr2` varchar(40) NOT NULL,
  `rate` decimal(6,3) NOT NULL,
  `wouldsend` decimal(9,6) NOT NULL,
  `doessend` decimal(6,3) NOT NULL,
  `datetime` datetime NOT NULL,
  PRIMARY KEY (`uniqueX`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE IF NOT EXISTS `expenses` (
  `uniqueX` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(25) NOT NULL,
  `amount` decimal(16,8) NOT NULL,
  `runintotal` decimal(16,8) NOT NULL,
  `destination` varchar(40) NOT NULL,
  `datetime` datetime NOT NULL,
  PRIMARY KEY (`uniqueX`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `expenses2`
--

CREATE TABLE IF NOT EXISTS `expenses2` (
  `uniqueX` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(25) NOT NULL,
  `type` varchar(40) NOT NULL,
  `runintotal` datetime NOT NULL,
  `datetime` datetime NOT NULL,
  PRIMARY KEY (`uniqueX`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `login1`
--

CREATE TABLE IF NOT EXISTS `login1` (
  `uniqueX` int(11) NOT NULL AUTO_INCREMENT,
  `loginName` varchar(25) NOT NULL,
  `loginTime` datetime NOT NULL,
  PRIMARY KEY (`uniqueX`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `messages1`
--

CREATE TABLE IF NOT EXISTS `messages1` (
  `uniqueX` int(11) NOT NULL AUTO_INCREMENT,
  `from1` varchar(25) NOT NULL,
  `to1` varchar(25) NOT NULL,
  `product` varchar(40) NOT NULL,
  `type` varchar(25) NOT NULL,
  `message1` varchar(500) NOT NULL,
  `datetime` datetime NOT NULL,
  PRIMARY KEY (`uniqueX`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `products1`
--

CREATE TABLE IF NOT EXISTS `products1` (
  `uniqueX` int(11) NOT NULL AUTO_INCREMENT,
  `productName` varchar(40) NOT NULL,
  `profileName` varchar(25) NOT NULL,
  `detail` varchar(500) NOT NULL,
  `divisible` tinyint(1) NOT NULL,
  `status1` varchar(25) NOT NULL DEFAULT 'okay',
  `dateTime` datetime NOT NULL,
  PRIMARY KEY (`uniqueX`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

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
,`price1` decimal(6,3)
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
,`price2` decimal(6,3)
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
,`price1` decimal(6,3)
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
,`price1` decimal(6,3)
,`price2` decimal(6,3)
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `sales3`
--

CREATE TABLE IF NOT EXISTS `sales3` (
  `uniqueX` int(11) NOT NULL AUTO_INCREMENT,
  `amount1` decimal(6,3) NOT NULL,
  `type1` varchar(25) NOT NULL,
  `creator1` varchar(25) NOT NULL,
  `product1` varchar(40) NOT NULL,
  `creator2` varchar(25) NOT NULL,
  `product2` varchar(40) NOT NULL,
  `price1` decimal(6,3) NOT NULL,
  `price2` decimal(6,3) NOT NULL,
  `keeptrade` varchar(25) NOT NULL,
  `user` varchar(25) NOT NULL,
  `dateTime` datetime NOT NULL,
  PRIMARY KEY (`uniqueX`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `salesactive`
--

CREATE TABLE IF NOT EXISTS `salesactive` (
  `uniqueX` int(11) NOT NULL AUTO_INCREMENT,
  `saleId` int(11) NOT NULL,
  `stock` decimal(6,3) NOT NULL,
  PRIMARY KEY (`uniqueX`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Stand-in structure for view `salesactive2`
--
CREATE TABLE IF NOT EXISTS `salesactive2` (
`uniqueX` int(11)
,`saleId` int(11)
,`stock` decimal(6,3)
,`amount1` decimal(6,3)
,`type1` varchar(25)
,`creator1` varchar(25)
,`product1` varchar(40)
,`creator2` varchar(25)
,`product2` varchar(40)
,`price1` decimal(6,3)
,`price2` decimal(6,3)
,`user` varchar(25)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `salesactive3`
--
CREATE TABLE IF NOT EXISTS `salesactive3` (
`uniqueX` int(11)
,`saleId` int(11)
,`stock` decimal(6,3)
,`amount1` decimal(6,3)
,`type1` varchar(25)
,`creator1` varchar(25)
,`product1` varchar(40)
,`creator2` varchar(25)
,`product2` varchar(40)
,`divisible` tinyint(1)
,`price1` decimal(6,3)
,`price2` decimal(6,3)
,`user` varchar(25)
);
-- --------------------------------------------------------

--
-- Table structure for table `scores1`
--

CREATE TABLE IF NOT EXISTS `scores1` (
  `uniqueX` int(11) NOT NULL AUTO_INCREMENT,
  `who1` varchar(25) NOT NULL,
  `creator` varchar(25) NOT NULL,
  `product` varchar(40) NOT NULL,
  `amount` decimal(12,3) NOT NULL,
  PRIMARY KEY (`uniqueX`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tradelog`
--

CREATE TABLE IF NOT EXISTS `tradelog` (
  `uniqueX` int(11) NOT NULL AUTO_INCREMENT,
  `odduser` varchar(25) NOT NULL,
  `wouldsend` decimal(7,6) NOT NULL,
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users1`
--

CREATE TABLE IF NOT EXISTS `users1` (
  `uniqueX` int(11) NOT NULL AUTO_INCREMENT,
  `loginName` varchar(25) NOT NULL,
  `createDate` datetime NOT NULL,
  `hashword` varchar(255) NOT NULL,
  `thestyle` varchar(25) NOT NULL,
  `closeDate` datetime DEFAULT NULL,
  PRIMARY KEY (`uniqueX`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `valuepairs`
--

CREATE TABLE IF NOT EXISTS `valuepairs` (
  `uniqueX` int(11) NOT NULL AUTO_INCREMENT,
  `thekey` varchar(50) NOT NULL,
  `thevalue` varchar(50) NOT NULL,
  `datetime` datetime NOT NULL,
  PRIMARY KEY (`uniqueX`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `withdrawals`
--

CREATE TABLE IF NOT EXISTS `withdrawals` (
  `uniqueX` int(11) NOT NULL AUTO_INCREMENT,
  `amount` decimal(16,8) NOT NULL,
  `address` varchar(40) NOT NULL,
  `state` varchar(40) NOT NULL,
  `datetime1` datetime NOT NULL,
  `datetime2` datetime NOT NULL,
  PRIMARY KEY (`uniqueX`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure for view `coinview`
--
DROP TABLE IF EXISTS `coinview`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `coinview` AS select `addresschecks`.`difference` AS `difference`,`addresschecks`.`address` AS `address`,`addresschecks`.`datetime` AS `datetime`,`addresschecks`.`user` AS `user`,`addresschecks`.`runintotal` AS `runintotal`,'income' AS `tablename` from `addresschecks` where (`addresschecks`.`difference` > 0) union select (`expenses`.`amount` * -(1)) AS `amount * -1`,`expenses`.`destination` AS `destination`,`expenses`.`datetime` AS `datetime`,`expenses`.`user` AS `user`,`expenses`.`runintotal` AS `runintotal`,'expenses' AS `tablename` from `expenses` order by `datetime` desc;

-- --------------------------------------------------------

--
-- Structure for view `pv01`
--
DROP TABLE IF EXISTS `pv01`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `pv01` AS select `salesactive2`.`uniqueX` AS `uniqueX`,`salesactive2`.`creator1` AS `creator1`,`salesactive2`.`product1` AS `product1`,`salesactive2`.`creator2` AS `creator2`,`salesactive2`.`product2` AS `product2`,`salesactive2`.`price1` AS `price1`,count(0) AS `ct` from `salesactive2` where `salesactive2`.`price1` in (select min(`salesactive2`.`price1`) from `salesactive2` where (`salesactive2`.`stock` > 0) group by `salesactive2`.`creator1`,`salesactive2`.`product1`,`salesactive2`.`creator2`,`salesactive2`.`product2`) group by `salesactive2`.`creator1`,`salesactive2`.`product1`,`salesactive2`.`creator2`,`salesactive2`.`product2` order by `salesactive2`.`price1` limit 0,30;

-- --------------------------------------------------------

--
-- Structure for view `pv02`
--
DROP TABLE IF EXISTS `pv02`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `pv02` AS select `salesactive2`.`uniqueX` AS `uniqueX`,`salesactive2`.`creator1` AS `creator1`,`salesactive2`.`product1` AS `product1`,`salesactive2`.`creator2` AS `creator2`,`salesactive2`.`product2` AS `product2`,`salesactive2`.`price2` AS `price2`,count(0) AS `ct` from `salesactive2` where `salesactive2`.`price2` in (select max(`salesactive2`.`price2`) from `salesactive2` where (`salesactive2`.`stock` > 0) group by `salesactive2`.`creator2`,`salesactive2`.`product2`,`salesactive2`.`creator1`,`salesactive2`.`product1`) group by `salesactive2`.`creator2`,`salesactive2`.`product2`,`salesactive2`.`creator1`,`salesactive2`.`product1` order by `salesactive2`.`uniqueX` limit 0,30;

-- --------------------------------------------------------

--
-- Structure for view `pv1`
--
DROP TABLE IF EXISTS `pv1`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `pv1` AS select `salesactive2`.`creator1` AS `pvc1`,`salesactive2`.`product1` AS `pvp1`,`salesactive2`.`creator2` AS `pvc2`,`salesactive2`.`product2` AS `pvp2` from `salesactive2` limit 0,30;

-- --------------------------------------------------------

--
-- Structure for view `pv2`
--
DROP TABLE IF EXISTS `pv2`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `pv2` AS select `salesactive2`.`creator2` AS `pvc1`,`salesactive2`.`product2` AS `pvp1`,`salesactive2`.`creator1` AS `pvc2`,`salesactive2`.`product1` AS `pvp2` from `salesactive2` limit 0,30;

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

-- --------------------------------------------------------

--
-- Structure for view `salesactive2`
--
DROP TABLE IF EXISTS `salesactive2`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `salesactive2` AS select `salesactive`.`uniqueX` AS `uniqueX`,`salesactive`.`saleId` AS `saleId`,`salesactive`.`stock` AS `stock`,`sales3`.`amount1` AS `amount1`,`sales3`.`type1` AS `type1`,`sales3`.`creator1` AS `creator1`,`sales3`.`product1` AS `product1`,`sales3`.`creator2` AS `creator2`,`sales3`.`product2` AS `product2`,`sales3`.`price1` AS `price1`,`sales3`.`price2` AS `price2`,`sales3`.`user` AS `user` from (`salesactive` left join `sales3` on((`sales3`.`uniqueX` = `salesactive`.`saleId`))) where (`sales3`.`uniqueX` > 0) limit 0,30;

-- --------------------------------------------------------

--
-- Structure for view `salesactive3`
--
DROP TABLE IF EXISTS `salesactive3`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `salesactive3` AS select `salesactive2`.`uniqueX` AS `uniqueX`,`salesactive2`.`saleId` AS `saleId`,`salesactive2`.`stock` AS `stock`,`salesactive2`.`amount1` AS `amount1`,`salesactive2`.`type1` AS `type1`,`salesactive2`.`creator1` AS `creator1`,`salesactive2`.`product1` AS `product1`,`salesactive2`.`creator2` AS `creator2`,`salesactive2`.`product2` AS `product2`,`products1`.`divisible` AS `divisible`,`salesactive2`.`price1` AS `price1`,`salesactive2`.`price2` AS `price2`,`salesactive2`.`user` AS `user` from (`salesactive2` left join `products1` on(((`products1`.`profileName` = `salesactive2`.`creator1`) and (`products1`.`productName` = `salesactive2`.`product1`))));

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

