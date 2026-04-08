#!/usr/bin/env python3
import socket, ssl, threading
LISTEN_ADDR = '0.0.0.0'
LISTEN_PORT = 8443
BACKEND_HOST = '127.0.0.1'
BACKEND_PORT = 8080
CERTFILE = 'cert.crt'
KEYFILE = 'cert.key'

def pipe(src, dst):
    try:
        while True:
            data = src.recv(4096)
            if not data:
                break
            dst.sendall(data)
    except Exception:
        pass
    finally:
        try:
            dst.shutdown(socket.SHUT_WR)
        except Exception:
            pass

def handle(client_sock):
    try:
        backend = socket.create_connection((BACKEND_HOST, BACKEND_PORT))
    except Exception:
        client_sock.close(); return
    t1 = threading.Thread(target=pipe, args=(client_sock, backend))
    t2 = threading.Thread(target=pipe, args=(backend, client_sock))
    t1.start(); t2.start()
    t1.join(); t2.join()
    client_sock.close(); backend.close()

context = ssl.SSLContext(ssl.PROTOCOL_TLS_SERVER)
context.load_cert_chain(certfile=CERTFILE, keyfile=KEYFILE)

with socket.socket(socket.AF_INET, socket.SOCK_STREAM, 0) as sock:
    sock.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)
    sock.bind((LISTEN_ADDR, LISTEN_PORT))
    sock.listen(5)
    with context.wrap_socket(sock, server_side=True) as ssock:
        print('TLS proxy listening on', LISTEN_PORT)
        while True:
            try:
                client, addr = ssock.accept()
            except KeyboardInterrupt:
                break
            threading.Thread(target=handle, args=(client,)).start()
