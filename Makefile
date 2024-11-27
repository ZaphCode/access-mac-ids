PAGE_URL = http://localhost:8080/public
ADMIN_URL = http://localhost:8081

up:
	docker-compose up -d

down:
	docker-compose down

admin:
	open $(ADMIN_URL)

start: 
	docker-compose up -d && open $(PAGE_URL)

.DEFAULT_GOAL := start