#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <time.h>
#include <errno.h>
#include <inttypes.h>
// sockets in linux libraries
#include <unistd.h>
#include <sys/types.h>
#include <sys/socket.h>
#include <netinet/in.h>
#include <netdb.h>
#include <fcntl.h>

//#define TESTING

#define MAX_CLIENTS 20
#define NDEPENDENCIES 3

#ifndef TESTING
    #define SERVER_PORT 65432
    #define CLIENT_PORT 54321
#else
    #define SERVER_PORT 54321
    #define CLIENT_PORT 65432
#endif


typedef union {
    struct { int16_t id, condition; };
    struct { int16_t left, forward, right; };
    //struct { long a, b, c, d, e, f, g, h; };
} NetMssg;

typedef struct a Client;
typedef struct b Sign;

typedef struct a {
    uint16_t ptr;
    uint16_t id;
} Client;

typedef struct b {
    long last_mssg_t;
    uint32_t s_addr;
    uint16_t id, condition;
    uint16_t left, forward, right;
    uint16_t children[NDEPENDENCIES], parents[NDEPENDENCIES];
} Sign;


Client clients[MAX_CLIENTS];
Sign signs[MAX_CLIENTS];

void jkl (int i);

int main (int argc, char **argv) {
    struct sockaddr_in server_address, client_address;
    struct timespec now, then;
    int sockt, msglen, i = 0, j, t, n_clients = 3, length;
    long ini_time, dt;
    NetMssg mssg;

    // creates a sockt
    if ((sockt = socket(AF_INET, SOCK_DGRAM, IPPROTO_UDP)) < 0) jkl(1);
    fcntl(sockt, F_SETFL, O_NONBLOCK); // non-blocking sockt
    server_address.sin_family = AF_INET; // address family;
    server_address.sin_addr.s_addr = htonl(INADDR_ANY); // any incoming interface
    server_address.sin_port = htons(SERVER_PORT); // local port number
    if (bind(sockt, (struct sockaddr *)&server_address, sizeof(server_address)) < 0) jkl(2);

    // timing init
    printf("servidor ativo\n");
    if (clock_gettime(CLOCK_MONOTONIC, &now) != 0) jkl(3);
    ini_time = now.tv_sec;
    
    printf("size of Sign = %lu, size of Client = %lu\n", sizeof(Sign), sizeof(Client));
    printf("grad's lan ip range = %d\n", 0xac1407ff - 0xac140401);

#ifndef TESTING
    // server loop
    while (1) {
        // timing
        then = now;
        if (clock_gettime(CLOCK_MONOTONIC, &now) != 0) jkl(4);
        dt = 1000000*(now.tv_sec - then.tv_sec) + (now.tv_nsec - then.tv_nsec)/1000; // in microseconds
        printf("t(%d) = %ld s; dt = %ld us\n", i++, (now.tv_sec - ini_time), dt);

        // if msglen > sizeof(mssg), no message received is reported
        while ((length = recvfrom(sockt, &mssg, sizeof(mssg), 0, (struct sockaddr *)&client_address, &msglen)) > 0) {
            if (length != sizeof(NetMssg)) {
                printf("message received from IP 0x%08x, port %d of bad length\n", ntohl(client_address.sin_addr.s_addr), ntohs(client_address.sin_port));
                //break;
            }
            for (i = 0; i < n_clients; i++) {
                if (clients[i].id == mssg.id) break;
            }
            if (i == n_clients) {
                printf("message received from UNKNOWN sign %d: condition = %d\n\tIP = 0x%08x, port %d\n", mssg.id, mssg.condition, ntohl(client_address.sin_addr.s_addr), ntohs(client_address.sin_port));
            } else {
                printf("message received from sign %d: condition = %d\n\tIP = 0x%08x, port %d\n", mssg.id, mssg.condition, ntohl(client_address.sin_addr.s_addr), ntohs(client_address.sin_port));
            }
        }

        usleep(1000000/30); // 30 Hz
    }
#else
  // message sending iteration timing test

    printf("0x%02x.%02x.%02x.%02x\n", 172, 20, 18, 255);
    client_address.sin_family = AF_INET;
    client_address.sin_port = htons(CLIENT_PORT);
    clock_gettime(CLOCK_MONOTONIC, &then);
    //for (j = 0; j < 4; j++) {
        for (i = 0xac141201; i < 0xac1412ff; i++) {
            client_address.sin_addr.s_addr = htonl(i); 
            while (sendto(sockt, &mssg, sizeof(mssg), 0, (struct sockaddr *)&client_address, sizeof(client_address)) != sizeof(mssg)) {
                if (errno == 11) {
                    printf("errno 11\n");
                    usleep(500000);
                } else jkl(5);
            }
        }
    //}
    clock_gettime(CLOCK_MONOTONIC, &now);
    dt = 1000000*(now.tv_sec - then.tv_sec) + (now.tv_nsec - then.tv_nsec)/1000;
    printf("dt = %ld us\n", dt); // in microseconds
#endif

    return 0;
}

void jkl (int i) {
    fprintf(stderr, "Error %d: %s (errno %d)\n", i, strerror(errno), errno);
    exit(i);
}


// for (i = 0xc0a80f01; i < 0xc0a80fff; i++) :: labhw && home
// for (i = 0xac140401; i < 0xac1407ff; i++) :: grad
