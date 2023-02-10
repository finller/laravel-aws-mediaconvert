<?php

namespace Finller\AwsMediaConvert\Support;

use Illuminate\Contracts\Support\Arrayable;

/**
 * Default settings for an web optimized .mp4 Video
 */
class DefaultMediaConvertSettings implements Arrayable
{
    public function __construct(public array $settings)
    {
        //
    }

    public static function make(string $FileInput): self
    {
        return new self(
            [
                'OutputGroups' => [],
                'AdAvailOffset' => 0,
                'Inputs' => [
                    [
                        'AudioSelectors' => [
                            'Audio Selector 1' => [
                                'Offset' => 0,
                                'DefaultSelection' => 'DEFAULT',
                                'ProgramSelection' => 1,
                            ],
                        ],
                        'VideoSelector' => [
                            'ColorSpace' => 'FOLLOW',
                        ],
                        'FilterEnable' => 'AUTO',
                        'PsiControl' => 'USE_PSI',
                        'FilterStrength' => 0,
                        'DeblockFilter' => 'DISABLED',
                        'DenoiseFilter' => 'DISABLED',
                        'TimecodeSource' => 'EMBEDDED',
                        'FileInput' => $FileInput,
                    ],
                ],
            ]
        );
    }

    public function addOutputGroup(array|Arrayable $outputGroup): static
    {
        array_push(
            $this->settings['OutputGroups'],
            $outputGroup instanceof Arrayable ? $outputGroup->toArray() : $outputGroup
        );

        return $this;
    }

    public function addOutputGroupWhen(mixed $condition, callable|array|Arrayable $outputGroup): static
    {
        if (!$condition) {
            return $this;
        }

        return $this->addOutputGroup(is_callable($outputGroup) ? $outputGroup() : $outputGroup);
    }

    public function toArray(): array
    {
        return $this->settings;
    }
}
