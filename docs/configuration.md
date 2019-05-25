# Configuration

- [Introduction](#introduction)
- [Configuration](#configuration)
    - [Database Migrations](#database-preparation)
- [Generating Tokens](#generating-tokens)
    - [Hashing Tokens](#hashing-tokens)
- [Protecting Routes](#protecting-routes)
- [Passing Tokens In Requests](#passing-tokens-in-requests)

### Introduction
Laravel Abstract provides a very quick interface for rapidly prototyping apps by offering a configuration based RESTful API.

In the simplest configuration, the configuration for everything lies in 2 places 
  1. The model itself
  2. The `LaravelAbstract` class

#### Configuring the AbstractRouteServiceProvider

Publish the vendor files. Inside the newly published `AbstractRouteServiceProvider` file you'll want to add your models to the `ROUTE_BINDINGS` array. Should looks something like

```
// To set the middleware that abstract routes use
LaravelAbstract::bind()->middleware(['web', 'auth']);
```
```
// To bypass the Laravel Policies (useful for development or debugging)
LaravelAbstract::bind()->bypass(true);
```
```
// To register the models to the project
LaravelAbstract::bind()->route([
    'users' => User::class,
]);
// To get a single model class
LaravelAbstract::bind()->route('users');
```
```
// Do you even want to enable the routes bro?
LaravelAbstract::bind()->useRoutes(false);
```
```
// How should we "resolve" the model key to the model class.
LaravelAbstract::bind()->resolveUsing(function ($modelKey) {
    $class = LaravelAbstract::bind()->route($modelKey);
    
    $model = new $class;
    
    throw_if(!$model instanceof AbstractEloquentModel, ModelNotInstanceOfAbstractEloquentModel::class);
    
    return $model;
});

```
#### Configuring your models
You'll need to extend `Kregel\LaravelAbstrac\AbstractEloquentModel` to enable the route/model binding 

Under the hood, part of what makes this package so powerful is that it uses [Spatie's Query Builder package](https://github.com/spatie/laravel-query-builder) on the `index` and `show` routes.

In order to make interfacing with the query builder as hands off as possible you can define `filter`, `include`, `sort`, and `fields` from the model itself using the following consts:

```php
public const ALLOWED_FILTERS = [];
public const ALLOWED_RELATIONSHIPS = [];
public const ALLOWED_SORTS = [];
public const ALLOWED_FIELDS = [];
```

Then for model creation and updating, you can specify model validation rules so the data posted, patched, or put to your api will be :ok_hand:
```php
public const VALIDATION_CREATE_RULES = [
    'name' => 'required'
];
public const VALIDATION_UPDATE_RULES = [];
```

Lastly, from the model const configuration bits there's a searchable fields array. Where you can list the fields that will be included in your searchable result. (We'll get into how to use this in an http query later)
```php
public const SEARCHABLE_FIELDS = [
   'name'
];
```

#### Configuring model access
You're able to limit access to the routes via the baked in Laravel policies. You'll just have to ensure to add an extra method for the `index` method along with the rest of the restful methods.

If you'd like to just bypass all the Laravel policies for the routes you can do that by adding the `LaravelAbstract::bind()->bypass(true)` to the abstract service provider.

The policy should have (at the very least) these method stubs
```php
abstract public function view(User $user, User $model);

abstract public function index(User $user);

abstract public function create(User $user);

abstract public function update(User $user, User $model);

abstract public function delete(User $user, User $model);
```