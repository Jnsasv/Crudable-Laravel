# Crudable-Laravel

laravel project base with a generic crud with passport and api response 

## Installation
#### Install composer dependencies
```bash
composer install
```
#### Install and build npm dependencies
```bash
npm install
npm run dev | prod
```
#### Run migrations and seeds, install passport and generate key
```bash
php artisan migrate
php artisan db:seed
php artisan passport:install
php artisan key:generate
```

## Interesting things to see 
### App
 **[CrudController](https://github.com/Jnsasv/Crudable-Laravel/blob/master/app/Http/Controllers/CrudController.php)**
 **[Crudable](https://github.com/Jnsasv/Crudable-Laravel/blob/master/app/Models/Crudable.php)**
**[StoreRequest](https://github.com/Jnsasv/Crudable-Laravel/blob/master/app/Http/Requests/StoreRequest.php)**
**[UpdateRequest](https://github.com/Jnsasv/Crudable-Laravel/blob/master/app/Http/Requests/UpdateRequest.php)**

### Resource
 **[Navigation](https://github.com/Jnsasv/Crudable-Laravel/blob/master/resources/views/layouts/navigation.blade.php)**
 **[Components](https://github.com/Jnsasv/Crudable-Laravel/tree/master/resources/views/components)**
 **[Views](https://github.com/Jnsasv/Crudable-Laravel/tree/master/resources/views/crud)**
 **[Scripts](https://github.com/Jnsasv/Crudable-Laravel/blob/master/resources/js/crud.js)**


## License
This project is a laravel implementation so it no need other license.
The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
