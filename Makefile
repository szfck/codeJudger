.PHONY: help

help: ## This help.
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

.DEFAULT_GOAL := help

# DOCKER TASKS
run: ## build and run the containers
	cd docker; docker-compose up -d db;
	cd docker; bash wait-for-mysql.sh;
	cd docker; docker-compose up -d app judge;

stop: ## stop running containers
	cd docker; docker-compose down;

rebuild-judge: ## run judger container on port 3000
	cd docker/judge; docker-compose up --build;

judger-judge: ## enter the bash of judger container
	docker exec -it judger-judge sh

judger-db: ## enter the bash of judger-db container
	docker exec -it judger-db bash

create-db: ## create database and tables using createDB.sql dump
	cat docker/db/createDB.sql | docker exec -i judger-db mysql -uroot -p123456

judger-app: ## enter the bash of judger-app container
	docker exec -it judger-app bash

cp: ## commit all and push to github master
	git add .; git commit; git push

lint: ## run php linter using nodejs
	docker exec judger-app bash -c "phplint '**/*.php'"

test: ## run unit tests
	docker exec judger-app bash -c "cd application/tests; phpunit --debug"

rebuild: move-images ## rebuild new images and run
	make run

move-images: ## remove images
	docker image rm docker_app
	docker image rm docker_db
	docker image rm docker_judge
