from tkinter import *
from tkinter import Tk
from graph import *

window = Tk()
window.title("GUI Interface BETA")

window.withdraw()
window.update_idletasks()  # Update "requested size" from geometry manager

x = (window.winfo_screenwidth() - window.winfo_reqwidth()) / 2
y = (window.winfo_screenheight() - window.winfo_reqheight()) / 2
window.geometry("+%d+%d" % (x, y))

def login():
    print("Not Found !")

def login_verify():
    user = entry_1.get()
    pswd = entry_2.get()
    graph(user,pswd)

user = Label(window,text = "1.Currency Name: ")
pswd = Label(window,text = "2.Currency Name: ")
button = Button(window,text = "Show Graph",command = login_verify)

Lb = Listbox(window,selectmode=EXTENDED)
Lb.insert(1,"BTC")
Lb.insert(2,"ETH")
Lb.insert(3,"LTC")
Lb.pack()

user.grid(row = 0,column = 0,sticky = E) #row = satır ---- W - E - N - S.
pswd.grid(row = 1,column = 0,sticky = E) #column = sütun  ----- sticky yapıstırır.
button.grid(row = 2,column = 1)

entry_1 = Entry(window) #Textbox yapar.
entry_2 = Entry(window)

entry_1.grid(row = 0,column = 1)
entry_2.grid(row = 1,column = 1)

window.deiconify()
window.mainloop() #window açık.
