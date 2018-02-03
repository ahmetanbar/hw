#! /usr/bin/python3
"""
    This module is meant to be a GUI for the chat_client.
"""
from tkinter import *
import chat_client as client
from chat_client import *
from _thread import start_new_thread


class chat_gui(Frame):

    def __init__(self, master=None):
        self.USERS_CONNECTED = [] # users who exist in the chatroom
        self.IS_CONNECTED = False # indicates whether a user is connected

        Frame.__init__(self, master)
        self.grid(sticky = W+E+N+S)
        self.master.title("Chat")

        # set up gui frames
        self.Frame1 = Frame(master)
        self.Frame1.grid(row = 0, column = 0, rowspan = 3, columnspan = 1, \
        sticky = W+E+N+S)
        self.Frame2 = Frame(master)
        self.Frame2.grid(row = 3, column = 0, rowspan = 3, columnspan = 1, \
        sticky = W+E+N+S)
        self.Frame3 = Frame(master)
        self.Frame3.grid(row = 0, column = 1, rowspan = 5, columnspan = 3, \
        sticky = W+E+N+S)
        self.Frame4 = Frame(master)
        self.Frame4.grid(row = 5, column = 1, rowspan = 1, columnspan = 3, \
        sticky = W+E+N+S)

        self.initialize()

    def initialize(self):
        """
        Initializes to GUI.
        """
        # set up chat list
        self.gui_userlist = Listbox(self.Frame1)
        self.gui_userlist.pack(side="left",expand=1,fill="both")
        self.userlist_scrollbar = Scrollbar(self.Frame1,orient="vertical")
        self.userlist_scrollbar.config(command=self.gui_userlist.yview)
        self.userlist_scrollbar.pack(side="left",fill="both")
        self.gui_userlist.config(yscrollcommand=self.userlist_scrollbar.set)

        # set up connection part
        self.s_label=Label(self.Frame2, text="Server_IP")
        self.p_label=Label(self.Frame2, text="Server_Port")
        self.u_label=Label(self.Frame2, text="Username")
        self.server = Entry(self.Frame2)
        self.server.insert(0,'10.12.9.244')
        self.port = Entry(self.Frame2)
        self.port.insert(0,'3001')
        self.user = Entry(self.Frame2)
        self.connect = Button(self.Frame2,text="Connect",command=self.connect)
        self.s_label.grid(row=0,column=0)
        self.p_label.grid(row=1,column=0)
        self.u_label.grid(row=2,column=0)
        self.server.grid(row=0,column=1,columnspan=2)
        self.port.grid(row=1,column=1,columnspan=2)
        self.user.grid(row=2,column=1,columnspan=2)
        self.connect.grid(row=3,column=1)

        # set up chat pane
        self.chat = Text(self.Frame3)
        self.chat.pack(side="left",expand=1,fill="both")
        self.chat_scrollbar = Scrollbar(self.Frame3,orient="vertical")
        self.chat_scrollbar.config(command=self.chat.yview)
        self.chat_scrollbar.pack(side="left",fill="both")
        self.chat.config(yscrollcommand=self.chat_scrollbar.set)

        # set up message input
        self.msg = Entry(self.Frame4)
        self.msg.bind("<Return>", self.send_msg)
        self.msg.pack(side="left",expand=1,fill="both")

    def connect(self):
        """
        Connects to the server.
        """
        if not(self.IS_CONNECTED) and self.server.get() and self.port.get() \
        and self.user.get():
            connection = client.connect_to_server(self,self.server.get(),\
            int(self.port.get()),self.user.get())

            if connection[0] == 1:
                self.IS_CONNECTED = True
                self.connect.config(text="Disconnect")
                self.USERNAME = self.user.get()
                self.SOCKET = connection[1]
                # self.chat.insert(END,"Connected to "+self.server.get()+" as "\
                # +self.USERNAME)
                self.display("Connected to "+self.server.get()+" as "\
                +self.USERNAME,color="green")

                try:
                    data = self.SOCKET.recv(RECV_BUFR)
                    users = data.decode().split('&')
                    for user in users:
                        self.add_user(user)
                    start_new_thread(client.socket_handler,(self,self.SOCKET))
                except:
                    pass

            elif connection[0] == 0:
                # self.chat.insert(END,"Username exists. Please choose another")
                self.display("Username exists. Please choose another",\
                color="red")

            else:
                # self.chat.insert(END,"Connection failed.")
                self.display("Connection failed.",color="red")
        else:
            self.disconnect()

    def disconnect(self):
        """
        Disconnects from a connection to the server.
        """
        self.SOCKET.shutdown(1)
        self.SOCKET = None
        self.gui_userlist.delete(0,END)
        self.IS_CONNECTED = False
        self.connect.config(text="Connect")

    def send_msg(self, event):
        """
        Sends a message to the server.
        """
        try:
            prompt = "\n["+datetime.now().strftime('%H:%M:%S')+"] "+ \
            self.USERNAME+" > "
            # self.chat.insert(END,prompt+self.msg.get())
            self.display(prompt+self.msg.get())
            client.send_msg(self.SOCKET,self.msg.get())
            self.msg.delete(0,END)
        except(AttributeError):
            self.display("\nNo connection.\n",color="red")

    def add_user(self,user):
        """
        Adds a user to the chat.
        """
        if len(user.strip()) >= 1:
            self.gui_userlist.insert(0,user)

    def remove_user(self,user):
        """
        removes a user from the user list.
        """
        i = 0
        for name in self.gui_userlist.get(0,END):
            if name == user:
                self.gui_userlist.delete(i,i)
            i+=1

    def display(self, msg, color='black'):
        """
        Displays a message in the chat panel.
        """
        self.chat.configure(state='normal')
        self.chat.insert(END,msg)
        # self.chat.tag_add(msg, "1.8", "1.13")
        self.chat.tag_configure(msg, foreground=""+color)
        self.chat.configure(state='disabled')

        if msg.strip() == 'Disconnected.' and self.IS_CONNECTED == True:
            self.disconnect()