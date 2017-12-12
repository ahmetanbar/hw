from tkinter import *

window = Tk()

def push():
    print("Not yet :)")

user = Label(window,text = "Username: ")
pswd = Label(window,text = "Password: ")
button = Button(window,text = "Login",command = push)

user.grid(row = 0,column = 0,sticky = E) #row = satır ---- W - E - N - S.
pswd.grid(row = 1,column = 0,sticky = E) #column = sütun  ----- sticky yapıstırır.
button.grid(row = 2,column = 1)

entry_1 = Entry(window) #Textbox yapar.
entry_2 = Entry(window)

entry_1.grid(row = 0,column = 1)
entry_2.grid(row = 1,column = 1)


remember = Checkbutton(window,text = "Don`t forget me ")
remember.grid(columnspan = 2) #columnspan = kaç sütunun altına koyulacağını ayarlar.(ortaya yapar)

window.mainloop() #window açık.