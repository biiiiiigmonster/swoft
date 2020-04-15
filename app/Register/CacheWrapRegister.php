<?php


namespace App\Register;


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
     * @param string $methodName
     */
    public static function register(array $data,string $className, string $methodName): void
    {
        self::$data[$className][$methodName] = $data;
    }

    /**
     * @param string $className
     * @param string $methodName
     * @return array
     */
    public static function get(string $className, string $methodName): array
    {
        return self::$data[$className][$methodName] ?? [];
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
        return $el->evaluate($value, ['arg' => $arguments]);
    }
}
