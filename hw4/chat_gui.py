from tkinter import *
from tkinter import messagebox
import chat_client as client
from chat_client import *
from _thread import start_new_thread


class chat_gui(Frame):



    def __init__(self, master=None):

        self.USERS_CONNECTED = [] # users who exist in the chatroom
        self.IS_CONNECTED = False # indicates whether a user is connected
        
        Frame.__init__(self, master)
        self.grid(sticky = W+E+N+S)
        self.master.title("HW Chat")

        self.Frame1 = Frame(master)
        self.Frame1.grid(row = 0, column = 0, rowspan = 5, columnspan = 1, \
        sticky = W+E+N+S)
        self.Frame2 = Frame(master)
        self.Frame2.grid(row = 4, column = 0, rowspan = 3, columnspan = 1, \
        sticky = W+E+N+S)
        self.Frame3 = Frame(master)
        self.Frame3.grid(row = 0, column = 1, rowspan = 5, columnspan = 3, \
        sticky = W+E+N+S)
        self.Frame4 = Frame(master)
        self.Frame4.grid(row = 5, column = 1, rowspan = 1, columnspan = 3, \
        sticky = W+E+N+S)

        self.initialize()

    def initialize(self):

        self.count = 0


        self.ul_label=Label(self.Frame1, text="Online Userlist",foreground="green")   
        self.ul_label.pack(side = "top") 	
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
        self.pw_label=Label(self.Frame2,text="Password")
        self.server = Entry(self.Frame2)
        self.server.insert(0,'45.55.169.97')
        self.port = Entry(self.Frame2)
        self.port.insert(0,'34000')
        self.server.config(state=DISABLED)
        self.port.config(state=DISABLED)
        self.user = Entry(self.Frame2)
        self.pw = Entry(self.Frame2,show = "*")
        self.connect = Button(self.Frame2,text="Connect",command=self.connect,width = 16,foreground="green")
        self.signup = Button(self.Frame2,text="Join Us",command=self.signing,foreground="blue")
        self.s_label.grid(row=0,column=0)
        self.p_label.grid(row=1,column=0)
        self.u_label.grid(row=2,column=0)
        self.pw_label.grid(row=3,column=0)

        self.server.grid(row=0,column=1,columnspan=2)
        self.port.grid(row=1,column=1,columnspan=2)
        self.user.grid(row=2,column=1,columnspan=2)
        self.pw.grid(row=3,column=1,columnspan=2)
        self.connect.grid(row=4,column=2)
        self.signup.grid(row=4,column=0)

        self.chat = Text(self.Frame3)
        self.chat.pack(side="left",expand=1,fill="both")

        self.chat_scrollbar = Scrollbar(self.Frame3,orient="vertical")
        self.chat_scrollbar.config(command=self.chat.yview)
        self.chat_scrollbar.pack(side="left",fill="both")
        self.chat.config(yscrollcommand=self.chat_scrollbar.set)


        self.msg = Entry(self.Frame4)
        self.msg.bind("<Return>", self.send_msg)
        self.msg.pack(side="left",expand=1,fill="both")
        self.msg.config(state=DISABLED)
        self.chat.config(state=DISABLED)

