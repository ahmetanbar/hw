import matplotlib.pyplot as plt
from data import *
import matplotlib.animation as animation
import matplotlib.dates as mdates #matplotlib e dateler yazdırmak için kütüphane eklendi
from matplotlib import style
def graph_latest(type1,type2):
    fig=plt.figure(figsize=(15, 10), dpi=50,num=20)
    style.use('ggplot') #ggplot tasarımındaki tablomuzun stylenı belirledik.
    ax1=fig.add_subplot(1,1,1)
    def animate(i):
        time, value = current(type1, type2)
        title = type1 + " - " + type2 + " Latest History Chart\nCurrent Price = " +str(value)
        ax1.set_title(title)
        plt.xticks(rotation=90,size=15)  # x eksenindeki gelen verileri daha rahat görünüp üst üste binmemesi için rotate ettik.
        plt.gcf().autofmt_xdate()
        myFmt = mdates.DateFormatter('%H:%M:%S')  # Datatime daki değerlerin hangi formatta yazdırılacağını seçtik.
        plt.gca().xaxis.set_major_formatter(myFmt)
        x, y=history(type1,type2)
        #ax1.clear() Eğer değerler olan grafiğe eklenirse bu eklenmeyecek.
        ax1.plot(x,y,color='red')
    ani=animation.FuncAnimation(fig, animate,interval=1000)
    plt.show()
#graph_current("BTC","LTC")
def graph_usd_x_alltime(type1):
    fig=plt.figure(figsize=(15,10), dpi=50, num=20)
    style.use('ggplot')
    ax1=fig.add_subplot(1,1,1)
    def animate(i):
        time, value = current("USDT",type1)
        title ="USD - " + type1 + " All Time History Chart\nCurrent Price = " + str(value)
        ax1.set_title(title)
        plt.xticks(rotation=90,size=15)
        plt.gcf().autofmt_xdate()
        myFmt=mdates.DateFormatter('%H:%M:%S')
        plt.gca().xaxis.set_major_formatter(myFmt)
        x, y =usd_x_alltime(type1)
        ax1.plot(x,y,color='red')
    ani=animation.FuncAnimation(fig,animate,interval=1000)
    plt.show()
