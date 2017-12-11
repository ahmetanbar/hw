import requests

summaryurl="https://bittrex.com/api/v1.1/public/getmarketsummaries"
summary = requests.get(summaryurl)
json_summary = summary.json()

i=0

for j in json_summary["result"]:
    print(i)
    print("1 {} : {:f} {}".format(json_summary["result"][i]["MarketName"][4:],json_summary["result"][i]["Last"],json_summary["result"][i]["MarketName"][:3]))
    i = i + 1




