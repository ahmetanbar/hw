# file: chat_server.py
from datetime import datetime,timedelta
import socket,sys,select,sqlite3,bcrypt
from _thread import start_new_thread

HOST = "45.55.169.97"
user_list = {}
RECV_BUFR = 4096
PORT = 34000
CONN = sqlite3.connect("users.db")
CURSOR = CONN.cursor()
all_users2=[]

def chat_server():
    server_socket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    server_socket.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)
    server_socket.bind((HOST, PORT))
    server_socket.listen(10)
    user_list[''] = server_socket
    print("*********CHAT RUNNİNG********")
    print("\nadmin>")
    while 1:
        try:
            all_sockets = get_all_sockets()
            ready_to_read, ready_to_write, in_error = \
                select.select(all_sockets, [], [], 0)
            for sock in ready_to_read:
                if sock == server_socket:
                    add_user(server_socket)
                elif sock == sys.stdin:
                    m = sys.stdin.readline().rstrip()
                    send_msg_to_all(server_socket, server_socket, "server",
                                    "server > " + m)
                    if m:
                        with open("messages", "a", encoding="utf-8") as file:
                            file.write("\n" + "[" + (datetime.now() + timedelta(hours=3)).strftime(
                                '%Y:%m:%d:%H:%M') + "] server > " + m + " $$")
                else:
                    recv_msg(server_socket, sock)
        except(KeyboardInterrupt):
            print("Program terminated.")
            sys.exit()

def recv_msg(server_socket, sock):
    try:
        data = sock.recv(RECV_BUFR).decode()
        username = get_username(sock)
        if data:
            msg = username + " > " + data.rstrip()
            print("\n" + "[" + (datetime.now() + timedelta(hours=3)).strftime('%H:%M') + "] "+ msg)
            send_msg_to_all(server_socket, sock, username, msg)
            with open("messages", "a", encoding="utf-8") as file:
                file.write("\n" + "[" + (datetime.now() + timedelta(hours=3)).strftime('%Y:%m:%d:%H:%M') + "] " +"@"+ msg+" $$")
        else:
            remove_user(username)

    except(UnboundLocalError):
        print("The user doesnt exist.")

    except(ConnectionResetError, NameError, socket.timeout) as e:
        username=get_username(sock)
        msg = "[*]" +"@"+ username + " exited."
        print("\n" + msg)
        send_msg_to_all(server_socket, sock, username, msg)

def send_msg_to_all(server_socket, senders_socket, senders_username, message):
    print("Entering send_msg_to_all")
    message = "" + message
    for username, socket in user_list.items():
        if socket != server_socket and socket != senders_socket:
            try:
                socket.send(bytes(message, 'UTF-8'))
            except:
                socket.close()
                remove_user(username)
    print("admin>")
def get_usernames():
    CURSOR.execute("SELECT * FROM users")
    names=""
    for user in CURSOR.fetchall():
        names="@"+str(user[0])+"&"+names
    all_users2=names
    return all_users2

def add_user(server_socket):
    try:
        new_sock, new_addr = server_socket.accept()
        joindata = new_sock.recv(RECV_BUFR).decode().rstrip()
        new_sock.settimeout(30)
        namepasswd = joindata.split('&')
        username = namepasswd[0]
        password = namepasswd[1]
        get_usernames()
        if namepasswd[2]=="1":
            CURSOR.execute("SELECT * FROM users WHERE username = '%s'" % (username))
            data = CURSOR.fetchall()

            if len(data) > 0:
                if bcrypt.checkpw(password.encode('utf-8'),data[0][1]):
                    user_list[username] = new_sock
                    new_sock.send(bytes("1","UTF-8"))
                    all_users = ''
                    for user, socket in user_list.items():
                        all_users += "&" + user
                    with open("messages", "r", encoding="utf-8") as file:
                        pastmessage = file.read()

                    all_users = pastmessage + all_users + "&#True"
                    #  +"*_*"+ get_usernames()
                    print(all_users)
                    start_new_thread(new_sock.send, (bytes(all_users, 'UTF-8'),))
                    mesg = "[*]" +"@"+ username + " entered."
                    #print("\n" + mesg)
                    print_all_users()
                    send_msg_to_all(server_socket, new_sock, username, mesg)
            else:
                print(username + " " + str(new_addr) + " failed to connect.")
                new_sock.send(bytes("0", 'UTF-8'))
                new_sock.close()
                print("admin>")
        elif namepasswd[2]=="0":
            print("KAYIT")
            password = bytes(password, encoding='utf-8')
            CURSOR.execute("SELECT * FROM users WHERE username = '%s'" % (username))
            data = CURSOR.fetchall()
            if not (len(data) > 0):
                print(username)
                print(password)
                password=bcrypt.hashpw(password,bcrypt.gensalt(14))
                CURSOR.execute("Insert into users Values(?,?)", (username, password))
                CONN.commit()
                new_sock.send(bytes("1", 'UTF-8'))
                new_sock.close()
            else:
                print(username + " " + str(new_addr) + " is already used.")
                new_sock.send(bytes("0",'UTF-8'))
                new_sock.close()
                print("admin>")
    except:
        for i in range(0,10):
            new_sock.send(bytes("USE MY FUCKING GUI\n", 'UTF-8'))
        new_sock.close()
def remove_user(username, kicked=False):
    try:
        user_list[username].close()
        del user_list[username]
        msg = "[*]" +"@"+ username + " exited."
        print(msg)
        print_all_users()
        send_msg_to_all(user_list[''], user_list[''], \
                        '', msg)
    except KeyError:
        pass


def get_username(socket):
    u = ''
    for username, sock in user_list.items():
        if socket == sock:
            u = username
    return u

def get_all_sockets():
    all_sockets = []
    all_sockets.append(sys.stdin)
    for username, socket in user_list.items():
        all_sockets.append(socket)
    return all_sockets

def print_all_users():
    all_users = "\nUSERS: ["
    for user, socket in user_list.items():
        all_users += user + ","
    print(all_users[:-1] + "]")
    print(get_usernames())

if __name__ == "__main__":
    chat_server()
