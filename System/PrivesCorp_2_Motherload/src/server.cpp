#include "server.h"

void initServerData() {
  setreuid(geteuid(), geteuid());
}

void sendPermToServer(char perm[]) {
  cout << "\n[+] Trying to upload the file to server for verification..." << endl;
  sleep(2);
  cout << "[-] Timeout : Server could not be reached, please try again later, or contact support" << endl;
}
