#include<iostream>
#include<assert.h>
#include<string>
#include<vector>
using namespace std;

int main() {
    string s;
    cin >> s;
    if (s == "0") { cout << s << endl; return 0; }
    bool neg = false;
    if (s[0] == '-') neg = true, s = s.substr(1);
    reverse(s.begin(), s.end());
    if (neg) cout << "-";
    for (int i = 0; i < s.size(); i++) {
        cout << s[i];
    }
    cout << endl;
    return 0;
}
