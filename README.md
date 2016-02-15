# Grabby [ ![Codeship Status for edcs/grabby](https://codeship.com/projects/da4c26b0-b5f2-0133-6bbf-724fe1788ad4/status?branch=master)](https://codeship.com/projects/134212)

A PhantomJS adapter to generate screengrabs of webpages in PHP.

## Installation

It is recommended that you install this library using Composer.

```bash
$ composer require edcs/grabby
```

## Dependencies

Grabby requires PHP version >=5.4.0 and `symfony/process` 2.7.0. PhantomJS is also required; Grabby checks to see if a
it is installed on the server and if not, it tries to use a bundled binary.

# Getting Started

The following snippet will run grabby it's most basic form, this will generate a screengrab of Google's home page in a PNG
called `grabby.png` at a resolution of 1920x1080px. The file will be stored in the same directory which the Grabby `Factory`
class is located.

```php
<?php

use Edcs\Grabby\Factory;

require 'vendor/autoload.php';

$grabby = new Factory('http://www.google.co.uk');

echo $grabby->grab();
```    

## Extra Parameters

You would probably like your screengrab to be stored in a different location and probably generated in a different size. You
can pass Grabby some extra parameters to do this. The following example will generate a screengrab of Google's home page in a PNG
called `screenshot.jpg` at a resolution of 150x200px. The file will be stored in `/my/storage/dir/`, an exception is thrown if 
this directory doesn't exist.

```php
<?php

use Edcs\Grabby\Factory;

require 'vendor/autoload.php';

$grabby = new Factory('http://www.google.co.uk', 'screenshot.png', '/my/storage/dir/', 150, 200);

echo $grabby->grab();
```    

## Other File Formats

You can generate screengrabs in `png`, `jpg` or `pdf` formats. Simply suffix the filename property with one of those extensions.

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

This project is a work in progress - contributions and pull requests are welcome.

## Security Vulnerabilities

If you discover a security vulnerability within this package, please send an e-mail to edcoleridgesmith@gmail.com. All security 
vulnerabilities will be promptly addressed.
