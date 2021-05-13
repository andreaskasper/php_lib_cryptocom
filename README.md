# php_lib_cryptocom
A php class API wrapper for crypto.com

Build status: [![Build Status](https://travis-ci.org/andreaskasper/php_lib_cryptocom.svg)](https://travis-ci.org/andreaskasper/php_lib_cryptocom)

[![Latest Stable Version](https://poser.pugx.org/andreaskasper/php_lib_cryptocom/v/stable.svg)](https://packagist.org/packages/andreaskasper/php_lib_cryptocom) [![Total Downloads](https://poser.pugx.org/andreaskasper/php_lib_cryptocom/downloads)](https://packagist.org/packages/andreaskasper/php_lib_cryptocom) [![Latest Unstable Version](https://poser.pugx.org/andreaskasper/php_lib_cryptocom/v/unstable.svg)](https://packagist.org/packages/andreaskasper/php_lib_cryptocom) [![License](https://poser.pugx.org/andreaskasper/php_lib_cryptocom/license.svg)](https://packagist.org/packages/andreaskasper/php_lib_cryptocom)

# Features

# Install

## via Composer

composer.json
```json
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/andreaskasper/php_lib_cryptocom"
        }
    ],
    "require": {
        "andreaskasper/cryptocom": "*"
    },
    "minimum-stability": "dev"
}
```

then use composer for example via docker

```console
foo@bar:~$ docker run -it --rm -v ${PWD}:/app/ composer update
```


# Steps
- [x] Build a base test image to test this build process (Travis/Docker)
- [ ] Build tests
- [ ] Gnomes
- [ ] Profit
