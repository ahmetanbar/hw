from tkinter import *

window = Tk()
window.title("GUI Interface BETA")
window.geometry("250x100")
#window.configure(background = "red")
def login():
    print("Not yet :)")

def login_verify():
    user = entry_1.get()
    pswd = entry_2.get()
    if user == "baki" and pswd == "123":
        print("As soon as")
        window.configure(background="green")
    else:
        login()

user = Label(window,text = "Username: ")
pswd = Label(window,text = "Password: ")
button = Button(window,text = "Login",command = login_verify)
#button.bind("<Button-1>",push)

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