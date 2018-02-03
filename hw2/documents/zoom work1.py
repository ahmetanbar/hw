from matplotlib.pyplot import figure, show
import numpy
import matplotlib.pyplot as plt
from data import *
import matplotlib.animation as animation
import matplotlib.dates as mdates  # matplotlib e dateler yazdýrmak için kütüphane eklendi
from matplotlib import style
import requests
import dateutil.parser
from data import history

class ZoomPan:
    def __init__(self):
        self.press = None
        self.cur_xlim = None
        self.cur_ylim = None
        self.x0 = None
        self.y0 = None
        self.x1 = None
        self.y1 = None
        self.xpress = None
        self.ypress = None

    def zoom_factory(self, ax, base_scale=2.):
        def zoom(event):
            cur_xlim = ax.get_xlim()
            cur_ylim = ax.get_ylim()
            cur_ylim = ax.get_ylim()

            xdata = event.xdata  # get event x location
            ydata = event.ydata  # get event y location

            if event.button == 'down':
                # deal with zoom in
                scale_factor = 1 / base_scale
            elif event.button == 'up':
                # deal with zoom out
                scale_factor = base_scale
            else:
                # deal with something that should never happen
                scale_factor = 1
                print(event.button)

            new_width = (cur_xlim[1] - cur_xlim[0]) * scale_factor
            new_height = (cur_ylim[1] - cur_ylim[0]) * scale_factor

            relx = (cur_xlim[1] - xdata) / (cur_xlim[1] - cur_xlim[0])
            rely = (cur_ylim[1] - ydata) / (cur_ylim[1] - cur_ylim[0])

            ax.set_xlim([xdata - new_width * (1 - relx), xdata + new_width * (relx)])
            ax.set_ylim([ydata - new_height * (1 - rely), ydata + new_height * (rely)])
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
            print("clicked")

        def onRelease(event):
            self.press = None
            ax.figure.canvas.draw()
            print("released")

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

        # attach the call back
        fig.canvas.mpl_connect('button_press_event', onPress)
        fig.canvas.mpl_connect('button_release_event', onRelease)
        fig.canvas.mpl_connect('motion_notify_event', onMotion)
        fig.canvas.mpl_connect('figure_enter_eventasdfasdf', enter_figure)

        # return the function
        return onMotion


fig = plt.figure(figsize=(15,10), dpi=50 , num=20)
ax=fig.add_subplot(1,1,1)
plt.xticks(rotation=90,size=15)
plt.gcf().autofmt_xdate()
myFmt = mdates.DateFormatter('%H:%M:%S')  # Datatime daki deðerlerin hangi formatta yazdýrýlacaðýný seçtik.
plt.gca().xaxis.set_major_formatter(myFmt)
# ax = fig.add_subplot(111, xlim=(0, 1), ylim=(0, 1), autoscale_on=False)
# ax = fig.add_subplot(111)
ax.set_title('Click to zoom')

# x, y, s, c = numpy.random.rand(4, 200)
# s *= 200
x,y=history("BTC","LTC")

ax.plot(x,y,color='red')
scale = 1.1
zp = ZoomPan()
figZoom = zp.zoom_factory(ax, base_scale=scale)
figPan = zp.pan_factory(ax)

show()
