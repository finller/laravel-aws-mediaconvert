<?php

namespace Finller\AwsMediaConvert\Http\Controllers;

use Aws\Sns\Message;
use Aws\Sns\MessageValidator;
use Finller\AwsMediaConvert\Events\ConversionHasCompleted;
use Finller\AwsMediaConvert\Events\ConversionHasError;
use Finller\AwsMediaConvert\Events\ConversionHasInputInformation;
use Finller\AwsMediaConvert\Events\ConversionHasNewWarning;
use Finller\AwsMediaConvert\Events\ConversionHasStatusUpdate;
use Finller\AwsMediaConvert\Events\ConversionIsProgressing;
use Finller\AwsMediaConvert\Events\ConversionQueueHop;
use Illuminate\Routing\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AwsMediaConvertWebhookController extends Controller
{
    public function __construct()
    {
        /**
         * Verify SNS message signature
         */
        $this->middleware(function ($request, $next) {
            $message = Message::fromRawPostData();

            $validator = new MessageValidator();

            if (! $validator->isValid($message)) {
                abort(403);
            }

            return $next($request);
        });
    }

    public function __invoke()
    {
        $message = Message::fromRawPostData();
        $this->ensureSubscriptionIsConfirmed($message);

        if (! isset($message['Message'])) {
            return response()->json(['message' => 'ok']);
        }

        $notification = json_decode($message['Message'], true);

        if (
            $notification['source'] !== 'aws.mediaconvert' ||
            ! isset($notification['detail'])
        ) {
            return response()->json(['message' => 'ok']);
        }

        $this->dispatchEvent(Arr::get($notification, 'detail.status'), $notification);

        Log::info('MediaConvert webhook', $message->toArray());

        return response()->json(['message' => 'ok']);
    }

    public function dispatchEvent(string $status, array $notification): void
    {
        switch ($status) {
            case 'PROGRESSING':
                event(new ConversionIsProgressing($notification));
                break;
            case 'INPUT_INFORMATION':
                event(new ConversionHasInputInformation($notification));
                break;
            case 'COMPLETE':
                event(new ConversionHasCompleted($notification));
                break;
            case 'STATUS_UPDATE':
                event(new ConversionHasStatusUpdate($notification));
                break;
            case 'NEW_WARNING':
                event(new ConversionHasNewWarning($notification));
                break;
            case 'QUEUE_HOP':
                event(new ConversionQueueHop($notification));
                break;
            case 'ERROR':
                event(new ConversionHasError($notification));
                break;
            default:
                throw new \Exception();
        }
    }

    public function ensureSubscriptionIsConfirmed(Message $message): void
    {
        if (isset($message['SubscribeURL'])) {
            Http::get($message['SubscribeURL']);
        }
    }
}
