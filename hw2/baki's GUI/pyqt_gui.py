import sys
from graph import *
from data import *
from PyQt5.QtWidgets import QDialog, QApplication, QPushButton,QHBoxLayout,QListWidget,QMessageBox, QLineEdit
from matplotlib.backends.backend_qt5agg import FigureCanvasQTAgg as FigureCanvas
from PyQt5.QtGui import QPainter, QColor, QPen
from PyQt5.QtCore import Qt
############################################################################################################################################

class Window(QDialog):
    def __init__(self, parent=None):
        super(Window, self).__init__(parent)
        width = 950
        height = 500

        self.setMinimumWidth(width)
        self.setMinimumHeight(height)
        self.setMaximumWidth(width)
        self.setMaximumHeight(height)

        self.setAutoFillBackground(True)
        p = self.palette()
        p.setColor(self.backgroundRole(), Qt.darkBlue)
        self.setPalette(p)

        self.setWindowTitle('GUI 2018')
        self.listWidget = QListWidget(self)

        self.button = QPushButton('Search and Plot',self)
        self.button.clicked.connect(self.search)
        self.button2 = QPushButton('BTC',self)
        self.button2.clicked.connect(self.addlistbtc)
        self.button3 = QPushButton('ETH',self)
        self.button3.clicked.connect(self.addlisteth)
        self.button4 = QPushButton('USDT',self)
        self.button4.clicked.connect(self.addlistusdt)
        self.button.move(10,435)
        self.button.resize(150,20)
        self.button2.move(10,455)
        self.button2.resize(50,38)
        self.button3.move(60,455)
        self.button3.resize(50,38)
        self.button4.move(110,455)
        self.button4.resize(50,38)
        self.listWidget.move(10,10)
        self.listWidget.resize(150,390)
        self.listWidget.itemClicked.connect(self.Clicked)
        self.textbox = QLineEdit(self)
        self.textbox.move(10,405)
        self.textbox.resize(150,30)

        self.figure = plt.figure(figsize=(15, 10), dpi=50, num=20)
        self.canvas = FigureCanvas(self.figure)

        graphbox = QHBoxLayout()
        graphbox.addStretch()
        graphbox.addWidget(self.canvas)
        self.setLayout(graphbox)

    def keyPressEvent(self, e):
        if e.key() == Qt.Key_F4:
            self.close()
        elif e.key() == Qt.Key_F3:
            self.search()

    def search(self):
        global a
        global items
        global type1
        global select1
        a = str(self.textbox.text())
        print(a.upper())

        if a.upper() == "BTC-O":
            self.addlistbtc()
        elif a.upper() =="ETH-O":
            self.addlisteth()
        elif a.upper() == "USDT-O":
            self.addlisteth()

        items=[]
        s = 0
        for i in range(self.listWidget.count()):
            s+=1

        if s == 0:
            buttonReply = QMessageBox.question(self, 'Beklenen HATA !!!', "Bir dahaki sefere Listeyi doldurmadan basmayacağıma söz veriyorum.",
                                    QMessageBox.Yes | QMessageBox.No, QMessageBox.No)
            if buttonReply == QMessageBox.Yes:
                self.close()
            else:
                print(" Designed by bakialmaci ")



        for i in range(self.listWidget.count()):
            if a.upper() == self.listWidget.item(i).text() and type1 == "BTC":
                select1 = a.upper()
                self.graph_latest2()
            elif a.upper() == self.listWidget.item(i).text() and type1 == "ETH":
                select1 = a.upper()
                self.graph_latest2()
            elif a.upper() == self.listWidget.item(i).text() and type1 == "USDT":
                select1 = a.upper()
                self.graph_usd_x_alltime2()

            print(self.listWidget.item(i).text())



    def addlistbtc(self):
        global type1
        eth,btc,usdt= names_eth_btc_usdt()
        self.listWidget.clear()
        self.listWidget.addItems(btc)
        type1 = "BTC"
        print(type1)
        self.canvas.close_event()
        self.figure.clear()


    def addlisteth(self):
        global type1
        eth,btc,usdt= names_eth_btc_usdt()
        self.listWidget.clear()
        self.listWidget.addItems(eth)
        type1 = "ETH"
        print(type1)
        self.canvas.close_event()
        self.figure.clear()

    def addlistusdt(self):
        global type1
        eth,btc,usdt= names_eth_btc_usdt()
        self.listWidget.clear()
        self.listWidget.addItems(usdt)
        type1 = "USDT"
        print(type1)
        self.canvas.close_event()
        self.figure.clear()

    def Clicked(self, item):
        global type1
        if type1 == "BTC":
            # print(item.text())
            self.figure.clear()
            self.graph_latest()
        elif type1 == "ETH":
            # print(item.text())
            self.figure.clear()
            self.graph_latest()
        elif type1== "USDT":
            # print(item.text())
            self.figure.clear()
            self.graph_usd_x_alltime()


    def graph_latest(self):
        global select1
        select1=self.listWidget.currentItem().text()
        print(select1)

        style.use('ggplot')  # ggplot tasarımındaki tablomuzun stylenı belirledik.
        ax1 = self.figure.add_subplot(1, 1, 1)

        def animate(i):
            time, value = current(type1,select1)
            title = type1 + " - " + select1 + " Latest History Chart\nCurrent Price = " + str(value)
            ax1.set_title(title)
            plt.xticks(rotation=90,size=15)  # x eksenindeki gelen verileri daha rahat görünüp üst üste binmemesi için rotate ettik.
            plt.gcf().autofmt_xdate()
            myFmt = mdates.DateFormatter('%H:%M:%S')  # Datatime daki değerlerin hangi formatta yazdırılacağını seçtik.
            plt.gca().xaxis.set_major_formatter(myFmt)
            x, y = history(type1, select1)
            ax1.plot(x, y, color='blue')

        ani = animation.FuncAnimation(self.figure, animate, interval=1000)
        self.canvas.draw()


    def graph_latest2(self):
        global select1
        print(select1)

        style.use('ggplot')  # ggplot tasarımındaki tablomuzun stylenı belirledik.
        ax1 = self.figure.add_subplot(1, 1, 1)

        def animate(i):
            time, value = current(type1,select1)
            title = type1 + " - " + select1 + " Latest History Chart\nCurrent Price = " + str(value)
            ax1.set_title(title)
            plt.xticks(rotation=90,size=15)  # x eksenindeki gelen verileri daha rahat görünüp üst üste binmemesi için rotate ettik.
            plt.gcf().autofmt_xdate()
            myFmt = mdates.DateFormatter('%H:%M:%S')  # Datatime daki değerlerin hangi formatta yazdırılacağını seçtik.
            plt.gca().xaxis.set_major_formatter(myFmt)
            x, y = history(type1, select1)
            ax1.plot(x, y, color='blue')

        ani = animation.FuncAnimation(self.figure, animate, interval=1000)
        self.canvas.draw()

    def graph_usd_x_alltime2(self):

        global select1
        print(select1)
        style.use('ggplot')
        ax2 = self.figure.add_subplot(1, 1, 1)

        def animate(i):
            time, value = current("USDT", select1)
            title = "USD - " + select1 + " All Time History Chart\nCurrent Price = " + str(value)
            ax2.set_title(title)
            plt.xticks(rotation=90, size=15)
            plt.gcf().autofmt_xdate()
            myFmt = mdates.DateFormatter('%H:%M:%S')
            plt.gca().xaxis.set_major_formatter(myFmt)
            x, y = usd_x_alltime(select1)
            ax2.plot(x, y, color='green')

        ani = animation.FuncAnimation(self.figure, animate, interval=3000)
        self.canvas.draw()

    def graph_usd_x_alltime(self):

        global select1
        select1=self.listWidget.currentItem().text()
        print(select1)
        style.use('ggplot')
        ax2 = self.figure.add_subplot(1, 1, 1)

        def animate(i):
            time, value = current("USDT", select1)
            title = "USD - " + select1 + " All Time History Chart\nCurrent Price = " + str(value)
            ax2.set_title(title)
            plt.xticks(rotation=90, size=15)
            plt.gcf().autofmt_xdate()
            myFmt = mdates.DateFormatter('%H:%M:%S')
            plt.gca().xaxis.set_major_formatter(myFmt)
            x, y = usd_x_alltime(select1)
            ax2.plot(x, y, color='green')

        ani = animation.FuncAnimation(self.figure, animate, interval=3000)
        self.canvas.draw()

app = QApplication(sys.argv)
main = Window()
main.setGeometry(450,300,1000,800)
main.show()
sys.exit(app.exec_())