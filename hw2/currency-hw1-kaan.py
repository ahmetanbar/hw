import requests
api1="https://bittrex.com/api/v1.1/public/getmarketsummaries"
type_coin=input("Oranlarını Görmek İstediğiniz Coin Türünü Giriniz:")
response=requests.get(api1)
json_verisi=response.json()
for i in range(0,250):
    if type_coin==json_verisi["result"][i]["MarketName"][:3]:
            print("1",json_verisi["result"][i]["MarketName"][4:]," == ",format(json_verisi["result"][i]["Last"], '.8f'),type_coin)