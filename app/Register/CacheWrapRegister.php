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
     * @param string $key
     * @param array $args
     * @return string
     */
    public static function formatKey(string $key, array $args): string
    {
        // Parse express language
        $el = new ExpressionLanguage();
        $values = array_merge($args,[
            'request' => context()->getRequest(),//表达式支持请求对象
        ]);
        return $el->evaluate($key, $values);
    }
}
