**README for Laravel 4.x is [here](./README_L4.md)**

# Installation

Run command in your terminal to include this package as a dependency:
```bash
composer require braunson/laravel-rackspace-opencloud
```

Register the OpenCloud service provider and alias the OpenCloud facade by adding it to the providers and aliases arrays in the `config/app.php` file.

For Laravel 5.5 and later **don't need** (auto discovery).

For Laravel 5.2 - 5.4:

```php
'providers' => [
    Braunson\LaravelRackspaceCdn\LaravelRackspaceCdnServiceProvider::class
];
```

```php
'aliases' => [
    'OpenCloud' => Braunson\LaravelRackspaceCdn\Facades\OpenCloud::class
]
```

For Laravel 5.1 and earlier:

```php
'providers' => [
    'Braunson\LaravelRackspaceCdn\LaravelRackspaceCdnServiceProvider'
]
```

```php
'aliases' => [
    'OpenCloud' => 'Braunson\LaravelRackspaceCdn\Facades\OpenCloud'
]
```

## Configuration

Copy the config files into your project by running:
```
php artisan vendor:publish --provider="Braunson\LaravelRackspaceCdn\LaravelRackspaceCdnServiceProvider"
```

Edit the config file to include your username, api key, region and url (internal or public).

# Usage

## Artisan Commands

Upload files via the command line.

Synchronize a whole directory. Copies all files to `/public/assets`:
```
php artisan cdn:sync public/assets
```

Copies all files to `/assets` trimming 'public' from the path:
```
php artisan cdn:sync public/assets --trim=public
```

You can configure your `package.json` to do this as NPM task:

```json
"scripts": {
    "cdn:sync": "php artisan cdn:sync public/assets --trim=public"
},
```

The sync command will save a file adjacent to the synchronized directory. It contains the http and https urls for your container. Along with a md5 hash of the directory.
In this way when a file changes inside a directory and is reuploaded you get a new cache busted URL.

If you are using the URL helper then it will return a CDN url for a file, if it finds a `*.cdn.json` file adjacent to one of it's parent directories.

```php
URL::asset('assets/image.jpg');
```

You should be able to run `php artisan cdn:sync public/assets --trim=public` before or during a deployment and once complete all files being called by `URL::asset()` will return a CDN resource.


## Upload to CDN

```php
OpenCloud::upload($container, $file, $name = null)
```

- `$container` - (string) Name of the container to upload into;
- `$file` - (string / UploadedFile) Path to file, or instance of `Symfony\Component\HttpFoundation\File\UploadedFile` as returned by `Request::file()`;
- `$name` - (string) Optional file name to be used when saving the file to the CDN.

Example:
```php
Route::post('/upload', function()
{ 
    // '\Input' alias was removed from the default aliases in Laravel 5.2+
    if(Request::hasFile('image')){
        $file = OpenCloud::upload('my-container', Request::file('image'));
    }

    $cdnUrl = $file->PublicURL();
    // Do something with $cdnUrlth

    return Redirect::to('/upload');
});
```
## Delete from CDN

```php
OpenCloud::delete($container, $file)
```
