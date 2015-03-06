# Filters

[![Build Status](https://travis-ci.org/gourmet/filters.svg?branch=master)](https://travis-ci.org/gourmet/{{lcPluginName}})
[![Total Downloads](https://poser.pugx.org/gourmet/filters/downloads.svg)](https://packagist.org/packages/gourmet/{{lcPluginName}})
[![License](https://poser.pugx.org/gourmet/filters/license.svg)](https://packagist.org/packages/gourmet/{{lcPluginName}})

Dispatcher filters (middlewares) for CakePHP 3.

## Install

Using [Composer][composer]:

```
composer require gourmet/filters:dev-master
```

You then need to load the plugin. In `boostrap.php`, something like:

```php
\Cake\Core\Plugin::load('Gourmet/Filters');
```

## Usage

All the below examples happen in `bootstrap.php`.

### MaintenanceFilter

By default, this filter will look for the `ROOT/maintenance.html` file and if it exists,
it will use it as the response. 

```php
DispatcherFactory::add('Gourmet/Filters.Maintenance');
```

You could customize the path like so:

```php
DispatcherFactory::add('Gourmet/Filters.Maintenance', [
    'path' => '/absolute/path/to/maintenance/file.html'
]);
```

*You could for example do `echo 'Scheduled maintenance' > maintenance.html` and your site
will automatically be set to maintenance mode with the message 'Scheduled maintenance'.*

### IpFilter

Restrict access to spefic IPs and/or ban other.

```php
DispatcherFactory::add('Gourmet/Filters.Ip', [
    'allow' => [
        '127.0.0.1'
    ]
]);
```

or 

```php
DispatcherFactory::add('Gourmet/Filters.Ip', [
    'allow' => [
        '127.0.0.1'
    ]
]);
```
### RobotsFilter

This one provides a default `robots.txt` file for non-production environments. By default,
it checks the 'APP_ENV' environment variable and compares it's value to 'production'.

```php
DispatcherFactory::add('Gourmet.Filters/Robots');
```

On all your non-production environments, `robots.txt` will look like this:

```
User-Agent: *
Disallow: /
```

and your pages' headers will include the `X-Robots-Tag` with 'noindex. nofollow, noarchive' flags.

You can customize all of that using the configuration keys: priority, when, key, value.

## Patches & Features

* Fork
* Mod, fix
* Test - this is important, so it's not unintentionally broken
* Commit - do not mess with license, todo, version, etc. (if you do change any, bump them into commits of
their own that I can ignore when I pull)
* Pull request - bonus point for topic branches

## Bugs & Feedback

http://github.com/gourmet/filters/issues

## License

Copyright (c) 2015, Jad Bitar and licensed under [The MIT License][mit].

[cakephp]:http://cakephp.org
[composer]:http://getcomposer.org
[composer:ignore]:http://getcomposer.org/doc/faqs/should-i-commit-the-dependencies-in-my-vendor-directory.md
[mit]:http://www.opensource.org/licenses/mit-license.php
