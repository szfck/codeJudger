problem=$1
submission=$2
echo $submission

filename=${submission%%.py}
echo $filename
problems_path=/judge/problems
submissions_path=/judge/submissions

TIME_LIMIT=5
TIMEOUT_CODE=124

for input in $problems_path/$problem/secret/*.in; do
    num=$(basename "$input" | cut -d. -f1)

    echo run $num
    echo begin testing
    timeout $TIME_LIMIT python $submissions_path/$submission < $input 2> /tmp/err.txt 1> /tmp/$num.out

    #cat /tmp/err.txt
    if [ "$(cat /tmp/err.txt)" ]; then
        exit 2
    fi

    echo end testing
    echo exitcode = $?

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
