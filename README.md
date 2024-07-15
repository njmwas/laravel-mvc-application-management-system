# Application Management System
This is an upgraded laravel framework that includes a controller for creating custom API resources for any applicaiton

## Setup
- Install Laravel 11 and above
- clone this respository as your starter kit

## How it works
- Create your models and model policies for your applications using the Laravel console
```
php artisan make:model ModelName --migration --policy
```
- Modify the model to add the columns
- Modify the policies to controll who can view, create, update or delete this resource
- The rest will be handled by the api routes and the core controller

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
