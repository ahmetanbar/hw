import requests
import dateutil.parser
def history(type1,type2): # To Graph
    api = "https://bittrex.com/api/v1.1/public/getmarkethistory?market="+str(type1)+"-"+str(type2)
    response = requests.get(api)
    json = response.json()
    values = []
    times = []

    for value in json["result"]:
        if "BUY"==value["OrderType"]:
            values.append(float(format(value["Price"],'.8f')))
            time = str(value["TimeStamp"].split("T")[1])[:11].split(":")
            time[0] = str(int(time[0]) + 3)
            time = ":".join(time)
            time1=[str(value["TimeStamp"].split("T")[0]),time]
            time1="T".join(time1)
            times.append(dateutil.parser.parse(str(time1)))
    return times[:],values[:]

def current(type1,type2): #To Graph and GUI
    api = "https://bittrex.com/api/v1.1/public/getmarketsummary?market="+type1+"-"+type2
    response = requests.get(api)
    json = response.json()
    if json["success"]==True:
        value = json["result"][0]["Last"]
        time = str(json["result"][0]["TimeStamp"].split("T")[1])[:10].split(":")
        time[0] = str(int(time[0]) + 3)
        time = ":".join(time)
        return True,time, value
    else:
        return False,0,0

def usd_x_alltime(type1):
    api="https://apiv2.bitcoinaverage.com/indices/global/history/"+type1+"USD?period=alltime&?format=json"
    response = requests.get(api)
    json = response.json()
    times = []
    values = []
    for value in json:
        if "00:00:00"==value["time"][11:]:
            times.append(dateutil.parser.parse(value["time"]))
        values.append(value["average"])
    return times[:],values[:]
def names_eth_btc_usdt(): # To GUI
    api = "https://bittrex.com/api/v1.1/public/getmarkets"
    response = requests.get(api)
    json = response.json()
    names_eth=[]
    names_btc=[]
    names_usdt=[]

    for value in json["result"]:
        if "ETH"==value["BaseCurrency"]:
            names_eth.append(value["MarketCurrency"])
        elif "BTC"==value["BaseCurrency"]:
            names_btc.append(value["MarketCurrency"])
        elif "USDT"==value["BaseCurrency"]:
            names_usdt.append(value["MarketCurrency"])
    return names_eth[:],names_btc[:],names_usdt[:]
def calculator(type1,type2):
    api = "https://bittrex.com/api/v1.1/public/getmarketsummary?market=" + type1 + "-" + type2
    response = requests.get(api)
    json = response.json()
    value = json["result"][0]["Last"]
    return value
def matching(type1,base):
    api = "https://bittrex.com/api/v1.1/public/getmarkets"
    response = requests.get(api)
    json = response.json()
    x1=0
    x2=0
    for value in json["result"]:
        if base == value["BaseCurrency"]:
            if type1==value["MarketCurrency"]:
                x1=1
            else:
                x2=0
    if x1==1:
        sum=1
    else:
        sum=0
    return sum
