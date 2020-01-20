<?php


namespace App\Annotation\Register;


use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

class CacheWrapRegister
{
    /**
     * @var array
     */
    private static $data = [];

    /**
     * 注册
     * @param string $className
     * @param string $methodName
     * @param array $data
     */
    public static function register(string $className, string $methodName,array $data): void
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
    public static function formatedKey(array $arguments, string $value): string
    {
        // Parse express language
        $el = new ExpressionLanguage();
        return $el->evaluate($value, ['arg' => $arguments]);
    }
}
