<?php

namespace Finller\AwsMediaConvert;

use Aws\MediaConvert\MediaConvertClient;
use Illuminate\Support\Str;

class AwsMediaConvert
{
    public function __construct(
        public MediaConvertClient $client

    ) {
        //
    }

    public function getClient(): MediaConvertClient
    {
        return $this->client;
    }

    public function createJob(array $settings, array $metaData = [], array $tags = [], int $priority = 0): \Aws\Result
    {
        return $this->client->createJob([
            'Role' => config('aws-mediaconvert.iam_arn'),
            'Settings' => $settings,
            'Queue' => config('aws-mediaconvert.queue_arn'),
            'UserMetadata' => $metaData,
            'Tags' => $tags,
            'StatusUpdateInterval' => 'SECONDS_'.config('aws-mediaconvert.webhook_interval'),
            'Priority' => $priority,
        ]);
    }

    public function getJob(string $id): \Aws\Result
    {
        return $this->client->getJob([
            'Id' => $id,
        ]);
    }

    public function cancelJob(string $id): \Aws\Result
    {
        return $this->client->cancelJob([
            'Id' => $id,
        ]);
    }

    public function listJobs(array $options): \Aws\Result
    {
        return $this->client->listJobs($options);
    }

    public function getUri(string $path): string
    {
        return 's3://'.config('filesystems.disks.s3.bucket').Str::start($path, '/');
    }
}
