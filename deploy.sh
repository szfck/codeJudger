# This shell file deploys a new version to our server.

# install docker
# sudo apt-get update
# sudo apt-get install apt-transport-https ca-certificates curl software-properties-common
# curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo apt-key add -
# sudo add-apt-repository -y "deb [arch=amd64] https://download.docker.com/linux/ubuntu $(lsb_release -cs) stable"

# sudo apt-get update
# sudo apt-get install -y docker-ce
# sudo apt-get install -y make
# sudo curl -L "https://github.com/docker/compose/releases/download/1.24.0/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose

# sudo chmod +x /usr/local/bin/docker-compose

# deploy
eval "$(ssh-agent -s)" # Start ssh-agent cache
chmod 600 ~/.ssh/deploy_rsa # Allow read access to the private key
ssh-add ~/.ssh/deploy_rsa # Add the private key to SSH

echo "SSHing to CodeJudger."
ssh root@140.82.63.62 << EOF
    cd /root/codeJudger
    chown -R www-data:www-data .
    git pull origin master
    make run-prod
EOF
