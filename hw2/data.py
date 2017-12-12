import requests
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
            times[a] = str(json["result"][i]["TimeStamp"])
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
    json = json["result"][0]["TimeStamp"]
    return json