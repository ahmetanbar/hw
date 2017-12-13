from data import *
import matplotlib.pyplot as plt
from matplotlib import style,pyplot
from matplotlib import colors as mcolors
import datetime
import numpy as np
import matplotlib.dates as mdates
#from matplotlib.dates import
import matplotlib.cbook as cbook
#print(values_current("BTC","LTC")) #Şuanki Değeri Verir Ex: "BTC","LTC"
#print(values_history("BTC","LTC")) # Geçmiş Değerleri Verir. Ex: "BTC","ETH"
#print(times_history("BTC","LTC")) # Geçmiş Değerlerin Zamanlarını Verir. Ex: "ETH","BTC"
#print(times_current(type1,type2)) # Şuanki Değerin Zamanını Verir. Ex: "LTC","BTC"
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
    plt.title("BTC - USD History Chart\nCurrent Value = {}",btc_usd_current())
    plt.xticks(rotation=45)
    x = [datetime.datetime.now() - datetime.timedelta(days=i) for i in range(2699)]
    y = values_btc_usd_alltime()
    plt.plot(x, y)
    plt.gcf().autofmt_xdate()
    myFmt = mdates.DateFormatter('%d:%m:%Y')
    plt.gca().xaxis.set_major_formatter(myFmt)
    plt.show()
    plt.close()
graph_history()