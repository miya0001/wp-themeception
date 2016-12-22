# wp-themeception

[![Build Status](https://travis-ci.org/miya0001/wp-themeception.svg?branch=master)](https://travis-ci.org/miya0001/wp-themeception)

Check the specification of the WordPress theme.

## The goal of this project

Lists tags from current theme and check the theme that has thoese features.

* https://make.wordpress.org/themes/handbook/review/
* https://make.wordpress.org/themes/handbook/review/required/theme-tags/

## How it works

* Installs and starts WordPress with `wp server`.
* Installs and activates the theme you want to test.
* Installs [Theme Review Helper](https://github.com/miya0001/theme-review-helper) plugin that provides JSON API of metadata for the theme.
* Runs Codeception/WebDriver and PhantomJS based tests.

## What is it testing?

* Captures wanings and notices of PHP.
* Captures JavaScript errors.
* Check no 404 images.
* Gets tags from `style.css` and check those features are available in the theme.
* Takes a screenshot.

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

Load environment variables:

```
$ export WP_VERSION=latest WP_THEME=twentysixteen WP_PATH=/tmp/wp-tests WP_ERROR_LOG=/tmp/wp-error.log
```

Or

```
$ source ./.envrc
```

Other environment variables:

| Name         | Desctiption                                                |
|--------------|------------------------------------------------------------|
| `WP_THEME`   | Slug or Zip URL of the Theme. See `wp help theme install`. |
| `WP_VERSION` | WordPress version. See `wp help core download`.            |
| `WP_PATH`    | Path to the Document Root. Default is `/tmp/wp-tests`.     |
| `WP_PORT`    | The port number to bind the server to. Default is `8080`.  |
| `DB_PASS`    | MySQL root password. Default is empty.                     |

Install WordPress and run `wp server`:

```
$ npm run install-wp
$ npm run wp
```

### Run tests.

```
$ npm test
```

See example at [https://travis-ci.org/miya0001/wp-themeception](https://travis-ci.org/miya0001/wp-themeception).

### Example

```
$ npm test

wpThemeCept: Reviewing the theme.
Signature: wpThemeCept
Test: tests/acceptance/wpThemeCept.php
Scenario --
 I can see wp version
  4.7
 I can see current theme
  blanche-lite
 ---
 I am on page "/"
 I can dont see js errors
 I can dont see img errors
 ---
 I am on page "/wp-admin/"
 I can dont see js errors
 I can dont see img errors
 ---
 I am on page "/wp-admin/themes.php"
 I can dont see js errors
 I can dont see img errors
 ---
 I am on page "/wp-admin/customize.php"
 I can dont see js errors
 I can dont see img errors
 ---
 I am on page "/wp-admin/widgets.php"
 I can dont see js errors
 I can dont see img errors
 ---
 I am on page "/wp-admin/nav-menus.php"
 I can dont see js errors
 I can dont see img errors
 ---
 I am on page "/?name=template-sticky"
 I can dont see404
 I can dont see js errors
 I can dont see img errors
 ---
 I am on page "/?name=sample-page"
 I can dont see404
 I can dont see js errors
 I can dont see img errors
 ---
 I am on page "/?s=hello"
 I can dont see404
 I can dont see js errors
 I can dont see img errors
 ---
 I am on page "/archives/date/2016/12"
 I can dont see404
 I can dont see js errors
 I can dont see img errors
 ---
 I am on page "/archives/category/aciform"
 I can dont see404
 I can dont see js errors
 I can dont see img errors
 ---
 I am on page "/dsc20050604_133440_34211"
 I can dont see404
 I can dont see js errors
 I can dont see img errors
 ---
 I am on page "/this-test-is-checking-on-404"
 I can dont see js errors
 I can dont see img errors
 ---
 I see tags
 I can see the theme supports
  [ ] one-column
  [ ] two-columns
  [ ] right-sidebar
  [✓] custom-background
  [✓] custom-header
  [✓] custom-colors
  [✓] custom-logo
  [✓] custom-menu
  [ ] full-width-template
  [✓] translation-ready
  [✓] featured-images
  [✓] threaded-comments
  [ ] footer-widgets
  [ ] blog
  [ ] entertainment
  [ ] photography
 ---
 I take screenshot "/wp-admin/"
 ---
 I take screenshot "/"
 ---
 I can dont see error in log
 PASSED
```
