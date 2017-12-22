import sys
from graph import *
from data import *
from PyQt5.QtWidgets import QDialog, QApplication, QPushButton, QHBoxLayout, QListWidget, QMessageBox, QLineEdit
from matplotlib.backends.backend_qt5agg import FigureCanvasQTAgg as FigureCanvas
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

        self.button = QPushButton('Search and Plot', self)
        self.button.clicked.connect(self.search)
        self.button2 = QPushButton('BTC', self)
        self.button2.clicked.connect(self.addlistbtc)
        self.button3 = QPushButton('ETH', self)
        self.button3.clicked.connect(self.addlisteth)
        self.button4 = QPushButton('USDT', self)
        self.button4.clicked.connect(self.addlistusdt)
        self.button.move(10, 435)
        self.button.resize(150, 20)
        self.button2.move(10, 455)
        self.button2.resize(50, 38)
        self.button3.move(60, 455)
        self.button3.resize(50, 38)
        self.button4.move(110, 455)
        self.button4.resize(50, 38)
        self.listWidget.move(10, 10)
        self.listWidget.resize(150, 390)
        self.listWidget.itemClicked.connect(self.Clicked)
        self.textbox = QLineEdit(self)
        self.textbox.move(10, 405)
        self.textbox.resize(150, 30)

        self.figure = plt.figure(figsize=(15, 10), dpi=50, num=20)
        self.canvas = FigureCanvas(self.figure)

        ##########################################################
        self.press = None
        self.cur_xlim = None
        self.cur_ylim = None
        self.x0 = None
        self.y0 = None
        self.x1 = None
        self.y1 = None
        self.xpress = None
        self.ypress = None
        ##########################################################

        graphbox = QHBoxLayout()
        graphbox.addStretch()
        graphbox.addWidget(self.canvas)
        self.setLayout(graphbox)