################################
    #######################
 

    def signing(self):

        self.count = self.count + 1

        if self.count%2 == 1:
            self.gui_userlist.pack_forget()
            self.ul_label.pack_forget()
            self.userlist_scrollbar.pack_forget()
            self.jl_label=Label(self.Frame1, text="JOIN US !",foreground="blue")


            self.jl_label.pack(side = "top")

            self.nu_label=Label(self.Frame1, text="Username")
            self.nuser = Entry(self.Frame1)

            self.np_label=Label(self.Frame1, text="Password")
            self.npass = Entry(self.Frame1,show = "*")

            self.nvp_label=Label(self.Frame1, text="Password Verify")
            self.nvpass = Entry(self.Frame1,show = "*")

            self.sgnl_label=Label(self.Frame1, text="----------")
            self.signupok = Button(self.Frame1,text="JOIN",foreground="green",command = self.save)

            self.nu_label.pack(side="top")
            self.nuser.pack(side="top")
            self.np_label.pack(side="top")
            self.npass.pack(side="top")
            self.nvp_label.pack(side="top")
            self.nvpass.pack(side="top")
            self.sgnl_label.pack(side="top")
            self.signupok.pack(side="top",fill="both")
        else:
            self.ul_label = Label(self.Frame1, text="Online Userlist", foreground="green")
            self.ul_label.pack(side="top")
            self.gui_userlist = Listbox(self.Frame1)
            self.gui_userlist.pack(side="left", expand=1, fill="both")
            self.userlist_scrollbar = Scrollbar(self.Frame1, orient="vertical")
            self.userlist_scrollbar.config(command=self.gui_userlist.yview)
            self.userlist_scrollbar.pack(side="left", fill="both")
            self.gui_userlist.config(yscrollcommand=self.userlist_scrollbar.set)

            self.jl_label.pack_forget()
            self.nu_label.pack_forget()
            self.nuser.pack_forget()
            self.np_label.pack_forget()
            self.npass.pack_forget()
            self.nvp_label.pack_forget()
            self.nvpass.pack_forget()
            self.sgnl_label.pack_forget()
            self.signupok.pack_forget()


    def save(self):

        if (len(self.nuser.get()) < 4 or len(self.npass.get()) < 4 or len(self.nvpass.get()) <4) or (self.nvpass.get() != self.npass.get()):

            messagebox.showwarning("WARNING", "Username and Password character number is have to be minumum 5."
                                              " \nYou have to give importance your password.")
        else:

            def okey():
                messagebox.showinfo("CONGRATULATIONS", "Your registration has been completed succesfully.")
                file2 = open("data.txt", "a")
                file2.writelines(self.nuser.get() + "\n")
                file2.writelines(self.npass.get() + "\n")
                file2.close()

            file2 = open("data.txt", "r")
            with open("data.txt") as file:
                x = [i.strip() for i in file]
            # print(len(x))

            for i in range(len(x)):
                if (str(self.nuser.get())) == x[i]:
                    messagebox.showwarning("JOIN ERROR", "USERNAME EXIST")
                    break

                file2.close()

                if int(i+1) == len(x):
                    okey()

    def getmessages(self):

        file = open("messages.txt", "r")

        x = 0
        while str(file.readline()) != "":
            x = x + 1

        file.close()
        file = open("messages.txt", "r")

        for i in range(1, x + 1):
            self.display(str(file.readline()))
            self.display("\n")
        file.close()

        self.chat.see(END)



    def connect(self):
        file2 = open("data.txt", "r")
        with open("data.txt") as file:
            x = [i.strip() for i in file]
        # print(len(x))

        for i in range(len(x)):
            if (str(self.user.get())) == x[i]:
                #Connects to the server.
                if not(self.IS_CONNECTED) and self.server.get() and self.port.get() \
                and self.user.get():
                    connection = client.connect_to_server(self,self.server.get(),\
                    int(self.port.get()),self.user.get())

                    if connection[0] == 1:

                        self.signing()

                        self.signup.config(state=DISABLED)

                        self.IS_CONNECTED = True
                        self.connect.config(text="Disconnect")
                        self.USERNAME = self.user.get()
                        self.SOCKET = connection[1]

                        self.display("Connected to "+self.server.get()+" as "\
                        +self.USERNAME)
                        ################################################################################################################
                        self.msg.config(state=NORMAL)
                        self.chat.config(state=NORMAL)

                        self.getmessages()

                        ################################################################################################################
                        try:
                            data = self.SOCKET.recv(RECV_BUFR)
                            users = data.decode().split('&')
                            for user in users:
                                if (user != users[0]):
                                    self.add_user(user)
                                else:
                                    self.display(users[0])
                            start_new_thread(client.socket_handler,(self,self.SOCKET))
                        except:
                            pass

                    elif connection[0] == 0:
                        self.display("Username exists. Please choose another")
                        self.signup.config(state=NORMAL)

                    else:
                        self.signup.config(state=NORMAL)
                        self.display("Connection failed.")
                else:
                    self.disconnect()
                    self.count = 0
                    self.signup.config(state=NORMAL)

                file2.close()
                break

            if i+1 == len(x):
                messagebox.showwarning("ERROR", "Username not found !")


    def disconnect(self):
        self.SOCKET.shutdown(1)
        self.SOCKET = None
        self.gui_userlist.delete(0,END)
        self.IS_CONNECTED = False
        self.connect.config(text="Connect")

    def send_msg(self, event):
        #Sends a message to the server.
        try:
        	
            prompt = "\n\n["+datetime.now().strftime('%H:%M')+"] "+ \
            self.USERNAME+" > "

            self.display(prompt+self.msg.get())
            print(datetime.now())

            self.chat.see(END)        

            file = open("messages.txt","a")
            file.write("["+str(datetime.now())[11:19]+"] "+self.user.get()+" > "+self.msg.get())
            file.write("\n")
            file.close()
            
            print(self.msg.get())
            #print(type(datetime.now()))
            client.send_msg(self.SOCKET,self.msg.get())
            self.msg.delete(0,END)
        except(AttributeError):

            self.display("\nNo connection.\n")
            self.chat.see(END)

    def add_user(self,user):
        #Adds a user to the chat.

        if len(user.strip()) >= 1:
            self.gui_userlist.insert(0,user)

    def remove_user(self,user):
        #removes a user from the user list.
        i = 0
        for name in self.gui_userlist.get(0,END):
            if name == user:
                self.gui_userlist.delete(i,i)
            i+=1

    def display(self, msg):
        #Displays a message in the chat panel.
        self.chat.configure(state='normal')
        self.chat.insert(END,msg)
        self.chat.tag_configure(msg)
        self.chat.configure(state='disabled')

        if msg.strip() == 'Disconnected.' and self.IS_CONNECTED == True:
            self.disconnect()



