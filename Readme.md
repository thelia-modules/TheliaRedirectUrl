# Thelia Redirect Url

The goal of this module is to redirect 404 urls with 301 or 302 redirections.

## Installation

### Manually

* Copy the module into ```<thelia_root>/local/modules/``` directory and be sure that the name of the module is TheliaRedirectUrl.
* Activate it in your thelia administration panel

### Composer

Add it in your main thelia composer.json file

```
composer require thelia/thelia-redirect-url-module:~0.1.0
```

## Usage

The configuration is very simple :
* You can add redirections one by one in the module configuration
* You can import a file with all your redirections in Tools, Import, Redirected urls.