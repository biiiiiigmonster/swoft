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
     * @param string $className
     * @param string $method
     * @param array $args
     * @return string
     */
    public static function evaluateKey(string $key, string $className, string $method, array $args): string
    {
        if($key==='') return '';
        // Parse express language
        $el = new ExpressionLanguage();
        $values = array_merge($args,[
            'request' => context()->getRequest(),//表达式支持请求对象
            'CLASS' => $className,
            'METHOD' => $method,
        ]);
        return (string)$el->evaluate($key, $values);
    }
}
