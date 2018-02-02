from chat_gui import *
from datetime import datetime
import socket
import sys
import select

RECV_BUFR = 16384
USERS_CONNECTED = [] # users who exist in the chatroom
SOCKET = [] # socket to the server
USERNAME = [] # users username


def connect_to_server(gui,SERVER_IP,SERVER_PORT,username):

    try:
        # access to connect to server
        clientsocket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
        clientsocket.connect((SERVER_IP, SERVER_PORT))

        # send username
        clientsocket.send(bytes(username,'UTF-8'))
        clientsocket.settimeout(30)
        ack = clientsocket.recv(RECV_BUFR).decode()

        if ack != "NOT_UNIQUE": # unique username
            SOCKET.append(clientsocket)
            return [1,clientsocket]
        else: # username is not unique
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
        # decode newly received message
        data = data.decode()



        data = "[" + datetime.now().strftime('%H:%M') + "] " + data
        gui.display(data+"\n")



        file = open("messages.txt","a")
        #file.write("["+str(datetime.now())[11:19]+"] "+self.user.get()+" > "+self.msg.get())
        file.write(data+"\n")
        file.close()

        # a new user has entered. Add to the GUI
        if "[*]" in data and "entered" in data and len(data.strip()) >= 1:
            gui.add_user(data.split(" ")[-2])

        # a user has left. Remove from the GUI
        if "[*]" in data and "exited" in data:
            gui.remove_user(data.split(" ")[-2])

        gui.chat.see(END)



def socket_handler(gui,socket):

    #Handler for socket processing.
    try:
        while 1:
            socket_list = [socket]

            # Get the list sockets which are readable
            read_sockets, write_sockets, error_sockets = select.select(socket_list , [], [])

            for sock in read_sockets:
                # incoming message from remote server
                if sock == socket:
                    recv_msg(gui,sock)

    except(KeyboardInterrupt):
        print("Program terminated.")
        sys.exit()

    except:

        gui.display("\nDisconnected.\n")
        gui.chat.see(END)


def send_msg(server_socket,msg):

    #Allows a user to send a message to the chat server using the given socket.
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
