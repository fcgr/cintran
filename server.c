#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <time.h>
#include <errno.h>
// sckts in linux libraries
#include <unistd.h>
#include <sys/types.h>
#include <sys/socket.h>
#include <netinet/in.h>
#include <netdb.h>
#include <fcntl.h>

#define MAX_CLIENTS 20
#define NDEPENDENCIES 3
#define SERVER_PORT 54321
#define CLIENT_PORT 65432

typedef union {
    struct { int id, condition; };
    struct { short left, forward, right; };
    //struct { long a, b, c, d, e, f, g, h; };
} Message;

typedef struct a Client;
typedef struct b Sign;

typedef struct a {
    Sign *ptr;
    int id;
} Client;

typedef struct b {
    Sign *children[NDEPENDENCIES], *parents[NDEPENDENCIES];
    struct sockaddr_in address;
    long last_mssg_t;
    int id, condition;
    short left, forward, right;
} Sign;


Client clients[MAX_CLIENTS];
Sign signs[MAX_CLIENTS];

void jkl (int i);

int main (int argc, char **argv) {
    struct sockaddr_in server_addr, client_addr;
    struct timespec now, then;
    int sckt, msglen, i = 0, j, t, n_clients = 3, length;
    long ini_time, dt;
    Message mssg;

    // creates a sckt
    if ((sckt = socket(AF_INET, SOCK_DGRAM, IPPROTO_UDP)) < 0) jkl(1);
    fcntl(sckt, F_SETFL, O_NONBLOCK); // non-blocking sckt
    server_addr.sin_family = AF_INET; // address family;
    server_addr.sin_addr.s_addr = htonl(INADDR_ANY); // any incoming interface
    server_addr.sin_port = htons(SERVER_PORT); // local port number
    if (bind(sckt, (struct sockaddr *)&server_addr, sizeof(server_addr)) < 0) jkl(2);

    // timing init
    printf("servidor ativo\n");
    if (clock_gettime(CLOCK_MONOTONIC, &now) != 0) jkl(3);
    ini_time = now.tv_sec;
    
    printf("size of Sign = %lu, size of Client = %lu\n", sizeof(Sign), sizeof(Client));
    // server loop
    while (1) {
        // timing
        then = now;
        if (clock_gettime(CLOCK_MONOTONIC, &now) != 0) jkl(4);
        dt = 1000000*(now.tv_sec - then.tv_sec) + (now.tv_nsec - then.tv_nsec)/1000; // in microseconds
        //printf("t(%d) = %ld s; dt = %ld us\n", i++, (now.tv_sec - ini_time), dt);

        // if msglen > sizeof(mssg), no message received is reported
        while ((length = recvfrom(sckt, &mssg, sizeof(mssg), 0, (struct sockaddr *)&client_addr, &msglen)) > 0) {
            if (length != sizeof(Message)) {
                printf("message received from IP 0x%08x, port %d of bad length\n", client_addr.sin_addr.s_addr, client_addr.sin_port);
                //break;
            }
            for (i = 0; i < n_clients; i++) {
                if (clients[i].id == mssg.id) break;
            }
            if (i == n_clients) {
                printf("message received from UNKNOWN sign %d: condition = %d\n\tIP = 0x%08x, port %d", mssg.id, mssg.condition, client_addr.sin_addr.s_addr, client_addr.sin_port);
            } else {
                printf("message received from sign %d: condition = %d\n\tIP = 0x%08x, port %d", mssg.id, mssg.condition, client_addr.sin_addr.s_addr, client_addr.sin_port);
            }
        }

        usleep(1000000/30); // 60 Hz
    }

    return 0;
}

void jkl (int i) {
    fprintf(stderr, "Error %d: %s (errno %d)\n", i, strerror(errno), errno);
    exit(i);
}