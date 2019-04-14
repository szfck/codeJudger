from random import *

N = 1e2

len = randint(1, N)

res = ''

for i in range(len):
    ch = randint(0, 52)
    if ch < 26:
        res += chr(ch + ord('a'))
    else:
        res += ' '

print (res)
print (len)
