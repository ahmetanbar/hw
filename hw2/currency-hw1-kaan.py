import matplotlib.pyplot as plt
import requests
import numpy as np
api="https://bittrex.com/api/v1.1/public/getmarkethistory?market=BTC-ETH"
response=requests.get(api)
json=response.json()
a=0
times=[0 for i in range(100)]
values=[0 for i in range(100)]
for i in range(0,100):
    if "BUY"==str(json["result"][i]["OrderType"]):
        times[a]=str(json["result"][i]["TimeStamp"])
        values[a]=format(json["result"][i]["Price"],'.8f')
        a=a+1
print(times[:])
print(values[:])