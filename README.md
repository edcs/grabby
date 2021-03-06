# Grabby 
[![Codeship Status for edcs/grabby](https://codeship.com/projects/da4c26b0-b5f2-0133-6bbf-724fe1788ad4/status?branch=master)](https://codeship.com/projects/134212) 
[![Total Downloads](https://poser.pugx.org/edcs/grabby/downloads)](https://packagist.org/packages/edcs/grabby)
[![Latest Stable Version](https://poser.pugx.org/edcs/grabby/v/stable)](https://packagist.org/packages/edcs/grabby)
[![License](https://poser.pugx.org/edcs/grabby/license)](https://packagist.org/packages/edcs/grabby)
[![Coverage Status](https://coveralls.io/repos/github/edcs/grabby/badge.svg?branch=master)](https://coveralls.io/github/edcs/grabby?branch=master) 
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/8e1185a8-27f7-4eff-8de3-6b0e10179f90/mini.png)](https://insight.sensiolabs.com/projects/8e1185a8-27f7-4eff-8de3-6b0e10179f90)

A PhantomJS adapter to generate screengrabs of webpages in PHP.

## Installation

It is recommended that you install this library using Composer. Before installing Grabby, add the following to the
`scripts` namespace in your `composer.json` file:

```javascript
    "scripts": {
        "post-install-cmd": [
            "PhantomInstaller\\Installer::installPhantomJS"
        ],
        "post-update-cmd": [
            "PhantomInstaller\\Installer::installPhantomJS"
        ]
    }
```

That takes care of installing the correct PhantomJS binary into your project directory. Next you need to run the
following command to add Grabby to your project:

```bash
$ composer require edcs/grabby
```

## Dependencies

Grabby requires PHP version >=5.4.0 and `symfony/process` ^3.1. PhantomJS is also required; Grabby will download the
correct binary for your system.

# Getting Started

The following snippet will run grabby it's most basic form, this will generate a screengrab of Google's home page in a 
PNG called `grabby.png` at a resolution of 1920x1080px. The file will be stored in the same directory which the Grabby 
`Factory` class is located.

```php
<?php

use Edcs\Grabby\Factory;

require 'vendor/autoload.php';

$grabby = new Factory('http://www.google.co.uk');

$grabby->grab();
```    

## Extra Parameters

You would probably like your screengrab to be stored in a different location and probably generated in a different size.
You can pass Grabby some extra parameters to do this. The following example will generate a screengrab of Google's home 
page in a PNG called `screenshot.jpg` at a resolution of 150x200px. The file will be stored in `/my/storage/dir/`, an 
exception is thrown if this directory doesn't exist.

```php
<?php

use Edcs\Grabby\Factory;

require 'vendor/autoload.php';

$grabby = new Factory('http://www.google.co.uk', 'screenshot.png', '/my/storage/dir/', [
    'viewportSize' => [
        'width' => 150,
        'height' => 200
    ]
]);

$grabby->grab();
```

Grabby also supports creating PDF versions of web pages in different paper sizes. You can use the same config as above
to create PDF renderings using a viewport size, or, you can use the following paper size config:

```php
<?php

use Edcs\Grabby\Factory;

require 'vendor/autoload.php';

$grabby = new Factory('http://www.google.co.uk', 'screenshot.pdf', '/my/storage/dir/', [
    'paperSize' => [
        'format' => 'A4',
        'orientation' => 'portrait',
        'margin' => '1cm'
    ]
]);

$grabby->grab();
```

Since Grabby is built on top of PhantomJS, you have all of the Web Page Module configuration options at your disposal. If
you required a complex configuration, you can build up an array using the module option as the array key and it's properties
as the value. The following example would create a `portrait` `A4` PDF with a `3cm` margin containing an image of Google's
homepage viewied through a `150px` by `200px` viewport using a header called `X-Test` with the value `foo`:

```php
<?php

use Edcs\Grabby\Factory;

require 'vendor/autoload.php';

$grabby = new Factory('http://www.google.co.uk', 'screenshot.pdf', '/my/storage/dir/', [
    'customHeaders' => [
        'X-Test' => 'foo'
    ],
    'viewportSize' => [
        'width' => 150,
        'height' => 200
    ],
    'paperSize' => [
        'format' => 'A4',
        'orientation' => 'portrait',
        'margin' => '3cm'
    ]
]);

$grabby->grab();
```

You can check out the Web Page Module documentation here: http://phantomjs.org/api/webpage/

## Other File Formats

You can generate screengrabs in `png`, `jpg` or `pdf` formats. Simply suffix the filename property with one of those 
extensions.

## Accessing the Generated File

Once you have run `grab()` to generate your screengrab file, you can either access the generated filenames path like so:

```php
<?php

use Edcs\Grabby\Factory;

require 'vendor/autoload.php';

$grabby = new Factory('http://www.google.co.uk', 'screenshot.png', '/my/storage/dir/', 150, 200);

$file = $grabby->grab()->getScreengrabLocation(); // Returns /my/storage/dir/screenshot.png
```    

Or you access the contents of the file like so:

```php
<?php

use Edcs\Grabby\Factory;

require 'vendor/autoload.php';

$grabby = new Factory('http://www.google.co.uk', 'screenshot.png', '/my/storage/dir/', 150, 200);

$fileContents = $grabby->grab()->getScreengrab(); // Returns the contents of /my/storage/dir/screenshot.png
```    

## Contributing

Please see [CONTRIBUTING](https://github.com/edcs/grabby/blob/master/CONTRIBUTING.md) for details.

## Security Vulnerabilities

If you discover a security vulnerability within this package, please send an e-mail to edcoleridgesmith@gmail.com. All 
security vulnerabilities will be promptly addressed.
