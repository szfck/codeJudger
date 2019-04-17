#include<iostream>
#include<assert.h>
#include<string>
using namespace std;

int main() {
    string s;
    getline(cin, s);
    int len;
    cin >> len;
    string res = "";
    assert (len == s.size());
    for (int i = 0; i < len; i++) {
        if (s[i] == ' ') res += "%%20";
        else res += s[i];
    }
    cout << res << endl;

    return 0;
}
