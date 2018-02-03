import socket

#host = "10.225.162.41"  # defining server ip
host="10.225.180.162"
port = 34000          #  defining port
buf = 65535
work = (host,port)

s = socket.socket(socket.AF_INET,socket.SOCK_STREAM)  #representing ipv4 ,representing tcp way
print(s)
s.connect(work)

ip = str(socket.gethostname())
print(ip)
while True:
	text = input("")
	if (text).encode():
		s.send(ip.encode()+ " ".encode() + text.encode())
	else:
		bos=" "
		s.send(bos.encode())
	data=s.recv(buf)
	print(data.decode("utf-8"))
	# open("o")

	if text == "q":
		print( "the connection has been terminated.")

		break


s.close()
