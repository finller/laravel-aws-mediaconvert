<?php

namespace Finller\AwsMediaConvert\Support\Hls;

class DefaultHls480pMediaConvertOutput
{
    public static function make(
        string $NameModifier = '-$h$-$f$fps-$rv$kbps'
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
                    'Scte35Pid' => 500,
                    'TimedMetadataPid' => 502,
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
                'Height' => 360,
                'TimecodeInsertion' => 'DISABLED',
                'AntiAlias' => 'ENABLED',
                'Sharpness' => 50,
                'CodecSettings' => [
                    'Codec' => 'H_264',
                    'H264Settings' => [
                        'InterlaceMode' => 'PROGRESSIVE',
                        'ParNumerator' => 1,
                        'NumberReferenceFrames' => 3,
                        'Syntax' => 'DEFAULT',
                        'FramerateDenominator' => 1001,
                        'GopClosedCadence' => 1,
                        'HrdBufferInitialFillPercentage' => 90,
                        'GopSize' => 90,
                        'Slices' => 1,
                        'GopBReference' => 'DISABLED',
                        'HrdBufferSize' => 1800000,
                        'SlowPal' => 'DISABLED',
                        'ParDenominator' => 1,
                        'SpatialAdaptiveQuantization' => 'ENABLED',
                        'TemporalAdaptiveQuantization' => 'ENABLED',
                        'FlickerAdaptiveQuantization' => 'DISABLED',
                        'EntropyEncoding' => 'CABAC',
                        'Bitrate' => 1200000,
                        'FramerateControl' => 'SPECIFIED',
                        'RateControlMode' => 'CBR',
                        'CodecProfile' => 'MAIN',
                        'Telecine' => 'NONE',
                        'FramerateNumerator' => 30000,
                        'MinIInterval' => 0,
                        'AdaptiveQuantization' => 'HIGH',
                        'CodecLevel' => 'LEVEL_3_1',
                        'FieldEncoding' => 'PAFF',
                        'SceneChangeDetect' => 'ENABLED',
                        'QualityTuningLevel' => 'MULTI_PASS_HQ',
                        'FramerateConversionAlgorithm' => 'DUPLICATE_DROP',
                        'UnregisteredSeiTimecode' => 'DISABLED',
                        'GopSizeUnits' => 'FRAMES',
                        'ParControl' => 'SPECIFIED',
                        'NumberBFramesBetweenReferenceFrames' => 3,
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
                    'CodecSettings' => [
                        'Codec' => 'AAC',
                        'AacSettings' => [
                            'AudioDescriptionBroadcasterMix' => 'NORMAL',
                            'Bitrate' => 96000,
                            'RateControlMode' => 'CBR',
                            'CodecProfile' => 'HEV1',
                            'CodingMode' => 'CODING_MODE_2_0',
                            'RawFormat' => 'NONE',
                            'SampleRate' => 48000,
                            'Specification' => 'MPEG4',
                        ],
                    ],
                    'LanguageCodeControl' => 'FOLLOW_INPUT',
                    'AudioType' => 0,
                ],
            ],
            'NameModifier' => $NameModifier,
        ];
    }
}
