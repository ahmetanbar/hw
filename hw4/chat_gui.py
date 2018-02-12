from tkinter import messagebox
import chat_client as client
from chat_client import *
from _thread import start_new_thread
count=0
class chat_gui(Frame):

    def __init__(self, master=None):
        self.USERS_CONNECTED = []
        self.IS_CONNECTED = False

        Frame.__init__(self, master)
        self.grid(sticky = W+E+N+S)
        self.master.title("Chat")
        self.Frame1 = Frame(master)
        self.Frame1.grid(row=0, column=0, rowspan=5, columnspan=1, sticky=W + E + N + S)
        self.Frame2 = Frame(master)
        self.Frame2.grid(row=4, column=0, rowspan=3, columnspan=1, sticky=W + E + N + S)
        self.Frame3 = Frame(master)
        self.Frame3.grid(row=0, column=1, rowspan=5, columnspan=3, sticky=W + E + N + S)
        self.Frame4 = Frame(master)
        self.Frame4.grid(row=5, column=1, rowspan=1, columnspan=3, sticky=W + E + N + S)
        self.initialize()

    def initialize(self):

        self.count=0
        self.ul_label = Label(self.Frame1,text="Online Userlist", foreground="green")
        self.ul_label.pack(side="top")
        self.gui_userlist = Listbox(self.Frame1)
        self.gui_userlist.pack(side="left", expand=1, fill="both")
        self.userlist_scrollbar = Scrollbar(self.Frame1, orient="vertical")
        self.userlist_scrollbar.config(command=self.gui_userlist.yview)
        self.userlist_scrollbar.pack(side="left", fill="both")
        self.gui_userlist.config(yscrollcommand=self.userlist_scrollbar.set)

        self.s_label = Label(self.Frame2, text="Server_IP")
        self.p_label = Label(self.Frame2, text="Server_Port")
        self.u_label = Label(self.Frame2, text="Username")
        self.pw_label = Label(self.Frame2, text="Password")
        self.server = Entry(self.Frame2)
        self.server.insert(0, '45.55.169.97')
        self.port = Entry(self.Frame2)
        self.port.insert(0, '34000')
        self.server.config(state=DISABLED)
        self.port.config(state=DISABLED)
        self.user = Entry(self.Frame2)
        self.pw = Entry(self.Frame2, show="*")
        self.connect = Button(self.Frame2, text="Connect", command=self.connect, width=16, foreground="green")

        self.signup = Button(self.Frame2, text="Join Us", command=self.signing, foreground="blue")
        self.s_label.grid(row=0, column=0)
        self.p_label.grid(row=1, column=0)
        self.u_label.grid(row=2, column=0)
        self.pw_label.grid(row=3, column=0)

        self.server.grid(row=0, column=1, columnspan=2)
        self.port.grid(row=1, column=1, columnspan=2)
        self.user.grid(row=2, column=1, columnspan=2)
        self.pw.grid(row=3, column=1, columnspan=2)
        self.connect.grid(row=4, column=2)
        self.signup.grid(row=4, column=0)

        self.chat = Text(self.Frame3)
        self.chat.pack(side="left", expand=1, fill="both")


        self.chat_scrollbar = Scrollbar(self.Frame3, orient="vertical")
        self.chat_scrollbar.config(command=self.chat.yview)
        self.chat_scrollbar.pack(side="left", fill="both")
        self.chat.config(yscrollcommand=self.chat_scrollbar.set)

        self.msg = Entry(self.Frame4)
        self.msg.bind("<Return>", self.send_msg)
        self.msg.pack(side="left", expand=1, fill="both")
        self.msg.config(state=DISABLED)
        self.chat.config(state=DISABLED)

    def signing(self):

        self.count = self.count + 1

        if self.count % 2 == 1:
            self.gui_userlist.pack_forget()
            self.ul_label.pack_forget()
            self.userlist_scrollbar.pack_forget()
            self.jl_label = Label(self.Frame1, text="JOIN US !", foreground="blue")

            self.jl_label.pack(side="top")

            self.nu_label = Label(self.Frame1, text="Username")
            self.nuser = Entry(self.Frame1)

            self.np_label = Label(self.Frame1, text="Password")
            self.npass = Entry(self.Frame1, show="*")

            self.nvp_label = Label(self.Frame1, text="Password Verify")
            self.nvpass = Entry(self.Frame1, show="*")

            self.sgnl_label = Label(self.Frame1, text="----------")
            self.signupok = Button(self.Frame1, text="JOIN", foreground="green", command=self.save)

            self.nu_label.pack(side="top")
            self.nuser.pack(side="top")
            self.np_label.pack(side="top")
            self.npass.pack(side="top")
            self.nvp_label.pack(side="top")
            self.nvpass.pack(side="top")
            self.sgnl_label.pack(side="top")
            self.signupok.pack(side="top", fill="both")
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
        joins=[self.nuser.get(),self.npass.get(),self.nvpass.get()]

        if joins[0] and joins[1] and joins[2]:
            if joins[1]==joins[2]:
                if len(joins[1])>5:
                    if joins[0].isalnum():
                        connection=client.connect_for_signup(self, self.server.get(), \
                        int(self.port.get()), self.nuser.get(), self.npass.get())

                        if connection:
                            messagebox.showinfo("CONGRATULATIONS", "Your registration has been completed succesfully.")

                            self.signing()
                        else:
                            messagebox.showinfo("Warning", "The username is already used.")
                    else:
                        messagebox.showinfo("Warning", "Please use only alphanumeric character as username")
                else:
                    messagebox.showinfo("Warning","Password isn't secure enough")
            else:
                messagebox.showinfo("Warning","Passwords aren't the sames.")
        else:
            messagebox.showinfo("Warning","Please don't leave any.")

    def connect(self):
        if not(self.IS_CONNECTED) and self.pw.get() \
        and self.user.get():
            if self.user.get().isalnum():
                connection = client.connect_to_server(self,self.server.get(),\
                int(self.port.get()),self.user.get(),self.pw.get())
            else:
                messagebox.showinfo("Warning", "Please control username!")
                return 1
            if connection[0]:
                if self.count % 2 == 1:
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
                self.chat.config(state=NORMAL)
                self.chat.delete(1.0, END)
                self.chat.config(state=DISABLED)
                self.signup.config(state=DISABLED)
                self.IS_CONNECTED = True
                self.connect.config(text="Disconnect")
                self.USERNAME = self.user.get()
                self.SOCKET = connection[1]
                self.display("Connected to "+self.server.get()+" as "+self.USERNAME+ " $$")
                self.msg.config(state=NORMAL)
                self.chat.config(state=NORMAL)

                try:
                    temp=''
                    while True:
                        data = self.SOCKET.recv(1024)
                        users = data.decode()
                        temp=temp+users
                        if (users[-5:]=="#True"):
                            break
                    temp = temp.split('&')

                    temp=temp[:-1]

                    for user in temp:
                        if(user!=temp[0]):
                            self.add_user(user)
                        else:
                            self.display(temp[0])

                    start_new_thread(client.socket_handler,(self,self.SOCKET))
                    self.chat.see(END)
                except:
                    pass

            elif connection[0]:
                self.display("Username exists. Please choose another $$")
                self.signup.config(state=NORMAL)

            else:
                self.signup.config(state=NORMAL)
                self.display("Connection failed. $$")
        else:
            try:
                self.disconnect()
                self.count = 0
                self.signup.config(state=NORMAL)
            except AttributeError:
                self.display("Plese fill in the textbox correctly $$")
                pass

    def disconnect(self):
        try:
            self.chat.config(state = NORMAL)
            self.chat.delete(1.0,END)
            self.chat.config(state=DISABLED)
            self.SOCKET.shutdown(1)
            self.SOCKET = None
            self.gui_userlist.delete(0,END)
            self.IS_CONNECTED = False
            self.connect.config(text="Connect")
        except:
            self.connect.config(text="Connect")
            sys.exit()

    def send_msg(self,event):
        try:
            prompt = "\n["+datetime.now().strftime('%H:%M')+"] "+"@"+ \
            self.USERNAME+" > "
            self.display(prompt+self.msg.get()+" $$")
            client.send_msg(self.SOCKET,self.msg.get())
            self.msg.delete(0,END)
            self.chat.see(END)
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
        def color_text(edit, tag, word, fg_color='black', bg_color='white'):
            # add a space to the end of the word
            if word=="$$":
                word="\n "
                edit.insert('end',word)
            word = word + " "

            edit.insert('end', word)
            end_index = edit.index('end')
            begin_index = "%s-%sc" % (end_index, len(word) + 1)
            edit.tag_add(tag, begin_index, end_index)
            edit.tag_config(tag, foreground=fg_color, background=bg_color)
        self.chat.configure(state='normal')

        word_list = msg.split()
        print(word_list)
        myword1 = '@kaanaritr'
        myword2 = '@baki'
        myword3 = '@ubuntu'

        tags = ["tg" + str(k) for k in range(len(word_list))]
        for ix, word in enumerate(word_list):
            # word[:len(myword)] for word ending with a punctuation mark
            if word[:len(myword1)] == myword1:
                color_text(self.chat, tags[ix], word, 'blue')
            elif word[:len(myword2)] == myword2:
                color_text(self.chat, tags[ix], word, 'red')
            elif word[:len(myword3)]==myword3:
                color_text(self.chat,tags[ix],word,'orange')
            else:
                color_text(self.chat, tags[ix], word)
        #self.chat.insert(END,msg)

        self.chat.configure(state='disabled')

        if msg.strip() == 'Disconnected.' and self.IS_CONNECTED == True:
            self.disconnect()
