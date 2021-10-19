## Installation
`composer require nanuc/laravel-nextcloud`

`php artisan vendor:publish --provider="Nanuc\Nextcloud\NextcloudServiceProvider" --tag="config"`

### Logging
create a logging channel `nextcloud` and set `NEXTCLOUD_API_LOGGING=true` in `.env`. 