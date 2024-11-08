<?php
namespace App\Constants;

class ImageConstants
{
    public const STATUS_ACTIVE = 0;
    public const STATUS_INACTIVE = 1;

    public static function getStatuses()
    {
        return [
            self::STATUS_ACTIVE => 'ACTIVE',
            self::STATUS_INACTIVE => 'INACTIVE',
        ];
    }

}
