# file: chat_server.py
import socket
import sys
from socket import *
import socket
import select
from datetime import datetime
from datetime import timedelta
import sqlite3
import bcrypt
from _thread import start_new_thread

conn = sqlite3.connect("users.db")
cursor = conn.cursor()

HOST = "45.55.169.97"
SOCKET_LIST = {}
RECV_BUFR = 4096
PORT = 34000


def chat_server():
    server_socket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    server_socket.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)
    server_socket.bind((HOST, PORT))
    server_socket.listen(10)

    SOCKET_LIST['Host'] = server_socket

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
                        with open("messages.txt", "a", encoding="utf-8") as file:
                            file.write("\n" + "[" + (datetime.now() + timedelta(hours=3)).strftime(
                                '%Y:%m:%d:%H:%M') + "] server > " + m)
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
            print("\n" + "[" + (datetime.now() + timedelta(hours=3)).strftime('%H:%M') + "] " + msg)
            send_msg_to_all(server_socket, sock, username, msg)
            with open("messages.txt", "a", encoding="utf-8") as file:
                file.write("\n" + "[" + (datetime.now() + timedelta(hours=3)).strftime('%Y:%m:%d:%H:%M') + "] " + msg)
        else:
            remove_user(username)


    except(UnboundLocalError):
        print("The user doesnt exist.")

    except(ConnectionResetError, NameError, socket.timeout) as e:
        username=get_username(sock)
        msg = "[*]" + username + " exited."
        print("\n" + msg)
        send_msg_to_all(server_socket, sock, username, msg)


def send_msg_to_all(server_socket, senders_socket, senders_username, message):
    print("Entering send_msg_to_all")

    message = "" + message
    for username, socket in SOCKET_LIST.items():
        if socket != server_socket and socket != senders_socket:
            try:
                socket.send(bytes(message, 'UTF-8'))
            except:
                socket.close()
                remove_user(username)
    print("admin>")


def add_user(server_socket):
    new_sock, new_addr = server_socket.accept()
    joindata = new_sock.recv(RECV_BUFR).decode().rstrip()
    new_sock.settimeout(30)
    namepasswd = joindata.split('&')
    username = namepasswd[0]
    password = namepasswd[1]
    if namepasswd[2]=="1":
        print("Giriş")
        cursor.execute("SELECT * FROM users WHERE username = '%s'" % (username))
        data = cursor.fetchall()
        if len(data) > 0:
            if bcrypt.checkpw(password.encode('utf-8'),data[0][1]):
                SOCKET_LIST[username] = new_sock
                new_sock.send(bytes("OK","UTF-8"))
                all_users = ''
                for user, socket in SOCKET_LIST.items():
                    all_users += "&" + user
                with open("messages.txt", "r", encoding="utf-8") as file:
                    pastmessage = file.read()
                all_users = pastmessage + all_users + "&#True"
                start_new_thread(new_sock.send, (bytes(all_users, 'UTF-8'),))
                mesg = "[*]" + username + " entered."
                print("\n" + mesg)
                print_all_users()
                send_msg_to_all(server_socket, new_sock, username, mesg)
        else:
            print(username + " " + str(new_addr) + " failed to connect.")
            new_sock.send(bytes("NOT_UNIQUE", 'UTF-8'))
            new_sock.close()
            print("admin>")
    elif namepasswd[2]=="0":
        print("KAYIT")
        password = bytes(password, encoding='utf-8')
        cursor.execute("SELECT * FROM users WHERE username = '%s'" % (username))
        # username baki olanlar dondu.
        data = cursor.fetchall()
        # print(type(data)) #liste seklinde.
        if not (len(data) > 0):
            print(username)
            print(password)
            password=bcrypt.hashpw(password,bcrypt.gensalt(14))
            cursor.execute("Insert into users Values(?,?)", (username, password))
            conn.commit()
            new_sock.send(bytes("True", 'UTF-8'))
            new_sock.close()
        else:
            print(username + " " + str(new_addr) + " is already used.")
            new_sock.send(bytes("False", 'UTF-8'))
            new_sock.close()
            print("admin>")

    # if username not in SOCKET_LIST and username.strip() != "":
    #     SOCKET_LIST[username] = new_sock
    #     new_sock.send(bytes("OK",'UTF-8'))
    #     all_users = ''
    #     for user,socket in SOCKET_LIST.items():
    #         all_users += "&"+user
    #     new_sock.send(bytes(all_users,'UTF-8'))
    #     mesg = "[*]"+username+ " entered."
    #     print("\n"+mesg)
    #     print_all_users()
    #     send_msg_to_all(server_socket,new_sock,username,mesg)
    # else:
    #     print(username+" "+str(new_addr)+" failed to connect.")
    #     new_sock.send(bytes("NOT_UNIQUE",'UTF-8'))
    #     new_sock.close()
    #     print("admin>")


def remove_user(username, kicked=False):
    try:
        SOCKET_LIST[username].close()
        del SOCKET_LIST[username]
        msg = "[*]" + username + " exited."
        print(msg)
        print_all_users()
        send_msg_to_all(SOCKET_LIST['Host'], SOCKET_LIST['Host'], \
                        'Host', msg)
    except KeyError:
        pass


def get_username(socket):
    u = ''
    for username, sock in SOCKET_LIST.items():
        if socket == sock:
            u = username
    return u


def get_all_sockets():
    all_sockets = []
    all_sockets.append(sys.stdin)
    for username, socket in SOCKET_LIST.items():
        all_sockets.append(socket)
    return all_sockets


def print_all_users():
    all_users = "\nUSERS: ["
    for user, socket in SOCKET_LIST.items():
        all_users += user + ","
    print(all_users[:-1] + "]")


if __name__ == "__main__":
    chat_server()
