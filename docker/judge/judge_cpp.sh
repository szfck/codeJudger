problem=$1
submission=$2
user_id=$3
filename=${submission%%.cpp}

problems_path=/judge/problems
submissions_path=/judge/submissions/$user_id

compile_file=cpp${filename}.out

rm -f /tmp/$compile_file


echo start compile

# compile error
if ! g++ $submissions_path/$submission -o /tmp/$compile_file 2> $submissions_path/error.cpp ; then
    exit 2
fi
echo compile finished

TIME_LIMIT=5
TIMEOUT_CODE=124

for input in $problems_path/$problem/secret/*.in; do
    num=$(basename "$input" | cut -d. -f1)

    echo run $num
    timeout $TIME_LIMIT /tmp/$compile_file < $input > /tmp/$num.out

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
