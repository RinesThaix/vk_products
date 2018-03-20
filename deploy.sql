CREATE DATABASE vk_test;

CREATE TABLE vk_test.`products` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `description` text(0) NOT NULL,
  `price` int(10) NOT NULL,
  `url` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPRESSED;

CREATE TABLE vk_test.`products_meta` (
  `meta_key` varchar(16) NOT NULL,
  `meta_value` int(10) NOT NULL,
  PRIMARY KEY (`meta_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPRESSED;