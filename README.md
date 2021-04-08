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
