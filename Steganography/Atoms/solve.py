#!/usr/bin/env python3
import re

cipher = "MtMdDsFmMdHsMdMdUuo"
convert = {
    'Fm': 100,
    'Md': 101,
    'Hs': 108,
    'Mt': 109,
    'Ds': 110,
    'Uup': 115,
    'Uuo': 118
}

for found in re.findall('[A-Z][a-z]*', cipher):
    print(chr(convert[found]), end="")
print()