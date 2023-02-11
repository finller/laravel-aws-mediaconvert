# Bring AWS MediaConvert to Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/finller/laravel-aws-mediaconvert.svg?style=flat-square)](https://packagist.org/packages/finller/laravel-aws-mediaconvert)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/finller/laravel-aws-mediaconvert/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/finller/laravel-aws-mediaconvert/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/finller/laravel-aws-mediaconvert/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/finller/laravel-aws-mediaconvert/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/finller/laravel-aws-mediaconvert.svg?style=flat-square)](https://packagist.org/packages/finller/laravel-aws-mediaconvert)

This package provides an easy way to interact with AWS MediaConvert. It provides usefull presets for **HLS**, **MP4** optimization and **thumbnail**.

The package is greatly inspired by the work of meemalabs and their similar package https://github.com/meemalabs/laravel-media-converter !

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

In the most basic way, this package provides a service which is a wrap around the aws sdk.
So you can simply create a MediaConvert job by calling `createJob` like that.

```php
Finller\AwsMediaConvert\Facades\AwsMediaConvert::createJob(settings: []);
```

But we also provid usefull `HLS` and `MP4` presets that are optimized for the web.
Here is a more advanced usage:

Convert any video to an optimized MP4:

```php
$input = AwsMediaConvert::getUri($path); // you can use getUri to build the S3 uri quickly

AwsMediaConvert::createJob(
    settings: DefaultMediaConvertSettings::make($input)
        ->addOutputGroup(
            DefaultOptimizedVideoMediaConvertGroup::make(
                Destination: $destination,
                Height: min(1080, $originalHeight) // optional but you can set a Height or Width to resize the video
            )
        )
        ->toArray(),
    metaData: [ // feel free to add metadata so you can do the right action when receiving the webhook
        'env' => config('app.env'),
        get_class($this->media) => $this->media->id,
        'job' => get_class($this),
    ]
);
```

Convert any video to an optimized Apple HLS set of files:

```php
$input = AwsMediaConvert::getUri($path); // you can use getUri to build the S3 uri easily

AwsMediaConvert::createJob(
    settings: DefaultMediaConvertSettings::make($input)
        ->addOutputGroup(
            DefaultHlsMediaConvertGroup::make($destination)
                ->addOutputWhen($maxHeight >= 1080, DefaultHls1080pMediaConvertOutput::make())
                ->addOutputWhen($maxHeight >= 720, DefaultHls720pMediaConvertOutput::make())
                ->addOutputWhen($maxHeight >= 540, DefaultHls540pMediaConvertOutput::make())
                ->addOutputWhen($maxHeight >= 540, DefaultHls480pMediaConvertOutput::make())
        )
        ->toArray(),
    metaData: []
);
```

Perform multiple Conversion in 1 job:

```php
$input = AwsMediaConvert::getUri($path); // you can use getUri to build the S3 uri easily

AwsMediaConvert::createJob(
    settings: DefaultMediaConvertSettings::make($input)
    ->addOutputGroup(
            DefaultOptimizedVideoMediaConvertGroup::make(
                Destination: $destination,
                Height: min(1080, $originalHeight) // optional but you can set a Height or Width to resize the video
            )
        )
        ->addOutputGroup(
            DefaultHlsMediaConvertGroup::make($destination)
                ->addOutputWhen($originalHeight >= 1080, DefaultHls1080pMediaConvertOutput::make())
                ->addOutputWhen($originalHeight >= 720, DefaultHls720pMediaConvertOutput::make())
                ->addOutputWhen($originalHeight >= 540, DefaultHls540pMediaConvertOutput::make())
                ->addOutputWhen($originalHeight >= 540, DefaultHls480pMediaConvertOutput::make())
        )
        ->toArray(),
    metaData: []
);
```

### Tracks MediaConvert jobs with webhooks

### 1. Register the webhook route in your app.

You can simply use our prebuilt Webhook controller

In your `web`, `api` or any route file of yours, register the prebuilt route with the following macro.
You can use any url

```php
Route::awsMediaConvertWebhook('aws/webhooks/media-convert');
```

If you have put your route in a place where the `VerifyCsrfToken` is attached, you will have to add an exception just like that:
```php
class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'aws/*', // Put the route you have chosen here
    ];
}
```

### 2. Create an SNS Topic
Go to https://console.aws.amazon.com/sns/v3/home (don't forget to select the right region for you).

On the right navigation bar, select "Topics" and click the "Create topic" button on your right.
For the Type, choose "Standard" and give a name to your Topic juste like "MediaConvertJobUpdate" and click "Create topic"

Now, click "Create subscription" and select HTTPS for the "Protocol". Then enter the webhook route you have chosen like `https://app.example/aws/webhooks/media-convert` and confirm creation.

By default, AWS will have sent a post request to URL you defined in your "Subscription" setup. This package automatically handles the "confirmation" part. In case there is an issue and it is not confirmed yet, please click on the "Request confirmation" button.


#### 3. Create an AWS CloudWatch rule
1. Go to https://console.aws.amazon.com/cloudwatch/home (don't forget to select the right region for you).
2. Open Events > Rule from the left navigation bar.
3. Click Create Rule.
In the Event Source panel select the "Event pattern" radio and "Events by Services" (it should be the default value)
In "Service Name", choose "MediaConvert" et keep  "All Events" for Event Type.

Your Event pattern preview should be
```json
{
  "source": [
    "aws.mediaconvert"
  ]
}
```

If you need to listen to only a specific queue for example, you can do it like that:
```json
{
  "source": ["aws.mediaconvert"],
  "detail": {
    "queue": ["arn:aws:mediaconvert:us-east-1:123456789:queues/Default"]
  }
}
```

In the Target panel (on the right), click "Add Target" and select "SNS Topic". Then select the previously created SNS Topic.

That's all, this package will dispatch Laravel events for you to listen.
But if you need more specific behavior, you can create your own controller by extending `AwsMediaConvertWebhookController` for example.

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
