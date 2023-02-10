<?php

namespace Finller\AwsMediaConvert\Support;

use Illuminate\Contracts\Support\Arrayable;

class MediaConvertGroup implements Arrayable
{
    public function __construct(public array $settings)
    {
        //
    }

    public function addOutput(array|Arrayable $Output): static
    {
        array_push(
            $this->settings['Outputs'],
            $Output instanceof Arrayable ? $Output->toArray() : $Output
        );

        return $this;
    }

    public function addOutputWhen(mixed $condition, callable|array|Arrayable $Output): static
    {
        if (!$condition) {
            return $this;
        }

        return $this->addOutput(is_callable($Output) ? $Output() : $Output);
    }

    public function toArray(): array
    {
        return $this->settings;
    }
}
