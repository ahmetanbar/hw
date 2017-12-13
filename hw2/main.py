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
    for i in a:
        print(Lb.get(i))
    graph("BTC",Lb.get(i))

Lb = Listbox(window,selectmode=EXTENDED)

Lb.insert(1,"BTC")
Lb.insert(2,"ETH")
Lb.insert(3,"LTC")

button = Button(window,text = "Show Graph",command = select)



Lb.pack()
button.pack()
window.deiconify()
window.mainloop() #window açık.

#BTC bazlı 200 tane para birimi var.
#ETH 58 tane var.