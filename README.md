
## Description

- this project handle posts & categories many to many relationship using filment for backend dashboard
- create list apis for posts and categories using jwt
- http://127.0.0.1:8000/api/login add email and password in body
- http://127.0.0.1:8000/api/refresh add token in body
- http://127.0.0.1:8000/api/logout add bearer token 
- http://127.0.0.1:8000/api/posts add bearer token
- http://127.0.0.1:8000/api/categories add bearer token

## TO run this project

needed versions

-   php 8.1.2
-   php-intel
-   php-zip

Steps

-   clone this project
-   run `composer install`
-   run `php artisan jwt:secret`
-   run `php artisan migrate`
-   run `php artisan db:seed`
-   run `npm install`

# Laravel_Filment
