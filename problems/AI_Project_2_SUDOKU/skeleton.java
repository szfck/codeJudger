import java.io.*;
import java.util.*;

public class Main {

    static class Board {
        int[][] cells = new int[9][9];
        void print() {
            for (int i = 0; i < 9; i++) {
                System.out.print(cells[i][0]);
                for (int j = 1; j < 9; j++) {
                    System.out.print(" " + cells[i][j]);
                }
                System.out.print('\n');
            }
        }
    }

    public static void main(String[] args) throws IOException {
        BufferedReader br = new BufferedReader(new InputStreamReader(System.in));

        Board board = new Board();
        for (int i = 0; i < 9; i++) {
            StringTokenizer st = new StringTokenizer(br.readLine());
            for (int j = 0; j < 9; j++) {
                board.cells[i][j] = Integer.parseInt(st.nextToken());
            }
        }
        Board answer = sudoku(board);
        answer.print();
    }

    public static Board sudoku(Board board) {
        // Your code here

    }
}
