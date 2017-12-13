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

#***************************************************************************************


def select():
    a = Lb.curselection()

    for j in a:
        print(Lb.get(j))
    graph_current("BTC",Lb.get(j))

def select2():
    b = Lb2.curselection()
    for j in b:
        print(Lb2.get(j))
    graph_current("ETH",Lb2.get(j))

Lb = Listbox(window)
Lb2 = Listbox(window)
btcname = Label(window,text = "for BTC")
ethname = Label(window,text = "for ETH")

for j in range(1,15):
    name=names_btc()
    Lb.insert(j,name[j])

for j in range(1,15):
    name2=names_eth()
    Lb2.insert(j,name2[j])

button  = Button(window,text = "Show Graph BTC",command = select,fg="red")
button2 = Button(window,text ="Show Graph ETH",command = select2,fg="blue")


btcname.pack(side=LEFT)
ethname.pack(side=RIGHT)
Lb.pack(side=LEFT)
Lb2.pack(side=RIGHT)
button.pack(side=LEFT)
button2.pack(side=RIGHT)
window.deiconify()
window.mainloop() #window açık.

#BTC bazlı 200 tane para birimi var.
#ETH 58 tane var.