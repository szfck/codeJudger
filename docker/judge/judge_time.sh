run_cmd=$1
input=$2
std_output=$3
err_output=$4
time_output=$5
echo $(echo "(" $( TIMEFORMAT="%3U + %3S"; { time $run_cmd < $input 1> $std_output 2> $err_output ; } 2>&1) ")" | bc -l) > $time_output
