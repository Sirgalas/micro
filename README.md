# frontend

###пересобрать контейнер
```
docker-compose up -d
```

запустить npm скрипт из докера
```
docker-compose exec frontend-nodejs npm install
```

### собрать проект
```
docker-compose exec frontend-nodejs npm run build
```

# backend
###развернуть  приложение 
```
docker-compose exec api-php-cli composer install
```

#docker 
### остановить все контейнеры
```
docker stop $(docker ps -a -q)
```
### удалить остановленые контейнеры 
```
docker stop $(docker ps -a -q)
```
