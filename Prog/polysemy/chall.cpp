#include <iostream>
#include <unistd.h>

void print(char p_printable, float p_pause);

int main(int argc, char** argv) {
    std::string s = "I love chocolate. This morning there was no more chocolate. But you probably don't care....";
    print(s[0],2);
    print(s[1],2);
    print(s[2],2);
    print(s[3],5);
    print(s[4],5);
    print(s[5],2);
    print(s[6],4);
    print(s[7],5);
    print(s[8],4);
    print(s[9],4);
    print(s[10],7);
    print(s[11],4);
    print(s[12],2);
    print(s[13],4);
    print(s[14],4);
    print(s[15],5);
    print(s[16],2);
    print(s[17],2);
    print(s[18],2);
    print(s[19],5);
    print(s[20],2);
    print(s[21],4);
    print(s[22],4);
    print(s[23],4);
    print(s[24],7);
    print(s[25],4);
    print(s[26],2);
    print(s[27],5);
    print(s[28],4);
    print(s[29],2);
    print(s[30],5);
    print(s[31],2);
    print(s[32],2);
    print(s[33],2);
    print(s[34],4);
    print(s[35],7);
    print(s[36],4);
    print(s[37],5);
    print(s[38],4);
    print(s[39],2);
    print(s[40],2);
    print(s[41],2);
    print(s[42],2);
    print(s[43],7);
    print(s[44],4);
    print(s[45],7);
    print(s[46],4);
    print(s[47],4);
    print(s[48],4);
    print(s[49],4);
    print(s[50],7);
    print(s[51],2);
    print(s[52],4);
    print(s[53],5);
    print(s[54],2);
    print(s[55],2);
    print(s[56],5);
    print(s[57],2);
    print(s[58],2);
    print(s[59],2);
    print(s[60],4);
    print(s[61],7);
    print(s[62],4);
    print(s[63],2);
    print(s[64],2);
    print(s[65],2);
    print(s[66],2);
    print(s[67],7);
    print(s[68],4);
    print(s[69],2);
    print(s[70],4);
    print(s[71],5);
    print(s[72],4);
    print(s[73],4);
    print(s[74],4);
    print(s[75],4);
    print(s[76],7);
    print(s[77],4);
    print(s[78],2);
    print(s[79],5);
    print(s[80],2);
    print(s[81],2);
    print(s[82],2);
    print(s[83],4);
    print(s[84],7);
    print(s[85],4);
    print(s[86],2);
    print(s[87],4);
    print(s[88],4);
    print(s[89],2);
    print(s[90],7);
    std::cout << std::endl;
    return 0;
}

void print(char p_printable, float p_pause) {
    float UNIT = 0.05;
    std::cout << p_printable << std::flush;
    usleep(p_pause * UNIT * 1000000);
}