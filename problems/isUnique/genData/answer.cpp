#include<iostream>
#include<assert.h>
#include<string>
#include<vector>
using namespace std;

int main() {
    string s;
    cin >> s;
    vector<int> vis(256, 0);
    bool flag = true;
    for (int i = 0; i < (int) s.size(); i++) {
        if (++vis[s[i]] > 1) {
            flag = false;
        }
    }
    cout << (flag ? "True" : "False") << endl;
    return 0;
}
