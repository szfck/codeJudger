.PHONY: help

help: ## This help.
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

.DEFAULT_GOAL := help

init:
	mkdir -p submissions && chmod 777 submissions
	mkdir -p tmp && chmod 777 tmp

# DOCKER TASKS
prod: ## run in pord
	make init
	cat .env.prod > .env
	make start-db
	docker-compose up -d app judge;

run: ## run in dev
	make init
	make start-db
	docker-compose up app judge;

stop: ## stop running containers
	docker-compose down;

# Database
start-db: ## start db
	docker-compose up -d db; 
	bash docker/wait-for-mysql.sh;
	# make create-db;

stop-db : ## stop db
	docker-compose down db;

container-db: ## enter the bash of db container
	docker exec -it judger-db bash

create-db: ## create database and tables using createDB.sql dump
	cat docker/db/init/createDB.sql | docker exec -i judger-db mysql -uroot -p123456

# PHP Web App
start-app: start-db ## start app
	docker-compose up app;

stop-app: ## stop app
	docker-compose down app;

container-app: ## enter the bash of app container
	docker exec -it judger-app bash

# Judge
start-judge-prod: start-db ## start judge in prodd
	docker-compose up -d judge;

start-judge-dev: start-db ## start judge in dev 
	docker-compose up judge;

stop-judge: # stop judge
	docker-compose down judge;

container-judge: ## enter the bash of judge container
	docker exec -it judger-judge sh

# rebuild-judge: ## run judger container on port 3000
# 	docker; docker-compose up --build judge;

# cp: ## commit all and push to github master
# 	git add .; git commit; git push

lint: ## run php linter using nodejs
	docker exec judger-app bash -c "phplint 'application/controllers/*.php'"
	docker exec judger-app bash -c "phplint 'application/helpers/*.php'"
	docker exec judger-app bash -c "phplint 'application/views/**/*.php'"
	docker exec judger-app bash -c "phplint 'application/models/*.php'"
	docker exec judger-app bash -c "phplint 'application/tests/controllers/*.php'"
	docker exec judger-app bash -c "phplint 'application/tests/models/*.php'"
	docker exec judger-app bash -c "phplint 'application/tests/helpers/*.php'"
	docker exec judger-app bash -c "phplint 'application/tests/mocks/*.php'"

test: ## run unit tests
	docker exec judger-app bash -c "cd application/tests; phpunit --debug"

# rebuild: stop move-images ## rebuild new images and run
# 	make run-dev

rm-images: ## remove images
	docker image rm docker_app
	docker image rm docker_db
	docker image rm docker_judge

clean: ## clear tmp dir and files
	rm -rf submissions
	rm -rf tmp
	make create-db
