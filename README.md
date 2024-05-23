# Laravel maintenance mode
- A custom maintenance mode for Laravel (JSON response support).

## How to install
- required `PHP >= 7.2`, `Laravel >= 5.8`
```
composer require congnqnexlesoft/laravel-maintenance-mode
```

## How to configure
In `app/Http/Kernel.php`, add this `middleware` in `$middleware array` 
- [Required] Put `MaintenanceModeMiddleware::class` below `\Spatie\Cors\Cors::class`  (should be **2nd item**)
- [Required] Don't use `Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode`
```PHP
// 2nd, should below `Cors` and don't use 'Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode'
\CongnqNexlesoft\MaintenanceMode\Http\Middleware\MaintenanceModeMiddleware::class,
```

## Response
### Features:
- **Using JSON response**
- **Except URIs**
- Require config the line below to your `.env` file
```dotenv
## [BEGIN] congnqnexlesoft/laravel-maintenance-mode, lumen-maintenance-mode, symfony-maintenance-mode ##
MAINTENANCE_RESPONSE_FORMAT=json
#    separate by ,(comma)
EXCEPT_URIS=URI_1,URI_2
## [END] congnqnexlesoft/laravel-maintenance-mode, lumen-maintenance-mode, symfony-maintenance-mode ##
```
### Using View
- Copy these files to your project (if):
```
resources/views/errors/503.blade.php
storage/framework/.gitignore
```

## Put the application into maintenance mode (default in Laravel).
```shell
php artisan down
```
## Bring the application out of maintenance mode (default in Laravel).
```shell
php artisan up
```

---
## DevOps
### Release a new version
```shell
sh .ops/release-a-new-version.sh
```
