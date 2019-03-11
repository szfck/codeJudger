.PHONY: help

help: ## This help.
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

.DEFAULT_GOAL := help

# DOCKER TASKS
run: ## build and run the containers
	cd docker; docker-compose up -d;

stop: ## stop running containers
	cd docker; docker-compose down;

judger-db: ## enter the bash of judger-db container
	docker exec -it judger-db bash

create-db: ## create database and tables using createDB.sql dump
	cat createDB.sql | docker exec -i judger-db mysql -uroot -p123456

judger-app: ## enter the bash of judger-app container
	docker exec -it judger-app bash

cp: ## commit all and push to github master
	git add .; git commit; git push

lint: ## run php linter using nodejs
	npm i -g phplint;  phplint '**/*.php'

test: ## run unit tests
	docker exec judger-app bash -c "cd application/tests; phpunit"
