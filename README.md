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

 **[ModelsProvider](https://github.com/Jnsasv/Crudable-Laravel/blob/master/app/Providers/ModelsProvider.php)**
 **[CrudController](https://github.com/Jnsasv/Crudable-Laravel/blob/master/app/Http/Controllers/CrudController.php)**
 **[Crudable](https://github.com/Jnsasv/Crudable-Laravel/blob/master/app/Models/Crudable.php)**
**[StoreRequest](https://github.com/Jnsasv/Crudable-Laravel/blob/master/app/Http/Requests/StoreRequest.php)**
**[UpdateRequest](https://github.com/Jnsasv/Crudable-Laravel/blob/master/app/Http/Requests/UpdateRequest.php)**

### Resource
 **[Navigation](https://github.com/Jnsasv/Crudable-Laravel/blob/master/resources/views/layouts/navigation.blade.php)**
 **[Components](https://github.com/Jnsasv/Crudable-Laravel/tree/master/resources/views/components)**
 **[Views](https://github.com/Jnsasv/Crudable-Laravel/tree/master/resources/views/crud)**
 **[Scripts](https://github.com/Jnsasv/Crudable-Laravel/blob/master/resources/js/crud.js)**

### Database
 **[DataBaseSeeder](https://github.com/Jnsasv/Crudable-Laravel/blob/master/database/seeders/DatabaseSeeder.php)**
 **[RoleSeeder](https://github.com/Jnsasv/Crudable-Laravel/blob/master/database/seeders/RoleSeeder.php)**
 **[StatusSeeder](https://github.com/Jnsasv/Crudable-Laravel/blob/master/database/seeders/StatusSeeder.php)**

### Routes
 **[api](https://github.com/Jnsasv/Crudable-Laravel/blob/master/routes/api.php)**
 **[web](https://github.com/Jnsasv/Crudable-Laravel/blob/master/routes/web.php)**
 **[crud](https://github.com/Jnsasv/Crudable-Laravel/blob/master/routes/crud.php)**

### Auth
#### Passport
 auth things was taked from the example code used on  **[codecheef.org](https://www.codecheef.org/article/laravel-9-rest-api-authentication-with-passport-example)** and has been complemented with 4 digits registered user code on **[ApiAuthController](https://github.com/Jnsasv/Crudable-Laravel/blob/master/app/Http/Controllers/ApiAuthController.php)**

## how to use

1.  Create a migration to add the model to the db.

2.  Create a class in Crudables folder or in Models folder that extends from  **[Crudable](https://github.com/Jnsasv/Crudable-Laravel/blob/master/app/Models/Crudable.php)** and has namespace inside Models.

3. override to the class  at least `$modelname`, `$actions`, `$model_display_name`, `$display_names`, `$editable_fields`, `$creatable_fields`, `$field_types`, `$withs`, `$view_bag`, `$create_mode`, `$update_rules`, `$store_rules` properties.

4. if you need extra logic before or after create,update or delete records override the class methods `beforeStore`, `afterStore`, `beforeUpdate`, `afterUpdate`, `beforeDestroy`, `afterDestroy`.

5. if you need extra script logic to add other functions override 
`$xtraScripts` property and `headerXtraButtons`, `tableXtraButtons` methods.

6. 

## License
This project is a laravel implementation so it no need other license.
The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
