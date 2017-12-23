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
            times.append(dateutil.parser.parse(value["TimeStamp"]))
    return times[:],values[:]
def current(type1,type2): #To Graph and GUI
    api = "https://bittrex.com/api/v1.1/public/getmarketsummary?market="+type1+"-"+type2
    response = requests.get(api)
    json = response.json()
    value = json["result"][0]["Last"]
    time = str(json["result"][0]["TimeStamp"].split("T")[1])[:10].split(":")
    time[0]=str(int(time[0])+3)
    time=":".join(time)
    return time,value
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
        if "BTC"==value["BaseCurrency"]:
            names_btc.append(value["MarketCurrency"])
        else:
            names_usdt.append(value["MarketCurrency"])
    return names_eth[:],names_btc[:],names_usdt[:]
