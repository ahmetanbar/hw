from data import values_history,times_history,values_current,times_current
print(values_current("BTC","LTC")) #Şuanki Değeri Verir Ex: "BTC","LTC"
print(values_history("BTC","LTC")) # Geçmiş Değerleri Verir. Ex: "BTC","ETH"
print(times_history("BTC","LTC")) # Geçmiş Değerlerin Zamanlarını Verir. Ex: "ETH","BTC"
print(times_current("BTC","LTC")) # Şuanki Değerin Zamanını Verir. Ex: "LTC","BTC"