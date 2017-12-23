import sys
from PyQt5.QtWidgets import *
from PyQt5.QtGui import QIcon
from PyQt5.QtCore import pyqtSlot, QBasicTimer
from matplotlib.backends.backend_qt5agg import FigureCanvasQTAgg as FigureCanvas
from matplotlib.backends.backend_qt5agg import NavigationToolbar2QT as NavigationToolbar
from matplotlib.figure import Figure
import matplotlib.pyplot as plt
from data import *
import matplotlib.animation as animation
import matplotlib.dates as mdates
from matplotlib import style
eth, btc, usdt = names_eth_btc_usdt()
choose=0
choose1=0
ss2="ETC"
ss="LTC"
class App(QMainWindow):
    def __init__(self):
        super().__init__()
        self.height = 200
        self.width=470
        self.setGeometry(500,250,self.width,self.height)
        self.setWindowTitle('Crypto Coin Currency Program - Bee Software Industries')
        self.setMinimumHeight(200)
        self.setMinimumWidth(470)
        self.setMaximumHeight(200)
        self.setMaximumWidth(470)
        self.table_widget = MyTableWidget(self)
        self.setCentralWidget(self.table_widget)
        self.show()
class MyTableWidget(QWidget):
    def __init__(self, parent):
        super(QWidget, self).__init__(parent)
        self.layout = QVBoxLayout(self)
        # Initialize tab screen
        self.tabs = QTabWidget()
        self.tab1 = QWidget()
        self.tab2 = QWidget()
        self.tab3 = QWidget()
        self.tab4 = QWidget()
        self.tab5 = QWidget()
        self.tabs.resize(300, 300)
        self.press = None
        self.cur_xlim = None
        self.cur_ylim = None
        self.x0 = None
        self.y0 = None
        self.x1 = None
        self.y1 = None
        self.xpress = None
        self.ypress = None
        # Add tabs
        self.tabs.addTab(self.tab1, "Main Page")
        
        ############# FIRST TAB #############
        
        self.tab1.layout = QGridLayout(self)
        self.step=0
        self.message = QLabel('This software was made by Kaan Bee Software')
        self.message.setGeometry(0, 0, 270, 25)
        self.pbar = QProgressBar(self)
        self.pbar.setGeometry(30, 40, 200, 25)
        self.timer = QBasicTimer()
        self.button1 = QPushButton('Load App', self)
        self.button1.clicked.connect(self.doAction)
        self.tab1.layout.addWidget(self.message,1,2)
        self.tab1.layout.addWidget(self.pbar,2,1,1,2)
        self.tab1.layout.addWidget(self.button1,2,3)
        self.tab1.setLayout(self.tab1.layout)

        ############# SECOND TAB-BTC TAB ############# FINISHED

        self.tab2.layout = QHBoxLayout(self)
        self.layout1 = QHBoxLayout(self)
        self.layout2 = QVBoxLayout(self)
        self.figure1 = Figure(figsize=(15, 10), dpi=50)
        self.canvas1 = FigureCanvas(self.figure1)
        self.toolbar1 = NavigationToolbar(self.canvas1, self)
        self.search1 = QLineEdit(self)
        self.search1.setPlaceholderText("Also you can write here")
        self.box1 = QComboBox(self)
        self.box1.addItem("According to BTC")
        self.box1.addItem("According to USD")
        self.button2 = QPushButton("Search")
        self.button2.clicked.connect(self.searchitem)
        self.box1.activated[int].connect(self.onActivated)
        self.layout1.addWidget(self.search1)
        self.layout1.addWidget(self.box1)
        self.layout1.addWidget(self.button2)
        self.list1 = QListWidget(self)
        self.list1.itemClicked.connect(self.touchme)
        self.layout2.addLayout(self.layout1)
        self.layout2.addWidget(self.canvas1)
        self.layout2.addWidget(self.toolbar1)
        self.tab2.layout.addLayout(self.layout2)
        self.tab2.layout.addWidget(self.list1)
        self.tab2.setLayout(self.tab2.layout)

        ################THIRD TAB-ETH TAB################ FINISHED
        
        self.tab3.layout = QHBoxLayout(self)
        self.layout3 = QHBoxLayout(self)
        self.layout4 = QVBoxLayout(self)
        self.figure2 = Figure(figsize=(15, 10), dpi=50)
        self.canvas2 = FigureCanvas(self.figure2)
        self.toolbar2 = NavigationToolbar(self.canvas2, self)
        self.search2 = QLineEdit(self)
        self.search2.setPlaceholderText("Also you can write here")
        self.box2 = QComboBox(self)
        self.box2.addItem("According to ETH")
        self.box2.addItem("According to USD")
        self.button3 = QPushButton("Search")
        self.button3.clicked.connect(self.searchitem2)
        self.box2.activated[int].connect(self.onActivated2)
        self.layout3.addWidget(self.search2)
        self.layout3.addWidget(self.box2)
        self.layout3.addWidget(self.button3)
        self.list2 = QListWidget(self)
        self.list2.itemClicked.connect(self.touchme2)
        self.layout4.addLayout(self.layout3)
        self.layout4.addWidget(self.canvas2)
        self.layout4.addWidget(self.toolbar2)
        self.tab3.layout.addLayout(self.layout4)
        self.tab3.layout.addWidget(self.list2)
        self.tab3.setLayout(self.tab3.layout)

        ################USER GUIDE################
        
        self.tab4.layout = QVBoxLayout(self)
        self.layout6 = QHBoxLayout(self)
        self.layout32= QHBoxLayout(self)
        self.layout33=QVBoxLayout(self)
        self.message1=QLabel('Hi friend, thanks to you for choosing us.')
        self.layout6.addWidget(self.message1)
        self.message6=QLabel('This program is Open-Source and It will always be free')
        self.layout32.addWidget(self.message6)
        self.layout33.addLayout(self.layout6)
        self.layout33.addLayout(self.layout32)
        self.tab4.layout.addLayout(self.layout33)
        self.tab4.setLayout(self.tab4.layout)
        
        ##################CALCULATOR#####################
        
        self.tab5.layout = QVBoxLayout(self)
        self.layout7 = QVBoxLayout(self)
        self.layout8 = QHBoxLayout(self)
        self.layout9 = QHBoxLayout(self)
        self.layout10=QHBoxLayout(self)
        self.message7 = QLabel(' You can calculate all currencies here')
        self.btcbutton = QPushButton("BTC Based Coins")
        self.btcbutton.clicked.connect(self.calculator1)
        self.layout8.addWidget(self.btcbutton)
        self.info3 = QLabel(" Choose the Type of Your Coin Bases for 1.Coin ")
        self.layout8.addWidget(self.info3)
        self.ethbutton = QPushButton("ETH Based Coins")
        self.ethbutton.clicked.connect(self.calculator2)
        self.layout8.addWidget(self.ethbutton)
        self.calc1 = QLineEdit(self)
        self.calc1.setPlaceholderText("Value(ex 1,01)")
        self.layout9.addWidget(self.calc1)
        self.box7 = QComboBox(self)
        self.box7.addItem("1.Coin")
        self.box7.activated[int].connect(self.calculator3)
        self.layout9.addWidget(self.box7)
        self.info5 = QLabel(" =========== ")
        self.layout9.addWidget(self.info5)
        self.info6 = QLineEdit(self)
        self.info6.setPlaceholderText(" Result ")
        self.layout9.addWidget(self.info6)
        self.box8 = QComboBox(self)
        self.box8.addItem("2.Coin")
        self.box8.addItem("BTC")
        self.box8.addItem("ETH")
        self.box8.addItem("ETC")
        self.box8.addItem("LTC")
        self.box8.addItem("USDT")
        self.box8.activated[str].connect(self.calculator4)
        self.summary=QPushButton("Calculate")
        self.summary.clicked.connect(self.calculator5)
        self.layout10.addWidget(self.summary)
        self.layout9.addWidget(self.box8)
        self.layout7.addLayout(self.layout8)
        self.layout7.addLayout(self.layout9)
        self.layout7.addLayout(self.layout10)
        self.tab5.layout.addLayout(self.layout7)
        self.tab5.setLayout(self.tab5.layout)

        ############# Add tabs to widget ################
        
        self.layout.addWidget(self.tabs)
        self.setLayout(self.layout)
        
        #################----------------------#FUNCTIONS#-----------------------#####################################
        
    def calculator1(self):
        global selected1
        self.box7.clear()
        self.box7.addItem("Select")
        self.box7.addItems(btc)
        selected1 = 0
        
    def calculator2(self):
        global selected1
        self.box7.clear()
        self.box7.addItem("Select")
        self.box7.addItems(eth)
        selected1=1
        
    def calculator3(self, number5):
        global coin1
        if selected1==0:
            if number5!=0:coin1=btc[number5-1]
        else:
            if number5!=0:coin1=eth[number5-1]
            
    def calculator4(self, type55):
        global coin2
        coin2=type55
        
    def calculator5(self):
        if (self.calc1.text() != ""):
            x,y=current(coin2,coin1)
            y=float(y)*float(self.calc1.text())
            self.info6.setText(format(y,'.10f'))
        else:
            self.info6.setText("Please Write Down Some Value")
            
    def searchitem(self):#####SORUNSUZ######
        global ss
        if (self.search1.text() != ""):
            ss = self.search1.text().upper()
            true1=matching(ss,"BTC")
            if 1==true1:
                self.figure1.clear()
                self.search1.clear()
                self.search1.setPlaceholderText("Also you can write here")
                self.plot1()
            else:
                self.search1.clear()
                self.search1.setPlaceholderText("Wrong Name, Try Again")
                
    def searchitem2(self):#####SORUNSUZ#####
        global ss2
        if (self.search2.text() != ""):
            ss2 = self.search2.text().upper()
            true2 = matching(ss2, "ETH")
            if 1 == true2:
                self.figure2.clear()
                self.search2.clear()
                self.search2.setPlaceholderText("Also you can write here")
                self.plot2()
            else:
                self.search2.clear()
                self.search2.setPlaceholderText("Wrong Name, Try Again")
                
    def onActivated(self, number): ####SORUNSUZ#####
        global choose1
        self.figure1.clear()
        if 0==number:
            self.search1.setPlaceholderText("Also you can write here")
            self.list1.clear()
            self.list1.addItems(btc)
            choose1=0
        if 1==number:
            self.search1.setPlaceholderText("Don't use me. Here. Our Api is broken nowadays")
            self.list1.clear()
            self.list1.addItem("BTC")
            self.list1.addItem("LTC")
            self.list1.addItem("XMR")
            self.list1.addItem("XRP")
            self.list1.addItem("ZEC")
            choose1 = 1
            
    def onActivated2(self, number2): ####SORUNSUZ#####
        global choose
        self.figure2.clear()
        if 0==number2:
            self.search2.setPlaceholderText("Also you can write here")
            self.list2.clear()
            self.list2.addItems(eth)
            choose=0
        if 1==number2:
            self.search2.setPlaceholderText("Don't use me. Here. Our Api is broken nowadays")
            self.list2.clear()
            self.list2.addItem("ETH")
            self.list2.addItem("XRP")
            self.list2.addItem("ZEC")
            self.list2.addItem("XMR")
            choose = 1
            
    def touchme(self):###SORUNSUZ###
        global ss
        self.figure1.clear()
        ss = self.list1.currentItem().text()
        self.plot1()
        
    def touchme2(self): ###SORUNSUZ###
        global ss2
        self.figure2.clear()
        ss2 = self.list2.currentItem().text()
        self.plot2()
        
    ###############################################-----PLOT1 SORUNSUZ-----################################################
    
    def plot1(self):
        if choose1==0:
            #ax = self.figure1
            type6 = ss
            style.use('ggplot')
            ax = self.figure1.add_subplot(1, 1, 1)
            type5="BTC"
            time1, value1 = current(type5, type6)
            title2 = type5 + " - " + type6 + " Latest History Chart\nCurrent Price = " + format(value1,'.10f')
            ax.set_title(title2)
            plt.xticks(rotation=90, size=15)
            plt.yticks(size=15)
            self.figure1.autofmt_xdate()
            myFmt = mdates.DateFormatter('%H:%M:%S')
            ax.xaxis.set_major_formatter(myFmt)
            x1, y1 = history(type5, type6)
            ax.plot(x1, y1, color='red')
            def animate1(i):
                time1, value1 = current(type5, type6)
                title2 = type5 + " - " + type6 + " Latest History Chart\nCurrent Price = " + str(value1)
                ax.set_title(title2)
                plt.xticks(rotation=90,size=15)
                plt.yticks(size=15)
                self.figure1.autofmt_xdate()
                myFmt = mdates.DateFormatter('%H:%M:%S')
                ax.xaxis.set_major_formatter(myFmt)
                x1, y1 = history(type5, type6)
                ax.plot(x1, y1, color='red')
            ani1 = animation.FuncAnimation(self.figure1, animate1, interval=20000)
            scale = 1.1
            figZoom = self.zoom_factory(ax, base_scale=scale)
            figPan = self.pan_factory(ax)
            self.canvas1.draw()
        if choose1==1:
            ax=self.figure1
            type1=ss
            style.use('ggplot')
            ax = self.figure1.add_subplot(1, 1, 1)
            plt.xticks(rotation=90, size=15)
            plt.yticks(size=15)
            plt.gcf().autofmt_xdate()
            myFmt = mdates.DateFormatter('%Y:%m:%d')
            plt.gca().xaxis.set_major_formatter(myFmt)
            x, y = usd_x_alltime(type1)
            ax.plot(x, y, color='red')
            time, value = current("USDT", type1)
            title = "USD - " + type1 + " All Time History Chart\nCurrent Price = " + format(value,'.10f')
            ax.set_title(title)
            scale = 1.1
            figZoom = self.zoom_factory(ax, base_scale=scale)
            figPan = self.pan_factory(ax)
            self.canvas1.draw()
            
    ###############################################-----PLOT2 Sorunsuz-------################################################
    
    def plot2(self):
        if choose==0:
            #ax = self.figure2
            type4 = ss2
            style.use('ggplot')
            ax = self.figure2.add_subplot(1, 1, 1)
            type3="ETH"
            time2, value2 = current(type3, type4)
            title2 = type3 + " - " + type4 + " Latest History Chart\nCurrent Price = " + format(value2,'.10f')
            ax.set_title(title2)
            plt.xticks(rotation=90, size=15)
            plt.yticks(size=15)
            self.figure2.autofmt_xdate()
            myFmt = mdates.DateFormatter('%H:%M:%S')
            ax.xaxis.set_major_formatter(myFmt)
            x2, y2 = history(type3, type4)
            ax.plot(x2, y2, color='red')
            def animate2(i):
                time2, value2 = current(type3, type4)
                title2 = type3 + " - " + type4 + " Latest History Chart\nCurrent Price = " + str(value2)
                ax.set_title(title2)
                plt.xticks(rotation=90,size=15)
                plt.yticks(size=15)
                self.figure2.autofmt_xdate()
                myFmt = mdates.DateFormatter('%H:%M:%S')
                ax.xaxis.set_major_formatter(myFmt)
                x2, y2 = history(type3, type4)
                ax.plot(x2, y2, color='red')
            ani = animation.FuncAnimation(self.figure2, animate2, interval=20000)
            scale = 1.1
            figZoom = self.zoom_factory(ax, base_scale=scale)
            figPan = self.pan_factory(ax)
            self.canvas2.draw()
        if choose==1:
            self.figure2.clear()
            ax=self.figure2
            type1=ss2
            style.use('ggplot')
            ax = self.figure2.add_subplot(1, 1, 1)
            plt.xticks(rotation=90, size=15)
            plt.yticks(size=15)
            self.figure2.autofmt_xdate()
            myFmt = mdates.DateFormatter('%Y:%m:%d')
            ax.xaxis.set_major_formatter(myFmt)
            x2, y2 = usd_x_alltime(type1)
            ax.plot(x2, y2, color='red')
            time, value = current("USDT", type1)
            title = "USD - " + type1 + " All Time History Chart\nCurrent Price = " + format(value,'.10f')
            ax.set_title(title)
            scale = 1.1
            figZoom = self.zoom_factory(ax, base_scale=scale)
            figPan = self.pan_factory(ax)
            self.canvas2.draw()
            
    def timerEvent(self, e):################SORUNSUZ################
        if self.step >= 100:
            self.button1.setText('Click to Open App')
            self.timer.stop()
        if self.step ==50:
            self.button1.setText('Thanks your patient')
        if self.step ==5:
            self.tabs.addTab(self.tab4,"User Guide")
            self.tabs.setTabEnabled(1,False)
        if self.step == 35:
            self.list1.addItems(btc)
            self.tabs.addTab(self.tab2, "BTC Based Coins")
            self.tabs.setTabEnabled(2, False)
        if self.step == 60:
            self.list2.addItems(eth)
            self.tabs.addTab(self.tab3, "ETH Based Coins")
            self.tabs.setTabEnabled(3, False)
        if self.step ==90:
            self.tabs.addTab(self.tab5,"Calculator")
            self.tabs.setTabEnabled(4,False)
        #self.step = self.step + 1
        self.step = self.step + 5
        self.pbar.setValue(self.step)
        
    def doAction(self):################SORUNSUZ################
        self.timer.start(100, self)
        self.button1.setText('App is Loading...')
        if self.step>=100:
            ex.resize(600, 610)
            ex.setMaximumWidth(610)
            ex.setMaximumHeight(600)
            ex.setMinimumWidth(610)
            ex.setMinimumHeight(600)
            ex.move(400,80)
            self.tabs.removeTab(0)
            self.height=500
            self.width=500
            self.tabs.setTabEnabled(0, True)
            self.tabs.setTabEnabled(1, True)
            self.tabs.setTabEnabled(2, True)
            self.tabs.setTabEnabled(3,True)
            self.tabs.setCurrentIndex(0)
            
    def zoom_factory(self, ax, base_scale=2.):
        def zoom(event):
            cur_xlim = ax.get_xlim()
            cur_ylim = ax.get_ylim()
            xdata = event.xdata
            ydata = event.ydata
            if event.button == 'down':
                scale_factor = base_scale
            elif event.button == 'up':
                scale_factor = 1 / base_scale
            else:
                scale_factor = 1
            new_width = (cur_xlim[1] - cur_xlim[0]) * scale_factor
            new_height = (cur_ylim[1] - cur_ylim[0]) * scale_factor
            relx = (cur_xlim[1] - xdata) / (cur_xlim[1] - cur_xlim[0])
            rely = (cur_ylim[1] - ydata) / (cur_ylim[1] - cur_ylim[0])
            ax.set_xlim([xdata - new_width * (1 - relx), xdata + new_width * (relx)])
            ax.set_ylim([ydata - new_height * (1 - rely), ydata + new_height * (rely)])
            ax.figure.canvas.draw()
        fig = ax.get_figure()
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
            event.canvas.figure.patch.set_facecolor('red')
            event.canvas.draw()
        fig = ax.get_figure()
        fig.canvas.mpl_connect('button_press_event', onPress)
        fig.canvas.mpl_connect('button_release_event', onRelease)
        fig.canvas.mpl_connect('motion_notify_event', onMotion)
        fig.canvas.mpl_connect('figure_enter_eventasdfasdf', enter_figure)
        return onMotion
    
    @pyqtSlot()
    def on_click(self):
        self.figure2.clear()
        self.figure1.clear()
        print("\n")
        for currentQTableWidgetItem in self.tableWidget.selectedItems():
            print(currentQTableWidgetItem.row(), currentQTableWidgetItem.column(), currentQTableWidgetItem.text())
            
if __name__ == '__main__':
    app = QApplication(sys.argv)
    ex = App()
    sys.exit(app.exec_())
