# Parrot: Repeats requested variables back as a placeholder for javascript templates in Laravel

[![Latest Stable Version](https://poser.pugx.org/awkwardideas/parrot/v/stable)](https://packagist.org/packages/awkwardideas/parrot)
[![Total Downloads](https://poser.pugx.org/awkwardideas/parrot/downloads)](https://packagist.org/packages/awkwardideas/parrot)
[![Latest Unstable Version](https://poser.pugx.org/awkwardideas/parrot/v/unstable)](https://packagist.org/packages/awkwardideas/parrot)
[![License](https://poser.pugx.org/awkwardideas/parrot/license)](https://packagist.org/packages/awkwardideas/parrot)

## Install Via Composer

```bash
$ composer require awkwardideas/parrot
```

## Add to config/app.php

Under Package Service Providers Add

```php
AwkwardIdeas\Parrot\ParrotServiceProvider::class,
```

# Available Directives
```blade
@parrot('view.name', ['some' => 'data'])
``` 