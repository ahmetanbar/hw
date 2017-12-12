import requests
api="https://bittrex.com/api/v1.1/public/getmarkethistory?market=BTC-ETH"
response=requests.get(api)
json=response.json()
def values():
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
def times():
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