##Setup Steps

install php dependencies using composer:
```sh
composer install
```

install node dependencies (for this project only for UI) run :

```sh
npm install
npm run dev
```
initial Database

fill DBMS credential in `.env` file then:

```sh
php artisan migrate
```

## Testing

be sure to have dev dependencies & proper chromium driver for dusk :

```sh
composer install --require-dev
php artisan dusk:chrome-driver 86
```

fill APP_URL in `.env` file then:

```sh
php artisan test && php artisan dusk
```
