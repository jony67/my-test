# -*- coding: utf-8 -*-
"""
Created on Sat Sep 12 18:16:36 2020

@author: jony67
"""
import pymysql.cursors   
# Функция возвращает connection.
def getConnection(my_host, my_user, my_pass, my_db, my_charset='utf8'):
     
    # Вы можете изменить параметры соединения.
    connection = pymysql.connect(host=my_host,
                                 user=my_user,
                                 password=my_pass,                             
                                 db=my_db,
                                 charset=my_charset,
                                 cursorclass=pymysql.cursors.DictCursor)
    return connection

'''
#Пример использования:

host  =  '127.0.0.1'
user  =  'root'
passs =  '123' 
db    =  'test'

connection = getConnection(host, user, passs, db)
# SQL-запрос
sql = "SELECT * FROM my_table "   
    
try:
    # Устанавливаем курсор    
    cursor = connection.cursor()
    # Выполняем запрос  и передаем 1 параметр.
    cursor.execute(sql)
    # описание курсора    
    print ("cursor.description: ", cursor.description)
    for row in cursor:
        #print(row) # печать всех полей в строке
        # Печать полей отдельно
        print (" ----------- ")
        print ("Номер: ", row["Number"])
        print ("Имя: ", row["Name"])             
finally:
    # Закрыть соединение (Close connection).      
    connection.close()
'''  
