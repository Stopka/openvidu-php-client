<?php
/**
 * Created by IntelliJ IDEA.
 * User: stopka
 * Date: 13.10.17
 * Time: 14:02
 */

namespace Stopka\OpenviduPhpClient\Recording;


use Stopka\OpenviduPhpClient\Enum;

class RecordingLayoutEnum
{
    use Enum;

    /**
     * All the videos are evenly distributed, taking up as much space as possible
     */
    const BEST_FIT = "BEST_FIT";

    /**
     * <i>(not available yet)</i>
     */
    const PICTURE_IN_PICTURE = "PICTURE_IN_PICTURE";

    /**
     * <i>(not available yet)</i>
     */
    const VERTICAL_PRESENTATION = "VERTICAL_PRESENTATION";

    /**
     * <i>(not available yet)</i>
     */
    const HORIZONTAL_PRESENTATION = "HORIZONTAL_PRESENTATION";

    /**
     * <i>(not available yet)</i>
     */
    const CUSTOM = "CUSTOM";


    public function getValues(): array
    {
        return [
            self::BEST_FIT,
            self::PICTURE_IN_PICTURE,
            self::VERTICAL_PRESENTATION,
            self::HORIZONTAL_PRESENTATION,
            self::CUSTOM
        ];
    }
}
