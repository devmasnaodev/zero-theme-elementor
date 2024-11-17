# Zero Theme - Elementor

A simple and lightweight classical theme for the Elementor page builder, based on TailwindCSS or SASS, designed for developers.

## Developer Features

- Support for ACF Local JSON
- Elementor Extensions
- Minimal Interface
- Gulp Pipeline

## Requisitos mínimos

- PHP 7.4
- Nodejs 16.15.0
- Npm 8.5.5
- Gulp 4.0.2
- WordPress 5.4.8
- Composer 2.5.8

## Setup Inicial

Clone the repository into the WordPress theme folder at `wp-content/themes`:

``` shell
$ cd PATH/TO/WORDPRESS/wp-content/themes

$ git clone https://github.com/rodrigo-gpereira/zero-theme.git zero-theme
```

For Linux/Mac or WSL2, it is recommended to use [ASDF](https://asdf-vm.com/) to manage multiple Node.js installations.

For Windows to manage multiple node installations via NVM, watch on my [YouTube channel how to configure your Windows terminal like a pro](https://www.youtube.com/watch?v=dMVOPfWQW3g)

## Install dependencies:

``` shell
$ composer install

$ npm install
``` 
Configure the `.env` file with your environment variables:

``` shell
#Local SSL certificate files
SSL_KEY_FILE=/PATH/TO/YOUR/CERTKEY/localhost-key.pem
SSL_CERT_FILE=/PATH/TO/YOUR/CERTFILE/localhost.pem

# Domain of the development environment
DOMAIN=https://wordpress-zero-theme.local

#Package Info
TEXT_DOMAIN=zero-theme
PACKAGE=zero_theme
```

Start the development environment:

``` shell
$ npm start
```

Update the `.pot` translation file:

``` shell
$ gulp pot
```

Generate the theme build:

``` shell
$ npm run build
```
