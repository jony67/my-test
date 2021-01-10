USE `test`;
DROP TABLE IF EXISTS `24_group` ;
CREATE TABLE `24_group` (
  `login` varchar(255) DEFAULT NULL,
  `group` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `fullname` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO test.`24_group` (login,`group`,password,fullname) VALUES 
('Иванов В.Е.','24','827ccb0eea8a706c4c34a16891f84e7b','Иванов В.Е.')
,('Петров Н.А.','24','a029d0df84eb5549c641e04a9ef389e5','Петров Н.А.')
,('Сидоров В.А.','24','2f3bc18c0d3e6b1b8a445075535d26e9','Сидоров В.А.')
;