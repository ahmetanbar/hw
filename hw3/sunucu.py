import socket

host = "10.193.14.6" #sunucu IP`si
port = 34000 #haberlesme portu
buf = 1024
calistir = (host,port)

bagla = socket.socket(socket.AF_INET,socket.SOCK_STREAM) #IPv4 ve TCP kullanimi icin.
bagla.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1) 
bagla.bind(calistir)
bagla.listen(4) #maximum 4 ıstemcıye izin verdim.

istemci,adres = bagla.accept()
print ("Baglanti Geldi:",adres[0]) #baglandigini anladim

while True:
	data = istemci.recv(buf)
	veri = "Ben Sunucu Botuyum. Serverimize hosgeldiniz ben mekan sahibi :)" #karsidaki ki her yazdiginda cevap yolluyorum.
	istemci.send(veri.encode())

	if data == "q":    #karsidaki q ile cikis yapiyor
		break
	elif len(data) == 0:
		pass
	else:
		print (data)


istemci.close()
bagla.close()
