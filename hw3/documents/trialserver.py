#!/usr/bin/python3
import socket, sys, threading

# Simple chat client that allows multiple connections via threads

PORT = 34000  # the port number to run our server on

_version_ = "0.0.1"


class ChatServer(threading.Thread):

    def _init_(self, port, host="10.225.180.162"):
        threading.Thread._init_(self)
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

    # Not currently used. Ensure sockets are closed on disconnect
    def exit(self):
        self.server.close()

    def run_thread(self, conn, addr):
        print('Client connected with ' + addr[0] + ':' + str(addr[1]))
        while True:
            data = conn.recv(1024)
            reply = b'OK...' + data
            print(reply)
            conn.sendall(reply)

        conn.close()  # Close

    def run(self):
        print('Waiting for connections on port %s' % (self.port))
        # We need to run a loop and create a new thread for each connection
        while True:
            conn, addr = self.server.accept()
            threading.Thread(target=self.run_thread, args=(conn, addr)).start()


class ChatClient(object):

    def _init_(self, port, host='localhost'):
        self.host = host
        self.port = port
        self.socket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
        self.socket.connect((self.host, port))

    def send_message(self, msg):
        pass


if _name_ == '_main_':
    server = ChatServer(PORT)
    # Run the chat server listening on PORT
    server.run()

    # Send a message to the chat server

    client = ChatClient(PORT)
    client.send_message("DJ Dikkat")