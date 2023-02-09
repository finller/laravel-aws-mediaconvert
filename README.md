# Bring AWS MediaConvert to Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/finller/laravel-aws-mediaconvert.svg?style=flat-square)](https://packagist.org/packages/finller/laravel-aws-mediaconvert)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/finller/laravel-aws-mediaconvert/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/finller/laravel-aws-mediaconvert/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/finller/laravel-aws-mediaconvert/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/finller/laravel-aws-mediaconvert/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/finller/laravel-aws-mediaconvert.svg?style=flat-square)](https://packagist.org/packages/finller/laravel-aws-mediaconvert)

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require finller/laravel-aws-mediaconvert
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-aws-mediaconvert-config"
```

This is the contents of the published config file:

```php
return [
    /**
     * IAM Credentials from AWS.
     *
     * Please note, if you are intending to use Laravel Vapor, rename
     * From: AWS_ACCESS_KEY_ID - To: e.g. VAPOR_ACCESS_KEY_ID
     * From: AWS_SECRET_ACCESS_KEY - To: e.g. VAPOR_SECRET_ACCESS_KEY
     * and ensure that your Vapor environment has these values defined.
     */
    'credentials' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
    ],
    'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    'version' => 'latest',
    'url' => env('AWS_MEDIACONVERT_ACCOUNT_URL'),

    /**
     * Specify the IAM Role ARN.
     *
     * You can find the Role ARN visiting the following URL:
     * https://console.aws.amazon.com/iam/home?region=us-east-1#/roles
     * Please note to adjust the "region" in the URL above.
     * Tip: in case you need to create a new Role, you may name it `MediaConvert_Default_Role`
     * by making use of this name, AWS MediaConvert will default to using this IAM Role.
     */
    'iam_arn' => env('AWS_IAM_ARN'),

    /**
     * Specify the queue you would like use.
     *
     * It can be found by visiting the following URL:
     * https://us-east-1.console.aws.amazon.com/mediaconvert/home?region=us-east-1#/queues/details/Default
     * Please note to adjust the "region" in the URL above.
     */
    'queue_arn' => env('AWS_QUEUE_ARN'),

    /**
     * Specify how often MediaConvert sends STATUS_UPDATE events to Amazon CloudWatch Events.
     * Set the interval, in seconds, between status updates.
     *
     * MediaConvert sends an update at this interval from the time the service begins processing
     * your job to the time it completes the transcode or encounters an error.
     *
     * Accepted values: 10, 12, 15, 20, 30, 60, 120, 180, 240, 300, 360, 420, 480, 540, 600
     */
    'webhook_interval' => 60,
];
```

## Usage

```php
Finller\AwsMediaConvert\Facades\AwsMediaConvert::createJob(settings: []);
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

-   [Quentin Gabriele](https://github.com/QuentinGab)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
