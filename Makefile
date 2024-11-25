PAGE_URL = http://localhost:8080

up:
	docker-compose up -d

down:
	docker-compose down

start: 
	docker-compose up -d && open $(PAGE_URL)

.DEFAULT_GOAL := start