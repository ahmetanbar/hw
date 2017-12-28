#!/usr/bin/python3
import socket, sys, threading

# Simple chat client that allows multiple connections via threads

PORT = 34000  # the port number to run our server on

class ChatServer(threading.Thread):

    def __init__(self, port, host="10.225.162.41"):
        threading.Thread.__init__(self)
        self.port = port
        self.host = host
        self.server = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
        self.users = {}  # current connections
        try:
            self.server.bind((self.host, self.port))
        except socket.error:
            print('Bind failed %s' % (socket.error))
            sys.exit()

        self.server.listen(10)
        global descriptors
        descriptors = [self.server]

    # Not currently used. Ensure sockets are closed on disconnect
    def exit(self):
        self.server.close()

    def run_thread(self, conn, addr):
        print('Client connected with ' + addr[0] + ':' + str(addr[1]))
        while True:
            data = conn.recv(65535)
            reply = data
            print(reply.decode("utf-8")) #convert bytes to string
            conn.sendall(reply)
        # conn.close()  # Close

    def run(self):
        global i
        i = 0
        # print("PORT: "+str(self.port))
        # print("HOST: "+str(self.host))
        print('Waiting for connections on port %s' % (self.port))
        # We need to run a loop and create a new thread for each connection
        while True:
            conn, addr = self.server.accept()
            print(addr[0])

            threading.Thread(target=self.run_thread, args=(conn, addr)).start()
            # print("CONN: "+str(conn))
            # print("ADDR: "+str(addr))


class ChatClient(object):

    def __init__(self, port, host='localhost'):
        self.host = host
        self.port = port
        self.socket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
        self.socket.connect((self.host, port))
        print(port)
        print(host)

    def send_message(self, msg):
        pass


server = ChatServer(PORT)
    # Run the chat server listening on PORT
server.run()

    # Send a message to the chat server

client = ChatClient(PORT)