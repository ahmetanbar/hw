import socket

host = "10.193.14.6" #sunucu IP`si
port = 34000 #haberlesme portu
buf = 1024
run = (host,port)

connect = socket.socket(socket.AF_INET,socket.SOCK_STREAM) #IPv4 ve TCP kullanimi icin.
connect.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1) 
connect.bind(run)
connect.listen(4) #maximum 4 ıstemcıye izin verdim.

client,address = connect.accept()
print ("Connected:",address[0]) #baglandigini anladim

while True:
	data = client.recv(buf)
	textmessage = "Welcome to code heaven !!!" #karsidaki ki her yazdiginda cevap yolluyorum.
	client.send(textmessage.encode())

	if data == "q":    #karsidaki q ile cikis yapiyor
		break
	elif len(data) == 0:
		pass
	else:
		print (data)


client.close()
connect.close()
