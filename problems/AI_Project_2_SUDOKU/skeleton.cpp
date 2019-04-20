#include<bits/stdc++.h>
using namespace std;

typedef vector<int> VI;
typedef vector<VI> VVI;

VVI sudoku(VVI board) {
    // Your code here
}

int main() {
    VVI board(9, VI(9));
    for (int i = 0; i < 9; i++) {
        for (int j = 0; j < 9; j++) {
            cin >> board[i][j];
        }
    }
    VVI answer = sudoku(board);
    for (int i = 0; i < 9; i++) {
        cout << answer[i][0];
        for (int j = 1; j < 9; j++) {
            cout << " " << answer[i][j];
        }
        cout << endl;
    }
    return 0;
}
