def sudoku(board):
    # Your code here
    pass

if __name__=='__main__':
    board = []
    for i in range(9):
        board.append([int(x) for x in input().split()])
        
    answer = sudoku(board)
    for row in answer:
        print (' '.join(str(x) for x in row))