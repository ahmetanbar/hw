import sqlite3

conn = sqlite3.connect("users.db")
cursor = conn.cursor()
cursor.execute('''CREATE TABLE userdata
             (date text, trans text, symbol text, qty real, price real)''')