<?php

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
    'endpoint' => env('AWS_MEDIACONVERT_ACCOUNT_URL'),

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
