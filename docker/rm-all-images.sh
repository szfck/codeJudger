while [ `expr $(docker images | wc -l)` -gt 1 ]; do
    docker rmi -f $(docker images | sed -n 2p | awk '{print $3;}') || true
done
