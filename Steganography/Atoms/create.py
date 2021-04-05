#!/usr/bin/env python3

flag = "mendeleev"
convert = {
    100: "Fm",
    101: "Md",
    108: "Hs",
    109: "Mt",
    110: "Ds",
    115: "Uup",
    118: "Uuo"
}

for c in map(ord, list(flag)):
    print(convert[c], end="")
print()