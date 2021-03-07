#include "server.h"

int main()
{

  // recover server data
  initServerData();

  FILE *fp;
  char perm[256];
  ofstream file;

  fp = popen("ls -ld /home/bob/.financial.txt", "r");
  
  int i = 0;
  while (fgets(perm, sizeof(perm), fp) != NULL) {
    // euh
  }
  pclose(fp);

  // writing permissions to perm.txt
  file.open("/home/bob/perms.txt");
  file << perm;
  file.close();
  cout << "[+] Permissions were saved to 'perms.txt'" << endl;

  // sending permissions to the server for it to verify integrity
  sendPermToServer(perm);

  return 0;
}
