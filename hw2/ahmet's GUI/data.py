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
            if time[1]!=":":
                if int(time[0:2])>23:
                    time=str(int(time[0:2])-24) + time[2:]
            time1=[str(value["TimeStamp"].split("T")[0]),time]
            time1="T".join(time1)
            times.append(dateutil.parser.parse(str(time1)))
            # print(times)
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
