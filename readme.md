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

Under Facades/Class Aliases Add

```php
'Parrot' => AwkwardIdeas\Parrot\Facades\Parrot::class,
```

# Available Directives
```blade
@parrot('view.name', ['some' => "", 'data'=>"", 'parrotClass'=>"CustomClass", 'parrotID'=>"templateID"])
```
* Similar to @include blade directive. Provide your own data to be used in the template, you only need to define the high level variables, actual values are not needed. Parrot will mock the values for these variables. 
* The parrotClass key can be provided to be output with @parrotClass.  This will just echo the class, so it needs to be within a class="" attribute.  
* The parrotID key can be provided to be output with @parrotID. This will echo id='parrotIDValue', so that the ID can be optional on your markup.

```blade
@parrotif('view.name', ['some' => ""])
```
Similar to @includeif blade directive

```blade
@parrotClass
```
If the template is called with parrot, it will show the $parrotClass variable.  A default class of parrotTemplate is output if a custom class is not provided.

```blade
@parrotID
```
If the template is called with parrot, it will show the $parrotID variable.

```blade
@onParrot
```
Starts an if case for when parrot is being used. If not being parroted, the template wont render the contained content. An ```@else``` may be used with ```@onParrot```
```blade
@endOnParrot
```
Ends the if case for ```@onParrot```

```blade
@noParrot
```
Starts an if case for when the template is being render without parrot. If being parroted, the template wont render the contained content. An ```@else``` may be used with ```@noParrot```

```blade
@endNoParrot
```
Ends the if case for ```@endNoParrot```