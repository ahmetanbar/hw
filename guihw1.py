import sys
import requests
from PyQt5.QtWidgets import QDialog, QApplication, QPushButton, QVBoxLayout,QHBoxLayout, QListView, QListWidget
from matplotlib.backends.backend_qt5agg import FigureCanvasQTAgg as FigureCanvas
from matplotlib.backends.backend_qt5agg import NavigationToolbar2QT as NavigationToolbar
import matplotlib.pyplot as plt

global ss
global choose
global button_id
global o

class Window(QDialog):
    def __init__(self, parent=None):
        super(Window, self).__init__(parent)
        self.button = QPushButton('Plot')
        self.button.clicked.connect(self.plot)
        self.button2 = QPushButton('BTC')
        self.button2.clicked.connect(lambda: self.buttonsee(1))
        self.button3 = QPushButton('ETH')
        self.button3.clicked.connect(lambda: self.buttonsee(2))
        self.button4 = QPushButton('USD')
        self.button4.clicked.connect(lambda: self.buttonsee(3))
        self.listWidget = QListWidget()
        self.listWidget.currentItemChanged.connect(lambda : self.PrintClick())
        self.figure = plt.figure()
        self.canvas = FigureCanvas(self.figure)
        self.toolbar = NavigationToolbar(self.canvas, self)

        h_box = QHBoxLayout()
        h_box.addWidget(self.button2)
        h_box.addWidget(self.button3)
        h_box.addWidget(self.button4)
        layout = QVBoxLayout()
        layout.addLayout(h_box)
        layout.addWidget(self.listWidget)
        layout.addWidget(self.button)
        layout.addWidget(self.toolbar)
        layout.addWidget(self.canvas)
        self.setLayout(layout)

    def PrintClick(self):
        ss= self.listWidget.currentItem().text()
        return ss
    def buttonsee(self,button_id): #arizali var - choose u alip plot fonksiyonunda if kontrollerinde kullanmaya çalýþmak için yazdým. ama edemedim.
        if button_id==1:
            choose="BTC"
            self.nameBTC()
            print(choose)

        elif button_id==2:
            choose="ETH"
            self.nameETH()
            print(choose)
        elif button_id==3:
            choose="USDT"
            self.nameUSD()
            print(choose)
        return choose


    def plot(self):
        xList= []
        yList= []
        summaryurl = "https://bittrex.com/api/v1.1/public/getmarkethistory?market="
        if ("BTC"=="BTC"):   # choose buralara yerleþtirilecek.yerleþtiremedim. o yüzden böyle þaçma bir eþitlik yazdým.
            summaryurl=summaryurl+"BTC-"+ self.PrintClick()
        elif ("ETH"==self.buttonsee()):
            summaryurl=summaryurl+"ETH-"+ self.PrintClick()
        elif ("USDT"==self.buttonsee()):
            summaryurl=summaryurl+"USDT-"+ self.PrintClick()
        summary = requests.get(summaryurl)
        json_summary = summary.json()
        #buradan aþaðýda veriyi iþleyip xList yList i oluþturuyorum. ama bazý ayarlamalar gerek.
        k=-1
        for j in json_summary["result"]:
            k=k+1
            if k<20:
                m = json_summary["result"][k]["Price"]
                n = json_summary["result"][k]["TimeStamp"][14:19]
                xList.append(float(m))
                yList.append(str(n))


        self.figure.clear()
        ax = self.figure.add_subplot(111)
        ax.plot(yList,xList, '-')
        ax.set_title("Last Price= {:f}".format(json_summary["result"][0]["Price"]))
        self.canvas.draw()

    def nameBTC(self):
        btcList=[]
        marketurl="https://bittrex.com/api/v1.1/public/getmarkets"
        market = requests.get(marketurl)
        json_market = market.json()
        i=0
        for j in json_market["result"]:
            if json_market["result"][i]["BaseCurrency"]=="BTC":
                v=json_market["result"][i]["MarketCurrency"]
                btcList.append(str(v))
            i=i+1
        self.listWidget.addItems(btcList)

    def nameETH(self):
        ethList=[]
        marketurl="https://bittrex.com/api/v1.1/public/getmarkets"
        market = requests.get(marketurl)
        json_market = market.json()
        i=0
        for j in json_market["result"]:
            if json_market["result"][i]["BaseCurrency"]=="ETH":
                v=json_market["result"][i]["MarketCurrency"]
                ethList.append(str(v))
            i=i+1
        self.listWidget.addItems(ethList)

    def nameUSD(self):
        usdList=[]
        marketurl="https://bittrex.com/api/v1.1/public/getmarkets"
        market = requests.get(marketurl)
        json_market = market.json()
        i=0
        for j in json_market["result"]:
            if json_market["result"][i]["BaseCurrency"]=="USDT":
                v=json_market["result"][i]["MarketCurrency"]
                usdList.append(str(v))
            i=i+1
        self.listWidget.addItems(usdList)



if __name__ == '__main__':
    app = QApplication(sys.argv)
    main = Window()
    main.setGeometry(450,38,1000,800)
    main.show()
    sys.exit(app.exec_())



#Arama textEditi eklenecek
#Zoom ile gezinme eklenecek
#listWidget butonlar arasýnda geçince temizlenmiyor. kodunu yazýnca bug oluþuyor.
#buttonsee fonksiyonun döner deðeri kullanilacak