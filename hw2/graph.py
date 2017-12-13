from data import *
import matplotlib.pyplot as plt
from matplotlib import style,pyplot
import datetime
import matplotlib.dates as mdates
def graph_current(type1,type2): # Yakın Zaman Grafiğini Veriyor.
    style.use('ggplot')
    plt.figure(figsize=(15, 10), dpi=50,num=(20))
    plt.title(type1+" - "+type2+" Latest History Chart")
    plt.xticks(rotation=90)
    plt.plot(times_history(type1,type2),values_history(type1,type2))
    plt.show()
def graph_history(): # BTC-USD Geçmiş Zaman Grafiğini Veriyor
    style.use('ggplot')
    plt.figure(figsize=(15, 10), dpi=50, num=(20))
    title1="BTC - USD History Chart\nCurrent Buy Price ="+str(btc_usd_current())
    plt.title(title1)
    plt.xticks(rotation=45)
    x = [datetime.datetime.now() - datetime.timedelta(days=i) for i in range(2699)]
    y = values_btc_usd_alltime()
    plt.plot(x, y)
    if times_btc_usd_alltime()==str(x):
        plt.scatter(x, y)
    plt.gcf().autofmt_xdate()
    myFmt = mdates.DateFormatter('%d:%m:%Y')
    plt.gca().xaxis.set_major_formatter(myFmt)
    plt.show()
    plt.close()