###########################################################################
    def zoom_factory(self, ax, base_scale=1.):

        def zoom(event):
            cur_xlim = ax.get_xlim()
            cur_ylim = ax.get_ylim()

            xdata = event.xdata  # get event x location
            ydata = event.ydata  # get event y location

            if event.button == 'down':
                # deal with zoom in
                scale_factor = base_scale
            elif event.button == 'up':
                scale_factor = 1 / base_scale
            else:

                scale_factor = 1
                print(event.button)

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
            # print("clicked")

        def onRelease(event):
            self.press = None
            ax.figure.canvas.draw()
            # print("released")

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
###########################################################################
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
        elif a.upper() == "ETH-O":
            self.addlisteth()
        elif a.upper() == "USDT-O":
            self.addlistusdt()

        items = []
        s = 0
        for i in range(self.listWidget.count()):
            s += 1

        if s == 0:
            buttonReply = QMessageBox.question(self, 'Beklenen HATA !!!',
                                               "Bir dahaki sefere Listeyi doldurmadan basmayacağıma söz veriyorum.",
                                               QMessageBox.Yes | QMessageBox.No, QMessageBox.No)
            if buttonReply == QMessageBox.Yes:
                self.close()
                self.open()
                self.textbox.clear()
            else:
                print(" Designed by bakialmaci ")
                self.close()

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
        self.textbox.clear()

    def addlistbtc(self):
        global type1
        eth, btc, usdt = names_eth_btc_usdt()
        self.listWidget.clear()
        self.listWidget.addItems(btc)
        type1 = "BTC"
        print(type1)
        self.canvas.close_event()
        self.figure.clear()

    def addlisteth(self):
        global type1
        eth, btc, usdt = names_eth_btc_usdt()
        self.listWidget.clear()
        self.listWidget.addItems(eth)
        type1 = "ETH"
        print(type1)
        self.canvas.close_event()
        self.figure.clear()

    def addlistusdt(self):
        global type1
        eth, btc, usdt = names_eth_btc_usdt()
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
        elif type1 == "USDT":
            # print(item.text())
            self.figure.clear()
            self.graph_usd_x_alltime()

    def graph_latest(self):

        self.textbox.clear()
        global select1
        select1 = self.listWidget.currentItem().text()
        print(select1)

        style.use('ggplot')
        fig = plt.figure(figsize=(15, 10), dpi=50, num=20)
        ax = fig.add_subplot(1, 1, 1)

        def animate(i):
            time, value = current(type1, select1)
            plt.xticks(rotation=45, size=10)
            plt.gcf().autofmt_xdate()
            myFmt = mdates.DateFormatter('%H:%M:%S')
            plt.gca().xaxis.set_major_formatter(myFmt)
            ax.set_title(type1 + " - " + select1 + " Latest History Chart\nCurrent Price = " + str(value))
            x, y = history(type1, select1)
            ax.plot(x, y, color='red')
            scale = 1.1
            self.zoom_factory(ax, base_scale=scale)
            self.pan_factory(ax)

        ani = animation.FuncAnimation(self.figure, animate, interval=2000)
        self.canvas.draw()

    def graph_latest2(self):
        self.textbox.clear()
        global select1
        print(select1)

        style.use('ggplot')
        fig = plt.figure(figsize=(15, 10), dpi=50, num=20)
        ax = fig.add_subplot(1, 1, 1)

        def animate(i):
            time, value = current(type1, select1)
            plt.xticks(rotation=45, size=10)
            plt.gcf().autofmt_xdate()
            myFmt = mdates.DateFormatter('%H:%M:%S')
            plt.gca().xaxis.set_major_formatter(myFmt)
            ax.set_title(type1 + " - " + select1 + " Latest History Chart\nCurrent Price = " + str(value))
            x, y = history(type1, select1)
            ax.plot(x, y, color='red')
            scale = 1.1
            self.zoom_factory(ax, base_scale=scale)
            self.pan_factory(ax)

        ani = animation.FuncAnimation(self.figure, animate, interval=2000)
        self.canvas.draw()

    def graph_usd_x_alltime2(self):
        self.textbox.clear()
        global select1
        print(select1)

        if (select1 == "BTC" or select1 == "ETH" or select1 == "ETH"):
            style.use('ggplot')
            fig = plt.figure(figsize=(15, 10), dpi=50, num=20)
            ax = fig.add_subplot(1, 1, 1)

            def animate(i):
                time, value = current("USDT", select1)
                plt.xticks(rotation=45, size=10)
                plt.gcf().autofmt_xdate()
                myFmt = mdates.DateFormatter('%H:%M:%S')
                plt.gca().xaxis.set_major_formatter(myFmt)
                ax.set_title(type1 + " - " + select1 + " Latest History Chart\nCurrent Price = " + str(value))
                x, y = usd_x_alltime(select1)
                ax.plot(x, y, color='red')
                scale = 1.1
                self.zoom_factory(ax, base_scale=scale)
                self.pan_factory(ax)

            ani = animation.FuncAnimation(self.figure, animate, interval=1000)
            self.canvas.draw()

    def graph_usd_x_alltime(self):
        self.textbox.clear()
        global select1
        select1 = self.listWidget.currentItem().text()
        print(select1)

        if (select1 == "BTC" or select1 == "ETH" or select1 == "ETH"):
            style.use('ggplot')
            fig = plt.figure(figsize=(15, 10), dpi=50, num=20)
            ax = fig.add_subplot(1, 1, 1)

            def animate(i):
                time, value = current("USDT", select1)
                plt.xticks(rotation=45, size=10)
                plt.gcf().autofmt_xdate()
                myFmt = mdates.DateFormatter('%H:%M:%S')
                plt.gca().xaxis.set_major_formatter(myFmt)
                ax.set_title(type1 + " - " + select1 + " Latest History Chart\nCurrent Price = " + str(value))
                x, y = usd_x_alltime(select1)
                ax.plot(x, y, color='red')
                scale = 1.1
                self.zoom_factory(ax, base_scale=scale)
                self.pan_factory(ax)

            ani = animation.FuncAnimation(self.figure, animate, interval=1000)
            self.canvas.draw()

app = QApplication(sys.argv)
main = Window()
main.setGeometry(450, 300, 1000, 800)
main.show()
sys.exit(app.exec_())
