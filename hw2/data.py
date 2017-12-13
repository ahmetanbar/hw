import requests
# Kütüphane Tamamlandı. Sorunsuz Çalışıyor

def values_history(type1,type2): # İstenilen para biriminin geçmiş değerlerini verir.
    api = "https://bittrex.com/api/v1.1/public/getmarkethistory?market="+str(type1)+"-"+str(type2)
    response = requests.get(api)
    json = response.json()
    a = 0
    for i in range(0, 100):
        if "BUY" == str(json["result"][i]["OrderType"]):
            a = a + 1
    values = [0 for i in range(a)]
    a = 0
    for i in range(0,100):
        if "BUY"==str(json["result"][i]["OrderType"]):
            values[a]=format(json["result"][i]["Price"],'.8f')
            a=a+1
    return values[:]
def times_history(type1,type2): # İstenilen para biriminin geçmiş zamanlarını verir.
    api = "https://bittrex.com/api/v1.1/public/getmarkethistory?market="+str(type1)+"-"+str(type2)
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
            z = str(str(json["result"][i]["TimeStamp"]).split("T")[1])[:10].split(":")
            z[0]=str(int(z[0])+3)
            z[1]=str(z[1])
            z[2]=str(z[2])
            t=str(":".join(z))
            times[a]=str(t)
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
    for i in range(0,2699):
        values[a]=json[i]["average"]
        a=a+1
    return values
def names(): # Coin İsimlerini Gönderir.
    api = "https://bittrex.com/api/v1.1/public/getcurrencies"
    response = requests.get(api)
    json = response.json()
    a = 0
    names=[0 for i in range(438)]
    for i in range(0,288):
        names[i]=json["result"][i]["Currency"]
    return names[:]