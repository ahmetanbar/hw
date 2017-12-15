import requests
# Kütüphane Tamamlandı. Sorunsuz Çalışıyor
def values_history(type1,type2): # İstenilen para biriminin geçmiş değerlerini verir.
    api = "https://bittrex.com/api/v1.1/public/getmarkethistory?market="+str(type1)+"-"+str(type2)
    response = requests.get(api)
    json = response.json()
    a = 0
    for i in range(0, 100): # Alış fiyatlarını Arrayimize yazdıracağımız için BUY döndüren json sayısıı bulduk
        if "BUY" == str(json["result"][i]["OrderType"]):
            a = a + 1
    values = [0 for i in range(a)] # Buy döndüren json sayısını Arrayimize yazdırdık(a değeri kadar 0 elemanı yerleştirdik)
    a = 0 #a içeride kullanılacağı için değişkeni 0'ladık
    for i in range(0,100): # elimizde toplam 100 veri var o kadar for döndürdük
        if "BUY"==str(json["result"][i]["OrderType"]): #Alış fiyatı olan Değerleri Gördüğü zaman Arrayimize yazdırması için üstteki metodu kullandık
            values[a]=format(json["result"][i]["Price"],'.8f')
            a=a+1 # i den farklı olarak a sayısını arttırarak Arrayimizin boyutunun doğru eşleşmesini ve aralarda 0 lı değer kalmamasını sağladık.
    return values[:] #fonksiyon çağırıldığında değerlerimizi döndürdük.
def times_history(type1,type2): # İstenilen para biriminin geçmiş zamanlarını verir.
    api = "https://bittrex.com/api/v1.1/public/getmarkethistory?market="+str(type1)+"-"+str(type2)#Api'ya kullanıcıdan alınan değerlerin girilmesi için ++ lar arasına alınan değişkenler yazıldı
    response = requests.get(api)
    json = response.json()
    a = 0
    for i in range(0, 100):
        if "BUY" == str(json["result"][i]["OrderType"]):
            a = a + 1
    times = [0 for i in range(a)]
    a = 0
    for i in range(0, 100):
        if "BUY" == str(json["result"][i]["OrderType"]):
            z = str(str(json["result"][i]["TimeStamp"]).split("T")[1])[:10].split(":")#Alınan zaman değerleri .split() fonksiyonu ile parçalandı, aralarında T olduğu için "T" yazıldı(2017-10-10T23:12:23.4).Ayrılan 2 parça Array olarak ayrıldığı için lazım olan arrayı [1] ile çektik gerekli kısmınıda [:10] son 10 haneyi alarak çektik.
            z[0]=str(int(z[0])+3)#Zaman farkı olan 3 saati eklemen için tekrar split ile saat dakika saniye olarak ayırdık integer değere çevirip 3 saat arttırdık.
            z[1]=str(z[1])#dakikada ve saniyede değişiklik yapılmadığı için onları direk kendi Array değerine eşitledik
            z[2]=str(z[2])
            t=str(":".join(z)) #.join fonksiyonu ile, ':' ile tekrar aynı formatta birleştirdik.
            times[a]=str(t) # birleştirdiğimiz değeri return edeceğimiz değere yazdırdık.
            a = a + 1
    return times[:]
def values_current(type1,type2): # Şuan ki istenilen para birimlerinin oranlarını verir.
    api = "https://bittrex.com/api/v1.1/public/getmarketsummary?market="+type1+"-"+type2
    response = requests.get(api)
    json = response.json()
    json = json["result"][0]["Last"]
    return json
def times_current(type1,type2): # Şuan ki istenilen para birimlerinin oranlarının o anki zamanını verir.
    api = "https://bittrex.com/api/v1.1/public/getmarketsummary?market="+type1+"-"+type2
    response = requests.get(api)
    json = response.json()
    z = str(json["result"][0]["TimeStamp"].split("T")[1])[:10].split(":")
    z[0]=str(int(z[0])+3)
    json=":".join(z)
    return json
def times_btc_usd_alltime():
    api="https://apiv2.bitcoinaverage.com/indices/global/history/BTCUSD?period=alltime&?format=json"
    response=requests.get(api)
    json=response.json()
    a=0
    times=[0 for i in range(2699)]
    for i in range(0,2699):
        times[a]=str(json[i]["time"])[:10]
        a=a+1
    return times
def values_btc_usd_alltime():
    api = "https://apiv2.bitcoinaverage.com/indices/global/history/BTCUSD?period=alltime&?format=json"
    response = requests.get(api)
    json = response.json()
    a=0
    values=[0 for i in range(2699)]
    for i in range(0,2699): #2699 tane değerimiz olduğu için o kadar for ile değerlerini values çektik.
        values[a]=json[i]["average"]
        a=a+1
    return values
def names_eth(): # ETH Bazlı Coin İsimlerini Gönderir.
    api = "https://bittrex.com/api/v1.1/public/getmarkets"
    response = requests.get(api)
    json = response.json()
    a = 0
    names=[0 for i in range(58)] # ETH bazlı 58 kod olduğunu bulduk ve o kadar değer olduğunu bilerek array e yazdırdık.
    for i in range(0,270): # toplamda 270 tane olan değerimizden ETH değeri döndürenleri return edeceğimiz değişkenimize yazdırdık.
        if "ETH"==json["result"][i]["BaseCurrency"]:
            names[a] = json["result"][i]["MarketCurrency"]
            a=a+1
    return names[:]
def names_btc(): # BTC Bazlı Coin İsimlerini Gönderir.
    api = "https://bittrex.com/api/v1.1/public/getmarkets"
    response = requests.get(api)
    json = response.json()
    names=[]
    for value in json["result"]:
        if "BTC"==value["BaseCurrency"]:
            names.append(value["MarketCurrency"])
    return names[:]
def btc_usd_current():
    api="https://blockchain.info/tr/ticker"
    response=requests.get(api)
    json=response.json()
    json=json["USD"]["buy"]
    return json
