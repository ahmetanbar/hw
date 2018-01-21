from tkinter import *
from chat_gui import *
from chat_client_cli import *
from datetime import datetime
import socket
import os
import sys
import select

RECV_BUFR = 4096
USERS_CONNECTED = []
SOCKET = []
USERNAME = []
DEBUG = True

def connect_to_server(gui,SERVER_IP,SERVER_PORT,username):
    try:
        clientsocket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
        clientsocket.connect((SERVER_IP, SERVER_PORT))

        clientsocket.send(bytes(username,'UTF-8'))
        clientsocket.settimeout(30)
        ack = clientsocket.recv(RECV_BUFR).decode()

        if ack != "NOT_UNIQUE":
            SOCKET.append(clientsocket)
            return [1,clientsocket]
        else:
            return [0,clientsocket]

    except(ConnectionRefusedError):
        gui.display("\nServer offline.\n")
        return [-1,0]


def recv_msg(gui,socket):
    data = socket.recv(RECV_BUFR)
    if not data :
        gui.disconnect()
    else:
        data = data.decode()
        data = "[" + datetime.now().strftime('%H:%M') + "] " + data
        gui.display("\n"+data)
        if "[*]" in data and "entered" in data and len(data.strip()) >= 1:
            gui.add_user(data.split(" ")[-2])
        if "[*]" in data and "exited" in data:
            gui.remove_user(data.split(" ")[-2])


def socket_handler(gui,socket):
    try:
        while 1:
            socket_list = [socket]
            read_sockets, write_sockets, error_sockets = select.select(socket_list , [], [],)

            for sock in read_sockets:
                if sock == socket:
                    recv_msg(gui,sock)

    except(KeyboardInterrupt):
        print("Program terminated.")
        sys.exit()

    except:
        gui.display("\nDisconnected.\n")


def send_msg(server_socket,msg):
    server_socket.send(bytes(msg,'UTF-8'))


if __name__ == "__main__":
    if len(sys.argv) >= 2 and sys.argv[1] == "-c":
        cli_chat_client()
    else:
        root = Tk()
        gui_root = chat_gui(master=root)
        gui_root.mainloop()