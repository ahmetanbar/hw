import sys
import requests
from PyQt5.QtWidgets import QDialog, QApplication, QPushButton, QVBoxLayout,QHBoxLayout, QListView, QListWidget, QLineEdit, QLabel
from matplotlib.backends.backend_qt5agg import FigureCanvasQTAgg as FigureCanvas
from matplotlib.backends.backend_qt5agg import NavigationToolbar2QT as NavigationToolbar
import matplotlib.pyplot as plt

global button_id

class Window(QDialog):
    def __init__(self, parent=None):
        super(Window, self).__init__(parent)
        self.setWindowTitle('Market Currency')
        self.listWidget = QListWidget()
        self.listWidget.currentItemChanged.connect(self.touchme)
        self.button = QPushButton('Plot')
        self.button.clicked.connect(self.plot)
        self.button2 = QPushButton('BTC')
        self.button2.clicked.connect(lambda: self.buttonsee(1))
        self.button3 = QPushButton('ETH')
        self.button3.clicked.connect(lambda: self.buttonsee(2))
        self.button4 = QPushButton('USD')
        self.button4.clicked.connect(lambda: self.buttonsee(3))


        self.figure = plt.figure()
        self.canvas = FigureCanvas(self.figure)
        self.toolbar = NavigationToolbar(self.canvas, self)

        self.textbox = QLineEdit('Ara beni')
        self.textbox.move(20, 20)
        self.textbox.resize(280, 40)
        self.x=self.textbox.text()
        print(self.x)
        self.aramam=QLabel()
        self.aramam.setText("""or Write here""")

        h_box = QHBoxLayout()
        h_box.addWidget(self.button2)
        h_box.addWidget(self.button3)
        h_box.addWidget(self.button4)

        yazih_box=QHBoxLayout()
        yazih_box.addStretch()
        yazih_box.addWidget(self.aramam)
        yazih_box.addStretch()

        layout = QVBoxLayout()
        layout.addLayout(h_box)
        layout.addWidget(self.listWidget)
        layout.addWidget(self.button)
        layout.addLayout(yazih_box)
        layout.addWidget(self.textbox)
        layout.addWidget(self.toolbar)
        layout.addWidget(self.canvas)
        self.setLayout(layout)

    def touchme(self):
        global ss
        ss= self.listWidget.currentItem().text()
        print(ss)

    def buttonsee(self,button_id):
        global choose
        if button_id==1:
            choose="BTC"
            self.nameBTC()
        elif button_id==2:
            choose="ETH"
            self.nameETH()
        elif button_id==3:
            choose="USDT"
            self.nameUSD()


    def plot(self):
        xList= []
        yList= []
        summaryurl = "https://bittrex.com/api/v1.1/public/getmarkethistory?market="

        if ("BTC"==choose):
            summaryurl=summaryurl+"BTC-"+ ss
        elif ("ETH"==choose):
            summaryurl=summaryurl+"ETH-"+ ss
        elif ("USDT"==choose):
            summaryurl=summaryurl+"USDT-"+ ss
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
        print("girdim")
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
        self.listWidget.clear()
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
        self.listWidget.clear()
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
        self.listWidget.clear()
        self.listWidget.addItems(usdList)



if __name__ == '__main__':
    app = QApplication(sys.argv)
    main = Window()
    main.setGeometry(450,38,1000,800)
    main.show()
    sys.exit(app.exec_())


#Arama textEditi eklenecek
#Zoom ile gezinme eklenecek
#Bug var temizlenecek