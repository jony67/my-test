###############################################################################
# ОПИСАНИЕ
# Данные для создания теста представлены в файле test.xlsx на 2-х листах
###############################################################################
import numpy as np
import pandas as pd
# Игнорировать предупреждения:
import warnings
#warnings.filterwarnings("ignore")

###############################################################################
# ЗАГРУЗКА ДАННЫХ
###############################################################################
file="test.xlsx"
data = pd.read_excel(file,
                    sheet_name='data',
                    header=0,
                    index_col=None,
                    na_values='NaN'
                    )
mytable = pd.read_excel(file,
                    sheet_name='table',
                    header=0,
                    index_col=None,
                    na_values='NaN'
                    )
#------------------------------------------------------------------------------
# Переменные
#------------------------------------------------------------------------------
host     =  '127.0.0.1' # IP-адрес MySQL-сервера
#admin    =  'root'      # имя администратора
#pass_a   =  '123'       # пароль администратора
userName =  'user1'    # имя пользователя
pass_k   =  'paswd'    # пароль пользователя
db       =  'test'      # имя базы данных
char     =  'utf8'      # кодировка символов
tableTest=mytable['TableName'][0]   # имя таблицы вопросов
tableAnswer=tableTest+'_a'          # имя таблицы ответов
TestName=mytable['TestName'][0]     # название теста
Autors=mytable['Autors'][0]         # имя автора
NumberAnswer=mytable['NumAnswer'][0]# кол-во вариантов ответов на вопрос
NumberQ=mytable['NumQuestions'][0]  # кол-во вопросов в тесте
TimeTest=mytable['TimeTest'][0]     # время выполнения теста
###############################################################################
# Подключение к БД
###############################################################################
import myconnect as mc
from sqlalchemy import create_engine
print("Программа создания теста в системе Тест-Info:")
print("======================================================================")
print("Введите имя пользователя: ")
admin=str(input())
print("Введите пароль: ")
#pass_a=str(input())

import getpass
import sys

#if sys.stdin.isatty():
pass_a = getpass.getpass('Введите пароль: ')
#else:
#    print('Using readline')
#    pass_a = sys.stdin.readline().rstrip()

print('Read: ', pass_a)


# Подключаемся к БД
connection = mc.getConnection(host, admin, pass_a, db)
###############################################################################
# Запросы
###############################################################################
# SQL-запросы на удаление:
# удаляем таблицу вопросов
sql_delete_test = f'''
DROP TABLE IF EXISTS `{tableTest}`;
'''

# удаляем таблицу ответов
sql_delete_answer = f'''
DROP TABLE IF EXISTS `{tableAnswer}`;
'''

# SQL-запросы на создание:
# создаем таблицу вопросов
sql_create_test = f'''
CREATE TABLE {tableTest} (
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
''' 

# создаем таблицу ответов
sql_create_answer = f'''
CREATE TABLE {tableAnswer} (
    `group` char(255) NOT NULL,
    `login` char(255) NOT NULL,
    `mark` float DEFAULT NULL,
    `true_t` int(11) DEFAULT NULL,
    `no_otv` char(255) DEFAULT NULL,
    `yes_otv` char(255) DEFAULT NULL
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
''' 

# Определяем кол-во записей в таблице REG
sql_reg_num = 'SELECT COUNT(*) AS n FROM `reg`' 

# Получаем список тестов
sql_reg_test = 'SELECT `desk` FROM `reg`' 

# Добавляем запись в таблицу REG
sql_insert_reg = '''INSERT INTO `reg` (
    `no`,`desk`,`qmax`,`tbl`,`autor`,`tip`,`num`,`time`,`vid`)
    VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s)
    '''

# Назначаем права на таблицу ответов
sql_grant_user = f'''
GRANT INSERT ON `{tableAnswer}` TO `{userName}`@`%`; 
'''   
###############################################################################
# Программа
###############################################################################

try:
    # Устанавливаем курсор    
    cursor = connection.cursor()
    #print ("cursor.description: ", cursor.description) 
#------------------------------------------------------------------------------
# Таблица вопросов
#------------------------------------------------------------------------------    
    # Если таблица теста существует, удаляем ее
    cursor.execute(sql_delete_test)
    # Создаем таблицу теста 
    cursor.execute(sql_create_test)    
    database_connection = create_engine('mysql+pymysql://{0}:{1}@{2}/{3}?charset={4}'.
                                        format(admin, pass_a, host, db, char))
    # Заполняем таблицу теста 
    data.to_sql(con=database_connection, name=tableTest, if_exists='replace')   
    ShowMessage('Таблица создана успешно! Было импортировано '+IntToStr(i)+' строк(и).');

#------------------------------------------------------------------------------
# Таблица ответов
#------------------------------------------------------------------------------    
    # Если таблица ответов существует, удаляем ее
    cursor.execute(sql_delete_answer)
    # Создаем таблицу ответов
    cursor.execute(sql_create_answer)
    # устанавливаем права на таблицу ответов для пользователя
    cursor.execute(sql_grant_user)    
#------------------------------------------------------------------------------
# Таблица REG (список всех тестов)
#------------------------------------------------------------------------------ 
    n=pd.read_sql_query(sql_reg_num, database_connection)['n'][0]+1
    testList= pd.read_sql_query(sql_reg_test, database_connection)['desk']
    if (testList[testList==TestName].count()):
        print ('да, '+ TestName)   
    else:
        print ('нет, '+TestName)
        cursor.execute(sql_insert_reg, (
            float(n),
            TestName,
            0,
            tableTest,
            Autors,
            float(NumberAnswer),
            float(NumberQ),
            float(TimeTest),
            0
            )
        )        

    
    connection.commit()    
finally:
    # Закрыть соединение (Close connection).      
    connection.close()