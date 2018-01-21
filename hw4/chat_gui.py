# coding: utf8
from tkinter import *
import chat_client as client
from chat_client import *
from _thread import start_new_thread

class chat_gui(Frame):

    def __init__(self, master=None):
        self.USERS_CONNECTED = []
        self.IS_CONNECTED = False

        Frame.__init__(self, master)
        self.grid(sticky = W+E+N+S)
        self.master.title("Chat")

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
        self.gui_userlist = Listbox(self.Frame1)
        self.gui_userlist.pack(side="left",expand=1,fill="both")
        self.userlist_scrollbar = Scrollbar(self.Frame1,orient="vertical")
        self.userlist_scrollbar.config(command=self.gui_userlist.yview)
        self.userlist_scrollbar.pack(side="left",fill="both")
        self.gui_userlist.config(yscrollcommand=self.userlist_scrollbar.set)

        self.s_label=Label(self.Frame2, text="Server_IP")
        self.p_label=Label(self.Frame2, text="Server_Port")
        self.u_label=Label(self.Frame2, text="Username")
        self.server = Entry(self.Frame2)
        self.server.insert(0,'45.55.169.97')
        self.port = Entry(self.Frame2)
        self.port.insert(0,'34000')
        self.user = Entry(self.Frame2)
        self.connect = Button(self.Frame2,text="Connect",command=self.connect)
        self.s_label.grid(row=0,column=0)
        self.p_label.grid(row=1,column=0)
        self.u_label.grid(row=2,column=0)
        self.server.grid(row=0,column=1,columnspan=2)
        self.port.grid(row=1,column=1,columnspan=2)
        self.user.grid(row=2,column=1,columnspan=2)
        self.connect.grid(row=3,column=1)

        self.chat = Text(self.Frame3)
        self.chat.pack(side="left",expand=1,fill="both")
        self.chat_scrollbar = Scrollbar(self.Frame3,orient="vertical")
        self.chat_scrollbar.config(command=self.chat.yview)
        self.chat_scrollbar.pack(side="left",fill="both")
        self.chat.config(yscrollcommand=self.chat_scrollbar.set)

        self.msg = Entry(self.Frame4)
        self.msg.bind("<Return>", self.send_msg)
        self.msg.pack(side="left",expand=1,fill="both")

    def connect(self):
        if not(self.IS_CONNECTED) and self.server.get() and self.port.get() \
        and self.user.get():
            connection = client.connect_to_server(self,self.server.get(),\
            int(self.port.get()),self.user.get())

            if connection[0] == 1:
                self.IS_CONNECTED = True
                self.connect.config(text="Disconnect")
                self.USERNAME = self.user.get()
                self.SOCKET = connection[1]
                self.display("Connected to "+self.server.get()+" as "\
                +self.USERNAME)
                #################################################
                #  when users login, past messages will be add
                #################################################
                try:
                    data = self.SOCKET.recv(RECV_BUFR)
                    users = data.decode().split('&')
                    for user in users:
                        self.add_user(user)
                    start_new_thread(client.socket_handler,(self,self.SOCKET))
                except:
                    pass

            elif connection[0] == 0:
                self.display("Username exists. Please choose another")

            else:
                self.display("Connection failed.")
        else:
            self.disconnect()

    def disconnect(self):
        self.SOCKET.shutdown(1)
        self.SOCKET = None
        self.gui_userlist.delete(0,END)
        self.IS_CONNECTED = False
        self.connect.config(text="Connect")

    def send_msg(self, event):
        try:
            prompt = "\n["+datetime.now().strftime('%H:%M')+"] "+ \
            self.USERNAME+" > "
            self.display(prompt+self.msg.get())
            print(datetime.now())
            print(type(datetime.now()))
            client.send_msg(self.SOCKET,self.msg.get())
            self.msg.delete(0,END)
        except(AttributeError):
            self.display("\nNo connection.\n")

    def add_user(self,user):
        if len(user.strip()) >= 1:
            self.gui_userlist.insert(0,user)

    def remove_user(self,user):
        i = 0
        for name in self.gui_userlist.get(0,END):
            if name == user:
                self.gui_userlist.delete(i,i)
            i+=1

    def display(self, msg):
        self.chat.configure(state='normal')
        self.chat.insert(END,msg)
        self.chat.tag_configure(msg, foreground="")
        self.chat.configure(state='disabled')

        if msg.strip() == 'Disconnected.' and self.IS_CONNECTED == True:
            self.disconnect()