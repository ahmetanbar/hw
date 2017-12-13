from data import values_history,times_history,values_current,times_current,times_btc_usd_alltime,values_btc_usd_alltime
import matplotlib.pyplot as plt
from matplotlib import style
from matplotlib import colors as mcolors
#print(values_current("BTC","LTC")) #Şuanki Değeri Verir Ex: "BTC","LTC"
#print(values_history("BTC","LTC")) # Geçmiş Değerleri Verir. Ex: "BTC","ETH"
#print(times_history("BTC","LTC")) # Geçmiş Değerlerin Zamanlarını Verir. Ex: "ETH","BTC"
#print(times_current(type1,type2)) # Şuanki Değerin Zamanını Verir. Ex: "LTC","BTC"
def graph_current(type1,type2):
    style.use('ggplot')
    plt.figure(figsize=(15, 10), dpi=50,num=(20))
    plt.title(type1+" - "+type2+" Latest History Chart")
    plt.xticks(rotation=90)
    plt.plot(times_history(type1,type2),values_history(type1,type2))
    plt.show()
#graph_current("BTC","ETH")
def graph_history():
    style.use('ggplot')
    plt.figure(figsize=(15,10),dpi=50,num=(20))
    plt.title("BTC - USD History Chart")
    plt.xticks(rotation=90)
    #plt.xlim(1,100)
    plt.plot(times_btc_usd_alltime(),values_btc_usd_alltime())
    plt.show()
    plt.xlabel("Time")
graph_history()