<?php

namespace RadishesFlight\ExpressAge;

class ExpressAgeFactory
{
    public const TYPE_EMS = 'ems';
    public const TYPE_STO = 'sto';

    public static function create(string $type, array $config): ExpressAgeInterFace
    {
        switch ($type) {
            case self::TYPE_EMS:
                return new Ems(
                    $config['host'],
                    $config['sender_no'],
                    $config['authorization'],
                    $config['key']
                );
            
            case self::TYPE_STO:
                return new StoExpress(
                    $config['host'],
                    $config['from_app_key'],
                    $config['from_code'],
                    $config['secret']
                );
            
            default:
                throw new \InvalidArgumentException("Unsupported express type: {$type}");
        }
    }
}
