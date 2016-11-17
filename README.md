# WP Theme Spec

[![Build Status](https://travis-ci.org/miya0001/wp-theme-spec.svg?branch=master)](https://travis-ci.org/miya0001/wp-theme-spec)

Check the specification of the WordPress theme.

## The goal of this project

Lists tags from current theme and check the theme that has thoese features.

* https://make.wordpress.org/themes/handbook/review/
* https://make.wordpress.org/themes/handbook/review/required/theme-tags/

It is one of the automated theme review projects.

## How it works

* Install and activate the theme you want to test.
* Install [Theme Review Helper](https://github.com/miya0001/theme-review-helper) plugin that provides JSON API of metadata for the theme.
* Run Codeception/WebDriver and PhantomJS based tests.

## What is it testing?

* Captures waning and notice of PHP.
* Captures JavaScript errors.
* Gets tags from `style.css` and check those features are available in the theme.

### Supported tags

* [ ] one-column
* [ ] two-column
* [ ] three-columns
* [ ] four-columns
* [ ] left-sidebar
* [ ] right-sidebar
* [ ] grid-layout
* [x] flexible-header
* [ ] accessibility-ready
* [ ] buddypress
* [x] custom-background
* [x] custom-colors
* [x] custom-header
* [x] custom-menu
* [x] custom-logo
* [x] editor-style
* [x] featured-image-header
* [x] featured-images
* [ ] footer-widgets
* [ ] front-page-post-form
* [ ] full-width-template
* [ ] microformats
* [x] post-formats
* [ ] rtl-language-support
* [x] sticky-post
* [x] theme-options
* [x] threaded-comments
* [x] translation-ready
* [ ] blog
* [ ] e-commerce
* [ ] education
* [ ] entertainment
* [ ] food-and-drink
* [ ] holiday
* [ ] news
* [ ] photography
* [ ] portfolio

## Getting Started

### Install dependencies.

```
$ npm run init
```

### Setup WordPress.

```
$ export WP_VERSION=latest WP_THEME=twentysixteen WP_PATH=/tmp/wp-tests
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

Example:

```
Acceptance Tests (1) -------------------------------------------------------------
wpthemeCept: Check the theme specification from tags
Signature: wpthemeCept
Test: tests/acceptance/wpthemeCept.php
Scenario --
 I see current theme
  Current theme is "twentysixteen".
 I see tags for "twentysixteen"
  * one-column
  * two-columns
  * right-sidebar
  * accessibility-ready
  * custom-background
  * custom-colors
  * custom-header
  * custom-menu
  * editor-style
  * featured-images
  * flexible-header
  * microformats
  * post-formats
  * rtl-language-support
  * sticky-post
  * threaded-comments
  * translation-ready
  * blog
 I see the theme supports ["one-column","two-columns","right-sidebar","accessi...]
  one-column: No tests defined
  two-columns: No tests defined
  right-sidebar: No tests defined
  accessibility-ready: No tests defined
  custom-background: OK
  custom-colors: OK
  custom-header: OK
  custom-menu: OK
  editor-style: OK
  featured-images: OK
  flexible-header: OK
  microformats: No tests defined
  post-formats: OK
  rtl-language-support: No tests defined
  sticky-post: OK
  threaded-comments: OK
  translation-ready: OK
  blog: No tests defined
 PASSED

----------------------------------------------------------------------------------


Time: 7.9 seconds, Memory: 8.00MB

OK (1 test, 1 assertion)
```

See [https://travis-ci.org/miya0001/wp-theme-spec](https://travis-ci.org/miya0001/wp-theme-spec).
