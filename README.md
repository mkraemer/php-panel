# PHP-Panel

Extendable lightweight event-driven information aggregator and renderer for [bar](https://github.com/LemonBoy/bar).

## Installation

PHP-Panel uses [composer](http://getcomposer.org) for dependency management; install dependencies with
```bash
composer.phar install
```

## Concept

### Information collection

Modules are used for the collection of various information.
There are two ways to implement modules:

#### Periodicly Updated Modules

Modules implementing the PeriodiclyUpdatedModuleInterface will collect and return information in fixed intervals. For example, this is used to display the current time, battery usage, sound volume or memory usage.

For example implementations of this, see the Module\Battery.php, Module\Sound.php or Module\Time.php.

#### Evented Modules

Modules implementing the EventedModuleInterface use [Evenement](https://github.com/igorw/evenement) to provide an event source and return new information when available. This allows for event-driven streaming updates, e.g. from websockets, the STDOUT of some process, ...

An implementation which makes use of this to subscribe to information of the BSPWM window manager is Modules\BSPWM.php.

### Rendering

Twig is used to render the information provided. For this, some twig extensions specific for creating format string compatible with bar are available.

See the files in the templates/ directory for examples of this.

## Example

```bash
php panel.php
```
yields something like this:
[![Screenshot](https://raw.githubusercontent.com/mkraemer/php-panel/master/screenshot.jpg)](https://raw.githubusercontent.com/mkraemer/php-panel/master/screenshot.jpg)
