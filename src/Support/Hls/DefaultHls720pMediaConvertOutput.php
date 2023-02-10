<?php

namespace Finller\AwsMediaConvert\Support\Hls;

class DefaultHls720pMediaConvertOutput
{
    public static function make(
        string $NameModifier = '-$h$p-$f$fps-$rv$kbps'
    ): array {
        return [
            'ContainerSettings' => [
                'Container' => 'M3U8',
                'M3u8Settings' => [
                    'AudioFramesPerPes' => 4,
                    'PcrControl' => 'PCR_EVERY_PES_PACKET',
                    'PmtPid' => 480,
                    'PrivateMetadataPid' => 503,
                    'ProgramNumber' => 1,
                    'PatInterval' => 0,
                    'PmtInterval' => 0,
                    'VideoPid' => 481,
                    'AudioPids' => [
                        482,
                        483,
                        484,
                        485,
                        486,
                        487,
                        488,
                        489,
                        490,
                        491,
                        492,
                        493,
                        494,
                        495,
                        496,
                        497,
                        498,
                    ],
                ],
            ],
            'VideoDescription' => [
                'ScalingBehavior' => 'DEFAULT',
                'Height' => 720,
                'TimecodeInsertion' => 'DISABLED',
                'AntiAlias' => 'ENABLED',
                'Sharpness' => 50,
                'CodecSettings' => [
                    'Codec' => 'H_264',
                    'H264Settings' => [
                        'InterlaceMode' => 'PROGRESSIVE',
                        'NumberReferenceFrames' => 3,
                        'Syntax' => 'DEFAULT',
                        'GopClosedCadence' => 1,
                        'GopSize' => 90,
                        'Slices' => 1,
                        'GopBReference' => 'DISABLED',
                        'MaxBitrate' => 8000000,
                        'SpatialAdaptiveQuantization' => 'ENABLED',
                        'TemporalAdaptiveQuantization' => 'ENABLED',
                        'FlickerAdaptiveQuantization' => 'DISABLED',
                        'EntropyEncoding' => 'CABAC',
                        'RateControlMode' => 'QVBR',
                        'QvbrSettings' => [
                            'QvbrQualityLevel' => 7,
                            'QvbrQualityLevelFineTune' => 0,
                        ],
                        'CodecProfile' => 'MAIN',
                        'MinIInterval' => 0,
                        'AdaptiveQuantization' => 'HIGH',
                        'CodecLevel' => 'AUTO',
                        'FieldEncoding' => 'PAFF',
                        'SceneChangeDetect' => 'ENABLED',
                        'QualityTuningLevel' => 'SINGLE_PASS',
                        'UnregisteredSeiTimecode' => 'DISABLED',
                        'GopSizeUnits' => 'FRAMES',
                        'NumberBFramesBetweenReferenceFrames' => 2,
                        'RepeatPps' => 'DISABLED',
                    ],
                ],
                'AfdSignaling' => 'NONE',
                'DropFrameTimecode' => 'ENABLED',
                'RespondToAfd' => 'NONE',
                'ColorMetadata' => 'INSERT',
            ],
            'AudioDescriptions' => [
                [
                    'AudioTypeControl' => 'FOLLOW_INPUT',
                    'AudioSourceName' => 'Audio Selector 1',
                    'CodecSettings' => [
                        'Codec' => 'AAC',
                        'AacSettings' => [
                            'AudioDescriptionBroadcasterMix' => 'NORMAL',
                            'Bitrate' => 96000,
                            'RateControlMode' => 'CBR',
                            'CodecProfile' => 'LC',
                            'CodingMode' => 'CODING_MODE_2_0',
                            'RawFormat' => 'NONE',
                            'SampleRate' => 48000,
                            'Specification' => 'MPEG4',
                        ],
                    ],
                    'LanguageCodeControl' => 'FOLLOW_INPUT',
                ],
            ],
            'NameModifier' => $NameModifier,
        ];
    }
}
