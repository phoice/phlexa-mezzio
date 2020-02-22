# phlexa-mezzio

Build voice applications for Amazon Alexa with phlexa, PHP and Mezzio.

# Laminas und Mezzio Library for Amazon Alexa Skills

This library depends on phlexa, the library for building your own PHP based 
Amazon Alexa skills. It adds a couple of useful factory classes based on 
`Laminas\ServiceManager` and some middleware classes ready to use for your 
middleware pipeline. It also contains an Intent-Manager based on 
`Laminas\ServiceManager` to make intent class handling as easy as possible for 
your applications.

## Dependencies

* PHP 7
* https://github.com/php-fig/http-message-util
* https://github.com/http-interop/http-middleware
* https://github.com/php-fig/container
* https://github.com/php-fig/http-message
* https://github.com/phoice/phlexa
* https://github.com/mezzio/mezzio-router
* https://github.com/mezzio/mezzio-template
* https://github.com/laminas/laminas-servicemanager

## Installation

Install it in your PHP project simply with Composer:

```
composer require phoice/phlexa-mezzio
```

## Usage

To get started with this library please refer to the Amazon Alexs Skill Skeleton:

https://github.com/phoice/phlexa-mezzio-skeleton
