## Lumen-jwt-rest-full-api

### Installation (windows)
`git clone https://`

`docker-compose up --build -d`

`winpty docker exec -t -i docker-lumen_php_1 sh`

`cd .. && php composer.phar install && php artisan migrate && php artisan cache:clear`

### Postman collection

Postman collection is provided in file job.postman_collection

### Configuration

For working email sending need to configure proper mailer settings in .env file.