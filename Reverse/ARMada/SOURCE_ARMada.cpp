#include <string>
#include <vector>
#include <iostream>
#include <cstring>

#define TCHAR char
#define DWORD long
#define BYTE unsigned char

std::basic_string<TCHAR> yolo(std::vector<BYTE> inputBuffer);

static TCHAR encodeLookup[] = "\x01\x16\x35\x05\x2a\x21\x08\x28\x69\x2c\x09\x11\x33\x03\x10\x31\x13\x70\x75\x2d\x2f\x1a\x72\x0b\x2e\x27\x3b\x7b\x73\x37\x24\x06\x20\x12\x3a\x14\x1b\x76\x23\x30\x77\x17\x25\x0f\x0c\x36\x6d\x0e\x71\x00\x34\x38\x29\x04\x2b\x0a\x18\x15\x74\x26\x0d\x32\x7a\x07";

std::basic_string<TCHAR> yolo(std::vector<BYTE> inputBuffer){

	std::basic_string<TCHAR> encodedString;
	encodedString.reserve(((inputBuffer.size()/3) + (inputBuffer.size() % 3 > 0)) * 4);
	DWORD temp;
	std::vector<BYTE>::iterator cursor = inputBuffer.begin();
	
	for(size_t idx = 0; idx < inputBuffer.size()/3; idx++){
		temp  = (*cursor++) << 16;
		temp += (*cursor++) << 8;
		temp += (*cursor++);
		encodedString.append(1,encodeLookup[(temp & 0x00FC0000) >> 18] ^ 0x42);
		encodedString.append(1,encodeLookup[(temp & 0x0003F000) >> 12] ^ 0x42);
		encodedString.append(1,encodeLookup[(temp & 0x00000FC0) >> 6 ] ^ 0x42);
		encodedString.append(1,encodeLookup[(temp & 0x0000003F)      ] ^ 0x42);
	}
	
	switch(inputBuffer.size() % 3){
	case 1:
		temp  = (*cursor++) << 16;
		encodedString.append(1,encodeLookup[(temp & 0x00FC0000) >> 18] ^ 0x42);
		encodedString.append(1,encodeLookup[(temp & 0x0003F000) >> 12] ^ 0x42);
		encodedString.append(2,0x7f ^ 0x42);
		break;
	case 2:
		temp  = (*cursor++) << 16;
		temp += (*cursor++) << 8;
		encodedString.append(1,encodeLookup[(temp & 0x00FC0000) >> 18] ^ 0x42);
		encodedString.append(1,encodeLookup[(temp & 0x0003F000) >> 12] ^ 0x42);
		encodedString.append(1,encodeLookup[(temp & 0x00000FC0) >> 6 ] ^ 0x42);
		encodedString.append(1,0x7e ^ 0x43);
		break;
	}
	return encodedString;
}

int main(){
	char* cstring = new char[64];
	std::cout << "Entrez un input : ";
	std::cin.getline(cstring, 65, '\n');

	std::vector<BYTE> superVect = std::vector<BYTE>((BYTE*)cstring, (BYTE*)cstring + strlen(cstring));
	std::basic_string<TCHAR> encoded = yolo(superVect);
	
	std::cout << "Encoded : " << encoded << std::endl;
	return 0;
}
