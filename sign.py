#import http
import http.client
import time, struct, random ,sys
def sendMsg(conn, id, msg):
    t = 0;
    snd = str(id) +  " " + str(msg)
    #while(t!=200):
    try:
        conn.request("POST",url = snd)
        print("Enviou: " + snd)
        #t = (conn.getresponse()).status
    except ConnectionRefusedError:
        print("Connection refused")
    except http.client.CannotSendRequest:
        print("CannotSendRequest")
    except Error as e:
        print("Unexpected Error: ", e)

def recvMsg(conn, id):
    #conn.request("GET", url = "", body = str(id))
    data = (conn.getresponse()).read()
    decData = data.decode("utf8")
    return decData[0],decData[1],decData[2]

if __name__ == '__main__':  
    placa1Id = 2525
    placa1Status = struct.pack('<I', random.randrange(3))[0] #Gera estado aleatório
    placa2Id = 2526
    placa2Status = 0x03
    conn1 = http.client.HTTPConnection("52.67.227.118")
    sendMsg(conn1, placa1Id, placa1Status)
    print (recvMsg(conn1, placa2Id))
    conn1.close()
    time.sleep(3)
    conn2 = http.client.HTTPConnection("52.67.227.118")
    sendMsg(conn2, placa2Id, placa2Status)
    l, f, r = recvMsg(conn2, placa2Id)
    conn2.close()
    print("Recebeu: ",l, f, r)
    #print(str(l),str(f),str(r))
    if str(l) == str(placa1Status):
        print("Teste OK")
    else:
        print("Teste Falho")