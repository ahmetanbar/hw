from tkinter import *
from tkinter import Tk
from graph import *
window = Tk()
window.title("GUI Interface BETA")

window.withdraw()
window.update_idletasks()

x = (window.winfo_screenwidth() - window.winfo_reqwidth()) / 2     #burada pencere ayarlamaları yaptık
y = (window.winfo_screenheight() - window.winfo_reqheight()) / 2
window.geometry("+%d+%d" % (x, y)) #pencere boyutlandırılması yapıldı.

def select():
    a = Lb.curselection()
    for j in a:
        print(Lb.get(j)) # listboxdan alınan deger
    graph_current("BTC",Lb.get(j)) #listboxdan alınan deger grafıge aktarıldı

def select2():
    b = Lb2.curselection()
    for j in b:
        print(Lb2.get(j))
    graph_current("ETH",Lb2.get(j))

Lb = Listbox(window) #listbox oluşturuldu
Lb2 = Listbox(window)
btcname = Label(window,text = "for BTC") #metin oluştruldu
ethname = Label(window,text = "for ETH")

for j in range(1,15):
    name=names_btc()
    Lb.insert(j,name[j]) #listbox içine verileri yazdırdık  15 olmasının nedeni programı çok yavaşlatmasından dolayı

for j in range(1,15):
    name2=names_eth()
    Lb2.insert(j,name2[j]) 

def searching():
    for j in range(1, 15):
        name = names_btc()
        name2 = names_eth()
        name2[j]
        name[j]
        if(search.get() == name[j]):  #textboxa yazılan degerlerın nereden geldıgını anlamak ıcın yapıldı
            graph_current("BTC", search.get())
            print("YOUR COIN TYPE = BTC")
        elif(search.get() == name2[j]):
            graph_current("ETH", search.get())
            print("YOUR COIN TYPE = ETH")

def btc_usd():
    graph_history()  #btc to usd verileri yazdırıldı

search = Entry(window) #arama oluşturuldu
searchbutton = Button(window, text="Search", command=searching)

button  = Button(window,text = "Show Graph BTC",command = select,fg="red")
button2 = Button(window,text ="Show Graph ETH",command = select2,fg="blue")

btc_usd_button = Button(window,text = "BTC to USD GRAPH",command = btc_usd,fg = "green")

btc_usd_button.pack(side=BOTTOM) #componentlerın yerleri belirlendi ve onaylandı.
searchbutton.pack(side=BOTTOM)
search.pack(side=BOTTOM)
btcname.pack(side=LEFT)
ethname.pack(side=RIGHT)
Lb.pack(side=LEFT)
Lb2.pack(side=RIGHT)
button.pack(side=LEFT)
button2.pack(side=RIGHT)

window.deiconify() #window boyut ayarlamasının çalışması için kullandıldı.
window.mainloop() #window daima  açık kalmasını sağlıyor bunu yazmassak anlık açılıp kapanıyor..

#BTC bazlı 200 tane para birimi var.
#ETH 58 tane var.
