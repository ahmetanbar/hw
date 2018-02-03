# coding: utf8
from tkinter import *
from chat_gui import *
from datetime import datetime
import socket
import os
import sys
import select

RECV_BUFR = 16384
USERS_CONNECTED = []
SOCKET = []
USERNAME = []
DEBUG = True

#it run, when click "connect" button
def connect_to_server(gui,SERVER_IP,SERVER_PORT,username):
    try:
        #socket_family(AF_UNIX or 
AF_INET),socket_type(SOCK_STREAM,SOCK_DGRAM)
        clientsocket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
        #socket connection start
        clientsocket.connect((SERVER_IP, SERVER_PORT))
        #username is send
        clientsocket.send(bytes(username,'UTF-8'))

        useraccept = clientsocket.recv(RECV_BUFR).decode()
        #username unique or not unique.
        if useraccept != "NOT_UNIQUE":
            SOCKET.append(clientsocket)
            return [1,clientsocket]
        else:
            return [0,clientsocket]

    except(ConnectionRefusedError):
        gui.display("\nServer offline.\n")
        gui.chat.see(END)
        return [-1,0]


def recv_msg(gui,socket):
    data = socket.recv(RECV_BUFR)
    if not data :
        gui.disconnect()
    else:
        data = data.decode()
        data = "[" + datetime.now().strftime('%H:%M') + "] " + data
        gui.display("\n" + data)

        if "[*]" in data and "entered" in data and len(data.strip()) >= 
1:
            gui.add_user(data.split(" ")[-2])
        if "[*]" in data and "exited" in data:
            gui.remove_user(data.split(" ")[-2])

        gui.chat.see(END)

def socket_handler(gui,socket):
    try:
        while 1:
            socket_list = [socket]
            read_sockets, write_sockets, error_sockets = 
select.select(socket_list, [], [], )

            for sock in read_sockets:
                if sock == socket:
                    recv_msg(gui,sock)

    except(KeyboardInterrupt):
        print("Program terminated.")
        sys.exit()

    except:
        gui.display("\nDisconnected.\n")
        gui.chat.see(END)

def send_msg(server_socket,msg):
    server_socket.send(bytes(msg,'UTF-8'))

def on_closing():
    try:
        if messagebox.askokcancel("Quit", "Do you want to quit?"):
            gui_root.disconnect()
            sys.exit()
    except AttributeError:
        sys.exit()

if __name__ == "__main__":
    root = Tk()
    root.minsize(width=850, height=410)
    root.maxsize(width=850, height=410)
    root.protocol("WM_DELETE_WINDOW", on_closing)
    gui_root = chat_gui(master=root)
    gui_root.mainloop()
