from random import *

N = 26

len = randint(1, N)

res = ''

for i in range(len):
    ch = randint(0, 25)
    res += chr(ch + ord('a'))

print (res)
