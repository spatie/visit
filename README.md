# Display the response of any URL

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/visit.svg?style=flat-square)](https://packagist.org/packages/spatie/visit)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/spatie/visit/Check%20&%20fix%20styling?label=code%20style)](https://github.com/spatie/visit/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/visit.svg?style=flat-square)](https://packagist.org/packages/spatie/visit)

This tool can display the response of any URL. Think of it as `curl` for humans. By default, the output will be colorized. The response code and response time will be displayed after the response.

![screenshot](https://github.com/spatie/visit/blob/main/docs/images/intro.png?raw=true)

JSON responses will be colorized by default as well.

![screenshot](https://github.com/spatie/visit/blob/main/docs/images/json.png?raw=true)

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/visit.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/visit)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

You can install the package via composer:

```bash
composer global require spatie/visit
```

To colorize HTML, you should install [bat 0.20 or higher](https://github.com/sharkdp/bat). 

On macOS you can install bat using brew.

```bash
brew install bat
```

To colorize JSON, you should install [jq](https://stedolan.github.io/jq/).

On macOS you can install jq using brew.

```bash
brew install jq
```

## Usage

To visit a certain page, execute `visit` followed by a URL.

```bash
visit spatie.be
```

![screenshot](https://spatie.github.io/visit/images/html.png)

### Using a different method

By default, the `visit` command will make GET request. To use a different HTTP verb, you can pass it to the `method` option.

```bash
visit <your-url> --method=delete
```

### Following redirects

By default, the `visit` command will not follow redirects. To follow redirects and display the response of the redirection target, add the `--follow-redirects` option.

```bash
php artisan visit /my-page --follow-redirects
```

### Passing a payload

You can pass a payload to non-GET request by using the payload. The payload should be formatted as JSON.

```bash
visit <your-url> --payload='{"testKey":"testValue"}'
```

When you pass a payload, we'll assume that you want to make a `POST` request. If you want to use another http verb, pass it explicitly.

```php
visit <your-url> --method=patch --payload='{"testKey":"testValue"}'
```



### Showing the headers of the response

By default, `visit`  will not show any headers. To display them, add the `--headers` option

```bash
visit <your-url> /my-page --headers
```

![screenshot](https://github.com/spatie/visit/blob/main/docs/images/headers.png?raw=true)

### Only displaying the response

If you want `visit` to only display the response, omitting the response result block at the end, pass the `--only-response` option.

```bash
visit <your-url> --only-response
```

### Only displaying the response properties block

To avoid displaying the response, and only display the response result block, use the `--only-stats` option

```bash
visit <your-url> --only-stats
```

### Avoid colorizing the response

`visit` will automatically colorize any HTML and JSON output. To avoid the output being colorized, use the `--no-color` option.

```bash
visit <your-url> --no-color
```

### Displaying the result HTML as text

Usually an HTML response is quite lengthy. This can make it hard to quickly see what text will be displayed in the browser. To convert an HTML to a text variant, you can pass the `--text` option.

```bash
visit <your-url> --text
```

### Filtering HTML output

If you only want to see a part of an HTML response you can use the `--filter` option. For HTML output, you can pass [a css selector](https://www.w3schools.com/cssref/css_selectors.asp).

Imagine that your app's full response is this HTML:

```html
<html>
    <body>
        <div>First div</div>
        <p>First paragraph</p>
        <p>Second paragraph</p>
    </body>
</html>
```

This command ...

```bash
visit <your-url> --filter="p"
```

... will display:

```html
<p>First paragraph</p>
<p>Second paragraph</p>
```

### Filtering JSON output

If you only want to see a part of an JSON response you can use the `--filter` option. You may use dot-notation to reach nested parts.

Imagine that your app's full response is this JSON:

```json
{
    "firstName": "firstValue",
    "nested": {
        "secondName": "secondValue"
    }
}
```

This command ...

```bash
visit <your-url> --filter="nested.secondName"
```

... will display:

```html
secondValue
```

### Ignoring SSL Errors

If you want the `visit` command to bypass SSL certificate verification (useful for testing against local development
servers with self-signed certificates), you can use the `--ignore-ssl-errors` option.

```bash
visit <your-url> --ignore-ssl-errors
```

This will allow you to make requests to endpoints with invalid or untrusted SSL certificates without the request
failing.

**Note:** Use this option carefully. Bypassing SSL verification compromises the security of your request and should only be used for testing purposes.


## Laravel integration

The `visit` command can also reach into a Laravel app and do stuff like:

- logging in a user
- visiting a route name
- reporting the amount of queries performed and models hydrated to build up the response.

To enable this, you must install [the spatie/laravel-visit package](https://github.com/spatie/laravel-visit) inside your Laravel app.

To visit a route in your Laravel app, make sure you execute `visit` when the current working directory is your Laravel app. You should also use a relative URL (so omit the app URL).

![screenshot](https://github.com/spatie/visit/blob/main/docs/images/relative.png?raw=true)

Your can use these extra options:

- `--user`: you can pass this option a user id or email that will be logged in before rendering the response
- `--route`: pass this option the name of a route, you don't have to specify an url anymore. For example `visit --route=contact`
- `--show-exceptions`: when your app throws an exception, this option will show that exception.

Here's an example of the `route` option:

![screenshot](https://github.com/spatie/visit/blob/main/docs/images/laravel1.png?raw=true)

In the stats block at the end you'll see the amount of queries and models hydrated.

![screenshot](https://github.com/spatie/visit/blob/main/docs/images/laravel2.png?raw=true)

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/spatie/.github/blob/main/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Freek Van der Herten](https://github.com/freekmurze)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
