import base64

STANDARD_ALPHABET = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/'
CUSTOM_ALPHABET = 'CTwGhcJj+nKSqARsQ27omX0Iley91ufDbPxVY4ar5UgMNt/L3BvzkFiHZW6dOp8E'

def custom64Decode(input):
    DECODE_TRANS = str.maketrans(CUSTOM_ALPHABET, STANDARD_ALPHABET)
    newStr =  input.translate(DECODE_TRANS) + '='
    return base64.b64decode(newStr)

stringg = str(input("Entre un truc à décoder : "))
print(custom64Decode(stringg))