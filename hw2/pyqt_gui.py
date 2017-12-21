import sys
import requests
import numpy as np

from PyQt5.QtWidgets import QDialog, QApplication, QPushButton, QVBoxLayout,QHBoxLayout, QListView, QListWidget, QLineEdit, QLabel
from matplotlib.backends.backend_qt5agg import FigureCanvasQTAgg as FigureCanvas
from matplotlib.backends.backend_qt5agg import NavigationToolbar2QT as NavigationToolbar
import matplotlib.pyplot as plt

class Window(QDialog):
    def __init__(self, parent=None):
        super(Window, self).__init__(parent)

        self.setMinimumWidth(1000)
        self.setMinimumHeight(500)
        self.setMaximumWidth(1000)
        self.setMaximumHeight(500)

        self.setWindowTitle('GUI 2018')
        self.listWidget = QListWidget(self)
        self.button = QPushButton('Search and Plot',self)
        self.button.clicked.connect(self.plot)
        self.button2 = QPushButton('BTC',self)
        self.button3 = QPushButton('ETH',self)
        self.button4 = QPushButton('USD',self)
        self.textbox = QLineEdit(self)
        self.textbox.move(0,405)
        self.button.move(0,435)
        self.button.resize(100,20)
        self.button2.move(50,470)
        self.button2.resize(50,20)
        self.button3.move(150,470)
        self.button3.resize(50,20)
        self.button4.move(250,470)
        self.button4.resize(50,20)
        self.listWidget.move(0,0)
        self.listWidget.resize(100,400)

        self.figure = plt.figure()
        self.canvas = FigureCanvas(self.figure)

        graphbox = QHBoxLayout()
        graphbox.addStretch()
        graphbox.addWidget(self.canvas)

        self.setLayout(graphbox)



    def plot(self):
        xList= []
        yList= []
        summaryurl = "https://bittrex.com/api/v1.1/public/getmarkethistory?market=BTC-ETH"
        summary = requests.get(summaryurl)
        json_summary = summary.json()
        print(summaryurl)
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
        ax.set_title("Baki Almacı")
        self.canvas.draw()

app = QApplication(sys.argv)
main = Window()
main.setGeometry(450,300,1000,800)
main.show()
sys.exit(app.exec_())