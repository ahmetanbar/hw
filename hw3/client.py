#client.py

import socket

host = "10.193.14.6"  # fixed server ipsi ile degistirilecek
port = 34000          # port tanimlandi
buf = 1024  
calistir = (host,port)

s = socket.socket(socket.AF_INET,socket.SOCK_STREAM)  #ipv4 turunde ip kullanildigi icin af_inet kullanildi, sock_Stream
							#  ise iletimimizi TCP kontrollu yaptigimizi gosteriyor
s.connect(calistir)

while True:
	gonder = input(">>")
	s.send(gonder.encode())
	data=s.recv(buf)
	print(data)


	if gonder == "q":
		print( "Baglanti Kapatildi..")
		break


s.close()