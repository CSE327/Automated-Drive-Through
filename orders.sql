CREATE TABLE `orders` (
  `ID` int(11) NOT NULL,
  `Date` date NOT NULL,
  `OrderNumber` int(11) DEFAULT `D001` NOT NULL,
  `Name` varchar(250) NOT NULL,
  `Code` varchar (250) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Price` decimal(10,0) NOT NULL,
  `TotalPrice` decimal(10,0) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;