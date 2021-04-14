#ifndef SERVER_H
#define SERVER_H

#include <stdio.h>
#include <stdlib.h>
#include <iostream>
#include <fstream>
#include <unistd.h>

using namespace std;

void initServerData();
void sendPermToServer(char perm[]);

#endif
