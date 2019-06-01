--
-- Table structure for table `employee`
--

CREATE TABLE IF NOT EXISTS `list` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `channel` varchar(255) NOT NULL COMMENT 'Channel Name',
  `songname` varchar(255) NOT NULL COMMENT 'Last Song Name',
  `lastupdate` varchar(255) NOT NULL COMMENT 'LastUpdated',
  `clink` varchar(255) NOT NULL COMMENT 'Channel Link',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Listee' AUTO_INCREMENT=64 ;

--
-- Dumping data for table `employee`
--

INSERT INTO `list` (`id`, `channel`, `songname`, `lastupdate`,`clink`) VALUES
(1, 'sadw', 'www','2131214','www.ycfhre'),
(2, '22', 'www1','4643','www.jfchxt'),
(3, '33', 'www2','644','wwwfhre'),
(4, '44', 'www3','65984','wwwdfxjhd'),
(5, '55', 'www4','3569234','wwwfhjd'),
(6, '66', 'www5','312314','www.fyc'),
(7, '77', 'www6','54514','www.hvk');

