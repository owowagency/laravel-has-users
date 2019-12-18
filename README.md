# Laravel: Has Users With Roles Trait

A trait for Laravel models which have many users with roles.

## Installation

Via Composer in an already running project:

``` bash
$ composer require owowagency/laravel-has-users-with-roles
$ composer update
```

## Usage

1. Implement the trait in the model which will have many users with roles.
2. *Override the `getUsersPivotClass` method to return the desired pivot model class. By default it returns `Pivot::class`.
3. *Configure the `user_model_path` config value to tell the trait where the `User` model is. By default the path is `App\Models\User`.

\* = Optional

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[MIT](https://choosealicense.com/licenses/mit/)