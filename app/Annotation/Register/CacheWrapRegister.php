<?php


namespace App\Annotation\Register;


class CacheWrapRegister
{
    /**
     * @var array
     */
    private static $data = [];

    /**
     *
     * @param array $data
     * @param string $className
     * @param string $methodName
     */
    public static function register(array $data, string $className, string $methodName): void
    {
        self::$data[$className][$methodName] = $data;
    }
}
