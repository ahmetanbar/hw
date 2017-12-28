import socket

<<<<<<< HEAD
host = "159.89.21.124" #server IP
=======
host = "45.55.169.97" #server IP
>>>>>>> 3a7136889a4981d0bc93b295436ef4ab945b5f7b
port = 34000 #connetion port
buf = 1024
run = (host,port)

connect = socket.socket(socket.AF_INET,socket.SOCK_STREAM) #for IPv4 and TCP using
connect.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1) 
connect.bind(run)
connect.listen(4) # I give permision maximum 4 users.

client,address = connect.accept()
print ("Connected:",address[0]) #nofication of connection

while True:
	data = client.recv(buf)
	textmessage = "Welcome to code heaven !!!" 
	client.send(textmessage.encode())

	if data == "q":    #exit to press q
		break
	elif len(data) == 0:
		pass
	else:
		print (data)


client.close()
connect.close()
