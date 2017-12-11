#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <time.h>
#include <errno.h>
#include <inttypes.h>
// linux libraries
#include <unistd.h>
#include <sys/types.h>
#include <dirent.h>
#include <signal.h>
// sockets in linux libraries
#include <sys/socket.h>
#include <netinet/in.h>
#include <netdb.h>
#include <fcntl.h>

#define LOCAL_PORT 80
#define MAXPENDING 20
#define MAXCONNECTIONS 30
#define MAX_SIGNS 30
#define BUFFER_SIZE 1500

void jkl (int i);
void signal_handler (int signal_id);
int16_t find_sign (int sign_id);

typedef struct {
    time_t last_seen;
    int16_t id;
} SignPtr;

typedef struct {
    int16_t id;
    int16_t child[3], parent[3];
    char direction[3], here, incident;
} Sign;

Sign sign[MAX_SIGNS];
SignPtr sign_ptr[MAX_SIGNS];
int listen_socket, connected_socket[MAXCONNECTIONS], num_connected = 0, nsigns = 0;
char readdir_path[50] = "/var/www/html/out_php/";
char writedir_path[50] = "/var/www/html/in_php/";
char answer_msg[] = "HTTP/1.1 200 OK\015\012Connection: close\015\012Last-Modified: Fri Dec  8 17:15:51 UTC 2017\015\012Content-Length: 3\015\012Content-Type: text/html\015\012\015\012000\n";

