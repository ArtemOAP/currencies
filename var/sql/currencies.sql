CREATE TABLE `list`(
  `id` int(11) primary key AUTO_INCREMENT,
  `code` varchar(32) NOT NULL  UNIQUE
) ENGINE=INNODB  AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

create table history(
  `id`int(11) primary key AUTO_INCREMENT,
  `id_currency` int,
  `course`  DECIMAL(12,2) not null,
  `date` datetime DEFAULT CURRENT_TIMESTAMP,
   FOREIGN KEY (id_currency)  REFERENCES list (Id)
) ENGINE=INNODB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE TABLE `user`(
  `id` int(11) primary key AUTO_INCREMENT,
  `name` varchar(32) NOT NULL  UNIQUE,
  `hash` varchar(255) NOT NULL
) ENGINE=INNODB  AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;