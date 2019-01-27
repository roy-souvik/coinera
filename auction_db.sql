-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 09, 2013 at 01:42 PM
-- Server version: 5.1.36
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `auction_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_master`
--

CREATE TABLE IF NOT EXISTS `admin_master` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_userid` varchar(35) NOT NULL DEFAULT '',
  `admin_password` varchar(35) NOT NULL DEFAULT '',
  `admin_mail` varchar(100) NOT NULL,
  `url` varchar(200) NOT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `admin_master`
--

INSERT INTO `admin_master` (`admin_id`, `admin_userid`, `admin_password`, `admin_mail`, `url`) VALUES
(1, 'admin', 'admin!1980', 'subhra.s@arhamcreation.com', 'http://arhamcreation.in/coinera/');

-- --------------------------------------------------------

--
-- Table structure for table `bid_info`
--

CREATE TABLE IF NOT EXISTS `bid_info` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `user_id` int(100) NOT NULL,
  `product_id` int(100) NOT NULL,
  `description` text NOT NULL,
  `bid_price` double NOT NULL,
  `final_bid_price` double NOT NULL,
  `bid_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `bid_info`
--

INSERT INTO `bid_info` (`id`, `user_id`, `product_id`, `description`, `bid_price`, `final_bid_price`, `bid_date`) VALUES
(1, 5, 3, '<p>gfcdgfdgfd</p>', 150, 153, '2013-07-06'),
(2, 7, 3, '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum nunc urna, luctus ac porttitor at, porta at lectus. Interdum et malesuada fames ac ante ipsum primis in faucibus.</p>', 100, 102, '2013-07-06'),
(3, 8, 3, '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum nunc urna, luctus ac porttitor at, porta at lectus. Interdum et malesuada fames ac ante ipsum primis in faucibus.</p>', 120, 122.4, '2013-07-06'),
(4, 13, 56, '', 3, 3.06, '2013-07-06'),
(5, 17, 19, '<p>shipping....?</p>', 100, 102, '2013-07-06'),
(6, 17, 19, '<p>shipping....?</p>', 100, 102, '2013-07-06'),
(7, 6, 1, '<p>fjfg</p>', 150, 153, '2013-07-08'),
(8, 5, 6, '<p>ersdfsdfsdfsdf</p>', 111, 113.22, '2013-07-08'),
(9, 13, 8, '', 300, 306, '2013-07-08'),
(10, 5, 14, '', 15, 15.3, '2013-07-08'),
(11, 6, 11, '', 456, 465.12, '2013-07-08'),
(12, 13, 9, '', 122, 124.44, '2013-07-08'),
(13, 10, 9, '', 121, 123.42, '2013-07-08'),
(14, 7, 6, '<p>ttttt</p>', 115, 117.3, '2013-07-09');

-- --------------------------------------------------------

--
-- Table structure for table `buyer_info`
--

CREATE TABLE IF NOT EXISTS `buyer_info` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `user_id` int(100) NOT NULL,
  `product_id` int(100) NOT NULL,
  `bid_count` int(222) NOT NULL,
  `remarks` varchar(200) NOT NULL,
  `expired` enum('Y','N') NOT NULL DEFAULT 'Y',
  `status` enum('Y','N') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `buyer_info`
--

INSERT INTO `buyer_info` (`id`, `user_id`, `product_id`, `bid_count`, `remarks`, `expired`, `status`) VALUES
(6, 5, 3, 0, 'fdgdf gdfg', 'N', 'Y'),
(7, 7, 3, 0, '', 'Y', 'Y'),
(8, 8, 3, 0, '', 'Y', 'Y'),
(9, 13, 56, 0, '', 'Y', 'Y'),
(10, 17, 19, 0, '', 'Y', 'Y'),
(11, 17, 19, 0, '', 'Y', 'Y'),
(12, 6, 1, 0, 'u r the winner', 'N', 'Y'),
(13, 5, 6, 0, '', 'Y', 'Y'),
(14, 13, 8, 0, '', 'Y', 'Y'),
(15, 5, 14, 0, '', 'Y', 'Y'),
(16, 6, 11, 0, 'you are the winning bidder. Please pay asap', 'Y', 'Y'),
(17, 13, 9, 0, '', 'Y', 'Y'),
(18, 10, 9, 0, '', 'Y', 'Y'),
(19, 7, 6, 0, '', 'Y', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `category_info`
--

CREATE TABLE IF NOT EXISTS `category_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `p_id` int(100) NOT NULL DEFAULT '0',
  `name` varchar(200) NOT NULL,
  `date` date NOT NULL,
  `status` enum('Y','N') NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `category_info`
--

INSERT INTO `category_info` (`id`, `p_id`, `name`, `date`, `status`) VALUES
(1, 0, 'Art & Antiques', '2013-06-04', 'Y'),
(2, 1, 'Cameras & Watches', '2013-06-04', 'Y'),
(3, 1, 'Painting', '2013-06-04', 'Y'),
(4, 1, 'Silver & Silver Plate', '2013-06-04', 'Y'),
(5, 1, 'Furniture& Interior Items ', '2013-06-04', 'Y'),
(6, 0, 'Coins & Notes', '2013-06-04', 'Y'),
(7, 6, 'Indian Coins', '2013-06-04', 'Y'),
(8, 6, 'Indian Notes', '2013-06-04', 'Y'),
(9, 0, 'Stamps', '2013-06-04', 'Y'),
(10, 9, 'Stamps ', '2013-06-04', 'Y'),
(11, 9, 'Share Certificate,Letter,Hundis', '2013-06-04', 'Y'),
(12, 9, 'Medal & Tokens', '2013-06-04', 'Y'),
(13, 0, 'Books & Magazines', '2013-06-04', 'Y'),
(14, 13, 'Cooking, Food & Wine', '2013-06-04', 'Y'),
(15, 13, 'Children', '2013-06-04', 'Y'),
(16, 13, 'Animals', '2013-06-04', 'Y'),
(18, 0, 'Everything Else', '2013-06-23', 'Y'),
(19, 13, 'Numismatic Books', '2013-06-23', 'Y'),
(20, 6, 'World Coins & Notes', '2013-06-23', 'Y'),
(21, 18, 'Gift Items', '2013-06-23', 'Y'),
(22, 18, 'Greeting Cards', '2013-06-23', 'Y'),
(23, 18, 'Others', '2013-06-23', 'Y'),
(24, 1, 'Antiques  Handicrafts', '2013-06-23', 'Y'),
(25, 1, 'Collectibles', '2013-06-29', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(50) NOT NULL,
  `seller_id` int(50) NOT NULL,
  `bidder_id` int(50) NOT NULL,
  `message` text NOT NULL,
  `msg_id` int(50) NOT NULL DEFAULT '0',
  `bid_id` int(50) NOT NULL,
  `msg_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `product_id`, `seller_id`, `bidder_id`, `message`, `msg_id`, `bid_id`, `msg_date`) VALUES
(1, 6, 6, 7, 'ddddd', 7, 14, '2013-07-09'),
(2, 6, 6, 5, 'test1', 5, 8, '2013-07-09'),
(3, 6, 6, 5, 'rrrrrrrrrrr', 5, 8, '2013-07-09');

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE IF NOT EXISTS `notification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `buyer_id` int(20) NOT NULL,
  `seller_id` int(20) NOT NULL,
  `product_id` int(20) NOT NULL,
  `admin_msg` text NOT NULL,
  `send_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`id`, `buyer_id`, `seller_id`, `product_id`, `admin_msg`, `send_date`) VALUES
(1, 5, 6, 3, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ut nibh in eros dapibus pulvinar. Mauris quis vestibulum leo. Curabitur tempor eu risus sit amet pellentesque. Sed condimentum consequat erat eu euismod. Aenean lorem nibh, aliquet at sapien non', '2013-07-06'),
(2, 6, 5, 1, 'please send the product asap', '2013-07-08');

-- --------------------------------------------------------

--
-- Table structure for table `product_info`
--

CREATE TABLE IF NOT EXISTS `product_info` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `user_id` int(100) NOT NULL,
  `cat_id` int(100) NOT NULL,
  `cat_p_id` int(100) NOT NULL,
  `title` varchar(300) NOT NULL,
  `sub_title` varchar(300) NOT NULL,
  `bid_price` double NOT NULL,
  `direct_price` double NOT NULL,
  `description` text NOT NULL,
  `images` varchar(200) NOT NULL,
  `image2` varchar(200) NOT NULL,
  `image3` varchar(200) NOT NULL,
  `entry_date` date NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `quantity` int(100) NOT NULL,
  `packaging_no` varchar(200) NOT NULL,
  `bid_status` enum('Y','N') NOT NULL DEFAULT 'Y',
  `status` enum('Y','N') NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=62 ;

--
-- Dumping data for table `product_info`
--

INSERT INTO `product_info` (`id`, `user_id`, `cat_id`, `cat_p_id`, `title`, `sub_title`, `bid_price`, `direct_price`, `description`, `images`, `image2`, `image3`, `entry_date`, `start_date`, `end_date`, `quantity`, `packaging_no`, `bid_status`, `status`) VALUES
(1, 5, 7, 6, 'Test Coin 1', 'Golden Coin', 150, 0, '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis non viverra neque, eget hendrerit lorem. Donec commodo turpis ornare eros posuere, et tempus justo cursus. Aliquam erat volutpat. Nam eu leo malesuada, tristique justo aliquam, pellentesque nunc. Mauris nec dolor hendrerit, convallis odio ultrices, elementum est! Pellentesque magna nulla, laoreet vel ante id, vestibulum aliquet risus.</p>', 'images2.jpg', '', '', '2013-06-19', '2013-06-20', '2013-06-30', 1, '', 'N', 'N'),
(2, 5, 7, 6, 'Test Coin 2', 'Golden Coin 2', 220, 0, '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis non viverra neque, eget hendrerit lorem. Donec commodo turpis ornare eros posuere, et tempus justo cursus.</p>', '1.jpg', '3300755_1342255993_414485717_1-Pictures-of--SJG-Cheap-A5-Leaflets-Flyers-Posters-Vinyl-Banners-Vehicle-Graphics-Decals-Business.jpg', '', '2013-07-01', '2013-06-21', '2013-07-23', 1, '', 'Y', 'Y'),
(3, 6, 11, 9, 'Pen Drive', 'Test Pendrive 1', 89, 0, '<p>Duis non viverra neque, eget hendrerit lorem. Donec commodo turpis ornare eros posuere, et tempus justo cursus. Aliquam erat volutpat. Nam eu leo malesuada, tristique justo aliquam, pellentesque nunc. Mauris nec dolor hendrerit, convallis odio ultrices, elementum est! Pellentesque magna nulla, laoreet vel ante id, vestibulum aliquet risus.</p>', 'INFD4GBEVOBL_21_1600x1600.jpg', '', '', '2013-06-19', '2013-06-20', '2013-06-30', 1, '', 'N', 'N'),
(4, 6, 14, 13, 'Test Book', 'Book 2', 0, 153, '<p>Duis non viverra neque, eget hendrerit lorem. Donec commodo turpis ornare eros posuere, et tempus justo cursus. Aliquam erat volutpat. Nam eu leo malesuada, tristique justo aliquam, pellentesque nunc. Mauris nec dolor hendrerit, convallis odio ultrices, elementum est! Pellentesque magna nulla, laoreet vel ante id, vestibulum aliquet risus.</p>', 'books460.jpg', '', '', '2013-06-19', '2013-06-25', '2013-06-29', 1, '', 'Y', 'Y'),
(5, 6, 7, 6, 'Test Coin 3', 'test', 0, 855, '<p>Duis non viverra neque, eget hendrerit lorem. Donec commodo turpis ornare eros posuere, et tempus justo cursus. Aliquam erat volutpat. Nam eu leo malesuada, tristique justo aliquam, pellentesque nunc. Mauris nec dolor hendrerit, convallis odio ultrices, elementum est! Pellentesque magna nulla, laoreet vel ante id, vestibulum aliquet risus.</p>', 'quarter-coin-head.jpg', '', '', '2013-06-19', '2013-06-23', '2013-08-07', 1, '', 'Y', 'Y'),
(6, 6, 16, 13, 'Test Book 2', 'Animals', 99, 0, '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras ut adipiscing purus. Suspendisse consequat leo eu libero porta vestibulum! Mauris lacinia tellus dictum urna fringilla, molestie viverra libero porta. Aliquam ultrices lorem ut nulla venenatis congue.</p>', '82780205.jpg', '', '', '2013-06-19', '2013-06-20', '2013-06-30', 1, '', 'Y', 'Y'),
(7, 6, 11, 9, 'DVD WRITER', 'Test Writer 2', 66, 0, '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras ut adipiscing purus. Suspendisse consequat leo eu libero porta vestibulum! Mauris lacinia tellus dictum urna fringilla, molestie viverra libero porta. Aliquam ultrices lorem ut nulla venenatis congue.</p>', 'External-DVD-Writers.jpg', '', '', '2013-06-19', '2013-06-27', '2013-08-08', 1, '', 'Y', 'Y'),
(8, 6, 7, 6, 'Test Coin 4', 'Silver Coin', 256, 0, '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras ut adipiscing purus. Suspendisse consequat leo eu libero porta vestibulum! Mauris lacinia tellus dictum urna fringilla, molestie viverra libero porta. Aliquam ultrices lorem ut nulla venenatis congue.</p>', 'Bullion-Coins---Platinum---obverse.jpg', '', '', '2013-06-19', '2013-06-24', '2013-06-22', 1, '', 'Y', 'Y'),
(9, 5, 11, 9, 'DVD WRITER 2', 'TEST PRODUCT', 121, 0, '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec porttitor, felis ac ornare volutpat, risus eros facilisis dui, quis tempus lacus libero vel neque. Duis enim magna,</p>', 'dvd.jpg', '', '', '2013-06-19', '2013-06-24', '2013-06-30', 1, '', 'Y', 'Y'),
(10, 5, 7, 6, 'Test Coin 5', 'Golden Coin 3', 369, 0, '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec porttitor, felis ac ornare volutpat, risus eros facilisis dui, quis tempus lacus libero vel neque. Duis enim magna,</p>', 'proof-gold-coins-765421.jpg', '', '', '2013-06-19', '2013-06-24', '2013-06-29', 1, '', 'N', 'N'),
(11, 5, 14, 13, 'TEST BOOK 3', 'Books', 300, 0, '<p>Proin elementum posuere euismod. Vestibulum feugiat sagittis sapien in luctus. Aliquam erat volutpat. Nam dapibus imperdiet tortor, ac condimentum neque dapibus eu.</p>', 'books460.jpg', '8450271_US-olwp4.jpg', '4233220_UK-olwp1.jpg', '2013-07-01', '2013-06-20', '2013-06-30', 1, '', 'N', 'N'),
(12, 7, 7, 6, 'Bronze Coin', 'Test Coin 6', 0, 200, '<p>Vivamus sed leo non magna euismod porta nec id massa. Praesent quis metus id purus convallis hendrerit et scelerisque orci. Quisque porttitor ante ac nibh dapibus vulputate.</p>', 'five-pound-gold-coin-obverse_1.jpg', '', '', '2013-06-21', '2013-06-22', '2013-06-30', 1, '', 'Y', 'Y'),
(13, 9, 8, 6, 'new', 'a1', 12.11, 0, '<p>adswd</p>', '1342255993_414485717_1-Pictures-of--SJG-Cheap-A5-Leaflets-Flyers-Posters-Vinyl-Banners-Vehicle-Graphics-Decals-Business.jpg', '', '', '2013-06-21', '2013-06-28', '2013-06-25', 1, '', 'Y', 'Y'),
(14, 9, 8, 6, 'sw', 'a1', 12.11, 0, '<p>sdcdscds</p>', '1342255993_414485717_1-Pictures-of--SJG-Cheap-A5-Leaflets-Flyers-Posters-Vinyl-Banners-Vehicle-Graphics-Decals-Business.jpg', '', '', '2013-06-21', '2013-06-29', '2013-06-24', 1, '', 'Y', 'Y'),
(15, 5, 3, 1, 'Acharya Tulsi Shiksha Pariyojanaaa', 'aaa', 0, 200, '<p>aaaa</p>', 'Almond Crescent1.jpg', '', '', '2013-06-22', '2013-06-25', '2013-06-28', 1, '', 'Y', 'Y'),
(16, 10, 8, 6, 'RS 10 TWO PCS BRITISH INDIA NOTES', 'VERY RARE HARD TO FIND', 0, 5000, '<p>RS 10 TWO PCS BRITISH INDIA NOTES</p>\r\n<p>&nbsp;</p>\r\n<p>VERY RARE HARD TO FIND</p>\r\n<p>&nbsp;</p>\r\n<p>BID WITH CONFIDENCE...</p>', 'IMG00484-20130530-2100 (1).jpg', '', '', '2013-07-01', '2013-06-22', '2013-06-30', 1, '', 'Y', 'Y'),
(17, 10, 8, 6, 'RS 2 BRITISH INDIA NOTE', 'VERY RARE', 0, 500000, '<p>RS 2 BRITISH INDIA NOTES</p>', 'IMG00481-20130526-2127.jpg', '', '', '2013-07-02', '2013-06-22', '2013-06-30', 1, '', 'Y', 'Y'),
(18, 10, 8, 6, 'RS 5 BUNDLE SIGNED BY S.JAGGANATHAN', 'VERY RARE HARD TO FIND', 250, 0, '<p><span>RS 5 BUNDLE + 4 DEER ON THE BACK..INCORRECT URDU</span></p>\r\n<div><span><br /></span></div>\r\n<div><span><br /></span></div>\r\n<div><span>VERY RARE</span></div>', 'IMG00522-20130622-1956.jpg', '', '', '2013-07-01', '2013-07-24', '2013-08-21', 1, '', 'Y', 'Y'),
(28, 15, 8, 6, 'Rs 100 agriculture note', 'Very Rare', 7, 0, '<p>Rs 100 agriculture note..</p>\r\n<p>very rare bid ..very reasonable price</p>', 'IMG00525-20130625-1113.JPG', '', '', '2013-06-24', '2013-07-25', '2013-07-31', 1, '', 'Y', 'Y'),
(29, 17, 2, 1, 'Very Rare old and antique Watch', 'Antique Watch', 500, 0, '<p>Very Rare old and antique Watch..</p>\r\n<p>&nbsp;</p>\r\n<p>BID WITH CONFIDENCE...</p>', 'old watch.JPG', '', '', '2013-07-02', '2013-07-15', '2013-07-31', 1, '', 'Y', 'Y'),
(19, 10, 8, 6, 'Rs 2 green note signed by P.C>Bhattacharya', 'VERY RARE', 50, 0, '<p>Rs 2 green note signed by P.C&gt;Bhattacharya</p>', 'IMG00416-20130512-1012.JPG', '', '', '2013-06-23', '2013-06-23', '2013-06-30', 1, '', 'Y', 'Y'),
(20, 10, 8, 6, 'RS 2 SIGNED BY DIFFERENT GOV', 'FINE CONDITION', 2, 0, '<p>VERY RARE TO FIND</p>', 'IMG00419-20130512-1022.JPG', '', '', '2013-06-23', '2013-06-23', '2013-06-30', 1, '', 'Y', 'Y'),
(21, 10, 7, 6, 'very rare george 5 coin', 'very rare to find', 500, 0, '<p>very rare george 5 coin</p>', 'G5COIN.JPG', '', '', '2013-06-23', '2013-06-23', '2013-06-30', 1, '', 'Y', 'Y'),
(22, 10, 8, 6, 'RS 10 BRITISH INDIA NOTE', 'SIGNED BY C.D.DESHMUKH', 0, 5000, '<p>RS 10 BRITISH INDIA NOTE</p>', '111.JPG', '', '', '2013-07-02', '2013-06-23', '2013-06-30', 1, '', 'Y', 'Y'),
(23, 10, 8, 6, 'RS 5 BRITISH INDIA NOTE SIGNED BY TAYLOR', 'TWO SERIAL CURRENCY', 0, 7500, '<p>VERY RARE BID WITH CONFIDENCE</p>', '$T2eC16JHJIYE9qUcN,9JBRe+4iQ9Sw~~60_3.JPG', '', '', '2013-07-02', '2013-06-23', '2013-06-30', 1, '', 'Y', 'Y'),
(24, 10, 8, 6, 'RS 20 (9 NOTES) SIGNED BY DIFFERENT GOVERNOR', 'VERY RARE', 20, 0, '<p>RS 20 (9 NOTES) SIGNED BY DIFFERENT GOVERNOR</p>', 'IMG00390-20130504-1935.JPG', '', '', '2013-06-23', '2013-06-23', '2013-06-30', 1, '', 'Y', 'Y'),
(25, 10, 8, 6, 'RS 10 NOTES 4 PCS SIGNED BY DIFFERENT GOVERNOR(L.K.JHA/NARSHIMAM/JAGARNATHAN)', 'EXTRA FINE CONDITION', 50, 0, '<p>RS 10 NOTES 4 PCS SIGNED BY DIFFERENT GOVERNOR(L.K.JHA/NARSHIMAM/JAGARNATHAN)</p>', 'IMG00385-20130504-1844.JPG', '', '', '2013-06-23', '2013-06-23', '2013-06-30', 1, '', 'Y', 'Y'),
(26, 10, 8, 6, 'RS 1 TOTAL 62 PCS FROM THE SAME BUNDLE', 'VERY RARE', 50, 0, '<p>RS 1 TOTAL 62 PCS FROM THE SAME BUNDLE</p>', 'IMG00421-20130512-1038.JPG', '', '', '2013-06-23', '2013-06-23', '2013-06-30', 1, '', 'Y', 'Y'),
(27, 10, 8, 6, 'RE 1 NOTE  33 PCS DIFFERENT GOVNS..DIFFRENT YEARS', 'very rare to find', 0, 20, '<p>RE 1 NOTE &nbsp;33 PCS DIFFERENT GOVNS..DIFFRENT YEARS</p>', 'IMG00418-20130512-1017.JPG', '', '', '2013-06-23', '2013-06-23', '2013-06-30', 1, '', 'Y', 'Y'),
(30, 17, 2, 1, 'Very Rare old and antique Watch', 'VERY RARE HARD TO FIND', 100, 0, '<p style=\\"text-align: center;\\">Very Rare old and antique Watch</p>', 'OLDWATCH2.JPG', '', '', '2013-06-27', '2013-07-15', '2013-07-31', 1, '', 'Y', 'Y'),
(31, 13, 8, 6, 'Re 1 green notes (2pcs)', 'VERY RARE', 0, 2000, '<p>Re 1 green notes (2pcs)</p>', 're 1 green notes.JPG', '', '', '2013-07-02', '2013-07-17', '2013-07-31', 1, '', 'Y', 'Y'),
(32, 13, 8, 6, 'Rs 500 old note', 'signed by Venkitrama', 0, 1200, '<p>Bid with confidence</p>', 'rs 500 old.JPG', '', '', '2013-07-02', '2013-07-17', '2013-07-31', 1, '', 'Y', 'Y'),
(33, 13, 8, 6, 'Re 1 Very rare note', 'I-D,signed by l.K.Jha', 0, 350, '<p>very rare for collectors.</p>', 're1 lk.JPG', '', '', '2013-07-02', '2013-07-31', '2013-07-31', 1, '', 'Y', 'Y'),
(34, 17, 8, 6, 'Re 1 note .extra fine condition', 'Signed by A.K.Roy', 20, 0, '<p>Very Rare..Extra Fine Condition</p>', 'akr.JPG', '', '', '2013-07-02', '2013-07-31', '2013-07-31', 1, '', 'Y', 'Y'),
(35, 17, 8, 6, 'Re 1 Note ,signed by jones', 'pic of george 6', 20, 0, '<p>Very Rare item</p>', 'jones.JPG', '', '', '2013-07-02', '2013-07-17', '2013-07-31', 1, '', 'Y', 'Y'),
(36, 17, 8, 6, 'Re 1 Note ,signed by jones', 'pic of george 6', 0, 2000, '<p>Very Rare item</p>', 'jones.JPG', '', '', '2013-07-02', '2013-07-17', '2013-07-31', 1, '', 'Y', 'Y'),
(37, 17, 8, 6, 'Rs 10 big note', 'signed by B.Rama Rao', 10, 0, '<p>Rs 10 Big Note..Rare Item</p>', 'BRama.JPG', '', '', '2013-07-02', '2013-07-17', '2013-07-31', 1, '', 'Y', 'Y'),
(38, 17, 20, 6, 'foreign currency', 'VERY RARE', 50, 0, '<p>note is in good condition</p>', 'fn.JPG', '', '', '2013-06-27', '2013-07-19', '2013-07-30', 1, '', 'Y', 'Y'),
(39, 16, 8, 6, 'Rs.5  of CD Deshmukh', '3 deer on the back', 0, 25000, '<p>Rs.5 &nbsp;of CD Deshmukh note is in fine condition and very rare.</p>', '5 front C.D. Deshmukh.jpg', '', '', '2013-07-02', '2013-06-28', '2013-07-10', 1, '', 'Y', 'Y'),
(40, 16, 7, 6, 'George V Mary', 'Rare Coins', 0, 30000, '<p>Coin is in very fine conmdition and it is very very rare</p>', '2.jpg', '', '', '2013-07-02', '2013-06-29', '2013-07-10', 1, '', 'Y', 'Y'),
(41, 16, 8, 6, 'Rs.10 note of J.B. Taylor', 'elephant on back side', 0, 13000, '<p>very rare</p>', '10 front J.B. taylor.jpg', '', '', '2013-07-02', '2013-06-28', '2013-07-10', 1, '', 'Y', 'Y'),
(42, 16, 20, 6, '1 rupee 1956 Mauritius Coin', 'Queen Elizabeth the second on reverse', 10000, 0, '<p>Coin is is very rare and in good condition</p>', 'IMG_0005.jpg', '', '', '2013-07-02', '2013-06-29', '2013-07-10', 1, '', 'Y', 'Y'),
(43, 16, 20, 6, 'New Pence 10 Coin', 'Elizabeth-II D.G.REG.F.D.1970', 10000, 0, '<p>The coin is very rare and in fine condition</p>', 'IMG_0007.jpg', '', '', '2013-07-02', '2013-06-29', '2013-07-12', 1, '', 'Y', 'Y'),
(44, 16, 20, 6, '1 shilling 1968 kenya coin', 'king on reverse', 5000, 0, '<p>The coin is in very fine condition</p>', 'IMG_0009.jpg', '', '', '2013-07-02', '2013-06-29', '2013-07-12', 1, '', 'Y', 'Y'),
(45, 16, 20, 6, 'United Arab Emirates', 'Sura dani (liquor vase) on reverse', 6000, 0, '<p>The coin is very rare and in fine condition</p>', 'IMG_0011.jpg', '', '', '2013-07-02', '2013-06-29', '2013-07-12', 1, '', 'Y', 'Y'),
(46, 16, 7, 6, '5 Rupee coin of Jawaharlal Centenary', 'coin of year 1989', 1000, 0, '<p>The coin is in good condition</p>', 'IMG_0002.jpg', '', '', '2013-07-02', '2013-06-29', '2013-07-12', 1, '', 'Y', 'Y'),
(47, 16, 8, 6, '1 rupee B series note of 1957', 'signed by a.k. roy', 0, 12000, '<p>The note is very rare and in good condition</p>', 'IMG.jpg', '', '', '2013-07-02', '2013-06-29', '2013-07-12', 1, '', 'Y', 'Y'),
(48, 17, 25, 1, 'VERY OLD COW BELL', 'ANTIQUE & MORE THAN 50 YRS OLD', 100, 0, '<p>VERY OLD COW BELL</p>', 'COW BELL.JPG', '', '', '2013-07-02', '2013-07-19', '2013-07-30', 1, '', 'Y', 'Y'),
(49, 16, 20, 6, 'United Arab Emirates', 'back side of Sura dani (liquor vase) on reverse', 6000, 0, '<p>Back side of the coin, Front side of the same had uploaded earlier</p>', 'IMG_0010.jpg', '', '', '2013-07-02', '2013-06-30', '2013-07-12', 1, '', 'Y', 'Y'),
(50, 16, 8, 6, '10 rupee note of J.W. Kelly', 'elephant on back side', 5000, 0, '<p>Note is very rare and in fine condition</p>', '10 front J.W. Kelly.jpg', '', '', '2013-07-02', '2013-07-01', '2013-07-12', 1, '', 'Y', 'Y'),
(51, 16, 7, 6, 'Ramdarbar Coins', 'Ram sita lakshman and hanuman on reverse', 25000, 0, '<p>It is very rare coin.</p>', 'Copy of C-1.jpg', '', '', '2013-07-02', '2013-07-01', '2013-07-12', 1, '', 'Y', 'Y'),
(52, 16, 8, 6, 'one rupee note of 1940', 'signed by jones', 15000, 0, '<p>The note is very very rare</p>', 'Jones 1 rupee.jpg', '', '', '2013-07-02', '2013-07-01', '2013-07-12', 1, '', 'Y', 'Y'),
(53, 16, 8, 6, '100 rupee note of L.K.Jha', 'Mahatma Gandhi on reverse', 10000, 0, '<p>The note id rare and in very good condition</p>', '100 rupee l.k.jha.jpg', '', '', '2013-07-02', '2013-07-01', '2013-07-11', 1, '', 'Y', 'Y'),
(54, 17, 7, 6, '1 rupee coin - 60 Years of Parliment of India', 'VERY RARE', 0, 2, '<p style=\\"text-align: center;\\"><em><span style=\\"text-decoration: underline;\\">1 rupee coin - 60 Years of Parliment of India</span></em></p>', '1 rupee coin - 60 Years of Parliment of India.JPG', '', '', '2013-06-30', '2013-07-19', '2013-07-31', 1, '', 'Y', 'Y'),
(55, 16, 8, 6, '1 rupee note Bundle of 1991', 'signed by Montek Singh', 5000, 0, '<p>the bundle is in mint condition.</p>', '371048_IMG.jpg', '', '', '2013-07-02', '2013-06-30', '2013-07-12', 1, '', 'Y', 'Y'),
(56, 17, 7, 6, 'RS 2 COIN.', 'VERY RARE', 2, 0, '<p>RS 2 COIN,FULL TIGER ON THE BACK</p>', '2-rs-RBI.jpg', '', '', '2013-07-02', '2013-07-17', '2013-07-30', 1, '', 'Y', 'Y'),
(57, 16, 8, 6, '1 rupee note Bundle of 1989 (86 Pcs.)', 'signed by Gopi K arora', 4500, 0, '<p>The bundle is in mint condition.</p>', 'IMG_0001.jpg', '', '', '2013-07-02', '2013-06-30', '2013-07-15', 1, '', 'Y', 'Y'),
(58, 16, 8, 6, '1 rupee note Bundle of 1991', 'signed by Montek Singh', 5000, 0, '<p>The bundle is in mint condition</p>', '3190987_IMG.jpg', '', '', '2013-07-02', '2013-06-30', '2013-07-12', 1, '', 'Y', 'Y'),
(59, 17, 7, 6, 'RS 5 COIN.VERY RARE', 'DANDI MARCH PIC ON THE BACK', 0, 200, '<p>RS 5 COIN.VERY RARE,DANDI MARCH PIC ON THE BACK</p>', '1361024197_479477002_4-difrent-type-of-rs-5-coin-Art-Collectibles.jpg', '', '', '2013-07-02', '2013-07-17', '2013-07-31', 1, '', 'Y', 'Y'),
(60, 16, 7, 6, '1 rupee Big Dabbu Coin', 'Year 1962', 1000, 0, '<p>The Coin is in good condition</p>', '5155879_1962 One Rupee Coin.jpg', '', '', '2013-07-07', '2013-07-07', '2013-07-31', 1, '', 'Y', 'Y'),
(61, 16, 20, 6, '1958 Ghana Coin', '2 Shilling', 5000, 0, '<p>The coin is in very good condition</p>', '872971_2 shilling of Ghana.jpg', '', '', '2013-07-07', '2013-07-07', '2013-07-31', 1, '', 'Y', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `product_status`
--

CREATE TABLE IF NOT EXISTS `product_status` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `product_id` int(100) NOT NULL,
  `winner_id` int(100) NOT NULL,
  `bid_count` int(200) NOT NULL,
  `shipping_cost` double NOT NULL,
  `order_no` varchar(200) NOT NULL,
  `purchase_date` date NOT NULL,
  `expire_date` date NOT NULL,
  `delivery_date` date NOT NULL,
  `status` varchar(200) NOT NULL DEFAULT 'Pending',
  `courier_name` varchar(200) NOT NULL,
  `tracking_no` varchar(200) NOT NULL,
  `tracking_url` varchar(400) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `product_status`
--

INSERT INTO `product_status` (`id`, `product_id`, `winner_id`, `bid_count`, `shipping_cost`, `order_no`, `purchase_date`, `expire_date`, `delivery_date`, `status`, `courier_name`, `tracking_no`, `tracking_url`, `start_date`, `end_date`) VALUES
(1, 3, 5, 3, 0, '0406071', '2013-07-06', '2013-07-13', '2013-07-14', 'Shipped', 'Blue Dart', 'Pen546fs', 'http://bluedart.com/', '2013-07-06', '2013-07-13'),
(2, 1, 6, 1, 0, '0608072', '2013-07-08', '2013-07-15', '2013-07-29', 'Delivered', 'blue dart', '1234567890', 'http://www.bluedart.com/', '2013-07-08', '2013-07-15'),
(3, 11, 6, 1, 0, '', '0000-00-00', '2013-07-15', '2013-07-15', 'Delivered', 'blue dart', '010101', 'http://www.bluedart.com/', '0000-00-00', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `seller_info`
--

CREATE TABLE IF NOT EXISTS `seller_info` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `user_id` int(100) NOT NULL,
  `product_id` int(100) NOT NULL,
  `remarks` text NOT NULL,
  `expired` enum('Y','N') NOT NULL DEFAULT 'Y',
  `status` enum('Y','N') NOT NULL DEFAULT 'N',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `seller_info`
--

INSERT INTO `seller_info` (`id`, `user_id`, `product_id`, `remarks`, `expired`, `status`) VALUES
(1, 6, 3, '', 'N', 'Y'),
(2, 5, 1, '', 'N', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `temp_user_info`
--

CREATE TABLE IF NOT EXISTS `temp_user_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `password` varchar(222) NOT NULL,
  `email_id` varchar(200) NOT NULL,
  `date_of_birth` date NOT NULL,
  `address` text NOT NULL,
  `city` varchar(200) NOT NULL,
  `zip_code` varchar(80) NOT NULL,
  `state` varchar(200) NOT NULL,
  `country` varchar(200) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `image` varchar(100) NOT NULL DEFAULT 'sample.jpg',
  `remarks` text NOT NULL,
  `entry_date` date NOT NULL,
  `activation_code` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `temp_user_info`
--

INSERT INTO `temp_user_info` (`id`, `first_name`, `last_name`, `user_name`, `password`, `email_id`, `date_of_birth`, `address`, `city`, `zip_code`, `state`, `country`, `phone`, `image`, `remarks`, `entry_date`, `activation_code`) VALUES
(17, 'Goutam', 'Mondal', 'goutam', '123456', 'goutam1mondal@yahoo.com', '1990-03-01', 'habra', 'kolkata', '700123', 'wb', 'India', '8670916655', '', '', '2013-06-29', 'b5ad60fc230898d4369067e5a157e8c6');

-- --------------------------------------------------------

--
-- Table structure for table `user_info`
--

CREATE TABLE IF NOT EXISTS `user_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `password` varchar(222) NOT NULL,
  `email_id` varchar(200) NOT NULL,
  `date_of_birth` date NOT NULL,
  `address` text NOT NULL,
  `city` varchar(200) NOT NULL,
  `zip_code` varchar(80) NOT NULL,
  `state` varchar(200) NOT NULL,
  `country` varchar(200) NOT NULL,
  `phone` varchar(80) NOT NULL,
  `image` varchar(100) NOT NULL DEFAULT 'sample.jpg',
  `ship_first_name` varchar(100) NOT NULL,
  `ship_last_name` varchar(100) NOT NULL,
  `ship_address` text NOT NULL,
  `ship_state` varchar(200) NOT NULL,
  `ship_city` varchar(100) NOT NULL,
  `ship_country` varchar(200) NOT NULL,
  `ship_zip_code` varchar(100) NOT NULL,
  `ship_phone` varchar(100) NOT NULL,
  `ship_fax` varchar(100) NOT NULL,
  `paypal_email` varchar(200) NOT NULL,
  `paypal_auth_id` varchar(200) NOT NULL,
  `paypal_trans_key` varchar(200) NOT NULL,
  `paypal_world_id` varchar(200) NOT NULL,
  `paypal_2checkout_id` varchar(200) NOT NULL,
  `paypal_money_brk_id` varchar(200) NOT NULL,
  `remarks` text NOT NULL,
  `entry_date` date NOT NULL,
  `status` enum('Y','N') NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `user_info`
--

INSERT INTO `user_info` (`id`, `first_name`, `last_name`, `user_name`, `password`, `email_id`, `date_of_birth`, `address`, `city`, `zip_code`, `state`, `country`, `phone`, `image`, `ship_first_name`, `ship_last_name`, `ship_address`, `ship_state`, `ship_city`, `ship_country`, `ship_zip_code`, `ship_phone`, `ship_fax`, `paypal_email`, `paypal_auth_id`, `paypal_trans_key`, `paypal_world_id`, `paypal_2checkout_id`, `paypal_money_brk_id`, `remarks`, `entry_date`, `status`) VALUES
(5, 'Max', 'Payne', 'max', '123', 'souvik.r@arhamcreation.in', '1888-03-10', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'Kolkata', '700009', 'West Bengal', 'India', '9876568037', 'Test Image.jpg', 'Max', 'Payne', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'West Bengal', 'Kolkata', 'India', '700009', '9876568037', '123456789', '', '', '', '', '', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vehicula quam consequat facilisis auctor', '2013-06-19', 'Y'),
(6, 'David', 'Dos', 'dell', '888', 'bibhas.m@arhamcreation.com', '1789-09-20', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis sodales felis non ligula pharetra rutrum.', 'Mumbai', '400039', 'Maharashtra', 'India', '983156897', 'Test Image.jpg', 'David', 'Dos', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis sodales felis non ligula pharetra rutrum.', 'Maharashtra', 'Mumbai', 'India', '400039', '983156897', '', '', '', '', '', '', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis sodales felis non ligula pharetra rutrum.', '2013-06-19', 'Y'),
(7, 'Jack', 'Sparrow', 'jack', '123', 'subhra.s@arhamcreation.com', '1980-09-15', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'Kolkata', '700036', 'West Bengal', 'India', '9433568978', 'Test Image.jpg', 'Jack', 'Sparrow', 'Vivamus sed leo non magna euismod porta nec id massa.', 'West Bengal', 'Kolkata', 'Armenia', '700038', '99999999', '1234567', '', '', '', '', '', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', '2013-06-21', 'Y'),
(8, 'John', 'Wright', 'john', '12345', 'goutam.m@arhamcreation.in', '1982-02-16', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'Kolkata', '700006', 'West Bengal', 'India', '987654321', 'Test Image.jpg', 'John', 'Wright', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'West Bengal', 'Kolkata', 'India', '700006', '987654321', '', '', '', '', '', '', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', '2013-06-21', 'Y'),
(9, 'Praveen', 'Chhajer', 'praveen', 'CoiN@131', 'praveen@arhamcreation.com', '1980-01-11', 'sac', 'cdscsd', '700001', 'cdcds', 'Liberia', '11', 'Almond Crescent1.jpg', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'dsdvc44t45\r\nfdeefde\r\nfrefre', '2013-06-21', 'Y'),
(10, 'vijay', 'sharna', 'vjks', 'tan504cat965', 'jnj.vijay@yahoo.co.in', '1979-05-18', 'sgghhfgnhm', 'gfggh', '700001', 'hfhfh', 'India', '1111', 'sample.jpg', 'vijay', 'sharna', 'sgghhfgnhm', 'hfhfh', 'gfggh', 'India', '700001', '1111', '', '', '', '', '', '', '', '', '2013-06-22', 'Y'),
(13, 'Deepshikha', 'SHARMA', 'ds101', 'tan504cat965', 'deep.sikha1982@gmail.com', '1982-10-29', '255/100 nsc bose rd', 'KOLKATA', '700047', 'WEST BENGAL', 'India', '9331407378', 'sample.jpg', 'Deepshikha', 'SHARMA', '255/100 nsc bose rd', 'WEST BENGAL', 'KOLKATA', 'India', '700047', '9331407378', '', '', '', '', '', '', '', '', '2013-06-23', 'Y'),
(14, 'rajesh', 'sharma', 'rajesh', 'englandindia', 'rajes.kr.sharma@gmail.com', '1976-12-03', '97 raja subodh chandra mullick road', 'kolkata', '700047', 'west bengal', 'India', '8013783220', 'sample.jpg', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2013-06-24', 'Y'),
(15, 'vijay', 'shaw', 'vijay', '23237911vijay', 'vijaykumar.shaw@yahoo.co.in', '1986-01-29', '8 p d road', 'kolkata', '700105', 'west bengal', 'India', '9883686766', 'sample.jpg', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2013-06-24', 'Y'),
(16, 'Soumen Kumar', 'Saha', 'soumi0512', 'MousahA2007', 'soumi0512@gmail.com', '1978-07-11', 'Vill.- Patrasayer, P.O.- Patrasayer, P.S.- Patrasayer, Dist.-Bankura, Pin- 722206', 'Bankura', '722206', 'West Bengal', 'India', '8391881088', 'DSC00159.JPG', 'Soumen Kumar', 'Saha', 'Vill.- Patrasayer, P.O.- Patrasayer, P.S.- Patrasayer, Dist.-Bankura, Pin- 722206', 'West Bengal', 'Bankura', 'India', '722206', '8391881088', '', '', '', '', '', '', '', '', '2013-06-27', 'Y'),
(17, 'sanwar', 'mal', 'sanwarmal', 'tan504cat965', 'ognexports@gmail.com', '1979-05-18', '255/100 nsc bose rd', 'kolkata', '700047', 'west bengal', 'India', '9433089232', 'sample.jpg', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2013-06-27', 'Y'),
(25, 'bibhas', 'maji', 'bibhas', 'bibhas', 'bibhasmaji@ymail.com', '1988-11-30', 'Garia', 'Kolkata', '700001', 'West Bengal', 'India', '9163141505', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2013-06-30', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `views`
--

CREATE TABLE IF NOT EXISTS `views` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `view` int(50) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `views`
--

INSERT INTO `views` (`id`, `view`, `date`) VALUES
(1, 215, '2013-07-08'),
(2, 207, '2013-07-09');
