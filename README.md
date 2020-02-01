clone project 

go to root project
 
then type this commands : 

* build php image
```
docker-compose build
```
* mount images
```
docker-compose up -d
```
* go into php image : 
```
docker exec -it php bash
```
* install project, migrate database and install assets
```
composer install
php bin/console doctrine:migrations:migrate
php bin/console assets:install -- public
```

Finally launch app on localhost:3200/api


* in case of problems with swagger,delete migrations file and redo : 
```

php bin/console make:migration
doctrine:migrations:migrate
```


