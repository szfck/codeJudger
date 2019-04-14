if [ "$#" -ne 2 ]; then
    echo "./genTestcase.sh {problem} {case number}"
    exit 1
fi

problem=$1
caseNum=$2

if ! cd $problem; then
    exit 1
else
    echo "in the problem $problem"
fi

if ! cd genData; then
    echo 'genData dir not exsit'
    exit 1
fi

if [ ! -f answer.cpp ]; then
    echo "File answer.cpp not found!"
    exit 1
fi

if [ ! -f gen.py ]; then
    echo "File gen.py not found!"
    exit 1
fi

if ! g++ -o answer answer.cpp; then
    echo "compile error for answer.cpp"
    exit 1
fi

for i in $( seq 1 $caseNum ); do
    input=../secret/$i.in
    output=../secret/$i.out
    echo "generate test case $input"
    if ! python gen.py > $input; then
        echo 'gen.py error'
        exit 1
    fi
    
    if ! ./answer < $input > $output; then
        echo 'answer run error'
        exit 1
    fi
done

rm -f answer
