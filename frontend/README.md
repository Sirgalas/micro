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

