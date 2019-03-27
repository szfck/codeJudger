problem=$1
submission=$2
filename=${submission%%.cpp}

problems_path=/judge/problems
submissions_path=/judge/submissions

compile_file=cpp${filename}.out

rm -f /tmp/$compile_file

g++ $submissions_path/$submission -o /tmp/$compile_file

for input in $problems_path/$problem/secret/*.in; do
    num=$(basename "$input" | cut -d. -f1)
    /tmp/$compile_file < $input > /tmp/$num.out

    if ! diff $problems_path/$problem/secret/$num.out /tmp/$num.out; then
        exit 1
    fi
done
