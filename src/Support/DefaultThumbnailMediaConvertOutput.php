<?php

namespace Finller\AwsMediaConvert\Support;

/**
 * Default settings for creating a thumbnail of the video
 */
class DefaultThumbnailMediaConvertOutput
{
    public static function make(
        string $FramerateNumerator,
        string $FramerateDenominator,
        string $MaxCaptures,
        string $Quality,
        string $Width,
        string $Destination
    ): array {
        return [
            'CustomName' => 'Thumbnails',
            'Name' => 'File Group',
            'Outputs' => [
                [
                    'ContainerSettings' => [
                        'Container' => 'RAW',
                    ],
                    'VideoDescription' => [
                        'ScalingBehavior' => 'DEFAULT',
                        'TimecodeInsertion' => 'DISABLED',
                        'AntiAlias' => 'ENABLED',
                        'Sharpness' => 50,
                        'CodecSettings' => [
                            'Codec' => 'FRAME_CAPTURE',
                            'FrameCaptureSettings' => [
                                'FramerateNumerator' => $FramerateNumerator,
                                'FramerateDenominator' => $FramerateDenominator,
                                'MaxCaptures' => $MaxCaptures,
                                'Quality' => $Quality,
                            ],
                        ],
                        'AfdSignaling' => 'NONE',
                        'DropFrameTimecode' => 'ENABLED',
                        'RespondToAfd' => 'NONE',
                        'ColorMetadata' => 'INSERT',
                        'Width' => $Width,
                    ],
                ],
            ],
            'OutputGroupSettings' => [
                'Type' => 'FILE_GROUP_SETTINGS',
                'FileGroupSettings' => [
                    'Destination' => $Destination,
                ],
            ],
        ];
    }
}
