import requests
api = "https://bittrex.com/api/v1.1/public/getmarkets"
response = requests.get(api)
json = response.json()
a=0
for i in range(0,270):
    if "ETH" == json["result"][i]["BaseCurrency"]:
        a=a+1
print(a)