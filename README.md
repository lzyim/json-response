Json Response
=====

Installation
------------

Install using composer:

```bash
composer require soloslee/json-response
```

Laravel (optional)
------------------

Add the service provider in `config/app.php`:

```php
'Soloslee\JsonResponse\JsonResponseServiceProvider::class',
```

And add the JsonResponse alias to `config/app.php`:

```php
'JsonResponse' => Soloslee\JsonResponse\Facades\JsonResponse::class,
```

Basic Usage
-----------

Start by creating an `JsonResponse` instance (or use the `JsonResponse` Facade if you are using Laravel):

```php
use Soloslee\JsonResponse\JsonResponse;

return JsonResponse::success();
```

### Success

```php
JsonResponse::success([
    'id' => $user->id,
    'phone' => $user->phone,
    'email' => $user->email,
    'authorized' => $user->cleaner,
    'token' => $user->token
]);
```

### Error

```php
JsonResponse::error('Fails to send message.', 602);
```

## License

Laravel Json Response is licensed under [MIT license](http://opensource.org/licenses/MIT).
