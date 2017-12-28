#client.py

import socket

host = "159.89.21.124"  # defining server ip
port = 34000          #  defining port
buf = 1024  
work = (host,port)

s = socket.socket(socket.AF_INET,socket.SOCK_STREAM)  #representing ipv4 ,representing tcp way
s.connect(work)

while True:
	text = input(">>")
	s.send(text.encode())
	data=s.recv(buf)
	print(data)


	if text == "q":
		print( "the connection has been terminated.")
		break


s.close()