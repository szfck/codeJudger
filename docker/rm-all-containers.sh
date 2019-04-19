while [ `expr $(docker ps -a | wc -l)` -gt 1 ]; do
    docker rm -f $(docker ps -a | sed -n 2p | awk '{print $1;}') || true
done
