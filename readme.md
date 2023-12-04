# Zero Theme - Elementor

Um tema simples e leve para o construtor de páginas Elementor baseado em Tailwindcss ou SASS, feito para desenvolvedores.

## Recursos para desenvolvedor

 - Suporte para ACF Local JSON
 - Elementor Extensions
 - Interface Mínima
 - Gulp Pipeline

## Requisitos mínimos

- PHP 7.4
- Nodejs 16.15.0
- Npm 8.5.5
- Gulp 4.0.2
- WordPress 5.4.8
- Composer 2.5.8

## Setup Inicial

<p>Clone o repositório na dentro da pasta de temas do WordPress wp-content/themes </p>

```
$ cd PATH/TO/WORDPRESS/wp-content/themes

$ git clone https://github.com/rodrigo-gpereira/zero-theme.git zero-theme
```

<p> Para Linux/Mac ou WSL2 Recomendo utilizar [ASDF](https://asdf-vm.com/) para gerenciar multiplas instalações de node </p>

<p> Instale as dependências </p>

```
$ composer install

$ npm install
```
<p> Ajustes os arquivo .env para suas variáveis de ambiente </p>

```
#Local SSL certificate files
SSL_KEY_FILE=/PATH/TO/YOUR/CERTKEY/localhost-key.pem
SSL_CERT_FILE=/PATH/TO/YOUR/CERTFILE/localhost.pem

# Domain of the development environment
DOMAIN=https://zero-theme.local

#Package Info
TEXT_DOMAIN=zero-theme
PACKAGE=zero_theme
```

<p> Iniciar o ambiente </p>

```
$ npm start
```

<p> Atualizar o arquivo de traduções .pot </p>

```
$ gulp pot
```

<p> Gerar a build do Tema </p>

```
$ npm run build
```
