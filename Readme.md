# Thelia Redirect Url

The goal of this module is to redirect 404 urls with 302 or 301 redirections (temporary or permanent).

## Installation

### Manually

* Copy the module into ```<thelia_root>/local/modules/``` directory and be sure that the name of the module is TheliaRedirectUrl.
* Activate it in your thelia administration panel

### Composer

Add it in your main thelia composer.json file

```
composer require thelia/thelia-redirect-url-module:~0.3.0
```

## Usage

The configuration is very simple :
* You can add redirections one by one in the module configuration
* You can import a file with all your redirections in Tools, Import, Redirected urls.

## Others

Be sure that you use the following format for your urls :
'path' + 'parameters'

*for example :*
+ *'/'*
+ *'/contact.html'*
+ *'/contact.html?user_id=12&message=hello'*

The module will catch 404 response from Thelia and check if the request uri has a matching url in the redirect_url table.
If not, it will then check with the pathInfo. If it finds a match, it will redirect to the temporary redirect if it is provided
, else if will redirect to the redirect column (which is mandatory).