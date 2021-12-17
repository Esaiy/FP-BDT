# Final Project Basis Data Terdistribusi

## Gambar Arsitektur Aplikasi
![image](https://user-images.githubusercontent.com/30065248/146547145-069fef31-383f-45c9-8ca5-e7f04b624ded.png)

## Konfigurasi
Untuk script konfigurasi HAProxy, MySQL, dan redis terdapat di folder `script`

- Konfigurasi MySQL master-slave pada laravel :
```
'mysql' => [
            'read' => [
                'host' => [
                    env('DB_HOST_1', '10.0.0.193'),
                ],
            ],
            'write' => [
                'host' => [
                    env('DB_HOST', '10.0.0.33'),
                ],
            ],
            'driver' => 'mysql',
            ...
```
- Konfigurasi Redis pada laravel :
```
'default' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', '6380'),
            'database' => env('REDIS_DB', '0'),
            'read_write_timeout' => 60,
        ],

        'read' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT_READ', '6379'),
            'database' => env('REDIS_DB', '0'),
            'read_write_timeout' => 60,
        ],

        'session' => [
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6380),
            'database' => 1,
            'read_write_timeout' => 60,
        ],

        'cache' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', '6380'),
            'database' => env('REDIS_CACHE_DB', '1'),
            'read_write_timeout' => 60,
        ],
```

- 

