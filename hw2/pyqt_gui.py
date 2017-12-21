import sys
from graph import *
from data import *
from PyQt5.QtWidgets import QDialog, QApplication,QMessageBox, QPushButton,QHBoxLayout, QListWidget, QLineEdit,QProgressBar
from PyQt5.QtCore import QBasicTimer
from matplotlib.backends.backend_qt5agg import FigureCanvasQTAgg as FigureCanvas
#############################################################################################################################################

class Window(QDialog):
    def __init__(self, parent=None):
        super(Window, self).__init__(parent)
        width = 950
        height = 500

        self.setMinimumWidth(width)
        self.setMinimumHeight(height)
        self.setMaximumWidth(width)
        self.setMaximumHeight(height)

        self.setWindowTitle('GUI 2018')
        self.listWidget = QListWidget(self)

        self.pbar = QProgressBar(self)
        self.pbar.setGeometry(4,10,185,25)
        self.timer = QBasicTimer()

        self.button = QPushButton('Search and Plot',self)
        self.button.clicked.connect(self.graph_latest)
        self.button2 = QPushButton('BTC',self)
        self.button2.clicked.connect(self.addlistbtc)
        self.button3 = QPushButton('ETH',self)
        self.button3.clicked.connect(self.addlisteth)
        self.button4 = QPushButton('USD',self)
        self.button4.clicked.connect(self.addlistusdt)
        self.textbox = QLineEdit(self)
        self.textbox.move(4,405)
        self.textbox.resize(150,30)
        self.button.move(4,435)
        self.button.resize(150,20)
        self.button2.move(4,455)
        self.button2.resize(50,38)
        self.button3.move(54,455)
        self.button3.resize(50,38)
        self.button4.move(104,455)
        self.button4.resize(50,38)
        self.listWidget.move(4,50)
        self.listWidget.resize(150,350)
        self.listWidget.itemClicked.connect(self.Clicked)
        self.step = 0

        self.figure = plt.figure(figsize=(15, 10), dpi=50, num=20)
        self.canvas = FigureCanvas(self.figure)

        graphbox = QHBoxLayout()
        graphbox.addStretch()
        graphbox.addWidget(self.canvas)
        self.setLayout(graphbox)

    def addlistbtc(self):
        global type1
        eth,btc,usdt= names_eth_btc_usdt()
        self.listWidget.clear()
        self.listWidget.addItems(btc)
        type1 = "BTC"
        print(type1)
        self.canvas.close_event()
        self.pbar.setValue(0)
        for i in range(100):
            self.pbar.setValue(self.step)
            self.step= i+2


    def addlisteth(self):
        global type1
        eth,btc,usdt= names_eth_btc_usdt()
        self.listWidget.clear()
        self.listWidget.addItems(eth)
        type1 = "ETH"
        print(type1)
        self.canvas.close_event()
        self.pbar.setValue(0)
        for i in range(100):
            self.pbar.setValue(self.step)
            self.step= i+2

    def addlistusdt(self):

        global type1
        eth,btc,usdt= names_eth_btc_usdt()
        self.listWidget.clear()
        self.listWidget.addItems(usdt)
        type1 = "USDT"
        self.canvas.close_event()
        print(type1)
        self.pbar.setValue(0)
        for i in range(100):
            self.pbar.setValue(self.step)
            self.step= i+2


    def Clicked(self, item):
        # QMessageBox.information(self, "ListWidget", "You clicked: " + item.text())
        print(item.text())



    def graph_latest(self):
        self.canvas.close_event()
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

        ani = animation.FuncAnimation(self.figure, animate, interval=3000)
        self.pbar.setValue(0)
        for i in range(100):
            self.pbar.setValue(self.step)
            self.step= i+2

        self.canvas.draw()

    def graph_usd_x_alltime(self):

        global select1
        select1=self.listWidget.currentItem().text()
        print(select1)

        style.use('ggplot')
        ax1 = self.figure.add_subplot(1, 1, 1)

        def animate():
            time, value = current("USDT", "ETH")
            title = "USD - " + "ETH" + " All Time History Chart\nCurrent Price = " + str(value)
            ax1.set_title(title)
            plt.xticks(rotation=90, size=15)
            plt.gcf().autofmt_xdate()
            myFmt = mdates.DateFormatter('%H:%M:%S')
            plt.gca().xaxis.set_major_formatter(myFmt)
            x, y = usd_x_alltime("ETH")
            ax1.plot(x, y, color='blue')

        ani = animation.FuncAnimation(self.figure, animate, interval=3000)
        self.canvas.draw()

app = QApplication(sys.argv)
main = Window()
main.setGeometry(450,300,1000,800)
main.show()
sys.exit(app.exec_())
