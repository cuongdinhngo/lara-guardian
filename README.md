# Laravel Guardian

Laravel Guardian makes it easy to perform permission

1-Install `cuongnd88/lara-repository` using Composer.

```php
$ composer require cuongnd88/lara-guardian
```

2-Add the following service provider in `config/app.php`

```php
<?php
// config/app.php
return [
    // ...
    'providers' => [
        // ...
        Cuongnd88\LaraGuardian\LaraGuardianServiceProvider::class,
    ]
    // ...
];
```

3-Run `make:guardian` command

```php

php artisan vendor:publish --provider="Cuongnd88\LaraQueryKit\LaraQueryKitServiceProvider"

php artisan make:guardian

```

_`App/Traits` provides `QueryKit` trait to empower Laravel models._

_`App/Guardian/Traits` has a trait to support Laravel Guardian._

_`App/Http/Middlewares/GuardianMiddleware.php` is to check user's permissions._

_`App/Models` provides 5 models such as Action, Role, Group, Permission, Role._

_`database/migrations` has 5 tables: actions, roles, groups, permissions, roles._


## Sample Usage


Based on route's name, Lara Guardian checks user's permission. You must follow the rule in naming a route: `$page.$action`

```php
Route::group(['middleware' => ['guardian']], function(){
    Route::get('/user', function(){
        dump("Congratulation. You have the right permission");
    })->name('user.read');
});
```

You have to assign the `guard` middleware in your `app/Http/Kernel.php` file.

```php
    protected $routeMiddleware = [
    	. . . .
        'guardian' => \App\Http\Middleware\GuardianMiddleware::class,
    ];

```

There is the relationship of Guardian's models

![Guardian models](ERD-Laravel-Guardian.png.png)

`MEMO`: the `alias` of `actions, pages` tables is used to name a route, therefore you need to enter `lower-case` letters, `dash` symbol instead of space.


Please add `App\Guardian\Traits\HasGuardian.php` into the model

```php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Guardian\Traits\HasGuardian;

class User extends Authenticatable
{
    use Notifiable;
    use HasGuardian;
}
```


The `HasGuardian` trait provides:

_`joinGroup($groupId)` : user joins a group._

```php
    public function joinGroup(Request $request)
    {
        $user = \App\Models\User::find(10);
        $user->joinGroup(2);
    }
```

_`joinMultiGroups($groups)` : user joins multi groups._

```php
    public function joinManyGroups(Request $request)
    {
        $user = \App\Models\User::find(10);
        $user->joinMultiGroups([
            ['group_id' => 1],
            ['group_id' => 3],
        ]);
    }
```

_`hasPermissions(array $where = [], string $action = null, array $select = [])` : show user's permissions._

```php
    public function getUserPermissions(Request $request)
    {
        $user = \App\Models\User::find(10);
        $user->hasPermissions()->toArray();
    }
```

_`rightAccess(string $page = null, string $action =  null)` : check user has the permission to access._

```php
    public function checkUserAccess(Request $request)
    {
        $user = \App\Models\User::find(10);
        if ($user->rightAccess('product', 'create')) {
        	dump('Right Access');
        } else {
        	dump('Forbidden');
        }
    }
```


## Import/Export data

Currently, Lara Guardian imports array data (read files in `config\guardian`) into database, and exports data in DB to file by using simple command

```php
php artisan guardian --action[=ACTION] --model[=MODEL]
```

_`--action=` is `import` or `export` value._

_`model=` is one or three values `actions|pages|groups`._

For example:

```php
php artisan guardian --action=import --model=actions
```

`App\Traits\QueryKit.php` support these useful methods in importing/exporting guardian data:

_`insertDuplicate(array $data, array $insertKeys, array $updateKeys)` is insert new rows or update existed rows. The first argument consists of the values to insert or update, while second argument lists the column(s) that uniquely identify records within the associated table. The third argument is an array of the columns that should be updated if a matching record already exists in the database._

```php
$data = [
    ['fullname' => 'AAAA', 'email' => 'aaaa@xxxx.com', 'age' => 20, 'address' => 'WWW'],
    ['fullname' => 'BBBBB', 'email' => 'bbbb@xxxx.com', 'age' => 25, 'address' => 'QQQQ'],
];
\App\Models\User::insertDuplicate(
        $data,
        ['fullname', 'email'],
        ['age', 'address']
    );
```

_`except(array $columns)` is to retrieve a subset of the output data._

```php
	$exceptable = ['created_at', 'updated_at', 'deleted_at'];
	$data = app(User::class)->except($exceptable)->get()->toArray()
```
