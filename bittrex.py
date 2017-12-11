import requests

nameurl="https://bittrex.com/api/v1.1/public/getmarkets"
name = requests.get(nameurl)
json_name = name.json()

i=0

for j in json_name["result"]:
    currencyurl="https://bittrex.com/api/v1.1/public/getticker?market={}".format(json_name["result"][i]["MarketName"])
    currency = requests.get(currencyurl)
    json_currency = currency.json()
    if(json_name["result"][i]["IsActive"]):
        print(i)
        print("{} {} = 1 {} ".format(float(json_currency["result"]["Last"]),json_name["result"][i]["BaseCurrencyLong"],json_name["result"][i]["MarketCurrencyLong"]))
    i = i + 1




