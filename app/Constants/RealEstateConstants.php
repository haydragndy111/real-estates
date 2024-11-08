<?php
namespace App\Constants;

class RealEstateConstants
{
    public const TYPE_TOWNHOUSE = 0;
    public const TYPE_APARTMENT = 1;
    public const TYPE_HOTEL_ROOMS = 2;
    public const TYPE_VILLA = 3;
    public const TYPE_RESIDENTIAL_PLOT = 4;
    public const TYPE_COMMERCIAL_PLOT = 5;

    public static function getTypes()
    {
        return [
            self::TYPE_TOWNHOUSE => 'TOWNHOUSE',
            self::TYPE_APARTMENT => 'APARTMENT',
            self::TYPE_HOTEL_ROOMS => 'HOTEL_ROOMS',
            self::TYPE_VILLA => 'VILLA',
            self::TYPE_RESIDENTIAL_PLOT => 'RESIDENTIAL_PLOT',
            self::TYPE_COMMERCIAL_PLOT => 'COMMERCIAL_PLOT',
        ];
    }

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
