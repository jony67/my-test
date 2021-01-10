-- --------------------------
-- Create privilages
-- --------------------------
/*
Скрипт создает пользователя с паролем и дает ему необходимые права,
требуемые для прохождения теста.

Выполнить скрипт после того, как будут созданы все таблицы системы тестирования!!!

Для создания дампа БД 'test' средствами MySQL открыть командную строку,
перейти в каталог с исполняемыми файлами MySQL и выполнить:
1) бэкап БД 'test' от пользователя root вместе с процедурами: 
> mysqldump -u root -p test --routines > имя_файла.sql
2) бэкап всех БД: 
> mysqldump -u root -p --all_databases > имя_файла.sql
*/
SET @username = 'user1'; /* пользователь */
SET @pswd = 'paswd!'; /* пароль */

/* GRANT SELECT ON test.* TO @user@'%' IDENTIFIED BY 'password'; */
set @var_grant=CONCAT('GRANT SELECT ON test.* TO ',@username,'@\'%\' IDENTIFIED BY \'',@pswd,'\'');
prepare pr_grant FROM @var_grant; 
execute pr_grant;

/* GRANT INSERT, UPDATE, DELETE ON test.sessions TO 'user'@'%'; */
set @var_iud=CONCAT('GRANT INSERT, UPDATE, DELETE ON test.sessions TO ',@username,'@\'%\'');
prepare pr_iud FROM @var_iud; 
execute pr_iud;

/* GRANT UPDATE(vid) ON test.reg TO 'user'@'%'; */
set @var_update=CONCAT('GRANT UPDATE(vid) ON test.reg TO ',@username,'@\'%\'');
prepare pr_update FROM @var_update; 
execute pr_update;

-- --------------------------
-- Создание процедур
-- --------------------------
-- --------------------------
-- Процедура установки прав пользователя @user на все таблицы ответов
-- --------------------------
DROP PROCEDURE IF EXISTS `test`.`user_grant`;
delimiter //
CREATE PROCEDURE `test`.`user_grant`()
BEGIN
  DECLARE grant_user VARCHAR(255);
  DECLARE done INT DEFAULT 0;
  DECLARE cur1 CURSOR FOR SELECT TABLE_NAME from information_schema.TABLES where (TABLE_schema='test' and TABLE_NAME LIKE '%\_a');
  DECLARE CONTINUE HANDLER FOR not FOUND SET done = 1;
  SET @username = 'user1'; /* пользователь */
  OPEN cur1;
  REPEAT
      FETCH cur1 INTO grant_user;
        IF NOT done then
          set @var1=CONCAT('GRANT INSERT ON ',grant_user,' TO ',@username,'@\'%\'');
          /*set @var1=CONCAT('REVOKE INSERT ON ',grant_user,' FROM \'user\'@\'%\'');*/
          prepare priv FROM @var1; 
          execute priv;
        END IF;
  UNTIL done END REPEAT;
  CLOSE cur1; 
END //
-- --------------------------
-- Convert from CP-1251 to UTF-8
-- --------------------------
DROP PROCEDURE IF EXISTS `test`.`convert_utf8`;
delimiter //
CREATE PROCEDURE `test`.`convert_utf8`()
BEGIN
  DECLARE t_name VARCHAR(255);
  DECLARE done INT DEFAULT 0;
  DECLARE cur1 CURSOR FOR SELECT TABLE_NAME from information_schema.TABLES where (TABLE_schema='test');
  DECLARE CONTINUE HANDLER FOR not FOUND SET done = 1;
  OPEN cur1;
  REPEAT
      FETCH cur1 INTO t_name;
        IF NOT done then
          set @var1=CONCAT('ALTER TABLE ',t_name,' CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci');
          prepare con FROM @var1; 
          execute con;
        END IF;
  UNTIL done END REPEAT;
  CLOSE cur1; 
END //
-- --------------------------
-- Клонирование таблицы учебной группы
-- --------------------------
DROP PROCEDURE IF EXISTS `test`.`clone_group`;
delimiter //
CREATE PROCEDURE `test`.`clone_group`()
BEGIN
  CREATE TABLE `0_group` (
  `login` varchar(255) DEFAULT NULL,
  `group` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `fullname` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
END //
-- --------------------------
-- Клонирование таблицы вопросов и ответов теста
-- --------------------------
DROP PROCEDURE IF EXISTS `test`.`clone_qtest`;
delimiter //
CREATE PROCEDURE `test`.`clone_qtest`()
BEGIN
CREATE TABLE `0_test_name` (
  `kod` int(11) DEFAULT NULL,
  `npp` int(11) DEFAULT NULL,
  `vopros` longtext,
  `otvet1` longtext,
  `otvet2` longtext,
  `otvet3` longtext,
  `otvet4` longtext,
  `otvet5` longtext,
  `prav` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `0_testname_a` (
  `group` char(255) NOT NULL,
  `login` char(255) NOT NULL,
  `mark` float DEFAULT NULL,
  `true_t` int(11) DEFAULT NULL,
  `no_otv` char(255) DEFAULT NULL,
  `yes_otv` char(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8; 
END //
-- --------------------------
-- Вызов процедур
-- --------------------------
CALL `test`.`user_grant`;