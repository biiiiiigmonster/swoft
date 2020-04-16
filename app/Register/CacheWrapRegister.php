<?php


namespace App\Register;


use Swoft\Log\Helper\CLog;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

/**
 * Class CacheWrapRegister
 * @package App\Annotation\Register
 * @since 2.0
 */
class CacheWrapRegister
{
    /**
     * @var array
     */
    private static $data = [];

    /**
     * 注册
     * @param array $data
     * @param string $className
     * @param string $method
     */
    public static function register(array $data,string $className,string $method): void
    {
        self::$data[$className][$method] = $data;
    }

    /**
     * @param string $className
     * @param string $method
     * @return array
     */
    public static function get(string $className, string $method): array
    {
        return self::$data[$className][$method] ?? [];
    }

    /**
     * @param array $arguments
     * @param string $value
     * @return string
     */
    public static function formatKey(array $arguments, string $value): string
    {
        // Parse express language
        $el = new ExpressionLanguage();
        CLog::info('转换：'.json_encode($arguments));
        return $el->evaluate($value, $arguments);
    }
}
