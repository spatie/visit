
[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/support-ukraine.svg?t=1" />](https://supportukrainenow.org)

# Display the response of any URL

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/visit.svg?style=flat-square)](https://packagist.org/packages/spatie/visit)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/spatie/visit/run-tests?label=tests)](https://github.com/spatie/visit/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/spatie/visit/Check%20&%20fix%20styling?label=code%20style)](https://github.com/spatie/visit/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/visit.svg?style=flat-square)](https://packagist.org/packages/spatie/visit)

This tool can display the response of any URL. Think of it as `curl` for humans. By default, the output will be colorized, and the response code and response time will be displayed.

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/visit.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/visit)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

You can install the package via Homebrew:

```bash
brew install visit-cli
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
visit <your-url> --method=post --payload='{"testKey":"testValue"}'
```

### Showing the headers of the response

By default, `visit`  will not show any headers. To display them, add the `--headers` option

```bash
visit <your-url> /my-page --headers
```

![screenshot](https://spatie.github.io/visit/images/headers.png)

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

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Freek Van der Herten](https://github.com/freekmurze)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
