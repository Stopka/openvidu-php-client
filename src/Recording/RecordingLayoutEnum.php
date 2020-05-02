<?php

declare(strict_types=1);

namespace Stopka\OpenviduPhpClient\Recording;

use Stopka\OpenviduPhpClient\Enum\EnumTrait;

class RecordingLayoutEnum
{
    use EnumTrait;

    /**
     * All the videos are evenly distributed, taking up as much space as possible
     */
    public const BEST_FIT = 'BEST_FIT';

    /**
     * <i>(not available yet)</i>
     */
    public const PICTURE_IN_PICTURE = 'PICTURE_IN_PICTURE';

    /**
     * <i>(not available yet)</i>
     */
    public const VERTICAL_PRESENTATION = 'VERTICAL_PRESENTATION';

    /**
     * <i>(not available yet)</i>
     */
    public const HORIZONTAL_PRESENTATION = 'HORIZONTAL_PRESENTATION';

    /**
     * <i>(not available yet)</i>
     */
    public const CUSTOM = 'CUSTOM';

    /**
     * @return string[]
     */
    public function getValues(): array
    {
        return [
            self::BEST_FIT,
            self::PICTURE_IN_PICTURE,
            self::VERTICAL_PRESENTATION,
            self::HORIZONTAL_PRESENTATION,
            self::CUSTOM,
        ];
    }
}
