def add(a, b):
    # Your code here
    return a + b

if __name__=='__main__':
    a, b = [int(x) for x in input().split()]
    print (add(a, b))