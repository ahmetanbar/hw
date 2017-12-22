import sys
import requests
from PyQt5.QtWidgets import QDialog, QApplication, QPushButton, QVBoxLayout,QHBoxLayout, QListView, QListWidget, QLineEdit, QLabel,QMessageBox
from matplotlib.backends.backend_qt5agg import FigureCanvasQTAgg as FigureCanvas
from matplotlib.backends.backend_qt5agg import NavigationToolbar2QT as NavigationToolbar
import matplotlib.pyplot as plt
from PyQt5 import QtCore
from PyQt5.QtWidgets import QMainWindow, QWidget, QLabel, QLineEdit
from PyQt5.QtWidgets import QPushButton
from PyQt5.QtCore import QSize

global button_id

class Window(QDialog):
    def __init__(self, parent=None):
        super(Window, self).__init__(parent)
        self.setWindowTitle('Market Currency')
        self.listWidget = QListWidget()
        self.listWidget.itemClicked.connect(self.touchme)
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
        self.canvas.move(20, 20)
        self.canvas.resize(40, 40)

        self.textbox = QLineEdit()
        self.textbox.move(20, 20)
        self.textbox.resize(280, 40)
        self.aramam=QLabel()
        self.aramam.setText("""                               or Write here and Plot it""")

        h_box = QHBoxLayout()
        h_box.addWidget(self.button2)
        h_box.addWidget(self.button3)
        h_box.addWidget(self.button4)

        yazih_box=QHBoxLayout()
        yazih_box.addStretch()
        yazih_box.addWidget(self.aramam)
        yazih_box.addStretch()

        aramah_box=QHBoxLayout()
        aramah_box.addStretch()
        aramah_box.addWidget(self.textbox)
        aramah_box.addStretch()

        objects = QVBoxLayout()
        objects.addWidget(self.aramam)
        objects.addWidget(self.textbox)
        objects.addWidget(self.toolbar)

        myobject = QHBoxLayout()
        myobject.addStretch()
        myobject.addLayout(objects)
        myobject.addStretch()

        layout = QVBoxLayout()
        layout.addLayout(h_box)
        layout.addWidget(self.listWidget)
        layout.addWidget(self.button)
        layout.addLayout(myobject)
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
        global ss
        xList= []
        yList= []

        summaryurl = "https://bittrex.com/api/v1.1/public/getmarkethistory?market="
        # if not :
        #     print("ss girilmedi")
        print("xx")
        if ("BTC"==choose):
            if (self.textbox.text() in btcList):
                ss=self.textbox.text()
                self.textbox.clear()
                print("icerdeyim")
            elif (self.textbox.text()!="") :
                textboxValue = self.textbox.text()
                self.textbox.clear()
                QMessageBox.question(self, 'what the!!!', "Onca seçenek varken neden \" " + textboxValue + "\" anlatir misin? \n      Belki ETH'ye bakmak istersin.", QMessageBox.Ok,
                                     QMessageBox.Ok)

                ss = "ETH"
            summaryurl=summaryurl+"BTC-"+ ss
        elif ("ETH"==choose):
            if (self.textbox.text() in ethList):
                ss=self.textbox.text()
                self.textbox.clear()
                print("icerdeyim")
            elif (self.textbox.text()!="") :
                textboxValue = self.textbox.text()
                self.textbox.clear()
                QMessageBox.question(self, 'what the!!!', "Onca seçenek varken neden \" " + textboxValue + "\" anlatir misin? \n      Belki ETC'ye bakmak istersin.", QMessageBox.Ok,
                                     QMessageBox.Ok)

                ss = "ETC"
            summaryurl=summaryurl+"ETH-"+ ss
        elif ("USDT"==choose):
            if (self.textbox.text() in usdList):
                ss=self.textbox.text()
                self.textbox.clear()
                print("icerdeyim")
            elif (self.textbox.text()!="") :
                textboxValue = self.textbox.text()
                self.textbox.clear()
                QMessageBox.question(self, 'what the!!!', "Onca seçenek varken neden \" " + textboxValue + "\" anlatir misin? \n      Belki BTC'ye bakmak istersin.", QMessageBox.Ok,
                                     QMessageBox.Ok)
                ss = "BTC"
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
                xList.append(str(m))
                yList.append(str(n))
        self.figure.clear()
        ax = self.figure.add_subplot(111)
        ax.plot(yList,xList, 'o-')
        ax.set_title("{} Last Price= {:f}".format(ss,json_summary["result"][0]["Price"]))
        ss = ""
        self.canvas.draw()

    def nameBTC(self):
        self.listWidget.clear()
        global btcList
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
        global ethList
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
        global usdList
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

#Zoom ile gezinme eklenecek