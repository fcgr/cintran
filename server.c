#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <time.h>
#include <errno.h>
// sockets in linux libraries
#include <unistd.h>
#include <sys/types.h>
#include <sys/socket.h>
#include <netinet/in.h>
#include <netdb.h>
#include <fcntl.h>

#define SRVPORT 54321

void jkl (int i);

int main (int argc, char **argv) {
    struct sockaddr_in srvaddr, cltaddr;
    struct timespec now, then;
    int sckt, msglen, i = 0, j, t;
    long ini_time, dt;

    // creates a socket
    if ((sckt = socket(AF_INET, SOCK_DGRAM, IPPROTO_UDP)) < 0) jkl(1);
    fcntl(sckt, F_SETFL, O_NONBLOCK); // non-blocking socket
    srvaddr.sin_family = AF_INET; // address family;
    srvaddr.sin_addr.s_addr = htonl(INADDR_ANY); // any incoming interface
    srvaddr.sin_port = htons(SRVPORT); // local port number
    if (bind(sckt, (struct sockaddr *)&srvaddr, sizeof(srvaddr)) < 0) jkl(2);

    // server loop
    printf("servidor ativo\n");
    if (clock_gettime(CLOCK_MONOTONIC, &now) != 0) jkl(3);
    printf("time res = %ld, %ld\n", then.tv_sec, then.tv_nsec);
    ini_time = now.tv_nsec;
    while (1) {
        // timing
        then = now;
        if (clock_gettime(CLOCK_MONOTONIC, &now) != 0) jkl(4);
        dt = 1000000*(now.tv_sec - then.tv_sec) + (now.tv_nsec - then.tv_nsec)/1000; // in microseconds
        printf("t(%d) = %ld s; dt = %ld us\n", i++, (now.tv_sec - ini_time), dt);
        usleep(1000000/60); // 60 Hz
    }

    return 0;
}

void jkl (int i) {
    fprintf(stderr, "Error %d: %s (errno %d)\n", i, strerror(errno), errno);
    exit(i);
}