int main (int argc, char **argv) {
    struct sockaddr_in local_address, remote_address;
    int msg_length, i, j, k, answer_length;
    socklen_t address_length = sizeof(struct sockaddr_in);
    char msg_buffer[BUFFER_SIZE];
    unsigned int block_flag, issue_number = 0;
    time_t initial_time = time(NULL);
    FILE *file = NULL;
    DIR *read_directory;
    struct dirent *listed_file = NULL;
    char file_buffer[BUFFER_SIZE];
    size_t nread, readdirpath_length;
    int16_t sign_id;
    char incident_type, traffic_condition;
    char *answp = NULL;

    signal(SIGINT, signal_handler);
    if ((listen_socket = socket(AF_INET, SOCK_STREAM, IPPROTO_TCP)) < 0) jkl(-1);
    fcntl(listen_socket, F_SETFL, O_NONBLOCK);
    local_address.sin_family = AF_INET;
    local_address.sin_port = htons(LOCAL_PORT);
    local_address.sin_addr.s_addr = htonl(INADDR_ANY);
    if (bind(listen_socket, (struct sockaddr *)&local_address, sizeof(local_address)) < 0) jkl(-2);
    if (listen(listen_socket, MAXPENDING) < 0) jkl(-3);
    answer_length = strlen(answer_msg);
    answp = &answer_msg[answer_length - 4];
    readdirpath_length = strlen(readdir_path);
    printf("server online\n");
    
    while (1) {
        //address_length = sizeof(connected_socket[0]);
        connected_socket[num_connected] = accept(listen_socket, (struct sockaddr *)&remote_address, &address_length);
        if (connected_socket[num_connected] >= 0) {
            printf("new connection established\n");
            fcntl(connected_socket[num_connected], F_SETFL, O_NONBLOCK);
            num_connected++;
        }
        for (i = 0; i < num_connected; i++) {
            msg_length = recv(connected_socket[i], msg_buffer, BUFFER_SIZE, 0);
            if (msg_length < 0) continue;
            if (msg_length == 0) {
                printf("connection closed\n");
                close(connected_socket[i]);
                connected_socket[i--] = connected_socket[--num_connected];
                continue;
            }
            printf("new message received\n");
            msg_buffer[msg_length] = '\0';
            fwrite(msg_buffer, sizeof(char), msg_length, stdout);
            if (sscanf(msg_buffer, " POST %"SCNd16" %c", &sign_id, &traffic_condition) == EOF) {
                close(connected_socket[i]);
                connected_socket[i--] = connected_socket[--num_connected];
                jkl(4); continue;
            }
            //block_flag = fcntl(connected_socket[i], F_GETFL) & (~O_NONBLOCK);
            //fcntl(connected_socket[i], F_SETFL, block_flag);
            for (j = 0; j < nsigns && sign_ptr[j].id != sign_id; j++);
            if (j >= nsigns) {
                printf("no sign found of the id provided by message\n");
                close(connected_socket[i]);
                connected_socket[i--] = connected_socket[--num_connected];
                continue;
            }
            for (k = 0; k < 3; k++) {
                if (sign[j].parent[k] >= 0 && sign[sign[j].parent[k]].here >= 0)
                    answer_msg[answer_length + k - 4] = sign[j].direction[k] = sign[sign[j].parent[k]].here;
                else
                    answer_msg[answer_length + k - 4] = '9';
            }
            sign[j].here = (traffic_condition > sign[j].incident) ? traffic_condition : sign[j].incident;
            sign_ptr[j].last_seen = time(NULL);
            if (send(connected_socket[i], answer_msg, answer_length, 0) != answer_length) jkl(6);
            //fcntl(connected_socket[i], F_SETFL, O_NONBLOCK);
            printf("message sent: %c%c%c\n", answp[0], answp[1], answp[2]);
            close(connected_socket[i]);
            connected_socket[i--] = connected_socket[--num_connected];
            printf("connection closed\n");
        }
        readdir_path[readdirpath_length] = '\0';
        if (!(read_directory = opendir(readdir_path))) jkl(7);
        //readdir(read_directory);
        //readdir(read_directory);
        while (listed_file = readdir(read_directory)) {
            if (listed_file->d_name[0] == '.') continue;
            strcpy(&readdir_path[readdirpath_length], listed_file->d_name);
            printf("spotted file %s\n", readdir_path);
            if (strstr(listed_file->d_name, ".cad") != NULL) {
                if (!(file = fopen(readdir_path, "r"))) {
                    remove(readdir_path);
                    jkl(8); continue;
                }
                memset(&sign[nsigns], 0xff, sizeof(Sign));
                if (fscanf(file, " %"SCNd16"|%"SCNd16";%"SCNd16";%"SCNd16"|%"SCNd16";%"SCNd16";%"SCNd16"", &sign[nsigns].id, &sign[nsigns].parent[0], &sign[nsigns].parent[1], &sign[nsigns].parent[2], &sign[nsigns].child[0], &sign[nsigns].child[1], &sign[nsigns].child[2]) == EOF) {
                    fclose(file);
                    remove(readdir_path);
                    jkl(9); continue;
                }
                sign_ptr[nsigns].id = sign[nsigns].id;
                for (i = 0; i < 3; i++) {
                    if (sign[nsigns].parent[i] == 0) {
                        sign[nsigns].parent[i] = -1;
                    } else {
                        sign[nsigns].parent[i] = find_sign(sign[nsigns].parent[i]);
                        sign[nsigns].parent[i] >= 0 ? (sign[sign[nsigns].parent[i]].child[i] = nsigns) : jkl(14);
                    }
                    if (sign[nsigns].child[i] == 0) {
                        sign[nsigns].child[i] = -1;
                    } else {
                        sign[nsigns].child[i] = find_sign(sign[nsigns].child[i]);
                        sign[nsigns].child[i] >= 0 ? (sign[sign[nsigns].child[i]].parent[i] = nsigns) : jkl(15);
                    }
                }
                sign_ptr[nsigns].last_seen = time(NULL);
                nsigns++;
                fclose(file);
                remove(readdir_path);
                printf("read file %s\n", readdir_path);
            } else if (strstr(listed_file->d_name, ".inc") != NULL) {
                if (!(file = fopen(readdir_path, "r"))) {
                    remove(readdir_path);
                    jkl(10); continue;
                }
                if (fscanf(file, " %"SCNd16"|%c", &sign_id, &incident_type) == EOF) {
                    fclose(file);
                    remove(readdir_path);
                    jkl(11); continue;
                }
                for (i =0; i < nsigns && sign_ptr[i].id != sign_id; i++);
                if (i >= nsigns) {
                    printf("sign of the reported incident not found\n");
                    fclose(file);
                    remove(readdir_path);
                    continue;
                }
                sign[i].incident = incident_type;
                if (sign[i].here < incident_type)
                    sign[i].here = incident_type;
                fclose(file);
                remove(readdir_path);
                printf("read file %s\n", readdir_path);
            }
        }
        closedir(read_directory);

        for (i = 0; i < nsigns; i++) {
            if (time(NULL) - sign_ptr[i].last_seen < 5*60) continue;
            printf("long time no see sign\n");
            sprintf(writedir_path, "/var/www/html/in_php/%04x.prob", issue_number++);
            if (!(file = fopen(writedir_path, "w"))) { jkl(17); continue; }
            fprintf(file, "%d|1", sign_ptr[i].id);
            fclose(file);
            sign_ptr[i].last_seen = time(NULL);
        }
        usleep(200000);
    }
    close(listen_socket);
    for (i = 0; i < num_connected; i++)
        close(connected_socket[i]);

    return 0;
}

void signal_handler (int signal_id) {
    int i;
    close(listen_socket);
    for (i = 0; i < num_connected; i++)
        close(connected_socket[i]);
    printf("closed all connections\n");
    exit(1);
}

void jkl (int i) {
    fprintf(stderr, "ERROR: %d: %s (errno %d)\n", i, strerror(errno), errno);
    if (i < 0) exit(i);
}

int16_t find_sign (int sign_id) {
    int i;
    for (i = 0; i < nsigns && sign[i].id != sign_id; i++);
    return (i < nsigns) ? i : -1;
}

    
