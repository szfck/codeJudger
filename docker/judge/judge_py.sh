problem=$1
submission=$2
user_id=$3
echo $submission

filename=${submission%%.py}
echo $filename
problems_path=/judge/problems
submissions_path=/judge/submissions/$user_id

TIME_LIMIT=5
TIMEOUT_CODE=124

for input in $problems_path/$problem/secret/*.in; do
    num=$(basename "$input" | cut -d. -f1)

    echo run $num
    echo begin testing
    timeout $TIME_LIMIT python $submissions_path/$submission < $input 2> $submissions_path/error 1> $submissions_path/output
    
    if [ "$(cat $submissions_path/error)" ]; then
        exit 2
    fi

    echo end testing
    echo exitcode = $?

    # time limit exceed
    if [ $? -eq $TIMEOUT_CODE ]; then
        exit 3
    fi

    # wrong answer
    cp $problems_path/$problem/secret/$num.out $submissions_path/expected_output
    if ! diff $submissions_path/expected_output $submissions_path/output; then
        exit 1
    fi
    echo finish run $num
done
