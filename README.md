# WP Theme Spec

[![Build Status](https://travis-ci.org/miya0001/wp-theme-spec.svg?branch=master)](https://travis-ci.org/miya0001/wp-theme-spec)

Check the specification of the WordPress theme.

## The goal of this project

Lists tags from current theme and check the theme that has thoese features.

* https://make.wordpress.org/themes/handbook/review/
* https://make.wordpress.org/themes/handbook/review/required/theme-tags/

It is one of the automated theme review projects.

## Getting Started

### Install dependencies.

```
$ npm run init
```

### Setup WordPress.

```
$ export WP_VERSION=latest
$ export WP_THEME=tentysixteen
$ npm run install-wp
$ npm run wp
```

Other environment variables:

| Name         | Desctiption                                                |
|--------------|------------------------------------------------------------|
| `WP_THEME`   | Slug or Zip URL of the Theme. See `wp help theme install`. |
| `WP_VERSION` | WordPress version. See `wp help core download`.            |
| `WP_PATH`    | Path to the Document Root. Default is `/tmp/wp-tests`.     |
| `WP_PORT`    | The port number to bind the server to. Default is `8080`.  |
| `DB_PASS`    | MySQL root password. Default is empty.                     |

### Run tests.

```
$ npm test
```
