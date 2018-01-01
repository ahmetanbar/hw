import socket
import datetime

file = open("reg.txt",'a')
users = open("users.txt",'a')
passwords = open("pass.txt",'a')

#host = "10.225.162.41"  # defining server ip
host="10.225.180.162"
port = 34000          #  defining port
buf = 65535
work = (host,port)


s = socket.socket(socket.AF_INET,socket.SOCK_STREAM)  #representing ipv4 ,representing tcp way
print("Enter your text message")
s.connect(work)


ip = str(socket.gethostname())
while True:
	text = input("")
	time = str(datetime.datetime.time(datetime.datetime.now()))[:8]
	file = open("reg.txt", "a")
	if (text).encode():
		s.send(ip.encode()+ "--> ".encode() + text.encode() +" (".encode()+ time.encode()+")".encode())
		file.write(str(ip)+"--> "+str(text)+" ("+str(time)+")")
		file.write('\n')
		file.flush()
		file.close()

	else:
		bos=" "
		s.send(bos.encode())
	data=s.recv(buf)
	print(data.decode("utf-8"))

	if text == "q":
		print( "the connection has been terminated.")
		break


s.close()
