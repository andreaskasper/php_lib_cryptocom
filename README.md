# php_lib_cryptocom
A php class API wrapper for crypto.com

![LastUpdate](https://img.shields.io/github/last-commit/andreaskasper/php_lib_cryptocom)
[![Build Status](https://img.shields.io/travis/com/andreaskasper/php_lib_cryptocom)](https://travis-ci.org/andreaskasper/php_lib_cryptocom)

### Bugs & Issues:
[![Github Issues](https://img.shields.io/github/issues/andreaskasper/php_lib_cryptocom.svg)](https://github.com/andreaskasper/php_lib_cryptocom/issues)
![Code Languages](https://img.shields.io/github/languages/top/andreaskasper/php_lib_cryptocom.svg)

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
