problem=$1
submission=$2
echo $submission

filename=${submission%%.py}
echo $filename
problems_path=/judge/problems
submissions_path=/judge/submissions

compile_file=cpp${filename}.out

rm -f /tmp/$compile_file


TIME_LIMIT=5
TIMEOUT_CODE=124
SUCCESS_CODE=0
COMPILE_ERROR_CODE=2

for input in $problems_path/$problem/secret/*.in; do
    num=$(basename "$input" | cut -d. -f1)

    echo run $num
    timeout $TIME_LIMIT python $submissions_path/$submission < $input > /tmp/$num.out
    if [ $? -eq $SUCCESS_CODE ]; then
        exit 0
    fi

    if [ $? -eq $COMPILE_ERROR_CODE ]; then
        exit 2
    fi

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
