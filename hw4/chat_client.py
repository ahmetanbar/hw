from tkinter import *
from chat_gui import *
from datetime import datetime
import socket
import os
import sys
import select
import hashlib
from _thread import start_new_thread

global sound_thread

try:
    import winsound
    from winsound import Beep
except:
    import os

RECV_BUFR = 16384
USERS_CONNECTED = []
SOCKET = []
username = []
DEBUG = True

def connect_for_signup(gui,SERVER_IP,SERVER_PORT,username,password):
    try:
        clientsocket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
        h = hashlib.sha512()
        h.update(password.encode("utf8"))
        password = h.hexdigest()

        clientsocket.connect((SERVER_IP, SERVER_PORT))
        namepasswd = username + "&" + password + "&" + "0"
        clientsocket.send(bytes(namepasswd,'UTF-8'))
        useraccept = bool(int(clientsocket.recv(RECV_BUFR).decode()))
        return useraccept
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
        clientsocket.send(bytes(namepasswd,encoding='utf-8'))

        useraccept = clientsocket.recv(RECV_BUFR).decode()

        if useraccept== "1":
            start_new_thread(sound_intro, ())
            SOCKET.append(clientsocket)
            return [True,clientsocket]
        else:
            messagebox.showinfo("Warning", "Your username or password wrong!")
            return [False,clientsocket]

    except(ConnectionRefusedError):
        gui.display("\nServer offline.\n")
        gui.chat.see(END)
        return [-1,0]

def sound_msg():
    try:
        Beep(2000, 200)
        Beep(1500, 200)
        Beep(1000, 200)
    except:
        os.system('play --no-show-progress --null --channels 1 synth %s sine %f' % (2000, 200))
        os.system('play --no-show-progress --null --channels 1 synth %s sine %f' % (1500, 200))
        os.system('play --no-show-progress --null --channels 1 synth %s sine %f' % (1000, 200))


def sound_intro():
    try:
        Beep(440, 500)
        Beep(440, 500)
        Beep(440, 500)
        Beep(349, 350)
        Beep(523, 150)
        Beep(440, 500)
        Beep(349, 350)
        Beep(523, 150)
        Beep(440, 1000)
        Beep(659, 500)
        Beep(659, 500)
        Beep(659, 500)
        Beep(698, 350)
        Beep(523, 150)
        Beep(415, 500)
        Beep(349, 350)
        Beep(523, 150)
        Beep(440, 1000)
    except:
        os.system('play --no-show-progress --null --channels 1 synth %s sine %f' % (440, 500))
        os.system('play --no-show-progress --null --channels 1 synth %s sine %f' % (440, 500))
        os.system('play --no-show-progress --null --channels 1 synth %s sine %f' % (440, 500))
        os.system('play --no-show-progress --null --channels 1 synth %s sine %f' % (349, 350))
        os.system('play --no-show-progress --null --channels 1 synth %s sine %f' % (523, 150))
        os.system('play --no-show-progress --null --channels 1 synth %s sine %f' % (440, 500))
        os.system('play --no-show-progress --null --channels 1 synth %s sine %f' % (349, 350))
        os.system('play --no-show-progress --null --channels 1 synth %s sine %f' % (523, 150))
        os.system('play --no-show-progress --null --channels 1 synth %s sine %f' % (440, 1000))
        os.system('play --no-show-progress --null --channels 1 synth %s sine %f' % (659, 500))
        os.system('play --no-show-progress --null --channels 1 synth %s sine %f' % (659, 500))
        os.system('play --no-show-progress --null --channels 1 synth %s sine %f' % (659, 500))
        os.system('play --no-show-progress --null --channels 1 synth %s sine %f' % (698, 350))
        os.system('play --no-show-progress --null --channels 1 synth %s sine %f' % (523, 150))
        os.system('play --no-show-progress --null --channels 1 synth %s sine %f' % (415, 500))
        os.system('play --no-show-progress --null --channels 1 synth %s sine %f' % (349, 350))
        os.system('play --no-show-progress --null --channels 1 synth %s sine %f' % (523, 150))
        os.system('play --no-show-progress --null --channels 1 synth %s sine %f' % (440, 1000))


def recv_msg(gui,socket):
    data = socket.recv(RECV_BUFR)
    if not data :
        gui.disconnect()
    else:
        data = data.decode()
        print(data)
        data = "[" + datetime.now().strftime('%H:%M') + "] " +data + " $$"
        gui.display("\n" + data)
        data.split(" ")
        if "[*]" in data and "entered" in data and len(data.strip()) >= 1:
            gui.add_user(data.split(" ")[1][4:])
        if "[*]" in data and "exited" in data:
            gui.remove_user(data.split(" ")[1][4:])
        sound_msg()
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
        sys.exit()

    except:
        gui.display("\nDisconnected.\n")
        gui.chat.see(END)

def send_msg(server_socket,msg):
    print(msg)
    server_socket.send(bytes(msg,'UTF-8'))

def on_closing():
    try:
        if messagebox.askokcancel("Quit", "Do you want to quit?"):
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
