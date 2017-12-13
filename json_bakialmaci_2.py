import requests

user_input = input("Enter Currency: ")
user_input = user_input.upper()

if (user_input=='BTC'):
    exit()

api="https://bittrex.com/api/v1.1/public/getmarkethistory?market=BTC-"+user_input
name = requests.get(api)
json = name.json()

def timeparse():
    for i in range(0,20):
        Time = json["result"][i]["TimeStamp"]
        a = 0
        print("||  ", end='')
        for i in Time:
            a+=1
            if (a>11 and a<20):
                print(i,end='')
        print("  ||  ",end='')
timeparse()
 
    #String verileri integere çevrilmesi yapılacak.

