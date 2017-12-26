#!/usr/bin/python
#--coding:cp1254
from data import *
import sys
from PyQt5.QtWidgets import QDialog, QApplication, QPushButton, QVBoxLayout,QHBoxLayout,QListWidget, QLineEdit, QMessageBox
from matplotlib.backends.backend_qt5agg import FigureCanvasQTAgg as FigureCanvas
from matplotlib.backends.backend_qt5agg import NavigationToolbar2QT as NavigationToolbar
import matplotlib.pyplot as plt
import matplotlib.animation as animation
from PyQt5.QtGui import QIcon,QPixmap
from PyQt5.QtCore import QEvent,Qt
import matplotlib.dates as mdates
from matplotlib import style
import requests
import dateutil.parser
global button_id
global choose
global ss
ss=""
choose=""
global err
err=0
editmessage="Write any from above and Enter"
import urllib.request
urllib.request.urlretrieve("https://asilentspectatorblog.files.wordpress.com/2017/05/wp-1495363795875.png?w=660","bitcoin.png")

class Window(QDialog):
    def __init__(self, parent=None):
        super(Window, self).__init__(parent)
        self.press = None
        self.cur_xlim = None
        self.cur_ylim = None
        self.x0 = None
        self.y0 = None
        self.x1 = None
        self.y1 = None
        self.xpress = None
        self.ypress = None
        self.setWindowTitle('Market Currency')
        self.listWidget = QListWidget()
        self.listWidget.itemClicked.connect(self.touchme)
        self.button = QPushButton('Plot')
        self.button.clicked.connect(self.plot)
        self.button2 = QPushButton('BTC', self)
        self.button2.setFocusPolicy(False)
        self.button2.clicked.connect(lambda: self.buttonsee(1))
        self.button3 = QPushButton('ETH', self)
        self.button3.setFocusPolicy(False)
        self.button3.clicked.connect(lambda: self.buttonsee(2))
        self.button4 = QPushButton('USD', self)
        self.button4.setFocusPolicy(False)
        self.button4.clicked.connect(lambda: self.buttonsee(3))
        self.setWindowIcon(QIcon('bitcoin.png'))

        self.fig = plt.figure(figsize=(15,10),dpi=50, num=30)
        self.canvas = FigureCanvas(self.fig)
        self.canvas.move(20, 20)
        self.canvas.resize(40, 40)
        style.use('ggplot')

        self.textbox = QLineEdit()
        self.textbox.setText(editmessage)
        self.textbox.cursorPositionChanged.connect(self.editted)
        self.textbox.returnPressed.connect(self.plot)
        self.textbox.move(20, 20)
        self.textbox.resize(280, 40)

        h_box = QHBoxLayout()
        h_box.addWidget(self.button2)
        h_box.addWidget(self.button3)
        h_box.addWidget(self.button4)


        aramah_box=QHBoxLayout()
        aramah_box.addStretch()
        aramah_box.addWidget(self.textbox)
        aramah_box.addStretch()

        objects = QVBoxLayout()
        objects.addWidget(self.textbox)

        myobject = QHBoxLayout()
        myobject.addStretch()
        myobject.addLayout(objects)
        myobject.addStretch()

        layout = QVBoxLayout()
        layout.addLayout(h_box)
        layout.addWidget(self.listWidget)
        layout.addLayout(myobject)
        layout.addWidget(self.canvas)
        self.setLayout(layout)


    def printted(self):
        print("girdim")

    def editted(self):
        if self.textbox.text()==editmessage:
            self.textbox.clear()

    def zoom_factory(self, ax, base_scale=2.):
        def zoom(event):
            cur_xlim = ax.get_xlim()
            # cur_ylim = ax.get_ylim()

            xdata = event.xdata  # get event x location
            # ydata = event.ydata  # get event y location
            if xdata==None:
                return None

            if event.button == 'down':
                scale_factor = base_scale
            elif event.button == 'up':
                scale_factor = 1/base_scale
            else:
                scale_factor = 1
                print(event.button)

            new_width = (cur_xlim[1] - cur_xlim[0]) * scale_factor
            # new_height = (cur_ylim[1] - cur_ylim[0]) * scale_factor

            relx = (cur_xlim[1] - xdata) / (cur_xlim[1] - cur_xlim[0])
            # rely = (cur_ylim[1] - ydata) / (cur_ylim[1] - cur_ylim[0])
            ax.set_xlim([xdata - new_width * (1 - relx), xdata + new_width * (relx)])
            # ax.set_ylim([ydata - new_height * (1 - rely), ydata + new_height * (rely)])
            ax.figure.canvas.draw()

        fig = ax.get_figure()  # get the figure of interest
        fig.canvas.mpl_connect('scroll_event', zoom)
        return zoom

    def pan_factory(self, ax):
        def onPress(event):
            if event.inaxes != ax: return
            self.cur_xlim = ax.get_xlim()
            self.cur_ylim = ax.get_ylim()
            self.press = self.x0, self.y0, event.xdata, event.ydata
            self.x0, self.y0, self.xpress, self.ypress = self.press

        def onRelease(event):
            self.press = None
            ax.figure.canvas.draw()

        def onMotion(event):
            if self.press is None: return
            if event.inaxes != ax: return
            dx = event.xdata - self.xpress
            dy = event.ydata - self.ypress
            self.cur_xlim -= dx
            self.cur_ylim -= dy
            ax.set_xlim(self.cur_xlim)
            ax.set_ylim(self.cur_ylim)

            ax.figure.canvas.draw()

        def enter_figure(event):
            print('enter_figure')
            event.canvas.figure.patch.set_facecolor('red')
            event.canvas.draw()

        fig = ax.get_figure()  # get the figure of interest
        fig.canvas.mpl_connect('button_press_event', onPress)
        fig.canvas.mpl_connect('button_release_event', onRelease)
        fig.canvas.mpl_connect('motion_notify_event', onMotion)
        fig.canvas.mpl_connect('figure_enter_eventasdfasdf', enter_figure)
        return onMotion

    def touchme(self):
        global ss
        ss= self.listWidget.currentItem().text()
        self.textbox.clear()
        self.fig.clear()
        self.plot()

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

    def firsterror(self):
        global err
        messages=""
        if 0==err:
            err=err+1
            messages="\n\nAs you know, this is your first error. \nSo we want to remember that you can read info about application by making click question mark which is upper right corner."
        return messages


    def info(self):
        QMessageBox.about(self, "How do it work?",
                          "Hello User\n\nWelcome to Application\nThe application shows currency prices.\n\nAs you see, there are"
                          " three button based on \"BTC-ETH-USDT\"\n\nFirstly,you select based on.\n\nAfter that:You click currency in the list\n\n"
                          "or \n\nYou write in the box what you want to see currency and enter it.\n\nWhen graphic is opened,you will see based"
                          " on and currency graph.\n\nYou zoom the graph and slide it how you want.\n\nAlso if you need help,you can e-mail to ahmetanbar@icloud.com"
                          "\n\nThanks for choosing us.")

    def plot(self):

        global ss
        global choose
        global summaryurl

        if (not choose):
            QMessageBox.question(self, 'what the!!!',
                                 "You haven't choose any markets.What are you doing?",
                                 QMessageBox.Ok, QMessageBox.Ok)
            self.textbox.clear()
            return None
        if ("BTC"==choose):
            if (self.textbox.text() in btcList):
                ss=self.textbox.text()
                self.textbox.clear()
            elif (self.textbox.text().upper() in btcList):
                ss = self.textbox.text().upper()
                self.textbox.clear()
            elif (self.textbox.text()!=editmessage and self.textbox.text()!=""):
                textboxValue = self.textbox.text() + self.firsterror()
                self.textbox.clear()
                QMessageBox.question(self, 'what the!!!', "Why " + textboxValue + "\" \n", QMessageBox.Ok,QMessageBox.Ok)
                return None
            elif not ss:
                QMessageBox.question(self, 'what the!!!',"Haven't selected item in the list or wrote any item", QMessageBox.Ok, QMessageBox.Ok)
                return None

        elif ("ETH"==choose):
            if (self.textbox.text() in ethList):
                ss=self.textbox.text()
                self.textbox.clear()
            elif (self.textbox.text().upper() in ethList):
                ss = self.textbox.text().upper()
                self.textbox.clear()
            elif (self.textbox.text()!=editmessage and self.textbox.text()!=""):
                textboxValue = self.textbox.text()  + self.firsterror()
                self.textbox.clear()
                QMessageBox.question(self, 'what the!!!', "Why\" " + textboxValue + "\" ?\n", QMessageBox.Ok,QMessageBox.Ok)
                return None
            elif not ss:
                QMessageBox.question(self, 'what the!!!',"Haven't selected item in the list and wrote any item", QMessageBox.Ok, QMessageBox.Ok)
                return None

        elif ("USDT"==choose):
            if (self.textbox.text() in usdList):
                ss=self.textbox.text()
                self.textbox.clear()
                print("icerdeyim")
            elif (self.textbox.text().upper() in usdList):
                ss = self.textbox.text().upper()
                self.textbox.clear()
            elif (self.textbox.text()!=editmessage and self.textbox.text()!=""):
                textboxValue = self.textbox.text()  + self.firsterror()
                self.textbox.clear()
                QMessageBox.question(self, 'what the!!!', "Why\" " + textboxValue + "\" ?\n", QMessageBox.Ok,QMessageBox.Ok)
                return None
            elif not ss:
                QMessageBox.question(self, 'what the!!!',"Haven't selected item in the list and wrote any item", QMessageBox.Ok, QMessageBox.Ok)
                return None



        style.use('ggplot')

        # fig = plt.figure(figsize=(15, 10), dpi=50, num=20)
        ax = self.fig.add_subplot(1, 1, 1)
        time, value = current(choose, ss)
        plt.xticks(rotation=45, size=15)
        plt.yticks(size=15)
        plt.gcf().autofmt_xdate()
        myFmt = mdates.DateFormatter('%H:%M:%S')
        plt.gca().xaxis.set_major_formatter(myFmt)
        ax.set_title(choose + " - " + ss + " Latest History Chart\nCurrent Price = " + str(value), color="darkBlue")
        x, y = history(choose, ss)
        ax.plot(x, y, color='red')
        scale = 1.1
        plt.xlabel("TIME", size=25, color="darkBlue")
        plt.ylabel(ss + "/" + choose, size=25, color="darkBlue")
        plt.text(value, 0, r'$\cos(2 \pi t) \exp(-t)$', size=50)
        self.zoom_factory(ax, base_scale=scale)
        self.pan_factory(ax)

        def animate(i):
            time, value = current(choose, ss)
            plt.xticks(rotation=45, size=15)
            plt.gcf().autofmt_xdate()
            myFmt = mdates.DateFormatter('%H:%M:%S')
            plt.gca().xaxis.set_major_formatter(myFmt)
            ax.set_title(choose + " - " + ss + " Latest History Chart\nCurrent Price = " + str(value))
            x, y = history(choose, ss)
            ax.plot(x, y, color='red')
            scale = 1.1
            self.zoom_factory(ax, base_scale=scale)

        ani = animation.FuncAnimation(self.fig, animate, interval=10000)
        self.canvas.draw()

    def event(self, event):
        if event.type() == QEvent.EnterWhatsThisMode:
            self.info()

            return True
        return QDialog.event(self, event)

    def nameBTC(self):
        self.listWidget.clear()
        global btcList, ss
        btcList=[]
        ss=""
        marketurl="https://bittrex.com/api/v1.1/public/getmarkets"
        market = requests.get(marketurl)
        json_market = market.json()
        for j in json_market["result"]:
            if j["BaseCurrency"]=="BTC":
                v=j["MarketCurrency"]
                btcList.append(str(v))
        self.listWidget.addItems(btcList)

    def nameETH(self):
        global ethList,ss
        ss=""
        ethList=[]
        marketurl="https://bittrex.com/api/v1.1/public/getmarkets"
        market = requests.get(marketurl)
        json_market = market.json()
        for j in json_market["result"]:
            if j["BaseCurrency"]=="ETH":
                v=j["MarketCurrency"]
                ethList.append(str(v))
        self.listWidget.clear()
        self.listWidget.addItems(ethList)

    def nameUSD(self):
        global usdList,ss
        ss=""
        usdList=[]
        marketurl="https://bittrex.com/api/v1.1/public/getmarkets"
        market = requests.get(marketurl)
        json_market = market.json()
        for j in json_market["result"]:
            if j["BaseCurrency"]=="USDT":
                v=j["MarketCurrency"]
                usdList.append(str(v))
        self.listWidget.clear()
        self.listWidget.addItems(usdList)




app = QApplication(sys.argv)
scale=1.1
main = Window()
main.setGeometry(450,38,600,800)
main.show()
sys.exit(app.exec_())