#include "server.h"
#include <random>
#include <string>

std::string random_string( size_t length );

int main()
{

  std::string filename = random_string(13);

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

  // writing permissions to own file
  file.open("/tmp/"+filename+".txt");
  file << perm;
  file.close();
  cout << "[+] Permissions were saved to '/tmp/" << filename << ".txt'" << endl;

  // sending permissions to the server for it to verify integrity
  sendPermToServer(perm);

  return 0;
}

std::string random_string(std::string::size_type length)
{
    static auto& chrs = "0123456789"
        "abcdefghijklmnopqrstuvwxyz"
        "ABCDEFGHIJKLMNOPQRSTUVWXYZ";

    thread_local static std::mt19937 rg{std::random_device{}()};
    thread_local static std::uniform_int_distribution<std::string::size_type> pick(0, sizeof(chrs) - 2);

    std::string s;

    s.reserve(length);

    while(length--)
        s += chrs[pick(rg)];

    return s;
}
