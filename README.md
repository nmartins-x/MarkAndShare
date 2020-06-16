
# Mark & Share

A map platform allowing anyone to share or collaborate in lists of position markers. Powered by Laravel 7, Vue.js and Mapbox.

(Work in progress!)

## Installation

Install laravel dependencies via composer:
```bash
composer install
```

Install NPM packages. This will install Vue.js, Bootstrap.css, Laravel Mix, etc...
```bash
npm install
```
or
```bash
yarn
```

Create environment file:
```bash
cp .env.example .env
```
Next, create a free account on [https://www.mapbox.com/](https://www.mapbox.com/) to create an access token that will need to be added to the .env file. You can also add a Twitter API key and can configure the rest of the configuration variables (e,g. DB).

To wrap things off, run:
```bash
php artisan key:generate
php artisan migrate
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.