from tkinter import *
from chat_gui import *
from datetime import datetime
import socket
import os
import sys
import select
import hashlib
RECV_BUFR = 16384
USERS_CONNECTED = []
SOCKET = []
username = []
DEBUG = True


def connect_for_signup(gui,SERVER_IP,SERVER_PORT,username,password):
    try:
        # socket_family(AF_UNIX or AF_INET),socket_type(SOCK_STREAM,SOCK_DGRAM)
        clientsocket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
        # socket connection start
        h = hashlib.sha512()
        h.update(password.encode("utf8"))
        password = h.hexdigest()
        # print(password)
        clientsocket.connect((SERVER_IP, SERVER_PORT))
        namepasswd = username + "&" + password + "&" + "0"
        # print(namepasswd)
        clientsocket.send(bytes(str(namepasswd),'UTF-8'))
        useraccept = clientsocket.recv(RECV_BUFR).decode()
        # print(useraccept)
        if useraccept != "NOT_UNIQUE":
            return True
        else:
            return False
    except(ConnectionRefusedError):
        messagebox.showinfo("Warning", "Server Offline!")
        gui.chat.see(END)
        return [-1]




def connect_to_server(gui,SERVER_IP,SERVER_PORT,username,password):
    try:
        clientsocket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
        clientsocket.connect((SERVER_IP, SERVER_PORT))
        h = hashlib.sha512()
        h.update(password.encode("utf8"))
        password=h.hexdigest()
        namepasswd = username+"&"+password+"&"+"1"
        clientsocket.send(bytes(namepasswd,'UTF-8'))

        useraccept = clientsocket.recv(RECV_BUFR).decode()

        if useraccept== "OK":
            # print("username parola eslesti sohbete girildi")
            SOCKET.append(clientsocket)
            return [True,clientsocket]
        else:
            messagebox.showinfo("Warning", "Your username or password wrong!")
            return [False,clientsocket]

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

        if "[*]" in data and "entered" in data and len(data.strip()) >= 1:
            gui.add_user(data.split(" ")[-2])
        if "[*]" in data and "exited" in data:
            gui.remove_user(data.split(" ")[-2])

        gui.chat.see(END)

def socket_handler(gui,socket):
    try:
        while 1:
            socket_list = [socket]
            read_sockets, write_sockets, error_sockets = select.select(socket_list, [], [], )

            for sock in read_sockets:
                if sock == socket:
                    recv_msg(gui,sock)

    except(KeyboardInterrupt):
        # print("Program terminated.")
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
def hashing(pw,salt):
    pw_bytes = pw.encode('utf-8')
    salt_bytes = salt.encode('utf-8')
    return hashlib.sha256(pw_bytes + salt_bytes).hexdigest() + "," + salt
if __name__ == "__main__":
    root = Tk()
    root.minsize(width=850, height=410)
    root.maxsize(width=850, height=410)
    root.protocol("WM_DELETE_WINDOW", on_closing)
    gui_root = chat_gui(master=root)
    gui_root.mainloop()