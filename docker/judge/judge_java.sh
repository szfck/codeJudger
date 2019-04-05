problem=$1
submission=$2
filename=${submission%%.java}

problems_path=/judge/problems
submissions_path=/judge/submissions

rm -f /tmp/Main.java
rm -f /tmp/Main

cp $submissions_path/$submission /tmp/Main.java

echo start compile

# compile error
if ! javac /tmp/Main.java; then
    exit 2
fi
echo compile finished

TIME_LIMIT=5
TIMEOUT_CODE=124

for input in $problems_path/$problem/secret/*.in; do
    num=$(basename "$input" | cut -d. -f1)

    echo run $num
    timeout $TIME_LIMIT java -cp /tmp Main < $input > /tmp/$num.out

    # time limit exceed
    if [ $? -eq $TIMEOUT_CODE ]; then
        exit 3
    fi

    # wrong answer
    if ! diff $problems_path/$problem/secret/$num.out /tmp/$num.out; then
        exit 1
    fi
    echo finish run $num
done
