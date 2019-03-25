while ! docker exec judger-db mysqladmin ping --silent >& /dev/null ; do
    echo "Waiting for database connection..."
    sleep 2
done
