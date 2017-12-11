import requests

user = input("Oranlanacak Parayı Giriniz(EX: BTC) : ")

currency_name = "https://bittrex.com/api/v1.1/public/getcurrencies" # buradan isimleri çektim
response = requests.get(currency_name)
currency_json_verisi = response.json()

get_market = "https://bittrex.com/api/v1.1/public/getmarketsummaries" #burada paraların son durumları yer alıyor
response_market = requests.get(get_market)
get_market_json = response_market.json()

oranlar = "https://bittrex.com/api/v1.1/public/getmarketsummary?market="+user+"-" # dıger birimlerin btc ye oranlarını aldık
print(oranlar)
#oranlar_market = requests.get(oranlar)
#oranlar_market_json = oranlar_market.json()

#print(json_verisi) 288

while(1):
    for i in range(1,14):
        coins = currency_json_verisi["result"][i]["Currency"] #dövizin ismini çektim
        oranlar = oranlar+coins #url adresinin sonuna ekledim.
        print(i,user+"-"+coins," ---> ",end='')
        oranlar_market = requests.get(oranlar)
        oranlar_market_json = oranlar_market.json()
        oran = oranlar_market_json["result"][0]["Last"]
        print(oran)
        oranlar="https://bittrex.com/api/v1.1/public/getmarketsummary?market=BTC-"
        if(i == 13):
            print("--------------------------------GÜNCELLENİYOR-------------------------------------------")


#i = 15 ten sonra hata alıyorum. büyük ihtimalle markette oranı bulamıyor.
# yazdırılan oranların bazıları ondalıklı olmuyor.
