from data import * # yazdığımız data kütüphanesindeki tüm fonksiyonları çektik asd
import matplotlib
matplotlib.use("TkAgg")
import matplotlib.pyplot as plt
from matplotlib import style # matplotlib in style fonksiyonu çekildi
import datetime # datetime kütüphanesi eklendi
import matplotlib.dates as mdates #matplotlib e dateler yazdırmak için kütüphane eklendi
def graph_current(type1,type2): # Yakın Zaman Grafiğini Veriyor.
    style.use('ggplot') #ggplot tasarımındaki tablomuzun stylenı belirledik.
    plt.figure(figsize=(15, 10), dpi=50,num=(20))#Tablodaki verilerin font ayarlarını yaptık.
    plt.title(type1+" - "+type2+" Latest History Chart")#Tablo Başlığını Kullanıcıan Aldığımız Değerlere göre yazdırdık.
    plt.xticks(rotation=90)#x eksenindeki gelen verileri daha rahat görünüp üst üste binmemesi için rotate ettik.
    plt.plot(times_history(type1,type2),values_history(type1,type2))#(x,y) formatında değişkenlerimizi tabloya gönderdik.
    plt.show()#tabloyu gösterdik.
    plt.close()
def graph_history(): # BTC-USD Geçmiş Zaman Grafiğini Veriyor
    style.use('ggplot')
    plt.figure(figsize=(15, 10), dpi=50, num=(20))
    title1="BTC - USD History Chart\nCurrent Buy Price ="+str(btc_usd_current())#Üsttekine ek Current Valuelarda Başlığa Eklendi.
    plt.title(title1)
    plt.xticks(rotation=45)
    x = [datetime.datetime.now() - datetime.timedelta(days=i) for i in range(2699)]#datetime kütüphanesi kullanılarak şuanki zamanda günlük olarak geriye doğru elimizdeki değer kadar değeri array e yazdırdık.
    y = values_btc_usd_alltime() # data kütüphanemizden çektiğimiz değerleri y eksenine bastırdık.
    plt.plot(x, y)
    plt.gcf().autofmt_xdate()
    myFmt = mdates.DateFormatter('%d:%m:%Y') # Datatime daki değerlerin hangi formatta yazdırılacağını seçtik.
    plt.gca().xaxis.set_major_formatter(myFmt)
    plt.show()
    plt.close()
