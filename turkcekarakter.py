#--coding:cp1254

import requests

url="https://poloniex.com/public?command=returnTicker"
veri = requests.get(url)
json_verim = veri.json()

choose=input("1-Bitcoin bazlı fiyatlar \n2-Dolar bazlı fiyatlar ")

if choose=="1":
    cryptos=[("BTC_BCN","Byte Coin"),("BTC_BELA","Bela"),("BTC_BLK","Black Coin")]
    for (i,j) in cryptos:
        print( "One ? = {} {}".format(1/float(json_verim[i]["last"]),j))
    print("One ? = " + json_verim["USDT_BTC"]["last"] + "dolar")


elif choose=="2":
    cryptos2=[("USDT_BTC","?"),("USDT_DASH","DASH"),("USDT_LTC","Litecoin"),("USDT_NXT","Nxt")]
    for(i,j) in cryptos2:
        print("One {}= {} Dolar".format(j,json_verim[i]["last"]))



