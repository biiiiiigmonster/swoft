<?php declare(strict_types=1);


namespace App\Register;


use App\Annotation\Mapping\Throttle;
use Swoft\Log\Helper\CLog;
use Swoft\Stdlib\Helper\ArrayHelper;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

/**
 * Class ThrottleRegister
 * @package App\Register
 */
class ThrottleRegister
{
    /**
     * @var array
     */
    private static $throttle = [];

    /**
     * @param string $className
     * @param string $method
     * @param Throttle $throttle
     */
    public static function register(string $className,string $method,Throttle $throttle): void
    {
        [$maxAccepts,$duration] = explode('/',$throttle->getFrequency(),2);
        $value = substr($duration,0,-1);
        $unit = substr($duration,-1);
        $ttl = $value * ArrayHelper::get(['s'=>1,'m'=>60,'h'=>60*60,'d'=>60*60*24],$unit,1);
        CLog::info($value,$unit,$ttl);
        $throttleConfig = [$throttle->getPrefix(),$throttle->getKey(),$maxAccepts,$ttl];
        self::$throttle[$className][$method] = $throttleConfig;
    }

    /**
     * @param string $className
     * @param string $method
     * @return array
     */
    public static function get(string $className,string $method): array
    {
        return self::$throttle[$className][$method] ?? [];
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
        // Parse express language
        $el = new ExpressionLanguage();
        $values = array_merge($args,[
            'request' => context()->getRequest(),//表达式支持请求对象
            'CLASS' => $className,
            'METHOD' => $method,
        ]);
        return $el->evaluate($key, $values);
    }
}
