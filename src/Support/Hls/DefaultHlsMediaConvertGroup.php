<?php

namespace Finller\AwsMediaConvert\Support\Hls;

use Illuminate\Contracts\Support\Arrayable;

/**
 * Default settings for an Apple HLS web optimized Video
 */
class DefaultHlsMediaConvertGroup implements Arrayable
{
    public function __construct(public array $settings)
    {
        //
    }

    public static function make(string $Destination): self
    {
        return new self([
            'CustomName' => 'Standard HLS',
            'Name' => 'Apple HLS',
            'Outputs' => [],
            'OutputGroupSettings' => [
                'Type' => 'HLS_GROUP_SETTINGS',
                'HlsGroupSettings' => [
                    'SegmentLength' => 10,
                    'Destination' => $Destination,
                    'MinSegmentLength' => 0,
                ],
            ],
        ]);
    }

    public function addOutput(array $Output): static
    {
        array_push($this->settings['Outputs'], $Output);

        return $this;
    }

    public function addOutputGroupWhen(mixed $condition, callable|array $Output): static
    {
        if (! $condition) {
            return $this;
        }

        return $this->addOutput(is_callable($Output) ? $Output() : $Output);
    }

    public function toArray(): array
    {
        return $this->settings;
    }
}
